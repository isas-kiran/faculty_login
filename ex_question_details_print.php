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

        
			<?php $paper_id=$_GET['papers_id']; 
			
			  	$select_exams="select * from ex_papers where (papers_id=".$paper_id.") order by papers_id desc";
			 	$ptr_exam=mysql_query($select_exams);
			  	$data_ex=mysql_fetch_array($ptr_exam);
			  
			  	$sle_lang="select language_name from ex_language where language_id='".$data_ex['language_id']."'";
				$ptr_lang=mysql_query($sle_lang);
				$data_lang=mysql_fetch_array($ptr_lang);
				
				$sel_syll="select name from subject where subject_id='".$data_ex['syllabus_id']."'";
				$ptr_syll=mysql_query($sel_syll);
				$data_syll=mysql_fetch_array($ptr_syll);
			?>	
		 		  
            <table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
            
                    <tr height="5">
            </tr></table>
            
            <table align="center" style="border:1px solid #0066cc;" width="786" >
            	<tr>
                    <td  align="center"valign="top" width="701" style="font-size:25px" colspan="2">MCQ Examination</td>
                    <td width="26" align="right" style="padding-right:15px;">
                       <table width="99%"></table>
                       <td width="43" valign="top">
                        <?php
                         if($_GET['action'] !='print')
                         {
                         ?>
                        <a href="ex_question_details_print.php?papers_id=<?php echo $paper_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a><?php } ?>
                    </td>
            	</tr>
           		<tr>
                	<td colspan="4">
                    	<table width="100%" cellpadding="5" cellspacing="5">
                        	<tr>
                        		<td colspan="3" wid><strong>Paper Name :</strong></td>
                                <td width="81%"><?php echo $data_ex['paper_name'] ?></td>
                             </tr>
                            <tr>
                                <td colspan="3"><strong>Paper Marks :</strong></td>
                                <td><?php echo $data_ex['paper_mark'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Language :</strong></td>
                                <td><?php echo $data_lang['language_name'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">Subject: </td>
                                <td><?php echo $data_syll['syllabus_name'] ?></td>
                            </tr>
                        </table>
                        <hr />
                   </td>
               </tr>
               <?php
			     $sele_ex="select * from ex_papers_section where papers_id='".$data_ex['papers_id']."' ";
				 $ptr_my=mysql_query($sele_ex);
				 $q=1;
				 while($data_mys_exam=mysql_fetch_array($ptr_my))
					{
						$select_question_first = " select question_title,question_id,question_img,unit_id from ex_question where question_id='".$data_mys_exam['question_id']."' order by question_id asc " ;
						$ptrs_first_que = mysql_query($select_question_first) ;
						$i=0 ;
						$data_ptr_last_que = mysql_fetch_array($ptrs_first_que);
						
						$question_id = $data_ptr_last_que['question_id'];
						$question_title = stripslashes(html_entity_decode($data_ptr_last_que['question_title']));
						$question_img = $data_ptr_last_que['question_img'];
						$unit_id= $data_ptr_last_que['unit_id'];
						$select_option_last = " select * from ex_options where question_id='$question_id' ";
						$ptrs_option = mysql_query($select_option_last);
						
						$sel_unit="select topic_name from topic where topic_id='".$unit_id."'";
						$ptr_unit_name=mysql_query($sel_unit);
						$data_unit_name= mysql_fetch_array($ptr_unit_name);
			   ?>
			   
               <tr>
                  <td valign="top" style="padding-top:8px"><?php echo $q ?>. </td>
                  <td><span>Question No. : <?php echo $question_id; ?></span> and <span>Unit Name. : <?php echo $data_unit_name['unit']; ?></span></td>
               </tr>
               <tr>
               		<td valign="top" style="padding-top:8px"></td>
                    <td width="97%">
                       <table cellpadding="3" cellspacing="3" width="100%">
                         <tr>
                          <td colspan="3"><span style=" font-size:16px;"><?=stripslashes($question_title);?>
						  <?php if($question_img !=''){ ?> <img src="ex_question_photo/<?php echo $question_img; ?>" height="50" width="100" /><?php }?>
                            </span></td>
                         </tr>
                            <?php 
									$p=1;
									while($data_opt = mysql_fetch_array($ptrs_option))
									{
									   
										?>
										<tr>
										<td width="25">
										<input type="radio" name="ans_<?php echo $question_id; ?>"  value="<?php echo $p; ?>" <?php if($data_opt['answer']=='y') { echo 'checked="checked"'; } ?> /></td>					
										<td> <?=stripslashes(html_entity_decode($data_opt['option_title']))?> </td>
										</tr>
										<?php 
										$p++;
									 }
									?>
						</table>
                     </td>
                   </tr>
                   
                <tr>
                <td>&nbsp;</td>
                </tr>
   <?php $q++; }?>
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