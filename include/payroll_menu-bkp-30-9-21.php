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
            if($page_name =='add_system_parameters.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_system_parameters.php" style="color:#7CA32F;">System Parameters</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_system_parameters.php" style="color:#666666;">System Parameters</a></td>
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
            if($page_name =='manage_advance_deduction.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_advance_deduction.php" style="color:#7CA32F;">Manage Advance Deduction </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_advance_deduction.php" style="color:#666666;">Manage Advance Deduction</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='advance_deduction.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="advance_deduction.php" style="color:#7CA32F;">Advance Deduction</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="advance_deduction.php" style="color:#666666;">Advance Deduction</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='payroll_manage_staff.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="payroll_manage_staff.php" style="color:#7CA32F;">Manage Staff Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="payroll_manage_staff.php" style="color:#666666;">Manage Staff Details</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
<td class="width5"></td>
	    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_attendance.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_attendance.php" style="color:#7CA32F;">Manage Attendance</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_attendance.php" style="color:#666666;">Manage Attendance</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='import_attendance.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_attendance.php" style="color:#7CA32F;">Import Attendance</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_attendance.php" style="color:#666666;">Import Attendance</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<!--<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_previous_leaves.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_previous_leaves.php" style="color:#7CA32F;">Manage Previous Leaves  </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_previous_leaves.php" style="color:#666666;">Manage Previous Leaves  </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>-->

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='previous_balance_leave.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="previous_balance_leave.php" style="color:#7CA32F;">Manage Staff Leaves</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="previous_balance_leave.php" style="color:#666666;">Manage Staff Leaves</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_leave_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_leave_management.php" style="color:#7CA32F;">Manage Monthly Days</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_leave_management.php" style="color:#666666;">Manage Monthly Days</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>


<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='leave_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="leave_management.php" style="color:#7CA32F;">Add Monthly Days</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="leave_management.php" style="color:#666666;">Add Monthly Days</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_staff_leave_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_leave_management.php" style="color:#7CA32F;">Manage Total Leaves</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_leave_management.php" style="color:#666666;">Manage Total Leave</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='staff_leave_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_leave_management.php" style="color:#7CA32F;">Calculate Total Leaves</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_leave_management.php" style="color:#666666;">Calculate Total Leave</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
<td class="width5"></td>
 
<!-- 
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_staff_service_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_service_incentive.php" style="color:#7CA32F;">Manage Service Inc. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_service_incentive.php" style="color:#666666;">Manage Service Inc. </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='staff_service_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_service_incentive.php" style="color:#7CA32F;">Service Inc. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_service_incentive.php" style="color:#666666;">Service Inc. </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_staff_product_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_product_incentive.php" style="color:#7CA32F;">Manage Prod. Inc. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_product_incentive.php" style="color:#666666;">Manage Prod. Inc. </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>



<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='staff_product_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_product_incentive.php" style="color:#7CA32F;">Product Inc. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_product_incentive.php" style="color:#666666;">Product Inc. </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>


<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_staff_course_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_course_incentive.php" style="color:#7CA32F;">Manage Course Inc. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_course_incentive.php" style="color:#666666;">Manage Course Inc. </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
 
 

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='staff_course_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_course_incentive.php" style="color:#7CA32F;">Course Inc. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_course_incentive.php" style="color:#666666;">Course Inc. </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
 
<td class="width5"></td> -->
</tr>
<tr>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_staff_salary_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_salary_management.php" style="color:#7CA32F;">Manage Salary</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_salary_management.php" style="color:#666666;">Manage Salary</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='staff_salary_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_salary_management.php" style="color:#7CA32F;">Calculate Salary</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_salary_management.php" style="color:#666666;">Calculate Salary</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<!-- <td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_staff_event_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_event_management.php" style="color:#7CA32F;">Manage Staff Event Management </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_event_management.php" style="color:#666666;">Manage Staff Event Management </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='staff_event_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_event_management.php" style="color:#7CA32F;">Staff Event Management </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_event_management.php" style="color:#666666;">Staff Event Management </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td> -->


<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='make_salary.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="make_salary.php" style="color:#7CA32F;">Process Salary</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="make_salary.php" style="color:#666666;">Process Salary</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='salary_slip.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="salary_slip.php" style="color:#7CA32F;">Generate Salary Slip </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="salary_slip.php" style="color:#666666;">Generate Salary Slip </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>
<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='salary_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="salary_report.php" style="color:#7CA32F;"> Salary Report </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="salary_report.php" style="color:#666666;"> Salary Report </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='incentive_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="incentive_report.php" style="color:#7CA32F;">Incentive Report </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="incentive_report.php" style="color:#666666;">Incentive Report </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?> </table>
			
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
		<?php 
        if($page_name =='incentive_course_report.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="incentive_course_report.php" style="color:#7CA32F;">Course Incentive Report </a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="incentive_course_report.php" style="color:#666666;">Course Incentive Report </a></td>
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
        if($page_name =='incentive_product_report.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="incentive_product_report.php" style="color:#7CA32F;">Product Incentive Report </a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="incentive_product_report.php" style="color:#666666;">Product Incentive Report </a></td>
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
        if($page_name =='pr_manage_daily_attendance.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="pr_manage_daily_attendance.php" style="color:#7CA32F;">Manage Daily Attendance</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="pr_manage_daily_attendance.php" style="color:#666666;">Manage Daily Attendance</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
        }
        ?>
	</table>		
</td>
	<?php
}
else
{
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==203) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($f==12)
				{
					echo '</tr><tr>';
				}
				if($array_prev[$e][$f]['privilege_id']==204)
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php 
					if($page_name =='add_system_parameters.php')
					{
					?>
					<tr>
						<td class="tab2_left"></td>
						<td class="tab2_mid"><a href="add_system_parameters.php" style="color:#7CA32F;">System Parameter</a></td>
						<td class="tab2_right"></td>
					</tr>
					<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="add_system_parameters.php" style="color:#666666;">System Parameter</a></td>
						<td class="tab_right"></td>
					</tr>
					<?php
					}
					?> </table>
                    </td>
                    <td class="width5"></td>
                    <?php
				}
				if($array_prev[$e][$f]['privilege_id']==225)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
					if($page_name ==  'manage_advance_deduction.php')
					{
					?>
					<tr>
						<td class="tab2_left"></td>
						<td class="tab2_mid"><a href="manage_advance_deduction.php" style="color:#7CA32F;">Manage Advance Deduction</a></td>
						<td class="tab2_right"></td>
					</tr>
					<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="manage_advance_deduction.php" style="color:#666666;">Manage Advance Deduction</a></td>
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
			 
			 
				if($array_prev[$e][$f]['privilege_id']==205)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
					if($page_name ==  'advance_deduction.php')
					{
					?>
					<tr>
						<td class="tab2_left"></td>
						<td class="tab2_mid"><a href="advance_deduction.php" style="color:#7CA32F;">Advvance Deduction </a></td>
						<td class="tab2_right"></td>
					</tr>
					<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="advance_deduction.php" style="color:#666666;">Advvance Deduction</a></td>
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
				if($array_prev[$e][$f]['privilege_id']==206)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
					if($page_name ==  'payroll_manage_staff.php')
					{
						?>
						<tr>
							<td class="tab2_left"></td>
							<td class="tab2_mid"><a href="payroll_manage_staff.php" style="color:#7CA32F;">Manage Staff details </a></td>
							<td class="tab2_right"></td>
						</tr>
					<?php
					}
					else
					{
						?>
						<tr>
							<td class="tab_left"></td>
							<td class="tab_mid"><a href="payroll_manage_staff.php" style="color:#666666;">Manage Staff details </a></td>
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
				if($array_prev[$e][$f]['privilege_id']==207)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
					if($page_name ==  'manage_attendance.php')
					{
						?>
						<tr>
							<td class="tab2_left"></td>
							<td class="tab2_mid"><a href="manage_attendance.php" style="color:#7CA32F;">Manage Attendance</a></td>
							<td class="tab2_right"></td>
						</tr>
						<?php
					}
					else
					{
						?>
						<tr>
							<td class="tab_left"></td>
							<td class="tab_mid"><a href="manage_attendance.php" style="color:#666666;">Manage Attendance</a></td>
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
				if($array_prev[$e][$f]['privilege_id']==208)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
					if($page_name ==  'import_attendance.php')
					{
					?>
					<tr>
						<td class="tab2_left"></td>
						<td class="tab2_mid"><a href="import_attendance.php" style="color:#7CA32F;">Import Attendance</a></td>
						<td class="tab2_right"></td>
					</tr>
					<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="import_attendance.php" style="color:#666666;">Import Attendance</a></td>
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
				if($array_prev[$e][$f]['privilege_id']==209)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
					if($page_name ==  'previous_balance_leave.php')
					{
					?>
					<tr>
						<td class="tab2_left"></td>
						<td class="tab2_mid"><a href="previous_balance_leave.php" style="color:#7CA32F;">Manage Staff Leaves </a></td>
						<td class="tab2_right"></td>
					</tr>
					<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="previous_balance_leave.php" style="color:#666666;">Manage Staff Leaves </a></td>
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
				if($array_prev[$e][$f]['privilege_id']==210)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
					if($page_name ==  'manage_leave_management.php')
					{
					?>
					<tr>
						<td class="tab2_left"></td>
						<td class="tab2_mid"><a href="manage_leave_management.php" style="color:#7CA32F;">Manage Monthly Days </a></td>
						<td class="tab2_right"></td>
					</tr>
					<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="manage_leave_management.php" style="color:#666666;">Manage Monthly Days </a></td>
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
				if($array_prev[$e][$f]['privilege_id']==211)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
						if($page_name ==  'leave_management.php')
						{
						?>
						<tr>
							<td class="tab2_left"></td>
							<td class="tab2_mid"><a href="leave_management.php" style="color:#7CA32F;">Add Monthly Days</a></td>
							<td class="tab2_right"></td>
						</tr>
						<?php
						}
						else
						{
						?>
						<tr>
							<td class="tab_left"></td>
							<td class="tab_mid"><a href="leave_management.php" style="color:#666666;">Add Monthly Days</a></td>
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
				if($array_prev[$e][$f]['privilege_id']==212)//'General Setting'
				{
					?>
                    <td>
                    <table border="0" cellspacing="0" cellpadding="0">
					<?php
                 	if($page_name ==  'manage_staff_leave_management.php')
                    {
                    ?>
                    <tr>
                        <td class="tab2_left"></td>
                        <td class="tab2_mid"><a href="manage_staff_leave_management.php" style="color:#7CA32F;">Manage Total Leaves </a></td>
                        <td class="tab2_right"></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td class="tab_left"></td>
                        <td class="tab_mid"><a href="manage_staff_leave_management.php" style="color:#666666;">Manage Total Leaves </a></td>
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
				if($array_prev[$e][$f]['privilege_id']==213)//'General Setting'
				{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
						<?php
			 		if($page_name ==  'staff_leave_management.php')
					{
					?>
					<tr>
						<td class="tab2_left"></td>
						<td class="tab2_mid"><a href="staff_leave_management.php" style="color:#7CA32F;">Calculate Total Leaves </a></td>
						<td class="tab2_right"></td>
					</tr>
					<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="staff_leave_management.php" style="color:#666666;">Calculate Total Leaves </a></td>
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
	/* if($array_prev[$e][$f]['privilege_id']==214)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'manage_staff_service_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_service_incentive.php" style="color:#7CA32F;">Manage Service Inc.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_service_incentive.php" style="color:#666666;">Manage Service Inc.</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
</td>
<?php
	}
	if($array_prev[$e][$f]['privilege_id']==215)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'staff_service_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_service_incentive.php" style="color:#7CA32F;">Service Inc.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_service_incentive.php" style="color:#666666;">Service Inc.</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
</td>
<?php
	}
	if($array_prev[$e][$f]['privilege_id']==216)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'manage_staff_product_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_product_incentive.php" style="color:#7CA32F;">Manage Product Inc. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_product_incentive.php" style="color:#666666;">Manage Product Inc.</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
</td>
<?php
	}
	if($array_prev[$e][$f]['privilege_id']==217)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'staff_product_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_product_incentive.php" style="color:#7CA32F;">Product Inc.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_product_incentive.php" style="color:#666666;">Product Inc.</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
</td>
<?php
	}
	if($array_prev[$e][$f]['privilege_id']==218)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'manage_staff_course_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_course_incentive.php" style="color:#7CA32F;">Manage Course Inc.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_course_incentive.php" style="color:#666666;">Manage Course Inc.</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
</td>
<?php
	}
	if($array_prev[$e][$f]['privilege_id']==219)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'staff_course_incentive.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_course_incentive.php" style="color:#7CA32F;">Course Inc.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_course_incentive.php" style="color:#666666;">Course Inc.</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
</td>
<?php
	} */
	if($array_prev[$e][$f]['privilege_id']==220)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'manage_staff_salary_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_staff_salary_management.php" style="color:#7CA32F;">Manage Salary</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_staff_salary_management.php" style="color:#666666;">Manage Salary</a></td>
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
	if($array_prev[$e][$f]['privilege_id']==221)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'staff_salary_management.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="staff_salary_management.php" style="color:#7CA32F;">Calculate Salary</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="staff_salary_management.php" style="color:#666666;">Calculate Salary</a></td>
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
	if($array_prev[$e][$f]['privilege_id']==222)//'General Setting'
    {
	?>
    <td>
		<table border="0" cellspacing="0" cellpadding="0">
            <?php
  			if($page_name ==  'make_salary.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="make_salary.php" style="color:#7CA32F;">Process Salary</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="make_salary.php" style="color:#666666;">Process Salary</a></td>
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
	if($array_prev[$e][$f]['privilege_id']==223)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'salary_slip.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="salary_slip.php" style="color:#7CA32F;">Generate Salary Slip </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="salary_slip.php" style="color:#666666;">Generate Salary Slip </a></td>
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
	if($array_prev[$e][$f]['privilege_id']==224)//'General Setting'
    {
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name ==  'salary_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="salary_report.php" style="color:#7CA32F;">Salary Report </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="salary_report.php" style="color:#666666;">Salary Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
</td>
<?php
}
if($array_prev[$e][$f]['privilege_id']==258)//'General Setting'
{
	?>
    <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
  	if($page_name ==  'service_incentive_report.php')
    {
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="incentive_report.php" style="color:#7CA32F;"> Incentive Report </a></td>
			<td class="tab2_right"></td>
		</tr>
	<?php
    }
    else
    {
    ?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="incentive_report.php" style="color:#666666;"> Incentive Report</a></td>
			<td class="tab_right"></td>
		</tr>
		<?php
	}
	?>
	</table>
	</td>
	<?php
}
if($array_prev[$e][$f]['privilege_id']==260)//'General Setting'
{
	?>
    <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
  	if($page_name ==  'incentive_course_report.php')
    {
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="incentive_course_report.php" style="color:#7CA32F;">Course Incentive Report </a></td>
			<td class="tab2_right"></td>
		</tr>
	<?php
    }
    else
    {
    ?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="incentive_course_report.php" style="color:#666666;">Course Incentive Report</a></td>
			<td class="tab_right"></td>
		</tr>
		<?php
	}
	?>
	</table>
	</td>
	<?php
}
if($array_prev[$e][$f]['privilege_id']==327)//'General Setting'
{
	?>
    <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
  	if($page_name ==  'incentive_product_report.php')
    {
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="incentive_product_report.php" style="color:#7CA32F;">Product Incentive Report </a></td>
			<td class="tab2_right"></td>
		</tr>
	<?php
    }
    else
    {
    ?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="incentive_product_report.php" style="color:#666666;">Product Incentive Report</a></td>
			<td class="tab_right"></td>
		</tr>
		<?php
	}
	?>
	</table>
	</td>
	<?php
}
if($array_prev[$e][$f]['privilege_id']==353)//'General Setting'
{
	?>
    <td class="width5"></td>
    <td>
        <table border="0" cellspacing="0" cellpadding="0">
        <?php
        if($page_name=='pr_manage_daily_attendance.php')
        {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="pr_manage_daily_attendance.php" style="color:#7CA32F;">Manage Daily Attendance</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="pr_manage_daily_attendance.php" style="color:#666666;">Manage Daily Attendance</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
        }
        ?>
        </table>
	</td>
	<?php
}
		
		}
	}
	}
  }
?>
   
</tr>
</table>