<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Employee Performance Mail</title>
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
	$branch_id= "and cm_id='2'";
	$cm_id1= '2';
	$getDate=" and DATE(added_date) ='".date('Y-m-d')."'"; 
	$followup_date=" and DATE(followup_date) ='".date('Y-m-d')."' ";
	
	$sel_branch_name="select branch_name from site_setting where cm_id=".$cm_id1." and type='A'";
	$ptr_branch_name=mysql_query($sel_branch_name);
	$data_branch=mysql_fetch_array($ptr_branch_name);
	$branch_name=" For ".$data_branch['branch_name']." branch";
	
$message.=  '<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">'; 
			$select_directory='order by name asc';                      
			$sql_query= "select * from site_setting where 1 and system_status='Enabled' ".$branch_id."  ".$pre_keyword." ".$select_directory.""; 
			$ptr_db=mysql_query($sql_query);
			$no_of_records=mysql_num_rows($ptr_db);
			
			$message.='<tr>
			<td colspan="10" >
				<table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 					<tr class="grey_td" style="background-color:#999;color: black">
						<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Name</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Timesheet</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Utilisation</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Presence</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Working Hours</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Task Completion</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Quality Of Work</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Rules Followed</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Phone Submited</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>No. Of Negative Remark</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Points</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Monthly Points</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Comments</strong></td>
					</tr>';
                    	if($no_of_records)
                        {
							$i=1;
							$total_assign=0;
							$total_pending=0;
							$total_completed=0;
							$total_walkin=0;
							$total_enrolled=0;            
                            while($val_query=mysql_fetch_array($ptr_db))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['admin_id']; 
                                include "include/paging_script.php";
								
                                $message.= '<tr '.$bgcolor.'>';
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';    
								$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['name'].'</td>'; 
								
								$select_per="select * from emp_performance_report where employee_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$ptr_per=mysql_query($select_per);
								$data_per=mysql_fetch_array($ptr_per);
								
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['timesheet_mark'].'</td>';
								//--------------------------------------------------------------------------------------------=====================----------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['utilisation_mark'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['presence'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['working_hrs'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['task_mark'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['quality_work_mark'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
					 			$message.= '<td align="center" style="border:1px solid #CCC">'.round($data_per['class_start_time_mark']+$data_per['class_end_time_r_mark']+$data_per['faculty_grooming_r_mark']+$data_per['logsheet_send_r_mark']+$data_per['mobile_used_r_mark']+$data_per['timetable_followed_r_mark']+$data_per['student_decoram_r_mark']).'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['phone_submited'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['negative_remarks'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['points'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['monthly_points'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
                              	$message.= '<td align="center" style="border:1px solid #CCC">'.$data_per['comments'].'</td>';
								//---------------------------------------------------------------------------------------------------------------------------------------------
                                $message.= '</tr>';
                               	$i++;         
                                $bgColorCounter++;
                            }
						}		
					$message.='</table>
				</td>
			</tr>';
//========================================================================================================================================================================
$message.='</table>';
					
						/*------------send a mail to admin about this---------------------*/
						$subject = "Daily Employee Performance Report for Pune Branch - ISAS BEAUTY SCHOOL ";
							
						$sendMessage=$GLOBALS['box_message_top'];
						echo $sendMessage.=$message;
						echo "<input type='hidden' name='mail_content' id='mail_content' value='".addslashes($sendMessage)."' >";
						//===================================================//21-12-17=====================================================
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
									$mail->setFrom('info@isassystems.com', 'ISAS');
									$mail->addAddress("erp.isas@gmail.com"); 
									
									$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='349' and cm_id='".$cm_id1."'";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									$tot_num_rows=mysql_num_rows($ptr_sel_sms);
									$i=0;
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' and type!='S' ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											$emailss=trim($data_cnt['email']);
											$mail->addCC("$emailss"); 
											$i++;
										}
									}
									
									"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' and email!='' ";
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
									}
									
									
									$mail->Subject = ' Employee Performance Report Report For Pune Branch- '.date('Y-m-d').'';
									
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
						//================================================================================	
?>
</body>
</html>