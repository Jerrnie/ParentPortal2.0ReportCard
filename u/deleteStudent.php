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
  $checkRecord = mysqli_query($conn, "sELECT studentID, studentCode, firstName, middleName, lastName FROM tbl_student where studentID ='" . $id . "'");
  $result = mysqli_fetch_array($checkRecord);
  $studcode = $result['studentCode'];
  $fname = $result['firstName'];
  $mname = $result['middleName'];
  $lname = $result['lastName'];
  $totalrows = mysqli_num_rows($checkRecord);

  if ($totalrows > 0) {
    // Delete record
    $query = "dELETE FROM tbl_student  WHERE studentID='" . $id . "'";
    mysqli_query($conn, $query);

    $query12 = "UPDATE tbl_parentuser AS c
 SET c.isEnabled = 0
WHERE c.usertype = 'P' AND 
c.userID NOT IN 
(SELECT cid FROM (
SELECT a.userID AS cid FROM tbl_student AS a INNER JOIN tbl_parentuser AS b ON b.userID = a.userID ) AS c
)";

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Delete a student name ' '" . $fname . " ' ' " . $mname . " ' ' " . $lname . " ', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);


    mysqli_query($conn, $query12);
    echo 1;
    exit;
  }
}

echo 0;
exit;
