<?php

session_start();
require_once 'conn.php';

$conn = new Db;

if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='1' ) {

    if(isset($_POST['updatehod']) || isset($_POST['assignhod'])) {
        
        try {    
            $hodId = $_POST['hod'];
            $collegeid = $_POST['collegeid'];
            $depid = $_POST['depid'];


            $sql = " SELECT depid FROM `users` WHERE `uid`='$hodId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $depIdsPrev = $query->fetch(PDO::FETCH_COLUMN);
            
            $depIdsNew = json_decode($depIdsPrev, true);
            if(array_search($depid, $depIdsNew)===false) {
                array_push($depIdsNew, $depid);
            }
            array_push($depIdsNew, $depid);

            $depIdsNew = json_encode($depIdsNew);
            
            $sql = "UPDATE `users` SET `collegeid`='$collegeid', `depid`='$depIdsNew' WHERE `uid`='$hodId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            
            if(isset($_POST['updatehod'])) {
                $prevHodId = $_POST['prevhod'];

                $sql = " SELECT depid FROM `users` WHERE `uid`='$prevHodId' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute();
                $depIdsPrev = $query->fetch(PDO::FETCH_COLUMN)["depid"];

                $depsIdsNew = $depIdsPrev;
                $key = array_search($depid, $depIdsPrev);
                if($key) {

                    unset($depsIdsNew[$key]);
                    $depsIdsNew = array_values($depsIdsNew);
                    $depsIdsNew = json_encode($depsIdsNew);

                    $sql = "UPDATE `users` SET `collegeid`='-', `depid`='$depsIdsNew' WHERE `uid`='$prevHodId' ";
                    $query = $conn->mconnect()->prepare($sql);
                    $query->execute();
                }
                

            }
            $_SESSION['succ'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            
        }catch(PDOException $e) {
            // echo $e->getMessage();
            $_SESSION['succ'] = 0;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

    }else {
        http_response_code(404);
        die();
    }

}
else {
    http_response_code(404);
    die();
}

?>