<?php include 'inc_classes.php';?>
<?php
$subject_id=$_POST['subject_id'];
//$action=$_POST['action'];
//if($action=="report_courc")
//{
	echo '<select id="unit_id" name="unit_id" class="input_select" style="width:200px" >';
	$sel_name1= "select topic_id FROM `topic_map` WHERE 1 and subject_id='".$subject_id."' order by topic_id asc";
	$ptr1=mysql_query($sel_name1);
	while($fetch_name1=mysql_fetch_array($ptr1))
	{
		$sel_name="select topic_id, topic_name FROM topic WHERE 1 and topic_id='".$fetch_name1['topic_id']."'";
		$ptr=mysql_query($sel_name);
		
		while($fetch_name=mysql_fetch_array($ptr))
		{
			if($fetch_name['topic_id']==$fetch['topic_id'])
			{
				$sel='selected="selected"';
			}
			?>
			<option value ="<?php echo $fetch_name['topic_id'] ?>"  > <?php echo $fetch_name['topic_name'] ?> </option>
			<?php
		}
		//}else{
	}
	echo '</select>';
?>