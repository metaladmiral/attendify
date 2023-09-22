<?php

session_start();
require_once 'conn.php';
$conn = new Db;

if(!empty($_POST['stoken'])) {
    $shtoken =  $conn->mconnect()->quote($_POST['stoken']."*");
    // $shtoken =  '"p"';/

    if($_SESSION['usertype']=="3") {
        $depids = json_decode($_SESSION["depid"], true);
        $depids = "'".implode("', '", $depids)."'";
        
        $sql = "SELECT batchid FROM `batches` WHERE `depid` IN ($depids) ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute();
        $batches = $query->fetchAll(PDO::FETCH_COLUMN);
        $batches = "'".implode("', '", $batches)."'";

        $sql = "SELECT a.`mno`, a.`name`, a.`studid`, a.`studemail` FROM `students` a WHERE MATCH(name, studemail, mno, mano,wno,uniroll,classroll) AGAINST($shtoken IN BOOLEAN MODE) AND `batchid` IN ($batches) ";
    }
    else {
        $sql = "SELECT a.`mno`, a.`name`, a.`studid`, a.`studemail` FROM `students` a WHERE MATCH(name, studemail, mno, mano,wno,uniroll,classroll) AGAINST($shtoken IN BOOLEAN MODE) ";
    }

    $query = $conn->mconnect()->prepare($sql);
    // $query->execute(['"'.$shtoken.'"']);
    $query->execute();
    $studRes = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($studRes);
}else {
    echo json_encode(array());
}