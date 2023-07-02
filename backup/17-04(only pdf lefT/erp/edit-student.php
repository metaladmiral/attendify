<?php 
session_start();
require_once 'conn.php';
$conn = new Db;

$sql = "SELECT * FROM `students` WHERE `studid`='".$_GET['sid']."' ";
$query = $conn->mconnect()->prepare($sql);
$query->execute();
if($query->rowCount()==0){
    header('Location: ../404.php');
    die();
}
$pdata = $query->fetch(PDO::FETCH_ASSOC);
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
                            <h1 class="page-title">Edit Student</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Student</li>
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
                                    <ul class="tabs-menu nav" role="tablist">
                                        <?php if($_SESSION['usertype']=="0") { ?>
                                        <li class=""><a href="#tab20" class="active" data-bs-toggle="tab" aria-selected="true" role="tab"><i class="fa fe fe-users"></i> Student Details</a></li>
                                        <li><a href="#tab21" data-bs-toggle="tab" class="" aria-selected="false" tabindex="-1" role="tab"><i class="fa fe fe-layers"></i>  Accounts</a></li>
                                        <li><a href="#tab22" data-bs-toggle="tab" class="" aria-selected="false" tabindex="-1" role="tab"><i class="fa fe fe-database"></i>  Documents & Result</a></li>
                                        <li><a href="#tab23" data-bs-toggle="tab" class="" aria-selected="false" tabindex="-1" role="tab"><i class="fa fe fe-truck"></i>  Dispatch</a></li>
                                        <?php }else if($_SESSION['usertype']=="1") { ?>
                                            <li class=""><a href="#tab20" class="active" data-bs-toggle="tab" aria-selected="true" role="tab"><i class="fa fe fe-users"></i> Student Details</a></li>
                                        <?php }else if($_SESSION['usertype']=="2") { ?>
                                            <li><a href="#tab21" data-bs-toggle="tab" class="active" aria-selected="true" tabindex="-1" role="tab"><i class="fa fe fe-layers"></i>  Accounts</a></li>
                                        <?php }else if($_SESSION['usertype']=="3") { ?>
                                            <li><a href="#tab22" data-bs-toggle="tab" class="active" aria-selected="true" tabindex="-1" role="tab"><i class="fa fe fe-database"></i>  Documents & Result</a></li>
                                        <?php }else if($_SESSION['usertype']=="4") { ?>
                                            <li><a href="#tab23" data-bs-toggle="tab" class="active" aria-selected="true" tabindex="-1" role="tab"><i class="fa fe fe-truck"></i>  Dispatch</a></li>
                                        <?php }else { ?>
                                            <script>
                                                swal({
                                                    title: "Oops!",
                                                    text: "You do not have permission for this section of the website!",
                                                    type: "warning",
                                                    showCancelButton: false
                                                });
                                                setTimeout(() => {
                                                    window.location = './index';
                                                }, 3500);
                                            </script>
                                        <?php } ?>
                                    </ul>
                                    <hr>
                                    <div class="tab-content">
                                        <div class="tab-pane <?php if($_SESSION['usertype']=="1" || $_SESSION['usertype']=="0") { ?> active show <?php } ?>" id="tab20" role="tabpanel">
                                           <!-- Batch select tag -->
                                           
                                          <div class="row">
                                          <div class="col-6">

                                          <form action='../assets/backend/editstud_script.php' method="POST">
                                              
                                            <div class="form-group">
                                                <label class="form-label">Batch</label>
                                                <select name="batch" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <option value="">Select Batch</option>
                                                    <?php 
                                                        $sql = "SELECT * FROM `batches`";
                                                        $query = $conn->mconnect()->prepare($sql);
                                                        $query->execute();
                                                        $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($data as $key => $value) {
                                                            if($pdata["batchid"]==$value["batchid"]) {
                                                            ?>
                                                            <option value="<?php echo $value['batchid']; ?>" selected><?php echo $value['batchLabel']; ?></option>                                                    
                                                            <?php 
                                                            }else {
                                                                ?>
                                                            <option value="<?php echo $value['batchid']; ?>"><?php echo $value['batchLabel']; ?></option>                                                    
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <!--  -->
                                            
                                        </div>
                                        <div class="col-6">
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Councellor</label>
                                                <select name="counsellor" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <option value="">Select Counsellor</option>
                                                    <?php 
                                                        $sql = "SELECT * FROM `users` WHERE `usertype`='3' ";
                                                        $query = $conn->mconnect()->prepare($sql);
                                                        $query->execute();
                                                        $data= $query->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($data as $key => $value) {
                                                            if($pdata["counsid"]==$value["uid"]) {
                                                                ?>
                                                                <option value="<?php echo $value['uid']; ?>" selected><?php echo $value['username']; ?> - <?php echo $value['email']; ?></option>                                                    
                                                                <?php 
                                                                }else {
                                                                ?>
                                                                <option value="<?php echo $value['uid']; ?>"><?php echo $value['username']; ?> - <?php echo $value['email']; ?></option>                                                    
                                                                <?php
                                                                }
                                                            ?>
                                                            
                                                            <?php 
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <!--  -->
                                            
                                        </div>

                                         </div>

                                            
                                            <div class="row">
                                          <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Registration Status</label>
                                                <select name="regstatus" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <option value="0" <?php echo ($pdata["regstatus"]=="0") ? "selected" : ""; ?>>Not Eligible</option>
                                                    <option value="1" <?php echo ($pdata["regstatus"]=="1") ? "selected" : ""; ?>>Pending</option>
                                                    <option value="2" <?php echo ($pdata["regstatus"]=="2") ? "selected" : ""; ?>>Done</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Admission Date</label>
                                                <input name="admdate" type="date" class="form-control" placeholder="Enter email" value=<?php echo $pdata['dor']; ?> required>
                                            </div>
                                            </div>
                                            </div>
                                            
                                            
                                            <div class="row">
                                          <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Fee Commitment</label>
                                                <input type="text" class='form-control' name="feecomm" value='<?php echo $pdata['totalfee']; ?>' required>
                                            </div>
                                            </div>
                                            <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Roll Number Status</label>
                                                <select name="rollnostatus" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <option value="0" <?php echo ($pdata["rollstatus"]=="0") ? "selected" : ""; ?>>Roll Number Received</option>
                                                    <option value="1" <?php echo ($pdata["rollstatus"]=="1") ? "selected" : ""; ?>>Pendency</option>
                                                    <option value="2" <?php echo ($pdata["rollstatus"]=="2") ? "selected" : ""; ?>>LGS Verified</option>
                                                    <option value="3" <?php echo ($pdata["rollstatus"]=="3") ? "selected" : ""; ?>>LGS Not Verified</option>
                                                    <option value="4" <?php echo ($pdata["rollstatus"]=="4") ? "selected" : ""; ?>>IBOSE</option>
                                                    <option value="4" <?php echo ($pdata["rollstatus"]=="5") ? "selected" : ""; ?>>Below 5000</option>
                                                    <option value="4" <?php echo ($pdata["rollstatus"]=="6") ? "selected" : ""; ?>>Cancelled</option>
                                                   
                                                </select>
                                            </div>
                                            </div>
                                            </div>
                                            

                                            <div class="row">
                                                <?php
                                                $rolls = json_decode($pdata["rollnos"], true);
                                                $name = explode(' ', $pdata["name"]);
                                                $firstname = $name[0];
                                                $lastname = $name[1];
                                                ?>
                                          <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Class Roll Number</label>
                                                <input name="classroll" type="text" class="form-control" placeholder="Enter Class Roll Number" value='<?php echo $rolls["classroll"]; ?>'>
                                            </div>
                                            </div>
                                            <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">University Roll Number</label>
                                                <input name="uniroll" type="text" class="form-control" placeholder="Enter University Roll Number" value='<?php echo $rolls["uniroll"]; ?>'>
                                            </div>
                                            </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Email ID</label>
                                                <input name="email" type="email" class="form-control" placeholder="Enter email" value='<?php echo $pdata['email']; ?>' required>
                                            </div>
                                            <div class="row">
                                          <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">First Name</label>
                                                <input name="firstname" type="text" class="form-control" placeholder="Enter First Name" value='<?php echo  $firstname; ?>'  required>
                                            </div>
                                            </div>
                                            <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                                <input name="lastname" type="text" class="form-control" placeholder="Enter Last Name" value='<?php echo  $lastname; ?>'  required>
                                            </div>
                                            </div>
                                            </div>
                                            
                                            <div class="row">
                                          <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Father's Name</label>
                                                <input name="fname" type="text" class="form-control" placeholder="Enter Father's Name" value='<?php echo $pdata["fname"]; ?>' required>
                                            </div>
                                            </div>
                                            <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Mother's Name</label>
                                                <input name="mname" type="text" class="form-control" placeholder="Enter Mother's Name" value='<?php echo $pdata["mname"]; ?>' required>
                                            </div>
                                            </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="row">
                                          <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Date of Birth</label>
                                                <input name="dob" type="date" class="form-control" placeholder="Enter Date of Birth" value='<?php echo $pdata["dob"]; ?>' required>
                                            </div>
                                            </div>
                                            
                                            <div class="col-6">
                                             
                                             <label for="exampleInputEmail1" class="form-label">Mobile Number</label>
                                             
                                             <div class="row">
                                             <div class="col-4">
                                            <div class="form-group">
                                                
                                                <select name="mcc" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                                                    <option data-countryCode="AD" value="376">Andorra (+376)</option>
                                                    <option data-countryCode="AO" value="244">Angola (+244)</option>
                                                    <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                                                    <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                                                    <option data-countryCode="AR" value="54">Argentina (+54)</option>
                                                    <option data-countryCode="AM" value="374">Armenia (+374)</option>
                                                    <option data-countryCode="AW" value="297">Aruba (+297)</option>
                                                    <option data-countryCode="AU" value="61">Australia (+61)</option>
                                                    <option data-countryCode="AT" value="43">Austria (+43)</option>
                                                    <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                                                    <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                                                    <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                                                    <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                                                    <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                                                    <option data-countryCode="BY" value="375">Belarus (+375)</option>
                                                    <option data-countryCode="BE" value="32">Belgium (+32)</option>
                                                    <option data-countryCode="BZ" value="501">Belize (+501)</option>
                                                    <option data-countryCode="BJ" value="229">Benin (+229)</option>
                                                    <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                                                    <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                                                    <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                                                    <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                                                    <option data-countryCode="BW" value="267">Botswana (+267)</option>
                                                    <option data-countryCode="BR" value="55">Brazil (+55)</option>
                                                    <option data-countryCode="BN" value="673">Brunei (+673)</option>
                                                    <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                                                    <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                                                    <option data-countryCode="BI" value="257">Burundi (+257)</option>
                                                    <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                                                    <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                                                    <option data-countryCode="CA" value="1">Canada (+1)</option>
                                                    <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                                                    <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                                                    <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                                                    <option data-countryCode="CL" value="56">Chile (+56)</option>
                                                    <option data-countryCode="CN" value="86">China (+86)</option>
                                                    <option data-countryCode="CO" value="57">Colombia (+57)</option>
                                                    <option data-countryCode="KM" value="269">Comoros (+269)</option>
                                                    <option data-countryCode="CG" value="242">Congo (+242)</option>
                                                    <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                                                    <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                                                    <option data-countryCode="HR" value="385">Croatia (+385)</option>
                                                    <option data-countryCode="CU" value="53">Cuba (+53)</option>
                                                    <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                                                    <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                                                    <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                                                    <option data-countryCode="DK" value="45">Denmark (+45)</option>
                                                    <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                                                    <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                                                    <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                                                    <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                                                    <option data-countryCode="EG" value="20">Egypt (+20)</option>
                                                    <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                                                    <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                                                    <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                                                    <option data-countryCode="EE" value="372">Estonia (+372)</option>
                                                    <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                                                    <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                                                    <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                                                    <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                                                    <option data-countryCode="FI" value="358">Finland (+358)</option>
                                                    <option data-countryCode="FR" value="33">France (+33)</option>
                                                    <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                                                    <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                                                    <option data-countryCode="GA" value="241">Gabon (+241)</option>
                                                    <option data-countryCode="GM" value="220">Gambia (+220)</option>
                                                    <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                                                    <option data-countryCode="DE" value="49">Germany (+49)</option>
                                                    <option data-countryCode="GH" value="233">Ghana (+233)</option>
                                                    <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                                                    <option data-countryCode="GR" value="30">Greece (+30)</option>
                                                    <option data-countryCode="GL" value="299">Greenland (+299)</option>
                                                    <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                                                    <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                                                    <option data-countryCode="GU" value="671">Guam (+671)</option>
                                                    <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                                                    <option data-countryCode="GN" value="224">Guinea (+224)</option>
                                                    <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                                                    <option data-countryCode="GY" value="592">Guyana (+592)</option>
                                                    <option data-countryCode="HT" value="509">Haiti (+509)</option>
                                                    <option data-countryCode="HN" value="504">Honduras (+504)</option>
                                                    <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                                                    <option data-countryCode="HU" value="36">Hungary (+36)</option>
                                                    <option data-countryCode="IS" value="354">Iceland (+354)</option>
                                                    <option data-countryCode="IN" value="91" selected>India (+91)</option>
                                                    <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                                                    <option data-countryCode="IR" value="98">Iran (+98)</option>
                                                    <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                                                    <option data-countryCode="IE" value="353">Ireland (+353)</option>
                                                    <option data-countryCode="IL" value="972">Israel (+972)</option>
                                                    <option data-countryCode="IT" value="39">Italy (+39)</option>
                                                    <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                                                    <option data-countryCode="JP" value="81">Japan (+81)</option>
                                                    <option data-countryCode="JO" value="962">Jordan (+962)</option>
                                                    <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                                                    <option data-countryCode="KE" value="254">Kenya (+254)</option>
                                                    <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                                                    <option data-countryCode="KP" value="850">Korea North (+850)</option>
                                                    <option data-countryCode="KR" value="82">Korea South (+82)</option>
                                                    <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                                                    <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                                                    <option data-countryCode="LA" value="856">Laos (+856)</option>
                                                    <option data-countryCode="LV" value="371">Latvia (+371)</option>
                                                    <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                                                    <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                                                    <option data-countryCode="LR" value="231">Liberia (+231)</option>
                                                    <option data-countryCode="LY" value="218">Libya (+218)</option>
                                                    <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                                                    <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                                                    <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                                                    <option data-countryCode="MO" value="853">Macao (+853)</option>
                                                    <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                                                    <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                                                    <option data-countryCode="MW" value="265">Malawi (+265)</option>
                                                    <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                                                    <option data-countryCode="MV" value="960">Maldives (+960)</option>
                                                    <option data-countryCode="ML" value="223">Mali (+223)</option>
                                                    <option data-countryCode="MT" value="356">Malta (+356)</option>
                                                    <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                                                    <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                                                    <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                                                    <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                                                    <option data-countryCode="MX" value="52">Mexico (+52)</option>
                                                    <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                                                    <option data-countryCode="MD" value="373">Moldova (+373)</option>
                                                    <option data-countryCode="MC" value="377">Monaco (+377)</option>
                                                    <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                                                    <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                                                    <option data-countryCode="MA" value="212">Morocco (+212)</option>
                                                    <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                                                    <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                                                    <option data-countryCode="NA" value="264">Namibia (+264)</option>
                                                    <option data-countryCode="NR" value="674">Nauru (+674)</option>
                                                    <option data-countryCode="NP" value="977">Nepal (+977)</option>
                                                    <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                                                    <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                                                    <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                                                    <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                                                    <option data-countryCode="NE" value="227">Niger (+227)</option>
                                                    <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                                                    <option data-countryCode="NU" value="683">Niue (+683)</option>
                                                    <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                                                    <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                                                    <option data-countryCode="NO" value="47">Norway (+47)</option>
                                                    <option data-countryCode="OM" value="968">Oman (+968)</option>
                                                    <option data-countryCode="PW" value="680">Palau (+680)</option>
                                                    <option data-countryCode="PA" value="507">Panama (+507)</option>
                                                    <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                                                    <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                                                    <option data-countryCode="PE" value="51">Peru (+51)</option>
                                                    <option data-countryCode="PH" value="63">Philippines (+63)</option>
                                                    <option data-countryCode="PL" value="48">Poland (+48)</option>
                                                    <option data-countryCode="PT" value="351">Portugal (+351)</option>
                                                    <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                                                    <option data-countryCode="QA" value="974">Qatar (+974)</option>
                                                    <option data-countryCode="RE" value="262">Reunion (+262)</option>
                                                    <option data-countryCode="RO" value="40">Romania (+40)</option>
                                                    <option data-countryCode="RU" value="7">Russia (+7)</option>
                                                    <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                                                    <option data-countryCode="SM" value="378">San Marino (+378)</option>
                                                    <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                                                    <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                                                    <option data-countryCode="SN" value="221">Senegal (+221)</option>
                                                    <option data-countryCode="CS" value="381">Serbia (+381)</option>
                                                    <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                                                    <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                                                    <option data-countryCode="SG" value="65">Singapore (+65)</option>
                                                    <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                                                    <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                                                    <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                                                    <option data-countryCode="SO" value="252">Somalia (+252)</option>
                                                    <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                                                    <option data-countryCode="ES" value="34">Spain (+34)</option>
                                                    <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                                                    <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                                                    <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                                                    <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                                                    <option data-countryCode="SD" value="249">Sudan (+249)</option>
                                                    <option data-countryCode="SR" value="597">Suriname (+597)</option>
                                                    <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                                                    <option data-countryCode="SE" value="46">Sweden (+46)</option>
                                                    <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                                                    <option data-countryCode="SI" value="963">Syria (+963)</option>
                                                    <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                                                    <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                                                    <option data-countryCode="TH" value="66">Thailand (+66)</option>
                                                    <option data-countryCode="TG" value="228">Togo (+228)</option>
                                                    <option data-countryCode="TO" value="676">Tonga (+676)</option>
                                                    <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                                                    <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                                                    <option data-countryCode="TR" value="90">Turkey (+90)</option>
                                                    <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                                                    <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                                                    <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                                                    <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                                                    <option data-countryCode="UG" value="256">Uganda (+256)</option>
                                                    <option data-countryCode="GB" value="44">UK (+44)</option>
                                                    <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                                                    <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                                                    <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                                                    <option data-countryCode="US" value="1">USA (+1)</option>
                                                    <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                                                    <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                                                    <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                                                    <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                                                    <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                                                    <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                                                    <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                                                    <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                                                    <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                                                    <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                                                    <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                                                    <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                                                   
                                                </select>
                                                
                                            </div>
                                            </div>
                                                <div class="col-8">
                                            <div class="form-group">
                                                
                                                <input name="mno" type="number" class="form-control" placeholder="Enter Mobile Number" value='<?php echo $pdata['contact']; ?>' required>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            
                                            
                                            
                                            </div>

                                            <div class="row">
                                          <div class="col-6">
                                            
                                             
                                             <label for="exampleInputEmail1" class="form-label">Mobile Number (Alternate)</label>
                                             
                                             <div class="row">
                                             <div class="col-4">
                                            <div class="form-group">
                                                
                                                <select name="macc" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option data-countryCode="CO" value="57">Colombia (+57)</option>
		<option data-countryCode="KM" value="269">Comoros (+269)</option>
		<option data-countryCode="CG" value="242">Congo (+242)</option>
		<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385">Croatia (+385)</option>
		<option data-countryCode="CU" value="53">Cuba (+53)</option>
		<option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357">Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45">Denmark (+45)</option>
		<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593">Ecuador (+593)</option>
		<option data-countryCode="EG" value="20">Egypt (+20)</option>
		<option data-countryCode="SV" value="503">El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291">Eritrea (+291)</option>
		<option data-countryCode="EE" value="372">Estonia (+372)</option>
		<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679">Fiji (+679)</option>
		<option data-countryCode="FI" value="358">Finland (+358)</option>
		<option data-countryCode="FR" value="33">France (+33)</option>
		<option data-countryCode="GF" value="594">French Guiana (+594)</option>
		<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241">Gabon (+241)</option>
		<option data-countryCode="GM" value="220">Gambia (+220)</option>
		<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
		<option data-countryCode="DE" value="49">Germany (+49)</option>
		<option data-countryCode="GH" value="233">Ghana (+233)</option>
		<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30">Greece (+30)</option>
		<option data-countryCode="GL" value="299">Greenland (+299)</option>
		<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91" selected>India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea North (+850)</option>
		<option data-countryCode="KR" value="82">Korea South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option data-countryCode="LV" value="371">Latvia (+371)</option>
		<option data-countryCode="LB" value="961">Lebanon (+961)</option>
		<option data-countryCode="LS" value="266">Lesotho (+266)</option>
		<option data-countryCode="LR" value="231">Liberia (+231)</option>
		<option data-countryCode="LY" value="218">Libya (+218)</option>
		<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370">Lithuania (+370)</option>
		<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853">Macao (+853)</option>
		<option data-countryCode="MK" value="389">Macedonia (+389)</option>
		<option data-countryCode="MG" value="261">Madagascar (+261)</option>
		<option data-countryCode="MW" value="265">Malawi (+265)</option>
		<option data-countryCode="MY" value="60">Malaysia (+60)</option>
		<option data-countryCode="MV" value="960">Maldives (+960)</option>
		<option data-countryCode="ML" value="223">Mali (+223)</option>
		<option data-countryCode="MT" value="356">Malta (+356)</option>
		<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596">Martinique (+596)</option>
		<option data-countryCode="MR" value="222">Mauritania (+222)</option>
		<option data-countryCode="YT" value="269">Mayotte (+269)</option>
		<option data-countryCode="MX" value="52">Mexico (+52)</option>
		<option data-countryCode="FM" value="691">Micronesia (+691)</option>
		<option data-countryCode="MD" value="373">Moldova (+373)</option>
		<option data-countryCode="MC" value="377">Monaco (+377)</option>
		<option data-countryCode="MN" value="976">Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212">Morocco (+212)</option>
		<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
		<option data-countryCode="MN" value="95">Myanmar (+95)</option>
		<option data-countryCode="NA" value="264">Namibia (+264)</option>
		<option data-countryCode="NR" value="674">Nauru (+674)</option>
		<option data-countryCode="NP" value="977">Nepal (+977)</option>
		<option data-countryCode="NL" value="31">Netherlands (+31)</option>
		<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
		<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227">Niger (+227)</option>
		<option data-countryCode="NG" value="234">Nigeria (+234)</option>
		<option data-countryCode="NU" value="683">Niue (+683)</option>
		<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47">Norway (+47)</option>
		<option data-countryCode="OM" value="968">Oman (+968)</option>
		<option data-countryCode="PW" value="680">Palau (+680)</option>
		<option data-countryCode="PA" value="507">Panama (+507)</option>
		<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595">Paraguay (+595)</option>
		<option data-countryCode="PE" value="51">Peru (+51)</option>
		<option data-countryCode="PH" value="63">Philippines (+63)</option>
		<option data-countryCode="PL" value="48">Poland (+48)</option>
		<option data-countryCode="PT" value="351">Portugal (+351)</option>
		<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974">Qatar (+974)</option>
		<option data-countryCode="RE" value="262">Reunion (+262)</option>
		<option data-countryCode="RO" value="40">Romania (+40)</option>
		<option data-countryCode="RU" value="7">Russia (+7)</option>
		<option data-countryCode="RW" value="250">Rwanda (+250)</option>
		<option data-countryCode="SM" value="378">San Marino (+378)</option>
		<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221">Senegal (+221)</option>
		<option data-countryCode="CS" value="381">Serbia (+381)</option>
		<option data-countryCode="SC" value="248">Seychelles (+248)</option>
		<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65">Singapore (+65)</option>
		<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386">Slovenia (+386)</option>
		<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252">Somalia (+252)</option>
		<option data-countryCode="ZA" value="27">South Africa (+27)</option>
		<option data-countryCode="ES" value="34">Spain (+34)</option>
		<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290">St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249">Sudan (+249)</option>
		<option data-countryCode="SR" value="597">Suriname (+597)</option>
		<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
		<option data-countryCode="SE" value="46">Sweden (+46)</option>
		<option data-countryCode="CH" value="41">Switzerland (+41)</option>
		<option data-countryCode="SI" value="963">Syria (+963)</option>
		<option data-countryCode="TW" value="886">Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66">Thailand (+66)</option>
		<option data-countryCode="TG" value="228">Togo (+228)</option>
		<option data-countryCode="TO" value="676">Tonga (+676)</option>
		<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216">Tunisia (+216)</option>
		<option data-countryCode="TR" value="90">Turkey (+90)</option>
		<option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
		<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256">Uganda (+256)</option>
		<option data-countryCode="GB" value="44">UK (+44)</option>
		<option data-countryCode="UA" value="380">Ukraine (+380)</option>
		<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598">Uruguay (+598)</option>
		<option data-countryCode="US" value="1">USA (+1)</option>
		<option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
		<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379">Vatican City (+379)</option>
		<option data-countryCode="VE" value="58">Venezuela (+58)</option>
		<option data-countryCode="VN" value="84">Vietnam (+84)</option>
		<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
		<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260">Zambia (+260)</option>
		<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                                                   
                                                </select>
                                                
                                            </div>
                                            </div>
                                                <div class="col-8">
                                            <div class="form-group">
                                                
                                                <input name="mano" type="number" class="form-control" placeholder="Enter Alternate Mobile Number" value='<?php echo $pdata['alternateno']; ?>'>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                           
                                            <div class="col-6">
                                            
                                             
                                             <label for="exampleInputEmail1" class="form-label">Whatsapp Numbar</label>
                                             
                                             <div class="row">
                                             <div class="col-4">
                                            <div class="form-group">
                                                
                                                <select name="wacc" class="form-control" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                                    <option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option data-countryCode="CO" value="57">Colombia (+57)</option>
		<option data-countryCode="KM" value="269">Comoros (+269)</option>
		<option data-countryCode="CG" value="242">Congo (+242)</option>
		<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385">Croatia (+385)</option>
		<option data-countryCode="CU" value="53">Cuba (+53)</option>
		<option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357">Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45">Denmark (+45)</option>
		<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593">Ecuador (+593)</option>
		<option data-countryCode="EG" value="20">Egypt (+20)</option>
		<option data-countryCode="SV" value="503">El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291">Eritrea (+291)</option>
		<option data-countryCode="EE" value="372">Estonia (+372)</option>
		<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679">Fiji (+679)</option>
		<option data-countryCode="FI" value="358">Finland (+358)</option>
		<option data-countryCode="FR" value="33">France (+33)</option>
		<option data-countryCode="GF" value="594">French Guiana (+594)</option>
		<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241">Gabon (+241)</option>
		<option data-countryCode="GM" value="220">Gambia (+220)</option>
		<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
		<option data-countryCode="DE" value="49">Germany (+49)</option>
		<option data-countryCode="GH" value="233">Ghana (+233)</option>
		<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30">Greece (+30)</option>
		<option data-countryCode="GL" value="299">Greenland (+299)</option>
		<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91" selected>India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea North (+850)</option>
		<option data-countryCode="KR" value="82">Korea South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option data-countryCode="LV" value="371">Latvia (+371)</option>
		<option data-countryCode="LB" value="961">Lebanon (+961)</option>
		<option data-countryCode="LS" value="266">Lesotho (+266)</option>
		<option data-countryCode="LR" value="231">Liberia (+231)</option>
		<option data-countryCode="LY" value="218">Libya (+218)</option>
		<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370">Lithuania (+370)</option>
		<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853">Macao (+853)</option>
		<option data-countryCode="MK" value="389">Macedonia (+389)</option>
		<option data-countryCode="MG" value="261">Madagascar (+261)</option>
		<option data-countryCode="MW" value="265">Malawi (+265)</option>
		<option data-countryCode="MY" value="60">Malaysia (+60)</option>
		<option data-countryCode="MV" value="960">Maldives (+960)</option>
		<option data-countryCode="ML" value="223">Mali (+223)</option>
		<option data-countryCode="MT" value="356">Malta (+356)</option>
		<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596">Martinique (+596)</option>
		<option data-countryCode="MR" value="222">Mauritania (+222)</option>
		<option data-countryCode="YT" value="269">Mayotte (+269)</option>
		<option data-countryCode="MX" value="52">Mexico (+52)</option>
		<option data-countryCode="FM" value="691">Micronesia (+691)</option>
		<option data-countryCode="MD" value="373">Moldova (+373)</option>
		<option data-countryCode="MC" value="377">Monaco (+377)</option>
		<option data-countryCode="MN" value="976">Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212">Morocco (+212)</option>
		<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
		<option data-countryCode="MN" value="95">Myanmar (+95)</option>
		<option data-countryCode="NA" value="264">Namibia (+264)</option>
		<option data-countryCode="NR" value="674">Nauru (+674)</option>
		<option data-countryCode="NP" value="977">Nepal (+977)</option>
		<option data-countryCode="NL" value="31">Netherlands (+31)</option>
		<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
		<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227">Niger (+227)</option>
		<option data-countryCode="NG" value="234">Nigeria (+234)</option>
		<option data-countryCode="NU" value="683">Niue (+683)</option>
		<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47">Norway (+47)</option>
		<option data-countryCode="OM" value="968">Oman (+968)</option>
		<option data-countryCode="PW" value="680">Palau (+680)</option>
		<option data-countryCode="PA" value="507">Panama (+507)</option>
		<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595">Paraguay (+595)</option>
		<option data-countryCode="PE" value="51">Peru (+51)</option>
		<option data-countryCode="PH" value="63">Philippines (+63)</option>
		<option data-countryCode="PL" value="48">Poland (+48)</option>
		<option data-countryCode="PT" value="351">Portugal (+351)</option>
		<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974">Qatar (+974)</option>
		<option data-countryCode="RE" value="262">Reunion (+262)</option>
		<option data-countryCode="RO" value="40">Romania (+40)</option>
		<option data-countryCode="RU" value="7">Russia (+7)</option>
		<option data-countryCode="RW" value="250">Rwanda (+250)</option>
		<option data-countryCode="SM" value="378">San Marino (+378)</option>
		<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221">Senegal (+221)</option>
		<option data-countryCode="CS" value="381">Serbia (+381)</option>
		<option data-countryCode="SC" value="248">Seychelles (+248)</option>
		<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65">Singapore (+65)</option>
		<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386">Slovenia (+386)</option>
		<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252">Somalia (+252)</option>
		<option data-countryCode="ZA" value="27">South Africa (+27)</option>
		<option data-countryCode="ES" value="34">Spain (+34)</option>
		<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290">St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249">Sudan (+249)</option>
		<option data-countryCode="SR" value="597">Suriname (+597)</option>
		<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
		<option data-countryCode="SE" value="46">Sweden (+46)</option>
		<option data-countryCode="CH" value="41">Switzerland (+41)</option>
		<option data-countryCode="SI" value="963">Syria (+963)</option>
		<option data-countryCode="TW" value="886">Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66">Thailand (+66)</option>
		<option data-countryCode="TG" value="228">Togo (+228)</option>
		<option data-countryCode="TO" value="676">Tonga (+676)</option>
		<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216">Tunisia (+216)</option>
		<option data-countryCode="TR" value="90">Turkey (+90)</option>
		<option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
		<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256">Uganda (+256)</option>
		<option data-countryCode="GB" value="44">UK (+44)</option>
		<option data-countryCode="UA" value="380">Ukraine (+380)</option>
		<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598">Uruguay (+598)</option>
		<option data-countryCode="US" value="1">USA (+1)</option>
		<option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
		<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379">Vatican City (+379)</option>
		<option data-countryCode="VE" value="58">Venezuela (+58)</option>
		<option data-countryCode="VN" value="84">Vietnam (+84)</option>
		<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
		<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260">Zambia (+260)</option>
		<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                                                   
                                                </select>
                                                
                                            </div>
                                            </div>
                                                <div class="col-8">
                                            <div class="form-group">
                                                
                                                <input name="wano" type="number" class="form-control" placeholder="Enter WhatsApp Number" value='<?php echo $pdata['wano']; ?>' required>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Aadhar Card Number</label>
                                                <input name="aadharno" type="text" class="form-control" placeholder="Enter Aadhar Card / VID Number" value='<?php echo $pdata['aadharno']; ?>' required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Address</label>
                                                <input name="address" type="text" class="form-control" placeholder="Enter Address" value='<?php echo $pdata['address']; ?>' required>
                                            </div>
                                            
                                           <!-- <div class="row">
                                          <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">State</label>
                                                <select name="state" id="stateinput" class="form-control" data-placeholder="Choose State" tabindex="-1" aria-hidden="true">
                                                    <option value="Andra Pradesh" <?php echo ($pdata["state"]=="Andra Pradesh") ? "selected" : ""; ?>>Andra Pradesh</option>
                                                    <option value="Arunachal Pradesh" <?php echo ($pdata["state"]=="Arunachal Pradesh") ? "selected" : ""; ?>>Arunachal Pradesh</option>
                                                    <option value="Assam" <?php echo ($pdata["state"]=="Assam") ? "selected" : ""; ?>>Assam</option>
                                                    <option value="Bihar" <?php echo ($pdata["state"]=="Bihar") ? "selected" : ""; ?>>Bihar</option>
                                                    <option value="Chhattisgarh" <?php echo ($pdata["state"]=="Chhattisgarh") ? "selected" : ""; ?>>Chhattisgarh</option>
                                                    <option value="Goa" <?php echo ($pdata["state"]=="Goa") ? "selected" : ""; ?>>Goa</option>
                                                    <option value="Gujarat" <?php echo ($pdata["state"]=="Gujarat") ? "selected" : ""; ?>>Gujarat</option>
                                                    <option value="Haryana" <?php echo ($pdata["state"]=="Haryana") ? "selected" : ""; ?>>Haryana</option>
                                                    <option value="Himachal Pradesh" <?php echo ($pdata["state"]=="Himachal Pradesh") ? "selected" : ""; ?>>Himachal Pradesh</option>
                                                    <option value="Jammu and Kashmir" <?php echo ($pdata["state"]=="and Kashmir") ? "selected" : ""; ?>>Jammu and Kashmir</option>
                                                    <option value="Jharkhand" <?php echo ($pdata["state"]=="Jharkhand") ? "selected" : ""; ?>>Jharkhand</option>
                                                    <option value="Karnataka" <?php echo ($pdata["state"]=="Karnataka") ? "selected" : ""; ?>>Karnataka</option>
                                                    <option value="Kerala" <?php echo ($pdata["state"]=="Kerala") ? "selected" : ""; ?>>Kerala</option>
                                                    <option value="Madya Pradesh" <?php echo ($pdata["state"]=="Madya Pradesh") ? "selected" : ""; ?>>Madya Pradesh</option>
                                                    <option value="Maharashtra" <?php echo ($pdata["state"]=="Maharashtra") ? "selected" : ""; ?>>Maharashtra</option>
                                                    <option value="Manipur" <?php echo ($pdata["state"]=="Manipur") ? "selected" : ""; ?>>Manipur</option>
                                                    <option value="Meghalaya" <?php echo ($pdata["state"]=="Meghalaya") ? "selected" : ""; ?>>Meghalaya</option>
                                                    <option value="Mizoram" <?php echo ($pdata["state"]=="Mizoram") ? "selected" : ""; ?>>Mizoram</option>
                                                    <option value="Nagaland" <?php echo ($pdata["state"]=="Nagaland") ? "selected" : ""; ?>>Nagaland</option>
                                                    <option value="Orissa" <?php echo ($pdata["state"]=="Orissa") ? "selected" : ""; ?>>Orissa</option>
                                                    <option value="Punjab" <?php echo ($pdata["state"]=="Punjab") ? "selected" : ""; ?>>Punjab</option>
                                                    <option value="Rajasthan" <?php echo ($pdata["state"]=="Rajasthan") ? "selected" : ""; ?>>Rajasthan</option>
                                                    <option value="Sikkim" <?php echo ($pdata["state"]=="Sikkim") ? "selected" : ""; ?>>Sikkim</option>
                                                    <option value="Tamil Nadu" <?php echo ($pdata["state"]=="Nadu") ? "selected" : ""; ?>>Tamil Nadu</option>
                                                    <option value="Telangana" <?php echo ($pdata["state"]=="Telangana") ? "selected" : ""; ?>>Telangana</option>
                                                    <option value="Tripura" <?php echo ($pdata["state"]=="Tripura") ? "selected" : ""; ?>>Tripura</option>
                                                    <option value="Uttaranchal" <?php echo ($pdata["state"]=="Uttaranchal") ? "selected" : ""; ?>>Uttaranchal</option>
                                                    <option value="Uttar Pradesh" <?php echo ($pdata["state"]=="Uttar Pradesh") ? "selected" : ""; ?>>Uttar Pradesh</option>
                                                    <option value="West Bengal" <?php echo ($pdata["state"]=="West Bengal") ? "selected" : ""; ?>>West Bengal</option>
                                                    <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                                                    <option value="Andaman and Nicobar Islands" <?php echo ($pdata["state"]=="Andaman and Nicobar Islands") ? "selected" : ""; ?>>Andaman and Nicobar Islands</option>
                                                    <option value="Chandigarh" <?php echo ($pdata["state"]=="Chandigarh") ? "selected" : ""; ?>>Chandigarh</option>
                                                    <option value="Dadar and Nagar Haveli" <?php echo ($pdata["state"]=="Dadar and Nagar Haveli") ? "selected" : ""; ?>>Dadar and Nagar Haveli</option>
                                                    <option value="Daman and Diu" <?php echo ($pdata["state"]=="Daman and Diu") ? "selected" : ""; ?>>Daman and Diu</option>
                                                    <option value="Delhi" <?php echo ($pdata["state"]=="Delhi") ? "selected" : ""; ?>>Delhi</option>
                                                    <option value="Lakshadeep" <?php echo ($pdata["state"]=="Lakshadeep") ? "selected" : ""; ?>>Lakshadeep</option>
                                                    <option value="Pondicherry" <?php echo ($pdata["state"]=="Pondicherry") ? "selected" : ""; ?>>Pondicherry</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">District</label>
                                                <select class="form-control" id="inputDistrict">
                                                    <option value="">Choose State, then Select District</option>
                                                </select>
                                            </div>
                                            </div> 
                                            </div>-->
                                            
                                            <!-- <a href="#tab21" data-bs-toggle="tab" class="" aria-selected="false" tabindex="-1" role="tab"><button class="btn btn-primary" onclick="">Add Student</button></a> -->
                                            <!-- &nbsp;&nbsp;&nbsp; -->
                                             <input type="hidden" name="studid" value="<?php echo $_GET['sid']; ?>">
                                            <button class="btn btn-primary" onclick="updateStudent('<?php echo $_GET['sid']; ?>', 'general');" type="submit">Save</button>
                                                    </form>
                                            <!-- <a href="javascript:void(0)" class="btn  btn-lg btn-primary">Confirm</a> -->
                                        </div>
                                        
                                        
                                        
                                        
                                        <!-- accounts tab -->
                                        <!-- $(".ttfees")[0].value = resp.totalfee; -->
                                        <?php
                                        $totalfee = (int) $pdata['totalfee'];
                                        $totalleft = (int) $pdata['totalleft'];

                                        $totalPaid = $totalfee - $totalleft;

                                        $inst = $pdata['instalment'];
                                        if(empty($inst) OR is_null($inst)) {
                                            $appinst = 0;
                                        }
                                        else {
                                            $inst = json_decode($inst, true);
                                            $appinst = 0;
                                            foreach ($inst as $key => $value) {
                                                if($value["status"]=="1") {$appinst += 1;}
                                            }
                                        }
                                        
                                        ?>
                                        <div class="tab-pane <?php if($_SESSION['usertype']=="2") { ?> active show <?php } ?>" id="tab21" role="tabpanel">
                                            <div class="d-flex country">
                                            <button class="btn btn-success" data-bs-target="#country-selector" data-bs-toggle="modal"><b>Add Payment +</b></button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-light" disabled><b><span style="color:brown;">Total Fee: ₹<span class='ttfees'><?php echo $totalfee; ?></span></span></b></button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-light" disabled><b><span style="color:green;">Total Paid: ₹<span class='paidfees'><?php echo $totalPaid; ?></span></span></b></button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-light" disabled><b><span style="color:red;">Fee Due: ₹<span class='leftfees'><?php echo $totalleft; ?></span></span></b></button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-light" disabled><b><span style="color:blue;">Approved Installments: <span class='apvdinst'><?php echo $appinst; ?></span></span></b></button>
                                            
                                            
                                            </div>
                                            
                                            <!-- Add Payment modal -->
                                            <div class="modal fade" id="country-selector">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content country-select-modal">
                    <div class="modal-header">
                        <h6 class="modal-title">Add Payments | <?php echo $pdata['name']; ?></h6><button class='closeInstModal' aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        
                        
                        <div class="row">
                        <div class="col-6">
                        <div class="form-group">
                            <form action="" method="post" enctype='multipart/form-data' class='insform' onsubmit="return false;">
                        <label class="form-label">Amount Received *</label>
                        <input name="amount" type="number" class="form-control" placeholder="Due: ₹1000">
                        </div>
                        </div>
                        <div class="col-6">
                        <div class="form-group">
                        <label class="form-label">Date *</label>
                        <input name="date" type="date" class="form-control" placeholder="Date" >
                        </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <label class="form-label">Bank Name *</label>
                        <input name="bankname" type="text" class="form-control" placeholder="" >
                        </div>
                        
                        <div class="form-group">
                        <label class="form-label">Referance Number *</label>
                        <input name="refno" type="text" class="form-control" placeholder="" >
                        </div>
                        
                        <div class="form-group">
                        <textarea name="note" class="form-control" rows="4" placeholder="Admin Note"></textarea>
                        </div>
                        
                        <div class="row">
                        <div class="col-6">
                        <div class="form-group">
                            <label class="form-label mt-0">Upload Receipt</label>
                            <input id="" type="file" class="form-control" name="rfile" accept="image/*">                        
                        </div>
                        </div>
                        <div class="col-6">
                       <label class="form-label"> </label>
                        <button class="btn btn-info" onclick="saveSendInst();"><b>Save & Send for Verification</b></button>
                        </form>
                        <script>
                            function saveSendInst() {
                                let form = $('.insform')[0];
                                let fd = new FormData();
                                for (let i = 0; i < 6; i++) {
                                    const e = form[i];
                                    const name = e.attributes.name.nodeValue;
                                    if(name=="amount") {
                                        let am = parseInt(e.value);
                                        if(am>"<?php echo $pdata['totalleft']; ?>") {
                                            swal({
                                                title: "Oops!",
                                                text: "Given amount is greater than the fees left! Please submit correct values.",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonText: 'Exit'
                                            });
                                            return 0;
                                        }
                                    }
                                    let val="";
                                    if(name=="rfile") {
                                        try {
                                            val = e.files[0];
                                        }catch(err) {}
                                    }else {
                                        val = e.value;
                                        if(val=="" && name!="note") {
                                            swal({
                                                title: "Oops!",
                                                text: "Please fill all the required fields!",
                                                type: "warning",
                                                confirmButtonText: 'Ok'
                                            });
                                            return 0;
                                        }
                                    }
                                    fd.set(name, val);
                                }
                                notif({
                                    type: "info",
                                    msg: "Instalment addition in progress",
                                    width: "all",
                                    height: 100,
                                    position: "center"
                                });
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        let resp = xhttp.responseText;
                                        for (let i = 0; i < 6; i++) { 
                                            const e = form[i];
                                            e.value = "";
                                        }
                                        $(".closeInstModal")[0].click();

                                        resp = JSON.parse(atob(resp));
                                        swal({
                                            title: "Hooray!",
                                            text: "Instalment has been added!",
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonText: 'Ok'
                                        });
                                        // console.log(resp);
                                        // let html = "";

                                        let amount = resp.amount;
                                        let date = resp.date;
                                        let details = JSON.parse(resp.details);
                                        let bank = details.bankname;
                                        let refno = details.refno;
                                        let note = details.note;
                                        let file = resp.file;
                                        let instid = resp.instid;
                                        
                                        let table = $('#responsive-datatable').DataTable();
                                            // html += '<tr><td>2</td><td><span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3"><abbr style="text-decoration: none;" title="Waiting for approval from accounts department">Waiting</abbr></span></td><td>₹'+amount+'</td><td>'+date+'</td><td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><a href="./accdocs/'+file+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></span></td><td>'+bank+'</td><td>'+refno+'</td><td>'+note+'</td></tr>';
                                            // $(".insttable")[0].innerHTML += html;
                                            if(file=="-") {
                                                table.row.add([1, '<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3"><abbr style="text-decoration: none;" title="Waiting for approval from accounts department">Waiting</abbr></span>', "₹"+amount, date, "NO", bank, refno, note]).draw(false);
                                            }
                                            else {
                                                table.row.add([1, '<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3"><abbr style="text-decoration: none;" title="Waiting for approval from accounts department">Waiting</abbr></span>', "₹"+amount, date, "NO", '<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><a href="./accdocs/'+file+'" download><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></span>', bank, refno, note]).draw(false);

                                            }

                                    }
                                };
                                fd.set("studid", "<?php echo $_GET['sid']; ?>");
                                    xhttp.open("POST", "../assets/backend/addinst.php");
                                xhttp.send(fd);
                            } 
                         
                        </script>

                       
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
                                    <p>• Hover on the payment status to know more.</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">
                                                <thead>
                                                    <tr>
                                                        <th>SN.</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        <th>Receipt</th>
                                                        <th>Bank Name</th>
                                                        <th>Referance Number</th>
                                                        <th>Admin Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody class='insttable'>
                                                    <?php 
                                                    if(empty($pdata["instalment"]) || is_null($pdata["instalment"])) {

                                                    }else {
                                                    $insts = json_decode($pdata["instalment"], true);
                                                    $html = "";
                                                    foreach ($insts as $key => $value) {
                                                        $det = json_decode( $value["details"],true);
                                                        if($value['status']=="1") {
                                                            $apby = $value["apby"];
                                                            $status = '<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><abbr style="text-decoration: none;" title="Approved from accounts department | Approved by '.$apby.'">Approved</abbr></span>';
                                                        }else if($value['status']=="0") {
                                                            $status = '<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3"><abbr style="text-decoration: none;" title="Waiting for approval from accounts department">Waiting</abbr></span>';
                                                        }else {
                                                            $status = '<span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3"><abbr style="text-decoration: none;" title="Reajected by accounts department | Rejected by Anish Kumar ">Rejected</abbr></span>';
                                                        }
                                                        if($value["file"]!="-") {
                                                            $html .= "<tr><td>".($key+1)."</td><td>".$status."</td><td>₹".$value['amount']."</td><td>".$value['date']."</td><td><a href='./accdocs/".$value['file']."' download><span class='badge bg-success-transparent rounded-pill text-success p-2 px-3'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></span></a></td><td>".$det['bankname']."</td><td>".$det['refno']."</td><td>".$det['note']."</td></tr>";
                                                        }else {
                                                            $html .= "<tr><td>".($key+1)."</td><td>".$status."</td><td>₹".$value['amount']."</td><td>".$value['date']."</td><td>NO</td><td>".$det['bankname']."</td><td>".$det['refno']."</td><td>".$det['note']."</td></tr>";
                                                        }
                                                    }
                                                    echo $html;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            
                                        </div>
                                        
                                        
                                        <!-- document Section -->
                                        <div class="tab-pane <?php if($_SESSION['usertype']=="3") { ?> active show <?php } ?>" id="tab22" role="tabpanel">
                                            
                                            <div class="col-xl-12">
                                <div class="card">
                                    <!-- <div class="card-header">
                                        <h3 class="card-title">Student's Documents &nbsp; <button class="btn btn-info"><b><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp; Documents Summary</b></button></h3>
                                    </div> -->
                                    <div class="card-body">
                                    <!-- <p>• Hover on the payment status to know more.</p> -->
                                        <div class="table-responsive">
                                            <table class="table border text-nowrap text-md-nowrap table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SN.</th>
                                                        <th>Document</th>
                                                        <th>Status</th>
                                                        <th>Download</th>
                                                        
                                                        <!-- <th>SN.</th>
                                                        <th>10th Documents</th>
                                                        <th>12th Documents</th>
                                                        <th>Photo</th>
                                                        <th>Adhar Card</th>
                                                        <th>DMC</th>
                                                        <th>Diplona</th>
                                                        <th>Admin Note</th>
                                                        
                                                        <td><span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3"><abbr style="text-decoration: none;" title="Reajected by accounts department | Rejected by Anish Kumar | Rejection Note from Account Department">Rejected</abbr></span></td>-->
                                                        
                                                    </tr>
                                                </thead>
                                                <script>
                                                    function uploadDoc(e, t) {
                                                        const input = document.createElement('input');
                                                        input.type = "file";
                                                        input.click();
                                                        input.onchange = function() {
                                                            var xhttp = new XMLHttpRequest();
                                                            xhttp.onreadystatechange = function() {
                                                                if (this.readyState == 4 && this.status == 200) {
                                                                    let resp = JSON.parse(xhttp.responseText);
                                                                    let r = resp.status;
                                                                    
                                                                    
                                                                    if(r=="1") {
                                                                        $(e)[0].className = "badge bg-success-transparent rounded-pill text-success p-2 px-3";
                                                                        $(e)[0].innerHTML = "Uploaded";
                                                                        $(e)[0].offsetParent.nextElementSibling.innerHTML = "<a href='./accdocs/"+resp.name+"' download><span class='badge bg-success-transparent rounded-pill text-success p-2 px-3'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></span></a>";
                                                                        swal({
                                                                            title: "Hooray!",
                                                                            text: "Document has been added!",
                                                                            type: "success",
                                                                            showCancelButton: false,
                                                                            confirmButtonText: 'Ok'
                                                                        });
                                                                    }else {
                                                                        swal({
                                                                            title: "Oops!",
                                                                            text: "Document addition was unsuccessful!",
                                                                            type: "warning",
                                                                            showCancelButton: false,
                                                                            confirmButtonText: 'Ok'
                                                                        });
                                                                    }
                                                                    
                                                                }
                                                            };
                                                            let fd = new FormData();
                                                            fd.set('file', input.files[0]);
                                                            fd.set('t', t);
                                                            fd.set("studid", "<?php echo $_GET['sid']; ?>");
                                                            xhttp.open("POST", "../assets/backend/uploadDoc.php");
                                                            xhttp.send(fd); 
                                                        }
                                                    }
                                                </script>
                                                <tbody>
                                                    <?php 
                                                    $docs = json_decode($pdata["docs"], true);
                                                    ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>10th Documents</td>
                                                        <?php if($docs[0]=="-") {
                                                        ?> 
                                                        <td><span style='cursor:pointer' onclick='uploadDoc(this, 0);' class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Click to Upload</span></td> 
                                                        <td>NA</td>
                                                        <?php    
                                                        }else {
                                                            ?> 
                                                            <td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Uploaded</span></td> 
                                                            <td><a download="true" href='./accdocs/<?php echo $docs["0"]; ?>'><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></td>
                                                            <?php
                                                        } ?>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Sign</td>
                                                       
                                                        <?php if($docs[1]=="-") {
                                                        ?> 
                                                        <td><span style='cursor:pointer' onclick='uploadDoc(this, 1);' class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Click to Upload</span></td> 
                                                        <td>NA</td>
                                                        <?php    
                                                        }else {
                                                            ?> 
                                                            <td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Uploaded</span></td> 
                                                            <td><a download="true" href='./accdocs/<?php echo $docs["1"]; ?>'><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></td>
                                                            <?php
                                                        } ?>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Photo</td>
                                                       
                                                        <?php if($docs[2]=="-") {
                                                        ?> 
                                                        <td><span style='cursor:pointer' onclick='uploadDoc(this, 2);' class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Click to Upload</span></td> 
                                                        <td>NA</td>
                                                        <?php    
                                                        }else {
                                                            ?> 
                                                            <td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Uploaded</span></td> 
                                                            <td><a download="true" href='./accdocs/<?php echo $docs["2"]; ?>'><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></td>
                                                            <?php
                                                        } ?>
                                                    </tr>
                                                        
                                                        <tr>
                                                        <td>4</td>
                                                        <td>Adhar Card</td>
                                                       
                                                        <?php if($docs[3]=="-") {
                                                        ?> 
                                                        <td><span style='cursor:pointer' onclick='uploadDoc(this, 3);' class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Click to Upload</span></td> 
                                                        <td>NA</td>
                                                        <?php    
                                                        }else {
                                                            ?> 
                                                            <td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Uploaded</span></td> 
                                                            <td><a download="true" href='./accdocs/<?php echo $docs["3"]; ?>'><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></td>
                                                            <?php
                                                        } ?>
                                                    </tr>
                                                        
                                                        <tr>
                                                        <td>5</td>
                                                        <td>DMC</td>
                                                       
                                                        <?php if($docs[4]=="-") {
                                                        ?> 
                                                        <td><span style='cursor:pointer' onclick='uploadDoc(this, 4);' class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Click to Upload</span></td> 
                                                        <td>NA</td>
                                                        <?php    
                                                        }else {
                                                            ?> 
                                                            <td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Uploaded</span></td> 
                                                            <td><a download="true" href='./accdocs/<?php echo $docs["4"]; ?>'><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></td>
                                                            <?php
                                                        } ?>
                                                    </tr>
                                                        
                                                        <tr>
                                                        <td>6</td>
                                                        <td>Diploma</td>
                                                       
                                                        <?php if($docs[5]=="-") {
                                                        ?> 
                                                        <td><span style='cursor:pointer' onclick='uploadDoc(this, 5);' class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Click to Upload</span></td> 
                                                        <td>NA</td>
                                                        <?php    
                                                        }else {
                                                            ?> 
                                                            <td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Uploaded</span></td> 
                                                            <td><a download="true" href='./accdocs/<?php echo $docs["5"]; ?>'><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></td>
                                                            <?php
                                                        } ?>
                                                    </tr>
                                                        
                                                        <tr>
                                                        <td>7</td>
                                                        <td>Fee Snapshots</td>
                                                       
                                                        <?php if($docs[6]=="-") {
                                                        ?> 
                                                        <td><span style='cursor:pointer' onclick='uploadDoc(this, 6);' class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Click to Upload</span></td> 
                                                        <td>NA</td>
                                                        <?php    
                                                        }else {
                                                            ?> 
                                                            <td><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Uploaded</span></td> 
                                                            <td><a download="true" href='./accdocs/<?php echo $docs["6"]; ?>'><span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></td>
                                                            <?php
                                                        } ?>
                                                    </tr>
                                                        
                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                      
                                        </div>
                                        <!-- end of doc section -->
                                        
                                        
                                        <div class="tab-pane <?php if($_SESSION['usertype']=="4") { ?> active show <?php } ?>" id="tab23" role="tabpanel">
                                            <div class="d-flex country">
                                            <button class="btn btn-success" data-bs-target="#country-selector2" data-bs-toggle="modal"><b>Add Dispatch Record +</b></button>
                                            
                                            
                                            
                                            </div>
                                            
                                            <!-- Add Dispatch modal -->
                                            <div class="modal fade" id="country-selector2">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content country-select-modal">
                    <div class="modal-header">
                        <h6 class="modal-title">Add Dispatch | <?php echo $pdata['name']; ?></h6><button aria-label="Close" class="btn-close"
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
dtype
                        
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
                       <label class="form-label"> </label>
                        <button class="btn btn-info" onclick="saveDisp();" type="button"><b>Save Dispatch Record</b></button>
                                                    </form>
                       
                        </div>
                        </div>
                        <script>
                            function saveDisp() {
                                let form = $(".disform")[0];
                                let fd=new FormData();
                                for(let i=0;i<=4;i++) {
                                    let name =form[i].attributes.name.nodeValue;
                                    if(name=="recfile") {
                                        fd.set(name, form[i].files[0]);
                                    }
                                    else {
                                        fd.set(name, form[i].value);
                                    }
                                }
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        let resp = JSON.parse(atob(this.responseText));
                                        let table = $("#distable").DataTable();
                                        let dtype = resp['distype'];
                                        if(dtype=="0") {
                                            dtype = "Registered Speed Post";
                                        }
                                        else if(dtype=="1") {
                                            dtype = "By Hand";
                                        }
                                        else {
                                            dtype = "Courier";
                                        }
                                        if(resp['receipt']=="-") {
                                            table.row.add([resp['count'],resp['date'],dtype,resp['trackid'],resp['remarks'],"NA"]).draw(false);
                                        }
                                        else {
                                            table.row.add([resp['count'],resp['date'],dtype,resp['trackid'],resp['remarks'],'<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><a href="./disdocs/'+resp['receipt']+'" download><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></span>']).draw(false);
                                        }
                                        swal({
                                            title: "Hooray!",
                                            text: "Dispatch Record is successfully added!",
                                            type: "success",
                                            showCancelButton: true,
                                            confirmButtonText: 'Exit'
                                        });
                                    }
                                };
                                fd.set("studid", "<?php echo $_GET['sid']; ?>")
                                xhttp.open("POST", "../assets/backend/addDisp.php");
                                xhttp.send(fd);
                            }
                        </script>
                       
                        
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
                                                <?php 
                                                    $dispatch = json_decode($pdata["dispatch"], true);
                                                    if(!is_null($dispatch) && !empty($dispatch)) {
                                                    foreach ($dispatch as $key => $value) {
                                                        $dtype = $value["distype"];
                                                        if($dtype=="0") {
                                                            $dtype = "Registered Speed Post";
                                                        }
                                                        else if($dtype=="1") {
                                                            $dtype = "By Hand";
                                                        }
                                                        else {
                                                            $dtype = "Courier";
                                                        }
                                                        if($value['receipt']=="-") {
                                                            $rec = "NA";
                                                        }
                                                        else {
                                                            $rec = '<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"><a href="./disdocs/'.$value['receipt'].'" download><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></span>';
                                                        }
                                                        ?>
                                                        <tr>
                                                        <td> <?php echo $key+1; ?> </td>
                                                        <td> <?php echo $value['date']; ?> </td>
                                                        <td> <?php echo $dtype; ?> </td>
                                                        <td> <?php echo $value['trackid']; ?> </td>
                                                        <td> <?php echo $value['remarks']; ?> </td>
                                                        <td> <?php echo $rec; ?> </td>
                                                    </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                                    
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

    <script src="../assets/plugins/notify/js/rainbow.js"></script>
    <script src="../assets/plugins/notify/js/sample.js"></script>
    <script src="../assets/plugins/notify/js/jquery.growl.js"></script>
    <script src="../assets/plugins/notify/js/notifIt.js"></script>

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
    <script>
        var AndraPradesh = ["Anantapur","Chittoor","East Godavari","Guntur","Kadapa","Krishna","Kurnool","Prakasam","Nellore","Srikakulam","Visakhapatnam","Vizianagaram","West Godavari"];
var ArunachalPradesh = ["Anjaw","Changlang","Dibang Valley","East Kameng","East Siang","Kra Daadi","Kurung Kumey","Lohit","Longding","Lower Dibang Valley","Lower Subansiri","Namsai","Papum Pare","Siang","Tawang","Tirap","Upper Siang","Upper Subansiri","West Kameng","West Siang","Itanagar"];
var Assam = ["Baksa","Barpeta","Biswanath","Bongaigaon","Cachar","Charaideo","Chirang","Darrang","Dhemaji","Dhubri","Dibrugarh","Goalpara","Golaghat","Hailakandi","Hojai","Jorhat","Kamrup Metropolitan","Kamrup (Rural)","Karbi Anglong","Karimganj","Kokrajhar","Lakhimpur","Majuli","Morigaon","Nagaon","Nalbari","Dima Hasao","Sivasagar","Sonitpur","South Salmara Mankachar","Tinsukia","Udalguri","West Karbi Anglong"];
var Bihar = ["Araria","Arwal","Aurangabad","Banka","Begusarai","Bhagalpur","Bhojpur","Buxar","Darbhanga","East Champaran","Gaya","Gopalganj","Jamui","Jehanabad","Kaimur","Katihar","Khagaria","Kishanganj","Lakhisarai","Madhepura","Madhubani","Munger","Muzaffarpur","Nalanda","Nawada","Patna","Purnia","Rohtas","Saharsa","Samastipur","Saran","Sheikhpura","Sheohar","Sitamarhi","Siwan","Supaul","Vaishali","West Champaran"];
var Chhattisgarh = ["Balod","Baloda Bazar","Balrampur","Bastar","Bemetara","Bijapur","Bilaspur","Dantewada","Dhamtari","Durg","Gariaband","Janjgir Champa","Jashpur","Kabirdham","Kanker","Kondagaon","Korba","Koriya","Mahasamund","Mungeli","Narayanpur","Raigarh","Raipur","Rajnandgaon","Sukma","Surajpur","Surguja"];
var Goa = ["North Goa","South Goa"];
var Gujarat = ["Ahmedabad","Amreli","Anand","Aravalli","Banaskantha","Bharuch","Bhavnagar","Botad","Chhota Udaipur","Dahod","Dang","Devbhoomi Dwarka","Gandhinagar","Gir Somnath","Jamnagar","Junagadh","Kheda","Kutch","Mahisagar","Mehsana","Morbi","Narmada","Navsari","Panchmahal","Patan","Porbandar","Rajkot","Sabarkantha","Surat","Surendranagar","Tapi","Vadodara","Valsad"];
var Haryana = ["Ambala","Bhiwani","Charkhi Dadri","Faridabad","Fatehabad","Gurugram","Hisar","Jhajjar","Jind","Kaithal","Karnal","Kurukshetra","Mahendragarh","Mewat","Palwal","Panchkula","Panipat","Rewari","Rohtak","Sirsa","Sonipat","Yamunanagar"];
var HimachalPradesh = ["Bilaspur","Chamba","Hamirpur","Kangra","Kinnaur","Kullu","Lahaul Spiti","Mandi","Shimla","Sirmaur","Solan","Una"];
var JammuKashmir = ["Anantnag","Bandipora","Baramulla","Budgam","Doda","Ganderbal","Jammu","Kargil","Kathua","Kishtwar","Kulgam","Kupwara","Leh","Poonch","Pulwama","Rajouri","Ramban","Reasi","Samba","Shopian","Srinagar","Udhampur"];
var Jharkhand = ["Bokaro","Chatra","Deoghar","Dhanbad","Dumka","East Singhbhum","Garhwa","Giridih","Godda","Gumla","Hazaribagh","Jamtara","Khunti","Koderma","Latehar","Lohardaga","Pakur","Palamu","Ramgarh","Ranchi","Sahebganj","Seraikela Kharsawan","Simdega","West Singhbhum"];
var Karnataka = ["Bagalkot","Bangalore Rural","Bangalore Urban","Belgaum","Bellary","Bidar","Vijayapura","Chamarajanagar","Chikkaballapur","Chikkamagaluru","Chitradurga","Dakshina Kannada","Davanagere","Dharwad","Gadag","Gulbarga","Hassan","Haveri","Kodagu","Kolar","Koppal","Mandya","Mysore","Raichur","Ramanagara","Shimoga","Tumkur","Udupi","Uttara Kannada","Yadgir"];
var Kerala = ["Alappuzha","Ernakulam","Idukki","Kannur","Kasaragod","Kollam","Kottayam","Kozhikode","Malappuram","Palakkad","Pathanamthitta","Thiruvananthapuram","Thrissur","Wayanad"];
var MadhyaPradesh = ["Agar Malwa","Alirajpur","Anuppur","Ashoknagar","Balaghat","Barwani","Betul","Bhind","Bhopal","Burhanpur","Chhatarpur","Chhindwara","Damoh","Datia","Dewas","Dhar","Dindori","Guna","Gwalior","Harda","Hoshangabad","Indore","Jabalpur","Jhabua","Katni","Khandwa","Khargone","Mandla","Mandsaur","Morena","Narsinghpur","Neemuch","Panna","Raisen","Rajgarh","Ratlam","Rewa","Sagar","Satna",
"Sehore","Seoni","Shahdol","Shajapur","Sheopur","Shivpuri","Sidhi","Singrauli","Tikamgarh","Ujjain","Umaria","Vidisha"];
var Maharashtra = ["Ahmednagar","Akola","Amravati","Aurangabad","Beed","Bhandara","Buldhana","Chandrapur","Dhule","Gadchiroli","Gondia","Hingoli","Jalgaon","Jalna","Kolhapur","Latur","Mumbai City","Mumbai Suburban","Nagpur","Nanded","Nandurbar","Nashik","Osmanabad","Palghar","Parbhani","Pune","Raigad","Ratnagiri","Sangli","Satara","Sindhudurg","Solapur","Thane","Wardha","Washim","Yavatmal"];
var Manipur = ["Bishnupur","Chandel","Churachandpur","Imphal East","Imphal West","Jiribam","Kakching","Kamjong","Kangpokpi","Noney","Pherzawl","Senapati","Tamenglong","Tengnoupal","Thoubal","Ukhrul"];
var Meghalaya = ["East Garo Hills","East Jaintia Hills","East Khasi Hills","North Garo Hills","Ri Bhoi","South Garo Hills","South West Garo Hills","South West Khasi Hills","West Garo Hills","West Jaintia Hills","West Khasi Hills"];
var Mizoram = ["Aizawl","Champhai","Kolasib","Lawngtlai","Lunglei","Mamit","Saiha","Serchhip","Aizawl","Champhai","Kolasib","Lawngtlai","Lunglei","Mamit","Saiha","Serchhip"];
var Nagaland = ["Dimapur","Kiphire","Kohima","Longleng","Mokokchung","Mon","Peren","Phek","Tuensang","Wokha","Zunheboto"];
var Odisha = ["Angul","Balangir","Balasore","Bargarh","Bhadrak","Boudh","Cuttack","Debagarh","Dhenkanal","Gajapati","Ganjam","Jagatsinghpur","Jajpur","Jharsuguda","Kalahandi","Kandhamal","Kendrapara","Kendujhar","Khordha","Koraput","Malkangiri","Mayurbhanj","Nabarangpur","Nayagarh","Nuapada","Puri","Rayagada","Sambalpur","Subarnapur","Sundergarh"];
var Punjab = ["Amritsar","Barnala","Bathinda","Faridkot","Fatehgarh Sahib","Fazilka","Firozpur","Gurdaspur","Hoshiarpur","Jalandhar","Kapurthala","Ludhiana","Mansa","Moga","Mohali","Muktsar","Pathankot","Patiala","Rupnagar","Sangrur","Shaheed Bhagat Singh Nagar","Tarn Taran"];
var Rajasthan = ["Ajmer","Alwar","Banswara","Baran","Barmer","Bharatpur","Bhilwara","Bikaner","Bundi","Chittorgarh","Churu","Dausa","Dholpur","Dungarpur","Ganganagar","Hanumangarh","Jaipur","Jaisalmer","Jalore","Jhalawar","Jhunjhunu","Jodhpur","Karauli","Kota","Nagaur","Pali","Pratapgarh","Rajsamand","Sawai Madhopur","Sikar","Sirohi","Tonk","Udaipur"];
var Sikkim = ["East Sikkim","North Sikkim","South Sikkim","West Sikkim"];
var TamilNadu = ["Ariyalur","Chennai","Coimbatore","Cuddalore","Dharmapuri","Dindigul","Erode","Kanchipuram","Kanyakumari","Karur","Krishnagiri","Madurai","Nagapattinam","Namakkal","Nilgiris","Perambalur","Pudukkottai","Ramanathapuram","Salem","Sivaganga","Thanjavur","Theni","Thoothukudi","Tiruchirappalli","Tirunelveli","Tiruppur","Tiruvallur","Tiruvannamalai","Tiruvarur","Vellore","Viluppuram","Virudhunagar"];
var Telangana = ["Adilabad","Bhadradri Kothagudem","Hyderabad","Jagtial","Jangaon","Jayashankar","Jogulamba","Kamareddy","Karimnagar","Khammam","Komaram Bheem","Mahabubabad","Mahbubnagar","Mancherial","Medak","Medchal","Nagarkurnool","Nalgonda","Nirmal","Nizamabad","Peddapalli","Rajanna Sircilla","Ranga Reddy","Sangareddy","Siddipet","Suryapet","Vikarabad","Wanaparthy","Warangal Rural","Warangal Urban","Yadadri Bhuvanagiri"];
var Tripura = ["Dhalai","Gomati","Khowai","North Tripura","Sepahijala","South Tripura","Unakoti","West Tripura"];
var UttarPradesh = ["Agra","Aligarh","Allahabad","Ambedkar Nagar","Amethi","Amroha","Auraiya","Azamgarh","Baghpat","Bahraich","Ballia","Balrampur","Banda","Barabanki","Bareilly","Basti","Bhadohi","Bijnor","Budaun","Bulandshahr","Chandauli","Chitrakoot","Deoria","Etah","Etawah","Faizabad","Farrukhabad","Fatehpur","Firozabad","Gautam Buddha Nagar","Ghaziabad","Ghazipur","Gonda","Gorakhpur","Hamirpur","Hapur","Hardoi","Hathras","Jalaun","Jaunpur","Jhansi","Kannauj","Kanpur Dehat","Kanpur Nagar","Kasganj","Kaushambi","Kheri","Kushinagar","Lalitpur","Lucknow","Maharajganj","Mahoba","Mainpuri","Mathura","Mau","Meerut","Mirzapur","Moradabad","Muzaffarnagar","Pilibhit","Pratapgarh","Raebareli","Rampur","Saharanpur","Sambhal","Sant Kabir Nagar","Shahjahanpur","Shamli","Shravasti","Siddharthnagar","Sitapur","Sonbhadra","Sultanpur","Unnao","Varanasi"];
var Uttarakhand  = ["Almora","Bageshwar","Chamoli","Champawat","Dehradun","Haridwar","Nainital","Pauri","Pithoragarh","Rudraprayag","Tehri","Udham Singh Nagar","Uttarkashi"];
var WestBengal = ["Alipurduar","Bankura","Birbhum","Cooch Behar","Dakshin Dinajpur","Darjeeling","Hooghly","Howrah","Jalpaiguri","Jhargram","Kalimpong","Kolkata","Malda","Murshidabad","Nadia","North 24 Parganas","Paschim Bardhaman","Paschim Medinipur","Purba Bardhaman","Purba Medinipur","Purulia","South 24 Parganas","Uttar Dinajpur"];
var AndamanNicobar = ["Nicobar","North Middle Andaman","South Andaman"];
var Chandigarh = ["Chandigarh"];
var DadraHaveli = ["Dadra Nagar Haveli"];
var DamanDiu = ["Daman","Diu"];
var Delhi = ["Central Delhi","East Delhi","New Delhi","North Delhi","North East Delhi","North West Delhi","Shahdara","South Delhi","South East Delhi","South West Delhi","West Delhi"];
var Lakshadweep = ["Lakshadweep"];
var Puducherry = ["Karaikal","Mahe","Puducherry","Yanam"];


$("#stateinput").change(function(){
  var StateSelected = $(this).val();
  var optionsList;
  var htmlString = "";

  switch (StateSelected) {
    case "Andra Pradesh":
        optionsList = AndraPradesh;
        break;
    case "Arunachal Pradesh":
        optionsList = ArunachalPradesh;
        break;
    case "Assam":
        optionsList = Assam;
        break;
    case "Bihar":
        optionsList = Bihar;
        break;
    case "Chhattisgarh":
        optionsList = Chhattisgarh;
        break;
    case "Goa":
        optionsList = Goa;
        break;
    case  "Gujarat":
        optionsList = Gujarat;
        break;
    case "Haryana":
        optionsList = Haryana;
        break;
    case "Himachal Pradesh":
        optionsList = HimachalPradesh;
        break;
    case "Jammu and Kashmir":
        optionsList = JammuKashmir;
        break;
    case "Jharkhand":
        optionsList = Jharkhand;
        break;
    case  "Karnataka":
        optionsList = Karnataka;
        break;
    case "Kerala":
        optionsList = Kerala;
        break;
    case  "Madya Pradesh":
        optionsList = MadhyaPradesh;
        break;
    case "Maharashtra":
        optionsList = Maharashtra;
        break;
    case  "Manipur":
        optionsList = Manipur;
        break;
    case "Meghalaya":
        optionsList = Meghalaya ;
        break;
    case  "Mizoram":
        optionsList = Mizoram;
        break;
    case "Nagaland":
        optionsList = Nagaland;
        break;
    case  "Orissa":
        optionsList = Orissa;
        break;
    case "Punjab":
        optionsList = Punjab;
        break;
    case  "Rajasthan":
        optionsList = Rajasthan;
        break;
    case "Sikkim":
        optionsList = Sikkim;
        break;
    case  "Tamil Nadu":
        optionsList = TamilNadu;
        break;
    case  "Telangana":
        optionsList = Telangana;
        break;
    case "Tripura":
        optionsList = Tripura ;
        break;
    case  "Uttaranchal":
        optionsList = Uttaranchal;
        break;
    case  "Uttar Pradesh":
        optionsList = UttarPradesh;
        break;
    case "West Bengal":
        optionsList = WestBengal;
        break;
    case  "Andaman and Nicobar Islands":
        optionsList = AndamanNicobar;
        break;
    case "Chandigarh":
        optionsList = Chandigarh;
        break;
    case  "Dadar and Nagar Haveli":
        optionsList = DadraHaveli;
        break;
    case "Daman and Diu":
        optionsList = DamanDiu;
        break;
    case  "Delhi":
        optionsList = Delhi;
        break;
    case "Lakshadeep":
        optionsList = Lakshadeep ;
        break;
    case  "Pondicherry":
        optionsList = Pondicherry;
        break;
}


  for(var i = 0; i < optionsList.length; i++){
    htmlString = htmlString+"<option value='"+ optionsList[i] +"'>"+ optionsList[i] +"</option>";
  }
  $("#inputDistrict").html(htmlString);

});
    </script>

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

    <script>
        $("#distable").DataTable();
    </script>
</body>
</html>