<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
require '../include/config.php';
$page = "viewallAnnouncement";
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require 'sendmessage.php';
require 'sendText.php';
session_start();
$userID = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userMname = $_SESSION['middle-name'];
$userLname = $_SESSION['last-name'];
$userLvl = $_SESSION['usertype'];
$userEmail = $_SESSION['userEmail'];


$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
if (!isset($user_check) && !isset($password_check)) {
  session_destroy();
  header("location: ../index.php");
} else if ($levelCheck == 'P') {
  header("location: home.php");
} else if ($levelCheck == 'E') {
  header("location: PersonnelHome.php");
}
$parentName;
if (isset($_GET['page'])) {
  $userID2 = $_GET['page'];
  $sql = "sELECT a.* ,b.fullName,b.mobile FROM tbl_student AS a inner join tbl_parentuser AS b ON b.userID = a.userID WHERE a.userID = '" . $userID2 . "'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    if (mysqli_num_rows($result) > 0) {

      if ($pass_row = mysqli_fetch_array($result)) {
        $haveAccess = '1';
        $studentCode       = $pass_row['3'];
        $LRN               = $pass_row['4'];
        $Prefix            = $pass_row['5'];
        $Lastname          = $pass_row['6'];
        $Firstname         = $pass_row['7'];
        $Middlename        = $pass_row['8'];
        $Suffix            = $pass_row['9'];
        $parentName = $pass_row[16];
        $mobile = $pass_row[17];


        $studentSchoolYearID = $pass_row[2];
      }
    } else {
      $haveAccess = '2';
    }
  } else {
    $haveAccess = '2';
  }
} else {
  $haveAccess = '2';
}


if ($haveAccess == '2') {
  header('Location: viewAllUser.php?notfound');
}
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>All Payment Reminders | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

  <!-- customize css -->
  <link rel="stylesheet" type="text/css" href="assets/css/hideAndNext.css">
  <link rel="stylesheet" type="text/css" href="assets/css/css-navAndSlide.css">
  <!-- sweet alert -->
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
    ?>
    <!-- nav bar & side bar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Reminders for <?php echo $parentName ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="viewAllUser.php">User Maintenance</a></li>
                <li class="breadcrumb-item active">Payment Reminder</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <p>
              <a href="?page=<?php echo $userID2 ?>" type="button" class="btn btn-success add-button buttonDelete ">
                <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
              </a>&nbsp&nbsp
              <a data-toggle="modal" data-target="#modal-lg" type="button" class="btn btn-primary add-button" style="color: white;">
                <span class=" fa fa-plus-square">&nbsp&nbsp</span>Add New Reminder
              </a>
            </p>
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="width: 100%;">
            <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Amount</th>
                  <th>Reminder Date</th>
                  <th>Status</th>
                  <th>Action</th>

                </tr>
              </thead>
              <tbody>
                <?php

                $sql = "sELECT  a.*,  b.lastName, b.firstName, b.middleName FROM tbl_pr as a inner join tbl_student as b on a.studentID = b.studentID WHERE a.userID ='" . $userID2 . "' and a.isDeleted = '0' AND a.schoolYearID = '" . $schoolYearID . "' ORDER BY isSent,remindDate";
                $result1 = mysqli_query($conn, $sql);
                $ctr = 0;
                if (mysqli_num_rows($result1) > 0) {
                  while ($row = mysqli_fetch_array($result1)) {

                    $studentID   = $row[2];
                    $amount        = $row[3];
                    $accountNumber     = $row[4];
                    $remindDate = $row[5];
                    $isSent = $row[6];
                    $rd    = date_format(date_create($row[5]), "M d, Y");
                    $sortformat = strtotime($row[5]);



                    echo "<tr class='tRow' id='row" . $ctr . "'>";



                    echo "<td><h5>";
                    echo ucwords(combineName($row[11], $row[10], $row[12]));
                    echo "</h5></td>";
                    echo "<td align='right'><h5><b>";
                    echo "₱ " . number_format($row[3], 2);
                    echo "</b></h5></td>";
                    echo "<td data-sort='" . $sortformat . "'><h6>";
                    echo $rd;
                    echo "</h6></td>";
                    if ($isSent) {
                      echo '<td class="text-center" title="The user receive the message"><h3><span class="badge badge-success">Sent</span></h3></td>';
                    } else {
                      echo '<td class="text-center" title="To be send"><h3><span class="badge badge-warning">To be sent</span></h3></td>';
                    }
                    echo '   <td class="text-center">';
                    if (!$isSent) {
                      echo '       <a class="btn btn-primary btn-sm " title="View / Edit" id="veButton' . $ctr . '"  href="editPaymentReminder.php?chap=' . $row[0] . '">';
                      echo '           <i class="fas fa-pencil-alt" id="edit-icon' . $ctr . '">';
                      echo '           </i>';
                      echo '           <span id="view' . $ctr . '">/</span>';
                      echo '           <i class="fas fa-eye">';
                      echo '           </i>';
                      echo '       </a>';
                    }


                    echo '       <a href="#" class="btn delete btn-sm btn-danger" title="Delete" id="delete' . $ctr . '" rowIdentifier="row' . $ctr . '" rowIdentifier2="' . $isSent . '"  value="' . $row[0] . '" >';
                    echo '           <i class="fas fa-trash">';
                    echo '           </i>';
                    echo '       </a>';
                    echo "</td>";


                    echo "</tr>";
                    $ctr++;
                  }
                } else {
                  echo "<script> swal('error'); </script>";
                }


                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Payment Reminder Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST" onsubmit="return confirmation()">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-8">
                  <div class="form-group">


                    <label class="required-field" id="incomlbl">
                      Student

                    </label>
                    <select name="studentcode" id="studentcode" class="form-control select2bs4 studentcode" required="true" onchange="myfunction()">
                      <?php
                      $sql = "select studentCode, lastName,firstName,middleName,studentID FROM tbl_student where userID='" . $userID2 . "' AND schoolYearID = '".$schoolYearID."'";
                      $result1 = mysqli_query($conn, $sql);
                      $ctr = 0;
                      if (mysqli_num_rows($result1) > 0) {
                        while ($row = mysqli_fetch_array($result1)) {
                          $isSelected = '';
                          if (isset($_POST['studentcode']) && $_POST['studentcode'] == $row[4]) {
                            $isSelected = 'selected';
                          }
                          echo '<option ' . $isSelected . ' value="' . $row[4] . '"><b>Student Code:</b> ' . $row[0] . " - <b>Name:</b> " . ucwords(combineName($row[2], $row[1], $row[3])) . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-lg-4">
                  <?php
                  $sql = "select a.studentCode, a.lastName,a.firstName,a.middleName,a.studentID,b.sectionName,b.sectionYearLevel FROM tbl_student as a inner join tbl_sections as b on b.sectionID = a.sectionID where userID='" . $userID2 . "' AND schoolYearID = '".$schoolYearID."'";
                  $result1 = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_array($result1)) {
                      echo '<input type="hidden" id="section' . $row[4] . '" value="' . $row[5] . '">';
                      echo '<input type="hidden" id="level' . $row[4] . '" value="' . $row[6] . '">';
                    }
                  }
                  ?>

                  <div class="form-group">
                    <script type="text/javascript">
                      function myfunction() {
                        var id = $("#studentcode").val();
                        $("#b").val($("#section" + id).val());
                        $("#a").val($("#level" + id).val());




                      }
                    </script>

                    <label class="unrequired-field" id="incomlbl">
                      Account Number

                    </label>
                    <input <?php if (isset($_POST['accountNumber'])) {
                              echo "value='" . $_POST["accountNumber"] . "'";
                            } ?> type="text" class="form-control" name="accountNumber">


                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="unrequired-field">Year Level</label>
                        <input value="<?php echo $sectionYearLevel ?>" type="text" name="enddate" class="form-control" readonly="true" id="a">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="unrequired-field">Section</label>
                        <input value="<?php echo $section ?>" type="text" name="enddate" class="form-control" readonly="true" id="b">
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-sm-6">
                  <label class="required-field" id="incomlbl">
                    Amount

                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <b>₱</b>
                      </span>
                    </div>
                    <input placeholder="E.g: 10590.00" value='<?php if (isset($_POST['amount'])) {
                                                                echo $_POST["amount"];
                                                              } ?>' type="text" class="form-control decimal" required="true" name="amount">

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="required-field">Date range button:</label>

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
                    <label class="unrequired-field">Notification Date</label>
                    <input required="true" value="<?php if (isset($_POST['startdate'])) {
                                                    echo $_POST['startdate'];
                                                  } ?>" type="text" name="startdate" class="form-control" readonly="true" id="startdate">
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="unrequired-field">Due Date</label>
                    <input required="true" value="<?php if (isset($_POST['enddate'])) {
                                                    echo $_POST['enddate'];
                                                  } ?>" type="text" name="enddate" class="form-control" readonly="true" id="enddate">
                  </div>
                </div>

              </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="Submit" class="btn btn-primary" name="addReminder">Add Reminder</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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


    <?php require '../maintenanceChecker.php';
    ?>
</body>
<script type="text/javascript">
  function confirmation() {
    var r = confirm("Do you wish to Continue?!\nPutting past date to notify will send the reminder immediately.");
    if (r == true) {
      return true;
    } else {
      return false;
    }
  }




  $('#daterange-btn').daterangepicker({
      ranges: {
        'Today': [moment(), moment()],
        'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
        'Next 7 Days': [moment().add(7, 'days'), moment().add(7, 'days')],
        'Next 30 Days': [moment().add(30, 'days'), moment().add(30, 'days')],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
      },
      startDate: moment().subtract(29, 'days'),
      endDate: moment()
    },
    function(start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      $('#startdate').val(start.format('MMMM D, YYYY'))
      $('#enddate').val(end.format('MMMM D, YYYY'))
    }
  )

  // Install input filters.
  $(".interger").inputFilter(function(value) {
    return /^-?\d*$/.test(value);
  });
  $(".numberOnly").inputFilter(function(value) {
    return /^\d*$/.test(value);
  });
  $(".numberOnly2").inputFilter(function(value) {
    return /^\d*$/.test(value);
  });
  $("#intLimitTextBox").inputFilter(function(value) {
    return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500);
  });
  $(".decimal").inputFilter(function(value) {
    return /^-?\d*[.]?\d*$/.test(value);
  });
  $("#currencyTextBox").inputFilter(function(value) {
    return /^-?\d*[.,]?\d{0,2}$/.test(value);
  });
  $(".textOnly").inputFilter(function(value) {
    return /^[a-z-' ']*$/i.test(value);
  });
  $(".textOnly2").inputFilter(function(value) {
    return /^[a-z-' '-\.]*$/i.test(value);
  });
  $("#hexTextBox").inputFilter(function(value) {
    return /^[0-9a-f]*$/i.test(value);
  });
  // validations
  (function($) {
    $.fn.inputFilter = function(inputFilter) {
      return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    };
  }(jQuery));




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
</script>
<script type="text/javascript" src="assets/scripts/hideAndNext.js"></script>
<!-- FastClick -->
<script src="../include/plugins/fastclick/fastclick.js"></script>
<script>
  $("#siblings-order").keyup(function() {

    var orderBirth = $("#siblings-order").val();
    if (orderBirth == 1) {
      $('#checkboxPrimary1').prop('checked', true);

    } else {
      $('#checkboxPrimary1').prop('checked', false);

    }

  });

  $(document).ready(function() {
    $('#example1').DataTable({
      "scrollX": true,
    });
  });

  $(document).ready(function() {
    $('.yearselect').select2();
  });
  $(document).on("click", ".delete", function() {
    var x = $(this).attr('value');
    var row2 = $(this).attr('rowIdentifier2');
    var row = $(this).attr('rowIdentifier');
    var msg;
    var title;


    if (row2 == '1') {
      ttl = "Already Sent";
      msg = "Deleting this will not remove the message";
    } else {
      ttl = "Are you sure?";
      msg = "Deleted record(s) cannot be restored.";
    }

    Swal.fire({
      title: ttl,
      text: msg,
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
          url: "removePaymentReminder.php",
          type: "POST",
          cache: false,
          "data": {
            "studentidx": x
          },
          dataType: "html",
          success: function() {
            swal.fire("Done!", "It was succesfully deleted!", "success");
            $("#" + row).css({
              "background-color": "#FACFCB"
            }, "slow").delay(200).animate({
              opacity: "hide"
            }, "slow");
          },
          error: function(xhr, ajaxOptions, thrownError) {
            swal.fire("Error deleting!", "Please try again", "error");
          }
        });
      }
    })
    e.preventDefault();
  });


  (function($) {
    $.fn.inputFilter = function(inputFilter) {
      return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    };
  }(jQuery));

  // Install input filters.
  $(".interger").inputFilter(function(value) {
    return /^-?\d*$/.test(value);
  });
  $(".numberOnly").inputFilter(function(value) {
    return /^\d*$/.test(value);
  });
  $(".numberOnly2").inputFilter(function(value) {
    return /^\d*$/.test(value);
  });
  $("#intLimitTextBox").inputFilter(function(value) {
    return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500);
  });
  $(".decimal").inputFilter(function(value) {
    return /^-?\d*[.]?\d*$/.test(value);
  });
  $("#currencyTextBox").inputFilter(function(value) {
    return /^-?\d*[.,]?\d{0,2}$/.test(value);
  });
  $(".textOnly").inputFilter(function(value) {
    return /^[a-z-' ']*$/i.test(value);
  });
  $(".textOnly2").inputFilter(function(value) {
    return /^[a-z-' '-\.]*$/i.test(value);
  });
  $("#hexTextBox").inputFilter(function(value) {
    return /^[0-9a-f]*$/i.test(value);
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
  myfunction();
</script>

</html>

<?php

if (isset($_POST['addReminder'])) {
  $isSent2 = false;
  $x = date('Y', strtotime($_POST['startdate']));
  $y = date('Y', strtotime($_POST['enddate']));

  if ("1970" == $x) {
    header('Location: allPaymentReminder.php?date&page=' . $userID2);
    exit(1);
  }
  if ("1970" == $y) {
    header('Location: allPaymentReminder.php?date&page=' . $userID2);
    exit(1);
  }


  $remindDate = date('Y-m-d', strtotime($_POST['startdate']));
  $deadline = date('Y-m-d', strtotime($_POST['enddate']));

  $studentID = $_POST['studentcode'];
  $amount = $_POST['amount'];
  $haveAccountNumber = true;

  $immedientSend = false;
  $accountNumber = $_POST['accountNumber'];


  $checkRecord = mysqli_query($conn, "SELECT lastName,firstName,middleName FROM tbl_student where studentID ='" . $studentID . "' AND schoolYearID = '" . $schoolYearID . "'");
  $result = mysqli_fetch_assoc($checkRecord);
  // $studentName = combineName( $result['lastName'], $result['firstName'], $result['middleName']);
  $studentName         = $result['firstName'] . " " . $result['middleName'][0] . ". " .  $result['lastName'];



  if (new DateTime() > new DateTime($remindDate)) {
    $immedientSend = true;
  }

  if (($pos = strpos($amount, ".")) !== FALSE) {
    $arr = explode(".", $amount, 2);
    $first = $arr[0];
    $whatIWant = substr($amount, $pos + 1);

    if (strlen(trim($whatIWant)) != 2) {
      header('Location: allPaymentReminder.php?invalidDecimal&page=' . $userID2);
      exit(1);
    }


    if ($first < 0) {
      header('Location: allPaymentReminder.php?amountInvalid&page=' . $userID2);
      exit(1);
    }
  } else {
    $amount .= ".00";
    $arr = explode(".", $amount, 2);
    $first = $arr[0];
    $pos = strpos($amount, ".");
    $whatIWant = substr($amount, $pos + 1);

    if (strlen(trim($whatIWant)) != 2) {
      header('Location: allPaymentReminder.php?invalidDecimal&page=' . $userID2);
      exit(1);
    }


    if ($first < 0) {
      header('Location: allPaymentReminder.php?amountInvalid&page=' . $userID2);
      exit(1);
    }
  }

  if (strlen(trim($accountNumber)) == '') {
    $haveAccountNumber = false;
  }



  $parentID = $userID2;
  $pname = $parentName;
  $sname = $studentName;
  $an = $accountNumber;
  $deadline2 = date("F d, Y", strtotime($deadline));
  require 'paymentReminderMessage.inc.php';

  if ($haveAccountNumber) {
    if ($immedientSend) {

      sendMessage($parentID, "1", $messageWithACN);

      $checkRecord1 = mysqli_query($conn, "SELECT fullName FROM tbl_parentuser WHERE userID  = '" .  $parentID  . "' AND schoolYearID = '" . $schoolYearID . "' ");
      $result1 = mysqli_fetch_array($checkRecord1);
      $nameReceiver = $result1['fullName'];

      $date = date('Y-m-d H:i:s');
      $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate,schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', 'Sends a payment reminder to ' '" . $nameReceiver . "', '$date','" . $schoolYearID . "')";
      mysqli_query($conn, $insertauditQuery);

      sendOTP($messageWithACN, $mobile);
      $isSent2 = true;
      $insertQuery2 = "Insert into tbl_pr
    (
    userID,
    studentID,
    amount,
    accountNumber,
    remindDate,
    isSent,
    deadline,
    schoolYearID
    )
    VALUES
    (
    '" . $userID2 . "',
    '" . $studentID . "',
    '" . $amount . "',
    '" . $accountNumber . "',
    '" . $remindDate . "',
    '1',
    '" . $deadline . "',
    '" . $schoolYearID . "'
    )";
    } else {
      $insertQuery2 = "Insert into tbl_pr
      (
      userID,
      studentID,
      amount,
      accountNumber,
      remindDate,
      isSent,
    deadline,
    schoolYearID
      )
      VALUES
      (
      '" . $userID2 . "',
      '" . $studentID . "',
      '" . $amount . "',
      '" . $accountNumber . "',
      '" . $remindDate . "',
      '0',
      '" . $deadline . "',
      '" . $schoolYearID . "'
      )";
    }
  } else {
    if ($immedientSend) {
      sendMessage($parentID, "1", $message);

      $checkRecord1 = mysqli_query($conn, "SELECT fullName FROM tbl_parentuser WHERE userID  = '" .  $parentID  . "' AND schoolYearID = '" . $schoolYearID . "' ");
      $result1 = mysqli_fetch_array($checkRecord1);
      $nameReceiver = $result1['fullName'];

      $date = date('Y-m-d H:i:s');

      $insertauditQuery = "Insert into tbl_audittrail (userID, fname, lname, activity, activitydate, schoolYearID) Values  ('" .  $user_check . "', '" .  $userFname  . "', '" .  $userLname  . "', ''Sends a payment reminder to ' '" . $nameReceiver . "', '$date','" . $schoolYearID . "')";

      mysqli_query($conn, $insertauditQuery);

      sendOTP($message, $mobile);
      $isSent2 = true;

      $insertQuery2 = "Insert into tbl_pr
    (
    userID,
    studentID,
    amount,
    accountNumber,
    remindDate,
    isSent,
    deadline,
    schoolYearID
    )
    VALUES
    (
    '" . $userID2 . "',
    '" . $studentID . "',
    '" . $amount . "',
    null,
    '" . $remindDate . "',
    '1',
    '" . $deadline . "',
    '" . $schoolYearID . "'
    )";
    } else {
      $insertQuery2 = "Insert into tbl_pr
      (
      userID,
      studentID,
      amount,
      accountNumber,
      remindDate,
      isSent,
    deadline,
    schoolYearID
      )
      VALUES
      (
      '" . $userID2 . "',
      '" . $studentID . "',
      '" . $amount . "',
      null,
      '" . $remindDate . "',
      '0',
    '" . $deadline . "',
    '" . $schoolYearID . "'
      )";
    }
  }




  mysqli_query($conn, $insertQuery2);
  // echo $insertQuery2;



  if ($isSent2) {
    header('Location: allPaymentReminder.php?uploadSuccess2&page=' . $userID2);
    exit(1);
  } else {
    header('Location: allPaymentReminder.php?uploadSuccess&page=' . $userID2);
    exit(1);
  }
}


if (isset($_REQUEST['invalidDecimal'])) {
  displayMessage("warning", "Warning", "Invalid decimal place");
}

if (isset($_REQUEST['amountInvalid'])) {
  displayMessage("warning", "Warning", "Amount is too low");
}

if (isset($_REQUEST['decimal'])) {
  displayMessage("warning", "Warning", "Decimal not found");
}

if (isset($_REQUEST['uploadSuccess'])) {
  displayMessage("success", "Success", "Reminder Added");
}

if (isset($_REQUEST['date'])) {
  displayMessage("warning", "Warning", "Invalid Date");
}

if (isset($_REQUEST['updateSuccess2'])) {
  displayMessage("success", "Success", "Update success and Payment reminder has been sent");
}
if (isset($_REQUEST['updateSuccess'])) {
  displayMessage("success", "Success", "Update success");
}
if (isset($_REQUEST['uploadSuccess2'])) {
  displayMessage("success", "Success", "Payment reminder has been sent");
}

?>