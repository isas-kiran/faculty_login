<?php include 'inc_classes.php';?>
<?php
$batch_id=$_POST['batch_id'];
$action=$_POST['action'];
if($action=="stud_report")
{
	
	$sel_name="select enroll_id FROM student_course_batch_map WHERE 1 and batch_id='".$batch_id."' ";
    $ptr=mysql_query($sel_name);
    
	?>

	<?php
	while($fetch_name=mysql_fetch_array($ptr))
	{
        $n = "select enroll_id,name FROM enrollment WHERE 1 and enroll_id='".$fetch_name['enroll_id']."' ";
        $nm = mysql_query($n);
        while($fetch=mysql_fetch_array($nm))
	{
	    	$sel='';
	    if($fetch_name['enroll_id']==$fetch['enroll_id'])
		{
			$sel='selected="selected"';
		}
		?>
        <option value=""> Select student</option>
		<option value ="<?php echo $fetch['enroll_id'] ?>" > <?php echo $fetch['name'] ?> </option>
		<?php
    }
	}

}

?>