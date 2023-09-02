<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$depid = $_POST['depid'];
try {

    $sql = "SELECT batchid, batchLabel FROM `batches` WHERE `depid`='$depid' "; 
    $sql = $conn->mconnect()->prepare($sql);
    
    $sql->execute();
    $batchDetails = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($batchDetails);
}
catch(PDOException $e) {
    echo "0";
}

?>