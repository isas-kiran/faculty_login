<?php include 'inc_classes.php';
 ?>


<?php

$select_exc = "select * from pr_leave_management where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' ";
                           // $ptr_fs = mysql_query($select_exc);
                            $working_days=mysql_fetch_array($db->query($select_exc));
                          
							echo $working_days['no_of_working_days'];
			?>

