<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_course_exam_duration where exam_duration_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> test Duration</title>
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
 
			
			function course_ajax(course_id) 
			 {
        		var selVal = course_id;
				
				<?php 
				$concsts ='';
				if($record_id)
				{
					$concsts= "+'&batch_id=$record_id'";
				}
				?>
			var data1="course_id="+selVal<?php echo $concsts; ?>;
                //alert(data1);
                 $.ajax ({
            url: "get_student.php", type: "post", data: data1, cache: false,
            success: function (html)
				{
					document.getElementById('student_div').innerHTML=html;
					//alert(html);
				  $(".multiselect").multiselect();
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
    <td class="top_mid" valign="bottom"><?php include "include/exam_menu.php"; ?></td>
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
                            $title=$_POST['title'];
                            $duration=$_POST['duration'];
                            $course_id=$_POST['course_id'];
                            
                            if($course_id=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Select course";
                            }
                            if($title=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter exam name ";
                            }
                            if($duration=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter duration";
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
                                $data_record['exam_name'] =$title;
                                $data_record['exam_duration'] =$duration; 
                                $data_record['course_id'] = $course_id;

                               if($record_id)
                                {
                                    $where_record=" exam_duration_id='".$record_id."'";
                                    $db->query_update("course_exam_duration", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("course_exam_duration", $data_record);
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
                    <tr>
                        <td width="10%">Select course  </td>                            
                        <td width="20%">
                           <select id="course_id" name="course_id" onChange="course_ajax(this.value);">
                            <option value="">Select</option>
                            <?php
														   $course_category = " select category_name,category_id from course_category ";
														   
														   $ptr_course_cat = mysql_query($course_category);
														   while($data_cat = mysql_fetch_array($ptr_course_cat))
														   {
															   echo " <optgroup label='".$data_cat['category_name']."'>";
														
                                        					$get="SELECT course_name FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
										 					$myQuery=mysql_query($get);
										 					while($row = mysql_fetch_assoc($myQuery))
															{
																
															?>
                            <option value = "<?php echo $row['course_name']?>" <? if (isset($course_interested) && $course_interested == $row['course_name']) echo "selected";?> > <?php echo $row['course_name'] ?> </option>
                            <?php }
													echo " </optgroup>";
														   }
													?>
                            
                          </select>
                        </td>
                    </tr>
                    <tr>
            	<td></td>
            	<td>
                	 <div id="student_div" >
                     </div>
                </td>
            </tr>
                    <tr>
                        <td valign="top">Test Name<span class="orange_font">*</span></td>
                        <td ><input type="text"  class="validate[required] input_text" name="title" id="title" value="<?php if ($_POST['save_changes']) echo $_POST['title']; else echo $row_record['exam_name']; ?>" /></td> 
                    </tr>
                    <tr>
                        <td>Exam Date<span class="orange_font"></span></td>
                        <td ><input type="text" class="input_text datepicker" name="exam_date" id="exam_date" 
                                    value="<?php 
									if($_POST['exam_date']) 
									echo $_POST['exam_date']; 
									else if($row_record['exam_date'] !='')
									{
									$arrage_date= explode('-',$row_record['exam_date'],3);     
									echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
										
									}?>" /></td>
                      </tr>
                      <tr>
                        <td valign="top">Start Time<span class="orange_font">*</span></td>
                        <td>           
                            <input type="text"  class="validate[required] input_text" name="start_time" id="start_time" value="<?php if ($_POST['start_time']) echo $_POST['start_time']; else echo $row_record['start_time']; ?>" style="width: 50px !important;" />&nbsp; &nbsp;<select name="time1" ><option value="am">AM</option><option value="pm">PM</option></select>
                        </td> 
                    </tr>
                    <tr>
                        <td valign="top">End Time<span class="orange_font">*</span></td>
                        <td>           
                            <input type="text"  class="validate[required] input_text" name="end_time" id="end_time" value="<?php if ($_POST['end_time']) echo $_POST['end_time']; else echo $row_record['end_time']; ?>" style="width: 50px !important;" />&nbsp; &nbsp;<select name="time" ><option value="am">AM</option><option value="pm">PM</option></select>
                        </td> 
                    </tr>
                    <tr>
                        <td valign="top">Duration<span class="orange_font">*</span></td>
                        <td>           
                            <input type="text"  class="validate[required] input_text" name="duration" id="duration" value="<?php if ($_POST['save_changes']) echo $_POST['duration']; else echo $row_record['exam_duration']; ?>" />
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