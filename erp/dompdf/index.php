<?php
session_start();

require_once 'autoload.inc.php';
include '../assets/Db.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/* getting data */ 

    $db = new Db();
    $query = $db->query("SELECT * FROM `makes360_events` WHERE `eveid`='".$_GET['id']."' ");
    $query->execute();

    $data = $query->fetchAll(PDO::FETCH_ASSOC)[0];

/* ------------------------------------------------------------------------------------------------------------------ */
use Dompdf\Dompdf;

$doc = new Dompdf();

$abouteve = $data["aboutevent"];
$eveobj = $data["eventobjective"];
$techasp = $data["technicalaspect"];
$noofpart = $data["noofparticipants"];

$outcomes = json_decode($data["eventoutcome"], true);
$outcomehtml = "";
foreach ($outcomes as $key => $value) {
    $outcomehtml .= "
    <tr>
        <td>Event Outcome ".($key+1)."</td>
        <td>".$value."</td>
    </tr>
    ";
}

$images = json_decode($data["photos"], true);
$imageshtml = "";
foreach ($images as $key => $value) {
    $img = base64_encode(file_get_contents("./".$value));
    $imageshtml .= "
    <img src='data:image/png;base64, ".$img."' style='width: 450px;height: auto;'>
    <br>
    <br>
    ";
}
$html = '
    <style>
        body {
            padding-left: 40px;
            padding-right: 40px;
        }
        * {
            margin: 0px;
            padding: 0px;
        }
        .mainheading {
            margin-top: 40px;
            font-family: sans-serif;
            text-decoration: underline;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            margin: 0 auto;
            margin-top: 22px;
        }
        .second span {
            font-weight: normal;
        }
    </style>
    <center>
    
        <h1 class="mainheading">Event Reports</h1>
        <table> 
            <tr>
                <th>Date</th>
                <th>Activity Title</th>
                <th>No. of Participants</th>
                <th>Description</th>
                <th>Outcome</th>
            </tr>
            <tr>
                <td>'.$data["date"].'</td>
                <td>'.$data["title"].'</td>
                <td>'.$noofpart.'</td>
                <td>'.$data["description"].'</td>
                <td>'.$data["outcome"].'</td>
            </tr>
        </table>
    
    </center>
    
    <br>
    
    <div class="second">
        <b>Mode: <span>'.$data["eventmode"].'</span></b>
        <br>
        <b>Date: <span>'.$data["date"].'</span></b>
        <br>
        <b>Timings: <span>'.$data["timings"].'</span></b>
        <br>
    </div>

    <br>

    1. <b>Event Objective: </b><span style="line-height: 30px;">'.$eveobj.'</span>
    <br>
    <br>
    2. <b>About the Event: </b><span style="line-height: 30px;">'.$abouteve.'</span>
    <br>
    <br>
    <div style="page-break-before: always;">
    <br>
    <br>
    3. <b>Technical Aspect: </b><span style="line-height: 30px;">'.$techasp.'</span>
    </div>
    <br>
    <br>
    <br>
    4. <b>Event Outcome: Knowledge achieved, learnings etc (about 150 words in points): </b><span style="line-height: 30px;"><table>'.$outcomehtml.'</table></span>

    <div style="page-break-before: always;">

    </div>
    
    <br>
    <br>
    5. <b>Photographs: </b>
    <br>
    <br>
    '.$imageshtml.'
    
    ';
    
    
// echo '    <img src="http://localhost/dompdf/koala.jpeg"> ';
$doc->loadHtml($html);

$doc->setPaper('letter', 'potrait');

$doc->render();

$doc->stream("dompdf_out.pdf", array("Attachment" => false));

// echo $imageshtml;