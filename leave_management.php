<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_leave_management where leave_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='211'";
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
 Leave Management</title>
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
			$("#salary_type").chosen({allow_single_deselect:true});
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
	 if(frm.no_of_days.value=='U')
		 {
			 disp_error +='Select No. of days\n';
			 document.getElementById(no_of_days).style.border = '1px solid #f00';
			 frm.no_of_days.focus();
			 error='yes';
		 }
	   if(frm.no_of_working_days_in_month.value=='')
		 {
			 disp_error +='Enter No. of working days \n';
			 document.getElementById('no_of_working_days_in_month').style.border = '1px solid #f00';
			 frm.no_of_working_days_in_month.focus();
			 error='yes';
	     }

		 if(frm.no_of_holidays.value=='')
		 {
			 disp_error +='Enter No. of Holidays. \n';
			 document.getElementById('no_of_holidays').style.border = '1px solid #f00';
			 frm.no_of_holidays.focus();
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
						
						$no_of_days=( ($_POST['no_of_days'])) ? $_POST['no_of_days'] : "";
						
						$no_of_working_days=( ($_POST['no_of_working_days_in_month'])) ? $_POST['no_of_working_days_in_month'] : "";
						
						$no_of_holidays=( ($_POST['no_of_holidays'])) ? $_POST['no_of_holidays'] : "0";
				         $branch_name=$_REQUEST['branch_name'];
				
                        if($month =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Month";
                        }
						  if($no_of_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter No. of days";
                        }
						
						if($no_of_working_days =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter No. of working days";
                        }
						if($no_of_holidays =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter No. of holidays";
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
							$data_record['no_of_days']=$no_of_days;
                            $data_record['no_of_working_days'] =$no_of_working_days;
                            $data_record['no_of_holidays'] =$no_of_holidays;
							$data_record['added_date'] =date("Y-m-d H:i:s");
							$data_record['admin_id'] =$_SESSION['admin_id'];
                           // $branch_name=$_REQUEST['branch_name'];
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{
								$sel_branch="select cm_id,branch_name from site_setting where branch_name='".$branch_name."' and type='A'";
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
							
							
						 if($file_uploaded)
							$data_record['photo'] = $uploaded_url;
                            if($record_id)
                            {
								
                                $where_record="leave_id='".$record_id."'";                                
                                $db->query_update("pr_leave_management", $data_record,$where_record); 
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('leave_mgmt','Update','leaves','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                           else{
                                            $record_comission=$db->query_insert("pr_leave_management", $data_record);
											$slab_id=mysql_insert_id(); 
											"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('leave_mgmt','Add','leaves','".$slab_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  
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
						<?php
						
						?> 
								</td>
								
								<td>
						<?php
						
						echo 'Select Month</td><td>';
						$monthArray = range(1, 12);
						$currentMonth =date('Y').'-'.date('m').'-01';
                        $prv_month=Date('F', strtotime('-1 month',strtotime($currentMonth)));
						 $prv_month1=Date('m', strtotime('-1 month',strtotime($currentMonth)));
						echo ' <select required id="month" name="month" onChange="getmonthdays(this.value);check_exist();">';
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
 
              		<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
					{
						?>
					  <tr>
						<td>Select Branch</td>
						<td>

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
						echo ' <select id="branch_name" name="branch_name" onchange="check_exist();">';
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
				<?php }  else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?>
				
				
				<tr>
			<td width="20%">Salary Type</td>
            <td width="40%">
			<select id="salary_type" name="salary_type" onChange="getmonthdays();">
			<option value="">Select Salary Type</option>
			<option <?php if($row_record['salary_type']=='cal wise') echo "selected"; else echo "" ?> value="cal wise">Calender Wise</option>
			<option <?php if($row_record['salary_type']=='working day wise') echo "selected"; else  echo ""  ?> value="working day wise">Working Days Wise</option>
			</select>
			</td>
			</tr>
               
                <tr>
                <td width="20%">Number Of Days <span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="no_of_days" id="no_of_days" value="<?php if($_POST['save_changes']) echo $_POST['no_of_days']; else echo $row_record['no_of_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
             
            <tr>
                <td width="20%">Number Of Working Days (in month)<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onkeyup="getmonthdays();" class="validate[required] input_text" name="no_of_working_days_in_month" id="no_of_working_days_in_month" value="<?php if($_POST['save_changes']) echo $_POST['no_of_working_days']; else echo $row_record['no_of_working_days'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            
            
            <tr>
                <td width="20%">Number Of HoliDays</td>
                <td width="40%">
                    <input type="text" onkeyup="getmonthdays();" class="input_text" name="no_of_holidays" id="no_of_holidays" value="<?php if($_POST['save_changes']) echo $_POST['no_of_holidays']; else echo $row_record['no_of_holidays'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            


			
            <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Leaves" name="save_changes"  id="save_changes"/></td>
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

function getmonthdays(i)
{
	
	var year= $("#year").val();
	var hd=0;
	var i = $("#month").val();
	var salary_type = $("#salary_type").val();
	var month=i-1;
	
     var days= 32 - new Date(year, month, 32).getDate();
	 $('#no_of_days').val(days);
	 var year = $("#year").val();
	var month = $("#month").val();
	//alert(salary_type);
	if(salary_type.trim()=='cal wise')
	{
		var wd= $("#no_of_working_days_in_month").val(days);
		$("#no_of_holidays").val(0);
	}
	else
	{
		var nwd= $("#no_of_days").val();
		var wd1= $("#no_of_working_days_in_month").val();
			if(wd1>nwd)
	{
		alert('Working days Not Greater Than Days In Month');
		$("#no_of_working_days_in_month").val('');
	}
		var hd=nwd-wd1;
		
    if(hd<0)
	{
		$("#no_of_holidays").val(0);
	}
	else {
     $("#no_of_holidays").val(hd);
	}
	}
	
	


 }
 
 function check_exist()
 {
	 var year= $("#year").val();
	var month = $("#month").val();
	 var branch_name = $("#branch_name").val();
	 var ptype = 'leave_mgmt';
	 $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'check_exist.php',
            data: { year: year,month:month,branch_name:branch_name,ptype:ptype },
            
        }).done(function(responseData) {
		 //alert(responseData);
		if(responseData==1)
		{
			alert("Record All Ready Exist For This Selection");
			$("#no_of_working_days_in_month").attr("disabled", "disabled");
			$("#no_of_holidays").attr("disabled", "disabled");
			$("#save_changes").hide();
		}
		else{
			$("#no_of_working_days_in_month").removeAttr("disabled");
			$("#no_of_holidays").removeAttr("disabled");
			$("#save_changes").show();
		}
		
        }).fail(function() {
            console.log('Failed');
        });
 }
</script>
<script language="javascript">
//create_floor('add');
</script>
<script language="javascript">
<?php 
if($_SESSION['type']!="S" && $_SESSION['type']!='Z' && $_SESSION['type']!='LD')
{
?>
branch_name=document.getElementById['branch_name'].value;
get_staff(branch_name);
<?php
}
?>
</script>
</body>
</html>
<?php $db->close();?>