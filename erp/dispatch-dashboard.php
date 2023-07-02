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

$sql = "SELECT * FROM `instalments` WHERE `status`='0' ";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$dataInst= $query->fetchAll(PDO::FETCH_ASSOC);

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

    $sql = "SELECT * FROM `students` WHERE `batchid` IN ($batches) AND `counsid` IN ($couns)";
    // if(!isset($_POST['extfilters']) && empty($_POST['extfilters'])) {
    //     $sql .= " 1";
    // }else {
    //     $sql .= " 1";
    //     // $sql .= " `totalleft`>=".$_POST['extfilters'];
    // }
    // echo $sql;
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

    $sql = "SELECT * FROM `students` WHERE `batchid`='$bat' AND `counsid`='$couns'";
    // if(!isset($_POST['extfilters']) && empty($_POST['extfilters'])) {
    //     $sql .= " 1";
    // }else {
    //     $sql .= " `totalleft`>=".$_POST['extfilters'];
    // }
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
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
                                            <button class='btn btn-primary' type="submit">Apply Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                        

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
                                            <table id="responsive-datatable" class="table table-striped table-bordered dt-responsive nowrap">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">S. No</th>
                                                        <th class="border-bottom-0">Actions</th>
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Email</th>
                                                        <th class="border-bottom-0">Student Id</th>
                                                        <th class="border-bottom-0">Batch</th>
                                                        <th class="border-bottom-0">Counsellor</th>
                                                        <th class="border-bottom-0">Dispatch</th>
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

                                                            $dispatch = json_decode($value['dispatch'], true);

                                                            ?>
                                                            <tr>
                                                            <td><?php echo $key+1; ?></td>
                                                            <td><button id="bEdit" onclick='window.location = "./edit-student.php?sid=<?php echo $value["studid"]; ?>"' type="button" class="btn btn-sm btn-primary"><span class="fe fe-edit"> </span></button></td>
                                                            <td><?php echo $value['name']; ?></td>
                                                            <td><?php echo $value['email']; ?></td>
                                                            <td><?php echo $value['studid']; ?></td>
                                                            <td><?php echo $value['batchid']; ?></td>
                                                            <td><?php echo $value['counsid']; ?></td>
                                                            <td>
                                                                <?php 
                                                                foreach ($dispatch as $keya => $valuea) {
                                                                    $types = array("Registered Speed Post", "By Hand", "Courier");
                                                                    ?>
                                                                    <div style='display:flex'>
                                                                        <label for="" class="form-label"><?php echo $keya+1; ?>.</label>
                                                                        <div style='display:flex;width: auto;align-items:center;justify-content:center;margin-left: 5px;margin-right: 5px;'><label for="" class="form-label">Track ID: </label><span style='margin-left: 5px;'><?php echo $valuea["trackid"]; ?></span></div>
                                                                        <div style='display:flex;width: auto;align-items:center;justify-content:center;margin-left: 5px;margin-right: 5px;'><label for="" class="form-label">Type: </label><span style='margin-left: 5px;'><?php echo $types[((int) $valuea["distype"])]; ?></span></div>
                                                                        <div style='display:flex;width: auto;align-items:center;justify-content:center;margin-left: 5px;margin-right: 5px;'><label for="" class="form-label">Date: </label><span style='margin-left: 5px;'><?php echo $valuea["date"]; ?></span></div>
                                                                        <div style='display:flex;width: auto;align-items:center;justify-content:center;margin-left: 5px;margin-right: 5px;'><label for="" class="form-label">Remarks: </label><span style='margin-left: 5px;'><?php echo $valuea["remarks"]; ?></span></div>
                                                                        <div style='display:flex;width: auto;align-items:center;justify-content:center;margin-left: 5px;margin-right: 5px;'><label for="" class="form-label">Receipt: </label>
                                                                        <?php if($valuea["receipt"]!="-") { ?> 
                                                                            <a download="true" href="./disdocs/<?php echo $valuea['receipt']; ?>"><span style='margin-left: 5px;' class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a>    
                                                                        <?php }else {
                                                                            ?>
                                                                            <span style='margin-left: 5px;'>-</span>
                                                                            <?php
                                                                        } ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
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

                        <script>
                            function approveInst(instId, e) {
                                $(e)[0].offsetParent.offsetParent.style.display = "none";
                                var xhttp = new XMLHttpRequest();
                                let fd = new FormData();
                                fd.set('instId', instId);
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        let resp = this.responseText;
                                        console.log(resp);
                                        if(resp=="1") {
                                            swal('Hooray!', 'Instalment has been approved!', 'success');
                                        }else {
                                            swal({
                                                title: "Oops!",
                                                text: "Instalment was not approved due to some technical issues. Contact Website Admin.",
                                                type: "warning",
                                                showCancelButton: false
                                            });
                                        }
                                    }
                                };
                                xhttp.open("POST", "../assets/backend/approveInst.php");
                                xhttp.send(fd);
                            }
                        </script>
            
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