<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/generalSandC.php';
require 'assets/adminlte.php';
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
$page = 'audittrail';
?>

<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Audit Trail</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">
  <link rel="stylesheet" type="text/css" href="assets/css/css-home.css">
  <!-- customize css -->
  <link rel="stylesheet" type="text/css" href="assets/css/hideAndNext.css">
  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href="assets/css/css-navAndSlide.css">
  <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">

  <link rel="stylesheet" href="../include/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" type="text/css" href="assets/css/css-studentinfo.css">


</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper">


    <!-- nav bar & side bar -->
    <?php
    session_start();

    require 'includes/navAndSide.php';
    $user_check = $_SESSION['userID'];
    $levelCheck = $_SESSION['usertype'];
    $userFname = $_SESSION['first-name'];
    $userLname = $_SESSION['last-name'];
    // if (!isset($user_check) && !isset($password_check)) {
    //   session_destroy();
    //   header("location: ../index.php");
    // } else if ($levelCheck == 'P') {
    //   header("location: home.php");
    // } else if ($levelCheck == 'A') {
    //   header("location: index.php");
    // }

    if (!isset($user_check)) {
      session_destroy();
      header("location: ../login.php");
    } else if ($levelCheck == 'P') {
      header("location: home.php");
    } else if ($levelCheck == 'E') {
      header("location: PersonnelHome.php");
    } else if ($levelCheck == 'A') {
      header("location: index.php");
    }

    //   $user_check = $_SESSION['userID'] ;
    //   $levelCheck = $_SESSION['usertype'];
    //   if(!isset($user_check) && !isset($password_check))
    //   {
    //     session_destroy();
    //     header("location: ../index.php");
    //   }
    //   else if ($levelCheck=='S'){
    //     header("location: index.php");
    //   }
    ?>
    <!-- nav bar & side bar -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>View Activity Logs</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">View Activity Logs</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <form action="" method="POST">
          <!-- Default box -->
          <div class="card">
            <div class="card-header">

              <!-- <div class="input-daterange">
                <div class="row mb-1">
                  <div class="col-sm-3">
                    <label class="unrequired-field">Date From:</label>
                    <div class="input-group">

                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input placeholder="MM/DD/YYYY" name="from_date" id="from_date" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                    </div>
                  </div>

                  <div class="col-sm-5">

                    <label class="unrequired-field">Date To:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input placeholder="MM/DD/YYYY" name="to_date" id="to_date" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                      &nbsp&nbsp &nbsp&nbsp
                      <div class="col-xm-6">
                        <button type="button" name="filter" id="filter" value="filter" class="btn btn-info">
                          <span class=" fa fa-search">&nbsp&nbsp</span>Search
                        </button>
                      </div>
                      &nbsp&nbsp
                      <button id="export" type="submit" name="export" class="btn btn-primary add-button">
                        <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export to Excel
                      </button>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- criteria -->
              <!-- </div> -->
              <!-- /.card-header -->

              <div id="Top" class="card-body" style="width: 100%;">
                <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
                  <thead>
                    <tr>
                      <th>UserID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Activity</th>
                      <th>Activity Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT userID, fname, lname, activity, activityDate FROM tbl_audittrail WHERE schoolYearID = '" . $schoolYearID . "' order by activityDate desc";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) { ?>
                      <!--open of while  -->
                      <tr>
                        <td><?php echo $row["userID"]; ?></td>
                        <td><?php echo $row["fname"]; ?></td>
                        <td><?php echo $row["lname"]; ?></td>
                        <td><?php echo $row["activity"]; ?></td>
                        <td><?php echo $row["activityDate"]; ?></td>
                      </tr>
                    <?php }
                    ?>
                  </tbody>
                </table>

                <!-- /.card-body -->
              </div>
            </div>
        </form>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    <!-- ./wrapper -->
    <?php
    require 'assets/scripts.php';


    ?>
    <!-- customize scripts -->
    <script src="../include/plugins/datatables/jquery.dataTables.js"></script>
    <script src="../include/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

    <script src="../include/table2excel/src/jquery.table2excel.js" type="text/javascript"></script>



    <?php require '../maintenanceChecker.php';
    ?>
</body>


<script>
  $(document).ready(function() {
    $('#example1').DataTable({
      "paging": true,
      "ordering": true,
      "autoWidth": true,
      "order" : [],
      "pagingType": "full_numbers",
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "bInfo": false,
      "order": [
        [4, "desc"]
      ]
    });
    $('.dataTables_length').addClass('bs-select');
  });


  $("#export").click(function() {
    var today = new Date();
    var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
      String(today.getDate()).padStart(2, '0') +
      today.getFullYear();

    $("#example1").table2excel({
      // exclude CSS class
      exclude: ".noExl",
      name: "Worksheet Name",
      filename: "Audittrail" + FinalDateStr //do not include extension
    });
    // $.ajax({
    //   // url: "exportaudit.php",
    //   type: "POST",
    //   cache: false,
    // });
  });



  $('#filter').click(function() {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    if (from_date != '' && to_date != '') {
      $.ajax({
        url: "filter.php",
        method: "POST",
        data: {
          from_date: from_date,
          to_date: to_date
        },
        success: function(data) {
          $('#example1').html(data);
        }
      });
    } else {
      alert("Please Select Specific Date");
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

  // $('#from_date').inputmask('mm/dd/yyyy', {
  //   'placeholder': 'mm/dd/yyyy'
  // })
  // $('[data-mask]').inputmask()
  // $("#date").mask("99/99/9999");

  // $('#to_date').inputmask('mm/dd/yyyy', {
  //   'placeholder': 'mm/dd/yyyy'
  // })
  // $('[data-mask]').inputmask()
  // $("#date").mask("99/99/9999");

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

</html>