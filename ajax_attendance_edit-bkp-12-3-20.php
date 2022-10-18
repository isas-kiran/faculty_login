<?php include 'inc_classes.php';

	$option=isset($_REQUEST['option']) ? $_REQUEST['option'] : '';
   	$Id=isset($_REQUEST['Id']) ? $_REQUEST['Id']  : '';
	$val=isset($_REQUEST['val'])  ? $_REQUEST['val']  : '';
	$values=isset($_REQUEST['values']) ? $_REQUEST['values'] : '';
	if($option=='edit')
	{
		echo '
		<div id="edit_'.$val.'_'.$Id.'">
    	<input type="text" id="save_'.$val.'_'.$Id.'" value="'.$values.'"  style="width:50px;" />
    	<input type="button" value="Save" onclick="return saveColumn(\''.$Id.'\',\''.$val.'\');" />
		</div>
		';
	}
	else if($option=='save')
	{
		$value = $_REQUEST['value'];
		$id=$_REQUEST['Id'];
		$full_day='';
		$half_day='';
		$quarter_day='';
		$one_third='';
		$two_third='';
		$over1='';
		$over2='';
		$over3='';
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
		$update_att="update pr_import_attendance set full_day='".$full_day."',half_day='".$half_day."',quarter_day='".$quarter_day."',one_third='".$one_third."',two_third='".$two_third."',over1='".$over1."',over2='".$over2."',over3='".$over3."' where attendance_id='".$id."' ";
		$pr_query=mysql_query($update_att);
		
		echo '<div ondblclick="return editColumn(\''.$Id.'\',\''.$val.'\')" id="edit_'.$val.'_'.$Id.'">'.$value.'</div>';
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