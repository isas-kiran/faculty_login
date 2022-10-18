<?php
include 'inc_classes.php';
$action=$_POST['action'];
$branch_name=$_POST['branch_name'];
if($action=='get_kit_course')
{
	$sel_cm="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
	$ptr_cm=mysql_query($sel_cm);
	$data_cm=mysql_fetch_array($ptr_cm);
	
	echo'<select name="course_id" id="course_id" class="input_select" style="width:200px;">';
	echo'<option value="">Select Course Name</option>';
	$course_category="select category_name,category_id from course_category ";
	$ptr_course_cat=mysql_query($course_category);
	while($data_cat=mysql_fetch_array($ptr_course_cat))
	{
		echo "<optgroup label='".$data_cat['category_name']."'>";
		$get="SELECT c.course_id,c.course_name FROM courses c, product_kit k where c.course_id=k.course_id and c.category_id='".$data_cat['category_id']."' and k.cm_id='".$data_cm['cm_id']."' order by c.course_id";
		$myQuery=mysql_query($get);
		while($row = mysql_fetch_assoc($myQuery))
		{
			$selected_course='';
			if($row_record['course_id']==$row['course_id'])
			{
				$selected_course='selected="selected"';
			}
			?> 
			<option <?php echo $selected_course; ?> value="<?php echo $row['course_id']?>" <?php if (isset($course_interested) && $course_interested == $row['course_name']) echo "selected";?>> <?php echo $row['course_name'] ?></option>
			<?php 
		}
		echo " </optgroup>";
	}
	echo '</select>';
}
?>