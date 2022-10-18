<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
	
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM bp_body_member where member_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update bp_body_member set photo='' where member_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../member_photo/".$row_record['photo']))
        unlink("../member_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Members</title>
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
    
      <!--------------------------------------FOR MARATHI TYPING------------------------>    
    <script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,akindicplugin",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,|removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,akindicplugin",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : ""
		}
	});
</script>
<!-----------------------------------------SCRIPT END------------------------------>
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
    <td class="top_mid" valign="bottom"><?php include "include/member_menu.php"; ?></td>
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
                            $member_name=$_POST['member_name'];
                            $disignation=$_POST['disignation'];                   
                            $contact_no=$_POST['contact_no'];  
							$address=$_POST['address'];
							$photo=$_POST['photo'];
							$email=$_POST['email'];
							$dob=$_POST['dob'];
							 
                            if($member_name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Member Name ";
                            }
							 if($address=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Address";
                            }
							 $uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update bp_body_member set photo='' where member_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['photo'] && file_exists("../member_photo/".$row_record['photo']))
                                        unlink("../member_photo/".$row_record['photo']);
                                    if($row_record['photo'] && file_exists("../member_photo/".$row_record['photo']))
                                        unlink("../member_photo/".$row_record['photo']);
                                }
                                $uploaded_url=time().basename($_FILES['photo']["name"]);
                                $newfile = "../member_photo/";

                                $filename = $_FILES['photo']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['photo']['type'];// type of file being uploaded
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['photo']['tmp_name'];
                                $target_path1 = $newfile.$uploaded_url;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
                                {
                                    
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../member_photo/".$uploaded_url;
                                        copy($target_path1,$thump_target_path);

                                        list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                        //echo $width.$height;
                                        if($width<=170 && $height<=170)
                                        {
                                            $file_uploaded=1;
                                        }
                                        else
                                        {
                                            //------------resize the image----------------
                                            $obj_img1 = new thumbnail_images();
                                            $obj_img1->PathImgOld = $thump_target_path;
                                            $obj_img1->PathImgNew = $thump_target_path;
                                            $obj_img1->NewWidth = 150;
                                            $obj_img1->NewHeight = 171;
                                            if (!$obj_img1->create_thumbnail_images())
                                            {
                                                $file_uploaded=0;
                                                unlink($target_path1);
                                                $success=0;
                                                $errors[$i++]="There are some errors while uploading image, please try again";
                                            }
                                            else
                                            {
                                                $file_uploaded=1;
                                               /* list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                                //echo $width.$height;
                                                if($height>100)
                                                {
                                                    //------------resize the image----------------
                                                    $obj_img1 = new thumbnail_images();
                                                    $obj_img1->PathImgOld = $thump_target_path;
                                                    $obj_img1->PathImgNew = $thump_target_path;
                                                    $obj_img1->NewHeight = 100;
                                                    if (!$obj_img1->create_thumbnail_images())
                                                    {
                                                        $file_uploaded=0;
                                                        unlink($target_path1);
                                                        $uploaded_url="";
                                                    }                                                    
                                                }
                                                */
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $file_uploaded=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading image, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded=0;
                                    $success=0;
                                    $errors[$i++]="Location image: Only image files allowed";
                                }
                            }
                            if(count($errors))
                            {
                                ?>
                                <tr>
                                    <td> <br></br>
                                    <table align="left" style="text-align:left;" class="alert">
                                    <tr><td ><strong>Please correct the following errors</strong><ul>
                                            <?php
                                            for($k=0;$k<count($errors);$k++)
                                                    echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                            </ul>
                                    </td></tr>
                                    </table>
                                    </td>
                                </tr>   <br></br>  
                                <?php
                            }
                            else
                            {
                                $success=1;
                                $data_record['member_name'] =$member_name;
                                $data_record['disignation'] =$disignation;
								$data_record['dob'] =$dob;
                                $data_record['contact_no'] =$contact_no;
								$data_record['email'] =$email;
                                $data_record['address'] =($address);
                               
							    if($file_uploaded)
                                $data_record['photo'] = $uploaded_url;

                               if($record_id)
                                {
                                   ///print_r($data_record); //    exit;
                                    $where_record=" member_id='".$record_id."'";
                                    $db->query_update("body_member", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("body_member", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Body Members" name="save_changes"  />
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
              <tr>
                  <td width="20%" valign="top">Body Member Name<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="validate[required] input_text" name="member_name" id="member_name"
                 value="<?php if($_POST['save_changes']) echo $_POST['member_name']; else echo $row_record['member_name'];?>" 
                 onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" 
                 onKeyDown="positionChange(event);"  onblur="hideme();" /> <div style="display:none; position:absolute; padding-top:5%;padding-left:10%" id="hindi_images" >
                 <img src="HindiMap.jpg" alt="Hindi letter map"></div></td>
                 
                <td width="10%"></td>
              </tr>
              
              <tr>
                  <td width="20%" valign="top">Designation</td>
                <td width="70%"><input type="text"  class="input_text" name="disignation" id="disignation" value="<?php if($_POST['save_changes']) echo $_POST['disignation']; else echo $row_record['disignation'];?>" /></td> 
                <td width="10%"></td>
              </tr>
              <tr>
                  <td width="20%" valign="top">Date Of Birth</td>
                <td width="70%"><input type="text"  class="input_text datepicker" readonly="true" name="dob" id="dob" value="<?php if($_POST['save_changes']) echo $_POST['dob']; else echo $row_record['dob'];?>" /></td> 
                <td width="10%"></td>
              </tr>
              <tr>
                  <td width="20%" valign="top">Contact No<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="validate[required] input_text" name="contact_no" id="contact_no" value="<?php if($_POST['save_changes']) echo $_POST['contact_no']; else echo $row_record['contact_no'];?>" /></td> 
                <td width="10%"></td>
              </tr>
              <tr>
                  <td width="20%" valign="top">Email Id</td>
                <td width="70%"><input type="text"  class="input_text" name="email" id="email" value="<?php if($_POST['save_changes']) echo $_POST['email']; else echo $row_record['email'];?>" /></td> 
                <td width="10%"></td>
              </tr>
              <tr>
                  <td width="20%" valign="top">Address<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="validate[required] input_text" name="address" id="address" value="<?php if($_POST['save_changes']) echo $_POST['address']; else echo $row_record['address'];?>" /></td> 
                <td width="10%"></td>
              </tr>
                  <td width="20%" valign="top">Photo</td>
               <td width="40%"><?php
                    if($record_id && $row_record['photo'] && file_exists("../member_photo/".$row_record['photo']))
                        echo '<img height="77px" width="77px" src="../member_photo/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                    else
                        echo '<input type="file" name="photo" id="photo" class="validate[required] input_text"></td>';?>
                    </td>
                <td width="10%"></td>
              </tr>
            <!-- <tr>
                  <td valign="top">Description<span class="orange_font">*</span></td>
                  <td>
                      <?php
                                   /* include("../FCKeditor/fckeditor.php");
                                    $BasePath = "../FCKeditor/";
                                    $oFCKeditor 			= new FCKeditor('description') ;
                                    $oFCKeditor->BasePath	= $BasePath ;
                                    if($_POST['save_changes'])
                                        $oFCKeditor->Value		= stripslashes($_POST['description']);
                                    else
                                        $oFCKeditor->Value		= stripslashes($row_record['description']);
                                    //$oFCKeditor->ToolbarSet	= "MyToolBar";
                                    $oFCKeditor->Height		= "600";
                                    $oFCKeditor->Create() ;*/
                     ?>
                  </td> 
             </tr>-->
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?>  Body Member" name="save_changes"  /></td>
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