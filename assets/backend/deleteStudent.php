<?php

session_start();
require_once 'conn.php';

$conn = new Db;
try{
    $sid = $_GET['sid'];
    $sql = "DELETE FROM `students` WHERE `studid`='$sid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();

    $_SESSION['delSucc'] = "1";
    header('Location: ../../erp/index.php');
    
}catch(PDOException $e){
    $_SESSION['delSucc'] = "0";
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
