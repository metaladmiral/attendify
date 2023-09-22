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

                        <div class="col-12">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h4 class="card-title">Directions To Use</h4>
                                    <p class="card-text">
                                        <label for="" class="form-label">Attendance: </label>
                                        <ul>
                                            <li>CheckBox Ticked: <b>Present</b></li>
                                            <li>CheckBox Unticked: <b>Absent</b></li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php
                        if(!$dataNull) {
                            foreach ($data as $key => $value) {
                                foreach ($value as $key_ => $value_) {
                                    $sectionInfo = explode('-', $key_);
                                    foreach($value_ as $key__ => $subjectDetails) {
                                    $randId = uniqid();
                                    ?>
                                    
                                    <div class="col-12 <?php echo $randId; ?> batchTab">
                                        <form class='form_<?php echo $randId; ?>' method="POST" onsubmit="return false;" action='../assets/backend/submitAttendance'>
                                        <!-- <form class='form_<?php echo $randId; ?>' method="POST" onsubmit="return false;"> -->
                                            <input type="hidden" name="batchid" value="<?php echo $key; ?>">
                                            <input type="hidden" name="sectionid" value="<?php echo $key_; ?>">
                                            <input type="hidden" name="subjectid" value="<?php echo $subjectDetails[0]; ?>">
                                            <input type="hidden" name="date" value="">
                                            <input type="hidden" name="absentStudents" value="">
                                            <input type="hidden" name="classCount" value="">
                                        </form>
                                        <div class="card card-collapsed">
                                            <div class="card-header">
                                                <h3 class="card-title"><?php echo $batchData[$key]; ?> (section: <?php echo chr($sectionInfo[0]+64).$sectionInfo[1]; ?>) - <?php echo $subjectDetails[1]; ?> </h3>
                                                <div class="card-options">
                                                    <a href="javascript:void(0)" class="card-options-collapse card-collapsable" onclick='getStudentDetails(this, "<?php echo $key; ?>", "<?php echo $key_; ?>", "<?php echo $randId; ?>", "<?php echo $subjectDetails[0]; ?>");' data-bs-toggle="card-collapse" data-loadedRecords="0" ><i class="fe fe-chevron-up"></i></a>
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
                                                <div class="row classCountContainer<?php echo $randId; ?>" style='display: none;'>
                                                    <div class="col-3"><label for="">No. of Classes Taken: </label></div>
                                                    <div class="col-9">
                                                        <input type="number" min="1" max="3" class='form-control classesTaken' onkeyup="addAttChkBox('<?php echo $randId; ?>', this.value);" onchange="addAttChkBox('<?php echo $randId; ?>', this.value);" id="classCount<?php echo $randId; ?>" value="1">
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
                                                                <table class="table table-bordered text-nowrap border-bottom key-buttons file-datatable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Roll No.</th>
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
                                                        <button class="btn btn-primary submitAttendanceBtn <?php echo "btn_".$randId; ?>" onclick='return submitAttendance("<?php echo $randId; ?>");' disabled>Submit Attendance</button>
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
        function addAttChkBox(randId, classCount) {
            // let html = "";
            
            // $("."+randId+" .chkBoxes")
            classCount = parseInt(classCount);
            if(classCount>0 && classCount<4) {
                console.log(typeof(classCount));
                let chkBoxesCont = $("."+randId+" .chkBoxes");
                for(let key in chkBoxesCont) {
                    if(key=="length") {break;}
                    let studid = chkBoxesCont[key].children[0].value;
                    let html = "";
                    for (let i = 0; i < classCount; i++) {
                        html += `
                        <input type='checkbox' style='position: unset;margin-block-start: unset;margin-inline-start: unset;' class='cb_${randId} cb${i} form-check-input' value='${studid}' checked>
                        `;
                    }
                    chkBoxesCont[key].innerHTML = html;
                }
            }

        }
        function submitAttendance(randId) {
            // let classInfo = $(e)[0].classList[3];
            let checkBoxes= $(".cb_"+randId);
            let classCount= $("#classCount"+randId)[0].value;
            // alert(classCount);
            let absentStudents = [];

            for (let i = 0; i < classCount; i++) { 
                let chkBoxes = $("."+randId+" .cb"+i);

                console.log("."+randId+" .cb"+i);
                absentStudents.push([]);
                for(k in chkBoxes) {
                    if(chkBoxes[k].value) {
                        if(!chkBoxes[k].checked) {
                            absentStudents[i].push(chkBoxes[k].value);
                        }
                        if(k==(chkBoxes.length-1)) {
                            break;
                        }    
                    }
                    else {
                        break;
                    }
                }
            }

            $(".form_"+randId+" input[name='absentStudents']")[0].value = btoa(JSON.stringify(absentStudents));
            $(".form_"+randId+" input[name='date']")[0].value = $(".attDate"+randId)[0].getAttribute('date-value');
            $(".form_"+randId)[0].submit();
            // console.log(JSON.stringify(absentStudents));
        }
    </script>
    <script>

        var dateRanges = [];

        let studentDetailsOffset = 0;
        async function getStudentDetails(e, batchid, sectionid, randid, subjectid) {
            let otherTabs = $(".batchTab");
            let randClassName;
            for(let i in otherTabs) {
                if(i=="length") {break;}
                $("#classCount"+randid)[0].value = "1";
                if($(otherTabs[i]).hasClass(randid)) {continue;}
                if(!$($(otherTabs[i]).children()[1]).hasClass('card-collapsed')) {

                    randClassName = "."+$(otherTabs[i]).attr('class').split(' ')[1];
                    
                    if($(randClassName+" .card-collapsable").attr('data-loadedRecords')) {
                        $(randClassName+" .card-collapsable").attr('data-loadCount', "1");
                    }
                    $(randClassName+" .card-collapsable").attr('data-loadedRecords', "0");

                    $(randClassName+" .attStatusText").html('Select Date to Get Status and Submit Attendance');
                    $(randClassName+" .attStatusText").removeClass('text-success');
                    $(randClassName+" .classesTaken")[0].value = "";
                    $($(otherTabs[i]).children()[1]).addClass('card-collapsed');
                }
            }
            if($(e).attr('data-loadedRecords')=="0") {
                $(e).attr('data-loadedRecords', "1");
                // $(".student-records")[0].style.display = "block";

                let fd = new FormData();
                fd.set("offset", studentDetailsOffset);
                fd.set("batchid", batchid);
                fd.set("sectionid", sectionid);
                
                fd.set("subjectid", subjectid);
                await fetch('../assets/backend/getAttendanceMarkedStatus', {
                    method: 'POST',
                    body: fd
                })
                .then(function (response) {
                    if (response.ok) {
                        return response.text(); 
                    }
                    throw new Error('Network response was not OK');
                })
                .then(async function (data) {
                    await initDates(data);
                    setAbsentees(data);
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });

                await fetch('../assets/backend/getStudentRecords', {
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
                    if($(e).attr('data-loadCount')) {
                        processStudentDetails(batchid, sectionid, data, randid, 1);
                    }
                    else {

                        processStudentDetails(batchid, sectionid, data, randid);
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });



            }
        }

        function processStudentDetails(batchid, sectionid, data, randid, reOpen) {
            data = JSON.parse(data);
           
            showStudentDetails(batchid, sectionid, data, randid, reOpen);
        }
        let datesWithSubmissionRecords;
        function initDates(data) {
            dateRanges = [];
            data=JSON.parse(data)["dateDetails"];
            datesWithSubmissionRecords = data;
            dateRanges.push(Object.keys(data)[0]);
            dateRanges.push(Object.keys(data)[1]);
            
        }
        let absentees;
        let classesCount = 0;
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

        function setHtml(htmlData, date, randid, classCount) {
            let dateKey;
            try {
                dateKey = absentees[date];
            }
            catch(err) {
                dateKey = null;
            }
            let html = "";
            if(dateKey) {
                let absDataObj;
                if(Object.values(dateKey).includes("-")) {
                    absDataObj = dateKey.split('-');
                    classesCount = absDataObj.length;
                }else {
                    absDataObj = JSON.parse(dateKey);
                    absDataObj = [absDataObj];
                    classesCount = 1;
                }

                $(".classCountContainer"+randid+" input")[0].value = classesCount;
                
                
                for(const key in htmlData) {
                    let rollno;
                    if(htmlData[key].uniroll && (htmlData[key].uniroll.toLowerCase())!="na") {
                        rollno = htmlData[key].uniroll;
                    }
                    else {
                        rollno = htmlData[key].classroll;
                        
                    }
                    html += `<tr>
                    <td>${rollno}</td>
                    <td>${htmlData[key].name}</td>
                    <td class='chkBoxes row' style='justify-content:center;'>`;
                    for(let k in absDataObj) {
                        let absStudsUid = absDataObj[k]; 
                        if(absStudsUid.includes(htmlData[key].studid)) {
                            html += `<input type='checkbox' style='position: unset;margin-block-start: unset;margin-inline-start: unset;' class='cb_${randid} form-check-input cb${k}' value='${htmlData[key].studid}'>`;
                        }
                        else {
                            html += `<input type='checkbox' style='position: unset;margin-block-start: unset;margin-inline-start: unset;' class='cb_${randid} form-check-input cb${k}' value='${htmlData[key].studid}' checked>`;
                        }

                    }
                    html += `</td>
                    </tr>`;

                }
            }else {
                for(const key in htmlData) {
                    let rollno;
                    if(htmlData[key].uniroll && (htmlData[key].uniroll.toLowerCase())!="na") {
                        rollno = htmlData[key].uniroll;
                    }
                    else {
                        rollno = htmlData[key].classroll;
                        
                    }
                    html += `<tr>
                        <td>${rollno}</td>
                        <td>${htmlData[key].name}</td>
                        <td class='chkBoxes'><input type='checkbox' style='position: unset;margin-block-start: unset;margin-inline-start: unset;' class='cb_${randid} form-check-input cb0' value='${htmlData[key].studid}' checked></td>
                        </tr>`;
                }
            }
            return html;
        }   
        function showStudentDetails(batchid, sectionid, data, randid, reOpen=0, classCount=1) {
            $("."+randid+" .student-table-body")[0].innerHTML = "";
            
            $("."+randid+" .loader")[0].style.display = "none";
            $(".attDate"+randid)[0].style.display = "block";
            $(".attDate"+randid).daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: true,
	            autoApply: true,
                locale: {
                    "format": "YYYY-MM-DD",
                },
                isInvalidDate: isInvalidDate
            });

            $(".attDate"+randid).on('apply.daterangepicker', function(ev, picker) {
                $(".attDate"+randid)[0].setAttribute('date-value', picker.startDate.format('YYYY-MM-DD'));

                $(".classCountContainer"+randid)[0].style.display = "flex";
                // $(".classCountContainer"+randid+" input")[0].setAttribute('onkeyup', 'showStudentDetails("'+batchid+'","'+sectionid+'","'+data+'", "'+randid+'", this.value)');

                let html = setHtml(data, picker.startDate.format('YYYY-MM-DD'), randid, classCount);
                $("."+randid+" .student-table-body")[0].innerHTML = html;
                if(html) {
                    $("."+randid+" .submitAttendanceBtn").removeAttr('disabled');
                }
                // console.log(datesWithSubmissionRecords[picker.startDate.format('YYYY-MM-DD')]);
                if(datesWithSubmissionRecords[picker.startDate.format('YYYY-MM-DD')]=="1") {
                    
                    $("."+randid+" .attStatusText").addClass('text-success');
                    $("."+randid+" .attStatusText").removeClass('text-danger');
                    $("."+randid+" .attStatusText")[0].innerHTML = "Already Submitted!";
                }
                else {
                    $("."+randid+" .attStatusText").removeClass('text-success');
                    $("."+randid+" .attStatusText").addClass('text-danger');
                    $("."+randid+" .attStatusText")[0].innerHTML = "Not Submitted Yet!";

                }
		    });
            

            if(!reOpen) {
                // alert('op');
                // let table = new DataTable("."+randid+" .file-datatable", {
                //     dom: 'Bfrtip',
                //     buttons: [
                //         'colvis'
                //     ]
                // });

                $("."+randid+" .file-datatable").DataTable( {
                    bPaginate: false,
                    bInfo: false,
                    sorting: false
                } );
            }
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