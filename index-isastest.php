<?php include '../faculty_login/inc_classes.php';?>
<?php //include "../faculty_login/include/headHeader_gst.php";?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Complaint/Feedback Form</title>
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="css/style.css">


</head>

<body>
<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<!--<div class="pen-title">
  <h1>Complaint/Feedback Form</h1><span>Pen <i class='fa fa-paint-brush'></i> + <i class='fa fa-code'></i> by <a href='http://andytran.me'>Andy Tran</a></span>
</div>-->
<!-- Form Module-->
<script src="../faculty_login/js/jquery-1.6.4.min.js" type="text/javascript"></script>
<?php
if(isset($_POST['submit']))
{
	$name=$_POST['name'];
	$course_id=( ($_POST['course_id'])) ? $_POST['course_id'] : "0";
	$complaint_type=$_POST['complaint_type'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$ticket_no=$_POST['ticket_nos'];
	$comment=$_POST['comment'];
	$admin_id=$_POST['admin_id'];
	$captcha=$_POST['captcha'];
	if((trim(strtolower($_POST['captcha'])) == $_SESSION['captcha']))
	{
		$insert_cm="insert into student_complaint (`name`,`course_id`,`complaint_type`,`ticket_no`,`email_id`,`phone_no`,`comment`,`staff_id`,`added_date`,`status`,`other_status`) values('".$name."','".$course_id."','".$complaint_type."','".$ticket_no."','".$email."','".$mobile."','".$comment."','".$admin_id."','".date('Y-m-d')."','Active','Open')";
		$ptr_ins=mysql_query($insert_cm);
		$comp_id=mysql_insert_id();
		
		$mail = new PHPMailer(true);
	try {
		//$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->SMTPDebug=1;   
		$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'erp.isas@gmail.com';                   // SMTP username
        $mail->Password = 'erp@08isas';                            // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
		$mail->Port = 465;
		
		$mail->setFrom('learn@isasbeautyschool.org', 'ISAS'); 
		if($email !='')
			$mail->addAddress("$email");
		else
			$mail->addAddress("erp.isas@gmail.com");
		
		$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='159'";
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
					$mail->addCC("$data_cnt['email']"); 
					
					$j++;
				}
			}
		}
		$mail->Subject = 'ISAS Complaint Message from '.$name.'';
		$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Compalint / Feedback / Request Messages From '.$name.'</h2></td>
                    </tr></table>';
		$message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%">
					<section style="width:80%;margin:0 auto"><header style="text-align:right;margin-bottom:5px"><img src="http://www.isasbeautyschool.org/faculty_login/images/logo.jpg" style="height:40px" class="CToWUd"></header><article style="border:#e2e2e2 1px solid;border-radius:5px;padding:10px;font-family:Lucida Sans Unicode,Lucida Grande,Tahoma,Verdana,sans-serif!important;font-size:13px!important"><p>Hi There!,</p><div>&nbsp;</div><div>Thank you for contacting isasbeautyschool</div><div>&nbsp;</div><div>This is an automated acknowledgement to inform you that we will respond to your email within 24 hrs.</div><div>&nbsp;</div><div>Please note the Ticket ID for this query is '.$ticket_no.'.</div><div>&nbsp;</div><div>You can view your Order details here:</div><div>&nbsp;</div><div><a href="http://isasbeautyschool.org/complaint/" target="_blank" data-saferedirecturl="http://isasbeautyschool.org/complaint/">http://isasbeautyschool.org/complaint/</a></div><div>&nbsp;</div><div>We appreciate your patience in the interim.</div><div>&nbsp;</div><div><span class="il">Happy</span> <span class="il">isasbeautyschool</span>!</div><div>Customer Success Team</div><div>&nbsp;</div><div><a href="http://isasbeautyschool.org/complaint/" target="_blank" data-saferedirecturl="http://www.isasbeautyschool.com">http://www.isasbeautyschool.com</a></div><div>&nbsp;</div><p></p></article></section>
					</td>
                    </tr></table>';
					
		$sendMessage=$GLOBALS['box_message_top'];
		echo $sendMessage.=$message;
		$sendMessage.=$GLOBALS['box_message_bottom'];
		
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
		//echo "Your complaint is registered. Your ticket no is ".$ticket_no."";
	}
	else
	{
		echo "Enter valid secuirity code";
	}
}
?>
<div class="module form-module">
  <div class="toggle"><i class="fa fa-times fa-pencil"> </i> <span style="font-size:16px;font:weight:800">Click here for previous complaint status...!</span>
    <!--<div class="tooltip">See your complaint status</div>-->
  </div>
  <div class="form">
    <h2>Complaint / Feedback / Request Form</h2>
     <form name="complaint_form" method="post">
      <input type="text" placeholder="Name" name="name" required />
	  <input type="hidden" name="ticket_nos" id="ticket_nos" value="" >
	  <select name="course_id" id="course_id" >  
		<option value=""> Select Course </option>
		<?php
		$course_category = " select category_name,category_id from course_category ";
		$ptr_course_cat = mysql_query($course_category);
		while($data_cat = mysql_fetch_array($ptr_course_cat))
		{
			echo "<optgroup label='".$data_cat['category_name']."'>";
			$get="SELECT course_name,course_id FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
			$myQuery=mysql_query($get);
			while($row1 = mysql_fetch_assoc($myQuery))
			{
				$selected= '';
				if($row_record['course_id']==$row1['course_id'] || $_POST['course_id']==$row1['course_id'] )
				{
					$selected= ' selected="selected" ';
				}		
				?>
					<option value = "<?php echo $row1['course_id']?>" <?php echo $selected;  ?> > <?php echo $row1['course_name'] ?> </option>
			<?php	
			}
			echo " </optgroup>";
		}
		?>
		</select>
		<select name="complaint_type" id="complaint_type" >  
			<option value=""> Select type</option>
			<option value="feedback"> Feedback </option>
			<optgroup label="Complaint">
				<option value="Faculty related"> Faculty related </option>
				<option value="Teaching"> Teaching </option>
				<option value="Fees"> Fees </option>
				<option value="Exam"> Exam </option>
				<option value="Management"> Management </option>
				<option value="Event"> Event </option>
				<option value="Uniform"> Uniform </option>
				<option value="Phone Submission"> Phone Submission </option>
			</optgroup>
			<optgroup label="Request">
				<option value="Leave"> Leave </option>
				<option value="Other"> Other </option>
				<option value="Bonafied"> Bonafied </option>
				<option value="Certificate"> Certificate </option>
				<option value="Photos"> Photos </option>
			</optgroup>
			<option value="testomonial"> Testomonial </option>
			
		</select>
		<input type="text" placeholder="Mobile Number" name="mobile"/>
		<input type="email" placeholder="Email Address" name="email" required />
		<textarea placeholder="Write comment" name="comment"/></textarea>
		<select name="admin_id" id="admin_id" >  
		<option value=""> Select Staff </option>
		<?php
		$sel_name = " select admin_id,name from site_setting ";
		$ptr_name = mysql_query($sel_name);
		while($data_name = mysql_fetch_array($ptr_name))
		{	
			?>
				<option value = "<?php echo $data_name['admin_id']?>" > <?php echo $data_name['name'] ?> </option>
			<?php	
		}
		?>
		</select>
		<img  src="../faculty_login/captcha/captcha.php" id="captcha" height="35px"/>
                                    <img src="../faculty_login/captcha/refresh.png" id="change-image" style="cursor: pointer; padding: 8px 26px;" onClick=			"document.getElementById('captcha').src='../faculty_login/captcha/captcha.php?'+Math.random();">
        <input type="text" placeholder="Enter Security code" name="captcha"/>
      <input type="submit" class="submit_btn" name="submit" value="Register">
    </form>
  </div>
  <div class="form">
    <h2>See your complaint status</h2>
	<form name="submit_ticket" method="get" action="complaint_status.php">
      <input type="text" name="ticket_no" placeholder="Enter Your Ticket No."/>
      <!--<input type="password" placeholder="Password"/>-->
      <input type="submit" name="submit_ticket" value="Submit">
    </form>
  </div>
  <!--<div class="cta"><a href="http://andytran.me">Forgot your password?</a></div>-->
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<!--<script src='https://codepen.io/andytran/pen/vLmRVp.js'></script>-->

    <script  src="js/index.js"></script>
	<script>
			var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
			var string_length = 8;
			var randomstring = '';
			for (var i=0; i<string_length; i++) {
				var rnum = Math.floor(Math.random() * chars.length);
				randomstring += chars.substring(rnum,rnum+1);
			}
			alert("Your Ticket no is "+randomstring+"  \nPlease save it.\nYour complaint is registered.");
			document.getElementById("ticket_nos").value=randomstring;
			
	</script>
</body>
</html>
