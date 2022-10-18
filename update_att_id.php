<?php include 'inc_classes.php'; ?>
<?php
$sel_att="select staff_id, cm_id from pr_staff_salary_management where 1 ";
$ptr_sel=mysql_query($sel_att);
while($data_att=mysql_fetch_array($ptr_sel))
{
	$sel_atid="select admin_id,cm_id,attendence_id from site_setting where attendence_id='".$data_att['staff_id']."' and cm_id='".$data_att['cm_id']."'";
	$ptr_sel_att=mysql_query($sel_atid);
	while($data_atts=mysql_fetch_array($ptr_sel_att))
	{
		$upd_att="update pr_staff_salary_management set employee_id='".$data_atts['admin_id']."' where staff_id='".$data_atts['attendence_id']."' and cm_id='".$data_atts['cm_id']."'";
		$ptr_update=mysql_query($upd_att);
	}
}
?>