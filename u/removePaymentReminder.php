<?php
require '../include/config.php';
require '../assets/phpfunctions.php';
require '../include/getschoolyear.php';

session_start();
$id = $_POST['studentidx'];
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];


$query = "update tbl_pr set isDeleted =  '1' WHERE prID='" . $id . "'";
mysqli_query($conn, $query);

$checkRecord = mysqli_query($conn, "SELECT userID FROM tbl_pr WHERE prID  = '" .  $id  . "' ");
$result = mysqli_fetch_array($checkRecord);
$userID = $result['userID'];

$checkRecord1 = mysqli_query($conn, "SELECT fullName FROM tbl_parentuser WHERE userID  = '" .  $userID  . "' ");
$result1 = mysqli_fetch_array($checkRecord1);
$nameReceiver = $result1['fullName'];

$date = date('Y-m-d H:i:s');
$insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Deletes a payment reminder of ' '" . $nameReceiver . ". ', '$date','" . $schoolYearID . "')";
mysqli_query($conn, $insertauditQuery);
