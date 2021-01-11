
<?php 
ob_start();
 function isActive($page, $navtitle)
{
	if ($page == $navtitle) {
		echo "active";		
	}
	else{
		echo "";
	}
}
function treeOpen($page, $navtitle)
{
	if (strpos($page, $navtitle)) {
		echo "menu-open";		
	}
	else{
		echo "";
	}
}
 function titlePage()
{
	echo SCHOOL_NAME;
}
require './/../include/getschoolyear.php';

 ?>



 <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <b class="text-secondary">
        <h3><?php titlePage(); ?></h3>
      </b>
    </li>
  </ul>

  <!-- Notification -->
  <?php
  date_default_timezone_set('Asia/Manila');
  function facebook_time_ago1($timestamp)
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

  $result1 = "";
  $date2 = " ";
  $query1 = mysqli_query($conn, "SELECT A.RequestRemarks, A.DateTimeRequested, A.status,U.fullName as ParentName,
  DAte(S.DateSchedule) as DateSchedule, S.occupied, S.WebLink, S.SchedTimeFrom, S.SchedTimeTo,
  P.Personnel_code,
  concat(P.Fname,' ', P.Mname,' ',P.Lname) as PersonnelName,P.Position,A.Appoint_Id,A.PersonnelSched_Id
  from tbl_appointment A
  left join tbl_parentuser U on U.userID = A.ParentId
  Left join tbl_PersonnelSched S on S.PersonnelSched_Id = A.PersonnelSched_Id
  Left join tbl_Personnel P on P.Personnel_Id = S.Personnel_Id 
  where A.status ='Pending' and S.Personnel_Id = '".$_SESSION['pID']."'
  AND A.schoolYearID = '" . $schoolYearID . "'
  Order by DateSchedule");
  
  $result1 = mysqli_num_rows($query1);

  ?>
<div class="row">  
  <ul class="navbar-nav ml-auto navbar-center scrollable-menu">
    <li class="nav-item dropdown">
      <p class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false" id="drop">
        <i class="far fa-bell" style="font-size:30px"></i><span class="badge badge-warning navbar-badge" id="count"><?php echo $result1?> </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center scrollable-menu" aria-labelledby="drop" id="dropinterval">
          <span class="dropdown-header">Notification</span>

          <?php
          $query2 = mysqli_query($conn, "SELECT A.DateTimeRequested
          from tbl_appointment A
          left join tbl_parentuser U on U.userID = A.ParentId
          Left join tbl_PersonnelSched S on S.PersonnelSched_Id = A.PersonnelSched_Id
          Left join tbl_Personnel P on P.Personnel_Id = S.Personnel_Id 
          where A.status ='Pending' and S.Personnel_Id = '".$_SESSION['pID']."'
          AND A.schoolYearID = '" . $schoolYearID . "'
          Order by A.DateTimeRequested ASC LIMIT 1");
          
          if (mysqli_num_rows($query2) > 0) {
            while ($row = mysqli_fetch_array($query2)) {              
                         
              $date2 = date_format(date_create($row[0]), "Y-m-d H:i:s");
             
            }
          }
          ?>
        <div class="dropdown-divider"></div>
          <a href="personnelRequestApproval.php" class="dropdown-item">
            <i class="far fa-calendar-alt mr-2"></i> <?php echo $result1 ?> Pending Approval
            <span class="float-right text-muted text-sm"><?php echo facebook_time_ago1($date2) ?></span>
          </a>                 
        </div>
    </li>
  </ul>  
</div>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <strong class="nav-link-special ">S.Y. <?php echo $schoolYear ?></strong>
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">

        <i class="fa fa-user"></i>
        <!-- <span class="badge badge-warning navbar-badge">15</span> -->
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="../index.php?logout" type="button" class="btn btn-block btn-outline-danger ">
          Log Out <i class="fa fa-sign-out-alt"></i></a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <span class="brand-link ">
      <img  src="<?PHP echo "../".SCHOOL_LOGO_PATH?>" alt="<?PHP echo SCHOOL_ABV?>" class="brand-image img-circle elevation-3"
           style="opacity: .8;">
      <span class="brand-text font-weight-light title-right lead"><?PHP echo SCHOOL_ABV?> | Parent Portal</span>
    </span>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-child-indent nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="PersonnelHome.php" class="nav-link <?php isActive($page,"home");?>">
              <i class="nav-icon fa fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>
<?php
// $user_check = $_SESSION['userID'] ;
// $sql = "SELECT count(*)  as students FROM tbl_parentuser AS a ,tbl_student AS b WHERE a.userID = b.userID AND a.userID= ".$user_check ;
// $result = mysqli_query($conn, $sql); //rs.open sql,con
// while ($row = mysqli_fetch_assoc($result)){

// $count = $row['students'];
// if($count > 0){
//   echo' <li class="nav-item">';
//   echo'<a href="viewStudent.php" class="nav-link current" isActive($page, "audittrail") >';
//   echo'  <i class="nav-icon fa fa-user"></i>';
//   echo' <p>Student Information</p>';
//   echo'</a>';
//   echo'</li>';
// }
// }
?>


          <li class="nav-item">
            <a href="PersonnelAttendance.php" class="nav-link <?php isActive($page,"PersonnelAttendance");?> " >
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                 Attendance
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="personnelAddSchedule.php" class="nav-link <?php isActive($page,"personnelAddSchedule");?> " >
              <i class="nav-icon far fa-calendar-plus"></i>
              <p>
                 Add/View Schedule
              </p>
            </a>
          </li>
        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-book" aria-hidden="true"></i>
            <p>
              Appointment
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="personnelRequestApproval.php" class="nav-link <?php isActive($page, "personnelRequestApproval"); ?>">
                <i class="nav-icon fa fa-pencil-alt"></i>
                <p>Pending Approval</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="personnelRequestAppointmentHistory.php" class="nav-link <?php isActive($page, "personnelRequestAppointmentHistory"); ?>">
                <i class="nav-icon fa fa-history"></i>
                <p>Approval History</p>
              </a>
            </li>            
            <li class="nav-item">
              <a href="personnelRequestAppoint.php" class="nav-link <?php isActive($page, "personnelRequestAppoint"); ?>">
                <i class="nav-icon far fa-calendar"></i>
                <p>Request Appointment</p>
              </a>
            </li>
                        
            <li class="nav-item">
              <a href="PersonnelRequestAppointHistory.php" class="nav-link <?php isActive($page, "PersonnelRequestAppointHistory"); ?>">
                <i class="nav-icon far fa-calendar"></i>
                <p>Request History</p>
              </a>
            </li>
          </ul>
        </li>

          <li class="nav-item">
            <a href="personnelCalendar.php" class="nav-link <?php isActive($page,"personnelCalendar");?> " >
              <i class="nav-icon fa fa-calendar"></i>
              <p>
                Events Calendar
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="PersonnelSettings.php" class="nav-link <?php isActive($page,"AccountSettings");?> " >
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Account Settings
              </p>
            </a>
          </li>
        <li class="nav-item">
        <a href="PersonnelUserManual.php" class="nav-link <?php isActive($page, "ParentUserGuide"); ?> ">
            <i class="nav-icon fas fa-pager"></i>
            <p>
              User Manual
            </p>
          </a>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>