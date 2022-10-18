<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_staff_leave_management where staff_leave_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	
	 $select_sallery_details="select * from sallery where admin_id='".$record_id."'";
	$sallery_details=mysql_query($select_sallery_details);
	$fetch_sallery=mysql_fetch_array($sallery_details);
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update site_setting set photo='' where admin_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("staff_photo/".$row_record['photo']))
        unlink("staff_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='213'";
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
<?php if($record_id) echo "Edit"; else echo "Add";?>
 Staff Leave Management</title>
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
	 <link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function()
	{
		$("#year").chosen({allow_single_deselect:true});
		$("#month").chosen({allow_single_deselect:true});
		$("#staff_id").chosen({allow_single_deselect:true});
		$("#extra_leave_type").chosen({allow_single_deselect:true});
		
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
	 	if(frm.no_of_days_in_month.value=='')
		 {
			 disp_error +='Select No. of days\n';
			 document.getElementById(no_of_days_in_month).style.border = '1px solid #f00';
			 frm.no_of_days_in_month.focus();
			 error='yes';
		 }
	   	if(frm.present_days.value=='')
		 {
			 disp_error +='Enter Present days \n';
			 document.getElementById('present_days').style.border = '1px solid #f00';
			 frm.present_days.focus();
			 error='yes';
	     }

		 if(frm.leave_days.value=='')
		 {
			 disp_error +='Enter Leave days. \n';
			 document.getElementById('leave_days').style.border = '1px solid #f00';
			 frm.leave_days.focus();
			 error='yes';
	     }
		 
		
		 
		
		 
		 if(frm.previous_balance_leaves.value=='')
		 {
			 disp_error +='Enter Previous balance leaves. \n';
			 document.getElementById('previous_balance_leaves').style.border = '1px solid #f00';
			 frm.previous_balance_leaves.focus();
			 error='yes';
	     }
		 
		
		 
		 if(frm.monthly_leaves.value=='')
		 {
			 disp_error +='Enter Monthly Leaves. \n';
			 document.getElementById('monthly_leaves').style.border = '1px solid #f00';
			 frm.monthly_leaves.focus();
			 error='yes';
	     }
		 
	
		 
		 if(frm.final_leave_balance.value=='')
		 {
			 disp_error +='Enter Leave balance. \n';
			 document.getElementById('final_leave_balance').style.border = '1px solid #f00';
			 frm.final_leave_balance.focus();
			 error='yes';
	     }
		
		   if(frm.final_paid_days.value=='')
		 {
			 disp_error +='Enter Leave balance. \n';
			 document.getElementById('final_paid_days').style.border = '1px solid #f00';
			 frm.final_paid_days.focus();
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
						
						$employee_id=( ($_POST['staff_id'])) ? $_POST['staff_id'] : "";
						$number_of_days_in_month=( ($_POST['number_of_days_in_month'])) ? $_POST['number_of_days_in_month'] : "";
						$working_days=( ($_POST['working_days'])) ? $_POST['working_days'] : "";
						$present_days=( ($_POST['present_days'])) ? $_POST['present_days'] : "";
						$leave_days=( ($_POST['leave_days'])) ? $_POST['leave_days'] : "0";
						$previous_balance_leaves=( ($_POST['previous_balance_leaves']))?$_POST['previous_balance_leaves']:"0";
						$monthly_leaves=( ($_POST['monthly_leaves'])) ? $_POST['monthly_leaves'] : "0";
						$final_leave_balance=( ($_POST['final_leave_balance'])) ? $_POST['final_leave_balance'] : "0";
						$final_paid_days=( ($_POST['final_paid_days'])) ? $_POST['final_paid_days'] : "";
						$description=( ($_POST['description'])) ? $_POST['description'] : "";
						$extra_days=( ($_POST['extra_days'])) ? $_POST['extra_days'] : "0";
						$extra_leave_type=( ($_POST['extra_leave_type'])) ? $_POST['extra_leave_type'] : "";
						$late_mark=( ($_POST['late_mark'])) ? $_POST['late_mark'] : "0";
						$total_working_days=( ($_POST['total_working_days'])) ? $_POST['total_working_days'] : "0";
						
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
						  if($number_of_days_in_month =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter No. of days";
                        }
						
						if($present_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Present days";
                        }
						if($leave_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Leave days";
                        }
						
						if($previous_balance_leaves =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Previous balance leaves";
                        }
					
						if($monthly_leaves =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Monthly leaves";
                        }
						
						if($final_leave_balance =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Final leave balance";
                        }
						if($final_paid_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Final paid days";
                        }
						
						if($total_working_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Total Working days";
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
							$branch_name=$_POST['branch_name'];
							$data_record['month']=$month;
                            $data_record['year']=$year;
							$data_record['staff_id'] =$staff_id;
							$data_record['employee_id']=$employee_id;
							$data_record['number_of_days_in_month']=$number_of_days_in_month;
							$data_record['working_days'] =$working_days;
                            $data_record['present_days'] =$present_days;
                            $data_record['leave_days'] =$leave_days;
							$data_record['previous_balance_leaves'] =$previous_balance_leaves;
							$data_record['monthly_leaves'] =$monthly_leaves;
							$data_record['final_leave_balance'] =$final_leave_balance;
							$data_record['final_paid_days'] =$final_paid_days;
							$data_record['description'] =$description;
							$data_record['extra_days'] =$extra_days;
							$data_record['late_mark'] =$late_mark;
							$data_record['total_working_days'] =$total_working_days;
							$data_record['extra_leave_type'] =$extra_leave_type;
							$data_record['added_date'] =date("Y-m-d H:i:s");
							$data_record['admin_id'] =$_SESSION['admin_id'];
                           
							
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{
								$sel_branch="select branch_name,cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								if(mysql_num_rows($ptr_branch))
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$data_record['cm_id']=$data_branch['cm_id'];
								
									$data_record['branch_name']=$data_branch['branch_name'];
								//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
								}
								else{
									$data_record['cm_id']="0";
									$data_record['branch_name']=$data_branch['branch_name'];
								}
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$data_record['branch_name']=$_SESSION['branch_name'];
							}
							
							
						
                            if($record_id)
                            {
								$select_pre_leave="select * from pr_previous_leave_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$employee_id."'";
							   	$leave = mysql_query($select_pre_leave);
                               	if(mysql_num_rows($leave))
							   	{
									$data_record1['employee_id']=$employee_id;
									$data_record1['previous_balance_leaves'] =$final_leave_balance;
									$data_record1['monthly_leave'] =0;
									$where_record1="month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff_id']."'";                                
                                	$db->query_update("pr_previous_leave_management", $data_record1,$where_record1);   
							   	}
							    else
							   	{
									$data_record1['month']=$month;
                           			$data_record1['year']=$year;
									$data_record1['staff_id']=$staff_id;
									$data_record1['employee_id']=$employee_id;
									$data_record1['previous_balance_leaves']=$final_leave_balance;
                            		$data_record1['monthly_leave'] =$monthly_leaves;
									$data_record1['added_date'] =date("Y-m-d H:i:s");
									$data_record1['admin_id'] =$_SESSION['admin_id'];
                            
									if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
									{
										$sel_branch="select branch_name,cm_id,branch_name from site_setting where branch_name='".$branch_name."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										if(mysql_num_rows($ptr_branch))
										{
											$data_branch=mysql_fetch_array($ptr_branch);
											$data_record1['cm_id']=$data_branch['cm_id'];
										
											$data_record1['branch_name']=$data_branch['branch_name'];
										//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
										}
										else{
											$data_record1['cm_id']="0";
											$data_record1['branch_name']=$data_branch['branch_name'];
										}
									}	
									else
									{
										$data_record1['cm_id']=$_SESSION['cm_id'];
										$data_record1['branch_name']=$_SESSION['branch_name'];
									}
								   	$record_comission1=$db->query_insert("pr_previous_leave_management", $data_record1); 
							   	}
                               	$where_record="staff_leave_id='".$record_id."'";                                
                               	$db->query_update("pr_staff_leave_management", $data_record,$where_record); 
								$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('staff_leaves','Update','Staff Leaves','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);  
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                           else
						   {
							   	$select_pre_leave="select * from pr_previous_leave_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$employee_id."'";
							   	$leave = mysql_query($select_pre_leave);
                               	if(mysql_num_rows($leave))
							   	{
							   		$data_record1['previous_balance_leaves'] =$final_leave_balance;
									$data_record1['monthly_leave'] =0;
									$where_record1="month='".$_REQUEST['month']."' AND year='".$_POST['year']."' AND staff_id='".$_REQUEST['staff_id']."'";                                
                                	$db->query_update("pr_previous_leave_management", $data_record1,$where_record1);   
							   	}
							   	else
							   	{
									$data_record1['month']=$month;
                            		$data_record1['year']=$year;
									$data_record1['staff_id']=$staff_id;
									$data_record1['employee_id']=$employee_id;
									$data_record1['previous_balance_leaves']=$final_leave_balance;
                            		$data_record1['monthly_leave'] =$monthly_leaves;
									$data_record1['added_date'] =date("Y-m-d H:i:s");
									$data_record1['admin_id'] =$_SESSION['admin_id'];
                            		//$branch_name=$_SESSION['branch_name'];
									if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
									{
										$sel_branch="select branch_name,cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										if(mysql_num_rows($ptr_branch))
										{
											$data_branch=mysql_fetch_array($ptr_branch);
											$data_record1['cm_id']=$data_branch['cm_id'];
								
											$data_record1['branch_name']=$branch_name;
											//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
										}
										else
										{
											$data_record1['cm_id']="0";
											$data_record1['branch_name']=$branch_name;
										}
									}	
									else
									{
										$data_record1['cm_id']=$_SESSION['cm_id'];
										$data_record1['branch_name']=$_SESSION['branch_name'];
									}
									$record_comission1=$db->query_insert("pr_previous_leave_management", $data_record1); 
							   	}
								$record_comission=$db->query_insert("pr_staff_leave_management", $data_record);
								$slab_id=mysql_insert_id(); 
											
								$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('staff_leaves','Add','Staff Leaves','".$slab_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);  
								echo '<br></br><div id="msgbox" style="width:40%;">Record Added successfully</center></div><br></br>';
						   	}
                    	}
                    }
                    if($success==0)
                    {
						$payment_done = "select * from pr_staff_salary_management where month='".$row_record['month']."' AND year='".$row_record['year']."' AND staff_id='".$row_record['staff_id']."' AND branch_name='".$row_record['branch_name']."' AND payment_action=1";
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
                        <tr><td>
                        	<form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
                            <center><p style="color:green;font-size:15px;"><b> <?php echo $msg; ?> </b></p></center>
                        	<table border="0" cellspacing="15" cellpadding="0" width="100%">
                       		<tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>      
                       	<tr>
                		<td colspan="2">
						<?php
						echo '<table width="100%"><tr><td width="35%">';
						echo 'Select Year</td><td>';
						$nxt=date('Y')-1;
						$yearArray = range($nxt, 2030);
						echo '<select required id="year" name="year" style="width:100px;">';
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
						echo ' <select required id="month" name="month" onChange="getmonthdays(this.value); gettotaldays(this.value);">';
					?>
                        <option value="<?php echo $prv_month1; ?>"><?php echo $prv_month; ?></option>
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
					<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
                            $sel_branch="SELECT * FROM branch where 1 order by branch_id asc ";	 
                            $query_branch=mysql_query($sel_branch);
                            $total_Branch=mysql_num_rows($query_branch);
                            echo '<table width="100%"><tr><td>'; 
                            echo '<select style="width:25%" id="branch_name" name="branch_name" onchange="get_staff(this.value);">';
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
                   		</tr>
						<?php 
					}  
					else 
					{ ?>
						<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']?>"/>
						<?php 
					}?>
	  				<tr>
                        <td colspan="4">
                            <table id="staff_name" width="100%">
                                <tr>
                                    <td width="11%">Select Staff<span class="orange_font">*</span></td>
                                    <td width="42%">
                                    <select id="staff_id" name="staff_id" onChange="getmonthdays(this.value);" >
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
                                                    <option <?php if($data['admin_id']==$row_record['employee_id']) echo "selected"; else echo "";  ?> value="<?php echo $data['admin_id']; ?>" ><?php echo $data['name']; ?></option>
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
                <td width="20%">Extra Days Type</td>
                <td width="40%">
                <?php if($record_id){ if($row_record['extra_days']==0) { $disabled="disabled"; } else { $disabled=""; } } ?>
                <select id="extra_leave_type" <?php echo $disabled; ?> name="extra_leave_type" onChange="finalleavebalance();">
                
                <option <?php if($row_record['extra_leave_type']=='with leaves') echo "selected"; else echo "" ?> value="with leaves">With leaves</option>
                <option <?php if($row_record['extra_leave_type']=='with salary') echo "selected"; else  echo ""  ?> value="with salary">With salary</option>
                </select>
                </td>
			</tr>
            <tr>
                <td width="20%">Number Of Days (in month)<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" readonly class="validate[required] input_text" name="number_of_days_in_month" id="number_of_days_in_month" value="<?php if($_POST['save_changes']) echo $_POST['number_of_days_in_month']; else echo $row_record['number_of_days_in_month'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			<tr>
                <td width="20%">Number Of Working Days (in month)<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" readonly class="validate[required] input_text" name="working_days" id="working_days" value="<?php if($_POST['save_changes']) echo $_POST['working_days']; else echo $row_record['working_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Present Days<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="finalleavebalance();" class="validate[required] input_text" name="present_days" id="present_days" value="<?php if($_POST['save_changes']) echo $_POST['present_days']; else echo $row_record['present_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            <tr>
                <td width="20%">Leave Days</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="finalleavebalance();" class="input_text" name="leave_days" id="leave_days" value="<?php if($_POST['save_changes']) echo $_POST['leave_days']; else echo $row_record['leave_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Extra Days</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="finalleavebalance();" class="input_text" name="extra_days" id="extra_days" value="<?php if($_POST['save_changes']) echo $_POST['extra_days']; else echo $row_record['extra_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Previous Balance Leaves</td>
                <td width="40%">
                    <input type="text" readonly onKeyUp="finalleavebalance();" class="input_text" name="previous_balance_leaves" id="previous_balance_leaves" value="<?php if($_POST['save_changes']) echo $_POST['previous_balance_leaves']; else echo $row_record['previous_balance_leaves'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Monthly Leaves</td>
                <td width="40%">
                    <input type="text" readonly class="input_text" name="monthly_leaves1" id="monthly_leaves1" value="<?php if($_POST['save_changes']) echo $_POST['monthly_leaves']; else echo $row_record['monthly_leaves'];?>" />
					<input type="hidden" class="input_text" name="monthly_leaves" id="monthly_leaves" value="<?php if($_POST['save_changes']) echo $_POST['monthly_leaves']; else echo $row_record['monthly_leaves'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Late Marks</td>
                <td width="40%">
                    <input type="text" readonly class="input_text" onKeyUp="finalleavebalance();" name="late_mark" id="late_mark" value="<?php if($record_id) echo $row_record['late_mark']; else echo '0'; ?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Description</td>
                <td width="40%">
                    <textarea rows="2" cols="42" name="description" id="description"><?php if($_POST['save_changes']) echo $_POST['description']; else echo $row_record['description'];?></textarea>
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%" style="font-size:14px;color:green;"><b>**** Total Working Days ****</b></p></td>
            </tr>
			<tr>
                <td width="20%">Total Working Days</td>
                <td width="40%">
                    <input type="text" readonly class="input_text" name="total_working_days" id="total_working_days" value="<?php if($_POST['save_changes']) echo $_POST['total_working_days']; else echo $row_record['total_working_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Final Leave Balance</td>
                <td width="40%">
                    <input type="text" readonly class="input_text" name="final_leave_balance" id="final_leave_balance" value="<?php if($_POST['save_changes']) echo $_POST['final_leave_balance']; else echo $row_record['final_leave_balance'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<tr>
                <td width="20%">Final Paid Days</td>
                <td width="40%">
                    <input type="text" readonly class="input_text" name="final_paid_days" id="final_paid_days" value="<?php if($_POST['save_changes']) echo $_POST['final_paid_days']; else echo $row_record['final_paid_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			<?php if(!mysql_num_rows($payment1))
            { ?>
                <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Record" name="save_changes" id="save_changes" /></td>
                <td></td>
                </tr>
				<?php 
			} ?>
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

<?php
if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
{
?>
    <script>
	branch_id =document.getElementById("branch_name").value;
	//alert(branch_id);
//	show_bank(branch_id);
	</script>
    <?php } ?>
    
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
	 //alert(days);
	 $('#number_of_days_in_month').val(days);
	 var year = $("#year").val();
	var month = $("#month").val();
	var staff_id = $("#staff_id").val();
	var ptype = 'staff_leave';
	 $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'check_exist.php',
            data: { year: year,month:month,staff_id:staff_id,ptype:ptype },
            
        }).done(function(responseData) {
		 //alert(responseData);
		if(responseData==1)
		{
			alert("Record All Ready Exist For This Selection");
			$("#save_changes").hide();
		}
		else
		{
			$("#save_changes").show();
		}
		
        }).fail(function() {
            console.log('Failed');
        });

 }
 
 function gettotaldays(staff) {
 
	//var atype = $("#atype").val();
	var year = $("#year").val();
	var month = $("#month").val();
	var staff = $("#staff_id").val();
	var working_days = $("#working_days").val();
	 if(year!='' && month!='' && staff!='')
	 {
	if(staff==''){
		alert("Please Select Staff");
		return false;
	}
	if(month==''){
		alert("Please Select Month");
		return false;
	}
	if(year==''){
		alert("Please Select Year");
		return false;
	}
	var branch_name = $("#branch_name").val();
	var type="leave";
        $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'get_attendance_day_ajax.php',
            data: { branch_name:branch_name,year: year,month:month,staff:staff,type:type },
            
        }).done(function(responseData) {
        //alert(responseData);
		var res = responseData.split(">>");
		if(res[0]<0)
		{
		$('#leave_days').val(0);	
		}
		else
		{
		$('#leave_days').val(precisionRound(res[0],2));
		}
		$('#present_days').val(precisionRound(res[1],2));

		$('#previous_balance_leaves').val(precisionRound(res[9],2));
		$('#monthly_leaves').val(precisionRound(res[10],2));
		$('#monthly_leaves1').val(precisionRound(res[10],2));
		$('#working_days').val(precisionRound(res[21],2));
		//alert(res[27]);
		$('#late_mark').val(precisionRound(res[27],2));
		$('#extra_days').val(precisionRound(res[28],2));
		//alert(res['1']);
		//sum_extra_days
        if(res[20]==0)
		{
			alert("Please Fill The Attendance");
			$('#present_days').val('');
			$('#leave_days').val('');
			$('#final_paid_days').val('');
			$('#monthly_leaves').val('');
			$('#monthly_leaves1').val('');
			$('#previous_balance_leaves').val('');
			$('#final_leave_balance').val('');
		}
		//alert(res[11]);
		if(res[11]==0)
		{
			alert("Please Fill Previous Leaves and Monthly Leave");
			$('#present_days').val('');
			$('#leave_days').val('');
			$('#final_paid_days').val('');
			$('#monthly_leaves').val('');
			$('#monthly_leaves1').val('');
			$('#previous_balance_leaves').val('');
			$('#final_leave_balance').val('');
		}
		if(res[21]==0)
		{
			alert("Please Fill Working days for Month And Year Selection");	
			$('#present_days').val('');
			$('#leave_days').val('');
			$('#final_paid_days').val('');
			$('#monthly_leaves').val('');
			$('#monthly_leaves1').val('');
			$('#previous_balance_leaves').val('');
			$('#final_leave_balance').val('');
		}
		
		
		
		finalleavebalance();
        }).fail(function() {
            console.log('Failed');
        });
	 
	 }
    }
	

 function finalleavebalance() {
 
	//var atype = $("#atype").val();
	var leave_days = $("#leave_days").val();
	var late_mark = $("#late_mark").val();
	var working_days = $("#working_days").val();
	
	if(late_mark=='')
	{
		 $('#late_mark').val(0);
	}
	var present_days = $("#present_days").val();
	var extra_days = $("#extra_days").val();
	var previous_balance_leaves = $("#previous_balance_leaves").val();
	var monthly_leaves = $("#monthly_leaves").val();
	var extra= $("#extra_leave_type").val();
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
	
	if(extra_days==0)
	{
		//$("#extra_leave_type").attr("disabled", "disabled");
		$('#extra_leave_type').prop('disabled', true).trigger("chosen:updated");
	}
	else
	{
  $('#extra_leave_type').prop('disabled', false).trigger("chosen:updated");
	}
	var tot_bal_leave=parseFloat(previous_balance_leaves)+parseFloat(monthly_leaves);
	var tot_leaves=parseFloat(leave_days)+parseFloat(late_mark);
	if(extra=="with salary") // with salary
	{
	 leave_balance=precisionRound((parseFloat(present_days)+parseFloat(tot_bal_leave))-(parseFloat(late_mark)),2);
	 
	  var temp=parseFloat(leave_balance)-parseFloat(working_days);
	/*  if(temp>0)
	 {
		var lb=parseFloat(leave_balance)-parseFloat(working_days);
        $('#final_leave_balance').val(lb);
	 }
	 else
	 {
		var lb=0;
        $('#final_leave_balance').val(lb); 
	 } */
	if(leave_balance>working_days)
	 {
		 var lv=tot_bal_leave;
		 //alert(lv);
		 var paid=parseFloat(working_days)+parseFloat(extra_days);
		  $('#final_paid_days').val(precisionRound(paid,2));
		   $('#final_leave_balance').val(tot_bal_leave);
	 }
	 else
	 {
		 var lv=leave_balance;
		  $('#final_paid_days').val(precisionRound(lv,2));
		    $('#final_leave_balance').val(0);
	 }
	 
	}
	else
	{
	 leave_balance=precisionRound((parseFloat(present_days)+parseFloat(tot_bal_leave))-(parseFloat(late_mark)),2);
	 var temp=parseFloat(leave_balance)-parseFloat(working_days);
	 if(temp>0)
	 {
		var lb=parseFloat(leave_balance)-parseFloat(working_days);
        $('#final_leave_balance').val(lb);
	 }
	 else
	 {
		var lb=0;
        $('#final_leave_balance').val(lb); 
	 }
	 if(leave_balance>working_days)
	 {
		 var lv=leave_balance-lb;
		  $('#final_paid_days').val(precisionRound(lv,2));
	 }
	 else
	 {
		 var lv=leave_balance;
		  $('#final_paid_days').val(precisionRound(lv,2));
	 }
	
	
	}
	$('#total_working_days').val(precisionRound(present_days,2));
	 }	 
 }
</script>
<script language="javascript">
<?php 
if($_SESSION['type']!="S" && $_SESSION['type']!='Z' && $_SESSION['type']!='LD')
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