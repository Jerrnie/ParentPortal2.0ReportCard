<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "exportAllStudentAttendancePerSection";
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
} else if ($levelCheck == 'P') {
  header("location: home.php");
} else if ($levelCheck == 'E') {
  header("location: PersonnelHome.php");
}

  // select box open tag
  $selectBoxOpen = "<select name='sectionYearLevel'>";
  // select box close tag
  $selectBoxClose = "</select>";
  // select box option tag
  $selectBoxOption = '';
  
  $sql = "sELECT  sectionID,sectionYearLevel,sectionName  FROM tbl_sections";
  // play with return result array
  $result = mysqli_query($conn, $sql);
   
  while($row = mysqli_fetch_array($result)){
  $selectBoxOption .="<option value = '".$row['sectionID']."'>".$row['sectionYearLevel']."-".$row['sectionName']."</option>";
  }
  // create select box tag with mysql result
  $selectBox = $selectBoxOpen.$selectBoxOption.$selectBoxClose;
  
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Student Attendance | Parent Portal</title>
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
    require 'includes/navAndSide.php';
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Export Attendance Per Section</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Export Attendance</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <form action="../include/exportAttendancereportPerSection.php" method="POST" enctype="multipart/form-data" class="noEnterOnSubmit">
          <div class="row">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-6">
              <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                            border: 2px solid gray;text-align: center">
                <div class="row mb-3">
                  <!-- criteria-->
                  <div class="col-sm-6">
                    <label class="unrequired-field">Date From:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input placeholder="MM/DD/YYYY" name="subfrom" id="subfrom" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="unrequired-field">Date To:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input placeholder="MM/DD/YYYY" name="subto" id="subto" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                    </div>
                  </div>
                </div><!-- criteria-->
                <div class="row mb-4">
                  <!-- criteria-->
                  <div class="col-sm-6">
                    <label class="unrequired-field">Section</label>
                    <div class="input-group">
                      <select  name="sectioncode"   id="sectioncode" class="form-control select2bs4 sectioncode" required="true" onchange="myfunction()">
                      <?php echo $selectBoxOption;?>
                      </select>


                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="unrequired-field">File Name</label>
                    <div class="input-group">
                      <input title="We will fill this up for you" value="<?php echo "AttendanceStudentsPerSection_" . date('Ymd') ?>" id="filenameinfo" name="filenameinfo" value="RegisteredStudentsInfo" type="text" class="form-control">
                    </div>
                  </div>
              
                </div><!-- criteria-->
                <div class="row mb-2" hidden>
                  <!-- criteria-->
                  <div class="col-lg-6">
                    <div class="icheck-primary d-inline">
                      <input onclick="ChangeFileNameStudent()" value="student" type="radio" id="radioPrimary1" name="r1" checked>
                      <label for="radioPrimary1">Students
                      </label>
                    </div>
                  </div>
                </div>
                <!-- <div class="row mb-2"> -->
                <!-- criteria-->
                <!-- <div class="col-lg-12">
                                        <label class="unrequired-field">Type :&nbsp&nbsp</label>
                                        <select name="gradelevel" id="gradelevel" onchange="ChangeFileNametoReg()">
                                            <option value="Student">Student</option>
                                            <option value="Personnel">Personnel</option>
  
                                        </select>
                                    </div> -->
                <!-- </div> -->
                <!-- criteria-->
                <div></div>
                <button type="button" name="filter" id="filter" style="float:right; margin-left:10px;"value="filter" class="btn btn-secondary">
                      <span class=" fas fa-eye">&nbsp&nbsp</span>View Report
                </button>

                  <button type="submit" name="btn-submit" class="btn btn-primary add-button">
                      <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export Report
                  </button>


              </div>
            </div>
            <div class="col-lg-3">
            </div>
          </div>
        </form>
        
<br>
<br>
        <div class="row">


<div class="col-lg-12">
          <!-- Default box -->
     <div class="card card-secondary">
      <div class="card-header bg-dark">

         <h2 class="card-title" style="font-size: 32px;">Attendance Report</h2>

      </div>
       <!-- /.card-header -->
       <div class="card-body" style="width: 100%;">
              <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
                <thead>
                <tr>
                  <th>Student Number</th>
                  <th>Name</th>
                  <th>Section and Grade Level</th>
                  <th>Date and Time</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              </div>
       <!-- /.card-body -->
     </div>
</div>
<div>
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
      setInterval(function() {
        sessionChecker();
      }, 20000); //time in milliseconds 
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
  $('#datemask2').inputmask('mm/dd/yyyy', {
    'placeholder': 'mm/dd/yyyy'
  })

  $('[data-mask]').inputmask()

  function ChangeFileNameStudent() {
    // var gradeLevel = document.getElementById('gradelevel').value;
    var today = new Date();
    var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
      String(today.getDate()).padStart(2, '0') +
      today.getFullYear();
    $("#filenameinfo").prop("value", "AttendanceStudentsPerSection_" + FinalDateStr);
  }

  function ChangeFileNamePersonnel() {
    // var gradeLevel = document.getElementById('gradelevel').value;
    var today = new Date();
    var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
      String(today.getDate()).padStart(2, '0') +
      today.getFullYear();
    $("#filenameinfo").prop("value", "AttendancePersonnel_" + FinalDateStr);
  }


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

  $.extend($.fn.dataTable.defaults, {
    searching: false,
  });

  $(document).ready(function() {
    $('#example1').DataTable({
      "scrollX": true,        
        "scrollY":       "500px",
        "scrollCollapse": true,
        "paging":         false,
        "order": [],
        "info":     false
    });
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
    var subfrom = $('#subfrom').val();
    var subto = $('#subto').val();
    var sectioncode = $('#sectioncode').val();
    if (subfrom != '' && subto != '') {
      $.ajax({
        url: "AttendancePerSectionFilter.php",
        method: "POST",
        data: {
          subfrom: subfrom,
          subto: subto,
          sectioncode: sectioncode
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

<?php


?>