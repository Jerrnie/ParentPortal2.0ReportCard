<?php
session_start();

require '../vendor/autoload.php';
require '../include/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);


//get and set active excel file.

if (empty($_FILES)||empty($_FILES['ASD']['tmp_name'])) {
	$_SESSION['MESSAGE-PROMPT']="No file selected";
	header('Location: personnelImport.php');
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
		header('Location: personnelImport.php');
	}
	else{

$excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
$excel->setActiveSheetIndex(0);

//echo "<table>";
$ctr;
$i = 2; //counter
$NoNewPersonnels = 0;
$noFailed = 0;

$faileds = array();

	#Get all ID
		
while ($excel->getActiveSheet()->getCell('A'.$i)->getValue() !="") {
	$Personnel_code	 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('A'.$i)->getValue()))), 0, 60);
	$Lname			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('B'.$i)->getValue()))), 0, 60);
	$Fname			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('C'.$i)->getValue()))), 0, 60);
	$Mname			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('D'.$i)->getValue()))), 0, 60);
	$Gender			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('E'.$i)->getValue()))), 0, 60);
	$Position		 = mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('F'.$i)->getValue())));
	$Mobile			 = mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('G'.$i)->getValue())));
	$Email			 =substr(mysqli_real_escape_string($conn, stripcslashes(trim($excel -> getActiveSheet() -> getCell('H'.$i)->getValue()))), 0, 60);
	
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
			PostedDateTime
		)
		VALUES
		(
		'". $Personnel_code ."',
		'". $Fname   ."',
		'". $Mname   ."',
		'". $Lname   ."',
		'". $Position   ."',
		'". $Mobile   ."',
		'Active',
		'1',
		'".$nowtime."'
		)";

		mysqli_query($conn, $insertQuery2);
		$NoNewPersonnels++;

		$sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_code= '".$Personnel_code."'and a.Mobile = '".$Mobile."'";

		$result = mysqli_query($conn, $sql);
		$pass_row = mysqli_fetch_assoc($result);
		$userID = $pass_row['Personnel_Id'];

		$hashedPassword = password_hash($Personnel_code, PASSWORD_DEFAULT);
      	$insertQuery = "Insert into tbl_parentuser
						(fname,mname,lname,mobile,sex,email,password,isEnabled,userType,designation,isReset,pID)
						VALUES
						('". $Fname   ."',
						'". $Mname   ."',
						'". $Lname   ."',
						'" . $Mobile . "',
						'".$Gender."',
						'".$Email."',
						'" . $hashedPassword . "',
						'1',
						'E',
						'" . $Position . "',
						'1',
						'" . $userID . "'
					)";
		mysqli_query($conn, $insertQuery);
		

	$i++;
}
	$_SESSION['MESSAGE-PROMPT']="New Entry: ".$NoNewPersonnels;
	header('Location: personnelImport.php?importSuccess');

	}
}

else{
	$_SESSION['MESSAGE-PROMPT']="File is not supported";
	header('Location: personnelImport.php?');
}


?>