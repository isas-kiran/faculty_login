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
            if($page_name =='ex_exam_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_exam_report.php" style="color:#7CA32F;"> Exam Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_exam_report.php" style="color:#666666;"> Exam Report</a></td>
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
            if($page_name =='ex_student_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_student_report.php" style="color:#7CA32F;">View Exam Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_student_report.php" style="color:#666666;">View Exam Details</a></td>
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
            if($page_name =='ex_stud_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_stud_report.php" style="color:#7CA32F;">Manage Individual Student Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_stud_report.php" style="color:#666666;">Manage Individual Student Report</a></td>
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
<td class="width5"></td>
<?php
   }
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
    $array_previ_parent= $_SESSION['privilege_id_parent']; 
    
    for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==5) //'for only change password'
        {
           
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==310)
				{
			?>
               
            <td>
	        <table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='ex_exam_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_exam_report.php" style="color:#7CA32F;"> Exam Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_exam_report.php" style="color:#666666;"> Exam Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
                </table>
            </td>
            <?php }elseif($array_prev[$e][$f]['privilege_id']==311){?>
            <td>
	             <table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='ex_student_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_student_report.php" style="color:#7CA32F;">View Exam Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_student_report.php" style="color:#666666;">View Exam Details</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
                </table>
            </td><?php
				}elseif($array_prev[$e][$f]['privilege_id']==312){?>
                    <td>
                         <table border="0" cellspacing="0" cellpadding="0">
                         <?php 
                            if($page_name =='ex_stud_report.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="ex_stud_report.php" style="color:#7CA32F;">Manage Individual Student Report</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="ex_stud_report.php" style="color:#666666;">Manage Individual Student Report</a></td>
                                <td class="tab_right"></td>
                            </tr>
                            <?php
                            }
                            
                            ?>
                        </table>
                    </td><?php
                        }
			}
		}
	}
}
				?>
  </tr>
</table>