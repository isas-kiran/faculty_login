<?php
include 'inc_classes.php';
$action=$_POST['action'];
$branch_id=$_POST['branch_id'];
if($action=="show_category")
{
	$sel_cm="select cm_id from site_setting where branch_name='".$branch_id."' and type='A' and system_status='Enabled'";
	$ptr_cm=mysql_query($sel_cm);
	$data_cm=mysql_fetch_array($ptr_cm);
	echo '<select name="pcategory_id" style="width:200px;" id="pcategory_id" onchange="show_subcategory(this.value,0);" ><option value="">Select Category</option>';
	$sql_dest="select pcategory_name, pcategory_id from product_category where 1 and cm_id='".$data_cm['cm_id']."' order by pcategory_id asc";
	$ptr_edes = mysql_query($sql_dest);
	while($data_dist = mysql_fetch_array($ptr_edes))
	{
		$selecteds = '';
		if($data_dist['pcategory_id']==$row_record['pcategory_id'])
			$selecteds = 'selected="selected"';	                                 
		echo "<option value='".$data_dist['pcategory_id']."' ".$selecteds.">".$data_dist['pcategory_name']."</option>";
	}
	echo '</select>';
}
?>