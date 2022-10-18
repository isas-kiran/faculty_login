<?php include 'inc_classes.php';?>
<?php
	
	  $group_id=$_POST['group_id'];
	if($group_id=='')
	    {
		echo "Please select any Group first...!!!";
		}
	else
	    {	
			if($group_id !='')
			{  
				$checked='';
				
				  $sel_std = "select * from add_group_detail where group_id='".$group_id."' ";
				 $ptr_student = mysql_query( $sel_std); 
				 //$data_ptr_subj = mysql_fetch_array($ptr_subject);
				 $i=1;
				 $total_no = mysql_num_rows($ptr_student);
				 echo '<table width="100%">';
				 echo  '<tr>';
				 $total_student = 0;
				 while($data_ptr_std = mysql_fetch_array($ptr_student))
				 {
					  if( $group_id ==$data_ptr_std['group_id'])
					  {
					   echo  '<td style="border:1px solid #999;">'; 
					   $checked='';
					   $del=$data_ptr_std['group_id'];
					    if($_POST['group_id'] !='' )
			   			{
					   		if(in_array($data_ptr_std['group_id'],$array_stud))
					   		$checked = " checked='checked' ";
							$del ='';
						}
					   
					 
					   echo  "<input type='checkbox' name='requirment_id[]'  value='".$data_ptr_std['group_id']."' id='requirment_id$i'  onClick='del_not(this.value, $i)' class='case' $checked /> ".$data_ptr_std['group_name']." ";
					   
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
