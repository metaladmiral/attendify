<?php
session_start();
require_once 'conn.php';

// var_dump($_POST);
$conn = new Db;

$studid = $_POST['studid'];
$marks = array(
    "phase1"=>array("mst"=>$_POST['mst1'], "assign"=>$_POST['assign1']),
    "phase2"=>array("mst"=>$_POST['mst2'], "assign"=>$_POST['assign2'])
);

$totalAtt = $_POST['totalattendance'];
$marks = json_encode($marks);

try {
    $sql = "UPDATE `students` SET `marks`=?, `totalattendance`=? WHERE `studid`='$studid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute([$marks, $totalAtt]);
    // echo 1;
    $_SESSION['message'] = "1";
    header('Location: '.$_SERVER['HTTP_REFERER']);
    
}catch(PDOException $e) {
    // echo $e->getMessage();
    $_SESSION['message'] = "2";
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
