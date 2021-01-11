<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
$page = "adminchangeschoolyear";
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
session_start();

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


//   $userID = $_SESSION['userID'];
//   $userFname = $_SESSION['first-name'];
//   $userMname = $_SESSION['middle-name'];
//   $userLname = $_SESSION['last-name'];
//   $userLvl = $_SESSION['usertype'];
//   $userEmail = $_SESSION['userEmail'];


//   $user_check = $_SESSION['userID'] ;
//   $levelCheck = $_SESSION['usertype'];
//   if(!isset($user_check) && !isset($password_check))
//   {
//     session_destroy();
//     header("location: ../index.php");
//   }

if (isset($_GET['page'])) {

  $sql = "select a.*,b.* from tbl_schoolyear as a inner join tbl_settings as b on b.currentSchoolYear=a.schoolYearID";

  $result = mysqli_query($conn, $sql);
  $pass_row = mysqli_fetch_assoc($result);
  $schoolYearID3 = $pass_row['currentSchoolYear'];

  $checkRecord = mysqli_query($conn, "SELECT schoolYear FROM tbl_schoolyear where schoolYearID ='" . $schoolYearID3  . "'");
  $result = mysqli_fetch_array($checkRecord);
  $schoolyear1 = $result['schoolYear'];

  $checkRecord = mysqli_query($conn, "SELECT schoolYear FROM tbl_schoolyear where schoolYearID ='" . $_GET['page'] . "'");
  $result = mysqli_fetch_array($checkRecord);
  $schoolyear = $result['schoolYear'];

  $date = date('Y-m-d H:i:s');
  $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Changes the school year from ' '" .  $schoolyear1 . " ' 'to ' '" . $schoolyear . "', '$date','" . $schoolYearID3 . "')";
  mysqli_query($conn, $insertauditQuery);

  $schoolYearId2 = $_GET['page'];
  $queryupdatepass = " update tbl_settings set currentSchoolYear = " . $schoolYearId2;
  mysqli_query($conn, $queryupdatepass);

  $date = date('Y-m-d H:i:s');
  $insertauditQuery1 = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Changes the school year from ' '" .  $schoolyear1 . " ' 'to ' '" . $schoolyear . "', '$date','" . $schoolYearId2 . "')";
  mysqli_query($conn, $insertauditQuery1);

  displayMessage("success", "Password Changed", "Success!");
}
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>School Year Activated | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

  <!-- customize css -->
  <link rel="stylesheet" type="text/css" href="assets/css/hideAndNext.css">
  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href="assets/css/css-navAndSlide.css">
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
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper">

    <!-- nav bar & side bar -->
    <?php
    require 'includes/navAndSide.php';
    ?>

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

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Change School Year </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">School Year Activated</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <section class="content">
        <form action="" method="POST" enctype="multipart/form-data" class="noEnterOnSubmit">
          <div class="row">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-6">

              <div class="row mb-4">
                <!-- Current School year-->
                <h1> New School Year Activated!</h1>
              </div> <!-- Current School year-->
              <div class="row mb-12">
                <!-- Current School year-->
                <a class="btn btn-primary btn-sm " href="adminchangeschoolyear.php">
                  Go Back
                </a>
              </div>
            </div>
            <div class="col-lg-3">
            </div>
          </div>
        </form>
      </section>



    </div>

  </div>

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


<?php
if (isset($_POST["btn-submit"])) {
  displayMessage("warning", "New/Confirm password must not be empty " . $_POST['schoolYear'], "Please try again");
}

?>