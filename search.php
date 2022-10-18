<?php include 'inc_classes.php';?>
<?php
		//if (isset($_GET['term'])){
    	$return_arr = array();
		$sel_vendor="select * from vendor";
		$ptr_vendor=mysql_query($sel_vendor);
		while($row=mysql_fetch_array($ptr_vendor))
		{
			 $return_arr[] =  $row['name'];
		}
		//}
		return $return_arr;
?>
               