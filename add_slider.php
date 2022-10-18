<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT title,menu_id,description FROM slider where slider_id='".$record_id."'";
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
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
Slider</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/slider_menu.php"; ?></td>
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
							$menu_id =$_POST['menu_id']; 
							           
                            
                            if($title=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter title ";
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
                                $data_record['title'] =$title;
                                $data_record['description'] =($description);
							   $data_record['menu_id'] =($menu_id);
							
                               if($record_id)
                                {
                                   ///print_r($data_record); //    exit;
                                    $where_record=" slider_id='".$record_id."'";
                                    $db->query_update("slider", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("slider", $data_record);
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
              <tr>
                 <td width="20%" valign="top">Select Menu</td>
                <td width="70%">
               
                           <?php //echo $row_record['menu_id']; ?>
                            <select name="menu_id"  class="input_select_login">
					  <option value="">==Select Menu ==</option>
					 <?php
					  
					 $select_names = "select menu_id,name from ".$GLOBALS["pre_db"]."menu  ";
					 
					  $ptr= mysql_query($select_names);
					  if(mysql_num_rows($ptr))
					  {
					  	while($data=mysql_fetch_array($ptr))
					  	{      if( $data['menu_id'] == $_POST['menu_id'] || $data['menu_id'] == $row_record['menu_id'] )
								{
										echo  "<option value='".$data['menu_id']."' selected='selected'> ".$data['name']."</option>";
								}
								else
								{
									echo  "<option value='".$data['menu_id']."'> ".$data['name']."</option>";
								}	
					  	}
					  }
					 ?>
				 </select>
                 </td> 
                <td width="10%"></td>
              </tr>
             <tr>
                  <td valign="top">Description</td>
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
                                    $oFCKeditor->Height		= "600";
                                    $oFCKeditor->Create() ;
                     ?>
                  </td> 
             </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Pages" name="save_changes"  /></td>
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