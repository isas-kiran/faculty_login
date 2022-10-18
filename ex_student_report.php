<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
$exam_no=$_GET['exam_no'];
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
<title>View Exam Details</title>
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
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
   <!-- <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
        });
    </script>-->
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
	//alert(aa);
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
                    <tr><td ><strong>Please correct the following errors</strong>
                    <ul>
                    <?php
                    for($k=0;$k<count($errors);$k++)
					{
                    	echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';
					}
					?>
                    </ul>
                    </td></tr>
                    </table>
                    </td></tr><br></br>  
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
                        <td width="17%" style=""><input type="text"  class="validate[required] input_text" name="exam_no" id="exam_no" value="<?php if ($_POST['exam_no']) echo $_POST['exam_no']; else echo $_GET['exam_no']; ?>"  style="width:160px;height: 26px"/></td> 
                         <td width="63%" ><input type="submit" class="input_btn" value="Search" name="save_changes"  /></td>
                    </tr>
                    <tr>
                    	<td width="20%"><span class="orange_font"></span></td>
                        <td width="17%">
                        <!-- <input type="checkbox" name="analyst_sheet" <?php if($_GET['analyst_sheet']=="on") echo 'checked="checked"';?> /> Examination Analyst Sheet<br />
                         <input type="checkbox" name="summeryreport" <?php if($_GET['summeryreport']=="on") echo 'checked="checked"';?> / > Exam Summery Report<br />-->
                         <!--<input type="checkbox" name="disclaimer" <?php if($_GET['disclaimer']=="on") echo 'checked="checked"';?> /> View Exam Details<br />-->
                        <!-- <input type="checkbox" name="student_report" <?php //if($_GET['student_report']=="on") echo 'checked="checked"';?> /> Student Report of Question and Answer-->
                         </td>
                    </tr>
                </table>
        		</form>
	        </td>
		</tr>
        <?php
		if($_GET['exam_no'])
		{
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
	        <tr>
				<td colspan="3" style="padding-bottom:30px">
                	<table style="border-top:1px solid #0066cc;" width="100%">
				        <tr><td>
			            <table width="100%">
							<tr>
								<td align="center" style="color:#0066cc;font-size:18px" colspan="3"><strong>View Exam Details</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
                            </tr>
				            <tr>
								<td>          
					            <table align="center" border="1px"  width="786" cellpadding="5" cellspacing="0" bgcolor="" style=" border:1px solid;" >
									<tr style="padding-left:10px">
										<td width="146"><strong style="padding-left:10px">Examination No :&nbsp;&nbsp;&nbsp;</strong><?php echo $exam_no; ?></td>
					                    <td width="141"><strong style="padding-left:10px">Subject :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_syllabus['name']; ?></td>
									</tr>
									<tr>
										<td><strong style="padding-left:10px">Mark  :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_ex['exam_mark']; ?></td>
										<td><strong style="padding-left:10px">Language :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_lang['language_name']; ?></td>
									</tr>
									<tr>
										<td><strong style="padding-left:10px">Duration  :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_ex['exam_duration']; ?></td>
										<td><strong style="padding-left:10px">Exam Passing Grade  :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_ex['pass_grade_from'].' %'; ?></td>
									</tr>
									<?php 
									$sep_from_date=explode("-",$data_ex['validity_fromdate']);
									$from_date=$sep_from_date[2]."/".$sep_from_date[1]."/".$sep_from_date[0];
									//$from_date=$data_ex['validity_fromdate'];
									$sep_to_date=explode("-",$data_ex['validity_fromdate']);
									$to_date=$sep_to_date[2]."/".$sep_to_date[1]."/".$sep_to_date[0];
									//$to_date=$data_ex['validity_todate'];
									?>
									<tr>
										<td><strong style="padding-left:10px">From Date  :&nbsp;&nbsp;&nbsp;</strong><?php echo $from_date; ?></td>
										<td><strong style="padding-left:10px">To Date  :&nbsp;&nbsp;&nbsp;</strong><?php echo $to_date; ?></td>
									</tr>
									<?php
									$sel_papere="select DISTINCT(papers_id) from ex_exams_section where exams_id='".$data_ex['exams_id']."'";
									$ptr_paper=mysql_query($sel_papere);
									$data_paper=mysql_fetch_array($ptr_paper);
									$select_unit_ids="select paper_name from ex_papers where papers_id='".$data_paper['papers_id']."'";
									$ptr_unit_ids=mysql_query($select_unit_ids);
									$data_unit_ids=mysql_fetch_array($ptr_unit_ids);
									?>
								<tr>
									<td><strong style="padding-left:10px">Selected Papers  :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_unit_ids['paper_name']; ?></td>
									<td><strong></strong></td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td align="center" style="color:#0066cc" colspan="3"><strong></strong></td>
					</tr>
					<tr>
						<td align="center" colspan="3"><table style="border:0px solid #0066cc;" width="100%" align="center">
		            <tr>
	                    <td align="center">&nbsp;&nbsp;&nbsp;</td>
                        <td align="center" >
							<?php
                            echo "<input class='input_btn' type='button' name='print' value='Print With Ans' title='Print With Ans' border='0' onclick=\"window.open('ex_exam_details_print.php?exam_no=".$exam_no."&ans_action=with_ans','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer;float:right' >";
                            ?>
                        </td>
                        <td align="center" >
							<?php
                            echo "<input class='input_btn' type='button' name='print' value='Print' title='Print' border='0' onclick=\"window.open('ex_exam_details_print.php?exam_no=".$exam_no."&ans_action=wo_ans','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer;float:right' >";
                            ?>
                        </td>
	                </tr>
	                <tr>
	                  	<td width="3%">&nbsp;</td>
	                </tr>
	                <hr  style="border-color:#0066cc;">
	                <?php			
						$exam_no=$_GET['exam_no'];
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
							 	$select_question_first = "select question_title,question_id,question_img from ex_question where question_id='".$data_mys_exam['question_id']."' and language_id='".$data_ex['language_id']."' order by question_id asc " ;
								$ptrs_first_que = mysql_query($select_question_first) ;
								$i=0 ;
                                if(mysql_num_rows($ptrs_first_que)) 
								{ 
									$data_ptr_last_que = mysql_fetch_array($ptrs_first_que);
									$question_id = $data_ptr_last_que['question_id'];
									$question_title = stripslashes(html_entity_decode($data_ptr_last_que['question_title']));
									$question_img = $data_ptr_last_que['question_img'];
									echo "<input type='hidden' name='current_question' id='current_questions' value='".$question_id."' >";
									$select_option_last ="select * from options where question_id='".$question_id."' ";
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
													<input type="radio" name="ans_<?php echo $question_id; ?>"  value="<?php echo $p; ?>" <?php //if($data_opt['answer']=='y') { echo 'checked="checked"'; } ?> /></td>					
													<td> <?=stripslashes(html_entity_decode($data_opt['option_title']))?> <?php if(strlen($options_img) >10){ ?> <img src="question_photo/<?php echo $options_img; ?>" height="50" width="100" /><?php }?> </td>
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
                	</table>
              	</td>
			</tr>
            
		</table>
        </td>
        </tr>
	</table>
    </td>
</tr>
<?php 	}
		if($_GET['student_report']=="on")
		{
			
		}
	}   
	?>
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