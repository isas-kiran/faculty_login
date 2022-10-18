<?php include 'inc_classes.php'; ?>
<?php
$action = $_POST['action'];
if($action=='ajax_save')
{
				$enroll_id=$_POST['enroll_id'];
				$name=$_POST['name'];
				$mail=$_POST['mail'];
				$contact=$_POST['contact'];
				$username=$_POST['username'];
				$pass=$_POST['pass'];
				$add= $_POST['add'];
				
				$update_enroll="update enrollment set name='$name', mail='$mail', contact='$contact', username='$username', pass='$pass',address='$add' where enroll_id='$enroll_id'";
				$ptr_enroll=mysql_query($update_enroll);
				$update_login="update stud_login set username='$username', pass='$pass' where stud_login_id='$enroll_id'";
				$pte_login=mysql_query($update_login);
				
}

if($action['ajax_logsheet'])
{
	
				$course_id=$_POST['course_id'];
				$total_topics=$_POST['total_topic'];
				$enroll_id_1=$_POST['enroll_id_1'];
				
				$select_enroll = " select logsheet_id from logsheet where enroll_id='".$enroll_id_1."' ";
				$ptr_enroll=mysql_query($select_enroll);
				$stud_log = $_POST['action1'];
				$sep_stud_log = explode(',',$stud_log);
				
				$topic_id=$_POST['topic_id'];
				$sep_topic_id= explode(',',$topic_id);
					
				if(mysql_num_rows($ptr_enroll))
				{
					
					for($i=0;$i<$total_topics;$i++)
					{
						echo $update_query="update logsheet set student_sign= '".$sep_stud_log[$i]."' where enroll_id='".$enroll_id_1."'  and topic_id='".$sep_topic_id[$i]."'";
						$my_query_update=mysql_query($update_query);
					}
				}
				else
				{
					for($i=0;$i<$total_topics;$i++)
					{
						
						$insert_logsheet="insert into logsheet (`enroll_id`,`course_id`,`topic_id`,`student_sign`,`added_date`) 
						values('$enroll_id_1','$course_id','".$sep_topic_id[$i]."','".$sep_stud_log[$i]."','".date('Y-m-d H:i:s')."')";
						
						$ptr_query=mysql_query($insert_logsheet);
					}
				}
				
}
                                
                         	?>  
            
