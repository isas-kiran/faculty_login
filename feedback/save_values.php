<?php include '../inc_classes.php';
$action = $_POST['action'];
if($action=='save_values')
{
	
	$customer_id=$_POST['customer_id'];
	$customer_service_id=$_POST['customer_service_id'];
	$service_id=$_POST['service_id'];
	$therapist_id=$_POST['therapist_id'];
	$m_q_id=$_POST['m_q_id'];
	$q_id=$_POST['q_id'];
	$ans=$_POST['ans'];
	$added_date=$_POST['added_date'];
	$que=$_POST['que'];
	$cm_id=$_POST['cm_id'];
	$admin_id=$_POST['admin_id'];
	
	
	$feedback="select q_id from feedback where q_id='".$q_id."'";
	$ptr_feedback=mysql_query($feedback);
	$data=mysql_num_rows($ptr_feedback);
	
	if($data)
	{
		$update_status="update feedback set ans='".$ans."' where q_id='".$q_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
	else
	{
		$insert="INSERT INTO `feedback`(`customer_id`, `customer_service_id`, `service_id`, `therapist_id`, `m_q_id`, `q_id`, `ans`, `added_date`, `que`, `cm_id`, `admin_id`) VALUES ('".$customer_id."','".$customer_service_id."','".$service_id."','".$therapist_id."','".$m_q_id."','".$q_id."','".$ans."','".date('Y-m-d')."','".$que."','".$cm_id."','".$admin_id."')";
		$query=mysql_query($insert);
	}
}
	?>