<?php
function normalizeString ($str = '')
{
    $str = strip_tags($str); 
    $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
    $str = strtolower($str);
    $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
    $str = htmlentities($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '-', $str);
    $str = rawurlencode($str);
    $str = str_replace('%', '-', $str);
    return $str;
}

function removeSubSur($filename)
{
  if(strpos($filename, '_') !== false){
    $string = explode('_', $filename);
    array_pop($string);
    return  implode('_', $string).'.pdf';
  }
  else{
    return $filename;
  }
}
function countDigits( $str )
{
    return preg_match_all( "/[0-9]/", $str );
}

function countSpecialCharacter( $str )
{
    return $count = preg_match_all('@[^\w]@', $str);
}

function countUpperCase($str) {
  return strlen(preg_replace('![^A-Z]+!', '', $str));
}

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

