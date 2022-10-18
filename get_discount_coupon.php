<?php include 'inc_classes.php';?>
<?php
$discount_coupon=$_POST['discount_coupon'];
if($discount_coupon !='')
{
	$sel_discount_coupon="SELECT * FROM discount_coupon where code='".$discount_coupon."' and status='Active' and start_date<='".date('Y-m-d')."' and end_date>='".date('Y-m-d')."' order by discount_coupon_id asc ";
	$ptr_discount_coupon =  mysql_query($sel_discount_coupon);
	if(mysql_num_rows($ptr_discount_coupon))
	{
		$data_discount_coupon = mysql_fetch_array($ptr_discount_coupon);
		echo "Discount Code Applied Successfully##".$data_discount_coupon['discount'];
	}
	else
	{
		echo "Discount Code Is Not Valid or Expired ##0";
	}
}
?>