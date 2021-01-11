<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page = "RequestAppointmentInformation";

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

      $query1 = mysqli_query($conn, "UPDATE tbl_ParentAttendAppointment SET  ReadTag='2' WHERE AttendAppoint_Id='".$_GET['page']."'");
      mysqli_query($conn, $query1);
  
      $query = "SELECT DISTINCT CONCAT(D.Lname,', ',D.Fname,' ',D.Mname) AS PersonnelName,D.Position, 
      C.DateSchedule,C.SchedTimeFrom,C.SchedTimeTo,C.WebLink,C.RequestAppoint_Id,B.studentID,
      CONCAT(B.lastName,', ',B.firstName,' ',B.middleName) AS StudentName,A.AttendAppoint_Id
      FROM tbl_ParentAttendAppointment A
      JOIN tbl_student B ON B.studentID = A.studentID
      INNER JOIN tbl_parentuser E ON E.userID = B.userID
      INNER JOIN tbl_PersonnelRequestAppointment C ON C.RequestAppoint_Id = A.RequestAppointment_Id
      INNER JOIN tbl_Personnel D ON D.Personnel_Id = C.Personnel_Id
      WHERE A.AttendAppoint_Id = '".$_GET['page']."' AND E.userID = '".$user_check."' LIMIT 1";
      
    $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array ($result)) {
                  $DateSchedule   = $row[2];
                  $SchedTimeFrom   = $row[3];
                  $SchedTimeTo    = $row[4];
                  $WebLink      = $row[5];
                  $PersonnelName   = $row[0];
                  $Position      = $row[1];
                  $req_ID = $row[6];
                  $studentID = $row[7];
                  $studentName = $row[8];
                  $AttendAppointId = $row[9];
     
            }
          }
    }
  }

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
              <li class="breadcrumb-item"><a href="RequestAppointment.php">View Request Appointment</a></li>
              <li class="breadcrumb-item active">Request Appointment Details</li>

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
              Request Appointment Details
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

                    <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Date</label>
                          <input disabled="true" value="<?php echo $DateSchedule?>"
                          name="pcode" type="date" class="form-control" placeholder="">


                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Start Time</label>
                          <input disabled="true" value="<?php echo $SchedTimeFrom ?>"
                          name="fname" id="fname" type="time" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">End Time</label>
                          <input disabled="true" value="<?php echo $SchedTimeTo  ?>"
                          name="fname" id="fname" type="time" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                  </div>


                  <div class="row">
                    
                  <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Student Name</label>
                          <input disabled="true" value="<?php echo $studentName  ?>"
                          name="studentName" id="studentName" type="text" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
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
                          <label class="unrequired-field">Medium to Used</label>
                          <input disabled="true" value="<?php echo $WebLink  ?>"
                            name="Remarks" type="text" class="form-control" placeholder="">

                        </div>
                      </div>
                  </div>


                </div>
                  <footer class="card-footer ">
                  <!--<input type="submit" style="width:100px;" value="Deny" name="btnDeny" class="btn btn-danger float-right">-->
                  <a data-toggle="modal" data-target="#modal-lg" type="button" class="btn btn-danger float-right add-button" style="color: white; width:100px;">
                Deny
              </a>
                  <input type="submit" style="width:100px; margin-right: 10px;" value="Approve" name="Request1" class="btn btn-success float-right">
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
  <div class="modal fade" id="modal-lg">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Reason</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST">
            <div class="modal-body">
            <textarea type="text" name="reason" class="form-control" id="reason" placeholder="Reason" required rows="4" cols="50" ></textarea>										                  
            </div>
            <div class="modal-footer">

            <input type="submit" style="width:100px; margin-right: 10px;" value="Submit" name="Deny" class="btn btn-success float-right">
              
              <button type="button" class="btn btn-default float-right" style="width:100px; margin-left:10px;" data-dismiss="modal">Close</button>

            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<?php

require 'assets/scripts.php';

if (isset($_POST['Request1'])) {
    
    $sql2 = mysqli_query($conn, "UPDATE tbl_ParentAttendAppointment
    SET Status = '2'
    WHERE AttendAppoint_Id = '".$AttendAppointId."' AND studentID ='".$studentID."'");

 //   displayMessage("success","Success!" ,"Appointment request has been submitted!");
    header('Location: RequestAppointHistory.php?ARA');
}
if (isset($_POST['Deny'])) {
    
  $sql2 = mysqli_query($conn, "UPDATE tbl_ParentAttendAppointment
  SET Status = '4', Reason = '".$_POST['reason']."'
  WHERE AttendAppoint_Id = '".$AttendAppointId."' AND studentID ='".$studentID."'");

  //displayMessage("success","Success!" ,"Appointment request has been submitted!");
  header('Location: RequestAppointHistory.php?ARD');
}

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
