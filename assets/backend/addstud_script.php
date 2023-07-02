<?php
session_start();
require_once 'conn.php';

// var_dump($_POST);
$conn = new Db;

$studid = substr($_POST['batch'], 0, 3).substr($_POST['counsellor'], 0, 3).uniqid();

$sql = "INSERT INTO `students`(studid, batchid, counsid, rollstatus, rollnos, regstatus, name, contact, alternateno, wano, dor, email, fname, mname,dob, aadharno, state, district, totalfee, totalleft, docs) VALUES (?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?, ?,?,?)";
$query = $conn->mconnect()->prepare($sql);

if(empty($_POST['classroll'])) {
    $_POST['classroll'] = "-";
} 
if(empty($_POST['uniroll'])) {
    $_POST['uniroll'] = "-";
} 
$rollnos = array("uniroll"=>$_POST['uniroll'],"classroll"=>$_POST['classroll']);
$rollnos = json_encode($rollnos, JSON_FORCE_OBJECT);

// $firstname = preg_replace('/\s+/', '', $_POST['firstname']);
// $lastname = preg_replace('/\s+/', '', $_POST['lastname']);
$name = $_POST['fullname'];
// $name = $firstname." ".$lastname;

$mno = "+".$_POST['mcc']." ".$_POST['mno'];
$amno = "+".$_POST['macc']." ".$_POST['mano'];
$wano = "+".$_POST['wacc']." ".$_POST['wano'];

$cPhonequery = "SELECT count(*) as c FROM `students` WHERE `contact`='$mno' ";
$cPhonequery = $conn->mconnect()->prepare($cPhonequery);
$cPhonequery->execute();
if($cPhonequery->fetch(PDO::FETCH_ASSOC)['c']>0) {
    
    if(!isset($_POST['custom'])) {
        $_SESSION['message'] = "phoneErr";
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else {
        die("phoneErr");
    }
}

$docs = array("-","-","-","-","-","-","-", "-");
$docs = json_encode($docs, JSON_FORCE_OBJECT);

$query->execute(array( $studid,$_POST['batch'],$_POST['counsellor'],$_POST['rollnostatus'],$rollnos,$_POST['regstatus'],$name,$mno,$amno,$wano,$_POST['admdate'],$_POST['email'],$_POST['fname'],$_POST['mname'],$_POST['dob'],$_POST['aadharno'],$_POST['state'],$_POST['district'],$_POST['feecomm'],$_POST['feecomm'], $docs));

$sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
$query = $conn->mconnect()->prepare($sql);
$mess = "has added a student with ID - ".$studid;
$time = strtotime("now");
$query->execute([$mess, $time, $_SESSION['uid']]);

if(!isset($_POST['custom'])) {
    $_SESSION['message'] = "1";
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
else {
    echo base64_encode(json_encode(array("studid"=>$studid, "totalfee"=>$_POST['feecomm'], "fullname"=>$name), JSON_FORCE_OBJECT));
}
