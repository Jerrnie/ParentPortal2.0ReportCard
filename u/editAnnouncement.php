<!DOCTYPE html>

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require '../assets/phpfunctions.php';
$page = "viewallAnnouncement";


// $_SESSION['userID']
// $_SESSION['first-name']
// $_SESSION['middle-name']
// $_SESSION['last-name']
// $_SESSION['usertype']
// $_SESSION['userEmail']
// $_SESSION['schoolID']
// $_SESSION['userType']

session_start();
$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
$userFname = $_SESSION['first-name'];
$userLname = $_SESSION['last-name'];
if (!isset($user_check) && !isset($password_check)) {
  session_destroy();
  header("location: ../login.php");
} else if ($levelCheck == 'P') {
  header("location: home.php");
} else if ($levelCheck == 'E') {
  header("location: PersonnelHome.php");
}

if (isset($_GET['page'])) {

  $query = "select * from tbl_announcement where announceID =" . $_GET['page'];
  $result = mysqli_query($conn,  $query);
  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      if ($row = mysqli_fetch_array($result)) {
        $announceID   = $row[0];
        $title        = $row[1];
        $html         = $row[3];
        $subtitle     = $row[2];
        $startDate    = date_format(date_create($row[6]), "M d, Y H:i:s");
        $endDate      = date_format(date_create($row[5]), "M d, Y H:i:s");
        $dateCreated  = date_format(date_create($row[4]), "M d, Y H:i:s");
        $image   = $row[9];
        $radio     = $row[10];
        $status    = 0;
        $haveAccess = 1;

        $query = "select * from tbl_audience where announceID =" . $announceID;
        
        $result = mysqli_query($conn,  $query);
        if (mysqli_num_rows($result)==0) { $selectedSections[] = 'x'; }

          else{
            while($row = mysqli_fetch_array($result))
            {
              $selectedSections[] = $row[1];
            }
          }
        //For Posting
        if (date("Y/m/d H:i:s") < date_format(date_create($row[6]), "Y/m/d H:i:s")) {
          $status    = '<td class="text-center" title="Your information reach the school"><h3><span class="badge badge-success">For Posting</span></h3></td>';
        }

        //Posted
        elseif (date("Y/m/d H:i:s") >= date_format(date_create($row[6]), "Y/m/d H:i:s") && date("Y/m/d H:i:s") <= date_format(date_create($row[5]), "Y/m/d H:i:s")) {
          $status   = '<td class="text-center" title="Your information has been save."><h3><span class="badge badge-info">Posted</span></h3></td>';
        }

        //expired
        else {
          $status   = '<td class="text-center" title="Press submit to confirm your registration."><h3><span class=" badge badge-danger">Expired</span></h3></td>';
        }

        $haveAccess = 1;
      }
    } else {
      $haveAccess = 0; //not Found
    }
  } else {
    $haveAccess = 0; //not Found
  }
} else {
  header("location: viewAnnouncement.php");
}



// $sql = "sELECT a.* FROM tbl_student AS a WHERE a.studentID = '".$studentID."'";
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Edit Announcement | Parent Portal</title>
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
    .small-box {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- nav bar & side bar -->
    <?php
    require 'includes/navAndSide.php';
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">
        <?php
        if (!$haveAccess) {
          require 'includes/4043.php';
        } else {
        ?>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1> Edit Announcement </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="viewAllAnnouncement.php">View All Announcement</a></li>
                <li class="breadcrumb-item active">View Announcement</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <div class="container-fluid ">
        <!-- Main content -->






          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h3 class="card-title" style="font-size: 30px;">
                      <small></small>
                    </h3>
                    <!-- tools box -->
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                    <!-- /. tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body pad">
                  <form method="post" enctype="multipart/form-data">
            <div class="row" >
              <div class="col-12" style="background-color: #F5FFFA; ">
                <div class="form-group" >

                  <div  style="font-size: 24px; font-weight: bold;">
                    Select Audience
                    <small></small>
                  </div>
                  <select class="duallistbox" name="audi[]" multiple="multiple">
                  <?php
if (isset($_POST['audi'])) {
  $selectedSections = $_POST['audi'];
}
else if (!isset($_POST['audi']) && isset($_POST['gothis'])) {
  unset($selectedSections);
  $selectedSections[] = 'x';
}


                  $sql = "select * from tbl_sections order by sectionYearLevel";
                  $result1 = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_array($result1)) {

                      if (in_array($row[0], $selectedSections)) {
                        $selected = "selected";
                      }
                      else{
                        $selected='';
                      }
                      echo '<option '.$selected.' value = "'.$row[0].'">'.$row[3].' - '.$row[2]. '</option>';
                    }
                  }
                  ?>
                  </select>
                </div>
              </div>
            </div>
            <hr>
                              <div  style="font-size: 24px; font-weight: bold;">
                    Main Content
                    <small></small>
                  </div>

                      <div class="row">
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="unrequired-field">Primary Title</label>
                            <input value="<?php if(isset($_POST['title'])){echo $_POST['title'];} else {echo $title;}  ?>" name="title" id="title" type="text" maxlength="50" class="form-control" placeholder="">
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="unrequired-field">Secondary Title</label>
                            <input value="<?php echo $subtitle ?>" name="subtitle" id="subtitle" type="text" maxlength="50" class="form-control" placeholder="">
                          </div>
                        </div>
                        <!-- ADD IMAGE LABEL -->
                        <!-- <div class="col-md-12">
                      <div class="addimages">
                            <label for="">Add Image</label>
                    </div>
                    </div>
                    <style media="screen">
                    div.addimages {
                      position: relative;
                      left: 707px;
                      top: -86px;
                      }
                      </style> -->
                        <!-- ADD IMAGE LABEL -->
                        </style>


                        <!--                           <div class="col-lg-4">
                            <div class="form-group">
                              <label class="unrequired-field">Status</label>
                              <?php echo $status ?>
                            </div>
                          </div> -->
                      </div>

                      <div class="row">
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label>Date range button:</label>

                            <div class="input-group">
                              <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                <i class="far fa-calendar-alt"></i> Date range picker
                                <i class="fas fa-caret-down"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="unrequired-field">Start Date</label>
                            <input type="text" value="<?php echo $startDate ?>" name="startdate" class="form-control" readonly="true" id="startdate">
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="unrequired-field">End Date</label>
                            <input type="text" value="<?php echo $endDate  ?>" name="enddate" class="form-control" readonly="true" id="enddate">
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <textarea value="" name="htmlcode" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php
                                                                                                                                                                                              echo html_entity_decode(htmlspecialchars_decode($html));

                                                                                                                                                                                              ?></textarea>
                      </div>
                      <div class="relative">
                      <a href="viewAllAnnouncement.php" class="btn btn-danger float-right" style="height:40px;width:100px;left:100px;">Cancel</a>
                        <button type="submit" class="btn btn-primary float-right hi" style="height:40px;width:100px;left:100px; margin-right:5px;" name="gothis">Save</button>
                      
                      </div>
                      <!-- replace -->
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="choose">
                            <br>
                            <div class="addimagelabel">
                              <label for="">Insert image</label>
                              <style>
                                div.addimagelabel {
                                  position: absolute;
                                  left: 0px;
                                  top: 0px;
                                  height: 100%;
                                  width: 100%;
                                }
                              </style>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <div class="Radio">
                                    <input type="radio" id="SOA" name="type" value="OnTop" <?php echo ($radio == '1') ? 'checked' : '' ?>>
                                    <label for="OnTop">Top</label>
                                    <input type="radio" id="RC" name="type" value="OnBottom" <?php echo ($radio == '0') ? 'checked' : '' ?>>
                                    <label for="OnBottom">Bottom</label>
                                  </div>
                                </div>
                              </div>
                              <style>
                                div.Radio {
                                  position: absolute;
                                  left: 0px;
                                  top: 30px;
                                  height: 100%;
                                  width: 100%;
                                }
                              </style>

                            </div>
                            <br>

                            <div class="input">
                              <input type="file" name="sample" id="sample" style="border: 1px solid #dddddd; height:30px;width:200px;visibility: <?php if ($hasimage == false) ?>show" name="" value="" style="">
                              <style>
                                div.input {
                                  position: relative;
                                  left: -8px;
                                  top: -15px;
                                  height: 100%;
                                  width: 100%;
                                }
                              </style>
                            </div>
                            <div class="withbuttons">
                              <?php
                              if (strlen($image) > 0) {
                                echo "<div class='updateimage'>";
                                echo "<input type='submit' value='Change' class='btn btn-primary float-left' id='change' name='change' style='height:35px;width:75px;background-color:Orange;border-color:gray;'>";
                                echo "</div>";

                                echo "<div class='remove'>";
                                echo "<input type='submit' class='btn btn-primary' value='Remove'name='remove' style='height:35px;width:80px;background-color:red;border-color:gray;'>";
                                echo "</div>";
                              } else {
                                echo "";
                              }
                              ?>
                              <!-- <style>
                                  div.change {
                                    position: relative;
                                    left: -05px;
                                    top: 10px;
                                    height: 100%;
                                    width: 100%;
                                    }
                                    </style> -->
                              <div class="limit">
                                Max. file size limit is 5MB.
                              </div>
                              <style>
                                .limit {
                                  position: absolute;
                                  left: 123px;
                                  top: 83px;
                                  font-size-adjust: .01;
                                  font-family: Monospace;
                                }
                              </style>
                              <div class="imagepreviewlabel">
                                <br>

                                <label for="">Image Preview:</label>
                              </div>
                              <style>
                                div.imagepreviewlabel {
                                  position: absolute;
                                  left: 0px;
                                  top: 120px;
                                  height: 100%;
                                  width: 100%;
                                }
                              </style>
                            </div>

                            <br><br>


                            <div class="image">
                              <br>
                              <?php if (strlen($image) > 0) {
                                echo "<div class='imagefile'>";
                                echo "<input type='hidden' value=?><img src='uploads/$image';;<?php name='inputfile'>";
                                echo "</div>";
                                $hasimage = true;
                                global $hasimage;
                              } else if (strlen($image) <= 0) {
                                $hasimage = false;
                              } ?>
                            </div>

                            <style>
                              img {
                                max-width: 300%;
                                max-height: 100%;
                              }
                            </style>

                            <style>
                              img {
                                max-width: 100%;
                                max-height: 100%;
                              }
                            </style>
                            <style>
                              div.remove {
                                position: relative;
                                left: 0px;
                                top: -55px;
                                height: 100%;
                                width: 100%;
                              }
                            </style>
                            <br>
                            <br>
                            <br>
                          </div>
                          <div class="withoutbuttons">

                            <?php
                            global $hasimage;
                            if ($hasimage == false) {
                              // echo"<input type='file'  name='inputfile' style='height:40px;width:250px;'>";
                              echo "<div class='test'>";
                              echo "<input type='submit' class='btn btn-primary' value='Insert'name='update' style='height:35px;width:65px;background-color:DarkSlateGrey;border-color:DarkSlateGrey;'>";
                              echo "</div>";
                            }
                            ?>
                            <style>
                              div.test {
                                position: absolute;
                                left: 210px;
                                top: 30px;

                              }
                            </style>
                          </div>


                        </div>

                        <!-- replace -->

                      </div>
                      <div class="IP">
                        <style>
                          div.IP {
                            position: relative;
                            left: 25px;
                          }
                        </style>

                      </div>
                      <!-- <div class="btn btn-primary float-right"> -->



                      <!-- </div> -->
                      <br>
                      <div class="">


                      </div>
                      <!-- showimage -->
                      <!-- echo "<img src='uploads/$image'; width=1000; height=400;>"; -->
                      <style>
                        div.imagefile {
                          position: relative;
                          left: 20px;
                          top: -150px;
                          height: 100%;
                          width: 100%;
                          z-index: 1;
                        }
                      </style>
                      <style>
                        div.updateimage {
                          position: relative;
                          visibility: visible;

                          left: 210px;
                          top: -47px;
                          line-height: 110px;
                          list-style-type: none;
                          height: 100%;
                          width: 100%;
                          z-index: 2;
                        }
                      </style>
                      <style>
                        div.remove {
                          position: relative;
                          left: 215px;
                          top: -132px;
                          height: 100%;
                          width: 100%;
                          line-height: 200px;
                          list-style-type: none;
                          z-index: 1;
                        }
                      </style>


                      <!-- echo"<input type='file' name='file' style='height:40px;width:250px;'>"; -->
                      <!-- changeimage -->

                      <?php

                      if (isset($_POST['change'])) {

                        $file = $_FILES['sample'];

                        $fileName1 = $_FILES['sample']['name'];
                        $fileTmpName1 = $_FILES['sample']['tmp_name'];
                        $fileSize1 = $_FILES['sample']['size'];
                        $fileError1 = $_FILES['sample']['error'];
                        $fileType1 = $_FILES['sample']['type'];

                        $fileExt1 = explode('.', $fileName1);
                        $fileActualExt1 = strtolower(end($fileExt1));

                        $allowed1 = array('jpg', 'jpeg', 'png', 'pdf');

                        if (in_array($fileActualExt1, $allowed1)) {
                          if ($fileError1 == 0) {
                            if ($fileSize1 < 5000000) {
                              $fileNameNew1 = uniqid('', true) . "." . $fileActualExt1;
                              $fileDestination1 = 'uploads/' . $fileNameNew1;
                              move_uploaded_file($fileTmpName1, $fileDestination1);

                              $qr1 = "UPDATE tbl_announcement SET image = '" . $fileNameNew1 . "'  where announceID = '" . $announceID . "'";
                              mysqli_query($conn, $qr1);
                              unlink('uploads/' . $image);
                              header("Refresh:1");
                            } else {
                              displayMessage("Warning", "Warning", "Your file is too big, limit of 5mb only!");
                            }
                          } else {
                            displayMessage("Warning", "Warning", "There was an error uploading your file!");
                          }
                        } else {
                          displayMessage("Warning", "Warning", "You cannot upload files of this type!");
                        }
                      }


                      ?>
                      <!-- addimage -->
                      <?php

                      if (isset($_POST['update'])) {

                        $file = $_FILES['sample'];

                        $fileName = $_FILES['sample']['name'];
                        $fileTmpName = $_FILES['sample']['tmp_name'];
                        $fileSize = $_FILES['sample']['size'];
                        $fileError = $_FILES['sample']['error'];
                        $fileType = $_FILES['sample']['type'];

                        $fileExt = explode('.', $fileName);
                        $fileActualExt = strtolower(end($fileExt));

                        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

                        if (in_array($fileActualExt, $allowed)) {
                          if ($fileError == 0) {
                            if ($fileSize < 500000) {
                              $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                              $fileDestination = 'uploads/' . $fileNameNew;
                              move_uploaded_file($fileTmpName, $fileDestination);
                              header("Refresh:1");

                              $qr = "UPDATE tbl_announcement SET image = '" . $fileNameNew . "'  where announceID = '" . $announceID . "'";
                              mysqli_query($conn, $qr);
                            } else {
                              displayMessage("Warning", "Warning", "Your file is too big, limit of 5 mb only!");
                            }
                          } else {
                            displayMessage("Warning", "Warning", "There was an error uploading your file!");
                          }
                        } else {
                          displayMessage("Warning", "Warning", "You cannot upload files of this type!");
                        }
                      }


                      ?>
                      <!-- delete -->
                      <?php
                      if (isset($_POST['remove'])) {

                        $qr = "UPDATE tbl_announcement SET image = Null, isOnTop = Null where announceID = '" . $announceID . "'";
                        mysqli_query($conn, $qr);
                        unlink('uploads/' . $image);
                        displayMessage("Warning", "Success", "Image has been removed");
                        header("Refresh:1");
                      }
                      ?>
                    </form>

                  </div>
                </div>
              </div>
              <!-- /.col-->
            </div>
            <!-- ./row -->
          </section>
          <!-- /.content -->

      </div>

    </div>
    <!-- /.content-wrapper -->
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>

  <?php
        }
        require 'assets/scripts.php';

        if (isset($_POST['gothis'])) {
          $audi = $_POST['audi'];
          echo "<script>$('#summernote').summernote('codeview.toggle');</script>";
          $_POST['title'] = mysqli_real_escape_string($conn, stripcslashes($_POST['title']));
          $_POST['startdate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['startdate']));
          $_POST['enddate'] = mysqli_real_escape_string($conn, stripcslashes($_POST['enddate']));
      $newDateStart = date('Y-m-d H:i:s', strtotime($_POST['startdate']));
      $newDateEnd = date('Y-m-d H:i:s', strtotime($_POST['enddate']));

          $_POST['subtitle'] = mysqli_real_escape_string($conn, stripcslashes($_POST['subtitle']));
          $_POST['htmlcode'] = mysqli_real_escape_string($conn, stripcslashes($_POST['htmlcode']));
          $htmlcode = htmlentities(htmlspecialchars($_POST['htmlcode']));
          //echo html_entity_decode(htmlspecialchars_decode($htmlcode));
      if (empty($_POST['audi'])) {
        displayMessage("warning", "Audience Missing", "Please select Audience");
      }
      else if (strlen(trim($_POST['startdate'])) < 3) {
            displayMessage("warning", "Range Date Invalid", "Please try again");
          } else {
            $answer = $_POST['type'];
            if ($answer == "OnTop") {
              $radio = "1";
            }
            if ($answer == "OnBottom") {
              $radio = "0";
            }
            $insertQuery = "Update tbl_announcement
 Set
 title ='" . $_POST['title'] . "',
 subtitle ='" . $_POST['subtitle'] . "',
 htmlcode ='" . $htmlcode . "',
 dateCreated =now(),
 dateEnd ='" . $newDateEnd . "',
 dateStart ='" . $newDateStart . "',
 userID ='" . $_SESSION['userID']  . "',
 isOnTop ='" . $radio  . "'
 where announceID = '" . $announceID . "'

";
            mysqli_query($conn, $insertQuery);

$deleteQuery ="dELETE FROM tbl_audience WHERE announceID='".$announceID."'";
mysqli_query($conn, $deleteQuery);

          foreach ($audi as $key => $sectionID) {
        $insertauditQuery2 = "insert into tbl_audience (announceID,sectionID) values ('".$announceID."','".$sectionID."')";
        mysqli_query($conn, $insertauditQuery2);
          }

            //Insert Audit Trail
            $date = date('Y-m-d H:i:s');
            $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname . "', '" . $userLname . "', 'Edits the announcement entitled ' '" . $_POST['title'] . "', '$date','" . $schoolYearID . "')";
            mysqli_query($conn, $insertauditQuery);
            header('Location: editAnnouncement.php?editsuccess&page=' . $announceID);
          }
        }
        if (isset($_REQUEST['editsuccess'])) {
          displayMessage("success", "Success", "Announcement has been change");
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
  <script>
    $('.duallistbox').bootstrapDualListbox({
  nonSelectedListLabel: 'Not Selected',
  selectedListLabel: 'Selected',
  infoText:"<div style='font-size: 15px;'>&nbsp &nbsp Showing all {0}</div>",
  infoTextFiltered:'<div style="font-size: 15px;"><span class="badge badge-warning" >Filtered</span> {0} from {1}</div>',
  infoTextEmpty: '<div style="font-size: 15px;">Empty list</div>',  
  filterTextClear:"<div style='font-size: 15px;'>Show all</div>",filterPlaceHolder:"Filter",
});




    $(function() {
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
        disableDragAndDrop: true,
        callbacks: {
          onImageUpload: function(data) {
            data.pop();
          }
        }

      });
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment().startOf('day'), moment().endOf('day')],
          'Tomorrow': [moment().add(1, 'days').startOf('day'), moment().add(1, 'days').endOf('day')],
          'Next 7 Days': [moment().add(7, 'days').startOf('day'), moment().add(7, 'days').endOf('day')],
          'Next 30 Days': [moment().add(30, 'days').startOf('day'), moment().add(30, 'days').endOf('day')],
          'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf('day')], 
          },
            locale: {
    format: 'MMMM D, YYYY H:mm:ss'
  },
    "timePicker": true,
    "timePicker24Hour": true,
        "startDate":  $('#startdate').val(),
    "endDate": $('#enddate').val(),
      },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY H:mm:ss') + ' - ' + end.format('MMMM D, YYYY H:mm:ss'))
          $('#startdate').val(start.format('MMMM D, YYYY H:mm:ss'))
          $('#enddate').val(end.format('MMMM D, YYYY H:mm:ss'))
        }
      )

    $("#title").on('input', function() {
      if ($(this).val().length >= 50) {
        const toast = swal.mixin({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 3000
        });
        toast.fire({
          type: 'warning',
          title: 'The maximum number of characters has been reached!'
        });
      }
    });

    $("#subtitle").on('input', function() {
      if ($(this).val().length >= 50) {
        const toast = swal.mixin({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 3000
        });
        toast.fire({
          type: 'warning',
          title: 'The maximum number of characters has been reached!'
        });
      }
    });
  </script>
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

</html>