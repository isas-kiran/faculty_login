<?php 
error_reporting(E_ALL); 
ini_set("display_errors", 1);
include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Mail</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<body>
<?php
/*$mobile='9822519894';
$message='Hi kiran is here checking SMS';

$service_url = "http://103.16.101.52:8080/sendsms/bulksms?username=".urlencode('kapd-santosh')."&password=".urlencode('sapke')."&type=0&dlr=1&destination=".$mobile."&source=ISASBS&message=".urldecode($message)."";
		//$service_url ="http://sms.digicalmmedia.com/vendorsms/pushsms.aspx?user=isasbeauty01&password=MM55A8QX&msisdn=".$mobile."&sid=ISASBS&msg=".urldecode($message)."&fl=0&gwid=2";
	
	echo ' <iframe src="'.$service_url.'" id="iframe" style="display:none"></iframe> ';	*/	
$AttendanceTime='1578327943';
echo "<br/>".$punchTime=gmdate("Y-m-d H:i:s", $AttendanceTime);
echo "<br/>".$ChkPunchTime=gmdate("Y-m-d", $AttendanceTime);
$UserId="1";
echo "<br/>Month".$month=date("m", strtotime($punchTime));
echo "<br/>Year".$year=date("Y", strtotime($punchTime));
//echo "<br/>Total Days".date("Y", strtotime($punchTime));
$number = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
echo "<br/>Total Days {$number} days in {$month} month";

echo "<br/>".$sql_user = "select * from pr_pune_biometric_attendance where UserId='".trim($UserId)."' and DATE(PunchTime)='".date($ChkPunchTime)."' order by ID desc";
$result_user = mysql_query($sql_user);
if (mysql_num_rows($result_user) > 0) 
{
	$punchDate=$ChkPunchTime;
	$data_attendace = mysql_fetch_assoc($result_user);
	if($data_attendace['AttendanceType']=='CheckIn')
	{
		$PunchInData=explode(" ",$data_attendace['PunchTime']);
		$CheckIn=$PunchInData[1];
		echo "<br/>".$punchTime=gmdate("Y-m-d H:i:s", $data_attendace['AttendanceTime']);
		echo "<br/>".$differTime=abs($AttendanceTime - $data_attendace['AttendanceTime'] )/60;		
	}
	else if($data_attendace['AttendanceType']=='CheckOut')
	{
		echo "No data";
	}
}

?>
</body>
</html>