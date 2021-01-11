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

  $query1 = mysqli_query($conn, "SELECT a.Message_Id, a.MessageBody, a.SenderUser_Id, a.ReceiverUserId, b.userID
                  FROM tbl_Message a
                  LEFT JOIN tbl_parentuser b ON a.SenderUser_Id = b.userID
                 WHERE a.ReceiverUserId = '" . $_SESSION['userID'] . "' AND a.ReadTag ='0' AND a.schoolYearID = '" . $schoolYearID . "'");
  $result1 = mysqli_num_rows($query1);

  ?>

  <ul class="navbar-nav ml-auto navbar-center scrollable-menu">
    <li class="nav-item dropdown ">
      <p class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false id=" drop">
        <i class="far fa-bell" style="font-size:30px"></i><span class="badge badge-warning navbar-badge" id="count"><?php echo $result1; ?></span>
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

              echo '<a class="dropdown-item text-primary" href="readmail.php?page=' . $encodeThis1 . '&id=' . $encodeThis2 . '&hash='.$encodeThis4.'">' . $fname . '</a>';
              echo '<p style="text-align:center"> ' . facebook_time_ago1($date) . '</p>';
              echo '<div class="dropdown-divider"></div>';
            }
          } else {
            echo '<p style="text-align:center"><i></i>No new message(s).</p>';
          }

          ?>


          <!-- <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a> -->
          <!--
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
         -->
          <!-- <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>-->
        </div>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <strong class="nav-link-special ">S.Y. <?php echo $schoolYear ?>
      <?php
      $levelCheck = $_SESSION['usertype'];

      if ($levelCheck == 'S') {
        echo '- Support';
      } else {
        echo '- Admin';
      }

      ?>
    </strong>
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">

        <i class="fa fa-user"></i>
        <!-- <span class="badge badge-warning navbar-badge">15</span> -->
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="../login.php?logout" type="button" class="btn btn-block btn-outline-danger ">
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
          <a href="index.php" class="nav-link <?php isActive($page, 'index'); ?>">
            <i class="nav-icon fa fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <!-- <li class="nav-item">
            <a href="adminchangepass.php" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="adminchangeschoolyear.php" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Change School Year
              </p>
            </a>
          </li> -->

        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-file-import" aria-hidden="true"></i>
            <p>
              Import Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="courseImport.php" class="nav-link <?php isActive($page, "courseImport"); ?>">
                <i class="nav-icon fa fa-list-ul"></i>
                <p>Sections</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="studentImport.php" class="nav-link <?php isActive($page, "studentImport"); ?>">
                <i class="nav-icon fa fa-graduation-cap"></i>
                <p>Students</p>
              </a>
            </li>


          </ul>
        </li>

        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-file-pdf" aria-hidden="true"></i>
            <p>
              Upload Files
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="reportCardView.php" class="nav-link <?php isActive($page, "reportCardView"); ?>">
                <i class="nav-icon fa fa-id-card"></i>
                <p>Report Card</p>
              </a>
            </li>


          </ul>
        </li>
        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-bullhorn" aria-hidden="true"></i>
            <p>
              Announcement
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="publishA.php" class="nav-link <?php isActive($page, "AddAnnouncement"); ?>">
                <i class="nav-icon fa fa-pencil-alt"></i>
                <p>Add Announcement</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="viewAllAnnouncement.php" class="nav-link <?php isActive($page, "viewallAnnouncement"); ?>">
                <i class="nav-icon fa fa-bullseye"></i>
                <p>View Announcement</p>
              </a>
            </li>
          </ul>
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
              <a href="compose.php" class="nav-link <?php isActive($page, "compose"); ?>">
                <i class="nav-icon fa fa-pencil-alt"></i>
                <p>Compose Message</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="inbox.php" class="nav-link <?php isActive($page, "inbox"); ?>">
                <i class="nav-icon fa fa-envelope-open"></i>
                <p>Inbox</p>
              </a>
            </li>
          </ul>
        </li>



        <?php
        $levelCheck = $_SESSION['usertype'];
        if ($levelCheck == 'S') {
          echo '<li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>';
          echo '<a href="#" class="nav-link">';
          echo '<i class="nav-icon fa fa-clipboard-list" aria-hidden="true"></i>';
          echo '<p>Audit Trail 
          <i class="right fas fa-angle-left"></i></p>';
          echo '</a>';

          echo '<ul class="nav nav-treeview">';

          echo '<li class="nav-item">';
          echo  '<a href="audittrail.php" class="nav-link <?php isActive($page, "audittrail"); ?>';
          echo '<i class="nav-icon fa fa-calendar"></i>';
          echo '<p>View Activity Logs</p>';
          echo '</a>';
          echo '</li>';

          echo '<li class="nav-item">';
          echo '<a href="auditexport.php" class="nav-link <?php isActive($page, "auditexport"); ?>';
          echo '<i class="nav-icon fa fas fa-file-excel"></i>';
          echo '<p>Export Activity Logs</p>';
          echo '</a>';
          echo '</li>';

          echo '<li class="nav-item">';
          echo  '<a href="SEaudittrail.php" class="nav-link <?php isActive($page, "SEaudittrail"); ?>';
          echo '<i class="nav-icon fa fa-calendar"></i>';
          echo '<p>User Activity Logs</p>';
          echo '</a>';
          echo '</li>';

          echo '</ul>';

          echo '</li>';
        }

        ?>



        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="viewAllUser.php" class="nav-link <?php isActive($page, "viewAllUser"); ?>">
            <i class="nav-icon fa fas fa-user" aria-hidden="true"></i>
            <p>
              User Maintenance
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>" hidden>
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
            <p>
              Reports
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link <?php isActive($page, "exportpage"); ?>">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Grading</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?php treeOpen($page, "disable"); ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

          
            <li class="nav-item">
              <a href="adminchangepass.php" class="nav-link <?php isActive($page, "adminchangdeta"); ?>">
                <i class="nav-icon fa fa-lock"></i>
                <p>Change Password</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="adminchangeschoolyear.php" class="nav-link <?php isActive($page, "adminchangdeta"); ?>">
                <i class="nav-icon fa fa-calendar"></i>
                <p>Change School Year</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="passwordSecurity.php" class="nav-link <?php isActive($page, "passwordsecurity"); ?>">
                <i class="nav-icon fa fa-key"></i>
                <p>Password Security</p>
              </a>
            </li>
            
            <?php 
            
        $levelCheck = $_SESSION['usertype'];
        if ($levelCheck == 'S') {
            echo '<li class="nav-item">';
            echo '<a href="changeVersion.php" class="nav-link">';
            echo '<i class="nav-icon fa fa-cog"></i>';
            echo '<p>Change Version</p>';
            echo '</a>';
            echo '</li>';
        }
            ?>
            <li class="nav-item">
              <a href="adminSetting.php" class="nav-link <?php isActive($page, "adminchangedetails"); ?>">
                <i class="nav-icon fa fa-user-cog"></i>
                <p>Account Information</p>
              </a>
            </li>
          
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<script>
  // $(document).ready(function() {
  //   function load_unseen_notification(view = '') {

  //     $.ajax({
  //       url: "fetchnotif.php",
  //       method: "POST",
  //       data: {
  //         view: view
  //       },
  //       datatype: "json",
  //       success: function(data) {
  //         $('.dropdown-menu').html(data.notification);
  //         if (data.unseen_notification > 0) {
  //           $('.count').html(data.unseen_notification);
  //         }
  //       }
  //     });
  //   }

  //   load_unseen_notification();

  //   setInterval(function() {
  //     load_unseen_notification();
  //   }, 5000);
  // });
</script>