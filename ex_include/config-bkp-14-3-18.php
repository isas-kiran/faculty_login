<?php

if(basename($_SERVER['REQUEST_URI'])=='config.php')

	{

		header("location:../login.php?msg=Access Denied...!");

	}



	//Email responses

	$domainName="cidescomcq.com";

	$adminEmail 		= "sudhir.pawar@waakan.com";

    $pre_db            ="";

	//Databse configuration local server

     if($_SERVER['HTTP_HOST']=="localhost:81" )//|| $_SERVER['HTTP_HOST']=="hindavi-1"

    {

	$host 			= "localhost";

	$dbuid			= "root";

	$dbpwd 			= "";

	$dbname			= "online_exams_new";

    }

    else

    {

	$host 			= "localhost";

	$dbuid			= "cidescom_mcq";

	$dbpwd 			= "Waakan@2017*";

	$dbname			= "cidescom_mcq";

    }     

    $box_message_top='<br>

        <table style=" color:#FFFFFF; width:100%; background-color:#98BB49"><tr><td>

        <table align="center" width="100%" cellpadding="1" cellspacing="1">

        <tr><td style="color:#FFFFFF;padding-left:10px;	font-size:18px;	font-weight:600;padding-top:5px; padding-bottom:5px;">'.ucfirst($domainName).' Messages</td></tr>

        <tr><td style="color:#0F7ACD; padding:8px; background-color:#FFFFFF;" align="left">';

    $box_message_bottom='</td></tr>

	</table></td></tr>

	</table>';



    $show_records = 10;



    $escapeCharacters=array('?','&','/','\\','%','"',':');    

?>

