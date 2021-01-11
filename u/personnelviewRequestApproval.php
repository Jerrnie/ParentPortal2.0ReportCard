<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page = "personnelviewRequestApproval";

  session_start();
  $userID = $_SESSION['userID'];
  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  $status =$_GET['stat'];
  $nowtime = date("Y-m-d H:i:s");
  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../login.php");
  }
  else if ($levelCheck=='P'){
    header("location: home.php");
  }
  else if ($levelCheck=='A'){
    header("location: PersonnelHome.php");
  }

  else if ($levelCheck == 'S') {
    header("location: index.php");
}

  if (isset($_GET['page'])) {

    $query1 = mysqli_query($conn, "UPDATE tbl_appointment SET  ReadTag='2' WHERE Appoint_Id='".$_GET['page']."'");
    mysqli_query($conn, $query1);

  $query = "select A.RequestRemarks, DAte(A.DateTimeRequested) as DateTimeRequested, A.status,
              U.fullName as ParentName,U.mobile,
              DAte(S.DateSchedule) as DateSchedule, S.occupied, S.WebLink, S.SchedTimeFrom, S.SchedTimeTo,
              P.Personnel_code,
              concat(P.Fname,' ', P.Mname,' ',P.Lname) as PersonnelName,P.Position,A.Appoint_Id,A.PersonnelSched_Id
              from tbl_appointment A
              left join tbl_parentuser U on U.userID = A.ParentId
              Left join tbl_PersonnelSched S on S.PersonnelSched_Id = A.PersonnelSched_Id
              Left join tbl_Personnel P on P.Personnel_Id = S.Personnel_Id
              where A.Appoint_Id =".$_GET['page'];
              $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array ($result)) {
                  $mobile   = $row[4];
                  $DateSchedule   = $row[5];
                  $SchedTimeFrom   = $row[8];
                  $SchedTimeTo    = $row[9];
                  $ParentName    = $row[3];
                  $RequestRemarks  = $row[0];
                  $PersonnelName   = $row[11];
                  $DateTimeRequested  = $row[1];
                  $Appoint_Id = $row[13];
                  $PersonnelSched_Id = $row[14];
                  $status= $row[2];

                  if ($status== "Approved" || $status== "Denied")
                  {
                    $disabled = 1;
                  }
                  else
                  {
                    $disabled = 0;
                  }
            }
          }
        }
      }

else
{
  header("location: personnelRequestApproval.php");
}



 // $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Schedule | Parent Portal</title>
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
require 'includes/navAndSide3.php';
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
              <li class="breadcrumb-item"><a href="requestApproval.php">View Request</a></li>
              <li class="breadcrumb-item active">Approve Pending Request</li>

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
                Appointment Request Information
                <small></small>
                <?php
                if($status == 'Approved') {
                  echo '<span class="badge badge-success" >';
                  echo $status ;
                  echo '</span>';
                }
                elseif ($status == 'Denied')
                {
                  echo '<span class="badge badge-danger" >';
                  echo $status;
                  echo '</span>';
                }
                else
                {
                  echo '<span class="badge badge-warning" >';
                  echo $status;
                  echo '</span>';
                }
                ?>
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
                          <label class="unrequired-field">Date Requested</label>
                          <input disabled="true" value="<?php echo $DateTimeRequested  ?>"
                          name="DateTimeRequested" id="DateTimeRequested" type="date" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                  </div>


                  <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Parent Name</label>
                              <input disabled="true" value="<?php echo $ParentName  ?>"
                              name="ParentName" id="ParentName" type="text" class="form-control" placeholder="">
                        </div>
                      </div>
                      <!-- <div class="col-lg-4">
                          <div class="form-group">
                            <label class="unrequired-field">Personnel</label>
                            <input disabled="true" value="<?php echo $PersonnelName  ?>"
                            name="PersonnelName" type="text" class="form-control" placeholder="">
                          </div>
                      </div> -->

                      <div class="col-lg-8">
                        <div class="form-group">
                          <label class="unrequired-field">Parent's Purpose</label>
                          <input disabled="true" value="<?php echo $RequestRemarks  ?>"
                          name="RequestRemarks" type="text" class="form-control" placeholder="">
                        </div>
                      </div>
                  </div>


                </div>
                  <footer class="card-footer ">
                  <!-- <button type="submit" <?php if ($disabled == 1){ ?> disabled <?php   } ?> class="btn btn-danger float-right" style="width:100px; height:38px; margin-left:10px;" name="DisapprovedRequest">Deny</button> -->
                  <a data-toggle="modal" data-target="#modal-lg" type="button" class="btn btn-danger float-right add-button" style="color: white; width:100px; margin-left:10px;">
                Deny
              </a>
                  <button type="submit" <?php if ($disabled == 1){ ?> disabled <?php   } ?> class="btn btn-info float-right" style="width:100px; height:38px;" name="approvedRequest">Approve</button>
                  <!-- <a href="#" class="btn delete btn-sm btn-danger"   value="<?php echo $Personnel_Id?>" >
                  Deny
                  </a> -->
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

            <input type="submit" style="width:100px; margin-right: 10px;" value="Submit" name="DisapprovedRequest" class="btn btn-success float-right">
              
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

if (isset($_POST['approvedRequest'])) {

  if ($status == "Approved" || $status =="Denied")
  {
    displayMessage("warning","Already " .$status,"warning!");
  }
 // $endTime = $_POST['TimeEnd'];
  else{
    $sql1 = mysqli_query($conn, "UPDATE tbl_appointment
    SET
    status='Approved',
    ApprovedUserId = '".$userID."',
    approvedDateTime = '".$nowtime."',
    ReadTag = '3'
    WHERE Appoint_Id = '".$Appoint_Id."'");

    $sql2 = mysqli_query($conn, "UPDATE tbl_PersonnelSched
    SET
    occupied = '1',    
    WHERE PersonnelSched_Id = '".$PersonnelSched_Id."'");

$Mobile = $mobile;
$newmessage= 'Your appointment request with '.$PersonnelName.' has been APPROVED.

Here are the details of your appointment.

Date: '.date_format(date_create($DateSchedule), "M d, Y").'
Time: '.date_format(date_create($SchedTimeFrom), "h:i A"). '-' .date_format(date_create($SchedTimeTo), "h:i A").'
Reason: '.$RequestRemarks.'.
- '.SCHOOL_ABV.' ';
$crypted = password_hash($resetpass, PASSWORD_DEFAULT);
sendOTP($newmessage,$Mobile);


    $disabled = 1;
   displayMessage("success","Approved","Success!");

   header('Location: personnelRequestAppointmentHistory.php?ARA');
  }
}
else
{
  if (isset($_POST['DisapprovedRequest']))
  {
    if ($status == "Approved" || $status =="Denied")
    {
      displayMessage("warning","Already " .$status,"warning!");
    }
    else
    {
      $sql1 = mysqli_query($conn, "UPDATE tbl_appointment
      SET
      status='Denied',
      ApprovedUserId = '".$userID."',
      approvedDateTime = '".$nowtime."',
      Reason = '".$_POST['reason']."',
      ReadTag = '3'    
      WHERE Appoint_Id = '".$Appoint_Id."'");

      $sql2 = mysqli_query($conn, "UPDATE tbl_PersonnelSched
      SET
      occupied = '0',
      status = '2'
      WHERE PersonnelSched_Id = '".$PersonnelSched_Id."'");

    $Mobile = $mobile;
    $newmessage= 'Your appointment request with '.$PersonnelName.' has been DISAPPROVED.

Reason: '.$_POST['reason'].'.
    - '.SCHOOL_ABV.'';
    $crypted = password_hash($resetpass, PASSWORD_DEFAULT);
    sendOTP($newmessage,$Mobile);

      $disabled = 1;
      displayMessage("success","Denied","Request has been denied!");

      header('Location: personnelRequestAppointmentHistory.php?ARD');
    }
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
        'Tomorrow': [moment(), moment().add(1, 'days')],
        'Next 7 Days': [moment().add(6, 'days'), moment()],
        'Next 30 Days': [moment().add(29, 'days'), moment()],
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
