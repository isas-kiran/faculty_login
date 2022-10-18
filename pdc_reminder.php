<?php include 'inc_classes.php';?>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<?php
$todays_date=date('Y-m-d');
$prv_date =date('Y-m-d', strtotime('+4 day', strtotime($todays_date)));
$newdate =date('d-M-Y', strtotime($prv_date));

$sel_cm="select DISTINCT(cm_id) from site_setting where type='A' and system_status='Enabled' ";
$ptr_cm=mysql_query($sel_cm);
while($data_cm=mysql_fetch_array($ptr_cm))
{
	$select_inst="select enroll_id,installment_amount,cm_id from installment where installment_date='".$prv_date."' and cm_id='".$data_cm['cm_id']."' ";
	$ptr_inst=mysql_query($select_inst);
	if(mysql_num_rows($ptr_inst))
	{
		while($data_inst=mysql_fetch_array($ptr_inst))
		{
			$mail_s = array();
			$contact= array();
			$desc="Installment reminder";
			$cm_id=$data_inst['cm_id'];

			$select_mobno="select name,contact,course_id,assigned_to,mail,cm_id from enrollment where enroll_id='".$data_inst['enroll_id']."' ";
			$ptr_mob = mysql_query($select_mobno);
			$data_mob = mysql_fetch_array($ptr_mob);

			$name=$data_mob['name'];
			$contact_no=$data_mob['contact'];
			$stud_mail=$data_mob['mail'];

			$sel_course="select course_name from courses where course_id='".$data_mob['course_id']."'";
			$ptr_course=mysql_query($sel_course);
			$data_course=mysql_fetch_array($ptr_course);

			$sel_mail="select contact_phone,email,cm_id,name from site_setting where admin_id='".$data_mob['assigned_to']."'  ";
			$ptr_mail=mysql_query($sel_mail);
			$data_mail=mysql_fetch_array($ptr_mail);

			$mail_s[0]= $data_mail['email'];
			$contact[0]= $data_mail['contact_phone'];
			$councillor_name=$data_mail['name'];

			$sel_cm="select contact_phone,email,cm_id from site_setting where 1 and ((cm_id='".$data_mob['cm_id']."' and type='A' )  or type='Z' or type='S') and system_status='Enabled' ";
			$ptr_cm=mysql_query($sel_cm);
			$i=1;
			while($data_cm=mysql_fetch_array($ptr_cm))
			{
				$mail_s[$i]= $data_cm['email'];
				$contact[$i]= $data_cm['contact_phone'];
				$i++;
			}
			
			echo "<br/>".$mesg_faculty=" Hello,<br/></br/>This is inform to you, <b>".$name."</b> has PDC cheque submission on <b>".$newdate."</b> as amount of <b>".$data_inst['installment_amount']."</b> for course ".$data_course['course_name'].". Please contact and confirm the same.<br/> <b>Councillor Name: ".$councillor_name."</b> ";

			$message =$mesg_faculty;
			
			//==================================Staf Reminder========================================
			
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
					//$mail->addAddress("erp.isas@gmail.com"); 
					
					$total_cnt= count($mail_s);
					for($i=0;$i<$total_cnt;$i++)
					{
						if($i==0){
							$mail->addAddress("$mail_s[$i]");
						}else
						{
							$mail->addCC("$mail_s[$i]");
						}
					}
					
					$mail->Subject = 'ISAS - PDC Cheque Reminder for '.$name.' ';
					
					$sendMessage=$GLOBALS['box_message_top'];
					$sendMessage.=$message;
					$sendMessage.=$GLOBALS['box_message_bottom'];
					
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
			//================================================================================
		}
	}
}
?>