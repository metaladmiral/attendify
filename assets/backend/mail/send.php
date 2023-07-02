<?php

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
require 'mailConfig.php';

if(isset($_POST['submit'])) {
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = $smtph;
$mail->Port = 587;
$mail->Username = $usrnm;
$mail->Password = $passwd;
$mail->SMTPAuth = true;

$mail->From = $usrnm;
$mail->FromName = 'Makes360';
$mail->AddAddress('anishjustofficial@gmail.com');
// $mail->AddReplyTo('phoenixd110@gmail.com', 'Information');

$mail->IsHTML(true);
$name = $_POST['name'];
$mail_ = $_POST['mail'];
$bid = $_POST['bid'];

// $name = "code";
// $mail_ = "code";
// $bid = "code";
// $bid = "Name : ".$name." Email: ".$mail_;

    $mail->Subject = "New Bid (".$name.")";
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
    $mail->Body    = "Name : ".$name." Email: ".$mail_." Bid in: ".$bid;
    // $mail->Body = $bid;

    // $mail->Subject    = "New Bid ";
    // $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    // $mail->Body    = "Body";

    if(!$mail->Send())
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
    echo "Thank You!";
    }
}
?>