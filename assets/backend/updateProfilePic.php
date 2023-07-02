<?php

session_start();
require_once 'conn.php';

$conn = new Db;
if(isset($_FILES['file'])) {

        $path = $_FILES['file']['name'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if($ext=='jpg' || $ext=="jpeg" || $ext=="png") {
            
            $randname = uniqid('', TRUE).".".$ext;
            $location = "C:/xampp/htdocs/lgs/assets/profilepics/";
            $id = uniqid('');
            $uid = $_SESSION['uid'];

            if(move_uploaded_file($_FILES['file']["tmp_name"], $location.$randname)) {
                $sql = "UPDATE`users` SET `profilepic`='$randname' WHERE `uid`='".$uid."' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute();

                $_SESSION['profilepic'] = $randname;

                echo $randname;
            }
            else {
                die('1');
            }
        }
        else {
            die("2");
        }
    
}