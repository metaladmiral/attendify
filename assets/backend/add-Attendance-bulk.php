<?php

require '../vendor/autoload.php';
include './conn.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
    $subjectLabel = $data['subjectLabel'];
    $batchLabel = $data['batchLabel'];

    try {
        /**  Verify that $inputFileName really is an Xls file **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename, [\PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS]);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(FALSE);
        $spreadsheet = $reader->load($filename);
        $worksheet = $spreadsheet->getActiveSheet();
        
        $absStuds = array();
        $studCount = 0;
        $dateCount = 0;

        $currentDate = "";
        $dateRepeat = 0;
        foreach ($worksheet->getColumnIterator() as $key=>$col) {
            if($key=='A' || $key=='C' || $key=="D") {
                continue;
            }
            if($key=='B') {
                $cellIterator = $col->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); 
                foreach ($cellIterator as $key=>$cell) {
                    if($key==1) { continue; }
                    $val = $cell->getValue();
                    if(!$val) { break; }
                    $studCount++;
                }
                continue;
            }
            $cellIterator = $col->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); 
            $currentIndex = 0;

            foreach ($cellIterator as $key=>$cell) {
                if($key==1) {
                    $date = $cell->getValue();
                    if(!$date) {
                        break;
                    }
                    if(\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell)) {
                        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                        $date = json_decode(json_encode($date), true);
                        $date= strtotime($date['date']);
                    }
                    else {
                        $date = $cell->getValue();
                        $date= strtotime($date);
                    }
                    
                    if($currentDate != $date) {
                        $absStuds[$date][0] = array();
                        $currentIndex = 0;
                        $currentDate = $date;
                        // $dateRepeat = false;
                    }
                    else {
                        $dateRepeat = 1;
                    }
                    $dateCount++;
                    
                    if($dateRepeat) {
                        $currentIndex = ((int) array_push($absStuds[$currentDate], array()))-1;
                        $dateRepeat = 0;
                    }

                    continue;
                }
                
                if($cell->getValue() == "A") { //absent Present
                    $currCoordinante = $cell->getCoordinate();
                    $studidCellCoordinate = preg_replace('/[A-Z]+/', 'B', $currCoordinante);
                    $studid = $worksheet->getCell($studidCellCoordinate)->getValue();

                    if(!is_null($studid) && $studid) {
                        array_push($absStuds[$currentDate][$currentIndex], $studid);
                    }else {
                        break;
                    }
                }
                // else {
                //     $currCoordinante = $cell->getCoordinate();
                //     $studidCellCoordinate = preg_replace('/[A-Z]+/', 'B', $currCoordinante);
                //     $studid = $worksheet->getCell($studidCellCoordinate)->getValue();

                //     if(is_null($studid) || !$studid) {
                //         break;
                //     }
                // }

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
            $absStudIds = "";
            foreach($value as $key_ => $value_) {
                if(count($value)==$key_+1) {
                    $absStudIds .= json_encode($value_);
                }
                else {
                    $absStudIds .= json_encode($value_)."-";
                }
            }
            // $absStudIds = json_encode($value);
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
        // echo json_encode($queryParam);
        echo json_encode(array("statusCode"=>1, "studCount"=>$studCount, "dateCount"=>$dateCount, "subjectLabel"=>$subjectLabel, "batchLabel"=>$batchLabel ));
        unlink($filename);
    }
    catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        // File isn't actually an Xls file, even though it has an xls extension 
        echo json_encode(array("statusCode"=>0, "msg"=>"File uploaded is not a XLS.", "msg2"=>$e->getMessage()));
    }

}