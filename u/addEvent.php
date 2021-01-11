<?php
session_start();
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];

require '../include/config.php';
require '../include/getschoolyear.php';
//echo $_POST['title'];

require_once('bdd.php');

$dateschedstart = date('Y-m-d H:i:s', strtotime($_POST['start']));
$dateschedend = date('Y-m-d H:i:s', strtotime($_POST['end']));

$dateschedstart2 = date('Y-m-d', strtotime($_POST['start']));
$dateschedend2 = date('Y-m-d', strtotime($_POST['end']));

$datestart = date('Y-m-d', strtotime($_POST['start']));
$dateend = date('Y-m-d', strtotime($_POST['end']));


$timestart = date('H:i:s', strtotime($_POST['start']));
$timeend = date('H:i:s', strtotime($_POST['end']));

if ($dateschedstart2 == '1970-01-01' && $dateschedend2 == '1970-01-01') {
  $message = 'Date and Time Invalid, Please try again.';

  echo "<SCRIPT> //not showing me this
      alert('$message')
      window.location.replace('eventCalendar.php?invalid');
  </SCRIPT>";
} elseif ($dateschedstart2 == '1970-01-01') {
  $message = 'Start Date and Time Invalid, Please try again.';

  echo "<SCRIPT> //not showing me this
      alert('$message')
      window.location.replace('eventCalendar.php?invalid');
  </SCRIPT>";
} elseif ($dateschedend2 == '1970-01-01') {
  $message = 'End Date and Time Invalid, Please try again.';

  echo "<SCRIPT> //not showing me this
      alert('$message')
      window.location.replace('eventCalendar.php?invalid');
  </SCRIPT>";
} elseif ($timestart == $timeend) {
  $message = 'Time Invalid, Please try again.';

  echo "<SCRIPT> //not showing me this
      alert('$message')
      window.location.replace('eventCalendar.php?invalid');
  </SCRIPT>";
} elseif ($timestart > $timeend) {
  $message = 'Time Range Invalid, Please try again.';

  echo "<SCRIPT> //not showing me this
      alert('$message')
      window.location.replace('eventCalendar.php?invalid');
  </SCRIPT>";
} elseif ($datestart > $dateend) {
  $message = 'Date Range Invalid, Please try again.';

  echo "<SCRIPT> //not showing me this
      alert('$message')
      window.location.replace('eventCalendar.php?invalid');
  </SCRIPT>";
} else {

  if (isset($_POST['userID']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])) {

    $userID = $_POST['userID'];
    
    
    $title = str_replace ("'","`",$_POST['title']);
    
		$description = str_replace(array("\n", "\r", "\t", "'", "\\"), array("\\n", "\\r", "\\t", "''", "\\\\"), $_POST['description']);


    $start = $_POST['start'];
    $end = $_POST['end'];
    $color = $_POST['color'];

    $newDateStart = date('Y-m-d H:i:s', strtotime($_POST['start']));
    $newDateEnd = date('Y-m-d H:i:s', strtotime($_POST['end']));

    $sql = "INSERT INTO events(title, schoolYearId,description,start, end, color,posteduserid,datetimeposted) values ('$title','$schoolYearID','$description', '$newDateStart', '$newDateEnd', '$color','$userID',now())";
    //$req = $bdd->prepare($sql);
    //$req->execute();

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearId) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Creates an event entitled ' '" . $title . " ' 'valid from ' '" . $newDateStart . " ' 'to ' '" . $newDateEnd . "', '$date','$schoolYearID')";
    mysqli_query($conn, $insertauditQuery);

    $query = $bdd->prepare($sql);
    if ($query == false) {
      print_r($bdd->errorInfo());
      die('Erreur prepare');
    }
    $sth = $query->execute();
    if ($sth == false) {
      print_r($query->errorInfo());
      die('Erreur execute');
    }
  }
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
