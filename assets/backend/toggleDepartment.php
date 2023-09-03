<?php

session_start();
require_once 'conn.php';

$conn = new Db;
try{

    $batchid= $_POST['batchid'];
    $appliedDepId = $_POST['appliedDepId'];
    $toApplied= $_POST['toApplied'];

    if($toApplied) {
        $sql = "SELECT depid FROM `batches` WHERE `batchid`='$batchid' ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute();
        $olddepid = $query->fetch(PDO::FETCH_COLUMN);

            $sql = "UPDATE `batches` SET `depid`='$appliedDepId', `olddepid`='$olddepid' WHERE `batchid`='$batchid' ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute();

    }
    else {
        $sql = "SELECT olddepid FROM `batches` WHERE `batchid`='$batchid' ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute();
        $olddepid = $query->fetch(PDO::FETCH_COLUMN);

        $sql = "UPDATE `batches` SET `depid`='$olddepid', `olddepid`='-' WHERE `batchid`='$batchid' ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute();
    }
    echo "1";

}catch(PDOException $e){
    echo "0";
}