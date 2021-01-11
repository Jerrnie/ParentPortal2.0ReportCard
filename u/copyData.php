<?php 
require '../include/config.php';
require '../assets/phpfunctions.php';

$id = $_POST['studentidx'];


if($id > 0){

  // Check record exists

    $sql = "select a.currentSchoolYear from tbl_settings as a ";

    $result = mysqli_query($conn, $sql);

    $pass_row = mysqli_fetch_assoc($result);

    $schoolYearID = $pass_row['currentSchoolYear'];
    



    $nowtime = date("Y-m-d H:i:s");
 	  $query = "update tbl_student set isSubmitted =  '0' , isExported =  '0' , datetimePosted = null, datetimeRegistered = '".$nowtime."', schoolYearID ='".$schoolYearID."'  WHERE studentID='".$id."'";
	  mysqli_query($conn,$query);

	   	  $query = "update tbl_schoolinfo set inComingLevel =  null , inComingTrack =  null  WHERE studentID='".$id."'";
	  mysqli_query($conn,$query);




  
}


?>