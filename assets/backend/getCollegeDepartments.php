<?php

session_start();
require_once 'conn.php';

$conn = new Db;

$collegeidsArr = json_decode($_POST['collegeids'], true);
$collegeids = "'".implode("', '", $collegeidsArr)."'";
try {

    $sql = "SELECT depid, b.label as clgLabel, a.label as depLabel FROM `departments` a INNER JOIN `colleges` b ON a.collegeid=b.collegeid  WHERE a.`collegeid` IN ($collegeids) "; 
    $sql = $conn->mconnect()->prepare($sql);
    
    $sql->execute();
    $depDetails = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($depDetails);
}
catch(PDOException $e) {
    echo "0";
}

?>