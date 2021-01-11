<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../assets/phpfunctions.php';
$page = "personnelRequestAppoint";


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
} else if ($levelCheck == 'A') {
  header("location: index.php");
}

$query = "select a.Personnel_Id,a.Fname,a.Mname,a.Lname,a.Mobile from tbl_Personnel as a,tbl_parentuser as b where a.Personnel_Id = b.pID AND b.userID ='".$user_check."'";
$result = mysqli_query($conn,  $query);
if ($result) {
  if (mysqli_num_rows($result) > 0) {
    if ($row = mysqli_fetch_array ($result)) {
      $Personnel_Id = $row[0];
      $Fname = $row[1];
      $Mname = $row[2];
      $Lname = $row[3];
     
    }
  }
}

?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Request Appointment | Parent Portal</title>
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
    .small-box {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    .section { 
            display: none; 
        }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- nav bar & side bar -->
    <?php
    require 'includes/navAndSide3.php';
    require 'sendText.php';
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
                  Add Request Appointment
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
                  <div class="row">

<div class="col-lg-4">
        <div class="form-group">
          <label class="unrequired-field">Date of Appointment </label>
          <input name="dateSched" type="date" class="form-control" placeholder="">
        </div>
      </div>
</div>
<div class="row">
<div class="col-lg-4">
        <div class="form-group">
          <label class="unrequired-field">Start Time</label>
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
          <label class="unrequired-field">End Time</label>
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

<div class="col-lg-8">
<div class="form-group">
<label class="unrequired-field">Medium to be Used</label>
<input type="text" name="weblink" oninput="lenValidation('weblink','100')" class="form-control" id="weblink">
</div>
</div>
  </div>
  <hr>
                  <div class="row mb-2">
                  <!-- criteria-->
                  <div class="col-lg-6">
                    <div class="icheck-primary d-inline">
                      <input value="student" type="radio" id="radioPrimary1" name="r1" checked>
                      <label for="radioPrimary1">List of Students
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="icheck-primary d-inline">
                      <input value="section" type="radio" id="radioPrimary3" name="r1">
                      <label for="radioPrimary3">List of Sections
                      </label>
                    </div>
                  </div>
                </div>
                
          
                <div class="row student selectt">
              <div class="col-12" style="background-color: #F5FFFA; ">
                <div class="form-group" >
<br>
                  <div  style="font-size: 24px; font-weight: bold;">
                    Select Student
                    <small></small>
                  </div><br>
                  <select class="duallistbox" name="stud[]" multiple="multiple">
                  <?php

if (isset($_POST['stud'])) {
  $selectedSections = $_POST['stud'];
}
else{
  $selectedSections[] = 'x';
}

                  $sql = "SELECT A.userID,A.studentID,A.lastName,A.firstName,A.middleName,C.sectionID FROM tbl_student A
                  LEFT JOIN tbl_PersonnelSection C ON A.sectionID = C.sectionID 
                  WHERE C.Personnel_Id = '".$Personnel_Id."' AND A.schoolYearID = '".$schoolYearID."' ORDER BY A.lastName";
                  $result1 = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_array($result1)) {
                      if ($row[5] == 0) {
                        #do nothing
                      }
                      else{
                      if (in_array($row[1], $selectedSections)) {
                        $selected = "selected";
                      }
                      else{
                        $selected='';
                      }
                      echo '<option '.$selected.' value = "'.$row[1].'">'.$row[2].', '.$row[3]. ' '.$row[4]. '</option>';
                      $le = $row[1];
                    }
                    }
                  }
                  ?>
                  </select>
                </div>
              </div>
            </div>
              <div class="row section selectt">
              <div class="col-12" style="background-color: #F5FFFA; ">
                <div class="form-group" >
                  <br>
                  <div  style="font-size: 24px; font-weight: bold;">
                    Select Section
                    <small></small>
                  </div><br>
                  <select class="duallistbox" name="Sec[]" multiple="multiple">
                  <?php

if (isset($_POST['Sec'])) {
  $selectedSections = $_POST['Sec'];
}
else{
  $selectedSections[] = 'x';
}

                  $sql = "SELECT * FROM tbl_sections A
                  LEFT JOIN tbl_PersonnelSection C ON A.sectionID = C.sectionID
                  WHERE C.Personnel_Id = '".$Personnel_Id."'
                  ORDER BY sectionYearLevel";
                  $result1 = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_array($result1)) {
                      if ($row[0] == 0) {
                        #do nothing
                      }
                      else{
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
                  }
                  ?>
                  </select>
                </div>
              </div>
            </div>
          
<?php 
//print_r($selectedSections);


            ?>
                    <div class="createbutton">
                      <button type="submit" onclick="showLoad()" class="btn btn-primary float-right" name="gothis">Create</button>

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

    </div>
    <div id="loading">
  <img id="loading-image" src="../assets/imgs/ajax-loader.gif" alt="Loading..." />
</div>
    <!-- /.content-wrapper -->
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>

    <?php

    require 'assets/scripts.php';

    if (isset($_POST['gothis'])) {

      $startTime = $_POST['TimeFrom'];
      $endTime = $_POST['TimeEnd'];
      
      $datesched = date('Y-m-d', strtotime($_POST['dateSched']));
      
      $datenow = date("Y-m-d");
      $datenow2 = date("Y-m-d H:i:s");
      
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

      if ($_POST['r1'] === "student") {
        $stud = $_POST['stud'];
        if($stud == ''){
          displayMessage("warning","No Student Selected","Please try again");
        }
        else{
                
      $stud = $_POST['stud'];
      echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
      
       $insertQuery = "INSERT INTO tbl_PersonnelRequestAppointment (
       Personnel_Id,
       DateSchedule,
       SchedTimeFrom,
       SchedTimeTo,
       WebLink,
       PostedDateTime,
       schoolYearID)
       VALUES
       (
        '" . $Personnel_Id . "',
        '" . $datesched . "',
        '" . $_POST['TimeFrom'] . "',
        '" . $_POST['TimeEnd'] . "',
        '" . $_POST['weblink'] . "',
        '".$datenow2."',
        '" . $schoolYearID . "'
        )";
        mysqli_query($conn, $insertQuery);
       
            $sql = "sELECT a.RequestAppoint_Id FROM tbl_PersonnelRequestAppointment AS a WHERE a.Personnel_Id = '" . $Personnel_Id . "' and a.DateSchedule ='".  $datesched ."' and a.SchedTimeFrom ='".$_POST['TimeFrom']."' and a.SchedTimeTo ='".$_POST['TimeEnd']."' and a.schoolYearID ='".  $schoolYearID ."' ";
            $result = mysqli_query($conn, $sql);
            $pass_row = mysqli_fetch_assoc($result);
            $raID = $pass_row['RequestAppoint_Id'];
     
            $sql2 = "sELECT a.userID FROM tbl_student AS a WHERE a.studentID = '" . $studentID . "' AND a.schoolYearID ='".  $schoolYearID ."' ";
            $result = mysqli_query($conn, $sql2);
            $pass_row = mysqli_fetch_assoc($result);
            $userID = $pass_row['userID'];
     
            // 1 means Scheduled
            foreach ($stud as $key => $studentID) {

              $sql2 = "sELECT a.userID FROM tbl_student AS a WHERE a.studentID = '" . $studentID . "' AND a.schoolYearID ='".  $schoolYearID ."'";
              $result = mysqli_query($conn, $sql2);
              $pass_row = mysqli_fetch_assoc($result);
              $userID = $pass_row['userID'];
     
              $insertauditQuery2 = "insert into tbl_ParentAttendAppointment (RequestAppointment_Id,studentID,userID,Status,ReadTag) values ('".$raID."','".$studentID."','".$userID."','1','1')";
              mysqli_query($conn, $insertauditQuery2);
              
              $sql = "sELECT b.mobile FROM tbl_student AS a,tbl_parentuser AS b WHERE a.userID=b.userID AND a.studentID = '" . $studentID . "' AND a.schoolYearID ='".  $schoolYearID ."' ";
              $result = mysqli_query($conn, $sql);
              $pass_row = mysqli_fetch_assoc($result);
              $pmobile = $pass_row['mobile'];
     
              $Mobile = $pmobile;
$newmessage= 'You have a request appointment for '.$Fname.' '.$Lname.'.

To respond to the appointment, Please login to the parent portal website
and go to request appointment.

- '.SCHOOL_ABV.' ';
sendOTP($newmessage,$Mobile);
            }       
            header('Location: personnelRequestAppoint.php?AppointmentRequestCreated');    
          }      
      }
      else{
        $Sec = $_POST['Sec'];
        if($Sec == ''){
          displayMessage("warning","No Sections Selected","Please try again");
        }
        else{
       
        echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
    
        $insertQuery = "INSERT INTO tbl_PersonnelRequestAppointment (
        Personnel_Id,
        DateSchedule,
        SchedTimeFrom,
        SchedTimeTo,
        WebLink,
        PostedDateTime,
        schoolYearID)
        VALUES
        (
         '" . $Personnel_Id . "',
         '" . $datesched . "',
         '" . $_POST['TimeFrom'] . "',
         '" . $_POST['TimeEnd'] . "',
         '" . $_POST['weblink'] . "',
         '".$datenow2."',
         '" . $schoolYearID . "'
         )";
         mysqli_query($conn, $insertQuery);
     
          foreach ($Sec as $key => $sectionID) {
     
            
            $sql2 = "sELECT a.RequestAppoint_Id FROM tbl_PersonnelRequestAppointment AS a WHERE a.Personnel_Id = '" . $Personnel_Id . "' and a.DateSchedule ='".  $datesched ."' and a.SchedTimeFrom ='".$_POST['TimeFrom']."' and a.SchedTimeTo ='".$_POST['TimeEnd']."' and a.schoolYearID ='".  $schoolYearID ."' ";            
            $result2 = mysqli_query($conn, $sql2);
            $pass_row2 = mysqli_fetch_assoc($result2);
            $raID = $pass_row2['RequestAppoint_Id'];
            
            $sql = "sELECT a.studentID,b.mobile FROM tbl_student AS a,tbl_parentuser AS b WHERE a.userID=b.userID AND a.sectionID = '" . $sectionID . "' AND a.schoolYearID ='".  $schoolYearID ."' ";
            $result = mysqli_query($conn, $sql);
                        
            while ($row = mysqli_fetch_array($result))
            { 
              $Mobile = $row['mobile'];
$newmessage= 'You have a request appointment for '.$Fname.' '.$Lname.'.

To respond to the appointment, Please login to the parent portal website
and go to request appointment.

- '.SCHOOL_ABV.' ';
sendOTP($newmessage,$Mobile);
            
            
              $insertauditQuery2 = "insert into tbl_ParentAttendAppointment (RequestAppointment_Id,studentID,Status,ReadTag) values ('".$raID."','".$row['studentID']."','1','1')";
              mysqli_query($conn, $insertauditQuery2);
            }          
          }   
          header('Location: PersonnelRequestAppointHistory.php?PRAH');
        }
        }
     }
  }  
    if (isset($_REQUEST['AppointmentRequestCreated'])) {
      displayMessage("success", "Success", "Appointment Request has been created.");
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
            $(document).ready(function() { 
                $('input[type="radio"]').click(function() { 
                    var inputValue = $(this).attr("value"); 
                    var targetBox = $("." + inputValue); 
                    $(".selectt").not(targetBox).hide(); 
                    $(targetBox).show(); 
                }); 
            }); 

    $('.duallistbox').bootstrapDualListbox({
  nonSelectedListLabel: 'Not Selected',
  selectedListLabel: 'Selected',
  infoText:"<div style='font-size: 15px;'>&nbsp &nbsp Showing all {0}</div>",
  infoTextFiltered:'<div style="font-size: 15px;"><span class="badge badge-warning" >Filtered</span> {0} from {1}</div>',
  infoTextEmpty: '<div style="font-size: 15px;">Empty list</div>',  
  filterTextClear:"<div style='font-size: 15px;'>Show all</div>",filterPlaceHolder:"Filter",
});

      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Tomorrow': [moment(), moment().add(1, 'days')],
            'Next 7 Days': [moment().add(6, 'days'), moment().add(7, 'days')],
            'Next 30 Days': [moment().add(29, 'days'), moment().add(30, 'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          $('#startdate').val(start.format('MMMM D, YYYY'))
          $('#enddate').val(end.format('MMMM D, YYYY'))
        })

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
      
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
            'Next 7 Days': [moment().add(7, 'days'), moment().add(7, 'days')],
            'Next 30 Days': [moment().add(30, 'days'), moment().add(30, 'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          $('#startdate').val(start.format('MMMM D, YYYY'))
          $('#enddate').val(end.format('MMMM D, YYYY'))
        })

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
      
    $('#loading').hide();

      function showLoad(){
  $('#loading').show();
}
    </script>
    <?php require '../maintenanceChecker.php';
    ?>
</body>

</html>
