<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<?php
	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
?>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php';	
	$mail = new PHPMailer(true);
	try {
		//$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->SMTPDebug=1;   
		$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'info@isasbeautyschool.com';                   // SMTP username
        $mail->Password = 'isas@08info';                            // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
		$mail->Port = 465;
		$mail->SetFrom('info@isasbeautyschool.com', 'ISAS');     //Set who the message is to be sent from
		$mail->addReplyTo('info@isasbeautyschool.com', 'ISAS beautyschool');  //Set an alternative reply-to address
		
		if($_POST['action']=='inquiry')
		{
			$inq_mail=trim($_POST['email_id']);
			//$mail->addAddress("$inq_mail"); 
			//print_r($users_mail);
			if(trim($_POST['users_mail']) !='')
			{
				$users_mail=explode(',',$_POST['users_mail']);
				$usermail=array_unique($users_mail);
				$array_mail = array_values(array_filter($usermail));
				//print_r($array_mail);
				for($i=0;$i<count($array_mail);$i++)
				{
					if($i==0)
					{
						if($inq_mail !='')
							$mail->addAddress("$inq_mail");
						else
							$mail->addAddress("$array_mail[$i]");
					}
					else
					{	
						$emails=trim($array_mail[$i]);
						$mail->addBCC("$emails"); 
					}
				}
			}
			/*$users_mail=explode(',',$_POST['users_mail']);
			for($i=0;$i<count($users_mail);$i++)
			{
				$emails=$users_mail[$i];
				$mail->addCC("$emails"); 
			}*/
			$email_text_msg=$_POST['email_text_msg'];
			//$mail->addBCC($_POST['inqyiry_idss']); 
			$mail->Subject = 'Thank you for registering in ISAS Beauty School for '.$_POST['branch_name'].' Branch ';
			$message.=urldecode($email_text_msg)."<br/>";
			
			$sel_coursse_id="select course_name from courses where course_id='".$_POST['course_id']."'";
			$ptr_query=mysql_query($sel_coursse_id);
			$data_course=mysql_fetch_array($ptr_query);
			
			$sel_cnt="select contact_phone from site_setting where admin_id='".$_POST['employee_id']."' ";
			$ptr_cnt=mysql_query($sel_cnt);
			if(mysql_num_rows($ptr_cnt))
			{
				$data_cnt=mysql_fetch_array($ptr_cnt);
				$staff_contact=$data_cnt['contact_phone'];
			}
			else
			{
				$staff_contact="9158985007";
			}
			$message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" style="color:black;" >';
			/*$message .= '
				<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
				<tr>
				<td colspan="2" align="left" style="color:black;"><h3> Hello '.$_POST['firstname'].' '.$_POST['lastname'].', Thank you for showing interest in '.$data_course['course_name'].' course. We appreciate your inquiry with our '.$_POST['branch_name'].' branch.</h3></td>
				</tr></table>';*/
				/*if($_POST['branch_name'])
				{
					$message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
					<tr>
					<td width="15%" align="left"><b>Branch Name</b></td>
					<td width="85%" align="left"><font color="#FF0000">'.$_POST['branch_name'].'</font><br></td>
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
				if($_POST['firstname'])
				{
					$message.= '
					<tr>
					<td width="15%" align="left"><b>First Name</b></td>
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
				}*/
				
				$address='';
				if($_POST['branch_name']=="Pune")
				{
					$address= '<strong>Our Address: </strong>International School of Aesthetics and Spa, 2nd Floor, The Greens,North Main Road, Koregoan Park, Pune-411001. <br/>Location: <a href="https://bit.ly/2yOhji6" target="_blank" >https://bit.ly/2yOhji6</a>  <br/>Events - <a href="https://bit.ly/2O2uDTU" target="_blank" >https://bit.ly/2O2uDTU</a> <br/> Student artwork - <a href="https://bit.ly/2La2VXz" target="_blank" >https://bit.ly/2La2VXz</a>  <br/>Institute Photos: <a href="https://bit.ly/2O2qO0Q" target="_blank" >https://bit.ly/2O2qO0Q</a> ';
				}
				else if($_POST['branch_name']=="Ahmedabad")
				{
					$address= '<strong>Our Address: </strong>International School of Aesthetics and Spa, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007. <br/>Location: <a href="https://bit.ly/2N28vbw" target="_blank" >https://bit.ly/2N28vbw</a> <br/>Events: <a href="https://bit.ly/2O2uDTU" target="_blank" >https://bit.ly/2O2uDTU<a/> <br/>Student artwork: <a href="https://bit.ly/2La2VXz" target="_blank" >https://bit.ly/2La2VXz</a> <br/>Institute photos: <a href="https://bit.ly/2uzwfMx" target="_blank" >https://bit.ly/2uzwfMx</a> ';
				}
				else if($_POST['branch_name']=="ISAS PCMC")
				{
					$address= '<strong>Our Address: </strong>Hari A1,Next to ABS Gym, Pimple Nilakh, Pune 411027. <br/>Location: <a href="https://bit.ly/2Ke26fQ" target="_blank" >https://bit.ly/2Ke26fQ</a> <br/>Events - <a href="https://bit.ly/2O2uDTU" target="_blank" >https://bit.ly/2O2uDTU</a> <br/>Student artwork: <a href="https://bit.ly/2La2VXz" target="_blank">https://bit.ly/2La2VXz" target="_blank</a> <br/>Institute photos: <a href="https://bit.ly/2LrF6JM" target="_blank" >https://bit.ly/2LrF6JM</a> ';
				}
				
				$message.= '
					<tr>
					<td colspan="2" width="100%%" align="left">Hello '.$_POST['firstname'].' '.$_POST['lastname'].', Thank you for showing interest in '.$data_course['course_name'].' course. We appreciate your inquiry with our '.$_POST['branch_name'].' branch. For more details you can get touch with us on  <a href="tel:'.$staff_contact.'">'.$staff_contact.'</a> .<br/><br/> '.$address.'</td>
					</tr>';
				/*if($_POST['lead_category'])
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
				}*/
				$message.='<tr></tr></table>';
				$message.='
				<table style="max-width:600px;min-width:280px;border:1px solid #cccccc" cellspacing="0" cellpadding="0" border="0" align="center">
					<tbody>
					<tr>
					  <td height="20"></td>
					</tr>
					<tr>
					  	<td><div style="width:100%"><img src="http://www.isasbeautyschool.org/faculty_login/images/mailer/img1.gif" style="width:inherit" alt="BIGGEST CIDESCO BEAUTY SCHOOL in INDIA" class="CToWUd" vspace="0" hspace="0" border="0" align="left"></div></td>
					</tr>
					<tr>
					   	<td height="20"></td>
					</tr>
				   	<tr>
						<td width="598"> <table width="100%" cellspacing="0" cellpadding="0" align="center">
				  	<tbody>
					<tr>
					  <td width="20"> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					  <td> <table width="100%" cellspacing="0" cellpadding="0" align="center">
				  	<tbody>
					<tr>
				  		<td height="15"></td> 
					</tr>
					<tr>
					  	<td>
				  		<table width="260" cellspacing="0" cellpadding="0" align="left">
				  		<tbody>
				   		<tr>
					  <td height="10"></td>
					</tr>
					<tr>
					  <td> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img2.jpg" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				
				 <table width="270" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#ae3f8f;font-size:20px"><b>ISAS ACCOLADES</b></td>
					</tr>
					<tr>
					  <td height="10"></td> 
					</tr>
					<tr>
					  <td>
						  <table cellspacing="0" cellpadding="0">
						  <tbody>
							<tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Highest No. on CIDESCO Students</td>
							</tr>
							<tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
							<tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">100% Result in CIDESCO (Media Makeup, Beauty Therapy, Salon / Spa Management) Exams</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
							<tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">#1 CIDESCO Spa Management Institute</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr> <tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Largest No. of VTCT-UK Certified Students</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr> 
						   <tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Highest No. of Events Participated </td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
						   <tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">15 Prestigious Awards Won for 
						Educational Excellence </td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr><tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Largest No. of International Placements</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
						  </tbody>
						</table>
				  	</td>
					</tr>
				   <tr>
					  <td height="15"></td> 
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
					<tr></tr>
					<tr>
					  <td height="20" align="center"><table width="180" cellspacing="0" cellpadding="0" align="center">
						<tbody><tr>
						  <td><table style="border-collapse:collapse" width="180" cellspacing="0" cellpadding="0" border="0">
							<tbody><tr>
							  <td style="border-bottom:3px solid #a50d0d" height="36" bgcolor="#e21212" align="center"><a href="http://www.isasbeautyschool.com" style="font-family:Arial,Helvetica,sans-serif;font-size:16px;color:#ffffff;text-decoration:none;display:block;line-height:34px" target="_blank" data-saferedirecturl="http://www.isasbeautyschool.com"><b>KNOW MORE</b></a></td>
							</tr>
						  </tbody></table></td>
						  <td width="4"></td>
						</tr>
						<tr>
						  <td height="4"></td>
						</tr>
					  </tbody></table></td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
					<tr>
					   <td>
				  <table width="260" cellspacing="0" cellpadding="0" align="right">
				  <tbody>
				   <tr>
					  <td height="10"></td>
					</tr>
					<tr>
					  <td align="right"> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img3.jpg" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				 <table width="270" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#ae3f8f;font-size:20px;text-align:right"><b>INTERNATIONAL DIPLOMA<br>COURSES OFFERED</b></td>
					</tr>
					<tr>
					  <td height="20"></td> 
					</tr>
					<tr>
					  <td>
				  <table cellspacing="0" cellpadding="0" align="right">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Creative Hair Dressing</td>
					</tr>
					<tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
					<tr>
					 <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Professional Makeup</td>
					</tr> 
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
					<tr>
					 <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Nail Technology</td>
					</tr>
				  <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr><tr>
					  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Advanced Beauty Therapy</td>
					</tr> 
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
				   <tr>
					  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Salon / Spa Management</td>
					</tr>
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
				   <tr>
					 <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Signature Spa Therapy</td>
					</tr>
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
				   <tr>
					  <td height="15"></td> 
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
					<tr>
					  <td height="12"></td>
					</tr>
					<tr>
					  <td height="4" bgcolor="#ae3f8f"></td>
					</tr>
					<tr>
					  <td height="2"></td>
					</tr>
					<tr>
					  <td> <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#e6e6e6" align="center">
				  <tbody>
					<tr>
					  <td width="20"> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					  <td> <table width="100%" cellspacing="0" cellpadding="0" align="center">
				  <tbody>
					<tr>
				  <td height="15"></td> 
					</tr>
					<tr>
					  <td>
				  <table width="220" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#171717;text-align:center;font-size:20px"><i>International <br>Certifications <br>Offered</i></td>
					</tr>
				  </tbody>
				</table>
				 <table width="280" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td><div style="width:100%"><img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img4.jpg" style="width:inherit" alt="" class="CToWUd" vspace="0" hspace="0" border="0" align="left"></div></td>
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
				  </tbody>
				</table>
				</td>
					  <td width="20"> <img src="https://ci6.googleusercontent.com/proxy/SlF4bR_4b66YPSCCmC4tU7leJ8tY4OTu_bW3KTQgc7A2S_JmY9lJ4ydMF9_Mk27JDy94Nv-zQnnhP6wAruSXhgZWXO6va2szy9PWMK4o8AAOS7sCuJcjd3UTIg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				</td>
					</tr>
				  </tbody>
				</table>
				</td>
					  <td width="20"> <img src="https://ci6.googleusercontent.com/proxy/SlF4bR_4b66YPSCCmC4tU7leJ8tY4OTu_bW3KTQgc7A2S_JmY9lJ4ydMF9_Mk27JDy94Nv-zQnnhP6wAruSXhgZWXO6va2szy9PWMK4o8AAOS7sCuJcjd3UTIg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				</td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
					<tr>
					  <td> <table cellspacing="0" cellpadding="0" align="center">
				  <tbody>
					<tr>
					  <td><div style="width:100%"><img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img5.jpg" style="width:inherit" alt="" class="CToWUd" vspace="0" hspace="0" border="0" align="left"></div></td>
					</tr>
				  </tbody>
				</table>
				</td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
				  </tbody>
				</table>';				
		}		
		if($_POST['action']=='add_new_course')
		{
			
			$inq_mail=$_POST['mail'];
			if($inq_mail !='')
			$mail->addAddress("$inq_mail");
			else
			$mail->addAddress("erp.isas@gmail.com");
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
			$mail->Subject = $_POST['name'].' Added New Course '.$_POST['course_id'].' for branch '. $_POST['branch_name'];
			$message= '
                    <table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>'.$_POST['name'].' Enroll For New Course in '.$_POST['branch_name'].' branch</h2></td>
                    </tr></table>';
					if($_POST['admission_date'])
                    {
					$message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Admission Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['admission_date'].'</font><br></td>
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
					if($_POST['name'])
					{
                    $message.= '
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
					
					if($_POST['final_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Balance Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['dropdown'])
					{
						$message.= '
									<tr>
									<td width="15%" colspan="2" align="center"><b>Installment</b></td>
									</tr>';
					
						$message.= '</table><table  colspan="5" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Sr. No</b></td>
									<td width="45%" align="left"><b>Installment amount</b></td>
									<td width="40%" align="left"><b>Installment date</b></td>
									</tr>';
						for($i=1;$i<=$_POST['dropdown'];$i++)
						{
							$message.= '
							<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$i.'</font><br></td>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['inst_val'.$i].'</font><br></td>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['inst_date'.$i].'</font><br></td>
							</tr>';
                         }
						$message.='</table>';
					}
					
					//$message.='<tr></tr></table>';
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
				$mail->addAddress("erp.isas@gmail.com");
			if(trim($_POST['users_mail']) !='')
			{
				$users_mail=explode(',',$_POST['users_mail']);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					$mail->addBCC("$emails"); 
				}
			}
			$user_type=$_POST['user_type'];
			$cust_name='';
			if($user_type=='Customer')
			{
				$sql_product = "select cust_name, cust_id from customer where cust_id='".$_POST['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$cust_name=$data_product['cust_name'];
			}
			else if($user_type=='Employee')
			{
				$sql_product = "select name, admin_id from site_setting where admin_id='".$_POST['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$cust_name=$data_product['name'];
			}
			else
			{
				$sql_product = "select name from enrollment where enroll_id='".$_POST['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$cust_name=$data_product['name'];
			}
			$sel_name="select cust_name from customer where cust_id='".$_POST['customer_id']."' ";
			$ptr_name=mysql_query($sel_name);
			$data_cust=mysql_fetch_array($ptr_name);
			$cust_name=$data_cust['cust_name'];
			
			//$mail->addBCC($_POST['mail']); 
			$mail->Subject ='Product sold for branch '.$_POST['branch_name'].' for customer - '.$cust_name;
			$message ='
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					<tr>
						<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool Messages</h2></td>
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
					if($cust_name)
                    {
						$message.= '
                    	<tr>
						<td width="15%" align="left"><b>Mobile No</b></td>
                    	<td width="85%" align="left"><font color="#FF0000">'.$cust_name.'</font><br></td>
                    	</tr>';
					}				
					if($_POST['customer_id'])
                    {
						$message.= '
                    	<tr>
						<td width="15%" align="left"><b>Customer</b></td>
                    	<td width="85%" align="left"><font color="#FF0000">'.$data_cust['cust_name'].'</font><br></td>
                    	</tr>';
					}	
					if($_POST['total_service'])
					{
						$message.= '</table><table  colspan="5" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
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
			if($inq_mail !='')
				$mail->addAddress("$inq_mail");
			else
				$mail->addAddress("erp.isas@gmail.com");
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
			$mail->Subject = 'Congratulatation '.$_POST['name'].'! your enrollment with isasbeautyschool is successful.';
			
			
			$message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" style="color:black;" >';
			
			$address='';
			if($_POST['branch_name']=="Pune")
			{
				$address= '<strong>Our Address: </strong>International School of Aesthetics and Spa, 2nd Floor, The Greens,North Main Road, Koregoan Park, Pune-411001. <br/>Location: <a href="https://bit.ly/2yOhji6" target="_blank" >https://bit.ly/2yOhji6</a>  <br/>Events - <a href="https://bit.ly/2O2uDTU" target="_blank" >https://bit.ly/2O2uDTU</a> <br/> Student artwork - <a href="https://bit.ly/2La2VXz" target="_blank" >https://bit.ly/2La2VXz</a>  <br/>Institute Photos: <a href="https://bit.ly/2O2qO0Q" target="_blank" >https://bit.ly/2O2qO0Q</a> ';
			}
			else if($_POST['branch_name']=="Ahmedabad")
			{
				$address= '<strong>Our Address: </strong>International School of Aesthetics and Spa, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007. <br/>Location: <a href="https://bit.ly/2N28vbw" target="_blank" >https://bit.ly/2N28vbw</a> <br/>Events: <a href="https://bit.ly/2O2uDTU" target="_blank" >https://bit.ly/2O2uDTU<a/> <br/>Student artwork: <a href="https://bit.ly/2La2VXz" target="_blank" >https://bit.ly/2La2VXz</a> <br/>Institute photos: <a href="https://bit.ly/2uzwfMx" target="_blank" >https://bit.ly/2uzwfMx</a> ';
			}
			else if($_POST['branch_name']=="ISAS PCMC")
			{
				$address= '<strong>Our Address: </strong>Hari A1,Next to ABS Gym, Pimple Nilakh, Pune 411027. <br/>Location: <a href="https://bit.ly/2Ke26fQ" target="_blank" >https://bit.ly/2Ke26fQ</a> <br/>Events - <a href="https://bit.ly/2O2uDTU" target="_blank" >https://bit.ly/2O2uDTU</a> <br/>Student artwork: <a href="https://bit.ly/2La2VXz" target="_blank">https://bit.ly/2La2VXz" target="_blank</a> <br/>Institute photos: <a href="https://bit.ly/2LrF6JM" target="_blank" >https://bit.ly/2LrF6JM</a> ';
			}
			$message.= '
			<tr>
				<td colspan="2" width="100%%" align="left">Hello '.$_POST['name'].', Thank you for choosing ISAS BEAUTYSCHOOL, '.$_POST['branch_name'].' . <br/><br/> '.$address.'</td>
			</tr>';
			
			
			$message.='<tr></tr></table>';
				$message.='
				<table style="max-width:600px;min-width:280px;border:1px solid #cccccc" cellspacing="0" cellpadding="0" border="0" align="center">
					<tbody>
					<tr>
					  <td height="20"></td>
					</tr>
					<tr>
					  	<td><div style="width:100%"><img src="http://www.isasbeautyschool.org/faculty_login/images/mailer/img1.gif" style="width:inherit" alt="BIGGEST CIDESCO BEAUTY SCHOOL in INDIA" class="CToWUd" vspace="0" hspace="0" border="0" align="left"></div></td>
					</tr>
					<tr>
					   	<td height="20"></td>
					</tr>
				   	<tr>
						<td width="598"> <table width="100%" cellspacing="0" cellpadding="0" align="center">
				  	<tbody>
					<tr>
					  <td width="20"> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					  <td> <table width="100%" cellspacing="0" cellpadding="0" align="center">
				  	<tbody>
					<tr>
				  		<td height="15"></td> 
					</tr>
					<tr>
					  	<td>
				  		<table width="260" cellspacing="0" cellpadding="0" align="left">
				  		<tbody>
				   		<tr>
					  <td height="10"></td>
					</tr>
					<tr>
					  <td> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img2.jpg" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				
				 <table width="270" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#ae3f8f;font-size:20px"><b>ISAS ACCOLADES</b></td>
					</tr>
					<tr>
					  <td height="10"></td> 
					</tr>
					<tr>
					  <td>
						  <table cellspacing="0" cellpadding="0">
						  <tbody>
							<tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Highest No. on CIDESCO Students</td>
							</tr>
							<tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
							<tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">100% Result in CIDESCO (Media Makeup, Beauty Therapy, Salon / Spa Management) Exams</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
							<tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">#1 CIDESCO Spa Management Institute</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr> <tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Largest No. of VTCT-UK Certified Students</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr> 
						   <tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Highest No. of Events Participated </td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
						   <tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">15 Prestigious Awards Won for 
						Educational Excellence </td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr><tr>
							  <td valign="top"><img src="https://ci3.googleusercontent.com/proxy/uCxfUoNW_QSlDE31098v7cLMZtiUcXt_L9HEsUizAO_gYcKmiDaWXj0kLSauFpcxod7dv7nnt1xN2DHN4DDXihfWLIbyCrmczE7Yxj6NEbzky75h2AQGKUmKdg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/bullet.gif" alt="" class="CToWUd"></td>
							  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px">Largest No. of International Placements</td>
							</tr> <tr>
							  <td height="8"></td>
							  <td height="8"></td>
							</tr>
						  </tbody>
						</table>
				  	</td>
					</tr>
				   <tr>
					  <td height="15"></td> 
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
					<tr></tr>
					<tr>
					  <td height="20" align="center"><table width="180" cellspacing="0" cellpadding="0" align="center">
						<tbody><tr>
						  <td><table style="border-collapse:collapse" width="180" cellspacing="0" cellpadding="0" border="0">
							<tbody><tr>
							  <td style="border-bottom:3px solid #a50d0d" height="36" bgcolor="#e21212" align="center"><a href="http://www.isasbeautyschool.com" style="font-family:Arial,Helvetica,sans-serif;font-size:16px;color:#ffffff;text-decoration:none;display:block;line-height:34px" target="_blank" data-saferedirecturl="http://www.isasbeautyschool.com"><b>KNOW MORE</b></a></td>
							</tr>
						  </tbody></table></td>
						  <td width="4"></td>
						</tr>
						<tr>
						  <td height="4"></td>
						</tr>
					  </tbody></table></td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
					<tr>
					   <td>
				  <table width="260" cellspacing="0" cellpadding="0" align="right">
				  <tbody>
				   <tr>
					  <td height="10"></td>
					</tr>
					<tr>
					  <td align="right"> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img3.jpg" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				 <table width="270" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#ae3f8f;font-size:20px;text-align:right"><b>INTERNATIONAL DIPLOMA<br>COURSES OFFERED</b></td>
					</tr>
					<tr>
					  <td height="20"></td> 
					</tr>
					<tr>
					  <td>
				  <table cellspacing="0" cellpadding="0" align="right">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Creative Hair Dressing</td>
					</tr>
					<tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
					<tr>
					 <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Professional Makeup</td>
					</tr> 
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
					<tr>
					 <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Nail Technology</td>
					</tr>
				  <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr><tr>
					  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Advanced Beauty Therapy</td>
					</tr> 
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
				   <tr>
					  <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Salon / Spa Management</td>
					</tr>
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
				   <tr>
					 <td style="font-family:Segoe,Arial;color:#404040;font-size:13px;text-align:right">Signature Spa Therapy</td>
					</tr>
				   <tr>
					  <td height="12"></td>
					  <td height="12"></td>
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
				   <tr>
					  <td height="15"></td> 
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
					<tr>
					  <td height="12"></td>
					</tr>
					<tr>
					  <td height="4" bgcolor="#ae3f8f"></td>
					</tr>
					<tr>
					  <td height="2"></td>
					</tr>
					<tr>
					  <td> <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#e6e6e6" align="center">
				  <tbody>
					<tr>
					  <td width="20"> <img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					  <td> <table width="100%" cellspacing="0" cellpadding="0" align="center">
				  <tbody>
					<tr>
				  <td height="15"></td> 
					</tr>
					<tr>
					  <td>
				  <table width="220" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td style="font-family:Segoe,Arial;color:#171717;text-align:center;font-size:20px"><i>International <br>Certifications <br>Offered</i></td>
					</tr>
				  </tbody>
				</table>
				 <table width="280" cellspacing="0" cellpadding="0" align="left">
				  <tbody>
					<tr>
					  <td><div style="width:100%"><img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img4.jpg" style="width:inherit" alt="" class="CToWUd" vspace="0" hspace="0" border="0" align="left"></div></td>
					</tr>
				  </tbody>
				</table>
				  </td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
				  </tbody>
				</table>
				</td>
					  <td width="20"> <img src="https://ci6.googleusercontent.com/proxy/SlF4bR_4b66YPSCCmC4tU7leJ8tY4OTu_bW3KTQgc7A2S_JmY9lJ4ydMF9_Mk27JDy94Nv-zQnnhP6wAruSXhgZWXO6va2szy9PWMK4o8AAOS7sCuJcjd3UTIg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				</td>
					</tr>
				  </tbody>
				</table>
				</td>
					  <td width="20"> <img src="https://ci6.googleusercontent.com/proxy/SlF4bR_4b66YPSCCmC4tU7leJ8tY4OTu_bW3KTQgc7A2S_JmY9lJ4ydMF9_Mk27JDy94Nv-zQnnhP6wAruSXhgZWXO6va2szy9PWMK4o8AAOS7sCuJcjd3UTIg=s0-d-e1-ft#https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/spacer.gif" alt="" class="CToWUd"></td>
					</tr>
				  </tbody>
				</table>
				</td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
					<tr>
					  <td> <table cellspacing="0" cellpadding="0" align="center">
				  <tbody>
					<tr>
					  <td><div style="width:100%"><img src="https://www.ieplads.com/mailers/2018/shiksha/ISAS_4dec/images/img5.jpg" style="width:inherit" alt="" class="CToWUd" vspace="0" hspace="0" border="0" align="left"></div></td>
					</tr>
				  </tbody>
				</table>
				</td>
					</tr>
					<tr>
					  <td height="20"></td>
					</tr>
				  </tbody>
				</table>';
			
			/*$message= '
				<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
				
				<tr>
				<td colspan="2" align="left" style="color:black;"><h2>Enrollment Messages for '.$_POST['name'].' From '.$_POST['branch_name'].'</h2></td>
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
				if($_POST['total_amt'])
				{
					$message.= '
					<tr>
					<td width="15%" align="left"><b>Total Amount</b></td>
					<td width="85%" align="left"><font color="#FF0000">'.$_POST['total_amt'].'</font><br></td>
					</tr>';
				}
				if($_POST['dropdown'])
				{
					$message.= '
					<tr>
						<td width="15%" colspan="2" align="center"><b>Installment</b></td>
					</tr>';
					$message.= '</table><table  colspan="5" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
					<tr>
						<td width="15%" align="left"><b>Sr. No</b></td>
						<td width="45%" align="left"><b>Installment amount</b></td>
					<td width="40%" align="left"><b>Installment date</b></td>
					</tr>';
					for($i=1;$i<=$_POST['dropdown'];$i++)
					{
						$message.= '
						<tr>
						<td width="15%" align="left"><font color="#FF0000">'.$i.'</font><br></td>
						<td width="15%" align="left"><font color="#FF0000">'.$_POST['inst_val'.$i].'</font><br></td>
						<td width="15%" align="left"><font color="#FF0000">'.$_POST['inst_date'.$i].'</font><br></td>
						</tr>';
					}
					$message.='</table>';
				}*/	
			}
			if($_POST['action']=='add_students')
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
				$inq_mail=$_POST['mail'];
				if($inq_mail !='')
					$mail->addAddress("$inq_mail");
				else
					$mail->addAddress("erp.isas@gmail.com");
				
				$users_mail='';
				if(trim($_POST['users_mail']) !='')
				{
					$users_mail=explode(',',$_POST['users_mail']);
					//print_r($users_mail);
					for($i=0;$i<count($users_mail);$i++)
					{
						$emails=$users_mail[$i];
						$mail->addBCC("$emails"); 
					}
				}
					//$mail->addBCC($_POST['mail']); 
				$mail->Subject = 'ISAS ('.$_POST['branch_name'].') -  Installment Payment of '.$_POST['name'].' done for  Course '.$_POST['course_name'].' ';
				$message= '
				<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
				
				<tr>
				<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool Messages</h2></td>
				</tr></table>';
			
				if($_POST['branch_name'])
				{
				$message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
				<tr>
				<td width="15%" align="left"><b>Branch</b></td>
				<td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
				</tr>';
				}
				if($_POST['name'])
				{
				$message.= '
				<tr>
				<td width="15%" align="left"><b>Student Name</b></td>
				<td width="85%" align="left"><font color="#FF0000">'.$_POST['name'].'</font><br></td>
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
				
				if($_POST['amount_paid'])
				{
				$message.= '
				<tr>
				<td width="15%" align="left"><b>Deposite Amount</b></td>
				<td width="85%" align="left"><font color="#FF0000">'.$_POST['amount_paid'].'</font><br></td>
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
				
				
				
				  $message.='<tr></tr></table>';
			}
			if($_POST['action']=='add_payment_service')
			{
				$inq_mail=$_POST['mail'];
				if($inq_mail !='')
					$mail->addAddress("$inq_mail");
				else
					$mail->addAddress("erp.isas@gmail.com");
				
				$users_mail='';
				if(trim($_POST['users_mail']) !='')
				{
					$users_mail=explode(',',$_POST['users_mail']);
					//print_r($users_mail);
					for($i=0;$i<count($users_mail);$i++)
					{
						$emails=$users_mail[$i];
						$mail->addBCC("$emails"); 
					}
				}
					//$mail->addBCC($_POST['mail']); 
				$mail->Subject = 'Service Payment of '.$_POST['customer_name'].' is completed ISAS '.$_POST['branch_name'].' ';
				$message= '
				<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
				<tr>
				<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool Messages</h2></td>
				</tr></table>';
			
				if($_POST['branch_name'])
				{
				$message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
				<tr>
				<td width="15%" align="left"><b>Branch</b></td>
				<td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
				</tr>';
				}
				if($_POST['customer_name'])
				{
				$message.= '
				<tr>
				<td width="15%" align="left"><b>Student Name</b></td>
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
				
				if($_POST['amount_paid'])
				{
				$message.= '
				<tr>
				<td width="15%" align="left"><b>Deposite Amount</b></td>
				<td width="85%" align="left"><font color="#FF0000">'.$_POST['amount_paid'].'</font><br></td>
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
				
				if($_POST['bank_name'] && $_POST['bank_name']!="--Select--")
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
		
		if($_POST['action']=='verify_enroll')
		{
			$name=$_POST['name'];
			$branch_name=$_POST['branch_name'];
			$course_id=$_POST['course_id'];
			$select_cm="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm=mysql_query($select_cm);
			if(mysql_num_rows($ptr_cm))
			{
				$data_cm=mysql_fetch_array($ptr_cm);
				$cm_id=$data_cm['cm_id'];
			}
			else
			{
				$cm_id=$_SESSION['cm_id'];
			}
			$sel_name="select name from site_setting where admin_id='".$_SESSION['admin_id']."'";
			$ptr_name=mysql_query($sel_name);
			$data_name=mysql_fetch_array($ptr_name);
			$names=$data_name['name'];
			if(trim($name) !='')
			{
				$sel_emails="select email from site_setting where email!='' and cm_id='".$cm_id."' and (type='A' or type='AC')";
				$ptr_mail=mysql_query($sel_emails);
				if(mysql_num_rows($ptr_mail))
				{
					$i=1;
					while($data_mail=mysql_fetch_array($ptr_mail))
					{
						$mail_id=$data_mail['email'];
						if($i==1)
						{
							$mail->addAddress("$mail_id");
						}
						else
						{
							$mail->addCC("$mail_id"); 
						}
						$i++;
					}
				}
				//$mail->addBCC("erp.isas@gmail.com");			
				$mail->Subject = 'Enrollment Verification';
				$message='Please verify the Enrollment of '.$name.' for course '.$course_id.' for Branch '.$branch_name.' <br/><br/><br/>Thanks & Regards<br/> '.$names.'';
			} 
		}
		if($_POST['action']=='dsr_mail')
		{
			$users_mail='';
			if(trim($_POST['users_mail']) !='')
			{
				$users_mail=$_POST['users_mail'];
				$usermail=array_unique($users_mail);
				$array_mail = array_values(array_filter($usermail));
				//print_r($array_mail);
				for($i=0;$i<count($array_mail);$i++)
				{
					if($i==0)
					{
						$mail->addAddress("$array_mail[$i]");
					}
					else
					{
						$emails=trim($array_mail[$i]);
						$mail->addBCC("$emails"); 
					}
				}
				$message .="mail sending";
			}
			else
				$mail->addAddress("erp.isas@gmail.com");
			//$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'DSR Report';
			$message .=stripslashes($_POST['mail_content']);
			$message .="Successfully sent ";
		}
		$sendMessage=$GLOBALS['box_message_top'];
		echo $sendMessage.=$message;
		$sendMessage.=$GLOBALS['box_message_bottom'];
		if($_POST['action']!='')
		{
			$mail->WordWrap = 3000; 
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Body    = $sendMessage;
			$mail->Send();
			echo "Email Sent Successfully.";
		}
		//$sendMessage="Its kiran vyavahare";
		//$mail->addAddress('ajaymahadik60@gmail.com');
		//$mail->addCC('sudhirwithu@gmail.com');
		 
	} catch (phpmailerException $e) {
	  echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  echo $e->getMessage(); //Boring error messages from anything else!
}
?>