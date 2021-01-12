<!DOCTYPE html>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/adminlte.php';
  require '../include/config.php';
  $page = "viewStudent";
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

  $sqID = $_SESSION['sqID'];

  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  if(!isset($user_check) && !isset($password_check))
  {
    if ($levelCheck=='P'){
      session_destroy();
      header("location: ../index.php");
    }
    else if ($levelCheck=='E'){
      session_destroy();
      header("location: ../login.php"); 
    }
  }
  else if ($levelCheck=='A'){
    header("location: index.php"); 
  }
  else if ($levelCheck=='S'){
    header("location: index.php"); 
  }

  
  $sql = "sELECT  b.userID, a.userID  FROM tbl_student AS a INNER JOIN tbl_parentuser AS b ON a.userID = b.userID where a.userID = '".$user_check."' LIMIT 1";
  $result1 = mysqli_query($conn, $sql);
   $ctr=0;
     if (mysqli_num_rows($result1) > 0) {
       $row = mysqli_fetch_array($result1);
       $parentID = $row[0];
       }
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Student Information | Parent Portal</title>
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
if ($levelCheck=='P'){
  require 'includes/navAndSide2.php';
}
elseif ($levelCheck=='E'){
  require 'includes/navAndSide3.php';
  
  

}
?>
<!-- nav bar & side bar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Student Information</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <p>
              <a href="?" type="button" class="btn btn-success add-button buttonDelete ">
                <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
                </a>
              </p>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="width: 100%;">
              <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
                <thead>
                <tr>
                  <th>Student Code</th>
                  <th>Name</th>
                  <th>Action</th>

                </tr>
                </thead>
                <tbody>
          <?php
                $dir    = 'RC/';
                $files = scandir($dir, 1);

                $dir1    = 'SOA/';
                $files1 = scandir($dir1, 1);

                $dir2    = 'SI/';
                $files2 = scandir($dir2, 1);

            $sql = "select a.studentID,a.studentCode,a.lastName,a.firstName,middleName FROM tbl_student AS a 
            where a.userID ='".$parentID."' AND schoolYearID = '" . $schoolYearID . "' ";
           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){
                  $studentID  = $row[0];
                  $studentCode   = $row[1];
                  $lanem    = $row[2];
                  $fname    = $row[3];
                  $mname    = $row[4];
                  $name        = combineName($row[3],$row[2],$row[4]);
                  



                    $file = $studentCode;
                $matchIndex;
                $haveMatch;

                     foreach ($files as $key => $value) {
                       if (pathinfo($value, PATHINFO_FILENAME)==$file) {
                         $matchIndex = $key;
                         $haveMatch = true;
                         break;
                       }
                       else{
                        $haveMatch = false;
                       }
                     }

                $matchIndex1;
                $haveMatch1;

                     foreach ($files1 as $key => $value) {
                       if (pathinfo($value, PATHINFO_FILENAME)==$file) {
                         $matchIndex1 = $key;
                         $haveMatch1 = true;
                         break;
                       }
                       else{
                        $haveMatch1 = false;
                       }
                     }

                $matchIndex2;
                $haveMatch2;

                     foreach ($files2 as $key => $value) {
                       if (pathinfo($value, PATHINFO_FILENAME)==$file) {
                         $matchIndex2 = $key;
                         $haveMatch2 = true;
                         break;
                       }
                       else{
                        $haveMatch2 = false;
                       }
                     }




              
          echo"<tr class='tRow' id='row".$ctr."'>";
                  echo"<td><h5>";
                  echo $row[1];
                  echo"</h5></td>";
                  echo"<td><h6>";
                  echo $row[2];
                  echo", ";
                  echo $row[3];
                  echo" ";
                  echo $row[4];
                  echo"</h6></td>";
                   echo'   <td class="text-center">';


                  if ($haveMatch) {
                      echo '       <a class="btn btn-secondary iconsize btn-sm " title="View Report Card"  href="rcViewer.inc.php?page=' . $row[1] . '&name='.$name.'">';
                      echo '           <i class="fas fa-id-card">';
                      echo '           </i>';
                      echo '           <span>Report Card</span>';
                      echo '       </a>';
                  }
                  // else{
                  //     echo '       <a class="btn btn-secondary iconsize btn-sm " title="Report Card not available"  href="rcViewer.inc.php?page=' . $row[1] . '&name='.$name.'">';
                  //     echo '           <i class="fas fa-id-card">';
                  //     echo '           </i>';
                  //     echo '           <span></span>';
                  //     echo '       </a>';
                  // }
                  if ($haveMatch1) {
                      echo '       <a class="btn btn-warning iconsize btn-sm " title="View Statement of Account" href="soaViewer.inc.php?page=' . $row[1] . '&name='.$name.'">';
                      echo '           <i class="fas fa-file-invoice">';
                      echo '           </i>';
                      echo '           <span ></span>';
                      echo '       </a>';
                  }
                  if ($haveMatch2) {
                      echo '       <a class="btn btn-success iconsize btn-sm " title="View Student Profile" href="siViewer.inc.php?page=' . $row[1] . '&name='.$name.'">';
                      echo '           <i class="fas fa-user">';
                      echo '           </i>';
                      echo '           <span ></span>';
                      echo '       </a>';
                  }
                   echo'   </td>';


                  

          echo"</tr>";
                    $ctr++;
              }
            }
              else{
                echo "<script> swal('error'); </script>";
              }


          ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- ./wrapper -->
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
<script type="text/javascript">

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

</script>
<script type="text/javascript" src="assets/scripts/hideAndNext.js"></script>
<!-- FastClick -->
<script src="../include/plugins/fastclick/fastclick.js"></script>
<script>

$( "#siblings-order" ).keyup(function() {

  var orderBirth = $("#siblings-order"). val();
  if (orderBirth==1) {
    $('#checkboxPrimary1').prop('checked', true);

   }
   else{
    $('#checkboxPrimary1').prop('checked', false);

   }

});

$(document).ready(function() {
    $('#example1').DataTable( {
        "scrollX": true,
    } );
} );

$(document).ready(function() {
    $('.yearselect').select2();
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

            swal.fire({
                title: 'Please Wait..!',
                text: 'Submitting..',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                onOpen: () => {
                    swal.showLoading()
                }
            })
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
  return /^-?\d*$/.test(value); });
$(".numberOnly").inputFilter(function(value) {
  return /^\d*$/.test(value); });
$(".numberOnly2").inputFilter(function(value) {
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


</script>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false; 
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds 
</script>
</html>

<?php


?>
