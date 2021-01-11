<?php
require '../include/config.php';
require '../include/getschoolyear.php';
session_start();
$id = $_POST['studentidx'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];
$userID  = $_SESSION['userID'];

$dir1    = 'SI/';
$files1 = scandir($dir1, 1);

foreach ($files1 as $key => $value) {
  if (pathinfo($value, PATHINFO_FILENAME) == $id) {
    $matchIndex1 = $key;
    $haveMatch1 = true;
    break;
  } else {
    $haveMatch1 = false;
  }
}

if ($haveMatch1) {
  $file = $files1[$matchIndex1];
  unlink("SI/" . $file);
  // $checkRecord = mysqli_query($conn, "SELECT studentCode FROM tbl_student where studentID ='" . $id  . "'");
  // $result = mysqli_fetch_array($checkRecord);
  // $studid = $result['studentCode'];

  $checkRecord1 = mysqli_query($conn, "SELECT firstName, middleName, lastName FROM tbl_student where studentCode ='" . $id . "'");
  $result1 = mysqli_fetch_array($checkRecord1);
  $fname = $result1['firstName'];
  $mname = $result1['middleName'];
  $lname = $result1['lastName'];


  $date = date('Y-m-d H:i:s');
  $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values ('" . $userID . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Deletes the profile of ' '" . $fname . " ' '" . $mname . " ' '" . $lname . ". ', '$date','" . $schoolYearID . "')";
  mysqli_query($conn, $insertauditQuery);
  return 1;
} else {
  return 0;
}
