<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$sel_log="select * from batch_timetable where c_b_id='".$record_id."'";
$ptr_log=mysql_query($sel_log);
$row_record=mysql_fetch_array($ptr_log);
$course_id=$row_record['course_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Batch Date</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
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
    </script>
    <script type="text/javascript">
	var pageName='add_timetable';
	jQuery(document).ready( function() 
	{
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		// binds form submission and fields to the validation engine
		$("#topic_id").chosen({allow_single_deselect:true});
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});

function delete_records(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#day'+id).replaceWith(function(){
			return $('<input type="text"  name="day'+id+'" id="day'+id+'"  style="width:40px" />', {html: $(this).html()});
		});
		$('#topic'+id).replaceWith(function(){
			return $('<input type="text" name="topic'+id+'" id="topic'+id+'" value="" style="width:200px" />', {html: $(this).html()});
		});
		$('#topic_content'+id).replaceWith(function(){
			return $('<input type="text" name="topic_content'+id+'" id="topic_content'+id+'" value="" />', {html: $(this).html()});
		});
		if(types=='floor')
		{  
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
			showUser();
		}
	}
}        
</script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
<style>
.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}
.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}
.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}
.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}
.inactive{ background-color:#FFF;cursor:pointer; color:#000}
.active{ background-color:#699;cursor:pointer; color:#FFF}
.hidden{ display:none; width:0px; height:0px;}	
.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }
.pointer{ cursor:pointer;}
</style>
<script>
function select_topic_content(topic_id)
{
	var data1="action=gettopic_content&topic_id="+topic_id+"&logsheet_id=<?php echo $row_record['logsheet_id']; ?>";
	//alert(data1);
	$.ajax({
		url: "get_topic_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			document.getElementById("topic_content").value=html;
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
    <td class="top_right"></td>
    <?php 
	if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
	{
		$del_record_id=$_REQUEST['record_id'];
		$c_b_id=$_REQUEST['c_b_id'];
		
		$sql_query= "SELECT batch_holiday_id FROM batch_holiday where batch_holiday_id='".$del_record_id."' and c_b_id='".$c_b_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{                           
			$delete_query="delete from batch_holiday where batch_holiday_id='".$del_record_id."' and c_b_id='".$c_b_id."'";
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
  	</tr>
  	<tr>
    	<td class="mid_left"></td>
    	<td class="mid_mid">             
			<form method="post" name="frmTakeAction">
                <?php
				if($_POST['save_changes'])
				{
					$hollidates=$_POST['date'];
					$data_split=explode("/",$hollidates);
					$hollidate=$data_split[2].'-'.$data_split[1].'-'.$data_split[0];
					
					$c_b_ids=$_POST['c_b_id'];
					$course_ids=$_POST['course_id'];
					$holiday_reason=$_POST['holiday_reason'];
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
						
						if($record_id)
						{
							$select_holidays="select holiday_date from holiday_mapping where 1 and cm_id='".$cm_id."'";
							$ptr_hol=mysql_query($select_holidays);
							while($day_holi=mysql_fetch_array($ptr_hol))
							{
								$skipdates[]=$day_holi['holiday_date'];
							}
							
							$select_batch_holiday="select holiday_date from batch_holiday where 1 and c_b_id='".$record_id."'";
							$ptr_batch_holiday=mysql_query($select_batch_holiday);
							while($batch_holiday=mysql_fetch_array($ptr_batch_holiday))
							{
								$skipbatchholiday[]=$batch_holiday['holiday_date'];
							}
							
							
							$sel_data="select * from batch_timetable where c_b_id='".$record_id."' and course_id='".$course_id."' and date >='".$hollidate."' group by day order by day asc";
							$ptr_timet_data=mysql_query($sel_data);
							$total_days=mysql_num_rows($ptr_timet_data);
							
							$holiStartDate=$hollidate;
							$holiTimestamp=strtotime($holiStartDate);
							
							$startDate=$hollidate;
							$timestamp=strtotime($startDate);
							$days=$total_days;
							while($data_times=mysql_fetch_array($ptr_timet_data))
							{
								$day=$data_times['day'];
								$c_b_id=$record_id;
								
								$data_record_timetable['c_b_id']=$c_b_id;
								//$data_record_timetable['logsheet_map_id']=$data_times['logsheet_map_id'];
								//$data_record_timetable['logsheet_id']=$data_times['logsheet_id'];
								//$data_record_timetable['course_id']=$data_times['course_id'];
								/*$data_record_timetable['day']=$data_times['day'];*/ //Last changes
								//$data_record_timetable['staff_id']=$staff;
								/*$data_record_timetable['topic_id']=$data_times['topic_id']; //Last changes
								$data_record_timetable['topic_content']=$data_times['topic_content'];
								$data_record_timetable['model_required']=$data_times['model_required'];
								$data_record_timetable['admin_id']=$_SESSION['admin_id'];*/
								//$data_record_timetable['cm_id']=$cm_id;
								//$data_record_timetable['added_date']=date('Y-m-d H:i:s');
								//echo "<br/>".$days."--".$timestamp."--".$startDate;
								//echo"<br/>".date("l", $timestamp);
								//$skipdates=array("2019-07-03","2019-07-05","2019-07-08","2019-07-15","2019-07-18",);
								//echo "<br/>Timestamp".date("Y-m-d", $timestamp);
								$sel_cb="select batch_type from course_batch_mapping where c_b_id='".$record_id."'";
								$ptr_cb=mysql_query($sel_cb);
								$data_cb=mysql_fetch_array($ptr_cb);
								
								if($data_cb['batch_type']=='weekdays')
								{
									$skipdays = array("Sunday");
								}
								else
								{
									$skipdays = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday");
								}
								
								$skipholidays = array(date("Y-m-d", $holiTimestamp));
								
								$i = 1;
								$dates=array();
								
								//echo "<br/>dates-".date("Y-m-d", $holiTimestamp).'--'.date("Y-m-d", $timestamp);
								//$timestamp = strtotime("+ 0 day", $timestamp);
								//echo "<br/>-->".date("l", $timestamp)."--".$timestamp;
								$totals=1;
								for($i=1;$i<=$totals;$i++)
								{
									if((in_array(date("l", $timestamp), $skipdays)) || in_array(date("Y-m-d", $timestamp),$skipholidays) || in_array(date("Y-m-d", $timestamp),$skipbatchholiday) || (in_array(date("Y-m-d", $timestamp), $skipdates)) )
									{	
										
										$timestamp=strtotime("+ 1 day", $timestamp);
										
										//$dates[$i]=date("d/m/Y",strtotime("+ 1 day", $timestamp));
										//$timestamp = strtotime("+ 1 day", $timestamp);
										$totals++;
									}
									else
									{
										$data_record_timetable['date']=date("Y-m-d", $timestamp);
										//echo "<br/>".date("Y-m-d", $timestamp);
										//$courses_batch_id=$db->query_insert("batch_timetable", $data_record_timetable); 
										
										$where_record=" day='".$data_times['day']."' and c_b_id='".$c_b_id."'";
										$db->query_update("batch_timetable", $data_record_timetable,$where_record);
							
										if($i==$totals)
										{
											$data_record_c_b_d['end_date']=date("Y-m-d", $timestamp);
											$where_record_c_b="c_b_id='".$c_b_id."'";
											$db->query_update("course_batch_mapping", $data_record_c_b_d,$where_record_c_b);
										}
										$timestamp=strtotime("+ 1 day", $timestamp);
									}
								}
								/*if ( (in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates)))
								{	
									$timestamp=strtotime("+ 1 day", $timestamp);
									
									//$dates[$i]=date("d/m/Y",strtotime("+ 1 day", $timestamp));
									//$timestamp = strtotime("+ 1 day", $timestamp);
								}
								else
								{
									$data_record_timetable['date']=date("Y-m-d", $timestamp);
									//echo "<br/>".date("Y-m-d", $timestamp);
									$courses_batch_id=$db->query_insert("batch_timetable", $data_record_timetable); 
									$timestamp=strtotime("+ 1 day", $timestamp);
								}*/
								//$timestamp=strtotime("+ 1 day", $timestamp);										
							}
							
							
							$insert_rec="insert into batch_holiday(`c_b_id`,`course_id`,`holiday_date`,`holiday_reason`,`admin_id`,`cm_id`,`added_date`) values ('".$c_b_ids."','".$course_ids."','".$hollidate."','".$holiday_reason."','".$_SESSION['admin_id']."','".$_SESSION['cm_id']."','".date('Y-m-d')."')";
							$ptr_insert=mysql_query($insert_rec);
							//$where_record="batch_timetable_map_id='".$record_id."'";
							//$db->query_update("batch_timetable", $data_record,$where_record);
							   
							echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
							?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense type added successfully</p></center></div>
							<script type="text/javascript">
							$(document).ready(function() {
							$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
									Ok: function() { $( this ).dialog( "close" );}
								}
							});
												
							});
							setTimeout('document.location.href="batch_timetable.php?record_id=<?php echo $row_record['c_b_id']; ?>";',300);
							</script>
							<?php
						}
					}
				}
				if($success==0)
				{
					$sel_batch="select batch_name from course_batch_mapping where c_b_id='".$record_id."'";
					$ptr_batch_name=mysql_query($sel_batch);
					$data_batch_name=mysql_fetch_array($ptr_batch_name);
					
					$sel_course="select course_name from courses where course_id='".$course_id."'";
					$ptr_course_name=mysql_query($sel_course);
					$data_course_name=mysql_fetch_array($ptr_course_name);
					
					$sel_name="select name from site_setting where admin_id='".$row_record['admin_id']."'";
					$ptr_name=mysql_query($sel_name);
					$data_name=mysql_fetch_array($ptr_name);
					
					$sel_time="select batch_time from batch_time where batch_time_id='".$row_record['batch_time_id']."'";
					$ptr_time=mysql_query($sel_time);
					$data_time=mysql_fetch_array($ptr_time);
					
					
				?>
					<table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%;padding:50px" >
                    	<tr>
                            <td width="20%">Batch Name<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box"><?php echo $data_batch_name['batch_name']; ?><input type="hidden" name="c_b_id" id="c_b_id" value="<?php echo $row_record['c_b_id']; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="20%">Course Name<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box"><?php echo $data_course_name['course_name']; ?><input type="hidden" name="course_id" id="course_id" value="<?php echo $row_record['course_id']; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="20%">Faculty Name<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box"><?php echo $data_name['name']; ?></td>
                        </tr>
                        <tr>
                            <td width="20%">Batch Timing<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box"><?php echo $data_time['batch_time']; ?></td>
                        </tr>
                    	<tr>
                            <td width="20%">Enter Holiday Reason<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box">
                                <textarea name="holiday_reason" id="holiday_reason" style="height:55px" class="validate[required] input_text" placeholder="Enter Holiday Reason in short" ><?php  if($_POST['holiday_reason']) echo $_POST['holiday_reason']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Select Holiday Date<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box">
                                <input type="text" class="validate[required] input_text datepicker" name="date" placeholder="Holiday Date" id="date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['date'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2"><input type="submit" name="save_changes" value="Save"  /></td>
                        </tr>
					</table>
					<?php 
				}?>
                
                
                <?php
				$sql_records= "SELECT * FROM batch_holiday where 1 and c_b_id='".$record_id."'";
				$no_of_records=mysql_num_rows($db->query($sql_records));
				if($no_of_records)
				{
					$bgColorCounter=1;
					if(!$_SESSION['showRecords'])
						$_SESSION['showRecords']=10;

					$query_string.="&show_records=".$showRecord;
					$pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
					$all_records= $pager->paginate();?>
					<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                    <input type="hidden" name="formAction" id="formAction" value=""/>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					
					<tr><td valign="top" colspan="2">
					   <table width="97%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width:97%;">
					<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="40%" class="tr-header"><strong>Holiday date</strong></td><td width="20%" class="tr-header"><strong>Holiday Reason</strong></td><td width="20%" class="tr-header">Action</td></tr><?php
					while($val_record=mysql_fetch_array($all_records))
					{
						if($bgColorCounter%2==0)
							$bgcolor='class="grey_td"';
						else
							$bgcolor=""; 
						 //$payment_mode_id=$val_record['module_type_id'];
						 
						$paid_totas=0;
						$listed_record_id=$val_record['batch_holiday_id'];
						include "include/paging_script.php";
						echo '<tr class="'.$bgclass.'">';
						
						$holi_date=explode("-",$val_record['holiday_date']);
						$holidates=$holi_date[2].'/'.$holi_date[1].'/'.$holi_date[1];
						echo '<td align="center">'.$sr_no.'</td>'; 
						echo '<td align="center">'.$holidates.'</td>';
						echo '<td align="center">'.$val_record['holiday_reason'].'</td>';
						
						echo '<td align="center">';										
						echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&c_b_id='.$record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>';
						
						echo '</td>';
						echo '</tr>';
					   $bgColorCounter++;
					}
					?>
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
                    </form>
				<?php
			}
			else if($_GET['search'])
				echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
			else
				echo'<center><br><div id="alert" style="width:30%">No Records here</div><br></center>';
				
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
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>