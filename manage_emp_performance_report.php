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
    	<td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php";?></td>
    	<td class="top_right"></td>
	</tr>
   	<tr>
    	<td class="mid_left"></td>
    	<td class="mid_mid" align="center">
			<table cellspacing="0" cellpadding="0" class="table" width="95%">
            	<tr class="head_td">
    				<td colspan="17">
        				<form method="get" name="search">
							<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              					<tr>
								<?php 
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                                {
									?>
									<td width="15%">
										<select name="branch_name_s" id="branch_name_s" class="input_select_login" style="width: 150px;" onchange="getstaff(this.value)">
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
									<input type="hidden" name="branch_name_s" id="branch_name_s" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
									</td>
									<?php 
								}
								if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								{
									?>
									<td width="10%" align="center" style="padding-left:0px;width: 15%;" id="staff_details">
										<select name="staff_id_s" id="staff_id_s" class="input_select" style="width:150px">
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
										$sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." ".$search_cm_id." and system_status='Enabled' and type='C' order by name asc"; 
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
									<?php
								}
								?>
                				<!--<td width="20%">
                                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                        <option value="">-Operation-</option>
                                        <option value="delete">Delete</option>
                                </select></td>-->
                        
                                <td width="10%">
                                <input type="text" name="start_date" class="input_text datepicker" placeholder="From Date"  id="start_date" title="From Date" value="<?php if($_REQUEST['start_date']) echo $_REQUEST['start_date']; else echo date('d/m/Y',strtotime('-1 days')) ?>">
                                </td>
                                 
                                <!--<td width="10%">
                                <input type="text" name="end_date" class="input_text datepicker" placeholder="To Date" id="end_date"  title="To Date" value="<?php //if($_REQUEST['end_date']) echo $_REQUEST['end_date']; else echo date('d/m/Y');?>">
                                </td>-->
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                <!--<td class="leftAlign" width="140px"> 
                                    <a href="daily_stack_report.php" target="_blank" style="font-size:14; font-weight:800">Daily Stack Report</a>
                                </td>-->
                                <!--<td class="leftAlign" ><a href="manage_inq_report.php" target="_blank" style="font-size:14; font-weight:800">Total Stack Report</a>-->
                                <!--<table border="0" cellspacing="0" cellpadding="0" align="right">
                                    <tr>
                                        <td></td>
                                        <td class="width5"></td>
                                        <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                        <td class="width2"></td>
                                        <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                                    </tr>
                                </table>-->
                                <!--</td>-->
            				</tr>
        				</table>
        			</form>	
				</td>
			</tr>
			<?php
            $sep_url_string='';
            $sep_url= explode("?",$_SERVER['REQUEST_URI']);
            if($sep_url[1] !='')
            {
                $sep_url_string="&".$sep_url[1];
            }
            ?> 
			<?php
            if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
            {
                $frm_date=explode("/",$_REQUEST['start_date']);
                $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
				$start_date=$frm_dates;
                $enquiry_from_date=" and DATE(report_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
            }
            else
            {
               $enquiry_from_date=" and DATE(`report_date`) >='".date('Y-m-d',strtotime('-1 days'))."'"; //date('Y-m-d',strtotime('-1 days'))

            }
            /*if($_REQUEST['end_date']  && $_REQUEST['end_date']!="To Date")
            {
                $to_date=explode("/",$_REQUEST['end_date']);
                $to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
				$end_date=$to_dates;
                $pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
                $installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
                $enquiry_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
                $followup_to_date=" and DATE(followup_date)<='".date('Y-m-d',strtotime($to_dates))."'";
            }
            else
            {
                $enquiry_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
                $followup_to_date=" and DATE(`followup_date`)<='".date('Y-m-d')."'";
                $end_date=date('d/m/y');
            }*/
            $search_cm_id='';
            $cm_ids=$_SESSION['cm_id'];
            if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
            {
                if($_REQUEST['branch_name_s']!='')
                {
                    $branch_name=$_REQUEST['branch_name_s'];
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
            if($_REQUEST['staff_id_s'])
            {
                $staff_ids=$_REQUEST['staff_id_s'];
                $where_staff_id=" and admin_id='".$staff_ids."'";
            }
            else
            {
                $where_staff_id='';
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
    
            if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
            {
                $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
            }
           
            $branch_id='';
            /*if($_REQUEST['staff_id'] !='')
            {*/
            $select_directory='order by name asc';
			if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
			{
				$sql_query= "select * from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' ".$where_staff_id." ".$search_cm_id." ".$select_directory."";
			}
			else
			{
            	$sql_query="select * from site_setting where 1 and admin_id='".$_SESSION['admin_id']."' ".$_SESSION['where']." and system_status='Enabled' ".$select_directory."";
			}
				$db=mysql_query($sql_query); //and system_status='Enabled'
            	$no_of_records=mysql_num_rows($db);
            ?>
            <form method="post" name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
            <input type="hidden" name="formAction" id="formAction" value=""/>
            <?php
            if($no_of_records)
            {
                $bgColorCounter=1;
                //$_SESSION['show_records'] = 10;
                $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'];
                $query_string1=$query_string.$date_query;
               // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                $all_records= $pager->paginate();
                ?>                  
                <tr class="grey_td" >
                <td width="4%" align="center"><strong>Sr. No.</strong></td>
                <td width="10%" align="center"><strong>Name</strong></td>
                <td width="7%" align="center"><strong>Timesheet Status</strong></td>
                <td width="7%" align="center"><strong>Utilisation</strong></td>
                <td width="7%" align="center"><strong>Presence</strong></td>
                <td width="8%" align="center"><strong>Working Hours</strong></td>
                <td width="8%" align="center"><strong>Task Completion</strong></td>
                <td width="7%" align="center"><strong>Quality Of Work</strong></td>
                 <td width="7%" align="center"><strong>Rules Followed</strong></td>
                <td width="7%" align="center"><strong>Phone Submited</strong></td>
                <td width="8%" align="center"><strong>No. Of Negative Remark</strong></td>
                <td width="8%" align="center"><strong>Points</strong></td>
                 <td width="8%" align="center"><strong>Monthly Points</strong></td>
                <td width="12%" align="center"><strong>Comments</strong></td>
                </tr>
                <?php
                $i=1;
                $total_assign=0;
                $total_pending=0;
                $total_completed=0;
                $total_walkin=0;
                $total_enrolled=0;
                while($val_query=mysql_fetch_array($all_records))
                {
                    $name = '';
                    if($bgColorCounter%2==0)
                        $bgcolor='class="grey_td"';
                    else
                        $bgcolor="";                
                    $listed_record_id=$val_query['admin_id']; 
                    include "include/paging_script.php";
                    
                    echo '<td align="center">'.$i.'</td>';
                    echo '<td align="center">'.$val_query['name'].'</td>';
                    
					$select_per="select * from emp_performance_report where employee_id='".$val_query['admin_id']."' ".$enquiry_from_date." ";
					$ptr_per=mysql_query($select_per);
					$data_per=mysql_fetch_array($ptr_per);
                    //=========================Total new enquiry called==================================
                    echo'<td align="center">'.$data_per['timesheet_mark'].'</td>';
                    //=============================Total New Pending followup=============================
                   	echo '<td align="center">'.$data_per['utilisation_mark'].'</td>';
                    //=============================Total Followups ========================================
                    echo '<td align="center">'.$data_per['presence'].'</td>';
                    //============================Non Repeated calls=======================================
                    echo '<td align="center">'.$data_per['working_hrs'].'</td>';
                    //========================= Total pending followup=====================================
                    echo'<td align="center">'.$data_per['task_mark'].'</td>';
                    //========================= Total followups Called=====================================
                    echo'<td align="center">'.$data_per['quality_work_mark'].'</td>';
                    //============================Total Invalid ===========================================
					 echo'<td align="center">'.round($data_per['class_start_time_mark']+$data_per['class_end_time_r_mark']+$data_per['faculty_grooming_r_mark']+$data_per['logsheet_send_r_mark']+$data_per['mobile_used_r_mark']+$data_per['timetable_followed_r_mark']+$data_per['student_decoram_r_mark']).'</td>';
                    //============================Total Invalid ===========================================
                    echo '<td align="center">'.$data_per['phone_submited'].'</td>';
                    //==========================Total Walkin folllowup=====================================
                    echo '<td align="center">'.$data_per['negative_remarks'].'</td>';
					//=====================================================================================
					echo '<td align="center">'.$data_per['points'].'</td>';
					//=====================================================================================
					echo '<td align="center">'.$data_per['monthly_points'].'</td>';
                    //===========================Total Enrollment==========================================
                    echo '<td align="center">'.$data_per['comments'].'</td>';
                    
                   
                    echo '</tr>';
                    $i++;
                }
                ?>
                <tr class="head_td">
                	<td colspan="17">
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
            	
    			<?php 
			//} 
			}
	  		else
        		echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';?>
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