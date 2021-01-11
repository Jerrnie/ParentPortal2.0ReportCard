<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page="viewAllPersonnel";

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
  else if ($levelCheck=='P'){
    header("location: home.php");
  }

  else if ($levelCheck=='E'){
    header("location: PersonnelHome.php");
  }

  if (isset($_GET['page'])) {

    $query = "select * from tbl_Personnel where Personnel_Id =".$_GET['page'];
      $result = mysqli_query($conn,  $query);
      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          if ($row = mysqli_fetch_array ($result)) {
            $Personnel_Id   = $row[0];
            $Personnel_code   = $row[1];
            $Position = $row[2];
            $Fname   = $row[3];
            $Mname   = $row[4];
            $Lname   = $row[5];

            $haveAccess=1;

              }
        }
        else
        {
          $haveAccess = 0; //not Found
        }
    }
    else
    {
      $haveAccess = 0; //not Found
    }
  }

  else
  {
    header("location: viewAllPersonnel.php");
  }

?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Schedule | ParentPortal</title>
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
                              <label class="unrequired-field">Code</label>
                              <input value="<?php echo $Personnel_code ?>"
                              name="code" id="code" type="text" class="form-control"  maxlength="50" placeholder="" readonly>
                            </div>
                          </div>
                   </div>

                   <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">First Name</label>
                              <input value="<?php echo $Fname,' ',$Mname,' ',$Lname ?>"
                              name="name" id="name" type="text" class="form-control"  maxlength="50" placeholder="" readonly>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Position</label>
                              <input value="<?php echo $Position ?>"
                              name="position" id="position" type="text" class="form-control" maxlength="50" placeholder="" readonly>
                            </div>
                          </div>
                   </div>

                   <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Start Date</label>
                          <input value="<?php echo isset($_POST['datesched']) ? $_POST['datesched'] : '' ?>"
                          type="date" name="datesched1" class="form-control">
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">End Date</label>
                          <input value="<?php echo isset($_POST['datesched']) ? $_POST['datesched'] : '' ?>"
                          type="date" name="datesched2" class="form-control">
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


                   </div>

                   <div class="row">

                   <div class="col-lg-8">
                            <div class="form-group">
                              <label class="unrequired-field">Medium to use</label>
                          <input type="text" name="weblink" oninput="lenValidation('weblink','100')" class="form-control" id="weblink">
                            </div>
                          </div>
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

  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];

  $newDate1 = date('Y-m-d', strtotime($_POST['datesched1']));
  $newDate2 = date('Y-m-d', strtotime($_POST['datesched2']));

  $datenow = date("Y-m-d");

  $newDatedate = date('M d, Y', strtotime($_POST['datesched']));
  $nameOfDay = date('D', strtotime($_POST['datesched']));

  $sql = "select a.* from tbl_PersonnelSched as a where Personnel_Id='" . $Personnel_Id. "'AND DateSchedule ='" . $newDate. "' AND SchedTimeFrom ='" . $startTime. "' AND SchedTimeTo ='" . $endTime. "'";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {

    displayMessage("warning","Time Start and End is already registered on $newDatedate","Invalid Entry");
  }
  else{

    $sql = "select a.* from tbl_PersonnelSched as a where Personnel_Id='" . $Personnel_Id. "'AND DateSchedule ='" . $newDate. "' AND SchedTimeFrom ='" . $startTime. "'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {

      displayMessage("warning","Time Start is already registered on $newDatedate","Invalid Entry");
    }

  else{

    $sql = "select a.* from tbl_PersonnelSched as a where Personnel_Id='" . $Personnel_Id. "'AND DateSchedule ='" . $newDate. "' AND SchedTimeTo ='" . $endTime. "'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {

      displayMessage("warning","Time End is already registered on $newDatedate","Invalid Entry");
    }
  else{

    $sql = "select a.* from tbl_PersonnelSched as a where Personnel_Id='" . $Personnel_Id. "' AND DateSchedule ='" . $newDate. "' AND SchedTimeFrom BETWEEN '$startTime' AND '$endTime' ";
    
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {

      displayMessage("warning","Time Start and End Range is already registered on $newDatedate","Invalid Entry");
    }
  else{

  if($newDate == '1970-01-01')
  {
    displayMessage("warning","Date Invalid","Please try again");
  }
  elseif($datenow > $newDate)
  {
    displayMessage("warning","Date Invalid","Please try again");
  }
  elseif ($startTime > $endTime) {
    displayMessage("warning","Time Range Invalid","Please try again");
  }
  elseif ($startTime == $endTime) {
    displayMessage("warning","Time Invalid","Please try again");
  }
  else{

    $insertQuery2 = "INSERT INTO tbl_PersonnelSched (
      Personnel_Id,
      DateSchedule,
      DaySchedule,
      SchedTimeFrom,
      SchedTimeTo,
      WebLink,
      PostedUserID,
      PostedDateTime)
    SELECT
    '".$Personnel_Id."',
    DATE_ADD('".$newDate1."', INTERVAL t.n DAY),
    '".$_POST['startTime']."',
    '".$_POST['endTime']."',
    '".$_POST['weblink']."',
    $userID,
    now()

    FROM (
        SELECT 
            a.N + b.N * 10 + c.N * 100 AS n
        FROM
            (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
           ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
           ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) c
        ORDER BY n
    ) t   
    WHERE
        t.n <= TIMESTAMPDIFF(DAY, '".$newDate1."', '".$newDate2."');";

    mysqli_query($conn, $insertQuery2);

    header('Location: addSchedule.php?addsched&page='.$Personnel_Id);
}
}
}
}
}
}
if (isset($_REQUEST['addsched'])) {
  displayMessage("success","Success","Personnel Schedule has been made");
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

</script>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds

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
<?php require '../maintenanceChecker.php';
  ?>
</body>
</html>
