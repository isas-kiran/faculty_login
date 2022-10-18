<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Change Username</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
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
<?php include "ex_include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "ex_include/menuLeft.php"; ?>
<!--left end-->

<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "ex_include/account_menu.php"; ?></td>
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
                            $c_name=$_POST['c_name'];
                            $new_name=$_POST['new_name'];
                            $new_c_name=$_POST['new_c_name'];

                            if($c_name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter current password";
                            }
                            if($c_name)
                            {
                                $sql_site_setting="select admin_id from ".$GLOBALS["pre_db"]."site_setting where pass='".$c_name."' and admin_id = '".$_SESSION['admin_id']."' ";
                                if(!mysql_num_rows($db->query($sql_site_setting)))
                                {
                                    $success=0;
                                    $errors[$i++]="Provide correct current password";
                                }
                            }
                            if($new_name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter new password";
                            }
                            if($new_c_name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter new confirm password";
                            }
                            if($new_c_name !='' && $new_name !='')
                            {
                                if($new_name!=$new_c_name)
                                {
                                        $success=0;
                                        $errors[$i++]="New password & new confirm password should be same";
                                }
                            }
                            if($c_name !='' && $new_name !='')
                            {
                                if($c_name == $new_name)
                                {
                                    $success=0;
                                    $errors[$i++]="Choose a password you haven't previously used with this account";
                                }
                            }
                            if(count($errors))
                            {
                                ?>
                                <tr><td><br></br>
                                <table align="left" width="60%" style="text-align:left;" class="alert">
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
                                $update_site_setting="update ".$GLOBALS["pre_db"]."site_setting set pass='".$new_c_name."' where  admin_id = '".$_SESSION['admin_id']."' ";
                                //echo $update_site_setting;
                                $db->query($update_site_setting);
                                echo '<br><div id="msgbox" style="width:40%;">Changes saved successfully</center></div>';
                            }
                        }
                        if($success==0)
                        {?>
            <tr><td>
        <form method="post" id="jqueryForm">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
              <tr>
                <td width="20%">Current Password<span class="orange_font">*</span></td>
                <td width="40%" style=""><input type="password" maxlength="16" class="validate[required,maxSize[15]] input_text" name="c_name" id="c_name" value="<?php if($_POST['save_changes']) echo $_POST['c_name'];?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                <td>New Password<span class="orange_font">*</span></td>
                <td style=""><input type="password" maxlength="16" class="validate[required,minSize[6],maxSize[15]] input_text" name="new_name" id="new_name" value="<?php if($_POST['save_changes']) echo $_POST['new_name'];?>"/></td>
                <td width="40%"></td> 
              </tr>
              <tr>
                <td>New Confirm Password<span class="orange_font">*</span></td>
                <td style=""><input type="password" maxlength="16" class="validate[required,minSize[6],equals[new_name]] input_text" name="new_c_name" id="new_c_name" value="<?php if($_POST['save_changes']) echo $_POST['new_c_name'];?>"  /></td>
                <td width="40%"></td> 
              </tr>  
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="Change Password" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
           </td></tr>
                <?php }?>	 
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
<div id="footer"><? require("ex_include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>