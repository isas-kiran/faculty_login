<?php include 'inc_classes.php';?>
<?php
//================Pune===================
/*$select_no="select * from expense where cm_id='2' and expense_id >14683 order by added_Date asc";
$ptr_no=mysql_query($select_no);
$i=11667;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='PUN/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='2'";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
//==================Ahm=====================
/*$select_no="select * from enrollment where cm_id='60' and enroll_id >3844 order by added_date asc";
$ptr_no=mysql_query($select_no);
$j=2143;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update enrollment set ext_invoice_no='AHM/ENR/".$j."' where enroll_id='".$data_no['enroll_id']."' and cm_id='60' ";
	$ptr_update=mysql_query($update_no);
	$j++;
}
//==================PCMC====================
$select_no="select * from enrollment where cm_id='115' and enroll_id >3844 order by added_date asc";
$ptr_no=mysql_query($select_no);
$k=1525;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update enrollment set ext_invoice_no='PCM/ENR/".$k."' where enroll_id='".$data_no['enroll_id']."' and cm_id='115' ";
	$ptr_update=mysql_query($update_no);
	$k++;
}
//====================Singhgad================
$select_no="select * from enrollment where cm_id='174' and enroll_id >3844 order by added_date asc";
$ptr_no=mysql_query($select_no);
$m=1184;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update enrollment set ext_invoice_no='SIN/ENR/".$m."' where enroll_id='".$data_no['enroll_id']."' andcm_id='174' ";
	$ptr_update=mysql_query($update_no);
	$m++;
}
//====================Ahmednagar================
$select_no="select * from enrollment where cm_id='119' and enroll_id >3844 order by added_date asc";
$ptr_no=mysql_query($select_no);
$n=1161;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update enrollment set ext_invoice_no='AMD/ENR/".$n."' where enroll_id='".$data_no['enroll_id']."' and cm_id='119' ";
	$ptr_update=mysql_query($update_no);
	$n++;
}
*/
//=============================================================Product Sale============================================
/*$select_no="select sales_product_id from sales_product where cm_id='2' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update sales_product set ext_invoice_no='PUN/SAL/".$i."' where sales_product_id='".$data_no['sales_product_id']."' and cm_id='2' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================Ahm=====================
$select_no="select sales_product_id from sales_product where cm_id='60' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update sales_product set ext_invoice_no='AHM/SAL/".$i."' where sales_product_id='".$data_no['sales_product_id']."' and cm_id='60' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================PCMC====================
$select_no="select sales_product_id from sales_product where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update sales_product set ext_invoice_no='PCM/SAL/".$i."' where sales_product_id='".$data_no['sales_product_id']."' and cm_id='115' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Singhgad================
$select_no="select sales_product_id from sales_product where cm_id='174' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update sales_product set ext_invoice_no='SIN/SAL/".$i."' where sales_product_id='".$data_no['sales_product_id']."' and cm_id='174' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Ahmednagar================
$select_no="select sales_product_id from sales_product where cm_id='119' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update sales_product set ext_invoice_no='AMD/SAL/".$i."' where sales_product_id='".$data_no['sales_product_id']."' and cm_id='119' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
//================================================================SERVICE SALE==================================================
/*$select_no="select customer_service_id from customer_service where cm_id='2' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update customer_service set ext_invoice_no='PUN/SER/".$i."' where customer_service_id='".$data_no['customer_service_id']."' and cm_id='2' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================Ahm=====================
*/
/*$select_no="select customer_service_id from customer_service where cm_id='60' and customer_service_id >='9626' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=10001;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update customer_service set ext_invoice_no='AHM/SER/".$i."' where customer_service_id='".$data_no['customer_service_id']."' and cm_id='60' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
//==================PCMC====================
/*$select_no="select customer_service_id from customer_service where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update customer_service set ext_invoice_no='PCM/SER/".$i."' where customer_service_id='".$data_no['customer_service_id']."' and cm_id='115' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Singhgad================
$select_no="select customer_service_id from customer_service where cm_id='174' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update customer_service set ext_invoice_no='SIN/SER/".$i."' where customer_service_id='".$data_no['customer_service_id']."' and cm_id='174' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Ahmednagar================
$select_no="select customer_service_id from customer_service where cm_id='119' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update customer_service set ext_invoice_no='AMD/SER/".$i."' where customer_service_id='".$data_no['customer_service_id']."' and cm_id='119' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================================================Purchase Product==================================
$select_no="select inventory_id from inventory where cm_id='2' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory set ext_invoice_no='PUN/PUR/".$i."' where inventory_id='".$data_no['inventory_id']."' and cm_id='2' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
//==================Ahm=====================
$select_no="select inventory_id from inventory where cm_id='60' and vendor_id='53' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory set ext_invoice_no='AHM/PUR/INT/".$i."' where inventory_id='".$data_no['inventory_id']."' and cm_id='60' and vendor_id='53'";
	$ptr_update=mysql_query($update_no);
	$i++;
}
/*//==================PCMC====================
$select_no="select inventory_id from inventory where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory set ext_invoice_no='PCM/PUR/".$i."' where inventory_id='".$data_no['inventory_id']."' and cm_id='115' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Singhgad================
$select_no="select inventory_id from inventory where cm_id='174' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory set ext_invoice_no='SIN/PUR/".$i."' where inventory_id='".$data_no['inventory_id']."' and cm_id='174' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Ahmednagar================
$select_no="select inventory_id from inventory where cm_id='119' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update inventory set ext_invoice_no='AMD/PUR/".$i."' where inventory_id='".$data_no['inventory_id']."' and cm_id='119' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
//==================================================Expense==================================
/*$select_no="select expense_id from expense where cm_id='2' and expense_id >='13548' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=10829;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='PUN/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='2' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
//==================Ahm=====================
/*$select_no="select expense_id from expense where cm_id='60' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='AHM/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='60' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================PCMC====================
$select_no="select expense_id from expense where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='PCM/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='115' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Singhgad================
$select_no="select expense_id from expense where cm_id='174' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='SIN/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='174' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Ahmednagar================
$select_no="select expense_id from expense where cm_id='119' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='AMD/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='119' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================================================Receipt==================================
$select_no="select receipt_id from receipt where cm_id='2' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update receipt set ext_invoice_no='PUN/REC/".$i."' where receipt_id='".$data_no['receipt_id']."' and cm_id='2' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================Ahm=====================
$select_no="select receipt_id from receipt where cm_id='60' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update receipt set ext_invoice_no='AHM/REC/".$i."' where receipt_id='".$data_no['receipt_id']."' and cm_id='60' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================PCMC====================
$select_no="select receipt_id from receipt where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update receipt set ext_invoice_no='PCM/REC/".$i."' where receipt_id='".$data_no['receipt_id']."' and cm_id='115' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Singhgad================
$select_no="select receipt_id from receipt where cm_id='174' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update receipt set ext_invoice_no='SIN/REC/".$i."' where receipt_id='".$data_no['receipt_id']."' and cm_id='174' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//====================Ahmednagar================
$select_no="select receipt_id from receipt where cm_id='119' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update receipt set ext_invoice_no='AMD/REC/".$i."' where receipt_id='".$data_no['receipt_id']."' and cm_id='119' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/
?>