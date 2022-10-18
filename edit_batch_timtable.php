<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$sel_log="select * from batch_timetable where batch_timetable_map_id='".$record_id."'";
$ptr_log=mysql_query($sel_log);
$row_record=mysql_fetch_array($ptr_log);
$course_id=$row_record['course_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Batch Timetable</title>
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
			//$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            /*$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }*/
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
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
    <?php 
	if($_REQUEST['deleteRecord'])
	{
		$del_record_id=$_REQUEST['deleteRecord'];
		$sql_query= "SELECT logsheet_id FROM logsheet where logsheet_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{                           
			$delete_query="delete from logsheet where logsheet_id='".$del_record_id."'";
			$db->query($delete_query);
			
			$delete_que="delete from logsheet_map where logsheet_id='".$del_record_id."'";
			$db->query($delete_que);
			?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record Deleted Successfully</p></center></div>
			<script type="text/javascript">
            $(document).ready(function() {
            $( "#statusChangesDiv" ).dialog({
                modal: true,
                buttons: {
                    Ok: function() { $( this ).dialog( "close" );}
                }
            });
                                
            });
            setTimeout('document.location.href="create_logsheet.php";',500);
            </script>
            <?php
		}
	}
	?>
               
			<form method="post" name="frmTakeAction">
                <?php
				if($_POST['save_changes'])
				{
					$topic_id=$_POST['topic_id'];
					$added_date=date('Y-m-d');  
					$topic_content=$_POST['topic_content']; 
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
						
						$data_record['topic_id'] = $topic_id;
						$data_record['topic_content'] =$topic_content;
						
						if($record_id)
						{
							
							$where_record="batch_timetable_map_id='".$record_id."'";
							$db->query_update("batch_timetable", $data_record,$where_record);
							   
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
				?>
					<table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%;padding:50px" >
					<tr>
						<td width="20%">Select Topic <span class="orange_font">*</span></td>
						<td width="40%" class="customized_select_box">
							<select name="topic_id" id="topic_id" class=" topic_id" onChange="select_topic_content(this.value);" >  
							<option value=""> Select Topic </option>
							<?php
							$select_topic="select topic_id from topic_map where course_id='".$course_id."' order by topic_id";
							$ptr_topic= mysql_query($select_topic);
							while($data_topic=mysql_fetch_array($ptr_topic))
							{
								$sel_name="select topic_name,topic_id from topic where topic_id='".$data_topic['topic_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_name=mysql_fetch_array($ptr_name);
								
								$selected= '';
								if($data_topic['topic_id']==$row_record['topic_id'] || $_POST['topic_id']==$data_topic['topic_id'] )
								{
									$selected= ' selected="selected" ';
								}
								
								echo "<option value='".$data_name['topic_id']."' ".$selected.">".addslashes($data_name['topic_name'])." </option>";
							}
							?>    
							</select>
						</td>
					</tr>
                    <tr>
						<td width="20%">Enter Topic Content<span class="orange_font">*</span></td>
						<td width="40%" class="customized_select_box">
						<textarea name="topic_content" id="topic_content" class="input_textarea" style="width: 450px; height: 100px;"><?php echo $row_record['topic_content']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2"><input type="submit" name="save_changes" onclick="return validme();"  value="Save"  /></td>
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