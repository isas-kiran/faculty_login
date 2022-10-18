<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'PHPMailer-master/PHPMailerAutoload.php';



include "waakanadmin/include/config.php";
$daily_quota = 4800;
//mary.morley@nhs.net
$select_in_process_camp = " select campaign_id from campaign where status='In Process'  ";
$ptr_id = mysql_query($select_in_process_camp);
if(mysql_num_rows($ptr_id))
{
	$data_campaign = mysql_fetch_array($ptr_id);
	$select_counter_for_today = " select count(user_id)as total_counter from  user where date(sent_time)='".date('Y-m-d')."' and campaign_id='".$data_campaign['campaign_id']."' ";
	
	$ptr_counter = mysql_query($select_counter_for_today);
	$data_counter = mysql_fetch_array($ptr_counter);
	$total_counter = $data_counter['total_counter'];
	
	if($total_counter<$daily_quota)
	{
	 $select_user = " select user_id, username, email_id from user where campaign_id='".$data_campaign['campaign_id']."' and sent_time='' order by user_id asc  limit 0, 20 ";
	$ptr_user = mysql_query($select_user);
	if(mysql_num_rows($ptr_user))
	{
		while($data_user = mysql_fetch_array($ptr_user))
		{	$email_id=$username=$user_id='';
			$email_id = trim($data_user['email_id']);
			$username = trim($data_user['username']);
			$user_id = $data_user['user_id'];
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
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
$mail->setFrom('info@oceanone.in', 'SeventyPercent Off');
//Set an alternative reply-to address
$mail->addReplyTo('info@oceanone.in', 'SeventyPercent Off');
//Set who the message is to be sent to

//$mail->addAddress('alkeshrtripathi@gmail.com', 'Alkesh Tripathi');
$mail->addAddress($email_id, $username);
//$mail->addAddress('sudhir.pawar@waakan.com', 'sudhir pawar');
//Set the subject line
$mail->Subject = ' Dear '.$username. ' write off up to 70% of your debts';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->AddEmbeddedImage("debt_man.gif", "my-attach", "debt_man.gif");
$mail->Body = 'Dear  ' .$username. ',<br />
if finding issue to open an email please click to visit in new window <a href="http://www.oceanone.in/form.php" target="_blank">Click to open mail </a>
<br /><br />
<form name="register" method="post" action="http://www.oceanone.in/confirm.php"  >
<table style="border: #00F 2px solid; border-radius:5px; background-color:#C6F4F4">
<tr>
<td >
<table>
<tr>
<td rowspan="2">
<img src="www.oceanone.in/debt_man.gif" height="200px" width="200px"  align="left" style="margin-left:70px"/></td>
<td style=" float:left;font-size:93px ;color:#939;  font-family:\'Arial Black\', Gadget, sans-serif"> DEBT</td></tr>
<tr><td  style="float:left;font-size:53px ;color:#0CF; font-family:\'Arial Black\', Gadget, sans-serif">COMPARE</td>
</tr></table></td>
<td>
<table cellspacing="10">
<tr>
<td align="left" style="font-size:24px; color:#93C; font-family:\'Arial Black\', Gadget, sans-serif;">☎ 01434433798
</td></tr>
<tr>
<td style="font-size:24px; color:#93C; font-family:\'Arial Black\', Gadget, sans-serif;">✉<a href="mailto:help@debtcompare.co.uk">help@debtcompare.co.uk</a>
</td></tr>
</table></td></tr>

<tr><td  style=" padding-left:200px; float:left;font-size:19px; color:#939; font-family:\'Arial Black\', Gadget, sans-serif" >The Comparison Specialists</td>

</tr>

      <!--table align="center" border="1" bgcolor="#CCCCCC" bordercolorlight="#FF0000"-->
<tr>
<th style="padding-left:200px;font-size:20px; color:#93C; font-family:\'Arial Black\', Gadget, sans-serif" align="left" >The Right Way To Financial Freedom</th>
<td style="font-size:24px; color:#FA0724;font-family:\'Arial Black\', Gadget, sans-serif">Struggling with debts get <br /> written off upto 70%</td>
<tr>  <td style=" padding-left:200px; font-size:18px; color:#93C;" >✓Try our No Obligation service</td>
      <td style="font-size:24px">First Name:</td>
      <tr><td><td><input type="text"name="firstname" /></td></td></tr>
      

<tr>
      <td style="font-size:18px;color:#93C; padding-left:200px; ">✓ Find the best solution for your debt</td>
       <td style="font-size:24px">Last Name:</td>
      <tr><td><td><input type="text"name="lastname"  /></td></td></tr>
</tr>
<tr>
      <td style="font-size:18px;color:#93C;  padding-left:200px; ">✓ Stop phone calls from creditors</td>
      <td style="font-size:24px">Phone Number:</td>
      <tr><td><td><input type="text" name="mobile"  /></td></td>
</tr>
<tr>
      <td style="font-size:18px;color:#93C;  padding-left:200px; ">✓ Negotiate the freezing of interest & charges</td>
      <td style="font-size:24px">Email:</td>
      <tr><td><td><input type="text" name="email" /></td></td></tr>
</tr>      
<tr>      
      <td style="font-size:18px;color:#93C;  padding-left:200px; ">✓ One low monthly payment you can afford</td>
      <td style="font-size:24px">Number of Creditors:</td></tr>
      <tr><td><td><input type="text" name="credentors" /></td></td></tr>
</tr>
<tr>
      <td style="font-size:18px;color:#93C;  padding-left:200px; ">✓ Manage your financial commitments</td>
      <td style="font-size:24px">Unsecured Debt Amount(£):</td>
      <tr><td><td><input type="text" name="usecure_debt" /></td></td></tr>
</tr>
<tr>      
      <td style=" padding-left:200px; font-size:18px;color:#93C">✓ Compare all options from a DMP** to an IVA***</td>
      <td><input type="submit" name="save" value="submit" onclick="return myfunction()" style="width:200px; font-weight: bold 30px; font-size:18px ; background-color:#C6F; border-radius:10px;" /></td>
</tr>

</table>
</form><br/><br />
Unsubscribe to this e-mail, please <a href="http://oceanone.in/unsubscribe.php?email_id='.$email_id.'&campaign_id='.$data_campaign['campaign_id'].'">click here.</a><br />
  ';

//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'visit website http://www.oceanone.in/form.php';
//Attach an image file


//send the message, check for errors
			if (!$mail->send()) {
				echo "<br />Mailer Error: " . $mail->ErrorInfo;
				$insert_error = " insert into error_in_mail(email_id, 	user_id,campaign_id	,added_date , error_desc ) values('$email_id','$user_id','".$data_campaign['campaign_id']."', '".date('Y-m-d H:i:s')."', '".$mail->ErrorInfo."'  )";
				$ptr_insert_error = mysql_query($insert_error);
			} else {
				echo "<br />Message sent to $user_id ->$email_id";
			}
			
			$update_query = " update user set sent_time='".date('Y-m-d H:i:s')."', status ='Sent' where user_id='$user_id' ";
			$ptr_update = mysql_query($update_query);
		}
	}
	}
	else
	{
		echo "Todays quota is full. total email sent ->".$total_counter;
	}
}
if($total_counter<$daily_quota)
	{
?>

<script language="javascript">
				setTimeout('document.location.href=document.location.href;',30000);
				</script>
    <?php } ?>