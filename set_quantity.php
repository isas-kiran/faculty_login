<?php include 'inc_classes.php';
$action = $_POST['action'];
//=========================SET Qty Status====================================
if($action=='set_quantity')
{
	$qty=$_POST['values'];
	$id=$_POST['id'];
	
	$update_qty="update product set quantity='".$qty."' where product_id='".$id."'";
	$ptr_qty=mysql_query($update_qty);
}
//========================================END==============================================
//=========================SET Available QTY for Staff_checkout_report=====================
if($action=='set_avl_qty')
{
	$qty=$_POST['values'];
	$id=$_POST['id'];
	$user_id=$_POST['user_id'];
	
	$update_qty="update product_user_map set quantity_in_consumable='".$qty."' where product_id='".$id."' and user_id='".$user_id."' ";
	$ptr_qty=mysql_query($update_qty);
}
//===============================END==============================================
//=========================SET Consumed Qty for staff_checkout_report==============================
if($action=='set_cons_quantity')
{
	$qty=$_POST['values'];
	$id=$_POST['id'];
	$user_id=$_POST['user_id'];
	
	$update_qty="update product_user_map set quantity_in_consumable=(quantity_in_consumable - ".$qty.") where product_id='".$id."' and user_id='".$user_id."' ";
	$ptr_qty=mysql_query($update_qty);
}
//===============================END==============================================
