<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$sem = $_POST['sem'];
$batchid = $_POST['batchid'];

$sql = $conn->mconnect()->prepare(" SELECT collegeid, depid FROM `batches` WHERE `batchid`='$batchid' ");
$sql->execute();
$batchData = $sql->fetch(PDO::FETCH_ASSOC);
$collegeid=$batchData['collegeid'];
$depid=$batchData['depid'];

if(isset($_POST['tpp'])) {
    $sql = $conn->mconnect()->prepare(" SELECT subjectid, subjectname FROM `subjects` WHERE `subjectsem`='$sem' AND `collegeid`='$collegeid' AND `depid`='$depid' AND `tpp`='1' ");
}
else {
    $sql = $conn->mconnect()->prepare(" SELECT subjectid, subjectname FROM `subjects` WHERE `subjectsem`='$sem' AND `collegeid`='$collegeid' AND `depid`='$depid' ");
}
$sql->execute();
if($sql->rowCount()>0) {
    $subjectData = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($subjectData, JSON_FORCE_OBJECT);
}
else {
    echo "0";
}

?>