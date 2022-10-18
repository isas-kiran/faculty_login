<?php include 'inc_classes.php';?>
<?php
$action=$_POST['action'];
$success='';
if($action=='basic_course')
{
	$course_id=$_POST['course_id'];
	$theory_mark=$_POST['theory_mark'];
	$practical_mark=$_POST['practical_mark'];
	$ids=$_POST['ids'];
	$enroll_id=$_POST['enroll_id'];
	$is_print=$_POST['is_print'];
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
			$update_grade="UPDATE `action_certificate_grade` set theory_mark='".$theory_mark."',practical_mark='".$practical_mark."',theory_percentage='".$theory_per."',practical_percentage='".$practical_per."',total_percentage='".$tot_per."',grade='".$grade."',cm_id='".$_SESSION['cm_id']."',admin_id='".$_SESSION['admin_id']."',added_date='".date('Y-m-d H:i:s')."',is_print='".$is_print."' where enroll_id='".$enroll_id."' and course_id='".$course_id."'";
        	$ptr_certificate=mysql_query($update_grade);
			//$success .="Grade Updated Suucessfully";
		}
		else
		{
			$ins_grade="INSERT INTO `action_certificate_grade`(`enroll_id`, `course_id`,`theory_mark`,`practical_mark`, `theory_percentage`, `practical_percentage`, `total_percentage`,`grade`,`is_print`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$enroll_id."','".$course_id."','".$theory_mark."','".$practical_mark."','".$theory_per."','".$practical_per."','".$tot_per."','".$grade."','".$is_print."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
        	$ptr_certificate=mysql_query($ins_grade);
			//$success .="Grade Added Successfully";
		}
	}
	else
	{
		//$success .="Please Add this Course Weightage first..!";
	}
	//echo "##".$success;
}
else if($action=='diploma_course')
{
	$course_id=$_POST['course_id'];
	$ids=$_POST['ids'];
	$enroll_id=$_POST['enroll_id'];
	$is_print=$_POST['is_print'];
	
	$sele_course="select * from weightage_integrated_course where course_id='".$course_id."'";
	$ptr_course=mysql_query($sele_course);
	$tot=mysql_num_rows($ptr_course);
	if($tot)
	{
		$data_course=mysql_fetch_array($ptr_course);
		$basic_weightage=$data_course['basic_weightage'];
		$advance_weightage=$data_course['advance_weightage'];
		
		$sel_grade="select a.*,cm.course_id ,c.course_type from action_certificate_grade a, courses c,courses_map cm where 1 and a.course_id=cm.course_id and a.course_id=c.course_id and a.enroll_id='".$enroll_id."' and cm.course_parent_id='".$course_id."' ";
		$ptr_sel=mysql_query($sel_grade);
		if(mysql_num_rows($ptr_sel))
		{
			$total_diploma_per=0;
			while($data_diploma=mysql_fetch_array($ptr_sel))
			{
				if($data_diploma['course_type']!='')
				{
					if($data_diploma['course_type']=='basic')
					{
						$course_per=intval($data_diploma['total_percentage'] * ($basic_weightage/100));
					}
					else if($data_diploma['course_type']=='advance')
					{
						$course_per=intval($data_diploma['total_percentage'] * ($advance_weightage/100));
					}
					$total_diploma_per +=$course_per;
				}
				else
				{
					$success .="Please Confgure course first as a Basic Course or Advance Course \n";
				}
			} 
		}
		echo $total_diploma_per;
		
		$grade='';
		$sel_dip_grade="select * from grade_calculation where 1";
		$ptr_dip_grade=mysql_query($sel_dip_grade);
		while($data_dip_grade=mysql_fetch_array($ptr_dip_grade))
		{
			//echo $data=$data_grade['starting_marks_from'].'<='.$tot_per.'-'.$data_grade['ending_marks_to'].'>='.$tot_per.'###';
			if($data_dip_grade['starting_marks_from']<= $total_diploma_per && $data_dip_grade['ending_marks_to']>= $total_diploma_per)
			{
				$dip_grade=$data_dip_grade['grade'];
			}
		}
		echo "##".$dip_grade;
		
		$sel_grade="select * from action_certificate_grade where enroll_id='".$enroll_id."' and course_id='".$course_id."'";
		$ptr_sel=mysql_query($sel_grade);
		if(mysql_num_rows($ptr_sel))
		{
			$update_grade="UPDATE `action_certificate_grade` set total_percentage='".$total_diploma_per."',grade='".$dip_grade."',cm_id='".$_SESSION['cm_id']."',admin_id='".$_SESSION['admin_id']."',added_date='".date('Y-m-d H:i:s')."',is_print='".$is_print."' where enroll_id='".$enroll_id."' and course_id='".$course_id."'";
        	$ptr_certificate=mysql_query($update_grade);
			$success .="Grade Updated Successfully";
		}
		else
		{
			$ins_grade="INSERT INTO `action_certificate_grade`(`enroll_id`, `course_id`,`total_percentage`,`grade`,`is_print`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$enroll_id."','".$course_id."','".$total_diploma_per."','".$dip_grade."','".$is_print."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
        	$ptr_certificate=mysql_query($ins_grade);
			
			$success .="Grade added Successfully";
		}
	}
	else
	{
		echo $success .="Please Add this Course Weightage first..! \n";
	}
	echo "##".$success ;
}
?>