<?php
include 'inc_classes.php';
$vendor_id=$_POST['vendor_id'];
$totals=$_POST['totals'];
if($_POST['vendor_id']!='')
{
	$sql_dest = " select product_id, admin_id from product where admin_id='".$vendor_id."' ";
	$ptr_edes = mysql_query($sql_dest);
	if(mysql_num_rows($ptr_edes))
	{
		while($data_dist = mysql_fetch_array($ptr_edes))
		{
			//for($i=1;$i<=$totals;$i++)
				//{
			$select_product_name="select product_id,product_name,quantity,admin_id from product where product_id='".$data_dist['product_id']."' and status='Active' ".$_SESSION['where']." and  admin_id='".$vendor_id."' ";
			$query_product=mysql_query($select_product_name);
			if(mysql_num_rows($query_product))
			{
				$fetch_array=mysql_fetch_array($query_product);
				
				$name='';
				if($_SESSION['type'] =='S')
				{
					$sel_emp="select name from site_setting where admin_id='".$fetch_array['admin_id']."'";
					$ptr_admin_id=mysql_query($sel_emp);
					$data_name=mysql_fetch_array($ptr_admin_id);
					
					$name= "(".$data_name['name'].")";
				}
				
				echo "<option value='".$fetch_array['product_id']."' >".addslashes($fetch_array['product_name'])." (Qty- ".$fetch_array['quantity'].")&nbsp;&nbsp;&nbsp;".$name."</option>";
			}
		}
	}
}
//}
?>