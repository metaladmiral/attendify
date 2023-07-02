<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

if($_SESSION['usertype']!="3") {
    header('Location: ./index.php');
    die();
}

$cArr = array();
$bArr = array();

$sql = "SELECT * FROM `batches` ORDER BY `id` DESC";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$dataBatch= $query->fetchAll(PDO::FETCH_ASSOC);

if(count($_POST)>0) {
    // var_dump($_POST);
    foreach ($_POST as $key => $value) {
        if($value=="checked") {
            $name = explode('-', $key);
            $pre = $name[0];
            if($pre=="b") {
                array_push($bArr, $name[1]);
            }
        }
    }

    if(count($bArr)>0) {
        $batches = "'" . implode ( "', '", $bArr ) . "'";
    }else {
        $batches = "SELECT batchid FROM `batches`";
    }
    

    $sql = "SELECT * FROM `students` WHERE `batchid` IN ($batches) AND `counsid`=? ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute([$_SESSION['uid']]);
    $studRes = $query->fetchAll(PDO::FETCH_ASSOC);

}
else {

    $bat = $dataBatch[0]['batchid'];
    $sql = "SELECT * FROM `students` WHERE `batchid`='$bat' AND `counsid`=? ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute([$_SESSION['uid']]);
    $studRes = $query->fetchAll(PDO::FETCH_ASSOC);

}

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
                            <h1 class="page-title">Dashboard</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->
                        <script>
                            function getResults() {
                                $("#studForm").submit();
                            }
                            function studFormSubmit() {
                                const form = $("#studForm")[0];
                                for (let i = 0; i < form.length; i++) {
                                    const element = form[i];
                                    if(element.checked) {
                                        element.setAttribute('value', 'checked');
                                    }
                                }
                                // console.log(form.length);
                                return true;
                            }
                        </script>
                        <form action="" method="POST" id="studForm" onsubmit="return studFormSubmit()">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Batch</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">Select a Batch for results</h6>
                                            <p class="card-text">
                                                    <div class="form-group">
                                                        <?php 
                                                            
                                                            foreach ($dataBatch as $key => $value) {
                                                                ?>
                                                                <label class="custom-control custom-checkbox-md">
                                                                    <input onchange="getResults()" type="checkbox" class="custom-control-input" onchange="getResults()" name="b-<?php echo $value['batchid']; ?>" <?php if(($key==0 && count($_POST)==0) || in_array($value['batchid'], $bArr) ) {echo "value='checked' checked";}else {echo "value='0'";} ?>>
                                                                    <span class="custom-control-label"><?php echo $value["batchLabel"]; ?></span>
                                                                </label>
                                                                <?php 
                                                            }
                                                        ?>
                                                    </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Results</h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="javascript:void(0)" class="card-options-fullscreen" data-bs-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        
                                    <div class="table-responsive">
                                            <table id="responsive-datatable" class="table table-bordered text-nowrap border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">S. No</th>
                                                        <!-- <th class="border-bottom-0">Actions</th> -->
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Email</th>
                                                        <th class="border-bottom-0">Student Id</th>
                                                        <th class="border-bottom-0">Fees Due</th>
                                                        <th class="border-bottom-0">Batch</th>
                                                        <th class="border-bottom-0">Counsellor</th>
                                                        <th class="border-bottom-0">Roll No. Status</th>
                                                        <th class="border-bottom-0">University Roll No.</th>
                                                        <th class="border-bottom-0">Class Roll No.</th>
                                                        <th class="border-bottom-0">Contact</th>
                                                        <th class="border-bottom-0">Alternate No.</th>
                                                        <th class="border-bottom-0">Whatsapp No.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        foreach ($studRes as $key => $value) {
                                                            $rolls = json_decode($value['rollnos'], true);
                                                            $uniroll = $rolls['uniroll'];
                                                            $classroll = $rolls['classroll'];
                                                            $rollSArr = array("Roll Number Received", "Pendency", "LGS Verified", "LGS Not Verified", "IBOSE", "Below 5000", "Cancelled");
                                                            ?>
                                                            <tr>
                                                            <td><?php echo $key+1; ?></td>
                                                            <!-- <td><button id="bEdit" onclick='window.location = "./edit-student.php?sid=<?php echo $value["studid"]; ?>"' type="button" class="btn btn-sm btn-primary"><span class="fe fe-edit"> </span></button></td> -->
                                                            <td><?php echo $value['name']; ?></td>
                                                            <td><?php echo $value['email']; ?></td>
                                                            <td><?php echo $value['studid']; ?></td>
                                                            <td><?php echo $value['batchid']; ?></td>
                                                            <td><?php echo $value['counsid']; ?></td>
                                                            <td><?php echo $rollSArr[((int)$value['rollstatus'])]; ?></td>
                                                            <td><?php echo $uniroll; ?></td>
                                                            <td><?php echo $classroll; ?></td>
                                                            <td><?php echo $value['contact']; ?></td>
                                                            <td><?php echo $value['alternateno']; ?></td>
                                                            <td><?php echo $value['wano']; ?></td>
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
    <script>
        $(document).ready(function() {
            var table = $('#resTable').DataTable( {
                responsive: false
            } );
            // table.buttons().container()
            //     .appendTo( '#example_wrapper .col-md-6:eq(0)' );
            } );
    </script>
</body>
</html>