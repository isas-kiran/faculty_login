<?php include 'inc_classes.php';?>
<?php 
$id=$_POST['id'];

$sel_details="select email, contact_phone from site_setting where admin_id='".$id."'";
$ptr=mysql_query($sel_details);
$data_deatils=mysql_fetch_array($ptr);
echo $data_deatils['contact_phone']."-".$data_deatils['email'];
?>
