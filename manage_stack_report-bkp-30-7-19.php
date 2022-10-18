<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Stack Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		$("#staff_id").chosen({allow_single_deselect:true});
		<?php 
		if($_SESSION['type']=="S")
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
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
					$("#staff_id").chosen({allow_single_deselect:true});
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
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="17">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <?php if($_SESSION['type']=='S')
				{
				?>
				 <td width="15%">
					<select name="branch_name" id="branch_name" class="input_select_login" style="width: 150px;" onchange="getstaff(this.value)">
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
					<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
					</td>
					<?php 
				}?>
				<td width="10%" align="center" style="padding-left:0px;width: 15%;" id="staff_details">
                    <select name="staff_id" id="staff_id" class="input_select" style="width:150px">
                        <option value="">Select Staff</option>
                        <?php
							if($_SESSION['type']=='S')
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
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
                        
                         <td width="10%">
                         <input type="text" name="start_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="start_date" title="From Date" value="<?php if($_REQUEST['start_date']) echo $_REQUEST['start_date']; else echo $enquiry_from_date=date('d/m/Y',strtotime('-30 days')) ?>">
                         </td>
                         
                         <td width="10%">
                         <input type="text" name="end_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="end_date"  title="To Date" value="<?php if($_REQUEST['end_date']) echo $_REQUEST['end_date']; else echo date('d/m/Y');?>">
                        </td>
                        <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                        <td class="leftAlign" width="140px"> 
                			<a href="daily_stack_report.php" target="_blank" style="font-size:14; font-weight:800">Daily Stack Report</a>
                        </td>
                		<td class="leftAlign" > 
                			<a href="manage_inq_report.php" target="_blank" style="font-size:14; font-weight:800">Total Stack Report</a>
                    	<!--<table border="0" cellspacing="0" cellpadding="0" align="right">
                        	<tr>
                          		<td></td>
                          		<td class="width5"></td>
                            	<td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                            	<td class="width2"></td>
                            	<td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                          	</tr>
                    	</table>-->
                		</td>
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
						  	$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates))."' ";
						}
						else
						{
							$enquiry_from_date=""; 
							$followup_from_date="";
							
							if($_REQUEST['to_date']=='')
							{
								$enquiry_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$followup_from_date=" and DATE(`followup_date`) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$start_date=date('Y-m-d',strtotime('-7 days'));
							}
							else
							{
								$enquiry_from_date="";
								$followup_from_date='';
								$start_date='';
							}
						}
						if($_REQUEST['end_date']  && $_REQUEST['end_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['end_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
							$enquiry_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
							$followup_to_date=" and DATE(followup_date)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$enquiry_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
							$followup_to_date=" and DATE(`followup_date`)<='".date('Y-m-d')."'";
							$end_date=date('Y-m-d');
						}
						$search_cm_id='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S")
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
						if($_REQUEST['staff_id'])
						{
							$staff_ids=$_REQUEST['staff_id'];
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
						if($_REQUEST['staff_id'] !='')
						{
                        $select_directory='order by name asc';                      
                        $sql_query= "select * from site_setting where 1 and (type='C' or type='A') ".$_SESSION['where']." and system_status='Enabled' ".$where_staff_id." ".$search_cm_id." ".$select_directory."";
					  	$db=mysql_query($sql_query); //and system_status='Enabled'
                        $no_of_records=mysql_num_rows($db);
						
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
   
    						<form method="post" name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                    		<input type="hidden" name="formAction" id="formAction" value=""/>
                            <tr><td align="left" colspan="17"><strong>Note: Default Date start from <?php echo $start_date; ?> to <?php echo $end_date; ?></strong></td></tr>
                            <tr class="grey_td" >
                            <td colspan="3" align="center"><strong>Total Enquiry</strong></td>
                            <?php
							$select_enq="select inquiry_id from inquiry where 1 ".$search_cm_id." ".$_SESSION['where']."  ".$enquiry_from_date." ".$enquiry_to_date."";
							$query_enq=mysql_query($select_enq);
							$count_total=mysql_num_rows($query_enq);
							?>
                            <td colspan="3" align="center"><strong><?php echo $count_total; ?></strong></td>
                            <td colspan="11" align="center">Enquiries not assigned</td>
                            <?php
							$select_unassign="select inquiry_id, from inquiry where 1 and (employee_id='' or employee_id is NULL) ".$search_cm_id." ".$_SESSION['where']."  ".$enquiry_from_date." ".$enquiry_to_date."";
							$query_enq_unassign=mysql_query($select_unassign);
							$count_unassigned=mysql_num_rows($query_enq_unassign);
							?>
                            <!--<td colspan="3"><?php //echo $count_unassigned; ?></td>-->
                            </tr>
                      		<tr class="grey_td" >
                        	<td width="4%" align="center"><strong>Sr. No.</strong></td>
                        	<td width="7%" align="center"><strong>Name</strong></td>
                        	<td width="7%" align="center"><strong>Total New Enq. Assign</strong></td>
                            <td width="7%" align="center"><strong>Total New Enq. Called</strong></td>
                            <td width="7%" align="center"><strong>Pending New Followups</strong></td>
                            <td width="8%" align="center"><strong>Total Followups (Repeated)</strong></td>
                            <td width="8%" align="center"><strong>Total Followups (Non-Repeated)</strong></td>
                            <td width="7%" align="center"><strong>Total Pending Followups</strong></td>
                            <td width="7%" align="center"><strong>Total Followups Called</strong></td>
                            <td width="8%" align="center"><strong>Invalid/Not Intrested Enquiry</strong></td>
                            <td width="8%" align="center"><strong>Total Walkin (Repeated)</strong></td>
                            <td width="8%" align="center"><strong>Total Walkin (Non-Repeated)</strong></td>
                        	<td width="7%" align="center"><strong>Total Enroll</strong></td>
                            <td width="7%" align="center"><strong>Total Upgrade</strong></td>
                            <td width="7%" align="center"><strong>Total Downpayment</strong></td>
                            <td width="7%" align="center"><strong>Total Installment</strong></td>
                            <td width="7%" align="center"><strong>Total Amount</strong></td>
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
                            	
								$select_enquiry="select inquiry_id from inquiry where 1 and employee_id='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_enquiery=mysql_query($select_enquiry);
								$count_enquiry=mysql_num_rows($query_enquiery);
								echo '<td align="center"><a target="_blank" href="show_students.php?assigned_to='.$val_query['admin_id'].''.$sep_url_string.' ">'.$count_enquiry.'</a></td>';
								$total_assign +=$count_enquiry;
								
								$select_enq_cnt="select inquiry_id from inquiry where 1 and (followup_date !='' or followup_date is NOT NULL) and employee_id='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_enq_cnt=mysql_query($select_enq_cnt);
								$count_enq_called=mysql_num_rows($query_enq_cnt);
								
								/*$cnt_new_followup=0;
								$cnt_pd=0;
								while($data_new_inq=mysql_fetch_array($query_enquiery))
								{
									if($data_new_inq['followup_date']!='' || $data_new_inq['followup_date'] !=NULL)
									{
										$cnt_new_followup +=1; 
									}
									else
									{
										$cnt_pd +=1;
									}
								}*/
								
								$sel_exst_foll="SELECT * FROM inquiry where 1 and status = 'Enquiry' and employee_id='".$val_query['admin_id']."' ".$search_cm_id." and (response !='7' and response!='8' or response is NULL) ".$followup_from_date." ".$followup_to_date." order by inquiry_id desc";
								$ptr_exst_foll=mysql_query($sel_exst_foll);
								$total_foll=mysql_num_rows($ptr_exst_foll);
								/*$cnt_exist=0;
								$cnt_new=0;
								if($cnt_foll=mysql_num_rows($ptr_exst_foll))
								{
									while($data_foll=mysql_fetch_array($ptr_exst_foll))
									{
										$sele_f="select followup_id from followup_details where student_id='".$data_foll['student_id']."' ";
										$ptr_f=mysql_query($sele_f);
										if(mysql_num_rows($ptr_f) >1)
										{
											$cnt_exist +=1;
										}
										else
										{
											$cnt_new +=1;
										}
									}
								}*/
								
								//=========================Total new enquiry called==================================
								echo'<td align="center"><a target="_blank" href="show_students.php?assigned_to='.$val_query['admin_id'].'&followup_by=followup_completed'.$sep_url_string.' ">'.$count_enq_called.'</a></td>';
								$total_new_called +=$count_enq_called;
								//====================================================================================
								//=============================Total New Pending followup=============================
								$select_pend_followups="select inquiry_id from inquiry where 1 and (followup_date='' or followup_date is NULL) and employee_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_pend_followups=mysql_query($select_pend_followups);
								$count_pending_follow=mysql_num_rows($query_pend_followups);			
													
								echo '<td align="center"><a target="_blank" href="show_students.php?assigned_to='.$val_query['admin_id'].'&followup_by=followup_pending'.$sep_url_string.' ">'.$count_pending_follow.'</a></td>';
								$total_new_pending +=$count_pending_follow;
								//=====================================================================================
								//=============================Total Followups ========================================
								
								/*$select_comp_foll="select inquiry_id from inquiry where 1 and (followup_date!='' or followup_date is NOT NULL) and employee_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_follow=mysql_query($select_comp_foll);
								$comp_followups=mysql_num_rows($query_follow);	*/	
								$select_tot_called="select followup_id from followup_details where 1 and admin_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_tot_called=mysql_query($select_tot_called);
								$tot_foll_called=mysql_num_rows($query_tot_called);
								$tot_followups=$tot_foll_called+$total_foll;
								
								echo '<td align="center">'.$tot_followups.'</td>';
															
								$total_all_followups +=$tot_followups;
								//=====================================================================================
								//============================Non Repeated calls=====================================
								$select_not_repeated="select DISTINCT(student_id) from followup_details where 1 and admin_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_not_repeaated=mysql_query($select_not_repeated);
								$tot_non_repeated=mysql_num_rows($query_not_repeaated);
								$non_repeated_followups=$tot_non_repeated+$total_foll;
								
								echo '<td align="center">'.$non_repeated_followups.'</td>';
															
								$total_non_repeated_followups +=$non_repeated_followups;
								//=====================================================================================
								//========================= Total pending followup=====================================
								echo'<td align="center"><a target="_blank" href="manage_student.php?employee_id='.$val_query['admin_id'].''.$sep_url_string.' ">'.$total_foll.'</a></td>';
								$tot_pend_followup +=$total_foll;
								//=====================================================================================
								//========================= Total followups Called=====================================
								echo'<td align="center">'.$tot_foll_called.'</td>';
								$tot_called_followup +=$tot_foll_called;
								//=====================================================================================
								//============================Total Invalid ===========================================
								
								$select_invalid="select inquiry_id from inquiry where 1 and (response='7' or response='8') and employee_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_invalid=mysql_query($select_invalid);
								$count_invalid=mysql_num_rows($query_invalid);								
								echo '<td align="center"><a target="_blank" href="show_students.php?assigned_to='.$val_query['admin_id'].'&response=not_intrested'.$sep_url_string.' ">'.$count_invalid.'</a></td>';
								$total_invalid +=$count_invalid;
								
								//=====================================================================================
								//==========================Total Walkin folllowup=====================================
								$select_rep_walkin="select student_id from followup_details where 1 and response='1' and admin_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_rep_walkin=mysql_query($select_rep_walkin);
								$count_rep_walkin=mysql_num_rows($query_rep_walkin);	
								echo '<td align="center">'.$count_rep_walkin.'</td>';
								$total_rep_walkin +=$count_rep_walkin;
								//=====================================================================================
								//==========================Total Walkin folllowup=====================================
								$select_enq_walkin="select DISTINCT(student_id) from followup_details where 1 and response='1' and admin_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."";
								$query_enq_walkin=mysql_query($select_enq_walkin);
								$count_enq_walkin=mysql_num_rows($query_enq_walkin);	
								echo '<td align="center">'.$count_enq_walkin.'</td>';
								$total_walkin +=$count_enq_walkin;
								//=====================================================================================
								//===========================Total Enrollment====================================
								$select_inst="select enroll_id from enrollment where 1 and ref_id='0' and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." ";
								$query_inst=mysql_query($select_inst);
								$count_enroll=mysql_num_rows($query_inst);
								
								$sel_enroll="select enroll_id from enrollment where 1 and ref_id!='0' and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." ";
								$query_enroll=mysql_query($sel_enroll);
								$cnt_enroll=mysql_num_rows($query_enroll);
								
								echo '<td align="center"><a target="_blank" href="total_enrollment.php?assign_to='.$val_query['admin_id'].''.$sep_url_string.' ">'.$count_enroll.'</a></td>';
								//===============================Total Upgrade==============================
								echo '<td align="center"><a target="_blank" href="total_enrollment.php?assign_to='.$val_query['admin_id'].''.$sep_url_string.' ">'.$cnt_enroll.'</a></td>';
								$total_enrolled +=$count_enroll;
								$total_upgrade +=$cnt_enroll;
								//=====================================================================================
								//==============================Total Downpaymet================================
								$sel_down_amnt="select SUM(amount) as total_amnt from invoice where 1 and type='down_payment' and assigned_to='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
								$query_down_amnt=mysql_query($sel_down_amnt);
								$data_down_amnt=mysql_fetch_array($query_down_amnt);
								echo '<td align="center">'.intval($data_down_amnt['total_amnt']).'</td>';
								$total_downpayment +=$data_down_amnt['total_amnt'];
								//==============================Total Installment====================================
								$sel_recv_amnt="select SUM(amount) as total_amnt from invoice where 1 and (type!='down_payment' or type is NULL) and assigned_to='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
								$query_recv_amnt=mysql_query($sel_recv_amnt);
								$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
								echo '<td align="center">'.intval($data_recv_amnt['total_amnt']).'</td>';
								$total_installment +=$data_recv_amnt['total_amnt'];
								//==============================Total Amount======================================
								$total_amnt=$data_down_amnt['total_amnt']+$data_recv_amnt['total_amnt'];
								echo '<td align="center">'.intval($total_amnt).'</td>';
								$total_amount +=$total_amnt;
								//=====================================================================================
								echo '</tr>';
								$i++;
							}
							?>
                            <tr class="grey_td" >
                        	<td align="center" colspan="2"><strong>Total</strong></td>
                        	<td align="center"><strong><?php echo $total_assign; ?></strong></td>
                            <td align="center"><strong><?php echo $total_new_called; ?></strong></td>
                            <td align="center"><strong><?php echo $total_new_pending; ?></strong></td>
                            <td align="center"><strong><?php echo $total_all_followups; ?></strong></td>
                            <td align="center"><strong><?php echo $total_non_repeated_followups; ?></strong></td>
                            <td align="center"><strong><?php echo $tot_pend_followup; ?></strong></td>
                        	<td align="center"><strong><?php echo $tot_called_followup; ?></strong></td>
                            <td align="center"><strong><?php echo $total_invalid; ?></strong></td>
                            <td align="center"><strong><?php echo $total_rep_walkin; ?></strong></td>
                            <td align="center"><strong><?php echo $total_walkin; ?></strong></td>
                        	<td align="center"><strong><?php echo $total_enrolled; ?></strong></td>
                            <td align="center"><strong><?php echo $total_upgrade; ?></strong></td>
                            <td align="center"><strong><?php echo $total_downpayment; ?></strong></td>
                            <td align="center"><strong><?php echo $total_installment; ?></strong></td>
                            <td align="center"><strong><?php echo $total_amount; ?></strong></td>
                     		</tr>
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
                              </form>
  <?php 					} 
						}
	  
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';?>
      
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

<?php 
/*if($_SESSION['type']=='S')
{
	?>
    <script>
	getstaff('Pune');
	</script>
	<?php
}*/
?>
<!--footer start-->
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
