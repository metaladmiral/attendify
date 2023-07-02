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
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Forgot Password">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico">
    <!-- TITLE -->
    <title>Forgot Password</title>
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
        <!-- End GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">
                <!-- Theme-Layout -->

                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto">
                    <div class="text-center">
                        <a href="/"><img src="../assets/images/brand/logo-white.png" class="header-brand-img m-0" alt=""></a>
                    </div>
                </div>

                <!-- CONTAINER OPEN -->
                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" method="POST" action="../assets/backend/forgotScript.php">
                            <span class="login100-form-title pb-5">
                                Forgot Password
                            </span>
                            <p class="text-muted">Enter the email address registered on your account</p>
                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                    <i class="zmdi zmdi-email" aria-hidden="true"></i>
                                </a>
                                <input class="input100 border-start-0 ms-0 form-control" type="email" placeholder="Email" name="email">
                            </div>
                            <div class="submit">
                                <center><button class="btn btn-primary" type="submit">Submit</button></center>
                            </div>
                            <div class="text-center mt-4">
                                <p class="text-dark mb-0 d-inline-flex"><a class="text-primary ms-1" href="/">Send me Back</a></p>
                            </div>
                            <label class="login-social-icon"><span>Miss You :(</span></label>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--END PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    <!-- JQUERY JS -->
    <script src="../assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- SHOW PASSWORD JS 
    <script src="../assets/js/show-password.min.js"></script> -->

    <!-- Perfect SCROLLBAR JS-->
    <script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script>

    <!-- Color Theme js -->
    <script src="../assets/js/themeColors.js"></script>

    <!-- CUSTOM JS -->
    <script src="../assets/js/custom.js"></script>

    <!-- Custom-switcher -->
    <!-- <script src="../assets/js/custom-swicher.js"></script> -->

    <!-- Switcher js -->
    <!-- <script src="../assets/switcher/js/switcher.js"></script> -->

</body>

</html>