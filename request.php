<?php 
require 'include/config.php';

$mobile = $_POST['studentidx'];


if($mobile > 0){

  // Check record exists
  $checkRecord = mysqli_query($conn,"SELECT userID FROM tbl_parentuser where mobile ='".$mobile."'");
  $totalrows = mysqli_num_rows($checkRecord);

  if($totalrows > 0){
    
    $query = "UPDATE tbl_parentuser SET resetRequest ='Yes' WHERE mobile='".$mobile."'";
    mysqli_query($conn,$query);

    exit;
  }
}
else{
	echo "0";
}

echo 0;
exit; 
?>