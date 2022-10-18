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
	$sel="select * from reward_point_config where reward_point_id='".$record_id."'";
	$ptr_data=mysql_query($sel);
	if(mysql_num_rows($ptr_data))
		$row_record=mysql_fetch_array($ptr_data);
		
}
else
{
	$record_id='';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage SAC codes</title>
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
     <?php 
                    if($_REQUEST['deleteRecord'])
                    {
                        $del_record_id=$_REQUEST['deleteRecord'];
                        $sql_query= "SELECT reward_point_id FROM ".$GLOBALS["pre_db"]."reward_point_config where reward_point_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_reward','Delete','reward point','".$del_record_id."','".date('Yt-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
							
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."reward_point_config where reward_point_id='".$del_record_id."'";
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
 function validme()
	 {
		 frm = document.frmTakeAction;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
	 	if(frm.bank_name.value=='')
		 {
			 disp_error +='Enter Bank Name\n';
			 document.getElementById('bank_name').style.border = '1px solid #f00';
			 frm.bank_name.focus();
			 error='yes';
	     }
		 if(frm.branch.value=='')
		 {
			 disp_error +='Enter Branch name\n';
			 document.getElementById('branch').style.border = '1px solid #f00';
			 frm.branch.focus();
			 error='yes';
	     }
		 if(frm.account_no.value=='')
		 {
			 disp_error +='Enter Account Number\n';
			 document.getElementById('account_no').style.border = '1px solid #f00';
			 frm.account_no.focus();
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
function check_payment_status(action,bank_id,cm_id)
{
	var data1="action="+action+"&bank_id="+bank_id+"&cm_id="+cm_id;
	//alert(data1);
	$.ajax({
	url: "bank_ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
	}
	});
}
/*function check_paytm(values,bank_id,cm_id)
{
	var data1="action=check_paytm&bank_id="+bank_id+"&acc_no="+values+"&cm_id="+cm_id;
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
	}
	});
}
function check_voucher(values,bank_id,cm_id)
{
	var data1="action=check_voucher&bank_id="+bank_id+"&acc_no="+values+"&cm_id="+cm_id;
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
	}
	});
}*/
</script>                            
                      <form method="post" name="frmTakeAction">
                      <?php
					  			$record_cat_id='';
								if($_GET['record_id'] !='')
								{
									$record_cat_id="and reward_point_id='".$_GET['record_id']."' ";
								}
                                $sql_records= "SELECT * FROM reward_point_config where 1 ".$record_cat_id." ".$_SESSION['where']." ".$pre_transcation_id." order by reward_point_id asc";
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
                                    <table width="98%" align="center" cellpadding="0" cellspacing="1" class="table" style="width: 97%;">
									<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><?php if($_SESSION['type']=='S')
									{ ?><td width="8%"><strong>Center</strong></td><? }?><td width="11%" class="tr-header"><strong>Rupees</strong></td><td width="11%" class="tr-header"><strong>Reward Point</strong></td><?php if($_SESSION['type']=="S")	{ ?><td width="12%" class="tr-header"><strong>Action</strong></td><?php }?></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										
										$paid_totas=0;
										$listed_record_id=$val_record['reward_point_id'];
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										$sel_branch="select branch_name from site_setting where cm_id='".$val_record['cm_id']."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										$data_branch=mysql_fetch_array($ptr_branch);
										if($_SESSION['type']=='S')
										{
											echo '<td align="center">'.$data_branch['branch_name'].'</td>';
										}
										echo "<td align='center'>".$val_record['rupees']."</td>";
										echo "<td align='center'>".$val_record['reward_point']."</td>";
																				
										if($_SESSION['type']=="S")
										{
											echo '<td align="center"><a href="rewards_point_config.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
											echo '</td>';
										}
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
									
							if(isset($_POST['save_changes']))
							{
								$errors=array(); $i=0;	
								$branch_name=$_POST['branch_name'];
								$rupees=$_POST['rupees'];
								$reward_point=$_POST['reward_point'];
								
								if($_POST['branch_name'] =="")
								{
										$success=0;
										$errors[$i++]="Select Branch";
								}
								if($_POST['rupees'] =="")
								{
										$success=0;
										$errors[$i++]="Enter Rupees";
								}
								if($_POST['reward_point'] =="")
								{
										$success=0;
										$errors[$i++]="Enter Reward Point";
								}
								
								$added_date=date('Y-m-d');   
								echo  count($errors);
								if(count($errors))
								{
										?>
								<tr><td> <br></br>
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
									$data_record['rupees'] = $_POST['rupees'];
									$data_record['reward_point'] = $_POST['reward_point'];
									
									if($_SESSION['type']=='S')
									{
										$sel_branch="select cm_id ,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										$data_branch=mysql_fetch_array($ptr_branch);
										$cm_id=$data_branch['cm_id'];
										
										$branch_name1=$branch_name;
										$_SESSION['cm_id_notification']=$data_branch['cm_id'];
									}	
									else
									{
										$cm_id=$_SESSION['cm_id'];
										$branch_name1=$_SESSION['branch_name'];
									}
									$data_record['cm_id'] = $cm_id;
									$data_record['added_date'] = date('Y-m-d H:i:s');
									
									if($record_id)
									{
										if($data_record['reward_point'] !='')
										{
												$update_bank = "update reward_point_config set `rupees`='".$data_record['rupees']."',`reward_point`='".$data_record['reward_point']."',`added_date`='".date('Y-m-d H:i:s')."',`cm_id`='".$cm_id."' where reward_point_id='".$record_id."'";
												$ptr_bank= mysql_query($update_bank);
											
												"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_reward_point','Edit','".$_POST['bank_name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
												$query=mysql_query($insert);
												
											?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Rewards Point Updated successfully</p></center></div>
													<script type="text/javascript">
														$(document).ready(function() {
															$( "#statusChangesDiv" ).dialog({
																	modal: true,
																	buttons: {
																				Ok: function() { $( this ).dialog( "close" );}
																			 }
															});
															
														});
													   setTimeout('document.location.href="rewards_point_config.php";',1000);
													</script>
										<?php
										}
									}
									else
									{
										if($data_record['reward_point'] !='')
										{
												$insert_for_prevelgegeis = "insert into reward_point_config (`rupees`,`reward_point`,`added_date`,`cm_id`) values('".$data_record['rupees']."','".$data_record['reward_point']."','".date('Y-m-d H:i:s')."','".$cm_id."')";
												$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
												$ins_id=mysql_insert_id();
												"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_reward_point','Add','".$_POST['bank_name']."','".$ins_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
												$query=mysql_query($insert);
												
												?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Bank Details added successfully</p></center></div>
													<script type="text/javascript">
														$(document).ready(function() {
															$( "#statusChangesDiv" ).dialog({
																	modal: true,
																	buttons: {
																				Ok: function() { $( this ).dialog( "close" );}
																			 }
															});
															
														});
													   setTimeout('document.location.href="rewards_point_config.php";',1000);
													</script>
										<?php
										}
									}
								}
							}
                            ?>
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
                             <? if($_SESSION['type']=='S')
							{
								?>
                              <tr>
                                <td align="center">Select Branch</td>
                                <td>
                                <?php
                                $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                                $query_branch = mysql_query($sel_branch);
                                $total_Branch = mysql_num_rows($query_branch);
                                echo '<table width="100%"><tr><td>';
                                echo ' <select id="branch_name" name="branch_name">';
                                while($row_branch = mysql_fetch_array($query_branch))
                                {
									$selected='';
									if($_POST['branch_name']== $row_branch['branch_name'])
									{
										 $selected='selected="selected"';
									}
									$selected_branch="select branch_name from site_setting where cm_id= '".$row_record['cm_id']."' and type='A' ";
									$ptr_selected=mysql_query($selected_branch);
									if(mysql_num_rows($ptr_selected))
									{
										$data_cm_id=mysql_fetch_array($ptr_selected);
										if($data_cm_id['branch_name'] == $row_branch['branch_name'] )
										{
											 $selected='selected="selected"';
										}
									}
                                    ?>
                                    <option value="<? if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>" <?php echo $selected ?>><? echo $row_branch['branch_name']; ?> 
                                    </option>
                                    <?php
                                }
                                    echo '</select>';
                                    echo "</td></tr></table>";
                                    ?>
                            </td>
                        </tr>
                        <?php } ?>
						<!--<tr>
							<td Colspan="2" align="center" style="font-size:18px">Enter Rewards Point w.r.t.  Rupees [eg. Get 2 reward point after spending 100 rs/-]</td>
						<tr>-->
                            <tr>
                            	<td width="52%" class="tr-header" align="center">Enter Page Name</td>
                                 <td width="25%" class="customized_select_box">
                      			<input type="text" name="" id="page_name" value="<?php if($_POST['page_name']) echo $_POST['page_name']; else echo $row_record['page_name']; ?>" >
								</td>
                               <!--<td width="20%" ><input type="button" onClick="ajax_kit()" value="Add New Item" /></td> -->
                            </tr>
							<tr>
								<td Colspan="2" align="center" style="font-size:12px">(Note: Write same name in page where you want to add SAC code. Ex. $page_name = "example"; )</td>
							<tr>
                            <tr>
                            	<td width="52%" class="tr-header" align="center">Enter SAC code</td>
                                <td width="25%" class="customized_select_box">
                      			<input type="text" name="sac_code" id="sac_code" value="<?php if($_POST['sac_code']) echo $_POST['sac_code']; else echo $row_record['sac_code']; ?>">
                            </td>
                               <!--<td width="20%" ><input type="button" onClick="ajax_kit()" value="Add New Item" /></td> -->
                            </tr>
                            <tr>
                            	<td align="center" colspan="2"><input type="submit" onclick="return validme();" name="save_changes" value="<?php if($record_id) echo "Update"; else echo "Save"; ?>"  /></td>
                            </tr>
                            </table>
                            
                      <?php ?>
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
</body>
</html>
<?php $db->close();?>