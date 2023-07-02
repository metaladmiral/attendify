<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
    if($_POST['email'] != "" || $_POST['password'] != "" || $_POST['usertype'] != ""){
        $conn = new Db;
        try{
            $email = $_POST['email'];
            $username = $_POST['username'];
            $uid = substr($email, 0, 4)."".uniqid();
            $password = md5($_POST['password']);
            $usertype = $_POST['usertype'];
            
            $sql = "INSERT INTO `users`(uid, email, username, password, usertype) VALUES (?, ?, ?, ?, ?)";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute(array($uid, $email, $username,$password,$usertype));


            $_SESSION['message']="1";
            header('location:../../erp/manage-users.php');
        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            header('location:../../erp/manage-users.php');
        }
    }else{
        $_SESSION['message']=$e->getMessage();
        header('location:../../erp/manage-users.php');
    }
}