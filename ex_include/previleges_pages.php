<?php
if($_SESSION['type']=='A' )
{

$array_prev = $_SESSION['privilege_id'];
$array_pages = array();
$r=0;
for($e=0;$e<count($array_prev);$e++)
{
    //echo  $array_prev[$e]['privilege_id'];
     $array_pages[count($array_pages)]['page']='index.php';
     $array_pages[count($array_pages)]['page']='login.php';
	 
     if($array_prev[$e]['privilege_id']==1) //'manage_password'
    {
        $array_pages[count($array_pages)]['page']='#';
        $array_pages[count($array_pages)]['page']='#';
    }
     if($array_prev[$e]['privilege_id']==2) // manage_account
    {
	 $array_pages[count($array_pages)]['page']='admin_account_details.php';
	 $array_pages[count($array_pages)]['page']='admin_edit_details.php';
	 $array_pages[count($array_pages)]['page']='admin_change_username.php';
	 $array_pages[count($array_pages)]['page']='admin_change_password.php';
	 $array_pages[count($array_pages)]['page']='edit_delete_admin.php';
	 $array_pages[count($array_pages)]['page']='add_sub_admin.php';
	 $array_pages[count($array_pages)]['page']='manage_staff.php';
	 $array_pages[count($array_pages)]['page']='staff_regi.php';
       
    }
     if($array_prev[$e]['privilege_id']==3) // 'manage_student'
    {
        $array_pages[count($array_pages)]['page']='manage_student_class.php';
        $array_pages[count($array_pages)]['page']='student_register_form.php';
        $array_pages[count($array_pages)]['page']='manage_student_class.php';
        $array_pages[count($array_pages)]['page']='edit_student_class.php';
    }
     if($array_prev[$e]['privilege_id']==4)//'manage_exam'
    {
        $array_pages[count($array_pages)]['page']='manage_exam.php';
        $array_pages[count($array_pages)]['page']='edit_exam.php';
		$array_pages[count($array_pages)]['page']='add_exam.php';
		
		 $array_pages[count($array_pages)]['page']='manage_paper.php';
        $array_pages[count($array_pages)]['page']='edit_paper.php';
		 $array_pages[count($array_pages)]['page']='create_paper.php';
		 
        $array_pages[count($array_pages)]['page']='manage_question.php';
		 $array_pages[count($array_pages)]['page']='edit_question.php';
        $array_pages[count($array_pages)]['page']='create_question.php';
		
		 $array_pages[count($array_pages)]['page']='manage_take.php';
        $array_pages[count($array_pages)]['page']='take_exam.php';
    }
     if($array_prev[$e]['privilege_id']==5) // 'manage_staff'
    {

        $array_pages[count($array_pages)]['page']='manage_staff.php';
        $array_pages[count($array_pages)]['page']='staff_regi.php';
          }
     if($array_prev[$e]['privilege_id']==6)//'manage_menu'
    {

        $array_pages[count($array_pages)]['page']='menu-manages.php';
        $array_pages[count($array_pages)]['page']='menu-to-do.php';
    }
	 if($array_prev[$e]['privilege_id']==7)//'manage_pages'
    {

        $array_pages[count($array_pages)]['page']='page-manages.php';
        $array_pages[count($array_pages)]['page']='page-to-do.php';
    }
	 if($array_prev[$e]['privilege_id']==8)//'manage_inquiry'
    {

        $array_pages[count($array_pages)]['page']='#';
    }
	 if($array_prev[$e]['privilege_id']==9)//'manage_contact'
    {

        $array_pages[count($array_pages)]['page']='manage_contact.php';
    }
	 if($array_prev[$e]['privilege_id']==10)//'manage_class'
    {

        $array_pages[count($array_pages)]['page']='manage_class.php';
        $array_pages[count($array_pages)]['page']='add_subject_details.php';
		$array_pages[count($array_pages)]['page']='edit_class.php';
        $array_pages[count($array_pages)]['page']='manage_subject.php';
	    $array_pages[count($array_pages)]['page']='edit_subject.php';
        $array_pages[count($array_pages)]['page']='add_subject.php';
		$array_pages[count($array_pages)]['page']='add_class.php';
    }
	 if($array_prev[$e]['privilege_id']==11)//'manage_course'
    {

        $array_pages[count($array_pages)]['page']='course-manages.php';
        $array_pages[count($array_pages)]['page']='add_course.php';
    }
}
$total_page_counters =  count($array_pages);
$page_name= basename($_SERVER['PHP_SELF']);
$founds='No';
for($d=0;$d<$total_page_counters;$d++)
{
    if($page_name==$array_pages[$d]['page'])
    {
        $founds='Yes';
        break;
    }
}
if($founds=='No')
{
    echo 'Restricted area';
    ?>
<script language="javascript">
    document.location.href='index.php?msg=Restricted area';
    </script>
    <?php
    exit();
}

}
?>