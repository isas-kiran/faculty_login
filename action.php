<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='37'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
.hr_line { border: 0; border-bottom: 1px dashed #ccc; background: #999; }
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Action Form</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<!--<script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <!--<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>-->
    <script>
	jQuery(document).ready( function() 
	{
		//$("#counc1_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
	
</script>
	<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
	{
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		//   $('input:radio[name=free_course][value=N]').click();
		//   $('input:radio[name=discount_course][value=Y]').click();
		//   $('input:radio[name=status][value=Inactive]').click();
	});
    </script>
   	<script>
	function calc_grade(enroll_id,course_id,ids)
	{
		//alert(course_id);
		var is_print=document.getElementById('is_print'+course_id+'').value;
		var enroll_id=enroll_id;
		var theory_mark=document.getElementById('theory_grade_'+course_id+'_'+ids+'').value;
		var practical_mark=document.getElementById('practical_grade_'+course_id+'_'+ids+'').value;
		if(theory_mark!='' && practical_mark!='')
		{
			var data12="action=basic_course&course_id="+course_id+"&ids="+ids+"&theory_mark="+theory_mark+"&practical_mark="+practical_mark+"&enroll_id="+enroll_id+"&is_print="+is_print;
			//alert(data12);
			$.ajax({
				url: "get_grade_calculation.php", type: "post", data: data12, cache: false,
				success: function (html)
				{
					//alert(html);
					var res=html.split("##");
					document.getElementById('theory_per_'+course_id+'_'+ids+'').value=res[0];
					document.getElementById('practical_per_'+course_id+'_'+ids+'').value=res[1];
					tots=parseInt(res[0])+parseInt(res[1]);
					
					document.getElementById('tot_per_'+course_id+'').value=tots;
					document.getElementById('tot_sub_grade_'+course_id+'').value=res[2];
					document.getElementById('grade_status_'+course_id+'').innerHTML=res[2];			
					//alert(res[3]);
				}
			});
		}
		else
		{
			alert("Please Enter Theory Mark and Practical Mark");
		}
	}
	
	function calc_diploma_grade(enroll_id,course_id,ids)
	{
		//alert(course_id);
		if(course_id!='')
		{
			var is_print=document.getElementById('is_print'+course_id+'').value;
			var enroll_id=enroll_id;
			var data12="action=diploma_course&course_id="+course_id+"&ids="+ids+"&enroll_id="+enroll_id+"&is_print="+is_print;
			//alert(data12);
			$.ajax({
				url: "get_grade_calculation.php", type: "post", data: data12, cache: false,
				success: function (html)
				{
					//alert(html);
					var res=html.split("##");
					document.getElementById('tot_sub_grade_per_'+course_id+'').value=res[0];
					document.getElementById('tot_sub_grade_'+course_id+'').value=res[1];
					document.getElementById('sub_grade_status_'+course_id+'').innerHTML=res[1];		
					alert(res[2]);	
				}
			});
		}
		else
		{
			alert("Please Enter Theory Mark and Practical Mark");
		}
	}
	function update_course_status(status)
	{
		var enroll_id=document.getElementById('enroll_id').value;
		
		var data12="action=update_course_status&status="+status+"&enroll_id="+enroll_id;
			//alert(data12);
		$.ajax({
			url: "ajax.php", type: "post", data: data12, cache: false,
			success: function (html)
			{
				alert("Course Status Updated Successfully");
			}
		});
	}
	function update_enroll_status(status)
	{
		var enroll_id=document.getElementById('enroll_id').value;
		var data12="action=update_enroll_status&status="+status+"&enroll_id="+enroll_id;
			//alert(data12);
		$.ajax({
			url: "ajax.php", type: "post", data: data12, cache: false,
			success: function (html)
			{
				alert("Enrollment Status Updated Successfully");
			}
		});
	}
	function update_student_status(status)
	{
		var enroll_id=document.getElementById('enroll_id').value;
		var data12="action=update_student_status&status="+status+"&enroll_id="+enroll_id;
			//alert(data12);
		$.ajax({
			url: "ajax.php", type: "post", data: data12, cache: false,
			success: function (html)
			{
				alert("Student Status Updated Successfully");
			}
		});
	}
	function change_student_name()
	{
		var enroll_id=document.getElementById('enroll_id').value;
		var name=document.getElementById('name').value;
		//alert(enroll_id);
		var data12="action=update_student_name&name="+name+"&enroll_id="+enroll_id;
		//alert(data12);
		$.ajax({
			url: "ajax.php", type: "post", data: data12, cache: false,
			success: function (html)
			{
				alert("Student Name Updated Successfully");
			}
		});
	}
   </script>
    </head>
<body>
<?php include "include/header.php";?>
<div id="info"> 
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
	<?php
    if($_POST['save_changes'])
    {
        $sche_action=$_POST['sche_action'];
        $batch_action=$_POST['batch_action'];
        $logsheet_action=$_POST['logsheet_action'];
        
        $name=$_POST['name'];
        if($_POST['logsheet_date'] !='')
        {
            $logsheet_dates= explode('/',$_POST['logsheet_date'],3);     
            $logsheet_date= $logsheet_dates[2].'-'.$logsheet_dates[1].'-'.$logsheet_dates[0];
        }
        if($_POST['sche_date'] !='')
        {
            $arrage_sche_date= explode('/',$_POST['sche_date'],3);     
            $arrage_sche_dates= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
        }
        if($_POST['batch_date'] !='')
        {
            $arrage_dates= explode('/',$_POST['batch_date'],3);     
            $date= $arrage_dates[2].'-'.$arrage_dates[1].'-'.$arrage_dates[0];
        }
        $counc_id=$_POST['counc_id']; 
        $counc1_id=$_POST['counc1_id'];
        $logsheet_councellor=$_POST['logsheet_councellor']; 
        
        //$inform_bop=$_POST['inform_bop'];
        $inform_counc=$_POST['inform_counc'];
        $inform_faculty=$_POST['inform_faculty'];
        
        //$inform_bop_id=$_POST['inform_bop_id']; 
        $inform_counc_id=$_POST['inform_counc_id'];
        $inform_faculty_id=$_POST['inform_faculty_id'];
        $enroll_id=$record_id;
        
        $data_record['enroll_id'] =$enroll_id;
        $data_record['schedule_Induction'] =$sche_action;
        $data_record['batch_schedule'] =$batch_action;
        $data_record['logsheet_schedule'] =$logsheet_action;
        
        $data_record['schedule_date'] =$date1;
        $data_record['batch_date'] =$date;
        $data_record['logsheet_date'] =$logsheet_date;
        
        $data_record['schedule_councellor'] =$counc_id;
        $data_record['batch_councellor'] = $counc1_id;
        $data_record['logsheet_councellor'] =$logsheet_councellor;
        
        //$data_record['inform_bop'] =$inform_bop_id;
        $data_record['inform_councellor'] =$inform_counc_id;
        $data_record['inform_faculty'] =$inform_faculty_id;
        $data_record['added_date'] =date('Y-m-d h:i:s');
        $data_record['admin_id']=$_SESSION['admin_id'];
        if($record_id)
        {
            $delete_cnc="delete from action_councellor where enroll_id='".$data_record['enroll_id']."'";
            $ptr_del=mysql_query($delete_cnc);
            
            
            $schedule_date= explode('/',$data_record['schedule_date'],3);     
            $schedule_date= $schedule_date[2].'-'.$schedule_date[1].'-'.$schedule_date[0];
            
            $insert_into_councellor= "INSERT INTO `action_councellor` (`enroll_id`, `schedule_Induction`, `batch_schedule`, `schedule_date`,`batch_date`,`schedule_councellor`,`batch_councellor`,`logsheet_schedule`,`logsheet_date`,`logsheet_councellor`,`added_date`,`action_by_status`, `admin_id`) VALUES ('".$data_record['enroll_id']."', '".$data_record['schedule_Induction']."','".$data_record['batch_schedule']."', '".$arrage_sche_dates."', '".$data_record['batch_date']."', '".$data_record['schedule_councellor']."', '".$data_record['batch_councellor']."','".$logsheet_action."','".$logsheet_date."','".$data_record['logsheet_councellor']."', '".date('Y-m-d H:i:s')."','done','".$data_record['admin_id']."')";
            $ptr_isert_invp = mysql_query($insert_into_councellor);
            
           	$total_main_course=$_POST['total_main_course']; 
            
            //================================ACTION CERTIFICATE======================================
            for($i=1;$i<=$total_main_course;$i++)
            {
				$course_id=$_POST['course_id_'.$i.''];
				$enroll_id=$_POST['enroll_id_'.$i.''];
               	$total_course=$_POST['total_course_'.$i.''];
				
				$delete_cer="delete from action_certificate where enroll_id='".$enroll_id."'";
            	$ptr_del_cer=mysql_query($delete_cer);
						
				$update_enrollment="update enrollment set course_start_date='".$_POST['course_start_date_'.$i.'']."',course_end_date='".$_POST['course_end_date_'.$i.'']."',installment_display_id='".$_POST['stud_reg_no_'.$i.'']."',certificate_date='".$_POST['certificate_date_'.$i.'']."' where enroll_id='".$enroll_id."' and course_id='".$course_id."'";
				$ptr_update=mysql_query($update_enrollment);
			
                if($total_course > 0)
                {
					for($ch=1;$ch<=$total_course;$ch++)
					{
						$course_sub_id=$_POST['course_id_'.$i.'_'.$ch.''];
						$total_sub_courses=$_POST['total_sub_course_'.$i.'_'.$ch.''];
						
						if($total_sub_courses>0)
						{
							for($subch=1;$subch<=$total_sub_courses;$subch++)
							{
								$course_sub_child_id=$_POST['course_id_'.$i.'_'.$ch.'_'.$subch.''];
								
								$sep_dates= explode('/',$_POST['course_status_date_'.$i.'_'.$ch.'_'.$subch.''],3);     
								$course_status_date= $sep_dates[2].'-'.$sep_dates[1].'-'.$sep_dates[0];
								
								$ins_certificate="INSERT INTO `action_certificate`(`enroll_id`, `course_id`,`ref_course_id`,`status`,`theory_grade`,`practical_grade`,`course_status_date`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$enroll_id."','".$_POST['course_id_'.$i.'_'.$ch.'_'.$subch.'']."','".$course_sub_child_id."','".$_POST['course_status_'.$i.'_'.$ch.'_'.$subch.'']."','".$_POST['theory_grade_'.$course_sub_child_id.'_'.$subch.'']."','".$_POST['practical_grade_'.$course_sub_child_id.'_'.$subch.'']."','".$course_status_date."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
								$ptr_certificate=mysql_query($ins_certificate);
							}
						}
						else
						{
							$sep_dates= explode('/',$_POST['course_status_date_'.$i.'_'.$ch.''],3);     
							$course_status_date= $sep_dates[2].'-'.$sep_dates[1].'-'.$sep_dates[0];
							
							$ins_certificate="INSERT INTO `action_certificate`(`enroll_id`, `course_id`,`ref_course_id`,`status`, `theory_grade`, `practical_grade`,`course_status_date`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$enroll_id."','".$course_sub_id."','".$course_id."','".$_POST['course_status_'.$i.'_'.$ch.'']."','".$_POST['theory_grade_'.$course_sub_id.'_'.$ch.'']."','".$_POST['practical_grade_'.$course_sub_id.'_'.$ch.'']."','".$course_status_date."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
							$ptr_certificate=mysql_query($ins_certificate);
							$main_course_ids=mysql_insert_id();
						}
					}
                }
                else //for basic and advance course only
                {
                    if($_POST['course_status_date_'.$i.''] !='')
                    {
                        $sep_dates= explode('/',$_POST['course_status_date_'.$i.''],3);     
                        $course_status_date= $sep_dates[2].'-'.$sep_dates[1].'-'.$sep_dates[0];
                    }
                    $ins_certificate="INSERT INTO `action_certificate`(`enroll_id`, `course_id`,`ref_course_id`,`status`, `theory_grade`, `practical_grade`, `course_status_date`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$enroll_id."','".$course_id."','0','".$_POST['course_status_'.$i.'']."','".$_POST['theory_grade_'.$course_id.'_'.$i.'']."','".$_POST['practical_grade_'.$course_id.'_'.$i.'']."','".$course_status_date."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
                    $ptr_certificate=mysql_query($ins_certificate);
                }
            }
            //=======================================END===============================================
            //===================================ACTION SAVE DATES=====================================
            for($i=1;$i<=$total_main_course;$i++)
            {
				$delete_final="delete from action_final where enroll_id='".$_POST['enroll_id_'.$i.'']."'";
            	$ptr_del_final=mysql_query($delete_final);
			
                $complition_date='';
                if($_POST['complition_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['complition_date_'.$i.''],3);     
                    $complition_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $payment_complition_date='';
                if($_POST['payment_complition_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['payment_complition_date_'.$i.''],3);     
                    $payment_complition_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $logbook_date='';
                if($_POST['logbook_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['logbook_date_'.$i.''],3);     
                    $logbook_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $print_certificate_date='';
                if($_POST['print_certificate_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['print_certificate_date_'.$i.''],3);     
                    $print_certificate_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $certificate_issue_date='';
                if($_POST['certificate_issue_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['certificate_issue_date_'.$i.''],3);     
                    $certificate_issue_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                
                $certificate_issue_staff_id=( ($_POST['certificate_issue_staff_id_'.$i.''])) ? $_POST['certificate_issue_staff_id_'.$i.''] : "0";
				$certificate_sr_no=( ($_POST['certificate_sr_no_'.$i])) ? $_POST['certificate_sr_no_'.$i] : "0";
				
                $sel_final="INSERT INTO `action_final`(`enroll_id`,`course_id`, `completion_date`, `payment_cleared_date`, `payment_cleared_action`, `logbook_completed_date`, `logbook_completed_action`, `certificate_print_date`, `print_certificate_action`,`certificate_type`, `certificate_issue_date`, `issue_certificate_action`, `certificate_by_staff`,`certificate_sr_no`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$_POST['enroll_id_'.$i.'']."','".$_POST['course_id_'.$i.'']."','".$complition_date."','".$payment_complition_date."','".$_POST['payment_cleared_'.$i.'']."','".$logbook_date."','".$_POST['logbook_action_'.$i.'']."','".$print_certificate_date."','".$_POST['certificate_printed_'.$i.'']."','".$_POST['certificate_type_'.$i.'']."','".$certificate_issue_date."','".$_POST['certificate_issued_'.$i.'']."','".$certificate_issue_staff_id."','".$certificate_sr_no."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
                $ptr_certificate=mysql_query($sel_final);
                //'".$_POST['google_testominal']."','".$_POST['justdial_testominal']."','".$_POST['video_taken']."',
            }//`google_action`, `justdial_Action`, `video_action`,  certificate_sr_no_
            //==========================================TESTOMINAL===============================================
            $ins_testo="INSERT INTO `action_testominal`(`enroll_id`,`google_action`, `justdial_action`, `video_action`,`staff_id`, `cm_id`, `admin_id`, `added_date`) VALUES ('".$data_record['enroll_id']."','".$_POST['google_testominal']."','".$_POST['justdial_testominal']."','".$_POST['video_taken']."','".$_POST['staff_ids']."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
            $ptr_testominal=mysql_query($ins_testo);
            //===========================================END====================================================
        }
        else
        {
            //$db->query_insert("pay_balace_bill_mapping", $data_college);
            //echo '<div id="msgbox" style="width:40%;">Supplier added successfully</center></div>';
        }
        $success=1;
    }                               

	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
	{
		$pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
        /*$sql_previos_total= "SELECT sum(amount) as credits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Credit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
        $row_previos_total=$db->fetch_array($db->query($sql_previos_total));
        $sql_previos_total1= "SELECT sum(amount) as debits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Debit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
        $row_previos_total1=$db->fetch_array($db->query($sql_previos_total1));
	    $balance=$row_previos_total['credits']-$row_previos_total1['debits'];*/
    }
	else
    {
    	$balance=0;
    	$pre_from_date="";                            
    }
	$sql_records="SELECT * FROM invoice where enroll_id=".$record_id." ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  order by invoice_id desc limit 0,1 ";
	$all_records = mysql_query($sql_records);
	$no_of_records=mysql_num_rows($db->query($sql_records));
	if($no_of_records)
	{    
		$bgColorCounter=1;
		if(!$_SESSION['showRecords'])
			$_SESSION['showRecords']=10;
		?>
        <form method="post" name="frmTakeAction">
        <table cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr><td valign="middle" align="right">
        	<table width="100%" cellpadding="0" callspacing="0" border="0">
            	<tr>
                <?php
                if($no_of_records>10)
                {
                    echo '<td width="3%" align="left">Show</td>
                    <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                    for($s=0;$s<count($show_records);$s++)
                    {
                        if($_SESSION['show_records']==$show_records[$s])
                            echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                        else
                            echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                    }
                    echo'</td></select>';
                }
                ?>
                <!-- <td width="70%" align="right"><a href="javascript:void(0);" onClick="window.open('csvcompany_manage.php','win1','status=no, toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no'); return false;" ><img src="images/csv.png" border="0"/></a>

                <img src='images/view.jpeg' title='View Invoice' border='0' onclick="window.open('invoice-generate-company.php')" style='cursor:pointer' > 
                <img src='images/print1.jpeg' onclick="window.open('invoice-generate-company.php?action=print','View Invoice')" style='cursor:pointer'title='Print Invoice' border='0'>
                </td>-->
                <td height="2" align="right"></td>
                </tr>
            </table>
			</td>
        </tr>
        <tr><td height="10"></td></tr>
        <tr>
        <td valign="top" colspan="2">
        <table cellspacing="1"  cellpadding="5" style="width: 100%;" align="center">
        <?php
		while($val_record=mysql_fetch_array($all_records))
		{
			$invoice_no= $val_record['invoice_id'];
			if($bgColorCounter%2==0)
				$bgcolor='class="grey_td"';
			else
				$bgcolor=""; 
			 $enroll_id=$val_record['enroll_id'];
			 $paid_totas=0;
			/*if($bgColorCounter%2==0)
				$bgclass="tr-sub_white1";
			else
				$bgclass="tr-sub1";*/
			include "include/paging_script.php";
			echo '<tr class="'.$bgclass.'">';
			//echo '<td align="center">'.$sr_no.'</td>';
			
			$name ='';
			$email_id = '';
			$phone_no ='';

			$select_firstname = " select * from enrollment where enroll_id='".$record_id."' ";
			$ptr_query=mysql_query($select_firstname);
			$data_select = mysql_fetch_array($ptr_query);
			//$invoice= $data_select['invoice_no'];
			?>
			<tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Personal Details</strong></td></tr>
			<!--<tr>
			<td colspan="2">
				<table align="center" width="100%" cellpadding="5" cellspacing="0"
				bgcolor="#EFEFEF" >
				<tr>
					<td width="21%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Roll No</span></td><td width="24%"><?php //echo $enroll_id;?></td>
					<td width="22%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Receipt No</span></td><td width="33%"><?php //echo $invoice_no; ?></td>
				</tr>
				<tr>
					<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">GST No.</span></td><td>27AADFI5575R1ZK</td>
					<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Invoice No.</span></td><td width="33%" ><?php //echo $invoice_no; ?></td>
				</tr>
				</table>
			</td>
			</tr>-->
			<?php
			$date_new=explode("-",$data_select['added_date']);
			$admission_date=$date_new[2].'/'.$date_new['1'].'/'.$date_new['0'];
			if($_SESSION['type']=='S' || $_SESSION['type']=='LD')
			{
				echo '<tr><td width="30%" style="font-size:15px"><strong>Student Name</strong></td><td align="left" style="padding-left:5px;font-size:15px"><b><input type="text" name="name" id="name" value="'.$data_select['name'].'" style="width:45%" class="input_text"><input type="hidden" name="enroll_id" id="enroll_id" value="'.$enroll_id.'" >&nbsp;&nbsp;&nbsp;<input type="button" onclick="return change_student_name()" name="change_name" id="change_name" value="Change Name" class="input_button"></td></tr>';
			}
			else
			{
				echo '<tr><td width="30%" style="font-size:15px"><strong>Student Name</strong></td><td align="left" style="padding-left:5px;font-size:15px"><b>"'.$data_select['name'].'"</b><input type="hidden" name="enroll_id" id="enroll_id" value="'.$enroll_id.'" >&nbsp;&nbsp;&nbsp;</td></tr>';
			}
			echo '<tr><td width="30%" style="font-size:15px"><strong>Admission Date</strong></td><td align="left" style="padding-left:5px;font-size:15px"><b>'.$admission_date.'</td></tr>';
            echo '<tr><td width="30%" style="font-size:15px"><strong>Enrooment No.</strong></td><td align="left" style="padding-left:5px;font-size:15px"><b>'.$data_select['installment_display_id'].'</td></tr>';
            echo '<tr><td width="30%" style="font-size:15px"><strong>Contact No.</strong></td><td align="left" style="padding-left:5px;font-size:15px"><b>'.$data_select['contact'].'</b></td></tr>';
            echo '<tr><td width="30%" style="font-size:15px"><strong>Email Id </strong></td><td align="left" style="padding-left:5px;font-size:15px;"><b>'.$data_select['mail'].'</b></td></tr>';
            echo '<tr><td width="30%" style="font-size:15px"><strong>Address</strong></td><td align="left" style="padding-left:5px;font-size:15px"><b>'.$data_select['address'].'</b></td></tr>';
            echo '<tr><td width="30%" style="font-size:15px"><strong>DOB</strong></td><td align="left" style="padding-left:5px;font-size:15px"><b>'.$data_select['dob'].'</b></td></tr>';
            $paid=$data_select['paid'];
            //echo '<tr><td><strong>Down Payment</strong></td><td align="left">'.$data_select['down_payment'].'</td></tr>'; 
            if($data_select['paid'] !='')
            {
            }
			$disabled_status='disabled="disabled"';
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
			{
				$disabled_status='';
			}
			
			$disabled_for_all='disabled="disabled"';
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z')
			{
				$disabled_for_all='';
			}
            ?> 
            <!--<tr><td width="37%"><strong>Deposite Amount</strong></td><td width="63%" align="left"><input type="text" name="amount_paid" id="amount_paid" onkeyup="calculate_total(this.value)" value="" > </td></tr>-->
			
            	<tr>
                	<td colspan="2" align="center" style=" font-size:14px; font-weight:bold"><strong>Student Status</strong></td></tr>
                <tr>
                    <td colspan="2">
                        <table align="center" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF" >
                            <tr bgcolor="#A8A8A8">
                                <td width="30%" align="center" style="padding-left:10px;"><span style=" font-weight:bold">Course Status</span></td>
                                <td width="30%" align="center" style="padding-left:10px;"><span style=" font-weight:bold">Enrollment Status</span></td>
                                <td width="30%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Student Status</span></td> 
                            </tr>
                            <tr>
                            	<td align="left" style="padding-left:10px;">
                                <select name="course_status" <?php //echo $disabled_status;?> onchange="update_course_status(this.value)">
                                	<option value="">Update Course Status</option>
                                    <?php
									$sel_course_status="select course_status from enrollment where enroll_id='".$record_id."' ";
									$ptr_course_status=mysql_query($sel_course_status);
									$data_course_status=mysql_fetch_array($ptr_course_status);
									$course_status=$data_course_status['course_status'];
									?>
                                    <option value="not_started" <?php if($course_status=='not_started') echo 'selected="selected"'; ?>>Not Started</option>
                                    <option value="started" <?php if($course_status=='started') echo 'selected="selected"'; ?>>Started</option>
                                    <option value="halted" <?php if($course_status=='halted') echo 'selected="selected"'; ?>>Halted</option>
                                    <option value="cancelled" <?php if($course_status=='cancelled') echo 'selected="selected"'; ?>>Cancelled</option>
                                    <option value="restart" <?php if($course_status=='restart') echo 'selected="selected"'; ?>>Restart</option>
                                    <option value="finished" <?php if($course_status=='finished') echo 'selected="selected"'; ?>>Finish</option>
                                </select>
                                </td>
                                <td align="left" style="padding-left:10px;">
                                <select <?php echo $disabled_status; ?> name="enroll_status" id="enroll_status" onchange="update_enroll_status(this.value)">
                                	<option value="">Update Enrollment Status</option>
                                    <?php
									$sel_enroll_status="select status from enrollment where enroll_id='".$record_id."' ";
									$ptr_enroll_status=mysql_query($sel_enroll_status);
									$data_enroll_status=mysql_fetch_array($ptr_enroll_status);
									$enroll_status=$data_enroll_status['status'];
									?>
                                    <option value="Enquiry" <?php if($enroll_status=='Enquiry') echo 'selected="selected"'; ?>>Enquiry</option>
                                    <option value="Enrolled" <?php if($enroll_status=='Enrolled') echo 'selected="selected"'; ?>>Enrolled</option>
                                    <option value="kit_issued" <?php if($enroll_status=='kit_issued') echo 'selected="selected"'; ?>>Kit Issued</option>
                                    <option value="batch_scheduled" <?php if($enroll_status=='batch_scheduled') echo 'selected="selected"'; ?>>Batch Scheduled</option>
                                    <option value="course_started" <?php if($enroll_status=='course_started') echo 'selected="selected"'; ?>>Course Started</option>
                                    <option value="course_completed" <?php if($enroll_status=='course_completed') echo 'selected="selected"'; ?>>Course Completed</option>
                                </select>
                                </td>
                                <td align="left" style="padding-left:10px;">
                                <select <?php echo $disabled_for_all; ?> name="student_status"  id="student_status" onchange="update_student_status(this.value)">
                                	<option value="">Update Student Status</option>
                                    <?php
									$sel_student_status="select student_status from enrollment where enroll_id='".$record_id."' ";
									$ptr_student_status=mysql_query($sel_student_status);
									$data_student_status=mysql_fetch_array($ptr_student_status);
									$student_status=$data_student_status['student_status'];
									?>
                                    <option value="Active" <?php if($student_status=='Active') echo 'selected="selected"'; ?>>Active</option>
                                    <option value="Inactive" <?php if($student_status=='Inactive') echo 'selected="selected"'; ?>>Inactive</option>
                                    <option value="Aborted" <?php if($student_status=='Aborted') echo 'selected="selected"'; ?>>Aborted</option>
                                </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2" align="center" style=" font-size:14px; font-weight:bold; color:#F00"><strong>Outstanding Details</strong></td></tr>	
                <tr>
                    <td colspan="2">
                        <table align="center" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF" >
                        <tr bgcolor="#A8A8A8">
                            <td width="20%" align="left" style="padding-left:10px;"><span style=" font-weight:bold">Outstanding Type</span></td>
                            <td width="20%" align="left" style="padding-left:10px;"><span style=" font-weight:bold">Category/Invoice no.</span></td>
                            <td width="20%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Total Amount</span></td> 
                            <td width="20%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Paid Amount</span></td>
                            <td width="20%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Remaining Amount</span></td>
                            <td width="45%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Reason/Description</span></td>
                        </tr>
                        <?php
						$outstanding_amnt='';
						$sel_outstand="select * from enroll_outstanding where enroll_id='".$record_id."' and remaining_amount>0";
						$ptr_outstand=mysql_query($sel_outstand);
						if(mysql_num_rows($ptr_outstand))
						{
							while($data_outstand=mysql_fetch_array($ptr_outstand))
							{
								$outstanding_amnt='yes';
								?>
                            	<tr>
                                	<td align="left" style="padding-left:10px;"><span style="font-weight:bold">Debit/Credit Outstanding</span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_outstand['type']); ?> </span></td>
                                    <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><?php echo intval($data_outstand['amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><?php echo intval($data_outstand['payble_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><?php echo intval($data_outstand['remaining_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_outstand['reason']; ?></span></td>    
                                </tr>
                             	<?php
							}
						}
						
						$sel_prod_out="select * from sales_product where customer_id='".$record_id."' and type='Student' and remaining_amount>0";
						$ptr_prod_out=mysql_query($sel_prod_out);
						if(mysql_num_rows($ptr_prod_out))
						{
							while($data_prod_out=mysql_fetch_array($ptr_prod_out))
							{
								?>
                                <tr>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold">Product Outstanding</span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['sales_product_id']); ?> </span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['total_price']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['payable_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['remaining_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_prod_out['reason']; ?></span></td>    
                                </tr>
                                <?php
							}
						}
						
						$sel_serv_out="select * from customer_service where customer_id='".$record_id."' and type='Student' and remaining_amount>0";
						$ptr_serv_out=mysql_query($sel_serv_out);
						if(mysql_num_rows($ptr_serv_out))
						{
							while($data_serv_out=mysql_fetch_array($ptr_serv_out))
							{
								?>
                                <tr>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold">Product Outstanding</span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['customer_service_id']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['payable_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['remaining_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_serv_out['followup_desc']; ?></span></td>    
                                </tr>
                                <?php
							}
						}
						?>
                        </table>
                    </td>
                </tr>
                
                <tr><td colspan="2" align="center" style=" font-size:14px; font-weight:bold"><strong>Action (Enrollment Related)</strong></td></tr>
                                  
                    <tr><td colspan="2">
                    <table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
                    <tr bgcolor="#A8A8A8">
                        <td width="36%" align="left" style="padding-left:10px;"><span style=" font-weight:bold">Name</span></td>
                        <td width="19%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Action</span></td>      
                        <td width="18%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Date</span></td>
                        <td width="27%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Councellor Name</span></td>
                    </tr>
                    
                    <?php 
                    $schedule_date='';
                    $batch_date='';
                    $logsheet_date='';
                    $batch_councellor='';
                    $schedule_councellor='';
                    $logsheet_councellor='';
                    $inform_bop='';
                    
                    $sel="select * from action_councellor where enroll_id=".$record_id."";
                    $ptr_sel= mysql_query($sel);
                    if(mysql_num_rows($ptr_sel))
                    {
                        $data_sel=mysql_fetch_array($ptr_sel);
                        $schedule_date=date("d/m/Y", strtotime($data_sel['schedule_date']));
                        $batch_date=date("d/m/Y", strtotime($data_sel['batch_date']));
                        $logsheet_date=date("d/m/Y", strtotime($data_sel['logsheet_date']));
                        
                        $schedule_councellor=$data_sel['schedule_councellor'];
                        $batch_councellor=$data_sel['batch_councellor'];
                        $logsheet_councellor=$data_sel['logsheet_councellor'];
                        $inform_bop=$data_sel['inform_bop'];
                    }
                    ?>
                    <tr>
                        <td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Logsheet</span></td>
                        <?php
						//$disabled_log='';
                        if($_SESSION['type']=="S" && $data_sel['logsheet_schedule']=="yes")
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="logsheet_action" <?php if($data_sel['logsheet_schedule']=='yes') {echo 'checked="checked"' ;} ?> value="yes"></span></td>
                            
                            <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="logsheet_date" value="<?php if($_POST['logsheet_date']) echo $logsheet_date; else if($logsheet_date !='') echo $logsheet_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date"></span></td>
							<td align="left"  style="padding-left:10px;">
                            	<select name="logsheet_councellor" id="logsheet_councellor" class="input_select" style="width:150px;">
                                <?php
                                $select_faculty="select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by cm_id asc";
                                $ptr_faculty = mysql_query($select_faculty);
                                while($data_faculty = mysql_fetch_array($ptr_faculty))
                                { 
                                    $class3 = '';
                                    if($logsheet_councellor !='')
                                    {
                                        if($data_faculty['admin_id'] == $logsheet_councellor)
                                        {  
                                            $class3 = 'selected="selected"';
                                        }
                                    }
                                    else
                                    {
                                        if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                        {  
                                            $class3 = 'selected="selected"';
                                        }
                                    }
                                    echo '<option value="'.$data_faculty['admin_id'].'" '.$class3.' >'.$data_faculty['name'].' </option>';     
                                }
								?>        
                            	</select>
                            </td>
                            <?php
							$disabled_log='';
                        }
                        else if($data_sel['logsheet_schedule']=="yes" && $_SESSION['type']!="S")
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="hidden"  name="logsheet_action" value="yes"><?php if($data_sel['logsheet_schedule']=='yes') {echo '<img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified">';}?></span></td>
                            <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $logsheet_date;?><input type="hidden" name="logsheet_date" value="<?php if($_POST['logsheet_date']) echo $logsheet_date; else if($logsheet_date !='') echo $logsheet_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date"></span></td>
                            
                            <td align="left"  style="padding-left:10px;">
                            <?php
							$select_faculty="select name from site_setting where admin_id='".$logsheet_councellor."' and cm_id='".$data_select['cm_id']."' order by admin_id asc";
                            $ptr_faculty=mysql_query($select_faculty);
							$data_faculty=mysql_fetch_array($ptr_faculty);
							echo $data_faculty['name'];
							?>
                            <input type="hidden" name="logsheet_councellor" id="logsheet_councellor" value="<?php if($logsheet_councellor!='') echo $logsheet_councellor;?>" >
                            </td>
                            <?php
							$disabled_log='disabled="disabled"';
                        }
                        else
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="logsheet_action" <?php if($data_sel['logsheet_schedule']=='yes') {echo 'checked="checked"' ;}?> value="yes"></span></td>
                            <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="logsheet_date" value="<?php if($_POST['logsheet_date']) echo $logsheet_date; else if($logsheet_date !='') echo $logsheet_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date"></span></td>
                            <td align="left"  style="padding-left:10px;">
                             <select name="logsheet_councellor" id="logsheet_councellor" class="input_select" style="width:150px;"  <?php echo $disabled_log; ?>>
                                <?php 
                                $select_faculty = "select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by cm_id asc";
                                $ptr_faculty = mysql_query($select_faculty);
                                while($data_faculty = mysql_fetch_array($ptr_faculty))
                                { 
                                    $class3 = '';
                                    if($logsheet_councellor !='')
                                    {
                                        if($data_faculty['admin_id'] == $logsheet_councellor)
                                        {  
                                            $class3 = 'selected="selected"';
                                        }
                                    }
                                    else
                                    {
                                        if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                        {  
                                            $class3 = 'selected="selected"';
                                        }
                                    }
                                    echo '<option value="'.$data_faculty['admin_id'].'" '.$class3.' >'.$data_faculty['name'].' </option>';     
                                }
                                  ?>        
                            </select>
                            </td>
                            <?php
							$disabled_log='';
                        }
                        ?>
                    </tr>
                    <?php 
                    /*$disabled="disabled";
                    if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' || $_SESSION['type']=="A" || $_SESSION['type']=="C")
                    {
                        $disabled="";
                    }*/
                    ?>
                    <tr>
                        <td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Schedule Induction (Only For Councelor & Admin)</span></td>
                        <!--<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="sche_action" <?php //if($data_sel['schedule_Induction']=='yes') {echo 'checked="checked"' ;}  echo $disabled; ?> value="yes"/></span></td>-->
                        
                        <?php
						$disabled_sched='';
                        if($_SESSION['type']=="S" && $data_sel['schedule_Induction']=="yes")
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="sche_action" <?php if($data_sel['schedule_Induction']=='yes') {echo 'checked="checked"';} ?> value="yes"></span></td>
                            
                            <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" value="<?php if($_POST['sche_date']) echo $_POST['sche_date']; else if($schedule_date !='') echo $schedule_date; else echo date('d/m/Y'); ?>" name="sche_date"  class="datepicker" placeholder="Action date"></span></td>
                            
							<td align="left"  style="padding-left:10px;">
                                <select name="counc_id" id="counc_id" class="input_select" style="width:150px;">
                                    <?php 
                                    $select_faculty="select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by admin_id asc";//select * from site_setting where type='C' ".$_SESSION['cm_id_councellor']."  order by cm_id asc
                                    $ptr_faculty = mysql_query($select_faculty);
                                    while($data_faculty = mysql_fetch_array($ptr_faculty))
                                    { 
                                        $class1 = '';
                                        if($schedule_councellor!='')
                                        {
                                            if($data_faculty['admin_id'] == $schedule_councellor)
                                            {  
                                                $class1 = 'selected="selected"';
                                            }
                                        }
                                        else
                                        {
                                            if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                            {  
                                                $class1 = 'selected="selected"';
                                            }
                                        }
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class1.' >'.$data_faculty['name'].' </option>';     
                                    }
                                    ?>        
                                </select>
                            </td>
							<?php
							$disabled_sched='';
                        }
                        else if($data_sel['schedule_Induction']=="yes" && $_SESSION['type']!="S")
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="hidden"  name="sche_action" value="yes" /><?php if($data_sel['schedule_Induction']=='yes') {echo '<img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified">';}?></span></td>
                            <td align="left"  style="padding-left:10px;"><span style="font-weight:bold">
                            <?php
							if($schedule_date !='') echo $schedule_date;
							?>
                            <input type="hidden" value="<?php if($_POST['sche_date']) echo $_POST['sche_date']; else if($schedule_date !='') echo $schedule_date; else echo date('d/m/Y'); ?>" name="sche_date"  class="datepicker" placeholder="Action date "/></span></td>
                            <td align="left"  style="padding-left:10px;">
                            <?php
							$select_faculty="select name from site_setting where cm_id='".$data_select['cm_id']."' and  admin_id='".$schedule_councellor."' order by admin_id asc";//select * from site_setting where type='C' ".$_SESSION['cm_id_councellor']."  order by cm_id asc
							$ptr_faculty=mysql_query($select_faculty);
							$data_faculty=mysql_fetch_array($ptr_faculty);
							echo $data_faculty['name'];
							?>
                            <input type="hidden" name="counc_id" id="counc_id" value="<?php echo $schedule_councellor; ?>">
                            </td>
                            <?php
							$disabled_sched='disabled="disabled"';
                        }
                        else
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="sche_action" <?php if($data_sel['schedule_Induction']=='yes') {echo 'checked="checked"' ;}?> value="yes"></span></td>
                            
                            <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" value="<?php if($_POST['sche_date']) echo $_POST['sche_date']; else if($schedule_date !='') echo $schedule_date; else echo date('d/m/Y'); ?>" name="sche_date"  class="datepicker" placeholder="Action date "/></span></td>
                            <td align="left"  style="padding-left:10px;">
                                <select name="counc_id" id="counc_id" class="input_select" style="width:150px;">
                                    <?php 
                                    $select_faculty="select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by admin_id asc";//select * from site_setting where type='C' ".$_SESSION['cm_id_councellor']."  order by cm_id asc
                                    $ptr_faculty = mysql_query($select_faculty);
                                    while($data_faculty = mysql_fetch_array($ptr_faculty))
                                    { 
                                        $class1 = '';
                                        if($schedule_councellor!='')
                                        {
                                            if($data_faculty['admin_id'] == $schedule_councellor)
                                            {
                                            	$class1='selected="selected"';
                                            }
                                        }
                                        else
                                        {
                                            if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                            {
                                            	$class1 = 'selected="selected"';
                                            }
                                        }
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class1.' >'.$data_faculty['name'].' </option>';     
                                    }
                                    ?>        
                                </select>
                            </td>
							<?php
							$disabled_sched='';
                        }
                        ?>
                        <!--<td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" value="<?php //($_POST['sche_date']) echo $_POST['sche_date']; else if($arrage_sche_dates !='') echo $arrage_sche_dates; else echo date('d/m/Y'); ?>" <?php //echo $disabled_sched; ?> name="sche_date"  class="datepicker" placeholder="Action date "/></span></td>-->                      
                    </tr>
                    <?php 
                    $disabled_cm="disabled";
                    if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' || $_SESSION['type']=="A" )
                    {
                        $disabled_cm="";
                    }
                    ?>
                    <tr>
                        <td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Batch schedule (Only For Admin)</span></td>
                        <!--<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox" <?php //echo $disabled_cm; ?> name="batch_action"  <?php //if($data_sel['batch_schedule']=='yes') {echo 'checked="checked"' ;} ?>  value="yes" /></span></td>-->
                        
                        <?php
						$disabled_batch_sch='';
                        if($_SESSION['type']=="S" && $data_sel['batch_schedule']=="yes")
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="batch_action" <?php if($data_sel['batch_schedule']=='yes') {echo 'checked="checked"';} ?> value="yes"></span></td>
                            
                            <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="batch_date" value="<?php if($_POST['batch_date']) echo $_POST['batch_date']; else if($batch_date !='') echo $batch_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date"></span></td>
                            <td align="left"  style="padding-left:10px;">
                            <select name="counc1_id" id="counc1_id" class="input_select" style="width:150px;">                            	<?php 
                                    $select_faculty="select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by admin_id asc";
                                    $ptr_faculty=mysql_query($select_faculty);
                                    while($data_faculty=mysql_fetch_array($ptr_faculty))
                                    {
                                        $class2='';
                                        if($batch_councellor !='')
                                        {
                                            if($data_faculty['admin_id'] == $batch_councellor)
                                            {  
                                                $class2 = 'selected="selected"';
                                            }
                                        }
                                        else
                                        {
                                            if($data_faculty['admin_id'] ==$_SESSION['admin_id'])
                                            {  
                                                $class2 = 'selected="selected"';
                                            }
                                        }
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class2.' >'.$data_faculty['name'].' </option>';
                                    }
                                  ?>        
                            </select>
                            </td>
							<?php
							$disabled_batch_sch='';
                        }
                        else if($data_sel['batch_schedule']=="yes" && $_SESSION['type']!="S")
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="hidden"  name="batch_action" value="yes" /><?php if($data_sel['batch_schedule']=='yes') {echo '<img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified">';}?></span></td>
                            <td align="left" style="padding-left:10px;"><span style="font-weight:bold">
                            <?php
							if($batch_date !='') echo $batch_date;
							?>
                            <input type="hidden" name="batch_date" value="<?php if($_POST['batch_date']) echo $_POST['batch_date']; else if($batch_date !='') echo $batch_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date"></span></td>
                            <td align="left"  style="padding-left:10px;">
                            <?php
							$select_faculty="select name from site_setting where cm_id='".$data_select['cm_id']."' and admin_id='".$batch_councellor."' order by cm_id asc";
							$ptr_faculty=mysql_query($select_faculty);
							$data_faculty=mysql_fetch_array($ptr_faculty);
							echo $data_faculty['name'];
							?>
                            <input type="hidden" name="counc1_id" id="counc1_id" value="<?php echo $batch_councellor; ?>">
                            </td>
							<?php
							$disabled_batch_sch='disabled="disabled"';
                        }
                        else
                        {
                            ?>
                            <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="batch_action" <?php if($data_sel['batch_schedule']=='yes') {echo 'checked="checked"' ;}?> value="yes"></span></td>
                            <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="batch_date" value="<?php if($_POST['batch_date']) echo $_POST['batch_date']; else if($batch_date !='') echo $batch_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date"></span></td>
                            <td align="left"  style="padding-left:10px;">
                            	<select name="counc1_id" id="counc1_id" class="input_select" style="width:150px;">                                    <?php 
                                    $select_faculty="select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by admin_id asc";
                                    $ptr_faculty=mysql_query($select_faculty);
                                    while($data_faculty=mysql_fetch_array($ptr_faculty))
                                    { 
                                        $class2='';
                                        if($batch_councellor !='')
                                        {
                                            if($data_faculty['admin_id'] == $batch_councellor)
                                            {  
                                                $class2 = 'selected="selected"';
                                            }
                                        }
                                        else
                                        {
                                            if($data_faculty['admin_id'] ==$_SESSION['admin_id'])
                                            {  
                                                $class2 = 'selected="selected"';
                                            }
                                        }
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class2.' >'.$data_faculty['name'].' </option>';
                                    }
                                  ?>        
                            </select>
                            </td>
							<?php
							$disabled_batch_sch='';
                        }
                        ?>
                    </tr>
                    <!--<tr>
                    	<td colspan="4" align="center"><input type="button" class="input_btn" name="councilior_action" id="councilior_action" value="Save Enrollment Action" onclick="save_action_enrollment(<?php //echo $record_id; ?>)" ></td>
                    </tr>-->
                </table>
                </td>
                </tr> 
                <tr bgcolor="#EFEFEF">
                    <td colspan="3" align="center" style="font-size:12px"><strong>Student Kit Issued</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align="center"  width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF" >
                            <tr bgcolor="#A8A8A8">
                                <td width="5%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Sr. No</span></td>
                                <td width="20%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Product Issued</span></td>      
                                <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Quantity</span></td>
                                <td width="16%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Date</span></td>
                                <td width="18%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Staff</span></td>
                                <td width="5%" align="center"  style="padding-left:10px;"><span style="font-weight:bold">Action</span></td>
                            </tr>
                            
                            <?php
                            $sql_query1 = "select * from student_kit_map where enroll_id='".$record_id."' ".$_SESSION['where']." order by student_kit_id asc ";
                            $ptr_querys1=mysql_query($sql_query1);
                            if($total=mysql_num_rows($ptr_querys1))
                            {
                                $s=1;
                                while($data_queries1=mysql_fetch_array($ptr_querys1))
                                {
                                    $sel_tel = "select product_id,product_name,quantity from product where 1 and product_id='".$data_queries1['product_id']."' ".$_SESSION['where']." order by product_id asc";	
                                    $query_tel = mysql_query($sel_tel);
                                    $data=mysql_fetch_array($query_tel);
                                    $names=$data['product_name'];
                                    
                                    "<br/>".$sele_admin="select name from site_setting where admin_id='".$data_queries1['admin_id']."' ";
                                    $ptr_admin=mysql_query($sele_admin);
                                    $data_name=mysql_fetch_array($ptr_admin);
                                    
                                    $dates=explode(" ",$data_queries1["added_date"]);
                                    $new_date=explode("-",$dates[0]);
                                    $kit_date=$new_date[2]."/".$new_date[1]."/".$new_date[0];
                                    $disabled='';
                                    if($_SESSION['type']!="S" || $_SESSION['type']!='Z' || $_SESSION['type']!='LD' || $_SESSION['type']!="A")
                                    {
                                        $disabled="disabled";
                                    }
                                    echo '<tr><td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$s.'</span></td>';
                                    echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$names.'</span></td>';
                                    echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$data_queries1["product_qty"].'</span></td>';
                                    echo '<td align="center" style="padding-left:10px;"><input type="text" name="kit_issue_date" '.$disabled.' id="kit_issue_date" class="datepicker" value="'.$kit_date.'" /></td>';
                                    echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$data_name["name"].'</span></td>';
                                    echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold"><input type="checkbox" '.$disabled.' checked name="kit_action[]" id="kit_action'.$i.'"</span></td></tr>';
                                    $s++;
                                }
                            }
                            ?>
                            
                        </table>
                    </td>
                </tr>       
                    <!--<tr><td colspan="2">
                    <table align="center" border="0px" width="100%" cellpadding="4" cellspacing="0">
                    <tr bgcolor="#EFEFEF">
                        <td width="32%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Inform BOP for kit</span></td>
                        <td width="44%" align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="checkbox" name="inform_bop" <?php //if($data_sel['inform_bop']!='') {echo 'checked="checked"' ;}?> value="inform_bop" /></span></td>
                        <td width="33%" >
                         <select name="inform_bop_id " id="inform_bop_id" class="input_select" style="width:150px;">                        
                            <?php 
                                /* $select_faculty = "select * from site_setting where 1 ".$_SESSION['where']."  order by cm_id asc";
                                $ptr_faculty = mysql_query($select_faculty);
                                while($data_faculty = mysql_fetch_array($ptr_faculty))
                                { 
                                    $class4 = '';
                                    if($inform_bop !='')
                                    {
                                        if($data_faculty['admin_id'] == $inform_bop)
                                        {  
                                            $class4 = 'selected="selected"';
                                        }
                                    }
                                    else 
                                    {
                                        if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                        {  
                                            $class4 = 'selected="selected"';
                                        }
                                    }
                                    echo '<option value="'.$data_faculty['admin_id'].'" '.$class4.' >'.$data_faculty['name'].' </option>';     
                                } */
                                ?>        
                        </select>
                        </td>
                        </tr>                           		
                    </table>
                    </td>
                    </tr>-->
                    <tr>
                        <td colspan="2" style=" font-size:14px; font-weight:bold" align="center">Action (Certificate Related)</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
                            <!--<tr>
                                <td height="46" colspan="8" align="center" style=" font-size:12px; font-weight:bold"><strong>Course Details</strong></td>
                            </tr>-->
                            <!--<tr bgcolor="#A8A8A8">
                                <td width="5%" align="center"><span style="font-weight:bold">Sr. No</span></td>
                                <td width="30%" align="center"><span style="font-weight:bold">Course Name</span></td>
                                <td width="10%" align="center"><span style="font-weight:bold">Date</span></td>
                                <td width="35%" align="center"><span style="font-weight:bold">Status</span></td>  
                                <td width="10%" align="center"><span style="font-weight:bold">Theory Grade</span></td>  
                                <td width="10%" align="center"><span style="font-weight:bold">Practical Grade</span></td>  
                            </tr>-->
                            <?php
                            $sel_courses="SELECT * FROM enrollment where 1 and (ref_id='".$record_id."' or enroll_id='".$record_id."') and cm_id='".$data_select['cm_id']."' ";
                            $ptr_courses=mysql_query($sel_courses);
                            $tot_main_course=mysql_num_rows($ptr_courses);
                            $c=1;
                            while($data_course=mysql_fetch_array($ptr_courses))
                            {
                                $select_name="select course_name,course_id,is_parent,course_type from courses where course_id='".$data_course['course_id']."'";
                                $ptr_name=mysql_query($select_name);
                                $s=1;
                                $data_name=mysql_fetch_array($ptr_name);
                                //if($data_name['is_parent']!='')
								
								$sel_cert_final="select certificate_sr_no from action_final where enroll_id=".$data_course['enroll_id']." and course_id='".$data_course['course_id']."' order by action_final_id desc";
                                $ptr_cert_final= mysql_query($sel_cert_final);
								$certificate_sr_no='';
								if(mysql_num_rows($ptr_cert_final))
								{
                                	$data_cert_no=mysql_fetch_array($ptr_cert_final);
									$certificate_sr_no=$data_cert_no['certificate_sr_no'];
								}
                                ?>
                                <tr bgcolor="#A8A8A8">
                                    <td width="30%" colspan="2" align="center" style="padding-left:10px;"><span style=" font-weight:bold">Course Name</span></td>
                                    <td width="10%" colspan="2"  align="center" style="padding-left:10px;"><span style="font-weight:bold">Course Fee</span></td>      
                                    <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Paid Fee</span></td>
                                    <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Balance Fee</span></td>
                                    <td width="30%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Installments</span></td>
                                    <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Date</span></td>
                                    <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Action</span></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2" style="padding-left:10px;"><span style="font-weight:bold; font-size:15px"><?php echo $c.'. '.$data_name['course_name']; ?></span></td><input type="hidden" name="course_id_<?php echo $c ;?>" id="course_id_<?php echo $c ;?>" value="<?php echo $data_name['course_id']; ?>" ><input type="hidden" name="enroll_id_<?php echo $c ;?>" id="enroll_id_<?php echo $c ;?>" value="<?php echo $data_course['enroll_id']; ?>">
                                    <td align="center" colspan="2"  style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_course['net_fees'];?></span></td>
                                    <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_course['paid'];?></span></td>
                                    <td align="center" style="padding-left:10px;"><span style="font-weight:bold; color:#F00"><?php echo $data_course['balance_amt'];?> </span></td>
                                    <td align="center" style="padding-left:10px;"><span style="font-weight:bold">
                                    <?php
                                    $sel_inst="SELECT * FROM `installment` where enroll_id ='".$data_course['enroll_id']."' and course_id='".$data_course['course_id']."' ";
                                    $ptr_ins=mysql_query($sel_inst);
                                    if(mysql_num_rows($ptr_ins))
                                    {
                                        while($data_inst=mysql_fetch_array($ptr_ins))
                                        {
                                            $col_paid ='<font color="#006600">';
                                            if($data_inst['status'] =='not paid')
                                                $col_paid ='<font color="#FF3333">';
                                            echo $data_inst['installment_amount'].'/- '.$data_inst['installment_date'].' : '.$col_paid.$data_inst['status']."</font><br>";	
                                        }
                                    }
                                    else
                                    {
                                    }
                                    $sel_inv="SELECT * FROM invoice where enroll_id=".$data_course['enroll_id']." and status='paid'";
                                    $ptr_inv=mysql_query($sel_inv);
                                    while($data_inv=mysql_fetch_array($ptr_inv))
                                    {
                                        $col_paid_inv ='';
                                        $col_paid ='<font color="#FF3333">';
                                        $date_i=explode(" ",$data_inv['added_date']);
                                        $date_invs=$date_i[0];
                                        echo $data_inv['amount'].'/- '.$date_invs.' :<font color="#006600"> '.$data_inv['status'].'</font><br>';
                                    }
                                    ?>
                                    </span>                                  
                                    </td>
                                    <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_course['added_date']; ?></span></td>
                                    <input type="hidden" name="is_integrated_course" id="is_integrated_course" value="<?php echo $data_name['is_parent']; ?>">
                                </tr>
                                <tr>
                                    <td colspan="10" width="100%">
                                        <table width="100%">
                                            <td width="8%" align="center">Course Start Date</td>
                                            <td width="10%" align="center">
                                            <?php
											$readonly_s_date='';
											$bg_color_s_date='';
											if($data_course['course_start_date'] !='' && $_SESSION['type']!='S')
											{
												$readonly_s_date='readonly="readonly"';
												$bg_color_s_date='background-color:#EFEFEF';
											}
											$readonly_e_date='';
											$bg_color_e_date='';
											if($data_course['course_end_date'] !='' && $_SESSION['type']!='S')
											{
												$readonly_e_date='readonly="readonly"';
												$bg_color_e_date='background-color:#EFEFEF';
											}
											$bg_color_reg_no='';
											$readonly_reg_no='';
											if($data_course['installment_display_id'] !='' && $_SESSION['type']!='S')
											{
												$readonly_reg_no='readonly="readonly"';
												$bg_color_reg_no='background-color:#EFEFEF';
											}
											$bg_color_cert_awarded='';
											$readonly_cert_awarded='';
											if($data_course['certificate_date'] !='' && $_SESSION['type']!='S')
											{
												$readonly_cert_awarded='readonly="readonly"';
												$bg_color_cert_awarded='background-color:#EFEFEF';
											}
											$readonly_cert_sr_no='';
											$bg_color_sr_no='';
											if($certificate_sr_no > 0 && $_SESSION['type']!='S')
											{
												$readonly_cert_sr_no='readonly="readonly"';
												$bg_color_sr_no='background-color:#EFEFEF';
											}
											?>
                                            <input <?php echo $readonly_s_date;?> type="text" style="width:80px;<?php echo $bg_color_s_date; ?>" class="datepicker" name="course_start_date_<?php echo $c ;?>" id="course_start_date_<?php echo $c ;?>" value="<?php if($data_course['course_start_date'] !='') { echo $data_course['course_start_date'];} else if($data_course['added_date']) { $res=explode("-",$data_course['added_date']); echo $res[2]."/".$res[1]."/".$res[0];} ?>">
                                            </td>
                                            <td width="8%" align="center">Course End Date</td>
                                            <td width="10%" align="center"><input type="text" <?php echo $readonly_e_date;?> style="width:80px;<?php echo $bg_color_e_date; ?>" class="datepicker" name="course_end_date_<?php echo $c ;?>" id="course_end_date_<?php echo $c ;?>" value="<?php if($data_course['course_end_date']) { echo $data_course['course_end_date'];} ?>" ></td>
                                            <td width="10%" align="center">Candidate Reg. No.</td>
                                            <td width="10%" align="center"><input <?php echo $readonly_reg_no;?> type="text" name="stud_reg_no_<?php echo $c ;?>" id="stud_reg_no_<?php echo $c ;?>" value="<?php if($data_course['installment_display_id']) { echo $data_course['installment_display_id'];} ?>" style="width:160px;<?php echo $bg_color_reg_no; ?>" ></td>
                                            <td width="10%" align="center">Certificate Awarded On</td>
                                            <td width="8%" align="center"><input <?php echo $readonly_cert_awarded;?> type="text" style="width:80px;<?php echo $bg_color_cert_awarded; ?>" class="datepicker" name="certificate_date_<?php echo $c ;?>" id="certificate_date_<?php echo $c ;?>" value="<?php if($data_course['certificate_date']) { echo $data_course['certificate_date'];} else echo date('d/m/Y'); ?>" ></td>
                                            <td width="10%" align="center">Certificate Sr. No.</td>
                                            <td width="8%" align="center"><input <?php echo $readonly_cert_sr_no;?> type="text" name="certificate_sr_no_<?php echo $c; ?>" value="<?php if($_POST['certificate_sr_no_'.$c]) echo $_POST['certificate_sr_no_'.$c]; else if($certificate_sr_no !='') echo $certificate_sr_no;?>" class="" placeholder="Enter Certificate No." style="width:100px; <?php echo $bg_color_sr_no; ?>">
                                            </td>
                                            <td width="5%" align="center"><input type="submit" name="save_changes" id="save_changes" value="Save" ></td>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                                echo '<tr>';
                                $sel_data="select status,theory_grade,practical_grade,course_status_date from action_certificate where course_id='".$data_name['course_id']."' and enroll_id='".$data_course['enroll_id']."'";
                                $ptr_seldata=mysql_query($sel_data);
                                $data_crs=mysql_fetch_array($ptr_seldata);
                                
                                if($data_crs['status']=="not_started")
                                    $not_started='checked="checked"';
                                else if($data_crs['status']=="started")
                                    $started='checked="checked"';
                                else if($data_crs['status']=="halted")
                                    $halted='checked="checked"';
                                else if($data_crs['status']=="cancelled")
                                    $cancelled='checked="checked"';
                                else if($data_crs['status']=="restart")
                                    $restart='checked="checked"';
                                else if($data_crs['status']=="finished")
                                    $finished='checked="checked"';
                                
                                $theory_grade=$data_crs['theory_grade'];
                                $practical_grade=$data_crs['practical_grade'];
                                //echo "Parent-".$data_name['is_parent'];
                                $crc_id=$data_name['course_id'];
                                if($data_name['is_parent']!='y')
                                {
                                    $tot_course=1;
                                    $course_status_date='';
                                    if(mysql_num_rows($ptr_seldata))
                                    {
                                        $course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
                                    }
                                    $grade_rec='';
                                    $theory_per='';
                                    $practical_per='';
                                    $grade_per_rec='';
                                    $theory_mark='';
                                    $practical_mark='';
                                    
                                    $sel_grade="select * from action_certificate_grade where enroll_id='".$data_course['enroll_id']."' and course_id='".$crc_id."'";
                                    $ptr_sel=mysql_query($sel_grade);
                                    if(mysql_num_rows($ptr_sel)>0)
                                    {
                                        $data_grade_rec=mysql_fetch_array($ptr_sel);
                                        $grade_rec=$data_grade_rec['grade'];
                                        $theory_per=$data_grade_rec['theory_percentage'];
                                        $practical_per=$data_grade_rec['practical_percentage'];
                                        $theory_mark=$data_grade_rec['theory_mark'];
                                        $practical_mark=$data_grade_rec['practical_mark'];
                                        $grade_per_rec=$data_grade_rec['total_percentage'];
                                    }
                                    
                                    if($_POST['course_status_date_'.$c.'']){$course_status_date=$_POST['course_status_date_'.$c.''];} else if($course_status_date !=''){$course_status_date=$course_status_date;} else {$course_status_date=date('d/m/Y');}
                                    echo '<td><input type="hidden" name="course_status_date_'.$c.'" id="course_status_date_'.$c.'" value="'.$course_status_date.'" class="datepicker" placeholder="course status date"/></td>';
                                    
                                    echo '<td><table width="100%"><tr>';
                                
                                    echo '<td><input type="radio" name="course_status_'.$c.'" value="not_started" '.$not_started.' ></td><td><input type="radio" name="course_status_'.$c.'" value="started" '.$started.' ></td><td><input type="radio" name="course_status_'.$c.'" value="halted" '.$halted.'></td><td><input type="radio" name="course_status_'.$c.'" value="cancelled" '.$cancelled.' ></td><td><input type="radio" name="course_status_'.$c.'" value="restart"'.$restart.' ></td><td><input type="radio" name="course_status_'.$c.'" value="finished" '.$finished.' ></td><tr>
                                    <tr><td>Not Started</td><td>Started</td><td>Halted</td><td>Cancelled</td><td>Restart</td><td>Finished</td>
                                    </tr></table>';
                                    echo '</td>';
                                    
                                    $readonly_grades="";
                                    if($theory_mark >0 && $_SESSION['type']!='S')
                                    {
                                        $readonly_grades='readonly="readonly" style="background-color:#EFEFEF"';
                                    }
                                    /*if($_SESSION['type']=='S')
                                    {
                                        $disabled_grades="";
                                    }*/
                                    
                                    echo '<td><strong>Theory Grade</strong></td>';
                                    echo '<td><input  type="text" placeholder="Theory Grade" name="theory_grade_'.$data_name['course_id'].'_'.$c.'" id="theory_grade_'.$data_name['course_id'].'_'.$c.'" '.$readonly_grades.' value="'.$theory_mark.'" /> <input type="hidden" name="theory_per_'.$crc_id.'_'.$c.'" id="theory_per_'.$crc_id.'_'.$c.'" value="'.$theory_per.'" /></td>';
                                    echo '<td><strong>Practical Grade</strong></td>';
                                    echo '<td><input type="text" placeholder="Practical Grade" name="practical_grade_'.$data_name['course_id'].'_'.$c.'" id="practical_grade_'.$data_name['course_id'].'_'.$c.'" '.$readonly_grades.' value="'.$practical_mark.'" /><input type="hidden" name="practical_per_'.$crc_id.'_'.$c.'" id="practical_per_'.$crc_id.'_'.$c.'" value="'.$practical_per.'" /></td>';
                                    echo '<td id="grade_status_'.$crc_id.'" style="text-align:center;font-weight:bold;font-size:17px;color:green">'.$grade_rec.'</td>';
                                    echo '<td><input type="button" name="calculate_grade" value="Calculate Grade" id="calculate_grade" '.$readonly_grades.' onClick="calc_grade('.$data_course['enroll_id'].','.$crc_id.','.$c.')"><input type="hidden" name="tot_per_'.$crc_id.'" id="tot_per_'.$crc_id.'" value="'.$grade_per_rec.'" /><input type="hidden" name="tot_sub_grade_per_'.$crc_id.'" id="tot_sub_grade_per_'.$crc_id.'" value="'.$grade_per_rec.'" /><input type="hidden" name="tot_sub_grade_'.$crc_id.'" id="tot_sub_grade_'.$crc_id.'" value="'.$grade_rec.'" /><input type="hidden" name="is_print'.$crc_id.'" id="is_print'.$crc_id.'" value="y" /></td>';
                                }
                                else
                                {
                                    ?>
                                    <tr>
                                        <td colspan="2" align="center" id="grade_status_<?php echo $crc_id; ?>" style="text-align:center;font-weight:bold;font-size:17px;color:green"></td>
                                       <input type="hidden" name="course_id_<?php echo $c;?>" id="course_id_<?php echo $c ;?>" value="<?php echo $crc_id; ?>"><input type="hidden" name="enroll_id_<?php echo $c;?>" id="enroll_id_<?php echo $c ;?>" value="<?php echo $data_course['enroll_id'];?>">
                                        <?php
                                        $grade_data_rec='';
                                        $grade_data_per_rec='';
                                        $sel_grade="select * from action_certificate_grade where enroll_id='".$data_course['enroll_id']."' and course_id='".$crc_id."'";
                                        $ptr_sel=mysql_query($sel_grade);
                                        if(mysql_num_rows($ptr_sel))
                                        {
                                            $data_grade_rec=mysql_fetch_array($ptr_sel);
                                            $grade_data_rec=$data_grade_rec['grade'];
                                            $grade_data_per_rec=$data_grade_rec['total_percentage'];
                                        }
                                        echo '<td colspan="2" align="center" id="sub_grade_status_'.$crc_id.'" style="text-align:center;font-weight:bold;font-size:17px;color:green">'.$grade_data_rec.'</td>';
                                        /*echo '<td align="center"><input type="text" placeholder="Theory Grade" name="theory_grade_'.$crs_child_id.'_'.$ch.'" id="theory_grade_'.$crs_child_id.'_'.$ch.'" '.$disabled_grades.' value="'.$theory_grade.'" /><input type="hidden" name="theory_per_'.$crs_child_id.'_'.$ch.'" id="theory_per_'.$crs_child_id.'_'.$ch.'" /></td>';
                                        echo '<td align="center"><input type="text" placeholder="Practical Grade" name="practical_grade_'.$crs_child_id.'_'.$ch.'" id="practical_grade_'.$crs_child_id.'_'.$ch.'" '.$disabled_grades.' value="'.$practical_grade.'" /><input type="hidden" name="practical_per_'.$crs_child_id.'_'.$ch.'" id="practical_per_'.$crs_child_id.'_'.$ch.'" /></td>';*/
                                        if($data_name['course_type']!='integrated')
                                        {
                                            echo '<td align="right"><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calc_diploma_grade('.$data_course['enroll_id'].','.$crc_id.','.$ch.')"><input type="hidden" name="tot_sub_grade_per_'.$crc_id.'" id="tot_sub_grade_per_'.$crc_id.'" value="'.$grade_data_per_rec.'" /><input type="hidden" name="tot_sub_grade_'.$crc_id.'" id="tot_sub_grade_'.$crc_id.'" value="'.$grade_data_rec.'" /><input type="hidden" name="is_print'.$crc_id.'" id="is_print'.$crc_id.'" value="y" /></td>';
                                        }
                                        echo '</tr>';
                                        
                                    //echo '<td><strong>Theory Grade</strong></td>';
                                    //echo '<td><input type="text" name="theory_grade_'.$c.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
                                    //echo '<td><strong>Practical Grade</strong></td>';
                                    //echo '<td><input type="text" name="practical_grade_'.$c.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';
                                }
                                echo '<tr><td colspan="9"><hr class="hr_line"></td></tr>';
                                echo'</tr>';
                                
                                //=========================Diploma Course Start================================
                                $tot_course=0;
                                $sel_child="select c.course_name,c.is_parent,cm.course_id from courses c, courses_map cm where 1 and c.course_id=cm.course_id and cm.course_parent_id='".$data_name['course_id']."'";
                                $ptr_child=mysql_query($sel_child);
                                if($totals_course=mysql_num_rows($ptr_child))
                                {
                                    $tot_course=$totals_course;
                                    $totals_child_course=0;
                                    $ch=1;
                                    while($data_child=mysql_fetch_array($ptr_child))
                                    {
                                        $crc_ids=$data_child['course_id'];
                                        $sel_data="select status,theory_grade,practical_grade,course_status_date from action_certificate where course_id='".$data_child['course_id']."' and enroll_id='".$data_course['enroll_id']."'";
                                        $ptr_seldata=mysql_query($sel_data);
                                        $data_crs=mysql_fetch_array($ptr_seldata);
                                        $course_status_date='';
                                        //echo "is parent-".$data_child['is_parent'];
                                        $select_child_name="select course_name,course_id,is_parent from courses where course_id='".$data_child['course_id']."'";
                                        $ptr_child_name=mysql_query($select_child_name);
                                        $data_chile_course_name=mysql_fetch_array($ptr_child_name);
                                        
                                        if(mysql_num_rows($ptr_seldata))
                                        {
                                            $course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
                                        }
                                        
                                        if($data_crs['status']=="not_started")
                                            $not_started='checked="checked"';
                                        else if($data_crs['status']=="started")
                                            $started='checked="checked"';
                                        else if($data_crs['status']=="halted")
                                            $halted='checked="checked"';
                                        else if($data_crs['status']=="cancelled")
                                            $cancelled='checked="checked"';
                                        else if($data_crs['status']=="restart")
                                            $restart='checked="checked"';
                                        else if($data_crs['status']=="finished")
                                            $finished='checked="checked"';
                                        
                                        $theory_grade=$data_crs['theory_grade'];
                                        $practical_grade=$data_crs['practical_grade'];
                                        echo '<input type="hidden" name="is_diploma_course" id="is_integrated_course" value="'.$data_child['is_parent'].'">';
                                        //=====================Check Diploma Level================================
                                        $grade_rec='';
                                        $theory_per='';
                                        $practical_per='';
                                        $theory_mark='';
                                        $practical_mark='';
                                        $grade_per_rec='';
                                        if($data_child['is_parent']!='y')
                                        {
                                            //$c=1;  
                                            $totals_child_course=0;
                                            $course_status_date='';
                                            if(mysql_num_rows($ptr_seldata))
                                            {
                                                $course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
                                            }
                                            
                                            $sel_grade="select * from action_certificate_grade where enroll_id='".$data_course['enroll_id']."' and course_id='".$crc_ids."'";
                                            $ptr_sel=mysql_query($sel_grade);
                                            if(mysql_num_rows($ptr_sel))
                                            {
                                                $data_grade_rec=mysql_fetch_array($ptr_sel);
                                                $grade_rec=$data_grade_rec['grade'];
                                                $theory_per=$data_grade_rec['theory_percentage'];
                                                $practical_per=$data_grade_rec['practical_percentage'];
                                                $theory_mark=$data_grade_rec['theory_mark'];
                                                $practical_mark=$data_grade_rec['practical_mark'];
                                                $grade_per_rec=$data_grade_rec['total_percentage'];
                                            }
                                            echo '<tr><td id="grade_status_'.$crc_ids.'" style="text-align:center;font-weight:bold;font-size:17px;color:green">'.$grade_rec.'</td>';
                                            echo '<td colspan="3" align="left"><span style="padding-left:5px;font-size:13px;font-weight:bold">'.$ch.'. '.$data_chile_course_name['course_name'].'</span><input type="hidden" name="course_id_'.$c.'_'.$ch.'" id="course_id_'.$c.'_'.$ch.'" value="'.$data_chile_course_name['course_id'].'" ><br/></td>';
                                            if($_POST['course_status_date_'.$c.'_'.$ch.'']) {$course_status_date=$_POST['course_status_date_'.$c.'_'.$ch.''];} else if($course_status_date !='') {$course_status_date=$course_status_date;} else {$course_status_date=date('d/m/Y');} 
											echo '<td><input type="hidden" name="course_status_date_'.$c.'_'.$ch.'" id="course_status_date_'.$c.'_'.$ch.'" value="'.$course_status_date.'" class="datepicker" placeholder="course status date"/></td>';
											echo '<td><table width="100%"><tr>';
                                            //echo '<input type="hidden" name="total_sub_course_'.$c.'" id="total_sub_course_'.$c.'" value="'.$tot_course.'" >';
                                        	echo '<td><input type="radio" name="course_status_'.$c.'_'.$ch.'"  value="not_started" '.$not_started.' ></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="started" '.$started.' ></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="halted" '.$halted.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="cancelled" '.$cancelled.' ></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="restart"'.$restart.' ></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="finished" '.$finished.' ></td><tr>
                                            <tr><td>Not Started</td><td>Started</td><td>Halted</td><td>Cancelled</td><td>Restart</td><td>Finished</td>
                                            </tr></table>';
                                            echo '</td>';
                                            
                                            $readonly_grades=""; //10-10-19
                                            if($data_crs['status']=="finished" && $_SESSION['type']!="S")
                                            {
                                                $readonly_grades='readonly="readonly" style="background-color:#EFEFEF"';
                                            }
                                            
                                            /*echo '<td><input type="text" placeholder="Theory Grade" name="theory_grade_'.$crc_ids.'_'.$ch.'" id="theory_grade_'.$crc_ids.'_'.$ch.'" '.$disabled_grades.' value="'.$theory_grade.'" /><input type="hidden" name="theory_per_'.$crc_ids.'_'.$ch.'" id="theory_per_'.$crc_ids.'_'.$ch.'" /></td>';
                                            
                                            echo '<td><input type="text" placeholder="Practical Grade" name="practical_grade_'.$crc_ids.'_'.$ch.'" id="practical_grade_'.$crc_ids.'_'.$ch.'" '.$disabled_grades.' value="'.$practical_grade.'" /><input type="hidden" name="practical_per_'.$crc_ids.'_'.$ch.'" id="practical_per_'.$crc_ids.'_'.$ch.'" /></td>';
                                            echo '<td><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calc_grade('.$crc_ids.','.$ch.')"><input type="hidden" name="tot_sub_grade_'.$crc_ids.'" id="tot_sub_grade_'.$crc_ids.'" value="'.$grade_per_rec.'" /><input type="hidden" name="tot_per_'.$crc_ids.'" id="tot_per_'.$crc_ids.'" /></td></tr>';*/
                                            
                                            echo '<td align="center"><input type="text" placeholder="Theory Grade" name="theory_grade_'.$crc_ids.'_'.$ch.'" id="theory_grade_'.$crc_ids.'_'.$ch.'" '.$readonly_grades.' value="'.$theory_mark.'" ><input type="hidden" name="theory_per_'.$crc_ids.'_'.$ch.'" id="theory_per_'.$crc_ids.'_'.$ch.'" value="'.$theory_per.'"></td>';
                                            echo '<td align="center"><input type="text" placeholder="Practical Grade" name="practical_grade_'.$crc_ids.'_'.$ch.'" id="practical_grade_'.$crc_ids.'_'.$ch.'" '.$readonly_grades.' value="'.$practical_mark.'" /> <input type="hidden" name="practical_per_'.$crc_ids.'_'.$ch.'" id="practical_per_'.$crc_ids.'_'.$ch.'" value="'.$practical_per.'" /></td>';
											echo '<td><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calc_grade('.$data_course['enroll_id'].','.$crc_ids.','.$ch.')"><input type="hidden" name="tot_per_'.$crc_ids.'" id="tot_per_'.$crc_ids.'" /><input type="hidden" name="tot_sub_grade_'.$crc_ids.'" id="tot_sub_grade_'.$crc_ids.'" value="'.$grade_per_rec.'" /><input type="hidden" name="is_print'.$crc_ids.'" id="is_print'.$crc_ids.'" value="" /></td>';
                                        }
                                        else
                                        {
                                            $select_child_name="select course_name,course_id,is_parent from courses where course_id='".$data_child['course_id']."'";
                                            $ptr_child_name=mysql_query($select_child_name);
                                            $s=1;
                                            $data_child_name=mysql_fetch_array($ptr_child_name);
                                            $crs_child_id=$data_child_name['course_id'];
                                            ?>
                                            
                                            <tr>
                                                <td id="grade_status_<?php echo $crs_child_id; ?>" style="text-align:center;font-weight:bold;font-size:17px;color:green"></td>
                                                <td align="left" colspan="3" style="padding-left:10px;"><span style="font-weight:bold; font-size:13px"><?php echo $ch.'. '.$data_child_name['course_name']; ?></span></td> 
                                                <input type="hidden" name="course_id_<?php echo $c ;?>_<?php echo $ch ;?>" id="course_id_<?php echo $c ;?>_<?php echo $ch ;?>" value="<?php echo $data_child_name['course_id']; ?>" >
                                                <?php
                                                $grade_data_rec='';
                                                $grade_data_per_rec='';
                                                $sel_grade="select * from action_certificate_grade where enroll_id='".$data_course['enroll_id']."' and course_id='".$crs_child_id."'";
                                                $ptr_sel=mysql_query($sel_grade);
                                                if(mysql_num_rows($ptr_sel))
                                                {
                                                    $data_grade_rec=mysql_fetch_array($ptr_sel);
                                                    $grade_data_rec=$data_grade_rec['grade'];
                                                    $grade_data_per_rec=$data_grade_rec['total_percentage'];
                                                }
                                                echo '<td id="sub_grade_status_'.$crs_child_id.'" style="text-align:center;font-weight:bold;font-size:17px;color:green">'.$grade_data_rec.'</td>';
                                                /*echo '<td align="center"><input type="text" placeholder="Theory Grade" name="theory_grade_'.$crs_child_id.'_'.$ch.'" id="theory_grade_'.$crs_child_id.'_'.$ch.'" '.$disabled_grades.' value="'.$theory_grade.'" /><input type="hidden" name="theory_per_'.$crs_child_id.'_'.$ch.'" id="theory_per_'.$crs_child_id.'_'.$ch.'" /></td>';
                                                echo '<td align="center"><input type="text" placeholder="Practical Grade" name="practical_grade_'.$crs_child_id.'_'.$ch.'" id="practical_grade_'.$crs_child_id.'_'.$ch.'" '.$disabled_grades.' value="'.$practical_grade.'" /><input type="hidden" name="practical_per_'.$crs_child_id.'_'.$ch.'" id="practical_per_'.$crs_child_id.'_'.$ch.'" /></td>';*/
                                                echo '<td><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calc_diploma_grade('.$data_course['enroll_id'].','.$crs_child_id.','.$ch.')"><input type="hidden" name="tot_sub_grade_per_'.$crs_child_id.'" id="tot_sub_grade_per_'.$crs_child_id.'" value="'.$grade_data_per_rec.'" /><input type="hidden" name="tot_sub_grade_'.$crs_child_id.'" id="tot_sub_grade_'.$crs_child_id.'" value="'.$grade_data_rec.'" /></td><input type="hidden" name="is_print'.$crs_child_id.'" id="is_print'.$crs_child_id.'" value="" />';
                                                
                                                ?>                                                        
                                                <!--<td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['net_fees']; ?></span></td>
                                                <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['paid']; ?></span></td>
                                                <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['balance_amt']; ?> </span></td>
                                                <td align="center" style="padding-left:10px;"><span style="font-weight:bold">-->
                                                <?php
                                                /*$sel_inst="SELECT * FROM `installment` where enroll_id ='".$data_course['enroll_id']."' and course_id='".$data_course['course_id']."'  ";
                                                $ptr_ins=mysql_query($sel_inst);
                                                if(mysql_num_rows($ptr_ins))
                                                {
                                                    while($data_inst=mysql_fetch_array($ptr_ins))
                                                    {
                                                        $col_paid ='<font color="#006600">';
                                                        if($data_inst['status'] =='not paid')
                                                            $col_paid ='<font color="#FF3333">';
                                                        echo $data_inst['installment_amount'].'/- '.$data_inst['installment_date'].' : '.$col_paid.$data_inst['status']."</font><br>";	
                                                    }
                                                }
                                                else
                                                {
                                                }
                                                $sel_inv="SELECT * FROM invoice where enroll_id=".$data_course['enroll_id']." and status='paid'";
                                                $ptr_inv=mysql_query($sel_inv);
                                                while($data_inv=mysql_fetch_array($ptr_inv))
                                                {
                                                    $col_paid_inv ='';
                                                    $col_paid ='<font color="#FF3333">';
                                                    $date_i=explode(" ",$data_inv['added_date']);
                                                    $date_invs=$date_i[0];
                                                    echo $data_inv['amount'].'/- '.$date_invs.' :<font color="#006600"> '.$data_inv['status'].'</font><br>';	
                                                }*/
                                                ?>
                                                <!--</span>                                  
                                                </td>
                                                <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['added_date']; ?></span></td>-->
                                            </tr>
                                            
                                            <?php
                                            /*echo '<td><strong>Theory Grade</strong></td>';
                                            echo '<td><input type="text" name="theory_grade_'.$c.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
                                            echo '<td><strong>Practical Grade</strong></td>';
                                            echo '<td><input type="text" name="practical_grade_'.$c.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';*/
                                        }
                                        //=====================Cerificate Level Course Category===============\
                                        if($data_child['is_parent']=='y')
                                        {
                                            $sel_sub_child="select c.course_name,c.is_parent,cm.course_id from courses c,courses_map cm where 1 and c.course_id=cm.course_id and cm.course_parent_id='".$data_child['course_id']."'";
                                            $ptr_sub_child=mysql_query($sel_sub_child);
                                            if($totals_child_course=mysql_num_rows($ptr_sub_child))
                                            {
                                                $subch=1;
                                                while($data_sub_child=mysql_fetch_array($ptr_sub_child))
                                                {
                                                    $crc_sub_id=$data_sub_child['course_id'];
                                                    $sel_data="select status,theory_grade,practical_grade,course_status_date from action_certificate where course_id='".$data_sub_child['course_id']."' and enroll_id='".$data_course['enroll_id']."'";
                                                    $ptr_seldata=mysql_query($sel_data);
                                                    $data_crs=mysql_fetch_array($ptr_seldata);
                                                    $course_status_date='';
                                                    if(mysql_num_rows($ptr_seldata))
                                                    {
                                                    	$course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
                                                    }
                                                    
                                                    if($data_crs['status']=="not_started")
                                                        $not_started='checked="checked"';
                                                    else if($data_crs['status']=="started")
                                                        $started='checked="checked"';
                                                    else if($data_crs['status']=="halted")
                                                        $halted='checked="checked"';
                                                    else if($data_crs['status']=="cancelled")
                                                        $cancelled='checked="checked"';
                                                    else if($data_crs['status']=="restart")
                                                        $restart='checked="checked"';
                                                    else if($data_crs['status']=="finished")
                                                        $finished='checked="checked"';
                                                    
                                                    $theory_grade=$data_crs['theory_grade'];
                                                    $practical_grade=$data_crs['practical_grade'];
                                                    
                                                    $grade_rec='';
                                                    $theory_per='';
                                                    $practical_per='';
                                                    $grade_per_rec='';
                                                    $theory_mark='';
                                                    $practical_mark='';
                                                    $sel_grade="select * from action_certificate_grade where enroll_id='".$data_course['enroll_id']."' and course_id='".$crc_sub_id."'";
                                                    $ptr_sel=mysql_query($sel_grade);
                                                    if(mysql_num_rows($ptr_sel))
                                                    {
                                                        $data_grade_rec=mysql_fetch_array($ptr_sel);
                                                        $grade_rec=$data_grade_rec['grade'];
                                                        $theory_per=$data_grade_rec['theory_percentage'];
                                                        $practical_per=$data_grade_rec['practical_percentage'];
                                                        $theory_mark=$data_grade_rec['theory_mark'];
                                                        $practical_mark=$data_grade_rec['practical_mark'];
                                                        $grade_per_rec=$data_grade_rec['total_percentage'];
                                                    }
                                                    
                                                    echo '<tr>';
                                                    
                                                    echo '<td id="grade_status_'.$crc_sub_id.'" style="text-align:center;font-weight:bold;font-size:17px;color:green">'.$grade_rec.'</td>';
                                                    echo '<td colspan="3" align="right"><span style="padding-left:15px">'.$subch.') '.$data_sub_child['course_name'].'</span><input type="hidden" name="course_id_'.$c.'_'.$ch.'_'.$subch.'" id="course_id_'.$c.'_'.$ch.'_'.$subch.'" value="'.$data_sub_child['course_id'].'" ><br/></td>';
                                                    
                                                    if($_POST['course_status_date_'.$c.'_'.$ch.'_'.$subch.'']) { $course_status_date=$_POST['course_status_date_'.$c.'_'.$ch.'_'.$subch.''];} else if($course_status_date !='') { $course_status_date=$course_status_date;} else {$course_status_date=date('d/m/Y'); }
                                                    
                                                    echo '<td><input type="hidden" name="course_status_date_'.$c.'_'.$ch.'_'.$subch.'" id="course_status_date_'.$c.'_'.$ch.'_'.$subch.'" value="'.$course_status_date.'" class="datepicker" placeholder="course status date"/></td>';
                                                    echo '<td><table width="100%"><tr>';
                                                    echo '<td><input type="radio" name="course_status_'.$c.'_'.$ch.'_'.$subch.'" value="not_started" '.$not_started.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'_'.$subch.'" value="started" '.$started.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'_'.$subch.'" value="halted" '.$halted.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'_'.$subch.'" value="cancelled" '.$cancelled.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'_'.$subch.'" value="restart" '.$restart.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'_'.$subch.'" value="finished" '.$finished.'></td><tr>
                                                    <tr><td>Not Started</td><td>Started</td><td>Halted</td><td>Cancelled</td><td>Restart</td><td>Finished</td></tr></table>';
                                                    echo '</td>';
                                                    
													$readonly_grades="";
                                                    if($data_crs['status']=="finished" && $_SESSION['type']!='S')
													{
														$readonly_grades='readonly="readonly" style="background-color:#EFEFEF"';
													}

                                                    
                                                    echo '<td align="center"><input type="text" placeholder="Theory Grade" name="theory_grade_'.$crc_sub_id.'_'.$subch.'" id="theory_grade_'.$crc_sub_id.'_'.$subch.'" '.$readonly_grades.' value="'.$theory_mark.'" /><input type="hidden" name="theory_per_'.$crc_sub_id.'_'.$subch.'" id="theory_per_'.$crc_sub_id.'_'.$subch.'" value="'.$theory_per.'" /></td>';
                                                    echo '<td align="center"><input type="text" placeholder="Practical Grade" name="practical_grade_'.$crc_sub_id.'_'.$subch.'" id="practical_grade_'.$crc_sub_id.'_'.$subch.'" '.$readonly_grades.' value="'.$practical_mark.'" /> <input type="hidden" name="practical_per_'.$crc_sub_id.'_'.$subch.'" id="practical_per_'.$crc_sub_id.'_'.$subch.'" value="'.$practical_per.'" /></td>';
                                                    echo '<td><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calc_grade('.$data_course['enroll_id'].','.$crc_sub_id.','.$subch.')"><input type="hidden" name="tot_per_'.$crc_sub_id.'" id="tot_per_'.$crc_sub_id.'" /><input type="hidden" name="is_print'.$crc_sub_id.'" id="is_print'.$crc_sub_id.'" value="" /><input type="hidden" name="tot_sub_grade_'.$crc_sub_id.'" id="tot_sub_grade_'.$crc_sub_id.'" value="'.$grade_per_rec.'" /></td>';
                                                    echo '</tr>';
                                                    $subch++;
                                                }
                                                //echo '<input type="hidden" name="total_sub_child_course_'.$c.'_'.$ch.'_'.$subch.'" id="total_sub_child_course_'.$c.'_'.$ch.'_'.$subch.'" value="'.$totals_child_course.'" >';
                                            }
                                        }
                                        echo '<input type="hidden" name="total_sub_course_'.$c.'_'.$ch.'" id="total_sub_course_'.$c.'_'.$ch.'" value="'.$totals_child_course.'" >';				
                                        $ch++;
                                    }
                                }
                                
                                echo '<tr><td colspan="9"><hr class="hr_line"></td></tr>';
                                
                                //=======================================================================================
                               	$sel_final="select * from action_final where enroll_id=".$data_course['enroll_id']." and course_id='".$data_course['course_id']."' order by action_final_id desc limit 0,1";
                                $ptr_sel_final= mysql_query($sel_final);
                                if(mysql_num_rows($ptr_sel_final))
                                {
                                    $data_final=mysql_fetch_array($ptr_sel_final);
									
                                    $completion_date='';
                                    if($data_final['completion_date']!='')
                                    {
                                        $completion_date=date("d/m/Y", strtotime($data_final['completion_date']));
                                    }
                                    $payment_cleared_date='';
                                    if($data_final['payment_cleared_date'])
                                    {
                                        $payment_cleared_date=date("d/m/Y", strtotime($data_final['payment_cleared_date']));
                                    }
                                    $logbook_completed_date='';
                                    if($data_final['logbook_completed_date'])
                                    {
                                        $logbook_completed_date=date("d/m/Y", strtotime($data_final['logbook_completed_date']));
                                    }
                                    $certificate_print_date='';
                                    if($data_final['certificate_print_date'])
                                    {
                                        $certificate_print_date=date("d/m/Y", strtotime($data_final['certificate_print_date']));
                                    }
                                    $certificate_issue_date='';
                                    if($data_final['certificate_issue_date'])
                                    {
                                        $certificate_issue_date=date("d/m/Y", strtotime($data_final['certificate_issue_date']));
                                    }
                                   	$payment_cleared_action=$data_final['payment_cleared_action'];
                                    $logbook_completed_action=$data_final['logbook_completed_action'];
                                    $print_certificate_action=$data_final['print_certificate_action'];
                                    $issue_certificate_action=$data_final['issue_certificate_action'];
                                    $certificate_by_staff=$data_final['certificate_by_staff'];
                                    $certificate_type=trim($data_final['certificate_type']);
									
                                }
                                ?>
                                <tr>
                                    <td colspan="9">
                                    <table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
                                        <tr>
                                            <td width="17%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Course Completetion Date</span></td>
                                            <td width="16%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Logbook Completed</span></td>
                                            <td width="17%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">All Payment Cleared</span></td>
                                            <td width="16%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Certificate Action</span></td>
                                            <td width="17%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Print Certificate</span></td>
                                            <td width="17%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Issued Certificate</span></td>
                                        </tr>
                                        <tr>
                                            <?php 
                                            $py_disb='';
                                            if($completion_date!='' && $_SESSION['type']!='S')
                                            {
												?>
                                                <td width="17%" align="center" style="padding-left:10px;"><img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified"><br/><?php echo $completion_date; ?><input type="hidden" name="complition_date_<?php echo $c; ?>" value="<?php if($_POST['complition_date']) echo $_POST['complition_date']; else if($completion_date !='') echo $completion_date; else echo date('d/m/Y');?>" class="datepicker"></td>
                                                <?php
												$py_disb='readonly="readonly"';
											}
											else
											{
												?>
                                                <td width="17%" align="center" style="padding-left:10px;"><input type="text" name="complition_date_<?php echo $c; ?>" value="<?php if($_POST['complition_date']) echo $_POST['complition_date']; else if($completion_date !='') echo $completion_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Completion date"></td>
                                                <?php
												$py_disb='';
											}
											?>
                                            
                                            <?php
                                            $lb_disb='';
                                           // if($logbook_completed_date!='' &&  ($_SESSION['type']!='S' || $_SESSION['type']!='Z'|| $_SESSION['type']!='LD'))
										   	if($logbook_completed_action!='' && $_SESSION['type']!='S')
                                            {
												?>
                                                <td width="16%" align="center"  style="padding-left:10px;">
                                                <img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified"><br/><?php echo $logbook_completed_date; ?>
                                                <input type="hidden" name="logbook_action_<?php echo $c; ?>" <?php if($logbook_completed_action!='') {echo 'checked="checked"' ;}?> value="yes"><br/><input type="hidden" name="logbook_date_<?php echo $c; ?>" value="<?php if($_POST['logbook_date']) echo $_POST['logbook_date']; else if($logbook_completed_date !='') echo $logbook_completed_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Logbbok date">
                                                </td>      
                                                <?php
                                                $lb_disb='readonly="readonly"';
                                            }
											else
											{
												?>
                                                <td width="16%" align="center"  style="padding-left:10px;"><input type="checkbox" <?php echo $lb_disb; ?> name="logbook_action_<?php echo $c; ?>" <?php if($logbook_completed_action!='') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" name="logbook_date_<?php echo $c; ?>" <?php echo $lb_disb; ?> value="<?php if($_POST['logbook_date']) echo $_POST['logbook_date']; else if($logbook_completed_date !='') echo $logbook_completed_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Logbbok date "/>
                                                </td>      
                                                <?php
											}
											//==============Payment Cleared Action=============
                                            $readonly_ac='';
                                            if($payment_cleared_action=='yes' && $_SESSION['type']!="S")
                                            {
												?>
                                                <td width="17%" align="center" style="padding-left:10px;">
                                                <img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified"><br/><?php echo $payment_cleared_date; ?>
                                                <input type="hidden" name="payment_cleared_<?php echo $c; ?>" <?php if($payment_cleared_action=='yes') {echo 'checked="checked"' ;}?> value="yes"><br/><input type="hidden" name="payment_complition_date_<?php echo $c; ?>" value="<?php if($_POST['payment_complition_date']) echo $_POST['payment_complition_date']; else if($payment_cleared_date !='') echo $payment_cleared_date; else echo date('d/m/Y');?>" class="datepicker"></td>
                                                <?php
                                               $readonly_ac='readonly="readonly"';
                                            }
											else if($payment_cleared_action <=0 && ($_SESSION['admin_id']=="41" || $_SESSION['admin_id']=="9" || $_SESSION['type']=='AC' || $_SESSION['type']=='S' || $_SESSION['type']=='Z'))
											{
												?>
                                                <td width="17%" align="center" style="padding-left:10px;"><input type="checkbox" name="payment_cleared_<?php echo $c; ?>"  <?php echo $disable_ac;?> <?php if($payment_cleared_action=='yes') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" <?php echo $disable_ac;?> name="payment_complition_date_<?php echo $c; ?>" value="<?php if($_POST['payment_complition_date']) echo $_POST['payment_complition_date']; else if($payment_cleared_date !='') echo $payment_cleared_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Payment Completion date"></td>
                                                <?php
											}
											else if($payment_cleared_action > 0 && $_SESSION['type']=="S")
											{
												?>
                                                <td width="17%" align="center" style="padding-left:10px;"><input type="checkbox" name="payment_cleared_<?php echo $c; ?>"  <?php echo $disable_ac;?> <?php if($payment_cleared_action=='yes') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" <?php echo $disable_ac;?> name="payment_complition_date_<?php echo $c; ?>" value="<?php if($_POST['payment_complition_date']) echo $_POST['payment_complition_date']; else if($payment_cleared_date !='') echo $payment_cleared_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Payment Completion date"></td>
                                                <?php
											}
											else
											{
												?>
                                                <td width="17%" align="center" style="padding-left:10px;">Please Take Payment Confirmation From Account Department</td>
                                                <?php
											}
                                            //===============CERTIFICATE ACTION=================
											//$certificate_action='disabled="disabled"';
                                            if(($payment_cleared_action!='' && $logbook_completed_action!='' && $print_certificate_action=='' && ($_SESSION['type']=="LD" || $_SESSION['type']=="Z")) || $_SESSION['type']=="S")
                                            {
												?>
                                                <td width="16%" align="center"  style="padding-left:10px;"><input type="checkbox" <?php //echo $certificate_action;?> name="certificate_printed_<?php echo $c; ?>" <?php if($print_certificate_action!='') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" <?php //echo $disable_certificate_action; ?> name="print_certificate_date_<?php echo $c; ?>" value="<?php if($_POST['print_certificate_date']) echo $_POST['print_certificate_date']; else if($certificate_print_date !='') echo $certificate_print_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Print Certificate date">
                                                </td>
                                                <?php
                                                //$certificate_action="";
                                            }
											else if($print_certificate_action!='')
											{
												?>
                                                <td width="16%" align="center" style="padding-left:10px;">
                                                <img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified"><br/><?php echo $certificate_print_date; ?>
                                                <input type="hidden" name="certificate_printed_<?php echo $c; ?>" <?php if($print_certificate_action!='') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="hidden" name="print_certificate_date_<?php echo $c; ?>" value="<?php if($_POST['print_certificate_date']) echo $_POST['print_certificate_date']; else if($certificate_print_date !='') echo $certificate_print_date; else echo date('d/m/Y');?>" class="datepicker">
                                                </td>
                                                <?php
											}
											else
											{
												?>
                                                <td width="16%" align="center"  style="padding-left:10px;">
                                                Please clear the Payment or Only Admin and LD will check this.
                                                <input type="hidden" name="certificate_printed_<?php echo $c; ?>" <?php if($print_certificate_action!='') {echo 'checked="checked"' ;}?> value="" ><br/><input type="hidden" name="print_certificate_date_<?php echo $c; ?>" value="<?php if($certificate_print_date !='') echo $certificate_print_date;?>">
                                                </td>
                                                <?php
											}
											//====================CERTIFICATE PRINTED===============
											
                                            //$disable_certificate_action='disabled="disabled"';
                                            if(($payment_cleared_action!='' && $print_certificate_action!='') || $_SESSION['type']=="S")
                                            {
												?>
                                                <td width="18%" align="center">
                                                <!--<select name="certificate_type_<?php /*echo $c; ?>" id="certificate_type_<?php echo $c; ?>" <?php //echo $disable_certificate; ?> class="input_select" style="width:150px; margin-bottom:5px">
                                                <option value="" >Select Certificate</option>
                                                <option <?php if($certificate_type=="certificate_level") echo 'selected="selected"';else if($data_name['course_type']!='integrated' || $data_name['course_type']!='diploma_level')echo 'selected="selected"'; ?> value="certificate_level" >Certificate level/Diploma level</option>
                                                <option <?php if($certificate_type=="DIC") echo 'selected="selected"'; else if($data_name['course_type']=='diploma_level') echo 'selected="selected"'; ?> value="DIC" >DIC</option>
                                                <option <?php if($certificate_type=="PGDC") echo 'selected="selected"';else if($data_name['course_id']=='11') echo 'selected="selected"'; ?> value="PGDC" >PGDC</option>
                                                <option <?php if($certificate_type=="PGDC-NAIL") echo 'selected="selected"';?> value="PGDC-NAIL" >PGDC-NAIL</option>
                                                <option <?php if($certificate_type=="MIC") echo 'selected="selected"';else if($data_course['course_id']=='52') echo 'selected="selected"';*/ ?> value="MIC" >MIC</option>
                                                </select>-->
                                                <br/>
                                                <?php 
                                                $mobiles = array("firefox");
                                                $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
                                                $i=0;
                                                
                                                foreach($mobiles as $mobile) {
                                                    if(strpos($agent, $mobile) !== false) {
                                                      $i += 1; // I have tested it with a loop of 10, 50, 100 and 1000 that $i += 1 is faster than $i++
                                                    }
                                                }
                                                if($i >= 1)
                                                {
													if(date('Y-m-d') > '2022-06-30')
													{
														$action_final="select action_final_id from action_final where enroll_id='".$data_course['enroll_id']."' and course_id='".$data_course['course_id']."' and final_print_certificate!=''";
													}
													else
													{
														$action_final="select action_final_id from action_final where enroll_id='".$data_course['enroll_id']."' and course_id='".$data_course['course_id']."' and print_certificate_action!=''";
													}
                                                    $ptr_action=mysql_query($action_final);
                                                    if(mysql_num_rows($ptr_action))
                                                    {
														
														if($_SESSION['type']=='S')
                                                        {
															?>
														<select name="certificate_type_<?php echo $c; ?>" id="certificate_type_<?php echo $c; ?>" class="input_select" style="width:150px; margin-bottom:5px">
															<option value="">Select Certificate</option>
															<option <?php if($certificate_type=="certificate_level") echo 'selected="selected"';else if($data_name['course_type']!='integrated' || $data_name['course_type']!='diploma_level')echo 'selected="selected"'; ?> value="certificate_level" >Certificate level/Diploma level</option>
															<option <?php if($certificate_type=="DIC") echo 'selected="selected"'; else if($data_name['course_type']=='diploma_level') echo 'selected="selected"'; ?> value="DIC" >DIC</option>
															<option <?php if($certificate_type=="PGDC") echo 'selected="selected"';else if($data_name['course_id']=='11') echo 'selected="selected"'; ?> value="PGDC" >PGDC</option>
															<option <?php if($certificate_type=="PGDC-NAIL") echo 'selected="selected"';?> value="PGDC-NAIL" >PGDC-NAIL</option>
															<option <?php if($certificate_type=="MIC") echo 'selected="selected"';else if($data_course['course_id']=='52') echo 'selected="selected"'; ?> value="MIC" >MIC</option>
															<!--<option <?php //if($certificate_type=="Event") echo 'selected="selected"'; ?> value="Event" >Event</option>
															<option <?php //if($certificate_type=="Workshop") echo 'selected="selected"'; ?> value="Workshop" >Workshop</option>
															<option <?php //if($certificate_type=="Biotop_hair_workshop_Participation") echo 'selected="selected"'; ?> value="Biotop_hair_workshop_Participation" >Biotop Hair Workshop Participation</option>
															<option <?php //if($certificate_type=="makeup_workshop_participation") echo 'selected="selected"'; ?> value="makeup_workshop_participation" >Makeup Workshop Participation</option>
															<option <?php //if($certificate_type=="keratine_treatment_seminar_participation") echo 'selected="selected"'; ?> value="keratine_treatment_seminar_participation" >Keratine Treatment Participation</option>
															<option <?php //if($certificate_type=="rica_wax_workshop_participation") echo 'selected="selected"'; ?> value="rica_wax_workshop_participation" >Richa Wax Workshop Participation</option>-->
														</select>
														<br/>
														<?php
                                                            echo '<input type="button" name="Reprint Certificate" value="Re-Print Certificate" onclick="get_url('.$data_course['enroll_id'].','.$data_course['course_id'].','.$c.')" style="width: 150px;"><br/>';
                                                        }
                                                        //----------------------------
                                                        //echo '<input type="button" name="Reprint Certificate" value="Re-Print Certificate" onclick="get_url('.$data_course['enroll_id'].','.$data_course['course_id'].','.$c.')" style="width: 150px;">';
                                                        echo'Certificate Printed<br/><center><img src="images/certificate_print.png" border="0" width="30px" height="30px" title="Certificate Printed"></center>';	
                                                    }
                                                    else
                                                    {
														?>
														<select name="certificate_type_<?php echo $c; ?>" id="certificate_type_<?php echo $c; ?>" class="input_select" style="width:150px; margin-bottom:5px">
															<option value="">Select Certificate</option>
															<option <?php if($certificate_type=="certificate_level") echo 'selected="selected"';else if($data_name['course_type']!='integrated' || $data_name['course_type']!='diploma_level')echo 'selected="selected"'; ?> value="certificate_level" >Certificate level/Diploma level</option>
															<option <?php if($certificate_type=="DIC") echo 'selected="selected"'; else if($data_name['course_type']=='diploma_level') echo 'selected="selected"'; ?> value="DIC" >DIC</option>
															<option <?php if($certificate_type=="PGDC") echo 'selected="selected"';else if($data_name['course_id']=='11') echo 'selected="selected"'; ?> value="PGDC" >PGDC</option>
															<option <?php if($certificate_type=="PGDC-NAIL") echo 'selected="selected"';?> value="PGDC-NAIL" >PGDC-NAIL</option>
															<option <?php if($certificate_type=="MIC") echo 'selected="selected"';else if($data_course['course_id']=='52') echo 'selected="selected"'; ?> value="MIC" >MIC</option>
															<!--<option <?php //if($certificate_type=="Event") echo 'selected="selected"'; ?> value="Event" >Event</option>
															<option <?php //if($certificate_type=="Workshop") echo 'selected="selected"'; ?> value="Workshop" >Workshop</option>
															<option <?php //if($certificate_type=="Biotop_hair_workshop_Participation") echo 'selected="selected"'; ?> value="Biotop_hair_workshop_Participation" >Biotop Hair Workshop Participation</option>
															<option <?php //if($certificate_type=="makeup_workshop_participation") echo 'selected="selected"'; ?> value="makeup_workshop_participation" >Makeup Workshop Participation</option>
															<option <?php //if($certificate_type=="keratine_treatment_seminar_participation") echo 'selected="selected"'; ?> value="keratine_treatment_seminar_participation" >Keratine Treatment Participation</option>
															<option <?php //if($certificate_type=="rica_wax_workshop_participation") echo 'selected="selected"'; ?> value="rica_wax_workshop_participation" >Richa Wax Workshop Participation</option>-->
														</select>
														<br/>
														<?php
                                                        echo '<input type="button" name="print certificate" value="Print Certificate"  onclick="get_url('.$data_course['enroll_id'].','.$data_course['course_id'].','.$c.')" style="width: 150px;">';
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<br/>"."<span style='color:red'>Please Use Mozila Firefox Browser</span>";
                                                }
                                                ?>
                                                </td>
                                                <?php
                                                $disable_certificate_action="";
                                            }
											else
											{
												?>
                                                <td width="18" align="center">Please Clear the Payment and check the Certificate Action</td>
                                                <?php
											}
											
											//-----------------ISSUED Certificate--------------------------------
                                           	// $disable_issue_certificate='disabled="disabled"';
											
                                            if($print_certificate_action =='yes' && $issue_certificate_action=='' && ($_SESSION['type']=="A" ||$_SESSION['type']=="AC" || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' ))
                                            {
												?>
                                                <td width="17%" align="center" style="padding-left:5px;"><input type="checkbox" name="certificate_issued_<?php echo $c; ?>" <?php if($issue_certificate_action!='') {echo 'checked="checked"';}?> value="yes"><br/><input type="text" name="certificate_issue_date_<?php echo $c; ?>" value="<?php if($_POST['certificate_issue_date']) echo $_POST['certificate_issue_date']; else if($certificate_issue_date !='') echo $certificate_issue_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Logbbok date "/>
                                            	<br/>
                                                <select name="certificate_issue_staff_id_<?php echo $c; ?>" id="certificate_issue_staff_id_<?php echo $c;?>" class="input_select" style="width:150px;">
                                                <?php 
                                                $select_faculty="select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by admin_id asc";
                                                $ptr_faculty=mysql_query($select_faculty);
                                                while($data_faculty=mysql_fetch_array($ptr_faculty))
                                                { 
                                                    $class4 = '';
                                                    if($certificate_by_staff >0)
                                                    {
                                                        if($data_faculty['admin_id']==$certificate_by_staff && $certificate_by_staff >0)
                                                        {  
                                                            $class4='selected="selected"';
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                                        {
                                                            $class4 = 'selected="selected"';
                                                        }
                                                    }
                                                    echo '<option value="'.$data_faculty['admin_id'].'" '.$class4.' >'.$data_faculty['name'].' </option>';
                                                }
                                                ?>        
                                                </select>                                            
                                                </td>
                                                <?php
                                                $disable_issue_certificate="";
                                            }
											else if($print_certificate_action =='yes' && $issue_certificate_action!='')
											{
												?>
                                                
                                                <td width="17%" align="center" style="padding-left:5px;">
                                                <img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified"><br/><?php echo $certificate_issue_date; ?><br/><input type="hidden" name="certificate_issued_<?php echo $c; ?>" <?php if($issue_certificate_action!='') {echo 'checked="checked"';}?> value="yes"><input type="hidden" name="certificate_issue_date_<?php echo $c; ?>" value="<?php if($_POST['certificate_issue_date']) echo $_POST['certificate_issue_date']; else if($certificate_issue_date !='') echo $certificate_issue_date; else echo date('d/m/Y');?>" ><br/>
                                                <?php
                                                $select_faculty="select name from site_setting where admin_id='".$certificate_by_staff."' order by cm_id asc";
                                                $ptr_faculty = mysql_query($select_faculty);
                                                $data_faculty = mysql_fetch_array($ptr_faculty);
                                                echo $data_faculty['name'];
                                                ?>
                                                </td>
                                                <?php
											}
											else
											{
												?><td width="17%" align="center" style="padding-left:5px;">Please Clear the previous actions</td>
                                                <?php
											}
                                            ?>
                                            
                                        </tr>
                                    </table>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                                <?php
                                //echo '<tr><td colspan="8"><hr/></td></tr>';
                                echo'<input type="hidden" name="total_course_'.$c.'" id="total_course_'.$c.'" value="'.$tot_course.'" >';
                                echo '<input type="hidden" name="c" id="c" value="'.$c.'">';
                                $c++;
                            }
                            ?>
                        	<input type="hidden" name="total_main_course" id="total_main_course" value="<?php echo $tot_main_course; ?>">
                        </table>
                    </td>
                    </tr>
                    <tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Action (Testominal)</strong></td></tr>
                    <tr>
                        <td colspan="8">
                            <?php
                            $sel_testo="select * from action_testominal where enroll_id=".$data_course['enroll_id']." order by testominal_id desc";
                            $ptr_testo= mysql_query($sel_testo);
                            if(mysql_num_rows($ptr_testo))
                            {
                                $data_testo=mysql_fetch_array($ptr_testo);
                                $google_action=$data_testo['google_action'];
                                $justdial_action=$data_testo['justdial_action'];
                                $video_action=$data_testo['video_action'];
                                $staff_id=$data_testo['staff_id'];
                            }
                            ?>
                            <table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
							<?php
                            $disable_testomianl='disabled="disabled"';
                            if($issue_certificate_action =='yes' && ($_SESSION['type']=="A" || $_SESSION['type']=="AC" || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'))
                            {
                                $disable_testomianl="";
                            }
                            ?>
                                <tr>
                                    <td width="30%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Google</span></td>
                                    <td width="20%" align="left"  style="padding-left:10px;"><input type="checkbox" <?php echo $disable_testomianl;?> name="google_testominal" <?php if($google_action!='') {echo 'checked="checked"' ;}?> value="yes"></td>  
                                    <td align="left" width="30%"  style="padding-left:10px;" rowspan="3">
                                        <select name="staff_ids" id="staff_ids" class="input_select" style="width:150px;">
										<?php 
                                        $select_faculty="select * from site_setting where cm_id='".$data_select['cm_id']."' and system_status='Enabled' order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class3 = '';
                                            if($staff_id !='')
                                            {
                                                if($data_faculty['admin_id'] == $staff_id)
                                                {  
                                                    $class3 = 'selected="selected"';
                                                }
                                            }
                                            else
                                            {
                                                if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                                {  
                                                    $class3 = 'selected="selected"';
                                                }
                                            }
                                            echo '<option value="'.$data_faculty['admin_id'].'" '.$class3.' >'.$data_faculty['name'].' </option>';     
                                        }
                                        ?>        
                                        </select>
                                    </td>											
                                </tr>
                                <tr>
                                    <td width="36%" align="left" style="padding-left:10px;"><span style=" font-weight:bold">Justdial</span></td>
                                    <td width="20%" align="left" style="padding-left:10px;"><input type="checkbox" <?php echo $disable_testomianl;?> name="justdial_testominal" <?php if($justdial_action!='') {echo 'checked="checked"';}?> value="yes"></td>
                                </tr>
                                <tr>
                                    <td width="36%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Video taken</span></td>
                                    <td width="20%" align="left"  style="padding-left:10px;"><input type="checkbox" <?php echo $disable_testomianl;?> name="video_taken" <?php if($video_action!='') {echo 'checked="checked"';}?> value="yes"></td>      
                                </tr>
                            </table>
                        </td>
                    </tr>
					<?php 
                    //if($data_select['action_status']=='') 
                    //{
                    ?>
                    <tr>
                        <td colspan="2" align="center"> <input type="submit" name="save_changes" value="Save"  /></td>
                    </tr>
                    <?
                    //}
                   $bgColorCounter++;
                }
                ?>
                </table>
                </td>
                </tr>
                            <tr><td height="10"></td></tr>
                            <tr><td valign="middle" align="right">
                                    <table width="100%" cellpadding="0" callspacing="0" border="0">
                                        <tr>
                                            <?php
                                            if($no_of_records>10)
                                            {
                                                echo '<td width="3%" align="left">Show</td>
                                                <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';
                                                for($s=0;$s<count($show_records);$s++)
                                                {
                                                    if($_SESSION['show_records']==$show_records[$s])
                                                        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                    else
                                                        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                }
                                                echo'</td></select>';
                                            }
                                            ?>
                                            <td align="right"></td>
                                        </tr>
                                    </table>
                                </td></tr>
                            </table>
                            </form><?php
                        }
                        else if($_GET['search'])
                            echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                        else
                            echo'<center><br><div id="alert" style="width:30%">No Payment history here</div><br></center>';
	                    ?>
                    </td>
                    <td class="mid_right"></td>
                  </tr>
                   <tr>
                        <td class="bottom_left"></td>
                        <td class="bottom_mid"></td>
                        <td class="bottom_right"></td>
                    </tr>
                 </table>
             </div>
<!--right end-->
</div>
<!--info end-->
<div class="clearit"></div>
<noscript>Warning! JavaScript must be enabled for proper operation of the Administrator backend.</noscript>
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script>
function get_url(enroll_id,course_id,i)
{
	//var c = $("#c").val();
	//alert(c);
	//for(var i=1;i<=c;i++)
	if(i!='')
	{
		//alert(i);
		var certificate_type = $("#certificate_type_"+i).val();
		//var record_id = $("#record_id").val();
		//var course_id = $("#course_id_"+i).val();	
		//alert(certificate_type);
		if(certificate_type=="certificate_level") window.open('certificate_details_level.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="DIC") window.open('certificate_details_dic.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="PGDC") window.open('certificate_details_pgdc.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="PGDC-NAIL") window.open('certificate_details_pgdc_nail.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="MIC") window.open('certificate_details_mic.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="Event") window.open('certificate_details_event.php?record_id=record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="Workshop") window.open('certificate_details_workshop.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="Biotop_hair_workshop_Participation") window.open('certificate_details_biotop.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="makeup_workshop_participation") window.open('certificate_details_makeup.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="keratine_treatment_seminar_participation") window.open('certificate_details_keratine.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
		else if(certificate_type=="rica_wax_workshop_participation") window.open('certificate_details_rica.php?record_id='+enroll_id+'&course_id='+course_id, '_blank');
	}
}
</script>
</body>
</html>
<?php $db->close();?>