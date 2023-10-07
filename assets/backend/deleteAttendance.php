<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$batchid = $_GET['batchid'];
$subjectid = $_GET['subjectid'];
$section = $_GET['section'];

try {
    $sql = "DELETE FROM `att_$batchid` WHERE `sectionid`='$section' AND `subjectid`='$subjectid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    $_SESSION['delSucc'] = "1";
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
catch(PDOException $e) {
    $_SESSION['delSucc'] = "0";
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
