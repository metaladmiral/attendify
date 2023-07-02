<?php 
session_start();
require_once 'conn.php';
require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';
require 'mail/mailConfig.php';

$conn = new Db;


if(!isset($_POST['e'])) {

    $email = $_POST['email'];

    $query = $conn->mconnect()->prepare("SELECT * FROM `users` WHERE `email`='".$email."' AND `active`='1' ");
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if($query->rowCount()==0) {
        $_SESSION['msg'] = "1";
        header("Location: ".$_SERVER['HTTP_REFERER']);
        die();
    }else {
        

        // use PHPMailer\PHPMailer\PHPMailer;
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->SMTPDebug = 4;
        // var_dump($mail);
        // $alert = '';
        try{
            $mail->IsSMTP();
            $mail->Host = $smtph;
            $mail->SMTPAuth = true;
            $mail->Username = $usrnm; //Please Do not Change
            $mail->Password = $passwd; // Please Do not Change
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $xprt;

            $mail->setFrom($frme); // Please Do not Change
            $mail->addAddress($email); // Email address where you want to receive emails ( Pathonos admin's email here ) // Change it

            $mail->isHTML(true);
            // $mail->Subject = "New Bid ($name)";
            // $mail->Body = "<h3>Name : $name <br>Email: $mail <br>Bid in $: $bid</h3>";
            $otp = rand(10010, 99999);
            $_SESSION['otp'] = $otp;
            $mail->Subject = "Password Reset on LGS!";
            $mail->Body = "OTP: ".$otp;

            $_SESSION['resetuid'] = $data["uid"];
            $_SESSION['succ'] = "1";
            header("Location: ".$_SERVER['HTTP_REFERER']);
            
            $mail->send();
            
        } catch (Exception $e){
            $_SESSION['msg'] = "2";
            header("Location: ".$_SERVER['HTTP_REFERER']);
            die();
        }
        
    }
}
else if(isset($_POST['e']) && $_POST['e']=="1") {
    $otp_toval = $_POST['otp'];
    $otpsess = $_SESSION['otp'];
    $ruid = $_SESSION['resetuid'];
    $newpass = md5($_POST['newpass']);

    if($otp_toval == $otpsess) {
        $query = $conn->mconnect()->prepare(" UPDATE `users` SET `password`=? WHERE `uid`='$ruid' ");
        $query->execute([$newpass]);
        $_SESSION['succ'] = "2";
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    else {
        $_SESSION['succ'] = "3";
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

}
