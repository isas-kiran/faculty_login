<?php
include 'inc_classes.php';
$action=$_POST['action'];
if($action=="show_produts_by_employee")
{
	$admin_id=$_POST['admin_id'];
	$emp_id='';
	if($admin_id!='')
	{
		$emp_id=" and user_id='".$admin_id."'";
	}
	$sql_dest = "select DISTINCT(product_id) from product_user_map where 1 ".$emp_id." ".$_SESSION['where']." ";
	$ptr_edes = mysql_query($sql_dest);
	if(mysql_num_rows($ptr_edes))
	{
		echo "<option value=''>Select Product</option>";
		while($data_dist = mysql_fetch_array($ptr_edes))
		{
			$select_product_name="select product_id,product_name from product where product_id='".$data_dist['product_id']."' ".$_SESSION['where']." ";
			$query_product=mysql_query($select_product_name);
			if(mysql_num_rows($query_product))
			{
				$fetch_array=mysql_fetch_array($query_product);				
				echo "<option value='".$fetch_array['product_id']."' >".addslashes($fetch_array['product_name'])."</option>";
			}
		}
		//echo "</select>";
	}
	else
	{
		//echo "No produts Checkout for this employee. Checkout any product";
	}
	 
	
}
else if($action=="show_produts_details")
{
	$product_id=$_POST['product_id'];
	$employee_id=$_POST['employee_id'];
	if($product_id!='')
	{
		$select_products="select * from consumption where product_id='".$product_id."' and employee_id='".$employee_id."' and quantity>0";
		$ptr_product=mysql_query($select_products);
		if(mysql_num_rows($ptr_product))
		{
			$data_products=mysql_fetch_array($ptr_product);
			echo $data_products['quantity'].'###'.$data_products['unit'].'###'.$data_products['measure'].'###'.$data_products['description'].'###'.$data_products['added_date'];
		}
		else
		{
			$description='No';
			$select_products="select SUM(quantity_in_consumable) as quantity from product_user_map where product_id='".$product_id."' and user_id='".$employee_id."' and quantity_in_consumable > 0 ";
			$ptr_product=mysql_query($select_products);
			$data_productss=mysql_fetch_array($ptr_product);
			
			"\n".$sel_prd1="select size,unit,added_date from product where product_id='".$product_id."'";
			$ptr_prd1=mysql_query($sel_prd1);
			$data_prd1=mysql_fetch_array($ptr_prd1);
			
			echo $data_productss['quantity'].'###'.$data_prd1['size'].'###'.$data_prd1['unit'].'###No###'.$data_prd1['added_date'];
		}
	}
}
?>