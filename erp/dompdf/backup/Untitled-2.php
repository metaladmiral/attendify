<?php
session_start();
require("fpdf.php");
include '../assets/Db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* getting data */ 

    $db = new Db();
    $query = $db->query("SELECT * FROM `makes360_events` WHERE `eveid`='".$_GET['id']."' ");
    $query->execute();

    $data = $query->fetchAll(PDO::FETCH_ASSOC)[0];

/* ------------------------------------------------------------------------------------------------------------------ */

$pdf = new FPDF();

$pdf->AddPage();
$pdf->setFont("Arial", "B", 19);

// $pdf->Cell(50, 10, "");

$text = "POST EVENT DETAILS";
$mid_x = 135;
$pdf->Text(68,18,$text);

$pdf->MultiCell(191, 20, "", 0, "C");

/* Titles */
$pdf->setFont("Arial", "B", 11);
$pdf->Cell(18, 10, "Date", 1, 0);
$pdf->Cell(36, 10, "Activity Title", 1, 0);
$pdf->Cell(47, 10, "Number of Participants", 1, 0);
$pdf->Cell(50, 10, "Description of Activity", 1, 0);
$pdf->Cell(40, 10, "Outcome", 1, 0);

$pdf->Ln();

// $mode = "Mode: Hybrid mode (Online and Offline)";
// $date = "Date: 8thSeptember 2022";
// $timing = "Timings: 12:00 p.m onwards";
$mode = "Mode: ".$data["eventmode"];
$date = "Date: ".$data["date"];
$timing = "Timings: ".$data["timings"];


// $aboutevent = "The expert session was organised by the CEC-IT team where the speaker was Head Digital |EFHX|, honorary Joseph Dolphin. The session was organised on the technical topics like Metaverse where the importance of how it carries abilities to replicate the real-world using revolutionary technologies like AR and VR. 
// The speaker was an expert in these and shared his own experience of work in the same technologies. The motive to organise the event was fulfilled that was to make students aware of the importance of their field in the real-world scenarios as well.
// ";

// $eventobj = "The primary objective of the event was to make students aware of the latest concept about Metaverse: its evolution, opportunities, and framework. The importance of Metaverse was also discussed as to how it allows user todigitally gather information and how everyone can have different avatars in the virtual reality and do and feel thing same as the physical world reducing carbon-foot print.";

// $techasp = "A very insightful and interactive event for students in which our expert for the session briefed all about Metaverse Technology; various ways how this technology maymake our day-to-day life easy. The expert staged the process, uses and how to manage and bring up the ideas related. He also highlighted about how Metaverse will be the next iteration of internet and social media, by offering various business opportunities to enterprises worldwide which left students with clarity and new information to work on. ";

// $noofpart = "Students count: 65
// Faculty Count: 11
// Expert Count: 1
// ";
$aboutevent = $data["aboutevent"];
$eventobj = $data["eventobjective"];
$techasp = $data["technicalaspect"];
$noofpart = $data["noofparticipants"];

/* $outcomes = array("Students came to know about Metaverse Technology how it interacts with different Iot devices and hardware to provide physical world like experience in the virtual world.", "Students learnt about the six pillars of metaverse ecosystem i.e., about Avatar, Content Creation, Economy, Social Acceptability, Security & Privacy, and Trust & Accountability.
Students also learnt about the enablers of metaverse ecosystem i.e., about Network, Cloud, Edge Computing, Artificial Intelligence, Blockchain, IoT, And Extended Reality.", "Applications of Metaverse technology were explained in detail like Gaming, online voting etc.");
*/
$outcomes = json_decode($data["eventoutcome"], true);
// $images = array("image.jpg", "image.jpg", "image.jpg", "image.jpg", "image.jpg", "image.jpg");
$images = json_decode($data["photos"], true);


/* Title with values */ 
// $act = "Expert Talk on Metaverse: Evolution, Opportunities, Framework and Online Commerce asdasd Commerce Commerce Commerce Commerce";
$act = $data["title"];
$act = str_split($act, 1);
$max_act = count($act)-1;

// $desc = "This event was organized to give knowledge to students about Metaverse Technology and it future. In this event, students came to know about virtual reality technology and usage of it in today’s world with the help of Metaverse. Detailed information about online Commerce was also given.";
$desc = $data["description"];
$desc = str_split($desc, 1);
$max_desc = count($desc)-1;

// $out = " The session was very interactive, and the students were able to follow almost everything that was being told by the speaker.  All the problems of students regarding Metaverse technology and online Commerce were resolved.  The students got all their queries answered in a very satisfying manner.";
$outcome = $data["outcome"];
$out = str_split($outcome, 1);
$max_out = count($out)-1;

$y = $pdf->getY();
$pdf->setFont("Arial", "", 10);
$pdf->MultiCell(18, 5, $date, "LRB", 0);


$kval = 22;
$line = "";

$pdf->setY($y);
$pdf->setX(18+10);
$pdf->Cell(36, 60, "", "LRB");
for($i=0;$i<=$max_act;$i++) {
    if($i>$kval) {
        $pdf->setX(18+10);
        $pdf->MultiCell(36, 4.5, $line, 0, "L");
        // add a cell
        $line = "";
        $kval += 22;
    }
    $line .= $act[$i];
    if($i==$max_act) {
        //add a cell
        $pdf->setX(18+10);
        $pdf->MultiCell(36, 4.5, $line, 0, "L");
    }
}

$pdf->setY($y);
$pdf->setX(36+18+10);
$pdf->Cell(47, 60, "65", "LRB");


$pdf->Cell(50, 60, "", "LRB");
$kval = 24;
$line = "";
for($i=0;$i<=$max_desc;$i++) {
    if($i>$kval) {
        $pdf->setX(18+10+36+47);
        $pdf->MultiCell(50, 4.8, $line, 0, "L");
        // add a cell
        $line = "";
        $kval += 24;
    }
    $line .= $desc[$i];
    if($i==$max_desc) {
        //add a cell
        $pdf->setX(18+10+36+47);
        $pdf->MultiCell(50, 4.8, $line, 0, "L");
    }
}

$pdf->setY($y);
$pdf->setX(36+18+10+47+50);
$pdf->Cell(40, 60, "", "LRB");

$kval = 24;
$line = "";
$y = $pdf->getY();
// for($i=0;$i<=$max_out;$i++) {
//     if($i>$kval) {
//         $pdf->setX(18+10+36+47+50);
//         $pdf->MultiCell(50, 4.5, $line, 0, "L");
//         // add a cell
//         $line = "";
//         $kval += 24;
//     }
//     $line .= $out[$i];
//     if($i==$max_out) {
//         //add a cell
//         $pdf->setX(18+10+36+47+50);
//         $pdf->MultiCell(50, 4.5, $line, 0, "L");
//     }
// }

$pdf->setX(18+10+36+47+50);
$pdf->MultiCell(40, 4.5, $outcome, 0, "L");

$pdf->Ln();
/* ---------------------------------------- */ 

$pdf->setFont("Arial", "B", 10);
$pdf->Text(10, ($y+60+10),$mode);
$pdf->Text(10, ($y+60+10+6),$date);
$pdf->Text(10, ($y+60+10+11.5),$timing);

$y = ($y + 95);

$pdf->setFont("Arial", "B", 10.8);
$pdf->Text(10, $y, "1. Event Objective: ");
$pdf->setFont("Arial", "", 11);
$pdf->setY($y - 3.8);
$pdf->setX(45);
$pdf->MultiCell(150, 5, $eventobj);

$y = ($pdf->getY() + 10);

$pdf->setFont("Arial", "B", 10.8);
$pdf->Text(10, $y, "2. About the Event: ");
$pdf->setFont("Arial", "", 11);
$pdf->setY($y - 3.8);
$pdf->setX(45);
$pdf->MultiCell(150, 5, $aboutevent);

$y = ($pdf->getY() + 10);

$pdf->setFont("Arial", "B", 10.8);
$pdf->Text(10, $y, "3. Technical Aspect: ");
$pdf->setFont("Arial", "", 11);
$pdf->setY($y - 3.8);
$pdf->setX(48);
$pdf->MultiCell(147, 5, $techasp);

$y = ($pdf->getY() + 10);

$pdf->setFont("Arial", "B", 10.8);
$pdf->Text(10, $y, "4. No. of Participants: ");
$pdf->setFont("Arial", "", 11);
$pdf->setY($y - 3.8);
$pdf->setX(50);
$pdf->MultiCell(147, 5, $noofpart);

$pdf->AddPage();

$y = ($pdf->getY() + 10);
/* Event Outcome */ 
$pdf->setFont("Arial", "B", 10.8);
$pdf->Text(10, $y, "5. Event Outcome: Knowledge achieved, learnings etc (about 150 words in points)");
$pdf->setFont("Arial", "", 11);
$pdf->setY($y + 3.8);
$pdf->setX(10);
/* Row 1 */ 

foreach ($outcomes as $key => $value) {
    $pdf->Ln();
    $y = $pdf->getY();
    $pdf->MultiCell(25, 5.3, "Event Outcome ".($key+1), "LTB");
    $pdf->setY($y);
    $pdf->setX(25+10);
    $pdf->MultiCell(140, 6, $value, "LTBR");
}

// $pdf->Ln();
// $y = $pdf->getY();
// $pdf->MultiCell(25, 5.3, "Event Outcome 1", "LTB");
// $pdf->setY($y);
// $pdf->setX(25+10);
// $pdf->MultiCell(140, 6, $outcome1, "LTBR");

// $pdf->Ln();
// $y = $pdf->getY();
// $pdf->MultiCell(25, 5.3, "Event Outcome 2", "LTB");
// $pdf->setY($y);
// $pdf->setX(25+10);
// $pdf->MultiCell(140, 6, $outcome2, "LTBR");

// $pdf->Ln();
// $y = $pdf->getY();
// $pdf->MultiCell(25, 5.3, "Event Outcome 3", "LTB");
// $pdf->setY($y);
// $pdf->setX(25+10);
// $pdf->MultiCell(140, 6, $outcome3, "LTBR");


$pdf->AddPage();

$pdf->setFont("Arial", "B", 11);
$pdf->Text(10, 15, "Photographs:");

foreach ($images as $key => $value) {
    if(($key%2)==0 && $key!=0) {
        $pdf->AddPage();
    }
    $pdf->Image("../eventreportsdir/".$_GET['id']."/".$value, 10, 20 + (110*($key%2)) + (10*($key%2)), 150, 110);
    // $pdf->Image("images/image.jpg", 10, 20 + 110 + 10, 150, 110);
}
// echo $pdf->getPageHeight();

$pdf->Output();