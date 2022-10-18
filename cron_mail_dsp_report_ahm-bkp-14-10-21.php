<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSP Report Mail</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>

    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
</head>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<script>
function getErrorMessage(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    alert(msg);
}
</script>
<body>
<?php
	$branch_id= "and cm_id='60'";
	$cm_id1= '60';
		
	/*$getDate=" and DATE(added_date) ='".date('Y-m-d')."'"; 
	$followup_date=" and DATE(followup_date) ='".date('Y-m-d')."' ";*/
	
	/*$todays_date=date('Y-m-d');
	if($_REQUEST['on_date'] && $_REQUEST['on_date']!=="0000-00-00" && $_REQUEST['on_date']!="From Date")
	{
		$frm_date=explode("/",$todays_date);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$date_for_month=$frm_date[2]."-".$frm_date[1];
		$start_date=$frm_dates;
		$added_date=" and DATE(added_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$dsr_added_date=" and DATE(dsr_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$added_date_i=" and DATE(i.added_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$added_f_date=" and DATE(followup_date) ='".date('Y-m-d',strtotime($frm_dates))."' ";
		$end_added_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates . '-4 month'))."'"; //date('Y-m-d',strtotime('-1 days'))
		$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates . '-4 month'))."' ";
		$end_followup_date=" and DATE(followup_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$end_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$last_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime($frm_dates . "last day of this month"))."'";
		$from_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($frm_dates . "first day of previous month"))."'";
		$to_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($frm_dates . "last day of previous month"))."'";
		$to_last_day_of_current_month= " and DATE(added_date) <='".date("Y-m-d", strtotime($frm_dates . "last day of this month"))."'";
		$first_day_of_current_month=" and DATE(added_date) >='".date("Y-m-d", strtotime($frm_dates . "first day of this month"))."'";
		$secondlastmonth = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $frm_dates ) )) ;
		$from_second_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($secondlastmonth . "first day of previous month"))."'";
		$to_second_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($secondlastmonth . "last day of previous month"))."'";
		$from_thirty_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates . '-30 days'))."'"; //
	}
	else
	{*/
		$added_f_date=" and DATE(followup_date) ='".date('Y-m-d')."'";
		$added_date=" and DATE(added_date) ='".date('Y-m-d')."'";
		$dsr_added_date=" and DATE(added_date) ='".date('Y-m-d')."'";
		$added_date_i=" and DATE(i.added_date) ='".date('Y-m-d')."'";
		$end_added_date=" and DATE(added_date) <='".date('Y-m-d')."'";
		$date_for_month=date('Y-m');
		$date=date('Y-m-d');
		$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-4 month'))."'"; //date('Y-m-d',strtotime('-1 days'))
		$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d')."' ";
		$end_followup_date=" and DATE(followup_date) <='".date('Y-m-d')."'";
		$end_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d')."'";
		$last_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime("last day of this month"))."'";
		$from_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime("first day of previous month"))."'";
		$to_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime("last day of previous month"))."'";
		$to_last_day_of_current_month= " and DATE(added_date) <='".date("Y-m-d", strtotime("last day of this month"))."'";
		$first_day_of_current_month=" and DATE(added_date) >='".date("Y-m-d", strtotime("first day of this month"))."'";
		$secondlastmonth = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $date ) )) ;
		$from_second_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($secondlastmonth . "first day of previous month"))."'";
		$to_second_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($secondlastmonth . "last day of previous month"))."'";
		$from_thirty_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-30 days'))."'"; //
	//}
	
		
	$sel_branch_name="select branch_name from site_setting where cm_id=".$cm_id1." and type='A'";
	$ptr_branch_name=mysql_query($sel_branch_name);
	$data_branch=mysql_fetch_array($ptr_branch_name);
	$branch_name=" For ".$data_branch['branch_name']." branch";
	
$message.=  '<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">'; 
			$select_directory='order by name asc';
			               
			/*$sql_query= "select * from site_setting where 1 and system_status='Enabled' ".$branch_id."  ".$pre_keyword." ".$select_directory.""; 
			$ptr_db=mysql_query($sql_query);
			$no_of_records=mysql_num_rows($ptr_db);*/
			
			
			
			$message.='<tr>
			<td colspan="10" >
				<table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 					<tr class="grey_td">
						<td width="2%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Field Name</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$data_couc['name'].'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>1</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Fresh Lead Assign</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_enquiry="select inquiry_id from inquiry where 1 and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."'  ".$added_date." ";
							$query_enquiery=mysql_query($select_enquiry);
							$count_enquiry=mysql_num_rows($query_enquiery);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_enquiry.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>2</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of leads given by L.D.</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sql_query="SELECT * FROM inquiry where 1 and campaign_type='lead_distribution' and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."'  ".$added_date." ";
							$ptr_query=mysql_query($sql_query);
							$tota_ld_lead=mysql_num_rows($ptr_query);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$tota_ld_lead.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>3</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Fresh Call Done</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_enq_cnt="select inquiry_id from inquiry where 1 and (followup_date !='' or followup_date is NOT NULL) and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date." ";
							$query_enq_cnt=mysql_query($select_enq_cnt);
							$count_enq_called=mysql_num_rows($query_enq_cnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_enq_called.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>4</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total followup Call Done</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_tot_called="select followup_id from followup_details where 1 and admin_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date." ";
							$query_tot_called=mysql_query($select_tot_called);
							$tot_foll_called=mysql_num_rows($query_tot_called);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$tot_foll_called.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>5</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total Salon followup Call Done</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$salon_tot_called="select followup_id from service_followup_details where 1 and admin_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date." ";
							$salon_tot_called=mysql_query($salon_tot_called);
							$salon_foll_called=mysql_num_rows($salon_tot_called);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$salon_foll_called.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>6</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Career-consultant calls</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$message.='<td align="center" style="border:1px solid #CCC"><strong>0</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>7</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Any other tieups calls</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$message.='<td align="center" style="border:1px solid #CCC"><strong>0</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>8</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total Calls done</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$message.='<td align="center" style="border:1px solid #CCC"><strong>0</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>9</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Cousnseling done Today</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_enq_walkin="select DISTINCT(student_id) from followup_details where response='1' and admin_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date." ";
							$query_enq_walkin=mysql_query($select_enq_walkin);
							$count_enq_walkin=mysql_num_rows($query_enq_walkin);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_enq_walkin.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>10</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of cousnseling done till date (Monthly)</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."'  order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$monthly_enq_walkin="select DISTINCT(student_id) from followup_details where 1 and response='1' and admin_id='".$data_couc['admin_id']."'and cm_id='".$cm_id1."' and DATE(`added_date`) >= '".$date_for_month."-01'  ".$end_added_date." ";
							$mont_enq_walkin=mysql_query($monthly_enq_walkin);
							$count_month_walkin=mysql_num_rows($mont_enq_walkin);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_month_walkin.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>11</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Enrollments done today</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."'  order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_inst="select enroll_id from enrollment where 1 and ref_id='0' and assigned_to='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date." ";
							$query_inst=mysql_query($select_inst);
							$count_enroll=mysql_num_rows($query_inst);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_enroll.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>12</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Enrollments till date (Monthly)</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_enroll="select enroll_id from enrollment where 1 and ref_id='0' and assigned_to='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' and DATE(`added_date`) >= '".$date_for_month."-01'  ".$end_added_date." ";
							$query_enroll=mysql_query($select_enroll);
							$count_monthly_enroll=mysql_num_rows($query_enroll);
							$message.='<td align="center" style="border:1px solid #CCC"><strong><?php echo $count_monthly_enroll; ?></strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>13</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Upgrade Done Today</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_enroll="select enroll_id from enrollment where 1 and ref_id!='0' and assigned_to='".$data_couc['admin_id']."' and cm_id='".$cm_id1."'  ".$added_date." ";
							$query_enroll=mysql_query($select_enroll);
							$count_monthly_enroll=mysql_num_rows($query_enroll);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_monthly_enroll.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>14</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Upgrade Done Till Date (Monthly)</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_enroll="select enroll_id from enrollment where 1 and ref_id!='0' and assigned_to='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' and DATE(`added_date`) >= '".$date_for_month."-01'  ".$end_added_date." ";
							$query_enroll=mysql_query($select_enroll);
							$count_monthly_enroll=mysql_num_rows($query_enroll);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_monthly_enroll.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>15</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Pending Followups since last 4 months</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_exst_foll="SELECT * FROM inquiry where 1 and status = 'Enquiry' and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' <strong></strong> and (response !='7' and response!='8' or response is NULL) ".$followup_from_date." ".$end_followup_date." order by inquiry_id desc";
							$ptr_exst_foll=mysql_query($sel_exst_foll);
							$total_foll=mysql_num_rows($ptr_exst_foll);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.round($count_monthly_enroll,2).'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>16</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Invalid leads done Today</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_inv="select DISTINCT(student_id) from followup_details where 1 and response='8' and admin_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date."";
							$query_inv=mysql_query($select_inv);
							$count_invalid=mysql_num_rows($query_inv);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'. round($count_invalid,2).'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>17</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Not Interested leads done Today</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_ni="select DISTINCT(student_id) from followup_details where 1 and response='7' and admin_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date."";
							$query_ni=mysql_query($select_ni);
							$count_ni=mysql_num_rows($query_ni);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.round($count_ni,2).'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>18</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Todays Realised Amount</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled'  and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_real_amnt="select SUM(amount) as total_amnt from invoice where 1 and assigned_to='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date." ";
							$query_real_amnt=mysql_query($sel_real_amnt);
							$data_real_amnt=mysql_fetch_array($query_real_amnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($data_real_amnt['total_amnt'] > 0) 
							{
								$message.=round($data_real_amnt["total_amnt"],2);
							}
							else 
							{
								$message.='0'; 
							}
							$message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>19</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Amount Realised Till Date</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_real_month_amnt="select SUM(amount) as total_amnt from invoice where 1 and assigned_to='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$end_added_date." ";
							$query_real_month_amnt=mysql_query($sel_real_month_amnt);
							$data_real_month_amnt=mysql_fetch_array($query_real_month_amnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($data_real_month_amnt['total_amnt'] >0) 
							{
								$message.= round($data_real_month_amnt['total_amnt'],2);
							}
							else $message.='0';
                             $message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>20</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Recovery for this Month</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' and e.cm_id='".$cm_id1."'  and DATE(i.installment_date) >= '".$date_for_month."-01'  ".$last_installment_date_i." ";
							$query_recv_amnt=mysql_query($sel_recv_amnt);
							$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($data_recv_amnt['total_amnt'] > 0 ) 
							{
								$message.=round($data_recv_amnt['total_amnt'],2); 
							}
							else $message.=0;
							$message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>21</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Recovery Realised For This Month Till Date</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_rel_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' and e.cm_id='".$cm_id1."'  and DATE(i.installment_date) >= '".$date_for_month."-01'  ".$end_installment_date_i." ";
							$query_rel_amnt=mysql_query($sel_rel_amnt);
							$data_rel_amnt=mysql_fetch_array($query_rel_amnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($data_rel_amnt['total_amnt'] > 0) 
							{
								$message.=round($data_rel_amnt['total_amnt'],2); 
							}
							else $message.='0';
							$message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>22</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Recovery Pending of Last Month</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' and e.cm_id='".$cm_id1."' ".$from_last_installment_month." ".$to_last_installment_month." ";
							$query_recv_amnt=mysql_query($sel_recv_amnt);
							$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($data_recv_amnt['total_amnt']) 
							{
								$message.= round($data_recv_amnt['total_amnt'],2); 
							}
							else $message.='0'; 
							$message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>23</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Recovery Pending of Second Last Month</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' and e.cm_id='".$cm_id1."' ".$from_second_last_installment_month." ".$to_second_last_installment_month." ";
							$query_recv_amnt=mysql_query($sel_recv_amnt);
							$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($data_recv_amnt['total_amnt']) 
                            {
                            	$message.=round($data_recv_amnt['total_amnt'],2); 
                            }
                            else $message.='0';
                            $message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>24</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Recovery Pending Since Before Second Last Month</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' and e.cm_id='".$cm_id1."' ".$from_second_last_installment_month." ".$end_installment_date_i." ";
							$query_recv_amnt=mysql_query($sel_recv_amnt);
							$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($data_recv_amnt['total_amnt'])
							{
								$message.=round($data_recv_amnt['total_amnt'],2);
							}
							else $message.='0'; 
							
							$message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>25</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Very Hot Leads (Last 30 days)</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_vh="select inquiry_id from inquiry where 1 and lead_grade='very_hot' and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$from_thirty_date." ".$end_added_date." ";
							$query_vh=mysql_query($select_vh);
							$count_vh=mysql_num_rows($query_vh);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($count_vh)
							{
								echo round($count_vh,2);
							}
							else $message.='0'; 
							$message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>26</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of  Hot Leads (Last 30 days)</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_hot="select inquiry_id from inquiry where 1 and lead_grade='hot' and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$from_thirty_date." ".$end_added_date." ";
							$query_hot=mysql_query($select_hot);
							$count_hot=mysql_num_rows($query_hot);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.round($count_hot,2).'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>27</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Warm Leads (Last 30 days)</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_warm="select inquiry_id from inquiry where 1 and lead_grade='warm' and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$from_thirty_date." ".$end_added_date." ";
							$query_warm=mysql_query($select_warm);
							$count_warm=mysql_num_rows($query_warm);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>';
							if($count_warm)
							{
								$message.= round($count_warm,2);
							}
							else $message.='0'; 
							$message.='</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>28</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Booking Amount Funnel (Last 30 Days)</strong></td>';
						$array = array();
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$crs_price ='';
							$select_ni="select course_id from inquiry where 1 and (lead_grade='very_hot' or lead_grade='hot') and employee_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$from_thirty_date." ".$to_last_day_of_current_month." ";
							$query_ni=mysql_query($select_ni);
							if($count_ni=mysql_num_rows($query_ni))
							{
								$data_course_id=mysql_fetch_array($query_ni);
								$select_price="select course_price from courses_price where course_id='".$data_course_id['course_id']."'";
								$ptr_crs=mysql_query($select_price);
								$data_crs_price=mysql_fetch_array($ptr_crs);
								$crs_price +=$data_crs_price['course_price'];
								$message.='<td align="center" style="border:1px solid #CCC"><strong>'.round($crs_price,2).'</strong></td>';
							}
							else
							{
								$message.='<td align="center" style="border:1px solid #CCC"><strong>0</strong></td>';
							}
							
							$sel_tot="select enroll_id,net_fees from enrollment where 1 and assigned_to='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$first_day_of_current_month." ".$to_last_day_of_current_month." ";
							$ptr_tots=mysql_query($sel_tot);
							$tot_num=mysql_num_rows($ptr_tots);
							while($data_tot=mysql_fetch_array($ptr_tots))
							{
								$sle_inv="select SUM(amount) as total_amnt from invoice where 1 and enroll_id='".$data_tot['enroll_id']."' and cm_id='".$cm_id1."' ".$first_day_of_current_month." ".$to_last_day_of_current_month." ";
								$ptr_inv=mysql_query($sle_inv);
								$data_inv=mysql_fetch_array($ptr_inv);
								$course_fee=$data_tot['net_fees'];
								$paid_amount=$data_inv['total_amnt'];
								$cal_per=number_format(($paid_amount / $course_fee)*100,2);
								$tot_per +=$cal_per;
							}
							$month_enroll_perc=number_format($tot_per / $tot_num,2);
							$realised_funnel= $month_enroll_perc * $crs_price / 100 ;
							array_push($array, $realised_funnel);
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>29</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Realised Amount Funnel</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled'  and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						$i=0;
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.round($array[$i],2).'</strong></td>';
							$i++;
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>30</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No of Student Review</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled'  and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$select_rev="select * from action_final i, enrollment e where 1 and i.enroll_id=e.enroll_id and i.google_action='yes' and e.employee_id='".$data_couc['admin_id']."'  and e.cm_id='".$cm_id1."' ".$added_date_i." ";
							$query_rev=mysql_query($select_rev);
							$count_review=mysql_num_rows($query_rev);
							$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_review.'</strong></td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>31</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Student Testimonial</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$crs_price ='';
							$select_ni="select * from action_final i, enrollment e where 1 and i.enroll_id=e.enroll_id and i.video_action='yes' and e.employee_id='".$data_couc['admin_id']."' and e.cm_id='".$cm_id1."' ".$added_date_i." ";
							$query_ni=mysql_query($select_ni);
							if($count_testominal=mysql_num_rows($query_ni))
							{
								$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_testominal.'</strong></td>';
							}
							$message.='<td align="center" style="border:1px solid #CCC">0</td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>32</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Models added in Model Bank</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$crs_price ='';
							$select_model="select model_id from model_bank where 1 and admin_id='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$added_date."  ";
							$query_model=mysql_query($select_model);
							if($count_model=mysql_num_rows($query_model))
							{
								$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$count_model.'</strong></td>';
							}
							$message.='<td align="center" style="border:1px solid #CCC">0</td>';
						}
					$message.='</tr><tr class="grey_td">';
						$message.='<td width="8%" align="center" style="border:1px solid #CCC"><strong>33</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>No. of Models added in Model Bank</strong></td>';
						$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' and cm_id='".$cm_id1."' order by admin_id asc";
						$ptr_counc=mysql_query($select_counc);
						while($data_couc=mysql_fetch_array($ptr_counc))
						{
							$dsr_matched ='';
							$select_ni="select * from dsr_match_reprot where 1 and added_by='".$data_couc['admin_id']."' and cm_id='".$cm_id1."' ".$dsr_added_date." ";
							$query_ni=mysql_query($select_ni);
							if($count_ni=mysql_num_rows($query_ni))
							{
								$data_course_id=mysql_fetch_array($query_ni);
								$message.='<td align="center" style="border:1px solid #CCC"><strong>'.$data_course_id['status'].'</strong></td>';
							}
							$message.='<td align="center">--</td>';
						}
					$message.='</tr>';
				$message.='</table>
			</td>
		</tr>';
$message.='</table>';
					
						/*------------send a mail to admin about this---------------------*/
						$subject ="Daily Sales Performance Report for Ahmedabad Branch - ISAS BEAUTY SCHOOL ";
						$sendMessage=$GLOBALS['box_message_top'];
						echo $sendMessage.=$message;
						echo "<input type='hidden' name='mail_content' id='mail_content' value='".addslashes($sendMessage)."' >";
						//===================================================//21-12-17=====================================================
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
									$mail->setFrom('info@isassystems.com', 'ISAS');
									$mail->addAddress("erp.isas@gmail.com"); 
									
									$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='347' and cm_id='".$cm_id1."'";
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
									}
									
									$sel_act="select contact_phone,email from site_setting where type='S' and email!='' ";
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
									}
									
									
									$mail->Subject ='Daily Sales Performance Report Report For Ahmedabad Branch- '.date('Y-m-d').'';
									
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
?>
</body>
</html>