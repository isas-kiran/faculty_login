<?php include 'inc_classes.php';?>
<?php
	$product_id=$_POST['product_id'];
	if($product_id !='')
	{
		$select_name="select product_id,price from product where product_id='".$product_id."' ";
	    $ptr_query=mysql_query($select_name);
	    $data_name=mysql_fetch_array($ptr_query);
		echo $data_name['price'];
	}
?>	
