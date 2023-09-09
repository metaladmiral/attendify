<?php

require '../vendor/autoload.php';
include './conn.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_FILES['file'])) {
    $fname = $_FILES['file']['tmp_name'];
    $tmpname = "tmp_".rand(9999, 999999).".xls";
    copy($fname, $tmpname);
    echo $tmpname;
}
else {
    $db = new db;
    $data = json_decode($_POST['data'], true);
    $filename = $data['xlname'];

    $batch = $data['batchid'];
    $section = $data['sectionid'];
    $subject = $data['subjectid'];

    try {
        /**  Verify that $inputFileName really is an Xls file **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename, [\PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS]);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($filename);
        $worksheet = $spreadsheet->getActiveSheet();
        
        $absStuds = array();

        foreach ($worksheet->getColumnIterator() as $key=>$col) {
            if($key=='A' || $key=='B' || $key=='C' || $key=="D") {
                continue;
            }
            $cellIterator = $col->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); 
            $currentDate = "";
            foreach ($cellIterator as $key=>$cell) {
                if($key==1) {
                    $date = $cell->getValue();
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                    $date = json_decode(json_encode($date), true);
                    $date= strtotime($date['date']);
                    $absStuds[$date] = array();
                    $currentDate = $date;
                    continue;
                }
                
                if($cell->getValue() == "A") { //absent Present
                    $studidCellCoordinate = preg_replace('/[A-Z]/', 'B', $cell->getCoordinate());
                    $studid = $worksheet->getCell($studidCellCoordinate)->getValue();
                    array_push($absStuds[$currentDate], $studid);
                }

            }
        }

        if(count($absStuds)==0) {
            echo json_encode(array("StatusCode"=>0, "msg"=>"Not Data in XL file."));
            die();
        }

        try {
            $sql = "SELECT id FROM `att_$batch` LIMIT 1";
            $query = $db->mconnect()->prepare($sql);
            $query->execute();
        }
        catch(PDOException $e) {
            $sql = "CREATE TABLE `att_$batch` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `sectionid` varchar(50) DEFAULT NULL,
                `subjectid` varchar(50) DEFAULT NULL,
                `date` varchar(50) DEFAULT NULL,
                `absentStudents` text DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_sectionid` (`sectionid`),
                KEY `idx_subjectid` (`subjectid`),
                FULLTEXT KEY `absentStudents` (`absentStudents`)
              ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4";
            $query = $db->mconnect()->prepare($sql);
            $query->execute();
        }

        $queryParam = "";
        foreach ($absStuds as $key => $value) {
            $date=$key;
            $absStudIds = json_encode($value);
            if($key == array_key_last($absStuds) ){
                $queryParam .= "('$section', '$subject', '$date', '$absStudIds')";
            }
            else {
                $queryParam .= "('$section', '$subject', '$date', '$absStudIds'),";
            }
        }
        
        $sql = "INSERT INTO `att_$batch`(sectionid, subjectid, date,absentStudents) VALUES $queryParam";
        $query = $db->mconnect()->prepare($sql);
        $query->execute();
        
        sleep(2);
        echo "1";
        unlink($filename);
    }
    catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        // File isn't actually an Xls file, even though it has an xls extension 
        echo json_encode(array("StatusCode"=>0, "msg"=>"File uploaded is not a XLS.", "msg2"=>$e->getMessage()));
    }

}