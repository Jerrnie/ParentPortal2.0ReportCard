<?php
session_start();
$user_check = $_SESSION['userID'];
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
	header('Location: courseImport.php');
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
		header('Location: courseImport.php');
	} else {

		$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$excel->setActiveSheetIndex(0);

		//echo "<table>";
		$ctr;
		$i = 2; //counter
		$noUpdates = 0;
		$noNewCourse = 0;
		$noFailed = 0;

		$faileds = array();

		#Get all ID

		$checkRecord = mysqli_query($conn, "sELECT sectionCode FROM tbl_sections");

		while ($pass_row = mysqli_fetch_assoc($checkRecord)) {
			$list_sectionCode[] 	= $pass_row['sectionCode'];
		}

		while ($excel->getActiveSheet()->getCell('A' . $i)->getValue() != "") {
			$sectionCode 	= $excel->getActiveSheet()->getCell('A' . $i)->getValue();
			$sectionName	= $excel->getActiveSheet()->getCell('B' . $i)->getValue();
			$yearLevel		= $excel->getActiveSheet()->getCell('C' . $i)->getValue();
			$sectionCode    = substr(mysqli_real_escape_string($conn, stripcslashes(trim($sectionCode))), 0, 50);
			$sectionName 	= substr(mysqli_real_escape_string($conn, stripcslashes(trim($sectionName))), 0, 180);
			$yearLevel		= substr(mysqli_real_escape_string($conn, stripcslashes(trim($yearLevel))), 0, 35);

			//issue to be fix will i allow to update mobile number and parent name when importing

			if (in_array($sectionCode, $list_sectionCode)) {



				$insertQuery = "update tbl_sections
		set
		sectionName  = '" . $sectionName . "',
		sectionYearLevel	  = '" . $yearLevel	. "'
		where sectionCode = '" . $sectionCode . "'";
				mysqli_query($conn, $insertQuery);
				$noUpdates++;
			} else {
				$insertQuery2 = "Insert into tbl_sections
		(
		sectionCode,
		sectionName,
		sectionYearLevel
		)
		VALUES
		(
		'" . $sectionCode . "',
		'" . $sectionName   . "',
		'" . $yearLevel    . "'
		)";
				mysqli_query($conn, $insertQuery2);
				$noNewCourse++;

				$date = date('Y-m-d H:i:s');
				$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Imports list of sections from a file named ' '" . $fileName . "', '$date','" . $schoolYearID . "')";
				mysqli_query($conn, $insertauditQuery);
			}

			$i++;
		}
		$_SESSION['MESSAGE-PROMPT'] = "New Entry: " . $noNewCourse . " Updated: " . $noUpdates;
		header('Location: courseImport.php?importSuccess');
	}
} else {
	$_SESSION['MESSAGE-PROMPT'] = "File is not supported";
	header('Location: courseImport.php?');
}
