<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page="addSchedulePersonnel";


// $_SESSION['userID']
// $_SESSION['first-name']
// $_SESSION['middle-name']
// $_SESSION['last-name']
// $_SESSION['usertype']
// $_SESSION['userEmail']
// $_SESSION['schoolID']
// $_SESSION['userType']

  session_start();
  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../index.php");
  }
  else if ($levelCheck=='P'){
    header("location: home.php");
  }

  else if ($levelCheck=='E'){
    header("location: PersonnelHome.php");
  }



 // $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Personnel Schedule | Parent Portal</title>
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
require 'includes/navAndSide.php';
?>
<!-- nav bar & side bar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">


<div class="container-fluid ">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <div class="card-title" style="font-size: 30px;">
                Add Personnel Schedule
                <small></small>
              </div>
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
              <form  method="post">

                  <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Subject</label>
                              <input value="<?php echo isset($_POST['subject']) ? $_POST['subject'] : '' ?>"
                              name="subject" id="subject" type="text" class="form-control"  maxlength="50" placeholder="">
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Title</label>
                              <input value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"
                              name="title" id="title" type="text" class="form-control" maxlength="50" placeholder="">
                            </div>
                          </div>
                   </div>

                   <div class="row">
                    <div class="col-lg-4">
                <div class="form-group">
                  <label>Date range button:</label>

                  <div class="input-group">
                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                      <i class="far fa-calendar-alt"></i> Date range picker
                      <i class="fas fa-caret-down"></i>
                    </button>
                  </div>
                </div>
                </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Start Date</label>
                          <input type="text" name="startdate" class="form-control" readonly="true" id="startdate">
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">End Date</label>
                          <input type="text" name="enddate" class="form-control" readonly="true" id="enddate">
                            </div>
                          </div>

                   </div>





                   <div class="row">
                    <div class="col-lg-4">
                    <div class="form-group">
                  <label>Start Time</label>

                  <div class="input-group">
                  <select name="startTime" class="form-control" id="startTime" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()"  onblur="this.size=0;">
                                <option value="07:00:00">7:00 AM</option>
                                <option value="07:30:00">7:30 AM</option>
                                <option value="08:00:00">8:00 AM</option>
                                <option value="08:30:00">8:30 AM</option>
                                <option value="09:00:00">9:00 AM</option>
                                <option value="09:30:00">9:30 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="10:30:00">10:30 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="11:30:00">11:30 AM</option>
                                <option value="12:00:00">12:00 AM</option>
                                <option value="12:30:00">12:30 AM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="13:30:00">1:30 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="14:30:00">2:30 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="16:30:00">3:30 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="16:30:00">4:30 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                                <option value="17:30:00">5:30 PM</option>
                                <option value="18:00:00">6:00 PM</option>
                                <option value="18:30:00">6:30 PM</option>
                                <option value="19:00:00">7:00 PM</option>
                                <option value="19:30:00">7:30 PM</option>
                                <option value="20:00:00">8:00 PM</option>
                              </select>
                </div>
                </div>

                </div>


                <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">End Time</label>
                              <select name="endTime" class="form-control" id="endTime" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()"  onblur="this.size=0;">
                                <option value="07:00:00">7:00 AM</option>
                                <option value="07:30:00">7:30 AM</option>
                                <option value="08:00:00">8:00 AM</option>
                                <option value="08:30:00">8:30 AM</option>
                                <option value="09:00:00">9:00 AM</option>
                                <option value="09:30:00">9:30 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="10:30:00">10:30 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="11:30:00">11:30 AM</option>
                                <option value="12:00:00">12:00 AM</option>
                                <option value="12:30:00">12:30 AM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="13:30:00">1:30 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="14:30:00">2:30 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="16:30:00">3:30 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="16:30:00">4:30 PM</option>
                                <option value="16:00:00">5:00 PM</option>
                                <option value="17:30:00">5:30 PM</option>
                                <option value="18:00:00">6:00 PM</option>
                                <option value="18:30:00">6:30 PM</option>
                                <option value="19:00:00">7:00 PM</option>
                                <option value="19:30:00">7:30 PM</option>
                                <option value="20:00:00">8:00 PM</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Slot:</label>
                          <input type="text" name="slot" class="form-control" id="slot">
                            </div>
                          </div>

                   </div>







              <div class="mb-3">
              <label>Description</label>

                <textarea value="" name="htmlcode" class="textarea"
                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if(isset($_POST['htmlcode'])){
                  echo htmlentities($_POST['htmlcode']);
                }
                ?></textarea>
              </div>
              <button type="submit" class="btn btn-primary float-right" name="gothis">Create</button>
              </form>

            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->

</div>

  </div>
  <!-- /.content-wrapper -->


<?php

require 'assets/scripts.php';

if (isset($_POST['gothis'])) {
  echo "<script>$('#summernote').summernote('codeview.toggle');</script>";

  $_POST['subject'] = mysqli_real_escape_string($conn, stripcslashes($_POST['subject']));
  $_POST['title'] = mysqli_real_escape_string($conn, stripcslashes($_POST['title']));
  $_POST['slot'] = mysqli_real_escape_string($conn, stripcslashes($_POST['slot']));

  $_POST['startdate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['startdate']));
  $_POST['enddate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['enddate']));
  $newDateStart = date('Y-m-d', strtotime($_POST['startdate']));
  $newDateEnd = date('Y-m-d', strtotime($_POST['enddate']));

  $_POST['endTime'] = mysqli_real_escape_string($conn, stripcslashes($_POST['endTime']));
  $_POST['startTime'] = mysqli_real_escape_string($conn, stripcslashes($_POST['startTime']));

  $_POST['htmlcode'] = mysqli_real_escape_string($conn, stripcslashes($_POST['htmlcode']));
    $htmlcode = htmlentities(htmlspecialchars($_POST['htmlcode']));
    //echo html_entity_decode(htmlspecialchars_decode($htmlcode));
  if (strlen(trim($_POST['startdate']))<3) {
    displayMessage("warning","Range Date Invalid","Please try again");
  }
  else{
 $insertQuery = "Insert into tbl_appointment
 (
 Subject,
 Title,
 htmlcode,
 slot,
 dateCreated,
 dateEnd,
 dateStart,
 timeEnd,
 timeStart,
 userID
 )
 VALUES
 (
  '".$_POST['subject'] ."',
  '".$_POST['title']."',
  '".$htmlcode."',
  '".$_POST['slot']."',
  now(),
  '".$newDateEnd."',
  '".$newDateStart."',
  '".$_POST['endTime'] ."',
  '".$_POST['startTime']."',
  '".$_SESSION['userID']  ."'
 )";
mysqli_query($conn, $insertQuery);
header('Location: addAppointment.php?AppointmentCreated');
  }
}
if (isset($_REQUEST['AppointmentCreated'])) {
  displayMessage("success","Success","Appointment has been made");
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

    $( "#title" ).on('input', function() {
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

      $( "#subject" ).on('input', function() {
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
