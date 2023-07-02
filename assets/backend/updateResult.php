<?php
session_start();
require_once 'conn.php';

// var_dump($_POST);
$conn = new Db;

$studid = $_POST['studid'];
$res = $_POST['res'];

try {
    $sql = "UPDATE `students` SET `resultStat`=? WHERE `studid`='$studid' ";
    $query = $conn->mconnect()->prepare($sql);

    $query->execute([$res]);

    $sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
    $query = $conn->mconnect()->prepare($sql);
    $mess = " has edited result of student with ID - ".$studid;
    $time = strtotime("now");
    $query->execute([$mess, $time, $_SESSION['uid']]);

    echo "1";
    
}catch(PDOException $e) {
    echo "2";
}
