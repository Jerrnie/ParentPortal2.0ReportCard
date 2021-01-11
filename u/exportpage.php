<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require 'assets/scripts/phpfunctions.php';
  require 'assets/generalSandC.php';
  require '../include/schoolConfig.php';
  $page= 'exportpage';

  // select box open tag
$selectBoxOpen = "<select name='sectionYearLevel'>";
// select box close tag
$selectBoxClose = "</select>";
// select box option tag
$selectBoxOption = '';

$sql = "sELECT  sectionYearLevel  FROM tbl_sections";
// play with return result array
$result = mysqli_query($conn, $sql);
 
while($row = mysqli_fetch_array($result)){
$selectBoxOption .="<option value = '".$row['sectionYearLevel']."'>".$row['sectionYearLevel']."</option>";
}
// create select box tag with mysql result
$selectBox = $selectBoxOpen.$selectBoxOption.$selectBoxClose;



$selectBoxOpen1 = "<select name='sectionName'>";
// select box close tag
$selectBoxClose1 = "</select>";
// select box option tag
$selectBoxOption1 = '';

$sql1 = "sELECT  sectionName  FROM tbl_sections";
// play with return result array
$result1 = mysqli_query($conn, $sql1);
 
while($row = mysqli_fetch_array($result1)){
$selectBoxOption1 .="<option value = '".$row['sectionName']."'>".$row['sectionName']."</option>";
}
// create select box tag with mysql result
$selectBox1 = $selectBoxOpen1.$selectBoxOption1.$selectBoxClose1;


?>

<html lang="en">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Export | Parent Portal</title>
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
                            <h1>Export Data</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Export Data</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body display nowrap" style="width:100%;border-radius: 25px;
                            border: 2px solid gray;text-align: center">
                             <div class="row mb-3"> 
                                <div class="col-lg-2">
                                </div>
                                 <div class="col-lg-8">
                                    <h3>Export Stundet Attendance</h3>
                                 </div>
                                 <div class="col-lg-2">
                                </div>
                                
                            </div>
                            <form action="../include/export.php" method="post">
                            <!-- submitted-->
                            <!-- <div class="row mb-4">
                                <div class="col-sm-6">
                                        <label class="unrequired-field">Submitted From:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input value="<?php echo isset($_POST['subfrom']) ? $_POST['subfrom'] : '' ?>"
                                            name="birthdate" id="datemask2" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="unrequired-field">To:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input value="<?php echo isset($_POST['birthdate']) ? $_POST['birthdate'] : '' ?>"
                                        name="birthdate" id="datemask2" type="text" class="form-control" data-inputmask-alias="datetime"data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                    </div>
                                </div>
                            </div>  -->
                            <!-- submitted-->
                                  <!-- Default box -->
            <div class="row mb-1">
                <div class="col-sm-6">
                  <label class="unrequired-field">Date From:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input placeholder="MM/DD/YYYY" name="from_date" id="from_date" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  </div>
                </div>

                <div class="col-sm-6">
                  <label class="unrequired-field">Date To:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input placeholder="MM/DD/YYYY" name="to_date" id="to_date" type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  </div>
                </div>
              </div>
              <div class="row mb-1">
                
              <div class="col-sm-6">
                  <label class="unrequired-field">Grade Level :</label>
                  <div class="input-group">
                    <select style="text-align:center;" name="level" id="level" class="form-control" >
                    <option value="">-Select Level-</option>
                    <?php echo $selectBoxOption;?>
                    </select>
                  </div>
                </div>
              
                <div class="col-sm-6">
                  <label class="unrequired-field">Section :</label>
                  <div class="input-group">
                    <select style="text-align:center;" name="section" id="section" class="form-control" >
                    <option value="">-Select Section-</option>
                    <?php echo $selectBoxOption1;?>
                    </select>
                  </div>
                </div>
              </div>
              
                            <div class="row mb-4"> <!-- Filename-->
                                <div class="col-lg-3">
                                </div>
                                <div class="col-lg-6">
                                    <label class="unrequired-field">File Name:</label><br>
                                    <div class="input-group">
                                    <input title="We will fill this up for you" value="<?php echo "Student_Attendance_".date('Ymd')  ?>"
                                    id="filename" name="filename" value="RegisteredStudents" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                </div>
                            </div><!-- Filename-->

                            <div class="row mb-2"> <!--Export button-->
                                    <div class="col-lg-2">
                                    </div>
                                    <div class="col-lg-8" style="display: flex;justify-content: center;
                                        align-items: center;">
                                        <!-- <button onclick="Export()" id="export"
                                        type="button" class="btn btn-primary add-button">
                                        <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export Records
                                        </button> -->
                                        <button name="exportbtn"
                                        type="submit" class="btn btn-primary add-button">
                                        <span class=" fas fa-file-alt">&nbsp&nbsp</span>Export Stundet Attendance
                                        </button>
                                    </div>
                                    <div class="col-lg-2">
                                    </div>
                            </div> <!-- Export button -->
                            </form>
                        </div>
            </section>

        </div> <!-- content-wrapper-->

    </div>


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

        function Export()
        {
            var conf = confirm("Export student general info to XLS?");
            if(conf == true)
            {
                window.open("../include/export.php", '_blank');
            }
            var conf = confirm("Export student detailed info to XLS?");
            if(conf == true)
            {
                window.open("../include/exportdata.php", '_blank');
            }
        }

        function ChangeFileNametoAll(){
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') + 
                                String(today.getDate()).padStart(2, '0') + 
                                today.getFullYear();
            $("#filename").prop("value", "General_ALLStudents_"  + FinalDateStr );
        }
        function ChangeFileNametoPending(){
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') + 
                                String(today.getDate()).padStart(2, '0') + 
                                today.getFullYear();
            $("#filename").prop("value", "General_PendingExport_"  + FinalDateStr );
        }
        function ChangeFileNametoExported(){
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') + 
                                String(today.getDate()).padStart(2, '0') + 
                                today.getFullYear();
            $("#filename").prop("value", "General_Exported_"  + FinalDateStr );
        }
        function ChangeFileNametoDetAll(){
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') + 
                                String(today.getDate()).padStart(2, '0') + 
                                today.getFullYear();
            $("#filenameinfo").prop("value", "Details_ALLStudents_"  + FinalDateStr );
        }
        function ChangeFileNametoDetPending(){
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') + 
                                String(today.getDate()).padStart(2, '0') + 
                                today.getFullYear();
            $("#filenameinfo").prop("value", "Details_PendingExport_"  + FinalDateStr );
        }
        function ChangeFileNametoDetExported(){
            var today = new Date();
            var FinalDateStr = String(today.getMonth() + 1).padStart(2, '0') + 
                                String(today.getDate()).padStart(2, '0') + 
                                today.getFullYear();
            $("#filenameinfo").prop("value", "Details_Exported_"  + FinalDateStr );
        }
    </script>

    <?php
    require 'assets/scripts.php';

    if(isset($_POST['exportbtn'])){


        
    }
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
    <script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false; 
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds 
</script>
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" type="text/css" href="../include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <?php require '../maintenanceChecker.php';
  ?>
</body>

</html>