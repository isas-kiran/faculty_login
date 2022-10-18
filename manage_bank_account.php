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
	$sel="select * from bank where bank_id='".$record_id."'";
	$ptr_data=mysql_query($sel);
	if(mysql_num_rows($ptr_data))
		$row_record=mysql_fetch_array($ptr_data);
		
	$sel_payment_mode1="select branch_name from site_setting where cm_id='".$row_record['cm_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$branch_name=trim($data_payment_mode1['branch_name']);
	
	$sel_branch_id="select branch_id from branch where branch_name='".$branch_name."'";
	$ptr_branch_id=mysql_query($sel_branch_id);
	$data_branch_id=mysql_fetch_array($ptr_branch_id);
}
else
{
	$record_id='';
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='109'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Bank</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
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
            $("#payment_mode").multiselect().multiselectfilter();
			//$("#staff_pre_id").multiselect().multiselectfilter();
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
    <td class="top_mid" valign="bottom"><?php include "include/expense_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
     <?php 
                    if($_REQUEST['deleteRecord'])
                    {
                        $del_record_id=$_REQUEST['deleteRecord'];
                        $sql_query= "SELECT bank_id FROM ".$GLOBALS["pre_db"]."bank where bank_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_bank_account','Delete','manage_bank_account','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
							
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."bank where bank_id='".$del_record_id."'";
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
function set_status(values,ids)
{
	var data1="action=bank_status&status="+values+"&bank_id="+ids;	
	//alert(data1);
	$.ajax({
		url: "set_status.php", type: "post", data: data1, cache: false,
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
									$record_cat_id="and bank_id='".$_GET['record_id']."' ";
									
								}
                                $sql_records= "SELECT * FROM bank where 1 ".$record_cat_id." ".$_SESSION['where']." ".$pre_transcation_id." order by bank_id asc";
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
								<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="11%" class="tr-header"><strong>Bank Name</strong></td><td width="11%" class="tr-header"><strong>Branch</strong></td><td width="11%" class="tr-header"><strong>Account No.</strong></td><? if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{ ?><td width="8%"><strong>Center</strong></td><? }?><td width="8%"><strong>Is Credit Card</strong></td><td width="8%"><strong>Is paytm</strong></td><td width="8%"><strong>Is Vouchers</strong></td><?php if($_SESSION['type']=="S"  || $edit_access=='yes' )
	{ ?><td width="8%"><strong>Status</strong></td><td width="12%" class="tr-header"><strong>Action</strong></td> <?php }?></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										$se_kit="select bank_name,bank_id,branch,account_no,cm_id,is_credit_card,is_paytm,is_voucher from bank where bank_id='".$val_record['bank_id']."'";
										$ptr_kit_name=mysql_query($se_kit);
										$data_kit_name=mysql_fetch_array($ptr_kit_name);
										
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 $payment_mode_id=$val_record['bank_id'];
										 $paid_totas=0;
                                       $listed_record_id=$val_record['bank_id'];
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										echo "<td align='center'><a href='manage_bank_account.php?record_id=".$listed_record_id."' class='table_font'>".$data_kit_name['bank_name']."</a></td>";
										echo "<td align='center'>".$data_kit_name['branch']."</td>";
										echo "<td align='center'>".$data_kit_name['account_no']."</td>";
										$sel_branch="select branch_name from site_setting where cm_id='".$val_record['cm_id']."' and type='A'";
										$ptr_branch=mysql_query($sel_branch);
										$data_branch=mysql_fetch_array($ptr_branch);
										
										if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
										{
											  echo '<td align="center">'.$data_branch['branch_name'].'</td>';
										}
										$credit_card_checked='';
										if($data_kit_name['is_credit_card'] !='')
										{
											$credit_card_checked='checked="checked"';
										}
										
										$paytm_checked='';
										if($data_kit_name['is_paytm'] !='')
										{
											$paytm_checked='checked="checked"';
										}
										
										$voucher_checked='';
										if($data_kit_name['is_voucher'] !='')
										{
											$voucher_checked='checked="checked"';
										}
										
										echo "<td align='center'><input ".$credit_card_checked." type='radio' name='is_credit_".$data_branch['branch_name']."' value='check_credit' onclick='check_payment_status(this.value,".$listed_record_id.",".$val_record['cm_id'].")'></td>";
										echo "<td align='center'><input ".$paytm_checked." type='radio' name='is_paytm_".$data_branch['branch_name']."' value='check_paytm'  onclick='check_payment_status(this.value,".$listed_record_id.",".$val_record['cm_id'].")'></td>";
										echo "<td align='center'><input ".$voucher_checked." type='radio' name='is_voucher_".$data_branch['branch_name']."' value='check_voucher' onclick='check_payment_status(this.value,".$listed_record_id.",".$val_record['cm_id'].")'></td>";
										if($_SESSION['type']=="S"  || $edit_access=='yes')
										{
										echo '<td align="center"><a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp </td>';
										echo '<td align="center">';
										echo '<select name="bank_status" id="bank_status" class="input_select" style="width:100px;" onChange="set_status(this.value,'.$listed_record_id.')">
										<option value="">Select Status</option>';
										$act_selecteds = '';
										$inact_selecteds='';
										if($val_record['status']=='Active')
											$act_selecteds = 'selected="selected"';
										else if	($val_record['status']=='Inactive')
											$inact_selecteds = 'selected="selected"';
											
										echo "<option value='Active' ".$act_selecteds." >Active</option>";
										echo "<option value='Inactive' ".$inact_selecteds." >Inactive</option>";
										echo'</select>';
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
								$capex_invest=$_POST['capex_invest'];
								
								if($_POST['bank_name'] =="")
								{
										$success=0;
										$errors[$i++]="Enter Bank Name";
								}
								if($_POST['branch'] =="")
								{
										$success=0;
										$errors[$i++]="Enter Branch Name";
								}
								if($_POST['account_no'] =="")
								{
										$success=0;
										$errors[$i++]="Enter Account No";
								}
								if($record_id)
								{
									$bank_id="and bank_id !=".$record_id."";
								}
								else
								{
									 $bank_id="";
								}
								/*$chk_exist =" select bank_id from bank where account_no='".$_POST['account_no']."' ".$bank_id." ";
								$ptr_chk_exit = mysql_query($chk_exist);
								if(mysql_num_rows($ptr_chk_exit))
								{
									$success=0;
									$errors[$i++]="Account no already exist";
								}*/
								
								$added_date=date('Y-m-d H:i:s');   
								echo  count($errors);
								if(count($errors))
								{
										?>
								<tr><td colspan="3"> <br></br>
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
									$data_record['bank_name'] = $_POST['bank_name'];
									$data_record['branch'] = $_POST['branch'];
									$data_record['account_no'] = $_POST['account_no'];
									$data_record['capex_invest'] = $capex_invest;
									
									if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
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
									$data_record['added_date'] = date('Y-m-d H:i:s');
									
									if($record_id)
									{
										if($data_record['bank_name'] !='')
										{
												$update_bank = "update bank set `bank_name`='".$data_record['bank_name']."',`branch`='".$data_record['branch']."',`account_no`='".$data_record['account_no']."',`capex_invest`='".$capex_invest."',`added_date`='".date('Y-m-d H:i:s')."',`cm_id`='".$cm_id."' where bank_id='".$record_id."'";
												$ptr_bank= mysql_query($update_bank);
												
												$del_rec="delete from bank_payment_map where bank_id='".$record_id."'";
												$ptr_rec=mysql_query($del_rec);
												//=========================Payment Mode===================================
												$payment_mode = $_POST['payment_mode'];
												for($i=0;$i<count($payment_mode);$i++)
												{
													$insert_for_bank_pay="insert into bank_payment_map(`bank_id`,`payment_mode_id`)values('".$record_id."','".$payment_mode[$i]."')";
													$ptr_insert_preilgef = mysql_query($insert_for_bank_pay);
												} 
												//========================================================================
												
												"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_bank_account','Edit','".$_POST['bank_name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
												$query=mysql_query($insert);
												
											?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Bank Details Updated successfully</p></center></div>
													<script type="text/javascript">
														$(document).ready(function() {
															$( "#statusChangesDiv" ).dialog({
																	modal: true,
																	buttons: {
																				Ok: function() { $( this ).dialog( "close" );}
																			 }
															});
															
														});
													   setTimeout('document.location.href="manage_bank_account.php";',1000);
													</script>
										<?php
										}
									}
									else
									{
										if($data_record['bank_name'] !='')
										{
											$insert_for_prevelgegeis = "insert into bank (`bank_name`,`branch`,`account_no`,`capex_invest`,`added_date`,`admin_id`,`cm_id`) values('".$data_record['bank_name']."','".$data_record['branch']."','".$data_record['account_no']."','".$capex_invest."','".date('Y-m-d H:i:s')."','".$_SESSION['admin_id']."','".$cm_id."')";
											$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
											$ins_id=mysql_insert_id();
											
											//=========================Payment Mode===================================
											$payment_mode = $_POST['payment_mode'];
											for($i=0;$i<count($payment_mode);$i++)
											{
												$insert_for_bank_pay= "insert into bank_payment_map (`bank_id`,`payment_mode_id`) values('".$ins_id."','".$payment_mode[$i]."')";
												$ptr_insert_preilgef = mysql_query($insert_for_bank_pay);
											} 
											//========================================================================
											$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_bank_account','Add','".$_POST['bank_name']."','".$ins_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
                                               setTimeout('document.location.href="manage_bank_account.php";',1000);
                                            </script>
										<?php
										}
									}
								}
							}
                            ?>
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
                             <? if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
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
                            <tr>
                            	<td width="52%" class="tr-header" align="center">Enter Bank Name</td>
                                 <td width="25%" class="customized_select_box">
                      			<input type="text" name="bank_name" id="bank_name" value="<?php if($_POST['bank_name']) echo $_POST['bank_name']; else echo $row_record['bank_name']; ?>" >
                               </td>
                               <!--<td width="20%" ><input type="button" onClick="ajax_kit()" value="Add New Item" /></td> -->
                            </tr>
                             <tr>
                            	<td width="52%" class="tr-header" align="center">Enter Branch</td>
                                 <td width="25%" class="customized_select_box">
                      			<input type="text" name="branch" id="branch" value="<?php if($_POST['branch']) echo $_POST['branch']; else echo $row_record['branch']; ?>">
                               </td>
                               <!--<td width="20%" ><input type="button" onClick="ajax_kit()" value="Add New Item" /></td> -->
                            </tr>
                             <tr>
                            	<td width="52%" class="tr-header" align="center">Enter Account No</td>
                                 <td width="25%" class="customized_select_box">
                      			<input type="text" name="account_no" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $row_record['account_no']; ?>" >
                               </td>
                            </tr>
                            <tr>
                            	<td width="52%" class="tr-header" align="center">CapEx Investment</td>
                                 <td width="25%" class="customized_select_box">
                      			<input type="text" name="capex_invest" id="capex_invest" value="<?php if($_POST['capex_invest']) echo $_POST['capex_invest']; else echo $row_record['capex_invest']; ?>" >
                               </td>
                            </tr>
                            <tr>
                                <td width="20%" align="center">Select Payment Mode for Bank</td>
                                <td width="40%">
                                    <select multiple="payment_mode" name="payment_mode[]" id="payment_mode" class="input_select" style="width:150px;">
                                            <?php 
                                                $select_faculty = "select * from payment_mode order by payment_mode_id asc";
                                                $ptr_faculty = mysql_query($select_faculty);
                                                $i=0;
                                                while($data_faculty = mysql_fetch_array($ptr_faculty))
                                                { 
                                                	$class = '';
													if($record_id)
													{
														$sql_sub_cat ="select * from bank_payment_map where payment_mode_id='".$data_faculty['payment_mode_id']."' and bank_id='".$record_id."' ";
														$ptr_sub_cat = mysql_query($sql_sub_cat);
														if(mysql_num_rows($ptr_sub_cat))
														{
															$class = 'selected="selected"';
														}
													}
													echo '<option '.$class.' value="'.$data_faculty['payment_mode_id'].'" >'.$data_faculty['payment_mode'].'</option>';
													 
                                                $i++;
                                                }
                                                ?> 
                                     </select>
                                </td> 
                                <td width="40%"></td>
                            </tr>
                            <tr>
                            	<td align="center" colspan="2"><input type="submit" onclick="return validme();"  name="save_changes" value="<?php if($record_id) echo "Update"; else echo "Save"; ?>"  /></td>
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