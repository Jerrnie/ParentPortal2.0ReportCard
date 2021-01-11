<?php
require '../include/config.php';
$page = "exportmsgstatus";
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
session_start();
$user_check = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];
?>

<?php

$check = $_POST['r1'];

if (isset($_POST["btn-submit"])) {
    //%M/%e/%Y %h:%i:%s %p
    if ($_POST['r1'] === "seen") {

        $sql = "SELECT d.fullName AS 'Sender' ,c.fullName AS 'Receiver', b.MessageBody AS 'Message', Date_format(a.ReadDateTime, '%M/%e/%Y %h:%i:%s %p') AS 'Date Viewed'
                FROM tbl_MessageReadState a
                LEFT JOIN tbl_Message b ON a.Message_Id = b.Message_Id
                LEFT JOIN tbl_parentuser c ON b.ReceiverUserId = c.userID
                LEFT JOIN tbl_parentuser d ON b.SenderUser_Id = d.userID
                WHERE b.ReadTag = '1'
                AND Date(a.ReadDateTime) >= '"  . $_POST['subfrom'] . "'
                AND Date(a.ReadDateTime) <= '"  . $_POST['subto'] . "' 
                AND b.schoolYearID = '" . $schoolYearID . "'
                ORDER BY a.ReadDateTime asc";
    } else {

        $sql = "SELECT c.fullName AS 'Sender', b.fullname AS 'Receiver', a.MessageBody AS 'Message', Date_format(a.PostedDateTime, '%M/%e/%Y %h:%i:%s %p') AS 'Date Sent'
        FROM tbl_Message a
        LEFT JOIN tbl_parentuser b ON a.ReceiverUserId = b.userID
        LEFT JOIN tbl_parentuser c ON a.SenderUser_Id = c.userID
        WHERE a.ReadTag = '0'
        AND a.schoolYearID = '" . $schoolYearID . "'
        AND Date(a.PostedDateTime) >= '"  . $_POST['subfrom'] . "'
        AND Date(a.PostedDateTime) <= '"  . $_POST['subto'] . "' ORDER BY a.PostedDateTime asc";
    }
    $resultset = mysqli_query($conn, $sql);

    if ($resultset->num_rows > 0) {
        while ($rowsinfo = $resultset->fetch_assoc()) {
            $msginfo[] = $rowsinfo;
        }
    }
    if (empty($msginfo)) {
        echo '<script type="text/javascript">';
        echo ' alert("No Records to Generate Message Report. Please add specific Date Range.")';  //not showing an alert box.
        echo '</script>';
        echo '<script type="text/javascript">';
        echo 'window.open("../u/exportmessage.php","_self")';
        echo '</script>';
        exit;
    } else {

        if ($check == "seen") {
            $date = date('Y-m-d H:i:s');
            $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearId) Values  
        ('" .  $user_check . "', '" .  $userFname . "', '" .  $userLname . "', 'Exports all messages read by parents.','" . $date . "','$schoolYearID')";
            mysqli_query($conn, $insertauditQuery);
        } elseif ($check == "unseen") {
            $date = date('Y-m-d H:i:s');
            $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearId) Values  
        ('" .  $user_check . "', '" .  $userFname . "', '" .  $userLname . "', 'Exports all messages not read by parents.','" . $date . "','$schoolYearID')";
            mysqli_query($conn, $insertauditQuery);
        }
        //\\n
        function cleanData(&$str)
        {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "", $str);
            if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }


        $aud = 'Audittrail';
        $fname = $aud . date('Ymd');

        $filename = $_POST['filenameinfo'] . ".xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $show_coloumn = false;
        ob_end_clean();
        if (!empty($msginfo)) {
            foreach ($msginfo as $record) {
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
        exit();
    }
}

?>