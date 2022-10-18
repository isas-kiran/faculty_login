<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT form_link,course_id,form_name,form_id,form_desc,authorised FROM forms where form_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Download</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/download_menu.php"; ?></td>
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
                        $form_name=$_POST['form_name'];
                        $form_desc = $_POST['form_desc'];
                        $course_duration=$_POST['subject_id'];
						$course_id=$_POST['course_id'];
                        $authorised=$_POST['authorised'];
                        $added_date=('Y-m-d H:i:s');                        
                        $form_link=$_POST['form_link']; 
						$subject_id=$_POST['subject_id']; 

                        if($form_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter From name";
                        }
                        if($authorised =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Select Athorised or not ";
                        }   
                            $uploaded_url1="";
                            if(count($errors)==0 && $_FILES['form_link']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update forms set form_link='' where form_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['form_link'] && file_exists("../download_data/".$row_record['form_link']))
                                        unlink("../download_data/".$row_record['form_link']);
                                    if($row_record['form_link'] && file_exists("../download_data/".$row_record['form_link']))
                                        unlink("../download_data/".$row_record['form_link']);
                                }
                                $uploaded_url1=time().basename($_FILES['form_link']["name"]);
                                $newfile1 = "../download_data/";

                                $filename = $_FILES['form_link']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['form_link']['type'];// type of file being uploaded
                                //echo $filetype;exit;
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['form_link']['tmp_name'];
                                $target_path1 = $newfile1.$uploaded_url1;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "application/pdf")
                                {
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../download_data/".$uploaded_url1;
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
                            if($_POST['form_link'] != '')
                            {
                               if(strpos($_POST['form_link'],"<iframe")!==false)
                               {
                                  // echo '1'.'<br />';
                                   $ex=explode("/", $_POST['form_link']);
                                   $ex1=explode('"', $ex[4]);
                                   $data_record['form_link']= $ex1[0];   //$data_record1['course_url'] =   nl2br($_POST['course_url']);
                               }
                               else if(strpos($_POST['form_link'],"http://")!==false || strpos($_POST['form_link'],"https://")!==false)
                               {
                                   $ex=explode("/", $_POST['form_link']);                              
                                   if($ex[2]=='youtu.be')
                                   {
                                       //echo 'sub 1'.'<br />';
                                        $data_record['form_link']= $ex[3];                                    
                                   }
                                   else
                                   {                                   
                                        //echo 'sub 2<br />';
                                        $ex1=explode('=', $ex[3]);
                                        $data_record['form_link']=$ex1[1];
                                   }
                               }
                            }
                            
							$data_record['admin_id'] = $_SESSION['admin_id'];
                            $data_record['form_name'] =$form_name;
                            $data_record['form_desc'] =$form_desc;
                            $data_record['course_id'] =$course_id;
                            $data_record['authorised'] =$authorised;
                            $data_record['added_date'] =$added_date;
							$data_record['subject_id'] =$subject_id;
							
							
                            if($file_uploaded)
                           $data_record['form_link'] =$uploaded_url1;
                            if($record_id)
                            {
                                $where_record=" form_id='".$record_id."'";                                
                                $db->query_update("forms", $data_record,$where_record);                              
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
                                $courses_id=$db->query_insert("forms", $data_record);                                
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
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <tr>
            <td width="20%">Select Course<span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="course_id" id="course_id" class="validate[required] input_select" onchange="show_subject(this.value)">  
                        <option value=""> Select Course </option>
                        <?php
                            $select_category = "select course_id,course_name from courses ".$_SESSION['where_admin_id_2']." order by course_id asc";
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
            </tr>
            <tr>
                <td width="20%">File Name<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="form_name" id="form_name" value="<?php if($_POST['save_changes']) echo $_POST['form_name']; else echo $row_record['form_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>             
           
            <tr>
            <td width="20%" valign="top">Course Description <!--span class="orange_font">*</span --></td>
            <td colspan="2">
                    <?php
                            include("../FCKeditor/fckeditor.php");
                            $BasePath = "../FCKeditor/";
                            $oFCKeditor 		= new FCKeditor('form_desc') ;
                            $oFCKeditor->BasePath	= $BasePath ;
                            if($_POST['save_changes'])
                                $oFCKeditor->Value	= stripslashes($_POST['form_desc']);
                            else
                                $oFCKeditor->Value	= stripslashes($row_record['form_desc']);
                            //$oFCKeditor->ToolbarSet	= "MyToolBar";
                            $oFCKeditor->Height		= "230";
                            $oFCKeditor->Create() ;
                     ?>
                </td> 
            </tr>
            <tr>
                <td width="20%">Is it Athorised </td>
                <td width="40%">
                    <input type="radio" name="authorised"  value="Authorised" <?php if($_POST['authorised'] == 'Authorised' || $row_record['authorised'] == 'Authorised') echo 'checked="checked"';?>/>Yes  &nbsp; &nbsp; 
                    <input type="radio" name="authorised"  value="N" <?php if($_POST['authorised'] == 'N' || $row_record['authorised'] == 'N') echo 'checked="checked"';else echo 'checked="checked"';?> />No </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">File (PDF)</td>
                <td width="40%"><input type="file" class="input_text" name="form_link" id="form_link" value=""/></td> 
                <td width="40%"></td>
            </tr>
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