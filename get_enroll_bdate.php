<?php 
include 'inc_classes.php';
include "include/headHeader.php";
$current_date = date("Y-m-d");
$next_date = date('Y-m-d', strtotime($current_date. ' + 10 day'));
$subscription_date  = date("d-m", strtotime($subscription));

$sel_bdate="select name,dob,contact from enrollment where 1 and DATE_FORMAT(dob, '%m-%d') > DATE_FORMAT('".$current_date."', '%m-%d') and DATE_FORMAT(dob, '%m-%d') < DATE_FORMAT('".$next_date."', '%m-%d') and ref_id <=0";
$ptr_dates=mysql_query($sel_bdate);
while($bdate_data=mysql_fetch_array($ptr_dates))
{
	$text="This is test sms";
	$type="promotional";
	echo $bdate_data['name']."  -  ".$bdate_data['dob']."  -  ".$bdate_data['contact']."<br/>";
	 send_sms_function($bdate_data['contact'],$text,$type);
}
?>