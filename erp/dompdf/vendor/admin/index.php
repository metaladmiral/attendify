<?php 
session_start();
include 'php/dbh.php';
$selected_language = 'en';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new db;
$ldate = strtotime("now");
// echo $query = $db->cconnect("mvmtnqxp_admin");
$query = $db->cconnect("mvmtnqxp_admin")->prepare("SELECT * FROM `contracts` WHERE `ldate`>'".$ldate."' ");
$query->execute();
$rcount = $query->rowCount();

$query = $db->cconnect("mvmtnqxp_admin")->prepare("SELECT * FROM `contracts` WHERE `ldate`>'".$ldate."' LIMIT 0, 10");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background:#e6e6e6;
        }
        .maina{
            width: 100%;
            /* min-height: 100% !important;
            max-height: auto; */
            height: calc(100vh - 75px);
            background-color: #e6e6e6;
            position: relative;
        }
        .workingA {
            width: 500px;
            height: auto;
            border-radius: 4px;
            background: white;
            margin:0 auto;
            margin-top: 32px;
        }
        .workingA .top {
            width: calc(100% - 12px);
            height: 60px;
            display: flex;
            align-items:center;
            padding-left: 12px;
        }   
        .workingA .bottom {
            width: calc(100% - 24px);
            padding-left: 12px;
            padding-right: 12px;
            height: auto;
        }
    </style>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Apartment</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/search.css">
	<link rel="stylesheet" type="text/css" href="css/index-mobile.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/c577f31af1.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
	<script>let nFTabs = 5;</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
				<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
				<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
	
</head>
<body>
    <script>
        function acceptContract(e, aptid) {
            alert("Contract for apartment with id -> "+aptid+" has been accepted!");
            $(e)[0].offsetParent.remove();
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(this.readyState==4 && this.status==200) {
                    
                }
            }
            var fd = new FormData();
            fd.append('aptid', aptid);
            xhr.open("POST", "acceptContract.php");
            xhr.send(fd);
        }
        function loadMore(offset) {            
            document.querySelector(".bottom").innerHTML += "<center> <div class='lds-facebook' style='display: none;'><div></div><div></div><div></div></div></center>";
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(this.readyState==4 && this.status==200) {
                    setTimeout(function(){
                        document.querySelector('.lds-facebook').remove();
                        document.querySelector(".bottom").innerHTML += this.responseText;
                    }, 1200);
                }
            }
            var fd = new FormData();
            fd.append('offset', offset);
            fd.append('rcount', "<?php echo $rcount; ?>");
            xhr.open("POST", "adminpanel_script.php");
            xhr.send(fd);
        }
    </script>
    <nav class='lower_navigation'>
        <img src="logo_trans.png" alt="" onclick="window.location = 'https://lebailmobilite.com';" style='cursor:pointer;'>
    </nav>

    <div class="maina">
        <div class="workingA" style=''>
            <div class="top"><h2>Contracts to confirm</h2></div>
            <div class="bottom">
                <?php if(count($res)<=0) { ?><center><span class='regular-text-nav' style='color: gray;'>No Contracts confirmed yet!</span></center><br><br> <?php }  ?>
                <!-- <center> <div class="lds-facebook" style='display: none;'><div></div><div></div><div></div></div></center> -->
                <?php foreach ($res as $key => $value) {
                    ?>
                    <div class="item" style='border-bottom: 1px solid #ccc;position: relative;'>
                        <br>
                        <b style='font-size: 12px;'>For: </b><span class="regular-text-nav" style='color: gray;'><?php echo $value['aptid']; ?></span>
                        <br>
                        <b style='font-size: 12px;'>Owner Name: </b><span class="regular-text-nav" style='color: gray;'><?php echo $value['lname']; ?></span>
                        ,
                        <b style='font-size: 12px;'>Tenant Name: </b><span class="regular-text-nav" style='color: gray;'><?php echo $value['tname']; ?></span>
                        <br>
                        <b style='font-size: 12px;'>Amount: </b><span class="regular-text-nav" style='color: gray;'><?php echo $value['amount']; ?></span>
                        <br>
                        <b style='font-size: 12px;'>Moveoutdate: </b><span class="regular-text-nav" style='color: gray;'><?php echo $value['moveoutdate']; ?></span>
                        <br>
                        <br>
                        <button style='width: 70px;height: 40px;' onclick='acceptContract(this, "<?php echo $value["aptid"]; ?>");'>Accept</button>
                        <br>
                        <br>
                    </div>
                    <?php
                } 
                if($rcount>10) {
                    ?>
                        <center><button style='width: 70px;height: 40px;' onclick='loadMore("10");'>Load More</button></center>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>

</body>    
</html>