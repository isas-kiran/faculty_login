<?php include 'inc_classes.php';
$action = $_POST['action'];
//================================================================SET Enquiry Status==========================================================================
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
//============================================================END=============================================================================================
//================================================================SET Installment Status==========================================================================
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
//============================================================END=============================================================================================
//================================================================SET Service Status==========================================================================
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
//============================================================END=============================================================================================
//================================================================SET USer Status==========================================================================
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
	
//============================================================END=============================================================================================
//================================================================SET enroll action Status==========================================================================
if($action=='enroll_action_status')
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
		$update_status="update enrollment set action_status='".$status."' where enroll_id='".$enroll_id."'";
		$ptr_status=mysql_query($update_status);
		
		$insert_sta="insert into enroll_verification(`enroll_id`,`status`,`admin_id`,`cm_id`,`added_date`) values ('".$enroll_id."','".$status."','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d')."')";
		$ptr_ins=mysql_query($insert_sta);
		
		//------send notification on inquiry addition-----
			$notification_args['reference_id'] = $enroll_id;
			$notification_args['on_action'] = 'enroll_verify';
			$notification_status = addNotifications($notification_args);
		//-----------------------------------------------
		echo "Status updated successfully";
	}
}
	
//============================================================END=============================================================================================