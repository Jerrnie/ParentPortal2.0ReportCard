<?php

require '../vendor/autoload.php';
require '../include/config.php';
require '../include/getschoolyear.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

session_start();
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];


if (empty($_FILES) || empty($_FILES['ASD']['tmp_name'])) {
	$_SESSION['MESSAGE-PROMPT'] = "No file selected";
	header('Location: viewAllPersonnelSection.php');
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
		header('Location: viewAllPersonnelSection.php');
	} else {

		//get and set active excel file.
		$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$excel->setActiveSheetIndex(0);

		//echo "<table>";
		$ctr;
		$i = 2; //counter
		$noUpdates = 0;
		$NoNewPersonnelSection = 0;
		$noFailed = 0;

		$faileds = array();
		array_push($faileds, array(
			'Personnel Code',
			'Section Code',
			'Reason of reject data'
		));

		#Get all ID

		$checkRecord = mysqli_query($conn, "sELECT Personnel_code FROM tbl_Personnel WHERE schoolYearID ='".$schoolYearID."'");

		while ($pass_row = mysqli_fetch_assoc($checkRecord)) {
			$list_personnelCode[] = $pass_row['Personnel_code'];
		}

		while ($excel->getActiveSheet()->getCell('A' . $i)->getValue() != "") {
			$Personnel_code	 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('A' . $i)->getValue()))), 0, 60);
			$SectionCode	 = mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('B' . $i)->getValue())));
			$SectionID;

			//get courseID
			$sql = "sELECT a.sectionID FROM tbl_sections AS a WHERE a.sectionCode = '" . $SectionCode . "'";

			if ($result = mysqli_query($conn, $sql)) {
				$pass_row = mysqli_fetch_assoc($result);
				$sectionID_Temp = $pass_row['sectionID'];

				if (strlen(trim($sectionID_Temp)) > 0) {
					$SectionID = $sectionID_Temp;
				} else {
					$SectionID = 0;
				}
			} else {
				$SectionID = 0;
			}

			$hasError = false;

			if (!$hasError) {

				if (in_array($Personnel_code, $list_personnelCode)) {

					$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code = '" . $Personnel_code . "' AND a.schoolYearID = '" . $schoolYearID . "' ";
					$result = mysqli_query($conn, $sql);
					$pass_row = mysqli_fetch_assoc($result);
					$oldID = $pass_row['Personnel_Id'];

					
					$sql2 = "SELECT b.psID FROM tbl_Personnel AS a, tbl_PersonnelSection AS b WHERE a.Personnel_Id=b.Personnel_Id AND b.SectionID = '" . $SectionID . "' AND b.Personnel_Id = '" . $oldID . "' AND b.schoolYearID = '" . $schoolYearID . "' LIMIT 1";
					$result = mysqli_query($conn, $sql2);
					$totalrows = mysqli_num_rows($result);
					
					// if Date and Time Schedule is the same #just update
					if ($totalrows > 0) {

						$sql2 = "SELECT b.pID FROM tbl_Personnel AS b WHERE b.Personnel_code = '" . $Personnel_code . "' AND b.schoolYearID = '" . $schoolYearID . "' ";
						$result2 = mysqli_query($conn, $sql2);
						$totalrows = mysqli_num_rows($result2);

						$pass_row2 = mysqli_fetch_assoc($result2);
						$pID = $pass_row2['pID'];

						$nowtime = date("Y-m-d H:i:s");

						$insertQuery = "update tbl_PersonnelSection
						set
						Personnel_Id  = '" . $pID . "',
						sectionID  = '" . $SectionID . "'
						where psID = '" . $psecID . "'
						";
						mysqli_query($conn, $insertQuery);
						$noUpdates++;						
						
					} else {
						$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '" . $Personnel_code . "' AND a.schoolYearID = '" . $schoolYearID . "'";

						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['Personnel_Id'];

						$insertQuery = "Insert into tbl_PersonnelSection
							(Personnel_Id,sectionID,schoolYearID)
							VALUES
							('" . $userID   . "',
							'" . $SectionID   . "',
							'".$schoolYearID."'
							)";
						mysqli_query($conn, $insertQuery);
						
						$list_personnelCode[] = $Personnel_code;
						
						$NoNewPersonnelSection++;
						
						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID ) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of personnel handled from a file named ' '" . $fileName . ". ', '$date','" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					}
				} else {

						$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '" . $Personnel_code . "' AND a.schoolYearID = '" . $schoolYearID . "'";

						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['Personnel_Id'];

						$hashedPassword = password_hash($Personnel_code, PASSWORD_DEFAULT);
						$insertQuery = "Insert into tbl_PersonnelSection
						(Personnel_Id,sectionID,schoolYearID)
						VALUES
						('" . $userID   . "',
						'" . $SectionID   . "'	,
						'".$schoolYearID."'						
					    )";
						mysqli_query($conn, $insertQuery);
						$NoNewPersonnelSection++;
						$list_personnelCode[] = $Personnel_code;
							
						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of personnel handled from a file named ' '" . $fileName . ". ', '$date','" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					}
			} //x

			else {
				$noFailed++;
			}
			$i++;
		}
		if (count($faileds) < 2) {
			unset($_SESSION['failedList']);
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;"><b style="color:green;">New Handled Section:</b> ' . $NoNewPersonnelSection . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: viewAllPersonnelSection.php?importSuccess');
		} else {
			$_SESSION['failedList'] = $faileds;
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;"><b style="color:green;">New Handled Section:</b> ' . $NoNewPersonnelSection . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: viewAllPersonnelSection.php?importSuccess');
		}
	}
} else {
	$_SESSION['MESSAGE-PROMPT'] = "File is not supported";
	header('Location: viewAllPersonnelSection.php');
}

function validateMobile($mobile)
{
	return preg_match('/^[0-9]{11}+$/', $mobile);
}

function isAlreadyOnFailedList($studentCode, $faileds)
{
	$isFailed = false;
	$i = 0;
	//check if already exist in failed imports
	if (sizeof($faileds) == 0) {
		$isFailed = false;
	} else {
		$nof = sizeof($faileds) - 1;

		for ($i; $i <= $nof; $i++) {
			if ($studentCode == $faileds[$i]['0']) {
				$isFailed = true;
				break;
			} else {
				$isFailed = false;
			}
		}
	}
	return array($i, $isFailed);
}

#functions
