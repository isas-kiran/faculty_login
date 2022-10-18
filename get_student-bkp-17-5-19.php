<?php include 'inc_classes.php';?>
<?php
	
	  	$course_id=$_POST['course_id'];
		if($course_id=='')
	    {
		echo "Please select any course first...!!!";
		}
		else
	    {	
			if($course_id !='')
			{  $course_con =' course_id="'.$course_id.'" and 1  ';
				$checked='';
				$sts = " and status = 'Enrolled' ";
			  /************************************************/
			   if($_POST['batch_id'] !='')
			   {
				   $select_existing_batch_student = "select enroll_id from student_course_batch_map where batch_id ='".$_POST['batch_id']."' ".$_SESSION['where'];
				   $ptr_batch = mysql_query($select_existing_batch_student);
				   $conc_enroll = " and batch_id='".$_POST['batch_id']."'  ";
				   $con ='';
				   $total_rec = mysql_num_rows($ptr_batch);
				   $i=1;
				   
				   $array_stud = array();
				   while($data_stud = mysql_fetch_array($ptr_batch))
				   {
						
						 $array_stud[$i-1]=$data_stud['enroll_id'];
						 
						 $i++;
					}
					
					$sts = " or status = 'Enrolled' ";
				//	$checked = " checked='checked' ";
				}
				
			   
				  $sel_std = "select * from enrollment where ($course_con $conc_enroll ) $sts   ".$_SESSION['where'] ;
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
					   $del=$data_ptr_std['enroll_id'];
					    if($_POST['batch_id'] !='' )
			   			{
					   		if(in_array($data_ptr_std['enroll_id'],$array_stud))
					   		$checked = " checked='checked' ";
							$del ='';
						}
					   
					 
					   echo  "<input type='checkbox' name='requirment_id[]'  value='".$data_ptr_std['enroll_id']."' id='requirment_id$i'  onClick='del_not(this.value, $i)' class='case' $checked /> ".$data_ptr_std['name']." <input type='hidden' name='del_enroll_$i' value='$del' id='del_enroll_$i'  />";
					   
					   echo  '</td>';
					   if($i%6==0)
					   echo  '<tr></tr>';  
					   $i++;
					  }
				 }
				 echo "</tr><tr><td>";
				 echo "<input type='hidden' name='total_students' value='".($i-1)."'></td></tr>";
		  	} echo "</table>";
		}
?>	
