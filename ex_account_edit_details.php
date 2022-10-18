<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Account</title>
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
    <script>
function validin()
{
	frm=document.jqueryForm;
	disp_error="Please Correct Following errors\n\n";
	error="";
	
	if(frm.name.value=='')
	{
		disp_error +="Enter Name\n";
		document.getElementById('name').style.border = '1px solid #f00';
		frm.name.focus();
		error="yes";
	}
	if(frm.email.value=='')
	{
		disp_error +="Enter Email ID\n";
		document.getElementById('email').style.border = '1px solid #f00';
		frm.email.focus();
		error="yes";
	}
	else
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(frm.email.value))  
		{  
			
		}
		else
		{
			disp_error +="Enter Valid Email ID\n";
			document.getElementById('email').style.border = '1px solid #f00';
			frm.email.focus();
			error="yes";
		} 
	}
	if(frm.alternate_email.value !='')
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(frm.alternate_email.value))  
		{  
			
		}
		else
		{
			disp_error +="Enter Valid Alternate Email ID\n";
			document.getElementById('alternate_email').style.border = '1px solid #f00';
			frm.alternate_email.focus();
			error="yes";
		} 
	}
	
	if(frm.contact_email.value=='')
	{
		disp_error +="Enter Contact Email ID\n";
		document.getElementById('contact_email').style.border = '1px solid #f00';
		frm.contact_email.focus();
		error="yes";
	}
	else
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(frm.contact_email.value))  
		{  
			
		}
		else
		{
			disp_error +="Enter Valid Contact Email ID\n";
			document.getElementById('contact_email').style.border = '1px solid #f00';
			frm.contact_email.focus();
			error="yes";
		} 
	}
	if(frm.contact_phone.value !='')
	{
		if(frm.contact_phone.value.length < 11 && frm.contact_phone.value.length > 9)
		{
			
		}
		else
		{
			disp_error +="Enter Valid Contact Number\n";
			document.getElementById('contact_phone').style.border = '1px solid #f00';
			frm.contact_phone.focus();
			error="yes";
		}
	}
	
	if(error=="yes")
	{
		alert(disp_error);
		return false;
	}
	else
	return true;
	
}
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
                            $name=$_POST['name'];
                            $email_id=$_POST['email'];
                            $alternate_email=$_POST['alternate_email'];
                            $designation=$_POST['designation'];
                            $contact_address=$_POST['contact_address'];
                            $contact_email=$_POST['contact_email'];
                            $contact_phone=$_POST['contact_phone'];

                            if($name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter your name";
                            }
                            if($email_id=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter your email";
                            }
                            if($email_id && !isValidEmailPHP($email_id))
                            {
                                    $success=0;
                                    $errors[$i++]="Enter valid email";
                            }
                            if($contact_email=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter your contact email";
                            }
                            if($contact_email && !isValidEmailPHP($contact_email))
                            {
                                    $success=0;
                                    $errors[$i++]="Enter valid contact email";
                            }
							 if($alternate_email && !isValidEmailPHP($alternate_email))
                            {
                                    $success=0;
                                    $errors[$i++]="Enter valid alternate email";
                            }
                          /*    if($contact_phone=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter your contact phon no";
                            }*/
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
                                $data_record['name'] =$name;
                                $data_record['email'] =$email_id;
                                $data_record['alternate_email'] =$alternate_email;
                                $data_record['designation'] =$designation;
                                $data_record['contact_address'] =$contact_address;
                                $data_record['contact_email'] =$contact_email;
                                $data_record['contact_phone'] =$contact_phone;

                                $where_record=" admin_id= ".$_SESSION['admin_id']." ";
                                $db->query_update("site_setting", $data_record,$where_record);
                                echo '<br>';
                                echo '<div id="msgbox" style="width:40%;">Changes saved successfully</div>';
                                $_SESSION['email_id']=$email_id;
                            }
                        }
                        if($success==0)
                        {
                        $sql_site_setting="SELECT name,email,alternate_email,designation,contact_address,contact_email,contact_phone FROM ".$GLOBALS["pre_db"]."site_setting where admin_id = '".$_SESSION['admin_id']."' ";
                        $row_site_setting=$db->fetch_array($db->query($sql_site_setting));
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
              <tr>
                <td width="20%">Name<span class="orange_font">*</span></td>
                <td width="40%" style="border: 1px  "><input type="text"  class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_site_setting['name'];?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                <td>Email<span class="orange_font">*</span></td>
                <td style="border: 1px  "><input type="text"  class="validate[required,custom[email]] input_text" name="email" id="email" value="<?php if($_POST['save_changes']) echo $_POST['email']; else echo $row_site_setting['email'];?>"/></td>
                <td width="40%"></td> 
              </tr>
              <tr>
                <td>Alternate Email</td>
                <td style="border: 1px  "><input type="text"  class="validate[required,custom[email],ajax[ajaxEmailCallPhp]] input_text" name="alternate_email" value="<?php if($_POST['save_changes']) echo $_POST['alternate_email']; else echo $row_site_setting['alternate_email'];?>" /></td>
                <td width="40%"></td> 
              </tr>
              <tr>
                <td>Designation</td>
                <td style="border: 1px  "><input type="text"  class="input_text" name="designation" value="<?php if($_POST['save_changes']) echo $_POST['designation']; else echo $row_site_setting['designation'];?>" /></td>
                <td width="40%"></td> 
              </tr>
<!--              <tr>
                <td colspan="3" class="line"></td>
              </tr>-->
              <tr>
                <td colspan="3" class="green_head_font">Contact Us Details</td>
              </tr>
              <tr>
                <td valign="top">Address</td>
                <td style="border: 1px "><textarea class="input_textarea" name="contact_address"><?php if($_POST['save_changes']) echo $_POST['contact_address']; else echo $row_site_setting['contact_address'];?></textarea></td>
                <td width="70%" valign="top"></td> 
              </tr>
              <tr>
                <td>Email<span class="orange_font">*</span></td>
                <td style="border: 1px  "><input type="text"  class="validate[required,custom[email],ajax[ajaxEmailCallPhp]] input_text" name="contact_email" id="contact_email" value="<?php if($_POST['save_changes']) echo $_POST['contact_email']; else echo $row_site_setting['contact_email'];?>"/></td>
                <td width="40%"></td> 
              </tr>
              <tr>
                <td>Phone</td>
                <td style="border: 1px  "><input type="text"  class="input_text" id="contact_phone" name="contact_phone" value="<?php if($_POST['save_changes']) echo $_POST['contact_phone']; else echo $row_site_setting['contact_phone'];?>" /></td>
                <td width="40%"></td> 
              </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="SAVE CHANGES" onclick=" return validin();" name="save_changes"  /></td>
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
<div id="footer"><? require("ex_include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>