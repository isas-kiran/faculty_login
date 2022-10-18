<?php
function isValidURLPHP($url)
{
	return preg_match('/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/', $url);
}

function isValidEmailPHP($email)
{
	//return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email);
}

function isValidNumberPHP($number)
{
	if(is_numeric($number))	return 1;
	else return 0;
}
function isValidDatePHP($date)
{
	$date_array=explode("-",$date);
	return checkdate  ( $date_array[1],$date_array[2],$date_array[0]  );
}
function sendUserMail($to="",$subject="",$message,$from_id="")
{
	if(!$from_id)
		$from_id='support@'.$GLOBALS['domainName'].'<support@'.$GLOBALS['domainName'].'>';
	
	$sendMessage=$GLOBALS['box_message_top'];
	$sendMessage.=$message;
	$sendMessage.=$GLOBALS['box_message_bottom'];
	
	$headers= 'MIME-Version: 1.0' . "\n";
	$headers.='Content-type: text/html; charset=utf-8' . "\n";
	$headers.='From:'.$from_id;
	//echo $to.$sendMessage;
	if(mail($to, $subject, $sendMessage, $headers))
		return 1;
	else
		return 0;
}	
?>
<script>
function roundNumber(num, scale) {
	if(!("" + num).includes("e")) {
		return +(Math.round(num + "e+" + scale) + "e-" + scale);
		} else {
			var arr = ("" + num).split("e");
			var sig = ""
			if(+arr[1] + scale > 0) {
			sig = "+";
		}
		return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
  	}
}
</script>