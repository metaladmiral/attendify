<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$sql = "SELECT * FROM `batches` ORDER BY `id` DESC";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$dataBatch= $query->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM `subjects`";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
$dataSubjects= $query->fetchAll(PDO::FETCH_ASSOC);
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
    <title></title>
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
                            <h1 class="page-title">Attendance Bulk Upload</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Bulk Uploads</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Attendance</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Upload Attendance in Bulk</h3>
                                        <div class="card-options">
                                            <!-- <a href="./xlformats/marks-bulk-format.xlsx" id='downloadFormat' class='btn btn-primary' download>Download</a> -->
                                        </div>
                                    </div>
                                    <style>
                                        #select2-subjectSelect-results {
                                            max-height: 450px !important;
                                        }
                                        strong.select2-results__group {
                                            background: var(--gray-dark);
                                            color: white;
                                        }
                                    </style>
                                    <form action="../assets/backend/add-marks-bulk.php" method="POST" id="studForm" enctype="multipart/form-data">
                                        <div class="card-body body1" style='display: block;'>

                                                <div class="form-group col-md-12">
                                                    <label for="" class="form-label">Select Department: </label>
                                                    <select name="depid" id='depSelect' class="form-control form-select select2" data-placeholder="Choose One" tabindex="-1" aria-hidden="true" required>
                                                            <option value="" disabled selected>Select Department</option>
                                                            <?php 
                                                            if($ut=="4" || $ut=="1") { 
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid`!='tpp765' ";
                                                            }else {
                                                                $sql = "SELECT a.`label` as depLabel, b.`label` as clgLabel, a.`depid` as depid FROM `departments` a INNER JOIN `colleges` b ON a.`collegeid`=b.`collegeid` WHERE a.`depid` IN ($depidin) AND a.`depid`!='tpp765' " ;
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

                                            <div class="form-group col-md-12">
                                                <b><label for="batch">Select a Batch: <sup class="text-danger">(Select Department First)</sup></label></b>
                                                <select id='batchSelect' class='form-control form-select select2' name="batch" required disabled>
                                                <option value="" selected disabled>Select Batch</option>
                                                <?php 
                                                    
                                                    foreach ($dataBatch as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['batchid']; ?>"><?php echo $value["batchLabel"]; ?></option>
                                                        <?php 
                                                    }
                                                    
                                                ?>
                                                </select>

                                                <br>
                                                <br>

                                                <b><label for="batch">For: </label></b>
                                                <select id='for' class='form-control form-select select2' name="for" required>
                                                    <option value="" selected disabled>Select For: </option>
                                                    <option value="mst1">MST 1</option>
                                                    <option value="mst2">MST 2</option>
                                                    <option value="assgn1">ASSGN 1</option>
                                                    <option value="assgn2">ASSGN 2</option>
                                                </select>

                                                <br>
                                                <br>
                                                
                                                <button href="" class="btn-pill btn btn-info btn-sm" onclick="getAutoExcel();" type="button">Get Automated Student Excel</button>

                                                <br>
                                                <br>

                                                <b><label for="batch">Select Subject: <sup class="text-danger">(Select Department First)</sup></label></b>
                                                <select id='subjectSelect' class='form-control form-select select2' name="subject" required disabled>
                                                <option value="" selected disabled>Select Subject</option>
                                                <?php 
                                                    
                                                    foreach ($dataSubjects as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['subjectid']; ?>"><?php echo $value["subjectname"]; ?> - <?php echo $value["subjectcode"]; ?></option>
                                                        <?php 
                                                    }
                                                    
                                                ?>
                                                </select>
                                                
                                                
                                            </div>

                                            <div class="form-group col-md-12">
                                                <div class="">
                                                    <input type="file" name="file" class="dropify excelData" data-bs-height="180">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary">Upload Data</button>
                                            </div>

                                        </div>
                                        <div class="card-body card body2" style='display: none;'>
                                            <label for=""><b>Adding Students: </b></label>
                                            <div class="progress progress-md">
                                                <div class="progress-bar bg-primary prg" style="width: 0.1%;">0.1%</div>
                                            </div>
                                            <br>
                                            <span style='text-weight:bold;display: none;' class="text-success sedone">Students From Excel are successfully added.</span>
                                            <span style='text-weight:bold;display: none;' class="text-danger sefail">Process failed! Contact administrator.</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-12">
                            <div class="card studentIdTable" style="display: none;">
                                <div class="card-header">
                                    <div class="card-title">Student Records in the Section</div>
                                </div>
                                <div class="card-body cardBody">
                                    <table class="table table-bordered text-nowrap border-bottom recordTable">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">Student Name</th>
                                                <th class="wd-15p border-bottom-0">Student ID</th>
                                                <th class="wd-15p border-bottom-0">Class Roll</th>
                                                <th class="wd-15p border-bottom-0">Univ. Roll</th>
                                            </tr>
                                        </thead>
                                        <tbody class='studentRecordBody'>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                            async function getAutoExcel() {

                                let batch = $("#batchSelect").val();
                                let forType = $("#for").val();

                                if(!batch || !forType) {
                                    alert("Select Batch & For First to continue!");
                                    return;
                                }

                                let fd = new FormData();
                                fd.set('batchid', batch);
                                fd.set('autoExcel', "1");
                                let resp = await fetch(`../assets/backend/getStudentRecords`, {
                                    method: "POST",
                                    body: fd,
                                });
                                if(resp.ok) {
                                    const data = await resp.json();
                                    let html = "";
                                    let maxMarks = "";
                                    if(forType=="mst1") {forType = "MST 1"; maxMarks ="24"; }
                                    if(forType=="mst2") {forType = "MST 2"; maxMarks ="24"; }
                                    if(forType=="assgn1") {forType = "ASSGN 1"; maxMarks ="10"; }
                                    if(forType=="assgn2") {forType = "ASSGN 2"; maxMarks ="10"; }
                                    $(".cardBody")[0].innerHTML = `
                                    <table class="table table-bordered text-nowrap border-bottom recordTable">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">Student Name</th>
                                                <th class="wd-15p border-bottom-0">Student ID</th>
                                                <th class="wd-15p border-bottom-0">Class Roll</th>
                                                <th class="wd-15p border-bottom-0">Univ. Roll</th>
                                                <th class="wd-15p border-bottom-0">Section</th>
                                                <th class="wd-15p border-bottom-0">${forType} (${maxMarks})</th>
                                            </tr>
                                        </thead>
                                        <tbody class='studentRecordBody'>

                                        </tbody>
                                    </table>
                                    `;
                                    for(let key in data) {
                                        let cr, ur;
                                        let section = data[key].sectionid;
                                        section = section.split('-');
                                        section = String.fromCharCode(parseInt(section[0])+64) + "" + section[1];
                                        if(data[key].classroll!="NA" && data[key].classroll!="undefined" && data[key].classroll!=undefined) {cr = data[key].classroll;}else {cr='NA';}
                                        if(data[key].uniroll) {ur = data[key].uniroll;}else {ur='NA';}
                                        html += `
                                            <tr>
                                                <td>${data[key].name}</td>
                                                <td>${data[key].studid}</td>
                                                <td>${cr}</td>
                                                <td>${ur}</td>
                                                <td>${section}</td>
                                                <td></td>
                                            </tr>
                                        `;
                                    }
                                    $(".studentIdTable")[0].style.display = "block";
                                    document.querySelector(".studentRecordBody").innerHTML = html;
                                    
                                    $(".recordTable").DataTable({
                                        dom: 'Bfrtip',
                                        buttons: [
                                            {
                                                extend: 'excel',
                                                title: ''
                                            },
                                        ]
                                    });
                                }
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
            if(file) {
                const batch = document.querySelector('#batchSelect').value;
                const subject = document.querySelector('#subjectSelect').value;
                const forType = document.querySelector('#for').value;
                $(".body1")[0].style.display = "none";
            $(".body2")[0].style.display = "block";
            
            let currWidth = 0.1;
            let progressInterval = setInterval(() => {
                currWidth += 2.5;
                $(".prg")[0].setAttribute('style', 'width: '+currWidth.toString()+"%");
                $(".prg")[0].innerHTML = currWidth.toString()+" %";
            }, 1500);

                let tmpXLName = "";

                let xml = new XMLHttpRequest();
                xml.onreadystatechange = function() {
                    if(this.readyState==4 && this.status==200) {
                        tmpXLName = this.responseText;
                    }
                }
                let fd = new FormData();
                fd.set('file', document.querySelector('.excelData').files[0]);
                xml.open("POST", "../assets/backend/add-marks-bulk.php", false);
                xml.send(fd);

                const worker = new Worker("uploadBulkMarksWorker.js?v=0.2");
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

                let data = {xlname: tmpXLName ,batchid:batch, forType:forType, subjectid:subject };
                worker.postMessage(JSON.stringify(data));

            }
            else {
                alert('Upload a File First!');
            }
            
        });
    </script>

<script>
                            
                            $("#depSelect").change(function() {
                                // alert('prakhar');
                                let val = $(this).val();
                                if(val) {
                                    enableDep(val);
                                }
                                else {
                                    $("#batchSelect").attr('disabled', '1');
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
                                        $("#batchSelect").text('');

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
                                                getDepartmentSubjects(depid);
                                            $("#batchSelect").removeAttr('disabled');
                                            $("#batchSelect").html(html);
                                        }
                                        else {$("#batchSelect").attr('disabled', '1');}
                                    }
                                }
                                else {
                                    $("#batchSelect").attr('disabled', '1');
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

                            <script>
                            async function getDepartmentSubjects(depid) {
                                let fd = new FormData();
                                fd.set('depid', depid);
                                <?php if($ut=="4") { ?>
                                    fd.set('tpp', "1");
                                <?php } ?>
                                let resp = await fetch(`../assets/backend/getDepartmentSubjects`, {
                                    method: "POST",
                                    body: fd,
                                });
                                if(resp.ok) {
                                    const data = await resp.text();
                                    if(data) {
                                        let subjectData = JSON.parse(data);
                                        console.log(subjectData);
                                        let html = "<option value='' selected disabled>Select Subjects:</option>";
                                        $("#subjectSelect").text('');

                                        let sem = "0";

                                        for(let key in subjectData) {
                                            if(subjectData[key].subjectsem != sem) {
                                                html += `</optgroup>`;
                                                html += `<optgroup label='Sem: ${subjectData[key].subjectsem} '>`;
                                                sem = subjectData[key].subjectsem;
                                            }
                                            <?php if(isset($_GET['subject'])) { 
                                                ?>
                                                if(subjectData[key].subjectid=="<?php echo $_GET['subject'] ?>") {
                                                    html += `
                                                        <option value="${subjectData[key].subjectid}" selected>${subjectData[key].subjectname} - ${subjectData[key].subjectcode}</option>
                                                    `;
                                                    continue;
                                                }
                                                <?php
                                             } ?>
                                            html += `
                                                <option value="${subjectData[key].subjectid}" >${subjectData[key].subjectname} - ${subjectData[key].subjectcode}</option>
                                                `;
                                            }
                                        if(html) {
                                            $("#subjectSelect").removeAttr('disabled');
                                            $("#subjectSelect").html(html);
                                        }
                                        else {$("#subjectSelect").attr('disabled', '1');}
                                    }
                                }
                            }
                            </script>

</body>
</html>