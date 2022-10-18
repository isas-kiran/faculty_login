<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();

if(isset($_REQUEST['record_id']))
	$record_id = $_REQUEST['record_id'];

if(isset($_REQUEST['record_id']))
	$invoice_id=$_REQUEST['invoice_id'];
	
$sel_course="select course_id,assigned_to from enrollment where enroll_id='".$record_id."'";
$ptr_course=mysql_query($sel_course);
$data_course=mysql_fetch_array($ptr_course);
$assigned_to=$data_course['assigned_to'];

$course_name="select course_name from courses where course_id='".$data_course['course_id']."'";
$ptr_c_name=mysql_query($course_name);
$data_cnama=mysql_fetch_array($ptr_c_name);
$course_name=$data_cnama['course_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Enrollment ";?>
 Form</title>
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
    <!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
    <?php
	if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
	?>
		$(document).ready(function()
		{            
			$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',
			maxDate: '+2Y',});
		});
		<?php
	}
	?>
	
    </script>
    <script type="text/javascript">
	
	finish = 0;
	remain=0;
	function calculate_total()
	{
		var final_call=0;
		var amount_paid=document.getElementById('amount_paid').value;
		//alert(amount_paid);
		//==============================TOTAL GST ==================================// changes in 14-11-17
		var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
		//alert(cgsttax);
		var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
		var totalgst=cgsttax+sgsttax;
		//alert(amount_paid);
		var new_total_tax=parseFloat((totalgst+100)/100);
		var total_taxable_value = parseInt(amount_paid / new_total_tax);
		
		var total_gst =parseInt(amount_paid - total_taxable_value);
		//alert(total_gst);
		//document.getElementById('total_gst').value=total_gst;
		//==========================================================================
		//==============================For CGST====================================
		/*var cgst=parseFloat(document.getElementById('cgst_taxes').value);			// changes in 14-11-17
		var new_cgst_tax=parseFloat((cgst+100)/100);
		var cgst_taxable_value = parseInt(amount_paid / new_cgst_tax);
		var cgast_tax =parseInt(amount_paid - cgst_taxable_value);*/
		cgast_tax=parseInt(total_gst/2);
		document.getElementById('cgst_tax').value=cgast_tax;
		//==========================================================================
		
		//==============================For SGST====================================
		/*var sgst=parseFloat(document.getElementById('sgst_taxes').value);			// changes in 14-11-17
		var new_sgst_tax=parseFloat((sgst+100)/100);
		var sgst_taxable_value = parseInt(amount_paid / new_sgst_tax);
		var sgast_tax =parseInt(amount_paid - sgst_taxable_value);*/
		sgast_tax=parseInt(total_gst/2);
		document.getElementById('sgst_tax').value=sgast_tax;
		//=========================================================================
		var new_tax=new_total_tax//parseFloat(new_cgst_tax)+parseFloat(new_sgst_tax); // changes in 14-11-17
		total_paid=parseFloat(amount_paid)-parseFloat(cgast_tax)-parseFloat(sgast_tax);
		document.getElementById('total_paid_gst').value=total_paid;
		document.getElementById('refund_amnt').value=total_paid;
		var add_amount=parseInt(document.getElementById('add_amnt').value);
		var total_add_amount=parseInt(total_paid+add_amount);
		var sub_amount=parseInt(document.getElementById('sub_amnt').value);
		var total_sub_amount=parseInt(total_add_amount-sub_amount);		
		//alert(total_sub_amount);
		document.getElementById('total_refund').value=total_sub_amount;
		
	}
</script>
<style type = "text/css">
	#feedback{
    	line-height:;
    }
	.obrderclass{ border:1px solid #f00}
</style>  
<script type="text/javascript">
	function show() { document.getElementById('payment').style.display = 'block'; $('#pay_type').removeClass("obrderclass");  }
    function hide() { document.getElementById('payment').style.display = 'none'; $('#pay_type').removeClass("obrderclass");  }
</script>
      
<script>
function validme()
{
	frm = document.frmTakeAction;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
 
	if($('#payment_type').val() =="select")
	{
		disp_error +='Payment mode not selected \n'; 
		$('#payment_type').addClass("obrderclass"); 
		error='yes';
	}
	else
	{
		pay_value=$('#payment_type').val();
		pay_type=pay_value.split('-');
		payment_types=pay_type[0];
		
		$('#payment_type').removeClass("obrderclass"); 
		/*var selected = $("input[name=payment_type]:checked");
			if (selected.length > 0) {
				selectedVal = selected.val();*/
		if(payment_types =='cheque')
		{
			if(frm.cust_bank_name.value=='')
			{
				disp_error +='Select Customer  bank name \n';
				 error='yes';
				 document.getElementById('cust_bank_name').style.border = '1px solid #f00';
				 frm.cust_bank_name.focus();
			}
			if(frm.bank_name.value=='select')
			{
				disp_error +='Select ISAS bank name \n';
				 error='yes';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
			}
			if(frm.account_no.value=='')
			{
				disp_error +='Enter Account Number of ISAS bank \n';
				 error='yes';
				 document.getElementById('account_no').style.border = '1px solid #f00';
				 frm.account_no.focus();
			}
			if(frm.chaque_no.value=='')
			{
				disp_error +='Cheque Number is blank \n';
				 error='yes';
				  document.getElementById('chaque_no').style.border = '1px solid #f00';
				 frm.chaque_no.focus();
			}
			if(frm.chaque_date.value=='')
			{
				disp_error +='Cheque date is blank \n';
				 error='yes';
				 $('#chaque_date').addClass("obrderclass"); 
				 frm.chaque_date.focus();
			}
		}
		else if(payment_types =='Credit Card')
		{
			if(frm.cust_bank_name.value=='')
			{
				disp_error +='Select Customer  bank name \n';
				 error='yes';
				 document.getElementById('cust_bank_name').style.border = '1px solid #f00';
				 frm.cust_bank_name.focus();
			}
			if(frm.bank_name.value=='select')
			{
				disp_error +='Select ISAS bank name \n';
				 error='yes';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
			}
			if(frm.account_no.value=='')
			{
				disp_error +='Enter Account Number of ISAS bank \n';
				 error='yes';
				 document.getElementById('account_no').style.border = '1px solid #f00';
				 frm.account_no.focus();
			}
			if(frm.credit_card_no.value=='')
			{
				disp_error +='Enter Credit Card Number \n';
				 error='yes';
				 document.getElementById('credit_card_no').style.border = '1px solid #f00';
				 frm.credit_card_no.focus();
			}
		}
		else if(payment_types =='online')
		{
			if(frm.bank_ref_no.value=='')
			{
				disp_error +='Enter Bank Reference Number \n';
				error='yes';
				document.getElementById('bank_refc_no').style.border = '1px solid #f00';
				frm.bank_ref_no.focus();
			}
			if(frm.cust_bank_name.value=='')
			{
				disp_error +='Enter Bank Name \n';
				error='yes';
				document.getElementById('cust_bank_name').style.border = '1px solid #f00';
				frm.cust_bank_name.focus();
			}
		}
	}
	// alert(error);
	if(error=='yes')
	{
		alert(disp_error);
		//calculate_total($("#amount_paid").val(),1);
		return false;
	}
	else
	{
	}
	// return true;
}
	 
function show_payment(value) 
{
	payment_mode=value.split("-")
	//alert(payment_mode[0]);
	var branch_name=document.getElementById("branch_name").value;
	if(payment_mode[0]=="cheque")
	{
		document.getElementById("chaque_details").style.display = 'block';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		
		show_bank(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("bank_ref_no").style.display = 'none';
		
		show_bank(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		
		show_bank(branch_name,"paytm")
	}
	else if(payment_mode[0]=="online")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		
		show_bank(branch_name,"online")
	}
	else if(payment_mode[0]=="Bajaj Finance Loan")
	{
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		
		show_bank(branch_name,"bajaj_finance_loan")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		
		show_bank(branch_name,"")
	}
}	
function show_acc_no(bank_id)
{
	//alert(bank_id);
	var data1="action=show_account&bank_id="+bank_id;
	//alert(data1);
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		document.getElementById('account_no').value=html;
	}
	});
}
function show_bank(branch_id,vals)
{
	record_id= document.getElementById("record_id").value;
	var bank_data="action=enroll&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data);
	$.ajax({
	url: "show_bank.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		document.getElementById("bank_id").innerHTML=retbank;
		if(document.getElementById("bank_name").value)
		{
			//alert(document.getElementById("bank_name").value);
			var bank_ids=document.getElementById("bank_name").value;
			show_acc_no(bank_ids)
		}
	}
	});
	
	var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		installment_tax= taxes[1];
		cgst=taxes[2];
		sgst=taxes[3];
		//document.getElementById("service_tax_id").innerHTML=service_tax;
		//document.getElementById("inst_tax_id").innerHTML=installment_tax;
		document.getElementById("cgst_id").innerHTML=cgst;
		document.getElementById("sgst_id").innerHTML=sgst;
		
		//document.getElementById("service_taxes").value=service_tax;
		//document.getElementById("inst_taxes").value=installment_tax;
		document.getElementById("cgst_taxes").value=cgst;
		document.getElementById("sgst_taxes").value=sgst;
		//alert("service tax- "+service_tax);
		//course_id1 =document.getElementById("course_id").value;
		//alert(document.getElementById("service_taxes").value);
	}
	});
	show_staff(branch_id,admin_id);
}
function show_staff(branch_id,admin_id)
{
	var record_id= document.getElementById("record_id").value;
	var bank_data="action=enrollment&branch_id="+branch_id+"&record_id="+record_id+"&admin_id="+admin_id;
	$.ajax({
	url: "show_councellor.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		//alert(retbank);
		document.getElementById("employee_id").innerHTML=retbank;
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
    					<?php
    						if($_POST['save_changes'])
                        	{
								$enroll_id=$_REQUEST['record_id'];
								$invoice_id=$_REQUEST['invoice_id'];
								$course_id=$_POST['course_id'];
								$reason=$_POST['reason'];
                            	$refund_amnt=$_POST['amount_paid'];
								$cgst_tax= $_POST['cgst_tax'];
								$cgst_tax_in_per= $_POST['cgst_taxes'];
								$sgst_tax= $_POST['sgst_tax'];
								$sgst_tax_in_per= $_POST['sgst_taxes'];
								
								$amount_without_tax=$_POST['refund_amnt'];
								$add_amnt=$_POST['add_amnt'];
								$add_amnt_desc=$_POST['add_amnt_desc'];
								
								$sub_amnt=$_POST['sub_amnt'];
								$add_sub_desc=$_POST['add_sub_desc'];
								
								$total_refund=$_POST['total_refund'];
								$cm_id=$_POST['cm_id'];
                             	$cm_id_branch=$_POST['cm_id_branch'];
								
								$added_date=$_POST['added_date'];
								$ad_date=explode('/',$added_date,3);
								$added_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0]." ".date('H:i:s');
								
								
								if($_POST['invoice_due_date'] !=''){
									$ad_date1=explode('/',$_POST['invoice_due_date'],3);
									$invoice_date=$ad_date1[2].'-'.$ad_date1[1].'-'.$ad_date1[0];
								}
								else $invoice_date=date('Y-m-d');
								
								$payment_mode=$_POST['payment_type'];
								$sep=explode("-",$payment_mode);
								$payment_type=$sep[1];
								$payment_type_val=$sep[0];
								
								$bank_name='';
								$cust_bank_name='';
								$credit_card_no='';
								$chaque_no='';
								$chaque_date='';
								$bank_ref_no='';
								if($payment_type_val !="cash" && $_POST['cust_bank_name']!='')
								{
									$bank_name= $_POST['bank_name'];
									$cust_bank_name=$_POST['cust_bank_name'];
									$credit_card_no=$_POST['credit_card_no'];
									$chaque_no=$_POST['chaque_no'];
									$chaque_date=$_POST['chaque_date'];
									$bank_ref_no=$_POST['bank_ref_no'] ? $_POST['bank_ref_no'] : "";		
								}
								$sel_branch_name="select branch_name from site_setting where cm_id=$cm_id_branch";
								$ptr_branch=mysql_query($sel_branch_name);
								$data_branch=mysql_fetch_array($ptr_branch);
								$branch_name=$data_branch['branch_name'];
								
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								{
									$data_record['cm_id']=$cm_id_branch;
									$branch_name1=$branch_name;
									$cm_id1=$cm_id_branch;
								}	
								else
								{
									$data_record['cm_id']=$_SESSION['cm_id'];
									$branch_name1=$_SESSION['branch_name'];
									$cm_id1=$_SESSION['cm_id'];
								}
								
								
								if($record_id)
								{
									$sel_recpt="select receipt_no from invoice where cm_id='".$cm_id1."' and invoice_id='".$invoice_id."' and receipt_no IS NOT NULL order by invoice_id desc limit 0,1";
									$ptr_recpt=mysql_query($sel_recpt);
									$data_receipt=mysql_fetch_array($ptr_recpt);
									
									$recp=explode("-",$data_receipt['receipt_no']);
									$recpt_no=intval($recp[1])+1;
									$pre='';
									if($cm_id1=='2')
									{
										$pre="PUN-";
									}
									else if($cm_id1=='60')
									{
										$pre="AHM-";
									}
									else if($cm_id1=='115')
									{
										$pre="PCMC-";
									}
									$receipt_no=$pre.$recpt_no;
									
									$insert_new_invoice = "INSERT INTO `enrollment_refund` (`enroll_id`, `invoice_id`,`course_id`, `refund_amount`,`amount_without_tax`, `addition_amount`,`addition_amount_desc`,`substraction_amount`,`substract_amount_desc`,`total_refund`,`cgst_tax_in_per`, `cgst_tax`,`sgst_tax_in_per`, `sgst_tax`,`reason`,`paid_type`, `cust_bank_name`,`bank_name`, `cheque_detail`, `chaque_date`, `credit_card_no`,`bank_ref_no`,`admin_id`, `added_date`,`cm_id`,`invoice_date`) VALUES ('".$enroll_id."','".$invoice_id."', '".$course_id."', '".$refund_amnt."','".$amount_without_tax."','".$add_amnt."','".$add_amnt_desc."', '".$sub_amnt."', '".$add_sub_desc."','".$total_refund."','".$cgst_tax_in_per."','".$cgst_tax."','".$sgst_tax_in_per."','".$sgst_tax."','".$reason."','".$payment_type."','".$cust_bank_name."', '".$bank_name."', '".$chaque_no."', '".$chaque_date."','".$credit_card_no."', '".$bank_ref_no."','".$_SESSION['admin_id']."', '".$added_date."','".$cm_id1."','".$invoice_date."'); ";
									$ptr_installments_invoice = mysql_query($insert_new_invoice);									
									$invoice_id = mysql_insert_id();
									
									$update_inv="update invoice set status='Refund' where invoice_id='".$invoice_id."'";
									$ptr_update=mysql_query($update_inv);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('refund_payment','Add','".$_POST['name']."','".$invoice_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  
								
									//========================================================================================================
									if($payment_type=='2' || $payment_type=='4' || $payment_type=='5')
							    	{
							   			$bank="INSERT INTO `bank_records`(`bank_id`, `type`, `record_id`,`invoice_id`, `amount`, `added_date`, `cm_id`, `admin_id`) VALUES ('".$bank_name."','expense','".$record_id."','".$invoice_id."','".$amount_paid."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							   			$bank_query=mysql_query($bank);  
									}
								
									?>
                                	<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record Added Successfully</p></center></div>
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
									//setTimeout('document.location.href="invoice-summary.php?record_id=<?php echo $record_id; ?>";',1000);
                            		</script>
                                	<?php
									//unset($_SESSION['rand']);
								
								/*if($payment_type_val=="online")
								{*/
									?>
                                    <!--<div style="display:none;">
									<form method="post" name="customerData" action="ccavRequestHandler1.php">
									<table width="40%" height="100" border='1' align="center" style="display:none">
									<caption><font size="4" color="blue"><b>Integration Kit</b></font></caption>
									</table>
										<table width="40%" height="100" border='1' align="center">
											<tr>
												<td>Parameter Name:</td><td>Parameter Value:</td>
											</tr>
											<tr>
												<td colspan="2"> Compulsory information*</td>
											</tr>
											<tr>
												<td>TID	:</td><td><input type="hidden" name="tid" id="tid" value="<? //echo rand(0, 9999999999); ?>" readonly/></td>
											</tr>
											<tr>
												<td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="73035"/></td>
											</tr>
											<tr>
												<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<? //echo $invoice_id; ?>"/></td>
											</tr>
											<tr>
												<td>Amount	:</td><td><input type="hidden" name="amount" value="<? //echo $amount_paid; ?>"/></td>
											</tr>
											<tr>
												<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>
											</tr>
											<tr>
												<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="http://www.isasbeautyschool.com/faculty_login/ccavResponseHandler.php"/></td>
											</tr>
											<tr>
												<td>Cancel URL	:</td><td><input type="hidden" name="cancel_url" value="http://www.isasbeautyschool.com/faculty_login/ccavResponseHandler.php"/></td>
											</tr>
											<tr>
												<td>Language	:</td><td><input type="hidden" name="language" value="EN"/></td>
											</tr>
											<tr>
												<td colspan="2">Billing information(optional):</td>
											</tr>
											<tr>
												<td>Billing Name	:</td><td><input type="hidden" name="billing_name" value="<? //echo $data_select1['name']; ?>"/></td>
											</tr>
											<tr>
												<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="<? //echo $data_select1['address']; ?>"/></td>
											</tr>
											<tr>
												<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="<? //echo $branch_name1; ?>"/></td>
											</tr>
											<tr>
												<td>Billing State	:</td><td><input type="hidden" name="billing_state" value="MH"/></td>
											</tr>
											<tr>
												<td>Billing Zip	:</td><td><input type="hidden" name="billing_zip" value="412207"/></td>
											</tr>
											<tr>
												<td>Billing Country	:</td><td><input type="hidden" name="billing_country" value="India"/></td>
											</tr>
											<tr>
												<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<? //echo $data_select1['contact']; ?>"/></td>
											</tr>
											<tr>
												<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<? //echo $data_select1['mail'] ; ?>"/></td>
											</tr>
											<tr>
												<td colspan="2">Shipping information(optional)</td>
											</tr>
											<tr>
												<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<? //echo $data_select1['name']; ?>"/></td>
											</tr>
											<tr>
												<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value="<? //echo $data_select1['address']; ?>"/></td>
											</tr>
											<tr>
												<td>shipping City	:</td><td><input type="hidden" name="delivery_city" value="<? //echo $branch_name1; ?>"/></td>
											</tr>
											<tr>
												<td>shipping State	:</td><td><input type="hidden" name="delivery_state" value="Andhra"/></td>
											</tr>
											<tr>
												<td>shipping Zip	:</td><td><input type="hidden" name="delivery_zip" value="425001"/></td>
											</tr>
											<tr>
												<td>shipping Country	:</td><td><input type="hidden" name="delivery_country" value="India"/></td>
											</tr>
											<tr>
												<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<? //echo $data_select1['contact']; ?>"/></td>
											</tr>
											
											<tr>
												<td>Vault Info.	:</td><td><input type="hidden" name="customer_identifier" value=""/></td>
											</tr>
											<tr>
												<td>Integration Type:</td><td><input type="hidden" name="integration_type" value="iframe_normal"/></td>
											</tr>
											<tr>
												<td></td>
                                                <script>
												document.customerData.submit();
												</script>>
												
											</tr>
										</table>
									  </form>
                                      </div>-->
                                      <?php
								/*}
								else
								{*/
								?>
                                	<!--<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Payment Added Successfully</p></center></div>
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
										setTimeout('document.location.href="invoice-summary.php?record_id=<?php //echo $record_id; ?>";',1000);
                            		</script>-->
                                <?php
								//}
								
									/*$db->query_insert("installment",$data_record,$where_record);
									echo '<div id="msgbox" style="width:40%;"><div>Payment added successfully</center>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="invoice-summary.php">Back</a>
									</div>
									</div>';*/
									
									
									
									
									/*$insert_into_invoice= "INSERT INTO `invoice` (`course_id`, `admin_id`, `bank_name`, `cheque_detail`, `chaque_date`, `online_transc_details`, `amount`, `paid_type`, `added_date`, `enroll_id`,`installment_id`) VALUES ('".$data_record['course_id']."', '".$_SESSION['admin_id']."', '', '', '', '', '".$_POST['amount_paid']."', 'cheque', '".date('Y-m-d H:i:s')."','$enroll_id','$installment_id')";
									$ptr_isert_invp = mysql_query($insert_into_invoice);
									*/
								}
								else
								{
								 // $db->query_insert("pay_balace_bill_mapping", $data_college);
								 //  echo '<div id="msgbox" style="width:40%;">Supplier added successfully</center></div>';
								}
								$success=1;
								
								
                            	
                        	}
                            else
							{
								//echo "Record Not Saved";
							}
                         	?>       
                                
                                
                                <form method="get" name="jqueryForm" id="jqueryForm">
                                    
                                </form>
                         
                      <?php
                      if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
                      {
                  		$pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
                        /*$sql_previos_total= "SELECT sum(amount) as credits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Credit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                        $row_previos_total=$db->fetch_array($db->query($sql_previos_total));

                        $sql_previos_total1= "SELECT sum(amount) as debits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Debit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
                        $row_previos_total1=$db->fetch_array($db->query($sql_previos_total1));
                        $balance=$row_previos_total['credits']-$row_previos_total1['debits'];*/
                      }
                      else
                      {
                      	$balance=0;
                        $pre_from_date="";                            
                      }
                      $sql_records= "SELECT * FROM invoice where invoice_id=".$invoice_id." ".$pre_from_date." ".$pre_to_date." order by invoice_id desc limit 0,1 ";
					  $all_records = mysql_query($sql_records);
                      $no_of_records=mysql_num_rows($db->query($sql_records));
                      if($no_of_records)
                      {
                      		$bgColorCounter=1;
                        	if(!$_SESSION['showRecords'])
                            $_SESSION['showRecords']=10;
							?>
                            <form method="post" name="frmTakeAction" id="add_payment_form" onSubmit="return validme();">
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
                                                   <!-- <td width="70%" align="right"><a href="javascript:void(0);" onClick="window.open('csvcompany_manage.php','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no'); return false;" ><img src="images/csv.png" border="0"/></a>
    
    <img src='images/view.jpeg' title='View Invoice' border='0' 
	onclick="window.open('invoice-generate-company.php')" style='cursor:pointer' > 
    <img src='images/print1.jpeg'
								onclick="window.open('invoice-generate-company.php?action=print','View Invoice')" style='cursor:pointer'title='Print Invoice' border='0'>
                                            </td>-->
                                                    <td height="2" align="right"></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    
                                    <tr>
                                    	<td valign="top" colspan="2">
                                        <input type="hidden" name="record_id" id="record_id" value="<?php echo $_GET['record_id']; ?>"  />
                                       <table cellspacing="1"  cellpadding="5" style="width: 90%;" align="center">
										<?php
										while($val_record=mysql_fetch_array($all_records))
										{
											if($bgColorCounter%2==0)
												$bgcolor='class="grey_td"';
											else
												$bgcolor=""; 
											 $enroll_id=$val_record['enroll_id'];
											 $paid_totas=0;
											/*if($bgColorCounter%2==0)
												$bgclass="tr-sub_white1";
											else
												$bgclass="tr-sub1";*/
											include "include/paging_script.php";
											if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
											{
												?>
												<tr>
												<td>Select Branch</td>
												<td>
												<?php
												$sel_cm_id="select branch_name from site_setting where cm_id=".$val_record['cm_id']." ";
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
												<?php 
											}
											else 
											{ 
												?>
                                       			<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                                       			<?php 
											}
											$sel_inst1= "select * from installment where enroll_id=".$record_id." order by installment_id asc limit 0,1 ";
											$ptr_inst=mysql_query($sel_inst1);
											$data_inst1=mysql_fetch_array($ptr_inst);
											
											//=========================For prevent to save multiple entries================
												$rand=rand();
												$_SESSION['rand']=$rand;
											//=============================================================================
											?>
											<tr>
                                                <td width="20%">Invoice Date<span class="orange_font">*</span></td>
                                                <td width="49%"><input type="text" id="invoice_due_date" readonly="readonly" name="invoice_due_date" class="input_text datepicker" value="<?php if($_POST['invoice_due_date']) echo $_POST['invoice_due_date']; else if($data_inst1['installment_date']!=''){$arrage_date= explode('-',$data_inst1['installment_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
                                                </td>
                                            </tr>
                                           	<?php
                                        	
                                        	//echo '<td align="center">'.$sr_no.'</td>';	?>
                                            <tr>
												<td width="20%">Date<span class="orange_font">*</span></td>
												<td width="49%"><?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>
                                            <input type="hidden" id="added_date" name="added_date" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
												</td>
											</tr> <?php
										
											echo " <td><strong>Enrollment No.</strong></td><td align='left'>".$val_record['enroll_id']."</td></tr>";
											echo '<input type="hidden" name="invoice_no" id="invoice_no" value='.$val_record['enroll_id'].'>';
										
											$name ='';
											$email_id = '';
											$phone_no ='';
					
									  		$select_firstname = " select * from enrollment where enroll_id='".$val_record['enroll_id']."' ";
									  		$ptr_query=mysql_query($select_firstname);
											$data_select = mysql_fetch_array($ptr_query);
										
											echo '<tr><td><strong>Student Name</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['name'].'
											<input type="hidden" name="cm_id_branch" id="cm_id_branch" value='.$data_select['cm_id'].'><input type="hidden" name="mail" id="mail" value='.$data_select['mail'].'><input type="hidden" name="name" id="name" value='.$data_select['name'].'></td></tr>';
											echo '<tr><td><strong>Course Name</strong></td><td align="left">'.$course_name.' <input type="hidden" name="course_id" id="course_id" value='.$data_select['course_id'].'></td></tr>';
                                        	
										   	?> 
                                            <tr>
                                            	<td width="37%"><strong>Select Reason</strong></td>
                                                <td width="63%" align="left">
                                               	<select name="reason" id="reason" class="input_select">
                                                    <option value="">Select Reason</option>
                                                    <option value="Not Intrested">Not Intrested</option>
                                                    <option value="Institute Problem">Institute Problem</option>
                                                    <option value="Family Issue">Family Issue</option>
                                                    <option value="Medical Issue">Medical Issue</option>
                                                </select>
                                                </td>
                                            </tr>
											<tr> 
                                            	<td width="37%"><strong>Refund Amount</strong></td><td width="63%" align="left"><input type="text" name="amount_paid" id="amount_paid" class="input_text" onKeyUp="calculate_total(this.value,0)" value="<?php echo $val_record['amount']; ?>" > </td></tr>
											<tr>      
												<td width="20%" class="heading">CGST<span id="cgst_id"><?php if($val_record['cgst_tax_in_per']) echo $val_record['cgst_tax_in_per']; else if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="cgst_taxes" name="cgst_taxes" value="<?php if($val_record['cgst_tax_in_per']) echo $val_record['cgst_tax_in_per']; else if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?>"  />
											  	<td><input type="text" class="validate[required] input_text" readonly="readonly" name="cgst_tax" id="cgst_tax"  value="<?php if($_POST['cgst_tax']) echo $_POST['cgst_tax']; else echo $val_record['cgst_tax'];?>" /></td>
											</tr>
											<tr>      
												<td width="20%" class="heading">SGST<span id="sgst_id"><?php  if($val_record['sgst_tax_in_per']) echo $val_record['sgst_tax_in_per']; else if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="sgst_taxes" name="sgst_taxes" value="<?php if($val_record['sgst_tax_in_per']) echo $val_record['sgst_tax_in_per']; else if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?>"  />
											  	<td><input type="text" class="validate[required] input_text" readonly="readonly" name="sgst_tax" id="sgst_tax"  value="<?php if($_POST['sgst_tax']) echo $_POST['sgst_tax']; else echo $val_record['sgst_tax'];?>" /></td>
											</tr>
                                            <tr>
                                            	<td width="37%">Total</td>
                                                <td width="63%" align="left"><input type="text" class="validate[required] input_text" name="refund_amnt" id="refund_amnt" readonly="readonly"></td>
                                            </tr>
                                            <tr>
                                            	<td width="30%">Adjustment +</td>
                                                <td width="30%" align="left"><input type="text" class="validate[required] input_text" name="add_amnt" id="add_amnt" onKeyUp="calculate_total()" value="0" > </td>
                                                <td width="40%"><textarea placeholder="Enter description of addition amount" style="width:200px; height:70px" name="add_amnt_desc" id="add_amnt_desc" class="input_textarea"></textarea></td>
                                            </tr>
											<tr>
                                            	<td width="30%">Adjustment -</td>
                                                <td width="30%" align="left"><input type="text" class="validate[required] input_text" name="sub_amnt" id="sub_amnt" onKeyUp="calculate_total()" value="0" > </td>
                                                <td width="40%"><textarea placeholder="Enter description of deduction amount" style="width:200px; height:70px" name="add_sub_desc" id="add_sub_desc" class="input_textarea"></textarea></td>
                                            </tr>
                                            <tr>
                                            	<td width="37%">Total Refund Paid</td>
                                                <td width="63%" align="left"><input type="text" name="total_refund" id="total_refund" class="validate[required] input_text" value="" > </td>
                                            </tr>
											<tr>
												<!-- <td width="20%" class="heading">Total Paid </td>-->
												<td><input type="hidden" class="validate[required] input_text" readonly="readonly" name="total_paid_gst" id="total_paid_gst"  value="<?php if($_POST['total_paid_gst']) echo $_POST['total_paid_gst']; else echo $val_record['total_paid_gst'];?>" /></td>
											</tr>
                                        	<tr>
                                          		<td width="20%" class="heading">Select Payment Mode<span class="orange_font">*</span></td>
                                            	<td><select name="payment_type" id="payment_type" onChange="show_payment(this.value)">
                                            	<option value="select">--Select--</option>
												<?php
                                                $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
                                                $ptr_payment_mode=mysql_query($sel_payment_mode);
                                                while($data_payment=mysql_fetch_array($ptr_payment_mode))
                                                {
                                                    $selected='';
                                                    if($data_payment['payment_mode_id'] == $row_expense['payment_mode_id'])
                                                    {
                                                        $selected='selected="selected"';
                                                    }
                                                    echo '<option '.$selected.' value="'.$data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
                                                }
                                                ?>
                                            	</select></td>
                                           	</tr>
                                           	<tr>
                                           		<td colspan="3">
                                                <div id="bank_ref_no" <?php if($_POST['payment_type'] =='online-5') echo 'style="display:block"'; else if($val_record['paid_type'] =='5') echo 'style="display:block"';  else echo 'style="display:none"'; ?>>
													<table width="100%">
														<tr>
															<td width="21%" class="tr-header" align="">Ref. no<span class="orange_font">*</span></td>
															<td width="35%"><input type="text" name="bank_ref_no" id="bank_refc_no" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $data_invoice['bank_ref_no']; ?>"/></td>
														</tr>
													</table>
												</div>
                                             	<div id="bank_details" style="display:none">
                                             	<table width="100%">
                                             		<tr>
                                             			<td width="62%" class="tr-header" align="">Customer Bank Name<span class="orange_font">*</span></td>
                                             			<td width="20%" style="vertical-align:bottom">
                                              			<input type="text" name="cust_bank_name" id="cust_bank_name" value="<?php if($_POST['cust_bank_name']) echo $_POST['cust_bank_name']; else echo $row_record['cust_bank_name']; ?>"/>
                                             			</td>
                                              			<td width="20%" class="tr-header" align=""> ISAS Bank Name : &nbsp; 
                                              			<?php 
											  			/*if($_SESSION['type'] !="S")
											  			{
											  			?>
                                              				<select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">
                                             				<option value="select">--Select--</option>
                                             				<?php
                                             				$sle_bank_name="select bank_id,bank_name from bank ".$_SESSION['where_cm_id'].""; 
                                             				$ptr_bank_name=mysql_query($sle_bank_name);
                                             				while($data_bank=mysql_fetch_array($ptr_bank_name))
                                             				{
                                                				$selected='';
                                                				if($data_bank['bank_id'] == $row_invoice['bank_name'])
                                                				{
                                                    				$selected='selected="selected"';
                                                				}
                                                 				echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
                                             				}
                                             				?>
                                             				</select>
                                            				<?php
                                             			}*/
											 			?>
                                             			<div id="bank_id"></div>
                                             			</td>
                                             			<td width="20%" class="tr-header" align=""> ISAS Account No : &nbsp; 
                                              			<input type="text" name="account_no" readonly id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $row_record['account_no']; ?>"/>
                                            			</td>
                                             		</tr>
                                             	</table>
                                             	</div>
                                             	</td>
                                           	</tr>
                                            <tr>
                                            	<td colspan="2">
                                            	<div id="chaque_details" style="display:none" <?php  //if($row_invoice=='cheque' || $_POST['payment_type'] =='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                                             		<table width="100%">
                                                		<tr>
                                                			<td width="37%">Customer Cheque No.</td>
                                                        	<td><input type="text" name="chaque_no" id="chaque_no"  class="validate[required] input_text"  value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_invoice['chaque_no'];?>" onKeyPress="return isNumber(event)" maxlength="6"/></td>
                                                		</tr>
                                                 		<tr>
                                                 			<td>Customer Cheque Date</td>
                                                 			<td><input type="text" name="chaque_date" id="chaque_date"  class="datepicker" placeholder="cheque date " value="<?php if($_POST['save_changes']) echo $_POST['chaque_date']; else echo $chaque_date ;?>"/></td>
                                                 		</tr>
                                            		</table>
                                            	</div>
                                            	<div id="credit_details" style="display:none">
                                            		<table width="100%">
                                             			<tr>
                                             				<td width="37%" class="tr-header" align="">Enter Credit Card No</td>
                                             				<td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_invoice['credit_card_no']; ?>" /></td>
                                             			</tr>
                                             		</table>
                                            	</div>
                                            	</td>
                                       		</tr>       
                                        	<!--<tr>
                                            	<td width="22%">Assigned to<span class="orange_font"></span></td>
                                            	<td width="44%"><select id="employee_id" name="employee_id" >
                                            	<option value="">--Select Staff--</option>
                                            	
                                            	</select>
                                                </td>
                                            	<td width="34%"></td>
                                        	</tr> -->                                                                                                                       
											<!--<tr><td colspan="2"><strong>Installments</strong></td></tr>		-->
                                        	<!--<tr>
                                        		<td colspan="2">
                                        			<table width="95%" align="center">
                                        				<tr>
                                        					<td>
																<?php
                                                                /*$sel_inst= "select * from installment where enroll_id=".$record_id." ";
                                                                $ptr_query_inst=mysql_query($sel_inst);
                                                                $i=$data_select['no_of_installment'];
                                                                echo '<input type="hidden" name="no_of_installment" value='.$i.' id="no_of_installment" /><table width="100%" style="border:1px solid black">';
                                                                echo'<tr><td width="30%"><b>Installments</b></td><td width="20%"><b>Inst Amt</b></td><td width="25%"><b>Inst Date</b></td><td>Paid Status</td></tr>';
                                                                $j=1;
                                                                $no_of_paid__installment=0;
                                                                while($data_inst=mysql_fetch_array($ptr_query_inst))
                                                                {
                                                                    if($data_inst['status'] =='paid')
                                                                    $no_of_paid__installment=$no_of_paid__installment+1;
                                                                    $col_paid ='<font color="#006600">';
                                                                    if($data_inst['status'] =='not paid')
                                                                    $col_paid ='<font color="#FF3333">';
                                                                    echo '<input type="hidden" name="course_id" value="'.$data_inst['course_id'].'" id="course_id" />';
                                                                    echo'<tr><td width="15%"><b>Installment '.$j.'</b></td><td width="15%"><input type="hidden" name="inst_original_'.$j.'" id="inst_original_'.$j.'" value="'.$data_inst['installment_amount'].'"><input type="hidden" name="inst_'.$j.'" id="inst_'.$j.'" value="'.$data_inst['installment_amount'].'"><span id=int_id_'.$j.'>'.$data_inst['installment_amount'].'</span></td><td width="15%"><input type="hidden" name="inst_date'.$j.'" id="inst_date'.$j.'" value="'.$data_inst['installment_date'].'">'.$data_inst['installment_date'].'</td><td>'.$col_paid.$data_inst['status'].'</font></td></tr>';
                                                                    $j++;
                                                                    $i--;
                                                                }
                                                                echo '</table>';
                                                                echo '<input type="hidden" name="no_of_paid_installment" value="'.$no_of_paid__installment.'" id="no_of_paid_installment" />';*/
                                                                ?>
                                                                
                                                            </td>
                                        				</tr>
                                        			</table>
                                        		</td>
                                        	</tr>-->
                                            <!--<tr>
                                            	<td width="37%"><strong>Adjustment <br/>(add + or - sign before amount)</strong></td><td align="left"  width="63%"> <div id="avail_balance_show"><?php //echo $data_select['balance_amt']; ?></div><input type="hidden" name="adjustment" id="adjustment" /> </td></tr>
                                        	<tr>
								 			<tr>
                                            	<td width="37%"><strong>Total</strong></td><td align="left"  width="63%"> <div id="avail_balance_show"><?php //echo $data_select['balance_amt']; ?></div><input type="hidden" name="avail_balance" id="avail_balance" /> </td></tr>-->
                                            <tr>
                                            	<td colspan="2" align="center"> <input type="submit" name="save_changes" value="Add Payment" class="add_submit_button"/></td>
                                        	</tr>
                                        	<?php
                                       		$bgColorCounter++;
                                    	}
                                    	?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td height="10"></td>
                            </tr>
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
                                        <td align="right"></td>
                                    </tr>
                                </table>
                            </td></tr>
                        </table>
					</form><?php
				}
				else if($_GET['search'])
					echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
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
<script>
<?php
if($record_id || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
{
	?>
	//vals= document.getElementById("amount_paid").value;
	//alert('hello');
	setTimeout(calculate_total(),5000);
	
	<?php
}
?>
</script>
<!--info end-->
<div class="clearit"></div> 
 <noscript>
  Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>