<?php include("../../include/config.php");?>
<?php
$start=trim(str_replace("T"," ",$_POST['newStart']));
$end=trim(str_replace("T"," ",$_POST['newEnd']));
echo $insert = "UPDATE customer_service SET start_event_time ='".$start."',end_event_time ='".$end."' WHERE customer_service_id = '".$_POST['id']."'";
$ptr_ins=mysql_query($insert);

echo "ok";
/*require_once '_db.php';

$insert = "UPDATE customer_service SET start = :start, end = :end WHERE customer_service_id = :customer_service_id";

$stmt = $db->prepare($insert);

$stmt->bindParam(':start', $_POST['newStart']);
$stmt->bindParam(':end', $_POST['newEnd']);
$stmt->bindParam(':customer_service_id', $_POST['id']);

$stmt->execute();

class Result {}

$response = new Result();
$response->result = $_POST['id'];
$response->message = 'Update successful';

header('Content-Type: application/json');
echo json_encode($response);*/

?>
