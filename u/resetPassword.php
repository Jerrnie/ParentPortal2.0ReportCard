
<?php
require '../include/config.php';
require '../include/getschoolyear.php';
require 'sendText.php';
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
    // Update record
    $sql1 = "sELECT a.mobile FROM tbl_parentuser AS a WHERE a.userID = '" . $id . "'";

    $result1 = mysqli_query($conn, $sql1);
    $pass_row = mysqli_fetch_assoc($result1);
    $mobile = $pass_row['mobile'];

    $resetpass = rand(1000000, 9999999);
    $Mobile = $mobile;
    $newmessage = 'Your temporary password in Parent Portal is ' . $resetpass . '. Please login and change it immediately.';
    $crypted = password_hash($resetpass, PASSWORD_DEFAULT);

    sendOTP($newmessage, $Mobile);
    $query = mysqli_query($conn, "UPDATE tbl_parentuser SET password ='" . $crypted . "', isReset='1', resetRequest='No' WHERE userID='" . $id . "'");
    mysqli_query($conn, $query);

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Resets the password of ' '" . $pname . "', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    exit;
  }
}

echo 0;
exit;
?>