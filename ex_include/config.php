<?php
if(basename($_SERVER['REQUEST_URI'])=='config.php')
{
	header("location:../login.php?msg=Access Denied...!");
}
//Email responses
$domainName="cidescomcq.com";
$adminEmail= "erp.isas@gmail.com";
$pre_db="";
//Databse configuration local server
if($_SERVER['HTTP_HOST']=="localhost" )
{
	$host="localhost";
	$dbuid="root";
	$dbpwd="";
	$dbname="online_exams_new";
}
else
{
	$host="localhost";
	$dbuid="isas_exam";
	$dbpwd="Isasexam@2019";
	$dbname="isas_exam";
	
	
	$host_2="localhost";
	$dbuid_2="isasadmin";
	$dbpwd_2="isasadmin007";
	$dbname_2="isasbeautyschool_org";
	
}
    	$con1 = mysql_connect($host ,$dbuid, $dbpwd);
	mysql_select_db($dbname,$con1 ); 
	
		$con2 = mysql_connect($host_2 ,$dbuid_2, $dbpwd_2);
	mysql_select_db($dbname_2,$con2 ); 
	
	$box_message_top='<br>
    <table style=" color:#FFFFFF; width:100%; background-color:#98BB49"><tr><td>
	<table align="center" width="100%" cellpadding="1" cellspacing="1">
	<tr><td style="color:#FFFFFF;padding-left:10px;	font-size:18px;	font-weight:600;padding-top:5px; padding-bottom:5px;">'.ucfirst($domainName).' Messages</td></tr>
	<tr><td style="color:#0F7ACD; padding:8px; background-color:#FFFFFF;" align="left">';
    $box_message_bottom='</td></tr>
	</table></td></tr>
	</table>';
    $show_records=10;
    $escapeCharacters=array('?','&','/','\\','%','"',':');    
?>