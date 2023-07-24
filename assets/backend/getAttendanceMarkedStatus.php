<?php

session_start();
require_once 'conn.php';
$conn = new Db;

$tableName = "att_".$_POST['batchid'];
$sectionId = $_POST['sectionid'];
$subjectId = $_POST['subjectid'];
// $sql = $conn->cconnect()->prepare("SELECT studid, name, marks, totalattendance FROM `students` WHERE `batchid`='".$_POST['batchid']."' AND `sectionid`='".$_POST['sectionid']."' ");

$nowDate = strtotime("today");
$dateDetails = array();

try {
    $sql = $conn->mconnect()->prepare("SELECT  date FROM $tableName WHERE `date`<='$nowDate' AND `sectionId`='$sectionId' AND `subjectId`='$subjectId' ORDER BY `date` DESC LIMIT 2 ");
    $sql->execute();

    $data = $sql->fetchAll(PDO::FETCH_COLUMN);
    
    $key = array_search($nowDate, $data);
    if(gettype($key)=='integer') {
        $dateDetails[date('Y-m-d', $data[$key])] = 1;
        if(count($data)>1) {
            $dateDetails[date('Y-m-d', $data[1])] = 1;
        }
    }
    else {
        $dateDetails[date('Y-m-d', $nowDate)] = 0;
        if(count($data)>0) {
            $dateDetails[date('Y-m-d', $data[0])] = 1;
        }   
    }
    
    $sql = $conn->mconnect()->prepare("SELECT absentStudents, date FROM $tableName WHERE `date`<='$nowDate' AND `sectionId`='$sectionId' AND `subjectId`='$subjectId' ORDER BY `date` DESC LIMIT 2 ");
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    $absentStudents = array();
    foreach ($data as $key => $value) {
        // $data[$key]["date"] = date("Y-m-d", $value["date"]);
        $absentStudents[date("Y-m-d", $value["date"])] = $value["absentStudents"];
    }


}
catch(PDOException $e) {
    $dateDetails[date('Y-m-d', $nowDate)] = "0";
    $absentStudents = null;
}

echo json_encode(array("dateDetails"=>$dateDetails, "absentStudentsDetails"=>$absentStudents));
// echo json_encode($dateDetails);