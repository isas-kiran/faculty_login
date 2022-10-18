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
        $array_pages[count($array_pages)]['page']='account_change_password.php';
        $array_pages[count($array_pages)]['page']='account_change_username.php';
    }
     if($array_prev[$e]['privilege_id']==2) // manage_account
    {
	 $array_pages[count($array_pages)]['page']='course_manage.php';
	 $array_pages[count($array_pages)]['page']='add_course.php';
	 $array_pages[count($array_pages)]['page']='course_category.php';
	 $array_pages[count($array_pages)]['page']='add_course_category.php';
    }
     if($array_prev[$e]['privilege_id']==3) // 'manage_subject'
    {
        $array_pages[count($array_pages)]['page']='subject_manage.php';
        $array_pages[count($array_pages)]['page']='subject_add.php';
    }
     if($array_prev[$e]['privilege_id']==4)//'manage_staff'
    {
        $array_pages[count($array_pages)]['page']='staff_manage.php';
		$array_pages[count($array_pages)]['page']='staff_registration.php';
    }
     if($array_prev[$e]['privilege_id']==5) // 'manage_student'
    {
        $array_pages[count($array_pages)]['page']='manage_student.php';
          }
     if($array_prev[$e]['privilege_id']==6)//'manage_subadmin'
    {

        $array_pages[count($array_pages)]['page']='manage_subadmin.php';
        $array_pages[count($array_pages)]['page']='add_subadmin.php';
    }
	 if($array_prev[$e]['privilege_id']==7)//'manage_download'
    {

        $array_pages[count($array_pages)]['page']='manage_download.php';
        $array_pages[count($array_pages)]['page']='add_download.php';
    }
	 if($array_prev[$e]['privilege_id']==8)//'manage_quation'
    {

        $array_pages[count($array_pages)]['page']='manage_question.php';
		 $array_pages[count($array_pages)]['page']='create_question.php';
    }
	 if($array_prev[$e]['privilege_id']==9)//'manage_exam'
    {

        $array_pages[count($array_pages)]['page']='manage_exam.php';
		  $array_pages[count($array_pages)]['page']='add_exam.php';
    }
	 if($array_prev[$e]['privilege_id']==10)//'manage_quation paper'
    {

        $array_pages[count($array_pages)]['page']='manage_paper.php';
        $array_pages[count($array_pages)]['page']='create_paper.php';
    }
	 if($array_prev[$e]['privilege_id']==11)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_admition.php';
        $array_pages[count($array_pages)]['page']='add_admition.php';
    }
	
	 if($array_prev[$e]['privilege_id']==12)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_photo.php';
        $array_pages[count($array_pages)]['page']='add_gallery.php';
		$array_pages[count($array_pages)]['page']='add-images-in-gallery.php';
    }
	 if($array_prev[$e]['privilege_id']==13)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_vedio_gallery.php';
        $array_pages[count($array_pages)]['page']='add_vedio_gallery.php';
		$array_pages[count($array_pages)]['page']='add-videos-in-gallery.php';
    }
	 if($array_prev[$e]['privilege_id']==14)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_menu.php';
        $array_pages[count($array_pages)]['page']='add_menu.php';
    }
	 if($array_prev[$e]['privilege_id']==15)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_pages.php';
        $array_pages[count($array_pages)]['page']='add_pages.php';
    }
	 if($array_prev[$e]['privilege_id']==16)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_slider.php';
        $array_pages[count($array_pages)]['page']='add_slider.php';
		 $array_pages[count($array_pages)]['page']='add_image_slider.php';
    }
	 if($array_prev[$e]['privilege_id']==16)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_testimonial.php';
    }
	 if($array_prev[$e]['privilege_id']==17)//'manage take admition'
    {

        $array_pages[count($array_pages)]['page']='manage_notice.php';
        $array_pages[count($array_pages)]['page']='add_notice.php';
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