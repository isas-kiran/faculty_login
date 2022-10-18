<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_course_syllabus where syllabus_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> syllabus</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
        <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
<!--End multiselect -->
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
                    url: "admin_ajax_process.php?action=AddSubTopic", type: "post", data: data1, cache: false,
                    success: function (html)
                    {
                        //alert(html);
                        document.getElementById(curr_div).innerHTML=html;
                    }
                });               
                }
                
            /*var i=no;
            var next = i+1;
            if(document.getElementById(i).style.display=='none')
            {
            document.getElementById(i).style.display='block';
            }
            else
            {
            var value='<div id="'+i+'"><table width="100%" border="0"><tr><td><input class="input_text" type="text" name="tag'+i+'"></td><td align="left" style="font-size:11px!important;"><a href="#" title="Add Degree" onclick="javascript:add_degree('+next+');">Add(+)</a></td><td align="left" style="font-size:11px!important;"><a href="#" title="Delete Degree" onclick="javascript:del_degree('+i+');">Delete(-)</a></td></tr></table></div> <div id="'+next+'"></div>';
            document.getElementById(i).innerHTML= value;
            document.getElementById('extra').value=i;
            }*/
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
    <td class="top_mid" valign="bottom"><?php include "include/syllabus_menu.php"; ?></td>
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
                        $topic_name=$_POST['topic_name'];
                        $description = $_POST['description'];
                        $category=$_POST['course_category'];
                        $sequence_no = $_POST['sequence_no'];
                        
                        if($topic_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter topic name";
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
                            $data_record['course_id']=$category;
                            $data_record['topic_name'] =$topic_name;
                            $data_record['sequence_no'] = $sequence_no;
                            
                            
                            if($record_id)
                            {
                                $where_record=" syllabus_id='".$record_id."'";
                                $db->query_update("course_syllabus", $data_record,$where_record);
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
                                $data_record['parent_category'] ='0'; 
                                $data_record['type'] ='main_category';
                                $insert_id=$db->query_insert("course_syllabus", $data_record);
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                            if($record_id =='') {
                                for($i=0;$i<=$extra_pdf;$i++)
                                {
                                     $data_query['type'] ='sub_category';
                                     $data_query['course_id'] = $category;
                                     $data_query['topic_name'] = $_POST['tag'.$i]; 
                                     $data_query['duration'] = $_POST['duration'.$i];
                                     $data_query['parent_category'] =$insert_id;
                                     $db->query_insert("course_syllabus", $data_query);                                
                                }
                            }                        
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <tr>
                <td width="20%">Course Name<span class="orange_font">*</span></td>
                <td width="40%" >
                    <select name="course_category" id="course_category" class="validate[required] input_select" >  
                        <option value="">Select Course</option>
                        <?php
                            $select_category = "select * from PB_courses order by course_id asc";
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
                <td width="20%">Topic Name<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="topic_name" id="topic_name" value="<?php if($_POST['save_changes']) echo $_POST['topic_name']; else echo $row_record['topic_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Sequence of Topic<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="sequence_no" id="sequence_no" value="<?php if($_POST['save_changes']) echo $_POST['sequence_no']; else echo $row_record['sequence_no'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            
            <?php if($record_id =='') { ?>
            <tr>
                <td width="20%" >Sub Topic<span class="orange_font">*</span></td>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td>Sub Topic Name</td>
                            <td>Duration</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="40%">
                                <input type="text" class="validate[required] input_text" name="tag0" id="tag0" value="<?php if($_POST['save_changes']) echo $_POST['tag0']; else echo $row_record['topic_name'];?>" />                                
                            </td>
                            <td width="40%">
                                <input type="text" class="validate[required] input_text" name="duration0" id="duration0" value="<?php if($_POST['save_changes']) echo $_POST['duration0']; else echo $row_record['duration'];?>" />                                
                            </td>
                            <td width="20%">
                                <a href="javascript:void();" style="color:#7CA32F;" title="Add Degree" onclick="javascript:add_degree(1);"> Add&nbsp;(+)</a>&nbsp;&nbsp;&nbsp;<b></b>&nbsp;&nbsp;&nbsp;    
                                <a href="javascript:void();" style="color:#7CA32F;" title="Delete Degree" onclick="javascript:del_degree(1);">Delete&nbsp;(-)</a>
                            </td>
                        </tr>
                    </table>
                </td>
                
            </tr>
            <? } ?>
            
            <input type="hidden" name="extras" id="extras"value='0'/>
          <tr><td colspan="3" width="100%"><div id='div_1'></div></td></tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Course" name="save_changes"  /></td>
                <td></td>
            </tr>
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