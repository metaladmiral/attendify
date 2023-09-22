<?php 
// session_start();
$superadminURLS = array("manage-batches", "manage-users", "manage-counsellors", "assign-class-counselor");
$operationsURLS = array("", "add-student");
// var_dump($_SESSION);

$ut = $_SESSION['usertype'];

?>
<script>
        function accDenied() {
            swal({
                title: "Alert",
                text: "You are unautorized to view this section! Login as Superadmin or authorized user to continue ahead.",
                type: "warning",
                showCancelButton: false
            });
        }
    </script>
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="#">
            <img src="https://www.cgccms.in/assets/logo.png" height="40" class="header-brand-img light-logo" alt="logo">
                <img src="https://www.cgccms.in/assets/logo.png" height="40" class="header-brand-img light-logo1" alt="logo">
                
                <img src="https://www.cgccms.in/assets/logo.png" height="40" class="header-brand-img desktop-logo"
                                alt="logo">
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
                <?php if($ut=="2") { ?>
                    <li class="slide">
                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="dashboard"><i class="side-menu__icon lnr lnr-pie-chart"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <?php } ?>
                

                <?php if($ut=="1") { ?>
                    <li class="slide">
                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="dashboard-superadmin"><i class="side-menu__icon lnr lnr-pie-chart"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <?php } ?>
                <?php if($ut=="3" || $ut=="4") { ?>
                    <li class="slide">
                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="dashboard-hod"><i class="side-menu__icon lnr lnr-pie-chart"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <?php } ?>
                
                
                <!-- <?php if($ut=="2") { ?>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="1") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?> ><i class="side-menu__icon fe fe-users"></i>
                        <span onclick='window.location = "<?php echo $operationsURLS[1]; ?>" ' class="side-menu__label">Add Student</span></i>
                    </a>
                </li>
                <?php } ?> -->


                <?php if($ut=="1" || $ut=="3" || $ut=="4") { ?>
                <li class="slide">
                   <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="1" || $ut=="3" || $ut=="4") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-database"></i>
                       <span class="side-menu__label">Reports</span><i class="angle fe fe-chevron-right"></i>
                   </a>
                   <?php if($ut=="1" || $ut=="3" || $ut=="4") { ?>
                   <ul class="slide-menu">
                       <li class="panel sidetab-menu">
                           <div class="panel-body tabs-menu-body p-0 border-0">
                               <div class="tab-content">
                                   <div class="tab-pane active" id="side1">
                                       <ul class="sidemenu-list">
                                           <!-- <li class="side-menu-label1"><a href="javascript:void(0)">Admin</a></li> -->
                                           
                                           <li><a href="student-record" class="slide-item"> Student Record</a></li>
                                           <?php if($ut=="3") { ?><li><a href="consolidated-reports" class="slide-item"> Consolidated Reports</a></li> <?php } ?>
                                           <li><a href="attendance-reports" class="slide-item"> Attendance Reports</a></li>
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </li>
                   </ul>
                   <?php } ?>
                </li>
                <?php } ?> 

                <?php if($ut=="2") { ?>
                <li class="slide">
                   <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-database"></i>
                       <span class="side-menu__label">Attendance</span><i class="angle fe fe-chevron-right"></i>
                   </a>
                   <?php if($ut=="2") { ?>
                   <ul class="slide-menu">
                       <li class="panel sidetab-menu">
                           <div class="panel-body tabs-menu-body p-0 border-0">
                               <div class="tab-content">
                                   <div class="tab-pane active" id="side1">
                                       <ul class="sidemenu-list">
                                           <!-- <li class="side-menu-label1"><a href="javascript:void(0)">Admin</a></li> -->
                                           
                                           <li><a href="attendance-details" class="slide-item"> Attendance Records</a></li>
                                           <li><a href="mark-attendance" class="slide-item"> Mark Attendance</a></li>
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </li>
                   </ul>
                   <?php } ?>
                </li>
                <?php } ?> 

                <?php if($ut=="2") { ?>
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="marks-and-assesments"><i class="side-menu__icon lnr lnr-pie-chart"></i>
                        <span class="side-menu__label">Marks & Assesments</span>
                    </a>
                </li>
                <?php } ?>

                <!-- Operations END -->
                
                <?php if($ut=="1") { ?>
                <li class="slide">
                   <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="1") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-database"></i>
                       <span class="side-menu__label">Super Admin</span><i class="angle fe fe-chevron-right"></i>
                   </a>
                   <?php if($ut=="1") { ?>
                   <ul class="slide-menu">
                       <li class="panel sidetab-menu">
                           <div class="panel-body tabs-menu-body p-0 border-0">
                               <div class="tab-content">
                                   <div class="tab-pane active" id="side1">
                                       <ul class="sidemenu-list">
                                           <!-- <li class="side-menu-label1"><a href="javascript:void(0)">Admin</a></li> -->
                                           
                                           <li><a href="assign-hod" class="slide-item"> Assign HOD</a></li>
                                           <li><a href="<?php echo $superadminURLS[0]; ?>" class="slide-item"> Manage Batches</a></li>
                                           <li><a href="<?php echo $superadminURLS[1]; ?>" class="slide-item"> Manage Faculties</a></li>
                                           <li><a href="manage-subjects" class="slide-item"> Manage Subjects</a></li>
                                           <li><a href="college-department" class="slide-item"> College & Departments IDs</a></li>
                                           
                                            <!-- <l><a href="#" class="slide-item"> Faculty Dashboard</a></l i> -->
                                            <!-- <li><a href="<?php echo $superadminURLS[2]; ?>" class="slide-item"> Add Counseller</a></li> -->
                                           <!-- <li><a href="#" class="slide-item"> Email Setting</a></li> -->
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </li>
                   </ul>
                   <?php } ?>
                </li>
                <?php } ?> 
                
                <?php if($ut=="3" || $ut=="4") { ?>
                <li class="slide">
                   <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="3" || $ut=="4") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-database"></i>
                       <span class="side-menu__label">HOD</span><i class="angle fe fe-chevron-right"></i>
                   </a>
                   <?php if($ut=="3" || $ut=="4") { ?>
                   <ul class="slide-menu">
                       <li class="panel sidetab-menu">
                           <div class="panel-body tabs-menu-body p-0 border-0">
                               <div class="tab-content">
                                   <div class="tab-pane active" id="side1">
                                       <ul class="sidemenu-list">
                                           <!-- <li class="side-menu-label1"><a href="javascript:void(0)">Admin</a></li> -->
                                           
                                           <?php if($ut=="3") { ?>
                                            <li><a href="assign-class-counselor" class="slide-item"> Assign CC</a></li>
                                            <?php } ?>
                                            <?php if($ut=="3") { ?><li><a href="analysis" class="slide-item"> Analysis</a></li> <?php } ?>
                                           <li><a href="assign-subject-faculty" class="slide-item"> Assign Subject Faculty</a></li>
                                           
                                            <!-- <l><a href="#" class="slide-item"> Faculty Dashboard</a></l i> -->
                                            <!-- <li><a href="<?php echo $superadminURLS[2]; ?>" class="slide-item"> Add Counseller</a></li> -->
                                           <!-- <li><a href="#" class="slide-item"> Email Setting</a></li> -->
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </li>
                   </ul>
                   <?php } ?>
                </li>
                <?php } ?> 
                

                <?php if($ut=="1") { ?>
                <li class="slide">
                   <a class="side-menu__item" data-bs-toggle="slide" <?php echo ($ut=="1") ? "href='javascript:void(0)'" : "onclick='accDenied();return false;' href='#' disabled"; ?>><i class="side-menu__icon fe fe-layers"></i>
                       <span class="side-menu__label">Bulk Actions</span><i class="angle fe fe-chevron-right"></i>
                   </a>
                   <?php if($ut=="1") { ?>
                   <ul class="slide-menu">
                       <li class="panel sidetab-menu">
                           <div class="panel-body tabs-menu-body p-0 border-0">
                               <div class="tab-content">
                                   <div class="tab-pane active" id="side1">
                                       <ul class="sidemenu-list">
                                           <!-- <li class="side-menu-label1"><a href="javascript:void(0)">Admin</a></li> -->
                                           
                                           <li><a href="add-students-bulk" class="slide-item"> Add Students</a></li>
                                           <li><a href="add-users-bulk" class="slide-item"> Add Faculties</a></li>
                                           <li><a href="add-subjects-bulk" class="slide-item"> Add Subjects</a></li>
                                           <li><a href="add-attendance-bulk" class="slide-item"> Add Attendance</a></li>
                                           
                                            <!-- <l><a href="#" class="slide-item"> Faculty Dashboard</a></l i> -->
                                            <!-- <li><a href="<?php echo $superadminURLS[2]; ?>" class="slide-item"> Add Counseller</a></li> -->
                                           <!-- <li><a href="#" class="slide-item"> Email Setting</a></li> -->
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </li>
                   </ul>
                   <?php } ?>
                </li>
                <?php } ?> 

                <li class="slide">
                   <a class="side-menu__item" data-bs-toggle="slide"><i class="side-menu__icon fe fe-layers"></i>
                       <span class="side-menu__label">Time Tables</span><i class="angle fe fe-chevron-right"></i>
                   </a>
                   <ul class="slide-menu">
                       <li class="panel sidetab-menu">
                           <div class="panel-body tabs-menu-body p-0 border-0">
                               <div class="tab-content">
                                   <div class="tab-pane active" id="side1">
                                       <ul class="sidemenu-list">
                                           <!-- <li class="side-menu-label1"><a href="javascript:void(0)">Admin</a></li> -->
                                           
                                           <?php if($ut=="1" || $ut=="3" || $ut=="4") { ?>
                                                <li><a href="add-time-table" class="slide-item"> Add Time Table</a></li>
                                            <?php } ?>

                                            <?php
                                           
                                           $fileNames = scandir("./tt/");
                                           if($fileNames) {
                                                foreach ($fileNames as $key => $value) {
                                                    if($value=='.' || $value=='..') {
                                                        continue;
                                                    }
                                                    $fileLabel = explode('.', $value)[0];
                                                    ?>
                                                        <li><a href="./tt/<?php echo $value; ?>" class="slide-item" download> <?php echo $fileLabel; ?></a></li>
                                                    <?php
                                                }
                                            }
                                           ?>
                                           
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </li>
                   </ul>
                </li>
                <!--Super Admin ENDS
                !-->
                
                <!--<li class="slide">-->
                <!--    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-shield"></i>-->
                <!--        <span class="side-menu__label">Help & Support</span><i class="angle fe fe-chevron-right"></i>-->
                <!--    </a>-->
                <!--    <ul class="slide-menu">-->
                <!--        <li class="panel sidetab-menu">-->
                <!--            <div class="panel-body tabs-menu-body p-0 border-0">-->
                <!--                <div class="tab-content">-->
                <!--                    <div class="tab-pane active" id="side1">-->
                <!--                        <ul class="sidemenu-list">-->
                <!--                            <li class="side-menu-label1"><a href="javascript:void(0)">Help & Support</a></li>-->
                <!--                            <li><a href="#" class="slide-item"> How to Use</a></li>-->
                <!--                            <li><a href="#" class="slide-item"> Watch Videos</a></li>-->
                <!--                            <li><a href="#" class="slide-item"> Contact Us</a></li>-->
                <!--                        </ul>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->
                <!-- Super Admin ENDS -->
                
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
</div>