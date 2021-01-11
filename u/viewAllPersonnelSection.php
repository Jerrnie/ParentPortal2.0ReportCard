<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "viewAllPersonnelSection";
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
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Import/List Sections Handled | Parent Portal</title>
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
    require 'includes/navAndSide.php';
    unset($_FILES);

    require '../vendor/autoload.php';


    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Import/List Sections Handled</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Import/List Sections Handled</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


      <!-- <div class="content-header"> -->
      <!-- Main content -->
      <!-- <div class="box span12"> -->

      <section class="content"><br>
        <div class="row">

          <div class="col-lg-1">&nbsp</div>
          <div class="col-lg-10">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title" style="font-size: 28px;">Import via Excel Template</h3>
                <div class="card-tools">
                  <!-- Buttons, labels, and many other things can be placed here! -->
                  <!-- Here is a label for example -->
                  <a href="tmp/Personnel.Section-Template.xls" class="badge badge-warning " style="color: black; font-size: 18px;">Download Template</a>
                </div>
              </div>

              <!-- form start -->
              <form role="form" method="post" action="personnelSectionImport.php" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">.xls / .xlsx</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="ASD" id="excelFile">
                        <label class="custom-file-label" for="exampleInputFile" id="excelFileLabel">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <button type="submit" onclick="showLoad()" name="excelUpload" class="input-group-text" id="">Upload</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            </form>
          </div>
      </section>


      <section class="content"><br>
        <div class="row">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">

                <div class="card card-secondary">
                  <div class="card-header">
                    <span style="font-size: 28px;">List of Sections Handled</span>
                    <a href="?" type="button" class="btn btn-success add-button buttonDelete ">
                      <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
                    </a>


                    </button>

                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" style="width: 100%;">
                    <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Section</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT a.Fname,a.Mname,a.Lname,c.sectionYearLevel,c.sectionName,b.psID FROM tbl_Personnel AS a, tbl_PersonnelSection AS b,tbl_sections as c WHERE a.Personnel_Id = b.Personnel_Id AND b.sectionID = c.sectionID AND a.schoolYearID = '" . $schoolYearID . "'";
                        $result1 = mysqli_query($conn, $sql);

                        $ctr = 0;
                        if (mysqli_num_rows($result1) > 0) {
                          while ($row = mysqli_fetch_array($result1)) {

                            $Fname   = $row[0];
                            $Mname    = $row[1];
                            $Lname    = $row[2];
                            $YearLevel   = $row[3];
                            $SectionName    = $row[4];
                            $psID    = $row[5];
                            
                            echo "<tr class='tRow' id='row" . $ctr . "'>";

                            echo "<td><h6>";
                            echo $row[2];
                            echo ", ";
                            echo $row[0];
                            echo " ";
                            echo $row[1];
                            echo "</td><h6>";
                            echo "<td><h6>";
                            echo $row[3];
                            echo "-";
                            echo $row[4];
                            echo "</h6></td>";


                            echo "</td>";
                            echo '   <td class="text-center">';
                            echo '       <a href="#" class="btn delete iconsize btn-danger" title="Delete" id="delete' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $row[5] . '" >';
                            echo '           <i class="d-flex justify-content-center fas fa-trash">';
                            echo '           </i>';
                            echo '       </a>';
                            echo '   </td>';

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
                  <!-- /.card-body -->
                </div>
      </section>
      <!-- /.content -->
    </div>

    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    <!-- /.content-wrapper -->
    <script type="text/javascript">
      var input = document.getElementById('excelFile');
      var infoArea = document.getElementById('excelFileLabel');

      input.addEventListener('change', showFileName);

      function showFileName(event) {

        // the change event gives us the input it occurred in 
        var input = event.srcElement;

        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input.files[0].name;

        // use fileName however fits your app best, i.e. add it into a div
        infoArea.textContent = 'File name: ' + fileName;
      }
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
      "order": [2],

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
          url: "removePersonnelSection.php",
          type: "POST",
          cache: false,
          "data": {
            "studentidx": x
          },
          dataType: "html",
          success: function() {
            swal.fire("Done!", "It was succesfully deleted!", "success");
            $("#" + row).css({
              "background-color": "#FACFCB"
            }, "slow").delay(200).animate({
              opacity: "hide"
            }, "slow");
          },
          error: function(xhr, ajaxOptions, thrownError) {
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


if (isset($_SESSION['failedList'])) {
  $faileds = $_SESSION['failedList'];
//   $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();

// Load an existing spreadsheet
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
$spreadsheet = $reader->load("tmp/Personnel.Section-Template.xls");

// Get the first sheet
$sheet = $spreadsheet ->getActiveSheet();

// Remove 2 rows starting from the row 2
$sheet ->removeRow(2,2);



#setting
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$sheet
    ->fromArray(
        $faileds,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );

$writer = new Xlsx($spreadsheet);
//$nowtime = date("Y-m-d H-i-s");
$filename = "ForRevision-SectionHandled.xlsx";
$writer->save("tmp/".$filename);
echo "<meta http-equiv='refresh' content='0;url=tmp/".$filename."'/>";
unset($_SESSION['failedList']);
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("info", "Import Details", $message);
  unset($_SESSION['MESSAGE-PROMPT']);
  // ignore_user_abort(true);
  //  unlink("tmp/".$filename);
  exit(0);
}


else if (isset($_SESSION['MESSAGE-PROMPT'])&&!isset($_REQUEST['importSuccess'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("error","Invalid Entry",$message);
  unset($_SESSION['MESSAGE-PROMPT']);
  exit(0);
} else if (isset($_SESSION['MESSAGE-PROMPT']) && isset($_REQUEST['importSuccess'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];

  $date = date('Y-m-d H:i:s');
  $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  
    ('" .  $user_check . "', '" .  $userFname . "', '" .  $userLname . "', 'Has uploaded an personnel sections','" . $date . "','" . $schoolYearID . "')";
  mysqli_query($conn, $insertauditQuery);

  displayMessage("info", "Import Details", $message);
  unset($_SESSION['MESSAGE-PROMPT']);
  exit(0);
}

?>

    <?php require '../maintenanceChecker.php';
    ?>