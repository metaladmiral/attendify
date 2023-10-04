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
    $subject = $data['subjectid'];
    $forType = $data["forType"];


    try {
        /**  Verify that $inputFileName really is an Xls file **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename, [\PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS]);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($filename);
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getColumnIterator() as $key=>$col) {
            if($key=='A' || $key=='B' || $key=='C' || $key=="D" || $key=="E") {
                continue;
            }
            $cellIterator = $col->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); 
            $currentDate = "";

            $sql = "UPDATE `students` SET `marks`=? WHERE `studid`=?";
            $pdoWTransaction = $db->mconnect();
            $updateQuery = $pdoWTransaction->prepare($sql);
            try {
                $pdoWTransaction->beginTransaction();
                foreach ($cellIterator as $key=>$cell) {
                               
                    $studidCellCoordinate = preg_replace('/[A-Z]/', 'B', $cell->getCoordinate());
                    $studid = $worksheet->getCell($studidCellCoordinate)->getValue();
    
                    $sql = "SELECT marks FROM `students` WHERE `studid`='$studid'";
                    $query = $db->mconnect()->prepare($sql);
                    $query->execute();
                    $marks = $query->fetch(PDO::FETCH_COLUMN);
    
                    if(!$marks) {
                        $marks = '{}';
                    }
    
                    $marks = json_decode($marks, true);
                    if(!isset($marks[$subject])) {
                        $marks[$subject] = array("mst1"=>"", "mst2"=>"", "assgn1"=>"", "assgn2"=>"");
                    }
    
                    $marks[$subject][$forType] = $cell->getValue();
                    $newMarks = json_encode($marks);
    
                    
                    $updateQuery->execute([$newMarks, $studid]);
    
                }
                $pdoWTransaction->commit();
            }
            catch(PDOException $e) {
                $db->mconnect()->rollback();
                // $_SESSION['err'] = $e->getMessage();
                echo "0";
                unlink($filename);
                die();
            }
            
        }
        
        sleep(2);
        echo "1";
        unlink($filename);
    }
    catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        // File isn't actually an Xls file, even though it has an xls extension 
        echo json_encode(array("StatusCode"=>0, "msg"=>"File uploaded is not a XLS.", "msg2"=>$e->getMessage()));
    }

}