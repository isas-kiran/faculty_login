<?php

//$db_exists = file_exists("daypilot.sqlite");
if($_SERVER['HTTP_HOST']=="localhost" || $_SERVER['HTTP_HOST']=="192.168.2.105")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
{
$host 			= "localhost";
$dbuid			= "root";
$dbpwd 			= "";
$dbname			= "isasbeautyschool";

$db = new PDO("mysql:host=$host;dbname=isasbeautyschool", $dbuid, $dbpwd);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
else
{
$host 			= "localhost";
$dbuid			= "isasadmin";
$dbpwd 			= "isasadmin007";
$dbname			= "isasbeautyschool_org";


$db = new PDO("mysql:host=localhost;dbname=isasbeautyschool_org", $dbuid, $dbpwd);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  

/*$servername = "localhost";
$username = "root";
$password = "";
$db = new PDO("mysql:host=$servername;dbname=isasbeautyschool", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); */
//if (!$db_exists) {
    //create the database
    $db->exec("CREATE TABLE IF NOT EXISTS events (
                        id INTEGER PRIMARY KEY, 
                        name TEXT, 
                        start DATETIME, 
                        end DATETIME,
                        resource VARCHAR(30))");

    /*$messages = array(
                    array('name' => 'Event 1',
                        'start' => '2013-05-09T00:00:00',
                        'end' => '2013-05-09T10:00:00',
                        'resource' => 'B')
                );*/

    $insert = "INSERT INTO events (name, start, end, resource) VALUES (:name, :start, :end, :resource)";
    $stmt = $db->prepare($insert);
 	
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->bindParam(':resource', $resource);
 
    /*foreach ($messages as $m) {
      $name = $m['name'];
      $start = $m['start'];
      $end = $m['end'];
      $resource = $m['resource'];
      $stmt->execute();
    }*/
    
//}

?>
