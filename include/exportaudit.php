<?php
$page = "exportaudit";
require '../include/config.php';
require '../include/getschoolyear.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';


session_start();
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];

if (isset($_POST["export"])) {
    $FromTime   = date('Y-m-d', strtotime($_POST['subfrom']));
    $ToDate   = date('Y-m-d 23:59:59.999', strtotime($_POST['subto']));

    $query =
        "SELECT userID as 'User ID', fname as 'Firstname', lname as 'Lastname', activity as 'Activity', Date_format(activityDate, '%M/%e/%Y %h:%i:%s %p') AS 'Activity Date' FROM tbl_audittrail 
           WHERE activityDate >='" . $FromTime  . "'  
           AND activityDate <= '" . $ToDate . "' 
           AND schoolYearID = '" . $schoolYearID . "' order by activityDate asc
      ";
    $result = mysqli_query($conn, $query);

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
        echo 'window.open("../u/auditexport.php","_self")';
        echo '</script>';
        exit;
    } else {

        $date = date('Y-m-d H:i:s');
        $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  
            ('" .  $user_check . "', '" .  $userFname . "', '" .  $userLname . "', 'Exports list of activities of system administrators from ' '" . $FromTime . " ' 'to ' '" .  $ToDate . "','" . $date . "','" . $schoolYearID . "')";
        mysqli_query($conn, $insertauditQuery);

        function cleanData(&$str)
        {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "", $str);
            if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        $filename = $_POST['filenameinfo'] . ".xls";
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
