<!DOCTYPE html>

<?php
  require '../include/config.php';
  require 'assets/fonts.php';
  require 'assets/generalSandC.php';
  require 'assets/adminlte.php';
  require 'assets/scripts/phpfunctions.php';
  require 'assets/generalSandC.php';
  require '../include/schoolConfig.php';
  require '../include/getschoolyear.php';
  $page = "studentImport";

?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Import Students | Parent Portal</title>
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

  <style type="text/css">
    
    #loading {
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  position: fixed;
  display: block;
  opacity: 0.7;
  background-color: #fff;
  z-index: 99;
  text-align: center;
}

#loading-image {
  position: absolute;
  top: 40%;
  left: 40%;
  z-index: 100;

}

.iconsize {
      width: 32px; 
      height: 32px;
    } 
  </style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">

<!-- nav bar & side bar -->
<?php
  session_start();
require 'includes/navAndSide.php';
  unset($_FILES);

  require '../vendor/autoload.php';
require '../include/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../login.php");
  }
  else if ($levelCheck=='P'){
    header("location: home.php"); 
  }
  else if ($levelCheck=='E'){
    header("location: PersonnelHome.php");
  }
  
 
  $checkRecord = mysqli_query($conn,"sELECT max(sectionID) as lastInsert FROM tbl_sections");
  $pass_row = mysqli_fetch_assoc($checkRecord);

  if (!$pass_row['lastInsert']>0) {
    header('Location: courseImport.php?sectionRequired');
  }
?>
<!-- nav bar & side bar -->


  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
	<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        	<div class="col-sm-6">
            <h1>Import Students</h1>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Import Students</li>
            </ol>
         	 </div>
       		</div>
     	</div><!-- /.container-fluid -->
    </section>

    <!-- <div class="content-header"> -->
	    <!-- Main content -->
		<section class="content"><br>
				<!-- <div class="box span12"> -->
<div class="row">
   <div class="col-lg-1">&nbsp</div>
   <div class="col-lg-10">
      <div class="card card-secondary">
         <div class="card-header">
            <h3 class="card-title" style="font-size: 28px;">Import via Excel Template</h3>
                                        <div class="card-tools">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <a href="tmp/Student Template.xls" class="badge badge-warning " style="color: black; font-size: 18px;">Download Template</a>
    </div>
         </div>
         <!-- form start -->
         <form role="form" method="post" action="studentImport.inc.php" enctype="multipart/form-data">
            <div class="card-body">
               <div class="form-group">
                  <label for="exampleInputFile">.xls / .xlsx</label>
                  <div class="input-group">
                     <div class="custom-file">
                        <input type="file" class="custom-file-input"  name="ASD" id="excelFile">
                        <label class="custom-file-label" for="exampleInputFile"  id="excelFileLabel">Choose file</label>
                     </div>
                     <div class="input-group-append">
                        <button type="submit" onclick="showLoad()" name="excelUpload" class="input-group-text" id="">Upload</button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
         </section>
         <div class="row">
           <div class="container-fluid"  style="padding-left: 14px; padding-right: 12px;">
            <div class="row">
            <div class="col-lg-1">&nbsp</div>
             <div class="col-lg-10">
               
        <!-- Default box -->
        <div class="card card-secondary">
          <div class="card-header">
            <span style="font-size: 28px;">List of Students</span>
              <a href="?" type="button" class="btn btn-success add-button buttonDelete ">
                <span class="fa fa-undo  ref-btn ref-btn2" aria-hidden="true">&nbsp&nbsp</span>Refresh
              </a>


</button>
            
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="width: 100%;">
            <table id="example1" class="table table-bordered" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>
                  <th>Student Code</th>
                  <th>Name</th>
                  <th>Year Level</th>
                  <th>Section</th>
                  <th>Parent Name</th>
                  <th>Mobile Number</th>
                  <th>Action</th>

                </tr>
              </thead>
              <tbody>
                <?php

                $dir    = 'RC/';
                $files = scandir($dir, 1);






                $sql = "sELECT a.studentID, a.studentCode, a.firstName, a.middleName, a.lastName, b.sectionName, b.sectionYearLevel,c.fullname,c.mobile FROM tbl_student AS a INNER JOIN tbl_sections AS b ON a.sectionID = b.sectionID inner join tbl_parentuser as c on c.userID = a.userID WHERE a.schoolYearID = '" . $schoolYearID . "' ORDER BY a.lastName,a.firstName ASC";
                
                // For two parent in one student
                /* $sql = "SELECT A.studentID, A.studentCode, A.firstName, A.middleName, A.lastName, C.sectionName, 
                C.sectionYearLevel,D.fullname,D.mobile FROM tbl_student A 
                JOIN tbl_StudentTransaction B ON B.studentID = A.studentID
                LEFT JOIN tbl_sections C ON C.sectionID = A.sectionID
                LEFT JOIN tbl_parentuser D ON D.userID = B.userID
                WHERE A.schoolYearID = '" . $schoolYearID . "' ORDER BY A.lastName,A.firstName ASC";*/
                
                $result1 = mysqli_query($conn, $sql);
                $ctr = 0;
                if (mysqli_num_rows($result1) > 0) {
                  while ($row = mysqli_fetch_array($result1)) {

                    $studentID   = $row[0];
                    $studentCode = $row[1];
                    $name        = ucwords(combineName($row[2],$row[4],$row[3]));;
                    $sectionName   = $row[5];
                    $yearLevel     = $row[6];
                    $parentName = $row[7];
                    $mobile = $row[8];



                    $file = $studentCode;
                $matchIndex;
                $haveMatch;




                    $status = '';

                    echo "<tr class='tRow' id='row" . $ctr . "'>";
                    echo "<td><h5>";
                    echo $studentCode;
                    echo "</h5></td>";
                    echo "<td><h6>";
                    echo $name;
                    echo "</h6></td>";

                    if ($sectionName=='Unset') {
                    echo "<td><h6>";
                    echo "NOT SET";
                    echo "</h6></td>";
                    echo "<td><h6>";
                    echo "-------";
                    echo "</h6></td>";
                    }

                    else{
                    echo "<td><h6>";
                    echo $yearLevel;
                    echo "</h6></td>";
                    echo "<td><h6>";
                    echo $sectionName;
                    echo "</h6></td>";
                   
                  }

                  echo "<td><h6>";
                  echo $parentName;
                  echo "</h6></td>";
                  echo "<td><h6>";
                  echo $mobile;
                  echo "</h6></td>";
                 

                      echo '<td class="text-center">';
                      echo '       <a class="btn btn-info iconsize" title="Edit Information" href="StudentInformation.php?page=' . $row[0] . '">';
                      echo '           <i class="fas fa-edit d-flex justify-content-center">';
                      echo '           </i>';
                      echo '        </a>';
                      
                      echo '        <a href="#" class="btn remove iconsize btn-danger" title="Remove Student" id="remove' . $ctr . '" rowIdentifier="row' . $ctr . '"  value="' . $studentID . '" >';
                      echo '           <i class="d-flex justify-content-center fas fa-trash">';
                      echo '           </i>';
                      echo '        </a>';
                      echo '   </td>';




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
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

             </div>
           </div>
         </div>
         <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
      </div>
      <!--/row--> 


   </div>
</div>

<div id="loading">
  <img id="loading-image" src="../assets/imgs/ajax-loader.gif" alt="Loading..." />
</div>
<!-- ./wrapper -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
var input = document.getElementById( 'excelFile' );
var infoArea = document.getElementById( 'excelFileLabel' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  
  // the change event gives us the input it occurred in 
  var input = event.srcElement;
  
  // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
  var fileName = input.files[0].name;
  
  // use fileName however fits your app best, i.e. add it into a div
  infoArea.textContent = 'File name: ' + fileName;
}	


function showLoad(){
  $('#loading').show();
}


</script>






<?php

require 'assets/scripts.php';

?>
<!-- customize scripts -->
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
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false; 
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds 

  $(document).ready(function() {
    $('#example1').DataTable({
      "scrollX": true,
    });
  });
    $('#loading').hide();




    $(document).on("click", ".remove", function() {
      var x = $(this).attr('value');
      var row = $(this).attr('rowIdentifier');

      Swal.fire({
        title: 'Are you sure?',
        text: "Deleted record(s) cannot be restored.",
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
            url: "deleteStudent.php",
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
              swal.fire("Error deleted!", "Please try again", "error");
            }
          });
        }
      })
      e.preventDefault();
    });
</script>



<?php require '../maintenanceChecker.php';
  ?>
</body>

</html>
<?php

if (isset($_SESSION['failedList'])) {
  $faileds = $_SESSION['failedList'];
//   $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();

// Load an existing spreadsheet
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
$spreadsheet = $reader->load("tmp/Student Template.xls");

// Get the first sheet
$sheet = $spreadsheet ->getActiveSheet();

// Remove 2 rows starting from the row 2
$sheet ->removeRow(2,2);



#setting
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

$sheet
    ->fromArray(
        $faileds,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );

$writer = new Xlsx($spreadsheet);
//$nowtime = date("Y-m-d H-i-s");
$filename = "ForRevision-StudentImport.xlsx";
$writer->save("tmp/".$filename);
echo "<meta http-equiv='refresh' content='0;url=tmp/".$filename."'/>";
unset($_SESSION['failedList']);
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("info", "Import Details", $message);
  unset($_SESSION['MESSAGE-PROMPT']);
  // ignore_user_abort(true);
  //  unlink("tmp/".$filename);
  exit(0);
}


else if (isset($_SESSION['MESSAGE-PROMPT'])&&!isset($_REQUEST['importSuccess'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("error","Invalid Entry",$message);
  unset($_SESSION['MESSAGE-PROMPT']);
  exit(0);
}


else if (isset($_SESSION['MESSAGE-PROMPT'])&&isset($_REQUEST['importSuccess'])) {
  $message = $_SESSION['MESSAGE-PROMPT'];
  displayMessage("info", "Import Details", $message);
  unset($_SESSION['MESSAGE-PROMPT']);
  exit(0);
}

?>

<?php
if (isset($_REQUEST['update'])) {
  $message = "";
  displayMessage("success", "Success", $message);
}
?>