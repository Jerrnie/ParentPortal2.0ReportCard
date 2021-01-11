<?php 

// $amount = '10.00';
// if (($pos = strpos($amount, ".")) !== FALSE) { 
//   $whatIWant = substr($amount, $pos +1);    


//     if (strlen(trim($whatIWant))!=2) {
//       echo "invalid deci";
//     }

//     $arr = explode(".", $amount, 2);
//   $first = $arr[0];
//   echo "$first";
//     if ($first<0) {
//       echo "amount too low";
//     }
// }
// else{
//   echo "no deci";
// }
//0------------------------------------
//     $orgDate = "2020-01-01 10:20:30";  
//     $newDate = date("F d, Y", strtotime($orgDate));  
//     echo "New date format is: ".$newDate. " (F d, Y)";  
//     $deadline = date('m/d/Y', strtotime($newDate));


//     function validateDate($date, $format = 'M d, Y',$format2 = 'F d, Y',$format3 = 'm/d/Y')
// {

// 	$f = DateTime::createFromFormat($format3, $date);
// 	if (($f && $f->format($format3) === $date)) {
// 		return true;
// 	}
// 	else if (strpos($date, ',')===false) {
// 		return false;
// 	}
// 	else{
// 		$whatIWant = substr($date, strpos($date, ",")  -2,2);    
// 		if (strlen(trim($whatIWant))<2) {
// 			$date = substr_replace($date, "0", strpos($date, ",")-1,0);
// 		}
// 		    $d = DateTime::createFromFormat($format, $date);
//     $e = DateTime::createFromFormat($format2, $date);
//     // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
//     return ($d && $d->format($format) === $date) || ($e && $e->format($format2) === $date);
// 	}

// }

// if (validateDate('01/01/2020')) {
// 	echo "true";
// }
// else{
// 	echo "false";
// }


// echo "<br>". $deadline . " == 01/01/2020
// <br>";
//---------------------------------------------
// //
// if (validateDate("01/01/2020")) {
// 	echo "true";
// }
// else{
// 	echo "false";
// }

// function validateDate($date, $format = 'M d, Y',$format2 = 'F d, Y',$format3 = 'm/d/Y')
// {
// 	$f = DateTime::createFromFormat($format3, $date);
// 	if (($f && $f->format($format3) === $date)) {
// 		return true;
// 	}
// 	else if (strpos($date, ',')===false) {
// 		return false;
// 	}
// 	else{
// 		$whatIWant = substr($date, strpos($date, ",")  -2,2);    
// 		if (strlen(trim($whatIWant))<2) {
// 			$date = substr_replace($date, "0", strpos($date, ",")-1,0);
// 		}
// 		    $d = DateTime::createFromFormat($format, $date);
//     $e = DateTime::createFromFormat($format2, $date);
//     // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
//     return ($d && $d->format($format) === $date) || ($e && $e->format($format2) === $date);
// 	}

// }
//------------------
// $amount = "100";

// if (($pos = strpos($amount, ".")) !== FALSE) { 
//     $arr = explode(".", $amount, 2);
//   $first = $arr[0];
//   $whatIWant = substr($amount, $pos +1);  

//     if (strlen(trim($whatIWant))!=2) {
//       echo "wrong decimal";
//     }


//     if ($first<0) {
//       echo "walang value";
//     }
// }
// else{
//   $amount .=".00";
//   $arr2 = explode(".", $amount, 2);
//   $first2 = $arr2[0];
//   $pos = strpos($amount, ".");
//   $whatIWant2 = substr($amount, $pos +1);  
//   echo "$whatIWant2<br>";
//     if (strlen(trim($whatIWant2))!=2) {
//      echo "wrong decimal2";
//     }


//     if ($first2<0) {
//       echo "walang value2";
//     }
// }

// if (($pos = strpos($amount, ".")) !== FALSE) { 
//     $arr = explode(".", $amount, 2);
//   $first = $arr[0];
//   $whatIWant = substr($amount, $pos +1);  

//     if (strlen(trim($whatIWant))!=2) {
// echo "wrong decimal";
//     }


//     if ($first<0) {
// echo "walang value";
//     }
// }
// else{
//   $amount .=".00";
//     $arr = explode(".", $amount, 2);
//   $first = $arr[0];
//   $pos = strpos($amount, ".");
//   $whatIWant = substr($amount, $pos +1);  

//     if (strlen(trim($whatIWant))!=2) {
// echo "wrong decimal2";
//     }


//     if ($first<0) {
// echo "walang value2";
//     }
// }\
// 
// echo floor(2036 / 60)  ;
// echo "<bR>";
// echo 820 % 60;

// function removeSubSur($filename)
// {
// 	$string = explode('_', $filename);
// 	array_pop($string);
// 	return  implode('_', $string);

// }

// echo removeSubSur("StudentCode");


require '../assets/phpfunctions.php';
require '../include/config.php';


$dir = "RC/";

$filename = normalizeString('asdsadsd/asdasd.pdf');
$file = $dir. $filename ;

echo "$file";

?>
<!-- ($d && $d->format($format3) === $date) -->