<?php
require '../include/config.php';
require '../include/getschoolyear.php';

session_start();
$user_check  = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];
$id = $_POST['personnelidx'];


if ($id > 0) {

  // Check record exists
  $checkRecord = mysqli_query($conn, "SELECT PersonnelSched_Id FROM tbl_PersonnelSched where PersonnelSched_Id ='" . $id . "'");
  $totalrows = mysqli_num_rows($checkRecord);

  $checkRecord1 = mysqli_query($conn, "sELECT Fname, Mname, Lname FROM tbl_Personnel where Personnel_Id ='" . $pid . "'");
  $result1 = mysqli_fetch_array($checkRecord1);
  $fname = $result1['Fname'];
  $mname = $result1['Mname'];
  $lname = $result1['Lname'];

  if ($totalrows > 0) {

    $query = "dELETE FROM tbl_PersonnelSched  WHERE PersonnelSched_Id='" . $id . "'";
    mysqli_query($conn, $query);

    $query = "dELETE FROM tbl_appointment  WHERE PersonnelSched_Id='" . $id . "'";
    mysqli_query($conn, $query);

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Deletes the schedule of ' '" . $fname . "' ' " . $mname . "' ' " . $lname . ". ', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    exit;
  }
}

echo 0;
exit;
