<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$uid = $_GET['uid'];
if(!empty($uid)) {
    $sql = "SELECT * FROM `users` WHERE `uid`='$uid' ";
    $query = $conn->mconnect()->prepare($sql);
    $query->execute();
    if($query->rowCount()>0) {
        $row = $query->fetchAll(PDO::FETCH_ASSOC)[0];
        $collegeids = json_decode($row['collegeid'], true);
        $depids = json_decode($row['depid'], true);
    }
    else {
        header('Location: ../404.php');
    }
}
else {
header('Location: ../404.php');
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
                            <h1 class="page-title">Edit User</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Superadmin</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit a User</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="../assets/backend/updateuser.php">
                                    <div class="">
                                        <input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>">

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1" class="form-label">Select Colleges: </label>
                                                <select name="collegeid[]" id="collegeSelect" class="form-control form-select select2" multiple required>    

                                                    <?php
                                                    $sql = "SELECT collegeid, label FROM `colleges`";
                                                    $query = $conn->mconnect()->prepare($sql);
                                                    $query->execute();
                                                    $row_ = $query->fetchAll(PDO::FETCH_KEY_PAIR);
                                                    foreach ($row_ as $key => $value) {
                                                        if(in_array($key, $collegeids)) {
                                                        ?>
                                                            <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
                                                            <?php
                                                        }
                                                        else {
                                                            ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1" class="form-label">Select Departments: <sup class="text-danger">(Select College First)</sup></label>
                                                <select name="depid[]" id="depSelect" class="form-control form-select select2" onclick="" disabled="1" multiple required>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Employ ID</label>
                                            <input value="<?php echo $row['empid']; ?>" name="empid" type="number" class="form-control" id="exampleInputEmail1" placeholder="Enter Employ ID">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Email Address</label>
                                            <input value="<?php echo $row['email']; ?>" name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" autocomplete="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label"> Full Name</label>
                                            <input value="<?php echo $row['username']; ?>" name="fullname" type="text" class="form-control" placeholder="Enter Full Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="new-password">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">User Type</label>
                                            <select name="usertype" class="form-control" data-placeholder="Choose one" aria-hidden="true">
                                                    <!-- <option label="Choose one">
                                                    </option> -->
                                                    <option value="1" <?php echo ($row['usertype']=="1") ? "selected" : ""; ?>>Superadmin</option>
                                                    <option value="2" <?php echo ($row['usertype']=="2") ? "selected" : ""; ?>>Faculty</option>
                                                    <option value="3" <?php echo ($row['usertype']=="3") ? "selected" : ""; ?>>HOD</option>
                                                    <option value="4" <?php echo ($row['usertype']=="4") ? "selected" : ""; ?>>TPP HOD</option>
                                                </select>
                                        </div>
                                        
                                    </div>
                                    <button class="btn btn-primary mt-4 mb-0" type="submit" name="submit">Update</button>
                                </form>

                                
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
    

    <script>
                            
                            $("#collegeSelect").change(function() {

                                let val = $(this).val();
                                if(val.length) {
                                    enableDep(JSON.stringify(val));
                                }
                                else {
                                    $("#depSelect").attr('disabled', '1');
                                    // $("#depSelect").html("<option value='' selected disabled>Select Department</option>");
                                }
                            });
                            async function enableDep(collegeids) {
                                let fd = new FormData();
                                fd.set('collegeids', collegeids);
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
                                        // let html = "<option value='' selected disabled>Select Department</option>";
                                        let html = "";
                                        $("#depSelect").text('');
                                        let depids = [<?php echo "'".implode("', '",$depids)."'"; ?>];
                                        for(let key in depData) {
                                            if(depids.includes(depData[key].depid)) {
                                                html += `
                                                    <option value="${depData[key].depid}" selected>${depData[key].depLabel} - ${depData[key].clgLabel}</option>
                                                `;
                                                continue;
                                            }
                                            html += `
                                                <option value="${depData[key].depid}">${depData[key].depLabel} - ${depData[key].clgLabel}</option>
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

    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="../assets/js/sweet-alert.js"></script>
    <?php if(isset($_SESSION['message'])) {
        if($_SESSION['message']=="1") {
            ?>
            <script>

            swal({
                title: "Hooray!",
                text: "User has been updated!",
                type: "success",
                timer: 3500,
                showCancelButton: false
            }, function(){window.location='manage-users.php'});

            </script>
            <?php
        }else {
            ?>
            <script>
                swal({
                    title: "Oops!",
                    text: "Updation was unsuccessfull! Please contact administrator",
                    type: "warning",
                    showCancelButton: false
                });
                </script>
            <?php
        }
        unset($_SESSION['message']);
    } ?>
    
</body>
</html>