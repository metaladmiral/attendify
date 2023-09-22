<?php

if(isset($_SESSION['uid'])) {
    if(!empty($_SESSION['uid'])) {

    }
    else {
        header('Location: ../');
    }
}
else {
    header('Location: ../');
}
$uid = $_SESSION['uid'];
$ll = strtotime("now");
$sql = "UPDATE `users` SET `lastlogin`=? WHERE `uid`='$uid' ";
$query = $conn->mconnect()->prepare($sql);
$query->execute(array($ll));

if($_SESSION['profilepic']==null || empty($_SESSION['profilepic'])) {
    $profilepic = "male_avatar.png";
}
else {
    $profilepic = $_SESSION['profilepic'];
}

if($_SESSION['lockscreen']=="1") {
    header('Location: ../login/lockscreen.php');
}

?>
<script>
    function search(val) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let resp = this.responseText;
                resp = JSON.parse(resp);
                console.log(resp);
                let html = "";
                if(resp.length>0) {
                    for (let i = 0; i < resp.length; i++) {
                        const e = resp[i];
                        let contact = e.mno;
                        let name = e.name;
                        let studid = e.studid;
                        let email = e.studemail;
                        html += "<a href='edit-student?sid="+studid+"'><button class='dropdown-item'>"+name+" - "+contact+", "+email+"</button></a>";
                    }
                    document.querySelector('.searchCont .itms').innerHTML = html;
                    document.querySelector('.searchCont').classList.remove('hide');
                    document.querySelector('.searchCont').classList.add('show');
                }else {
                    document.querySelector('.searchCont').classList.remove('show');
                    document.querySelector('.searchCont').classList.add('hide');
                }
            }
        };
        let fd = new FormData();
        fd.set('stoken', val);
        xhttp.open("POST", "../assets/backend/search.php");
        xhttp.send(fd);
    }
</script>
<div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                        <!-- sidebar-toggle-->
                        <a class="logo-horizontal " href="index.html">
                            <img src="../assets/images/brand/logo-white.png" class="header-brand-img desktop-logo" alt="logo">
                            <img src="../assets/images/brand/logo-dark.png" class="header-brand-img light-logo1"
                                alt="logo">
                        </a>
                        <!-- LOGO -->
                        <div class="main-header-center ms-3 d-none d-lg-block">
                            <?php if($_SESSION['usertype']=='1' || $_SESSION['usertype']=="3") { ?>
                            <input type="text" class="form-control" id="" placeholder="Type For Master Student Search..." onkeyup="search(this.value);">
                            <!-- <input type="text" class="form-control dropdown-toggle show" id="typehead" placeholder="Search for results..." data-bs-toggle="dropdown" aria-expanded="true"> -->
                            <!-- <input type="text" class="form-control" placeholder="Search for results..."> -->
                            <!-- <input type="text" class="form-control" onchange="return false;" placeholder="Search for results..."> -->
                            <div class="dropdown-menu hide searchCont" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 42px, 0px);" data-popper-placement="bottom-start">
                                <b><label for="" style='margin:8px;'>Search Results</label></b>
                                <div class="itms">

                                    </div>
                                </div>
                            <button class="btn px-0 pt-2"><i class="fe fe-search" aria-hidden="true"></i></button>
                            <?php } ?>
                        </div>
                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <!-- SEARCH -->
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                                aria-controls="navbarSupportedContent-4" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                            </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">
                                        <div class="dropdown d-lg-none d-flex">
                                            <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="dropdown">
                                                <i class="fe fe-search"></i>
                                            </a>
                                            <div class="dropdown-menu header-search dropdown-menu-start">
                                                <div class="input-group w-100 p-2">
                                                    <input type="text" class="form-control" onclick="" placeholder="Search....">
                                                    <div class="input-group-text btn btn-primary">
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- COUNTRY -->
                                        <div class="d-flex">
                                            <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                                <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                                <span class="light-layout"><i class="fe fe-sun"></i></span>
                                            </a>
                                        </div>
                                        <!-- Theme-Layout -->
                                        
                                        <!-- CART -->
                                        <div class="dropdown d-flex">
                                            <a class="nav-link icon full-screen-link nav-link-bg">
                                                <i class="fe fe-minimize fullscreen-button"></i>
                                            </a>
                                        </div>
                                        <!-- FULL-SCREEN -->
                                        <div class="dropdown  d-flex notifications">
                                            <!-- <a class="nav-link icon" data-bs-toggle="dropdown"><i
                                                    class="fe fe-bell"></i><span class=" pulse"></span>
                                            </a> -->
                                            <a class="nav-link icon" href="notification.php"><i
                                                    class="fe fe-bell"></i><span class=" pulse"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading border-bottom">
                                                    <div class="d-flex">
                                                        <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">Notifications
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="notifications-menu">
                                                    <a class="dropdown-item d-flex" href="#">
                                                        <div class="me-3 notifyimg  bg-primary brround box-shadow-primary">
                                                            <i class="fe fe-mail"></i>
                                                        </div>
                                                        <div class="mt-1 wd-80p">
                                                            <h5 class="notification-label mb-1">New Application received
                                                            </h5>
                                                            <span class="notification-subtext">3 days ago</span>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item d-flex" href="#">
                                                        <div class="me-3 notifyimg  bg-secondary brround box-shadow-secondary">
                                                            <i class="fe fe-check-circle"></i>
                                                        </div>
                                                        <div class="mt-1 wd-80p">
                                                            <h5 class="notification-label mb-1">Project has been
                                                                approved</h5>
                                                            <span class="notification-subtext">2 hours ago</span>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item d-flex" href="#">
                                                        <div class="me-3 notifyimg  bg-success brround box-shadow-success">
                                                            <i class="fe fe-shopping-cart"></i>
                                                        </div>
                                                        <div class="mt-1 wd-80p">
                                                            <h5 class="notification-label mb-1">Your Product Delivered
                                                            </h5>
                                                            <span class="notification-subtext">30 min ago</span>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item d-flex" href="#">
                                                        <div class="me-3 notifyimg bg-pink brround box-shadow-pink">
                                                            <i class="fe fe-user-plus"></i>
                                                        </div>
                                                        <div class="mt-1 wd-80p">
                                                            <h5 class="notification-label mb-1">Friend Requests</h5>
                                                            <span class="notification-subtext">1 day ago</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a href="notification"
                                                    class="dropdown-item text-center p-3 text-muted">View all
                                                    Notification</a>
                                            </div>
                                        </div>
                                        <!-- NOTIFICATIONS -->
                                        
                                        <!-- MESSAGE-BOX -->
                                        
                                        <!-- SIDE-MENU -->
                                        <div class="dropdown d-flex profile-1">
                                            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                                <img src="../assets/profilepics/<?php echo $profilepic; ?>" alt="profile-user" style='object-fit:cover;'
                                                    class="avatar  profile-user brround cover-image">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                    <h5 class="text-dark mb-0 fs-14 fw-semibold"><?php echo $_SESSION['fullname']; ?></h5>
                                                        <small class="text-muted"><?php 
                                                        if($_SESSION['usertype']=="1") {
                                                            $utype = "Super Admin";
                                                        } else if($_SESSION['usertype']=="2") {
                                                            $utype = "Teacher";
                                                        }
                                                        else if($_SESSION["usertype"]=="3") {
                                                            $utype= "HOD";
                                                        }
                                                        else if($_SESSION["usertype"]=="4") {
                                                            $utype= "TPP HOD";
                                                        }
                                                        echo $utype;
                                                        ?></small>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a class="dropdown-item" href="profile">
                                                    <i class="dropdown-icon fe fe-user"></i> Profile
                                                </a>
                                                <a class="dropdown-item" href="notification">
                                                    <i class="dropdown-icon fe fe-mail"></i> Notifications
                                                    <span class="badge bg-danger rounded-pill float-end">5</span>
                                                </a>
                                                <a class="dropdown-item" href="../login/lockscreen">
                                                    <i class="dropdown-icon fe fe-lock"></i> Lockscreen
                                                </a>
                                                <a class="dropdown-item" href="./logout.php">
                                                    <i class="dropdown-icon fe fe-alert-circle"></i> Log out
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>