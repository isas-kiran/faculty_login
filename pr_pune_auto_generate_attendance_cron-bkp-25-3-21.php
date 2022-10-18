<?php include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title id="title">Pune Auto Generate Attendance</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>

    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script> 
    <script>
	$(document).ready(function()
    {
		$("#year").chosen({allow_single_deselect:true});
		$("#month").chosen({allow_single_deselect:true});
		$("#staff_id").chosen({allow_single_deselect:true});
	});
	</script>  
</head>
<body>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<?php
	$branch_name='Pune';
	$year=date('Y');
	
	$monthArray = range(1, 12);
	$currentMonth =date('Y').'-'.date('m').'-01';
	$prv_month=Date('F', strtotime('-1 month',strtotime($currentMonth)));
	$prv_month1=Date('m', strtotime('-1 month',strtotime($currentMonth)));
	$month=$prv_month1;
	
	$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
	/*$cm_id='0';
	if($_SESSION['type']=='S')
	{
		$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
		$ptr_branch=mysql_query($sel_branch);
		$data_branch=mysql_fetch_array($ptr_branch);
		$cm_id=$data_branch['cm_id'];
		$branch_name1=$branch_name;
	}	
	else
	{
		$branch_name1=$_SESSION['branch_name'];
		$cm_id=$_SESSION['cm_id'];
	}*/
	$branch_name1='Pune';
	$cm_id=2;
	
	$sel_serv_id="select service_tag_id from biometric_device where cm_id='".$cm_id."'";
	$ptr_serv_id=mysql_query($sel_serv_id);
	$data_serv_id=mysql_fetch_array($ptr_serv_id);
	$service_tag_id=$data_serv_id['service_tag_id'];
	
	/*$whr_staff_id="";
	if($staff_id>0)
	{
		$whr_staff_id=" and UserID='".$staff_id."'";
	}*/
	
	$select_att="select DISTINCT(UserID) from pr_pune_biometric_attendance where cm_id='".$cm_id."' and ServiceTagId='".$service_tag_id."' and year='".$year."' and month='".$month."' order by UserID asc ";
	$ptr_att=mysql_query($select_att);
	while($data_atte=mysql_fetch_array($ptr_att))
	{
		$staff_att_id=$data_atte['UserID'];
		$currentMonth =$year.'-'.$month.'-01';
		$pr_month=Date('Y-m-d',strtotime($currentMonth));
		$first_day_this_month='01-'.$month.'-'.$year;
		$last_day_this_month=$days.'-'.$month.'-'.$year;
		$curr_date='';
		$total_day =0;
		for($i=1;$i<=$days;$i++)
		{
			if($i<10)
			{
				$d='0'.$i;
			}
			else
			{
				$d=$i;
			}
			$curr_date=$year.'-'.$month.'-'.$d;
			
			$select_user="select * from pr_pune_biometric_attendance where cm_id='".$cm_id."' and ServiceTagId='".$service_tag_id."' and year='".$year."' and month='".$month."' and UserID='".$data_atte['UserID']."' and DATE(PunchTime)='".$curr_date."' order by PunchTime asc";
			$ptr_chk_ext=mysql_query($select_user);
			if($tot=mysql_num_rows($ptr_chk_ext))
			{
				$c_in=0;
				$c_out=0;
				$tot_ckout=0;
				$tot_hrs=0;
				$curr_date='';
				$t=0;
				$check_in=array();
				$check_out=array();
				$hrs_min='';
				$ints=0;
				$in_ts='';
				$out_ts='';
				$punch_out='';
				$punch_in='';
				while($data_user_att=mysql_fetch_array($ptr_chk_ext))
				{
					$curr_date=$data_user_att['PunchTime'];
					if($data_user_att['AttendanceType']=='CheckIn')
					{
						$check_in[$c_in] = strtotime($data_user_att['PunchTime']);
						if($ints<=0) //check 1st of record PUNCH IN only
						{
							$in_ts= date('H:i',strtotime($data_user_att['PunchTime'])); // for inserting in DB
							$ints=1;
						}
						$c_in++;
					}
					else if($data_user_att['AttendanceType']=='CheckOut')
					{
						$check_out[$c_out] =strtotime($data_user_att['PunchTime']);
						$out_ts=date('H:i',strtotime($data_user_att['PunchTime']));// for inserting in DB
						$c_out++;
						$tot_ckout++;
					}							
					$t++;
				}
				if($out_ts)
				{
					$punch_out=$out_ts;//date('H:i',$check_out[$chk]);
				}
				if($in_ts)
				{
					$punch_in=$in_ts;//date('H:i',$check_in[$chk]);
				}
				//echo "<br/> totals-  ".$tot_ckout;
				$late_m =0;
				$day_tot=0;
				$e_h=0;
				$extra_hr=0;
				$full_day='';
				$onethird_day='';
				$half_day='';
				$quarter_day='';
				for($chk=0;$chk<$tot_ckout;$chk++)
				{
					$out=$check_out[$chk];
					$in=$check_in[$chk];
					if($out >0 && $in >0)
					{
						$tot_hrs +=($out - $in);
						$hrs_min=gmdate("H:i", $tot_hrs);
						if($tot_hrs > 32400)
						{
							$e_h=intval($tot_hrs - 32400);
							$extra_hr=gmdate("H:i", $e_h);
						}
						
						if($tot_hrs < 31500 && $tot_hrs >=30600)
						{
							$late_m=1;
						}
						if($tot_hrs >= 31500)
						{
							$full_day='P';
							$day_tot=1;
							$total_day +=1;
						}
						if($tot_hrs >= 21600 && $tot_hrs < 31500)
						{
							$onethird_day='P';
							$day_tot=0.75;
							$total_day +=0.75;
						}
						if($tot_hrs >= 14500 && $tot_hrs < 21600)
						{
							$half_day='P';
							$day_tot=0.5;
							$total_day +=0.5;
						}
						if($tot_hrs <= 14500)
						{
							$quarter_day='P';
							$day_tot=0.25;
							$total_day +=0.25;
						}
					}							
				}
				if($tot==$t)
				{
					//insert in DB for present user
					/*echo "<br/>1-->".$sel_from=" select attendance_id from `pr_import_attendance` where `staff_id`='".$staff_att_id."' and `year`='".$year."' and `month`='".$month."' and date='".$curr_date."' and cm_id='".$cm_id."' ";
					$ptr_frm=mysql_query($sel_from);
					if(mysql_num_rows($ptr_frm))
					{
						echo "<br/>2----->".$update_att="UPDATE `pr_import_attendance` SET `days`='".$days."', `date`='".$curr_date."', `punch_in_timestamp`='".$in."', `punch_out_timestamp`='".$out."',`punch_in`='".$punch_in."', `punch_out`='".$punch_out."', `total_hrs`='".$hrs_min."', `extra_hrs`='".$extra_hr."', `branch_name`='".$branch_name1."', `full_day`='".$full_day."', `half_day`='".$half_day."', `quarter_day`='".$quarter_day."', `one_third`='".$onethird_day."',`day_total`='".$day_tot."', `total_till_date`='".$total_day."',`late_marks`='".$late_m."', `extra_days`='0', `admin_id`='".$_SESSION['admin_id']."', `cm_id`='".$cm_id."' where `staff_id`='".$staff_att_id."' and `year`='".$year."' and `month`='".$month."' and cm_id='".$cm_id."'";
						$ptr_insert=mysql_query($update_att);
					}
					else
					{*/
						$ins_attendace="INSERT INTO `pr_import_attendance`(`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$staff_att_id."','".$year."','".$month."','".$days."','".$curr_date."','".$in."','".$out."','".$punch_in."','".$punch_out."','".$hrs_min."','".$extra_hr."','".$branch_name1."','".$full_day."','".$half_day."','".$quarter_day."','".$onethird_day."','".$day_tot."','".$total_day."','".$late_m."','0','69','".$cm_id."')";
					$ptr_ins=mysql_query($ins_attendace);
					//}
				}
			}
			else			//insert absent record in database
			{
				/*$sel_from=" select attendance_id from `pr_import_attendance` where `staff_id`='".$staff_att_id."' and `year`='".$year."' and `month`='".$month."' and date='".$curr_date."' and cm_id='".$cm_id."' ";
				$ptr_frm=mysql_query($sel_from);
				if(mysql_num_rows($ptr_frm))
				{
					$update_att="UPDATE `pr_import_attendance` SET `days`='".$days."', `date`='".$curr_date."',`punch_in_timestamp`='', `punch_out_timestamp`='',`punch_in`='',`punch_out`='',`total_hrs`='',`extra_hrs`='',`branch_name`='".$branch_name1."',`full_day`='  ', `half_day`='  ',`quarter_day`='  ',`one_third`='  ',`day_total`='0', `total_till_date`='0',`late_marks`='  ', `extra_days`='0', `admin_id`='69', `cm_id`='".$cm_id."' where `staff_id`='".$staff_att_id."' and `year`='".$year."' and `month`='".$month."' and cm_id='".$cm_id."'";
					$ptr_insert=mysql_query($update_att);
				}
				else
				{*/
				$insert_attendace="INSERT INTO `pr_import_attendance`(`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$staff_att_id."','".$year."','".$month."','".$days."','".$curr_date."','','','','','','','Pune','  ','  ','  ','  ','0','0',' ','0','69','".$cm_id."')";
				$ptr_insert=mysql_query($insert_attendace);
				//}
			}
		}
	}
	
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
			$mail->addCC("santosh.sapke@gmail.com"); 
			
			/*$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='103' and cm_id='".$cm_id1."'";
			$ptr_sel_sms=mysql_query($sel_sms_cnt);
			$tot_num_rows=mysql_num_rows($ptr_sel_sms);
			$i=0;
			while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
			{
				$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' and type!='S' ";
				$ptr_cnt=mysql_query($sel_act);
				if(mysql_num_rows($ptr_cnt))
				{
					$data_cnt=mysql_fetch_array($ptr_cnt);
					$emailss=trim($data_cnt['email']);
					$mail->addCC("$emailss"); 
					$i++;
				}
			}*/
			
			/*echo"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' and email!='' ";
			$ptr_cnt=mysql_query($sel_act);
			if(mysql_num_rows($ptr_cnt))
			{
				$j=$tot_num_rows;
				while($data_cnt=mysql_fetch_array($ptr_cnt))
				{
					$email2=trim($data_cnt['email']);
					$mail->addCC("$email2"); 
					$j++;
				}
			}*/
			
			///usr/local/bin/php -q /home/isasadmin007/isastest/faculty_login/dsr_mail.php?&send_mail=mail
			///bin/touch /home/isasadmin007/public_html/cron_test.txt >/dev/null 2>&1 && /bin/echo "Cron ran at: `date`" >> /home/isasadmin007/public_html/cron_test.txt
			$mail->Subject = 'ISAS Pune Attendace is generated for Month '.$prv_month.' '.$year.'';
			$message='Hi, <br/>I would like to inform you that <b>"ISAS Pune"</b> Attendance is generated by system automatically for month '.$prv_month.' '.$year.' . Please check.';
			$sendMessage=$GLOBALS['box_message_top'];
			$sendMessage.=$message;
			$sendMessage.=$GLOBALS['box_message_bottom'];
			
			$mail->WordWrap = 3000; 
			$mail->isHTML(true);                                  
			$mail->Body =$sendMessage;
			 
			$mail->Send();
			echo "Email Sent Successfully.";
		} catch (phpmailerException $e) {
		  echo $e->errorMessage(); 
		} catch (Exception $e) {
		  echo $e->getMessage(); 
		}	
	//===============================================================================
	
?>
</body>
</html>
<?php $db->close();?>