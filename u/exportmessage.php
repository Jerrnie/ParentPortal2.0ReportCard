<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "exportmessage";
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
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
    header("location: ../login.php");
} else if ($levelCheck == 'P') {
    header("location: home.php");
} else if ($levelCheck == 'E') {
    header("location: PersonnelHome.php");
}

?>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Message Report | Parent Portal</title>
    <link rel="shortcut icon" href="../assets/imgs/favicon.ico">
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <!-- nav bar & side bar -->
        <?php
        require 'includes/navAndSide.php';
        ?>
        <!-- nav bar & side bar -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Message Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Message Report</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <form action="../include/exportmsgstatus.php" method="POST" enctype="multipart/form-data" class="noEnterOnSubmit">
                    <div class="row">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                            border: 2px solid gray;text-align: center">
                                <div class="row mb-3">
                                    <!-- criteria-->
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Date From:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input placeholder="MM/DD/YYYY" name="subfrom" id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Date To:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input placeholder="MM/DD/YYYY" name="subto" id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                </div><!-- criteria-->
                                <div class="row mb-2">
                                    <!-- criteria-->
                                    <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNameSeen()" value="seen" type="radio" id="radioPrimary1" name="r1" checked>
                                            <label for="radioPrimary1">Seen
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNameUnseen()" value="unseen" type="radio" id="radioPrimary3" name="r1">
                                            <label for="radioPrimary3">Unseen
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row mb-2"> -->
                                <!-- criteria-->
                                <!-- <div class="col-lg-12">
                                        <label class="unrequired-field">Type :&nbsp&nbsp</label>
                                        <select name="gradelevel" id="gradelevel" onchange="ChangeFileNametoReg()">
                                            <option value="Student">Student</option>
                                            <option value="Personnel">Personnel</option>
  
                                        </select>
                                    </div> -->
                                <!-- </div> -->
                                <!-- criteria-->
                                <div></div>
                                <div class="row mb-8">
                                    <!--Export button-->
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <label class="unrequired-field">File Name :&nbsp&nbsp</label>
                                            <input title="We will fill this up for you" value="<?php echo "Messagereport_" . date('Ymd')  ?>" id="filenameinfo" name="filenameinfo" value="RegisteredStudentsInfo" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                    </div>
                                    <div class="col-lg-5" style="display: flex;justify-content: center;
                                        align-items: center;">
                                        <!-- <button onclick="Export()" id="export"
                                        type="button" class="btn btn-primary add-button">
                                        <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export Records
                                        </button> -->
                                        <button type="submit" name="btn-submit" class="btn btn-primary add-button">
                                            <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export to Excel
                                        </button>
                                    </div>

                                </div> <!-- Export button -->


                            </div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                    </div>
                </form>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- 
    </div> -->
    <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    </div>

    <script src="includes/sessionChecker.js"></script>
    <script type="text/javascript">
        extendSession();
        var isPosted;
        var isDisplayed = false;
        setInterval(function() {
            sessionChecker();
        }, 20000); //time in milliseconds 
    </script>
    <!-- ./wrapper -->

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


    function ChangeFileNameSeen() {
        // var gradeLevel = document.getElementById('gradelevel').value;
        var today = new Date();
        var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
            String(today.getDate()).padStart(2, '0') +
            today.getFullYear();
        $("#filenameinfo").prop("value", "MessageReportSeen_" + FinalDateStr);
    }

    function ChangeFileNameUnseen() {
        // var gradeLevel = document.getElementById('gradelevel').value;
        var today = new Date();
        var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
            String(today.getDate()).padStart(2, '0') +
            today.getFullYear();
        $("#filenameinfo").prop("value", "MessageReportUnseen_" + FinalDateStr);
    }
</script>

</html>