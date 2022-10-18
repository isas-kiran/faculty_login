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
<title>Manage Attendence</title>
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
    <!--End multiselect -->
     <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
     <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'yy-mm-dd' ,maxDate: new Date()});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			$("#course_batch_id").chosen({allow_single_deselect:true});
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

function course_ajax(course_id) 
{
    var course_id = course_id;
    var data1="course_id="+course_id;
    // alert(data1);
    $.ajax ({
    url: "get_report.php", type: "post", data: data1, cache: false,
    success: function (html)
    {
        document.getElementById('batch_id').innerHTML=html;
        //alert(html);
      $(".multiselect").multiselect();
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
		$course_batch_id=$_POST['course_batch_id'];
		$date=$_REQUEST['date'];
		
		$delete_existing = "Delete from student_attendence where course_batch_id='".$course_batch_id."' and DATE(attendence_date)='".$date."' ";
		$ptr_delete = mysql_query($delete_existing);
		
		$total_student=$_POST['total_student'];
		for($i=1;$i<=$total_student;$i++)
		{
			
			$enroll_id=$_POST['enrollid_'.$course_batch_id.'_'.$i];
			$course_id=$_POST['courseid_'.$course_batch_id.'_'.$i];
			$attendence=$_POST['attendence_'.$course_batch_id.'_'.$i.''];
			
			$uniform=$_POST['uniform_'.$course_batch_id.'_'.$i.''];
			$latemark=$_POST['latemark_'.$course_batch_id.'_'.$i.''];
			$mobile=$_POST['mobile_'.$course_batch_id.'_'.$i.''];
			$sms=$_POST['sms_'.$course_batch_id.'_'.$i.''];
			
			$sel_batch_id="select batch_id,cm_id from course_batch_mapping where c_b_id='".$course_batch_id."'";
			$ptr_batch_id=mysql_query($sel_batch_id);
			$data_batch=mysql_fetch_array($ptr_batch_id);
			
			$insert="INSERT INTO `student_attendence`(`course_batch_id`,`course_id`,`enroll_id`, `batch_id`,`attendence`, `attendence_date`, `uniform`, `latemark`,`mobile_submit`, `sms_send`,`admin_id`,`cm_id`,`added_date`) VALUES ('".$course_batch_id."','".$course_id."','".$enroll_id."','".$data_batch['batch_id']."','".$attendence."','".$date."','".$uniform."','".$latemark."','".$mobile."','".$sms."','".$_SESSION['admin_id']."','".$data_batch['cm_id']."','".date('Y-m-d H:i:s')."')";                          
			$ptr_query=mysql_query($insert);
		}
		$update="update batch_timetable set status='Completed' where c_b_id='".$course_batch_id."' and date='".$date."'";
		$up_query=mysql_query($update);
		?>
        <script>	
			alert("Record Successfully Updated");
		</script>
		<?
	}
	?>    
<form method="get" name="jqueryForm" id="jqueryForm">
    <table align="center" border="0" width="70%"> 
        <!--<tr>
            <td width="20%">Select Course<span class="orange_font">*</span></td>
            <td width="40%" class="customized_select_box">
            <?php
            /*$sel_course_batch_mapping="select * from course_batch_mapping where batch_id='".$record_id."'";	
            $ptr_course_batch_mapping= mysql_query($sel_course_batch_mapping);
            $data_course_batch_mapping=mysql_fetch_array($ptr_course_batch_mapping);*/
            ?>        
            <select name="course_id" id="course_id" class=" input_select" onChange="course_ajax(this.value);" >  
                <option value=""> Select Course </option>
                <?php									
                /*$sel_course="Select * from courses  ";
                $ptr_array=mysql_query($sel_course);
                while($data_course=mysql_fetch_array($ptr_array))
                {
                    $selected= '';
                    if( $_GET['course_id']==$data_course['course_id'] )
                    {
                        $selected= ' selected="selected" ';
                    }?>
                    <option value = "<?php echo $data_course['course_id']?>" <?php echo $selected;  ?> >[<?php echo $data_course[course_name].'' ?>] <?php echo $data_course['course_name'] ?> </option>
                    <?php 							  
                }*/
                ?>
            </select>
            </td> 
        </tr>-->
        <tr>
            <td width="30">Select Batch<span class="orange_font"></span></td>
            <td width="38%" >
            <select name="course_batch_id" id="course_batch_id" class="validate[required] input_select" style="width:400px" >  
            <option value=""> Select Batch</option>
            <?php
            $select_cb = "select * from course_batch_mapping where 1 order by c_b_id desc";
            $ptr_cb = mysql_query($select_cb);
            while($data_cb = mysql_fetch_array($ptr_cb))
            {               
                $sel_staff="select name from site_setting where admin_id='".$data_cb['staff_id']."'";
                $ptr_staff=mysql_query($sel_staff);
                $data_staff=mysql_fetch_array($ptr_staff);
                
				$sel_course="select course_name from courses where course_id='".$data_cb['course_id']."'";
				$ptr_course=mysql_query($sel_course);
				$data_course=mysql_fetch_array($ptr_course);
				
                $sel='';
                if($_REQUEST['course_batch_id']==$data_cb['c_b_id'])
                {
                    $sel='selected="selected"';
                }
                
                echo '<option '.$sel.' value='.$data_cb['c_b_id'].'>'.$data_cb['batch_name'].'&nbsp;&nbsp;('.$data_course['course_name'].')&nbsp;&nbsp;('.$data_staff['name'].')</option>';
            } 
            ?>
            </select>
            </td>
        </tr>
        <tr>
            <td width="30">Select Date<span class="orange_font"></span></td>
            <td width="44%"><input type="text" class="input_text datepicker" name="date" id="dob" 
            value="<?php if($_GET['date'] !='') echo $_GET['date']; else echo date("Y-m-d"); ?>" /></td>
            <td width="34%"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Search" name="search_batch" /></td>
        </tr>
    </table>
</form>
                       
                      	<?php
                       	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
                      	{
                  			$pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
                        }
                        else
						{
							$balance=0;
							$pre_from_date="";                            
						}
					   
						if($_REQUEST['course_batch_id']!='' && $_REQUEST['date']!='')
						{
							$course_batch_id=$_REQUEST['course_batch_id'];
							
							$date=$_REQUEST['date'];
							 "<br/>".$sql_records= "SELECT * FROM student_course_batch_map where c_b_id=".$course_batch_id." ";
							$no_of_records=mysql_num_rows($db->query($sql_records));
							if($no_of_records)
							{
								$bgColorCounter=1;
								if(!$_SESSION['showRecords'])
									$_SESSION['showRecords']=10;
	
								$query_string.="&show_records=".$showRecord;
								$pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
								$all_records= $pager->paginate();?>
								<form method="post" name="frmTakeAction">
                                	<table cellpadding="0" cellspacing="0" width="100%" border="0">
										<tr>
                                        	<td valign="top" >
                                            	<table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
													<tr align="center" class="grey_td" >
														<td width="6%" class="tr-header"><strong>Sr No.</strong></td>
														<td width="17%" class="tr-header"><strong>Student Name</strong></td>
														<td width="17%" class="tr-header"><strong>Course Name</strong></td>
                                                        <!--<td width="12%" class="tr-header"><strong>Faculty Sign</strong></td>-->
														<td width="12%" class="tr-header"><strong>Student Sign</strong></td>
														<td width="8%" class="tr-header"><strong>Not in Uniform</strong></td>
									   				   	<td width="8%"  class="tr-header"><strong>Is LateMark</strong></td>
														<td width="8%"  class="tr-header"><strong>Mobile not Submited</strong></td>
														<td width="12%" class="tr-header"><strong>Send SMS & Mail</strong></td>
													</tr><?php
													$j=1;
													while($val_record=mysql_fetch_array($all_records))
													{
														$enroll_id=$val_record['enroll_id'];
														$listed_record_id = $val_record['s_c_b_id'];
														
														$select_attend="select * from student_attendence where course_batch_id='".$course_batch_id."' and enroll_id='".$val_record['enroll_id']."' and DATE(attendence_date)='".$date."'";
														$ptr_attend=mysql_query($select_attend);
														$data_att=mysql_fetch_array($ptr_attend);
														
														//$course_batch_id=$val_record['course_batch_id'];
																												
														$select_name = " select enroll_id,course_id,name from enrollment where enroll_id='".$val_record['enroll_id']."' ";
														$ptr_name=mysql_query($select_name);
														$data_name = mysql_fetch_array($ptr_name);
											
														$select_topic_name = " select course_name,course_id from courses where course_id='".$data_name['course_id']."' ";
									  	    			$ptr_topic_name=mysql_query($select_topic_name);
										    			$data_topic_name = mysql_fetch_array($ptr_topic_name);
											
														$select_attendence = " select * from `student_attendence` where  enroll_id='".$val_record['enroll_id']."' and c_b_id='".$batch_id."' and repeated='".$_GET['date']."'";	
														$pr_attendence= mysql_query($select_attendence);
														$data_logsheet = mysql_fetch_array($pr_attendence);
														
														
														if($bgColorCounter%2==0)
														$bgcolor='class="grey_td"';
														else
															$bgcolor=""; 
														
											 			//$paid_totas=0;
														/*if($bgColorCounter%2==0)
															$bgclass="tr-sub_white1";
														else
															$bgclass="tr-sub1";*/
														include "include/paging_script.php";
														
														echo '<tr class="'.$bgclass.'">';
														echo '<td align="center">'.$sr_no.'</td>';
														echo '<td align="center">'.$data_name['name'].'<input type="hidden" name="enrollid_'.$course_batch_id.'_'.$j.'" value="'.$enroll_id.'"></td>';
														echo '<td align="center">'.$data_topic_name['course_name'].'<input type="hidden" name="courseid_'.$course_batch_id.'_'.$j.'" value="'.$data_topic_name['course_id'].'"></td>';
														echo '<td align="center">';
														?><input type="radio" checked="checked" class="minimal" name="attendence_<?php echo $course_batch_id.'_'.$j ; ?>" value="present" <?php if($data_att['attendence'] =="present") echo 'checked="checked"'; else echo '';?>> P &nbsp;&nbsp;<input type="radio" class="minimal-red" name="attendence_<?php echo $course_batch_id.'_'.$j ; ?>" value="absent" <?php if($data_att['attendence'] =="absent") echo 'checked="checked"'; else echo ''; ?>> A <br /><?php
                                                        echo '</td>';
                                                        ?>
														<td align="center"><input type="checkbox" <?php if($data_att['uniform'] =="no") echo 'checked="checked"' ;?> id="uniform_" name="uniform_<?php echo $course_batch_id; ?>_<?php echo $j; ?>" value="no" /></td>
                                                        <td align="center"><input type="checkbox" <?php if($data_att['latemark'] =="no") echo 'checked="checked"' ;?> id="latemark_" name="latemark_<?php echo $course_batch_id; ?>_<?php echo $j; ?>" value="no" /></td>
                                                        <td align="center"><input type="checkbox" <?php if($data_att['mobile_submit'] =="no") echo 'checked="checked"' ;?>id="mobile_<?php echo $course_batch_id; ?>_<?php echo $j; ?>" name="mobile_<?php echo $course_batch_id; ?>_<?php echo $j; ?>" value="no" /></td>
															 
											 			<?php
														echo '<td align="center">';
														echo '<select name="sms_'.$course_batch_id.'_'.$j.'">';
														?>
														<option value="">Select Option</option>
                                                        <option value="yes"<?php if($data_att["sms_send"] =="yes") echo 'selected="selected"' ?> >Yes</option>
                                                        <option value="no"<?php if($data_att["sms_send"] =="no") echo 'selected="selected"' ?> >No</option>
														<!--<option value="Uniform" <?php //if($data_logsheet["repeated1"] =="Uniform") echo 'selected="selected"' ?>>Uniform</option>
														<option value="Latemark" <?php //if($data_logsheet["repeated1"] =="Latemark") echo 'selected="selected"' ?>>Latemark</option>
														<option value="Absent" <?php //if($data_logsheet["repeated1"] =="Absent") echo 'selected="selected"' ?>>Absent</option>
														<option value="Mobile" <?php //if($data_logsheet["repeated1"] =="Mobile") echo 'selected="selected"' ?>>Mobile</option>-->
														</select>
														<?php
														echo'</td>';
														echo '</tr>';
											
										   				$bgColorCounter++;
												   		$j++;						
													}
													?>
                                        			<input type="hidden" name="total_student"  id="total_student" value="<?php echo ($j-1); ?>"   />
													<tr style="font-weight:bold; height:30px;">
														<td align="center" colspan="8">
    	                                                    <input type="hidden" name="course_batch_id" id="course_batch_id" value="<?php echo $course_batch_id; ?>" >
															<input type="submit" name="save_changes"  id="save_changes" value="Update & Save"   /> 
														</td>
														<!--<td>
														<?php
										  				//echo "<input type='button' name='print' value='Print' title='Print logsheet' onclick=\"window.open('report_generate1.php?batch_id=".$_REQUEST['batch_id']."&date=".$_REQUEST['date']."&action=print','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' />"
											  			?>
														</td>-->
													</tr>						  			
												</table>
                                            </td>
                                       	</tr>
                                        <tr>
                                        	<td height="10"></td>
                                        </tr>
                                        <tr>
                                        	<td valign="middle" align="right">
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
                                            </td>
                                        </tr>
                                    </table>
        						</form>
								<?php
							}
                        }
                        else
                        	echo'<center><br><div id="alert" style="width:30%">No Record found.</div><br></center>';
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
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.	</noscript>
                <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>