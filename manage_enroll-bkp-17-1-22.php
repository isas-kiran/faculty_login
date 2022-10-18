<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Enroll Student</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
	<link rel="stylesheet" href="js/chosen.css" />
    <script type="text/javascript" src="../js/common.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
 	<script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	var  pageName = "add_expense";
    $(document).ready(function()
	{
		$("#country").chosen({allow_single_deselect:true});
		$("#state").chosen({allow_single_deselect:true});
		$("#city").chosen({allow_single_deselect:true});
		$("#area").chosen({allow_single_deselect:true});
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd/mm/yy'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
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
		/*else
			document.frmTakeAction.submit();*/
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
			
			$("#state").chosen({allow_single_deselect:true});
			$("#city").chosen({allow_single_deselect:true});
	
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
			$("#city").chosen({allow_single_deselect:true});
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
			$("#area").chosen({allow_single_deselect:true});
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
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='39'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  	<tr>
    	<td class="top_left"></td>
    	<td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
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
				$sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."enrollment where enroll_id ='".$del_record_id."'";
				$my_query=mysql_query($sql_query);
				
				if(mysql_num_rows($my_query))
				{       
					$data_delete=mysql_fetch_array($my_query);         
					 
					"<br>".$sql_query= "SELECT name FROM enrollment where enroll_id ='".$del_record_id."' ";              
					$query=mysql_query($sql_query);
					$fetch=mysql_fetch_array($query);
					
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_enrollment','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);    
													
					$delete_query="delete from ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
					$db->query($delete_query);      
					
					$delete_query_invoice="delete from ".$GLOBALS["pre_db"]."invoice where enroll_id='".$del_record_id."'";
					$db->query($delete_query_invoice);
					
					$delete_query_inst="delete from ".$GLOBALS["pre_db"]."installment where enroll_id='".$del_record_id."'";
					$db->query($delete_query_inst);    
					
					$delete_query_inst_his="delete from ".$GLOBALS["pre_db"]."installment_history where enroll_id='".$del_record_id."'";
					$db->query($delete_query_inst_his);  
					
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
						
						$sel_cm="select cm_id from site_setting where admin_id='".$councillior_id."'";
						$ptr_sel_cm=mysql_query($sel_cm);
						$data_center_m=mysql_fetch_array($ptr_sel_cm);
						
						$sql_query= "SELECT enroll_id,cm_id,admin_id FROM enrollment where enroll_id ='".$sel_record_id."' or ref_id='".$sel_record_id."'";
						$my_query=mysql_query($sql_query);
						if(mysql_num_rows($my_query))
						{
							while($data_cm=mysql_fetch_array($my_query))
							{       
								$update_query="update enrollment set admin_id='".$councillior_id."',assigned_to='".$councillior_id."',cm_id='".$data_center_m['cm_id']."',transfer_from_cm_id='".$data_cm['cm_id']."',transfer_from_admin_id='".$data_cm['admin_id']."' where enroll_id='".$data_cm['enroll_id']."'";
								$query=mysql_query($update_query);
								
								$update_inv="update invoice set assigned_to='".$councillior_id."', admin_id='".$councillior_id."',cm_id='".$data_center_m['cm_id']."' where enroll_id='".$data_cm['enroll_id']."'";
								$ptr_inv=mysql_query($update_inv);
								
								$update_inst="update installment set cm_id='".$data_center_m['cm_id']."' where enroll_id='".$data_cm['enroll_id']."'";
								$ptr_inst=mysql_query($update_inst);
								
								$update_inst_history="update installment_history set cm_id='".$data_center_m['cm_id']."' where enroll_id='".$data_cm['enroll_id']."'";
								$ptr_insth=mysql_query($update_inst_history);
							}
						}
					}
					?>
					<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) owner transfer successfully</p></center></div>
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
			$sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
			if(mysql_num_rows($db->query($sql_query)))
			{            
			
				"<br>".$sql_query= "SELECT name FROM enrollment where enroll_id ='".$del_record_id."' ";              
				$query=mysql_query($sql_query);
				$fetch=mysql_fetch_array($query);
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_enrollment','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert); 
						   
				$delete_query="delete from ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
				$db->query($delete_query);
				
				$delete_query_invoice="delete from ".$GLOBALS["pre_db"]."invoice where enroll_id='".$del_record_id."'";
				$db->query($delete_query_invoice);
				
				$delete_query_inst="delete from ".$GLOBALS["pre_db"]."installment where enroll_id='".$del_record_id."'";
				$db->query($delete_query_inst);    
				
				$delete_query_inst_his="delete from ".$GLOBALS["pre_db"]."installment_history where enroll_id='".$del_record_id."'";
				$db->query($delete_query_inst_his);  
				
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
				</script>
				<?php
			}
		}
		?>
	<tr>
		<td class="mid_left"></td>
    	<td class="mid_mid" align="center">    
			<table cellspacing="0" cellpadding="0" class="table" width="97%">
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>

	<tr>
    	<td colspan="15">
        <form method="get" name="search">
        <table width="100%">
        <tr class="head_td">
    	<td colspan="16">
			<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
            <tr>
                <td class="width5"></td>
                <?php
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
				{
					?>
                    <td width="20%">
                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <?php
						if($_SESSION['type']=='S' || $edit_access=='yes')
						{
							?>
							<option value="delete">Delete</option>
							<?php
						}
						?>
                        <option value="change_owner">Transfer admission to another branch</option>
                    </select>
                    </td>
                	<?php
				}
				?>
                <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
				{
					?>
				 	<td width="15%">
					<select name="branch_name" id="branch_name" class="input_select_login" style="width: 150px; ">
						<option value="">-Branch Name-</option>
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
				<td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                <td><input type="submit" name="search" value="Search" title="Search" class="example-fade" /></td>
                
                <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD') {?><td> <a href="excel_enroll.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td><?php }?>
				<!--<td> <a href="installment_followup_summery.php<?php echo $sep_url_string; ?>"><strong>Installment Followup</strong></a></td>-->		
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              			<tr>
              				<td></td>
              				<td class="width5"></td>
                            <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                            <td class="width2"></td>
                            
                            <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                    	</tr>
                    </table>	
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
                <td width="8%">
                	<select id="country" name="country" onchange="select_state(this.value)" style="width:200px">
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
                <td width="15%" id="show_states">
                	<select id="state" name="state" onchange="select_city(this.value)" style="width:200px">
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
                <td width="15%" id="show_cities">
                	<select id="city" name="city" style="width:200px" onchange="select_area(this.value)">
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
                <td width="15%" id="show_area">
                    <select id="area" name="area" style="width:200px">
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
				<td width="35%" align="left"><input type="submit" name="search" value="Search" title="Search" class="example-fade"  /></td>
            </tr>
        </table>
    </td>
</tr>
</table>
</form>	
</td>
</tr>

    <?php
	
						$from_date="";
						$to_date="";
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_dates=explode("/",$_REQUEST['to_date']);
							$to_date=$to_dates[2]."-".$to_dates[1]."-".$to_dates[0];
							
							$to_date=" and added_date<='".date('Y-m-d',strtotime($to_date))."'";
						}
						if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['start_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						if($_REQUEST['end_date']  && $_REQUEST['end_date']!="To Date")
						{
							$to_dates=explode("/",$_REQUEST['end_date']);
							$to_date=$to_dates[2]."-".$to_dates[1]."-".$to_dates[0];
							
							$to_date=" and added_date<='".date('Y-m-d',strtotime($to_date))."'";
						}
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
								$select_installments = " select course_id from courses where course_name like '%".$keyword."%' ";
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
								
                                $pre_keyword =" and (name like '%".$keyword."%' || contact like '%".$keyword."%' || mail like '%".$keyword."%' || username like '%".$keyword."%' || qualification like '%".$keyword."%' || address like '%".$keyword."%' ".$cm_id_filter." ".$course_name_filter.")";
                            }                            
                        else
                            $pre_keyword="";
                        
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
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id='';
							}
						}
						$enquiry_src='';
						if($_REQUEST['enquiry_src'])
						{
                            $enq_src=$_REQUEST['enquiry_src'];
							$enquiry_src=" and source = '".$enq_src."'";
						}
						$assigned_to='';
						if($_REQUEST['assigned_to'])
						{
                            $assigned=$_REQUEST['assigned_to'];
							$assigned_to="and assigned_to='".$assigned."' and assigned_to!=''";
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
                            $select_directory='order by enroll_id desc';    
							
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and enroll_id='".$_GET['record_id']."' ";
							
						}
						$source_id='';
						if($_REQUEST['c_id'] !='')
						{
							$source_id=" and source='".$_REQUEST['c_id']."'";
						}   
						if($_SESSION['type']=='AG')
						{             
                       		$sql_query= "SELECT * FROM enrollment where 1 and inquiry_added_by='".$_SESSION['admin_id']."' ".$record_cat_id." and ref_id='0' ".$_SESSION['where']." ".$enquiry_src." ".$assigned_to." ".$from_date." ".$to_date." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$pre_keyword." ".$source_id." ".$select_directory.""; 
						}
						else
						{
							$sql_query= "SELECT * FROM enrollment where 1 ".$record_cat_id." and ref_id='0' ".$_SESSION['where']." ".$enquiry_src." ".$assigned_to." ".$from_date." ".$to_date." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$pre_keyword." ".$source_id." ".$select_directory.""; 
						}
						//echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name']."&from_date=".$_REQUEST['from_date']."&to_date=".$_REQUEST['to_date'];
                            $query_string1=$query_string.$date_query;
                            //$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    						<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                            <input type="hidden" name="formAction" id="formAction" value=""/>
                            <input type="hidden" name="councillior_admin_id" id="councillior_admin_id" value=""  />
                          	<tr class="grey_td" >
								<?php
                                if($_SESSION['type'] =='S' || $_SESSION['type']=='Z' || $edit_access=='yes')
                                {	
                                    ?>
                                    <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                                    <?php
                                }
                                ?>
                                <td width="4%" align="center"><strong>Sr. No.</strong></td>
                                <td width="12%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Name</strong></a> <?php echo $img1;?></td>
                                <?
                                if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
                                { 
                                    ?>
                                    <td width="7%" align="center"><strong>Branch Name</strong></td>
                                    <?php
                                }?>
                                <td width="5%" align="center"><strong>Login </strong></td>
                                <!--<td width="6%" align="center"><strong>Total courses</strong></td>-->
                                <td width="13%" align="center"><strong>Course Name</strong></td>
                                <td width="7%" align="center"><strong>Down Fee</strong></td>
                                <td width="7%" align="center"><strong>Balance Fee</strong></td>
                                <td width="7%" align="center"><strong>Assign to</strong></td>
                                <!--<td width="16%" align="center"><strong>Installments</strong></td>-->
                                <!-- <td width="15%" align="center"><strong>Kit</strong></td>-->
                                <?php
                                if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')//|| $_SESSION['name']=="isasfinance"
                                { 
                                    ?>
                                    <!--<td width="6%" align="center"><strong>View Logsheet</strong></td>-->
                                    <? 
                                }?>
                                <!--<td width="6%" align="center"><strong>View Payment</strong></td>-->
                                <td width="5%" align="center"><strong>Date</strong></td>
                                <?php
                                if($_SESSION['type']=='S' || $edit_access=='yes')//|| $_SESSION['name']=="isasfinance"
                                {	
                                    ?>
                                    <td width="8%" align="center" class="centerAlign"><strong>Action</strong></td>
                                    <?php 
                                }?>
                          	</tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
									$listed_invoce_id=$val_query['invoice_no'];               
                                $listed_record_id=$val_query['enroll_id']; 
                               
							   	include "include/paging_script.php";
								if($_SESSION['type'] =='S' || $_SESSION['type']=='Z' || $edit_access=='yes')
								{	
                                	echo '<tr '.$bgcolor.' >
                                    <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>'; 
                                //if($_SESSION['type'] =='A' || $_SESSION['type'] =='S')
								//{		
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
								echo '<td ><a href="manage_enroll_student.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['name'].'<br /><img src="images/mobile-phone-8-16.ico">'.$val_query['contact'].' <br /> <img src="images/mobile_home.png" width="18" height="18">'.$val_query['contact_home'].' <br /> <img src="images/mail.png">'.$val_query['mail'].' <br/> <strong>Country</strong> - '.$data_country['name'].'<br/><strong>State</strong> - '.$data_states['name'].' <br/><strong>City</strong> - '.$data_city['name'].' <br /> <strong>Area - </strong>'.$data_area['area_name'].'</a></td>';
								/*}
								else {
									echo '<td >'.$val_query['name'].'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['contact'].' <br /> <img src="images/mail.png">'.$val_query['mail'].'</td>';
								}*/	
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
								{
								  	$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
								  	$ptr_branch=mysql_query($sel_branch);
								  	$data_branch=mysql_fetch_array($ptr_branch);
								  	echo '<td >'.$data_branch['branch_name'].'</td>';
								}
								echo '<td ><img src="images/username.png" title="username">'.$val_query['username'].'<br /><img src="images/key.png" title="password">'.$val_query['pass'].'</td>';
								/*if( $_SESSION['type'] =='S' )
								{
									if($val_query['ref_id'] ==0)
									{
										echo '<td><center><a href="add_new_course_gst.php?record_id='.$listed_record_id.'">
										<img src="images/course.png" border="0" width="30px" height="30px" title="Add New Course"></a></center></td>';
									}
									else
									{
										echo '<td><center><img src="images/fireeagle_location.png" border="0" width="30px" height="30px" title="New Course added"></center></td>';
									}
								}
								else
								{
									if($val_query['ref_id'] ==0)
									{
										echo '<td><center><img src="images/course.png" border="0" width="30px" height="30px" title="Add New Course"></center></td>';
									}
									else
									{
										echo '<td><center><img src="images/fireeagle_location.png" border="0" width="30px" height="30px" title="New Course added"></center></td>';
									}
								}*/
								/*echo '<td><center><a href="action.php?record_id='.$listed_record_id.'">
								<img src="images/action.jpg" border="0" width="30px" height="30px" title="View Payment"></a></center></td>';*/
								$sel_total_course="select enroll_id,course_id,down_payment,discount,net_fees from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ref=mysql_query($sel_total_course);
								$totals_courses=mysql_num_rows($ptr_ref);
								$totals_cntt=mysql_num_rows($ptr_ref);
								
								/*echo '<td align="center">'.$totals_cntt.'</td>';*/
								
                                echo '<td ><b>';
								while($data_total=mysql_fetch_array($ptr_ref))
								{
									$select_course = "select * from courses where course_id = '".$data_total['course_id']."'  ";
									$val_course= $db->fetch_array($db->query($select_course));
									
									echo '<b>'.$val_course['course_name'].'</b><br><img src="images/indian-rupee-16.ico">'.$data_total['net_fees'].'/-(With Tax)';
									if($totals_courses = $totals_courses-1 )
									echo '<hr />';
								}
								echo '</td>';
								$disco ='';
								if(trim($val_query[discount]) !='0')
								$disco= '<br /> Discount: '.$val_query[discount];
								echo '<td>';
								$sel_total_courses="select down_payment,discount,balance_amt from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								
								$ptr_refs=mysql_query($sel_total_courses);
								$total_fees=mysql_num_rows($ptr_refs);
								while($data_fees=mysql_fetch_array($ptr_refs))
								{
									echo ''.$data_fees['down_payment'].'<br>Discount- '.$data_fees['discount'];
									if($total_fees = $total_fees-1 )
									echo '<hr />';
								}
								echo '</td>';
								//echo '<td >'.$val_query['down_payment'].$disco.'</td>';
								echo '<td >';
								$sel_bal_amnt="select down_payment,discount,balance_amt from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								
								$ptr_bal_amnt=mysql_query($sel_bal_amnt);
								$total_fees=mysql_num_rows($ptr_bal_amnt);
								while($data_bal_amnt=mysql_fetch_array($ptr_bal_amnt))
								{
									echo $data_bal_amnt['balance_amt'];
									if($total_fees = $total_fees-1 )
									echo '<hr />';
								}
								echo'</td>';
								
								echo '<td >';
								$sel_assign="select assigned_to,transfer_from_admin_id,transfer_from_cm_id from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_assign=mysql_query($sel_assign);
								$total_assign=mysql_num_rows($ptr_assign);
								while($data_assign=mysql_fetch_array($ptr_assign))
								{
									$transf_data='';
									if($data_assign['transfer_from_admin_id']!='' && $data_assign['transfer_from_cm_id']!='')
									{
										$sel_transf_name="select name,branch_name from site_setting where admin_id='".$data_assign['transfer_from_admin_id']."' and cm_id='".$data_assign['transfer_from_cm_id']."'";
										$ptr_transf_name=mysql_query($sel_transf_name);
										$data_transf_name=mysql_fetch_array($ptr_transf_name);
										$transf_data='<br/><span style="color:red">Transfer from '.$data_transf_name['name'].' &nbsp;&nbsp;('.$data_transf_name['branch_name'].')</span>';
									}
									$sel_name="select name from site_setting where admin_id='".$data_assign['assigned_to']."'";
									$ptr_name=mysql_query($sel_name);
									$data_name=mysql_fetch_array($ptr_name);
									echo $data_name['name'].''.$transf_data;
									if($total_assign = $total_assign-1 )
										echo '<hr />';
								}
								echo'</td>';
								
								/*$sel_inst_amnt="select course_id,enroll_id from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										"<br />".$select_installments = " SELECT * FROM installment where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												$col_paid ='<font color="#006600">';
												if($data_installment[status] =='not paid')
												$col_paid ='<font color="#FF3333">';
											 	echo $data_installment[installment_amount].'/- '.$data_installment[installment_date].' : '.$col_paid.$data_installment[status]."</font><br>";	
											}
										}
										if($total_inst = $total_inst-1 )
											echo '<hr />';
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								*/
								
								$sql_invoice="select invoice_id from invoice where enroll_id='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' and installment_id='0' order by invoice_id desc";
								$my_query_invoice=mysql_query($sql_invoice);
								$row_invoice= mysql_fetch_array($my_query_invoice);
																
								echo '<td align="center">';
								$sel_added_date="select added_date from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_added_date=mysql_query($sel_added_date);
								$total_added_date=mysql_num_rows($ptr_added_date);
								while($data_added_date=mysql_fetch_array($ptr_added_date))
								{
									echo $data_added_date['added_date'];
									if($total_added_date = $total_added_date-1 )
										echo '<hr />';
								}
								echo'</td>';
								if($_SESSION['type'] =='S' || $edit_access=='yes')//|| $_SESSION['name']=="isasfinance"
								{
									/*if($val_query['service_tax'] >0)
									{
										echo '<td align="center"><a href="enroll.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
									}
									else if($val_query['cgst_tax'] >0)
									{*/
										echo '<td align="center"><a href="enroll_gst.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
									/*}
									if($val_query['service_tax'] >0)
									{*/
							  			//echo '<a href="" onClick="window.open(\'invoice-generate.php?record_id='.$row_invoice['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/invoice.png" title="View Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
									/*}
									else if($val_query['cgst_tax'] >0)
									{*/
										//echo '<a href="" onClick="window.open(\'invoice-generate_gst.php?record_id='.$row_invoice['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/gst1.png" width="21" height="21" title="View GST Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
									//}
							  		echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                	echo '</td>';
								}
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="16">
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
						<tr>
							<td width="20%">Select Councillior<span class="orange_font">*</span></td>
							<td width="40%">
							<select name="councillior_id" id="councillior_id">
							<option value="">Select Name</option>
							<?php
							$cm_category = "select name,branch_name,system_status,cm_id from site_setting where 1 and (type='C' or type='A' or type='Z') and system_status='Enabled' group by cm_id ";
							$ptr_cm = mysql_query($cm_category);
							while($data_cm = mysql_fetch_array($ptr_cm))
							{
								echo " <optgroup label='".$data_cm['branch_name']."'>";
								
								$sle_name="select admin_id,name,branch_name from site_setting where 1 and system_status='Enabled' and (type='C' or type='A' or type='Z') and cm_id='".$data_cm['cm_id']."' order by name asc"; 
								$ptr_name=mysql_query($sle_name);
								while($data_name=mysql_fetch_array($ptr_name))
								{
									echo '<option value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
								}
								echo " </optgroup>";
							}
							?>
							</select>
							</td>
						</tr>
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
