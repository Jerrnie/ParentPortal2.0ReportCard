<?php
ob_start();
function isActive($page, $navtitle)
{
  if ($page == $navtitle) {
    echo "active";
  } else {
    echo "";
  }
}
function treeOpen($page, $navtitle)
{
  if (strpos($page, $navtitle)) {
    echo "menu-open";
  } else {
    echo "";
  }
}
function titlePage()
{
  echo SCHOOL_NAME;
}
require './/../include/getschoolyear.php';

?>
<style type="text/css">
  #dropinterval {
    max-height: 250px;
    margin-bottom: 10px;
    overflow-y: scroll;
    width: 200px;
    left: 50%;
    margin-left: -130px;
    -webkit-overflow-scrolling: touch;
  }
</style>
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

  
  $result2 = "";
  $result3 = "";
  $result4 = "";
  $result5 = "";
  $date1 = " ";
  $date2 = " ";
  $date3 = " ";
  $date4 = " ";
  $query1 = mysqli_query($conn, "SELECT a.Message_Id, a.MessageBody, a.SenderUser_Id, 
                  a.ReceiverUserId, b.userID 
                  FROM tbl_Message a
                  LEFT JOIN tbl_parentuser b ON a.SenderUser_Id = b.userID
                 WHERE a.ReceiverUserId = '" . $_SESSION['userID'] . "' 
                 AND a.ReadTag ='0'
                 AND a.schoolYearID = '" . $schoolYearID . "'");
  $result1 = mysqli_num_rows($query1);


  $query2 = mysqli_query($conn, "SELECT 
  a.RequestAppoint_Id,a.Weblink, a.PostedDateTime,c.firstName     
  FROM tbl_PersonnelRequestAppointment a 
  LEFT JOIN tbl_ParentAttendAppointment b ON b.RequestAppointment_Id = a.RequestAppoint_Id
  LEFT JOIN tbl_student c ON c.studentID = b.studentID                    
  WHERE c.userID = '" . $_SESSION['userID'] . "' AND b.ReadTag = '1' AND a.DateSchedule >= CAST(NOW() AS DATE)  
  AND a.schoolYearID = '" . $schoolYearID . "'");
  $result2 = mysqli_num_rows($query2);

  
  $query3 = mysqli_query($conn,"SELECT DISTINCT D.Personnel_code, CONCAT(D.Lname,', ',D.Fname,' ', D.Mname) AS PersonnelName,D.Position,E.sectionName,
  E.sectionYearLevel,F.DateSchedule,F.SchedTimeTo,F.SchedTimeFrom,F.WebLink,F.personnelsched_Id,D.Personnel_Id
  FROM tbl_student A
  JOIN tbl_PersonnelSection B ON B.sectionID = A.sectionID
  LEFT JOIN tbl_parentuser C ON C.userID = A.userID
  LEFT JOIN tbl_Personnel D ON D.Personnel_Id = B.Personnel_Id 
  LEFT JOIN tbl_sections E ON E.sectionID = B.sectionID
  LEFT JOIN tbl_PersonnelSched F ON F.Personnel_Id = B.Personnel_Id 
  WHERE C.userID = '".$_SESSION['userID']."' AND F.DateSchedule >= CAST(NOW() AS DATE) AND F.occupied = 0 AND F.status ='1'
  AND F.schoolYearID = '" . $schoolYearID . "'");
  $result3 = mysqli_num_rows($query3);

  $query4 = mysqli_query($conn,"SELECT A.approvedDateTIme
  from tbl_appointment A
  left join tbl_parentuser U on U.userID = A.ParentId
  Left join tbl_PersonnelSched S on S.PersonnelSched_Id = A.PersonnelSched_Id
  Left join tbl_Personnel P on P.Personnel_Id = S.Personnel_Id 
  where (A.status ='Approved')
   and U.userID = '".$_SESSION['userID']."'
   AND A.schoolYearID = '" . $schoolYearID . "' AND ReadTag = '3'");
  $result4 = mysqli_num_rows($query4);

  $query5 = mysqli_query($conn,"SELECT A.approvedDateTIme
  from tbl_appointment A
  left join tbl_parentuser U on U.userID = A.ParentId
  Left join tbl_PersonnelSched S on S.PersonnelSched_Id = A.PersonnelSched_Id
  Left join tbl_Personnel P on P.Personnel_Id = S.Personnel_Id 
  where (A.status ='Denied')
   and U.userID = '".$_SESSION['userID']."'
   AND A.schoolYearID = '" . $schoolYearID . "' AND ReadTag = '3'");
  $result5 = mysqli_num_rows($query5);
  
  ?>
<div class="row">  


  <ul class="navbar-nav ml-auto navbar-center scrollable-menu">
    <li class="nav-item dropdown">
      <p class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false" id=" drop">
        <i class="far fa-comments" style="font-size:30px"></i><span class="badge badge-warning navbar-badge" id="count"><?php echo $result1; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center scrollable-menu" aria-labelledby="drop" id="dropinterval">
          <span class="dropdown-header">Notification</span>

          <?php
          $query2 = mysqli_query($conn, "SELECT a.SenderUser_Id, a.ReceiverUserId,  
          a.MessageBody, a.PostedDateTime,
          b.Subject_Id, d.fullName
          FROM tbl_Message a 
          LEFT JOIN tbl_MessageThread b ON b.Message_Id = a.Message_Id
          -- LEFT JOIN tbl_MessageSubject c ON c.Subject_Id = b.Subject_Id
          LEFT JOIN tbl_parentuser d ON a.SenderUser_Id = d.userID
          WHERE a.ReceiverUserId = '" . $_SESSION['userID'] . "' AND a.ReadTag = '0' 
          AND a.schoolYearID = '" . $schoolYearID . "'
          ORDER BY a.PostedDateTime Desc");

          // $result = mysqli_query($conn, $query2);
          if (mysqli_num_rows($query2) > 0) {
            while ($row = mysqli_fetch_array($query2)) {
              $sID = $row[0];
              $msgbody = $row[2];
              $subjID = $row[4];
              $fname = $row[5];
              // $lname = $row[6];
              $date = date_format(date_create($row[3]), "Y-m-d H:i:s");

                                                                    $salt = "Ph03n1x927";

                                                                    $var1 = md5($salt.$row[4].$row[0]);
                                                                    $var2 = md5($salt.$row[4].$row[1]);


                                                                    $encodeThis1 = urlencode(base64_encode($row[4]));
                                                                    $encodeThis2 = urlencode(base64_encode($row[0]));
                                                                    $encodeThis3 = urlencode(base64_encode($row[1]));
                                                                    $encodeThis4 = urlencode(base64_encode($var1));
                                                                    $encodeThis5 = urlencode(base64_encode($var2));


              echo '<a class="dropdown-item text-primary" href="readmail2.php?page=' . $encodeThis1 . '&id=' . $encodeThis2 . '&hash='.$encodeThis4.'">' . $fname . '</a>';
              echo '<p style="text-align:center"> ' . facebook_time_ago1($date) . '</p>';
              echo '<div class="dropdown-divider"></div>';
            }
          } else {
            echo '<p style="text-align:center"><i></i>No new message(s).</p>';
          }

          ?>
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
    <img src="<?PHP echo "../" . SCHOOL_LOGO_PATH ?>" alt="<?PHP echo SCHOOL_ABV ?>" class="brand-image img-circle elevation-3" style="opacity: .8;">
    <span class="brand-text font-weight-light title-right lead"><?PHP echo SCHOOL_ABV ?> | Parent Portal</span>
  </span>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-child-indent nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="home.php" class="nav-link <?php isActive($page, "home"); ?>">
            <i class="nav-icon fa fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="viewStudent.php" class="nav-link <?php isActive($page, "viewStudent"); ?> ">
            <i class="nav-icon fa fa-user"></i>
            <p>
              Student Information
            </p>
          </a>
        </li>


        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-envelope" aria-hidden="true"></i>
            <p>
              Message
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="composeUser.php" class="nav-link <?php isActive($page, "composeUser"); ?>">
                <i class="nav-icon fa fa-pencil-alt"></i>
                <p>Compose Message</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="inboxUser.php" class="nav-link <?php isActive($page, "inboxUser"); ?>">
                <i class="nav-icon fa fa-envelope-open"></i>
                <p>Inbox</p>
              </a>
            </li>
          </ul>
        </li>




        <!-- <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-envelope" aria-hidden="true"></i>
            <p>
              Appointment
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="composeUser.php" class="nav-link <?php isActive($page, "composeUser"); ?>">
                <i class="nav-icon fa fa-pencil-alt"></i>
                <p>Request Appointment</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="inboxUser.php" class="nav-link <?php isActive($page, "inboxUser"); ?>">
                <i class="nav-icon fa fa-envelope-open"></i>
                <p>View Personnel Schedule</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="readmail2.php" class="nav-link <?php isActive($page, "readmail2"); ?>">
                <i class="nav-icon fa fa-envelope-open"></i>
                <p>Appointment History</p>
              </a>
            </li>
          </ul>
        </li> -->


        <li class="nav-item">
          <a href="userSettings.php" class="nav-link <?php isActive($page, "AccountSettings"); ?> ">
            <i class="nav-icon fa fa-cog"></i>
            <p>
              Account Settings
            </p>
          </a>
        </li>
        <li class="nav-item">
        <a href="ParentUserManual.php" class="nav-link <?php isActive($page, "ParentUserGuide"); ?> ">
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
