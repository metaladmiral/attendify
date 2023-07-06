<?php

require_once 'conn.php';
$conn = new Db;

if(!empty($_POST['stoken'])) {
    $shtoken =  $conn->mconnect()->quote($_POST['stoken']."*");
    // $shtoken =  '"p"';/

    $sql = "SELECT a.`mno`, a.`name`, a.`studid`, a.`studemail` FROM `students` a WHERE MATCH(name, studemail, mno, mano,wno,uniroll,classroll) AGAINST($shtoken IN BOOLEAN MODE) ";
    $query = $conn->mconnect()->prepare($sql);
    // $query->execute(['"'.$shtoken.'"']);
    $query->execute();
    $studRes = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($studRes);
}else {
    echo json_encode(array());
}