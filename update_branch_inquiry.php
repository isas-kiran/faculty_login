<?php include 'inc_classes.php';?>
<?php

echo "<br/>".$sel='select * from inquiry where cm_id=""';
$ptr=mysql_query($sel);
while($data_en=mysql_fetch_array($ptr))
{
	echo "<br/>".$sel_cm_id="select cm_id from site_setting where admin_id='".$data_en['employee_id']."' ";
	$ptr_admin=mysql_query($sel_cm_id);
	$data_admin=mysql_fetch_array($ptr_admin);
	
	echo "<br/>".$update="update inquiry set cm_id='".$data_admin['cm_id']."' where inquiry_id='".$data_en['inquiry_id']."'";
	$ptr_update=mysql_query($update);
}
?>

<?php $db->close();?>