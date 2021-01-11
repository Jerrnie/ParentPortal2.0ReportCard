<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page = "viewAllPersonnel";

  session_start();
  $userID = $_SESSION['userID'];

  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../login.php");
  }

  else if ($levelCheck=='P'){
    header("location: home.php"); 
  }
  else if ($levelCheck=='E'){
    header("location: PersonnelHome.php");
  }
  if (isset($_GET['page'])) {

  $query = "select * from tbl_PersonnelSched where PersonnelSched_Id =".$_GET['page'];
    $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array ($result)) {
          $PersonnelSched_Id   = $row[0];
          $Personnel_Id = $row[1];
          $DateSchedule   = $row[2];
          $SchedTimeFrom   = $row[4];
          $SchedTimeTo   = $row[5];
          $WebLink   = $row[7]; 
          $haveAccess=1;
        }
      }
    }
  }

else
{
  header("location: viewAllPersonnel.php");
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
    .Redcolor{
        color:red;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- nav bar & side bar -->
<?php
require 'includes/navAndSide.php';
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
              <li class="breadcrumb-item active">Update Schedule</li>

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
                Update Schedule
                <small></small>
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
              <form method="POST">
                    
          
                   <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Date Schedule - </label>
                              <label class="unrequired-field Redcolor"> <?php echo date_format(date_create($DateSchedule), "M d, Y") ?> </label>
                              <input name="dateSched" type="date" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                    
                    <div class="col-lg-4">
                              <div class="form-group">
                                <label class="unrequired-field">Time From - </label>
                                <label class="unrequired-field Redcolor"> <?php echo date_format(date_create($SchedTimeFrom), "h:i A")?> </label>
                                <select name="TimeFrom" class="form-control" id="TimeFrom" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()"  onblur="this.size=0;">
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
                                <option value="12:00:00">12:00 PM</option>
                                <option value="12:30:00">12:30 PM</option>
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
                                <label class="unrequired-field">Time To - </label>
                                <label class="unrequired-field Redcolor"> <?php echo date_format(date_create($SchedTimeTo), "h:i A")?>  </label>
                                <select name="TimeEnd" class="form-control" id="TimeEnd" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()"  onblur="this.size=0;">
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
                                <option value="12:00:00">12:00 PM</option>
                                <option value="12:30:00">12:30 PM</option>
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
                            
                     </div>
                     <div class="row">                            
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Medium to be used</label>
                              <input value="<?php echo $WebLink ?>" name="weblink" type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                     </div>

                      </div>               
                        <footer class="card-footer ">
                        <button name="cancelEdit" class="btn btn-danger float-right" style="margin-left:10px;">Cancel</button>
                        <button type="submit" class="btn btn-info float-right" name="updatesched">Update</button>
                        
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


<?php

require 'assets/scripts.php';

if (isset($_POST['updatesched'])) {
  
  $startTime = $_POST['TimeFrom'];
  $endTime = $_POST['TimeEnd'];
  
  $datesched = date('Y-m-d', strtotime($_POST['dateSched']));
  
  $nameOfDay = date('D', strtotime($datesched));

  $datenow = date("Y-m-d");

  if($datesched == '1970-01-01'){
    displayMessage("warning","Date Invalid","Please try again");
  }
  elseif($datenow > $datesched){
    displayMessage("warning","Date Invalid","Please try again");
  }
  elseif ($startTime > $endTime) {
    displayMessage("warning","Time Range Invalid","Please try again");
  }
  elseif ($startTime == $endTime) {
    displayMessage("warning","Time Invalid","Please try again");
  }
  else{

  $sql1 = mysqli_query($conn, "UPDATE tbl_PersonnelSched 
  SET 
  DateSchedule='".$datesched."',
  DaySchedule='".$nameOfDay."',
  SchedTimeFrom='" . $_POST['TimeFrom'] . "',
  SchedTimeTo='" . $_POST['TimeEnd'] . "',
  WebLink='" . $_POST['weblink'] . "',
  PostedUserID ='".$_SESSION['userID']  ."'
  WHERE PersonnelSched_Id = $PersonnelSched_Id");

  header('Location: viewSchedule.php?updateChed&page='.$PersonnelSched_Id);

  }
}

if (isset($_REQUEST['updateChed'])) {
  displayMessage("success","Success","Personnel Schedule has been Update");
}


if (isset($_POST['cancelEdit'])) {
  header('Location: viewAllPersonnelSched.php?Editcancel&page='.$Personnel_Id);
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
setInterval(function(){sessionChecker();}, 1000);//time in milliseconds

</script>
</body>
</html>
