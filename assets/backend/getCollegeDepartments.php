<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$collegeid = $_GET['collegeid'];

try {

    $sql = $conn->mconnect()->prepare("SELECT depid, label FROM `departments` WHERE `collegeid`='".$collegeid."' ");
    
    $sql->execute();
    $depDetails = $sql->fetchAll(PDO::FETCH_KEY_PAIR);
    
    echo json_encode($depDetails);
}
catch(PDOException $e) {
    echo "0";
}

?>