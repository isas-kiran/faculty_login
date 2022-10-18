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
                            <td width="10%" align="center"><input type="text" name="on_date" class="input_text datepicker" placeholder="Date"  id="on_date" title="Date" value="<?php if($_GET['on_date']!="") echo $_GET['on_date']; else echo date('d/m/Y')?>">
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
			$c_date=date('Y-m-d',strtotime($frm_dates));
			$c_month=date('m',strtotime($frm_dates));
			$c_year=date('Y',strtotime($frm_dates));
			$added_date=" and DATE(date) ='".date('Y-m-d',strtotime($frm_dates))."'";
			$month=" and month ='".date('m',strtotime($frm_dates))."'";
			$year=" and year ='".date('Y',strtotime($frm_dates))."'";
		}
		else
		{
			$c_date=date('Y-m-d');
			$c_month=date('m',strtotime('-1 days'));
			$c_year=date('Y',strtotime($c_date));
			
			$todays_date=date('Y-m-d',strtotime('-1 days'));
			$added_date=" and DATE(date) ='".date('Y-m-d',strtotime('-1 days'))."'";
			$month=" and month ='".date('m',strtotime('-1 days'))."'";
			$year=" and year ='".date('Y',strtotime('-1 days'))."'";
			$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
		}
		
		$search_cm_id='';
		$cm_id=$_SESSION['cm_id'];
		if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			if($_REQUEST['branch_name']!='')
			{
				$branch_name=$_REQUEST['branch_name'];
				$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
				$ptr_cm_id=mysql_query($select_cm_id);
				$data_cm_id=mysql_fetch_array($ptr_cm_id);
				$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
				$cm_id=$data_cm_id['cm_id'];
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
			
		//$sql_query= "select * from pr_daily_attendance where 1 ".$added_date." ".$where_staff." ".$month." ".$year." ".$_SESSION['where']." ".$search_cm_id." group by staff_id"; 
		
		
		
		$monthArray = range(1, 12);
		$currentMonth =date('Y').'-'.date('m').date('d');
		$prv_month=Date('F');//Date('F', strtotime('-1 month',strtotime($currentMonth)));
		$prv_month1=Date('m');//Date('m', strtotime('-1 month',strtotime($currentMonth)));
		$month=$prv_month1;
		$days = cal_days_in_month(CAL_GREGORIAN, $c_month, $c_year); // 31
		
		$sel_serv_id="select service_tag_id from biometric_device where 1 ".$_SESSION['where']." ".$search_cm_id." ";
		$ptr_serv_id=mysql_query($sel_serv_id);
		$data_serv_id=mysql_fetch_array($ptr_serv_id);
		$service_tag_id=$data_serv_id['service_tag_id'];
		
		$sql_query= "select DISTINCT(UserID) from pr_pune_biometric_attendance where 1 ".$_SESSION['where']." ".$search_cm_id." and ServiceTagId='".$service_tag_id."' and year='".$c_year."' and month='".$c_month."' and DATE(PunchTime)='".$c_date."' order by UserID asc";
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
				
				//======================================================
				$staff_att_id=$val_query1['UserID'];
		
				$sel_admin="select admin_id from site_setting where attendence_id='".$staff_att_id."' and cm_id='".$cm_id."'";
				$ptr_admin_id=mysql_query($sel_admin);
				$data_admin_id=mysql_fetch_array($ptr_admin_id);
				$employee_id=$data_admin_id['admin_id'];
				
				$currentMonth =$c_year.'-'.$c_month.'-01';
				$pr_month=Date('Y-m-d',strtotime($currentMonth));
				$first_day_this_month='01-'.$c_month.'-'.$c_year;
				$last_day_this_month=$days.'-'.$c_month.'-'.$c_year;
				$curr_date='';
				$total_day =0;
				
				$sel_staff="select name,attendence_id from site_setting where attendence_id='".$val_query1['UserID']."' and cm_id='".$cm_id."'";
				$ptr_staff1 = mysql_query($sel_staff);
				if(mysql_num_rows($ptr_staff1))
				{
					$staff="select name,attendence_id from site_setting where attendence_id='".$staff_att_id."' ".$_SESSION['where']." ".$search_cm_id." ";
					$staff1 = mysql_query($staff);
					$staff_name=mysql_fetch_array($staff1);
					
					$select_user="select * from pr_pune_biometric_attendance where cm_id='".$cm_id."' and ServiceTagId='".$service_tag_id."' and year='".$c_year."' and month='".$c_month."' and UserID='".$val_query1['UserID']."' and DATE(PunchTime)='".$c_date."' order by PunchTime asc";
					$ptr_chk_ext=mysql_query($select_user);
					if($tot=mysql_num_rows($ptr_chk_ext))
					{
						$c_in=0;
						$c_out=0;
						$tot_ckout=0;
						$tot_hrs=0;
						$curr_date='';
						$t=0;
						$check_in=array();
						$check_out=array();
						$hrs_min='';
						$ints=0;
						$in_ts='';
						$out_ts='';
						$punch_out='';
						$punch_in='';
						while($data_user_att=mysql_fetch_array($ptr_chk_ext))
						{
							$curr_date=$data_user_att['PunchTime'];
							if($data_user_att['AttendanceType']=='CheckIn')
							{
								$check_in[$c_in] = strtotime($data_user_att['PunchTime']);
								if($ints<=0) //check 1st of record PUNCH IN only
								{
									$in_ts= date('H:i',strtotime($data_user_att['PunchTime'])); // for inserting in DB
									$ints=1;
								}
								$c_in++;
							}
							else if($data_user_att['AttendanceType']=='CheckOut')
							{
								$check_out[$c_out] =strtotime($data_user_att['PunchTime']);
								$out_ts=date('H:i',strtotime($data_user_att['PunchTime']));// for inserting in DB
								$c_out++;
								$tot_ckout++;
							}							
							$t++;
						}
						if($out_ts)
						{
							$punch_out=$out_ts;//date('H:i',$check_out[$chk]);
						}
						if($in_ts)
						{
							$punch_in=$in_ts;//date('H:i',$check_in[$chk]);
						}
						//echo "<br/> totals-  ".$tot_ckout;
						$late_m =0;
						$day_tot=0;
						$e_h=0;
						$extra_hr=0;
						$full_day='';
						$onethird_day='';
						$half_day='';
						$quarter_day='';
						for($chk=0;$chk<$tot_ckout;$chk++)
						{
							$out=$check_out[$chk];
							$in=$check_in[$chk];
							if($out >0 && $in >0)
							{
								$tot_hrs +=($out - $in);
								$hrs_min=gmdate("H:i", $tot_hrs);
								if($tot_hrs > 32400)
								{
									$e_h=intval($tot_hrs - 32400);
									$extra_hr=gmdate("H:i", $e_h);
								}
								
								if($tot_hrs < 31500 && $tot_hrs >=30600)
								{
									$late_m=1;
								}
								if($tot_hrs >= 31500)
								{
									$full_day='P';
									$day_tot=1;
									$total_day +=1;
								}
								if($tot_hrs >= 21600 && $tot_hrs < 31500)
								{
									$onethird_day='P';
									$day_tot=0.75;
									$total_day +=0.75;
								}
								if($tot_hrs >= 14500 && $tot_hrs < 21600)
								{
									$half_day='P';
									$day_tot=0.5;
									$total_day +=0.5;
								}
								if($tot_hrs <= 14500)
								{
									$quarter_day='P';
									$day_tot=0.25;
									$total_day +=0.25;
								}
							}
						}
						if($tot==$t)
						{
							$ins_attendace="INSERT INTO `pr_daily_attendance`(`employee_id`,`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$employee_id."','".$staff_att_id."','".$year."','".$month."','".$days."','".$todays_date."','".$in."','".$out."','".$punch_in."','".$punch_out."','".$hrs_min."','".$extra_hr."','".$branch_name1."','".$full_day."','".$half_day."','".$quarter_day."','".$onethird_day."','".$day_tot."','".$total_day."','".$late_m."','0','69','".$cm_id."')";
							$ptr_ins=mysql_query($ins_attendace);
							//echo "<br/>-> ".$ins=mysql_insert_id();
							
							
							echo $message ='<tr bgcolor="#DCF0F8">
							<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$t.'</td>
							<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$staff_name['name'].'</td>
							<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$punch_in.'</td>
							<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$punch_out.'</td>
							<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$hrs_min.'</td>';
							//}
						}
					}
					else
					{
						$insert_attendace="INSERT INTO `pr_daily_attendance`(`employee_id`,`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$employee_id."','".$staff_att_id."','".$year."','".$month."','".$days."','".$todays_date."','','','','','','','Pune','  ','  ','  ','  ','0','0',' ','0','69','".$cm_id."')";
						$ptr_insert=mysql_query($insert_attendace);
						
						echo $message ='<tr bgcolor="#DCF0F8">
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$t.'</td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'>'.$staff_name['name'].'</td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'></td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'></td>
						<td align="center" style="border:1px solid #CCC" class="td1 td2" '.$datestyle.'></td>';
					}
				}
				//====================================================================
			}
			?>
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