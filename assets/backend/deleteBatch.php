<?php

session_start();
require_once 'conn.php';

$conn = new Db;
try{
    $batchid = $_POST['batchid'];
    $sql = "DELETE FROM `batches` WHERE `batchid`='$batchid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    echo "1";
}catch(PDOException $e){
    echo "0";
}
