<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../PHPMailerAutoload.php';




//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "dedrelay.secureserver.net";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = false;
//Username to use for SMTP authentication
$mail->Username = "info@oceanone.in";
//Password to use for SMTP authentication
$mail->Password = "waakan@2015";
//Set who the message is to be sent from
$mail->setFrom('info@oceanone.in', 'Debt Compare');
//Set an alternative reply-to address
$mail->addReplyTo('info@oceanone.in', 'Sudhir Pawar');
//Set who the message is to be sent to

$mail->addAddress('alkeshrtripathi@gmail.com', 'Alkesh Tripathi');
$mail->addAddress('sdhr_pwar@yahoo.co.in', 'sudhir pawar');
$mail->addAddress('sudhir.pawar@waakan.com', 'sudhir pawar');
//Set the subject line
$mail->Subject = 'Debt Compare';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->AddEmbeddedImage("bg.jpg", "my-attach", "bg.jpg");
$mail->Body = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Debt Compare | Home</title>
	
</head>


<body>
<table width="960" height="1300" background="cid:my-attach">
<tr>
<td></td>
<td valign="top"  style="padding-top:280px;">
<table ><tr>
<td>
<form action="http://debtcompare.flg360.co.uk/api/APIHTTPPost.php" method="post" onsubmit="javascript:return fncValidateForm(this);" >

	<input type="hidden" name="intLeadGroupID" value="47899"><input type="hidden" name="strSource" value=""><input type="hidden" name="strMedium" value=""><input type="hidden" name="strTerm" value=""><input type="hidden" name="intSiteID" value="0"><input type="hidden" name="intReferrerBuyerID" value="44667"><input type="hidden" name="strAPISuccessURL" value="http://debtcompare.co.uk/Confirmation/"><input type="hidden" name="strAPIFailURL" value=""><label for="strLeadFirstName" style="display:block; margin-bottom:5px;margin-left:670px;width:206px;">First Name:</label>
	<input type="text" name="strLeadFirstName" id="strLeadFirstName" value="" style="display:block; margin-bottom:5px;margin-left:670px;display:inline-block;height:20px;padding:4px 6px;margin-bottom:10px;font-size:14px;line-height:20px;color:#555;vertical-align:middle;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;width:206px;"><label for="strLeadLastName"  style="display:block; margin-bottom:5px;margin-left:670px;width:206px;">Last Name:</label>
	<input type="text" name="strLeadLastName" id="strLeadLastName" value="" style="display:block; margin-bottom:5px;display:inline-block;height:20px;padding:4px 6px;margin-bottom:10px;font-size:14px;line-height:20px;color:#555;vertical-align:middle;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;width:206px;margin-left:670px;" />
    <label for="strLeadPhone1" style="display:block; margin-bottom:5px;margin-left:670px;width:206px;">Phone Number:</label>
	<input type="text" name="strLeadPhone1" id="strLeadPhone1" value=""
    style="display:block; margin-bottom:5px;display:inline-block;height:20px;padding:4px 6px;margin-bottom:10px;font-size:14px;line-height:20px;color:#555;vertical-align:middle;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;width:206px;margin-left:670px;" /><label for="strLeadEmail" style="display:block; margin-bottom:5px;display:block; margin-bottom:5px;margin-left:670px;width:206px;">Email:</label>
	<input type="text" name="strLeadEmail" id="strLeadEmail" value="" style="display:block; margin-bottom:5px;display:block;margin-left:670px;width:206px;"><label for="strLeadData2" style="display:block; margin-bottom:5px;margin-left:670px;width:206px;">Number of Creditors:</label>
	<input type="text" name="strLeadData2" id="strLeadData2" value=""  style="display:block; margin-bottom:5px;display:inline-block;height:20px;padding:4px 6px;margin-bottom:10px;font-size:14px;line-height:20px;color:#555;vertical-align:middle;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;margin-left:670px;width:206px;" />
    <label for="strLeadData3" style="display:block; margin-bottom:5px;margin-left:670px;width:206px;">Unsecured Debt Amount (£):</label>
	<input type="text" name="strLeadData3" id="strLeadData3" value="" style="display:block; margin-bottom:5px;display:inline-block;height:20px;padding:4px 6px;margin-bottom:10px;font-size:14px;line-height:20px;color:#555;vertical-align:middle;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;width:206px;margin-left:670px;"><input type="submit" name="submit" value="Submit" style=" margin-bottom:5px;margin-left:670px;width:auto; font-size:16px; "></form></td></tr></table>
    </td></tr></table>
    </body>
</html>';

//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'visit website http://www.debtcompare.co.uk/';
//Attach an image file
//$mail->addAttachment('bg.jpg');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
