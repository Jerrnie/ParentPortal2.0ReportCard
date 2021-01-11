<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';

$page = "personnelAddSchedule";
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
$pID = $_SESSION['pID'];

$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
if (!isset($user_check) && !isset($password_check)) {
  session_destroy();
  header("location: ../login.php");
} else if ($levelCheck == 'A') {
  header("location: index.php");
} else if ($levelCheck == 'P') {
  header("location: home.php");
}
else if ($levelCheck == 'S') {
    header("location: index.php");
}


  $query = "select * from tbl_Personnel where Personnel_Id =".$pID;
    $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array ($result)) {
                  $Personnel_Id   = $row[0];
                  $Personnel_Code        = $row[1];
                  $Fname        = $row[3];
                  $Mname         = $row[4];
                  $Lname         = $row[5];
                  $Position     = $row[2];
                  $status   = 0;
                  $haveAccess=1;

            }
      }
    }

?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Schedule | Parent Portal</title>
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

<style>
      .iconsize {
      width: 32px; 
      height: 32px;
    } 
 </style>

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
            <h1 class="m-0 text-dark">Add Schedule</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Add Schedule</li>
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
            <a href="?" type="button" class="btn btn-success add-button buttonDelete ">     <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
              </a>&nbsp&nbsp
              <a data-toggle="modal" data-target="#modal-lg" type="button" class="btn btn-primary add-button" style="color: white;">
                <span class=" fa fa-plus-square">&nbsp&nbsp</span>New Schedule
              </a>
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
                  <th>Medium to be Used</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
          <?php
          $sql = "SELECT a.PersonnelSched_Id,a.DateSchedule,a.SchedTimeFrom,
          a.SchedTimeTo,a.WebLink FROM tbl_PersonnelSched AS a
          where a.Personnel_Id ='".$pID."' 
          AND schoolYearID = '" . $schoolYearID . "'
          ORDER BY a.DateSchedule DESC";
           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){

                  $PersonnelSched_Id   = $row[0];
                  $DateSchedule   = date_format(date_create($row[1]),"M d, Y");
                  $SchedTimeFrom   = date_format(date_create($row[2]),"h:i A");
                  $SchedTimeTo   = date_format(date_create($row[3]),"h:i A");
                  $WebLink   = $row[4];
                  $status='';

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
                  echo $row[4];
                  echo"</h6></td>";

                    echo'   <td class="text-center">';
                    echo'       <a class="btn btn-primary iconsize btn-sm" title="Edit" href="EditSchedule.php?page='.$row[0].'">';
                    echo'           <i class="fas fa-pencil-alt">';
                    echo'           </i>';
                    echo'           ';
                    echo'       </a>';
                    echo'        <a href="#" class="btn delete iconsize btn-sm btn-danger" title="Delete" id="delete'.$ctr.'" rowIdentifier="row'.$ctr.'"  value="'.$row[0].'" >';
                    echo'           <i class="fas fa-trash">';
                    echo'           </i>';
                    echo'       </a>';
                    echo'   </td>';

          echo"</tr>";
                    $ctr++;

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
  </div>

    <!-- ./wrapper -->

      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Schedule Form</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div><form action="" method="POST">
            <div class="modal-body">
                   <div class="row" hidden>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Personnel Name</label>
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
                          <label class="required-field" >Date range button:</label>
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
                          <input required="true" value="<?php if(isset($_POST['DateSchedule'])){echo $_POST['datesched'];} ?>" type="text" name="datesched1" class="form-control" readonly="true" id="datesched1">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">End Date</label>
                          <input required="true" value="<?php if(isset($_POST['DateSchedule'])){echo $_POST['datesched'];} ?>" type="text" name="datesched2" class="form-control" readonly="true" id="datesched2">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                    <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Start Time</label>
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

<div class="col-lg-8">
         <div class="form-group">
           <label class="unrequired-field">Medium to be Used</label>
       <input type="text" name="weblink" oninput="lenValidation('weblink','100')" class="form-control" id="weblink">
         </div>
       </div>


            </div>
            <div class="modal-footer">
              <button type="Submit" class="btn btn-primary float-right" name="addSchedule">Add</button>
              <button type="button" class="btn btn-default float-right" style="margin-left:10px;" data-dismiss="modal">Close</button>

            </div></form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
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

      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Tomorrow': [ moment().add(1, 'days'),moment().add(1, 'days')],
            'Next 7 Days': [moment().add(7, 'days'), moment().add(7, 'days')],
            'Next 30 Days': [moment().add(30, 'days'), moment().add(30, 'days')],
          },
          startDate: moment().subtract(1, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          $('#datesched1').val(start.format('MMMM D, YYYY'))
          $('#datesched2').val(end.format('MMMM D, YYYY'))
        }
      )

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
  // validations
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
      "order": [],
    });
  });

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
            url: "removeSchedule.php",
            type: "POST",
            cache: false,
            "data":
                {"personnelidx" : x},
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

</html>

<?php
if (isset($_POST['addSchedule'])) {
  echo "<script>$('#summernote').summernote('codeview.toggle');</script>";

  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];

  $newDate1 = date('Y-m-d', strtotime($_POST['datesched1']));
  $newDate2 = date('Y-m-d', strtotime($_POST['datesched2']));

  $datenow = date("Y-m-d");

  $datenow2 = date("Y-m-d H:i:s");


  
  $sql = "SELECT a.* from tbl_PersonnelSched AS a WHERE Personnel_Id='" . $Personnel_Id. "' AND (DateSchedule BETWEEN '" . $newDate1. "' AND '" . $newDate2. "') AND SchedTimeFrom ='" . $startTime. "' AND SchedTimeTo ='" . $endTime. "' AND schoolYearID = '" . $schoolYearID . "'";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {

    displayMessage("warning","Time Start and End is already registered","Invalid Entry");
  }
  else{

    $sql = "select a.* from tbl_PersonnelSched as a where Personnel_Id='" . $Personnel_Id. "' AND (DateSchedule BETWEEN '" . $newDate1. "' AND '" . $newDate2. "') AND SchedTimeFrom ='" . $startTime. "' AND schoolYearID = '" . $schoolYearID . "'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {

      displayMessage("warning","Time Start is already registered","Invalid Entry");
    }

  else{

    $sql = "select a.* from tbl_PersonnelSched as a where Personnel_Id='" . $Personnel_Id. "' AND (DateSchedule BETWEEN '" . $newDate1. "' AND '" . $newDate2. "') AND SchedTimeTo ='" . $endTime. "' AND schoolYearID = '" . $schoolYearID . "'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {

      displayMessage("warning","Time End is already registered","Invalid Entry");
    }
  else{

    $sql = "select a.* from tbl_PersonnelSched as a where Personnel_Id='" . $Personnel_Id. "' AND (DateSchedule BETWEEN '" . $newDate1. "' AND '" . $newDate2. "') AND schoolYearID = '" . $schoolYearID . "' AND SchedTimeFrom BETWEEN '$startTime' AND '$endTime' ";
    
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {

      displayMessage("warning","Time Start and End Range is already registered","Invalid Entry");
    }
  else{

  if($newDate1 == '1970-01-01')
  {
    displayMessage("warning","Start Date Invalid","Please try again");
  }
  if($newDate2 == '1970-01-01')
  {
    displayMessage("warning","End Date Invalid","Please try again");
  }
  elseif($newDate1 > $newDate2)
  {
    displayMessage("warning","Date Range Invalid","Please try again");
  }
  elseif ($startTime > $endTime) {
    displayMessage("warning","Time Range Invalid","Please try again");
  }
  elseif ($startTime == $endTime) {
    displayMessage("warning","Time Invalid","Please try again");
  }
  else{

    $insertQuery2 = "INSERT INTO tbl_PersonnelSched (
      DateSchedule,
      Personnel_Id,
      SchedTimeFrom,
      SchedTimeTo,
      WebLink,
      PostedUserID,
      PostedDateTime,
      schoolYearID)
    SELECT
    DATE_ADD('".$newDate1."', INTERVAL t.n DAY),
    '".$Personnel_Id."',
    '".$_POST['startTime']."',
    '".$_POST['endTime']."',
    '".$_POST['weblink']."',
    '".$userID."',
    '".$datenow2."',
    '" . $schoolYearID . "'

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


    header('Location: personnelAddSchedule.php?addSched');
  }
}
}
}
}
}

if (isset($_REQUEST['addSched'])) {
  displayMessage("success","Success","Schedule has been added");
}

?>
