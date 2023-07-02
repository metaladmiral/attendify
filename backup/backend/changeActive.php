<?php

session_start();
require_once 'conn.php';

$conn = new Db;
try{
    $state = $_POST['state'];
    $uid = $_POST['uid'];
    
    
    $sql = "UPDATE `users` SET active=? WHERE `uid`='$uid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute(array($state));

    echo "1";
}catch(PDOException $e){
    echo $e->getMessage();
}
