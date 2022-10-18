<?php session_start();
 include 'inc_classes.php';
?>
<?php
if($_POST['branch_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	        $branch_id = $_POST['branch_id'];
			
			
	     	$sel_tax="select travelling_allowance,dearness_allowance,house_rent_allowance,branch_name from sallery_deduction where branch_name ='".$branch_id."' ";
			$ptr_tax=mysql_query($sel_tax);
			$data_tax=mysql_fetch_array($ptr_tax);
			
			echo $data_tax['travelling_allowance']."-".$data_tax['dearness_allowance']."-".$data_tax['house_rent_allowance'];
		 
}
?>