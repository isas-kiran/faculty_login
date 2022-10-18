<?php session_start();
include 'inc_classes.php';
$action=$_POST['action'];
if($action=="gettopic")
{
	$course_id=$_POST['course_id'];
	if($course_id)
	{
		$select_topic="select topic_id from topic_map where course_id='".$course_id."' order by topic_id";
		$ptr_topic= mysql_query($select_topic);
		while($data_topic=mysql_fetch_array($ptr_topic))
		{
			$sel_name="select topic_name,topic_id from topic where topic_id='".$data_topic['topic_id']."'";
			$ptr_name=mysql_query($sel_name);
			$data_name=mysql_fetch_array($ptr_name);
			
			echo "<option value='".$data_name['topic_id']."' >".addslashes($data_name['topic_name'])." </option>";
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
?>