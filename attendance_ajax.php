<?php include 'inc_classes.php';
 ?>
<style>
.table1, .th1, .td1 {
    border: 1px solid;
    border-collapse: collapse;

    padding: 4px;
	font-size:12px;
}
.td2 {
   text-align:center;
}
input {
	text-align:center;
}
</style>
<hr>
</br>
<center>
<!-- <input type="button" class="input_btn" onClick="PrintDiv('example');" value="Print" name="" style="width:10%;" /> -->

<?php
if($_REQUEST['branch_name']!='')
{
	$sel_br="select cm_id from site_setting where branch_name='".$_POST['branch_name']."'";
	$ptr_br=mysql_query($sel_br);
	$data_br=mysql_fetch_array($ptr_br);
	
	$where_branch_name=" and cm_id='".$data_br['cm_id']."' ";
}
else
{
	$where_branch_name=" and cm_id='".$_SESSION['cm_id']."'";
}

if($_REQUEST['staff']=='')
{
	$select_exc="select * from pr_import_attendance where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' ".$where_branch_name." group by staff_id";
}
else
{
	$select_exc="select * from pr_import_attendance where month='".$_REQUEST['month']."' and year='".$_REQUEST['year']."' and employee_id='".$_REQUEST['staff']."' ".$where_branch_name." group by staff_id order by date asc";
}
$ptr_fs = mysql_query($select_exc);

$payment_done ="select * from pr_staff_salary_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."' ".$where_branch_name." AND payment_action=1";
$payment = mysql_query($payment_done);
if(mysql_num_rows($payment))
{
	$disable="disabled";
	$msg="**** Salary Allready Done ****";
}
else
{
	$disable="";	
}


if(mysql_num_rows($ptr_fs)) 
{
	?>
	<form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
	<p style="color:green;font-size:15px;"><b> <?php echo $msg; ?> </b></p>
	<table id="example" class="table1" width="95%" cellspacing="0" style="margin-left: 0px;">
        <thead>
            <tr>
                <th class="th1">Date</th>
                <th class="th1">Punch In</th>
                <th class="th1">Punch Out</th>
                <th class="th1">Total Hrs</th>
                <th class="th1">Extra Hrs</th>
                <th class="th1">Full Day</th>
                <th class="th1">Half Day</th>
                <th class="th1">Quarter</th>
                <th class="th1">One Third</th>
                <th class="th1">Two Third</th>
                <th class="th1">Over (1.25)</th>
                <th class="th1">over (1.5)</th>
                <th class="th1">over (2)</th>
                <th class="th1">Day Total</th> 
                <th class="th1">Total Till Date</th>
                <th class="th1">Late Marks</th> 
            </tr>
	</thead>
	<tbody>	
	<?php
	$t=1;
	while($val_query1 = mysql_fetch_array($ptr_fs))
	{ 
		$staff="select name,attendence_id from site_setting where attendence_id='".$val_query1['staff_id']."' and system_status='Enabled' ".$where_branch_name." ";
		$staff1 = mysql_query($staff);
		if(mysql_num_rows($staff1))
		{
			$staff_name = mysql_fetch_array($staff1);
			?>
			<tr>
			<td class="td1 td2" colspan="17" style="background-color:#F2F2F2;"><b style="color:green;font-size:14px;float:left;"><?php echo $staff_name['name'];  ?></b></td></tr>
			<?php
			//$number=mysql_num_rows($ptr_fs);
			//$no=$number%$val_query['days'];
			//if ($number != 0 && $number%$val_query['days'] == 0)
			//{
			//	echo $val_query['staff_id'];
			//	}
			$year=$_REQUEST['year'];
			$month=$_REQUEST['month'];
			$currentMonth =$year.'-'.$month.'-01';
			$pr_month=Date('M',strtotime($currentMonth));
			$first_day_this_month='01-'.$pr_month.'-'.$year;
			$last_day_this_month=$val_query1['days'].'-'.$pr_month.'-'.$year;
			
			$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
			$tot_seconds = 0;
			$ex_seconds=0;
			$tot_full_day=0;
			$tot_half_day=0; 
			$tot_quarter_day=0; 
			$tot_onethird_day=0;
			$tot_present_day=0;
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
				$pr_month=Date('M',strtotime($curr_date));
				$select_exc1 ="select * from pr_import_attendance where DATE(date)='".$curr_date."'  AND staff_id='".$val_query1['staff_id']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' ".$where_branch_name." order by staff_id,date asc";
				//$select_exc1 ="select * from pr_import_attendance where date>='".$first_day_this_month."' AND date<='".$last_day_this_month."' AND staff_id='".$val_query1['staff_id']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND branch_name='".$_REQUEST['branch_name']."' order by staff_id,date asc";
				$ptr_fs1 = mysql_query($select_exc1);
				$tot_present_day +=mysql_num_rows($ptr_fs1);
				$val_query = mysql_fetch_array($ptr_fs1);
				//while($val_query = mysql_fetch_array($ptr_fs1))
				//{
					//Date in YYYY-MM-DD format.
					$date =$curr_date;
					$att_date=$d.'-'.$pr_month.''.$year;
					//Set this to FALSE until proven otherwise.
					$weekendDay = false;
					//Get the day that this particular date falls on.
					$day = date("D", strtotime($date));
					//Check to see if it is equal to Sat or Sun.
					if($day == 'Sun'){
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
					}
					?>
					<tr>
						<td class="td1 td2" <?php echo $datestyle; ?>><?php echo $att_date;  ?></td>
						<td class="td1 td2" <?php echo $datestyle; ?>><?php echo $val_query['punch_in']; ?></td>
						<td class="td1 td2" <?php echo $datestyle; ?>><?php echo $val_query['punch_out']; ?></td>
						<td class="td1 td2" <?php echo $datestyle; ?>><?php echo $val_query['total_hrs']; ?></td>
						<td class="td1 td2" <?php echo $datestyle; ?>><?php echo $val_query['extra_hrs']; ?></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_full_day_<?php echo $val_query['attendance_id']; ?>" ><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'full_day')" id="edit_full_day_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['full_day']; ?> &nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_half_day_<?php echo $val_query['attendance_id']; ?>" ><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'half_day')" id="edit_half_day_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['half_day']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_quarter_day_<?php echo $val_query['attendance_id']; ?>" ><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'quarter_day')" id="edit_quarter_day_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['quarter_day']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_one_third_<?php echo $val_query['attendance_id']; ?>" ><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'one_third')" id="edit_one_third_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['one_third']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_two_third_<?php echo $val_query['attendance_id']; ?>" ><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'two_third')" id="edit_two_third_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['two_third']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_over1_<?php echo $val_query['attendance_id']; ?>" ><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'over1')" id="edit_over1_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['over1']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_over2_<?php echo $val_query['attendance_id']; ?>"><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'over2')" id="edit_over2_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['over2']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_over3_<?php echo $val_query['attendance_id']; ?>" ><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'over3')" id="edit_over3_<?php echo $val_query['attendance_id']; ?>"><?php echo $val_query['over3']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<td class="td1 td2" <?php echo $datestyle; ?> ><?php echo $val_query['day_total']; ?></td>
						<td class="td1 td2" <?php echo $datestyle; ?> ><?php echo $val_query['total_till_date']; ?></td>
						<td class="td1 td2" <?php echo $datestyle; ?> id="chk_late_mark_<?php echo $val_query['attendance_id']; ?>"><div ondblclick="return editColumn(<?php echo $val_query['attendance_id'];?>,'late_mark')" id="edit_late_mark_<?php echo $val_query['attendance_id']; ?>"><?php if($val_query['late_marks']==0) echo ''; else echo $val_query['late_marks']; ?>&nbsp;&nbsp;&nbsp;</div></td>
						<?php
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
						if($val_query['full_day'] ==='P')
						{
							$tot_full_day +=1;
						}
						//========TOTAL Half DAY====
						if($val_query['half_day'] ==='P')
						{
							$tot_half_day +=1;
						}
						//========TOTAL Quarter DAY====
						if($val_query['quarter_day']==='P')
						{
							$tot_quarter_day +=1;
						}
						//========TOTAL OneThird DAY====
						if($val_query['one_third'] ==='P')
						{
							$tot_onethird_day +=1;
						}
						?>
						<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id<?php echo $t; ?>" value="<?php echo $val_query['attendance_id'] ?>" />
						<input type="hidden" name="days" id="days" value="<?php echo $val_query['days'] ?>" />
					</tr>
					<?php $t++;
				//}
			}
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
			?>
			<tr>
				<td class="td1 td2" colspan="3">Total</td>
				<td class="td1 td2"><?php echo $tot_hours;  ?></td>
				<td class="td1 td2"><?php echo $extra_hours;  ?></td>
				<td class="td1 td2"><?php echo $tot_full_day; ?></td>
				<td class="td1 td2"><?php echo $tot_half_day; ?></td>
				<td class="td1 td2"><?php echo $tot_quarter_day; ?></td>
				<td class="td1 td2"><?php echo $tot_onethird_day; ?></td>
				<td class="td1 td2"></td>
				<td class="td1 td2"></td>
				<td class="td1 td2"></td>
				<td class="td1 td2"></td>
				<td class="td1 td2"><?php echo $day_totals;  ?></td>
				<td class="td1 td2"><?php echo $total_till_date;  ?></td>
				<td class="td1 td2"><?php echo $tot_late_mark;  ?></td>
				
				<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id<?php echo $t; ?>" value="<?php echo $val_query['attendance_id'] ?>" />
				<input type="hidden" name="days" id="days" value="<?php echo $val_query['days'] ?>" />
			</tr>
			<?php
		}
	}
	?>
	</tbody>  
	</table><?php
}
else 
{ 
	?>
	<p Style="font-size:20px;color:red;">No Record Found</p>
	<?php 
}
?>
<script type="text/javascript">
	function PrintDiv(elem) {
		$(".table1").css( "border", "1px solid" );
		$(".td1").css( "border", "1px solid" );
		$(".th1").css( "border", "1px solid" );
		$(".table1").css( "border-collapse", "collapse" );
		$(".td1").css( "border-collapse", "collapse" );
		$(".th1").css( "border-collapse", "collapse" );
		$(".table1").css( "padding", "4px" );
		$(".td1").css( "padding", "4px" );
		$(".th1").css( "padding", "4px" );
		$(".table1").css( "font-size", "12px" );
		$(".td1").css( "font-size", "12px" );
		$(".td2").css( "text-align", "center" );
		
		$("#title").remove(); 
		var originalContents = $("body").html();
		var printContents = $("#example").html();
		$("body").html(printContents);
		window.print();
		$("body").html(originalContents);
		return false;
	}
</script>