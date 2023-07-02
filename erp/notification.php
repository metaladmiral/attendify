<?php

session_start();
require_once 'conn.php';
$conn = new Db;

if($_SESSION['usertype']=="0") {
    $sql = "SELECT * FROM `history` a INNER JOIN `users` b ON a.`uid`=b.`uid` ";
    $query_ = $conn->mconnect()->prepare($sql);
    $query_->execute();
}
else {
    $sql = "SELECT * FROM `history` a INNER JOIN `users` b ON a.`uid`=b.`uid` WHERE a.`uid`=? ";
    $query_ = $conn->mconnect()->prepare($sql);
    $query_->execute([$_SESSION['uid']]);
}
$data = $query_->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Notification</title>
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
                            <h1 class="page-title">Notification</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Notification</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->
                        <?php 
                        if($query_->rowCount()==0) {
                            ?>
                            <center>
                            <div class="col-md-4 col-xl-4">
                                <div class="card text-white bg-danger">
                                    <div class="card-body">
                                        <h4 class="card-title">No Data Available</h4>
                                        <p class="card-text">No Previous History found.</p>
                                    </div>
                                </div>
                            </div>
                            </center>
                            <?php
                        }else {
                        ?>
                        <div class="container">
                            <ul class="notification">
                                <?php
                                foreach ($data as $key => $value) {
                                    $date = Date("d M, y", $value['time']);
                                    $time = Date("h:i A", $value['time']);
                                    if(empty($value["profilepic"]) || is_null($value["profilepic"])) {
                                        $ppic = "male_avatar.png";
                                    }
                                    else {
                                        $ppic = $value["profilepic"];
                                    }
                                    ?>
                                    <li>
                                        <div class="notification-time">
                                            <span class="date"><?php echo $date; ?></span>
                                            <span class="time"><?php echo $time; ?></span>
                                        </div>
                                        <div class="notification-icon">
                                            <a href="javascript:void(0);"></a>
                                        </div>
                                        <div class="notification-time-date mb-2 d-block d-md-none">
                                            <span class="date"><?php echo $date; ?></span>
                                            <span class="time ms-2"><?php echo $time; ?></span>
                                        </div>
                                        <div class="notification-body">
                                            <div class="media mt-0">
                                                <div class="main-avatar avatar-md online">
                                                    <img alt="avatar" class="br-7" src="../assets/profilepics/<?php echo $ppic; ?>" style='object-fit:cover;'>
                                                </div>
                                                <div class="media-body ms-3 d-flex">
                                                    <div class="">
                                                        <p class="fs-15 text-dark fw-bold mb-0"><?php echo $value['username']; ?></p>
                                                        <p class="mb-0 fs-13 text-dark"><?php echo $value['username']." ".$value["mess"]; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                               
                            </ul>
                            <?php if($query_->rowCount()>25) { ?>
                            <div class="text-center mb-4">
                                <button class="btn ripple btn-primary w-md">Load more</button>
                            </div>
                            <?php } ?>
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
</body>
</html>