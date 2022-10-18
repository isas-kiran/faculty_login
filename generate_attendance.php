<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title id="title">Manage Attendance</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<!-- <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
	<!-- <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script> 
    <script language="javascript" src="js/script.js"></script>
    <script language="javascript" src="js/conditions-script.js"></script>
	<link rel="stylesheet" href="js/chosen.css" />

	<script src="js/chosen.jquery.js" type="text/javascript"></script>
	<script>
	$(document).ready(function()
    {
		$("#year").chosen({allow_single_deselect:true});
		$("#month").chosen({allow_single_deselect:true});
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
		if(isset($_POST['submit']))
		{
			$branch_name=$_POST['branch_name'];
			$staff_id=$_POST['staff_id'];
			$year=$_POST['year'];
			$month=$_POST['month'];
			
			$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
			
			$cm_id='0';
			if($_SESSION['type']=='S')
			{
				$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
				$ptr_branch=mysql_query($sel_branch);
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id=$data_branch['cm_id'];
				$branch_name1=$branch_name;
			}	
			else
			{
				$branch_name1=$_SESSION['branch_name'];
				$cm_id=$_SESSION['cm_id'];
			}
			$sel_serv_id="select service_tag_id from biometric_device where cm_id='".$cm_id."'";
			$ptr_serv_id=mysql_query($sel_serv_id);
			$data_serv_id=mysql_fetch_array($ptr_serv_id);
			$service_tag_id=$data_serv_id['service_tag_id'];
			
			$whr_staff_id="";
			$whr_staff_id_p="";
			if($staff_id>0)
			{
				$whr_staff_id=" and UserID='".$staff_id."'";
				$whr_staff_id_p=" and p.UserID='".$staff_id."'";
			}
			
			$select_att="select DISTINCT(UserID) from pr_pune_biometric_attendance p, site_setting s where p.cm_id='".$cm_id."' and p.ServiceTagId='".$service_tag_id."' and p.year='".$year."' and p.month='".$month."' and s.attendence_id=p.UserID ".$whr_staff_id_p." order by p.UserID asc ";
			$ptr_att=mysql_query($select_att);
			while($data_atte=mysql_fetch_array($ptr_att))
			{
				$staff_att_id=$data_atte['UserID'];
				
				$sel_admin="select admin_id from site_setting where attendence_id='".$staff_att_id."' and cm_id='".$cm_id."'";
				$ptr_admin_id=mysql_query($sel_admin);
				$data_admin_id=mysql_fetch_array($ptr_admin_id);
				$employee_id=$data_admin_id['admin_id'];
				
				$currentMonth =$year.'-'.$month.'-01';
				$pr_month=Date('Y-m-d',strtotime($currentMonth));
				$first_day_this_month='01-'.$month.'-'.$year;
				$last_day_this_month=$days.'-'.$month.'-'.$year;
				$curr_date='';
				$total_day =0;
				for($i=1;$i<=$days;$i++)
				{
					if($i<10)
					{
						$d='0'.$i;
					}
					else
					{
						$d=$i;
					}
					$curr_date=$year.'-'.$month.'-'.$d;
					
					$select_user="select * from pr_pune_biometric_attendance where cm_id='".$cm_id."' and ServiceTagId='".$service_tag_id."' and year='".$year."' and month='".$month."' and UserID='".$data_atte['UserID']."' and DATE(PunchTime)='".$curr_date."' order by PunchTime asc";
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
								/*if($tot_hrs > 32400) // 9 hrs
								{
									$e_h=intval($tot_hrs - 32400);
									$extra_hr=gmdate("H:i", $e_h);
								}
								
								if($tot_hrs < 31500 && $tot_hrs >30500) //8.28 to 8.45
								{
									$late_m=1;
								}
								
								if($tot_hrs >= 30500) //  > 8.28 hrs
								{
									$full_day='P';
									$day_tot=1;
									$total_day +=1;
								}
								if($tot_hrs >= 21600 && $tot_hrs < 30500) // 6 to 8.28 hrs
								{
									$onethird_day='P';
									$day_tot=0.75;
									$total_day +=0.75;
								}
								if($tot_hrs >= 14500 && $tot_hrs < 21600) //  4 to 6 hrs
								{
									$half_day='P';
									$day_tot=0.5;
									$total_day +=0.5;
								}
								if($tot_hrs <= 14500) // <4 hrs
								{
									$quarter_day='P';
									$day_tot=0.25;
									$total_day +=0.25;
								}*/
								//==============NEW code-27-10-21==============
								if($tot_hrs > 32400) // 9 hrs
								{
									$e_h=intval($tot_hrs - 32400);
									$extra_hr=gmdate("H:i", $e_h);
								}
								/*if($tot_hrs < 31500 && $tot_hrs >30500) //8.28 to 8.45
								{
									$late_m=1;
								}*/
								
								if($tot_hrs >= 14500) //  > 8.28 hrs
								{
									$full_day='P';
									$day_tot=1;
									$total_day +=1;
								}
								
								if($tot_hrs < 14500) // <4 hrs
								{
									$half_day='P';
									$day_tot=0.5;
									$total_day +=0.5;
								}
							}							
						}
						//echo "<br/>Date - ".$curr_date." Total Hours - ".$hrs_min;
						//echo "<br/>Each recor Query - ".$ins_attendace="INSERT INTO `pr_import_attendance`(`staff_id`, `year`, `month`, `days`, `date`, `punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$staff_att_id."','".$year."','".$month."','".$days."','".$curr_date."','".$in."','".$out."','".$hrs_min."','".$extra_hr."','Pune','".$full_day."','".$half_day."','".$quarter_day."','".$onethird_day."','".$day_tot."','".$total_day."','".$late_m."','0','".$_SESSION['admin_id']."','".$cm_id."')";
						//calulate Time
						
						if($tot==$t)
						{
							//insert in DB
							$ins_attendace="INSERT INTO `pr_import_attendance`(`employee_id`,`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$employee_id."','".$staff_att_id."','".$year."','".$month."','".$days."','".$curr_date."','".$in."','".$out."','".$punch_in."','".$punch_out."','".$hrs_min."','".$extra_hr."','Pune','".$full_day."','".$half_day."','".$quarter_day."','".$onethird_day."','".$day_tot."','".$total_day."','".$late_m."','0','".$_SESSION['admin_id']."','".$cm_id."')";
							$ptr_ins=mysql_query($ins_attendace);
						}
					}
					else			//inser record in database
					{
						$insert_attendace="INSERT INTO `pr_import_attendance`(`employee_id`,`staff_id`, `year`, `month`, `days`, `date`, `punch_in_timestamp`, `punch_out_timestamp`,`punch_in`, `punch_out`, `total_hrs`, `extra_hrs`, `branch_name`, `full_day`, `half_day`, `quarter_day`, `one_third`,`day_total`, `total_till_date`,`late_marks`, `extra_days`, `admin_id`, `cm_id`) VALUES ('".$employee_id."','".$staff_att_id."','".$year."','".$month."','".$days."','".$curr_date."','','','','','','','Pune','  ','  ','  ','  ','0','0',' ','0','".$_SESSION['admin_id']."','".$cm_id."')";
						$ptr_insert=mysql_query($insert_attendace);
					}
				}
			}
			//
			?><div id="statusChangesDiv" title="Record added"><center><br><p>Attendance Generated successfully</p></center></div>
				<script type="text/javascript">
                    $(document).ready(function() {
                        $( "#statusChangesDiv" ).dialog({
                                modal: true,
                                buttons: {
                                            Ok: function() { $( this ).dialog( "close" );}
                                         }
                        });
                        
                    });
                setTimeout('document.location.href="generate_attendance.php";',500);
                </script>

            <?php
			
		}
		$success=0;
		if($success==0)
		{
			?>
            <tr>
            	<td>
        			<form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
					<table border="0" cellspacing="15" cellpadding="0" width="100%">
            		<tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
                    <tr>
            		<?php 
					if($_SESSION['type']=='S')
					{ ?>
			 			<td style="width:13%;">Select branch</td> 
                		<td style="width: 80%;">
						<?php
						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<select id="branch_name" name="branch_name" onchange="get_staff(this.value);">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];  ?>" > <?php echo $row_branch['branch_name']; ?> 
							</option>
							<?
						}
						echo '</select>';
						?>
						<!--<div id="branch_name">
						</div>-->
						</td>
				
						<?php 
					}
					else 
					{ ?>
						<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name'];?>"/>						<?php 
					}?>
                    </tr>
                    <tr>
						<td width="100%" colspan="2">
                    		<table id="staff_name" width="100%">
                                <tr>
                                <td width="11%">Select Staff<span class="orange_font">*</span></td>
                                <td width="64%">
                                <select id="staff_id" name="staff_id">
                                <option value="">Select Staff</option>
                                <?php  
                                if($record_id)
                                {
                                    $sel_staff="select admin_id,attendence_id,name from site_setting where 1 and attendence_id!='' ".$_SESSION['where']." order by attendence_id asc";	 
                                    $query_staff = mysql_query($sel_staff);
                                    if($total_staff=mysql_num_rows($query_staff))
                                    {
                                        while($data=mysql_fetch_array($query_staff))
                                        {
                                            ?>
                                            <option <?php if($data['admin_id']==$row_record['employee_id']) echo "selected"; else echo "";  ?> value="<?php echo $data['admin_id']; ?>" ><?php echo $data['name']; ?></option>
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
					</tr>
                    <tr>
                        <td colspan="2">
                        
                        <table width="100%">
                        <tr>
                        <td width="15%" style="padding-left:0px;">Select Year<span class="orange_font">*</span></td>
                        <td>
                        <?php
                        $nxt=date('Y')-1;
                        $yearArray = range($nxt, 2030);
                        echo '<select required id="year" name="year" style="width:100px;">';
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
                        </td>
						<td width="15%" style="padding-left:0px;">
						<?php
                        echo 'Select Month<span class="orange_font">*</span></td><td>';
                        $monthArray = range(1, 12);
                        $currentMonth =date('Y').'-'.date('m').'-01';
                        $prv_month=Date('F', strtotime('-1 month',strtotime($currentMonth)));
                        $prv_month1=Date('m', strtotime('-1 month',strtotime($currentMonth)));
                        echo ' <select required id="month" name="month">';
                        ?>
                        <option value="<?php echo $prv_month1; ?>"><?php echo $prv_month; ?></option>
                        <?php
                        foreach ($monthArray as $month) {
                            // padding the month with extra zero
                            $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
                            // you can use whatever year you want
                            // you can use 'M' or 'F' as per your month formatting preference
                            $fdate = date("F", strtotime("2015-$monthPadding-01"));
                            echo '<option value="'.$monthPadding.'">'.$fdate.'</option>';
                        }
                        ?>
						</select>
						<td><input style="margin-right: 0px;margin-left: 0px;width:100%;" type="submit" name="submit" class="input_btn" value="Generate Attendance" /></td>
						</tr></table>
               		</tr> 
					</table>
					<div id="showdiv"></div>
					</form>
				</td>
            </tr>
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
<div id="footer"><?php require("include/footer.php");?></div>
<!--footer end-->
<script language="javascript">
function getattendance() {
	//var atype = $("#atype").val();
	var year = $("#year").val();
	var month = $("#month").val();
	var staff = $("#staff_id").val();
	var branch_name = $("#branch_name").val();
	
	if(month==''){
		alert("Please Select Month");
		return false;
	}
	if(year==''){
		alert("Please Select Year");
		return false;
	}
	if(branch_name==''){
		alert("Please Select branch name");
		return false;
	}
	//alert(branch_name);
	//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year+">>>>>>>"+branch_name);
        $.ajax({ 
	        type: 'post',
            url: 'attendance_ajax.php',
            data: { year: year,month:month,staff:staff,branch_name:branch_name },
            
        }).done(function(responseData) {
			
        $("#showdiv").html(responseData);
        }).fail(function() {
            console.log('Failed');
        });

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

<?php 
if($_SESSION['type']!="S")
{
?>
branch_name=document.getElementById('branch_name').value;
get_staff(branch_name);
<?php
}
?>
</script>



</body>



</html>



<?php $db->close();?>