<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Account</title>
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
                            $title=$_POST['title'];
                            $description=$_POST['description'];
                            
                            if($title=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Welcome Title";
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
                                $data_record['title'] =$title;
                                $data_record['description'] =$description;
                               
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
                        $row_site_setting=$db->fetch_array($db->query($sql_site_setting));
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
              <tr>
                <td width="20%">Well come Containt Heading<span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="title" id="title" value="<?php if($_POST['save_changes']) echo $_POST['title']; else echo $row_site_setting['title'];?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                <td>Middle Containt</td>
                <td>
                <?php
                                    include("../FCKeditor/fckeditor.php");
                                    $BasePath = "../FCKeditor/";
                                    $oFCKeditor 			= new FCKeditor('description') ;
                                    $oFCKeditor->BasePath	= $BasePath ;
                                    if($_POST['save_changes'])
                                        $oFCKeditor->Value		= stripslashes($_POST['description']);
                                    else
                                        $oFCKeditor->Value		= stripslashes($row_site_setting['description']);
                                    $oFCKeditor->Height		= "300";
                                    $oFCKeditor->Create() ;
                     ?>
                
                <td width="40%"></td> 
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