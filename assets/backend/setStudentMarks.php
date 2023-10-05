<?php

session_start();
require_once 'conn.php';

$conn = new Db;

if(!isset($_POST['colType'])) {
    try{
        
        $subjectid = $_POST['subjectid'];
        $studid = $_POST['studid'];
        
        $sql = " SELECT marks FROM `students` WHERE `studid`='$studid' ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute();
        $marksOld = $query->fetch(PDO::FETCH_COLUMN);
    
        $marksOld = json_decode($marksOld, true);
    
        $marksOld[$subjectid] = [
            'mst1' => (isset($_POST['mst1']) && !empty($_POST['mst1'])) ? $_POST['mst1'] : "NA",
            'assgn1' => (isset($_POST['assgn1']) && !empty($_POST['assgn1'])) ? $_POST['assgn1'] : "NA",
            'mst2' => (isset($_POST['mst2']) && !empty($_POST['mst2'])) ? $_POST['mst2'] : "NA",
            'assgn2' => (isset($_POST['assgn2']) && !empty($_POST['assgn2'])) ? $_POST['assgn2'] : "NA",
        ];
        
        $marksNew = json_encode($marksOld);
    
        $sql = "UPDATE `students` SET `marks`=? WHERE `studid`='$studid' ";
        $query = $conn->mconnect()->prepare($sql);
        $query->execute([$marksNew]);
    
        echo "1";
    
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
else {
    try{
        
        $subjectid = $_POST['subjectid'];
        $data = json_decode($_POST['data'], true);
        $colType = $_POST['colType'];

        $updateSql = "UPDATE `students` SET `marks`=? WHERE `studid`=?";

        $pdo = $conn->mconnect();
        $pdo->beginTransaction();

        foreach ($data as $studid => $marks) {
            $sql = " SELECT marks FROM `students` WHERE `studid`='$studid' ";
            $query = $conn->mconnect()->prepare($sql);
            $query->execute();
            $marksOld = $query->fetch(PDO::FETCH_COLUMN);
        
            $marksOld = json_decode($marksOld, true);
            $marksNew = $marksOld;
        
            if(!isset($marksOld[$subjectid])) {
                $marksNew[$subjectid] = array("mst1"=>"", "mst2"=>"", "assgn1"=>"", "assgn2"=>"");
            }
    
            $marksNew[$subjectid][$colType] = $marks;
            
            $marksNew = json_encode($marksNew);
        
            $query = $pdo->prepare($updateSql);
            $query->execute([$marksNew, $studid]);
        }
   
        $pdo->commit();
        
        echo "1";
    
    }catch(PDOException $e){
        echo $e->getMessage();
        $pdo->rollBack();
    }
}
