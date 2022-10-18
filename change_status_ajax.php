<?php include 'inc_classes.php';
$status=$_POST['status'];
$id=$_POST['id'];

if($_POST['type']=='subscriber')
{
	//----------- Update Subscriber Status ----------------------
$update= "UPDATE isas_subscriber_details SET user_status='".$status."' WHERE user_id='".$id."'  ";
$ptr_certificate= mysql_query($update);
echo 1;
}
else {
//----------- Update Campaign Status ----------------------
$update= "UPDATE campaign SET status='".$status."' WHERE campaign_id='".$id."'  ";
$ptr_certificate= mysql_query($update);
echo 1;
}
?>