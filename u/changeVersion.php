<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
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
//
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

$sql = "sELECT * FROM version";
$result1 = mysqli_query($conn, $sql);
$ctr = 0;
if (mysqli_num_rows($result1) > 0) {
  $row = mysqli_fetch_array($result1);
  $version = $row[0];
  $build = $row[1];
}

?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Change Version | Parent Portal</title>
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
              <h1>Change Version</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Change Version</li>
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
              <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                          border: 2px solid gray;text-align: center">
                <div class="row mb-2">
                  <!-- old password-->
                  
                  <div class="col-lg-4">
                    <label class="unrequired-field">Version:</label><br>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-group">
                      <input value="<?php echo $version ?>" name="VerNum" id="VerNum" maxlength="50" type="text" class="form-control" required>
                    </div>
                  </div>
                </div>
                <!-- old password-->
                <br>
                <div class="row mb-2">
                  <!-- new password-->
                  
                  <div class="col-lg-4">
                    <label class="unrequired-field">Build Number:</label><br>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-group">
                      <input value="<?php echo $build ?>" name="BuildNum" id="BuildNum" maxlength="50" type="text" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-lg-1">
                  </div>
                </div>
                <div class="row mb-2">
                  <!--Update button-->
                  <div class="col-lg-6">
                  </div>
                  
                  <div class="col-lg-4">
                    <button style="width:100px;" type="submit" name="btn-submit" class="btn btn-primary add-button">
                      Update
                    </button>
                  </div>
                </div> <!-- Update button -->

              </div>
            </div>
            <div class="col-lg-3">
            </div>

          </div>
        </form>
      </section>


    </div>
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
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

</html>

<script type="text/javascript">
  function cleartext() {
    document.getElementById('oldpassword').value = '';
    document.getElementById('newpassword').value = '';
    document.getElementById('confirmpassword').value = '';
  };
</script>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
  extendSession();
  var isPosted;
  var isDisplayed = false;
  setInterval(function() {
    sessionChecker();
  }, 20000); //time in milliseconds


  $("#oldpassword").on('input', function() {
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

  $("#newpassword").on('input', function() {
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

  $("#confirmpassword").on('input', function() {
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


<?php
if (isset($_POST["btn-submit"])) {

  $datenow = date("Y-m-d H:i:s");

  $insertQuery = "update version
  set
  Version = '" . $_POST['VerNum'] . "',
  BuildNo = '" . $_POST['BuildNum'] . "',
  PostedDateTime ='".$datenow."'
  
  ";
      mysqli_query($conn, $insertQuery);

      echo $insertQuery;
      $message = "Version Changed";
      $title = "Success";
      $type = "success";
      header('Location: changeVersion.php?title=' . $title . '&type=' . $type . '&message=' . $message);
   
}

?>