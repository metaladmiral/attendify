<?php

session_start();
require_once 'conn.php';

if(isset($_SESSION['usertype'])) {
    if($_SESSION['usertype']!="1") {
        http_response_code(404);
        die();
    }
}
else {
    http_response_code(404);
    die();
}

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
