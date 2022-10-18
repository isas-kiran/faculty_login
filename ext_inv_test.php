<?php include 'inc_classes.php';?>
<?php


$select_no="select expense_id from expense where cm_id='2' and expense_id >='11070' order by expense_id asc";
$ptr_no=mysql_query($select_no);
$i=9149;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='PUN/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='2' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}
//==================Ahm=====================
/* $select_no="select expense_id from expense where cm_id='60' and expense_id >='11066' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=3944;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='AHM/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='60' ";
	$ptr_update=mysql_query($update_no);
	$i++;
} */
//==================PCMC====================
/* $select_no="select expense_id from expense where cm_id='115' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='PCM/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='115' ";
	$ptr_update=mysql_query($update_no);
	$i++;
} */
//====================Singhgad================
/* $select_no="select expense_id from expense where cm_id='174' and expense_id >='9747' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1160;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='SIN/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='174' ";
	$ptr_update=mysql_query($update_no);
	$i++;
} */
//====================Ahmednagar================
/*$select_no="select expense_id from expense where cm_id='119' order by added_date asc";
$ptr_no=mysql_query($select_no);
$i=1111;
while($data_no=mysql_fetch_array($ptr_no))
{
	$update_no="update expense set ext_invoice_no='AMD/EXP/".$i."' where expense_id='".$data_no['expense_id']."' and cm_id='119' ";
	$ptr_update=mysql_query($update_no);
	$i++;
}*/

?>