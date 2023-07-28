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
    
    $sql = $conn->mconnect()->prepare("SELECT batchLabel, batchid FROM `batches` WHERE `batchid` IN (".$processedBatchsAssigned.") ");
    $sql->execute();
    $batchLabelData = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    $batchData = array();
    foreach ($batchLabelData as $key => $value) {
        $batchData[$value["batchid"]] = $value["batchLabel"];
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
    <!-- TITLE -->
    <title>ERP</title>
    <link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script src="../assets/js/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>

    <script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/plugins/datatable/dataTables.responsive.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
                            <h1 class="page-title">Mark Attendance</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Mark Attendance</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->

                        <?php
                        if(!$dataNull) {
                            foreach ($data as $key => $value) {
                                foreach ($value as $key_ => $value_) {
                                    $sectionInfo = explode('-', $key_);
                                    $randId = uniqid();
                                    ?>
                                    
                                    <div class="col-12 <?php echo $key.$key_; ?> ">
                                        <form class='form_<?php echo $randId; ?>' method="POST" action='../assets/backend/submitAttendance'>
                                            <input type="hidden" name="batchid" value="<?php echo $key; ?>">
                                            <input type="hidden" name="sectionid" value="<?php echo $key_; ?>">
                                            <input type="hidden" name="subjectid" value="<?php echo $value_[0]; ?>">
                                            <input type="hidden" name="date" value="">
                                            <input type="hidden" name="absentStudents" value="">
                                        </form>
                                        <div class="card card-collapsed">
                                            <div class="card-header">
                                                <h3 class="card-title"><?php echo $batchData[$key]; ?> (section: <?php echo chr($sectionInfo[0]+64).$sectionInfo[1]; ?>) - <?php echo $value_[1]; ?> </h3>
                                                <div class="card-options">
                                                    <a href="javascript:void(0)" class="card-options-collapse" onclick='getStudentDetails(this, "<?php echo $key; ?>", "<?php echo $key_; ?>", "<?php echo $randId; ?>", "<?php echo $value_[0]; ?>");'data-bs-toggle="card-collapse" data-loadedRecords="0" ><i class="fe fe-chevron-up"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3"><label for="">Select Date: </label></div>
                                                    <div class="col-9">
                                                        <input id='attDate' style='display:none;' class='form-control attDate<?php echo $randId; ?>'>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span>Attendance Status: </span> <span class="attStatusText font-weight-bold" style='font-weight: bold;'>Select Date to Get Status and Submit Attendance</span>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="spinner-grow text-primary me-2 loader" style="width: 3rem; height: 3rem;" role="status"></div>
                                                <!-- <div class="col-lg-12"> -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered text-nowrap border-bottom key-buttons" id="file-datatable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Name</th>
                                                                            <th>Present Today</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class='student-table-body'>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary submitAttendanceBtn <?php echo "btn_".$key."_".$key_; ?>" onclick='submitAttendance("<?php echo $randId; ?>");' disabled>Submit Attendance</button>
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        else {
                            echo "No Subjects are currently assinged to you!";
                        }

                        ?>
            
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
        function submitAttendance(randId) {
            // let classInfo = $(e)[0].classList[3];
            let checkBoxes= $("."+randId);
            let absentStudents = [];
            for(let k in checkBoxes) {
                if(!checkBoxes[k].checked) {
                    absentStudents.push(checkBoxes[k].value);
                }
                if(k==(checkBoxes.length-1)) {
                    break;
                }
            }
            $(".form_"+randId+" input[name='absentStudents']")[0].value = btoa(JSON.stringify(absentStudents));
            $(".form_"+randId+" input[name='date']")[0].value = $(".attDate"+randId)[0].getAttribute('date-value');
            $(".form_"+randId)[0].submit();
        }
    </script>
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
                fetch('../assets/backend/getAttendanceMarkedStatus', {
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
                    initDates(data);
                    setAbsentees(data);
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });

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
                    processStudentDetails(batchid, sectionid, data, randid);
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });



            }
        }

        function processStudentDetails(batchid, sectionid, data, randid) {
            data = JSON.parse(data);
            for(const key in data) {
                data[key].marks = JSON.parse(data[key].marks);
                
                let avgMarks = 0;
                let finalMarks = 0;

                if(data[key].marks.phase1.mst==null) {
                    data[key].marks.phase1.mst = 0;
                } 
                if(data[key].marks.phase1.assign==null) {
                    data[key].marks.phase1.assign = 0;
                } 

                if(data[key].marks.phase2.mst==null) {
                    data[key].marks.phase2.mst = 0;
                } 
                if(data[key].marks.phase2.assign==null) {
                    data[key].marks.phase2.assign = 0;
                }        

                avgMarks = (parseInt(data[key].marks.phase1.mst) + parseInt(data[key].marks.phase1.assign) + parseInt(data[key].marks.phase2.mst) + parseInt(data[key].marks.phase2.assign))/4;
                data[key].marks['avgMarks'] = avgMarks;

                if(data[key].totalattendance>75 && data[key].totalattendance<=80) {
                    finalMarks += 5;
                }

                finalMarks += avgMarks;

                data[key]['totalInternal'] = finalMarks;

            }
            showStudentDetails(batchid, sectionid, data, randid);
        }
        let datesWithSubmissionRecords;
        function initDates(data) {
            data=JSON.parse(data)["dateDetails"];
            datesWithSubmissionRecords = data;
            dateRanges.push(Object.keys(data)[0]);
            dateRanges.push(Object.keys(data)[1]);
            
        }
        let absentees;
        function setAbsentees(data) {
            data = JSON.parse(data)["absentStudentsDetails"];
            absentees = data;
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

    <script>
       function isInvalidDate(date, log) {
            if(!dateRanges[1]) {
                if(date.format('YYYY-MM-DD')==dateRanges[0]) {
                    return false;
                }
            }
            if(date.format('YYYY-MM-DD')<=dateRanges[0] && date.format('YYYY-MM-DD')>=dateRanges[1]) {
                return false;
            }
            return true;
        }
        function setHtml(htmlData, date, randid) {
            let dateKey;
            try {
                dateKey = absentees[date];
            }
            catch(err) {
                dateKey = null;
            }
            let html = "";
            if(dateKey) {
                let absStudsUid = JSON.parse(dateKey);
                for(const key in htmlData) {
                    if(absStudsUid.includes(htmlData[key].studid)) {
                        html += `<tr>
                        <td>${parseInt(key)+1}</td>
                        <td>${htmlData[key].name}</td>
                        <td><input type='checkbox' class='${randid}' value='${htmlData[key].studid}'></td>
                        </tr>`;
                    }
                    else {
                        html += `<tr>
                        <td>${parseInt(key)+1}</td>
                        <td>${htmlData[key].name}</td>
                        <td><input type='checkbox' class='${randid}' value='${htmlData[key].studid}' checked></td>
                        </tr>`;
                    }
                }
            }else {
                for(const key in htmlData) {
                    html += `<tr>
                        <td>${parseInt(key)+1}</td>
                        <td>${htmlData[key].name}</td>
                        <td><input type='checkbox' class='${randid}' value='${htmlData[key].studid}' checked></td>
                        </tr>`;
                }
            }
            return html;
        }   
        function showStudentDetails(batchid, sectionid, data, randid) {
            $("."+batchid+sectionid+" .student-table-body")[0].innerHTML = "";
            
            $("."+batchid+sectionid+" .loader")[0].style.display = "none";
            $("."+batchid+sectionid+" #attDate")[0].style.display = "block";
            $("."+batchid+sectionid+" #attDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: true,
	            autoApply: true,
                locale: {
                    "format": "YYYY-MM-DD",
                },
                isInvalidDate: isInvalidDate
            });

            $("."+batchid+sectionid+" #attDate").on('apply.daterangepicker', function(ev, picker) {
                $("."+batchid+sectionid+" #attDate")[0].setAttribute('date-value', picker.startDate.format('YYYY-MM-DD'));

                let html = setHtml(data, picker.startDate.format('YYYY-MM-DD'), randid);
                $("."+batchid+sectionid+" .student-table-body")[0].innerHTML = html;
                
                $("."+batchid+sectionid+" .submitAttendanceBtn").removeAttr('disabled');
                // console.log(datesWithSubmissionRecords[picker.startDate.format('YYYY-MM-DD')]);
                if(datesWithSubmissionRecords[picker.startDate.format('YYYY-MM-DD')]=="1") {
                    
                    $("."+batchid+sectionid+" .attStatusText").addClass('text-success');
                    $("."+batchid+sectionid+" .attStatusText").removeClass('text-danger');
                    $("."+batchid+sectionid+" .attStatusText")[0].innerHTML = "Already Submitted!";
                }
                else {
                    $("."+batchid+sectionid+" .attStatusText").removeClass('text-success');
                    $("."+batchid+sectionid+" .attStatusText").addClass('text-danger');
                    $("."+batchid+sectionid+" .attStatusText")[0].innerHTML = "Not Submitted Yet!";

                }
		    });
            
            let table = new DataTable("."+batchid+sectionid+" #file-datatable", {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
                ]
            });
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


</body>
</html>