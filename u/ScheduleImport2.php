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
	header('Location: schedulePersonnelImport.php');
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
		header('Location: schedulePersonnelImport.php');
	} else {

		//get and set active excel file.
		$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$excel->setActiveSheetIndex(0);

		//echo "<table>";
		$ctr;
		$i = 2; //counter
		$noUpdates = 0;
		$NoNewSchedule = 0;
		$noFailed = 0;

		$faileds = array();
		array_push($faileds, array(
			'Personnel Code',
			'Date Schedule',
			'SchedTimeFrom',
			'SchedTimeTo',
			'Weblink',
			'Reason of reject data'
		));

		#Get all ID
		$checkRecord = mysqli_query($conn, "sELECT a.Personnel_code, b.DateSchedule FROM tbl_Personnel as a inner join tbl_PersonnelSched as b on b.Personnel_Id = a.Personnel_Id");

		while ($pass_row = mysqli_fetch_assoc($checkRecord)) {
			$list_personnelCode[] = $pass_row['Personnel_code'];
			$list_DateSchedule[] = $pass_row['DateSchedule'];
		}


		while ($excel->getActiveSheet()->getCell('A' . $i)->getValue() != "") {
			$Personnel_code	 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('A' . $i)->getValue()))), 0, 60);
			$DateSchedule			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('B' . $i)->getValue()))), 0, 60);
			$SchedTimeFrom			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('C' . $i)->getValue()))), 0, 60);
			$SchedTimeTo			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('D' . $i)->getValue()))), 0, 60);
			$Weblink			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('E' . $i)->getValue()))), 0, 60);

			$hasError = false;

			if (!$hasError) {

				if (in_array($Personnel_code, $list_personnelCode)) {

					
					$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code = '" . $Personnel_code . "' AND a.schoolYearID = '" . $schoolYearID . "'";
					$result = mysqli_query($conn, $sql);
					$pass_row = mysqli_fetch_assoc($result);
					$oldID = $pass_row['Personnel_Id'];

					$datesched = date('Y-m-d', strtotime($DateSchedule));
					$TimeFrom = date('H:i:s', strtotime($SchedTimeFrom));
					$TimeTo = date('H:i:s', strtotime($SchedTimeTo));

					$sql2 = "sELECT b.Personnel_Id, b.PersonnelSched_Id FROM tbl_Personnel AS a inner join tbl_PersonnelSched as b on a.Personnel_Id=b.Personnel_Id WHERE b.DateSchedule = '" . $datesched . "' and b.SchedTimeFrom = '" . $TimeFrom . "' and b.SchedTimeTo = '" . $TimeTo . "' and a.Personnel_Id = '" . $oldID . "' AND a.schoolYearID = '" . $schoolYearID . "'";
					$result2 = mysqli_query($conn, $sql2);
					$totalrows = mysqli_num_rows($result2);
					// if Date and Time Schedule is the same #just update
					if ($totalrows > 0) {

						$sql2 = "SELECT b.Personnel_Id, b.PersonnelSched_Id FROM tbl_Personnel AS a inner join tbl_PersonnelSched as b on a.Personnel_Id=b.Personnel_Id WHERE b.DateSchedule = '" . $datesched . "' and b.SchedTimeFrom = '" . $TimeFrom . "' and b.SchedTimeTo = '" . $TimeTo . "' and a.Personnel_Id = '" . $oldID . "' AND a.schoolYearID = '" . $schoolYearID . "'";
						$result2 = mysqli_query($conn, $sql2);
						$pass_row = mysqli_fetch_assoc($result2);
						$schedId = $pass_row['PersonnelSched_Id'];
						$nowtime = date("Y-m-d H:i:s");

						echo $sql2;
						
						$datesched = date('Y-m-d', strtotime($DateSchedule));
						$TimeFrom = date('H:i:s', strtotime($SchedTimeFrom));
						$TimeTo = date('H:i:s', strtotime($SchedTimeTo));

						
						$insertQuery = "update tbl_PersonnelSched
						set
						DateSchedule  = '" . $datesched . "',
						SchedTimeFrom  = '" . $TimeFrom . "',
						SchedTimeTo  = '" . $TimeTo . "',
						WebLink = '" . $Weblink . "',
						PostedUserID = '" .$user_check. "',
						PostedDateTime = '" . $nowtime . "'
						where PersonnelSched_Id = '" . $schedId . "'";
						mysqli_query($conn, $insertQuery);

						echo $insertQuery;

						$noUpdates++;						
						
					} else {
						$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '" . $Personnel_code . "' AND a.schoolYearID = '" . $schoolYearID . "'";

						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['Personnel_Id'];

						$nowtime = date("Y-m-d H:i:s");

						$datesched = date('Y-m-d', strtotime($DateSchedule));
						$TimeFrom = date('H:i:s', strtotime($SchedTimeFrom));
						$TimeTo = date('H:i:s', strtotime($SchedTimeTo));

						$hashedPassword = password_hash($Personnel_code, PASSWORD_DEFAULT);
						$insertQuery = "Insert into tbl_PersonnelSched
							(Personnel_Id,DateSchedule,SchedTimeFrom,SchedTimeTo,Weblink,PostedUserID,PostedDateTime,schoolYearID)
							VALUES
							('" . $userID   . "',
							'" . $datesched   . "',
							'" . $TimeFrom   . "',
							'" . $TimeTo . "',
							'" . $Weblink . "',
							'1',
							'" . $nowtime . "',
							'" . $schoolYearID . "'
						)";
						mysqli_query($conn, $insertQuery);
						$list_personnelCode[] = $Personnel_code;
						$list_DateSchedule[] = $DateSchedule;
						$NoNewSchedule++;

						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID ) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of personnel schedules from a file named ' '" . $fileName . ". ', '$date','" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					}
				} else {

						$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '" . $Personnel_code . "' AND a.schoolYearID = '" . $schoolYearID . "'";

						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['Personnel_Id'];

						$nowtime = date("Y-m-d H:i:s");

						$datesched = date('Y-m-d', strtotime($DateSchedule));
						$TimeFrom = date('H:i:s', strtotime($SchedTimeFrom));
						$TimeTo = date('H:i:s', strtotime($SchedTimeTo));

						$hashedPassword = password_hash($Personnel_code, PASSWORD_DEFAULT);
						$insertQuery = "Insert into tbl_PersonnelSched
							(Personnel_Id,DateSchedule,SchedTimeFrom,SchedTimeTo,Weblink,PostedUserID,PostedDateTime,schoolYearID)
							VALUES
							('" . $userID   . "',
							'" . $datesched   . "',
							'" . $TimeFrom   . "',
							'" . $TimeTo . "',
							'" . $Weblink . "',
							'1',
							'" . $nowtime . "',
							'" . $schoolYearID . "'
						)";
						mysqli_query($conn, $insertQuery);
						$NoNewSchedule++;
						$list_personnelCode[] = $Personnel_code;
						$list_DateSchedule[] = $DateSchedule;

						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of personnel schedules from a file named ' '" . $fileName . ". ', '$date','" . $schoolYearID . "')";
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
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;"><b style="color:green;">New Schedule:</b> ' . $NoNewSchedule . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: schedulePersonnelImport.php?importSuccess');
		} else {
			$_SESSION['failedList'] = $faileds;
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;"><b style="color:green;">New Schedule:</b> ' . $NoNewSchedule . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: schedulePersonnelImport.php?importSuccess');
		}
	}
} else {
	$_SESSION['MESSAGE-PROMPT'] = "File is not supported";
	header('Location: schedulePersonnelImport.php');
}

#functions
