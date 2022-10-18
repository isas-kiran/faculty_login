<?php
require_once '_db.php';
    
$stmt = $db->prepare('SELECT * FROM customer_service WHERE NOT ((end_event_time <= :start_event_time) OR (start_event_time >= :end_event_time)) order by customer_service_id desc ' );

$stmt->bindParam(':start_event_time', $_POST['start']);
$stmt->bindParam(':end_event_time', $_POST['end']);

$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
$events = array();

foreach($result as $row) {
  $e = new Event();
  
$stmt1 = $db->prepare('SELECT cust_name FROM customer WHERE cust_id = '.$row['customer_id'].' ');
$stmt1->execute();
$result1 = $stmt1->fetchAll();

 $e->id = $row['customer_service_id'];
 foreach($result1 as $row1) {
	  $e->text = $row1['cust_name'];
 }
 
 $e->resource = $row['staff_id_event'];
  $e->start = $row['start_event_time'];
  $e->end = $row['end_event_time'];
  $events[] = $e;
}

header('Content-Type: application/json');
echo json_encode($events);

?>
