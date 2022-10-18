<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Account</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; 
$record_id=$_REQUEST['record_id'];
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update bp_site_setting set photo='' where admin_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../member_photo/".$row_record['photo']))
        unlink("../member_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}


?>
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
    <td class="top_mid" valign="bottom"><?php include "include/account_menu.php"; ?></td>
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
                            $wish_title=$_POST['wish_title'];
                            $photo=$_POST['photo'];
                            
                            if($wish_title=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Welcome Title";
                            }
							 $uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update bp_site_setting set photo='' where admin_id='".$record_id."'";
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
                                            $obj_img1->NewHeight = 170;
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
            <tr><td> <br></br>
                                <table align="left" width="50%" style="text-align:left;" class="alert">
                                <tr><td class="text"><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>    
                                <?php
                            }
                            else
                            {
                                $success=1;
                                $data_record['wish_title'] =$wish_title;
                                $data_record['photo'] =$photo;
							    
								if($file_uploaded)
                                $data_record['photo'] = $uploaded_url;

                               
							   $where_record=" admin_id= ".$_SESSION['admin_id']." ";
                                $db->query_update("site_setting", $data_record,$where_record);
                                echo '<br>';
                                echo '<div id="msgbox" style="width:40%;">Changes saved successfully</div>';
                                $_SESSION['email_id']=$email_id;
                            }
                        }
                        if($success==0)
                        {
                        $sql_site_setting="SELECT * FROM ".$GLOBALS["pre_db"]."site_setting where admin_id = '".$_SESSION['admin_id']."' ";
                        $row_record=$db->fetch_array($db->query($sql_site_setting));
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
              <tr>
                <td width="20%">Wish Heading<span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="wish_title" id="wish_title" value="<?php if($_POST['save_changes']) echo $_POST['wish_title']; else echo $row_record['wish_title'];?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                <td>Wish Image</td>
                <td width="40%"> <?php //echo '===sachin '.$row_record['photo'];
                    if(  $row_record['photo'] && file_exists("../member_photo/".$row_record['photo']))
                        echo '<img height="77px" width="77px" src="../member_photo/'.$row_record['photo'].'"><br>
						<a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$_SESSION['admin_id'].'">Delete / Upload new</a></td><td width="40%"></td>';
                    else
                        echo '<input type="file" name="photo" id="photo" class="validate[required] input_text"></td>';?></td>
                <td> </td> 
              </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="SAVE CHANGES" name="save_changes"  /></td>
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