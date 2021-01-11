<!DOCTYPE html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
require '../include/config.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "auditexport";
require 'assets/scripts/phpfunctions.php';
require 'assets/generalSandC.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';

session_start();
$userID = $_SESSION['userID'];
$userFname = $_SESSION['first-name'];
$userMname = $_SESSION['middle-name'];
$userLname = $_SESSION['last-name'];


$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
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

// select box open tag
$selectBoxOpen = "<select name='sectionYearLevel'>";
// select box close tag
$selectBoxClose = "</select>";
// select box option tag
$selectBoxOption = '';

$sql = "sELECT  Personnel_Id,Personnel_code  FROM tbl_Personnel WHERE schoolYearID = '" . $schoolYearID . "'";
// play with return result array
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $selectBoxOption .= "<option value = '" . $row['Personnel_code'] . "'>" . $row['Personnel_code'] . "</option>";
}
// create select box tag with mysql result
$selectBox = $selectBoxOpen . $selectBoxOption . $selectBoxClose;

$selectBoxOpen1 = "<select name='sectionName'>";
// select box close tag
$selectBoxClose1 = "</select>";
// select box option tag
$selectBoxOption1 = '';

$sql1 = "sELECT  studentID,studentCode  FROM tbl_student WHERE schoolYearID = '" . $schoolYearID . "'";
// play with return result array
$result1 = mysqli_query($conn, $sql1);

while ($row = mysqli_fetch_array($result1)) {
    $selectBoxOption1 .= "<option value = '" . $row['studentCode'] . "'>" . $row['studentCode'] . "</option>";
}
// create select box tag with mysql result
$selectBox1 = $selectBoxOpen1 . $selectBoxOption1 . $selectBoxClose1;

?>

<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Student/Personnel Attendance | Parent Portal</title>
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
                            <h1>Export Activity Logs</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Export Activity Logs</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <form action="../include/exportaudit.php" method="POST" enctype="multipart/form-data" class="noEnterOnSubmit">
                    <div class="row">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                            border: 2px solid gray;text-align: center">
                                <!-- <h3 class="unrequired-field"><b>Audit Trail</b></h3> -->
                                <h4 class="unrequired-field"><b>Admin Transaction log</b></h4>
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
                                <!-- <div class="row mb-2"> -->
                                <!-- criteria-->
                                <!-- <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNameStudent()" value="student" type="radio" id="radioPrimary1" name="r1" checked>
                                            <label for="radioPrimary1">Students
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNamePersonnel()" value="personnel" type="radio" id="radioPrimary3" name="r1">
                                            <label for="radioPrimary3">Personnel
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
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
                                            <input title="We will fill this up for you" value="<?php echo "AudittrailReport_" . date('Ymd')  ?>" id="filenameinfo" name="filenameinfo" value="RegisteredAudittrail" type="text" class="form-control">
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
                                        <button id="export" type="submit" name="export" class="btn btn-primary add-button">
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
                <br><br>
                <form action="../include/exportAttendanceAudit.php" method="POST" enctype="multipart/form-data" class="noEnterOnSubmit">
                    <div class="row">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                            border: 2px solid gray;text-align: center">

                                <h4 class="unrequired-field"><b>Student and Personnel Attendance</b></h4>
                                <div class="row mb-3">
                                    <!-- criteria-->
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Date From:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input placeholder="MM/DD/YYYY" name="subfrom1" id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Date To:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input placeholder="MM/DD/YYYY" name="subto1" id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                </div><!-- criteria-->
                                <!-- <div class="row mb-2"> -->
                                <!-- criteria-->
                                <!-- <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNameStudent()" value="student1" type="radio" id="radioPrimary5" name="r2" checked>
                                            <label for="radioPrimary5">Students
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNamePersonnel()" value="personnel1" type="radio" id="radioPrimary6" name="r2">
                                            <label for="radioPrimary6">Personnel
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="row mb-4"> -->
                                <!-- criteria-->
                                <!-- <div class="col-sm-6">
                                        <label class="unrequired-field">Student Code</label>
                                        <div class="input-group">
                                            <select name="studnum" id="studnum" class="form-control select2bs2 studnum" required="true" onchange="myfunction()">
                                                <?php echo $selectBoxOption1; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Employee Code</label>
                                        <div class="input-group">
                                            <select name="empnum" id="empnum" class="form-control select2bs1 empnum" required="true" onchange="myfunction()" disabled>
                                                <?php echo $selectBoxOption; ?>
                                            </select>


                                        </div>
                                    </div>
                                </div> -->
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
                                            <input title="We will fill this up for you" value="<?php echo "StudentPersonnelAttendanceAudit_" . date('Ymd')  ?>" id="filenameinfo1" name="filenameinfo1" value="TimeinTimeoutStudentsPersonnelInfo" type="text" class="form-control">
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
                <br><br>
                <form action="../include/indiexportAttendanceAudit.php" method="POST" enctype="multipart/form-data" class="noEnterOnSubmit">
                    <div class="row">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                            border: 2px solid gray;text-align: center">

                                <h5 class="unrequired-field"><b>Individual Student and Personnel Attendance</b></h5>
                                <div class="row mb-3">
                                    <!-- criteria-->
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Date From:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input placeholder="MM/DD/YYYY" name="subfrom1" id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Date To:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input placeholder="MM/DD/YYYY" name="subto1" id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                </div><!-- criteria-->
                                <div class="row mb-2">
                                    <!-- criteria-->
                                    <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNameStudent1()" value="student1" type="radio" id="radioPrimary5" name="r2" checked>
                                            <label for="radioPrimary5">Students
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="icheck-primary d-inline">
                                            <input onclick="ChangeFileNamePersonnel1()" value="personnel1" type="radio" id="radioPrimary6" name="r2">
                                            <label for="radioPrimary6">Personnel
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <!-- criteria-->
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Student Code</label>
                                        <div class="input-group">
                                            <select name="studnum" id="studnum" class="form-control select2bs2 studnum" required="true" onchange="myfunction()">
                                                <?php echo $selectBoxOption1; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="unrequired-field">Employee Code</label>
                                        <div class="input-group">
                                            <select name="empnum" id="empnum" class="form-control select2bs1 empnum" required="true" onchange="myfunction()" disabled>
                                                <?php echo $selectBoxOption; ?>
                                            </select>


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
                                            <input title="We will fill this up for you" value="<?php echo "IndividualStudentPersonnelAttendanceAudit_" . date('Ymd')  ?>" id="filenameinfo2" name="filenameinfo2" value="IndividualTimeinTimeoutStudentsPersonnelInfo" type="text" class="form-control">
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
                                        <button type="submit" name="btn-submit1" class="btn btn-primary add-button">
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
                <br>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
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
</body>
<script type="text/javascript">
    // validations
    $("#radioPrimary6").click(function() {
        $("#studnum").attr("disabled", true);

        $("#empnum").attr("disabled", false);
        //$("#discountselection").show(); //To Show the dropdown
    });
    $("#radioPrimary5").click(function() {
        $("#empnum").attr("disabled", true);
        $("#studnum").attr("disabled", false);

        //$("#discountselection").hide();//To hide the dropdown
    });

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    //Initialize Select2 Elements
    $('.select2bs1').select2()

    //Initialize Select2 Elements
    $('.select2bs1').select2({
        theme: 'bootstrap4'
    })
    //Initialize Select2 Elements
    $('.select2bs1').select2()

    //Initialize Select2 Elements
    $('.select2bs2').select2({
        theme: 'bootstrap4'
    })
    //Initialize Select2 Elements
    $('.select2bs2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2()

    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
    })

    $('[data-mask]').inputmask()

    function ChangeFileNameStudent1() {
        // var gradeLevel = document.getElementById('gradelevel').value;
        var today = new Date();
        var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
            String(today.getDate()).padStart(2, '0') +
            today.getFullYear();
        $("#filenameinfo").prop("value", "StudentPersonnelAttendanceAudit_" + FinalDateStr);
    }

    $(document).ready(function() {
        $('.yearselect').select2();
    });
</script>
<script type="text/javascript" src="assets/scripts/hideAndNext.js"></script>
<!-- FastClick -->
<script src="../include/plugins/fastclick/fastclick.js"></script>
<script>

</script>

</html>

<?php


?>