<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Daily Attendance</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='206'";
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
    <link rel="stylesheet" href="js/chosen.css" />
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
		if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
					//alert("hi");
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
		function get_staff(branch_name)
		{
			var prod_data="action=get_staff_for_line&branch_name="+branch_name;
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
    <?php 
    if($_POST['formAction'])
    {

        if($_POST['formAction']=="delete")
        {
            for($r=0;$r<count($_POST['chkRecords']);$r++)
            {
                $del_record_id=$_POST['chkRecords'][$r];
                $sql_query= "SELECT admin_id FROM ".$GLOBALS["pre_db"]."site_setting where admin_id ='".$del_record_id."'";
                if(mysql_num_rows($db->query($sql_query)))
                {
                    "<br>".$sql_query= "SELECT name FROM site_setting where admin_id ='".$del_record_id."' ";              
                    $query=mysql_query($sql_query);
                    $fetch=mysql_fetch_array($query);
                        
                    "<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
                    $query=mysql_query($insert);       
                                                            
                    $delete_query="delete from ".$GLOBALS["pre_db"]."site_setting where admin_id='".$del_record_id."'";
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
                                        Ok: function() { $( this ).dialog( "close" );}
                                        }
                    });
                });
            </script>
            <?php                            
    	}                       
    }

    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
    {
        $del_record_id=$_REQUEST['record_id'];
        $sql_query= "SELECT admin_id FROM ".$GLOBALS["pre_db"]."site_setting where admin_id='".$del_record_id."'";
        if(mysql_num_rows($db->query($sql_query)))
        {
            "<br>".$sql_query= "SELECT name FROM site_setting where admin_id ='".$del_record_id."' ";              
            $query=mysql_query($sql_query);
            $fetch=mysql_fetch_array($query);
                
            "<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
            $query=mysql_query($insert);                        
            $delete_query="delete from ".$GLOBALS["pre_db"]."site_setting where admin_id='".$del_record_id."'";
            $db->query($delete_query);

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
    <table cellspacing="0" cellpadding="0" class="table" width="95%">
        <tr class="head_td">
            <td colspan="16">
                <form method="get" name="search">
	                <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
                        <tr>
                            <td class="width5"></td>
                            <td width="20%">
                                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                    <option value="">-Operation-</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </td>
                            <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{
								?>
								<td style="width: 10%;">Select branch</td> 
								<td colspan="2" align="left" style="padding-left:0px;width: 15%;">
								<?php
								$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
								$query_branch = mysql_query($sel_branch);
								$total_Branch = mysql_num_rows($query_branch);
								echo '<select id="branch_name" name="branch_name" onchange="get_staff(this.value);">';
								while($row_branch = mysql_fetch_array($query_branch))
								{
									$sel='';
                                    if($row_branch['branch_name']==$_GET['branch_name'])
                                    {
                                        $sel='selected="selected"';
                                    }
                                    if($_GET['branch_name']=='' && $row_branch['branch_name']=='Pune')
                                    {
                                        $sel='selected="selected"';
                                    }
									?>
									<option <?php echo $sel; ?> value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];  ?>" > <?php echo $row_branch['branch_name']; ?> 
									</option>
									<?php
								}
								echo '</select>';
								?>
								</td>
								<?php 
							}
							else 
							{
								?>
								<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name'];?>" /> 
								<?php 
							}?>
							<td width="20%">
								<table id="staff_name" width="100%">
									<tr>
										<td width="20%">
										<select id="staff_id" name="staff_id">
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
													$selected='';
													if($data['admin_id']==$_REQUEST['staff_id'])
													{
														$selected='selected="selected"';
													}
													
													?>
													<option <?php echo $selected; ?> value="<?php if($_POST['staff_id']) echo $_POST['staff_id']; else echo $data['admin_id']; ?>" ><?php echo $data['name']; ?></option>
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
                            <td width="10%" align="center"><input type="text" name="on_date" class="input_text datepicker" placeholder="Date"  id="on_date" title="Date" value="<?php if($_REQUEST['on_date']!="Date") echo $_REQUEST['on_date'];?>">
                            </td>
                            <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                            <td width="20%"></td>
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
        		</form>	
    		</td>
  		</tr>
		<?php
		
		if($_REQUEST['keyword']!="Keyword")
			$keyword=trim($_REQUEST['keyword']);
		if($keyword !='')
		{                            
		   $pre_keyword=" and (name like '%".$keyword."%' or  username like '%".$keyword."%' or  email like '%".$keyword."%' )";
		}                            
		else
		{
			$pre_keyword="";
		}

		if($_REQUEST['on_date'] && $_REQUEST['on_date']!=="0000-00-00" && $_REQUEST['on_date']!="From Date")
		{
			$frm_date=explode("/",$_REQUEST['on_date']);
			$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
			$date_for_month=$frm_date[2]."-".$frm_date[1];
			$start_date=$frm_dates;
			$added_date=" and DATE(date) ='".date('Y-m-d',strtotime($frm_dates))."'";
			$month=" and month ='".date('m',strtotime($frm_dates))."'";
			$year=" and year ='".date('Y',strtotime($frm_dates))."'";
		}
		else
		{
			$added_date=" and DATE(date) ='".date('Y-m-d',strtotime('-1 days'))."'";
			$month=" and month ='".date('m',strtotime('-1 days'))."'";
			$year=" and year ='".date('Y',strtotime('-1 days'))."'";
			$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
		}
		
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
				$search_cm_id=" and cm_id='2'";
			}
		}
		
		if($_REQUEST['staff_id'])
		{
			$staff_ids=$_REQUEST['staff_id'];
			$where_staff=" and employee_id ='".$staff_ids."'";
		}
		else 
			$where_staff="";
			
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

		if($_GET['orderby']=='course_name' )
			$img1 = $img;
		if($_GET['order'] !='' && ($_GET['orderby']=='course_name'))
		{
			$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
			$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
		}
		else
			$select_directory='order by admin_id desc';                      
			
		$sql_query= "select * from pr_daily_attendance where 1 ".$added_date." ".$where_staff." ".$month." ".$year." ".$_SESSION['where']." ".$search_cm_id." group by staff_id"; 
		$ptr_query=mysql_query($sql_query);
		$no_of_records=mysql_num_rows($ptr_query);
		if($no_of_records)
		{
			$bgColorCounter=1;
			//$_SESSION['show_records'] = 10;
			$query_string='&keyword='.$keyword;
			//$query_string1=$query_string.$date_query;
		   	// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
			//$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
			//$all_records= $pager->paginate();
			?>
			<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
			<input type="hidden" name="formAction" id="formAction" value=""/>
			<tr class="grey_td" >
				<?php if($_SESSION['type']=='S' ||  $edit_access='yes')
                {
                    ?>
                    <!--<td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
                    <?php 
                } ?>
                <td width="4%" align="center"><strong>Sr. No.</strong></td>
                <td width="12%" align="center"><strong>Staff Name</strong></td>
                <td width="10%" align="center"><strong>Punch In</strong></td>
                <td width="9%" align="center"><strong>Punch Out</strong></td>
                <td width="7%" align="center"><strong>Total Hours</strong></td>
            </tr>
			<?php
			$t=1;
			while($val_query1=mysql_fetch_array($ptr_query))
			{
				/*if($bgColorCounter%2==0)
					$bgcolor='class="grey_td"';
				else
					$bgcolor="";                
				$listed_record_id=$val_query['attendence_id'];
				include "include/paging_script.php";
				echo '<tr '.$bgcolor.' >';
				if($_SESSION['type']=='S' ||  $edit_access='yes')
				{
					echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
				}*/
				
				$staff="select name,attendence_id from site_setting where attendence_id='".$val_query1['staff_id']."' ".$_SESSION['where']." ".$search_cm_id." ";
				$staff1 = mysql_query($staff);
				if(mysql_num_rows($staff1))
				{
					$staff_name = mysql_fetch_array($staff1);
				
					$tot_seconds = 0;
					$ex_seconds=0;
					$tot_full_day=0;
					$tot_half_day=0; 
					$tot_quarter_day=0; 
					$tot_onethird_day=0;
					$tot_present_day=0;
					$day_totals=0;
										
					$select_exc1 ="select * from pr_daily_attendance where 1 and staff_id='".$val_query1['staff_id']."' ".$_SESSION['where']." ".$added_date." ".$month." ".$year." ".$search_cm_id." order by staff_id,date asc";
					$ptr_fs1 = mysql_query($select_exc1);
					$tot_present_day +=mysql_num_rows($ptr_fs1);
					$val_query = mysql_fetch_array($ptr_fs1);
					
					$date =$todays_date;
					
					$att_date=date("d-M-Y", strtotime($todays_date));//$d.'-'.$pr_month.''.$year;
					//Set this to FALSE until proven otherwise.
					$weekendDay = false;
					//Get the day that this particular date falls on.
					$day = date("D", strtotime($date));
					//Check to see if it is equal to Sat or Sun.
					/*if($day == 'Sun'){
						//Set our $weekendDay variable to TRUE.
						//$weekendDay = true;
						$datestyle="style='background-color:#FF6262;'";
					}
					else if($day == 'Sat'){
						//Set our $weekendDay variable to TRUE.
						//$weekendDay = true;
						$datestyle="style='background-color:#FBF882;'";
					}
					else{
						$datestyle="";
					}*/
					
					echo $message ='<tr bgcolor="#DCF0F8">
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$t.'</td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$staff_name['name'].'</td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$val_query['punch_in'].'</td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$val_query['punch_out'].'</td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$val_query['total_hrs'].'<input type="hidden" name="floor_id'.$t.'" id="floor_id'.$t.'" value="'.$val_query['attendance_id'].'" /><input type="hidden" name="days" id="days" value="'.$val_query['days'].'" /><input type="hidden" name="floor_id'.$t.'" id="floor_id'.$t.'" value="'.$val_query['attendance_id'].'" /><input type="hidden" name="days" id="days" value="'.$val_query['days'].'" /></td>';
						
						if($val_query['late_marks']==0) $lt=''; else  $lt=$val_query['late_marks']; 
						/*$message .='<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.' id="chk_late_mark_'.$val_query['attendance_id'].'"><div ondblclick="return editColumn('.$val_query['attendance_id'].',"late_mark")" id="edit_late_mark_'.$val_query['attendance_id'].'">'.$lt.'&nbsp;&nbsp;&nbsp;</div></td>';*/
						//$tot_hr +=$val_query['total_hrs'];
						$tot_hr=$val_query['total_hrs'].':00';
						$extra_hr =$val_query['extra_hrs'].':00';
						$day_totals +=$val_query['day_total']; 
						$total_till_date=$val_query['total_till_date'];
						$tot_late_mark +=$val_query['late_marks'];
						//======Total hours========			  	
						list($hour,$minute,$second) = explode(':', $tot_hr);
						$tot_seconds += $hour*3600;
						$tot_seconds += $minute*60;
						$tot_seconds += $second;
						//======Extra Hours====
						list($exhour,$exminute,$exsecond) = explode(':', $extra_hr);
						$ex_seconds += $exhour*3600;
						$ex_seconds += $exminute*60;
						$ex_seconds += $exsecond;
						//========TOTAL Full DAY====
						if($val_query['full_day']!='')
						{
							$tot_full_day +=1;
						}
						//========TOTAL Half DAY====
						if($val_query['half_day']!='')
						{
							$tot_half_day +=1;
						}
						//========TOTAL Quarter DAY====
						if($val_query['quarter_day']!='')
						{
							$tot_quarter_day +=1;
						}
						//========TOTAL OneThird DAY====
						if($val_query['one_third']!='')
						{
							$tot_onethird_day +=1;
						}
						//$message .='';
					echo $message ='</tr>';
					 
					$t++;
					//}
					//=====Calc Total Hours=======
					$tohours = floor($tot_seconds/3600);
					$tot_seconds -= $tohours*3600;
					$tominutes  = floor($tot_seconds/60);
					$tot_seconds -= $tominutes*60;
					$tot_hours="{$tohours}:{$tominutes}:{$tot_seconds}";
					//=====Calc Extra hours=======
					$ext_hours = floor($ex_seconds/3600);
					$ex_seconds -= $ext_hours*3600;
					$ext_minutes  = floor($ex_seconds/60);
					$ex_seconds -= $ext_minutes*60;
					$extra_hours="{$ext_hours}:{$ext_minutes}:{$ex_seconds}";
					
					/*$message .='<tr bgcolor="#C7DAF1">
						<td align="center" style="border:1px solid #CCC" class="td1 td2" colspan="3">Total</td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2">'.$tot_hours.'</td>';*/
						//$message .='';
					//$message .='</tr>';
				}
				/*echo '</tr>';
				$bgColorCounter++;*/
			}
			?>
			<!--<tr class="head_td">
    			<td colspan="16">
       				<table cellspacing="0" cellpadding="0" width="100%">
            			<tr>
						<?php
                        /*if($no_of_records>10)
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
                        echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';*/
                        ?>
            			</tr>
        			</table>                         
    			</td>
    		</tr>-->
    		</form>
			<?php 
		} 
		else
			echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No course found related to your search criteria, please try again</div><br></td></tr>';?>
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
<script>
branch_name=document.getElementById('branch_name').value;
get_staff(branch_name);
</script>
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>