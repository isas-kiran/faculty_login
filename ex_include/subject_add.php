<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM courses where course_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Course</title>
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
        function showdiv(val)
        {
            if(val=='Y')
            {
                $(".coursess").hide();
            }
            else
            {
                $(".coursess").show();
            }
        }
        function show_dicount(val)
        {            
            if(val=='Y')
            {
                $(".discount").show();
            }
            else
            {
                $(".discount").hide();
            }
        }
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
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
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
                        $course_name=$_POST['course_name'];
                        $course_description = $_POST['course_description'];
                        $course_duration=$_POST['course_duration'];
                        $course_level=$_POST['course_level'];
                        $course_video=$_POST['course_video'];
                        $course_pdf=$_POST['course_pdf'];                        
                        $course_author=@implode(",",$_POST['user_id']);                        
                        $course_duration=$_POST['course_duration'];
                        $category_id = $_POST['category_id'];
                        $free_course = $_POST['free_course'];
                        $course_price = $_POST['course_price'];
                        $course_keyword = $_POST['course_keyword'];
                        
                        $discountss=$_POST['discount'];                        
                        $start_date=$_POST['start_date'];
                        $end_date=$_POST['end_date'];
                          
                          
                        $status=$_POST['status'];
                        
                        if($course_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter course name";
                        }
                        if($course_duration =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter course duration";
                        }   
                        if($course_level =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter course level";
                        }
                        
                        $uploaded_url="";
                            if(count($errors)==0 && $_FILES['course_video']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update courses set course_video='' where course_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        unlink("../UploadedData/".$row_record['course_video']);
                                    if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        unlink("../UploadedData/".$row_record['course_video']);
                                }
                                $path = "../UploadedData/";
                                $valid_formats = array("wmv", "flv","mp4","mov","3gp","3ga","avi","mpg","3gpp","gsm","mpeg","m4v","cmp","mpe","movie","swf");
                                $name = $_FILES['course_video']['name'];
                                $size = $_FILES['course_video']['size'];
                                
                                    list($txt, $ext) = explode(".", $name);
                                    if($name) 
                                        {
                                        $lowercase = strtolower($ext);
                                            if(in_array($lowercase,$valid_formats))
                                                { 
                                                    $uploaded_url = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
                                                    $tmp = $_FILES['course_video']['tmp_name'];                                    
                                                    $newfile = "../UploadedData/";

                                                    $explodeName = explode(".",$uploaded_url);

                                                    $thumbfile = $explodeName[0] . ".jpg";
                                                    $thumbfileswf = $explodeName[0] . ".flv";
                                                    $thumbfileMp4 = $explodeName[0] . ".mp4";

                                                     //ffmpeg -i sample.3gp -ar 44100  sample3gp.swf 
                                                    // ffmpeg -i Nikon_Coolpix_S3000.AVI -r 24 nikon.mp4

                                                    $options = "-an -y -f mjpeg -ss 2 -s 180x150 -vframes 1 ";
                                                    $optionsSWF = "-ar 44100";
                                                    $optionsMP4 = "-r 24";

                                                    $thumbpath = "../UploadedData/".$thumbfile;  
                                                    $thumbpathSWf = "../UploadedData/".$thumbfileswf; 
                                                    $thumbpathMpp = "../UploadedData/".$thumbfileMp4; 

                                                    $target_path1 = $newfile.$uploaded_url;
                                                    if(move_uploaded_file($tmp, $path.$uploaded_url))
                                                        {
                                                            $thump_target_path="../UploadedData/".$uploaded_url;                                            
                                                            $file_uploaded = 1;
                                                            exec("ffmpeg -i " . $thump_target_path . " " . $options . " " . $thumbpath, $output);                                            
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsSWF." ".$thumbpathSWf, $outputs);
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsMP4." ".$thumbpathMpp, $outputss);
                                                            //print_r($output); 
                                                        }
                                                    else
                                                    {
                                                        $file_uploaded=0;
                                                        $success=0;
                                                        $errors[$i++]="There are some errors while uploading video, please try again";                                                        
                                                    }
                                                }
                                            else
                                                {
                                                    $file_uploaded=0;
                                                    $success=0;
                                                    $errors[$i++]="Invalid file format..";
                                                    
                                                }
                                        }
                            }
                            
                            $uploaded_url1="";
                            if(count($errors)==0 && $_FILES['course_pdf']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update courses set course_pdf='' where course_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                }
                                $uploaded_url1=time().basename($_FILES['course_pdf']["name"]);
                                $newfile1 = "../UploadedData/";

                                $filename = $_FILES['course_pdf']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['course_pdf']['type'];// type of file being uploaded
                                //echo $filetype;exit;
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['course_pdf']['tmp_name'];
                                $target_path1 = $newfile1.$uploaded_url1;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "application/pdf")
                                {
                                    
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../UploadedData/".$uploaded_url1;
                                        copy($target_path1,$thump_target_path);
                                        $file_uploaded1=1;
                                    }
                                    else
                                    {
                                        $file_uploaded1=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading pdf, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded1=0;
                                    $success=0;
                                    $errors[$i++]="Location pdf: Only pdf files allowed";
                                }
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
                           
                            // echo $_POST['course_url'];
                            if($_POST['course_url'] != '')
                            {
                               if(strpos($_POST['course_url'],"<iframe")!==false)
                               {
                                  // echo '1'.'<br />';
                                   $ex=explode("/", $_POST['course_url']);
                                   $ex1=explode('"', $ex[4]);
                                   $data_record['course_url']= $ex1[0];   //$data_record1['course_url'] =   nl2br($_POST['course_url']);
                               }
                               else if(strpos($_POST['course_url'],"http://")!==false || strpos($_POST['course_url'],"https://")!==false)
                               {
                                   $ex=explode("/", $_POST['course_url']);                              
                                   if($ex[2]=='youtu.be')
                                   {
                                       //echo 'sub 1'.'<br />';
                                        $data_record['course_url']= $ex[3];                                    
                                   }
                                   else
                                   {                                   
                                        //echo 'sub 2<br />';
                                        $ex1=explode('=', $ex[3]);
                                        $data_record['course_url']=$ex1[1];
                                   }
                               }
                            }
                            
                            $data_record['course_url_img']=$thumbfile;
                            $data_record['course_name'] =$course_name;
                            $data_record['course_description'] =$course_description;
                            $data_record['course_duration'] =$course_duration;
                            $data_record['course_level'] =$course_level;
                            $data_record['category_id'] =$category_id;
                            $data_record['free_course'] = $free_course;
                            $data_record['course_price'] = $course_price;
                            $data_record['course_keyword'] = $course_keyword;
                            
                            if($file_uploaded)
                                $data_record['course_video'] =$uploaded_url;
                            if($file_uploaded1)
                                $data_record['course_pdf'] =$uploaded_url1;
                            
                            $data_record['course_author'] =$course_author;
                           
                            if($record_id)
                            {
                                $where_record=" course_id='".$record_id."'";                                
                                $db->query_update("courses", $data_record,$where_record);                              
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
                                $courses_id=$db->query_insert("courses", $data_record);                                
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                            
                            $discount['discount']=$discountss;
                            $discount['start_date']=$start_date;
                            $discount['end_date']=$end_date;
                            $discount['status']=$status;
//                            $discount['for_edit']=$_POST['discount_course'];
                            
                            if($courses_id)
                                $discount['course_id']=$courses_id;
                            else 
                                $discount['course_id']=$record_id;
                            
                            if($val_coupon['discount_coupon_id'] && $_POST['discount_course'] == 'Y')
                            {

                                $where=" discount_coupon_id='".$val_coupon['discount_coupon_id']."'";
                                $db->query_update("discount_coupon", $discount,$where);                                
                            }
                            else if($_POST['discount_course']== 'Y')
                            {
                                
                                $discount['added_date']=date("Y-m-d H:i:s");
                                $discount_id=$db->query_insert("discount_coupon", $discount);
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
                <td width="20%">Course Category<span class="orange_font">*</span></td>
                <td width="40%" >
                    <select name="category_id" id="category_id" class="validate[required] input_select" >  
                        <option value=""> Select Category</option>
                        <?php
                            $select_category = "select * from course_category order by category_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['category_id'] == $row_record['category_id'])
                                    echo '<option value='.$data_category['category_id'].' selected="selected">'.$data_category['category_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['category_id'].'>'.$data_category['category_name'].'</option>';
                            }
                            ?>        
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Course Name<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="course_name" id="course_name" value="<?php if($_POST['save_changes']) echo $_POST['course_name']; else echo $row_record['course_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>             
            <tr>
                <td width="20%">Course Duration<span class="orange_font">*</span></td>
                <td width="40%"><input type="text" class="validate[required] input_text" name="course_duration" id="course_duration" value="<?php if($_POST['save_changes']) echo $_POST['course_duration']; else echo $row_record['course_duration'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Course level<span class="orange_font">*</span></td>
                <td width="40%">
                    <select name="course_level" id="course_level" class="validate[required] input_select">
                        <option value="">Select course Level</option>
                        <option value="Basic" <?php if($row_record['course_level']=='Basic') echo 'Selected'; ?>>Basic</option>
                        <option value="Intermediate" <?php if($row_record['course_level']=='Intermediate') echo 'Selected'; ?>>Intermediate</option>
                        <option value="Expert"<?php if($row_record['course_level']=='Expert') echo 'Selected'; ?>>Expert</option>
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
            <?php
                $sql_sub_cat = "select * from courses where course_id='".$row_record['course_id']."' ";
                $data_sub_cat = $db->fetch_array($db->query($sql_sub_cat));
                $implode_data = explode(",",$data_sub_cat['course_author']);            
             ?>
            <tr>
                <td width="20%">Course Author</td>
                <td width="40%" >
                    <select  multiple="multiple" name="user_id[]" id="user_id" class="input_select" style="width:150px;">                        
                        <?php 
                            $select_faculty = "select * from user where user_type='Faculty' order by user_id asc";
                            $ptr_faculty = mysql_query($select_faculty);
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
                                $class = '';
                                for($t=0;$t<count($implode_data);$t++)
                                 {  
                                     if($data_faculty['user_id'] == $implode_data[$t])
                                            $class = 'selected="selected"';
                                 }
                                
                                 if($class !='')                                    
                                        echo '<option value="'.$data_faculty['user_id'].'" '.$class.' >'.$data_faculty['first_name'].' '.$data_faculty['last_name'].'</option>';     
                                 else
                                     echo '<option value="'.$data_faculty['user_id'].'" >'.$data_faculty['first_name'].' '.$data_faculty['last_name'].'</option>';  
                                                                
                               /* $name=$data_faculty['first_name'].' '.$data_faculty['last_name'];
                                if($data_faculty['user_id'] == $row_record['user_id'])
                                    echo '<option value="'.$data_faculty['user_id'].'" selected="selected">'.$name.'</option>';
                                else
                                    echo '<option value="'.$data_faculty['user_id'].'">'.$name.'</option>';*/
                            }
                            ?>        
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Course Description <!--span class="orange_font">*</span --></td>
                <td colspan="2">
                    <?php
                            include("../FCKeditor/fckeditor.php");
                            $BasePath = "../FCKeditor/";
                            $oFCKeditor 		= new FCKeditor('course_description') ;
                            $oFCKeditor->BasePath	= $BasePath ;
                            if($_POST['save_changes'])
                                $oFCKeditor->Value	= stripslashes($_POST['course_description']);
                            else
                                $oFCKeditor->Value	= stripslashes($row_record['course_description']);
                            //$oFCKeditor->ToolbarSet	= "MyToolBar";
                            $oFCKeditor->Height		= "230";
                            $oFCKeditor->Create() ;
                     ?>
                </td> 
<!--                <td width="40%"></td>-->
            </tr>
            <tr>
                <td width="20%">Is it free course</td>
                <td width="40%">
                    <input type="radio" name="free_course" onchange="showdiv(this.value);" id="free_course" value="Y" <?php if($_POST['free_course'] == 'Y' || $row_record['free_course'] == 'Y') echo 'checked="checked"';?>/>Yes  &nbsp; &nbsp; 
                    <input type="radio" name="free_course" id="free_course" onchange="showdiv(this.value);" value="N" <?php if($_POST['free_course'] == 'N' || $row_record['free_course'] == 'N') echo 'checked="checked"';else echo 'checked="checked"';?> />No </td> 
                <td width="40%"></td>
            </tr>
            
            <tr>
                <td width="20%"><div id="coursess" class="coursess" >Course Fees</div></td>
                
                <td width="40%"><div id="coursess" class="coursess" >
                    <input type="text" class="input_text" name="course_price" id="course_price" value="<?php if($_POST['save_changes']) echo $_POST['course_price']; else echo $row_record['course_price'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
            
            <tr>
                <td width="20%">Discount course</td>
                <td width="40%">
                    <input type="radio" name="discount_course" id="discount_course" onchange="show_dicount(this.value);" value="Y" <?php if($_POST['discount'] == 'Y') echo 'checked="checked"';else echo 'checked="checked"';?>/>Yes  &nbsp; &nbsp; 
                    <input type="radio" name="discount_course" id="discount_course" onchange="show_dicount(this.value);" value="N" <?php if($_POST['discount'] == 'N') echo 'checked="checked"';?> />No </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <div id="discount" class="discount">
                        <table border="0" cellspacing="15" cellpadding="0"  width="40%" >
                            <tr>
                                <td >Discount</td>
                                <td >
                                    <input type="text" class="input_text" name="discount" id="discount" value="<?php if($_POST['save_changes']) echo $_POST['discount']; else echo $val_coupon['discount'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Start Date</td>
                                <td>
                                    <input type="text" class="validate[required] input_text datepicker" name="start_date" id="start_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else echo $val_coupon['start_date'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td>
                                    <input type="text" class="validate[required] input_text datepicker" name="end_date" id="end_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else echo $val_coupon['end_date'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>                                    
                                    <input type="radio" name="status" id="status"  value="Active" <?php if($_POST['status'] == 'Active' || $val_coupon['status'] == 'Active') echo 'checked="checked"';?>/>Active  &nbsp; &nbsp; 
                                    <input type="radio" name="status" id="status"  value="Inactive" <?php if($_POST['status'] == 'Inactive' || $val_coupon['status'] == 'Inactive') echo 'checked="checked"';?>/>Inactive 
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>                
            </tr>
            <tr>
                <td width="20%">Course Keyword</td>
                <td width="40%"><input type="text" class="input_text" name="course_keyword" id="course_keyword" value="<?php if($_POST['save_changes']) echo $_POST['course_keyword']; else echo $row_record['course_keyword'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Course PDF</td>
                <td width="40%"><input type="file" class="input_text" name="course_pdf" id="course_pdf" value=""/></td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Course video</td>
                <td width="40%"><input type="file" class="input_text" name="course_video" id="course_video" value=""/></td> 
                <td width="40%"></td>
            </tr>
<!--            <tr><td></td><td colspan="2" class="orange_font"><strong>OR</strong></td></tr>            
            <tr>
                <td width="20%">Youtube Video Url</td>
                <td width="40%"><input type="text" class="input_text" name="course_url" id="course_url" value="<?php if($_POST['save_changes']) echo $_POST['course_url']; else echo $row_record['course_url'];?>" /></td> 
                <td width="40%"></td>
            </tr>-->
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