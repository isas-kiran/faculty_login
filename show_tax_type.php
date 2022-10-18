<?php

include 'inc_classes.php';

$branch_id=$_POST['branch_id'];
if($_POST['branch_id']!='')
{
		$sql_dest = " select branch_name, tax_name from tax_type where branch_name='".$branch_id."' ";
		$ptr_edes = mysql_query($sql_dest);
	    while($data_dist = mysql_fetch_array($ptr_edes))
		{
			echo "<option value='".$data_dist['tax_name']."' >".$data_dist['tax_name']."</option>";
		}
}
?>