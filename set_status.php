<?php include 'inc_classes.php';
$action = $_POST['action'];
//===============================SET Enquiry Status=============================================
if($action=='close_followup_inquiry')
{
	$record_id=$_POST['record_id'];
	if($record_id)
	{
		$update_status="update inquiry set status='Cancelled' where inquiry_id='".$record_id."'";
		$ptr_status=mysql_query($update_status);

		$update_status1="update stud_regi set status='Cancelled' where student_id='".$record_id."'";
		$ptr_status1=mysql_query($update_status1);
		
		$update_status2="update followup_details set status='Inactive' where student_id='".$record_id."'";
		$ptr_status2=mysql_query($update_status2);
		
		echo "Status updated successfully";
	}
}
//===============================END=============================================================
//===============================SET Installment Status==========================================
if($action=='close_followup_inquiry11')
{
	$record_id=$_POST['record_id'];
	if($record_id)
	{
		$update_status="update inquiry set status='Cancelled' where record_id='".$record_id."'";
		$ptr_status=mysql_query($update_status);
		
		$update_status1="update stud_regi set status='Cancelled' where record_id='".$record_id."'";
		$ptr_status1=mysql_query($update_status1);
		
		$update_status2="update followup_details set status='Inactive' where record_id='".$record_id."'";
		$ptr_status2=mysql_query($update_status2);
		
		echo "Status updated successfully";
	}
}
//======================================END=======================================================
//=====================================SET Service Status=========================================
if($action=='close_followup_inquiry22')
{
	$record_id=$_POST['record_id'];
	if($record_id)
	{
		$update_status="update inquiry set status='Cancelled' where record_id='".$record_id."'";
		$ptr_status=mysql_query($update_status);
		
		$update_status1="update stud_regi set status='Cancelled' where record_id='".$record_id."'";
		$ptr_status1=mysql_query($update_status1);
		
		$update_status2="update followup_details set status='Inactive' where record_id='".$record_id."'";
		$ptr_status2=mysql_query($update_status2);
		
		echo "Status updated successfully";
	}
}
//====================================END==========================================================
//====================================SET USer Status=============================================
if($action=='user_status')
{
	$status=$_POST['status'];
	$admin_id=$_POST['admin_id'];
	if($admin_id)
	{
		$update_status="update site_setting set status='".$status."' where admin_id='".$admin_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	
//=======================================END========================================================
//=====================================SET USer Status==============================================
if($action=='enroll_upgrade_status')
{
	$status=$_POST['status'];
	$enroll_id=$_POST['enroll_id'];
	if($enroll_id)
	{
		$update_status="update enrollment set upgrade_status='".$status."' where enroll_id='".$enroll_id."'";
		$ptr_status=mysql_query($update_status);
		//echo "Status updated successfully";
	}
}
	
//==========================================END=====================================================
//===================================SET System Status==============================================
if($action=='system_status')
{
	$status=$_POST['status'];
	$admin_id=$_POST['admin_id'];
	if($admin_id)
	{
		$update_status="update site_setting set system_status='".$status."' where admin_id='".$admin_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully '".$status."'";
	}
}
	
//=======================================END=======================================================
//===================================SET Course Status==============================================
if($action=='course_status')
{
	$status=$_POST['status'];
	$course_id=$_POST['course_id'];
	if($course_id)
	{
		$update_status="update courses set status='".$status."' where course_id='".$course_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	
//=======================================END=========================================================
//================================SET Course Status==================================================
if($action=='set_web_status')
{
	$status=$_POST['status'];
	$prod_id=$_POST['prod_id'];
	if($prod_id)
	{
		$update_status="update wb_great_things set status='".$status."' where id='".$prod_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	
//=======================================END========================================================
//====================================SET Course Status=============================================
if($action=='set_web_seq_status')
{
	$status=$_POST['status'];
	$prod_id=$_POST['prod_id'];
	if($prod_id)
	{
		$update_status="update wb_great_things set sequence_id='".$status."' where id='".$prod_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	
//================================================END==============================================
//=================================SET enroll action Status========================================
{
	$enroll_id=$_POST['enroll_id'];
	$status=trim($_POST['status']);
	if($status=="1")
	{
		$status="verified";
	}
	else if($status=="2")
	{
		$status="acknowledgement";
	}
	if($enroll_id)
	{
		$select_cm="select cm_id from enrollment where enroll_id='".$enroll_id."'";
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
		
		$update_status="update enrollment set action_status='".$status."' where enroll_id='".$enroll_id."'";
		$ptr_status=mysql_query($update_status);
		
		$insert_sta="insert into enroll_verification(`enroll_id`,`status`,`admin_id`,`cm_id`,`added_date`) values ('".$enroll_id."','".$status."','".$_SESSION['admin_id']."','".$cm_id."','".date('Y-m-d')."')";
		$ptr_ins=mysql_query($insert_sta);
		
		//------send notification on inquiry addition-----
			$notification_args['reference_id'] = $enroll_id;
			$notification_args['on_action'] = 'enroll_verify';
			$notification_status = addNotifications($notification_args);
		//-----------------------------------------------
		echo "Status updated successfully";
		
		
	}
}
//============================================END============================================
//========================================SET Bank Status==========================================
if($action=='bank_status')
{
	$status=$_POST['status'];
	$bank_id=$_POST['bank_id'];
	if($bank_id)
	{
		$update_status="update bank set status='".$status."' where bank_id='".$bank_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	
//=======================================END============================================================
//========================================SET Bank Status==========================================
if($action=='set_inv_status')
{
	$inv_id=$_POST['inv_id'];
	if($inv_id)
	{
		$update_status="update inventory set invoice_status='Approve' where inventory_id='".$inv_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	
//=======================================END============================================================