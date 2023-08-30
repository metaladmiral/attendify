<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$showReports = 0;

$ut = $_SESSION['usertype'];
if($ut=="3") {
    $collegeid = $_SESSION['collegeid'];
    $depid = $_SESSION['depid'];
}

if(isset($_GET['batch']) && isset($_GET['subject'])) {
    $showReports = 1;

    $batch = $_GET['batch'];
    $subjectID = $_GET['subject'];

        $section = $_GET['section'];
        $sql = $conn->mconnect()->prepare("SELECT studid, uniroll, classroll, name FROM `students` WHERE `batchid`='".$batch."' AND `sectionid`='$section'  ");
    
    $sql->execute();
    $studentDetails = $sql->fetchAll(PDO::FETCH_ASSOC);


    
    try {

        if(isset($_GET['daterange']) && !empty($_GET['daterange'])) {
            $dateRange = explode(' - ', $_GET['daterange']);
            $startDate = strtotime($dateRange[0]);
            
            $endDate = strtotime($dateRange[1]);
        }
        else {
            $startDate = strtotime("today -1 month");
            
            $endDate = strtotime("today");
        }
        $sql = "SELECT date, absentStudents FROM `att_$batch` WHERE `subjectid`='$subjectID' AND `date` BETWEEN $startDate AND $endDate ";

        $sql = $conn->mconnect()->prepare($sql);
        $sql->execute();
        $attendanceData = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        $dates = array();
        
            foreach ($attendanceData as $key => $value) {   
                $dates[$value["date"]] = $value['absentStudents'];
            }
        
        $stickedData = array("students"=>$studentDetails, "dates"=>$dates);
            // var_dump($stickedData);
    }
    catch(PDOException $e) {
        $stickedData = array("dates"=>array(), "students"=>array());
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
    <!-- TITLE -->
    <title>Attendify - Attendance Reports CGCcms.in</title>
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

    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .amsify-selection-label {
            height: 40px;
            display:flex;
            align-items:center;
            justify-content:right;
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
                            <h1 class="page-title">Attendance Reports</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Superadmin</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Attendance Reports</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Select Details</h3>
                                    <div class="card-options">
                                        <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-4">
                                                    <select name="batch" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" required>
                                                            <option value="" disabled selected>Select Batch</option>
                                                            <?php 
                                                            if($ut!="3") { 
                                                                $sql = "SELECT * FROM `batches`";
                                                            }else {
                                                                $sql = "SELECT * FROM `batches` WHERE `collegeid`='$collegeid' AND `depid`='$depid' " ;
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
                                                    <select name="section" class='form-control' id="" required>
                                                        <option value="" disabled selected>Select Section</option>
                                                        <?php
                                                            for($i=65;$i<=73;$i++) {
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
                                                <div class="col-4">
                                                    <select name="subject" class='form-control' id="" required>
                                                        <option value="" selected disabled>Select Subject</option>
                                                        <?php 
                                                        $sql = "SELECT * FROM `subjects` WHERE `collegeid`='$collegeid' AND `depid`='$depid' GROUP BY `subjectsem`, `subjectname` ";
                                                        $query = $conn->mconnect()->prepare($sql);
                                                        $query->execute();
                                                        $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                        $currOptGrp = 0;
                                                        foreach ($data as $key => $value) {
                                                            if($value['subjectsem']!=$currOptGrp) {
                                                                echo "</optgroup>";
                                                                echo "<optgroup label='Sem: ".$value['subjectsem']." ' >";
                                                                $currOptGrp = $value['subjectsem'];
                                                            }
                                                            ?>
                                                            <option value="<?php echo $value['subjectid']; ?>" 
                                                                <?php if(isset($_GET['subject'])) { if($_GET['subject']==$value["subjectid"]) {echo "selected";} } ?>><?php echo $value['subjectname']; ?> - <?php echo $value['subjectcode']; ?></option>
                                                        <?php 
                                                        }
                                                        echo "</optgroup>";
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class='btn btn-primary'>Generate Reports</button>
                                        </div>
                                            
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($showReports) { ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Report</h3>
                                    <div class="card-options">
                                        <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="col-12">
                                        <form action="" class='dateSelectForm'>
                                            <input type="hidden" name="batch" value="<?php echo $_GET['batch']; ?>">
                                            <input type="hidden" name="subject" value="<?php echo $_GET['subject']; ?>">
                                            <input type="hidden" name="section" value="<?php echo $_GET['section']; ?>">
                                            <b><label for="">Select Date Range:</label></b>
                                            <input type="text" class='attDateRange form-control' name="daterange">
                                        </form>
                                    </div>
                                    <br>
                                    <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="file-datatable1" class="table table-bordered text-nowrap key-buttons border-bottom">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0" width="1">Roll No.</th>
                                                    <th class="border-bottom-0" width="1">Name</th>
                                                    <abbr title="Total Present"><th width="1" class="border-bottom-0">TP</th></abbr>
                                                    <abbr title="Lectures Delivered"><th width="1" class="border-bottom-0">LD</th></abbr>
                                                    <abbr title="Attendance Percentage"><th width="1" class="border-bottom-0">AP</th></abbr>
                                                    <?php
                                                        foreach ($stickedData["dates"] as $key => $value) {
                                                            ?>
                                                                <th width="1"><?php echo date("d M", $key); ?></th>
                                                            <?php
                                                        }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                foreach ($stickedData["students"] as $key => $value) {
                                                    $rand = uniqid();
                                                    ?>
                                                        <tr>
                                                            <td><?php echo ($value["uniroll"]) ? $value["uniroll"] : $value["classroll"]; ?></td>
                                                            <td><?php echo $value["name"]; ?></td>
                                                            
                                                            <?php
                                                                $totalClasses = 0;
                                                                $totalPresent = 0;
                                                                $html = "";
                                                                foreach ($stickedData["dates"] as $key_ => $value_) {
                                                                    $absStuds = json_decode($value_, true);
                                                                    $key = array_search($value["studid"], $absStuds);
                                                                    $totalClasses++;
                                                                    $html .= "<td>";
                                                                    if(gettype($key)=='integer'){
                                                                        $html .= "<span class='text-danger'>A</span>";
                                                                    }else {
                                                                        $totalPresent++;
                                                                        $html .= "<span class='text-success'>P</span>";
                                                                    }
                                                                    $html .= "</td>";
                                                                }
                                                                if($totalClasses!=0) {
                                                                    $totalAttPercent = floor( (($totalPresent/$totalClasses)*100))."%";
                                                                }
                                                                else {
                                                                    $totalAttPercent = "NA";
                                                                }
                                                                ?>
                                                                <td><?php echo $totalPresent ?></td>
                                                                <td><?php echo $totalClasses; ?></td>
                                                                <td><?php echo $totalAttPercent; ?></td>
                                                                <?php echo $html; ?>

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

    <?php
    
    if(isset($_SESSION['sufaculty']))
    {
        if($_SESSION['sufaculty']!="1")  {

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
                swal('Hooray!', 'Faculty Successfully assigned!', 'success');
            </script>
            <?php
        }
        unset($_SESSION['sufaculty']);
    }

    ?>
<link rel="stylesheet" href="../assets/amsify/css/amsify.select.css" />
<script src="../assets/amsify/js/jquery.amsifyselect.js"></script>
<script>
    $(document).ready(function() {
        $("select[name='facultyId']").amsifySelect({
            searchable: true,
            type:'bootstrap'
        });
        // $("select[name='facultyId']")[0].style.display = "none";
    });
</script>

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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $("#file-datatable1").DataTable({
            dom: "Bfrtip",
            buttons: ['excel', 'pdf'],
            "bInfo": false,
            "pageLength": 23000,
            "bPaginate": false
        });
    </script>

    <?php
    if($showReports) {
        ?>
        <script>

            <?php
            if(!isset($_GET['daterange'])) {
            ?>
                let today = new Date();
                let endDate = new Date();
                today.setMonth(today.getMonth() - 1);
            <?php } else { 
                $daterange = explode(' - ', $_GET['daterange']);
            ?>
                let today = "<?php echo $daterange[0]; ?>";
                let endDate = "<?php echo $daterange[1]; ?>";
            <?php } ?>

            $(".attDateRange").daterangepicker({
                startDate: today,
                endDate: endDate,
                autoUpdateInput: true,
                locale: {
                    "format": "YYYY-MM-DD",
                }
            });

            $(".attDateRange").on('apply.daterangepicker', function(ev, picker) {
                $(".dateSelectForm").submit();
            });


        </script>
        <?php
    }
    ?>

</body>
</html>