<?php

session_start();


$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];

if (isset($_POST['view'])) {

    require '../include/config.php';

    $query2 = "SELECT a.SenderUser_Id, a.ReceiverUser_Id, 
          a.Subject_Id, a.Message_Id,
          b.Subject_Id, c.MessageBody, d.fname, d.lname, c.PostedDateTime
          FROM tbl_MessageThread a
          LEFT JOIN tbl_MessageSubject b ON a.Subject_Id = b.Subject_Id
          LEFT JOIN tbl_Message c ON c.Message_Id = b.Message_Id
          LEFT JOIN tbl_parentuser d ON a.SenderUser_Id = d.userID
          WHERE a.ReceiverUser_Id = '" . $_SESSION['userID'] . "' AND c.ReadTag = '0' 
          Order by c.PostedDateTime desc";
    //  // <small><em>' . $message . '</em></small>   
    $result = mysqli_query($conn, $query2);
    $output = '';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $sID = $row[0];
            $subjID = $row[2];
            $msgbody = $row[5];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $date = date_format(date_create($row[8]), "Y-m-d H:i:s");

            $output .= ' 
            <li>
                <a href="#">
                    <strong>' . $fname . ' ' . $lname . '</strong><br/>                               
            </li>
            ';
        }
    } else {
        $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>
             ';
    }
    $query1 = "SELECT a.Message_Id, a.MessageBody, a.SenderUser_Id, a.ReceiverUserId, b.userID 
            FROM tbl_Message a
            LEFT JOIN tbl_parentuser b ON a.SenderUser_Id = b.userID
            WHERE a.ReceiverUserId = '" . $_SESSION['userID'] . "' AND a.ReadTag ='0'";

    $result1 = mysqli_query($conn, $query1);
    $count = mysqli_num_rows($result1);
    $data = array(
        'notification' => $output,
        'unseen_notification' => $count
    );
    echo json_encode($data);
}
