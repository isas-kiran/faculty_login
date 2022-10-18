<?php include 'inc_classes.php';?>
<?php
$voucher_id=$_POST['voucher_id'];
$qty=$_POST['qty'];
$codes='';
if($voucher_id !='' && $qty >0)
{
	$sel_vou_codes="select voucher_code,voucher_code_id from voucher_code_map where voucher_id='".$voucher_id."' and status='active' order by voucher_code_id asc limit 0,".$qty."";
	$ptr_voucher_code=mysql_query($sel_vou_codes);
	$i=1;
	while($data_codes=mysql_fetch_array($ptr_voucher_code))
	{
		$codes .="<span style='font-size:16px; font-weight:400; color:#00F'>".$i.")  ".$data_codes['voucher_code']."    &nbsp;&nbsp;&nbsp; ".$data_codes['status']."<input type='hidden' name='code".$i."' id='code".$i."' value='".$data_codes['voucher_code_id']."'></span></br>"; 
		$i++;
	}
	echo $codes;
}
?>	
