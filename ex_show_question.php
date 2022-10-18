<?php include 'inc_classes.php';?>
<?php
	
	$unit_id=$_POST['unit_id'];
	$result = array();
	if($unit_id !='')
	{
		$select_question_id="select question_id,question_title,	main_question_id,language_id from question where unit_id='".$unit_id."' order by main_question_id asc limit 0,1";
		$ptr_ques_id=mysql_query($select_question_id);
		$row_contact = mysql_fetch_array($ptr_ques_id);
		
		$sel_language="select language_name from language where language_id='".$row_contact['language_id']."'";
		$ptr_lang=mysql_query($sel_language);
		$data_lang=mysql_fetch_array($ptr_lang);
		
		$sel_unit="";
		echo '<table style="border:1px solid #0066cc"><tr>';
		echo '<td>Language - </td><td>'.$data_lang['language_name'].'</td></tr>';
		echo '<tr><td>Question - </td><td></td></tr>';
		echo '<tr><td></td><td>'.$row_contact['question_title'].'</td>';
		echo '</tr></table>';
	}
?>	
