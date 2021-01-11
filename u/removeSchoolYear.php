<?php
require '../include/config.php';
require '../include/getschoolyear.php';
session_start();
$id = $_POST['studentidx'];


if ($id > 0) {

  // Check record exists
  $checkRecord = mysqli_query($conn, "SELECT schoolYearID FROM tbl_schoolyear where schoolYearID ='" . $id . "'");
  $totalrows = mysqli_num_rows($checkRecord);

  if ($totalrows > 0) {
    // Delete record
    $query = "dELETE FROM tbl_schoolyear  WHERE schoolYearID='" . $id . "'";
    mysqli_query($conn, $query);

    exit;
  }
}

echo 0;
exit;
