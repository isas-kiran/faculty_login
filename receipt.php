<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
$page_name = "receipt";
$sele_sac_code="select sac_code from sac_code_config where page_name='".$page_name."'";
$ptr_sac_code=mysql_query( $sele_sac_code);
$data_sac_code=mysql_fetch_array($ptr_sac_code);

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='104'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	$sel="select * from receipt where receipt_id='".$record_id."'";
	$ptr_data=mysql_query($sel);
	$row_record=mysql_fetch_array($ptr_data);
		
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}
else
{
	$record_id='';
}
if($_REQUEST['receipt_id'])
{
	$receipt_id=$_REQUEST['receipt_id'];
	$where_receipt=" and receipt_id='".$receipt_id."'";
}
else
{
	$receipt_id='';
	$where_receipt="";
}
?>
<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Receipt</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>

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
    <!--End multiselect -->
     <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
     <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
    var  pageName = "add_expense";
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd/mm/yy'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			$("#realtxt").chosen({allow_single_deselect:true});
			$("#customer_id").chosen({allow_single_deselect:true});
       });
	</script>
    <script type="text/javascript" src="../js/common.js"></script>
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
<script>
function payment(value)
{
	payment_mode=value.split("-")
	var branch_name=document.getElementById("branch_name").value;
	if(payment_mode[0]=="cheque")
	{
		document.getElementById("chaque_details").style.display = 'block';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		//document.getElementById("paytm_details").style.display = 'none';
		document.getElementById("petty_cash_types").style.display = 'none'
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("bank_ref_no").style.display = 'none';
		//document.getElementById("paytm_details").style.display = 'none';
		document.getElementById("petty_cash_types").style.display = 'none'
		show_bank_for_payment_mode(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		//document.getElementById("paytm_details").style.display = 'none';
		document.getElementById("petty_cash_types").style.display = 'none'
		show_bank_for_payment_mode(branch_name,"paytm")
	}
	else if(payment_mode[0]=="online")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		//document.getElementById("paytm_details").style.display = 'none';
		document.getElementById("petty_cash_types").style.display = 'none'
		show_bank_for_payment_mode(branch_name,"online")
	}
	else if(payment_mode[0]=="cash")
	{
		document.getElementById("petty_cash_types").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		//document.getElementById("paytm_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"");
	}
	else
	{
		document.getElementById("chaque_details").style.display ='none';
		document.getElementById("bank_details").style.display ='none';
		document.getElementById("credit_details").style.display ='none';
		//document.getElementById("paytm_details").style.display ='none';
		document.getElementById("petty_cash_types").style.display ='none';
		show_bank_for_payment_mode(branch_name,"");
		
	}
}

</script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='40' ".$_SESSION['where']."";
$ptr_sel_sms=mysql_query($sel_sms_cnt);
$tot_num_rows=mysql_num_rows($ptr_sel_sms);
$i=0;
while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
{
	"<br/>".$sel_act="select contact_phone,email from site_setting where admin_id='".$data_sel_cnt['staff_id']."'  and email!='' ".$_SESSION['where']."";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$data_cnt=mysql_fetch_array($ptr_cnt);
		?>
		mail1[<?php echo $i; ?>]='<?php echo $data_cnt['email'];?>';
		<?php
		$i++;
	}
}		
if($_SESSION['type']!='S')
{
	"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' and email!='' ";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$j=0;
		while($data_cnt=mysql_fetch_array($ptr_cnt))
		{
			?>
			mail1[<?php echo $j; ?>]='<?php echo $data_cnt['email'];?>';
			<?php
			$j++;
		}
	}
}
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='104'";
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
	<?php
	if($_SESSION['']=="S")
	{
		?>
		if(document.getElementById('branch_name'))
		{
			branch =document.getElementById('branch_name');
			var branch_name=branch.options[branch.selectedIndex].text; 
		}
		else
		{
			var branch_name='';
		}
		<?php
	}
	else
	{
		?>
		var branch_name='<?php echo $_SESSION['branch_name'] ?>';
		<?php
	}
	?>	
	if(document.getElementById('category'))
	{
		category =document.getElementById('category');
		var category_name=category.options[category.selectedIndex].text; 
	}
	else
	{
		var category_name='';
	}
	if(document.getElementById('payment_mode'))
	{
		payment_mode =document.getElementById('payment_mode');
		var payment_mode_name=payment_mode.options[payment_mode.selectedIndex].text; 
		
		var bank_names='';
		var account_no ='';
		var chaque_no ='';
		var date ='';
		var cust_bank_name ='';
		var credit_card_no ='';
		var bank_ref_no ='';
		
		if(payment_mode_name=='cheque-2')
		{
			if(document.getElementById('bank_name'))
			{
				bank_name =document.getElementById('bank_name');
				var bank_names=bank_name.options[bank_name.selectedIndex].text; 
			}
			else
			{
				var bank_names='';
			}
			if(document.getElementById('account_no'))
				var account_no =document.getElementById('account_no').value;
			else
				var account_no ='';
			if(document.getElementById('chaque_no'))
				var chaque_no =document.getElementById('chaque_no').value;
			else
				var chaque_no ='';
			if(document.getElementById('date'))
				var date =document.getElementById('date').value;
			else
				var date ='';
		}
		else if(payment_mode_name=='Credit Card-4')
		{
			if(document.getElementById('bank_name'))
			{
				bank_name =document.getElementById('bank_name');
				var bank_names=bank_name.options[bank_name.selectedIndex].text; 
			}
			else
			{
				var bank_names='';
			}
			if(document.getElementById('account_no'))
				var account_no =document.getElementById('account_no').value;
			else
				var account_no ='';
			if(document.getElementById('cust_bank_name'))
				var cust_bank_name =document.getElementById('cust_bank_name').value;
			else
				var cust_bank_name ='';
			if(document.getElementById('credit_card_no'))
				var credit_card_no =document.getElementById('credit_card_no').value;
			else
				var credit_card_no ='';
		}
		else if(payment_mode_name=='online-5')
		{
			if(document.getElementById('bank_name'))
			{
				bank_name =document.getElementById('bank_name');
				var bank_names=bank_name.options[bank_name.selectedIndex].text; 
			}
			else
			{
				var bank_names='';
			}
			if(document.getElementById('account_no'))
				var account_no =document.getElementById('account_no').value;
			else
				var account_no ='';
			if(document.getElementById('bank_ref_no'))
				var bank_ref_no =document.getElementById('bank_ref_no').value;
			else
				var bank_ref_no ='';
		}
	}
	else
	{
		var payment_mode_name='';
	}
	
	if(document.getElementById('user'))
	{
		user =document.getElementById('user');
		var user=bank_name.options[user.selectedIndex].text; 
		if(document.getElementById('customer_id'))
		{
			customer_id =document.getElementById('customer_id');
			var customer_id=customer_id.options[customer_id.selectedIndex].text; 
		}
		else
		{
			var customer_id='';
		}
	}
	else
	{
		var user='';
	}
	if(document.getElementById('amount_wo_tax'))
		var amount_wo_tax =document.getElementById('amount_wo_tax').value;
	else
		var amount_wo_tax ='';
		
	if(document.getElementById('amount'))
		var amount =document.getElementById('amount').value;
	else
		var amount ='';
	if(document.getElementById('description'))
		var description=document.getElementById('description').value;
	else
		var description='';
	var users_mail=mail1;
	data1='action=receipt&branch_name='+branch_name+'&category_name='+category_name+'&payment_mode_name='+payment_mode_name+'&bank_names='+bank_names+'&account_no='+account_no+'&chaque_no='+chaque_no+'&date='+date+'&cust_bank_name='+cust_bank_name+'&credit_card_no='+credit_card_no+'&bank_ref_no='+bank_ref_no+'&customer_id='+customer_id+'&amount_wo_tax='+amount_wo_tax+'&amount='+amount+'&description='+description+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
	success: function(response)
	{
		//alert(response);//http://www.htdpt.in/tracking/send_email.php
		return true;
	}
	});

}

function validme()
{
	frm = document.save;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
	if(frm.category.value=='select')
	{
		 disp_error +='Select Category Name\n';
		 document.getElementById('category').style.border = '1px solid #f00';
		 frm.category.focus();
		 error='yes';
	}
	/* else
	 {
		 if(frm.category.value=='bank')
		 {
			  if(frm.bank_name.value=='')
			 {
				 disp_error +='Select Bank Name\n';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
				 error='yes';
			 }
			 
		 }
	 }*/
	if(frm.payment_mode.value=='select')
	{
		disp_error +='Select Payment Mode\n';
		document.getElementById('payment_mode').style.border = '1px solid #f00';
		frm.payment_mode.focus();
		error='yes';
	}
	else
	{
		pay_value=$('#payment_mode').val();
		pay_type=pay_value.split('-');
		payment_types=pay_type[0];
		if(payment_types=='cheque')
		{
			if(frm.bank_name.value=='')
			{
				disp_error +='Select Bank Name\n';
				document.getElementById('bank_name').style.border = '1px solid #f00';
				frm.bank_name.focus();
				error='yes';
			}
			if(frm.account_no.value=='')
			{
				disp_error +='Enter Account Number\n';
				document.getElementById('account_no').style.border = '1px solid #f00';
				frm.account_no.focus();
				error='yes';
			}
			if(frm.chaque_no.value=='')
			{
				disp_error +='Enter Chaque Number\n';
				document.getElementById('chaque_no').style.border = '1px solid #f00';
				frm.chaque_no.focus();
				error='yes';
			}
			if(frm.date.value=='')
			{
				disp_error +='Enter Cheque Date\n';
				document.getElementById('date').style.border = '1px solid #f00';
				frm.date.focus();
				error='yes';
			}
		}
		if(payment_types=='Credit Card')
		{
			if(frm.bank_name.value=='')
			{
				disp_error +='Select Bank Name\n';
				document.getElementById('bank_name').style.border = '1px solid #f00';
				frm.bank_name.focus();
				error='yes';
			}
			if(frm.credit_card_no.value=='')
			{
				disp_error +='Enter Credit Card Number\n';
				document.getElementById('credit_card_no').style.border = '1px solid #f00';
				frm.credit_card_no.focus();
				error='yes';
			}
		}
	}
	if(frm.amount.value=='')
	{
		disp_error +='Plese Enter Amount\n';
		document.getElementById('amount').style.border = '1px solid #f00';
		frm.amount.focus();
		error='yes';
	}
	if(error=='yes')
	{
		alert(disp_error);
		return false;
	}
	else
	{
		send();
		return true;
		
	}
}

function isPastDate(value) 
{
	var now = new Date;
	var target = new Date(value);
	if (target.getFullYear() < now.getFullYear()) {
		return true;
	} else if (target.getMonth() < now.getMonth()) {
		return true;
	} else if (target.getDate() < now.getDate()) {
		return true;
	}

	return false;
}
	function isFeatureDate(value) {
        var now = new Date;
        var target = new Date(value);
        if (target.getFullYear() > now.getFullYear()) {
            return true;
        } else if (target.getMonth() > now.getMonth()) {
            return true;
        } else if (target.getDate() > now.getDate()) {
            return true;
        }
        return false;
    }
function isSpclChar(id)
{
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";

 vals = document.getElementById(id).value;
for (var i = 0; i < vals.length; i++) {
    if (iChars.indexOf(vals.charAt(i)) != -1) {
          return 'yes';
        }
    }
	
}  
function validateEmail(emailField)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(document.getElementById('email').value !='')
	{
		if (reg.test(document.getElementById('email').value) == false) 
		{
			alert('Invalid Email Address');
			document.getElementById('email').style.border = '1px solid #f00';
			document.getElementById('email').focus();
			return false;
		}
	}
	return true;
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
	document.getElementById("bank_record").style.display="none";
	if(document.getElementById("record_id"))
		record_id= document.getElementById("record_id").value;
	else
		record_id='';	
	var bank_data="action=receipt&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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

	var tax_data1="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax_type.php",type:"post", data: tax_data1,cache: false,
	success: function(rettax)
	{
		//alert(rettax);
		document.getElementById("create_type1").innerHTML='';
		document.getElementById("res1").value=rettax;
	}
	});
}
function show_bank_for_payment_mode(branch_id,vals)
{
	document.getElementById("bank_record").style.display="none";
	record_id= document.getElementById("record_id").value;
	var bank_data="action=receipt&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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
function show_category(category)
{
	//alert(category);
	if(category =="voucher")
	{
		var cat_data="action=show_category_name&category_name="+category;
		//alert(cat_data);
		$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retcat)
		{
			//alert(retcat);
			document.getElementById("cat_id").style.display="block"
			document.getElementById("cat_id").innerHTML=retcat;
		}
		});
	}
	else
	{
		document.getElementById("cat_id").style.display="none"
	}
}
function calculte_amount_tax(val_tax_ids)
{
	tax_value='';
	tot_amount=0;
	var total_tax_length=document.getElementsByName("total_tax[]").length;
	if(val_tax_ids!=0 || total_tax_length!=0)
	{
		var total_tax=document.getElementsByName("total_tax[]").length;
		//alert(total_tax);
		tot_tax_amount=0;
		for(i=1;i<=total_tax;i++)
		{
			tax_id='tax_value'+i;
			tax_amount_id='tax_amount'+i;
			tax_value = Number(document.getElementById(tax_id).value);
		
			cost_tot_tt=parseInt(document.getElementById("amount_wo_tax").value);
			cal_tot_amount=cost_tot_tt * (tax_value/100);
			
			//document.getElementById(tax_amount_id).value=cal_tot_amount;
			$('#tax_amount'+i).val(cal_tot_amount);
			tot_tax_amount=parseInt(Number(tot_tax_amount) + Number(cal_tot_amount))
		}
		tot_amount=parseInt(cost_tot_tt + tot_tax_amount)
		$('#amount').val(tot_amount);
	}
	else
	{
		cost_tot_tt=parseInt(document.getElementById("amount_wo_tax").value);
		$('#amount').val(cost_tot_tt);
	}
	
}
function delete_tax(id,tax_types)
{
	//alert(id);
	if(confirm('Do you really want to delete record'))
	{
		$('#tax_type'+id).replaceWith(function(){
			return $('<input type="text" name="tax_type'+id+'" id="tax_type'+id+'" value="" />', {html: $(this).html()});
		});
		$('#tax_value'+id).replaceWith(function(){
			return $('<input type="text" name="tax_value'+id+'" id="tax_value'+id+'" value="" />', {html: $(this).html()});
		});
		$('#tax_amount'+id).replaceWith(function(){
			return $('<input type="text" name="tax_amount'+id+'" id="tax_amount'+id+'" value="" />', {html: $(this).html()});
		});
		if(tax_types=='total_type1')
		{  
			$('#type1_id'+id).hide();
			$('#del_floor_type1'+id).val('yes');
			tax_val=$('#tax_value'+id).val;
			//show_tax(tax_val);
			calculte_amount_tax(id);
		}
	}
}
function show_data(id)
{
	//alert(bank_id);
	var branch_name=document.getElementById("branch_name").value;
	var data1="action=show_data&action_page=receipt&id="+id+'&branch_name='+branch_name;
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		$('#show_type').html(html);
		// document.getElementById('show_type').value=html;
		$("#realtxt").chosen({allow_single_deselect:true});
		$("#customer_id").chosen({allow_single_deselect:true});
	}
	});
}
function show_mobile_no(val1,val2)
{
}
</script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
</head>
<body>
<?php include "include/header.php"; ?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/expense_menu.php";?></td>
    <td class="top_right"></td>
</tr>
    <?php       
	if($_POST['formAction'])
	{
		if($_POST['formAction']=="delete")
		{
			for($r=0;$r<count($_POST['chkRecords']);$r++)
			{
				$del_record_id=$_POST['chkRecords'][$r];
				$sql_query= "SELECT receipt_id FROM ".$GLOBALS["pre_db"]."receipt where receipt_id ='".$del_record_id."'";
				if(mysql_num_rows($db->query($sql_query)))
					{
													
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Delete','receipt','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);           
						
						$delete_query="delete from ".$GLOBALS["pre_db"]."receipt where receipt_id='".$del_record_id."'";
						$db->query($delete_query);                                                                                        
					}
			}
			?>
            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
            <script type="text/javascript">
               // $("#statusChangesDiv").dialog();
                $(document).ready(function() {
                    $( "#statusChangesDiv" ).dialog({
                        modal: true,
                        buttons: {
                                    Ok: function() { $( this ).dialog( "close" ); }
                                 }
                        });
                    });
            </script>
			<?php                            
		}
	}
	if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
	{
		$del_record_id=$_REQUEST['record_id'];
		$sql_query= "SELECT receipt_id FROM ".$GLOBALS["pre_db"]."receipt where receipt_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{      
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Delete','receipt','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert);     
								 
			$delete_query="delete from ".$GLOBALS["pre_db"]."receipt where receipt_id='".$del_record_id."'";
			$db->query($delete_query);      
			?>
			<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
			<script type="text/javascript">
			   // $("#statusChangesDiv").dialog();
				$(document).ready(function() {
					$( "#statusChangesDiv" ).dialog({
						modal: true,
						buttons: {
									Ok: function() { $( this ).dialog( "close" ); }
								 }
						});
					});
			</script>
			<?php
		}
	}
	?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
    <?php
    $success=0;
	if($_POST['save_changes'] && $_POST['randcheck']==$_SESSION['rand'])
	{
		$bank_name='';
		$chaque_no='';
		$date='';
		$credit_card_no='';
		$sac_code=($_POST['sac_code']) ? $_POST['sac_code'] : "";
		$cash_type=($_POST['cash_type']) ? $_POST['cash_type'] : "";
		$payment_mode=$_POST['payment_mode'];
		$sep=explode("-",$payment_mode);
		$payment_mode_id=$sep[1];
		$type=( ($_POST['user'])) ? $_POST['user'] : "";
		$customer_id=( ($_POST['customer_id'])) ? $_POST['customer_id'] : "0";
		$description =mysql_real_escape_string($_POST['description']);
		$category=$_POST['category'];
		$branch_name=$_POST['branch_name'];
		if($category =="voucher")
		{
			$voucher=$_POST['voucher'];
		}
		$amount=( ($_POST['amount'])) ? $_POST['amount'] : "0";
		$amount_wo_tax=( ($_POST['amount_wo_tax'])) ? $_POST['amount_wo_tax'] : "0";
		$cust_bank_name='';
		if($payment_mode_id !="1" && $category !="cash_transfer" )
		{
			$bank_name=$_POST['bank_name'];
			$cust_bank_name=$_POST['cust_bank_name'];
			$chaque_no=$_POST['chaque_no'];
			$credit_card_no=$_POST['credit_card_no'];
			$date=$_POST['date'];
		}
		else if($payment_mode_id =="3")
		{
			$isas_paytm_no=($_POST['isas_paytm_no']) ? $_POST['isas_paytm_no'] : "";
			$cust_paytm_no=($_POST['cust_paytm_no']) ? $_POST['cust_paytm_no'] : "";
		}
		$bank_ref_no=( ($_POST['bank_ref_no'])) ? $_POST['bank_ref_no'] : "0";
		
		if($_POST['added_date'] !='')
		{
			$ad_date=explode('/',$_POST['added_date'],3);
			$added_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
		}
		else $added_date='';
		$total_type1=$_POST['total_type1'];
		if(count($errors))
		{
			?>
			<tr>
				<td> <br></br>
				<table align="left" style="text-align:left;" class="alert">
				<tr><td ><strong>Please correct the following errors</strong><ul>
						<?php
						for($k=0;$k<count($errors);$k++)
								echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
						</ul>
				</td></tr>
				</table>
				</td>
			</tr>   <br></br>  
			<?php
		}
		else
        {
		
			$success=1;
			$data_record['sac_code']=$sac_code;
			$data_record['category'] = $category;
			$data_record['amount'] = $amount;
			$data_record['amount_wo_tax'] = $amount_wo_tax;
			$data_record['bank_id'] =$bank_name;
			$data_record['bank_ref_no'] = $bank_ref_no;
			$data_record['description'] = $description;
			$data_record['cash_type'] = $cash_type;
			$data_record['payment_mode_id'] = $payment_mode_id;
			$data_record['chaque_no'] = $chaque_no;
			$data_record['chaque_date'] =$date;
			$data_record['credit_card_no'] =$credit_card_no;
			$data_record['cust_bank_name'] =$cust_bank_name;
			$data_record['voucher'] =$voucher;
			$data_record['customer_id'] =$customer_id;
			$data_record['emp_type']=$type;
			//===============================CM ID for Super Admin===============
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
			$admin_id=$_SESSION['admin_id'];
			//========================================================================
			if($record_id)
			{
				$update="update receipt set category='".$data_record['category']."', amount_wo_tax='".$data_record['amount_wo_tax']."',amount='".$data_record['amount']."', bank_id='".$data_record['bank_id']."',cash_type='".$cash_type."', payment_mode_id='".$payment_mode_id."', chaque_no='".$chaque_no."', chaque_date='".$date."',cust_bank_name='".$cust_bank_name."', credit_card_no='".$credit_card_no."', description='".$description."', cm_id='".$cm_id."',admin_id='".$_SESSION['admin_id']."', voucher='".$data_record['voucher']."' , sac_code='".$data_record['sac_code']."', emp_type='".$type."',customer_id='".$customer_id."',added_date='".$added_date."' where receipt_id='".$record_id."'";
				$ptr_update=mysql_query($update);
				
				$update_bnk=" update bank_records set amount='".$data_record['amount']."',bank_id='".$data_record['bank_id']."' where record_id='".$record_id."' ";
	            $upade_bk=mysql_query($update_bnk);
				
				for($x=1;$x<=$total_type1;$x++)
				{
					$_POST['tax_type'.$x];
					if($_POST['del_floor_type1'.$x]=='yes')
					{
						if($_POST['type1_id'.$x]!='' && $_POST['del_floor_type1'.$x]=='yes' )
						{
							"<br />".$delete_row = " delete from receipt_tax_map where receipt_tax_map_id='".$_POST['type1_id'.$x]."' ";
							$ptr_delete = mysql_query($delete_row);
						}
					}
					if($_POST['del_floor_type1'.$x] !='yes')
					{
						$data_record_tax['receipt_id'] =$record_id; 
						'<br/>'.$data_record_tax['tax_type'] =$_POST['tax_type'.$x];
						$data_record_tax['tax_value'] =$_POST['tax_value'.$x];
						$data_record_tax['tax_amount'] =$_POST['tax_amount'.$x];
						if($_POST['type1_id'.$x]=='' && $_POST['tax_type'.$x] !='')
						{
							$type1_id=$db->query_insert("receipt_tax_map", $data_record_tax);
						}
						else
						{
							$where_record="receipt_tax_map_id='".$_POST['type1_id'.$x]."'";
							$type1_id= $_POST['type1_id'.$x];
							$db->query_update("receipt_tax_map", $data_record_tax,$where_record);
						}
						unset($data_record_tax);
					}
				}
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Edit','receipt','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);     
				echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Receipt added successfully</p></center></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" );}
												 }
								});
							});
						<?php unset($_SESSION['rand']);?>
						setTimeout('document.location.href="receipt.php";',1000);
						</script>
                        <?php
			}
			else
			{
				//==============Update Invoice No.=====================
				$sel_inv="select ext_invoice_no from receipt where cm_id='".$data_record['cm_id']."' and ext_invoice_no IS NOT NULL order by ext_invoice_no desc limit 0,1";
				$ptr_inv=mysql_query($sel_inv);
				$data_inv=mysql_fetch_array($ptr_inv);
				
				$recp=explode("/",$data_inv['ext_invoice_no']);
				$inv_no=intval($recp[2])+1;
				$preinv=$recp[0].'/'.$recp[1].'/';
				$ext_invoice_no=$preinv.$inv_no;
				//======================================================
				
			 	$insert_for_receipt = "insert into receipt (`category`,`ext_invoice_no`,`bank_id`,`amount_wo_tax`,`amount`,`added_date`,`cash_type`,`payment_mode_id`,`chaque_no`,`chaque_date`,`cust_bank_name`,`credit_card_no`,`bank_ref_no`,`description`,`cm_id`,`voucher`,`sac_code`,`admin_id`,`emp_type`,`customer_id`) values('".$data_record['category']."','".$ext_invoice_no."','".$data_record['bank_id']."','".$data_record['amount_wo_tax']."','".$data_record['amount']."','".$added_date."','".$cash_type."','".$payment_mode_id."','".$chaque_no."','".$date."','".$cust_bank_name."','".$credit_card_no."','".$bank_ref_no."','".$description."','".$cm_id."','".$data_record['voucher']."','".$sac_code."','".$_SESSION['admin_id']."','".$type."','".$customer_id."')";
				$ptr_insert_receipt = mysql_query($insert_for_receipt);
				$receipt_ids=mysql_insert_id();
				
				if($payment_mode_id=='2' || $payment_mode_id=='4' || $payment_mode_id=='5')
				{
					$bank="INSERT INTO `bank_records`(`bank_id`, `type`, `record_id`, `amount`, `added_date`, `cm_id`, `admin_id`) VALUES ('".$data_record['bank_id']."','receipt','".$receipt_ids."','".$data_record['amount']."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$bank_query=mysql_query($bank);  
				}
				for($j=1;$j<=$total_type1;$j++)
				{
					if($_POST['tax_type'.$j] !='' && $_POST['tax_value'.$j] !='')
					{
						$data_record_tax['receipt_id'] =$receipt_ids; 
						$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
						$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
						$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
						$customer_tax_id=$db->query_insert("receipt_tax_map", $data_record_tax);
					}
				}
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('receipt','Add','receipt','".$receipt_ids."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);
				//------send notification on inquiry addition--------------------
					$notification_args['reference_id'] = $receipt_ids;
					$notification_args['on_action'] = 'receipt_payment';
					$notification_status = addNotifications($notification_args);
				//---------------------------------------------------------------
				echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Receipt added successfully</p></center></div>
				<script type="text/javascript">
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
						});
					});
					<?php unset($_SESSION['rand']);?>
					setTimeout('document.location.href="receipt.php";',1000);
				</script>
				
			<?php
			}
		}
	}
	?>
<?php
	if($where_receipt=='')
	{
?>	
	<form name="save" method="post">
		<table cellspacing="3" cellpadding="3" style="border:1px solid #CCC; margin-top: 15px;" width="95%">
		<? if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			<tr>
			<td align="center" width="10%">Select Branch</td>
			<input type="hidden" name="record_id" class="input_text" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
			<td>
			<?php
			$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
			$query_branch = mysql_query($sel_branch);
			$total_Branch = mysql_num_rows($query_branch);
			echo '<table width="100%"><tr><td>';
			echo ' <select id="branch_name"  style="width:200px" class="input_text" name="branch_name" onchange="show_bank(this.value)">';

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
				<option <?php echo $selected; ?> value="<?php echo $row_branch['branch_name'];?>"><?php echo $row_branch['branch_name']; ?> 
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
		
		//=========================For prevent to save multiple entries================
			$rand=rand();
			$_SESSION['rand']=$rand;
		//=============================================================================
		
		?>
	<tr>
		<td width="10%" align="center">Date<span class="orange_font">*</span><input type="hidden" name="res1" id="res1" /></td>
		<td width="25%">
		<?php 
		if($_SESSION['type']=="S")
		{
			?>
            <input type="text" style="width:200px" id="added_date" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
            <?php
		}
		else
		{
			if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>
        <input type="hidden"  style="width:200px" id="added_date" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
        <?php
		}
        ?>
		</td>
	</tr>
	<tr>
		<td width="10%" align="center">SAC No.<span class="orange_font"></span></td>
		<td width="25%"><input type="text" style="width:200px" name="sac_code" id="sac_code" class="input_text" value="<?php if($_POST['sac_code']) echo $_POST['sac_code']; else echo $data_sac_code['sac_code']; ?>"  />
		</td>
	</tr>
	 <tr>
		<td width="10%" class="tr-header" align="center">Select Category</td>
		<td width="15%"><select name="category"  style="width:200px" class="input_text" id="category" onchange="show_category(this.value)">
		<option value="select">--Select--</option>
		<option  value="incoming" <?php if($_POST['category']=="incoming") echo 'selected="selected"'; elseif($row_record['category'] =="incoming") echo 'selected="selected"'; ?>>Incoming</option>
		<option value="business" <?php if($_POST['category']=="business") echo 'selected="selected"'; elseif($row_record['category'] =="business") echo 'selected="selected"'; ?>>Business</option>
		<option value="product" <?php if($_POST['category']=="product") echo 'selected="selected"'; elseif($row_record['category'] =="product") echo 'selected="selected"'; ?>>Product</option>
		<option value="bank" <?php if($_POST['category']=="bank") echo 'selected="selected"'; elseif($row_record['category'] =="bank") echo 'selected="selected"'; ?>>Bank</option>
		<option value="innocent" <?php if($_POST['category']=="innocent") echo 'selected="selected"'; elseif($row_record['category'] =="innocent") echo 'selected="selected"'; ?>>Innocent</option>
		<option value="other" <?php if($_POST['category']=="other") echo 'selected="selected"'; elseif($row_record['category'] =="other") echo 'selected="selected"'; ?>>Other</option>
		<option value="santosh" <?php if($_POST['category']=="santosh") echo 'selected="selected"'; elseif($row_record['category'] =="santosh") echo 'selected="selected"'; ?>>Santosh Sapke</option>
		<option value="voucher" <?php if($_POST['category']=="voucher") echo 'selected="selected"'; elseif($row_record['category'] =="voucher") echo 'selected="selected"'; ?>>Voucher</option>
		</select></td>
	</tr>

	<tr>
		<td colspan="3" align="center">
			<div id="cat_id"></div>
		</td>
	</tr>
	<!---------------------------------------Payment mode------------------------------------->  
	<tr>
		<td width="10%" class="tr-header" align="center">Select Payment Mode</td>
		<td width="25%"><select name="payment_mode" style="width:200px" class="input_text" id="payment_mode" onchange="payment(this.value)">
		<option value="select">--Select--</option>
		<?php
		$sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
		$ptr_payment_mode=mysql_query($sel_payment_mode);
		while($data_payment=mysql_fetch_array($ptr_payment_mode))
		{
			$selected='';
			if($data_payment['payment_mode_id'] == $row_record['payment_mode_id'])
			{
				$selected='selected="selected"';
			}
			echo '<option '.$selected.' value="'.$data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
		}
		?>
		</select></td>
	</tr>
    <tr>
    	<td colspan="2" >
        	<div id="petty_cash_types" <?php  if($data_payment_mode1['payment_mode']=='cash') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
        	<table width="100%" >
            	<tr>
                	<td width="13%" class="tr-header" align="center">Select Cash Type</td>
                    <td width="35%"><input type="radio" name="cash_type" id="cash_type" value="petty_cash" <?php if($_POST['cash_type']=='petty_cash') echo 'checked="checked"'; else if($row_record['cash_type']=='petty_cash') echo 'checked="checked"';?> /> Petty Cash  &nbsp;&nbsp;<input type="radio" name="cash_type" id="cash_type" value="business_cash" <?php if($_POST['cash_type']=='business_cash') echo 'checked="checked"'; else if($row_record['cash_type']=='business_cash') echo 'checked="checked"'; ?> /> Business Cash</td>
                </tr>
            </table>
            </div>
        </td>
    </tr>
	<tr>
		<td colspan="3">
			<div id="bank_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
			<table width="100%">
				<tr>
					<td width="27%" class="tr-header" align="center">ISAS Bank Name</td>
					<td>
						<?php 
						if($_SESSION['type'] !="S"  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' )
						{
						?>
							<select name="bank_name" id="bank_name" style="width:200px" class="input_text" onchange="show_acc_no(this.value)">
							<option value="">--Select--</option>
							<?php
							$sle_bank_name="select bank_id,bank_name from bank ".$_SESSION['where_cm_id'].""; 
							$ptr_bank_name=mysql_query($sle_bank_name);
							while($data_bank=mysql_fetch_array($ptr_bank_name))
							{
								$selected='';
								if($data_bank['bank_id'] == $row_record['bank_id'])
								{
									$selected='selected="selected"';
								}
								 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
							}
							?>
							</select>
							<?php
						}
						?>
		
						<div id="bank_record">
							<?php 
							if($record_id !='')
							{
								?>
								<select name="bank_name" id="bank_name" style="width:200px" class="input_text" onChange="show_acc_no(this.value)">
								<option value="">--Select--</option>
								<?php
								echo $sle_bank_name="select bank_id,bank_name from bank where cm_id='".$row_record['cm_id']."'"; 
								$ptr_bank_name=mysql_query($sle_bank_name);
								while($data_bank=mysql_fetch_array($ptr_bank_name))
								{
									$selected='';
									if($data_bank['bank_id'] == $row_record['bank_id'])
									{
										$selected='selected="selected"';
									}
									echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
								}
								?>
								</select>
								<?php
							}
							?>
						</div>
						<div id="bank_id"></div>
					</td>
				</tr>
				<tr>
					<td width="15%" class="tr-header" align="center">ISAS Account No</td>
					<td><input type="text" name="account_no" style="width:200px" class="input_text" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
				</tr>
			</table>
			</div>
            <div id="bank_ref_no" <?php if($_POST['payment_type'] =='online-5') echo 'style="display:block"'; else if($data_invoice['paid_type'] =='5') echo 'style="display:block"';  else echo 'style="display:none"'; ?>>
                <table width="100%">
                    <tr>
                        <td width="6%" class="tr-header" align="center">Bank Ref. no</td>
                        <td width="35%"><input type="text" name="bank_ref_no" class="input_text" style="width:200px" id="bank_ref_no" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $data_invoice['bank_ref_no']; ?>"/></td>
                    </tr>
                </table>
            </div>
			<div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
			<table width="100%">
				<tr>
					 <td class="tr-header" width="27%" style="width:200px" align="center">Enter Chaque No.</td>
					  <td><input type="text" name="chaque_no" style="width:200px" class="input_text" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
				</tr>
				<tr>
					<td width="27%" class="tr-header" align="center">Enter Chaque Date</td>
					<td><input type="text" name="date" id="date" style="width:200px" class="input_text datepicker" value="<?php if($_POST['date']) echo $_POST['date']; else echo $row_record['chaque_date']; ?>"  /></td>
				</tr>
			</table>
			</div>
			<div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
			<table width="100%">
                <tr>
                    <td width="27%" class="tr-header" align="center">Customer Bank Name</td>
                    <td><input type="text" name="cust_bank_name" id="cust_bank_name" style="width:200px" class="input_text" maxlength="4" value="<?php if($_POST['cust_bank_name']) echo $_POST['cust_bank_name']; else echo $row_record['cust_bank_name']; ?>" /></td>
                </tr>
				<tr>
					<td width="27%" class="tr-header" align="center">Customer Credit Card No</td>
					<td><input type="text" name="credit_card_no" id="credit_card_no" style="width:200px" class="input_text" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>
				</tr>
			</table>
			</div>
		</td>
	</tr>
    <tr>           		
        <td width="10%" align="center">Select Employee Type<span class="orange_font"></span></td>
        <td>
        <select id="user" name="user" class="input_text" onChange="show_data(this.value)" style="width:200px">
        <option value="">--Select--</option>
        <option value="Student" <?php if($row_record['emp_type']=="Student") echo 'selected="selected"'?>>Student</option>
        <option value="Customer" <?php if($row_record['emp_type']=="Customer") echo 'selected="selected"' ?>>Customer</option>
        <option value="Employee" <?php if($row_record['emp_type']=="Employee") echo 'selected="selected"' ?>>Employee</option>
        <option value="Vendor" <?php if($row_record['emp_type']=="Vendor") echo 'selected="selected"' ?>>Vendor</option>
        </select>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="left" style="width:85%">
            <div id="show_type">
            <?php
			if($record_id)
			{
				if($row_record['emp_type']=='Customer')
				{
					?>
					<table style="width:100%;">
					<tr>
						<td style="width:27%;" align="center">Search by Mobile no.</td>
						<td>
						<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php echo $_POST['id']; ?>')">
						<option value="">Select Mobile No.</option>
						<?php  
							$sql_cust = "select mobile1,cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
							$ptr_cust = mysql_query($sql_cust);
							while($data_cust = mysql_fetch_array($ptr_cust))
							{
								echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
							}
						?>
						</select>
						</td>
					</tr> 
					<tr>
						<td style="width:27%;" align="center">Select Customer<span class="orange_font">*</span></td>
						<td width="70%" id="sel_cust" class="customized_select_box">
						<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
						<option value="">Select Customer</option> 
						<?php  
						$sql_cust = "select cust_name,cust_id from customer where 1 ".$_SESSION['where']." or cust_id='1113' or cust_id='1212' or cust_id='1805' or cust_id='18' order by cust_id asc";
						$ptr_cust = mysql_query($sql_cust); // 1212 = Ahmednagar, 1113= PCMC, 1805=Pune,18=Ahmedbad
						while($data_cust = mysql_fetch_array($ptr_cust))
						{
							$selecteds='';
							if($data_cust['cust_id']==$row_record['customer_id'])
							{
								$selecteds="selected='selected'";
							}
							echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
						}
						?>
						<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option>
						</select>
						<td width="10%"></td>
					</tr>
					</table>
				<?php
				}
				else if($row_record['emp_type']=='Student')
				{
					?>
					<table style="width:100%;">
						<tr>
							
							<td style="width:27%;" align="center">Search by Mobile no.</td>
							<td>
							<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php echo $_POST['id']; ?>')">
							<option value="">Select Mobile No.</option>
							<?php  
								$sql_cust = "select contact,enroll_id from enrollment where 1 ".$_SESSION['where']." and ref_id='0' order by enroll_id asc";
								$ptr_cust = mysql_query($sql_cust);
								while($data_cust = mysql_fetch_array($ptr_cust))
								{ 
									echo "<option value='".$data_cust['contact']."' ".$selecteds.">".$data_cust['contact']."</option>";
								}
								?>
							</select>
							</td>
						</tr> 
						<tr>
							<td style="width:27%;" align="center">Select Student<span class="orange_font">*</span></td>
							<td width="70%" id="sel_cust" class="customized_select_box">
							<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
							<option value="">Select Student</option> 
							<?php  
							$sql_cust = "select name, enroll_id from enrollment where 1 ".$_SESSION['where']." and ref_id='0' order by enroll_id asc";
							$ptr_cust = mysql_query($sql_cust);
							while($data_cust = mysql_fetch_array($ptr_cust))
							{ 
								$selecteds='';
								if($data_cust['enroll_id']==$row_record['customer_id'])
								{
									$selecteds="selected='selected'";
								}
								echo "<option value='".$data_cust['enroll_id']."' ".$selecteds.">".$data_cust['name']."</option>";
							}
							?>
							<!--<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option>-->
							</select>
							<td width="10%"></td>
						</tr>
					</table>
					<?php
				}
				else if($row_record['emp_type']=='Employee')
				{
					?>
					<table style="width:100%;">
						<tr>
							
							<td style="width:27%;" align="center">Search by Mobile no.</td>
							<td>
							<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php echo $_POST['id']; ?>')">
							<option value="">Select Mobile No.</option>
							<?php  
							$sql_cust = "select contact_phone,admin_id from site_setting where 1 ".$_SESSION['where']." order by admin_id asc";
							$ptr_cust = mysql_query($sql_cust);
							while($data_cust = mysql_fetch_array($ptr_cust))
							{                 	           
								echo "<option value='".$data_cust['contact_phone']."' ".$selecteds.">".$data_cust['contact_phone']."</option>";
							}
							?>
							</select>
							</td>
						</tr> 
						<tr>
							<td style="width:27%;" align="center">Select Employee<span class="orange_font">*</span></td>
							<td width="70%" id="sel_cust" class="customized_select_box">
							<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
							<option value="">Select Employee</option> 
							<?php  
							$sql_cust = "select name, admin_id from site_setting where 1 ".$_SESSION['where']." order by admin_id asc";
							$ptr_cust = mysql_query($sql_cust);
							while($data_cust = mysql_fetch_array($ptr_cust))
							{
								$selecteds='';
								if($data_cust['admin_id']==$row_record['customer_id'])
								{
									$selecteds="selected='selected'";
								}
								echo "<option value='".$data_cust['admin_id']."' ".$selecteds.">".$data_cust['name']."</option>";
							}
							?>
							<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option>
							</select>
							<td width="10%"></td>
						</tr>
					</table>
					<?php
				}
				else if($row_record['emp_type']=='Vendor')
				{
					?>
					<table style="width:100%;">
						<tr>
							<input type="hidden" name="res1" id="res1" />
							<input type="hidden" name="res_tax" id="res_tax" />
							<td style="width:16%;" align="center">Search by Mobile no.</td>
							<td>
							<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php echo $_POST['id']; ?>')">
							<option value="">Select Mobile No.</option>
							<?php  
							$sql_cust = "select contact,vendor_id from vendor where 1 ".$_SESSION['where']." order by vendor asc";
							$ptr_cust = mysql_query($sql_cust);
							while($data_cust = mysql_fetch_array($ptr_cust))
							{
								echo "<option value='".$data_cust['contact']."' ".$selecteds.">".$data_cust['contact']."</option>";
							}
							?>
							</select>
							</td>
						</tr> 
						<tr>
							<td style="width:27%;" align="center">Select Vendor<span class="orange_font">*</span></td>
							<td width="70%" id="sel_cust" class="customized_select_box">
							<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
							<option value="">Select Vendor</option> 
							<?php  
							$sql_cust = "select contact,vendor_id,name from vendor where 1 ".$_SESSION['where']." order by vendor_id asc";
							$ptr_cust = mysql_query($sql_cust);
							while($data_cust = mysql_fetch_array($ptr_cust))
							{
								$selecteds='';
								if($data_cust['vendor_id']==$row_record['customer_id'])
								{
									$selecteds="selected='selected'";
								}
								echo "<option value='".$data_cust['vendor_id']."' ".$selecteds.">".$data_cust['name']."</option>";
							}
							?>
							</select>
							<td width="10%"></td>
						</tr>
					</table>
					<?php
				}
			}
			?>
            </div>
        </td>
    </tr>
	<tr>
		<td width="10%" class="tr-header" align="center">Amount</td>
		<td width="25%"><input type="text" name="amount_wo_tax" id="amount_wo_tax" onBlur="calculte_amount_tax('0')" style="width:200px" class="input_text" value="<?php if($_POST['amount_wo_tax']) echo $_POST['amount_wo_tax']; else echo $row_record['amount_wo_tax']; ?>"  /></td>
	</tr>
 <!--===========================================================NEW TABLE 2 START===================================-->   
	<tr>
		<td width="10%" align="center">Tax<span class="orange_font">*</span></td>
		<td colspan="1">
		<table  width="100%" style="border:1px solid gray; ">
			<tr>
			<td colspan="2">
			<table cellpadding="5" width="100%" >
				<tr>
					<?php
					if($record_id =='')
					{
						?>
						<input type="hidden" name="type1" id="type1" class="inputText" size="1" onKeyUp="create_type1();" value="0" />
						<?php 
					}?>
					<script language="javascript">
					function type1(idss)
					{
						res1= document.getElementById("res1").value;
						//alert(idss);
						var shows_data='<div id="type1_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="8%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="" /><select name="tax_type'+idss+'" class="input_text" id="tax_type'+idss+'" ><option value="">Select Tax</option>'+res1+'</select></td><td valign="top" width="8%" align="left"><input type="text" class="input_text" name="tax_value'+idss+'" id="tax_value'+idss+'" onKeyUp="calculte_amount_tax('+idss+')"/><input type="hidden" name="tax_amount'+idss+'" id="tax_amount'+idss+'" /></td><input type="hidden" name="total_tax[]" id="total_tax'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
						document.getElementById('total_type1').value=idss;
						return shows_data;
					}                                         
					</script>
					<td align="right">
						<input type="button" name="Add"  class="addBtn" onClick="javascript:create_type1('add_type1');" alt="Add(+)" > 
						<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_type1('delete_type1');" alt="Delete(-)" >
					</td>
				</tr>
				<tr>
					<td></td><td align="left"></td>
				</tr>
			</table> 
			<table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
				<tr>
					<td align="center"></td><td align="center"></td><td align="center"></td>
				</tr>
				<tr>
					<td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td>
				</tr>
				<tr>
					<td colspan="7">
						<table cellspacing="3" id="tbl" width="100%">
							<tr>
								<td valign="top" width="8%" align="center">Tax Type</td>
								<td valign="top" width="8%"  align="center">Tax Value(in %)</td>  
							</tr>
							<tr>
						<td colspan="7">
						<?php
						if($record_id)
						{
							$select_exc = "select * from receipt_tax_map where receipt_id='".$record_id."' order by receipt_tax_map_id asc ";
							$ptr_fs = mysql_query($select_exc);
							$s=1;
							$total_comision= mysql_num_rows($ptr_fs);
							$total_conditions= mysql_num_rows($ptr_fs);
							while($data_exclusive = mysql_fetch_array($ptr_fs))
							{ 
								$slab_id= $data_exclusive['receipt_tax_map_id'];
								?> 
								<div class="type1" id="type1_id<?php echo $s; ?>">
								<table cellspacing="5" id="tbl<?php echo $s; ?>" width="100%">
								<tr>
								<td width="8%" align="center">
							   
								<select name="tax_type<?php echo $s; ?>" id="tax_type<?php echo $s; ?>">
								<option value="">Select Tax</option>
								<?php
								$cm_ids='';
								if($record_id )
								{
									$cm_ids="and cm_id='".$row_record['cm_id']."'";
								}
								$sql_tax = " select tax_name from tax_type where 1 ".$cm_ids."";
								$ptr_tax = mysql_query($sql_tax);
								while($data_tax = mysql_fetch_array($ptr_tax))
								{
									$selected='';
									if($data_tax['tax_name']==$data_exclusive['tax_type'] )
									{
										$selected='selected="selected"';
									}
									echo '<option value="'.$data_tax['tax_name'].'" '.$selected.'>'.$data_tax['tax_name'].'</option>';
								}
								?>
								</select>
								<!--<input type="hidden" name="tax_type<?php //echo $s; ?>" id="tax_type<?php echo $s; ?>" style=" width:100px" value="<?php //echo $data_exclusive['tax_type'] ?>" />-->                               
								</td>
								<td width="8%" align="center">
								<input type="hidden" name="tax_amount<?php echo $s; ?>" id="tax_amount<?php echo $s; ?>" value="<?php echo $data_exclusive['tax_amount'] ?>"/>
								<input type="text" name="tax_value<?php echo $s; ?>" id="tax_value<?php echo $s; ?>" style=" width:100px" value="<?php echo $data_exclusive['tax_value'] ?>" onKeyUp="calculte_amount_tax(<?php echo $s; ?>)"/></td><td width="8%"> </td>
								<td valign="top" width="10%" align="center">
								<?php
								if($record_id)
								{
								?>
									<input type="hidden" name="total_tax[]" id="total_tax<?php echo $s; ?>" />
									<input type="hidden" name="type1_id<?php echo $s;?>" id="type1_id<?php echo $s; ?>" value="<?php echo $data_exclusive['receipt_tax_map_id'] ?>" />
									<input type="button" title="Delete Options(-)" onClick="delete_tax(<?php echo $s; ?>,'total_type1');" class="delBtn" name="del">
									<input type="hidden" name="del_floor_type1<?php echo $s; ?>" id="del_floor_type1<?php echo $s; ?>" value="" />
								<?php 
								} ?>   
								</td>
								</tr>
							   </table>
							   </div>
								<?php
							$s++;
							}
						}
							 ?>
						</tr> 
				</table>
				<div id="create_type1"></div>
			</td></tr></table>
			<?php
			if($record_id)
			{
				?>
				<input type="hidden" name="total_type1" id="total_type1" class="inputText"   value="<?php echo $total_conditions; ?>" />
				<input type="hidden" name="type1" id="type1" class="inputText" value="<?php echo $total_conditions; ?>" />
				<?php  
			}
			else
			{
				?>
				<input type="hidden" name="total_type1" id="total_type1"  value="0" />
				<?php
			}
			?> 
			</td>
			</tr>
		</table>
		</td>
	</tr>

       <!--============================================================END TABLE 2=========================================-->
	<tr>
		<td width="10%" class="tr-header" align="center">Amount</td>
		<td width="25%"><input type="text" name="amount" id="amount" style="width:200px" class="input_text" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount']; ?>"  /></td>
	</tr>
	<tr>
	  <tr>
		<td width="10%" class="tr-header" align="center">Description</td>
		<td width="25%"><textarea name="description" id="description" style="width:300px;height:70px" class="input_text" ><?php if($_POST['description']) echo $_POST['description']; else echo $row_record['description']; ?></textarea></td>
	</tr>
	<tr>
		<?php
		$select_amnt1="select SUM(amount) as total from receipt where cash_type='petty_cash' order by receipt_id desc limit 0,1";
		$ptr_amt1=mysql_query($select_amnt1);
		$total_amount1=0;
		if(mysql_num_rows($ptr_amt1))
		{
			$data_amnt1=mysql_fetch_array($ptr_amt1);
			$total_amount1=$data_amnt1['total'];
		}
		?>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
		<td align="center" colspan="2"><input type="submit" onclick="return validme()" name="save_changes" value="Save"  /> Total Petty Cash : <?php echo $total_amount1; ?></td>
	</tr>
</table>
</form>
<?php
	}
?>
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="11">
    <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                </select></td>
                <td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
    <?php
						$from_date="";
						$to_date="";
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_dates=explode("/",$_REQUEST['to_date']);
							$to_date=$to_dates[2]."-".$to_dates[1]."-".$to_dates[0];
							
							$to_date=" and added_date<='".date('Y-m-d',strtotime($to_date))."'";
						}
							
						
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
						{
							$cm_id_filter='';
							$sel_branch="select cm_id from site_setting where branch_name like '".$keyword."' "; 
							$ptr_branch=mysql_query($sel_branch);     
							if(mysql_num_rows($ptr_branch)) 
							{
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id_filter="|| cm_id = '".$data_branch['cm_id']."'";
							} 
							
							$pay_mode_filter='';
							$sel_pay_id="select payment_mode_id from payment_mode where payment_mode like '%".$keyword."%' "; 
							$ptr_pay_id=mysql_query($sel_pay_id);    
							if(mysql_num_rows($ptr_pay_id)) 
							{
								$data_pay_id=mysql_fetch_array($ptr_pay_id);
								$pay_mode_filter="|| payment_mode_id = '".$data_pay_id['payment_mode_id']."'";
							}  
							$bank_name_filter='';
							$select_bank = " select bank_id from bank where bank_name like '%".$keyword."%' ";
							$ptr_bank = mysql_query($select_bank);
							if($total=mysql_num_rows($ptr_bank))
							{
								while($data_bank_name = mysql_fetch_array($ptr_bank))
								{
									$bank_name_filter.= " || bank_id =".$data_bank_name['bank_id'];
								}
							}
							
							/*$enquiry_added='';
							$sel_enq="select admin_id from site_setting where name like '%".$keyword."%'";
							$ptr_enq=mysql_query($sel_enq);
							if(mysql_num_rows($ptr_enq))
							{
								$data_enq=mysql_fetch_array($ptr_enq);
								$enquiry_added="|| admin_id = '".$data_enq['admin_id']."'";
							}*/
							
							$pre_keyword =" and (category like '%".$keyword."%' ".$cm_id_filter." ".$pay_mode_filter." ".$bank_name_filter." || chaque_no like '%".$keyword."%' || chaque_date like '%".$keyword."%' || amount like '%".$keyword."%')";
						}
                        else
                            $pre_keyword="";

                        if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
                        
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;

                        if($_GET['order']=='asc')
                        {
                            $order='desc';
                            $img = "<img src='images/sort_up.png' border='0'>";
                        }
                        else if($_GET['order']=='desc')
                        {
                            $order='asc';
                            $img = "<img src='images/sort_down.png' border='0'>";
                        }
                        else
                            $order='desc';

                        if($_GET['orderby']=='category' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='receipt_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by added_date desc';  
							
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and receipt_id='".$_GET['record_id']."' ";
							
						}                     
                        $sql_query= "SELECT * FROM receipt where 1 ".$record_cat_id." ".$where_receipt." ".$_SESSION['where']." ".$pre_keyword." ".$from_date." ".$to_date." and category !='cash_transfer' ".$select_directory." "; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
                      <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                      <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                      <?php
                      if($_SESSION['type']=='S' || $edit_access=='yes'   )
                      {
                      	?>								
                        <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                        <?php } ?>
                       	<td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <?php //echo $img1;?></td>
                        <td width="10%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Category Name</strong></a>
                        <?php
                        if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
                        {
                            ?>
                            <td width="8%" align="center"><strong>Branch Name</strong></td>
                            <?php } ?>
                            <td width="8%" align="center"><strong>Payment Mode</strong></td>
                            <td width="12%" align="center"><strong>Payment Details</strong></td>
                            <td width="8%" align="center"><strong>Amount</strong></td>
                            <td width="12%" align="center"><strong>Description</strong></td>
                            <td width="12%" align="center"><strong>Customer/Vendor name</strong></td>
                            <td width="8%" align="center"><strong>Added date</strong></td>
                            <!--<td width="15%"><strong>Tag</strong></td>
                            <td width="20%" class="centerAlign"><strong>Image</strong></td>-->
                            <?php
                            if($_SESSION['type']=='S' || $edit_access=='yes'   )
                            {
                                ?>
                                <td width="8%" class="centerAlign"><strong>Action</strong></td>
                                <?php 
                            } ?>
                            </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['receipt_id']; 
                                include "include/paging_script.php";
								$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."'";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_expense_type="select expense_type from expense_type where expense_type_id='".$val_query['expense_type_id']."'";
								$ptr_expense_type=mysql_query($sel_expense_type);
								$data_expense_type=mysql_fetch_array($ptr_expense_type);
								
								$sel_bank="select bank_name from bank where bank_id='".$val_query['bank_id']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
								$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='S' || $edit_access=='yes'   )
								{
                                    echo'<td align="center" align="center">';	
									echo '<input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">';
									echo'</td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';      
								if($_SESSION['type']=='S'  || $edit_access=='yes'  )
								{
									echo '<td align="center"><a href="receipt.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['category'].'</a></td>';
								}
								else
									echo '<td align="center">'.$val_query['category'].'</td>';
								if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
								{
									echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								}
								echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
								
								
								if($val_query['payment_mode_id']!="1" && $val_query['payment_mode_id']!="3" && $val_query['payment_mode_id']!="6" && $val_query['payment_mode_id']!="8")
								{
									echo '<td align="center">';
									echo'<strong>ISAS Bank:</strong> '.$data_bank_name['bank_name'].'<br/><strong>Cust. Bank:</strong> '.$val_query['cust_bank_name'].'';
									if($val_query['payment_mode_id']=="4")
									{
										echo '<br/>><strong>CC No:</strong> '.$val_query['credit_card_no'].'';
									}
									if($val_query['payment_mode_id']=="5")
									{
										echo '<br/>><strong>Bank Ref. No:</strong> '.$val_query['credit_card_no'].'';
									}
									if($val_query['payment_mode_id']=="2")
									{
										echo '<br/>><strong>Chaque No:</strong> '.$val_query['chaque_no'].'<br/><strong>Chaque Date:</strong> '.$val_query['chaque_date'].'';
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center"></td>';
								}
                                echo '<td align="center">'.$val_query['amount'].'</td>';
								echo '<td align="center">'.$val_query['description'].'</td>';
								$name='';
								if($val_query['emp_type']=="Student")
								{
									$sel_student="select name from enrollment where enroll_id='".$val_query['customer_id']."'";
									$ptr_stud=mysql_query($sel_student);
									$data_stud=mysql_fetch_array($ptr_stud);
									$name=$data_stud['name'];
								}
								else if($val_query['emp_type']=="Customer")
								{
									$sel_cust="select cust_name from customer where cust_id='".$val_query['customer_id']."'";
									$ptr_cust=mysql_query($sel_cust);
									$data_cust=mysql_fetch_array($ptr_cust);
									$name=$data_cust['cust_name'];
								}
								else if($val_query['emp_type']=="Employee")
								{
									$sel_emp="select name from site_setting where admin_id='".$val_query['customer_id']."'";
									$ptr_emp=mysql_query($sel_emp);
									$data_emp=mysql_fetch_array($ptr_emp);
									$name=$data_emp['name'];
								}
								else if($val_query['emp_type']=="Vendor")
								{
									$sel_vendor="select name from vendor where vendor_id='".$val_query['customer_id']."'";
									$ptr_vendor=mysql_query($sel_vendor);
									$data_vendor=mysql_fetch_array($ptr_vendor);
									$name=$data_vendor['name'];
								}
								echo '<td align="center">'.$name.'</td>';								
								echo '<td align="center">'.$val_query['added_date'].'</td>';
								
								if($_SESSION['type']=='S'  || $edit_access=='yes' )
								{
									echo '<td align="center"><a href="receipt.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									echo '</td>';
								}
                                echo '</tr>';
                                $bgColorCounter++;
                            }    
                            ?>
  <tr class="head_td">
    <td colspan="11">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                      if($no_of_records>10)
                            {
                                echo '<td width="3%" align="left">Show</td>
                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                $show_records=array(0=>'10',1=>'20','50','100');
                                for($s=0;$s<count($show_records);$s++)
                                {
                                    if($_SESSION['show_records']==$show_records[$s])
                                        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                    else
                                        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                }
                                echo'</td></select>';
                            }
                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';                         
                 ?>                                    
            </tr>
        </table>            
    </td>
    </tr></form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No category found related to your search criteria, please try again</div><br></td></tr>';?>
</table>

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
<!--footer start-->
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
<?php
if($record_id)
{
	if($row_record['category']=="voucher")
	{
		?>
        <script>
		category=document.getElementById("category").value;
		show_category(category);
		</script>
        <?php
	}
	?>
	<!--<script>
		user=document.getElementById("user").value;
		if(user!='')
		{
			show_data(user);
		}
	</script>-->
	<?php
}
?>
<script>
branch_name =document.getElementById("branch_name").value;
//alert(branch_name);
show_bank(branch_name);
//alert(branch_name);
</script>
   
</body>
</html>
