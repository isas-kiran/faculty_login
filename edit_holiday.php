<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
{
	$record_id = $_REQUEST['record_id'];
	$sql_point= "SELECT * FROM holiday where holiday_id='".$record_id."'";
	if(mysql_num_rows($db->query($sql_point)))
	$row_record=$db->fetch_array($db->query($sql_point));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Holiday</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
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
    <td class="top_mid" valign="bottom"><?php include "include/general_setting_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
     <?php 
                    if($_REQUEST['deleteRecord'])
                    {
                        $del_record_id=$_REQUEST['deleteRecord'];
                        $sql_query= "SELECT responce_id FROM ".$GLOBALS["pre_db"]."responce_category where responce_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."responce_category where responce_id='".$del_record_id."'";
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
                    <form method="post" name="frmTakeAction">
                    <?php
							$errors=array(); $i=0;			
							$success=0;
							
							if($_POST['save_changes'])
							{
								$branch_name=$_POST['branch_name'];
								$added_date=date('Y-m-d H:i:s');  
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
									</td></tr><br></br>  
									<?php
								}
								else
								{
									$success=1;
									$data_record['added_date'] = date('Y-m-d H:i:s');
									//===============================CM ID for Super Admin =================
									if($_SESSION['type']=='S')
									{
										$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										if(mysql_num_rows($ptr_branch))
										{
											$data_branch=mysql_fetch_array($ptr_branch);
											$cm_id=$data_branch['cm_id'];
											$data_record_type1['cm_id'] =$cm_id;
										}
										else
										{
											?>
											<script>alert("You cant update ...! First create center manager for this branch or you can add new one record")</script>
											<?php
											exit();
										}
									}	
									else
									{
										$branch_name1=$_SESSION['branch_name'];
										$cm_id=$_SESSION['cm_id'];
										$data_record_type1['cm_id'] =$cm_id;
									}
									//====================================================================
									if($record_id)
									{
										$data_record_type1['added_date']=$added_date;
										$data_record_type1['name'] = addslashes(trim($_POST['name']));
										
										$frm_date = addslashes(trim($_POST['from_date'])) ;
										$to_date = addslashes(trim($_POST['to_date'.$j])) ;
										
										if($frm_date !='//' || $frm_date !='' )
										{
											$sep_date = explode('/',$frm_date);
											$frm_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
										}
										else
										{
											if($frm_date <= date('(Y-m-d)') )
											{
												$success=0;
												$errors[$i++]="Invalid Followup Date";
											}
											$success=0;
											$errors[$i++]="Enter your Start Date";
										}
										if($to_date !='//' || $to_date !='' )
										{
											$sep_date = explode('/',$to_date);
											$to_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
										}
										else
										{
											if($to_date <= date('(Y-m-d)') )
											{
												$success=0;
												$errors[$i++]="Invalid Followup Date";
											}
											$success=0;
											$errors[$i++]="Enter your End Date";
										}
										$data_record_type1['from_date'] = $frm_date ;
										$data_record_type1['to_date'] = $to_date ;
										$where_record="holiday_id='".$record_id."'";   
										$db->query_update("holiday", $data_record_type1,$where_record); 
									}
									    
									echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
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
									setTimeout('document.location.href="responce_category.php";',1000);
									</script>
								<?php
								}
							}
							if($success==0)
							{	
								?>
								<table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%;">
								<?php
								if($_SESSION['type']=='S')
								{
								?>
									<tr>
										<td align="">Select Branch</td>
										<td>
										<?php
										$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
										$ptr_query=mysql_query($sel_cm_id);
										$data_branch_nmae=mysql_fetch_array($ptr_query);
										$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
										$query_branch = mysql_query($sel_branch);
										$total_Branch = mysql_num_rows($query_branch);
										echo '<table width="100%"><tr><td>';
										echo '<select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
										while($row_branch = mysql_fetch_array($query_branch))
										{
											?>
											<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>"  <?php if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
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
								{ ?>
									<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
									<?php 
								}?>
								<tr>
									<td width="20%">Holiday Name</td>
									<td><input type="text" name="name" id="name" class="input_text" value="<?php echo $row_record['name']; ?>" /></td>
								</tr>
								<tr>
									<td width="20%">From Date</td>
									<td><input type="text" name="from_date" class="input_text datepicker" id="from_date" value="<?php if($row_record['from_date']) {$frm_date=explode("-",$row_record['from_date']); echo $frm_date[2].'/'.$frm_date[1].'/'.$frm_date[0];} ?>" /></td>
								</tr>
								<tr>
									<td width="20%">To Date</td>
									<td><input type="text" name="to_date" class="input_text datepicker" id="to_date" value="<?php if($row_record['to_date']) {$frm_date=explode("-",$row_record['to_date']); echo $frm_date[2].'/'.$frm_date[1].'/'.$frm_date[0];} ?>" /></td>
								</tr>
								<tr>
									<td align="center" colspan="2"><input type="submit" name="save_changes" onclick="return validme();"  value="Update"  /></td>
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
create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>