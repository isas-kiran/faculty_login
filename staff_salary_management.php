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
	
	$select_sallery_details="select * from pr_add_salary_details where emplyee_id='".$record_id."'";
	$sallery_details=mysql_query($select_sallery_details);
	$fetch_sallery=mysql_fetch_array($sallery_details);
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='221'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> Staff Salary Management</title>
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

	<!--<script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	 <link rel="stylesheet" href="js/chosen.css" />
	<script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script>
        $(document).ready(function()
            {
                $("#year").chosen({allow_single_deselect:true});
                $("#month").chosen({allow_single_deselect:true});
                $("#staff_id").chosen({allow_single_deselect:true});
                <?php 
                if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
                {
                    ?>
                    $("#branch_name").chosen({allow_single_deselect:true});
                    <?php
                }
                ?>
            });
    </script>
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
    
        /*if(frm.actual_present_days.value=='')
        {
            disp_error +='Enter Actual present days. \n';
            document.getElementById('actual_present_days').style.border = '1px solid #f00';
            frm.actual_present_days.focus();
            error='yes';
        }*/
         
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
         
        /*if(frm.balance_leaves.value=='')
        {
            disp_error +='Enter Balance Leave. \n';
            document.getElementById('balance_leaves').style.border = '1px solid #f00';
            frm.balance_leaves.focus();
            error='yes';
        }*/
         
        /*if(frm.adjustment_leaves.value=='')
        {
            disp_error +='Enter Adjustment Leave. \n';
            document.getElementById('adjustment_leaves').style.border = '1px solid #f00';
            frm.adjustment_leaves.focus();
            error='yes';
        } */        
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
<input type="hidden" value="<?php echo $_REQUEST['record_id']; ?>" name="record_id"  id="record_id" />
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
					$employee_id=( ($_POST['staff_id'])) ? $_POST['staff_id'] : "";
					$salary=( ($_POST['salary'])) ? $_POST['salary'] : "0";
					$working_days=( ($_POST['working_days'])) ? $_POST['working_days'] : "";
					$final_paid_days=( ($_POST['final_paid_days'])) ? $_POST['final_paid_days'] : "";
					//$absent_days=( ($_POST['absent_days'])) ? $_POST['absent_days'] : "0";
					$days_in_month=( ($_POST['days_in_month'])) ? $_POST['days_in_month'] : "";
					$per_day_amount=( ($_POST['per_day_amount'])) ? $_POST['per_day_amount'] : "";
					$salary_to_be_paid=( ($_POST['salary_to_be_paid'])) ? $_POST['salary_to_be_paid'] : "";
					$basic_salary=(($_POST['basic_salary'])) ? $_POST['basic_salary'] : "";
					$basic_actual_paid=(($_POST['basic_actual_paid'])) ? $_POST['basic_actual_paid'] : "";
					$house_rent_allowance=(($_POST['house_rent_allowance'])) ? $_POST['house_rent_allowance'] : "";
					$travelling_allowance=(($_POST['travelling_allowance'])) ? $_POST['travelling_allowance'] : "";
					$education_allowance=(($_POST['education_allowance'])) ? $_POST['education_allowance'] : "";
					$medical_allowance=(($_POST['medical_allowance'])) ? $_POST['medical_allowance'] : "";
					$executive_allowance=(($_POST['executive_allowance'])) ? $_POST['executive_allowance'] : "";
					$special_allowance_1=(($_POST['special_allowance_1'])) ? $_POST['special_allowance_1'] : "";
					$total_gross_salary=(($_POST['total_salary'])) ? $_POST['total_salary'] : "";
					$professional_tax=(($_POST['professional_tax'])) ? $_POST['professional_tax'] : "";
					$esic=(($_POST['esic'])) ? $_POST['esic'] : "";
					$basis_of_pf=(($_POST['basis_of_pf'])) ? $_POST['basis_of_pf'] : "";
					$pf=(($_POST['pf'])) ? $_POST['pf'] : "";
					$after_professional_tax=( ($_POST['after_professional_tax'])) ? $_POST['after_professional_tax'] : "";
					$tds=( ($_POST['tds'])) ? $_POST['tds'] : "";
					$after_tds=( ($_POST['after_tds'])) ? $_POST['after_tds'] : "";
					
					$advance_deduction=( ($_POST['advance_deduction'])) ? $_POST['advance_deduction'] : "0";
					$after_deduction=( ($_POST['after_deduction'])) ? $_POST['after_deduction'] : "0";
					$expence_deduction=( ($_POST['expence_deduction'])) ? $_POST['expence_deduction'] : "0";
					$after_expence_deduction=(($_POST['after_expence_deduction']))? $_POST['after_expence_deduction'] : "0";
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
					$extra_days=( ($_POST['extra_days'])) ? $_POST['extra_days'] : "0";
					$extra_days_payment=( ($_POST['extra_days_payment'])) ? $_POST['extra_days_payment'] : "0";
					$extra_days_payment_amount=(($_POST['extra_days_payment_amount']))? $_POST['extra_days_payment_amount']:"0";
					$sel_att_id="select attendence_id from site_setting where admin_id='".$employee_id."' ";
					$ptr_att_id=mysql_query($sel_att_id);
					$data_att_id=mysql_fetch_array($ptr_att_id);
					$staff_id=$data_att_id['attendence_id'];
					if($month =="")
					{
						$success=0;
						$errors[$i++]="Select Month";
					}
					if($employee_id =="")
					{
						$success=0;
						$errors[$i++]="Select Staff";
					}
					if($salary =="")
					{
						$success=0;
						$errors[$i++]="Enter salary";
					}
					/*if($tds =="")
					{
							$success=0;
							$errors[$i++]="Enter TDS";
					}*/
					if($working_days =="")
					{
						$success=0;
						$errors[$i++]="Enter working days";
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
						$data_record['employee_id']=$employee_id;
						$data_record['salary']=$salary;
						$data_record['working_days'] =$working_days;
						//$data_record['actual_present_days'] =$actual_present_days;
						//$data_record['absent_days'] =$absent_days;
						$data_record['days_in_month'] =$days_in_month;
						$data_record['per_day_amount'] =$per_day_amount;
						$data_record['salary_to_be_paid'] =$salary_to_be_paid;
						$data_record['basic_salary'] =$basic_salary;
						$data_record['basic_actual_paid'] =$basic_actual_paid;
						$data_record['house_rent_allowance'] =$house_rent_allowance;
						$data_record['travelling_allowance'] =$travelling_allowance;
						$data_record['education_allowance'] =$education_allowance;
						$data_record['medical_allowance'] =$medical_allowance;
						$data_record['executive_allowance'] =$executive_allowance;
						$data_record['special_allowance_1'] =$special_allowance_1;
						$data_record['total_gross_salary'] =$total_gross_salary;
						$data_record['professional_tax'] =$professional_tax;
						$data_record['after_professional_tax'] =$after_professional_tax;
						$data_record['esic'] =$esic;
						$data_record['basis_of_pf'] =$basis_of_pf;
						$data_record['pf'] =$pf;
						$data_record['tds'] =$tds;
						$data_record['after_tds'] =$salary_to_be_paid;
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
						$data_record['final_paid_days'] =$final_paid_days;
						//$data_record['extra_days_payment'] =$extra_days_payment;
						//$data_record['extra_days_payment_amount'] =$extra_days_payment_amount;
			
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
						$branch_name=$_REQUEST['branch_name'];
						if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
						{
							$sel_branch="select cm_id,branch_name from site_setting where branch_name='".$branch_name."' and type='A'";
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
							
							$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('staff_salary','Update','Staff Salary','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);  
							echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
						}
						else
						{
							$record_comission=$db->query_insert("pr_staff_salary_management", $data_record);
							$slab_id=mysql_insert_id(); 
					
							$data_update['status']='Paid';
							$inc_month ="select * from pr_incentive_calculation where branch_name='".$_SESSION['branch_name']."'";
							$inc = $db->fetch_array($db->query($inc_month));
							$month1=$month-$inc['incentive_paid_month'];
							$where="employee_id='".$employee_id."' AND month='".$month1."' AND Year='".$year."'"; 
							$where1="employee_id='".$employee_id."' AND month='".$month1."' AND Year='".$year."'";
							$where2="expense_id='".$_REQUEST['expense_id']."'"; 
																
							$db->query_update("pr_staff_product_incentive", $data_update,$where); 
							$db->query_update("pr_staff_course_incentive", $data_update,$where); 
							$db->query_update("pr_staff_service_incentive", $data_update,$where1);
							$db->query_update("expense", $data_update,$where2);	
							
							$inst_id= explode("-",$_REQUEST['advance_installment_id']);
							$ct=count($inst_id);
							for($z=0;$z<$ct;$z++)
							{
								$val=$inst_id[$z];
								$where3="advance_installment_id='".$val."'"; 
								$db->query_update("pr_advance_installments", $data_update,$where3);
							}
							$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('staff_salary','Add','Staff Salary','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);  
							echo '<br></br><div id="msgbox" style="width:40%;">Record Added successfully</center></div><br></br>';
						}
					}
				}
if($success==0)
{
	$payment_done = "select * from pr_staff_salary_management where month='".$row_record['month']."' AND year='".$row_record['year']."' AND employee_id='".$row_record['employee_id']."' AND branch_name='".$row_record['branch_name']."' AND payment_action=1";
	$payment1 = mysql_query($payment_done);
	
	if(mysql_num_rows($payment1))
	{
		$disable="disabled";
		$msg="**** Salary Allready Done ****";
	}
	else
	{
		$disable="";	
	}
	?>
	<tr>
	<td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
        <input type="hidden" class="input_text" name="advance_installment_id" id="advance_installment_id" value="" />
		<center><p style="color:green;font-size:15px;"><b> <?php echo $msg; ?> </b></p></center>
        
        <table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
            </tr>
            <tr>
                <td colspan="2">
                <?php
                echo '<table width="100%"><tr><td width="35%">';
                echo 'Select Year</td><td>';
                $nxt=date('Y')-1;
                $yearArray = range($nxt, 2030);
                echo ' <select required id="year" name="year" style="width:100px;">';
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
                </select>			
                </td>
                <td>
                <?php
                
                echo 'Select Month</td><td>';
                $monthArray = range(1, 12);
                $currentMonth =date('Y').'-'.date('m').'-01';
                $prv_month=Date('F', strtotime('-1 month',strtotime($currentMonth)));
                $prv_month1=Date('m', strtotime('-1 month',strtotime($currentMonth)));
                echo ' <select required id="month" name="month" onChange="getmonthdays(this.value);gettotaldays();">';
                ?>
                <option value="<?php echo $prv_month1; ?>"><?php echo $prv_month; ?></option>
                <?php
                foreach ($monthArray as $month) 
				{
                    // padding the month with extra zero
                    $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
                    // you can use whatever year you want
                    // you can use 'M' or 'F' as per your month formatting preference
                    $fdate = date("F", strtotime("2015-$monthPadding-01"));
                    ?><option <?php if($month==$row_record['month']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $monthPadding; ?>"><?php echo $fdate; ?></option>
                	<?php 
				}
                ?>
                </select>
                <?php
                echo "</td></tr></table>";
                ?> 
                </td>
            </tr>  
            <?php 
            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
            {
                ?>
                <tr>
                    <td width="20%">Select Branch<span class="orange_font">*</span></td>
                    <td width="40%">
                        <?php 
                        if($_REQUEST['record_id'])
                        {
                            $sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A'";
                            $ptr_query=mysql_query($sel_cm_id);
                            $data_branch_nmae=mysql_fetch_array($ptr_query);
                        }
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                        $query_branch = mysql_query($sel_branch);
                        $total_Branch = mysql_num_rows($query_branch);
                        echo '<table width="100%"><tr><td>'; 
                        echo ' <select style="width:25%" id="branch_name" name="branch_name" onchange="get_staff(this.value)">';
                        echo '<option value="">Select Branch</option>';
                        while($row_branch = mysql_fetch_array($query_branch))
                        {
                            ?>
                            <option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
                            </option>
                            <?php
                        }
                        echo '</select>';
                        echo "</td></tr></table>";
                        ?>
                    </td>
                    <?php 
                }
                else 
                { ?>
                    <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"/> 
                    <?php 
                }?>
            </tr>
			<tr>
  				<td colspan="4">
  					<table id="staff_name" width="100%">
  						<tr>
                            <td width="11%">Select Staff<span class="orange_font">*</span></td>
                            <td width="42%">
                            <select id="staff_id" name="staff_id" onChange="getmonthdays(this.value)" >
                            <option value="">Select Staff</option>
                            <?php  
                            if($record_id)
                            {
                                $sel_staff = "select admin_id,attendence_id,name from site_setting where 1 AND attendence_id!='' order by attendence_id asc";	 
                                $query_staff = mysql_query($sel_staff);
                                if($total_staff=mysql_num_rows($query_staff))
                                {
                                    while($data=mysql_fetch_array($query_staff))
                                    {
                                        ?>
                                        <option <?php if($data['admin_id']==$row_record['employee_id']) echo "selected"; else echo "";?> value="<?php echo $data['admin_id']; ?>" ><?php echo $data['name']; ?></option>
                                        <?php 
                                    }
                                }
                            }
                            ?>
                            </select>
                            </td>
						</tr>
  					</table>
  				</td>
			</tr>
            <tr>
                <td width="20%">Salary<span class="orange_font"></span></td>
                <td width="40%"><input type="text" readonly class="validate[required] input_text" name="salary" id="salary" value="<?php if($_POST['save_changes']) echo $_POST['salary']; else echo $row_record['salary'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Days In Month</td>
                <td width="40%">
                <input type="text" readonly class="input_text" name="days_in_month" id="days_in_month" value="<?php if($_POST['save_changes']) echo $_POST['days_in_month']; else echo $row_record['days_in_month'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">working Days<span class="orange_font"></span></td>
                <td width="40%">
                <input type="text" readonly class="validate[required] input_text" name="working_days" id="working_days" value="<?php if($_POST['save_changes']) echo $_POST['working_days']; else echo $row_record['working_days'];?>" />
                    </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Final Paid Days<span class="orange_font"></span></td>
                <td width="40%">
                <input type="text" readonly class="input_text" name="final_paid_days" id="final_paid_days" value="<?php if($_POST['save_changes']) echo $_POST['final_paid_days']; else echo $row_record['final_paid_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Per Day Amount</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="gettotaldays();" class="input_text" name="per_day_amount" id="per_day_amount" value="<?php if($_POST['save_changes']) echo $_POST['per_day_amount']; else echo $row_record['per_day_amount'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Payable Salary For Month</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="gettotaldays();" class="input_text" name="payable_salary" id="payable_salary" value="<?php if($_POST['save_changes']) echo $_POST['payable_salary']; else echo $row_record['payable_salary'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Basic Salary<span class="orange_font"></span></td>
                <td width="40%">
                <input type="text" class="validate[required] input_text" readonly="readonly" name="basic_salary" id="basic_salary" value="<?php if($_POST['save_changes']) echo $_POST['basic_salary']; else echo $row_record['basic_salary'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Basic Actual Paid<span class="orange_font"></span></td>
                <td width="40%">
                <input type="text" class="validate[required] input_text" readonly="readonly" name="basic_actual_paid" id="basic_actual_paid" value="<?php if($_POST['save_changes']) echo $_POST['basic_actual_paid']; else echo $row_record['basic_actual_paid'];?>" /></td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">House Rent Allowance<span class="orange_font"></span>
                <td width="40%"><input type="text" class="validate[required] input_text" readonly="readonly" name="house_rent_allowance" id="house_rent_allowance" value="<?php if($_POST['save_changes']) echo $_POST['house_rent_allowance']; else echo $row_record['house_rent_allowance'];?>" /></td>
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Conveyance Allowance<span class="orange_font">*</span> 
                <td width="40%">
                    <input type="text" class="input_text" readonly="readonly" name="travelling_allowance" id="travelling_allowance" value="<?php if($_POST['save_changes']) echo $_POST['travelling_allowance']; else echo $row_record['travelling_allowance'];?>" />
                </td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Education Allowance<span class="orange_font">*</span> 
                <td width="40%"><input type="text" class="input_text" readonly="readonly" onKeyUp="get_total();" name="education_allowance" id="education_allowance" value="<?php if($_POST['save_changes']) echo $_POST['education_allowance']; else echo $row_record['education_allowance'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Medical Allowance <span class="orange_font">*</span>
                <td width="40%"><input type="text" class="input_text" readonly="readonly" onKeyUp="get_total();" name="medical_allowance" id="medical_allowance" value="<?php if($_POST['save_changes']) echo $_POST['medical_allowance']; else echo $row_record['medical_allowance'];?>" />
                </td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Executive Allowance <span class="orange_font">*</span>
                <td width="40%"><input type="text" class="input_text" readonly="readonly" onKeyUp="get_total();" name="executive_allowance" id="executive_allowance" value="<?php if($_POST['save_changes']) echo $_POST['executive_allowance']; else echo $row_record['executive_allowance'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Special Allowance<span class="orange_font">*</span>
                <td width="40%"><input type="text" class="input_text" readonly="readonly" onKeyUp="get_total();" name="special_allowance_1" id="special_allowance_1" value="<?php if($_POST['save_changes']) echo $_POST['special_allowance1']; else echo $row_record['special_allowance'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Total Gross Salary</td>
                <td width="20%"><input type="text" class="input_text" name="total_salary" id="total_salary" value="<?php if($_POST['save_changes']) echo $_POST['total_salary']; else echo $row_record['total_salary'];?>" />
                </td> 
            </tr>
            <tr>
                <td width="20%">Professional Tax</td>
                <td width="40%"><input type="text" readonly class="input_text" name="professional_tax" id="professional_tax" value="<?php if($_POST['save_changes']) echo $_POST['professional_tax']; else echo $row_record['professional_tax'];?>" />
                </td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">ESIC</td>
                <td width="40%"><input type="text" readonly class="input_text" name="esic" id="esic" value="<?php if($_POST['save_changes']) echo $_POST['esic']; else echo $row_record['esic'];?>" />
                </td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Basis of PF</td>
                <td width="40%"><input type="text" readonly class="input_text" name="basis_of_pf" id="basis_of_pf" value="<?php if($_POST['save_changes']) echo $_POST['basis_of_pf']; else echo $row_record['basis_of_pf'];?>" />
                </td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">PF @12%</td>
                <td width="40%"><input type="text" readonly class="input_text" name="pf" id="pf" value="<?php if($_POST['save_changes']) echo $_POST['pf']; else echo $row_record['pf'];?>" />
                </td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">After Professional Tax</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="gettotaldays();" class="input_text" name="after_professional_tax" id="after_professional_tax" value="<?php if($_POST['save_changes']) echo $_POST['after_professional_tax']; else echo $row_record['after_professional_tax'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">TDS</td>
                <td width="40%">
                    <input type="text" readonly onChange="gettotaldays();" class="input_text" name="tds" id="tds" value="<?php if($_POST['save_changes']) echo $_POST['tds']; else echo $row_record['tds'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>	
            <tr>
                <td width="20%">After TDS</td>
                <td width="40%">
                    <input type="text" readonly onChange="gettotaldays();" class="input_text" name="after_tds" id="after_tds" value="<?php if($_POST['save_changes']) echo $_POST['after_tds']; else echo $row_record['after_tds'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>			
            <tr>
                <td width="20%">Advance Given</td>
                <td width="40%">
                    <input type="text" readonly onChange="gettotaldays1();" class="input_text" name="advance_deduction" id="advance_deduction" value="<?php if($_POST['save_changes']) echo $_POST['advance_deduction']; else echo $row_record['advance_deduction'];?>" />
                </td> 
               <td width="40%"><textarea placeholder="Advance Description" id="advance_des" rows="1" name="advance_des"><?php echo $row_record['advance_des'];  ?></textarea> </td>
            </tr>
            <tr>
                <td width="20%">After Deduction</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="gettotaldays();" class="input_text" name="after_deduction" id="after_deduction" value="<?php if($_POST['save_changes']) echo $_POST['after_deduction']; else echo $row_record['after_deduction'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Expense Addition</td>
                <td width="40%">
                    <input type="text" readonly onChange="gettotaldays();" class="input_text" name="expence_deduction" id="expence_deduction" value="<?php if($_POST['save_changes']) echo $_POST['expence_deduction']; else echo $row_record['expence_deduction'];?>" />
                    <input type="hidden" name="expense_id" id="expense_id" value="" />
                </td> 
                 
                <td width="40%"><textarea placeholder="Expense Description" id="expense_des" rows="1" name="expense_des"><?php echo $row_record['expense_des'];  ?></textarea> </td>
            </tr>
            <tr>
                <td width="20%">After Expense Addition</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="gettotaldays();" class="input_text" name="after_expence_deduction" id="after_expence_deduction" value="<?php if($_POST['save_changes']) echo $_POST['after_expence_deduction']; else echo $row_record['after_expence_deduction'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Incentive On Service<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays1();" class="validate[required] input_text" name="incentive_on_service" id="incentive_on_service" value="<?php if($_POST['save_changes']) echo $_POST['incentive_on_service']; else echo $row_record['incentive_on_service'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Incentive On Product<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays1();" class="validate[required] input_text" name="incentive_on_product" id="incentive_on_product" value="<?php if($_POST['save_changes']) echo $_POST['incentive_on_product']; else echo $row_record['incentive_on_product'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Event Incentive<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays1();" class="validate[required] input_text" name="event_incentive" id="event_incentive" value="<?php if($_POST['save_changes']) echo $_POST['event_incentive']; else echo $row_record['event_incentive'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Course Incentive<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays1();" class="validate[required] input_text" name="course_incentive" id="course_incentive" value="<?php if($_POST['save_changes']) echo $_POST['course_incentive']; else echo $row_record['course_incentive'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Other Incentive<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays1();" class="validate[required] input_text" name="other_incentive" id="other_incentive" value="<?php if($_POST['save_changes']) echo $_POST['other_incentive']; else echo $row_record['other_incentive'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
        <!-- <tr>
            <td width="20%">Balance Leaves</td>
            <td width="40%">
                <input type="text" class="input_text" name="balance_leaves" id="balance_leaves" value="<?php //if($_POST['save_changes']) echo $_POST['balance_leaves']; else echo $row_record['balance_leaves'];?>" />
            </td> 
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="20%">Adjustment Leaves</td>
            <td width="40%">
                <input type="text" class="input_text" name="adjustment_leaves" id="adjustment_leaves" value="<?php //if($_POST['save_changes']) echo $_POST['adjustment_leaves']; else echo $row_record['adjustment_leaves'];?>" />
            </td> 
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="20%">Total</td>
            <td width="40%">
                <input type="text" class="input_text" name="total" id="total" value="<?php //if($_POST['save_changes']) echo $_POST['total']; else echo $row_record['total'];?>" />
            </td> 
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="20%">Payment Mode</td>
            <td width="40%">
			<?php
				/*echo '<select id="payment_mode" name="payment_mode" style="width:120px;" class="input_select_login" >';
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
				echo '</select>';*/
			?>
			</td>
			<td width="40%"></td>
		</tr>
		</table>
		<table class="bank" style="display:none;" border="0" cellspacing="15" cellpadding="0" width="100%">
			<tr>
                <td width="20%">Bank Name</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_name" id="bank_name" value="<?php //if($_POST['save_changes']) echo $_POST['bank_name']; else echo $row_record['bank_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Branch Name</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_branch_name" id="bank_branch_name" value="<?php //if($_POST['save_changes']) echo $_POST['bank_branch_name']; else echo $row_record['bank_branch_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Account Number</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_account_number" id="bank_account_number" value="<?php //if($_POST['save_changes']) echo $_POST['bank_account_number']; else echo $row_record['bank_account_number'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			</table>			
			<table class="cheque" style="display:none;" border="0" cellspacing="15" cellpadding="0" width="100%">
			<tr>
                <td width="20%">Bank Name</td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_name1" id="bank_name1" value="<?php //if($_POST['save_changes']) echo $_POST['bank_name1']; else echo $row_record['bank_name1'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Payment By</td>
                <td width="40%">
                    <input type="text" class="input_text" name="payment_by" id="payment_by" value="<?php //if($_POST['save_changes']) echo $_POST['payment_by']; else echo $row_record['payment_by'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Cheque Number</td>
                <td width="40%">
                    <input type="text" class="input_text" name="cheque_number" id="cheque_number" value="<?php //if($_POST['save_changes']) echo $_POST['cheque_number']; else echo $row_record['cheque_number'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			
			</table> -->
			<tr>
                <td width="20%">Adjustment</td>
                <td width="40%">
                    <input type="text" onChange="gettotaldays1();" class="input_text" name="adjustment" id="adjustment" value="<?php if($_POST['save_changes']) echo $_POST['adjustment']; else echo $row_record['adjustment'];?>" />
                </td> 
               <td width="40%"><textarea placeholder="Adjustment Description" id="adjustment_des" rows="1" name="adjustment_des"><?php echo $row_record['adjustment_des'];  ?></textarea> </td>
            </tr>
			<tr>
                <td width="20%">Salary To Be Paid</td>
                <td width="40%">
                    <input type="text" readonly class="input_text" name="salary_to_be_paid" id="salary_to_be_paid" value="<?php if($_POST['save_changes']) echo $_POST['salary_to_be_paid']; else echo $row_record['salary_to_be_paid'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
            	<td colspan="3">
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">
                        <tr>
                            <?php 
                            //if(!mysql_num_rows($payment1))
                            //{
                                ?>
                                <td align="center"><input type="submit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Salary" name="save_changes"  id="save_changes"/></td>
                                <?php 
                            //} ?>
                            <td></td>
                        </tr>
                    </table>
                </td>
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

function get_staff(branch_name)
{
	var prod_data="action=get_staff_for_staff_leave&branch_name="+branch_name;
	//alert(prod_data);
	$.ajax({
		url:"ajax.php",type:"post",timeout: 5000,data:prod_data,cache:false,
		success: function(prod_data)
		{
			$("#staff_name").html(prod_data);
			$("#staff_id").chosen({allow_single_deselect:true});
		}
		});
		
}


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
	if(year!='' && month!='' && staff_id!='')
	{
		var record_id = $("#record_id").val();
		if(record_id=='')
		{
			var ptype = 'staff_salary';
		}
		//alert(staff_id+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
		$.ajax({ 
	        type: 'post',
            url: 'check_exist.php',
            data: { year: year,month:month,staff_id:staff_id,ptype:ptype },
            
        }).done(function(responseData) {
		//alert(responseData);
		if(responseData==1)
		{
			alert("Record All Ready Exist For This Selection");
			//$("#save_changes").hide();
		}
		else
		{
			$("#save_changes").show();
		}
		
        }).fail(function() {
            console.log('Failed');
        });
	 }
 }
 
 function gettotaldays1() {
 
 	var advance_deduction = $("#advance_deduction").val();
	var event_incentive = $("#event_incentive").val();
	var incentive_on_product = $("#incentive_on_product").val();
	var incentive_on_service = $("#incentive_on_service").val();
	var course_incentive = $("#course_incentive").val();
	var other_incentive = $("#other_incentive").val();
	var adjustment = $("#adjustment").val();
	var expence_add=$("#after_expence_deduction").val();
	//var extra_days_payment_amount=$("#extra_days_payment_amount").val();
	if(event_incentive=='')
	{
		event_incentive=0;
	}
	
	if(incentive_on_product=='')
	{
		incentive_on_product=0;
	}
	if(incentive_on_service=='')
	{
		incentive_on_service=0;
	}
	if(course_incentive=='')
	{
		course_incentive=0;
	}
	if(other_incentive=='')
	{
		other_incentive=0;
	}
	if(adjustment=='')
	{
		adjustment=0;
	}
	if(expence_add=='')
	{
		expence_add=0;
	}
	if(advance_deduction=='')
	{
		advance_deduction=0;
	}
	
	var total=((parseFloat(expence_add)+parseFloat(incentive_on_service)+parseFloat(incentive_on_product)+parseFloat(event_incentive)+parseFloat(other_incentive)+parseFloat(course_incentive)+parseFloat(adjustment)));
	$('#salary_to_be_paid').val(precisionRound(total,2));
    }
	
	
	function gettotaldays(staff) 
	{
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
	//var extra_days_payment=$("#extra_days_payment").val();
	
	if(year!='' && month!='' && staff!='')
	{
	
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
		var branch_name = $("#branch_name").val();
			
		$.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'get_attendance_day_ajax.php',
            data: { branch_name:branch_name,year: year,month:month,staff:staff,working_days:working_days,tds:tds,advance_deduction:advance_deduction,expence_deduction:expence_deduction,event_incentive:event_incentive,incentive_on_product:incentive_on_product,incentive_on_service:incentive_on_service,course_incentive:course_incentive,other_incentive:other_incentive,adjustment:adjustment },
        }).done(function(responseData) {
       	//alert(responseData);
		var res = responseData.split(">>");
		
		$('#advance_installment_id').val(res[29]);
		
		//alert(res[29]);
		if(res[20]==0)
		{
			alert("Please Fill The Attendance");
			//$('#actual_present_days').val('');
			//$('#absent_days').val('');
			$('#after_professional_tax').val('');
			$('#per_day_amount').val('');
			$('#after_deduction').val('');
			$('#after_expence_deduction').val('');
			$('#salary_to_be_paid').val('');
			$('#salary_to_be_paid').val(0);
			$('#tds').val('');
			$('#basic_salary').val(0);
			$('#travelling_allowance').val(0);
			$('#education_allowance').val(0);
			$('#medical_allowance').val(0);
			$('#executive_allowance').val(0);
			$('#special_allowance_1').val(0);
			$('#total_salary').val(0);
			$('#education_allowance').val(0);
			$('#medical_allowance').val(0);
			$('#executive_allowance').val(0);
			$('#special_allowance_1').val(0);
			$('#total_salary').val(0);
			
			$('#professional_tax').val(0);
			$('#esic').val(0);
			$('#basis_of_pf').val(0);
			$('#pf').val(0);
			$('#after_professional_tax').val(0);
			$('#tds').val(0);
			$('#after_tds').val(0);
			
			//$("#actual_present_days").attr("readonly", "readonly");
			//$("#absent_days").attr("readonly", "readonly");
			$("#after_professional_tax").attr("readonly", "readonly");
			$("#per_day_amount").attr("readonly", "readonly");
			$("#after_deduction").attr("readonly", "readonly");
			$("#after_expence_deduction").attr("readonly", "readonly");
			$("#salary_to_be_paid").attr("readonly", "readonly");
			$("#tds").attr("readonly", "readonly");
		}
		else
		{
			$('#after_professional_tax').val(precisionRound(res[3],2));
			$('#per_day_amount').val(precisionRound(res[4],2));
			$('#after_deduction').val(precisionRound(res[5],2));
			$('#after_expence_deduction').val(precisionRound(res[6],2));
			$('#salary_to_be_paid').val(precisionRound(res[7],2));
			$('#tds').val(precisionRound(res[8],2));
			$('#advance_deduction').val(precisionRound(res[12],2));
			$('#expence_deduction').val(precisionRound(res[13],2));
			$('#incentive_on_service').val(precisionRound(res[14],2));
			$('#incentive_on_product').val(precisionRound(res[15],2));
			$('#event_incentive').val(precisionRound(res[16],2));
			$('#course_incentive').val(precisionRound(res[17],2));
			$('#expense_id').val(precisionRound(res[18],2));
			$('#payable_salary').val(precisionRound(res[19],2));
			$('#working_days').val(precisionRound(res[21],2));
			$('#final_paid_days').val(precisionRound(res[23],2));
			
			$('#basic_salary').val(res[30]);
			$('#basic_actual_paid').val(res[31]);
			$('#house_rent_allowance').val(res[32]);
			$('#travelling_allowance').val(res[33]);
			$('#education_allowance').val(res[34]);
			$('#medical_allowance').val(res[35]);
			$('#executive_allowance').val(res[36]);
			$('#special_allowance_1').val(res[37]);
			$('#total_salary').val(res[38]);
			$('#professional_tax').val(res[39]);
			$('#esic').val(res[40]);
			$('#basis_of_pf').val(res[41]);
			$('#pf').val(res[42]);
			$('#after_professional_tax').val(res[43]);
			$('#tds').val(res[44]);
			$('#after_tds').val(res[45]);
			//$('#extra_days').val(precisionRound(res[24],2));
			//$('#tp').html(res[25]);
			//$('#extra_days_payment_amount').val(precisionRound(res[26],2));		
			//alert(res['16']);
		}
		if(res[2]==0)
		{
			alert("Please Fill Staff Salary Detail");
			//	$('#actual_present_days').val('');
			//	$('#absent_days').val('');
			$('#salary').val('');
			$('#after_professional_tax').val('');
			$('#per_day_amount').val('');
			$('#after_deduction').val('');
			$('#after_expence_deduction').val('');
			$('#salary_to_be_paid').val('');
			$('#tds').val('');
			$('#basic_salary').val(0);
			$('#travelling_allowance').val(0);
			$('#education_allowance').val(0);
			$('#medical_allowance').val(0);
			$('#executive_allowance').val(0);
			$('#special_allowance_1').val(0);
			$('#total_salary').val(0);
			$('#professional_tax').val(0);
			$('#esic').val(0);
			$('#basis_of_pf').val(0);
			$('#pf').val(0);
			$('#after_professional_tax').val(0);
			$('#tds').val(0);
			$('#after_tds').val(0);
			//$("#actual_present_days").attr("readonly", "readonly");
			$("#absent_days").attr("readonly", "readonly");
			$("#salary").attr("readonly", "readonly");
			$("#after_professional_tax").attr("readonly", "readonly");
			$("#per_day_amount").attr("readonly", "readonly");
			$("#after_deduction").attr("readonly", "readonly");
			$("#after_expence_deduction").attr("readonly", "readonly");
			$("#salary_to_be_paid").attr("readonly", "readonly");
			$("#tds").attr("readonly", "readonly");
		}
		else
		{
			$('#salary').val(precisionRound(res[2],2));
			$('#after_professional_tax').val(precisionRound(res[3],2));
			$('#per_day_amount').val(precisionRound(res[4],2));
			$('#after_deduction').val(precisionRound(res[5],2));
			$('#after_expence_deduction').val(precisionRound(res[6],2));
			$('#salary_to_be_paid').val(precisionRound(res[7],2));
			$('#tds').val(precisionRound(res[8],2));
			$('#advance_deduction').val(precisionRound(res[12],2));
			$('#expence_deduction').val(precisionRound(res[13],2));
			$('#incentive_on_service').val(precisionRound(res[14],2));
			$('#incentive_on_product').val(precisionRound(res[15],2));
			$('#event_incentive').val(precisionRound(res[16],2));
			$('#course_incentive').val(precisionRound(res[17],2));
			$('#expense_id').val(precisionRound(res[18],2));
			$('#payable_salary').val(precisionRound(res[19],2));
			$('#working_days').val(precisionRound(res[21],2));
			$('#final_paid_days').val(precisionRound(res[23],2));
			$('#basic_salary').val(res[30]);
			$('#basic_actual_paid').val(res[31]);
			$('#house_rent_allowance').val(res[32]);
			$('#travelling_allowance').val(res[33]);
			$('#education_allowance').val(res[34]);
			$('#medical_allowance').val(res[35]);
			$('#executive_allowance').val(res[36]);
			$('#special_allowance_1').val(res[37]);
			$('#total_salary').val(res[38]);
			$('#professional_tax').val(res[39]);
			$('#esic').val(res[40]);
			$('#basis_of_pf').val(res[41]);
			$('#pf').val(res[42]);
			$('#after_professional_tax').val(res[43]);
			$('#tds').val(res[44]);
			$('#after_tds').val(res[45]);
			//$('#extra_days').val(precisionRound(res[24],2));
			//$('#tp').html(res[25]);
			//$('#extra_days_payment_amount').val(precisionRound(res[26],2));
			//alert(res[21]);			
		}
		if(res[21]==0)
		{
			alert("Please Fill Working days for Month And Year Selection");	
			//	$('#actual_present_days').val('');
			//	$('#absent_days').val('');
			$('#salary').val('');
			$('#after_professional_tax').val('');
			$('#per_day_amount').val('');
			$('#after_deduction').val('');
			$('#after_expence_deduction').val('');
			$('#salary_to_be_paid').val('');
			$('#tds').val('');
			$('#basic_salary').val(0);
			$('#travelling_allowance').val(0);
			$('#education_allowance').val(0);
			$('#medical_allowance').val(0);
			$('#executive_allowance').val(0);
			$('#special_allowance_1').val(0);
			$('#total_salary').val(0);
			$('#professional_tax').val(0);
			$('#esic').val(0);
			$('#basis_of_pf').val(0);
			$('#pf').val(0);
			$('#after_professional_tax').val(0);
			$('#tds').val(0);
			$('#after_tds').val(0);
			//	$("#actual_present_days").attr("readonly", "readonly");
			//	$("#absent_days").attr("readonly", "readonly");
			$("#salary").attr("readonly", "readonly");
			$("#after_professional_tax").attr("readonly", "readonly");
			$("#per_day_amount").attr("readonly", "readonly");
			$("#after_deduction").attr("readonly", "readonly");
			$("#after_expence_deduction").attr("readonly", "readonly");
			$("#salary_to_be_paid").attr("readonly", "readonly");
			$("#tds").attr("readonly", "readonly");
		}
		else
		{
			$('#salary').val(precisionRound(res[2],2));
			$('#after_professional_tax').val(precisionRound(res[3],2));
			$('#per_day_amount').val(precisionRound(res[4],2));
			$('#after_deduction').val(precisionRound(res[5],2));
			$('#after_expence_deduction').val(precisionRound(res[6],2));
			$('#salary_to_be_paid').val(precisionRound(res[7],2));
			$('#tds').val(precisionRound(res[8],2));
			$('#advance_deduction').val(precisionRound(res[12],2));
			$('#expence_deduction').val(precisionRound(res[13],2));
			$('#incentive_on_service').val(precisionRound(res[14],2));
			$('#incentive_on_product').val(precisionRound(res[15],2));
			$('#event_incentive').val(precisionRound(res[16],2));
			$('#course_incentive').val(precisionRound(res[17],2));
			$('#expense_id').val(precisionRound(res[18],2));
			$('#payable_salary').val(precisionRound(res[19],2));
			$('#working_days').val(precisionRound(res[21],2));
			$('#final_paid_days').val(precisionRound(res[23],2));
			$('#basic_salary').val(res[30]);
			$('#basic_actual_paid').val(res[31]);
			$('#house_rent_allowance').val(res[32]);
			$('#travelling_allowance').val(res[33]);
			$('#education_allowance').val(res[34]);
			$('#medical_allowance').val(res[35]);
			$('#executive_allowance').val(res[36]);
			$('#special_allowance_1').val(res[37]);
			$('#total_salary').val(res[38]);
			$('#professional_tax').val(res[39]);
			$('#esic').val(res[40]);
			$('#basis_of_pf').val(res[41]);
			$('#pf').val(res[42]);
			$('#after_professional_tax').val(res[43]);
			$('#tds').val(res[44]);
			$('#after_tds').val(res[45]);
		}
		if(res[22]==0)
		{
			alert("Please Fill Staff Leave Details");
			//$('#actual_present_days').val('');
			//$('#absent_days').val('');
			$('#salary').val('');
			$('#after_professional_tax').val('');
			$('#per_day_amount').val('');
			$('#after_deduction').val('');
			$('#after_expence_deduction').val('');
			$('#salary_to_be_paid').val('');
			$('#tds').val('');
			$('#basic_salary').val(0);
			$('#travelling_allowance').val(0);
			$('#professional_tax').val(0);
			$('#esic').val(0);
			$('#basis_of_pf').val(0);
			$('#pf').val(0);
			$('#after_professional_tax').val(0);
			$('#tds').val(0);
			$('#after_tds').val(0);
			//$("#actual_present_days").attr("readonly", "readonly");
			//$("#absent_days").attr("readonly", "readonly");
			$("#salary").attr("readonly", "readonly");
			$("#after_professional_tax").attr("readonly", "readonly");
			$("#per_day_amount").attr("readonly", "readonly");
			$("#after_deduction").attr("readonly", "readonly");
			$("#after_expence_deduction").attr("readonly", "readonly");
			$("#salary_to_be_paid").attr("readonly", "readonly");
			$("#tds").attr("readonly", "readonly");
		}
		else
		{
			$('#salary').val(precisionRound(res[2],2));
			$('#after_professional_tax').val(precisionRound(res[3],2));
			$('#per_day_amount').val(precisionRound(res[4],2));
			$('#after_deduction').val(precisionRound(res[5],2));
			$('#after_expence_deduction').val(precisionRound(res[6],2));
			$('#salary_to_be_paid').val(precisionRound(res[7],2));
			$('#tds').val(precisionRound(res[8],2));
			$('#advance_deduction').val(precisionRound(res[12],2));
			$('#expence_deduction').val(precisionRound(res[13],2));
			$('#incentive_on_service').val(precisionRound(res[14],2));
			$('#incentive_on_product').val(precisionRound(res[15],2));
			$('#event_incentive').val(precisionRound(res[16],2));
			$('#course_incentive').val(precisionRound(res[17],2));
			$('#expense_id').val(precisionRound(res[18],2));
			$('#payable_salary').val(precisionRound(res[19],2));
			$('#working_days').val(precisionRound(res[21],2));
			$('#final_paid_days').val(precisionRound(res[23],2));
			$('#basic_salary').val(res[30]);
			$('#basic_actual_paid').val(res[31]);
			$('#house_rent_allowance').val(res[32]);
			$('#travelling_allowance').val(res[33]);
			$('#education_allowance').val(res[34]);
			$('#medical_allowance').val(res[35]);
			$('#executive_allowance').val(res[36]);
			$('#special_allowance_1').val(res[37]);
			$('#total_salary').val(res[38]);
			$('#professional_tax').val(res[39]);
			$('#esic').val(res[40]);
			$('#basis_of_pf').val(res[41]);
			$('#pf').val(res[42]);
			$('#after_professional_tax').val(res[43]);
			$('#tds').val(res[44]);
			$('#after_tds').val(res[45]);
		}
		setTimeout(gettotaldays1());
        }).fail(function() {
            console.log('Failed');
        });
		
	}
}

</script>
<script language="javascript">
//create_floor('add');
//payment_type('<?php //echo $row_record['payment_mode']; ?>');
</script>
<script language="javascript">
<?php 
if($_SESSION['type']!="S"  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' )
{
	?>
	var branch_name=document.getElementById('branch_name').value;
	get_staff(branch_name);
	<?php
}
?>
</script>
</body>
</html>
<?php $db->close();?>