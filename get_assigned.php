<?php include 'inc_classes.php';
$action = $_POST['action'];
if($action=='get_assigned')
{
	$councellor=$_POST['councellor'];
	$enquiry_id=$_POST['enquiry_id'];
	if($enquiry_id)
	{
		 $update_status="update inquiry set employee_id='".$councellor."' where inquiry_id='".$enquiry_id."'";
		$ptr_status=mysql_query($update_status);
		//echo "Status updated successfully";
	}
}
else if($action=='set_prod_status')
{
	$status=$_POST['status'];
	$prod_id=$_POST['prod_id'];
	if($prod_id)
	{
		$update_status="update product set status='".$status."' where product_id='".$prod_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
else if($action=='set_prod_brand')
{
	$status=$_POST['status'];
	$prod_id=$_POST['prod_id'];
	if($prod_id)
	{
		$update_status="update product set brand='".$status."' where product_id='".$prod_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Brand updated successfully";
	}
}
?>