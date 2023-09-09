<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$ut = $_SESSION['usertype'];
if($ut=="3") {
    $collegeid = $_SESSION['collegeid'];
    $depid = json_decode($_SESSION['depid'], true);
    $depidFT = implode(" OR ", $depid);
    $depidin = "'".implode("', '", $depid)."'";
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
                            <h1 class="page-title">Student Records</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Student Records</li>
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

                                    <form action="" onsubmit="getStudentDetails(this);return false;">
                                        <?php if($ut=="4") { ?>
                                            <input type="hidden" value="1" name="tpp">
                                        <?php } ?>
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">Select Department: </label>
                                                    <select name="depid" id='depSelect' class="form-control form-select select2" data-placeholder="Choose One" tabindex="-1" aria-hidden="true" required>
                                                            <option value="" disabled selected>Select Department</option>
                                                            <?php 
                                                            if($ut=="4" || $ut=="1") { 
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid`!='tpp765'";
                                                            }else{
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid` IN ($depidin) AND a.`depid`!='tpp765'" ;
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
                                                <div class="col-3">
                                                    <label for="" class="form-label">Select Batch: <sup class="text-danger">(Select Department First)</sup></label>
                                                    <select name="batch" id='batchid' class="form-control form-select select2" data-placeholder="Choose One" tabindex="-1" required disabled>
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
                                                <div class="col-3">
                                                    <label for="" class="form-label">Select Section:</label>
                                                    <select name="section" id='sectionid' class='form-control form-select select2' id="">
                                                        <option value="" selected disabled>Select Section</option>
                                                        <?php
                                                            for($i=65;$i<=74;$i++) {
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
                                                <div class="col-3">
                                                    <label for="" class="form-label">Select Semester:</label>
                                                    <select name="sem" id='sem' class='form-control form-select select2' id="">
                                                        <option value="" selected disabled>Select Semester</option>
                                                        <?php
                                                            for($i=1;$i<=8;$i++) {
                                                                ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class='btn btn-primary'>Get Student Records</button>
                                        </div>
                                            
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 student-records" style='display:none;'>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Students Found</h3>
                                    <div class="card-options">
                                        <a href="javascript:void(0)" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="spinner-grow text-primary me-2 loader" style="width: 3rem; height: 3rem;" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="data-records" style='display:none;'>
                                        <div class=col-12>
                                            <div class=card>
                                                <div class=card-body>
                                                    <div class=table-responsive>
                                                    <table id='file-datatable' data-init="0" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                        <thead>
                                                            <tr class='subjectsColumns'>
                                                                
                                                            </tr>
                                                            <tr class='subjectsSubColumns'>
                                                                
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

    <script>
        let studentDetailsOffset = 0;
        async function getStudentDetails(e) {

            $(".student-records")[0].style.display = "block";
            $(".loader")[0].style.display = "block";
            
            let batchid = $("#batchid").val();
            let sectionid = $("#sectionid").val();
            
            let subjectDetails;

            let fd2 = new FormData();
            fd2.set('sem', $("select[name='sem']")[0].value);
            fd2.set("batchid", batchid);
            <?php if($ut=="4") { ?>
                fd2.set("tpp", "1");
            <?php } ?>
            let resp = await fetch('../assets/backend/getSubjects', {
                method: 'POST',
                body: fd2
            });
            
            if(resp.ok) {
                let data = await resp.text();
                subjectDetails = data;
            }
            
            let fd = new FormData();
            fd.set("offset", studentDetailsOffset);
            fd.set("batchid", batchid);
            fd.set("sectionid", sectionid);

            fetch('../assets/backend/getStudentRecords?subjects=true', {
                method: 'POST',
                body: fd
            })
            .then(function (response) {
                if (response.ok) {
                    return response.text(); 
                }
                throw new Error('Network response was not OK');
            })
            .then(function (data_) {
                processStudentDetails(data_, subjectDetails);
            })
            .catch(function (error) {
                console.error('Error:', error);
            });

        }
        
        function processStudentDetails(data, subjectDetails) {
            console.log(data);
            data = JSON.parse(data);
            if(subjectDetails!==0 && subjectDetails!==undefined) {
                subjectDetails = JSON.parse(subjectDetails);
            }
            else {
                subjectDetails = [];   
            }
            showStudentDetails(data, subjectDetails);
        }

        function showStudentDetails(data, subjectDetails) {
            
            $("#file-datatable").remove();
            $(".table-responsive")[0].innerHTML = `<table id='file-datatable' data-init="0" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                        <thead>
                                                            <tr class='subjectsColumns'>
                                                                
                                                            </tr>
                                                            <tr class='subjectsSubColumns'>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody class='student-table-body'>
                                                        </tbody>
                                                    </table>`;


            let subjectHTML = `<th width="1">Actions</th><th width="1">Name</th>`;
            let subjectSubHTML = "<th></th><th></th>";

            for(const key in subjectDetails) {
                let subject = subjectDetails[key];
                subjectHTML += `
                                                        
                <th colspan="5">
                    ${subject.subjectname}
                </th>
                `;
                subjectSubHTML += `
                    <th>MST 1</th>
                    <th>ASSGN 1</th>
                    <th>MST 2</th>
                    <th>ASSGN 2</th>
                    <th>AVG</th>
                `;
            }
            $(".subjectsColumns")[0].innerHTML = subjectHTML;
            if(subjectSubHTML) {
                $(".subjectsSubColumns")[0].innerHTML = subjectSubHTML;
            }
            else {
                $(".subjectsSubColumns")[0].remove();
            }
            // consol.elog(subjectHTML);

            let html = "";
            for(const key in data) {
                let studDetails = data[key];
                let marks;
                if(studDetails.marks!==undefined) {
                    marks = JSON.parse(studDetails.marks);
                }
                else {
                    marks = [];
                }
                html += `<tr>
                <td><i onclick="window.location = 'edit-student.php?sid=${data[key].studid} ' " class="fa fa-edit" data-bs-toggle="tooltip" title="fa fa-edit" style='font-size: 16px;cursor:pointer;'></i></td>
                <td>${data[key].name}</td>
                `;
                for(const skey in subjectDetails) {
                    let subjectid = subjectDetails[skey].subjectid;
                    if(marks[subjectid]==undefined) {
                        html += `
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        `;
                    }
                    else {
                        let allMarks = marks[subjectid];
                        let avgMarks;
                        if(allMarks.mst1!='NA' && allMarks.mst1!='NA' && allMarks.mst2!='NA' && allMarks.assgn2!='NA'){
                            avgMarks = ((parseInt((allMarks.mst1)) + parseInt((allMarks.assgn1)) +parseInt((allMarks.mst2)) +parseInt((allMarks.assgn2))) / 4 )
                        }
                        else {
                            avgMarks = 'NA';
                        }
                        html += `
                        <td>${allMarks.mst1}</td>
                        <td>${allMarks.assgn1}</td>
                        <td>${allMarks.mst2}</td>
                        <td>${allMarks.assgn2}</td>
                        <td>${ avgMarks }</td>
                        `;
                    }
                }
                html += `</tr>`;
                
            }
            $(".loader")[0].style.display = "none";
            $(".data-records")[0].style.display = "block";
            $(".student-table-body")[0].innerHTML += html;
            if($("#file-datatable").attr('data-init')=="0") {
                console.log($("#file-datatable").html());
                $("#file-datatable").DataTable( {
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf'],
                    "bInfo": false,
                    "pageLength": 50
                } );
                $("#file-datatable").attr('data-init', '1');
            }
        }

    </script>

<script>
                            
                            $("#depSelect").change(function() {
                                // alert('prakhar');
                                let val = $(this).val();
                                if(val) {
                                    enableDep(val);
                                }
                                else {
                                    $("#batchid").attr('disabled', '1');
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
                                        $("#batchid").text('');

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
                                            $("#batchid").removeAttr('disabled');
                                            $("#batchid").html(html);
                                        }
                                        else {$("#batchid").attr('disabled', '1');}
                                    }
                                }
                                else {
                                    $("#batchid").attr('disabled', '1');
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

</body>
</html>