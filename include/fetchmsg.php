<?php
require '../include/config.php';
session_start();
$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];

$sql = "SELECT a.Message_Id, a.SenderUser_Id, b.fname, b.lname, a.ReceiverUserId,
                                        c.fname, c.lname, a.MessageBody, e.SubjectName, a.PostedDateTime,e.MessageSubject_ID FROM tbl_Message a
                                        left JOIN tbl_parentuser b on a.SenderUser_Id = b.userID
                                        LEFT JOIN tbl_parentuser c on a.ReceiverUserId = c.userID
                                        LEFT JOIN tbl_MessageThread d ON a.Message_Id = d.Message_Id
                                        LEFT JOIN tbl_MessageSubject e ON e.MessageSubject_ID = d.SubjectName_Id
                                        WHERE a.ReceiverUserId = '" . $user_check . "' or a.SenderUser_Id = '" . $user_check . "'
                                        AND e.MessageSubject_ID = '" . $_GET['page'] . "'";

$result = mysqli_query($conn,  $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array($result)) {
            // $pID = $row[2];
            $sID = $row[1];
            $Sfname = $row[2];
            $Slname = $row[3];

            $rID = $row[4];
            $Rfname = $row[5];
            $Rlname = $row[6];

            // $read = $row[11];
            $msgId = $row[0];
            $message = $row[7];
            $subject = $row[8];
            $subjId = $row[10];

            $Date    = date_format(date_create($row[9]), "F d, Y g:i A");
        }
    }
}
$output = '';

foreach ($result as $row) {
    $output .= '<div class="card">
                                            <div class="card-header">By: <b>' . $Sfname . ' ' . $Slname . '</b> on <i>' . $Date . '</i></div>
                                            <div class="card-body">' . $message . '</div>
                                           
                                            </div> ';

    $output .= get_reply($conn,  $rID);
}
echo $output;



function get_reply($conn, $Receiver_id = 0, $marginleft = 0)
{
    $query =
        "SELECT a.Message_Id, a.SenderUser_Id, b.fname, b.lname, a.ReceiverUserId,
                                            c.fname, c.lname, a.MessageBody, e.SubjectName, a.PostedDateTime FROM tbl_Message a
                                            left JOIN tbl_parentuser b on a.SenderUser_Id = b.userID
                                            LEFT JOIN tbl_parentuser c on a.ReceiverUserId = c.userID
                                            LEFT JOIN tbl_MessageThread d ON a.Message_Id = d.Message_Id
                                            LEFT JOIN tbl_MessageSubject e ON e.MessageSubject_ID = d.SubjectName_Id
                                            WHERE a.ReceiverUserId = '" . $Receiver_id . "'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            if ($row = mysqli_fetch_array($result)) {
                $sID = $row[1];
                $Sfname = $row[2];
                $Slname = $row[3];

                $rID = $row[4];
                $Rfname = $row[5];
                $Rlname = $row[6];

                // $read = $row[11];
                // $msgId = $row[0];
                $message = $row[7];
                $subject = $row[8];

                $Date    = date_format(date_create($row[9]), "F d, Y g:i A");
            }
            $output = '';

            if ($Receiver_id == 0) {
                $marginleft = 0;
            } else {
                $marginleft = $marginleft + 48;
            }
            foreach ($result as $row) {
                $output .= '<div class="panel panel-default">
                                                <div class="panel-heading">To: <b>' . $Rfname . ' ' . $Rlname . '</b> on <i>' . $Date . '</i></div>
                                                <div class="panel-body">' . $message . '</div>
                                               
                                                </div> ';

                $output .= get_reply($conn, $Receiver_id, $marginleft);
            }
            return $output;
        }
    }
}
