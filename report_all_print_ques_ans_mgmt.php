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
				/* $paper_id=$_GET['papers_id']; 
			  	$select_exams="select * from papers where (papers_id=".$paper_id.") order by papers_id desc";
			 	$ptr_exam=mysql_query($select_exams);
			  	$data_ex=mysql_fetch_array($ptr_exam);	  
			  	$sle_lang="select language_name from language where language_id='".$data_ex['language_id']."'";
				$ptr_lang=mysql_query($sle_lang);
				$data_lang=mysql_fetch_array($ptr_lang); */
			?>	
		 		  
            <table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
            
                    <tr height="5">
            </tr></table>
            
            <table align="center" cellpadding="5" cellspacing="5" border="1px" bordercolor="#0066cc" style="border:1px solid #0066cc; border-collapse:collapse; font-size:9px" width="786" >
            	<tr>
                   
                    <td width="26" align="right" style="padding-right:15px;">
                       <table width="99%"> <?php 
							$topic ="SELECT topic_name FROM `topic` where topic_id=".$_REQUEST['unit_id']."";
					   $tname = mysql_query($topic);
					   $topic_name = mysql_fetch_array( $tname);
					   ?></table>
                       <td width="43" valign="top" colspan="2">
                      
                        <?php
                         if($_GET['action'] !='print') 
                         {
                         ?>
                        <a href="report_all_print_ques_ans_mgmt.php?syllabus_id=<?php echo $_GET['syllabus_id']; ?>&unit_id=<?php echo $_GET['unit_id']; ?>&keyword=<?php echo $_GET['keyword']; ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a><?php } ?>
						Unit Name:<?php echo $topic_name['topic_name']; ?>
					</td>
            	</tr>
           		<tr>
				<?php if($_REQUEST['syllabus_id']!="" || $_REQUEST['unit_id']!="") 
				{
				?>
                	<!--<td colspan="4">
                    	<table width="100%" cellpadding="5" cellspacing="5">
                        <?php if($_REQUEST['syllabus_id']!="") 
						{
							$sele_syll="select syllabus_name from ex_syllabus where 1 and  syllabus_id='".$_REQUEST['syllabus_id']."' ";
							$ptr_syll=mysql_query($sele_syll);
							$data_syll=mysql_fetch_array($ptr_syll);
						?>
                        	<tr>
                        		<td colspan="3" width="30%"><strong>Syllabus Name :</strong></td>
                                <td width="70%"><?php echo $data_syll['syllabus_name'] ?></td>
                             </tr>
                       <?php } ?>
                       <?php if($_REQUEST['unit_id']!="") 
						{
							$sel_unit_name="select unit from ex_unit where unit_id='".$_REQUEST['unit_id']."'  ";
							$ptr_units=mysql_query($sel_unit_name);
							$data_unit_name= mysql_fetch_array($ptr_units);
						?>
                        	<tr>
                        		<td colspan="3" width="30%"><strong>Unit Name :</strong></td>
                                <td width="70%"><?php echo $data_unit_name['unit']; ?></td>
                             </tr>
                       <?php } ?>
                       <?php if($_REQUEST['keyword']!="") 
						{
							
						?>
                        	<tr>
                        		<td colspan="3" width="30%"><strong>Search by keyword :</strong></td>
                                <td width="70%"><?php echo $_REQUEST['keyword']; ?></td>
                             </tr>
                       <?php } ?>
                        </table>
                        
                   </td>-->
				<?php 
				}
				?>
               </tr>
                <?php		
				
					if($_REQUEST['keyword']!="Keyword")
						$keyword=trim($_REQUEST['keyword']);
					if($keyword)
						$pre_keyword=" and (question_title like '%".$keyword."%')";
					else
						$pre_keyword="";

					if($_REQUEST['syllabus_id'])
						$syllabus_id="and syllabus_id= '".$_REQUEST['syllabus_id']."'";
					else
						$syllabus_id='';
						
					if($_REQUEST['unit_id'])
						$unit_id="and unit_id= '".$_REQUEST['unit_id']."'";
					else
						$unit_id='';
				
					
					/* $sele_sy="select * from syllabus_unit_map where 1 ".$syllabus_id." ".$unit_id." ";
					$ptr_sy=mysql_query($sele_sy);
					$q=1;
					if(mysql_num_rows($ptr_sy))
					{
						$s=1;
						while($data_sy=mysql_fetch_array($ptr_sy))
						{
							$sele_ex="select * from syllabus where 1 and  syllabus_id='".$data_sy['syllabus_id']."' ";
							$ptr_my=mysql_query($sele_ex);
							$data_mys_exam=mysql_fetch_array($ptr_my); */

							if($_GET['syllabus_id']!='')
							{
								$sub_query1=" and syllabus_id='".$_GET['syllabus_id']."' ";
                            }else{
                                $sub_query1= "";
                            }
                            
							if($_GET['unit_id']!='')
							{
								 $sub_query2=" and unit_id='".$_GET['unit_id']."' ";
							}else{
                                $sub_query2= "";
                            }
							
							$select_question_first = "select question_title,question_id,question_img,unit_id from ex_question where 1 and language_id='1' ".$sub_query1." ".$sub_query2."  ".$pre_keyword." ORDER BY unit_id desc  " ;
							$ptrs_first_que = mysql_query($select_question_first) ;
							if($total_ques=mysql_num_rows($ptrs_first_que))
							{
								$s=1;
								while($data_ptr_last_que = mysql_fetch_array($ptrs_first_que))
								{
									$i=0 ;
									$question_id = $data_ptr_last_que['question_id'];
									$question_title = $data_ptr_last_que['question_title'];
									$question_img = $data_ptr_last_que['question_img'];
									$unit_ids= $data_ptr_last_que['unit_id'];
									$select_option_last = " select * from ex_options where question_id='$question_id' ";
									$ptrs_option = mysql_query($select_option_last);
									
									$sel_unit="select unit from ex_unit where unit_id='".$unit_ids."'  ";
									$ptr_unit_name=mysql_query($sel_unit);
									$data_unit_name= mysql_fetch_array($ptr_unit_name);
									?>
									<tr>
										<td valign="top" style="padding-top:8px" align="center" width="10%"><?php echo $s; ?>. </td>
										<!--<td valign="top" style="padding-top:8px" align="center"><?php echo $data_mys_exam['syllabus_name']; ?></td>
										<td valign="top" style="padding-top:8px" align="center"><?php //echo $data_unit_name['unit']; ?></td>-->
										<td width="90%">
											<table cellpadding="3" cellspacing="3" width="100%">
												<tr>
													<td colspan="4"><span style=" font-size:10px;"><?=stripslashes($question_title);?>
													<?php if($question_img !=''){ ?> <img src="ex_question_photo/<?php echo $question_img; ?>" height="50" width="100" /><?php }?></span></td>
												</tr>
												<?php 
												$p=1;
												while($data_opt = mysql_fetch_array($ptrs_option))
												{
												?>
													<tr>
													<td width="25">
													<input type="radio" name="ans_<?php echo $question_id."_".$s; ?>"  value="<?php echo $p; ?>" <?php if($data_opt['answer']=='y') { echo 'checked="checked"'; } ?> /></td>					
													<td> <?php echo $data_opt['option_title']?> </td>
													</tr>
													<?php 
													$p++;
												}?>
											</table>
										</td>
									</tr>
									<?php
									$s++;
                             	}
							}
                  			/* $q++;
				  		}
                   	} */
                 ?>
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