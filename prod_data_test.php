<?php 
ini_set('max_execution_time', '600');
include 'inc_classes.php';?>
<?php
$sel_prod="select * from product";
$ptr_prod=mysql_query($sel_prod);
while($data_prod=mysql_fetch_array($ptr_prod))
{
	$ins_data="INSERT INTO `product_daily_report`(`product_id`, `cm_id`, `stockiest_id`, `type`, `purchase_qty`, `sales_qty`, `checkout_qty`, `vendor_id`, `cust_type`, `cust_id`, `todays_qty`,`todays_shelf_qty`,`todays_consumable_qty`, `description`,`admin_id`,`added_date`) VALUES ('".$data_prod['product_id']."','".$data_prod['cm_id']."','".$data_prod['admin_id']."','primary','0','0','0','0','','0','".$data_prod['quantity']."','','','trnasfer product data to daily product report','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
	$ptr_ins=mysql_query($ins_data);
}
?>