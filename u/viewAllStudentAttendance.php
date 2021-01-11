<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
$page = "viewAllStudentAttendance";
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
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
  header("location: ../login.php");
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
  <title>Student Attendance | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

  <!-- customize css -->
  <link rel="stylesheet" type="text/css" href="assets/css/hideAndNext.css">
  <link rel="stylesheet" type="text/css" href="assets/css/css-navAndSlide.css">
  <!-- sweet alert -->
  <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">

  <link rel="stylesheet" href="../include/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" type="text/css" href="assets/css/css-studentinfo.css">


  <!-- daterange picker -->
  <link rel="stylesheet" href="../include/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../include/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../include/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" type="text/css" href="../include/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../include/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../include/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

<style>
.iconsize {
  width: 32px; 
  height: 32px;
}
</style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper">

    <!-- nav bar & side bar -->
    <?php
    require 'includes/navAndSide.php';
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Student Attendance</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Student Attendance</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
      <form method="POST">
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <p>
              <a href="?" type="button" class="btn btn-success add-button buttonDelete ">
                <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
              </a>&nbsp&nbsp
            </p>
           </div>
          
          <!-- /.card-header -->
          <div class="card-body" style="width: 100%;">
            <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>
                  <th>Student Code</th>
                  <th>Name</th>
                  <th>Date and Time</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT b.lastName,b.firstName,b.middleName,a.TimePunch,a.Mode,b.studentCode 
                FROM tbl_Attendance AS a, tbl_student AS b WHERE b.studentCode=a.StudentId AND a.isStudent = '1' AND a.schoolYearID = '" . $schoolYearID . "' ORDER BY a.TimePunch DESC";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) { ?>
                  <!--open of while  -->
                  <tr>
                    <td class="text-center">
                      <h4><span style="font-weight:normal;" class="badge">
                          <?php echo $row["studentCode"]; ?>
                        </span></h4>
                    </td>
                    <td class="text-center">
                      <h4><span style="font-weight:normal;" class="badge">
                          <?php echo $row["lastName"];
                          echo ','; ?>
                          <?php echo $row["firstName"];
                          echo ' '; ?>
                          <?php echo $row["middleName"]; ?>
                        </span></h4>
                    </td>
                    <td class="text-center">
                      <h4><span style="font-weight:normal;" class="badge"><?php echo date_format(date_create($row["TimePunch"]), "M d, Y h:i A"); ?></span></h4>
                    </td>
                    <?php if ('1' == $row[4]) {
                      echo '<td class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-success">TIME IN</span></h4></td>';
                    } elseif ('2' == $row[4]) {
                      echo '<td class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-danger">TIME OUT</span></h4></td>';
                    } ?>
                  </tr>
                <?php }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
              </form>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>

    <script src="includes/sessionChecker.js"></script>
    <script type="text/javascript">
      extendSession();
      var isPosted;
      var isDisplayed = false;
      setInterval(function() {
        sessionChecker();
      }, 20000); //time in milliseconds 
    </script>
    <!-- ./wrapper -->

    <?php

    require 'assets/scripts.php';





    ?>
    <!-- customize scripts -->
    <script src="../include/plugins/datatables/jquery.dataTables.js"></script>

    <script src="../include/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" type="text/css" href="../include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">


<?php require '../maintenanceChecker.php';
  ?>
</body>
<script type="text/javascript">
  // validations

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

  //Initialize Select2 Elements
  $('.select2bs4').select2()

  //Datemask2 mm/dd/yyyy
  $('#datemask2').inputmask('mm/dd/yyyy', {
    'placeholder': 'mm/dd/yyyy'
  })

  $('[data-mask]').inputmask()

</script>
<script type="text/javascript" src="assets/scripts/hideAndNext.js"></script>
<!-- FastClick -->
<script src="../include/plugins/fastclick/fastclick.js"></script>
<script>
  $("#siblings-order").keyup(function() {

    var orderBirth = $("#siblings-order").val();
    if (orderBirth == 1) {
      $('#checkboxPrimary1').prop('checked', true);

    } else {
      $('#checkboxPrimary1').prop('checked', false);

    }

  });
  $(document).ready(function() {
    $('#example1').DataTable({
      "scrollX": true,
      "order": [],
    });
  });

  $(document).ready(function() {
    $('.yearselect').select2();
  });
   
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
  $(".numberOnly2").inputFilter(function(value) {
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

</html>
<?php
if (isset($_REQUEST['update'])) {
  $message = "";
  displayMessage("success", "Success", $message);
}
?>