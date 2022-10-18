<?php



include 'inc_classes.php';

$action=$_POST['action'];

if($_POST['pcategory_id']!='')

{

	$pcategory_id=$_POST['pcategory_id'];

	$sub_id=$_POST['sub_id'];

	echo '<table style="width: 90%"><tr><td width="21%">Product Sub Category :</td>';

	echo '<td width="70%">';

	echo '<select name="sub_id" style="width:200px;" required>

    	<option value="">Select Category</option>';

		echo $sql_dest = " select sub_name, sub_id from product_subcategory where pcategory_id='".$pcategory_id."' order by sub_id asc";

		$ptr_edes = mysql_query($sql_dest);

		while($data_dist = mysql_fetch_array($ptr_edes))

		{ 

		 echo $sql_dest1 = " select * from product where pcategory_id='".$pcategory_id."' and  sub_id='".$sub_id."'";

		  $ptr_edes1= mysql_query($sql_dest1);

		  $fetch_prodct=mysql_fetch_array($ptr_edes1);

		

				$selecteds = '';

				if($data_dist['sub_id']==$fetch_prodct['sub_id'])

				$selecteds = 'selected="selected"';	

				   

			echo "<option value='".$data_dist['sub_id']."' ".$selecteds.">".$data_dist['sub_name']."</option>";

		}

	echo '</select>

    </td></tr></table>';

}

if($action=="show_service")

{

	$pcategory_id=$_POST['pcategory_id'];

	$sub_id=$_POST['sub_id'];

	echo '<table style="width: 90%"><tr><td width="21%">Service Sub Category :</td>';

	echo '<td width="70%">';

	echo '<select name="sub_id" style="width:200px;" required>

    	<option value="">Select Category</option>';

		$sql_dest = " select sub_name, sub_id from service_subcategory where category_id='".$pcategory_id."' order by sub_id asc";

		$ptr_edes = mysql_query($sql_dest);

		while($data_dist = mysql_fetch_array($ptr_edes))

		{ 

		 $sql_dest1 = " select * from servies where service_category_id='".$pcategory_id."' and  subcategory_id='".$sub_id."'";

		  $ptr_edes1= mysql_query($sql_dest1);

		  $fetch_prodct=mysql_fetch_array($ptr_edes1);

		

				$selecteds = '';

				if($data_dist['sub_id']==$fetch_prodct['subcategory_id'])

				$selecteds = 'selected="selected"';	

				   

			echo "<option value='".$data_dist['sub_id']."' ".$selecteds.">".$data_dist['sub_name']."</option>";

		}

	echo '</select>

    </td></tr></table>';

}

?>