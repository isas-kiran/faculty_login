<?php include 'inc_classes.php';?>
<?php
$voucher_id=$_POST['voucher_id'];
$cust_id=$_POST['cust_id'];
$voucher_code=trim($_POST['voucher_code']);
if($voucher_id !='' && $cust_id !='' && $voucher_code!='')
{
	$sel="select voucher_code_id from voucher_customer_code_map where customer_id='".$cust_id."' and voucher_id='".$voucher_id."' and status='active' ";
	$ptr_sel=mysql_query($sel);
	if(mysql_num_rows($ptr_sel))
	{
		$no=0;
		while($data_codes=mysql_fetch_array($ptr_sel))
		{
			$sele_match="select voucher_code,voucher_code_id from voucher_code_map where voucher_code_id='".$data_codes['voucher_code_id']."' and voucher_id='".$voucher_id."'";
			$ptr_match=mysql_query($sele_match);
			if(mysql_num_rows($ptr_match))
			{
				$data_match=mysql_fetch_array($ptr_match);
				if(trim($voucher_code)==trim($data_match['voucher_code']))
				{
					$no=$no+1;
					$code=$data_match['voucher_code_id'];
				}
			}
		}
		echo $no;
		echo "###".$code;
	}
}
?>