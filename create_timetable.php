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
<title>Add Timetable</title>
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
			$("#course_id").chosen({allow_single_deselect:true});
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
        
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
function select_course(course_id)
{
	var data1="action=gettopic&course_id="+course_id;
	$.ajax({
		url: "get_topic_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			//res=html;
			document.getElementById("create_floor").innerHTML='';
			document.getElementById("res1").value=html;
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
		$sql_query= "SELECT timetable_id FROM timetable where timetable_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{                           
			$delete_query="delete from timetable where timetable_id='".$del_record_id."'";
			$db->query($delete_query);
			
			$delete_que="delete from timetable_topic_map where timetable_id='".$del_record_id."'";
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
            setTimeout('document.location.href="create_timetable.php";',500);
            </script>
            <?php
		}
	}
	?>
               
                      <form method="post" name="frmTakeAction">
                      <?php
                                $sql_records= "SELECT course_id,timetable_id FROM timetable where 1";
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();?>
                                    
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                    
                                    <tr><td valign="top" colspan="2">
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
									<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="40%" class="tr-header"><strong>Course name</strong></td><td width="20%" class="tr-header"><strong>Total Topics</strong></td><td width="20%" class="tr-header">Action</td></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 //$payment_mode_id=$val_record['module_type_id'];
										 
										$paid_totas=0;
                                       	$listed_record_id=$val_record['timetable_id'];
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
										
                                        echo '<td align="center">'.$sr_no.'</td>'; 
										
										$sel_course="select course_name from courses where course_id='".$val_record['course_id']."'";
										$ptr_course=mysql_query($sel_course);
										$data_course=mysql_fetch_array($ptr_course);
										echo '<td align="center"><a href="view_timetable.php?record_id='.$listed_record_id.'" target="_blank" >'.$data_course['course_name'].'</a></td>';
										
										$sel_time="select timetable_map_id from timetable_topic_map where timetable_id='".$val_record['timetable_id']."'";
										$ptr_time=mysql_query($sel_time);
										$total_topic=mysql_num_rows($ptr_time);
										echo '<td align="center"><a href="view_timetable.php?record_id='.$listed_record_id.'" target="_blank" >'.$total_topic.'</a></td>';
										
										echo '<td align="center">';										
										echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;<a href="create_timetable.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
										
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
                                    
                                    
                                    <?php
                                }
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Records here</div><br></center>';
							$errors=array(); $i=0;			
							$success=0;
							
							
							if($_POST['save_changes'])
							{
								$course_id=$_POST['course_id'];
								$added_date=date('Y-m-d');  
								$total_floor=$_POST['floor']; 
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
															
									//===============================CM ID for Super Admin===============
									$branch_name1=$_SESSION['branch_name'];
									$cm_id=$_SESSION['cm_id'];
									$data_record_type1['cm_id'] =$cm_id;
									//====================================================================
									$data_record['course_id'] = $course_id;
									$data_record['cm_id'] =$cm_id;
									$data_record['admin_id'] = $_SESSION['admin_id'];
									$data_record['added_date'] = date('Y-m-d H:i:s');
									$record_ids=$db->query_insert("timetable",$data_record);
									$sub_id=mysql_insert_id();  
									
									for($j=1;$j<=$total_floor;$j++)
									{
										if($_POST['topic'.$j]!='')
										{
											$data_record_type1['timetable_id'] = $sub_id;
											$data_record_type1['course_id'] = $course_id;
											$data_record_type1['day'] = $_POST['day'.$j];
											$data_record_type1['topic_id'] =$_POST['topic'.$j];
											$data_record_type1['topic_content'] = addslashes(trim($_POST['topic_content'.$j]));
											$data_record_type1['model_required'] =$_POST['model'.$j];
											$data_record_type1['admin_id'] = $_SESSION['admin_id'];
											$data_record_type1['cm_id'] =$cm_id;
											$data_record_type1['added_date']=$added_date;
											$record_ids=$db->query_insert("timetable_topic_map",$data_record_type1);
										}
									}          
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
							 		setTimeout('document.location.href="create_timetable.php";',1000);
									</script>
				 					<?php
								}
							}
							if($success==0)
							{	
									
                            ?>
                            <input type="hidden" name="res1" id="res1" />
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
                            <tr>
                                <td width="20%">Select Course <span class="orange_font">*</span></td>
                                <td width="40%" class="customized_select_box">
                                    <select name="course_id" id="course_id" class=" input_select" onChange="select_course(this.value);" >  
                                        <option value=""> Select Course </option>
                                        <?php
										$get="SELECT course_name,course_id FROM courses order by course_id";
										$ptr_course=mysql_query($get);
                                        $disbled='';
                                        while($data_course=mysql_fetch_array($ptr_course))
                                        {  
                                            $selected= '';
                                            if($data_course['course_id']==$row_record['course_id'] || $_POST['course_id']==$data_course['course_id'] )
                                            {
                                                $selected= ' selected="selected" ';
                                            }
                                            ?>
                                            <option value ="<?php echo $data_course['course_id']?>" <?php echo $selected; ?> ><?php echo $data_course['course_name'] ?></option>
                                            <?php
                                        }
                                        ?>    
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                	<table  width="100%" style="border:0px solid gray; ">
                                		<tr>
                                        <td colspan="3">
                                        <table cellpadding="5" width="100%" >
                                        	<tr>
                                         	<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                                         	<script language="javascript">
                                            function floors(idss)
                                            {
												res= document.getElementById("res1").value;
												
                                            	var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="20%" align="center">Day '+idss+'<input type="hidden" name="day'+idss+'" id="day'+idss+'" style="width:90%" value="'+idss+'" required/></td><td valign="top" width="20%" align="center"><select name="topic'+idss+'" id="topic'+idss+'" style="width:95%" ><option value="">Select Topic '+idss+'</option>'+res+'</select></td><td valign="top" width="40%" align="center"><textarea name="topic_content'+idss+'" placeholder="Topic Contetnt '+idss+'" id="topic_content'+idss+'" title="Topic Content '+idss+'" value="" style="width:100%;height:30px"></textarea></td><td valign="top" width="20%" align="center"><input type="text" name="model'+idss+'" id="model'+idss+'" ></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                            	document.getElementById('floor').value=idss;
                                                return shows_data;
                                            }
                                            </script>
                                            <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
                                            <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
                                            </td></tr>
                                            <tr><td>  </td><td align="left"></td></tr>
                                        </table> 
                                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
                                        <tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
                  						<tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
                  						<tr>
                                            <td colspan="6">
                                            <table cellspacing="3" id="tbl" width="100%">
                                            <tr>
                                            <td valign="top" width="20%" align="center">Days</td>
                                            <td valign="top" width="20%" align="center">Topic</td>
                                            <td valign="top" width="40%" align="center">Topic Content</td>
                                            <td valign="top" width="20%" align="center">Model Required</td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="floor" id="floor"  value="0" />
                                    <div id="create_floor"></div>
                              	</td></tr>
							</table>
                                        <!--============================================================END TABLE=========================================-->
                                        </td>
                                        </tr>
                                        </table>
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
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script language="javascript">
//create_floor('add');
</script>
<script language="javascript">
//create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>