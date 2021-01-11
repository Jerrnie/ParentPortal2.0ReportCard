<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page = "studentImport";

  session_start();
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

        $query = "SELECT a.studentID,a.lastName,a.firstName,a.middleName,a.suffix,a.prefix,a.lrn,a.birthdate,
        a.address,a.studentCode,b.fullName,b.mobile,b.userID,a.sectionID FROM tbl_student AS a,tbl_parentuser AS b WHERE a.userID=b.userID AND a.studentID ='".$_GET['page']."' AND a.schoolYearID = '".$schoolYearID."'";
       
       $result = mysqli_query($conn,  $query);
          if ($result) {
            if (mysqli_num_rows($result) > 0) {
              if ($row = mysqli_fetch_array ($result)) {
                        $studentID   = $row[0];
                        $lastName        = $row[1];
                        $firstName         = $row[2];
                        $middleName     = $row[3];
                        $suffix    = $row[4];
                        $prefix      = $row[5];
                        $lrn  = $row[6];
                        $birthday   = $row[7];
                        $address = $row[8];
                        $studentCode = $row[9];                        
                        $fullName = $row[10];
                        $mobile = $row[11];
                        $userID = $row[12];
                        $sectionID = $row[13];
                        $haveAccess=1;
              }
            }
          }
        }
      
      else
      {
        header("location: studentImport.php");
      }

        // select box open tag
  $selectBoxOpen = "<select name='sectionYearLevel'>";
  // select box close tag
  $selectBoxClose = "</select>";
  // select box option tag
  $selectBoxOption = '';
  
  $sql = "sELECT  sectionID,sectionYearLevel,sectionName  FROM tbl_sections ORDER BY sectionYearLevel ASC ";
  // play with return result array
  $result = mysqli_query($conn, $sql);
   
  while($row = mysqli_fetch_array($result)){
    if ($row[0] == 0) {
      #do nothing
    }
    else{
      
  $selectBoxOption .="<option value = '".$row['sectionID']."'>".$row['sectionYearLevel']."-".$row['sectionName']."</option>";

}  
}
  // create select box tag with mysql result
  $selectBox = $selectBoxOpen.$selectBoxOption.$selectBoxClose;
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Information | Parent Portal</title>
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
              <li class="breadcrumb-item active">Student Information</li>

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
                Student Information
                <small></small>
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
                          <div class="col-lg-3">
                            <div class="form-group">
                            <input value="<?php echo $userID ?>"
                              name="userid" id="userid" type="text" maxlenght="60" class="form-control" hidden>
                              <input value="<?php echo $studentID ?>"
                              name="studid" id="studid" type="text" maxlenght="60" class="form-control" hidden>
                            
                              <label class="unrequired-field">Student Code</label>
                              <input value="<?php echo $studentCode ?>"
                              name="scode" id="scode" type="text" maxlenght="60" class="form-control" placeholder="" required>
                            </div>
                            </div>
                            <div class="col-lg-3">
                          <div class="form-group">
                              <label class="unrequired-field">LRN</label>
                              <input  value="<?php echo $lrn  ?>"
                              name="lrn" id="lrn" type="text" class="form-control" placeholder="" required>
                            </div>
                          </div>
                     

                   </div>

                   <div class="row">
                    <div class="col-lg-3">
                <div class="form-group">
                <label class="unrequired-field">Last Name</label>
                              <input  value="<?php echo $lastName  ?>"
                              name="lname" id="lname" type="text" class="form-control" placeholder="" required>
                            </div>
                          </div>

                          <div class="col-lg-3">
                            <div class="form-group">
                              <label class="unrequired-field">First Name</label>
                              <input value="<?php echo $firstName?>"
                              name="fname" id="fname" type="text" class="form-control" placeholder="" required>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label class="unrequired-field">Middle Name</label>
                              <input value="<?php echo $middleName?>"
                              name="mname" id="mname" type="text" class="form-control" placeholder="" required>
                            </div>
                          </div>
                          
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label class="unrequired-field">Suffix</label>
                              <input value="<?php echo $suffix?>"
                              name="suffix" id="suffix" type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
<?php
                        $query2 = "SELECT a.sectionYearLevel,a.sectionName,a.sectionID FROM tbl_sections AS a WHERE sectionID ='".$sectionID."'";
        $result = mysqli_query($conn,  $query2);
          if ($result) {
            if (mysqli_num_rows($result) > 0) {
              if ($row = mysqli_fetch_array ($result)) {
        $syearlevel = $row[0];
        $sname = $row[1];
        $sid = $row[2];    
              }
              }
            }
            
     ?> 
                        <div class="row">
                          
                        <div class="col-lg-3">
                            <div class="form-group">
                              <label class="unrequired-field">Birth Date</label>
                              <input value="<?php echo $birthday?>"
                              name="bday" id="bday" type="date" class="form-control" placeholder="">
                            </div>
                          </div>

                        <div class="col-sm-3">
                    <label class="unrequired-field">Section</label>
                    <div class="input-group">
                      <select name="sectionId" id="sectionId" class="form-control select2bs4 sectioncode" required="true" onchange="myfunction()">                      
                      <?php echo $selectBoxOption;?>
                      <option value="<?php echo $sid?>" selected><?php echo $syearlevel; echo '-';  echo $sname; ?></option>
                      </select>
                    </div>
                    </div>                            
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label class="unrequired-field">Parent Name</label>
                              <input value="<?php echo $fullName ?>"
                              name="pname" id="pname" type="text" maxlenght="60" class="form-control" placeholder="" required>
                            </div>
                            </div>
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label class="unrequired-field">Mobile Number</label>
                              <input value="<?php echo $mobile ?>"
                              name="mobile" id="mobile" type="text" maxlenght="60" class="form-control" placeholder="" required>
                            </div>
                            </div>
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label class="unrequired-field">Address</label>
                              <textarea name="address" id="address" type="text" class="form-control" 
                              placeholder="" required> <?php echo $address  ?> </textarea>
                            </div>
                          </div>
                   </div>

                      </div>
                      <footer class="card-footer ">
                      <a href="studentImport.php" class="btn btn-danger float-right" style="margin-left:10px;">
     Cancel
 </a>
                <button type="submit" class="btn btn-info float-right"  name="update" >Update</button>

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
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
</div>

  </div>
  <!-- /.content-wrapper -->


<?php

require 'assets/scripts.php';

if(isset($_POST['update'])){

  $bdate = date('Y-m-d', strtotime($_POST['bday']));
  $sql1 = "SELECT a.mobile FROM tbl_parentuser AS a WHERE userID='" . $userID . "' ORDER BY a.mobile DESC LIMIT 1";

  $result = mysqli_query($conn, $sql1);
  $pass_row = mysqli_fetch_assoc($result);
  $oldmobile = $pass_row['mobile'];

  $sql1 = "SELECT a.studentCode FROM tbl_student AS a WHERE a.studentID='" . $_POST['studid'] . "' ORDER BY a.studentID DESC LIMIT 1";

  $result = mysqli_query($conn, $sql1);
  $pass_row = mysqli_fetch_assoc($result);
  $oldcode = $pass_row['studentCode'];

  if($oldmobile == $_POST['mobile'] && $oldcode == $_POST['scode'])
  {
    $query = mysqli_query($conn,"UPDATE tbl_parentuser SET
    fullName ='".$_POST['pname']."',
    mobile= '".$_POST['mobile']."'
    WHERE userID='" . $_POST['userid']."'");
    mysqli_query($conn,$query);
    
    $insertQuery = "update tbl_student
    SET
    studentCode = '" . $_POST['scode'] . "',
    LRN = '" . $_POST['lrn'] . "',
    lastName  = '" . $_POST['lname'] . "',
    firstName  = '" . $_POST['fname'] . "',
    middleName  = '" . $_POST['mname'] . "',
    suffix = '" . $_POST['suffix'] . "',
    birthdate = '" . $bdate . "',
    Address = '" . $_POST['address'] . "',
    sectionID ='". $_POST['sectionId']."'
    WHERE studentID = '" . $studentID . "'";
    mysqli_query($conn, $insertQuery);
  
    header('Location: studentImport.php?update');
    
  }
  else{
    
  if($oldmobile == $_POST['mobile'])
  {
    $sql = "select a.* from tbl_student as a where a.studentCode='" . $_POST['scode'] . "'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

      displayMessage("warning", "Code is already registered", "Invalid Entry");
    }
    else{
    $query3 = mysqli_query($conn,"UPDATE tbl_parentuser SET
    fullName ='".$_POST['pname']."',
    mobile= '".$_POST['mobile']."'
    WHERE userID='" . $_POST['userid']."'");
    mysqli_query($conn,$query3);

    $insertQuery = "update tbl_student
    SET
    studentCode = '" . $_POST['scode'] . "',
    LRN = '" . $_POST['lrn'] . "',
    lastName  = '" . $_POST['lname'] . "',
    firstName  = '" . $_POST['fname'] . "',
    middleName  = '" . $_POST['mname'] . "',
    suffix = '" . $_POST['suffix'] . "',
    birthdate = '" . $bdate . "',
    Address = '" . $_POST['address'] . "',
    sectionID ='". $_POST['sectionId']."'
    WHERE studentID = '" . $studentID . "'";
    mysqli_query($conn, $insertQuery);
  
    header('Location: studentImport.php?update');
    }
  }
  else{
   
    if($oldcode == $_POST['scode'])
    {
      $sql = "select a.* from tbl_parentuser as a where mobile='" . $_POST['mobile'] . "'";

      $result = mysqli_query($conn, $sql);
  
      if (mysqli_num_rows($result) > 0) {
  
        displayMessage("warning", "Mobile Number is already registered", "Invalid Entry");
      }
      else{
      if (strlen($_POST['mobile']) < 11 || strlen($_POST['mobile']) > 12) {
        displayMessage("warning", "Invalid Mobile Number", "Please try again ");
      }
      else{

      $query1 = mysqli_query($conn,"UPDATE tbl_parentuser SET
      fullName ='".$_POST['pname']."',
      mobile= '".$_POST['mobile']."'
      WHERE userID='" . $_POST['userid']."'");
      mysqli_query($conn,$query1);
      
      $insertQuery = "update tbl_student
      SET
      studentCode = '" . $_POST['scode'] . "',
      LRN = '" . $_POST['lrn'] . "',
      lastName  = '" . $_POST['lname'] . "',
      firstName  = '" . $_POST['fname'] . "',
      middleName  = '" . $_POST['mname'] . "',
      suffix = '" . $_POST['suffix'] . "',
      birthdate = '" . $bdate . "',
      Address = '" . $_POST['address'] . "',
      sectionID ='". $_POST['sectionId']."'
      WHERE studentID = '" . $studentID . "'";
      mysqli_query($conn, $insertQuery);
    
      header('Location: studentImport.php?update');
      }
    }
  }
    else{
    $sql = "select a.* from tbl_student as a where a.studentCode='" . $_POST['scode'] . "'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

      displayMessage("warning", "Code is already registered", "Invalid Entry");
    }
    else{
    $sql = "select a.* from tbl_parentuser as a where mobile='" . $_POST['mobile'] . "'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

      displayMessage("warning", "Mobile Number is already registered", "Invalid Entry");
    }
    else{
  if (strlen($_POST['mobile']) < 11 || strlen($_POST['mobile']) > 12) {
    displayMessage("warning", "Invalid Mobile Number", "Please try again ");
  }
else{
      
    $query2 = mysqli_query($conn,"UPDATE tbl_parentuser SET
    fullName ='".$_POST['pname']."',
    mobile= '".$_POST['mobile']."'
    WHERE userID='" . $_POST['userid']."'");
    mysqli_query($conn,$query2);
    
    $insertQuery = "update tbl_student
    SET
    studentCode = '" . $_POST['scode'] . "',
    LRN = '" . $_POST['lrn'] . "',
    lastName  = '" . $_POST['lname'] . "',
    firstName  = '" . $_POST['fname'] . "',
    middleName  = '" . $_POST['mname'] . "',
    suffix = '" . $_POST['suffix'] . "',
    birthdate = '" . $bdate . "',
    Address = '" . $_POST['address'] . "',
    sectionID ='". $_POST['sectionId']."'
    WHERE studentID = '" . $studentID . "'";
    mysqli_query($conn, $insertQuery);
  
      header('Location: studentImport.php?update');
  }
}
}
}
}
}
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
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" type="text/css" href="../include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<script>

//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
  })

  //Initialize Select2 Elements
  $('.select2bs4').select2()

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
            url: "removeUser.php",
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
        }).then((result) => {document.location.href = 'viewAllUser.php';});

            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error deleting!", "Please try again", "error");
            }
        });
  }
})
e.preventDefault();
});

</script>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds

</script>
<?php require '../maintenanceChecker.php';
  ?>
</body>
</html>
