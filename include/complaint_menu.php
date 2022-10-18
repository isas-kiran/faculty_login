<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
   <?php
   if($_SESSION['type'] =='S')
   {
	   ?>
        <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
           if($page_name =='manage_complaint.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_complaint.php" style="color:#7CA32F;">Manage Complaint </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_complaint.php" style="color:#666666;">Manage Complaint </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
</table>
</td>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_complaint_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_complaint_report.php" style="color:#7CA32F;">Manage Complaint Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_complaint_report.php" style="color:#666666;">Manage Complaint Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<!--<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_course_certification.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_course_certification.php" style="color:#7CA32F;">Add Course Certification </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_course_certification.php" style="color:#666666;">Add Course Certification </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>-->
       <?php
   }
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
  	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==158) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==159)
				{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                           if($page_name =='manage_complaint.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="manage_complaint.php" style="color:#7CA32F;">Manage Complaint </a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="manage_complaint.php" style="color:#666666;">Manage Complaint </a></td>
                                <td class="tab_right"></td>
                            </tr>
                            <?php
                            }
                            
                            ?>
                        </table>
                    </td>
					<td class="width5"></td>
					<?php 
				} 
				if($array_prev[$e][$f]['privilege_id']==351)
				{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                           	if($page_name =='manage_complaint_report.php')
                            {
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="manage_complaint_report.php" style="color:#7CA32F;">Manage Complaint Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
                            }
                            else
                            {
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="manage_complaint_report.php" style="color:#666666;">Manage Complaint Report</a></td>
									<td class="tab_right"></td>
								</tr>
								<?php
                            }
                            ?>
                        </table>
                    </td>
					<td class="width5"></td>
					<?php 
				} 
				?>

<!--<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_course_certification.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_course_certification.php" style="color:#7CA32F;">Manage Course Certification </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_course_certification.php" style="color:#666666;">Manage Course Certification </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_course_certification.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_course_certification.php" style="color:#7CA32F;">Add Course Certification </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_course_certification.php" style="color:#666666;">Add Course Certification </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>-->
 <?php
					}
			}
		}
   }
					?>
  </tr>
</table>