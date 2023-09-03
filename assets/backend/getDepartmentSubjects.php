<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$depid = $_POST['depid'];
if(isset($_POST['tpp'])) {
    $tpp = "1";
}
else {
    $tpp = "0";
}
try {

    if($tpp) {
        $sql = "SELECT subjectcode, subjectid, subjectname, subjectsem FROM `subjects` WHERE `depid`='$depid' AND `tpp`='1' "; 
    }
    else {
        $sql = "SELECT subjectcode, subjectid, subjectname, subjectsem FROM `subjects` WHERE `depid`='$depid' "; 
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