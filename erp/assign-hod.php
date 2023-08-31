<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$showHODStatus = 0;

if(isset($_GET['collegeid']) && isset($_GET['depid'])) {
    $showHODStatus = 1;

    $collegeid = $_GET['collegeid'];
    $depid = $_GET['depid'];

    $query = $conn->mconnect()->prepare("SELECT uid, email, username FROM `users` WHERE MATCH(`depid`) AGAINST ('$depid' IN BOOLEAN MODE) AND `usertype`='3' ");
    $query->execute();
    if($query->rowCount()) {
         $details = $query->fetch(PDO::FETCH_ASSOC);
         $assignHodUid = $details["uid"];
         $hodemail = $details["email"];
         $hodusername = $details["username"];
    }
    else {
        $assignHodUid = null;
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
    <title>Attendify - HOD CGCcms.in</title>
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
                            <h1 class="page-title">Assign HOD</h1>
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
                                        
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1" class="form-label">College</label>
                                                <select name="collegeid" id="collegeSelect" class="form-control form-select select2" required>    
                                                    <option value="" selected disabled>Select College</option>
                                                    <?php
                                                    $sql = "SELECT collegeid, label FROM `colleges`";
                                                    $query = $conn->mconnect()->prepare($sql);
                                                    $query->execute();
                                                    $row = $query->fetchAll(PDO::FETCH_KEY_PAIR);
                                                    foreach ($row as $key => $value) {
                                                        ?>
                                                            <option value="<?php echo $key; ?>" <?php if(isset($_GET['collegeid'])) { if($_GET['collegeid']==$key) {echo "selected";} } ?>><?php echo $value; ?></option>
                                                            <?php
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="colleges" value="<?php echo base64_encode(json_encode($row)); ?>">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1" class="form-label">Department <sup class="text-danger">(Select College First)</sup></label>
                                                <select name="depid" id="depSelect" class="form-control form-select select2" onclick="" disabled="1" required>
                                                    <option value="" selected disabled><?php if(isset($_GET['depid'])) { echo "Department Selected"; } else {echo "Select Department";} ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class='btn btn-primary'>Get Details</button>
                                        </div>
                                            
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            
                            $("#collegeSelect").change(function() {
                                // alert('prakhar');
                                let val = $(this).val();
                                if(val) {
                                    let arr = [val];
                                    enableDep(JSON.stringify(arr));
                                }
                                else {
                                    $("#depSelect").attr('disabled', '1');
                                    // $("#depSelect").html("<option value='' selected disabled>Select Department</option>");
                                }
                            });
                            async function enableDep(collegeid) {
                                let fd = new FormData();
                                fd.set('collegeids', collegeid);
                                let resp = await fetch(`../assets/backend/getCollegeDepartments`, {
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
                                        let depData = JSON.parse(data);
                                        let html = "<option value='' selected disabled>Select Department</option>";
                                        $("#depSelect").text('');

                                        for(let key in depData) {
                                            <?php if(isset($_GET['depid'])) { 
                                                ?>
                                                if(depData[key].depid=="<?php echo $_GET['depid'] ?>") {
                                                    html += `
                                                        <option value="${depData[key].depid}" selected>${depData[key].depLabel} - ${depData[key].clgLabel}</option>
                                                    `;
                                                    continue;
                                                }
                                                <?php
                                             } ?>
                                            html += `
                                                <option value="${depData[key].depid}" >${depData[key].depLabel} - ${depData[key].clgLabel}</option>
                                            `;
                                        }
                                        if(html) {
                                            $("#depSelect").removeAttr('disabled');
                                            $("#depSelect").html(html);
                                        }
                                        else {$("#depSelect").attr('disabled', '1');}
                                    }
                                }
                                else {
                                    $("#depSelect").attr('disabled', '1');
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
                        
                        <?php if($showHODStatus) { ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Assign/Update</h3>
                                    <div class="card-options">
                                        <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="../assets/backend/changehod" method="POST">
                                        <input type="hidden" name="collegeid" value="<?php echo $_GET['collegeid']; ?>">
                                        <input type="hidden" name="depid" value="<?php echo $_GET['depid']; ?>">
                                    <?php
                                    
                                        if(!$assignHodUid) {
                                            ?>
                                            <b><label for="">HOD Assigned: </label></b> <span class='text-danger'>No</span>
                                            <br>
                                            <br>
                                            <label for="">Select HOD: </label>
                                            <br>

                                            <select name="hod" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" required>
                                                <option value="" disabled selected>Select HOD</option>
                                                <?php 
                                                   $sql = "SELECT uid, username, email FROM `users` WHERE `usertype`='3' ";
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
                                             <button class='btn btn-primary' type='submit' name='assignhod'>Assign HOD</button>
                                            <?php
                                        }
                                        else {
                                            ?>
                                            <b><label for=""> HOD Assigned: </label></b> <span class='text-success'>Yes</span> : <span class='currHODUsername'></span>
                                            <br>
                                            <br>
                                            <label for="">Select HOD: </label>
                                            <br>

                                            <input type="hidden" value="<?php echo $assignHodUid; ?>" name='prevhod'>

                                                <select name="hod" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true" required>
                                                    <option value="" disabled selected>Select HOD</option>
                                                    <?php 
                                                    $sql = "SELECT uid, username, email FROM `users` WHERE `usertype`='3' ";
                                                    $query = $conn->mconnect()->prepare($sql);
                                                    $query->execute();
                                                    $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($data as $key => $value) {
                                                            if($assignHodUid==$value["uid"]) {
                                                                ?>
                                                                 <option class='text-success' value="<?php echo $value['uid']; ?>"><?php echo $value['username']; ?> - <?php echo $value['email']; ?> &#x2022;</option>
                                                                <?php
                                                            }
                                                            else {
                                                                ?>
                                                                <option value="<?php echo $value['uid']; ?>"><?php echo $value['username']; ?> - <?php echo $value['email']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>

                                                <br>

                                                <button class='btn btn-primary' type='submit' name="updatehod">Update HOD</button>

                                                 <script>
                                                    document.querySelector(".currHODUsername").innerHTML = "(<?php echo $hodusername; ?> - <?php echo $hodemail; ?>)";
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
                swal('Hooray!', 'HOD Successfully assigned!', 'success');
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