<?php include 'inc_classes.php';?>
<?php

$select_no="select * from inventory_invoice where cm_id='60' and invoice_id >='2919' and payable_amount>0 order by invoice_id asc";
$ptr_no=mysql_query($select_no);
$i=413;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory_invoice set receipt_no='AHM-".$i."' where invoice_id='".$data_no['invoice_id']."' and cm_id='60'";
	$ptr_update=mysql_query($update_no);
	$i++;
}
/*$select_no="select * from sales_product_invoice where cm_id='60' and invoice_id >='4111' order by invoice_id asc";
$ptr_no=mysql_query($select_no);
$i=1101;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update sales_product_invoice set receipt_no='AHM-".$i."' where invoice_id='".$data_no['invoice_id']."' and cm_id='60' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
/*$select_no="select * from inventory_invoice where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=101;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory_invoice set receipt_no='PCMC-".$i."' where invoice_id='".$data_no['invoice_id']."' and cm_id='115'  ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
$select_no="select * from inventory_invoice where cm_id='119' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=101;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory_invoice set receipt_no='AMD-".$i."' where invoice_id='".$data_no['invoice_id']."' and cm_id='119'  ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
$select_no="select * from inventory_invoice where cm_id='174' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=101;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory_invoice set receipt_no='SING-".$i."' where invoice_id='".$data_no['invoice_id']."' and cm_id='174'  ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/

/*$select_no="select * from invoice where cm_id='2' and amount>0  and status!='Change Installment' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=5454;
while($data_no=mysql_fetch_array($ptr_no))
{
	echo "<br/>".$update_no="update invoice set receipt_no='PUN-".$i."' where invoice_id='".$data_no['invoice_id']."'  ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/

/*$select_no="select * from customer_service_invoice where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=5454;
while($data_no=mysql_fetch_array($ptr_no))
{
	echo "<br/>".$update_no="update customer_service_invoice set receipt_no='PCMC-".$i."' where invoice_id='".$data_no['invoice_id']."'  ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/

?>
