<?php include 'inc_classes.php';?>
<?php
$cust_name=$_POST['customer_id'];
$type=$_POST['type'];
if($cust_name !='')
{
	if($type=="Customer")
	{
		$select_name="select email,address,delivery_address from customer where cust_id='".$cust_name."' ";
		$ptr_query=mysql_query($select_name);
		$data_name=mysql_fetch_array($ptr_query);
		echo $data_name['email']."###";
		echo $data_name['address']."###";
		echo $data_name['delivery_address'];
	}
	else if($type=="Student")
	{
		$sel_tel = "select enroll_id,name,mail,address from enrollment where enroll_id='".$cust_name."'";	 
		$query_tel = mysql_query($sel_tel);
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['enroll_id']."###";
		echo $data_srvice['address']."###";
		echo $data_srvice['address'];
	}
	else if($type=="Employee")
	{
		$sel_tel = "select admin_id,name,email,current_address from site_setting where contact_phone='".$mobile_no."'";	 
		$query_tel = mysql_query($sel_tel);
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['email']."###";
		echo $data_srvice['current_address']."###";
		echo $data_srvice['current_address'];
	}
}
?>