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
    
    try {
        /**  Verify that $inputFileName really is an Xls file **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename, [\PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS]);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($filename);
        $rows = $spreadsheet->getActiveSheet()->toArray();
        
        
        $sql = "INSERT INTO `users`(uid, email, username, password, usertype, active,collegeid, depid, number, dob, ptuid, pemail, joinedon, gender, empid) VALUES ";
        $queryData = array();
        foreach ($rows as $key => $value) {
           if($key=="0") {
            continue;
           }
           $empid = $value[0];
           $username = $value[1];
           $email = $value[2];
           $password = md5($value[3]);
           $collegeid = $value[4];
           $depid = $value[5];
           $number = $value[6];
           $dob = $value[7];
           $dob = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($dob);
           $ptuid = $value[8];
           $emailpersonal = $value[9];
           $joinedon = $value[10];
           $gender = $value[11];
           $usertype = $value[12];

           $active = "1";
           if(empty($email) || empty($username) || empty($empid) || empty($password) || empty($collegeid) || empty($depid) || empty($number) || empty($usertype) ) {
            continue;
           }
           if($usertype=="1") {
            continue;
           }
           
           $collegeids = array();
           $depids = array();

           if(strpos($collegeid, ",")!==false) {
            $collegeid = str_replace('/\s+/', '', $collegeid);
            $collegeidsArr = explode(",", $collegeid);
            foreach ($collegeidsArr as $key => $value) {
                if(!trim($value)) {
                    continue;
                }
                array_push($collegeids, str_replace('/\s+/', '', $value));
            }
           }
           else {
               array_push($collegeids, $collegeid);
           }

           if(strpos($depid, ",")!==false) {
            $depid = str_replace('/\s+/', '', $depid);
            $depidsArr = explode(",", $depid);
            foreach ($depidsArr as $key => $value) {
                if(!trim($value)) {
                    continue;
                }
                array_push($depids, str_replace('/\s+/', '', $value));
            }
           }
           else {
               array_push($depids, $depid);
           }

           $collegeids = json_encode($collegeids);
           $depids = json_encode($depids);

           $validatedName = preg_replace('/\s+/', '', $username);
           $uid = substr(strtolower($validatedName), 0, 3).uniqid();
            
            array_push($queryData, array($uid, $email, $username, $password, $usertype, $active, $collegeids, $depids, $number, $dob, $ptuid, $emailpersonal, $joinedon, $gender, $empid));

        }
        

        $str = array();
        foreach($queryData as $key=>$value) {
            array_push($str, "('".implode("','", $value)."')");
        }

        // var_dump($rows);
        // var_dump($queryData);
        $queryData_ = implode(',', $str);
        $sql .= $queryData_;

        // echo $sql;
        try {

            $query = $db->mconnect()->prepare($sql);
            $query->execute();
            sleep(3);
            // echo $sql;
            echo "1";
        }catch(PDOException $e) {
            // echo $e->getMessage();
        }

    }
    catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        // File isn't actually an Xls file, even though it has an xls extension 
        echo json_encode(array("StatusCode"=>0, "msg"=>"File uploaded is not a XLS.", "msg2"=>$e->getMessage()));
    }
    finally{ 
        unlink($filename);
    }

}