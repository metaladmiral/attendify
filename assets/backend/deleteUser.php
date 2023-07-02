<?php

session_start();
require_once 'conn.php';

$conn = new Db;
try{
    $uid = $_POST['uid'];

    $sql = "DELETE FROM `users` WHERE `uid`='$uid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    echo "1";
}catch(PDOException $e){
    echo "0";
}
