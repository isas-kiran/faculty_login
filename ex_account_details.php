<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>My Account</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
</head>
<body>
<?php include "ex_include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "ex_include/menuLeft.php";?>
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
	<table border="0" cellspacing="15" cellpadding="0">
            <?php
                $sql_site_setting="SELECT name,email,alternate_email,designation,contact_address,contact_email,contact_phone FROM ".$GLOBALS["pre_db"]."site_setting where admin_id = '".$_SESSION['admin_id']."' ";
                $row_site_setting=$db->fetch_array($db->query($sql_site_setting));
            ?>
                  <tr>
                    <td class="form_title">Name</td>
                    <td>:</td>
                    <td><?php echo $row_site_setting['name'];?></td>
                  </tr>
                   <tr>
                    <td class="form_title">Email</td>
                    <td>:</td>
                    <td><?php echo $row_site_setting['email'];?></td>
                  </tr>
                   <tr>
                    <td class="form_title">Alternate Email</td>
                    <td>:</td>
                    <td><?php echo $row_site_setting['alternate_email'];?></td>
                  </tr>
                  <tr>
                    <td class="form_title">Designation</td>
                    <td>:</td>
                    <td><?php echo $row_site_setting['designation'];?></td>
                  </tr>
            <tr><td colspan="3" style="color:#7CA32F;">Contact Us Details</td></tr>
                  <tr>
                    <td class="form_title">Address</td>
                    <td>:</td>
                    <td><?php echo $row_site_setting['contact_address'];?></td>
                  </tr>
                  <tr>
                    <td class="form_title">Email</td>
                    <td>:</td>
                    <td><?php echo $row_site_setting['contact_email'];?></td>
                  </tr>
                  <tr>
                    <td class="form_title">Phone</td>
                    <td>:</td>
                    <td><?php echo $row_site_setting['contact_phone'];?></td>
                  </tr>
</table>

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
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer">
<? require("ex_include/footer.php");?>
</div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>
