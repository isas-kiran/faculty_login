<?php include 'inc_classes.php';
switch ($_POST['ptype']) {
	case pre_balance:
		$select_pre_leave="select * from pr_previous_leave_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$_REQUEST['staff_id']."' ";
		$pre_leave = mysql_query($select_pre_leave);
		echo $total=mysql_num_rows($pre_leave);
	break;
	case leave_mgmt:
		$select_leave="select * from pr_leave_management where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' ";
		$leave = mysql_query($select_leave);
		echo $total=mysql_num_rows($leave);
	break;
	case staff_leave:
		$select_staff_leave="select * from pr_staff_leave_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$_REQUEST['staff_id']."' ";
		$staff_leave = mysql_query($select_staff_leave);
		echo $total=mysql_num_rows($staff_leave);
	break;
	case staff_salary:
		$select_staff_sal="select * from pr_staff_salary_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$_REQUEST['staff_id']."' ";
		$staff_sal= mysql_query($select_staff_sal);
		echo $total=mysql_num_rows($staff_sal);
	break;
	case incentive_calculation:
		$select_staff_sal="select * from pr_incentive_calculation where branch_name='".$_REQUEST['branch_name']."' ";
		$staff_sal= mysql_query($select_staff_sal);
		echo $total=mysql_num_rows($staff_sal);
	break;
	case product_incentive:
		$select_staff_leave="select * from pr_staff_product_incentive where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$_REQUEST['staff']."' ";
		$staff_leave = mysql_query($select_staff_leave);
		echo $total=mysql_num_rows($staff_leave);
	break;
	case service_incentive:
		$select_staff_leave="select * from pr_staff_service_incentive where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$_REQUEST['staff']."' ";
		$staff_leave = mysql_query($select_staff_leave);
		echo $total=mysql_num_rows($staff_leave);
	break;
	case course_incentive:
		$select_staff_leave="select * from pr_staff_course_incentive where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND employee_id='".$_REQUEST['staff']."' ";
		$staff_leave = mysql_query($select_staff_leave);
		echo $total=mysql_num_rows($staff_leave);
	break;
	case imp_attendance:
		$select_att="select * from pr_import_attendance where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' ";
		$att = mysql_query($select_att);
		echo $total=mysql_num_rows($att);
	break;	
} 
?>