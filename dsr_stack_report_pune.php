<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Stack Mail</title>
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
			$sql_query= "select * from site_setting where 1 and (type='C' or type='A') and system_status='Enabled' ".$branch_id."  ".$pre_keyword." ".$select_directory.""; 
			$ptr_db=mysql_query($sql_query);
			$no_of_records=mysql_num_rows($ptr_db);
			
			$message.='<tr>
			<td colspan="10" >
				<table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 					<tr class="grey_td" style="background-color:#999;color: black">
						<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Name</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total New Enq. Assign</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total New Enq. Called</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Pending New Followups</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total Followups (Repeated)</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total Followups (Non-Repeated)</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total Pending Followups</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total Followups Called</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Invalid/Not Intrested Enquiry</strong></td>
						<td width="8%" align="center" style="border:1px solid #CCC"><strong>Total Walkin</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Enroll. / Upgrade</strong></td>
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
								
								$select_enquiry="select inquiry_id from inquiry where 1 and employee_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$query_enquiery=mysql_query($select_enquiry);
								$count_enquiry=mysql_num_rows($query_enquiery);
								
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$count_enquiry.'</td>';
								$total_assign +=$count_enquiry;
								//--------------------------------------------------------------------------------------------=====================----------------------------
								$select_enq_cnt="select inquiry_id from inquiry where 1 and (followup_date !='' or followup_date is NOT NULL) and employee_id='".$val_query['admin_id']."' ".$search_cm_id." ".$branch_id." ".$getDate." ";
								$query_enq_cnt=mysql_query($select_enq_cnt);
								$count_enq_called=mysql_num_rows($query_enq_cnt);
                               
								$sel_exst_foll="SELECT * FROM inquiry where 1 and status = 'Enquiry' and employee_id='".$val_query['admin_id']."' ".$branch_id." and (response !='7' and response!='8' or response is NULL) ".$followup_date." order by inquiry_id desc";
								$ptr_exst_foll=mysql_query($sel_exst_foll);
								$total_foll=mysql_num_rows($ptr_exst_foll);
								
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$count_enq_called.'</td>';
								$total_new_called +=$count_enq_called;
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$select_pend_followups="select inquiry_id from inquiry where 1 and (followup_date='' or followup_date is NULL) and employee_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$query_pend_followups=mysql_query($select_pend_followups);	
								$count_pending_follow=mysql_num_rows($query_pend_followups);	
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$count_pending_follow.'</td>';
								$total_new_pending +=$count_pending_follow;
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$select_tot_called="select followup_id from followup_details where 1 and admin_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$query_tot_called=mysql_query($select_tot_called);
								$tot_foll_called=mysql_num_rows($query_tot_called);
								
								$tot_followups=$tot_foll_called+$total_foll;
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$tot_followups.'</td>';
								$total_all_followups +=$tot_followups;
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$select_not_repeated="select DISTINCT(student_id) from followup_details where 1 and admin_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$query_not_repeaated=mysql_query($select_not_repeated);
								$tot_non_repeated=mysql_num_rows($query_not_repeaated);
								$non_repeated_followups=$tot_non_repeated+$total_foll;
								
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$non_repeated_followups.'</td>';
								$total_non_repeated_followups +=$non_repeated_followups;
								//---------------------------------------------------------------------------------------------------------------------------------------------
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$total_foll.'</td>';
								$tot_pend_followup +=$total_foll;
								//---------------------------------------------------------------------------------------------------------------------------------------------
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$tot_foll_called.'</td>';
								$tot_called_followup +=$tot_foll_called;
								//---------------------------------------------------------------------------------------------------------------------------------------------
								//$select_invalid="select inquiry_id from inquiry where 1 and (response='7' or response='8') and employee_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								
								$select_invalid="select DISTINCT(student_id) from followup_details where 1 and(response='7' or response='8') and admin_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate."";
								$query_invalid=mysql_query($select_invalid);
								$count_invalid=mysql_num_rows($query_invalid);
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$count_invalid.'</td>';
								$total_invalid +=$count_invalid;
								//---------------------------------------------------------------------------------------------------------------------------------------------
                              	
								//---------------------------------------------------------------------------------------------------------------------------------------------
								$select_enq_walkin="select DISTINCT(student_id) from followup_details where 1 and response='1' and admin_id='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$query_enq_walkin=mysql_query($select_enq_walkin);
								$count_enq_walkin=mysql_num_rows($query_enq_walkin);	
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$count_enq_walkin.'</td>';
								$total_walkin +=$count_enq_walkin;
								//---------------------------------------------------------------------------------------------------------------------------------------------
                              	
								$select_inst="select enroll_id from enrollment where 1 and ref_id='0' and assigned_to='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$query_inst=mysql_query($select_inst);
								$count_enroll=mysql_num_rows($query_inst);
								
								$sel_enroll="select enroll_id from enrollment where 1 and ref_id!='0' and assigned_to='".$val_query['admin_id']."' ".$branch_id." ".$getDate." ";
								$query_enroll=mysql_query($sel_enroll);
								$cnt_enroll=mysql_num_rows($query_enroll);
								
								$message.= '<td align="center" style="border:1px solid #CCC">'.$cnt_enroll.'</td>';
								$total_enrolled +=$count_enroll;
								//---------------------------------------------------------------------------------------------------------------------------------------------
                              	
                                $message.= '</tr>';
                               	$i++;         
                                $bgColorCounter++;
                            }
							
							$message.= '<tr class="grey_td" >
                        	<td width="10%" align="center" colspan="2"><strong>Total</strong></td>
                        	<td width="10%" align="center"><strong>'.$total_assign.'</strong></td>
                            <td width="10%" align="center"><strong>'.$total_new_called.'</strong></td>
                            <td width="10%" align="center"><strong>'.$total_new_pending.'</strong></td>
                            <td width="10%" align="center"><strong>'.$total_all_followups.'</strong></td>
                            <td width="10%" align="center"><strong>'.$total_non_repeated_followups.'</strong></td>
                            <td width="10%" align="center"><strong>'.$tot_pend_followup.'</strong></td>
                        	<td width="10%" align="center"><strong>'.$tot_called_followup.'</strong></td>
                            <td width="10%" align="center"><strong>'.$total_invalid.'</strong></td>
                            <td width="10%" align="center"><strong>'.$total_walkin.'</strong></td>
                        	<td width="10%" align="center"><strong>'.$total_enrolled.'</strong></td>
                     		</tr>';

						}		
					$message.='</table>
				</td>
			</tr>';
//========================================================================================================================================================================
$message.='</table>';
					
						/*------------send a mail to admin about this---------------------*/
						$subject = " Daily Stack Report for Pune Branch - ISAS BEAUTY SCHOOL ";
							
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
									
									$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='283' and cm_id='".$cm_id1."'";
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
									
									
									$mail->Subject = 'Daily Stack Report Report For Pune Branch- '.date('Y-m-d').'';
									
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