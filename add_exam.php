<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM exam where exam_id='".$record_id."'";
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
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
Exam</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
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
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
        });
    </script>
    <script>
function show_subject(subject)
		{
//alert(subject);
var data1="show_subject=1&subject="+subject;
 $.ajax({
url: "show_subjects.php", type: "post", data: data1, cache: false,
success: function (html)
{
 document.getElementById('show_subject').innerHTML=html;
}
});
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
    <td class="top_mid" valign="bottom"><?php include "include/exams_menu.php"; ?></td>
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
							$exame_dates= explode('/',$_POST['exam_date'],3);     
							$exam_date= $exame_dates[2].'-'.$exame_dates[0].'-'.$exame_dates[1]; 
									
                            $exam_name=$_POST['exam_name'];
                            $exam_desc=$_POST['exam_desc'];
                            $duration=$_POST['duration'];
							//$exam_date=$_POST['exam_date'];
                            $start_time=$_POST['start_time'];
							$end_time=$_POST['end_time'];
							$course_id=$_POST['course_id'];
                            if($exam_name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter exam name ";
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
								$data_record['admin_id'] = $_SESSION['admin_id'];
                                $data_record['exam_name'] =$exam_name;
                                $data_record['duration'] =$duration; 
                                $data_record['exam_desc'] = $exam_desc;
								$data_record['duration'] =$duration; 
                                $data_record['exam_date'] = $exam_date;
								$data_record['start_time'] =$start_time; 
                                $data_record['end_time'] = $end_time;
								$data_record['course_id'] = $course_id;
                               if($record_id)
                                {
                                    $where_record=" exam_id='".$record_id."'";
                                    $db->query_update("exam", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("exam", $data_record);
									
									$sele_course="select course_name from courses where course_id='$course_id'";
									$ptr_course=mysql_query($sele_course);
									$data_course=mysql_fetch_array($ptr_course);
									 /*------------send a mail to Student and faculty about this---------------------*/
                                                $subject = "Examination Schedule on ".$GLOBALS['domainName']."";
												
                                                $message .= '
                                                <table cellpadding="3" align="left" cellspacing="3" width="75%">
												<tr><td colspan="3">Examination Schedule for '.$data_course['course_name'].' </td></tr>
												 <tr>
                                                    <td width="35%"><strong>Exam Name</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$exam_name.'</td>
                                                </tr>';
												 $message.= '
                                               
                                                <tr>
                                                    <td width="35%"><strong>Date Of Exam</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$exam_date.'</td>
                                                </tr>';
                                               
                                                $message.= '
                                               
                                                <tr>
                                                    <td width="35%"><strong>Duration</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$duration.'</td>
                                                </tr>';
                                               
												 
                                                $message.= '
                                                
                                                <tr>
                                                    <td width="35%"><strong>Time</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$start_time.' to '.$end_time.'</td>
                                                </tr>';
												
												
												$sel_faculty="select staff_mail from staff_regi ".$_SESSION['where_cm_id']." ".$_SESSION['user_id_or']."";
												$ptr_staff=mysql_query($sel_faculty);
												
                                                
                                                '</table>';
												
													$sendMessage=$GLOBALS['box_message_top'];
													$sendMessage.=$message;
													$sendMessage.=$GLOBALS['box_message_bottom'];
													$from_id='support<support@'.$GLOBALS['siteUrlName'].'>';
													$headers= 'MIME-Version: 1.0' . "\n";
													$headers.='Content-type: text/html; charset=utf-8' . "\n";
													$headers.='From:'.$from_id;
													//echo $to.$sendMessage;
													if($_SERVER['HTTP_HOST']!="localhost" && $_SERVER['HTTP_HOST']!="localhost:81")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
   													 {
														while($data_staff=mysql_fetch_array($ptr_staff))
														{
															if(mail($data_staff['staff_mail'], $subject, $sendMessage, $headers))
															{
																//echo'<br>'. 'sent to staff';	
															}
														}
														 $select_email_id = " select mail from enrollment where (1".$_SESSION['where']."".$_SESSION['user_id_or'].") and course_id='".$course_id."' and mail !='' ";
														$ptr_emails = mysql_query($select_email_id);
														while($data_emails = mysql_fetch_array($ptr_emails))
														{
															if(mail($data_emails['mail'], $subject, $sendMessage, $headers))
															{
																//echo'<br>'. 'sent to student';	
															}
														}
														
													}
									//===============================End Sent Mail===================================
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
                    <!--<tr>
            <td width="20%">Select Course<span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="course_id" id="course_id" class="validate[required] input_select" onchange="show_subject(this.value)">  
                        <option value=""> Select Course </option>
                        <?php
                            $select_category = "select * from courses order by course_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['course_id'] == $row_record['course_id'])
                                    echo '<option value='.$data_category['course_id'].' selected="selected">'.$data_category['course_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['course_id'].'>'.$data_category['course_name'].'</option>';
                            }
                            ?>        
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
             <tr>
                <td width="20%"> Select Subject </td>
                <td width="40%" ><div id="show_subject"></div> </td> 
                <td width="40%"></td>
            </tr>-->
            <tr><td>
        
                    <!--<tr>
                        <td width="26%">Select course  </td>                            
                        <td width="74%">
                           <select id="course_id" name="course_id" onChange="course_ajax(this.value);">
                            <option value="">Select</option>
                            <?php
															/*$sele_course_name="select course_id,course_name from courses where course_id='".$row_record['course_id']."'";
															$ptr_course_name=mysql_query($sele_course_name);
															$data_course_name=mysql_fetch_array($ptr_course_name);
															$course_interested=$data_course_name['course_name'];
														   $course_category = " select category_name,category_id from course_category ";
														   
														   $ptr_course_cat = mysql_query($course_category);
														   while($data_cat = mysql_fetch_array($ptr_course_cat))
														   {
															   echo " <optgroup label='".$data_cat['category_name']."'>";
														
                                        					$get="SELECT course_name,course_id FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
										 					$myQuery=mysql_query($get);
										 					while($row = mysql_fetch_assoc($myQuery))
															{
																*/
															?>
                            <option value = "<?php //echo $row['course_id']?>" <? //if (isset($course_interested) && $course_interested == $row['course_name']) echo "selected";?> > <?php //echo $row['course_name'] ?> </option>
                            <?php /*}
													echo " </optgroup>";
														   }*/
													?>
                            
                          </select>
                        </td>
                    </tr>-->
                    <!--<tr>
            	<td></td>
            	<td>
                	 <div id="student_div" >
                     </div>
                </td>
            </tr>-->
                    <tr>
                        <td valign="top">Exam Name<span class="orange_font">*</span></td>
                        <td ><input type="text"  class="validate[required] input_text" name="exam_name" id="exam_name" value="<?php if ($_POST['save_changes']) echo $_POST['exam_name']; else echo $row_record['exam_name']; ?>" /></td> 
                        
                    </tr>
                     <tr>
                        <td valign="top">Discription</td>
                        <td>           
                            <input type="text"  class="input_text" name="exam_desc" id="exam_desc" value="<?php if ($_POST['save_changes']) echo $_POST['exam_desc']; else echo $row_record['exam_desc']; ?>" />
                        </td> 
                        
                    </tr>
                    <!--<tr>
                        <td>Exam Date<span class="orange_font"></span></td>
                        <td ><input type="text" class="input_text datepicker" name="exam_date" id="exam_date" 
                                    value="<?php 
									/*if($_POST['exam_date']) 
									{
										echo $_POST['exam_date']; 
									}
									else if($row_record['exam_date'] !='')
									{
									$arrage_date= explode('-',$row_record['exam_date'],3);     
									echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
										
									}*/?>" /></td>
                      </tr>-->
                      <tr>
                        <td valign="top">Start Time<span class="orange_font">*</span></td>
                        <td>           
                            <input type="text"  class="validate[required] input_text" name="start_time" id="start_time" value="<?php if ($_POST['start_time']) echo $_POST['start_time']; else echo $row_record['start_time']; ?>" style="width: 50px !important;" />
                        </td> 
                    </tr>
                    <tr>
                        <td valign="top">End Time<span class="orange_font">*</span></td>
                        <td>           
                            <input type="text"  class="validate[required] input_text" name="end_time" id="end_time" value="<?php if ($_POST['end_time']) echo $_POST['end_time']; else echo $row_record['end_time']; ?>" style="width: 50px !important;" />
                        </td> 
                    </tr>

                    <tr>
                        <td valign="top">Duration<span class="orange_font">*</span></td>
                        <td>           
                          <input type="text"  class="input_text" name="duration" id="duration" value="<?php if ($_POST['save_changes']) echo $_POST['duration']; else echo $row_record['duration']; ?>" />
                      </td> 
                      
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" class="input_btn" value="<?php if ($record_id) echo "Update"; else  echo "Add"; ?> Exam Details" name="save_changes"  /></td>
                        
                    </tr>
                </table>
        </form>
        </td></tr>
<?php
                        }   ?>
	 
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>