<?php include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome on <?php echo $GLOBALS['domainName'];?></title>
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
<div id="login">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid">
        <table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
           
            <tr>
                <td class="green_head_font" width="30%">Forgot Password?</td>
<!--                <td class="rightAlign">
                    <select class="input_select_login">
					<option>1</option>
					<option>1</option>
					</select>	
                </td>	-->
              </tr>
        </table>
    </td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <?php
                        $success=0;
                        if(isset($_POST['submit']))
                        {
                            echo '<table width="95%" align="center" cellpadding="5">
                            <tr><td style="padding-left: 15px;">';
                            $errors=array(); $i=0;
                            $email=$_POST['email'];

                            if($email=="")
                            {
                                $success=0;
                                $errors[$i++]="Enter registered E-mail";
                            }
                            if($email)
                            {
                                $sql_user="select username,pass from ".$GLOBALS["pre_db"]."site_setting where email='".$email."'";
                                if(!mysql_num_rows($db->query($sql_user)))
                                {
                                    $success=0;
                                    $errors[$i++]="There is no user registered with this email address";
                                }
                            }
                            if(count($errors))
                            {
                                ?>
                                <table align="center" width="100%" style="text-align:left;" class="alert1">
                                <tr><td><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                                <?php
                            }
                            else
                            {
                                $sql_user= "SELECT username,pass FROM ".$GLOBALS["pre_db"]."site_setting where email='".$email."'";
                                //echo $sql_user;
                                $row_user=$db->fetch_array($db->query($sql_user));

                                $success=1;
                                $message_digest=$box_message_top;
                                $message_digest.="
                                <table width='100%' align='left' border='0' cellspadding='4'>
                                        <tr><td colspan='2' align='left'>You requested a password.</td></tr>
                                        <tr><td colspan='2' align='left'>Please use the following details to login</td></tr>
                                        <tr><td height='5'></td></tr>
                                        <tr><td width='15%' align='left'><b>Username</b></td>
                                                <td width='85%' align='left'>".$row_user['username']."<br></td>
                                        </tr>
                                        <tr><td align='left'><b>Password</b></td>
                                                <td align='left'><font color='#FF0000'>".$row_user['pass']."</font><br></td>
                                        </tr>
                                        <tr><td height='5'></td></tr>
                                        <tr><td colspan='2' align='left'>Thanks,<br>Support Team<br><strong>".$siteUrlName."</strong>
                                                </td>
                                        </tr>
                                </table>";
                                $message_digest.=$box_message_bottom;
                                //echo $message_digest;
                                $to=$email;
                                $subject="Your username and password on ".$domainName;
                                $from="<support@parallelbranch.in>";
                                $header="From: $from\nContent-Type: text/html; charset=iso-8859-1";
                                $sentmail = mail($to,$subject,$message_digest,$header);
                                echo '<center><br><div id="msgbox" style="width:100%">Your username &  password have been sent to your email address<br>(If not received please check your spam folder)</div>
                                    <br><br><input type="button" name="continue" value="Continue" onclick="window.location.href=\'login.php\'" class="inputButton"></center>';
                            }
                            echo '</td></tr></table>';
                        }
                        if($success==0)
                        {?>
        <br clear="all">
                        <form method="post" id="jqueryForm">
                            <table cellpadding="5" cellspacing="5" align="center" width="90%">
                            <tr><td>Enter your registered E-mail</td></tr>
                            <tr><td><input type="text" class="validate[required] input_text_login" name="email" id="email" value="<?php echo $_POST['email'];?>" /></td></tr>
                            <tr>
                                <td colspan="0" align="left">
                                    <input type="submit" name="submit" id="submit" class="input_btn" value="Submit"/>&nbsp;
                                    <input type="button" name="cancel" class="input_btn" value="Cancel" onclick="window.location.href='index.php'"/>
                                </td>
                            </tr>
                            </table>
                        </form>
            <?php
                        }?>
	</td>
    <td class="mid_right"></td>
  </tr>
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>

</div>
<div id="footer"><?php include "include/footer.php";?></div>
</body>
</html>
