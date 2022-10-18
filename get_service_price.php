<?php include 'inc_classes.php';?>
<?php
	$service_id=$_POST['service_id'];
	if($service_id !='')
	{
		$select_name="select service_id,service_price,service_time from servies where service_id='".$service_id."' ";
	    $ptr_query=mysql_query($select_name);
	    $data_name=mysql_fetch_array($ptr_query);
		echo $data_name['service_price']."-".$data_name['service_time'];
	}
?>	
