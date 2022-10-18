<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php";
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Followup Summery</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
     <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',minDate: 0,maxDate: "+15D"});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            // $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
		
function date()
{
	var followup_date= document.getElementById('followup_date');
	// alert (followup_date)
	var date = new Date();
	if(followup_date < Date())
	{
		alert("Followup Date should Be Greater than Todays Date");
		document.getElementById('followup_date').style.border = '1px solid #f00';
	}
}
function isFeatureDate(value) 
{
	var now = new Date;
	var target = new Date(value);
	var new_date=value.split("/");
	
	if (new_date[2] > now.getFullYear()) {
		return true;
	} else if (new_date[1] > now.getMonth()) {
		return true;
	} else if (new_date[0]  >= now.getDate()) {
		return true;
	}
	
}
function isNextDate(value) 
{
	var now = new Date;
	
	var tt = value;
    var date = new Date(tt);
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + 15);
    
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();

	if (y > date.getFullYear()) {
		return true;
	} else if (mm > date.getMonth()) {
		return true;
	} else if (dd  >= date.getDate()) {
		return true;
	}
	return false;
}

function validme()
{
	frm = document.frmTakeAction;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
 	
	if(frm.followup_date.value=='')
	{
		disp_error +='Enter followup date  \n';
		document.getElementById('followup_date').style.border = '1px solid #f00';
		frm.followup_date.focus();
		error='yes';
	}
	else
	{	
		if(isFeatureDate(frm.followup_date.value))
		{
		}
		else
		{
			disp_error +='Enter Valid Follow (feature) up Date\n';
			document.getElementById('followup_date').style.border = '1px solid #f00';
			error='yes';
		}
 	}
	if(frm.response.value=='')
	{
		disp_error +='Select Response Category  \n';
		document.getElementById('response').style.border = '1px solid #f00';
		frm.response.focus();
		error='yes';
	}
	else if(frm.response.value=='7')
	{
		if(frm.response_reason.value=='')
		{
			disp_error +='Select Response Reason  \n';
			document.getElementById('response_reason').style.border = '1px solid #f00';
			frm.response_reason.focus();
			error='yes';
		}
	}
	
	if(frm.followup_details.value=='')
	{
		disp_error +='Enter followup description  \n';
		document.getElementById('followup_details').style.border = '1px solid #f00';
		frm.followup_details.focus();
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
		if(confirm("Please Delete Selected Record From inquiry"))
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

function show_responce(vals)
{
	response_id=vals;
	if(response_id=="7")
	{
		document.getElementById('show_reason').style.display="block";
	}
	else
	{
		document.getElementById('show_reason').style.display="none";
	}
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
								$lead_category_followup=$_POST['lead_category_followup'];
								$lead_grade=$_POST['lead_grade'];
								$followup_date1=$_POST['followup_date'];
								$followup_details=mysql_real_escape_string($_POST['followup_details']);
								$response=$_POST['response'];
								$response_reason=$_POST['response_reason'];
								$student_id=$record_id;	
								$cm_id= $_POST['cm_id'];
								$admin_id=$_SESSION['admin_id'];
								$branch_name=trim($_POST['branch_name']);
								$student_name=$_POST['student_name'];
								$course_name=$_POST['course_name'];
								$mobile_no=$_POST['mobile_no'];
								if($followup_date1 !='//' || $followup_date1 !='' )
								{
									$sep_date = explode('/',$followup_date1);
									$followup_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
								}
								else
								{
									if($followup_date1 <= date('(Y-m-d)') )
									{
										$success=0;
										$errors[$i++]="Invalid Followup Date";
									}
									$success=0;
									$errors[$i++]="Enter your Followup Date";
								}	
								if(count($errors))
                                {
									?>
									<table width="90%" align="left" class="alert">
									<tr>
										<td align="left"><strong>Please correct the following errors</strong>
										<div style=" border: 1px solid #F00 ; padding-left:20px; background-color:#FC9">
											<?php
											for($k=0;$k<count($errors);$k++)
												echo '<div style="text-align:left;padding:5px;">'.$errors[$k].'</div>';?>
										  </div></td>
									  </tr>
									</table>
									<br clear="all">
									<?php
                                }
                                else
                                {
									$success=1;
									$insert_followup = "INSERT INTO `followup_details` (`student_id`,`lead_category_followup`,`followup_date`,`lead_grade`,`followup_details`,`response`,`response_reason`, `added_date`,`cm_id`,`admin_id`) VALUES ('".$student_id."','".$lead_category_followup."', '".$followup_date."', '".$lead_grade."','".$followup_details."','".$response."','".$response_reason."','".date('Y-m-d H:i:s')."','".$cm_id."','".$admin_id."')";
									$ptr_followup = mysql_query($insert_followup);
									
									$update_rec="update inquiry set followup_date='".$followup_date."',lead_grade='".$lead_grade."',response='".$response."', lead_category_followup='".$lead_category_followup."',response_reason='".$response_reason."',followup_details='".$followup_details."' where inquiry_id='".$student_id."'";
									$ptr_update=mysql_query($update_rec);
									
									//=============================================SEND SMS============================================
									
									/* $insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`admin_id`,`cm_id`,`added_date`) values('".$firstname."','".$mobile1."','".$messagessss."','inquiry','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
									$ptr_sms=mysql_query($insert_sms);
									
									//"<br/>".$mesg ="Hi ".$student_name." your have followup for ".$course_name." course on ".$followup_date1." in ISAS beautyschool";
									$messagessss =$mesg; */
									//----------------------------------SMS Send------------------------------------------------
								if($response!='7' && $response!='8')
								{
									$sel_resp="select * from responce_category where responce_id='".$response."'";
									$ptr_query=mysql_query($sel_resp);
									$resp='';
									if(mysql_num_rows($ptr_query))
									{
										$data_resp=mysql_fetch_array($ptr_query);
										if($response==$data_resp['responce_id'])
										{
											$txt_msg =$data_resp['sms_text']." ";
										}
									}
									
									$messagessss=$txt_msg;
									$address='';
									if($branch_name=="Pune")
									{
										$address="ISAS Beauty School, B-wing, Kensinngton Cort, Lane no. 5, North Main Road, Koregoan Park, Pune-411001. Location:  https://bit.ly/2yOhji6 ";//,Events - https://bit.ly/2O2uDTU ,Student artwork - https://bit.ly/2La2VXz ,Institute Photos: https://bit.ly/2O2qO0Q";
									}
									else if($branch_name=="Ahmedabad")
									{
										$address="ISAS Beauty School, 1st Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007. Location: https://bit.ly/2N28vbw ";//,Events: https://bit.ly/2O2uDTU ,Student artwork: https://bit.ly/2La2VXz ,Institute photos: https://bit.ly/2uzwfMx";
									}
									else if($branch_name=="ISAS PCMC")
									{
										$address="Hari A1,Next to ABS Gym, Pimple Nilakh, Pune 411027. Location: https://bit.ly/2Ke26fQ ";//,Events - https://bit.ly/2O2uDTU ,Student artwork: https://bit.ly/2La2VXz ,Institute photos: https://bit.ly/2LrF6JM";
									}
									else if($branch_name=="Baramati")
									{
										//$address="International School of Aesthetics and Spa, Baramati, Email :learn@isasbeautyschool.com";
									}
									$sel_cnt="select contact_phone from site_setting where type='C' and other_type='inquiry' and branch_name='".$branch_name."' ";
									$ptr_cnt=mysql_query($sel_cnt);
									if(mysql_num_rows($ptr_cnt))
									{
										$data_cnt=mysql_fetch_array($ptr_cnt);
										$staff_contact=$data_cnt['contact_phone'];
									}
									else
									{
										$staff_contact="9158985007";
									}
									$search_by= array("student_name", "course_name", "branch_name", "mobile_no","address");
									$replace_by = array($student_name, $course_name, $branch_name, $staff_contact,$address);
									$messagessss = str_replace($search_by, $replace_by, $messagessss);
									
									"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='38' ".$_SESSION['where']."";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']." ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											//send_sms_function($data_cnt['contact_phone'],$messagessss);
										}
									}
									if($_SESSION['type']!='S')
									{
										"<br/>".$sel_act="select contact_phone from site_setting where type='S' ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											while($data_cnt=mysql_fetch_array($ptr_cnt))
											{
												//send_sms_function($data_cnt['contact_phone'],$messagessss);
											}
										}
									}
									
									send_sms_function($mobile_no,$messagessss);
									
									$insert_sms="insert into sms_log_history (`name`,`mobile_no`,`sms_text`,`sms_type`,`admin_id`,`cm_id`,`added_date`) values('".$student_name."','".$mobile_no."','".$messagessss."','inquiry_followup','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
									$ptr_sms=mysql_query($insert_sms);
								}
									//==========================================END SEND SMS===============================================
									?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Followup Update successfully</p></center></div>
									<script type="text/javascript">
									$(document).ready(function() {
										$( "#statusChangesDiv" ).dialog({
												modal: true,
												buttons: {
															Ok: function() { $( this ).dialog( "close" );}
														 }
										});
										
									});
									//setTimeout('document.location.href="followup_details.php?record_id=<?php echo $record_id; ?>";',700);
									</script>
 
								<?php
								}
                        	}
                                
                         	
								"<br/>".$sql_records= "select inquiry_id,firstname,middlename,lastname,mobile1,email_id,course_id,enquiry_date, followup_date,lead_category_followup , lead_grade from inquiry where inquiry_id='".$record_id."' ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status." order by inquiry_id desc";
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                           
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();
                                    
                                if($success==0)
                    			{
								?>
                                    <form method="post" name="frmTakeAction" onSubmit="return validme()">
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
                                                 
                                                    <td height="2" align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10" align="right">
                                    <a href="followup_details.php?record_id=<?php echo $record_id; ?>"><input type="button" name="back" value="Back"  /></a>
                                    </td>
                                    </tr>
                                    <!--====================================Followups Details=================================-->
                                    <tr>
                                    	<td valign="top" >
                                    	<table width="97%" height="84" align="center" class="table">
                                    	<?php
                                    	$select_enroll = " select inquiry_id,firstname,middlename,lastname,mobile1,email_id,course_id,enquiry_date, followup_date, lead_category_followup , lead_grade,cm_id from inquiry where inquiry_id='".$record_id."' ";
									  	$ptr_enroll=mysql_query($select_enroll);
										$data_enroll = mysql_fetch_array($ptr_enroll);
										
										$select_course = " select course_id,course_name from courses where course_id='".$data_enroll['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										
										$select_followup = " select * from followup_details where student_id='".$record_id."' order by added_date desc limit 0,1 ";
									  	$ptr_followup=mysql_query($select_followup);
										$data_followup = mysql_fetch_array($ptr_followup);
										
										$sel_branch="select branch_name from site_setting where cm_id='".$data_enroll['cm_id']."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										$data_branch=mysql_fetch_array($ptr_branch);
										echo '<input type="hidden" name="cm_id" value="'.$data_enroll['cm_id'].'"/><input type="hidden" name="branch_name" value="'.$data_branch['branch_name'].'"/>';
										?>
                                        <tr><th colspan="2" style="font-size:14px; font-weight:800">Student Details</th></tr>
                                    	<tr style="padding-left:10px">
                                        	<td width="50%"><strong>Student Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_enroll['firstname'].' '.$data_enroll['middlename'].' '.$data_enroll['lastname']; ?> <input type="hidden" name="student_name" value="<?php echo $data_enroll['firstname'];?>"></td>
                                            <td width="50%"><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_course['course_name']; ?><input type="hidden" name="course_id" value="<? echo $data_course['course_id']?>" /><input type="hidden" name="course_name" value="<?php echo $data_course['course_name']?>"></td>
                                        </tr>
                                         <tr>
                                        	<td width="50%"><strong>Mobile No :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_enroll['mobile1']; ?><input type="hidden" name="mobile_no" value="<?php echo $data_enroll['mobile1']?>"></td>
                                            <td width="50%"><strong>Email ID :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_enroll['email_id']; ?></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%"><strong>Lead Category Followup :&nbsp;&nbsp;&nbsp;</strong><? 
											if($data_enroll['lead_category_followup'] == "walkin_followup")
											{
												echo $lead_cat="Walk-in"; 
											}else
                                            {
												echo $lead_cat="Phone";
											}
											?>
											
											</td>
                                            <td width="50%"><strong>Lead Grade :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['lead_grade']; ?></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%"><strong>Enquiry Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['enquiry_date']; ?></td>
                                            <td width="50%"><strong>Followup Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['followup_date']; ?></td>
                                        </tr>
                                    </table>
                                    </td></tr>
                                    <!--=====================================Last Followupps Details==========================-->
                                    <tr>
                                      <td valign="top" >
                                    <table width="97%" height="84" align="center" class="table">
                                        <tr><th colspan="2" style="font-size:14px; font-weight:800">Last 3 Followups Details</th></tr>
                                        <?php
										$select_last_followup = " select * from followup_details where student_id='".$record_id."' order by added_date desc limit 0,3 ";
									  	$ptr_last_followup=mysql_query($select_last_followup);
										$i=1;
										while($data_last_followup = mysql_fetch_array($ptr_last_followup))
										{
											?>
                                            <tr>
                                            	<td colspan="2" style="font-size:12px; font-weight:800">Followup Details <?php echo $i; ?></td>
                                            </tr>
                                    		<tr style="padding-left:10px">
                                        		<td width="50%"><strong>Lead Category Followup :&nbsp;&nbsp;&nbsp;</strong><?php if($data_last_followup['lead_category_followup']=='phone_followup') echo "Phone Followup"; else if($data_last_followup['lead_category_followup']=='walkin_followup') echo "Walkin Followup"; ?></td>
                                            	<td width="50%"><strong>Followup Date :&nbsp;&nbsp;&nbsp;</strong><?php if($data_last_followup['followup_date'] !='')
												{
													$arrage_date= explode('-',$data_last_followup['followup_date']);     
													echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
												}?>
                                                </td>
                                        	</tr>
                                         	<tr>
                                        		<td width="50%"><strong>Lead Grade :&nbsp;&nbsp;&nbsp;</strong><?php if($data_last_followup['lead_grade']=='very_hot') echo "Very Hot"; else if($data_last_followup['lead_grade']=='hot') echo "Hot"; else if($data_last_followup['lead_grade']=='warm') echo "Warm"; else if($data_last_followup['lead_grade']=='Nutral') echo "Nutral"; else if($data_last_followup['lead_grade']=='cold') echo "Cold"; ?></td>
                                            	<td width="50%"><strong>Response category :&nbsp;&nbsp;&nbsp;</strong>
												<?php $sel_source="SELECT * FROM responce_category where responce_id='".$data_last_followup['response']."'";
												$ptr_src=mysql_query($sel_source);
												$data_src=mysql_fetch_array($ptr_src);
												echo $data_src['respnce_category_name'];
												?>
                                                </td>
                                        	</tr>
                                        	<tr>
                                        		<td width="100%" colspan="2"><strong>Followup Details :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_last_followup['followup_details']; ?>
												</td>
                                        	</tr>
                                         	<?php
											$i++;
                                         } ?>
                                    </table>
                                    </td></tr>
                                    <!--======================================================================================-->
                                    <tr><th colspan="2" style="font-size:14px; font-weight:800">Update Followup Details</th></tr>
                                    <tr><td valign="top" >
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
										
                                        <tr>
                                                <td width="40%">Lead Grade<span class="orange_font">*</span></td>
                                                <td width="60%"><input type="radio" name ="lead_grade" id="lead_grade" checked="checked" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "very_hot"; ?>" <?php //if($data_followup['lead_grade']=='very_hot') echo "checked='checked'" ?>/> Very Hot &nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "hot"; ?>" <?php //if($data_followup['lead_grade']=='hot') echo "checked='checked'" ?> /> Hot &nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "warm"; ?>" <?php //if($data_followup['lead_grade']=='warm') echo "checked='checked'" ?> /> Warm&nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "Nutral"; ?>" <?php //if($data_followup['lead_grade']=='Nutral') echo "checked='checked'" ?> /> Neutral&nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "cold"; ?>" <?php //if($data_followup['lead_grade']=='cold') echo "checked='checked'" ?> /> Cold
                                                </td>
                                        </tr>
										<tr>
											<td width="40%">Response Category<span class="orange_font">*</span></td>
											<td width="60%">
                                            <div style="width:27%;">
                                            <select id="response" name="response" class="input_select" style="width:150px" onchange="show_responce(this.value)">
											<option value="">--Select Resonse--</option>
											<?php 
											$sel_source="SELECT * FROM responce_category";
											$ptr_src=mysql_query($sel_source);
											while($data_src=mysql_fetch_array($ptr_src))
											{
												$sele_source="";//$data_src['responce_id'] == $data_followup['response'] ||
												if( $_POST['response']== $data_src['responce_id'] )
												{
													$sele_source='selected="selected"';
												}
												?>
												<option <?php echo $sele_source?> value ="<?php echo $data_src['responce_id']?>" <?php if (isset($response) && $response == $data_src['responce_id']) echo "selected";?> > <?php echo $data_src['respnce_category_name'] ?> </option>
												<?php
											}
											?>
											</select>
                                            </div>
                                            <div id="show_reason" style="display:none; width:60%">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Reason for not intrested &nbsp;&nbsp;:&nbsp;&nbsp;
                                            <select id="response_reason" name="response_reason" class="input_select" style="width:150px" >
                                                <option value="">--Select Reason--</option>
                                                <option value="1">Long Distance</option>
                                                <option value="2">High Fees</option>
                                                <option value="3">Joined Somewhere</option>
                                                <option value="4">Parents not allowed</option>
                                                <option value="5">Problem with Institute</option>
                                                <option value="6">Time Not match</option>
                                            </select>
                                            </div>
                                            </td>
											
										</tr>
                                        
                                        <tr>
                                         	<td width="40%">Followup Details<span class="orange_font">*</span></td>
                                            <td width="58%"><textarea name="followup_details" style="width:100%; height:70px"  id="followup_details"><?php //echo $data_followup['followup_details']; ?></textarea></td>
                                        </tr>
										<tr>
                                        	<td colspan="2" style="background-color:#EAEAEA; height:5px"></td>
                                        </tr>
                                        <tr>
                                            <td width="40%">Next Lead Category Followup<span class="orange_font">*</span></td>
                                            <td width="40%"><input type="radio" name ="lead_category_followup" id="lead_category_followup" checked="checked" value="<?php if($_POST['lead_category_followup']) echo $_POST['lead_category_followup']; else echo "phone_followup"; ?>" <?php if($data_followup['lead_category_followup']=='phone_followup') echo "checked='checked'" ?>/> Phone Followup
											<input type="radio" name ="lead_category_followup" id="lead_category_followup" value="<?php if($_POST['lead_category_followup']) echo $_POST['lead_category_followup']; else echo "walkin_followup"; ?>" <?php if($data_followup['lead_category_followup']=='walkin_followup') echo "checked='checked'" ?>/> Walk-in Followup
                            				</td>
                      					</tr>
                                        <tr>
                                            <td width="40%">Next Followup Date<span class="orange_font">*</span></td>
                                            <td width="40%"><input type="text" class="input_text datepicker" name="followup_date" id="followup_date" 
                                            value="<?php if($_POST['followup_date']) echo $_POST['followup_date']; else 
                                            {
                                                /*if($data_followup['followup_date'] !='')
                                                {
                                                    $arrage_date= explode('-',$data_followup['followup_date']);     
                                                    echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
                                                }*/
                                                // $row_record['staff_dob'];
                                            }?>" />
                                            </td>
                                    	</tr>
                                         <tr><td colspan="2" align="center"><input type="submit" name="save_changes" value="Update"  /></td></tr>
                                        </table>
                                    </td></tr>
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
                                                    <td align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    </table>
                                    </form><?php
									
									}
                                }
								
                                else
								{
									?>
  <!-- ================================================Start Table=============================================================================================-->
<?php if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT batch_id FROM ".$GLOBALS["pre_db"]."batch where batch_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {                                                
                                        $delete_query="delete from ".$GLOBALS["pre_db"]."batch where batch_id='".$del_record_id."'";
                                        $db->query($delete_query);                                                                                        
                                    }
                             }
                             ?>
                                    <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                                    <script type="text/javascript">
                                    // $("#statusChangesDiv").dialog();
                                        $(document).ready(function() {
                                            $( "#statusChangesDiv" ).dialog({
                                                    modal: true,
                                                    buttons: {
                                                                Ok: function() { $( this ).dialog( "close" );}
                                                             }
                                            });
                                        });
                                    </script>
                            <?php                            
                                }                       
                     }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT batch_id FROM ".$GLOBALS["pre_db"]."batch where batch_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        $delete_query="delete from ".$GLOBALS["pre_db"]."batch where batch_id='".$del_record_id."'";
                        $db->query($delete_query);
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                            // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    });
                                });
                            </script>
                            <?php
                        }
                    }
                    ?>
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="11">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
               <!-- <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
                       	<td width="15%">
                      
                         <select name="lead_grade" id="lead_grade" class="input_select_login" >
                                <option value="">- Lead Gtrade -</option>
                                <option value="very_hot"<?php if($_REQUEST['lead_grade']=="very_hot") echo "selected";  ?>>Very Hot</option>
                                <option value="hot"<?php if($_REQUEST['lead_grade']=="hot") echo "selected"; ?> >Hot</option>
                                <option value="warm"<?php if($_REQUEST['lead_grade']=="warm") echo "selected"; ?>>Warm</option>
                                <option value="nutral"<?php if($_REQUEST['lead_grade']=="nutral") echo "selected";  ?>>Neutral</option>
                                <option value="cold"<?php if($_REQUEST['lead_grade']=="cold") echo "selected"; ?>>Cold</option>
                        </select></td>
                         <td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                         <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                         
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td class="rightAlign" style="color:red"> Note: The records are display only for next two days followups.
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              
              <td class="width5" style="color:red"></td>
              
                <!--<td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>-->
              </tr>
                    </table>	
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
    
    
    <?php
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
							 $frm_date=explode("/",$_REQUEST['from_date']);
							 $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							 
						  	$pre_from_date=" and followup_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						 }
						else
						{
							$pre_from_date="";                            
						}
						if($_REQUEST['to_date'] && $_REQUEST['to_date']!=="0000-00-00" && $_REQUEST['to_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							 
							$pre_to_date=" and followup_date<='".date('Y-m-d',strtotime($to_dates))."'";						
						}
						else
							$pre_to_date="";
						
                        if($_REQUEST['lead_grade'] && $_REQUEST['lead_grade']!="lead_grade" && $_REQUEST['lead_grade']!="")
                            $lead_grade=trim($_REQUEST['lead_grade']);
                        if($lead_grade)
                            {                            
                                $pre_lead_grade =" and lead_grade like '%".$lead_grade."%' ";
                            }                            
                        else
                            $pre_lead_grade="";
                        

                        if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
                        
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;

                        if($_GET['order']=='asc')
                        {
                            $order='desc';
                            $img = "<img src='images/sort_up.png' border='0'>";
                        }
                        else if($_GET['order']=='desc')
                        {
                            $order='asc';
                            $img = "<img src='images/sort_down.png' border='0'>";
                        }
                        else
                            $order='desc';

                        if($_GET['orderby']=='name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							
							$branch_id='';
							
							if($_POST['from_date']=='' && $_POST['to_date']=='')
							{
								$default="and followup_date >= '".date('Y-m-d')."' and followup_date <='".date('Y-m-d', strtotime('+2 days'))."' ";
							}
						
                        $select_directory='order by inquiry_id desc';                      
                        $sql_query= "select inquiry_id,firstname,middlename,lastname, course_id, mobile1, followup_date,cm_id from inquiry where status = 'Enquiry' ".$default." ".$_SESSION['where']." ".$pre_from_date." ".$pre_to_date." ".$pre_lead_grade." ".$select_directory.""; 
						//echo $sql_query;
					   	$db=mysql_query($sql_query);
                        $no_of_records=mysql_num_rows($db);
						
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
							// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
    <!--<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
    <td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="20%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Name</strong></a> <?php echo $img1;?></td>
	<?php 
	if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		?>
		<td width="10%" align="center"><strong>Branch Name</strong></td>
		<?php
	}
	?>
    <td width="15%" align="center"><strong>Course Name</strong></td>
    <td width="15%" align="center"><strong>Contact No  </strong></td>
    <td width="15%" align="center"><strong>Followup Date </strong></td>
    <td width="15%" align="center"><strong>Lead Category </strong></td>
    <td width="15%" align="center"><strong>Lead Grade</strong></td>
     <td width="15%" align="center"><strong>Followup by </strong></td>
     <td width="10%" align="center"><strong>Added Date</strong></td>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
								
								$sele_latest_rec="select followup_date,lead_category_followup, lead_grade,added_date,cm_id,admin_id from followup_details where student_id = '".$val_query['inquiry_id']."' and  followup_date >= '".date('Y-m-d')."' and followup_date <='".date('Y-m-d', strtotime('+2 days'))."' order by followup_id desc";
								$ptr_select_letest_rec=mysql_query($sele_latest_rec);
								$val_select_letest_rec=mysql_fetch_array($ptr_select_letest_rec);	
								
								$select_course_id="select * from  courses where course_id='".$val_query['course_id']."' ";
								$ptr_select_course_id=mysql_query($select_course_id);
								$val_select_course=mysql_fetch_array($ptr_select_course_id);
								
								$sel_name="select name from site_setting where admin_id='".$val_select_letest_rec['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_name=mysql_fetch_array($ptr_name);
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['student_id']; 
//                                $select_country = "select country_name from PB_country where country_id = '".$val_query['country_id']."' ";
//                                $val_contry = $db->fetch_array($db->query($select_country));
                                include "include/paging_script.php";
                                if($val_select_letest_rec['lead_category_followup']=='walkin_followup')
								$lead_cat= "Walk-in Followup";
								else
								$lead_cat= "Phone Followup";
								
								if($val_select_letest_rec['lead_grade']=="very_hot")
								{
									$lead_grade="Very Hot";
									$bgcolr="#810100";
									$color="#fff";
								}
								else if($val_select_letest_rec['lead_grade']=="hot")
								{
									$lead_grade="Hot";
									$bgcolr="#C41206";
									$color="#fff";
								}
								else if($val_select_letest_rec['lead_grade']=="warm")
								{
									$lead_grade="Warm";
									$bgcolr="#F58F09";
									$color="#000";
								}
								else if($val_select_letest_rec['lead_grade']=="Nutral")
								{
									$lead_grade="Neutral";
									$bgcolr="#F4F805";
									$color="#000";
								}
								else if($val_select_letest_rec['lead_grade']=="cold")
								{
									$lead_grade="Cold";
									 $bgcolr="#377A07";
									 $color="#000";
								}
								$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								
								
                                echo '<tr '.$bgcolor.' >
                                     '; // <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>
                                echo '<td align="center">'.$sr_no.'</td>';                                
                                echo '<td align="center"><a href="followup_details.php?record_id='.$val_query['inquiry_id'].'">'.$val_query['firstname'].' ' .$val_query['lastname'].'</a></td>';
								
								if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								{	
									echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								}
								
								echo '<td align="center">'.$val_select_course['course_name'].'</td>';  
                                echo '<td align="center">'.$val_query['mobile1'].'</td>';
                                echo '<td align="center">'.$val_query['followup_date'].'	</td>';
								echo '<td align="center">'.$lead_cat.'</td>';
								echo '<td align="center" bgcolor='.$bgcolr.' style="color:'.$color.'">'.$lead_grade.'</td>';
								echo '<td align="center">'.$data_name['name'].'</td>';
								echo '<td align="center">'.$val_select_letest_rec['added_date'].'</td>';
								
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }  
							  
                                ?>
  
  
  <tr class="head_td">
    <td colspan="11">
       <table cellspacing="0" cellpadding="0" width="100%" >
            <tr>
                <?php
                      if($no_of_records>10)
                            {
                                echo '<td width="3%" align="left">Show</td>
                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                $show_records=array(0=>'10',1=>'20','50','100');
                                for($s=0;$s<count($show_records);$s++)
                                {
                                    if($_SESSION['show_records']==$show_records[$s])
                                        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                    else
                                        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                }
                                echo'</td></select>';
                            }
                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';
                         
                 ?>
                                    
            </tr>
        </table>
 
    
                                    
                                       
                               
    </td>
    </tr></form>
      <?php } 
	  
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Student found related to your search criteria, please try again</div><br></td></tr>';?>
</table>
<?

	//==========================================================END Table========================================================================================================
								}
								
								
                                    //echo'<center><br><div id="alert" style="width:30%">No Record history here</div><br></center>';
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
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
