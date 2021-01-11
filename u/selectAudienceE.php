<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../assets/phpfunctions.php';
$page = "AddAnnouncement";


// $_SESSION['userID']
// $_SESSION['first-name']
// $_SESSION['middle-name']
// $_SESSION['last-name']
// $_SESSION['usertype']
// $_SESSION['userEmail']
// $_SESSION['schoolID']
// $_SESSION['userType']


session_start();
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



// $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Announcement | Parent Portal</title>
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
  <!-- Bootstrap4 Duallistbox -->
<script src="../include/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>




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
    require 'includes/navAndSide.php';
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">
<br>

      <div class="container-fluid ">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <div class="card-title" style="font-size: 30px;">
                    Select Announcement Audience
                    <small></small>
                  </div>
                  <!-- tools box -->
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body pad">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <form method="post" action="publishA.php">

                  <select class="duallistbox" name="audi[]" multiple="multiple">
                  <?php
                  $sql = "select * from tbl_sections order by sectionYearLevel";
                  $result1 = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_array($result1)) {
                      echo '<option value = "'.$row[0].'">'.$row[3].' - '.$row[2]. '</option>';
                    }
                  }
                  ?>
                  </select>
                </div>
                <!-- /.form-group -->
                            <div class="modal-footer justify-content-between">
              <button type="button" style="visibility: hidden;" class="btn btn-default" data-dismiss="modal"></button>
              <button type="Submit" class="btn btn-primary" name="audSelect">Continue</button>
                  </form>

            </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>


                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>
          <!-- ./row -->
        </section>
        <!-- /.content -->

      </div>

    </div>
    <!-- /.content-wrapper -->


    <?php

    require 'assets/scripts.php';



    if (isset($_POST['gothis'])) {
      echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
      $_POST['title'] = mysqli_real_escape_string($conn, stripcslashes($_POST['title']));
      $_POST['startdate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['startdate']));
      $_POST['enddate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['enddate']));
      $newDateStart = date('Y-m-d', strtotime($_POST['startdate']));
      $newDateEnd = date('Y-m-d', strtotime($_POST['enddate']));
      $_POST['subtitle'] = mysqli_real_escape_string($conn, stripcslashes($_POST['subtitle']));
      $_POST['htmlcode'] = mysqli_real_escape_string($conn, stripcslashes($_POST['htmlcode']));
      $htmlcode = htmlentities(htmlspecialchars($_POST['htmlcode']));
      // $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
      //echo html_entity_decode(htmlspecialchars_decode($htmlcode));
      if (strlen(trim($_POST['startdate'])) < 3) {
        displayMessage("warning", "Range Date Invalid", "Please try again");
      } else {
        $answer = $_POST['type'];
        if ($answer == "OnTop") {
          $radio = "1";
        }
        if ($answer == "OnBottom") {
          $radio = "0";
        }
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
          if ($fileError == 0) {
            if ($fileSize < 5000000) {
              $fileNameNew = uniqid('', true) . "." . $fileActualExt;
              $fileDestination = 'uploads/' . $fileNameNew;
              move_uploaded_file($fileTmpName, $fileDestination);
              header("location: publishA.php?uploadsuccess");
            } else {
              displayMessage("Warning", "Warning", "Your file is too big!");
            }
          } else {
            displayMessage("Warning", "Warning", "There was an error uploading your file!");
          }
        } else {
          displayMessage("Warning", "Warning", "You cannot upload files of this type!");
        }
        $insertQuery = "Insert into tbl_announcement
 (
 title,
 subtitle,
 htmlcode,
 dateCreated,
 dateEnd,
 dateStart,
 userID,
 image,
 isOnTop,
 schoolYearId
 )
 VALUES
 (
  '" . $_POST['title'] . "',
  '" . $_POST['subtitle'] . "',
  '" . $htmlcode . "',
  now(),
  '" . $newDateEnd . "',
  '" . $newDateStart . "',
  '" . $_SESSION['userID']  . "',
  '" . $fileNameNew  . "',
  '" . $radio . "',
  '" . $schoolYearId . "'




 )";
        mysqli_query($conn, $insertQuery);
        //Insert Audit Trail
        $date = date('Y-m-d H:i:s');
        $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Has created an Announcement Entitled: ' '" . $_POST['title'] . "', '$date')";
        mysqli_query($conn, $insertauditQuery);
        header('Location: publishA.php?AnnouncementCreated');
      }
    }
    if (isset($_REQUEST['AnnouncementCreated'])) {
      displayMessage("success", "Success", "Announcement has been created.");
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




      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Tomorrow': [moment(), moment().add(1, 'days')],
            'Next 7 Days': [moment().add(6, 'days'), moment().add(7, 'days')],
            'Next 30 Days': [moment().add(29, 'days'), moment().add(30, 'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          $('#startdate').val(start.format('MMMM D, YYYY'))
          $('#enddate').val(end.format('MMMM D, YYYY'))
        })

      $("#title").on('input', function() {
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

          //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox({
  nonSelectedListLabel: 'Not Selected',
  selectedListLabel: 'Selected',
});


    </script>
    <script src="includes/sessionChecker.js"></script>
    <script type="text/javascript">
      extendSession();
      var isPosted;
      var isDisplayed = false;
      setInterval(function() {
        sessionChecker();
      }, 1000); //time in milliseconds


    </script>
</body>

</html>