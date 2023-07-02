<?php
session_start();
require_once 'conn.php';

// var_dump($_POST);
$conn = new Db;

$studid = $_POST['studid'];

// $sql = "INSERT INTO `students`(studid, batchid, counsid, rollstatus, rollnos, regstatus, name, contact, alternateno, wano, dor, email, fname, mname,dob, aadharno, state, district, address, totalfee, totalleft) VALUES (?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?, ?,?,?)";

$sql = "SELECT * FROM `students` WHERE `studid`='$studid' ";
$query_ = $conn->mconnect()->prepare($sql);
$query_->execute();
$data = $query_->fetch(PDO::FETCH_ASSOC);
$totalfeeP = (int) $data['totalfee'];
$totalleftP = (int) $data['totalleft'];

$totalPaidP = $totalfeeP - $totalleftP;

$totalleftN = ((int) $_POST['feecomm']) - $totalPaidP;

try {
    $sql = "UPDATE `students` SET `batchid`=?, `counsid`=?, `rollstatus`=?,`rollnos`=?,`regstatus`=?,`name`=?,`contact`=?,`alternateno`=?,`wano`=?,`dor`=?,`email`=?,`fname`=?,`mname`=?,`dob`=?,`aadharno`=?, `totalfee`=?, `totalleft`=? WHERE `studid`='$studid' ";
    $query = $conn->mconnect()->prepare($sql);

    if(empty($_POST['classroll'])) {
        $_POST['classroll'] = "-";
    } 
    if(empty($_POST['uniroll'])) {
        $_POST['uniroll'] = "-";
    } 
    $rollnos = array("uniroll"=>$_POST['uniroll'],"classroll"=>$_POST['classroll']);
    $rollnos = json_encode($rollnos, JSON_FORCE_OBJECT);

    $firstname = preg_replace('/\s+/', '', $_POST['firstname']);
    $lastname = preg_replace('/\s+/', '', $_POST['lastname']);
    $name = $firstname." ".$lastname;

    $mno = $_POST['mcc'].$_POST['mno'];
    $amno = $_POST['macc'].$_POST['mano'];
    $wano = $_POST['wacc'].$_POST['wano'];

    $query->execute(array( $_POST['batch'],$_POST['counsellor'],$_POST['rollnostatus'],$rollnos,$_POST['regstatus'],$name,$mno,$amno,$wano,$_POST['admdate'],$_POST['email'],$_POST['fname'],$_POST['mname'],$_POST['dob'],$_POST['aadharno'], $_POST['feecomm'], $totalleftN));

    $sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
    $query = $conn->mconnect()->prepare($sql);
    $mess = " has edited student with ID - ".$studid;
    $time = strtotime("now");
    $query->execute([$mess, $time, $_SESSION['uid']]);

    $_SESSION['message'] = "1";
    $_SESSION['data'] = base64_encode(json_encode(array("totalfee"=>$_POST['feecomm']), JSON_FORCE_OBJECT));
    header('Location: '.$_SERVER['HTTP_REFERER']);
    
}catch(PDOException $e) {
    $_SESSION['message'] = "2";
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
