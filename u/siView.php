<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
$page = "siView";
// require 'assets/scripts/phpfunctions.php';
require '../assets/phpfunctions.php';
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
  <title>Student Profile | Parent Portal</title>
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


  <style type="text/css">
    #loading {
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      position: fixed;
      display: block;
      opacity: 0.7;
      background-color: #fff;
      z-index: 99;
      text-align: center;
    }

    #loading-image {
      position: absolute;
      top: 40%;
      left: 40%;
      z-index: 100;

    }
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
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Student Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Student Profile</li>
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
              <a href="?" type="button" class="btn btn-success add-button buttonDelete ">
                <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
              </a>&nbsp&nbsp
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
                <span class=" fa fa-plus-square">&nbsp&nbsp</span>Single Upload

              </button>

              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".bd-example-modal-lg2">
                <span class=" fa fa-plus-square">&nbsp&nbsp</span>Batch Upload

              </button>
            </p>
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="width: 100%;">
            <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>
                  <th>Student Code</th>
                  <th>Name</th>
                  <th>Section</th>
                  <th>Year Level</th>
                  <th>Action</th>

                </tr>
              </thead>
              <tbody>
                <?php

                $dir1    = 'SI/';
                $files1 = scandir($dir1, 1);

                $sql = "sELECT a.studentID, a.studentCode, a.firstName, a.middleName, a.lastName, b.sectionName, b.sectionYearLevel FROM tbl_student AS a INNER JOIN tbl_sections AS b ON a.sectionID = b.sectionID  inner join tbl_parentuser as c on a.userid = c.userid  where a.schoolYearID = ".$schoolYearID." ORDER BY a.lastName,a.firstName ASC";
                $result1 = mysqli_query($conn, $sql);
                $ctr = 0;
                if (mysqli_num_rows($result1) > 0) {
                  while ($row = mysqli_fetch_array($result1)) {

                    $studentID   = $row[0];
                    $studentCode = $row[1];
                    $name        = ucwords(combineName($row[2], $row[4], $row[3]));;
                    $sectionName   = $row[5];
                    $yearLevel     = $row[6];
                    $file = $studentCode;


                    $matchIndex1;
                    $haveMatch1;

                    foreach ($files1 as $key => $value) {
                      if (pathinfo($value, PATHINFO_FILENAME) == $file) {
                        $matchIndex1 = $key;
                        $haveMatch1 = true;
                        break;
                      } else {
                        $haveMatch1 = false;
                      }
                    }

                    $status = '';

                    echo "<tr class='tRow' id='row" . $ctr . "'>";
                    echo "<td><h5>";
                    echo $studentCode;
                    echo "</h5></td>";
                    echo "<td><h6>";
                    echo $name;
                    echo "</h6></td>";

                    if ($sectionName == 'unset') {
                      echo "<td><h6>";
                      echo "NOT SET";
                      echo "</h6></td>";
                      echo "<td><h6>";
                      echo "-------";
                      echo "</h6></td>";
                    } else {
                      echo "<td><h6>";
                      echo $sectionName;
                      echo "</h6></td>";
                      echo "<td><h6>";
                      echo $yearLevel;
                      echo "</h6></td>";
                    }

                    if ($haveMatch1) {
                      echo '<td class="text-center">';
                      echo '       <a class="btn btn-primary iconsize" title="View Student Profile" href="siViewer.php?page=' . $row[1] . '&name=' . $name . '">';
                      echo '           <i class="d-flex justify-content-center fas fa-eye">';
                      echo '           </i>';
                      echo '           <span id="view' . $ctr . '"></span>';
                      echo '       </a>';
                      echo '       <a href="#" title="Remove Student Profile" class="btn delete iconsize btn-danger" title="Delete" id="delete' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $row[1] . '" >';
                      echo '           <i class="d-flex justify-content-center fas fa-trash">';
                      echo '           </i>';
                      echo '       </a>';
                      echo '   </td>';
                    } else {
                      echo '<td class="text-center">';
                      echo '       <button disabled class="btn btn-primary btn-sm " title="No Student Profile Available" id="veButton' . $ctr . '"  href="?">';
                      echo '           <span id="view' . $ctr . '"></span>Profile not available';
                      echo '       </button>';
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


  $(document).ready(function() {
    $('.yearselect').select2();
  });

  $('.modal').on('show.bs.modal', function(event) {
    var idx = $('.modal:visible').length;
    $(this).css('z-index', 1040 + (10 * idx));
  });
  $('.modal').on('shown.bs.modal', function(event) {
    var idx = ($('.modal:visible').length) - 1; // raise backdrop after animation.
    $('.modal-backdrop').not('.stacked').css('z-index', 1039 + (10 * idx));
    $('.modal-backdrop').not('.stacked').addClass('stacked');
  });
</script>


<!-- Large modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Single Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form class="" method="POST" enctype="multipart/form-data">

          <label for="">Student Code: </label>
          <select name="studentcode" class="form-control select2bs4">

            <?php
            $sql = "select studentCode, lastName, firstName, middleName FROM tbl_student";
            $result1 = mysqli_query($conn, $sql);
            $ctr = 0;
            if (mysqli_num_rows($result1) > 0) {
              while ($row = mysqli_fetch_array($result1)) {
                echo '<option value="' . $row[0] . '">' . $row[0] . " - " . $row[2] . " " . $row[3][0] . ". " . $row[1] . '</option>';
              }
            }
            ?>
          </select>
          <br><br><label for="">Attach PDF: </label>
          <input type="file" name="file" value="" id="file">
          <div class="unrequired-field">Max. file size limit per PDF is 5MB.</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="savefile">Upload</button>
      </div>
    </div>
  </div>
</div>

</form>
<!-- <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Batch Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



<form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="foldername" id="foldername" value="" ><br/><br/>
                <b>Specify Location of Files: </b></br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <input type="file" name="files[]" id="files" multiple directory="" webkitdirectory="" moxdirectory="" multiple/><br/><br/>


                <script type="text/javascript">
                $('.types').change(function(e){
                  var selectedValue = $(this).val();
                  $('#foldername').val(selectedValue)
                });
                </script>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"  value="Upload" name="upload">Upload</button>
    </form>

      </div>
    </div>
  </div>
</div> -->


<div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
          <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="pt-2 px-3">
              <h3 class="card-title">Batch Upload</h3>
            </li>
            <li class="nav-item">
              <a class="nav-link active tab1" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Upload</a>
            </li>
            <li class="nav-item">
              <a class="nav-link tab2" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Uploading Guide</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
              <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="foldername" id="foldername" value="">
                <b>Specify Location of Files: </b></br>
                <div class="row">
                  <div class="col-lg-8">
                    <div class="row">
                      <label for="files" class="btn btn-secondary unrequired-field">Choose Folder</label><label class="btn unrequired-field" id="statusFile">No folder chosen</label>
                      <div class="unrequired-field">Max. file size limit per PDF is 5MB.</div>

                    </div>
                  </div>
                  <div class="col-lg-1"><input type="file" name="files[]" id="files" multiple directory="" webkitdirectory="" moxdirectory="" multiple style="display: none"></div>
                  <div class="col-lg-2"></div>
                  <div class="custom-control custom-checkbox " >&nbsp&nbsp
                        <input type="checkbox" class="custom-control-input" id="customCheck5" name="isSurnameFormat">
                        <label class="custom-control-label" for="customCheck5">Surname format <sup style="color: red">&nbsp Filename: student-143_Juan</sup></label>
                  </div>
                </div>


                <script type="text/javascript">
                  $(document).ready(function() {
                    $('#files').change(function() {
                      var files = $(this)[0].files;
                      if (files.length < 1) {
                        $('#statusFile').text("No folder chosen");
                      } else {
                        $('#statusFile').text(files.length + " Files selected.");
                      }
                    });

                    $('.tab1').click(function() {
                      $('#uploadbtn').show();
                    });
                    $('.tab2').click(function() {
                      $('#uploadbtn').hide();
                    });
                  });
                </script>

            </div>
            <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
              <b>Reminder:</b>
              <ol>
                <li>All profiles must be placed in a single folder.</li>
                <li>Individual profile must be named the same as the student code.</li>
                <li>All profiles must be in a PDF file format.</li>
                <li>Maximum of 100 files per batch upload.</li>
              </ol>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row modal-footer" style="margin-top: -13px; margin-left: 9px; margin-right: 9px;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" value="Upload" name="upload" onclick="showLoad()" id="uploadbtn">Upload</button>
        <!--         <div class="col-lg-6"><button type="submit" class="btn btn-primary" value="Upload" name="upload" onclick="showLoad()">Upload</button></div>
        <div class="col-lg-6"><button type="button" class="btn btn-secondary col-lg-5" data-dismiss="modal" style="margin-bottom: 10px;">Close</button></div> -->
      </div>

    </div>
  </div>
</div>

<div id="loading">
  <img id="loading-image" src="../assets/imgs/ajax-loader.gif" alt="Loading..." />
</div>



<script type="text/javascript" src="assets/scripts/hideAndNext.js"></script>
<!-- FastClick -->
<script src="../include/plugins/fastclick/fastclick.js"></script>
<script>
  $('#loading').hide();

  function showLoad() {
    $('#modal1').modal('toggle');
    $('#loading').show();
  }




  $('.types').change(function(e) {
    var selectedValue = $(this).val();
    $('#foldername').val(selectedValue)
  });


  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

  //Initialize Select2 Elements
  $('.select2bs4').select2()



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
          url: "removeFile3.php",
          type: "POST",
          cache: false,
          "data": {
            "studentidx": x
          },
          dataType: "html",
          success: function() {
            Swal.fire({
              title: 'Done!',
              type: 'success',
              html: 'It was succesfully deleted!',
              allowOutsideClick: false,
              allowEscapeKey: false
            }).then((result) => {
              document.location.href = 'siView.php';
            });
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
if (isset($_POST['savefile'])) {
  $file = $_FILES['file'];

  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('pdf');

  if (in_array($fileActualExt, $allowed)) {

    if ($fileError == 0) {
      if ($fileSize < 5000000) {
        $fileNameNew1 = $_POST['studentcode'] . "." . $fileActualExt;
        $answer = $_POST['type'];

        $fileDestination = 'SI/' . $fileNameNew1;

        if (file_exists('SI/' . $fileNameNew1)) {
          unlink('SI/' . $fileNameNew1);
        }

        move_uploaded_file($fileTmpName, $fileDestination);

        $checkRecord = mysqli_query($conn, "SELECT lastName, firstName, middleName FROM tbl_student where studentCode ='" . $_POST['studentcode'] . "'");
        $result = mysqli_fetch_assoc($checkRecord);
        $lname = $result['lastName'];
        $fname = $result['firstName'];
        $mname = $result['middleName'];

        $date = date('Y-m-d H:i:s');
        $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" . $userID . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Uploads a profile for student named ' '" . $fname . " ' '" . $mname . " ' '" . $lname . ". ', '$date','" . $schoolYearID . "')";
        mysqli_query($conn, $insertauditQuery);

        header('Location: siView.php?uploadingSuccess');
      } else {

        header('Location: siView.php?bigFile');
      }
    } else {
      header('Location: siView.php?error');
    }
  } else {
    header('Location: siView.php?notFound');
  }
}

if (isset($_POST['upload'])) {

  foreach ($_FILES['files']['name'] as $ii => $name) {

    $fileName = $_FILES['files']['name'][$ii];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $fileDestination2 = 'SI/';
    $allowed = array('pdf');

    if (in_array($fileActualExt, $allowed)) {

      $isNewFormat = isset($_POST['isSurnameFormat']);
  
      if ($isNewFormat) {
        $fileName = removeSubSur($fileName);

        if (file_exists($fileDestination2 . $fileName)) {
          unlink($fileDestination2 . $fileName);
        }
      }
      else{
        if (file_exists($fileDestination2 . $_FILES['files']['tmp_name'][$ii])) {
          unlink($fileDestination2 . $_FILES['files']['tmp_name'][$ii]);
        }
      }
    

      $date = date('Y-m-d H:i:s');
      $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $userID . "', '" .  $userFname . "', '" .  $userLname . "', 'Uploads report cards file named ' '" . $fileName . "', '$date','" . $schoolYearID . "')";
      mysqli_query($conn, $insertauditQuery);

      move_uploaded_file($_FILES['files']['tmp_name'][$ii], "$fileDestination2/" . "/" . $fileName);




      header('Location: siView.php?uploadingSuccess');
    } elseif (strlen($_FILES['files']['name'][$ii]) < 1) {
      header('Location: siView.php?error2');
    } else {
      header('Location: siView.php?pdfRequired');
    }
  }
}





if (isset($_REQUEST['bigFile'])) {
  displayMessage("Warning", "Warning", "Your file is too big!");
}
if (isset($_REQUEST['error'])) {
  displayMessage("Warning", "Warning", "There was an error uploading your file!");
}
if (isset($_REQUEST['error2'])) {
  displayMessage("warning", "Fields must not be empty", "Please try again");
}
if (isset($_REQUEST['notFound'])) {
  displayMessage("Warning", "Warning", "PDF file is required!");
}
if (isset($_REQUEST['uploadingSuccess'])) {
  displayMessage("success", "Success", "Uploading success");
}
?>