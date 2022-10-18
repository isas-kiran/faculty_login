<?php require 'PHPMailer-5.2.14/class.phpmailer.php';

$mail = new PHPMailer(true);
						try {
								//$mail->IsSMTP();                                      // Set mailer to use SMTP
								$mail->SMTPDebug=1;   
								$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
								$mail->SMTPAuth = true;                               // Enable SMTP authentication
								$mail->Username = 'ajaymahadik60@gmail.com';                   // SMTP username
								$mail->Password = '9975988948';                            // SMTP password
								$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
								$mail->Port = 465;
								
								$mail->setFrom('erp.isas@gmail.com', 'ISAS');
								
								$mail->addAddress("vyavaharekiran@gmail.com"); 
								
								/*$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='103'";
								$ptr_sel_sms=mysql_query($sel_sms_cnt);
								$tot_num_rows=mysql_num_rows($ptr_sel_sms);
								$i=0;
								while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
								{
									"<br/>".$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ";
									$ptr_cnt=mysql_query($sel_act);
									if(mysql_num_rows($ptr_cnt))
									{
										$data_cnt=mysql_fetch_array($ptr_cnt);
										"<br/> 1st mail-  ".$emailss=$data_cnt['email'];
										$mail->addCC("$emailss"); 
										
										$i++;
									}
								}
								if($_SESSION['type']!='S')
								{
									"<br/>".$sel_act="select contact_phone,email from site_setting where type='S'";
									$ptr_cnt=mysql_query($sel_act);
									if(mysql_num_rows($ptr_cnt))
									{
										$j=$tot_num_rows;
										while($data_cnt=mysql_fetch_array($ptr_cnt))
										{
											"<br/> 2nd mail-  ".$data_cnt['email'];
											?>
											<!--mail[<?php ///echo $j; ?>]='<?php //echo  $data_cnt['email'];?>';-->
											<?php
											$j++;
										}
									}
								}*/
								///usr/local/bin/php -q /home/isasadmin007/isastest/faculty_login/dsr_mail.php?&send_mail=mail
								///bin/touch /home/isasadmin007/public_html/cron_test.txt >/dev/null 2>&1 && /bin/echo "Cron ran at: `date`" >> /home/isasadmin007/public_html/cron_test.txt
								$mail->Subject = 'DSR Test report on- '.date('d/m/Y').'';
								
								$sendMessage="Hi ";
								$sendMessage.="kiran. how are you ";
								//$sendMessage.=$GLOBALS['box_message_bottom'];
								
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
?>