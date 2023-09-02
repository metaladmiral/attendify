<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
    $conn = new Db;
    try{

        $deps = json_decode( $_POST['deps'],true);
        $colleges = json_decode( base64_decode($_POST['colleges']),true);

        foreach ($deps as $key => $value) {
            if($value['depid']==$_POST['depid']) {
                $depLabel = $value['depLabel'];
            }
        }

        $batchLabel = $colleges[$_POST['collegeid']]." - ".$_POST['course']." - ".$depLabel." - ".$_POST['startDate']."-".$_POST['endDate'];

        $batchId = substr($batchLabel, 0, 4)."".uniqid();
        $batchId = preg_replace('/\s+/', '', $batchId);
        $sql = "INSERT INTO `batches`(batchLabel,batchid, collegeid, depid) VALUES (?, ?, ?, ?)";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute(array($batchLabel, $batchId, $_POST['collegeid'], $_POST['depid']));
        $_SESSION['message']="1";
        header('location:../../erp/manage-batches.php');
    }catch(PDOException $e){
        // echo "0";
        $_SESSION['message']=$e->getMessage();
        header('location:../../erp/manage-batches.php');
    }
}