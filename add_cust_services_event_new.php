<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM customer_service where customer_service_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
		$record_id=0;
	$select_cost="SELECT cust_name,cust_id FROM customer where cust_id='".$row_record['customer_id']."'";
	$query_cust=mysql_query($select_cost);
	$fetch_cust=mysql_fetch_array($query_cust); 
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	$sel_acc_no="select account_no from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}
/*if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update servies set photo='' where service_id='".$record_id."'";
    echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../static_Page_photo/".$row_record['photo']))
        unlink("../static_Page_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?>Customer Service</title>
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
				document.getElementById("staff_id"+val_idss).disabled = false;
				$("#staff_id"+val_idss).chosen({allow_single_deselect:true});
			}
			else
			{
				document.getElementById("sin_service_price"+val_idss).disabled = true;
				document.getElementById("sin_service_disc"+val_idss).disabled = true;
				document.getElementById("sin_service_time"+val_idss).disabled = true;
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
}
function getDiscount(disc,idss)
{
	total_price='';
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.discount.value;
	service_price=parseFloat(document.getElementById("sin_service_price"+idss).value);
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
		installment_tax= taxes[1];
		document.getElementById("service_tax_id").innerHTML=service_tax;
		document.getElementById("service_taxes").value=service_tax;
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
	var date=document.getElementById("date").value;
	var start_time = document.getElementById("start_time").value;
	var curr_date = document.getElementById("date").value;
	var data1="emp_id="+emp_id+"&start_time="+start_time+"&curr_date="+curr_date;
	//alert(data1);
	$.ajax({
	url: "get_exit_time.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html.trim());
		if(html.trim() !='')
		{
			alert("This Time Schedule is already exist for this Staff,Please Select another Start time");
			document.getElementById("start_time").value='';
			document.getElementById("end_time").value='';
			document.getElementById("employee_id").selectedIndex = "0";
		}
	}
	});
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
	 if(frm.service_price.value=='')
	 {
		 disp_error +='Enter Service Price \n';
		 document.getElementById('service_price').style.border = '1px solid #f00';
		 frm.service_price.focus();
		 error='yes';
	 }
	 if(frm.service_tax.value=='')
	 {
		 disp_error +='Enter Service tax \n';
		 document.getElementById('service_tax').style.border = '1px solid #f00';
		 frm.service_tax.focus();
		 error='yes';
	 }
	 if(frm.total_cost.value=='')
	 {
		 disp_error +='Enter Total cost \n';
		 document.getElementById('total_cost').style.border = '1px solid #f00';
		 frm.total_cost.focus();
		 error='yes';
	 }
	  if(frm.date.value=='')
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
	 }
	 if(frm.start_time.value=='')
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
	 }
	 
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
		 }else if(frm.payment_mode.value=="paytm-3")
		 {
			if(frm.bank_name.value=="select")
		 	{
				 disp_error +='Select Bank name  \n';
				 document.getElementById('bank_name').style.border = '1px solid #f00';
				 frm.bank_name.focus();
				 error='yes';
			}
			
		 }else if(frm.payment_mode.value=="Credit Card-4")
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
	 }

	
	 if(error=='yes')
	 {
		 alert(disp_error);
		 return false;
	 }
	 else
	 {
		//submit_event();
	 	return true;
	 }
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
	
	var data1="mobile_no="+value;	
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

<!--<link type="text/css" rel="stylesheet" href="EventCalendar/media/layout.css" />    
<link type="text/css" rel="stylesheet" href="EventCalendar/themes/calendar_g.css" />    
<link type="text/css" rel="stylesheet" href="EventCalendar/themes/calendar_green.css" />    
<link type="text/css" rel="stylesheet" href="EventCalendar/themes/calendar_traditional.css" />    
<link type="text/css" rel="stylesheet" href="EventCalendar/themes/calendar_transparent.css" />    
<link type="text/css" rel="stylesheet" href="EventCalendar/themes/calendar_white.css" />    -->
<!-- helper libraries -->

	<script src="EventCalendar/new/helpers/jquery-1.12.2.min.js" type="text/javascript"></script>
    
	<!-- daypilot libraries -->
    <script src="EventCalendar/new/js/daypilot-all.min.js?v=2726" type="text/javascript"></script>

    <!-- daypilot themes -->
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/areas.css?v=2726" />    
        
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/month_white.css?v=2726" />    
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/month_green.css?v=2726" />    
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/month_transparent.css?v=2726" />    
    <link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/month_traditional.css?v=2726" />
        
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/navigator_8.css?v=2726" />    
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/navigator_white.css?v=2726" />    
        
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/calendar_transparent.css?v=2726" />    
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/calendar_white.css?v=2726" />    
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/calendar_green.css?v=2726" />    
    <link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/calendar_traditional.css?v=2726" />

    <link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/scheduler_8.css?v=2726" />
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/scheduler_white.css?v=2726" />    
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/scheduler_green.css?v=2726" />    
	<link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/scheduler_blue.css?v=2726" />    
    <link type="text/css" rel="stylesheet" href="EventCalendar/new/themes/scheduler_traditional.css?v=2726" />
	<link type="text/css" rel="stylesheet" href="../themes/scheduler_transparent.css?v=2726" />    
    
<!--<script src="EventCalendar/js/jquery-1.9.1.min.js" type="text/javascript"></script>-->

<!-- daypilot libraries -->
<!--<script src="EventCalendar/js/daypilot/daypilot-all.min.js" type="text/javascript"></script>-->
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
							$branch_name=$_POST['branch_name'];
                          	$customer_id=$_POST['customer_id'];
                            $service_price=$_POST['service_price'];  
							$discount_price=$_POST['discount_price'];    
							$service_tax=$_POST['service_tax']; 
							$total_cost=$_POST['total_cost']; 
							$employee_id=$_POST['employee_id'];
							$service=$_POST['requirment_id'];
							$date=trim($_POST['date']);
							$start_time=trim($_POST['start_time']);
							$end_time=trim($_POST['end_time']);
							$bank_name='';
							$chaque_no='';
							$chaque_date='';
							$credit_card_no='';
							$payment_mode=$_POST['payment_mode'];
							$sep=explode("-",$payment_mode);
							$payment_mode_id=$sep[1];
							$payment_type_val=$sep[0];
							$amount=$_POST['amount'];
							$start=trim($_POST['start']);
							$end=trim($_POST['end']);
							
							//$voucher_number='';
							//$voucher_deal_id='';
							//$remaining_voucher=$_POST['remaining_voucher'];
							$categories='';
							$category=$_POST['category'];
							if($category=="Package")
							{
								$packagess_deal_id=$_POST['packagess_deal_id'];
							}
							
							/*if($category =="Voucher")
							{
								$voucher_number=$_POST['voucher_number'];
								$voucher_deal_id=$_POST['voucher_deal_id'];
								$categories=$_POST['categories'];
							}*/
							
							
							$disc_type=$_POST['discount'];
							$nonmemb_discount_type=$_POST['nonmemb_discount_type'];
							$nonmemb_discount=$_POST['nonmemb_discount'];
							$nonmemb_discount_price=$_POST['nonmemb_discount_price'];
							
							if($payment_mode_id !="1" || $payment_mode_id !="3" ||$payment_mode_id !="5")
							{
								$bank_name=$_POST['bank_name'];
								$chaque_no=$_POST['chaque_no'];
								$credit_card_no=$_POST['credit_card_no'];
								$chaque_date=$_POST['cheque_date'];
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
                                $data_record['customer_id'] =$customer_id;
                                $data_record['service_price'] =$service_price;
								$data_record['discount_price'] =$discount_price;
								$data_record['service_tax'] =$service_tax;
								$data_record['total_cost'] =$total_cost;
								$data_record['staff_id'] =$employee_id;
								$data_record['added_date']=date('Y-m-d H:i:s');
								$data_record['date'] =$date;
								$data_record['start_time'] =$start_time;
								$data_record['end_time'] =$end_time;
								$data_record['payment_mode_id'] =$payment_mode_id;
								$data_record['chaque_no'] =$chaque_no;
								$data_record['chaque_date'] =$chaque_date;
								$data_record['credit_card_no'] =$credit_card_no;
								$data_record['bank_id'] =$bank_name;
								$data_record['amount'] =$amount;
								$total_floor=$_POST['floor'];
								$data_record['discount_type']=$disc_type;
								$data_record['voucher_deal_id']=$voucher_deal_id;
								$data_record['voucher_number']=$voucher_number;
								
								$data_record['payable_amount']=$_POST['payable_amount'];
								$data_record['remaining_amount']=$_POST['remaining_amount'];
								
								$status='';
								$data_record['nonmemb_discount_type']=$nonmemb_discount_type;
								$data_record['nonmemb_discount']=$nonmemb_discount;
								$data_record['nonmemb_discount_price']=$nonmemb_discount_price;
								
								
								$data_record['start_event_time'] =$start;
								$data_record['end_event_time'] =$end;
								
								if($payment_mode_id =='' || $payment_mode_id =='0' && $data_record['amount'] =='')
								{
									$status="Booked";
								}
								else
								{
									$status="Completed";
								}
								
								$data_record['status'] =$status;
								
								
								if($record_id)
								{
									$where_record=" customer_service_id='".$record_id."'";
									$db->query_update("customer_service", $data_record,$where_record);
									
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
										//$data_record_extra['product_id']=$record_id;   
										//$data_record_extra['title'] =ucfirst($_POST['title'.$z]);										
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
                                            setTimeout('document.location.href="manage_cust_services.php";',500);
                                        </script>
         
                                    <?php

								}
								else
								{
									$record_id=$db->query_insert("customer_service", $data_record);
									
									for($i=1;$i<=$total_floor;$i++)
									{
										if($_POST['service_id'.$i] !='')
										{
											$data_record_service['customer_service_id'] =$record_id; 
											$data_record_service['customer_id'] =$customer_id; 
											$data_record_service['service_id'] =$_POST['service_id'.$i];
											$data_record_service['service_price'] =$_POST['sin_service_price'.$i];
											$data_record_service['discount'] =$_POST['sin_service_disc'.$i];
											$data_record_service['discount_price'] =$_POST['sin_service_disc_price'.$i];
											$data_record_service['total_price'] =$_POST['sin_service_total'.$i];
											$data_record_service['service_time'] =$_POST['sin_service_time'.$i];
											$data_record_service['admin_id'] =$_POST['staff_id'.$i];
											$customer_service_id=$db->query_insert("customer_service_map", $data_record_service);
										}
									}
									
									if($payment_type_val=="online")
									$status='pending';
									else
									$status='paid';
									
									$chaque_date_exp=explode('/', $chaque_date);
									$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
									
									 $insert_cust_service_invoice = " INSERT INTO `customer_service_invoice` (`customer_service_id`, `service_price`, `total_cost`, `amount`, `payable_amount`,`remaining_amount`, `paid_type`, `bank_id`, `cheque_detail`, `chaque_date`, `credit_card_no`, `admin_id`, `added_date`,`status`,`cm_id`) VALUES ('".$record_id."', '".$service_price."', '".$total_cost."', '".$amount."', '".$_POST['payable_amount']."','".$_POST['remaining_amount']."', '".$payment_mode_id."','".$bank_name."', '".$chaque_no."', '".$sep_check_date."','".$credit_card_no."', '".$_SESSION['admin_id']."', '".date('Y-m-d H:i:s')."','".$status."','".$cm_id1."'); ";
									$ptr_cust_service_invoice = mysql_query($insert_cust_service_invoice);	
									
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
													if($data_vsm['service_id']==$_POST['service_id'.$i])
													{
														/*"<br/>".$sel_svcsm="select svm_id from sales_customer_service_voucher_map where service_id='".$data_vsm['service_id']."' and voucher_id='".$data_vsm['voucher_id']."' and quantity > 0 ";
														$ptr_svcsm=mysql_query($sel_svcsm);
														if(mysql_num_rows($ptr_svcsm))
														{*/
														"<br/>".$update_prod_qty="update sales_customer_service_voucher_map set quantity=(quantity -1) where service_id='".$data_pvsm['service_id']."' and package_id='".$packagess_deal_id."' ";
														$query_prod_qty=mysql_query($update_prod_qty);
														//}
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
											"<br/>".$update_vou_code="update voucher_customer_code_map set status ='inactive' where package_id='".$packagess_deal_id."' and customer_id='".$customer_id."'";
											$ptr_code=mysql_query($update_vou_code);
											$sel_spcvs="select id from sales_package_voucher_memb where cust_id='".$customer_id."' and package_id='".$packagess_deal_id."' and quantity <= 0";
											$ptr_spcvs=mysql_query($sel_spcvs);
											if(mysql_num_rows($ptr_spcvs))
											{
												"<br/>".$update_query="update sales_package_voucher_memb set status='inactive' where cust_id='".$customer_id."' and package_id='".$packagess_deal_id."'";
												$ptr_qry=mysql_query($update_query);
											}
										}
										
									}
									if($status=="Completed")
									{
									?>
                                    	<script>
                                		window.open('invoice-service.php?record_id=<?php echo $record_id; ?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900, height=600,directories=no,location=no');
										</script>
                                    <?php
									}
									else
									{
										?>
                                    	<script>
                                		window.open('job-card-generate.php?record_id=<?php echo $record_id; ?>','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900, height=600,directories=no,location=no');
										</script>
                                    <?php
									}
									//echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record Added successfully kiran</p></center></div>
										<script type="text/javascript">
                                            $(document).ready(function() {
                                                $( "#statusChangesDiv" ).dialog({
                                                        modal: true,
                                                        buttons: {
                                                                    Ok: function() { $( this ).dialog( "close" );}
                                                                 }
                                                });
                                            });
                                           // setTimeout('document.location.href="manage_cust_services.php";',5000);
                                        </script>
                                    <?php
								}
							}
                        }
                        if($success==0)
                        {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" >
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
            <!--  <tr>
              <td width="20%" valign="top">Customer Name <span class="orange_font"> *</span></td>
              <td>
               <input  placeholder='Customer Name' value="<?php if($_POST['save_changes']) echo $_POST['cust_name']; else echo $fetch_cust['cust_name'];?>"  class='flexdatalist input_text' onChange='selectCountry(this.value)'  data-min-length='1'  multiple='multiple' list='cust_name'  type='text' id="cust_name" required/>
                <datalist id="cust_name">-->
					<?php
                   /* $query ="SELECT cust_name,cust_id FROM customer WHERE 1 ";
                        $result = mysql_query($query);
                        while($fetch_query=mysql_fetch_array($result))
                                  {
                                      echo '<option value="'.$fetch_query['cust_name'].'">'.$fetch_query['cust_name'].'</option>';
                                  }*/
                    ?>
               <!-- </datalist>
              </td>
           </tr>-->
            
           <tr>
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
               <td width="70%"  class="customized_select_box" id="sel_cust">
               <select name="customer_id" id="customer_id" style="width:200px;" onChange="getMembership(this.value)">
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
                   
						<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option> 
                </select>

                <td width="10%"></td>

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
              	</div></td>
            	</tr>
            	<tr>

                <td width="20%" valign="top" colspan="3">

                <div id="membership_id" style="display:none">

                <table width="100%">

					<tr>
					<td width="7%">Membership Details</td>
					<td width="27%">Name :<span id="memb_name"> </span><br />Discount(in %) : <span id="memb_disc"></span></td>
					</tr>
                </table><input type="hidden" name="memb_discount" id="memb_discount" value="">

                </div>

                </td>

             </tr> 

			<tr>
            	<td width="10%">Select Service<span class="orange_font">*</span></td>
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
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="10%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="service_id'+idss+'" id="service_id'+idss+'" style="width:140px" onChange="getprice(this.value,'+idss+')"><option value="">Select Service</option><?php
									$sel_tel = "select service_id,service_name,service_price,service_time from servies order by service_id asc";	 
									$query_tel = mysql_query($sel_tel);
									if($total=mysql_num_rows($query_tel))
									{
										while($data=mysql_fetch_array($query_tel))
										{
											echo '<option value="'.$data['service_id'].'">'.$data['service_name'] ." &nbsp;&nbsp;&nbsp;       (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time']." min)".'</option>';
										}
									}
									 ?>
									 </select></td><td width="8%" align="center"><input type="text" disabled="disabled" name="sin_service_price'+idss+'" id="sin_service_price'+idss+'" style=" width:100px" /></td><td width="8%" align="center"><input type="text" name="sin_service_disc'+idss+'" id="sin_service_disc'+idss+'" onkeyup="getDiscount(this.value,'+idss+')"  disabled="disabled" style=" width:100px" /><input type="hidden" name="sin_service_disc_price'+idss+'" id="sin_service_disc_price'+idss+'" /></td><td width="8%" align="center"><input type="text" disabled="disabled" name="sin_service_total'+idss+'" id="sin_service_total'+idss+'" style=" width:100px"><input type="hidden" disabled="disabled" name="sin_service_time'+idss+'" id="sin_service_time'+idss+'" style=" width:100px" /></td><td width="10%"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:90%"><option value="">Select Staff</option><?php
									$sel_staff = "select admin_id,name from site_setting order by admin_id asc";	 
									$query_staff = mysql_query($sel_staff);
									if($total_staff=mysql_num_rows($query_staff))
									{
										while($data=mysql_fetch_array($query_staff))
										{
											echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
										}
									}
									 ?>
									 </select></td><td valign="top" width="8%" align="center"><input type="hidden" name="total_services[]" id="total_services'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
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
                        <td valign="top" width="21%" align="center">Service Name</td>
                        <td valign="top" width="16%"  align="center">Price</td>
                        <td valign="top" width="18%"  align="center">Discount (in %)<br />
                        
                        <?php
						
						?>
                        <input type="radio" name="discount" id="discount" checked="checked" value="percentage" <?php if($_POST['discount']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="discount" id="discount" value="rupees" <?php if($_POST['discount']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/
                        </td>
                        <td valign="top" width="14%"  align="center">Total Price</td>
                        <!--<td valign="top" width="6%"  align="center">Time(in Min.)</td>-->
                        <td valign="top" width="17%"  align="center">Staff</td>
                       
                        <td valign="top" width="14%"  align="center"> <?php	if($record_id){ echo "Acton"; } ?></td>
                        </tr>
                        <tr>
                            <td colspan="7">
							<?php
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
                            <td width="8%" align="center"><input type="text" name="sin_service_price<?php echo $t; ?>" id="sin_service_price<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['service_price'] ?>" /></td><td width="8%" align="center"><input type="text" name="sin_service_disc<?php echo $t; ?>" id="sin_service_disc<?php echo $t; ?>" value="<?php echo $data_exclusive['discount'] ?>" onKeyUp="getDiscount(this.value,<?php echo $t; ?>)"  style=" width:100px" /><input type="hidden" name="sin_service_disc_price<?php echo $t; ?>" id="sin_service_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['discount_price'] ?>" /></td><td width="8%" align="center"><input type="text"  name="sin_service_total<?php echo $t; ?>" id="sin_service_total<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['total_price'] ?>"><input type="hidden"name="sin_service_time<?php echo $t; ?>" id="sin_service_time<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['service_time'] ?>" /></td><td width="10%"><select name="staff_id<?php echo $t; ?>" id="staff_id<?php echo $t; ?>" style="width:90%"><option value="">Select Staff</option><?php
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
                            <input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['customer_service_map_id'] ?>" />
                            <input type="button" title="Delete Options(-)" onClick="delete_service(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
                            <input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
                      <?php } ?>   
                         </td>
                             </tr></table>
                             </div>
                            <?php
                            $t++;
                                }
                            ?>
                        </tr> 
                        </table>
                         <input type="hidden" name="floor" id="floor"  value="0" />
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
            	<td colspan="4">
            	<div id="memb_discount_div" style="display:none">
            	<table width="100%">
            		<tr>
                		<td width="20%" valign="top">Membership Discount Price</td>
                		<td width="72%"><input type="text" class=" input_text" name="discount_price" id="discount_price" onBlur="showUser()" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_record['discount_price'];?>" /></td> 
                		<td width="5%"></td>
            		</tr>
            	</table>
            	</div>
            	</td>
           	</tr>
            <tr>
            	<td width="20%" valign="top">Non-member Discount  <input type="radio" name="nonmemb_discount_type" onChange="showUser()" id="nonmemb_discount_type" checked="checked" value="percentage" <?php if($_POST['nonmemb_discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="nonmemb_discount_type" id="nonmemb_discount_type" onChange="showUser()" value="rupees" <?php if($_POST['nonmemb_discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/</td>
                
            	<td width="72%"><input type="text" class=" input_text" name="nonmemb_discount" id="nonmemb_discount" onBlur="showUser()" value="<?php if($_POST['nonmemb_discount']){echo $_POST['nonmemb_discount'];} else {echo $row_record['nonmemb_discount'];}?>" /></td> 
            	<td width="5%"></td>
            </tr>
            <tr>
            	<td width="20%" valign="top">Non-member Discount Price</td>
            	<td width="72%"><input type="text" class=" input_text" name="nonmemb_discount_price" id="nonmemb_discount_price" value="<?php if($_POST['nonmemb_discount_price']) echo $_POST['nonmemb_discount_price']; else echo $row_record['nonmemb_discount_price'];?>" /></td> 
            	<td width="5%"></td>
            </tr>
			<!--<tr>
            	<td width="20%" valign="top">Non Membership Discount  <input type="radio" name="nonmemb_discount_type" id="nonmemb_discount_type" checked="checked" value="percentage" <?php //if($_POST['nonmemb_discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="nonmemb_discount_type" id="nonmemb_discount_type" value="rupees" <?php //if($_POST['nonmemb_discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['nonmemb_discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/</td>
                
                <td width="70%"><input type="text"  class=" input_text" name="nonmemb_discount" id="nonmemb_discount" onkeypress="showUser(this.value)" value="<?php //if($_POST['nonmemb_discount']) echo $_POST['nonmemb_discount']; else echo $row_record['nonmemb_discount'];?>" /></td> 
            </tr>
            <tr>
            	<td width="20%" valign="top">Non Membership Discount Price </td>
                
                <td width="70%"><input type="text"  class=" input_text" name="nonmemb_discount_price" id="nonmemb_discount_price" readonly="readonly" value="<?php //if($_POST['nonmemb_discount_price']) echo $_POST['nonmemb_discount_price']; else echo $row_record['nonmemb_discount_price'];?>" /></td> 
            </tr>-->
             <tr>      

                  <td width="20%" class="heading">Service Tax <span id="service_tax_id"><?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"  />

    

                  <td><input type="text" class=" input_text"  name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>

    

            </tr>

            <tr>

                <td width="20%" valign="top">Total Cost<span class="orange_font">*</span></td>

                <td width="70%"><input type="text"  class=" input_text" name="total_cost" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>" /></td> 

                <td width="10%"></td>

            </tr>

            <tr>

            	<td width="15%" valign="top">Date<span class="orange_font">*</span></td>

             	<td width="70%"><input type="text"  class=" input_text datepicker" name="date" id="date" value="<?php if($_POST['date']) echo $_POST['date']; else echo $row_record['date'];?>" /></td> 

              	<td width="10%"></td>

            </tr>
			<tr>
            <td colspan="3">
            <input type="hidden" name="event_id" id="event_id"  />
            <input type="hidden" name="start" id="start"  />
            <input type="hidden" name="end" id="end"  />
            
<div id="dp"></div>

<script type="text/javascript">
$.noConflict();
    var dp = new DayPilot.Calendar("dp");

    // view
    dp.startDate = DayPilot.Date.today();
    dp.viewType = "Week";
    dp.allDayEventHeight = 25;
	
    dp.eventDeleteHandling = "Update";
    dp.onEventDelete = function(args) {
        alert("deleting: " + args.e.text());
    };

    // bubble, with async loading
    dp.bubble = new DayPilot.Bubble({
        onLoad: function(args) {
            var ev = args.source;
            //alert("event: " + ev);
            args.async = true;  // notify manually using .loaded()
            
            // simulating slow server-side load
            setTimeout(function() {
                args.html = "testing bubble for: <br>" + ev.text();
                args.loaded();
            }, 500);
        }
    });
    
    dp.contextMenu = new DayPilot.Menu({
        items: [
        {text:"Show event ID", onclick: function() {alert("Event value: " + this.source.value());} },
        {text:"Show event text", onclick: function() {alert("Event text: " + this.source.text());} },
        {text:"Show event start", onclick: function() {alert("Event start: " + this.source.start().toStringSortable());} },
        {text:"Delete", onclick: function() { dp.events.remove(this.source); } }
    ]});

    // event moving
    dp.onEventMoved = function (args) {
		$.post("EventCalendar/backend_move.php", 
				{
					id: args.e.id(),
					newStart: args.newStart.toString(),
					newEnd: args.newEnd.toString()
				}, 
				function() {
					//console.log("Moved.");
					dp.message("Moved: " + args.e.text());
				});
                    
       
    };
    
    // event resizing
    dp.onEventResized = function (args) {
	$.post("EventCalendar/backend_resize.php", 
			{
				id: args.e.id(),
				newStart: args.newStart.toString(),
				newEnd: args.newEnd.toString()
			}, 
			function() {
				//console.log("Resized.");
				dp.message("Resized: " + args.e.text());
			});
    };

    // event creating
    /*dp.onTimeRangeSelected = function (args) {
        var name = prompt("New event name:", "Event");
        if (!name) return;
        var e = new DayPilot.Event({
            start: args.start,
            end: args.end,
            id: DayPilot.guid(),
            resource: args.resource,
            text: name
        });
        dp.events.add(e);
        dp.clearSelection();
        dp.message("Created");
    };*/

    dp.onTimeRangeSelected = function (args) {
        //var name = prompt("New event name:", "Event");
        
		var name = document.getElementById('customer_id').options[document.getElementById('customer_id').selectedIndex].text
		if (name=="Select Customer") return;
        var e = new DayPilot.Event({
            start: args.start,
            end: args.end,
            id: DayPilot.guid(),
            resource: args.resource,
            text: name
        });
        dp.events.add(e);
        dp.events.edit(e);
        dp.clearSelection();
        dp.message("Service Booked for"+text );
		
		alert(args.start);
		document.getElementById("start").value=args.start;
		document.getElementById("end").value=args.end;
    };

    dp.onTimeRangeRightClick = function(args) {
        window.console && console.log(args);
    };
    
    dp.onTimeRangeDoubleClicked = function(args) {
        alert("Name: " + args.text + "start: " + args.start + " end: " + args.end );
    };

    dp.onEventClick = function(args) {
         alert("Name: " + args.text + "start: " + args.start + " end: " + args.end );
    };

    dp.showEventStartEnd = true;
    dp.scrollLabelsVisible = true;

   /* var e = new DayPilot.Event({
        start: DayPilot.Date.today().addHours(12),
        end: DayPilot.Date.today().addHours(15),
        id: DayPilot.guid(),
        text: "Special event"
    });
    dp.events.add(e);*/

    dp.contextMenuSelection = new DayPilot.Menu({
        items: [
            {
                'text': 'Create new event (JavaScript)', 'onclick': function () {
                dp.events.add(new DayPilot.Event({
                    start: this.source.start,
                    end: this.source.end,
                    text: "New event",
                    resource: this.source.resource
                }));
            }
            },
            {'text': '-'},
            {
                'text': 'Show selection details', 'onclick': function () {
                alert('Start: ' + this.source.start + '\nEnd: ' + this.source.end + '\nResource id: ' + this.source.resource);
            }
            },
            {
                'text': 'Clean selection', 'onclick': function () {
                dp.clearSelection();
            }
            }]
    });

    dp.init();
	
	loadEvents();
    
	function loadEvents() {
		var start = dp.visibleStart();
		var end = dp.visibleEnd();

		$.post("EventCalendar/backend_events.php", 
		{
			start: start.toString(),
			end: end.toString()
		}, 
		function(data) {
			//console.log(data[0]);
			dp.events.list = data;
			dp.update();
		});
	}

</script>
<script type="text/javascript">
$.noConflict();
$(document).ready(function() {
    var url = window.location.href;
    var filename = url.substring(url.lastIndexOf('/')+1);
    if (filename === "") filename = "index.html";
    $(".menu a[href='" + filename + "']").addClass("selected");
});
        
</script>
            <!--</div>
            <div class="clear">
            </div>-->
            
            </td>
            </tr>
            <tr>

            	<td width="15%" valign="top">Select Start Time<span class="orange_font">*</span></td>

             	<!--<td width="70%"><input type="text"  class=" input_text" style="width:50px" name="start_time" id="start_time" onBlur="show_time(this.value)" maxlength="4" value="<?php //if($_POST['start_time']) echo $_POST['start_time']; else echo $row_record['start_time'];?>" /></td> -->
                
                <td width="70%">
                <table>
                 <tr>
                    <td width="6%" align="left">Start time(HH) :</td>
                    <td width="10%" align="left">
                    <select name="start_time_hr" id="start_time_hr" onChange="show_time();" style="width:50px">
    
                    <?php for($i=00;$i<24; $i++)
					{ 
						$number = $i; //The number is in the position 1 in the array, so this will be number variable
						$num = ""; //The final number
						if($number<10) $num .= "0"; //If the number is below 10, it will add a leading zero
						$num .= $number;
					?>
                
                        <option value="<?php echo $num;?>"><?php echo $num;?></option>
                
              <?php } ?>
                    </select>
                    </td>
                    
                    <td width="6%" align="left">Start time(MIN) :</td><td width="20%">
                    <select name="start_time_min" id="start_time_min" onChange="show_time();" style="width:50px">
    
                    <?php for($j=0;$j<=59; $j++)
					   { 
					   	$number = $j; //The number is in the position 1 in the array, so this will be number variable
						$num = ""; //The final number
						if($number<10) $num .= "0"; //If the number is below 10, it will add a leading zero
						$num .= $number;
					   ?>
    
                        <option value="<?php echo $num;?>"><?php echo $num;?></option>
                
                 <?php } ?>	
                    </select>
                    </td>
                    </tr>
                   </table>
                 </td>

              	
            </tr>
            <tr>
            <td width="15%" valign="top">Start Time</td>
            <td width="70%"><input type="text"  class=" input_text" style="width:50px" name="start_time" id="start_time" readonly="readonly" value="<?php if($_POST['start_time']) echo $_POST['start_time']; else echo $row_record['start_time'];?>" /></td>
            
            <td width="10%"><input type="hidden" name="times" id="times" value="" /></td>

            </tr>

            <tr>

            	<td width="15%" valign="top">End Time<span class="orange_font">*</span></td>

             	<td width="70%"><input type="text"  class=" input_text" style="width:50px" name="end_time" id="end_time" maxlength="2" value="<?php if($_POST['end_time']) echo $_POST['end_time']; else echo $row_record['end_time'];?>" /><!--<select name="time_prime_to"><option value="am">AM</option><option value="pm">PM</option></select>--></td> 

              	<td width="10%"></td>

            </tr>
           <!-- <tr>
            	<td width="15%" valign="top">Select Package<span class="orange_font">*</span></td>
                <td width="70%">
                <select name="package" id="package" onChange="add_package(this.value)">
                <option value="">Select Package</option>
                <?php
				/*$sel_tel ="select package_id,package_name,cost_to_center from package where end_date > '".date('Y-m-d')."' order by package_id asc";	 
				$query_tel = mysql_query($sel_tel);
				if($total=mysql_num_rows($query_tel))
				{
					while($data=mysql_fetch_array($query_tel))
					{
						$selected='';
						if($data_exclusive['package_id'] ==$data['package_id'] )
						{
							$selected='selected="selected"';
						}
						echo '<option value="'.$data['package_id'].'" '.$selected.'>'.$data['package_name']."   (Price- ".$data['cost_to_center'].")".'</option>';
					}
				}*/
				 ?>
                </select>
                </td>
            </tr>-->
             <tr>
            	<td width="15%" valign="top">Select Category<span class="orange_font">*</span></td>
                <td width="70%">
                <select name="category" id="category" onChange="show_category(this.value)">
                <option value="">Select Category</option>
               	<option value="Package">Package</option>
                <option value="Voucher">Voucher</option>
                </select>
                </td>
            </tr>
            <tr>
            <td colspan="3">
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
             	<td colspan="3"><input type="hidden" name="res1" id="res1" />
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
                                            <td width="23%">Redumption : <span id="package_prices"></span> - <span id="package_amnt_prices"></span> = <span id="total_price_pkg"></span><input type="hidden" name="totals_price_pkg" id="totals_price_pkg" value="" /></td>
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
             
             	<div id="bank_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo 'style="display:block"'; else echo ' style="display:none"'; ?>>
             		<table width="100%">
             			<tr>
             				<td width="23%" class="tr-header" >Bank Name</td>
             				<td>
             					<div id="bank_id"></div>
             				</td>
             			</tr>
             			<tr>
             				<td class="tr-header" width="23%">Account No</td>
             				<td><input type="text" name="account_no" readonly id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
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
             	<!--<div id="voucher_no"></div>-->
               	
                </td>
               </tr>
               <tr>
                   <td colspan="3">
                        <!--<div id="voucher_div_id" style="display:none">
                            <table style="width:100%">
                                <tr>
                                    <td width="6%">Voucher Details</td>
                                    <td width="23%">Voucher Name : <span id="voucher_name"></span><input type="hidden" name="vouchers_name" id="vouchers_name" value="" /></td>
                                </tr>
                                <tr>
                                    <td width="6%">
                                    </td><td width="23%">Start Date : <span id="voucher_start_date"></span><input type="hidden" name="vouchers_start_date" id="vouchers_start_date" value="" /></td>
                                </tr>
                                <tr>
                                    <td width="6%"></td>
                                    <td width="23%">End Date : <span id="voucher_end_date"></span><input type="hidden" name="vouchers_end_date" id="vouchers_end_date" value="" /></td>
                                </tr>
                                <tr>
                                	<td colspan="3">
                                    <div id="amount_div">
                                        <table width="100%">
                                            <tr>
                                                <td width="6%"></td>
                                                <td width="23%">Price : <span id="voucher_price"></span><input type="hidden" name="vouchers_price" id="vouchers_price" value="" /></td>
                                            </tr>
                                            <tr>
                                                <td width="6%"></td>
                                                <td width="23%">Redumption : <span id="voucher_prices"></span> - <span id="amount_prices"></span> = <span id="total_price"></span><input type="hidden" name="totals_price" id="totals_price" value="" /><input type="hidden" name="categories" id="categories"  /></td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                 </tr>
                           </table>
                       </div>-->
                   </td>
                </tr>
                
                <tr>
                	<td width="" class="tr-header">Amount<span class="orange_font">*</span></td>
                	<td width=""><input type="text" name="amount" id="amount" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount']; ?>"  /></td>
                	<td width="10%"><input type="hidden" name="remaining_voucher" id="remaining_voucher" value="0"  /></td>
            	</tr>
                
                <tr>

                    <td width="25%" >Payable Amount</td>
                
                    <td width="40%"><input type="text" name="payable_amount" id="payable_amount" value="<?php if($_POST['save_changes']) echo $_POST['payable_amount']; else echo $row_record['payable_amount']; ?>" onKeyUp="cal_remaining_amt();"/></td>
            
              </tr>
             
             <tr>

                <td width="25%" >Remaining Amount</td>
            
                <td width="40%"><input type="text" name="remaining_amount" id="remaining_amount" value="<?php if($_POST['save_changes']) echo $_POST['remaining_amount']; else echo $row_record['remaining_amount']; ?>"  /></td>
            
             </tr>
             
                <tr>
            	<td width="" class="tr-header" align="">Select Employee<span class="orange_font">*</span></td>
            	<td><select name="employee_id" id="employee_id" onChange="show_exist_time(this.value)">
             	<option value="">--Select--</option>
             	<?php
             	$sle_name="select admin_id,name from site_setting ".$_SESSION['where_cm_id'].""; 
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
                  <td><input type="submit" class="input_btn" onClick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Service" name="save_changes"  /></td>
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
	contact='';
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
	if(membership_discount !=0)
	{
		var discount_price= service_price * (membership_discount/100);
	}
	else
	{
		var discount_price= 0;
	}
	
	if(discount_price !=0)
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
	
	
	
	var service_tax= document.getElementById('service_taxes').value;
	var disc_price= document.getElementById('nonmemb_discount_price').value;
	
	
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
	
	
	var service_tax__price= parseFloat(disc_price * (service_tax/100));
	document.getElementById('service_tax').value=service_tax__price;
	var total_cost =  parseFloat(disc_price) +  parseFloat( service_tax__price);
	document.getElementById('total_cost').value=total_cost;
	document.getElementById('amount').value=total_cost;
	document.getElementById('remaining_amount').value=total_cost;
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
if($_SESSION['type']=="S")
{
	?>
     <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}
if($record_id)
{
	?>
    <script>
	customer_id= document.getElementById("customer_id").value;
	getMembership(customer_id);
	
</script>

<?php
}
if($record_id || $_SESSION['type']=="S")
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