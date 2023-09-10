<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$sql = "SELECT collegeid, label FROM `colleges` ";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$clgDetails = $query->fetchAll(PDO::FETCH_KEY_PAIR);

$sql = "SELECT depid, label FROM `departments` ";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$depDetails = $query->fetchAll(PDO::FETCH_KEY_PAIR);

// var_dump($clgDetails);

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
    <script src="../assets/js/jquery.min.js"></script>
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
                            <h1 class="page-title">Manage Subjects</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Superadmin</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Subjects</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add a Subject</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="../assets/backend/addSubject.php">
                                    
                                    <div class="">

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
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                            <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                            <label for="exampleInputEmail1" class="form-label">Department <sup class="text-danger">(Select College First)</sup></label>
                                            <select name="depid" id="depSelect" class="form-control form-select select2" onclick="" disabled="1" required>
                                                <option value="" selected disabled>Select Department</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Subject Code</label>
                                            <input name="code" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Subject Code" autocomplete="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label"> Subject Name</label>
                                            <input name="name" type="text" class="form-control" placeholder="Enter Subject Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1" class="form-label">Subject Sem</label>
                                            <select name="sem" class="form-control" data-placeholder="Choose one" aria-hidden="true" required>
                                                <option value="" disabled selected>Select Subject Semester</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <button class="btn btn-primary mt-4 mb-0" type="submit" name="submit">Add Subject</button>
                                </form>

                                
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
                                    body: fd
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

                        <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Subjects</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered border text-nowrap mb-0" id="responsive-datatable">
                                                <thead>
                                                        <th>S. No.</th>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Subject Sem</th>
                                                        <th>College</th>
                                                        <th>Department</th>
                                                        <th name="bstable-actions">Actions</th>
                                                </thead>
                                                <tbody>
                                                    
                                                        <?php 
                                                        $sql = "SELECT subjectname as name, subjectid as id, subjectcode as code, subjectsem as sem,collegeid,depid FROM `subjects` ";
                                                        $query = $conn->mconnect()->prepare($sql);
                                                        $query->execute();
                                                        $row = $query->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($row as $key => $value) {
                                                            ?>

                                                                <tr style='position:relative;'>
                                                                <td><?php echo ($key+1); ?></td>
                                                                <td><?php echo $value["code"]; ?></td>
                                                                <td><?php echo $value["name"]; ?></td>
                                                                <td><?php echo $value["sem"]; ?></td>
                                                                <td><?php echo $clgDetails[$value["collegeid"]]; ?></td>
                                                                <td><?php echo $depDetails[$value["depid"]]; ?></td>
                                                                <td name="bstable-actions"><div class="btn-list">
                                                                <button id="bEdit" type="button" class="btn btn-sm btn-primary" onclick="window.location = 'edit-subject?sid=<?php echo $value['id']; ?>';">
                                                                    <span class="fe fe-edit"> </span>
                                                                </button>
                                                                <button type="button" onclick="deleteSubject('<?php echo $value['id']; ?>')" class="btn btn-sm btn-danger"><span class="fe fe-trash-2"></span></button>
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
                                    function deleteSubject(subjectid) {
                                        if(!confirm("Are you sure to delete the subject?")) {
                                            return ;
                                        }
                                        window.location = "../assets/backend/deleteSubject?subjectid="+subjectid;
                                    }
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
                                                    showCancelButton: false
                                                });
                                            }
                                            }
                                        };
                                        var formdata= new FormData();
                                        formdata.set("uid", uid);
                                        xhttp.open("POST", "../assets/backend/deleteUser.php");
                                        xhttp.send(formdata);
                                    }
                                    function changeActive(uid, e) {
                                        let state;
                                        if($(e)[0].getAttribute('data-checked')=="1") {
                                             state="0";
                                             $(e)[0].setAttribute('data-checked', "0");
                                            }else {
                                                state="1";
                                                $(e)[0].setAttribute('data-checked', "1");
                                        }
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                            // document.getElementById("demo").innerHTML = xhttp.responseText;
                                            if(xhttp.responseText=="1") {
                                                if(state=="0") {
                                                    swal('Operation Successfull!', 'User state changed to inactive!', 'success');
                                                }
                                                else {
                                                    swal('Operation Successfull!', 'User state changed to active!', 'success');
                                                }
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
                                        formdata.set("state", state);
                                        formdata.set("uid", uid);
                                        xhttp.open("POST", "../assets/backend/changeActive.php");
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
    

    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="../assets/js/sweet-alert.js"></script>
    <?php if(isset($_SESSION['message'])) {
        if($_SESSION['message']=="1") {
            ?>
            <script>swal('Congratulations!', 'New Subject has been added!', 'success');</script>
            <?php
        }else {
            ?>
            <script>
                swal({
                    title: "Alert",
                    text: "Addition was unsuccessfull!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
                </script>
            <?php
        }
        unset($_SESSION['message']);
    } ?>
    
    <?php if(isset($_SESSION['messageDel'])) {
        if($_SESSION['messageDel']=="1") {
            ?>
            <script>swal('Operation Successfull!', 'Subject Has Been Deleted!', 'success');</script>
            <?php
        }else {
            ?>
            <script>
                swal({
                    title: "Alert",
                    text: "Deletion was unsuccessfull! Contact Admin",
                    type: "warning"
                });
                </script>
            <?php
        }
        unset($_SESSION['messageDel']);
    } ?>
    
</body>
</html>