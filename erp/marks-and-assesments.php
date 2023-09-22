<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$sql = $conn->mconnect()->prepare("SELECT faculty FROM `users` WHERE `uid`='".$_SESSION['uid']."' ");
$sql->execute();

$data = $sql->fetch(PDO::FETCH_COLUMN);
$data = json_decode($data, true);
if(is_null($data) || count($data)==0) {
    $dataNull = true;
}else {
    $dataNull = false;
    $allBatchesAssigned = array();
    foreach ($data as $key => $value) {
        array_push($allBatchesAssigned, $key);
    }
    
    $processedBatchsAssigned = "'".implode("', '", $allBatchesAssigned)."'";
    
    $sql = $conn->mconnect()->prepare("SELECT batchid, batchLabel FROM `batches` WHERE `batchid` IN (".$processedBatchsAssigned.") ");
    $sql->execute();
    $batchData = $sql->fetchAll(PDO::FETCH_KEY_PAIR);
    
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
    <!-- TITLE -->
    <title>ERP</title>
    <link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script src="../assets/js/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- BOOTSTRAP CSS -->
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
                            <h1 class="page-title">Marks and Assesments</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Attendance Details</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->
                        <div id="assignSubjects"><?php
                        $nullCount = 0;
                        if(!$dataNull) {
                            foreach ($data as $key => $value) {
                                foreach ($value as $key_ => $value_) {
                                    if(!$value_) {continue;}
                                    $sectionInfo = explode('-', $key_);
                                    foreach($value_ as $key__ => $subjectDetails) {
                                    $randId = uniqid();
                                    ?>
                                    
                                    <div class="col-12 <?php echo $randId; ?>">
                                        <form class='form_<?php echo $randId; ?>' method="POST" action='../assets/backend/submitAttendance'>
                                            <input type="hidden" name="batchid" value="<?php echo $key; ?>">
                                            <input type="hidden" name="sectionid" value="<?php echo $key_; ?>">
                                            <input type="hidden" name="subjectid" value="<?php echo $subjectDetails[0]; ?>">
                                            <input type="hidden" name="date" value="">
                                            <input type="hidden" name="absentStudents" value="">
                                        </form>
                                        <div class="card card-collapsed">
                                            <div class="card-header">
                                                <h3 class="card-title"><?php echo $batchData[$key]; ?> (section: <?php echo chr($sectionInfo[0]+64).$sectionInfo[1]; ?>) - <?php echo $subjectDetails[1]; ?> </h3>
                                                <div class="card-options">
                                                    <a href="javascript:void(0)" class="card-options-collapse" onclick='getStudentDetails(this, "<?php echo $key; ?>", "<?php echo $key_; ?>", "<?php echo $randId; ?>", "<?php echo $subjectDetails[0]; ?>");'data-bs-toggle="card-collapse" data-loadedRecords="0" ><i class="fe fe-chevron-up"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row" style='display: none;'>
                                                    <div class="col-3"><label for="">Select Date: </label></div>
                                                    <div class="col-9">
                                                        <input id='attDate' style='display:none;' class='form-control attDate<?php echo $randId; ?> attDate'>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="spinner-grow text-primary me-2 loader" style="width: 3rem; height: 3rem;" role="status"></div>
                                                <!-- <div class="col-lg-12"> -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered text-nowrap border-bottom key-buttons file-datatable" id='<?php echo $randId; ?>_dt'>
                                                                    <thead>
                                                                        <tr class='dates-table-row'>
                                                                            <th>Roll No.</th>
                                                                            <th>Name</th>
                                                                            <th>MST 1</th>
                                                                            <th>Assgn. 1</th>
                                                                            <th>MST 2</th>
                                                                            <th>Assgn. 2</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class='student-table-body'>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                }
                            }
                        }
                        else {
                            echo "No Subjects are currently assinged to you!";
                        }

                        ?></div>
                        <!-- BODY CONTENT END -->
                        
                    </div>
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->
        </div>
     <!-- FOOTER -->
    <?php include 'footer.php' ?>
    
    <script>

        var dateRanges = [];

        let studentDetailsOffset = 0;
        function getStudentDetails(e, batchid, sectionid, randid, subjectid) {
            if($(e).attr('data-loadedRecords')=="0") {
                $(e).attr('data-loadedRecords', "1");
                // $(".student-records")[0].style.display = "block";

                let fd = new FormData();
                fd.set("offset", studentDetailsOffset);
                fd.set("batchid", batchid);
                fd.set("sectionid", sectionid);
                fd.set("subjectid", subjectid);

                fetch('../assets/backend/getStudentRecords', {
                    method: 'POST',
                    body: fd
                })
                .then(function (response) {
                    if (response.ok) {
                        return response.text(); 
                    }
                    throw new Error('Network response was not OK');
                })
                .then(function (data) {
                    console.log(data);
                    showStudentDetails(batchid, sectionid, data, randid, subjectid);
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });


            }
        }

    </script>
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
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>

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
    <script src="../assets/plugins/edit-table/bst-edittable.js"></script>
    <script src="../assets/plugins/edit-table/edit-table.js"></script>
    <script src="../assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
    <script src="../assets/js/table-data.js"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        function showStudentDetails(batchid, sectionid, data, randid, subjectid) {
            $("."+randid+" .student-table-body")[0].innerHTML = "";
            let html = "";
            data = JSON.parse(data);

            html = "";
            for(const key in data) {
                let marks = JSON.parse(data[key].marks);

                if (marks && marks[subjectid]) {
                    marks = marks[subjectid];
                } else {
                    marks = {
                        mst1: "NA",
                        assgn1: "NA",
                        mst2: "NA",
                        assgn2: "NA"
                    };
                }

                let studid = data[key].studid;
                let rollno;
                if(data[key].uniroll && (data[key].uniroll.toLowerCase())!="na") {
                    rollno = data[key].uniroll;
                }
                else {
                    rollno = data[key].classroll;
                    
                }
                
                html += `<tr data-studid='${data[key].studid}'>
                <td>${rollno}</td>
                <td>${data[key].name}</td>
                <td class='mst1'>${marks.mst1}</td>
                <td class='assgn1'>${marks.assgn1}</td>
                <td class='mst2'>${marks.mst2}</td>
                <td class='assgn2'>${marks.assgn2}</td>
                `;
                html += "</tr>";
            }
            $("."+randid+" .loader")[0].style.display = "none";
            
            $("."+randid+" .student-table-body")[0].innerHTML = html;
            // let table = new DataTable("."+randid+" .file-datatable", {
            //     dom: 'Bfrtip',
            //     buttons: [
            //         'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
            //     ]
            // });
            // $().DataTable({
            //     dom: 'Bfrtip',
            //     buttons: [
            //         'pdf', 'excel'
            //     ],
            //     "bInfo": false,
            //     "pageLength": 40,
            //     "bPaginate": false
            // });

            var example3 = new BSTable(randid+"_dt", {
                editableColumns:"2,3,4,5",
                onEdit: function(row) {
                    let studid = $(row).attr('data-studid');
                    let mst1 = $(row).children(".mst1").html();
                    let assgn1 = $(row).children(".assgn1").html();
                    let mst2 = $(row).children(".mst2").html();
                    let assgn2 = $(row).children(".assgn2").html();

                    updateStudentMarks(studid, mst1, assgn1, mst2, assgn2, subjectid);

                },

                advanced: { // Do not override advanced unless you know what youre doing
                    columnLabel: 'Actions',
                    buttonHTML: `<div class="btn-list">
                    <button id="bEdit" type="button" class="btn btn-sm btn-primary">
                        <span class="fe fe-edit" > </span>
                    </button>
                    <button id="bAcep" type="button" class="btn  btn-sm btn-primary" style="display:none;">
                        <span class="fe fe-check-circle" > </span>
                    </button>
                    <button id="bCanc" type="button" class="btn  btn-sm btn-danger" style="display:none;">
                        <span class="fe fe-x-circle" > </span>
                    </button>
                </div>`
                }
                
            });
            example3.init();
        }
        
            </script>
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
                swal('Hooray!', 'Attendance Successfully registered!', 'success');
            </script>
            <?php
        }
        unset($_SESSION['succ']);
    }

    ?>

<script>

    
    async function updateStudentMarks(studid, mst1, assgn1, mst2, assgn2, subjectid) {
        const url = '../assets/backend/setStudentMarks'; // Replace with the actual URL
        
        // Create a new FormData object and append the required fields
        const formData = new FormData();
        formData.append('subjectid', subjectid);
        formData.append('studid', studid);
        formData.append('mst1', mst1);
        formData.append('assgn1', assgn1);
        formData.append('mst2', mst2);
        formData.append('assgn2', assgn2);
  
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
            });

            if (response.ok) {
                const responseData = await response.text();
                if(responseData!="1") {
                    swal({
                        title: "Oops!",
                        text: "An error occured. Please contact admin!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: 'Exit'
                    });
                }
            } else {
                console.error('Request failed with status:', response.status);
            }
        } catch (error) {
            console.error('An error occurred:', error);
        }
    }
</script>

<script>
    $(document).ready(function() {
        let html = $("#assignSubjects")[0].innerHTML;
        console.log(html);
        if(!html) {
            $("#assignSubjects")[0].innerHTML = "No Subjects are currently assinged to you!";
        }
    });
</script>

</body>
</html>