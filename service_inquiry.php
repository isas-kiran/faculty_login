<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
 $page_name = "service";
 $sele_sac_code="select sac_code from sac_code_config where page_name='".$page_name."'";
 $ptr_sac_code=mysql_query( $sele_sac_code);
 $data_sac_code=mysql_fetch_array($ptr_sac_code);
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM service_inquiry where inquiry_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
		$record_id=0;
}

$staff_prev=$_SESSION['staff_prev']; 
$prev_value="";
for($e=0;$e<count($staff_prev);$e++)
{
	if($staff_prev[$e]==178) 
	{
		$prev_value="and privilege_id='178'";
	}
}
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='178'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Service Enquiry</title>
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
    });
</script>
<script>
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
 
 
</script> 
<script>
function getMembership(cust_id)
{
	var data1="customer_id="+cust_id;
	var data2="customer_id="+cust_id;
	//alert(data2);
	 $.ajax({
	url: "get_mail.php", type: "post", data: data2, cache: false,
	success: function (html)
	{
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
					var sep_val=html.split("-");
					var memb_name= sep_val[0].trim();
					var memb_disc= sep_val[1].trim();
					//alert(memb_disc);
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
		 $( ".new_custom_course" ).dialog({
                                        width: '500',
                                        height:'300'
                                    });
	}
	return false;
}
function getprice(values,val_idss)
{
	//alert(val_idss);
	var service_id=document.getElementById('service_id'+val_idss).value;
	//alert(service_id)			
	var data1="service_id="+service_id;	
	//alert(data1);
        $.ajax({
            url: "get_service_price.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				service_split=html.split("-");
				document.getElementById("sin_service_price"+val_idss).value=service_split[0];
				document.getElementById("sin_service_time"+val_idss).value=service_split[1];
				document.getElementById("sin_service_total"+val_idss).value=service_split[0];
				document.getElementById("sin_service_qty"+val_idss).value=1;
				var exit_disc=document.getElementById("sin_service_disc"+val_idss).value = 0;
				var exit_disc_price=document.getElementById("sin_service_disc_price"+val_idss).value = 0;
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
				document.getElementById("sin_service_total"+val_idss).disabled = true;
				document.getElementById("sin_service_qty"+val_idss).disabled = true;
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
}
function calc_service_price(idss)
{
	frm = document.jqueryForm;  
	service_price=parseFloat(document.getElementById("sin_service_price"+idss).value);
	qty=parseInt(document.getElementById("sin_service_qty"+idss).value);
	total_price=parseFloat(service_price*qty);
	disc_val=parseFloat(document.getElementById("sin_service_disc"+idss).value);
	document.getElementById("sin_total"+idss).value=total_price;
	document.getElementById("sin_service_total"+idss).value=total_price;
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
	/*var bank_data="action=service&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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
	});*/
	var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		//service_tax= taxes[0];
		//installment_tax= taxes[1];
		/*document.getElementById("service_tax_id").innerHTML=service_tax;
		document.getElementById("service_taxes").value=service_tax;*/
		cgst=taxes[2];
		sgst=taxes[3];
		
		document.getElementById("cgst_id").innerHTML=cgst;
		document.getElementById("sgst_id").innerHTML=sgst;
		document.getElementById("cgst_taxes").value=cgst;
		document.getElementById("sgst_taxes").value=sgst;
	}
	});
	setTimeout(showUser,1000);
}
/*function show_bank_for_payment_mode(branch_id,vals)
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
	
}*/
</script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='178'";
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
if($_SESSION['type']!='S'  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' )
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
//var payable_amount =document.getElementById('payable_amount').value;
//var remaining_amount =document.getElementById('remaining_amount').value;
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
	url:'send_email_inq.php',type:"post",data:data1,cache:false,crossDomain:true,async:false,
	success: function(response)
	{
		//alert(response);
		return true;
	}
	});

}

</script>
<script>
/*function payment(value)
{
	payment_mode=value.split("-")
	//alert(payment_mode[0]);
	var branch_name=document.getElementById("branch_name").value;
	if(payment_mode[0]=="cheque")
	{
		document.getElementById("chaque_details").style.display = 'block';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		//document.getElementById("voucher_no").style.display = 'none';
		//document.getElementById("voucher_div_id").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		//document.getElementById("voucher_no").style.display = 'none';
		//document.getElementById("voucher_div_id").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"credit_card")
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		//document.getElementById("voucher_no").style.display = 'none';
		//document.getElementById("voucher_div_id").style.display = 'none';
		show_bank(branch_name,"paytm")
	}
	
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
	
}*/
function show_time(cur_time)
{
	var start_time_hr=document.getElementById("start_time_hr").value;
	//alert(start_time_hr);
	
	var start_time_min=document.getElementById("start_time_min").value;
	//alert(start_time_min)
	
	var time = ((start_time_hr<=9) ? "0"+start_time_hr : start_time_hr) + ":" + ((start_time_min<=9) ? "0" + start_time_min : start_time_min);
	//Total start time selected in 00:00:00 format. For hours and minutes less than 9, the function adds a 0 before the number.
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
								//document.getElementById("remaining_amount").value=Math.abs(total);
								document.getElementById("total_remaining_amnt"+id).value=Math.abs(total);
							}
							else
							{ 
								document.getElementById("total_price"+id).innerHTML=0;
								document.getElementById("remaining_amnt_in_voucher"+id).value=Math.abs(total);
								document.getElementById("remaining_total"+id).innerHTML=Math.abs(total);
								document.getElementById("amount").value=0;
								//document.getElementById("remaining_amount").value=0;
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
			//document.getElementById("remaining_amount").value=remaining_amnt;
			
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
			//document.getElementById("remaining_amount").value=remaining_amnt;
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
								//document.getElementById("remaining_amount").value=remaining_amnt;
							}
							else
							{
								remaining_amnt=document.getElementById("total_cost").value;
								document.getElementById("amount").value=remaining_amnt;
								//document.getElementById("remaining_amount").value=remaining_amnt;
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
				//document.getElementById("remaining_amount").value=Math.abs(total);
			}
			else
			{
				document.getElementById("amount").value=0;
				//document.getElementById("remaining_amount").value=0;
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
	/*	var final_amt=Number(document.getElementById('amount').value);
		var payable_amt=Number(document.getElementById('payable_amount').value);
		if(payable_amt > final_amt)
		{
		  alert("Payable Amount should not be greater than Final amount..");
		  document.getElementById("payable_amount").value=0;	
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
		cal_tot_re=Math.round(cal_tot_rem_amt);*/
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
	 if(frm.name.value=='')
	 {
		 disp_error +='Enter Customer Name\n';
		 document.getElementById('name').style.border = '1px solid #f00';
		 frm.name.focus();
		 error='yes';
	 }
	 if(frm.enquiry_src.value=='')
	 {
		 disp_error +='Select Enquiry Source Name\n';
		 document.getElementById('enquiry_src').style.border = '1px solid #f00';
		 frm.enquiry_src.focus();
		 error='yes';
	 }
	 if(frm.followup_date.value=='')
	 {
		 disp_error +='Select Next Followup Date\n';
		 document.getElementById('followup_date').style.border = '1px solid #f00';
		 frm.followup_date.focus();
		 error='yes';
	 }
	 if(frm.followup_desc.value=='')
	 {
		 disp_error +='Enter Followup Decription\n';
		 document.getElementById('followup_desc').style.border = '1px solid #f00';
		 frm.followup_desc.focus();
		 error='yes';
	 }
	 if(frm.response.value=='')
	 {
		 disp_error +='Select Response Category\n';
		 document.getElementById('response').style.border = '1px solid #f00';
		 frm.response.focus();
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
</style>
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>
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
							$inquiry_date=( ($_POST['inquiry_date'])) ? $_POST['inquiry_date'] : "";
							if($inquiry_date !='')
							{
								$seps_date = explode('/',$inquiry_date);
								$inquiry_date = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
							}
							else
								$inquiry_date='';
							$branch_name= ($_POST['branch_name']) ? $_POST['branch_name'] : "";
							$lead_category=($_POST['lead_category'])? $_POST['lead_category'] : "";
							$name=($_POST['name']) ? $_POST['name'] : "";
							$mobile=( ($_POST['mobile'])) ? $_POST['mobile'] : "";
							$email_id=( ($_POST['email_id'])) ? $_POST['email_id'] : "";
							$service_price=( ($_POST['service_price'])) ? $_POST['service_price'] : "";
							$nonmemb_discount_type=( ($_POST['nonmemb_discount_type'])) ? $_POST['nonmemb_discount_type'] : "";
							$nonmemb_discount=( ($_POST['nonmemb_discount'])) ? $_POST['nonmemb_discount'] : "";
							$nonmemb_discount_price=( ($_POST['nonmemb_discount_price'])) ? $_POST['nonmemb_discount_price'] : "";
							$cgst_tax=( ($_POST['cgst_tax'])) ? $_POST['cgst_tax'] : "";
							$cgst_tax_in_per=( ($_POST['cgst_taxes'])) ? $_POST['cgst_taxes'] : "";
							$sgst_tax=( ($_POST['sgst_tax'])) ? $_POST['sgst_tax'] : "";
							$sgst_tax_in_per=( ($_POST['sgst_taxes'])) ? $_POST['sgst_taxes'] : "";
							$total_cost=( ($_POST['total_cost'])) ? $_POST['total_cost'] : "";
							$amount=( ($_POST['amount'])) ? $_POST['amount'] : "";
							$enquiry_src=( ($_POST['enquiry_src'])) ? $_POST['enquiry_src'] : "";
							$remark=( ($_POST['remark'])) ? $_POST['remark'] : "";
							$followup_date1=( ($_POST['followup_date'])) ? $_POST['followup_date'] : "";
							$apply_gst=( ($_POST['apply_gst'])) ? $_POST['apply_gst'] : "";
							if($followup_date1 !='')
							{
								$seps_date = explode('/',$followup_date1);
								$followup_date1 = $seps_date[2].'-'.$seps_date[1].'-'.$seps_date[0];
							}
							else
								$followup_date1='';
							
							$lead_category_followup=( ($_POST['lead_category_followup'])) ? $_POST['lead_category_followup'] : "";
							$followup_desc=( ($_POST['followup_desc'])) ? $_POST['followup_desc'] : "";
							$lead_grade=( ($_POST['lead_grade'])) ? $_POST['lead_grade'] : "";
							$response=( ($_POST['response'])) ? $_POST['response'] : "";
							$employee_id=( ($_POST['employee_id'])) ? $_POST['employee_id'] : "0";
							$cm_id='0';
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								
								$cm_ids=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_ids;
								$cm_id=$cm_ids;
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
								$cm_id=$_SESSION['cm_id'];
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
								$data_record['inquiry_date']=$inquiry_date;
                                $data_record['lead_category'] =$lead_category;
                                $data_record['name'] =$name;
								$data_record['mobile'] =$mobile;
								$data_record['email_id'] =$email_id;
								$data_record['service_price'] =$service_price;
								$data_record['nonmemb_discount_type']=$nonmemb_discount_type;
								$data_record['nonmemb_discount']=$nonmemb_discount;
								$data_record['nonmemb_discount_price']=$nonmemb_discount_price;
								$data_record['cgst_tax']=$cgst_tax;
								$data_record['sgst_tax']=$sgst_tax;
								$data_record['cgst_tax_in_percent']=$cgst_tax_in_per;
								$data_record['sgst_tax_in_percent']=$sgst_tax_in_per;
								$data_record['total_cost'] =$total_cost;
								$data_record['amount'] =$amount;
								$data_record['enquiry_src'] =$enquiry_src;
								$data_record['remark'] =$remark;
								$data_record['followup_date'] =$followup_date1;
								$data_record['lead_category_followup'] =$lead_category_followup;
								$data_record['followup_desc'] =$followup_desc;
								$data_record['lead_grade'] =$lead_grade;
								$data_record['response'] =$response;
								$data_record['added_date']=date('Y-m-d');
								$data_record['staff_id'] =$employee_id;
								$data_record['admin_id'] =$_SESSION['admin_id'];
								$total_floor=$_POST['floor'];
								$data_record['apply_gst'] =$apply_gst;
								if($record_id)
								{
									$where_record=" inquiry_id='".$record_id."'";
									$db->query_update("service_inquiry", $data_record,$where_record);
									//echo "total_floor->".$total_floor;
									for($z=1;$z<=$total_floor;$z++)
									{
										//echo "Floor- ". $_POST['del_floor'.$z]."<br />";
										"<br />floor_id- ".$_POST['floor_id'.$z];
										if($_POST['del_floor'.$z]=='yes')
										{
											if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
											{
												$delete_row = " delete from service_inquiry_map where service_inquiry_map_id='".$_POST['floor_id'.$z]."' ";
												$ptr_delete = mysql_query($delete_row);
											}
										}
										//echo "<br/>".$_POST['del_floor'.$z];
										if($_POST['del_floor'.$z] !='yes')
									  	{
											$data_record_service['inquiry_id'] =$record_id; 
											$data_record_service['service_id'] =$_POST['service_id'.$z];
											$data_record_service['service_price'] =$_POST['sin_service_price'.$z];
											$data_record_service['service_quantity'] =$_POST['sin_service_qty'.$z];
											$data_record_service['service_quantity_price'] =$_POST['sin_total'.$z];
											$data_record_service['discount'] =$_POST['sin_service_disc'.$z];
											$data_record_service['discount_price'] =$_POST['sin_service_disc_price'.$z];
											$data_record_service['total_price'] =$_POST['sin_service_total'.$z];
											$data_record_service['service_time'] =$_POST['sin_service_time'.$z];
											$data_record_service['admin_id'] =$_POST['staff_id'.$z];
											
											if($_POST['floor_id'.$z]=='' && $_POST['service_id'.$z] !='')
											{
												 $type1_id=$db->query_insert("service_inquiry_map", $data_record_service);
											}
											else
											{
												$where_map_record="service_inquiry_map_id='".$_POST['floor_id'.$z]."'";
												$floor_id= $_POST['floor_id'.$z];
												$db->query_update("service_inquiry_map", $data_record_service,$where_map_record);
											}
											unset($data_record_service);
									   	}
									}
                               		// echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
									?><div id="statusChangesDiv" title="Record Updated"><center><br><p>Record updated successfully</p></center></div>
										<script type="text/javascript">
                                            $(document).ready(function() {
                                                $( "#statusChangesDiv" ).dialog({
                                                        modal: true,
                                                        buttons: {
                                                                    Ok: function() { $( this ).dialog( "close" );}
                                                                 }
                                                });
                                                
                                            });
                                           //setTimeout('document.location.href="manage_service_inquiry.php";',500);
                                        </script>
                                    <?php

								}
								else
								{
									$data_record['status'] ="Enquiry";
									$record_id=$db->query_insert("service_inquiry", $data_record);
									for($i=1;$i<=$total_floor;$i++)
									{
										if($_POST['service_id'.$i] !='')
										{
											$data_record_service['inquiry_id'] =$record_id; 
											$data_record_service['service_id'] =$_POST['service_id'.$i];
											$data_record_service['service_price'] =$_POST['sin_service_price'.$i];
											$data_record_service['service_quantity'] =$_POST['sin_service_qty'.$i];
											$data_record_service['service_quantity_price'] =$_POST['sin_total'.$i];
											$data_record_service['discount'] =$_POST['sin_service_disc'.$i];
											$data_record_service['discount_price'] =$_POST['sin_service_disc_price'.$i];
											$data_record_service['total_price'] =$_POST['sin_service_total'.$i];
											$data_record_service['service_time'] =$_POST['sin_service_time'.$i];
											$data_record_service['admin_id'] =$_POST['staff_id'.$i];
											$customer_service_id=$db->query_insert("service_inquiry_map", $data_record_service);
										}
									}
									$insert_followup = "INSERT INTO `service_followup_details` (`inquiry_id`,`lead_category_followup`,`followup_date`,`followup_details`,`response`,`lead_grade`, `added_date`, `cm_id`, `admin_id`)VALUES ('$record_id','$lead_category_followup', '$followup_date1','$followup_desc','".$response."','$lead_grade','".date('Y-m-d H:i:s')."','".$cm_id."','".$_SESSION['admin_id']."')";
									$ptr_followup = mysql_query($insert_followup);
									//=============SMS Send================
									
									$name=$data_record['name'];
									$contact=$data_record['mobile'];
									$mesg ="Hi ".$name." your inquiry for service is book";
									$sel_inq="select sms_text from previleges where privilege_id='178'";
									$ptr_inq=mysql_query($sel_inq);
									$txt_msg='';
									if(mysql_num_rows($ptr_query))
									{
										$dta_msg=mysql_fetch_array($ptr_inq);
										$txt_msg=$dta_msg['sms_text'];
									}
									$messagessss =$mesg.$txt_msg;
									"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='178'";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select contact_phone from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											//send_sms_function($data_cnt['contact_phone'],$messagessss);
										}
									}
									if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'  )
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
									//send_sms_function($contact,$messagessss);
									
									if($status=="Completed")
									{
									?>
                                    	<script>
                                		//window.open('invoice-service.php?record_id=<?php echo $record_id; ?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900, height=600,directories=no,location=no');
										</script>
                                    <?php
									}
									else
									{
										?>
                                    	<script>
                                		//window.open('job-card-generate.php?record_id=<?php echo $record_id; ?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900, height=600,directories=no,location=no');
										</script>
                                    <?php
									}
									//echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									?><div id="statusChangesDiv" title="Record Added"><center><br><p>Record Added successfully </p></center></div>
										<script type="text/javascript">
                                            $(document).ready(function() {
                                                $( "#statusChangesDiv" ).dialog({
                                                        modal: true,
                                                        buttons: {
                                                                    Ok: function() { $( this ).dialog( "close" );}
																	
                                                                 }
                                                });
                                            });
                                       setTimeout('document.location.href="manage_service_inquiry.php";',1000);
                                        </script>
                                    <?php
								}
							}
                        }
                        if($success==0)
                        {
                        ?>
						
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" onSubmit="return validme()" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>	
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                <input type="hidden" id="excluded_tax" name="excluded_tax" value="">
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
						echo ' <select id="branch_name" class="input_select" name="branch_name" onchange="show_bank(this.value)">';
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
				<td width="22%">Inquiry Date<span class="orange_font"></span></td>
				<td width="44%"><input type="text" style="300px" class="input_text datepicker" name="inquiry_date" id="inquiry_date" 	value="<?php 
				if($_POST['inquiry_date']) 
				echo $_POST['inquiry_date']; 
				else if($row_record['inquiry_date'] !='')
				{
					$arrage_datesa= explode(' ',$row_record['inquiry_date']);     
					$arrage_date= explode('-',$arrage_datesa[0],3);     
					echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; 
				}else echo date('d/m/Y')?>" />
				</td>
				<td width="34%"></td>
			</tr>
			<tr>
				<td width="22%">Lead Category<span class="orange_font">*</span></td>
				<td width="44%"><input type="radio" name ="lead_category" id="lead_category" checked="checked" value="phone" <?php if($_POST['lead_category'] == "phone") echo 'checked="checked"'; else if($row_record['lead_category'] == "phone") echo 'checked="checked"'; ?> /> Phone 
				<input type="radio" name ="lead_category" id="lead_category" value="walkin" <?php if($_POST['lead_category'] == "walkin") echo 'checked="checked"'; else if($row_record['lead_category'] == "walkin") echo 'checked="checked"'; ?> /> Walked-in</td>
			</tr>
			<tr>
				<td width="22%" valign="top">Customer Name<span class="orange_font">*</span></td>
				<td width="40%"><input type="text" style="300px" class="input_text" name="name" id="name" value="<?php if($_POST['name']) echo $_POST['name']; else echo $row_record['name'];?>" ></td>
			</tr>
			<tr>
				<td width="22%" valign="top">Mobile No.<span class="orange_font">*</span></td>
				<td width="40%"><input type="text" class="input_text" name="mobile" id="mobile" value="<?php if($_POST['mobile']) echo $_POST['mobile']; else echo $row_record['mobile'];?>" ></td>
			</tr>
			<tr>
				<td width="22%" valign="top">Email Id<span class="orange_font"></span></td>
				<td width="40%"><input type="text" class="input_text" name="email_id" id="email_id" value="<?php if($_POST['email_id']) echo $_POST['email_id']; else echo $row_record['email_id'];?>"></td>
			</tr>
			
			<tr>
            	<td width="10%">Select Service<span class="orange_font"></span></td>
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
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="18%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="service_id'+idss+'" id="service_id'+idss+'" style="width:175px" onChange="getprice(this.value,'+idss+')"><option value="">Select Service</option><?php
									$sel_tel = "select service_id,service_name,service_price,service_time from servies order by service_id asc";	 
									$query_tel = mysql_query($sel_tel);
									if($total=mysql_num_rows($query_tel))
									{
										while($data=mysql_fetch_array($query_tel))
										{
											echo '<option value="'.$data['service_id'].'">'.addslashes($data['service_name']) ." &nbsp;&nbsp;&nbsp;       (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time']." min)".'</option>';
										}
									}
									 ?>
									 </select></td><td width="5%" align="center"><input type="text" disabled="disabled" name="sin_service_price'+idss+'" id="sin_service_price'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:60px" /></td><td width="5%" align="center"><input type="text" disabled="disabled" name="sin_service_qty'+idss+'" id="sin_service_qty'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:60px" /><input type="hidden" name="sin_total'+idss+'" id="sin_total'+idss+'"></td><td width="12%" align="center"><input type="text" name="sin_service_disc'+idss+'" id="sin_service_disc'+idss+'" onkeyup="getDiscount(this.value,'+idss+')"  disabled="disabled" style=" width:80px" /><input type="hidden" name="sin_service_disc_price'+idss+'" id="sin_service_disc_price'+idss+'" /></td><td width="8%" align="center"><input type="text" disabled="disabled" onkeyup="calc_service_price('+idss+')" name="sin_service_total'+idss+'" id="sin_service_total'+idss+'" style=" width:80px"><input type="hidden" disabled="disabled" name="sin_service_time'+idss+'" id="sin_service_time'+idss+'" style=" width:100px" /></td><td width="15%" align="center"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:90%"><option value="">Select Staff</option><?php
									if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
									{
										$sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$_SESSION['where']." ".$prev_value."";
										$ptr_id=mysql_query($sel_prev_id);
										if(mysql_num_rows($ptr_id))
										{
											while($data_prev_id=mysql_fetch_array($ptr_id))
											{
												$sel_staff = "select admin_id,name from site_setting where 1 and admin_id='".$data_prev_id['admin_id']."' ".$_SESSION['where']." order by admin_id asc";	
												$query_staff = mysql_query($sel_staff);
												if(mysql_num_rows($query_staff))
												{
													$data=mysql_fetch_array($query_staff);
													echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
												}
												
											}
										}
									}
									 ?>
									 </select></td><td valign="top" width="3%" align="center"><input type="hidden" name="total_services[]" id="total_services'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                                
                        </script>
                       <td align="right"><input type="button"  name="Add"s class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
    <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
    </td></tr>
                            <tr><td>  </td><td align="left"></td></tr>
                    </table> 
                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
    <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
    <tr>
                        <td colspan="7">
                        <table cellspacing="3" id="tbl" width="100%">
                        <tr>
                        <td valign="top" width="25%" align="center">Service Name</td>
                        <td valign="top" width="10%"  align="center">Price</td>
                        <td valign="top" width="10%"  align="center">Quantity</td>
                        <td valign="top" width="15%"  align="center">Discount (in %)<br />
                        
                        <input type="radio" name="discount" id="discount" checked="checked" value="percentage" <?php if($_POST['discount']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="discount" id="discount" value="rupees" <?php if($_POST['discount']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in <?php if($_SESSION['tax_type']=='GST') echo 'Rs -/'; else echo 'AED'; ?>
                        </td>
                        <td valign="top" width="15%"  align="center">Total Price</td>
                        <!--<td valign="top" width="6%"  align="center">Time(in Min.)</td>-->
                        <td valign="top" width="20%"  align="center">Staff</td>
                       
                        <td valign="top" width="5%"  align="center">Acton</td>
                        </tr>
                        <tr>
                            <td colspan="7">
							<?php
							if($record_id)
							{
                            $select_exc = "select * from service_inquiry_map where inquiry_id='".$record_id."' order by service_inquiry_map_id asc ";
                            $ptr_fs = mysql_query($select_exc);
                            $t=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs))
                            { 
                                $slab_id= $data_exclusive['service_inquiry_map_id'];
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
										echo '<option value="'.$data['service_id'].'" '.$selected.'>'.addslashes($data['service_name'])."   (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time'].")".'</option>';
									}
								}
								?>
								</select></td>
                            	<td width="8%" align="center"><input type="text" name="sin_service_price<?php echo $t; ?>" onkeyup="calc_service_price('<?php echo $t; ?>')" id="sin_service_price<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['service_price'] ?>" /></td><td width="5%" align="center"><input type="text" name="sin_service_qty<?php echo $t; ?>" id="sin_service_qty<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px" value="<?php echo $data_exclusive['service_quantity'] ?>" /><input type="hidden" name="sin_total<?php echo $t; ?>" id="sin_total<?php echo $t; ?>" value="<?php echo $data_exclusive['service_quantity_price'] ?>"></td><td width="8%" align="center"><input type="text" name="sin_service_disc<?php echo $t; ?>" id="sin_service_disc<?php echo $t; ?>" value="<?php echo $data_exclusive['discount'] ?>" onKeyUp="getDiscount(this.value,<?php echo $t; ?>)"  style=" width:100px" /><input type="hidden" name="sin_service_disc_price<?php echo $t; ?>" id="sin_service_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['discount_price'] ?>" /></td><td width="8%" align="center"><input type="text"  name="sin_service_total<?php echo $t; ?>" onkeyup="calc_service_price('<?php echo $t; ?>')" id="sin_service_total<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['total_price'] ?>"><input type="hidden"name="sin_service_time<?php echo $t; ?>" id="sin_service_time<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['service_time'] ?>" /></td><td width="10%"><select name="staff_id<?php echo $t; ?>" id="staff_id<?php echo $t; ?>" style="width:90%"><option value="">Select Staff</option><?php
								$sel_staff = "select admin_id,name from site_setting order by admin_id asc";	 
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
								}
								?>
								</select></td>
                                <td valign="top" width="10%" align="center">
                           		<?php
					 			if($record_id)
					 			{
									?>
                        			<input type="hidden" name="total_services[]" id="total_services<?php echo $t; ?>" />
                            		<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['service_inquiry_map_id'] ?>" />
                            		<input type="button" title="Delete Options(-)" onClick="delete_service(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
                            		<input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
               				<?php } ?>   
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
                         <input type="hidden" name="floor" id="floor"  value="<?php echo $total_conditions; ?>" />
                        <div id="create_floor"></div>
                    </td></tr></table>
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
             </td>
         </tr>
             <tr>
                <td width="20%" valign="top">Service Price</td>
                <td width="70%"><input type="text"  class=" input_text" name="service_price" id="service_price"  value="<?php if($_POST['service_price']) echo $_POST['service_price']; else echo $row_record['service_price'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            
            <tr>
            	<td width="20%" valign="top">Discount<input type="radio" name="nonmemb_discount_type" onChange="showUser()" id="nonmemb_discount_type" checked="checked" value="percentage" <?php if($_POST['nonmemb_discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="nonmemb_discount_type" id="nonmemb_discount_type" onChange="showUser()" value="rupees" <?php if($_POST['nonmemb_discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="rupees") { echo 'checked="checked"';} ?> />in <?php if($_SESSION['tax_type']=='GST') echo 'Rs -/'; else echo 'AED'; ?></td>
                
            	<td width="72%"><input type="text" class=" input_text" name="nonmemb_discount" id="nonmemb_discount" onBlur="showUser()" value="<?php if($_POST['nonmemb_discount']){echo $_POST['nonmemb_discount'];} else {echo $row_record['nonmemb_discount'];}?>" /></td> 
            	<td width="5%"></td>
            </tr>
			<tr>
				<td colspan="2">
					<div id="loyalty_points_id" style="display:none"></div>
				</td>
			</tr>
            <tr>
            	<td width="20%" valign="top">Discounted Price</td>
            	<td width="72%"><input type="text" class=" input_text" name="nonmemb_discount_price" id="nonmemb_discount_price" value="<?php if($_POST['nonmemb_discount_price']) echo $_POST['nonmemb_discount_price']; else echo $row_record['nonmemb_discount_price'];?>" /></td> 
            	<td width="5%"></td>
            </tr>
            <tr>
                <td width="15%" valign="top">Apply GST <?php echo $row_record['apply_gst']; ?><span class="orange_font">*</span></td>
                <td width="70%"><input type="radio" class="input_radio" name="apply_gst" id="apply_gst"  onclick="showUser()" value="included" <?php if($_POST['apply_gst']=='included') echo 'checked="checked"'; else if($row_record['apply_gst']=='included') echo 'checked="checked"'; else if ($record_id =='' && $row_record['apply_gst'] =='') echo 'checked="checked"';  ?> />Included &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="apply_gst" id="apply_gst"  onclick="showUser()" value="yes" <?php if($_POST['apply_gst']=='yes') echo 'checked="checked"'; else if($row_record['apply_gst']=='yes') echo 'checked="checked"'; ?> />Yes &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="apply_gst" id="apply_gst" onclick="showUser()" value="no" <?php if($_POST['apply_gst']=='no') echo 'checked="checked"'; else if($row_record['apply_gst']=='no') echo 'checked="checked"'; ?>/>No</td> 
                <td width="10%"></td>
            </tr>
			<tr>      
                  <td width="20%" class="heading">CGST <span id="cgst_id"><?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="cgst_taxes" name="cgst_taxes" value="<?php if($_SESSION['type']!='S'  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['cgst'];} ?>"  />
                  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="cgst_tax" id="cgst_tax"  value="<?php if($_POST['cgst_tax']) echo $_POST['cgst_tax']; else echo $row_record['cgst_tax'];?>" /></td>
            </tr>
            <tr>      
                  <td width="20%" class="heading">SGST <span id="sgst_id"><?php if($_SESSION['type']!='S'  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="sgst_taxes" name="sgst_taxes" value="<?php if($_SESSION['type']!='S'  && $_SESSION['type']!='Z' && $_SESSION['type']!='LD'){ echo $_SESSION['sgst'];} ?>"  />
                  <td><input type="text" class="validate[required] input_text" readonly="readonly" name="sgst_tax" id="sgst_tax"  value="<?php if($_POST['sgst_tax']) echo $_POST['sgst_tax']; else echo $row_record['sgst_tax'];?>" /></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Total Cost<span class="orange_font"></span></td>
                <td width="70%"><input type="text"  class=" input_text" name="total_cost" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>" /></td> 
                <td width="10%"></td>
            </tr>
			<tr>
				<td width="" class="tr-header">Amount<span class="orange_font"></span></td>
				<td width=""><input type="text" name="amount" class=" input_text" id="amount" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount']; ?>"  /></td>
				<td width="10%"><input type="hidden" name="remaining_voucher" id="remaining_voucher" value="0"  /></td>
			</tr>
			<tr>
				<td width="22%" class="heading">Enquiry Source<span class="orange_font">*</span></td>
				<td><select id="enquiry_src" class=" input_select" name="enquiry_src">
				<option value="">----Select----</option>
				
                <?php 
					$course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
					$ptr_course_cat = mysql_query($course_category);
					while($data_cat = mysql_fetch_array($ptr_course_cat))
					{
						echo " <optgroup label='".$data_cat['branch_name']."'>";
						$sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='service' ";
						$ptr_src=mysql_query($sel_source);
						while($data_src=mysql_fetch_array($ptr_src))
						{
							?>
							<option value = "<?php echo $data_src['campaign_id']?>" <? if($_POST['source'] == $data_src['campaign_id']) echo "selected"; else if ( $data_src['campaign_id'] == $row_record['enquiry_src']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
							<?
						}
						echo "</optgroup>";
					}?>
				</select>
				</td>
			</tr>
			<tr>
				<td width="22%" class="heading">Remark<span class="orange_font"></span></td>
				<td><textarea name="remark" class=" input_textarea" id="remark" ><?php if($_POST['remark']) echo $_POST['remark']; else echo $row_record['remark'];?></textarea></td>
			  </tr>
			<tr>
			<tr>
				<td width="22%" >Followup Description<span class="orange_font">*</span></td>
				<td width="44%" ><textarea name="followup_desc" class=" input_textarea" id="followup_desc" ><?php if($_POST['followup_desc']) echo $_POST['followup_desc']; else echo $row_record['followup_desc'];?></textarea></td>
			</tr>
			<tr>
				<td width="22%">Lead Grade<span class="orange_font">*</span></td>
				<td width="44%">
				<input type="radio" name ="lead_grade" id="lead_grade" value="very_hot" <?php if($_POST['lead_grade'] == "very_hot") echo 'checked="checked"';else if($row_record['lead_grade'] == "very_hot") echo 'checked="checked"'; else echo 'checked="checked"'; ?> /> Very Hot &nbsp;
				<input type="radio" name ="lead_grade" id="lead_grade" value="hot"  <?php if($_POST['lead_grade'] == "hot") echo 'checked="checked"';else if($row_record['lead_grade'] == "hot") echo 'checked="checked"'; ?> /> Hot &nbsp;
				<input type="radio" name ="lead_grade" id="lead_grade" value="warm" <?php if($_POST['lead_grade'] == "warm") echo 'checked="checked"'; else if($row_record['lead_grade'] == "warm") echo 'checked="checked"'; ?> /> Warm&nbsp;
				<input type="radio" name ="lead_grade" id="lead_grade" value="Nutral" <?php if($_POST['lead_grade'] == "Nutral") echo 'checked="checked"';else if($row_record['lead_grade'] == "Nutral") echo 'checked="checked"'; ?> /> Nutral&nbsp;
				<input type="radio" name ="lead_grade" id="lead_grade" value="cold" <?php if($_POST['lead_grade'] == "cold") echo 'checked="checked"';else if($row_record['lead_grade'] == "cold") echo 'checked="checked"'; ?> /> Cold
				</td>
			</tr>
			<tr>
				<td width="22%">Response Category<span class="orange_font">*</span></td>
				<td width="44%"><select id="response" class=" input_select" name="response">
				<option value="">--Select Resonse--</option>
				<?php 
				$sel_source="SELECT * FROM responce_category";
				$ptr_src=mysql_query($sel_source);
				while($data_src=mysql_fetch_array($ptr_src))
				{
					$sele_source="";
					if($data_src['responce_id'] == $row_record['response'] || $_POST['response']== $data_src['responce_id'] )
					{
						$sele_source='selected="selected"';
					}
					?>
					<option <?php echo $sele_source?> value = "<?php echo $data_src['responce_id']?>" <? if (isset($response) && $response == $data_src['responce_id']) echo "selected";?> > <?php echo $data_src['respnce_category_name'] ?> </option>
					<?
				}
				?>
				</select></td>
				<td width="34%"></td>
			</tr>
            <tr>
            	<td width="22%">Next Lead Category Followup<span class="orange_font">*</span></td>
                <td width="34%"><input type="radio" name ="lead_category_followup" id="lead_category_followup" checked="checked" value="phone_followup" <?php if($_POST['lead_category_followup'] == "phone_followup") echo 'checked="checked"'; else if($row_record['lead_category_followup'] == "phone_followup") echo 'checked="checked"'; ?> /> Phone Followup <input type="radio" name ="lead_category_followup" id="lead_category_followup" value="walkin_followup" <?php if($_POST['lead_category_followup'] == "walkin_followup") echo 'checked="checked"'; else if($row_record['lead_category_followup'] == "walkin_followup") echo 'checked="checked"'; ?> /> Walk-in Followup</td>
            </tr>
            <tr>
				<td width="22%">Next Followup Date<span class="orange_font">*</span></td>
				<td width="44%"><input type="text" style="width:200px" class="input_text datepicker" name="followup_date" id="followup_date" value="<?php if($_POST['followup_date']) echo $_POST['followup_date']; else { if($row_record['followup_date'] !=''){ $arrage_date= explode('-',$row_record['followup_date'],3); echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0]; }	}?>" /></td>
			</tr>
			<tr>
            	<td width="" class="tr-header" align="">Select Employee<span class="orange_font">*</span></td>
            	<td><select name="employee_id" id="employee_id" onChange="show_exist_time(this.value)">
             	<option value="">--Select--</option>
             	<?php
             	$sle_name="select admin_id,name from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." order by name  "; 
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
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn"  value="<?php if($record_id) echo "Update"; else echo "Add";?> Service" name="save_changes"  /></td>
                  <td></td>
            </tr>
        </table>
        </form>
        
         <script type="text/javascript">



            $(function() 

            {

                $(".custom_cuorse_submit").click(function(){
                    var cust_name = $("#cust_name").val();
                    var mobile1 = $("#mobile1").val();
                    var email = '';/*$("#email").val()*/
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
								getMembership()
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
                    <!--<tr>
                        <td>Email<span class="orange_font"></span></td>
                        <td><input type="text" class="inputText" name="email" id="email"></td>
                    </tr>-->
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
<div id="footer"><?php require("include/footer.php");?></div>
<!--footer end-->

<script language="javascript">
/*if($("#no_of_floor").val()==0)
{
create_floor('add');
}*/
</script>

<script>
function showUser(non_memb_disc)
{
	//alert("hiiii");
	contact=0;
	var total_service= document.getElementsByName("total_services[]");
	totals=total_service.length;
	for(i=1; i<=totals;i++)
	{
		//alert(i);
		servicesss_idddd=Number(document.getElementById("sin_service_total"+i).value);
		//alert(servicesss_idddd);
		record_id= document.getElementById("record_id").value;
		if(record_id !='')
		{
			$("#service_id"+i).chosen({allow_single_deselect:true});
			$("#staff_id"+i).chosen({allow_single_deselect:true});
		}
		
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
	
	var discount_price= 0;
	
	var total_discount_price=service_price;
	
	if(document.getElementById('nonmemb_discount').value)
	{	
		var nonmemb_discount= parseFloat(document.getElementById('nonmemb_discount').value);
	}
	else
	{
		var nonmemb_discount=0;
	}//var nonmemb_discount_type= parseFloat(document.getElementById('nonmemb_discount_type').value);
	frm = document.jqueryForm;  
	nonmemb_discount_type =frm.nonmemb_discount_type.value;
	
	if(nonmemb_discount !=0)
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
	
	if(nonmemb_discount_price !=0)
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
	
	//==============================For CGST====================================
	frm = document.jqueryForm; 
	gst_show =frm.apply_gst.value;
	if(gst_show=='yes')
	{
		//==============================For CGST====================================
		var cgst=parseFloat(document.getElementById('cgst_taxes').value);
		var new_cgst_tax=parseFloat(disc_price * (cgst/100));
		document.getElementById('cgst_tax').value=new_cgst_tax;
		//==========================================================================
		
		//==============================For SGST====================================
		var sgst=parseFloat(document.getElementById('sgst_taxes').value);
		var new_sgst_tax=parseFloat(disc_price * (sgst/100));
		document.getElementById('sgst_tax').value=new_sgst_tax;
		//=========================================================================
		var new_tax=parseFloat(new_cgst_tax)+parseFloat(new_sgst_tax);
		
	}
	else if(gst_show=='included')
	{
		//==================CHANGES==========================1-12-17
		var cgsttax=parseFloat(document.getElementById('cgst_taxes').value);
		var sgsttax=parseFloat(document.getElementById('sgst_taxes').value);
		var totalgst=cgsttax+sgsttax;
		var excluded_tax=0;
		var total_gst=parseFloat(disc_price * (totalgst/100));
		//==============================================================
		//document.getElementById('total_gst').value=total_gst;
		//==========================================================================
		//==============================For CGST====================================
		/*var cgst=parseFloat(document.getElementById('cgst_taxes').value);
		var new_cgst_tax=parseFloat(disc_price * (cgst/100));*/
		new_cgst_tax=parseFloat(total_gst/2);
		document.getElementById('cgst_tax').value=new_cgst_tax;//Math.round
		//==========================================================================
		
		//==============================For SGST====================================
		/*var sgst=parseFloat(document.getElementById('sgst_taxes').value);
		var new_sgst_tax=parseFloat(disc_price * (sgst/100));*/
		new_sgst_tax=parseFloat(total_gst/2);
		document.getElementById('sgst_tax').value=new_sgst_tax;//Math.round
		//=========================================================================
		 excluded_tax=parseFloat(disc_price)-(parseFloat(new_cgst_tax)+parseFloat(new_sgst_tax));
		document.getElementById('excluded_tax').value=excluded_tax;
		//alert(excluded_tax);
		var new_tax=0;
	}
	else
	{
		document.getElementById('cgst_tax').value=0;
		document.getElementById('sgst_tax').value=0;
		var new_tax=0;
	}	
	
	var total_cost =  parseFloat(disc_price) +  parseFloat( new_tax);
	document.getElementById('total_cost').value=total_cost;
	document.getElementById('amount').value=total_cost;
	//document.getElementById('remaining_amount').value=total_cost;
	//alert(discount_price);
	
	cal_remaining_amt();
}
</script>
<script language="javascript">
<?php 
if($record_id =='')
{
?>
create_floor('add');
<?php
}
?>
/*create_type1('add_type1');
create_type2('add_type2');*/

//create_floor_dependent();
</script>
<?php
if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
	if(document.getElementById("category"))
	{
		category= document.getElementById("category").value;
		//alert(category);
		show_category(category);
	}
</script>

<?php
}
if($record_id || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
</body>

</html>

<?php $db->close();?>