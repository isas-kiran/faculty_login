<?php 
error_reporting(E_ALL); 
ini_set("display_errors", 1);
include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Test Mail</title>
<link href="css/style.css" rel="stylesheet" type="text/css" /> 
</head>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<body>
<?php
	/*------------send a mail to admin about this---------------------*/
	//===================================================================================//21-12-17
	$mail = new PHPMailer(true);
	try {
			//$mail->IsSMTP();                                      // Set mailer to use SMTP
			$mail->SMTPDebug=1;   
			$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'erp.isas@gmail.com';                   // SMTP username
			$mail->Password = 'erp@frespa';                            // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
			$mail->Port = 465;
			$mail->setFrom('info@isasbeautyschool.com', 'ISAS');
			$mail->addAddress("erp.isas@gmail.com"); 
			
			/*$mail->SMTPDebug=1;   
			$mail->Host = 'mail.google.com';                       // Specify main and backup server
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'erp.isas@gmail.com';                   // SMTP username
			$mail->Password = 'erp@frespa';                            // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
			$mail->Port = 587;
			
			$mail->DKIM_domain = 'isasbeautyschool.com';
            $mail->DKIM_private = 'email_private_key.txt';
            $mail->DKIM_selector = 'phpmailer';
            $mail->DKIM_passphrase = ''; //key is not encrypted
            
			$mail->setFrom('info@isasbeautyschool.com', 'ISAS');
			$mail->addAddress("erp.isas@gmail.com"); */
			
			///usr/local/bin/php -q /home/isasadmin007/isastest/faculty_login/dsr_mail.php?&send_mail=mail
			///bin/touch /home/isasadmin007/public_html/cron_test.txt >/dev/null 2>&1 && /bin/echo "Cron ran at: `date`" >> /home/isasadmin007/public_html/cron_test.txt
			$mail->Subject = 'Test Mail - '.$date.'';
			

			$message='
				<table style="max-width:600px;min-width:280px;border:1px solid #cccccc" cellspacing="0" cellpadding="0" border="0" align="center">
					<tbody>
						<tr>
							<td height="20"></td>
						</tr>
						<tr>
							<td style="border-bottom:3px solid #a50d0d" height="36" bgcolor="#e21212" align="center">Click Here </td>
						<tr>
							<td height="20"></td>
						</tr>
					</tbody>
				</table>';
			$sendMessage=$message;
				//width=900,height=600,
			$mail->WordWrap = 3000; 
			$mail->isHTML(true);                                  
			$mail->Body    = $sendMessage;
			 
			$mail->Send();
			echo "Email Sent Successfully.";
		} catch (phpmailerException $e) {
		  echo $e->errorMessage(); 
		} catch (Exception $e) {
		  echo $e->getMessage(); 
		}	
//=========================================================================================================	
				?>
</body>
</html>