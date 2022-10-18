<?php include 'inc_classes.php';

$action=$_REQUEST['action'];
if($action=='edit_attendance')
{
	$option = isset($_REQUEST['option']) ? $_REQUEST['option'] : '';
   	$id= isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
	$value=isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	
	switch($option)
	{
		case $option=='full_day': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case $option=='half_day': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case $option=='quarter_day': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case $option=='one_third': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case $option=='two_third': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case $option=='over1': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case $option=='over2': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case $option=='over3': // Display Text box
			echo '
			<input type="text" id="'.$id.'" name="" value="'.$value.'" style="width:50px;" /> 
			<input type="button" value="Save" onclick="return saveColumn('.$id.','.$option.',this.value);" />';
		break;
		case 'save': // Save to Database
			$value = $_REQUEST['value'];
			echo $value;
		break;
	}
}
else if($action=='save_attendance')
{
	
}
?>