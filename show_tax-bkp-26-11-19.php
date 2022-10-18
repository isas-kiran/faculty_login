<?php session_start();
 include 'inc_classes.php';
?>
<?
if($_POST['branch_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	        $branch_id = $_POST['branch_id'];
	     	$sel_tax="select service_tax,installment_course_percentage,cgst,sgst from general_settings where branch_name ='".$branch_id."' order by setting_id desc";
			$ptr_tax=mysql_query($sel_tax);
			$data_tax=mysql_fetch_array($ptr_tax);
			echo $data_tax['service_tax']."-".$data_tax['installment_course_percentage']."-".$data_tax['cgst']."-".$data_tax['sgst'];
		 
}
?>