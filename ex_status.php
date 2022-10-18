<?php header('Content-Type: text/html; charset=ISO-8859-15'); ?>
<?php  include 'ex_inc_classes.php';

$id=$_POST['id'];
$status=$_POST['status'];

$sql="UPDATE `ex_student_exam_registration` SET `status`='".$status."' WHERE `id` = '".$id."' ";
$sql1 = mysql_query($sql);
echo $sql1;



?>