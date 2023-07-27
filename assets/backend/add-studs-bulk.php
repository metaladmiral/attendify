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
    $batchid = $data['batchid'];
    
    try {
        /**  Verify that $inputFileName really is an Xls file **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename, [\PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS]);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($filename);
        $rows = $spreadsheet->getActiveSheet()->toArray();
        
        $sql = "INSERT INTO `students`(studid, batchid, sectionid, name, semester, bloodgrp, dob, dep, college, classroll, uniroll, studemail, parentemail, fname, mname, category, mno, mano, wno, permaddr, localaddr, state, district, hosteldetails, parentsworkdetails, loandetails, unhealthyhabits, marksinschool, aimofedu, personaltraits, natureofstudent, initcommskill, totalattendance) VALUES ";

        $docs = array("-","-","-","-","-","-","-", "-");
        $docs = json_encode($docs, JSON_FORCE_OBJECT);

        $queryData = array();
        foreach ($rows as $key => $value) {
           if($key=="0") {
            continue;
           }
            $batchid = $value[0];
            $section = explode('-', $value[1]);
            $sectionid = ord($section[0])."-".$section[1];

            $name = $value[2]." ".$value[3];
            $sem = $value[4];
            $bloodgrp = $value[5];
            $dob = $value[6];
            $dep = $value[7];
            $classroll = $value[8];
            $uniroll = $value[9];
            $email = $value[10];
            $paremail = $value[11];
            $fname = $value[12];
            $mname = $value[13];
            $category = $value[14];
            $mobile = $value[15];
            $mano = $value[16];
            $wano = $value[17];
            $permaddr = $value[18];
            $localaddr = $value[19];

            $state = $value[20];
            $district = $value[21];
            

            $hosteldetails = json_encode(array("hosteler"=>$value[22], "roomno"=>$value[23], "hostelname"=>$value[24]));
            
            $parentdetails = json_encode(array("parentoccupation"=>$value[25], "parannualincome"=>$value[26]));
            
            $loandetails = json_encode(array("loanstatus"=>$value[27], "loanamount"=>$value[28]));

            $unhealthyhabits = $value[29];
            $marksinschool = json_encode(array($value[30],$value[31]));

            $aimofedu = $value[32];
            $traits = $value[33];
            
            $natureofstud = json_encode(array($value[34], $value[35], $value[36]));
            $commskills = $value[37];

            $studid = substr($batchid, 0, 2).substr(strtolower($name), 0, 3).uniqid();
            
            array_push($queryData, array($studid,$batchid, $sectionid, $name, $sem, $bloodgrp, $dob, $dep, "1", $classroll, $uniroll, $email, $paremail, $fname, $mname, $category, $mobile,$mano, $wano,$permaddr,$localaddr, $state,$district,$hosteldetails,$parentdetails,$loandetails,$unhealthyhabits,$marksinschool, $aimofedu,$traits,$natureofstud,$commskills, ""));

        }

        $str = array();
        foreach($queryData as $key=>$value) {
            array_push($str, "('".implode("','", $value)."')");
        }

        // var_dump($rows);
        // var_dump($queryData);
        $queryData_ = implode(',', $str);
        $sql .= $queryData_;

        echo $sql;
        try {

            // $query = $db->mconnect()->prepare($sql);
            // $query->execute();
            sleep(3);
            echo "1";
        }catch(PDOException $e) {
            echo $e->getMessage();
        }

    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        // File isn't actually an Xls file, even though it has an xls extension 
        echo json_encode(array("StatusCode"=>0, "msg"=>"File uploaded is not a XLS.", "msg2"=>$e->getMessage()));
    }
    finally{ 
        unlink($filename);
    }

}