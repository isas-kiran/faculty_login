<?php include 'inc_classes.php';?>
<?php
$course_id=$_POST['course_id'];
if($course_id)
{
	                                   
	                                      $select_name=" select batch_id from course_batch_mapping where course_id='".$course_id."' ";
											$ptr_name= mysql_query($select_name);
											    
											while($data_name = mysql_fetch_array($ptr_name))
										 {    
	//echo count($num);                  
	                                     // echo $data_name['batch_id'];
										   $select_batch="select batch_id,batch_name from batch where batch_id='".$data_name['batch_id']."'";
										 $select_query=mysql_query($select_batch);
										$fetch_batch=mysql_fetch_array($select_query);
										
											
										echo '<option value='.$fetch_batch['batch_id'].'>'.$fetch_batch['batch_name'].'</option>';
										
											}
}
	
?>
