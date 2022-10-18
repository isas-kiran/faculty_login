<?php include 'inc_classes.php';?>
<?php
	
	 $member_id=$_POST['subject_ids'];
	if($member_id=='')
	    {
		echo "Please select any subject first...!!!";
		}
	else
	    {	
	$result = array();
	  if($member_id !='')
		  {
			  /************************************************/
			  $result_seprated =explode(',',$member_id);
			  echo ' <select id="cities" class="multiselect" multiple="multiple" name="topics[]">';
			
						for($i=0;$i<count($result_seprated);$i++)
						{
							if($result_seprated[$i] !='')
								{
									$concat .="  subject_id='$result_seprated[$i]' ";
									
									 $sel_tel = "select * from subject where subject_id='$result_seprated[$i]' ";	
									 $ptr_subject = mysql_query( $sel_tel); 
									 $data_ptr_subj = mysql_fetch_array($ptr_subject);
									// echo "<optgroup label='".$data_ptr_subj['name']."'>";
									  $sel_contact = "SELECT * FROM topic where  subject_id='".$data_ptr_subj['subject_id']."' ";	 
										$query_contact = mysql_query($sel_contact);
										$i=1;
										if(mysql_num_rows($query_contact))
										{
										
										
										while($row_contact = mysql_fetch_array($query_contact))
											{
													
													  echo "<option value='".$row_contact['topic_id']."'>".$row_contact['topic_name']."</option>";
												
											}

										}
									//	echo "</optgroup>";
									 
								}
						
						}
			echo "    </select>";
			 
		  }
	
	   
		}
?>	
