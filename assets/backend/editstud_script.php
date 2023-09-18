<?php
session_start();
require_once 'conn.php';

// var_dump($_POST);
$conn = new Db;

// die();

$studid = $_POST['studid'];

$hosteldetails = json_encode(array(
    "hosteler"=> $_POST['hosteler'],
    "roomno"=> $_POST['roomno'],
    "hostelname"=> $_POST['hostelname']
));

$parentworkdetails = json_encode(array(
    "parentoccupation" => $_POST['parentoccupation'],
    "parannualincome" => $_POST['parannualincome']
));
$loandetails = json_encode(array(
    "loanstatus" => $_POST['loanstatus'],
    "loanamount" => $_POST['loanamount']
));
$marksinschool = json_encode(array($_POST['10thmarks'], $_POST['12thmarks']));
$natureofstud = json_encode(array_values($_POST['natureofstud']));


try {
    $sql = "UPDATE `students` SET `sectionid`='".$_POST['section']."', `name`='".$_POST['name']."', `semester`='".$_POST['sem']."', `bloodgrp`='".$_POST['bldgrp']."', `dob`='".$_POST['dob']."', `dep`='".$_POST['depname']."', `classroll`='".$_POST['classroll']."', `uniroll`='".$_POST['uniroll']."', `studemail`='".$_POST['studemail']."', `parentemail`='".$_POST['pemail']."', `fname`='".$_POST['fname']."', `mname`='".$_POST['mname']."', `category`='".$_POST['category']."', `mno`='".$_POST['mno']."', `mano`='".$_POST['mano']."', `wno`='".$_POST['wno']."', `permaddr`='".$_POST['permaddr']."', `localaddr`='".$_POST['localaddr']."', `state`='".$_POST['state']."', `district`='".$_POST['district']."', `hosteldetails`='$hosteldetails', `parentsworkdetails`='$parentworkdetails', `loandetails`='$loandetails', `unhealthyhabits`='".$_POST['unhealthyhabits']."', `marksinschool`='$marksinschool', `aimofedu`='".$_POST['aimoe']."', `personaltraits`='".$_POST['personaltraits']."', `natureofstudent`='$natureofstud', `initcommskill`='".$_POST['initcommskill']."' WHERE `studid`='$studid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    echo 1;
    $_SESSION['message'] = "1";
    header('Location: '.$_SERVER['HTTP_REFERER']);
    
}catch(PDOException $e) {
    echo $e->getMessage();
    // $_SESSION['message'] = "2";
    // header('Location: '.$_SERVER['HTTP_REFERER']);
}
