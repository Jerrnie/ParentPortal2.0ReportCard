<?php 
require '../include/config.php';

$id = $_POST['studentidx'];


if($id > 0){

  // Check record exists
  $checkRecord = mysqli_query($conn,"sELECT studentID FROM tbl_student where studentID ='".$id."'");
  $totalrows = mysqli_num_rows($checkRecord);

  if($totalrows > 0){
    // Delete record
    $query = "dELETE FROM tbl_student  WHERE studentID='".$id."'";
    mysqli_query($conn,$query);
	  $query = "dELETE FROM tbl_siblings WHERE studentID='".$id."'";
	  mysqli_query($conn,$query);
	  $query = "dELETE FROM tbl_guardian WHERE studentID='".$id."'";
	  mysqli_query($conn,$query);
	  $query = "dELETE FROM tbl_schoolyear WHERE studentID='".$id."'";
	  mysqli_query($conn,$query);
	  $query = "dELETE FROM tbl_schoolinfo WHERE studentID='".$id."'";
	  mysqli_query($conn,$query);
	  $query = "dELETE FROM tbl_contact WHERE studentID='".$id."'";
	  mysqli_query($conn,$query);
	echo 1;
    exit;
  }
}

echo 0;
exit; 
?>