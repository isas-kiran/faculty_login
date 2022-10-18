<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title id="title">Make Salary</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
   
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
 
    <script language="javascript" src="js/script.js"></script>

    <script language="javascript" src="js/conditions-script.js"></script>
	<link rel="stylesheet" href="js/chosen.css" />
	<script src="js/chosen.jquery.js" type="text/javascript"></script>
	<script>
	$(document).ready(function()
    {
		$("#year").chosen({allow_single_deselect:true});
		$("#month").chosen({allow_single_deselect:true});
		
		<?php 
		if($_SESSION['type']=="S")
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			<?php
		}
		?>
	});
	</script> 
    <style>

.table1, .th1, .td1 {
    border: 1px solid;
    border-collapse: collapse;
    padding: 4px;
	font-size:12px;
}
.td2 {
   text-align:center;
}

.table2 tr:first-child td {
  border-top: 0;
}
.table2 tr td:first-child {
  border-left: 0;
}
.table2 tr:last-child td {
  border-bottom: 0;
}
.table2 tr td:last-child {
  border-right: 0;
}

.table2 tr:first-child th {
  border-top: 0;
}
.table2 tr th:first-child {
  border-left: 0;
}
.table2 tr:last-child th {
  border-bottom: 0;
}
.table2 tr th:last-child {
  border-right: 0;
}
</style>
	<?php 
	function send_mail($branch_name,$month,$year,$staff_id)
	{
		//===================================================================
		$select_exc = "select * from pr_staff_salary_management where branch_name='".$branch_name."' AND month='".$month."' AND year='".$year."' AND staff_id='".$staff_id."' AND payment_action=1";
        $payment1 = mysql_query($select_exc);
        $payment = mysql_fetch_array($payment1);
						
		$select_staff = "select attendence_id,admin_id,name,company_name,contact_address,dob,joining_date,designation1,department,alternate_email from site_setting where attendence_id='".$staff_id."' "; 
		$staff_query = mysql_query($select_staff);
		$staff= mysql_fetch_array($staff_query);
		
		if($staff['company_name']=='ISAS')
		{
			$address = "select * from branch where branch_name='".$branch_name."'"; 
			$add_query=mysql_query($address);
			$add = mysql_fetch_array($add_query);
			
			$address1=strip_tags($add['branch_address']);
			$company_name="ISAS Beauty School Pvt Ltd.";
			$img='https://www.isasbeautyschool.org/faculty_login/images/logo.jpg';
		}
		elseif($staff['company_name']=='Innocent')
		{
			$address = "select * from branch where branch_name='".$branch_name."'"; 
			$add_query=mysql_query($address);
		    $add = mysql_fetch_array($add_query);
			
			$address1=strip_tags($add['innocent_address']);
			$company_name="Innocent Salon";
			$img='https://www.isasbeautyschool.org/faculty_login/images/innocent1.png';
		}
		else if(trim($staff['company_name'])=='Frespa')
		{
			$address = "select * from branch where branch_name='".$branch_name."'"; 
			$add_query=mysql_query($address);
		    $add =mysql_fetch_array($add_query);
			
			$address1=strip_tags($add['frespa_address']);
			$company_name="Frespa Consultancy";
			$img='https://www.isasbeautyschool.org/faculty_login/images/freshpa.png';
		} 
		$rent = "select * from pr_add_salary_details where staff_id='".$staff_id."' "; 
		$rent_query=mysql_query($rent);
		$rent_Detail = mysql_fetch_array($rent_query);
		
		$leaves = "select * from pr_staff_leave_management where staff_id='".$staff_id."' AND month='".$month."' AND year='".$year."' order by staff_leave_id desc limit 0,1"; 
		$leave_query=mysql_query($leaves);
		$pre_leaves = mysql_fetch_array($leave_query);
							
		$staff_salary = "select * from pr_staff_salary_management where branch_name='".$branch_name."' AND staff_id='".$staff_id."' AND month='".$month."' AND year='".$year."'"; 
		$staff_query=mysql_query($staff_salary);
		$staff_sal = mysql_fetch_array($staff_query);
							
		$current_Month1 =date('Y').'-'.$month.'-01';
		$last_month=Date('m', strtotime('-1 month',strtotime($current_Month1)));
		$last_year=Date('Y', strtotime('-1 month',strtotime($current_Month1)));
		
		$leave_detail = "select * from pr_previous_leave_management where staff_id='".$staff_id."' AND month='".$last_month."' AND year='".$last_year."' order by previous_leave_id desc limit 0,1";     
		$leave_quer=mysql_query($leave_detail);
		$leav_count=mysql_num_rows($lev);
		$leave = mysql_fetch_array($leave_quer);
		
		$incentive=$staff_sal['incentive_on_service']+$staff_sal['incentive_on_product']+$staff_sal['event_incentive']+$staff_sal['course_incentive']+$staff_sal['other_incentive'];
		$total_deductions=intval($rent_Detail['proffessional_tax']+$rent_Detail['tds']+$staff_sal['advance_deduction']);
		$previous_balance_leaves=$leave['previous_balance_leaves'];
		$salry_obj ='';			 
		if(mysql_num_rows($payment1))
		{
			$salry_obj = '<style>
				.table1, .th1, .td1 {
					border: 1px solid;
					border-collapse: collapse;
					padding: 4px;
					font-size:12px;
				}
				.td2 {
				   text-align:center;
				   border-right:1px solid;
				   border-collapse: collapse;
				}
				
				.table2 tr:first-child td {
				  border-top: 0;
				}
				.table2 tr td:first-child {
				  border-left: 0;
				}
				.table2 tr:last-child td {
				  border-bottom: 0;
				}
				.table2 tr td:last-child {
				  border-right: 1;
				}
				
				.table2 tr:first-child th {
				  border-top: 0;
				}
				.table2 tr th:first-child {
				  border-left: 0;
				}
				.table2 tr:last-child th {
				  border-bottom: 0;
				}
				.table2 tr th:last-child {
				  border-right: 0;
				}
				</style>';
			$salry_obj .= '<center>';
			$salry_obj .= '<div id="showtable">
				<table id="customer-order" style="overflow: visible;width:100%;" class="table1">
					<tr>
						<th class="th1" style="width:50%;" colspan="2"><img src="'.$img.'" height="50%" width="50%"/></th>
						<th class="th1" style="width:50%" colspan="3"><b style="font-size:24px;">'.$company_name.'</b></th> 
					</tr>
  					<tr>
    					<th class="th1" colspan="5"><center><p style="">'.$address1.'</p></center></th>
   					</tr>
					<tr>';
                        if($month=='01'){ $month="January"; }
                        if($month=='02'){ $month="February "; }
                        if($month=='03'){ $month="March"; }
                        if($month=='04'){ $month="April"; }
                        if($month=='05'){ $month="May"; }
                        if($month=='06'){ $month="June"; }
                        if($month=='07'){ $month="July"; }
                        if($month=='08'){ $month="Auguest"; }
                        if($month=='09'){ $month="September"; }
                        if($month=='10'){ $month="October"; }
                        if($month=='11'){ $month="November"; }
                        if($month=='12'){ $month="December"; }
                        $salry_obj .= '<th class="th1" colspan="5"><center><b style="font-size:16px;">PAYSLIP FOR THE MONTH OF '.$month.' '.$year.'.</b></center></th>
					</tr>
					</br/>';
					$salry_obj .= '<tr>
                    	<td colspan="5" style="border: 0px solid;border-collapse: collapse;">
							<table class="table2" style="overflow: visible;width:100%;border-collapse: collapse;border: 0px solid;">
								<tr>
									<td class="td1" style="width:50%" colspan="3">Emp Code: ISAS-EMP-APP-'.$staff['attendence_id'].'</td>
									<td class="td1" style="width:50%" colspan="2">Emp Name: '.$staff['name'].'.</td>
								</tr>
								<tr>
									<td class="td1" style="width:50%" colspan="3">Department: '. $staff['department'].'</td>
									<td class="td1" style="width:50%" colspan="2"></td>
                                </tr>
								<tr>
									<td class="td1" style="width:50%" colspan="3">Location: '.$staff['contact_address'].'</td>
									<td class="td1" style="width:50%" colspan="2">Designation: '.$staff['designation1'].'.</td>
                                </tr>
								<tr>
									<td class="td1" style="width:50%" colspan="3">Date Of Birth: '.date('d-m-Y',strtotime($staff['dob'])).'</td>
									<td class="td1" style="width:50%" colspan="2">Bank A/c No.: 	'.$rent_Detail['bank_account_number'].'</td>
                                </tr>
								<tr>
                                	<td class="td1" style="width:50%" colspan="3">Date of Joining: '.$staff['joining_date'].'</td>
									<td class="td1" style="width:50%" colspan="2">Employment Status: Confirmed	</td>
								</tr>
                                <tr>
                                	<td class="td1" style="width:50%" colspan="3">Pan No.:'.$rent_Detail['pan_number'].'</td>
									<td class="td1" style="width:50%" colspan="2">Salary Tenure:1-'.$month.'-'.$year.' To '.$payment['days_in_month'].'-'.$month.'-'.$year.'</td>
								</tr>
                           	</table>
						</td>
                 	</tr>
					</br/>';
					$salry_obj .= '<tr>
						<th class="th1"><b style="font-size:14px;">Total Working Days</b></th>
						<th class="th1"><b style="font-size:14px;">Present Days</b></th>
						<th class="th1"><b style="font-size:14px;">Extra Days</b></th>
                        <th class="th1"><b style="font-size:14px;">LWP Days</b></th>
                        <th class="th1"><b style="font-size:14px;">Balance Leaves</b></th>
  					</tr>';
					$salry_obj .= '<tr>
						<td class="td1 td2">'.$payment['days_in_month'].'</td>
						<td class="td1 td2">'.$pre_leaves['present_days'].'</td>
						<td class="td1 td2">'.$pre_leaves['extra_days'].'</td>
						<td class="td1 td2">'.$pre_leaves['leave_days'].'</td>
						<td class="td1 td2">'.$pre_leaves['final_leave_balance'].'</td>
					</tr></br/>';
					$salry_obj .= '<tr>
						<th class="td1" colspan="2" style="font-size:14px;"><strong>Gross Salary</strong></td>
						<th class="td1 td2" colspan="3">'.intval($payment['payable_salary']).' Rs./-</td>
						
					</tr>';
					$salry_obj .= '<tr>
						<td colspan="5">
                        	<table class="table2" style="overflow: visible;width:100%;border-collapse: collapse;border: 0px solid;">';
								$salry_obj .= '<tr>
									<th class="th1"><b style="font-size:14px;">Earnings</b></th>
                                    <th class="th1"><b style="font-size:14px;">Amount</b></th>
									<th class="th1"><b style="font-size:14px;">Deductions</b></th>
									<th class="th1"><b style="font-size:14px;">Amount</b></th>
                                </tr>';
 								$salry_obj .= '<tr>
									<td class="td1">Basic</td>
									<td class="td1 td2">'.$rent_Detail['basic_salary'].'</td>
									<td class="td1">Professional Tax</td>
									<td class="td1 td2">'.$rent_Detail['proffessional_tax'].'</td>
								</tr>';
								$salry_obj .= '<tr>
                                    <td class="td1">House Rent Allowance</td>
                                    <td class="td1 td2">'.$rent_Detail['house_rent_allowance'].'</td>
                                    <td class="td1">Income Tax (TDS)</td>
                                    <td class="td1 td2">'.$rent_Detail['tds'].'</td>
								</tr>';
								$salry_obj .= '<tr>
                                    <td class="td1">Travelling Allowance</td>
                                    <td class="td1 td2">'.$rent_Detail['travelling_allowance'].'</td>
                                    <td class="td1">Provident Fund</td>
                                    <td class="td1 td2">'.$rent_Detail['pf'].'</td>
                                </tr>';
                                $salry_obj .='<tr>
                                    <td class="td1">Medical Allowance</td>
									<td class="td1 td2">'.$rent_Detail['medical_allowance'].'</td>
                                    <td class="td1">ESIC</td>
                                    <td class="td1 td2">'.$rent_Detail['esic'].'</td>
                                </tr>';
                                $salry_obj .='<tr>
                                	<td class="td1">Incentive</td>
									<td class="td1 td2">'.$incentive.'</td>
									<td class="td1">Advance</td>
                                    <td class="td1 td2">'.$staff_sal['advance_deduction'].'</td>
								</tr>';
                                $salry_obj .= '<tr>
                                	<td class="td1">Special Allowance 1 </td>
                                    <td class="td1 td2">'.$rent_Detail['specia_allowance1'].'</td>
          							<td class="td1">Fine / Deductions</td>
                                    <td class="td1 td2">0</td>
                                </tr>';
                                $salry_obj .= '<tr>
                                	<td class="td1">Company Allowance 2</td>
                                	<td class="td1 td2">'.$rent_Detail['specia_allowance2'].'</td>
									<td class="td1"><strong>Total Deductions</strong></td>
									<td class="td1 td2">'.$total_deductions.'</td>
                                </tr>';
                                $salry_obj .= '<tr>
                                    <td class="td1">Salary Adjustment </td>
                                    <td class="td1 td2">'.$staff_sal['adjustment'].'</td>
									<td class="td1"></td>
                                    <td class="td1 td2"></td>
                                </tr>';
                                $salry_obj .= '<tr>
                                    <td class="td1">Expense Addition </td>
                                    <td class="td1 td2">'.$staff_sal['expence_deduction'].'</td>
									<td class="td1"></td>
                                    <td class="td1 td2"></td>
                                </tr>';
                                $salry_obj .= '<tr>
                                    <td class="td1"><strong>Net Salary</strong></td>
                                    <td class="td1 td2">'.$payment['salary_to_be_paid'].'</td>
									<td class="td1"></td>
                                    <td class="td1 td2"></td>
                                </tr>';
								$salry_obj .= '<tr>
                                    <td class="td1" colspan="5"></td>
                                    
                                </tr>';  
                                $salry_obj .= '<tr>
                                    <th class="th1"><strong>Bank Name</strong></th>
                                    <th class="th1"><strong>Payment Mode</strong></th>
                                    <th class="th1" colspan="2"><strong>Branch Description</strong></th>
                                </tr>';
                                 $salry_obj .= '<tr>';
                                    $bank_detail = "select bank_name from bank where bank_id='".$payment['bank_name']."'"; 
									$bank_query=mysql_query($bank_detail);
                                    $bank = mysql_fetch_array($bank_query);
                                   
                                    $salry_obj .= '<td class="td1 td2">'.$bank['bank_name'].'</td>
                                    <td class="td1 td2">'.$staff_sal['cheque_no'].'</td>
                                    <td class="td1 td2" colspan="2">Koregaon Park, Pune - 411001.	</td>
								</tr>';
							$salry_obj .= '</table>
						</td>
					</tr>
					<tr>';
					//echo "<br/>6";
					if($_SESSION['type']=="S")
					{
						
						$salry_obj .='<td class="td1" colspan="5"><b style="float:right;margin-top:50px;font-size:12px;">Note: This is system generated slip,it does not need stamp and signature</b></td>';
						
					}
					else
					{
						
						$salry_obj .='<td class="td1" colspan="5"><b style="float:right;margin-top:50px;font-size:14px;">Authorized Sign</b></td>';
						
                    }
					$salry_obj .= '</tr>
				</table>
			</div>
		</center>';
		echo "<br/>".$salry_obj;
		/*include('payroll/pdf.php');
		$file_name = 'salary_slip_'.$staff['name'].'_'.$month.'_'.$year.'.pdf';
		$html_code = '<link rel="stylesheet" href="payroll/bootstrap.min.css">';
		$html_code .= $salry_obj;
		$pdf = new Pdf();
		$pdf->load_html($html_code);
		$pdf->render();
		$file = $pdf->output();
		file_put_contents($file_name, $file);
		
		require 'PHPMailer-5.2.14/class.phpmailer.php';
		require_once "../../php/Mail.php"; 
		$mail = new PHPMailer(true);
		try {
		//$mail = new PHPMailer;
		$mail->SMTPDebug=1;
		//$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host = 'ssl://smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = '465';								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'info@isasbeautyschool.com';					//Sets SMTP username
		$mail->Password = 'isas@08info';					//Sets SMTP password
		$mail->SMTPSecure = 'ssl';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->SetFrom('info@isasbeautyschool.com', 'ISAS');		//Sets the From email address for the message
		//$mail->FromName = 'ISAS Beauty School';			//Sets the From name of the message
		$mail->addAddress(''.$staff['alternate_email'].'');
		$mail->addReplyTo('info@isasbeautyschool.com', 'ISAS beautyschool');		//Adds a "To" address
		$mail->WordWrap = 3000;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->isHTML(true);							//Sets message type to HTML				
		$mail->AddAttachment($file_name);     				//Adds an attachment from a path on the filesystem
		$mail->Subject = 'Salary Slip of '.$month.' / '.$year.' from ISAS Beauty School';			//Sets the Subject of the message
		$mail->Body = 'Please Find Salary details in attach PDF File.';				//An HTML or plain text message body
		if($mail->Send())								//Send an Email. Return true on success or false on error
		{
			$message = '<label class="text-success">Salary Slip has been send successfully...</label>';
		}
		
		} catch (phpmailerException $e) {
		  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
		  echo $e->getMessage(); //Boring error messages from anything else!
		}*/
		//unlink($file_name);
	}
//====================================================================
	}
	if($_POST['save_changes'])
	{
		$branch_name=$_POST['branch_name'];
		$year=$_POST['year'];
		$month=$_POST['month'];
		
		if($_SESSION['type']=='S')
		{
			$sel_branch="select cm_id ,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_branch=mysql_query($sel_branch);
			$data_branch=mysql_fetch_array($ptr_branch);
			$cm_id=$data_branch['cm_id'];
			
			$branch_name1=$branch_name;
			$_SESSION['cm_id_notification']=$data_branch['cm_id'];
		}	
		else
		{
			$cm_id=$_SESSION['cm_id'];
			$branch_name1=$_SESSION['branch_name'];
		}
		$added_date=date('Y-m-d');
	
		for($z=1;$z<=$_REQUEST['total'];$z++)
		{			
			$payment_mode=$_POST['payment_mode'.$z];
			$data_record_type1['payment_mode'] =addslashes(trim($_POST['payment_mode'.$z]));
			if($payment_mode=='5')
			{
				$data_record_type1['bank_name'] =$_POST['bank_name'.$z];
				$data_record_type1['account_no'] =$_POST['account_no'.$z];	
                $data_record_type1['cheque_no'] =$_POST['cheque_no'.$z];				
			}
			elseif($payment_mode=='2')
			{
				$data_record_type1['cheque_no'] =$_POST['cheque_no'.$z];
				$data_record_type1['account_no'] =0;	
                $data_record_type1['bank_name'] =$_POST['bank_name'.$z];				
			}
			elseif($payment_mode=='1')
			{
				$data_record_type1['cheque_no'] =0;	
				$data_record_type1['account_no'] =0;	
                $data_record_type1['bank_name'] =0;
			}
			else 
			{
				$data_record_type1['cheque_no'] =0;	
				$data_record_type1['account_no'] =0;	
                $data_record_type1['bank_name'] =0;
			}
			$data_record_type1['comment'] =$_POST['comment'.$z];
			$ad_date=explode('/',$_POST['payment_date'.$z],3);
			$payment_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
							
			$data_record_type1['payment_date'] =$payment_date;
			if(isset($_POST['action'.$z]))
			{
				$insert_for_receipt = "insert into expense (`payment_mode_id`,`bank_id`, `account_no`,`chaque_no`, `chaque_date`,`amount`, `description`,`employee_id`, `added_date`, `cm_id`,`expense_category_id`,`expense_type_id`,`total_price`) values('".$_POST['payment_mode'.$z]."','".$_POST['bank_name'.$z]."','".$_POST['account_no'.$z]."','".$_POST['cheque_no'.$z]."','".$_POST['payment_date'.$z]."','".$_POST['salary'.$z]."','".$_POST['comment'.$z]."','".$_POST['employee'.$z]."','".$added_date."','".$cm_id."','137','178','".$_POST['salary'.$z]."')";
				$ptr_insert_receipt = mysql_query($insert_for_receipt);	 
							 
				$data_record_type1['payment_action'] =1;
                $where_record="staff_salary_id='".$_POST['floor_id'.$z]."'";
	            $db->query_update("pr_staff_salary_management", $data_record_type1,$where_record);		

				$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('make_salary','Add','Make Salary','".$_POST['floor_id'.$z]."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);  	
				//send_mail($branch_name1,$year,$month,$_POST['employee'.$z]);	
				send_mail(Pune,03,2019,653);	
			}
		}
	}
?>
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->

<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">      
        <?php
		$success=0;
		if($success==0)
		{
			?>
            <tr><td>
        	<form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
				<table border="0" cellspacing="15" cellpadding="0" width="100%">
            		<tr>
                    	<td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
                    <tr>
                    	<td>
                    		
                    	</td>
                    </tr>
 				</table>
                <div id="showdiv"></div>
			</form>
		</td>
	</tr>
<?php
} ?>
</table></td>
<td class="mid_right"></td>
</tr>
<tr>
<td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>
</div>
<!--right end-->
</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><?php require("include/footer.php");?></div>
<!--footer end-->
<script language="javascript">
function getsalarydetails() {
 
	//var atype = $("#atype").val();
	var year = $("#year").val();
	var month = $("#month").val();
	var branch_name = $("#branch_name").val();
	
	if(month==''){
		alert("Please Select Month");
		return false;
	}
	if(year==''){
		alert("Please Select Year");
		return false;
	}
	if(branch_name==''){
		alert("Please Select branch name");
		return false;
	}
	//alert(branch_name);
        $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'make_salary_ajax.php',
            data: { year: year,month:month,branch_name:branch_name },
            
        }).done(function(responseData) {
        $("#showdiv").html(responseData);
        }).fail(function() {
            console.log('Failed');
        });

    }
</script>
<?php
send_mail(Pune,04,2019,653);
?>
</body>
</html>
<?php $db->close();?>