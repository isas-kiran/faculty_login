<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='exam_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="exam_report.php" style="color:#7CA32F;"> Exam Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="exam_report.php" style="color:#666666;"> Exam Report</a></td>
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
            if($page_name =='student_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="student_report.php" style="color:#7CA32F;">View Exam Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="student_report.php" style="color:#666666;">View Exam Details</a></td>
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
            if($page_name =='stud_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="stud_report.php" style="color:#7CA32F;">Manage Individual Student Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="stud_report.php" style="color:#666666;">Manage Individual Student Report</a></td>
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
           /* if($page_name =='disclaimer_report.php')
            {*/
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="disclaimer_report.php" style="color:yellow;">Disclaimer Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
           /* }
            else
            {*/
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="disclaimer_report.php" style="color:white;">Disclaimer Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
           /* }*/
            
            ?>
</table>
</td>-->
   </tr>
</table>