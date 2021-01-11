<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../assets/phpfunctions.php';
$page = "addPersonnel";

session_start();
$userID = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userMname = $_SESSION['middle-name'];
$userLname = $_SESSION['last-name'];
$userLvl = $_SESSION['usertype'];
$userEmail = $_SESSION['userEmail'];

$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
if (!isset($user_check) && !isset($password_check)) {
  session_destroy();
  header("location: ../index.php");
} else if ($levelCheck == 'P') {
  header("location: home.php");
} else if ($levelCheck == 'E') {
  header("location: PersonnelHome.php");
}
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Appointment | ParentPortal</title>
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
    require 'includes/navAndSide.php';
    ?>
    <!-- nav bar & side bar -->
    <div class="content-wrapper ">


      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Add Personnel</li>
                <li class="breadcrumb-item"><a href="viewAllPersonnel.php">View All Personnel</a></li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Content Wrapper. Contains page content -->

      <div class="container-fluid ">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <div class="card-title" style="font-size: 30px;">
                    Add Personnel
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
                  <form method="post">

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Code</label>
                          <input value="<?php echo isset($_POST['code']) ? $_POST['code'] : '' ?>" name="code" oninput="lenValidation('code','20')" id="code" type="text" class="form-control" placeholder="" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">First Name</label>
                          <input value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : '' ?>" name="fname" id="fname" type="text" class="form-control textOnly" oninput="lenValidation('fname','60')" placeholder="" required>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Middle Name</label>
                          <input value="<?php echo isset($_POST['mname']) ? $_POST['mname'] : '' ?>" name="mname" id="mname" type="text" class="form-control textOnly" oninput="lenValidation('mname','60')" placeholder="">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Last Name</label>
                          <input value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : '' ?>" name="lname" id="lname" type="text" class="form-control textOnly" oninput="lenValidation('lname','60')" placeholder="" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Position</label>
                          <input value="<?php echo isset($_POST['position']) ? $_POST['position'] : '' ?>" name="position" id="position" type="text" class="form-control" oninput="lenValidation('position','50')" placeholder="" required>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Contact Number</label>
                          <input value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : '' ?>" name="mobile" id="mobile" type="number" class="form-control" oninput="lenValidation('mobile','11')" placeholder="" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Email</label>
                          <input value="<?php echo isset($_POST['Email']) ? $_POST['Email'] : '' ?>" name="Email" id="Email" type="text" class="form-control" oninput="lenValidation('Email','50')" placeholder="" required>
                        </div>
                      </div>

                      <div class="col-lg-4" hidden>
                        <div class="form-group">
                          <label class="unrequired-field">Have Access?</label>
                          <input <?php if (isset($_POST['b'])) echo "value='y'"; ?> name="paccess" id="paccess" type="checkbox" class="form-control" checked>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right" name="gothis">Create</button>
                  </form>

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

      $_POST['fname'] = mysqli_real_escape_string($conn, stripcslashes($_POST['fname']));
      $_POST['mname'] = mysqli_real_escape_string($conn, stripcslashes($_POST['mname']));

      $_POST['lname'] = mysqli_real_escape_string($conn, stripcslashes($_POST['lname']));
      $_POST['position'] = mysqli_real_escape_string($conn, stripcslashes($_POST['position']));

      $datenow = date("Y-m-d");

      if (strlen($_POST['mobile']) > 11) {
        displayMessage("warning", "Invalid Mobile Number", "Please try again ");
      }
      if (empty($_POST["paccess"])) {

        $sql = "select a.* from tbl_Personnel as a where Personnel_code='" . $_POST['code'] . "'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

          displayMessage("warning", "Code is already registered", "Invalid Entry");
        } else {

          $sql = "select a.* from tbl_Personnel as a where Mobile='" . $_POST['mobile'] . "'";

          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {

            displayMessage("warning", "Mobile Number is already registered", "Invalid Entry");
          } else {

            if (strlen($_POST['mobile']) < 10 || strlen($_POST['mobile']) > 12) {
              displayMessage("warning", "Invalid Mobile Number", "Please try again ");
            } else {
              $insertQuery = "Insert into tbl_Personnel
      (
      Personnel_Code,
      Position,
      Fname,
      Mname,
      Lname,
      Mobile,
      status,
      PostedUserID,
      PostedDateTime
      )
      VALUES
      (
        '" . $_POST['code'] . "',
        '" . $_POST['position'] . "',
        '" . $_POST['fname'] . "',
        '" . $_POST['mname'] . "',
      '" . $_POST['lname'] . "',
      '" . $_POST['mobile'] . "',
      'Active',
      $userID,
      now()
      )";
              mysqli_query($conn, $insertQuery);
              header('Location: addPersonnel.php?PersonnelCreated');
            }
          }
        }
      } else {
        $sql = "select a.* from tbl_Personnel as a where Personnel_code='" . $_POST['code'] . "'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

          displayMessage("warning", "Code is already registered", "Invalid Entry");
        } else {

          $sql = "select a.* from tbl_Personnel as a where Mobile='" . $_POST['mobile'] . "'";

          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {

            displayMessage("warning", "Mobile Number is already registered", "Invalid Entry");
          } else {

            if (strlen($_POST['mobile']) < 10 || strlen($_POST['mobile']) > 12) {
              displayMessage("warning", "Invalid Mobile Number", "Please try again ");
            } else {
              $insertQuery = "Insert into tbl_Personnel
      (
      Personnel_Code,
      Position,
      Fname,
      Mname,
      Lname,
      Mobile,
      status,
      PostedUserID,
      PostedDateTime
      )
      VALUES
      (
        '" . $_POST['code'] . "',
        '" . $_POST['position'] . "',
        '" . $_POST['fname'] . "',
        '" . $_POST['mname'] . "',
      '" . $_POST['lname'] . "',
      '" . $_POST['mobile'] . "',
      'Active',
      $userID,
      now()
      )";
              mysqli_query($conn, $insertQuery);


              $sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_Code = '" . $_POST['code'] . "' AND a.Fname = '" . $_POST['fname'] . "' ORDER BY a.Personnel_Id DESC ";

              $result = mysqli_query($conn, $sql);
              $pass_row = mysqli_fetch_assoc($result);
              $personnelId = $pass_row['Personnel_Id'];
              $hashedPassword = password_hash($_POST['code'], PASSWORD_DEFAULT);

              $insertQuery3 = "Insert into tbl_parentuser
        (
        pID,
        fname,
        mname,
        lname,
        mobile,
        password,
        isEnabled,
        usertype,
        designation,
        email
        )
        VALUES
        (
        '" . $personnelId . "',
        '" . $_POST['fname'] . "',
        '" . $_POST['mname'] . "',
        '" . $_POST['lname'] . "',
        '" . $_POST['mobile'] . "',
        '" . $hashedPassword . "',
        '1',
        'E',
        '" . $_POST['position'] . "',
        '" . $_POST['Email'] . "'
        )";

              $date = date('Y-m-d H:i:s');
              $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Has added a personnel name: ' '" . $_POST['fname'] . " ' ' " . $_POST['mname'] . " ' ' " . $_POST['lname'] . " ', '$date')";
              mysqli_query($conn, $insertauditQuery);

              mysqli_query($conn, $insertQuery3);
              header('Location: addPersonnel.php?PersonnelCreated');
            }
          }
        }
      }
    }
    if (isset($_REQUEST['PersonnelCreated'])) {
      displayMessage("success", "Success", "Personnel has been made");
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
      $(function() {

        $('.textarea').summernote({
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']],
          ],
          disableDragAndDrop: true

        });
      })

      (function($) {
        $.fn.inputFilter = function(inputFilter) {
          return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
              this.oldValue = this.value;
              this.oldSelectionStart = this.selectionStart;
              this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
              this.value = this.oldValue;
              this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
              this.value = "";
            }
          });
        };
      }(jQuery));

      // Install input filters.
      $(".interger").inputFilter(function(value) {
        return /^-?\d*$/.test(value);
      });
      $(".numberOnly").inputFilter(function(value) {
        return /^\d*$/.test(value);
      });
      $("#intLimitTextBox").inputFilter(function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500);
      });
      $(".decimal").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
      });
      $("#currencyTextBox").inputFilter(function(value) {
        return /^-?\d*[.,]?\d{0,2}$/.test(value);
      });
      $(".textOnly").inputFilter(function(value) {
        return /^[a-z-' ']*$/i.test(value);
      });
      $(".textOnly2").inputFilter(function(value) {
        return /^[a-z-' '-\.]*$/i.test(value);
      });
      $("#hexTextBox").inputFilter(function(value) {
        return /^[0-9a-f]*$/i.test(value);
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

      function lenValidation(id, limit) {
        if ($("#" + id).val().length >= limit) {
          $("#" + id).val($("#" + id).val().substr(0, limit));
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
      }
    </script>
    <?php require '../maintenanceChecker.php';
  ?>
</body>

</html>