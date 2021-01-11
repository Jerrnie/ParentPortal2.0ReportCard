<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
$page = "adminchangepass";
// require 'assets/scripts/phpfunctions.php';
require '../assets/phpfunctions.php';
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


$sql = " select *  FROM tbl_PasswordSettings LIMIT 1";
$result1 = mysqli_query($conn, $sql);
$ctr = 0;
if (mysqli_num_rows($result1) > 0) {
  $row = mysqli_fetch_array($result1);
  $hasLengthCheck       =  $row['3'];
  $minLength             =  $row['4'];
  $hasNumberCheck       =  $row['5'];
  $minNumberCount       =  $row['6']; 
  $hasSpecialCharacter  =  $row['7'];
  $minSpecialCharacter  =  $row['8'];
  $hasUpperCase         =  $row['9'];
  $minUpperCase         =  $row['10'];
}

if ($hasLengthCheck) {
  $lenCheck = " at least <b>$minLength character(s)</b>";
}
else{
 $lenCheck =' at least <b>8 character(s)</b>';
 $minLength = 8;
}
if ($hasNumberCheck) {
  $numCheck = ", at least <b>$minNumberCount digit(s)</b>";
}
else{
  $numCheck = '';
}
if ($hasSpecialCharacter) {
  $scCheck =", at least <b>$minSpecialCharacter special character(s)</b>";
}
else{
  $scCheck ="";
}
if ($hasUpperCase) {
  $ucCheck = ", at least <b>$minNumberCount upper case letter(s)</b>";
}
else{
  $ucCheck ='';
}

$passReq = "The new password must have".$lenCheck.$numCheck.$ucCheck.$scCheck;
                //The password must have at least 8 characters, at least 1 digit(s), at least 1 upper case letter(s), at least 1 special character(s)
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Admin Change password | Parent Portal</title>
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
              <h1>Change Password </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Change Password</li>
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
                  <div class="col-lg-1">
                  </div>
                  <div class="col-lg-4">
                    <label class="unrequired-field">Current Password:</label><br>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-group">
                      <input value="<?php echo isset($_POST['oldpassword']) ? $_POST['oldpassword'] : '' ?>" name="oldpassword" id="oldpassword" maxlength="50" type="password" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-1">
                  </div>
                </div>
                <!-- old password-->
                <br></br>
                <div class="row mb-2">
                  <!-- new password-->
                  <div class="col-lg-1">
                  </div>
                  <div class="col-lg-4">
                    <label class="unrequired-field">New Password:</label><br>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-group">
                      <input type="password" value="<?php echo isset($_POST['newpassword']) ? $_POST['newpassword'] : '' ?>" name="newpassword" id="newpassword" maxlength="50 type=" password" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-1">
                  </div>
                </div>
                <!-- new password-->
                <div class="row mb-2">
                  <!-- new password-->
                  <div class="col-lg-1">
                  </div>
                  <div class="col-lg-4">
                    <label class="unrequired-field">Confirm Password:</label><br>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-group">
                      <input type="password" value="<?php echo isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '' ?>" name="confirmpassword" id="confirmpassword" maxlength="50 type=" password" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-1">
                  </div>
                </div>
                <!-- new password-->
                <div class="row mb-2">
                  <!--Update button-->
                  <div class="col-lg-6">
                  </div>
                  <div class="col-lg-3" style="display: flex;justify-content: center;
                                        align-items: center;">
                    <button type="submit" name="btn-submit" class="btn btn-primary add-button">
                      <span class=" fas fa-save">&nbsp&nbsp</span>Update
                    </button>
                  </div>
                  <div class="col-lg-2" style="display: flex;justify-content: center;
                                        align-items: center;">
                    <button onClick="cleartext();" type="submit" class="btn btn-primary add-button">
                      Clear
                    </button>
                  </div>
                  <div class="col-lg-2">
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
  $mobilenum =  $_SESSION['mobile'];
  //if lrn is not equal to 12
  // if (strlen($_POST['newpassword'])!=12 && strlen($_POST['newpassword'])!=0){
  //   displayMessage("warning","new password is Invalid","Please try again");
  //   }

  if (empty($_POST['newpassword']) || empty($_POST['confirmpassword'])) {
    displayMessage("warning", "New/Confirm password must not be empty", "Please try again");
  } elseif ($_POST['newpassword'] != $_POST['confirmpassword']) {
    displayMessage("warning", "Password Mismatch", "Please try again");
  } else {
    $sql = "select a.* from tbl_parentuser as a where mobile='" . $mobilenum . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

      if ($pass_row = mysqli_fetch_assoc($result)) {

        $chkpass = password_verify($_POST['oldpassword'], $pass_row['password']);

        if (!$chkpass) {
          displayMessage("warning", "Wrong Current Password", "Please try again ");
        } else {
  $errorMessage = 'Password must have ';
  $hasError = 0; 
  if(strlen($_POST['newpassword']) < $minLength){
    $errorMessage .= $lenCheck;
    $hasError = 1;
  } 

  if($hasNumberCheck){
    if (countDigits($_POST['newpassword']) < $minNumberCount) {
      if (!$hasError) {
        $errorMessage .= ltrim($numCheck, ','); 
      }
      else{
        $errorMessage .= $numCheck;
      }
      $hasError = 1;
    }
  }

  if($hasUpperCase){
    if (countUpperCase($_POST['newpassword']) < $minUpperCase) {
      if (!$hasError) {
        $errorMessage .= ltrim($ucCheck, ','); 
      }
      else{
        $errorMessage .= $ucCheck;
      }
      $hasError = 1;
    }
  }

  if($hasSpecialCharacter){
    if (countSpecialCharacter($_POST['newpassword']) < $minSpecialCharacter) {
      if (!$hasError) {
        $errorMessage .= ltrim($scCheck, ','); 
      }
      else{
        $errorMessage .= $scCheck;
      }
      $hasError = 1;
    }
  }

  if ($hasError) {
    $_SESSION['MESSAGE-PROMPT'] = $errorMessage;
    header('Location: adminchangepass.php?forgotNumber='.$forgotNumber.'&forgotpass=true&passwordRequirementFailed');
    exit(1);
  }

          $hashedPassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
          $queryupdatepass = " update tbl_parentuser set password = '" . $hashedPassword  . "' where mobile='" . $mobilenum . "'";

          $date = date('Y-m-d H:i:s');
          $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Changes password', '$date','" . $schoolYearID . "')";
          mysqli_query($conn, $insertauditQuery);

          mysqli_query($conn, $queryupdatepass);
          session_destroy();
          header('Location: ../login.php?cps');
        }
      }
    };
  };
}


if (isset($_SESSION['MESSAGE-PROMPT'])&&isset($_REQUEST['passwordRequirementFailed'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("error","Invalid Entry",$message);
  unset($_SESSION['MESSAGE-PROMPT']);
}

?>