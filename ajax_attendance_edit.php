<?php include 'inc_classes.php';

	$option=isset($_REQUEST['option']) ? $_REQUEST['option'] : '';
   	$Id=isset($_REQUEST['Id']) ? $_REQUEST['Id']  : '';
	$val=isset($_REQUEST['val'])  ? $_REQUEST['val']  : '';
	$values=isset($_REQUEST['values']) ? $_REQUEST['values'] : '';
	if($option=='edit')
	{
		echo '
		<div id="edit_'.$val.'_'.$Id.'">
    	<input type="text" id="save_'.$val.'_'.$Id.'" value="'.trim($values).'"  style="width:50px;" />
    	<input type="button" value="Save" onclick="return saveColumn(\''.$Id.'\',\''.$val.'\');" />
		</div>
		';
	}
	else if($option=='save')
	{
		$value = trim($_REQUEST['value']);
		$id=$_REQUEST['Id'];
		$full_day='';
		$half_day='';
		$quarter_day='';
		$one_third='';
		$two_third='';
		$over1='';
		$over2='';
		$over3='';
		$late_mark='';
		if($val=='late_mark')
		{
			$late_mark=$value;
		}
		if($val=='full_day')
		{
			$full_day=$value;
		}
		if($val=='half_day')
		{
			$half_day=$value;
		}
		if($val=='quarter_day')
		{
			$quarter_day=$value;
		}
		if($val=='one_third')
		{
			$one_third=$value;
		}
		if($val=='two_third')
		{
			$two_third=$value;
		}
		if($val=='over1')
		{
			$over1=$value;
		}
		if($val=='over2')
		{
			$over2=$value;
		}
		if($val=='over3')
		{
			$over3=$value;
		}
		
		if($val=='late_mark')
		{
			$update_att="update pr_import_attendance set late_marks='".$late_mark."' where attendance_id='".$id."' ";
			$pr_query=mysql_query($update_att);
		}
		else
		{
			$update_att="update pr_import_attendance set full_day='".$full_day."',half_day='".$half_day."',quarter_day='".$quarter_day."',one_third='".$one_third."',two_third='".$two_third."',over1='".$over1."',over2='".$over2."',over3='".$over3."' where attendance_id='".$id."' ";
			$pr_query=mysql_query($update_att);
		}
		echo '<div ondblclick="return editColumn(\''.$Id.'\',\''.$val.'\')" id="edit_'.$val.'_'.$Id.'">'.$value.'</div>';
		
		$select_tot="select staff_id,year,month,days,cm_id from pr_import_attendance where attendance_id='".trim($Id)."'";
		$pt_query=mysql_query($select_tot);
		$data_att=mysql_fetch_array($pt_query);		
		$total_day=0;
		$days=$data_att['days'];
		for($i=1;$i<=$days;$i++)
		{
			if($i<10)
			{
				$d='0'.$i;
			}
			else
			{
				$d=$i;
			}
			$curr_date = $data_att['year'].'-'.$data_att['month'].'-'.$d;
			
			$select_user="select * from pr_import_attendance where cm_id='".$data_att['cm_id']."' and staff_id='".$data_att['staff_id']."' and year='".$data_att['year']."' and month='".$data_att['month']."' and DATE(date)='".$curr_date."' order by date asc";
			$ptr_chk_ext=mysql_query($select_user);
			if($tot=mysql_num_rows($ptr_chk_ext))
			{
				$data_user_att=mysql_fetch_array($ptr_chk_ext);
				
				$day_tot=0;
				$full_day='';
				$onethird_day='';
				$half_day='';
				$quarter_day='';
				
				if(trim($data_user_att['full_day'])=='P')
				{
					$full_day='P';
					$day_tot=1;
					$total_day +=1;
				}
				if(trim($data_user_att['one_third'])=='P')
				{
					$onethird_day='P';
					$day_tot=0.75;
					$total_day +=0.75;
				}
				if(trim($data_user_att['half_day'])=='P')
				{
					$half_day='P';
					$day_tot=0.5;
					$total_day +=0.5;
				}
				if(trim($data_user_att['quarter_day'])=='P')
				{
					$quarter_day='P';
					$day_tot=0.25;
					$total_day +=0.25;
				}
				
				//echo "<br/>Date - ".$curr_date." Total Hours - ".$hrs_min;
				//insert in DB
				$ins_attendace="update `pr_import_attendance` set `staff_id`='".$data_att['staff_id']."',`year`='".$data_att['year']."',`month`='".$data_att['month']."',`date`='".$curr_date."',`branch_name`='Pune', `full_day`='".$full_day."',`half_day`='".$half_day."',`quarter_day`='".$quarter_day."',`one_third`='".$onethird_day."',`day_total`='".$day_tot."', `total_till_date`='".$total_day."',`admin_id`='".$_SESSION['admin_id']."',`cm_id`='".$data_att['cm_id']."' where attendance_id='".$data_user_att['attendance_id']."'";
				$ptr_ins=mysql_query($ins_attendace);
			}
		}		
	}
	
	/*switch($option)
	{
		case 'edit': // Display Text box
		echo '
		<div id="edit_'.$val.'_'.$Id.'">
    	<input type="text" id="save_'.$val.'_'.$Id.'" value="'.$values.'"  style="width:50px;" />
    	<input type="button" value="Save" onclick="return saveColumn(\''.$Id.'\',\''.$val.'\');" />
		</div>	
		';
  		break;

  		case 'save': // Save to Database
		
  		break;
	}*/
	?>