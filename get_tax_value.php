<?php
include 'inc_classes.php';
$branch_name=$_POST['branch_name'];
$tax_type=$_POST['tax_type'];
if($branch_name!='' && $tax_type!='')
{
	$sql_dest = " select tax_value from tax_type where branch_name='".$branch_name."' and tax_name='".$tax_type."' ";
	$ptr_edes = mysql_query($sql_dest);
	$data_dist = mysql_fetch_array($ptr_edes);
	echo $data_dist['tax_value'];	
}
?>