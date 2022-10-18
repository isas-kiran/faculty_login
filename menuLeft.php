<?php  $page_name= basename($_SERVER['PHP_SELF']);

    $activeDone="";
    $page_name= basename($_SERVER['PHP_SELF']); 
    
    $homeClass='ui-state-default';
    if ($page_name =='index.php')
    {
        $activeDone=0;
        $homeClass='ui-state-active';
    }
    $myAccountClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'account_details.php' || $page_name == 'account_edit_details.php' || 
	$page_name == 'account_change_username.php' || $page_name == 'account_change_password.php' || $page_name=='wel_comecont.php'
	|| $page_name == 'wel_comecont.php' || $page_name=='wish_image.php'))
    {
        $activeDone=1;
        $myAccountClass='ui-state-active';
    }
	
    $courseClass='ui-state-default';    
    if($activeDone=="" && ($page_name == 'course_manage.php'  || $page_name == 'add_course.php' || $page_name =='course_category.php' || $page_name =='add_course_category.php' || $page_name =='subject_manage.php' || $page_name =='subject_add.php' || $page_name =='topic_manage.php' || $page_name =='add_topic.php' || $page_name =='batch_manage.php' || $page_name =='add_batch.php' || $page_name =='course_logsheet.php'  || $page_name =='import_all.php' ))
    {
        $activeDone=2;
        $courseClass='ui-state-active';
    }
	/*$topicClass='ui-state-default';    
    if($activeDone=="" && ($page_name == 'topic_manage.php'  || $page_name == 'add_topic.php' ))
    {
        $activeDone=4;
        $topicClass='ui-state-active';
    }*/
    
    $studentClass='ui-state-default';
   if($activeDone=="" && ($page_name == 'manage_student.php'   ||$page_name == 'inquiry.php' ||$page_name == 'add_student.php'   || $page_name == 'manage_enroll.php' || $page_name == 'enroll.php' || $page_name == 'enroll_gst.php' || $page_name == 'logsheet.php' || $page_name == 'online_trans_summery.php' || $page_name == 'followup_summery.php' || $page_name == 'followup_record.php' || $page_name == 'import_student.php' || $page_name == 'add_new_course.php' || $page_name == 'add_student_kit.php' || $page_name == 'student_report.php' || $page_name == 'total_report.php' || $page_name == 'add_student_gst.php' || $page_name == 'enroll_gst.php' || $page_name == 'import_campaign_inquiries.php'))
    {
        $activeDone=3;
        $studentClass='ui-state-active';
    }
    
    
    
   /* $studentClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_student.php'   ||$page_name == 'inquiry.php'   || $page_name == 'manage_enroll.php' || $page_name == 'enroll.php'  || $page_name == 'logsheet.php'))
    {
        $activeDone=6;
        $studentClass='ui-state-active';
    }*/
   /* $sub_admin='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_subadmin.php'  || $page_name == 'manage_subadmin.php' ))
    {
        $activeDone=8;
        $sub_admin='ui-state-active';
    }
	
	 $councellor='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_councellor.php'  || $page_name == 'manage_councellor.php' ))
    {
        $activeDone=9;
        $sub_admin='ui-state-active';
    }
	 $bop='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_bop.php'  || $page_name == 'manage_bop.php' ))
    {
        $activeDone=10;
        $sub_admin='ui-state-active';
    }*/
	/*$downloadClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_download.php'  || $page_name == 'manage_download.php'  ))
    {
        $activeDone=4;
        $downloadClass='ui-state-active';
    }*/
	
	/*$examsClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_exam.php'  || $page_name == 'manage_exam.php' || $page_name == 'manage_question.php' || $page_name == 'create_question.php' || $page_name == 'manage_paper.php' || $page_name == 'create_paper.php'))
    {
        $activeDone=5;
        $examsClass='ui-state-active';
    }
	 $user='ui-state-default';*/
    
	
   /* $quetionClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'create_question.php' || $page_name == 'manage_question.php'))
    {
        $activeDone=9;
        $quetionClass='ui-state-active';
    } 
    
	  $papaersClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'create_paper.php'  || $page_name == 'manage_paper.php' ))
    {
        $activeDone=11;
        $papaersClass='ui-state-active';
    }*/
/*    $admitionClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_admition.php'  || $page_name == 'manage_admition.php' || $page_name=='stud_admition_details.php'))
    {
        $activeDone=12;
        $admitionClass='ui-state-active';
    }  
*/	 /*$photoClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_photo.php'  || $page_name == 'add_gallery.php' || $page_name=='add-images-in-gallery.php' || $page_name == 'manage_vedio_gallery.php'  || $page_name == 'add_vedio_gallery.php' || $page_name == 'add-videos-in-gallery.php' ))
    {
        $activeDone=6;
        $photoClass='ui-state-active';
    }  */
    
	
	/*$pageClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_menu.php'  || $page_name == 'add_menu.php' ))
    {
        $activeDone=7;
        $pageClass='ui-state-active';
    }
	
	
    $pageClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_pages.php'  || $page_name == 'add_pages.php' ))
    {
        $activeDone=8;
        $pageClass='ui-state-active';
    }
	
	$sliderClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_slider.php'  || $page_name == 'add_slider.php' || $page_name == 'add_image_slider.php' ))
    {
        $activeDone=9;
        $sliderClass='ui-state-active';
    }
	
	$testimonialClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_testimonial.php'))
    {
        $activeDone=10;
        $testimonialClass='ui-state-active';
    }
	
	$noticeClass='ui-state-default';
    if($activeDone=="" && ($page_name =='manage_notice.php' || $page_name == 'add_notice.php' ))
    {
        $activeDone=11;
        $noticeClass='ui-state-active';
    }*/
	
	 $generalClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_source.php'   ||$page_name == 'manage_source.php'   || $page_name == 'add_tax.php' || $page_name == 'manage_tax.php' ||$page_name == 'manage_discount.php' ||$page_name == 'add_discount.php'   || $page_name == 'add_batch_time.php' || $page_name == 'manage_batch_time.php' ||$page_name == 'manage_lab.php' ||$page_name == 'add_lab.php' ||$page_name == 'add_sms_mail.php' || $page_name == 'manage_sms_mail.php'  || $page_name == 'add_sallery.php' || $page_name == 'add_tax_type.php'|| $page_name == 'manage_tax_type.php' || $page_name == 'rewards_point_config.php' || $page_name == 'rewards_value_config.php'	 || $page_name == 'manage_sac_code.php')  )
    {
        $activeDone=4;
        $generalClass='ui-state-active';
    }
	$privilagesClass='ui-state-default';    
    if($activeDone=="" && ($page_name == 'privilages_manage.php'  || $page_name == 'add_privilages.php' ))
    {
        $activeDone=5;
        $privilagesClass='ui-state-active';
    }
	if($activeDone=="" && ($page_name == 'manage_user.php'  || $page_name == 'add_user.php' ))
    {
        $activeDone=6;
        $sub_admin='ui-state-active';
    }
	/*if($activeDone=="" && ($page_name == 'manage_sms.php'  || $page_name == 'send_sms.php' ))
    {
        $activeDone=7;
        $sms='ui-state-active';
    }*/
	
    $reportClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_report.php'||$page_name=='package_service.php'||$page_name=='outstand_report.php'||$page_name == 'lead.php'|| $page_name == 'total_enrollment.php' || $page_name == 'total_enquiry.php' || $page_name == 'manage_expense.php' || $page_name == 'dsr_report.php' || $page_name == 'total_source.php' || $page_name == 'campaign_main_report.php' || $page_name == 'total_response.php' || $page_name == 'checkout_report.php' || $page_name == 'customer_service_report.php' || $page_name == 'total_sales_report.php' || $page_name == 'audit_report.php' || $page_name == 'consumption_report.php' || $page_name == 'product_outstand_report.php'))
    {
        $activeDone=7;
        $reportClass='ui-state-active';
    }
    
  /*  $staffClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'staff_manage.php'  || $page_name == 'staff_registration.php'))
    {
        $activeDone=17;
        $staffClass='ui-state-active';
    }*/
	$expenseClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'expense.php'  || $page_name == 'receipt.php'  || $page_name == 'cash_transfer.php'  || $page_name == 'expense_type.php'  || $page_name == 'payment_mode.php'|| $page_name == 'manage_bank_account.php' || $page_name == 'import_expense.php'))
    {
        $activeDone=8;
        $expenseClass='ui-state-active';
    }
	
	$servicesClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'add_service_category.php'  || $page_name == 'manage_services_category.php' || $page_name == 'add_services.php'  || $page_name == 'manage_services.php' || $page_name == 'manage_customer.php'|| $page_name == 'add_customer.php' || $page_name == 'manage_membership.php' || $page_name == 'add_membership.php' || $page_name == 'add_customer_membership.php' || $page_name == 'add_cust_services.php' || $page_name == 'manage_cust_services.php' || $page_name == 'manage_package.php' || $page_name == 'add_package.php'  || $page_name == 'add_voucher.php' || $page_name =='manage_memb_package_voucher.php' || $page_name =='sale_memb_package_voucher.php' || $page_name=="import_services.php" || $page_name=="book_service.php"|| $page_name=="manage_service_inquiry.php"|| $page_name=="service_inquiry.php"|| $page_name=="import_campaign_services.php" ))
    {
        $activeDone=9;
        $servicesClass='ui-state-active';
    }
	
	$productClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_product_category.php'  || $page_name == 'add_product_category.php' || $page_name == 'manage_product.php' || $page_name == 'add_product.php' || $page_name == 'manage_checkout.php' || $page_name == 'add_checkout.php' || $page_name == 'manage_inventory.php' || $page_name == 'add_inventory.php' || $page_name == 'sales_product.php' || $page_name == 'add_vendor.php' || $page_name == 'manage_vendor.php'  || $page_name == 'import_products.php' || $page_name =='import_products.php' || $page_name =='manage_sales_product.php' || $page_name=="consumption_qty.php" || $page_name=="product_inword.php" || $page_name=="manage_inword.php"))
    {
        $activeDone=10;
        $productClass='ui-state-active';
    }
	$complaintClass='ui-state-default';
    if($activeDone=="" && ($page_name == 'manage_complaint.php' ))
    {
        $activeDone=11;
        $complaintClass='ui-state-active';
    }
	
	$payrollClass='ui-state-default';
    if(($page_name == 'add_system_parameters.php') || ($page_name == 'manage_attendance.php') || ($page_name == 'import_attendance.php') || ($page_name == 'payroll_manage_staff.php') || ($page_name == 'previous_balance_leave.php') || ($page_name == 'manage_leave_management.php') || ($page_name == 'leave_management.php') || ($page_name == 'manage_staff_leave_management.php' || ($page_name == 'staff_leave_management.php') || ($page_name == 'manage_advance_deduction.php') || ($page_name == 'advance_deduction.php') || ($page_name == 'manage_staff_service_incentive.php') || ($page_name == 'staff_service_incentive.php') || ($page_name == 'manage_staff_product_incentive.php') || ($page_name == 'staff_product_incentive.php') || ($page_name == 'manage_staff_course_incentive.php') || ($page_name == 'staff_course_incentive.php') || ($page_name == 'manage_staff_salary_management.php') || ($page_name == 'staff_salary_management.php') || ($page_name == 'make_salary.php') || ($page_name == 'salary_slip.php') || ($page_name == 'salary_report.php')))
    {
        $activeDone=12;
        $payrollClass='ui-state-active';
    }
	$event='ui-state-default';
    if(($page_name=="add_event.php") || ($page_name == 'manage_event.php' ))
    {
        $activeDone=13;
        $event='ui-state-active';
    }
	$finance_report='ui-state-default';
    if(($page_name=="enroll_incomming_gst.php") || ($page_name == 'enroll_incomming_gst_export.php' ) || ($page_name == 'product_incomming_gst.php' )|| ($page_name == 'product_incomming_gst_export.php' ) || ($page_name == 'service_incomming_gst.php' ) || ($page_name == 'service_incomming_gst_export.php' ) || ($page_name == 'expense_tds.php' ) || ($page_name == 'bank_summery.php' ) || ($page_name == 'product_summery_report.php' ) || ($page_name == 'service_summery_report.php' ) || ($page_name == 'expense_summery_report.php' ) || ($page_name == 'purchase_summery_report.php' ) || ($page_name == 'cash_transfer_summery_report.php' ) || ($page_name == 'gst_summury_report.php' ) || ($page_name == 'receipt_summury_report.php' ) || ($page_name == 'all_bank_report.php') || ($page_name == 'bank_summery_report.php') )
    {
        $activeDone=14;
        $finance_report='ui-state-active';
    }
	
	if(($page_name=="batch_specific.php") || ($page_name == 'manage_subscriber.php' ) || ($page_name == 'subscriber_specific.php' )|| ($page_name == 'manage_group.php' ) || ($page_name == 'add_group.php' ) || ($page_name == 'group_by_sms.php' ) || ($page_name == 'upload_num_excel.php' ) || ($page_name == 'send_sms_email.php' ))
    {
        $activeDone=15;
        $sms='ui-state-active';
    }
	if(($page_name=="manage_campaign.php") || ($page_name == 'add_campaign.php' ) || ($page_name == 'campaign_report.php' ))
    {
        $activeDone=16;
        $campaign='ui-state-active';
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
<div id="accordion">

    <div>
        <h3 class="<?php echo $homeClass;?>" >
            <a href="javascript:void(0);">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td><img src="images/home_icon2.png" /></td><td class="width5"></td><td onClick="location.href='index.php'">Home</td></tr>
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
                   <tr><td onClick="location.href='account_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Account Details</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='account_edit_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_edit_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Edit Details</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='account_change_username.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_change_username.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Username</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='account_change_password.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_change_password.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Password</a></td></tr>  
                   <!--<tr><td onClick="location.href='wel_comecont.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="wel_comecont.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Well Come Containt </a></td></tr>
                   <tr><td class="line"></td></tr>
                   <tr><td onClick="location.href='wish_image.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="wish_image.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Wish Image</a></td></tr> --> 
            </table>
        </div>
    </div>
    
    <div>
            <h3 <?php echo $courseClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/course.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Courses</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr>
                      <td onClick="location.href='course_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="course_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Course</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr>
                      <td onClick="location.href='add_course.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Course</a></td></tr>
                
                <tr><td class="line"></td></tr>
                <tr>
                      <td onClick="location.href='course_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="course_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Course Category</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr>
                      <td onClick="location.href='add_course_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Course Category</a></td></tr>
                      <tr><td class="line"></td></tr>
                      
                      <tr>
                      <td onClick="location.href='subject_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="subject_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject</a></td></tr>
                    <tr><td class="line"></td></tr>
                      
                      <tr>
                      <td onClick="location.href='subject_add.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="subject_add.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr>
                      <td onClick="location.href='topic_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="topic_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Topic</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr>
                      <td onClick="location.href='add_topic.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_topic.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Topic</a></td></tr>
                    <tr><td class="line"></td></tr>
                      
                      
                      <tr>
                      <td onClick="location.href='batch_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="batch_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Batch</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr>
                      <td onClick="location.href='add_batch.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_batch.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Batch</a></td></tr>
                       <tr><td class="line"></td></tr>
                    <tr>
                      <td onClick="location.href='import_all.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_all.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Course</a></td></tr>
               
                </table>
            </div>
    </div>
    
   <!--<div>
            <h3 <?php //echo $topicClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Topic</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='topic_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="topic_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Topic</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_topic.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_topic.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Topic</a></td></tr>
                </table>
            </div>
    </div>-->
    <!--<div>
            <h3 <?php //echo $subjectClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/city_small.png" /></td><td class="width5"></td><td>Manage Subject</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='subject_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="subject_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='subject_add.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="subject_add.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject</a></td></tr>
                <tr><td class="line"></td></tr>
<!--                    <tr><td onclick="location.href='banches_worker_add.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="banches_worker_add.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Employee</a></td></tr>
-->
               <!-- </table>
            </div>
    </div>-->
   
    <div>
            <h3 <?php echo $studentClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/student.png" height="20" width="20"/></td><td class="width5"></td>
                  <td>Manage Student</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <tr><td onClick="location.href='manage_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Enquiry</a></td></tr>
                <tr><td class="line"></td></tr>
                <tr><td onClick="location.href='inquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="inquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Enquiry</a></td></tr>
                <tr><td class="line"></td></tr>
                
                <tr><td onClick="location.href='manage_enroll.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_enroll.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Enrolled Student</a></td></tr>
                <tr><td class="line"></td></tr>
                
                <!--<tr><td onClick="location.href='enroll.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="enroll.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enrollment Form</a></td></tr>
                <tr><td class="line"></td></tr>-->
                
                <tr><td onClick="location.href='enroll_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="enroll_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enrollment Form</a></td></tr><!--<img src="images/new.gif" />-->
                <tr><td class="line"></td></tr>
                
                <tr><td onClick="location.href='logsheet.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="logsheet.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Logsheet</a></td></tr>
                <tr><td class="line"></td></tr>
                <tr><td onClick="location.href='online_trans_summery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="online_trans_summery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Online Transaction Summery</a></td></tr>
                <tr><td class="line"></td></tr>
                <tr><td onClick="location.href='followup_summery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="followup_summery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Followup Summery</a></td></tr>
                <tr><td class="line"></td></tr>
                <tr><td onClick="location.href='followup_record.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="followup_record.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Followup Report</a></td></tr>
                <tr><td class="line"></td></tr>
                 <tr><td onClick="location.href='import_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Student</a></td></tr>
                <tr><td class="line"></td></tr>
                 <tr><td onClick="location.href='total_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Todays Report</a></td></tr>
				 <tr><td class="line"></td></tr>
                 <tr><td onClick="location.href='student_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="student_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Student Report</a></td></tr>
                 <tr><td class="line"></td></tr>
                 <tr><td onClick="location.href='import_campaign_inquiries.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_campaign_inquiries.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Campaign Enquiries</a></td></tr>
				 
                </table>
            </div>
    </div>
     <!--<div>
            <h3 <?php //echo $sub_admin;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage SubAdmin</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_subadmin.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_subadmin.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SubAdmin</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_subadmin.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_subadmin.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add SubAdmin</a></td></tr>
                </table>
            </div>
    </div>-->
    
     <!--<div>
            <h3 <?php //echo $councellor;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Councellor</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_councellor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_councellor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Councellor </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_councellor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_councellor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Councellor </a></td></tr>
                </table>
            </div>
            
    </div>-->
    
   <!-- <div>
            <h3 <?php //echo $bop;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage BOP</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_bop.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_bop.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage BOP </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_bop.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_bop.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add BOP </a></td></tr>
                </table>
            </div>
            
    </div>-->
    
     
    
    
    <!--<div>
            <h3 <?php //echo $downloadClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Download</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_download.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_download.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Download</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_download.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_download.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Download</a></td></tr>

                </table>
            </div>
    </div>-->
    <!--<div>
            <h3 <?php //echo $quetionClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr><td><img src="images/paper.png" /></td><td class="width5"></td><td>Manage Subject Question </td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                 <tr><td onClick="location.href='create_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="create_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject Questions </a></td></tr>
                </table>
            </div>
    </div>-->
    <!-- <div>
            <h3 <?php //echo $examsClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/sitemap_min.png" /></td><td class="width5"></td><td>Manage Exam </td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_exam.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_exam.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='add_exam.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_exam.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Exam</a></td></tr>
                     <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='manage_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                 <tr><td onClick="location.href='create_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="create_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject Questions </a></td></tr>
                  <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='manage_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Question Paper</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='create_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="create_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Question Paper</a></td></tr>
                   
                </table>
            </div>
    </div>-->
    <!--<div>
            <h3 <?php //echo $papaersClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/Faq-16.png" /></td><td class="width5"></td><td>Manage Question Paper</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Question Paper</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='create_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php// if($page_name=="create_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Question Paper</a></td></tr>
                </table>
            </div>
    </div>-->
   
    <!--<div>
            <h3 <?php// echo $admitionClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/course_min.png" /></td><td class="width5"></td><td>Manage Take Admition  </td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_admition.php'" class="menu_font"><a href="javascript:void(0);" class="<?php// if($page_name=="manage_admition.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Take Admition  Cutting</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_admition.php'" class="menu_font"><a href="javascript:void(0);" class="<?php// if($page_name=="add_admition.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Take Admition </a></td></tr>
                    </table>
            </div>
    </div>-->
   
    <!--<div>
            <h3 <?php //echo $photoClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16-16_banner_design.png" /></td><td class="width5"></td>
                <td>Manage Gallery</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_photo.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_photo.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Picture Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Picture Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add-images-in-gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add-images-in-gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Picture </a></td></tr>
                    <tr><td class="line"></td></tr>
					<tr><td onClick="location.href='manage_vedio_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_vedio_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Video Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_vedio_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_vedio_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Video Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add-videos-in-gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add-videos-in-gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Video </a></td></tr>
                </table>
            </div>
    </div>
    
    <div>
            <h3 <?php //echo $menuClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16-16_banner_design.png" /></td><td class="width5"></td>
                <td>Manage Menu</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_menu.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_menu.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Menu</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_menu.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_menu.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Menu</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php //echo $pageClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Pages</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_pages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_pages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Pages</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_pages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_pages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Pages</a></td></tr>
                </table>
            </div>
    </div>
    <div>
            <h3 <?php //echo $sliderClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Slider</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_slider.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_slider.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Slider</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_slider.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_slider.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Slider</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_image_slider.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_image_slider.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Image To Slider</a></td></tr>

                </table>
            </div>
    </div>
     <div>
            <h3 <?php //echo $testimonialClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Testimonial</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_testimonial.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_testimonial.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Testimonial</a></td></tr>
                    <tr><td class="line"></td></tr>
                </table>
            </div>
            
    </div>
     <div>
            <h3 <?php //echo $noticeClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Notice</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_notice.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_notice.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Notice </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_notice.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_notice.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Notice </a></td></tr>
                </table>
            </div>
            
    </div>-->
    
    <div>
            <h3 <?php echo $generalClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/general.png" height="20" width="20"/></td><td class="width5"></td><td>General Setting</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_source.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_source.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Source </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_source.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_source.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Source </a></td></tr>
                     <tr><td class="line"></td></tr>
                     <tr><td onClick="location.href='manage_tax.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_tax.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Tax </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_tax.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_tax.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Tax </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_discount.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_discount.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Discount Coupon </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_discount.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_discount.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Discount Coupon</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_batch_time.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_batch_time.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Batch Time </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_batch_time.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_batch_time.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Batch Time</a></td></tr>
                     <tr><td class="line"></td></tr>
                   
                    <tr><td onClick="location.href='manage_lab.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_lab.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Lab</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_lab.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_lab.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Lab</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_sms_mail.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_sms_mail.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SMS</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_sms_mail.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_sms_mail.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add SMS</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='rewards_point_config.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="reward_point_config.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Rewards Point</a></td></tr>
					<tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='rewards_value_config.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="reward_value_config.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Rewards Value</a></td></tr>
					<tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_sac_code.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_sac_code.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SAC code</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_sallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_sallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Sallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_tax_type.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_tax_type.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Tax Type</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_tax_type.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_tax_type.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Tax Type</a></td></tr>
                    
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
                    <tr><td onClick="location.href='privilages_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="privilages_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Previlages</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_privilages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_privilages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Previlages</a></td></tr>
                </table>
            </div>
    </div>
   
    <div>
            <h3 <?php echo $user;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/users.png" height="20" width="20"/></td><td class="width5"></td><td>Manage User/Staff</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage User</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add User</a></td></tr>
                </table>
            </div>
    </div>
    <!--<div>
            <h3 <?php //echo $sms;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>SMS Log</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_sms.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_sms.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SMS</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='send_sms.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="send_sms.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Send SMS</a></td></tr>
                </table>
            </div>
    </div>-->
    
    <div>
            <h3 <?php echo $reportClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/city.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Report</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='total_enrollment.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_enrollment.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Total Enrollment</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='total_enquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_enquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Total Enquiry</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <!--<tr><td onClick="location.href='total_source.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_source.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Source Report</a></td></tr> -->
					 <tr><td onClick="location.href='campaign_main_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="campaign_main_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Campaign Report</a></td></tr>
                    <tr><td class="line"></td></tr>
				     <tr><td onClick="location.href='lead.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="lead.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Lead GradeReport</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <tr><td onClick="location.href='outstand_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="outstand_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">OutStanding Report</a></td></tr>
					 <tr><td class="line"></td></tr>
                     <tr><td onClick="location.href='product_outstand_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_outstand_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product OutStanding Report</a></td></tr>
                    <tr><td class="line"></td></tr>
					 <tr><td onClick="location.href='total_sales_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_sales_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Total Sales Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <tr><td onClick="location.href='package_service.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="package_service.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Package Service Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <tr><td onClick="location.href='total_response.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_response.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Response Category Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_expense.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_expense.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Expense</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='dsr_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="dsr_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage DSR</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='checkout_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="checkout_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Checkout Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='customer_service_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="customer_service_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Service Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='audit_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="audit_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Audit Report</a></td></tr>
					 <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='consumption_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="consumption_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Consumption Report</a></td></tr>
				</table>
            </div>
    </div>
    <!-- <div>
            <h3 <?php //echo $staffClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/news-subscribe_min.png" /></td><td class="width5"></td><td>Manage Staff</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='staff_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="staff_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='staff_registration.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_savings.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add staff</a></td></tr>
                </table>
            </div>
    </div>-->
    <div>
            <h3 <?php echo $expenseClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/expense.png" height="20px" width="20px"/></td><td class="width5"></td><td>Manage Expense and Bank</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr>
                    <td onClick="location.href='receipt.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="receipt.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Receipt</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='expense.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='cash_transfer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="cash_transfer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Cash Transfer</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='payment_mode.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="payment_mode.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Payment Mode</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='expense_type.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense_type.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Expense Type</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_bank_account.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_bank_account.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Bank Account</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='import_expense.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_expense.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Expense</a></td></tr>
                   
                    
                </table>
            </div>
    </div> 
    
    <div>
            <h3 <?php echo $servicesClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/service.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Services</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
					<tr>
					<td onClick="location.href='manage_service_inquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_service_inquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Service Inquiry</a></td>
					</tr>
					<tr><td class="line"></td></tr>
					<tr>
					<td onClick="location.href='service_inquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_inquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Service Inquiry</a></td>
					</tr>
					<tr><td class="line"></td></tr>
                	<tr>
					<td onClick="location.href='manage_cust_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_cust_service.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Customer Services</a></td>
					</tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='book_service.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="book_service.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Book Services</a></td></tr>
                    <tr><td class="line"></td></tr>
                	<tr><td onClick="location.href='manage_services_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_services_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Services Category </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_service_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_service_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Services Category</a></td></tr>
                   
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Services </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Services </a></td></tr>
                   
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_customer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_customer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Customer </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_customer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_customer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Customer</a></td></tr>
                                
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Membership </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Membership</a></td></tr>
                    
                    <!--<tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_customer_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_customer_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Customer Membership </a></td></tr>-->
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_customer_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_customer_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Customer Membership</a></td></tr>
                     <tr><td class="line"></td></tr>
                     <tr><td onClick="location.href='manage_package.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_package.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Package</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='add_package.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_package.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Package</a></td></tr>
                     <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='add_voucher.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_voucher.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Voucher</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='manage_memb_package_voucher.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_memb_package_voucher.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Package/ Voucher/ Membership</a></td></tr>
                     <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='sale_memb_package_voucher.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="sale_memb_package_voucher.php.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Package/ Voucher/ Membership</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='import_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Services</a></td></tr>
                    
					<tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='import_campaign_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_campaign_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Campaign Services</a></td></tr>
                </table>
            </div>
            
    </div>
    
    
    
    <div>
            <h3 <?php echo $productClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/product.png" height="20px" width="20px"/></td><td class="width5"></td><td>Manage product</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_product_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_product_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage product_category</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_product_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_product_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product Category</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_product.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_product.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Product</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_product.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_product.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add product</a></td></tr>
                   
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_checkout.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_checkout.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage checkout</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_checkout.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_checkout.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add checkout</a></td></tr>
                    
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_inventory.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_inventory.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Purchase</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_inventory.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_inventory.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Purchase</a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_sales_product.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_sales_product.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Mangae Sales Product</a></td></tr>
                    
                     <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='sales_product.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="sales_product.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Sales Product</a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='manage_vendor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_vendor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Vendor</a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_vendor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_vendor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Vendor</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
					<tr><td onClick="location.href='consumption_qty.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="consumption_qty.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Consumption</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
					<tr><td onClick="location.href='manage_inword.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_inword.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Inward</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
					<tr><td onClick="location.href='product_inword.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_inword.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Inward</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <tr><td onClick="location.href='import_products.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_products.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Products</a></td></tr>
                    
                    
                </table>
            </div>
    </div>
    <div>
            <h3 <?php echo $complaintClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/complaint.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Complaint</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_complaint.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_complaint.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage complaint</a></td></tr>
                    
                </table>
            </div>
    </div>
	
	
	 <div>
            <h3 <?php echo $payrollClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/payroll.png" height="20" width="20"/></td><td class="width5"></td><td>Payroll</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
				<tr><td onClick="location.href='add_system_parameters.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_system_parameters.php") echo 'menu_font_selected'; else echo 'menu_font';?>"> System Parameters</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='manage_advance_deduction.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_advance_deduction.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Advance Deduction</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='advance_deduction.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="advance_deduction.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Advance Deduction</a></td></tr>
					<tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='payroll_manage_staff.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="payroll_manage_staff.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage staff</a></td></tr>
					<tr><td class="line"></td></tr>
					 <tr><td onClick="location.href='manage_attendance.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_attendance.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Attendance</a></td></tr>
					<tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='import_attendance.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_attendance.php") echo 'menu_font_selected'; else echo 'menu_font';?>"> Import Attendance</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='previous_balance_leave.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="previous_balance_leave.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Previous Leaves</a></td></tr>
					<tr><td class="line"></td></tr>
					 <tr><td onClick="location.href='manage_leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Leave Management</a></td></tr>
					<tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Leave Management</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='manage_staff_leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff Leave Management</a></td></tr>
					<tr><td class="line"></td></tr>
					  <tr><td onClick="location.href='staff_leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Staff Leave Management</a></td></tr>
					<tr><td class="line"></td></tr>
					<!-- <tr><td onClick="location.href='manage_staff_service_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_service_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff Service Incentive</a></td></tr>
					<tr><td class="line"></td></tr>
					 <tr><td onClick="location.href='staff_service_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_service_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Staff Service Incentive</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='manage_staff_product_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_product_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff Product Incentive</a></td></tr>
					<tr><td class="line"></td></tr>
					 <tr><td onClick="location.href='staff_product_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_product_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Staff Product Incentive</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='manage_staff_course_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_course_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff Course Incentive</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='staff_course_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_course_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Staff Course Incentive</a></td></tr>
					<tr><td class="line"></td></tr>
					 -->
					 <tr><td onClick="location.href='manage_staff_salary_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_salary_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff Salary Management</a></td></tr>
					<tr><td class="line"></td></tr>
					 <tr><td onClick="location.href='staff_salary_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_salary_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Staff Salary Management</a></td></tr>
					<tr><td class="line"></td></tr>
					  <tr><td onClick="location.href='make_salary.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="make_salary.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Make Salary </a></td></tr>
					<tr><td class="line"></td></tr>
					 
					 <tr><td onClick="location.href='salary_slip.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="salary_slip.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Salary Slip</a></td></tr>
					 <tr><td class="line"></td></tr>
					 
					 <tr><td onClick="location.href='salary_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="salary_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Salary Report</a></td></tr>
					                </table>
            </div>
    </div>
	
	<div>
            <h3 <?php echo $event;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/event.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Event</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_event.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_event.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Event</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_event.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_event.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Event</a></td></tr>
                </table>
            </div>
    </div>
	<div>
            <h3 <?php echo $finance_report;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/financial.png" height="20" width="20"/></td><td class="width5"></td><td>Financial Report</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='enroll_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="enroll_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enroll incomming GST</a></td></tr>
                    <tr><td class="line"></td></tr>
					<tr><td onClick="location.href='product_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product incomming GST</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='service_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Service incomming GST</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='purchase_outgoing_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="purchase_outgoing_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Purchase outgoing GST</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='expense_outgoing_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense_outgoing_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense outgoing GST</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='expense_tds.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense_tds.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense TDS</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='gst_summury_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="gst_summury_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">GST Summury Report</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='bank_summery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="bank_summery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enrollment Bank Report</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='product_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product Bank Report (Sales)</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='service_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Service Bank Report (Sales) </a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='expense_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense Bank Report </a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='purchase_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="purchase_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Purchase Bank Report  </a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='cash_transfer_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="cash_transfer_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Cash Transfer Bank Report </a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='receipt_summury_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="receipt_summury_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Receipt Summury Report </a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='all_bank_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="all_bank_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">All Bank Summury Report </a></td></tr>
                    <tr><td class="line"></td></tr>
					<tr><td onClick="location.href='bank_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="bank_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Old Bank Summury Report </a></td></tr>
                </table>
            </div>
    </div>
	
	
	<div>
            <h3 <?php echo $sms;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/sms.png" height="20" width="20"/></td><td class="width5"></td><td>SMS And Email</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='batch_specific.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="batch_specific.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Batch Specific</a></td></tr>
                    <tr><td class="line"></td></tr>
					<tr><td onClick="location.href='manage_subscriber.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_subscriber.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subscriber</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='subscriber_specific.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="subscriber_specific.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Subscriber Specific</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='manage_group.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_group.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Group</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='add_group.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_group.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Group</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='group_by_sms.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="group_by_sms.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Group By Sms</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='send_sms_email.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="send_sms_email.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Send SMS / Email</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='upload_num_excel.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="upload_num_excel.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Upload Excel</a></td></tr>
                </table>
            </div>
    </div>
	
	
	<div>
            <h3 <?php echo $campaign;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/campaign.png" height="20" width="20"/></td><td class="width5"></td><td>Campaign</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_campaign.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_campaign.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Campaign</a></td></tr>
                    <tr><td class="line"></td></tr>
					<tr><td onClick="location.href='add_campaign.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_campaign.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Campaign</a></td></tr>
					<tr><td class="line"></td></tr>
					<tr><td onClick="location.href='campaign_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="campaign_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Campaign Report</a></td></tr>
					
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
            <a href="javascript:void(0);">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td><img src="images/home_icon2.png" height="20" width="20"/></td><td class="width5"></td><td onClick="location.href='index.php'">Home</td></tr>
                </table>
            </a>
        </h3>
    </div>
   <?php 	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==1) //'for only change password'
        {?>
    		<div>
        		<h3 class="<?php echo $myAccountClass;?>" ><a href="#">
            	<table border="0" cellspacing="0" cellpadding="0">
                	<tr><td><img src="images/man_acc_icon.png" height="20" width="20"/></td><td class="width5"></td><td>My Account</td></tr>
            	</table></a>
        		</h3>
        	<div>
        	
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{
					if($array_prev[$e][$f]['privilege_id']==20)
					{
					?>
                   		<tr><td onClick="location.href='account_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Account Details</a></td></tr>
                   		<tr><td class="line"></td></tr>
                   <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==21)
					{
				   ?>
                   		<tr><td onClick="location.href='account_edit_details.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_edit_details.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Edit Details</a></td></tr>
                   		<tr><td class="line"></td></tr>
                   <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==22)
					{
				   ?>
                   		<tr><td onClick="location.href='account_change_username.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_change_username.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Username</a></td></tr>
                   		<tr><td class="line"></td></tr>
                   <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==23)
					{
				   ?>
                   		<tr><td onClick="location.href='account_change_password.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="account_change_password.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Change Password</a></td></tr>  
                   <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==24)
					{
				   ?>
                   		<tr><td onClick="location.href='wel_comecont.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="wel_comecont.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Well Come Containt </a></td></tr>
                   		<tr><td class="line"></td></tr>
                   <?php 
					}
				else if($array_prev[$e][$f]['privilege_id']==25)
					{
				   ?>
                   		<tr><td onClick="location.href='wish_image.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="wish_image.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Wish Image</a></td></tr>
                   <?php 
					}
			}
				   ?>  
            	</table>
            
        	</div>
    	</div>
    	<?
		}
	
		if($array_previ_parent[$e]['privilege_id']==2)//'Manage Courses'
    	{
		?>
    	<div>
            <h3 <?php echo $courseClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/course.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Courses</td></tr>
            </table></a>
            </h3>
            <div>
            
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
                	<?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==26)
					{
					?>
                    <tr>
                      <td onClick="location.href='course_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="course_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Course</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==27)
					{
					?>
                    <tr>
                      <td onClick="location.href='add_course.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Course</a></td></tr>               
                	<tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==28)
					{
					?>
                	<tr>
                      <td onClick="location.href='course_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="course_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Course Category</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==29)
					{
					?>
                    <tr>
                      <td onClick="location.href='add_course_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_course_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add  Course Category</a></td></tr>
                      <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==30)
					{
					?>
                       <tr><td onClick="location.href='subject_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="subject_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject</a></td></tr>
                   <tr><td class="line"></td></tr>
                   <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==31)
					{
					?>
                    <tr><td onClick="location.href='subject_add.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="subject_add.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject</a></td></tr>
                	<tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==32)
					{
					?>
                 	<tr><td onClick="location.href='topic_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="topic_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Topic</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==33)
					{
					?>
                    <tr><td onClick="location.href='add_topic.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_topic.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Topic</a></td></tr>
                	<tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==34)
					{
					?>
                    <tr>
                      <td onClick="location.href='batch_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="batch_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Batch</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==35)
					{
					?>
                    <tr>
                      <td onClick="location.href='add_batch.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_batch.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Batch</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==36)
					{
					?>
                    <tr>
                      <td onClick="location.href='import_all.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_all.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Course</a></td></tr>
               		<?php
					}
				}
					?>	
                </table>
            
            </div>
    </div>
    
    <?php
	/*}
if($array_prev[$e]['privilege_id']==3)//'my Subject'
    {*/
	?>
   <!-- <div>
            <h3 <?php// echo $subjectClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/city_small.png" /></td><td class="width5"></td><td>Manage Subject</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='subject_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="subject_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='subject_add.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="subject_add.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject</a></td></tr>
                <tr><td class="line"></td></tr>
                </table>
            </div>
  </div>-->
  
  <?php
	}
if($array_previ_parent[$e]['privilege_id']==3)//'Manage Student'
    {
	?>
    <div>
            <h3 <?php echo $studentClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/student.png" height="20" width="20"/></td><td class="width5"></td>
                  <td>Manage Student</td></tr>
            </table></a>
            </h3>
            <div>
            
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{
					if($array_prev[$e][$f]['privilege_id']==38)
					{
					?>
                    <tr><td onClick="location.href='inquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="inquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Enquiry</a></td></tr>
                	<tr><td class="line"></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==37)
					{
					?>
                    <tr><td onClick="location.href='manage_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Enquiries</a></td></tr>
                	<tr><td class="line"></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==39)
					{
					?>
                    <tr><td onClick="location.href='manage_enroll.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_enroll.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Enrolled Student</a></td></tr>
                	<tr><td class="line"></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==40)
					{
					?>
                    <!--<tr><td onClick="location.href='enroll.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="enroll.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enrollment Form</a></td></tr>
                 	<tr><td class="line"></td></tr>-->
                    <tr><td onClick="location.href='enroll_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="enroll_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enrollment Form <!--<img src="images/new.gif" />--></a></td></tr>
                 	<tr><td class="line"></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==41)
					{
					?>
                    <tr><td onClick="location.href='logsheet.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="logsheet.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Logsheet</a></td></tr>
               		<tr><td class="line"></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==42)
					{
					?>
                    <tr><td onClick="location.href='online_trans_summery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="online_trans_summery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Online Transaction Summery</a></td></tr>
                	<tr><td class="line"></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==43)
					{
					?>
                    <tr><td onClick="location.href='followup_summery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="followup_summery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Followup Summery</a></td></tr>
                	<tr><td class="line"></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==44)
					{
					?>
                    <tr><td onClick="location.href='followup_record.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="followup_record.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Followup Report</a></td></tr>
                	<tr><td class="line"></td></tr>
                 	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==45)
					{
					?>
                 	<tr><td onClick="location.href='import_student.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_student.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Student</a></td></tr>
                	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==239)
					{
					?>
                 	<tr><td onClick="location.href='import_campaign_inquiries.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_campaign_inquiries.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Campaign Enquiries</a></td></tr>
                	<?php
					}
				}
					?>
                    </table>
         
            </div>
    </div>
    <?php
	/*}
if($array_prev[$e]['privilege_id']==6)//'my courses'
    {*/
	?>
    <!--<div>
            <h3 <?php //echo $topicClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/city_small.png" /></td><td class="width5"></td><td>Manage Topic</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='topic_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="topic_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Topic</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_topic.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_topic.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Topic</a></td></tr>
                <tr><td class="line"></td></tr>
                </table>
            </div>
     </div>
   -->
    <?php 
	/*}
if($array_previ_parent[$e]['privilege_id']==4)//Manage Download'
    {*/
	?>
    <!--<div>
            <h3 <?php //echo $downloadClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Download</td></tr>
            </table></a>
            </h3>
            <div>
                
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				/*for($f=0;$f<count($array_prev[$e]);$f++)
    			{
				 
					if($array_prev[$e][$f]['privilege_id']==46)
					{*/
					?>
                    <tr><td onClick="location.href='manage_download.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_download.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Download</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					/*}
					else if($array_prev[$e][$f]['privilege_id']==47)
					{*/
					?>
                    <tr><td onClick="location.href='add_download.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_download.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Download</a></td></tr>
                    <?php 
					//}
					?>

				<?php 
				//} 
				?>
                </table>
            
            
            </div>
    </div>-->
    
    <?php
	/*}
if($array_prev[$e]['privilege_id']==8)//'my courses'
    {*/
	?>
   <!-- <div>
            <h3 <?php //echo $quetionClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr><td><img src="images/paper.png" /></td><td class="width5"></td><td>Manage Subject Question </td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                 <tr><td onClick="location.href='create_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="create_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject Questions </a></td></tr>
                </table>
            </div>
    </div>-->
    
    
    <?php
	//}
//if($array_prev[$e]['privilege_id']==6)//'my courses'
   // {
	?>
 <!--    <div>
            <h3 <?php //echo $sub_admin;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage SubAdmin</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_subadmin.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_subadmin.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SubAdmin</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_subadmin.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_subadmin.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add SubAdmin</a></td></tr>
                </table>
            </div>
    </div>
    <?php 
	/*}
	if($array_prev[$e]['privilege_id']==19)//'my courses'
    {*/
	?>
     <div>
            <h3 <?php //echo $noticeClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Councellor</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_councellor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_councellor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Councellor </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_councellor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_councellor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Councellor </a></td></tr>
                </table>
            </div>
    </div>
    
     <?php 
	/*}
	if($array_prev[$e]['privilege_id']==20)//'my courses'
    {*/
	?>
     <div>
            <h3 <?php //echo $councellor;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage BOP</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_bop.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_bop.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage BOP </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_bop.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_bop.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add BOP </a></td></tr>
                </table>
            </div>
            
    </div>-->
    
   
    <?php
	/*}
	if($array_previ_parent[$e]['privilege_id']==5)//'Manage Exam'
    {*/
	?>
    <!-- <div>
            <h3 <?php //echo $examsClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/sitemap_min.png" /></td><td class="width5"></td><td>Manage Exam </td></tr>
            </table></a>
            </h3>
            <div>
            
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
				<?php 
               /* for($f=0;$f<count($array_prev[$e]);$f++)
                {
				
				
					if($array_prev[$e][$f]['privilege_id']==48)
					{*/
					?>
                    <tr><td onClick="location.href='manage_exam.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_exam.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==49)
					{*/
					?>
                    <tr><td onClick="location.href='add_exam.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_exam.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Exam</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==50)
					{*/
					?>
                    <tr><td onClick="location.href='manage_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subject Questions</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==51)
					{*/
					?>
                 	<tr><td onClick="location.href='create_question.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="create_question.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Subject Questions </a></td></tr>
                  	<tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==52)
					{*/
					?>
                    <tr><td onClick="location.href='manage_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Question Paper</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==53)
					{*/
					?>
                    <tr><td onClick="location.href='create_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php// if($page_name=="create_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Question Paper</a></td></tr>
                    <?php
					//}
					?>
                <?php
				//}
				?>
                </table>
            </div>
    </div>-->
    <?php
	/*}
if($array_prev[$e]['privilege_id']==10)//'my courses'
    {*/
	?>
   <!-- <div>
            <h3 <?php //echo $papaersClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/Faq-16.png" /></td><td class="width5"></td><td>Manage Question Paper</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Question Paper</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='create_paper.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="create_paper.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Question Paper</a></td></tr>
                </table>
            </div>
    </div>-->
   <?php
	/*}
if($array_prev[$e]['privilege_id']==12)//'my courses'
    {*/
	?>
   <!-- <div>
            <h3 <?php //echo $photoClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16-16_banner_design.png" /></td><td class="width5"></td>
                <td>Manage Picture Gallery</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='manage_photo.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_photo.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Picture Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='add_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Picture Gallery</a></td></tr>
                    <tr><td onClick="location.href='add-images-in-gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add-images-in-gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Picture </a></td></tr>

                </table>
            </div>
    </div>-->
    <?php
	/*}
if($array_previ_parent[$e]['privilege_id']==6)//'Manage Video Gallery'
    {*/
	?>
   <!-- <div>
           <h3 <?php //echo $photoClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16-16_banner_design.png" /></td><td class="width5"></td>
                <td>Manage Gallery</td></tr>
            </table></a>
            </h3>
            <div>
            
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
            	<?php 
				/*for($f=0;$f<count($array_prev[$e]);$f++)
    			{
				 
					if($array_prev[$e][$f]['privilege_id']==54)
					{*/
					?>
                    <tr><td onClick="location.href='manage_photo.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_photo.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Picture Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					/*}
					else if($array_prev[$e][$f]['privilege_id']==55)
					{*/
					?>
                    <tr><td onClick="location.href='add_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Picture Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					/*}
					else if($array_prev[$e][$f]['privilege_id']==56)
					{*/
					?>
                    <tr><td onClick="location.href='add-images-in-gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add-images-in-gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Picture </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					/*}
					else if($array_prev[$e][$f]['privilege_id']==57)
					{*/
					?>
					<tr><td onClick="location.href='manage_vedio_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_vedio_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Video Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <?php 
					/*}
					else if($array_prev[$e][$f]['privilege_id']==58)
					{*/
					?>
                    <tr><td onClick="location.href='add_vedio_gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_vedio_gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Video Gallery</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					/*}
					else if($array_prev[$e][$f]['privilege_id']==59)
					{*/
					?>
                    <tr><td onClick="location.href='add-videos-in-gallery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add-videos-in-gallery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Video </a></td></tr>
                	 <?php 
					/*}
					
				}*/
				?>
                    
                </table>
            </div>
    </div>-->
    <?php
	/*}
if($array_previ_parent[$e]['privilege_id']==7)//'manage Menu'
    {*/
	?>
    <!--<div>
            <h3 <?php //echo $menuClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16-16_banner_design.png" /></td><td class="width5"></td>
                <td>Manage Menu</td></tr>
            </table></a>
            </h3>
            <div>
            
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
            	<?php 
				/*for($f=0;$f<count($array_prev[$e]);$f++)
    			{
				 
					if($array_prev[$e][$f]['privilege_id']==60)
					{*/
					?>
                    <tr><td onClick="location.href='manage_menu.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_menu.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Menu</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==61)
					{*/
					?>
                    <tr><td onClick="location.href='add_menu.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_menu.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Menu</a></td></tr>
                	<?php
					/*}
				}*/
					?>
                </table>
            </div>
    </div>-->
    <?php
	/*}
if($array_previ_parent[$e]['privilege_id']==8)//'Manage Pages'
    {*/
	?>
    <!--<div>
            <h3 <?php //echo $pageClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Pages</td></tr>
            </table></a>
            </h3>
            <div>
                
            	<table border="0" cellspacing="5" cellpadding="0" width="100%">
            <?php 
			/*for($f=0;$f<count($array_prev[$e]);$f++)
    		{ 
					if($array_prev[$e][$f]['privilege_id']==62)
					{*/
					?>
                    <tr><td onClick="location.href='manage_pages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_pages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Pages</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==63)
					{*/
					?>
                    <tr><td onClick="location.href='add_pages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_pages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Pages</a></td></tr>
                	<?php 
					/*}
			}*/
					?>
                </table>
            </div>
    </div>-->
    <?php
	/*}
if($array_previ_parent[$e]['privilege_id']==9)//'Manage Slider'
    {*/
	?>
    <!--<div>
            <h3 <?php //echo $sliderClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Slider</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
			/*for($f=0;$f<count($array_prev[$e]);$f++)
    		{ 
					if($array_prev[$e][$f]['privilege_id']==64)
					{*/
					?>
                    <tr><td onClick="location.href='manage_slider.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_slider.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Slider</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==65)
					{*/
					
					?>
                    <tr><td onClick="location.href='add_slider.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_slider.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Slider</a></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==66)
					{*/
					
					?>
                    <tr><td onClick="location.href='add_image_slider.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_image_slider.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Image To Slider</a></td></tr>
					<?php
					/*}
			}*/
					?>
                </table>
            </div>
    </div>-->
     <?php
	/*}
if($array_previ_parent[$e]['privilege_id']==10)//'Manage Testimonial'
    {*/
	?>
     <!--<div>
            <h3 <?php //echo $testimonialClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Testimonial</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				/*for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==67)
					{*/
					?>
                    <tr><td onClick="location.href='manage_testimonial.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_testimonial.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Testimonial</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					/*}
				}*/
					?>
                </table>
            </div>
            
    </div>-->
     <?php
	/*}
if($array_previ_parent[$e]['privilege_id']==11)//'Manage Notice'
    {*/
	?>
     <!--<div>
            <h3 <?php //echo $noticeClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>Manage Notice</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				/*for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==68)
					{*/
					?>
                    <tr><td onClick="location.href='manage_notice.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_notice.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Notice </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==69)
					{*/
					?>
                    <tr><td onClick="location.href='add_notice.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_notice.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Notice </a></td></tr>
                     <?php
					/*}
				}*/
					?>
                </table>
            </div>
    </div>-->
    
   
    
    
     <?php
	}
 
if($array_previ_parent[$e]['privilege_id']==12)//'General Setting'
    {
	?>
     <div>
           <h3 <?php echo $generalClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/general.png" height="20" width="20"/></td><td class="width5"></td><td>General Setting</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==70)
					{
					?>
                    <tr><td onClick="location.href='manage_source.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_source.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Source </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==71)
					{
					?>
					
                    <tr><td onClick="location.href='add_source.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_source.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Source </a></td></tr>
                     <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==72)
					{
					?>
                     <tr><td onClick="location.href='manage_branch.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_branch.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Branch </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==73)
					{
					?>
                    <tr><td onClick="location.href='add_branch.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_branch.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Branch </a></td></tr>
                    <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==74)
					{
					?>
                     <tr><td onClick="location.href='manage_tax.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_tax.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Tax </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==75)
					{
					?>
                    <tr><td onClick="location.href='add_tax.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_tax.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Tax </a></td></tr>
                    <tr><td class="line"></td></tr>
                    
					<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==76)
					{
					?>
                    <tr><td onClick="location.href='manage_discount.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_discount.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Discount Coupon </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==77)
					{
					?>
                    <tr><td onClick="location.href='add_discount.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_discount.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Discount Coupon</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==78)
					{
					?>
                    <tr><td onClick="location.href='manage_batch_time.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_batch_time.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Batch Time </a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==79)
					{
					?>
                    <tr><td onClick="location.href='add_batch_time.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_batch_time.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Batch Time</a></td></tr>
                     <tr><td class="line"></td></tr>
                     
					
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==84)
					{
					?>
                    <tr><td onClick="location.href='manage_lab.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_lab.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Lab</a></td></tr>
                     <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==85)
					{
					?>
                    <tr><td onClick="location.href='add_lab.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_lab.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Lab</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==161)
					{
					?>
					<tr><td onClick="location.href='rewards_point_config.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="rewards_point_config.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Rewards Point</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==160)
					{
					?>
                    <tr><td onClick="location.href='rewards_value_config.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="rewards_value_config.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Reward Value</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==174)
					{
					?>
                    <tr><td onClick="location.href='manage_sac_code.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_sac_code.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SAC code</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==88)
					{
					?>
                    <tr><td onClick="location.href='add_sallary.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_sallary.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Sallary</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==89)
					{
					?>
                    <tr><td onClick="location.href='add_tax_type.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_tax_type.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Tax Type</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==90)
					{
					?>
                    <tr><td onClick="location.href='manage_tax_type.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_tax_type.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Tax Type</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==142)
					{
					?>
                    <tr><td onClick="location.href='responce_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="responce_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Responce</a></td></tr>
                    <?php
					}
				}
					?>
                </table>
            </div>
    </div>
    
     <?php
	}
	
	if($array_previ_parent[$e]['privilege_id']==13)//'my User'
    {
	?>
     <div>
            <h3 <?php echo $privilagesClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/pre.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Previlages</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==91)
					{
					?>
                    <tr><td onClick="location.href='privilages_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="privilages_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Previlages</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==92)
					{

					?>
                    <tr><td onClick="location.href='add_privilages.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_privilages.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Previlages</a></td></tr>
                    <?php
					}
				}
					?>
                </table>
            </div>
    </div>
   
     <?php 
	}
    if($array_previ_parent[$e]['privilege_id']==14)//'my User'
    {
	?>
     <div>
            <h3 <?php echo $user;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/users.png" height="20" width="20"/></td><td class="width5"></td><td>Manage User/Staff</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                     <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==93)
					{
					?>
                    <tr><td onClick="location.href='manage_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage User</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==94)
					{
					?>
                    <tr><td onClick="location.href='add_user.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_user.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add User</a></td></tr>
                    <?php
					}
					
				}
					?>
                </table>
            </div>
    </div>
    
    
     <?php
	/*}
if($array_previ_parent[$e]['privilege_id']==15)//'my User'
    {*/
	?>
     <!--<div>
            <h3 <?php //echo $sms;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/16_pages.png" /></td><td class="width5"></td><td>SMS Log</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				/*for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==95)
					{*/
					?>
                    <tr><td onClick="location.href='manage_sms.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="manage_sms.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage SMS</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==96)
					{*/
					
					?>
                    <tr><td onClick="location.href='send sms.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="send sms.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Send SMS</a></td></tr>
                    <?php
					/*}
				}*/
					?>
                </table>
            </div>
    </div>-->
    
     <?php
	}
if($array_previ_parent[$e]['privilege_id']==16)//'Report'
    {
	?>
     <div>
            <h3 <?php echo $reportClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/city.png" height="20px" width="20px"/></td><td class="width5"></td><td>Manage Report</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                 <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==97)
					{
					?>
                    <tr><td onClick="location.href='manage_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==98)
					{
					?>
                    <tr><td onClick="location.href='total_enrollment.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_enrollment.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Total Enrollment</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==99)
					{
					?>
                    <tr><td onClick="location.href='total_enquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_enquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Total Enquiry</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==100)
					{
					?>
                    <!-- <tr><td onClick="location.href='total_source.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_source.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Source Report</a></td></tr> -->
					<tr><td onClick="location.href='campaign_main_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="campaign_main_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Campaign Report</a></td></tr>
                    <tr><td class="line"></td></tr>
					
					
					<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==148)
					{
					?>
                    <tr><td onClick="location.href='lead.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="lead.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Lead Grade Report</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==149)
					{
					?>
                    <tr><td onClick="location.href='outstand_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="outstand_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Outstanding Report</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==248)
					{
					?>
                    <tr><td onClick="location.href='product_outstand_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_outstand_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product Outstanding Report</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==154)
					{
					?>
                    <tr><td onClick="location.href='total_sales_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_sales_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Total Sales Report</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==150)
					{
					?>
                    <tr><td onClick="location.href='package_service.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="package_service.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Package Service Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==101)
					{
					?>
                    <tr><td onClick="location.href='total_response.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="total_response.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Response Category Report</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==102)
					{
					?>
                     <tr><td onClick="location.href='manage_expense.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_expense.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Expense</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==103)
					{
					?>
                    <tr><td onClick="location.href='dsr_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="dsr_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage DSR</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==143)
					{
					?>
                    <tr><td onClick="location.href='checkout_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="checkout_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Checkout Report</a></td></tr>
					 <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==176)
					{
					?>
                    <tr><td onClick="location.href='consumption_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="consumption_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Consumption Report</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==144)
					{
					?>
                    <tr><td onClick="location.href='checkout_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="checkout_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Service & Sales Report</a></td></tr>
					
					<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==153)
					{
					?>
                    <tr><td onClick="location.href='audit_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="audit_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Audit Report</a></td></tr>
                    <?php
					}
				}
					?>
                </table>
            </div>
    </div>
    <?php
	}
/*if($array_prev[$e]['privilege_id']==17)//'my User'
    {*/
	?>
    <!-- <div>
            <h3 <?php //echo $staffClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                  <tr><td><img src="images/news-subscribe_min.png" /></td><td class="width5"></td><td>Manage Staff</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <tr><td onClick="location.href='staff_manage.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="staff_manage.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <tr><td onClick="location.href='staff_registration.php'" class="menu_font"><a href="javascript:void(0);" class="<?php //if($page_name=="add_savings.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add staff</a></td></tr>
                </table>
            </div>
    </div>-->
     <?php
	//}
if($array_previ_parent[$e]['privilege_id']==17)//'my User'
    {
	?>
    <div>
            <h3 <?php echo $expenseClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/expense.png" height="20px" width="20px"/></td><td class="width5"></td><td>Manage Expense and Bank</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                	
                <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==104)
					{
					?>
                    <tr>
                    <td onClick="location.href='receipt.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="receipt.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Receipt</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==105)
					{
					?>
                    <tr><td onClick="location.href='expense.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==106)
					{
					?>
                    <tr><td onClick="location.href='cash_transfer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="cash_transfer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Cash Transfer</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==107)
					{
					?>
                    <tr><td onClick="location.href='payment_mode.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="payment_mode.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Payment Mode</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==108)
					{
					?>
                    <tr><td onClick="location.href='expense_type.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense_type.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Expense Type</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==109)
					{
					?>
                    <tr><td onClick="location.href='manage_bank_account.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_bank_account.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Bank Account</a></td></tr>
                    <tr><td class="line"></td></tr>
                    
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==110)
					{
					?>
                    <tr><td onClick="location.href='import_expense.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_expense.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Expense</a></td></tr>
                	<?php
					}
				}
					?>
                </table>
            </div>
    </div>
    
    
     <?php
	}
	if($array_previ_parent[$e]['privilege_id']==18)//'my User'
    {
	?>
    
     <div>
            <h3 <?php echo $servicesClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/service.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Services</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==177)
					{
					?>
					<tr><td onClick="location.href='manage_service_inquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_service_inquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Service Inquiry</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==178)
					{
					?>
					<tr><td onClick="location.href='service_inquiry.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_inquiry.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Inquiry</a></td></tr>
                    <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==111)
					{
					?>
                	<tr><td onClick="location.href='manage_cust_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_cust_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Customer Services</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					
					else if($array_prev[$e][$f]['privilege_id']==145)
					{
					
					?>
                    <tr><td onClick="location.href='book_service.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="book_service.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Book Services</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==113)
					{
					
					?>
                	 <tr><td onClick="location.href='manage_services_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_services_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Services Category </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==114)
					{
					
					?>
                    <tr><td onClick="location.href='add_service_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_service_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Services Category</a></td></tr>
                   
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==115)
					{
					
					?>
                    <tr><td onClick="location.href='manage_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Services </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==116)
					{
					
					?>
                    <tr><td onClick="location.href='add_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Services </a></td></tr>
                    
                   
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==117)
					{
					
					?>
                    <tr><td onClick="location.href='manage_customer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_customer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Customer </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==118)
					{
					
					?>
                    <tr><td onClick="location.href='add_customer.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_customer.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Customer</a></td></tr>
                    
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==119)
					{
					
					?>
                    <tr><td onClick="location.href='manage_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Membership </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==120)
					{
					
					?>
                    <tr><td onClick="location.href='add_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Membership</a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==121)
					{
					
					?>
                    <tr><td onClick="location.href='manage_customer_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_customer_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Customer Membership </a></td></tr>
                    
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==122)
					{
					
					?>
                    <tr><td onClick="location.href='add_customer_membership.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_customer_membership.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Customer Membership</a></td></tr>
                     <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==123)
					{
					
					?>
                     <tr><td onClick="location.href='manage_package.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_package.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Package</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==124)
					{
					?>
                    
                    <tr><td onClick="location.href='add_package.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_package.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Package</a></td></tr>
                     <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==125)
					{
					
					?>
                    
                    <tr><td onClick="location.href='add_voucher.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_voucher.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Voucher</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==126)
					{
					
					?>
                    
                    <tr><td onClick="location.href='manage_memb_package_voucher.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_memb_package_voucher.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Package/ Voucher/ Membership</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==127)
					{
					
					?>
                    <tr><td onClick="location.href='sale_memb_package_voucher.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="sale_memb_package_voucher.php.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Sale Package/ Voucher/ Membership</a></td></tr>
                     <tr><td class="line"></td></tr>
                     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==128)
					{
					
					?>
                    
                    <tr><td onClick="location.href='import_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Services</a></td></tr>
                <?php
					}
					
					else if($array_prev[$e][$f]['privilege_id']==246)
					{
					
					?>
                    
                    <tr><td onClick="location.href='import_campaign_services.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_campaign_services.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Campaign Services</a></td></tr>
                <?php
					}
				}
					?>
                </table>
            </div>
            
    </div>
    
    
    <?php
	}
	if($array_previ_parent[$e]['privilege_id']==19)//'my User'
    {
	?>
	<div>
            <h3 <?php echo $productClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/product.png" height="20px" width="20px"/></td><td class="width5"></td><td>Manage product</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==129)
					{
					?>
                    <tr><td onClick="location.href='manage_product_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_product_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage product_category</a></td></tr>
                    <tr><td class="line"></td></tr>
                  	<?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==130)
					{
					?>
                    <tr><td onClick="location.href='add_product_category.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_product_category.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product Category</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==131)
					{
					?>
                    <tr><td onClick="location.href='manage_product.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_product.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Product</a></td></tr>
                    <tr><td class="line"></td></tr>
                  	<?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==132)
					{
					?>
                    <tr><td onClick="location.href='add_product.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_product.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add product</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==133)
					{
					?>
                    <tr><td onClick="location.href='manage_checkout.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_checkout.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage checkout</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==134)
					{
					?>
                    <tr><td onClick="location.href='add_checkout.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_checkout.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add checkout</a></td></tr>
                    
                     <tr><td class="line"></td></tr>
                     <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==135)
					{
					?>
                    <tr><td onClick="location.href='manage_inventory.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_inventory.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Purchase</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==136)
					{
					?>
                    <tr><td onClick="location.href='add_inventory.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_inventory.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Purchase</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==137)
					{
					?>
                    <tr><td onClick="location.href='manage_inventory.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_inventory.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Sales Product</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==138)
					{
					?>
                    <tr><td onClick="location.href='add_inventory.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_inventory.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Sale Product</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']=='139')
					{
					?>
                    <tr><td onClick="location.href='manage_vendor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_vendor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Vendor</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']=='140')
					{
					?>
                    <tr><td onClick="location.href='add_vendor.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_vendor.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Vendor</a></td></tr>
                     <tr><td class="line"></td></tr>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==249)
					{
						?><tr><td onClick="location.href='manage_inword.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_inword.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Inward</a></td></tr>
                    	<tr><td class="line"></td></tr>
                    	<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==250)
					{
						?>
                        <tr><td onClick="location.href='product_inword.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_inword.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Inward</a></td></tr>
                    	<tr><td class="line"></td></tr>
                        <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==141)
					{
						?>
						<tr><td onClick="location.href='import_products.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_products.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Products</a></td></tr>
						<?php 
					}
				}
					?>
                </table>
            </div>
    </div>
	<?php
	}
	if($array_previ_parent[$e]['privilege_id']==158)//'my User'
    {
	?>
     <div>
            <h3 <?php echo $complaintClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/complaint.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Complaint</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==159)
					{
					?>
                    <tr><td onClick="location.href='manage_complaint.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_complaint.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Complaint</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					
					}
				}
					?>
                </table>
            </div>
    </div>
	<?php
	}
	if($array_previ_parent[$e]['privilege_id']==203)//'payroll'
    {
	?>
     <div>
            <h3 <?php echo $payrollClass;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/payroll.png" height="20" width="20"/></td><td class="width5"></td><td>Payroll</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                    <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==204)
					{
					?>
                    
					 <tr><td onClick="location.href='add_system_parameters.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_system_parameters.php") echo 'menu_font_selected'; else echo 'menu_font';?>">System Parameters</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php }
					else if($array_prev[$e][$f]['privilege_id']==225)
					{
					?>
                    
					 <tr><td onClick="location.href='manage_advance_deduction.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_advance_deduction.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Advance Deduction</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php } else if($array_prev[$e][$f]['privilege_id']==205)
					{
					?>
					<tr><td onClick="location.href='advance_deduction.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="advance_deduction.php") echo 'menu_font_selected'; else echo 'menu_font';?>"> Advance Deduction</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php } else if($array_prev[$e][$f]['privilege_id']==206)
					{
					?>
					<tr><td onClick="location.href='payroll_manage_staff.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="payroll_manage_staff.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff details</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php } else if($array_prev[$e][$f]['privilege_id']==207)
					{
					?>
					<tr><td onClick="location.href='manage_attendance.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_attendance.php") echo 'menu_font_selected'; else echo 'menu_font';?>">manage Attendance</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php } else if($array_prev[$e][$f]['privilege_id']==208)
					{
					?>
					<tr><td onClick="location.href='import_attendance.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="import_attendance.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Import Attendance</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php } else if($array_prev[$e][$f]['privilege_id']==209)
					{
					?>
					<tr><td onClick="location.href='previous_balance_leave.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="previous_balance_leave.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Previous Leaves</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php } else if($array_prev[$e][$f]['privilege_id']==210)
					{
					?>
					<tr><td onClick="location.href='manage_leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Leaves</a></td></tr>
                    <tr><td class="line"></td></tr>
					<?php } else if($array_prev[$e][$f]['privilege_id']==211)
					{
					?>
					<tr><td onClick="location.href='leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Leaves</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==212)
					{
					?>
					<tr><td onClick="location.href='manage_staff_leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Staff Leaves</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==213)
					{
					?>
					<tr><td onClick="location.href='staff_leave_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_leave_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Staff Leaves</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					/* else if($array_prev[$e][$f]['privilege_id']==214)
					{
					?>
					<tr><td onClick="location.href='manage_staff_service_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_service_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Service Incentive</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==215)
					{
					?>
					<tr><td onClick="location.href='staff_service_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_service_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Service Incentive</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==216)
					{
					?>
					<tr><td onClick="location.href='manage_staff_product_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_product_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage product Incentive</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==217)
					{
					?>
					<tr><td onClick="location.href='staff_product_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_product_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Product Incentive</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==218)
					{
					?>
					<tr><td onClick="location.href='manage_staff_course_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_course_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Course Incentive</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==219)
					{
					?>
					<tr><td onClick="location.href='staff_course_incentive.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_course_incentive.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Course Incentive</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}  */
					else if($array_prev[$e][$f]['privilege_id']==220)
					{
					?>
					<tr><td onClick="location.href='manage_staff_salary_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_staff_salary_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Salary Management</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==221)
					{
					?>
					<tr><td onClick="location.href='staff_salary_management.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="staff_salary_management.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Salary</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==222)
					{
					?>
					<tr><td onClick="location.href='make_salary.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="make_salary.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Make Salary</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==223)
					{
					?>
					<tr><td onClick="location.href='salary_slip.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="salary_slip.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Salary Slip</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==224)
					{
					?>
					<tr><td onClick="location.href='salary_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="salary_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Salary Report</a></td></tr>
                    
                    <?php
					}
					}
				
					?>
                </table>
            </div>
    </div>
	<?php
	}
	if($array_previ_parent[$e]['privilege_id']==191)//'my User'
    {
	?>
     <div>
            <h3 <?php echo $event;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/event.png" height="20" width="20"/></td><td class="width5"></td><td>Manage Event</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                     <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==192)
					{
					?>
                    <tr><td onClick="location.href='manage_event.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_event.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Event</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==193)
					{
					?>
                    <tr><td onClick="location.href='add_event.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_event.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Event</a></td></tr>
                    <?php
					}
					
				}
					?>
                </table>
            </div>
    </div>
     <?php
	}
	if($array_previ_parent[$e]['privilege_id']==196)//'my User'
    {
	?>
     <div>
            <h3 <?php echo $finance_report;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/financial.png" height="20" width="20"/></td><td class="width5"></td><td>Financial Report</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                     <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==197)
					{
					?>
                    <tr><td onClick="location.href='enroll_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="enroll_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enroll incomming GST</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==198)
					{
					?>
                    <tr><td onClick="location.href='product_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product incomming GST</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==199)
					{
					?>
                    <tr><td onClick="location.href='service_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Service Incomming GST</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==200)
					{
					?>
                    <tr><td onClick="location.href='service_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Purchase Outgoing GST</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==201)
					{
					?>
                    <tr><td onClick="location.href='service_incomming_gst.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_incomming_gst.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense Outgoing GST</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==202)
					{
					?>
                    <tr><td onClick="location.href='expense_tds.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense_tds.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense TDS</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==240)
					{
					?>
                    <tr><td onClick="location.href='bank_summery.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="bank_summery.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Enrollment Bank Report </a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==241)
					{
					?>
                    <tr><td onClick="location.href='product_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="product_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Product Bank Report (sales) </a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==242)
					{
					?>
                    <tr><td onClick="location.href='service_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="service_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Service Bank Report (sales) </a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==243)
					{
					?>
                    <tr><td onClick="location.href='expense_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="expense_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Expense Bank Report </a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==244)
					{
					?>
                    <tr><td onClick="location.href='purchase_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="purchase_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Purchase Bank Report </a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==245)
					{
					?>
                    <tr><td onClick="location.href='cash_transfer_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="cash_transfer_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Cash Transfer Bank Report </a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==247)
					{
					?>
                    <tr><td onClick="location.href='gst_summury_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="gst_summury_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">GST Summery Report</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==251)
					{
					?>
                    <tr><td onClick="location.href='receipt_summury_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="receipt_summury_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Receipt Summery Report</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==252)
					{
					?>
                    <tr><td onClick="location.href='all_bank_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="all_bank_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">All Bank Summery Report</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==253)
					{
					?>
                    <tr><td onClick="location.href='bank_summery_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="bank_summery_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Old Bank Summery Report</a></td></tr>
                    <?php
					}
					
				}
					?>
                </table>
            </div>
    </div>
     <?php
	}
	
	if($array_previ_parent[$e]['privilege_id']==226)//'my User'
    {
	?>
     <div>
            <h3 <?php echo $sms;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/sms.png" height="20" width="20"/></td><td class="width5"></td><td>SMS And Email</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                     <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==227)
					{
					?>
                    <tr><td onClick="location.href='batch_specific.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="batch_specific.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Batch Specific</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==228)
					{
					?>
                    <tr><td onClick="location.href='manage_subscriber.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_subscriber.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Subscriber</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==229)
					{
					?>
                    <tr><td onClick="location.href='subscriber_specific.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="subscriber_specific.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Subscriber Specific</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==230)
					{
					?>
                    <tr><td onClick="location.href='manage_group.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_group.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Group</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==231)
					{
					?>
                    <tr><td onClick="location.href='add_group.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_group.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Group</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==232)
					{
					?>
                    <tr><td onClick="location.href='group_by_sms.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="group_by_sms.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Group By SMS</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==233)
					{
					?>
                    <tr><td onClick="location.href='send_sms_email.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="send_sms_email.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Send SMS / Email</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==234)
					{
					?>
                    <tr><td onClick="location.href='upload_num_excel.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="upload_num_excel.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Upload Excel</a></td></tr>
                    <?php
					}
					
				}
					?>
                </table>
            </div>
    </div>
     <?php
	}
	
	if($array_previ_parent[$e]['privilege_id']==235)//'my User'
    {
	?>
     <div>
            <h3 <?php echo $campaign;?> ><a href="#">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/campaign.png" height="20" width="20"/></td><td class="width5"></td><td>Campaign</td></tr>
            </table></a>
            </h3>
            <div>
                <table border="0" cellspacing="5" cellpadding="0" width="100%">
                     <?php 
				for($f=0;$f<count($array_prev[$e]);$f++)
    			{ 
					if($array_prev[$e][$f]['privilege_id']==236)
					{
					?>
                    <tr><td onClick="location.href='manage_campaign.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="manage_campaign.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Manage Campaign</a></td></tr>
                    <tr><td class="line"></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==237)
					{
					?>
                    <tr><td onClick="location.href='add_campaign.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="add_campaign.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Add Campaign</a></td></tr>
                    <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==238)
					{
					?>
                    <tr><td onClick="location.href='campaign_report.php'" class="menu_font"><a href="javascript:void(0);" class="<?php if($page_name=="campaign_report.php") echo 'menu_font_selected'; else echo 'menu_font';?>">Campaign Report</a></td></tr>
                    <?php
					}
					
					
				}
					?>
                </table>
            </div>
    </div>
     <?php
	}
	
	} ?>
	
	
      </div>
</div>

<?php
 }
 ?>
</div>
