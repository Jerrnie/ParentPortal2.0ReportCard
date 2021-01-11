<?php
function displayMessage($type,$title,$message){
  echo "<script>";
    echo "Swal.fire({";
      echo "html: '$message',";
      echo "type: '$type',";
      echo "title: '$title',";
      echo "customClass: 'swal-sm'";
    echo "})";
  echo "</script>";

}
function cleanThis($string) {
   $string = str_replace('-', '', $string);
   $string = str_replace(' ', '', $string);
   $string = str_replace('/', '', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
   return $string;
}
function cleanData($data)
{
  require 'include/config.php';
  $data= stripcslashes($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

function combineName($fName,$lName,$mName)
{
  if ($mName == ' ' || $mName =='') {
    $combinedName = ucfirst($lName) . ", " . ucfirst($fName);
  }
  else{
    $mInitial = substr($mName, 0,1);
    $combinedName = ucfirst(strtolower($lName)) . ", " . ucfirst(strtolower($fName)) .' '. ucfirst(strtolower($mInitial)) . '.';
  }

  return $combinedName;
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return $string; // Removes special chars.
}

function obfuscate_email($email)
  {    
      $em   = explode("@",$email);
      $name = implode(array_slice($em, 0, count($em)-1), '@');
      $len  = floor(strlen($name)/2);

      return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
  }

function generateNumericOTP($n) { 
      
    $generator = "1357902468ABCDEFGHIJKLMOPWXYZ"; 
  
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
   
    return $result; 
} 

function generateStudentCode() { 
      
    $generator = "1357902468"; 
    $n = rand(1,7);
  
    $result = "Student-"; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
   
    return $result; 
} 
  

?>

