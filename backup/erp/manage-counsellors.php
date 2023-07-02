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
                            <h1 class="page-title">Manage Users</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Superadmin</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add a Counsellor</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="../assets/backend/adduser.php">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                                            <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" autocomplete="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="new-password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="new-password">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">User Type</label>
                                            <select name="usertype" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <!-- <option label="Choose one">
                                                    </option> -->
                                                    <option value="1">Operations</option>
                                                    <option value="2">Accounts</option>
                                                    <option value="3">Counsellor</option>
                                                    <option value="4">Dispatch</option>
                                                    <option value="5">Customer Support</option>
                                                </select>
                                        </div>
                                        
                                    </div>
                                    <button class="btn btn-primary mt-4 mb-0" type="submit" name="submit">Submit</button>
                                </form>

                                
                            </div>
                        </div>

                        <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Users</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered border text-nowrap mb-0" id="basic-edit">
                                                <thead>
                                                    <tr>
                                                        <th>First name</th>
                                                        <th>User Type</th>
                                                    <th name="bstable-actions">Actions</th></tr>
                                                </thead>
                                                <tbody>
                                                    
                                                        <?php 
                                                        $sql = "SELECT * FROM `users`";
                                                        $query = $conn->mconnect()->prepare($sql);
                                                        $query->execute();
                                                        $row = $query->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($row as $key => $value) {
                                                            ?>

                                                                <tr style='position:relative;'>
                                                                <td><?php echo $value["email"]; ?></td>
                                                                <?php 
                                                                $utype="";
                                                                switch ($value["usertype"]) {
                                                                    case '1':
                                                                        $utype = "Operations";
                                                                        break;
                                                                    
                                                                    case '2':
                                                                        $utype = "Accounts";
                                                                        break;
                                                                    case '3':
                                                                        $utype = "Counsellor";
                                                                        break;
                                                                    case '4':
                                                                        $utype = "Dispatch";
                                                                        break;
                                                                    case '5':
                                                                        $utype = "Customer Support";
                                                                        break;
                                                                    default:
                                                                        break;
                                                                }
                                                                ?>
                                                                <td><?php echo $utype; ?></td>
                                                                <td name="bstable-actions"><div class="btn-list">
                                                                <button id="bDel" type="button" onload='console.log(this)' onclick="deleteUser('<?php echo $value['uid']; ?>', this);" class="btn  btn-sm btn-danger">
                                                                    <span class="fe fe-trash-2"> </span>
                                                                </button>
                                                            </div></td>
                                                
                                                                </tr>

                                                            <?php
                                                        }
                                                        ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function deleteUser(uid, e) {
                                        $(e)[0].offsetParent.offsetParent.style.display = "none";
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                            // document.getElementById("demo").innerHTML = xhttp.responseText;
                                            if(xhttp.responseText=="1") {
                                                swal('Operation Successfull!', 'User has been deleted!', 'success');
                                            }
                                            else {
                                                swal({
                                                    title: "Alert",
                                                    text: "Operation was unsuccessfull!",
                                                    type: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Exit'
                                                });
                                            }
                                            }
                                        };
                                        var formdata= new FormData();
                                        formdata.set("uid", uid);
                                        xhttp.open("POST", "../assets/backend/deleteUser.php");
                                        xhttp.send(formdata);
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
    <?php if(isset($_SESSION['message'])) {
        if($_SESSION['message']=="1") {
            ?>
            <script>swal('Congratulations!', 'New User has been added!', 'success');</script>
            <?php
        }else {
            ?>
            <script>
                swal({
                    title: "Alert",
                    text: "Registeration was unsuccessfull!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
                </script>
            <?php
        }
        unset($_SESSION['message']);
    } ?>
    
</body>
</html>