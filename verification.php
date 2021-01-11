<html lang="en">

    <?php 
    require 'include/schoolConfig.php';
    require 'include/config.php';
    require 'assets/phpfunctions.php';
    require 'sendText2.php';
    // require 'sendMail.php';
    session_start();
    ob_start();

    if (!$_SESSION['TempUserID']) {
       header('Location: index.php?');
       exit;  
    }

      $userID = $_SESSION['TempUserID'];
      $fullname  = $_SESSION['fullname'];
      $number = $_SESSION['mobile'];
  ?>


<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- css -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="include/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="include/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- sweetalert -->
  <link rel="stylesheet" type="text/css" href="include/plugins/sweetalert2/sweetalert2.min.css">


  <!-- sweetalert -->
  <script type="text/javascript" src="include/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- js -->
  <!-- InputMask -->
  <script src="include/plugins/moment/moment.min.js"></script>
  <script src="include/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

        <title>
            <?php echo SCHOOL_ABV ."  | Parent Portal"?>
        </title>
        <link rel="shortcut icon" href="assets/imgs/favicon.ico">

<style type="text/css">div.card {box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);}</style>
</head>


<body class="hold-transition sidebar-mini  lockscreen body-style pace-primary">

  <div class="lockscreen-wrapper hidden">
    <div class="lockscreen-logo">
        <a href="index.php"><b><?php echo SCHOOL_NAME; ?></b></a>
      </div>

      <!-- User name -->
      <div class="lockscreen-name"><?php echo $fullname ?></div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">

      <!-- lockscreen image -->
        <div class="lockscreen-image">
        <img src="assets/imgs/pp2logo.png" alt="logo" >
        </div>
  
        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" action="verification.php" method="post">
            <div class="input-group">
          <input type="text" name="otpcode" class="form-control otpform" placeholder="OTP CODE" data-inputmask='"mask": "   * * * * * * "' data-mask >
              <div class="input-group-append">
                  <button type="submit" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
              </div>
            </div>
        </form>
      </div>

    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
      Please enter the code we've sent to your mobile phone  <?php echo "<b>".$number."</b>" ?>
    </div>

    <div class="text-center">
      <a href="index.php">Or sign in as a different user</a>
    </div><br>

    <div class="lockscreen-footer text-center">
    <a href="?resendCode" >Resend Code</a><br>
        <!-- &#x26A0<b><a class="text-black">Please Check Spam Mails</a></b><br> -->
    </div>

</div>

</body>


<script type="text/javascript">
    $('[data-mask]').inputmask();
</script>


</html>
<?php


  function submitCode($otpCode,$action) {

      include 'include/config.php';
      $otpCode= preg_replace('/\s+/', '', $otpCode);
      $otpCode = strtoupper($otpCode);

      $userID = $_SESSION['TempUserID'];

      $sql = "sELECT * FROM tbl_token WHERE userID = '$userID' ORDER BY timeGen DESC  LIMIT 1";
      $result = mysqli_query($conn, $sql);
      $pass_row = mysqli_fetch_assoc($result);
      $time1 = strtotime("now");
      $time2 = strtotime($pass_row['timeGen']);
      $timeDiff = $time1 - $time2;

      
      if ($action == "submit") {
              
      //more than 5 min ago (expired)
      if ($timeDiff >= 300) {
          echo "<script>";
            echo "Swal.fire({";
              echo "position: 'bottom-end',";
              echo "type: 'warning',";
              echo "title: 'Verification Failed',";
              echo "text: 'Code expired',";
              echo "showConfirmButton: false,";
              echo "timer: 2500,";
              echo "customClass: 'swal-sm'";
            echo "})";
          echo "</script>";
      }



      //less than 5 min ago
      else if ($timeDiff <= 300){ 
        //if used
        if ($pass_row['used'] == 1) {
          echo "<script>";
            echo "Swal.fire({";
              echo "position: 'bottom-end',";
              echo "type: 'warning',";
              echo "title: 'Verification Failed',";
              echo "text: 'Code Expired',";
              echo "showConfirmButton: false,";
              echo "timer: 1700,";
              echo "customClass: 'swal-sm'";
            echo "})";
          echo "</script>";
        }

        //equal and not used
        else if ($otpCode==$pass_row['token'] && $pass_row['used'] != 1) {

        $tokenID = $pass_row['tokenID'];
        $sql = "uPDATE tbl_token set used = '1' where tokenID =  $tokenID ";
        $_SESSION['otpChange']=true;
        mysqli_query($conn, $sql);

              #UserID
              $_SESSION['userID'] = $_SESSION['TempUserID'];
              unset($_SESSION['TempUserID']);
              $datetime          = date('Y-m-d H:i:s');
              $insertauditQuery3 = "Insert into tbl_loginLogs (userID, loginTime,schoolYearID) Values  ('" .  $pass_row['userID'] . "', '" . $datetime . "', '" . $schoolYearID . "')";
              mysqli_query($conn, $insertauditQuery3);
  
              if ($_SESSION['usertype'] === 'A') {
                header('Location: u/index.php');
                exit();
              } elseif ($_SESSION['usertype'] === 'E') {
                header('Location: u/PersonnelHome.php'); 
                exit();
              } elseif ($_SESSION['usertype'] === 'P') {
                header('Location: u/home.php');
                exit();
              } elseif ($_SESSION['usertype'] === 'S') {
                header('Location: u/index.php');
                exit();
              }
       }
        else{
          echo "<script>";
            echo "Swal.fire({";
              echo "position: 'bottom-end',";
              echo "type: 'warning',";
              echo "title: 'Verification Failed',";
              echo "text: 'Code don\'t match',";
              echo "showConfirmButton: false,";
              echo "timer: 1700,";
              echo "customClass: 'swal-sm'";
            echo "})";
          echo "</script>";
        }
      }
    }

    else if ($action == "login") {
        if ($timeDiff >= 180 || $pass_row['used'] > 0) {
          $token = generateNumericOTP(6);
          $timeStamp = date("Y-m-d H:i:s");
  
          $userID = $_SESSION['TempUserID'];
  
          $sql = "Insert into tbl_token (token, userID, timeGen,used) values ('".$token."','".$userID."','".$timeStamp."',0)";
          mysqli_query($conn, $sql);
  
          $message = "Your One-Time-PIN is " . $token. " . Use this code to access your Parent Potal account.";
          $number = $_SESSION['mobile'];
          sendOTP($message, $number);
  
          $msg = "Code sent to your phone";
          displayMessage("success", "Success", $msg);
  
        }
  
        else if ($timeDiff < 180){ 
          header('Location: verification.php?cooldown2');
        }
    }

    else if ($action == "resend") {

      if ($timeDiff >= 180 || $pass_row['used'] > 0) {
        $token = generateNumericOTP(6);
        $timeStamp = date("Y-m-d H:i:s");

        $userID = $_SESSION['TempUserID'];

        $sql = "Insert into tbl_token (token, userID, timeGen,used) values ('".$token."','".$userID."','".$timeStamp."',0)";
        mysqli_query($conn, $sql);

        $message = "Your One-Time-PIN is " . $token. " . Use this code to access your Parent Potal account.";
        $number = $_SESSION['mobile'];
        sendOTP($message, $number);

        $msg = "Code sent to your phone";
        displayMessage("success", "Success", $msg);

      }

      else if ($timeDiff < 180){ 
        header('Location: verification.php?cooldown');
      }
    }

        else if ($action == "cooldown") {

          if ($timeDiff >= 180) {
            header('Location: verification.php?resendCode');
            exit;
          }
      $formatedTimeDiff=date("i:s",(180-$timeDiff));
        echo "<script>";
          echo "Swal.fire({";
            echo "position: 'bottom-end',";
            echo "type: 'warning',";
            echo "title: 'Please try to resend again after $formatedTimeDiff',";
            echo "showConfirmButton: false,";
            echo "timer: 1200,";
            echo "customClass: 'swal-sm'";
          echo "})";
        echo "</script>";
    }

    else if ($action == "cooldown2") {

          if ($timeDiff >= 180) {
            header('Location: verification.php');
            exit;
          }


      $formatedTimeDiff=date("i:s",(180-$timeDiff));
        echo "<script>";
          echo "Swal.fire({";
            echo "position: 'bottom-end',";
            echo "type: 'warning',";
            echo "html: 'There\'s still code that hasn\'t been used <br> Please try to resend again after $formatedTimeDiff',";
            echo "showConfirmButton: false,";
            echo "timer: 1800,";
            echo "customClass: 'swal-sm'";
          echo "})";
        echo "</script>";
    }

    else if ($action == "resendSuccess") {
      echo "<script>";
          echo "Swal.fire({";
            echo "position: 'bottom-end',";
            echo "type: 'success',";
            echo "title: 'Success',";
            echo "text: 'Code Resent',";
            echo "showConfirmButton: false,";
            echo "timer: 1700,";
            echo "customClass: 'swal-sm'";
          echo "})";
        echo "</script>";
    }



  }  




//-----------------------------------

function stillHasOTPSent($token,$id)
{
    include 'include/config.php';
    $token = strtoupper($token);
    $userID = $id;  
    
    $sql = "sELECT * FROM tbl_token WHERE userID = '$userID' ORDER BY timeGen DESC  LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $totalrows = mysqli_num_rows($result);
      if($totalrows > 0){
        $pass_row = mysqli_fetch_assoc($result);
        $time1 = strtotime("now");
        $time2 = strtotime($pass_row['timeGen']);
        $timeDiff = $time1 - $time2; 
  
        if ($pass_row['used']=='1'||$timeDiff<=180) {
          echo "<script>";
          echo "alert('1-".$timeDiff."')";
          echo "</script>";
          return false;
        }
        else {
          echo "<script>";
          echo "alert('2".$timeDiff."')";
          echo "</script>";
          return true;
        }
      }
    }
    else{
                          echo "<script>";
          echo "alert('3')";
          echo "</script>";
      return true;
    }

}
  if (isset($_POST['otpcode'])) {
    submitCode($_POST['otpcode'],"submit");
  }

  if (isset($_REQUEST['resendCode'])){
    submitCode("NAN","resend");
  }

  if (isset($_REQUEST['cooldown'])){
    submitCode("NAN","cooldown");
  }

  if (isset($_REQUEST['cooldown2'])){
    submitCode("NAN","cooldown2");
  }

  if (isset($_REQUEST['resendSuccess'])){
    submitCode("NAN","resendSuccess");
  }

  if (isset($_REQUEST['login'])){
    submitCode("NAN","login");
  }

?>