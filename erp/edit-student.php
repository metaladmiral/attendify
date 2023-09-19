<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$sql = "SELECT * FROM `students` a INNER JOIN `batches` b ON a.`batchid`=b.`batchid` WHERE a.`studid`='".$_GET['sid']."' ";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
if($query->rowCount()==0){
    header('Location: ../404.php');
    die();
}
$pdata = $query->fetch(PDO::FETCH_ASSOC);

$fullname = $pdata["name"];
$fullname = preg_replace('/\s+/', '', $fullname);

$studid = $pdata["studid"];

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
                            <h1 class="page-title">Edit Student</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- BODY CONTENT -->
                        <div class="card">
                     <div class="card-header">
                        <h3 class="card-title">Edit Student Details</h3>
                     </div>
                     <div class="card-body">
                        <div class="card-pay">
                           <div class="tab-content">
                              <div class="tab-pane active show" id="tab20" role="tabpanel">

                              <form method="POST" action="../assets/backend/editstud_script.php">
                                 <input type="hidden" name="studid" value="<?php echo $studid; ?>">
                                 <!-- Batch select tag -->
                                 <div class="row">
                                    <div class="col-6">
                                       
                                          <div class="form-group">
                                             <label class="form-label">Batch</label>
                                             <input type="text" class='form-control' value='<?php echo $pdata["batchLabel"]; ?>' disabled>
                                          </div>
                                          <!--  -->
                                    </div>
                                    <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">Section</label>
                                        <?php $sectionDetails = explode('-', $pdata["sectionid"]);  ?>
                                        <select name="section" class="form-control form-select select2" id="" required>
                                        <?php
                                        for($i=65;$i<=74;$i++) {
                                             $p = 1;
                                             while($p<=2) {
                                                   ?>
                                               <option value="<?php echo $i-64; ?>-<?php echo $p; ?>" <?php if((($sectionDetails[0]+64).$sectionDetails[1])==($i.$p)) {echo "selected";} ?> ><?php echo chr($i); ?><?php echo $p; ?></option>
                                          <?php
                                          $p++;
                                          }
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <!--  -->
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Name</label>
                                            <input type="text" name="name" class='form-control' value='<?php echo $pdata["name"]; ?>' required>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                             <label for="exampleInputEmail1" class="form-label">Semester</label>
                                             <input type="text" name="sem" class='form-control' value='<?php echo $pdata["semester"]; ?>' required>
                                        </div>
                                    </div>
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Blood Group</label>
                                 <input type="text" class='form-control' name="bldgrp" value='<?php echo $pdata["bloodgrp"]; ?>' required>
                                 </div>
                                 </div>
                                 </div>
                                 <div class="row">
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label class="form-label">Date of Birth</label>
                                 <input type="text" class='form-control' name="dob" value='<?php echo $pdata["dob"]; ?>' required>
                                 </div>
                                 </div>
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label class="form-label">Name of the department/Institute</label>
                                 <input type="text" class='form-control' name="depname" value='<?php echo $pdata["dep"]; ?>' required>
                                 </div>
                                 </div>
                                 </div>
                                 <div class="row">
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Class Roll Number</label>
                                 <input type="text" class='form-control' name="classroll" value='<?php echo $pdata["classroll"]; ?>' required>
                                 </div>
                                 </div>
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">University Roll Number</label>
                                 <input type="text" class='form-control' name="uniroll" value='<?php echo $pdata["uniroll"]; ?>'>
                                 </div>
                                 </div>
                                 </div>
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Student Email ID</label>
                                 <input type="text" class='form-control' name="studemail" value='<?php echo $pdata["studemail"]; ?>' required>
                                 </div>
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Parent Email ID</label>
                                 <input type="text" class='form-control' name="pemail" value='<?php echo $pdata["parentemail"]; ?>' required>
                                 </div>
                                 <div class="row">
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Father's Name</label>
                                 <input type="text" class='form-control' name="fname" value='<?php echo $pdata["fname"]; ?>' required>
                                 </div>
                                 </div>
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Mother's Name</label>
                                 <input type="text" class='form-control' name="mname" value='<?php echo $pdata["mname"]; ?>' required>
                                 </div>
                                 </div>
                                 </div>
                                 <div class="row">
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Category</label>
                                 <input type="text" class='form-control' name="category" value='<?php echo $pdata["category"]; ?>' required>
                                 </select>
                                 </div>
                                 </div>
                                 <div class="col-6">
                                 <label for="exampleInputEmail1" class="form-label">Mobile Number</label>
                                 <div class="row">
                                 <div class="col-12">
                                 <div class="form-group">
                                 <input type="text" class='form-control' name="mno" value='<?php echo $pdata["mno"]; ?>' required>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 <div class="row">
                                 <div class="col-6">
                                 <label for="exampleInputEmail1" class="form-label">Mobile Number (Alternate)</label>
                                 <div class="row">
                                 
                                 <div class="col-12">
                                 <div class="form-group">
                                 <input type="text" class='form-control' name="mano" value='<?php echo $pdata["mano"]; ?>' required>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 <div class="col-6">
                                 <label for="exampleInputEmail1" class="form-label">Whatsapp Number</label>
                                 <div class="row">
                                 <div class="col-12">
                                 <div class="form-group">
                                 <input type="text" class='form-control' name="wno" value='<?php echo $pdata["wno"]; ?>' required>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Permanent Address</label>
                                 <input type="text" class='form-control' name="permaddr" value='<?php echo $pdata["permaddr"]; ?>' required>
                                 </div>
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">Local Address</label>
                                 <input type="text" class='form-control' name="localaddr" value='<?php echo $pdata["localaddr"]; ?>' required>
                                 </div>
                                 <div class="row">
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">State</label>
                                 <input type="text" name="state" class='form-control' value='<?php echo $pdata["state"]; ?>' required>
                                 </div>
                                 </div>
                                 <div class="col-6">
                                 <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-label">District</label>
                                 <input type="text" name="district" class='form-control' value='<?php echo $pdata["district"]; ?>' required>
                                 </div>
                                 </div>
                                 <?php
                                 $hostelDetails = json_decode($pdata["hosteldetails"], true);
                                 ?>
                                 <div class="row">
                                 <div class="col-4">
                                 <label for="exampleInputEmail1" class="form-label">Hosteler</label>
                                 <input type="text" name="hosteler" class='form-control' value='<?php echo $hostelDetails["hosteler"]; ?>' required>
                                 </div>
                                 <div class="col-4">
                                 <label for="exampleInputEmail1" class="form-label">Room No.</label>
                                 <input type="text" name="roomno" class='form-control' value='<?php echo $hostelDetails["roomno"]; ?>'>
                                 </div>
                                 <div class="col-4">
                                 <label for="exampleInputEmail1" class="form-label">Hostel Name</label>
                                 <input type="text" name="hostelname" class='form-control' value='<?php echo $hostelDetails["hostelname"]; ?>'>
                                 </div>
                                 </div>
                                 </div>
                                
                                 <?php
                                 $parentDetails = json_decode($pdata["parentsworkdetails"], true);
                                 ?>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Parent Occupation</label>
                                            <input type="text" name="parentoccupation" class='form-control' value='<?php echo $parentDetails["parentoccupation"]; ?>' required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Parent Annual Income</label>
                                            <input type="text" name="parannualincome" class='form-control' value='<?php echo $parentDetails["parannualincome"]; ?>' required>
                                        </div>
                                    </div>
                                    </div>

                                    <?php
                                        $loanDetails = json_decode($pdata["loandetails"], true);
                                    ?>

                                    <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Applied for Loan</label>
                                            <!--<input name="parocc" type="text" class="form-control" placeholder="Enter Parent Occupation" required>-->
                                            <input type="text" class='form-control' name="loanstatus" value='<?php echo $loanDetails["loanstatus"]; ?>' required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Loan Amount</label>
                                            <input type="text" class='form-control' name="loanamount" value='<?php echo $loanDetails["loanamount"]; ?>' >
                                        </div>
                                    </div>
                                </div>

                                
                                          <div class="form-group">
                                             <label for="exampleInputEmail1" class="form-label">Unhealthy Habits (if any)</label>
                                             <textarea type="text" class='form-control' name="unhealthyhabits" required><?php echo $pdata["unhealthyhabits"]; ?></textarea>
                                          </div>
                                          <?php $marks = json_decode($pdata["marksinschool"], true); ?>
                                          <div class="row">
                                             <div class="col-6">
                                                <div class="form-group">
                                                   <label for="exampleInputEmail1" class="form-label">% Marks in 10th</label>
                                                   <input type="text" class='form-control' name="10thmarks" value='<?php echo $marks[0]; ?>' required>
                                                </div>
                                             </div>
                                             <div class="col-6">
                                                <div class="form-group">
                                                   <label for="exampleInputEmail1" class="form-label">% Marks in 12th</label>
                                                   <input type="text" class='form-control' value='<?php echo $marks[1]; ?>' name="12thmarks" required>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label for="exampleInputEmail1" class="form-label">Aim of education</label>
                                             <textarea name="aimoe" class="form-control" placeholder="Start typing here..." required><?php echo $pdata["aimofedu"]; ?></textarea>
                                          </div>
                                          <div class="form-group">
                                             <label for="exampleInputEmail1" class="form-label">Discipline, Peronal Traits and Progressive Improvement in weak areas</label>
                                             <textarea name="personaltraits" class="form-control" placeholder="Start typing here..." required><?php echo $pdata["personaltraits"]; ?></textarea>
                                          </div>
                                          <?php $natureofstud = json_decode($pdata["natureofstudent"], true); ?>
                                          <div class="row">
                                             <div class="col-4">
                                                <div class="form-group">
                                                   <label for="exampleInputEmail1" class="form-label">Nature of Student 1</label>
                                                   
                                                   <input type="text" name="natureofstud[]" class='form-control' value='<?php echo ($natureofstud[0]=="0") ? "Aggresive" :  "Non-Aggresive" ; ?>' required>
                                                </div>
                                             </div>
                                             <div class="col-4">
                                                <div class="form-group">
                                                   <label for="exampleInputEmail1" class="form-label">Nature of Student 2</label>
                                                   <input type="text" class='form-control' name="natureofstud[]" value='<?php echo ($natureofstud[1]=="0") ? "Extrovert" :  "Introvert" ; ?>' required>
                                                </div>
                                             </div>
                                             <div class="col-4">
                                                <div class="form-group">
                                                   <label for="exampleInputEmail1" class="form-label">Nature of Student 3</label>
                                                   <input type="text" class='form-control' name="natureofstud[]" value='<?php echo ($natureofstud[2]=="0") ? "Positive Thinker" :  "Negative Thinker" ; ?>' required>
                                                </div>
                                             </div>
                                             <div class="col-12">
                                                <label for="exampleInputEmail1" class="form-label">Communication Skill at the time of Admission</label>
                                                <textarea class="form-control" name="initcommskill" placeholder="Start typing here..." required><?php echo $pdata["initcommskill"]; ?></textarea>
                                             </div>    
                                          </div>

                                        
                                 <button type="button" style='width:0;height:0;font-size: 0.1;opacity:0;position:absolute;' class="modalLoader modal-effect btn btn-primary-light d-grid mb-3" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#loaderModal" onclick="return false;">Scale</button>
                                 <button class="modalLoaderClose btn btn-light" style='width:0;height:0;font-size: 0.1;opacity:0;position:absolute;' data-bs-dismiss="modal">a</button>

                                 <br>

                                 <div class="row">
                                    <!-- <div class="col-2">
                                       <button type="submit" class="btn btn-primary">Save Details</button>
                                    </div> -->
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-primary col-12">Save Details</button>
                                    </div>

                                    <div class="col-2">
                                       <button onclick="deleteStudent();" class="btn btn-danger col-12">Delete Student</button>
                                    </div>
                                       
                                 </div>

                                 <script>
                                    let deleteStudent = () => {
                                       if(confirm("Are you sure to delete this student")) { 
                                          window.location = '../assets/backend/deleteStudent?sid=<?php echo $_GET['sid']; ?>'; 
                                       }
                                    };
                                 </script>

                                 </form>
                                
                                 <!-- <a href="javascript:void(0)" class="btn  btn-lg btn-primary">Confirm</a> -->
                              </div>
                              <!-- accounts tab -->
                              <!--<div class="tab-pane" id="tab21" role="tabpanel">-->
                              <!--    <label for="" class="form-label">Create a student before proceeding.</label>-->
                              <!--</div>-->
                              <div class="tab-pane tab21" id="tab21" role="tabpanel">
                                 
                                 <div class="d-flex country">
                                    <button class="btn btn-success" data-bs-target="#country-selector" data-bs-toggle="modal"><b>Add Dues +</b></button>
                                 </div>
                                 <!-- Add Payment modal -->
                                 <div class="modal fade" id="country-selector">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                       <div class="modal-content country-select-modal">
                                          <div class="modal-header">
                                             <h6 class="modal-title">Add Dues</h6>
                                             <button aria-label="Close" class="btn-close closeInstModal" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                          </div>
                                          <div class="modal-body">
                                             <form action="" class='insform' onsubmit="return false;">
                                                <div class="row">
                                                   <div class="col-6">
                                                      <div class="form-group">
                                                         <label class="form-label">Amount Received</label>
                                                         <input name="amount" type="number" class="form-control" placeholder="Due: ₹1000" >
                                                      </div>
                                                   </div>
                                                   <div class="col-6">
                                                      <div class="form-group">
                                                         <label class="form-label">Date</label>
                                                         <input name="date" type="date" class="form-control" placeholder="Date" >
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="form-label">Bank Name</label>
                                                   <input name="bankname" type="text" class="form-control" placeholder="" >
                                                </div>
                                                <div class="form-group">
                                                   <label class="form-label">Referance Number</label>
                                                   <input name="refno" type="text" class="form-control" placeholder="" >
                                                </div>
                                                <div class="form-group">
                                                   <textarea name="note" class="form-control" rows="4" placeholder="Admin Note"></textarea>
                                                </div>
                                                <div class="row">
                                                   <div class="col-6">
                                                      <div class="form-group">
                                                         <label class="form-label mt-0">Upload Receipt</label>
                                                         <input id="" type="file" class="form-control" name="rfile">
                                                      </div>
                                                   </div>
                                                   <div class="col-6">
                                                      <label class="form-label"> </label>
                                                      <button class="btn btn-info" onclick="saveSendInsta();"><b>Save & Send for Verification</b></button>
                                             </form>
                                             </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Add Payment modal END -->
                                 <hr>
                                 <div class="row row-sm">
                                    <div class="col-lg-12">
                                       <div class="card">
                                          <div class="card-body">
                                             <div class="row">
                                                <div class="col-6">
                                                   <div class="form-group">
                                                      <label for="exampleInputEmail1" class="form-label">Parent Occupation</label>
                                                      <input name="parocc" type="text" class="form-control" placeholder="Enter Parent Occupation" required>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="form-group">
                                                      <label for="exampleInputEmail1" class="form-label">Parent Annual Income</label>
                                                      <input name="parani" type="text" class="form-control" placeholder="Enter Annual Income" required>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-6">
                                                   <div class="form-group">
                                                      <label for="exampleInputEmail1" class="form-label">Applied for Loan</label>
                                                      <!--<input name="parocc" type="text" class="form-control" placeholder="Enter Parent Occupation" required>-->
                                                      <select class="form-control" required>
                                                         <option value='' selected required>Select Loan Status</option>
                                                         <option value='1'>Yes</option>
                                                         <option value='0'>No</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="form-group">
                                                      <label for="exampleInputEmail1" class="form-label">Loan Amount</label>
                                                      <input name="parani" type="text" class="form-control" placeholder="Enter Load Amount">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row row-sm">
                                                <div class="col-lg-12">
                                                   <div class="card">
                                                      <div class="card-header">
                                                         <h3 class="card-title">Dues</h3>
                                                      </div>
                                                      <div class="card-body">
                                                         <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                                               <thead>
                                                                  <tr>
                                                                     <th class="wd-15p border-bottom-0">S. No</th>
                                                                     <th class="wd-15p border-bottom-0">Amount</th>
                                                                     <th class="wd-20p border-bottom-0">Date</th>
                                                                     <th class="wd-15p border-bottom-0">Bank Name</th>
                                                                     <th class="wd-10p border-bottom-0">Reference no.</th>
                                                                     <th class="wd-10p border-bottom-0">Admin Note.</th>
                                                                     <th class="wd-10p border-bottom-0">File</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- document Section -->
                              <div class="tab-pane"  id="" role="tabpanel">
                                 <label for="" class="form-label">Create a student before proceeding.</label>
                              </div>
                              <div class="tab-pane tab22" id="tab22" role="tabpanel">
                                 <div class="col-xl-12">
                                    <div class="card">
                                       <!-- <div class="card-header">
                                          <h3 class="card-title">Student's Documents &nbsp; <button class="btn btn-info"><b><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp; Documents Summary</b></button></h3>
                                          </div> -->
                                       
                                    </div>
                                 </div>
                              </div>
                              <!-- end of doc section -->
                              <div class="tab-pane" id="tab23" role="tabpanel">
                                 <label for="" class="form-label">Create a student before proceeding.</label>
                              </div>
                              <div class="tab-pane tab23" id="" role="tabpanel">
                                 <div class="d-flex country">
                                    <button class="btn btn-success" data-bs-target="#country-selector2" data-bs-toggle="modal"><b>Add Dispatch Record +</b></button>
                                 </div>
                                 <!-- Add Dispatch modal -->
                                 <div class="modal fade" id="country-selector2">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                       <div class="modal-content country-select-modal">
                                          <div class="modal-header">
                                             <h6 class="modal-title">Add Dispatch </h6>
                                             <button aria-label="Close" class="btn-close closeDispModal"
                                                data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                          </div>
                                          <div class="modal-body">
                                             <div class="row">
                                                <div class="col-6">
                                                   <div class="form-group">
                                                      <label class="form-label">Dispatch Type</label>
                                                      <form class="disform" method="POST" onsubmit="return false;" enctype="multipart/form-data">
                                                         <select name="distype" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                            <option value="0">Registered Speed Post</option>
                                                            <option value="1">By Hand</option>
                                                            <option value="2">Courier</option>
                                                         </select>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                <div class="form-group">
                                                <label class="form-label">Dispatch Date</label>
                                                <input name="date" type="date" class="form-control" placeholder="Date" name="date">
                                                </div>
                                                </div>
                                             </div>
                                             <div class="form-group">
                                             <label class="form-label">Tracking ID</label>
                                             <input type="text" class="form-control" placeholder="" name="trackid">
                                             </div>
                                             <div class="form-group">
                                             <label class="form-label">Dispatch Remarks</label>
                                             <input  type="text" class="form-control" placeholder="" name="remarks" >
                                             </div>
                                             <div class="row">
                                             <div class="col-6">
                                             <div class="form-group">
                                             <label class="form-label mt-0">Upload Receipt</label>
                                             <input id="" type="file" class="form-control" name="recfile">
                                             </div>
                                             </div>
                                             <div class="col-6">
                                             <label class="form-label"> </label>
                                             <button class="btn btn-info" onclick="saveDisp();" type="button"><b>Save Dispatch Record</b></button>
                                             </form>
                                             </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Add dispatch modal END -->
                                 <hr>
                                 <div class="col-xl-12">
                                    <div class="card">
                                       <!-- <div class="card-header">
                                          <h3 class="card-title">Dispatch History &nbsp; <button class="btn btn-info"><b><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp; Dispatch Summary</b></button></h3>
                                          </div> -->
                                       <div class="card-body">
                                          <p>• Hover on the payment status to know more.</p>
                                          <div class="table-responsive">
                                             <table class="table border text-nowrap text-md-nowrap table-striped mb-0" id='distable'>
                                                <!-- <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable"> -->
                                                <thead>
                                                   <tr>
                                                      <th>SN.</th>
                                                      <th>Date</th>
                                                      <th>Type</th>
                                                      <th>Tracking ID</th>
                                                      <th>Remarks</th>
                                                      <th>Receipt</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
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

    <?php if(isset($_SESSION['message'])) {
        if($_SESSION['message']=="1") {
            ?>
            <script>swal('Hooray!', 'Student details have been updated successfully!', 'success');</script>
            <?php
        }else {
            ?>
            <script>
                swal({
                    title: "Alert",
                    text: "Updation was unsuccessfull! Please contact administrator",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
                </script>
            <?php
        }
        unset($_SESSION['message']);
    } ?>
    <?php if(isset($_SESSION['delSucc'])) {
        if($_SESSION['delSucc']=="1") {
            ?>
            <script>swal('Hooray!', 'Student Deletion Successfull!', 'success');</script>
            <?php
        }else {
            ?>
            <script>
                swal({
                    title: "Alert",
                    text: "Deletion was unsuccessfull! Please contact administrator",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
                </script>
            <?php
        }
        unset($_SESSION['delSucc']);
    } ?>
</body>
</html>