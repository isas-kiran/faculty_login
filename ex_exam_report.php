<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM grade where grade_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Exam Report</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	jQuery(document).ready( function() 
	{
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
</script>   
<!--<script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script>
function show_subject(subject)
{
	//alert(subject);
	var data1="show_subject=1&subject="+subject;
	 $.ajax({
	url: "ex_show_subjects.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
	 document.getElementById('show_subject').innerHTML=html;
	}
	});
}
</script> 
<script type="text/javascript">
checked=false;
function checkedAll (search1) 
{
	var aa= document.getElementById('jqueryForm');
	if (checked == false)
	{
		checked = true
	}
	else
	{
		checked = false
	}
	for (var i =0; i < aa.elements.length; i++){ aa.elements[i].checked = checked;}
}
</script>
<script>
function validin()
{
	frm=document.jqueryForm;
	disp_error="Please Correct Following errors\n\n";
	error="";
	
	if(frm.exam_no.value=='')
	{
		disp_error +="Enter Exam Number\n";
		document.getElementById('exam_no').style.border = '1px solid #f00';
		frm.exam_no.focus();
		error="yes";
	}
	/*if(frm.unit_id.checked==false)
	{
		disp_error +="Select Unit Name\n";
		document.getElementById('unit_id').style.border = '1px solid #f00';
		frm.unit_id.focus();
		error="yes";
	}*/
	var checkBoxes = document.getElementsByClassName( 'case' );
	var isChecked = false;
	 for (var i = 0; i < checkBoxes.length; i++) {
        if ( checkBoxes[i].checked ) {
            isChecked = true;
        };
    };
    if ( isChecked ) {
        /*alert( 'At least one checkbox checked!' );*/
        } else {
			
       		disp_error +="Please Select at least one report\n";
			error="yes";
        }   
          
	
	if(error=="yes")
	{
		alert(disp_error);
		return false;
	}
	else
	return true;
	
}
</script> 
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "ex_include/exams_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">
        <?php
		$errors=array(); $i=0;
		$success=0;
		if($_POST['save_changes'])
		{
			$grade=$_POST['grade'];
			$from=$_POST['from'];
			$to=$_POST['to'];
			if($grade=="")
			{
					$success=0;
					$errors[$i++]="Enter Language name ";
			}
			if(count($errors))
			{
				?>
<tr><td> <br></br>
				<table align="left" style="text-align:left;" class="alert">
				<tr><td ><strong>Please correct the following errors</strong><ul>
						<?php
						for($k=0;$k<count($errors);$k++)
							echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
						</ul>
				</td></tr>
				</table>
		 		</td></tr>   <br></br>  
				<?php
			}
			else
			{
				$success=1;
				$data_record['grade'] =$grade;
				$data_record['from'] =$from; 
				$data_record['to'] =$to; 
			   if($record_id)
				{
					$where_record="grade_id='".$record_id."'";
					$db->query_update("grade", $data_record,$where_record);
					echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
				}
				else
				{
					$record_id=$db->query_insert("grade", $data_record);
					echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				}
			}
		}
		if($success==0)
		{
			?>
            <tr><td>
        	<form method="get" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
            	<table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
                    <tr>
                    <td width="20%">Examination Number<span class="orange_font">*</span></td>
                        <td width="40%" style=""><input type="text"  class="validate[required] input_text" name="exam_no" id="exam_no" value="<?php if ($_POST['exam_no']) echo $_POST['exam_no']; else echo $_GET['exam_no']; ?>" />
                        
                        <!--<input type="hidden"  name="school_code" id="school_code" value="<?php //if ($_POST['school_code']) echo $_POST['school_code']; else echo $_GET['school_code']; ?>" />-->
                        </td> 
                        <td width="40%"></td>
                    </tr>
                    <tr>
                    	<td width="20%"><span class="orange_font"></span></td>
                         <td width="40%">
                         <input type="checkbox" class="case" name="analyst_sheet" <?php if($_GET['analyst_sheet']=="on") echo 'checked="checked"';?> /> Examination Analysis Sheet<br />
                         <input type="checkbox" class="case" name="summeryreport" <?php if($_GET['summeryreport']=="on") echo 'checked="checked"';?> /> Exam Summary Report<br />
                         </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" class="input_btn" value="Search" onClick="return validin()" name="save_changes">
                        </td>
                    </tr>
                </table>
        	</form>
        </td></tr>
        <?php 
		if($_GET['analyst_sheet']=="on")
		{
  			//echo $sele_stud="select * from stud_login where (examination_number='".$_GET['exam_no']."') and exam_stoped =''";
			$sele_stud="select * from ex_stud_login where examination_number='".$_GET['exam_no']."'";
			$ptr_stud=mysql_query($sele_stud);
		  	while($data_stud=mysql_fetch_array($ptr_stud)){
			if($data_stud['exam_stoped'] ==''){
			  $examno = $data_stud['examination_number'];
			}elseif(($data_stud['exam_stoped'] == 'yes') && ($data_stud['exam_intrupted'] == 'yes')){
			  $examno = $data_stud['examination_number'];
			}elseif(($data_stud['exam_intrupted'] == 'yes') && ($data_stud['reattempt_permission'] == 'yes')){
			  $examno = $data_stud['examination_number'];
			}else{
			  $examno = '';
			}
		}
		$sel_examno="select * from ex_exams where exam_number='".$examno."' ";
		$ptr_exams=mysql_query($sel_examno);
		$data_examno=mysql_fetch_array($ptr_exams);
		?>
        <tr><td colspan="3" style="padding-bottom:30px">
        	<table style=" padding-bottom:10px" width="100%">
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
                        	<td width="57%" align="center">Topics</td>
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
						$sel_exam_ques="select DISTINCT(unit_id) from ex_exams_section where exams_id='".$data_examno['exams_id']."'";
						$ptr_ques=mysql_query($sel_exam_ques);
						$total_questions=mysql_num_rows($ptr_ques);
						$total_ques =0;
						while($data_exam_ques=mysql_fetch_array($ptr_ques))
						{
							$sel_unitid="select topic_name,topic_id from topic where topic_id='".$data_exam_ques['unit_id']."'";
							$ptr_unitid=mysql_query($sel_unitid);
							$data_unitid=mysql_fetch_array($ptr_unitid);
							
							/*$sel_ques1="select * from question where unit_id='".$data_exam_ques['unit_id']."'";
							$ptr_ques1=mysql_query($sel_ques1);*/
							
							"<br/>UNIT_QUESTION>>>>>".$sel_unit_ques1="select question_id from ex_question where unit_id='".$data_exam_ques['unit_id']."'";
							$ptr_unit_ques1=mysql_query($sel_unit_ques1);
							$tota_unit_ques=mysql_num_rows($ptr_unit_ques1);
							$t=0;
							$total=0;
							$unattend='';
							while($data_ques1=mysql_fetch_array($ptr_unit_ques1))
							{
								
								$sele_quest="select question_id from ex_student_paper where question_id='".$data_ques1['question_id']."' and exam_no='".$data_examno['exam_number']."'";
								$ptrs_quesrt=mysql_query($sele_quest);
								if($stude_total_ques=mysql_num_rows($ptrs_quesrt))
								{
									$datas_quest=mysql_fetch_array($ptrs_quesrt);
									
									$sel_incorrect="select answer_option,question_id,exam_no from ex_student_paper where exam_no='".$data_examno['exam_number']."' and question_id='".$datas_quest['question_id']."' ";
									$ptr_ques_id=mysql_query($sel_incorrect);
									if($totals_question=mysql_num_rows($ptr_ques_id))
									{
										while($data_totals=mysql_fetch_array($ptr_ques_id))
										{
											$total_ans=$data_totals['answer_option'];
											$sel_ques1="select * from ex_question where question_id='".$data_totals['question_id']."'";
											$ptr_ques1=mysql_query($sel_ques1);
											if($totals_question11=mysql_num_rows($ptr_ques1))
											{
												$data_ques1=mysql_fetch_array($ptr_ques1);
													
												$select_options="select * from ex_options where question_id='".$data_totals['question_id']."' and answer='y' limit 0,1";
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
                                <td><?php echo $data_unitid['topic_name'] ?>
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
         	<?php 
		}
		if($_GET['summeryreport']=="on")
		{
			$sele_stud="select * from ex_stud_login where examination_number='".$_GET['exam_no']."'";
			$ptr_stud=mysql_query($sele_stud);
			$data_stud=mysql_fetch_array($ptr_stud);
				
			$select_exams="select * from ex_exams where exam_number='".$data_stud['examination_number']."'  ";
			$ptr_ex=mysql_query($select_exams);
			$data_exams=mysql_fetch_array($ptr_ex);
			?>
        	<tr><td colspan="3" style="padding-bottom:30px">
        	<table style="border:2px solid #0066cc;" width="100%">
            <tr>
            	<td>Examination Number :  <?php echo $data_exams['exam_number']; ?></td>
            </tr>
            
            <tr>
            	<td>School Code : <?php echo $data_exams['school_code'] ;?></td>
            </tr>
            
            <tr>
            	<td align="center" style="color:#0066cc;font-size:18px"><strong>Exam Summary Report</strong></td>
            </tr>
            <tr>
            	<td align="center">
                	<table style="border:1px solid #0066cc;	border-collapse: collapse;" width="95%" border="1px" align="center">
                    	<tr bgcolor="#0066cc" style="color:#FFF">
                        	<td align="center">Sr.No</td>
                        	<td align="center">Student Name</td>
                            <td align="center">Exam Appeared Date</td>
                            <td align="center">Exam Result</td>
                            <td align="center">Result</td>
							<td align="center">Exam Status</td>
							<td align="center">Exam Start Time<br/>(UTC time)</td>
							<td align="center">Exam End Time<br/>(UTC time)</td>
							<td align="center">Ques. Attempted</td>
                        </tr>
                        <?php
						$select_non_stopped_exam ="select stud_login_id as student_id,enroll_no from ex_stud_login where examination_number='".$data_exams['exam_number']."' "; //and exam_stoped ='' -->28/3/19
						$ptr_student_nn = mysql_query($select_non_stopped_exam);
						if(mysql_num_rows($ptr_student_nn))
						{
							$y=1;
							while($data_stud=mysql_fetch_array($ptr_student_nn))
							{
								$sel_exam_ques="select Distinct(student_id) from ex_student_paper where exam_no='".$data_exams['exam_number']."' and student_id='".$data_stud['student_id']."'  order by attempt_id desc";
								$ptr_ques=mysql_query($sel_exam_ques);
								$total_questions=mysql_num_rows($ptr_ques);
								if($total_questions)
								{
									while($data_ques=mysql_fetch_array($ptr_ques))
									{
										$total_ex_mark=$data_exams['exam_mark'];
										$total_ques=$data_exams['total_ques'];
										$pass_grade=$data_exams['pass_grade_from'];
								
										$select="select * from ex_stud_login where stud_login_id='".$data_ques['student_id']."' order by added_date desc"; //and exam_stoped ='' -->28/3/19
										$ptr_student=mysql_query($select);
										$data_student=mysql_fetch_array($ptr_student);
								
										$date=explode("-",$data_student['added_date']);
										$newdate=$date[2]."/".$date[1]."/".$date[0];
								
										$selec_subject_nam="SELECT ex_student_paper.question_id, ex_options.question_id,ex_options.option_id,ex_options.option_title,ex_options.answer FROM ex_student_paper, ex_options WHERE ex_student_paper.question_id = ex_options.question_id AND ex_student_paper.student_id='".$data_student['stud_login_id']."' and ex_student_paper.answer_option = ex_options.option_id  GROUP BY ex_options.question_id";
										$ptr_subject=mysql_query($selec_subject_nam);
										$total=0;
										if($total_ques=mysql_num_rows($ptr_subject))
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
										$bgcolor='';
										$per=round(($total*100)/$total_ex_mark,2);
										if($per<$pass_grade)
										{
											$result="Fail";
											$bgcolor='bgcolor="#FD7991"';
										}
										else 
										{
											$result="Pass";
										}
										$status='';
										if($data_student['status']=="inactive")
										{
											$status="Completed";
										}
										else
											$status=$data_student['status'];
											
										if($data_student['exam_stoped']=='yes')
										{
											$status ="Exam Stopped";
										}
										
										$sel_end="select end_time from ex_student_paper_time where student_id='".$data_stud['student_id']."'";
										$ptr_end=mysql_query($sel_end);
										
										$data_end=mysql_fetch_array($ptr_end);
										$cenvertedTime = date('Y-m-d H:i:s',strtotime('+'.$data_end['end_time'].' seconds',strtotime($data_student['exam_start_time'])));
										
										$sel_name="select name from enrollment where enroll_id='".$data_stud['enroll_no']."'";
										$ptr_name=mysql_query($sel_name);
										$data_student_name=mysql_fetch_array($ptr_name);
										?>
										<tr <?php echo $bgcolor; ?> >
											<td align="center"><?php echo $y; ?></td>
											<td align="center"><?php echo $data_student_name['name']." (".$data_student['pass'].")";?>
											</td>
											<td align="center"><?php echo $newdate; ?></td>
											<td align="center"><?php echo $per."%"; ?></td>
											<td align="center"><?php echo $result; ?></td>
											<td align="center"><?php echo $status; ?></td>
											<td align="center"><?php echo $data_student['exam_start_time']; ?></td>
											<td align="center"><?php echo $cenvertedTime; ?></td>
											<?php
											if($_SESSION['admin_id']=="69")
											{
												?>
												<td align="center"><a href="ex_student_question_details.php?exam_no=<?php echo $data_exams['exam_number']; ?>&student_id=<?php echo $data_student['stud_login_id']; ?>" target="_blank"><?php echo $total_ques; ?></a></td>
												<?php
											}
											else
											{
												?>
												<td align="center"><?php echo $total_ques; ?></td>
												<?php
											}
											?>
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
		<?php 
	} ?>
    <?php
	if($_GET['exam_no']!='')
	{ ?>
        <tr>
                <td align="center" colspan="3">
                <?php
				if($_GET['analyst_sheet']=="on")
				{
					$analyst_sheet="&analyst_sheet=".$_GET['analyst_sheet']."";
				}
				if($_GET['summeryreport']=="on")
				{
					$summary_report="&summeryreport=".$_GET['summeryreport']." ";
				}
				echo "
					<input class='input_btn' type='button' name='print' value='Print' title='Print' border='0' 
					onclick=\"window.open('ex_exam_report_print.php?exam_no=".$_GET['exam_no']."".$analyst_sheet."".$summary_report."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' >
					
					";
				?>
        </tr>
        
        <?php
		}
		if($_GET['disclaimer']=="on")
		{
		?>
        <!--<tr>
          <td colspan="3" style="padding-bottom:30px"><table style="border:2px solid #0066cc;" width="100%">
            <tr><td><table width="100%">
              <tr>
                <td width="54%">Examination Number :</td>
                <td width="46%"> <?php //echo  $_GET['exam_no'] ?></td>
              </tr>
              <tr>
                <td>Syllabus :</td>
                <td>test</td>
              </tr>
              <tr>
                <td>Marks :</td>
                <td>100</td>
              </tr>
              <tr>
                <td>Language :</td>
                <td>English</td>
              </tr>
              <tr>
                <td>Duration :</td>
                <td>3hr</td>
              </tr>
              <tr>
                <td align="center" style="color:#0066cc" colspan="3"><strong>Result Of Disclaimer</strong></td>
              </tr>
              <tr>
                <td align="center" colspan="3"><table style="border:1px solid #0066cc;	" width="90%" align="center">
                  <tr>
                    <td colspan="3">Multiple Choice Examination</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="5%" valign="top">1.</td>
                    <td width="95%">Question 1 <br />
                      <input type="radio" name="1" />
                      option 1<br />
                      <input type="radio" name="1" />
                      option 2<br />
                      <input type="radio" name="1" />
                      option 3<br />
                      <input type="radio" name="1" />
                      option 4<br /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="5%" valign="top">2.</td>
                    <td>Question 2 <br />
                      <input type="radio" name="1" />
                      option 1<br />
                      <input type="radio" name="1" />
                      option 2<br />
                      <input type="radio" name="1" />
                      option 3<br />
                      <input type="radio" name="1" />
                      option 4<br /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="5%" valign="top">3.</td>
                    <td>Question 3 <br />
                      <input type="radio" name="1" />
                      option 1<br />
                      <input type="radio" name="1" />
                      option 2<br />
                      <input type="radio" name="1" />
                      option 3<br />
                      <input type="radio" name="1" />
                      option 4<br /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="5%" valign="top">4.</td>
                    <td>Question 4 <br />
                      <input type="radio" name="1" />
                      option 1<br />
                      <input type="radio" name="1" />
                      option 2<br />
                      <input type="radio" name="1" />
                      option 3<br />
                      <input type="radio" name="1" />
                      option 4<br /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center"><input class="input_btn" type="button" name="print" value="Print" /></td>
                <td align="center"><input class="input_btn" type="button" name="save_to_pdf" value="Save To PDF" /></td>
              </tr>
            </table></td>
            </tr>
          </table></td></tr>-->
          <?php }
		  if($_GET['student_report']=="on")
		  {
		  ?>
          <!--<tr>
          <td colspan="3" style="padding-bottom:30px"><table style="border:2px solid #0066cc;" width="100%">
            <tr><td><table width="100%">
              <tr>
                <td width="54%">Examination Number :</td>
                <td width="46%"> <?php //echo  $_GET['exam_no'] ?></td>
              </tr>
              <tr>
                <td>Student Name :</td>
                <td>Kiran Vyavahare</td>
              </tr>
              <tr>
                <td>Marks :</td>
                <td>100</td>
              </tr>
              
              <tr>
                <td align="center" style="color:#0066cc" colspan="3"><strong>Single Student Report Showing Questions and Answer</strong></td>
              </tr>
              <tr>
                <td align="center" colspan="3">
                <table style="border:1px solid #0066cc;	border-collapse: collapse;" width="90%" border="1px" align="center">
                    	<tr bgcolor="#0066cc" style="color:#FFF">
                        	<td align="center">Sr. No.</td>
                            <td align="center">Question No.</td>
                            <td align="center">Answer</td>
                            <td align="center">Marks</td>
                        </tr>
                        <tr>
                        	<td>1</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        	<td>2</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        	<td>3</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        	<td>4</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        	<td>5</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        	<td>6</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table></td>
              </tr>
              
            </table></td>
            </tr>
          </table></td></tr>-->
           	<?php 
			} 
        }?>
        </table></td>
    <td class="mid_right"></td>
  </tr>
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>

</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("ex_include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>