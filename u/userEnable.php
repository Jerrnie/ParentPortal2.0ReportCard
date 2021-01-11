<?php
require '../include/config.php';
require '../include/getschoolyear.php';
session_start();
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];
$id = $_POST['studentidx'];


if ($id > 0) {

  // Check record exists
  $checkRecord = mysqli_query($conn, "SELECT userID, fullName FROM tbl_parentuser where userID ='" . $id . "'");
  $result1 = mysqli_fetch_array($checkRecord);
  $pname = $result1['fullName'];
  $totalrows = mysqli_num_rows($checkRecord);

  if ($totalrows > 0) {
    // Delete record
    $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='1' WHERE userID='" . $id . "'");
    mysqli_query($conn, $query);

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Enables a personnel named ' '" . $pname . "', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);


    exit;
  }
}

echo 0;
exit;
