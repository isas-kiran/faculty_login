<?php session_start();
 include 'inc_classes.php';
?>
<?
if($_POST['course_id'] && $_POST['course_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	        $course_id = $_POST['course_id'];
	     	$seelct_course=mysql_query("select course_price from courses where course_id='".$_POST['course_id']."'");
			$val_recordss=mysql_fetch_array($seelct_course);
	       echo " Total Fees ".$val_recordss['course_price'];
		   echo '<input type="hidden" name="toals_feess" id="total_prices"  value='.$val_recordss['course_price'].' />';
		 
}
?>