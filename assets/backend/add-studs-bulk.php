<?php

require '../vendor/autoload.php';
include './conn.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_FILES['file'])) {
    $fname = $_FILES['file']['tmp_name'];
    $tmpname = "tmp_".rand(9999, 999999).".xls";
    copy($fname, $tmpname);
    echo $tmpname;
}
else {
    $db = new db;
    $data = json_decode($_POST['data'], true);
    $filename = $data['xlname'];
    $batchid = $data['batchid'];
    
    try {
        /**  Verify that $inputFileName really is an Xls file **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename, [\PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS]);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($filename);
        $rows = $spreadsheet->getActiveSheet()->toArray();
        
        $sql = "INSERT INTO `students`(studid, batchid, counsid, rollstatus, rollnos, regstatus, name, contact, alternateno, wano, dor, email, fname, mname, dob, aadharno, state, district, instalment, totalfee, totalleft, dispatch, docs) VALUES ";

        $docs = array("-","-","-","-","-","-","-", "-");
        $docs = json_encode($docs, JSON_FORCE_OBJECT);

        $queryData = array();
        foreach ($rows as $key => $value) {
           if($key=="0") {
            continue;
           }
            $regstat = $value[0];
            $rollstat = $value[1];

            $classroll = ($value[2]) ? $value[2] : "-";
            $uniroll = ($value[3]) ? $value[3] : "-";
            $rolls = json_encode(array("uniroll"=>$uniroll, "classroll"=>$classroll));

            $cid = $value[4];
            $name = $value[5];
            $fname = $value[6];
            $mname = $value[7];
            $dob = $value[8];
            $no = $value[9];
            $ano = $value[10];
            $wano = $value[11];
            $adharno = (String) $value[12];
            $district = $value[13];
            $state = $value[14];
            $email = $value[15];
            $dor = $value[16];
            $feecomm = $value[17];
            $feeleft = ($value[18]) ? $value[18] : '0';

            $instalments = array();
            
            $inst1date = $value[19];
            $inst1bank = $value[20];
            $inst1 = $value[21];
            $instref1 = $value[22];
            $instver1 = $value[23];

            if(!is_null($inst1date)) {
                // $det1 = json_encode(array(*));
                // $det1 = str_replace('\\','\*\\\',$det1);
                $instid = uniqid()."1";
                array_push($instalments, array("instid"=>$instid, "date"=>$inst1date, "amount"=>$inst1, "bankname"=>$inst1bank, "refno"=>$instref1, "note"=>"Na", "file"=>"-", "status"=>$instver1, "apby"=>"From Old Data"));
            }

            $inst2date = $value[24];
            $inst2bank = $value[25];
            $inst2 = $value[26];
            $instref2 = $value[27];
            $instver2 = $value[28];

            if(!is_null($inst2date)) {
                // $det2 = json_encode(array());
                $instid = uniqid()."2";
                array_push($instalments, array("instid"=>$instid, "date"=>$inst2date, "amount"=>$inst2, "bankname"=>$inst2bank, "refno"=>$instref2, "note"=>"Na", "file"=>"-", "status"=>$instver2, "apby"=>"From Old Data"));
            }
            
            $inst3date = $value[29];
            $inst3bank = $value[30];
            $inst3 = $value[31];
            $instref3 = $value[32];
            $instver3 = $value[33];
            
            if(!is_null($inst3date)) {
                // $det3 = json_encode(array());
                $instid = uniqid()."3";
                array_push($instalments, array("instid"=>$instid, "date"=>$inst3date, "amount"=>$inst3, "bankname"=>$inst3bank, "refno"=>$instref3, "note"=>"Na", "file"=>"-", "status"=>$instver3, "apby"=>"From Old Data"));
            }

            $instalments = json_encode($instalments, JSON_FORCE_OBJECT);

            $dispDate = $value[35];
            if(!empty($dispDate)) {
                $dispBy = strtolower($value[36]);
                if(strpos($dispBy, "hand")!== false) {
                    $dispBy = 1;
                }
                else {
                    $dispBy = 2;
                }
                $dispTrackID = $value[37];
                $dispRemarks = $value[38];

                $dispatch = json_encode(array(array("date"=>$dispDate, "distype"=>$dispBy, "trackid"=>$dispTrackID, "remarks"=>$dispRemarks, "receipt"=>"-")), JSON_FORCE_OBJECT);
            }else {
                $dispatch = NULL;
            }
            
            $studid = substr($batchid, 0, 2).substr($cid, 0, 3).substr(strtolower($name), 0, 3).uniqid();

            
            array_push($queryData, array($studid, $batchid, $cid, $rollstat,$rolls, $regstat, $name, $no, $ano, $wano, $dor, $email, $fname, $mname, $dob, $adharno, $state, $district, $instalments,$feecomm,$feeleft, $dispatch, $docs));

        }

        $str = array();
        foreach($queryData as $key=>$value) {
            array_push($str, "('".implode("','", $value)."')");
            // $strQues = "";
            // foreach ($value as $key1 => $value1) {
            //     if(count($value)-1 == $key1) {
            //         $strQues .= "?";
            //         continue;
            //     }
            //     $strQues .= "?, ";
            // }
            // array_push($str, "($strQues)");
        }

        // var_dump($rows);
        // var_dump($queryData);
        $queryData_ = implode(',', $str);
        $sql .= $queryData_;

        // echo $sql;
        try {

            $query = $db->mconnect()->prepare($sql);
            $query->execute();
            sleep(3);
            echo "1";
        }catch(PDOException $e) {
            echo $e->getMessage();
        }

    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        // File isn't actually an Xls file, even though it has an xls extension 
        echo json_encode(array("StatusCode"=>0, "msg"=>"File uploaded is not a XLS.", "msg2"=>$e->getMessage()));
    }
    finally{ 
        unlink($filename);
    }

}