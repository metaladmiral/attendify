<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
        $conn = new Db;
        try{
            $email = $_POST['email'];
            $uid = $_POST['uid'];
            $username = $_POST['fullname'];
        
            $sql = "UPDATE `users` SET email=?, username=? WHERE `uid`='$uid' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute(array($email, $username));

            
            $_SESSION['fullname']=$username;
            $_SESSION['email']=$email;
        
            $_SESSION['messageProfile']="1";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }catch(PDOException $e){
            $_SESSION['messageProfile']=$e->getMessage();
            // echo $e->getMessage();
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
}