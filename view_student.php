<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM stud_regi where student_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update stud_regi set photo='' where student_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
        unlink("../student_photos/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
student</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
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
						
                        $name= $_POST['name'];
						$username=$_POST['username'];
                        $pass=$_POST['pass'];
						 $tan_date=explode('/',$_POST['dob'],3);
						 $dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];
						
                        $address=$_POST['address']; 
					    $contact=$_POST['contact'];
					    $mail=$_POST['mail'];
					    $qualification=$_POST['qualification'];
						$photo=$_POST['photo'];
						$added_date=date('Y-m-d H:i:s');                    
                        if($name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter student name   name";
                        }
						 if($contact =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Student Contact No";
                        }
						if($username =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter User Name";
                        }
						if($pass =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter PassWord";
                        }
                       $uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update stud_regi set photo='' where student_id='".$record_id."'";
                                    $db->query($update_news);
                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                                        unlink("../student_photos/".$row_record['photo']);
                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                                        unlink("../student_photos/".$row_record['photo']);
                                }
                                $uploaded_url=time().basename($_FILES['photo']["name"]);
                                $newfile = "../teacher_photo/";

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
                                        $thump_target_path="../teacher_photo/".$uploaded_url;
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
					 
                            
                            $data_record['name']=$name;
                            $data_record['username'] =$username;
                            $data_record['pass'] =$pass;
                            $data_record['dob'] =$dob;
							$data_record['address'] =$address;
                            $data_record['contact'] =$contact;
                            $data_record['mail'] = $mail;
						    $data_record['qualification']=$qualification;
                           
                            $data_record['photo'] =$photo;
						 if($file_uploaded)
							$data_record['photo'] = $uploaded_url;
                            if($record_id)
                            {
                                $where_record="student_id='".$record_id."'";                                
                                $db->query_update("stud_regi", $data_record,$where_record);   
							
								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
							    $data_record['added_date'] = date('Y-m-d H:i:s');
                                $courses_id=$db->query_insert("staff_regi", $data_record);  
							    $staff_id= mysql_insert_id();
								
							$privilege_ids = $_POST['privilege_id'];
                            for($i=0;$i<count($privilege_ids);$i++)
                            {
                            $insert_for_prevelgegeis = "insert into admin_previleges values(0,'".$privilege_ids[$i]."','',
							'".$staff_id."')";
                            $ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
						    }                             
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
           
            <?php
                $sql_sub_cat = "select * from staff_regi where staff_id='".$row_record['staff_id']."' ";
                $data_sub_cat = $db->fetch_array($db->query($sql_sub_cat));
                //$implode_data = explode(",",$data_sub_cat['course_author']);            
             ?>
            <tr>
                <td width="20%">Student Name<span class="orange_font">*</span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            <tr>
                <td width="20%">Contact No<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="contact" id="contact" value="<?php if($_POST['save_changes']) echo $_POST['contact']; else echo $row_record['contact'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
            <tr>
                <td width="20%">Email Id<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="mail" id="mail" value="<?php if($_POST['save_changes']) echo $_POST['mail']; else echo $row_record['mail'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
             <tr>
                <td width="20%">Address<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="address" id="address" value="<?php if($_POST['save_changes']) echo $_POST['address']; else echo $row_record['address'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
             <tr>
                <td width="20%">Date Of Birth<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text datepicker" name="dob" id="dob" 
                    value="<?php if($_POST['save_changes']) echo $_POST['dob']; else 
				$arrage_date= explode('-',$row_record['dob'],3);     
				echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
					// $row_record['staff_dob'];
					?>" />
                </td> 
                <td width="40%"></td>
            </tr>              
             <tr>
                <td width="20%">Qualification<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="qualification" id="qualification" value="<?php if($_POST['save_changes']) echo $_POST['qualification']; else echo $row_record['qualification'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            <tr>
              <td width="20%"> User Name<span class="orange_font">*</span> </td>
              <td width="40%">
                <input type="text" class="validate[required] input_text" name="username" id="username" value="<?php if($_POST['save_changes']) echo $_POST['username']; else echo $row_record['username'];?>" />
                </td> 
              <td width="40%"></td>
            </tr>
            <tr>
                <td width="20%">Password<span class="orange_font">*</span></td>
                <td width="40%"><input type="password" class="validate[required] input_text" name="pass" id="pass" value="<?php if($_POST['save_changes']) echo $_POST['pass']; else echo $row_record['pass'];?>" />
 </td> 
                <td width="40%"></td>
            </tr>
            <tr>
            <td width="20%">Photo</td>
            <td width="40%"><?php
                    if($record_id && $row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                        echo '<img height="77px" width="77px" src="../student_photos/'.$row_record['photo'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                    else
                        echo '<input type="file" name="photo" id="photo" class="input_text"></td>';?></td> 
            <td width="40%"></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Student " name="save_changes"  /></td>
            <td></td>
            </tr>
        </table>
        </form>
        </td></tr>
<?php
 } ?>
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