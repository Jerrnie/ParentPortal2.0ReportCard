<?php

function sendMessage($rID, $sID, $message)
{
  
require '../include/config.php';
require '../include/getschoolyear.php';
  $_POST['subj'] = $rID;
  $htmlcode = $_POST['htmlcode'] = $message;
  $date = date('Y-m-d H:i:s');

  $no = "0";

  $insertQuery = "Insert into tbl_Message
     (
     SenderUser_Id , ReceiverUserId, AdminReplyTag, MessageBody, PostedDateTime, ReadTag,schoolYearID)
     VALUES
     (
      '" . $sID . "','" . $_POST['subj'] . "','" . $no . "','" .  $htmlcode . "','" . $date . "', '" . $no . "','".$schoolYearID."')";
  mysqli_query($conn, $insertQuery);

  $checkRecord = mysqli_query($conn, "SELECT Message_Id FROM tbl_Message where SenderUser_Id ='" . $sID . "' AND schoolYearID = '".$schoolYearID."' Order by Message_Id desc");
  $result = mysqli_fetch_assoc($checkRecord);
  $msgId = $result['Message_Id'];



  $insertQuery3 = "Insert into tbl_MessageThread
     (
     Subject_Id , Message_Id, SenderUser_Id, ReceiverUser_Id)
     VALUES
     (
      '" . $_POST['subj']  . "','" . $msgId  . "','" . $sID . "','" .  $_POST['subj'] . "')";
  mysqli_query($conn, $insertQuery3);
}
//453
?>