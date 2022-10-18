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
<title>Add Holiday</title>
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
	var pageName='add_holiday';
        jQuery(document).ready( function() 
        {
			$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            /*$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }*/
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
                        $sql_query= "SELECT holiday_id FROM holiday where holiday_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
							$delete_query="delete from holiday where holiday_id='".$del_record_id."'";
							$db->query($delete_query);
							
							$delete_query="delete from holiday_mapping where holiday_id='".$del_record_id."'";
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
                                $sql_records= "SELECT * FROM holiday where 1 ".$_SESSION['where']." order by holiday_id asc";
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
									<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><?php if($_SESSION['type']=='S')
										{ ?><td width="11%" class="tr-header"><strong>branch name</strong></td><?php } ?><td width="11%" class="tr-header"><strong>Holiday name</strong></td><td width="11%" class="tr-header"><strong>From date</strong></td><td width="11%" class="tr-header"><strong>To date</strong></td><td width="12%" class="tr-header"><strong>Action</strong></td></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 //$payment_mode_id=$val_record['module_type_id'];
										 
										$paid_totas=0;
                                       	$listed_record_id=$val_record['holiday_id'];
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
										
                                        echo '<td align="center">'.$sr_no.'</td>';
										if($_SESSION['type']=='S')
										{
											$sel_branch="select branch_name from site_setting where cm_id='".$val_record['cm_id']."' and type='A'";
											$ptr_branch=mysql_query($sel_branch);
											$data_branch=mysql_fetch_array($ptr_branch);
											echo '<td align="center">'.$data_branch['branch_name'].'</td>';
										}
									
										echo "<td align='center'>".$val_record['name']."</td>";
										echo "<td align='center'>".$val_record['from_date']."</td>";
										echo "<td align='center'>".$val_record['to_date']."</td>";
										echo '<td align="center">';
										
										echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;<a href="edit_holiday.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
										
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
								$branch_name=$_POST['branch_name'];
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
									$data_record['added_date'] = date('Y-m-d H:i:s');									
									//===============================CM ID for Super Admin===============
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
								
									for($j=1;$j<=$total_floor;$j++)
									{
										if($_POST['name'.$j] !='')
										{
											$frm_date = addslashes(trim($_POST['from_date'.$j])) ;
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
												
											$data_record_type1['name'] = addslashes(trim($_POST['name'.$j]));
											$data_record_type1['from_date'] = $frm_date ;
											$data_record_type1['to_date'] = $to_date;
											$data_record_type1['admin_id'] = $_SESSION['admin_id'];
											$data_record_type1['added_date']=$added_date;
											$record_ids=$db->query_insert("holiday",$data_record_type1);
											$sub_id=mysql_insert_id();
											
											//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
											//We add one to inlude both dates in the interval.
											$days = abs(round((strtotime($to_date)- strtotime($frm_date)) / 86400 ));
											
											for($i=0;$i<$days+1;$i++)
											{
												$addDate=date('Y-m-d', strtotime($frm_date. ' + '.$i.' days'));
												$data_holiday['holiday_id'] = $record_ids;
												$data_holiday['holiday_date'] = $addDate;
												$data_holiday['admin_id'] = $_SESSION['admin_id'];
												$data_holiday['cm_id'] =$cm_id;
												$holiday_rec=$db->query_insert("holiday_mapping",$data_holiday);
												$holiday_id=mysql_insert_id();
											}
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
							 		setTimeout('document.location.href="add_holiday.php";',1000);
									</script>
				 					<?php
								}
							}
							if($success==0)
							{	
									
                            ?>
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
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
                                <td colspan="3">
                                	<table  width="100%" style="border:0px solid gray; ">
                                		<tr>
                                        <td colspan="3">
                                        <!--===========================================================NEW TABLE START===================================-->
                                        <table cellpadding="5" width="100%" >
                                        	<tr>
                                         	<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                                         	<script language="javascript">
                                            function floors(idss)
                                            {
                                            	var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="40%" align="center"><input type="text" name="name'+idss+'" id="name'+idss+'" style="width:90%" required/></td><td valign="top" width="20%" align="center"><input type="text" name="from_date'+idss+'" class="input_text datepicker" placeholder="From Date" id="from_date'+idss+'" title="From Date" value=""></td><td valign="top" width="20%" align="center"><input type="text" name="to_date'+idss+'" class="input_text datepicker" placeholder="To Date" id="to_date'+idss+'" title="To Date" value=""></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
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
                                            <td valign="top" width="40%" align="center">Holiday Name</td>
                                            <td valign="top" width="20%" align="center">Start Date</td>
											<td valign="top" width="20%" align="center">To Date</td>
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
create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>