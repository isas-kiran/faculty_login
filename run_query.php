<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
<meta content="utf-8" http-equiv="encoding"  />
<title>Manage Student</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>


<?php
echo "<br/>".$up_query="select DISTINCT(student_id) from followup_details where student_id > 19000 and student_id < 19500 order by followup_id desc ";
$ptr_query=mysql_query($up_query);
while($data_query=mysql_fetch_array($ptr_query))
{
	echo "<br/>".$data_query['student_id'];
	
	$up_follow ="select * from followup_details where student_id ='".$data_query['student_id']."' order by followup_id desc limit 0,1 ";
	$ptr_foll_query = mysql_query($up_follow);
	$data_follo= mysql_fetch_array($ptr_foll_query);
	
	echo "<br/>".$update="UPDATE inquiry set response='".$data_follo['response']."',followup_date='".$data_follo['followup_date']."',followup_details='".addslashes($data_follo['followup_details'])."', lead_category_followup='".$data_follo['lead_category_followup']."',response_reason='".$data_follo['response_reason']."',lead_grade='".$data_follo['lead_grade']."' where inquiry_id = '".$data_query['student_id']."' ";
	$ptr_my_query=mysql_query($update);
}
?>