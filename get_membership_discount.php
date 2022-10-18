<?php include 'inc_classes.php';?>
<?php
	$membership_id=$_POST['membership_id'];
	if($membership_id !='')
	{
		$sel_tel = "select membership_id,membership_name,price,discount,validity from membership where membership_id='".$membership_id."'";	 
		$query_tel = mysql_query($sel_tel);
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['discount'].'-'.$data_srvice['price'].'-'.$data_srvice['validity'];
	}
?>	
