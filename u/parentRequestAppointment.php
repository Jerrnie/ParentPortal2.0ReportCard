<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page = "parentRequestAppointment";

  session_start();
  $userID = $_SESSION['userID'];
  $userFname = $_SESSION['first-name'];
  $userMname = $_SESSION['middle-name'];
  $userLname = $_SESSION['last-name'];
  $userLvl = $_SESSION['usertype'];
  $userEmail = $_SESSION['userEmail'];
  $status= "";
  $disabled = 1;
  $personnelsched_Id= 0;

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

  if (isset($_GET['page'])) {

      $query = " select DAte(S.DateSchedule) as DateSchedule, S.SchedTimeFrom, S.SchedTimeTo,S.WebLink, P.Personnel_code,
                concat(P.Fname,' ', P.Mname,' ',P.Lname) as PersonnelName,P.Position, S.occupied,
                S.personnelsched_Id
                from  tbl_PersonnelSched S
                Left join tbl_Personnel P on P.Personnel_Id = S.Personnel_Id
                Left Join tbl_appointment A on A.PersonnelSched_Id = S.PersonnelSched_Id
                where Now() < DateSchedule and S.occupied = 0 and (A.status is null or A.status = '')
                and S.personnelsched_Id =".$_GET['page'];
    $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array ($result)) {
                  $DateSchedule   = $row[0];
                  $SchedTimeFrom   = $row[1];
                  $SchedTimeTo    = $row[2];
                  $WebLink      = $row[3];
                  $PersonnelCode   = $row[4];
                  $PersonnelName   = $row[5];
                  $Position      = $row[6];
                  $personnelsched_Id = $row[8];
                  //$status= $row[2];

            }
          }
    }
    else
    {
      $disabled = 1;
      header("location: parentAppointmentHistory.php");
    }
      $queryCheck = "select status from tbl_appointment where personnelsched_Id = " .$personnelsched_Id;
      $resultCheck = mysqli_query($conn,  $queryCheck);
      $disabled = 0;
      if ($resultCheck){
        if (mysqli_num_rows($resultCheck) > 0) {
          if ($row2 = mysqli_fetch_array ($resultCheck)) {
            $status= $row2[0];
          }
          if ($status== "Pending")
          {
            $disabled = 1;
          }
          else
          {
            $disabled = 0;
          }
        }
      }
      else
      {
        $disabled = 1;
        header("location: parentAppointmentHistory.php");
      }


}

else
{
  header("location: parentAppointmentHistory.php");
}



 // $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Request Appointment | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

  <link rel="stylesheet" href="../include/plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" type="text/css" href="assets/css/css-home.css">
    <!-- daterange picker -->
  <link rel="stylesheet" href="../include/plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="../include/plugins/fontawesome-free/css/all.min.css">
  <!-- sweet alert -->
  <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="../include/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../include/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../include/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../include/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../include/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../include/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../include/dist/css/adminlte.min.css">





  <style type="text/css">
    .small-box{
       box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- nav bar & side bar -->
<?php
require 'includes/navAndSide2.php';
require 'sendText.php';
?>
<!-- nav bar & side bar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">


<div class="container-fluid ">
    <!-- Main content -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="parentViewPersonnelSched.php">View Personnel Schedule</a></li>
              <li class="breadcrumb-item active">Request for Appointment</li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 style="font-size: 30px;" class="card-title">
              Request for Appointment
                <!-- <small></small> -->
              </h3>
              <!-- tools box -->
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body pad">
              <form method="POST"  >
                  <div class="row">

                    <div class="col-lg-3">
                        <div class="form-group">
                          <label class="unrequired-field">Date</label>
                          <input disabled="true" value="<?php echo $DateSchedule?>"
                          name="pcode" type="date" class="form-control" placeholder="">


                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                          <label class="unrequired-field">Start Time</label>
                          <input disabled="true" value="<?php echo $SchedTimeFrom ?>"
                          name="fname" id="fname" type="time" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                          <label class="unrequired-field">End Time</label>
                          <input disabled="true" value="<?php echo $SchedTimeTo  ?>"
                          name="fname" id="fname" type="time" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                          <label class="unrequired-field">Medium to be Used</label>
                          <input disabled="true" value="<?php echo $WebLink  ?>"
                          name="DateTimeRequested" id="DateTimeRequested" type="text" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                  </div>


                  <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Personnel Name</label>
                              <input disabled="true" value="<?php echo $PersonnelName  ?>"
                              name="ParentName" id="ParentName" type="text" class="form-control" placeholder="">
                        </div>
                      </div>
                      <div class="col-lg-4">
                          <div class="form-group">
                            <label class="unrequired-field">Designation</label>
                            <input disabled="true" value="<?php echo $Position  ?>"
                            name="PersonnelName" type="text" class="form-control" placeholder="">
                          </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Parent's Purpose</label>
                          <input autocomplete="off" value="<?php if (isset($_POST['RequestRemarks'])) { echo htmlentities($_POST['RequestRemarks']); } ?>" 
                          id="RequestRemarks" name="RequestRemarks" type="text" class="form-control" oninput="lenValidation('RequestRemarks','500')" list="purpose" placeholder="">
                         
                        <datalist id="purpose" name= "purpose">
                          <option value="Visit">
                          <option value="Payment">
                          <option value="Meeting">
                        </datalist>

                        </div>
                      </div>
                  </div>


                </div>
                  <footer class="card-footer ">
                  <a style ="float:right;" href="parentViewPersonnelSched.php" class="btn btn-danger"   >
                  Cancel
                  </a>
                  <button type="submit"  <?php if ($disabled == 1){ ?> disabled <?php   } ?> class="btn btn-success float-right" name="Request" style ="float:right; margin-right: 10px;">Submit</button>
                  <!-- <button type="submit"  class="btn btn-danger float-left" name="Cancel">Cancel</button> -->

                  </footer>
              </div>

              </form>

            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
  </div>

</div>

  </div>
  <!-- /.content-wrapper -->


<?php

require 'assets/scripts.php';

if (isset($_POST['Request'])) {
  //$_POST['title'] = mysqli_real_escape_string($conn, stripcslashes($_POST['title']));
    
  $nowtime = date("Y-m-d H:i:s");
  $_POST['RequestRemarks'] = mysqli_real_escape_string($conn, stripcslashes($_POST['RequestRemarks']));
  $remarks = html_entity_decode(htmlspecialchars_decode($_POST['RequestRemarks']));

  if ($status == "Approved" || $status =="Denied" || $status =="Pending")
  {
    $disabled = 1;
    header('Location: parentAppointmentHistory.php');
    displayMessage("warning","Request Already Submitted ","warning!");
  }
//  // $endTime = $_POST['TimeEnd'];
  else{
    $nowtime = date("Y-m-d H:i:s");

    $nowtime1 = date("Y-m-d H:i:s");

    $sql1 = "Insert into tbl_appointment
		(
			PersonnelSched_Id,ParentId,RequestRemarks,
    DateTimeRequested,status,ApprovedUserID,approvedDateTime,schoolYearID
		)
		VALUES
		(
      '".$personnelsched_Id."',
      '".$userID."',
      '".$remarks."',
      '".$nowtime."',
      'Pending',
      '$userID',
      '".$nowtime1."',
      '" . $schoolYearID . "'
    )";

    mysqli_query($conn, $sql1);

    $sql2 = mysqli_query($conn, "UPDATE tbl_PersonnelSched
    SET occupied = '1'
    WHERE PersonnelSched_Id = '".$personnelsched_Id."'");

    $disabled = 1;

    $sql3 = "sELECT a.fullName FROM tbl_parentuser AS a WHERE a.userID = '" . $userID . "' AND a.schoolYearID = '" . $schoolYearID . "' ORDER BY a.userID DESC ";

    $result = mysqli_query($conn, $sql3);
    $pass_row = mysqli_fetch_assoc($result);
    $parentName = $pass_row['fullName'];

    $sql4 = "sELECT b.Mobile FROM tbl_PersonnelSched AS a,tbl_Personnel AS b WHERE a.Personnel_Id =b.Personnel_Id AND a.PersonnelSched_Id = '" . $personnelsched_Id . "' AND a.schoolYearID = '" . $schoolYearID . "'";

    $result = mysqli_query($conn, $sql4);
    $pass_row = mysqli_fetch_assoc($result);
    $mobile = $pass_row['Mobile'];

    $Mobile = $mobile;
$newmessage= 'You have a pending appointment to '.$parentName.'.

Here are the details of appointment request.

Date: '.date_format(date_create($DateSchedule), "M d, Y").'
Time: '.date_format(date_create($SchedTimeFrom), "h:i A"). '-' .date_format(date_create($SchedTimeTo), "h:i A").'
Reason: '.$remarks.'.
- '.SCHOOL_ABV.' ';
$crypted = password_hash($resetpass, PASSWORD_DEFAULT);
sendOTP($newmessage,$Mobile);


    displayMessage("success","Success!" ,"Appointment request has been submitted!");
    header('Location: parentAppointmentHistory.php?ARS');

  }
}
else
{
  if (isset($_POST['DisapprovedRequest']))
  {
    // if ($status == "Approved" || $status =="Denied")
    // {
    //   displayMessage("warning","Already " .$status,"warning!");
    // }
    // else
    // {
    //   $sql1 = mysqli_query($conn, "UPDATE tbl_appointment
    //   SET
    //   status='Denied'
    //   WHERE Appoint_Id = $Appoint_Id");

    //   $disabled = 1;
    //   displayMessage("success","Denied","Success!");
    // }
  }

}


// if (isset($_POST['DisapprovedRequest'])) {

//   $startTime = $_POST['TimeFrom'];
//   $endTime = $_POST['TimeEnd'];

//   if ($startTime == $endTime) {
//     displayMessage("warning","Time Invalid","Please try again");
//   }
//   else{
//   $sql1 = mysqli_query($conn, "UPDATE tbl_PersonnelSched
//   SET
//   SchedTimeFrom='" . $_POST['TimeFrom'] . "',
//   SchedTimeTo='" . $_POST['TimeEnd'] . "',
//   WebLink='" . $_POST['weblink'] . "',
//   PostedUserID ='".$_SESSION['userID']  ."'
//   WHERE Personnel_Id = $Personnel_Id");

//   header('Location: viewPersonnel.php?updateChed&page='.$Personnel_Id);

//   }
// }

// if (isset($_REQUEST['approvedRequest'])) {
//   $disabled = 1;
//   displayMessage("success","Success","Personnel Schedule has been Update");
// }


?>
<!-- Summernote -->
<script src="../include/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Select2 -->
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
<script src="../include/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script><script>



  $(function () {


$('.textarea').summernote({
toolbar: [
  ['style', ['style']],
  ['font', ['bold', 'underline', 'clear']],
  ['fontname', ['fontname']],
  ['color', ['color']],
  ['para', ['ul', 'ol', 'paragraph']],
  ['table', ['table']],
  ['insert', ['link']],
  ['view', ['fullscreen', 'codeview', 'help']],
],
disableDragAndDrop: true

});
  })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today': [moment(), moment()],
          'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
          'Next 7 Days': [moment().add(7, 'days'), moment().add(7, 'days')],
          'Next 30 Days': [moment().add(30, 'days'), moment().add(30, 'days')],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        $('#startdate').val(start.format('MMMM D, YYYY'))
        $('#enddate').val(end.format('MMMM D, YYYY'))
      }
    )

$(document).on("click", ".delete", function() {
    var x = $(this).attr('value');

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
            url: "removePersonnel.php",
            type: "POST",
            cache: false,
            "data":
                {"personnelidx" : x},
            dataType: "html",
            success: function () {
        Swal.fire({
          title: 'Done!',
          type: 'info',
          html: 'It was succesfully deleted!',
          allowOutsideClick:false,
          allowEscapeKey: false
        }).then((result) => {document.location.href = 'viewAllPersonnel.php';});

            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error deleting!", "Please try again", "error");
            }
        });
  }
})
e.preventDefault();
});

function lenValidation(id,limit) {
	if ($("#"+id).val().length>=limit) {
		$("#"+id).val($("#"+id).val().substr(0,limit));
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
}
</script>
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
