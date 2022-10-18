<?php include 'inc_classes.php';?>
<?php
	
	$member_id=$_POST['subject_ids'];
	if($member_id=='')
	    {
		echo "Please select Subject name...!!!";
		}
	else
	    {	
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
									$concat .="  subject_id='$result_seprated[$i]' ";
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
	
	    $sel_contact = "SELECT topic_id,topic_name FROM topic where 1 $concat order by subject_id asc ";	 
		$query_contact = mysql_query($sel_contact);
		$i=1;
		$total_contact = mysql_num_rows($query_contact);
		$member_result='';
		echo ' <select id="cities" class="multiselect" multiple="multiple" name="topics[]">';
		while($row_contact = mysql_fetch_array($query_contact))
		    {
					
					  echo "<option value='".$row_contact['topic_id']."'>".$row_contact['topic_name']."</option>";
				
			}

		}
?>	
    </select>