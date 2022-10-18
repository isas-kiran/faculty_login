<?php 
error_reporting(E_ALL); 
ini_set("display_errors", 1);
include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Mail</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<body>
<?php
				
	/*------------send a mail to admin about this---------------------*/
	//===================================================================================//21-12-17
	$mail = new PHPMailer(true);
	//try {
			$mail->IsSMTP();                                      // Set mailer to use SMTP
			$mail->SMTPDebug=2;   
			$mail->Host = 'relay-hosting.secureserver.net';                       // Specify main and backup server
			$mail->SMTPAuth = false;                               // Enable SMTP authentication
			                         // SMTP password
			$mail->SMTPSecure = 'None';                            // Enable encryption, 'tls' also accepted
			$mail->Port = 25;
			$mail->setFrom('info@isasbeautyschool.com', 'ISAS TESTING');
			$mail->addAddress("erp.isas@gmail.com"); 
			$mail->isHTML(true);
			$mail->Charset = 'UTF-8';
			
			$mail->Subject = 'Mail Testing - '.$date.'';
			
			$sendMessage=$GLOBALS['box_message_top'];
			$sendMessage.=$message;
			$sendMessage.=$GLOBALS['box_message_bottom'];
			
			$mail->WordWrap = 3000; 
			$mail->isHTML(true);                                  
			$mail->Body    = $sendMessage;
			
			 
			if($mail->Send()) {
			   echo "Email Sent Successfully.";
			} else {
				$arrResult['response'] = 'error';
				echo "There was a problem sending the form.: " . $mail->ErrorInfo;
				exit;
			}
			
		/*} catch (phpmailerException $e) {
		echo $e->errorMessage(); 
	} catch (Exception $e) {
	echo $e->getMessage(); 
}	*/
//=========================================================================================================	
				?>
</body>
</html>