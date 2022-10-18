<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php";
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$inst_id = $_GET['installment_id'];

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
<?php if($record_id) echo "Add PDC Details ";?>
 </title>
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
	if($_SESSION['type']=='S')
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
	admin_id=<?php echo $_SESSION['admin_id']; ?>;
    </script>
    <script type="text/javascript">
	function submitform()
	{
		return calculate_total($("#amount_paid").val(),1);
	}
	finish = 0;
	remain=0;
	function calculate_total(amount_paid,final_call)
	{
		if(amount_paid == "")
			amount_paid = 0;
		//==============================TOTAL GST ==================================// changes in 14-11-17
		var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
		var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
		var totalgst=cgsttax+sgsttax;
		
		var new_total_tax=parseFloat((totalgst+100)/100);
		var total_taxable_value = parseInt(amount_paid / new_total_tax);
		var total_gst =parseInt(amount_paid - total_taxable_value);
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
		
		total_paid=parseFloat(amount_paid)+parseFloat(cgast_tax)+parseFloat(sgast_tax);
		document.getElementById('total_paid_gst').value=total_paid;
		
		var no_of_installment = $("#no_of_installment").val();
		var no_of_paid_installment = parseInt($("#no_of_paid_installment").val());
		if(no_of_paid_installment && no_of_paid_installment!=undefined)
			var start_with = no_of_paid_installment+1;
		else
			var start_with = 1;
		//alert(start_with);
		//----first reset all the values to default--
		for(c=start_with;c<=no_of_installment;c++)
		{
			$("#int_id_"+c).html(parseInt($("#inst_"+c).val()));
		}
		//-------------------------------------------
		
		var balance_amount = $("#balance_amount").val();
		var amount_to_be_paid = parseInt(amount_paid);
		var total_remaining = parseInt(balance_amount);// - parseInt(amount_to_be_paid);
		if(total_remaining-parseInt(amount_to_be_paid)<0)
		{
			alert("Invalid input.");
			return false;
		}
		//alert(start_with+'-'+no_of_installment);
		$("#bal_amt").val(total_remaining);
		for(x=start_with;x<=no_of_installment;x++)
		{
			//alert(total_remaining);
			var inst_id_val = parseInt($("#inst_"+x).val());
			if(total_remaining<0)
			{
				alert("Amount should be less than or equal to the remaining amount.");
				break;
			}
			else
			{
				var current_inst_bal = inst_id_val-amount_to_be_paid;
				//alert(inst_id_val+'='+current_inst_bal);
				if(current_inst_bal<0)
				{
					amount_to_be_paid = -1*current_inst_bal;
					total_remaining = total_remaining-inst_id_val;
					if(final_call == 1)
					{
						//alert($("#inst_original_"+start_with).val()+'<11>'+amount_paid);
						if(parseInt($("#inst_original_"+start_with).val())<amount_paid)
							$("#inst_"+x).val(0);
					}
					$("#int_id_"+x).html(0);
					continue;
				}
				else
				{
					//alert(current_inst_bal);
					if(current_inst_bal==0)
						total_remaining = total_remaining-inst_id_val;
					else
						total_remaining = total_remaining-amount_to_be_paid;
					if(final_call == 1)
					{
						//alert($("#inst_original_"+start_with).val()+'<122>'+amount_paid);
						if(parseInt($("#inst_original_"+start_with).val())>amount_paid)
						{
							
							/*amount_to_be_paid = -1*current_inst_bal;
							total_remaining = total_remaining-inst_id_val;
							if(final_call == 1)
							{
								//alert($("#inst_original_"+start_with).val()+'<11>'+amount_paid);
								if(parseInt($("#inst_original_"+start_with).val())>amount_paid)
									$("#inst_"+x).val(0);
									
								
							}
							$("#int_id_"+x).html(0);
							continue;*/
							
						    alert("Deposit amount should not be less than current installment.");
							return false;
						}
						else
						{
							$("#inst_"+x).val(current_inst_bal);
						}
					}
					$("#int_id_"+x).html(current_inst_bal);
					break;
				}
			}
		}
		if(final_call == 1)
			$('#avail_balance').val(total_remaining);	
			
		$('#avail_balance_show').html(total_remaining);
		return true;
	}
	function calculate_total_old(amount_paid)   // caloculate the total of sell
  	{
		var balance_amount= document.getElementById('balance_amount').value;
		//alert(balance_amount);
	    amount_paid_id=parseInt(amount_paid); 
		//alert(amount_paid_id);
		//amount_paid_id= document.getElementById(amount_paid_id).value;
		avail_balance_id = parseInt(balance_amount) - parseInt(amount_paid_id);
		//alert(avail_balance_id);	
		document.getElementById('bal_amt').value=avail_balance_id;
		no_of_installment = $("#no_of_installment").val();	
		//alert(no_of_installment);
		var remaining =	parseInt(balance_amount);
		
		for(x=1;x<=no_of_installment;x++)
		{ 
		  //  alert(finish);
			if(finish!=x)
			{
			inst_id_val = $("#inst_"+x).val();					
			//alert(inst_id_val);
			vlsd = inst_id_val-amount_paid_id;
			//alert(vlsd);
			//alert(amount_paid_id);
			if(vlsd<0)
			{
				remain= vlsd;
				$("#int_id_"+x).html(0);
				//$("#inst_"+(x+1)).val($("#inst_"+x).val()+remain);
				nx =(parseInt($("#inst_"+x).val())+remain);
				$("#inst_"+(x+1)).val(nx);
				$("#inst_"+x).val(vlsd)
				if(nx<0 && $("#inst_"+(x+1)))
				{
					$("#inst_"+(x+1)).val(0);
					//alert(nx);
					//alert($("#inst_"+(x+1)).val());
					$("#int_id_"+(x+1)).html(0);
					if($("#inst_"+(x+2)))
					{
						nx2 = (parseInt($("#inst_"+(x+2)).val())+nx);
						$("#int_id_"+(x+2)).html(nx2);
					}
				}
				else
				{
					$("#int_id_"+(x+1)).html(nx);
				}
				
				//alert(nx);
				
				finish=x;
				break;
					
			}else
			if(amount_paid_id <= parseInt(inst_id_val))
			{ 
			   
				if($("#int_id_"+x).html() !=0)
				{	
				 	
					$("#int_id_"+x).html(vlsd);
					if($("#int_id_"+x).html()==0)
					finish=x;
					break;
				}
				
				
				
			}
			
			//alert(finish);
			}
		}
		//alert($("#inst_1").val());
		document.getElementById('avail_balance').value=avail_balance_id;		
		document.getElementById('avail_balance_show').innerHTML = avail_balance_id;
    }
	
	
</script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='144' ".$_SESSION['where']."";
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
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='144'";
$ptr_mail_text=mysql_query($sel_mail_text);
if($tot_mail_text=mysql_num_rows($ptr_mail_text))
{
	$data_mail_text=mysql_fetch_array($ptr_mail_text);
	?>
	email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
	<?php
}
?>
//alert(mail1);
function send()
{								  
	//alert('hi');
	/* var branch =document.getElementById('branch_name');
	var branch_name=branch.options[branch.selectedIndex].text; 
	var invoice_no =document.getElementById('invoice_no').value;
	var enrolled_id =document.getElementById('record_id').value;
	var name =document.getElementById('name').value;
	var course_name =document.getElementById('course_name').value;
	
	// alert(invoice_no);
	var mail =document.getElementById('mail').value;
	//alert(inst_student_id); 
	var cm_id_branch =document.getElementById('cm_id_branch').value;
	//alert(cm_id_branch);
	var total=document.getElementById('total').value;
	// alert(total);
	var discount =document.getElementById('discount').value;
	//alert(discount);
	var down_payment =document.getElementById('down_payment').value;
	//alert(down_payment);
	
	var paid_amt =document.getElementById('paid_amt').value;
	// alert(paid_amt);
	var balance_amount =document.getElementById('balance_amount').value;
	//alert(balance_amount);
	var amount_paid =document.getElementById('amount_paid').value;
	//alert(amount_paid);
	m =document.getElementById('payment_type');
	var payment_type=m.options[m.selectedIndex].text;
	//alert(payment_type);
	var no_of_installment = $("#no_of_installment").val();
	//alert(no_of_installment);
	var cust_bank_name =document.getElementById('cust_bank_name').value;
	//alert(cust_bank_name);
	bank_id=document.getElementById('bank_name');
	var bank=bank_id.options[bank_id.selectedIndex].text;
	//alert(bank);
	var account_no =document.getElementById('account_no').value;
	//alert(account_no);
	var chaque_no =document.getElementById('chaque_no').value;
	//alert(chaque_no);
	var chaque_date =document.getElementById('chaque_date').value;
	//alert(chaque_date);
	var credit_card_no =document.getElementById('credit_card_no').value;
	// alert(credit_card_no); 
	var avail_balance =document.getElementById('avail_balance').value;
	//alert(avail_balance);
	var users_mail=mail1;
	data1='action=add_payment&branch_name='+branch_name+'&invoice_no='+invoice_no+'&cm_id_branch='+cm_id_branch+'&total='+total+'&discount='+discount+'&down_payment='+down_payment+'&paid_amt='+paid_amt+'&balance_amount='+balance_amount+'&amount_paid='+amount_paid+'&payment_type='+payment_type+'&cust_bank_name='+cust_bank_name+'&bank='+bank+'&account_no='+account_no+'&chaque_no='+chaque_no+'&chaque_date='+chaque_date+'&credit_card_no='+credit_card_no+'&avail_balance='+avail_balance+"&users_mail="+users_mail+"&mail="+mail+"&name="+name+"&email_text_msg="+email_text_msg+"&course_name="+course_name;
	//alert(data1);
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
	success: function(response)
	{
		
		return true;
	}
	}); 
	 */
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
		setTimeout(send,500);
		return submitform();
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
            if($_POST['save_changes'] && $_POST['randcheck']==$_SESSION['rand'])
            {
                $chaque_no=$_POST['chaque_no'];
                $chaque_date=$_POST['chaque_date'];
                $bank_name=$_POST['bank_name'];
                
                if($record_id)
                {
                    //$where_record="enroll_id=".$enroll_id;
                    //$db->query_update("enrollment",$data_record_update,$where_record);
					$sele_install ="select * from installment where enroll_id='".$record_id."' and installment_id='".$inst_id."'";
					$ptr_inst= mysql_query($sele_install);
					if(mysql_num_rows($ptr_inst))
					{
						$data_instllment=mysql_fetch_array($ptr_inst);
						
						$update_pdc="update installment set pdc_chaque_no='".$chaque_no."',pdc_chaque_date='".$chaque_date."', pdc_bank_name='".$bank_name."',pdc_date='".date('Y-m-d')."',pdc_status='active' where installment_id='".$inst_id."' and enroll_id='".$record_id."' ";
						$ptr_pdc=mysql_query($update_pdc);
					}
				}
                
				$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Add_payment','Add','".$_POST['name']."','".$invoice_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
                $query=mysql_query($insert);  
                
               	//====================================SEND MESSAGE================================
                /* $select_mobno = " select contact_phone from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and (type='A' or type='C' ) and contact_phone !='' ";
                $ptr_mob = mysql_query($select_mobno);
                while($data_mob = mysql_fetch_array($ptr_mob))
                {
                    //================for Faculty==============
                    $insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$data_mob['name']."','".$data_mob['contact_phone']."','".$desc."','".$data_mob['designation']."','enqiry','".$cm_id."','".$data_record['added_date']."')";
                    $ptr_sms=mysql_query($insert_sms);
                    //send_sms($mobile_numbers,$message);
                    //=========================================
                } */
                //=================For Student=============
                /* $insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$firstname.' '.$lastname."','".$data_select1['contact']."','".$desc1."','Student','enqiry','".$cm_id."','".$data_record['added_date']."')";
                $ptr_sms=mysql_query($insert_sms);
                //send_sms($mobile_numbers,$message);
                
                $select_template="select sms_text from previleges where privilege_id='144'";
                $ptr_temp=mysql_query($select_template);
                $data_temp=mysql_fetch_array($ptr_temp);
                $messagessss=$data_temp['sms_text'];
                //"<br/>".$messagessss ="Thanks for taking admission in ISAS";
                //send_sms_function($contact,$messagessss);
                $sele_pay="select payment_mode from payment_mode where payment_mode_id='".$payment_type."'";
                $ptr_pay=mysql_query($sele_pay);
                $data_pay=mysql_fetch_array($ptr_pay);
                //=============SMS Send================
                $mesg ="Payment of ".$data_select1['name']." is done.Amount of Rs. ".$amount_paid."/- received by ".$data_pay['payment_mode']." on ".$_POST['added_date']." ";
                $mesg .="\n- ISAS ".$branch_name;
                $sel_inq="select sms_text from previleges where privilege_id='144'";
                $ptr_inq=mysql_query($sel_inq);
                $txt_msg='';
                if(mysql_num_rows($ptr_query))
                {
                    $dta_msg=mysql_fetch_array($ptr_inq);
                    $txt_msg=$dta_msg['sms_text'];
                }
                $messagessss =$mesg.$txt_msg;
                $sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='144' ".$_SESSION['where']."";
                $ptr_sel_sms=mysql_query($sel_sms_cnt);
                while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
                {
                    "<br/>".$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."'";
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
                } */
                //send_sms_function($data_select1['contact'],$messagessss);
                
                //------send notification on inquiry addition--------------------
				$notification_args['reference_id'] = $enroll_id;
				$notification_args['on_action'] = 'installment_payment';
				$notification_status = addNotifications($notification_args);
                //---------------------------------------------------------------
                //======================================== END SEND MESSAGE=====================================
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
                setTimeout('document.location.href="manage_enroll_student.php?record_id=<?php echo $record_id; ?>";',200);
                </script>
                <?php
                unset($_SESSION['rand']);
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
      }
      else
      {
        $balance=0;
        $pre_from_date="";                            
      }
      $sql_records= "SELECT * FROM invoice where enroll_id=".$record_id." ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  order by invoice_id desc limit 0,1 ";
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
                    <input type="hidden" name="record_id" id="record_id" value="<?php echo $_GET['record_id']; ?>"  />
                   	<table cellspacing="1"  cellpadding="5" style="width: 60%;" align="center">
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
                        
                        $sel_inst1= "select * from installment where enroll_id=".$record_id." order by installment_id asc limit 0,1 ";
                        $ptr_inst=mysql_query($sel_inst1);
                        $data_inst1=mysql_fetch_array($ptr_inst);
                        
                        //=========================For prevent to save multiple entries================
                        $rand=rand();
                        $_SESSION['rand']=$rand;
                        //=============================================================================
                        
                        echo '<tr class="'.$bgclass.'">';
                        ?>
                        
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
                        
                        echo '<tr><td><strong>Student Name</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['name'].'<input type="hidden" name="cm_id_branch" id="cm_id_branch" value='.$data_select['cm_id'].'><input type="hidden" name="mail" id="mail" value='.$data_select['mail'].'><input type="hidden" name="name" id="name" value='.$data_select['name'].'></td></tr>';
                        echo '<tr><td><strong>Course Name</strong></td><td align="left">'.$course_name.' <input type="hidden" name="course_name" id="course_name" value='.$course_name.'></td></tr>';
                        echo '<tr><td><strong>Total</strong></td><td align="left">'.$data_select['course_fees'].' <input type="hidden" name="total" id="total" value='.$data_select['course_fees'].'></td></tr>';
                        echo '<tr><td><strong>Discount</strong></td><td align="left">';
                        echo $data_select['discount'];
                        echo '</td><input type="hidden" name="discount" id="discount" value='.$data_select['discount'].'></tr>';
                        $paid=$data_select['paid'];
                        
                        echo '<tr><td><strong>Down Payment</strong></td><td align="left">'.$data_select['down_payment'].'<input type="hidden" name="down_payment" id="down_payment" value='.$data_select['down_payment'].'></td></tr>'; 
                        if($data_select['paid'] !='')
                        {
                            echo '<tr><td><strong>Paid</strong></td><td align="left">'.$data_select['paid'].'<input type="hidden" name="paid_amt" id="paid_amt" value="'.$data_select['paid'].'"></td></tr>'; 
                        }
                       	echo '<tr><td><strong>Balance Amount</strong></td><td align="left">'.$data_select['balance_amt'].'<input type="hidden" name="balance_amount" id="balance_amount" value="'.$data_select['balance_amt'].'" class="inputText"></td></tr>';
                        
                        echo '<tr><td><input type="hidden" name="bal_amt" id="bal_amt"/></td></tr>'		
                        ?> 
                        <tr><td colspan="2"><strong>PDC For -:</strong></td></tr>		
                        <tr>
                        <td colspan="2">
                        <table width="95%" align="center">
                            <tr>
                            <td >
                                <?php
                                $sel_inst= "select * from installment where enroll_id=".$record_id." and installment_id='".$inst_id."'";
                                $ptr_query_inst=mysql_query($sel_inst);
                                $i=$data_select['no_of_installment'];
                                echo '<input type="hidden" name="no_of_installment" value='.$i.' id="no_of_installment" /><table width="100%" style="border:1px solid black">';
                                echo'<tr><td width="30%"><b>Installments</b></td><td width="20%"><b>Inst Amt</b></td><td width="25%"><b>Inst Date</b></td><td>Paid Status</td></tr>';
                            //	echo '<tr></tr>';
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
                                echo '<input type="hidden" name="no_of_paid_installment" value="'.$no_of_paid__installment.'" id="no_of_paid_installment" />';
                                ?>
                                
                            </td>
                        </tr>
                        </table>
                        </td>
                        </tr>
                        
                        <tr>
                            <td width="37%"><strong>Chaque Number</strong></td><td width="63%" align="left"><input type="text" name="chaque_no" id="chaque_no" value="" >
                           	</td>
                        </tr>
                        <tr>
                            <td width="20%">Chaque Date<span class="orange_font">*</span></td>
                            <td width="49%"><input type="text" id="chaque_date" name="chaque_date" class="input_text datepicker" value="<?php if($_POST['chaque_date']) echo $_POST['chaque_date']; else if($data_inst1['chaque_date']!=''){$arrage_date= explode('-',$data_inst1['installment_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="37%"><strong>Bank Name</strong></td><td width="63%" align="left"><input type="text" name="bank_name" id="bank_name" value="" >
                            </td>
                        </tr>
                        <tr>
                            <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
                            <td colspan="2" align="center"> <input type="submit" name="save_changes" value="Add PDC Details" class="add_submit_button"/></td>
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
if($record_id || $_SESSION['type']=="S")
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