<?php

session_start();
require_once 'conn.php';
$conn = new Db;

$studid = $_POST['studid'];
$t = $_POST['t'];
$m = $_POST['m'];

if($m!="1") {

$ext = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
$randname = substr($studid, 0, 4).uniqid().".".$ext;

if(move_uploaded_file($_FILES["file"]["tmp_name"], "C:/xampp/htdocs/lgs/erp/accdocs/$randname")) {

}
else {
    echo json_encode(array("status"=>"0"));
    die();
}

$sql = " SELECT docs FROM `students` WHERE `studid`='$studid' ";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$docs = $query->fetch(PDO::FETCH_ASSOC)['docs'];
$docs = json_decode($docs, true);

$docs[$t] = $randname;
$docs = json_encode($docs, JSON_FORCE_OBJECT);

$sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
$query = $conn->mconnect()->prepare($sql);
$mess = "has added a document for Student ID - ".$studid;
$time = strtotime("now");
$query->execute([$mess, $time, $_SESSION['uid']]);

try {
    $sql = " UPDATE `students` SET `docs`='$docs' WHERE `studid`='$studid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();   
    echo json_encode(array("name"=>$randname, "status"=>"1"));
}
catch(PDOException $e) {
    echo json_encode(array("status"=>"0"));
}


}
else {
    // $totalfiles = count($_FILES);
    $sql = " SELECT docs FROM `students` WHERE `studid`='$studid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    $docs = $query->fetch(PDO::FETCH_ASSOC)['docs'];
    $docs = json_decode($docs, true);

    $totdoc = count($docs);
    $p = $totdoc;

    foreach ($_FILES as $key => $value) {
        $ext = strtolower(pathinfo($value["name"],PATHINFO_EXTENSION));
        $randname = substr($studid, 0, 4).uniqid().".".$ext;
        
        $docs[$p] = $randname;
        $p++;
        
        if(move_uploaded_file($value["tmp_name"], "C:/xampp/htdocs/lgs/erp/accdocs/$randname")) {
            
        }
        else {
            echo json_encode(array("status"=>"0"));
            die();
        }
    }
    // echo count($docs);
    $docs = json_encode($docs, JSON_FORCE_OBJECT);
    
    $sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
    $query = $conn->mconnect()->prepare($sql);
    $mess = "has added multiple documents for Student ID - ".$studid;
    $time = strtotime("now");
    $query->execute([$mess, $time, $_SESSION['uid']]);

    try {
        $sql = " UPDATE `students` SET `docs`='$docs' WHERE `studid`='$studid' ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute();   
        echo json_encode(array("name"=>$randname, "status"=>"1"));
    }
    catch(PDOException $e) {
        echo json_encode(array("status"=>"0"));
    }


}