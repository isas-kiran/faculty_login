<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM bp_saving where saving_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Saving</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/saving_menu.php"; ?></td>
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
                            $saving_name=$_POST['saving_name'];
                            $discription=$_POST['discription'];
						    $date_saving=$_POST['date_saving'];
                            
                            if($saving_name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Saving";
                            }
                            if($discription=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Discription ";
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
                                $data_record['saving_name'] =$saving_name;
                                $data_record['discription'] =$discription; 
                                $data_record['date_saving'] = $date_saving;

                               if($record_id)
                                {
                                    $where_record="saving_id='".$record_id."'";
                                    $db->query_update("saving", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("saving", $data_record);
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
                        <td width="22%" valign="top">Saving Name<span class="orange_font">*</span></td>
                        <td ><input type="text"  class="validate[required] input_text" name="saving_name" id="saving_name" value="<?php if ($_POST['save_changes']) echo $_POST['saving_name']; else echo $row_record['saving_name']; ?>" /></td> 
                        <td width="19%" ></td>
                    </tr>
                    <tr>
                        <td valign="top">Discription <span class="orange_font">*</span></td>
                                 
                          <td width="59%">
                            <?php
                                            include("../FCKeditor/fckeditor.php");
                                            $BasePath = "../FCKeditor/";
                                            $oFCKeditor 			= new FCKeditor('discription') ;
                                            $oFCKeditor->BasePath	= $BasePath ;
                                            if($_POST['save_changes'])
                                                $oFCKeditor->Value		= stripslashes($_POST['discription']);
                                            else
                                                $oFCKeditor->Value		= stripslashes($row_record['discription']);
                                            //$oFCKeditor->ToolbarSet	= "MyToolBar";
                                            $oFCKeditor->Height		= "300";
                                            $oFCKeditor->Create() ;
                             ?>
                        </td> 
                        <td></td>
                    </tr>
                    <tr>
                    <td valign="top">Date</td>
                    <td>           
                    <input type="text"  class="input_text  datepicker" readonly="true" name="date_saving" id="date_saving" value="<?php if ($_POST['save_changes']) echo $_POST['date_saving']; else echo $row_record['date_saving']; ?>" />
                    </td> 
                    <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" class="input_btn" value="<?php if ($record_id) echo "Update"; else  echo "Add"; ?> Saving" name="save_changes"  /></td>
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