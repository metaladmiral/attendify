<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
require 'mailConfig.php';

// use PHPMailer\PHPMailer\PHPMailer;
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->SMTPDebug = 4;
var_dump($mail);


  try{
    $mail->IsSMTP();
    $mail->Host = $smtph;
    $mail->SMTPAuth = true;
    $mail->Username = $usrnm; //Please Do not Change
    $mail->Password = $passwd; // Please Do not Change
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $xprt;

    $mail->setFrom($frme); // Please Do not Change
    $mail->addAddress('myprakhar96@gmail.com'); // Email address where you want to receive emails ( Pathonos admin's email here ) // Change it

    $mail->isHTML(true);
    // $mail->Subject = "New Bid ($name)";
    // $mail->Body = "<h3>Name : $name <br>Email: $mail <br>Bid in $: $bid</h3>";
    $mail->Subject = "New Bid ";
    $mail->Body = "<h3>Name ";

    $mail->send();
    header("Location: thankyou");
    
  } catch (Exception $e){
    $alert = '<div class="alert-error">
                <span>'.$e->getMessage().'</span>
              </div>';
  }


?>

<style>
    /*css for alert messages*/
.alert-error{
  z-index: 1;
  background: #FFF3CD;
  font-size: 18px;
  padding: 20px 40px;
  min-width: 420px;
  position: fixed;
  right: 0;
  top: 150px;
  border-left: 8px solid #FFA502;
  border-radius: 4px;
}
</style>