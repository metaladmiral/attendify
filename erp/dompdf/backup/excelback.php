<?php

session_start();
include '../assets/Db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// echo var_dump($_POST);

$range = explode('-',base64_decode($_GET['range']));
$start = $range[0];
$end = $range[1];

$db = new Db();
$query = $db->query("SELECT title, date, department, eventmode, noofparticipants FROM `makes360_events` WHERE `startdate`<='".$start."' AND `enddate`>='".$end."' ");

$data = $query->fetchAll(PDO::FETCH_ASSOC);

$output = "<table class='table' bordered='1' style='border: 1px solid black;border-collapse: collapse;'>
<tr>
    <th style='border: 1px solid black;border-collapse: collapse;'>S. No.</th>
    <th>Activity/Event</th>
<th>Date</th>
<th>Department</th>
<th>Event Mode</th>
<th>No of Participants</th>
</tr>
";
foreach ($data as $key => $value) {

    $output .= "
    <tr>
        <td style='border: 1px solid black;border-collapse: collapse;'>".($key+1)."</td>
        <td style='border: 1px solid black;border-collapse: collapse;'>".$value["title"]."</td>
        <td style='border: 1px solid black;border-collapse: collapse;'>".$value["date"]."</td>
        <td style='border: 1px solid black;border-collapse: collapse;'>".$value["department"]."</td>
        <td style='border: 1px solid black;border-collapse: collapse;'>".$value["eventmode"]."</td>
        <td style='border: 1px solid black;border-collapse: collapse;'>".$value["noofparticipants"]."</td>
    </tr>
    ";

}

$output .= "</table>";

header('Content-Type: application/vnd.ms-excel');

// header("Content-type: application/octet-stream");
header('Content-Disposition: attachment;filename="eventreports'.$data[0]["date"].'.xlsx"');
header("Pragma: no-cache");
header("Expires: 0");

echo $output;