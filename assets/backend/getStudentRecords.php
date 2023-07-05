<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$offset = $_POST['offset'];

$sql = $conn->mconnect()->prepare("SELECT studid, name, marks, totalattendance FROM `students` WHERE `batchid`='".$_POST['batchid']."' AND `sectionid`='".$_POST['sectionid']."' ");
$sql->execute();
$data = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data, JSON_FORCE_OBJECT);

?>