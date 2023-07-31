<?php 
session_start();
require_once 'conn.php';
$conn = new Db;
if($_SESSION['usertype']=='1') {
    header('Location: ./dashboard-superadmin');
}
else if($_SESSION['usertype']=='2') {
    header('Location: ./user-dashboard');
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
                            <h1 class="page-title">Dashboard</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">CC Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <?php
                        if(count($data)) {
                            foreach ($data as $key => $value) {
                                $sectionInfo = explode('-', $value);
                                ?>
                                <div class="col-12 <?php echo $key.$value; ?> ">
                                    <div class="card card-collapsed">
                                        <div class="card-header">
                                            <h3 class="card-title"><?php echo $batchData[$key]; ?> (section: <?php echo chr($sectionInfo[0]+64).$sectionInfo[1]; ?>)</h3>
                                            <div class="card-options">
                                                <a href="javascript:void(0)" class="card-options-collapse" onclick='getStudentDetails(this, "<?php echo $key; ?>", "<?php echo $value; ?>");'data-bs-toggle="card-collapse" data-loadedRecords="0" ><i class="fe fe-chevron-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="spinner-grow text-primary me-2 loader" style="width: 3rem; height: 3rem;" role="status"></div>
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap border-bottom key-buttons" id="file-datatable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Actions</th>
                                                                        <th>Name</th>
                                                                        <th>Mst 1</th>
                                                                        <th>Assignment 1</th>
                                                                        <th>Mst 2</th>
                                                                        <th>Assignment 2</th>
                                                                        <th>Average Marks</th>
                                                                        <th>Total Attendance</th>
                                                                        <th>Total Internal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class='student-table-body'>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }else {
                            ?>
                            <span class="text-danger">You are not assigned as CC for any sections.</span>
                            <?php
                        }

                        ?>
            
                        <!-- BODY CONTENT END -->
                        
                    </div>
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->
        </div>
     <!-- FOOTER -->
    <?php include 'footer.php' ?>

    <script>

        let studentDetailsOffset = 0;
        function getStudentDetails(e, batchid, sectionid) {
            if($(e).attr('data-loadedRecords')=="0") {
                $(e).attr('data-loadedRecords', "1");
                // $(".student-records")[0].style.display = "block";

                let fd = new FormData();
                fd.set("offset", studentDetailsOffset);
                fd.set("batchid", batchid);
                fd.set("sectionid", sectionid);

                fetch('../assets/backend/getStudentRecords', {
                    method: 'POST',
                    body: fd
                })
                .then(function (response) {
                    if (response.ok) {
                        return response.text(); 
                    }
                    throw new Error('Network response was not OK');
                })
                .then(function (data) {
                    processStudentDetails(batchid, sectionid, data);
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });
            }
        }

        function processStudentDetails(batchid, sectionid, data) {
            data = JSON.parse(data);
            for(const key in data) {
                data[key].marks = JSON.parse(data[key].marks);
                
                let avgMarks = 0;
                let finalMarks = 0;

                if(data[key].marks.phase1.mst==null) {
                    data[key].marks.phase1.mst = 0;
                } 
                if(data[key].marks.phase1.assign==null) {
                    data[key].marks.phase1.assign = 0;
                } 

                if(data[key].marks.phase2.mst==null) {
                    data[key].marks.phase2.mst = 0;
                } 
                if(data[key].marks.phase2.assign==null) {
                    data[key].marks.phase2.assign = 0;
                }        

                avgMarks = (parseInt(data[key].marks.phase1.mst) + parseInt(data[key].marks.phase1.assign) + parseInt(data[key].marks.phase2.mst) + parseInt(data[key].marks.phase2.assign))/4;
                data[key].marks['avgMarks'] = avgMarks;

                if(data[key].totalattendance>75 && data[key].totalattendance<=80) {
                    finalMarks += 5;
                }

                finalMarks += avgMarks;

                data[key]['totalInternal'] = finalMarks;

            }
            showStudentDetails(batchid, sectionid, data);
        }

    </script>
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

    <script>
        
        function showStudentDetails(batchid, sectionid, data) {
            $("."+batchid+sectionid+" .student-table-body")[0].innerHTML = "";
            let html = "";
            for(const key in data) {
                html += `<tr>
                <td>${parseInt(key)+1}</td>
                <td><i onclick="window.location = 'edit-student.php?sid=${data[key].studid} ' " class="fa fa-edit" data-bs-toggle="tooltip" title="fa fa-edit" style='font-size: 16px;cursor:pointer;'></i></td>
                <td>${data[key].name}</td>
                <td>${data[key].marks.phase1.mst}</td>
                <td>${data[key].marks.phase1.assign}</td>
                <td>${data[key].marks.phase2.mst}</td>
                <td>${data[key].marks.phase2.assign}</td>
                <td>${data[key].marks.avgMarks}</td>
                <td>${data[key].totalattendance}</td>
                <td>${data[key].totalInternal}</td>
                </tr>`;
            }
            $("."+batchid+sectionid+" .loader")[0].style.display = "none";
            $("."+batchid+sectionid+" .student-table-body")[0].innerHTML += html;
            $("."+batchid+sectionid+" #file-datatable").DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
                ]
            } );
        }

    </script>
</body>
</html>