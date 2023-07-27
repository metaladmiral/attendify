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
        
        $sql = "INSERT INTO `users`(uid, email, username, password, usertype, active) VALUES ";

        $queryData = array();
        foreach ($rows as $key => $value) {
           if($key=="0") {
            continue;
           }

           $email = $value[0];
           $username = $value[1];
           $usertype = "2";
           $active = "1";
           if(empty($email) || empty($username)) {
            continue;
           }

           $validatedName = preg_replace('/\s+/', '', $username);
           $password = md5("cgcfaculty@123");
           $uid = substr(strtolower($validatedName), 0, 3).uniqid();
            
            array_push($queryData, array($uid, $email, $username, $password, $usertype, $active));

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
            echo "1";
        }catch(PDOException $e) {
            echo $e->getMessage();
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