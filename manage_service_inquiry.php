<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Services Inquiry</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='177'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
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
    </script>
    
    <script>
	function service_status(values,ids)
	{
		var data1="status="+values+"&customer_id="+ids;	
		//alert(data1);
			$.ajax({
				url: "get_status.php", type: "post", data: data1, cache: false,
				success: function (html)
				{
					if(html=="success")
					{
						alert("Status changed successfully");
					}
				}
				});
		
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
	
	var data2="action=source_details&type=service&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "get_details.php", type: "post", data: data2, cache: false,
	success: function (vals)
	{
		if(vals !='')
		{
			document.getElementById("source_by").innerHTML=vals;
		}
	},
       error:function(exception){alert('Exception:'+exception);}
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
<?php       
if($_POST['formAction'])
{
	if($_POST['formAction']=="delete")
	{
		for($r=0;$r<count($_POST['chkRecords']);$r++)
		{
			$del_record_id=$_POST['chkRecords'][$r];
			$sql_query= "SELECT inquiry_id,name FROM service_inquiry where inquiry_id ='".$del_record_id."'";
			$ptr_query=mysql_query($sql_query);
			if(mysql_num_rows($ptr_query))
			{    
				$cust_data=mysql_fetch_array($ptr_query);
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_service_inquiry','Delete','".$cust_data['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);
															
				$delete_query="delete from service_inquiry where inquiry_id='".$del_record_id."'";
				$db->query($delete_query);  
				
				$delete_query="delete from service_followup_details where inquiry_id='".$del_record_id."'";
				$db->query($delete_query);  

				$delete_query1="delete from service_inquiry_map where inquiry_id='".$del_record_id."'";
				$db->query($delete_query1);                                                                                        
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
										Ok: function() { $( this ).dialog( "close" ); }
									 }
							});
						});
						setTimeout('document.location.href="manage_service_inquiry.php";',1000);
				</script>
				
		<?php                            
			}
 }
if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
{
	$del_record_id=$_REQUEST['record_id'];
	$sql_query= "SELECT inquiry_id,name FROM service_inquiry where inquiry_id ='".$del_record_id."'";
	$ptr_query=mysql_query($sql_query);
	if(mysql_num_rows($ptr_query))
	{                            
		$cust_data=mysql_fetch_array($ptr_query);
		
		"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('service_inquiry','Delete','".$cust_data['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
		$query=mysql_query($insert); 
		
		$delete_query="delete from service_inquiry where inquiry_id='".$del_record_id."'";
		$db->query($delete_query);  
		
		$delete_query="delete from service_followup_details where inquiry_id='".$del_record_id."'";
		$db->query($delete_query);  

		$delete_query1="delete from service_inquiry_map where inquiry_id='".$del_record_id."'";
		$db->query($delete_query1);      
		?>
		<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
		<script type="text/javascript">
		   // $("#statusChangesDiv").dialog();
			$(document).ready(function() {
				$( "#statusChangesDiv" ).dialog({
					modal: true,
					buttons: {
								Ok: function() { $( this ).dialog( "close" ); }
							 }
					});
				});
				 setTimeout('document.location.href="manage_service_inquiry.php";',1000);
		</script>
		<?php
	}
}
?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>    
<!--<tr class="head_td">
    <td colspan="16">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>

                </select></td>
				<?php //if($_SESSION['type']=='S')
				///{
				?>
                 <td width="15%">
                    <select name="branch_name" id="branch_name" class="input_select_login"  style="width: 150px; ">
                                <option value="">-Branch Name-</option>
                                <?php 
									/*$sel_branch="select branch_id,branch_name from branch";
									$ptr_sel=mysql_query($sel_branch);
									while($data_branch=mysql_fetch_array($ptr_sel))
									{
										$sel='';
										if($_REQUEST['branch_name'] == $data_branch['branch_name'])
										{
											$sel='selected="selected"';
										}
										echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
									}*/
								?>
                        </select>
                </td>
				<td> <a href="service_followup_summery.php<?php //echo $sep_url_string; ?>"><strong>Followup Summery</strong></a></td>
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <? //} ?>
				 <td width="15%"><input type="text" class="input_text datepicker" name="start_date" placeholder="From" id="dob" value="<?php //if($_REQUEST['start_date']!="") echo $_REQUEST['start_date'];?>" /></td>
					<td width="15%"><input type="text" class="input_text datepicker" name="end_date" id="end_date" placeholder="To" value="<?php //if($_REQUEST['end_date']!="") echo $_REQUEST['end_date'];?>"  /></td>
                <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
				<tr>
				
				<td class="width5"></td>
               
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                <td width="4%" align="center"> <a href="service_excel.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
              </tr>
                    </table>	
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>-->
<form method="get" name="search">
<tr class="head_td">
	<td colspan="18">
        	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
            	<tr>
                	<!--<td class="width5"></td>-->
                    <?php
					if($_SESSION['type']=='S' || $edit_access=='yes' )
					{
						?>
						<td width="6%">
						<select name="selAction" id="selAction" style="width:150px" class="input_select_login" onChange="Javascript:submitAction(this.value);">
							<option value="">Operations</option>
							<option value="delete">Delete</option>
							<!--<option value="change_owner">Change Inquiry Owner</option>-->
						</select>
						</td>
						<?php
					}
					?>
					<?php if($_SESSION['type']=='S'|| $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
						$sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' and (type='C' or type='A') order by name asc"; 
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
							$sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' and (type='C' or type='A') order by name asc"; 
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
                    <div id="source_by">
					<select id="enquiry_src" name="enquiry_src" class="input_select">
						<option value="">Select Enquiry Source</option>
						<?php 
                        $course_category = "select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
                        $ptr_course_cat = mysql_query($course_category);
                        while($data_cat = mysql_fetch_array($ptr_course_cat))
                        {
                        	echo " <optgroup label='".$data_cat['branch_name']."'>";
                            $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='service' order by campaign_name asc";
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
					<?php 
                    $course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
                    $ptr_course_cat = mysql_query($course_category);
                    while($data_cat = mysql_fetch_array($ptr_course_cat))
                    {
                    	echo " <optgroup label='".$data_cat['branch_name']."'>";
                    	$sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='service' order by campaign_name asc";
                        $ptr_src=mysql_query($sel_source);
                        while($data_src=mysql_fetch_array($ptr_src))
                        {
                    	    $sele_source="";
                            if($data_src['campaign_id'] == $_REQUEST['enquiry_src'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
                            {
                        	    $sele_source='selected="selected"';
                            }
                            ?>
                            <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($_REQUEST['enquiry_src']) && $_REQUEST['enquiry_src'] == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
                            <?php
                        }
                        echo " </optgroup>";
                    }?>
					</select>
                    </div>
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
				</tr>
			</table>
	</td>
</tr>
<tr class="head_td">
	<td colspan="18">
        <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
           	<tr>
               	<!--<td class="width5"></td>-->
                <td width="8%"><select id="lead_grade_by" name="lead_grade_by" class="input_select">
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
                <td width="8%">
                    <select id="followup_by" name="followup_by" class="input_select">
                    	<option value="">Select Followups Type</option>
                        <option value="followup_pending" <?php if($_REQUEST['followup_by']=="followup_pending") echo 'selected="selected"'; ?>>Untouched Followups</option>
                        <option value="followup_completed" <?php if($_REQUEST['followup_by']=="followup_completed") echo 'selected="selected"'; ?>>Completed Followup</option>
                    </select>
                </td>
				<td width="8%"><input type="text" class="input_text datepicker" name="start_date" placeholder="From Date" id="dob" value="<?php if($_REQUEST['start_date']!="") echo $_REQUEST['start_date'];?>" /></td>
					<td width="8%"><input type="text" class="input_text datepicker" name="end_date" id="end_date" placeholder="To Date" value="<?php if($_REQUEST['end_date']!="") echo $_REQUEST['end_date'];?>"  /></td>
					<!--<td width="10%"><input type="submit" name="search" value="Search" class="input_Button"/></td>-->
				<td width="8%"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
               
                <td width="5%" align="left"><input type="submit" name="search" value="Search" title="Search" class="example-fade"  /></td>
                <td width="4%" align="center"> <a href="excel.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
			</tr>
        </table>
    </td>
</tr>
</form>    
    
<?php
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
						else
							$keyword='';
                        if($keyword)
						{
                            $pre_keyword=" and (name like '%".$keyword."%' || mobile like '%".$keyword."%' || service_price like '%".$keyword."%' || status like '%".$keyword."%')";
							$pre_keyword_i="and (service_price like '%".$keyword."%' or total_cost like '%".$keyword."%' or name like '%".$keyword."%' or mobile like '%".$keyword."%' or status like '%".$keyword."%')";
						}
						else
                            $pre_keyword="";

                        if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
                        
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;
						$exist=0;
						if($_REQUEST['branch_name'])
						{
							$exist +=1;
							$sel_branch="select cm_id from site_setting where branch_name='".$_REQUEST['branch_name']."' and type='A'";
							$ptr_branch=mysql_query($sel_branch);
							$data_branch=mysql_fetch_array($ptr_branch);
							$cm_id=$data_branch['cm_id'];
							
							$branch_keyword=" and cm_id ='".$cm_id."'";
							$branch_keyword_p=" and cm_id ='".$cm_id."'";
						}
						else {
							$branch_keyword="";
							$branch_keyword_p="";
						}
						
						if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
						{
							$exist +=1;
							$frm_date=explode("/",$_REQUEST['start_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							 
							$pre_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$pre_from_date_i=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date="";     
							$pre_from_date_i="";                            
						}
						if($_REQUEST['end_date'] && $_REQUEST['end_date']!=="0000-00-00" && $_REQUEST['end_date']!="To Date")
						{
							$exist +=1;
							$to_date=explode("/",$_REQUEST['end_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							 
							$pre_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";			
							$pre_to_date_i=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
						}
						else
						{
							$pre_to_date="";
							$pre_to_date_i="";
						}
						
						
						if($_REQUEST['date_by']=="followup_by")
						{
							$exist +=1;
							if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
							{
								 $frm_date=explode("/",$_REQUEST['start_date']);
								 $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
								 
								$pre_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
								$pre_from_date_i=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							}
							else
							{
								$pre_from_date="";
								$pre_from_date_i="";                            
							}
							if($_REQUEST['end_date'] && $_REQUEST['end_date']!=="0000-00-00" && $_REQUEST['end_date']!="To Date")
							{
								$to_date=explode("/",$_REQUEST['end_date']);
								$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
								 
								$pre_to_date=" and DATE(followup_date) <='".date('Y-m-d',strtotime($to_dates))."'";	
								$pre_to_date_i=" and DATE(followup_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
							}
							else
							{
								$pre_to_date="";
								$pre_to_date_i="";
							}
						}
						else
						{	
							$exist +=1;					
							if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
							{
								$frm_date=explode("/",$_REQUEST['start_date']);
								$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
								$pre_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
								$pre_from_date_i=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							}
							else
							{
								$pre_from_date="";
								$pre_from_date_i="";                            
							}
							if($_REQUEST['end_date'] && $_REQUEST['end_date']!=="0000-00-00" && $_REQUEST['end_date']!="To Date")
							{
								$to_date=explode("/",$_REQUEST['end_date']);
								$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
								$pre_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";
								$pre_to_date_i=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
							}
							else
							{
								$pre_to_date="";
								$pre_to_date_i="";
							}
						}
							
						
						$lead_grade_by='';
						$lead_grade_by_i='';
						if($_REQUEST['lead_grade_by'])
						{
							$lead_grade_by=" and lead_grade='".$_REQUEST['lead_grade_by']."'";
							$lead_grade_by_i=" and lead_grade='".$_REQUEST['lead_grade_by']."'";
						}
						$status_type='';
						$status_type_i='';
						if($_REQUEST['status_type'])
						{
							
                            $status_tp=$_REQUEST['status_type'];
							if($status_tp=='all_campaign')
							{
								$status_type=" and campaign_id!=''";
								$status_type_i=" and campaign_id!=''";
							}
							else if($status_tp=='all_enquiries')
							{
								$status_type=" and status = 'Enquiry'";
								$status_type_i=" and status = 'Enquiry'";
							}
							else if($status_tp=='all_enrolled')
							{
								$status_type=" and status = 'Enrolled'";
								$status_type_i=" and status = 'Enrolled'";
							}
							else if($status_tp=='all_closed')
							{
								$status_type=" and status = 'Cancelled'";
								$status_type_i=" and status = 'Cancelled'";
							}							
						}
						$enquiry_added='';
						$enquiry_added_i='';
						if($_REQUEST['enquiry_added'])
						{
                            $enquiry_ad=$_REQUEST['enquiry_added'];
							$enquiry_added="and admin_id='".$enquiry_ad."'";
							$enquiry_added_i="and admin_id='".$enquiry_ad."'";
						}
						$assigned_to='';
						$assigned_to_i='';
						if($_REQUEST['assigned_to'])
						{
                            $assigned=$_REQUEST['assigned_to'];
							$assigned_to="and staff_id='".$assigned."'";
							$assigned_to_i="and staff_id='".$assigned."'";
						}
						
						$enquiry_src='';
						$enquiry_src_i='';
						if($_REQUEST['enquiry_src'])
						{
                            $enq_src=$_REQUEST['enquiry_src'];
							$enquiry_src=" and enquiry_src = '".$enq_src."'";
							$enquiry_src_i=" and enquiry_src = '".$enq_src."'";
						}
							
						$response='';
						$resps='';
						$resps_i='';
						$response_i='';
						if($_REQUEST['response'])
						{
                            $resp=$_REQUEST['response'];
							$response=" and response='".$resp."'";
							$response_i=" and response='".$resp."'";
						}
						else
						{
							$resps=" and (response !='7' and response!='8' or response is NULL) ";
							$resps_i=" and (response !='7' and response!='8' or response is NULL) ";
						}
						$where_followup='';
						$where_followup_i='';
						if($_REQUEST['followup_by'])
						{
                            $followup_by=$_REQUEST['followup_by'];
							if($followup_by=="followup_pending")
							{
								$where_followup=' and followup_date IS NULL';
								$where_followup_i=' and followup_date IS NULL';
							}
							else if($followup_by=="followup_completed")
							{
								$where_followup=' and followup_date IS NOT NULL';
								$where_followup_i=' and followup_date IS NOT NULL';
							}
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
							//$branch_id='';
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
							$c_id_i="and campaign_id='".$_GET['c_id']."' ";
						} 
						$cm_ids=='';
						if($_SESSION['where'] !='')
						{
							$cm_ids="and cm_id='".$_SESSION['cm_id']."'";
						}
						
						$select_directory='order by inquiry_id desc';  
							
						$record_cat_id='';
						$record_cat_idss='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and inquiry_id='".$_GET['record_id']."' ";
							$record_cat_idss="and inquiry_id='".$_GET['record_id']."' ";
							
						}	
						$cmids="";
						if($_SESSION['where']!='')
						{
							$cmids=" and cm_id='".$_SESSION['cm_id']."'";
						}
						
						/*if($pre_keyword=='')
						{                     
							$sql_query= "SELECT * FROM service_inquiry where 1 ".$record_cat_id." ".$_SESSION['where']." ".$pre_from_date." ".$pre_to_date." ".$branch_keyword." ".$status_type." ".$record_cat_id." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$resps." ".$response." ".$lead_grade_by." ".$where_followup." ".$pre_from_date." ".$pre_to_date." ".$c_id." ".$pre_keyword." ".$select_directory.""; 
						}
						else
						{*/
						//$sql_query= "SELECT distinct(i.inquiry_id) as inquiry_id FROM service_inquiry i, servies s, service_inquiry_map sim where 1 and i.inquiry_id=sim.inquiry_id  and sim.service_id=s.service_id ".$cm_ids." ".$branch_keyword_p." ".$pre_from_date_i." ".$pre_to_date_i." ".$record_cat_idss." ".$status_type_i." ".$enquiry_added_i." ".$assigned_to_i." ".$enquiry_src_i." ".$resps_i." ".$response_i." ".$lead_grade_by_i." ".$where_followup_i." ".$c_id_i." ".$pre_keyword_i." order by i.inquiry_id desc "; 
						
						$sql_query= "SELECT * FROM service_inquiry where 1 ".$cm_ids." ".$branch_keyword_p." ".$pre_from_date_i." ".$pre_to_date_i." ".$record_cat_idss." ".$status_type_i." ".$enquiry_added_i." ".$assigned_to_i." ".$enquiry_src_i." ".$resps_i." ".$response_i." ".$lead_grade_by_i." ".$where_followup_i." ".$c_id_i."  ".$pre_keyword_i." ".$search_cm_id."  ".$select_directory.""; 
						
						//}
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&enquiry_added='.$_REQUEST['enquiry_added'].'&assigned_to='.$_REQUEST['assigned_to'].'&enquiry_src='.$_REQUEST['enquiry_src'].'&response='.$_REQUEST['response'].'&start_date='.$_REQUEST['start_date'].'&end_date='.$_REQUEST['end_date'].'&status_type='.$_REQUEST['status_type'].'&followup_by='.$_REQUEST['followup_by'].'&date_by='.$_REQUEST['date_by'].'&lead_grade_by='.$_REQUEST['lead_grade_by'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
					  <?php
					  if($_SESSION['type']=="S" || $edit_access=='yes')
					  {
					  ?>
                        <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
						<?php
					  } ?>
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
						<?php
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
						{?>
							<td width="6%" align="center"><strong>Branch</strong></td>
						<?php
						}
						?>
                        <td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=service_name".$query_string;?>" class="table_font"><strong>Customer Name</strong></a> <?php echo $img1;?></td>
                        <td width="25%" align="center"><strong>Services</strong></td>
                        <td width="8%" align="center"><strong>Total Cost</strong></td>
                        <td width="12%" align="center"><strong>Added By</strong></td>
						<td width="12%" align="center"><strong>Assigned To</strong></td>
						<td width="10%" align="center"><strong>Source</strong></td>
						<td width="10%" align="center"><strong>Respose Category</strong></td>
                        <td width="10%" align="center"><strong>Status</strong></td>
						<td width="7%" align="center"><strong>Followup</strong></td>
						<td width="8%" align="center"><strong>Booking</strong></td>
                        <td width="10%" align="center"><strong>Added Date</strong></td>
                        <td width="10%" class="centerAlign"><strong>Action</strong></td>
                    </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['inquiry_id']; 
                                $position=120; // Define how many character you want to display.                                
                                $post = substr(strip_tags($val_query['remark']), 0, $position);
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=="S" || $edit_access=='yes' )
								{
                                      echo '<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';  
								
								//$sql_query= "SELECT * FROM service_inquiry where inquiry_id='".$listed_record_id."'"; 
								//$ptr_query=mysql_query($sql_query);
								//$val_query=mysql_fetch_array($ptr_query);
								
								if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
								{
									$sql_branch = "select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
									$ptr_branch = mysql_query($sql_branch);
									$data_branch = mysql_fetch_array($ptr_branch);
									echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								}
								echo '<td ><a href="service_inquiry.php?record_id='.$listed_record_id.'">'.$val_query['name'].'<br>'.$val_query['mobile'].'</a></td>';
								
								echo '<td align="center">';
								$sel_cust_services="select inquiry_id,service_id from service_inquiry_map where inquiry_id ='".$val_query['inquiry_id']."'";
								$ptr_sel_service=mysql_query($sel_cust_services);
								while($data_service=mysql_fetch_array($ptr_sel_service))
								{
									$select_service_name="select service_name,service_price from servies where service_id='".$data_service['service_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									echo $data_service_name['service_name']."(Price - ".$data_service_name['service_price'].")<br />";
								}
								echo '</td>';
                                echo '<td align="center">'.round($val_query['total_cost']).'</td>';
								
								"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_names=mysql_fetch_array($ptr_name);
								
								"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['staff_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_assign_by=mysql_fetch_array($ptr_name);
								
								echo '<td align="center">'.$data_names['name'].'</td>';
								echo '<td align="center">'.$data_assign_by['name'].'</td>';
								
								/*$enq_src="select source_name from source where source_id='".$val_query['enquiry_src']."'";
								$ptr_enq_src=mysql_query($enq_src);
								$data_enq_src=mysql_fetch_array($ptr_enq_src);
								
								echo '<td align="center">'.$data_enq_src['source_name'].'</td>';*/
								$enq_source=$val_query['campaign_id'];
								"<br/>". $enq_src="select campaign_name from campaign where campaign_id='".$val_query['enquiry_src']."'";
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
								echo '<td align="center">'.$response.'</td>';
								echo '<td align="center">'.$val_query['status'].'</td>';
								if($val_query['status']=='Booked')
								{
									echo '<td style="color:#FF0000" align="center"><img title="Followup Completed" src="images/enroll_cmpleted.png" height="30" width="30"></td>';
								}
								else
								echo '<td style="color:#FF0000" align="center"><a href="service_followup_details.php?record_id='.$listed_record_id.'" ><img title="Followup" src="images/followup.png" height="30" width="30"></a></td>';
								
								if($val_query['status']=='Booked')
								{
									echo '<td style="color:#FF0000" align="center"><img src="images/enroll_cmpleted.png" title="Service Booked" height="30" width="30"></td>';
								}
								else
									echo '<td style="color:#FF0000" align="center"><a href="enq_book_service.php?record_id='.$listed_record_id.'" ><img src="images/enrolls.png" title="Service Booked" height="30" width="30"></a></td>';
								echo '<td align="center">'.$val_query['added_date'].'</td>';
                                echo '<td align="center">';
								if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  || trim($val_query['status']) !="Completed")
								{
									echo '<a href="service_inquiry.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>';
								}
								if($_SESSION['type']=="S" || $edit_access=='yes'  )
								{
									 echo'<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								}
                                echo '</td>';
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="15">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                      if($no_of_records>10)
                            {
                                echo '<td width="3%" align="left">Show</td>
                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                $show_records=array(0=>'10',1=>'20','50','100');
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
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Page found related to your search criteria, please try again</div><br></td></tr>';?>
</table>

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
