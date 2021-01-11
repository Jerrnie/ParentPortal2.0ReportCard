<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
$page = "PersonnelAttendance";
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
} else if ($levelCheck == 'A') {
  header("location: index.php");
} else if ($levelCheck == 'P') {
  header("location: home.php");
} else if ($levelCheck == 'S') {
  header("location: index.php");
}

$sql = "sELECT  a.Personnel_code  FROM tbl_Personnel AS a , tbl_parentuser AS b where b.pID = a.Personnel_Id AND b.userID = " . $user_check . " LIMIT 1";
$result1 = mysqli_query($conn, $sql);
$ctr = 0;
if (mysqli_num_rows($result1) > 0) {
  $row = mysqli_fetch_array($result1);
  $pID = $row[0];
}


?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Attendance | Parent Portal</title>
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
    require 'includes/navAndSide3.php';
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Attendance</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="PersonnelHome.php">Home</a></li>
                <li class="breadcrumb-item active">Attendance</li>
              </ol>
            </div>
          </div>


          <br>
          <form action="PersonnelAttendance.php" method="POST">

            <div class="row font-weight-bold" style="margin-left:57px;">
              <div id="date" name="date2">
                <?php echo date('M d, Y'); ?>
              </div>
              &nbsp&nbsp&nbsp&nbsp&nbsp
              <div id="time">
              </div>
            </div>
            <?php

            $datenow = date('Y-m-d');

            $sql1 = "SELECT a.isTimeIn FROM tbl_Attendance AS a,tbl_Personnel as b WHERE a.StudentId = b.Personnel_Code AND b.Personnel_Code='" . $pID . "' AND a.schoolYearID = '" . $schoolYearID . "' AND a.TimePunch LIKE '$datenow%' ORDER BY a.Attendance_ID DESC LIMIT 1";
            $result = mysqli_query($conn, $sql1);
            $pass_row = mysqli_fetch_assoc($result);
            $isTimeIn = isset($pass_row['isTimeIn']) ? $pass_row['isTimeIn'] : 0;

            if ($isTimeIn == '2' || $isTimeIn == 0) {

              echo ' <div class="col-lg-3">';
              echo ' <div class="form-group">';
              echo ' <button type="submit" name="submitTimeIn" class="btn form-control btn-success">';
              echo ' <span class=" far fa-clock">&nbsp&nbsp</span><b>TIME IN<b>';
              echo ' </button>';
              echo ' </div>';
              echo ' </div>';
            } else {

              echo ' <div class="col-lg-3">';
              echo ' <div class="form-group">';
              echo ' <button type="submit" name="submitTimeOut" class="btn form-control btn-danger">';
              echo ' <span class=" far fa-clock">&nbsp&nbsp</span><b>TIME OUT<b>';
              echo ' </button>';
              echo ' </div>';
              echo ' </div>';
            }

            ?>

          </form>
        </div>
        <!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <div class="row mb-1">
              <div class="col-sm-3">
                <label class="unrequired-field">Date From:</label>
                <div class="input-group">

                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input placeholder="MM/DD/YYYY" name="from_date" id="from_date" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
              </div>

              <div class="col-sm-4">
                <label class="unrequired-field">Date To:</label>
                <div class="input-group">

                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input placeholder="MM/DD/YYYY" name="to_date" id="to_date" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  &nbsp&nbsp &nbsp&nbsp
                  <div class="col-xm-6">
                    <button type="button" name="filter" id="filter" value="filter" class="btn btn-info">
                      <span class=" fa fa-search">&nbsp&nbsp</span>Search
                    </button>
                  </div>
                  &nbsp&nbsp
                  <!-- <button type="submit" name="btn-export" class="btn btn-primary add-button">
                      <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export
                    </button> -->
                </div>
              </div>
            </div>

            <p>
              <a href="?" type="button" class="btn btn-success add-button buttonDelete ">
                <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
              </a>&nbsp&nbsp
              <input type="text" name="pid" id="pid" value="<?php echo $pID ?>" hidden></input>

            </p>
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="width: 100%;">
            <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>
                  <th>Date and Time</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $sql = "SELECT * FROM tbl_Attendance
          WHERE StudentId ='" . $pID . "' AND isStudent='2' AND schoolYearID = '" . $schoolYearID . "' ORDER BY TimePunch DESC";
                $result1 = mysqli_query($conn, $sql);
                $ctr = 0;
                if (mysqli_num_rows($result1) > 0) {
                  while ($row = mysqli_fetch_array($result1)) {

                    $TimeIN   = date_format(date_create($row[2]), "M d, Y h:i A");

                    $Mode = $row[3];

                    echo "<tr class='tRow' id='row" . $ctr . "'>";

                    echo '<td class="text-center"><h4><span class="badge" style="font-weight:normal;">';
                    echo $TimeIN;
                    echo '</span></h4></td><h5>';
                    if ('1' == $row[3]) {
                      echo '<td class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-success">TIME IN</span></h4></td>';
                    } elseif ('2' == $row[3]) {
                      echo '<td class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-danger">TIME OUT</span></h4></td>';
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
  </div>

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

    <?php

    if (isset($_POST['submitTimeIn'])) {

      $datenow1 = date('Y/m/d H:i:s');

      $insertQuery = "Insert into tbl_Attendance
  (
  StudentId,
  TimePunch,
  Mode,
  Gateway,
  IsTimeIN,
  isStudent,
  schoolYearID
  )
  VALUES
  (
  '" . $pID . "',
  '" . $datenow1 . "',
  '1',
  'STANDARD',
  '1',
  '2',
  '" . $schoolYearID . "'
  )";
      mysqli_query($conn, $insertQuery);

      $checkRecord = mysqli_query($conn, "SELECT Fname, Mname, Lname FROM tbl_Personnel WHERE Personnel_code = '" . $pID . "' AND schoolYearID = '" . $schoolYearID . "'");
      $result = mysqli_fetch_assoc($checkRecord);
      $empfname = $result['Fname'];
      $empmname = $result['Mname'];
      $emplname = $result['Lname'];

      $date = date('Y-m-d H:i:s');
      $insertauditQuery = "Insert into tbl_SEaudittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values ('" . $pID . "', '" .  $empfname  . "', '" .  $emplname  . "', 'Personnel ' '" .  $empfname . " ' '" .  $empmname  . " ' '" .  $emplname  . " ' 'Time in on ' '" . $datenow1 . "', '$date','" . $schoolYearID . "')";
      mysqli_query($conn, $insertauditQuery);

      header('Location: PersonnelAttendance.php?TimeIN');
    }

    if (isset($_REQUEST['TimeIN'])) {
      displayMessage("success", "Success", "TIME IN has been made");
    }
    ?>
    <?php

    if (isset($_POST['submitTimeOut'])) {

      $datenow1 = date('Y/m/d H:i:s');

      $insertQuery = "Insert into tbl_Attendance
  (
  StudentId,
  TimePunch,
  Mode,
  Gateway,
  IsTimeIN,
  isStudent,
  schoolYearID
  )
  VALUES
  (
  '" . $pID . "',
  '" . $datenow1 . "',
  '2',
  'STANDARD',
  '2',
  '2',
  '" . $schoolYearID . "'
  )";
      mysqli_query($conn, $insertQuery);

      $checkRecord = mysqli_query($conn, "SELECT Fname, Mname, Lname FROM tbl_Personnel WHERE Personnel_code = '" . $pID . "' AND schoolYearID = '" . $schoolYearID . "'");
      $result = mysqli_fetch_assoc($checkRecord);
      $empfname = $result['Fname'];
      $empmname = $result['Mname'];
      $emplname = $result['Lname'];

      $date = date('Y-m-d H:i:s');
      $insertauditQuery = "Insert into tbl_SEaudittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values ('" . $pID . "', '" .  $empfname  . "', '" .  $emplname  . "', 'Personnel ' '" .  $empfname . " ' '" .  $empmname  . " ' '" .  $emplname  . " ' 'Time out on ' '" . $datenow1 . "', '$date','" . $schoolYearID . "')";
      mysqli_query($conn, $insertauditQuery);

      header('Location: PersonnelAttendance.php?TimeOUT');
    }

    if (isset($_REQUEST['TimeOUT'])) {
      displayMessage("success", "Success", "Time OUT has been made");
    }
    ?>

</body>
<script type="text/javascript">
  $(document).ready(function() {
    setInterval(function() {
      $('#time').load('time.php')
    }, 1000);
  });

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


  $(document).ready(function() {
    $('.yearselect').select2();
  });
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
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false,
      "sorting": [],
      "info": false,

    });
  });
  $.extend($.fn.dataTable.defaults, {
    searching: false,
  });

  $(document).ready(function() {
    $('.yearselect').select2();
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

  $('#filter').click(function() {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var pid = $('#pid').val();
    if (from_date != '' && to_date != '') {
      $.ajax({
        url: "AttendancePersonnel2Filter.php",
        method: "POST",
        data: {
          from_date: from_date,
          to_date: to_date,
          pid: pid
        },
        success: function(data) {
          $('#example1').html(data);
        }
      });
    } else {
      alert("Please Select Specific Date");
    }
  });
</script>

</html>
<?php require '../maintenanceChecker.php';
?>