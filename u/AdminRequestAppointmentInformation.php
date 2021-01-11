<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page = "AdminRequestAppointmentInformation";

  session_start();
  $userID = $_SESSION['userID'];
  $userFname = $_SESSION['first-name'];
  $userMname = $_SESSION['middle-name'];
  $userLname = $_SESSION['last-name'];
  $userLvl = $_SESSION['usertype'];
  $userEmail = $_SESSION['userEmail'];
  $status= "";
  $disabled = 1;
  $personnelsched_Id= 0;
  $statusP ="";
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

      $query = "SELECT DISTINCT CONCAT(D.Lname,', ',D.Fname,' ',D.Mname) AS PersonnelName,D.Position, 
      C.DateSchedule,C.SchedTimeFrom,C.SchedTimeTo,C.WebLink,C.RequestAppoint_Id,B.studentID,
      CONCAT(B.lastName,', ',B.firstName,' ',B.middleName) AS StudentName,A.AttendAppoint_Id,
      F.sectionYearLevel,F.sectionName,C.RequestAppoint_Id,C.Status
      FROM tbl_ParentAttendAppointment A
      JOIN tbl_student B ON B.studentID = A.studentID
      INNER JOIN tbl_parentuser E ON E.userID = B.userID
      INNER JOIN tbl_sections F ON F.sectionID = B.sectionID
      INNER JOIN tbl_PersonnelRequestAppointment C ON C.RequestAppoint_Id = A.RequestAppointment_Id
      INNER JOIN tbl_Personnel D ON D.Personnel_Id = C.Personnel_Id
      WHERE C.RequestAppoint_Id = '".$_GET['page']."' LIMIT 1";
      
    $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array ($result)) {
                  $DateSchedule   = $row[2];
                  $SchedTimeFrom   = $row[3];
                  $SchedTimeTo    = $row[4];
                  $WebLink      = $row[5];
                  $PersonnelName   = $row[0];
                  $Position      = $row[1];
                  $req_ID = $row[6];
                  $studentID = $row[7];
                  $studentName = $row[8];
                  $AttendAppointId = $row[9];
                  $sYearLevel = $row[10];
                  $sectionName = $row[11];
                  $requestID = $row[12];
                  $statusP = $row[13];                  

            }
          }
    }
  }

?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Request Appointment | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">
  <link rel="stylesheet" href="../include/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

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
              <li class="breadcrumb-item active">Request for Appointment</li>
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
              Personnel Request for Appointment
                <!-- <small></small> -->
              </h3>
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
              <form method="POST">
                  <div class="row">

                    <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Date</label>
                          <input disabled="true" value="<?php echo $DateSchedule?>"
                          name="pcode" type="date" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Start Time</label>
                          <input disabled="true" value="<?php echo $SchedTimeFrom ?>"
                          name="fname" id="fname" type="time" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">End Time</label>
                          <input disabled="true" value="<?php echo $SchedTimeTo  ?>"
                          name="fname" id="fname" type="time" maxlenght="60" class="form-control" placeholder="">
                        </div>
                    </div>
                  </div>


                  <div class="row">                                       
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Personnel Name</label>
                              <input disabled="true" value="<?php echo $PersonnelName  ?>"
                              name="ParentName" id="ParentName" type="text" class="form-control" placeholder="">
                        </div>
                      </div>
                      <div class="col-lg-4">
                          <div class="form-group">
                            <label class="unrequired-field">Designation</label>
                            <input disabled="true" value="<?php echo $Position  ?>"
                            name="PersonnelName" type="text" class="form-control" placeholder="">
                          </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="unrequired-field">Medium to Used</label>
                          <input disabled="true" value="<?php echo $WebLink  ?>"
                            name="Remarks" type="text" class="form-control" placeholder="">
                        </div>
                      </div>
                  </div>

<footer class="card-footer">                  

              <?php
                  if($statusP == '3') {
                  
                  }elseif (date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime("$DateSchedule $SchedTimeTo"))) {
                  //  echo'<input style ="float:right;" type="submit" style="width:100px;" value="Cancel Appointment" id="cancel-button" name="btnCancel" class="btn btn-danger">';
                    echo'<a data-toggle="modal" data-target="#modal-lg" type="button" class="btn btn-danger float-right add-button" style="color: white; margin-left:10px;">Cancel Appointment</a>';
                  }elseif (date("Y/m/d") < date_format(date_create($DateSchedule), "Y/m/d")) {
                   // echo'<input style ="float:right;" type="submit" style="width:100px;" value="Cancel Appointment" id="cancel-button" name="btnCancel" class="btn btn-danger">';
                    echo'<a data-toggle="modal" data-target="#modal-lg" type="button" class="btn btn-danger float-right add-button" style="color: white; margin-left:10px;">Cancel Appointment</a>';
                  }                  
                  else{

                  }               
                                                       
                  ?>
</footer>

                </div>
   <!-- Default box -->
   <div class="card">
            <div class="card-header">
              <p>
             </p>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="width: 100%;">
              <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
                <thead>
                <tr>                  
                  <th>Student Name</th>
                  <th>Section</th>
                  <th>Parent Name</th>    
                  <th>Mobile Number</th>
                  <th>Reason</th>         
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
          <?php 

          $sql = "SELECT CONCAT(D.Lname,', ',D.Fname,' ',D.Mname) AS PersonnelName, D.Position, 
          C.DateSchedule,C.SchedTimeFrom,C.SchedTimeTo,C.WebLink,C.RequestAppoint_Id,A.AttendAppoint_Id,
          CONCAT(B.lastName,', ',B.firstName,' ',B.middleName) AS StudentName,F.sectionYearLevel,
          F.sectionName,G.fullName,G.mobile,A.Status,A.Reason
          FROM tbl_ParentAttendAppointment A
          JOIN tbl_student B ON B.studentID = A.studentID
          INNER JOIN tbl_PersonnelRequestAppointment C ON C.RequestAppoint_Id = A.RequestAppointment_Id
          INNER JOIN tbl_Personnel D ON D.Personnel_Id = C.Personnel_Id
          INNER JOIN tbl_sections F ON F.sectionID = B.sectionID
          INNER JOIN tbl_parentuser G ON G.userID = B.userID
          WHERE  C.RequestAppoint_Id = '".$requestID."'
          AND C.schoolYearID = '" . $schoolYearID . "' ORDER BY B.lastName";

           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){
                 
                  $DateSchedule   = $row[2];
                  $DateSchedule=date_create($row[2]);                
                  $DateSchedule = date_format($DateSchedule, 'm/d/Y');                
                  $SchedTimeFrom = date_format(date_create($row[3]), 'h:i A');                
                  $SchedTimeTo = date_format(date_create($row[4]), 'h:i A');
                  $Weblink       = $row[5];                  
                  $PersonnelName   = $row[0];
                  $Position  = $row[1];
                  $RequestAppoint = $row[6];
                  $AttendAppointId = $row[7];
                  $StudentName = $row[8];
                  $sectionName2 = $row[9];
                  $yearlevel = $row[10];
                  $parentName = $row[11];
                  $mobile = $row[12];
                  $Status3 = $row[13];
                  $Reason = $row[14];



          echo"<tr class='tRow' id='row".$ctr."'>";
                
          echo"<td><h6>";
          echo $StudentName;
          echo"</td><h6>";
          echo"<td><h6>";
          echo $yearlevel;
          echo"-";          
          echo $sectionName2;
          echo"</td><h6>";
          echo"<td><h6>";
          echo $parentName;
          echo"</h6></td>";
          echo"<td><h6>";
          echo $mobile;
          echo"</h6></td>";           
          echo"<td><h6>";
          echo $Reason;
          echo"</h6></td>";       
          
          if ($Status3 == '2') {
            echo '<td class="text-center"><h4><span class="badge badge-success" style ="font-weight: normal; width:110px;">Approve</span></h4></td>';
          } elseif($Status3 =='3'){
            echo '<td class="text-center"><h4><span class="badge badge-danger" style ="font-weight: normal; width:110px;">Cancelled</span></h4></td>';
          }else {
            echo '<td class="text-center"><h4><span class="badge badge-warning" style ="font-weight: normal; width:110px;">Pending</span></h4></td>';            
          }


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
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Reason</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST">
            <div class="modal-body">
            <textarea type="text" name="reason" class="form-control" id="reason" placeholder="Reason" required rows="4" cols="50" ></textarea>										                  
            </div>
            <div class="modal-footer">

            <input type="submit" style="width:100px; margin-right: 10px;" value="Submit" name="btnCancel" class="btn btn-success float-right">
              
              <button type="button" class="btn btn-default float-right" style="width:100px; margin-left:10px;" data-dismiss="modal">Close</button>

            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
  </div>

</div>

  </div>
  <!-- /.content-wrapper -->


<?php

if(isset($_POST['btnCancel'])){

    $query = mysqli_query($conn, "UPDATE tbl_ParentAttendAppointment SET  Status='3', Reason = '".$_POST['reason']."' WHERE RequestAppointment_Id='" . $requestID . "'");
    mysqli_query($conn, $query);

    $query = mysqli_query($conn, "UPDATE tbl_PersonnelRequestAppointment SET  Status='3' WHERE RequestAppoint_Id='" . $requestID . "'");
    mysqli_query($conn, $query);

    header('Location: AdminRequestAppointmentInformation.php?page='.$requestID);

    displayMessage("success", "Done!", "It was succesfully canceled!");
}


require 'assets/scripts.php';

if (isset($_POST['Request1'])) {
    
    $sql2 = mysqli_query($conn, "UPDATE tbl_ParentAttendAppointment
    SET Status = '2'
    WHERE AttendAppoint_Id = '".$AttendAppointId."' AND studentID ='".$studentID."'");

    displayMessage("success","Success!" ,"Appointment request has been submitted!");
    //header('Location: parentAppointmentHistory.php?ARS');
}

?>
  <script src="../include/plugins/datatables/jquery.dataTables.js"></script>

<script src="../include/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
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
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today': [moment(), moment()],
          'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
          'Next 7 Days': [moment().add(7, 'days'), moment().add(7, 'days')],
          'Next 30 Days': [moment().add(30, 'days'), moment().add(30, 'days')],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        $('#startdate').val(start.format('MMMM D, YYYY'))
        $('#enddate').val(end.format('MMMM D, YYYY'))
      }
    )

$(document).on("click", ".delete", function() {
    var x = $(this).attr('value');

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
            url: "removePersonnel.php",
            type: "POST",
            cache: false,
            "data":
                {"personnelidx" : x},
            dataType: "html",
            success: function () {
        Swal.fire({
          title: 'Done!',
          type: 'info',
          html: 'It was succesfully deleted!',
          allowOutsideClick:false,
          allowEscapeKey: false
        }).then((result) => {document.location.href = 'viewAllPersonnel.php';});

            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error deleting!", "Please try again", "error");
            }
        });
  }
})
e.preventDefault();
});

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
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds


$(document).ready(function() {
      $('#example1').DataTable({
        "scrollX": true,
      });
    });
</script>
<?php require '../maintenanceChecker.php';
  ?>
</body>
</html>
