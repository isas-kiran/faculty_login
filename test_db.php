<?php
$host = "localhost";
$dbuid = "isasadmin";
$dbpwd = "isasadmin007";
$dbname = "isasbeautyschool_org";

/*$con1 = mysql_connect($host ,$dbuid, $dbpwd);
mysql_select_db($dbname,$con1 ); 

$selec_db="select name,username, pass from site_setting where admin_id='2'";
$ptr_db=mysql_query($con1,$selec_db);
$data_db=mysql_fetch_array($ptr_db);

"<br/>".$data_db['username'].'-'.$data_db['pass'];*/
//=======================================================

$host1 = "localhost";
$dbuid1	= "isasllp";
$dbpwd1 = "isasllp!@!2021";
$dbname1 = "isas.llp";

/*$con2 = mysql_connect($host1 ,$dbuid1, $dbpwd1);
mysql_select_db($dbname1,$con2 ); 

$selec_db1="select name,username, pass from site_setting where admin_id='1'";
$ptr_d1b=mysql_query($con2,$selec_db1);
$data_db1=mysql_fetch_array($ptr_db1);

"<br/>".$data_db1['username'].'-'.$data_db1['pass'];*/
////////////////////////////////////////////////
?>
<?php
// PHP program to connect multiple MySQL database
// into single webpage
 
// Connection of first database
// Database name => database1
// Default username of localhost => root
// Default password of localhost is '' (none)


/*$dblink = mysql_connect("somehost", "someuser", "password");
mysql_select_db("BlogPosts",$dblink);
$qry = mysql_query($sql_statement,$dblink);
*/

$link1 = mysql_connect($host ,$dbuid, $dbpwd);
mysql_select_db($dbname,$link1);
// Check for connection
if($link1 == true) {
    echo "database1 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
 
echo "<br>";


$selec_db1="select name,username, pass from site_setting where admin_id='69'";
$res = mysql_query($selec_db1,$link1);
 
$row = mysql_fetch_array($res);
echo "1 -".$row['username'] .' - '. $row['pass']."<br>";
// Connection of first database
// Database name => database1
//===========================================================
$link2 = mysql_connect($host1 ,$dbuid1, $dbpwd1);
 mysql_select_db($dbname1,$link2);
 
// Check for connection
if($link2 == true) {
    echo "<br/>database2 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysql_error());
}
// Connection of databases
//$link = mysqli_connect('localhost', 'root', '');
 
// Display the list of all database name


$selec_db2="select name,username, pass from site_setting where admin_id='1'";
$res2 = mysql_query($selec_db2,$link2);
 
$row2 = mysql_fetch_array($res2);
echo "<br/>2 -".$row2['username'] .' - '. $row2['pass']."<br>";


/*while( $row = mysqli_fetch_assoc($res) ) {
    echo $row['Database'] . "<br>";
}
*/?>


