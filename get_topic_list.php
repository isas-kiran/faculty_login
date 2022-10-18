<?php session_start();
include 'inc_classes.php';
$action=$_POST['action'];
$ids=$_POST['ids'];
if($action=="gettopic")
{
	$subject_id=$_POST['subject_id'];
	if($subject_id)
	{
		$select_topic="select topic_id from topic_map where subject_id='".$subject_id."' order by topic_id";
		$ptr_topic= mysql_query($select_topic);
		if(mysql_num_rows($ptr_topic))
		{
			echo '<select name="topic'.$ids.'" id="topic'.$ids.'" style="width:200px" ><option value="">Select Topic '.$ids.'</option>';
			while($data_topic=mysql_fetch_array($ptr_topic))
			{
				$sel_name="select topic_name,topic_id from topic where topic_id='".$data_topic['topic_id']."'";
				$ptr_name=mysql_query($sel_name);
				$data_name=mysql_fetch_array($ptr_name);
				
				echo "<option value='".$data_name['topic_id']."' >".addslashes($data_name['topic_name'])." </option>";
			}
			echo '</select>';
		}
	}
}
else if($action=="gettopic_content")
{
	$topic_id=$_POST['topic_id'];
	$logsheet_id=$_POST['logsheet_id'];
	if($topic_id!='')
	{
		$sel_content="select topic_content from logsheet_map where topic_id='".$topic_id."' and logsheet_id='".$logsheet_id."'";
		$ptr_content=mysql_query($sel_content);
		$data_content=mysql_fetch_array($ptr_content);
		
		echo addslashes($data_content['topic_content']);
	}
}
else if($action=="getdomain")
{
	$domain_id=$_POST['domain_id'];
	if($domain_id)
	{
		$select_sub="select subject_id,name from subject where course_domain_id='".$domain_id."' order by subject_id";
		$ptr_sub= mysql_query($select_sub);
		while($data_sub=mysql_fetch_array($ptr_sub))
		{
			echo "<option value='".$data_sub['subject_id']."' >".addslashes($data_sub['name'])." </option>";
		}
	}
}
else if($action=="get_topics")
{
	$day_id=$_POST['day_id'];
	$c_b_id=$_POST['c_b_id'];
	$topic_name='';
	$sel_day="select topic_id from batch_timetable where c_b_id='".$c_b_id."' and day='".$day_id."'";
	$ptr_day=mysql_query($sel_day);
	while($data_day=mysql_fetch_array($ptr_day))
	{
		$sele_topic="select topic_name from topic where topic_id='".$data_day['topic_id']."'";
		$ptr_topic=mysql_query($sele_topic);
		$data_topic_name=mysql_fetch_array($ptr_topic);
		
		$topic_name .=$data_topic_name['topic_name'].'<br/>';
	}
	echo $topic_name;
}
?>