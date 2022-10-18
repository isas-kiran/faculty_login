<?php
include 'inc_classes.php';
$vendor_id=$_POST['vendor_id'];
if($vendor_id!='')
{
	$sel_wall="select wallet_balance from vendor where vendor_id='".$vendor_id."'";
	$ptr_wall=mysql_query($sel_wall);
	$data_wall=mysql_fetch_array($ptr_wall);
	echo $wallet_bal=$data_wall['wallet_balance'];
}
?>