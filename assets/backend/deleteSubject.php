<?php

session_start();
require_once 'conn.php';
$conn = new Db;

if(isset($_SESSION['usertype'])){

    if($_SESSION['usertype']=="1") {

        $subjectid = $_GET['subjectid'];

        try {
            $sql = "DELETE FROM `subjects` WHERE `subjectid`='$subjectid' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
    
    
            $_SESSION['messageDel']="1";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        catch(PDOException $e) {
            // echo $e->getMessage();
            $_SESSION['messageDel']="0";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

    }
    else {
        http_response_code(404);
        die();
    }

}
else {
    http_response_code(404);
    die();
}