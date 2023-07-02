<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
        $conn = new Db;
        try{
            $batchLabel = $_POST['batchLabel'];
            $batchid = $_POST['batchid'];
        
                $sql = "UPDATE `batches` SET `batchLabel`=? WHERE `batchid`='$batchid' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute(array($batchLabel));
        

            $_SESSION['message']="1";
            header('Location: '.$_SERVER['HTTP_REFERER']);

        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            // echo $e->getMessage();
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
}