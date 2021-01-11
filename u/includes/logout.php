<?php 
session_start();
$levelCheck = $_SESSION['usertype'];

 //if ($levelCheck == 'P') {
 if (true) {
      session_destroy();
      header('Location: ../../index.php?SessionExpired');
      exit();
  } else {
    session_destroy();
    header('Location: ../../login.php?SessionExpired');
    exit();
  }

?>