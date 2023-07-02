<?php 

session_start();
include 'php/dbh.php';
$selected_language = 'en';

$offset = (int) $_POST['offset'];
$trcount = (int) $_POST['rcount'];

$ldate = strtotime("now");
$query = $db->cconnect("mvmtnqxp_admin")->prepare("SELECT * FROM `contracts` WHERE `ldate`>'".$ldate."' LIMIT 10 OFFSET $offset");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php foreach ($res as $key => $value) {
?>
    <div class="item" style='border-bottom: 1px solid #ccc;'>
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
    <button style='width: 70px;height: 40px;' onclick='acceptContract("<?php echo $value["aptid"]; ?>");'>Accept</button>
    <br>
    <br>
</div>
<?php
} 
if($trcount>=($offset+10)) {  
?>
    <center><button style='width: 70px;height: 40px;' onclick='loadMore("<?php echo $offset+10; ?>");'>Load More</button></center>
<?php
}
?>