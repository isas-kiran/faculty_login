<?php  $page_name= basename($_SERVER['PHP_SELF']);

    $activeDone="";
    $page_name= basename($_SERVER['PHP_SELF']); 
    
    $homeClass='ui-state-default';
    if ($page_name == 'index.php')
    {
        $activeDone=0;
        $homeClass='ui-state-active';
    }
    
    $myAccountClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'account_details.php' || $page_name == 'account_edit_details.php' || $page_name == 'account_change_username.php' || $page_name == 'account_change_password.php' || $page_name=='wel_comecont.php'))
    {
        $activeDone=1;
        $myAccountClass='ui-state-active';
    }
    
    $memberClass='ui-state-default';    
    if($activeDone=="" && ($page_name == 'body_member_add.php'  || $page_name == 'body_member_manage.php'))
    {
        $activeDone=2;
        $CountryClass='ui-state-active';
    }
    
    $branchesClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'banches_add.php'  || $page_name == 'banches_manage.php'))
    {
        $activeDone=3;
        $branchesClass='ui-state-active';
    }
    
    $savinClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_savings.php'  || $page_name == 'manage_saving.php'))
    {
        $activeDone=4;
        $savinClass='ui-state-active';
    }
    
    $photoClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_gallery.php'   || $page_name == 'manage_photo.php' || $page_name == 'add-images-in-gallery.php') )
    {
        $activeDone=5;
        $photoClass='ui-state-active';
    }
    
    $videoClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_vedio_gallery.php'  || $page_name == 'manage_vedio_gallery.php' || $page_name == 'add-videos-in-gallery.php' ))
    {
        $activeDone=6;
        $videoClass='ui-state-active';
    }
    $faqClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_faq.php'  || $page_name == 'manage_faq.php' ))
    {
        $activeDone=7;
        $faqClass='ui-state-active';
    }
    
    $categoryClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_category.php'  || $page_name == 'manage_category.php'))
    {
        $activeDone=8;
        $categoryClass='ui-state-active';
    } 
    
    $courseClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_course.php'  || $page_name == 'manage_course.php' || $page_name == 'add_course_faq.php'  || $page_name == 'manage_course_faq.php' || $page_name == 'manage_course_certification.php' || $page_name == 'add_course_certification.php'))
    {
        $activeDone=9;
        $courseClass='ui-state-active';
    }
    
    $syllabusClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_course_sylabus.php'  || $page_name == 'manage_course_syllabus.php'))
    {
        $activeDone=10;
        $syllabusClass='ui-state-active';
    }
    
    $answerClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_question.php'  || $page_name == 'manage_questions.php'))
    {
        $activeDone=11;
        $answerClass='ui-state-active';
    }  
    
    
    $jobClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_jobs.php'  || $page_name == 'manage_jobs.php'))
    {
        $activeDone=12;
        $jobClass='ui-state-active';
    }
    $examClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_exam_duration.php'  || $page_name == 'manage_exam_duration.php' ))
    {
        $activeDone=13;
        $examClass='ui-state-active';
    }
    
    $testClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_test.php'  || $page_name == 'manage_test.php'|| $page_name == 'add_more.php'  || $page_name == 'view_test.php' || $page_name == 'edit_test_options.php'))
    {
        $activeDone=14;
        $testClass='ui-state-active';
    }
    
    $expertClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_expert_speak.php'  || $page_name == 'manage_expert.php' ))
    {
        $activeDone=15;
        $expertClass='ui-state-active';
    }
    $menuClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_menu.php'  || $page_name == 'manage_menu.php' ))
    {
        $activeDone=16;
        $menuClass='ui-state-active';
    }
    $pageClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_pages.php'  || $page_name == 'manage_pages.php' ))
    {
        $activeDone=17;
        $pageClass='ui-state-active';
    }
	$schemeClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_scheme.php'  || $page_name == 'manage_scheme.php' || $page_name == 'add_sub_scheme.php'  ))
    {
        $activeDone=18;
        $schemeClass='ui-state-active';
    }
?>
<script type="text/javascript">
    jQuery(document).ready( function() 
        {       
            $("#accordion").accordion({ active:<?php echo $activeDone;?>, header: "h3", autoHeight: false, collapsible: true });        
        });
</script>
<div id="left_info">
<div id="accordion">
    <div>
        <h3 class="<?php echo $homeClass;?>" >
            <a href="javascript:void(0);">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td><img src="images/home_icon2.png" /></td><td class="width5"></td><td onclick="location.href='index.php'">Home</td></tr>
                </table>
            </a>
        </h3>
    </div>
    <div>
        <h3 class="<?php echo $myAccountClass;?>" ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/man_acc_icon.png" /></td><td class="width5"></td><td>My Account</td></tr>
            </table></a>
        </h3>
        <div>
            <table border="0" cellspacing="5" cellpadding="0" width="100%">
                  <tr><td onclick="location.href='account_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Account Details</a></td></tr>
                        <tr><td class="line"></td></tr>
                   <tr><td onclick="location.href='account_edit_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_edit_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Edit Details</a></td></tr>
                        <tr><td class="line"></td></tr>
                   <tr><td onclick="location.href='account_change_username.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_change_username.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Username</a></td></tr>
                        <tr><td class="line"></td></tr>
                   <tr><td onclick="location.href='account_change_password.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_change_password.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Password</a></td></tr>  
            </table>
        </div>
    </div>
    <div>
            <h3 <?php echo $memberClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/icy_earth1.png" /></td><td class="width5"></td><td>Manage Body Members</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='body_member_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="body_member_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Body Members</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='body_member_add.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="body_member_add.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Body Members</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $branchesClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/city_small.png" /></td><td class="width5"></td><td>Manage Branches</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='banches_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="banches_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Branches</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='banches_add.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="banches_add.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Branches</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $savinClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/news-subscribe_min.png" /></td><td class="width5"></td><td>Manage Saving</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_saving.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_saving.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Saving</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_savings.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_savings.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Saving</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $photoClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/teacher_min.png" /></td><td class="width5"></td>
                  <td>Manage Photo Gallery</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_photo.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_photo.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Photo Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Photo Gallery</a></td></tr>
                   <tr><td onclick="location.href='add-images-in-gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add-images-in-gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Images in Gallery</a></td></tr>

                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $videoClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/user_min.png" /></td><td class="width5"></td><td>Manage Video Gallery</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_vedio_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_vedio_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Video Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                 <tr><td onclick="location.href='add_vedio_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_vedio_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Video Gallery </a></td></tr>
                 <tr><td onclick="location.href='add-videos-in-gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add-videos-in-gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Video in Gallery</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $faqClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/Faq-16.png" /></td><td class="width5"></td><td>Manage Social Programs</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_faq.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_faq.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Social Programs</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_faq.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_faq.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Social Programs</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $categoryClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/sitemap_min.png" /></td><td class="width5"></td><td>Manage Awarded Persons</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Awarded Persons</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Awarded Persons</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $courseClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/course_min.png" /></td><td class="width5"></td><td>Manage News</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_course.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_course.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage News</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_course.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add News</a></td></tr>
                    <!--<tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='manage_course_faq.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_course_faq.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Course Faq</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_course_faq.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course_faq.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Course Faq</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='manage_course_certification.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_course_certification.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Course Certification</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_course_certification.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course_certification.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Course Certification</a></td></tr>
-->                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $syllabusClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/book_min.png" /></td><td class="width5"></td><td>Manage Yearly Report</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_course_syllabus.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_course.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Yearly Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_course_sylabus.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Yearly Report</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $answerClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/Question_mark_min.png" /></td><td class="width5"></td><td>Manage FeedBack</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_questions.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_questions.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage FeedBack</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add FeedBack</a></td></tr>
                </table>
            </div>
    </div>
    
    <div>
            <h3 <?php echo $jobClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/job_openings_min.png" /></td><td class="width5"></td><td>Manage Internal Facilities</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_jobs.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_jobs.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage  Internal Facilities</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_jobs.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_jobs.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Internal Facilities</a></td></tr>
                </table>
            </div>
    </div>
    
    <div>
            <h3 <?php echo $examClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Rules And Regulations</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr>
                      <td onclick="location.href='manage_exam_duration.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_exam_duration.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Rules And Regulations</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_exam_duration.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_exam_duration.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Rules And Regulations</a></td></tr>
                </table>
            </div>
    </div>
    
    <div>
            <h3 <?php echo $testClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/test-paper-16.png" /></td><td class="width5"></td>
                <td>Manage Insurance Plan</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_test.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_test.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage  Insurance Plan</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_test.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_test.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Insurance Plan</a></td></tr>
                </table>
            </div>
    </div>
    
    <div>
            <h3 <?php echo $expertClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16-16_import-export.png" /></td><td class="width5"></td>
                <td>Manage SMS</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr>
                      <td onclick="location.href='manage_expert.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_expert.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SMS</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr>
                      <td onclick="location.href='add_expert_speak.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_expert_speak.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Send SMS</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $menuClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16-16_banner_design.png" /></td><td class="width5"></td>
                <td>Manage Menu</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_menu.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_menu.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Menu</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_menu.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_menu.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Menu</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $pageClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Pages</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_pages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_pages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Pages</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_pages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_pages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Pages</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $schemeClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Scheme</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onclick="location.href='manage_scheme.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_scheme.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Scheme</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onclick="location.href='add_scheme.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_scheme.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Scheme</a></td></tr>
                    <tr><td onclick="location.href='add_sub_scheme.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_sub_scheme.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Sub Scheme</a></td></tr>

                </table>
            </div>
    </div>
    
</div>
</div>
