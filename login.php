<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php

  session_start();
  ob_start();
  $schoolYearID;

  # Schoolname, Logo, ABV
  require 'include/schoolConfig.php';
  # Database
  require 'include/config.php';
  # SchoolYear
  require 'include/getschoolyear.php';
  # Font
  include 'include/fonts.php';
  # PHP functuions
  require 'assets/phpfunctions.php';
  # http -> https
  require 'include/httpsRouter.php';


  #Get all Security features
  $sql1 = "select * from tbl_PasswordSettings";
  $result = mysqli_query($conn, $sql1);
  $pass_row = mysqli_fetch_assoc($result);
  $maxLoginAttempt = $pass_row['maxLoginAttempt'];
  $hasLoginAttempt = $pass_row['hasLoginAttempt'];
  $hasRecaptchaUponLogin = $pass_row['hasRecaptchaUponLogin'];
  $hasRecaptchaUponAttendance = $pass_row['hasRecaptchaUponAttendance'];
  $hasOTP = $pass_row['hasOTP'];
  $ip = $_SERVER["REMOTE_ADDR"];


  ?>


  <script src="assets/js/sweetalert2.all.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="include/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="include/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- custom style -->
  <link rel="stylesheet" type="text/css" href="assets/css/home-style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/login-style.css">
  <!-- InputMask -->
  <script src="include/plugins/moment/moment.min.js"></script>
  <script src="include/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- Google recaptcha -->
  <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>


  <title>
    <?php echo SCHOOL_ABV . "  | Parent Portal" ?>
  </title>

    <link rel="shortcut icon" href="assets/imgs/favicon.ico">


</head>

<body>
  <div class=" main">

    <div class="row navbar" style="margin-top: -10px;">
      <div class="col-sm-8" style="padding-left: 30px;"><a style="color: black">
          <a href="index.php"><img class="img-school-logo " draggable="false" src="<?php echo SCHOOL_LOGO_PATH ?>" style="border-radius: 50%; width: 70px; height: 70px; margin-top: -10px;"></a>
          <span class="lbl-school-name"><b style="color: white;"><?php echo SCHOOL_NAME; ?></a></b></span>
      </div>
      <div class="col-sm-4">
        <div class="row">
          <div class="col-sm-5">
            <!-- <a href="PP2ReleaseNotesAdmin.pdf" class="glow d-flex justify-content-end" style="font-size: 20px; color: white;" type="application/pdf" target="_blank"><strong>What's New ?</strong></a> -->
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-7 feature ">
        <div class="col-lg-8 feature-box">
          <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-11"><b class="WPP">Welcome to Parent Portal,</b></div>
          </div>

          <br>
          <div class="row">
            <div class="col-lg-12 fLabel">
              <img class="fLogo " src="assets/imgs/icon/grades.png" draggable="false">&nbsp&nbsp&nbsp
              <b style="font-size: 20px;">View Grades.</b><span style="font-size: 15px;"> Parents can view report cards of their children from the comfort of their home.</span>
            </div>
          </div>

          <br>         
</div>
      </div>
      <br>

      <div class="col-lg-5 main-reg-form">
        <br><br><br><br>
        <form action="login.php" method="post" <?php if ($hasRecaptchaUponLogin) {echo 'onsubmit="return validateRecaptcha();"';} ?> >
          <div class="container col-lg-10 reg-form">
            <div class="row">
              <div class="col-lg-10 signup-label" style="font-size: 27px;"><b>Sign In</b></div>
            </div>
            <br>
            <div class="row">
              <div class="col-lg-10">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-mobile" style="width: 14px;"> </i></span>
                    </div>

                    <input placeholder="Mobile Number" value="<?php if (isset($_GET['mobilenr'])) {
                                                                echo $_GET['mobilenr'];
                                                              } ?>" name="forgotNumber" id="forgotNumber" required type="text" class="form-control" data-inputmask='"mask": "9999-999-9999"' data-mask>

                  </div>
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
                    <input placeholder="Password" required name="password" type="password" class="form-control" id="exampleInputPassword1" id="input-password"><br>

                  </div>
                </div>
              </div>
            </div>


            <?php if ($hasRecaptchaUponLogin) {?>
            <div class="row">
              <div class="col-lg-10">
                <div class="form-group">
                  <div class="input-group">
                    <div class="col-lg-5">
                  <a data-toggle="modal" data-target="#modal-default" class="fPassword forgotPassLink" href="#">Forgot Password ?</a>
                    </div>
                    <div class="col-lg-7">
                      <div id="RecaptchaField1"></div>
                  <!-- <div class="g-recaptcha" data-sitekey="6LeGhvwZAAAAAAnvqsZ6vWJplmbsjAXny9h4xM0a"></div> -->
                      
                    </div>

                  </div>
                </div>
              </div>
            </div>
       <?php   }
            ?>


            <div class="row">
              <div class="col-lg-5">
                <div class="form-group">
<?php if (!$hasRecaptchaUponLogin) {?>
                  <a data-toggle="modal" data-target="#modal-default" class="fPassword forgotPassLink" href="#">Forgot Password ?</a>
         <?php   }
            ?>
                </div>
              </div>

              <div class="col-lg-5">
                <div class="form-group">
                  <button type="submit" value="submit" name="login" id="loginbtn" class="btn btn-primary btn-block" style="float: left;"><b>SIGN IN</b></button>
                </div>
              </div>

            </div>
        </form>
        <br><br>
      </div>

      </form>

    </div>
  </div>

  </div>

  </div>

  </div>

  <?php require 'include/getVersion.php'; ?>
  <footer>
  <div class="copyright">
  <div class="d-flex">
  <div class="p-2">&nbsp&nbsp&nbsp <strong>Copyright &copy; 2020 <span>Protrack Parent Portal</span></strong></div>
  
  <div class="ml-auto p-2"><strong>Version : <?php echo $VersionNo ?> &nbsp&nbsp&nbsp Build No.: <?php echo $BuildNo ?></strong></div>
  </div>
  </div>
  </footer>
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="forgotpassword2.php" method="get" onsubmit=" return forgotNumberValid(this)">
          <div class="modal-header">
            <h4 class="modal-title">Password Recovery</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label class="required-field">Mobile Number</label><br>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                </div>
                <input value="<?php if (isset($_GET['mobilenr'])) {
                                echo $_GET['mobilenr'];
                              } ?>" name="forgotNumber" required type="text" class="form-control" data-inputmask='"mask": "9999-999-9999"' data-mask id="forgotpassword">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="forgotpass" value="true">Next</button>
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <?php require 'maintenanceChecker.php';
  ?>

</body>



<!-- jQuery -->
<script src="include/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="include/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask -->
<script src="include/plugins/moment/moment.min.js"></script>
<script src="include/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<script type="text/javascript">

    var CaptchaCallback = function() {
        grecaptcha.render('RecaptchaField1', {'sitekey' : '6LeGhvwZAAAAAAnvqsZ6vWJplmbsjAXny9h4xM0a'});
    };

  //reCAPTCHA LOGIN Validation
  function validateRecaptcha() {
      var response = grecaptcha.getResponse(0);
      if (response.length === 0) {
        Swal.fire({
          title: 'Please Tick the reCAPTCHA',
    imageUrl: 'assets/imgs/reCapGuide.jpg',
    imageWidth: 400,
    imageHeight: 200,
    imageAlt: 'Custom image',
          customClass: 'swal-sm'
        })
          return false;
      } else {
         // alert("validated");
          return true;
      }
  }

  var onloadCallback = function() {
    console.log("grecaptcha is ready!");
  };

  $(document).ready(function() {
    setInterval(function() {
      $('#time').load('time.php')
    }, 20000);
  });

  $('[data-mask]').inputmask();
  $('.alert').alert();

  function forgotNumberValid(form) {
    var forgotNumber = form.forgotNumber.value;
    forgotNumber = forgotNumber.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
    forgotNumber = $.trim(forgotNumber);


    if (forgotNumber.length < 11) {
      $(form.forgotNumber).addClass("is-invalid").removeClass("is-invalid");
      $(form.forgotNumber).attr('title', "Invalid Number");
      $(form.forgotNumber).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
      return false;
    } else {
      //return true;
    }

  }

  //InputFilter
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

  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }


  $("#exampleInputPassword1").on('input', function() {
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


  $("#studnum").on('input', function() {
    if ($(this).val().length >= 15) {
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



  $("#forgotNumber").on('input', function() {
    if (this.value.replace(/[_-]/g, '').length >= 11) {
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

</html>
<?php

if (isset($_REQUEST['insertsuccess'])) {
  $message = "You\'re now register";
  displayMessage("success", "Success", $message);
}

if (isset($_REQUEST['cps'])) {
  $message = "Password has been changed. Please re-login";
  displayMessage("success", "Success", $message);
}
if (isset($_REQUEST['cms'])) {
  $message = "Account details has been changed. Please re-login";
  displayMessage("success", "Success", $message);
}
if (isset($_REQUEST['mobilenr'])) {
  $message = "This mobile number is not registered.";
  displayMessage("error", "No Match", $message);
}

if (isset($_REQUEST['wrongpassword'])) {
  displayMessage("Failed", "Wrong Password", "Incorrect Password, Please try again.");
}
if (isset($_REQUEST['invalidmobile'])) {
  displayMessage("Failed", "Invalid Mobile", "Please try again.");
}
if (isset($_REQUEST['maxLoginAttempt'])) {

    $result = mysqli_query($conn, "SELECT timestamp FROM `ip` ORDER BY TIMESTAMP desc LIMIT 1");
    $count2 = mysqli_fetch_array($result, MYSQLI_NUM);
    $date2 = new DateTime(date("Y-m-d H:i:s"));
    $date3 = new DateTime($count2[0]);
    $since_start = $date3->diff($date2);
    $datediffinmin= $since_start->i;

    $datediffinmin = $datediffinmin -10; 
    if ($datediffinmin > -1) {
    displayMessage("info", "Try to login", "Login attempt restriction has been lifted");
    }
    else{
      $datediffinmin = abs($datediffinmin);
    displayMessage("error", "Login Attempt Limit Reach", "Please try again to login in $datediffinmin minute(s)");
    }


}
if (isset($_POST['login'])) {

  if ($hasLoginAttempt) {
     $date = date("Y-m-d H:i:s");
    $time = strtotime($date);
    $time = $time - (15 * 60);
    $date = date("Y-m-d H:i:s", $time);
    $result = mysqli_query($conn, "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE '$ip' AND `timestamp` > '$date'");
    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    if($count[0] > $maxLoginAttempt){
       header('Location: login.php?maxLoginAttempt');
       exit(1);
    }
  }

  $_POST['forgotNumber']   = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['forgotNumber'])));

  $sql1 = "sELECT a.schoolYearID from tbl_parentuser as a where mobile='" . $_POST['forgotNumber'] . "'";

  $result = mysqli_query($conn, $sql1);
  $pass_row = mysqli_fetch_assoc($result);
  $syid = $pass_row['schoolYearID'];

  if ($syid == '0') {

    $_POST['forgotNumber']   = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['forgotNumber'])));

    $sql = "SELECT a.* from tbl_parentuser as a where mobile='" . $_POST['forgotNumber'] . "'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

      if ($pass_row = mysqli_fetch_assoc($result)) {

        if (!$pass_row['isEnabled']) {
          header('Location: login.php?notActive');
          exit(1);
        }
        $chkpass = password_verify($_POST['password'], $pass_row['password']);


        if (!$chkpass) {
          if ($hasLoginAttempt) {
           $tmpnum = $_POST['forgotNumber'];

           mysqli_query($conn, "INSERT INTO `ip` (`address` ,`timestamp`,`mobile`)VALUES ('$ip','".date("Y-m-d H:i:s")."','$tmpnum')");
          }


          header('Location: login.php?wrongpassword');
        } elseif ($chkpass == true) {


          $_SESSION['userID']      = $pass_row['userID'];
          $_SESSION['sqID']      = $pass_row['sqID'];
          $_SESSION['first-name']  = $pass_row['fname'];
          $_SESSION['middle-name'] = $pass_row['mname'];
          $_SESSION['last-name']   = $pass_row['lname'];
          $_SESSION['mobile']      = $pass_row['mobile'];
          $_SESSION['userEmail']   = $pass_row['email'];
          $_SESSION['usertype']    = $pass_row['usertype'];
          $_SESSION['gender']       = $pass_row['sex'];
          $_SESSION['userPass']     = $_POST['password'];
          $_SESSION['pID']     = $pass_row['pID'];
          $_SESSION['threadID'] = $pass_row['threadID'];
          $_SESSION['last-time-stamp'] = time();

          
            $datetime = date('Y-m-d H:i:s');

            $insertauditQuery3 = "Insert into tbl_loginLogs (userID, loginTime,schoolYearID) Values  ('" .  $pass_row['userID'] . "', '" . $datetime . "', '" . $schoolYearID . "')";
            mysqli_query($conn, $insertauditQuery3);


          require 'sendmessage.inc.php';
          require 'messageCheck.inc.php';

          if ($_SESSION['usertype'] === 'A') {
            $date = date('Y-m-d H:i:s');
            $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $pass_row['userID'] . "', '" .  $pass_row['fname'] . "', '" .  $pass_row['lname'] . "', 'Logins to the system. ', '$date','" . $schoolYearID . "')";
            mysqli_query($conn, $insertauditQuery);

            header('Location: u/index.php');
            exit();
          } elseif ($_SESSION['usertype'] === 'E') {
            header('Location: u/PersonnelHome.php');
            exit();
          } elseif ($_SESSION['usertype'] === 'P') {
            header('Location: login.php?mobilenr');
            exit();
          } elseif ($_SESSION['usertype'] === 'S') {
            header('Location: u/index.php');
            exit();
          }
        }
      } else {
        header('Location: login.php?tryagain');
        exit();
      }
    } else {
      displayMessage("warning", "This phone number is not registered", "Please try again");
    }
  } else {
    $sql1 = "SELECT a.schoolYearID from tbl_parentuser as a where mobile='" . $_POST['forgotNumber'] . "' AND a.schoolYearID ='" . $schoolYearID . "'";

    $result = mysqli_query($conn, $sql1);
    $pass_row = mysqli_fetch_assoc($result);
    $syid = $pass_row['schoolYearID'];

    if ($syid <> $schoolYearID) {
      header('Location: login.php?mobilenr');
    } else {

      $_POST['forgotNumber']   = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['forgotNumber'])));
      $_POST['password'] = mysqli_real_escape_string($conn, stripcslashes($_POST['password']));

      $sql = "SELECT a.* from tbl_parentuser as a where mobile='" . $_POST['forgotNumber'] . "' AND a.schoolYearID ='" . $schoolYearID . "' AND usertype ='E' ORDER BY usertype ASC LIMIT 1";

      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {

        if ($pass_row = mysqli_fetch_assoc($result)) {

          if (!$pass_row['isEnabled']) {
            header('Location: login.php?notActive');
            exit(1);
          }
          $chkpass = password_verify($_POST['password'], $pass_row['password']);


          if (!$chkpass) {

          if ($hasLoginAttempt) {

           $tmpnum = $_POST['forgotNumber'];

           mysqli_query($conn, "INSERT INTO `ip` (`address` ,`timestamp`,`mobile`)VALUES ('$ip','".date("Y-m-d H:i:s")."','$tmpnum')");
          }


            header('Location: login.php?wrongpassword');
          } elseif ($chkpass == true) {

          #payment Reminder Send
          require 'sendmessage.inc.php';
          require 'messageCheck.inc.php';

          #Sessions
          $_SESSION['sqID']            = $pass_row['sqID'];
          $_SESSION['fullname']        = $pass_row['fullName'];
          $_SESSION['mobile']          = $pass_row['mobile'];
          $_SESSION['first-name']      = $pass_row['fname'];
          $_SESSION['middle-name']     = $pass_row['mname'];
          $_SESSION['last-name']       = $pass_row['lname'];
          $_SESSION['userEmail']       = $pass_row['email'];
          $_SESSION['usertype']        = $pass_row['usertype'];
          $_SESSION['gender']          = $pass_row['sex'];
          $_SESSION['userPass']        = $_POST['password'];
          $_SESSION['pID']             = $pass_row['pID'];
          $_SESSION['threadID']        = $pass_row['threadID'];
          $_SESSION['last-time-stamp'] = time();
          $datetime                    = date('Y-m-d H:i:s');

          if ($_SESSION['usertype'] === 'P') {
                header('Location: index.php?mobilenr');
                exit();
          } 

          if ($hasOTP) {
            $_SESSION['TempUserID'] = $pass_row['userID'];
            header('Location: verification.php?login');
          }

          else{

              #LoginLogs
              $insertauditQuery3 = "Insert into tbl_loginLogs (userID, loginTime,schoolYearID) Values  ('" .  $pass_row['userID'] . "', '" . $datetime . "', '" . $schoolYearID . "')";
              mysqli_query($conn, $insertauditQuery3);
  
              #UserID
              $_SESSION['userID'] = $pass_row['userID'];
  
              if ($_SESSION['usertype'] === 'A') {
                header('Location: u/index.php');
                exit();
              } elseif ($_SESSION['usertype'] === 'E') {
                header('Location: u/PersonnelHome.php');
                exit();
              } elseif ($_SESSION['usertype'] === 'P') {
                header('Location: index.php?mobilenr');
                exit();
              } elseif ($_SESSION['usertype'] === 'S') {
                header('Location: u/index.php');
                exit();
              }

            }


        }
        } else {
          header('Location: login.php?tryagain');
          exit();
        }
      } else {
        displayMessage("warning", "This phone number is not registered", "Please try again");
      }
    }
  }
}

if (isset($_REQUEST['logout'])) {

  if ($_SESSION['usertype'] === 'A') {
    $check_id = $_SESSION['userID'];
    $fname = $_SESSION['first-name'];
    $lname = $_SESSION['last-name'];

    $date = date('Y-m-d H:i:s');
    $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $check_id  . "', '" .   $fname . "', '" .  $lname . "', 'Logout from the system. ', '$date','" . $schoolYearID . "')";
    mysqli_query($conn, $insertauditQuery);
    session_destroy();
  }
}

if (isset($_POST['submitTimeIn'])) {

  $sql1 = "sELECT a.isStudent FROM tbl_student AS a WHERE a.studentCode = '" . $_POST['studnum'] . "' ORDER BY a.isStudent DESC ";

  $result1 = mysqli_query($conn, $sql1);
  $pass_row = mysqli_fetch_assoc($result1);
  $studID1 = $pass_row['isStudent'];

  if ($studID1 == 1) {
    //Student
    $sql1 = "SELECT b.isEnabled from tbl_student as a ,tbl_parentuser as b where a.userID=b.userID AND studentCode='" . $_POST['studnum'] . "'";

    $result = mysqli_query($conn, $sql1);
    $pass_row = mysqli_fetch_assoc($result);
    $Notactive = $pass_row['isEnabled'];


    if ($Notactive == 0) {
      header('Location: login.php?notActive');
    } else {

      $sql = "select a.studentID,a.studentCode from tbl_student as a where studentCode='" . $_POST['studnum'] . "'";

      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      if (mysqli_num_rows($result) == 0) {
        header('Location: index.php?nomatch');
      } else {

        $sql1 = "sELECT a.studentID FROM tbl_student AS a WHERE a.studentCode = '" . $_POST['studnum'] . "' ORDER BY a.studentID DESC ";

        $result1 = mysqli_query($conn, $sql1);
        $pass_row = mysqli_fetch_assoc($result1);
        $studID1 = $pass_row['studentID'];

        $datenow = date('Y-m-d');

        if ($result1) {

          $sql1 = "SELECT a.isTimeIn FROM tbl_Attendance AS a WHERE StudentId='" . $studID1 . "' AND TimePunch LIKE '$datenow%' ORDER BY a.Attendance_ID DESC LIMIT 1";

          $result = mysqli_query($conn, $sql1);
          $pass_row = mysqli_fetch_assoc($result);
          $isTimeIn = $pass_row['isTimeIn'];

          if ($isTimeIn == 2 || $isTimeIn == 0) {

            $sql = "select a.studentID,a.studentCode from tbl_student as a where studentCode='" . $_POST['studnum'] . "'";

            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $datenow1 = date('Y/m/d H:i:s');

            if (mysqli_num_rows($result) > 0) {
              $sql = "sELECT a.studentID FROM tbl_student AS a WHERE a.studentCode = '" . $_POST['studnum'] . "' ORDER BY a.studentID DESC ";

              $result = mysqli_query($conn, $sql);
              $pass_row = mysqli_fetch_assoc($result);
              $studID = $pass_row['studentID'];

              $insertQuery = "Insert into tbl_Attendance
      (
        StudentId,
        TimePunch,
        Mode,
        Gateway,
        IsTimeIN,
        isStudent
        )
        VALUES
        (
        '" . $studID . "',
        '" . $datenow1 . "',
        '1',
        'STANDARD',
        '1',
        '1'
        )";
              mysqli_query($conn, $insertQuery);
              header('Location: login.php?TimeIN');
            }
          } elseif ($isTimeIn == 1) {
            displayMessage("error", "Time IN", "You`ve already Time IN");
          }
        }
      }
    }
  }
  //Personnel
  else {

    $sql1 = "SELECT b.isEnabled from tbl_Personnel as a ,tbl_parentuser as b where a.Personnel_Id=b.pID AND Personnel_Code='" . $_POST['studnum'] . "'";

    $result = mysqli_query($conn, $sql1);
    $pass_row = mysqli_fetch_assoc($result);
    $Notactive = $pass_row['isEnabled'];


    if ($Notactive == 0) {
      header('Location: login.php?notActive');
    } else {

      $sql = "select a.Personnel_Id,a.Personnel_Code from tbl_Personnel as a where Personnel_Code='" . $_POST['studnum'] . "'";

      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      if (mysqli_num_rows($result) == 0) {
        header('Location: login.php?nomatch');
      } else {

        $sql1 = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_Code = '" . $_POST['studnum'] . "' ORDER BY a.Personnel_Id DESC ";

        $result1 = mysqli_query($conn, $sql1);
        $pass_row = mysqli_fetch_assoc($result1);
        $studID1 = $pass_row['Personnel_Id'];

        $datenow = date('Y-m-d');

        if ($result1) {

          $sql1 = "SELECT a.isTimeIn FROM tbl_Attendance AS a WHERE StudentId='" . $studID1 . "' AND TimePunch LIKE '$datenow%' ORDER BY a.Attendance_ID DESC LIMIT 1";

          $result = mysqli_query($conn, $sql1);
          $pass_row = mysqli_fetch_assoc($result);
          $isTimeIn = $pass_row['isTimeIn'];

          if ($isTimeIn == 2 || $isTimeIn == 0) {

            $sql = "select a.Personnel_Id,a.Personnel_Code from tbl_Personnel as a where Personnel_Code='" . $_POST['studnum'] . "'";

            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $datenow1 = date('Y/m/d H:i:s');

            if (mysqli_num_rows($result) > 0) {
              $sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_Code = '" . $_POST['studnum'] . "' ORDER BY a.Personnel_Id DESC ";

              $result = mysqli_query($conn, $sql);
              $pass_row = mysqli_fetch_assoc($result);
              $studID = $pass_row['Personnel_Id'];

              $insertQuery = "Insert into tbl_Attendance
      (
        StudentId,
        TimePunch,
        Mode,
        Gateway,
        IsTimeIN,
        isStudent
        )
        VALUES
        (
        '" . $studID . "',
        '" . $datenow1 . "',
        '1',
        'STANDARD',
        '1',
        '2'
        )";
              mysqli_query($conn, $insertQuery);
              header('Location: login.php?TimeIN');
            }
          } elseif ($isTimeIn == 1) {
            header('Location: login.php?AlreadyTimeIN');
          }
        }
      }
    }
  }
}
if (isset($_REQUEST['TimeIN'])) {
  displayMessage("success", "Success", "TIME IN has been made");
}
if (isset($_REQUEST['AlreadyTimeIN'])) {
  displayMessage("error", "Time IN", "You`ve already Time IN");
}

if (isset($_REQUEST['nomatch'])) {
  displayMessage("error", "No Match", "The Student or Employee Code is not register");
}



//TIME OUT
if (isset($_POST['submitTimeOut'])) {

  $sql1 = "sELECT a.isStudent FROM tbl_student AS a WHERE a.studentCode = '" . $_POST['studnum'] . "' ORDER BY a.isStudent DESC ";

  $result1 = mysqli_query($conn, $sql1);
  $pass_row = mysqli_fetch_assoc($result1);
  $studID1 = $pass_row['isStudent'];

  if ($studID1 == 1) {
    //student
    $sql1 = "SELECT b.isEnabled from tbl_student as a ,tbl_parentuser as b where a.userID=b.userID AND studentCode='" . $_POST['studnum'] . "'";

    $result = mysqli_query($conn, $sql1);
    $pass_row = mysqli_fetch_assoc($result);
    $Notactive = $pass_row['isEnabled'];


    if ($Notactive == 0) {
      header('Location: login.php?notActive');
    } else {

      $sql = "select a.studentID,a.studentCode from tbl_student as a where studentCode='" . $_POST['studnum'] . "'";

      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      if (mysqli_num_rows($result) == 0) {
        header('Location: login.php?nomatch');
      } else {

        $sql1 = "sELECT a.studentID FROM tbl_student AS a WHERE a.studentCode = '" . $_POST['studnum'] . "' ORDER BY a.studentID DESC ";

        $result1 = mysqli_query($conn, $sql1);
        $pass_row = mysqli_fetch_assoc($result1);
        $studID1 = $pass_row['studentID'];

        $datenow = date('Y-m-d');

        if ($result1) {

          $sql1 = "SELECT a.isTimeIn FROM tbl_Attendance AS a WHERE StudentId='" . $studID1 . "' AND TimePunch LIKE '$datenow%' ORDER BY a.Attendance_ID DESC LIMIT 1";

          $result = mysqli_query($conn, $sql1);
          $pass_row = mysqli_fetch_assoc($result);
          $isTimeIn = $pass_row['isTimeIn'];

          if ($isTimeIn == 1 || $isTimeIn == 0) {

            $sql = "select a.studentID,a.studentCode from tbl_student as a where studentCode='" . $_POST['studnum'] . "'";

            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $datenow1 = date('Y/m/d H:i:s');

            if (mysqli_num_rows($result) > 0) {
              $sql = "sELECT a.studentID FROM tbl_student AS a WHERE a.studentCode = '" . $_POST['studnum'] . "' ORDER BY a.studentID DESC ";

              $result = mysqli_query($conn, $sql);
              $pass_row = mysqli_fetch_assoc($result);
              $studID = $pass_row['studentID'];

              $insertQuery = "Insert into tbl_Attendance
      (
        StudentId,
        TimePunch,
        Mode,
        Gateway,
        IsTimeIN,
        isStudent
        )
        VALUES
        (
        '" . $studID . "',
        '" . $datenow1 . "',
        '2',
        'STANDARD',
        '2',
        '1'
        )";
              mysqli_query($conn, $insertQuery);
              header('Location: login.php?TimeOUT');
            }
          } elseif ($isTimeIn == 2) {
            displayMessage("error", "Time OUT", "You`ve already Time OUT");
          }
        }
      }
    }
  }
  //Personnel
  else {



    $sql1 = "SELECT b.isEnabled from tbl_Personnel as a ,tbl_parentuser as b where a.Personnel_Id=b.pID AND Personnel_Code='" . $_POST['studnum'] . "'";

    $result = mysqli_query($conn, $sql1);
    $pass_row = mysqli_fetch_assoc($result);
    $Notactive = $pass_row['isEnabled'];


    if ($Notactive == 0) {
      header('Location: login.php?notActive');
    } else {

      $sql = "select a.Personnel_Id,a.Personnel_Code from tbl_Personnel as a where Personnel_Code='" . $_POST['studnum'] . "'";

      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      if (mysqli_num_rows($result) == 0) {
        header('Location: login.php?nomatch');
      } else {

        $sql1 = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_Code = '" . $_POST['studnum'] . "' ORDER BY a.Personnel_Id DESC ";

        $result1 = mysqli_query($conn, $sql1);
        $pass_row = mysqli_fetch_assoc($result1);
        $studID1 = $pass_row['Personnel_Id'];

        $datenow = date('Y-m-d');

        if ($result1) {

          $sql1 = "SELECT a.isTimeIn FROM tbl_Attendance AS a WHERE StudentId='" . $studID1 . "' AND TimePunch LIKE '$datenow%' ORDER BY a.Attendance_ID DESC LIMIT 1";

          $result = mysqli_query($conn, $sql1);
          $pass_row = mysqli_fetch_assoc($result);
          $isTimeIn = $pass_row['isTimeIn'];

          if ($isTimeIn == 1 || $isTimeIn == 0) {

            $sql = "select a.Personnel_Id,a.Personnel_Code from tbl_Personnel as a where Personnel_Code='" . $_POST['studnum'] . "'";

            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $datenow1 = date('Y/m/d H:i:s');

            if (mysqli_num_rows($result) > 0) {
              $sql = "sELECT a.Personnel_Id FROM tbl_Personnel AS a WHERE a.Personnel_Code = '" . $_POST['studnum'] . "' ORDER BY a.Personnel_Id DESC ";

              $result = mysqli_query($conn, $sql);
              $pass_row = mysqli_fetch_assoc($result);
              $studID = $pass_row['Personnel_Id'];

              $insertQuery = "Insert into tbl_Attendance
      (
        StudentId,
        TimePunch,
        Mode,
        Gateway,
        IsTimeIN,
        isStudent
        )
        VALUES
        (
        '" . $studID . "',
        '" . $datenow1 . "',
        '2',
        'STANDARD',
        '2',
        '2'
        )";
              mysqli_query($conn, $insertQuery);
              header('Location: login.php?TimeOUT');
            }
          } elseif ($isTimeIn == 2) {
            header('Location: login.php?AlreadyTimeOUT');
          }
        }
      }
    }
  }
}
if (isset($_REQUEST['notActive'])) {
  displayMessage("warning", "Account inactive", "The account that you\'re trying to access is not active. Please contact the site administrator");
}
if (isset($_REQUEST['TimeOUT'])) {
  displayMessage("success", "Success", "TIME OUT has been made");
}
if (isset($_REQUEST['AlreadyTimeOUT'])) {
  displayMessage("error", "Time OUT", "You\'ve already Time OUT");
}

if (isset($_REQUEST['nomatch'])) {
  displayMessage("error", "No Match", "The Student or Employee Code is not register");
}

?>