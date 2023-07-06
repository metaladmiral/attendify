<?php
session_start();
require_once 'conn.php';

// var_dump($_POST);
$conn = new Db;

$studid = substr($_POST['batch'], 0, 3).substr($_POST['firstname'], 0, 3).uniqid();

$firstname = preg_replace('/\s+/', '', $_POST['firstname']);
$lastname = preg_replace('/\s+/', '', $_POST['lastname']);
$name = $firstname." ".$lastname;

if(empty($_POST['classroll'])) {
    $_POST['classroll'] = "-";
} 
if(empty($_POST['uniroll'])) {
    $_POST['uniroll'] = "-";
} 
// $rollnos = array("uniroll"=>$_POST['uniroll'],"classroll"=>$_POST['classroll']);
// $rollnos = json_encode($rollnos, JSON_FORCE_OBJECT);

$mno = "+".$_POST['mcc']." ".$_POST['mno'];
$amno = "+".$_POST['macc']." ".$_POST['amno'];
$wano = "+".$_POST['wacc']." ".$_POST['wano'];

$hosteler = $_POST['hosteler'];
if($hosteler=="1") {
    $roomno = $_POST['roomno'];
    $hostelname = $_POST['hostelname'];
}else {
    $roomno = "-";
    $hostelname = "-";

}
$hostelDetails = array("hosteler"=>$hosteler, "roomno"=>$roomno, "hostelname"=>$hostelname);
$hostelDetails = json_encode($hostelDetails);

$parOccupation = $_POST['parocc'];
$parAnnualIncome = $_POST['parani'];
$parentWorkDetails = array("parentoccupation"=>$parOccupation, "parannualincome"=>$parAnnualIncome);
$parentWorkDetails = json_encode($parentWorkDetails);

$loanStatus = $_POST['loanstatus'];
$loanAmount = $_POST['loanamount'];
if($loanStatus=="No") { $loanAmount = "0"; }
$loanDetails = array("loanstatus"=>$loanStatus, "loanamount"=>$loanAmount);
$loanDetails = json_encode($loanDetails);

$marks10 = $_POST['mrks10'];
$marks12 = $_POST['mrks12'];
$marksinschool = json_encode(array($marks10, $marks12));

$natureofstudent = json_encode(array($_POST['nos1'], $_POST['nos2'], $_POST['nos3'] ));


$sql = "INSERT INTO `students`(studid, batchid, sectionid, name, semester, bloodgrp, dob, dep, college, classroll, uniroll, studemail, parentemail, fname, mname, category, mno, mano, wno, permaddr, localaddr, state, district, hosteldetails, parentsworkdetails, loandetails, unhealthyhabits, marksinschool, aimofedu, personaltraits, natureofstudent, initcommskill) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$query = $conn->mconnect()->prepare($sql);
$query->execute(array( $studid,$_POST['batch'],$_POST['section'],$name,"1",$_POST['bloodgrp'],$_POST['dob'],"1","1",$_POST['classroll'],$_POST['uniroll'],$_POST['studemail'],$_POST['paremail'],$_POST['fname'],$_POST['mname'],$_POST['category'],$mno,$amno,$wano,$_POST['permaddr'], $_POST['localaddr'], $_POST['state'], $_POST['district'], $hostelDetails, $parentWorkDetails, $loanDetails, $_POST['uhhabits'], $marksinschool, $_POST['aimoe'], $_POST['personaltraits'], $natureofstudent, $_POST['commskilladm'] ));

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
