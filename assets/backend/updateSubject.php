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
            
            $sql = "UPDATE `subjects` SET `subjectname`=?, `subjectsem`=?,  `subjectcode`=?, `tpp`=?, `lab`=? WHERE `subjectid`='$id' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute([$name,$sem, $code, $tpp, $lab]);
        
            $_SESSION['message']="1";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            // echo $e->getMessage();
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
}