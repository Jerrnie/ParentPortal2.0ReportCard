<!DOCTYPE html>

<?php
date_default_timezone_set("Asia/Bangkok");
$database = "testDB";
$host = "52.74.3.44";
$username = "smsuser";
$password = "smspass";

$conn = mysqli_connect($host, $username, $password, $database);

if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}
// error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
    
  
    $data = array();
    
    $query = "SELECT * FROM tbl_Events ORDER BY Event_Id";
    
    $statement = $conn->prepare($query);
    
    $statement->execute();
    
    $result = $statement->fetchAll();
    
    foreach($result as $row)
    {
     $data[] = array(
      'id'   => $row["Event_Id"],
      'title'   => $row["EventName"],
      'start'   => $row["start_event"],
      'end'   => $row["end_event"]
     );
    }
    
    echo json_encode($data);
    
    ?>
    