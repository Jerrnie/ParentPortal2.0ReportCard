<?php
session_start();
$userID = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];

require '../vendor/autoload.php';
require '../include/config.php';
require '../include/getschoolyear.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);


//get and set active excel file.

if (empty($_FILES) || empty($_FILES['ASD']['tmp_name'])) {
	$_SESSION['MESSAGE-PROMPT'] = "No file selected";
	header('Location: viewAllEvents.php');
}


$fileName = $_FILES['ASD']['name'];
$ext = pathinfo($fileName, PATHINFO_EXTENSION);
$allowed = array('xlsx', 'xls');

$file = $_FILES['ASD']['tmp_name'];
$fileSize = $_FILES['ASD']['size'];
$fileType = $_FILES['ASD']['type'];



if (in_array($ext, $allowed)) {
	if ($fileSize > 10 * MB) {
		$_SESSION['MESSAGE-PROMPT'] = "File is too large";
		header('Location: viewAllEvents.php');
	} else {

		$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$excel->setActiveSheetIndex(0);

		//echo "<table>";
		$ctr;
		$i = 2; //counter
		$noNewEvents = 0;
		$noFailed = 0;

		$faileds = array();

		#Get all ID

		while ($excel->getActiveSheet()->getCell('A' . $i)->getValue() != "") {
			$title				= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('A' . $i)->getValue()))), 0, 60);
			$description		= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('B' . $i)->getValue()))), 0, 60);
			$color		= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('C' . $i)->getValue()))), 0, 60);
			$startdatetime1		= mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('D' . $i)->getValue())));
			$enddatetime1		= mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('E' . $i)->getValue())));

			//issue to be fix will i allow to update mobile number and parent name when importing
			$startdatetime2 = date('Y-m-d H:i:s', strtotime($startdatetime1));
			$enddatetime2 = date('Y-m-d H:i:s', strtotime($enddatetime1));
			$nowtime = date("Y-m-d H:i:s");

			$title1 = str_replace(array("\n", "\r", "\t", "'", "\\"), array("\\n", "\\r", "\\t", "''", "\\\\"), $title);

			$description1 = str_replace(array("\n", "\r", "\t", "'", "\\"), array("\\n", "\\r", "\\t", "''", "\\\\"), $description);

			$insertQuery2 = "Insert into events
		(
			title,
			schoolYearID,
			description,
			color,
			start,
			end,
			datetimeposted
		)
		VALUES
		(
		'" . $title1 . "',
		'" .  $schoolYearID . "',
		'" . $description1  . "',
		'" . $color   . "',
		'" . $startdatetime2   . "',
		'" . $enddatetime2   . "',
		'" . $nowtime  . "'
		)";
			mysqli_query($conn, $insertQuery2);
			$noNewEvents++;

			$date = date('Y-m-d H:i:s');
			$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  
   			('" .  $userID . "', '" .  $userFname . "', '" .  $userLname . "', 'Imports list of events from a file named ' '" . $fileName . ". ','" . $date . "','" . $schoolYearID . "')";
			mysqli_query($conn, $insertauditQuery);

			$i++;
		}
		$_SESSION['MESSAGE-PROMPT'] = "New Entry: " . $noNewEvents;
		header('Location: viewAllEvents.php?importSuccess');
	}
} else {
	$_SESSION['MESSAGE-PROMPT'] = "File is not supported";
	header('Location: viewAllEvents.php?');
}
