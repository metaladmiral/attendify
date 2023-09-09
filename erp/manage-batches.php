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
                            <h1 class="page-title">Manage Batches</h1>
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
                                <h4 class="card-title">Add New Batch</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="../assets/backend/addBatch.php">
                                    <input type="hidden" name="deps" value="">
                                    <div class="row">
                                        
                                        <div class="form-group col-3">
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
                                            <input type="hidden" name="colleges" value="<?php echo base64_encode(json_encode($row)); ?>">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="exampleInputEmail1" class="form-label">Department <sup class="text-danger">(Select College First)</sup></label>
                                            <select name="depid" id="depSelect" class="form-control form-select select2" onclick="" disabled="1" required>
                                                <option value="" selected disabled>Select Department</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="" class="form-label">Course</label>
                                            <select name="course" id="" class="form-control" required>
                                                <option value="" selected disabled>Select Course</option>
                                                <option value="B.Tech">B.Tech</option>
                                                <option value="M.Tech">M.Tech</option>
                                                <option value="MCA">MCA</option>
                                                <option value="MBA">MBA</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="exampleInputEmail1" class="form-label">Batch Session</label>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <!-- <input type="number" class="form-control col-12" placeholder="Start" name="startDate" min="1995" max="2500" id="" required> -->
                                                    <select name="startDate" id="" class="form-control col-12" required>
                                                            <option value="" disabled selected>Start</option>
                                                        <?php
                                                        for($i=2020;$i<=2027;$i++) {
                                                            ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <!-- <input type="number" class="form-control col-12" placeholder="End" name="endDate" min="1995" max="2500" id="" required> -->
                                                    <select name="endDate" id="" class="form-control col-12" required>
                                                        <option value="" disabled selected>End</option>
                                                           <?php
                                                           for($i=2020;$i<=2027;$i++) {
                                                            ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php
                                                           }
                                                           ?>         
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <button class="btn btn-primary mt-4 mb-0" type="submit" name="submit">Add</button>
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
                                        $("input[name='deps']")[0].value = data;
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
                                        <h3 class="card-title">Edit Batches</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap border-bottom" id='basic-datatable'>
                                                <thead>
                                                    <tr>
                                                        <th>Batch ID</th>
                                                        <th>Batch Name</th>
                                                        <th>Current HOD</th>
                                                        <th>Applied Science</th>
                                                        <th name="bstable-actions">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <script>
                                                    async function toggleDep(batchid, appliedDepId, toApplied) {
                                                        if(confirm("Are you sure to toggle the department to Applied Science?")) {
                                                            const url = "../assets/backend/toggleDepartment";
                                                            const formData = new FormData();

                                                            formData.append("batchid", batchid);
                                                            formData.append("appliedDepId", appliedDepId);
                                                            formData.append("toApplied", toApplied);

                                                            try {
                                                                const response = await fetch(url, {
                                                                    method: "POST",
                                                                    body: formData,
                                                                });

                                                                if (response.ok) {
                                                                    const data = await response.json();
                                                                    console.log("Response data:", data);
                                                                    location.reload();
                                                                } else {
                                                                    console.error("Request failed with status:", response.status);
                                                                    return false;
                                                                }
                                                            } catch (error) {
                                                                return false;
                                                                console.log("An error occurred:", error);
                                                            }
                                                        }
                                                        else {
                                                            return false;
                                                        }
                                                    }
                                                </script>
                                                    
                                                        <?php 
                                                        $sql = "SELECT * FROM `batches`";
                                                        $query = $conn->mconnect()->prepare($sql);
                                                        $query->execute();
                                                        $row = $query->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($row as $key => $value) {
                                                            $rand = uniqid();
                                                            $depid = $value["depid"];
                                                            $collegeid = $value["collegeid"];
                                                            
                                                            $sql = "SELECT username FROM `users` WHERE `usertype`='3' AND MATCH(`depid`) AGAINST ('$depid' IN BOOLEAN MODE) ";
                                                            $query = $conn->mconnect()->prepare($sql);
                                                            $query->execute();
                                                            $hod = $query->fetch(PDO::FETCH_COLUMN);
                                                            if(!$hod)  {$hod="<span class='text-danger'>NA</span>";}
                                                            ?>

                                                                <tr style='position:relative;'>
                                                                <td><?php echo $value["batchid"]; ?></td>
                                                                <td><?php echo $value["batchLabel"]; ?></td>
                                                                <td><?php echo $hod; ?></td>
                                                                <td>
                                                                    <div class="material-switch">
                                                                        <input id="toggleDep_<?php echo $rand; ?>" name="someSwitchOption001" type="checkbox"
                                                                        <?php if(gettype(array_search($depid, array("asd12a", "asdaqwe123")))=="integer") { $toApplied="0"; echo "checked"; }else {$toApplied = "1";} ?>
                                                                        <?php if($collegeid == "64ed7eada8d43") {$appliedDepId = "asdaqwe123"; }else {$appliedDepId = "asd12a";} ?>
                                                                        onchange="toggleDep('<?php echo $value["batchid"] ?>', '<?php echo $appliedDepId; ?>', '<?php echo $toApplied; ?>');"
                                                                        >
                                                                        <label for="toggleDep_<?php echo $rand; ?>" class="label-primary"></label>
                                                                    </div>
                                                                
                                                                </td>
                                                                <td name="bstable-actions"><div class="btn-list">
                                                                <button id="bEdit" type="button" class="btn btn-sm btn-primary" onclick="window.location = 'edit-batch.php?batchid=<?php echo $value['batchid']; ?>';">
                                                                    <span class="fe fe-edit"> </span>
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
                                    function deleteBatch(batchid, e) {
                                        $(e)[0].offsetParent.offsetParent.style.display = "none";
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                            // document.getElementById("demo").innerHTML = xhttp.responseText;
                                            if(xhttp.responseText=="1") {
                                                swal('Operation Successfull!', 'Batch has been deleted!', 'success');
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
                                        formdata.set("batchid", batchid);
                                        xhttp.open("POST", "../assets/backend/deleteBatch.php");
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
    <script src="../assets/js/custom-swicher.js"></script>
    <!-- Switcher js -->
    <script src="../assets/switcher/js/switcher.js"></script>

    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="../assets/js/sweet-alert.js"></script>
    <?php if(isset($_SESSION['message'])) {
        if($_SESSION['message']=="1") {
            ?>
            <script>swal('Congratulations!', 'New Batch has been added!', 'success');</script>
            <?php
        }else {
            ?>
            <script>
                swal({
                    title: "Alert",
                    text: "Operation was unsuccessfull!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
                </script>
            <?php
        }
        unset($_SESSION['message']);
    } ?>

    <script>
        $("#dtable").DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "bInfo": false
        });
    </script>
    
</body>
</html>