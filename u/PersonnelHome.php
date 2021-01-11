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
    header("location: ../login.php");
  }

  else if ($levelCheck=='A'){
    header("location: index.php"); 
  }
  else if ($levelCheck=='P'){
    header("location: home.php");
  }
  else if ($levelCheck == 'S') {
      header("location: index.php");
  }

  $query = "select a.*,b.isReset,b.isSecQuestions,b.pID FROM tbl_Personnel AS a INNER JOIN tbl_parentuser AS b ON a.Personnel_Id = b.pID where userID = ".$user_check." LIMIT 1";

  $result = mysqli_query($conn,  $query);
  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      if ($row = mysqli_fetch_array ($result)) {
       $Fname = $row[3];
       $Mname = $row[4];
       $Lname = $row[5]; 
       $isReset = $row[12]; 
       $isSecQues = $row[13];
       $pID = $row[14];
      }
    }
  } 
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
require 'includes/navAndSide3.php';
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
              <img class="logo" src="../assets/imgs/prismLogo.png" width="180px;" style="padding-left: 10px;padding-top: 50px;" >
            </div>
            <div class="col-sm-6" >
            </div>
            <div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5">
        <div class="row">
          <div class="col-lg-12">
            <p class="welcome-lbl">Welcome, <?php echo $Fname; ?> <?php echo $Lname; ?>!</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6" style="">
            <div class="small-box" style="padding: 50px 0;height:344.3px">
              <div class="inner" style="text-align: center">
                <i class="fas fa-history" style="color: #FF7A21; font-size: 80px;"></i>
                <h3><sup style="font-size: 20px"></sup></h3>
                <p class="lead" style="color: gray; font-size: 18px;">No. of Pending<br>Appointments</p>
                <?php 
                $sql = "SELECT COUNT(*) as pending from tbl_appointment as b, tbl_PersonnelSched as a 
                WHERE a.DateSchedule >= CAST(NOW() AS DATE) AND b.PersonnelSched_Id=a.PersonnelSched_Id AND b.status='Pending' AND b.schoolYearID = '" . $schoolYearID . "' AND a.Personnel_Id=$pID";                
                $result = mysqli_query($conn, $sql); //rs.open sql,con
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<!--open of while -->
                  <p class="welcome-lbl" style="font-size: 55px;"><?php echo $row['pending']; ?></p>
									<?php
									} //close of while
                  ?>
              </div>
            </div>
          </div>
        
        <div class="col-lg-6" style="">
            <div class="small-box" style="padding: 50px 0;height:344.3px">
              <div class="inner" style="text-align: center">
                <i class="far fa-calendar-check" style="color: #29e33f; font-size: 80px;"></i>
                <h3><sup style="font-size: 20px"></sup></h3>
                <p class="lead" style="color: gray; font-size: 18px;">No. of Approved<br>Appointments</p>
                <?php $sql = "SELECT COUNT(*) as approve from tbl_appointment as b, tbl_PersonnelSched as a 
                WHERE a.DateSchedule >= CAST(NOW() AS DATE) AND b.PersonnelSched_Id=a.PersonnelSched_Id AND b.schoolYearID = '" . $schoolYearID . "' AND b.status='Approved' AND a.Personnel_Id=$pID";
									$result = mysqli_query($conn, $sql); //rs.open sql,con
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<!--open of while -->
                  <p class="welcome-lbl" style="font-size: 55px;"><?php echo $row['approve']; ?></p>
									<?php
									} //close of while
                  ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
          <div class="col-lg-12" style="padding-top: 9px">
            </br></br>
          </div>
            <div class="card addshadow">
              <div class="card-header bg-dark">
                <h2 class="card-title" style="font-size: 21px;">Announcements</h2>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2 card-overflow">
<?php 
          $sql = "select * FROM tbl_announcement where schoolYearID = '" . $schoolYearID . "' AND dateEnd >= CAST(NOW() AS DATE) && dateStart <= CAST(NOW() AS DATE) ORDER BY dateCreated DESC ";
           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){

                  $announceID   = $row[0];
                  $title        = $row[1];
                  $subtitle     = $row[2];
                  $image     = $row[9];
                  $dateCreated  = date_format(date_create($row[4]),"M d, Y");

                  echo '<li class="item">';
                  echo '<div class="product-img">';
                  if (trim(strlen($image))>1) {
                    if (file_exists('uploads/'.$image)) {
                  echo '<img src="uploads/'.$image.'" alt=" " class="img-size-50">';
                      # code...
                    }
                  }
                  echo '</div>';
                  echo '<div class="product-info">';
                  echo '<a href="viewpersonnelAnnouncement.php?Aid='.$announceID.'" class="product-title" ><span style="font-size:18px;">'.$title;
                  echo '</span><span class="badge badge-warning float-right">'.$dateCreated.'</span></a>';
                  echo '<span class="product-description "><span style="font-size:18px;">'.$subtitle;
                  echo '</span></span>';
                  echo '</div>';
                  echo '</li>';

                }
              }
              else{
                echo '<br><br><br><div class="col-sm-12">';
                echo '<div class="card card-primary">';
                echo '<div class="card-header">';
                echo '<h3 class="card-title">Notice</h3>';
                echo '</div>';
                echo '<div class="card-body">';
                echo 'There is no announcement at the moment';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
              if ($isSecQues == 1) {
                displayMessage("warning", "Required", "You are required to define your security question under Account Settings.");
              }
              elseif ($isReset == 2) {
                
                displayMessage("warning", "Please change your password","Your password is default");
              }
              elseif ($isReset == 1) {
                
                displayMessage("warning", "Please change your password", "Your password has been reset by admin");
              }
              
 ?>


                </ul>
              </div>
              <!-- /.card-body -->

              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            
        
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
