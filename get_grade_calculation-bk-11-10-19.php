<?php include 'inc_classes.php';?>
<?php
$action=$_POST['action'];

if($action=='basic_course')
{
	$course_id=$_POST['course_id'];
	$theory_mark=$_POST['theory_mark'];
	$practical_mark=$_POST['practical_mark'];
	$ids=$_POST['ids'];
	$enroll_id=$_POST['enroll_id'];
	
	$sele_course="select * from weightage_basic_course where course_id='".$course_id."'";
	$ptr_course=mysql_query($sele_course);
	$tot=mysql_num_rows($ptr_course);
	if($tot)
	{
		$data_course=mysql_fetch_array($ptr_course);
		$theory_weightage=$data_course['theory_weightage'];
		$practical_weightage=$data_course['practical_weightage'];
		
		$theory_per=intval($theory_mark * ($theory_weightage/100));
		$practical_per=intval($practical_mark * ($practical_weightage/100));
		$tot_per=intval($theory_per+$practical_per);
		echo $theory_per."##".$practical_per;
		
		$grade='';
		$sel_grade="select * from grade_calculation where 1";
		$ptr_grade=mysql_query($sel_grade);
		while($data_grade=mysql_fetch_array($ptr_grade))
		{
			//echo $data=$data_grade['starting_marks_from'].'<='.$tot_per.'-'.$data_grade['ending_marks_to'].'>='.$tot_per.'###';
			if($data_grade['starting_marks_from']<= $tot_per && $data_grade['ending_marks_to']>= $tot_per)
			{
				$grade=$data_grade['grade'];
			}
		}
		echo "##".$grade;
		
		$sel_grade="select * from action_certificate_grade where enroll_id='".$enroll_id."' and course_id='".$course_id."'";
		$ptr_sel=mysql_query($sel_grade);
		if(mysql_num_rows($ptr_sel))
		{
			$update_grade="UPDATE `action_certificate_grade` set theory_mark='".$theory_mark."',practical_mark='".$practical_mark."',theory_percentage='".$theory_per."',practical_percentage='".$practical_per."',total_percentage='".$tot_per."',grade='".$grade."',cm_id='".$_SESSION['cm_id']."',admin_id='".$_SESSION['admin_id']."',added_date='".date('Y-m-d H:i:s')."' where enroll_id='".$enroll_id."' and course_id='".$course_id."'";
        	$ptr_certificate=mysql_query($update_grade);
		}
		else
		{
			$ins_grade="INSERT INTO `action_certificate_grade`(`enroll_id`, `course_id`,`theory_mark`,`practical_mark`, `theory_percentage`, `practical_percentage`, `total_percentage`,`grade`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$enroll_id."','".$course_id."','".$theory_mark."','".$practical_mark."','".$theory_per."','".$practical_per."','".$tot_per."','".$grade."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
        	$ptr_certificate=mysql_query($ins_grade);
		}
	}
	else
	{
		echo "Please Add this Course Weightage first..!";
	}
}
?>