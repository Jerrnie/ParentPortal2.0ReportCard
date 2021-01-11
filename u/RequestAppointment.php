<!DOCTYPE html>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/adminlte.php';
  require '../include/config.php';
  $page = "RequestAppointment";
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


  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../index.php");
  }

  else if ($levelCheck=='A'){
    header("location: index.php"); 
  }
  else if ($levelCheck=='E'){
    header("location: PersonnelHome.php");
  }
  else if ($levelCheck == 'S') {
      header("location: index.php");
  }

?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Request Appointment | Parent Portal </title>
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
        require 'includes/navAndSide2.php';
        ?>
<!-- nav bar & side bar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Request Appointment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Request Appointment</li>
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
                </a>&nbsp&nbsp
             </p>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="width: 100%;">
              <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Start Time</th>
                  <th>End Time</th>                           
                  <th>Student Name</th>
                  <th>Personnel Name</th>
                  <th>Designation</th>               
                  <th>Medium to be Used</th>          
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
          <?php 

          /* $sql = "SELECT DISTINCT G.Personnel_code, CONCAT(G.Lname,', ',G.Fname,' ', G.Mname) AS PersonnelName,G.Position, E.occupied,
          E.personnelsched_Id, E.DateSchedule,E.SchedTimeTo,E.SchedTimeFrom,E.WebLink ,D.sectionName,D.sectionYearLevel,
          A.sectionID,A.Personnel_Id FROM tbl_PersonnelSection AS A, tbl_student AS B,tbl_parentuser AS C,tbl_sections AS D,
          tbl_PersonnelSched AS E,tbl_appointment AS F,tbl_Personnel AS G WHERE A.Personnel_Id = E.Personnel_Id 
          AND E.Personnel_Id = G.Personnel_Id AND A.sectionID = B.sectionID AND D.sectionID = B.sectionID 
          AND B.userID = '".$user_check."' AND NOW() < E.DateSchedule AND E.occupied = 0 AND E.schoolYearID = '" . $schoolYearID . "' ORDER BY E.DateSchedule"; */

          $sql ="SELECT CONCAT(D.Lname,', ',D.Fname,' ',D.Mname) AS PersonnelName, D.Position, 
          C.DateSchedule,C.SchedTimeFrom,C.SchedTimeTo,C.WebLink,C.RequestAppoint_Id,A.AttendAppoint_Id,
          CONCAT(B.lastName,', ',B.firstName,' ',B.middleName) AS StudentName,A.ReadTag
          FROM tbl_ParentAttendAppointment A
          JOIN tbl_student B ON B.studentID = A.studentID
          INNER JOIN tbl_PersonnelRequestAppointment C ON C.RequestAppoint_Id = A.RequestAppointment_Id
          INNER JOIN tbl_Personnel D ON D.Personnel_Id = C.Personnel_Id
          WHERE A.Status ='1' AND B.userID = '".$user_check."' AND C.DateSchedule >= CAST(NOW() AS DATE) 
          AND C.schoolYearID = '" . $schoolYearID . "' ORDER BY C.DateSchedule";
          
          $result1 = mysqli_query($conn, $sql);

            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){

                  $DateSchedule   = $row[2];
                  $DateSchedule=date_create($row[2]);
                  //$DateSchedule = date('m/d/Y');
                  $DateSchedule = date_format($DateSchedule, 'm/d/Y');
                  //$SchedTimeFrom   = $row[1];
                  $SchedTimeFrom = date_format(date_create($row[3]), 'h:i A');
                  //$SchedTimeTo    = $row[2];
                  $SchedTimeTo = date_format(date_create($row[4]), 'h:i A');
                  $Weblink       = $row[5];                  
                  $PersonnelName   = $row[0];
                  $Position  = $row[1];
                  $RequestAppoint = $row[6];
                  $AttendAppointId = $row[7];
                  $StudentName = $row[8];
                  $ReadTag = $row[9];

          if($ReadTag == "1"){
          echo"<tr class='tRow' id='row".$ctr."' style='background-color:#ebebeb;'>";
                
                  echo"<td><h6>";
                  echo $DateSchedule;
                  echo"</td><h6>";
                  echo"<td><h6>";
                   echo $SchedTimeFrom;
                   echo"</td><h6>";
                  echo"<td><h6>";
                   echo $SchedTimeTo;
                   echo"</td><h6>";               
                  echo"<td><h6>";
                  echo $StudentName;
                 echo"</h6></td>";
                  echo"<td><h6>";
                  echo $PersonnelName;
                  echo"</h6></td>";
                  echo"<td><h6>";
                  echo $Position;
                  echo"</h6></td>";
                  echo"<td><h6>";
                    echo $Weblink;
                  echo"</h6></td>";   
                  
                  echo'   <td class="text-center">';
                  echo'       <a class="btn btn-primary btn-sm " title="Request Appointment" href="RequestAppointmentInformation.php?page='.$row[7].'">';
                  echo'           <i class="fa fa-eye">';
                  echo'           </i>';
                  echo'           ';
                  echo'       </a>';
                  echo'   </td>';

          echo"</tr>";
                    $ctr++;
                  }else{
                    echo"<tr class='tRow' id='row".$ctr."'>";
                
                  echo"<td><h6>";
                  echo $DateSchedule;
                  echo"</td><h6>";
                  echo"<td><h6>";
                   echo $SchedTimeFrom;
                   echo"</td><h6>";
                  echo"<td><h6>";
                   echo $SchedTimeTo;
                   echo"</td><h6>";               
                  echo"<td><h6>";
                  echo $StudentName;
                 echo"</h6></td>";
                  echo"<td><h6>";
                  echo $PersonnelName;
                  echo"</h6></td>";
                  echo"<td><h6>";
                  echo $Position;
                  echo"</h6></td>";
                  echo"<td><h6>";
                    echo $Weblink;
                  echo"</h6></td>";   
                  
                  echo'   <td class="text-center">';
                  echo'       <a class="btn btn-primary btn-sm " title="Request Appointment" href="RequestAppointmentInformation.php?page='.$row[7].'">';
                  echo'           <i class="fa fa-eye">';
                  echo'           </i>';
                  echo'           ';
                  echo'       </a>';
                  echo'   </td>';

          echo"</tr>";
                    $ctr++;
                }
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
  <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>

<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false; 
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds 
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
e.preventDefault();
});

$(document).on("click", ".reset", function() {
    var x = $(this).attr('value');
    var row = $(this).attr('rowIdentifier');

Swal.fire({
  title: 'Are you sure?',
  text: "Deleted record(s) cannot be restored.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Reset Password !'
}).then((result) => {

  if (result.value) {

            swal.fire({
                title: 'Please Wait..!',
                text: 'Reset Password..',
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
            "data": 
                {"studentidx" : x},
            dataType: "html",
            success: function () {
                swal.fire("Done!", "It was succesfully Password Reset!", "success");
                $("#"+row).css({ "background-color": "#FACFCB"},"slow").delay( 200 ).animate({ opacity: "hide" }, "slow");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error Password Reset!", "Please try again", "error");
            }
        });
  }
})
e.preventDefault();
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
</html>

<?php 


?>