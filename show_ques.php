<?php header('Content-Type: text/html; charset=ISO-8859-15'); ?>
<?php  include 'inc_classes.php';

//$member_id=$_REQUEST['subject_ids'];

//$top_id=$_REQUEST['topic_id'];

$topic_no=$_REQUEST['topic_no'];

$topic_name=$_REQUEST['topic_name'];

$subject_ids=$_REQUEST['subject_ids'];

$question_vals=$_REQUEST['question_vals'];

//if($member_id=='')
//{
	//echo "Please select Subject name...!!!";
//}
$concat_quesId='';
if($question_vals!='')
{
	$quesId_seprated =explode(',',$question_vals);
	// echo count($result_seprated);
	$concat_quesId = ' and  (';
	for($i=0;$i<count($quesId_seprated);$i++)
	{
		if($quesId_seprated[$i] !='')
		{	
			$concat_quesId .="  topic_id !='$quesId_seprated[$i]' ";
		}
		if( $i <(count($quesId_seprated)-1))
		{
			$concat_quesId .=" and " ;
		}
	}
	$concat_quesId .=" ) ";
}
/*else
{*/

	$result = array();
	if($subject_ids !='')
	{
		
	  /************************************************/
	  $result_seprated =explode(',',$subject_ids);
	  count($result_seprated);
	  $concat = ' and  (';
				for($i=0;$i<count($result_seprated);$i++)
				{
					if($result_seprated[$i] !='')
						{
							$concat .="  subject_id='$result_seprated[$i]' ";
						}
					if( $i <(count($result_seprated)-2))
						{
							$concat .=" or " ;
						}
				}
	  $concat .=" ) ";
	  /************************************************/
	//  $member_id = "and subject_id='".$concat."' ";
	}
	if($topic_no !='')
	{
	/*$select_ques="select * from question where question_id='".$question_no."' and language_id ='".$lang_id."'";
	$ptr_que=mysql_query($select_ques);
	$data_ques=mysql_fetch_array($ptr_que);
	$unit_id= $data_ques['unit_id'];*/
	$ques_concat="and topic_id='$topic_no'";
	}
 
	if($topic_name)
	{
	  $ques_concat="and topic_name like '%".$topic_name."%'";
	}
	echo "<table width='100%' id='wrapper'>";
	
	$sel_unit="select name, subject_id from subject where 1 $concat order by subject_id asc"; 
	$ptr_unit=mysql_query($sel_unit);
	if(mysql_num_rows($ptr_unit))
	{
		while($data_unit=mysql_fetch_array($ptr_unit))
		{
			$sep_unit ='';
			$sep_unit =" and subject_id='".$data_unit['subject_id']."' ";
			$sel_contact = "SELECT topic_id, topic_name FROM topic where 1 $concat $concat_quesId $ques_concat $sep_unit  order by topic_id asc ";	 
			$query_contact = mysql_query($sel_contact);
			$i=1;
			$total_contact = mysql_num_rows($query_contact);
			if($total_contact && $record_id =='')
			{
				echo "<table width='100%' id='wrapper'>";
				echo "<table><tr><td width='9%' valign='top'>Select Topic from ".$data_unit['name']."<span class='orange_font'>*</span></td>";
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
						echo "<span id='course'></span><input type='hidden' name='selected_subject' id='selected_subjects".$row_contact['topic_id']."' value='".$data_unit['name']."' >";
											
					   echo  '</td>';
					   if($i%2==0)
					   echo  '</tr><tr>';  
					   $i++;
					}
				}
				else
				{
					echo "* No Question found or Already selected";
				}
				echo "</tr></table>";
				echo "</td></tr></table><hr />";
			}
			else if($total_contact && $record_id !='')
			{
				
				echo "<table><tr><td width='9%' valign='top'>Select Topic from ".$data_unit['name']."<span class='orange_font'>*</span></td>";
				echo "<td width='41%' >";
				$member_result='';
				
				/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
				$i=1;
				echo '<table width="100%">';
				echo  '<tr>';
				while($row_contact = mysql_fetch_array($query_contact))
				{
					$checked='';
					$seleexam_se="select * from topic_map where topic_id='".$row_contact['topic_id']."' and course_id='$record_id' ";
					$ptr_ex=mysql_query($seleexam_se);
					$tot_ques=mysql_num_rows($ptr_ex);
					if($tot_ques !=0 || $tot_ques !='')
					{
						$checked="checked='checked'";
					}
					echo  "<td id='qs".$row_contact['topic_id']."'><input type='checkbox' name='topic_id[]' onclick='select_me(\"qs".$row_contact['topic_id']."\")' ".$checked."  value='".$row_contact['topic_id']."' id='topic_id$i' class='case ".$row_contact['topic_id']."' style='vertical-align:top'/><span id='course'></span>".$row_contact['topic_id'].". ".$row_contact['topic_name']." ";
					echo "<span id='course'></span><input type='hidden' name='selected_subject' id='selected_subjects".$row_contact['topic_id']."' value='".$data_unit['name']."' >";
					echo  '</td>';
					if($i%2==0)
						echo  '</tr><tr>';  
					$i++;
				}
				echo "</tr></table>";
				echo "</td></tr></table><hr />";
			}
			
		}
		
	}
	echo "</table>";

	
//}
?>