<?php include 'inc_classes.php';

$product_id = $_POST['product_id'];

    $select_name="select product_id,amount,price from product where product_id='".$product_id."' ";
	$ptr_query=mysql_query($select_name);
	$data_name=mysql_fetch_array($ptr_query);
	//echo $data_name['amount'];
	//echo $data_name['price'];
	
	echo '<table style="width: 70%">
	
	<tr>
	
	<td width="20%">Product Amount :</td>
	<td width="35%"><input type="text" name="amount" class="input_text" id="amount" value="'.$data_name['amount'].'" /></td>
	
	</tr>
	
	<tr>
	
	<td width="20%">Price :</td>
	<td width="35%"><input type="text" name="price" class="input_text" id="price" value="'.$data_name['price'].'" /></td>
	
	</tr>
	</table>';