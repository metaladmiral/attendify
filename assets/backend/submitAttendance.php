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
    
    try {
        $sql = $conn->mconnect()->prepare("UPDATE `$tablename` SET absentStudents=? WHERE `date`='$date' ");
        $sql->execute();
    }
    catch(PDOException $e) {
        try {
            $sql = $conn->mconnect()->prepare("INSERT INTO `$tableName`(sectionid, subjectid, date, absentStudents) VALUES(?, ?, ?, ?) ");
            $sql->execute([$sectionId, $subjectId, $date, $absentStudents]);
            $_SESSION["succ"] = "1";
            header('Location: ../../erp/mark-attendance.php');
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            $_SESSION["succ"] = "0";
            header('Location: ../../erp/mark-attendance.php');
        
        }
    }
