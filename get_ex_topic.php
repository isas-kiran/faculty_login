<?php include 'inc_classes.php';?>
<?php
	
	  $subject_id=$_POST['subject_id'];
	if($subject_id=='')
	    {
		echo "Please select any Subject first...!!!";
		}
	else
	    {	
			if($subject_id !='')
			{  $subject_con =' subject_id="'.$subject_id.'" and 1  ';
				$checked='';
				//$sts = " and status = 'Enrolled' ";
			  /************************************************/
			   if($_POST['subject_id'] !='')
			   {
				   $select_existing_topic = "  select * from toic where subject_id ='".$_POST['subject_id']."' ".$_SESSION['where'];
				   $ptr_batch = mysql_query($select_existing_batch_student);
				   $conc_enroll = "  and topic_id='".$_POST['topic_id']."'  ";
				   $con ='';
				   $total_rec = mysql_num_rows($ptr_batch);
				   $i=1;
				   
				   $array_stud = array();
				   while($data_stud = mysql_fetch_array($ptr_batch))
				   {
						
						 $array_stud[$i-1]=$data_stud['topic_id'];
						 
						 $i++;
					}
					
					
				//	$checked = " checked='checked' ";
				}
				
			   
				 $sel_std = "select * from topic where ($subject_con $conc_enroll )  ".$_SESSION['where'] ;
				 $ptr_student = mysql_query( $sel_std); 
				 //$data_ptr_subj = mysql_fetch_array($ptr_subject);
				 $i=1;
				 $total_no = mysql_num_rows($ptr_student);
				 echo '<table width="100%">';
				 echo  '<tr>';
				 $total_student = 0;
				 while($data_ptr_std = mysql_fetch_array($ptr_student))
				 {
					  if( $course_id ==$data_ptr_std['course_id'])
					  {
					   echo  '<td style="border:1px solid #999;">'; 
					   $checked='';
					   $del=$data_ptr_std['subject_id'];
					    if($_POST['topic_id'] !='' )
			   			{
					   		if(in_array($data_ptr_std['topic_id'],$array_stud))
					   		$checked = " checked='checked' ";
							$del ='';
						}
					   
					 
					   echo  "<input type='checkbox' name='requirment_id[]'  value='".$data_ptr_std['topic_id']."' id='requirment_id$i'  onClick='del_not(this.value, $i)' class='case' $checked /> ".$data_ptr_std['topic_name']." <input type='hidden' name='del_enroll_$i' value='$del' id='del_enroll_$i'  />";
					   
					   echo  '</td>';
					   if($i%4==0)
					   echo  '<tr></tr>';  
					   $i++;
					  }
				 }
				 echo "</tr><tr><td>";
				 echo "<input type='hidden' name='total_students' value='".($i-1)."'></td></tr>";
		  	} echo "</table>";
		}
?>	
