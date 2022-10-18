<?php  include 'inc_classes.php';
if($_POST['show_report'] && $_POST['student_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{  
	$student_id = $_POST['student_id'];
	$sele_stud="select * from stud_login where stud_login_id='".$student_id."'";
	$ptr_stud=mysql_query($sele_stud);
	$data_stud=mysql_fetch_array($ptr_stud);
	
	$select_ex="select * from exams where exam_number ='".$data_stud['examination_number']."' ";
   	$ptr_ex=mysql_query($select_ex);
	$total_ex = mysql_num_rows($ptr_ex);
	$data_ex=mysql_fetch_array($ptr_ex);
	$i=1;
	
	echo' <table style="border-top:2px solid #0066cc;" width="100%">
            <tr><td><table width="100%">
             <tr>
                <td align="center" style="color:#0066cc;font-size:18px" colspan="3"><strong>Student Report Showing Questions and Answer</strong></td>
				
				<td align="right" width="5%"><input class="input_btn" type="button" name="print" value="Print" title="Print" border="0" 
					onclick=\'window.open("student_report_print.php?exam_no='.$data_stud['examination_number'].'&student_id='.$_POST['student_id'].'","View Invoice","scrollbars=yes","resizable=yes","width=900,height=600")\' style="cursor:pointer" ></td>
             </tr>
             <tr>
                <td width="10%">Examination Number</td><td width="2%">:</td>
                <td width="46%">'.$data_stud['examination_number'].'</td>
             </tr>
             <tr>
                <td>Student Name</td><td width="2%">:</td>
                <td>'.$data_stud['name'].'</td>
             </tr>
             <tr>
                <td>Marks</td><td width="2%">:</td>
                <td>'.$data_ex['exam_mark'].'</td>
             </tr>
             <tr>
                <td align="center" colspan="3">
                <table style="border:1px solid #0066cc;	border-collapse: collapse;" width="90%" border="1px" align="center">
                    	<tr bgcolor="#0066cc" style="color:#FFF">
                        	<td align="center">Sr. No.</td>
                            <td align="center">Question No.</td>
							<td align="center">Topic</td>
                            <td align="center">Answer</td>
                            <td align="center">Marks</td>
                        </tr>';
						echo '<input type="hidden" name="student_id" id="student_id" value="'.$student_id.'"/>';
			$select_ques="select * from student_paper where student_id='".$student_id."' and exam_no='".$data_stud['examination_number']."' order by question_id asc";	
			$ptr_std=mysql_query($select_ques);	
			if($total_std=mysql_num_rows($ptr_std))
			{
				$total_m=0;
				$j=1;
				while($data_std=mysql_fetch_array($ptr_std))
				{
					"<br />".$sel_ques_name="select question_id,question_title,unit_id from question where question_id='".$data_std['question_id']."' order by question_id asc";
					$ptr_que=mysql_query($sel_ques_name);
					$data_que=mysql_fetch_array($ptr_que);
					
					"<br />".$sel_opt="select * from options where question_id='".$data_std['question_id']."' and answer='y'";
					$ptr_opt=mysql_query($sel_opt);
					$data_opt=mysql_fetch_array($ptr_opt);
					
					$sel_unit="select topic_name from topic where topic_id='".$data_que['unit_id']."'";
					$ptr_unit=mysql_query($sel_unit,$con2);
					$data_unit=mysql_fetch_array($ptr_unit);
					
					if($data_opt['option_id']==$data_std['answer_option'])
					{ $correct="Right"; $mark="1"; $total_m +=1;}
					else
					{ $correct="Wrong"; $mark="0";}
					
                        echo'<tr>
                            <td>'.$j.'</td>
                        	<td>'.$data_que['question_id'].''.'('.$data_que['question_id'].')</td>
							<td>'.$data_unit['topic_name'].'</td>
                            <td>'.$correct.'</td>
                            <td>'.$mark.'</td>
                        </tr>';
						
				$j++;
				}
				 echo'<tr>
                            <td style="background-color:#0066cc;color:white">&nbsp;</td>
                        	<td style="background-color:#0066cc;color:white">&nbsp;</td>
							<td style="background-color:#0066cc;color:white">&nbsp;</td>
                            <td style="background-color:#0066cc;color:white">Total</td>
                            <td style="background-color:#0066cc;color:white">'.$total_m.'</td>
                        </tr>';
				
			}
			else
			{
				 echo'<tr>
                        	<td colspan="4">Question Not found </td>
                        </tr>';
			}
               echo '</table></td>
              </tr>
              
            </table></td>
            </tr>
          </table>';
    ?>
   
        <br />
        <input type="text"   name="new_dist" id="new_dist" class="input_text"  style="display:none" placeholder="New Chapter" />
         </div>
    <?php
}
?>
