<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$depid = $_POST['depid'];

if(isset($_POST['tpp'])) {
    if($_POST['tpp']=="1") {
        $tpp = "1";
    }
    else {
        $tpp = "2";
    }
}
else {
    $tpp = "0";
}

try {

    if($_SESSION['usertype']!="1") {

        if($tpp) {
            if($tpp=="1") {
                $sql = "SELECT subjectcode, subjectid, subjectname, subjectsem FROM `subjects` WHERE `depid`='$depid' AND `tpp`='1' ORDER BY `subjectsem` ASC "; 
            }
            else {
                $sql = "SELECT subjectcode, subjectid, subjectname, subjectsem FROM `subjects` WHERE `depid`='$depid' AND `tpp`!='1' ORDER BY `subjectsem` ASC "; 
            }
        }
        else {
            $sql = "SELECT subjectcode, subjectid, subjectname, subjectsem FROM `subjects` WHERE `depid`='$depid' ORDER BY `subjectsem` ASC "; 
        }
        
    }
    else {
        $sql = "SELECT subjectcode, subjectid, subjectname, subjectsem FROM `subjects` ORDER BY `subjectsem` ASC "; 
    }


    $sql = $conn->mconnect()->prepare($sql);
    
    $sql->execute();
    $subjectDetails = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($subjectDetails);
}
catch(PDOException $e) {
    echo "0";
}

?>