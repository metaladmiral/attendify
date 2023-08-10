<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$sem = $_POST['sem'];
$sql = $conn->mconnect()->prepare(" SELECT subjectid, subjectname FROM `subjects` WHERE `subjectsem`='$sem' ");
$sql->execute();
if($sql->rowCount()>0) {
    $subjectData = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($subjectData, JSON_FORCE_OBJECT);
}
else {
    echo "0";
}

?>