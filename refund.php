<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_REQUEST['record_id']))
$record_id = $_REQUEST['record_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Refund Summery</title>
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
    </head>
<body>
<script>
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
		if(confirm("Are you sure, you want to give refund on selected record(s)?"))
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
<?php include "include/header.php";?>
<div id="info">
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
	
								<?php
								if($_POST['formAction']=="delete")
								{
									for($r=0;$r<count($_POST['chkRecords']);$r++)
									{
										$del_record_id=$_POST['chkRecords'][$r];
										/*$select_amount="select * from invoice where invoice_id='".$del_record_id."'";	
										$que_sel=mysql_query($select_amount);
										$que=mysql_fetch_array($que_sel);
										
										$amount +=$que['amount'];*/
										$update_invoice="update invoice set status ='Refund' where invoice_id='".$del_record_id."'";
										$query_update_invoice=mysql_query($update_invoice);
										 ?>
                                        <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) saved successfully</p></center></div>
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
                                            //setTimeout('document.location.href="manage_enroll.php";',1000);
                                        </script>
                                        <?php  
									} 
								}
								if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
								{
									$pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
                                }
                                else
                                {
                                    $balance=0;
                                    $pre_from_date="";                            
                                }
								$sql_records= "SELECT * FROM invoice where enroll_id=".$record_id." ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  
								order by invoice_id asc";
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();?>
									<!--<form method="post" name="frmTakeAction">-->                                 
									<form method="post"  name="frmTakeAction" >
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
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
                                                   
                                                    <td height="2" align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr>
                                    	<td valign="top" colspan="2">
                                    		<table width="97%"  align="center" class="table" >
												<?php
                                                $select_enroll = " select course_id,name,total_fees,added_date,installment_display_id,down_payment,course_fees,discount_type,discount,net_fees,service_tax,service_taxes_in_percent,cgst_tax,cgst_tax_in_percent,sgst_tax_in_percent,sgst_tax from enrollment where enroll_id='".$record_id."' ";
                                                $ptr_enroll=mysql_query($select_enroll);
                                                $data_enroll = mysql_fetch_array($ptr_enroll);
                                                
                                                $select_course = " select course_name from courses where course_id='".$data_enroll['course_id']."' ";
                                                $ptr_course=mysql_query($select_course);
                                                $data_course = mysql_fetch_array($ptr_course);
                                                
                                                ?>
                                                <tr style="padding-left:10px">
                                                    <td width="146" class="grey_td"><strong>Student Name :</strong></td><td width="143"><input type="hidden" id="student_name" value="<? echo $data_enroll['name']; ?>"><? echo $data_enroll['name']; ?></td>
                                                    <td width="145" class="grey_td"><strong>Course Name :</strong></td><td width="226"><input type="hidden" id="course_name" value="<? echo $data_course['course_name']; ?>"><? echo $data_course['course_name']; ?></td>
                                                    <td class="grey_td"><strong>Admission Date :</strong></td><td><input type="hidden" id="admission_date" value="<? echo $data_enroll['added_date']; ?>" ><? echo $data_enroll['added_date']; ?></td>
                                                    <td class="grey_td"><strong>Enrollment ID :</strong></td><td><input type="hidden" id="enrollment_id" value="<? echo $data_enroll['installment_display_id']; ?>"><? echo $data_enroll['installment_display_id']; ?></td>
                                                    <td width="141" class="grey_td"><strong>Course Fees :</strong></td><td width="161"><input type="hidden" id="course_fees" value="<?php echo $data_enroll['course_fees']; ?>"><? echo $data_enroll['course_fees']; ?></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td width="141" class="grey_td"><strong>Discount in (<?php echo $data_enroll['discount_type']; ?>)</strong></td><td width="161"><input type="hidden" id="discount" value="<? echo $data_enroll['discount']; ?>"><? echo $data_enroll['discount']; ?></td>
                                                    <td width="141" class="grey_td"><strong>Net Fees</strong></td><td width="161"><input type="hidden" id="net_fees" value="<? echo $data_enroll['net_fees']; ?>"><? echo $data_enroll['net_fees']; ?></td>
                                                    <td width="141" class="grey_td"><strong><?php if($data_enroll['service_tax'] >0) echo "Service Tax ".$data_enroll['service_taxes_in_percent'].""; else if($data_enroll['cgst_tax'] >0) echo "CGST (".$data_enroll['cgst_tax_in_percent']."%)+SGST(".$data_enroll['sgst_tax_in_percent']."%)"; ?></strong></td><td width="161"><input type="hidden" id="tax" value="<?php if($data_enroll['service_tax'] >0) echo $data_enroll['service_tax']; else if($data_enroll['cgst_tax'] >0) echo $data_enroll['cgst_tax']."+".$data_enroll['sgst_tax']; ?>"><?php if($data_enroll['service_tax'] >0) echo $data_enroll['service_tax']; else if($data_enroll['cgst_tax'] >0) echo $data_enroll['cgst_tax']."+".$data_enroll['sgst_tax']; ?></td>
                                                    <td width="141" class="grey_td"><strong>Total Fees :</strong></td><td width="161"><input type="hidden" id="total_fees" value="<? echo $data_enroll['total_fees']; ?>"><? echo $data_enroll['total_fees']; ?></td>
                                                    <td width="141" class="grey_td"><strong>Down Payment :</strong></td><td width="161"><input type="hidden" id="down_payment" value="<? echo $data_enroll['down_payment']; ?>"><? echo $data_enroll['down_payment']; ?></td>
                                                </tr>
                                    		</table>
                                    	</td>
                                    </tr>
                                    <tr>
                                    	<td valign="top" colspan="2">
										<input type="hidden" name="formAction" id="formAction" value=""/>
                                    	<table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
											<tr align="center" class="grey_td" ><td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td><td width="5%" class="tr-header"><strong>Sr.</strong></td><td width="7%" class="tr-header"><strong>Invoice No.</strong></td><td width="9%" class="tr-header"><strong>Inst. Paid</strong></td><td width="9%" class="tr-header"><strong>Balance Amount</strong></td><!--<td width="16%" class="tr-header"><strong>Installment</strong></td>--><td width="10%"  class="tr-header"><strong>Payment Mode</strong></td><td width="8%" class="tr-header"><strong> Date </strong></td></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										$enroll_id=$val_record['enroll_id'];
										$invoice_id=$val_record['invoice_id'];
										$paid_totas=0;
                                        /*if($bgColorCounter%2==0)
                                            $bgclass="tr-sub_white1";
                                        else
                                            $bgclass="tr-sub1";*/
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
										if($val_record['status']!='Refund')
										{
											echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$invoice_id.'"></td>';
										}
										else
											echo '<td></td>';
										echo '<td align="center"><input type="hidden" id="sr_no" value="'.$sr_no.'">'.$sr_no.'</td>';
										echo '<td align="center"><input type="hidden" id="invoice_id" value="'.$val_record['invoice_id'].'">'.$val_record['invoice_id'].'</td>';
										$name ='';
										$email_id = '';
										$phone_no ='';
					
									  	$select_firstname = " select * from enrollment where enroll_id='".$val_record['enroll_id']."' ";
									  	$ptr_query=mysql_query($select_firstname);
										$data_select = mysql_fetch_array($ptr_query);
										$paid=$data_select['paid'];
										
									    $totsss=$data_select['course_fees']-$data_select['discount'];
										$bal_totas=$totsss-$data_select['paid']; 
										echo '<td align="center"><input type="hidden" id="amount" value="'.$val_record['amount'].'">'.$val_record['amount'].'</td>'; 
										echo '<td align="center"><input type="hidden" id="balance_amt" value="'.$val_record['balance_amt'].'">'.$val_record['balance_amt'].'</td>';
										
										$sel_paid_type="select payment_mode from payment_mode where payment_mode_id='".$val_record['paid_type']."'";
										$ptr_paid_type=mysql_query($sel_paid_type);
										$data_paid_type=mysql_fetch_array($ptr_paid_type);
										
									    echo '<td align="center"><input type="hidden" id="payment_mode" value="'.$data_paid_type['payment_mode'].'">'.$data_paid_type['payment_mode'].'</td>';
										echo '<td align="center"><input type="hidden" id="added_date" value="'.$val_record['added_date'].'">';
										echo date("d-m-Y",strtotime($val_record['added_date']));
										echo'</td>';
										echo'</tr>';
									}
									?>
                                </table>
								</td></tr>
								<tr>
							 		<td align="center"><a name="selAction" id="selAction" onClick="Javascript:submitAction('<?php echo 'delete'; ?>');"><input type="submit" class="input_btn" value="Make Refund"  /></a></td>
							 	</tr>
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
                                	</td>
                                </tr>
                            </table>
                        </form><?php
                    }
                    else if($_GET['search'])
                      echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria,please try again to get more results</div><br></center>';
                    else
                    	echo'<center><br><div id="alert" style="width:30%">No Payment history here</div><br></center>';
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
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>