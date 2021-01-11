<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php

$page = "adminchangedetails";

require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
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

$sql = "sELECT  designation,password  FROM tbl_parentuser where userid = '" . $user_check . "' LIMIT 1";
$result1 = mysqli_query($conn, $sql);
$ctr = 0;
if (mysqli_num_rows($result1) > 0) {
  $row = mysqli_fetch_array($result1);
  $designation = $row[0];
  $userPass = $row[1];
}
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Admin Account Information| Parent Portal</title>
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
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper">

    <!-- nav bar & side bar -->
    <?php
    require 'includes/navAndSide.php';
    ?>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Account Information</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Account Information</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


      <div class="container">
        <div class="card card-primary card-outline">
          <div class="card-body">
            <h3 class=""><?php echo "Edit Information" ?></h3>
            <form action="" method="post">
              <br>
              <div class="row">
                <div class="col-lg-5">
                  <div class="form-group">
                    <input value="<?php echo $_SESSION['first-name']  ?>" name="first-name" required type="text" class="form-control textOnly" maxlength="60" placeholder="First Name" id="firstname">
                  </div>
                </div>

                <div class="col-lg-5">
                  <div class="form-group">
                    <input value="<?php echo $_SESSION['last-name'] ?>" name="last-name" required type="text" class="form-control textOnly" maxlength="60" placeholder="Last Name" id="lastname">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-10">
                  <div class="form-group">
                    <input value="<?php echo $designation ?>" name="designation" required type="text" class="form-control textOnly" maxlength="180" placeholder="Designation" id="designation">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                      </div>
                      <input name="pass1" type="password" class="input form-control" required="true" maxlength="50" placeholder="Enter current password" id="ecp">
                    </div>
                  </div>
                </div>
              </div>








          </div>
          <div class="card-footer"> <button class="btn btn-primary" name="editThis" value="editThis" type="submit">Save</button> </form>
          </div>
        </div><!-- /.card -->

      </div>

    </div>
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
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

</html>

<script type="text/javascript">
  Swal.Fire("asd")
</script>



<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
  extendSession();
  var isPosted;
  var isDisplayed = false;
  setInterval(function() {
    sessionChecker();
  }, 20000); //time in milliseconds


  $("#firstname").on('input', function() {
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
  $("#lastname").on('input', function() {
    if ($(this).val().length >= 60) {
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
  $("#ecp").on('input', function() {
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
  $("#designation").on('input', function() {
    if ($(this).val().length >= 180) {
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


<?php

if (isset($_POST['editThis'])) {
  $chkpass = password_verify($_POST['pass1'], $userPass);
  if (!$chkpass) {
    $message = "Incorrect Password";
    $title = "Invalid Entry";
    $type = "error";
    header('Location: adminSetting.php?title=' . $title . '&type=' . $type . '&message=' . $message);
  } else {


    $_POST['first-name']   = mysqli_real_escape_string($conn, stripcslashes($_POST['first-name']));
    $_POST['last-name']    = mysqli_real_escape_string($conn, stripcslashes($_POST['last-name']));
    $_POST['designation']        = mysqli_real_escape_string($conn, stripcslashes($_POST['designation']));


    $Fname = $_POST['first-name'];
    $Lname = $_POST['last-name'];
    
    $insertQuery = "update tbl_parentuser
set
fname = '" . $_POST['first-name'] . "',
lname = '" . $_POST['last-name'] . "',
designation = '" . $_POST['designation'] . "',
fullName = CONCAT('$Fname',' ','$Lname')
where userID ='" . $user_check . "'

";

    $_SESSION['first-name'] =  $_POST['first-name'];
    $_SESSION['last-name'] =  $_POST['last-name'];
    $_SESSION['designation']     = $_POST['designation'];

    mysqli_query($conn, $insertQuery);

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Changes account information of user  ' '" . $_SESSION['first-name'] . " ' '" . $_SESSION['last-name'] . " ' 'with designation of ' ' " . $_SESSION['designation'] . "', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    $message = "Information Changed";
    $title = "Success";
    $type = "success";
    header('Location: adminSetting.php?title=' . $title . '&type=' . $type . '&message=' . $message);
  }
}

if (isset($_GET['message'])) {
  displayMessage($_GET['type'], $_GET['title'], $_GET['message']);
}
?>