<?php

session_start();

$upass = md5($_POST['upass']);
if($_SESSION['password']==$upass) {
    $_SESSION['lockscreen'] = "0";
    header('Location: ../erp/');
}
else {
    $_SESSION['lsufail'] = "1";
    header('Location: '.$_SERVER['HTTP_REFERER']);
}