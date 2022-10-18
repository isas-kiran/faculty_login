<?php 
 include 'inc_classes.php';
 
       $action = $_POST['action'];
			
			if($action=='show_course')
			{
            $course_id=$_POST['course_id'];
           echo  $sel_class = "select * from courses where course_name='".$course_id."' ";
            $execute_class = mysql_query($sel_class);
            ?>	
              	<?php
			    $courses_data= mysql_fetch_array($execute_class);
                $course_price =trim($courses_data['course_price']); 
				echo $course_price;
			}
		?>		  