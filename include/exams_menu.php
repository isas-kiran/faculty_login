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
                        if($page_name =='ex_manage_exams.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_manage_exams.php" style="color:#7CA32F;">Manage Exam  </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_manage_exams.php" style="color:#666666;">Manage Exam </a></td>
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
            if($page_name == 'ex_add_exams.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_add_exams.php" style="color:#7CA32F;">Add Exam </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_add_exams.php" style="color:#666666;">Add Exam </a></td>
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
            if($page_name == 'ex_manage_mcq_paper.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_manage_mcq_paper.php" style="color:#7CA32F;">Manage MCQ Paper </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_manage_mcq_paper.php" style="color:#666666;">Manage MCQ Paper </a></td>
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
            if($page_name == 'ex_add_mcq_paper.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_add_mcq_paper.php" style="color:#7CA32F;">Add MCQ Paper </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_add_mcq_paper.php" style="color:#666666;">Add MCQ Paper </a></td>
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
            if($page_name == 'ex_manage_question.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_manage_question.php" style="color:#7CA32F;">Manage Questions</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_manage_question.php" style="color:#666666;">Manage Questions </a></td>
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
            if($page_name == 'ex_add_questions.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_add_questions.php" style="color:#7CA32F;">Add Questions</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_add_questions.php" style="color:#666666;">Add Questions </a></td>
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
            if($page_name == 'ex_edit_disclaimer.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_edit_disclaimer.php" style="color:#7CA32F;">Edit Discliamer</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_edit_disclaimer.php" style="color:#666666;">Edit Discliamer </a></td>
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
                if($page_name == 'ex_live_student.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_live_student.php" style="color:#7CA32F;">Stop Exam</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_live_student.php" style="color:#666666;">Stop Exam</a></td>
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
                if($page_name == 'ex_stopped_student.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_stopped_student.php" style="color:#7CA32F;">Restart Exam</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_stopped_student.php" style="color:#666666;">Restart Exam</a></td>
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
                if($page_name == 'ex_restarted_exam.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_restarted_exam.php" style="color:#7CA32F;">Restarted Exams</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_restarted_exam.php" style="color:#666666;">Restarted Exams</a></td>
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
                        if($page_name == 'ex_intrupted_student.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_intrupted_student.php" style="color:#7CA32F;">Intrupted Exam</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_intrupted_student.php" style="color:#666666;">Intrupted Exam</a></td>
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
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='import_mcq.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_mcq.php" style="color:#7CA32F;">Import MCQ</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_mcq.php" style="color:#666666;">Import MCQ</a></td>
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
        if($array_previ_parent[$e]['privilege_id']==5) //'for only change password'
        {
           
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==48)
				{
			?>
               
            <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php 
                        if($page_name =='ex_manage_exams.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_manage_exams.php" style="color:#7CA32F;">Manage Exam  </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_manage_exams.php" style="color:#666666;">Manage Exam </a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
                </table>
            </td>
            <?php }elseif($array_prev[$e][$f]['privilege_id']==300){?>
                <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php
            if($page_name == 'ex_add_exams.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_add_exams.php" style="color:#7CA32F;">Add Exam </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_add_exams.php" style="color:#666666;">Add Exam </a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
                </td>



                   <?php }elseif ($array_prev[$e][$f]['privilege_id']==301) {?>
                    <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php
            if($page_name == 'ex_manage_mcq_paper.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_manage_mcq_paper.php" style="color:#7CA32F;">Manage MCQ Paper </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_manage_mcq_paper.php" style="color:#666666;">Manage MCQ Paper </a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
                </td>
                    <?php }elseif($array_prev[$e][$f]['privilege_id']==302){?>
                    <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php
            if($page_name == 'ex_add_mcq_paper.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_add_mcq_paper.php" style="color:#7CA32F;">Add MCQ Paper </a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_add_mcq_paper.php" style="color:#666666;">Add MCQ Paper </a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
                </td>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==303) {?>
                    <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php
            if($page_name == 'ex_manage_question.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_manage_question.php" style="color:#7CA32F;">Manage Questions</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_manage_question.php" style="color:#666666;">Manage Questions </a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
                </td>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==304) {?>
                    <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php
            if($page_name == 'ex_add_questions.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_add_questions.php" style="color:#7CA32F;">Add Questions</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_add_questions.php" style="color:#666666;">Add Questions </a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
                </td>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==305) {?>
                    <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php
            if($page_name == 'ex_edit_disclaimer.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_edit_disclaimer.php" style="color:#7CA32F;">Edit Discliamer</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_edit_disclaimer.php" style="color:#666666;">Edit Discliamer </a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
                </td>
            
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==306) {?>
                    <td>
                <table border="0" cellspacing="0" cellpadding="0">
                <?php
                if($page_name == 'ex_live_student.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_live_student.php" style="color:#7CA32F;">Stop Exam</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_live_student.php" style="color:#666666;">Stop Exam</a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
            </td>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==307) {?>
                    <td>
                <table border="0" cellspacing="0" cellpadding="0">
                <?php
                if($page_name == 'ex_stopped_student.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_stopped_student.php" style="color:#7CA32F;">Restart Exam</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_stopped_student.php" style="color:#666666;">Restart Exam</a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
            </td>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==308) {?>
                        <td>
                <table border="0" cellspacing="0" cellpadding="0">
                <?php
                if($page_name == 'ex_restarted_exam.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_restarted_exam.php" style="color:#7CA32F;">Restarted Exams</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_restarted_exam.php" style="color:#666666;">Restarted Exams</a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
            </td>
            <?php }elseif ($array_prev[$e][$f]['privilege_id']==309) {?>
                        <td>
                        <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <?php
                        if($page_name == 'ex_intrupted_student.php')
                        {
                        ?>
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><a href="ex_intrupted_student.php" style="color:#7CA32F;">Intrupted Exam</a></td>
                            <td class="tab2_right"></td>
                        </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td class="tab_left"></td>
                            <td class="tab_mid"><a href="ex_intrupted_student.php" style="color:#666666;">Intrupted Exam</a></td>
                            <td class="tab_right"></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
            </td> 
            <?php
				}elseif($array_prev[$e][$f]['privilege_id']==310)
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
				}else if($array_prev[$e][$f]['privilege_id']==312){?>
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
				 else if($array_prev[$e][$f]['privilege_id']==320){?>
                    <td>
                         <table border="0" cellspacing="0" cellpadding="0">
                         <?php 
                            if($page_name =='import_mcq.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="import_mcq.php" style="color:#7CA32F;">Import MCQ</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="import_mcq.php" style="color:#666666;">Import MCQ</a></td>
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