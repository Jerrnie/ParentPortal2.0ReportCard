<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../assets/phpfunctions.php';
$page = "pdfviewer";
session_start();


// $_SESSION['userID']
// $_SESSION['first-name']
// $_SESSION['middle-name']
// $_SESSION['last-name']
// $_SESSION['usertype']
// $_SESSION['userEmail']
// $_SESSION['schoolID']
// $_SESSION['userType']
$isViewable = true;
$list_studentCode;

$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
if(!isset($user_check) && !isset($password_check))
{
  if ($levelCheck=='P'){
    session_destroy();
    header("location: ../index.php");
  }
  else if ($levelCheck=='E'){
    session_destroy();
    header("location: ../login.php"); 
  }
}
else if ($levelCheck=='A'){
  header("location: index.php"); 
}
else if ($levelCheck=='S'){
  header("location: index.php"); 
}
  $checkRecord = mysqli_query($conn,"sELECT a.studentCode FROM tbl_student AS a WHERE userID = '".$_SESSION['userID']."';");

  while( $pass_row = mysqli_fetch_assoc($checkRecord)){
      $list_studentCode[] = $pass_row['studentCode'];
  }

  if (count($list_studentCode)<1) {
    $isViewable = false;
  }

  if (!in_array($_GET['page'], $list_studentCode)) {
    $isViewable = false;
  }

  if (!$isViewable) {
    header("location: index.php");
  }

if (!isset($_GET['page'])) {
  header('Location: viewStudent.php');
}

  $data= stripcslashes($_GET['page']);
    $data = mysqli_real_escape_string($conn, $data);
$sql = " select a.*  FROM tbl_student as a inner join tbl_parentuser as b on b.userid = a.userid where studentcode='".$data."'";
$result1 = mysqli_query($conn, $sql);
$ctr = 0;
if (mysqli_num_rows($result1) > 0) {
  $row = mysqli_fetch_array($result1);
  $fName      =  $row['7'];
  $lName      =  $row['8'];
  $mName      =  $row['9'];
  $fullname = combineName($fName,$lName,$mName);

}
else{
  header('Location: viewStudent.php');
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


    <link rel="stylesheet" type="text/css" href="assets/css/css-studentinfo.css">





  <style type="text/css">
    .small-box {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
  </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">

    <!-- nav bar & side bar -->
    <?php
if ($levelCheck=='P'){
  require 'includes/navAndSide2.php';
}
elseif ($levelCheck=='E'){
  require 'includes/navAndSide3.php';
}
    ?>

        <?php

        require 'assets/scripts.php';

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
              <li class="breadcrumb-item"><a href="viewStudent.php">Student Information</a></li>
              <li class="breadcrumb-item active">Student Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><?php echo $fullname?>'s Profile</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
<div class="row">
  <div class="col-lg-12">                            <?php

                $dir    = 'SI/';
                $files2 = scandir($dir, 1);
                $file = $_GET['page'];
                $matchIndex;
                $haveMatch;

                     foreach ($files2 as $key => $value) {
                       if (pathinfo($value, PATHINFO_FILENAME)==$file) {
                         $matchIndex = $key;
                         $haveMatch = true;
                         break;
                       }
                       else{
                        $haveMatch = false;
                       }
                     }

                                    if ($haveMatch) {
                            echo "<div class='pdffile'>";
echo "<a href='siDownloader.php?file=".$files2[$matchIndex]."'>Download Student Information</a>";
echo "<br><br>";
                            echo"<input type='hidden' value=?><iframe src='SI/".$files2[$matchIndex]."#toolbar=0&navpanes=0&scrollbar=0';  name='inputfile' style='margin:0; padding:0; width:100%; height:800px; border:none; overflow:hidden;' scrolling='no' onload='AdjustIframeHeightOnLoad'> </iframe> <?php; >";
                             echo "</div>";
                                    }
                                    else{
                                      header('Location: siView.php');
                                    }
?></div>
</div>
</div>
              <!-- /.card-body -->
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->
<script type="text/javascript">

function AdjustIframeHeightOnLoad() { document.getElementById("inputfile").style.height = document.getElementById("inputfile").contentWindow.document.body.scrollHeight + "px"; }
function AdjustIframeHeight(i) { document.getElementById("inputfile").style.height = parseInt(i) + "px"; }
</script>
  <!-- Summernote -->


  <script src="includes/sessionChecker.js"></script>
  <script type="text/javascript">

    extendSession();
    var isPosted;
    var isDisplayed = false;
    setInterval(function() {
      sessionChecker();
    }, 20000); //time in milliseconds
  </script>
</body>

</html>
