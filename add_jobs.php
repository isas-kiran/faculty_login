<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_jobs where job_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Jobs</title>
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
            $("#course_id").multiselect().multiselectfilter();
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
    <td class="top_mid" valign="bottom"><?php include "include/job_menu.php"; ?></td>
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
                            $description=$_POST['description'];
                            $company=$_POST['company'];
                            $how_to_apply=$_POST['how_to_apply'];                            
                            $location=$_POST['location'];                             
                            
                            if($title=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter title ";
                            }
                            if($description=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter description";
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
                                $data_record['title'] =$title;
                                $data_record['description'] =strip_tags($description); 
                                $data_record['company'] = $company;
                                $data_record['location'] = $location;
                                $data_record['how_to_apply'] = $how_to_apply;
                                $data_record['post_date'] =$_POST['post_date'];

                               if($record_id)
                                {
                                    $delete_query="delete from ".$GLOBALS["pre_db"]."jobs_recommend where job_id='".$record_id."'";
                                    $db->query($delete_query);  
                                    
                                    $record_ids = $record_id;
                                    $where_record=" job_id='".$record_id."'";
                                    $job_id=$db->query_update("jobs", $data_record,$where_record);
                                    
//                                    $count= count($_POST['course_id']);
//                                    for($i=0;$i<$count;$i++)
//                                    {
//                                        $data_record2['job_id'] = $record_id;
//                                        $data_record2['course_id'] = $_POST['course_id'][$i];
//                                        $db->query_insert("jobs_recommend", $data_record2);
//                                    }
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_ids=$db->query_insert("jobs", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                                
                                $count= count($_POST['course_id']);
                                for($i=0;$i<$count;$i++)
                                {
                                    $data_record2['job_id'] = $record_ids;
                                    $data_record2['course_id'] = $_POST['course_id'][$i];
                                    $db->query_insert("jobs_recommend", $data_record2);
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
                  <td width="20%" valign="top">Job Title<span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="title" id="title" value="<?php if($_POST['save_changes']) echo $_POST['title']; else echo $row_record['title'];?>" /></td> 
                <td width="40%"></td>
              </tr>
            <tr>
                <td width="20%">Company</td>
                <td width="40%"><input type="text"  class="input_text" name="company" id="company" value="<?php if($_POST['save_changes']) echo $_POST['company']; else echo $row_record['company'];?>" /></td> 
                <td width="40%"></td>
              </tr>
             <tr>
                  <td valign="top">Job Description<span class="orange_font">*</span></td>
                  <td colspan="2"><?php
                            include("../FCKeditor/fckeditor.php");
                            $BasePath = "../FCKeditor/";
                            $oFCKeditor 		= new FCKeditor('description') ;
                            $oFCKeditor->BasePath	= $BasePath ;
                            if($_POST['save_changes'])
                                $oFCKeditor->Value	= stripslashes($_POST['description']);
                            else
                                $oFCKeditor->Value	= stripslashes($row_record['description']);
                            $oFCKeditor->Height		= "300";
                            $oFCKeditor->Create() ;
                ?></td>
             </tr>
              
              <tr>
                <td width="20%">Location</td>
                <td width="40%"><input type="text"  class="input_text" name="location" id="location" value="<?php if($_POST['save_changes']) echo $_POST['location']; else echo $row_record['location'];?>" /></td> 
                <td width="40%"></td>
              </tr>
            
            <tr>
                <td width="20%">How To Apply<span class="orange_font">*</span></td>
                <td width="40%"><input type="text" class="validate[required] input_text" name="how_to_apply" id="how_to_apply" value="<?php if($_POST['save_changes']) echo $_POST['how_to_apply']; else echo $row_record['how_to_apply'];?>" /></td> 
                <td width="40%"></td>
              </tr>            
            
            <tr>
                <td width="20%">Post Date<span class="orange_font">*</span></td>
                <td width="40%"><input type="text" class="validate[required] input_text datepicker" readonly="true" name="post_date" id="post_date" value="<?php if($_POST['save_changes']) echo $_POST['post_date']; else echo $row_record['post_date'];?>" /></td> 
                <td width="40%"></td>
              </tr>
            
            <?php
               $a = 0;
                $count = array();
                 if($record_id!='')
                    {
                        $sql_category = "select * from PB_jobs_recommend where job_id ='".$record_id."' ";
                        $ptr_qry = mysql_query($sql_category);
                        while($data_qry = mysql_fetch_array($ptr_qry))
                        {
                            $course_id = $data_qry['course_id'];
                            $count[$a] = $course_id;
                            $a++;
                        }
                    }
                    
            ?>
            <tr>
                <td width="20%">Course Name</td>
                <td width="40%" >
                    <select  multiple="multiple" name="course_id[]" id="course_id" class="validate[required] input_select" style="width:150px;">                        
                        <?php 
                        
                            $select_courses = "select * from PB_courses order by course_id asc";
                            $ptr_courses = mysql_query($select_courses);
                            while($data_courses = mysql_fetch_array($ptr_courses))
                            { 
                                
                                        $sql_category = "select * from  PB_jobs_recommend where job_id ='".$record_id."'  ";
                                        $ptr_qry = mysql_query($sql_category);
                                        while($data_qry = mysql_fetch_array($ptr_qry))
                                        {
                                            if($data_courses['course_id'] == $data_qry['course_id'])
                                                 $class = 'selected="selected"';  
                                            else
                                                $class = '';                                            
                                        }
                                                                       
                                   for($t=0;$t<count($count);$t++)
                                 {
                                     if($data_courses['course_id'] == $count[$t])
                                            $class = 'selected="selected"';                                                                           
                                 }
                                
                                 if($class !='')                                    
                                        echo '<option value="'.$data_courses['course_id'].'" '.$class.' >'.$data_courses['course_name'].'</option>';     
                                 else
                                     echo '<option value="'.$data_courses['course_id'].'" >'.$data_courses['course_name'].'</option>';  
                            }
                            ?>        
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Job" name="save_changes"  /></td>
                  <td></td>
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