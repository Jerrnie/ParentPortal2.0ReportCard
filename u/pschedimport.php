<?php

require '../vendor/autoload.php';
require '../include/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

session_start();

if (empty($_FILES)||empty($_FILES['ASD']['tmp_name'])) {
	$_SESSION['MESSAGE-PROMPT']="No file selected";
	header('Location: schedulePersonnelImport.php');
}

$fileName = $_FILES['ASD']['name'];
$ext = pathinfo($fileName, PATHINFO_EXTENSION);
$allowed = array('xlsx', 'xls');

$file = $_FILES['ASD']['tmp_name'];
$fileSize = $_FILES['ASD']['size'];
$fileType = $_FILES['ASD']['type'];


if (in_array($ext, $allowed)) {
	if ($fileSize > 10*MB) {
		$_SESSION['MESSAGE-PROMPT']="File is too large";
		header('Location: schedulePersonnelImport.php');
	}

	else{




//get and set active excel file.
$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
$excel->setActiveSheetIndex(0);

//echo "<table>";
$ctr;
$i = 2; //counter
$noUpdates = 0;
$noNewSchedule = 0;
$noFailed = 0;

$faileds = array();
			array_push($faileds, array(
				'Personnel Code',
				'Date Schedule',
				'SchedTimeFrom',
                'SchedTimeTo',
                'Weblink',
				'Reason of reject data'
				)
			);

	#Get all ID
		
	$checkRecord = mysqli_query($conn,"sELECT a.Personnel_code, b.DateSchedule FROM tbl_Personnel as a inner join tbl_PersonnelSched as b on b.Personnel_Id = a.Personnel_Id");

	while( $pass_row = mysqli_fetch_assoc($checkRecord)){
	    $list_personnelCode[] = $pass_row['Personnel_code']; 
	    $list_dateSchedule[] = $pass_row['DateSchedule']; 
	}

while ($excel->getActiveSheet()->getCell('A'.$i)->getValue() !="") {
	$Personnel_code	 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('A'.$i)->getValue()))), 0, 60);
	$DateSchedule			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('B'.$i)->getValue()))), 0, 60);
	$SchedTimeFrom			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('C'.$i)->getValue()))), 0, 60);
	$SchedTimeTo			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('D'.$i)->getValue()))), 0, 60);
	$Weblink			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('E'.$i)->getValue()))), 0, 60);

	$hasError=false;
	

	if (!$hasError) {

	if (in_array($Personnel_code, $list_personnelCode)) {

		$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code = '".$Personnel_code."'";
		$result = mysqli_query($conn, $sql);
		$pass_row = mysqli_fetch_assoc($result);
		$oldID = $pass_row['Personnel_Id'];

		$datesched = date('Y-m-d', strtotime($DateSchedule));
		$TimeFrom = date('H:i:s', strtotime($SchedTimeFrom));
		$TimeTo = date('H:i:s', strtotime($SchedTimeTo));
	
		$sql = "sELECT b.Personnel_Id, b.PersonnelSched_Id FROM tbl_Personnel AS a inner join tbl_PersonnelSched as b on a.Personnel_Id=b.Personnel_Id WHERE b.DateSchedule = '".$datesched."' and b.SchedTimeFrom = '".$TimeFrom."' and b.SchedTimeTo = '".$TimeTo."' and a.Personnel_Id = '".$oldID."'";
		$result = mysqli_query($conn, $sql);
		$totalrows = mysqli_num_rows($result);

		// if Date and Time Schedule is the same #just update
		if ($totalrows>0) {
			$pass_row = mysqli_fetch_assoc($result);
			$schedId = $pass_row['PersonnelSched_Id'];

			$nowtime = date("Y-m-d H:i:s");

			$insertQuery = "update tbl_PersonnelSched
			set
			DateSchedule  = '".$DateSchedule."',
			SchedTimeFrom  = '".$SchedTimeFrom."',
			SchedTimeTo  = '".$SchedTimeTo."',
			WebLink = '".$Weblink."',
			PostedDateTime = '".$nowtime."'
			where PersonnelSched_Id = '".$schedId."'";
			mysqli_query($conn, $insertQuery);
			$noUpdates++;	
		}

		// create another schedule
		else{
			$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '".$Personnel_code."'";

			$result = mysqli_query($conn, $sql);
			$pass_row = mysqli_fetch_assoc($result);
			$userID = $pass_row['Personnel_Id'];
		
			$nowtime = date("Y-m-d H:i:s");
			
			$datesched = date('Y-m-d', strtotime($DateSchedule));
			$TimeFrom = date('H:i:s', strtotime($SchedTimeFrom));
			$TimeTo = date('H:i:s', strtotime($SchedTimeTo));
		
			$hashedPassword = password_hash($Personnel_code, PASSWORD_DEFAULT);
			  $insertQuery = "Insert into tbl_PersonnelSched
							(Personnel_Id,DateSchedule,SchedTimeFrom,SchedTimeTo,Weblink,PostedUserID,PostedDateTime)
							VALUES
							('". $userID   ."',
							'". $datesched   ."',
							'". $TimeFrom   ."',
							'" . $TimeTo . "',
							'".$Weblink."',
							'1',
							'" . $nowtime . "'
						)";
			mysqli_query($conn, $insertQuery);	

		$list_personnelCode[] =$Personnel_code;
		$list_dateSchedule[] = $DateSchedule;
		$noNewSchedule++;

		}
	}			
		
	}//x

	else{
		$noFailed++;
	}

	$i++;
}


if (count($faileds)<2) {
	unset($_SESSION['failedList']);
mysqli_query($conn,$query12);
	  $_SESSION['MESSAGE-PROMPT']='<b style="color:green;"><b style="color:green;">New Schedule:</b> '.$noNewSchedule.'<br> <b style="color:orange;">Updates:</b> '.$noUpdates.'<br> <b style="color:red;">Failed input:</b> '.(count($faileds)-1);
	header('Location: schedulePersonnelImport.php?importSuccess');
}
else{
	mysqli_query($conn,$query12);
	$_SESSION['failedList']=$faileds;
	  $_SESSION['MESSAGE-PROMPT']='<b style="color:green;"><b style="color:green;">New Schedule:</b> '.$noNewSchedule.'<br> <b style="color:orange;">Updates:</b> '.$noUpdates.'<br> <b style="color:red;">Failed input:</b> '.(count($faileds)-1);
	header('Location: schedulePersonnelImport.php?importSuccess');
}


	}
}

else{
	$_SESSION['MESSAGE-PROMPT']="File is not supported";
	header('Location: schedulePersonnelImport.php');
	
}


    function validateDate($date, $format = 'M d, Y',$format2 = 'F d, Y',$format3 = 'm/d/Y')
{

	$f = DateTime::createFromFormat($format3, $date);
	if (($f && $f->format($format3) === $date)) {
		return true;
	}
	else if (strpos($date, ',')===false) {
		return false;
	}
	else{
		$whatIWant = substr($date, strpos($date, ",")  -2,2);    
		if (strlen(trim($whatIWant))<2) {
			$date = substr_replace($date, "0", strpos($date, ",")-1,0);
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

function isAlreadyOnFailedList($Personnel_code,$faileds)
{
	$isFailed=false;
	$i=0;
	//check if already exist in failed imports
	if (sizeof($faileds)==0) {
		$isFailed = false;
	}

	else{
		$nof = sizeof($faileds)-1;
		
		for ($i; $i <= $nof; $i++) { 
			if ($Personnel_code==$faileds[$i]['0']) {
				$isFailed = true;
				break;
			}
			else{
				$isFailed = false;
			}
		}
	}
	return array ($i, $isFailed);
}

#functions
?>





