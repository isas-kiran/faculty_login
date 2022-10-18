<?php include 'inc_classes.php';?>

<?php include "../classes/thumbnail_images.class.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
	jQuery(document).ready( function() {
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
    </script>
    <link rel="stylesheet" href="js/jquery.custom/development-bundle/themes/base/jquery.ui.all.css">
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

    <script type="text/javascript">
    $(document).ready(function()
    {
        //$('.date-input-1').datepicker({ maxDate: "+0D",changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-1').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-2').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst) 
        {
            res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
        }
    });
    </script>
    <style>
	.left_border{ border-left:solid #999 1px; }
	.right_border{ border-right:solid #999 1px;}
	.right_border1{ border-right:solid #EFEFEF  1px;}
	.top_border{ border-top:solid #999 1px;}
	.bottom_border{ border-bottom:solid #999 1px;}
	body{ font-family:Verdana, Geneva, sans-serif}
	</style>
</head>
<body>
  <div class="heightSpacer"></div>
  
     <?php
         $exam_no =$_GET['exam_no'];
		 
		 $sel_examno="select * from exams where exam_number='".$_GET['exam_no']."' or school_code='".$_GET['exam_no']."'";
		 $ptr_exams=mysql_query($sel_examno);
		 $data_examno=mysql_fetch_array($ptr_exams);
		 ?>
         
         <table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
             <tr>
                <td valign="top" width="304" style="font-size:25px">MCQ Examination</td>
                <td width="420" align="right" style="padding-right:15px;">
                   <table width="99%"></table>
                   
                   <td width="42" valign="top">
					<?php
                     if($_GET['action'] !='print')
                     {
                     ?>
                    <a href="exam_report_print.php?exam_no=<?php echo $exam_no ?>&analyst_sheet=<?php echo $_GET['analyst_sheet'] ?>&summeryreport=<?php echo $_GET['summeryreport'] ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
                    <?php } ?>
                   </td>
                   
                   <td width="0"></td>
               </tr>
                    <tr height="5">
            </tr></table>
            
            <table align="center" style="border:1px solid #0066cc;" width="786" bgcolor="#EFEFEF">
               <tr>
                  <td colspan="3"><strong>Examination Number :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_examno['exam_number']; ?></td>
              </tr>
              
               <tr>
                  <td colspan="3"><strong>School Code :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_examno['school_code']; ?></td>
              </tr>
               <tr>
                  <td>&nbsp;</td>
               </tr>
               
               <?php 
		if($_GET['analyst_sheet']=="on")
		{
			
			$sele_stud="select * from stud_login where (examination_number='".$_GET['exam_no']."') and exam_stoped =''";
			$ptr_stud=mysql_query($sele_stud);
			$data_stud=mysql_fetch_array($ptr_stud);
			
			$sel_examno="select * from exams where exam_number='".$data_stud['examination_number']."' ";
			$ptr_exams=mysql_query($sel_examno);
			$data_examno=mysql_fetch_array($ptr_exams);
		?>
        <tr><td colspan="3" style="padding-bottom:30px">
        	<table style="border:2px solid #0066cc; padding-bottom:10px" width="100%">
            <tr>
            	<td>Examination Number : <?php echo $data_examno['exam_number'] ;?></td>
            </tr>
            
             <tr>
            	<td>School Code : <?php echo $data_examno['school_code'] ;?></td>
            </tr>
            
            <tr>
            	<td align="center" style="color:#0066cc; font-size:18px"><strong>Examination Analysis Sheet</strong></td>
            </tr>
            <tr>
            	<td align="center">
                	<table style="border:1px solid #0066cc;	border-collapse: collapse;" width="90%" border="1px">
                    	<tr bgcolor="#0066cc" style="color:#FFF">
                        	<td width="7%" align="center">Sr. No.</td>
                        	<td width="57%" align="center">Unit</td>
                            <td width="36%" align="center">Incorrect Questions</td>
                        </tr>
                        <?php
						/*$k=1;
						
						$sel_exam_ques="select DISTINCT(question_id) from student_paper where exam_no='".$data_examno['exam_number']."'";
						$ptr_ques=mysql_query($sel_exam_ques);
						$total_questions=mysql_num_rows($ptr_ques);
						while($data_exam_ques=mysql_fetch_array($ptr_ques))
						{
							
							$sel_ques1="select * from question where question_id='".$data_exam_ques['question_id']."'";
							$ptr_ques1=mysql_query($sel_ques1);
							$data_ques1=mysql_fetch_array($ptr_ques1);
							
							"<br />".$sel_incorrect="select answer_option,question_id from student_paper where question_id='".$data_exam_ques['question_id']."' and exam_no='".$data_examno['exam_number']."'";
							$ptr_ques_id=mysql_query($sel_incorrect);
							$totals_question=mysql_num_rows($ptr_ques_id);
							$t=0;
							$total=0;
							while($data_totals=mysql_fetch_array($ptr_ques_id))
							{
								 "<br />".$select_options="select * from options where question_id='".$data_ques1['question_id']."' and answer='y' limit 0,1";
								$ptr_opt=mysql_query($select_options);
								$total_right=mysql_num_rows($ptr_opt);
								$data_total_rit=mysql_fetch_array($ptr_opt);
								
								if($data_total_rit['option_id']==$data_totals['answer_option'])
								{
									$t;
								}
								else
								{
									 $total +=1;
								}
								
								$t++;	
							}
							
						 ?>
                        <tr>
                        	<td align="center"><?php echo $k; ?></td>
                        	<td><?php echo $data_ques1['question_title'] ?>
                            <?php if($data_ques1['question_img'] !=''){ ?> <img src="../onlinemcq/question_photo/<?php echo $data_ques1['question_img']; ?>" height="50" width="100" /><?php }?>
                            </td>
                            <td><?php echo  $total;?></td>
                        </tr>
						<?php 
						$k++;
						 }*/
						$k=1;
						"<br />----".$sel_exam_ques="select DISTINCT(unit_id) from exams_section where exams_id='".$data_examno['exams_id']."'";
						$ptr_ques=mysql_query($sel_exam_ques);
						$total_questions=mysql_num_rows($ptr_ques);
						$total_ques =0;
						while($data_exam_ques=mysql_fetch_array($ptr_ques))
						{
							$sel_unitid="select * from unit where unit_id='".$data_exam_ques['unit_id']."'";
							$ptr_unitid=mysql_query($sel_unitid);
							$data_unitid=mysql_fetch_array($ptr_unitid);
							
							/*$sel_ques1="select * from question where unit_id='".$data_exam_ques['unit_id']."'";
							$ptr_ques1=mysql_query($sel_ques1);*/
							
								"<br/>UNIT_QUESTION>>>>>".$sel_unit_ques1="select question_id from question where unit_id='".$data_exam_ques['unit_id']."'";
								$ptr_unit_ques1=mysql_query($sel_unit_ques1);
								$tota_unit_ques=mysql_num_rows($ptr_unit_ques1);
								$t=0;
								$total=0;
								$unattend='';
								while($data_ques1=mysql_fetch_array($ptr_unit_ques1))
								{
									
									"<br/>--------".$sele_quest="select question_id from student_paper where question_id='".$data_ques1['question_id']."' and exam_no='".$data_examno['exam_number']."'";
									$ptrs_quesrt=mysql_query($sele_quest);
									if($stude_total_ques=mysql_num_rows($ptrs_quesrt))
									{
										$datas_quest=mysql_fetch_array($ptrs_quesrt);
										
										"<br/>===============".$sel_incorrect="select answer_option,question_id,exam_no from student_paper where exam_no='".$data_examno['exam_number']."' and question_id='".$datas_quest['question_id']."' ";
										$ptr_ques_id=mysql_query($sel_incorrect);
										if($totals_question=mysql_num_rows($ptr_ques_id))
										{
											while($data_totals=mysql_fetch_array($ptr_ques_id))
											{
												$total_ans=$data_totals['answer_option'];
												"<br/>===>>>>>>>".$sel_ques1="select * from question where question_id='".$data_totals['question_id']."'";
												$ptr_ques1=mysql_query($sel_ques1);
												if($totals_question11=mysql_num_rows($ptr_ques1))
												{
													$data_ques1=mysql_fetch_array($ptr_ques1);
														
													"<br />".$select_options="select * from options where question_id='".$data_totals['question_id']."' and answer='y' limit 0,1";
													$ptr_opt=mysql_query($select_options);
													$total_right=mysql_num_rows($ptr_opt);
													$data_total_rit=mysql_fetch_array($ptr_opt);
														
													if($data_total_rit['option_id']==$total_ans)
													{
														$t;
													}
													else
													{
														$total +=1;
														$total_ques +=1;
													}
														
												}
												$t++;
											}
										}
									}
									else
									{
										$unattend +=1;
									}
								}
							
						 ?>
                        <tr>
                        	<td align="center"><?php echo $k; ?></td>
                        	<td><?php echo $data_unitid['unit'] ?>
                            <?php // if($data_ques1['question_img'] !=''){ ?> <!--<img src="../onlinemcq/question_photo/<?php //echo $data_ques1['question_img']; ?>" height="50" width="100" /> --><?php //}?>
                            </td>
                            <td><?php echo $total;?></td>
                        </tr>
                        
						<?php 
						$k++;
						 }?>
                         <tr>
                        	<td colspan="2" align="center"><strong>Total</strong></td>
                        	
                            <td><strong><?php echo $total_ques;?></strong></td>
                        </tr>
                        <!--<tr>
                        	<td colspan="2" align="center"><strong>Unattended</strong></td>
                        	
                            <td><strong><?php //echo $unattend;?></strong></td>
                        </tr>-->
                    </table>
                </td>
            </tr>
        	</table>
        </td></tr>
         <?php } ?>

 <?php 
		if($_GET['summeryreport']=="on")
		{
			$sele_stud="select * from stud_login where (examination_number='".$_GET['exam_no']."' ) and exam_stoped =''";//or school_code='".$_GET['exam_no']."'
			$ptr_stud=mysql_query($sele_stud);
			$data_stud=mysql_fetch_array($ptr_stud);
				
			$select_exams="select * from exams where exam_number='".$data_stud['examination_number']."'  ";
			$ptr_ex=mysql_query($select_exams);
			$data_exams=mysql_fetch_array($ptr_ex);
			
			
		?>
        <tr><td colspan="3" style="padding-bottom:30px">
        	<table style="border:2px solid #0066cc;" width="100%">
            <tr>
            	<td>Examination Number :  <?php echo  $data_exams['exam_number'] ?></td>
            </tr>
            
            <tr>
            	<td>School Code : <?php echo $data_exams['school_code'] ;?></td>
            </tr>
            
            <tr>
            	<td align="center" style="color:#0066cc;font-size:18px"><strong>Exam Summary Report</strong></td>
            </tr>
            <tr>
            	<td align="center">
                	<table style="border:1px solid #0066cc;	border-collapse: collapse;" width="90%" border="1px" align="center">
                    	<tr bgcolor="#0066cc" style="color:#FFF">
                        	<td align="center">Sr.No</td>
                        	<td align="center">Student Name</td>
                            <td align="center">Examination Appeared Date</td>
                            <td align="center">Examination Result</td>
                            <td align="center">Result</td>
                        </tr>
                        <?php
						
						$select_non_stopped_exam = "select stud_login_id as student_id from stud_login where examination_number='".$data_exams['exam_number']."' and exam_stoped ='' ";
						$ptr_student_nn = mysql_query($select_non_stopped_exam);
						if(mysql_num_rows($ptr_student_nn))
						{
							$y=1;
							while($data_stud = mysql_fetch_array($ptr_student_nn))
							{
							$sel_exam_ques="select Distinct(student_id) from student_paper where exam_no='".$data_exams['exam_number']."' and student_id='".$data_stud['student_id']."'  order by attempt_id desc";
							$ptr_ques=mysql_query($sel_exam_ques);
							$total_questions=mysql_num_rows($ptr_ques);
							if($total_questions)
							{
								while($data_ques=mysql_fetch_array($ptr_ques))
								{
									$total_ex_mark=$data_exams['exam_mark'];
									$total_ques=$data_exams['total_ques'];
									$pass_grade=$data_exams['pass_grade_from'];
							
									$select="select * from stud_login where stud_login_id='".$data_ques['student_id']."' and exam_stoped ='' order by added_date desc";
									$ptr_student=mysql_query($select);
									$data_student=mysql_fetch_array($ptr_student);
							
									$date=explode("-",$data_student['added_date']);
									$newdate=$date[2]."/".$date[1]."/".$date[0];
							
									$selec_subject_nam="SELECT student_paper.question_id, options.question_id,options.option_id,options.option_title,options.answer
						  			FROM student_paper, options WHERE student_paper.question_id = options.question_id AND student_paper.student_id='".$data_student['stud_login_id']."' and student_paper.answer_option = options.option_id  GROUP BY options.question_id";
						  			$ptr_subject=mysql_query($selec_subject_nam);
									$total=0;
									if(mysql_num_rows($ptr_subject))
									{
										$t=1;
										while( $val_option=mysql_fetch_array($ptr_subject))
										{
											$option_title=$val_option['option_title'];
											$option_ans=$val_option['answer'];
											if($option_ans=='y')
											{
												$total=$t;
												$t++;
											}
										}
									}
									$per=($total*100)/$total_ex_mark;
									if($per<$pass_grade)
									{$result="Fail";}
									else {$result="Pass";}
						 			?>
                        			<tr>
                        				<td align="center"><?php echo $y; ?></td>
                            			<td align="center"><?php echo $data_student['name']."  (".$data_student['pass'].")";?></td>
                            			<td align="center"><?php echo $newdate; ?></td>
                            			<td align="center"><?php echo $per."%"; ?></td>
                            			<td align="center"><?php echo $result; ?></td>
                        			</tr>
                       				<?php
								}
							}
						 	$y++;
						}
					}?> 
                    </table>
                </td>
            </tr>
        </table>
     </td></tr>
<?php } ?>
		
         <?php
			if($_GET['action']=='print')
			{
			?>
			<script language="javascript">
			
			window.print();
			//window.close();
			setTimeout('window.close();',3000);
			//setTimeout('window.close();',5000);
			</script>
			<?php	
			}							
			?>
			</body>
			</html>
			<?php $db->close();?>