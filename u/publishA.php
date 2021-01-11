<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../assets/phpfunctions.php';
$page = "AddAnnouncement";


// $_SESSION['userID']
// $_SESSION['first-name']
// $_SESSION['middle-name']
// $_SESSION['last-name']
// $_SESSION['usertype']
// $_SESSION['userEmail']
// $_SESSION['schoolID']
// $_SESSION['userType']
// 




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


?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Announcement | Parent Portal</title>
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
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1> Add Announcement </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="viewAllAnnouncement.php">View All Announcement</a></li>
                <li class="breadcrumb-item active">Add Announcement</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <div class="container-fluid ">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <div class="card-title" style="font-size: 30px;">
                    <small></small>
                  </div>
                  <!-- tools box -->
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body pad">
                  <form method="post" enctype="multipart/form-data">
            <div class="row" >
              <div class="col-12" style="background-color: #F5FFFA; ">
                <div class="form-group" >

                  <div  style="font-size: 24px; font-weight: bold;">
                    Select Audience
                    <small></small>
                  </div><br>
                  <select class="duallistbox" name="audi[]" multiple="multiple" >
                  <?php

if (isset($_POST['audi'])) {
  $selectedSections = $_POST['audi'];
}
else{
  $selectedSections[] = 'x';
}

                  $sql = "select * from tbl_sections order by sectionYearLevel";
                  $result1 = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_array($result1)) {

                      if (in_array($row[0], $selectedSections)) {
                        $selected = "selected";
                      }
                      else{
                        $selected='';
                      }
                      echo '<option '.$selected.' value = "'.$row[0].'">'.$row[3].' - '.$row[2]. '</option>';
                      $le = $row[0];

                    }
                  }
                  ?>
                  </select>
                </div>
              </div>
            </div>
<?php 
//print_r($selectedSections);


            ?>
            <hr>
                              <div  style="font-size: 24px; font-weight: bold;">
                    Main Content
                    <small></small>
                  </div>
                    <div class="row" >
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Primary Title</label>
                          <input value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>" name="title" id="title" type="text" class="form-control" maxlength="50" placeholder="">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Secondary Title</label>
                          <input value="<?php echo isset($_POST['subtitle']) ? $_POST['subtitle'] : '' ?>" name="subtitle" id="subtitle" type="text" class="form-control" maxlength="50" placeholder="">
                        </div>
                      </div>
                      <!-- this is for choosefile -->

                      <!-- this is for choosefile -->
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
                          <input type="text" <?php if (isset($_POST['startdate'])) {
                            echo ' value = "'.$_POST["startdate"].'" ';
                          } ?> name="startdate" class="form-control" readonly="true" id="startdate">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">End Date</label>
                          <input type="text" <?php if (isset($_POST['enddate'])) {
                            echo ' value = "'.$_POST["enddate"].'" ';
                          } ?> name="enddate" class="form-control" readonly="true" id="enddate">
                        </div>
                      </div>


                    </div>


                    <div class="mb-3">
                      <textarea value="" name="htmlcode" class="textarea" style="width: 10000px; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if (isset($_POST['htmlcode'])) {
                                                                                                                                                                                                  echo htmlentities($_POST['htmlcode']);
                                                                                                                                                                                                }                                                                                                                                                                                            ?></textarea>
                    </div>
                    <div class="createbutton">
                      <button type="submit" class="btn btn-primary float-right" name="gothis">Create</button>

                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <div class="choose">
                          <br>

                          <input type="file" name="file" onChange="displayImage(this)" id="file" class="form-control" style="border: 1px solid #dddddd; height:44px;width:245px;">

                          <style>
                            div.choose {
                              position: relative;
                              left: -05px;
                              top: 15px;
                              height: 100%;
                              width: 100%;
                            }
                          </style>
                        </div>
                        <div class="addimagelabel">
                          <label for="">Add image : </label>

                          <style>
                            div.addimagelabel {
                              position: relative;
                              left: 0px;
                              top: -55px;
                              height: 100%;
                              width: 100%;
                            }
                          </style>
                        </div>

                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <div class="Radio">
                          <input type="radio" id="SOA"name="type" value="OnTop" checked="checked">
                          <label for="OnTop">Top</label>
                          <input type="radio" id="RC" name="type" value="OnBottom">
                          <label for="OnBottom">Bottom</label>
                        </div>
                      </div>
                    </div>
                    <style>
                      div.Radio {
                        position: absolute;
                        left: 260px;
                        top: -48px;
                        height: 100%;
                        width: 100%;
                      }
                    </style>
                    <div class="limit">
                      Max. file size limit is 5MB.
                    </div>
                    <style>
                      .limit {
                        position: relative;
                        left: 5px;
                        top: -18px;
                        font-size-adjust: .01;
                        font-family: Monospace;
                      }
                    </style>
                    <br>
                    <div class="importlabel">
                      <label for="">Image Preview:</label>
                    </div>

                    <p id="GFG_DOWN" style="color:green; font-size: 20px; font-weight: bold; display: show;">
                    </p>

                    <div class="hide" id="hide">
                      <img src="" onClick="triggerClick()" id="profileDisplay">
                    </div>
                    <style>
                      img {
                        max-width: 20%;
                        max-height: 20%;

                      }
                    </style>

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
    require '../include/getVersion.php';
    include 'footer.php';
    ?>

    <?php

    require 'assets/scripts.php';

    if (isset($_POST['gothis'])) {
      $audi = $_POST['audi'];
      echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
      $_POST['title'] = mysqli_real_escape_string($conn, stripcslashes($_POST['title']));
      $_POST['startdate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['startdate']));
      $_POST['enddate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['enddate']));
      $newDateStart = date('Y-m-d H:i:s', strtotime($_POST['startdate']));
      $newDateEnd = date('Y-m-d H:i:s', strtotime($_POST['enddate']));
      $_POST['subtitle'] = mysqli_real_escape_string($conn, stripcslashes($_POST['subtitle']));
      $_POST['htmlcode'] = mysqli_real_escape_string($conn, stripcslashes($_POST['htmlcode']));
      $htmlcode = htmlentities(htmlspecialchars($_POST['htmlcode']));
      // $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
      //echo html_entity_decode(htmlspecialchars_decode($htmlcode));
      if (empty($audi)||!isset($audi)) {
        displayMessage("warning", "Audience Missing", "Please select Audience");
      }
      else if (strlen(trim($_POST['startdate'])) < 3) {
        displayMessage("warning", "Range Date Invalid", "Please try again");
      } else {
        $answer = $_POST['type'];
        if ($answer == "OnTop") {
          $radio = "1";
        }
        if ($answer == "OnBottom") {
          $radio = "0";
        }
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
          if ($fileError == 0) {
            if ($fileSize < 5000000) {
              $fileNameNew = uniqid('', true) . "." . $fileActualExt;
              $fileDestination = 'uploads/' . $fileNameNew;
              move_uploaded_file($fileTmpName, $fileDestination);
              header("location: publishA.php?uploadsuccess");
            } else {
              displayMessage("Warning", "Warning", "Your file is too big!");
            }
          } else {
            displayMessage("Warning", "Warning", "There was an error uploading your file!");
          }
        } else {
          displayMessage("Warning", "Warning", "You cannot upload files of this type!");
        }
        $randomChar = generateNumericOTP('10');
        $insertQuery = "Insert into tbl_announcement
 (
 title,
 subtitle,
 htmlcode,
 dateCreated,
 dateEnd,
 dateStart,
 userID,
 schoolYearID,
 image,
 isOnTop,
 randomChar
 )
 VALUES
 (
  '" . $_POST['title'] . "',
  '" . $_POST['subtitle'] . "',
  '" . $htmlcode . "',
  now(),
  '" . $newDateEnd . "',
  '" . $newDateStart . "',
  '" . $_SESSION['userID']  . "',
  '" . $schoolYearID . "',
  '" . $fileNameNew  . "',
  '" . $radio  . "',
  '" . $randomChar . "'




 )";
        mysqli_query($conn, $insertQuery);

                  $sql = "sELECT a.announceID FROM tbl_announcement AS a WHERE a. randomChar = '" . $randomChar . "' and a.title ='".  $_POST['title'] ."' and a.schoolYearID ='".  $schoolYearID ."' ";
          $result = mysqli_query($conn, $sql);
          $pass_row = mysqli_fetch_assoc($result);
          $annID = $pass_row['announceID'];

          foreach ($audi as $key => $sectionID) {
        $insertauditQuery2 = "insert into tbl_audience (announceID,sectionID) values ('".$annID."','".$sectionID."')";
        mysqli_query($conn, $insertauditQuery2);
          }


        //Insert Audit Trail
        $date = date('Y-m-d H:i:s');
        $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Creates an announcement entitled ' '" . $_POST['title'] . "', '$date','" . $schoolYearID . "')";
        mysqli_query($conn, $insertauditQuery);
        header('Location: publishA.php?AnnouncementCreated');
      }
    }
    if (isset($_REQUEST['AnnouncementCreated'])) {
      displayMessage("success", "Success", "Announcement has been created.");
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
    <script src="../include/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script>
    $('.duallistbox').bootstrapDualListbox({
  nonSelectedListLabel: 'Not Selected',
  selectedListLabel: 'Selected',
  infoText:"<div style='font-size: 15px;'>&nbsp &nbsp Showing all {0}</div>",
  infoTextFiltered:'<div style="font-size: 15px;"><span class="badge badge-warning" >Filtered</span> {0} from {1}</div>',
  infoTextEmpty: '<div style="font-size: 15px;">Empty list</div>',  
  filterTextClear:"<div style='font-size: 15px;'>Show all</div>",filterPlaceHolder:"Filter",
});

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
          disableDragAndDrop: true,
          callbacks: {
            onImageUpload: function(data) {
              data.pop();
            }
          }

        });
      })

      // $('.textarea').summernote({
      //         callbacks: {
      //                       onImageUpload: function (data) {
      //                           data.pop();
      //                       }
      //                   }
      //               });

    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment().startOf('day'), moment().endOf('day')],
          'Tomorrow': [moment().add(1, 'days').startOf('day'), moment().add(1, 'days').endOf('day')],
          'Next 7 Days': [moment().add(7, 'days').startOf('day'), moment().add(7, 'days').endOf('day')],
          'Next 30 Days': [moment().add(30, 'days').startOf('day'), moment().add(30, 'days').endOf('day')],
          'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf('day')], 
          },
    "timePicker": true,
    "timePicker24Hour": true,
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY H:mm:ss') + ' - ' + end.format('MMMM D, YYYY H:mm:ss'))
          $('#startdate').val(start.format('MMMM D, YYYY H:mm:ss'))
          $('#enddate').val(end.format('MMMM D, YYYY H:mm:ss'))
        }
      )

      $("#title").on('input', function() {
        if ($(this).val().length >= 50) {
          const toast = swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000
          });
          toast.fire({
            type: 'warning',
            title: 'The maximum number of characters has been reached!'
          });
        }
      });

      $("#subtitle").on('input', function() {
        if ($(this).val().length >= 50) {
          const toast = swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000
          });
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
      setInterval(function() {
        sessionChecker();
      }, 20000); //time in milliseconds

      function triggerClick(e) {
        document.querySelector('#file').click();
      }

      function displayImage(e) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 5) {
          $('#file').val('');
          const toast = swal.mixin({
            toast: true,
            position: 'bottom-left',
            showConfirmButton: false,
            timer: 3000
          });
          toast.fire({
            type: 'warning',
            title: 'Your file is too big!'

          });
          //for clearing with Jquery
        }
        if (e.files[0]) {
          $('#hide').show();
          var reader = new FileReader();
          reader.onload = function(e) {
            document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
          }
          reader.readAsDataURL(e.files[0]);

        }



      }
      $('INPUT[type="file"]').change(function() {
        var ext = this.value.match(/\.(.+)$/)[1];
        switch (ext) {
          case 'jpg':
          case 'jpeg':
          case 'png':
            $('#uploadButton').attr('disabled', false);
            break;
          default:
            const toast = swal.mixin({
              toast: true,
              position: 'bottom-left',
              showConfirmButton: false,
              timer: 3000
            });
            toast.fire({
              type: 'warning',
              title: 'Your file format is invalid!'

            });
            this.value = '';
            $('#hide').hide();




        }
      });
    </script>
    <?php require '../maintenanceChecker.php';
    ?>
</body>

</html>
