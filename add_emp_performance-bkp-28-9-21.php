<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Performance Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php

if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM emp_performance_report where id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
		$record_id=0;
}

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='349'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+date.id+"')"); return res;
			//$("#date" ).datepicker({defaultDate: -1,maxDate:"-1D"});
		}
		
		$("#staff_id").chosen({allow_single_deselect:true});
		$("#staff_id_s").chosen({allow_single_deselect:true});
		<?php 
		if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			$("#branch_name_s").chosen({allow_single_deselect:true});
			<?php
		}
		?>
		
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
	function getstaff(branch_id)
	{
		var data1="action=stack_report&branch_id="+branch_id;	
		$.ajax({
		url: "show_councellor.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(html !='')
			{
				//alert(html);
				document.getElementById("staff_details").innerHTML=html;
				$("#staff_id_s").chosen({allow_single_deselect:true});
			}
		},
		error:function(exception){alert('Exception:'+exception);}
		});
	}
	function getstaffDetails(branch_id)
	{
		var data1="action=performance_report&branch_id="+branch_id;	
		$.ajax({
		url: "show_councellor.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(html !='')
			{
				//alert(html);
				document.getElementById("staff_ids").innerHTML=html;
				$("#staff_id").chosen({allow_single_deselect:true});
			}
		},
		error:function(exception){alert('Exception:'+exception);}
		});
	}
	function check_data(staff_id)
	{
		var branch_id= document.getElementById("branch_name").value;
		var date= document.getElementById("date").value;
		document.getElementById("working_hours").value = '';
		var data1="action=get_staff_presence&branch_id="+branch_id+"&staff_id="+staff_id+"&date="+date;	
		$.ajax({
		url: "ajax.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			if(html !='')
			{
				document.getElementById("presence").value = "yes";
				document.getElementById("working_hours").value = html;
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
    	<td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
    	<td class="top_right"></td>
	</tr>
   	<tr>
    	<td class="mid_left"></td>
    	<td class="mid_mid">
			<table cellspacing="0" cellpadding="0" width="100%">
            <?php
            $errors=array(); $i=0;			
            $success=0;
            
            if($_POST['save_changes'])
            {
                $branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
				$date=( ($_POST['date'])) ? $_POST['date'] : "";
				if($date !='')
				{
					$seps_date = explode('/',$date);
					$report_date = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
				}
				else
					$report_date='';
					
              	$staff_id=( ($_POST['staff_id'])) ? $_POST['staff_id'] : "";
				$timesheet_status=( ($_POST['timesheet_status'])) ? $_POST['timesheet_status'] : "";
				$utilisation=( ($_POST['utilisation'])) ? $_POST['utilisation'] : "";
				$presence=( ($_POST['presence'])) ? $_POST['presence'] : "";
				$working_hours=( ($_POST['working_hours'])) ? $_POST['working_hours'] : "";
				$task_completion=( ($_POST['task_completion'])) ? $_POST['task_completion'] : "";
				$quality_of_work=( ($_POST['quality_of_work'])) ? $_POST['quality_of_work'] : "";
				$phone_submited=( ($_POST['phone_submited'])) ? $_POST['phone_submited'] : "";
				$negative_remark=( ($_POST['negative_remark'])) ? $_POST['negative_remark'] : "";
				$points=( ($_POST['points'])) ? $_POST['points'] : "";
				$comments=( ($_POST['comments'])) ? $_POST['comments'] : "";
                $added_date=date('Y-m-d H:i:s');  
                $admin_id=$_SESSION['admin_id'];
				
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
				
                if(count($errors))
                {
                        ?>
                        <tr><td colspan="2"> <br></br>
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
					$data_record['employee_id'] = $staff_id;
					$data_record['timesheet_status'] = $timesheet_status;
					$data_record['utilisation'] = $utilisation;
					$data_record['presence'] = $presence;
					$data_record['working_hrs'] = $working_hours;
					$data_record['task_completion'] = $task_completion;
					$data_record['quality_work'] = $quality_of_work; 
					$data_record['phone_submited'] = $phone_submited;
					$data_record['negative_remarks'] = $negative_remark;
					$data_record['points'] = $points;
					$data_record['comments'] =$comments;
					$data_record['admin_id'] =$admin_id;
					$data_record['cm_id'] =$cm_id;
					$data_record['report_date']=$report_date;
					$data_record['added_date'] =$added_date;
					
					if($record_id)
					{
						$update="UPDATE `emp_performance_report` SET `employee_id`='".$staff_id.",`timesheet_status`='".$timesheet_status."',`utilisation`='".$utilisation."',`presence`='".$presence."',`working_hrs`='".$working_hours."',`task_completion`='".$task_completion."',`quality_work`='".$quality_of_work."',`phone_submited`='".$phone_submited."',`negative_remarks`='".$negative_remark."',`points`='".$points."',`comments`='".$comments."',`admin_id`='".$admin_id."',`cm_id`='".$cm_id."',`report_date`='".$report_date."',`added_date`='".$added_date."' WHERE id ='".$record_id."'";
						$ptr_up=mysql_query($update);
					}
					else
					{
						$insert="INSERT INTO `emp_performance_report`(`employee_id`, `timesheet_status`, `utilisation`, `presence`, `working_hrs`, `task_completion`, `quality_work`, `phone_submited`, `negative_remarks`, `points`, `comments`, `admin_id`, `cm_id`, `report_date`, `added_date`) VALUES ('".$staff_id."','".$timesheet_status."','".$utilisation."','".$presence."','".$working_hours."','".$task_completion."','".$quality_of_work."','".$phone_submited."','".$negative_remark."','".$points."','".$comments."','".$admin_id."','".$cm_id."','".$report_date."','".$added_date."')";
						$ptr_ins=mysql_query($insert);
					}
                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                    ?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record added successfully</p></center></div>
                    <script type="text/javascript">
                    $(document).ready(function() {
                        $( "#statusChangesDiv" ).dialog({
                            modal: true,
                            buttons: {
                                Ok: function() { $( this ).dialog( "close" );}
                            }
                        });        
                    });
                    setTimeout('document.location.href="manage_emp_performance_report.php";',500);
                    </script>
                    <?php
                }
            }
            if($success==0)
            {
            	?>
                <tr>
                    <td width="20%">Select Date<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="date" class="input_text datepicker" placeholder="Date" id="date" title="Date" value="<?php if($_REQUEST['date']) echo $_REQUEST['date']; else echo date('d/m/Y',strtotime('-1 days')) ?>">
                    </td>
                </tr>
                <tr>
                <td width="20%">Select Branch Name<span class="orange_font">*</span></td>
				<?php 
                if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                {
                    ?>
                    <td >
                        <select name="branch_name" id="branch_name" class="input_select_login" style="width: 300px;" onchange="getstaffDetails(this.value)">
                        <option value="">-Branch Name-</option>
                        <?php 
                        $sel_branch="select branch_id,branch_name from branch where status='Active'";
                        $ptr_sel=mysql_query($sel_branch);
                        while($data_branch=mysql_fetch_array($ptr_sel))
                        {
                            $sel='';
                            if($data_branch['branch_name']==$_GET['branch_name'])
                            {
                                $sel='selected="selected"';
                            }
                            else if($data_branch['branch_name']=='Pune')
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
                else 
                {
                    ?>
                    <td colspan="2" align="left">
                    <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                    </td>
                    <?php 
                }
				?>
                <tr>
                    <td width="20%">Select Staff<span class="orange_font">*</span></td>
                    <td id="staff_ids">
                        <select name="staff_id" id="staff_id" class="input_select" style="width:300px" onchange="check_data(this.value)">
                            <option value="">Select Staff</option>
                            <?php
                            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
                                    $search_cm_id=" and cm_id='2'";
                                    $cm_ids='2';
                                }
                            }
                            $sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." ".$search_cm_id." and system_status='Enabled' order by name asc"; 
                            $ptr_name=mysql_query($sle_name);
                            while($data_name=mysql_fetch_array($ptr_name))
                            {
                                $selected='';
                                if($data_name['admin_id'] == $_REQUEST['staff_id'])
                                {
                                    $selected='selected="selected"';
                                }
                                echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Enter Timesheet Status<span class="orange_font">*</span></td>
                    <td>
                        <select name="timesheet_status" id="timesheet_status" class="input_select">
                        	<option value="">Select Timesheet Status</option>
                        	<option value="yes" selected="selected">Yes</option>
                            <option value="no" >No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Utilisation<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="utilisation" class="input_text" id="utilisation" title="utilisation" value="<?php if($_POST['utilisation']) echo $_POST['utilisation']; else echo $row_record['utilisation']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%">Presence<span class="orange_font">*</span></td>
                    <td>
                        <select name="presence" id="presence" class="input_select">
                        	<option value="">Select Presence</option>
                        	<option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Working Hours<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="working_hours" class="input_text" id="working_hours" title="working_hours" value="<?php if($_POST['working_hours']) echo $_POST['working_hours']; else echo $row_record['working_hours']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%">Task Completion<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="task_completion" class="input_text" id="task_completion" title="task_completion" value="<?php if($_POST['task_completion']) echo $_POST['task_completion']; else echo $row_record['task_completion']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%">Quality of Work<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="quality_of_work" class="input_text" id="quality_of_work" title="quality_of_work" value="<?php if($_POST['quality_of_work']) echo $_POST['quality_of_work']; else echo $row_record['quality_of_work']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%">Phone Submited<span class="orange_font">*</span></td>
                    <td>
                        <select name="phone_submited" id="phone_submited" class="input_select">
                        	<option value="">Select Status</option>
                        	<option value="yes">Yes</option>
                            <option value="no" selected="selected">No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">No. of Negative Remark<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="negative_remark" class="input_text" id="negative_remark" title="negative_remark" value="<?php if($_POST['negative_remark']) echo $_POST['negative_remark']; else echo $row_record['negative_remark']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%">Points<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="points" class="input_text" id="points" title="points" value="<?php if($_POST['points']) echo $_POST['points']; else echo $row_record['points']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%">Comments<span class="orange_font">*</span></td>
                    <td>
                        <textarea type="text" name="comments" class="input_text" id="comments" title="comments" value="<?php if($_POST['comments']) echo $_POST['comments']; else echo $row_record['comments']; ?>"> </textarea>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><input type="submit" name="save_changes"  value="Save"  /></td>
                </tr>
        		<?php
			}?>
        	</table> 
        	</form>
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