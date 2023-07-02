<?php

require_once 'conn.php';
$conn = new Db;

if(!empty($_POST['stoken'])) {
    $shtoken =  $conn->mconnect()->quote($_POST['stoken']."*");
    // $shtoken =  '"p"';/

    $sql = "SELECT b.`batchLabel`, a.`contact`, a.`name`, a.`studid` FROM `students` a INNER JOIN `batches` b ON `a`.batchid=`b`.batchid WHERE MATCH(studid, name, contact, alternateno, wano, email, fname, mname, aadharno) AGAINST($shtoken IN BOOLEAN MODE) ";
    $query = $conn->mconnect()->prepare($sql);
    // $query->execute(['"'.$shtoken.'"']);
    $query->execute();
    $studRes = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($studRes);
}else {
    echo json_encode(array());
}