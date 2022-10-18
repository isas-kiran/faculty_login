<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_course_exam where course_question_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Test</title>
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
$("input[type=radio]").on('click', function () {
    $('[input[type=radio]name="' + $(this).attr('duration') + '"]').not(this).prop('checked', false);
});
function show_exam(id)
{
    //alert(id);
    var data1='action=show_exams&id='+id;
    //alert(data1); 
    $.ajax({
           url: "admin_ajax_process.php", type: "post", data: data1, cache: false,
           success: function (html)
               {
                   //alert(html)
                   $('#ExamDiv').html(html);
               }
          });
}
</script>
<script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
        
        function del_degree(del)
        {            
            /*var j=del;
            document.getElementById(j).style.display='none'; */
            var j=document.getElementById('extras').value;
            if(j != 0)
            {
                var curr_div = "div_"+j;
                document.getElementById(curr_div).style.display='none';
                previouss= j;
                if(previouss==0)
                {
                    previouss=0;
                }
                else
                    {
                        previouss= parseInt(j)-1;
                    }
                document.getElementById('extras').value=previouss;
                $('.scrollbar1').tinyscrollbar();
            }
        }
        function add_degree(no)
        {            
            var i=parseInt(document.getElementById('extras').value);
        
                if(i==0)
                {
                    i=1;
                }
                else
                {
                    i= parseInt(i)+1;
                }
                document.getElementById('extras').value=i;
                var next = parseInt(i)+1;
                var curr_div = "div_"+i;
                if(document.getElementById(curr_div).style.display=='none')
                {
                    document.getElementById(curr_div).style.display='block';
                }
                else
                {
                  var data1="curr_div="+i;
                //alert(data1);

                $.ajax({
                    url: "admin_ajax_process.php?action=AddCourse", type: "post", data: data1, cache: false,
                    success: function (html)
                    {
                        //alert(html);
                        document.getElementById(curr_div).innerHTML=html;
                    }
                });               
                }
                
            
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
    <td class="top_mid" valign="bottom"><?php include "include/test_menu.php"; ?></td>
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
                        $extra_pdf = $_POST['extras'];
                        $question=nl2br($_POST['question']);
                        $course_id=$_POST['course_id'];
                        $exam_duration_id=$_POST['exam_duration_id'];
                        if($question =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter question";
                        }
                        if($course_id =="")
                        {
                                $success=0;
                                $errors[$i++]="Select course";
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
                            if($record_id)
                            {
                                $data_record['question_title']=$question;
                                $data_record['course_id']=$course_id;
                                $data_record['exam_duration_id']=$exam_duration_id;
                                $where_record=" course_question_id='".$record_id."'";
                                $db->query_update("course_exam", $data_record,$where_record);
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else 
                            {
                                $data_question['question_title']=$question;
                                $data_question['exam_duration_id']=$exam_duration_id;
                                $data_question['course_id']=$course_id;
                                $insert_question=$db->query_insert("course_exam", $data_question); 
                            }
                            if($record_id =='')
                            {
                                for($i=0;$i<=$extra_pdf;$i++)
                                {                                 
                                     $data_query['option_title'] = $_POST['tag'.$i];
                                     if($_POST['duration'.$i]=='y')
                                        $data_query['answer'] = 'y';
                                     else 
                                        $data_query['answer'] = 'n';    
                                     $data_query['course_question_id'] = $insert_question;  
                                     $insert_id=$db->query_insert("course_question_options", $data_query);                                
                                }
                                if($insert_id)
                                { 
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div><br></br>';
                                }                              
                            }                          
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
                    <form  method="post" enctype="multipart/form-data" name="form1" id="jqueryForm">
                    <input type="hidden" name="no_of_extra" id="extra" value="1" />                        
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">
                        <tr>
                            <td width="20%">Select course <span class="orange_font">*</span></td>                            
                            <td width="40%">
                                <select name="course_id" id="course_id" class="validate[required] input_select" onchange="show_exam(this.value);">  
                                    <option value="">Select Course</option>
                                    <?php
                                        $select_category = "select * from PB_courses order by course_id asc";
                                        $ptr_category = mysql_query($select_category);
                                        while($data_category = mysql_fetch_array($ptr_category))
                                        {
                                            if($data_category['course_id'] == $row_record['course_id'] || $data_category['course_id'] == $_POST['course_id'] )
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
                            <td width="20%">Select test name<span class="orange_font">*</span></td>                            
                            <td width="40%">
                                <div id="ExamDiv">
                                    <select name="exam_duration_id" id="exam_duration_id" class="validate[required] input_select" >  
                                        <option value="">Select exam name</option>
                                        <?php
                                            $select_category = "select * from PB_course_exam_duration order by exam_duration_id asc";
                                            $ptr_category = mysql_query($select_category);
                                            while($data_category = mysql_fetch_array($ptr_category))
                                            {
                                                if($data_category['exam_duration_id'] == $row_record['exam_duration_id'] || $data_category['exam_duration_id'] == $_POST['exam_duration_id'] )
                                                    echo '<option value='.$data_category['exam_duration_id'].' selected="selected">'.$data_category['exam_name'].'</option>';
                                                else
                                                    echo '<option value='.$data_category['exam_duration_id'].'>'.$data_category['exam_name'].'</option>';
                                            }
                                            ?>        
                                    </select>
                                </div>
                            </td>
                            <td width="40%"></td>
                        </tr>
                        <tr>
                            <td>Question<span class="orange_font">*</span></td>
                            <td ><textarea class="validate[required] input_textarea" id="question" name="question" maxlength="100" size="100" ><?php if($row_record['question_title']) echo $row_record['question_title']; else echo ''; ?></textarea></td>  
                            <td></td>
                        </tr>
                        <?php if($row_record['course_id'] =='') { ?>
                        <tr>
                            <td width="20%"></td>    
                            <td colspan="2">
                                <table width="100%">
                                    <tr>
                                        <td>Option</td>
                                        <td>Answer</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">
                                            <textarea name="tag0" id="tag0" class="input_textarea"><?php if($_POST['save_changes']) echo $_POST['tag0']; else echo $row_record['tag0'];?></textarea>
                                        </td>
                                        <td width="40%" valign="bottom">
                                            <input type="radio" name="duration0" id="duration0" value="y" <?php if($row_record['answer']== 'y')  echo 'checked';?> onMouseDown="this.__chk = this.checked" onClick="if (this.__chk) this.checked = false" /> 
                                        </td>
                                        <td width="20%">
                                            <a href="javascript:void();" style="color:#7CA32F;" title="Add Degree" onclick="javascript:add_degree(1);"> Add&nbsp;(+)</a>&nbsp;&nbsp;&nbsp;<b></b>&nbsp;&nbsp;&nbsp;    
                                            <a href="javascript:void();" style="color:#7CA32F;" title="Delete Degree" onclick="javascript:del_degree(1);">Delete&nbsp;(-)</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php } ?>
                         <input type="hidden" name="extras" id="extras" value='0'/>
                         <tr><td colspan="3" width="100%"><div id='div_1'></div></td></tr>
                         <tr><td></td><td colspan="2" ><input class="input_btn" name="save_changes" type="submit" value="Submit" id="save_changes" /></td></tr>
                    </table>
                </form>
        </td></tr>
<?php
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>
