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
	header('Location: personnelImport.php');
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
		header('Location: personnelImport.php');
	} else {




		//get and set active excel file.
		$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$excel->setActiveSheetIndex(0);

		//echo "<table>";
		$ctr;
		$i = 2; //counter
		$noUpdates = 0;
		$noNewPersonnel = 0;
		$noNewAccounts = 0;
		$noFailed = 0;

		$faileds = array();
    array_push($faileds, array(
			'Personnel Code',
			'Lastname',
			'Firstname',
			'Middlename',
			'Gender',
			'Position',
			'Mobile',
			'Email',
			'Reason of reject data'
		));


		#Get all ID
		$checkRecord = mysqli_query($conn, "sELECT a.Personnel_code, b.Mobile FROM tbl_Personnel as a inner join tbl_parentuser as b on b.pID = a.Personnel_Id WHERE a.schoolYearID = '".$schoolYearID."'");

		while ($pass_row = mysqli_fetch_assoc($checkRecord)) {
			$list_personnelCode[] = $pass_row['Personnel_code'];
			$list_mobileNumber[] = $pass_row['Mobile'];
		}

		while ($excel->getActiveSheet()->getCell('A' . $i)->getValue() != "") {
      		$Personnel_code	 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('A' . $i)->getValue()))), 0, 60);
			$Lname			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('B' . $i)->getValue()))), 0, 60);
			$Fname			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('C' . $i)->getValue()))), 0, 60);
			$Mname			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('D' . $i)->getValue()))), 0, 60);
			$Gender			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('E' . $i)->getValue()))), 0, 60);
			$Position		 = mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('F' . $i)->getValue())));
			$Mobile			 = mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('G' . $i)->getValue())));
			$Email			 = substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('H' . $i)->getValue()))), 0, 60);

			$hasError = false;

			
			if (!validateMobile($Mobile)) {
				$hasError = true;

				list($ctr, $isFailed) = isAlreadyOnFailedList($Personnel_code, $faileds);
				if ($isFailed) {
					$faileds[$ctr][14] .= "+MobileNo";
				} else {
					array_push($faileds, array(
						$Personnel_code,
						$Lname,
						$Fname,
						$Mname,
						$Gender,
						$Position,
						$Mobile,
						$Email,
						'Mobile Number invalid'
					));
				}
			}
			if (in_array($Personnel_code, $list_personnelCode)) {
				$hasError = true;

				list($ctr, $isFailed) = isAlreadyOnFailedList($Personnel_code, $faileds);
				if ($isFailed) {
					$faileds[$ctr][14] .= "+Personnel_code";
				} else {
					array_push($faileds, array(
						$Personnel_code,
						$Lname,
						$Fname,
						$Mname,
						$Gender,
						$Position,
						$Mobile,
						$Email,
						'Personnel Code is already registered'
					));
				}
			}
			
			if (in_array($Mobile, $list_mobileNumber)) {
				$hasError = true;

				list($ctr, $isFailed) = isAlreadyOnFailedList($Personnel_code, $faileds);
				if ($isFailed) {
					$faileds[$ctr][14] .= "+Personnel_code";
				} else {
					array_push($faileds, array(
						$Personnel_code,
						$Lname,
						$Fname,
						$Mname,
						$Gender,
						$Position,
						$Mobile,
						$Email,
						'Mobile Number is already registered'
					));
				}
			}


			if (!$hasError) {
				//issue to be fix will i allow to update mobile number and personnel name when importing

				if (in_array($Personnel_code, $list_personnelCode)) {

					$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code = '" . $Personnel_code . "' ";
					$result = mysqli_query($conn, $sql);
					$pass_row = mysqli_fetch_assoc($result);
					$oldID = $pass_row['Personnel_Id'];

					
					$sql2 = "SELECT b.mobile,b.pID FROM tbl_Personnel AS a, tbl_parentuser AS b WHERE a.Personnel_Id=b.pID AND b.mobile = '" . $Mobile . "' and b.pID = '" . $oldID . "'  and b.usertype='E' ";
					$result = mysqli_query($conn, $sql2);
					$totalrows = mysqli_num_rows($result);
					// if mobile number is the same #just update
					if ($totalrows > 0) {
						
					$sql2 = "SELECT b.mobile,b.pID FROM tbl_Personnel AS a, tbl_parentuser AS b WHERE a.Personnel_Id=b.pID AND b.mobile = '" . $Mobile . "' and b.pID = '" . $oldID . "'  and b.usertype='E' ";
					$result = mysqli_query($conn, $sql2);
					$totalrows = mysqli_num_rows($result);

					$pass_row = mysqli_fetch_assoc($result);
					$pID = $pass_row['pID'];

						$queryP1 = "UPDATE tbl_parentuser AS c
						SET c.isEnabled = '1',isReset ='2', c.fullName = CONCAT('$Fname',' ','$Lname')
						WHERE c.pID = '" . $pID . "'";
						mysqli_query($conn, $queryP1);

						$nowtime = date("Y-m-d H:i:s");

			            $insertQuery = "update tbl_Personnel
						set
						Personnel_code = '" . $Personnel_code . "',
						Lname  = '" . $Lname . "',
						Fname  = '" . $Fname . "',
						Mname  = '" . $Mname . "',
						Position = '" . $Position . "',
						Mobile = '" . $Mobile . "',
						PostedDateTime = '" . $nowtime . "'
						where Personnel_Id = '" . $pID . "'";
						mysqli_query($conn, $insertQuery);
						$noUpdates++;
					}

					//if mobile number is changed. change of parent id or create another parent
					//change the handler of student
					else {

						$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '" . $Personnel_code . "'and a.Mobile = '" . $Mobile . "' AND a.schoolYearID = '" . $schoolYearID . "'";
						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['Personnel_Id'];

						$nowtime = date("Y-m-d H:i:s");

						$insertQuery2 = "Insert into tbl_Personnel
						(
							Personnel_code,
							Fname,
							Mname,
							Lname,
							Position,
							Mobile,
							Status,
							PostedUserID,
							PostedDateTime,
							schoolYearID
						)
						VALUES
						(
						'" . $Personnel_code . "',
						'" . $Fname   . "',
						'" . $Mname   . "',
						'" . $Lname   . "',
						'" . $Position   . "',
						'" . $Mobile   . "',
						'Active',
						'1',
						'" . $nowtime . "',
						'" . $schoolYearID . "'
						)";

						mysqli_query($conn, $insertQuery2);
						$noNewPersonnel++;




						$hashedPassword = password_hash($Personnel_code, PASSWORD_DEFAULT);
						$insertQuery = "Insert into tbl_parentuser
						(fname,mname,lname,mobile,sex,email,password,isEnabled,userType,designation,pID,fullName,isReset,schoolYearID)
						VALUES
						('" . $Fname   . "',
						'" . $Mname   . "',
						'" . $Lname   . "',
						'" . $Mobile . "',
						'" . $Gender . "',
						'" . $Email . "',
						'" . $hashedPassword . "',
						'1',
						'E',
						'" . $Position . "',
						'" . $userID . "',
						CONCAT('" . $Fname . "',' ','" . $Lname . "'),
						'2',
						'" . $schoolYearID . "'
	                    )";

						mysqli_query($conn, $insertQuery);
						$noNewAccounts++;

						$list_personnelCode[] = $Personnel_code;
						$list_mobileNumber[] = $Mobile;
						$noNewPersonnel++;

						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of personnel from a file named ' '" . $fileName . ". ', '$date', '" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					}
				} else {
					$sql = "sELECT b.mobile, a.pID FROM tbl_Personnel AS a inner join tbl_parentuser as b on a.pID=b.pID WHERE b.mobile = '" . $Mobile . "'";
					$result = mysqli_query($conn, $sql);
					$totalrows = mysqli_num_rows($result);

					if ($totalrows > 0) {
						$nowtime = date("Y-m-d H:i:s");

						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['pID'];
						$BirthdayR = date('Y-m-d', strtotime($Birthday));
						$queryP = "UPDATE tbl_parentuser AS c
						SET c.isEnabled = '1', c.isReset = '2', c.fullName = CONCAT('$Fname',' ','$Lname')
                WHERE c.pID = '" . $userID . "'";
						mysqli_query($conn, $queryP);


            $insertQuery = "update tbl_Personnel
						set
						Personnel_code = '" . $Personnel_code . "',
						Lname  = '" .  $Lname. "',
						Fname  = '" . $Fname . "',
						Mname  = '" . $Mname . "',
						Position = '" . $Position . "',
						Mobile = '" . $Mobile . "',
						datetimeRegistered = '" . $nowtime . "'
						where pID = '" . $userID . "'";
						mysqli_query($conn, $insertQuery);

            ++$noNewPersonnel;
						$list_personnelCode[] = $Personnel_code;
						$list_mobileNumber[] = $Mobile;


            $date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of personnel from a file named ' '" . $fileName . ". ', '$date')";
						mysqli_query($conn, $insertauditQuery);
      		} else {

						$nowtime = date("Y-m-d H:i:s");

						$insertQuery2 = "Insert into tbl_Personnel
		(
			Personnel_code,
			Fname,
			Mname,
			Lname,
			Position,
			Mobile,
			Status,
			PostedUserID,
			PostedDateTime,
			schoolYearID
		)
		VALUES
		(
		'" . $Personnel_code . "',
		'" . $Fname   . "',
		'" . $Mname   . "',
		'" . $Lname   . "',
		'" . $Position   . "',
		'" . $Mobile   . "',
		'Active',
		'1',
		'" . $nowtime . "',
		'" . $schoolYearID . "'
		)";

						mysqli_query($conn, $insertQuery2);
						$noNewPersonnel++;

						$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '" . $Personnel_code . "'and a.Mobile = '" . $Mobile . "' AND a.schoolYearID = '" . $schoolYearID . "'";

						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['Personnel_Id'];

						$hashedPassword = password_hash($Personnel_code, PASSWORD_DEFAULT);
						$insertQuery = "Insert into tbl_parentuser
						(fname,mname,lname,mobile,sex,email,password,isEnabled,userType,designation,pID,fullName,isReset,schoolYearID)
						VALUES
						('" . $Fname   . "',
						'" . $Mname   . "',
						'" . $Lname   . "',
						'" . $Mobile . "',
						'" . $Gender . "',
						'" . $Email . "',
						'" . $hashedPassword . "',
						'1',
						'E',
						'" . $Position . "',
						'" . $userID . "',
						CONCAT('" . $Fname . "',' ','" . $Lname . "'),
						'2',
						'" . $schoolYearID . "'
                    )";

						mysqli_query($conn, $insertQuery);
						$noNewAccounts++;
						$list_personnelCode[] = $Personnel_code;
						$list_mobileNumber[] = $Mobile;

						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of personnel from a file named ' '" . $fileName . ". ', '$date','" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					}
				}
			} //x

			else {
				$noFailed++;
			}

			$i++;
		}
		// print_r($faileds);

		$query12 = "UPDATE tbl_parentuser AS c
 SET c.isEnabled = 0
WHERE c.usertype = 'P' AND 
c.userID NOT IN 
(SELECT cid FROM (
SELECT a.userID AS cid FROM tbl_student AS a INNER JOIN tbl_parentuser AS b ON b.userID = a.userID ) AS c
)";

		if (count($faileds) < 2) {
			unset($_SESSION['failedList']);
			mysqli_query($conn, $query12);
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;">New account:</b> ' . $noNewAccounts . '<br> <b style="color:green;">New Personnel:</b> ' . $noNewPersonnel . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: personnelImport.php?importSuccess');
		} else {
			mysqli_query($conn, $query12);
			$_SESSION['failedList'] = $faileds;
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;">New account:</b> ' . $noNewAccounts . '<br> <b style="color:green;">New Personnel:</b> ' . $noNewPersonnel . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: personnelImport.php?importSuccess');
		}

	}
} else {
	$_SESSION['MESSAGE-PROMPT'] = "File is not supported";
	header('Location: personnelImport.php');
}


function validateDate($date, $format = 'M d, Y', $format2 = 'F d, Y', $format3 = 'm/d/Y')
{

	$f = DateTime::createFromFormat($format3, $date);
	if (($f && $f->format($format3) === $date)) {
		return true;
	} else if (strpos($date, ',') === false) {
		return false;
	} else {
		$whatIWant = substr($date, strpos($date, ",")  - 2, 2);
		if (strlen(trim($whatIWant)) < 2) {
			$date = substr_replace($date, "0", strpos($date, ",") - 1, 0);
		}
		$d = DateTime::createFromFormat($format, $date);
		$e = DateTime::createFromFormat($format2, $date);
		// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return ($d && $d->format($format) === $date) || ($e && $e->format($format2) === $date);
	}
}


function validateMobile($Mobile)
{
	return preg_match('/^[0-9]{11}+$/', $Mobile);
}

function isAlreadyOnFailedList($Personnel_code, $faileds)
{
	$isFailed = false;
	$i = 0;
	//check if already exist in failed imports
	if (sizeof($faileds) == 0) {
		$isFailed = false;
	} else {
		$nof = sizeof($faileds) - 1;

		for ($i; $i <= $nof; $i++) {
			if ($Personnel_code == $faileds[$i]['0']) {
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
