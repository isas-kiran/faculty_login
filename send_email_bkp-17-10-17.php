<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
?>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php';

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
		
		$mail->setFrom('info@ISAS-pune.com', 'ISAS');     //Set who the message is to be sent from
		//$mail->addReplyTo('waghshital.12@gmail.com', 'First Last');  //Set an alternative reply-to address
		
		if($_POST['action']=='inquiry')
		{
			//$inq_mail=$_POST['email_id'];
			//$mail->addAddress("$inq_mail"); 
			$users_mail=explode(',',$_POST['users_mail']);
			for($i=0;$i<count($users_mail);$i++)
			{
				$emails=$users_mail[$i];
				$mail->addCC("$emails"); 
			}
			$email_text_msg=$_POST['email_text_msg'];
			 //$mail->addBCC($_POST['inqyiry_idss']); 
			$mail->Subject = 'Enquiry from '. $_POST['firstname'].' '.$_POST['lastname'];
			$message.=urldecode($email_text_msg)."<br/>";
			$message .= '
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
					<td width="15%" align="left"><b>Email Id</b></td>
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
					<td width="15%" align="left"><b>Marital Status</b></td>
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
					<td width="15%" align="left"><b>Landline No</b></td>
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
					<td width="15%" align="left"><b>Response </b></td>
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
			
			$inq_mail=$_POST['mail'];
			$mail->addAddress("$inq_mail"); 
			$users_mail=explode(',',$_POST['users_mail']);
			print_r($users_mail);
			for($i=0;$i<count($users_mail);$i++)
			{
				$emails=$users_mail[$i];
				$mail->addCC("$emails"); 
			}
			
			//$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'New Course '.$_POST['course_id'].' Added for student '. $_POST['name'];
		
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
					if($_POST['dob'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Date Of Birth</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['dob'].'</font><br></td>
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
					if($_POST['contact'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Contact No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['contact'].'</font><br></td>
                    </tr>';
					}
					if($_POST['mail'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Email Id</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['mail'].'</font><br></td>
                    </tr>';
					}
					if($_POST['qualification'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Qualification</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['qualification'].'</font><br></td>
                    </tr>';
					}
					if($_POST['photo'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Photo</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['photo'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['paid_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Paid Type</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['paid_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['source'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Admission Remark</b></td>
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
					<td width="15%" align="left"><b>Course</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['course_id'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['admission_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Admission Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_date'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['total_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Course Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_coupon'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount Coupon Code</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_coupon'].'</font><br></td>
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
					<td width="15%" align="left"><b>Discount In</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment(Including tax)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['installment_on'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Installment On</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['installment_on'].'</font><br></td>
                    </tr>';
					}
					if($_POST['net_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Net Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['net_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['fees'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['down_payment_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Service Tax in Down Payment</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment_wo_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment(Without tax)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_wo_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['dropdown'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Number of Installment</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['dropdown'].'</font><br></td>
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
					<td width="15%" align="left"><b>Total Balance Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					
					
					  $message.='<tr></tr></table>';
		}
		
		
		
		
		if($_POST['action']=='invoice_summary')
		{
			
			//$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Invoice Summary for student '. $_POST['student_name'];
		
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['student_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Student Name</b></td>
                    <td width="85%" align="left">'.$_POST['student_name'].'<br></td>
                    </tr>';
					}
					if($_POST['course_name'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Course Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['course_name'].'</font><br></td>
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
					if($_POST['admission_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Admission Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['enrollment_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Enrollment Id</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['enrollment_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment'].'</font><br></td>
                    </tr>';
					}
					if($_POST['sr_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Sr No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['sr_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['invoice_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice Id</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['balance_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Balance Amt</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['balance_amt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['status'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Status</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['status'].'</font><br></td>
                    </tr>';
					}
					if($_POST['added_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Added Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['added_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['status1'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Status1</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['status1'].'</font><br></td>
                    </tr>';
					}
					
					  $message.='<tr></tr></table>';
		}
		
		
			if($_POST['action']=='add_cust_services')
			{
				$inq_mail=$_POST['mail'];
				$mail->addAddress("$inq_mail");
				$users_mail=explode(',',$_POST['users_mail']);
				print_r($users_mail);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					$mail->addBCC("$emails"); 
				}
				//$mail->addBCC($_POST['mail']); 
				$mail->Subject = 'Customer services added for branch '. $_POST['branch_name'];
		
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr >
					<td  width="15%" align="left"><b>Branch</b></td>
                    <td  width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['realtxt'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Mobile No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['realtxt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['customer_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['customer_id'].'</font><br></td>
                    </tr></table>';
					}
					
					
					if($_POST['total_service'])
					{
					
					$message.= '<table colspan="5" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;">
					<tr>
					
									<td width="15%" align="left"><b>Service Name</b></td>
									<td width="15%" align="left"><b>Price</b></td>
									<td width="15%" align="left"><b>Discount </b></td>
									<td width="15%" align="left"><b>Total Price</b></td>
									<td width="40%" align="left"><b>Staff Name</b></td></tr>';
						for($i=1;$i<=$_POST['total_service'];$i++)
						{
						
            
						     
									$message.= '
						         	<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['service_name'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_service_price'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_service_disc'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_service_total'.$i].'</font><br></td>
							<td width="40%" align="left"><font color="#FF0000">'.$_POST['staff_name'.$i].'</font><br></td>
									</tr>';
								
							 	
                         }
						 $message.='</table>';
						
					  }
						
					if($_POST['service_price'])
                    {
					$message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;">
                    <tr>
					<td width="15%" align="left"><b>Service Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['service_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Membership Discount Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['nonmemb_discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Non-Member Discount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['nonmemb_discount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['nonmemb_discount_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Non-Member Discount Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['nonmemb_discount_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['service_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Service Tax 15%</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['service_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_cost'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Cost</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_cost'].'</font><br></td>
                    </tr></table>';
					}
					
					if($_POST['total_voucher'])
					{
					$message.= '<table colspan="5" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Voucher Name</b></td>
									<td width="15%" align="left"><b>Voucher Code</b></td>
									<td width="15%" align="left"><b>Voucher Details </b></td>
									<td width="15%" align="left"><b>Redemptions</b></td>
									<td width="40%" align="left"><b>Remaining pice in voucher</b></td></tr>';
						for($i=1;$i<=$_POST['total_voucher'];$i++)
						{
						
            
						     
									$message.= '
						         	<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['voucher_name'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['cust_voucher_code'.$i].'</font><br></td>
							
						<td width="15%" align="left">Voucher Name:<font color="#FF0000">'.$_POST['voucher_name'.$i].'</font><br>
							        Start Date:<font color="#FF0000">'.$_POST['vouchers_start_date'.$i].'</font><br>
							End Date:<font color="#FF0000">'.$_POST['vouchers_end_date'.$i].'</font><br>
							Price:<font color="#FF0000">'.$_POST['vouchers_price'.$i].'</font><br></td>
							
							
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['totals_price'.$i].'</font><br></td>
							<td width="40%" align="left"><font color="#FF0000">'.$_POST['remaining_amnt_in_voucher'.$i].'</font><br></td>
									</tr>';
								
							 	
                        }
						$message.='</table>';
					}  
					
					if($_POST['package_names'])
					{
					$message.= '<table colspan="5" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Package Name:</b></td>
									<td width="15%" align="left"><b>Start Date:</b></td>
									<td width="15%" align="left"><b>End Date :</b></td>
									<td width="15%" align="left"><b>Price :</b></td>
									<td width="40%" align="left"><b>Redumption:</b></td></tr>';
						
									$message.= '<tr>
						<td width="15%" align="left"><font color="#FF0000">'.$_POST['package_name'].'</font><br></td>
						<td width="15%" align="left"><font color="#FF0000">'.$_POST['package_start_date'].'</font><br></td>
							
					<td width="15%" align="left"><font color="#FF0000">'.$_POST['package_end_date'].'</font><br></td>
						<td width="15%" align="left"><font color="#FF0000">'.$_POST['package_price'].'</font><br></td>
						<td width="40%" align="left"><font color="#FF0000">'.$_POST['totals_price_pkg'].'</font><br>
							</td>
									</tr></table>';
								
							 	
                    }
					
					if($_POST['category'])
                    {
					$message.= '<table colspan="2" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;">
                    <tr>
					<td width="15%" align="left"><b>Category</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['category'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_mode'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_mode'].'</font><br></td>
                    </tr>';
					}
					if($_POST['amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payable_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payable Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payable_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['employee_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Employee</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['employee_id'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Chaque Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Chaque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cheque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cheque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					
					
					
					  $message.='<tr></tr></table>';
		}
		
		
		if($_POST['action']=='add_customer_membership')
		{
			$inq_mail=$_POST['mail'];
			$mail->addAddress("$inq_mail");
			$users_mail=explode(',',$_POST['users_mail']);
			print_r($users_mail);
			for($i=0;$i<count($users_mail);$i++)
			{
				$emails=$users_mail[$i];
				$mail->addBCC("$emails"); 
			}
		   //$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Customer membership added for branch '. $_POST['branch_name'];
			$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['realtxt'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b> Mobile No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['realtxt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['customer_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['customer_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['membership_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Membership</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['membership_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['memb_disc'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Membership Details:Discount(in %)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['memb_disc'].'</font><br></td>
                    </tr>';
					}
					if($_POST['dayss'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Membership Details:Days</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['dayss'].'</font><br></td>
                    </tr>';
					}
					if($_POST['start_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['start_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['end_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['end_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_mode'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_mode'].'</font><br></td>
                    </tr>';
					}
					if($_POST['bank_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Chaque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cheque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cheque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_start_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_start_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_end_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_end_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['totals_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Totals Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['totals_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_voucher'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Voucher</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_voucher'].'</font><br></td>
                    </tr>';
					}
					
					
					
					  $message.='<tr></tr></table>';
		}
		
		if($_POST['action']=='add_inventoryy')
		{
			//$inq_mail=$_POST['mail'];
			//$mail->addAddress("$inq_mail");
			$users_mail='';
			if(trim($_POST['users_mail']) !='')
			{
				$users_mail=explode(',',$_POST['users_mail']);
				//print_r($users_mail);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					if($i==0)
					$mail->addAddress("isasoceanone@gmail.com");
					else
					$mail->addBCC("$emails"); 
				}
			}
			//$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Inventory added for branch '. $_POST['branch_name'] .' for vendor : ';
			$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['vendor_id'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Vendor/b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vendor_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['ref_invoice_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Referal Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['ref_invoice_no'].'</font><br></td>
                    </tr></table>';
					}
					
					
					if($_POST['total_service'])
					{
					
					$message.= '<table cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Product Name</b></td>
									<td width="15%" align="left"><b>Price</b></td>
									<td width="15%" align="left"><b>Product Qty</b></td>
									<td width="15%" align="left"><b>Discount</b></td>
									<td width="15%" align="left"><b>Total Price</b></td>
									<td width="15%" align="left"><b>Staff Name</b></td></tr>';
						for($i=1;$i<=$_POST['total_service'];$i++)
						{
						
            
						     
									$message.= '<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['product_id'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_price'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_qty'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_disc'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_total'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['staff_id'.$i].'</font><br></td>
									</tr>';
								
							 	
                         }
						  $message.='</table>';
					  }
					
					
					
				
					
					if($_POST['price'])
                    {
					$message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;">
                    <tr>
					<td width="15%" align="left"><b>Product Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_cost'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Cost</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_cost'].'</font><br></td>
                    </tr></table>';
					}
					
					if($_POST['type1'])
					{
					
					$message.= '<table colspan="2" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Tax Type</b></td>
									<td width="15%" align="left"><b>Tax Value(in %)</b></td>
									</tr>';
									
						for($i=1;$i<=$_POST['type1'];$i++)
						{
						
            
						     
									$message.= '
						         	<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['tax_type'.$i].'</font><br></td>
							
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['tax_value'.$i].'</font><br></td>
									</tr>';
								
							 	
                         }
						 $message.='</table>';
					  }
					
					if($_POST['payment_mode'])
                    {
					$message.= '<table colspan="2" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_mode'].'</font><br></td>
                    </tr>';
					}
					if($_POST['bank_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Chaque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cheque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cheque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_start_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_start_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_end_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_end_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_price'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['amount1'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount1'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payable_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payable Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payable_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					$message.='<tr></tr></table>';
		}
		if($_POST['action']=='sales_product')
		{
			$inq_mail=$_POST['mail'];
			if($inq_mail !='')
			$mail->addAddress("$inq_mail");
			else
			$mail->addAddress("isasoceanone@gmail.com");
			//print_r($users_mail);
			if(trim($_POST['users_mail']) !='')
			{
				$users_mail=explode(',',$_POST['users_mail']);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					$mail->addBCC("$emails"); 
				}
			}
		//$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Product sold for branch '. $_POST['branch_name'] .' for customer - ';
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['ref_invoice_no'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Referal Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['ref_invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['realtxt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Mobile No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['realtxt'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['customer_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['customer_id'].'</font><br></td>
                    </tr></table>';
					}
					
					if($_POST['total_service'])
					{
					
					$message.= '<table  colspan="5" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Product Name</b></td>
									<td width="15%" align="left"><b>Price</b></td>
									<td width="15%" align="left"><b>Product Qty</b></td>
									<td width="15%" align="left"><b>Discount</b></td>
									<td width="15%" align="left"><b>Total Price</b></td>
									</tr>';
						for($i=1;$i<=$_POST['total_service'];$i++)
						{
						
            
						     
									$message.= '
						         	<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['product_id'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['prod_price'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['product_qty'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['product_disc'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sales_product_price'.$i].'</font><br></td>
							
									</tr>';
								
							 	
                         }
						$message.='</table>';
					  }
					
					
					
					
					
					
					
					
					
					if($_POST['product_price'])
                    {
					$message.= '<table  colspan="2" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Product Price </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['product_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_price'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['total_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Price	</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_mode'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_mode'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cheque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cheque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_start_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_start_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_end_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_end_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['amount1'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Final Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount1'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payable_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payable Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payable_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					  $message.='<tr></tr></table>';
		}
		
		if($_POST['action']=='enroll')
		{
		     
			$inq_mail=$_POST['mail'];
			$mail->addAddress("$inq_mail");
			$users_mail=explode(',',$_POST['users_mail']);
			print_r($users_mail);
			for($i=0;$i<count($users_mail);$i++)
			{
				$emails=$users_mail[$i];
				$mail->addBCC("$emails"); 
			}
			 //$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Enrollment for branch '. $_POST['branch_name'] .' for customer - ';
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['admission_date'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Admission Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['inst_student_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Inst Student Id</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['inst_student_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['contact'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Contact</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['contact'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['mail'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Mail</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['mail'].'</font><br></td>
                    </tr>';
					}
					if($_POST['qualification'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Qualification</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['qualification'].'</font><br></td>
                    </tr>';
					}
					if($_POST['username'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Username</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['username'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['pass'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Password</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['pass'].'</font><br></td>
                    </tr>';
					}
					if($_POST['photo'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Photo</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['photo'].'</font><br></td>
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
					if($_POST['per_address'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Permenant Address</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['per_address'].'</font><br></td>
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
					if($_POST['source'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Source</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['source'].'</font><br></td>
                    </tr>';
					}
					if($_POST['admission_remark'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Admission Remark</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_remark'].'</font><br></td>
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
					if($_POST['paid_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Paid Type</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['paid_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['add_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Installement Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['add_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['toal_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['toal_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['concession'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Concession</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['concession'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_coupon'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount Coupon</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_coupon'].'</font><br></td>
                    </tr>';
					}
					if($_POST['net_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Net Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['net_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['service_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Service Tax</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['service_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment Tax</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment_wo_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment Without Tax</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_wo_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['installment_on'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Installment On</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['installment_on'].'</font><br></td>
                    </tr>';
					}
					if($_POST['dropdown'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Number of Installment</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['dropdown'].'</font><br></td>
                    </tr>';
					}
						if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Type</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['final_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Final Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_amt'].'</font><br></td>
                    </tr>';
					}
					
				
					
					  $message.='<tr></tr></table>';
		}
		
		
		
		if($_POST['action']=='add_students')
		{
			$inq_mail=$_POST['mail'];
			$mail->addAddress("$inq_mail");
			$users_mail=explode(',',$_POST['users_mail']);
			//print_r($users_mail);
			for($i=0;$i<count($users_mail);$i++)
			{
				$emails=$users_mail[$i];
				$mail->addBCC("$emails"); 
			}
		    // $mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Enrollment for branch '. $_POST['branch_name'] .' for customer - ';
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['admission_date'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Admission Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['inquiry_date'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['inquiry_date'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['contact'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Contact</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['contact'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['mail'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Mail</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['mail'].'</font><br></td>
                    </tr>';
					}
					if($_POST['qualification'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Qualification</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['qualification'].'</font><br></td>
                    </tr>';
					}
					if($_POST['username'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Username</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['username'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['pass'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Password</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['pass'].'</font><br></td>
                    </tr>';
					}
					if($_POST['photo'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Photo</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['photo'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['address'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Current Address</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['address'].'</font><br></td>
                    </tr>';
					}
					if($_POST['per_address'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Permanent Address</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['per_address'].'</font><br></td>
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
					if($_POST['source'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Source</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['source'].'</font><br></td>
                    </tr>';
					}
					if($_POST['admission_remark'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Admission Remark</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_remark'].'</font><br></td>
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
					if($_POST['paid_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Paid Type</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['paid_type'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['toal_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['toal_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['concession'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['concession'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_coupon'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount Coupon Code</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_coupon'].'</font><br></td>
                    </tr>';
					}
					if($_POST['net_fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Net Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['net_fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['service_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Service Tax 15</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['service_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['fees'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Fees</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['fees'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment(Including tax)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Service Tax in Down Payment</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['down_payment_wo_tax'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Down Payment(Without tax)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['down_payment_wo_tax'].'</font><br></td>
                    </tr>';
					}
					if($_POST['installment_on'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Installment On</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['installment_on'].'</font><br></td>
                    </tr>';
					}
					if($_POST['dropdown'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Number Of Installment</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['dropdown'].'</font><br></td>
                    </tr>';
					}
					if($_POST['add_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Installement Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['add_date'].'</font><br></td>
                    </tr>';
					}
					
						if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['final_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Final Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_amt'].'</font><br></td>
                    </tr>';
					}
					
				
					
					  $message.='<tr></tr></table>';
		}
		
		
			if($_POST['action']=='sale')
		{
			$inq_mail=$_POST['mail'];
			$mail->addAddress("$inq_mail");
			$users_mail=explode(',',$_POST['users_mail']);
			print_r($users_mail);
			for($i=0;$i<count($users_mail);$i++)
			{
				$emails=$users_mail[$i];
				$mail->addBCC("$emails"); 
			}
		     //$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Sale Voucher for branch '. $_POST['branch_name'] .' for customer - ';
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['category'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Category</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['category'].'</font><br></td>
                    </tr>';
					}
					if($_POST['realtxt'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Mobile No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['realtxt'].'</font><br></td>
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
					
					if($_POST['cust_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_id'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['voucher_id'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Voucher Id</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['voucher_id'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['vouchers_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_start_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_start_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_end_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_end_date'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['vouchers_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Selling Price </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['redeems_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Redeemable Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['redeems_price'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['total_quantities'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Quantity</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_quantities'].'</font><br></td>
                    </tr>';
					}
					if($_POST['issue_qty'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Quantity</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['issue_qty'].'</font><br></td>
                    </tr>';
					}
					if($_POST['memb_disc'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount(in %)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['memb_disc'].'</font><br></td>
                    </tr>';
					}
					if($_POST['days'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Days</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['days'].'</font><br></td>
                    </tr>';
					}
					if($_POST['memb_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['memb_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['package_names'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Pacakage Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['package_names'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['package_start_dates'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['package_start_dates'].'</font><br></td>
                    </tr>';
					}
					if($_POST['package_end_dates'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['package_end_dates'].'</font><br></td>
                    </tr>';
					}
					if($_POST['pkg_qtys'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Quantity</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['pkg_qtys'].'</font><br></td>
                    </tr>';
					}
					if($_POST['pkg_prices'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['pkg_prices'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['selling_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Selling Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['selling_amount'].'</font><br></td>
                    </tr></table>';
					}
					if($_POST['total_type1'])
					{
					
					$message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Tax Type</b></td>
									<td width="85%" align="left"><b>Tax Value(in %)</b></td>
									</tr>';
									
						for($i=1;$i<=$_POST['total_type1'];$i++)
						{
						
            
						     
									$message.= '<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['tax_type'.$i].'</font><br></td>
							
							<td width="85%" align="left"><font color="#FF0000">'.$_POST['tax_value'.$i].'</font><br></td>
									</tr>';
								
							 	
                         }
                       	$message.='</table>';
					  }
				
					if($_POST['start_date'])
                    {
					$message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;">
                    <tr>
					<td width="15%" align="left"><b>Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['start_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['end_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['end_date'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_mode'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_mode'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['cheque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cheque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					
					
					  $message.='<tr></tr></table>';
		}
		
		
			if($_POST['action']=='add_payment')
			{
				//$inq_mail=$_POST['mail'];
				//$mail->addAddress("$inq_mail");
				$users_mail=explode(',',$_POST['users_mail']);
				print_r($users_mail);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					$mail->addBCC("$emails"); 
				}
		     	//$mail->addBCC($_POST['mail']); 
				$mail->Subject = 'installment Payment done of '. $_POST['customer_name'] .'';
				$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['customer_name'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['customer_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Total</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['final_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Final Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['total_paid_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total paid Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_paid_amt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['balance_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['balance_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['amount_paid'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Deposite Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount_paid'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					
					
					
					  $message.='<tr></tr></table>';
		}
		
			if($_POST['action']=='add_inventory')
		{
		     //$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Inventory for branch '. $_POST['branch_name'] .' for customer - ';
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['name'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Vender Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['price'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Product Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['price'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['total_cost'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Discounted Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_cost'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['amount1'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Final Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount1'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_amnt_paid'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total paid Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_amnt_paid'].'</font><br></td>
                    </tr>';
					}
					if($_POST['balance_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['balance_amount'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['amount_paid'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Deposite Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount_paid'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					
					
					
					  $message.='<tr></tr></table>';
		}
		
		
			if($_POST['action']=='add_sale')
		{
		     //$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Sale Product for branch '. $_POST['branch_name'] .' for customer - ';
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['name'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Vender Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['price'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Product Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['price'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					
				
					if($_POST['total_amnt_paid'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Paid Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_amnt_paid'].'</font><br></td>
                    </tr>';
					}
					if($_POST['balance_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['balance_amount'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['amount_paid'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Deposite Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount_paid'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					
					
					
					  $message.='<tr></tr></table>';
		}
			if($_POST['action']=='add_customer')
			{
				//$inq_mail=$_POST['mail'];
				//$mail->addAddress("$inq_mail");
				$users_mail=explode(',',$_POST['users_mail']);
				print_r($users_mail);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					$mail->addBCC("$emails"); 
				}
		     	//$mail->addBCC($_POST['mail']); 
				$mail->Subject = 'Customer Installment Payment done of '. $_POST['customer_name'] .'';
				$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['customer_name'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['customer_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Service Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount in (%)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['final_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Final Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['total_paid_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Paid Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_paid_amt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['balance_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['balance_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['amount_paid'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Deposite Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount_paid'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					
					
					
					  $message.='<tr></tr></table>';
		}
		
		$sendMessage=$GLOBALS['box_message_top'];
		$sendMessage.=$message;
		$sendMessage.=$GLOBALS['box_message_bottom'];
		//$sendMessage="Its kiran vyavahare";
		//$mail->addAddress('ajaymahadik60@gmail.com');
		//$mail->addCC('sudhirwithu@gmail.com');
		 $mail->WordWrap = 3000; 
		 $mail->isHTML(true);                                  // Set email format to HTML
		 $mail->Body    = $sendMessage;
		 
	
	$mail->Send();
  echo "Email Sent Successfully.";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
	?>
	