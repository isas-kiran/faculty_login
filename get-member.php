<?php include 'inc_classes.php';

$membership_id = $_POST['membership_id'];

    $select_name="select membership_id,price from membership where membership_id='".$membership_id."' ";
	$ptr_query=mysql_query($select_name);
	$data_name=mysql_fetch_array($ptr_query);
	echo $data_name['price'];
	/*
	echo '<table style="width: 90%"><tr><td width="25%">Amount :</td>
	<td width="40%"><input type="text" name="price" class="validate[required] input_text" id="price" value="'.$data_name['price'].'"  /></td></tr></table>';*/