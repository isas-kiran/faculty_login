<?php include 'inc_classes.php';?>
<?php
	$customer_id=$_POST['customer_id'];
	$status=$_POST['status'];
	if($customer_id !='')
	{
		$select_name="UPDATE `customer_service` SET `status` = '".$status."' WHERE `customer_service_id` ='".$customer_id."' ";
	    $ptr_query=mysql_query($select_name);
		echo "success";
	}?>