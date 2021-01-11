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
	header('Location: studentImport.php');
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
		header('Location: studentImport.php');
	} else {




		//get and set active excel file.
		$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$excel->setActiveSheetIndex(0);

		//echo "<table>";
		$ctr;
		$i = 2; //counter
		$noUpdates = 0;
		$noNewStudent = 0;
		$noNewAccounts = 0;
		$noFailed = 0;

		$faileds = array();
		array_push($faileds, array(
			'studentCode',
			'LRN',
			'Prefix',
			'Lastname',
			'Firstname',
			'Middlename',
			'Suffix',
			'Birthday',
			'ParentName',
			'Address',
			'MobileNo',
			'Email',
			'SectionCode',
			'Reason of reject data'
		));

		#Get all ID

		$checkRecord = mysqli_query($conn, "sELECT a.studentCode, b.mobile FROM tbl_student as a inner join tbl_parentuser as b on b.userID = a.userID where a.schoolYearID = ". $schoolYearID);

		while ($pass_row = mysqli_fetch_assoc($checkRecord)) {
			$list_studentCode[] = $pass_row['studentCode'];
			$list_mobileNumber[] = $pass_row['mobile'];
		}

		while ($excel->getActiveSheet()->getCell('A' . $i)->getValue() != "") {
			$studentCode 	= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('A' . $i)->getValue()))), 0, 30);
			$LRN			= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('B' . $i)->getValue()))), 0, 20);
			$Prefix			= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('C' . $i)->getValue()))), 0, 10);
			$Lastname		= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('D' . $i)->getValue()))), 0, 60);
			$Firstname		= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('E' . $i)->getValue()))), 0, 60);
			$Middlename		= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('F' . $i)->getValue()))), 0, 60);
			$Suffix			= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('G' . $i)->getValue()))), 0, 20);
			$Birthday		= mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('H' . $i)->getValue())));
			$ParentName		= mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('I' . $i)->getValue())));
			$Address		= substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('J' . $i)->getValue()))), 0, 180);
			$MobileNo		= mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('K' . $i)->getValue())));
			$Email			= mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('L' . $i)->getValue())));
			$SectionCode	= mysqli_real_escape_string($conn, stripcslashes(trim($excel->getActiveSheet()->getCell('M' . $i)->getValue())));
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



			// $sec 			= strtotime($Birthday); 
			// $Birthday 		= date ("M d, Y", $sec);  
			$hasError = false;


			if (!validateDate($Birthday)) {
				$hasError = true;


				array_push($faileds, array(
					$studentCode,
					$LRN,
					$Prefix,
					$Lastname,
					$Firstname,
					$Middlename,
					$Suffix,
					$Birthday,
					$ParentName,
					$Address,
					$MobileNo,
					$Email,
					$SectionCode,
					'Birthdate'
				));
			}

			if (!validateMobile($MobileNo)) {
				$hasError = true;

				list($ctr, $isFailed) = isAlreadyOnFailedList($studentCode, $faileds);
				if ($isFailed) {
					$faileds[$ctr][14] .= "+MobileNo";
				} else {
					array_push($faileds, array(
						$studentCode,
						$LRN,
						$Prefix,
						$Lastname,
						$Firstname,
						$Middlename,
						$Suffix,
						$Birthday,
						$ParentName,
						$Address,
						$MobileNo,
						$Email,
						$SectionCode,
						'MobileNo '
					));
				}
			}

			if (strlen(trim($ParentName)) < 3) {
				$hasError = true;

				list($ctr, $isFailed) = isAlreadyOnFailedList($studentCode, $faileds);
				if ($isFailed) {
					$faileds[$ctr][14] .= "+MobileNo";
				} else {
					array_push($faileds, array(
						$studentCode,
						$LRN,
						$Prefix,
						$Lastname,
						$Firstname,
						$Middlename,
						$Suffix,
						$Birthday,
						$ParentName,
						$Address,
						$MobileNo,
						$Email,
						$SectionCode,
						'Parent Full Name '
					));
				}
			}

			if ((1 === preg_match('~[0-9]~', $Lastname)) || (1 === preg_match('~[0-9]~', $Lastname))) {
				$hasError = true;

				list($ctr, $isFailed) = isAlreadyOnFailedList($studentCode, $faileds);
				if ($isFailed) {
					$faileds[$ctr][14] .= "+Name";
				} else {
					array_push($faileds, array(
						$studentCode,
						$LRN,
						$Prefix,
						$Lastname,
						$Firstname,
						$Middlename,
						$Suffix,
						$Birthday,
						$ParentName,
						$Address,
						$MobileNo,
						$Email,
						$SectionCode,
						'Name'
					));
				}
			}

			// if (in_array($MobileNo, $list_mobileNumber)) {
			// 	$hasError=true;

			// 	list ($ctr, $isFailed) = isAlreadyOnFailedList($studentCode,$faileds);
			// 	if ($isFailed) {
			// 		$faileds[$ctr][14] .="+Mobile number is alreader Registered.";
			// 	}
			// 	else{
			// 		array_push($faileds, array(
			// 			$studentCode,
			// 			$LRN,
			// 			$Prefix,
			// 			$Lastname,
			// 			$Firstname,
			// 			$Middlename,
			// 			$Suffix,
			// 			$Birthday,
			// 			$ParentName,
			// 			$Address,
			// 			$MobileNo,
			// 			$Email,
			// 			$SectionCode,
			// 			'Mobile number is alreader Registered'
			// 			)
			// 		);
			// 	}
			// }

			if (!$hasError) {
				//issue to be fix will i allow to update mobile number and parent name when importing

				if (in_array($studentCode, $list_studentCode)) {

					$sql = "sELECT a.studentID FROM tbl_student AS a WHERE a.studentCode = '" . $studentCode . "' and a.schoolYearID = '".$schoolYearID."'";
					$result = mysqli_query($conn, $sql);
					$pass_row = mysqli_fetch_assoc($result);
					$oldID = $pass_row['studentID'];

					$sql = "sELECT b.mobile, b.userID FROM tbl_student AS a inner join tbl_parentuser as b on a.userID=b.userID WHERE b.mobile = '" . $MobileNo . "' and a.studentID = '" . $oldID . "'  and b.usertype='P' and a.schoolYearID ='".$schoolYearID."'";
					$result = mysqli_query($conn, $sql);
					$totalrows = mysqli_num_rows($result);

					// if mobile number is the same #just update
					if ($totalrows > 0) {
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['userID'];
						$BirthdayR = date('Y-m-d', strtotime($Birthday));

						$queryP = "UPDATE tbl_parentuser AS c
 SET c.isEnabled = 1,
 c.fullname = '" . $ParentName . "'
WHERE c.userID = '" . $userID . "'";
						mysqli_query($conn, $queryP);


						$nowtime = date("Y-m-d H:i:s");

						$insertQuery = "update tbl_student
			set
			userID = '" . $userID . "', 
			studentCode = '" . $studentCode . "',
			LRN  = '" . $LRN . "',
			Prefix  = '" . $Prefix . "',
			Lastname  = '" . $Lastname . "',
			Firstname  = '" . $Firstname . "',
			Middlename  = '" . $Middlename . "',
			Suffix  = '" . $Suffix . "',
			Birthdate  = '" . $BirthdayR . "',
			Address  = '" . $Address . "',
			datetimeRegistered = '" . $nowtime . "',
			sectionID = '" . $SectionID . "'
			where studentCode = '" . $studentCode . "'";
						mysqli_query($conn, $insertQuery);
						$noUpdates++;
					}

					//if mobile number is changed. change of parent id or create another parent
					//change the handler of student
					else {
						$hashedPassword = password_hash($MobileNo, PASSWORD_DEFAULT);
						$insertQuery = "Insert into tbl_parentuser
						(mobile,email,password,isEnabled,userType,sqID,isReset,fullName,schoolYearID)
						VALUES
						('" . $MobileNo . "','" . $Email . "','" . $hashedPassword . "','1','P','1','1','" . $ParentName . "','".$schoolYearID."'
					)";
						mysqli_query($conn, $insertQuery);
						$noNewAccounts++;
						$sql = "sELECT a.userID FROM tbl_parentuser AS a WHERE a.password= '" . $hashedPassword . "'and mobile = '" . $MobileNo . "'  and a.usertype='P' and a.schoolYearID ='".$schoolYearID."'";

						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['userID'];
						$nowtime = date("Y-m-d H:i:s");
						$BirthdayR = date('Y-m-d', strtotime($Birthday));

						$sql = "sELECT a.studentID FROM tbl_student AS a WHERE a.studentCode = '" . $studentCode . "' and a.schoolYearID ='".$schoolYearID."'";
						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$oldID = $pass_row['studentID'];

						$query = "dELETE FROM tbl_student  WHERE studentID='" . $oldID . "'";
						mysqli_query($conn, $query);

						$insertQuery = "Insert into tbl_student
						(
						userID,
						studentID,
						studentCode,
						LRN,
						Prefix,
						Lastname,
						Firstname,
						Middlename,
						Suffix,
						Birthdate,
						Address,
						datetimeRegistered,
						sectionID,
						schoolYearID
						)
						VALUES
						(
						'" . $userID . "',
						'" . $oldID . "',
						'" . $studentCode . "',
						'" . $LRN . "',
						'" . $Prefix . "',
						'" . $Lastname . "',
						'" . $Firstname . "',
						'" . $Middlename . "',
						'" . $Suffix . "',
						'" . $BirthdayR . "',
						'" . $Address . "',
						'" . $nowtime . "',
						'" . $SectionID . "',
						'" . $schoolYearID . "'

					)";
						mysqli_query($conn, $insertQuery);
						$list_studentCode[] = $studentCode;
						$list_mobileNumber[] = $MobileNo;
						$noNewStudent++;


						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of students from a file named ' '" . $fileName . ".' , '$date','" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					}
				} else {
					$sql = "sELECT b.mobile, a.userID FROM tbl_parentuser AS a inner join tbl_parentuser as b on a.userID=b.userID WHERE b.mobile = '" . $MobileNo . "' and a.schoolYearID ='".$schoolYearID."'";
					$result = mysqli_query($conn, $sql);
					$totalrows = mysqli_num_rows($result);

					if ($totalrows > 0) {
						$nowtime = date("Y-m-d H:i:s");

						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['userID'];
						$BirthdayR = date('Y-m-d', strtotime($Birthday));
						$queryP = "UPDATE tbl_parentuser AS c
						SET c.isEnabled = 1,
						c.fullname = '" . $ParentName . "'
						WHERE c.userID = '" . $userID . "'";
						mysqli_query($conn, $queryP);

echo $queryP;
						$noUpdates++;

						$insertQuery = "Insert into tbl_student
						(
						userID,
						studentCode,
						LRN,
						Prefix,
						Lastname,
						Firstname,
						Middlename,
						Suffix,
						Birthdate,
						Address,
						datetimeRegistered,
						sectionID,
						schoolYearID
						)
						VALUES
						(
						'" . $userID . "',
						'" . $studentCode . "',
						'" . $LRN . "',
						'" . $Prefix . "',
						'" . $Lastname . "',
						'" . $Firstname . "',
						'" . $Middlename . "',
						'" . $Suffix . "',
						'" . $BirthdayR . "',
						'" . $Address . "',
						'" . $nowtime . "',
						'" . $SectionID . "',
						'" . $schoolYearID . "'
					)";
						mysqli_query($conn, $insertQuery);
			
						++$noNewStudent;
						$list_studentCode[] = $studentCode;
						$list_mobileNumber[] = $MobileNo;


						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of students from a file named ' '" . $fileName . ".' , '$date','" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					} else {

						$hashedPassword = password_hash($MobileNo, PASSWORD_DEFAULT);
						$insertQuery = "Insert into tbl_parentuser
						(mobile,email,password,isEnabled,userType,sqID,isReset,fullName,schoolYearID)
						VALUES
						('" . $MobileNo . "','" . $Email . "','" . $hashedPassword . "','1','P','1','1','" . $ParentName . "','".$schoolYearID."'
					)";
						mysqli_query($conn, $insertQuery);
						$noNewAccounts++;


						$sql = "sELECT a.userID FROM tbl_parentuser AS a WHERE a.password= '" . $hashedPassword . "'and mobile = '" . $MobileNo . "' and usertype='P'";

						$result = mysqli_query($conn, $sql);
						$pass_row = mysqli_fetch_assoc($result);
						$userID = $pass_row['userID'];
						$nowtime = date("Y-m-d H:i:s");
						$BirthdayR = date('Y-m-d', strtotime($Birthday));



						$insertQuery = "Insert into tbl_student
						(
						userID,
						studentCode,
						LRN,
						Prefix,
						Lastname,
						Firstname,
						Middlename,
						Suffix,
						Birthdate,
						Address,
						datetimeRegistered,
						sectionID,
						schoolYearID
						)
						VALUES
						(
						'" . $userID . "',
						'" . $studentCode . "',
						'" . $LRN . "',
						'" . $Prefix . "',
						'" . $Lastname . "',
						'" . $Firstname . "',
						'" . $Middlename . "',
						'" . $Suffix . "',
						'" . $BirthdayR . "',
						'" . $Address . "',
						'" . $nowtime . "',
						'" . $SectionID . "',
						'" . $schoolYearID . "'
					)";
						mysqli_query($conn, $insertQuery);
						$noNewStudent++;
						$list_studentCode[] = $studentCode;
						$list_mobileNumber[] = $MobileNo;

						$date = date('Y-m-d H:i:s');
						$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads list of students from a file named ' '" . $fileName . ".' , '$date','" . $schoolYearID . "')";
						mysqli_query($conn, $insertauditQuery);
					}
				}
			} //x

			else {
				$noFailed++;
			}

			//print_r(in_array($studentCode, $list_studentID)===1);



			$i++;
		}
		// print_r($faileds);




		// $filename ="asd";
		//    $filename = $filename . ".xls";
		//    header("Content-Type: application/vnd.ms-excel");
		//    header("Content-Disposition: attachment; filename=\"$filename\"");
		//    $show_coloumn = true;
		//    ob_end_clean();
		//    if (!empty($faileds)) {
		//        foreach ($faileds as $record) {
		//            if (!$show_coloumn) {
		//                // display field/column names in first row
		//                echo implode("\t", array_keys($record)) . "\n";
		//                $show_coloumn = true;
		//            }
		//            echo implode("\t",  array_values($record)) . "\n";
		//        }
		//    }
		//    exit();
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
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;">New account:</b> ' . $noNewAccounts . '<br> <b style="color:green;">New Student:</b> ' . $noNewStudent . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: studentImport.php?importSuccess');
		} else {
			mysqli_query($conn, $query12);
			$_SESSION['failedList'] = $faileds;
			$_SESSION['MESSAGE-PROMPT'] = '<b style="color:green;">New account:</b> ' . $noNewAccounts . '<br> <b style="color:green;">New Student:</b> ' . $noNewStudent . '<br> <b style="color:orange;">Updates:</b> ' . $noUpdates . '<br> <b style="color:red;">Failed input:</b> ' . (count($faileds) - 1);
			header('Location: studentImport.php?importSuccess');
		}



		//
		// echo $faileds['0']['studentCode'];
		// foreach ($faileds as $key => $value) {
		// 	echo $key['studentCode'];
		// 	echo "<br><br>";
		// }
		// echo "<br><br>". sizeof($faileds);

		// $nof = sizeof($faileds)-1;

		// for ($i=0; $i <= $nof; $i++) { 
		// 	for ($ctr=0; $ctr <=14 ; $ctr++) { 
		// 		echo $faileds[$i][$ctr]." - ";
		// 	}
		// 	echo "<br>";
		// }


		//echo "</table>";
		//
		//
		// $newstr;
		// $date = "May 5, 1998";  
		// 		$whatIWant = substr($date, strpos($date, ",")  -2,2);   
		// 		if (strlen(trim($whatIWant))<2) {
		// 			$newstr = substr_replace($date, "0", strpos($date, ",")-1,0);
		// 		echo $newstr;

		// }  




	}
} else {
	$_SESSION['MESSAGE-PROMPT'] = "File is not supported";
	header('Location: studentImport.php');
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
