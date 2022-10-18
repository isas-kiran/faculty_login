<?php
$dbServerName = "lms.isasbeautyschool.co.in";
$dbUsername = "i6027013_wp2";
$dbPassword = "L.0QMmpqIjt5VpCispT73";
$dbName = "i6027013_wp2";

// create connection
$conn = mysql_connect($dbServerName ,$dbUsername, $dbPassword);
mysql_select_db($dbName,$conn );   
// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
echo "Connected successfully";

$sele_det="SELECT * FROM `wp_users` WHERE 1";
$ptr_sl=mysql_query($sele_det);
$data_sl=mysql_fetch_array($ptr_sl);
echo $data_sl['user_nicename'];
?>