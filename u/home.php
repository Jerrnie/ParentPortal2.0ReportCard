<!DOCTYPE html>


<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  require 'assets/scripts/phpfunctions.php';
  $page="home";
  session_start();

  $isReset;
  $isSecQues;
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
  else if ($levelCheck=='E'){
    header("location: PersonnelHome.php");
  }
  else if ($levelCheck == 'S') {
      header("location: index.php");
  }

  #get the scope of parent
  
  $query = 'sELECT sectionID FROM tbl_student WHERE userID = '.$_SESSION['userID'];
          $result = mysqli_query($conn,  $query);
        if (mysqli_num_rows($result)==0) { $storedSections[] = 'x'; }

          else{
            while($row = mysqli_fetch_array($result))
            {
              $storedSections[] = $row[0];
            }
          }


  $query = "SELECT COUNT(userID),sex, fullName, isReset,isSecQuestions FROM tbl_parentuser WHERE userId =".$user_check;

 $result = mysqli_query($conn,  $query);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($pass_row = mysqli_fetch_array ($result)) {
            $isSecQues = $pass_row['4']; 
            $isReset       = $pass_row['3']; 
            $lname       = $pass_row['2']; 
            $gender     = $pass_row['1'];   
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
    <!-- sweet alert -->
  <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">

      <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">

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
  <div class="content">
    <div class="row" style="margin-top: 20px;">
      <div class="col-lg-12" >
        <div class="col-lg-12 bannerprism" style="height: 340px;">
          <br><br>
          <div class="row">
            <div class="col-sm-3" hidden>
              <img class="logo" src="../assets/imgs/prismLogo.png" width="180px;" style="padding-left: 10px;padding-top: 50px; " >
            </div>
            <div class="col-sm-6" >
            </div>
            <div class="col-sm-3 " >
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class ="row">
      
    <div class="col-lg-12">
    <p class="welcome-lbl" >Welcome, <?php echo  $lname ?>!</p> 
  </div>
  </div>


  <div class="row">
      <div class="col-lg-12">
          <div class="col-lg-12" style="padding-top: 1px">
        
          </div>
		
        <section class="content">
				<!-- <div class="box span12"> -->

				<!-- /Dashboard -->
				<div class="row">
					<div class="col-lg-6">


					</div>

					<div class="col-lg-6">


					</div>

			
			</div>
			<!-- /.card-body -->

			</section>
          </div>

        </div>
    </div>
  </div>
</div>
<?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
  </div>

  </div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false; 
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds 
</script>
<?php 

require 'assets/scripts.php';

?>
<?php require '../maintenanceChecker.php';
  ?>
</body>
</html>
