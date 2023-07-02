<?php

session_start();
require_once 'conn.php';
$conn = new Db;

// var_dump($_POST);
$studid = $_POST['studid'];

$sql = "SELECT dispatch FROM `students` WHERE `studid`='$studid' ";
$query_ = $conn->mconnect()->prepare($sql);
$query_->execute();
$data = $query_->fetch(PDO::FETCH_ASSOC);
$disO =  $data['dispatch'];

if(empty($disO) || is_null($disO)) {
    $disN = array();
}
else{
    $disN = json_decode($disO, true);
}
// $instjson = json_encode(array( "instid"=>$instid, "amount"=>$amount, "date"=>$_POST['date'], "details"=>$details, "file"=>$file ) ,JSON_FORCE_OBJECT);

array_push($disN, array( "distype"=>$_POST['distype'], "date"=>$_POST['date'], "trackid"=>$_POST['trackid'], "remarks"=>$_POST['remarks'] ));
$count = count($disN);
$disNjson = json_encode($disN, JSON_FORCE_OBJECT);


$sql = "UPDATE `students` SET `dispatch`=? WHERE `studid`='$studid' ";
$query_ = $conn->mconnect()->prepare($sql);
$query_->execute([$disNjson]);

$outArr = array( "count"=>$count, "distype"=>$_POST['distype'], "date"=>$_POST['date'], "trackid"=>$_POST['trackid'], "remarks"=>$_POST['remarks'] );
echo base64_encode(json_encode($outArr, JSON_FORCE_OBJECT));

$sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
$query = $conn->mconnect()->prepare($sql);
$mess = "has added an dispatch for Student ID - ".$studid." (Track ID - ".$_POST["trackid"].")";
$time = strtotime("now");
$query->execute([$mess, $time, $_SESSION['uid']]);