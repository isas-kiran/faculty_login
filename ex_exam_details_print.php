<?php include 'ex_inc_classes.php';?>
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
				$exam_no=$_GET['exam_no'];
				$ans_action='';
				if($_GET['ans_action']!='')
				{
					$ans_action=$_GET['ans_action'];
				}
				else
				{
					$ans_action='wo_ans';
				}
				$select_exams="select * from ex_exams where (exam_number='".$exam_no."') order by exams_id desc";
				$ptr_exam=mysql_query($select_exams);
				$data_ex=mysql_fetch_array($ptr_exam);
	
				$select_syll="select name from subject where subject_id='".$data_ex['syllabus_id']."'";
				$ptr_syll=mysql_query($select_syll);
				$data_syllabus=mysql_fetch_array($ptr_syll);
				
				$sel_lang="select * from ex_language where language_id='".$data_ex['language_id']."'";
				$ptr_lang=mysql_query($sel_lang);
				$data_lang=mysql_fetch_array($ptr_lang);
	
				echo '<input type="hidden" name="total_topic" value="'.$c.'"/>';
			?>  
            <!--<table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
            	<tr height="5">
            	</tr>
            </table>-->
            <table align="center" style="border:1px solid #0066cc;" width="786" >
            	<tr>
                    <td  align="center"valign="top" width="701" style="font-size:20px" colspan="2">MCQ Examination</td>
                    <td width="26" align="right" style="padding-right:15px;">
                       	<table width="99%"></table>
                       	<td width="43" valign="top">
                        <?php
                        if($_GET['action'] !='print')
                        {
                        	?>
							<a href="exam_details_print.php?exam_no=<?php echo $exam_no ?>&ans_action=<?php echo $ans_action; ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a><?php } ?>
                    	</td>
				</tr>
                <!--<tr>
                    <td align="center" colspan="4">          
                    <table align="center" border="1px"  width="786" cellpadding="5" cellspacing="0" bgcolor="" style=" border:1px solid;" >
                        <tr style="padding-left:10px">
                            <td width="146"><strong style="padding-left:10px">Examination No :&nbsp;&nbsp;&nbsp;</strong><?php //echo $exam_no; ?></td>
                            <td width="141"><strong style="padding-left:10px">Syllabus :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_syllabus['syllabus_name']; ?></td>
                        </tr>
                        <tr>
                            <td><strong style="padding-left:10px">Mark  :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_ex['exam_mark']; ?></td>
                            <td><strong style="padding-left:10px">Language :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_lang['language_name']; ?></td>
                        </tr>
                        <tr>
                            <td><strong style="padding-left:10px">Duration  :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_ex['exam_duration']; ?></td>
                            <td><strong style="padding-left:10px">Exam Passing Grade  :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_ex['pass_grade_from'].' %'; ?></td>
                        </tr>
                        <?php 
                        /*$sep_from_date=explode("-",$data_ex['validity_fromdate']);
                        $from_date=$sep_from_date[2]."/".$sep_from_date[1]."/".$sep_from_date[0];
                        $sep_to_date=explode("-",$data_ex['validity_fromdate']);
                        $to_date=$sep_to_date[2]."/".$sep_to_date[1]."/".$sep_to_date[0];
                        ?>
                        <tr>
                            <td><strong style="padding-left:10px">From Date  :&nbsp;&nbsp;&nbsp;</strong><?php echo $from_date; ?></td>
                            <td><strong style="padding-left:10px">To Date  :&nbsp;&nbsp;&nbsp;</strong><?php echo $to_date; ?></td>
                        </tr>
                        <?php
                        $sel_papere="select DISTINCT(papers_id) from exams_section where exams_id='".$data_ex['exams_id']."'";
                        $ptr_paper=mysql_query($sel_papere);
                        $data_paper=mysql_fetch_array($ptr_paper);
						
                        $select_unit_ids="select paper_name from papers where papers_id='".$data_paper['papers_id']."'";
                        $ptr_unit_ids=mysql_query($select_unit_ids);
                        $data_unit_ids=mysql_fetch_array($ptr_unit_ids);*/
                        ?>
                    	<tr>
                        	<td><strong style="padding-left:10px">Paper No :&nbsp;&nbsp;&nbsp;</strong><?php //echo $data_unit_ids['paper_name']; ?></td>
                        	<td><strong></strong></td>
                    	</tr>
                	</table>
            		</td>
        		</tr>-->
                <tr>
           			<td colspan="4">&nbsp;&nbsp;<!--<hr / style="border-color:#0066cc;">--></td>
                </tr>
	            <?php	
						$select_exams="select * from ex_exams where (exam_number='".$exam_no."') order by exams_id desc";
						$ptr_exam=mysql_query($select_exams);
						$data_ex=mysql_fetch_array($ptr_exam);
						$sele_ex="select * from ex_exams_section where exams_id='".$data_ex['exams_id']."' and language_id='".$data_ex['language_id']."' ";
						$ptr_my=mysql_query($sele_ex);
						$q=1;
						if(mysql_num_rows($ptr_my))
						{
							while($data_mys_exam=mysql_fetch_array($ptr_my))
							{
							 	$select_question_first = " select question_title,question_id,question_img from ex_question where question_id='".$data_mys_exam['question_id']."' and language_id='".$data_ex['language_id']."' order by question_id asc " ;
								$ptrs_first_que = mysql_query($select_question_first) ;
								$i=0 ;
                                if(mysql_num_rows($ptrs_first_que)) 
								{ 
									$data_ptr_last_que = mysql_fetch_array($ptrs_first_que);
									$question_id = $data_ptr_last_que['question_id'];
									$question_title = stripslashes(html_entity_decode($data_ptr_last_que['question_title']));
									$question_img = $data_ptr_last_que['question_img'];
									echo "<input type='hidden' name='current_question' id='current_questions' value='".$question_id."' >";
									$select_option_last ="select * from ex_options where question_id='$question_id' ";
									$ptrs_option = mysql_query($select_option_last);
									?>
                                    <tr>
	                                   	<td valign="top" style="padding-top:8px"><?php echo $q ?>. </td>
                                        <td width="97%">
                                        <table cellpadding="3" cellspacing="3" width="100%">
    	                                    <tr>
        	                                    <td colspan="3"><span style=" font-size:16px;"><?=$question_title;?>
            	                                <?php if($question_img !=''){?><img src="ex_question_photo/<?php echo $question_img; ?>" height="50" width="100"/><?php }?>
                                                </span></td>
                                            </tr>
                                            <?php 
											$p=1;
											while($data_opt = mysql_fetch_array($ptrs_option))
											{
												$options_img=$data_opt['option_image'];
												?>
												<tr>
													<td width="25">
													<input type="radio" name="ans_<?php echo $question_id; ?>"  value="<?php echo $p; ?>" <?php if($data_opt['answer']=='y' && $ans_action=="with_ans") { echo 'checked="checked"'; } ?> /></td>					
													<td> <?=stripslashes(html_entity_decode($data_opt['option_title']))?> <?php if(strlen($options_img) >10){ ?> <img src="ex_question_photo/<?php echo $options_img; ?>" height="50" width="100" /><?php }?> </td>
												</tr>
												<?php 
												$p++;
											}?>
                                        </table>
                                        </td>
                                    </tr>
                                    <tr>
					                    <td>&nbsp;</td>
					                </tr>
                                    <?php
								}
								$q++;
							}			  
						}?>                
                	<tr>
                		<td>&nbsp;</td>
                	</tr>
			</table>
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