<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
// require 'assets/scripts/phpfunctions.php';
require '../assets/phpfunctions.php';
  $page="PersonnelSettings";

// $_SESSION['userID']
// $_SESSION['first-name']
// $_SESSION['middle-name']
// $_SESSION['last-name']
// $_SESSION['usertype']
// $_SESSION['userEmail']
// $_SESSION['schoolID']
// $_SESSION['userType']
// $_SESSION['gender']
// $_SESSION['mobile']

  session_start();

  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];

  $pID = $_SESSION['pID'];

  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../login.php");
  }
  else if ($levelCheck=='A'){
    header("location: index.php"); 
  }
  else if ($levelCheck=='P'){
    header("location: home.php");
  }
  else if ($levelCheck == 'S') {
      header("location: index.php");
  }
    $query = "select a.*,b.password,b.sqAnswer,b.sqID,b.userID,b.isSecQuestions,b.email FROM tbl_Personnel AS a INNER JOIN tbl_parentuser AS b ON a.Personnel_Id = b.pID where userID ='".$user_check."'";
      $result = mysqli_query($conn,  $query);
      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          if ($row = mysqli_fetch_array ($result)) {
            $Personnel_Id = $row[0];
           $Personnel_code = $row[1];
           $Position = $row[2];
           $Fname = $row[3];
           $Mname = $row[4];
           $Lname = $row[5];
           $Mobile = $row[6];
           $userPass = $row[12];
           $sqAnswer = $row[13];
           $sqID = $row[14];
           $userID = $row[15];
           $isSecQuestions = $row[16];
           $email = $row[17];
          }
        }
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
  <title>Settings | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

  <link rel="stylesheet" type="text/css" href="assets/css/css-home.css">
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

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- nav bar & side bar -->
<?php
require 'includes/navAndSide3.php';
?>
<!-- nav bar & side bar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Account Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Account Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title"><?php echo "Edit Information"?></h5>
<form action="" method="POST" >
<br>

<div class="row">
          <div class="col-lg-5">
            <div class="form-group">
              <input value="<?php echo $Personnel_code  ?>"
                name="pcode" type="text" class="form-control" maxlength="60" id="pcode" readonly>
            </div>
          </div>
          </div>

        <div class="row">
          <div class="col-lg-5">
            <div class="form-group">
              <input value="<?php echo $Fname  ?>"
                name="first-name"required type="text" class="form-control textOnly" maxlength="60" placeholder="First Name" id="firstname">
            </div>
          </div>

          <div class="col-lg-5">
            <div class="form-group">
              <input value="<?php echo $Lname ?>"
                name="last-name"required type="text" class="form-control textOnly" maxlength="60" placeholder="Last Name" id="lastname">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-10">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                   <span class="input-group-text"><i class="fas fa-mobile" style="width: 14px;"> </i></span>
                </div>
                <input value="<?php echo $Mobile ?>"
                name="numberSignup"  type="text" class=" form-control" placeholder="Mobile Number" required="true" data-inputmask='"mask": "0\\999-999-9999    "' data-mask id="accountmobilenumber">
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-10">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-envelope" style="width: 14px;"></i></span>
                </div>
                <input value="<?php echo $email ?>" name="email" type="email" maxlength="50" class="input thisNumber form-control" id="exampleInputEmail1" placeholder="Email Address" required="true">
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
                <input name="pass1" type="password" class="input form-control" required="true" maxlength="50" placeholder="Enter current password" id="currentpassword">
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-10">
            <div class="form-group clearfix" >
              <label class="genderform">Gender</label><br>

              <div class="icheck-primary d-inline">
                  <input <?php if(strtolower(trim($_SESSION['gender']))==="female") echo 'checked'; ?>
                  value="female" type="radio" id="radioPrimary2" name="r1" checked>
                  <label for="radioPrimary2">Female
                  </label>
              </div>&nbsp

              <div class="icheck-primary d-inline">
                 <input <?php if(strtolower(trim($_SESSION['gender']))==="male") echo 'checked'; ?>
                 value="male" type="radio" id="radioPrimary1" name="r1" >
                 <label for="radioPrimary1">Male
                 </label>
              </div>

            </div>
          </div>
        </div>

              </div> <div class="card-footer"> <button class="btn btn-primary"
name="editThis" value="editThis" type="submit">Save</button> </form> </div>
</div><!-- /.card -->

</div>
        <div class="col-lg-6">
<div class="card card-danger card-outline">
              <div class="card-body">
                <h5 class="card-title"><?php echo "Change Password"?></h5>
<form action="" method="post" >
<br>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                </div>
                <input name="epassO" type="password" class="input form-control" maxlength="50" required="true" placeholder="Enter current password" id="ecp">
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
                <input name="epass1" type="password" class="input form-control" maxlength="50" required="true" placeholder="Enter new password" id="enp">
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                </div>
                <input name="epass2" type="password" class="input form-control" maxlength="50" required="true" placeholder="Re-type new password" id="rnp">
              </div>
            </div>
          </div>
        </div>
                      </div> <div class="card-footer"> <button class="btn btn-primary"
name="editPass" value="editPass" type="submit">Save</button> </form> </div>
</div><!-- /.card -->
</form>

<div class="card card-danger card-outline">
              <div class="card-body">
                <h5 class="card-title"><?php echo "Change Security Question"?></h5>

<form action="" method="post" >
<br>

                          <div class="row">

                            <div class="col-lg-12">

                               <div class="form-group">
                                 <select name="question" class="form-control select2bs4">

<?php
          $sql = "select * FROM tbl_securityquestions";
           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){
                  if($sqID==$row[0]){$selected = " selected ";}else{$selected="";}
                  echo '<option value="'.$row[0].'" '.$selected.' >'.$row[1].'</option>';
                }
              }
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
                              <input autocomplete="off" name="answer" type="text" class="input thisNumber form-control" maxlength="100" id="sa" id="exampleInputEmail1" placeholder="Security answer" required="true">
                           </div>
                         </div>
                       </div>
                     </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                </div>
                <input name="qpass1" type="password" class="input form-control" required="true" maxlength="50" placeholder="Enter current password" id="ecp2">
              </div>
            </div>
          </div>
        </div>
                      </div> <div class="card-footer"> <button class="btn btn-primary"
name="editQuestion" value="editPass" type="submit">Save</button> </form> </div>
</div><!-- /.card -->
</form>
</div>
</div>

</div>
        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
      <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    </div>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

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

<script>

$(document).ready(function() {
    $('#example1').DataTable( {
        "scrollX": true,
    } );
} );

$(document).ready(function() {
    $('.yearselect').select2();
});
$(document).on("click", ".delete", function() {
    var x = $(this).attr('value');
    var row = $(this).attr('rowIdentifier');

Swal.fire({
  title: 'Are you sure?',
  text: "Deleted record(s) cannot be restored.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
        $.ajax({
            url: "remove.php",
            type: "POST",
            cache: false,
            "data":
                {"studentidx" : x},
            dataType: "html",
            success: function () {
                swal.fire("Done!", "It was succesfully deleted!", "success");
                $("#"+row).css({ "background-color": "#FACFCB"},"slow").delay( 200 ).animate({ opacity: "hide" }, "slow");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error deleting!", "Please try again", "error");
            }
        });
  }
})
});

$(document).on("click", ".submit", function() {
    var x = $(this).attr('value');
    var badge = $(this).attr('badgeIdentifier');
    var ctr = $(this).attr('ctrIdentifier');

Swal.fire({
  title: 'Are you sure?',
  text: "After submission you can't revert or edit your form",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Submit my registration!'
}).then((result) => {
  if (result.value) {
        $.ajax({
            url: "submit.php",
            type: "POST",
            cache: false,
            "data":
                {"studentidx" : x},
            dataType: "html",
            success: function () {
                $("#"+badge).addClass('badge-info').removeClass('badge-danger').text('Submitted') ;
                $("#delete"+ctr).delay( 100 ).animate({ opacity: "hide" }, "slow");
                $("#submit"+ctr).delay( 100 ).animate({ opacity: "hide" }, "slow");
                $("#view"+ctr).text('View') ;

                swal.fire("Submitted", "It was succesfully stored to the database!", "success");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error submitting!", "Please try again", "error");
            }
        });
  }
})
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


// validations





      //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Initialize Select2 Elements
    $('.select2bs4').select2()

    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })

    $('[data-mask]').inputmask()


$(document).ready(function() {
    $('.yearselect').select2();
});


$( "#firstname" ).on('input', function() {
if ($(this).val().length>=60) {
  const toast = swal.mixin({
  toast: true,
  position: 'bottom-end',
  showConfirmButton: false,
  timer: 3000 });
  toast.fire({
  type: 'warning',
  title: 'The maximum number of characters has been reached!'
  });
  }
  });

  $( "#lastname" ).on('input', function() {
  if ($(this).val().length>=60) {
    const toast = swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000 });
    toast.fire({
    type: 'warning',
    title: 'The maximum number of characters has been reached!'
    });
    }
    });

    $( "#exampleInputEmail1" ).on('input', function() {
    if ($(this).val().length>=50) {
      const toast = swal.mixin({
      toast: true,
      position: 'bottom-end',
      showConfirmButton: false,
      timer: 3000 });
      toast.fire({
      type: 'warning',
      title: 'The maximum number of characters has been reached!'
      });
      }
      });

      $( "#currentpassword" ).on('input', function() {
      if ($(this).val().length>=50) {
        const toast = swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000 });
        toast.fire({
        type: 'warning',
        title: 'The maximum number of characters has been reached!'
        });
        }
        });

        $( "#ecp" ).on('input', function() {
        if ($(this).val().length>=50) {
          const toast = swal.mixin({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 3000 });
          toast.fire({
          type: 'warning',
          title: 'The maximum number of characters has been reached!'
          });
          }
          });

          $( "#enp" ).on('input', function() {
          if ($(this).val().length>=50) {
            const toast = swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000 });
            toast.fire({
            type: 'warning',
            title: 'The maximum number of characters has been reached!'
            });
            }
            });

            $( "#rnp" ).on('input', function() {
            if ($(this).val().length>=50) {
              const toast = swal.mixin({
              toast: true,
              position: 'bottom-end',
              showConfirmButton: false,
              timer: 3000 });
              toast.fire({
              type: 'warning',
              title: 'The maximum number of characters has been reached!'
              });
              }
              });

              $( "#sa" ).on('input', function() {
              if ($(this).val().length>=100) {
                const toast = swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000 });
                toast.fire({
                type: 'warning',
                title: 'The maximum number of characters has been reached!'
                });
                }
                });

                $( "#ecp2" ).on('input', function() {
                if ($(this).val().length>=50) {
                  const toast = swal.mixin({
                  toast: true,
                  position: 'bottom-end',
                  showConfirmButton: false,
                  timer: 3000 });
                  toast.fire({
                  type: 'warning',
                  title: 'The maximum number of characters has been reached!'
                  });
                  }
                  });

                  $( "#accountmobilenumber" ).on('input', function() {
                  if (this.value.replace(/[_-]/g, '').length >=15 ) {
                    const toast = swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000 });
                  toast.fire({
                    type: 'warning',
                    title: 'The maximum number of characters has been reached!'
                  });
                  }
                  });

</script>
<?php
if (isset($_POST['editQuestion'])) {
  $chkpass = password_verify($_POST['qpass1'], $userPass);
  if (!$chkpass) {
        $message = "Incorrect Password";
        $title = "Invalid Entry";
        $type = "error";
        header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);
    }
  else{
            $insertQuery = "update tbl_parentuser
set
sqID = '" . $_POST['question'] . "',
sqAnswer = '" . $_POST['answer'] . "',
isSecQuestions = '2'
where userID ='".$_SESSION['userID']."'

";
            mysqli_query($conn, $insertQuery);
            $message = "Security question has been changed";
            $title = "Success";
            $type = "success";
            header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);
  }

}

if (isset($_POST['editPass'])) {
   $chkpass = password_verify($_POST['epassO'], $userPass);
  if (!$chkpass) {
        $message = "Incorrect Password";
        $title = "Invalid Entry";
        $type = "error";
        header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);
    }
  elseif ($_POST['epass1']!=$_POST['epass2']){
    $message = "Password mismatch";
    $title = "Invalid Entry";
    $type = "error";
    header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);
  }
  else{


  $errorMessage = 'Password must have ';
  $hasError = 0; 
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
    header('Location: PersonnelSettings.php?forgotNumber='.$forgotNumber.'&forgotpass=true&passwordRequirementFailed');
    exit(1);
  }


            $insertQuery = "update tbl_parentuser
set
password = '" . password_hash($_POST['epass1'], PASSWORD_DEFAULT) . "',
isReset = '0'
where userID ='".$_SESSION['userID']."'

";

 $_SESSION['userPass']   = password_hash($_POST['epass1'], PASSWORD_DEFAULT);

            mysqli_query($conn, $insertQuery);
            session_destroy();
            header('Location: ../login.php?cps');
  }

}
if (isset($_POST['editThis'])) {
  $chkpass = password_verify($_POST['pass1'], $userPass);
    if (strlen(cleanThis($_POST['numberSignup'])) < 11) {
        $message = "Mobile number is invalid";
        $title = "Invalid Entry";
        $type = "error";
        header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);
    } elseif (!$chkpass) {
        $message = "Incorrect Password";
        $title = "Invalid Entry";
        $type = "error";
        header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);
    }
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $message = "Email is invalid";
        $title = "Invalid Entry";
        $type = "error";
        header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);
    }

    else {
        $notEdited = false;
        $_POST['first-name']   = mysqli_real_escape_string($conn, stripcslashes($_POST['first-name']));
        $_POST['last-name']    = mysqli_real_escape_string($conn, stripcslashes($_POST['last-name']));
        $_POST['email']        = mysqli_real_escape_string($conn, stripcslashes($_POST['email']));
        $_POST['numberSignup'] = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['numberSignup'])));
        $_POST['pass1']        = mysqli_real_escape_string($conn, stripcslashes($_POST['pass1']));
        if (isset($_POST['r1'])) {
            if ($_POST['r1'] == "male") {
                $gender = "Male";
                ;
            } else {
                $gender = "Female";
            }

        }
        if ($_POST['numberSignup'] == $_SESSION['mobile']) {
          $notEdited = true;
        }
        $sql = "select a.* from tbl_parentuser as a where mobile='" . $_POST['numberSignup'] . "'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0 && !$notEdited) {

            $message = "Registered, Phone number hasn't change";
            $title = "Invalid Entry";
            $type = "error";
            header('Location: PersonnelSettings.php?title='.$title.'&type='.$type.'&message='.$message);

        } else {


            $insertQuery = "update tbl_Personnel
set
Fname = '" . $_POST['first-name'] . "',
Lname = '" . $_POST['last-name'] . "',
Mobile = '" . $_POST['numberSignup'] . "'
where Personnel_Id ='".$Personnel_Id."'

";

mysqli_query($conn, $insertQuery);

$Fname = $_POST['first-name'];
$Lname = $_POST['last-name'];

$insertQuery1 = "UPDATE tbl_parentuser
set
fname = '" . $_POST['first-name'] . "',
lname = '" . $_POST['last-name'] . "',
mobile = '" . $_POST['numberSignup'] . "',
sex = '$gender',
email = '" . $_POST['email'] . "',
isEnabled = '1',
fullName = CONCAT('$Fname',' ','$Lname')
where userID ='".$_SESSION['userID']."'

";
            mysqli_query($conn, $insertQuery1);

            $_SESSION['mobile']     = $_POST['numberSignup'];
            $_SESSION['userEmail']  = $_POST['email'];
            $_SESSION['gender']    = $gender;
            
            session_destroy();
            header('Location: ../login.php?cms');

        }


    }
}

if (isset($_REQUEST['EditSuccess'])) {
    echo "<script>";
    echo "Swal.fire({";
    echo "html: 'Edit Success',";
    echo "type: 'success',";
    echo "title: 'Success',";
    echo "showConfirmButton: false,";
    echo "timer: 2700,";
    echo "customClass: 'swal-sm'";
    echo "});";
    echo "$('#exampleModalCenter').modal('show');</script>";

}
if (isset($_REQUEST['ChangeSuccess'])) {
    echo "<script>";
    echo "Swal.fire({";
    echo "html: 'Password Changed',";
    echo "type: 'success',";
    echo "title: 'Success',";
    echo "showConfirmButton: false,";
    echo "timer: 2700,";
    echo "customClass: 'swal-sm'";
    echo "});";
    echo "$('#exampleModalCenter').modal('show');</script>";

}
if (isset($_GET['message'])) {
  displayMessage($_GET['type'], $_GET['title'], $_GET['message']);
}

if (isset($_SESSION['MESSAGE-PROMPT'])&&isset($_REQUEST['passwordRequirementFailed'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("error","Invalid Entry",$message);
  unset($_SESSION['MESSAGE-PROMPT']);
}

?>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds
</script>
<?php require '../maintenanceChecker.php';
  ?>
</body>
</html>
