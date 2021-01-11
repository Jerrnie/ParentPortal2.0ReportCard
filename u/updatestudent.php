<?php
ob_start();
require 'assets/scripts/phpfunctions.php';
  require '../include/config.php';


if (isset($_POST['studentInformationSave'])) {
$_POST['studentID']  				   = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['studentID']))); 
$_POST['student-phone']                = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['student-mobile'])));    
$_POST['student-mobile']               = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['student-mobile'])));    
$_POST['address']                      = mysqli_real_escape_string($conn, stripcslashes($_POST['address']));
$_POST['student-lrn']                  = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['student-lrn'])));
$_POST['first-name']                   = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['first-name'])));
$_POST['middle-name']                  = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['middle-name'])));
$_POST['last-name']                    = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['last-name'])));
$_POST['suffix']                       = mysqli_real_escape_string($conn, stripcslashes($_POST['suffix']));
$_POST['student-code']                 = mysqli_real_escape_string($conn, stripcslashes($_POST['student-code']));
$_POST['r1']                           = mysqli_real_escape_string($conn, stripcslashes($_POST['r1']));
$_POST['birthdate']                    = mysqli_real_escape_string($conn, stripcslashes($_POST['birthdate']));
$_POST['birthdate']                    = date('Y-m-d', strtotime($_POST['birthdate']));
$_POST['birthplace']                   = mysqli_real_escape_string($conn, stripcslashes($_POST['birthplace']));


if ($_POST['r1']=='female') {
	$genderprefix = 'Ms.';
}
else{
	$genderprefix = 'Mr.';
}

$insertQuery = "Update tbl_student
SET
studentCode= '".$_POST['student-code'] ."',
LRN= '".$_POST['student-lrn']."',
Prefix= '".$genderprefix."',
Lastname= '".$_POST['last-name']."',
Firstname= '".$_POST['first-name']."',
Middlename= '".$_POST['middle-name']."',
Suffix= '".$_POST['suffix']."',
Birthdate= '".$_POST['birthdate']."',
Birthplace= '".$_POST['birthplace']."',
Address= '".$_POST['address'] ."',
Telno= '".$_POST['student-phone'] ."',
Cellphone= '".$_POST['student-mobile']."'
where studentID = '".$_POST['studentID']."'";      

mysqli_query($conn, $insertQuery);

header('Location: viewDetails.php?page='.$_POST['studentID'].'&EditSuccess');

}

?>

