<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

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
                            <h1 class="page-title">Subjects Bulk Upload</h1>
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
                                        <h3 class="card-title">Upload Subjects in Bulk</h3>
                                        <div class="card-options">
                                            <a href="./xlformats/subjects-bulk-format.xlsx" id='downloadFormat' class='btn btn-primary' download>Download</a>
                                        </div>
                                    </div>
                                    <form action="../assets/backend/add-Subjects-bulk.php" method="POST" id="studForm" enctype="multipart/form-data">
                                        <div class="card-body body1" style='display: block;'>

                                            <div class="form-group col-md-12">
                                                <div class="">
                                                    <input type="file" name="file" class="dropify excelData" data-bs-height="180">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary">Add Subjects</button>
                                            </div>

                                        </div>
                                        <div class="card-body card body2" style='display: none;'>
                                            <label for=""><b>Adding Subjects: </b></label>
                                            <div class="progress progress-md">
                                                <div class="progress-bar bg-primary prg" style="width: 0.1%;">0.1%</div>
                                            </div>
                                            <br>
                                            <span style='text-weight:bold;display: none;' class="text-success sedone">Subjects From Excel are successfully added.</span>
                                            <span style='text-weight:bold;display: none;' class="text-danger sefail">Process failed! Contact administrator.</span>
                                        </div>
                                    </form>
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

    <!-- FILE UPLOADES JS -->
    <script src="../assets/plugins/fileuploads/js/fileupload.js"></script>

    <!-- FORMELEMENTS JS -->
    <script src="../assets/js/formelementadvnced.js"></script>
    <script src="../assets/js/form-elements.js"></script>

    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="../assets/js/sweet-alert.js"></script>

    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop an excel file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong appended.'
            },
            error: {
                'fileSize': 'The file size is too big (2M max).'
            },
            allowedFileExtensions: ['xlsx', 'xlsb', 'xls' ,'pdf']
        });
            
    </script>

    <script>
        document.querySelector('#studForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const file = document.querySelector('.excelData').files[0];
            $(".body1")[0].style.display = "none";
            $(".body2")[0].style.display = "block";
            
            let currWidth = 0.1;
            let progressInterval = setInterval(() => {
                currWidth += 2.5;
                $(".prg")[0].setAttribute('style', 'width: '+currWidth.toString()+"%");
                $(".prg")[0].innerHTML = currWidth.toString()+" %";
            }, 1500);
            if(file) {

                let tmpXLName = "";

                let xml = new XMLHttpRequest();
                xml.onreadystatechange = function() {
                    if(this.readyState==4 && this.status==200) {
                        tmpXLName = this.responseText;
                    }
                }
                let fd = new FormData();
                fd.set('file', document.querySelector('.excelData').files[0]);
                xml.open("POST", "../assets/backend/add-studs-bulk.php", false);
                xml.send(fd);

                const worker = new Worker("uploadBulkSubjectWorker.js?v=0.1");
                worker.onmessage = (ef) => {
                    clearInterval(progressInterval);
                    $(".prg")[0].setAttribute('style', 'width: 100%');
                    $(".prg")[0].innerHTML = "100 %";
                    if(ef.data=="1"){
                        $(".sedone")[0].style.display = "block";
                    }else {
                        $(".sefail")[0].style.display = "block";
                    }
                }

                let data = {xlname: tmpXLName};
                worker.postMessage(JSON.stringify(data));

            }
            else {
                alert('Upload a File First!');
            }
            
        });
    </script>

</body>
</html>