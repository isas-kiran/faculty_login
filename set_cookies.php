<?php 
include 'inc_classes.php';
$action = $_POST['action'];
if($action=='cookies')
{
	$user_id=$_POST['user_id'];
	$username=$_POST['username'];
	
	$cookie_name = 'isas_user_'.$username;
	$cookie_value = $username;
	setcookie($cookie_name, $cookie_value, time() + (86400 * 4000), "/"); // 86400 = 1 day
	
	//echo "Value is: " . $_COOKIE[$username];
	
	$update_query="update site_setting set cookies='set' where admin_id='".$user_id."' ";
	$ptr_update=mysql_query($update_query);
	
}
?>		  