<?php include 'inc_classes.php';?>
<?php
	
	$member_id=$_POST['service_ids'];
	if($member_id=='')
	    {
		echo "Please select Service name...!!!";
		}
	else
	    {	
	$result = array();
	if($member_id !='')
	{
		/************************************************/
		$result_seprated =explode(',',$member_id);
		// echo count($result_seprated);
		//$concat = ' and  (';
		for($i=0;$i<count($result_seprated);$i++)
		{
			$sel_tel = "select service_id,service_name,service_price,service_time from servies where service_id='".$result_seprated[$i]."'";	 
			$query_tel = mysql_query($sel_tel);
			$data_srvice = mysql_fetch_array($query_tel);
			$price +=trim($data_srvice['service_price']);
			$time +=trim($data_srvice['service_time']);
		}
		echo $price."-".$time;
	}
	
		}
?>	
