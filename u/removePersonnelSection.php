<?php
require '../include/config.php';
require '../include/getschoolyear.php';
session_start();
$id = $_POST['studentidx'];
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];

if ($id > 0) {

  // Check record exists
  $checkRecord = mysqli_query($conn, "SELECT psID FROM tbl_PersonnelSection where psID ='" . $id . "'");
  $result = mysqli_fetch_array($checkRecord);
  $title = $result['title'];
  $totalrows = mysqli_num_rows($checkRecord);

  if ($totalrows > 0) {
    // Delete record
    $query = "dELETE FROM tbl_PersonnelSection  WHERE psID='" . $id . "'";
    mysqli_query($conn, $query);

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Has deleted an personnel section entitled: ' '" . $title . "', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    exit;
  }
}

echo 0;
exit;
