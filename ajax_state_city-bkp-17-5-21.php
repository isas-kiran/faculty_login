<?php include 'inc_classes.php';
$action = $_POST['action'];

if($action=='state')
{
	$country_id=$_POST['country_id'];
	$record_state_id=$_POST['record_state_id'];
    $sel_state = "select * from states where country_id='".$country_id."' ";
    $ptr_states = mysql_query($sel_state);
	echo '<table width="100%"><tr><td>';
	echo '<select id="state" name="state" onchange="select_city(this.value)" style="width:460px"><option value="">Select State</option>';
	while($state_data= mysql_fetch_array($ptr_states))
	{
		$sel='';
		if($record_state_id==$state_data['id'])
		{
			$sel='selected="selected"';
		}
		echo '<option value="'.$state_data['id'].'" '.$sel.'>'.$state_data['name'].'</option>';
	}
	echo '</select></td></tr></table>';
}
else if($action=='state_m')
{
	$country_id=$_POST['country_id'];
	$record_state_id=$_POST['record_state_id'];
    $sel_state = "select * from states where country_id='".$country_id."' ";
    $ptr_states = mysql_query($sel_state);
	echo '<select id="state" name="state" onchange="select_city(this.value)" style="width:200px"><option value="">Select State</option>';
	while($state_data= mysql_fetch_array($ptr_states))
	{
		$sel='';
		if($record_state_id==$state_data['id'])
		{
			$sel='selected="selected"';
		}
		echo '<option value="'.$state_data['id'].'" '.$sel.'>'.$state_data['name'].'</option>';
	}
	echo '</select>';
}
else if($action=='city')
{
	$state_id=$_POST['state_id'];
	$record_city_id=$_POST['record_city_id'];
    $sel_city = "select * from cities where state_id='".$state_id."' ";
    $ptr_city = mysql_query($sel_city);
	echo '<table width="100%"><tr><td>';
	echo '<select id="city" name="city" style="width:460px"><option value="">Select City</option>';
	while($city_data= mysql_fetch_array($ptr_city))
	{
		$sel='';
		if($record_city_id==$city_data['id'])
		{
			$sel='selected="selected"';
		}
		echo '<option value="'.$city_data['id'].'" '.$sel.'>'.$city_data['name'].'</option>';
	}
	echo '</select></td></tr></table>';
}
else if($action=='city_m')
{
	$state_id=$_POST['state_id'];
	$record_city_id=$_POST['record_city_id'];
    $sel_city = "select * from cities where state_id='".$state_id."' ";
    $ptr_city = mysql_query($sel_city);
	echo '<select id="city" name="city" style="width:200px"><option value="">Select City</option>';
	while($city_data= mysql_fetch_array($ptr_city))
	{
		$sel='';
		if($record_city_id==$city_data['id'])
		{
			$sel='selected="selected"';
		}
		echo '<option value="'.$city_data['id'].'" '.$sel.'>'.$city_data['name'].'</option>';
	}
	echo '</select>';
}
?>		  