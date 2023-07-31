<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$sql = $conn->mconnect()->prepare("SELECT id FROM `users`");
$sql->execute();
$totalUsers = $sql->rowCount();

$sql = $conn->mconnect()->prepare("SELECT id FROM `students`");
$sql->execute();
$totalStudents = $sql->rowCount();


$sql = $conn->mconnect()->prepare("SELECT id FROM `batches` ");
$sql->execute();
$totalBatches = $sql->rowCount();

$sql = $conn->mconnect()->prepare("SELECT batchLabel, sectionCC FROM `batches` ");
$sql->execute();
$ccData = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $conn->mconnect()->prepare("SELECT faculty, batchLabel FROM `batches` ");
$sql->execute();
$facultyAssignData = $sql->fetchAll(PDO::FETCH_ASSOC);

$sections = array();
$subjects = array();
$faculties = array();
foreach ($facultyAssignData as $key => $value) {
    
    $facultyAssignData_ = json_decode($value["faculty"], true);
            
    foreach ($facultyAssignData_ as $sectionId => $subjectData) {
        array_push($sections, $sectionId);
        foreach ($subjectData as $subjectId => $facultyId) {
            if(gettype(array_search($subjectId, $subjects))!='integer') {
                array_push($subjects, $subjectId);
            }
            array_push($faculties, $facultyId);
        }
    }

    
}
$subjects = "'".implode("', '", $subjects)."'";
$faculties = "'".implode("', '", $faculties)."'";
$sql = $conn->mconnect()->prepare("SELECT subjectid, subjectname FROM `subjects` WHERE `subjectid` IN ($subjects) ");
$sql->execute();
$subjectInfo = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $conn->mconnect()->prepare("SELECT uid,email FROM `users` WHERE `uid` IN ($faculties) ");
$sql->execute();
$facultyInfo = $sql->fetchAll(PDO::FETCH_ASSOC);

$subjectsInfoData = array();
foreach ($subjectInfo as $key => $value) {
    $subjectsInfoData[$value["subjectid"]] = $value["subjectname"];
}

$facultyInfoData = array();
foreach ($facultyInfo as $key => $value) {
    $facultyInfoData[$value["uid"]] = $value["email"];
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
                            <h1 class="page-title">User Dashboard</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">User Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->
                        <div class="row">
                            <div class="col-4">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="mt-2">
                                                <h6 class="">Total Users</h6>
                                                <h2 class="mb-0 number-font"><?php echo $totalUsers; ?></h2>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="mt-2">
                                                <h6 class="">Total Students</h6>
                                                <h2 class="mb-0 number-font"><?php echo $totalStudents; ?></h2>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="mt-2">
                                                <h6 class="">Total Batches</h6>
                                                <h2 class="mb-0 number-font"><?php echo $totalBatches; ?></h2>
                                            </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Batches & Sections with No CC Assigned: </h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                            <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">S. No</th>
                                                        <th class="border-bottom-0">Batch Name</th>
                                                        <th class="border-bottom-0">CC Not Assigned</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        foreach ($ccData as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $key+1; ?></td>
                                                                <td><?php echo $value["batchLabel"]; ?></td>
                                                                <?php
                                                            $allSectionswithNoCC = array();
                                                            $sectionCC = json_decode($value["sectionCC"], true);
                                                            echo "<td>";
                                                            for($i=1;$i<=8;$i++) {
                                                                for ($p=1; $p < 3; $p++) { 
                                                                    $sectionTag = $i."-".$p;
                                                                    if(!isset($sectionCC[$sectionTag])) {
                                                                        $sectionTag = chr($i+64).$p;
                                                                        array_push($allSectionswithNoCC, $sectionTag);
                                                                    }

                                                                }
                                                            }
                                                            echo $allSectionsStr = implode(', ', $allSectionswithNoCC);
                                                            echo "</td>";
                                                            ?>

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

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Batches & Subjects Details: </h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                            <table id="file-datatable1" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">S. No</th>
                                                        <th class="border-bottom-0">Batch Name</th>
                                                        <th class="border-bottom-0">Faculties Assigned</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $counter = 0;
                                                        foreach ($facultyAssignData as $key => $value) {
                                                            $counter++;
                                                            echo "<tr>";
                                                            echo "<td>$counter</td>";
                                                            echo "<td>".$value['batchLabel']."</td>";
                                                            $data =json_decode($value["faculty"], true);
                                                            echo "<td>";
                                                            foreach ($data as $sectionId => $subjectDetails) {
                                                                $sectionId = explode('-', $sectionId);
                                                                $section = chr($sectionId[0]+64).$sectionId[1];
                                                                echo "<span class='text-success font-weight-bold'>$section :</span><br>";
                                                                // echo "<span>".$subjectInfo[$subjectDetails[0]]."</span>";
                                                                // echo "<span>".$facultyInfo[$subjectDetails[1]]."</span>";
                                                                foreach ($subjectDetails as $key => $value) {
                                                                    echo "<b>".$subjectsInfoData[$key]."</b>".": ".$facultyInfoData[$value]."<br>";
                                                                }
                                                            }
                                                            echo "</td>";
                                                            echo "</tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">All Subjects Created </h3>
                                        <div class="card-options">
                                            <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                            <table id="file-datatable2" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">S. No</th>
                                                        <th class="border-bottom-0">Subject Code</th>
                                                        <th class="border-bottom-0">Subject Name</th>
                                                        <th class="border-bottom-0">Subject Semester</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $sql = $conn->mconnect()->prepare("SELECT subjectcode, subjectname, subjectsem FROM `subjects` ");
                                                    $sql->execute();
                                                    foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
                                                        echo "<tr>";
                                                        echo "<td>".($key+1)."</td>";
                                                        echo "<td>".$value['subjectcode']."</td>";
                                                        echo "<td>".$value['subjectname']."</td>";
                                                        echo "<td>".$value['subjectsem']."</td>";
                                                        echo "</tr>";
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