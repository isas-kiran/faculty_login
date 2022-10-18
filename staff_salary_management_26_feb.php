<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_staff_salary_management where staff_salary_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	
	 $select_sallery_details="select * from sallery where admin_id='".$record_id."'";
	$sallery_details=mysql_query($select_sallery_details);
	$fetch_sallery=mysql_fetch_array($sallery_details);
}

/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
 Staff Salary Management</title>
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
    <script>
	 function validme()
	 {
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
	 if(frm.month.value=='')
		 {
			 disp_error +='Select month\n';
			 document.getElementById('month').style.border = '1px solid #f00';
			 frm.month.focus();
			 error='yes';
	     }
	 if(frm.salary.value=='')
		 {
			 disp_error +='Enter Salary \n';
			 document.getElementById(salary).style.border = '1px solid #f00';
			 frm.salary.focus();
			 error='yes';
		 }
	   if(frm.working_days.value=='')
		 {
			 disp_error +='Enter Working days \n';
			 document.getElementById('working_days').style.border = '1px solid #f00';
			 frm.working_days.focus();
			 error='yes';
	     }

		 if(frm.actual_present_days.value=='')
		 {
			 disp_error +='Enter Actual present days. \n';
			 document.getElementById('actual_present_days').style.border = '1px solid #f00';
			 frm.actual_present_days.focus();
			 error='yes';
	     }
		 
		 if(frm.absent_days.value=='')
		 {
			 disp_error +='Enter Absent days. \n';
			 document.getElementById('absent_days').style.border = '1px solid #f00';
			 frm.absent_days.focus();
			 error='yes';
	     }
		 
		 if(frm.days_in_month.value=='')
		 {
			 disp_error +='Enter Days in month. \n';
			 document.getElementById('days_in_month').style.border = '1px solid #f00';
			 frm.days_in_month.focus();
			 error='yes';
	     }
		 
		 if(frm.per_day_amount.value=='')
		 {
			 disp_error +='Enter Per day amount. \n';
			 document.getElementById('per_day_amount').style.border = '1px solid #f00';
			 frm.per_day_amount.focus();
			 error='yes';
	     }
		 
		 if(frm.salary_to_be_paid.value=='')
		 {
			 disp_error +='Enter salary to be paid. \n';
			 document.getElementById('salary_to_be_paid').style.border = '1px solid #f00';
			 frm.salary_to_be_paid.focus();
			 error='yes';
	     }
		 
		 if(frm.after_professional_tax.value=='')
		 {
			 disp_error +='Enter After Professional Tax. \n';
			 document.getElementById('after_professional_tax').style.border = '1px solid #f00';
			 frm.after_professional_tax.focus();
			 error='yes';
	     }
		 
		 if(frm.advance_deduction.value=='')
		 {
			 disp_error +='Enter Advance Deduction. \n';
			 document.getElementById('advance_deduction').style.border = '1px solid #f00';
			 frm.advance_deduction.focus();
			 error='yes';
	     }
		 
		 if(frm.after_deduction.value=='')
		 {
			 disp_error +='Enter After advance deduction. \n';
			 document.getElementById('after_deduction').style.border = '1px solid #f00';
			 frm.after_deduction.focus();
			 error='yes';
	     }
		
		   if(frm.expence_deduction.value=='')
		 {
			 disp_error +='Enter Expence deduction. \n';
			 document.getElementById('expence_deduction').style.border = '1px solid #f00';
			 frm.expence_deduction.focus();
			 error='yes';
	     }
		 
		  if(frm.after_expence_deduction.value=='')
		 {
			 disp_error +='Enter After expence deduction. \n';
			 document.getElementById('after_expence_deduction').style.border = '1px solid #f00';
			 frm.after_expence_deduction.focus();
			 error='yes';
	     }
		  if(frm.incentive_on_service.value=='')
		 {
			 disp_error +='Enter Incentive On Service. \n';
			 document.getElementById('incentive_on_service').style.border = '1px solid #f00';
			 frm.incentive_on_service.focus();
			 error='yes';
	     }
		 
		  if(frm.incentive_on_product.value=='')
		 {
			 disp_error +='Enter Incentive On Product. \n';
			 document.getElementById('incentive_on_product').style.border = '1px solid #f00';
			 frm.incentive_on_product.focus();
			 error='yes';
	     }
		 
		   if(frm.balance_leaves.value=='')
		 {
			 disp_error +='Enter Balance Leave. \n';
			 document.getElementById('balance_leaves').style.border = '1px solid #f00';
			 frm.balance_leaves.focus();
			 error='yes';
	     }
		 
		  if(frm.adjustment_leaves.value=='')
		 {
			 disp_error +='Enter Adjustment Leave. \n';
			 document.getElementById('adjustment_leaves').style.border = '1px solid #f00';
			 frm.adjustment_leaves.focus();
			 error='yes';
	     }
		 
		
	
		 
	 }
	
</script>
  
     <script language="javascript" src="js/script.js"></script>
     <script language="javascript" src="js/conditions-script.js"></script>
 
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
                    $errors=array(); $i=0;
                    $success=0;
                    if($_POST['save_changes'])
                    {
						
						$month=( ($_POST['month'])) ? $_POST['month'] : "";
                        $year=( ($_POST['year'])) ? $_POST['year'] : "";
						$staff_id=( ($_POST['staff_id'])) ? $_POST['staff_id'] : "";
						$salary=( ($_POST['salary'])) ? $_POST['salary'] : "0";
						$working_days=( ($_POST['working_days'])) ? $_POST['working_days'] : "";
						$actual_present_days=( ($_POST['actual_present_days'])) ? $_POST['actual_present_days'] : "";
						$absent_days=( ($_POST['absent_days'])) ? $_POST['absent_days'] : "";
						$days_in_month=( ($_POST['days_in_month'])) ? $_POST['days_in_month'] : "";
						$per_day_amount=( ($_POST['per_day_amount'])) ? $_POST['per_day_amount'] : "";
						$salary_to_be_paid=( ($_POST['salary_to_be_paid'])) ? $_POST['salary_to_be_paid'] : "";
						$after_professional_tax=( ($_POST['after_professional_tax'])) ? $_POST['after_professional_tax'] : "";
						$tds=( ($_POST['tds'])) ? $_POST['tds'] : "";
						$advance_deduction=( ($_POST['advance_deduction'])) ? $_POST['advance_deduction'] : "0";
						$after_deduction=( ($_POST['after_deduction'])) ? $_POST['after_deduction'] : "0";
						$expence_deduction=( ($_POST['expence_deduction'])) ? $_POST['expence_deduction'] : "0";
						$after_expence_deduction=( ($_POST['after_expence_deduction'])) ? $_POST['after_expence_deduction'] : "0";
						$incentive_on_service=( ($_POST['incentive_on_service'])) ? $_POST['incentive_on_service'] : "0";
						$incentive_on_product=( ($_POST['incentive_on_product'])) ? $_POST['incentive_on_product'] : "0";
						$event_incentive=( ($_POST['event_incentive'])) ? $_POST['event_incentive'] : "0";
						$course_incentive=( ($_POST['course_incentive'])) ? $_POST['course_incentive'] : "0";
						$other_incentive=( ($_POST['other_incentive'])) ? $_POST['other_incentive'] : "0";
						$total=( ($_POST['total'])) ? $_POST['total'] : "0";
						$payment_mode=( ($_POST['payment_mode'])) ? $_POST['payment_mode'] : "";
						$adjustment=( ($_POST['adjustment'])) ? $_POST['adjustment'] : "0";
						$adjustment_des=( ($_POST['adjustment_des'])) ? $_POST['adjustment_des'] : "";
						$advance_des=( ($_POST['advance_des'])) ? $_POST['advance_des'] : "";
						$expense_des=( ($_POST['expense_des'])) ? $_POST['expense_des'] : "";
						$payable_salary=( ($_POST['payable_salary'])) ? $_POST['payable_salary'] : "";
						
						
				
                        if($month =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Month";
                        }
						 if($staff_id =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Staff";
                        }
						  if($salary =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter salary";
                        }
						 if($tds =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter TDS";
                        }
						if($working_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter working days";
                        }
						if($actual_present_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter actual present days";
                        }
						if($absent_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter absent days";
                        }
						if($days_in_month =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter days in month";
                        }
						if($per_day_amount =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter per day amount";
                        }
						if($salary_to_be_paid =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter salary to be paid";
                        }
						if($after_professional_tax =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter after professional tax";
                        }
						if($advance_deduction =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter advance deduction";
                        }
						if($after_deduction =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter advance deduction ";
                        }
						
						if($expence_deduction =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter expense deduction ";
                        }
						
						if($after_expence_deduction =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter after expense deduction ";
                        }
						
						if($incentive_on_service =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter incentive on service ";
                        }
						
						if($incentive_on_product =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter incentive on product ";
                        }
						
						if($event_incentive =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter event incentive ";
                        }
						if($payable_salary =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Payable Salary ";
                        }
						
                       
                        if(count($errors))
                        {
                                ?>
                        <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>   <br></br>  
                    <?php
                        }
                        else
                        {
                            $success=1;
							
							$data_record['month']=$month;
                            $data_record['year']=$year;
							$data_record['staff_id']=$staff_id;
							$data_record['salary']=$salary;
                            $data_record['working_days'] =$working_days;
                            $data_record['actual_present_days'] =$actual_present_days;
							$data_record['absent_days'] =$absent_days;
							$data_record['days_in_month'] =$days_in_month;
							$data_record['per_day_amount'] =$per_day_amount;
							$data_record['salary_to_be_paid'] =$salary_to_be_paid;
							$data_record['after_professional_tax'] =$after_professional_tax;
							$data_record['tds'] =$tds;
							$data_record['advance_deduction'] =$advance_deduction;
							$data_record['after_deduction'] =$after_deduction;
							$data_record['expence_deduction'] =$expence_deduction;
							$data_record['after_expence_deduction'] =$after_expence_deduction;
							$data_record['incentive_on_service'] =$incentive_on_service;
							$data_record['incentive_on_product'] =$incentive_on_product;
							$data_record['event_incentive'] =$event_incentive;
							$data_record['other_incentive'] =$other_incentive;
							$data_record['course_incentive'] =$course_incentive;
							$data_record['adjustment_des'] =$adjustment_des;
							$data_record['expense_des'] =$expense_des;
							$data_record['advance_des'] =$advance_des;
							$data_record['adjustment'] =$adjustment;
							$data_record['payable_salary'] =$payable_salary;
				
							
							if($payment_mode=='Online')
							{
							$data_record['bank_name'] =$_POST['bank_name'];
                            $data_record['bank_branch_name'] =$_POST['bank_branch_name'];
							$data_record['bank_account_number'] =$_POST['bank_account_number'];							
							}
							elseif($payment_mode=='Cheque')
							{
							$data_record['bank_name'] =$_POST['bank_name1'];
                            $data_record['payment_by'] =$_POST['payment_by'];
							$data_record['cheque_number'] =$_POST['cheque_number'];						
							}
							
							$data_record['added_date'] =date("Y-m-d H:i:s");
							$data_record['admin_id'] =$_SESSION['admin_id'];
                            $branch_name=$_SESSION['branch_name'];
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								if(mysql_num_rows($ptr_branch))
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$data_record['cm_id']=$data_branch['cm_id'];
								
									$data_record['branch_name']=$branch_name;
								//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
								}
								else{
									$data_record['cm_id']="0";
									$data_record['branch_name']=$branch_name;
								}
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$data_record['branch_name']=$_SESSION['branch_name'];
							}
							
							
						
                            if($record_id)
                            {
								
                                $where_record="staff_salary_id='".$record_id."'";                                
                                $db->query_update("pr_staff_salary_management", $data_record,$where_record); 
								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                           else{
                                $record_comission=$db->query_insert("pr_staff_salary_management", $data_record);
								
								
						
								$stf = "select admin_id from site_setting where attendence_id='".$staff_id."' AND attendence_id!=''";	
								$query_stf = mysql_query($stf);
								$data_staff=mysql_fetch_array($query_stf);
								
								$data_update['status']='Paid';
								$inc_month = "select * from pr_incentive_calculation where branch_name='".$_SESSION['branch_name']."'";
							    $inc = $db->fetch_array($db->query($inc_month));
								$month1=$month-$inc['incentive_paid_month'];
								$where="staff_id='".$staff_id."' AND month='".$month1."' AND Year='".$year."'"; 
								$where1="staff_id='".$data_staff['admin_id']."' AND month='".$month1."' AND Year='".$year."'";$where2="expense_id='".$_REQUEST['expense_id']."'";  								
								$db->query_update("pr_staff_product_incentive", $data_update,$where); 
								$db->query_update("pr_staff_course_incentive", $data_update,$where); 
								$db->query_update("pr_staff_service_incentive", $data_update,$where1);
                                $db->query_update("expense", $data_update,$where2);								
											
											$slab_id=mysql_insert_id(); 
											  echo '<br></br><div id="msgbox" style="width:40%;">Record Added successfully</center></div><br></br>';
						   }
                          }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
   <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
      
   <tr>
                		<td colspan="2">
						<?php
						echo '<table width="100%"><tr><td width="35%">';
						echo 'Select Year</td><td>';
								$nxt=date('Y')-1;
$yearArray = range($nxt, 2030);
						echo ' <select required id="year" name="year" style="width:100px;" onChange="getworkingdays();">';
					
?>
    <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
    <?php
    foreach ($yearArray as $year) {
        // if you want to select a particular year
       // $selected = ($year == 2018) ? 'selected' : '';
	   
	   ?><option <?php if($year==$_REQUEST['year']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php
    }
    ?>
</select>			<?php
						
						?> 
								</td>
								
								<td>
						<?php
						
						echo 'Select Month</td><td>';
						$monthArray = range(1, 12);
						echo ' <select id="month" name="month" onChange="getmonthdays(this.value);gettotaldays();getworkingdays();">';
					?>
 <option value="">Select Month</option>
    <?php
    foreach ($monthArray as $month) {
        // padding the month with extra zero
        $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
        // you can use whatever year you want
        // you can use 'M' or 'F' as per your month formatting preference
        $fdate = date("F", strtotime("2015-$monthPadding-01"));
		
        ?><option <?php if($month==$row_record['month']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $monthPadding; ?>"><?php echo $fdate; ?></option>
   <?php }
    ?>
</select>
<?php
						echo "</td></tr></table>";
						?> 
								</td>
            		</tr>  

<tr>
   <td width="20%">Select Staff<span class="orange_font">*</span></td>
                <td width="40%">
     <select id="staff_id" name="staff_id" onChange="getmonthdays(this.value);gettotaldays();">
    <option value="">Select Staff</option>
	<?php
									if($_SESSION['type']=="S")
									{
										$sel_staff = "select admin_id,attendence_id,name from site_setting where 1 AND attendence_id!=''  ".$_SESSION['where']." order by attendence_id asc";	 
										$query_staff = mysql_query($sel_staff);
										if($total_staff=mysql_num_rows($query_staff))
										{
											while($data=mysql_fetch_array($query_staff))
											{
												?>
												<option <?php if($data['attendence_id']==$row_record['staff_id']) echo "selected"; else echo "";  ?> value="<?php echo $data['attendence_id']; ?>" ><?php echo $data['name']; ?></option>
											<?php }
										}
									}
									else
									{
										$sel_prev_id="select DISTINCT(attendence_id) from staff_previleges where 1 ".$_SESSION['where']." ".$prev_value."";
										$ptr_id=mysql_query($sel_prev_id);
										if(mysql_num_rows($ptr_id))
										{
											while($data_prev_id=mysql_fetch_array($ptr_id))
											{
												$sel_staff = "select admin_id,attendence_id,name from site_setting where 1 AND attendence_id!='' and admin_id='".$data_prev_id['admin_id']."' ".$_SESSION['where']." order by attendence_id asc";	
												$query_staff = mysql_query($sel_staff);
												if(mysql_num_rows($query_staff))
												{
													$data=mysql_fetch_array($query_staff);
													?>
												<option <?php if($data['attendence_id']==$row_record['staff_id']) echo "selected"; else echo "";  ?> value="<?php echo $data['attendence_id']; ?>" ><?php echo $data['name']; ?></option>
											<?php }
												
											}
										}
									}
									 ?>
	</select>
                </td> 
				 <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
		</tr>
		 
 

 
<?php 

?>
         <tr>
                <td width="20%">Salary<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="salary" id="salary" value="<?php if($_POST['save_changes']) echo $_POST['salary']; else echo $row_record['salary'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			
			<tr>
                <td width="20%">Days In Month</td>
                <td width="40%">
                    <input type="text" class="input_text" name="days_in_month" id="days_in_month" value="<?php if($_POST['save_changes']) echo $_POST['days_in_month']; else echo $row_record['days_in_month'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
               
                <tr>
                <td width="20%">working Days<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="working_days" id="working_days" value="<?php if($_POST['save_changes']) echo $_POST['working_days']; else echo $row_record['working_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
             
            <tr>
                <td width="20%">Present Days<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="actual_present_days" id="actual_present_days" value="<?php if($_POST['save_changes']) echo $_POST['actual_present_days']; else echo $row_record['actual_present_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            
            
            <tr>
                <td width="20%">Absent Days</td>
                <td width="40%">
                    <input type="text" onKeyUp="finalleavebalance();" class="input_text" name="absent_days" id="absent_days" value="<?php if($_POST['save_changes']) echo $_POST['absent_days']; else echo $row_record['absent_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            
			

			<tr>
                <td width="20%">Per Day Amount</td>
                <td width="40%">
                    <input type="text" onKeyUp="gettotaldays();" class="input_text" name="per_day_amount" id="per_day_amount" value="<?php if($_POST['save_changes']) echo $_POST['per_day_amount']; else echo $row_record['per_day_amount'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">Payable Salary For Month</td>
                <td width="40%">
                    <input type="text" onKeyUp="gettotaldays();" class="input_text" name="payable_salary" id="payable_salary" value="<?php if($_POST['save_changes']) echo $_POST['payable_salary']; else echo $row_record['payable_salary'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">After Professional Tax</td>
                <td width="40%">
                    <input type="text" onKeyUp="gettotaldays();" class="input_text" name="after_professional_tax" id="after_professional_tax" value="<?php if($_POST['save_changes']) echo $_POST['after_professional_tax']; else echo $row_record['after_professional_tax'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">After TDS</td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="input_text" name="tds" id="tds" value="<?php if($_POST['save_changes']) echo $_POST['tds']; else echo $row_record['tds'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">Advance Deduction</td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="input_text" name="advance_deduction" id="advance_deduction" value="<?php if($_POST['save_changes']) echo $_POST['advance_deduction']; else echo $row_record['advance_deduction'];?>" />
                </td> 
               <td width="40%"><textarea placeholder="Advance Description" id="advance_des" rows="1" name="advance_des"><?php echo $row_record['advance_des'];  ?></textarea> </td>
            </tr>
			
			<tr>
                <td width="20%">After Deduction</td>
                <td width="40%">
                    <input type="text" onKeyUp="gettotaldays();" class="input_text" name="after_deduction" id="after_deduction" value="<?php if($_POST['save_changes']) echo $_POST['after_deduction']; else echo $row_record['after_deduction'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Expense Addition</td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="input_text" name="expence_deduction" id="expence_deduction" value="<?php if($_POST['save_changes']) echo $_POST['expence_deduction']; else echo $row_record['expence_deduction'];?>" />
					<input type="hidden" name="expense_id" id="expense_id" value="" />
                </td> 
				 
                <td width="40%"><textarea placeholder="Expense Description" id="expense_des" rows="1" name="expense_des"><?php echo $row_record['expense_des'];  ?></textarea> </td>
            </tr>
			<tr>
                <td width="20%">After Expense Addition</td>
                <td width="40%">
                    <input type="text" onKeyUp="gettotaldays();" class="input_text" name="after_expence_deduction" id="after_expence_deduction" value="<?php if($_POST['save_changes']) echo $_POST['after_expence_deduction']; else echo $row_record['after_expence_deduction'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			 <tr>
                <td width="20%">Incentive On Service<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="validate[required] input_text" name="incentive_on_service" id="incentive_on_service" value="<?php if($_POST['save_changes']) echo $_POST['incentive_on_service']; else echo $row_record['incentive_on_service'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			 <tr>
                <td width="20%">Incentive On Product<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="validate[required] input_text" name="incentive_on_product" id="incentive_on_product" value="<?php if($_POST['save_changes']) echo $_POST['incentive_on_product']; else echo $row_record['incentive_on_product'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			 <tr>
                <td width="20%">Event Incentive<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="validate[required] input_text" name="event_incentive" id="event_incentive" value="<?php if($_POST['save_changes']) echo $_POST['event_incentive']; else echo $row_record['event_incentive'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			<tr>
                <td width="20%">Course Incentive<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="validate[required] input_text" name="course_incentive" id="course_incentive" value="<?php if($_POST['save_changes']) echo $_POST['course_incentive']; else echo $row_record['course_incentive'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			<tr>
                <td width="20%">Other Incentive<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="validate[required] input_text" name="other_incentive" id="other_incentive" value="<?php if($_POST['save_changes']) echo $_POST['other_incentive']; else echo $row_record['other_incentive'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			<!-- <tr>
                <td width="20%">Balance Leaves</td>
                <td width="40%">
                    <input type="text" class="input_text" name="balance_leaves" id="balance_leaves" value="<?php if($_POST['save_changes']) echo $_POST['balance_leaves']; else echo $row_record['balance_leaves'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Adjustment Leaves</td>
                <td width="40%">
                    <input type="text" class="input_text" name="adjustment_leaves" id="adjustment_leaves" value="<?php if($_POST['save_changes']) echo $_POST['adjustment_leaves']; else echo $row_record['adjustment_leaves'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Total</td>
                <td width="40%">
                    <input type="text" class="input_text" name="total" id="total" value="<?php if($_POST['save_changes']) echo $_POST['total']; else echo $row_record['total'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Payment Mode</td>
                <td width="40%">
			 <?php
					 						  
					echo '<select id="payment_mode" name="payment_mode" style="width:120px;" class="input_select_login" >';
					echo '<option value="0" selected="selected">-Payment Mode-</option>';
						if($row_record['payment_mode']=='Cash')
							echo '<option value="Cash" selected="selected">Cash</option>';
						else
							echo '<option value="Cash">Cash</option>';
						if($row_record['payment_mode']=='Online')
							echo '<option value="Online" selected="selected">Online</option>';
						else
							echo '<option value="Online">Online</option>';
						if($row_record['payment_mode']=='Cheque')
							echo '<option value="Cheque" selected="selected">Cheque</option>';
						else
							echo '<option value="Cheque">Cheque</option>';
					echo '</select>';
					  ?>
					  </td>
			<td width="40%"></td>
            </tr>
			
			
           
        </table>
		
		<table class="bank" style="display:none;" border="0" cellspacing="15" cellpadding="0" width="100%">
			<tr>
                <td width="20%">Bank Name</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_name" id="bank_name" value="<?php if($_POST['save_changes']) echo $_POST['bank_name']; else echo $row_record['bank_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Branch Name</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_branch_name" id="bank_branch_name" value="<?php if($_POST['save_changes']) echo $_POST['bank_branch_name']; else echo $row_record['bank_branch_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Account Number</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_account_number" id="bank_account_number" value="<?php if($_POST['save_changes']) echo $_POST['bank_account_number']; else echo $row_record['bank_account_number'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			</table>
			
			
			<table class="cheque" style="display:none;" border="0" cellspacing="15" cellpadding="0" width="100%">
			<tr>
                <td width="20%">Bank Name</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_name1" id="bank_name1" value="<?php if($_POST['save_changes']) echo $_POST['bank_name1']; else echo $row_record['bank_name1'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">Payment By</td>
                <td width="40%">
                    <input type="text" class="input_text" name="payment_by" id="payment_by" value="<?php if($_POST['save_changes']) echo $_POST['payment_by']; else echo $row_record['payment_by'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Cheque Number</td>
                <td width="40%">
                    <input type="text" class="input_text" name="cheque_number" id="cheque_number" value="<?php if($_POST['save_changes']) echo $_POST['cheque_number']; else echo $row_record['cheque_number'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			
			</table> -->
			<tr>
                <td width="20%">Adjustment</td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays();" class="input_text" name="adjustment" id="adjustment" value="<?php if($_POST['save_changes']) echo $_POST['adjustment']; else echo $row_record['adjustment'];?>" />
                </td> 
               <td width="40%"><textarea placeholder="Adjustment Description" id="adjustment_des" rows="1" name="adjustment_des"><?php echo $row_record['adjustment_des'];  ?></textarea> </td>
            </tr>
			<tr>
                <td width="20%">Salary To Be Paid</td>
                <td width="40%">
                    <input type="text" class="input_text" name="salary_to_be_paid" id="salary_to_be_paid" value="<?php if($_POST['save_changes']) echo $_POST['salary_to_be_paid']; else echo $row_record['salary_to_be_paid'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<table border="0" cellspacing="15" cellpadding="0" width="100%">
			 <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Salary" name="save_changes"  /></td>
            <td></td>
            </tr>
			</table>
        </form>
        </td></tr>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->

    
<script language="javascript">

function precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
}

function getmonthdays(i)
{
	var year= $("#year").val();
	var mn= $("#month").val();
	var month=mn-1;
     var days= 32 - new Date(year, month, 32).getDate();
	 $('#days_in_month').val(days);
	  var year = $("#year").val();
	var month = $("#month").val();
	var staff_id = $("#staff_id").val();
	var ptype = 'staff_salary';
	 $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'check_exist.php',
            data: { year: year,month:month,staff_id:staff_id,ptype:ptype },
            
        }).done(function(responseData) {
		// alert(responseData);
		if(responseData==1)
		{
			alert("Record All Ready Exist For This Selection");
			$("#actual_present_days").attr("readonly", "readonly");
			$("#absent_days").attr("readonly", "readonly");
			$("#salary").attr("readonly", "readonly");
			$("#after_professional_tax").attr("readonly", "readonly");
			$("#per_day_amount").attr("readonly", "readonly");
			$("#after_deduction").attr("readonly", "readonly");
			$("#after_expence_deduction").attr("readonly", "readonly");
			$("#salary_to_be_paid").attr("readonly", "readonly");
			$("#tds").attr("readonly", "readonly");
			$("#days_in_month").attr("readonly", "readonly");
			$("#working_days").attr("readonly", "readonly");
			
			$('#actual_present_days').val('');
			$('#absent_days').val('');
			$('#salary').val('');
			$('#after_professional_tax').val('');
			$('#per_day_amount').val('');
			$('#after_deduction').val('');
			$('#after_expence_deduction').val('');
			$('#salary_to_be_paid').val('');
			$('#tds').val('');
			$('#working_days').val('');
			$('#days_in_month').val('');
			
		}
		else{
			
			$("#actual_present_days").removeAttr("readonly");
			$("#absent_days").removeAttr("readonly");
			$("#'#salary'").removeAttr("readonly");
			$("#after_professional_tax").removeAttr("readonly");
			$("#per_day_amount").removeAttr("readonly");
			$("#after_deduction").removeAttr("readonly");
			$("#after_expence_deduction").removeAttr("readonly");
			$("#salary_to_be_paid").removeAttr("readonly");
			$("#tds").removeAttr("readonly");
		}
        }).fail(function() {
            console.log('Failed');
        });
	 
	// getworkingdays();
 }
 
 function gettotaldays(staff) {
 
	//var atype = $("#atype").val();
	var year = $("#year").val();
	var month = $("#month").val();
	var staff = $("#staff_id").val();
	var working_days = $("#working_days").val();
	var tds = $("#tds").val();
	var advance_deduction = $("#advance_deduction").val();
	var expence_deduction = $("#expence_deduction").val();
	var event_incentive = $("#event_incentive").val();
	var incentive_on_product = $("#incentive_on_product").val();
	var incentive_on_service = $("#incentive_on_service").val();
	var course_incentive = $("#course_incentive").val();
	var other_incentive = $("#other_incentive").val();
	var adjustment = $("#adjustment").val();
	// alert(staff);
	// if(year!='' && month!='' && staff!='' && working_days!='')
	// {
	
	if(month==''){
		alert("Please Select Month");
		return false;
	}
	if(year==''){
		alert("Please Select Year");
		return false;
	}
	if(staff==''){
		alert("Please Select Staff");
		return false;
	}
        $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'get_attendance_day_ajax.php',
            data: { year: year,month:month,staff:staff,working_days:working_days,tds:tds,advance_deduction:advance_deduction,expence_deduction:expence_deduction,event_incentive:event_incentive,incentive_on_product:incentive_on_product,incentive_on_service:incentive_on_service,course_incentive:course_incentive,other_incentive:other_incentive,adjustment:adjustment },
            
        }).done(function(responseData) {
       
		var res = responseData.split(">>");
		 
		
		
		 if(res['1']==0)
		{
			alert("Please Fill The Attendance");
			$('#actual_present_days').val('');
			$('#absent_days').val('');
			$('#salary').val('');
			$('#after_professional_tax').val('');
			$('#per_day_amount').val('');
			$('#after_deduction').val('');
			$('#after_expence_deduction').val('');
			$('#salary_to_be_paid').val('');
			$('#tds').val('');
			
			$("#actual_present_days").attr("readonly", "readonly");
			$("#absent_days").attr("readonly", "readonly");
			$("#salary").attr("readonly", "readonly");
			$("#after_professional_tax").attr("readonly", "readonly");
			$("#per_day_amount").attr("readonly", "readonly");
			$("#after_deduction").attr("readonly", "readonly");
			$("#after_expence_deduction").attr("readonly", "readonly");
			$("#salary_to_be_paid").attr("readonly", "readonly");
			$("#tds").attr("readonly", "readonly");
		}
		else{
		
		    $("#actual_present_days").removeAttr("readonly");
			$("#absent_days").removeAttr("readonly");
			$("#salary").removeAttr("readonly");
			$("#after_professional_tax").removeAttr("readonly");
			$("#per_day_amount").removeAttr("readonly");
			$("#after_deduction").removeAttr("readonly");
			$("#after_expence_deduction").removeAttr("readonly");
			$("#salary_to_be_paid").removeAttr("readonly");
			$("#tds").removeAttr("readonly");
			
		$('#actual_present_days').val(precisionRound(res['1'],2));
		$('#absent_days').val(precisionRound(res['0'],2));
		$('#salary').val(precisionRound(res['2'],2));
		$('#after_professional_tax').val(precisionRound(res['3'],2));
		$('#per_day_amount').val(precisionRound(res['4'],2));
		$('#after_deduction').val(precisionRound(res['5'],2));
		$('#after_expence_deduction').val(precisionRound(res['6'],2));
		$('#salary_to_be_paid').val(precisionRound(res['7'],2));
		$('#tds').val(precisionRound(res['8'],2));
		$('#advance_deduction').val(precisionRound(res['12'],2));
		$('#expence_deduction').val(precisionRound(res['13'],2));
		$('#incentive_on_service').val(precisionRound(res['14'],2));
		$('#incentive_on_product').val(precisionRound(res['15'],2));
		$('#event_incentive').val(precisionRound(res['16'],2));
		$('#course_incentive').val(precisionRound(res['17'],2));
		$('#expense_id').val(precisionRound(res['18'],2));
		$('#payable_salary').val(precisionRound(res['19'],2));
		//alert(res['16']);
		
		}
		
		if(res['2']==0)
		{
			alert("Please Fill Staff Salary Detail");
			$('#actual_present_days').val('');
			$('#absent_days').val('');
			$('#salary').val('');
			$('#after_professional_tax').val('');
			$('#per_day_amount').val('');
			$('#after_deduction').val('');
			$('#after_expence_deduction').val('');
			$('#salary_to_be_paid').val('');
			$('#tds').val('');
			
			$("#actual_present_days").attr("readonly", "readonly");
			$("#absent_days").attr("readonly", "readonly");
			$("#salary").attr("readonly", "readonly");
			$("#after_professional_tax").attr("readonly", "readonly");
			$("#per_day_amount").attr("readonly", "readonly");
			$("#after_deduction").attr("readonly", "readonly");
			$("#after_expence_deduction").attr("readonly", "readonly");
			$("#salary_to_be_paid").attr("readonly", "readonly");
			$("#tds").attr("readonly", "readonly");
		}
		else{
		
		    $("#actual_present_days").removeAttr("readonly");
			$("#absent_days").removeAttr("readonly");
			$("#salary").removeAttr("readonly");
			$("#after_professional_tax").removeAttr("readonly");
			$("#per_day_amount").removeAttr("readonly");
			$("#after_deduction").removeAttr("readonly");
			$("#after_expence_deduction").removeAttr("readonly");
			$("#salary_to_be_paid").removeAttr("readonly");
			$("#tds").removeAttr("readonly");
			
		$('#actual_present_days').val(precisionRound(res['1'],2));
		$('#absent_days').val(precisionRound(res['0'],2));
		$('#salary').val(precisionRound(res['2'],2));
		$('#after_professional_tax').val(precisionRound(res['3'],2));
		$('#per_day_amount').val(precisionRound(res['4'],2));
		$('#after_deduction').val(precisionRound(res['5'],2));
		$('#after_expence_deduction').val(precisionRound(res['6'],2));
		$('#salary_to_be_paid').val(precisionRound(res['7'],2));
		$('#tds').val(precisionRound(res['8'],2));
		$('#advance_deduction').val(precisionRound(res['12'],2));
		$('#expence_deduction').val(precisionRound(res['13'],2));
		$('#incentive_on_service').val(precisionRound(res['14'],2));
		$('#incentive_on_product').val(precisionRound(res['15'],2));
		$('#event_incentive').val(precisionRound(res['16'],2));
		$('#course_incentive').val(precisionRound(res['17'],2));
		$('#expense_id').val(precisionRound(res['18'],2));
		$('#payable_salary').val(precisionRound(res['19'],2));
		//alert(res['16']);
		
		}
		
		
		
        }).fail(function() {
            console.log('Failed');
        });
	// }
    }
	
	
	
	function getworkingdays() {
 
	//var atype = $("#atype").val();
	var year = $("#year").val();
	var month = $("#month").val();
	var branch_name = $("#branch_name").val();
	
	 if(year!='' && month!='')
	 {
	if(month==''){
		alert("Please Select Month");
		return false;
	}
	if(year==''){
		alert("Please Select Year");
		return false;
	}
	
        $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'get_working_day_ajax.php',
            data: { year: year,month:month,branch_name:branch_name },
            
        }).done(function(responseData) {
        //alert(responseData);
		if(responseData==0)
		{
		alert("Please Fill Working days for Month And Year Selection");	
		}
		else{
		$('#working_days').val(responseData);
		setTimeout(gettotaldays,500);
		}
        }).fail(function() {
            console.log('Failed');
        });
	 } 
 }

  function finalleavebalance() {
 
	//var atype = $("#atype").val();
	var leave_days = $("#absent_days").val();
	var previous_balance_leaves = $("#previous_balance_leaves").val();
	var monthly_leaves = $("#monthly_leaves").val();
	var leave_balance=0;
	var paid_days=0;
     if(previous_balance_leaves!='' && monthly_leaves!='' && leave_days!='')
	 {
	if(leave_days==''){
		alert("Please enter leave days");
		return false;
	}
	if(previous_balance_leaves==''){
		alert("Please enter previous balance leaves");
		return false;
	}
	if(monthly_leaves==''){
		alert("Please enter monthly leaves");
		return false;
	}
	leave_balance=((parseFloat(previous_balance_leaves)+parseFloat(monthly_leaves))-parseFloat(leave_days));
	 $('#final_leave_balance').val(leave_balance);
	 if(leave_balance<0)
	 {
	$('#final_leave_balance').val(0);	 
	
	 }
	 }	 
 }
</script>
<script language="javascript">
create_floor('add');
//payment_type('<?php echo $row_record['payment_mode']; ?>');
</script>

</body>
</html>
<?php $db->close();?>