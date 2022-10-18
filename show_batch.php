<?php session_start();
 include 'inc_classes.php';
?>
<?
if($_POST['show_batch'] && $_POST['course_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
		$course_id = $_POST['course_id'];
		$select_sales_representative=" select batch_id,course_id,batch_name,batch_time from course_batches where course_id ='".$_POST['course_id']."' ";
		$ptr_faculty = mysql_query($select_sales_representative);
?>
<table>
<tr>
<td>
<select name="batch_id" class="input_select">
<option value="">Select Batch </option>
<?php 
while($data_faculty = mysql_fetch_array($ptr_faculty))
{ 
$batch_name=$data_faculty['batch_name'];
$batch_time="(".$data_faculty['batch_time'].")";
$batch_id=$data_faculty['batch_id'];
?>
<option value="<?php echo $batch_id; ?>" ><?php echo $batch_name; echo $batch_time;  ?></option>
<?php
 }
?>

</select>
</td>
</tr>
</table>
<?
}
?>

