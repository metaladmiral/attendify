<?php

session_start();
require_once 'conn.php';
$conn = new Db;

$tableName = "att_".$_POST['batchid'];
$sectionId = $_POST['sectionid'];
$subjectId = $_POST['subjectid'];
$date = strtotime($_POST['date']);
$absentStudents = base64_decode($_POST['absentStudents']);

try {
    $sql = $conn->mconnect()->prepare("SELECT date FROM $tableName");
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_COLUMN);
}
catch(PDOException $e) {
    if(strpos($e->getMessage(), "view not found") !== false) {
        $sql = $conn->mconnect()->prepare("CREATE TABLE `$tableName` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sectionid VARCHAR(50),
            subjectid VARCHAR(50),
            date VARCHAR(50),
            absentStudents TEXT,
            INDEX idx_sectionid (sectionid),
            INDEX idx_subjectid (subjectid),
            FULLTEXT absentStudents (absentStudents)
        )");
        $sql->execute();
    }
}
    
    $sql = $conn->mconnect()->prepare("SELECT count(*) as c FROM `$tableName` WHERE `date`='$date' AND `sectionid`='$sectionId' AND `subjectid`='$subjectId' ");
    $sql->execute();
    $count = $sql->fetch(PDO::FETCH_COLUMN);

    $abs = array();
    $absentStudents = json_decode($absentStudents, true);
    foreach ($absentStudents as $key => $value) {
        array_push($abs, json_encode($value));
    }
    echo $absentStudents = implode("-", $abs);

    if($count) {
        try {
            $sql = $conn->mconnect()->prepare("UPDATE `$tableName` SET absentStudents=? WHERE `date`='$date' AND `sectionid`='$sectionId' AND `subjectid`='$subjectId' ");
            $sql->execute([$absentStudents]);
            $_SESSION["succ"] = "1";
            header('Location: ../../erp/mark-attendance.php');
        } catch (PDOException $e) {
            $_SESSION["succ"] = "0";
            header('Location: ../../erp/mark-attendance.php');
        }
    }
    else {
        try {
            $sql = $conn->mconnect()->prepare("INSERT INTO `$tableName`(sectionid, subjectid, date, absentStudents) VALUES(?, ?, ?, ?) ");
            $sql->execute([$sectionId, $subjectId, $date, $absentStudents]);
            $_SESSION["succ"] = "1";
            header('Location: ../../erp/mark-attendance.php');
        }
        catch(PDOException $ef) {
            echo $ef->getMessage();
            $_SESSION["succ"] = "0";
            header('Location: ../../erp/mark-attendance.php');
        }
    }