<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php //include 'inc_classes1.php'; ?>
<?php //require "PHPMailer-5.2.14/class.phpmailer.php"; ?>

<body>

<?php
									/*	$select_email_id = " select * from  inquiry where firstname='".$_POST['firstname']."' and middlename='".$_POST['middlename']."' and lastname='".$_POST['lastname']."' and mobile1='".$_POST['mobile1']."' and email_id='".$_POST['email_id']."'  ";
											$ptr_emails = mysql_query($select_email_id);*/
											
												 
									//---------Send Message-------------
								echo	$mesg ="Hi ".$_POST['firstname']." ".$_POST['lastname'].".";
									
									
									"<br/>".$messagessss =$mesg. "Thanks for Enquiry";
									//send_sms_function($mobile1,$messagessss);
									//-------------------------------------
									//------send notification on inquiry addition-----
									/*$notification_args['reference_id'] = $inqyiry_id;
									$notification_args['on_action'] = 'enquiry_added';
									$notification_status = addNotifications($notification_args);*/
									//-----------------------------------------------

									/*------------send a mail to admin about this---------------------*/
									$subject = "Enquiry from ".$_POST['firstname'].' '.$_POST['lastname']." on ".$GLOBALS['domainName']."";
									$message .= '
									<table cellpadding="3" align="left" cellspacing="3" width="75%">
									 <tr>
										<td width="35%"><strong>Firstname</strong></td>
										<td>:</td>
										<td width="65%">'.$_POST['firstname'].'</td>
									</tr>';
									
									$message.= '
								   
									<tr>
										<td width="35%"><strong>Middlename</strong></td>
										<td>:</td>
										<td width="65%">'.$_POST['middlename'].'</td>
									</tr>';
								   
									 
									$message.= '
									
									<tr>
										<td width="35%"><strong>Lastname</strong></td>
										<td>:</td>
										<td width="65%">'.$_POST['lastname'].'</td>
									</tr>';
									
									
									if($mobile1)
									$message.= '
									<tr>
										<td><strong>Mobile1</strong></td>
										<td>:</td>
										<td>'.$_POST['mobile1'].'</td>
									</tr>';
									
									if($email_id)
									$message.= '
									<tr>
										<td><strong>Email</strong></td>
										<td>:</td>
										<td>'.$_POST['email_id'].'</td>
									</tr>';
									
									$message.='<tr><td>Enquiry form filled from  </td><td>:</td><td>Admin Panel(Offline)<td></tr>
									</table>';
												
									$sendMessage=$GLOBALS['box_message_top'];
									$sendMessage.=$message;
									$sendMessage.=$GLOBALS['box_message_bottom'];
									$from_id='support<support@'.$GLOBALS['siteUrlName'].'>';
									$headers= 'MIME-Version: 1.0' . "\n";
									$headers.='Content-type: text/html; charset=utf-8' . "\n";
									$headers.='From:'.$from_id;
								$subject="ghgfhgfhf";
								$headers="jiyuiyuiuuyiuiuyiuyi";
											if(mail($_POST['email_id'], $subject, $sendMessage, $headers))
											{
												echo 'sent';	
											}
											else
											{
												echo "hello its";
											}
											 /*$select_email_id = " select email from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and (type='A' or type='C' or type='B') and email !='' ";
											$ptr_emails = mysql_query($select_email_id);
											while($data_emails = mysql_fetch_array($ptr_emails))
											{
												/*$mail->addAddress($data_emails['email']); 
												$mail->WordWrap = 50;
												$mail->isHTML(true); 
												 
												$mail->Subject = $subject;
												$mail->Body    = $sendMessage;
												
												if($mail->send())
												{
													echo '<br/>email sent to '.$data_emails['email'].'';	
												}
												else
												{ 
													
												}
												mail($data_emails['email'], $subject, $sendMessage, $headers);
												
											}
											/*"<br/>".$select_id="select module_type_id,sms_text from module_types where module_type ='Enquiry'";
											$ptr_sel=mysql_query($select_id);
											if(mysql_num_rows($ptr_sel))
											{
												$data_module=mysql_fetch_array($ptr_sel);
												$select_email_id = "select module_type_id,id from sms_mail_configuration_map where id !='".$data_module['module_type_id']."' ";
												$ptr_emails = mysql_query($select_email_id);
												while($data_emails = mysql_fetch_array($ptr_emails))
												{
													echo"<br/>".$sel_mail="select email_id from sms_mail_configuration where id='".$data_emails['id']."' and status='active' ".$_SESSION['where']."";
													$ptr_mail_id=mysql_query($sel_mail);
													$data_mail_ids=mysql_fetch_array($ptr_mail_id);
													
													mail($data_mail_ids['email_id'], $subject, $sendMessage, $headers);
													/*$mail->addAddress($data_mail_ids['email_id']); 
													$mail->WordWrap = 50;
													$mail->isHTML(true); 
													 
													$mail->Subject = $subject;
													$mail->Body    = $sendMessage;
													
													if($mail->send())
													{
														echo '<br/>email sent to '.$data_mail_ids['email_id'].'';	
													}
													else
													{ 
														echo '<br/>Error in sending email ';
													}*/
													
											
											
											//mail($data_emails['email'], $subject, $sendMessage, $headers);
											
											//==================== EMAIL to councellor======================================
											/*echo $select_counc_email_id = " select email from site_setting where cm_id='".$_SESSION['cm_id']."' and type='C' and email !='' ";
											$ptr_counc_emails = mysql_query($select_counc_email_id);
											while($data_counc_emails = mysql_fetch_array($ptr_counc_emails))
											{
												mail($data_counc_emails['email_id'], $subject, $sendMessage, $headers);
											}*/
											//==============================================================================
									//}
									?>
</body>
</html>