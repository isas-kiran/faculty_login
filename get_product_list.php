<?php
include 'inc_classes.php';
$action=$_POST['action'];

if($action=='get_checkout_product')
{
	$branch_name=$_POST['branch_name'];
	$totals=$_POST['totals'];
	if($branch_name!='')
	{
		$sql_cm="select cm_id,admin_id,name from site_setting where branch_name='".$branch_name."' and type='ST' ";
		$ptr_cm= mysql_query($sql_cm);
		$data_cm=mysql_fetch_array($ptr_cm);
		
		$select_product_name="select product_id,product_name,quantity,admin_id from product where 1 and quantity>0 and  cm_id='".$data_cm['cm_id']."' and status='Active' "; 
		$query_product=mysql_query($select_product_name);
		if(mysql_num_rows($query_product))
		{
			$name='';
			while($fetch_array=mysql_fetch_array($query_product))
			{
				$sel_emp="select name from site_setting where admin_id='".$fetch_array['admin_id']."'";
				$ptr_admin_id=mysql_query($sel_emp);
				$data_name=mysql_fetch_array($ptr_admin_id);
				$name= "(".$data_name['name'].")";
				echo "<option value='".$fetch_array['product_id']."' >".addslashes($fetch_array['product_name'])." (Qty- ".$fetch_array['quantity'].")&nbsp;&nbsp;&nbsp;".$name."</option>";
			}
		}
	}
}
else if($action=='get_sales_product')
{
	$branch_name=$_POST['branch_name'];
	$totals=$_POST['totals'];
	if($branch_name!='')
	{
		$sql_cm="select cm_id,admin_id,name from site_setting where branch_name='".$branch_name."' and type='ST' ";
		$ptr_cm= mysql_query($sql_cm);
		$data_cm=mysql_fetch_array($ptr_cm);
		
		$sel_tel="select p.product_id,p.product_name,p.price,p.quantity,p.admin_id from product p, site_setting s where 1 and p.status='Active' and p.admin_id=s.admin_id and p.cm_id='".$data_cm['cm_id']."' and p.quantity > 0  order by product_id asc";
		$query_tel = mysql_query($sel_tel);
		while($data=mysql_fetch_array($query_tel))
		{
			$name='';
			$sel_emp="select name from site_setting where admin_id='".$data['admin_id']."'";
			$ptr_admin_id=mysql_query($sel_emp);
			$data_name=mysql_fetch_array($ptr_admin_id);
			$name= "(".$data_name['name'].")";
			echo '<option value="'.$data['product_id'].'">'.addslashes($data['product_name']).'&nbsp;&nbsp;(Price - '.addslashes($data['price']).')&nbsp;&nbsp;'.$name.'</option>';
		}
	}
}
else
{
	$vendor_id=$_POST['vendor_id'];
	$totals=$_POST['totals'];
	if($_POST['vendor_id']!='')
	{
		$sql_dest = " select product_id, vendor_id from product_vendor_map where vendor_id='".$vendor_id."' ";
		$ptr_edes = mysql_query($sql_dest);
		if(mysql_num_rows($ptr_edes))
		{
			while($data_dist = mysql_fetch_array($ptr_edes))
			{
				//for($i=1;$i<=$totals;$i++)
					//{
				$select_product_name="select product_id,product_name,quantity,admin_id from product where product_id='".$data_dist['product_id']."' and status='Active' ".$_SESSION['where']." "; //".$_SESSION['user_id']." on 13/6/18
				$query_product=mysql_query($select_product_name);
				if(mysql_num_rows($query_product))
				{
					$fetch_array=mysql_fetch_array($query_product);
					
					$name='';
					//if($_SESSION['type'] =='S')
					//{
						$sel_emp="select name from site_setting where admin_id='".$fetch_array['admin_id']."'";
						$ptr_admin_id=mysql_query($sel_emp);
						$data_name=mysql_fetch_array($ptr_admin_id);
						
						$name= "(".$data_name['name'].")";
					//}
					
					echo "<option value='".$fetch_array['product_id']."' >".addslashes($fetch_array['product_name'])." (Qty- ".$fetch_array['quantity'].")&nbsp;&nbsp;&nbsp;".$name."</option>";
				}
			}
		}
	}
}
?>