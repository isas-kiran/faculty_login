<?php include 'inc_classes.php';?>
<?php
$topic_id=$_POST['topic_id'];
$sel_name1= "select subject_id FROM `topic_map` WHERE 1 and topic_id='".$topic_id."' order by topic_id asc";
$ptr1=mysql_query($sel_name1);
$fetch_name1=mysql_fetch_array($ptr1);
?>
<select id="subject_id" name="subject_id" class="input_select" onchange="select_topic(this.value)" style="width:200px">
<option value="">Select Subject</option>
<?php
	$course_domain="select cat_name,cat_id from course_domain_category ";
	$ptr_domain= mysql_query($course_domain);
	while($data_domain= mysql_fetch_array($ptr_domain))
	{
		
		echo "<optgroup label='".$data_domain['cat_name']."'>";
		$select_category = "select subject_id,name from subject where course_domain_id='".$data_domain['cat_id']."'";
		$ptr_category = mysql_query($select_category);
		while($data_category = mysql_fetch_array($ptr_category))
		{
			$sel='';
			if($fetch_name1['subject_id']==$data_category['subject_id'])
			{
				$sel='selected="selected"';
			}
			?>
			<option value="<?php echo $data_category['subject_id']?>" <?php echo $sel; ?> ><?php echo $data_category['name'] ?></option>
			<?php 
		}
		echo "</optgroup>";
	
}
?>
</select>