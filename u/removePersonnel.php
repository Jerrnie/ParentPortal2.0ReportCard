<?php
require '../include/config.php';
require '../include/getschoolyear.php';
session_start();
$id = $_POST['personnelidx'];
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];

if ($id > 0) {

  // Check record exists
  $checkRecord = mysqli_query($conn, "SELECT Personnel_Id, Personnel_code, Fname, Mname, Lname FROM tbl_Personnel where Personnel_Id ='" . $id . "'");
  $result = mysqli_fetch_array($checkRecord);
  $percode = $result['Personnel_code'];
  $fname = $result['Fname'];
  $mname = $result['Mname'];
  $lname = $result['Lname'];

  $totalrows = mysqli_num_rows($checkRecord);

  if ($totalrows > 0) {
    // Delete record
    $query = "dELETE FROM tbl_Personnel WHERE Personnel_Id='" . $id . "'";
    mysqli_query($conn, $query);

    $query2 = "dELETE FROM tbl_PersonnelSched WHERE Personnel_Id='" . $id . "'";
    mysqli_query($conn, $query2);

    $query3 = "dELETE FROM tbl_parentuser WHERE pID='" . $id . "'";
    mysqli_query($conn, $query3);


    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Deletes a personnel named ' '" . $fname . " ' ' " . $mname . " ' ' " . $lname . " ', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    exit;
  }
}

echo 0;
exit;
