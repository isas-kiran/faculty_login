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
<title>Change Batch Topics</title>
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
function select_day_content(day_id)
{
	var html='';
	var data1="action=get_topics&day_id="+day_id+"&c_b_id=<?php echo $record_id; ?>";
	alert(data1);
	$.ajax({
		url: "get_topic_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			document.getElementById("topic_data").innerHTML=html;
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
					
					$change_day=$_POST['day'];
					
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
							
							echo "<br/>".$sel_data="select * from batch_timetable where c_b_id='".$record_id."' and course_id='".$course_id."' and date >='".$hollidate."' group by day order by day asc";
							$ptr_timet_data=mysql_query($sel_data);
							$total_days=mysql_num_rows($ptr_timet_data);
							
							echo "<br/>date ".$holiStartDate=$hollidate;
							$holiTimestamp=strtotime($holiStartDate);
							
							echo "<br/>start date ".$startDate=$hollidate;
							$timestamp=strtotime($startDate);
							echo "<br/>Total day ".$days=$total_days;
							while($data_times=mysql_fetch_array($ptr_timet_data))
							{
								$day=$data_times['day'];
								$c_b_id=$record_id;
								
								$data_record_timetable['c_b_id']=$c_b_id;
								
								/*$data_record_timetable['day']=$data_times['day'];
								$data_record_timetable['topic_id']=$data_times['topic_id'];
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
									if((in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates)) )
									{	
										
										echo "<br/>holi- ".$timestamp=strtotime("+ 1 day", $timestamp);
										//$dates[$i]=date("d/m/Y",strtotime("+ 1 day", $timestamp));
										//$timestamp = strtotime("+ 1 day", $timestamp);
										$totals++;
									}
									else
									{
										
										if((in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates)) )
										{	
											
											echo "<br/>holi- ".$timestamp=strtotime("+ 1 day", $timestamp);
											//$dates[$i]=date("d/m/Y",strtotime("+ 1 day", $timestamp));
											//$timestamp = strtotime("+ 1 day", $timestamp);
											$totals++;
										}
										else if(in_array(date("Y-m-d", $timestamp),$skipholidays))
										{
											//echo "<br/>Day ".$data_record_timetable['date']=date("Y-m-d", $timestamp);
											echo "<br/>".$update="update batch_timetable set date='".date("Y-m-d", $timestamp)."' where day='".$change_day."' and c_b_id='".$c_b_id."'";
											$up_query=mysql_query($update);
											//$where_record="batch_timetable_map_id='".$data_date['batch_timetable_map_id']."'";
											//$db->query_update("batch_timetable", $data_record_timetable,$where_record);
											echo "<br/>holi- ".$timestamp=strtotime("+ 1 day", $timestamp);
											//$totals++;
										}
										else if($data_times['day']!=$change_day)
										{
											echo "<br/>Day ".$data_record_timetable['date']=date("Y-m-d", $timestamp);
											//echo "<br/>".date("Y-m-d", $timestamp);
											
											echo "<br/>where ".$where_record=" day='".$data_times['day']."' and c_b_id='".$c_b_id."'";
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
							//setTimeout('document.location.href="batch_timetable.php?record_id=<?php echo $row_record['c_b_id']; ?>";',300);
							</script>
							<?php
						}
					}
				}
				if($success==0)
				{	
				?>
					<table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%;padding:50px" >
                        <tr>
                            <td width="20%">Select Date<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box">
                                <input type="text" class="validate[required] input_text datepicker" name="date" placeholder="Change Date" id="date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['date']; else echo date('d/m/Y')?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Select Day<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box">
                            <select name="day" id="day" onchange="select_day_content(this.value)">
                            <option value="">Select Day</option>
                            <?php
							$sql_query= "SELECT DISTINCT(`day`) FROM batch_timetable where 1 and c_b_id='".$record_id."' order by day asc "; 
							$ptr_day=mysql_query($sql_query);
							while($data_day=mysql_fetch_array($ptr_day))
							{
								?>	
                            	<option value="<?php echo $data_day['day']; ?>">Day <?php echo $data_day['day']; ?></option>
								<?php
							}
							?>	
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Topics<span class="orange_font">*</span></td>
                            <td width="40%" class="customized_select_box" id="topic_data"> </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2"><input type="submit" name="save_changes" value="Save"  /></td>
                        </tr>
					</table>
					<?php 
				}?>
			</form>
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