<?php 
//Change note
//Change on 11-5-20 by Kiran - in GST calcultion in show_user functions of usung roundNumber fuction for value upto 3 decimal point

include 'inc_classes.php';?>
<?php include "admin_authentication.php";
$page_name = "service";
$sele_sac_code="select sac_code from sac_code_config where page_name='".$page_name."'";
$ptr_sac_code=mysql_query( $sele_sac_code);
$data_sac_code=mysql_fetch_array($ptr_sac_code);
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='112'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Book Services</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>-->
<!--<script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<link rel="stylesheet" href="js/chosen.css" />
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var pageName = "add_cust_services";
$(document).ready(function(){            
	$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
	$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
	{
		res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
	}
	
	$("#customer_id").chosen({allow_single_deselect:true});
	$("#service_id1").chosen({allow_single_deselect:true});
	$("#employee_id").chosen({allow_single_deselect:true});
	$("#realtxt").chosen({allow_single_deselect:true});
	$("#user").chosen({allow_single_deselect:true});
	//$("#scheduler_default_corner").html();
});
function calculte_other_cost(val)
{
	var total=isNaN(parseFloat(val * 2)) ? 0 :(val * 2)
	$('#other_cost').val(total);
	var other_cost=document.getElementById("other_cost").value;
	var total1=isNaN(parseFloat((+val) + (+other_cost))) ? 0 :parseFloat((+val) + (+other_cost))
	$('#total_cost').val(total1);
	var total_cost=document.getElementById("total_cost").value;
	var total2=isNaN(parseFloat(total_cost * 4)) ? 0 :parseFloat(total_cost * 4)
	$('#service_price').val(total2);
}
 
function getMembership(cust_id)
{
	var data1="customer_id="+cust_id;	
	var data2="customer_id="+cust_id;
	//alert(data2);
	 $.ajax({
	url: "get_mail.php", type: "post", data: data2, cache: false,
	success: function (html)
	{
		//alert(html);
		document.getElementById('cus').value=html;
		 //$("#cus").html(data);
	}
	});
			
	if(cust_id != 'custome' )
	{
        $.ajax({
		url: "get_membership.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			if(html.trim() =='')
			{
				document.getElementById('membership_id').style.display="none";
				document.getElementById('memb_discount').value=0;
				document.getElementById('memb_discount_div').style.display="none";
				//document.getElementById('nonmemb_discount').value=0;
			}
			else
			{
				document.getElementById('membership_id').style.display="block";
				var sep_val=html.split("###");
				var memb_name= sep_val[0].trim();
				var memb_disc= sep_val[1].trim();
				if(memb_disc !="undefined" || memb_disc !='')
				{
					document.getElementById('memb_name').innerHTML=memb_name;
					document.getElementById('memb_disc').innerHTML=memb_disc;
					document.getElementById('memb_discount').value=memb_disc;
					document.getElementById('memb_discount_div').style.display="block";
					//document.getElementById('nonmemb_discount').value=0;
				}
			}
			if(document.getElementsByName("total_services[]").length >1)
			showUser();	
		}
		});
	}
	else
	{
		 $( ".new_customer_add" ).dialog({
                                        width: '500',
                                        height:'300'
                                    });
	}
	return false;
}

function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
function convert_date(datetime) 
{
    var d = datetime;
	var y = addZero(d.getFullYear());
	var m = addZero(d.getMonth()+ parseInt(1));
	var dt = addZero(d.getDate());
    var h = addZero(d.getHours());
    var min = addZero(d.getMinutes());
    var s = addZero(d.getSeconds());
    var fulldate = y + "-" + m + "-" + dt + "T" + h + ":" + min + ":" + s;
	return fulldate;
}
var total_service_time=0;
function getprice(values,val_idss)
{
	//alert(val_idss);
	var service_id=document.getElementById('service_id'+val_idss).value;
	var data1="service_id="+service_id;	
	//alert(data1);
        $.ajax({
            url: "get_service_price.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				service_split=html.split("-");
				document.getElementById("sin_service_price"+val_idss).value=service_split[0];
				document.getElementById("sin_service_time"+val_idss).value=parseInt(service_split[1]);
				document.getElementById("sin_service_total"+val_idss).value=service_split[0];
				document.getElementById("sin_service_qty"+val_idss).value=1;
				var exit_disc=document.getElementById("sin_service_disc"+val_idss).value = 0;
				var exit_disc_price=document.getElementById("sin_service_disc_price"+val_idss).value = 0;
				total_service_time =Number(parseInt(total_service_time)+parseInt(service_split[1]));
				document.getElementById("total_service_time").value=total_service_time;
				service_time=parseInt(service_split[1]);
				//alert(service_time);
				if(service_time!='')
				{
					start_time=document.getElementById("last_start").value;
					//alert(start_time);
					document.getElementById("from_time"+val_idss).value = start_time;
					start_split=start_time.split("T");
					start_date=start_split[0];
					start_times=start_split[1];
					//alert(start_times);
					start_minutes=start_times.split(":");
					start_min=start_minutes[1];
					var now = new Date(start_date+" "+start_times);
					now.setMinutes(now.getMinutes() + service_time);
					var date_format=convert_date(now);
					document.getElementById("last_start").value=date_format;
					document.getElementById("to_time"+val_idss).value = date_format;
					//$("#from_time"+val_idss+"")[0].valueAsDate = now;   
				}
            }
            });
			var exit_disc='';
			if(values !="")
			{		
				document.getElementById("sin_service_price"+val_idss).disabled = false;
				document.getElementById("sin_service_disc"+val_idss).disabled = false;
				document.getElementById("sin_service_time"+val_idss).disabled = false;
				document.getElementById("sin_service_total"+val_idss).disabled = false;
				document.getElementById("sin_service_qty"+val_idss).disabled = false;
				document.getElementById("staff_id"+val_idss).disabled = false;
				$("#staff_id"+val_idss).chosen({allow_single_deselect:true});
			}
			else
			{
				document.getElementById("sin_service_price"+val_idss).disabled = true;
				document.getElementById("sin_service_disc"+val_idss).disabled = true;
				document.getElementById("sin_service_time"+val_idss).disabled = true;
				document.getElementById("sin_service_qty"+val_idss).disabled = true;
				document.getElementById("sin_service_total"+val_idss).disabled = true;
				document.getElementById("staff_id"+val_idss).disabled = true;
				//$("#staff_id"+val_idss).chosen({allow_single_deselect:true});
			}
			setTimeout(showUser,800);
			if(document.getElementById("package"))
			{
				var package=document.getElementById("package").value;
				//setTimeout(add_package(package),500);
			}
			//getDiscount(exit_disc,val_idss)
			
			//cal_remaining_amt();
			//var order_no=document.getElementById("order_no"+val_idss).value;
			//show_staff_time();
}
/* function set_order(order_no,val_idss)
{
	alert(val_idss);
	document.getElementById("order_no"+val_idss).value=order_no;
}
function show_staff_time(order_no,val_idss)
{
	contact='0';
	var total_service= document.getElementsByName("total_services[]");
	var start_time=document.getElementById("start").value;
	var end_time='';
	totals=total_service.length;
	for(i=1; i<=totals;i++)
	{
		order_no=Number(document.getElementById("order_no"+i).value);
		alert(order_no);
		alert();
		start_time=document.getElementById("start").value;
		start_split=start_time.split("T");
		start_date=start_split[0];
		start_time=start_split[1];
		start_minutes=start_time.split(":");
		start_min=start_minutes[1];
							
		var now = new Date(start_date+" "+start_time);
		now.setMinutes(now.getMinutes() + service_time);
		alert(now);
		var date_format=convert_date(now);
		
		document.getElementById("from_time"+val_idss).value = date_format;
	}
} */
function calc_service_price(idss)
{
	frm = document.jqueryForm;  
	service_price=parseFloat(document.getElementById("sin_service_price"+idss).value);
	qty=parseInt(document.getElementById("sin_service_qty"+idss).value);
	total_price=parseFloat(service_price*qty);
	disc_val=parseFloat(document.getElementById("sin_service_disc"+idss).value);
	document.getElementById("sin_total"+idss).value=total_price;
	document.getElementById("sin_service_total"+idss).value=service_price;
	setTimeout(getDiscount(disc_val,idss),800);
}
function getDiscount(disc,idss)
{
	total_price='';
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.discount.value;
	service_price=parseFloat(document.getElementById("sin_total"+idss).value);
	if(disc_type=="rupees")
	{
		total_price=parseFloat(service_price-disc);
		discount_price=parseFloat(disc);
	}
	else
	{
		discount= parseFloat((service_price*disc)/100);
		total_price=parseFloat(service_price-discount);
		discount_price=parseFloat(discount);
	}
	document.getElementById("sin_service_total"+idss).value=total_price;
	document.getElementById("sin_service_disc_price"+idss).value=discount_price;
	showUser();
	//cal_remaining_amt();
}
function show_bank(branch_id,vals)
{
	record_id= document.getElementById("record_id").value;
	var bank_data="action=service&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(branch_id);
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
	var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		//installment_tax= taxes[1];
		<?php
		if($_SESSION['tax_type']!='GST')
		{
			?>
			document.getElementById("service_tax_id").innerHTML=service_tax;
			document.getElementById("service_taxes").value=service_tax;
			<?php
		}
		?>
		cgst=taxes[2];
		sgst=taxes[3];
		igst=taxes[4];
		
		document.getElementById("cgst_id").innerHTML=cgst;
		document.getElementById("sgst_id").innerHTML=sgst;
		document.getElementById("igst_id").innerHTML=igst;
		document.getElementById("cgst_taxes").value=cgst;
		document.getElementById("sgst_taxes").value=sgst;
		document.getElementById("igst_taxes").value=igst;
	}
	});
	showUser();
}
function show_bank_for_payment_mode(branch_id,vals)
{
	//alert(branch_id);
	record_id= document.getElementById("record_id").value;
	var bank_data="action=service&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(branch_id);
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
}
function show_data(id)
{
	//alert(bank_id);
	var record_id= document.getElementById('record_id').value;
	var branch_name=document.getElementById("branch_name").value;
	var data1="action=show_data&action_page=book_service&id="+id+'&record_id='+record_id+'&branch_name='+branch_name;
	//document.getElementById("billing_address").value= '';
	//document.getElementById("delivery_address").value= '';
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
</script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='112' ".$_SESSION['where']."";
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
//alert(mail1);
function send()
{		//alert("hi");						  
var branch_name =document.getElementById('branch_name').value;
var realtxt =document.getElementById('realtxt').value;
customer =document.getElementById('customer_id');
var customer_id=customer.options[customer.selectedIndex].text;
if(document.getElementById('cus'))
var mail=document.getElementById('cus').value;
else
var mail="santosh.sapke@gmail.com";
//alert(mail);
var total_service =document.getElementById('no_of_floor').value;
concat_string='';
for(i=1; i<=total_service; i++)
{
	service_id = document.getElementById('service_id'+i).value;
	service = document.getElementById('service_id'+i);
	service_text = service.options[service.selectedIndex].text;
	staff_id =document.getElementById('staff_id'+i).value;
	staff =document.getElementById('staff_id'+i);
	staff_name = staff.options[staff.selectedIndex].text;
	sin_service_price =document.getElementById('sin_service_price'+i).value;
	sin_service_disc =document.getElementById('sin_service_disc'+i).value;
	sin_service_total =document.getElementById('sin_service_total'+i).value; 
	concat_string +='&service_id'+i+'='+service_id+'&service_name'+i+'='+service_text+'&sin_service_price'+i+'='+sin_service_price+'&sin_service_disc'+i+'='+sin_service_disc+'&sin_service_total'+i+'='+sin_service_total+'&staff_id'+i+'='+staff_id+'&staff_name'+i+'='+staff_name;
}
var service_price =document.getElementById('service_price').value;
var nonmemb_discount =document.getElementById('nonmemb_discount').value;
var nonmemb_discount_price =document.getElementById('nonmemb_discount_price').value;
//var service_tax =document.getElementById('service_tax').value;
var total_cost =document.getElementById('total_cost').value;
 cate =document.getElementById('category');
var category = cate.options[cate.selectedIndex].text;
//alert(category);
var payment_mode =document.getElementById('payment_mode').value;
var amount =document.getElementById('amount').value;
var payable_amount =document.getElementById('payable_amount').value;
var remaining_amount =document.getElementById('remaining_amount').value;
var employee_id=document.getElementById('employee_id');
employee_id=employee_id.options[employee_id.selectedIndex].text; 
var total_voucher=document.getElementById('type1').value;
concat_string_voucher='';
for(j=1; j<=total_voucher; j++)
{
	voucher=document.getElementById('voucher_deal_id'+j);
	voucher_name=voucher.options[voucher.selectedIndex].text;
	cust_voucher_code =document.getElementById('cust_voucher_code'+j).value;
	vouchers_start_date =document.getElementById('vouchers_start_date'+j).value;
	vouchers_end_date =document.getElementById('vouchers_end_date'+j).value;
	vouchers_price =document.getElementById('vouchers_price'+j).value;
	totals_price =document.getElementById('totals_price'+j).value;
	remaining_amnt_in_voucher =document.getElementById('remaining_amnt_in_voucher'+j).value;
	total_remaining_amnt =document.getElementById('total_remaining_amnt'+j).value;
	concat_string_voucher +='&voucher_name'+j+'='+voucher_name+'&cust_voucher_code'+j+'='+cust_voucher_code+'&vouchers_start_date'+j+'='+vouchers_start_date+'&vouchers_end_date'+j+'='+vouchers_end_date+'&vouchers_price'+j+'='+vouchers_price+'&totals_price'+j+'='+totals_price+'&remaining_amnt_in_voucher'+j+'='+remaining_amnt_in_voucher;  
} 
package1='';
package_name='';
package_names='';
package_start_date='';
package_end_date='';
package_price='';
totals_price_pkg='';
if(document.getElementById('packagess_deal_id'))
{
package1=document.getElementById('packagess_deal_id');
package_name=package1.options[package1.selectedIndex].text;

var package_names =document.getElementById('package_names').value;
var package_start_date =document.getElementById('package_start_date').value;
var package_end_date =document.getElementById('package_end_date').value;
var package_price =document.getElementById('package_price').value;
var totals_price_pkg =document.getElementById('totals_price_pkg').value;
}
bank='';
bank_name='';
account_no='';
chaque_no='';
cheque_date='';
if(document.getElementById('bank_name'))
{
var bank=document.getElementById('bank_name');
bank_name=bank.options[bank.selectedIndex].text;
var account_no =document.getElementById('account_no').value;
var chaque_no =document.getElementById('chaque_no').value;
var cheque_date =document.getElementById('cheque_date').value;
}
var users_mail=mail1;
//alert(users_mail);
data1='action=add_cust_services&branch_name='+branch_name+'&realtxt='+realtxt+'&customer_id='+customer_id+concat_string+'&total_service='+total_service+concat_string_voucher+'&total_voucher='+total_voucher+'&service_price='+service_price+'&nonmemb_discount='+nonmemb_discount+'&nonmemb_discount_price='+nonmemb_discount_price+'&total_cost='+total_cost+'&category='+category+'&payment_mode='+payment_mode+'&amount='+amount+'&payable_amount='+payable_amount+'&remaining_amount='+remaining_amount+'&employee_id='+employee_id+'&bank_name='+bank_name+'&account_no='+account_no+'&chaque_no='+chaque_no+'&cheque_date='+cheque_date+'&package_name='+package_name+'&package_start_date='+package_start_date+'&package_end_date='+package_end_date+'&package_price='+package_price+'&totals_price_pkg='+totals_price_pkg+"&users_mail="+users_mail+"&mail="+mail+"&email_text_msg="+email_text_msg;
//alert(data1);
	$.ajax({
	url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
	success: function(response)
	{
		//alert(response);
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
		document.getElementById("paytm_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		//document.getElementById("voucher_div_id").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("paytm_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		//document.getElementById("voucher_div_id").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"credit_card")
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'block';
		document.getElementById("bank_ref_no").style.display = 'none';
		//document.getElementById("voucher_div_id").style.display = 'none';
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
	/*else if(payment_mode[0]=="voucher")
	{
		//alert(payment_mode[0]);
		var cust_id=document.getElementById("customer_id").value;
		//alert(cust_id);
		var data="action=check_voucher_id&cust_id="+cust_id+"&record_id="+record_id;
		$.ajax({
			url:"ajax.php", type:"post", data:data, cache:false,
			success : function(html)
			{
				//alert(html);
				sep=html.split("###");
				voucher=sep[0].trim();
				deals=sep[1].trim();
				
				if(voucher !='')
				{
					document.getElementById("voucher_no").style.display = 'block';
					document.getElementById("chaque_details").style.display = 'none';
					document.getElementById("bank_details").style.display = 'none';
					document.getElementById("credit_details").style.display = 'none';
					//document.getElementById("voucher_no").innerHTML= deals;
					//document.getElementById("voucher_div_id").style.display = 'block';
					
					voucher_id=document.getElementById("voucher_deal_id").value;
					setTimeout(show_voucher_details(voucher_id,'',''),500)
				}
				else
				{
					alert("Voucher is Not added for this customer or validity or quantity of service is over.");
					document.getElementById("payment_mode").selectedIndex=0;
				}
				
			}
		});
		
		show_bank_for_payment_mode(branch_name,"voucher")
	}
	else if(payment_mode[0]=="package")
	{
		//alert(payment_mode[0]);
		var cust_id=document.getElementById("customer_id").value;
		//alert(cust_id);
		var data="action=check_package_id&cust_id="+cust_id+"&record_id="+record_id;
		$.ajax({
			url:"ajax.php", type:"post", data:data, cache:false,
			success : function(html)
			{
				//alert(html);
				sep=html.split("###");
				package=sep[0].trim();
				deals=sep[1].trim();
				
				if(package !='')
				{
					document.getElementById("package_id").style.display = 'block';
					document.getElementById("chaque_details").style.display = 'none';
					document.getElementById("bank_details").style.display = 'none';
					document.getElementById("credit_details").style.display = 'none';
					document.getElementById("package_id").innerHTML= deals;
					document.getElementById("package_div_id").style.display = 'block';
					
					package_id=document.getElementById("packagess_deal_id").value;
					setTimeout(show_package_details(package_id),500)
				}
				else
				{
					alert("Package is Not added for this customer or validity or quantity of service is over.");
					document.getElementById("payment_mode").selectedIndex=0;
				}
				
			}
		});
		
		show_bank_for_payment_mode(branch_name,"voucher")
	}*/
	else 
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		//document.getElementById("voucher_no").style.display = 'none';
		//document.getElementById("voucher_div_id").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"")
	}
}
function show_acc_no(bank_id)
{
	var data1="action=show_account&bank_id="+bank_id;
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		document.getElementById('account_no').value=html;
	}
	});
}
function show_time(cur_time)
{
	var start_time_hr=document.getElementById("start_time_hr").value;
	//alert(start_time_hr);
	
	var start_time_min=document.getElementById("start_time_min").value;
	//alert(start_time_min)
	
	var time = ((start_time_hr<=9) ? "0"+start_time_hr : start_time_hr) + ":" + ((start_time_min<=9) ? "0" + start_time_min : start_time_min);
	//Total start time selected in ?00:00:00? format. For hours and minutes less than 9, the function adds a 0 before the number.
	//alert(time)
	
	document.getElementById('start_time').value = time; //Selected value get displayed in End time text area.
	
	sep_cur_time=time.split(":");
	//alert(sep_cur_time[1])
	
	if(start_time_hr >24)
	{
		alert("Start time is not greater than 24");
		document.getElementById("start_time").value=24;
	}
	else
	{
		contact='';
		var total_service= document.getElementsByName("total_services[]");
		totals=total_service.length;
		for(i=1; i<=totals;i++)
		{
			//alert(i);
			ser_id="sin_service_time"+i;
			servicesss_idddd=Number(document.getElementById(ser_id).value);
			//alert(servicesss_idddd);
			if(servicesss_idddd!='')
			{
				contact =Number(contact)+Number(servicesss_idddd);
				//alert(contact);
			}
		}
		//alert("total- "+contact);
		m = contact % 60;
		h = (contact-m)/60;
		HRSMINS = h.toString() + ":" + (m<10?"0":"") + m.toString();
		sep_hrs=HRSMINS.split(":");
		
		if(sep_cur_time[1]!=00)
		{
			//alert(sep_cur_time[1]);
			//alert(sep_hrs[1])
			
			tot_min=Number(sep_cur_time[1]) + Number(sep_hrs[1]);
			//alert(tot_min)
			tot_min_new1=tot_min;
			new_hrs=Number(start_time_hr) + Number(sep_hrs[0]);
			
			if(tot_min > 60)
			{
				//alert(tot_min)
				new_hrs=new_hrs + 1;
				tot_min_new= (tot_min - 60);
				var tot_min_new1 = ((tot_min_new<=9) ? "0"+tot_min_new : tot_min_new);
			}
			
			
			total_hrs=new_hrs+":"+tot_min_new1;
		}
		
		else
		{
			new_hrs=Number(start_time_hr) + Number(sep_hrs[0]);
			total_hrs=new_hrs+":"+sep_hrs[1];
		}
			
		if(total_hrs>24)
		{
			alert("End time will not greater than 24. Enter other start time");
			document.getElementById("end_time").value=24;
		}
		else
		{
			document.getElementById("end_time").value=total_hrs;
		}
		
	}
}
function show_exist_time(emp_id)
{
	/*var date=document.getElementById("date").value;
	var start_time = document.getElementById("start_time").value;
	var curr_date = document.getElementById("date").value;
	var data1="emp_id="+emp_id+"&start_time="+start_time+"&curr_date="+curr_date;
	
	$.ajax({
	url: "get_exit_time.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		
		if(html.trim() !='')
		{
			alert("This Time Schedule is already exist for this Staff,Please Select another Start time");
			document.getElementById("start_time").value='';
			document.getElementById("end_time").value='';
			document.getElementById("employee_id").selectedIndex = "0";
		}
	}
	});*/
}
function show_category(value)
{
	var category=value;
	record_id= document.getElementById("record_id").value;
	if(category=="Voucher")
	{
		//alert(payment_mode[0]);
		document.getElementById("voucher_no").style.display="block";
		var cust_id=document.getElementById("customer_id").value;
		//alert(cust_id);
		var data="action=check_voucher_id&cust_id="+cust_id+"&record_id="+record_id;
		$.ajax({
			url:"ajax.php", type:"post", data:data, cache:false,
			success : function(html)
			{
				//alert(html);
				sep=html.split("###");
				voucher=sep[0].trim();
				deals=sep[1].trim();
				//alert(deals);
				if(voucher !='')
				{
					document.getElementById("voucher_no").style.display = 'block';
					//document.getElementById("chaque_details").style.display = 'none';
					//document.getElementById("bank_details").style.display = 'none';
					//document.getElementById("credit_details").style.display = 'none';
					document.getElementById("res1").value= deals;
					//document.getElementById("voucher_div_id").style.display = 'block';
					
					voucher_id=document.getElementById("voucher_deal_id1").value;
					//setTimeout(show_voucher_details(voucher_id,1,''),500)
				}
				else
				{
					alert("Voucher is Not added for this customer or validity or quantity of service is over.");
					document.getElementById("payment_mode").selectedIndex=0;
				}
				
			}
		});
		
		//show_bank(branch_name,"Voucher")
	}
	else if(category=="Package")
	{
		document.getElementById("voucher_no").style.display="none";
		//alert(payment_mode[0]);
		var cust_id=document.getElementById("customer_id").value;
		//alert(cust_id);
		var data="action=check_package_id&cust_id="+cust_id+"&record_id="+record_id;
		$.ajax({
			url:"ajax.php", type:"post", data:data, cache:false,
			success : function(html)
			{
				//alert(html);
				sep=html.split("###");
				package=sep[0].trim();
				deals=sep[1].trim();
				
				if(package !='')
				{
					document.getElementById("package_id").style.display = 'block';
					document.getElementById("chaque_details").style.display = 'none';
					document.getElementById("bank_details").style.display = 'none';
					document.getElementById("credit_details").style.display = 'none';
					document.getElementById("bank_ref_no").style.display = 'none';
					document.getElementById("package_id").innerHTML= deals;
					document.getElementById("package_div_id").style.display = 'block';
					
					package_id=document.getElementById("packagess_deal_id").value;
					setTimeout(show_package_details(package_id),500)
				}
				else
				{
					alert("Package is Not added for this customer or validity or quantity of service is over.");
					document.getElementById("payment_mode").selectedIndex=0;
				}
				
			}
		});
		
		//show_bank(branch_name,"voucher")
	}
	else if(category=="loyalty_point")
	{
		document.getElementById("loyalty_points_id").style.display="block";
		document.getElementById("voucher_no").style.display="none";
		document.getElementById("package_id").innerHTML = '';
		
		//alert(payment_mode[0]);
		var cust_id=document.getElementById("customer_id").value;
		var branch_name=document.getElementById("branch_name").value;
		
		var data="action=check_loyalty_points&cust_id="+cust_id+"&record_id="+record_id+"&branch_name="+branch_name;
		//alert(data);
		$.ajax({
			url:"ajax.php", type:"post", data:data, cache:false,
			success : function(html)
			{
				//alert(html);
				if(html!='')
				{
					sep=html.split('###');
					document.getElementById("loyalty_points_id").innerHTML=sep[1];
					document.getElementById("loyalty_success").innerHTML=sep[2];
					setTimeout(showUser(),500)
				}
				
			}
		});
	}
}

function show_redeme_points(redeme_point)
{
	//alert(redeme_point);
	var cust_id=document.getElementById("customer_id").value;
	var branch_name=document.getElementById("branch_name").value;
	
	var data="action=redeme_loyalty_points&cust_id="+cust_id+"&redeme_point="+redeme_point+"&branch_name="+branch_name;
	//alert(data);
	$.ajax({
		url:"ajax.php", type:"post", data:data, cache:false,
		success : function(html)
		{
			//alert(html);
			if(html!='')
			{
				sep=html.split('###');
				//document.getElementById("loyalty_points_id").innerHTML=sep[1];
				if(sep[1].trim()!='')
				{
					document.getElementById("redemptoin_value").value=sep[1];
					
				}
				else
				{
					document.getElementById("redemptoin_value").value=0;
				}
				setTimeout(showUser(),500);
				document.getElementById("loyalty_success").innerHTML=sep[2];
				
			}
			
		}
	});
	
}

function show_voucher_details(value,id,voucher_code)
{
	voucher_id=value.trim();
	//alert(value+" - "+id);
	if(voucher_id !='' && id!='')
	{
		cust_id=document.getElementById("customer_id").value;
		var data="voucher_id="+voucher_id+"&cust_id="+cust_id+"&voucher_code="+voucher_code;
		$.ajax({
		url:"get_voucher_details.php", type:"post", data:data,cache:false,
		success:function(html)
		{
			//alert(html);
			var new_html=html.split("###");
			if(new_html[0].trim() =='')
			{
				document.getElementById('voucher_div_id'+id).style.display="none";
			}
			else
			{
				if(voucher_id!='')
				{
					//alert(new_html[1]);
					document.getElementById('voucher_div_id'+id).style.display="block";
					var sep_val=new_html[0].split("/");
					var name= sep_val[0].trim();
					var voucher_price= sep_val[1].trim();
					var start_date= sep_val[2].trim();
					var end_date= sep_val[3].trim();
					var exist_qty= sep_val[4].trim();
					var category= sep_val[5].trim();
					var price= sep_val[6].trim();
					//alert(price);
					document.getElementById('voucher_name'+id).innerHTML=name;
					document.getElementById("vouchers_name"+id).value=name;
					document.getElementById("voucher_price"+id).innerHTML=price;
					document.getElementById("vouchers_price"+id).value=price;
					document.getElementById("voucher_start_date"+id).innerHTML=start_date;
					document.getElementById("vouchers_start_date"+id).value=start_date;
					document.getElementById("voucher_end_date"+id).innerHTML=end_date;
					document.getElementById("vouchers_end_date"+id).value=end_date;
					//document.getElementById("issue_qty").value=exist_qty;
					//alert("category "+category);
					document.getElementById("categories"+id).value=category;
					
					document.getElementById("voucher_prices"+id).innerHTML=price;
					var amnt=document.getElementById("amount").value;
					document.getElementById("amount_prices"+id).innerHTML=amnt;
					
					total=Number(price)-Number(amnt);
					//alert(total);
					if(category!="service")
					{
						document.getElementById("totals_price"+id).value=Math.abs(total);
						if(voucher_id !='' && id!='')
						{
							if(total < 0)
							{
								document.getElementById("total_price"+id).innerHTML=Math.abs(total);
								document.getElementById("remaining_amnt_in_voucher"+id).value=0;
								document.getElementById("remaining_total"+id).innerHTML=0;
								document.getElementById("amount").value=Math.abs(total);
								document.getElementById("remaining_amount").value=Math.abs(total);
								document.getElementById("total_remaining_amnt"+id).value=Math.abs(total);
							}
							else
							{ 
								document.getElementById("total_price"+id).innerHTML=0;
								document.getElementById("remaining_amnt_in_voucher"+id).value=Math.abs(total);
								document.getElementById("remaining_total"+id).innerHTML=Math.abs(total);
								document.getElementById("amount").value=0;
								document.getElementById("remaining_amount").value=0;
								document.getElementById("total_remaining_amnt"+id).value=0;
							}
						}
						document.getElementById("amount_div"+id).style.display="block";
					}
					else
					{
						document.getElementById("amount_div"+id).style.display="none";
						
						if(new_html[1] !='')
						{
							var voucher_services_id=new_html[1].trim();
							//alert(voucher_services_id);
							sep=voucher_services_id.split(",");
							var total_service= document.getElementsByName("total_services[]");
							totals=total_service.length;
							for(var k=0;k<sep.length;k++)
							{
								for(i=1; i<=totals;i++)
								{
									//alert(i);
									//var ser_id=;
									servicesss_idddd=Number(document.getElementById("service_id"+i).value);
									//alert(servicesss_idddd);
									if(servicesss_idddd==sep[k])
									{
										//alert("hi its"+i);
										document.getElementById("sin_service_total"+i).value=0;
										//contact =Number(contact)+Number(servicesss_idddd);
										//alert(contact);
										showUser();
									}
								}
							}
						}
						amount = document.getElementById("amount").value;
						//document.getElementById("remaining_total"+id).innerHTML=amount;
						document.getElementById("voucher_prices"+id).innerHTML='';
						document.getElementById("amount_prices"+id).innerHTML='';
						document.getElementById("total_price"+id).innerHTML='';
						document.getElementById("totals_price"+id).value='';
						document.getElementById("remaining_total"+id).innerHTML='';
						document.getElementById("total_remaining_amnt"+id).value=amount;
						document.getElementById("remaining_amount"+id).value=amount;
					}
					
					/*var total_voucher= document.getElementsByName("total_voucher[]");
					totals=total_voucher.length;
					alert("total voucher "+totals)
					for(i=1; i<=totals;i++)
					{
						//alert(i);
						document.getElementById("voucher_prices"+i).innerHTML=price;
						var amnt=document.getElementById("amount").value;
						document.getElementById("amount_prices"+i).innerHTML=amnt;
						
						total=Number(price)-Number(amnt);
						alert(total);
						document.getElementById("total_price"+i).innerHTML=Math.abs(total);
						document.getElementById("totals_price"+i).value=Math.abs(total);
						
						if(total < 0)
						{
							document.getElementById("remaining_amnt_in_voucher"+i).value=0;
							document.getElementById("remaining_total"+i).innerHTML=0;
							document.getElementById("amount").value=Math.abs(total);
							//document.getElementById("total_remaining_amnt").value=Math.abs(total);
							
						}
						else
						{ 
							document.getElementById("remaining_amnt_in_voucher"+id).value=Math.abs(total);
							document.getElementById("remaining_total"+id).innerHTML=Math.abs(total);
							document.getElementById("amount").value=0;
							//document.getElementById("total_remaining_amnt").value=0;
						}
					}*/
					//var amount=document.getElementById("amount").value;
					
					
					/*if(total < 0)
					{
						
					}
					else
					{
						document.getElementById("amount").value=0;
						document.getElementById("remaining_voucher").value=Math.abs(total);
					}*/
					
				}
				
			}
		}
		});
	}
	if(voucher_id.trim()=='' && id !='')
	{
		new_id=id-1;
		//alert(new_id);
		//alert("hi kiran");
		categories=document.getElementById("categories"+new_id).value;
		if(categories !="service")
		{
			//alert("previous cat is "+categories);
			voucher_id=document.getElementById("voucher_deal_id"+new_id).value;
			remaining_amnt=document.getElementById("total_remaining_amnt"+new_id).value
			//alert("amount= "+remaining_amnt);
			document.getElementById("amount").value=remaining_amnt;
			document.getElementById("remaining_amount").value=remaining_amnt;
			
			document.getElementById("voucher_prices"+id).innerHTML='';
			document.getElementById("amount_prices"+id).innerHTML='';
			document.getElementById("total_price"+id).innerHTML='';
			document.getElementById("totals_price"+id).value='';
			document.getElementById("remaining_total"+id).innerHTML='';
			document.getElementById("remaining_amnt_in_voucher"+id).value='';
			document.getElementById("total_remaining_amnt"+id).value='';
		}
		else
		{
			//alert("previous cat is "+categories);
			document.getElementById("voucher_prices"+id).innerHTML='';
			document.getElementById("amount_prices"+id).innerHTML='';
			document.getElementById("total_price"+id).innerHTML='';
			document.getElementById("totals_price"+id).value='';
			document.getElementById("remaining_total"+id).innerHTML=0;
			document.getElementById("remaining_amnt_in_voucher"+id).value=0;
			remaining_amnt=document.getElementById("total_remaining_amnt"+new_id).value
			document.getElementById("total_remaining_amnt"+id).value='';
			document.getElementById("amount").value=remaining_amnt;
			document.getElementById("remaining_amount").value=remaining_amnt;
		}
		/*document.getElementById("redemption_div_id"+id).innerHTML="<span></span>";
		document.getElementById("price_in_voucher_div_id"+id).innerHTML="<span></span>";*/
		//show_voucher_details(voucher_id,new_id)
		
	}
	
	cal_remaining_amt();
}

function validates(id)
{
	//alert(id);
	$('#loading'+id).html('<img src="images/loading.gif"> loading...');
	if(id !='')
	{
		voucher_id=document.getElementById("voucher_deal_id"+id).value;
		voucher_code=document.getElementById("cust_voucher_code"+id).value;
		cust_id=document.getElementById("customer_id").value;
		if(voucher_id.trim()!='')
		{
			var data="voucher_id="+voucher_id+"&cust_id="+cust_id+"&voucher_code="+voucher_code;
			$.ajax({
				url:"validate_voucher_code.php", type:"post", data:data,cache:false,
				success:function(html)
				{
					//alert(html);
					sep=html.split("###");
					
					if(sep[0].trim() > 0)
					{
						setTimeout(function () 
						{
							voucher_code_id=sep[1];
							document.getElementById('loading'+id).innerHTML='';
                			//$('#loading').html()
							show_voucher_details(voucher_id,id,voucher_code_id);
							//alert(voucher_code_id);
							document.getElementById("redeme_code_id"+id).value=voucher_code_id;
            			}, 1000);
					}
					else
					{
						setTimeout(function () 
						{
							document.getElementById('loading'+id).innerHTML='';
							alert("Selected Voucher or code is not valid");
							
							new_id=id-1;
							
							document.getElementById("voucher_prices"+id).innerHTML='';
							document.getElementById("amount_prices"+id).innerHTML='';
							document.getElementById("total_price"+id).innerHTML='';
							document.getElementById("totals_price"+id).value='';
							document.getElementById("remaining_total"+id).innerHTML=0;
							document.getElementById("remaining_amnt_in_voucher"+id).value=0;
							if(document.getElementById("total_remaining_amnt"+new_id))
							{
								remaining_amnt=document.getElementById("total_remaining_amnt"+new_id).value
								document.getElementById("amount").value=remaining_amnt;
								document.getElementById("remaining_amount").value=remaining_amnt;
							}
							else
							{
								remaining_amnt=document.getElementById("total_cost").value;
								document.getElementById("amount").value=remaining_amnt;
								document.getElementById("remaining_amount").value=remaining_amnt;
							}
							document.getElementById("total_remaining_amnt"+id).value='';
							//show_voucher_details(voucher_id,id,voucher_code_id);
							//document.getElementById("redeme_code_id"+id).value=voucher_code_id;
							//document.getElementById('voucher_div_id'+id).innerHTML='';
							//document.getElementById('redemption_div_id'+id).innerHTML='';
							//alert(voucher_code_id);
							
							
						}, 1000);
					}
				}
			});
		}
	}
	
	cal_remaining_amt();
	
}

function show_package_details(value)
{
	package_id=value;
	//alert(voucher_id);
	cust_id=document.getElementById("customer_id").value;
	var data="package_id="+package_id+"&cust_id="+cust_id;
	$.ajax({
	url:"get_package_details.php", type:"post", data:data,cache:false,
	success:function(html)
	{
		//alert(html);
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
			//var exist_qty= sep_val[4].trim();
			//var category= sep_val[5].trim();
			
			document.getElementById('packages_names').innerHTML=name;
			document.getElementById("package_names").value=name;
			document.getElementById("packages_price").innerHTML=price;
			document.getElementById("package_price").value=price;
			document.getElementById("packages_start_date").innerHTML=start_date;
			document.getElementById("package_start_date").value=start_date;
			document.getElementById("packages_end_date").innerHTML=end_date;
			document.getElementById("package_end_date").value=end_date;
			//document.getElementById("issue_qty").value=exist_qty;
			//document.getElementById("categories").value=category;
			
			document.getElementById("package_prices").innerHTML=price;
			var amnt=document.getElementById("amount").value;
			document.getElementById("package_amnt_prices").innerHTML=amnt;
			
			total=Number(price)-Number(amnt);
			document.getElementById("total_price_pkg").innerHTML=Math.abs(total);
			document.getElementById("totals_price_pkg").value=Math.abs(total);
			//var amount=document.getElementById("amount").value;
			
			if(total < 0)
			{
				document.getElementById("amount").value=Math.abs(total);
				document.getElementById("remaining_amount").value=Math.abs(total);
			}
			else
			{
				document.getElementById("amount").value=0;
				document.getElementById("remaining_amount").value=0;
				document.getElementById("remaining_voucher").value=Math.abs(total);
			}
			if(new_html[1] !='')
			{
				var voucher_services_id=new_html[1].trim();
				//alert(voucher_services_id);
				sep=voucher_services_id.split(",");
				
				var total_service= document.getElementsByName("total_services[]");
				totals=total_service.length;
				for(var k=0;k<sep.length;k++)
				{
					for(i=1; i<=totals;i++)
					{
						//alert(i);
						//var ser_id=;
						servicesss_idddd=Number(document.getElementById("service_id"+i).value);
						//alert(servicesss_idddd);
						if(servicesss_idddd==sep[k])
						{
							//alert("hi its"+i);
							document.getElementById("sin_service_total"+i).value=0;
							//contact =Number(contact)+Number(servicesss_idddd);
							//alert(contact);
							showUser();
						}
					}
				}
				
			}
		}
	}	
	});
	
	cal_remaining_amt();
}
</script>
<!--<link href="js/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css">
<script src="js/jquery.flexdatalist.min.js"></script>
<script>
$('.flexdatalist').flexdatalist({
	minLength: 1
});
</script>-->
<script>

function cal_remaining_amt()
	{
		var final_amt=Number(document.getElementById('amount').value);
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
		
		if(payable_amt!='')
		{
			cal_tot_rem_amt=final_amt - payable_amt;
			
		}
		else
		{
		  cal_tot_rem_amt=final_amt;
		  
		}
		cal_tot_re=Math.round(cal_tot_rem_amt);
		//alert(cal_tot_re);
		
		$('#remaining_amount').val(cal_tot_re);
	}
	
/*function myFunction(form)
{
	 if(document.getElementById("date").value == "")
	   {
		  alert("Please Enter Date"); // prompt user
		  document.getElementById("date").style.borderColor  = "red";
		  return false;
	   }
	   if(document.getElementById("start_time").value == "")
	   {
		  alert("Please Enter Start Time"); // prompt user
		  document.getElementById("start_time").style.borderColor  = "red";
		  return false;
	   }
	   if(document.getElementById("end_time").value == "")
	   {
		  alert("Please Enter End Time"); // prompt user
		  document.getElementById("end_time").style.borderColor  = "red";
		  return false;
	   }
	   if(document.getElementById("payment_mode").value == "")
	   {
			//alert(document.getElementById("payment_mode").value)
			alert("Please select Payment Mode"); 
			document.getElementById("payment_mode").style.borderColor  = "red";
			return false;
	   }
	   if(document.getElementById("employee_id").value == "")
	   {
		  alert("Please select Employee"); // prompt user
		  document.getElementById("employee_id").style.borderColor  = "red";
		  return false;
	   }
	   var i,
	   chks = document.getElementsByName('requirment_id[]');
	   for (i = 0; i < chks.length; i++)
	   {
		   	if (chks[i].checked)
			{
			   return true;
			}
			else
			{

        		alert('Please select Service');
        		return false;
    		}

  		}
}*/
function delete_service(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#service_id'+id).replaceWith(function(){
			
			return $('<select name="service_id'+id+'" id="service_id'+id+'" style="width:140px"><option value=""></option></select>', {html: $(this).html()});
		});
		$('#sin_service_price'+id).replaceWith(function(){
			
			return $('<input type="text" name="sin_service_price'+id+'" id="sin_service_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_disc'+id).replaceWith(function(){
			
			return $('<input type="text" name="sin_service_disc'+id+'" id="sin_service_disc'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_disc_price'+id).replaceWith(function(){
			
			return $('<input type="text" name="sin_service_disc_price'+id+'" id="sin_service_disc_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_time'+id).replaceWith(function(){
			
			return $('<input type="text" name="sin_service_time'+id+'" id="sin_service_time'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_total'+id).replaceWith(function(){
			
			return $('<input type="text" name="sin_service_total'+id+'" id="sin_service_total'+id+'" value="" />', {html: $(this).html()});
		});
		$('#staff_id'+id).replaceWith(function(){
			
			return $('<select name="staff_id'+id+'" id="staff_id'+id+'" style="width:140px"></select>', {html: $(this).html()});
		});
		
		if(types=='floor')
		{  
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
			showUser();
		}
	}
}
 function validme()
 {
	 frm = document.jqueryForm;
	 error='';
	 disp_error = 'Clear The Following Errors : \n\n';
	 if(frm.customer_id.value=='')
	 {
		 disp_error +='Select Customer Name\n';
		 document.getElementById('customer_id').style.border = '1px solid #f00';
		 frm.customer_id.focus();
		 error='yes';
	 }
	 if(frm.service_price.value <=0)
	 {
		 disp_error +='Enter Service Price \n';
		 document.getElementById('service_price').style.border = '1px solid #f00';
		 frm.service_price.focus();
		 error='yes';
	 }
	/* if(frm.service_tax.value=='')
	 {
		 disp_error +='Enter Service tax \n';
		 document.getElementById('service_tax').style.border = '1px solid #f00';
		 frm.service_tax.focus();
		 error='yes';
	 }
	 */
	 /*if(frm.total_cost.value !='')
	 {
		 disp_error +='Enter Total cost \n';
		 document.getElementById('total_cost').style.border = '1px solid #f00';
		 frm.total_cost.focus();
		 error='yes';
	 }*/
	/*  if(frm.date.value=='')
	 {
		 disp_error +='Select Date \n';
		 document.getElementById('date').style.border = '1px solid #f00';
		 frm.date.focus();
		 error='yes';
	 }
	 else
	 {
		if(isFeatureDate(frm.date.value))
		{
		}
		 else
		 {
			 disp_error +='Enter Valid Date\n';
			  document.getElementById('date').style.border = '1px solid #f00';
			 error='yes';
		 }
	 }*/
	 /*if(frm.start_time.value=='')
	 {
		 disp_error +='Enter Start Time  \n';
		 document.getElementById('start_time').style.border = '1px solid #f00';
		 frm.start_time.focus();
		 error='yes';
	 }
	 
	 if(frm.end_time.value=='')
	 {
		 disp_error +='Select Response Category  \n';
		 document.getElementById('end_time').style.border = '1px solid #f00';
		 frm.end_time.focus();
		 error='yes';
	 }*/
	 
	if(frm.payment_mode.value!='')
	{	 
		if(frm.payment_mode.value=="cheque-2")
		{
			if(frm.bank_name.value=="select")
		 	{
				 disp_error +='Select Bank name  \n';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
				 error='yes';
			}
			if(frm.chaque_no.value=="")
		 	{
				 disp_error +='Enter Chaque No.  \n';
				 document.getElementById('chaque_no').style.border = '1px solid #f00';
				 frm.chaque_no.focus();
				 error='yes';
			}
			if(frm.cheque_date.value=="")
		 	{
				 disp_error +='Enter Chaque Date  \n';
				 document.getElementById('cheque_date').style.border = '1px solid #f00';
				 frm.cheque_date.focus();
				 error='yes';
			}
		}
		else if(frm.payment_mode.value=="paytm-3")
		{
			if(frm.bank_name.value=="select")
		 	{
				 disp_error +='Select Bank name  \n';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
				 error='yes';
			}
			
		}
		else if(frm.payment_mode.value=="Credit Card-4")
		{
			if(frm.bank_name.value=="select")
		 	{
				 disp_error +='Select Bank name  \n';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
				 error='yes';
			}
			if(frm.credit_card_no.value=="")
		 	{
				 disp_error +='Enter Credit Card No.  \n';
				 document.getElementById('credit_card_no').style.border = '1px solid #f00';
				 frm.credit_card_no.focus();
				 error='yes';
			}
			
		}
		else if(frm.payment_mode.value=="online-5")
		{
			if(frm.bank_name.value=="")
		 	{
				 disp_error +='Select Bank name  \n';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
				 error='yes';
			}
			if(frm.ref_no_bank.value=="")
		 	{
				 disp_error +='Enter Ref No.  \n';
				 document.getElementById('ref_no_bank').style.border = '1px solid #f00';
				 frm.ref_no_bank.focus();
				 error='yes';
			}
			if(frm.cust_bank_name.value=="")
		 	{
				 disp_error +='Enter customer bank name  \n';
				 document.getElementById('cust_bank_name').style.border = '1px solid #f00';
				 frm.cust_bank_name.focus();
				 error='yes';
			}
		}
	}
	contact='0';
	var total_service= document.getElementsByName("total_services[]");
	totals=total_service.length;
	for(i=1; i<=totals;i++)
	{
		staff_ids=Number(document.getElementById("staff_id"+i).value);
		if(staff_ids=='')
		{
			disp_error +='Select Staff name of service no. '+i+' \n';
			document.getElementById('staff_id'+i+'').style.border = '1px solid #f00';
			//frm.staff_names.focus();
			error='yes';
		}
	}
	if(error=='yes')
	{
		alert(disp_error);
		return false;
	}
	else
	{
		$('.new_custom_course').dialog( 'close');
        return send();
	}
    return true;
 }
/*
function isNumber(evt) 

	{

    	evt = (evt) ? evt : window.event;

    	var charCode = (evt.which) ? evt.which : evt.keyCode;

    	if (charCode > 31 && (charCode < 48 || charCode > 57)) {

        return false;

    }

    return true;

}*/
function searchSel(value) 
{
	//alert(value);
	var data1="action=service&mobile_no="+value;	
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
			setTimeout(getMembership(sep[0].trim()),500);
		}
	}
	});
} 
function show_mobile_no(value,id)
{
	//alert(value);
	if(id=="Customer")
	{
		var data1="action=get_cust_mobileno&cust_id="+value;	
		//alert(data1);
		$.ajax({
		url: "get_name.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(html.trim()!='')
			{
				//alert(html);
				document.getElementById("mobiles").innerHTML=html;
				setTimeout(getMembership(value),500);
				$("#realtxt").chosen({allow_single_deselect:true});
				return true;
			}
			
		}
		});
	}
	else
	{
		setTimeout(getMembership(value),500);
	}
}
/*function add_package(value)
{
	var data1="action=show_package&package_id="+value;	
	//alert(data1);
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		sep= html.split("###");
		if(sep[0]!='' || sep[0]!='###')
		{
			document.getElementById("package_details").innerHTML=sep[0];
		}
		var prie= document.getElementById("package_price").value;
		var service_price=document.getElementById("total_cost").value
		var total_amount=Number(sep[1])+Number(service_price);
		document.getElementById("amount").value=total_amount;
	}
	});
}*/

function isPastDate(value) 
{
	var now = new Date;
	var target = new Date(value);
	var new_date=value.split("/");
	
	if (new_date[2] < now.getFullYear()) {
		
		return true;
	} else if (new_date[1] < now.getMonth()) {
		
		return true;
	} else if (new_date[0] < now.getDate()) {
		
		return true;
	}

	return false;
}
function isFeatureDate(value) 
{
	var now = new Date;
	var target = new Date(value);
	var new_date=value.split("/");
	
	if (new_date[2] > now.getFullYear()) {
		return true;
	} else if (new_date[1] > now.getMonth()) {
		return true;
	} else if (new_date[0]  >= now.getDate()) {
		return true;
	}

	return false;
}	
function delete_tax(id,tax_types)
{
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
			showUser();
			calculte_total_cost();
			calculte_amount_tax(id);
		}
	}
}
function delete_voucher(id)
{
	//alert(id);
	show_voucher_details("",id,"");
	setTimeout(create_type1('delete_type1'),500);
}
</script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>

<!-- demo stylesheet //22-12-17-->
<link type="text/css" rel="stylesheet" href="EventCalendar/helpers/demo9a45.css?v=3091" />
<link type="text/css" rel="stylesheet" href="EventCalendar/helpers/media/layout9a45.css?v=3091" />
<link type="text/css" rel="stylesheet" href="EventCalendar/helpers/media/elements9a45.css?v=3091" />

<!-- helper libraries //22-12-17-->
<script src="EventCalendar/helpers/jquery-1.12.2.min.js" type="text/javascript"></script>

<!-- daypilot libraries //22-12-17-->
<script src="EventCalendar/js/daypilot-all.min9a45.js?v=3091" type="text/javascript"></script>
<!-- /Event -->
<style>
.input_select {
    width: 60% !important;
}
.input_text {
    width: 60% !important;
}
.input_textarea {
    width: 60% !important;
}
.scheduler_default_corner {  background-color:#c0c0c0; z-index:-1; position:relative; }
</style>
<script>
	$.noConflict();
	</script>
    
    <script>
	function submit_form()
	{
		$( ".new_custom_course" ).dialog({
                                        width: '100%',
                                        height:'1400'
                                    });
									
		setTimeout(auto_search,1000)
		$(".chosen-container-single").css("width", "161px");
	}
	function auto_search()
	{
		$("#customer_id").chosen({allow_single_deselect:true});
		$("#service_id1").chosen({allow_single_deselect:true});
		$("#employee_id").chosen({allow_single_deselect:true});
		$("#realtxt").chosen({allow_single_deselect:true});
	}
	</script>
    
    
</head>
<body>
<?php
//echo $_SESSION['where'];
$staff_prev=$_SESSION['staff_prev']; 
$prev_value="";
for($e=0;$e<count($staff_prev);$e++)
{
	if($staff_prev[$e]==112) 
	{
		$prev_value="and privilege_id='112'";
	}
}
//echo "<br/>".$sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$_SESSION['where']." ".$prev_value."";
?>
<?php include "include/header.php";?>
<div id="info">
<!--left start-->
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
    
    <table width="100%" cellspacing="0" cellpadding="0">   
           

<?php
if(isset($_POST['import_excel']))
{
}                   

?>
<tr><td>
 <form method="get" id="jqueryForm1" name="jqueryForm1" enctype="multipart/form-data" action="add_cust_services.php" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            
            <tr>
            <div class="main">
			<td colspan="3">
                <div class="main1" style="float:left; width: 160px;">
                    <div id="nav1" ></div>
                </div>
			</td>
			</tr>
			<tr>
			<td colspan="3">			
                <div style="margin-left: 0px;">
                    <!--<div class="space">
                        Theme: <select id="theme">
                            <option value="calendar_default">Default</option>
                            <option value="calendar_white">White</option>                        
                            <option value="calendar_g">Google-Like</option>                        
                            <option value="calendar_green">Green</option>                        
                            <option value="calendar_traditional">Traditional</option>                        
                            <option value="calendar_transparent">Transparent</option>                        
                        </select>
                    </div>-->
                    <div id="dp"></div>
                </div>
		          <style>
				  .current{
					 border: 1px solid green;
				  }
				  </style>

                <script type="text/javascript">
				$(document).ready(function(){
				$('.navigator_default_day').click(function () {
				   $('.navigator_default_day').removeClass('current');
				   $('.navigator_default_cell_box').removeClass('navigator_default_todaybox');
				   
					$(this).removeClass('navigator_default_todaybox').addClass('current');
				//var divname= this.name;
				//$("#"+divname).show("fast").siblings().hide("fast");
				});
				}); 
				var nav = new DayPilot.Navigator("nav1");
				nav.showMonths = 1;
				nav.skipMonths = 3;
				nav.selectMode = "week";
				// $("#nav1").css("background-color","red");
				 
				nav.onTimeRangeSelected = function(args) {
					dp.startDate = args.day;
						
					//$( "this.navigator_default_todaybox" ).parent().css( "background-color", "blue" );
					dp.update();
					loadEvents();
                };
                nav.init();
				
				var dp = new DayPilot.Scheduler("dp");

				dp.startDate = "<?php echo date('Y-m-d') ?>";  // or just dp.startDate = "2013-03-25";
				// dp.days = 31;
				// dp.scale = "Hour";
				/*dp.timeHeaders = [
					{ groupBy: "Month", format: "MMM yyyy" },
					{ groupBy: "Day", format: "ddd d" },
					{ groupBy: "Hour"}
				];*/
				dp.cellGroupBy = "Hour";
				dp.cellDuration = 15;
				
				dp.bubble = new DayPilot.Bubble({
					onLoad: function(args) {
						var ev = args.source;
						//args.html = "testing bubble for: " + ev.text();
					}
				});
				dp.bubble = new DayPilot.Bubble();


				dp.contextMenu = new DayPilot.Menu({items: [
						//{text:"Show event ID", onclick: function() {alert("Event value: " + this.source.value());} },
						//{text:"Show Customer Name", onclick: function() {alert("Name : " + this.source.text());} },
						//{text:"Show Scheduled time", onclick: function() {alert("Event Start : " + this.source.start().toStringSortable() + "\nEvent End : " + this.source.end().toStringSortable());} }, 
						//{text:"Job Card", href: "job-card-generate.php?record_id={0}", target:"_blank"},
						
						{text:"Job Card", onclick: function() {window.open('job-card-generate.php?record_id='+this.source.id() +'','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=300, height=600,directories=no,location=no')}, target:"_blank"},
						{text:"Edit Service",onclick: function() {window.open('add_cust_services_gst.php?record_id='+this.source.id() +'','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1200, height=800,directories=no,location=no')}, target:"_blank"},
						{text:"Add Payment",onclick: function() {window.open('add_cust_service_payment.php?record_id='+this.source.id() +'','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1200, height=800,directories=no,location=no')}, target:"_blank"},
						//{text:"CallBack: Delete this event", command: "delete"} ,
							//{text:"Customer Info", items: [
							
									//{text:"Show event ID", onclick: function() {alert("Event value: " + this.source.value());} },
									//{text:"Show event text", onclick: function() {alert("Event text: " + this.source.text());} }
								//]
							//}
					]});

				dp.treeEnabled = true;
				//dp.rowHeaderWidth = 200;
				dp.resources = [
					<?php
					$sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$_SESSION['where']." ".$prev_value."";
					$ptr_id=mysql_query($sel_prev_id);
					if(mysql_num_rows($ptr_id))
					{
						while($data_prev_id=mysql_fetch_array($ptr_id))
						{
							$sel_staff = "select admin_id,name from site_setting where 1 and admin_id='".$data_prev_id['admin_id']."' ".$_SESSION['where']." and system_status='Enabled' order by admin_id asc";	
							$query_staff = mysql_query($sel_staff);
							if(mysql_num_rows($query_staff))
							{
								$data=mysql_fetch_array($query_staff);
								//echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
								echo '{name : "'.$data['name'].'", id:"'.$data['admin_id'].'"},';
								$i++;
							}
							
						}
					}
					?>
								 
					/* { name : "Room A.1", id : "A.1" },
					 { name: "Room B", id: "B" },
					 { name: "Room C", id: "C" },
					 { name: "Room D", id: "D" },
					 { name: "Room E", id: "E" },
					 { name: "Room F", id: "F" },
					 { name: "Room G", id: "G" },
					 { name: "Room H", id: "H" },
					 { name: "Room I", id: "I" },
					 { name: "Room J", id: "J" },
					 { name: "Room K", id: "K" }*/
					];

				/*var e = new DayPilot.Event({
					start: new DayPilot.Date("2015-01-01T00:00:00"),
					end: new DayPilot.Date("2015-01-02T00:00:00"),
					id: DayPilot.guid(),
					resource: "B",
					text: "First Event"
				});
				dp.events.add(e);

				var e = new DayPilot.Event({
					start: new DayPilot.Date("2015-01-02T00:00:00"),
					end: new DayPilot.Date("2015-01-02T09:00:00"),
					id: DayPilot.guid(),
					resource: "A",
					text: "Second Event"
				});
				dp.events.add(e);

				var e = new DayPilot.Event({
					start: new DayPilot.Date("2015-01-02T09:00:00"),
					end: new DayPilot.Date("2015-01-02T10:00:00"),
					id: DayPilot.guid(),
					resource: "A",
					text: "Third Event"
				});
				dp.events.add(e);*/
				for (var i = 0; i < 1; i++) {
						var duration = Math.floor(Math.random() * 6) + 1; // 1 to 6
						var start = Math.floor(Math.random() * 6) - 3; // -3 to 3
				
						/*var e = new DayPilot.Event({
							start: new DayPilot.Date("2013-03-25T00:00:00").addHours(start),
							end: new DayPilot.Date("2013-03-25T12:00:00").addHours(start).addHours(duration),
							id: DayPilot.guid(),
							resource: "B",
							text: "Event"
						});
						dp.events.add(e);*/
					}
				dp.eventDeleteHandling = "Update";
					
				dp.onEventDelete = function(args) 
				{
					if (!confirm("Do you really want to delete this event?") )
					{
					  args.preventDefault();
					}
				 };
				 
				dp.onEventDeleted = function(args) 
				{
					$.post("EventCalendar/backend_delete.php", 
					{
						id: args.e.id(),
						//newStart: args.newStart.toString(),
						//newEnd: args.newEnd.toString(),
						//newResource: args.newResource.toString()
					}, 
					function(resp) {
						console.log("Deleted." + args.e.text());
						
					});
					
				 };
				dp.eventHoverHandling = "Bubble";
				dp.onEventMoved = function (args) {
					$.post("EventCalendar/backend_move.php", 
					{
						id: args.e.id(),
						newStart: args.newStart.toString(),
						newEnd: args.newEnd.toString(),
						newResource: args.newResource.toString()
					}, 
					function(resp) {
						console.log(resp);
						console.log("Moved." + args.e.text());
					});
					dp.message("Moved: " + args.e.text());
				};
			
				// event resizing
				dp.onEventResized = function (args) {
					$.post("EventCalendar/backend_resize.php", 
					{
						id: args.e.id(),
						newStart: args.newStart.toString(),
						newEnd: args.newEnd.toString(),
						//newResource: args.newResource.toString()
					}, 
					function(res) {
						console.log(res);
						console.log("Resized.");
					});
					dp.message("Resized: " + args.e.text());
				};
				 
				dp.onTimeRangeSelected = function (args) {
						
						var name ="Event";
						dp.clearSelection();
						if (!name) return;
						var e = new DayPilot.Event({
							start: args.start,
							end: args.end,
							id: DayPilot.guid(),
							resource: args.resource,
							text: name
						});
						dp.events.add(e);
						document.getElementById("start").value=args.start;
						document.getElementById("last_start").value=args.start;
						document.getElementById("end").value=args.end;
						document.getElementById("resource").value=args.resource;
						
						document.getElementById("start_gst").value=args.start;
						document.getElementById("end_gst").value=args.end;
						document.getElementById("resource_gst").value=args.resource;
						dp.message("Created");
						 if(name !='')
						{
							submit_form();
                         //window.location = 'add_cust_services.php?start='+args.start+'&end='+args.end+'&resource='+args.resource;					
						
						} 
						//alert(document.location.href("add_cust_services.php"));
					};
					
					dp.onEventClicked = function(args) {
						var new_dates=args.e.start() +'';
						var date_time=new_dates.split("T");
						var new_dte=date_time[0].split("-")
						var start_dates=new_dte[2]+"/"+new_dte[1]+"/"+new_dte[0]+"  "+date_time[1];
						
						var new_enddates=args.e.end() +'';
						var date_timeend=new_enddates.split("T");
						var new_enddte=date_timeend[0].split("-")
						var end_dates=new_enddte[2]+"/"+new_enddte[1]+"/"+new_enddte[0]+"  "+date_timeend[1];
						
						var ser=args.e.bubbleHtml();
						//alert(args.e.bubbleHtml());
						sep=ser.split('<br/>');
						services="\n"; 
						for(var i=0; i< sep.length;i++)
						{
							
							services +=sep[i]+"\n";
							
						}
						alert("Name: " + args.e.text() + "\nStart: " + start_dates+ "\nEnd: " + end_dates+ '\n\nServices: ' + services);
					};
					
					dp.onTimeHeaderClick = function(args) {
						alert("clicked: " + args.header.start);
					}; 
				 //==================================
					dp.bubble = new DayPilot.Bubble({
						cssOnly: true,
						cssClassPrefix: "bubble_default",
						onLoad: function(args) {
						  var ev = args.source;
						  args.async = true;  // notify manually using .loaded()
								
						  // simulating slow server-side load
						  setTimeout(function() {
							args.html = "Services: <br>" + ev.bubbleHtml();
							args.loaded();
						  }, 200);
						}
					});
					dp.snapToGrid = false;
					dp.useEventBoxes = "Never";
				
					dp.onEventMoving = function(args) {
						var offset = args.start.getMinutes() % 5;
						if (offset) {
							args.start = args.start.addMinutes(-offset);
							args.end = args.end.addMinutes(-offset);
						}
				
						args.left.enabled = true;
						args.left.html = args.start.toString("h:mm tt");
					};
					//dp.init();
					
					
    
                    function loadEvents() {
                        var start = dp.visibleStart();
                        var end = dp.visibleEnd();
    
                        $.post("EventCalendar/backend_events.php", 
                        {
                            start: start.toString(),
                            end: end.toString()
                        }, 
                        function(data) {
							//alert("Data- "+data);
                            //console.log(data[0]);
                            dp.events.list = data;
                            dp.update();
                        });
                    }
					/*var e = new DayPilot.Event({
					start: new DayPilot.Date("2018-10-24T09:00:00"),
					end: new DayPilot.Date("2018-10-24T10:00:00"),
					id: DayPilot.guid(),
					resource: "114",
					text: "First Event"
					});
					dp.events.add(e);
	
					var e = new DayPilot.Event({
						start: new DayPilot.Date("2018-10-24T11:00:00"),
						end: new DayPilot.Date("2018-10-24T12:00:00"),
						id: DayPilot.guid(),
						resource: "114",
						text: "Second Event"
					});
					dp.events.add(e);
	
					var e = new DayPilot.Event({
						start: new DayPilot.Date("2018-10-24T09:00:00"),
						end: new DayPilot.Date("2018-10-24T10:00:00"),
						id: DayPilot.guid(),
						resource: "93",
						text: "Third Event"
					});
					dp.events.add(e);*/
					//==============================
					dp.dynamicEventRenderingCacheSweeping = true;

					dp.eventHoverHandling = "Bubble";

					dp.eventMovingStartEndEnabled = true;
					dp.eventResizingStartEndEnabled = true;
					dp.timeRangeSelectingStartEndEnabled = true;

					/*dp.onBeforeEventRender = function(args) {
						args.e.bubbleHtml = "<div><b>" + args.e.text + "</b></div><div>Start: " + new DayPilot.Date(args.e.start).toString("M/d/yyyy") + "</div><div>End: " + new DayPilot.Date(args.e.end).toString("M/d/yyyy") + "</div>";
					};*/

					dp.onBeforeResHeaderRender = function(args) {
					};

					dp.onBeforeRowHeaderRender = function(args) {
					};

					dp.onBeforeCellRender = function(args) {
					};

					
					dp.showNonBusiness = false;
					dp.businessBeginsHour = 9;
					dp.businessEndsHour = 21;
					dp.businessWeekends = true;
				   // dp.showNonBusiness = false;

					dp.debug.printToBrowserConsole = true;

					dp.init();
					
					loadEvents();
					//dp.scrollTo("2014-03-25");

			</script>
				
             </td>
             </tr>
             <!--<tr>
                  
                  <td colspan="3" align="center"><input type="submit" class="input_btn" onClick="return submit_form()" value="Book Service" name="save_changes"  /></td>
                  <td></td>
            </tr>-->
          </table>
         </form>
         
        <?php
        if($_POST['post_data'])
		{
			$sac_code=($_POST['sac_code']) ? $_POST['sac_code'] : "";
			//$branch_name=$_POST['branch_name'];
			$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
			//$customer_id=$_POST['customer_id'];
			$customer_id=( ($_POST['customer_id'])) ? $_POST['customer_id'] : "0";
			//$service_price=$_POST['service_price'];  
			$service_price=( ($_POST['service_price'])) ? $_POST['service_price'] : "";
			//$discount_price=$_POST['discount_price'];    
			$discount_price=( ($_POST['discount_price'])) ? $_POST['discount_price'] : "";
			//$service_tax=$_POST['service_tax']; 
			$service_tax=( ($_POST['service_tax'])) ? $_POST['service_tax'] : "";
			$show_gst=( ($_POST['show_gst'])) ? $_POST['show_gst'] : "";
			
			if($_SESSION['tax_type']=='GST')
			{
				$apply_gst=( ($_POST['apply_gst'])) ? $_POST['apply_gst'] : "";
			}
			else
			{
				$apply_gst=( ($_POST['apply_vat'])) ? $_POST['apply_vat'] : "";
			}
			$gst_type=( ($_POST['gst_type'])) ? $_POST['gst_type'] : "";
			//$cgst_tax= $_POST['cgst_tax'];
			$cgst_tax=( ($_POST['cgst_tax'])) ? $_POST['cgst_tax'] : "";
			//$cgst_tax_in_per= $_POST['cgst_taxes'];
			$cgst_tax_in_per=( ($_POST['cgst_taxes'])) ? $_POST['cgst_taxes'] : "";
			//$sgst_tax= $_POST['sgst_tax'];
			$sgst_tax=( ($_POST['sgst_tax'])) ? $_POST['sgst_tax'] : "";
			//$sgst_tax_in_per= $_POST['sgst_taxes'];
			$sgst_tax_in_per=( ($_POST['sgst_taxes'])) ? $_POST['sgst_taxes'] : "";
			$igst_tax=( ($_POST['igst_tax'])) ? $_POST['igst_tax'] : "";
			//$sgst_tax_in_per= $_POST['sgst_taxes'];
			$igst_tax_in_per=( ($_POST['igst_taxes'])) ? $_POST['igst_taxes'] : "";
			$service_taxes=( ($_POST['service_taxes'])) ? $_POST['service_taxes'] : "";
			
			$excluded_tax=( ($_POST['excluded_tax'])) ? $_POST['excluded_tax'] : "0";
			//$total_cost=$_POST['total_cost']; 
			$total_cost=( ($_POST['total_cost'])) ? $_POST['total_cost'] : "";
			//$employee_id=$_POST['employee_id'];
			$employee_id=( ($_POST['employee_id'])) ? $_POST['employee_id'] : "0";
			//$service=$_POST['requirment_id'];
			$service=( ($_POST['requirment_id'])) ? $_POST['requirment_id'] : "";
			//$date=trim($_POST['date']);
			//$start_time=trim($_POST['start_time']);
			$start_time=( ($_POST['start_time'])) ? $_POST['start_time'] : "";
			///$end_time=trim($_POST['end_time']);
			$end_time=( ($_POST['end_time'])) ? $_POST['end_time'] : "";
			$total_service_time=( ($_POST['total_service_time'])) ? $_POST['total_service_time'] : "";
			$cust_bank_name='';
			$bank_name='';
			$chaque_no='';
			$chaque_date='';
			$credit_card_no='';
			$isas_paytm_no='';
			$cust_paytm_no='';
			$payment_mode=$_POST['payment_mode'];
			$sep=explode("-",$payment_mode);
			$payment_mode_id=$sep[1];
			$payment_mode_id=( ($payment_mode_id)) ? $payment_mode_id : "0";
			
			$payment_type_val=$sep[0];
			$payment_type_val=( ($payment_type_val)) ? $payment_type_val : "";
			$amount=( ($_POST['amount'])) ? $_POST['amount'] : "";
			
			$start=( ($_POST['start'])) ? $_POST['start'] : "";
			$end=( ($_POST['end'])) ? $_POST['end'] : "";
			$resource=( ($_POST['resource'])) ? $_POST['resource'] : "0";
			$voucher_deal_id=( ($_POST['voucher_deal_id'])) ? $_POST['voucher_deal_id'] : "0";;
			$categories='';
			$category=( ($_POST['category'])) ? $_POST['category'] : "";
			$packagess_deal_id='0';
			if($category=="Package")
			{
				$packagess_deal_id=$_POST['packagess_deal_id'];
			}
			$redeme_points='';
			$redemptoin_value='';
			if($category=="loyalty_point")
			{
				$redeme_points=$_POST['redeme_points'];
				$redemptoin_value=$_POST['redemptoin_value'];
			}
			
			/*if($category =="Voucher")
			{
				$voucher_number=$_POST['voucher_number'];
				$voucher_deal_id=$_POST['voucher_deal_id'];
				$categories=$_POST['categories'];
			}*/
			$followup_date=$_POST['followup_date'];
			if($followup_date !='' )
			{
				$sep_date = explode('/',$followup_date);
				$followup_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
			}
			else
				$followup_date='';
			$treatment_followup_date=$_POST['treatment_followup_date'];
			if($treatment_followup_date !='' )
			{
				$treat_sep_date = explode('/',$treatment_followup_date);
				$treatment_followup_date = $treat_sep_date[2].'-'.$treat_sep_date[1].'-'.$treat_sep_date[0];
			}
			else
				$treatment_followup_date ='';
			$followup_desc=( ($_POST['followup_desc'])) ? $_POST['followup_desc'] : "";
			
			$payable_amount=( ($_POST['payable_amount'])) ? $_POST['payable_amount'] : "0";
			
			$remaining_amount=( ($_POST['remaining_amount'])) ? $_POST['remaining_amount'] : "0";
			///$disc_type=$_POST['discount'];
			$disc_type=( ($_POST['discount'])) ? $_POST['discount'] : "";
			//$nonmemb_discount_type=$_POST['nonmemb_discount_type'];
			$nonmemb_discount_type=( ($_POST['nonmemb_discount_type'])) ? $_POST['nonmemb_discount_type'] : "";
			//$nonmemb_discount=$_POST['nonmemb_discount'];
			$nonmemb_discount=( ($_POST['nonmemb_discount'])) ? $_POST['nonmemb_discount'] : "";
			//$nonmemb_discount_price=$_POST['nonmemb_discount_price'];
			$nonmemb_discount_price=( ($_POST['nonmemb_discount_price'])) ? $_POST['nonmemb_discount_price'] : "";
			$type=( ($_POST['user'])) ? $_POST['user'] : "0";
			if($payment_mode_id !="1" )
			{
				//$bank_name=$_POST['bank_name'];
				$bank_name=( ($_POST['bank_name'])) ? $_POST['bank_name'] : "0";
				$cust_bank_name=( ($_POST['cust_bank_name'])) ? $_POST['cust_bank_name'] : "";
				///$chaque_no=$_POST['chaque_no'];
				$chaque_no=( ($_POST['chaque_no'])) ? $_POST['chaque_no'] : "";
				//$credit_card_no=$_POST['credit_card_no'];
				$credit_card_no=( ($_POST['credit_card_no'])) ? $_POST['credit_card_no'] : "";
				///$chaque_date=$_POST['cheque_date'];
				$chaque_date=( ($_POST['cheque_date'])) ? $_POST['cheque_date'] : "";
				$bank_ref_no=($_POST['bank_ref_no']) ? $_POST['bank_ref_no'] : "";	
			}
			else if($payment_mode_id =="3")
			{
				$isas_paytm_no=($_POST['isas_paytm_no']) ? $_POST['isas_paytm_no'] : "";
				$cust_paytm_no=($_POST['cust_paytm_no']) ? $_POST['cust_paytm_no'] : "";
			}
			$cm_id1='0';
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
				$branch_name1=$_SESSION['branch_name'];
				$data_record['cm_id']=$_SESSION['cm_id'];
				
				$cm_id1=$_SESSION['cm_id'];
			}
			$total_floor=$_POST['floor'];
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
				$data_record['customer_id'] =$customer_id;
				$data_record['service_price'] =$service_price;
				$data_record['discount_price'] =$discount_price;
				$data_record['service_tax'] =$service_tax;
				$data_record['show_gst'] =$show_gst;
				$data_record['apply_gst'] =$apply_gst;
				$data_record['gst_type'] =$gst_type;
				$data_record['cgst_tax']=$cgst_tax;
				$data_record['sgst_tax']=$sgst_tax;
				$data_record['igst_tax']=$igst_tax;
				$data_record['cgst_tax_in_percent']=$cgst_tax_in_per;
				$data_record['sgst_tax_in_percent']=$sgst_tax_in_per;
				$data_record['igst_tax_in_percent']=$igst_tax_in_per;
				$data_record['service_tax_in_percent']=$service_taxes;
				$data_record['excluded_tax']=$excluded_tax;
				
				$data_record['total_cost'] =$total_cost;
				$data_record['staff_id'] =$employee_id;
				$data_record['admin_id'] =$_SESSION['admin_id'];
				$data_record['added_date']=date('Y-m-d H:i:s');
				//$data_record['date'] =$date;
				$data_record['start_time'] =$start_time;
				$data_record['end_time'] =$end_time;
				$data_record['payment_mode_id'] =trim($payment_mode_id);
				$data_record['chaque_no'] =$chaque_no;
				$data_record['chaque_date'] =$chaque_date;
				$data_record['credit_card_no'] =$credit_card_no;
				$data_record['isas_paytm_no'] =$isas_paytm_no;
				$data_record['cust_paytm_no'] =$cust_paytm_no;
				$data_record['bank_id'] =$bank_name;
				$data_record['cust_bank_name'] =$cust_bank_name;
				$data_record['bank_ref_no'] =$bank_ref_no;
				$data_record['amount'] =$amount;
				$total_floor=$_POST['floor'];
				$data_record['discount_type']=$disc_type;
				$data_record['category']=$category;
				$data_record['voucher_deal_id']=$voucher_deal_id;
				$data_record['voucher_number']=$voucher_number;
				$data_record['packagess_deal_id']=$packagess_deal_id;
				$data_record['redeme_points']=$redeme_points;
				$data_record['redemptoin_value']=$redemptoin_value;
				$data_record['payable_amount']=$payable_amount;

				$payble_gst_val=0;
				$payble_igst_val=0;
				$payble_cgst_val=0;
				$payble_sgst_val=0;
				$payble_excluded_amnt=0;
				if($payable_amount>0)
				{
					if($gst_type=='m_gst')
					{
						$payble_cgst_val=$payable_amount * ($cgst_tax_in_per / 100);
						$payble_sgst_val=$payable_amount * ($sgst_tax_in_per / 100);
						$payble_gst_val=round($cgst_val+$sgst_val,2);
					}
					else if($gst_type=='m_igst')
					{
						$payble_gst_val=$payble_igst_val=round($payable_amount * ($igst_tax_in_per / 100),2);
					}
					$payble_excluded_amnt=$payable_amount - $payble_gst_val;
				}
				$data_record['remaining_amount']=$remaining_amount;
				
				$status='';
				$data_record['nonmemb_discount_type']=$nonmemb_discount_type;
				$data_record['nonmemb_discount']=$nonmemb_discount;
				$data_record['nonmemb_discount_price']=$nonmemb_discount_price;
				$data_record['type']=$type;
				$data_record['followup_date']=$followup_date;
				$data_record['treatment_followup_date']=$treatment_followup_date;
				$data_record['followup_desc']=$followup_desc;
				
				$start=trim(str_replace("T"," ",$start));
				$end=trim(str_replace("T"," ",$end));
				
				$payble_amnt=trim($data_record['payable_amount']);
				//echo "Hi hello <br/>".$payment_mode_id."   ".$payble_amnt;
				if($payment_mode_id =='0' && $payble_amnt =='0')
				{
					$status="Booked";
				}
				else if(($payment_mode_id >'0') && ($payble_amnt =='0' || $payble_amnt =='0'))
				{
					$status="Booked";
				}
				else if(($payment_mode_id =='0' || $payment_mode_id =='0' ) && ($payble_amnt >'0'))
				{
					$status="Booked";
				}
				else if($payment_mode_id >'0' && $payble_amnt >'0' )
				{
					$status="Completed";
				}
				$data_record['status'] =$status;
				if($record_id)
				{
					/* $where_record=" customer_service_id='".$record_id."'";
					$db->query_update("customer_service", $data_record,$where_record);
					
					$update_cust_invoice="update customer_service_invoice set `service_price`='".$service_price."',`total_cost`='".$total_cost."',`amount`='".$amount."',`payable_amount`= '".$payable_amount."',`remaining_amount`='".$remaining_amount."',`total_paid`='".$payable_amount."',`paid_type`='".$payment_mode_id."',`bank_id`='".$bank_name."',`cust_bank_name`='".$cust_bank_name."', `cheque_detail`='".$chaque_no."', `chaque_date`='".$sep_check_date."', `credit_card_no`='".$credit_card_no."', `admin_id`='".$_SESSION['admin_id']."', `added_date`='".date('Y-m-d H:i:s')."',`cm_id`='".$cm_id1."'  where customer_service_id='".$record_id."' order by invoice_id asc ";
					$ptr_update=mysql_query($update_cust_invoice);
					
					if($payment_mode_id =="6")
					{
						$where_record1="cust_id='".$customer_id."' and voucher_id='".$voucher_deal_id."'";
						$db1->query_update("sales_package_voucher_memb", $data_record_sales,$where_record1);
					}
					for($z=1;$z<=$total_floor;$z++)
					{
						"Floor- ". $_POST['del_floor'.$z]."<br />";
						"<br />floor_id- ".$_POST['floor_id'.$z];
						if($_POST['del_floor'.$z]=='yes')
						{
							
							if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
							{
								"<br />".$delete_row = " delete from customer_service_map where customer_service_map_id='".$_POST['floor_id'.$z]."' ";
								$ptr_delete = mysql_query($delete_row);
							}
						}
						if($_POST['del_floor'.$z] !='yes')
						{
							$data_record_service['customer_service_id'] =$record_id; 
							$data_record_service['customer_id'] =$customer_id; 
							$data_record_service['service_id'] =$_POST['service_id'.$z];
							$data_record_service['service_price'] =$_POST['sin_service_price'.$z];
							$data_record_service['discount'] =$_POST['sin_service_disc'.$z];
							$data_record_service['discount_price'] =$_POST['sin_service_disc_price'.$z];
							$data_record_service['total_price'] =$_POST['sin_service_total'.$z];
							$data_record_service['service_time'] =$_POST['sin_service_time'.$z];
							$data_record_service['admin_id'] =$_POST['staff_id'.$z];
							
							if($_POST['floor_id'.$z]=='' && $_POST['service_id'.$z] !='')
							{
								 $type1_id=$db->query_insert("customer_service_map", $data_record_service);
							}
							else
							{
								$where_record="customer_service_map_id='".$_POST['floor_id'.$z]."'";
								$floor_id= $_POST['floor_id'.$z];
								$db->query_update("customer_service_map", $data_record_service,$where_record);
							}
							unset($data_record_service);
					   }
					}
					"<br>".$sql_query= "SELECT cust_name FROM customer where cust_id ='".$record_id."' ";              
					$query=mysql_query($sql_query);
					$fetch=mysql_fetch_array($query);
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_customer_service','Edit','".$fetch['cust_name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert); */
			
					// echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
					?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record updated successfully</p></center></div>
							<script type="text/javascript">
								$(document).ready(function() {
									$( "#statusChangesDiv" ).dialog({
											modal: true,
											buttons: {
														Ok: function() { $( this ).dialog( "close" );}
													 }
									});
									
								});
							  // setTimeout('document.location.href="manage_cust_services.php";',500);
							</script>
					<?php
				}
				else
				{
					$data_record['customer_invoice_no']='0';
					$sele_invoice_no=" select customer_invoice_no from customer_service where 1 and customer_invoice_no!='' order by customer_service_id desc limit 0,1";
					$ptr_sel_invoice_no=mysql_query($sele_invoice_no);
					if(mysql_num_rows($ptr_sel_invoice_no))
					{
						$data_invoice_no=mysql_fetch_array($ptr_sel_invoice_no);
						$data_record['customer_invoice_no'] =$data_invoice_no['customer_invoice_no']+1;
					}
					else 
					{
						$data_record['customer_invoice_no'] ="1001";
					}
					
					$end = date('Y-m-d H:i:s',strtotime('+'.$total_service_time.' minutes',strtotime($start)));
				
					$data_record['start_event_time'] =$start;
					$data_record['end_event_time'] =$end;
					$data_record['staff_id_event'] =$resource;
					
					//==============Update Invoice No.=====================
					$sel_inv="select ext_invoice_no from customer_service where cm_id='".$data_record['cm_id']."' and ext_invoice_no IS NOT NULL order by ext_invoice_no desc limit 0,1";
					$ptr_inv=mysql_query($sel_inv);
					$data_inv=mysql_fetch_array($ptr_inv);
					
					$recp=explode("/",$data_inv['ext_invoice_no']);
					$inv_no=intval($recp[2])+1;
					$preinv=$recp[0].'/'.$recp[1].'/';
					$data_record['ext_invoice_no']=$preinv.$inv_no;
					//======================================================
					
					$record_id=$db->query_insert("customer_service", $data_record);
					for($i=1;$i<=$total_floor;$i++)
					{
						if($_POST['service_id'.$i] !='')
						{
							$start_t=trim(str_replace("T"," ",$_POST['from_time'.$i]));
							$end_t=trim(str_replace("T"," ",$_POST['to_time'.$i]));
							$data_record_service['customer_service_id'] =$record_id; 
							$data_record_service['customer_id'] =$customer_id; 
							$data_record_service['service_id'] =$_POST['service_id'.$i];
							$data_record_service['service_price'] =$_POST['sin_service_price'.$i];
							$data_record_service['service_quantity'] =$_POST['sin_service_qty'.$i];
							$data_record_service['service_quantity_price'] =$_POST['sin_total'.$i];
							$data_record_service['discount'] =$_POST['sin_service_disc'.$i];
							$data_record_service['discount_price'] =$_POST['sin_service_disc_price'.$i];
							$data_record_service['total_price'] =$_POST['sin_service_total'.$i];
							$data_record_service['service_time'] =$_POST['sin_service_time'.$i];
							$data_record_service['start_event_time'] =$start_t;
							$data_record_service['end_event_time'] =$end_t;
							$data_record_service['admin_id'] =$_POST['staff_id'.$i];
							$data_record_service['added_date'] =date('Y-m-d H:i:s');
							$customer_service_id=$db->query_insert("customer_service_map", $data_record_service);
						}
					}
					/*if($payment_type_val=="online")
					$status='pending';
					else*/
					$status='paid';
					$chaque_date_exp=explode('/', $chaque_date);
					$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
					
					$sel_recpt="select receipt_no from customer_service_invoice where cm_id='".$cm_id1."' and receipt_no IS NOT NULL order by invoice_id desc limit 0,1";
					$ptr_recpt=mysql_query($sel_recpt);
					$data_receipt=mysql_fetch_array($ptr_recpt);
					$recp=explode("-",$data_receipt['receipt_no']);
					$recpt_no=intval($recp[1])+1;
					$pre=$recp[0].'-';
					$receipt_no=$pre.$recpt_no;
					
					"<br/>".$insert_cust_service_invoice = " INSERT INTO `customer_service_invoice` (`customer_service_id`,`receipt_no`, `service_price`, `total_cost`, `amount`, `payable_amount`,`excluded_tax_amount`,`apply_gst`,`show_gst`,`gst_type`,`cgst_tax`,`sgst_tax`,`igst_tax`,`cgst_tax_in_percent`,`sgst_tax_in_percent`,`igst_tax_in_percent`,`remaining_amount`, `total_paid`,`paid_type`, `bank_id`, `bank_ref_no`,`cust_bank_name`,`cheque_detail`, `chaque_date`, `credit_card_no`,`isas_paytm_no`,`cust_paytm_no`, `admin_id`, `added_date`,`status`,`cm_id`) VALUES ('".$record_id."','".$receipt_no."', '".$service_price."', '".$total_cost."', '".$amount."', '".$payable_amount."','".$payble_excluded_amnt."','".$apply_gst."','".$show_gst."','". $gst_type."','".$payble_cgst_val."','".$payble_sgst_val."','".$payble_igst_val."','".$cgst_tax_in_per."','".$sgst_tax_in_per."','".$igst_tax_in_per."','".$remaining_amount."', '".$payable_amount."', '".$payment_mode_id."','".$bank_name."','".$bank_ref_no."','".$cust_bank_name."', '".$chaque_no."', '".$sep_check_date."','".$credit_card_no."','".$isas_paytm_no."','".$cust_paytm_no."', '".$_SESSION['admin_id']."', '".date('Y-m-d H:i:s')."','".$status."','".$cm_id1."'); ";
					$ptr_cust_service_invoice = mysql_query($insert_cust_service_invoice);	
					$ins_id=mysql_insert_id();
					
					if($payment_mode_id=='2' || $payment_mode_id=='4' || $payment_mode_id=='5')
					{
						$bank="INSERT INTO `bank_records`(`bank_id`, `type`, `record_id`, `invoice_id`, `amount`, `added_date`, `cm_id`, `admin_id`) VALUES ('".$bank_name."','service','".$record_id."','".$ins_id."','".$payable_amount."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$bank_query=mysql_query($bank);  
					}
					
					$update_rewards="update customer set rewards_point=(rewards_point-".$redeme_points."), redeme_point=(redeme_point+".$redeme_points.") where cust_id='".$customer_id."' ";
					$ptr_update=mysql_query($update_rewards);
					
					$selct_rpc="SELECT * FROM `reward_point_config` where cm_id='".$cm_id1."'";
					$ptr_rpc=mysql_query($selct_rpc);
					$data_rpc=mysql_fetch_array($ptr_rpc);
					
					$sel_rew="select rewards_point from customer where cust_id='".$customer_id."'";
					$ptr_rew=mysql_query($sel_rew);
					$data_rew=mysql_fetch_array($ptr_rew);
					
					$rpc=intval($payable_amount/$data_rpc['rupees']);
					$total_rp=intval($rpc*$data_rpc['reward_point']);
					$total_rewards_pt=intval($data_rew['rewards_point']+$total_rp);
					
					$update_cust="update customer set rewards_point=".$total_rewards_pt." where cust_id='".$customer_id."'";
					$ptr_reward=mysql_query($update_cust);
					
					"<br/>".$ins_followups="insert into customer_service_followups (`customer_id`,`customer_service_id`,`followup_date`,`treatment_followup_date`,`followup_desc`,`admin_id`,`cm_id`,`added_date`) values('".$customer_id."','".$record_id."','".$followup_date."','".$treatment_followup_date."','".$followup_desc."','".$_SESSION['admin_id']."','".$cm_id1."','".date('Y-m-d H:i:s')."')";
					$ptr_ins=mysql_query($ins_followups);
					
					if($category=="Voucher")
					{
						for($j=1;$j<=$total_type1;$j++)
						{
							$categories =$_POST['categories'.$j];
							$voucher_deal_id=$_POST['voucher_deal_id'.$j];
							$voucher_code_id=$_POST['redeme_code_id'.$j];
							$remaining_amnt_in_voucher =$_POST['remaining_amnt_in_voucher'.$j];
							$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
							
							$data_record_sales['status'] ="inactive";
							$data_record_sales['amount'] =0;
							//$amnt='';
							if($categories=="amount")
							{
								
								if($remaining_amnt_in_voucher > 0)
								{
									$data_record_sales['amount'] =trim($remaining_amnt_in_voucher);
									$data_record_sales['status'] ="active";
									//$amnt=", amount='".$data_record_sales['amount']."'";
								}
							}
							if($categories=="amount")
							{
								if($data_record_sales['amount'] ==0)
								{
								 "<br/>".$update_query="update sales_package_voucher_memb set quantity = (quantity-1) where cust_id='".$customer_id."' and voucher_id='".$voucher_deal_id."'";
								$ptr_qry=mysql_query($update_query);
								}
								
								 "<br/>".$update_vou_code="update voucher_customer_code_map set status ='".$data_record_sales['status']."',redeem_price='".$data_record_sales['amount']."' where voucher_id='".$voucher_deal_id."' and customer_id='".$customer_id."' and voucher_code_id='".$voucher_code_id."'";
								$ptr_update_cose=mysql_query($update_vou_code);
								
								/*$sel_sales_voucher_qty="select voucher_customer_code_map_id from voucher_customer_code_map where customer_id='".$customer_id."' and voucher_id='".$voucher_deal_id."' and status='inactive'";
								$ptr_qty=mysql_query($sel_sales_voucher_qty);
								if(!mysql_num_rows($ptr_qty))
								{
									$update_query="update sales_package_voucher_memb set status='inactive' where cust_id='".$customer_id."' and voucher_id='".$voucher_deal_id."'";
									$ptr_qry=mysql_query($update_query);
								}*/
							}
							//echo "cat- ".$categories;
							if($categories=="service")
							{
								"<br/>".$sel_vsm="select service_id,quantity,voucher_id from voucher_service_map where voucher_id='".$voucher_deal_id."'";
								$ptr_vsm=mysql_query($sel_vsm);
								if($total_vsm=mysql_num_rows($ptr_vsm))
								{
									while($data_vsm=mysql_fetch_array($ptr_vsm))
									{
										"<br/>".$sel_svcsm="select svm_id from sales_customer_service_voucher_map where service_id='".$data_vsm['service_id']."' and voucher_id='".$data_vsm['voucher_id']."' and quantity > 0 ";
										$ptr_svcsm=mysql_query($sel_svcsm);
										if(mysql_num_rows($ptr_svcsm))
										{
											for($i=1;$i<=$total_floor;$i++)
											{
												if($_POST['service_id'.$i]!='')
												{
													if($data_vsm['service_id']==$_POST['service_id'.$i])
													{
														/*"<br/>".$sel_svcsm="select svm_id from sales_customer_service_voucher_map where service_id='".$data_vsm['service_id']."' and voucher_id='".$data_vsm['voucher_id']."' and quantity > 0 ";
														$ptr_svcsm=mysql_query($sel_svcsm);
														if(mysql_num_rows($ptr_svcsm))
														{*/
															 "<br/>".$update_prod_qty="update sales_customer_service_voucher_map set quantity=(quantity -1) where service_id='".$data_vsm['service_id']."' and voucher_id='".$voucher_deal_id."' and voucher_code_id ='".$voucher_code_id."'";
															$query_prod_qty=mysql_query($update_prod_qty);
														//}
													}
												}
											}
										}
									}
								}
								"<br/>". $sel_vsm1="select svm_id from sales_customer_service_voucher_map where voucher_id='".$voucher_deal_id."' and customer_id='".$customer_id."' and voucher_code_id ='".$voucher_code_id."' and quantity > 0";
								$ptr_vsm1=mysql_query($sel_vsm1);
								"<br/>". $total=mysql_num_rows($ptr_vsm1);
								if($total <= 0)
								{
									"<br/>".$update_query="update sales_package_voucher_memb set quantity=(quantity -1) where cust_id='".$customer_id."' and voucher_id='".$voucher_deal_id."'";
									$ptr_qry=mysql_query($update_query);
									"<br/>".$update_vou_code="update voucher_customer_code_map set status ='inactive' where voucher_id='".$voucher_deal_id."' and customer_id='".$customer_id."' and voucher_code_id='".$voucher_code_id."'";
									$ptr_code=mysql_query($update_vou_code);
									$sel_spcvs="select id from sales_package_voucher_memb where cust_id='".$customer_id."' and voucher_id='".$voucher_deal_id."' and quantity <= 0";
									$ptr_spcvs=mysql_query($sel_spcvs);
									if(mysql_num_rows($ptr_spcvs))
									{
										"<br/>".$update_query="update sales_package_voucher_memb set status='inactive' where cust_id='".$customer_id."' and voucher_id='".$voucher_deal_id."'";
										$ptr_qry=mysql_query($update_query);
									}
								}
							}
						}
					}
					else if($category=="Package")
					{
						"<br/>".$sel_pvsm="select service_id,quantity,package_id from package_service_map where package_id='".$packagess_deal_id."'";
						$ptr_pvsm=mysql_query($sel_pvsm);
						if($total_pvsm=mysql_num_rows($ptr_pvsm))
						{
							while($data_pvsm=mysql_fetch_array($ptr_pvsm))
							{
								"<br/>".$sel_svcsm="select svm_id from sales_customer_service_voucher_map where service_id='".$data_pvsm['service_id']."' and package_id='".$data_pvsm['package_id']."' and quantity > 0 ";
								$ptr_svcsm=mysql_query($sel_svcsm);
								if(mysql_num_rows($ptr_svcsm))
								{
									
									for($i=1;$i<=$total_floor;$i++)
									{
										if($_POST['service_id'.$i]!='')
										{
											 "<br/>".$data_pvsm['service_id']."--".$_POST['service_id'.$i];
											if($data_pvsm['service_id']==$_POST['service_id'.$i])
											{
												
												"<br/>".$update_prod_qty="update sales_customer_service_voucher_map set quantity=(quantity -1) where service_id='".$data_pvsm['service_id']."' and package_id='".$packagess_deal_id."' ";
												$query_prod_qty=mysql_query($update_prod_qty);
												
											}
										}
									}
								}
							}
						}
						"<br/>". $sel_vsm1="select svm_id from sales_customer_service_voucher_map where package_id='".$packagess_deal_id."' and customer_id='".$customer_id."' and quantity > 0";
						$ptr_vsm1=mysql_query($sel_vsm1);
						"<br/>total ". $total=mysql_num_rows($ptr_vsm1);
						if($total <= 0)
						{
							"<br/>".$update_query="update sales_package_voucher_memb set quantity=(quantity -1) where cust_id='".$customer_id."' and package_id='".$packagess_deal_id."'";
							$ptr_qry=mysql_query($update_query);
							/*"<br/>".$update_vou_code="update voucher_customer_code_map set status ='inactive' where package_id='".$packagess_deal_id."' and customer_id='".$customer_id."'";
							$ptr_code=mysql_query($update_vou_code);*/
							"<br/>".$sel_spcvs="select id from sales_package_voucher_memb where cust_id='".$customer_id."' and package_id='".$packagess_deal_id."'";
							$ptr_spcvs=mysql_query($sel_spcvs);
							if(mysql_num_rows($ptr_spcvs))
							{
								"<br/>".$update_query="update sales_package_voucher_memb set status='inactive' where cust_id='".$customer_id."' and package_id='".$packagess_deal_id."'";
								$ptr_qry=mysql_query($update_query);
							}
						}
						
					}
					
					"<br>".$sql_query= "SELECT cust_name FROM customer where cust_id ='".$record_id."' ";              
					$query=mysql_query($sql_query);
					$fetch=mysql_fetch_array($query);
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('book_service','Add','".$fetch['cust_name']."','".$ins_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					
					//=============SMS Send================
										
					if($type=='Student')
					{
						$sql_product = "select name,contact from enrollment where enroll_id='".$customer_id."' ";
						$ptr_product = mysql_query($sql_product);
						$data_product = mysql_fetch_array($ptr_product);
						$name=$data_product['name'];
						$contact=$data_product['contact'];
					}
					else if($type=='Employee')
					{
						$sql_product="select name, admin_id,contact_phone from site_setting where admin_id='".$customer_id."' ";
						$ptr_product=mysql_query($sql_product);
						$data_product=mysql_fetch_array($ptr_product);
						$name=$data_product['name'];
						$contact=$data_product['contact_phone'];
					}
					else 
					{
						$sql_product="select cust_name, cust_id,mobile1 from customer where cust_id='".$customer_id."' ";
						$ptr_product=mysql_query($sql_product);
						$data_product=mysql_fetch_array($ptr_product);
						$name=$data_product['cust_name'];
						$contact=$data_product['mobile1'];
					}
					
					///$mesg ="Hi ".$name." your service is book on ".$start." to ".$end." ";
					$sel_inq="select sms_text from previleges where privilege_id='112'";
					$ptr_inq=mysql_query($sel_inq);
					$txt_msg='';
					if(mysql_num_rows($ptr_inq))
					{
						$dta_msg=mysql_fetch_array($ptr_inq);
						$txt_msg=$dta_msg['sms_text'];
					}
					$messagessss =$txt_msg; 
					
					
					$sep=explode(" ",$start);
					$sep_date=explode("-",$sep[0]);
					$service_date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
					$service_time=$sep[1];
					$address='';
					if($branch_name1=="Pune")
					{
						$address="Innocent Beauty Salon, 2nd Floor, The Greens,North Main Road, Koregoan Park, Pune-411001. Locaton: https://bit.ly/2yOhji6";
					}
					else if($branch_name1=="Ahmedabad")
					{
						$address="Innocent Beauty Salon, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007. Locaton: https://bit.ly/2N28vbw";
					}
					else if($branch_name1=="Baramati")
					{
						$address="International School of Aesthetics and Spa, Baramati, Email :learn@isasbeautyschool.com.";
					}
					
					$sel_inq="select sms_text from previleges where privilege_id='112'";
					$ptr_inq=mysql_query($sel_inq);
					if($remaining_amount >0)
					{
						$messagessss =$txt_msg;
						$search_by= array("student_name","branch_name","service_time","service_date","address");
						$replace_by = array($name,$branch_name1,$service_time,$service_date,$address);
					 	"<br/>".$messagessss = str_replace($search_by, $replace_by, $messagessss);
					}
					else
					{
						"<br/>".$messagessss = "Hello ".$name.", We just want to say it was privilege to have the opportunity to serve you at the Innocent Beauty Salon. I hope you enjoyed the service as much as we enjoyed rendering it to you. As a thank you, We would like to offer you 10% of your next same service. Please call us to book an appointment.".$address."";
					}
					
					send_sms_function($contact,$messagessss);
					
					"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='112' ".$_SESSION['where']."";
					$ptr_sel_sms=mysql_query($sel_sms_cnt);
					while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
					{
						"<br/>".$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and type!='S' ".$_SESSION['where']."";
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
					//------send notification on inquiry addition--------------------
						$notification_args['reference_id'] = $record_id;
						$notification_args['on_action'] = 'book_service';
						$notification_status = addNotifications($notification_args);
					//---------------------------------------------------------------
					
					if($status=="Completed")
					{
					?>
						<script>
						window.open('invoice-service.php?record_id=<?php echo $record_id; ?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=450, height=600,directories=no,location=no');
						</script>
					<?php
					}
					else
					{
						?>
						<script>
						window.open('job-card-generate.php?record_id=<?php echo $record_id; ?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=450, height=600,directories=no,location=no');
						</script>
					<?php
					}
					//echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
					?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record Added successfully</p></center></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" );}
													
												 }
								});
								
							});
							//setTimeout('document.location.href="manage_cust_services.php";',5000);
						</script>
					<?php
				}
			}
		}
		?>
         
        <div class="new_custom_course" style="display: none;">
			<form method="get" id="buttonForm" name="buttonForm" action="add_cust_services.php" >
                <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>	
                        <td class="orange_font"></td>
                        <!--<td><input type="submit" class="input_btn"  value="For Back Entries with Service Tax" name="gst"  /></td>-->
                        <input type="hidden" name="resource" id="resource_gst" />
                        <input type="hidden" name="start" id="start_gst" />
                        <input type="hidden" name="end" id="end_gst" />
                  </tr>
                </table>
            </form>       
         	<form method="post" id="jqueryForm" name="jqueryForm" onSubmit="return validme()" enctype="multipart/form-data" >
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                      <tr>	
                        <td class="orange_font">* Mandatory Fields</td>
                        <td><!--<a href="add_cust_services_gst.php" ><input type="button" class="input_btn"  value="For GST Service book" name="gst"  /></a>--></td>
                        <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                        
                        <input type="hidden" name="resource" id="resource"  />
                        <input type="hidden" name="start" id="start"  />
						<input type="hidden" name="last_start" id="last_start" />
                        <input type="hidden" name="end" id="end"  />
						
                      </tr>
                      <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
                            {
                            ?>
                              <tr>
                                <td>Select Branch</td>
                                <td>
                                <?php 
                                if($_REQUEST['record_id'])
                                {
                                    $sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A' ";
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
                        <?php } else { ?>
                               <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                               <?php }?>
                   <tr>
						<td width="15%" >SAC No.<span class="orange_font"></span></td>
						<td width="49%"><input type="text" name="sac_code" id="sac_code" class="input_text" value="<?php if($_POST['sac_code']) echo $_POST['sac_code']; else echo $data_sac_code['sac_code']; ?>"  />
						</td>
					</tr>
                    <tr>
                        <td width="15%" valign="top">Show <?php if($_SESSION['tax_type']=='GST') echo 'GST'; else echo ' VAT'; ?><span class="orange_font">*</span></td>
                        <td width="70%"><input type="radio" class="input_radio" name="show_gst" id="show_gst" value="yes" <?php if($_POST['show_gst']=='yes') echo 'checked="checked"'; else if($row_record['show_gst']=='yes') echo 'checked="checked"'; else echo 'checked="checked"';  ?> />Yes &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="show_gst" id="show_gst" value="no" <?php if($_POST['show_gst']=='no') echo 'checked="checked"'; else if($row_record['show_gst']=='no') echo 'checked="checked"'; ?>/>No</td> 
                        <td width="10%"><input type="hidden" name="res1" id="res1" /></td>
                    </tr>
                    <tr>           		
                        <td width="14%" >Select Customer Type<span class="orange_font">*</span></td>
                        <td>
                        <select id="user" name="user" onChange="show_data(this.value)" style="width:200px">
                        <option value="">Select</option>
                        <option value="Student" <?php if($row_record['type']=="Student") echo 'selected="selected"'; ?>>Student</option>
                        <option value="Customer" <?php if($row_record['type']=="Customer") echo 'selected="selected"'; ?>>Customer</option>
                        <option value="Employee" <?php if($row_record['type']=="Employee") echo 'selected="selected"'; ?>>Employee</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="show_type"></div>
                        </td>
                    </tr>
                   	<!--<tr>
						<td width="15%">Search by Mobile no.</td>
						<td id="mobiles">
						<select id="realtxt" name="realtxt" onChange="searchSel(this.value)">
						<option value="">Select Mobile No.</option>
						<?php  
							/*$sql_cust = "select mobile1,cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
							$ptr_cust = mysql_query($sql_cust);
							while($data_cust = mysql_fetch_array($ptr_cust))
							{ 
									$selecteds = '';
									if($data_cust['cust_id']==$row_record['customer_id'])
									$selecteds = 'selected="selected"';	
								echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
			
							}*/
							?>
						</select>
						</td>
                    </tr> 
                    <tr>
                       <td width="15%" valign="top">Select Customer<span class="orange_font">*</span></td>
                       <td width="70%"  class="customized_select_box" id="sel_cust">
                       <select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobiles_no(this.value)">
                         <option value="">Select Customer</option> 
                          <?php  
                            /*$sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_name asc";
                            $ptr_cust = mysql_query($sql_cust);
                            while($data_cust = mysql_fetch_array($ptr_cust))
                            { 
								$selecteds = '';
								if($data_cust['cust_id']==$row_record['customer_id'])
									$selecteds = 'selected="selected"';	
								echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
                            }*/
                            ?>
                           
                                <option value="custome" style="font-style:oblique; font-weight:800">New Customer</option> 
                        </select>
                        <td width="10%"></td>
                    </tr>-->
                    <tr>
						<td><input type="hidden" id="cus" value=""></td>
                    </tr>
                    <tr>
						<td colspan="3" width="100%">
							<div id="custome_div" style="display:none">
							   <table width="100%">
								<tr>
									<td width="26%">Customised Name<span class="orange_font">*</span></td>
									<td width="40%"><input type="text" class="inputText" name="costomize_courses" id="costomize_courses" value="<?php if($_POST['costomize_courses']) echo $_POST['costomize_courses']; else echo $row_record['customised_course'];?>"/></td>
									<td width="20%">&nbsp;</td>
								</tr>
							  </table>
							</div>
						</td>
                    </tr>
                    <tr>
                        <td width="15%" valign="top" colspan="3">
						<input type="hidden" name="memb_discount" id="memb_discount" value="">
                        <div id="membership_id" style="display:none">
                        <table width="100%">
                            <tr>
								<td width="7%">Membership Details</td>
								<td width="27%">Name :<span id="memb_name"> </span><br />Discount(in %) : <span id="memb_disc"></span></td>
                            </tr>
                        </table>
                        </div>        
                        </td>
                    </tr> 
                    <tr>
                        <td width="15%">Select Service<span class="orange_font">*</span></td>
                        <td colspan="2">
                        <table  width="100%" style="border:1px solid gray; ">
                            <tr>
                            <td colspan="2">
                            <!--===========================================================NEW TABLE START===================================-->
                            <table cellpadding="5" width="100%" >
                             <tr>
                             <?php
                             if($record_id =='')
                             {
                                ?>
                                <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                                <?php 
                             }?>
                             <script language="javascript">
                                        
                                        function floors(idss)
                                        {
                                            var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="21%" align="center"><input type="hidden" name="from_time'+idss+'" id="from_time'+idss+'" value="" width="40px" /><input type="hidden" name="to_time'+idss+'" id="to_time'+idss+'" value=""  width="40px" /><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="service_id'+idss+'" id="service_id'+idss+'" style="width:140px" onChange="getprice(this.value,'+idss+')"><option value="">Select Service</option><?php
											/* $serv_category = "select category_name,service_category_id from service_category order by category_name";
											$ptr_serv_cat = mysql_query($serv_category);
											while($data_cat = mysql_fetch_array($ptr_serv_cat))
											{
												echo '<optgroup label="'.addslashes($data_cat['category_name']).'">'; */
												$servsub_category = "select sub_name,sub_id from service_subcategory order by sub_name";
												$ptr_servsub_cat = mysql_query($servsub_category);//where category_id='".$data_cat['service_category_id']."'
												while($datasub_cat = mysql_fetch_array($ptr_servsub_cat))
												{
													echo '<optgroup label="'.addslashes($datasub_cat['sub_name']).'">';
													$sel_tel = "select service_id,service_name,service_price,service_time from servies where 1 and subcategory_id='".$datasub_cat['sub_id']."' order by service_name asc";	 //where category_id='".$data_cat['service_category_id']."'
													$query_tel = mysql_query($sel_tel);
													if($total=mysql_num_rows($query_tel))
													{
														while($data=mysql_fetch_array($query_tel))
														{
															echo '<option value="'.$data['service_id'].'">'.addslashes($data['service_name']) ." &nbsp;&nbsp;&nbsp;       (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time']." min)".'</option>';
														}
													}
													echo " </optgroup>";
												}
												/* echo " </optgroup>";
											} */
                                             ?>
                                             </select></td><td width="16%" align="center"><input type="text" disabled="disabled" name="sin_service_price'+idss+'" id="sin_service_price'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:100px" /></td><td width="5%" align="center"><input type="text" disabled="disabled" name="sin_service_qty'+idss+'" id="sin_service_qty'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:60px" /><input type="hidden" name="sin_total'+idss+'" id="sin_total'+idss+'"></td><td width="18%" align="center"><input type="text" name="sin_service_disc'+idss+'" id="sin_service_disc'+idss+'" onkeyup="getDiscount(this.value,'+idss+')"  disabled="disabled" style=" width:100px" /><input type="hidden" name="sin_service_disc_price'+idss+'" id="sin_service_disc_price'+idss+'" /></td><td width="14%" align="center"><input type="text" disabled="disabled" name="sin_service_total'+idss+'" id="sin_service_total'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:100px"><input type="hidden" disabled="disabled" name="sin_service_time'+idss+'" id="sin_service_time'+idss+'" style=" width:100px" /></td><td width="17%" align="center"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:90%"><option value="">Select Staff</option><?php
                                            /*if($_SESSION['type']=="S")
                                            {
                                                $sel_staff = "select admin_id,name from site_setting where 1  ".$_SESSION['where']." order by admin_id asc";	 
                                                $query_staff = mysql_query($sel_staff);
                                                if($total_staff=mysql_num_rows($query_staff))
                                                {
                                                    while($data=mysql_fetch_array($query_staff))
                                                    {
                                                        echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
                                                    }
                                                }
                                            }
                                            else
                                            {*/
                                                $sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$_SESSION['where']." ".$prev_value."";
                                                $ptr_id=mysql_query($sel_prev_id);
                                                if(mysql_num_rows($ptr_id))
                                                {
                                                    while($data_prev_id=mysql_fetch_array($ptr_id))
                                                    {
                                                        $sel_staff = "select admin_id,name from site_setting where 1 and system_status='Enabled' and admin_id='".$data_prev_id['admin_id']."' ".$_SESSION['where']." order by name asc";	
                                                        $query_staff = mysql_query($sel_staff);
                                                        if(mysql_num_rows($query_staff))
                                                        {
                                                            $data=mysql_fetch_array($query_staff);
                                                            echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
                                                        }
                                                        
                                                    }
                                                }
                                            //}
                                             ?>
                                             </select><input type="hidden" name="total_services[]" id="total_services'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                            document.getElementById('floor').value=idss;
                                            return shows_data;
                                        }
                                        
                                </script>
								<td align="right"><input type="button"  name="Add"s class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" ><input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
								</td></tr>
                                <tr><td>  </td><td align="left"></td></tr>
                            </table> 
                            <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td>
							</tr>
							<tr><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
							<tr>
                                <td colspan="7">
                                <table cellspacing="3" id="tbl" width="100%">
                                <tr>
									<!--<td valign="top" width="6%" align="center">Order No.</td>-->
									<td valign="top" width="21%" align="center">Service Name</td>
									<td valign="top" width="16%"  align="center">Price</td>
                                     <td valign="top" width="10%"  align="center">Quantity</td>
									<td valign="top" width="18%"  align="center">Discount (in %)<br />
									<input type="radio" name="discount" id="discount" checked="checked" value="percentage" <?php if($_POST['discount']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="discount" id="discount" value="rupees" <?php if($_POST['discount']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in <?php if($_SESSION['tax_type']=='GST') echo 'Rs -/'; else echo 'AED'; ?> </td>
									<td valign="top" width="14%"  align="center">Total Price</td>
									<td valign="top" width="17%"  align="center">Staff</td>
									
                                </tr>
                                <tr>
                                    <td colspan="7">
                                    <?php
                                    if($record_id)
                                    {
										$select_exc = "select * from customer_service_map where customer_service_id='".$record_id."' order by customer_service_map_id asc ";
										$ptr_fs = mysql_query($select_exc);
										$t=1;
										$total_comision= mysql_num_rows($ptr_fs);
										$total_conditions= mysql_num_rows($ptr_fs);
										while($data_exclusive = mysql_fetch_array($ptr_fs))
										{ 
											$slab_id= $data_exclusive['customer_service_map_id'];
											?> 
											<div class="floor_div" id="floor_id<?php echo $t; ?>">
											<table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
											<tr>
											<td valign="top" width="15%" align="center"><select name="service_id<?php echo $t; ?>" id="service_id<?php echo $t; ?>" style="width:140px" onChange="getprice(this.value,<?php echo $t; ?>)"><option value="">Select Service</option><?php
											$sel_tel = "select service_id,service_name,service_price,service_time from servies order by service_id asc";	 
											$query_tel = mysql_query($sel_tel);
											if($total=mysql_num_rows($query_tel))
											{
												while($data=mysql_fetch_array($query_tel))
												{
													$selected='';
													if($data_exclusive['service_id'] ==$data['service_id'] )
													{
														$selected='selected="selected"';
													}
													echo '<option value="'.$data['service_id'].'" '.$selected.'>'.$data['service_name']."   (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time'].")".'</option>';
												}
											}
											?>
											</select></td>
											<td width="8%" align="center"><input type="text" name="sin_service_price<?php echo $t; ?>" id="sin_service_price<?php echo $t; ?>" style=" width:100px" onkeyup="calc_service_price(<?php echo $t; ?>)" value="<?php echo $data_exclusive['service_price'] ?>" /></td><td width="5%" align="center"><input type="text" name="sin_service_qty<?php echo $t; ?>" id="sin_service_qty<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px" value="<?php echo $data_exclusive['service_quantity'] ?>" /><input type="hidden" name="sin_total<?php echo $t; ?>" id="sin_total<?php echo $t; ?>" value="<?php echo $data_exclusive['service_quantity_price'] ?>"></td><td width="8%" align="center"><input type="text" name="sin_service_disc<?php echo $t; ?>" id="sin_service_disc<?php echo $t; ?>" value="<?php echo $data_exclusive['discount'] ?>" onKeyUp="getDiscount(this.value,<?php echo $t; ?>)"  style=" width:100px" /><input type="hidden" name="sin_service_disc_price<?php echo $t; ?>" id="sin_service_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['discount_price'] ?>" /></td><td width="8%" align="center"><input type="text"  name="sin_service_total<?php echo $t; ?>" id="sin_service_total<?php echo $t; ?>" style=" width:100px" onkeyup="calc_service_price(<?php echo $t; ?>)" value="<?php echo $data_exclusive['total_price'] ?>"><input type="hidden"name="sin_service_time<?php echo $t; ?>" id="sin_service_time<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['service_time'] ?>" /></td><td width="10%"><select name="staff_id<?php echo $t; ?>" id="staff_id<?php echo $t; ?>" style="width:90%"><option value="">Select Staff</option><?php
											/*$sel_staff = "select admin_id,name from site_setting order by admin_id asc";	 
											$query_staff = mysql_query($sel_staff);
											if($total_staff=mysql_num_rows($query_staff))
											{
												while($data=mysql_fetch_array($query_staff))
												{
													$selected='';
													if($data_exclusive['admin_id'] ==$data['admin_id'] )
													{
														$selected='selected="selected"';
													}
													echo '<option value="'.$data['admin_id'].'" '.$selected.'>'.$data['name'].'</option>';
												}
											}*/
											$sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$_SESSION['where']." ".$prev_value."";
											$ptr_id=mysql_query($sel_prev_id);
											if(mysql_num_rows($ptr_id))
											{
												while($data_prev_id=mysql_fetch_array($ptr_id))
												{
													$sel_staff = "select admin_id,name from site_setting where 1 and system_status='Enabled' and admin_id='".$data_prev_id['admin_id']."' ".$_SESSION['where']." order by admin_id asc";	
													$query_staff = mysql_query($sel_staff);
													if(mysql_num_rows($query_staff))
													{
														$data=mysql_fetch_array($query_staff);
														$selected='';
														if($data_exclusive['admin_id'] ==$data['admin_id'] )
														{
															$selected='selected="selected"';
														}
														echo '<option '.$selected.' value="'.$data['admin_id'].'">'.$data['name'].'</option>';
														//echo '{name : "'.$data['name'].'", id:"'.$data['admin_id'].'"},';
														$i++;
													}
													
												}
											}
											?>
											</select>
											<input type="hidden" name="from_time<?php echo $t; ?>" id="from_time<?php echo $t; ?>" value="" /><input type="hidden" name="to_time<?php echo $t; ?>" id="to_time<?php echo $t; ?>" value="" /></td>
											<td valign="top" width="10%" align="center">
											<?php
											if($record_id)
											{
												?>
												<input type="hidden" name="total_services[]" id="total_services<?php echo $t; ?>" />
												<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['customer_service_map_id'] ?>" />
												<input type="button" title="Delete Options(-)" onClick="delete_service(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
												<input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
												<?php 
											} ?>   
											</td>
											</tr></table>
											</div>
											<?php
											$t++;
										}
									}
                                    ?>
                                </tr> 
                                </table>
                                 <input type="hidden" name="floor" id="floor"  value="0" />
                                <div id="create_floor"></div>
                            </td></tr></table>
							<!--<table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
								<tr>
								<td width="10%" align="left"><input type="button" name="set_korderss" value="Set Order" onClick="return show_staff_time()"/></td>
								</tr>
							</table>-->
                             <?php
                             if($record_id)
                             {
                                ?>
                            <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
                            <input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
                            <?php } ?> 
                            <!--============================================================END TABLE=========================================-->
                            </td>
                            </tr>
                        </table>
						<input type="hidden" name="total_service_time" id="total_service_time" value="" />
                     </td>
                 </tr>
                     <tr>
                        <td width="15%" valign="top">Service Price</td>
                        <td width="70%"><input type="text"  class=" input_text" name="service_price" id="service_price"  value="<?php if($_POST['service_price']) echo $_POST['service_price']; else echo $row_record['service_price'];?>" /></td> 
                        <td width="10%"></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                        <div id="memb_discount_div" style="display:none">
                        <table width="98%">
                            <tr>
                                <td width="24%" valign="top">Membership Discount Price</td>
                                <td width="70%"><input type="text" class=" input_text" name="discount_price" id="discount_price" onBlur="showUser()" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_record['discount_price'];?>" /></td> 
                                <td width="5%"></td>
                            </tr>
                        </table>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" valign="top">Discount  <input type="radio" name="nonmemb_discount_type" onChange="showUser()" id="nonmemb_discount_type" checked="checked" value="percentage" <?php if($_POST['nonmemb_discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="nonmemb_discount_type" id="nonmemb_discount_type" onChange="showUser()" value="rupees" <?php if($_POST['nonmemb_discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="rupees") { echo 'checked="checked"';} ?> />in <?php if($_SESSION['tax_type']=='GST') echo 'Rs -/'; else echo 'AED'; ?></td>
                        
                        <td width="72%"><input type="text" class=" input_text" name="nonmemb_discount" id="nonmemb_discount" onBlur="showUser()" value="<?php if($_POST['nonmemb_discount']){echo $_POST['nonmemb_discount'];} else {echo $row_record['nonmemb_discount'];}?>" /></td> 
                        <td width="5%"></td>
                    </tr>
					<tr>
						<td colspan="2">
							<div id="loyalty_points_id" style="display:none"></div>
						</td>
					</tr>
					<tr>
                        <td width="15%" valign="top">Discounted Price</td>
                        <td width="72%"><input type="text" class=" input_text" name="nonmemb_discount_price" id="nonmemb_discount_price" value="<?php if($_POST['nonmemb_discount_price']) echo $_POST['nonmemb_discount_price']; else echo $row_record['nonmemb_discount_price'];?>" /></td> 
                        <td width="5%"></td>
                    </tr>
                    <tr>
                        <td width="15%" valign="top">Apply <?php if($_SESSION['tax_type']=='GST') echo 'GST'; else echo 'VAT'; ?><span class="orange_font">*</span></td>
                        <td width="70%">
                        <?php if($_SESSION['tax_type']=='GST') 
						{
						?>
                        <input type="radio" class="input_radio" name="apply_gst" id="apply_gst"  onclick="showUser()" value="included" <?php if($_POST['apply_gst']=='included') echo 'checked="checked"'; else if($row_record['apply_gst']=='included') echo 'checked="checked"'; else echo 'checked="checked"';  ?> />Included &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="apply_gst" id="apply_gst"  onclick="showUser()" value="yes" <?php if($_POST['apply_gst']=='yes') echo 'checked="checked"'; else if($row_record['apply_gst']=='yes') echo 'checked="checked"'; else echo 'checked="checked"';  ?> />Yes &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="apply_gst" id="apply_gst" onclick="showUser()" value="no" <?php if($_POST['apply_gst']=='no') echo 'checked="checked"'; else if($row_record['apply_gst']=='no') echo 'checked="checked"'; ?>/>No
                        <?php
						}
						else
						{
							?>
                            <input type="radio" class="input_radio" name="apply_vat" id="apply_vat"  onclick="showUser()" value="included" <?php if($_POST['apply_vat']=='included') echo 'checked="checked"'; else if($row_record['apply_vat']=='included') echo 'checked="checked"'; else echo 'checked="checked"';  ?> />Included &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="apply_vat" id="apply_vat"  onclick="showUser()" value="yes" <?php if($_POST['apply_vat']=='yes') echo 'checked="checked"'; else if($row_record['apply_vat']=='yes') echo 'checked="checked"'; else echo 'checked="checked"';  ?> />Yes &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="apply_vat" id="apply_vat" onclick="showUser()" value="no" <?php if($_POST['apply_vat']=='no') echo 'checked="checked"'; else if($row_record['apply_vat']=='no') echo 'checked="checked"'; ?>/>No
                            <?php
						}
						?>
                        </td> 
                        <td width="10%"></td>
                    </tr>
					<?php
					if($_SESSION['tax_type']=='GST')
					{ 
					?>
					<tr>
                        <td width="15%" valign="top">Select GST Type<span class="orange_font">*</span></td>
                        <td width="70%"><input type="radio" class="input_radio" name="gst_type" id="gst_type"  onclick="showUser()" value="m_gst" <?php if($_POST['gst_type']=='m_gst') echo 'checked="checked"'; else if($row_record['gst_type']=='m_gst') echo 'checked="checked"'; else echo 'checked="checked"';  ?> />GST &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="gst_type" id="gst_type1"  onclick="showUser()" value="m_igst" <?php if($_POST['gst_type']=='m_igst') echo 'checked="checked"'; else if($row_record['gst_type']=='m_igst') echo 'checked="checked"'; ?> />IGST</td> 
                        <td width="10%"></td>
                    </tr>
                    <?php
					}
					?>
                    <!--<tr>
                        <td width="20%" valign="top">Non Membership Discount  <input type="radio" name="nonmemb_discount_type" id="nonmemb_discount_type" checked="checked" value="percentage" <?php //if($_POST['nonmemb_discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="nonmemb_discount_type" id="nonmemb_discount_type" value="rupees" <?php //if($_POST['nonmemb_discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/</td>
                        
                        <td width="70%"><input type="text"  class=" input_text" name="nonmemb_discount" id="nonmemb_discount" onkeypress="showUser(this.value)" value="<?php //if($_POST['nonmemb_discount']) echo $_POST['nonmemb_discount']; else echo $row_record['nonmemb_discount'];?>" /></td> 
                    </tr>
                    <tr>
                        <td width="20%" valign="top">Non Membership Discount Price </td>
                        
                        <td width="70%"><input type="text"  class=" input_text" name="nonmemb_discount_price" id="nonmemb_discount_price" readonly="readonly" value="<?php //if($_POST['nonmemb_discount_price']) echo $_POST['nonmemb_discount_price']; else echo $row_record['nonmemb_discount_price'];?>" /></td> 
                    </tr>-->
                    <?php
					if($_SESSION['tax_type']=='GST')
					{
						?>
						<tr>      
							  <td width="15%" class="heading">CGST <span id="cgst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['cgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="cgst_taxes" name="cgst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['cgst'];} ?>"  />
							  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="cgst_tax" id="cgst_tax"  value="<?php if($_POST['cgst_tax']) echo $_POST['cgst_tax']; else echo $row_record['cgst_tax'];?>" /></td>
						</tr>
						<tr>      
							  <td width="15%" class="heading">SGST <span id="sgst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['sgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="sgst_taxes" name="sgst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['sgst'];} ?>"  />
							  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="sgst_tax" id="sgst_tax"  value="<?php if($_POST['sgst_tax']) echo $_POST['sgst_tax']; else echo $row_record['sgst_tax'];?>" /></td>
						</tr>
						<tr>      
							  <td width="15%" class="heading">IGST <span id="igst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['igst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="igst_taxes" name="igst_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['igst'];} ?>"  />
							  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="igst_tax" id="igst_tax"  value="<?php if($_POST['igst_tax']) echo $_POST['igst_tax']; else echo $row_record['igst_tax'];?>" /></td>
						</tr>
						<?php
					}
					else
					{
						?>
						<tr>      
							  <td width="20%" class="heading">VAT <span id="service_tax_id"><?php if($_SESSION['type']!='S'  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['service_tax'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo $_SESSION['service_tax'];} ?>"  />
							  <td><input type="text" class="input_text" name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>
						</tr>
						<?php
					}
					?>
                    <tr>
                        <td width="15%" valign="top">Total Cost<span class="orange_font">*</span></td>
                        <td width="70%"><input type="text"  class=" input_text" name="total_cost" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>" /></td> 
                        <td width="10%"><input type="hidden" id="excluded_tax" name="excluded_tax" value=""></td>
                    </tr>
                    <tr>
                    	<td width="15%" valign="top">Select Category<span class="orange_font">*</span></td>
                        <td width="70%">
                        <select name="category" id="category" onChange="show_category(this.value)">
							<option value="">Select Category</option>
							<option value="Package" <?php if($_POST['category']=="Package") echo 'selected="selected"'; else if($row_record['category']=="Package")echo 'selected="selected"'; ?>>Package</option>
							<option value="Voucher" <?php if($_POST['category']=="Voucher") echo 'selected="selected"'; else if($row_record['category']=="Voucher")echo 'selected="selected"'; ?>>Voucher</option>
							<option value="loyalty_point" <?php if($_POST['category']=="loyalty_point") echo 'selected="selected"'; else if($row_record['category']=="loyalty_point")echo 'selected="selected"'; ?>>Loyalty Point</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="3">
					<div id="loyalty_success" ></div>
                    <div id="voucher_no" style="display:none">
                    <table width="100%">
                     <!--===========================================================NEW TABLE 2 START===================================-->   
                       <tr>            
                            <td width="10%">Select Voucher<span class="orange_font">*</span></td>
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
                                        //alert(res1);
                                        var shows_data='<div id="type1_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="2%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="" /><select name="voucher_deal_id'+idss+'" id="voucher_deal_id'+idss+'" align="center" ><option value="">Select Voucher</option>'+res1+'</select></td><td width="2%" valign="top"><input type="text" name="cust_voucher_code'+idss+'" id="cust_voucher_code'+idss+'" /><input type="hidden" name="redeme_code_id'+idss+'" id="redeme_code_id'+idss+'" value="" /><input type="button" name="validate_code" id="validate_code" value="Check" onClick="validates('+idss+')" /></td><td width="6%"><div id="loading'+idss+'"></div><div id="voucher_div_id'+idss+'" style="display:none"><table style="width:100%" align="center"><tr><td width="23%">Voucher Name : <span id="voucher_name'+idss+'"></span><input type="hidden" name="vouchers_name'+idss+'" id="vouchers_name'+idss+'" value="" /></td></tr><tr><td width="23%">Start Date : <span id="voucher_start_date'+idss+'"></span><input type="hidden" name="vouchers_start_date'+idss+'" id="vouchers_start_date'+idss+'" value="" /></td></tr><tr><td width="23%">End Date : <span id="voucher_end_date'+idss+'"></span><input type="hidden" name="vouchers_end_date'+idss+'" id="vouchers_end_date'+idss+'" value="" /></td></tr><tr><td colspan="3"><div id="amount_div'+idss+'"><table width="100%" align="center"><tr><td width="23%">Price : <span id="voucher_price'+idss+'"></span><input type="hidden" name="vouchers_price'+idss+'" id="vouchers_price'+idss+'" value="" /></td></tr></table></div></td></tr></table></div></td><td width="4%" valign="top"><div id="redemption_div_id'+idss+'">Redumption : <span id="voucher_prices'+idss+'"></span> - <span id="amount_prices'+idss+'"></span> = <span id="total_price'+idss+'"></span><input type="hidden" name="totals_price'+idss+'" id="totals_price'+idss+'" value="" /><input type="hidden" name="categories'+idss+'" id="categories'+idss+'" /></div></td><td valign="top" width="4%" align="center"><div id="price_in_voucher_div_id'+idss+'"><span id="remaining_total'+idss+'"></span><input type="hidden" name="remaining_amnt_in_voucher'+idss+'" id="remaining_amnt_in_voucher'+idss+'" value=""/><input type="hidden" name="total_remaining_amnt'+idss+'" id="total_remaining_amnt'+idss+'" value=""/></div></td><td width="1%" align="center" valign="top"><input type="button" name="Delete"  class="delBtn"  onClick="delete_voucher('+idss+')" alt="Delete(-)" ></td><input type="hidden" name="total_voucher[]" id="total_voucher'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
            
                                   document.getElementById('total_type1').value=idss; 
                                   return shows_data;
                                    }
                                </script>
                        <td align="left"><span style="color:#F00; font-weight:600">Note-: First Redeem all Service vouchers then Amount vouchers</span></td>
                        <td align="right">
                        <input type="button" name="Add"  class="addBtn" onClick="javascript:create_type1('add_type1');" alt="Add(+)" > 
                        <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_type1('delete_type1');" alt="Delete(-)" >
                        </td>
                        </tr>
                             <tr><td></td><td align="left"></td></tr>
                        </table> 
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
                        <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
                        <tr>
							<td colspan="7">
								<table cellspacing="3" id="tbl" width="100%">
									<tr>
										<td valign="top" width="8%" align="center">Select Voucher</td>
										<td valign="top" width="8%" align="center">Voucher Code</td>
										<td valign="top" width="8%"  align="center">Voucher Details</td>
										<td valign="top" width="8%"  align="center">Redemptions</td>
										<td valign="top" width="8%"  align="center">Remaining pice in voucher</td>
										<td valign="top" width="2%"  align="center">Delete</td>
									</tr>
									<tr>
										<td colspan="7" bgcolor="#000000">
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
													<td width="8%" align="center"><input type="text" name="tax_type<?php echo $s; ?>" id="tax_type<?php echo $s; ?>" style=" width:100px" value="<?php echo $data_exclusive['tax_type'] ?>" />
													</td>
													<td width="8%" align="center"><input type="hidden" name="tax_amount<?php echo $s; ?>" id="tax_amount<?php echo $s; ?>" value="<?php echo $data_exclusive['tax_amount'] ?>"/><input type="text" name="tax_value<?php echo $s; ?>" id="tax_value<?php echo $s; ?>" style=" width:100px" value="<?php echo $data_exclusive['tax_value'] ?>" onKeyUp="calculte_amount_tax(<?php echo $s; ?>)"/></td>
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
										</td>
                                    </tr> 
                                </table>
                                <input type="hidden" name="total_type1" id="total_type1"  value="0" />
                                <div id="create_type1"></div>
                            </td>
						</tr>
						</table>
						<?php
						if($record_id)
						{
							?>
                            <!--<input type="hidden" name="total_type1" id="total_type1" class="inputText"   value="<?php //echo $total_conditions; ?>" />-->
                            <input type="hidden" name="type1" id="type1" class="inputText" value="<?php echo $total_conditions; ?>" />
							<?php 
						} ?> 
						</td>
						</tr>
                    </table>
                    </td>
                    </tr>
                    </table>
                    </div>
                    </td>
                    </tr>
                    
                   <!--============================================================END TABLE 2=========================================-->
                    <!--<tr>
                        <td></td>
                        <td><div id="package_details"></div></td>
                    </tr>-->
                    <tr>
                        <td colspan="3">
                        <div id="package_id"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div id="package_div_id" style="display:none">
                                <table style="width:100%">
                                    <tr>
                                        <td width="6%">Package Details</td>
                                        <td width="23%">Package Name : <span id="packages_names"></span><input type="hidden" name="package_names" id="package_names" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td width="6%">
                                        </td><td width="23%">Start Date : <span id="packages_start_date"></span><input type="hidden" name="package_start_date" id="package_start_date" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td width="6%"></td>
                                        <td width="23%">End Date : <span id="packages_end_date"></span><input type="hidden" name="package_end_date" id="package_end_date" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                        <div id="amount_div">
                                            <table width="100%">
                                                <tr>
                                                    <td width="6%"></td>
                                                    <td width="23%">Price : <span id="packages_price"></span><input type="hidden" name="package_price" id="package_price" value="" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="6%"></td>
                                                    <td width="23%" style="display:none">Redumption : <span id="package_prices"></span> - <span id="package_amnt_prices"></span> = <span id="total_price_pkg"></span><input type="hidden" name="totals_price_pkg" id="totals_price_pkg" value="" /></td>
                                                </tr>
                                            </table>
                                        </div>
                                        </td>
                                     </tr>
                               </table>
                           </div>
                       </td>
                    </tr>
                    <tr>
                        <td class="tr-header">Select Payment Mode<span class="orange_font"></span></td>
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
                     	<div id="bank_ref_no" <?php  if($data_payment_mode1['payment_mode']=='online') echo 'style="display:block"'; else echo ' style="display:none"'; ?>>
                            <table width="100%">
                                <tr>
                                    <td width="10%" class="tr-header" align="">Ref. no</td>
                                    <td width="35%"><input type="text" name="bank_ref_no" id="ref_no_bank" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $row_record['bank_ref_no']; ?>"/></td>
                                </tr>
                            </table>
                        </div>
                        <div id="bank_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo 'style="display:block"'; else echo ' style="display:none"'; ?>>
                            <table width="100%">
                                <tr>
                                    <td width="23%" class="tr-header" >ISAS Bank Name</td>
                                    <td>
                                        <div id="bank_id"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tr-header" width="23%">Account No</td>
                                    <td><input type="text" name="account_no" readonly id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
                                </tr>
								<tr>
                                    <td class="tr-header" width="23%">Cust. Bank Name</td>
                                    <td><input type="text" name="cust_bank_name" id="cust_bank_name" value="<?php if($_POST['cust_bank_name']) echo $_POST['cust_bank_name']; else echo $row_record['cust_bank_name']; ?>" /></td>
                                </tr>
                            </table>
                        </div>
                        <div id="chaque_details" <?php if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                            <table width="100%">
								
                                <tr>
                                    <td class="tr-header" width="23%">Enter Chaque No</td>
                                    <td><input type="text" name="chaque_no" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="tr-header" width="15%">Enter Chaque Date</td>
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
						<div id="paytm_details" <?php  if($data_payment_mode1['payment_mode']=='paytm') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                            <table width="100%">
                                <tr>
                                    <td class="tr-header" width="26%">ISAS Mobile No</td>
                                    <td><input type="text" name="isas_paytm_no" id="isas_paytm_no" maxlength="10" value="<?php if($_POST['isas_paytm_no']) echo $_POST['isas_paytm_no']; else echo $row_record['isas_paytm_no']; ?>" /></td>
                                </tr>
								<tr>
                                    <td class="tr-header" width="26%">Cust. Mobile No</td>
                                    <td><input type="text" name="cust_paytm_no" id="cust_paytm_no" maxlength="10" value="<?php if($_POST['cust_paytm_no']) echo $_POST['cust_paytm_no']; else echo $row_record['cust_paytm_no']; ?>" /></td>
                                </tr>
                            </table>
                        </div>
                        <!--<div id="voucher_no"></div>-->
                        
                        </td>
                       </tr>
                       <tr>
                           <td colspan="3">
                               
                           </td>
                        </tr>
                        <tr>
							<td width="15%">Care Call Followup Date<span class="orange_font">*</span></td>
							<td width="44%"><input type="text" class="input_text datepicker" name="followup_date" id="followup_date" value="<?php if($_POST['followup_date']) echo $_POST['followup_date']; else {
								if($row_record['followup_date'] !='')
								{
									$arrage_date= explode('-',$row_record['followup_date'],3);     
									echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
								}
								// $row_record['staff_dob'];
							}?>" /></td>
						</tr>
						<tr>
							<td width="15%">Treatment Call Followup Date<span class="orange_font">*</span></td>
							<td width="44%"><input type="text" style="width:200px" class="input_text datepicker" name="treatment_followup_date" id="treatment_followup_date" value="<?php if($_POST['treatment_followup_date']) echo $_POST['treatment_followup_date']; else {
								if($row_record['treatment_followup_date'] !='')
								{
									$arrage_date= explode('-',$row_record['treatment_followup_date'],3);     
									echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
								}
								// $row_record['staff_dob'];
							}?>" /></td>
						</tr>
						<tr>
							<td width="15%" >Followup Description</td>
							<td width="44%" ><textarea name="followup_desc" class="input_textarea" id="followup_desc" ><?php if($_POST['followup_desc']) echo $_POST['followup_desc']; else echo $row_record['followup_desc'];?></textarea></td>
						</tr>
                        <tr>
                            <td width="" class="tr-header">Amount<span class="orange_font">*</span></td>
                            <td width=""><input type="text" name="amount" id="amount" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount']; ?>"  /></td>
                            <td width="10%"><input type="hidden" name="remaining_voucher" id="remaining_voucher" value="0"  /></td>
                        </tr>
                        
                        <tr>
                            <td width="15%" >Payable Amount</td>                   
                            <td width="40%"><input type="text" name="payable_amount" id="payable_amount" value="<?php if($_POST['save_changes']) echo $_POST['payable_amount']; else echo $row_record['payable_amount']; ?>" onKeyUp="cal_remaining_amt();"/></td>
						</tr> 
						<tr>
							<td width="15%" >Remaining Amount</td>
							<td width="40%"><input type="text" name="remaining_amount" id="remaining_amount" value="<?php if($_POST['save_changes']) echo $_POST['remaining_amount']; else echo $row_record['remaining_amount']; ?>"  /></td>
						</tr>
                        <tr>
							<td width="" class="tr-header" align="">Select Employee<span class="orange_font">*</span></td>
							<td><select name="employee_id" id="employee_id" onChange="show_exist_time(this.value)">
							<option value="">--Select--</option>
							<?php
							$sle_name="select admin_id,name from site_setting where 1 and system_status='Enabled' ".$_SESSION['where'].""; 
							$ptr_name=mysql_query($sle_name);
							while($data_name=mysql_fetch_array($ptr_name))
							{
								$selected='';
								if($data_name['admin_id'] == $row_record['staff_id'] || $data_name['admin_id'] == $_SESSION['admin_id'])
								{
									$selected='selected="selected"';
								}
								echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
							}
							?>
							</select>
							</td>
						</tr>
						<tr>
                          <td>&nbsp; <input type="hidden" name="post_data" id="post_data" value="yes" /></td>
                          <td><input type="submit" id="submit_btn" class="input_btn"  value="Book Customer Service" name="save_changes"  /></td>
                          <td><input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/></td>
						</tr>
					</table>
                </form>
				<script type="text/javascript">
				function save_customer()
				{
                    var cust_name = $("#cust_name").val();
                    var mobile1 = $("#mobile1").val();
                    var email =''; /*$("#email").val()*/
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
                    var data1 = 'action=custome_customer_submit&customer_name='+cust_name+'&mobile='+mobile1+'&email='+email+"&branch_name="+branch_name;
                    $.ajax({
                        url: "ajax.php", type: "post", data: data1, cache: false,
                        success: function (html)
                        {
							if(html.trim() =='mobile')
							{
								alert("Mobile no. already Exist");
								return false;
							}
							else if (html.trim() =='cust_id')
							{
								alert("Customer name already Exist");
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
								$('.new_customer_add').dialog( 'close');
								$("#customer_id").chosen({allow_single_deselect:true});
								getMembership()
							}
                        }
                    });
				}
            
        </script>
        <div class="new_customer_add" style="display: none;">
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
                    <!--<tr>
                        <td>Email<span class="orange_font"></span></td>
                        <td><input type="text" class="inputText" name="email" id="email"></td>
                    </tr>-->                    
                    <tr>
                    
                    <tr>
                        <td></td>
                        <td><input type="button" class="inputButton customer_details_submit" onClick="return save_customer()" value="Submit" name="submit"/>&nbsp;
                            <input type="reset" class="inputButton" value="Close" onClick="$('.new_customer_add').dialog( 'close');"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>  
				
				
                <script type="text/javascript">



            /* $(function() 
            {

                $(".custom_cuorse_submit").click(function(){
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
							else if (html.trim() =='blank')
							{
								alert("Please enter Mobile number");
								return false;
							}
							else
							{
								$(".customized_select_box").html(html);
								
								$('.new_custom_course').dialog( 'close');
								$("#customer_id").chosen({allow_single_deselect:true});
								getMembership()
							}
                        }
                    });
                });
         }); */
        </script>
            <!--<form method="post" id="jqueryForm" name="discount" enctype="multipart/form-data">
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
            </form>-->
        </div> 
      	</td>
    	</tr>
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
 <div id="footer" style="margin-top:300px;"><?php require("include/footer.php");?></div>
 
 
<script>
function showUser(non_memb_disc)
{
	//alert("hiiii");
	contact='0';
	var total_service= document.getElementsByName("total_services[]");
	totals=total_service.length;
	for(i=1; i<=totals;i++)
	{
		//alert(i);
		servicesss_idddd=Number(document.getElementById("sin_service_total"+i).value);
		//alert(servicesss_idddd);
		if(servicesss_idddd!='')
		{
			contact =Number(contact)+Number(servicesss_idddd);
			if(contact=='')
			{
				contact="0";
			}
			//alert(contact);
		}
	}
	document.getElementById('service_price').value=contact;
	
	var service_price=contact;
	var membership_discount= parseFloat(document.getElementById('memb_discount').value);
	if(membership_discount >0)
	{
		var discount_price= service_price * (membership_discount/100);
	}
	else
	{
		var discount_price= 0;
	}
	
	if(discount_price >0)
	{
		var total_discount_price= parseFloat(service_price - discount_price);
		document.getElementById('memb_discount_div').style.display="block";
	}
	else
	{
		var total_discount_price=service_price;
		document.getElementById('memb_discount_div').style.display="none";
	}
	document.getElementById('discount_price').value=total_discount_price;
	if(document.getElementById('nonmemb_discount'))
	{	
		var nonmemb_discount= parseFloat(document.getElementById('nonmemb_discount').value);
	}
	else
	{
		var nonmemb_discount=0;
	}//var nonmemb_discount_type= parseFloat(document.getElementById('nonmemb_discount_type').value);
	frm = document.jqueryForm;  
	nonmemb_discount_type =frm.nonmemb_discount_type.value;
	
	if(nonmemb_discount >0)
	{
		if(nonmemb_discount_type=="percentage")
		{
			var nonmemb_discount_price= total_discount_price * (nonmemb_discount/100);
		}
		else
		{
			var nonmemb_discount_price= nonmemb_discount;
		}
	}
	else
	{
		var nonmemb_discount_price= 0;
	}
	
	if(nonmemb_discount_price >0)
	{
		var total_nonmemb_discount_price= parseFloat(total_discount_price - nonmemb_discount_price);
		document.getElementById('nonmemb_discount_price').value=total_nonmemb_discount_price;
	}
	else
	{
		var total_nonmemb_discount_price=total_discount_price;
		document.getElementById('nonmemb_discount_price').value=total_nonmemb_discount_price;
	}
	
	var disc_price= document.getElementById('nonmemb_discount_price').value;
	
	if(document.getElementById('category'))
	{
		var category=document.getElementById('category').value;
		//alert(category);
		if(category=="loyalty_point")
		{
			var redemptoin_value=document.getElementById("redemptoin_value").value;
			total=parseFloat(disc_price)-parseFloat(redemptoin_value);
			document.getElementById('nonmemb_discount_price').value=total;
			var disc_price= total;
		}
	}
	
	/*nonmemb_discount='';
	frms = document.jqueryForm;  
	
	nonmemb_discount_type =frms.nonmemb_discount_type.value;
	nonmemb_discount=non_memb_disc;
	non_memb_discount_price='';
	//alert(nonmemb_discount);
	if(nonmemb_discount > 0)
	{
		if(nonmemb_discount_type =="percentage")
		{
			//alert(nonmemb_discount);
			var non_memb_discount_price= disc_price * (nonmemb_discount/100);
			//alert(non_memb_discount_price);	
			document.getElementById("nonmemb_discount_price").value=non_memb_discount_price;
			
			alert(non_memb_discount_price);
		}
		else
		{
			var non_memb_discount_price=nonmemb_discount;
			document.getElementById("nonmemb_discount_price").value=non_memb_discount_price;
			
		}
		
		var price=disc_price - non_memb_discount_price;
		//alert(price);
	}
	else
	{
		var price=disc_price;
		//alert(price);
	}*/
	
	/*var service_tax= document.getElementById('service_taxes').value;
	var service_tax__price= parseFloat(disc_price * (service_tax/100));
	document.getElementById('service_tax').value=service_tax__price;*/
	//==============================TOTAL GST ==================================
	/* 1/12/17 var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
	var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
	var totalgst=cgsttax+sgsttax;
	
	var new_total_tax=parseFloat((totalgst+100)/100);
	var total_taxable_value = parseInt(disc_price / new_total_tax);
	var total_gst =parseInt(disc_price - total_taxable_value);*/
	frm = document.jqueryForm; 
	<?php
	if($_SESSION['tax_type']=='GST')
	{
		?>
		gst_show =frm.apply_gst.value;
		gst_type =frm.gst_type.value;
		//var gst_show=document.getElementById('apply_gst').value;
		//alert(gst_show);
		if(gst_show=='yes')
		{
			//==================CHANGES==========================1-12-17
			var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
			var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
			var igsttax=parseFloat(document.getElementById('igst_taxes').value);
			
			if(gst_type=='m_gst')
			{
				document.getElementById('igst_tax').value=0;//Math.round
				var totalgst=cgsttax+sgsttax;
						
				//$Original_Cost = $val_query['net_fees'] * 100/(100 + $total_gst_per);
				//var total_gst=parseFloat(disc_price * (totalgst/100));
				var total_gst=parseFloat(disc_price * (totalgst/100));
				
				//==============================================================
				//document.getElementById('total_gst').value=total_gst;
				//==========================================================================
				//==============================For CGST====================================
				/*var cgst=parseFloat(document.getElementById('cgst_taxes').value);
				var new_cgst_tax=parseFloat(disc_price * (cgst/100));*/
				new_cgst_tax=parseFloat(total_gst/2);
				document.getElementById('cgst_tax').value=roundNumber(new_cgst_tax,3);//Math.round
				//==========================================================================
				
				//==============================For SGST====================================
				/*var sgst=parseFloat(document.getElementById('sgst_taxes').value);
				var new_sgst_tax=parseFloat(disc_price * (sgst/100));*/
				new_sgst_tax=parseFloat(total_gst/2);
				document.getElementById('sgst_tax').value=roundNumber(new_sgst_tax,3);//Math.round
				//=========================================================================
				var new_tax=roundNumber(total_gst,3);
			}
			else
			{
				document.getElementById('cgst_tax').value=0;
				document.getElementById('sgst_tax').value=0;
				
				var totalgst=igsttax;
				
				var total_gst= disc_price * totalgst /(100 + totalgst);
				//var total_gst=parseFloat(disc_price * (totalgst/100));
				new_igst_tax=parseFloat(total_gst);
				document.getElementById('igst_tax').value=roundNumber(new_igst_tax,3);//Math.round
				var new_tax=roundNumber(new_igst_tax,3);
			}
			
		}
		else if(gst_show=='included')
		{
			//==================CHANGES==========================1-12-17
			var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
			var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
			var igsttax=parseFloat(document.getElementById('igst_taxes').value);
			
			if(gst_type=='m_gst')
			{
				document.getElementById('igst_tax').value=0;
				
				var totalgst=cgsttax+sgsttax;
				var excluded_tax=0;
				var total_gst= disc_price * totalgst /(100 + totalgst);
				//var total_gst=parseFloat(disc_price * (totalgst/100));
				//==============================================================
				//document.getElementById('total_gst').value=total_gst;
				//==========================================================================
				//==============================For CGST====================================
				/*var cgst=parseFloat(document.getElementById('cgst_taxes').value);
				var new_cgst_tax=parseFloat(disc_price * (cgst/100));*/
				new_cgst_tax=parseFloat(total_gst/2);
				document.getElementById('cgst_tax').value=roundNumber(new_cgst_tax,3);//Math.round
				//==========================================================================
				
				//==============================For SGST====================================
				/*var sgst=parseFloat(document.getElementById('sgst_taxes').value);
				var new_sgst_tax=parseFloat(disc_price * (sgst/100));*/
				new_sgst_tax=parseFloat(total_gst/2);
				document.getElementById('sgst_tax').value=roundNumber(new_sgst_tax,3);//Math.round
				//=========================================================================
				 excluded_tax=roundNumber(parseFloat(disc_price)-parseFloat(total_gst),3);
				document.getElementById('excluded_tax').value=excluded_tax;
				//alert(excluded_tax);
				var new_tax=0;
			}
			else
			{
				document.getElementById('cgst_tax').value=0;
				document.getElementById('sgst_tax').value=0;
				
				var totalgst=igsttax;
				var excluded_tax=0;
				var total_gst= disc_price * totalgst /(100 + totalgst);
				//var total_gst=parseFloat(disc_price * (totalgst/100));
				
				new_igst_tax=parseFloat(total_gst);
				document.getElementById('igst_tax').value=roundNumber(new_igst_tax,3);//Math.round
				
				
				excluded_tax=roundNumber(parseFloat(disc_price)-(parseFloat(new_igst_tax)),3);
				document.getElementById('excluded_tax').value=excluded_tax;
				//alert(excluded_tax);
				var new_tax=0;
			}
		}
		else
		{
			document.getElementById('cgst_tax').value=0;
			document.getElementById('sgst_tax').value=0;
			document.getElementById('igst_tax').value=0;
			var new_tax=0;
		}
		<?php
	}
	else
	{
		?>
		vat_show =frm.apply_vat.value;
		//gst_type =frm.gst_type.value;
		//var gst_show=document.getElementById('apply_gst').value;
		//alert(gst_show);
		if(vat_show=='yes')
		{
			//==================CHANGES==========================1-12-17
			var vattax=parseFloat(document.getElementById('service_taxes').value);
			var totalgst=vattax;
			var total_gst= disc_price * totalgst /(100 + totalgst);
			new_vat_tax=parseFloat(total_gst);
			document.getElementById('service_tax').value=roundNumber(new_vat_tax,3);//Math.round
			var new_tax=roundNumber(total_gst,3);		
		}
		else if(vat_show=='included')
		{
			//==================CHANGES==========================1-12-17
			var vattax=parseFloat(document.getElementById('service_taxes').value);
			var totalgst=vattax;
			var excluded_tax=0;
			var total_gst= disc_price * totalgst /(100 + totalgst);
			new_vat_tax=parseFloat(total_gst);
			document.getElementById('service_tax').value=roundNumber(new_vat_tax,3);//Math.round
			
			excluded_tax=roundNumber(parseFloat(disc_price)-parseFloat(total_gst),3);
			document.getElementById('excluded_tax').value=excluded_tax;
			var new_tax=0;
			
		}
		else
		{
			document.getElementById('service_tax').value=0;
			var new_tax=0;
		}
		<?php
	}
	?>
	var total_cost = parseFloat(disc_price) +  parseFloat(new_tax);
	document.getElementById('total_cost').value=roundNumber(total_cost,3);
	document.getElementById('amount').value=roundNumber(total_cost,3);
	document.getElementById('remaining_amount').value=roundNumber(total_cost,3);
	//alert(discount_price);
	
	cal_remaining_amt();
}
</script>
<script language="javascript">
create_floor('add');

/*create_type1('add_type1');
create_type2('add_type2');*/

//create_floor_dependent();
</script>
<?php
if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
{
	?>
     <script>
	if(document.getElementById("branch_name"))
	{
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	}
	</script>
    <?php
}
if($record_id)
{
	?>
    <script>
	if(document.getElementById("customer_id"))
	{
	customer_id= document.getElementById("customer_id").value;
	getMembership(customer_id);
	}
</script>

<?php
}
if($record_id || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
{
	?>
    <script>
	/*if(document.getElementById("payment_mode"))
	{
		vals= document.getElementById("payment_mode").value;
		payment(vals);
	}*/
	</script>
	<?php
}
?>
<!--footer end-->
</body>
</html>