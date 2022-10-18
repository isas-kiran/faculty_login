<?php include 'inc_classes.php';
//print_r($_SESSION['privilege_id']);
//echo "<br/>".print_r(($_SESSION['privilege_id_parent']));
//echo "<br/>".print_r(($_SESSION['privilege_id']));
//echo "<br/>".print_r(($_SESSION['privilege_id'][0]));
?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Home</title>

<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<?php include "include/header.php"; ?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<? 

//echo $_SESSION['type'];
include "dashboard1.php";?>
<!--right end-->
</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer">
<?php include "include/footer.php";?>
</div>

<!--footer end-->
</body>
</html>
<!--===============================Tooltip=================-->
<script>

</script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jboxcdn.com/0.3.2/jBox.min.js"></script>
<link href="http://code.jboxcdn.com/0.3.2/jBox.css" rel="stylesheet">
<script>
jQuery.noConflict();
(function( $ ) {
  $(function() {
$(document).ready(function() {
    $('.tooltip').jBox('Tooltip');
});
 });
})(jQuery);
</script>
<!--================================END tooltip============-->