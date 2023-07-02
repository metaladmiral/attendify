<?php 
session_start();
if(!isset($_SESSION['uid'])) {
    if(empty($_SESSION['uid'])) {

    }
    else {
        header('Location: ../erp/');
    }
}
else {
    header('Location: ../erp/');
}
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <!-- META DATA -->
    <META NAME="robots" CONTENT="noindex,nofollow">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Login">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico">
    <!-- TITLE -->
    <title>Login | Courier Dispatch</title>
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="../assets/js/sweet-alert.js"></script>
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
                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <a href="/"><img src="../assets/images/brand/logo-white.png" class="header-brand-img" alt=""></a>
                    </div>
                </div>
                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" method="POST" action="../assets/backend/userLogin.php?t=4">
                            <span class="login100-form-title pb-5">
                                Courier Dispatch Login
                            </span>
                            <div class="panel panel-primary">
                                
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-email text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input name="email" class="input100 border-start-0 form-control ms-0" type="email" placeholder="Email">
                                            </div>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input name="password" class="input100 border-start-0 form-control ms-0" type="password" placeholder="Password">
                                            </div>
                                            
                                            <div class="container-login100-form-btn">
                                                <button type="submit" href="#" class="login100-form-btn btn-primary">
                                                        Login
                                                </button>
                                            </div>
                                            <div class="text-center pt-3">
                                                <p class="text-dark mb-0">Forgot Password?<a href="forgot-password" class="text-primary ms-1">Click Here</a></p>
                                            </div>
                                            <label class="login-social-icon"><span><small>You are special :)</small></span></label>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    <!-- JQUERY JS -->
    <script src="../assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- SHOW PASSWORD JS -->
    <script src="../assets/js/show-password.min.js"></script>

    <!-- GENERATE OTP JS -->
    <!-- <script src="../assets/js/generate-otp.js"></script> -->

    <!-- Perfect SCROLLBAR JS-->
    <!-- <script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script> -->

    <!-- Color Theme js -->
    <script src="../assets/js/themeColors.js"></script>

    <!-- CUSTOM JS -->
    <script src="../assets/js/custom.js"></script>

    <!-- Custom-switcher -->
    <!-- <script src="../assets/js/custom-swicher.js"></script> -->

    <!-- Switcher js -->
    <!-- <script src="../assets/switcher/js/switcher.js"></script> -->
    <?php if(isset($_SESSION['wrongcred'])) {
        unset($_SESSION['wrongcred']);
        ?> 
        <script>
            swal({
                        title: 'Warning!',
                        text: 'Wrong Credentials!',
                        type: 'warning',
                        confirmButtonColor: '#4fa7f3'
                    });
        </script>
        <?php
    } ?>
</body>
</html>