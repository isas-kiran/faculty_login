<?php include 'inc_classes.php';
$action = $_POST['action'];
if($action=='user_status')
{
	$status=$_POST['status'];
	$product_id=$_POST['product_id'];
	if($product_id)
	{
		$update_status="update product set action='".$status."' where product_id='".$product_id."'";
		$ptr_status=mysql_query($update_status);
		echo "Status updated successfully";
	}
}
	?>