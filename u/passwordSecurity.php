<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php

$page = "passwordsecurity";

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

$sql = " select *  FROM tbl_PasswordSettings LIMIT 1";
$result1 = mysqli_query($conn, $sql);
$ctr = 0;
if (mysqli_num_rows($result1) > 0) {
  $row = mysqli_fetch_array($result1);
  $hasLoginAttempt                =  $row['1'];
  $maxLoginAttempt                =  $row['2'];
  $hasLengthCheck                 =  $row['3'];
  $minLength                      =  $row['4'];
  $hasNumberCheck                 =  $row['5'];
  $minNumberCount                 =  $row['6']; 
  $hasSpecialCharacter            =  $row['7'];
  $minSpecialCharacter            =  $row['8'];
  $hasUpperCase                   =  $row['9'];
  $minUpperCase                   =  $row['10'];
  $hasRecaptchaUponLogin          =  $row['11'];
  $hasRecaptchaUponAttendance     =  $row['12'];
  $hasRecaptchaUponVerification   =  $row['13'];
  $hasOTP                         =  $row['14'];
}
else{
 header("location: home.php");
}
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Security| Parent Portal</title>
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
              <h1>Security Preferences</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Security Preferences</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


      <div class="container">
        <div class="card card-primary card-outline">
          <div class="card-body">
            <form action="" method="post">
              <br>
            <div style="margin-left: 20px;">

            <h3 class=""><?php echo "Login Security" ?></h3>
<hr>
            <div style="margin-left: 20px;">
                <!-- Login Attempt -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="hasLoginAttempt"
                          <?php if($hasLoginAttempt) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck1">Login attempt limit</label>
                      </div>
                  </div>

                  <div id="customCard1" class="form-group row
                  ">
                    <label for="noFailedAttempt" class="col-sm-3 col-form-label">Max. Login Attempts</label>
                    <div class="col-xs-3">
                      <input <?php echo "value='$maxLoginAttempt'"; ?>  type="number" name="maxLoginAttempt" class="form-control" id="noFailedAttempt" autocomplete="false" min="3">
                    </div>
                  </div>
                 <!-- Login Attempt --><br>

                <!-- Login Attempt -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck8" name="hasOTP"
                          <?php if(  $hasOTP ) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck8">Login verification ( OTP ) </label>
                      </div>
                  </div>

                  <div id="customCard1" class="form-group row
                  ">
                    <div class="col-xs-3">
                    </div>
                  </div>
                 <!-- Login Attempt --><br>
               </div>

            <h3 class=""><?php echo "Password Security" ?></h3>
<hr>                 
                <div style="margin-left: 20px;">
                <!-- Length Check -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck2" name="hasLengthCheck"
                          <?php if($hasLengthCheck) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck2">Customize password length <sup id="defaultsup"  class="<?php if($hasLengthCheck) echo "d-none"; ?>" style="color:red;"> * 8 characters length is the default</sup></label>
                      </div>
                  </div>

                  <div id="customCard2" class="form-group row
                  ">
                    <label for="noFailedAttempt" class="col-sm-3 col-form-label">Min. Password Length</label>
                    <div class="col-xs-3">
                      <input  <?php echo "value='$minLength'"; ?> type="number" name="minLength" class="form-control" id="noFailedAttempt" autocomplete="false" min="8">
                    </div>
                  </div>
                 <!-- Length Check --><br>


                <!-- Number Check -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck3" name="hasNumberCheck"
                          <?php if($hasNumberCheck) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck3">Require digit(s) on password</label>
                      </div>
                  </div>

                  <div id="customCard3" class="form-group row
                  ">
                    <label for="noFailedAttempt" class="col-sm-3 col-form-label">Min. Digit(s)</label>
                    <div class="col-xs-3">
                      <input  <?php echo "value='$minNumberCount'"; ?> type="number" name="minNumberCount" class="form-control" id="noFailedAttempt" autocomplete="false" min="1">
                    </div>
                  </div>
                 <!-- Number Check --><br>

                <!-- Special Character -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck4" name="hasSpecialCharacter"
                          <?php if($hasSpecialCharacter) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck4">Require special character</label>
                      </div>
                  </div>

                  <div id="customCard4" class="form-group row
                  ">
                    <label for="noFailedAttempt" class="col-sm-3 col-form-label">Min. Special Character(s)</label>
                    <div class="col-xs-3">
                      <input  <?php echo "value='$minSpecialCharacter'"; ?> type="number" name="minSpecialCharacter" class="form-control" id="noFailedAttempt" autocomplete="false" min="1">
                    </div>
                  </div>
                 <!-- Special Character --><br>


                <!-- Upper Case -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck5" name="hasUpperCase"
                          <?php if($hasUpperCase) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck5">Require upper case</label>
                      </div>
                  </div>

                  <div id="customCard5" class="form-group row
                  ">
                    <label for="noFailedAttempt" class="col-sm-3 col-form-label">Min. Upper Case</label>
                    <div class="col-xs-3">
                      <input  <?php echo "value='$minUpperCase'"; ?> type="number" name="minUpperCase" class="form-control" id="noFailedAttempt" autocomplete="false" min="1">
                    </div>
                  </div>
                 <!-- Upper Case -->
              </div>
                 <hr>
           <h3 class=""><?php echo "Google reCAPTCHA" ?></h3>



<div style="margin-left: 20px;">


                <!-- Login Attempt -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck6" name="hasRecaptchaUponLogin"
                          <?php if($hasRecaptchaUponLogin) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck6">Login reCAPTCHA</label>
                      </div>
                  </div>

                 <!-- Login Attempt --><br>

                <!-- Login Attempt -->
                  <div class="form-group row">
                    <div class="col-sm-3"></div>
                      <div class="custom-control custom-checkbox col-xs-3" >
                        <input type="checkbox" class="custom-control-input" id="customCheck7" name="hasRecaptchaUponAttendance"
                          <?php if($hasRecaptchaUponAttendance) echo "Checked"; ?>
                        >
                        <label class="custom-control-label" for="customCheck7">Attendance reCAPTCHA</label>
                      </div>
                  </div>

                 <!-- Login Attempt --><br>


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
<?php 

                    if(!$hasLoginAttempt){ echo '$("#customCard1").fadeOut(250);'; }
                    if(!$hasLengthCheck){ echo '$("#customCard2").fadeOut(250);'; }
                    if(!$hasNumberCheck){ echo '$("#customCard3").fadeOut(250);'; }
                    if(!$hasSpecialCharacter){ echo '$("#customCard4").fadeOut(250);'; }
                    if(!$hasUpperCase){ echo '$("#customCard5").fadeOut(250);'; }
?> 


$(function () {
        $("#customCheck1").click(function () {
            if ($(this).is(":checked")) {
                $("#customCard1").fadeIn(500);
                $("#customCard1").removeClass('d-none');

            } else {
                $("#customCard1").fadeOut(500);
            }
        });

        $("#customCheck2").click(function () {
            if ($(this).is(":checked")) {
                $("#customCard2").fadeIn(500);
                $("#customCard2").removeClass('d-none');
                $("#defaultsup").fadeOut(500);


            } else {
                $("#customCard2").fadeOut(500);
                $("#defaultsup").fadeIn(800);
                $("#defaultsup").removeClass('d-none');
            }
        });

        $("#customCheck3").click(function () {
            if ($(this).is(":checked")) {
                $("#customCard3").fadeIn(500);
                $("#customCard3").removeClass('d-none');

            } else {
                $("#customCard3").fadeOut(500);
            }
        });

        $("#customCheck4").click(function () {
            if ($(this).is(":checked")) {
                $("#customCard4").fadeIn(500);
                $("#customCard4").removeClass('d-none');

            } else {
                $("#customCard4").fadeOut(500);
            }
        });

        $("#customCheck5").click(function () {
            if ($(this).is(":checked")) {
                $("#customCard5").fadeIn(500);
                $("#customCard5").removeClass('d-none');

            } else {
                $("#customCard5").fadeOut(500);
            }
        });
    });





  extendSession();
  var isPosted;
  var isDisplayed = false;
  setInterval(function() {
    sessionChecker();
  }, 20000); //time in milliseconds


</script>


<?php

if (isset($_POST['editThis'])) {

// hasLoginAttempt
// hasLengthCheck
// hasNumberCheck
// hasSpecialCharacter
// hasUpperCase
// hasRecaptchaUponLogin
// hasRecaptchaUponAttendance


/////////////////////////
// maxLoginAttempt     //
// minLength           //
// minNumberCount      //
// minSpecialCharacter //
// minUpperCase        //
// 
//                     //
/////////////////////////

    $_POST['maxLoginAttempt']   = mysqli_real_escape_string($conn, stripcslashes($_POST['maxLoginAttempt']));
    $_POST['minLength']   = mysqli_real_escape_string($conn, stripcslashes($_POST['minLength']));
    $_POST['minNumberCount']   = mysqli_real_escape_string($conn, stripcslashes($_POST['minNumberCount']));
    $_POST['minSpecialCharacter']   = mysqli_real_escape_string($conn, stripcslashes($_POST['minSpecialCharacter']));
    $_POST['minUpperCase']   = mysqli_real_escape_string($conn, stripcslashes($_POST['minUpperCase']));

    if (!isset($_POST['hasLoginAttempt'])) {
      $isCond1 = 0;
      $_POST['maxLoginAttempt']   = $maxLoginAttempt;
    }
    else{
      $isCond1 = 1;
    }

    if (!isset($_POST['hasLengthCheck'])) {
      $isCond2 = 0;
      $_POST['minLength']   = $minLength;
    }
    else{
      $isCond2 = 1;
    }

    if (!isset($_POST['hasNumberCheck'])) {
      $isCond3 = 0;
      $_POST['minNumberCount']   = $minNumberCount;
    }
    else{
      $isCond3 = 1;
    }

    if (!isset($_POST['hasSpecialCharacter'])) {
      $isCond4 = 0;
      $_POST['minSpecialCharacter']   = $minSpecialCharacter;
    }
    else{
      $isCond4 = 1;
    }

    if (!isset($_POST['hasUpperCase'])) {
      $isCond5 = 0;
      $_POST['minUpperCase']   = $minUpperCase;
    }
    else{
      $isCond5 = 1;
    }
    if (!isset($_POST['hasRecaptchaUponLogin'])) {
      $isCond6 = 0;
    }
    else{
      $isCond6 = 1;
    }

    if (!isset($_POST['hasRecaptchaUponAttendance'])) {
      $isCond7 = 0;
    }
    else{
      $isCond7 = 1;
    }

    if (!isset($_POST['hasOTP'])) {
      $isCond8 = 0;
    }
    else{
      $isCond8 = 1;
    }





    
    $insertQuery = "update tbl_PasswordSettings
set
hasLoginAttempt             = '" . $isCond1 . "',
maxLoginAttempt             = '" . $_POST['maxLoginAttempt'] . "',
hasLengthCheck              = '" . $isCond2 . "',
minLength                   = '" . $_POST['minLength'] . "',
hasNumberCheck              = '" . $isCond3 . "',
minNumberCount              = '" . $_POST['minNumberCount'] . "',
hasSpecialCharacter         = '" . $isCond4 . "',
minSpecialCharacter         = '" . $_POST['minSpecialCharacter'] . "',
hasUpperCase                = '" . $isCond5 . "',
minUpperCase                = '" . $_POST['minUpperCase'] . "',
hasRecaptchaUponLogin       = '" . $isCond6 . "',
hasRecaptchaUponAttendance  = '" . $isCond7 . "',
hasOTP                      = '" . $isCond8 . "'
where 1

";
echo "$insertQuery";

// echo $insertQuery;
    mysqli_query($conn, $insertQuery);

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Changes Password Security  ' '" . $_SESSION['first-name'] . " ' '" . $_SESSION['last-name'] .  "', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);

    $message = "Settings Changed";
    $title = "Success";
    $type = "success";
    header('Location: passwordSecurity.php?title=' . $title . '&type=' . $type . '&message=' . $message);
}

if (isset($_GET['message'])) {
  displayMessage($_GET['type'], $_GET['title'], $_GET['message']);
}
?>