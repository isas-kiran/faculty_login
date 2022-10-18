<?php include 'ex_inc_classes.php';

?>
<?php include "ex_admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Home</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include "ex_include/header.php"; ?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "ex_include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<? 
//echo $_SESSION['type'];
include "ex_dashboard.php";?>
<!--right end-->
</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer">
<?php include "ex_include/footer.php";?>
</div>
<!--footer end-->
</body>
</html>
