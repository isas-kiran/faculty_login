<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
$paper_id=$_GET['papers_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
 MCQ Question Details</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

<!-- <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
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
            
        <tr>
        <td colspan="3" style="padding-bottom:30px"><table style="border-top:1px solid #0066cc;" width="100%">
            <tr><td>
            <table width="100%">
              <tr>
                <td align="center" colspan="3">
                <table width="100%">
                	<tr><td colspan="2"> <?php
				echo "<input class='input_btn' type='button' name='print' value='Print' title='Print' border='0' onclick=\"window.open('ex_question_details_print.php?papers_id=".$paper_id."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer;float:right' >";
				?></td></tr>
                     <?php
				    	$paper_id=$_GET['papers_id'];
						$select_exams="select * from ex_papers where (papers_id=".$paper_id.") order by papers_id desc";
						$ptr_exam=mysql_query($select_exams);
						$data_ex=mysql_fetch_array($ptr_exam);
						
						$sle_lang="select language_name,language_code from ex_language where language_id='".$data_ex['language_id']."'";
						$ptr_lang=mysql_query($sle_lang);
						$data_lang=mysql_fetch_array($ptr_lang);
						
						$sel_syll="select name from subject where subject_id='".$data_ex['syllabus_id']."'";
						$ptr_syll=mysql_query($sel_syll);
						$data_syll=mysql_fetch_array($ptr_syll);
					?>
                  	<tr>
                    	<td colspan="4">
                    	<table border="1px" style="border-collapse:collapse" width="100%" cellpadding="5" cellspacing="5">
                        	<tr>
                        		<td colspan="3" wid>Paper Name : </td>
                                <td width="88%"><?php echo $data_ex['paper_name'].$data_lang['language_code'] ?></td>
                             </tr>
                            <tr>
                                <td colspan="3">Paper Marks: </td>
                                <td><?php echo $data_ex['paper_mark'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">Language: </td>
                                <td><?php echo $data_lang['language_name'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">Syllabus: </td>
                                <td><?php echo $data_syll['name'] ?></td>
                            </tr>
                            
                        </table>
                  		</td>
                    </tr>
                 	
                </table>
                <table style="border:1px solid #0066cc; border-collapse:collapse" width="100%" align="center" border="1px">
                	<tr>
                            <td style="padding:10px" valign="top" width="4%" align="center">Sr. no.</td>
                            <td style="padding:10px" valign="top" width="8%" align="center">Question No.</td>
                            <td style="padding:10px" valign="top" width="15%" align="center">Topic Name</td>
                            <td style="padding:10px" valign="top" width="73%" align="center">Question Titile</td>
                    </tr>
               
                  <?php			
					$sele_ex="select * from ex_papers_section where papers_id='".$data_ex['papers_id']."' ";
					$ptr_my=mysql_query($sele_ex);
					$q=1;
					if(mysql_num_rows($ptr_my))
					{
						while($data_mys_exam=mysql_fetch_array($ptr_my))
						{
							"<br/>".$select_question_first = " select question_title,question_id,question_img,unit_id from ex_question where question_id='".$data_mys_exam['question_id']."' order by question_id asc " ;
							$ptrs_first_que = mysql_query($select_question_first) ;
							if(mysql_num_rows($ptrs_first_que))
							{
								$i=0 ;
								$data_ptr_last_que = mysql_fetch_array($ptrs_first_que);
								$question_id = $data_ptr_last_que['question_id'];
								$question_title = stripcslashes(html_entity_decode($data_ptr_last_que['question_title']));
								$question_img = $data_ptr_last_que['question_img'];
								$unit_id= $data_ptr_last_que['unit_id'];
								
								$select_option_last = " select * from ex_options where question_id='$question_id' ";
								$ptrs_option = mysql_query($select_option_last);
								
								$sel_unit="select topic_name from topic where topic_id='".$unit_id."'";
								$ptr_unit_name=mysql_query($sel_unit );
								$data_unit_name= mysql_fetch_array($ptr_unit_name);
							?>
				  			<tr>
								<td valign="top" style="padding-top:8px" align="center"><?php echo $q; ?>. </td>
                                <td valign="top" style="padding-top:8px" align="center"><?php echo $question_id; ?></td>
                                <td valign="top" style="padding-top:8px" align="center"><?php echo $data_unit_name['topic_name']; ?></td>
								<td width="73%">
									<table cellpadding="3" cellspacing="3" width="100%">
										<tr>
											<td colspan="4"><span style=" font-size:16px;"><?=$question_title;?>
											<?php if($question_img !=''){ ?> <img src="question_photo/<?php echo $question_img; ?>" height="50" width="100" /><?php }?></span></td>
										</tr>
										<?php 
										$p=1;
										while($data_opt = mysql_fetch_array($ptrs_option))
										{
											$options_img=$data_opt['option_image'];
										?>
                                            <tr>
                                                <td width="25">
                                                <input type="radio" name="ans_<?php echo $question_id; ?>"  value="<?php echo $p; ?>" <?php if($data_opt['answer']=='y') { echo 'checked="checked"'; } ?> /></td>					
                                                <td> <?=stripslashes(html_entity_decode($data_opt['option_title']))?> <?php if(strlen($options_img) >10){ ?> <img src="question_photo/<?php echo $options_img; ?>" height="50" width="100" /><?php }?> </td>
                                            </tr>
                                            <?php 
											$p++;
										}?>
									</table>
								</td>
				 			</tr>
				  			
							 <?php
                             }
                  			$q++;
				  		}
                   	}
                     ?>
                </table></td>
              </tr>
              
              </table></td>
            </tr>
          </table></td></tr>
          
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