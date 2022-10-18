<?php include 'inc_classes.php';?>
<?php
$voucher_id=$_POST['voucher_id'];
$cust_id=$_POST['cust_id'];
$voucher_code=$_POST['voucher_code'];
$action=$_POST['action'];
if($voucher_id !='')
{
	$sele_voucher_price="select amount,id from sales_package_voucher_memb where cust_id='".$cust_id."' and voucher_id='".$voucher_id."' and status='active'";
	$ptr_sale=mysql_query($sele_voucher_price);
	$data_fetch=mysql_fetch_array($ptr_sale);
	
	$sel_tel = "select voucher_id,deal_name,start_date,end_date,amount,quantity_for_amount,category,redeam_amount from voucher where voucher_id='".$voucher_id."'";	 
	$query_tel = mysql_query($sel_tel);
	$data_srvice = mysql_fetch_array($query_tel);
	if($data_fetch['amount'] =='')
	{
		$price=$data_srvice['amount'];
	}
	else
	{
		$price=$data_fetch['amount'];
	}
	$sel_red= "select redeem_price from voucher_customer_code_map where voucher_id='".$voucher_id."' and customer_id='".$cust_id."' and sales_id='".$data_fetch['id']."' and voucher_code_id ='".$voucher_code."'";	 
	$query_red= mysql_query($sel_red);
	if(mysql_num_rows($query_red))
	{
		$data_red_price= mysql_fetch_array($query_red);
		$redeem_price=$data_red_price['redeem_price'];
	}
	else if($action=="sales")
	{
		$redeem_price=$data_srvice['redeam_amount'];
	}
	
	echo $data_srvice['deal_name'].'/'.$price.'/'.$data_srvice['start_date'].'/'.$data_srvice['end_date']."/".$data_srvice['quantity_for_amount']."/".$data_srvice['category']."/".$redeem_price;
	echo"###";
	$sel_voucher_service="select service_id,voucher_id from voucher_service_map where voucher_id='".$voucher_id."'";
	$ptr_voucher=mysql_query($sel_voucher_service);
	$total=mysql_num_rows($ptr_voucher);
	$i=1;
	while($data_voucher=mysql_fetch_array($ptr_voucher))
	{
		$sel_svcsm="select svm_id from sales_customer_service_voucher_map where service_id='".$data_voucher['service_id']."' and voucher_id='".$data_voucher['voucher_id']."' and voucher_code_id ='".$voucher_code."' and quantity > 0 ";
		$ptr_svcsm=mysql_query($sel_svcsm);
		if(mysql_num_rows($ptr_svcsm))
		{
			$voucher_service_cnt .=$data_voucher['service_id'];
			if($i!=$total)
			{
				$voucher_service_cnt .=",";
			}
		}
		$i++;
	}
	echo $voucher_service_cnt;
}
?>	
