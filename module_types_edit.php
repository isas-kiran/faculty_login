<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM module_types where module_type_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
	{
        $row_record=$db->fetch_array($db->query($sql_record));
		
	}
    else
	{
        $record_id=0;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Modules Type</title>
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
    
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
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
    
  <script>
/* function validme()
	 {
		 frm = document.frmTakeAction;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
	 	if(frm.expense_category.value=='')
		 {
			 disp_error +='Enter Expense Type\n';
			 document.getElementById('expense_category').style.border = '1px solid #f00';
			 frm.expense_category.focus();
			 error='yes';
	     }
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
	
	 }*/
</script>                          
                      <form method="post" name="frmTakeAction">
                      <?php
                               
							if($_POST['save_changes'])
							{
								$branch_name=$_POST['branch_name'];
								$sub_name=$_POST['sub_name'];
								$sms_text=$_POST['sms_text'];
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
								 </td></tr>   <br></br>  
							<?php
								}
								else
								{
									$success=1;
									$data_record['added_date'] = date('Y-m-d H:i:s');
									$data_record['module_type'] = $sub_name;
									$data_record['sms_text'] = $sms_text;
									//===============================CM ID for Super Admin===============
									if($_SESSION['type']=='S')
									{
										$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										$data_branch=mysql_fetch_array($ptr_branch);
										$cm_id=$data_branch['cm_id'];
										$data_record_type1['cm_id'] =$cm_id;
									}	
									else
									{
										$branch_name1=$_SESSION['branch_name'];
										$cm_id=$_SESSION['cm_id'];
										$data_record_type1['cm_id'] =$cm_id;
									}
								//====================================================================
								
								$where_record=" module_type_id ='".$record_id."'";
								
								$db->query_update("module_types", $data_record,$where_record);
								
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
							 	setTimeout('document.location.href="module_types.php";',1000);
								</script>
				 
								<?php
									
								}
							}
							if($success==0)
							{	
									
                            ?>
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; ">
                            <?php
								if($_SESSION['type']=='S')
								{
								?>
									<tr>
										<td align="center">Select Branch</td>
										<td>
										<?php
										$sel_cm_id="select branch_name from site_setting where cm_id=".$row['cm_id']." ";
										$ptr_query=mysql_query($sel_cm_id);
										$data_branch_nmae=mysql_fetch_array($ptr_query);
										$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
										$query_branch = mysql_query($sel_branch);
										$total_Branch = mysql_num_rows($query_branch);
										echo '<table width="100%"><tr><td>';
										echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
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
							<?php }
							else { ?>
									<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
							<?php }?>
                           
                            <tr>
                                <td align="center">Name</td><td><input type="text" name="sub_name" id="sub_name" value="<?php if($_POST['sub_name']) echo $_POST['sub_name']; else echo $row_record['module_type']; ?>"  /></td>
                            </tr>
                            <tr>
                                <td align="center">SMS Text </td><td><textarea name="sms_text" id="sms_text" ><?php if($_POST['sms_text']) echo $_POST['sms_text']; else echo $row_record['sms_text']; ?></textarea></td>
                            </tr>
                            <tr>
                            	<td align="center" colspan="2"><input type="submit" name="save_changes" onclick="return validme();"  value="Save"  /></td>
                            </tr>
                            </table>
                            
                      <?php }?>
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