<?php 

session_start();
include 'conn.php';

class login extends db {
    public function main() {
        $email = $_POST['email'];
        $uT = $_GET['t']; // usertype
        $password = md5($_POST['password']);

        $query = db::mconnect()->prepare("SELECT * FROM `users` WHERE `email`='".$email."' AND `password`='".$password."' AND `active`='1' ");
        $query->execute();
        $row = $query->rowCount();
        
        if($row>0) {
            $arr = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $uid = $arr[0]["uid"];
            $ousertype = $arr[0]["usertype"];
            $email = $arr[0]["email"];
            $fullname = $arr[0]["username"];
            // setcookie('uid', $uid, time() + (86400 * 30), "/");
            $_SESSION['uid'] = $uid;
            $_SESSION['usertype'] = $ousertype;
            $_SESSION['email'] = $email;
            $_SESSION['fullname'] = $fullname;
            
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
