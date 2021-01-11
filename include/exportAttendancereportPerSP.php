<?php
require '../include/config.php';
$page = "exportAttendancereport";
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
session_start();
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];
?>
<!DOCTYPE html>
<html>

<body style="border: 5pt solid #000000">

  <?php


  $check = $_POST['r2'];

  if (isset($_POST["btn-submit"])) {
    // $_POST['gradelevel'] = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['gradelevel'])));
    // $_POST['r1'] = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['r1'])));
    // $_POST['filenameinfo'] = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['filenameinfo'])));

    // if  ($_POST['r1'] === "submitted"){
    //   $submitted = 1;
    // }else{
    //   $submitted = 0;
    // }

    $quote = '"';

    if ($_POST['r2'] === "student1") {
      $sql = "select concat(" . $quote . "'" . $quote . ",S.studentCode) as `Student Code`,
      S.lastName as `Last Name`,S.firstName as `First Name`,S.middleName as `Middle Name`,
      (case when A.Mode = 1 then 'Time-In' 
       else 'Time-Out' End) as Status,
       DATE_FORMAT(A.TimePunch, '%M %e, %Y %r') as `Date and Time`,c.sectionYearLevel as `Grade Level`,c.sectionName as `Section Name`
      from tbl_Attendance A
      join tbl_student S on S.studentCode = A.StudentId
      Left join tbl_sections c on S.sectionID = c.sectionID
      where A.isStudent = '1'      
      AND S.studentCode = '" . $_POST['studnum'] . "'
      and date(A.TimePunch) >= '"  . $_POST['subfrom1'] . "'
      and date(A.TimePunch) <= '"  . $_POST['subto1'] . "'
      AND A.schoolYearID = '" . $schoolYearID . "'
      Order by A.StudentId,A.TimePunch;";
    } else //Personnel
    {
      $sql = "select concat(" . $quote . "'" . $quote . ",P.Personnel_code) as `Personnel Code`,
      P.Lname as `Last Name`,P.Fname as `First Name`,P.Mname as `Middle Name`,P.Position,
      (case when A.Mode = 1 then 'Time-In' 
       else 'Time-Out' End) as Status,
      DATE_FORMAT(A.TimePunch, '%M %e, %Y %r') as `Date and Time`
      from tbl_Attendance A
      join tbl_Personnel P on P.Personnel_code = A.StudentId
      where A.isStudent = '2'
      AND P.Personnel_code = '" . $_POST['empnum'] . "'
      and date(A.TimePunch) >= '"  . $_POST['subfrom1'] . "'
      and date(A.TimePunch) <= '"  . $_POST['subto1'] . "'
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
      echo 'window.open("../u/exportAllStudentAttendance.php","_self")';
      echo '</script>';
      exit;
    } else {
      if ($_POST['r2'] === "student1") {
        $date = date('Y-m-d H:i:s');
        $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  
    ('" .  $user_check . "', '" .  $userFname . "', '" .  $userLname . "', 'Exports attendance of ' '" .  $_POST['studnum'] . " ' 'from ' '" . $_POST['subfrom1'] . " ' 'to ' '" . $_POST['subto1'] . "','" . $date . "','" . $schoolYearID . "')";
        mysqli_query($conn, $insertauditQuery);
      } elseif ($_POST['r2'] === "personnel1") {
        $date = date('Y-m-d H:i:s');
        $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  
    ('" .  $user_check . "', '" .  $userFname . "', '" .  $userLname . "', ''Exports attendance of ' '" .  $_POST['empnum'] . " ' 'from ' '" . $_POST['subfrom1'] . " ' 'to ' '" . $_POST['subto1'] . "','" . $date . "','" . $schoolYearID . "')";
        mysqli_query($conn, $insertauditQuery);
      }

      $filename =  $_POST['filenameinfo1'] . ".xls";
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
</body>

</html>