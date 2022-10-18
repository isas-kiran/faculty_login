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
<title>add Customer Service Payment</title>
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
           
    $(document).ready(function()
    {            
        $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',
        maxDate: '+2Y',});
    });
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
      
      <script type="text/javascript">
	  function calculate_total(amount_paid)
	  {
		  //alert(amount_paid)
		 if(amount_paid == "")
			amount_paid = 0;
			
			var balance_amount= document.getElementById('balance_amount').value;
			//alert(balance_amount);
			amount_paid_id=parseInt(amount_paid); 
			//alert(amount_paid_id);
			remaining_amt = parseInt(balance_amount) - parseInt(amount_paid_id);
			//alert(remaining_amt);
			
			var total_remaining = parseInt(balance_amount);// - parseInt(amount_to_be_paid);
			if(total_remaining-parseInt(amount_paid_id)<0)
			{
				alert("Invalid input.");
				document.getElementById('amount_paid').value=0;
				return false;
			} 
			
			document.getElementById('remaining_amount').value=remaining_amt;		
		    document.getElementById('avail_balance_show').innerHTML = remaining_amt;
	  }
	  </script>
	  
	  <script>
	  mail1=Array();
	<?php
	$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='112'";
	$ptr_sel_sms=mysql_query($sel_sms_cnt);
	$tot_num_rows=mysql_num_rows($ptr_sel_sms);
	$i=0;
	while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
	{
		"<br/>".$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
		$ptr_cnt=mysql_query($sel_act);
		if(mysql_num_rows($ptr_cnt))
		{
			$data_cnt=mysql_fetch_array($ptr_cnt);
			?>
			mail1[<?php echo $i; ?>]='<?php echo  $data_cnt['email'];?>';
			<?php
			$i++;
		}
	}
	if($_SESSION['type']!='S')
	{
		"<br/>".$sel_act="select contact_phone,email from site_setting where type='S'";
		$ptr_cnt=mysql_query($sel_act);
		if(mysql_num_rows($ptr_cnt))
		{
			$j=$tot_num_rows;
			while($data_cnt=mysql_fetch_array($ptr_cnt))
			{
				?>
				mail1[<?php echo $j; ?>]='<?php echo  $data_cnt['email'];?>';
				<?php
				$j++;
			}
		}
	}
	"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='112'";
	$ptr_mail_text=mysql_query($sel_mail_text);
	if($tot_mail_text=mysql_num_rows($ptr_mail_text))
	{
		$data_mail_text=mysql_fetch_array($ptr_mail_text);
		?>
		email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
		<?php
	}
	?>
function send()
{								  
	branch =document.getElementById('branch_name');
	var branch_name=branch.options[branch.selectedIndex].text; 
	var invoice_no =document.getElementById('invoice_no').value;
	var customer_name=document.getElementById('cm_id_branch').value;
	var total=document.getElementById('total').value;
	var discount =document.getElementById('discount').value;
	var final_amt =document.getElementById('final_amt').value;
	var total_paid_amt =document.getElementById('total_paid_amt').value;
	var balance_amount =document.getElementById('balance_amount').value;
	var amount_paid =document.getElementById('amount_paid').value;
	m =document.getElementById('payment_type');
	var payment_type=m.options[m.selectedIndex].text;
	var cust_bank_name =document.getElementById('cust_bank_name').value;
	var bank =document.getElementById('bank_name');
	var bank_name=bank.options[bank.selectedIndex].text;
	var account_no =document.getElementById('account_no').value;
	var chaque_no =document.getElementById('chaque_no').value;
	var chaque_date =document.getElementById('chaque_date').value;
	var credit_card_no =document.getElementById('credit_card_no').value;
	var remaining_amount =document.getElementById('remaining_amount').value;
	var users_mail=mail1;
      data1='action=add_payment_service&branch_name='+branch_name+'&invoice_no='+invoice_no+'&customer_name='+customer_name+'&total='+total+'&discount='+discount+'&final_amt='+final_amt+'&total_paid_amt='+total_paid_amt+'&balance_amount='+balance_amount+'&amount_paid='+amount_paid+'&payment_type='+payment_type+'&cust_bank_name='+cust_bank_name+'&bank_name='+bank_name+'&account_no='+account_no+'&chaque_no='+chaque_no+'&chaque_date='+chaque_date+'&credit_card_no='+credit_card_no+'&remaining_amount='+remaining_amount+'&users_mail='+users_mail+"&email_text_msg="+email_text_msg;
	  // alert(data1);
		
		$.ajax({
		url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
		 success: function(response)
            {
				 // alert(response);
	           return true;
            }
              }); 
			  
		           //return false;

											   
	}
										   
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
}
// alert(error);
if(error=='yes')
{
	alert(disp_error);
	calculate_total($("#amount_paid").val(),1);
	return false;
}
 else
 {
	 return send();
 }
 return true;
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
		
		show_bank(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		show_bank(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		show_bank(branch_name,"paytm")
	}
	else if(payment_mode[0]=="online")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'none';
		show_bank(branch_name,"online")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
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
	var bank_data="action=prod_payment&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
    					<?php
						
							$sel_cust_service="select customer_id, customer_service_id, service_price, nonmemb_discount, amount, total_cost, nonmemb_discount_type, payable_amount, remaining_amount, cm_id from customer_service where customer_service_id='".$record_id."'";
							$quer_cust_service=mysql_query($sel_cust_service);
							$fetch_query_cust_service=mysql_fetch_array($quer_cust_service);
						
							$select_customer = " select cust_name, cust_id, address, mobile1, email from customer where cust_id='".$fetch_query_cust_service['customer_id']."' ";
							$ptr_customer=mysql_query($select_customer);
							$data_customer = mysql_fetch_array($ptr_customer);
						
    						if($_POST['save_changes'])
                        	{
                            	$payable_amount=$_POST['amount_paid'];	
								
							 	$customer_service_id=$_GET['record_id'];
								$cm_id=$_POST['cm_id'];
                             	$cm_id_branch=$_POST['cm_id_branch'];
								
								$cust_ids=$_POST['cust_ids'];
								
								$credit_card_no=$_POST['credit_card_no'];
								$cust_bank_name=$_POST['cust_bank_name'];
								$payment_mode=$_POST['payment_type'];
								$sep=explode("-",$payment_mode);
								$payment_type=$sep[1];
								$payment_type_val=$sep[0];
								$bank_name= $_POST['bank_name'];
								$branch_name=$_POST['branch_name'];
								if($_POST['invoice_due_date'] !=''){
									$ad_date1=explode('/',$_POST['invoice_due_date'],3);
									$invoice_due_date=$ad_date1[2].'-'.$ad_date1[1].'-'.$ad_date1[0];
								}
								else $invoice_due_date=date('Y-m-d');
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
								{
									$sel_branch_name="select cm_id,branch_name from site_setting where branch_name='".$branch_name."' and type='A'";
									$ptr_branch=mysql_query($sel_branch_name);
									$data_branch=mysql_fetch_array($ptr_branch);
									
									$branch_name=$data_branch['branch_name'];
									$data_record['cm_id']=$data_branch['cm_id'];
									$branch_name1=$branch_name;
									$cm_id1=$data_record['cm_id'];
								}	
								else
								{
									$data_record['cm_id']=$_SESSION['cm_id'];
									$branch_name1=$_SESSION['branch_name'];
									$cm_id1=$_SESSION['cm_id'];
								}
								
								$data_record['admin_id']=$_SESSION['admin_id'];
								
								$data_record_update['remaining_amount'] = $_POST['remaining_amount'];
								
								if($record_id)
								{
									
									$update_cust_service="update customer_service set remaining_amount='".$_POST['remaining_amount']."', payable_amount=(payable_amount + ".$payable_amount.")  where customer_service_id='".$customer_service_id."'";
									$query_update=mysql_query($update_cust_service);
									
									if($payment_type_val=="online")
									$status='pending';
									else
									$status='paid';
									
									$chaque_date_exp=explode('/', $_POST['chaque_date']);
									$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
									
									$sel_pay="select SUM(payable_amount) as total_amnt from customer_service_invoice where customer_service_id='".$record_id."'";
									$ptr_pay=mysql_query($sel_pay);
									$data_sep=mysql_fetch_array($ptr_pay);
									$total_paid=$data_sep['total_amnt'] + $payable_amount;
									
									$sel_recpt="select receipt_no from customer_service_invoice where cm_id='".$cm_id1."' and receipt_no IS NOT NULL order by invoice_id desc limit 0,1";
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
									
									"<br/>".$insert_cust_ser_invoice = " INSERT INTO `customer_service_invoice` (`customer_service_id`,`receipt_no`,`service_price`, `total_cost`, `amount`, `payable_amount`,`remaining_amount`,`total_paid`, `paid_type`, `cust_bank_name`, `bank_id`, `cheque_detail`, `chaque_date`, `credit_card_no`, `admin_id`, `added_date`,`status`,`cm_id`,`invoice_due_date`) VALUES ('".$record_id."','".$receipt_no."', '".$fetch_query_cust_service['service_price']."', '".$fetch_query_cust_service['total_cost']."', '".$fetch_query_cust_service['amount']."', '".$payable_amount."','".$_POST['remaining_amount']."','".$total_paid."', '".$payment_type."', '".$cust_bank_name."', '".$bank_name."', '".$_POST['chaque_no']."', '".$sep_check_date."','".$credit_card_no."', '".$_SESSION['admin_id']."', '".date('Y-m-d H:i:s')."','".$status."','".$cm_id1."','".$invoice_due_date."'); ";
									$ptr_cust_ser_invoice = mysql_query($insert_cust_ser_invoice);								
									$invoice_id = mysql_insert_id();
									
									 if($payment_type=='2' || $payment_type=='4' || $payment_type=='5')
							    {
							   $bank="INSERT INTO `bank_records`(`bank_id`, `type`, `record_id`, `invoice_id`, `amount`, `added_date`, `cm_id`, `admin_id`) VALUES ('".$bank_name."','service','".$record_id."','".$invoice_id."','".$payable_amount."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							   $bank_query=mysql_query($bank);  
								}
									
									//=============SMS Send================
									$sel_cust="select cust_name,mobile1 from customer where cust_id ='".$cust_ids."'";
									$ptr_cus_name=mysql_query($sel_cust);
									$data_cust_name=mysql_fetch_array($ptr_cus_name);
									$name=$data_cust_name['cust_name'];
									$contact=trim($data_cust_name['mobile1']);
									
									$sel_inq="select sms_text from previleges where privilege_id='195'";
									$ptr_inq=mysql_query($sel_inq);
									$txt_msg='';
									if(mysql_num_rows($ptr_inq))
									{
										$dta_msg=mysql_fetch_array($ptr_inq);
										$txt_msg=$dta_msg['sms_text'];
									}
									$messagessss =$txt_msg; 
									
									
									
									$address='';
									if($branch_name1=="Pune")
									{
										$address="International School of Aesthetics and Spa, 2nd Floor, The Greens,North Main Road, Koregoan Park, Pune-411001";
									}
									else if($branch_name1=="Ahmedabad")
									{
										$address="International School of Aesthetics and Spa, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007.";
									}
									else if($branch_name1=="Baramati")
									{
										$address="International School of Aesthetics and Spa, Baramati, Email :learn@isasbeautyschool.com";
									}
									
									$sel_inq="select sms_text from previleges where privilege_id='195'";
									$ptr_inq=mysql_query($sel_inq);
									
									$messagessss =$txt_msg;
									$search_by= array("student_name");
									$replace_by = array($name);
									"<br/>".$messagessss = str_replace($search_by, $replace_by, $messagessss);
									
									send_sms_function($contact,$messagessss);
									
									"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='195' ".$_SESSION['where']."";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and type!='S' ".$_SESSION['where']."";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											//send_sms_function($data_cnt['contact_phone'],$messagessss);
										}
									}
									if($_SESSION['type']!='S')
									{
										"<br/>".$sel_act="select contact_phone from site_setting where type='S' ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											while($data_cnt=mysql_fetch_array($ptr_cnt))
											{
												//send_sms_function($data_cnt['contact_phone'],$messagessss);
											}
										}
									}
									//"<br/>".$contact."-- ".$messagessss;
									
									?>
								
                               
                                	<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Payment Added Successfully</p></center></div>
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
										setTimeout('document.location.href="cust_serv_payment_details.php?record_id=<?php echo $record_id; ?>";',1000);
                            		</script>
                                <?php
								//======================================================== END SEND MESSAGE===============================
								if($payment_type_val=="online")
								{
									?>
                                    <div style="display:none;">
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
												<td>TID	:</td><td><input type="hidden" name="tid" id="tid" value="<?php echo rand(0, 9999999999); ?>" readonly/></td>
											</tr>
											<tr>
												<td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="73035"/></td>
											</tr>
											<tr>
												<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<?php echo $invoice_id; ?>"/></td>
											</tr>
											<tr>
												<td>Amount	:</td><td><input type="hidden" name="amount" value="<?php echo $payable_amount; ?>"/></td>
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
												<td>Billing Name	:</td><td><input type="hidden" name="billing_name" value="<?php echo $data_customer['cust_name']; ?>"/></td>
											</tr>
											<tr>
												<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="<?php echo $data_customer['address']; ?>"/></td>
											</tr>
											<tr>
												<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="<?php echo $branch_name1; ?>"/></td>
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
												<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<?php echo $data_customer['mobile1']; ?>"/></td>
											</tr>
											<tr>
												<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<?php echo $data_customer['email'] ; ?>"/></td>
											</tr>
											<tr>
												<td colspan="2">Shipping information(optional)</td>
											</tr>
											<tr>
												<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<?php echo $data_customer['cust_name']; ?>"/></td>
											</tr>
											<tr>
												<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value="<?php echo $data_customer['address']; ?>"/></td>
											</tr>
											<tr>
												<td>shipping City	:</td><td><input type="hidden" name="delivery_city" value="<?php echo $branch_name1; ?>"/></td>
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
												<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<?php echo $data_customer['mobile1']; ?>"/></td>
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
                                      </div>
                                      <?
								}
								else
								{
								?>
                                	<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Payment Added Successfully</p></center></div>
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
										//
										//setTimeout('document.location.href="cust_serv_payment_details.php?record_id=<?php echo $record_id; ?>";',1000);
                            		</script>
                                <?php
								}
								
									
								}
								else
								{
								 // $db->query_insert("pay_balace_bill_mapping", $data_college);
								 //  echo '<div id="msgbox" style="width:40%;">Supplier added successfully</center></div>';
								}
								$success=1;
								
								
                            	
                        	}
                                
                         	?>       
                                
                                
                                <form method="get" name="jqueryForm" id="jqueryForm">
                                    
                                </form>
                         
                      <?php
                       
                                $sql_records= "SELECT * FROM customer_service_invoice where customer_service_id=".$record_id." order by invoice_id desc limit 0,1 ";
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
                                                   
                                                    <td height="2" align="right"></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    
                                    <tr>
                                    	<td valign="top" colspan="2">
                                        <input type="hidden" name="record_id" id="record_id" value=""  />
                                       <table cellspacing="1"  cellpadding="5" style="width: 60%;" align="center">
										<?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 
										 
                                        
                                        include "include/paging_script.php";
										if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
										<?php }
										else { ?>
                                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                                       <?php } ?>
									   
									   <tr>
											<td width="20%">Invoice Due Date<span class="orange_font">*</span></td>
											<td width="49%"><input type="text" id="invoice_due_date" name="invoice_due_date" class="input_text datepicker" value="<?php if($_POST['invoice_due_date']) echo $_POST['invoice_due_date']; else if($row_record['invoice_due_date']!=''){$arrage_date= explode('-',$row_record['invoice_due_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
											</td>
										</tr>
									   
									   
									   <?php
                                        echo '<tr class="'.$bgclass.'">';
                                        $invoive_no=$val_record['invoice_id'] + 1;
										echo " <td><strong>Invoice No.</strong></td><td align='left'>".$invoive_no."
										<input type='hidden' name='invoice_no' id='invoice_no' value='$invoive_no'></td></tr>";
										
										$name ='';
										$email_id = '';
										$phone_no ='';
					
									  	
										
										
										echo '<tr><td><strong>Customer Name</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_customer['cust_name'].'
										<input type="hidden" name="cm_id_branch" id="cm_id_branch" value="'.$data_customer['cust_name'].'"/><input type="hidden" name="cust_ids" id="cust_ids" value="'.$data_customer['cust_id'].'"/></td></tr>';
										
                                        echo '<tr><td><strong>Total Service Price</strong></td><td align="left">'.$fetch_query_cust_service['service_price'].'<input type="hidden" name="total" id="total" value='.$fetch_query_cust_service['service_price'].'></td></tr>';
										
										if($fetch_query_cust_service['nonmemb_discount_type']=='percentage')
										  $discount_type="%";
										  
										  else
										   $discount_type="Rs";
										
                                        echo '<tr><td><strong>Discount in ('.$discount_type.')</strong></td><td align="left">';
                                        	echo $fetch_query_cust_service['nonmemb_discount'];
                                        echo '</td><input type="hidden" name="discount" id="discount" value='.$fetch_query_cust_service['nonmemb_discount'].'></tr>'; 
									    
										echo '<tr><td><strong>Final Amount</strong></td><td align="left">'.$fetch_query_cust_service['amount'].'<input type="hidden" name="final_amt" id="final_amt" value='.$fetch_query_cust_service['amount'].'></td></tr>';
										
										echo '<tr><td><strong>Total paid Amount</strong></td><td align="left">'.$fetch_query_cust_service['payable_amount'].'<input type="hidden" name="total_paid_amt" id="total_paid_amt" value='.$fetch_query_cust_service['payable_amount'].'></td></tr>';
										
									   echo '<tr><td><strong>Remaining Amount</strong></td><td align="left">'.$val_record['remaining_amount'].'
									   <input type="hidden" name="balance_amount" id="balance_amount" value="'.$val_record['remaining_amount'].'" class="inputText"></td></tr>';
										
										//echo '<tr><td><input type="hidden" name="bal_amt" id="bal_amt"/> </td></tr>'		
									   ?> 
										<tr><td width="37%"><strong>Deposite Amount</strong></td>
                                        <td width="63%" align="left"><input type="text" name="amount_paid" id="amount_paid" onKeyUp="calculate_total(this.value)"	value="" > </td></tr>
                                       <tr>
                                          	<td width="20%" class="heading">Select Payment Mode</td>
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
                                                <div id="bank_ref_no" <?php  if($data_payment_mode1['payment_mode']=='online') echo 'style="display:block"'; else echo ' style="display:none"'; ?>>
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="10%" class="tr-header" align="">Ref. no</td>
                                                            <td width="35%"><input type="text" name="bank_ref_no" id="ref_no_bank" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $row_record['bank_ref_no']; ?>"/></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                             	<div id="bank_details" style="display:none">
                                             	<table width="100%">
                                             		<tr>
                                             			<td width="56%" class="tr-header" align="">Customer Bank Name</td>
                                             			<td width="20%" style="vertical-align:bottom">
                                              			<input type="text" name="cust_bank_name" id="cust_bank_name" value="<?php if($_POST['cust_bank_name']) echo $_POST['cust_bank_name']; else echo $row_record['cust_bank_name']; ?>"/>
                                             			</td>
                                              			<td width="25%" class="tr-header" align=""> ISAS Bank Name : &nbsp; 
                                             			<div id="bank_id"></div>
                                             			</td>
                                             			<td width="25%" class="tr-header" align=""> ISAS Account No : &nbsp; 
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
										
                                        
								 		<tr><td width="37%"><strong>Remaining </strong></td><td align="left"  width="63%"> 
                                        <div id="avail_balance_show"><?php echo $val_record['remaining_amount']; ?></div>
                                        <input type="hidden" name="remaining_amount" id="remaining_amount" /> </td></tr>
                               			
                                        <tr>
                                            <td colspan="2" align="center"> <input type="submit" onClick="return submitform();" name="save_changes" value="Add Payment" class="add_submit_button"/></td>
                                        </tr>
                                        <?php
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
/*vals= document.getElementById("payment_type").value;
show_payment(vals);*/
<?php
if($record_id || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
{
	?>
	vals= document.getElementById("payment_type").value;
	show_payment(vals);
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