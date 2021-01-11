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
  $checkRecord = mysqli_query($conn, "sELECT sectionID, sectionName,sectionYearLevel FROM tbl_sections where sectionID ='" . $id . "'");
  $result = mysqli_fetch_array($checkRecord);
  $sectionName = $result['sectionName'];
  $secYear = $result['sectionYearLevel'];
  $totalrows = mysqli_num_rows($checkRecord);

  if ($totalrows > 0) {
    // Delete record
    $query = "dELETE FROM tbl_sections  WHERE sectionID='" . $id . "'";
    mysqli_query($conn, $query);

    $query = "update tbl_student set sectionID='0' WHERE sectionID='" . $id . "'";
    mysqli_query($conn, $query);

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Deletes the section named ' ' " . $sectionName . "' 'from ' '" .  $secYear . "', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    exit;
  }
}

echo 0;
exit;
