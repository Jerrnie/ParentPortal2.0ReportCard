<!DOCTYPE html>
<?php
require '../include/config.php';
require '../assets/phpfunctions.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require 'assets/generalSandC.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "readmail";
session_start();
?>

<html lang="en">

<style type="text/css">
    .small-box {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .fa_custom {
        color: #0099CC
    }

    #myBtn1 {
        opacity: 0.7;
    }

    #myBtn {
        opacity: 0.7;
    }
</style>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Parent Portal | Read Message</title>
     <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

    <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../include/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../include/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini">

    <div class=" wrapper">

        <?php
        require 'includes/navAndSide.php';
        $user_check = $_SESSION['userID'];
        $levelCheck = $_SESSION['usertype'];
        $userFname = $_SESSION['first-name'];
        $userLname = $_SESSION['last-name'];
        if (!isset($user_check) && !isset($password_check)) {
            session_destroy();
            header("location: ../index.php");
        } else if ($levelCheck == 'P') {
            header("location: home.php");
        } else if ($levelCheck == 'E') {
            header("location: PersonnelHome.php");
        }
foreach($_GET as $loc=>$item)
    $_GET[$loc] = base64_decode(urldecode($item));

        if (isset($_GET['page'])&&isset($_GET['id'])&&isset($_GET['hash'])) {

        $salt = "Ph03n1x927";


        $var1 = md5($salt.$_GET['page'].$_GET['id']);

            if ($_GET['hash']!=$var1) {
                header("location: inbox.php");

            }


            $sql =
                "SELECT a.Subject_Id, a.Message_Id, a.ReceiverUser_Id
                FROM tbl_MessageThread a
                -- LEFT JOIN tbl_MessageSubject b ON a.Subject_Id = b.Subject_Id
                WHERE a.Subject_Id = '" . $_GET['page'] . "' 
                AND a.ReceiverUser_Id = '" . $_SESSION['userID'] . "' 
                or a.SenderUser_Id = '" . $_SESSION['userID'] . "'";
            $result = mysqli_query($conn,  $sql);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    if ($row = mysqli_fetch_assoc($result)) {
                        // $pID = $row[2];
                        // $Sname = $row['SubjectName'];
                        $msgId = $row['Message_Id'];
                        $rID = $row['ReceiverUser_Id'];
                    }
                }

                $checkReadTag = mysqli_query($conn, "SELECT a.Message_Id, b.ReadTag
                FROM tbl_MessageThread a
                INNER JOIN tbl_Message b ON b.Message_Id = a.Message_Id
                WHERE b.schoolYearID = '" . $schoolYearID . "' AND a.ReceiverUser_Id = '" . $_SESSION['userID'] . "'
                order BY a.Message_Id desc");
                $result = mysqli_fetch_assoc($checkReadTag);
                $msg2 = $result['Message_Id'];
                $read = $result['ReadTag'];

                if ($read == 0) {
                    $date = date('Y-m-d H:i:s');
                    $insertupdateread = "Insert into tbl_MessageReadState(Message_Id, User_Id, ReadDateTime)
                            VALUES('" . $msg2 . "','" . $_SESSION['userID'] . "','" . $date . "')";
                    mysqli_query($conn, $insertupdateread);
                } else {
                    //Do Nothing
                }

                $date = date('Y-m-d H:i:s');
                $yes = '1';
                $insertupdate = "Update tbl_Message AS m, (SELECT a.Subject_Id, a.Message_Id, a.ReceiverUser_Id
                FROM tbl_MessageThread a
                LEFT JOIN tbl_MessageSubject b ON a.Subject_Id = b.Subject_Id
                WHERE a.Subject_Id ='" . $_GET['page'] . "' AND a.ReceiverUser_Id = '" . $_SESSION['userID'] . "') 
                AS p SET m.ReadTag='" . $yes . "' WHERE p.Message_Id = m.Message_Id";
                mysqli_query($conn, $insertupdate);
            }
        } else {
            header("location: inbox.php");
        }


        ?>

        <div class="content-wrapper">

            <div class="container-fluid">

                <section class="content">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="card card-outline card-info">

                                <div class="card-header">

                                    <div class="card-title" style="font-size: 30px;">
                                        Read Message
                                        <small></small>

                                    </div>

                                    <div class="float-right">

                                        <button id="reply" type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                                        <!-- <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button> -->
                                    </div>
                                    <!-- <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div> -->
                                    <!-- <i class="fa fa-angle-double-down float-right" style="font-size:25px" id="myBtn1"></i> -->
                                    <form action="" method="post">

                                        <div class="mb-3">
                                            <textarea value="" id="textarea1" name="textarea1" class="textarea" maxlength="250" placeholder="Your Message Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if (isset($_POST['textarea1'])) {
                                                                                                                                                                                                                                                                                        echo htmlentities($_POST['textarea1']);
                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                    ?></textarea>
                                            <span id="counter">250</span> <a id="char">character(s) remaining</a>

                                            <div class="float-right">
                                                <button id="close" type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                                                &nbsp&nbsp
                                                <button id="send" type="submit" name="send" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                                            </div>
                                        </div>
                                </div>
                                <!--next-->
                                </form>


                                <div class="card-header">

                                    <!-- <div class="card-tools">
                                        <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Previous"><i class="fas fa-chevron-left"></i></a>
                                        <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Next"><i class="fas fa-chevron-right"></i></a>
                                    </div> -->

                                    <!-- <div class="card-body p-0"> -->

                                    <!-- <div class="mailbox-read-info">
                                        <h4> Subject: <?php echo $msg2 ?></h4>

                                    </div> -->
                                    <!-- <span class="mailbox-read-time float-right">
                                          
                                        </span></h6> -->
                                    <!-- </div> -->

                                    <!-- <div class="mailbox-controls with-border text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                                                <i class="far fa-trash-alt"></i></button>
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                                                <i class="fas fa-reply"></i></button>
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                                                <i class="fas fa-share"></i></button>
                                        </div>

                                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                                            <i class="fas fa-print"></i></button>
                                    </div> -->

                                    <div class="mailbox-read-message">

                                        <!-- <textarea readonly value="" name="htmlcode" class="textarea" style="resize: none; width: 100%; height: 200px; font-size: 14px; line-height: 18px; border:none ; padding: 10px;"> <?php echo $message ?></textarea> -->
                                        <!-- <div id="display_comment"></div> -->
                                        <?php
                                        $sql = "SELECT DISTINCT a.Subject_Id, a.Message_Id, 
                                        a.SenderUser_Id, e.fullName, c.MessageBody,
                                        a.ReceiverUser_Id, f.fullName, d.MessageBody,
                                        c.Message_Id, c.PostedDateTime, d.PostedDateTime,     
                                        c.ReadTag, b.ReadDateTime
                                        FROM tbl_MessageThread a
                                        LEFT JOIN tbl_MessageReadState b ON a.Message_Id = b.Message_Id 
                                        LEFT JOIN tbl_Message c ON c.Message_Id = a.Message_Id
                                        LEFT JOIN tbl_Message d  ON d.Message_Id = a.Message_Id
                                        LEFT JOIN tbl_parentuser e ON a.SenderUser_Id = e.userID
                                        LEFT JOIN tbl_parentuser f ON a.ReceiverUser_Id = f.userID
                                        WHERE c.schoolYearID = '" . $schoolYearID . "' AND
                                        a.Subject_Id = '" . $_GET['page'] . "'
                                        AND (a.ReceiverUser_Id = '" .  $_SESSION['userID'] . "' 
                                        OR a.SenderUser_Id = '" .  $_SESSION['userID'] . "') 
                                        order by c.PostedDateTime desc";


                                        $result = mysqli_query($conn,  $sql);
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_array($result)) {

                                                    $sID = $row[2];
                                                    $sfname = $row[3];

                                                    $sbody = $row[4];
                                                    $rfname = $row[6];
                                                    $sDate    = date_format(date_create($row[9]), "F d, Y g:i A");
                                                    $read = $row[11];
                                                    $readDate = $row[12];
                                                    $rDate    = date_format(date_create($row[12]), "F d, Y g:i A");
                                                    $body = html_entity_decode(htmlspecialchars_decode($sbody));
                                                    // $rID = $row[6];
                                                    // $rfname = $row[7];
                                                    // $rlname = $row[8];
                                                    // $rbody = $row[9];
                                                    // $rDate    = date_format(date_create($row[11]), "F d, Y g:i A");

                                                    //echo($_SESSION['userID']);
                                                    //echo($sID);
                                                    if ($sID == $_SESSION['userID']) {

                                                        if ($read == 0) {
                                                            echo '<div class="row"><div class="col-lg-6 "></div><div class="card col-lg-6 float-right" style="background-color:#EAE6DA;"><div class="card-header" style="background-color:#45B8AC;">Me: <b> ' . $sfname . ' </b> on <i>' . $sDate . '</i></div><div class="card-body">' . $body . '</div></div></div>';
                                                        } else {
                                                            echo '<div class="row"><div class="col-lg-6 "></div><div class="card col-lg-6 float-right" style="background-color:#EAE6DA;"><div class="card-header" style="background-color:#45B8AC;">Me: <b> ' . $sfname . ' </b> on <i>' . $sDate . '</i></div><div class="card-body">' . $body . '</div><small><b><i>Seen: ' . $rDate . '</i></b></small></div></div>';
                                                        }
                                                    } else {
                                                        echo '<div class="row"><div class="card col-lg-6" style="background-color:#EAE6DA;"><div class="card-header" style="background-color:#FF6F61;">From: <b> ' . $sfname . ' </b> on <i>' . $sDate . ' </i></div><div class="card-body">' . $body . '</div></div></div>';
                                                    }
                                                }
                                            }
                                        } else {
                                            echo $result;
                                        }



                                        ?>
                                        <i class="fa fa-angle-double-up float-right" style="font-size:25px" id="myBtn"></i>
                                    </div>
                                    <!--<div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="' . $pID . '">Reply</button></div>-->
                                </div>


                                <div class="card-footer bg-white">
                                    <!-- <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                        <li>
                                            <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                                            <div class="mailbox-attachment-info">
                                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a>
                                                <span class="mailbox-attachment-size clearfix mt-1">
                                                    <span>1,245 KB</span>
                                                    <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                </span>
                                            </div>
                                        </li>
                                             
                                    </ul> -->

                                    <!-- <div class="form-group">
                                            <input value="<?php echo $rID ?>" name="to" id="to" type="text" class="form-control" placeholder="To:">
                                        </div> -->

                                    <!-- <div class="form-group">
                                        <input value="<?php echo isset($_POST['subj']) ? $_POST['subj'] : '' ?>" name="subj" id="compose-subject" type="text" class="form-control" placeholder="Subject:">
                                    </div> -->


                                    <!-- <div class="mb-3">
                                            <textarea value="" id="textarea1" name="textarea1" class="textarea" maxlength="250" placeholder="Your Message Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if (isset($_POST['textarea1'])) {
                                                                                                                                                                                                                                                                                        echo htmlentities($_POST['textarea1']);
                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                    ?></textarea>
                                            <span id="counter">250</span> <a id="char">character(s) remaining</a>

                                            <div class="float-right">
                                                <button id="close" type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                                                &nbsp&nbsp
                                                <button id="send" type="submit" name="send" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                                            </div>
                                        </div>
                                </div> -->

                                    <!-- <!-- <div class="card-footer"> -->
                                    <div class="float-right">

                                        <!-- <button id="reply" type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button> -->
                                        <!-- <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button> -->
                                    </div>
                                    <!-- <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                                    <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button> -->
                                </div>

                            </div>

                        </div>

                </section>

            </div>

        </div>

        <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    </div>

    <?php

    require 'assets/scripts.php';

    if (isset($_POST['send'])) {
        echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
        // $_POST['subj'] = mysqli_real_escape_string($conn, stripcslashes($_POST['subj']));
        $_POST['to'] = mysqli_real_escape_string($conn, stripcslashes($_POST['to']));
        $_POST['textarea1'] = mysqli_real_escape_string($conn, stripcslashes($_POST['textarea1']));
        $htmlcode = htmlentities(htmlspecialchars($_POST['textarea1']));
        $date = date('Y-m-d H:i:s');
        $no = "0";
        $yes = "1";

        // TODO if Stament...


        $insertQuery = "Insert into tbl_Message
     (
     SenderUser_Id , ReceiverUserId, AdminReplyTag, MessageBody, PostedDateTime, ReadTag,schoolYearID)
     VALUES
     (
      '" . $user_check . "','" . $_GET['id'] . "','" . $yes . "','" .  $htmlcode . "','" . $date . "', '" . $no . "','" . $schoolYearID . "')";
        mysqli_query($conn, $insertQuery);

        $checkRecord1 = mysqli_query($conn, "SELECT fullName FROM tbl_parentuser WHERE userID  = '" .  $_GET['id']  . "' ");
        $result1 = mysqli_fetch_array($checkRecord1);
        $nameReceiver = $result1['fullName'];

        $date = date('Y-m-d H:i:s');
        $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Sends a message to ' '" . $nameReceiver . "', '$date','" . $schoolYearID . "')";
        mysqli_query($conn, $insertauditQuery);


        $checkRecord = mysqli_query($conn, "SELECT Message_Id FROM tbl_Message where SenderUser_Id ='" . $user_check . "' AND schoolYearID = '" . $schoolYearID . "' Order by Message_Id desc");
        $result = mysqli_fetch_assoc($checkRecord);
        $msgId = $result['Message_Id'];

        //         $insertquery2 = "Insert into tbl_MessageSubject (Message_Id) 
        // Values
        // ('" . $msgId . "')";
        //         mysqli_query($conn, $insertquery2);


        $insertquery3 = "Insert into tbl_MessageThread (Subject_Id, Message_Id, SenderUser_Id, ReceiverUser_Id) 
    Values
    ('" . $_GET['page'] . "', '" .  $msgId . "','" . $user_check . "','" . $_GET['id']  . "')";
        mysqli_query($conn, $insertquery3);


                                                                     $salt = "Ph03n1x927";

                                                                    $var1 = md5($salt. $_GET['page'].$_GET['id']);


                                                                    $encodeThis1 = urlencode(base64_encode($_GET['page']));
                                                                    $encodeThis2 = urlencode(base64_encode($_GET['id']));
                                                                    $encodeThis4 = urlencode(base64_encode($var1));

        header(
            'Location: readmail.php?replySent&page=' . $encodeThis1 . '&id=' . $encodeThis2 . '&hash='.$encodeThis4
        );
    }
    if (isset($_REQUEST['replySent'])) {
        displayMessage("success", "Message has been Sent", " ");
    }



    ?>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../include/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page Script -->

    <script type="text/javascript">
        $("#textarea1, #send, #counter, #char, #close,#compose-subject,#to").hide(); // or you can have hidden w/ CSS
        $("#reply").click(function() {
            $("#textarea1").show();
            $("#send").show();
            $("#counter").show();
            $("#char").show();
            $("#close").show();
            $("#compose-subject").show();
            $('#to').show();
            $("#reply").hide();
        });
        $("#close").click(function() {
            $("#textarea1").hide();
            $("#send").hide();
            $("#counter").hide();
            $("#char").hide();
            $("#close").hide();
            $("#compose-subject").hide();
            $('#to').hide();
            $("#reply").show();
            $("#textarea1").val('').change();
        });

        var maxLength = 250;
        $('#textarea1').on('input', function() {
            var textlen = maxLength - $(this).val().length;
            $('#counter').text(textlen);
            if ($(this).val().length >= maxLength) {
                const toast = swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                toast.fire({
                    type: 'warning',
                    title: 'The maximum number of characters has been reached!'
                });
            }

        });


        $(document).ready(function() {

            $('#myBtn1').click(function() {
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 'slow');
                return false;
            });

        });

        $(document).ready(function() {

            $('#myBtn').click(function() {
                $('html,body').animate({
                    scrollTop: '0px'
                }, 'slow');
                return false;
            });

        });





        // load_comment();

        // function load_comment() {
        //     $.ajax({
        //         url: "../include/fetchmsg.php",
        //         method: "POST",
        //         success: function(data) {
        //             $('#display_comment').html(data);
        //         }
        //     })
        // }
    </script>
    <?php require '../maintenanceChecker.php';
    ?>
</body>

</html>