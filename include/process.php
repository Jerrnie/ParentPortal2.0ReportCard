<?php
require '../include/config.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
?>


<?php
if(isset($_POST['btndelete'])){

  
  $all = $_POST['select_all'];

  if(empty($all))
  {
    $checkbox = $_POST['id'];

    if(empty($checkbox))
    {
      displayMessage("warning", "No selected","Please select atleast one checkbox!");
    }
    else{

    $checkbox = $_POST['id'];

    for($i=0;$i<count($checkbox);$i++){
    $del_id = $checkbox[$i]; 
    $query = "dELETE FROM tbl_parentuser  WHERE usertype ='P' AND userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'";
    mysqli_query($conn, $query);

    $query1 = "dELETE FROM tbl_student  WHERE userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'";
    mysqli_query($conn, $query1);

    header('Location: ../u/viewAllUser2.php?Delete');
    }
  }

  }
  else
  {
    
      $query = "dELETE FROM tbl_parentuser  WHERE usertype ='P' AND schoolYearID ='".$schoolYearID."'";
      mysqli_query($conn, $query);

      $query1 = "dELETE FROM tbl_student  WHERE schoolYearID ='".$schoolYearID."'";
      mysqli_query($conn, $query1);


      header('Location: ../u/viewAllUser2.php?Delete');
    
  }
}

if (isset($_REQUEST['Delete'])) {
  displayMessage("success", "Done!", "It was succesfully deleted!");
}

//Enable
if(isset($_POST['btnEnable'])){
  
  $all = $_POST['select_all'];

  if(empty($all))
  {
    $checkbox = $_POST['id'];
      
    if(empty($checkbox))
    {
    displayMessage("warning", "No selected","Please select atleast one checkbox!");
    }
    else{

      $checkbox = $_POST['id'];
      for($i=0;$i<count($checkbox);$i++){
      $del_id = $checkbox[$i]; 

      $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='1' WHERE usertype ='P' AND userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'");
      mysqli_query($conn, $query);
      
//      header('Location: ../u/viewAllUser2.php?Enabled');
      }
    }

  }
  else
  {
      $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='1' WHERE usertype='P' AND schoolYearID ='".$schoolYearID."'");
      mysqli_query($conn, $query);

      
      header('Location: ../u/viewAllUser2.php?Enabled');
  }
}
if (isset($_REQUEST['Enabled'])) {
  displayMessage("success", "Done!", "It was succesfully enabled!");
}


//Disable
if(isset($_POST['btnDisable'])){
 
  $all = $_POST['select_all'];

  if(empty($all))
  {
    $checkbox = $_POST['id'];
        
    if(empty($checkbox))
    {
    displayMessage("warning", "No selected","Please select atleast one checkbox!");
    }
    else{
    $checkbox = $_POST['id'];
    for($i=0;$i<count($checkbox);$i++){
    $del_id = $checkbox[$i];
    $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='0' WHERE usertype ='P' AND userID='" . $del_id . "' AND schoolYearID ='".$schoolYearID."'");
    mysqli_query($conn, $query);

    header('Location: ../u/viewAllUser2.php?Disabled');
    }
  }
  }
  else
  {
      $query = mysqli_query($conn, "UPDATE tbl_parentuser SET  IsEnabled='0' WHERE usertype='P' AND schoolYearID ='".$schoolYearID."'");
      mysqli_query($conn, $query);
    
      header('Location: ../u/viewAllUser2.php?Disabled');
  }
}

if (isset($_REQUEST['Disabled'])) {
  displayMessage("success", "Done!", "It was succesfully disabled!");
}

?>