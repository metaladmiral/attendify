<?php

session_start();
require_once 'conn.php';

if(isset($_POST['submit'])){
        $conn = new Db;
        try{
            $newpass = $_POST['newpass'];
            $cnewpass = $_POST['cnewpass'];
            $currpass = md5($_POST['currpass']);
            $uid = $_SESSION['uid'];

            $sql = "SELECT * FROM `users` WHERE `uid`='".$uid."' AND `password`='".$currpass."' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            // echo $query->rowCount();
            if($query->rowCount()==0) {
                $_SESSION['messagePass']="cpasserr";
                header('Location: ../../erp/profile.php');
                die();
                // echo "cpass";
            }
            else {
                if($newpass==$cnewpass) {
                    $password = md5($newpass);
                    $sql = "UPDATE `users` SET password=? WHERE `uid`='$uid' ";
                    $query = $conn->mconnect()->prepare($sql);
                    $query->execute(array($password));
                    
                    $_SESSION['messagePass']="1";
                    header('Location: ../../erp/profile.php');
                }
                else {
                    $_SESSION['messagePass']="npass";
                    // echo "npass";
                    header('Location: ../../erp/profile.php');
                    die();
                }
            }
            

            
        }catch(PDOException $e){
            $_SESSION['messagePass']=$e->getMessage();
            // echo $e->getMessage();
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
}