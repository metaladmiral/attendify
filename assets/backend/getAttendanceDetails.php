<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$offset = $_POST['offset'];
$batchid = $_POST['batchid'];
$sectionid = $_POST['sectionid'];

$sql = $conn->mconnect()->prepare("SELECT studid, uniroll, classroll, name FROM `students` WHERE `batchid`='".$batchid."' AND `sectionid`='$sectionid'  ");

$sql->execute();
$studentDetails = $sql->fetchAll(PDO::FETCH_ASSOC);

// echo json_encode($data, JSON_FORCE_OBJECT);


try {
$sql = $conn->mconnect()->prepare("SELECT * FROM `att_$batchid` WHERE `sectionid`='$sectionid' AND `subjectid`='".$_POST['subjectid']."' ");
$sql->execute();
$attendanceData = $sql->fetchAll(PDO::FETCH_ASSOC);

$dates = array();
foreach ($attendanceData as $key => $value) {   
    $dates[$value["date"]] = $value['absentStudents'];
}

$stickedData = array("students"=>$studentDetails, "dates"=>$dates);

echo json_encode($stickedData);

}
catch(PDOException $e) {
    echo json_encode(array("dates"=>array(), "students"=>array()));
}
?>