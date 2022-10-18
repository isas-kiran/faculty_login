<?php include 'inc_classes.php';?>
<?php
	$package_id=$_POST['package_id'];
	if($package_id !='')
	{
		$sel_pkg = "select package_id,package_name,start_date,end_date,amount,quantity from package where package_id='".$package_id."' ";	 
		$query_pkg = mysql_query($sel_pkg);
		$data_pkg= mysql_fetch_array($query_pkg);
		echo $data_pkg['package_name'].'/'.$data_pkg['amount'].'/'.$data_pkg['start_date'].'/'.$data_pkg['end_date'].'/'.$data_pkg['quantity'];
		echo"###";
		$sel_package="select package_id,service_id from package_service_map where package_id='".$package_id."'";
		$ptr_package=mysql_query($sel_package);
		$totals=mysql_num_rows($ptr_package);
		$i=1;
		while($data_package=mysql_fetch_array($ptr_package))
		{
			$sel_svcsm="select svm_id from sales_customer_service_voucher_map where service_id='".$data_package['service_id']."' and package_id='".$data_package['package_id']."' and  quantity > 0";
			$ptr_svcsm=mysql_query($sel_svcsm);
			if(mysql_num_rows($ptr_svcsm))
			{
				$package_service_cnt .=$data_package['service_id'];
				if($i!=$total)
				{
					$package_service_cnt .=",";
				}
			}
			$i++;
			
		}
		echo $package_service_cnt;
	}
?>