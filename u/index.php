<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../include/getVersion.php';
$page = "index";
session_start();
?>

<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Home | Parent Portal</title>
	<link rel="shortcut icon" href="../assets/imgs/favicon.ico">
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/css-home.css"> -->
	<!-- customize css -->
	<link rel="stylesheet" type="text/css" href="assets/css/hideAndNext.css">
	<!-- sweet alert -->
	<link rel="stylesheet" type="text/css" href="assets/css/css-navAndSlide.css">
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

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
	<div class="wrapper">

		<!-- nav bar & side bar -->
		<?php
		require 'includes/navAndSide.php';

		$user_check = $_SESSION['userID'];
		$levelCheck = $_SESSION['usertype'];
		if (!isset($user_check)) {
			session_destroy();
			header("location: ../login.php");
		} else if ($levelCheck == 'P') {
			header("location: home.php");
		} else if ($levelCheck == 'E') {
			header("location: PersonnelHome.php");
		}
		?>
		<!-- nav bar & side bar -->


		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>Dashboard</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item active">Dashboard</li>
							</ol>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>

			<!-- <div class="content-header"> -->
			<!-- Main content -->
			<section class="content">
				<!-- <div class="box span12"> -->

				<!-- /Dashboard -->
				<div class="row">
					<div class="col-lg-1">
					</div>
					<div class="col-lg-2">
						<div class="card-body display nowrap" style="width:100%;">
							<table class="table table-striped table-bordered " style="text-align:center;
								 font-size: 150%;font-weight:bold;">
								<thead>
									<tr>
										<th style="background-color:#DA70D6;font-size: 60%">Posted<br>Events</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "select Count(*) as events FROM events where schoolYearID = '" . $schoolYearID . "'";
									$result = mysqli_query($conn, $sql); //rs.open sql,con
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<!--open of while -->
										<tr>
											<td><?php 
											
											$count = $row['events'];
											$eventscount = number_format($count);
											// echo $eventscount;
											echo "--";

										?></td>
										</tr>
									<?php
									} //close of while
									?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="card-body display nowrap" style="width:100%;">
							<table class="table table-striped table-bordered " style="text-align:center;
								 font-size: 150%;font-weight:bold;">
								<thead>
									<tr>
										<th style="background-color:#FFFF66;font-size: 60%">Pending<br>Appointment</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "select count(*) as pending from tbl_appointment where status = 'Pending' AND schoolYearID = '" . $schoolYearID . "'";
									$result = mysqli_query($conn, $sql); //rs.open sql,con
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<!--open of while -->
										<tr>
											<td><?php 
											$count = $row['pending'];
											$pendingcount = number_format($count);
											// echo $pendingcount;
											echo "--";
											 ?></td>
										</tr>
									<?php
									} //close of while
									?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="card-body display nowrap" style="width:100%">
							<table class="table table-striped table-bordered " style="text-align:center; font-size: 150%;font-weight:bold">
								<thead>
									<tr>
										<th style="background-color:#7FFF00;font-size: 60%">Registered<br>Students</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "select count(*) as student from tbl_student WHERE schoolYearID = '" . $schoolYearID . "'";
									$result = mysqli_query($conn, $sql); //rs.open sql,con
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<!--open of while -->
										<tr>
											<td><?php 
											$count = $row['student'];
											$studentcount = number_format($count);
											echo $studentcount;
											 
											 ?></td>
										</tr>
									<?php
									} //close of while
									?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="card-body display nowrap" style="width:100%">
							<table class="table table-striped table-bordered " style="text-align:center; font-size: 150%;font-weight:bold">
								<thead>
									<tr>
										<th style="background-color:#00BFFF;font-size: 60%">Registered<br>Personnel<br></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "select count(*) as personnel from tbl_Personnel a,tbl_parentuser as b WHERE a.schoolYearID = '" . $schoolYearID . "' AND a.Personnel_Id = b.pID";
									$result = mysqli_query($conn, $sql); //rs.open sql,con
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<!--open of while -->
										<tr>
											<td><?php 
											
											$count = $row['personnel'];
											$personnelcount = number_format($count);
											// echo $personnelcount;
											echo "--";
											
										?></td>
										</tr>
									<?php
									} //close of while
									?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="card-body display nowrap" style="width:100%">
							<table class="table table-striped table-bordered " style="text-align:center; font-size: 150%;font-weight:bold">
								<thead>
									<tr>
										<th style="background-color: #FF0000;font-size: 60%">Registered<br>Users</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "select count(*) as users from tbl_parentuser WHERE usertype = 'P' AND schoolYearID = '" . $schoolYearID . "'";
									$result = mysqli_query($conn, $sql); //rs.open sql,con
									while ($row = mysqli_fetch_assoc($result)) { ?>
										<!--open of while -->
										<tr>
											<td><?php 
												$count = $row['users'];
												$userscount = number_format($count);
												echo $userscount;
											 ?></td>
										</tr>
									<?php
									} //close of while
									?>
								</tbody>
							</table>
							
							<br>	
						</div>
					</div>
			</div>
			
			<section class="content">
				<!-- <div class="box span12"> -->

				<!-- /Dashboard -->
				<div class="row">
					<div class="col-lg-6">
					<div class="card addshadow">
              <div class="card-header bg-dark">
                <h2 class="card-title" style="font-size: 21px;"><b>Upcoming Events</b></h2>

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
          $sql = "select * FROM events where schoolYearID = '" . $schoolYearID . "' AND start >= CAST(NOW() AS DATE) ORDER BY start ASC LIMIT 5";
           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){

                  $announceID   = $row[0];
				  $title        = $row[1];
				  $start        = date_format(date_create($row[5]),"M d, Y");
                  $subtitle     = $row[3];
                  $dateCreated  = date_format(date_create($row[7]),"M d, Y");

                  echo '<li class="item">';
                  echo '<a class="product-title" ><span style="font-size:18px;">'.$title;
                  echo '</span><span class="badge badge-warning float-right">Start :'.$start.'</span></a>';
                  echo '<span class="product-description "><span style="font-size:18px;">'.$subtitle;
                  echo '</span></span>';
                  echo '</li>';

                }
              }
              else{
                echo '<br><br><br><div class="col-sm-12">';
                echo '<div class="card">';
                echo '<div class="card-header bg-dark">';
                echo '<h3 class="card-title">Notice</h3>';
                echo '</div>';
                echo '<div class="card-body">';
                echo 'There is no events at the moment';
                echo '</div>';
                echo '</div>';
                echo '</div>';
			  }
			?>
                </ul>
			</div>
		</div>

					</div>
					<div class="col-lg-4" hidden>
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
  $dateCreated  = date_format(date_create($row[4]),"M d, Y");

  echo '<li class="item">';
  echo '<div class="product-img">';
  echo '<img src="dist/img/default-150x150.png" alt="" class="img-size-50">';
  echo '</div>';
  echo '<div class="product-info">';
  echo '<a href="viewAnnouncement.php?Aid='.$announceID.'" class="product-title" ><span style="font-size:18px;">'.$title;
  echo '</span><span class="badge badge-warning float-right">'.$dateCreated.'</span></a>';
  echo '<span class="product-description "><span style="font-size:18px;">'.$subtitle;
  echo '</span></span>';
  echo '</div>';
  echo '</li>';

}
}
else{
echo '<br><br><br><div class="col-sm-12">';
echo '<div class="card">';
echo '<div class="card-header bg-dark">';
echo '<h3 class="card-title">Notice</h3>';
echo '</div>';
echo '<div class="card-body">';
echo 'There is no announcement at the moment';
echo '</div>';
echo '</div>';
echo '</div>';
}
?>
                </ul>
			</div>
		</div>

					</div>

					<div class="col-lg-4" hidden>
					<div class="card addshadow">
              <div class="card-header">
                <h2 class="card-title" style="font-size: 21px;">New Messages</h2>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2 card-overflow" >
			<?php 
         
date_default_timezone_set('Asia/Manila');
function facebook_time_ago($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes      = round($seconds / 60);           // value 60 is seconds  
    $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
    $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
    $weeks          = round($seconds / 604800);          // 7*24*60*60;  
    $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
    $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
    if ($seconds <= 60) {
        return "Just Now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "one minute ago";
        } else {
            return "$minutes minutes ago";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "an hour ago";
        } else {
            return "$hours hrs ago";
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return "yesterday";
        } else {
            return "$days days ago";
        }
    } else if ($weeks <= 4.3) //4.3 == 52/12  
    {
        if ($weeks == 1) {
            return "a week ago";
        } else {
            return "$weeks weeks ago";
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "a month ago";
        } else {
            return "$months months ago";
        }
    } else {
        if ($years == 1) {
            return "one year ago";
        } else {
            return "$years years ago";
        }
    }
}

$sql =
    "SELECT DISTINCT a.SenderUser_Id, d.fullName, 
a.ReceiverUser_Id, e.fullName, b.MessageBody,  
b.PostedDateTime, a.Subject_Id
FROM tbl_MessageThread a
LEFT JOIN tbl_Message b ON a.Message_Id = b.Message_Id
LEFT JOIN tbl_MessageSubject c ON c.Subject_Id = a.Subject_Id
LEFT JOIN tbl_parentuser d ON a.SenderUser_Id = d.userID
LEFT JOIN tbl_parentuser e on a.ReceiverUser_Id = d.userID
WHERE a.SenderUser_Id = '" . $_SESSION['userID'] . "'
OR a.ReceiverUser_Id= '" . $_SESSION['userID'] . "'  
AND PostedDateTime >= CAST(NOW() AS DATE) AND b.ReadTag = '0' ORDER BY b.PostedDateTime desc LIMIT 5";
$result1 = mysqli_query($conn, $sql);



$ctr = 0;
if (mysqli_num_rows($result1) > 0) {
    $counter = 0;
    $addUser = array();
    while ($row = mysqli_fetch_array($result1)) {

        $sID = $row[0];
        $sFname = $row[1];
        $rID = $row[2];
        $rFname = $row[3];

        // $subject = $row[6];
        $message = $row[4];

        $date = date_format(date_create($row[5]), "M d, Y h:i A");
        // $out1 = strlen($subject) > 25 ? substr($subject, 0, 25) . "..." :  $subject;
        $out = strlen($message) > 20 ? substr($message, 0, 20) . "..." :  $message;
        $subjID = $row[6];
			   
				  echo '<li class="item">';
				  echo '<a href="readmail.php?page=' . $row[6] . '&id=' . $row[0] . '">';
				  echo' <span style="font-size:18px;" class="product-title">'.$sFname;
				  echo '</span><span class="badge badge-warning float-right">'.facebook_time_ago1($date).'</span></a>';
                  echo '<span class="product-description "><span style="font-size:18px;">'.$out;
                  echo '</span></span>';
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
                echo 'There is no messages at the moment';
                echo '</div>';
                echo '</div>';
                echo '</div>';
			  }
			?>
                </ul>
		
		
			</div>
		</div>


					</div>

					<div class="col-lg-6">
					<div class="card addshadow">
              <div class="card-header bg-dark">
                <h2 class="card-title" style="font-size: 21px;"><b>Request for Password Reset</b></h2>

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
          $sql = "select * FROM tbl_parentuser where schoolYearID = '" . $schoolYearID . "' AND resetRequest ='Yes' LIMIT 7";
           $result1 = mysqli_query($conn, $sql);
            $ctr=0;
              if (mysqli_num_rows($result1) > 0) {
                while($row = mysqli_fetch_array($result1)){

                  $announceID   = $row[0];
				  $fname        = $row[15];
			     // $requestdate  = date_format(date_create($row[7]),"M d, Y");

                  echo '<li class="item" style="height:53px">';
                  echo '<span style="font-size:18px;">'.$fname;
                  //echo '</span><span class="badge badge-warning float-right">Start :'.$start.'</span></a>';
                  //echo '</span>';
                  echo '</span>';
                  echo '</li>';

                }
              }
              else{
                echo '<br><br><br><div class="col-sm-12">';
                echo '<div class="card">';
                echo '<div class="card-header bg-dark">';
                echo '<h3 class="card-title">Notice</h3>';
                echo '</div>';
                echo '<div class="card-body">';
                echo 'There is no request at the moment';
                echo '</div>';
                echo '</div>';
                echo '</div>';
			  }
			?>
                </ul>
		
		
			</div>
		</div>

					</div>

			
			</div>
			<!-- /.card-body -->

			</section>
		</div>
		
		<?php include 'footer.php';?>
		
		<!--/row-->
		</div>
		<!-- ./wrapper -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#example').DataTable({
					"scrollY": 200,
					"scrollX": true
				});
			});
		</script>
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
		<script src="includes/sessionChecker.js"></script>
		<script type="text/javascript">
			extendSession();
			var isPosted;
			var isDisplayed = false;
			setInterval(function() {
				sessionChecker();
			}, 20000); //time in milliseconds 
		</script>


  <?php require '../maintenanceChecker.php';

?>

</body>
<script type="text/javascript" src="assets/scripts/hideAndNext.js"></script>
<script>
	$(function() {
		$("#example1").DataTable({});
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
		});
	});

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

	$(document).ready(function() {
		$('#example').DataTable({
			"scrollY": 200,
			"scrollX": true
		});
	});
</script>

</html>
