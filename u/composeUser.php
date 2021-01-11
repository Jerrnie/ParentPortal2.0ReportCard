<!DOCTYPE html>

<?php
require '../include/config.php';
require '../assets/phpfunctions.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require 'assets/generalSandC.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "composeUser";
session_start();

// session_start();
// $user_check = $_SESSION['userID'];
// $levelCheck = $_SESSION['usertype'];
// if (!isset($user_check) && !isset($password_check)) {
//     session_destroy();
//     header("location: ../index.php");
// } else if ($levelCheck == 'P') {
//     header("location: home.php");
// }

// $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Parent Portal | Compose Message</title>

    <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

    <link rel="stylesheet" href="../include/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" type="text/css" href="assets/css/css-home.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../include/plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="../include/plugins/fontawesome-free/css/all.min.css">
    <!-- sweet alert -->
    <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="../include/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../include/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../include/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../include/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../include/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../include/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../include/dist/css/adminlte.min.css">




    <style type="text/css">
        .small-box {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- nav bar & side bar -->
        <?php
        require 'includes/navAndSide2.php';



        $user_check = $_SESSION['userID'];
        $levelCheck = $_SESSION['usertype'];
        if (!isset($user_check) && !isset($password_check)) {
            session_destroy();
            header("location: ../index.php");
        } else if ($levelCheck == 'A') {
            header("location: index.php");
        } else if ($levelCheck == 'E') {
            header("location: PersonnelHome.php");
        } else if ($levelCheck == 'S') {
            header("location: index.php");
        }
        ?>
        <!-- nav bar & side bar -->

        <!-- Content Wrapper. Contains page content -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($_POST['Ok'])) {
                foreach ($_POST['id'] as $id) :

                    $sq = mysqli_query($conn, "SELECT userID, fullname FROM tbl_parentuser
                                where usertype = 'A' AND userID ='" . $id . "'");
                    $srow = mysqli_fetch_array($sq);

                    $_POST['Uid'] = $srow['userID'];
                    $_POST['fname'] = "To: ".$srow['fullname'];
                // echo $srow['userID'] . "<br>";
                // echo $srow['fullname'] . "<br>";
                // echo $_POST['Uid'];
                endforeach;
            }

            ?>
            <div class="container-fluid">

                <section class="content">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="card card-outline card-info">

                                <div class="card-header">

                                    <div class="card-title" style="font-size: 30px;">

                                        Compose Message
                                        <small></small>

                                    </div>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>

                                </div>

                                <div class="card-body pad">

                                    <form action="" method="post">
                                        <div class="col-mb-3">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <input readonly value="<?php echo isset($_POST['fname']) ?  $_POST['fname']  : '' ?>" list="user" name="compose-to" id="compose-to" type="text" class="form-control" placeholder="To:" required>
                                                    </div>
                                                    <button type="button" id="contact" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                                        <span class="fa fa-address-book">&nbsp&nbsp</span>Contacts
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input hidden="true" value="<?php echo isset($_POST['Uid']) ?  $_POST['Uid']  : '' ?>" name="subj" id="compose-subject" type="text" class="form-control" placeholder="Subject:">
                                        </div>

                                        <div class="mb-3">
                                            <textarea value="" id="textarea" name="htmlcode" class="textarea" maxlength="250" placeholder="Your Message Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if (isset($_POST['htmlcode'])) {
                                                                                                                                                                                                                                                                                    echo htmlentities($_POST['htmlcode']);
                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                ?></textarea>
                                            <span id="counter">250</span> character(s) remaining

                                        </div>

                                        <!-- <div class="form-group">
                      <div class="btn btn-default btn-file">
                        <i class="fas fa-paperclip"></i> Attachment
                        <input type="file" name="attachment">
                      </div> -->
                                        <!-- <p class="help-block">Max. 32MB</p> -->
                                        <!-- </div> -->

                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <div class="float-right">
                                                <!-- <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button> -->
                                                <button type="submit" name="send" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                                            </div>
                                            <!-- <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button> -->
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>
            </div>

        </div>
        <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>

    </div>


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">Contacts</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="body">
                        <table id="example1" class="table table-borderless table-striped ">
                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search..">
                            <thead>
                                <tr>
                                    <th hidden="true">User ID</th>
                                    <th>&nbsp;</th>
                                    <th>Name</th>
                                </tr>

                                <?php
                                $query = "SELECT userID, fullname FROM tbl_parentuser
                                where usertype = 'A' order by fullname";
                                $result = mysqli_query($conn, $query);
                                // $ctr = '0';
                                while ($row = mysqli_fetch_array($result)) {
                                    $uID = $row[0];
                                    $fullname = $row[1];

                                ?>
                                    <tr>
                                        <td><input id="member_select" class="get_value" rName="<?php echo $fullname ?>" type="checkbox" name="id[]" value="<?php echo $uID  . ''  ?>"></td>
                                        <!-- <td><input id="member_select" class="get_value" type="checkbox" onClick="checkbox();" name="member_select[]" value="<?php echo $fname . ' ' . $lname . ' ' ?>"></td> -->
                                        <td><label><?php echo $fullname . ' ' ?></label></td>
                                    </tr>
                                <?php

                                }
                                ?>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="Ok" value="true">Ok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require '../maintenanceChecker.php';
  ?>
</body>


<?php

require 'assets/scripts.php';

if (isset($_POST['send'])) {
    echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
    $_POST['subj'] = mysqli_real_escape_string($conn, stripcslashes($_POST['subj']));
    $_POST['to'] = mysqli_real_escape_string($conn, stripcslashes($_POST['to']));
    $_POST['htmlcode'] = mysqli_real_escape_string($conn, stripcslashes($_POST['htmlcode']));
    $htmlcode = htmlentities(htmlspecialchars($_POST['htmlcode']));
    $date = date('Y-m-d H:i:s');
    $no = "0";

    // TODO if Stament...

    $insertQuery = "Insert into tbl_Message
     (
     SenderUser_Id , ReceiverUserId, AdminReplyTag, MessageBody, PostedDateTime, ReadTag, schoolYearID)
     VALUES
     (
      '" . $user_check . "','" . $_POST['subj'] . "','" . $no . "','" .  $htmlcode . "','" . $date . "', '" . $no . "','" . $schoolYearID . "')";
    mysqli_query($conn, $insertQuery);


    $checkRecord = mysqli_query($conn, "SELECT Message_Id FROM tbl_Message where SenderUser_Id ='" . $user_check . "' AND schoolYearID = '" . $schoolYearID . "' Order by Message_Id desc");
    $result = mysqli_fetch_assoc($checkRecord);
    $msgId = $result['Message_Id'];

    // $insertquery2 = "Insert into tbl_MessageSubject (Message_Id) 
    // Values
    // ('" . $msgId . "')";
    // mysqli_query($conn, $insertquery2);


    // $checkRecord = mysqli_query($conn, "SELECT Subject_Id FROM tbl_MessageSubject where Message_Id ='" . $msgId . "' Order by Message_Id desc");
    // $result = mysqli_fetch_assoc($checkRecord);
    // $subjId = $result['Subject_Id'];

    //     $insertquery3 = "Insert into tbl_MessageReadState (Message_Id, Admin_Id, Parent_Id, ReadDateTime) 
    // Values
    // ('" . $msgId1 . "', '" . $user_check . "','" . $_POST['to'] . "','" . $date . "')";
    //     mysqli_query($conn, $insertquery3);

    $insertQuery3 = "Insert into tbl_MessageThread
     (
     Subject_Id , Message_Id, SenderUser_Id, ReceiverUser_Id)
     VALUES
     (
      '" .   $user_check  . "','" . $msgId  . "','" . $user_check . "','" .  $_POST['subj'] . "')";
    mysqli_query($conn, $insertQuery3);

    header('Location: composeUser.php?composeCreated');
}
if (isset($_REQUEST['composeCreated'])) {
    displayMessage("success", "Message has been sent", " ");
}

?>

<!-- Summernote -->
<script src="../include/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Select2 -->
<script src="../include/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../include/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../include/plugins/moment/moment.min.js"></script>
<script src="../include/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../include/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../include/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../include/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../include/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("example1");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // $(function() {

    //   var charLimit = 250;
    //   $('#textarea').summernote({

    //     toolbar: [
    //       ['style', ['style']],
    //       ['font', ['bold', 'underline', 'clear']],
    //       ['fontname', ['fontname']],
    //       ['color', ['color']],
    //       ['para', ['ul', 'ol', 'paragraph']],
    //       ['table', ['table']],
    //       ['insert', ['link']],
    //       ['view', ['fullscreen', 'codeview', 'help']],
    //     ],
    //     disableDragAndDrop: true,
    //     callbacks: {
    //       onKeydown: function(e) {
    //         let characters = $('#textarea').summernote('code').replace(/(<([^>]+)>)/ig, "");
    //         let totalCharacters = characters.length;
    //         $("#counter").text(totalCharacters + " / " + charLimit);
    //         var t = e.currentTarget.innerText;
    //         if (t.trim().length >= charLimit) {
    //           if (e.keyCode != 8 && !(e.keyCode >= 37 && e.keyCode <= 40) && e.keyCode != 46 && !(e.keyCode == 88 && e.ctrlKey) && !(e.keyCode == 67 && e.ctrlKey)) e.preventDefault();
    //         }
    //       },
    //       onKeyup: function(e) {
    //         var t = e.currentTarget.innerText;
    //         $('#textarea').text(charLimit - t.trim().length);
    //       },
    //       onPaste: function(e) {
    //         let characters = $('#textarea').summernote('code').replace(/(<([^>]+)>)/ig, "");
    //         let totalCharacters = characters.length;
    //         $("#counter").text(totalCharacters + " / " + charLimit);
    //         var t = e.currentTarget.innerText;
    //         var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
    //         e.preventDefault();
    //         var maxPaste = bufferText.length;
    //         if (t.length + bufferText.length > charLimit) {
    //           maxPaste = charLimit - t.length;
    //         }
    //         if (maxPaste > 0) {
    //           document.execCommand('insertText', false, bufferText.substring(0, maxPaste));
    //         }
    //         $('#textarea').text(charLimit - t.length);
    //       }
    //     }
    //   });

    // })

    // $(function() {
    //   //Add text editor
    //   $('#textarea').summernote({
    //     toolbar: [
    //       ['style', ['style']],
    //       ['font', ['bold', 'underline', 'clear']],
    //       ['fontname', ['fontname']],
    //       ['color', ['color']],
    //       ['para', ['ul', 'ol', 'paragraph']],
    //       ['table', ['table']],
    //       ['insert', ['link']],
    //       ['view', ['fullscreen', 'codeview', 'help']],
    //     ],

    //   });

    // })

    $(document).ready(function() {
        $('.get_value').click(function() {
            $('.get_value').not(this).prop('checked', false);
        });
    });

    $(document).ready(function() {
        $('#modal-default').on('hide.bs.modal', function() {
            $('.get_value').prop('checked', false);
        })
    });

    var maxLength = 250;
    $('#textarea').on('input', function() {
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

    $("#compose-to").on('input', function() {
        if ($(this).val().length >= 50) {
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

    $("#compose-subject").on('input', function() {
        if ($(this).val().length >= 50) {
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
</script>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
    setInterval(function() {
        sessionChecker();
    }, 20000); //time in milliseconds
</script>


</html>