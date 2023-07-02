<?php

session_start();
require_once 'conn.php';
$conn = new Db;

// $cArr = base64_decode($_POST['cArr']);
// $bArr = base64_decode($_POST['bArr']);

$sql = base64_decode($_POST['sql']);

if(isset($_POST['otherfilterdata'])) {

    $without = "0";
    $oftr = explode('&', $_POST['otherfilterdata']);
    $docsreq = array();
    $dorfilter = "0";

    foreach ($oftr as $key => $value) {
        if(strpos($value, "docfilter")!== false) {
            if(strpos($value, "without") == false ) {
                array_push($docsreq, explode('=', $value)[1]);
            }
            else {
                $without = "1";
            }
        }
        else {
            $tmp = explode('=', $value)[1];
            if(!empty($tmp)) {
                $dorfilter = explode('=', $value)[1];
            }
        }
    }

    if($dorfilter!='0') {
        $sql = $sql." AND `dor`='$dorfilter' ";
    }

    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    $data= $query->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($data);
    
    $studstoBeRem = array();
    
    foreach ($data as $key => $value) {
        $docs = json_decode($value["docs"], true);
        // $i = count($docsreq);
        foreach ($docsreq as $keya => $valuea) {
            if($without=="0") {
                if($docs[$valuea]=="-") {
                    array_push($studstoBeRem, $key);
                    break;
                }
            }else {
                if($docs[$valuea]!="-") {
                    array_push($studstoBeRem, $key);
                    break;
                }
            }
        } 
    }     
    
    foreach ($studstoBeRem  as $key => $value) {
        unset($data[$value]);
    }

    $data = array_values($data);

    echo json_encode($data);
    
}
else {
    
    $data = json_decode($_POST['data'], true);
    if($data['type']=="fees"){
        if($data['val']=="0") {
            $sql = $sql." AND `totalleft`='0' ";
        }else {
            $sql = $sql." AND `totalleft`!='0' ";
        }
    }else {
        $sql = $sql." AND ".$data['type']."=".$data['val'];
    }

    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    $data= $query->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($data);
}

