<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
$page = "viewAllUser";
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
  <title>User Maintenance | Parent Portal</title>
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
              <h1>User Maintenance</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">User Maintenance</li>
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
            <div class="row">
                    <input style="width:100px;" type="submit" value="Enable" name="btnEnable" class="btn btn-success" onclick="return confirm('Are you sure?')">
                    &nbsp&nbsp&nbsp&nbsp
                    <input style="width:100px;" type="submit" value="Disable" name="btnDisable" class="text-white btn btn-warning" onclick="return confirm('Are you sure?')">
                    &nbsp&nbsp&nbsp&nbsp
                    <input style="width:100px;" type="submit" value="Delete" name="btndelete" class="btn btn-danger" onclick="return confirm('Are you sure?')">                   
            </div>  
          </div>
          
          <!-- /.card-header -->
          <div class="card-body" style="width: 100%;">
            <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>                  
                <!--<th width="5%"><input title="Select all" class="d-flex justify-content-center" type="checkbox" name="SelectAll[]" value="SelectAll" ></th> -->            
                  <th width="5%"></th>             
                  <th>Full Name</th>
                  <th width="10%">Mobile</th>
                  <th width="28%">Email</th>
                  <th width="13%">Reset password?</th>
                  <th>Action</th>                                    
                  <th width="10%">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $sql = "SELECT * FROM tbl_parentuser where usertype ='P' AND schoolYearID = '" . $schoolYearID . "' ORDER BY FIELD(resetRequest,'Yes') DESC;";
                $result1 = mysqli_query($conn, $sql);
                $ctr = 0;
                if (mysqli_num_rows($result1) > 0) {
                  while ($row = mysqli_fetch_array($result1)) {

                    $userID1   = $row[0];
                    $mobile   = $row[4];
                    $sex      = $row[5];
                    $email    = $row[6];
                    $password = $row[7];
                    $status = '';
                    $IsEnabled = $row[8];

                    echo "<tr class='tRow' id='row" . $ctr . "'>";

                    echo'<td><input class="text-center" type="checkbox" id="checkItem" name="check[]" value="'.$row['userID'].'"></td>';
                    echo "<td><h6>";
                    echo $row[15];
                    echo "</td><h6>";
                    echo "<td><h6>";
                    echo $row[4];
                    echo "</h6></td>";
                    // echo"<td><h6>";
                    //   echo $row[5];
                    // echo"</h6></td>";
                    echo "<td><h6>";
                    echo $row[6];
                    echo "</h6></td>";
                    echo "<td";
                    if ($row[13] == 'Yes') {
                      echo " style='background-color:orange; '";
                    }
                    echo "><h6>";
                    echo $row[13];
                    echo "</h6></td>";

                    echo '   <td class="text-center">';
                    echo '       <a class="btn btn-info iconsize" title="Edit Information" href="viewUser.php?page=' . $row[0] . '">';
                    echo '           <i class="fas fa-edit d-flex justify-content-center">';
                    echo '           </i>';
                    echo '           ';
                    echo '       </a>';

                    echo '        <a href="#" class="btn reset iconsize btn-dark" title="Reset Password" id="reset' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $row[0] . '" >';
                    echo '           <i class="fas fa-key d-flex justify-content-center">';
                    echo '           </i>';
                    echo '        </a>';

                    echo '       <a class="btn btn-primary iconsize" title="Payment Reminder" href="allPaymentReminder.php?page=' . $row[0] . '">';
                    echo '           <i class="fas fa-money-bill-alt d-flex justify-content-center">';
                    echo '           </i>';
                    echo '           ';
                    echo '       </a>';

                    echo '        <a href="#" class="btn delete iconsize btn-danger" title="Delete" id="delete' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $row[0] . '" >';
                    echo '           <i class="fas fa-trash d-flex justify-content-center">';
                    echo '           </i>';
                    echo '        </a>';
                    echo '   </td>';

                    // if ($row[8] == 0) {
                    //   echo '   <td class="text-center">';
                    //   echo '        <a href="#" name="yesvld" class="btn yesbtn btn-sm btn-warning" title="Enable" id="yesbtn' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $row[0] . '" >';
                    //   echo '           <i class="fas fa-check">';
                    //   echo '           </i>';
                    //   echo '           ';
                    //   echo '       </a>';
                    //   echo '   </td>';
                    // } else {
                    //   echo '   <td class="text-center">';
                    //   echo '        <a href="#" class="btn nobtn btn-sm btn-danger" title="Disable" id="nobtn' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $row[0] . '" >';
                    //   echo '           <i class="fas fa-times" style="font-size:17px;">';
                    //   echo '           </i>';
                    //   echo '           ';
                    //   echo '       </a>';
                    //   echo '   </td>';
                    // }

                   // echo'<td><input class="form-control" name="checkbox[]" type="checkbox" value="'.$row[0].'" /></td>';
                   

                    if ($row[8] == 1) {
                      echo '<td class="text-center" title="This account is enable."><h4><span class="badge badge-success" style ="font-weight: normal;">Enabled</span></h4></td>';
                      $status = '1';
                    } else {
                      echo '<td class="text-center" title="This account is disable."><h4><span class="badge badge-warning text-white" style ="font-weight: normal;">Disabled</h4></span></td>';
                    }
                    echo "</tr>";

                    $ctr++;
                  }
                } else {
                  echo "<script> swal('error'); </script>";
                }


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
    <?php 


//delete
if(isset($_POST['btndelete'])){

  
  $all = $_POST['SelectAll'];

  if(empty($all))
  {
    $checkbox = $_POST['check'];

    if(empty($checkbox))
    {
      displayMessage("warning", "No selected","Please select atleast one checkbox!");
    }
    else{

    $checkbox = $_POST['check'];

    for($i=0;$i<count($checkbox);$i++){
    $del_id = $checkbox[$i]; 
    $query = "dELETE FROM tbl_parentuser  WHERE usertype ='P' AND userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'";
    mysqli_query($conn, $query);

    $query1 = "dELETE FROM tbl_student  WHERE userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'";
    mysqli_query($conn, $query1);

    header('Location: viewAllUser.php?Delete');
    }
  }

  }
  else
  {
    
      $query = "dELETE FROM tbl_parentuser  WHERE usertype ='P' AND schoolYearID ='".$schoolYearID."'";
      mysqli_query($conn, $query);

      $query1 = "dELETE FROM tbl_student  WHERE schoolYearID ='".$schoolYearID."'";
      mysqli_query($conn, $query1);


      header('Location: viewAllUser.php?Delete');
    
  }
}

if (isset($_REQUEST['Delete'])) {
  displayMessage("success", "Done!", "It was succesfully deleted!");
}

//Enable
if(isset($_POST['btnEnable'])){
  
  $all = $_POST['SelectAll'];

  if(empty($all))
  {
    $checkbox = $_POST['check'];
      
    if(empty($checkbox))
    {
    displayMessage("warning", "No selected","Please select atleast one checkbox!");
    }
    else{

      $checkbox = $_POST['check'];
      for($i=0;$i<count($checkbox);$i++){
      $del_id = $checkbox[$i]; 

      $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='1' WHERE usertype ='P' AND userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'");
      mysqli_query($conn, $query);

      header('Location: viewAllUser.php?Enabled');
      }
    }

  }
  else
  {
      $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='1' WHERE usertype='P' AND schoolYearID ='".$schoolYearID."'");
      mysqli_query($conn, $query);

      header('Location: viewAllUser.php?Enabled');
  }
}
if (isset($_REQUEST['Enabled'])) {
  displayMessage("success", "Done!", "It was succesfully enabled!");
}


//Disable
if(isset($_POST['btnDisable'])){
 
  $all = $_POST['SelectAll'];

  if(empty($all))
  {
    $checkbox = $_POST['check'];
        
    if(empty($checkbox))
    {
    displayMessage("warning", "No selected","Please select atleast one checkbox!");
    }
    else{
    $checkbox = $_POST['check'];
    for($i=0;$i<count($checkbox);$i++){
    $del_id = $checkbox[$i];
    $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='0' WHERE usertype ='P' AND userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'");
    mysqli_query($conn, $query);

    header('Location: viewAllUser.php?Disabled');
    }
  }
  }
  else
  {
      $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='0' WHERE usertype='P' AND schoolYearID ='".$schoolYearID."'");
      mysqli_query($conn, $query);
    
      header('Location: viewAllUser.php?Disabled');
  }
}

if (isset($_REQUEST['Disabled'])) {
  displayMessage("success", "Done!", "It was succesfully disabled!");
}

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

  /*  function do_this(){ 

  var checkboxes = document.getElementsByName('approve[]');
  var button = document.getElementById('toggle');

  if(button.value == 'select'){
      for (var i in checkboxes){
          checkboxes[i].checked = 'FALSE';
      }
      button.value = 'deselect'
  }else{
      for (var i in checkboxes){
          checkboxes[i].checked = '';
      }
      button.value = 'select';
  }
  } */
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
      "columnDefs": [{ 'orderable': false, 'targets': 0 }],
    });
  });

  $(document).ready(function() {
    $('.yearselect').select2();
  });
  $(document).on("click", ".yesbtn", function() {

    var x = $(this).attr('value');
    var row = $(this).attr('rowIdentifier');


    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, enable it!'
    }).then((result) => {

      if (result.value) {

        swal.fire({
          title: 'Please Wait..!',
          text: 'Enabled..',
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          onOpen: () => {
            swal.showLoading()
          }
        })
        $.ajax({
          url: "userEnable.php",
          type: "POST",
          cache: false,
          "data": {
            "studentidx": x
          },
          dataType: "html",
          success: function() {
            location.reload(true);
            swal.fire("Done!", "It was succesfully enabled!", "success");
          },
          error: function(xhr, ajaxOptions, thrownError) {
            swal.fire("Error Enabling!", "Please try again", "error");
          }
        });
      }
    })
    e.preventDefault();
  });
  $(document).on("click", ".reset", function() {
    var x = $(this).attr('value');
    var row = $(this).attr('rowIdentifier');

    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, reset password!'
    }).then((result) => {

      if (result.value) {

        swal.fire({
          title: 'Please Wait..!',
          text: 'Reset password..',
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          onOpen: () => {
            swal.showLoading()
          }
        })
        $.ajax({
          url: "resetPassword.php",
          type: "POST",
          cache: false,
          "data": {
            "studentidx": x
          },
          dataType: "html",
          success: function() {
            swal.fire("Done!", "Password has been successfully reset!", "success");

          },
          error: function(xhr, ajaxOptions, thrownError) {
            swal.fire("Error reset password!", "Please try again", "error");
          }
        });
      }
    })
    e.preventDefault();
  });

  $(document).on("click", ".nobtn", function() {
    var x = $(this).attr('value');
    var row = $(this).attr('rowIdentifier');

    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, disable it!'
    }).then((result) => {

      if (result.value) {

        swal.fire({
          title: 'Please Wait..!',
          text: 'Disabled..',
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          onOpen: () => {
            swal.showLoading()
          }
        })
        $.ajax({
          url: "userDisabled.php",
          type: "POST",
          cache: false,
          "data": {
            "studentidx": x
          },
          dataType: "html",
          success: function() {
            location.reload(true);
            swal.fire("Done!", "It was succesfully disabled!", "success");
          },
          error: function(xhr, ajaxOptions, thrownError) {
            swal.fire("Error Disabling!", "Please try again", "error");
          }
        });
      }
    })
    e.preventDefault();
  });
  
  $(document).on("click", ".delete", function() {
      var x = $(this).attr('value');
      var row = $(this).attr('rowIdentifier');

      Swal.fire({
        title: 'Are you sure? ',
        text: "The information you want to delete have existing transaction. Deleted record(s) cannot be restored.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

        if (result.value) {

          swal.fire({
            title: 'Please Wait..!',
            text: 'Deleting..',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            onOpen: () => {
              swal.showLoading()
            }
          })
          $.ajax({
            url: "removeUser.php",
            type: "POST",
            cache: false,
            "data": {
              "studentidx": x
            },
            dataType: "html",
            success: function() {
              swal.fire("Done!", "It was succesfully deleted!", "success");
              $("#" + row).css({
                "background-color": "#FACFCB"
              }, "slow").delay(200).animate({
                opacity: "hide"
              }, "slow");
            },
            error: function(xhr, ajaxOptions, thrownError) {
              swal.fire("Error deleted!", "Please try again", "error");
            }
          });
        }
      })
      e.preventDefault();
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