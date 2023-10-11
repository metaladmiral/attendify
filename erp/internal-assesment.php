<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$showReports = 0;

$ut = $_SESSION['usertype'];
if($ut=="3") {
    $collegeid = $_SESSION['collegeid'];
    $depid = json_decode($_SESSION['depid'], true);
    $depidFT = implode(" OR ", $depid);
    $depidin = "'".implode("', '", $depid)."'";
}

if(isset($_GET['batch']) && isset($_GET['subject'])) {
    $showReports = 1;
    $batch = $_GET['batch'];

    $subjectID = $_GET['subject'];

    if(isset($_GET['section'])) {
        $section = $_GET['section'];
        $section = "'".implode("', '", $section)."'";
        $sql = $conn->mconnect()->prepare("SELECT studid, uniroll, classroll, name, marks, sectionid FROM `students` WHERE `batchid`='".$batch."' AND `sectionid` IN ($section)  ");
    }
    else {
        $sql = $conn->mconnect()->prepare("SELECT studid, uniroll, classroll, name, marks, sectionid FROM `students` WHERE `batchid`='".$batch."'");
    }

    $sql->execute();
    $studAbsentCount = array();
    $studentDetails = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach($studentDetails as $key => $value) {
        $studAbsentCount[$value["studid"]] = array("totalAbsent"=>0);
    }

    $sectionWiseLectureCount = array();
    
    $sql = $conn->mconnect()->prepare(" SELECT absentStudents, date, sectionid FROM `att_$batch` WHERE `subjectid`='$subjectID' ");
    $sql->execute();
    $attDetails = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach($attDetails as $key=>$value) {
        $absStuds = $value["absentStudents"];
        $absStuds = explode('-', $absStuds);
        foreach($absStuds as $key_ => $absStudsList) {  
            $absStudsList = json_decode($absStudsList, true);

            if(!isset( $sectionWiseLectureCount[$value["sectionid"]] )) {
                $sectionWiseLectureCount[$value["sectionid"]] = 0;
            }

            $sectionWiseLectureCount[$value["sectionid"]] += 1;

            foreach ($absStudsList as $key__ => $studid) {
                $studAbsentCount[$studid]["totalAbsent"] += 1;
            }
        }
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
    <title>Attendify - Internal Assesments CGCcms.in</title>
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
    <link rel="stylesheet" href="../assets/amsify/css/amsify.select.css" />
    
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
                            <h1 class="page-title">Internal Assesment</h1>
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
                                                    <label for="" class="form-label">Select Department <sup class="text-danger">*</sup>:</label>
                                                    <select name="depid" id='depSelect' class="form-control form-select select2" data-placeholder="Choose One" tabindex="-1" aria-hidden="true" required>
                                                            <option value="" disabled selected>Select Department</option>
                                                            <?php 
                                                            if($ut=="4" || $ut=="1") { 
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid`!='tpp765' ";
                                                            }else {
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid` IN ($depidin) AND a.`depid`!='tpp765' " ;
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
                                                    <label for="" class="form-label">Select Batch <sup class="text-danger">*</sup></sup>: <sup class="text-danger">(Select Department First)</sup></label>
                                                    <select name="batch" id="batchSelect" class="form-control form-select select2" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" disabled required>
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
                                                    <label for="" class="form-label">Select Section:</label>
                                                    <select name="section[]" class='form-control form-select select2' id="" multiple>
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
                                               
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class="form-label">Select Subject: <sup class="text-danger">(Select Department First)</sup> </label>
                                                    
                                                    <style>
                                                        #select2-subjectSelect-results {
                                                            max-height: 450px !important;
                                                        }
                                                        strong.select2-results__group {
                                                            background: var(--gray-dark);
                                                            color: white;
                                                        }
                                                    </style>

                                                    <select name="subject" id='subjectSelect'  class="form-control form-select select2" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" required searchable disabled>
                                                        <option value="" selected disabled>Select Subject</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <br>
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
                                    <div class="table-responsive">
                                        <table id="file-datatable1" class="table table-bordered text-nowrap key-buttons border-bottom">
                                            <thead>
                                                <tr>
                                                    
                                                    <th class="border-bottom-0" width="1">Stud. Name</th>
                                                    <th class="border-bottom-0" width="1">URN</th>
                                                    <th class="border-bottom-0" width="1">CRN</th>
                                                    <th class="border-bottom-0" width="1">Section</th>

                                                    <?php if(isset($_GET['subject'])) {
                                                    ?>
                                                        <th class="border-bottom-0" width="1" colspan="2">Marks</th>
                                                        <th class="border-bottom-0" width="1">Avg of MST 1 & 2 (24) A</th>
                                                        <th class="border-bottom-0" width="1" colspan="2">Marks in</th>
                                                        <th class="border-bottom-0" width="1">%age Attendance</th>
                                                        <th class="border-bottom-0" width="1">Marks of Attendance (6) D</th>
                                                        <th class="border-bottom-0" width="1">Total Marks (40) A+B+C+D</th>
                                                    <?php                                                        
                                                    } ?>

                                                </tr>
                                                <?php if(isset($_GET['subject'])) {
                                                    ?>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th width="1">MST-1 (24)</th>
                                                    <th width="1">MST-2 (24)</th>
                                                    <th></th>
                                                    <th width="1">ASSGN-1 (5) B</th>
                                                    <th width="1">ASSGN-2 (5) C</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <?php                                                        
                                                } ?>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                foreach ($studentDetails as $key => $value) {
                                                    $section = explode('-', $value["sectionid"]);
                                                    $section = chr($section[0]+64).$section[1];

                                                    $marks = json_decode($value["marks"], true);
                                                    if(isset( $marks[$_GET['subject']] )) {
                                                        $marks = $marks[$_GET['subject']];
                                                        $mst1 = $marks["mst1"];
                                                        $mst2 = $marks["mst2"];

                                                        if( (!empty($mst1) && !is_null($mst1) && $mst1!="-") && (!empty($mst2) && !is_null($mst2) && $mst2!="-") ) {
                                                            $avgMst = ( $mst1 + $mst2 ) / 2;
                                                        }
                                                        else {
                                                            $avgMst = 0;
                                                        }

                                                        $assgn1 = $marks["assgn1"] / 2;
                                                        $assgn2 = $marks["assgn2"] / 2;

                                                    }else {
                                                        $isSubmitted=false;
                                                        $mst1 = 0;
                                                        $mst2 = 0;
                                                        $avgMst = 0;

                                                        $assgn1 = 0;
                                                        $assgn2 = 0;
                                                    }

                                                    $attPercentage = ( ( $sectionWiseLectureCount[$value["sectionid"]] - $studAbsentCount[$studid]["totalAbsent"]) / $sectionWiseLectureCount[$value["sectionid"]]) * 100;
                                                    
                                                    $marksForAtt = 0;
                                                    if($attPercentage>75) {
                                                        $marksForAtt = ceil(( ($attPercentage - 75) / 5 ) + 1);
                                                    }

                                                    if(!$isSubmitted) {
                                                        $totalMarks = 0;
                                                    }
                                                    else {
                                                        $totalMarks = $avgMst + $assgn1 + $assgn2 + $marksForAtt;
                                                    }   

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $value["name"]; ?></td>
                                                        <td><?php echo $value["uniroll"]; ?></td>
                                                        <td><?php echo $value["classroll"]; ?></td>
                                                        <td><?php echo $section; ?></td>
                                                        <td><?php echo $mst1; ?></td>
                                                        <td><?php echo $mst2; ?></td>
                                                        <td><?php echo $avgMst; ?></td>
                                                        <td><?php echo $assgn1; ?></td>
                                                        <td><?php echo $assgn2; ?></td>
                                                        <td><?php echo $attPercentage; ?></td>
                                                        <td><?php echo $marksForAtt; ?></td>
                                                        <td><?php echo $totalMarks; ?></td>
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

                        <script>
                            
                            $("#depSelect").change(function() {
                                // alert('prakhar');
                                let val = $(this).val();
                                if(val) {
                                    enableDep(val);
                                }
                                else {
                                    $("#batchSelect").attr('disabled', '1');
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
                                        $("#batchSelect").text('');

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
                                                getDepartmentSubjects(depid);
                                            $("#batchSelect").removeAttr('disabled');
                                            $("#batchSelect").html(html);
                                        }
                                        else {$("#batchSelect").attr('disabled', '1');}
                                    }
                                }
                                else {
                                    $("#batchSelect").attr('disabled', '1');
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

                            <script>
                            async function getDepartmentSubjects(depid) {
                                let fd = new FormData();
                                fd.set('depid', depid);
                                <?php if($ut=="4") { ?>
                                    fd.set('tpp', "1");
                                <?php } ?>
                                let resp = await fetch(`../assets/backend/getDepartmentSubjects`, {
                                    method: "POST",
                                    body: fd,
                                });
                                if(resp.ok) {
                                    const data = await resp.text();
                                    if(data) {
                                        let subjectData = JSON.parse(data);
                                        let html = "<option value='' selected disabled>Select Subjects:</option>";
                                        $("#subjectSelect").text('');

                                        let sem = "0";

                                        for(let key in subjectData) {
                                            if(subjectData[key].subjectsem != sem) {
                                                html += `</optgroup>`;
                                                html += `<optgroup label='Sem: ${subjectData[key].subjectsem} '>`;
                                                sem = subjectData[key].subjectsem;
                                            }
                                            <?php if(isset($_GET['subject'])) { 
                                                ?>
                                                if(subjectData[key].subjectid=="<?php echo $_GET['subject'] ?>") {
                                                    html += `
                                                        <option value="${subjectData[key].subjectid}" selected>${subjectData[key].subjectname} - ${subjectData[key].subjectcode}</option>
                                                    `;
                                                    continue;
                                                }
                                                <?php
                                             } ?>
                                            html += `
                                                <option value="${subjectData[key].subjectid}" >${subjectData[key].subjectname} - ${subjectData[key].subjectcode}</option>
                                                `;
                                            }
                                        if(html) {
                                            console.log(html);
                                            $("#subjectSelect").removeAttr('disabled');
                                            $("#subjectSelect").html(html);
                                        }
                                        else {$("#subjectSelect").attr('disabled', '1');}
                                    }
                                }
                            }
                            </script>

                            <script>
                                $(document).ready(function() {
                                    // $('#subjectSelect').amsifySelect({
                                    //     searchable :true
                                    // });
                                });
                                

                            </script>

                        <!-- <script src="../assets/amsify/js/jquery.amsifyselect.js"></script>
<script>
    $(document).ready(function() {
        $("select[name='subject']").amsifySelect({
            searchable: true,
            type:'bootstrap'
        });
        // $("select[name='facultyId']")[0].style.display = "none";
    });
</script> -->

</body>
</html>