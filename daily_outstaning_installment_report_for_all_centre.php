<?php include 'inc_classes.php';?>
<?php
//====================== Connection 1 - PUNE PVT LTD ============================
$host = "localhost";
$dbuid = "isasadmin";
$dbpwd = "isasadmin007";
$dbname = "isasbeautyschool_org";

$link1 = mysql_connect($host ,$dbuid, $dbpwd);
mysql_select_db($dbname,$link1);
// Check for connection
if($link1 == true) {
    //echo "database1 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
//======================= Connection 2 - PUNE LLP ================================
$host1 = "localhost";
$dbuid1	= "isasllp";
$dbpwd1 = "isasllp!@!2021";
$dbname1 = "isas.llp";

$link2 = mysql_connect($host1 ,$dbuid1, $dbpwd1);
mysql_select_db($dbname1,$link2);
// Check for connection
if($link2 == true) {
    //echo "database2 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
//======================= Connection 3 - Dubai ===================================
$host3 = "localhost";
$dbuid3	= "isas_dubai";
$dbpwd3 = "isas_dubai@007";
$dbname3 = "isas_dubai";

$link3 = mysql_connect($host3 ,$dbuid3, $dbpwd3);
mysql_select_db($dbname3,$link3);
// Check for connection
if($link3 == true) {
    //echo "database2 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
//================================================================================

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Outstanding Report For All Branches</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
</head>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<script>
/*function send_emil_to_oceanone(email_id,subject,message,headers)
{
	//alert(email_id);
	var data12="send_email=yes&email_id='"+email_id+"'&subject="+subject+"&body_message="+message+"&header="+headers;
	//alert(data12);
	$.ajax({
            url: "http://htdpt.in/universal/solar_heater/send_email.php", type: "post", data: data12, cache: false,
            success: function (retrive_func)
            {
				
				 //alert(retrive_func);
			},
        error: function (jqXHR, exception) {
            getErrorMessage(jqXHR, exception);
        },	
    		
		});
}*/
function getErrorMessage(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    alert(msg);
}
</script>
<body>
<?php
//================================================Bank Summary===================================================== 
	$sep_url_string='';
	$sep_url= explode("?",$_SERVER['REQUEST_URI']);
	if($sep_url[1] !='')
	{
		$sep_url_string="&".$sep_url[1];
	}
	
	$date=date('Y-m-d');
	$date_for_month=date('Y-m');
	if($_REQUEST['date'] && $_REQUEST['date']!=="0000-00-00" && $_REQUEST['date']!="date")
	{
		$frm_date=explode("/",$_REQUEST['date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$date=date('Y-m-d',strtotime($frm_dates));
		$date_for_month=date('Y-m',strtotime($frm_dates));
	}
	
	$search_cm_id='';
	$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$search_cm_id_i=" and i.cm_id='".$data_cm_id['cm_id']."'";
			$cm_ids=$data_cm_id['cm_id'];
		}
		else
		{
			$search_cm_id=" ";
			$search_cm_id_i=" ";
			$cm_ids='';
		}
	}
	if($_SESSION['where']!='')
	{
		$where_i=" and i.cm_id='".$_SESSION['cm_id']."'";
	}
	if($_REQUEST['page'])
		$page=$_REQUEST['page'];
	else
		$page=0;
	
	if($_REQUEST['show_records'])
		$show=$_REQUEST['show'];
	else
		$show=0;
	
	if($_GET['order']=='asc')
	{
		$order='desc';
		$img = "<img src='images/sort_up.png' border='0'>";
	}
	else if($_GET['order']=='desc')
	{
		$order='asc';
		$img = "<img src='images/sort_down.png' border='0'>";
	}
	else
		$order='desc';
	
	if($_GET['orderby']=='name' )
		$img1 = $img;
	
	if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	$message.='<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">';
	$message.='<tr>
					<td align="center" colspan="10">Outstanding Report for '.$date.'</td>
				</tr>
				<tr class="grey_td head_td">
					<td colspan="12">
						<table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #CCC">
							<tr style="background-color:#999;color: black">
								<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
								<td width="15%" align="center" style="border:1px solid #CCC"><strong>Branch Name</strong></td>
								<td width="20%" align="center" style="border:1px solid #CCC"><strong>Student Name</strong></td>
								<td width="20%" align="center" style="border:1px solid #CCC"><strong>Course Name</strong></td>
								<td width="20%" align="center" style="border:1px solid #CCC"><strong>Installment Amount</strong></td>
								<td width="20%" align="center" style="border:1px solid #CCC"><strong>Councilor Name</strong></td>
							</tr>';				
				
				//-----------------ISAS PVT LTD-------------------------
				$sele_cm="select DISTINCT(cm_id) as cm_id from site_setting where 1 and type='A' and system_status='Enabled' order by cm_id asc";
				$ptr_cm=mysql_query($sele_cm,$link1);
				if(mysql_num_rows($ptr_cm))
				{
					$bgColorCounter=1;
					while($data_cmids=mysql_fetch_array($ptr_cm))
					{
						$search_cm_id=" and cm_id ='".$data_cmids['cm_id']."'";
						$search_cm_id_e=" and e.cm_id ='".$data_cmids['cm_id']."'";
						// and DATE(added_date)='".$date."' ".$_SESSION['where']." ".$search_cm_id."
						//=====================BANK BALANCE=========================
						$sql_query="select e.*,i.installment_amount from enrollment e, installment i where e.enroll_id=i.enroll_id and DATE(i.installment_date)='".$date."' ".$search_cm_id_e." order by e.enroll_id desc";
						$ptr_records=mysql_query($sql_query,$link1); //and system_status='Enabled'
						$no_of_records=mysql_num_rows($ptr_records);
						if($no_of_records)
						{
							$i=1;
							$k=1;
							while($data_ptr_sel1=mysql_fetch_array($ptr_records))
							{
								if($bgColorCounter%2==0)
									$bgcolor='class="grey_td"';
								else
									$bgcolor="";                
								$listed_record_id=$data_ptr_sel1['enroll_id'];
								
								$message.='<tr>';
								$message.='<td align="center" style="border:1px solid #CCC">'.$i.'</td>';
								
								$sel_bal="select branch_name from site_setting where cm_id='".$data_ptr_sel1['cm_id']."'";
								$ptr_bal=mysql_query($sel_bal,$link1);
								$dara_bal=mysql_fetch_array($ptr_bal);
								
								$sel_course="select course_name from courses where course_id='".$data_ptr_sel1['course_id']."'";
								$ptr_course=mysql_query($sel_course,$link1);
								$data_course=mysql_fetch_array($ptr_course);
								
								$sel_admin="select name from site_setting where admin_id='".$data_ptr_sel1['assigned_to']."'";
								$ptr_admin=mysql_query($sel_admin,$link1);
								$dara_admin=mysql_fetch_array($ptr_admin);
								
								$message.='<td align="center" style="border:1px solid #CCC">'.$dara_bal['branch_name'].'</td>';

								$message.='<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['name'].'</td>';
								
								$message.='<td align="center" style="border:1px solid #CCC">'.$data_course['course_name'].'</td>';
								$message.='<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['installment_amount'].'</td>';
								$message.='<td align="center" style="border:1px solid #CCC">'.$dara_admin['name'].'</td>';
								
								$message.= '</tr>';
								$i++;
								$k++;
								$bgColorCounter++;
								$rno++;
							}
						}
					}
				}
//===============================********************* ISAS LLP ***********************===================================
				$sele_cm="select DISTINCT(cm_id) as cm_id from site_setting where 1 and type='A' and system_status='Enabled' order by cm_id asc";
				$ptr_cm=mysql_query($sele_cm,$link2);
				if(mysql_num_rows($ptr_cm))
				{
					$bgColorCounter=1;
					while($data_cmids=mysql_fetch_array($ptr_cm))
					{
						$search_cm_id=" and cm_id ='".$data_cmids['cm_id']."'";
						$search_cm_id_e=" and e.cm_id ='".$data_cmids['cm_id']."'";
						//==============$$$$$$$$$$$===Bank Balance====$$$$$$$$$$=======================
						
						$sql_query1="select e.*,i.installment_amount from enrollment e, installment i where e.enroll_id=i.enroll_id and DATE(i.installment_date)='".$date."' ".$search_cm_id_e." order by e.enroll_id desc";
						$ptr_records1=mysql_query($sql_query1,$link2); //and system_status='Enabled'
						$no_of_records2=mysql_num_rows($ptr_records1);
						if($no_of_records2)
						{
							$k=1;
							while($data_ptr_sel2=mysql_fetch_array($ptr_records1))
							{
								if($bgColorCounter%2==0)
									$bgcolor='class="grey_td"';
								else
									$bgcolor="";                
								$listed_record_id=$data_ptr_sel2['enroll_id'];
								
								$message.= '<tr>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';
								
								$sel_bal="select branch_name from site_setting where cm_id='".$data_ptr_sel2['cm_id']."'";
								$ptr_bal=mysql_query($sel_bal,$link2);
								$dara_bal=mysql_fetch_array($ptr_bal);
								
								$sel_course="select course_name from courses where course_id='".$data_ptr_sel2['course_id']."'";
								$ptr_course=mysql_query($sel_course,$link2);
								$data_course=mysql_fetch_array($ptr_course);
								
								$sel_admin="select name from site_setting where admin_id='".$data_ptr_sel2['assigned_to']."'";
								$ptr_admin=mysql_query($sel_admin,$link2);
								$dara_admin=mysql_fetch_array($ptr_admin);
								
								
								if($data_ptr_sel2['cm_id']=='2')
								{
									$branch_names='ISAS LLP Pune';
								}
								else
									$branch_names=$dara_bal['branch_name'];
										
								$message.= '<td align="center" style="border:1px solid #CCC">'.$branch_names.'</td>';
								
								$message.='<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel2['name'].'</td>';
								
								$message.='<td align="center" style="border:1px solid #CCC">'.$data_course['course_name'].'</td>';
								$message.='<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel2['installment_amount'].'</td>';
								$message.='<td align="center" style="border:1px solid #CCC">'.$dara_admin['name'].'</td>';
								
								$message.= '</tr>';
								$i++;
								$k++;
								$bgColorCounter++;
								$rno++;
							}
						}
					}
				}
				
			$message.='</table>
					</td>
				</tr>
			</table>';
					
			/*------------send a mail to admin about this---------------------*/
			$subject =" ISAS - Todays Outstanding Installment Report - ".date('d/m/Y')."";
			
			$sendMessage=$GLOBALS['box_message_top'];
			echo $sendMessage.=$message;
			echo "<input type='hidden' name='mail_content' id='mail_content' value='".addslashes($sendMessage)."'>";
			//===================================================================================//21-12-17
			$mail = new PHPMailer(true);
			try {
					//$mail->IsSMTP();                                      // Set mailer to use SMTP
					$mail->SMTPDebug=1;   
					$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'erp.isas@gmail.com';                   // SMTP username
					$mail->Password = 'erp@frespa';                            // SMTP password
					$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
					$mail->Port = 465;
					$mail->setFrom('info@isasbeautyschool.com', 'ISAS');
					$mail->addAddress("erp.isas@gmail.com"); 
					$mail->addCC("isas.yogita@gmail.com"); 
					$mail->addCC("sachin@isas.in");
					$mail->addCC("sm@isas.in"); 
					$mail->addCC("isasho.qa@gmail.com"); 
					
					/*$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='103' and cm_id='".$cm_id1."'";
					$ptr_sel_sms=mysql_query($sel_sms_cnt);
					$tot_num_rows=mysql_num_rows($ptr_sel_sms);
					$i=0;
					while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
					{
						$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' and type!='S' and system_status='Enabled' ";
						$ptr_cnt=mysql_query($sel_act);
						if(mysql_num_rows($ptr_cnt))
						{
							$data_cnt=mysql_fetch_array($ptr_cnt);
							$emailss=trim($data_cnt['email']);
							$mail->addCC("$emailss"); 
							$i++;
						}
					}
					
					$sel_act="select contact_phone,email from site_setting where type='S' and email!='' and system_status='Enabled' ";
					$ptr_cnt=mysql_query($sel_act);
					if(mysql_num_rows($ptr_cnt))
					{
						$j=$tot_num_rows;
						while($data_cnt=mysql_fetch_array($ptr_cnt))
						{
							$email2=trim($data_cnt['email']);
							$mail->addCC("$email2"); 
							$j++;
						}
					}*/
					
					///usr/local/bin/php -q /home/isasadmin007/isastest/faculty_login/dsr_mail.php?&send_mail=mail
					///bin/touch /home/isasadmin007/public_html/cron_test.txt >/dev/null 2>&1 && /bin/echo "Cron ran at: `date`" >> /home/isasadmin007/public_html/cron_test.txt
					$mail->Subject ='ISAS - Todays Outstanding Installment Report - '.date('d/m/Y').'';
					
					$sendMessage=$GLOBALS['box_message_top'];
					$sendMessage.=$message;
					$sendMessage.=$GLOBALS['box_message_bottom'];
					
					$mail->WordWrap = 3000; 
					$mail->isHTML(true);                                  
					$mail->Body    = $sendMessage;
					
					$mail->Send();
					echo "Email Sent Successfully.";
				} catch (phpmailerException $e) {
				  echo $e->errorMessage(); 
				} catch (Exception $e) {
				  echo $e->getMessage(); 
			}	
			?>
	</body>
</html>