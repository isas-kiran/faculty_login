<?php include 'inc_classes.php';

$product_id = $_POST['product_id'];
if($product_id)
{
    $select_name="select product_id,quantity,size,unit,description,price,brand from product where product_id='".$product_id."' ";
	$ptr_query=mysql_query($select_name);
	$data_name=mysql_fetch_array($ptr_query);
	echo $data_name['size']." ".$data_name['unit'];
	echo '-'.$data_name['quantity'];
	/*$select_product="select SUM(issue_qty) as qty from checkout where product_id='".$product."' ";
	$ptr_quantity=mysql_query($select_product);
		$data_quantity=mysql_fetch_array($ptr_quantity);
		if($data_quantity['qty'] >0 )
	   	{
			echo '-'.$data_quantity['qty'];
		}
		else
		{
			echo '-0'; 
		}*/
	echo "-".$data_name['price']."#".$data_name['brand']."#".strip_tags($data_name['description']);
}
	