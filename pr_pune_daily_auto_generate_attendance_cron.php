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
	$todays_date=date('Y-m-d');
	$monthArray = range(1, 12);
	$currentMonth =date('Y').'-'.date('m').date('d');
	$prv_month=Date('F');//Date('F', strtotime('-1 month',strtotime($currentMonth)));
	$prv_month1=Date('m');//Date('m', strtotime('-1 month',strtotime($currentMonth)));
	$month=$prv_month1;
	
	$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
	
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
	
	$select_att="select DISTINCT(UserID) from pr_pune_biometric_attendance where cm_id='".$cm_id."' and ServiceTagId='".$service_tag_id."' and year='".$year."' and month='".$month."' and DATE(PunchTime)='".$todays_date."' order by UserID asc ";
	$ptr_att=mysql_query($select_att);
	while($data_atte=mysql_fetch_array($ptr_att))
	{
		$staff_att_id=$data_atte['UserID'];
		
		$sel_admin="select admin_id from site_setting where attendence_id='".$staff_att_id."' and cm_id='".$cm_id."'";
		$ptr_admin_id=mysql_query($sel_admin);
		$data_admin_id=mysql_fetch_array($ptr_admin_id);
		$employee_id=$data_admin_id['admin_id'];
		
		$currentMonth =$year.'-'.$month.'-01';
		$pr_month=Date('Y-m-d',strtotime($currentMonth));
		$first_day_this_month='01-'.$month.'-'.$year;
		$last_day_this_month=$days.'-'.$month.'-'.$year;
		$curr_date='';
		$total_day =0;
		//for($i=1;$i<=$days;$i++)
		//{
			/*if($i<10)
			{
				$d='0'.$i;
			}
			else
			{
				$d=$i;
			}
			$curr_date=$year.'-'.$month.'-'.$d;*/
		$sel_staff="select name,attendence_id from site_setting where attendence_id='".$data_atte['UserID']."' and cm_id='".$cm_id."'";
		$ptr_staff1 = mysql_query($sel_staff);
		if(mysql_num_rows($ptr_staff1))
		{	
			$select_user="select * from pr_pune_biometric_attendance where cm_id='".$cm_id."' and ServiceTagId='".$service_tag_id."' and year='".$year."' and month='".$month."' and UserID='".$data_atte['UserID']."' and DATE(PunchTime)='".$todays_date."' order by PunchTime asc";
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
					$ins_attendace="INSERT INTO `pr_daily_attendance`(`employee_id`,`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$employee_id."','".$staff_att_id."','".$year."','".$month."','".$days."','".$todays_date."','".$in."','".$out."','".$punch_in."','".$punch_out."','".$hrs_min."','".$extra_hr."','".$branch_name1."','".$full_day."','".$half_day."','".$quarter_day."','".$onethird_day."','".$day_tot."','".$total_day."','".$late_m."','0','69','".$cm_id."')";
					$ptr_ins=mysql_query($ins_attendace);
					echo "<br/>-> ".$ins=mysql_insert_id();
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
				$insert_attendace="INSERT INTO `pr_daily_attendance`(`employee_id`,`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$employee_id."','".$staff_att_id."','".$year."','".$month."','".$days."','".$todays_date."','','','','','','','Pune','  ','  ','  ','  ','0','0',' ','0','69','".$cm_id."')";
				$ptr_insert=mysql_query($insert_attendace);
				//}
			}
		}
	}

$message='<style>.table1, .th1, .td1 { border: 1px solid; border-collapse: collapse; padding: 4px; font-size:12px;}.td2 { text-align:center;
}input { text-align:center; }</style>';
//$message .='<hr></br>';

$select_exc="select * from pr_daily_attendance where DATE(date)='".$todays_date."' and month='".$month."' AND year='".$year."' AND cm_id='".$cm_id."' group by staff_id";
$ptr_fs = mysql_query($select_exc);

/*$payment_done ="select * from pr_staff_salary_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."' AND branch_name='".$_REQUEST['branch_name']."' AND payment_action=1";
$payment = mysql_query($payment_done);
if(mysql_num_rows($payment))
{
	$disable="disabled";
	$msg="**** Salary Allready Done ****";
}
else
{
	$disable="";	
}*/

if(mysql_num_rows($ptr_fs)) 
{
	$message .='<p style="color:green;font-size:15px;"><b>'.$msg.'</b></p>
	<table id="example" class="table1" width="95%" cellspacing="2" cellpadding="2" width="100%" style="margin-left: 0px;border:1px solid #999">
        <thead>
            <tr bgcolor="#EBEBEB">
				<th class="th1" align="center" style="border:1px solid #CCC">Sr. No</th>
                <th class="th1" align="center" style="border:1px solid #CCC">Staff Name</th>
                <th class="th1" align="center" style="border:1px solid #CCC">Punch In</th>
                <th class="th1" align="center" style="border:1px solid #CCC">Punch Out</th>
                <th class="th1" align="center" style="border:1px solid #CCC">Total Hrs</th>
            </tr>
	</thead>
	<tbody>	';
	
	$t=1;
	while($val_query1 = mysql_fetch_array($ptr_fs))
	{ 
		$staff="select name,attendence_id from site_setting where attendence_id='".$val_query1['staff_id']."' and cm_id='".$cm_id."' ";
		$staff1 = mysql_query($staff);
		if(mysql_num_rows($staff1))
		{
			$staff_name = mysql_fetch_array($staff1);
		
			/*$message .='<tr>
			<td class="td1 td2" colspan="17" align="center" style="border:1px solid #CCC;background-color:#F2F2F2;" ><b style="color:green;font-size:14px;float:left;">'.$staff_name['name'].'</b></td></tr>';*/
			
			/*$year=$_REQUEST['year'];
			$month=$_REQUEST['month'];
			$currentMonth =$year.'-'.$month.'-01';
			$pr_month=Date('M',strtotime($currentMonth));
			$first_day_this_month='01-'.$pr_month.'-'.$year;
			$last_day_this_month=$val_query1['days'].'-'.$pr_month.'-'.$year;
			
			$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31*/
			
			$tot_seconds = 0;
			$ex_seconds=0;
			$tot_full_day=0;
			$tot_half_day=0; 
			$tot_quarter_day=0; 
			$tot_onethird_day=0;
			$tot_present_day=0;
			$day_totals=0;
			/*for($i=1;$i<=$days;$i++)
			{
			if($i<10)
			{
				$d='0'.$i;
			}
			else
			{
				$d=$i;
			}*/
			//$curr_date=$year.'-'.$month.'-'.$d;
			//$pr_month=Date('M',strtotime($curr_date));
			
			$select_exc1 ="select * from pr_daily_attendance where DATE(date)='".$todays_date."'  AND staff_id='".$val_query1['staff_id']."' AND month='".$month."' AND year='".$year."' AND cm_id='".$cm_id."' order by staff_id,date asc";
			$ptr_fs1 = mysql_query($select_exc1);
			$tot_present_day +=mysql_num_rows($ptr_fs1);
			$val_query = mysql_fetch_array($ptr_fs1);
			
			$date =$todays_date;
			
			$att_date=date("d-M-Y", strtotime($todays_date));//$d.'-'.$pr_month.''.$year;
			//Set this to FALSE until proven otherwise.
			$weekendDay = false;
			//Get the day that this particular date falls on.
			$day = date("D", strtotime($date));
			//Check to see if it is equal to Sat or Sun.
			if($day == 'Sun'){
				//Set our $weekendDay variable to TRUE.
				//$weekendDay = true;
				$datestyle="style='background-color:#FF6262;'";
			}
			else if($day == 'Sat'){
				//Set our $weekendDay variable to TRUE.
				//$weekendDay = true;
				$datestyle="style='background-color:#FBF882;'";
			}
			else{
				$datestyle="";
			}
			
			$message .='<tr bgcolor="#DCF0F8">
				<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$t.'</td>
				<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$staff_name['name'].'</td>
				<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$val_query['punch_in'].'</td>
				<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$val_query['punch_out'].'</td>
				<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$val_query['total_hrs'].'<input type="hidden" name="floor_id'.$t.'" id="floor_id'.$t.'" value="'.$val_query['attendance_id'].'" /><input type="hidden" name="days" id="days" value="'.$val_query['days'].'" /><input type="hidden" name="floor_id'.$t.'" id="floor_id'.$t.'" value="'.$val_query['attendance_id'].'" /><input type="hidden" name="days" id="days" value="'.$val_query['days'].'" /></td>';
				
                if($val_query['late_marks']==0) $lt=''; else  $lt=$val_query['late_marks']; 
				
				/*$message .='<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.' id="chk_late_mark_'.$val_query['attendance_id'].'"><div ondblclick="return editColumn('.$val_query['attendance_id'].',"late_mark")" id="edit_late_mark_'.$val_query['attendance_id'].'">'.$lt.'&nbsp;&nbsp;&nbsp;</div></td>';*/
				//$tot_hr +=$val_query['total_hrs'];
				$tot_hr=$val_query['total_hrs'].':00';
				$extra_hr =$val_query['extra_hrs'].':00';
				$day_totals +=$val_query['day_total']; 
				$total_till_date=$val_query['total_till_date'];
				$tot_late_mark +=$val_query['late_marks'];
				//======Total hours========			  	
				list($hour,$minute,$second) = explode(':', $tot_hr);
				$tot_seconds += $hour*3600;
				$tot_seconds += $minute*60;
				$tot_seconds += $second;
				//======Extra Hours====
				list($exhour,$exminute,$exsecond) = explode(':', $extra_hr);
				$ex_seconds += $exhour*3600;
				$ex_seconds += $exminute*60;
				$ex_seconds += $exsecond;
				//========TOTAL Full DAY====
				if($val_query['full_day']!='')
				{
					$tot_full_day +=1;
				}
				//========TOTAL Half DAY====
				if($val_query['half_day']!='')
				{
					$tot_half_day +=1;
				}
				//========TOTAL Quarter DAY====
				if($val_query['quarter_day']!='')
				{
					$tot_quarter_day +=1;
				}
				//========TOTAL OneThird DAY====
				if($val_query['one_third']!='')
				{
					$tot_onethird_day +=1;
				}
				
				//$message .='';
			$message .='</tr>';
			 
			$t++;
			//}
			//=====Calc Total Hours=======
			$tohours = floor($tot_seconds/3600);
			$tot_seconds -= $tohours*3600;
			$tominutes  = floor($tot_seconds/60);
			$tot_seconds -= $tominutes*60;
			$tot_hours="{$tohours}:{$tominutes}:{$tot_seconds}";
			//=====Calc Extra hours=======
			$ext_hours = floor($ex_seconds/3600);
			$ex_seconds -= $ext_hours*3600;
			$ext_minutes  = floor($ex_seconds/60);
			$ex_seconds -= $ext_minutes*60;
			$extra_hours="{$ext_hours}:{$ext_minutes}:{$ex_seconds}";
			
			/*$message .='<tr bgcolor="#C7DAF1">
				<td align="center" style="border:1px solid #CCC" class="td1 td2" colspan="3">Total</td>
				<td align="center" style="border:1px solid #CCC" class="td1 td2">'.$tot_hours.'</td>';*/
				//$message .='';
			//$message .='</tr>';
		}
	}
	$message .='</tbody></table>';
}
else 
{ 
	$message .='<p Style="font-size:20px;color:red;">No Record Found</p>';
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
			$mail->addCC("cm.kp@isasbeautyschool.com"); 
			//$mail->addCC("cm.kp@isasbeautyschool.com"); 
			//$mail->addCC("kaustubh@isasbeautyschool.com"); 
						
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
			$mail->Subject = 'ISAS Pune Daily Attendace is generated for '.date('Y-m-d').'';
			//$message='Hi, <br/>I would like to inform you that <b>"ISAS Pune"</b> Attendance is generated by system automatically for month '.$prv_month.' '.$year.' . Please check.';
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
	//===============================================================================
	
?>
</body>
</html>
<?php $db->close();?>