<?php include("../include/config.php");?>
<?php

$start=trim(str_replace("T"," ",$_POST['newStart']));
$end=trim(str_replace("T"," ",$_POST['newEnd']));
$resource=trim(str_replace("T"," ",$_POST['newResource']));

$insert = "UPDATE customer_service_map SET start_event_time ='".$start."',end_event_time ='".$end."',admin_id='".$resource."'  WHERE customer_service_map_id = '".$_POST['id']."'";
$ptr_ins=mysql_query($insert);
/*require_once '_db.php';

$insert = "UPDATE customer_service SET start = :start, end = :end WHERE customer_service_id = :customer_service_id";

$stmt = $db->prepare($insert);

$stmt->bindParam(':start', $_POST['newStart']);
$stmt->bindParam(':end', $_POST['newEnd']);
$stmt->bindParam(':customer_service_id', $_POST['id']);

$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Update successful';

header('Content-Type: application/json');
echo json_encode($response);

*/?>
