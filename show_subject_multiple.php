<?php session_start();
 include 'inc_classes.php';
?>
<?
if($_POST['show_subject'] && $_POST['subject']) //$_POST:-because of that we can use this  in to the function for ajax 
{
		$subject = $_POST['subject'];
		$select_sales_representative=" select  subject_id,name,sub_fees from subject  where  course_id ='".$_POST['subject']."' ";
		$ptr_faculty = mysql_query($select_sales_representative);
?>
<table>
<?php 
 $j=1;
//$counter="1";
 $count_fee='';
while($data_faculty = mysql_fetch_array($ptr_faculty))
{ 
echo '<tr>';
echo '<td> '.$data_faculty['name'].'<td>';
echo '<td> Subject   Fees -'.$data_faculty['sub_fees'].' <td>';
$count_fee=$count_fee+$data_faculty['sub_fees'];
//echo '<td><input type="checkbox" name="subject_id'.$j.'" value='.$data_faculty['subject_id'].' /> <td>';
?>
<input type="checkbox" name= "subject_id<? echo $j;?>" style="text-align:right"  value="<? echo $data_faculty['subject_id']; ?>"  id="<? echo $j;?>" class="myCheckbox"
onclick="counter_check(<?php echo $j; ?>);" />
<input type="hidden" value="<?php echo $data_faculty['sub_fees'] ?>" id="fees_<?php echo $j; ?>"  />
<?php
echo '<tr>';
 $j++; }
?>
</table>
 <input type="hidden" name="total_sub_fee"  value="0<? // echo $count_fee ;?>"  id='sub_fee' >
 <input type="hidden" name="total_checked_questions" id="total_checked_questions" value="0" />
 <input type="hidden" name="total_sub"  value="<? echo $j-1;?>"  id='trotot' >
 <?
}
?>