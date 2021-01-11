<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require '../assets/phpfunctions.php';
  $page = "viewAllUser";

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

  $query = "select * from tbl_parentuser where userID =".$_GET['page'];
    $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array ($result)) {
                  $userID   = $row[0];
                  $fname        = $row[1];
                  $lname         = $row[3];
                  $mobile     = $row[4];
                  $sex    = $row[5];
                  $email      = $row[6];
                  $password  = $row[7];
                  $status   = 0;
                  $haveAccess=1;
                  $fullName = $row[15];

        }
      }
    }
  }

else
{
  header("location: viewAllUser.php");
}

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
              <li class="breadcrumb-item"><a href="viewUser.php">View All Users</a></li>
              <li class="breadcrumb-item active">Edit User</li>

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
                User Information
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
                          <div class="col-lg-8">
                            <div class="form-group">
                              <label class="unrequired-field">Full Name</label>
                              <input value="<?php echo $fullName  ?>"
                              name="fname" id="fname" type="text" maxlenght="60" class="form-control" placeholder="" required>
                            </div>
                          </div>

                   </div>

                   <div class="row">
                    <div class="col-lg-4">
                <div class="form-group">
                <label class="unrequired-field">Mobile Number</label>
                              <input  value="<?php echo $mobile  ?>"
                              name="mobile" id="mobile" type="text" class="form-control" placeholder="" required>
                            </div>
                          </div>
<!--                           <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Gender</label>
                              <input disabled="true" value="<?php echo $sex?>"
                              name="sex" type="text" class="form-control" placeholder="">
                            </div>
                          </div>
 -->
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Email</label>
                              <input value="<?php echo $email?>"
                              name="email" type="text" class="form-control" placeholder="" required>
                            </div>
                          </div>
                        </div>

                      </div>
                      <footer class="card-footer ">
                      <a href="viewAllUser.php" class="btn btn-danger float-right" style="margin-left:10px;">
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

  $sql1 = "SELECT a.mobile FROM tbl_parentuser AS a WHERE userID='" . $userID . "' ORDER BY a.mobile DESC LIMIT 1";

  $result = mysqli_query($conn, $sql1);
  $pass_row = mysqli_fetch_assoc($result);
  $oldmobile = $pass_row['mobile'];
  if($oldmobile == $_POST['mobile'])
  {
    $query = mysqli_query($conn,"UPDATE tbl_parentuser SET
    fullName ='".$_POST['fname']."',
    mobile= '".$_POST['mobile']."',
    email='".$_POST['email']."'
    WHERE userID='".$userID."'");

    mysqli_query($conn,$query);
    header('Location: viewAllUser.php?update');
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
      $query = mysqli_query($conn,"UPDATE tbl_parentuser SET
      fullName ='".$_POST['fname']."',
      mobile= '".$_POST['mobile']."',
      email='".$_POST['email']."'
      WHERE userID='".$userID."'");

      mysqli_query($conn,$query);
      header('Location: viewAllUser.php?update');
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
