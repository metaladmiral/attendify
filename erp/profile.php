<?php
session_start();
require_once 'conn.php';

$conn = new Db;
$uid = $_SESSION['uid'];

if($_SESSION['usertype']==1) {
    $usertype = "Super Admin";
} else if($_SESSION['usertype']==2) {
    $usertype = "Counselor";
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
                        
                        
                        <!-- BODY CONTENT -->
        <div class="main-contentAA app-contentAA mt-0AA">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">

                        <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <h1 class="page-title">Admin Profile</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </div>
                        </div>
                        <!-- PAGE-HEADER END -->

                        <!-- ROW-1 OPEN -->
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Edit Password</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center chat-image mb-5">

                                            <div class="avatar avatar-xxl chat-profile mb-3 brround" style='position: relative;'>
                                                <input type="file" name="profilepic" class='profileimg' style='width: 100%;height: 100%;border-radius: 50%;position:absolute;cursor:pointer;opacity:0;z-index: 10;top:0;' onchange="changeDp(this);">
                                                <style>
                                                    .piccover {
                                                        width: 100%;
                                                        height: 100%;
                                                        position:absolute;
                                                        background-color: rgb(0, 0, 0, 0.32);
                                                        top:0;
                                                        border-radius: 50%;
                                                        display: flex;
                                                        justify-content:center;
                                                        align-items:center;
                                                    }
                                                    .piccover i {
                                                        color: #e6e6e6;
                                                        font-size: 18px;
                                                    }
                                                </style>

                                                <a class="" href="profile.html"><img style='width: 100%;height: 100%;border-radius: 50%;object-fit:cover;' alt="avatar" src="../assets/profilepics/<?php echo $profilepic; ?>" class="brround profilepic"><div class="piccover"><i class="fa fa-camera" aria-hidden="true"></i><span style='color: white;font-size: 11px;display: none;'>Uploading...</span></div></a>
                                            </div>
                                            <div class="main-chat-msg-name">
                                                <a href="#">
                                                    <h5 class="mb-1 text-dark fw-semibold" style='margin-right: 12px;'><?php echo $_SESSION['fullname']; ?></h5>
                                                </a>
                                                <!-- <p class="text-muted mt-0 mb-0 pt-0 fs-13">Operations Head</p> -->
                                            </div>
                                        </div>
                                        <form action="../assets/backend/changePass.php" method="POST">
                                        <div class="form-group">
                                            <label class="form-label">Current Password</label>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input name="currpass" class="input100 form-control" type="password" placeholder="Current Password" autocomplete="current-password" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">New Password</label>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle1">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input name="newpass" class="input100 form-control" type="password" placeholder="New Password" autocomplete="new-password" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle2">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input name="cnewpass" class="input100 form-control" type="password" placeholder="Confirm Password" autocomplete="new-password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button href="javascript:void(0)" name="submit" class="btn btn-primary" type="submit">Update Password</button>
                                        
                                    </div>
                                    </form>
                                </div>
                                
                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Profile</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <?php 
                                            $sql = "SELECT * FROM `users` WHERE `uid`='$uid' ";
                                            $query = $conn->mconnect()->prepare($sql);
                                            $query->execute();
                                            $llogin = $query->fetchAll(PDO::FETCH_ASSOC)[0]['lastlogin'];
                                            $llogin = Date("d F Y, h:i:s a", $llogin);
                                            ?>
                                            <div class="form-group">
                                            <label for="exampleInputnumber"></label>
                                            <input type="number" class="form-control" id="exampleInputnumber" placeholder="Last Login: <?php echo $llogin; ?>" disabled>
                                        </div>
                                        
                                     
                                        
                                        <form action="../assets/backend/edituser.php" method="POST">
                                            <!-- <div class="col-lg-6 col-md-12"> -->
                                                <div class="form-group">
                                                    <label for="exampleInputname" class='form-label'>Full Name</label>
                                                    <input type="text" class="form-control" id="exampleInputname" name="fullname" placeholder="Full Name" value="<?php echo $_SESSION['fullname']; ?>">
                                                    <input type="hidden" value="<?php echo $_SESSION['uid']; ?>" name="uid">
                                                </div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class='form-label'>Email Address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['email']; ?>" placeholder="Email address" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class='form-label'>User Type</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" value="<?php echo $usertype; ?>" placeholder="Email address" disabled>
                                        </div>
                                        
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" href="javascript:void(0)" name="submit" class="btn btn-success my-1">Update Profile</button>
                                       
                                    </div>
                                </div>
                                </form>
                                
                                
                            </div>
                        </div>
                        <!-- ROW-1 CLOSED -->

                    </div>
                    <!--CONTAINER CLOSED -->

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
     <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- JQUERY JS -->
    <script src="../assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- INPUT MASK JS-->
    <script src="../assets/plugins/input-mask/jquery.mask.min.js"></script>

	<!-- TypeHead js -->
	<script src="../assets/plugins/bootstrap5-typehead/autocomplete.js"></script>
    <script src="../assets/js/typehead.js"></script>

    <!-- SHOW PASSWORD JS -->
    <script src="../assets/js/show-password.min.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="../assets/plugins/select2/select2.full.min.js"></script>
    <script src="../assets/js/select2.js"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script>
    <script src="../assets/plugins/p-scroll/pscroll.js"></script>
    <script src="../assets/plugins/p-scroll/pscroll-1.js"></script>

    <!-- SIDE-MENU JS -->
    <script src="../assets/plugins/sidemenu/sidemenu.js"></script>

    <!-- SIDEBAR JS -->
    <script src="../assets/plugins/sidebar/sidebar.js"></script>

    <!-- Color Theme js -->
    <script src="../assets/js/themeColors.js"></script>

    <!-- Sticky js -->
    <script src="../assets/js/sticky.js"></script>

    <!-- CUSTOM JS -->
    <script src="../assets/js/custom.js"></script>

    <!-- Custom-switcher -->
    <script src="../assets/js/custom-swicher.js"></script>

    <!-- Switcher js -->
    <script src="../assets/switcher/js/switcher.js"></script>

    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="../assets/js/sweet-alert.js"></script>

    <script>
        function changeDp(e) {
            let file = e.files[0];
            $(".piccover i")[0].style.display = "none";
            $(".piccover span")[0].style.display = "block";
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let resp = xhttp.responseText;
                    let alerttype = "";
                    let alertmsg = "";
                    let alerttitle = "";

                    if(resp=="1") {
                        alerttitle = "Oops!";
                        alerttype = "warning";
                        alertmsg = "An Error Occured!";
                    }
                    else if(resp=="2") {
                        alerttitle = "Oops!";
                        alerttype = "warning";
                        alertmsg = "Only PNG & JPG files are allowed to upload.";
                    }
                    else {
                        alerttitle = "Hurray!";
                        alertmsg = "Profile Picture Successfully updated!";  
                        alerttype = "success";
                        document.querySelector(".profilepic").addEventListener("load", event => {
                            $(".piccover i")[0].style.display = "block";
                            $(".piccover span")[0].style.display = "none";    
                            swal({
                                title: alerttitle,
                                text: alertmsg,
                                type: alerttype,
                                showCancelButton: true
                            });
                        });
                        document.querySelector(".avatar").setAttribute("src", '../assets/profilepics/'+resp);
                        document.querySelector(".profilepic").setAttribute("src", '../assets/profilepics/'+resp);
                        // document.querySelector(".profileimg").addEventListene(function(){
                        //     $(".piccover i")[0].style.display = "block";
                        //     $(".piccover span")[0].style.display = "none";    
                        // }).attr('src', '../assets/profilepics/'+resp);
                    }
                    
                    
                }
            };
            var formdata= new FormData();
            formdata.set('file', file);
            xhttp.open('POST', '../assets/backend/updateProfilePic.php');
            xhttp.send(formdata);
            
        }
    </script>
    <?php
    if(isset($_SESSION['messagePass'])) {
        $msg = $_SESSION['messagePass'];
        ?>
        <script>
            swal({
                    title: "Alert",
                    text: "<?php if($msg=="1") { echo "Password Changed!"; } else if($msg=="cpasserr") { echo "Current Password Wrong!"; } else if($msg=="npass") { echo "The two new passwords do no match!"; } else {echo $msg;} ?>",
                    <?php echo ($msg=="1") ? 'type: "success"' : 'type: "warning"'; ?> ,
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
        </script>
        <?php
        unset($_SESSION['messagePass']);
    }
    ?>

<?php
    if(isset($_SESSION['messageProfile'])) {
        $msg = $_SESSION['messageProfile'];
        ?>
        <script>
            swal({
                    title: "Alert",
                    text: "<?php if($msg=="1") { echo "Profile Updated!"; } else {echo $msg;} ?>",
                    <?php echo ($msg=="1") ? 'type: "success"' : 'type: "warning"'; ?> ,
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
        </script>
        <?php
        unset($_SESSION['messageProfile']);
    }
    ?>

<script>
        function accDenied() {
            swal({
                    title: "Alert",
                    text: "You are unautorized to view this section! Login as Superadmin or authorized user to continue ahead.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Exit'
                });
        }
    </script>
    
</body>
</html>