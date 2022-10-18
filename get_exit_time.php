<?php include 'inc_classes.php';?>
<?php
	
	$emp_id=$_POST['emp_id'];
	if($emp_id !='')
	{
		$start_time=trim($_POST['start_time']);
		$curr_date=trim($_POST['curr_date']);
		$sel_exist ="select * from customer_service where staff_id='".$emp_id."' and date='".$curr_date."'";	 
		$query_exist = mysql_query($sel_exist);
		if(mysql_num_rows($query_exist))
		{
			$exist='';
			while($data_exist_time = mysql_fetch_array($query_exist))
			{
				$exist_date=trim($data_exist_time['date']);
				$start_times_exist =trim($data_exist_time['start_time']);
				$end_exist_time=trim($data_exist_time['end_time']);
				//echo "curr date- ".$curr_date ."exis date- ".$exist_date;
				if($curr_date==$exist_date && $curr_date !='' && $exist_date !='')
				{
					
					
					if($start_time == $start_times_exist || $start_time == $end_exist_time || (($start_time <= $end_exist_time) && ($start_time >= $start_times_exist) ))
					{
						$exist .="exist";
					}
				}
				
			}
			echo $exist;
		}
			
	}
	
	
?>	
