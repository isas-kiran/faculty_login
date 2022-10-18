<?php include 'inc_classes.php';
$action = $_POST['action'];
if($action=='get_batch_details')
{
	?>
	<select name="course_batch_id" id="course_batch_id" class="validate[required] input_select" style="width:400px">
	<option value=""> Select Batch</option>
	<?php
	$select_cb="select * from course_batch_mapping where 1 order by c_b_id desc";
	$ptr_cb=mysql_query($select_cb);
	while($data_cb=mysql_fetch_array($ptr_cb))
	{               
		$sel_staff="select name from site_setting where admin_id='".$data_cb['staff_id']."'";
		$ptr_staff=mysql_query($sel_staff);
		$data_staff=mysql_fetch_array($ptr_staff);

		$sel_course="select course_name from courses where course_id='".$data_cb['course_id']."'";
		$ptr_course=mysql_query($sel_course);
		$data_course=mysql_fetch_array($ptr_course);
		
		echo '<option '.$sel.' value='.$data_cb['c_b_id'].'>'.$data_cb['batch_name'].'&nbsp;&nbsp;('.$data_course['course_name'].')&nbsp;-&nbsp;('.$data_staff['name'].')</option>';
	} 
	?>
	</select>
	<?php
}
?>