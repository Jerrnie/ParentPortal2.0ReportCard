<!DOCTYPE html>

<?php
require '../include/config.php';
require '../assets/phpfunctions.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require 'assets/generalSandC.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "compose";
$allID;
$idsent;
session_start();

// session_start();
// $user_check = $_SESSION['userID'];
// $levelCheck = $_SESSION['usertype'];
// if (!isset($user_check) && !isset($password_check)) {
//   session_destroy();
//   header("location: ../index.php");
// } else if ($levelCheck == 'P') {
//   header("location: home.php");
// }

// $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Parent Portal | Compose Message</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">
  <link rel="stylesheet" href="../include/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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

    #sectionlist {
      height: 300px;
      overflow-y: scroll;
    }

    #user ul {
      background-color: #eee;
      cursor: pointer;
    }

    #user li {
      padding: 12px;
    }

    .modal-md {
      max-width: 40%;
    }
  </style>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- nav bar & side bar -->
    <?php
    require 'includes/navAndSide.php';

    $user_check = $_SESSION['userID'];
    $levelCheck = $_SESSION['usertype'];
    $userFname = $_SESSION['first-name'];
    $userLname = $_SESSION['last-name'];
    if (!isset($user_check) && !isset($password_check)) {
      session_destroy();
      header("location: ../login.php");
    } else if ($levelCheck == 'P') {
      header("location: home.php");
    } else if ($levelCheck == 'E') {
      header("location: PersonnelHome.php");
    }
    ?>

    <div class="content-wrapper">

      <?php

// per user
      if (isset($_POST['Ok'])) {
        $_POST['fname'] = "To: ";
        $_SESSION['idSent'] = $_POST['id'];
        $ctr = 0;
        $limit =  count($_POST['id']) - 1;
        unset($_SESSION['idSent2']);

        foreach ($_POST['id'] as $id) :
          $sq = mysqli_query($conn, "SELECT userID, fullname, mobile FROM tbl_parentuser
                                where usertype = 'P' AND userID ='" . $id . "' AND schoolYearID = '" . $schoolYearID . "' ");
          $srow = mysqli_fetch_array($sq);
          $_POST['Uid'] = $srow['userID'];
          if ($ctr < $limit) {
            $_POST['fname'] .= $srow['fullname'] . ',  ';
          } else {
            $_POST['fname'] .= $srow['fullname'];
          }
          $ctr++;
        endforeach;
      }


// Per Section
      if (isset($_POST['Oku'])) {
        $_POST['fname'] = "To: ";
        $ctr = 1;
        $limit =  count($_POST['pid']) ;
        $allID="(";

        foreach ($_POST['pid'] as $id) {
          if ($limit==$ctr) {
           $allID .="'".$id."')";
          }
          else{
            $allID .="'".$id."',";
          }
          $sq = mysqli_query($conn, "SELECT * FROM tbl_sections WHERE sectionID = ".$id);
          $srow = mysqli_fetch_array($sq);
          if ($ctr < $limit) {
            $_POST['fname'] .= $srow['sectionYearLevel']."-".$srow['sectionName'] . ',  ';
          } else {
            $_POST['fname'] .= $srow['sectionYearLevel']."-".$srow['sectionName'];
          }

          $ctr++;
        }

        $_SESSION['idSent2'] =$allID;

        unset($_SESSION['idSent']);

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

                  <form name="myform" action="" method="post">
                    <div class="col-mb-3">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-5">
                            <textarea readonly list="user" name="compose-to" id="composeTo" type="text" class="form-control" placeholder="To:" required><?php echo isset($_POST['fname']) ? $_POST['fname'] : '' ?></textarea>
                          </div>
                          <button type="button" id="contact" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                            <span class="fa fa-address-book">&nbsp&nbsp</span>Contacts
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input hidden="true" value="<?php echo isset($_SESSION['idSent']) ? $_SESSION['idSent'] : isset($_SESSION['idSent2']) ? $_SESSION['idSent2'] : '' ?>" name="subj" id="compose-subject" type="text" class="form-control" placeholder="Subject:" required>
                    </div>

                    <div class="mb-3">
                      <textarea value="" id="textarea" name="htmlcode" class="textarea" maxlength="250" placeholder="Your Message Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required><?php if (isset($_POST['htmlcode'])) {
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
                        <button type="submit" name="sendmsg" class="btn btn-primary"><i class="far fa-envelope"></i>
                          Send</button>
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
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Contacts</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
          <li class="nav-item">
            <a onclick="hideSectionButton()" class="nav-link active tab1" id="custom-tabs-two-home-tab" data-toggle="pill" href="#parentlist" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">List of Parents</a>
          </li>
          <li class="nav-item">
            <a onclick="hideParentButton()" class="nav-link tab2" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#sectionlist" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">List of Section</a>
          </li>
        </ul>

        <script type="text/javascript">
          $("#custom-tabs-two-profile-tab").click(function() {
            $("#Up").show();
            $("#Ok").hide();
          });

          $("#custom-tabs-two-home-tab").click(function() {
            $("#Ok").show();
            $("#Up").hide();

          });
        </script>

        <div class="col-lg-12">
          <div class="modal-body" id="body">
            <div class="tab-content">
              <div class="tab-pane active" id="parentlist" aria-labelledby="custom-tabs-two-home-tab">
                <form action="" method="POST">
                  <table id="example1" class="table table-borderless table-striped table-layout: fixed">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Parent Name</th>
                        <th>Student Name</th>
                        <th>Mobile</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // $query = "SELECT userID, fullname, mobile FROM tbl_parentuser
                      // where usertype = 'P' AND schoolYearID = '" . $schoolYearID . "' order by fullname";

                      $query = "SELECT a.userID, a.fullname, a.mobile,
                      b.userID, b.firstName, b.middleName, b.lastName, b.suffix
                      FROM tbl_parentuser a
                      left join tbl_student b ON b.userID = a.userID
                      WHERE a.usertype = 'P' AND a.schoolYearID = '" . $schoolYearID . "' order by a.fullname";
                      $result = mysqli_query($conn, $query);


                      if ($result) {
                        $adduid = array();
                        $addpname = array();
                        $addstudfname = array();

                        if (mysqli_num_rows($result) > 0) {
                          // $ctr = '0';
                          while ($row = mysqli_fetch_array($result)) {
                            $uID = $row[0];
                            $fullname = $row[1];
                            $mobile = $row[2];
                            $suId = $row[3];
                            $fname = $row[4];
                            $mname = $row[5];
                            $lname  = $row[6];
                            $suff = $row[7];

                            // if (in_array($row[0],  $adduid)) {
                            // } else {
                            //   $adduid[] = $row[0];

                            //   if ($uID == $row[0]) {
                            //     if (in_array($row[1],  $addpname)) {
                            //     } else {

                            //       $addstudfname[] = $row[4];

                      ?>
                            <tr>
                              <td><input id="member_select" class="get_value" rName="<?php echo $fullname ?>" type="checkbox" name="id[]" value="<?php echo $uID  . ''  ?>"></td>
                              <td><?php echo $fullname . ' ' ?></td>
                              <td><?php echo $fname . ' ' ?> <?php echo $mname . ' ' ?> <?php echo $lname . ' ' ?></td>
                              <td><?php echo $mobile . ' ' ?></td>
                            </tr>

                      <?php

                          }
                        }
                      }
                      // }
                      //    }
                      //  }




                      ?>
                    </tbody>
                  </table>
                  <div class="modal-footer justify-content-between">
                    <!-- <button id="close" type="button" class="btn btn-default" name="close" data-dismiss="modal">Close</button> -->
                    <!-- <button id="Ok" type="submit" class="btn btn-primary" name="Ok" value="true">Ok</button> -->
                  </div>
                  <!-- </form> -->
              </div>

              <div class="tab-pane" id="sectionlist" aria-labelledby="custom-tabs-two-profile-tab">
              <form id="formTwo" action="" method="POST">
              <table id="example2" class="table table-borderless table-striped table-layout: fixed">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Sections</th>
                      <th hidden="true">Mobile</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "select * from tbl_sections";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                      if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                          $secname = $row[2];
                          $secid = $row[0];
                          $secyr = $row[3];

                          ?>
                                                          <tr>
                                  <td><input id="member_select" class="get_value" rName="<?php echo $secname ?>" type="checkbox" name="pid[]" value="<?php echo $secid . ' ' ?>"></td>
                                  <td><?php echo $secyr . ' ' ?> - <?php echo $secname . ' ' ?></td>

                                </tr>
                          <?php


                      }
                    }
                  }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer justify-content-between">
                <button id="close1" type="button" class="btn btn-default" name="close" data-dismiss="modal">Close</button>
                <button id="Ok" type="submit" class="btn btn-primary" name="Ok" value="true">Ok</button>
                <button id="Oku" type="submit" class="btn btn-primary" name="Oku" >Ok</button>

              </div>
              </form>
            </div>
            </div>
        </div>
          </div>
        </div>
      </div>


      <?php require '../maintenanceChecker.php';

      ?>
</body>



<?php


require 'assets/scripts.php';

if (isset($_POST['sendmsg'])) {

  echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
  $_POST['subj'] = mysqli_real_escape_string($conn, stripcslashes($_POST['subj']));
  $_POST['htmlcode'] = mysqli_real_escape_string($conn, stripcslashes($_POST['htmlcode']));
  $htmlcode = htmlentities(htmlspecialchars($_POST['htmlcode']));

  $date = date('Y-m-d H:i:s');
  $no   = "0";
  $ctr  = 0;
  $one  = "one";

  if (isset($_SESSION['idSent'])) {

    foreach ($_SESSION['idSent'] as $rid) {

      $insertQuery = "Insert into tbl_Message
        (
        SenderUser_Id , ReceiverUserId, AdminReplyTag, MessageBody, PostedDateTime, ReadTag, schoolYearID)
        VALUES
        (
        '" . $user_check . "','" . $rid . "','" . $no . "','" .  $htmlcode . "','" . $date . "', '" . $no . "','" . $schoolYearID . "')";

      mysqli_query($conn, $insertQuery);

      $checkRecord1 = mysqli_query($conn, "SELECT fullName FROM tbl_parentuser WHERE userID  = '" .  $rid  . "' ");
      $result1 = mysqli_fetch_array($checkRecord1);
      $nameReceiver = $result1['fullName'];

      $date = date('Y-m-d H:i:s');
      $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Sends a message to ' '" . $nameReceiver . "', '$date','" . $schoolYearID . "')";

      mysqli_query($conn, $insertauditQuery);

      $checkRecord = mysqli_query($conn, "SELECT Message_Id FROM tbl_Message where SenderUser_Id ='" . $user_check . "' AND schoolYearID = '" . $schoolYearID . "' Order by Message_Id desc");
      $result = mysqli_fetch_assoc($checkRecord);
      $msgId = $result['Message_Id'];


      $insertQuery3 = "Insert into tbl_MessageThread
        (
        Subject_Id , Message_Id, SenderUser_Id, ReceiverUser_Id)
        VALUES
        (
        '" . $rid . "','" . $msgId  . "','" . $user_check . "','" .  $rid . "')";

    mysqli_query($conn, $insertQuery3);

    unset($_SESSION['idSent']);

    header('Location: compose.php?composeCreated');

    }
  }

  else if (isset($_SESSION['idSent2'])) {

    $sql = "SELECT userID FROM tbl_student WHERE sectionID IN ".$_SESSION['idSent2'];
    $result1= mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result1)) {
      $owlID[]= $row['userID'];
      }

    foreach ($owlID as $rid) {

      $insertQuery = "Insert into tbl_Message
      (
      SenderUser_Id , ReceiverUserId, AdminReplyTag, MessageBody, PostedDateTime, ReadTag, schoolYearID)
      VALUES
      (
      '" . $user_check . "','" . $rid . "','" . $no . "','" .  $htmlcode . "','" . $date . "', '" . $no . "','" . $schoolYearID . "')";

      mysqli_query($conn, $insertQuery);

      $checkRecord1 = mysqli_query($conn, "SELECT fullName FROM tbl_parentuser WHERE userID  = '" .  $rid  . "' ");
      $result1 = mysqli_fetch_array($checkRecord1);
      $nameReceiver = $result1['fullName'];

      $date = date('Y-m-d H:i:s');
      $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Sends a message to ' '" . $nameReceiver . "', '$date','" . $schoolYearID . "')";

      mysqli_query($conn, $insertauditQuery);

      $checkRecord = mysqli_query($conn, "SELECT Message_Id FROM tbl_Message where SenderUser_Id ='" . $user_check . "' AND schoolYearID = '" . $schoolYearID . "' Order by Message_Id desc");
      $result = mysqli_fetch_assoc($checkRecord);
      $msgId = $result['Message_Id'];

      $insertQuery3 = "Insert into tbl_MessageThread
        (
        Subject_Id , Message_Id, SenderUser_Id, ReceiverUser_Id)
        VALUES
        (
        '" . $rid . "','" . $msgId  . "','" . $user_check . "','" .  $rid . "')";

        mysqli_query($conn, $insertQuery3);


    unset($_SESSION['idSent2']);

    header('Location: compose.php?composeCreated');
    }
  }

}

if (isset($_REQUEST['composeCreated'])) {
  displayMessage("success", "Message has been sent", " ");
}

?>

<!-- Summernote -->
<!-- <script src="../include/plugins/summernote/summernote-bs4.min.js"></script> -->
<!-- Select2 -->
<script src="../include/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../include/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../include/plugins/moment/moment.min.js"></script>
<!-- <script src="../include/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script> -->
<!-- date-range-picker -->
<script src="../include/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../include/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../include/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../include/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="../include/plugins/datatables/jquery.dataTables.js"></script>

<script src="../include/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<!-- FastClick -->
<script src="../include/plugins/fastclick/fastclick.js"></script>

<script>
  $(document).ready(function() {
    $("#Oku").hide();
  });

  $(document).ready(function() {
    $('#example1').DataTable({
      // "scrollX": true,
      // "order": [],
      "paging": false,
      "info": false,
      "sort": false,
      "scrollY": "40vh",
      "scrollCollapse": true,

    });
  });

  // $(document).ready(function() {
  //   $('.tab1').click(function() {
  //     $('#Up').hide();
  //     $('#Ok').show();
  //   });
  //   $('.tab2').click(function() {
  //     $('#Ok').hide();
  //     $('#Up').show();
  //   });
  // });

  $(document).ready(function() {
    $('#example2').DataTable({
      // "scrollX": true,
      // "order": [],
      "paging": false,
      "info": false,
      "sort": false,
      "scrollY": "40vh",
      "scrollCollapse": true,

    });
  });


  $('#modal-default').on('shown.bs.modal', function(e) {
    $.fn.dataTable.tables({
      visible: true,
      api: true
    }).columns.adjust();
  });
  $(document).ready(function() {
    $('#modal-default').on('hide.bs.modal', function() {
      $('.get_value').prop('checked', false);
    })
  });

function hideSectionButton() {
  $("#Oku").hide();
  $("#Ok").show();
}

function hideParentButton() {
  $("#Ok").hide();
  $("#Oku").show();
}

  // function myFunction() {
  //   var input, filter, table, tr, td, i;
  //   input = document.getElementById("myInput");
  //   filter = input.value.toUpperCase();
  //   table = document.getElementById("example1");
  //   tr = table.getElementsByTagName("tr");
  //   for (i = 0; i < tr.length; i++) {
  //     td = tr[i].getElementsByTagName("td")[0];
  //     if (td) {
  //       if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
  //         tr[i].style.display = "";
  //       } else {
  //         tr[i].style.display = "none";
  //       }
  //     }
  //   }
  // }
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


  // var addName = function() {
  //   var n = $("input:checked").attr("rName");
  //   $('#composeTo').val($('#composeTo').val() + ' ' + n);
  // };
  // $("input[type=checkbox]").on("click", addName);







  // $(document).ready(function() {
  //   $('#compose-to').keyup(function() {
  //     var query = $(this).val();
  //     if (query != '') {
  //       $.ajax({
  //         url: "../include/check_user.php",
  //         method: "POST",
  //         data: {
  //           query: query
  //         },
  //         success: function(data) {
  //           $('#user').fadeIn();
  //           $('#user').html(data);

  //         }
  //       });
  //     } else {
  //       $('#user').fadeOut();
  //     }
  //   });

  //   $(document).on('click', 'li', function() {
  //     $('#compose-to').val($(this).text());
  //     $('#user').fadeOut();

  //   });
  // });

  // function checkbox() {
  //   var checkboxes = document.getElementsByName('member_select[]');
  //   var checkboxesChecked = [];

  //   for (var i = 0; i < checkboxes.length; i++) {
  //     if (checkboxes[i].checked) {

  //       checkboxesChecked.push(checkboxes[i].value);

  //     }
  //   }
  //   document.getElementById("compose-subject").value = checkboxesChecked;
  // }


  // $(document).ready(function() {
  //   $('.get_value').click(function() {
  //     $('.get_value').not(this).prop('checked', false);
  //   });
  // });




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