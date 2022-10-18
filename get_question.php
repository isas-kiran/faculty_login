<?php include 'inc_classes.php';?>
<?php
	
	$member_id=$_POST['chapter_id'];
	$concates='';
	$result = array();
	  if($member_id !='')
		  {
			  /************************************************/
			  $result_seprated =explode(',',$member_id);
			 // echo count($result_seprated);
			  $concat = ' and  (';
						for($i=0;$i<count($result_seprated);$i++)
						{
							if($result_seprated[$i] !='')
								{
									$concat .="  chapter_id='$result_seprated[$i]' ";
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
		echo '<br>'.$select_question_id="select question_id,chapter_id,subject_id from question where 1 $concat order by subject_id asc";
		$ptr_ques_id=mysql_query($select_question_id);
	   
		$i=1;
		$member_result='';
		while($row_contact = mysql_fetch_array($ptr_ques_id))
		    {
					$concates .=$total_contact = mysql_num_rows($ptr_ques_id);

					 echo '<input type="hidden" id="ques" name="ques">';
					 
			}

		
?>	
    </select>