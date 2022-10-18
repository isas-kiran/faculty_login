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
	if($enroll_id)
	{
		$update_status="update enrollment set action_status='verify' where enroll_id='".$enroll_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	
//============================================================END=============================================================================================