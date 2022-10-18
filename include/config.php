	<?php
	ini_set('display_errors', 1);
	/*if(basename($_SERVER['REQUEST_URI'])=='config.php')
	{
		//header("location:../login.php?msg=Access Denied...!");
	}*/
	$domainName="isasbeautyschool.com";
	$adminEmail="erp.isas@gmail.com";
    $pre_db="";
	//Databse configuration local server
    if($_SERVER['HTTP_HOST']=="localhost" || $_SERVER['HTTP_HOST']=="192.168.2.105")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
    {
	$host 			= "localhost";
	$dbuid			= "root";
	$dbpwd 			= "";
	$dbname			= "isasbeautyschool.org";
    }
    else
    {
	$host 			= "localhost";
	$dbuid			= "root";
	$dbpwd 			= "";
	$dbname			= "isasbeautyschool.org";
    }  
	
	$con1 = mysql_connect($host ,$dbuid, $dbpwd);
	mysql_select_db($dbname,$con1 );   
    $box_message_top='<br>
        <table style=" color:#FFFFFF; width:100%; background-color:#CD2122"><tr><td>
        <table align="center" width="100%" cellpadding="1" cellspacing="1">
        <tr><td style="color:#FFFFFF;padding-left:10px;	font-size:18px;	font-weight:600;padding-top:5px; padding-bottom:5px;">Messages From '.ucfirst($domainName).'</td></tr>
        <tr><td style="color:#0F7ACD; padding:8px; background-color:#FFFFFF;" align="left">';
    $box_message_bottom='</td></tr>
	</table></td></tr>
	</table>';
    //echo 'hi';
    $show_records = 10;

    $escapeCharacters=array('?','&','/','\\','%','"',':');    
?>
