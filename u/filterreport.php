<!DOCTYPE html>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/adminlte.php';
  require '../include/config.php';
  $page = "filterreport";
  require 'assets/scripts/phpfunctions.php';
  require 'assets/generalSandC.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';

?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Admin Change School Year | Parent Portal</title>
  <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

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
    <div class="wrapper"><!--wrapper-->

        <!-- nav bar & side bar -->
        <?php
        require 'includes/navAndSide.php';
        ?>

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

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Registration Status    </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Registration Status</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <form action="../include/exportreport.php" method="POST" enctype="multipart/form-data" class="noEnterOnSubmit">
                <div class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                            border: 2px solid gray;text-align: center">
                            <div class="row mb-3"><!-- criteria-->
                                <div class="col-sm-6">
                                    <label class="unrequired-field">Date From:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input placeholder="MM/DD/YYYY"
                                        name="subfrom" id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="unrequired-field">Date To:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input placeholder="MM/DD/YYYY"
                                        name="subto"  id="datemask2" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                    </div>
                                </div>
                            </div><!-- criteria-->
                            <div class="row mb-2"> <!-- criteria-->
                                <div class="col-lg-6">
                                    <div class="icheck-primary d-inline">
                                        <input onclick="ChangeFileNametoReg()"
                                        value="submitted" type="radio" id="radioPrimary1" name="r1" checked>
                                        <label for="radioPrimary1">Registered Students
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="icheck-primary d-inline">
                                        <input  onclick="ChangeFileNametoPending()"
                                        value="unsubmitted" type="radio" id="radioPrimary3" name="r1">
                                        <label for="radioPrimary3" >Pending Registration
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2"> <!-- criteria-->
                                <div class="col-lg-12">
                                    <label class="unrequired-field">Grade Level  :&nbsp&nbsp</label>
                                    <select name="gradelevel" id="gradelevel" onchange="ChangeFileNametoReg()">
                                    <option value="All">All levels</option>
                                    <option value="Nursery 1">Nursery 1</option>
                                    <option value="Nursery 2">Nursery 2</option>
                                    <option value="Kinder 1">Kinder 1</option>
                                    <option value="Kinder 2">Kinder 2</option>
                                    <option value="Grade 1">Grade 1</option>
                                    <option value="Grade 2">Grade 2</option>
                                    <option value="Grade 3">Grade 3</option>
                                    <option value="Grade 4">Grade 4</option>
                                    <option value="Grade 5">Grade 5</option>
                                    <option value="Grade 6">Grade 6</option>
                                    <option value="Grade 7">Grade 7</option>
                                    <option value="Grade 8">Grade 8</option>
                                    <option value="Grade 9">Grade 9</option>
                                    <option value="Grade 10">Grade 10</option>
                                    <option value="Grade 11">Grade 11</option>
                                    <option value="Grade 12">Grade 12</option>
                                    <?php
                                            // $sql = "select distinct inComingLevel from tbl_schoolinfo order by inComingLevel;";
                                            // $result=mysqli_query($conn, $sql); //rs.open sql,con

                                            // echo "<select name='gradelevel'>";
                                            // while ($row = mysqli_fetch_array($result)) {
                                            //     $rows[] = $row;
                                            // }
                                            // foreach ($rows as $row) {
                                            //     echo "<option value='" . $row['inComingLevel'] . "'>" . $row['inComingLevel'] . "</option>";
                                            // }
                                    ?>


                                    </select>
                                </div>
                            </div><!-- criteria-->
                            <div></div>
                            <div class="row mb-8"> <!--Export button-->
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                        <label class="unrequired-field">File Name  :&nbsp&nbsp</label>
                                        <input title="We will fill this up for you" value="<?php echo "RegisteredStudents_".date('Ymd')  ?>"
                                        id="filenameinfo" name="filenameinfo" value="RegisteredStudentsInfo" type="text" class="form-control">
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
                                        <button
                                        type="submit" name="btn-submit"  class="btn btn-primary add-button">
                                        <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export Report
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
        </div><!--content wrapper-->

    </div><!--wrapper-->

    <!-- ./wrapper -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable( {
                "scrollY": 200,
                "scrollX": true
            } );
        } );

       //Datemask2 mm/dd/yyyy
       $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })

       $('[data-mask]').inputmask()

        $("#date").mask("99/99/9999");

        // $( "#datemask2" ).on('input', function() {
        // if (this.value.replace(/[dd/mm/yyyy]/g, '').length >=1 ) {
        //   const toast = swal.mixin({
        //   toast: true,
        //   position: 'bottom-end',
        //   showConfirmButton: false,
        //   timer: 3000 });
        // toast.fire({
        //   type: 'warning',
        //   title: 'The maximum number of characters has been reached!'
        // });
        // }
        // });

        function ChangeFileNametoReg(){
            var gradeLevel=document.getElementById('gradelevel').value;
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
                                String(today.getDate()).padStart(2, '0') +
                                today.getFullYear();
            $("#filenameinfo").prop("value", "RegisteredStudents_" + gradeLevel + "_ " + FinalDateStr );
        }
        function ChangeFileNametoPending(){
            var gradeLevel=document.getElementById('gradelevel').value;
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') +
                                String(today.getDate()).padStart(2, '0') +
                                today.getFullYear();
            $("#filenameinfo").prop("value", "PendingRegistration_" + gradeLevel + "_ " + FinalDateStr );
        }
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
    <?php require '../maintenanceChecker.php';
  ?>
</body>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false;
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds
</script>


</html>

<?php
// if (isset($_POST["btn-submit"])) {
//   $_POST['gradelevel'] = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['gradelevel'])));
//   $_POST['r1'] = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['r1'])));
//   $_POST['filenameinfo'] = mysqli_real_escape_string($conn, stripcslashes(cleanThis($_POST['filenameinfo'])));

//   if  ($_POST['r1'] === "submitted"){
//     $submitted = 1;
//   }else{
//     $submitted = 0;
//   }

//     $sql = " select s.studentCode,s.lrn,s.prefix as gender, s.lastName, s.firstName,
//         s.middleName, s.suffix, s.birthdate, s.Address,s.Telno,s.Cellphone,
//         s.dateTimeSubmitted, i.inComingLevel, i.averageGrade
//         from tbl_student s join tbl_schoolinfo i
//         on s.studentID = i.studentID
//         where s.isSubmitted = " . $submitted . " and i.inComingLevel = '" . $_POST['gradelevel'] . "'
//         and date(s.dateTimeSubmitted) >= '"  . $_POST['subfrom'] . "'
//         and date(s.dateTimeSubmitted) <= '"  . $_POST['subto'] . "'
//         and schoolYearID = " . $schoolYearID . " order by s.lastName;";

//     $resultset = mysqli_query($conn, $sql);
//     if ($resultset->num_rows > 0) {
//         while( $rowsinfo = $resultset->fetch_assoc())
//         {
//             $studinfo[] = $rowsinfo;
//         }
//     }
//      $filename =  $_POST['filenameinfo'] . ".xls";
//      header("Content-Type: application/xls");
//      header("Content-Disposition: attachment; filename=\"$filename\"");
//      $show_coloumn = false;
//      ob_end_clean();
//      if(!empty($studinfo))
//      {
//          foreach($studinfo as $record)
//          {
//              if(!$show_coloumn)
//              {
//              // display field/column names in first row
//              echo implode("\t", array_keys($record)) . "\n";
//              $show_coloumn = true;
//              }
//              echo implode("\t",  array_values($record)) . "\n";
//          }

//      }
//      exit();


// }
?>
