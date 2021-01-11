<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
// Load Composer's autoloader
require '../vendor/autoload.php';
require 'PHPMailerAutoload.php';
require 'credentials.php';
require 'htmlEmailTemplate.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = uEMAIL;                     // SMTP username
    $mail->Password   = ePASSWORD;                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom(uEMAIL, 'PPH');
    $mail->addAddress($_SESSION['userEmail'],$_SESSION['lname']);     // Add a recipient
    //$mail->addReplyTo(uEMAIL);

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('../assets/imgs/pphlogohq.png', 'LOGO.png');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Verification ( OTP )';
    $mail->Body    = $body;
    $mail->AltBody = 'Good day here\'s your Code :'.$_SESSION["token"];

    $mail->send();
    echo 'Message has been sent';
      if (isset($_REQUEST['resendCode'])){
    header('Location: ../verification.php?resendSuccess');
  }
  else{
    header('Location: ../verification.php');
   }

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

