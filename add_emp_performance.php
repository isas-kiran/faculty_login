<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM emp_performance_report where id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
		$record_id=0;
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='349'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Employee Performance</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<!-- <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
	jQuery(document).ready( function() 
	{
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		
	});
    </script>
    
	<!-- <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
     <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+date.id+"')"); return res;
			//$("#date" ).datepicker({defaultDate: -1,maxDate:"-1D"});
			$("#date").datepicker("setDate", "-1");
		}
		
		$("#staff_id").chosen({allow_single_deselect:true});
		$("#staff_id_s").chosen({allow_single_deselect:true});
		<?php 
		if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			$("#branch_name_s").chosen({allow_single_deselect:true});
			<?php
		}
		if($record_id=='')
		{
			?>
			//========values========
			document.getElementById("utilisation").value=0;
			document.getElementById("task_completion").value=0;
			document.getElementById("quality_of_work").value=0;
			//===========
			document.getElementById("timesheet_mark").value=0;
			document.getElementById("utilisation_mark").value=0;
			document.getElementById("task_mark").value=0;
			document.getElementById("quality_work_mark").value=0;
			
			document.getElementById("class_start_time_mark").value=0;
			document.getElementById("class_end_time_r_mark").value=0;
			document.getElementById("faculty_grooming_r_mark").value=0;
			document.getElementById("logsheet_send_r_mark").value=0;
			document.getElementById("mobile_used_r_mark").value=0;
			document.getElementById("timetable_followed_r_mark").value=0;
			document.getElementById("student_decoram_r_mark").value=0;
			//========checked=========
			document.getElementById("class_start_time_r_n").checked=true;
			document.getElementById("class_end_time_r_n").checked=true;
			document.getElementById("faculty_grooming_r_n").checked=true;
			document.getElementById("logsheet_send_r_n").checked=true;
			document.getElementById("mobile_used_r_n").checked=true;
			document.getElementById("timetable_followed_r_n").checked=true;
			document.getElementById("student_decoram_r_n").checked=true;
			//=======Values=====
			document.getElementById("late_login_without_info_mark").value=0;
			document.getElementById("absent_without_info_mark").value=0;
			document.getElementById("early_checkout_info_mark").value=0;
			document.getElementById("misconduct_with_staff_mark").value=0;
			document.getElementById("misconduct_with_student_mark").value=0;
			document.getElementById("logsheet_not_checked_mark").value=0;
			document.getElementById("other_issue_mark").value=0;
			//========checked=========
			document.getElementById("late_login_without_info_n").checked=true;
			document.getElementById("absent_without_info_n").checked=true;
			document.getElementById("early_checkout_info_n").checked=true;
			document.getElementById("misconduct_with_staff_n").checked=true;
			document.getElementById("misconduct_with_student_n").checked=true;
			document.getElementById("logsheet_not_checked_n").checked=true;
			document.getElementById("other_issue_n").checked=true;
			//====================================
			document.getElementById("points").value=0;
			document.getElementById("monthly_points").value=0;
			document.getElementById("negative_remark_mark").value=0;
			<?php
		}
		?>		
	});
    </script>
 	<script type="text/javascript">
	function submitAction(action)
	{
		var chks = document.getElementsByName('chkRecords[]');
		var hasChecked = false;
		for (var i = 0; i < chks.length; i++)
		{
			if (chks[i].checked)
			{
				hasChecked = true;
				break;
			}
		}
		if (hasChecked == false)
		{
			alert("Please select at least one record to do operation");
			$('#selAction').val('');
			return false;
		}

		document.getElementById('formAction').value=action;
		if(action=="delete")
		{
			if(confirm("Are you sure, you want to delete selected record(s)?"))
				document.frmTakeAction.submit();
			else
			{
				$('#selAction').val('');
				return false;
			}
		}
		else
			document.frmTakeAction.submit();
	}
	function redirect1(value,value1)
	{           
		//alert(value);
	   // alert(value1);
		window.location.href=value+value1;
	}

	function validationToDelete(type)
	{
		if(confirm("Are you sure, you want to delete selected record(s)?"))
			return true;
		else
			return false;
	}
	function getstaff(branch_id)
	{
		var data1="action=stack_report&branch_id="+branch_id;	
		$.ajax({
		url: "show_councellor.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(html !='')
			{
				//alert(html);
				document.getElementById("staff_details").innerHTML=html;
				$("#staff_id_s").chosen({allow_single_deselect:true});
			}
		},
		error:function(exception){alert('Exception:'+exception);}
		});
	}
	function getstaffDetails(branch_id)
	{
		var data1="action=performance_report&branch_id="+branch_id;	
		$.ajax({
		url: "show_councellor.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(html !='')
			{
				document.getElementById("staff_ids").innerHTML=html;
				$("#staff_id").chosen({allow_single_deselect:true});
			}
		},
		error:function(exception){alert('Exception:'+exception);}
		});
	}
	function check_data(staff_id)
	{
		var branch_id= document.getElementById("branch_name").value;
		var date= document.getElementById("date").value;
		document.getElementById("working_hours").value = '';
		var data1="action=get_staff_presence&branch_id="+branch_id+"&staff_id="+staff_id+"&date="+date;	
		$.ajax({
		url: "ajax.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			var val_Spl=html.split("##");
			var presence = val_Spl[0].trim();
			var att_ids=val_Spl[1].trim();
			//alert(presence);
			//alert(att_ids);
			if(att_ids !='')
			{
				//alert("1");
				document.getElementById("presence").value ="yes";
				document.getElementById("working_hours").value = presence;
			}
			else
			{
				//alert("hi");
				$("#presence").prop("selectedIndex", 2); 
				document.getElementById("working_hours").value = 0;
				$("#timesheet_status").prop("selectedIndex", 2); 
				document.getElementById("comments").value = "On Leave";
				
			}
		},
		error:function(exception){alert('Exception:'+exception);}
		});
	}
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	function change_mark(t_per)
	{
		if(t_per=='yes')
		{
			document.getElementById("timesheet_mark").value=1;
		}
		else
		{
			document.getElementById("timesheet_mark").value=1;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_utilisation(uti_per)
	{
		var marks=0;
		if(uti_per!='')
		{
			var inmark= roundNumber((uti_per*10),2);
			var marks=Number(inmark / 100); 
			//alert(inmark);
			document.getElementById("utilisation_mark").value=marks;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_task(task_per)
	{
		var marks=0;
		if(task_per!='')
		{
			var inmark= roundNumber((task_per*5),2);
			var marks=Number(inmark / 100); 
			document.getElementById("task_mark").value=marks;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_qualityWork(qw_per)
	{
		var marks=0;
		if(qw_per!='' )
		{
			var inmark= roundNumber((qw_per*5),2);
			var marks=Number(inmark / 100); 
			document.getElementById("quality_work_mark").value=marks;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_cst(cst_val)
	{
		if(cst_val=='yes')
		{
			document.getElementById("class_start_time_mark").value=1;
		}
		else
		{
			document.getElementById("class_start_time_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_cet(cet_val)
	{
		if(cet_val=='yes')
		{
			document.getElementById("class_end_time_r_mark").value=1;
		}
		else
		{
			document.getElementById("class_end_time_r_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_fg(fg_val)
	{
		if(fg_val=='yes')
		{
			document.getElementById("faculty_grooming_r_mark").value=1;
		}
		else
		{
			document.getElementById("faculty_grooming_r_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_fg(fg_val)
	{
		if(fg_val=='yes')
		{
			document.getElementById("faculty_grooming_r_mark").value=1;
		}
		else
		{
			document.getElementById("faculty_grooming_r_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_ls(ls_val)
	{
		if(ls_val=='yes')
		{
			document.getElementById("logsheet_send_r_mark").value=1;
		}
		else
		{
			document.getElementById("logsheet_send_r_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_mubh(mubh_val)
	{
		if(mubh_val=='yes')
		{
			document.getElementById("mobile_used_r_mark").value=1;
		}
		else
		{
			document.getElementById("mobile_used_r_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_tf(tf_val)
	{
		if(tf_val=='yes')
		{
			document.getElementById("timetable_followed_r_mark").value=1;
		}
		else
		{
			document.getElementById("timetable_followed_r_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_sd(sd_val)
	{
		if(sd_val=='yes')
		{
			document.getElementById("student_decoram_r_mark").value=1;
		}
		else
		{
			document.getElementById("student_decoram_r_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_llwi(llwi_val)
	{
		if(llwi_val=='yes')
		{
			document.getElementById("late_login_without_info_mark").value=1;
		}
		else
		{
			document.getElementById("late_login_without_info_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_awi(awi_val)
	{
		if(awi_val=='yes')
		{
			document.getElementById("absent_without_info_mark").value=2;
		}
		else
		{
			document.getElementById("absent_without_info_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_ecwi(ecwi_val)
	{
		if(ecwi_val=='yes')
		{
			document.getElementById("early_checkout_info_mark").value=1;
		}
		else
		{
			document.getElementById("early_checkout_info_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_mws(mws_val)
	{
		if(mws_val=='yes')
		{
			document.getElementById("misconduct_with_staff_mark").value=2;
		}
		else
		{
			document.getElementById("misconduct_with_staff_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_mwst(mwst_val)
	{
		if(mwst_val=='yes')
		{
			document.getElementById("misconduct_with_student_mark").value=2;
		}
		else
		{
			document.getElementById("misconduct_with_student_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_lnc(lnc_val)
	{
		if(lnc_val=='yes')
		{
			document.getElementById("logsheet_not_checked_mark").value=1;
		}
		else
		{
			document.getElementById("logsheet_not_checked_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	function calculate_oi(oi_val)
	{
		if(oi_val=='yes')
		{
			document.getElementById("other_issue_mark").value=1;
		}
		else
		{
			document.getElementById("other_issue_mark").value=0;
		}
		setTimeout(calculate_mark(),500);
	}
	
	function calculate_mark()
	{
		var timesheet_mark=parseFloat(document.getElementById("timesheet_mark").value);
		var utilisation_mark=parseFloat(document.getElementById("utilisation_mark").value);
		var task_mark=parseFloat(document.getElementById("task_mark").value);
		var quality_work_mark=parseFloat(document.getElementById("quality_work_mark").value);
		var class_start_time_mark=parseFloat(document.getElementById("class_start_time_mark").value);
		var class_end_time_r_mark=parseFloat(document.getElementById("class_end_time_r_mark").value);
		var faculty_grooming_r_mark=parseFloat(document.getElementById("faculty_grooming_r_mark").value);
		var logsheet_send_r_mark=parseFloat(document.getElementById("logsheet_send_r_mark").value);
		var mobile_used_r_mark=parseFloat(document.getElementById("mobile_used_r_mark").value);
		var timetable_followed_r_mark=parseFloat(document.getElementById("timetable_followed_r_mark").value);
		var student_decoram_r_mark=parseFloat(document.getElementById("student_decoram_r_mark").value);
		var negative_remark_mark=parseFloat(document.getElementById("negative_remark_mark").value);
		
		var late_login_without_info_mark=parseFloat(document.getElementById("late_login_without_info_mark").value);
		var absent_without_info_mark=parseFloat(document.getElementById("absent_without_info_mark").value);
		var early_checkout_info_mark=parseFloat(document.getElementById("early_checkout_info_mark").value);
		var misconduct_with_staff_mark=parseFloat(document.getElementById("misconduct_with_staff_mark").value);
		var misconduct_with_student_mark=parseFloat(document.getElementById("misconduct_with_student_mark").value);
		var logsheet_not_checked_mark=parseFloat(document.getElementById("logsheet_not_checked_mark").value);
		var other_issue_mark=parseFloat(document.getElementById("other_issue_mark").value);
		
		var total_negative_mark=parseFloat(late_login_without_info_mark+absent_without_info_mark+early_checkout_info_mark+misconduct_with_staff_mark+misconduct_with_student_mark+logsheet_not_checked_mark+other_issue_mark);
		document.getElementById("negative_remark_mark").value=total_negative_mark;
		
		var total_mark=parseFloat(timesheet_mark+utilisation_mark+task_mark+quality_work_mark+class_start_time_mark+class_end_time_r_mark+faculty_grooming_r_mark+logsheet_send_r_mark+mobile_used_r_mark+timetable_followed_r_mark+student_decoram_r_mark-total_negative_mark);
		
		document.getElementById("points").value=total_mark;
	}
	
	function validme()
	{   
		frm = document.jqueryForm;
		error='';
		disp_error = 'Clear The Following Errors : \n\n';	 
		if(frm.staff_id.value=='')
		{
			disp_error +='Select Staff Name\n';
			document.getElementById('staff_id').style.border = '1px solid #f00';
			frm.staff_id.focus();
			error='yes';
		}
		if(frm.timesheet_status.value=='')
		{
			//alert('hi');
			 disp_error +='Select Timesheet Status\n';
			 document.getElementById('timesheet_status').style.border = '1px solid #f00';
			 frm.timesheet_status.focus();
			 error='yes';
		 }
		 if(frm.utilisation.value=='')
		 {
			//alert('hi');
			 disp_error +='Enter Utilisation Percentage\n';
			 document.getElementById('utilisation').style.border = '1px solid #f00';
			 frm.utilisation.focus();
			 error='yes';
		 }
		 else if(frm.utilisation.value >100)
		 {
			 disp_error +='Enter Valid Utilisation Percentage. Should be less than or equal to 100%\n';
			 document.getElementById('utilisation').style.border = '1px solid #f00';
			 frm.utilisation.focus();
			 error='yes';
		 }
		 if(frm.presence.value=='')
		 {
			//alert('hi');
			 disp_error +='Select Presence status\n';
			 document.getElementById('presence').style.border = '1px solid #f00';
			 frm.presence.focus();
			 error='yes';
		 }
		 if(frm.working_hours.value=='')
		 {
			//alert('hi');
			disp_error +='Enter Working Hours\n';
			document.getElementById('working_hours').style.border = '1px solid #f00';
			frm.working_hours.focus();
			error='yes';
		 }
		 if(frm.task_completion.value=='')
		 {
			//alert('hi');
			 disp_error +='Enter Task Completion Percentage\n';
			 document.getElementById('task_completion').style.border = '1px solid #f00';
			 frm.task_completion.focus();
			 error='yes';
		 }
		 else if(frm.task_completion.value >100)
		 {
			 disp_error +='Enter Valid Task Completion Percentage. Should be less than or equal to 100%\n';
			 document.getElementById('task_completion').style.border = '1px solid #f00';
			 frm.task_completion.focus();
			 error='yes';
		 }
		 if(frm.quality_of_work.value=='')
		 {
			//alert('hi');
			 disp_error +='Enter Quality of Work Percentage\n';
			 document.getElementById('quality_of_work').style.border = '1px solid #f00';
			 frm.quality_of_work.focus();
			 error='yes';
		 }
		 else if(frm.quality_of_work.value >100)
		 {
			 disp_error +='Enter Valid Quality Work Percentage. Should be less than or equal to 100%\n';
			 document.getElementById('quality_of_work').style.border = '1px solid #f00';
			 frm.quality_of_work.focus();
			 error='yes';
		 }
		 if(frm.class_start_time_mark.value == '') //Now Discount
		 {
			 disp_error +='Select "Class Start On Time" Status\n';
			 document.getElementById('class_start_time_mark').style.border = '1px solid #f00';
			 frm.class_start_time_mark.focus();
			 error='yes';
		 }
		 if(frm.class_end_time_r_mark.value == '') //Now Discount
		 {
			 disp_error +='Select "Class End On Time" Status\n';
			 document.getElementById('class_end_time_r_mark').style.border = '1px solid #f00';
			 frm.class_end_time_r_mark.focus();
			 error='yes';
		 }
		 if(frm.faculty_grooming_r_mark.value == '') //Now Discount
		 {
			 disp_error +='Select "Faculty Grooming" Status\n';
			 document.getElementById('faculty_grooming_r_mark').style.border = '1px solid #f00';
			 frm.faculty_grooming_r_mark.focus();
			 error='yes';
		 }
		 if(frm.logsheet_send_r_mark.value == '') //Now Discount
		 {
			 disp_error +='Select "Logsheet Send" Status\n';
			 document.getElementById('logsheet_send_r_mark').style.border = '1px solid #f00';
			 frm.logsheet_send_r_mark.focus();
			 error='yes';
		 }
		 if(frm.mobile_used_r_mark.value == '') //Now Discount
		 {
			 disp_error +='Select "Mobile used in batch hours" Status\n';
			 document.getElementById('mobile_used_r_mark').style.border = '1px solid #f00';
			 frm.mobile_used_r_mark.focus();
			 error='yes';
		 }
		 if(frm.timetable_followed_r_mark.value == '') //Now Discount
		 {
			 disp_error +='Select "Timesheet Followed" Status\n';
			 document.getElementById('timetable_followed_r_mark').style.border = '1px solid #f00';
			 frm.timetable_followed_r_mark.focus();
			 error='yes';
		 }
		 if(frm.student_decoram_r_mark.value == '') //Now Discount
		 {
			 disp_error +='Select "Student Decoram" Status\n';
			 document.getElementById('student_decoram_r_mark').style.border = '1px solid #f00';
			 frm.student_decoram_r_mark.focus();
			 error='yes';
		 }	
		 if(frm.phone_submited.value == '') //Now Discount
		 {
			 disp_error +='Select "Phone Submited" Status\n';
			 document.getElementById('phone_submited').style.border = '1px solid #f00';
			 frm.phone_submited.focus();
			 error='yes';
		 }
		 
		 if(error=='yes')
		 {
			alert(disp_error);
			 return false;
		 }
		 else
		 return true;
	}
	
	/*function add_details(val)
	{
		var presence_val=val;
		var staff_id=document.getElementById("staff_id").value;
		
		if(presence_val!='' && staff_id!='')
		{
			if(presence_val=='yes')
			{
				$("#timesheet_status").prop("selectedIndex", 1); // timesheet status
				
				
			}
		}
	}*/
    </script>

</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">
        	<?php
            $errors=array(); $i=0;			
            $success=0;
            
            if($_POST['save_changes'])
            {
                $branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
				$date=( ($_POST['date'])) ? $_POST['date'] : "";
				if($date !='')
				{
					$seps_date = explode('/',$date);
					$report_date = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
				}
				else
					$report_date='';
					
              	$staff_id=( ($_POST['staff_id'])) ? $_POST['staff_id'] : "";
				$timesheet_status=( ($_POST['timesheet_status'])) ? $_POST['timesheet_status'] : "";
				$timesheet_mark=( ($_POST['timesheet_mark'])) ? $_POST['timesheet_mark'] : "";
				$utilisation=( ($_POST['utilisation'])) ? $_POST['utilisation'] : "";
				$utilisation_mark=( ($_POST['utilisation_mark'])) ? $_POST['utilisation_mark'] : "";
				$presence=( ($_POST['presence'])) ? $_POST['presence'] : "";
				$working_hours=( ($_POST['working_hours'])) ? $_POST['working_hours'] : "";
				$task_completion=( ($_POST['task_completion'])) ? $_POST['task_completion'] : "";
				$task_mark=( ($_POST['task_mark'])) ? $_POST['task_mark'] : "";
				$quality_of_work=( ($_POST['quality_of_work'])) ? $_POST['quality_of_work'] : "";
				$quality_work_mark=( ($_POST['quality_work_mark'])) ? $_POST['quality_work_mark'] : "";
				$phone_submited=( ($_POST['phone_submited'])) ? $_POST['phone_submited'] : "";
				
				$class_start_time_mark=( ($_POST['class_start_time_mark'])) ? $_POST['class_start_time_mark'] : "";
				$class_end_time_r_mark =( ($_POST['class_end_time_r_mark'])) ? $_POST['class_end_time_r_mark'] : "";
				$faculty_grooming_r_mark=( ($_POST['faculty_grooming_r_mark'])) ? $_POST['faculty_grooming_r_mark'] : "";
				$logsheet_send_r_mark=( ($_POST['logsheet_send_r_mark'])) ? $_POST['logsheet_send_r_mark'] : "";
				$mobile_used_r_mark=( ($_POST['mobile_used_r_mark'])) ? $_POST['mobile_used_r_mark'] : "";
				$timetable_followed_r_mark=( ($_POST['timetable_followed_r_mark'])) ? $_POST['timetable_followed_r_mark'] : "";
				$student_decoram_r_mark=( ($_POST['student_decoram_r_mark'])) ? $_POST['student_decoram_r_mark'] : "";
				
				$late_login_without_info_mark=( ($_POST['late_login_without_info_mark'])) ? $_POST['late_login_without_info_mark'] : "";
				$absent_without_info_mark =( ($_POST[' absent_without_info_mark'])) ? $_POST[' absent_without_info_mark'] : "";
				$early_checkout_info_mark=( ($_POST['early_checkout_info_mark'])) ? $_POST['early_checkout_info_mark'] : "";
				$misconduct_with_staff_mark=( ($_POST['misconduct_with_staff_mark'])) ? $_POST['misconduct_with_staff_mark'] : "";
				$misconduct_with_student_mark=( ($_POST['misconduct_with_student_mark'])) ? $_POST['misconduct_with_student_mark'] : "";
				$logsheet_not_checked_mark=( ($_POST['logsheet_not_checked_mark'])) ? $_POST['logsheet_not_checked_mark'] : "";
				$other_issue_mark=( ($_POST['other_issue_mark'])) ? $_POST['other_issue_mark'] : "";
				
				$negative_remark=( ($_POST['negative_remark'])) ? $_POST['negative_remark'] : "";
				$points=( ($_POST['points'])) ? $_POST['points'] : "";
				$monthly_points=( ($_POST['monthly_points'])) ? $_POST['monthly_points'] : "";
				$comments=( ($_POST['comments'])) ? $_POST['comments'] : "";
                $added_date=date('Y-m-d H:i:s');  
                $admin_id=$_SESSION['admin_id'];
				
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
				{
					$sel_branch="select cm_id ,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
					$ptr_branch=mysql_query($sel_branch);
					$data_branch=mysql_fetch_array($ptr_branch);
					$cm_id=$data_branch['cm_id'];
					
					$branch_name1=$branch_name;
					$_SESSION['cm_id_notification']=$data_branch['cm_id'];
				}	
				else
				{
					$cm_id=$_SESSION['cm_id'];
					$branch_name1=$_SESSION['branch_name'];
				}
				
                if(count($errors))
                {
					?>
					<tr><td colspan="2"> <br></br>
						<table align="left" style="text-align:left;" class="alert">
						<tr><td ><strong>Please correct the following errors</strong><ul>
								<?php
								for($k=0;$k<count($errors);$k++)
										echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
								</ul>
						</td></tr>
						</table>
					</td></tr>   <br></br>  
                    <?php
                }
                else
                {
                    $success=1;
					$data_record['report_date']=$report_date;
					$data_record['employee_id'] = $staff_id;
					$data_record['timesheet_status'] = $timesheet_status;
					$data_record['timesheet_mark'] = $timesheet_mark;
					$data_record['utilisation'] = $utilisation;
					$data_record['utilisation_mark'] = $utilisation_mark;
					$data_record['presence'] = $presence;
					$data_record['working_hrs'] = $working_hours;
					$data_record['task_completion'] = $task_completion;
					$data_record['task_mark'] = $task_mark;
					$data_record['quality_work'] = $quality_of_work; 
					$data_record['quality_work_mark'] = $quality_work_mark; 
					$data_record['phone_submited'] = $phone_submited;
					$data_record['class_start_time_mark'] = $class_start_time_mark;
					$data_record['class_end_time_r_mark'] = $class_end_time_r_mark;
					$data_record['faculty_grooming_r_mark'] = $faculty_grooming_r_mark;
					$data_record['logsheet_send_r_mark'] = $logsheet_send_r_mark;
					$data_record['mobile_used_r_mark'] = $mobile_used_r_mark;
					$data_record['timetable_followed_r_mark'] = $timetable_followed_r_mark;
					$data_record['student_decoram_r_mark'] = $student_decoram_r_mark;
					
					$data_record['late_login_without_info_mark'] = $late_login_without_info_mark;
					$data_record['absent_without_info_mark'] = $absent_without_info_mark;
					$data_record['early_checkout_info_mark'] = $early_checkout_info_mark;
					$data_record['misconduct_with_staff_mark'] = $misconduct_with_staff_mark;
					$data_record['misconduct_with_student_mark'] = $misconduct_with_student_mark;
					$data_record['logsheet_not_checked_mark'] = $logsheet_not_checked_mark;
					$data_record['other_issue_mark'] = $other_issue_mark;
					
					$data_record['negative_remarks'] = $negative_remark;
					$data_record['points'] = $points;
					$data_record['monthly_points'] = $monthly_points;
					$data_record['comments'] =$comments;
					$data_record['admin_id'] =$admin_id;
					$data_record['cm_id'] =$cm_id;
					$data_record['added_date'] =$added_date;
					
					
					$sel_emp="select id from emp_performance_report where DATE(report_date)='".$report_date."' and employee_id='".$staff_id."' and cm_id='".$cm_id."'";
					$ptr_emp=mysql_query($sel_emp);
					if($tot=mysql_num_rows($ptr_emp))
					{
						/*$update="UPDATE `emp_performance_report` SET `employee_id`='".$staff_id.",`timesheet_status`='".$timesheet_status."',`utilisation`='".$utilisation."',`presence`='".$presence."',`working_hrs`='".$working_hours."',`task_completion`='".$task_completion."',`quality_work`='".$quality_of_work."',`phone_submited`='".$phone_submited."',`negative_remarks`='".$negative_remark."',`points`='".$points."',`comments`='".$comments."',`admin_id`='".$admin_id."',`cm_id`='".$cm_id."',`report_date`='".$report_date."',`added_date`='".$added_date."' WHERE id ='".$record_id."'";
						$ptr_up=mysql_query($update);*/
						
						$where_record=" id='".$record_id."'";
                        $db->query_update("emp_performance_report", $data_record,$where_record);
					}
					else
					{
						/*$insert="INSERT INTO `emp_performance_report`(`employee_id`, `timesheet_status`, `utilisation`, `presence`, `working_hrs`, `task_completion`, `quality_work`, `phone_submited`, `negative_remarks`, `points`, `comments`, `admin_id`, `cm_id`, `report_date`, `added_date`) VALUES ('".$staff_id."','".$timesheet_status."','".$utilisation."','".$presence."','".$working_hours."','".$task_completion."','".$quality_of_work."','".$phone_submited."','".$negative_remark."','".$points."','".$comments."','".$admin_id."','".$cm_id."','".$report_date."','".$added_date."')";
						$ptr_ins=mysql_query($insert);*/
						
						$c_b_id=$db->query_insert("emp_performance_report", $data_record); 
					}
                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                    ?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record added successfully</p></center></div>
                    <script type="text/javascript">
                    $(document).ready(function() {
                        $( "#statusChangesDiv" ).dialog({
                            modal: true,
                            buttons: {
                                Ok: function() { $( this ).dialog( "close" );}
                            }
                        });        
                    });
                    //setTimeout('document.location.href="manage_emp_performance_report.php";',500);
                    </script>
                    <?php
                }
            }
			if($success==0)
			{
				?>
            	<tr><td>
   				<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" >
				<table border="0" cellspacing="15" cellpadding="0" width="100%">
              	<tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
				<tr>
                    <td width="20%">Select Date<span class="orange_font">*</span></td>
                    <td><input type="text" name="date" class="input_text datepicker" placeholder="Date" id="date" title="Date" value="<?php if($_REQUEST['date']) echo $_REQUEST['date']; else echo date('d/m/Y',strtotime('-1 days')) ?>">
                    </td>
                </tr>
                <tr>
                <td width="20%">Select Branch Name<span class="orange_font">*</span></td>
				<?php 
                if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                {
                    ?>
                    <td >
                        <select name="branch_name" id="branch_name" class="input_select_login" style="width: 300px;" onchange="getstaffDetails(this.value)">
                        <option value="">-Branch Name-</option>
                        <?php 
                        $sel_branch="select branch_id,branch_name from branch where status='Active'";
                        $ptr_sel=mysql_query($sel_branch);
                        while($data_branch=mysql_fetch_array($ptr_sel))
                        {
                            $sel='';
                            if($data_branch['branch_name']==$_GET['branch_name'])
                            {
                                $sel='selected="selected"';
                            }
                            else if($data_branch['branch_name']=='Pune')
                            {
                                $sel='selected="selected"';
                            }
                            echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
                        }
                        ?>
                        </select>
                    </td>
                    <?php
                }
                else 
                {
                    ?>
                    <td colspan="2" align="left">
                    <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>" />
                    </td>
                    <?php 
                }
				?>
                <tr>
                    <td width="20%">Select Staff<span class="orange_font">*</span></td>
                    <td id="staff_ids">
                        <select name="staff_id" id="staff_id" class="input_select" style="width:300px" onchange="check_data(this.value)">
                            <option value="">Select Staff</option>
                            <?php
                            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                            {
                                if($_REQUEST['branch_name']!='')
                                {
                                    $branch_name=$_REQUEST['branch_name'];
                                    $select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
                                    $ptr_cm_id=mysql_query($select_cm_id);
                                    $data_cm_id=mysql_fetch_array($ptr_cm_id);
                                    $search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
                                    $cm_ids=$data_cm_id['cm_id'];
                                }
                                else
                                {
                                    $search_cm_id=" and cm_id='2'";
                                    $cm_ids='2';
                                }
                            }
                            $sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." ".$search_cm_id." and system_status='Enabled' order by name asc"; 
                            $ptr_name=mysql_query($sle_name);
                            while($data_name=mysql_fetch_array($ptr_name))
                            {
                                $selected='';
                                if($data_name['admin_id'] == $_REQUEST['staff_id'])
                                {
                                    $selected='selected="selected"';
                                }
                                echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Presence<span class="orange_font">*</span></td>
                    <td>
                        <select name="presence" id="presence" class="input_select">
                        	<option value="">Select Presence</option>
                        	<option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">Enter Timesheet Status<span class="orange_font">*</span></td>
                    <td>
                        <select name="timesheet_status" id="timesheet_status" class="input_select" onchange="change_mark(this.value)">
                        	<option value="">Select Timesheet Status</option>
                        	<option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </td>
                    <td><input type="hidden" name="timesheet_mark" class="input_text" id="timesheet_mark" title="Timesheet Mark" value="<?php if($_POST['timesheet_mark']) echo $_POST['timesheet_mark']; else echo $row_record['timesheet_mark'];?>"> </td>
                </tr>
                <tr>
                    <td width="20%">Utilisation<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="utilisation"  onblur="calculate_utilisation(this.value)" maxlength="3" class="input_text" id="utilisation" title="utilisation" value="<?php if($_POST['utilisation']) echo $_POST['utilisation']; else echo $row_record['utilisation']; ?>">%<input type="hidden" name="utilisation_mark" id="utilisation_mark" value="<?php if($_POST['utilisation_mark']) echo $_POST['utilisation_mark']; else echo $row_record['utilisation_mark']; ?>">
                    </td>
                </tr>
                
                <tr>
                    <td width="20%">Working Hours<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="working_hours" class="input_text" id="working_hours" title="working_hours" value="<?php if($_POST['working_hours']) echo $_POST['working_hours']; else echo $row_record['working_hours']; ?>">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">Task Completion<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="task_completion" class="input_text" onblur="calculate_task(this.value)" id="task_completion" title="task_completion" value="<?php if($_POST['task_completion']) echo $_POST['task_completion']; else echo $row_record['task_completion']; ?>">%
                    </td>
                    <td><input type="hidden" name="task_mark" style="text-align:center; width:100px" class="input_text" id="task_mark" title="Task Mark" value="<?php if($_POST['task_mark']) echo $_POST['task_mark']; else echo $row_record['task_mark']; ?>"> </td>
                </tr>
                <tr>
                    <td width="20%">Quality of Work<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="quality_of_work" class="input_text" id="quality_of_work" onblur="calculate_qualityWork(this.value)" title="quality_of_work" value="<?php if($_POST['quality_of_work']) echo $_POST['quality_of_work']; else echo $row_record['quality_of_work']; ?>">%
                    </td>
                    <td><input type="hidden" name="quality_work_mark" style="text-align:center; width:100px" class="input_text" id="quality_work_mark" title="Quality Work Mark" value="<?php if($_POST['quality_work_mark']) echo $_POST['quality_work_mark']; else echo $row_record['quality_work_mark']; ?>"> </td>
                </tr>
                <tr>
                    <td width="20%"><strong>Rules Followed</strong><span class="orange_font">*</span></td>
                </tr>
                <tr>
                <td></td>
                <td width="100%">
                <table width="80%">
                <tr>
                    <td width="40%">Class Start on Time </td> 
                    <td width="30%">Yes<input type="radio" name="class_start_time_r"  onchange="calculate_cst(this.value)" id="class_start_time_r_y" class="input_radio" value="yes"> No<input type="radio" name="class_start_time_r" onchange="calculate_cst(this.value)" id="class_start_time_r_n" class="input_radio" value="no"> </td>
                    
                    <td width="20%"><input type="text" readonly="readonly" name="class_start_time_mark" style="text-align:center; width:100px" class="input_text" id="class_start_time_mark" value="<?php if($_POST['class_start_time_mark']) echo $_POST['class_start_time_mark']; else echo $row_record['class_start_time_mark']; ?>">
                	</td>
                </tr>
                <tr>
                    <td>Class End on Time </td>
                    <td>Yes<input type="radio" name="class_end_time_r" id="class_end_time_r_y" onchange="calculate_cet(this.value)" class="input_radio" value="yes"> No<input type="radio" name="class_end_time_r" id="class_end_time_r_n" onchange="calculate_cet(this.value)" class="input_radio" value="no"> </td>
                    <td><input type="text" readonly="readonly" name="class_end_time_r_mark" style="text-align:center; width:100px" class="input_text" id="class_end_time_r_mark" value="<?php if($_POST['class_end_time_r_mark']) echo $_POST['class_end_time_r_mark']; else echo $row_record['class_end_time_r_mark']; ?>"> 
                    </td>
                </tr>
                <tr>
                    <td>Faculty Grooming </td>
                    <td>Yes<input type="radio" name="faculty_grooming_r" id="faculty_grooming_r_y" onchange="calculate_fg(this.value)" class="input_radio" value="yes"> No<input type="radio" name="faculty_grooming_r" id="faculty_grooming_r_n" onchange="calculate_fg(this.value)" class="input_radio" value="no"></td>
                    <td><input type="text" readonly="readonly" name="faculty_grooming_r_mark" style="text-align:center; width:100px" class="input_text" id="faculty_grooming_r_mark" value="<?php if($_POST['faculty_grooming_r_mark']) echo $_POST['faculty_grooming_r_mark']; else echo $row_record['faculty_grooming_r_mark']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Logsheet Send </td>
                    <td>Yes<input type="radio" name="logsheet_send_r" id="logsheet_send_r_y" onchange="calculate_ls(this.value)" class="input_radio" value="yes"> No<input type="radio" name="logsheet_send_r" id="logsheet_send_r_n" onchange="calculate_ls(this.value)" class="input_radio" value="no"></td>
                    <td><input type="text" readonly="readonly" name="logsheet_send_r_mark" style="text-align:center; width:100px" class="input_text" id="logsheet_send_r_mark" value="<?php if($_POST['logsheet_send_r_mark']) echo $_POST['logsheet_send_r_mark']; else echo $row_record['logsheet_send_r_mark']; ?>"> 
                    </td>
                </tr>
                <tr>
                    <td>Mobile Not Used in Batch Hours </td>
                    <td>Yes<input type="radio" name="mobile_used_r" id="mobile_used_r_y" onchange="calculate_mubh(this.value)" class="input_radio" value="yes"> No<input type="radio" name="mobile_used_r" id="mobile_used_r_n" onchange="calculate_mubh(this.value)" class="input_radio" value="no"> </td>
                    <td><input type="text" readonly="readonly" name="mobile_used_r_mark" style="text-align:center; width:100px" class="input_text" id="mobile_used_r_mark" value="<?php if($_POST['mobile_used_r_mark']) echo $_POST['mobile_used_r_mark']; else echo $row_record['mobile_used_r_mark']; ?>"> 
                    </td>
                </tr>
                <tr>
                    <td>Timetable Followed </td>
                    <td>Yes<input type="radio" name="timetable_followed_r" id="timetable_followed_r_y" onchange="calculate_tf(this.value)" class="input_radio" value="yes"> No<input type="radio" name="timetable_followed_r" id="timetable_followed_r_n" onchange="calculate_tf(this.value)" class="input_radio" value="no"> </td>
                    <td><input type="text" readonly="readonly" name="timetable_followed_r_mark" style="text-align:center; width:100px" class="input_text" id="timetable_followed_r_mark" value="<?php if($_POST['timetable_followed_r_mark']) echo $_POST['timetable_followed_r_mark']; else echo $row_record['timetable_followed_r_mark']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Student Decoram </td>
                    <td>Yes<input type="radio" name="student_decoram_r" id="student_decoram_r_y" onchange="calculate_sd(this.value)" class="input_radio" value="yes"> No<input type="radio" name="student_decoram_r" id="student_decoram_r_n" onchange="calculate_sd(this.value)" class="input_radio" value="no"> </td>
                    <td><input type="text" readonly="readonly" name="student_decoram_r_mark" style="text-align:center; width:100px" class="input_text" id="student_decoram_r_mark" value="<?php if($_POST['student_decoram_r_mark']) echo $_POST['student_decoram_r_mark']; else echo $row_record['student_decoram_r_mark']; ?>">
                    </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                    <td width="20%">Phone Submited<span class="orange_font">*</span></td>
                    <td><select name="phone_submited" id="phone_submited" class="input_select">
                        	<option value="">Select Status</option>
                        	<option value="yes">Yes</option>
                            <option value="no" selected="selected">No</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">No. of Negative Remark<span class="orange_font">*</span></td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td width="100%">
                        <table width="80%">
                            <tr>
                                <td width="40%">Late Login Without Info </td> 
                                <td width="30%">Yes<input type="radio" name="late_login_without_info" onchange="calculate_llwi(this.value)" id="late_login_without_info_y" class="input_radio" value="yes"> No<input type="radio" name="late_login_without_info" onchange="calculate_llwi(this.value)" id="late_login_without_info_n" class="input_radio" value="no"> </td>
                                <td width="20%"><input type="text" readonly="readonly" name="late_login_without_info_mark" style="text-align:center; width:100px" class="input_text" id="late_login_without_info_mark" value="<?php if($_POST['late_login_without_info_mark']) echo $_POST['late_login_without_info_mark']; else echo $row_record['late_login_without_info_mark']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Absent Without Info</td>
                                <td>Yes<input type="radio" name="absent_without_info" id="absent_without_info_y" onchange="calculate_awi(this.value)" class="input_radio" value="yes"> No<input type="radio" name="absent_without_info" id="absent_without_info_n" onchange="calculate_awi(this.value)" class="input_radio" value="no"> </td>
                                <td><input type="text" readonly="readonly" name="absent_without_info_mark" style="text-align:center; width:100px" class="input_text" id="absent_without_info_mark" value="<?php if($_POST['absent_without_info_mark']) echo $_POST['absent_without_info_mark']; else echo $row_record['absent_without_info_mark']; ?>"> 
                                </td>
                            </tr>
                            <tr>
                                <td>Early Checkout Without Info</td>
                                <td>Yes<input type="radio" name="early_checkout_info" id="early_checkout_info_y" onchange="calculate_ecwi(this.value)" class="input_radio" value="yes"> No<input type="radio" name="early_checkout_info" id="early_checkout_info_n" onchange="calculate_ecwi(this.value)" class="input_radio" value="no"></td>
                                <td><input type="text" readonly="readonly" name="early_checkout_info_mark" style="text-align:center; width:100px" class="input_text" id="early_checkout_info_mark" value="<?php if($_POST['early_checkout_info_mark']) echo $_POST['early_checkout_info_mark']; else echo $row_record['early_checkout_info_mark']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Misconduct With Staff </td>
                                <td>Yes<input type="radio" name="misconduct_with_staff" id="misconduct_with_staff_y" onchange="calculate_mws(this.value)" class="input_radio" value="yes"> No<input type="radio" name="misconduct_with_staff" id="misconduct_with_staff_n" onchange="calculate_mws(this.value)" class="input_radio" value="no"></td>
                                <td><input type="text" readonly="readonly" name="misconduct_with_staff_mark" style="text-align:center; width:100px" class="input_text" id="misconduct_with_staff_mark" value="<?php if($_POST['misconduct_with_staff_mark']) echo $_POST['misconduct_with_staff_mark']; else echo $row_record['misconduct_with_staff_mark']; ?>"> 
                                </td>
                            </tr>
                            <tr>
                                <td>Misconduct With Student</td>
                                <td>Yes<input type="radio" name="misconduct_with_student" id="misconduct_with_student_y" onchange="calculate_mwst(this.value)" class="input_radio" value="yes"> No<input type="radio" name="misconduct_with_student" id="misconduct_with_student_n" onchange="calculate_mwst(this.value)" class="input_radio" value="no"> </td>
                                <td><input type="text" readonly="readonly" name="misconduct_with_student_mark" style="text-align:center; width:100px" class="input_text" id="misconduct_with_student_mark" value="<?php if($_POST['misconduct_with_student_mark']) echo $_POST['misconduct_with_student_mark']; else echo $row_record['misconduct_with_student_mark']; ?>"> 
                                </td>
                            </tr>
                            <tr>
                                <td>Logsheet Not Checked</td>
                                <td>Yes<input type="radio" name="logsheet_not_checked" id="logsheet_not_checked_y" onchange="calculate_lnc(this.value)" class="input_radio" value="yes"> No<input type="radio" name="logsheet_not_checked" id="logsheet_not_checked_n" onchange="calculate_lnc(this.value)" class="input_radio" value="no"> </td>
                                <td><input type="text" readonly="readonly" name="logsheet_not_checked_mark" style="text-align:center; width:100px" class="input_text" id="logsheet_not_checked_mark" value="<?php if($_POST['logsheet_not_checked_mark']) echo $_POST['logsheet_not_checked_mark']; else echo $row_record['logsheet_not_checked_mark']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Other Issue</td>
                                <td>Yes<input type="radio" name="other_issue" id="other_issue_y" onchange="calculate_oi(this.value)" class="input_radio" value="yes"> No<input type="radio" name="other_issue" id="other_issue_n" onchange="calculate_oi(this.value)" class="input_radio" value="no"> </td>
                                <td><input type="text" readonly="readonly" name="other_issue_mark" style="text-align:center; width:100px" class="input_text" id="other_issue_mark" value="<?php if($_POST['other_issue_mark']) echo $_POST['other_issue_mark']; else echo $row_record['other_issue_mark']; ?>">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td></td>
                    <td>
                        <input type="text" name="negative_remark_mark" readonly="readonly" id="negative_remark_mark" class="input_text" title="Negative Remark Mark" value="<?php if($_POST['negative_remark_mark']) echo $_POST['negative_remark_mark']; else echo $row_record['negative_remark_mark']; ?>">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">Total Points<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="points" class="input_text" readonly="readonly" id="points" title="points" value="<?php if($_POST['points']) echo $_POST['points']; else echo $row_record['points']; ?>">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">Monthly Points Till Date<span class="orange_font">*</span></td>
                    <td>
                        <input type="text" name="monthly_points" class="input_text" readonly="readonly" id="monthly_points" title="Monthly Points" value="<?php if($_POST['monthly_points']) echo $_POST['monthly_points']; else echo $row_record['monthly_points']; ?>">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">Comments<span class="orange_font">*</span></td>
                    <td><textarea type="text" name="comments" style="height:50px" class="input_text" id="comments" title="comments" value="<?php if($_POST['comments']) echo $_POST['comments']; else echo $row_record['comments']; ?>"> </textarea>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><input type="submit" onclick="return validme()" name="save_changes"  value="Save"  /></td>
                </tr>
        	</table>
        	</form>
        	</td></tr>
			<?php
         }   
		 ?>
	 
        </table></td>
    <td class="mid_right"></td>
  </tr>
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>
<script>
/*$(document).ready(function()
{
	document.getElementById("utilisation").value=0;
	document.getElementById("task_completion").value=0;
	document.getElementById("quality_of_work").value=0;
	document.getElementById("class_start_time_mark").value=0;
	document.getElementById("class_end_time_r_mark").value=0;
	document.getElementById("faculty_grooming_r_mark").value=0;
	document.getElementById("logsheet_send_r_mark").value=0;
	document.getElementById("mobile_used_r_mark").value=0;
	document.getElementById("timetable_followed_r_mark").value=0;
	document.getElementById("student_decoram_r_mark").value=0;
	document.getElementById("negative_remark_mark").value=0;
}*/
</script>
</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>