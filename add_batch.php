<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
//echo $_REQUEST['record_id'];
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
	//$record_id_course=$_REQUEST['course_batch_id'];
	
    $sql_record= "SELECT * FROM course_batch_mapping where c_b_id='".$record_id."' ";
    if(mysql_num_rows($db->query($sql_record)))
	{
		$row_record=$db->fetch_array($db->query($sql_record));
		$c_id = $row_record['course_id'];
	}
	else
    $record_id=0;
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<?php
//function addDays($timestamp, $days) {
	// $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday")
	// $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01");
  	 //timestamp is strtotime of ur $startDate
	
//}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Batch</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
<!--End multiselect -->
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
           /* $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});*/
			
			$("#course_id").chosen({allow_single_deselect:true});
			$("#batch_type").chosen({allow_single_deselect:true});
			$("#batch_category").chosen({allow_single_deselect:true});
			//$("#batch_id").chosen({allow_single_deselect:true});
			$("#batch").chosen({allow_single_deselect:true});
			$("#staff").chosen({allow_single_deselect:true});
			$("#domain_id").chosen({allow_single_deselect:true});
			<?php
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
			{
				?>
				$("#branch_name").chosen({allow_single_deselect:true});
				<?php
			}
			?>
        });
        function showdiv(val)
        {
            if(val=='Y')
            {
                $(".coursess").hide();
            }
            else
            {
                $(".coursess").show();
            }
        }
        function show_dicount(val)
        {            
            if(val=='Y')
            {
                $(".discount").show();
            }
            else
            {
                $(".discount").hide();
            }
        }
    </script>
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
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
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
		
      </script>
    
<script>
/*$(document).ready(function() {
    $("#batch_id").change(function() {
        var selVal = $(this).val();
		//alert(selVal);
        $("#customise").html('');
		
        if(selVal == 'new_batch') 
		{
            $("#customise").append('<table width="40%"><tr><td width="50%" class="heading">Add Batch Name</span></td><td width="38%" colspan=2"><input type="text" class="input_text" name="batch_name"/></td></tr></table>');
		}
		else{}
    });
});*/

function del_not(enroll_id, i)
{
	var el = 'requirment_id'+i;
	//alert(document.getElementById(el).checked);
	if( document.getElementById(el).checked)
		document.getElementById("del_enroll_"+i).value='';
	else
		document.getElementById("del_enroll_"+i).value=enroll_id;
	//alert (document.getElementById("del_enroll_"+i).value);
}
</script>
<script>
function course_ajax(course_id) 
{
	var selVal = course_id;
	var branch_name= document.getElementById('branch_name').value;
	<?php 
	$concsts ='';
	if($record_id)
	{
		$concsts= "+'&course_batch_id=$record_id'";
	}
	?>
	var data1="course_id="+selVal+"&branch_name="+branch_name<?php echo $concsts; ?>;
	///alert(data1);
	$.ajax ({
	url: "get_student.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//document.getElementById('student_div').innerHTML=html;
		//alert(html);
		//$(".multiselect").multiselect();
	}
	});
	
	var data2="action=check_logsheet_exist&course_id="+selVal;
	//alert(data2);
	$.ajax ({
	url: "ajax.php", type: "post", data: data2, cache: false,
	success: function (html)
	{
		var sep=html.split('##');
		if(sep[0]!="exist")
		{
			alert("Logsheet is not found for this course. Please create logsheet first\n Go to ==> Manage Logsheet");
			document.getElementById('mySubmit').style.display='none';
		}
		else
		{
			document.getElementById('logsheet_id').value=sep[1].trim();
			document.getElementById('timetable_exist').value='yes';
			document.getElementById('mySubmit').style.display='block';
		}
	}
	});
}
</script>
<script>
function validme()
{   
	frm = document.jqueryForm;
	error='';
    disp_error = 'Clear The Following Errors : \n\n';	 
	if(frm.course_id.value=='')
	{
    	//alert('hi');
		disp_error +='Select Course\n';
		document.getElementById('course_id').style.border = '1px solid #f00';
		frm.course_id.focus();
		error='yes';
    }
	if(frm.batch_name.value=='')
	{
		//alert('hi');
		 disp_error +='Enter Batch Name\n';
		 document.getElementById('batch_name').style.border = '1px solid #f00';
		 frm.batch_name.focus();
		 error='yes';
	 }
	 if(frm.batch.value=='')
	 {
		//alert('hi');
		 disp_error +='Select Batch Time\n';
		 document.getElementById('batch').style.border = '1px solid #f00';
		 frm.batch.focus();
		 error='yes';
	 } 
	 if(frm.staff.value=='')
	 {
		//alert('hi');
		 disp_error +='Select Faculty\n';
		 document.getElementById('staff').style.border = '1px solid #f00';
		 frm.staff.focus();
		 error='yes';
	 }
	 if(frm.start_date.value=='')
	 {
		//alert('hi');
		disp_error +='Enter Start Date\n';
		document.getElementById('start_date').style.border = '1px solid #f00';
		frm.start_date.focus();
		error='yes';
	 }
	 if(frm.start_time.value=='')
	 {
		//alert('hi');
		 disp_error +='Enter Start Time\n';
		 document.getElementById('start_time').style.border = '1px solid #f00';
		 frm.start_time.focus();
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
 //}
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
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
						$branch_name = (true == isset( $_POST['branch_name'] )) ? $_POST['branch_name'] : "";
						$domain_id = (true == isset( $_POST['domain_id'] )) ? $_POST['domain_id'] : "";
						$batch_type = (true == isset( $_POST['batch_type'] )) ? $_POST['batch_type'] : "";
						$logsheet_id= (true == isset( $_POST['logsheet_id'] )) ? $_POST['logsheet_id'] : "";
						$arrage_date= explode('/',$_POST['start_date'],3);     
						$start_date= $arrage_date[2].'-'.$arrage_date[1].'-'.$arrage_date[0];
						$start_date = ( true == isset( $start_date )) ? $start_date : "";
						$arrage_date= explode('/',$_POST['end_date'],3);     
						/*$end_date= $arrage_date[2].'-'.$arrage_date[1].'-'.$arrage_date[0];
						$end_date = ( true == isset( $end_date )) ? $end_date : "";*/
						//$batch_id_post = ( true == isset( $_POST['batch_id'] )) ? $_POST['batch_id'] : "";
					   	$batch_name = ( true == isset( $_POST['batch_name'] )) ? $_POST['batch_name'] : "";
						/*$start_time = ( true == isset( $_POST['start_time'] )) ? $_POST['start_time'] : "";
						$end_time = ( true == isset( $_POST['end_time'] )) ? $_POST['end_time'] : "";*/
						$no_of_student = ( true == isset( $_POST['no_of_student'] )) ? $_POST['no_of_student'] : "0";
						$course_id = ( true == isset( $_POST['course_id'] )) ? $_POST['course_id'] : "0";
						$batch = ( true == isset( $_POST['batch'] )) ? $_POST['batch'] : "0";
						$staff = ( true == isset( $_POST['staff'] )) ? $_POST['staff'] : "0";						
                        if(count($errors))
                        {
                        	?>
                        	<tr><td> <br></br>
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
                            
							//===============================CM ID for Super Admin===============
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$data_record['cm_id']=$cm_id;
								$data_record_batch['cm_id'] =$cm_id;
								$data_record_s_c_b_map['cm_id']=$cm_id;
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$cm_id=$_SESSION['cm_id'];
								$data_record['cm_id']=$cm_id;
								$data_record_batch['cm_id'] =$cm_id;
								$data_record_s_c_b_map['cm_id']=$cm_id;
							}
							//====================================================================
                            $data_record['start_date'] =$start_date;
							/*$data_record['end_date'] = $end_date;
                            $data_record['start_time'] = $start_time;
                            $data_record['end_time'] =$end_time;*/
							$data_record['admin_id']=$_SESSION['admin_id'];
							$data_record['added_date']=date('Y-m-d H:i:s');
							$data_record['course_id']=$course_id;
							$data_record['course_domain_id']=$domain_id;
							$data_record['batch_type']=$batch_type;
							$data_record['logsheet_id']=$logsheet_id;
							$data_record['batch_time_id']=$batch;
							$data_record['staff_id']=$staff;
							
							$data_record_batch['cm_id']=$cm_id;
							$data_record_batch['admin_id']=$_SESSION['admin_id'];
							$data_record_batch['added_date']=date('Y-m-d H:i:s');
							
							$data_record_s_c_b_map['admin_id']=$_SESSION['admin_id'];
							$data_record_s_c_b_map['added_date']=date('Y-m-d H:i:s');
							$data_record_s_c_b_map['course_id']=$course_id;
							$data_record_s_c_b_map['enroll_id']=$enroll_id;
							//$data_record_s_c_b_map['cm_id']=$_SESSION['cm_id'];
							
                            if($record_id)
                            {
								$data_record['batch_name'] = $batch_name;
								$data_record_batch['batch_name']=$batch_name;
                                $where_record=" c_b_id='".$record_id."' ";
								$db->query_update("course_batch_mapping", $data_record,$where_record);
								
								/*$update_no_of_studf = "update course_batch_mapping set no_of_student=".count($_POST['requirment_id'])." where c_b_id ='".$c_b_id."'  ";
								$uipd = mysql_query($update_no_of_studf);*/
								
								$del_batch_timetable="delete from batch_timetable where c_b_id='".$record_id."'";
								$ptr_batch_timetable=mysql_query($del_batch_timetable);
								
								if($_POST['timetable_exist']=="yes")
								{
									$batch_start_date=$start_date;
									$select_timetable="select logsheet_id from logsheet where logsheet_id='".$logsheet_id."'";
									$ptr_timetable=mysql_query($select_timetable);
									if($total_days=mysql_num_rows($ptr_timetable))
									{
										$data_timetable=mysql_fetch_array($ptr_timetable);
										
										$select_holidays="select holiday_date from holiday_mapping where 1 and cm_id='".$cm_id."'";
										$ptr_hol=mysql_query($select_holidays);
										while($day_holi=mysql_fetch_array($ptr_hol))
										{
											$skipdates[]=$day_holi['holiday_date'];
										}
										//print_r($skipdates);
									    $sel_data="select DISTINCT(day) from logsheet_map where logsheet_id='".$data_timetable['logsheet_id']."' order by day asc";
										$ptr_timet_data=mysql_query($sel_data);
										$total_days=mysql_num_rows($ptr_timet_data);
										$startDate=$start_date;
										$timestamp=strtotime($startDate);
										$days=$total_days;
										while($data_times=mysql_fetch_array($ptr_timet_data))
										{
											//$skipdates=array("2019-07-03","2019-07-05","2019-07-08","2019-07-15","2019-07-18",);
											if($batch_type=='weekdays')
											{
												$skipdays = array("Sunday");
											}
											else
											{
												$skipdays = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday");
											}
											$i = 1;
											$dates=array();
											
											//$timestamp = strtotime("+ 0 day", $timestamp);
											//echo "<br/>-->".date("l", $timestamp)."--".$timestamp;
											$totals=1;
											for($i=1;$i<=$totals;$i++)
											{
												if ((in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates)))
												{	
													$timestamp=strtotime("+ 1 day", $timestamp);
													//$dates[$i]=date("d/m/Y",strtotime("+ 1 day", $timestamp));
													//$timestamp = strtotime("+ 1 day", $timestamp);
													$totals++;
												}
												else
												{
													$sel_logdata="select * from logsheet_map where logsheet_id='".$data_timetable['logsheet_id']."' and day='".$data_times['day']."' order by day asc";
													$ptr_logdata=mysql_query($sel_logdata);
													while($data_log=mysql_fetch_array($ptr_logdata))
													{
														$data_record_timetable['c_b_id']=$record_id;
														$data_record_timetable['logsheet_map_id']=$data_log['logsheet_map_id'];
														$data_record_timetable['logsheet_id']=$data_log['logsheet_id'];
														$data_record_timetable['course_id']=$course_id;
														$data_record_timetable['course_domain_id']=$data_log['course_domain_id'];
														$data_record_timetable['day']=$data_log['day'];
														$data_record_timetable['staff_id']=$staff;
														$data_record_timetable['topic_id']=$data_log['topic_id'];
														$data_record_timetable['topic_content']=$data_log['topic_content'];
														$data_record_timetable['model_required']=$data_log['model_required'];
														$data_record_timetable['admin_id']=$_SESSION['admin_id'];
														$data_record_timetable['cm_id']=$cm_id;
														$data_record_timetable['added_date']=date('Y-m-d H:i:s');
														$data_record_timetable['date']=date("Y-m-d", $timestamp);
														//echo "<br/>".date("Y-m-d", $timestamp);
														$courses_batch_id=$db->query_insert("batch_timetable", $data_record_timetable); 
													}
													
													if($i==$totals)
													{
														$data_record_c_b_d['end_date']=date("Y-m-d", $timestamp);
														$where_record_c_b="c_b_id='".$record_id."'";
														$db->query_update("course_batch_mapping", $data_record_c_b_d,$where_record_c_b);
													}
													$timestamp=strtotime("+ 1 day", $timestamp);
												}
											}
																		
										}
									}
									echo ' <br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div> <br></br>';
								}
								else
								{
									echo ' <br></br><div id="msgbox" style="width:40%;">Logsheet is not Found for this Course</center></div> <br></br>';
								}
								
                            }
                            else
                           	{
								$data_record_batch['batch_name']=$batch_name;
								$data_record['batch_name'] = $batch_name;
								$where_admin_id="admin_id='".$_SESSION['admin_id']."'";
								/*if($data_record_batch['batch_name']!='' && $_POST['batch_id'] =='new_batch')
								{
                              		$batch_id=$db->query_insert("batch", $data_record_batch);  
									$data_record['batch_id'] = $batch_id;
									$data_record_s_c_b_map['batch_id'] = $batch_id;
									$batch_id_post= $batch_id;
								}
								else
								{
									$data_record['batch_id'] = $batch_id_post;
									$data_record_s_c_b_map['batch_id'] = $batch_id_post;									
								}*/
								$data_record['status'] = 'not_started';
								$c_b_id=$db->query_insert("course_batch_mapping", $data_record); 
								/*for($h=0;$h<count($_POST['requirment_id']);$h++)
								{
									$insert_into_student_course_batch_map = " insert into student_course_batch_map(`c_b_id`, `batch_id`, `enroll_id`, `course_id`, `admin_id`, `cm_id`, `added_date` )values('".$c_b_id."', '".$batch_id_post."','".$_POST['requirment_id'][$h]."','".$course_id."', '".$_SESSION['admin_id']."', '".$cm_id."', '".date('Y-m-d H:i:s')."' )  ";
									$ptr_insert_c = mysql_query($insert_into_student_course_batch_map);
									$update_enrollment_status = "update enrollment set status='batch_scheduled',batch_id='".$c_b_id."' where enroll_id='".$_POST['requirment_id'][$h]."' ";
									//$ptr_update = mysql_query($update_enrollment_status);
								}*/
								/*$update_no_of_studf = "update course_batch_mapping set no_of_student=".count($_POST['requirment_id'])." where c_b_id ='".$c_b_id."'  ";
								$uipd = mysql_query($update_no_of_studf);*/
								
								
								
								if($_POST['timetable_exist']=="yes")
								{
									
									$batch_start_date=$start_date;
									$select_timetable="select logsheet_id from logsheet where logsheet_id='".$logsheet_id."'";
									$ptr_timetable=mysql_query($select_timetable);
									if($total_days=mysql_num_rows($ptr_timetable))
									{
										$data_timetable=mysql_fetch_array($ptr_timetable);
										
										$select_holidays="select holiday_date from holiday_mapping where 1 and cm_id='".$cm_id."'";
										$ptr_hol=mysql_query($select_holidays);
										while($day_holi=mysql_fetch_array($ptr_hol))
										{
											$skipdates[]=$day_holi['holiday_date'];
										}
										//print_r($skipdates);
									    $sel_data="select DISTINCT(day) from logsheet_map where logsheet_id='".$data_timetable['logsheet_id']."' order by day asc";
										$ptr_timet_data=mysql_query($sel_data);
										$total_days=mysql_num_rows($ptr_timet_data);
										$startDate=$start_date;
										$timestamp=strtotime($startDate);
										$days=$total_days;
										while($data_times=mysql_fetch_array($ptr_timet_data))
										{
											//$skipdates=array("2019-07-03","2019-07-05","2019-07-08","2019-07-15","2019-07-18",);
											if($batch_type=='weekdays')
											{
												$skipdays = array("Sunday");
											}
											else
											{
												$skipdays = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday");
											}
											$i = 1;
											$dates=array();
											
											//$timestamp = strtotime("+ 0 day", $timestamp);
											//echo "<br/>-->".date("l", $timestamp)."--".$timestamp;
											$totals=1;
											for($i=1;$i<=$totals;$i++)
											{
												if ((in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates)))
												{	
													$timestamp=strtotime("+ 1 day", $timestamp);
													
													//$dates[$i]=date("d/m/Y",strtotime("+ 1 day", $timestamp));
													//$timestamp = strtotime("+ 1 day", $timestamp);
													$totals++;
												}
												else
												{
													$sel_logdata="select * from logsheet_map where logsheet_id='".$data_timetable['logsheet_id']."' and day='".$data_times['day']."' order by day asc";
													$ptr_logdata=mysql_query($sel_logdata);
													while($data_log=mysql_fetch_array($ptr_logdata))
													{
														$data_record_timetable['c_b_id']=$c_b_id;
														$data_record_timetable['logsheet_map_id']=$data_log['logsheet_map_id'];
														$data_record_timetable['logsheet_id']=$data_log['logsheet_id'];
														$data_record_timetable['course_id']=$course_id;
														$data_record_timetable['course_domain_id']=$data_log['course_domain_id'];
														$data_record_timetable['day']=$data_log['day'];
														$data_record_timetable['staff_id']=$staff;
														$data_record_timetable['topic_id']=$data_log['topic_id'];
														$data_record_timetable['topic_content']=$data_log['topic_content'];
														$data_record_timetable['model_required']=$data_log['model_required'];
														$data_record_timetable['admin_id']=$_SESSION['admin_id'];
														$data_record_timetable['cm_id']=$cm_id;
														$data_record_timetable['added_date']=date('Y-m-d H:i:s');
														$data_record_timetable['date']=date("Y-m-d", $timestamp);
														//echo "<br/>".date("Y-m-d", $timestamp);
														$courses_batch_id=$db->query_insert("batch_timetable", $data_record_timetable); 
													}
													
													if($i==$totals)
													{
														$data_record_c_b_d['end_date']=date("Y-m-d", $timestamp);
														$where_record_c_b="c_b_id='".$c_b_id."'";
														$db->query_update("course_batch_mapping", $data_record_c_b_d,$where_record_c_b);
													}
													$timestamp=strtotime("+ 1 day", $timestamp);
												}
											}
																		
										}
									}
									echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
								}
								else
								{
									echo ' <br></br><div id="msgbox" style="width:40%;">Logsheet is not Found for this Course</center></div> <br></br>';
								}
								//$courses_batch_id=$db->query_insert("student_course_batch_map", $data_record_s_c_b_map);  		
                               	
                           	}
                            
                        }
                    }
                    if($success==0)
                    {
                        ?>
            			<tr><td>
        				<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" >
							<table border="0" cellspacing="15" cellpadding="0" width="100%">
            					<tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            					<?php
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								{
									?>
                                    <tr>
                                        <td>Select Branch</td>
                                        <td>
                                        <?php
                                       	$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                                        $query_branch = mysql_query($sel_branch);
                                        $total_Branch = mysql_num_rows($query_branch);
                                        echo '<table width="100%"><tr><td>';
                                        echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
                                        while($row_branch = mysql_fetch_array($query_branch))
                                        {
                                            $selected='';
                                            if($_POST['branch_name']== $row_branch['branch_name'])
                                            {
                                                 $selected='selected="selected"';
                                            }
                                            $selected_branch="select branch_name from site_setting where cm_id= '".$row_record['cm_id']."' and type='A' ";
                                            $ptr_selected=mysql_query($selected_branch);
                                            if(mysql_num_rows($ptr_selected))
                                            {
                                                $data_cm_id=mysql_fetch_array($ptr_selected);
                                                if($data_cm_id['branch_name'] == $row_branch['branch_name'] )
                                                {
                                                     $selected='selected="selected"';
                                                }
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $row_branch['branch_name'];?>"><?php echo $row_branch['branch_name']; ?> 
                                            </option>
                                            <?php
                                        }
                                        echo '</select>';
                                        echo "</td></tr></table>";
                                        ?>
                                        </td>
                                    </tr>
                                    <?php 
								}
								else 
								{ 
									?>
       								<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
      								<?php 
								}?>
                                
                                <?php
								$sel_name="SELECT MAX(`c_b_id`) as last_id from course_batch_mapping";
								$ptr_name=mysql_query($sel_name);
								$data_name=mysql_fetch_array($ptr_name);
								?>
                                <tr>
                                    <td width="20%">Batch Name<span class="orange_font">*</span></td>
                                    <td width="40%" class="input_box"><input type="text" name="batch_name" id="batch_name" class="input_text" <?php if($_SESSION['type']!='S') echo 'readonly="readonly"'; ?> value="<?php if($record_id !='') { echo $row_record['batch_name']; } else echo $data_name['last_id']+100; ?>"  /></td>
                                </tr>
                                <tr>
                                    <td width="20%">Select Batch Type<span class="orange_font">*</span></td>
                                    <td width="40%" class="customized_select_box">
                                        <select name="batch_type" id="batch_type" class=" input_select">
                                            <option value="">Select Batch Type</option>
                                            <option value="weekdays" <?php if($row_record['batch_type']=='weekdays') echo 'selected="selected"'; ?>>Weekdays</option>
                                            <option value="weekend" <?php if($row_record['batch_type']=='weekend') echo 'selected="selected"'; ?>>Weekend</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">Select Batch Category<span class="orange_font">*</span></td>
                                    <td width="40%" class="customized_select_box">
                                     <select name="domain_id" id="domain_id" class="validate[required] input_select" >  
                                        <option value="">Select Domain Name </option>
                                        <?php
                                        $select_category = "select * from course_domain_category order by cat_id asc";
                                        $ptr_category = mysql_query($select_category);
                                        while($data_category = mysql_fetch_array($ptr_category))
                                        {
                                            $sel='';
                                            if($data_category['cat_id'] == $row_record['course_domain_id'])
                                            {
                                                $sel='selected="selected"';
                                            }
                                            echo '<option value='.$data_category['cat_id'].' '.$sel.'>'.$data_category['cat_name'].'</option>';
                                        }
                                        ?>        
                                    </select>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="20%">Select Course (pending for enrolled)<span class="orange_font">*</span></td>
                                    <td width="40%" class="customized_select_box">
									<?php
                                        $sel_course_batch_mapping="select * from course_batch_mapping where c_b_id='".$record_id."'";	
                                        $ptr_course_batch_mapping= mysql_query($sel_course_batch_mapping);
                                        $data_course_batch_mapping=mysql_fetch_array($ptr_course_batch_mapping);
                                    ?>
                                        <select name="course_id" id="course_id" class=" input_select" onChange="course_ajax(this.value);" >  
                                            <option value=""> Select Course </option>
                                            <?php
                                            /*if(!$record_id)                                            
                                            	$sel_course="Select distinct(course_id) from enrollment where status = 'Enrolled' ".$_SESSION['where'] ;
                                            else
                                            {*/
                                            $sel_course="SELECT course_id,course_name FROM courses where 1 and (is_parent='n' or is_parent IS NULL) ";
                                            //}
                                            $ptr_course=mysql_query($sel_course);
                                            $t=0;
                                            $total_course_exist = mysql_num_rows($ptr_course);
                                            $disbled='style="display:none; "';
                                            if($total_course_exist)
                                            {
                                                $disbled='';
                                                while($data_course=mysql_fetch_array($ptr_course))
                                                {
                                                    $selected= '';
                                                    if($data_course['course_id']==$row_record['course_id'] || $_POST['course_id']==$data_course['course_id'] )
                                                    {
                                                        $selected= ' selected="selected" ';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $data_course['course_id']?>" <?php echo $selected; ?> ><?php echo $data_course['course_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>    
                                            </select>
                                        </td> 
                                </tr>
                                <tr>
                                    <td><input type="hidden" name="logsheet_id" id="logsheet_id" value="" /><input type="hidden" name="timetable_exist" id="timetable_exist" value="" /></td>
                                    <td colspan="2">
                                        <div id="student_div" ></div>
                                    </td>
                                </tr>
                                <!--<tr>
                                    <td width="22%">Batch Name<span class="orange_font">*</span></td>
                                    <td width="38%" >
                                    <select name="batch_id" id="batch_id" class="validate[required] input_select" >  
                                        <option value=""> Select Batch</option>
                                        <?php
                                            /*$select_category = "select * from batch where 1 ".$_SESSION['where']." order by batch_id asc";
                                            $ptr_category = mysql_query($select_category);
                                            
                                            while($data_category = mysql_fetch_array($ptr_category))
                                            {
                                                if($data_category['batch_id'] == $row_record['batch_id'])
                                                    echo '<option value='.$data_category['batch_id'].' selected="selected">'.$data_category['batch_name'].'</option>';
                                                else
                                                    echo '<option value='.$data_category['batch_id'].'>'.$data_category['batch_name'].'</option>';
                                            }
                                            ?>  
                                             <?php if(!$record_id)
                                          { echo ' <option value="new_batch" ><b>Add New Batch</b></option>  ';}*/
                                          ?> 
                                                
                                    </select>
                                    </td> 
                                    <td width="40%"></td>
                                </tr>-->
                                <!--<tr>
                                    <td colspan="3"> <div id="customise"></div></td> 
                                </tr>-->
                                <tr>
                                    <td width="22%">Select Batch Time</td>
                                    <td width="38%"><select id="batch" name="batch"  class="validate[required] input_select">
                                    <option value="">Select Batch Time</option>
                                    <?php 
                                    $sel_batch="SELECT * FROM batch_time";
                                    $ptr_batch=mysql_query($sel_batch);
                                    while($data_batch=mysql_fetch_array($ptr_batch))
                                    {
                                        if($data_batch['batch_time_id']==$row_record['batch_time_id'])
                                        {
                                            $selected='selected="selected"';
                                        }
                                        else
                                        {
                                            $selected='';
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value ="<?php echo $data_batch['batch_time_id']?>" > <?php echo $data_batch['batch_time'] ?> </option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                    </td>
                                    <td width="40%"></td>
                                </tr>
                                <tr>
                                    <td width="22%">Select Faculty</td>
                                    <td width="38%"><select id="staff" name="staff"  class="validate[required] input_select">
                                    <option value="">Select Faculty Name</option>
                                    <?php 
                                    $sel_batch="SELECT * FROM site_setting where system_status='Enabled' ".$_SESSION['where']."";
                                    $ptr_batch=mysql_query($sel_batch);
                                    while($data_batch=mysql_fetch_array($ptr_batch))
                                    {
                                        $selected='';
                                        if($data_batch['admin_id']==$row_record['staff_id'])
                                        {	
                                           $selected='selected="selected"';
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value = "<?php echo $data_batch['admin_id']?>" <?php if (isset($batch_time) && $batch_time == $data_batch['admin_id']) echo "selected";?> > <?php echo $data_batch['name'] ?> </option>
                                        <?php
                                    }
                                    ?>
                                    </select></td>
                                    <td width="40%"></td>
                                </tr>
                                <tr>
                                    <td height="43">Start Date</td>
                                    <td>
                                    <?php 
                                    if($record_id!='')
                                    {
                                        if($row_record['start_date']!='')
                                        {
                                            $arrage_date= explode('-', $row_record['start_date'],3); 
                                            $new_arrange_date= $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];
                                        }
                                    }
                                    ?>
                                    <input type="text" class="validate[required] input_text datepicker" name="start_date" placeholder="Start Date" id="start_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else  echo $new_arrange_date ?>" />
                                    </td>
                                </tr>
                                <!--<tr>
                                    <td>End Date</td>
                                    <td>
                                    <?php 
                                    /*if($record_id!='')
                                    {
                                        if($row_record['end_date']!='')
                                        {
                                            $arrage_end_date= explode('-', $row_record['end_date'],3); 
                                            $new_arrange_end_date= $arrage_end_date[2].'/'.$arrage_end_date[1].'/'.$arrage_end_date[0];
                                        }	
                                    }*/
                                    ?>
                                    <input type="text" class="validate[required] input_text datepicker" name="end_date" placeholder="End Date" id="end_date" readonly="true" value="<?php //if($_POST['save_changes']) echo $_POST['end_date'];else echo  $new_arrange_end_date; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Start Time<span class="orange_font">*</span></td><? //echo $row_record['course_name'];?>
                                    <td width="38%">
                                   <input type="text" name="start_time" id="start_time" class="validate[required] input_text" placeholder="Start Time" value="<?php //if($_POST['save_changes']) echo $_POST['start_time']; elseif($record_id!='' && $row_record['start_time']!='') echo $row_record['start_time'];?>"  >
                                    </td> 
                                    <td width="40%"></td>
                                </tr>   
                                <tr>
                                    <td width="22%">End Time<span class="orange_font">*</span></td><? //echo $row_record['course_name'];?>
                                    <td width="38%">
                                    <input type="text" name="end_time" class="validate[required] input_text" placeholder="End Time" value="<?php //if($_POST['save_changes']) echo $_POST['end_time']; elseif($record_id!='' && $row_record['end_time']!='') echo $row_record['end_time'];?>"  >
                                    </td> 
                                    <td width="40%"></td>
                                </tr>-->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                    <input type="submit" id="mySubmit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Batch"  <?php echo $disbled; ?> name="save_changes"  />
                                    <?php if($disbled !='') echo "No Student is pending for batch schedule"; ?>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </form>
						<?php
                        if($record_id)
                        {
                            ?>
                            <script language="javascript"> 
                            course_ajax(<?php echo $c_id; ?>);
                            </script>
                            <?php } ?>
                            </td></tr>
                            <?php
                        }?>
					</table>
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
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>