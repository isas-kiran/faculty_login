<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
//$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	$sel="select * from sac_code_config where sac_code_id='".$record_id."'";
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
                        $sql_query= "SELECT sac_code_id FROM ".$GLOBALS["pre_db"]."sac_code_config where sac_code_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_reward','Delete','sac code','".$del_record_id."','".date('Yt-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
							
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."sac_code_config where sac_code_id='".$del_record_id."'";
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
	 	if(frm.page_name.value=='')
		 {
			 disp_error +='Enter Page Name\n';
			 document.getElementById(page_name).style.border = '1px solid #f00';
			 frm.page_name.focus();
			 error='yes';
	     }
		 if(frm.sac_code.value=='')
		 {
			 disp_error +='Enter SAC code\n';
			 document.getElementById('sac_code').style.border = '1px solid #f00';
			 frm.sac_code.focus();
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
									$record_cat_id="and sac_code_id='".$_GET['record_id']."' ";
								}
                                $sql_records= "SELECT * FROM sac_code_config where 1 ".$record_cat_id." ".$pre_transcation_id." order by sac_code_id asc";
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
									<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="11%" class="tr-header"><strong>Page Name</strong></td><td width="11%" class="tr-header"><strong>SAC code</strong></td><?php if($_SESSION['type']=="S")	{ ?><td width="12%" class="tr-header"><strong>Action</strong></td><?php }?></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										
										$paid_totas=0;
										$listed_record_id=$val_record['sac_code_id'];
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										
										echo "<td align='center'>".$val_record['page_name']."</td>";
										echo "<td align='center'>".$val_record['sac_code']."</td>";
																				
										if($_SESSION['type']=="S")
										{
											echo '<td align="center"><a href="manage_sac_code.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
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
								//$branch_name=$_POST['branch_name'];
								$page_name=$_POST['page_name'];
								$sac_code=$_POST['sac_code'];
								
								if($_POST['page_name'] =="")
								{
										$success=0;
										$errors[$i++]="Enter Page Name";
								}
								if($_POST['sac_code'] =="")
								{
										$success=0;
										$errors[$i++]="Enter SAC code";
								}
								$rec_id="";
								if($record_id)
								{
									$rec_id=" and sac_code_id !='".$record_id."'";
								}
								$sel_rew="select sac_code_id from sac_code_config where page_name='".$page_name."' ".$rec_id." ";
								$ptr_rew=mysql_query($sel_rew);
								if(mysql_num_rows($ptr_rew))
								{
									$success=0;
									$errors[$i++]="Record already exist.";
								}
								$added_date=date('Y-m-d');   
								if(count($errors))
								{
										?>
								<tr>
								<td></td>
								<td colspan="3"> <br></br>
										<table align="left" style="text-align:center;" class="alert">
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
									$data_record['page_name'] = $page_name;
									$data_record['sac_code'] = $sac_code;
									
									/*if($_SESSION['type']=='S')
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
									}*/
									$data_record['admin_id'] = $_SESSION['admin_id'];
									$data_record['added_date'] = date('Y-m-d H:i:s');
									
									if($record_id)
									{
										
										$update_bank = "update sac_code_config set `page_name`='".$page_name."',`sac_code`='".$sac_code."',`added_date`='".date('Y-m-d')."',`admin_id`='".$admin_id."' where sac_code_id='".$record_id."'";
										$ptr_bank= mysql_query($update_bank);
									
										"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_sac_code','Edit','".$_POST['bank_name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
													   setTimeout('document.location.href="manage_sac_code.php";',1000);
													</script>
										<?php
										
									}
									else
									{
										$insert_for_prevelgegeis = "insert into sac_code_config (`page_name`,`sac_code`,`added_date`,`admin_id`) values('".$page_name."','".$sac_code."','".date('Y-m-d')."','".$_SESSION['admin_id']."')";
										$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
										$ins_id=mysql_insert_id();
										"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_sac_code','Add','".$_POST['bank_name']."','".$ins_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
										$query=mysql_query($insert);
										
										?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>SAC Details added successfully</p></center></div>
											<script type="text/javascript">
												$(document).ready(function() {
													$( "#statusChangesDiv" ).dialog({
															modal: true,
															buttons: {
																		Ok: function() { $( this ).dialog( "close" );}
																	 }
													});
													
												});
											  setTimeout('document.location.href="manage_sac_code.php";',1000);
											</script>
										<?php
									}
								}
							}
                            ?>
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
                            
							<!--<tr>
								<td Colspan="2" align="center" style="font-size:18px">Enter Rewards Point w.r.t.  Rupees [eg. Get 2 reward point after spending 100 rs/-]</td>
							<tr>-->
                            <tr>
                            	<td width="52%" class="tr-header" align="center">Enter Page Name</td>
                                 <td width="25%" class="customized_select_box">
                      			<input type="text" name="page_name" id="page_name" value="<?php if($_POST['page_name']) echo $_POST['page_name']; else echo $row_record['page_name']; ?>" >
								</td>
                               <!--<td width="20%" ><input type="button" onClick="ajax_kit()" value="Add New Item" /></td> -->
                            </tr>
							<tr>
								<td Colspan="2" align="center" style="font-size:12px">(<span style="color:red">Note:</span> Write same name in page where you want to add SAC code. Ex. $page_name = "example" )</td>
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