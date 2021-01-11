<?php
require '../include/config.php';
$page = "exportAttendancereportPerSection";
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
?>


<?php
if (isset($_POST["btn-submit"])) {

  $quote = '"';

  if ($_POST['r1'] === "student") {
    $sql = "select concat(" . $quote . "'" . $quote . ",S.studentCode) as `Student Code`,
      S.lastName as `Last Name`,S.firstName as `First Name`,S.middleName as `Middle Name`,
      (case when A.Mode = 1 then 'Time-In' 
       else 'Time-Out' End) as Status,
       DATE_FORMAT(A.TimePunch, '%M %e, %Y %r') as `Date and Time`, c.sectionYearLevel as `Grade Level`,c.sectionName as `Section Name`
      from tbl_Attendance A
      join tbl_student S on S.studentCode = A.StudentId
      Left join tbl_sections c on S.sectionID = c.sectionID
      where A.isStudent = 1
      AND S.sectionID = '" . $_POST['sectioncode'] . "'
      and date(A.TimePunch) >= '"  . $_POST['subfrom'] . "'
      and date(A.TimePunch) <= '"  . $_POST['subto'] . "'
      AND A.schoolYearID = '" . $schoolYearID . "'
      Order by A.StudentId,A.TimePunch;";
  }

  $resultset = mysqli_query($conn, $sql);

  if ($resultset->num_rows > 0) {
    while ($rowsinfo = $resultset->fetch_assoc()) {
      $studinfo[] = $rowsinfo;
    }
  }
  if (empty($studinfo)) {
    echo '<script type="text/javascript">';
    echo ' alert("No Records to generate Attendance Records")';  //not showing an alert box.
    echo '</script>';
    echo '<script type="text/javascript">';
    echo 'window.open("../u/exportAllStudentAttendancePerSection.php","_self")';
    echo '</script>';
    exit;
  } else {

    $checkRecord = mysqli_query($conn, "SELECT sectionName, sectionYearLevel FROM tbl_sections where sectionID ='" . $_POST['sectioncode'] . "'");
    $result = mysqli_fetch_assoc($checkRecord);
    $secname = $result['sectionName'];
    $secyr = $result['sectionYearLevel'];

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  
        ('" .  $user_check . "', '" .  $userFname . "', '" .  $userLname . "', 'Exports attendance of all students in the section ' '" .  $secyr . " ' ' " .  $secname . "','" . $date . "','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    $filename =  $_POST['filenameinfo'] . ".xls";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $show_coloumn = false;
    ob_end_clean();
    if (!empty($studinfo)) {
      foreach ($studinfo as $record) {
        if (!$show_coloumn) {
          // display field/column names in first row
          echo implode("\t", array_keys($record)) . "\n";
          $show_coloumn = true;
        }
        echo implode("\t",  array_values($record)) . "\n";
      }
    }
    exit();
  }
}


?>