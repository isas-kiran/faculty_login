<?php include 'inc_classes.php';?>
<?php
$sel_ser="select * from customer_service_invoice";
$ptr_sel=mysql_query($sel_ser);
while($data_ser=mysql_fetch_array($ptr_sel))
{
	$sel_cust_serv="select * from customer_service where customer_service_id='".$data_ser['customer_service_id']."'";
	$ptr_cust_serv=mysql_query($sel_cust_serv);
	$data_cust_Serv=mysql_fetch_array($ptr_cust_serv);
	
	$apply_gst=$data_cust_Serv['apply_gst'];
	$show_gst=$data_cust_Serv['show_gst'];
	$gst_type=$data_cust_Serv['gst_type'];
	
	$cgst_tax_in_per=0;
	$sgst_tax_in_per=0;
	$igst_tax_in_per=0;
	$gst_val=0;
	$igst_val=0;
	$cgst_val=0;
	$sgst_val=0;
	$payble_amnt=$data_ser['payable_amount'];
	if($gst_type=='m_gst')
	{
		$cgst_tax_in_per=$data_cust_Serv['cgst_tax_in_percent'];
		$sgst_tax_in_per=$data_cust_Serv['sgst_tax_in_percent'];
		$cgst_val=$payble_amnt * ($cgst_tax_in_per / 100);
		$sgst_val=$payble_amnt * ($sgst_tax_in_per / 100);
		$gst_val=round($cgst_val+$sgst_val,2);
	}
	else if($gst_type=='m_igst')
	{
		$igst_tax_in_per=$data_cust_Serv['igst_tax_in_percent'];
		$gst_val=$igst_val=round($payble_amnt * ($igst_tax_in_per / 100),2);
	}
		
	$excluded_amnt=$payble_amnt - $gst_val;
	
	$update_qry="update customer_service_invoice set show_gst='".$show_gst."',apply_gst='".$apply_gst."',gst_type='".$gst_type."',cgst_tax_in_percent='".$cgst_tax_in_per."',sgst_tax_in_percent='".$sgst_tax_in_per."',igst_tax_in_percent='".$igst_tax_in_per."',cgst_tax='".$cgst_val."',sgst_tax='".$sgst_val."',igst_tax='".$igst_val."',excluded_tax_amount='".$excluded_amnt."' where invoice_id='".$data_ser['invoice_id']."'";
	//$ptr_update=mysql_query($update_qry);
	//echo "<br/>Cust_id - ".$data_ser['customer_service_id']."- Apply GST- ".$apply_gst."- GST Type - ".$gst_type."- GST Val - ".$gst_val."- Ex amnt - ".$excluded_amnt;
}



















?>