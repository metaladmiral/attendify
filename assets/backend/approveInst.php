<?php

session_start();
require_once 'conn.php';
$conn = new Db;

$instId = $_POST['instId'];

try {
    $sql = "SELECT * FROM `instalments` a INNER JOIN `students` b ON a.studid=b.studid WHERE `instid`='$instId' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    $dataInst= $query->fetchAll(PDO::FETCH_ASSOC)[0];

    $amount = (int) $dataInst['amount'];
    $studid = $dataInst['studid'];
    $totalfee = (int) $dataInst['totalfee'];
    $totalleft = ((int) $dataInst['totalleft']) - $amount;
    $insts = json_decode($dataInst['instalment'], true);
    foreach ($insts as $key => $value) {
        if($value["instid"]==$instId) {
            $insts[$key]["status"] = 1;
            $insts[$key]["apby"] = $_SESSION['fullname'];
        }
    }
    $insts = json_encode($insts, JSON_FORCE_OBJECT);

    $sql = " UPDATE `instalments` SET `status`=?, `approvedby`=? WHERE `instid`='$instId' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute(["1", $_SESSION['fullname']]);

    $sql = " UPDATE `students` SET `instalment`=?, `totalleft`=? WHERE `studid`='$studid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute([$insts, $totalleft]);

    $sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
    $query = $conn->mconnect()->prepare($sql);
    $mess = "has approved an instalment - ".$studid." (Instalment ID - ".$instId.")";
    $time = strtotime("now");
    $query->execute([$mess, $time, $_SESSION['uid']]);

    echo "1";
}
catch(PDOException $e) {
    echo "0";
}



