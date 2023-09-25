<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$ut = $_SESSION['usertype'];
if($ut=="3") {
    $collegeid = $_SESSION['collegeid'];
    $depid = json_decode($_SESSION['depid'], true);
    $depidFT = implode(" OR ", $depid);
    $depidin = "'".implode("', '", $depid)."'";
}

$showAnalysis = 0;
if(isset($_GET['batch']) && isset($_GET['depid']) && isset($_GET['sem'])) {
    $showAnalysis = 1;
    $batchid = $_GET['batch'];
    $depidGet = $_GET['depid'];
    $sem = $_GET['sem'];
    
    $sql = $conn->mconnect()->prepare(" SELECT faculty FROM `batches` WHERE `batchid`='$batchid' ");
    $sql->execute();
    $faculty = $sql->fetch(PDO::FETCH_COLUMN);
    $faculty = json_decode($faculty, true);

    $sqls = $conn->mconnect()->prepare(" SELECT subjectid, subjectname FROM `subjects` WHERE `depid`='$depidGet' AND `subjectsem`='$sem' ");
    $sqls->execute();
    $subjects = $sqls->fetchAll(PDO::FETCH_KEY_PAIR);

    $tppDepId = "tpp765";
    $sqls = "SELECT uid, username, empid FROM `users` WHERE MATCH(`depid`) AGAINST('$depidFT OR $tppDepId ') AND `usertype`='2' ";
    $sqls = $conn->mconnect()->prepare($sqls);
    $sqls->execute();
    $facultyDetails = $sqls->fetchAll(PDO::FETCH_ASSOC);
    $facultyDetails_ = array();
    foreach ($facultyDetails as $key => $value) {
        $facultyDetails_[$value["uid"]] = array($value["username"], $value["empid"]);
    }

    $sql = $conn->mconnect()->prepare(" SELECT subjectid,sectionid,count(*) as c FROM `att_$batchid` GROUP BY `subjectid`, `sectionid` ");
    $sql->execute();
    $lectureDetails = $sql->fetchAll(PDO::FETCH_ASSOC);
    $ld = array();
    foreach ($lectureDetails as $key => $value) {
        $ld[$value["subjectid"]][$value["sectionid"]] = $value["c"];
    }

}



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
    <script src="../assets/js/jquery.min.js"></script>
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
                            <h1 class="page-title">Analysis</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Student Records</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Select Class Details</h3>
                                    <div class="card-options">
                                        <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <form action="" onsubmit="">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="" class="form-label">Select Department: </label>
                                                    <select name="depid" id='depSelect' class="form-control form-select select2" data-placeholder="Choose One" tabindex="-1" aria-hidden="true" required>
                                                            <option value="" disabled selected>Select Department</option>
                                                            <?php 
                                                            if($ut=="4" || $ut=="1") { 
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid`!='tpp765'";
                                                            }else{
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid` IN ($depidin) AND a.`depid`!='tpp765'" ;
                                                            }
                                                            $query = $conn->mconnect()->prepare($sql);
                                                            $query->execute();
                                                            $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($data as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $value['depid']; ?>" 
                                                                <?php if(isset($_GET['depid'])) { if($_GET['depid']==$value["depid"]) {echo "selected";} } ?>
                                                                ><?php echo $value['depLabel']; ?> - <?php echo $value['clgLabel']; ?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <label for="" class="form-label">Select Batch: <sup class="text-danger">(Select Department First)</sup></label>
                                                    <select name="batch" id='batchid' class="form-control form-select select2" data-placeholder="Choose One" tabindex="-1" required disabled>
                                                            <option value="" disabled selected>Select Batch</option>
                                                            <?php 
                                                            if($ut!="3") { 
                                                                $sql = "SELECT * FROM `batches`";
                                                            }else {
                                                                $sql = "SELECT * FROM `batches` WHERE `depid` IN ($depidin) " ;
                                                            }
                                                            $query = $conn->mconnect()->prepare($sql);
                                                            $query->execute();
                                                            $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($data as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $value['batchid']; ?>" 
                                                                <?php if(isset($_GET['batch'])) { if($_GET['batch']==$value["batchid"]) {echo "selected";} } ?>
                                                                ><?php echo $value['batchLabel']; ?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <label for="" class="form-label">Select Semester:</label>
                                                    <?php
                                                    if(array_search("asdaqwe123", $depid)===false) {
                                                        $minSem = 3;
                                                        $maxSem = 8;
                                                    }
                                                    else {
                                                        $minSem = 1;
                                                        $maxSem = 2;
                                                    }

                                                    ?>
                                                    <input type="number" min="<?php echo $minSem; ?>"  value="<?php if(isset($_GET['sem']) && !empty($_GET['sem'])) { echo $_GET['sem']; }else {echo $minSem;}  ?>" max="<?php echo $maxSem; ?>" class="form-control" name="sem">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class='btn btn-primary'>Show Analysis</button>
                                        </div>
                                            
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php if($showAnalysis) { ?>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Analysis Details</h3>
                                    <div class="card-options">
                                        <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="data-records">
                                        <div class=col-12>
                                            <div class=card>
                                                <div class=card-body>
                                                    <div class=table-responsive>
                                                    <table id='file-datatable1' data-init="0" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                        <thead>
                                                            <tr>
                                                                <td>S.No</td>
                                                                <td>Subject</td>
                                                                <td>Section</td>
                                                                <td>Faculty</td>
                                                                <td>LD</td>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        <?php
                                                        
                                                            $count = 1;
                                                            foreach ($subjects as $subjectId => $subjectname) {
                                                                foreach ($faculty as $sectionId => $facultyUid) {
                                                                    $sectionName = explode('-', $sectionId);
                                                                    $sectionName = chr($sectionId[0]+64).$sectionId[2];
                                                                    if(isset($facultyUid[$subjectId])) {
                                                                        $facultyName = $facultyDetails_[$facultyUid[$subjectId]][0]." - ".$facultyDetails_[$facultyUid[$subjectId]][1];
                                                                    }
                                                                    else {
                                                                        $facultyName = "<span class='text-danger'>Not Assigned</span>";
                                                                    }
                                                                    
                                                                    ?>  
                                                                    <tr>
                                                                        <td><?php echo $count; ?></td>
                                                                        <td><?php echo $subjectname; ?></td>
                                                                        <td><?php echo $sectionName; ?></td>
                                                                        <td><?php echo $facultyName; ?></td>
                                                                        <td><?php echo (isset($ld[$subjectId][$sectionId])) ? $ld[$subjectId][$sectionId] : "0"; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                $count++;
                                                                }
                                                            }
                                                        ?>

                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>

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
    <script src="../assets/js/select2.js"></script>
    <!-- INTERNAL Data tables js-->
    <script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/plugins/datatable/dataTables.responsive.min.js"></script>
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

    <script>
            $("#file-datatable1").DataTable({
                "dom": "bfrtip",
                "pageLength": "40",
                "bInfo": false
            });
       

    </script>

<script>
                            
                            $("#depSelect").change(function() {
                                // alert('prakhar');
                                let val = $(this).val();
                                if(val) {
                                    enableDep(val);
                                }
                                else {
                                    $("#batchid").attr('disabled', '1');
                                    // $("#depSelect").html("<option value='' selected disabled>Select Department</option>");
                                }
                            });
                            async function enableDep(depid) {
                                let fd = new FormData();
                                fd.set('depid', depid);
                                let resp = await fetch(`../assets/backend/getBatchesByDepartment`, {
                                    method: "POST",
                                    body: fd,
                                });
                                if(resp.ok) {
                                    const data = await resp.text();
                                    if(data=="0") {
                                        swal({
                                            title: "Alert",
                                            text: "Maintainance Required! Contact Admin",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonText: 'Exit'
                                        });
                                        $("#depSelect").attr('disabled', '1');
                                    }
                                    else {
                                        let batchData = JSON.parse(data);
                                        let html = "<option value='' selected disabled>Select Batch</option>";
                                        $("#batchid").text('');

                                        for(let key in batchData) {
                                            <?php if(isset($_GET['batch'])) { 
                                                ?>
                                                if(batchData[key].batchid=="<?php echo $_GET['batch'] ?>") {
                                                    html += `
                                                        <option value="${batchData[key].batchid}" selected>${batchData[key].batchLabel}</option>
                                                    `;
                                                    continue;
                                                }
                                                <?php
                                             } ?>
                                            html += `
                                                <option value="${batchData[key].batchid}" >${batchData[key].batchLabel}</option>
                                                `;
                                            }
                                        if(html) {
                                            $("#batchid").removeAttr('disabled');
                                            $("#batchid").html(html);
                                        }
                                        else {$("#batchid").attr('disabled', '1');}
                                    }
                                }
                                else {
                                    $("#batchid").attr('disabled', '1');
                                    swal({
                                        title: "Alert",
                                        text: "Maintainance Required! Contact Admin",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: 'Exit'
                                    });
                                }
                            }
                        </script>

</body>
</html>