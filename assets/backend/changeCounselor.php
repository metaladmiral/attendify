<?php

session_start();
require_once 'conn.php';

$conn = new Db;

if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='3' ) {

    if(isset($_POST['updatecc']) || isset($_POST['assigncc'])) {
        
        try {    
            $ccId = $_POST['cc'];
            $batchId = $_POST['batchid'];
            $sectionId = $_POST['sectionid'];

            $sql = "SELECT CC from `users` WHERE uid='$ccId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $ccAssignHistory = $query->fetch(PDO::FETCH_COLUMN);
            $ccAssignHistory = json_decode($ccAssignHistory, true);

            $ccAssignHistory[$batchId] = $sectionId;
            $ccAssignNew = json_encode($ccAssignHistory);

            $sql = "UPDATE `users` SET `CC`='$ccAssignNew' WHERE `uid`='$ccId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();

            $sql = "SELECT sectionCC from `batches` WHERE `batchid`='$batchId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $sectionCCHistory = $query->fetch(PDO::FETCH_COLUMN);
            $sectionCCHistory = json_decode($sectionCCHistory, true);

            if(array_search($ccId, $sectionCCHistory)) {
                $key = array_search($ccId, $sectionCCHistory);
                unset($sectionCCHistory[$key]);
            }
            
            $sectionCCHistory[$sectionId] = $ccId;

            $sectionCCNew = json_encode($sectionCCHistory);

            $sql = "UPDATE `batches` SET `sectionCC`='$sectionCCNew' WHERE `batchid`='$batchId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();

            if(isset($_POST['updatecc'])) {
                $prevCCId = $_POST['prevcc'];
                $sql = "SELECT CC from `users` WHERE uid='$prevCCId' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute();
                $prevccAssignHistory = $query->fetch(PDO::FETCH_COLUMN);
                $prevccAssignHistory = json_decode($prevccAssignHistory, true);

                unset($prevccAssignHistory[$batchId]);

                $prevccAssignNew = json_encode($prevccAssignHistory);
                $sql = "UPDATE `users` SET `CC`='$prevccAssignNew' WHERE `uid`='$prevCCId' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute();

            }
            $_SESSION['succ'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            
        }catch(PDOException $e) {
            
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