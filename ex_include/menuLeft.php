<?php  $page_name= basename($_SERVER['PHP_SELF']);

    $activeDone="";
    $page_name= basename($_SERVER['PHP_SELF']); 
    
    $homeClass='ui-state-default';
    if ($page_name =='ex_index.php')
    {
        $activeDone=0;
        $homeClass='ui-state-active';
    }
    $myAccountClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'ex_account_details.php' || $page_name == 'ex_account_edit_details.php' || 
	$page_name == 'ex_account_change_username.php' || $page_name == 'ex_account_change_password.php' || $page_name=='ex_wel_comecont.php'
	|| $page_name == 'ex_wel_comecont.php' || $page_name=='ex_wish_image.php'))
    {
        $activeDone=1;
        $myAccountClass='ui-state-active';
    }
	
    $syllabusClass='ui-state-default';    
    if($activeDone=="" && ($page_name == 'ex_manage_language.php' || $page_name == 'ex_add_language.php' ||  $page_name =='ex_manage_syllabus.php' || $page_name =='ex_add_syllabus.php' || $page_name == 'ex_manage_grade.php' ||$page_name =='ex_add_grade.php' ||  $page_name == 'ex_manage_unit.php' || $page_name == 'ex_add_unit.php' || $page_name == 'ex_tab.php' || $page_name == 'ex_manage_tab.php' ))
    {
        $activeDone=2;
        $syllabusClass='ui-state-active';
    }
	 
	
	$examsClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'ex_live_student.php'  || $page_name == 'ex_add_mcq_paper.php' || $page_name == 'ex_manage_mcq_paper.php'   || $page_name == 'ex_manage_exam.php' || $page_name == 'ex_manage_question.php' || $page_name == 'ex_add_questions.php' || $page_name == 'ex_manage_paper.php' || $page_name == 'ex_create_paper.php' || $page_name == 'ex_edit_disclaimer.php'  || $page_name == 'ex_intrupted_student.php'|| $page_name == 'ex_add_exams.php'|| $page_name == 'ex_manage_exams.php' || $page_name == 'ex_restarted_exam.php' || $page_name == 'ex_stopped_student.php' || $page_name == 'ex_show_exams_student.php' || $page_name == 'ex_add_exams_student.php'))
    {
        $activeDone=3;
        $examsClass='ui-state-active';
    }
	 $userClass='ui-state-default';
	if($activeDone=="" && ($page_name == 'ex_manage_user.php'  || $page_name == 'ex_add_user.php' ))
    {
        $activeDone=4;
        $userClass='ui-state-active';
    } 
	
	 /*$schoolClass='ui-state-default'; 
    if($activeDone=="" && ($page_name == 'manage_school.php' || $page_name == 'add_school.php'  || $page_name == 'manage_student.php'   ||$page_name == 'add_student.php' || $page_name == 'manage_examiner.php'  || $page_name == 'add_examiner.php' 	))
    {
        $activeDone=5;
        $schoolClass='ui-state-active';
    }*/
	
	$reportClass='ui-state-default'; 
    if($activeDone=="" && ($page_name == 'ex_exam_report.php' || $page_name == 'ex_student_report.php' || $page_name == 'ex_stud_report.php' || $page_name == 'ex_disclaimer_report.php' ))
    {
        $activeDone=5;
        $reportClass='ui-state-active';
    }

    $privilagesClass='ui-state-default'; 
    if($activeDone=="" && ($page_name == 'ex_add_privilages.php' ||$page_name == 'ex_privilages_manage.php'))
    {
        $activeDone=6;
        $adminReportClass='ui-state-active';
    }
    
   
	$adminReportClass='ui-state-default'; 
    if($activeDone=="" && ($page_name == 'ex_audit_report.php'))
    {
        $activeDone=7;
        $adminReportClass='ui-state-active';
    }

   
	
?>
<script type="text/javascript">
    jQuery(document).ready( function() 
        {       
            $("#accordion").accordion({ active:<?php echo $activeDone;?>, header: "h3", autoHeight: false, collapsible: true });        
        });
</script>



<div id="left_info">

 <?php if($_SESSION['type'] =='S'){?>
<div id="accordion" style="padding-bottom:15px; padding-left:15px; padding-top:15px; width:91%;">

    <div>
        <h3 class="<?php echo $homeClass;?>" >
            <a  href="javascript:void(0);">
                <table border="0" cellspacing="0" cellpadding="0" >
                    <tr><td><img src="images/home_icon2.png" /></td><td class="width5"></td><td onClick="location.href='index.php'">Home</td></tr>
                </table>
            </a>
        </h3>
    </div>
    
    <!-- <div>
        <h3 class="<?php echo $myAccountClass;?>" ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/man_acc_icon.png" /></td><td class="width5"></td><td>My Account</td></tr>
            </table></a>
        </h3>
        <div>
            <table border="0" cellspacing="5" cellpadding="0" width="100%">
                   <tr><td onClick="location.href='ex_account_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Account Details</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='ex_account_edit_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_edit_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Edit Details</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='ex_account_change_username.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_change_username.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Username</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='ex_account_change_password.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_change_password.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Password</a></td></tr>  
            </table>
        </div>
    </div> -->
    
    <!-- <div>
            <h3 <?php echo $syllabusClass;?> ><a  href="#">
            <table border="0" cellspacing="0" cellpadding="0" >
                  <tr><td><img src="images/icy_earth1.png" /></td><td class="width5"></td><td>Manage Language</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                  <tr>
                      <td onClick="location.href='ex_manage_language.php'" class="menu_font"><a  href="javascript:void(0);" class="<?php if($page_name=="ex_manage_language.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Language</a></td></tr>
                      <tr><td class="line"></td></tr>  
                <tr>
                      <td onClick="location.href='ex_add_language.php'" class="menu_font"><a  href="javascript:void(0);" class="<?php if($page_name=="ex_add_language.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Language</a></td></tr>
                      <tr><td class="line"></td></tr>
                      
                      </table>
            </div>
    </div> -->
    
      <div>
            <h3 <?php echo $examsClass;?> ><a  href="#">
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/sitemap_min.png" /></td><td class="width5"></td><td>Manage Exam </td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='ex_manage_exams.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_exams.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='ex_add_exams.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_exams.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Exam</a></td></tr>
                     <tr><td class="line"></td></tr>
                     
                      <tr><td onClick="location.href='ex_manage_mcq_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_mcq_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage MCQ Paper</a></td></tr>
                     <tr><td class="line"></td></tr>
                    
                     <tr><td class="line"></td></tr>
                     
                      <tr><td onClick="location.href='ex_add_mcq_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_mcq_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add MCQ Paper</a></td></tr>
                     <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='ex_manage_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='ex_add_questions.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_questions.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='ex_edit_disclaimer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_edit_disclaimer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Edit Disclaimer</a></td></tr>
                    <tr><td class="line"></td></tr>
					
					<tr><td onClick="location.href='ex_live_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_live_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Stop Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
					
					<tr><td onClick="location.href='ex_stopped_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_stopped_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Restart Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
					
					<tr><td onClick="location.href='ex_restarted_exam.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_restarted_exam.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Restarted Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
					
                    
                    <tr><td onClick="location.href='ex_intrupted_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="intrupted_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Intrupted Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                     
                </table>
            </div>
    </div>
   
   
    <div>
            <h3 <?php echo $userClass;?> ><a  href="#">
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage User</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='ex_manage_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage User</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='ex_add_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add User</a></td></tr>
                </table>
            </div>
    </div>
    
    
    <!-- Manage Report -->
     <div>
            <h3 <?php echo $reportClass;?> ><a  href="#">
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Report</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='ex_exam_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_exam_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Exam Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='ex_student_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_student_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">View Exam Details</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <tr><td onClick="location.href='ex_stud_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_stud_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Individual Student Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <!-- <tr><td onClick="location.href='disclaimer_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_disclaimer_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Disclaimer Report</a></td></tr>
                     -->
                </table>
            </div>
    </div>

    <div>
            <h3 <?php echo $privilagesClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/pre.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Previlages</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='ex_privilages_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_privilages_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Previlages</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='ex_add_privilages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_privilages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Previlages</a></td></tr>
                </table>
            </div>
    </div>
   
    
    <div>
    	<h3 <?php echo $adminReportClass;?> ><a  href="#">
        <table border="0" cellspacing="0" cellpadding="0" >
        	<tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Admin Report</td></tr>
        </table></a>
        </h3>
        	<div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                     <tr><td onClick="location.href='ex_audit_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_audit_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Audit Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                </table>
            </div>
    </div>
</div>
<?php
 }
 else
 {
    $array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent']; 
	 ?>
<div id="accordion">
    <div>
        <h3 class="<?php echo $homeClass;?>" >
            <a href="javascript:void(0);" >
                <table border="0" cellspacing="0" cellpadding="0" >
                    <tr><td><img src="images/home_icon2.png" /></td><td class="width5"></td><td onClick="location.href='index.php'">Home</td></tr>
                </table>
            </a>
        </h3>
    </div>
    <?php 	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']== 1) //'for only change password'
        {?>
          
    <div>
        <h3 class="<?php echo $myAccountClass;?>" ><a  href="#">
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/man_acc_icon.png" /></td><td class="width5"></td><td style="color:#555555;">My Account</td></tr>
            </table></a>
        </h3>
        <div>
           <table border="0" cellspacing="5" cellpadding="0" width="100%">
           <?php  for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==28)
					{?>
                   <tr><td onClick="location.href='ex_account_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Account Details</a></td></tr>
                   <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==29) {
                       ?>
                   <tr><td onClick="location.href='ex_account_edit_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_edit_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Edit Details</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <?php }elseif ($array_prev[$e][$f]['privilege_id']==30) {
                       ?>
                   <tr><td onClick="location.href='ex_account_change_username.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_change_username.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Username</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <?php }elseif ($array_prev[$e][$f]['privilege_id']==31) {
                       ?>
                   <tr><td onClick="location.href='ex_account_change_password.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_account_change_password.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Password</a></td></tr>  
                   <!--<tr><td onClick="location.href='wel_comecont.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="wel_comecont.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Well Come Containt </a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='wish_image.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="wish_image.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Wish Image</a></td></tr>  -->
                    <?php }
                    }?>
            </table>
        </div>
    </div>
    <?
	}
    if($array_previ_parent[$e]['privilege_id']==6)//'Manage Courses'
    {
	?>
    <div>
            <h3 <?php echo $syllabusClass;?> ><a  href="#">
            <table border="0" cellspacing="0" cellpadding="0" >
                  <tr><td><img src="images/icy_earth1.png" /></td><td class="width5"></td><td style="color:#555555;">Manage Syllabus</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php  for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==21)
					{?>
                  <tr>
                      <td onClick="location.href='ex_manage_language.php'" class="menu_font"><a  href="javascript:void(0);" class="<?php if($page_name=="ex_manage_language.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Language</a></td></tr>
                      <tr><td class="line"></td></tr> 
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==22) {
                       ?> 
                     <tr>
                      <td onClick="location.href='ex_add_language.php'" class="menu_font"><a  href="javascript:void(0);" class="<?php if($page_name=="ex_add_language.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Language</a></td></tr>
                      <tr><td class="line"></td></tr>
                    <?php }?> 
                      <!-- <tr>
                      <td onClick="location.href='manage_syllabus.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_syllabus.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Syllabus</a></td></tr>
                    <tr><td class="line"></td></tr>
                      
                      <tr>
                      <td onClick="location.href='add_syllabus.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_syllabus.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add syllabus</a></td></tr>
   
                     <tr><td class="line"></td></tr>
                             -->
                    <!--tr>
                      <td onClick="location.href='manage_grade.php'" class="menu_font"><a href="javascript:void(0);" class="<--?php if($page_name=="manage_grade.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Grade</a></td></tr>
                    <tr><td class="line"></td></tr>     
                    <tr>
                      <td onClick="location.href='add_grade.php'" class="menu_font"><a href="javascript:void(0);" class="<--?php if($page_name=="add_grade.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Grade</a></td></tr>
                      <tr><td class="line"></td></tr-->
                    <!-- <tr><td onClick="location.href='manage_unit.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_unit.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Unit</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_unit.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_unit.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Unit</a></td></tr>
                     -->
                    <?php }?>
                    <!--tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_tab.php'" class="menu_font"><a href="javascript:void(0);" class="<--?php if($page_name=="manage_tab.php.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Language to question</a></td></tr>
                    
                    
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='tab.php'" class="menu_font"><a href="javascript:void(0);" class="<--?php if($page_name=="tab.php.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Language to question</a></td></tr-->
                </table>
            </div>
    </div>
     
    
   
    <?php
	}
    if($array_previ_parent[$e]['privilege_id']==2)
    {
	?>
     <div>
            <h3 <?php echo $examsClass;?> ><a href="#" >
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/sitemap_min.png" /></td><td class="width5"></td><td style="color:#555555;">Manage Exam </td></tr>
            </table></a>
            </h3>
            <div>
               <table border="0" cellspacing="5" cellpadding="0" width="100%">
               <?php  for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==8)
					{?>
                    <tr><td onClick="location.href='ex_manage_exams.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_exams.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==9) {
                    ?>
                    <tr><td onClick="location.href='ex_add_exams.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_exams.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <?php }elseif ($array_prev[$e][$f]['privilege_id']==10) {?>
                      <tr><td onClick="location.href='ex_manage_mcq_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_mcq_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage MCQ Paper</a></td></tr>
                     <tr><td class="line"></td></tr>
                    
                     <?php }elseif ($array_prev[$e][$f]['privilege_id']==11) {?>
                     
                    <tr><td onClick="location.href='ex_add_mcq_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_mcq_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add MCQ Paper</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==12) {?>
                    <tr><td onClick="location.href='ex_manage_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==13) {?>
                    <tr><td onClick="location.href='ex_add_questions.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_questions.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==33) {?>
                    <tr><td onClick="location.href='ex_edit_disclaimer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_edit_disclaimer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Edit Disclaimer</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==14) {?>
					<tr><td onClick="location.href='ex_live_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_live_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Stop Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==15) {?>
					<tr><td onClick="location.href='ex_stopped_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_stopped_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Restart Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==16) {?>
					<tr><td onClick="location.href='ex_restarted_exam.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_restarted_exam.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Restarted Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==17) {?>
					<tr><td onClick="location.href='ex_intrupted_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="intrupted_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Intrupted Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <?php }}?>   
                </table>
            </div>
    </div>
    
    <?php 
	}
    if($array_previ_parent[$e]['privilege_id']==3)
    {
	?>
     <div>
            <h3 <?php echo $userClass;?> ><a href="#" >
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td style="color:#555555;">Manage User</td></tr>
            </table></a>
            </h3>
            <div>
                 <table border="0" cellspacing="5" cellpadding="0" width="100%">
                 <?php  for($f=0;$f<count($array_prev[$e]);$f++){
    			if($array_prev[$e][$f]['privilege_id']==23)
                {?>
                    <tr><td onClick="location.href='ex_manage_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_manage_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage User</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==24) {?>
                    <tr><td onClick="location.href='ex_add_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add User</a></td></tr>
                    <?php }}?>
                </table>
            </div>
    </div>
     <?php 
	}
    if($array_previ_parent[$e]['privilege_id']==4)
    {
	?>
    <div>
            <h3 <?php echo $reportClass;?> ><a href="#" > 
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td style="color:#555555;">Manage Report</td></tr>
            </table></a>
            </h3>
            <div>
                 <table border="0" cellspacing="5" cellpadding="0" width="100%">
                 <?php  for($f=0;$f<count($array_prev[$e]);$f++){
    			if($array_prev[$e][$f]['privilege_id']==18)
                {?>
                    <tr><td onClick="location.href='ex_exam_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_exam_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Exam Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==19) {?>
                    <tr><td onClick="location.href='ex_student_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_student_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">View Exam Details</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==20) {?>
                     <tr><td onClick="location.href='ex_stud_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_stud_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Individual Student Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <!-- <tr><td onClick="location.href='disclaimer_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="disclaimer_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Disclaimer Report</a></td></tr>
                    <tr><td class="line"></td></tr>-->
                    <?php }}?>
                </table>
            </div>
    </div>
    <?php 
	}
    if($array_previ_parent[$e]['privilege_id']==7)
    {
	?>
     <div>
            <h3 <?php echo $userClass;?> ><a href="#" >
            <table border="0" cellspacing="0" cellpadding="0" >
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td style="color:#555555;">Manage Previlage</td></tr>
            </table></a>
            </h3>
            <div>
                 <table border="0" cellspacing="5" cellpadding="0" width="100%">
                 <?php  for($f=0;$f<count($array_prev[$e]);$f++){
    			if($array_prev[$e][$f]['privilege_id']==25)
                {?>
                    <tr><td onClick="location.href='ex_privilages_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_privilages_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage User</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php }elseif ($array_prev[$e][$f]['privilege_id']==26) {?>
                    <tr><td onClick="location.href='ex_add_privilages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_add_privilages.php.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add User</a></td></tr>
                    <?php }}?>
                </table>
            </div>
    </div>
    <?php
	}
    if($array_previ_parent[$e]['privilege_id']==5)
    {
		?>
    	<div>
    	<h3 <?php echo $reportClass;?> ><a href="#" > 
        <table border="0" cellspacing="0" cellpadding="0" style="color:#555555;">
        	<tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Admin Report</td></tr>
        </table></a>
        </h3>
        <div>
        <table border="0" cellspacing="5" cellpadding="0" width="100%">
        	<tr><td onClick="location.href='ex_audit_report.php '" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="ex_audit_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Audit Report</a></td></tr>
            <tr><td class="line"></td></tr>
        </table>
        </div>
    </div>
    <?php
	}
} ?>
</div>
<?php
 }
 ?>
</div>