<?php header('Content-Type: text/html; charset=ISO-8859-15'); ?><?php  include 'ex_inc_classes.php';

$ques_ids=$_POST['ques_ids'];

$record_id=$_POST['record_id'];

$language_id=$_POST['language_id'];

$question_no=$_POST['question_no'];
$lang_id=$_POST['language_id'];
$question_title=$_POST['question_title'];

$question_vals=$_POST['question_vals'];
if($question_vals!='')
{
	$quesId_seprated =explode(',',$question_vals);
	// echo count($result_seprated);
	$concat_quesId = ' and  (';
	for($i=0;$i<count($quesId_seprated);$i++)
	{
		if($quesId_seprated[$i] !='')
		{
			$concat_quesId .="  question_id !='$quesId_seprated[$i]' ";
		}
		if( $i <(count($quesId_seprated)-1))
		{
			$concat_quesId .=" and " ;
		}
	}
	$concat_quesId .=" ) ";
}
//echo $concat_quesId;
/*if($ques_ids=='')
{
	echo "Please select Unit name OR there is no question ...!!!";
}
else*/
{	
$result = array();
$concat='';
if($ques_ids !='')
{
	/************************************************/
	$result_seprated =explode(',',$ques_ids);
	// echo count($result_seprated);
	$concat = ' and  (';
	for($i=0;$i<count($result_seprated);$i++)
	{
		if($result_seprated[$i] !='')
		{
			$concat .="  topic_id='$result_seprated[$i]' ";
		}
		if( $i <(count($result_seprated)-2))
		{
			$concat .=" or " ;
		}
	}
	$concat .=" ) ";


	$concatq = ' and  (';
	for($i=0;$i<count($result_seprated);$i++)
	{
		if($result_seprated[$i] !='')
		{
			$concatq .="  unit_id='$result_seprated[$i]' ";
		}
		if( $i <(count($result_seprated)-2))
		{
			$concatq .=" or " ;
		}
	}
	$concatq .=" ) ";
	  /************************************************/
	//  $member_id = "and subject_id='".$concat."' ";
}
if($question_no !='')
{
	/*$select_ques="select * from question where question_id='".$question_no."' and language_id ='".$lang_id."'";
	$ptr_que=mysql_query($select_ques);
	$data_ques=mysql_fetch_array($ptr_que);
	$unit_id= $data_ques['unit_id'];*/
	$ques_concat="and question_id='$question_no'";
}
if($question_title)
{
	$ques_concat="and question_title like '%".$question_title."%'";
}
		echo "<table width='100%' id='wrapper'>";
		
		$sel_unit="select topic_name, topic_id from topic where 1 $concat order by topic_name asc";
		$ptr_unit=mysql_query($sel_unit);
		if(mysql_num_rows($ptr_unit))
		{
		while($data_unit=mysql_fetch_array($ptr_unit))
		{
			$sep_unit ='';
			
			$sep_unit =" and unit_id='".$data_unit['topic_id']."' ";
			
			$sel_contact = "SELECT question_id, question_title, question_img  FROM ex_question where 1 $concatq $concat_quesId $ques_concat $sep_unit and language_id='".$language_id."'  order by question_id asc ";	 
			$query_contact = mysql_query($sel_contact);
			$i=1;
			$total_contact = mysql_num_rows($query_contact);
			if($total_contact && $record_id =='')
			{
		
		//echo "Search Ques. <input type='text' name='keyword' id='kayword'><br /><br />";
		
		
			
			echo "<table><tr><td width='9%' valign='top'>Select Question from ".$data_unit['topic_name']."<span class='orange_font'>*</span></td>";
			echo "<td width='41%' >";
			$member_result='';
			echo '<table width="100%">';
			/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
			echo  '<tr>';
			$i=1;
			if($total_contact = mysql_num_rows($query_contact))
			{
				while($row_contact = mysql_fetch_array($query_contact))
				{
					echo  "<td id='qs".$row_contact['question_id']."'><input type='checkbox' name='chapter_id[]' onclick='select_me(\"qs".$row_contact['question_id']."\")'  value='".$row_contact['question_id']."' id='chapter_id$i' class='case ".$row_contact['question_id']."' style='vertical-align:top' /><input type='hidden' name='split'>".$row_contact['question_id'].". ".$row_contact['question_title']." ";
					echo "<input type='hidden' name='split'><input type='hidden' name='selected_unit' id='selected_units".$row_contact['question_id']."' value='".$data_unit['topic_name']."' >";
					if($row_contact['question_img'])
					{
					?>
					<img src='ex_question_photo/<?php echo $row_contact['question_img'] ?>' height='50' width='50'>
					<?php
					}
					
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
			/*$seleexam_se="select * from exams_section where 1 $concat";

			$ptr_ex=mysql_query($seleexam_se);

			$i=1;

			while($data_ex=mysql_fetch_array($ptr_ex))

			{

				$sel_contact = "SELECT * FROM question where 1 and question_id='".$data_ex['question_id']."' order by question_id asc ";	 

				$query_contact = mysql_query($sel_contact);


				$total_contact = mysql_num_rows($query_contact);

				$member_result='';

				echo '<table width="100%">';

				echo  '<tr>';

				$row_contact = mysql_fetch_array($query_contact);

				echo  "<td><input type='checkbox' checked='checked' name='chapter_id[]'  value='".$row_contact['question_id']."' id='chapter_id$i' class='case'/> ".$row_contact['question_title']." ";

				   echo  '</td>';

				   if($i%2==0)

				   echo  '</tr><tr>';  

				   $i++;

			}*/
			
			
			echo "<table><tr><td width='9%' valign='top'>Select Question from ".$data_unit['topic_name']."<span class='orange_font'>*</span></td>";
			echo "<td width='41%' >";
			$member_result='';
			
			/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
			
			
			$i=1;
			echo '<table width="100%">';
					echo  '<tr>';
			while($row_contact = mysql_fetch_array($query_contact))
				{
					$checked='';
					$seleexam_se="select * from ex_papers_section where question_id='".$row_contact['question_id']."' and papers_id='$record_id'  ";
					$ptr_ex=mysql_query($seleexam_se);
					$tot_ques=mysql_num_rows($ptr_ex);
					if($tot_ques !=0 || $tot_ques !='')
					{
						$checked="checked='checked'";
					}
					
						echo  "<td id='qs".$row_contact['question_id']."'><input type='checkbox' name='chapter_id[]' onclick='select_me(\"qs".$row_contact['question_id']."\")' ".$checked."  value='".$row_contact['question_id']."' id='chapter_id$i' class='case ".$row_contact['question_id']."' style='vertical-align:top'/><input type='hidden' name='split'>".$row_contact['question_id'].". ".$row_contact['question_title']." ";
					echo "<input type='hidden' name='split'><input type='hidden' name='selected_unit' id='selected_units".$row_contact['question_id']."' value='".$data_unit['topic_name']."' >";

					if($row_contact['question_img'])
					{
					?>
					<img src='ex_question_photo/<?php echo $row_contact['question_img'] ?>' height='50' width='50'>

					<?php
					}
			   echo  '</td>';

			   if($i%2==0)

			   echo  '</tr><tr>';  

			   $i++;


				}echo "</tr></table>";
				echo "</td></tr></table><hr />";
		}
		
		}
		
	}
	echo "</table>";

	
}
?>

