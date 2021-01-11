<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendEmail($subject,$message,$recipient,$email)
{
	try{

		// Load Composer's autoloader
		require '../vendor/autoload.php';
		require 'PHPMailerAutoload.php';
		require 'credentials.php';
	
		$mail = new PHPMailer(true);
	
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
		//Server settings
		$mail->SMTPDebug = 2;
    	//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    	$mail->isSMTP();   							 // Send using SMTP
		$mail->isHTML(true); 
    	$mail->Host       = eHOST;                    // Set the SMTP server to send through
    	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    	$mail->Username   = uEMAIL;                     // SMTP username
    	$mail->Password   = ePASSWORD;                               // SMTP password
    	//$mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    	$mail->Port       = ePORT;                                    // TCP port to connect to
    	//Recipients
    	$mail->setFrom(uEMAIL, 'PPH');
	
    	$mail->addAddress($email,$recipient);     // Add a recipient
	
    	$mail->Subject = $subject;
    	$mail->Body    = $message;
    	$mail->AltBody = $message;
	
    	$mail->send();
    	echo "1";

    }

    catch (Exception $e) {
    	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

}

sendEmail("hello world sub","hello world","me","alih.addang@phoenix.com.ph");

?>