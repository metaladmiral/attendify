<?php

session_start();
require_once 'conn.php';

$conn = new Db;

if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='1' ) {

    if(isset($_POST['updatesubjectfaculty']) || isset($_POST['assignsubjectfaculty'])) {
        
        try {    
            $facultyId = $_POST['facultyId'];
            $batchId = $_POST['batchid'];
            $sectionId = $_POST['sectionid'];
            $subjectId = $_POST['subjectid'];

            $sql = "SELECT subjectname from `subjects` WHERE `subjectid`='$subjectId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $subjectName = $query->fetch(PDO::FETCH_COLUMN);

            $sql = "SELECT faculty from `users` WHERE uid='$facultyId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $facultyAssignHistory = $query->fetch(PDO::FETCH_COLUMN);
            $facultyAssignHistory = json_decode($facultyAssignHistory, true);

            // if(isset($facultyAssignHistory[$batchId])) {
            //     array_push($facultyAssignHistory[$batchId], $sectionId);
            // }
            // else {
                //     $facultyAssignHistory[$batchId] = array($sectionId);
                // }
            $facultyAssignHistory[$batchId][$sectionId] = array($subjectId, $subjectName);
            $facultyAssignNew = json_encode($facultyAssignHistory);

            $sql = "UPDATE `users` SET `faculty`='$facultyAssignNew' WHERE `uid`='$facultyId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();

            $sql = "SELECT faculty from `batches` WHERE `batchid`='$batchId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $subjectFacultyHistory = $query->fetch(PDO::FETCH_COLUMN);
            $subjectFacultyHistory = json_decode($subjectFacultyHistory, true);
            
            // foreach ($subjectFacultyHistory as $key => $value) {
            //     if(array_search($facultyId, $subjectFacultyHistory[$key])) {
            //         $batchKey = array_search($facultyId, $subjectFacultyHistory[$key]);
            //         unset($subjectFacultyHistory[$key]);
            //     }
            // }
            
            $subjectFacultyHistory[$sectionId][$subjectId] = $facultyId;

            $subjectFacultyNew = json_encode($subjectFacultyHistory);

            $sql = "UPDATE `batches` SET `faculty`='$subjectFacultyNew' WHERE `batchid`='$batchId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();

            if(isset($_POST['updatesubjectfaculty'])) {
                $prevFacultyId = $_POST['prevfaculty'];
                $sql = "SELECT faculty from `users` WHERE `uid`='$prevFacultyId' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute();
                $prevfacultyAssignHistory = $query->fetch(PDO::FETCH_COLUMN);
                $prevfacultyAssignHistory = json_decode($prevfacultyAssignHistory, true);

                // $prevFacultyArrayInfo = array();
                // foreach ($prevfacultyAssignHistory as $key => $value) {
                //     $inBatchKey = array_search($sectionId, $prevfacultyAssignHistory[$key]);
                //     array_push($prevFacultyArrayInfo, $key, $inBatchKey);
                // }
                // array_splice($prevfacultyAssignHistory[$prevFacultyArrayInfo[0]], $prevFacultyArrayInfo[1], 1);
                unset($prevfacultyAssignHistory[$batchId][$sectionId]);
                if(!count($prevfacultyAssignHistory[$batchId])) {
                    unset($prevfacultyAssignHistory[$batchId]);
                }
                
                $prevfacultyAssignNew = json_encode($prevfacultyAssignHistory);
                $sql = "UPDATE `users` SET `faculty`='$prevfacultyAssignNew' WHERE `uid`='$prevFacultyId' ";
                $query = $conn->mconnect()->prepare($sql);
                $query->execute();

            }
            $_SESSION['sufaculty'] = 1;
            header('Location: ../../erp/assign-subject-faculty');
            
        }catch(PDOException $e) {
            
            $_SESSION['sufaculty'] = 0;
            header('Location: ../../erp/assign-subject-faculty');
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