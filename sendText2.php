<?php 

function sendOTP($message, $number)
{
  $secretKey = '002eab2e09373b05d0ce52d014363379';
  $UserID ='30';
  $Mobile =$number;
  $hash = md5($Mobile.$secretKey);
  //$message = urlencode($message);
//$url= "http://phoenix.net.ph:8088//infotxt/webservice.asp?UserID=$UserID&Hash=$hash&Mobile=$Mobile&SMS=$newmessage";

//global
$url = "https://www.phoenix.net.ph:458/infotxt/webservice.asp";

//local
// $url = "http://192.168.0.212:8088//infotxt/webservice.asp";


$data = array('mobile' => $Mobile, 'sms' => $message);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result == FALSE) { /* Handle error */ }

$someObject = json_decode($result, true);
 return $someObject['status'];
}

?>