<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM sales_package_voucher_memb where id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
		
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no,bank_name from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?>Customer Membership</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
    
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	var pageName="sales_package_memb_voucher";
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			$("#category").chosen({allow_single_deselect:true});
			
        });
    </script>
    	<script>
function send()
{								  

	branch =document.getElementById('branch_name');
	var branch_name=branch.options[branch.selectedIndex].text; 
	cat =document.getElementById('category').value;
	
	var realtxt =document.getElementById('realtxt').value;
	cust=document.getElementById('cust_id');
	var cust_id=cust.options[cust.selectedIndex].text;
	var memb_disc=document.getElementById('memb_disc').value;
	var days=document.getElementById('days').value;
	var memb_price=document.getElementById('memb_prices').value;
	
	var vouchers_name =document.getElementById('vouchers_name').value;
	
	var vouchers_start_date =document.getElementById('vouchers_start_date').value;
	var vouchers_end_date =document.getElementById('vouchers_end_date').value;
	var vouchers_price =document.getElementById('vouchers_price').value;
	var redeems_price =document.getElementById('redeems_price').value;
	var total_quantities =document.getElementById('total_quantities').value;
	var issue_qty =document.getElementById('issue_qty').value;
	var selling_amount =document.getElementById('selling_amount').value;
	var total_type1 =document.getElementById('total_type1').value;
	concat='';
	for(i=1; i<=total_type1; i++)
	{
	tax =document.getElementById('tax_type'+i);
	var tax_type=tax.options[tax.selectedIndex].text;
	tax_value =document.getElementById('tax_value'+i).value;
	concat_string_voucher +='&tax_type'+i+'='+tax_type+'&tax_value'+i+'='+tax_value;  
	} 
	var dob =document.getElementById('dob').value;
	var start_date =document.getElementById('start_date').value;
	var end_date =document.getElementById('end_date').value;
	var amount =document.getElementById('amount').value;
	payment=document.getElementById('payment_mode');
	var payment_mode=payment.options[payment.selectedIndex].text; 
	
		data1='action=sale&branch_name='+branch_name+'&category='+category+'&realtxt='+realtxt+'&cust_id='+cust_id+'&voucher_id='+voucher_id+'&vouchers_name='+vouchers_name+'&vouchers_start_date='+vouchers_start_date+'&vouchers_end_date='+vouchers_end_date+'&vouchers_price='+vouchers_price+'&redeems_price='+redeems_price+'&total_quantities='+total_quantities+'&issue_qty='+issue_qty+'&selling_amount='+selling_amount+'&total_type1='+total_type1+'&tax_type='+tax_type+'&tax_value='+tax_value+'&dob='+dob+'&start_date='+start_date+'&end_date='+end_date+'&amount='+amount+'&payment_mode='+payment_mode+concat_string_voucher;
		$.ajax({
		url:'http://www.htdpt.in/tracking/send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
		success: function(response)
		{
			return true;
		}
		});
}

</script>
<script>
function payment(value)
{
	payment_mode=value.split("-")
	//alert(payment_mode[0]);
	var branch_name=document.getElementById("branch_name").value;
	if(payment_mode[0]=="cheque")
	{
		document.getElementById("chaque_details").style.display = 'block';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		show_bank_for_payment_mode(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"paytm")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"")
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
		//alert(html);
		 document.getElementById('account_no').value=html;
	}
	});
}
function getMembership(membership_id)
{
	var data1="membership_id="+membership_id;	
	//alert(data1);
        $.ajax({
            url: "get_membership_discount.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				if(html.trim() =='')
				{
					document.getElementById('membership_div_id').style.display="none";
				}
				else
				{
					document.getElementById('membership_div_id').style.display="block";
					var sep_val=html.split("-",3);
					var memb_disc= sep_val[0].trim();
					var amount= sep_val[1].trim();
					var days= sep_val[2].trim();
					
					document.getElementById('memb_disc').innerHTML=memb_disc;
					document.getElementById('memb_prices').value=amount;
					document.getElementById("memb_price").innerHTML=amount;
					document.getElementById("days").value=days;
					document.getElementById("dayss").innerHTML=days;
				}
            }
            });
}
function getPackage(package_id)
{
	var data1="package_id="+package_id;	
	//alert(data1);
        $.ajax({
            url: "get_package_details.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				
				var new_html=html.split("###");
				if(new_html[0].trim() =='')
				{
					document.getElementById('package_div_id').style.display="none";
				}
				else
				{
					//alert(new_html[0]);
					document.getElementById('package_div_id').style.display="block";
					var sep_val=new_html[0].split("/");
					
					var name= sep_val[0].trim();
					var price= sep_val[1].trim();
					var start_date= sep_val[2].trim();
					var end_date= sep_val[3].trim();
					var pkg_qty= sep_val[4].trim();
					
					var date1 = new Date(start_date);
					var date2 = new Date(end_date);
					var timeDiff = Math.abs(date2.getTime() - date1.getTime());
					var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
					
					document.getElementById('package_name').innerHTML=name;
					document.getElementById("package_names").value=name;
					document.getElementById("pkg_price").innerHTML=price;
					document.getElementById("pkg_prices").value=price; 
					document.getElementById("package_start_date").innerHTML=start_date;
					document.getElementById("package_start_dates").value=start_date;
					document.getElementById("package_end_date").innerHTML=end_date;
					document.getElementById("package_end_dates").value=end_date;
					document.getElementById("pkg_qty").innerHTML=pkg_qty;
					document.getElementById("pkg_qtys").value=pkg_qty; 
					document.getElementById("amount").value=price;
					
					document.getElementById("days").value=diffDays;
					document.getElementById("show_qty_div").style.display="block";
				}
            }
            });
}
function getVoucher(voucher_id)
{
	var data1="action=sales&voucher_id="+voucher_id;	
	//alert(data1);
	$.ajax({
		url: "get_voucher_details.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			var new_html=html.split("###");
			if(new_html[0].trim() =='')
			{
				document.getElementById('voucher_div_id').style.display="none";
			}
			else
			{
				document.getElementById('voucher_div_id').style.display="block";
				var sep_val=new_html[0].split("/");
				var name= sep_val[0].trim();
				var price= sep_val[1].trim();
				var start_date= sep_val[2].trim();
				var end_date= sep_val[3].trim();
				var quantity= sep_val[4].trim();
				var categories= sep_val[5].trim();
				var redeem_price= sep_val[6].trim();
				//alert(redeem_price);
				var date1 = new Date(start_date);
				var date2 = new Date(end_date);
				var timeDiff = Math.abs(date2.getTime() - date1.getTime());
				var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
				//alert(diffDays);
				//alert(quantity);
				//alert(categories);
				document.getElementById('voucher_name').innerHTML=name;
				document.getElementById("vouchers_name").value=name;
				document.getElementById("voucher_price").innerHTML=price;
				document.getElementById("vouchers_price").value=price;
				document.getElementById("voucher_start_date").innerHTML=start_date;
				document.getElementById("vouchers_start_date").value=start_date;
				document.getElementById("voucher_end_date").innerHTML=end_date;
				document.getElementById("vouchers_end_date").value=end_date;
				document.getElementById("total_quantity").innerHTML=quantity;
				document.getElementById("total_quantities").value=quantity;
				document.getElementById("categories").value=categories;
				document.getElementById("redeem_price").innerHTML=redeem_price;
				document.getElementById("redeems_price").value=redeem_price;
				document.getElementById("amount").value=price;
				document.getElementById("days").value=diffDays;
				document.getElementById("show_qty_div").style.display="block";
				/*if(categories=="service")
				{
					document.getElementById("show_qty_div").style.display="block";
				}
				else
				{
					document.getElementById("show_qty_div").style.display="block";
				}*/
				
				//document.getElementById("selling_amount").value=price;
				//qty=document.getElementById("issue_qty").value;
				//show_quantities(qty);
				//getVoucher_code(voucher_id,qty)
			}
		}
		});
}
function getVoucher_code(voucher_id,qty)
{
	var data1="voucher_id="+voucher_id+"&qty="+qty;	
	//alert(data1);
	$.ajax({
	url: "get_voucher_code.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html =='')
		{
			document.getElementById('show_codes').style.display="none";
		}
		else
		{
			document.getElementById('show_codes').style.display="block";
			document.getElementById('show_codes').innerHTML=html;
		}
	}
	});
}
function validme()
{
	 frm = document.jqueryForm;
	 error='';
	 disp_error = 'Clear The Following Errors : \n\n';
	
	 if(frm.category.value=='')
	 {
		 disp_error +='Select category\n';
		 document.getElementById('category').style.border = '1px solid #f00';
		 frm.category.focus();
		 error='yes';
	 }
	
	 if(frm.start_date.value=='')
	 {
		 disp_error +='Enter Start Date   \n';
		 document.getElementById('start_date').style.border = '1px solid #f00';
		 frm.start_date.focus();
		 error='yes';
	 }
	 if(frm.end_date.value=='')
	 {
		 disp_error +='Enter End Date\n';
		 document.getElementById('end_date').style.border = '1px solid #f00';
		 frm.end_date.focus();
		 error='yes';
	 }
	 /*if(frm.payment_mode.value=='')
	 {
		 disp_error +='Select Payment Mode \n';
		 document.getElementById('payment_mode').style.border = '1px solid #f00';
		 frm.payment_mode.focus();
		 error='yes';
	 }*/
	 if(frm.amount.value=='')
	 {
		 disp_error +='Enter Amount \n';
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
		 return send();
	 }
	 return true;
}
function getdate() 
{
    var tt = document.getElementById('start_date').value;
	sep = tt.split("/");
	var tt=sep[1]+"/"+sep[0]+"/"+sep[2];
	var days = Number(document.getElementById('days').value);
	//alert(days);
    var date = new Date(tt);
	
	
    var newdate = new Date(date);
	//alert(newdate);
    newdate.setDate(newdate.getDate() + days);
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = dd + '/' + mm + '/' + y;
    document.getElementById('end_date').value = someFormattedDate;
}
function searchSel(value) 
{
	var data1="mobile_no="+value;	
        $.ajax({
		url: "get_name.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			 //Clear already selected option
			$("#cust_id option").removeAttr("selected");
			//Set option with value 2 as selected
			$("#cust_id option[value="+html+"]").attr("selected", "selected");
			/*var optionss = document.getElementById('cust_id').options;
			//alert(optionss.length);
			for(var i = 0; i < optionss.length; i++) {
				//alert(optionss[i].value+"-"+html)
				if(optionss[i].value == html) {
					alert(optionss[i].value);
					optionss[i].selected = true;
					break;
				}
			}*/
			//alert(html);
			//document.getElementById("cust_id").selectedIndex.value = html;
			
		}
		});
}
function show_customer(value)
{
	//alert(value);
	dataval=value.trim();
	
	if(dataval=="Voucher")
	{
		document.getElementById("show_vouchers_codes").style.display="block";
		document.getElementById("show_qty_div").style.display="block";
	}
	else if(dataval=="Package")
	{
		document.getElementById("show_qty_div").style.display="block";
	}
	else
	{
		//alert("hi");
		document.getElementById("show_vouchers_codes").style.display="none";
		document.getElementById("show_qty_div").style.display="none";
	}
	customer_id='<?php echo $row_record['cust_id']; ?>';
	membership_id='<?php echo $row_record['membership_id']; ?>';
	package_id='<?php echo $row_record['package_id']; ?>';
	voucher_id='<?php echo $row_record['voucher_id']; ?>';
	var data_cust="action=show_customers_category&category="+dataval+"&customer_id="+customer_id+"&membership_id="+membership_id+"&package_id="+package_id+"&voucher_id="+voucher_id;
	$.ajax({
	url:"ajax.php", type: "post", data: data_cust, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html.trim() !='')
		{
			document.getElementById('show_customer').innerHTML=html;
		}
		$("#cust_id").chosen({allow_single_deselect:true});
		$("#membership_id").chosen({allow_single_deselect:true});
		$("#package_id").chosen({allow_single_deselect:true});
		$("#voucher_id").chosen({allow_single_deselect:true});

	}
});
}	
function show_mobile_no(vals)
{}
function show_quantities(value)
{
	//alert(value);
	var category=document.getElementById("category").value;
	//alert(category);
	if(category=="Voucher")
	{	
		
		var prices= Number(document.getElementById("vouchers_price").value);
		var exist_qty=Number(document.getElementById("total_quantities").value);
		var voucher_id=document.getElementById("voucher_id").value;
		//var issue_qty='';
		if(exist_qty >0)
		{
			var issue_qty= parseInt(document.getElementById("issue_qty").value);
			if(issue_qty > exist_qty )
			{
				alert("Issue Quantity is not greater than total quantity");
				document.getElementById("issue_qty").value=0;
			}
			else
			{
				getVoucher_code(voucher_id,issue_qty);
				var total_price=prices*issue_qty;
				document.getElementById("selling_amount").value=total_price;
				show_tax(total_price);
			}
		}
	}
	else if(category=="Package")
	{
		//alert("HI");
		var pkg_prices= Number(document.getElementById("pkg_prices").value);
		var pkg_qtys=Number(document.getElementById("pkg_qtys").value);
		var package_id=document.getElementById("package_id").value;
		//var issue_qty='';
		if(pkg_qtys >0)
		{
			var issue_qty= parseInt(document.getElementById("issue_qty").value);
			if(issue_qty > pkg_qtys )
			{
				alert("Issue Quantity is not greater than total quantity");
				document.getElementById("issue_qty").value=0;
			}
			else
			{
				var total_price=pkg_prices*issue_qty;
				document.getElementById("selling_amount").value=total_price;
				show_tax(total_price);
			}
		}
	}
}
function show_bank(branch_id,vals)
{
	//alert(branch_id);
	record_id= document.getElementById("record_id").value;
	var bank_data="action=sale_package_memb_voucher&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data);
	$.ajax({
	url: "show_bank.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		//alert(retbank);
		document.getElementById("bank_id").innerHTML=retbank;
		if(document.getElementById("bank_name").value)
		{
			//alert(document.getElementById("bank_name").value);
			var bank_ids=document.getElementById("bank_name").value;
			show_acc_no(bank_ids)
		}
	}
	});

	/*var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		installment_tax= taxes[1];
		document.getElementById("service_tax_id").innerHTML=service_tax;
		document.getElementById("service_taxes").value=service_tax;
		val= Number(document.getElementById("amount").value);
		show_tax(val);

	}
	});*/
	
	var tax_data1="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax_type.php",type:"post", data: tax_data1,cache: false,
	success: function(rettax)
	{
		///alert(rettax);
		document.getElementById("create_type1").innerHTML='';
		document.getElementById("res1").value=rettax;
	}
	});

 }
function show_bank_for_payment_mode(branch_id,vals)
{
	record_id= document.getElementById("record_id").value;
	var bank_data="action=sale_package_memb_voucher&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data);
	$.ajax({
	url: "show_bank.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		//alert(retbank);
		document.getElementById("bank_id").innerHTML=retbank;
		if(document.getElementById("bank_name").value)
		{
			//alert(document.getElementById("bank_name").value);
			var bank_ids=document.getElementById("bank_name").value;
			show_acc_no(bank_ids)
		}
	}

	});
	
	/*var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		installment_tax= taxes[1];
		document.getElementById("service_tax_id").innerHTML=service_tax;
		//document.getElementById("inst_tax_id").innerHTML=installment_tax;
		document.getElementById("service_taxes").value=service_tax;
		//document.getElementById("inst_taxes").value=installment_tax;
		//alert("service tax- "+service_tax);
		val= Number(document.getElementById("amount").value);

	}
	});*/
}
function show_tax(val)
{
	//var amount= Number(val);
	//service_tax= Number(document.getElementById("service_taxes").value);
	
	//service_tax_val= Number(val*service_tax/100)
	//document.getElementById("service_tax").value=service_tax_val;
	
	total_cost=Number(val)/*+Number(service_tax_val)*/;
	document.getElementById("selling_amount").value=total_cost;
	//calculte_amount_tax();
	
}
function calculte_amount_tax(val_tax_ids)
{
	//alert(val_tax_ids);
	tax_value ='';
	var total_tax=document.getElementsByName("total_tax[]").length;
	//alert(total_tax);
	for(i=1;i<=total_tax;i++)
	{
		tax_id='tax_value'+i;
		//alert(tax_id);
		tax_value =Number(tax_value) + Number(document.getElementById(tax_id).value);
	}
	
    cost_tot_tt=parseInt(document.getElementById("selling_amount").value);
	cal_tot_amount=cost_tot_tt * (tax_value/100);
	//alert(cal_tot_amount)
	tot_amount=parseInt(cost_tot_tt + cal_tot_amount)
	//alert(tot_amount)
	
	$('#tax_amount'+val_tax_ids).val(cal_tot_amount);

	$('#amount').val(tot_amount);
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
			//calculte_amount_tax(id);
		}
	}
}
</script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<?php include "include/services_menu.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom">&nbsp;</td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">
            
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
							$branch_name=$_POST['branch_name'];
                          	$cust_id=$_POST['cust_id'];
							$category=trim($_POST['category']);
                            $bank_name='';
							$chaque_no='';
							$credit_card_no='';
							$chaque_date='';
							$membership_id='';
							$package_id='';
							$voucher_id='';
							$categories='';
							if($category=="Membership")
							{
								$membership_id=$_POST['membership_id']; 
							}
							if($category=="Package")
							{
								$package_id=$_POST['package_id'];
							}
							if($category=="Voucher")
							{
								$voucher_id=$_POST['voucher_id'];
								$categories=$_POST['categories'];
							}
							
							$start_date=$_POST['start_date'];
							$tan_date = explode('/',$start_date);
							$start_date=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
							
							$end_date=$_POST['end_date'];
							$tan_dates = explode('/',$end_date);
							$end_date=$tan_dates[2].'-'.$tan_dates[1].'-'.$tan_dates[0];
							
							$payment_mode=$_POST['payment_mode'];
							$sep=explode("-",$payment_mode);
							$payment_mode_id=$sep[1];
							$amount=$_POST['amount'];
							$issue_quantity=$_POST['issue_qty'];
							$service_tax=$_POST['service_tax'];
							$total_cost_with_tax=$_POST['total_cost_with_tax'];
							$selling_amount=$_POST['selling_amount'];
							$total_type1=$_POST['total_type1'];
							
							if($payment_mode_id !="1" || $payment_mode_id !="3" ||$payment_mode_id !="5")
							{
								$bank_name=$_POST['bank_name'];
								$chaque_no=$_POST['chaque_no'];
								$credit_card_no=$_POST['credit_card_no'];
								$chaque_date=$_POST['cheque_date'];
								
								$cheques_date=$_POST['cheque_date'];
								$chaquess_date = explode('/',$cheques_date);
								$chaque_date=$chaquess_date[2].'-'.$chaquess_date[1].'-'.$chaquess_date[0];
							}
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
							}
							if($record_id=='' && $category=="Membership")
							{
								  $sel_cat="select cust_id,membership_id from customer where cust_id ='".$cust_id."' and membership_id='".$membership_id."' ";
								  $ptr_cat=mysql_query($sel_cat);
								  $count_cust_id=mysql_num_rows($ptr_cat);
								  if($count_cust_id)
								  {
									$success=0;
									$errors[$i++]="Mebership already Exist.";
								  }
							}
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
								$data_record['cust_id'] =$cust_id;
								$data_record['category'] =$category;
                                $data_record['membership_id'] =$membership_id;
								$data_record['package_id'] =$package_id;
								$data_record['voucher_id'] =$voucher_id;
								$data_record['start_date'] =$start_date;
								$data_record['end_date'] =$end_date;
								$data_record['amount'] =$amount;
								$data_record['total_cost'] =$selling_amount;
								$data_record['payment_mode_id'] =$payment_mode_id;
								$data_record['chaque_no'] =$chaque_no;
								$data_record['chaque_date'] =$chaque_date;
								$data_record['credit_card_no'] =$credit_card_no;
								$data_record['bank_id'] =$bank_name;
								$data_record['status'] ="active";
								$data_record['quantity'] =$issue_quantity;
								$data_record['service_tax'] =	$service_tax;
								$data_record['total_cost_with_tax'] =$total_cost_with_tax;
								$data_record['added_date'] =date("Y-m-d H:i:s");
								
                               	if($record_id)
                                {
                                    $where_record="id='".$record_id."'";
                                    $db->query_update("sales_package_voucher_memb", $data_record,$where_record);
									if($category=="Membership")
									{
										$data_record_memb['membership'] ="yes";
										$data_record_memb['membership_id'] =$membership_id;
										$data_record_memb['start_date'] =$start_date;
										$data_record_memb['end_date'] =$end_date;
										$data_record_memb['price'] =$amount;
										
										$data_record_memb['payment_mode_id'] =$payment_mode_id;
										$data_record_memb['chaque_no'] =$chaque_no;
										$data_record_memb['chaque_date'] =$chaque_date;
										$data_record_memb['credit_card_no'] =$credit_card_no;
										$data_record_memb['bank_id'] =$bank_name;
										$data_record_memb['added_date'] =date("Y-m-d H:i:s");
										
										$where_record=" cust_id='".$cust_id."'";
                                   		$db->query_update("customer", $data_record_memb,$where_record);
									}
									
									for($x=1;$x<=$total_type1;$x++)
									{
										$_POST['tax_type'.$x];
										if($_POST['del_floor_type1'.$x]=='yes')
										{
											if($_POST['type1_id'.$x]!='' && $_POST['del_floor_type1'.$x]=='yes' )
											{
												"<br />".$delete_row = " delete from voucher_tax_map where voucher_tax_map_id='".$_POST['type1_id'.$x]."' ";
												$ptr_delete = mysql_query($delete_row);
											}
										}
										if($_POST['del_floor_type1'.$x] !='yes')
										{
											$data_record_tax['sales_voucher_id'] =$record_id; 
											'<br/>'.$data_record_tax['tax_type'] =$_POST['tax_type'.$x];
											$data_record_tax['tax_value'] =$_POST['tax_value'.$x];
											$data_record_tax['tax_amount'] =$_POST['tax_amount'.$x];
											if($_POST['type1_id'.$x]=='' && $_POST['tax_type'.$x] !='')
											{
												$type1_id=$db->query_insert("voucher_tax_map", $data_record_tax);
											}
											else
											{
												$where_record="voucher_tax_map_id='".$_POST['type1_id'.$x]."'";
												$type1_id= $_POST['type1_id'.$x];
												$db->query_update("voucher_tax_map", $data_record_tax,$where_record);
											}
											unset($data_record_tax);
									   	}
										
										
									}
									
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                   	$id=$db->query_insert("sales_package_voucher_memb", $data_record);
									for($j=1;$j<=$total_type1;$j++)
									{
										if($_POST['tax_type'.$j] !='' && $_POST['tax_value'.$j] !='')
										{
											$data_record_tax['sales_voucher_id'] =$id; 
											$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
											$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
											$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
											$customer_tax_id=$db->query_insert("voucher_tax_map", $data_record_tax);
										}
									}
									if($category=="Membership")
									{
										$data_record_memb['membership'] ="yes";
										$data_record_memb['membership_id'] =$membership_id;
										$data_record_memb['start_date'] =$start_date;
										$data_record_memb['end_date'] =$end_date;
										$data_record_memb['price'] =$amount;
										$data_record_memb['payment_mode_id'] =$payment_mode_id;
										$data_record_memb['chaque_no'] =$chaque_no;
										$data_record_memb['chaque_date'] =$chaque_date;
										$data_record_memb['credit_card_no'] =$credit_card_no;
										$data_record_memb['bank_id'] =$bank_name;
										$data_record_memb['added_date'] =date("Y-m-d H:i:s");
										$where_record=" cust_id='".$cust_id."'";
                                   		$db->query_update("customer", $data_record_memb,$where_record);
									}
									if($category=="Voucher")
									{
										$voucher_qty=$_POST['issue_qty'];
										"<br/>". $update_prod_qty="update voucher set quantity_for_amount=(quantity_for_amount - ".$_POST['issue_qty'].") where voucher_id='".$voucher_id."'";
										$query_prod_qty=mysql_query($update_prod_qty);
										//echo"<br/>".$categories;
										
										for($i=1;$i<=$voucher_qty;$i++)
										{
											$insert_vouc_code="insert into voucher_customer_code_map (`sales_id`,`voucher_id`,`customer_id`,`voucher_code_id`,`status`,`redeem_price`) values('".$id."','".$voucher_id."','".$cust_id."','".$_POST['code'.$i]."','active','".$_POST['redeems_price']."')";
											$ptr_vou_code=mysql_query($insert_vouc_code);
											//$voucher_cust_id=mysql_insert_id();
											
											if($categories=="service")
											{
												$sel_vsm="select service_id,quantity from voucher_service_map where voucher_id='".$voucher_id."'";
												$ptr_vsm=mysql_query($sel_vsm);
												while($data_vsm=mysql_fetch_array($ptr_vsm))
												{
													"<br>".$insert_qty="insert into sales_customer_service_voucher_map(`id`,`customer_id`,`voucher_id`,`voucher_code_id`,`service_id`,`quantity`) values('".$id."','".$cust_id."','".$voucher_id."','".$_POST['code'.$i]."','".$data_vsm['service_id']."','".$data_vsm['quantity']."')";
													$query_prod_qty=mysql_query($insert_qty);
												}
											}
											
											$update_codes="update voucher_code_map set status='inactive' where voucher_code_id='".$_POST['code'.$i]."'";
											$ptr_update=mysql_query($update_codes);
										}
										
									}
									if($category=="Package")
									{
										"<br/>". $update_pkg_qty="update package set quantity=(quantity - ".$_POST['issue_qty'].") where package_id='".$package_id."'";
										$query_pkg_qty=mysql_query($update_pkg_qty);
										//echo"<br/>".$categories;
										/*if($categories=="service")
										{*/
											"<br/>".$sel_vsm="select service_id,quantity from package_service_map where package_id='".$package_id."'";
											$ptr_vsm=mysql_query($sel_vsm);
											while($data_vsm=mysql_fetch_array($ptr_vsm))
											{
												 "<br>".$insert_qty="insert into sales_customer_service_voucher_map(`id`,`customer_id`,`package_id`,`service_id`,`quantity`) values('".$id."','".$cust_id."','".$package_id."','".$data_vsm['service_id']."','".$data_vsm['quantity']."')";
												$query_prod_qty=mysql_query($insert_qty);
											}
										//}
									}
									
									$sel_cust="select cust_name,mobile1 from customer where cust_id ='".$cust_id."'";
									$ptr_cus_name=mysql_query($sel_cust);
									$data_cust_name=mysql_fetch_array($ptr_cus_name);
									$name=$data_cust_name['cust_name'];
									$contact=$data_cust_name['mobile1'];
									$mesg ="Hi ".$name." Thanks for purchasing our service";
									$sel_inq="select sms_text from previleges where privilege_id='127'";
									$ptr_inq=mysql_query($sel_inq);
									$txt_msg='';
									if(mysql_num_rows($ptr_query))
									{
										$dta_msg=mysql_fetch_array($ptr_inq);
										$txt_msg=$dta_msg['sms_text'];
									}
									$messagessss =$mesg.$txt_msg;
									"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where module_type_id='127'";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select mobile from sms_mail_configuration where id='".$data_sel_cnt['id']."' and status='active' ".$_SESSION['where']."";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											send_sms_function($data_cnt['mobile'],$messagessss);
										}
									}
									send_sms_function($contact,$messagessss);
									
									
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
   <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                </tr>
                
                 <?php if($_SESSION['type']=='S')
						{
					?>
					  <tr>
						<td>Select Branch</td>
						<td>

						<?php 
						if($_REQUEST['record_id'])
						{
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
						}
						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>'; 
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 

							</option>
							<?php
						}
							echo '</select>';
							echo "</td></tr></table>";
							?>
					</td>
				</tr>
				<?php }  else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                      
                       <?php }?>
                        <input type="hidden" name="res1" id="res1" />
            <tr>
            	<td>Select Category</td>
                <td>
                <select name="category" id="category" onchange="show_customer(this.value)">
                	<option value="">Select Category</option>
                	<option value="Membership"  <?php if($row_record['category']=="Membership") echo 'selected="selected"'; else if($_POST['category']=="Membership") echo 'selected="selected"';?>>Membership</option>
                	<option value="Package" <?php if($row_record['category']=="Package") echo 'selected="selected"'; else if($_POST['category']=="Package") echo 'selected="selected"';?>>Package</option>
                	<option value="Voucher" <?php if($row_record['category']=="Voucher") echo 'selected="selected"'; else if($_POST['category']=="Voucher") echo 'selected="selected"';?>>Voucher</option>
                </select>
                </td>
           </tr>
           <tr>
            	<td colspan="3"><div id="show_customer"></div></td>	
           </tr>
           <tr>
           		<td width="100%" colspan="3">
           		<div id="show_qty_div" width="100%">
           			<table width="100%"><tr><td width="20%">Quantity</td><td><input type="text" name="issue_qty" id="issue_qty" onKeyup="show_quantities(this.value)" value="<?php if($_POST['issue_qty']) echo $_POST['issue_qty']; else if($row_record['quantity']) echo $row_record['quantity']; else echo "0"; ?>" /></td></tr></table></div>
           		</td>
           </tr>
           <tr>
           <td width="100%" colspan="3">
           <div id="show_vouchers_codes">
           	<table width="100%"><tr><td width="20%">Voucher Code</td><td><div id="show_codes" width="100%">
            <?php
					if($record_id)
					{
						$sel_vou_code="select voucher_code_id from voucher_customer_code_map where voucher_id='".$row_record['voucher_id']."' and customer_id='".$row_record['cust_id']."' order by voucher_code_id asc";
						$ptr_voucher=mysql_query($sel_vou_code);
						$i=1;
						while($data_voucher=mysql_fetch_array($ptr_voucher))
						{
							$sel_codes="select voucher_code from voucher_code_map where voucher_code_id='".$data_voucher['voucher_code_id']."' order by voucher_code_id asc";
							$ptr_codes=mysql_query($sel_codes);
							$data_codes=mysql_fetch_array($ptr_codes);
							echo"<span style='font-size:16px; font-weight:400; color:#00F'>".$i.")  ".$data_codes['voucher_code']."    &nbsp;&nbsp;&nbsp; ".$data_codes['status']."<input type='hidden' name='code".$i."' id='code".$i."' value='".$data_codes['voucher_code']."'></span></br>";
						$i++;
						}
					}
					?>
            
            </div></td></tr></table>
           </div>
           </td>
         </tr>
         <tr>
           		<td>Selling Amount:</td>
                <td><input type="text" name="selling_amount" onkeyup="show_tax(this.value)"  id="selling_amount" value="<?php if($_POST['selling_amount']) echo $_POST['selling_amount']; else echo $row_record['total_cost'];?>" required/></td><!--onKeyUp="show_tax(this.value)"-->
         </tr>
         <!--<tr>      
           		<td width="20%" class="heading">Service Tax <span id="service_tax_id"><?php //if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"/>
                <td><input type="text" name="service_tax" id="service_tax" value="<?php //if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>
                
         </tr>
         <tr>
           		<td width="20%">Service_tax_with_amount:</td>
                <td><input type="text" name="total_cost_with_tax" id="total_cost_with_tax" value="<?php //if($_POST['total_cost_with_tax']) echo $_POST['total_cost_with_tax']; else echo $row_record['total_cost_with_tax'];?>" required/></td>
         </tr>-->
          <!--===========================================================NEW TABLE 2 START===================================-->   

         <tr>

            	<td width="10%">Tax<span class="orange_font">*</span></td>

            	<td colspan="2">

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

							var shows_data='<div id="type1_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="8%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="" /><select name="tax_type'+idss+'" id="tax_type'+idss+'" ><option value="">Select Tax</option>'+res1+'</select></td><td valign="top" width="8%" align="left"><input type="text" name="tax_value'+idss+'" id="tax_value'+idss+'" onKeyUp="calculte_amount_tax('+idss+')"/><input type="hidden" name="tax_amount'+idss+'" id="tax_amount'+idss+'" /></td><input type="hidden" name="total_tax[]" id="total_tax'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';

					   document.getElementById('total_type1').value=idss;

					   return shows_data;

						}

                                                    

                    </script>

                       <td align="right">
                       <input type="button" name="Add"  class="addBtn" onClick="javascript:create_type1('add_type1');" alt="Add(+)" > 

                       <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_type1('delete_type1');" alt="Delete(-)" >

    </td></tr>

                            <tr><td>  </td><td align="left"></td></tr>

                    </table> 

                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>

    <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>

    <tr>

                        <td colspan="7">

                        <table cellspacing="3" id="tbl" width="100%">

                        <tr>

                        <td valign="top" width="8%" align="left">Tax Type</td>

                        <td valign="top" width="8%"  align="left">Tax Value(in %)</td>

                        

                        </tr>

                        <tr>

                            <td colspan="7">
							 
							<?php
                            $select_exc = "select * from voucher_tax_map where sales_voucher_id='".$record_id."' order by voucher_tax_map_id asc ";
                            $ptr_fs = mysql_query($select_exc);
                            $s=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs))
                            { 
                                $slab_id= $data_exclusive['voucher_tax_map_id'];
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
                            	<input type="text" name="tax_value<?php echo $s; ?>" id="tax_value<?php echo $s; ?>" style=" width:100px" value="<?php echo $data_exclusive['tax_value'] ?>" onKeyUp="calculte_amount_tax(<?php echo $s; ?>)"/></td>
                            	<td valign="top" width="10%" align="center">
                            	<?php
								if($record_id)
					 			{
								?>
									<input type="hidden" name="total_tax[]" id="total_tax<?php echo $s; ?>" />
                            		<input type="hidden" name="type1_id<?php echo $s; ?>" id="type1_id<?php echo $s; ?>" value="<?php echo $data_exclusive['voucher_tax_map_id'] ?>" />
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
                     ?>

                        </tr> 

                        </table>

                         <input type="hidden" name="total_type1" id="total_type1"  value="0" />

                        <div id="create_type1"></div>

                    </td></tr></table>

                     <?php

					 if($record_id)

					 {

						?>

                    <input type="hidden" name="total_type1" id="total_type1" class="inputText"   value="<?php echo $total_conditions; ?>" />

                    <input type="hidden" name="type1" id="type1" class="inputText" value="<?php echo $total_conditions; ?>" />

                    <?php  } ?> 

                    

                    </td>

                    </tr>

                </table>

             </td>

         </tr>

       <!--============================================================END TABLE 2=========================================-->
           <!--<tr>
            <td width="15%" valign="top">Select Membership <span class="orange_font">*</span></td>
             <td width="50%">
             <select name="membership_id" id="membership_id"  onChange="getMembership(this.value)">  
                        <option value=""> Select Membership</option>
                        <?php
                           /* $select_category = "select membership_id,membership_name from membership order by membership_id desc";
                            $ptr_category = mysql_query($select_category);
							
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['membership_id'] == $row_record['membership_id'])
                                    echo '<option value='.$data_category['membership_id'].' selected="selected">'.$data_category['membership_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['membership_id'].'>'.$data_category['membership_name'].'</option>';
                            }*/
                            ?>
                                   
                    </select>
            </td> 
              <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top" colspan="3">
                <div id="membership_id" >
                <table style="width:100%">
					<tr>
					<td width="6%">Membership Details</td>
					<td width="23%">Discount(in %) : <span id="memb_disc"></span><input type="hidden" name="days" id="days" value="" /></td>
					</tr>
                    <tr>
					<td width="6%"></td>
					<td width="23%">Days : <span id="dayss"></span><input type="hidden" name="days" id="days" value="" /></td>
					</tr>
                </table>
                </div>
                </td>
            </tr>-->
            
            <tr>
            <td width="15%" valign="top">Start Date <span class="orange_font">*</span></td>
             <td width="70%"><input type="text"  class=" input_text datepicker" name="start_date" onChange="getdate()" id="start_date" value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else if( $row_record['start_date']){ $sep_date=explode("-",$row_record['start_date']); echo $sep_date[2]."/".$sep_date[1]."/".$sep_date[0]; }?>" /></td> 
              <td width="10%"></td>

            </tr>
            
             <tr>
                  <td width="20%" valign="top">End Date <span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class=" input_text datepicker" name="end_date" id="end_date" value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else if( $row_record['end_date']){ $sep_date=explode("-",$row_record['end_date']); echo $sep_date[2]."/".$sep_date[1]."/".$sep_date[0];} ?>" /></td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
    		<td width="20%" valign="top">Total Amount<span class="orange_font">*</span></td>
    		<td width="70%"><input type="text"  class=" input_text " name="amount" id="amount" value="<?php if($_POST['save_changes']) echo $_POST['amount']; else echo $row_record['amount'];?>" /></td> 
   			<td width="10%"></td>
  	</tr>
               <!---------------------------------------Payment mode------------------------------------->  
                        
                <tr>
                <td class="tr-header">Select Payment Mode <span class="orange_font"></span></td>
                <td width="25%"><select name="payment_mode" id="payment_mode" onChange="payment(this.value)" >
                <option value="">--Select--</option>
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
                    <td colspan="2">
                    
                    <div id="bank_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                         <table width="100%">
                         <tr>
                         <td width="21%" class="tr-header" >Bank Name</td>
                         
                         <td>
            <?php 
            /*if($_SESSION['type'] !="S")
            {
            ?>
             <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">
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
             }*/
             ?>
             <div id="bank_record">
            <?php 
            /*if($record_id !='')
            {
            ?>
             <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">
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
             }*/
             ?></div>
             <div id="bank_id"></div>
             </td>
         </tr>
         <tr>
             <td class="tr-header" width="23%">Account No</td>
             <td><input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
         </tr>
      </table>
    </div>
    <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
     <table width="100%">
     	<tr>
     		<td class="tr-header" width="23%">Enter Chaque No</td>
     		<td><input type="text" name="chaque_no" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
     	</tr>
     	<tr>
     		<td class="tr-header" width="23%">Enter Chaque Date</td>
     		<td><input type="text" name="cheque_date" id="cheque_date" class="datepicker" value="<?php if($_POST['cheque_date']) echo $_POST['cheque_date']; else echo $row_record['chaque_date']; ?>"  /></td>
     	</tr>
    </table>
    </div>
    <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
    <table width="100%">
    	<tr>
    		<td class="tr-header" width="23%">Enter Credit Card No</td>
    		<td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>
    	</tr>
    </table>
    </div>
    </td>
   </tr>
      <!---------------------------------------End Payment mode------------------------------------->
  	
  	<tr>
   			<td>&nbsp;</td>
    		<td><input type="submit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Sales";?> Vouchers/Package/membership" name="save_changes"  /></td>
    		<td></td>
  	</tr>
</table>
</form>
</td></tr>
<?php  }   ?>
</table></td>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script>
function show_data()
{
	if('<?php echo $row_record['category']; ?>'=="Membership")
	{
		getMembership('<?php echo $row_record['membership_id']; ?>')
	}else if('<?php echo $row_record['category']; ?>'=="Package")
	{
		getPackage('<?php echo $row_record['package_id']; ?>')
	}else if('<?php echo $row_record['category']; ?>'=="Voucher")
	{	
		getVoucher('<?php echo $row_record['voucher_id']; ?>')
	}
}
</script>
<?php
/*if($_SESSION['type']=="S" && $record_id=='')
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	
	</script>
    <?php
	//exit();
}*/

if($record_id)
{ ?>
	<script>
    show_customer('<?php echo $row_record['category']; ?>')
	setTimeout(show_data,1000)
    </script>	
<?php
}
if($record_id || $_SESSION['type']=="S")
{
	?>
	 <!--<script>
		vals= document.getElementById("payment_mode").value;
		payment(vals);
	</script>-->
	<?php
}
?>
<script>
branch_name =document.getElementById("branch_name").value;
//alert(branch_name);
show_bank(branch_name);
</script>
<script language="javascript">
create_floor('add');
</script>
</body>
</html>
<?php $db->close();?>