<?php
require '../include/config.php';
session_start();
$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];

$error = '';
$to = '';
$message = '';


if (empty($_POST["to"])) {
    $error .= '<p class="text-danger">Parent is required</p>';
} else {
    $to = $_POST["to"];
}

if ($error == '') {
    $_POST['to'] = mysqli_real_escape_string($conn, stripcslashes($_POST['to']));
    $_POST['textarea1'] = mysqli_real_escape_string($conn, stripcslashes($_POST['textarea1']));
    $htmlcode = htmlentities(htmlspecialchars($_POST['textarea1']));
    $date = date('Y-m-d H:i:s');
    $no = "0";
    $yes = "1";

    $insertQuery = "Insert into tbl_Message
 (
 Parent_Id, AdminReplyTag , Admin_Id, MessageBody, PostedDateTime, ReadTag)
 VALUES
 (
  '" . $_POST['to'] . "','" . $yes . "','" . $user_check . "','" .  $htmlcode . "','" . $date . "', '" . $no . "')";
    mysqli_query($conn, $insertQuery);

    $error = '<label class="text-success">Comment Added</label>';
}
