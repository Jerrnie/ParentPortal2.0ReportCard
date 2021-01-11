<?php
session_start();
$minutes = 90;
$secondsBeforeWarning = 30;
$secondsWarningLast =30;

$mSecondsWarningLast = ($secondsWarningLast * 1000)+2000;
$passedSeconds = time() - $_SESSION['last-time-stamp'];

$minutesInSeconds = $minutes * 60;


  if ($passedSeconds > $minutesInSeconds-$secondsBeforeWarning&&$passedSeconds<$minutesInSeconds) {
    echo json_encode(array(2,$mSecondsWarningLast));
  }
  elseif ($passedSeconds >= $minutesInSeconds) {
  	session_destroy();
  	echo json_encode(array(1,$mSecondsWarningLast));
  }
  else{
  	echo json_encode(array(0,$mSecondsWarningLast));
  }


?>
