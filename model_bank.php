<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
$page_name = "model_bank";
$sele_sac_code="select sac_code from sac_code_config where page_name='".$page_name."'";
$ptr_sac_code=mysql_query( $sele_sac_code);
$data_sac_code=mysql_fetch_array($ptr_sac_code);

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='352'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

$expense_type_id='';
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	
	$sel="select * from model_bank where model_id='".$record_id."'";
	$ptr_data=mysql_query($sel);
	if(mysql_num_rows($ptr_data))
	$row_expense=mysql_fetch_array($ptr_data);
	$expense_type_id=$row_expense['model_id']; 
}
else
{
	$record_id='';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Model Bank</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
    <!--End multiselect -->
	<link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	var  pageName = "add_expense";
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd/mm/yy'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		
		$("#agent_id").chosen({allow_single_deselect:true});
		$("#expense_category").chosen({allow_single_deselect:true});
		$("#vendor").chosen({allow_single_deselect:true});
		$("#employee").chosen({allow_single_deselect:true});
		$("#payment_mode").chosen({allow_single_deselect:true});
   });
	</script>
    <script type="text/javascript" src="../js/common.js"></script>
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

function validme()
{
	frm = document.jqueryForm;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
	
	if(frm.name.value=='')
	{
		disp_error +='Enter Full Name\n';
		document.getElementById('name').style.border = '1px solid #f00';
		frm.name.focus();
		error='yes';
	}
	if(frm.mobile_no.value=='')
	{
		disp_error +='Enter Mobile No.\n';
		document.getElementById('mobile_no').style.border = '1px solid #f00';
		frm.mobile_no.focus();
		error='yes';	 
	}
	
	if(error=='yes')
	{
		alert(disp_error);
		return false;
	}
	else
	{
		//send();
		return true;
	}
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
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
	$sep_url_string="?".$sep_url[1];
}
?>   
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
				$sql_query= "SELECT model_id FROM ".$GLOBALS["pre_db"]."model_bank where model_id ='".$del_record_id."'";
				if(mysql_num_rows($db->query($sql_query)))
					{
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Model Bank','Delete','model_bank','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert); 
						
						$delete_query="delete from ".$GLOBALS["pre_db"]."model_bank where model_id='".$del_record_id."'";
						$db->query($delete_query);                                                                                        
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
					setTimeout('document.location.href="model_bank.php";',500);
				</script>
			<?php                            
		}
	}
	if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
	{
		$del_record_id=$_REQUEST['record_id'];
		$sql_query= "SELECT model_id FROM ".$GLOBALS["pre_db"]."model_bank where model_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Model Bank','Delete','model_bank','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert); 
						
			$delete_query="delete from ".$GLOBALS["pre_db"]."model_bank where model_id='".$del_record_id."'";
			$db->query($delete_query);      
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
					setTimeout('document.location.href="model_bank.php";',500);
			</script>
			<?php
		}
	}
	?>
  	<tr>
    	<td class="mid_left"></td>
    	<td class="mid_mid" align="center">
    	<?php
    	$success=0;
		if($_POST['save_changes'])
		{
			$name=($_POST['name']) ? $_POST['name'] : "";
			$mobile_no=( ($_POST['mobile_no'])) ? $_POST['mobile_no'] : "";
			$email_id=( ($_POST['email_id'])) ? $_POST['email_id'] : "";
			$address=mysql_real_escape_string( ($_POST['address']) ? $_POST['address'] : "");
			$remark=mysql_real_escape_string( ($_POST['remark']) ? $_POST['remark'] : "");
			$hair=( ($_POST['hair'])) ? $_POST['hair'] : "";
			$makeup=( ($_POST['makeup'])) ? $_POST['makeup'] : "";
			$beauty=( ($_POST['beauty'])) ? $_POST['beauty'] : "";
			$spa=( ($_POST['spa'])) ? $_POST['spa'] : "";
			$nail=( ($_POST['nail'])) ? $_POST['nail'] : "";
			$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
			$added_date=date('Y-m-d');
			//$total_type1=$_POST['total_type1'];
			if(count($errors))
			{
				?>
				<tr><td><br></br>
					<table align="left" style="text-align:left;" class="alert">
						<tr>
                        	<td ><strong>Please correct the following errors</strong>
                            <ul>
							<?php
							for($k=0;$k<count($errors);$k++)
								echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
							</ul>
							</td>
                        </tr>
					</table>
		 			</td>
                </tr>   <br></br>  
				<?php
			}
			else
			{
				$success=1;
				$data_record['name']=$name;
				$data_record['mobile_no']=$mobile_no;
				$data_record['email_id']=$email_id;
				$data_record['address'] = $address;
				$data_record['remark'] = $remark;
				$data_record['hair'] = $hair;
				$data_record['makeup'] = $makeup;
				$data_record['beauty'] = $beauty;
				$data_record['spa'] = $spa;
				$data_record['nail'] = $nail;
				$data_record['added_date'] = $added_date;
				
				//===============================CM ID for Super Admin===============
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
					$sel_branch="select cm_id ,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
					$ptr_branch=mysql_query($sel_branch);
					$data_branch=mysql_fetch_array($ptr_branch);
					$cm_id=$data_branch['cm_id'];
					$data_record['cm_id']=$data_branch['cm_id'];
					$branch_name1=$branch_name;
				}		
				else
				{
					$cm_id=$_SESSION['cm_id'];
					$branch_name1=$_SESSION['branch_name'];
					$data_record['cm_id']=$_SESSION['cm_id'];
				}	
				$admin_id=$_SESSION['admin_id'];
				$data_record['admin_id'] = $admin_id;
				//========================================================================
			
				if($record_id)
				{
					$where_records="model_id='".$record_id."'";
					$db->query_update("model_bank", $data_record,$where_records);
				
				
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Model Bank','Edit','model_bank','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert); 
										
					//echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
					?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense added successfully</p></center></div>
					<script type="text/javascript">
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
						});
					});
				   	setTimeout('document.location.href="model_bank.php";',1000);
					</script>
					<?php
				}
				else
				{
					$ids= $db->query_insert("model_bank", $data_record);
					
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Model Bank','Add','model_bank','".$ins_is."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert); 
				
					//------send notification on inquiry addition--------------------
					/*$notification_args['reference_id'] = $ins_is;
					$notification_args['on_action'] = 'expense';
					$notification_status = addNotifications($notification_args);*/
					//---------------------------------------------------------------
				
					echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
					?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense added successfully</p></center></div>
					<script type="text/javascript">
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
						});
					});
					<?php unset($_SESSION['rand']);?>
				   	setTimeout('document.location.href="model_bank.php";',1000);
					</script>
					<?php
				}
			}
		}
		?>
			<form name="jqueryForm" method="post">
			<table cellspacing="3" cellpadding="3" style="border:1px solid #CCC; margin-top: 15px;" width="95%">
			<?php 
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
			{
				?>
                <tr>
                <td align="center">Select Branch</td>
                <td>
                <?php 
                $sel_branch = "SELECT * FROM branch where 1 and status='Active' order by branch_id asc ";	 
                $query_branch = mysql_query($sel_branch);
                $total_Branch = mysql_num_rows($query_branch);
                echo '<table width="100%"><tr><td>';
                echo '<select id="branch_name" style="width:200px" class="input_text" name="branch_name" onchange="show_bank(this.value)">';
                
                while($row_branch = mysql_fetch_array($query_branch))
                {
                    $selected='';
                    if($_POST['branch_name']== $row_branch['branch_name'])
                    {
                    	$selected='selected="selected"';
                	}
                	$selected_branch="select branch_name from site_setting where cm_id= '".$row_expense['cm_id']."' and type='A' ";
                	$ptr_selected=mysql_query($selected_branch);
                	if(mysql_num_rows($ptr_selected))
                	{
                    	$data_cm_id=mysql_fetch_array($ptr_selected);
                    	if($data_cm_id['branch_name'] == $row_branch['branch_name'] )
                    	{
                    	     $selected='selected="selected"';
                    	}
                    }
                	?>
                	<option <?php echo $selected;?> value="<?php echo $row_branch['branch_name'];?>"><?php echo $row_branch['branch_name']; ?>                	</option>
                	<?php
                	
            	}
				echo '</select></td>';
            	echo "</tr></table>";
            	?>
				</td>
                </tr>
                <?php 
			}  
            else 
			{
				?>
                <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                <?php 
			}
            ?>
            <tr>
                <td width="15%" align="center">Name<span class="orange_font">*</span></td>
                <td width="25%"><input type="text" style="width:200px" name="name" id="name" class="input_text" value="<?php if($_POST['name']) echo $_POST['name']; else echo $row_expense['name']; ?>"  />
                </td>
            </tr>
            <tr>
                <td width="15%" align="center">Mobile No.<span class="orange_font">*</span></td>
                <td width="25%"><input type="text" style="width:200px" name="mobile_no" id="mobile_no" class="input_text" value="<?php if($_POST['mobile_no']) echo $_POST['mobile_no']; else echo $row_expense['mobile_no']; ?>"  />
                </td>
            </tr>
            <tr>
                <td width="15%" align="center">Email Id<span class="orange_font"></span></td>
                <td width="25%"><input type="text" style="width:200px" name="email_id" id="email_id" class="input_text" value="<?php if($_POST['email_id']) echo $_POST['email_id']; else echo $row_expense['email_id']; ?>"  />
                </td>
            </tr>
            <tr>
                <td width="15%" class="tr-header" align="center">Address</td>
                <td><textarea name="address" id="address" class="input_text" style="width:300px;height:70px"><?php if($_POST['address']) echo $_POST['address']; else echo $row_expense['address']; ?></textarea></td>
            </tr>
            <tr>
                <td width="15%" align="center">Prefered For<span class="orange_font">*</span></td>
                <td width="25%">
                <input type="checkbox" <?php if($_POST['hair']=='yes') echo 'checked="checked"'; else if($row_expense['hair']=='yes') echo 'checked="checked"'; ?> name="hair" id="hair" value="yes" class="input_checkbox">&nbsp;&nbsp; Hair <br/>
                <input type="checkbox" <?php if($_POST['makeup']=='yes') echo 'checked="checked"'; else if($row_expense['makeup']=='yes') echo 'checked="checked"'; ?> name="makeup" id="makeup" value="yes" class="input_checkbox">&nbsp;&nbsp; Makeup <br/>
                <input type="checkbox" <?php if($_POST['beauty']=='yes') echo 'checked="checked"'; else if($row_expense['beauty']=='yes') echo 'checked="checked"'; ?> name="beauty" id="beauty" value="yes" class="input_checkbox">&nbsp;&nbsp; Beauty <br/>
                <input type="checkbox" <?php if($_POST['spa']=='yes') echo 'checked="checked"'; else if($row_expense['spa']=='yes') echo 'checked="checked"'; ?> name="spa" id="spa" value="yes" class="input_checkbox">&nbsp;&nbsp; Spa <br/>
                <input type="checkbox" <?php if($_POST['nail']=='yes') echo 'checked="checked"'; else if($row_expense['nail']=='yes') echo 'checked="checked"'; ?> name="nail" id="nail" value="yes" class="input_checkbox">&nbsp;&nbsp; Nail <br/>
                </td>
            </tr>
            <tr>
                <td width="15%" class="tr-header" align="center">Remark</td>
                <td><textarea name="remark" id="remark" class="input_text" style="width:300px;height:70px"><?php if($_POST['remark']) echo $_POST['remark']; else echo $row_expense['remark']; ?></textarea></td>
            </tr>
            <tr>
            	<td align="center" colspan="2"><input type="submit" class="input_button" onclick="return validme()" name="save_changes" value="Save"  /></td>
            </tr>
		</table>
		</form>
		<?php
		
?>
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="14">
        <form method="get" name="search">
			<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                    </select></td>
                    <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
                    {
                    ?>
                        <td width="25%" align="center"><strong>Select Branch</strong> &nbsp;&nbsp;
                            <?php
                            $sel_branch = "SELECT * FROM branch where 1 and status='Active' order by branch_id asc ";	 
                            $query_branch = mysql_query($sel_branch);
                            $total_Branch = mysql_num_rows($query_branch);
                            //echo '<table width="100%"><tr><td>';
                            echo '<select id="branch_id" name="branch_id">';
                            echo '<option value="">Select Branch</option>';
                            while($row_branch = mysql_fetch_array($query_branch))
                            {
                                $selected='';
                                if($_REQUEST['branch_id']==$row_branch['branch_name'])
                                {
                                     $selected='selected="selected"';
                                }
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $row_branch['branch_name']; ?>"><?php echo $row_branch['branch_name']; ?></option>
                                <?php
                            }
                            echo '</select>';
                            //echo "</td></tr></table>";
                            ?> 
                            <!-- <td width="10%">
                             <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php //if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                             </td>
                             
                             <td width="10%">
                             <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php //if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                             </td>-->
                        </td>
                        <?php 
                    } ?>
                <td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
                        <tr>
                            <!--<td><a href="expense_export.php<?php //echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td> -->
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
	
	$where_cm_id_data="";
	if($_REQUEST['branch_id'])
	{						
		$cm_id='';
		$selected_branch="select cm_id from site_setting where branch_name='".$_REQUEST['branch_id']."' and type='A' ";
		$ptr_selected=mysql_query($selected_branch);
		if(mysql_num_rows($ptr_selected))
		{
			$data_cm_id=mysql_fetch_array($ptr_selected);
			$cm_id= $data_cm_id['cm_id'];
		}
		
		$where_cm_id_data=" and cm_id = '".$cm_id."'";
	}
	
	if($_REQUEST['keyword']!="Keyword")
		$keyword=trim($_REQUEST['keyword']);
	if($keyword)
	{
		$pre_keyword =" and ( name like '%".$keyword."%' || mobile_no like '%".$keyword."%' || email_id like '%".$keyword."%')";
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

	if($_GET['orderby']=='amount' )
		$img1 = $img;

	if($_GET['order'] !='' && ($_GET['orderby']=='model_id'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
		$select_directory='order by model_id desc';  
		
	
	$sql_query= "SELECT * FROM model_bank where 1 ".$where_cm_id_data." ".$_SESSION['where']." ".$pre_keyword." ".$from_date." ".$to_date." ".$select_directory." "; 
   //echo $sql_query;
	$no_of_records=mysql_num_rows($db->query($sql_query));
	if($no_of_records)
	{
		$bgColorCounter=1;
		//$_SESSION['show_records'] = 10;
		$query_string='&keyword='.$keyword.'&branch_id='.$_REQUEST['branch_id'].'&from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'];
		$query_string1=$query_string.$date_query;
	   // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
		$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
		$all_records= $pager->paginate();
		?>
        <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
        <input type="hidden" name="formAction" id="formAction" value=""/>
        <tr class="grey_td" >
			<?php
            if($_SESSION['type']=='S' || $edit_access=='yes'  )
            {?>
            <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
            <?php
            }
            ?>
            <td width="5%" align="center"><strong>Sr. No.</strong></td>
			<?php
            if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
            {
                ?>
                <td width="8%" align="center"><strong>Branch Name</strong></td>
                <?php 
            } ?>
            <td width="8%" align="center"><strong>Name</strong></td>
            <td width="8%"align="center"><strong>Mobile No.</strong></td>
        	<td width="12%" align="center"><strong>Email Id</strong></td>
            <td width="14%" align="center"><strong>Address</strong></td>
            <td width="10%" align="center"><strong>Prefered For</strong></td>
            <td width="10%"align="center"><strong>Remark</strong></td>
            <td width="8%" align="center"><strong>Added Date</strong></td>
			<?php
            if($_SESSION['type']=='S' || $edit_access=='yes' )
            {?>
            	<td width="12%" class="centerAlign"><strong>Action</strong></td>
        		<?php 
			} ?>
        </tr>
		<?php
        while($val_query=mysql_fetch_array($all_records))
        {
            if($bgColorCounter%2==0)
                $bgcolor='class="grey_td"';
            else
                $bgcolor="";                
            
            $listed_record_id=$val_query['model_id']; 
            
            include "include/paging_script.php";
			
			$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
            $ptr_branch=mysql_query($sel_branch);
            $data_branch=mysql_fetch_array($ptr_branch);
			
            echo '<tr '.$bgcolor.' >';
            
            if($_SESSION['type']=='S' || $edit_access=='yes' )
            {
                echo '<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
            }
            echo '<td align="center">'.$sr_no.'</td>'; 
             
            if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
            {
                echo '<td align="center">'.$data_branch['branch_name'].'</td>';
            }
			
			echo '<td align="center">'.$val_query['name'].'</td>'; 
            echo '<td align="center">'.$val_query['mobile_no'].'</td>';
            echo '<td align="center">'.$val_query['email_id'].'</td>';
            echo '<td align="center">'.$val_query['address'].'</td>';
            
            echo '<td align="center">';
			if($val_query['hair']!='')
				echo 'Hair <br/>';
			if($val_query['beauty']!='')
				echo 'Beauty <br/>';
			if($val_query['makeup']!='')
				echo 'Makeup <br/>';
			if($val_query['spa']!='')
				echo 'Spa <br/>';
			if($val_query['nail']!='')
				echo 'Nail';
			echo '</td>';
           
            echo '<td align="center">'.$val_query['remark'].'</td>';
            echo '<td align="center">'.$val_query['added_date'].'</td>';
            if($_SESSION['type']=='S' || $edit_access=='yes')
            {
            echo '<td align="center"><a href="model_bank.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

            echo '</td>';
            }
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
        </tr>
	</form>
    <?php 
	} 
    else
		echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No category found related to your search criteria, please try again</div><br></td></tr>';?>
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