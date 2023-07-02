<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
        $conn = new Db;
        try{
            $email = $_POST['email'];
            $uid = $_POST['uid'];
            $username = $_POST['fullname'];
            
            $usertype = $_POST['usertype'];
            
            $password = $_POST['password'];
            if(!empty($password) && !is_null($password)) {
                $password = md5($password);
                $sql = "UPDATE `users` SET email=?, username=?, password=?, usertype=? WHERE `uid`='$uid' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute(array($email, $username,$password,$usertype));
            }
            else {
                $sql = "UPDATE `users` SET email=?, username=?, usertype=? WHERE `uid`='$uid' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute(array($email, $username,$usertype));
            }

            $_SESSION['message']="1";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }catch(PDOException $e){
            $_SESSION['message']=$e->getMessage();
            // echo $e->getMessage();
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
}