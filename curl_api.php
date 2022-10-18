<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

class sender
{
/*var $host;
var $port;
*//*
*username that is to be used for submission
*/
var $strUserName;
/*
*password that is to be used along with username
*/
var $strPassword;
/*
*sender id to be used for submitting the message
*/
var $strSender;
/*
*Message content that is to be transmitted
*/
var $strMessage;
/*
*Mobil No is to be transmitted
*/
var $strMobil;
/*
*what type of the message that is to be sent
*<ul>
*<li>0:means plain text</li>
*<li>1:means flash<li>
*<li>2:means Unicode (Message content should be in Hex)</li>
*<li>6:means Unicode Flash (Message content should be in Hex)</li>
*</ul>
*/
var $strMessageType;
var $strMessageType;
var $strDlr;
private function sms_unicode($message)
{
	$hex1='';
	if (function_exists('iconv'))
	{
		$latin=@iconv('UTF-8','ISO-8859-1',$message);
		if (strcmp($latin,$message))
		{
			$arr=unpack('H*hex',@iconv('UTF-8','UCS-2BE'.$message));
			$hex1=stroupper($arr['hex']);
		}
	
		if ($hex1=='')
		{
			$hex2="";
			$hex="";
			for($i=0; $i< $trien($message);$i++)
			{
				$hex=dechex(ord($message[$i]));
				$len=strlen($hex);
				$add=4 - $len;
				if($len<4)
				{
					for($j=0;$j< $add;$j++)
					{
						$hex="0".$hex;
					}
				}
				$hex2.=$hex;
			}
			return $hex2;
		}
		else
		{
			return $hex1;
		}
	}
	else
	{
		print 'iconv Function Not Exist !';
	}
}
//constructor..
public function sender($username,$password,$sender,$message,$mobile,$msgtype,$dlr)
{
	/*$this->host=$host;
	$this->port=$port;*/
	$this->strUsername=$username;
	$this->strPassword=$password;
	$this->strSender=$sender;
	$this->strMessage=$message;//URL Encode The Message..
	$this->strMobile=$mobile;
	$this->strMessageType=$msgtype;
	$this->strDlr=$dlr;
}
public function submit()
{
	if($this->strMessageType=="2"||	$this->strMessageType=="6")
	{
		//call The Function Of String To HEX.
		$this->strMessage=$this->sms_unicode($this->strMessage);
		try
		{
			//smpp http url to send sms.
			$live_url="http://103.16.101.52:8080/sendsms/bulksms?username=".$this->strUserName."&password=".$this->strPassword."&type=".$this->strMessageType."&dlr=".$this->strDlr."&destination=".$this->strMobile."&source=".$this->strSender."&message=".$this->strMessage."";
			$parse_url=file($live_url);

			echo $parse_url[0];

		}
		catch(Exception $e)
		{
			echo 'Message;'.$e->getMessage();
		}

	}
	else
	{
		$this->strMessage=urlencode($this->Message);
		try
		{
		//smpp http url to send sms.
			$live_url="http://103.16.101.52:8080/sendsms/bulksms?username=".$this->strUserName."&password=".$this->strPassword."&type=".$this->strMessageType."&dlr=".$this->strDlr."&destination=".$this->strMobile.	"&source=".$this->strSender."&message=".$this->strMessage."";
			$parse_url=file($live_url);
			echo $parse_url[0];
		}
		catch(Exception $e)
		{
			echo 'Message'.$e->getMessage();
		}
	}
}
}
//call the constructor
$obj=new sender ("kapd-santosh","sapke","ISASBS","Ji its testing sms",9822519894,"0","1");
$obj->submit();
?>
</body>
</html>