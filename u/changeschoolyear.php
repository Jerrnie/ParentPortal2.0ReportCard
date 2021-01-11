<?php
require '../include/config.php';
require '../assets/phpfunctions.php';

$id = $_POST['studentidx'];


if ($id > 0) {

  // Check record exists
  $checkRecord = mysqli_query($conn, "sELECT schoolYearID from tbl_schoolyear where schoolYearID ='" . $id . "'");
  $totalrows = mysqli_num_rows($checkRecord);



  if ($totalrows > 0) {

    $query = "update tbl_settings set currentSchoolYear = '" . $id . "'";
  }
}
