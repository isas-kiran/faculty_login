<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM sales_product where sales_product_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
		
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Sales Product</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--<script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
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
	var pageName = "sales_product";
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			$("#customer_id").chosen({allow_single_deselect:true});
			//$("#employee_id").chosen({allow_single_deselect:true});
			$("#realtxt").chosen({allow_single_deselect:true});
        });
    </script>
    
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>

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
		//alert(branch_name)
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

function show_product_qty(product_id,id)
{
	//alert(product_id);
	var prod_data="action=show_product_qty&product_id="+product_id;
	$.ajax({
		url:"ajax.php",type:"post",timeout: 50000,data:prod_data,cache:false,
		success: function(prod_data)
		{
			prod_qty=prod_data.split("-");
			
			if(prod_qty[0].trim() || prod_qty[1].trim())
			{
				prod_data=prod_qty[0].trim();
				product_price=prod_qty[1].trim();
			}
			else
			{
				prod_data=0
				product_price=0;
			}
			document.getElementById("prod_price"+id).value=product_price;
			document.getElementById("sales_product_price"+id).value=product_price;
			document.getElementById("product_total_qty"+id).value=prod_data;
			var exit_disc=document.getElementById("product_disc"+id).value = 0;

			var exit_qty=document.getElementById("product_qty"+id).value = 1;
			
			<?php

				if($record_id=='') { ?>
					var exit_main_discount=document.getElementById("discount").value=0;
					
					var exit_payable_amt=document.getElementById("payable_amount").value=0;
				<?php } ?>
		}
		});
		setTimeout(calc_product_price(id),700);
		setTimeout(showUser,1000);
		/*setTimeout(getDiscount(id),600);
		setTimeout(calculte_total_cost,800);
		setTimeout(cal_remaining_amt,900);*/
}
function calc_product_price(prod_id)
{
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.discount1.value;
	
	prod_price=document.getElementById("prod_price"+prod_id).value;
	prod_qty=document.getElementById("product_qty"+prod_id).value;
	//alert(prod_qty)
	total_prod_qty=document.getElementById("product_total_qty"+prod_id).value;
	//alert(total_prod_qty);
	
	if(Number(prod_qty) > Number(total_prod_qty) )
	{
		alert("Issue Quantity is not Greater than Total Quantity");
		document.getElementById("product_qty"+prod_id).value=1;
		prod_qty=1;
	}
	var prod_price_new=prod_price * prod_qty;
	//alert(prod_price_new)
	document.getElementById("sales_product_price"+prod_id).value=prod_price_new;
	product_discount=document.getElementById("product_disc"+prod_id).value;
	//alert(product_discount);
	if(product_discount!=0)
	{
		if(disc_type=="rupees")
		{
			total_price=parseInt(prod_price_new-product_discount);
			discount_price=parseInt(product_discount);
		}
		else
		{
			discount= parseInt((prod_price_new*product_discount)/100);
			total_price=parseInt(prod_price_new-discount);
			discount_price=parseInt(discount);
		}
		
		document.getElementById("prod_disc_price"+prod_id).value=discount_price;
		document.getElementById("sales_product_price"+prod_id).value=total_price;
		
		//totl_price=prod_price_new*(product_discount/100);
		//total_product_price=prod_price_new-totl_price;
		//alert(total_product_price);
		//document.getElementById("sales_product_price"+prod_id).value=total_product_price;
	}
	else if(product_discount==0)
	{
	  document.getElementById("sales_product_price"+prod_id).value=prod_price_new;	
	}
	showUser();
	calculte_total_cost();
	cal_remaining_amt();
}
function show_bank(branch_id,vals)
{
	//alert(branch_id);
	record_id= document.getElementById("record_id").value;
	var bank_data="action=service&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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
	url: "show_tax_type.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		document.getElementById("create_type1").innerHTML='';
		document.getElementById("res_tax").value=rettax;
		document.getElementById("type1").value=0;
		
		cal_remaining_amt()
	}
	});
}
function show_bank_for_payment_mode(branch_id,vals)
{
	//alert(branch_id);
	record_id= document.getElementById("record_id").value;
	var bank_data="action=service&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data)
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
<script>
function showUser()
{
	contact='';
	var total_sales_product= document.getElementsByName("total_sales_product[]");
	totals=total_sales_product.length;
	//alert(totals);
	contact=''
	for(i=1; i<=totals;i++)
	{
		//alert(i);
		prod_totalssss=Number(document.getElementById("sales_product_price"+i).value);
		//alert("service   "+prod_totalssss);
		if(prod_totalssss!='')
		{
			contact =Number(contact)+Number(prod_totalssss);
			//alert(contact);
		}
	}
	//alert(contact);
	document.getElementById('product_price').value=contact;
	
	var total_prods_price=contact;
	if(document.getElementById('discount').value)
	{	
		var discount= parseInt(document.getElementById('discount').value);
	}
	else
	{
		var discount=0; 
	}
	
	frm = document.jqueryForm;  
	discount_type =frm.discount_type.value;
	
	if(discount !=0)
	{
		if(discount_type=="percentage")
		{
			var discount_price= total_prods_price * (discount/100);
		}
		else
		{
			var discount_price= discount;
		}
	}
	else
	{
		var discount_price= 0;
	}
	if(discount_price !=0)
	{
		var total_discount_price= parseInt(total_prods_price - discount_price);
		document.getElementById('discount_price').value=discount_price;
	}
	else
	{
		var total_discount_price=total_prods_price;
		document.getElementById('discount_price').value=discount_price;
	}
	
	document.getElementById('total_price').value=total_discount_price;
	document.getElementById('amount1').value=total_discount_price;
	//calculte_amount_tax();
	
	/*document.getElementById('total_price').value=contact;
	document.getElementById('amount1').value=contact;*/
	document.getElementById('remaining_amount').value=total_discount_price;
	calculte_amount_tax();
}
function getDiscount(idss)
{
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.discount1.value;
	//alert(idss);
	product_price=parseFloat(document.getElementById("prod_price"+idss).value);
	disc=parseFloat(document.getElementById("product_disc"+idss).value);
	//alert(disc)
	
	sin_product_qty=parseFloat(document.getElementById("product_qty"+idss).value);
	//alert(sin_product_qty)
	if(sin_product_qty!='0')
	{
		 total_price_qty=parseFloat(product_price * sin_product_qty);
		// alert('hi')
	}
	else if(sin_product_qty=='0')
	{
		//alert('hi')
		total_price_qty=product_price;
		//alert(total_price_qty)
	}
	//total_price_qty=product_price * sin_product_qty_new;
	//alert(total_price_qty)
	
	if(disc_type=="rupees")
	{
		total_price=parseFloat(total_price_qty-disc);
		discount_price=parseFloat(disc);
	}
	else
	{
		discount= parseFloat((total_price_qty*disc)/100);
		total_price=parseFloat(total_price_qty-discount);
		discount_price=parseFloat(discount);
	}
	
	document.getElementById("prod_disc_price"+idss).value=discount_price;
	//discount= (total_price_qty*disc)/100;
	//total_price=total_price_qty-discount;
	if(document.getElementById("sales_product_price"+idss))
	{
	  document.getElementById("sales_product_price"+idss).value=total_price;
	}
	showUser();
	calculte_total_cost();
	
}
function calculte_total_cost()
{
	var total_prods_price=document.getElementById("product_price").value;
	
	if(document.getElementById('discount').value)
	{	
		var discount= parseInt(document.getElementById('discount').value);
	}
	else
	{
		var discount=0;
	}
	
	frm = document.jqueryForm;  
	discount_type =frm.discount_type.value;
	
	if(discount !=0)
	{
		if(discount_type=="percentage")
		{
			var discount_price= total_prods_price * (discount/100);
		}
		else
		{
			var discount_price= discount;
		}
	}
	else
	{
		var discount_price= 0;
	}
	
	if(discount_price !=0)
	{
		var total_cost_new= parseInt(total_prods_price - discount_price);
		document.getElementById('discount_price').value=discount_price;
	}
	else
	{
		var total_cost_new=total_prods_price;
		document.getElementById('discount_price').value=discount_price;
	}
			
	 
	 //var discount=document.getElementById("discount").value;
	 //alert(discount)
	 //var total=isNaN(parseInt(product_price * (discount / 100))) ? 0 :parseInt((product_price * (discount / 100)))
	 //alert(total_cost)
	// var total_cost_new=isNaN(parseInt(product_price - total)) ? 0 :parseInt(product_price - total)
	 //alert(total_cost_new)
	 $('#total_price').val(total_cost_new);
	 $('#remaining_amount').val(total_cost_new);
	calculte_amount_tax();
}
function get_tax_value(val_tax_ids, tax_type)
{
	//alert(tax_type+"-"+val_tax_ids);
	var branch_name=document.getElementById('branch_name').value;
	//alert(branch_name)			
	var data1="tax_type="+tax_type+"&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "get_tax_value.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert("value"+html);
		tax_valuess=html.trim();
		document.getElementById("tax_value"+val_tax_ids).value=tax_valuess;
	}
	});
	
	setTimeout(calculte_amount_tax,800,val_tax_ids);
}
function calculte_amount_tax(val_tax_ids)
{
	tax_value ='';
	var total_tax=document.getElementsByName("total_tax[]").length;
	//alert(val_tax_ids);
	for(i=1;i<=total_tax;i++)
	{
		tax_id='tax_value'+i;
		if(document.getElementById(tax_id))
		{
			tax_value =Number(tax_value) + Number(document.getElementById(tax_id).value);
		}
	}
	//alert(tax_value);
	//tax_value +=document.getElementById('tax_value'+val_tax_ids).value;
    cost_tot_tt=Math.round(document.getElementById("total_price").value);
	cal_tot_amount=cost_tot_tt * (tax_value/100);
	//alert(cal_tot_amount)
	tot_amount=Math.round(cost_tot_tt + cal_tot_amount)
	//alert(tot_amount)
	//document.getElementById('tax_amount').innerHTML=tot_amount;
	$('#tax_amount'+val_tax_ids).val(cal_tot_amount);

	$('#amount1').val(tot_amount);
	
	cal_remaining_amt();
}
</script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='138'";
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
			mail[<?php echo $j; ?>]='<?php echo  $data_cnt['email'];?>';
			<?php
			$j++;
		}
	}
}
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='138'";
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
{		//alert('hi');						  
	var branch_name =document.getElementById('branch_name').value;
	var ref_invoice_no =document.getElementById('ref_invoice_no').value;
	var realtxt =document.getElementById('realtxt').value;
	var mail =document.getElementById('mail').value;
	var customer_id =document.getElementById('customer_id').value;
	var total_service =document.getElementById('no_of_floor').value;
	concat_string='';
	for(i=1; i<=total_service; i++)
	{
		//product_id = document.getElementById('product_id'+i).value;
		product = document.getElementById('product_id'+i);
		product_id = product.options[product.selectedIndex].text;
		prod_price =document.getElementById('prod_price'+i).value;
		product_qty =document.getElementById('product_qty'+i).value;
		
		product_disc =document.getElementById('product_disc'+i).value;
		sales_product_price =document.getElementById('sales_product_price'+i).value;
		concat_string +='&product_id'+i+'='+product_id+'&prod_price'+i+'='+prod_price+'&product_qty'+i+'='+product_qty+'&product_disc'+i+'='+product_disc+'&sales_product_price'+i+'='+sales_product_price;
	}
	var product_price =document.getElementById('product_price').value;
	var discount =document.getElementById('discount').value;
	var discount_price =document.getElementById('discount_price').value;
	var total_price =document.getElementById('total_price').value;
	var type1 =document.getElementById('type1').value;
	concat_string_tax='';
	for(j=1; j<=type1; j++)
	{
		//product_id = document.getElementById('product_id'+i).value;
		tax =document.getElementById('tax_type'+j);
		tax_type = tax.options[tax.selectedIndex].text;
		tax_value =document.getElementById('tax_value'+j).value;
		concat_string_tax +='&tax_type'+j+'='+tax_type+'&tax_value'+j+'='+tax_value;
	}
	
	var payment_mode =document.getElementById('payment_mode').value;
	bank =document.getElementById('bank_name');

	var  bank_details=bank.options[bank.selectedIndex].text;
             if(bank_details=="--Select--")
	{
		var bank_details="";
		
	}
	var account_no =document.getElementById('account_no').value;
	var chaque_details =document.getElementById('chaque_no').value;
	var cheque_date =document.getElementById('cheque_date').value;
	var credit_details =document.getElementById('credit_details').value;
           if(credit_details=="undefined")
            {
             credit_details="";
             }
	var credit_card_no =document.getElementById('credit_card_no').value;
	
	var amount1 =document.getElementById('amount1').value;
	var payable_amount =document.getElementById('payable_amount').value;
	var remaining_amount =document.getElementById('remaining_amount').value;
	var users_mail=mail1;
	data1='action=sales_product&branch_name='+branch_name+'&ref_invoice_no='+ref_invoice_no+'&realtxt='+realtxt+'&customer_id='+customer_id+'&product_price='+product_price+'&discount='+discount+'&discount_price='+discount_price+'&total_price='+total_price+'&payment_mode='+payment_mode+'&bank_details='+bank_details+'&account_no='+account_no+'&chaque_details='+chaque_details+'&cheque_date='+cheque_date+'&credit_details='+credit_details+'&credit_card_no='+credit_card_no+'&amount1='+amount1+'&payable_amount='+payable_amount+'&remaining_amount='+remaining_amount+concat_string+concat_string_tax+'&total_service='+total_service+'&type1='+type1+"&users_mail="+users_mail+"&mail="+mail+"&email_text_msg="+email_text_msg;
	//alert(data1);
	$.ajax({
		url:'http://www.htdpt.in/tracking/send_email.php',type:"post",data:data1,cache:false,crossDomain:true, async:false,
		success: function(response) {
		//alert(response);
		return true;
		}
	});
}
</script>

<script>

function show_mobile_no(cust_ids)
{
	var data2="customer_id="+cust_ids;
	//alert(data2);
	 $.ajax({
	url: "get_mail.php", type: "post", data: data2, cache: false,
	success: function (html)
	{
			//alert(html);
			//var mail= sep_val[0].trim();
			document.getElementById('mail').value=html;
			 //$("#cus").html(data);
			
	}
	});
	//alert(cust_ids);
	if(cust_ids == 'custome')
	{
		$( ".new_custom_course" ).dialog({
			width: '500',
			height:'300'
		});
	}
	else if(cust_ids == 'ahmedabad_sale')
	{
		var data2="action_for=ahmedabad&customer_id="+cust_ids;
		//alert(data2);
		 $.ajax({
		url: "get_stockist.php", type: "post", data: data2, cache: false,
		success: function (html)
		{
				//alert(html);
				//var mail= sep_val[0].trim();
				document.getElementById('stockiest').innerHTML=html;
				 //$("#cus").html(data);
				 $("#stockist_id").chosen({allow_single_deselect:true});
		}
		});
	}
}
function cal_remaining_amt()
{
	var final_amt=Number(document.getElementById('amount1').value);
	//alert(final_amt);
	
	var payable_amt=Number(document.getElementById('payable_amount').value);
	//alert(payable_amt);
	
	if(payable_amt > final_amt)
	{
	  alert("Payable Amount should not be greater than Final amount..");
	  document.getElementById("payable_amount").value=0;	
	  $('#remaining_amount').val(final_amt);
	  return false;
	}
	
	if(payable_amt!=0)
	{
		cal_tot_rem_amt=final_amt - payable_amt;
		
	}
	else
	{
	  cal_tot_rem_amt=final_amt;
	  
	}
	//alert(cal_tot_rem_amt);
	
	$('#remaining_amount').val(cal_tot_rem_amt);
}

function validme()
	 {
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		 
		 
		
		 if(frm.customer_id.value=='')
		 {
			 disp_error +='Select Customer\n';
			 document.getElementById('customer_id').style.border = '1px solid #f00';
			 frm.customer_id.focus();
			 error='yes';
	     }
		 
		 /*var fields = $("input[name='requirment_id[]']").serializeArray(); 
		 if (fields.length == 0) 
		  { 
		    disp_error +='Select Product\n';
			 
			error='yes';
		  }*/ 
		 
		 
		 if(frm.discount.value=='')

		 {

			 disp_error +='Enter Discount\n';

			 document.getElementById('discount').style.border = '1px solid #f00';

			 frm.discount.focus();

			 error='yes';

	     }

			 
			 if(frm.payment_mode.value=='')
			 {
				 disp_error +='Please select Payment Mode \n';
				 document.getElementById('payment_mode').style.border = '1px solid #f00';
				 frm.payment_mode.focus();
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
		
	 }
function searchSel(value) 
{
	var data1="action=sale_product&mobile_no="+value;	
	$.ajax({
	url: "get_name.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html.trim()!='')
		{
			sep=html.split("###");
			/*$( "#customer_id_chosen").toggleClass("chosen-with-drop chosen-container-active");
			$( "#customer_id").find("[data-option-array-index="+html+"]").toggleClass("result-selected");*/
			document.getElementById("sel_cust").innerHTML=sep[1];
			$("#customer_id").chosen({allow_single_deselect:true});
			/*$("#customer_id option").removeAttr("selected");
			$("#customer_id option[value="+html+"]").attr("selected", "selected");
			*/
			//setTimeout(getMembership(sep[0].trim()),500);
			document.getElementById("mail").value=sep[2];
		}
	}
	});
} 
</script> 
</head>
<body>
<?php include "include/header.php";?>
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
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
							//$branch_name=$_POST['branch_name'];
							$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
                            //$customer_id=$_POST['customer_id'];
							$customer_id=( ($_POST['customer_id'])) ? $_POST['customer_id'] : "0";
							//$product_price=$_POST['product_price']; 
							$product_price=( ($_POST['product_price'])) ? $_POST['product_price'] : "0";
							//$discount=$_POST['discount'];   
							$discount=( ($_POST['discount'])) ? $_POST['discount'] : "";
							//$total_price=$_POST['amount1'];
							$total_price=( ($_POST['amount1'])) ? $_POST['amount1'] : "0";
							//$tot_price_withou_tax=$_POST['total_price'];
							$tot_price_withou_tax=( ($_POST['total_price'])) ? $_POST['total_price'] : "0";
							//$payable_amount=$_POST['payable_amount'];
							$payable_amount=( ($_POST['payable_amount'])) ? $_POST['payable_amount'] : "0";
							$remaining_amount=( ($_POST['remaining_amount'])) ? $_POST['remaining_amount'] : "0";
							$bank_name='0';
							$chaque_no='';
							$date='';
							$credit_card_no='';
							$payment_mode_id='0';
							$payment_type_val='0';
							if($_POST['payment_mode'] !='')
							{
								$payment_mode=$_POST['payment_mode'];
								$sep=explode("-",$payment_mode);
								$payment_mode_id=$sep[1];
								$payment_type_val=$sep[0];
							}
							//$ref_invoice_no=$_POST['ref_invoice_no'];
							$ref_invoice_no=( ($_POST['ref_invoice_no'])) ? $_POST['ref_invoice_no'] : "0";
							//$amount=$_POST['amount'];
							$amount=( ($_POST['amount'])) ? $_POST['amount'] : "0";
							if($payment_mode_id !="1" || $payment_mode_id !="3" ||$payment_mode_id !="5")
							{
								
								$bank_name=( ($_POST['bank_name'])) ? $_POST['bank_name'] : "0";
								$chaque_no=( ($_POST['chaque_no'])) ? $_POST['chaque_no'] : "";
								$credit_card_no=( ($_POST['credit_card_no'])) ? $_POST['credit_card_no'] : "";
								
								if($_POST['cheque_date'] !='')
								{
									$cheques_date=( ($_POST['cheque_date'])) ? $_POST['cheque_date'] : "";
									$chaquess_date = explode('/',$cheques_date);
									$chaque_date=$chaquess_date[2].'-'.$chaquess_date[1].'-'.$chaquess_date[0];
								}
								else
									$chaque_date='';
							}
							
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								
								$data_record['cm_id']=$cm_id;
								
								$cm_id1=$cm_id;
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
								$cm_id1=$_SESSION['cm_id'];
							}
							$data_record['admin_id']=$_SESSION['admin_id'];
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
                                $data_record['customer_id'] =$customer_id;
                               
								$data_record['product_price'] =$product_price;
								$data_record['discount'] =$discount;
								$data_record['total_price']=$total_price;
								$data_record['tot_price_withou_tax']=$tot_price_withou_tax;
								$data_record['payable_amount']=$_POST['payable_amount'];
								$data_record['remaining_amount']=$remaining_amount;
								$data_record['added_date']=date('Y-m-d H:i:s');
								
								$data_record['payment_mode_id'] =$payment_mode_id;
								$data_record['chaque_no'] =$chaque_no;
								$data_record['chaque_date'] =$chaque_date;
								$data_record['credit_card_no'] =$credit_card_no;
								$data_record['bank_id'] =$bank_name;
								$total_floor=$_POST['floor'];
								$total_type1=$_POST['total_type1'];
								$data_record['ref_invoice_no']=$ref_invoice_no;
                               if($record_id)
                                {
									//echo 'hi';
									/*"<br />".$del_sales_product="delete from sales_product_map where sales_product_id='".$record_id."'";
                                      $ptr_del_section=mysql_query($del_sales_product);
									
                                    $where_record=" sales_product_id='".$record_id."'";
                                    $db->query_update("sales_product", $data_record,$where_record);
									
									for($i=0;$i<count($product);$i++)
									{
										 $quantity=$_POST['quantity'][$i];
										  'total_qty=> '.$quantity_total=$_POST['quantity_total'][$i];
										   
										 $ins_product="insert into sales_product_map (`sales_product_id`,`product_id`,`quantity`) values ('".$record_id."','".$_POST['requirment_id'][$i]."', '".$quantity."')";
										$ptr_product=mysql_query($ins_product);
										
										 '<br/>'.$select_quantity="select SUM(quantity) from sales_product_map where sales_product_id='".$record_id."'  and                                           product_id='".$_POST['requirment_id'][$i]."'";
										   $query_quantity=mysql_query($select_quantity);
										   if(mysql_num_rows($query_quantity))
										   {
											 $fetch_partial_quantity=mysql_fetch_array($query_quantity);
												  
											  'sum_qty=> '.$partial_complete_qty=$fetch_partial_quantity['SUM(quantity)'];
											
											   'rem=><br/>'.$total_remaining_qty= $quantity_total - $partial_complete_qty; 
										   }
										  
										
										 '<br/>'.$update_product="update product set quantity='".$total_remaining_qty."' where product_id='".$_POST['requirment_id'][$i]."' ";
										  $query_update=mysql_query($update_product);
										
									}
									
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';*/
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('sales_product','Edit','sale product','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
                                }
								
                                else
                                {
                                    $record_id=$db->query_insert("sales_product", $data_record);
									for($i=1;$i<=$total_floor;$i++)
									{

										$data_record_service['sales_product_id'] =$record_id; 
										//$data_record_service['product_id'] =$_POST['product_id'.$i];
										$data_record_service['product_id']=( ($_POST['product_id'.$i])) ? $_POST['product_id'.$i] : "0";
										//$data_record_service['prod_price'] =$_POST['prod_price'.$i];
										$data_record_service['prod_price']=( ($_POST['prod_price'.$i])) ? $_POST['prod_price'.$i] : "0";
										//$data_record_service['product_qty'] =$_POST['product_qty'.$i];
										$data_record_service['product_qty']=( ($_POST['product_qty'.$i])) ? $_POST['product_qty'.$i] : "0";
										//$data_record_service['product_disc'] =$_POST['product_disc'.$i];
										$data_record_service['product_disc']=( ($_POST['product_disc'.$i])) ? $_POST['product_disc'.$i] : "0";
										//$data_record_service['sales_product_price'] =$_POST['sales_product_price'.$i];
										$data_record_service['sales_product_price']=( ($_POST['sales_product_price'.$i])) ? $_POST['sales_product_price'.$i] : "0";
										$customer_service_id=$db->query_insert("sales_product_map", $data_record_service);
										$quantity_total=$_POST['product_total_qty'.$i];
										$select_quantity="select SUM(product_qty) from sales_product_map where sales_product_id='".$record_id."' and product_id='".$_POST['product_id'.$i]."'";
										$query_quantity=mysql_query($select_quantity);
										if(mysql_num_rows($query_quantity))
										{
											$fetch_partial_quantity=mysql_fetch_array($query_quantity);
											$partial_complete_qty=$fetch_partial_quantity['SUM(product_qty)'];
											$total_remaining_qty= $quantity_total - $partial_complete_qty; 
										}
										$update_product="update product set quantity='".$total_remaining_qty."' where product_id='".$_POST['product_id'.$i]."' ";
										$query_update=mysql_query($update_product);
									}
									
									for($j=1;$j<=$total_type1;$j++)
									{
										$data_record_tax['sales_product_id'] =$record_id; 
										$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
										$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
										
										$customer_tax_id=$db->query_insert("sales_product_tax_map", $data_record_tax);
									}
									
									if($payment_type_val=="online")
									$status='pending';
									else
									$status='paid';
									
									//$chaque_date_exp=explode('/', $chaque_date);
									//$chaque_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
									
									 $insert_sales_invoice = " INSERT INTO `sales_product_invoice` (`sales_product_id`, `total_price`, `payable_amount`,`remaining_amount`, `paid_type`, `bank_id`, `cheque_detail`, `chaque_date`, `credit_card_no`, `admin_id`, `added_date`,`status`,`cm_id`,`total_paid`) VALUES ('".$record_id."', '".$total_price."', '".$payable_amount."','".$remaining_amount."', '".$payment_mode_id."','".$bank_name."', '".$chaque_no."', '".$chaque_date."','".$credit_card_no."', '".$_SESSION['admin_id']."', '".date('Y-m-d H:i:s')."','".$status."','".$cm_id1."','".$payable_amount."'); ";
									$ptr_sales_invoice = mysql_query($insert_sales_invoice);	
									
									/*for($i=0;$i<count($product);$i++)
									{
										 $quantity=$_POST['quantity'][$i];
										  'total_qty=> '.$quantity_total=$_POST['quantity_total'][$i];
										   
										 $ins_product="insert into sales_product_map (`sales_product_id`,`product_id`,`quantity`) values ('".$record_id."','".$_POST['requirment_id'][$i]."', '".$quantity."')";
										$ptr_product=mysql_query($ins_product);
										
										 '<br/>'.$select_quantity="select SUM(quantity) from sales_product_map where sales_product_id='".$record_id."'  and                                           product_id='".$_POST['requirment_id'][$i]."'";
										   $query_quantity=mysql_query($select_quantity);
										   if(mysql_num_rows($query_quantity))
										   {
											 $fetch_partial_quantity=mysql_fetch_array($query_quantity);
												  
											  'sum_qty=> '.$partial_complete_qty=$fetch_partial_quantity['SUM(quantity)'];
											
											   'rem=><br/>'.$total_remaining_qty= $quantity_total - $partial_complete_qty; 
										   }
										  
										
										 '<br/>'.$update_product="update product set quantity='".$total_remaining_qty."' where product_id='".$_POST['requirment_id'][$i]."' ";
										$query_update=mysql_query($update_product);
										
									}*/
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('sales_product','Add','sale product','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									
									$sel_cust="select cust_name,mobile1 from customer where cust_id ='".$customer_id."'";
									$ptr_cus_name=mysql_query($sel_cust);
									$data_cust_name=mysql_fetch_array($ptr_cus_name);
									$name=$data_cust_name['cust_name'];
									$contact=$data_cust_name['mobile1'];
									$mesg ="Hi ".$name." Thanks for purchasing our service";
									$sel_inq="select sms_text from previleges where privilege_id='138'";
									$ptr_inq=mysql_query($sel_inq);
									$txt_msg='';
									if(mysql_num_rows($ptr_query))
									{
										$dta_msg=mysql_fetch_array($ptr_inq);
										$txt_msg=$dta_msg['sms_text'];
									}
									$messagessss =$mesg.$txt_msg;
									"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='138'";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											send_sms_function($data_cnt['contact_phone'],$messagessss);
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
												send_sms_function($data_cnt['contact_phone'],$messagessss);
											}
										}
									}
									send_sms_function($contact,$messagessss);
									
									?>
                                     <script>
                                	window.open('invoice_sales_product.php?record_id=<?php echo $record_id; ?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900, height=600,directories=no,location=no');

								</script>
                                    <?php
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data" name="jqueryForm" onSubmit="return validme()">
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
						 $sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A'";
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
                <tr>
                  <td width="15%" valign="top">Referal invoice No.<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="input_text" name="ref_invoice_no" id="ref_invoice_no" value="<?php if($_POST['save_changes']) echo $_POST['ref_invoice_no']; else if($row_record['ref_invoice_no'] !='') echo $row_record['ref_invoice_no']; ?>" /></td> 
                  <td width="10%"></td>
          		</tr>
            <tr>
            	<input type="hidden" name="res1" id="res1" />
            	<input type="hidden" name="res_tax" id="res_tax" />
            	<td>Search by Mobile no.</td>
            	 <td>
                <select id="realtxt" name="realtxt" onChange="searchSel(this.value)">
                <option value="">Select Mobile No.</option>
                <?php  
                    $sql_cust = "select mobile1,cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
                    $ptr_cust = mysql_query($sql_cust);
                    while($data_cust = mysql_fetch_array($ptr_cust))
                    { 
                            $selecteds = '';
                            if($data_cust['cust_id']==$row_record['customer_id'])
                            $selecteds = 'selected="selected"';	
                        echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
    
                    }
                    ?>
                </select>
                </td>
            </tr> 
            <tr>
            	<td width="20%" valign="top">Select Customer<span class="orange_font">*</span></td>
            	<td width="70%" id="sel_cust" class="customized_select_box">
            	<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value)" >
                <option value="">Select Customer</option> 
                <?php  
                $sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
                $ptr_cust = mysql_query($sql_cust);
                while($data_cust = mysql_fetch_array($ptr_cust))
                { 
                	$selecteds = '';
                	if($data_cust['cust_id']==$row_record['customer_id'])
                	$selecteds = 'selected="selected"';	
               		echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
                }
				?>
				<option value="ahmedabad_sale" style="font-weight:800">Ahmedabad Sale</option>
                <option value="custome" style="font-style:oblique; font-weight:800">New Customer</option>
                </select>
                <td width="10%"><input type="hidden" name="mail" id="mail" value=""  /></td>
            </tr>
			<tr>
				<td colspan="3">
				<div id='stockiest'></div>
				</td>
			</tr>
			
            <tr>
            	<td width="10%">Select Product<span class="orange_font">*</span></td>
            	<td colspan="2">
                	<table  width="100%" style="border:1px solid gray; ">
                    	<tr>
                    	<td colspan="2">
                        
                    	<!--===========================================================NEW TABLE START===================================-->
                    <table cellpadding="5" width="100%" >
                    <tr>
                    
                    <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                     
                     <script language="javascript">
                                
                                function floors(idss)
                                {
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td width="40%" align="left"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:250px" onchange="show_product_qty(this.value,'+idss+')"><option value="">Select Product</option>				<?php
									$sel_tel = "select product_id,product_name,price,quantity,admin_id from product where 1 ".$_SESSION['where']." ".$_SESSION['user_id']." and quantity > 0  order by product_id asc";	 
									$query_tel = mysql_query($sel_tel);
									while($data=mysql_fetch_array($query_tel))
									{
										$name='';
										if($_SESSION['type'] =='S')
										{
											$sel_emp="select name from site_setting where admin_id='".$data['admin_id']."'";
											$ptr_admin_id=mysql_query($sel_emp);
											$data_name=mysql_fetch_array($ptr_admin_id);
											$name= "(".$data_name['name'].")";
										}
										
										echo '<option value="'.$data['product_id'].'">'.addslashes($data['product_name']).'&nbsp;&nbsp;(Price - '.addslashes($data['price']).')&nbsp;&nbsp;'.$name.'</option>';
									}
									 ?>
									 </select></td><td width="3%" align="center"><input type="text" name="prod_price'+idss+'" id="prod_price'+idss+'" onkeyup="calc_product_price('+idss+')" /></td><td width="2%" align="center"><input type="text" name="product_total_qty'+idss+'" id="product_total_qty'+idss+'" readonly="readonly" /></td><td width="4%" align="center"><input type="text" name="product_qty'+idss+'" id="product_qty'+idss+'" onBlur="calc_product_price('+idss+')" /></td><td width="4%" align="center"><input type="text" name="product_disc'+idss+'" id="product_disc'+idss+'" onkeyup="calc_product_price('+idss+')" /><input type="hidden" name="prod_disc_price'+idss+'" id="prod_disc_price'+idss+'" /></td><td width="4%" align="center"><input type="text" name="sales_product_price'+idss+'" id="sales_product_price'+idss+'" onkeyup="calc_product_price('+idss+')" /><input type="hidden" name="total_sales_product[]" id="total_sales_product'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></td><tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                                
                        </script>
                       <td align="right"><input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
    <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
    </td></tr>
                            <tr><td>  </td><td align="left"></td></tr>
                    </table> 
                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
    <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
    <tr>
                        <td colspan="6">
                        <table cellspacing="3" id="tbl" width="100%">
                        <tr>
                        <td valign="top" align="center" width="21%" >Product Name</td>
                         <td valign="top" align="center" width="12%" >Product Price</td>
                        <td valign="top" width="13%" align="center">Total Qty</td>
                        <td valign="top" width="13%" align="center" >Qty</td>
                        <td valign="top" width="13%" align="center" >Discount<br/>
                        <input type="radio" name="discount1" id="discount1" checked="checked" value="percentage" />in %
                        <input type="radio" name="discount1" id="discount1" value="rupees" />in Rs -/</td>
                        <td valign="top" width="14%" align="center">Price</td>
                         </tr></table>
                         <input type="hidden" name="floor" id="floor"  value="0" />
                        <div id="create_floor"></div>
                    </td></tr></table>
                    <!--============================================================END TABLE=========================================-->
                    </td>
                    </tr>
                </table>
             </td>
             
           <!-- <td width="90%" >
           <?php /*?> <?php
            $sel_tel = "select product_id,product_name,price,quantity from product order by product_id asc";	 
			$query_tel = mysql_query($sel_tel);
			$i=1;
			$total_no = mysql_num_rows($query_tel);
			$member_result='';
			echo '<table width="100%">';
			
			echo  '<tr>';
			///-======= Existing course code===
			
			if($record_id)
			{ 
				$select_existing = " select product_id, sales_product_id, quantity from sales_product_map where sales_product_id='".$record_id."' ";
				$ptr_esxit = mysql_query($select_existing);
				$subject_array = array();
				$topic_array = array();
				$j=0;
				while( $data_exist = mysql_fetch_array($ptr_esxit))
				{
					$customer_array[$j]=$data_exist['sales_product_id'];
					$service_array[$j]=$data_exist['product_id'];
					$j++;
				}
			}
			while($row_member = mysql_fetch_array($query_tel))
			   {
				   $checked= '';
				if($record_id)
				{
					if(in_array($row_member['product_id'], $service_array))
					{
						$checked=" checked='checked'";
					}
				}
				   //$checked= '';
				  $select_product_chk= "select product_id, sales_product_id, quantity from sales_product_map where sales_product_id='".$row_record['sales_product_id']."' and product_id='".$row_member['product_id']."' ";
				   $ptr_product_chk=mysql_query($select_product_chk);
				   $fetch_product_ck=mysql_fetch_array($ptr_product_chk);
				   if(mysql_num_rows($ptr_product_chk))
				   {
					   //$checked= 'checked="checked"';
					   
					   $valu_quantity=$fetch_product_ck['quantity'];
				   }
				   else
				   {
					  $valu_quantity=$row_member['quantity']; 
				   }
				   
			   echo  '<td style="border:1px solid #999;">'; 
			  
			  
			   
			   echo  "<input type='checkbox' '".$checked."' name='requirment_id[]'  value='".$row_member['product_id']."' id='requirment_id$i'  onClick='showprice()' class='case' $checked /> ".$row_member['product_name']."( Price - ".$row_member['price']."/- )(Qty - ".$row_member['quantity'].")"." ";
			   
			   echo '<input type="hidden" name="price_hidden" value="'.$row_member['price'].'" id="price_hidden'.$i.'" />';
			   
			     echo '<input type="hidden" name="quantity_total[]" value="'.$row_member['quantity'].'" id="quantity_total'.$i.'" />';
			   
			   echo' &emsp; Qty: <input type="text" name="quantity[]" value="" id="quantity'.$i.'" style="width:30px" onkeyup="showprice()"/>';
			   
			  
			  
			   /*if($record_id!='' && (mysql_num_rows($ptr_product_chk)))
			   {
				   $tot=$row_member['price'] * $valu_quantity;
				   
				   echo '<div id="tot_pr_'.$i.'">';
				   echo' &emsp; Total: <input type="text" name="total_price" value="'.$tot.'" id="total_price'.$i.'" readonly="readonly" style="width:60px" />';
				   echo '</div>';
			   }
			  
			  
			  
			   
			   echo' &emsp; Total: <input type="text" name="total_price" value="" id="total_price'.$i.'" readonly="readonly" style="width:50px" />';
			 
			   
			 
			  
			   echo  '</td>';
			   if($i%2==0)
			   echo  '<tr></tr>';  
			   $i++;
				}
				echo' <input type="hidden" name="total_product" value="'.($i-1).'" id="total_product" />';
				echo '</table>';
            
            ?><?php */?>
                                       
                    </td> -->
           <!--</tr> -->
            <tr>
                <td width="20%" valign="top">Product Price</td>
                <td width="70%"><input type="text" class="input_text" name="product_price" id="product_price" onKeyUp="calculte_total_cost()" value="<?php if($_POST['product_price']) echo $_POST['product_price']; else echo $row_record['product_price'];?>" /></td> 
                <td width="10%"></td>
            </tr>
             
            <tr>
                <td width="20%" valign="top">Discount <input type="radio" name="discount_type" onChange="calculte_total_cost()" id="discount_type" checked="checked" value="percentage" <?php if($_POST['discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %
                <input type="radio" name="discount_type" id="discount_type" onChange="calculte_total_cost()" value="rupees" <?php if($_POST['discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/ <span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="input_text" name="discount" id="discount" onKeyUp="calculte_total_cost()" value="<?php if($_POST['discount']) echo $_POST['discount']; else echo $row_record['discount'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
            	<td width="20%" valign="top">Discount Price</td>
            	<td width="72%"><input type="text" class=" input_text" name="discount_price" id="discount_price" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_record['discount_price'];?>" /></td> 
            	<td width="5%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Total Price</td>
                <td width="70%"><input type="text"  class="input_text" name="total_price" id="total_price" value="<?php if($_POST['total_price']) echo $_POST['total_price']; else echo $row_record['total_price'];?>" /></td> 
                <td width="10%"></td>
            </tr>
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
                                res_tax= document.getElementById("res_tax").value;
                                //alert(idss);
    
                                var shows_data='<div id="type1_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="8%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="" /><select name="tax_type'+idss+'" id="tax_type'+idss+'" onChange="get_tax_value('+idss+',this.value)"><option value="">Select Tax</option>'+res_tax+'</select></td><td valign="top" width="8%" align="left"><input type="text" name="tax_value'+idss+'" id="tax_value'+idss+'" onKeyUp="calculte_amount_tax('+idss+')"/><input type="hidden" name="tax_amount'+idss+'" id="tax_amount'+idss+'" /></td><input type="hidden" name="total_tax[]" id="total_tax'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
    
                           document.getElementById('total_type1').value=idss;
    
                           return shows_data;
    
                            }
    
                                                        
    
                        </script>
    
                           <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_type1('add_type1');" alt="Add(+)" > 
    
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
                                $select_exc = "select * from inventory_tax_map where inventory_id='".$record_id."' order by inv_tax_map_id asc ";
                                $ptr_fs = mysql_query($select_exc);
                                $s=1;
                                $total_comision= mysql_num_rows($ptr_fs);
                                $total_conditions= mysql_num_rows($ptr_fs);
                                while($data_exclusive = mysql_fetch_array($ptr_fs))
                                { 
                                    $slab_id= $data_exclusive['inv_tax_map_id'];
                                ?> 
                                <div class="type1" id="type1_id<?php echo $s; ?>">
                                <table cellspacing="5" id="tbl<?php echo $s; ?>" width="100%">
                                    <tr>
                                    <td width="8%" align="center">
                                    <input type="text" name="tax_type<?php echo $s; ?>" id="tax_type<?php echo $s; ?>" style=" width:100px" value="<?php echo $data_exclusive['tax_type'] ?>" />
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
                                        <input type="hidden" name="type1_id<?php echo $s; ?>" id="type1_id<?php echo $s; ?>" value="<?php echo $data_exclusive['inv_tax_map_id'] ?>" />
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
    
                        <!--<input type="hidden" name="total_type1" id="total_type1" class="inputText"   value="<?php //echo $total_conditions; ?>" />-->
    
                        <input type="hidden" name="type1" id="type1" class="inputText" value="<?php echo $total_conditions; ?>" />
    
                        <?php } ?> 
    
                        
    
                        </td>
    
                        </tr>
    
                    </table>
    
                 </td>
    
             </tr>
    
           <!--============================================================END TABLE 2=========================================-->
             <!---------------------------------------Payment mode------------------------------------->  
                        
                <tr>
                <td class="tr-header">Select Payment Mode <span class="orange_font">*</span></td>
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
           /* if($_SESSION['type'] !="S")
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
           /* if($record_id !='')
            {
            ?>
             <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">
             <option value="">--Select--</option>
             <?php
             $sle_bank_name="select bank_id,bank_name from bank where cm_id='".$row_record['cm_id']."'"; 
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
                         <td class="tr-header" width="21%">Account No</td>
                         <td><input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
                         </tr>
                         </table>
                 </div>
                 
                 <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                     <table width="100%">
                    
                     <tr>
                     <td class="tr-header" width="21%">Enter Chaque No</td>
                     <td><input type="text" name="chaque_no" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
                     </tr>
                     <tr>
                     <td class="tr-header" width="21%">Enter Chaque Date</td>
                     <td><input type="text" name="cheque_date" id="cheque_date" class="datepicker" value="<?php if($_POST['cheque_date']) echo $_POST['cheque_date']; else echo $row_record['chaque_date']; ?>"  /></td>
                     </tr>
                     </table>
                 </div>
                 
                 <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                     <table width="100%">
                    
                     <tr>
                     <td class="tr-header" width="21%">Enter Credit Card No</td>
                     <td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>
                     </tr>
                     </table>
                 </div>
                 </td>
               </tr>
               
               <tr>

                <td width="25%" >Final Amount</td>
            
                <td width="40%"><input type="text" name="amount1" id="amount1" onChange="cal_remaining_amt();" value="<?php if($_POST['save_changes']) echo $_POST['amount1']; else echo $row_record['amount1']; ?>"  /></td>
            
             </tr>
             
             <tr>

                <td width="25%" >Payable Amount</td>
            
                <td width="40%"><input type="text" name="payable_amount" id="payable_amount" value="<?php if($_POST['save_changes']) echo $_POST['payable_amount']; else echo $row_record['payable_amount']; ?>" onKeyUp="cal_remaining_amt();"/></td>
            
             </tr>
             
             <tr>

                <td width="25%" >Remaining Amount</td>
            
                <td width="40%"><input type="text" name="remaining_amount" id="remaining_amount" value="<?php if($_POST['save_changes']) echo $_POST['remaining_amount']; else echo $row_record['remaining_amount']; ?>"  /></td>
            
             </tr>
              <!---------------------------------------End Payment mode------------------------------------->
             
            <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Sales Product" name="save_changes"  /> &nbsp;&nbsp;&nbsp;<!--<input type="submit" class="input_btn" value="Save and Print" name="save_changes"  />--></td>
                  
            </tr>
        </table>
        </form>
        <script type="text/javascript">



            $(function() 

            {

                $(".custom_cuorse_submit").click(function(){
                    var cust_name = $("#cust_name").val();
                    var mobile1 = $("#mobile1").val();
                    var email = $("#email").val();
					 var branch_name = $("#branch_name").val();
                  
                    if(cust_name == "" || cust_name == undefined)
                    {
                        alert("Eneter Customer name.");
                        return false;
                    }
                    /*if(mobile1 == "" || mobile1 == undefined)
                    {
                        alert("Enter Mobile no.");
                        return false;
                    }
                    if(email == "" || email == undefined)
                    {
                        alert("Eneter Email ID.");
                        return false;
                    }*/
                    var data1 = 'action=custome_customer_submit&customer_name='+cust_name+'&mobile='+mobile1+'&email='+email+"&branch_name="+branch_name
                    $.ajax({
                        url: "ajax.php", type: "post", data: data1, cache: false,
                        success: function (html)
                        {
							if(html.trim() =='mobile')
							{
								alert("Mobile no. or Email already Exist");
								return false;
							}
							else if(html.trim() =='cust_id')
							{
								alert("Customer Name already Exist");
								return false;
							}
							else if (html.trim() =='blank')
							{
								alert("Please enter Mobile number");
								return false;
							}
							else
							{
								$(".customized_select_box").html(html);
								/*var tax=(service_taxes * course_fee)/100;
								var course_with_tax=Number(course_fee)+Number(tax);
								$("#cust_name").val(course_with_tax);*/
								$('.new_custom_course').dialog( 'close');
								$("#customer_id").chosen({allow_single_deselect:true});
								//getMembership()
							}
                        }
                    });
                });
         });
        </script>
        <div class="new_custom_course" style="display: none;">
            <form method="post" id="jqueryForm" name="discount" enctype="multipart/form-data">
                <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
                    <tr>
                        <td width="20%">Customer Name<span class="orange_font">*</span></td>
                        <td width="40%"><input type="text" class="inputText" name="cust_name" id="cust_name"/></td>
                    </tr>
                    <tr>
                        <td>Mobile<span class="orange_font"></span></td>
                        <td width="40%"><input type="text" class="inputText" name="mobile1" id="mobile1"/></td>
                    </tr>
                    <tr>
                        <td>Email<span class="orange_font"></span></td>
                        <td><input type="text" class="inputText" name="email" id="email"></td>
                    </tr>
                    <tr>
                    
                    <tr>
                        <td></td>
                        <td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit"/>&nbsp;
                            <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>  
        </td></tr>
<?php
                        }   ?>
	 
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

<?php
if($_SESSION['type']=="S" && $record_id=='')
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
	//exit();
}
?>
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>

<?php
if($record_id || $_SESSION['type']=="S")
{
	?>
    <script>
	if(document.getElementById("payment_type"))
	{
	vals= document.getElementById("payment_type").value;
	show_payment(vals);
	}
	</script>
	<?php
}
else
{
	?>
    <script>
	branch_name=document.getElementById("branch_name").value;
	show_bank(branch_name);
	
	</script>
	<?php
}
?>
</body>
</html>
<?php $db->close();?>