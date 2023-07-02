<?php 

// session_start();
$superadminURLS = array("manage-batches.php", "manage-users.php", "manage-counsellors.php");
$operationsURLS = array("", "add-student.php");
// var_dump($_SESSION);

$ut = $_SESSION['usertype'];

?>
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="#">
                <img src="../assets/images/brand/icon-dark.png" class="header-brand-img light-logo" alt="logo">
                <img src="../assets/images/brand/logo-dark.png" class="header-brand-img light-logo1" alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">
                <!--<li class="sub-category"><h3>Main</h3></li> -->
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="#"><i class="side-menu__icon lnr lnr-pie-chart"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- <li class="sub-category"><h3>UI Kit</h3></li> -->
                <li class="slide">
                    
                    <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="0" || $ut=="1") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?> ><i class="side-menu__icon fe fe-users"></i>
                        <span class="side-menu__label">Operations</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <?php if($ut=="0" || $ut=="1") { ?>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Operations</a></li>
                                            <li><a href="#" class="slide-item"> Operations Dashboard</a></li>
                                            <li><a href="<?php echo $operationsURLS[1]; ?>" class="slide-item"> Add Student</a></li>
                                            <li><a href="#" class="slide-item"> Student Record & Reports</a></li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <!-- Operations END -->
                
                
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="0" || $ut=="2") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-layers"></i>
                        <span class="side-menu__label">Accounts</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Accounts</a></li>
                                            <li><a href="#" class="slide-item"> Accounts Dashboard</a></li>
                                            <li><a href="#" class="slide-item"> Manage Accounts</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Account ENDS -->
                
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="0" || $ut=="3") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-message-circle"></i>
                        <span class="side-menu__label">Counselor</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <?php if($ut=="0" || $ut=="3") { ?>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Counselor</a></li>
                                            <li><a href="#" class="slide-item"> Counselor Dashboard</a></li>
                                            <li><a href="#" class="slide-item"> Students Records & Reports</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <!-- Counselor ENDS -->
                
                 <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="0" || $ut=="4") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-truck"></i>
                        <span class="side-menu__label">Dispatch</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <?php if($ut=="0" || $ut=="4") { ?>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Dispatch</a></li>
                                            <li><a href="#" class="slide-item"> Dispatch Dashboard</a></li>
                                            <li><a href="#" class="slide-item"> Dispatch Records & Reports</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <!-- Dispatch ENDS -->
                
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="0" || $ut=="5") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-crosshair"></i>
                        <span class="side-menu__label">Support</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <?php if($ut=="0" || $ut=="5") { ?>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Support</a></li>
                                            <li><a href="#" class="slide-item"> Support Dashboard</a></li>
                                            <li><a href="#" class="slide-item"> Manage Support</a></li>
                                            <li><a href="#" class="slide-item"> Support Queries</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <!-- Support ENDS -->
                
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="0") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-database"></i>
                        <span class="side-menu__label">Super Admin</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <?php if($ut=="0") { ?>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Admin</a></li>
                                            <li><a href="<?php echo $superadminURLS[0]; ?>" class="slide-item"> Manage Batches</a></li>
                                            <li><a href="<?php echo $superadminURLS[1]; ?>" class="slide-item"> Manage Users</a></li>
                                            <!-- <li><a href="#" class="slide-item"> Counselor Dashboard</a></li> -->
                                            <!-- <li><a href="<?php echo $superadminURLS[2]; ?>" class="slide-item"> Add Counseller</a></li> -->
                                            <li><a href="#" class="slide-item"> Email Setting</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <!-- Super Admin ENDS -->
                
                
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-shield"></i>
                        <span class="side-menu__label">Help & Support</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Help & Support</a></li>
                                            <li><a href="#" class="slide-item"> How to Use</a></li>
                                            <li><a href="#" class="slide-item"> Watch Videos</a></li>
                                            <li><a href="#" class="slide-item"> Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Super Admin ENDS -->
                
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
</div>