<?php

session_start();
require_once 'conn.php';

$conn = new Db;

if(isset($_SESSION['usertype']) && ($_SESSION['usertype']=='3' || $_SESSION['usertype']=='4' )) {

    $facultyId = $_POST['facultyId'];
    if(isset($_POST['updatesubjectfaculty']) && $facultyId=="none") {

        try {
            $batchId = $_POST['batchid'];
            $sectionId = $_POST['sectionid'];
            $subjectId = $_POST['subjectid'];
            $prevFacultyId = $_POST['prevfaculty'];

            $sql = "SELECT faculty from `users` WHERE `uid`='$prevFacultyId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $prevfacultyAssignHistory = $query->fetch(PDO::FETCH_COLUMN);
            $prevfacultyAssignHistory = json_decode($prevfacultyAssignHistory, true);

            foreach ($prevfacultyAssignHistory[$batchId][$sectionId] as $key => $value) {
                // var_dump($value);
                $eKey = array_search($subjectId, $value);
                if(gettype($eKey)=="integer") {
                    unset($prevfacultyAssignHistory[$batchId][$sectionId][$key]);
                }
            }
            $prevfacultyAssignNew = json_encode($prevfacultyAssignHistory);
            $sql = "UPDATE `users` SET `faculty`='$prevfacultyAssignNew' WHERE `uid`='$prevFacultyId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            // echo $prevfacultyAssignNew;


            $sql = "SELECT faculty from `batches` WHERE `batchid`='$batchId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $subjectFacultyHistory = $query->fetch(PDO::FETCH_COLUMN);
            $subjectFacultyHistory = json_decode($subjectFacultyHistory, true);
            
            unset($subjectFacultyHistory[$sectionId][$subjectId]);

            $subjectFacultyNew = json_encode($subjectFacultyHistory);

            $sql = "UPDATE `batches` SET `faculty`='$subjectFacultyNew' WHERE `batchid`='$batchId' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            // echo $subjectFacultyNew;

            $_SESSION['sufacultynone'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            die();
        }
        catch(PDOException $e) {
            $_SESSION['sufaculty'] = 0;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            die();
        }

    }

    if((isset($_POST['updatesubjectfaculty'])  && $facultyId!="none") || isset($_POST['assignsubjectfaculty'])) {

        if(isset($_POST['updatesubjectfaculty'])) {
            $prevFacultyId = $_POST['prevfaculty'];
            if($prevFacultyId==$facultyId) {
                $_SESSION['sufaculty'] = 1;
                header('Location: ../../erp/assign-subject-faculty');
                die();
            }
        }

        if(empty($facultyId)) {
            $_SESSION['sufaculty'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            die();
        }

        try {    
            $batchId = $_POST['batchid'];
            $sectionId = $_POST['sectionid'];
            $subjectId = $_POST['subjectid'];

            if(isset($_POST['updatesubjectfaculty'])) {
                $prevFacultyId = $_POST['prevfaculty'];
                
                    $sql = "SELECT faculty from `users` WHERE `uid`='$prevFacultyId' ";
                    $query = $conn->mconnect()->prepare($sql);
                    $query->execute();
                    $prevfacultyAssignHistory = $query->fetch(PDO::FETCH_COLUMN);
                    $prevfacultyAssignHistory = json_decode($prevfacultyAssignHistory, true);

                    foreach ($prevfacultyAssignHistory[$batchId][$sectionId] as $key => $value) {
                        // var_dump($value);
                        $eKey = array_search($subjectId, $value);
                        if(gettype($eKey)=="integer") {
                            unset($prevfacultyAssignHistory[$batchId][$sectionId][$key]);
                        }
                    }
                     $prevfacultyAssignNew = json_encode($prevfacultyAssignHistory);
                    $sql = "UPDATE `users` SET `faculty`='$prevfacultyAssignNew' WHERE `uid`='$prevFacultyId' ";
                    $query = $conn->mconnect()->prepare($sql);
                    $query->execute();
                
            }


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
            // $facultyAssignHistory[$batchId][$sectionId] = array($subjectId, $subjectName);
            // $facultyAssignNew = json_encode($facultyAssignHistory);

             if(isset($facultyAssignHistory[$batchId][$sectionId])) {
                array_push($facultyAssignHistory[$batchId][$sectionId], array($subjectId, $subjectName));
            }
            else {
                $facultyAssignHistory[$batchId][$sectionId] = array();
                array_push($facultyAssignHistory[$batchId][$sectionId], array($subjectId, $subjectName));
            }

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

            
            $_SESSION['sufaculty'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            
        }catch(PDOException $e) {
            
            $_SESSION['sufaculty'] = 0;
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