<?php

session_start();
require_once 'conn.php';
$conn = new Db;

// var_dump($_POST);
$studid = $_POST['studid'];
$instid = substr($studid, 0, 4).uniqid();

$sql = "SELECT count(*) as c FROM `instalments` WHERE `refno`=? ";
$query = $conn->mconnect()->prepare($sql);
$query->execute([$_POST['refno']]);
if($query->fetch(PDO::FETCH_ASSOC)['c'] > 0) {
    die("referr");    
}

if(isset($_POST['rfile'])) {
    $file = "-";
}
else {
    $tmpname = $_FILES['rfile']['tmp_name'];
    $name = $_FILES['rfile']['name'];
    $ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));
    $file = substr($instid,0, 5).uniqid().".".$ext;
    move_uploaded_file($tmpname, "C:/xampp/htdocs/lgs/erp/accdocs/$file");
}


$details = json_encode(array("bankname"=>$_POST['bankname'], "refno"=>$_POST['refno'], "note"=>$_POST['note']), JSON_FORCE_OBJECT);
$sql = "INSERT INTO `instalments`(instid, amount, date, details, file, studid, refno) VALUES(?, ?, ?, ?, ?, ?, ?) ";
$query = $conn->mconnect()->prepare($sql);
$query->execute(array($instid, $_POST['amount'], $_POST['date'], $details, $file, $studid, $_POST['refno'] ));

$sql = "SELECT instalment FROM `students` WHERE `studid`='$studid' ";
$query_ = $conn->mconnect()->prepare($sql);
$query_->execute();
$data = $query_->fetch(PDO::FETCH_ASSOC);
$instO =  $data['instalment'];

if(empty($instO) || is_null($instO)) {
    $instN = array();
}
else{
    $instN = json_decode($instO, true);
}
// $instjson = json_encode(array( "instid"=>$instid, "amount"=>$amount, "date"=>$_POST['date'], "details"=>$details, "file"=>$file ) ,JSON_FORCE_OBJECT);

array_push($instN, array( "instid"=>$instid, "amount"=>$_POST['amount'], "date"=>Date("d M Y", strtotime($_POST['date'])), "bankname"=>$_POST['bankname'], "refno"=>$_POST['refno'], "note"=>$_POST['note'], "file"=>$file, "status"=>0 ));
$instNjson = json_encode($instN, JSON_FORCE_OBJECT);


$sql = "UPDATE `students` SET `instalment`=? WHERE `studid`='$studid' ";
$query_ = $conn->mconnect()->prepare($sql);
$query_->execute([$instNjson]);

$outArr = array( "instid"=>$instid, "amount"=>$_POST['amount'], "date"=>Date("d M Y", strtotime($_POST['date'])), "details"=>$details, "file"=>$file, "status"=>0);
echo base64_encode(json_encode($outArr, JSON_FORCE_OBJECT));


$sql = "INSERT INTO `history`(mess,time, uid) VALUES(?, ?, ?) ";
$query = $conn->mconnect()->prepare($sql);
$mess = "has added an instalment for Student ID - ".$studid." (Instalment ID - ".$instid.")";
$time = strtotime("now");
$query->execute([$mess, $time, $_SESSION['uid']]);
