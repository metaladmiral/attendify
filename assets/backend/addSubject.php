<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
    if($_POST['code'] != "" && $_POST['name'] != "" && $_POST['sem']){
        $conn = new Db;
        try{
            $collegeid = $_POST['collegeid'];
            $depid = $_POST['depid'];

            $code = $_POST['code'];
            $name = $_POST['name'];
            $id = (String) uniqid();
            $sem = $_POST['sem'];
            if(isset($_POST['tpp'])) {
                $tpp = $_POST['tpp'];
                if($tpp=="on") {
                    $tpp = "1";
                }
                else {
                    $tpp = "0";
                }
            }
            else {
                $tpp = "0";
            }

            if(isset($_POST['lab'])) {
                $lab = $_POST['lab'];
                if($lab=="on") {
                    $lab = "1";
                }
                else {
                    $lab = "0";
                }
            }
            else {
                $lab = "0";
            }
            
            $sql = "INSERT INTO `subjects`(subjectcode, subjectname, subjectid, subjectsem, collegeid, depid, tpp, lab) VALUES (?, ?, ?, ?, ? ,?, ?, ?)";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute(array($code, $name, $id, $sem, $collegeid, $depid, $tpp, $lab));

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