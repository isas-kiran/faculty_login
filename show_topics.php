<?php header('Content-Type: text/html; charset=ISO-8859-15'); ?>
<?php  include 'inc_classes.php';
$domain_ids=$_REQUEST['domain_ids'];
$action=$_REQUEST['action'];
if($action=="select_topic")
{
	echo "<table width='100%' id='wrapper'>";	
	$sel_unit="select * from course_domain_category where 1 and cat_id='".$domain_ids."' order by cat_id asc"; 
	$ptr_unit=mysql_query($sel_unit);
	if(mysql_num_rows($ptr_unit))
	{
			$data_unit=mysql_fetch_array($ptr_unit);
		//{
			//$sep_unit ='';
			//$sep_unit =" and subject_id='".$data_unit['subject_id']."' ";
			
			$sel_contact ="SELECT topic_id, topic_name FROM topic where 1 and course_domain_id='".$data_unit['cat_id']."' order by topic_name asc ";	 
			$query_contact = mysql_query($sel_contact);
			$i=1;
			$total_contact = mysql_num_rows($query_contact);
			if($total_contact && $record_id =='')
			{
				echo "<table width='100%' id='wrapper'>";
				echo "<table><tr><td width='9%' valign='top'>Select Topic from ".$data_unit['cat_name']."<span class='orange_font'>*</span></td>";
				echo "<td width='41%' >";
				$member_result='';
				echo '<table width="100%">';
				/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
				echo  '<tr>';
				$i=1;
				//$sel_unit="SELECT topic_id,topic_name FROM topic where 1 $concat order by subject_id asc ";
				//$ptr_unit=mysql_query($sel_unit);
				if($total_contact = mysql_num_rows($query_contact))
				{
					while($row_contact = mysql_fetch_array($query_contact))
					{
						echo  "<td id='qs".$row_contact['topic_id']."'><input type='checkbox' name='chapter_id[]' onclick='select_me(\"qs".$row_contact['topic_id']."\")'  value='".$row_contact['topic_id']."' id='chapter_id$i' class='case ".$row_contact['topic_id']."' style='vertical-align:top' /><span id='course'></span>".$row_contact['topic_id'].". ".$row_contact['topic_name']." ";
						echo "<span id='course'></span><input type='hidden' name='selected_subject' id='selected_subjects".$row_contact['topic_id']."' value='".$data_unit['cat_name']."' >";
											
					   echo  '</td>';
					   if($i%4==0)
					   echo  '</tr><tr>';  
					   $i++;
					}
				}
				else
				{
					echo "* No Topic found or Already selected";
				}
				echo "</tr></table>";
				echo "</td></tr></table><hr />";
			}
		//}
	}
	echo "</table>";
}
?>