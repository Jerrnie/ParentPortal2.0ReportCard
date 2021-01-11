<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  $page="home";

// $_SESSION['userID']     
// $_SESSION['first-name'] 
// $_SESSION['middle-name']
// $_SESSION['last-name']  
// $_SESSION['usertype']        
// $_SESSION['userEmail']  
// $_SESSION['schoolID']   
// $_SESSION['userType']   

  session_start();
  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../index.php");
  }
  else if ($levelCheck=='A'){
    header("location: index.php"); 
  }

  if (!isset($_POST['oldLogin'])) {
    header("location: studentEntry.php"); 
  }


  $query = "";
    $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($pass_row = mysqli_fetch_array ($result)) {

            $lname       = $pass_row['5']; 
            $gender     = $pass_row['3'];   
            $submitted  = $pass_row['0'];       
            $draft      = $pass_row['2'];   
            if ($gender=="Male") {
              $prefix="Mr.";
            }
            else{
              $prefix="Ms.";
            }

      }
    }
  }

 // $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo SCHOOL_NAME; ?></title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

  <link rel="stylesheet" type="text/css" href="assets/css/css-home.css">
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
require 'includes/navAndSide2.php';
?>
<!-- nav bar & side bar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
 

  <div class="container-fluid ">

  </div>

  </div>
</div>
  <!-- /.content-wrapper -->


<?php 

require 'assets/scripts.php';

?>
<?php require '../maintenanceChecker.php';
  ?>
</body>
</html>
