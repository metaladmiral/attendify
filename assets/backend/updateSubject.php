<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
        $conn = new Db;
        try{
            $id = $_POST['id'];
            $name = $_POST['name'];
            $sem = $_POST['sem'];
            $code = $_POST['code'];
            
            $sql = "UPDATE `subjects` SET `subjectname`=?, `subjectsem`=?,  `subjectcode`=? WHERE `subjectid`='$id' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute([$name,$sem, $code]);
        
            $_SESSION['message']="1";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            // echo $e->getMessage();
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
}