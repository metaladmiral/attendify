<?php 

session_start();
include 'php/dbh.php';
$selected_language = 'en';


$db = new db;
$aptid = $_POST['aptid'];

$query = $db->cconnect("mvmtnqxp_admin")->prepare("SELECT * FROM `contracts` WHERE `aptid`='$aptid'");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$moveoutdate = $res[0]['moveoutdate'];
$propid = $res[0]['propid'];
$ldate = $res[0]['ldate'];
$llid = $res[0]['llid'];
$ttid = $res[0]['ttid'];
$amount = $res[0]['amount'];

$query = $db->mconnect()->prepare("SELECT * FROM `apartments` WHERE `apt_id`='$aptid'");
$query->execute();
$aptDetails = $query->fetch(PDO::FETCH_ASSOC);
$apttitle = $aptDetails['title'];
$rentedTo = $aptDetails['rentedTo'];
if(empty($rentedTo) || is_null($rentedTo)){
    $rentedTo = array();
}
else {
    $rentedTo = json_decode($rentedTo, true);
}


$query = $db->mconnect()->prepare("SELECT * FROM `profiles` WHERE `profileid`='$llid'");
$query->execute();
$lld = $query->fetch(PDO::FETCH_ASSOC);
$llemail = $lld['email'];
$llname = $lld['fullname'];
$llphone = $lld['phone'];

$query = $db->mconnect()->prepare("SELECT * FROM `profiles` WHERE `profileid`='$ttid'");
$query->execute();
$ttd = $query->fetch(PDO::FETCH_ASSOC);
$ttemail = $ttd['email'];
$ttname = $ttd['fullname'];
$ttphone = $lld['phone'];
$profilepic = $lld['profilepic'];

array_push($rentedTo, array($ttid, $ttemail, $profilepic, date("d M, y", strtotime($moveoutdate)), $ttname));
$rentedTo = json_encode($rentedTo);

/* Mail */ 

$txt2 = "
<html>
    <head></head>
    <body style='background: #fff'>
    <style>
    // .nav {width: 100%;height: 60px;background:#b6e2e2;}
    </style>
    <div class='nav' style='width: 100%;height: 180px;background:#edf8f8;position:relative;'><center><img src='https://lebailmobilite.com/logo_trans.png' style='position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);width: 200px;height: 200px;'></center></div>
    <div style='width: calc(100% - 50px);height: 250px;background:#f2f2f2;padding:25px;'><span>Your apartment with title '".$apttitle."' has been rented! \n Here are the details of the tenant -> \n \r Email- ".$ttemail." Name- ".$ttname." Phone- ".$ttphone."</span></div>
    <div class='footer' style='width: 100%;height: 80px;background: #3B4E5B;position:relative;'><center><br><span style='color: white;margin-top:35px;'>&copy; ".date("Y")." Lebailmobilite</span></center></div>
    </body>
</html>
";

$txt1 = "
<html>
    <head></head>
    <body style='background: #fff'>
    <style>
    // .nav {width: 100%;height: 60px;background:#b6e2e2;}
    </style>
    <div class='nav' style='width: 100%;height: 180px;background:#edf8f8;position:relative;'><center><img src='https://lebailmobilite.com/logo_trans.png' style='position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);width: 200px;height: 200px;'></center></div>
    <div style='width: calc(100% - 50px);height: 250px;background:#f2f2f2;padding:25px;'><span>Apartment with title '".$apttitle."' has been rented to you! \n Here are the details of the landlord -> \n \r Email- ".$llemail." Name- ".$llname." Phone- ".$llphone."</span></div>
    <div class='footer' style='width: 100%;height: 80px;background: #3B4E5B;position:relative;'><center><br><span style='color: white;margin-top:35px;'>&copy; ".date("Y")." Lebailmobilite</span></center></div>
    </body>
</html>
";

$headers = "";
// $txt = "You have recieved a proposal on apartment with title - ".$apttitle." \n\n"."Check it out by logging in to your personal space.";
$headers  .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: noreply@lebailmobilite.com" . "\r\n";

$to = $ttemail;
$subject = "Apartment has been rented!";
$txt = "Apartment with title '".$apttitle."' has been rented to you! \n Here are the details of the landlord -> \n \r Email- ".$llemail." Name- ".$llname." Phone- ".$llphone;
$headers = "From: noreply@lebailmobilite.com" . "\r\n";
mail($to,$subject,$txt1,$headers);

$to = $llemail;
$subject = "Apartment has been rented!";
$txt = "Your apartment with title '".$apttitle."' has been rented! \n Here are the details of the tenant -> \n \r Email- ".$ttemail." Name- ".$ttname." Phone- ".$ttphone;
$headers = "From: noreply@lebailmobilite.com" . "\r\n";
mail($to,$subject,$txt2,$headers);

/* ---------------------------------------------------- */ 

$query = $db->cconnect("mvmtnqxp_admin")->prepare("DELETE FROM `contracts` WHERE `aptid`='$aptid'");
$query->execute();

$query = $db->mconnect()->prepare("UPDATE mvmtnqxp_apartment_general.`apartments` SET `contmoveoutdate`='$moveoutdate', `no_of_proposals`='0', `rentedTo`='$rentedTo' WHERE `apt_id`='$aptid'");
$query->execute();

$aptdb = "mvmtnqxp_apt_".$aptid."_".$llid;
$query = $db->cconnect($aptdb)->prepare("DELETE FROM `proposals` WHERE 1");
$query->execute();

$tdb = "mvmtnqxp_user_tenant_".$ttid;
$query = $db->cconnect($tdb)->prepare("UPDATE `proposals_sent` SET `timeout`=?, status=? WHERE `propid`='$propid' ");
$query->execute([$ldate, '2']);


?>
