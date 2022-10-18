<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_news where news_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> News</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/news_menu.php"; ?></td>
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
                            $source=$_POST['source'];
                            $post_date=$_POST['post_date'];                            
                            $category=$_POST['category'];                             
                            
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
                                $data_record['description'] =($description); 
                                $data_record['source'] = $source;
//                                if($post_date !='')
                                $data_record['post_date'] = $post_date;
                                $data_record['category'] = $category;
                                $data_record['status'] ='Active';

                               if($record_id)
                                {
                                   ///print_r($data_record); //    exit;
                                    $where_record=" news_id='".$record_id."'";
                                    $db->query_update("news", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("news", $data_record);
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
                  <td width="20%" valign="top">Title<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="validate[required] input_text" name="title" id="title" value="<?php if($_POST['save_changes']) echo $_POST['title']; else echo $row_record['title'];?>" /></td> 
                <td width="10%"></td>
              </tr>
             <tr><code><?php //echo THEMATER_URL; ?></code>
                  <td valign="top">Description<span class="orange_font">*</span></td>
                  <td>
                      <?php
                                    include("../FCKeditor/fckeditor.php");
                                    $BasePath = "../FCKeditor/";
                                    $oFCKeditor 			= new FCKeditor('description') ;
                                    $oFCKeditor->BasePath	= $BasePath ;
                                    if($_POST['save_changes'])
                                        $oFCKeditor->Value		= stripslashes($_POST['description']);
                                    else
                                        $oFCKeditor->Value		= stripslashes($row_record['description']);
                                    //$oFCKeditor->ToolbarSet	= "MyToolBar";
                                    $oFCKeditor->Height		= "300";
                                    $oFCKeditor->Create() ;
                     ?>
                      
<!--                      <textarea name="description" id="description" class="validate[required] input_textarea" rows="4"><?php //if($_POST['save_changes']) echo $_POST['description']; else echo $row_record['description'];?></textarea></td>-->
                  </td> </tr>
              <tr>
                <td width="20%">Source</td>
                <td width="40%"><input type="text"  class="input_text" name="source" id="source" value="<?php if($_POST['save_changes']) echo $_POST['source']; else echo $row_record['source'];?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                <td width="20%">Category</td>
                <td width="40%"><input type="text"  class="input_text" name="category" id="category" value="<?php if($_POST['save_changes']) echo $_POST['category']; else echo $row_record['category'];?>" /></td> 
                <td width="40%"></td>
              </tr>
            <div class="demo">

            <tr>
                <td width="20%">Post Date<span class="orange_font">*</span></td>
                <td width="40%"><input type="text" class="validate[required] input_text datepicker" name="post_date" id="post_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['post_date']; else echo $row_record['post_date'];?>" /></td> 
                <td width="40%"></td>
              </tr>
            </div>             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> News" name="save_changes"  /></td>
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