<?php 
include 'inc_classes.php';
$action = $_POST['action'];
$branch_name=$_POST['branch_name'];
$sel_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
$ptr_cm=mysql_query($sel_cm_id);
$data_cm=mysql_fetch_array($ptr_cm);
if($action=='stockiest')
{
	echo'<select name="stockiest" id="stockiest" class="input_select_login"  style="width: 150px; ">
	<option value="">-Select Stockiest-</option>';
	$sel_stockiest="select admin_id,name from site_setting where 1 and type='ST' and cm_id='".$data_cm['cm_id']."' and system_status='Enabled' order by name asc";
	$ptr_stockiest=mysql_query($sel_stockiest);
	while($data_stockist=mysql_fetch_array($ptr_stockiest))
	{
		echo '<option value="'.$data_stockist['admin_id'].'" > '.$data_stockist['name'].'</option>';
	}
	echo '</select>';
	
}
else if($action=='all')
{
	echo'<select name="stockiest" id="stockiest" class="input_select_login"  style="width: 150px; ">
	<option value="">-Select Stockiest-</option>';
	$sel_stockiest="select admin_id,name from site_setting where 1 and cm_id='".$data_cm['cm_id']."' and system_status='Enabled' order by name asc";
	$ptr_stockiest=mysql_query($sel_stockiest);
	while($data_stockist=mysql_fetch_array($ptr_stockiest))
	{
		echo '<option value="'.$data_stockist['admin_id'].'" > '.$data_stockist['name'].'</option>';
	}
	echo '</select>';
}
else if($action=='kit_stockiest')
{
	echo'<select name="stockiest" id="stockiest" onChange="get_product_list(this.value)" class="input_select_login" style="width: 150px; ">
	<option value="">Select Stockiest</option>';
	$sel_stockiest="select admin_id,name from site_setting where 1 and type='ST' and cm_id='".$data_cm['cm_id']."' and system_status='Enabled' order by name asc";
	$ptr_stockiest=mysql_query($sel_stockiest);
	while($data_stockist=mysql_fetch_array($ptr_stockiest))
	{
		echo '<option value="'.$data_stockist['admin_id'].'" > '.$data_stockist['name'].'</option>';
	}
	echo '</select>';
}
?>		  