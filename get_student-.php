<?php include 'inc_classes.php';?>
<?php
	
	 echo $course_id=$_POST['course_id'];
	if($course_id=='')
	    {
		echo "Please select any course first...!!!";
		}
	else
	    {	
			if($course_id !='')
			{
			  /************************************************/
				 $sel_std = "select * from enrollment where course_id='$course_id' ";	
				 $ptr_student = mysql_query( $sel_std); 
				 //$data_ptr_subj = mysql_fetch_array($ptr_subject);
				 $i=1;
				 $total_no = mysql_num_rows($ptr_student);
				 echo '<table width="100%">';
				 echo  '<tr>';
				 while($data_ptr_std = mysql_fetch_array($ptr_student))
				 {
					   echo  '<td style="border:1px solid #999;">'; 
					   echo  "<input type='checkbox' name='requirment_id[]'  value='".$data_ptr_std['enroll_id']."' id='requirment_id$i'  onClick='showUser()' class='case' $checked /> ".$data_ptr_std['name']." ";
					   echo  '</td>';
					   if($i%4==0)
					   echo  '<tr></tr>';  
					   $i++;
				 }
		  	}
		}
?>	
