<?php include 'inc_classes.php';?>
<?php
$cust_name=$_POST['customer_id'];
if($cust_name !='')
{
	$select_name="select cust_id,cust_name,membership_id from customer where cust_id='".$cust_name."' and DATE(end_date) >=CURDATE(); ";
	$ptr_query=mysql_query($select_name);
	$data_name=mysql_fetch_array($ptr_query);
	$sel_tel = "select membership_id,membership_name,price,discount from membership where membership_id='".$data_name['membership_id']."'";	 
	$query_tel = mysql_query($sel_tel);
	if(mysql_num_rows($query_tel))
	{
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['membership_name']."###".$data_srvice['discount'];
	}
	else
	{
		echo '';
	}
}?>