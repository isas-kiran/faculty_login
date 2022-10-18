<?php include 'inc_classes.php';?>
<?php
	$branch_name=$_POST['branch_name'];
	$course_id=$_POST['course_id'];
	$course_batch_id=$_POST['course_batch_id'];
	if($course_id=='')
	{
		echo "Please select any course first...!!!";
	}
	else
	{	
		if($course_id !='')
		{
			if($_SESSION['type']=='S')
			{
				$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
				$ptr_branch=mysql_query($sel_branch);
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id=$data_branch['cm_id'];
				$search_cm_id=" and cm_id='".$cm_id."'";
			}	
			else
			{
				$branch_name1=$_SESSION['branch_name'];
				$cm_id=$_SESSION['cm_id'];
				$search_cm_id=" and cm_id='".$cm_id."'";
			}
			$sel_map="SELECT * FROM courses_map WHERE course_id = '".$course_id."' UNION SELECT * FROM courses_map WHERE course_id IN (SELECT course_parent_id FROM courses_map WHERE course_id = '".$course_id."') ";
			$ptr_courses=mysql_query($sel_map);
			$total_course=mysql_num_rows($ptr_courses);
			$tot=1;
			while($data_map=mysql_fetch_array($ptr_courses))
			{
				$course_map .=$data_map['course_parent_id'];
				/*if($tot!=$total_course)
				{
					*/$course_map .=',';
				//}
				$tot++;
			}
			//echo "/n course map ".$course_map;
			
			$course_con =' and course_id IN ('.$course_map.''.$course_id.')';
			$checked='';
			$sts = " and status = 'Enrolled' ";
			/************************************************/
			if($course_batch_id !='')
			{
				$select_existing_batch_student="select enroll_id from student_course_batch_map where c_b_id ='".$course_batch_id."' ".$search_cm_id." ".$_SESSION['where']." ";
				$ptr_batch = mysql_query($select_existing_batch_student);
				$conc_enroll=" and batch_id='".$course_batch_id."'  ";
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
				//$checked = " checked='checked' ";
			}
					   
			echo "<br/>".$sel_std = "select * from enrollment where 1 ".$course_con." ".$conc_enroll." ".$sts." ".$search_cm_id." ".$_SESSION['where']." " ;
			$ptr_student = mysql_query( $sel_std); 
			//$data_ptr_subj = mysql_fetch_array($ptr_subject);
			$i=1;
			$total_no = mysql_num_rows($ptr_student);
			echo '<table width="100%">';
			echo  '<tr>';
			$total_student = 0;
			while($data_ptr_std = mysql_fetch_array($ptr_student))
			{
				/*if( $course_id ==$data_ptr_std['course_id'])
				{*/
					echo  '<td style="border:1px solid #999;">'; 
					$checked='';
					$del=$data_ptr_std['enroll_id'];
					if($course_batch_id !='' )
					{
						if(in_array($data_ptr_std['enroll_id'],$array_stud))
						$checked = " checked='checked' ";
						$del ='';
					}
					echo  "<input type='checkbox' name='requirment_id[]'  value='".$data_ptr_std['enroll_id']."' id='requirment_id$i'  onClick='del_not(this.value, $i)' class='case' $checked /><span style='font-size:14px'> ".$data_ptr_std['name']."</span> <input type='hidden' name='del_enroll_$i' value='$del' id='del_enroll_$i'  />";
				   
					echo  '</td>';
					if($i%6==0)
					echo  '<tr></tr>';  
					$i++;
				//}
			}
			echo "</tr><tr><td>";
			echo "<input type='hidden' name='total_students' value='".($i-1)."'></td></tr>";
		} 	
		echo "</table>";
	}
?>