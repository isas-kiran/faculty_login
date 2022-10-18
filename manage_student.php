<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
<meta content="utf-8" http-equiv="encoding"  />
<title>Manage Student</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
	
	<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript">
    $(document).ready(function()
	{  
		var currentDate = new Date();
		$('.datepicker').datepicker({ changeMonth: true, changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		//$('#inquiry_date').datepicker().datepicker('setDate', 'today');
	});
	</script>
    <script type="text/javascript">
		function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
            var hasChecked = false;
            for (var i = 0; i < chks.length; i++)
            {
                if (chks[i].checked)
                {
                    hasChecked = true;
                    break;
                }
            }
            if (hasChecked == false)
            {
                alert("Please select at least one record to do operation");
                $('#selAction').val('');
                return false;
            }

            document.getElementById('formAction').value=action;
            if(action=="delete")
            {
                if(confirm("Are you sure, you want to delete selected record(s)?"))
                    document.frmTakeAction.submit();
                else
                {
                    $('#selAction').val('');
                    return false;
                }
            }
			else if(action=="change_owner")
			{
				$( ".new_custom_course" ).dialog({
					width: '500',
					height:'150'
				});
			}
            else
                document.frmTakeAction.submit();
        }
        function redirect1(value,value1)
        {           
            //alert(value);
           // alert(value1);
            window.location.href=value+value1;
        }

        function validationToDelete(type)
        {
            if(confirm("Are you sure, you want to delete selected record(s)?"))
                return true;
            else
                return false;
        }
		
function select_branch(branch_name)
{
	var data1="action=manage_student&branch_id="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "show_councellor.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			sep=html.split("###");
			document.getElementById("enquiry_added").innerHTML=sep[0];
			document.getElementById("assigned_to").innerHTML=sep[1];
		}
	},
       error:function(exception){alert('Exception:'+exception);}
	});
	
	var data2="action=source_details&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "get_details.php", type: "post", data: data2, cache: false,
	success: function (vals)
	{
		if(vals !='')
		{
			document.getElementById("enquiry_src").innerHTML=vals;
		}
	},
       error:function(exception){alert('Exception:'+exception);}
	});
}

function select_councelor(branch_idsss)
{
	var data2="action=random_councilior&branch_id="+branch_idsss;	
	//alert(data2);
	$.ajax({
	url: "show_councellor.php", type: "post", data: data2, cache: false,
	success: function (valuess)
	{
		//alert(valuess);
		if(valuess !='')
		{
			document.getElementById("councillior_id").value=valuess;
		}
	},
       error:function(exception){alert('Exception:'+exception);}
	});
}

function select_state(country_id)
{
	var state_data="action=state_m&country_id="+country_id;
	$.ajax({
	url: "ajax_state_city.php",type:"post", data: state_data,cache: false,
	success: function(retstate)
	{
		//alert(retbank);
		document.getElementById("show_states").innerHTML=retstate;
		document.getElementById("city").innerHTML='';
		
		//$("#state").chosen({allow_single_deselect:true});
		//$("#city").chosen({allow_single_deselect:true});

	}
	});
}
function select_city(state_id)
{
	var city_data="action=city_m&state_id="+state_id;
	$.ajax({
	url: "ajax_state_city.php",type:"post", data: city_data,cache: false,
	success: function(retcity)
	{
		//alert(retbank);
		document.getElementById("show_cities").innerHTML=retcity;
		//$("#city").chosen({allow_single_deselect:true});
	}
	});
}
function select_area(city_id)
{
	//alert('hi');
	var state_id=document.getElementById("state").value;
	//alert(state_id);
	var area_data="action=area&city_id="+city_id+"&state_id="+state_id;
	$.ajax({
	url: "ajax_state_city.php",type:"post", data: area_data,cache: false,
	success: function(retcity)
	{
		//alert(retbank);
		document.getElementById("show_area").innerHTML=retcity;
		//$("#area").chosen({allow_single_deselect:true});
	}
	});
}
</script>
</head>
<body>
<?php include "include/header.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    				<?php if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                               	$del_record_id=$_POST['chkRecords'][$r];
                               	$sql_query= "SELECT inquiry_id FROM inquiry where inquiry_id ='".$del_record_id."'";
							   	$my_query=mysql_query($sql_query);
								if(mysql_num_rows($my_query))
								{                 
									$sql_query= "SELECT firstname, lastname FROM inquiry where inquiry_id ='".$del_record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
									
									$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_inquiry','Delete','".$fetch['firstname'].'-'.$fetch['lastname']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);    
									
									$delete_query1="delete from inquiry where inquiry_id='".$del_record_id."'";
									$db1=mysql_query($delete_query1); 
											
									$delete_query="delete from batch where batch_id='".$del_record_id."'";
									$dbs=mysql_query($delete_query);   
									                               
									$delete_query="delete from stud_regi where student_id='".$del_record_id."'";
									$db=mysql_query($delete_query);
									
									$delete_query1781="delete from ".$GLOBALS["pre_db"]."followup_details where student_id='".$del_record_id."'";
									$db4567=mysql_query($delete_query1781); 
                                 }
                             }
                             ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                            <script type="text/javascript">
                            // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    });
                                });
                                setTimeout('document.location.href="manage_student.php";',1000);
                            </script>
                            <?php                            
                     	}    
						else if($_POST['formAction']=="change_owner")
						{
							if($_POST['councillior_admin_id']!="")
                        	{
								$total_count=count($_POST['chkRecords']);
								for($r=0;$r<count($_POST['chkRecords']);$r++)
								{
									$sel_record_id=$_POST['chkRecords'][$r];
									$councillior_id=$_POST['councillior_admin_id'];
									
									$admin_id=$_SESSION['admin_id'];
									
									$selct_admin="select employee_id from inquiry where inquiry_id='".$sel_record_id."'";
									$ptr_admin_id=mysql_query($selct_admin);
									$data_admin=mysql_fetch_array($ptr_admin_id);
									
									if($_SESSION['type']!="S" && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' && $_SESSION['type']!="A" && $data_admin['employee_id']!=$admin_id)
									{
										$inq_query= "SELECT firstname,lastname FROM inquiry where inquiry_id ='".$sel_record_id."'";
										$my_inq_query=mysql_query($inq_query);
										$data_inq=mysql_fetch_array($my_inq_query);
										?>
                                        <div id="statusChangesDiv" title="Invalid Selection"><center><br><p>Error : You dont have permission to transfer <b><?php echo $data_inq['firstname']." ".$data_inq['lastname']; ?></b> Enquiry.</p><p>You are not Owner of this Enquiry</p></center></div>
                                        <?php
									}
									else
									{
										$sel_cm="select cm_id from site_setting where admin_id='".$councillior_id."'";
										$ptr_sel_cm=mysql_query($sel_cm);
										$data_center_m=mysql_fetch_array($ptr_sel_cm);
										
										$sql_query= "SELECT inquiry_id,admin_id,cm_id FROM inquiry where inquiry_id ='".$sel_record_id."'";
										$my_query=mysql_query($sql_query);
										if(mysql_num_rows($my_query))
										{
											$data_cm=mysql_fetch_array($my_query);             
											$update_query="update inquiry set employee_id='".$councillior_id."',cm_id='".$data_center_m['cm_id']."',transfer_from_cm_id='".$data_cm['cm_id']."',transfer_from_admin_id='".$data_cm['admin_id']."' where inquiry_id='".$sel_record_id."'";
											$query=mysql_query($update_query);    
										}
										?>
                                        <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) owner transfer successfully</p></center></div>
                                        <?php
									}
								 }
								 ?>
								
								<script type="text/javascript">
								// $("#statusChangesDiv").dialog();
									$(document).ready(function() {
										$( "#statusChangesDiv" ).dialog({
												modal: true,
												buttons: {
															Ok: function() { $( this ).dialog( "close" );}
														 }
										});
									});
									//setTimeout('document.location.href="manage_student.php";',2000);
								</script>
								<?php 
							}
							else
							{
								?>
                                <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Error : Councillor Not Selected</p></center></div>
                                <?php
							}
						}                   
                    }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_querys= "SELECT inquiry_id FROM inquiry where inquiry_id='".$del_record_id."'";
                        $my_querys=mysql_query($sql_querys);
						if(mysql_num_rows($my_querys))
						{     
							$sql_query= "SELECT firstname, lastname FROM inquiry where inquiry_id ='".$del_record_id."' ";              
							$query=mysql_query($sql_query);
							$fetch=mysql_fetch_array($query);
							
							$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_inquiry','Delete','".$fetch['firstname'].' '.$fetch['lastname']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);    
							
							$delete_query1="delete from inquiry where inquiry_id='".$del_record_id."'";
							$db1=mysql_query($delete_query1);
							
							$delete_query="delete from stud_regi where student_id='".$del_record_id."'";
							$db=mysql_query($delete_query);
							
							$delete_query11="delete from followup_details where student_id='".$del_record_id."'";
							$db2=mysql_query($delete_query11);

                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                            // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    });
                                });
								setTimeout('document.location.href="manage_student.php";',1000);
                            </script>
                            <?php
                        }
                    }
                    ?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="98%">
    
  <?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
	$sep_url_string="?".$sep_url[1];
}

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='37'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<form method="get" name="search">
<tr class="head_td">
	<td colspan="18">
        	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
            	<tr>
                	<!--<td class="width5"></td>-->
                    <?php
					//if($_SESSION['type']=='S' || $_SESSION['type']=='A')
					//{
						?>
						<td width="6%">
						<select name="selAction" id="selAction" style="width:150px" class="input_select_login" onChange="Javascript:submitAction(this.value);">
							<option value="">Operations</option>
                            <?php
							if($_SESSION['type']=='S' || $edit_access=='yes')
							{
								?>
								<option value="delete">Delete</option>
                            	<?php
							}
							if($_SESSION['type']=='A' || $_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' || $edit_access=='yes')
							{
								?>
								<option value="change_owner">Change Inquiry Owner</option>
								<?php
							}
							?>
						</select>
						</td>
						<?php
					//}
					?>
					<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
					{
						?>
						<td width="8%">
						<select name="branch_name" id="branch_name" class="input_select" onchange="select_branch(this.value)"><!--onchange="select_branch(this.value)" -->
							<option value="">Select Branch</option>
							<?php 
							$sel_branch="select branch_id,branch_name from branch";
							$ptr_sel=mysql_query($sel_branch);
							while($data_branch=mysql_fetch_array($ptr_sel))
							{
								$sel='';
								if($data_branch['branch_name']==$_GET['branch_name'])
								{
									$sel='selected="selected"';
								}
								echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
							}
							?>
						</select>
						</td>
						<?php
					}
					if($_SESSION['type']!='AG')
					{
					?>
                    <td width="8%" id="status_id">
                    <select name="status_type" class="input_select">
                    	<option value="">Select Enquiry Type</option>
                        <option value="all_campaign" <?php if($_REQUEST['status_type'] =='all_campaign') echo 'selected="selected"' ?>>Campaign Enquiries</option>
                        <option value="all_enquiries" <?php if($_REQUEST['status_type'] =='all_enquiries') echo 'selected="selected"' ?>>All Enquiries</option>
                        <option value="all_enrolled" <?php if($_REQUEST['status_type'] =='all_enrolled') echo 'selected="selected"' ?>>All Enrolled</option>
                        <option value="all_closed" <?php if($_REQUEST['status_type'] =='all_closed') echo 'selected="selected"' ?>>Closed Enquiries</option>
                    </select>
                    </td>
                    <td width="8%" >
                    <div id="added_by">
                    <select name="enquiry_added" id="enquiry_added" class="input_select">
                    	<option value="">Enquiry Created By</option>
                    	<?php
						$sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' and (type='C' or type='A' or type='Z' or type='LD') order by name asc"; 
						$ptr_name=mysql_query($sle_name);
						while($data_name=mysql_fetch_array($ptr_name))
						{
							$selected='';
							if($data_name['admin_id'] == $_GET['enquiry_added'])
							{
								$selected='selected="selected"';
							}
							echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
						}
						?>
                    </select>
                    </div>
                    </td>
					<td width="8%">
                    <div id="assigned_by">
                    <select name="assigned_to" id="assigned_to" class="input_select">
                    	<option value="">Enquiry Assigned To</option>
                        <?php
							$sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' and (type='C' or type='A' or type='Z' or type='LD') order by name asc"; 
							$ptr_name=mysql_query($sle_name);
							while($data_name=mysql_fetch_array($ptr_name))
							{
								$selected='';
								if($data_name['admin_id'] == $_GET['assigned_to'])
								{
									$selected='selected="selected"';
								}
								echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
							}
							?>
                    </select>
                    </div>
                    </td>
                    <td width="8%" >
						<select id="enquiry_src" name="enquiry_src" class="input_select">
							<option value="">Select Enquiry Source</option>
							<?php
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$whr_branch_name=" and branch_name='".$branch_name."'";
							}
							$course_category = "select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']." ".$whr_branch_name." ";
							$ptr_course_cat = mysql_query($course_category);
							while($data_cat = mysql_fetch_array($ptr_course_cat))
							{
								echo " <optgroup label='".$data_cat['branch_name']."'>";
								$sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' and status='Active' order by campaign_name asc";
								$ptr_src=mysql_query($sel_source);
								while($data_src=mysql_fetch_array($ptr_src))
								{
									$sele_source="";
									if($data_src['campaign_id'] == $_REQUEST['enquiry_src'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
									{
										$sele_source='selected="selected"';
									}
								?>
								<option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($enquiry_src) && $enquiry_src == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
											<?
								}
								echo " </optgroup>";
							}
							?>
						</select>
					</td>
                    <td width="8%"><select id="response" name="response" class="input_select">
                        <option value="">Select Response Type</option>
                        <?php
                        $sel_resp="select * from responce_category ";
                        $ptr_resp=mysql_query($sel_resp);
                        while($data_resp=mysql_fetch_array($ptr_resp))
                        {
                            ?>
                            <option value="<?php echo $data_resp['responce_id'];  ?>" <?php if($_GET['response'] == $data_resp['responce_id']) echo 'selected="selected"'; ?>><?php echo $data_resp['respnce_category_name'];  ?></option>	
                            <?php
                        }
                        ?>
                        </select>
                    </td>
                    <?php
					}
					?>
				</tr>
			</table>
	</td>
</tr>
<tr class="head_td">
	<td colspan="18">
        <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
           	<tr>
               	<!--<td class="width5"></td>-->
                <?php
				if($_SESSION['type']!='AG')
				{
					?>
					<td width="10%"><select id="lead_grade_by" name="lead_grade_by" class="input_select">
						<option value="">Select Lead Grade</option>
						<option value="very_hot" <?php if($_REQUEST['lead_grade_by']=="very_hot") echo 'selected="selected"'; ?>>Very Hot</option>
						<option value="hot" <?php if($_REQUEST['lead_grade_by']=="hot") echo 'selected="selected"'; ?>>Hot</option>
						<option value="warm" <?php if($_REQUEST['lead_grade_by']=="warm") echo 'selected="selected"'; ?>>Warm</option>
						<option value="Nutral" <?php if($_REQUEST['lead_grade_by']=="Nutral") echo 'selected="selected"'; ?>>Nutral</option>
						<option value="cold" <?php if($_REQUEST['lead_grade_by']=="cold") echo 'selected="selected"'; ?>>Cold</option>
						</select>
					</td>
					<td width="8%">
						<select id="date_by" name="date_by" class="input_select">
							<option value="">Select Date Type</option>
							<option value="inquiry_by" <?php if($_REQUEST['date_by']=="inquiry_by") echo 'selected="selected"'; ?>>Enquiry Created Date</option>
							<option value="followup_by" <?php if($_REQUEST['date_by']=="followup_by") echo 'selected="selected"'; ?>>Followup Date</option>
						</select>
                    </td>
                    <td width="10%">
						<select id="followup_by" name="followup_by" class="input_select">
							<option value="">Select Followups Type</option>
							<option value="followup_pending" <?php if($_REQUEST['followup_by']=="followup_pending") echo 'selected="selected"'; ?>>Untouched Followups</option>
							<option value="followup_completed" <?php if($_REQUEST['followup_by']=="followup_completed") echo 'selected="selected"'; ?>>Completed Followup</option>
						</select>
                    </td>
                    <td width="10%">
                        <select id="country" name="country" onchange="select_state(this.value)" class="input_select" >
                        <option value="">Select Country</option>
                        <?php 
                        $sel_countries="select * from countries where 1";
                        $ptr_countries=mysql_query($sel_countries);
                        while($data_countries=mysql_fetch_array($ptr_countries))
                        {
                            $sel_c='';
                            if($_GET['country']==$data_countries['id'])
                            {	
                                $sel_c='selected="selected"';
                            }
                            ?>
                            <option <?php echo $sel_c; ?> value="<?php echo $data_countries['id'];?>"> <?php echo $data_countries['name'];?> </option>
                            <?php						
                        }?>
                        </select>
                    </td>
                    <td width="10%" id="show_states">
                        <select id="state" name="state" onchange="select_city(this.value)" class="input_select">
                            <option value="">Select State</option>
                            <?php
                            if($_REQUEST['state']!='')
                            {
                                $countrys='';
                                if($_REQUEST['country'])
                                {
                                    $countrys_ids=$_REQUEST['country'];
                                    $countrys=" and country_id='".$countrys_ids."'";
                                }
                                
                                $sel_state="select * from states where 1 ".$countrys."";
                                $ptr_states=mysql_query($sel_state);
                                while($state_data= mysql_fetch_array($ptr_states))
                                {
                                    $sel='';
                                    if($_REQUEST['state']==$state_data['id'])
                                    {
                                        $sel='selected="selected"';
                                    }
                                    echo '<option value="'.$state_data['id'].'" '.$sel.'>'.$state_data['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td width="10%" id="show_cities">
                        <select id="city" name="city" class="input_select" onchange="select_area(this.value)">
                            <option value="">Select City</option>
                            <?php
                            if($_REQUEST['city']!='')
                            {
                                $country_id='';
                                if($_REQUEST['country'])
                                {
                                    $countrys=$_REQUEST['country'];
                                    $country_id=" and country_id='".$countrys."'";
                                }
                                $state_id='';
                                if($_REQUEST['state'])
                                {
                                    $stateid=$_REQUEST['state'];
                                    $state_id=" and state_id='".$stateid."'";
                                }
                                
                                $sel_city = "select * from cities where 1 ".$country_id." ".$state_id." ";
                                $ptr_city = mysql_query($sel_city);
                                while($city_data= mysql_fetch_array($ptr_city))
                                {
                                    $sel='';
                                    if($_REQUEST['city']==$city_data['id'])
                                    {
                                        $sel='selected="selected"';
                                    }
                                    echo '<option value="'.$city_data['id'].'" '.$sel.'>'.$city_data['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td width="10%" id="show_area">
                        <select id="area" name="area" class="input_select">
                            <option value="">Select Area</option>
                            <?php
                            if($_REQUEST['area']!='')
                            {
                                
                                $state_id='';
                                if($_REQUEST['state'])
                                {
                                    $stateid=$_REQUEST['state'];
                                    $state_id=" and state_id='".$stateid."'";
                                }
                                $city_id='';
                                if($_REQUEST['city'])
                                {
                                    $city=$_REQUEST['city'];
                                    $city_id=" and city_id='".$city."'";
                                }
                                $sel_area = "select * from city_area where 1 ".$state_id." ".$city_id." ";
                                $ptr_area = mysql_query($sel_area);
                                while($area_data= mysql_fetch_array($ptr_area))
                                {
                                    $sel='';
                                    if($_REQUEST['area']==$area_data['id'])
                                    {
                                        $sel='selected="selected"';
                                    }
                                    echo '<option value="'.$area_data['area_id'].'" '.$sel.'>'.$area_data['area_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    
					<?php
				}
				?>
			</tr>
        </table>
    </td>
</tr>
<tr class="head_td">
	<td colspan="18">
        <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
           	<tr>
               	<!--<td class="width5"></td>-->
                <?php
				if($_SESSION['type']!='AG')
				{
				?>
                
				<td width="8%"><input type="text" class="input_text datepicker" name="start_date" placeholder="From Date" id="dob" value="<?php if($_REQUEST['start_date']!="") echo $_REQUEST['start_date'];?>" /></td>
					<td width="8%"><input type="text" class="input_text datepicker" name="end_date" id="end_date" placeholder="To Date" value="<?php if($_REQUEST['end_date']!="") echo $_REQUEST['end_date'];?>"  /></td>
					<!--<td width="10%"><input type="submit" name="search" value="Search" class="input_Button"/></td>-->
				<td width="8%"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
               
                <td width="5%" align="left"><input type="submit" name="search" value="Search" title="Search" class="example-fade"  /></td>
                <?php if($_SESSION['type']=='S' || $_SESSION['type']=='A' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD') {?><td width="4%" align="center"> <a href="excel.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td><?php } 
				}
				?>
			</tr>
        </table>
    </td>
</tr>
</form>

<?php
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                        {          
							 	$cm_id_filter='';
								$sel_branch="select cm_id from site_setting where branch_name like '".$keyword."' "; 
								$ptr_branch=mysql_query($sel_branch);     
								if(mysql_num_rows($ptr_branch)) 
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$cm_id_filter="|| cm_id = '".$data_branch['cm_id']."'";
								} 
								$course_name_filter='';
								/*$sel_course_name="select course_id from courses where course_name like '%".$keyword."%' "; 
								$ptr_course_name=mysql_query($sel_course_name);    
								if(mysql_num_rows($ptr_course_name)) 
								{
									$data_course_name=mysql_fetch_array($ptr_course_name);
									$course_name_filter="|| course_id = '".$data_course_name['course_id']."'";
								}  */
								$select_installments="select course_id from courses where course_name like '%".$keyword."%' ";
								$ptr_installment = mysql_query($select_installments);
								if($total=mysql_num_rows($ptr_installment))
								{
									$xx='';
									$i=1;
									while($data_installment = mysql_fetch_array($ptr_installment))
									{
										$course_name_filter.= " || course_id =".$data_installment['course_id'];
										if($i !=$total)
										{
											//$xx.= '<br /><hr >';
										}
										$i++;
									}
								}
								
								$enquiry_added='';
								$sel_enq="select admin_id from site_setting where name like '%".$keyword."%'";
								$ptr_enq=mysql_query($sel_enq);
								if(mysql_num_rows($ptr_enq))
								{
									$data_enq=mysql_fetch_array($ptr_enq);
									$enquiry_added="|| admin_id = '".$data_enq['admin_id']."'";
								}
                                $pre_keyword =" and (firstname like '%".$keyword."%' || middlename like '%".$keyword."%' || lastname like '%".$keyword."%' || username like '%".$keyword."%' || mobile1 like '%".$keyword."%' || mobile2 like '%".$keyword."%' ".$course_name_filter." || address like '%".$keyword."%' || email_id like '%".$keyword."%')";
                            }                            
                       	else
                            $pre_keyword="";
							
                        $search_cm_id='';
						$branch_name='';
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$search_cm_id_s=" and s.cm_id='".$data_cm_id['cm_id']."'";
								
							}
							else
							{
								$search_cm_id='';
								$search_cm_id_s='';
							}
						}
						
						if($_REQUEST['date_by']=="followup_by")
						{
							if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
							{
								 $frm_date=explode("/",$_REQUEST['start_date']);
								 $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
								 
								$pre_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							}
							else
							{
								$pre_from_date="";                            
							}
							if($_REQUEST['end_date'] && $_REQUEST['end_date']!="0000-00-00" && $_REQUEST['end_date']!="To Date")
							{
								$to_date=explode("/",$_REQUEST['end_date']);
								$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
								 
								$pre_to_date=" and DATE(followup_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
							}
							else
								$pre_to_date="";
						}
						else
						{						
							if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
							{
								 $frm_date=explode("/",$_REQUEST['start_date']);
								 $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
								 
								$pre_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							}
							else
							{
								$pre_from_date="";                            
							}
							if($_REQUEST['end_date'] && $_REQUEST['end_date']!=="0000-00-00" && $_REQUEST['end_date']!="To Date")
							{
								$to_date=explode("/",$_REQUEST['end_date']);
								$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
								 
								$pre_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
							}
							else
								$pre_to_date="";
						}
							
						/*$start_date='';
						if($_REQUEST['start_date'])
						{
                            $start_date=$_REQUEST['start_date'];
							$start_date=" and added_date >='".$start_date."'";
						}
						$end_date='';
						if($_REQUEST['end_date'])
						{
                            $end_date=$_REQUEST['end_date'];
							$end_date=" and added_date <='".$end_date."'";
						}*/
						$lead_grade_by='';
						if($_REQUEST['lead_grade_by'])
						{
							$lead_grade_by=" and lead_grade='".$_REQUEST['lead_grade_by']."'";
						}
						$status_type='';
						if($_REQUEST['status_type'])
						{
							
                            $status_tp=$_REQUEST['status_type'];
							if($status_tp=='all_campaign')
							{
								$status_type=" and campaign_id!=''";
							}
							else if($status_tp=='all_enquiries')
							{
								$status_type=" and status = 'Enquiry'";
							}
							else if($status_tp=='all_enrolled')
							{
								$status_type=" and status = 'Enrolled'";
							}
							else if($status_tp=='all_closed')
							{
								$status_type=" and status = 'Cancelled'";
							}							
						}
						$enquiry_added='';
						if($_REQUEST['enquiry_added'])
						{
                            $enquiry_ad=$_REQUEST['enquiry_added'];
							$enquiry_added="and admin_id='".$enquiry_ad."'";
						}
						$assigned_to='';
						if($_REQUEST['assigned_to'])
						{
                            $assigned=$_REQUEST['assigned_to'];
							$assigned_to="and employee_id='".$assigned."'";
						}
						
						$enquiry_src='';
						if($_REQUEST['enquiry_src'])
						{
                            $enq_src=$_REQUEST['enquiry_src'];
							$enquiry_src=" and enquiry_source = '".$enq_src."'";
						}
							
						$response='';
						$resps='';
						if($_REQUEST['response'])
						{
                            $resp=$_REQUEST['response'];
							$response=" and response='".$resp."'";
						}
						else
						{
							$resps=" and (response !='7' and response!='8' or response is NULL) ";
						}
						$where_followup='';
						if($_REQUEST['followup_by'])
						{
                            $followup_by=$_REQUEST['followup_by'];
							if($followup_by=="followup_pending")
							{
								$where_followup=' and followup_date IS NULL';
							}
							else if($followup_by=="followup_completed")
							{
								$where_followup=' and followup_date IS NOT NULL';
							}
						}
						
						$country='';
						if($_REQUEST['country'])
						{
                            $country_id=$_REQUEST['country'];
							$country=" and country_id='".$country_id."'";
						}
						$state='';
						if($_REQUEST['state'])
						{
                            $state_id=$_REQUEST['state'];
							$state=" and state_id='".$state_id."'";
						}
						$city='';
						if($_REQUEST['city'])
						{
                            $city_id=$_REQUEST['city'];
							$city=" and city_id='".$city_id."'";
						}
						$area='';
						if($_REQUEST['area'])
						{
                            $area_id=$_REQUEST['area'];
							$area=" and area_id='".$area_id."'";
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

                        if($_GET['order'] !='' && ($_GET['orderby']=='name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							//===============================================================================================
							$branch_id='';
							/*if($_SESSION['type'] !='S')
							{
								$sel_cm_id_from_branch="select inquiry_id from inquiry where cm_id='".$_SESSION['cm_id']."'";
								$ptr_branch=mysql_query($sel_cm_id_from_branch);
								while($data_branch=mysql_fetch_array($ptr_branch))
								{
									$inquiry_id=$data_branch['inquiry_id'];
									$branch_id='and student_id='.$inquiry_id.'';
								}
								
							}*/
							//================================================================================================
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and inquiry_id='".$_GET['record_id']."' ";
						} 
						$c_id='';
						if($_GET['c_id'] !='')
						{
							$c_id="and campaign_id='".$_GET['c_id']."' ";
						} 
						$cm_ids=='';
						if($_SESSION['where'] !='')
						{
							$cm_ids="and cm_id='".$_SESSION['cm_id']."'";
						}
						
                        $select_directory='order by inquiry_id desc';    
						
						if($_SESSION['type']=='AG')
						{
							$sql_query="SELECT * FROM inquiry where 1 and admin_id='".$_SESSION['admin_id']."' ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$resps." ".$response." ".$lead_grade_by." ".$country." ".$state." ".$city." ".$area." ".$where_followup." ".$pre_from_date." ".$pre_to_date." ".$c_id." ".$select_directory."";
						}
						else
						{
							$sql_query="SELECT * FROM inquiry where 1 ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$resps." ".$response." ".$lead_grade_by." ".$country." ".$state." ".$city." ".$area." ".$where_followup." ".$pre_from_date." ".$pre_to_date." ".$c_id." ".$select_directory."";
						}
						//echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$branch_name.'&enquiry_added='.$enquiry_ad.'&assigned_to='.$_REQUEST['assigned_to'].'&enquiry_src='.$enq_src.'&response='.$response.'&start_date='.$_REQUEST['start_date'].'&end_date='.$_REQUEST['end_date'].'&status_type='.$_REQUEST['status_type'].'&followup_by='.$_REQUEST['followup_by'].'&date_by='.$_REQUEST['date_by'].'&lead_grade_by='.$_REQUEST['lead_grade_by'];
                            $query_string1=$query_string.$date_query;
							// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
                            <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                            <input type="hidden" name="formAction" id="formAction" value=""/>
                            <input type="hidden" name="councillior_admin_id" id="councillior_admin_id" value=""  />
                            <tr class="grey_td" >
                            <?php
							if($_SESSION['type']=='A' || $_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' || $edit_access=='yes')
							{
								?>
								<td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
								<?php
							}
							?>
                            <td width="3%" align="center"><strong>Sr. No.</strong></td>
                            
							<td width="10%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Name</strong></a><?php echo $img1;?></td>
								
                            <td width="9%" align="center"><strong>Course Name</strong></td>
                            <?php 
                            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                            { 
                                ?>
                                <td width="6%" align="center"><strong>Branch Name</strong></td>
                                <?php
                            }?>
                            <!--<td width="9%"><strong>Contact No  </strong></td>-->
                            <td width="10%" align="center"><strong>Added By</strong></td>
                            <td width="10%" align="center"><strong>Assigned To</strong></td>
                            <td width="8%" align="center"><strong>Source</strong></td>
                            <td width="8%" align="center"><strong>Respose Category</strong></td>
                            <td width="6%" align="center"><strong>Lead Grade</strong></td>
                            <td width="6%" align="center"><strong>Inquiry Date</strong></td>
                            <td width="5%" align="center"><strong>Status</strong></td>
                            <td width="8%" align="center"><strong>Description</strong></td>
                            <td width="5%" align="center"><strong>Followup Date</strong></td>
                            <td width="5%" align="center"><strong>Followup</strong></td>
                            <td width="5%" align="center"><strong>Enrollment</strong></td>
                            <?php 
                            //if($_SESSION['type']=='S' || $edit_access=='yes')
                           // { 
                                ?>
                            	<td width="6%" align="center"><strong>Action</strong></td> 
                                <?php
                           // }?>                        
                            </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
								/* $sel_inqury_id="select inquiry_id from inquiry where email_id='".$val_query['mail']."' and birth_date='".$val_query['dob']."' and address='".$val_query['address']."' and education='".$val_query['qualification']."'";
								$ptr_inquery_id=mysql_query($sel_inqury_id);
								$data_inquiry_id=mysql_fetch_array($ptr_inquery_id);
								 $inquiry_id=$data_inquiry_id['inquiry_id'];*/
								 
								/*"<br />".$sel_name_inq="select * from inquiry where inquiry_id='".$val_query['class_id']."'";
								$ptr_name_inq=mysql_query($sel_name_inq);
								$data_names_inq=mysql_fetch_array($ptr_name_inq);*/
								
								$sel_curse="select course_name from courses where course_id='".$val_query['course_id']."' ";
								$ptr_course=mysql_query($sel_curse);
								$data_course_name=mysql_fetch_array($ptr_course);
								
								"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_names=mysql_fetch_array($ptr_name);
								
								$asssign_name='';
								$sel_name_assign="select name from site_setting where admin_id='".$val_query['employee_id']."'";
								$ptr_name_assign=mysql_query($sel_name_assign);
								if(mysql_num_rows($ptr_name_assign))
								{
									$data_names_assign=mysql_fetch_array($ptr_name_assign);
									$asssign_name=$data_names_assign['name'];
								}
								
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['inquiry_id']; 
//                                $select_country = "select country_name from PB_country where country_id = '".$val_query['country_id']."' ";
//                                $val_contry = $db->fetch_array($db->query($select_country));
                                include "include/paging_script.php";
								
								$lead_grade='';
								$bgcolr='';
								$color='';
								$style='';
								if($val_query['lead_grade']=="very_hot")
								{
									$lead_grade="Very Hot";
									$bgcolr="#810100";
									$color="#fff";
									$style='bgcolor="#810100" style="color:#fff"';
								}
								else if($val_query['lead_grade']=="hot")
								{
									$lead_grade="Hot";
									$bgcolr="#C41206";
									$color="#fff";
									$style='bgcolor="#C41206" style="color:#fff"';
								}
								else if($val_query['lead_grade']=="warm")
								{
									$lead_grade="Warm";
									$bgcolr="#F58F09";
									$color="#000";
									$style='bgcolor="#F58F09" style="color:#000"';
								}
								else if($val_query['lead_grade']=="Nutral")
								{
									$lead_grade="Neutral";
									$bgcolr="#F4F805";
									$color="#000";
									$style='bgcolor="#F4F805" style="color:#000"';
								}
								else if($val_query['lead_grade']=="cold")
								{
									$lead_grade="Cold";
									$bgcolr="#377A07";
									$color="#000";
									$style='bgcolor="#377A07" style="color:#000"';
								}
                                
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='A' || $_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' || $edit_access=='yes')
								{
                                	echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
								
								$sel_country="select name from countries where id='".$val_query['country_id']."'";
								$ptr_country=mysql_query($sel_country);
								$data_country=mysql_fetch_array($ptr_country);
								
								$sel_states="select name from states where id='".$val_query['state_id']."'";
								$ptr_states=mysql_query($sel_states);
								$data_states=mysql_fetch_array($ptr_states);
								
								$sel_city="select name from cities where id='".$val_query['city_id']."'";
								$ptr_city=mysql_query($sel_city);
								$data_city=mysql_fetch_array($ptr_city);
								
								$sel_area="select area_name from city_area where area_id='".$val_query['area_id']."'";
								$ptr_area=mysql_query($sel_area);
								$data_area=mysql_fetch_array($ptr_area);
								
                                echo '<td align="center">'.$sr_no.'</td>';	
                                echo '<td align="left">';
								if($val_query['status']=='Enrolled')
								{
									echo $val_query['firstname']." ".$val_query['middlename']." ".$val_query['lastname'];
									if($val_query['mobile1'])
										echo'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['mobile1'];
									if($val_query['mobile2'])
										echo'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['mobile2'];
									if($val_query['email_id'])
										echo '<br /> <img src="images/mail.png">'.$val_query['email_id'];
									if($val_query['address'])
										echo '<br /> <img src="images/address.png" height="18" width="18">'.$val_query['address'];
									if($val_query['country_id'])
										echo '<br /> <strong>Country - </strong>'.$data_country['name'];
									if($val_query['state_id'])
										echo '<br /> <strong>State - </strong>'.$data_states['name'];
									if($val_query['city_id'])
										echo '<br /> <strong>City - </strong> '.$data_city['name'];
									if($val_query['area_id'])
										echo '<br /> <strong>Area - </strong>'.$data_area['area_name'];
								}
								else
								{
									echo '<a href="add_student_gst.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['firstname']." ".$val_query['middlename']." ".$val_query['lastname'];
									if($val_query['mobile1'])
										echo '<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['mobile1'];
									if($val_query['mobile2'])
										echo'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['mobile2'];
									if($val_query['email_id'])
										echo '<br /> <img src="images/mail.png">'.$val_query['email_id'];
									if($val_query['address'])
										echo '<br /> <img src="images/address.png" height="18" width="18">'.$val_query['address'];
									echo '</a>';
								}
								echo'</td>';
								echo '<td align="center">'.$data_course_name['course_name'].'</td>';
								  if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								  {
									  $sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
									  $ptr_branch=mysql_query($sel_branch);
									  $data_branch=mysql_fetch_array($ptr_branch);
									   echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								  }
                               	/* echo '<td align="center">'.$val_query['contact'].'</td>';*/
								/*echo '<td align="center">'.$val_query['mail'].'</td>';*/
								
								echo '<td align="center">'.$data_names['name'].'</td>';
								echo '<td align="center">'.$asssign_name.'';
								if($val_query['transfer_from_admin_id']!='' && $val_query['transfer_from_cm_id']!='')
								{
									$sel_transf_name="select name,branch_name from site_setting where admin_id='".$val_query['transfer_from_admin_id']."' and cm_id='".$val_query['transfer_from_cm_id']."'";
									$ptr_transf_name=mysql_query($sel_transf_name);
									$data_transf_name=mysql_fetch_array($ptr_transf_name);
									echo '<br/><span style="color:red">Transfer from '.$data_transf_name['name'].' &nbsp;&nbsp;('.$data_transf_name['branch_name'].')</span>';
								}
								echo '</td>';
								
								//==================Change source tableto campaign table on 24-4-18====================
								$enq_source=$val_query['campaign_id'];
								$enq_src="select campaign_name from campaign where campaign_id='".$val_query['enquiry_source']."'";
								$ptr_enq_src=mysql_query($enq_src);
								if(mysql_num_rows($ptr_enq_src))
								{
									$data_enq_src=mysql_fetch_array($ptr_enq_src);
									$enq_source=$data_enq_src['campaign_name'];
								}
								echo '<td align="center">'.$enq_source.'</td>';
								$response='';
								if($val_query['response'] == "1")
								{
									$response="Walk in";
								}
								else if($val_query['response'] == "2")
								{
									$response="Will walk in";
								}
								else if($val_query['response'] == "3")
								{
									$response="Call Back Later";
								}
								else if($val_query['response'] == "4")
								{
									$response="Call did not pick up";
								}
								else if($val_query['response'] == "5")
								{
									$response="Not reachable";
								}
								else if($val_query['response'] == "6")
								{
									$response="Call Taken";
								}
								else if($val_query['response'] == "7")
								{
									$response="Not Intrested";
								}
								else if($val_query['response'] == "8")
								{
									$response="Invalid";
								}
								else 
									$response=$val_query['response'];
								
								$sep_date=explode(" ",$val_query['added_date']);
								$inquiry_date=$sep_date[0];
								echo '<td align="center">'.$response.'</td>';
								echo '<td align="center" '.$style.' >'.$lead_grade.'</td>';
								echo '<td align="center">'.$inquiry_date.'</td>';
								//----------------------------------------------------------------------------
								if($val_query['status']=='Enrolled')
								{
									echo '<td style="color:#00CC00" align="center">'.$val_query['status'].'</td>';
								}
								else
									echo '<td style="color:#FF0000" align="center">'.$val_query['status'].'</td>';
								//------------------------------------------------------------------------------
								echo '<td style="" align="center">'.$val_query['followup_details'].'</td>';
								//------------------------------------------------------------------------------
								$sep_folldate=explode(" ",$val_query['followup_date']);
								$follow_date=$sep_folldate[0];
								echo '<td align="center">'.$follow_date.'</td>';
								//-------------------------------------------------------------------------------
								/*if($val_query['status']=='Enrolled')
								{
									echo '<td style="color:#FF0000" align="center"><img title="Followup Completed" src="images/enroll_cmpleted.png" height="30" width="30"></td>';
								}
								else*/
								echo '<td style="color:#FF0000" align="center"><a href="followup_details.php?record_id='.$val_query['inquiry_id'].'" target="_blank" ><img title="Followup" src="images/followup.png" height="30" width="30"></a></td>';
								//------------------------------------------------------------------------------
								if($val_query['status']=='Enrolled')
								{
									echo '<td style="color:#FF0000" align="center"><img src="images/enroll_cmpleted.png" title="Enrollment Completed" height="30" width="30"></td>';
								}
								else
								{
									/*if($val_query['cm_id']=='60')
										echo '<td style="color:#FF0000" align="center"><a href="add_student_enroll.php?record_id='.$listed_record_id.'" ><img src="images/enrolls.png" title="Enrollment" height="30" width="30"></a></td>';else */
									echo '<td style="color:#FF0000" align="center"><a href="add_student_gst.php?record_id='.$listed_record_id.'" ><img src="images/enrolls.png" title="Enrollment" height="30" width="30"></a></td>';
								}
									
								//--------------------------------------------------------------------------------
								
								if($_SESSION['type']=='S' || $edit_access=='yes' || ( ($val_query['campaign_id']!='' || $val_query['campaign_type']!='') && $val_query['followup_date']==''))
								{
									echo '<td align="center">';
									if($val_query['status']!='Enrolled')
										echo'<a href="inquiry.php?record_id='.$val_query['inquiry_id'].'"><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
									if($_SESSION['type']=='S' || $edit_access=='yes')
                                    {
										echo ' <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									}
                                	echo '</td>';
								}
								else
								{
									echo '<td align="center"></td>';
								}
								
                                echo '</tr>';
                                $bgColorCounter++;
                            }  
							?>
	<tr class="grey_td" >
    	<td width="6%" colspan="3" align="center"><strong>Total Records</strong></td>
    	<td width="10%" colspan="14" align="left"><strong><?php echo $no_of_records;?></strong></td> 
	</tr>
  	<tr class="head_td">
		<td colspan="17">
       		<table cellspacing="0" cellpadding="0" width="100%" >
        		<tr>
                <?php
                if($no_of_records>10)
				{
					echo '<td width="3%" align="left">Show</td>
					<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
					$show_records=array(0=>'10',1=>'20','50','100','200');
					for($s=0;$s<count($show_records);$s++)
					{
						if($_SESSION['show_records']==$show_records[$s])
							echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
						else
							echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
					}
					echo'</td></select>';
				}
				echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';
                ?>                                   
            </tr>
        </table>
    </td>
    </tr></form>
<?php   
} 
else
	echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Student found related to your search criteria, please try again</div><br></td></tr>';?>
</table>
	</td>
    <td>
		<script type="text/javascript">
                $(function()    
                {
    	            $(".custom_cuorse_submit").click(function(){
                    var councillior_id = $("#councillior_id").val();
                               
                    if(councillior_id == "" || councillior_id == undefined)
                    {
        	            alert("Select Councillor name.");
                        return false;
                    }
					else
					{
						//alert(councillior_id);
						$("#councillior_admin_id").val(councillior_id);
						$('.new_custom_course').dialog( 'close');
						setTimeout(document.frmTakeAction.submit(),3000)
					}
                    /*if(mobile1 == "" || mobile1 == undefined)
                    {
            	        alert("Enter Mobile no.");
                        return false;
                    }
                    if(email == "" || email == undefined)
                    {
                	    alert("Eneter Email ID.");
                        return false;
                    }*/
                    /*var data1 = 'action=custome_councillior_submit&councillior_id='+councillior_id
                    $.ajax({
                    	url: "ajax.php", type: "post", data: data1, cache: false,
                        success: function (html)
                        {
                        	if(html.trim() =='mobile')
                            {
                            	alert("Mobile no. or Email already Exist");
                                return false;
                            }
                            else if(html.trim() =='cust_id')
                            {
                            	alert("Customer Name already Exist");
                                return false;
                            }
                            else if (html.trim() =='blank')
                            {
                            	alert("Please enter Mobile number");
                                return false;
                            }
                            else
                            {
                            	$(".customized_select_box").html(html);
                               
                                $('.new_custom_course').dialog( 'close');
                                $("#customer_id").chosen({allow_single_deselect:true});
                               
                            }
                        }
                        });*/
                    });
             });
            </script>
            <div class="new_custom_course" style="display: none;">
                <form method="post" id="jqueryForm" name="discount" enctype="multipart/form-data">
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">
                        <tr>
                            <td colspan="3" class="orange_font">* Mandatory Fields</td>
                        </tr>
                        <?php
						if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{
							?>
							<tr>
								<td width="20%">Select Councillior<span class="orange_font">*</span></td>
								<td width="40%">
								<select name="councillior_id" id="councillior_id">
								<option value="">Select Name</option>
								<?php
								$sle_name="select admin_id,name,branch_name from site_setting where 1 and system_status='Enabled' and (type='C' or type='A' or type='Z' or type='LD') order by name asc"; 
								$ptr_name=mysql_query($sle_name);
								while($data_name=mysql_fetch_array($ptr_name))
								{
									echo '<option value="'.$data_name['admin_id'].'">'.$data_name['name'].' ('.$data_name['branch_name'].')</option>';
								}
								?>
								</select>
								</td>
							</tr>
							<?php
						}
						else
						{
							?>
                            <tr>
								<td width="20%">Select Branch<span class="orange_font">*</span></td>
								<td width="40%">
								<select name="br_ids" id="br_ids" onchange="select_councelor(this.value)">
								<option value="">Select Branch</option>
								<?php
								$sle_name="select branch_name from branch where 1 and status='Active' order by branch_name asc"; 
								$ptr_name=mysql_query($sle_name);
								while($data_name=mysql_fetch_array($ptr_name))
								{
									echo '<option value="'.$data_name['branch_name'].'">'.$data_name['branch_name'].'</option>';
								}
								?>
								</select>
                                <input type="hidden" name="councillior_id" id="councillior_id" value=""  />
								</td>
							</tr>
							<?php
						}
						?>
                        <tr>
                            <td></td>
                            <td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit"/>&nbsp;
                                <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
    </td>
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
<?php
/*if($_GET['branch_name']!='')
{
	?><script>select_branch('<?php echo $_GET['branch_name'];?>')</script><?php
*/
?>
</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>