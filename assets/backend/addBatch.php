<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
    if(!empty($_POST['batchLabel'])){
        $conn = new Db;
        try{
            $batchLabel = $_POST['batchLabel'];
            $batchId = substr($batchLabel, 0, 4)."".uniqid();
            $batchId = preg_replace('/\s+/', '', $batchId);
            $sql = "INSERT INTO `batches`(batchLabel,batchid) VALUES (?, ?)";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute(array($batchLabel, $batchId));
            $_SESSION['message']="1";
            header('location:../../erp/manage-batches.php');
        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            header('location:../../erp/manage-batches.php');
        }
    }else{
        $_SESSION['message']="n";
        header('location:../../erp/manage-batches.php');
    }
}