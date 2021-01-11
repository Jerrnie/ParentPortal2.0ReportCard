<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../assets/phpfunctions.php';
$page = "viewAllEvents";

session_start();
$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];

if (!isset($user_check) && !isset($password_check)) {
  session_destroy();
  header("location: ../login.php");
} else if ($levelCheck == 'P') {
  header("location: home.php");
} else if ($levelCheck == 'E') {
  header("location: PersonnelHome.php");
}

if (isset($_GET['page'])) {

  $query = "select * from events where id =" . $_GET['page'];
  $result = mysqli_query($conn,  $query);
  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      if ($row = mysqli_fetch_array($result)) {
        $id   = $row[0];
        $title        = $row[1];
        $description         = $row[3];
        $start     = $row[5];
        $end   = $row[6];
      }
    }
  }
} else {
  header("location: viewAllEvents.php");
}

?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Event | Parent Portal</title>
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
    .small-box {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
                  <li class="breadcrumb-item"><a href="viewAllEvents.php">View All Events</a></li>
                  <li class="breadcrumb-item active">Edit Event</li>

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
                    Event Information
                    <small></small>
                  </h3>
                  <!-- tools box -->
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
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
                          <label class="unrequired-field">Title</label>
                          <input value="<?php echo $title  ?>" name="title" id="title" type="text" maxlenght="60" class="form-control" placeholder="" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Start Date and Time - </label>
                          <label class="unrequired-field" style="color:red"><?php echo date('M d, Y h:i a', strtotime($start)) ?></label>
                          <input name="start" id="start" type="datetime-local" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">End Date and Time - </label>
                          <label class="unrequired-field" style="color:red"><?php echo date('M d, Y h:i a', strtotime($end)) ?></label>
                          <input name="end" id="end" type="datetime-local" class="form-control">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Description</label>
                          <textarea name="description" id="description" type="text" class="form-control" required><?php echo $description; ?></textarea>
                        </div>
                      </div>
                    </div>
                    <footer class="card-footer ">
                      <a class="btn btn-danger float-right" href="viewAllEvents.php">Cancel</a>
                      <button type="submit" class="btn btn-primary float-right" style="margin-right:5px;" name="updatevent">Update</button>


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

    </div>
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
  </div>
  <!-- /.content-wrapper -->


  <?php

  require 'assets/scripts.php';

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
  <script src="../include/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <script>
    $(function() {

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
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment(), moment()],
          'Tomorrow': [moment(), moment().add(1, 'days')],
          'Next 7 Days': [moment().add(6, 'days'), moment()],
          'Next 30 Days': [moment().add(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        $('#startdate').val(start.format('MMMM D, YYYY'))
        $('#enddate').val(end.format('MMMM D, YYYY'))
      }
    )
  </script>
  <script src="includes/sessionChecker.js"></script>
  <script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
    setInterval(function() {
      sessionChecker();
    }, 20000); //time in milliseconds
  </script>
  <?php

  if (isset($_POST['updatevent'])) {


    $dateschedstart = date('Y-m-d H:i:s', strtotime($_POST['start']));
    $dateschedend = date('Y-m-d H:i:s', strtotime($_POST['end']));

    $datestart = date('Y-m-d', strtotime($_POST['start']));
    $dateend = date('Y-m-d', strtotime($_POST['end']));


    $dateschedstart2 = date('Y-m-d', strtotime($_POST['start']));
    $dateschedend2 = date('Y-m-d', strtotime($_POST['end']));

    $timestart = date('H:i:s', strtotime($_POST['start']));
    $timeend = date('H:i:s', strtotime($_POST['end']));

    if ($dateschedstart2 == '1970-01-01' && $dateschedend2 == '1970-01-01') {
      displayMessage("warning", "Date and Time Invalid", "Please try again");
    } elseif ($dateschedstart2 == '1970-01-01') {
      displayMessage("warning", "Start Date and Time Invalid", "Please try again");
    } elseif ($dateschedend2 == '1970-01-01') {
      displayMessage("warning", "End Date and Time Invalid", "Please try again");
    } elseif ($timestart == $timeend) {
      displayMessage("warning", "Time Invalid", "Please try again");
    } elseif ($timestart > $timeend) {
      displayMessage("warning", "Time Range Invalid", "Please try again");
    } elseif ($datestart > $dateend) {
      displayMessage("warning", "Date Range Invalid", "Please try again");
    } else {
      $start = date('Y/m/d H:i:s', strtotime($_POST['start']));
      $end = date('Y/m/d H:i:s', strtotime($_POST['end']));

      $title = str_replace ("'","`",$_POST['title']);
    
      $description = str_replace(array("\n", "\r", "\t", "'", "\\"), array("\\n", "\\r", "\\t", "''", "\\\\"), $_POST['description']);
  
      $query = "UPDATE events 
  SET 
  title='" . $title . "',
  description='" . $description . "',
  start='" . $start . "',
  end='" . $end . "',
  posteduserid ='" . $_SESSION['userID']  . "'
  WHERE id = $id";
      $sql1 = mysqli_query($conn, $query);


      $date = date('Y-m-d H:i:s');
      $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Edits an event entitled ' '" . $title . " ' 'valid from ' '" .  $start . " ' 'to ' '" . $end . ". ', '$date','" . $schoolYearID . "')";
      mysqli_query($conn, $insertauditQuery);

      header('Location: viewEvent.php?updateChed&page=' . $id);
    }
  }

  if (isset($_REQUEST['updateChed'])) {
    displayMessage("success", "Success", "Event has been Update");
  }


  ?>

  <?php require '../maintenanceChecker.php';
  ?>
</body>

</html>