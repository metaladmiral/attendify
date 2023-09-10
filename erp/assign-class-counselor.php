<?php 
session_start();
require_once 'conn.php';
$conn = new Db;


$ut = $_SESSION['usertype'];
if($ut!="3") {
    http_response_code(404);
    die();
}
$collegeid = $_SESSION['collegeid'];
$depid = json_decode($_SESSION['depid'], true);
$depidFT = implode(" OR ", $depid);
$depidin = "'".implode("', '", $depid)."'";


$showCCStatus = 0;

if(isset($_GET['batch']) && isset($_GET['section'])) {
    $showCCStatus = 1;

    $batch = $_GET['batch'];
    $section = $_GET['section'];

    $query = $conn->mconnect()->prepare("SELECT sectionCC FROM `batches` WHERE `batchid`='$batch' ");
    $query->execute();
    
    $assignHistory = $query->fetch(PDO::FETCH_COLUMN);
    $assignHistory = json_decode($assignHistory, true);

    $assignedCCId = null;
    if(isset($assignHistory[$section])) {
        $sectionAssigned = 1;
        $assignedCCId = $assignHistory[$section];

    }else {
        $sectionAssigned = 0;

    }
    
}

?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <script src="../assets/js/jquery.min.js"></script>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico">
    <!-- TITLE -->
    <title>Attendify - Assign Class Counselor CGCcms.in</title>
    <!-- BOOTSTRAP CSS -->
    <link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- STYLE CSS -->
     <link href="../assets/css/style.css" rel="stylesheet">
	<!-- Plugins CSS -->
    <link href="../assets/css/plugins.css" rel="stylesheet">
    <!--- FONT-ICONS CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/amsify/css/amsify.select.css" />
    <!-- INTERNAL Switcher css -->
    <link href="../assets/switcher/css/switcher.css" rel="stylesheet">
    <link href="../assets/switcher/demo.css" rel="stylesheet">
    <style>
        .amsify-selection-list {
            position: relative !important;
        }
        .amsify-selection-label {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: right;
        }
    </style>
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
                            <h1 class="page-title">Assign Class Counselor</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Superadmin</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Assign Class Counselor</li>
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
                                    <form action="">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-6">
                                                    <select name="batch" class="form-control form-select select2" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" required>
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
                                                <div class="col-6">
                                                    <select name="section" class='form-control form-select select2' id="">
                                                        <option value="" selected disabled>Select Section</option>
                                                        <?php
                                                            for($i=65;$i<=74;$i++) {
                                                                $p = 1;
                                                                while($p<=2) {
                                                                    ?>
                                                                    <option value="<?php echo $i-64; ?>-<?php echo $p; ?>"
                                                                    <?php if(isset($_GET['section'])) { if(  $_GET['section']==(($i-64)."-".$p) ) {echo "selected";} } ?>
                                                                    ><?php echo chr($i); ?><?php echo $p; ?></option>
                                                                <?php
                                                                    $p++;
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class='btn btn-primary'>Get CC Status</button>
                                        </div>
                                            
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($showCCStatus) { ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Assign CC</h3>
                                    <div class="card-options">
                                        <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="../assets/backend/changeCounselor" method="POST">
                                        <input type="hidden" name="batchid" value="<?php echo $_GET['batch']; ?>">
                                        <input type="hidden" name="sectionid" value="<?php echo $_GET['section']; ?>">
                                    <?php
                                    
                                        if(!$sectionAssigned) {
                                            ?>
                                            <b><label for="">CC Assigned: </label></b> <span class='text-danger'>No</span>
                                            <br>
                                            <br>
                                            <label for="">Select Class Counselor (CC): </label>
                                            <br>

                                            <select name="cc" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" required>
                                                <option value="" disabled selected>Select CC</option>
                                                <?php 
                                                   $sql = "SELECT uid, username, email FROM `users` WHERE `usertype`='2' AND MATCH(`depid`) AGAINST ('$depidFT' IN BOOLEAN MODE) ";
                                                   $query = $conn->mconnect()->prepare($sql);
                                                   $query->execute();
                                                   $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                   foreach ($data as $key => $value) {
                                                       ?>
                                                        <option value="<?php echo $value['uid']; ?>"><?php echo $value['username']; ?> - <?php echo $value['email']; ?> </option>
                                                    <?php   
                                                    }
                                                    ?>
                                             </select>
                                            <br>
                                             <button class='btn btn-primary' type='submit' name='assigncc'>Assign CC</button>
                                            <?php
                                        }
                                        else {
                                            ?>
                                            <b><label for="">CC Assigned: </label></b> <span class='text-success'>Yes</span> : <span class='currCCUsername'></span>
                                            <br>
                                            <br>
                                            <label for="">Select Class Counselor (CC): </label>
                                            <br>

                                            <input type="hidden" value="<?php echo $assignedCCId; ?>" name='prevcc'>

                                                <select name="cc" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" required>
                                                    <option value="" disabled selected>Select CC</option>
                                                    <?php 
                                                    $sql = "SELECT uid, username, empid FROM `users` WHERE `usertype`='2' AND MATCH(`depid`) AGAINST ('$depidFT' IN BOOLEAN MODE)  ";

                                                    $query = $conn->mconnect()->prepare($sql);
                                                    $query->execute();
                                                    $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($data as $key => $value) {
                                                            if($assignedCCId==$value["uid"]) {
                                                                $currCCusername = $value["username"];
                                                                $currCCEmpid = $value["empid"];
                                                                ?>
                                                                 <option class='text-success' value="<?php echo $value['uid']; ?>"><?php echo $value['username']; ?> - <?php echo $value['empid']; ?> &#x2022;</option>
                                                                <?php
                                                            }
                                                            else {
                                                                ?>
                                                                <option value="<?php echo $value['uid']; ?>"><?php echo $value['username']; ?> - <?php echo $value['empid']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>

                                                <br>

                                                <button class='btn btn-primary' type='submit' name="updatecc">Update CC</button>

                                                 <script>
                                                    document.querySelector(".currCCUsername").innerHTML = "(<?php echo $currCCusername; ?> - <?php echo $currCCEmpid; ?>)";
                                                 </script>       

                                            <?php
                                        }

                                    ?>
                                    </form>
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

    
    <script src="../assets/amsify/js/jquery.amsifyselect.js"></script>
    
    <?php
    
    if(isset($_SESSION['succ']))
    {
        if($_SESSION['succ']!="1")  {

            ?>
            <script>swal({
             title: "Oops!",
             text: "An error occured. Please contact admin!",
             type: "warning",
             showCancelButton: true,
             confirmButtonText: 'Exit'
         });</script>
            <?php

        }
        else {
            ?>
            <script>
                swal('Hooray!', 'CC Successfully assigned!', 'success');
            </script>
            <?php
        }
        unset($_SESSION['succ']);
    }

    ?>

<script>
    $(document).ready(function() {
        $("select[name='cc']").amsifySelect({
            searchable: true,
            type:'bootstrap'
        });
        // $("select[name='facultyId']")[0].style.display = "none";
    });
</script>

</body>
</html>