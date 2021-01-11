  <?php 
    if ($Prefix =="M") {
      $sex = "Male";
    }
    else{
      $sex = $Prefix ;
    }
    $noOfSibling;
    $hasSchoolInfo;
    $hasFather;
    $hasMother;
    $sibling1_siblingID;
    $sibling1_fullName ;
    $sibling1_level    ;
    $sibling2_siblingID;
    $sibling2_fullName ;
    $sibling2_level    ;
    $sibling3_siblingID;
    $sibling3_fullName ;
    $sibling3_level    ;
    $sibling4_siblingID;
    $sibling4_fullName ;
    $sibling4_level    ;
    $sibling5_siblingID;
    $sibling5_fullName ;
    $sibling5_level    ;
    $hasSibling1=0;
    $hasSibling2=0;
    $hasSibling3=0;
    $hasSibling4=0;
    $hasSibling5=0;
    $hasFamilyinformation=1;
    $status;

    $sql = "sELECT a.* FROM tbl_contact AS a WHERE a.studentID = '".$studentID."'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($pass_row = mysqli_fetch_array ($result)) {
            $haveContact='1';
//19.18.17.2
            $contactID      = $pass_row['2'];
            $fullName       = $pass_row['3'];
            $phone          = $pass_row['4'];
            $mobile         = $pass_row['5'];
            $email         = $pass_row['6'];
        }
        else{
          $haveContact='0';
        }
            
    }
    else{
      $haveContact='0';
    }

  }

  else{
      $haveContact='0';
  }

      $sql = "sELECT a.* FROM tbl_schoolinfo AS a WHERE a.studentID = '".$studentID."'";
    $result = mysqli_query($conn, $sql);
     $isSubmittable='';
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($pass_row = mysqli_fetch_array ($result)) {
            $hasSchoolInfo ='1';

            $schoolInfoID       = $pass_row['2'];
            $schoolLastAttended = $pass_row['3'];
            $schoolYear         = $pass_row['4'];
            $schoolAddress      = $pass_row['5'];
            $levelCompleted     = $pass_row['6'];
            $averageGrade       = $pass_row['7'];
            $strand             = $pass_row['8'];

                if (empty($levelCompleted)) {
                    $isSubmittable = 'false';
                  }
                  else{
                    $isSubmittable = 'true';
                  }
        }
        else{
          $hasSchoolInfo ='0';
        }
            
    }
    else{
      $hasSchoolInfo ='0';
    }

  }

  else{
      $hasSchoolInfo ='0';
  }

  $sql = "sELECT a.* FROM tbl_parents AS a WHERE a.studentID = '".$studentID."' and isFather = '0'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($pass_row = mysqli_fetch_array ($result)) {
            $hasMother ='1';

            $motherID       = $pass_row['2'];
            $mother_fullName       = $pass_row['3'];
            $mother_employerName   = $pass_row['4'];
        }
        else{
          $hasMother ='0';
        }
            
    }
    else{
      $hasMother ='0';
    }

  }

  else{
      $hasMother ='0';
  }

  $sql = "sELECT a.* FROM tbl_parents AS a WHERE a.studentID = '".$studentID."' and isFather = '1'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($pass_row = mysqli_fetch_array ($result)) {
            $hasFather ='1';

            $fatherID       = $pass_row['2'];
            $father_fullName       = $pass_row['3'];
            $father_employerName   = $pass_row['4'];
        }
        else{
          $hasFather ='0';
        }
            
    }
    else{
      $hasFather ='0';
    }

  }

  else{
      $hasFather ='0';
  }

    $sql = "sELECT a.* FROM tbl_guardian AS a WHERE a.studentID = '".$studentID."'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        if ($pass_row = mysqli_fetch_array ($result)) {
            $hasGuardian ='1';

            $guardianID              = $pass_row['2'];
            $guardian_fullName       = $pass_row['3'];
            $guardian_relationship   = $pass_row['4'];
            $guardian_phone          = $pass_row['5'];
            $guardian_mobileNumber   = $pass_row['6'];
        }
        else{
          $hasGuardian ='0';
        }
            
    }
    else{
      $hasGuardian ='0';
    }

  }

  else{
      $hasGuardian ='0';
  }

  $sql = "sELECT a.* FROM tbl_siblings AS a WHERE a.studentID = '".$studentID."'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        while ($pass_row = mysqli_fetch_array ($result)) {
          if ($pass_row['siblingNo'] == '1') {
            $hasSibling1='1';
            $sibling1_siblingID = $pass_row['siblingID'];
            $sibling1_fullName  = $pass_row['fullName'];
            $sibling1_level     = $pass_row['level'];
          }
          else if ($pass_row['siblingNo'] == '2') {
            $hasSibling2='1';
            $sibling2_siblingID = $pass_row['siblingID'];
            $sibling2_fullName  = $pass_row['fullName'];
            $sibling2_level     = $pass_row['level'];
          }
          else if ($pass_row['siblingNo'] == '3') {
            $hasSibling3='1';
            $sibling3_siblingID = $pass_row['siblingID'];
            $sibling3_fullName  = $pass_row['fullName'];
            $sibling3_level     = $pass_row['level'];
          }
          else if ($pass_row['siblingNo'] == '4') {
            $hasSibling4='1';
            $sibling4_siblingID = $pass_row['siblingID'];
            $sibling4_fullName  = $pass_row['fullName'];
            $sibling4_level     = $pass_row['level'];
          }
          else if ($pass_row['siblingNo'] == '5') {
            $hasSibling5='1';
            $sibling5_siblingID = $pass_row['siblingID'];
            $sibling5_fullName  = $pass_row['fullName'];
            $sibling5_level     = $pass_row['level'];
          }
        }
            
    }
    // else{
    //   $hasSibling1 ='0';
    // }

  }

  // else{
  //     $hasSibling1 ='0';
  // }
  // 
  $sql = "sELECT count(a.userID) as noOfSibling FROM tbl_siblings AS a WHERE a.studentID = '".$studentID."'";



$result = mysqli_query($conn, $sql);
$pass_row = mysqli_fetch_assoc($result);
$noOfSibling = $pass_row['noOfSibling'];

  if (!$hasSibling1 && !$hasSibling2 && !$hasSibling3 && !$hasSibling4 && !$hasSibling5 && !$hasFather && !$hasMother) {
    $hasFamilyinformation='0';
  }

if ($studentSchoolYearID==0) {
  $isSchoolYearMatch = false;
}
else{
                        $isSchoolYearMatch = $schoolYearID == $studentSchoolYearID;
                        }

  ?>
<input type="hidden" name="countofsibs" id="countofsibs" value="<?php echo $noOfSibling ?>">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo ucfirst(strtolower($Lastname) )?>'s information</h1>
          </div>
          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Registration</a></li>
              <li class="breadcrumb-item active">View Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>











<!-- ------------------------------------ -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content" style="-webkit-print-color-adjust: exact !important; ">
    <!-- Content Header (Page header) -->

<div class="row">
<div class="col-lg-1"><br></div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3 col-lg-10" >
              <!-- title row -->
              <div class="row" >
                <div class="col-12" >
                  <h4>
                    <img src="<?PHP echo "../".SCHOOL_LOGO_PATH?>" alt="<?PHP echo SCHOOL_ABV?>" class="brand-image img-circle elevation-3 slOnpage"
                      style="opacity: .8">&nbsp&nbsp<?php echo SCHOOL_NAME?>
                    <small class="float-right">Date Time Generated: <?php echo date("d/m/Y H:i:s")?></small>
                  </h4>
                </div>
              </div>

            <div>
                
              <div class="row">
<!-- <p class="lead">Powered by</p><img width="250px;" src="../assets/imgs/PrismLogoLong.jpg"> -->
                <div class="col-6">
<br><br><br><br><br><br><br>
                  <div class="row">
              <div class=" col-sm-12 invoice-info" style="margin-top: 19px; ">
<div class="row">
                <div class="col-5 invoice-col" >
                  <span class="lead">Student Information:</span><br>
                        <b>Name: </b><?php echo combineName($Firstname,$Lastname,$Middlename); ?><br>

                        <b>Gender: </b><?php echo $sex ?><br>

                        <b>Suffix: </b><?php echo $Suffix ?><br>

                        <b>Birthdate: </b><?php echo date('d/m/Y', strtotime($Birthdate)); ?><br>
                        <b>Address:</b><?php echo $Address." ".$city  ?><br>
                        <b>Birthplace: </b><?php echo $Birthplace ?><br>

                </div>
                <div class="col-5 invoice-col">
                  <span class="lead">Contact Information:</span>
                  <p class=" well well-sm shadow-none" style="margin-top: 2px; ">

                    <?php if (isset($fullName)&&trim($fullName)!= "") { ?>
                      <b>Full Name: </b> <?php echo $fullName?></br>

                      <b>Mobile Number: </b>   <?php echo $mobile?></br>

                      <b>Phone Number: </b>    <?php echo $phone?></br>


                      <b>Email: </b>    <?php echo $email?></br>
                    <?php } else{ ?>
                      <b>Full Name: </b></br>

                      <b>Mobile Number: </b></br>

                      <b>Phone Number: </b></br>


                      <b>Email: </b></br>
                    <?php }?>


                  </p>
                </div>

</div>


                </div>
                  </div>
<br>
                  <div class="row">
                <div class="col-12">
                  <span class="lead">Previous Schoool Information:</span>
                  <p class=" well well-sm shadow-none" style="margin-top: 2px; ">

                    <?php if ($hasSchoolInfo) { ?>
                    <b>School: </b><?php echo $schoolLastAttended ?></br>

                    <b>School Year: </b><?php echo $schoolYear ?></br>

                    <b>School Address: </b><?php echo $schoolAddress ?></br>

                    <b>Average Grade: </b><?php echo $averageGrade ?></br>

                    <b>Incoming Level: </b><?php echo $levelCompleted ?>
                    <?php if ($strand!=''&&$strand!=' '){echo "<b>-</b> <i>".$strand."</i></br>";}?>
                    
                    <?php } else{ ?>
                    <b>School: </b></br>

                    <b>School Year: </b></br>

                    <b>School Address: </b></br>

                    <b>Average Grade: </b></br>

                    <b>Incoming Level: </b>

                    <b>Strand: </b></br>

                    <?php }?>
                  </p>
                </div>


                  </div>

                </div>

                <div class="col-6">

                  <div class="row">
                    <div class="col-7">
                      <div class="row" >
                        <div class="col-12 col-lg-10">
                  <img  src="../assets/imgs/prismLogo.png" style="width: 150px" class="float-right">
  </div>  
                      </div>
                    </div>
                      
                    <div class="col-5 col-sm-5" style="">

                      <b>Student Code: <?php echo $studentCode ?>
                      <br>
                      <b>LRN: </b><?php echo $LRN ?>
                      <br>
                      <b>User No. :</b> <?php echo  $userID?><br>
                      <b>Status:</b> <?php if ($isSchoolYearMatch&&$isSubmitted) {  echo '<span class=" badge badge-info">Registred</span>'; } else{ echo '<span id="submitBadge" class="  badge badge-danger">Pending Registration</span>';} ?></b>
                    </div>
                  </div>

                  <div class="row">
                <!-- /.col -->
                <div class="col-12" style="margin-top: 14px;"><br>
                  <span class="lead">Family Background:</span><br>

                  <div class="table-responsive">
                    <table class="table">
                <tr>
                  <th width="155px;">Parents</th>
                  <th >Name</th>
                  <th>Employer</th>
                </tr>
                    <?php if ($hasFather) { ?>
                      <tr>
                        <th>Father</th>
                        <td><?php echo $father_fullName; ?></td>
                        <td><?php echo $father_employerName; ?></td>
                      </tr>
                      <?php } else{ ?>
                      <tr>
                        <th>Father</th>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                      </tr>
                    <?php }?>

                    <?php if ($hasMother) { ?>
                      <tr>
                        <th>Mother</th>
                        <td><?php echo $mother_fullName; ?></td>
                        <td><?php echo $mother_employerName; ?></td>
                      </tr>
                    <?php } else{ ?>
                      <tr>
                        <th>Mother</th>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                      </tr>
                    <?php }?>

                    </table>
                  </div>
                  <hr>

                  <div class="table-responsive">
                    <table class="table">
                <tr>
                  <th width="155px;">Sibling</th>
                  <th >Name</th>
                  <th>Level&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                </tr>

                    <?php if ($hasSibling1) { ?>
                      <tr>
                        <th>&nbsp</th>
                        <td><?php echo $sibling1_fullName; ?></td>
                        <td><?php echo $sibling1_level; ?></td>
                      </tr>
                    <?php }?>


                    <?php if ($hasSibling2) { ?>
                      <tr>
                        <th>&nbsp</th>
                        <td><?php echo $sibling2_fullName; ?></td>
                        <td><?php echo $sibling2_level; ?></td>
                      </tr>
                    <?php }?>


                    <?php if ($hasSibling3) { ?>
                      <tr>
                        <th>&nbsp</th>
                        <td><?php echo $sibling3_fullName; ?></td>
                        <td><?php echo $sibling3_level; ?></td>
                      </tr>
                    <?php } ?>



                    <?php if ($hasSibling4) { ?>
                      <tr>
                        <th>&nbsp</th>
                        <td><?php echo $sibling4_fullName; ?></td>
                        <td><?php echo $sibling4_level; ?></td>
                      </tr>
                    <?php }  ?>
  


                    <?php if ($hasSibling5) { ?>
                      <tr>
                        <th>&nbsp</th>
                        <td><?php echo $sibling5_fullName; ?></td>
                        <td><?php echo $sibling5_level; ?></td>
                      </tr>
                    <?php } ?>


                      



                    </table>
                  </div>
                </div>
                <!-- /.col -->
                  </div>

                </div>

              </div>


            </div>
              <!-- /.row -->

<br>

              <!-- /.row -->
<br>
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
            <a href="?page=<?php echo $studentID?>&print" class="btn btn-secondary"><i class="fas fa-print"></i> Print</a>
                  
<?php            if(!($isSchoolYearMatch&&$isSubmitted)){
                  echo'       <a href="#" id="deleteBTN" class="btn delete btn-danger float-right"  value="'.$studentID.'" >';
                  echo'           <i class="fas fa-trash">';
                  echo'           </i>';
                  echo'           Delete';
                  echo'       </a>';
                  echo'       <a style="margin-right:10px;" isSubmittable='.$isSubmittable.' class="btn btn-success submit  float-right" id="submitBTN" href="#" value="'.$studentID.'">';
                  echo'           <i class="fas fa-check-square">';
                  echo'           </i>';
                  echo'           &nbspRegister';
                  echo'       </a>';
                  echo'    <button style="margin-right:10px;" ';
                  echo'    data-toggle="modal" data-target="#addstudentmodal"';
                  echo'    type="button" id="btnEdit" class="btn btn-primary no-print float-right">';
                  echo'    <span class=" fa fa fa-edit">&nbsp&nbsp</span>Edit';
                  echo'    </button>';
                  }

            ?> 
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
  </div>
  <!-- /.content-wrapper -->
  </div>

