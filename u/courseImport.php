<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
$page = "courseImport";

?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Import Sections | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/css-home.css"> -->
  <!-- customize css -->
  <link rel="stylesheet" type="text/css" href="assets/css/hideAndNext.css">
  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href="assets/css/css-navAndSlide.css">
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
    session_start();

    require 'includes/navAndSide.php';
    unset($_FILES);

    require '../vendor/autoload.php';
    require '../include/config.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
    <!-- nav bar & side bar -->


    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Import Sections</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Import Sections</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- <div class="content-header"> -->
      <!-- Main content -->
      <section class="content"><br>
        <!-- <div class="box span12"> -->
        <div class="row">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-1">&nbsp</div>

              <div class="col-lg-10">
                <div class="card card-secondary">

                  <div class="card-header">

                    <h3 class="card-title" style="font-size: 28px;">Import via Excel Template</h3>
                    <div class="card-tools">
                      <!-- Buttons, labels, and many other things can be placed here! -->
                      <!-- Here is a label for example -->
                      <a href="tmp/Section Template.xls" class="badge badge-warning " style="color: black; font-size: 18px;">Download Template</a>

                    </div>
                  </div>
                  <!-- form start -->
                  <form role="form" method="post" action="courseImport.inc.php" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputFile">.xls / .xlsx</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="ASD" id="excelFile">
                            <label class="custom-file-label" for="exampleInputFile" id="excelFileLabel">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <button type="submit" name="excelUpload" class="input-group-text" id="">Upload</button>
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
              <div class="col-lg-1">&nbsp</div>
              <div class="col-lg-10">
                <!-- Default box -->
                <div class="card card-secondary">
                  <div class="card-header">

                    <h2 class="card-title" style="font-size: 32px;">List of Sections</h2>
                    <a href="?" type="button" class="btn btn-success add-button buttonDelete ">
                      <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
                    </a>&nbsp&nbsp
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" style="width: 100%;">
                    <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
                      <thead>
                        <tr>
                          <th>Section Code</th>
                          <th>Section Name</th>
                          <th>Year Level</th>
                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $sql = "select * FROM tbl_sections ";
                        $result1 = mysqli_query($conn, $sql);
                        $ctr = 0;
                        if (mysqli_num_rows($result1) > 0) {
                          while ($row = mysqli_fetch_array($result1)) {

                            $sectionCode   = $row[1];
                            $sectionName      = $row[2];
                            $sectionYearLevel         = $row[3];

                            if ($row[0] == 0) {
                              #do nothing
                            } else {
                              echo "<tr class='tRow' id='row" . $ctr . "'>";
                              echo "<td><h5>";
                              echo $row[1];
                              echo "</h5></td>";
                              echo "<td><h6>";
                              echo $row[2];
                              echo "</h6></td>";
                              echo "<td><h6>";
                              echo $row[3];
                              echo "</h6></td>";

                              echo '   <td class="text-center">';
                              echo '       <a href="#" class="btn delete iconsize btn-sm btn-danger" title="Delete" id="delete' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $row[0] . '" >';
                              echo '           <i class="fas fa-trash">';
                              echo '           </i>';
                              echo '       </a>';
                              echo '   </td>';


                              echo "</tr>";
                              $ctr++;
                            }
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
              </div>

      </section>
    </div>
    
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    <!--/row-->
  </div>
  </div>

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




  <!-- ./wrapper -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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
  <script src="includes/sessionChecker.js"></script>
  <script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
    setInterval(function() {
      sessionChecker();
    }, 20000); //time in milliseconds 

    $(document).ready(function() {
      $('#example1').DataTable({
        "scrollX": true,
      });
    });
    $(document).on("click", ".delete", function() {
      var x = $(this).attr('value');
      var row = $(this).attr('rowIdentifier');

      Swal.fire({
        title: 'Are you sure?',
        text: "All student enrolled in this section will be unset",
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
            url: "removeCourse.php",
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
  </script>


<?php require '../maintenanceChecker.php';
  ?>
</body>

</html>
<?php



if (isset($_SESSION['MESSAGE-PROMPT']) && !isset($_REQUEST['importSuccess'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("error", "Invalid Entry", $message);
  unset($_SESSION['MESSAGE-PROMPT']);
  exit(0);
} else if (isset($_SESSION['MESSAGE-PROMPT']) && isset($_REQUEST['importSuccess'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("info", "Import Details", $message);
  unset($_SESSION['MESSAGE-PROMPT']);
  exit(0);
} else if (isset($_REQUEST['sectionRequired'])) {
  $message = "You need to add section list before importing student.";
  displayMessage("warning", "Warning", $message);
  exit(0);
}
?>