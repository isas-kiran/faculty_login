<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

if(isset($_GET['installment_id']))
	$installment_id = $_GET['installment_id'];

if(isset($_GET['ref_id']))
	$ref_id = $_GET['ref_id'];
else
	$ref_id ='';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Installment Followup Summery</title>
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
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
//             $('input:radio[name=free_course][value=N]').click();
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
</script>
    <style>
	.not-active {
	  pointer-events: none;
	  cursor: default;
	}
	</style>
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
								//$lead_category_followup=$_POST['lead_category_followup'];
								$lead_grade=$_POST['lead_grade'];
								$followup_date1=$_POST['followup_date'];
								$followup_details=$_POST['followup_details'];
								$response=$_POST['response'];
								$installment_id = $_GET['installment_id'];
								$student_id=$record_id;	
								$cm_id= $_POST['cm_id'];
								$admin_id=$_SESSION['admin_id'];
								$payment_date=$_POST['payment_date'];
								$student_name=$_POST['student_name'];
								$course_name=$_POST['course_name'];
								$mobile_no=$_POST['mobile_no'];
								if($followup_date1 !='//' )
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
								if($payment_date !='//' )
								{
									$sep_date = explode('/',$payment_date);
									$payment_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
								}
								else
								{
									if($payment_date <= date('(Y-m-d)') )
									{
										$success=0;
										$errors[$i++]="Invalid Payment Date";
									}
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
									"<br/>".$insert_followup ="INSERT INTO `installment_followup_details` (`student_id`,`installment_id`,`payment_date`,`followup_date`, `lead_grade`,`followup_details`,`response`,`added_date`,`cm_id`,`admin_id`,`status`) VALUES ('".$student_id."','".$installment_id."','".$payment_date."','".$followup_date."','".$lead_grade."','".$followup_details."','".$response."','".date('Y-m-d H:i:s')."','".$cm_id."','".$admin_id."','not_paid')";
									$ptr_followup = mysql_query($insert_followup);
									
									$update_rec="update enrollment set installment_followup_date='".$followup_date."'where enroll_id='".$student_id."'";
									$ptr_update=mysql_query($update_rec);
									
									$update_inst="update installment set installment_date='".$payment_date."'where enroll_id='".$student_id."' and installment_id='".$installment_id."'";
									$ptr_update_ins=mysql_query($update_inst);
									//===================================================SEND SMS===================================================================
									"<br/>".$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$student_name."','".$mobile_no."','".$desc."','student','installment_follwup_message','".$cm_id."','".date('Y-m-d H:i:s')."')";
									$ptr_sms=mysql_query($insert_sms);
									"<br/>".$mesg ="Hi ".$student_name." your have followup for ".$course_name." course on ".$followup_date1." in ISAS beautyschool";
									$messagessss =$mesg;
									send_sms_function($mobile_no,$messagessss);
									
									//==========================================END SEND SMS=======================================================================
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
									setTimeout('document.location.href="installment_followup_details.php?record_id=<?php echo $record_id; ?>&installment_id=<?php echo $installment_id; ?>&ref_id=<?php echo $ref_id; ?>";',800);
									</script>
 
								<?php
								}
                        	}
								$sql_records= "select enroll_id,name,contact,mail,course_id,added_date from enrollment where enroll_id='".$record_id."' order by enroll_id asc";
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
                                    <tr>
                                      <td valign="top" >
                                    <table width="990" height="84" align="center" class="table">
                                    <?
                                    	$select_enroll = "select enroll_id,name,contact,mail,course_id,added_date,cm_id from enrollment where enroll_id='".$record_id."' order by enroll_id asc ";
									  	$ptr_enroll=mysql_query($select_enroll);
										$data_enroll = mysql_fetch_array($ptr_enroll);
										
										$select_course = "select course_id,course_name from courses where course_id='".$data_enroll['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										
										$where_installments_ids='';
										if($installment_id !='')
										{
											$reference_id='';
											if($ref_id!='')
											{
												$reference_id=" or installment_id='".$ref_id."'";
											}
											$where_installments_ids=" and (installment_id='".$installment_id."' ".$reference_id.")";
										}
										
										$select_followup = "select * from installment_followup_details where student_id='".$record_id."' ".$where_installments_ids." order by added_date desc limit 0,1 ";
									  	$ptr_followup=mysql_query($select_followup);
										$data_followup = mysql_fetch_array($ptr_followup);
										
										echo '<input type="hidden" name="cm_id" value="'.$data_enroll['cm_id'].'"/>';
										?>
                                        <tr><th colspan="2">Student Details</th></tr>
                                    	<tr style="padding-left:10px">
                                        	<td width="146"><strong>Student Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_enroll['name'];?> <input type="hidden" name="student_name" value="<?php echo $data_enroll['name'];?>"></td>
                                            <td width="141"><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_course['course_name']; ?><input type="hidden" name="course_id" value="<? echo $data_course['course_id']?>" /><input type="hidden" name="course_name" value="<?php echo $data_course['course_name']?>"></td>
                                        </tr>
                                         <tr>
                                        	<td><strong>Mobile No :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_enroll['contact	']; ?><input type="hidden" name="mobile_no" value="<?php echo $data_enroll['mobile1']?>"></td>
                                            <td><strong>Email ID :&nbsp;&nbsp;&nbsp;</strong><?php echo $data_enroll['mail']; ?></td>
                                        </tr>
										<!-- <tr>
                                        	<td><strong>Lead Category Followup :&nbsp;&nbsp;&nbsp;</strong><? 
											/*if($data_followup['lead_category_followup'] == "walkin_followup")
											{
												echo $lead_cat="Walk-in"; 
											}else
                                            {
												echo $lead_cat="Phone";
											}*/
											?>
											
											</td>
                                            <td><strong>Lead Grade :&nbsp;&nbsp;&nbsp;</strong><? //echo $data_followup['lead_grade']; ?></td>
                                        </tr>-->
                                        <tr>
                                        	<td><strong>Enrolled Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_enroll['added_date']; ?></td>
                                            <td><strong>Followup Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_followup['followup_date']; ?></td>
                                        </tr>
                                    </table>
                                    </td></tr>
                                    <tr><th colspan="2">Followup Details</th></tr>
                                    <tr><td valign="top" >
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
										<!--<tr>
                                            <td width="40%">Lead Category Followup</td>
                                            <td width="40%"><input type="radio" name ="lead_category_followup" id="lead_category_followup" checked="checked" value="<?php //if($_POST['lead_category_followup']) echo $_POST['lead_category_followup']; else echo "phone_followup"; ?>" <?php //if($data_followup['lead_category_followup']=='phone_followup') echo "checked='checked'" ?>/> Phone Followup
											<input type="radio" name ="lead_category_followup" id="lead_category_followup" value="<?php //if($_POST['lead_category_followup']) echo $_POST['lead_category_followup']; else echo "walkin_followup"; ?>" <?php //if($data_followup['lead_category_followup']=='walkin_followup') echo "checked='checked'" ?>/> Walk-in Followup
                            				</td>
                      					</tr>-->
                                        <tr>
                                            <td width="40%">Next Followup Date<span class="orange_font">*</span></td>
                                            <td width="40%"><input type="text" class="input_text datepicker" name="followup_date" id="followup_date" 
                                                        value="<?php if($_POST['followup_date']) echo $_POST['followup_date']; else 
                                                        {
                                                            if($data_followup['followup_date'] !='')
                                                            {
																$arrage_date= explode('-',$data_followup['followup_date']);     
																echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
                                                            }
                                                            // $row_record['staff_dob'];
                                                        }?>" />
                                             </td>
                                    	</tr>
										<tr>
                                            <td width="40%">Expected Payment Date<span class="orange_font">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="orange_font">(Payment date is not less than followup date)</span></td>
                                            <td width="40%"><input type="text" class="input_text datepicker" name="payment_date" id="payment_date" 
													value="<?php if($_POST['payment_date']) echo $_POST['payment_date']; else 
													{
														if($data_followup['payment_date'] !='')
														{
															$arrage_date= explode('-',$data_followup['payment_date']);     
															echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
														}
														// $row_record['staff_dob'];
													}?>" />
                                             </td>
                                    	</tr>
                                        <tr>
                                                <td width="20%">Lead Grade<span class="orange_font">*</span></td>
                                                <td width="40%"><input type="radio" name ="lead_grade" id="lead_grade" checked="checked" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "very_hot"; ?>" <?php if($data_followup['lead_grade']=='very_hot') echo "checked='checked'" ?>/> Very Hot &nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "hot"; ?>" <?php if($data_followup['lead_grade']=='hot') echo "checked='checked'" ?> /> Hot &nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "warm"; ?>" <?php if($data_followup['lead_grade']=='warm') echo "checked='checked'" ?> /> Warm&nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "Nutral"; ?>" <?php if($data_followup['lead_grade']=='Nutral') echo "checked='checked'" ?> /> Neutral&nbsp;
                                                <input type="radio" name ="lead_grade" id="lead_grade" value="<?php if($_POST['lead_grade']) echo $_POST['lead_grade']; else echo "cold"; ?>" <?php if($data_followup['lead_grade']=='cold') echo "checked='checked'" ?> /> Cold
                                                </td>
                                         </tr>
										 <tr>
											<td width="22%">Response Category<span class="orange_font">*</span></td>
											<td width="44%"><select id="response" name="response">
											<option value="">--Select Resonse--</option>
											<option value="Will Pay" <?php if($data_followup['response']=="Will Pay") echo 'selected="selected"'; ?>>Will Pay</option>
											<option value="Call Did Not Pick-Up" <?php if($data_followup['response']=="Call Did Not Pick-Up") echo 'selected="selected"'; ?>>Call Did Not Pick-Up</option>
											<option value="Not Rechable" <?php if($data_followup['response']=="Not Rechable") echo 'selected="selected"'; ?>>Not Rechable</option>
											<option value="Already Paid" <?php if($data_followup['response']=="Already Paid") echo 'selected="selected"'; ?>>Already Paid</option>
											<?php 
											/*$sel_source="SELECT * FROM responce_category";
											$ptr_src=mysql_query($sel_source);
											while($data_src=mysql_fetch_array($ptr_src))
											{
												$sele_source="";
												if($data_src['responce_id'] == $data_followup['response'] || $_POST['response']== $data_src['responce_id'] )
												{
													$sele_source='selected="selected"';
												}
												?>
												<option <?php echo $sele_source?> value ="<?php echo $data_src['responce_id']?>" <?php if (isset($response) && $response == $data_src['responce_id']) echo "selected";?> > <?php echo $data_src['respnce_category_name'] ?> </option>
												<?
											}*/
											?>
											</select></td>
											
										</tr>
                                         <tr>
                                         	<td width="20%">Followup Details</td>
                                            <td width="40%"><textarea name="followup_details"  id="followup_details"><?php echo $data_followup['followup_details']; ?></textarea></td>
                                            
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
                <td class="rightAlign" style="color:red"> Note: The records are display only for next 3 days followups.
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
						  	$pre_from_date=" and installment_followup_date >='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
						}
						else
						{
							$pre_from_date="";                            
						}
						if($_REQUEST['to_date'] && $_REQUEST['to_date']!=="0000-00-00" && $_REQUEST['to_date']!="To Date")
							$pre_to_date=" and installment_followup_date<='".date('Y-m-d',strtotime($_REQUEST['to_date']))."'";
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
						
						"<br/>". $sql_query= "select enroll_id,name,contact,mail,course_id,added_date,installment_followup_date from enrollment where installment_followup_date!='' and installment_followup_date >= '".date('Y-m-d')."' and installment_followup_date <='".date('Y-m-d', strtotime('+3 days'))."' ".$_SESSION['where']." ".$pre_from_date." ".$pre_to_date." ".$pre_lead_grade." order by enroll_id asc"; 

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
    <td width="15%" align="center"><strong>Course Name</strong></td>
    <td width="15%" align="center"><strong>Contact No  </strong></td>
    <td width="15%" align="center"><strong>Followup Date </strong></td>
    <td width="15%" align="center"><strong>Lead Grade</strong></td>
     <td width="15%" align="center"><strong>Followup by </strong></td>
     <td width="10%" align="center"><strong>Added Date</strong></td>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
								$sele_latest_rec="select followup_date,lead_grade,added_date,cm_id,admin_id from installment_followup_details where student_id = '".$val_query['enroll_id']."' and followup_date >= '".date('Y-m-d')."' and followup_date <='".date('Y-m-d', strtotime('+3 days'))."' and status!='paid' order by followup_id desc";
								$ptr_select_letest_rec=mysql_query($sele_latest_rec);
								if(mysql_num_rows($ptr_select_letest_rec))
								{
									$val_select_letest_rec=mysql_fetch_array($ptr_select_letest_rec);	
									
									$select_course_id="select * from courses where course_id='".$val_query['course_id']."' ";
									$ptr_select_course_id=mysql_query($select_course_id);
									$val_select_course=mysql_fetch_array($ptr_select_course_id);
									
									$sel_name="select name from site_setting where admin_id='".$val_select_letest_rec['admin_id']."'";
									$ptr_name=mysql_query($sel_name);
									$data_name=mysql_fetch_array($ptr_name);
									
									if($bgColorCounter%2==0)
										$bgcolor='class="grey_td"';
									else
										$bgcolor="";                
									$listed_record_id=$val_query['enroll_id']; 
									include "include/paging_script.php";
									/*if($val_select_letest_rec['lead_category_followup']=='walkin_followup')
										$lead_cat= "Walk-in Followup";
									else
										$lead_cat= "Phone Followup";
									*/
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
									echo '<tr '.$bgcolor.' >'; 
									echo '<td align="center">'.$sr_no.'</td>';                                
									echo '<td align="center">';
									echo '<a href="installment_followup_details.php?record_id='.$val_query['enroll_id'].'">'.$val_query['name'].'</a>';
									echo'</td>';
									echo '<td align="center">'.$val_select_course['course_name'].'</td>';  
									echo '<td align="center">'.$val_query['contact'].'</td>';
									echo '<td align="center">'.$val_select_letest_rec['followup_date'].'	</td>';
									echo '<td align="center" bgcolor='.$bgcolr.' style="color:'.$color.'">'.$lead_grade.'</td>';
									echo '<td align="center">'.$data_name['name'].'</td>';
									echo '<td align="center">'.$val_select_letest_rec['added_date'].'</td>';
									echo '</tr>';
									$bgColorCounter++;
								}
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
