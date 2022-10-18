<?php 
error_reporting(E_ALL); 
ini_set("display_errors", 1);
include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>test sms</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<body>
<?php
$mobile='9822519894';
$message='Hi kiran is here checking SMS in freelancer';

/*
// Account details
$user = urlencode('isasbeauty01');
// Message details
$numbers = 919822519894;
$password = urlencode('MM55A8QX');
$sid=urlencode('ISASBS');
$message = rawurlencode('This is TEST message');
 
// Prepare data for POST request
$data = array('user' => $user,'password' => $password, 'msisdn' => $numbers, "sid" => $sid, "msg" => $message);
// Send the POST request with cURL
$ch = curl_init('http://sms.digicalmmedia.com/vendorsms/pushsms.aspx?');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;*/

$service_url ="http://sms.digicalmmedia.com/vendorsms/pushsms.aspx?user=isasbeauty01&password=MM55A8QX&msisdn=".$mobile."&sid=ISASBS&msg=".urlencode($message)."&fl=0&gwid=2";

$homepage = file_get_contents($service_url);
if($homepage)
{
  echo "Message Send Compleated...";
}
else{
  echo "Something Went Wrong...";
}

//$service_url = "http://103.16.101.52:8080/sendsms/bulksms?username=".urlencode('kapd-santosh')."&password=".urlencode('sapke')."&type=0&dlr=1&destination=".$mobile."&source=ISASBS&message=".urldecode($message)."";
		//$service_url ="http://sms.digicalmmedia.com/vendorsms/pushsms.aspx?user=isasbeauty01&password=MM55A8QX&msisdn=".$mobile."&sid=ISASBS&msg=".urldecode($message)."&fl=0&gwid=2";
		
		//$service_url ="http://sms.digicalmmedia.com/vendorsms/pushsms.aspx?user=isasbeauty01&password=MM55A8QX&msisdn=9822519894&sid=ISASBS&msg=this+message+from+isas+new+system+7pm&fl=0&gwid=2";
		
		//"http://sms.digicalmmedia.com/vendorsms/pushsms.aspx?user=isasbeauty01&password=MM55A8QX&msisdn=9822519894&sid=ISASBS&msg=this+message+from+isas+new&fl=0&gwid=2";
	
	//echo ' <iframe src="'.$service_url.'" id="iframe" style="display:none"></iframe> ';		
?>
</body>
</html>