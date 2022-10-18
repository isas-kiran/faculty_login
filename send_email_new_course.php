
<?php
require 'PHPMailer-5.2.14/class.phpmailer.php';

	//$email_id='waghshital.12@gmail.com';
	//$subject='Hi this is test smtp mail';
	
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
		
		$mail->setFrom('ajaymahadik60@gmail.com', 'ajaymahadik60@gmail.com');     //Set who the message is to be sent from
		//$mail->addReplyTo('waghshital.12@gmail.com', 'First Last');  //Set an alternative reply-to address
		
		if($_POST['action']=='inquiry')
		{
		
		$message= '
                    <table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['firstname'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Name</b></td>
                    <td width="85%" align="left">'.$_POST['firstname'].'<br></td>
                    </tr>';
					}
					if($_POST['middlename'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Middle Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['middlename'].'</font><br></td>
                    </tr>';
					}
					if($_POST['lastname'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Last Name </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['lastname'].'</font><br></td>
                    </tr>';
					}
					if($_POST['mobile1'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Mobile1</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['mobile1'].'</font><br></td>
                    </tr>';
					}
					if($_POST['email_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Email id</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['email_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['inquiry_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Inquiry Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['inquiry_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['lead_category'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Lead Category</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['lead_category'].'</font><br></td>
                    </tr>';
					}
					if($_POST['lead_category_followup'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Lead Category FollowUp</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['lead_category_followup'].'</font><br></td>
                    </tr>';
					}
					if($_POST['lead_grade'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Lead Grade</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['lead_grade'].'</font><br></td>
                    </tr>';
					}
					if($_POST['dob'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Date Of Birth</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['dob'].'</font><br></td>
                    </tr>';
					}
					if($_POST['maritalstatus'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>MaritalStatus</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['maritalstatus'].'</font><br></td>
                    </tr>';
					}
					if($_POST['address'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Address</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['address'].'</font><br></td>
                    </tr>';
					}
					if($_POST['mobile2'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Mobile2</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['mobile2'].'</font><br></td>
                    </tr>';
					}
					if($_POST['landline_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Landline_No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['landline_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['education'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Education</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['education'].'</font><br></td>
                    </tr>';
					}
					if($_POST['course_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Course</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['course_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['duration_studies'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Duration Studies</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['duration_studies'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['enquiry_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Enquiry Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['enquiry_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remark'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remark</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remark'].'</font><br></td>
                    </tr>';
					}
					if($_POST['enquiry_taken'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Enquiry Taken</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['enquiry_taken'].'</font><br></td>
                    </tr>';
					}
					if($_POST['inquiry_for'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Inquiry For</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['inquiry_for'].'</font><br></td>
                    </tr>';
					}
					if($_POST['followup_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['followup_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['branch_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Branch Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['branch_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['batch'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Batch</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['batch'].'</font><br></td>
                    </tr>';
					}
					if($_POST['response'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>response: </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['response'].'</font><br></td>
                    </tr>';
					}
					if($_POST['followup_desc'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['followup_desc'].'</font><br></td>
                    </tr>';
					}
					  $message.='<tr></tr></table>';
		}
		
		
		
		
		
		if($_POST['action']=='add_new_course')
		{
		
		$message= '
                    <table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Name</b></td>
                    <td width="85%" align="left">'.$_POST['name'].'<br></td>
                    </tr>';
					}
					if($_POST['username'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Middle Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['username'].'</font><br></td>
                    </tr>';
					}
					if($_POST['dob'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Last Name </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['dob'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['address'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Email id</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['address'].'</font><br></td>
                    </tr>';
					}
					if($_POST['contact'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Inquiry Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['contact'].'</font><br></td>
                    </tr>';
					}
					if($_POST['mail'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Lead Category</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['mail'].'</font><br></td>
                    </tr>';
					}
					if($_POST['qualification'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Lead Category FollowUp</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['qualification'].'</font><br></td>
                    </tr>';
					}
					if($_POST['photo'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Lead Grade</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['photo'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['paid_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>MaritalStatus</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['paid_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['source'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Address</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['source'].'</font><br></td>
                    </tr>';
					}
					if($_POST['admission_remark'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Mobile2</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_remark'].'</font><br></td>
                    </tr>';
					}
					if($_POST['course_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Landline_No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['course_id'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['admission_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Course</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['costomize_courses'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Duration Studies</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['costomize_courses'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_coupon'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Enquiry Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_coupon'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_coupon_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remark</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_coupon_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['concession'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Enquiry Taken</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['concession'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Inquiry For</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment'].'</font><br></td>
                    </tr>';
					}
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Branch Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Batch</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>response: </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['installment_on'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['installment_on'].'</font><br></td>
                    </tr>';
					}
					if($_POST['net_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['net_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment_wo_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_wo_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['first_installment'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['first_installment'].'</font><br></td>
                    </tr>';
					}
					if($_POST['branch_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['branch_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['final_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Followup Desc</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					
					
					  $message.='<tr></tr></table>';
		}
		
		
		$sendMessage=$GLOBALS['box_message_top'];
		$sendMessage.=$message;
		$sendMessage.=$GLOBALS['box_message_bottom'];
			//$sendMessage="Its kiran vyavahare";
		 $mail->addAddress('ajaymahadik60@gmail.com'); 
		 //$mail->addBCC($_POST['inqyiry_idss']); 
		 $mail->WordWrap = 1000; 
		 
		 $mail->isHTML(true);                                  // Set email format to HTML
 
		 $mail->Subject = 'Enquiry from';
		 $mail->Body    = $sendMessage;
		 
	
	$mail->Send();
  echo "Message Sent OK\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
	?>
	