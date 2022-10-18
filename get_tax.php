<?php include 'inc_classes.php';?>
<?php
	
	$admin_id=$_POST['admin_id'];
	
	$result = array();
	  if($_POST['admin_id'] !='')
		  {
			  	$sel_branch_name="SELECT branch_name FROM site_setting where admin_id='".$admin_id."' order by admin_id asc ";
				$ptr_branch_name =  mysql_query($sel_branch_name);	 
				$data_branch = mysql_fetch_array($ptr_branch_name);
				
			  	$sel_branch = "SELECT installment_course_percentage,service_tax FROM general_settings where branch_name='".$data_branch['branch_name']."' order by setting_id asc ";	 
				$query_branch = mysql_query($sel_branch);
				$total_Branch = mysql_num_rows($query_branch);
				$row_branch= mysql_fetch_array($query_branch);
						
						echo $row_branch['service_tax'].'_'.$row_branch['installment_course_percentage'];
						
        }
            ?>
               