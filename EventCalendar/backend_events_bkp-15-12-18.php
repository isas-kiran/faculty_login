<?php
require_once '_db.php';
    
$stmt = $db->prepare('SELECT * FROM customer_service_map WHERE 1 and start_event_time!="" and end_event_time!="" and start_event_time is NOT NULL and end_event_time is NOT NULL order by customer_service_map_id desc ' );///NOT ((end_event_time <= :start_event_time) OR (start_event_time >= :end_event_time))

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
$e->id = $row['customer_service_map_id'];
foreach($result1 as $row1) {
	  $e->text = $row1['cust_name'];
}

/*------------------------------------------------------------------------------------------*/
/* $stmt12 = $db->prepare('SELECT service_id,admin_id FROM customer_service_map WHERE customer_service_id = '.$row['customer_service_id'].' ');
$stmt12->execute();
$result12 = $stmt12->fetchAll();
foreach($result12 as $row12) { */
	
	$stmt123 = $db->prepare('SELECT service_name,service_time FROM servies WHERE service_id = '.$row['service_id'].' ');
	$stmt123->execute();
	$result123 = $stmt123->fetchAll();
	foreach($result123 as $row123) {
		$service_names=$row123['service_name'];
		$service_times=$row123['service_time'];
	 }
	$names='';
	$stmt_cust = $db->prepare('SELECT name FROM site_setting WHERE admin_id = "'.$row['admin_id'].'" ');
	$stmt_cust->execute();
	$result_cust = $stmt_cust->fetchAll();
	foreach($result_cust as $row_cust) {
		$names=$row_cust['name'];
	}
	
	$e->bubbleHtml .= $service_names."       -        ".$service_times." min       -       ".$names."<br/>";
	
 //}
/*-------------------------------------------------------------------------------------------*/
 $e->resource = $row['admin_id'];
  $e->start = $row['start_event_time'];
  $e->end = $row['end_event_time'];
  $events[] = $e;
}

header('Content-Type: application/json;charset=utf-8');
echo json_encode($events);

?>
