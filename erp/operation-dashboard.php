<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$cArr = array();
$bArr = array();

$sql = "SELECT * FROM `batches` ORDER BY `id` DESC";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$dataBatch= $query->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM `users` WHERE `usertype`='3' ";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$dataCouns= $query->fetchAll(PDO::FETCH_ASSOC);

if(count($_POST)>0) {

    // var_dump($_POST);
    if(isset($_POST['batch'])) {
        foreach ($_POST["batch"] as $key => $value) {
            array_push($bArr, $value);   
        }
    }
    else {
        $_POST["batch"] = array();
    }
    if(isset($_POST['couns'])) {
        foreach ($_POST["couns"] as $key => $value) {
            array_push($cArr, $value);   
        }
    }
    else {
        $_POST["couns"] = array();
    }
    
    if(count($bArr)>0) {
        $batches = "'" . implode ( "', '", $bArr ) . "'";
    }else {
        $batches = "SELECT batchid FROM `batches`";
    }
    
    if(count($cArr)>0) {
        $couns = "'" . implode ( "', '", $cArr ) . "'";
    }else {
        $couns = "SELECT counsid FROM `users` WHERE `usertype`='3' ";
    }

    $sql = "SELECT a.studid, a.name,a.dor,a.rollnos,a.email,c.username,a.rollstatus,a.contact,a.alternateno,a.wano,a.fname, a.mname, a.dob, a.aadharno,a.state,a.district,b.batchLabel,a.regstatus,a.totalleft,a.totalfee FROM `students` a INNER JOIN `batches` b ON a.`batchid`=b.`batchid` INNER JOIN `users` c ON a.`counsid`=c.`uid` WHERE b.`batchid` IN ($batches) AND a.`counsid` IN ($couns)";

    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    $studRes = $query->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($bArr);
    // var_dump($cArr);
    // echo "<br><br>";
    // echo $sql;
    // echo "<br><br>";
    // var_dump($studRes);
    
    // die();
}
else {
    $_POST["batch"] = array();
    $_POST["couns"] = array();
    $bat = $dataBatch[0]['batchid'];
    $couns = $dataCouns[0]['uid'];

    $sql = "SELECT a.studid,a.name,a.dor,a.rollnos,a.email,c.username,a.rollstatus,a.contact,a.alternateno,a.wano,a.fname, a.mname, a.dob, a.aadharno,a.state,a.district,b.batchLabel,a.regstatus,a.totalleft,a.totalfee FROM `students` a INNER JOIN `batches` b ON a.`batchid`=b.`batchid` INNER JOIN `users` c ON a.`counsid`=c.`uid` WHERE b.`batchid`='$bat' AND a.`counsid`='$couns'";
    // if(!isset($_POST['extfilters']) && empty($_POST['extfilters'])) {
    //     $sql .= " 1";
    // }else {
    //     $sql .= " `totalleft`>=".$_POST['extfilters'];
    // }
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    $studRes = $query->fetchAll(PDO::FETCH_ASSOC);


}
$nsql = $sql;
$totalFees = 0;
$totalDue = 0;
$studNo = 0;
$studWdueno = 0;

$studRegno = 0;
$studPendno = 0;
$studNEno = 0;

$rollSNo = array(0, 0, 0, 0, 0, 0, 0);

foreach ($studRes as $key => $value) {
    $studNo += 1;
    $totalFees += ((int) $value["totalfee"]);
    $totalDue += ((int) $value["totalleft"]);

    if(((int) $value["totalleft"])>0) {
        $studWdueno += 1;
    }

    if(((int) $value["regstatus"])==2) {
        $studRegno += 1;
    }else if(((int) $value["regstatus"])==1) {
        $studPendno += 1;
    }

    $rollSNo[((int) $value['rollstatus'])] = $rollSNo[((int) $value['rollstatus'])] + 1;

}

$studNEno = $studNo - $studRegno - $studNEno;



?>

<!doctype html>
<html lang="en" dir="ltr">
<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico">
    <!-- TITLE -->
    <title>ERP</title>
    <!-- BOOTSTRAP CSS -->
    <link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- STYLE CSS -->
     <link href="../assets/css/style.css" rel="stylesheet">
	<!-- Plugins CSS -->
    <link href="../assets/css/plugins.css" rel="stylesheet">
    <!--- FONT-ICONS CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet">
    <!-- INTERNAL Switcher css -->
    <link href="../assets/switcher/css/switcher.css" rel="stylesheet">
    <link href="../assets/switcher/demo.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        // <?php
        //     if(count($_POST)>0 || $qsPost>0)  {
        //         ?>
        //         sessionStorage.setItem("sql", "<?php echo base64_encode($sql); ?>");
        //         <?php
        //     }
        // ?>
    </script>
</head>
<body class="app sidebar-mini ltr light-mode">
    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->
    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
            <!-- app-Header & sidebar -->
            <?php include 'header.php' ?>
            <?php include 'sidebar.php' ?>
            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">
                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">
                        <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <h1 class="page-title">Operations Dashboard</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Select Batches</h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        </div>
                                    </div>
                                    <form action="" method="POST" id="studForm">
                                        <div class="card-body">

                                            <div class="row">
                                            <div class="form-group col-md-6">
                                                <select multiple="multiple" class="multi-select" name="batch[]">
                                                <?php 
                                                    
                                                    foreach ($dataBatch as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['batchid']; ?>" <?php if(($key==0 && count($_POST["batch"])==0) || in_array($value['batchid'], $bArr) ) {echo " selected";} ?> ><?php echo $value["batchLabel"]; ?></option>
                                                        <?php 
                                                    }
                                                ?>
                                                </select>
                                                
                                            </div>

                                            <div class="form-group col-md-6">
                                                <select multiple="multiple" class="multi-select" name="couns[]">
                                                    <option value="" selected disabled>Select Counsellors</option>
                                                <?php 
                                                foreach ($dataCouns as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['uid']; ?>" <?php if(($key==0 && count($_POST["couns"])==0) || in_array($value['uid'], $cArr)) {echo "selected";} ?> ><?php echo $value['username']." - ".$value['email']; ?></option>
                                                    <?php 
                                                }
                                                ?>
                                                </select>
                                            </div>

                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button class='btn btn-primary' type="submit">Apply Filters</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>

                            
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                <div class="row">

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick='$("html, body").animate({ scrollTop: $(document).height()-$(window).height() });'>Total Students</h6>
                                                        <h2 class="mb-0 number-font"><?php echo $studNo; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('regstatus', 0);">Registration Status <span class="text-muted fs-12">(Not Eligible)</span>  </h6>
                                                        <h2 class="mb-0 number-font"><?php echo $studNEno; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('regstatus', 1);">Registration Status <span class="text-muted fs-12">(Pending)</span>  </h6>
                                                        <h2 class="mb-0 number-font"><?php echo $studPendno; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('regstatus', 2);">Registration Status <span class="text-muted fs-12">(Done)</span>  </h6>
                                                        <h2 class="mb-0 number-font"><?php echo $studRegno; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                <div class="row">
                                    
                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="">Total Fees</h6>
                                                        <h2 class="mb-0 number-font"><?php echo $totalFees; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="">Total Due</h6>
                                                        <h2 class="mb-0 number-font"><?php echo $totalDue; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('fees', 0)">Students with Fees <span class="text-muted fs-12">(All Clear)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $studNo - $studWdueno; ?></h2>
                                                        
                                                    </div>
                                                    <div class="ms-auto">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function filterRes(type, val) {
                                            $("html, body").animate({ scrollTop: $(document).height()-$(window).height() }, "slow");
                                            var mytable = $('#resTable').DataTable();
                                            mytable.clear().draw();
                                            var xhttp = new XMLHttpRequest();
                                            xhttp.onreadystatechange = function() {
                                                if (this.readyState == 4 && this.status == 200) {
                                                    let resp = this.responseText;
                                                    resp = JSON.parse(resp);
                                                    console.log(resp);
                                                    for (let i = 0; i < resp.length; i++) {
                                                        const e = resp[i];
                                                        let sno = (i+1).toString();
                                                        let roll = JSON.parse(e.rollnos);
                                                        let rollslabel = ["Roll Number Received", "Pendency", "LGS Verified", "LGS Not Verified", "IBOSE", "Below 5000", "Cancelled"];
                                                        
                                                        for (let i = 0; i < 20; i++) {
                                                            mytable.column(i).visible(true);
                                                        }
                                                        mytable.row.add([ sno, '<button onclick=\'window.location = "./edit-student.php?sid='+e.studid+'"\' id="bEdit" type="button" class="btn btn-sm btn-primary"><span class="fe fe-edit"> </span></button>', e.name, e.email, e.batchLabel, e.username, rollslabel[e.rollstatus], roll.uniroll, roll.classroll, e.contact, e.alternateno, e.wano, e.dor, e.fname, e.mname, e.dob, e.aadharno, e.state, e.district, e.address ]).draw();
                                                    }
                                                // document.getElementById("demo").innerHTML = xhttp.responseText;
                                                }
                                            };
                                            let fd = new FormData();
                                            let obj = {type: type, val:val};
                                            fd.set("sql", "<?php echo base64_encode($nsql); ?>");
                                            fd.set('data', JSON.stringify(obj));
                                            xhttp.open("POST", "../assets/backend/getStudWFilter.php");
                                            xhttp.send(fd);
                                        }
                                    </script>

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                    <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('fees', 1)">Students with Fees <span class="text-muted fs-12">(Pending)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $studWdueno; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                <div class="row">
                                    
                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('rollstatus', 0)">Roll No. <span class="text-muted fs-12">(Received)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $rollSNo[0]; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('rollstatus', 1)">Roll No. <span class="text-muted fs-12">(Pendency)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $rollSNo[1]; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                        <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('rollstatus', 2)">Roll No. <span class="text-muted fs-12">(LGS Verified)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $rollSNo[2]; ?></h2>
                                                        
                                                    </div>
                                                    <div class="ms-auto">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                    <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('rollstatus', 3)">Roll No. <span class="text-muted fs-12">(LGS Not Verified)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $rollSNo[3]; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                    <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('rollstatus', 4)">Roll No. <span class="text-muted fs-12">(IBOSE)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $rollSNo[4]; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                    <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('rollstatus', 5)">Roll No. <span class="text-muted fs-12">(Below 5000)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $rollSNo[5]; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="card overflow-hidden">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="mt-2">
                                                    <h6 class="" style='color: #6C5FFC;cursor:pointer;font-weight:bold;' onclick="filterRes('rollstatus', 6)">Roll No. <span class="text-muted fs-12">(Cancelled)</span></h6>
                                                        <h2 class="mb-0 number-font"><?php echo $rollSNo[6]; ?></h2>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="chart-wrapper mt-1">
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-lg">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Other Filters</h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="otherFilForm">
                                       <div class="row">
                                        <div class="col-6">
                                            <b><label for="form-label">Documents Filter:</label></b>
                                            <select multiple="multiple" class="multi-select" name="docfilter">
                                                <option value="" selected disabled>Select Documents</option>
                                                <option value="without">-------- Without -------- (if checked, it'll filter students without marked documents)</option>
                                                <option value='0'>10th Documents</option>
                                                <option value='1'>Sign</option>
                                                <option value='2'>Photo</option>
                                                <option value='3'>Adhar Card</option>
                                                <option value='4'>DMC</option>
                                                <option value='6'>Fee Snapshots</option>
                                                <option value='7'>Address</option>
                                                <option value='5'>Diploma</option>
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <b><label for="form-label">Date of Admission Filter:</label></b>
                                            <input type="date" class='form-control' placeholder="Date of registration" name="dorfilter" value="">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class='btn btn-primary' onclick="applyOtherFilters(this); return false;">Apply Filters</button>
                                    </div>
                                    </form>
                                    <script>
                                        function applyOtherFilters() {
                                            var mytable = $('#resTable').DataTable();
                                            let form = $("#otherFilForm").serialize();
                                            mytable.clear().draw();
                                            var xhttp = new XMLHttpRequest();
                                            xhttp.onreadystatechange = function() {
                                                if (this.readyState == 4 && this.status == 200) {
                                                    let resp = this.responseText;
                                                    resp = JSON.parse(resp);
                                                    for (let i = 0; i < resp.length; i++) {
                                                        const e = resp[i];
                                                        
                                                        let sno = (i+1).toString();
                                                        let roll = JSON.parse(e.rollnos);
                                                        let rollslabel = ["Roll Number Received", "Pendency", "LGS Verified", "LGS Not Verified", "IBOSE", "Below 5000", "Cancelled"];

                                                        mytable.row.add([ sno, '<button onclick=\'window.location = "./edit-student.php?sid='+e.studid+'"\' id="bEdit" type="button" class="btn btn-sm btn-primary"><span class="fe fe-edit"> </span></button>', e.name, e.email, e.batchLabel, e.username, rollslabel[e.rollstatus], roll.uniroll, roll.classroll, e.contact, e.alternateno, e.wano, e.dor, e.fname, e.mname, e.dob, e.aadharno, e.state, e.district, e.address ]).draw();
                                                    }
                                                }
                                            };
                                            let fd = new FormData();
                                            console.log(form);
                                            fd.set('otherfilterdata', form);
                                            fd.set('sql', '<?php echo base64_encode($nsql); ?>');
                                            xhttp.open("POST", "../assets/backend/getStudWFilter.php");
                                            xhttp.send(fd);
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Graphical Info</h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                    <div class='chartcont' style='display: flex;align-items:center;justify-content:center;'>
                                    <style>
                                        .chartcont .chart-container {
                                            width: 33.3%;
                                            /* border: 1px solid black; */
                                        }
                                    </style>
                                        <!-- <div id="" style="width: 350px; height: 300px;"></div> -->
                                        <div class="chart-container">
                                            <canvas id="regchartjs" class="h-275"></canvas>
                                        </div>
                                        <div class="chart-container">
                                            <canvas id="rollchartjs" class="h-275"></canvas>
                                        </div>
                                        <div class="chart-container">
                                            <canvas id="feechartjs" class="h-275"></canvas>
                                        </div>
                                        <!-- <center><div id="rollchartjs" style="width: 350px; height: 300px;"></div></center>
                                        <div id="feechartjs" style="width: 350px; height: 300px;"></div> -->
                                    </div>
                                    </div>
                                </div>                     
                            </div>
                        </div>

                        


                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Filters</h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="javascript:void(0)" class="card-options-fullscreen" data-bs-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label">Fees Due</label>
                                            <select name="country" id="dueFilter" value="" class="form-control form-select select2" onchange="setDueFilter(this.value);">
                                                <option value="" selected>Due more than</option> 
                                                <option value="2000">More than 2,000</option>
                                                <option value="5000">More than 5,000</option>
                                                <option value="10000">More than 10,000</option>
                                                <option value="15000">More than 15,000</option>
                                                <option value="20000">More than 20,000</option>
                                            </select>
                                            <script>
                                                function setDueFilter(e) {
                                                    // $(".extfilters")[0].value = e.value;
                                                    console.log("asd");
                                                    // getResults();
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <script>
                            function generatePDF(sql) {
                                let data = btoa(JSON.stringify($("#resTable").DataTable().rows().data()));
                                document.querySelector("#data-pdf").value = data;
                                document.querySelector("#data-count").value = $("#resTable").DataTable().page.info().recordsTotal;;
                                // console.log(data);
                                // window.open(" ", "_blank");
                                document.querySelector('.pdfform').submit();
                            }
                        </script>

                        <form action="../assets/dompdf/index.php" method="POST" class='pdfform' target="_blank">
                            <input type="hidden" id='data-pdf' name="d">
                            <input type="hidden" id='data-count' name="dc">
                        </form>

                        <div class="row" id="studRec">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Student Records</h3>
                                        <!-- <button class="btn btn-primary" style='margin-left: 8px;' onclick="generatePDF();">PDF</button> -->
                                        <div class="form-group col-md-4" style='position:relative;top: 8px;'>
                                            <form action="" id='colForm'>
                                                <select name="cols" class="multi-select" multiple>
                                                    <option value="" selected disabled>Select Columns to Show</option>
                                                    <option value="2" selected>Batch Name</option>
                                                    <option value="3" selected>Name</option>
                                                    <option value="4" selected>Date of Reg.</option>
                                                    <option value="5" selected>Class Roll.</option>
                                                    <option value="6" selected>University Roll.</option>
                                                    <option value="7" selected>Email</option>
                                                    <option value="8" selected>Counsellor Name</option>
                                                    <option value="9" selected>Roll No. Status</option>
                                                    <option value="10" selected>Contact</option>
                                                    <option value="11" selected>Alternate No.</option>
                                                    <option value="12" selected>Whatsapp No.</option>
                                                    <option value="13" selected>Father's Name</option>
                                                    <option value="14" selected>Mother's Name</option>
                                                    <option value="15" selected>DOB</option>
                                                    <option value="16" selected>Aadhar No</option>
                                                    <option value="17" selected>State</option>
                                                    <option value="18" selected>District</option>
                                                </select>
                                                
                                            </form>
                                        </div>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="javascript:void(0)" class="card-options-fullscreen" data-bs-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        
                                    <div class="table-responsive">
                                            <table id="resTable" class="table table-striped table-bordered dt-responsive nowrap">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">S. No</th>
                                                        <th class="border-bottom-0">Actions</th>
                                                        <th class="border-bottom-0">Batch Name</th>
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Date of Registeration</th>
                                                        <th class="border-bottom-0">Class Roll No.</th>
                                                        <th class="border-bottom-0">University Roll No.</th>
                                                        <th class="border-bottom-0">Email</th>
                                                        <th class="border-bottom-0">Counsellor Name</th>
                                                        <th class="border-bottom-0">Roll No. Status</th>
                                                        <th class="border-bottom-0">Contact</th>
                                                        <th class="border-bottom-0">Alternate Contact</th>
                                                        <th class="border-bottom-0">Whatsapp No.</th>
                                                        <th class="border-bottom-0">Father's Name</th>
                                                        <th class="border-bottom-0">Mother's Name</th>
                                                        <th class="border-bottom-0">Date of Birth</th>
                                                        <th class="border-bottom-0">Aadhar No.</th>
                                                        <th class="border-bottom-0">State</th>
                                                        <th class="border-bottom-0">District</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        foreach ($studRes as $key => $value) {
                                                            $rolls = json_decode($value['rollnos'], true);
                                                            $uniroll = $rolls['uniroll'];
                                                            $classroll = $rolls['classroll'];
                                                            // $docs=json_decode($value['docs'], true);
                                                            $rollSArr = array("Roll Number Received", "Pendency", "LGS Verified", "LGS Not Verified", "IBOSE", "Below 5000", "Cancelled");
                                                            
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $key+1; ?></td>
                                                                <td><button onclick='window.location = "./edit-student.php?sid=<?php echo $value["studid"]; ?>"' id="bEdit" type="button" class="btn btn-sm btn-primary"><span class="fe fe-edit"> </span></button>
                                                            </td>
                                                            <td><?php echo $value['batchLabel']; ?></td>
                                                            <td><?php echo $value['name']; ?></td>
                                                            <td><?php echo $value['dor']; ?></td>
                                                            <td><?php echo $classroll; ?></td>
                                                            <td><?php echo $uniroll; ?></td>
                                                            <td><?php echo $value['email']; ?></td>
                                                            <!-- <td><?php echo $value['studid']; ?></td> -->
                                                            <td><?php echo $value['username']; ?></td>
                                                            <td><?php echo $rollSArr[((int)$value['rollstatus'])]; ?></td>
                                                            <td><?php echo $value['contact']; ?></td>
                                                            <td><?php echo $value['alternateno']; ?></td>
                                                            <td><?php echo $value['wano']; ?></td>
                                                            <td><?php echo $value['fname']; ?></td>
                                                            <td><?php echo $value['mname']; ?></td>
                                                            <td><?php echo $value['dob']; ?></td>
                                                            <td><?php echo $value['aadharno']; ?></td>
                                                            <td><?php echo $value['state']; ?></td>
                                                            <td><?php echo $value['district']; ?></td>
                                                            <!-- <td> -->
                                                                <?php
                                                                // $arr = array("")
                                                                // foreach ($docs as $key => $value) {
                                                                //     $ar
                                                                // }
                                                                ?>
                                                                <!-- <ul style='float: right;'> -->
                                                                <!-- <li> 10th Documents: <a download="true" href="./accdocs/asdt642c6257a4d85.jpeg"><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></li> -->
                                                                <!-- <li> Sign: <a download="true" href="./accdocs/asdt642c6257a4d85.jpeg"><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></li>
                                                             -->
                                                             <?php
                                                            //  foreach ($docs as $key => $value) {
                                                            //     $docLabel = array("10th Documents", "12th Documents", "Photo", "Aadhar Card", "DMC", "Diploma", "Fee Snapshots");
                                                            //     if($value!='-') {
                                                            //         ?>
                                                                     <!-- <li><span class="form-label"><?php echo $docLabel[$key]; ?>: </span><a download="true" href="./accdocs/<?php echo $value; ?>"><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></li> -->
                                                                     <?php
                                                            //     }
                                                            //  }
                                                             ?>
                                                                <!-- </ul> -->
                                                            <!-- </td> -->
                                                            </tr>
                                                            <?php
                                                        }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- BODY CONTENT END -->
                        
                    </div>
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->
        </div>
     <!-- FOOTER -->
    <?php include 'footer.php' ?>
    <!-- FOOTER END -->
    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- JQUERY JS -->
    <script src="../assets/js/jquery.min.js"></script>
    <!-- BOOTSTRAP JS -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- SPARKLINE JS-->
    <script src="../assets/js/jquery.sparkline.min.js"></script>
    <!-- Sticky js -->
    <script src="../assets/js/sticky.js"></script>
    <!-- CHART-CIRCLE JS-->
    <script src="../assets/js/circle-progress.min.js"></script>
    <!-- PIETY CHART JS-->
    <script src="../assets/plugins/peitychart/jquery.peity.min.js"></script>
    <script src="../assets/plugins/peitychart/peitychart.init.js"></script>
    <!-- SIDEBAR JS -->
    <script src="../assets/plugins/sidebar/sidebar.js"></script>
    <!-- Perfect SCROLLBAR JS-->
    <script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script>
    <script src="../assets/plugins/p-scroll/pscroll.js"></script>
    <script src="../assets/plugins/p-scroll/pscroll-1.js"></script>
    <!-- INTERNAL CHARTJS CHART JS-->
    <script src="../assets/plugins/chart/Chart.bundle.js"></script>
    <script src="../assets/plugins/chart/utils.js"></script>
    <!-- INTERNAL SELECT2 JS -->
    <script src="../assets/plugins/select2/select2.full.min.js"></script>
    <!-- INTERNAL Data tables js-->
    <script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
    <script src="../assets/plugins/datatable/js/jszip.min.js"></script>
    <script src="../assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
    <script src="../assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatable/js/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatable/js/buttons.print.min.js"></script>
    <script src="../assets/plugins/datatable/js/buttons.colVis.min.js"></script>
    <script src="../assets/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="../assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
    <script src="../assets/js/table-data.js"></script>
    <!-- INTERNAL APEXCHART JS -->
    <script src="../assets/js/apexcharts.js"></script>
    <script src="../assets/plugins/apexchart/irregular-data-series.js"></script>
    <!-- INTERNAL Flot JS -->
    <script src="../assets/plugins/flot/jquery.flot.js"></script>
    <script src="../assets/plugins/flot/jquery.flot.fillbetween.js"></script>
    <script src="../assets/plugins/flot/chart.flot.sampledata.js"></script>
    <script src="../assets/plugins/flot/dashboard.sampledata.js"></script>
    <!-- INTERNAL Vector js -->
    <script src="../assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SIDE-MENU JS-->
    <script src="../assets/plugins/sidemenu/sidemenu.js"></script>
	<!-- TypeHead js -->
	<script src="../assets/plugins/bootstrap5-typehead/autocomplete.js"></script>
    <script src="../assets/js/typehead.js"></script>
    <!-- INTERNAL INDEX JS -->
    <script src="../assets/js/index1.js"></script>
    <!-- Color Theme js -->
    <script src="../assets/js/themeColors.js"></script>
    <!-- CUSTOM JS -->
    <script src="../assets/js/custom.js"></script>
    <!-- Custom-switcher -->
    <script src="../assets/js/custom-swicher.js"></script>
    <!-- Switcher js -->
    <script src="../assets/switcher/js/switcher.js"></script>
    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="../assets/js/sweet-alert.js"></script>
    <script src="../assets/plugins/multipleselect/multiple-select.js"></script>
    <script src="../assets/plugins/multipleselect/multi-select.js"></script>

     <!-- CHARTJS JS -->
     <script src="../assets/plugins/chart/Chart.bundle.js"></script>
    <script src="../assets/js/chart.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#resTable').DataTable( {
                responsive: false,
                
            } );

            const form = document.querySelector('#colForm');
            // console.log(form);
            form.addEventListener('change', function() {
                let data = $("#colForm").serialize();
                for (let i = 2; i < 20; i++) {
                    table.column(i).visible(false);
                }
                let vals = data.split("&");
                for (let i = 0; i < vals.length; i++) {
                    let elem = vals[i].split("=")[1];
                    table.column(elem).visible(true);
                }
            });

            // $(".studRecColFilter").on('change', function(e){
            //     console.log(e);
            //     console.log('\n\n');
            //     console.log(this);
                
            //     // table.column(1).visible(false);
            // });

            

            // table.buttons().container()
            //     .appendTo( '#example_wrapper .col-md-6:eq(0)' );
            } );
    </script>

<script>
    var optionpiereg = {
        maintainAspectRatio: false,
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        },
        plugins: {
            legend: true,
            tootip: true,
            title: {
                display: true,
                text: "Registration Status",
                fullSize: true,
                position: 'bottom'
            }
        }
    };
    var datapiereg = {
        labels: ['Not Eligible', 'Pending', 'Done'],
        datasets: [{
            data: [<?php echo $studNEno; ?>, <?php echo $studPendno; ?>, <?php echo $studRegno; ?>],
            backgroundColor: ['#6c5ffc', '#05c3fb', '#09ad95']
        }]
    };
    var optionpieroll = {
        maintainAspectRatio: false,
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        },
        plugins: {
            legend: true,
            tootip: true,
            title: {
                display: true,
                text: "Fees Due",
                fullSize: true,
                position: 'bottom'
            }
        }
    };
    var datapieroll = {
        labels: ['All Clear', 'Pending'],
        datasets: [{
            data: [<?php echo $studNo - $studWdueno; ?>, <?php echo $studWdueno; ?>],
            backgroundColor: ['#6c5ffc', '#05c3fb']
        }]
    };
    var optionpiefee = {
        maintainAspectRatio: false,
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        },
        plugins: {
            legend: true,
            tootip: true,
            title: {
                display: true,
                text: "Roll No. Status",
                fullSize: true,
                position: 'bottom'
            }
        }
    };
    var datapiefee = {
        labels: ['Roll Number Received', 'Pendency', 'LGS Verified', 'LGS Not Verified', 'IBOSE', 'Below 5000', 'Cancelled'],
        datasets: [{
            data: [<?php echo $rollSNo[0]; ?>, <?php echo $rollSNo[1]; ?>, <?php echo $rollSNo[2]; ?>, <?php echo $rollSNo[3]; ?>, <?php echo $rollSNo[4]; ?>, <?php echo $rollSNo[5]; ?>, <?php echo $rollSNo[6]; ?>],
            backgroundColor: ['#6c5ffc', '#05c3fb', '#09ad95', '#cc0000','#e60099','#8533ff','#cccc00']
        }]
    };


    var ctx7 = document.getElementById('regchartjs');
    var myPieChart7 = new Chart(ctx7, {
        type: 'pie',
        data: datapiereg,
        options: optionpiereg
    });
    var ctx7 = document.getElementById('rollchartjs');
    var myPieChart7 = new Chart(ctx7, {
        type: 'pie',
        data: datapieroll,
        options: optionpieroll
    });
    var ctx7 = document.getElementById('feechartjs');
    var myPieChart7 = new Chart(ctx7, {
        type: 'pie',
        data: datapiefee,
        options: optionpiefee
    });
</script>

</body>
</html>