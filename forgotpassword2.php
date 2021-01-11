<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php 
    require 'include/schoolConfig.php';
    require 'include/config.php';
    include 'include/fonts.php';
    require 'assets/phpfunctions.php';
    session_start();
    ob_start();

if (!isset($_GET['forgotpass'])) {
  header('Location: index.php?');
  exit;
}

  if (isset($_GET['forgotpass'])) {
       $forgotNumber =  cleanthis($_GET['forgotNumber']);
    
  }
  else{
    $forgotNumber =  cleanthis($_POST['forgotNumber']);
  }
          $sql = "sELECT  a.*, b.userID,  b.password,  b.sqAnswer  FROM tbl_securityquestions AS a INNER JOIN tbl_parentuser AS b ON b.sqID = a.sqID where mobile = ".$forgotNumber." && (b.usertype = 'E' OR b.usertype = 'A') LIMIT 1";
           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                $row = mysqli_fetch_array($result1);
                  $sqid = $row[0];
                  $sqq = $row[1];
                  $sqAnswer = $row[4];
                  $userID = $row[2];
                }
                else{
                  header('Location: login.php?mobilenr='.$forgotNumber);
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
  $numCheck = ", <b>$minNumberCount digit(s)</b>";
}
else{
  $numCheck = '';
}
if ($hasSpecialCharacter) {
  $scCheck =", <b>$minSpecialCharacter special character(s)</b>";
}
else{
  $scCheck ="";
}
if ($hasUpperCase) {
  $ucCheck = ", <b>$minNumberCount upper case letter(s)</b>";
}
else{
  $ucCheck ='';
}

$passReq = "The new password must have".$lenCheck.$numCheck.$ucCheck.$scCheck;
                //The password must have at least 8 characters, at least 1 digit(s), at least 1 upper case letter(s), at least 1 special character(s)

// $_SESSION['MESSAGE-PROMPT']
// passwordRequirementFailed

// if (isset($_SESSION['MESSAGE-PROMPT'])) {
//   $message = $_SESSION['MESSAGE-PROMPT'];
//   echo "$message";
//   displayMessage("info", "Import Details", $message);
//   unset($_SESSION['MESSAGE-PROMPT']);
// }



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
        <!-- InputMask -->
        <script src="include/plugins/moment/moment.min.js"></script>
        <script src="include/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>


        <title>
            <?php echo SCHOOL_ABV ."  | Parent Portal"?>
        </title>
        <link rel="shortcut icon" href="assets/imgs/favicon.ico">

<style type="text/css">
div.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>

</head>


<body>
  <div class=" main">

    <div class="row navbar" style="margin-top: 0px;">
      <div class="col-sm-8" style="padding-left: 30px;  margin-bottom: 10px;"><a href="index.php" style="color: black;">
      <img class="img-school-logo " draggable="false" src="<?php echo SCHOOL_LOGO_PATH ?>" style="border-radius: 50%; width: 70px; height: 70px; margin-top: -10px;">
      <span class="lbl-school-name"><b style="color: white; font-size:30px;"><?php echo SCHOOL_NAME; ?></a></b></span>
      </div>
    </div>

<div class="container">
  <div class="clearfix"></div>
<div class="card col-lg-8" style="margin-top: 30px;">
  <form method="post">
  <div class="card-header">
    <h1 class="card-title" style="font-size: 30px;">Change Password</h1>
    <!-- /.card-tools -->
  </div>
  <!-- /.card-header -->
  <div class="card-body">
                          <div class="row">
      
                            <div class="col-lg-12">
        
                               <div class="form-group">
                                 <select name="question" class="form-control select2bs4" disabled="true">

<?php 

                  echo '<option value="'.$sqid.'">'.$sqq.'</option>';

 ?>
                                 </select>
                               </div>
                            </div>
      
                          </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text" title="This will be use on your password reset."><i class="fas fa-question-circle primary" style="width: 14px;" ></i></span>
                              </div>
                              <input autocomplete="off" name="answer" type="text" class="input thisNumber form-control" id="exampleInputEmail1" placeholder="Security Answer" required="true">
                           </div>
                         </div>
                       </div>
                     </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                </div>
                <input name="epass1" type="password" class="input form-control" required="true" placeholder=" New Password">
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                </div>
                <input name="epass2" type="password" class="input form-control" required="true" placeholder="Re-Type New Password">
              </div>
            </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-lg-12">
            <p class="text-danger h6"><?php echo $passReq; ?></p>
          </div>
        </div>        
  </div>
  <!-- /.card-body -->
  <div class="card-footer ">
<button class="btn btn-primary float-right" type="submit"  name="passRecov">Save</button>
<a style="margin-right: 20px; color: white;" class="btn btn-danger float-right request" value="<?php echo $forgotNumber ?>"  name="passRequest" >Request reset password</a>
  </div>

</form>
  <!-- /.card-footer -->
<!-- /.card -->
              


  </div>


</body>



 <!-- jQuery -->
<script src="include/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="include/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask -->
<script src="include/plugins/moment/moment.min.js"></script>
<script src="include/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<script type="text/javascript">

    $('[data-mask]').inputmask();

$(document).on("click", ".request", function() {
    var x = $(this).attr('value');

Swal.fire({
  title: 'Are you sure?',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, I want to reset my password'
}).then((result) => {

  if (result.value) {

            swal.fire({
                title: 'Please Wait..!',
                text: 'Sending request',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                onOpen: () => {
                    swal.showLoading()
                }
            })
            $.ajax({
            url: "request.php",
            type: "POST",
            cache: false,
            "data": 
                {"studentidx" : x},
            dataType: "html",
            success: function () {
                swal.fire("Done!", "Request to reset password has been submitted for approval.", "success");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error Sending Request!", "Please try again", "error");
            }
        });
  }
})
e.preventDefault();
});

function forgotNumberValid(form) {
    var forgotNumber = form.forgotNumber.value;
    forgotNumber = forgotNumber.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
    forgotNumber = $.trim(forgotNumber);


    if (forgotNumber.length <11) {
      $(form.forgotNumber).addClass("is-invalid").removeClass("is-invalid");
      $(form.forgotNumber).attr('title', "Invalid Number");
      $(form.forgotNumber).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
      return false;
    }
  else{
    //return true;
  }

}      


function valCheck(form) {
  var question = form.question.value;
  var answer   = $.trim(form.answer.value);

  if (question=='invalid') {
    $(form.question).addClass("is-invalid").removeClass("is-valid");
    $(form.question).attr('title', "Please select a question");
    $(form.question).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    return false;
  }
  if (answer.length == 0 ) {
    $(form.answer).addClass("is-invalid").removeClass("is-valid");
    $(form.answer).attr('title', "Please answer a question");
    $(form.answer).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    return false;
  }
  else{
    return true;
  }

}

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
  return /^-?\d*$/.test(value); });
$(".numberOnly").inputFilter(function(value) {
  return /^\d*$/.test(value); });
$("#intLimitTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
$(".decimal").inputFilter(function(value) {
  return /^-?\d*[.]?\d*$/.test(value); });
$("#currencyTextBox").inputFilter(function(value) {
  return /^-?\d*[.,]?\d{0,2}$/.test(value); });
$(".textOnly").inputFilter(function(value) {
  return /^[a-z-' ']*$/i.test(value); });
$(".textOnly2").inputFilter(function(value) {
  return /^[a-z-' '-\.]*$/i.test(value); });
$("#hexTextBox").inputFilter(function(value) {
  return /^[0-9a-f]*$/i.test(value); });

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}




</script>


</html>
<?php 

if (isset($_POST['passRecov'])) {
  $errorMessage = 'Password must have ';
  $hasError = 0; 
 $sqAnswer2 = $_POST['answer'];
 $sqAnswer =  cleanData(strtolower($sqAnswer));
 $sqAnswer2 =  cleanData(strtolower(trim($sqAnswer2)));


 if (trim(strtolower($sqq))=='unset') {
   displayMessage("warning","Security question is not set","Please request a password reset on admin");
 }
 else if (strlen(trim($sqAnswer))<1) {
   displayMessage("warning","Security question is not set","Please request a password reset on admin");
 }
 else if ($sqAnswer != $sqAnswer2) {
    displayMessage("error","Invalid Entry","Security question is not right");
  } 
  elseif ($_POST['epass1']!=$_POST['epass2']){
    displayMessage("error","Invalid Entry","Password mismatch");
  }


    
  else{

  if(strlen($_POST['epass1']) < $minLength){
    $errorMessage .= $lenCheck;
    $hasError = 1;
  } 




  if($hasNumberCheck){
    if (countDigits($_POST['epass1']) < $minNumberCount) {
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
    if (countUpperCase($_POST['epass1']) < $minUpperCase) {
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
    if (countSpecialCharacter($_POST['epass1']) < $minSpecialCharacter) {
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
    header('Location: forgotpassword.php?forgotNumber='.$forgotNumber.'&forgotpass=true&passwordRequirementFailed');
    exit(1);
  }




     $_POST['answer']              = mysqli_real_escape_string($conn, stripcslashes($_POST['answer']));
     $_POST['epass1']              = password_hash(mysqli_real_escape_string($conn, stripcslashes($_POST['epass1'])), PASSWORD_DEFAULT); 

            $insertQuery = "update tbl_parentuser
set
password = '" . $_POST['epass1'] . "',
isReset = 0,
resetRequest = 'No'
where userID =".$userID."

";
     
            mysqli_query($conn, $insertQuery);
            header('Location: login.php?cps');
  }

  }

if (isset($_SESSION['MESSAGE-PROMPT'])&&isset($_REQUEST['passwordRequirementFailed'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("error","Invalid Entry",$message);
  unset($_SESSION['MESSAGE-PROMPT']);
}?>

  <?php require 'maintenanceChecker.php';
  ?>
