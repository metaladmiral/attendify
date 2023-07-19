<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
    if($_POST['code'] != "" && $_POST['name'] != "" && $_POST['sem']){
        $conn = new Db;
        try{
            $code = $_POST['code'];
            $name = $_POST['name'];
            $id = (String) uniqid();
            $sem = $_POST['sem'];
            
            $sql = "INSERT INTO `subjects`(subjectcode, subjectname, subjectid, subjectsem) VALUES (?, ?, ?, ?)";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute(array($code, $name, $id, $sem));


            $_SESSION['message']="1";
            header('location:../../erp/manage-subjects.php');
        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            header('location:../../erp/manage-subjects.php');
        }
    }else{
        $_SESSION['message']="n";
        header('location:../../erp/manage-subjects.php');
    }
}