<?php

session_start();
require_once '../erp/conn.php';

$conn = new Db;

$_SESSION['lockscreen'] = "1";

if(isset($_SESSION['uid'])) {
    if(!empty($_SESSION['uid'])) {
        if($_SESSION['profilepic']==null || empty($_SESSION['profilepic'])) {
            $profilepic = "male_avatar.png";
        }
        else {
            $profilepic = $_SESSION['profilepic'];
        }
    }
    else {
        header('Location: ../');
    }
}
else {
    header('Location: ../');
}

?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <!-- META DATA --><META NAME="robots" CONTENT="noindex,nofollow">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Lock Screen">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico">
    <!-- TITLE -->
    <title>Happy Hours</title>
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

<body class="app sidebar-mini ltr login-img">

    <!-- BACKGROUND-IMAGE -->
    <div class="">

        <!-- GLOABAL LOADER -->
        <div id="global-loader">
            <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">
                <!-- Theme-Layout -->

                <div class="col col-login mx-auto">
                    <div class="text-center">
                        <a href="/"><img src="../assets/images/brand/logo-white.png" class="header-brand-img" alt=""></a>
                    </div>
                </div>
                <!-- CONTAINER OPEN -->
                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" method="POST" action="lockscreen_unlock.php">
                            <div class="text-center mb-4">
                                <img src="../assets/profilepics/<?php echo $profilepic; ?>" alt="lockscreen image" class="avatar avatar-xxl brround mb-2">
                                <h4><?php echo $_SESSION['fullname']; ?></h4>
                            </div>
                            <div class="wrap-input100 validate-input input-group" id="Password-toggle" data-bs-validate="Password is required">
                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                    <i class="zmdi zmdi-eye" aria-hidden="true"></i>
                                </a>
                                <input class="input100 border-start-0 ms-0 form-control" type="password" placeholder="Password" name="upass">
                            </div>
                            <div class="container-login100-form-btn pt-0">
                                <button href="" class="login100-form-btn btn-primary">
										Unlock
									</button>
                            </div>
                            <div class="text-center pt-2">
                                <span class="txt1">
										I Forgot :(
									</span>
                                <a class="" href="forgot-password">
										Click Here
									</a>
                            </div>
                            <label class="login-social-icon"><span>Happy Hours :)</span></label>
                            
                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End GLOABAL LOADER -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    <!-- JQUERY JS -->
    <script src="../assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- SHOW PASSWORD JS -->
    <script src="../assets/js/show-password.min.js"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script>

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

    <?php

                            if(isset($_SESSION['lsufail'])) {
                                ?>
                                <script>
                                    swal({
                                        title: "Oops!",
                                        text: "Wrong Password Entered! Try again!",
                                        type: "warning"
                                    });
                                </script>
                                <?php
                                unset($_SESSION['lsufail']);
                            }

    ?>

</body>

</html>