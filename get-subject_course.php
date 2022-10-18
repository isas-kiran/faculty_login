<?php

include 'inc_classes.php';

$course_id=$_POST['course_id'];

	
	echo '<table style="width: 60%"><tr>
	        <td width="20%">Subject :</td>';
			
	    echo '<td width="40%">';
		
		echo '<select name="subject_id" id="subject_id"  class=" input_select" onchange="show_chapter(this.value); ">
                  <option value="0">Select subject</option>';
						 
						    $sql_dest = " select DISTINCT(subject_id), course_id from topic_map where course_id='".$course_id."' ";
                            $ptr_edes = mysql_query($sql_dest);
                            while($data_dist = mysql_fetch_array($ptr_edes))
                            { 
								  $sql_dest1 = " select subject_id, name from subject where subject_id='".$data_dist['subject_id']."' and  course_id='".$course_id."' order by subject_id asc";
								  $ptr_edes1= mysql_query($sql_dest1);
								  $fetch_prodct=mysql_fetch_array($ptr_edes1);
								
								  $select_question = "  select question_id from question where subject_id='".$fetch_prodct['subject_id']."'  ";
								  $ptr_sub_qur = mysql_query($select_question);
								  $count_question=mysql_num_rows($ptr_sub_qur);
								  
								  $sql_dest2 = " select * from paper where course_id='".$course_id."' and  subject_id='".$fetch_prodct['subject_id']."'";
								  $ptr_edes2= mysql_query($sql_dest2);
								  $fetch_prodct2=mysql_fetch_array($ptr_edes2);
							
                                    $selecteds = '';
                                    if($data_dist['subject_id']==$fetch_prodct2['subject_id'])
                                    $selecteds = 'selected="selected"';	
										   
									echo "<option value='".$fetch_prodct['subject_id']."' $selecteds>".$fetch_prodct['name']."(Total Que=> ".$count_question.")"."</option>";
									
									
					 
                            }
		echo '</select>
             </td></tr></table>';
			 
			 
			$sql_dest = " select DISTINCT(subject_id), course_id from topic_map where course_id='".$course_id."' ";
			$ptr_edes = mysql_query($sql_dest);
			while($data_dist = mysql_fetch_array($ptr_edes))
			{ 
			    $sql_dest1 = " select subject_id, name from subject where subject_id='".$data_dist['subject_id']."' and  course_id='".$course_id."' order by subject_id asc";
			    $ptr2 = mysql_query($sql_dest1);
									while($data_category2 = mysql_fetch_array($ptr2))
								     {
									  $select_question2 = "  select question_id from question where subject_id='".$data_category2['subject_id']."'  ";
									  $ptr_sub_qur2 = mysql_query($select_question2);
	
						              echo "<input type='hidden' name='totla_q_".$data_category2['subject_id']."' id='totla_q_".$data_category2['subject_id']."' value='".mysql_num_rows($ptr_sub_qur2)."'>";  }
					 
			}
			        

?>