<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
$select_exc = "select added_date,customer_service_id from customer_service where 1 and customer_service_id > 3826 order by customer_service_id asc  ";
$ptr_fs = mysql_query($select_exc);
while($data_service=mysql_fetch_array($ptr_fs))
{
echo "<br/>".$update_service="update customer_service_map set added_date='".$data_service['added_date']."' where customer_service_id='".$data_service['customer_service_id']."' ";
$ptr_update=mysql_query($update_service);
}
?>
