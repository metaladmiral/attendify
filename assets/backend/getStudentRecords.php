<?php

session_start();
require_once 'conn.php';

$conn = new Db;


if(isset($_POST['autoExcel'])) {
    $sql = $conn->mconnect()->prepare("SELECT studid, name, classroll, uniroll FROM `students` WHERE `batchid`='".$_POST['batchid']."' AND `sectionid`='".$_POST['sectionid']."' ");
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data, JSON_FORCE_OBJECT);
}
else {
    $offset = $_POST['offset'];
    if($_POST['sectionid']!='null') {
        $sql = $conn->mconnect()->prepare("SELECT studid, uniroll, classroll, name, marks, totalattendance FROM `students` WHERE `batchid`='".$_POST['batchid']."' AND `sectionid`='".$_POST['sectionid']."' ");
    }
    else {
        $sql = $conn->mconnect()->prepare("SELECT studid, uniroll, classroll, name, marks, totalattendance FROM `students` WHERE `batchid`='".$_POST['batchid']."' ");
    }
    
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($data, JSON_FORCE_OBJECT);
}


?>