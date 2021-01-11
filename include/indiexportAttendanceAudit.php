<?php
require '../include/config.php';
$page = "indieexportAttendancereport";
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

    if (isset($_POST["btn-submit1"])) {

        if ($_POST['r2'] === "student1") {

            $FromTime   = date('Y-m-d', strtotime($_POST['subfrom1']));
            $ToDate   = date('Y-m-d 23:59:59.999', strtotime($_POST['subto1']));

            $query =
                "SELECT userID as 'User Code', fname as 'Firstname', lname as 'Lastname', activity as 'Activity', Date_format(activityDate, '%M/%e/%Y %h:%i:%s %p') AS 'Activity Date' FROM tbl_SEaudittrail 
           WHERE activityDate >='" . $FromTime  . "'         
           AND activityDate <= '" . $ToDate . "'
           AND  userID = '" . $_POST['studnum'] . "'
           AND schoolYearID = '" . $schoolYearID . "' order by activityDate asc";
            $result = mysqli_query($conn, $query);
        } elseif ($_POST['r2'] === "personnel1") {

            $FromTime   = date('Y-m-d', strtotime($_POST['subfrom1']));
            $ToDate   = date('Y-m-d 23:59:59.999', strtotime($_POST['subto1']));

            $query1 =
                "SELECT userID as 'User Code', fname as 'Firstname', lname as 'Lastname', activity as 'Activity', Date_format(activityDate, '%M/%e/%Y %h:%i:%s %p') AS 'Activity Date' FROM tbl_SEaudittrail 
           WHERE activityDate >='" . $FromTime  . "'         
           AND activityDate <= '" . $ToDate . "'
           AND  userID = '" . $_POST['empnum'] . "'
           AND schoolYearID = '" . $schoolYearID . "' order by activityDate asc";
            $result = mysqli_query($conn, $query1);
        }


        if ($result->num_rows > 0) {
            while ($rowsinfo = $result->fetch_assoc()) {
                $auditinfo[] = $rowsinfo;
            }
        }
        if (empty($auditinfo)) {
            echo '<script type="text/javascript">';
            echo ' alert("No Records to Generate Audit Trail. Please add specific Date Range.")';  //not showing an alert box.
            echo '</script>';
            echo '<script type="text/javascript">';
            echo 'window.open("../u/indieexportAttendanceAudit.php","_self")';
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


            function cleanData(&$str)
            {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "", $str);
                if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

            $filename = $_POST['filenameinfo2'] . ".xls";
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $show_coloumn = false;
            ob_end_clean();
            if (!empty($auditinfo)) {
                foreach ($auditinfo as $record) {
                    if (!$show_coloumn) {

                        // display field/column names in first row
                        echo implode("\t", array_keys($record)) . "\r\n";
                        $show_coloumn = true;
                    }
                    array_walk(
                        $record,
                        __NAMESPACE__ . '\cleanData'
                    );
                    echo implode("\t",  array_values($record)) . "\r\n";
                }
            }
            exit;
        }
    }
