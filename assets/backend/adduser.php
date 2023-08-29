<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
    if($_POST['email'] != "" && $_POST['password'] != "" && $_POST['usertype'] != "" && $_POST['username'] != ""){
        $conn = new Db;
        try{

            

            $collegeid = $_POST['collegeid'];
            $depid= $_POST['depid'];
            $empid = $_POST['empid'];
            $number = $_POST['phone'];

            $email = $_POST['email'];
            $username = $_POST['username'];
            $uid = substr($email, 0, 4)."".uniqid();
            $password = md5($_POST['password']);
            $usertype = $_POST['usertype'];
            
            $sql = "INSERT INTO `users`(uid, email, username, password, usertype, lastlogin, collegeid, depid, empid, number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute(array($uid, $email, $username,$password,$usertype, "0", $collegeid, $depid, $empid, $number));


            $_SESSION['message']="1";
            header('location:../../erp/manage-users.php');
        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            header('location:../../erp/manage-users.php');
        }
    }else{
        $_SESSION['message']="n";
        header('location:../../erp/manage-users.php');
    }
}