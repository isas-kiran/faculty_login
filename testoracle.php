<?php  $conn = oci_connect('rsdba', 'rsdba', '(DESCRIPTION =
(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 182.75.120.230)(PORT = 1521)))
(CONNECT_DATA ==(SERVICE_NAME=ISEO_DB) (SID = ISEO_DB)))'); 
//$conn = oci_connect('rsdba', 'rsdba', '182.75.120.230');
   if (!$conn) {
$m = oci_error();
echo $m['message'], "\n";
exit; } else {
print "Connected to Oracle!"; } oci_close($conn); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>