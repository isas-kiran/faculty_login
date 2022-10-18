<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM assets where asset_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Assets</title>
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

    <!-- Multiselect -->

    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>


    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	var pageName = "add_inventory";
    $(document).ready(function()
    {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			$("#vendor_id").chosen({allow_single_deselect:true});//product_id1
			//$("#product_id1").chosen({allow_single_deselect:true});
     });
	 $(document).keypress(
		function(event){
		 if (event.which == '13') {
			event.preventDefault();
		  }
	});
    </script>
    <script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
<script>
var reslts='';
record_id='';
function get_asset_list(vendor_id)
{
	var record_id= document.getElementById("record_id").value;
	var total_product= document.getElementsByName("total_product[]");
	var totals=total_product.length;

	var data1="vendor_id="+vendor_id+"totals="+totals;
	 //alert(data1)
	  $.ajax({
		url: "get_asset_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			//res=html;
			document.getElementById("create_floor").innerHTML='';
			//document.getElementById("create_type1").innerHTML='';
			document.getElementById("res1").value=html;
		}
	});
	var data2="vendor_id="+vendor_id;
	 //alert(data1)
	  $.ajax({
		url: "get_vendor_bal.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			if(html !='')
			{
				document.getElementById("wallet").style.display='block';
				document.getElementById("wallet_bal").style.display='block';
				document.getElementById("wallet_bal").innerHTML=html;
				document.getElementById("wallet_amount").value=html;
				document.getElementById("wallet_amnt").value=html;
			}
		}
	});
}
function show_product_desc(ids)
{
	product_id=document.getElementById("product_id"+ids).value;
	//alert(product_id)
	var data1="product_id="+product_id;
	$.ajax({
		url: "get-product_qty.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			var new_values=html;
			var fields = new_values.split(/-/);
			var unit11 = fields[0];
			var quantity = fields[1];
			
			var sep_field= unit11.split(" ");
			var unit1=sep_field[0];
			var measure=sep_field[1];
			
			var quantity_new = quantity /*- quantity_minus*/;
			
			$("#unit_desc"+ids).html(unit1);
			$("#measure_desc"+ids).html(measure);
			//$("#measure_unit"+ids).val(measure);
			var prod_desc=fields[2];
			var details = prod_desc.split(/#/);
			var price= details[0];
			$("#price_desc"+ids).html(price);
			var brand= details[1];
			var description= details[2];
			document.getElementById("product_details"+ids).style.display="block";
			$("#brand"+ids).html(brand);
			$("#description_desc"+ids).html(description);
				
			if(document.getElementById("select_from"))
			{
				values=document.getElementById("select_from").value;
				show_product_qty(values)
			}
		}
	});
}
function getprice(values,val_idss)
{
	show_product_desc(val_idss);
	var product_id=document.getElementById('product_id'+val_idss).value;
	var data1="product_id="+product_id;	
	$.ajax({
		url: "get_inven_product_price.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			product_price_inv=html;
			document.getElementById("base_price"+val_idss).value=0;
			document.getElementById("sin_product_price"+val_idss).value=product_price_inv;
			document.getElementById("sin_product_base_price"+val_idss).value=product_price_inv;
			document.getElementById("sin_product_total"+val_idss).value=product_price_inv;
			var exit_disc=document.getElementById("sin_product_disc"+val_idss).value = 0;
			var exit_disc=document.getElementById("prod_discounted_price"+val_idss).value = product_price_inv;
			var exit_cgst=document.getElementById("sin_product_cgst"+val_idss).value = 0;
			var exit_sgst=document.getElementById("sin_product_sgst"+val_idss).value = 0;
			var exit_igst=document.getElementById("sin_product_igst"+val_idss).value = 0;
			var exit_qty=document.getElementById("sin_product_qty"+val_idss).value = 1;
			
			document.getElementById("mrp_price"+val_idss).value=product_price_inv;
			document.getElementById("sin_product_base_price"+val_idss).style.backgroundColor="#cccc";
			document.getElementById("sin_product_price"+val_idss).style.backgroundColor="white";
			document.getElementById("sin_product_price"+val_idss).readOnly = false;
			document.getElementById("sin_product_base_price"+val_idss).readOnly = true;
			<?php
			if($record_id=='') { ?>
			 var exit_main_discount=document.getElementById("discount").value=0;
			 <?php } ?>
		}
		});
		var exit_disc='';
		if(values !="")
		{		
			document.getElementById("sin_product_price"+val_idss).disabled = false;
			document.getElementById("sin_product_base_price"+val_idss).disabled = false;
			document.getElementById("sin_product_disc"+val_idss).disabled = false;
			document.getElementById("prod_discounted_price"+val_idss).disabled = false;
			document.getElementById("sin_product_qty"+val_idss).disabled = false;
			document.getElementById("sin_product_total"+val_idss).disabled = false;
			document.getElementById("sin_product_cgst"+val_idss).disabled = false;
			document.getElementById("sin_product_sgst"+val_idss).disabled = false;
			document.getElementById("sin_product_igst"+val_idss).disabled = false;
			document.getElementById("staff_id"+val_idss).disabled = false;
		}
		else
		{
			document.getElementById("sin_product_price"+val_idss).disabled = true;
			document.getElementById("sin_product_base_price"+val_idss).disabled = true;
			document.getElementById("sin_product_disc"+val_idss).disabled = true;
			document.getElementById("prod_discounted_price"+val_idss).disabled = true;
			document.getElementById("sin_product_qty"+val_idss).disabled = true;
			document.getElementById("sin_product_total"+val_idss).disabled = true;
			document.getElementById("sin_product_cgst"+val_idss).disabled = true;
			document.getElementById("sin_product_sgst"+val_idss).disabled = true;
			document.getElementById("sin_product_igst"+val_idss).disabled = true;
			document.getElementById("staff_id"+val_idss).disabled = true;
		}
		setTimeout(showUser,800);
		getDiscount(val_idss);
		calculte_amount_tax(val_idss),800;
}
function getDiscount(idss)
{
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.products_disc_type.value;
	//alert(idss);
	base_price=document.getElementById("base_price"+idss).value;
	//alert(base_price);
	if(base_price=='1')
	{
		product_price=document.getElementById("sin_product_base_price"+idss).value;
	}
	else
	{
		product_price=document.getElementById("sin_product_price"+idss).value;
		
		//===================================Calculate Base Price============================== Changes 18/1/18
		var k=0;
		cgsttax=0;
		cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+idss).value);
		if(cgst_percent >0)
		{
			var cgsttax=cgst_percent;
			var k =k+1;
			
		}
		sgsttax=0;
		sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+idss).value);
		if(sgst_percent >0)
		{
			var sgsttax=sgst_percent;
			var k =k+1;
		}
		igsttax=0;
		igst_percent=parseFloat(document.getElementById("sin_product_igst"+idss).value);
		if(igst_percent >0)
		{
			var igsttax=igst_percent;
			k =k+1;
		}
		total_gst=0;
		tot_gst=0;
		tot_base_gst=0;
		if(cgsttax >0 || sgsttax >0)
		{
			var totalgst=Number(cgsttax+sgsttax);
			var new_total_tax=parseFloat(totalgst+100);
			//alert(new_total_tax);
			var tax_new=parseFloat(new_total_tax/100);
			//alert(tax_new);
			//var total_taxable_value = parseFloat(total_price / tax_new);
			//var tot_gst =precisionRound(parseFloat(total_price - total_taxable_value),2);
			//=================================for base price===========================
			var total_base_taxable_value = parseFloat(product_price / tax_new);
			var tot_base_gst =precisionRound(parseFloat(product_price - total_base_taxable_value),2);
			//==========================================================================
			total_gst=precisionRound(parseFloat(Number(tot_gst)/k),0);
			//alert(total_gst);
			
			if(cgsttax >0 && (sgsttax <=0 || sgsttax==''))
			{
				document.getElementById("sin_prod_cgst_price"+idss).value=total_gst;
				document.getElementById("sin_prod_sgst_price"+idss).value=0;
			}
			else if(sgsttax >0 && (cgsttax <=0 || cgsttax==''))
			{
				document.getElementById("sin_prod_sgst_price"+idss).value=total_gst;
				document.getElementById("sin_prod_cgst_price"+idss).value=0;
			}
			else if(cgsttax >0 && sgsttax >0)
			{
				document.getElementById("sin_prod_cgst_price"+idss).value=total_gst;
				document.getElementById("sin_prod_sgst_price"+idss).value=total_gst;
			}
			else
			{
				document.getElementById("sin_prod_cgst_price"+idss).value=0;
				document.getElementById("sin_prod_sgst_price"+idss).value=0;
			}
			
		}
		else if(igsttax > 0)
		{
			var totalgst=igsttax;
			var new_total_tax=parseFloat((totalgst+100)/100);
			//var total_taxable_value = parseFloat(total_price / new_total_tax);
			//var tot_gst =precisionRound(parseFloat(total_price - total_taxable_value),2);
			//=================================for base price===========================
			var total_base_taxable_value = parseFloat(product_price / new_total_tax);
			var tot_base_gst =precisionRound(parseFloat(product_price - total_base_taxable_value),2);
			//==========================================================================
			total_gst=precisionRound(parseFloat(tot_gst/k),2);
			//gst_price=Number(parseFloat(igast_tax)).toFixed(2);
			document.getElementById("sin_prod_igst_price"+idss).value=precisionRound(total_base_taxable_value,0);
		}
		else
		{
			
		}
		
		//totals_price=Number(total_price) - Number(tot_gst) ;
		product_price=Number(product_price) - Number(tot_base_gst) ; //Fpr base price
		totals_base_price=product_price;
		//total_mrp_price=precisionRound(total_base_price,0);
	//==========================================================End================================18/1/18
	}
	total_prod_price=product_price;
	total_base_price=product_price;
	
	discount_price=0;
	disc=parseFloat(document.getElementById("sin_product_disc"+idss).value).toFixed(2);
	//alert(disc)
	if(disc_type=="rupees")
	{
		total_prod_price=parseFloat(product_price-disc).toFixed(2);
		total_price=parseFloat(product_price-disc).toFixed(2);
		discount_price=parseFloat(disc).toFixed(2);
	}
	else
	{
		discount= parseFloat((product_price*disc)/100).toFixed(2);
		total_price=parseFloat(product_price-discount).toFixed(2);
		discount_price=parseFloat(discount).toFixed(2);
		total_prod_price=parseFloat(product_price-discount).toFixed(2);
	}
	document.getElementById("sin_prod_disc_price"+idss).value=discount_price;
	document.getElementById("prod_discounted_price"+idss).value=total_prod_price;
	
	sin_product_qty=parseFloat(document.getElementById("sin_product_qty"+idss).value).toFixed(2);
	
	//alert(sin_product_qty)
	if(sin_product_qty>0)
	{
		total_price=parseFloat(total_prod_price * sin_product_qty).toFixed(2);
	}
	else if(sin_product_qty=='0')
	{
		total_price=total_prod_price;
		//alert(total_price_qty)
	}
	document.getElementById("sin_product_total"+idss).value=total_price;
	
	if(base_price==1)
	{
		cgst_value=0;
		cgst_base_value=0;
		cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+idss).value).toFixed(2);
		if(cgst_percent >0)
		{
			cgst_value= precisionRound(parseFloat((total_price*cgst_percent)/100),0);
			cgst_base_value= precisionRound(parseFloat((total_base_price*cgst_percent)/100),0);<!--for base price-->
			cgst_price=precisionRound(parseFloat(cgst_value),0);
			document.getElementById("sin_prod_cgst_price"+idss).value=cgst_price;
		}
		else
		{
			document.getElementById("sin_prod_cgst_price"+idss).value=0;
		}
		sgst_value=0;
		sgst_base_value=0;
		sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+idss).value).toFixed(2);
		if(sgst_percent >0)
		{
			sgst_value= precisionRound(parseFloat((total_price*sgst_percent)/100),0);
			sgst_base_value= precisionRound(parseFloat((total_base_price*sgst_percent)/100),0);<!--for base price-->
			sgst_price=precisionRound(parseFloat(sgst_value),0);
			document.getElementById("sin_prod_sgst_price"+idss).value=sgst_price;
		}
		else
		{
			document.getElementById("sin_prod_sgst_price"+idss).value=0;
		}
		igst_value=0;
		igst_base_value=0;
		igst_percent=parseFloat(document.getElementById("sin_product_igst"+idss).value).toFixed(2);
		if(igst_percent >0)
		{
			igst_value= precisionRound(parseFloat((total_price*igst_percent)/100),0);
			igst_base_value= precisionRound(parseFloat((total_base_price*igst_percent)/100),0);<!--for base price-->
			igst_price=precisionRound(parseFloat(igst_value),0);
			document.getElementById("sin_prod_igst_price"+idss).value=igst_price;
		}
		else
		{
			document.getElementById("sin_prod_igst_price"+idss).value=0;
		}
		
		totals_price=precisionRound(Number(total_price) + Number(cgst_value) + Number(sgst_value)+ Number(igst_value),2);
		total_mrp_price=precisionRound(Number(total_base_price) + Number(cgst_base_value) + Number(sgst_base_value)+ Number(igst_base_value),2);
		
		//alert(total_mrp_price);
	}
	else
	{
		cgst_value=0;
		cgst_base_value=0;
		cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+idss).value).toFixed(2);
		if(cgst_percent >0)
		{
			cgst_value= precisionRound(parseFloat((total_price*cgst_percent)/100),0);
			cgst_base_value= precisionRound(parseFloat((total_base_price*cgst_percent)/100),0);//for base price
			cgst_price=precisionRound(parseFloat(cgst_value),0);
			document.getElementById("sin_prod_cgst_price"+idss).value=cgst_price;
		}
		else
		{
			document.getElementById("sin_prod_cgst_price"+idss).value=0;
		}
		sgst_value=0;
		sgst_base_value=0;
		sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+idss).value).toFixed(2);
		if(sgst_percent >0)
		{
			sgst_value= precisionRound(parseFloat((total_price*sgst_percent)/100),0);
			sgst_base_value= precisionRound(parseFloat((total_base_price*sgst_percent)/100),0);//for base price
			sgst_price=precisionRound(parseFloat(sgst_value),0);
			document.getElementById("sin_prod_sgst_price"+idss).value=sgst_price;
		}
		else
		{
			document.getElementById("sin_prod_sgst_price"+idss).value=0;
		}
		igst_value=0;
		igst_base_value=0;
		igst_percent=parseFloat(document.getElementById("sin_product_igst"+idss).value).toFixed(2);
		if(igst_percent >0)
		{
			igst_value= precisionRound(parseFloat((total_price*igst_percent)/100),0);
			igst_base_value= precisionRound(parseFloat((total_base_price*igst_percent)/100),0);//for base price
			igst_price=precisionRound(parseFloat(igst_value),0);
			document.getElementById("sin_prod_igst_price"+idss).value=igst_price;
		}
		else
		{
			document.getElementById("sin_prod_igst_price"+idss).value=0;
		}
		//alert(total_price+"-"+cgst_value+"-"+sgst_value);
		totals_price=precisionRound(Number(total_price) + Number(cgst_value) + Number(sgst_value)+ Number(igst_value),2);
		total_mrp_price=precisionRound(Number(total_base_price) + Number(cgst_base_value) + Number(sgst_base_value)+ Number(igst_base_value),2);
		//alert(totals_price);
	}
	if(base_price==1)
	{
		document.getElementById("sin_product_price"+idss).value=Math.round(total_mrp_price);
		document.getElementById("mrp_price"+idss).value=Math.round(total_mrp_price);
		document.getElementById("sin_product_total"+idss).value=Math.round(totals_price);
	}
	else
	{
		//alert(totals_price);
		//alert(totals_base_price);
		document.getElementById("sin_product_total"+idss).value=Math.round(totals_price);
		document.getElementById("sin_product_base_price"+idss).value=Math.round(totals_base_price);
		document.getElementById("mrp_price"+idss).value=Math.round(total_mrp_price);
		//document.getElementById("prod_discounted_price"+prod_id).value=totals_base_price;
	}
	
	
	showUser();
	calculte_total_cost();
	calculte_amount_tax(idss);
}

function precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
}
function calculte_total_cost()
{
	 //alert('hi')

	var price=document.getElementById("price").value;

	var discount=document.getElementById("discount").value;
	 //alert(discount)
	var total=isNaN(parseFloat(price * (discount / 100))) ? 0 :parseFloat((price * (discount / 100)))
	 //alert(total_cost)
	var total_cost_new=isNaN(parseFloat(price - total)) ? 0 :parseFloat(price - total)
	$('#total_cost').val(total_cost_new);
	$('#amount1').val(total_cost_new);
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
	//alert(val_tax_ids);
	var total_tax=document.getElementsByName("total_tax[]").length;
	//alert(total_tax);
	for(i=1;i<=total_tax;i++)
	{
		tax_id='tax_value'+i;
		//alert(tax_id);
		//break;
		if(document.getElementById(tax_id) !='')
		{
			tax_value =Number(tax_value) + Number(document.getElementById(tax_id).value);
		}
	}
	//alert("tax_value "+tax_value);
	//tax_value +=document.getElementById('tax_value'+val_tax_ids).value;
    cost_tot_tt=parseFloat(document.getElementById("total_cost").value).toFixed(2);
	cal_tot_amount=Number(cost_tot_tt * (tax_value/100));
	//alert("total amnt - "+cal_tot_amount);
	tot_amount=parseFloat(Number(cost_tot_tt) + Number(cal_tot_amount)).toFixed(2);
	//alert(tot_amount);
	//document.getElementById('tax_amount').innerHTML=tot_amount;
	$('#tax_amount'+val_tax_ids).val(cal_tot_amount);

	$('#amount1').val(tot_amount);
	
	cal_remaining_amt();
}

function cal_remaining_amt()
{
	var final_amt=Number(document.getElementById('amount1').value);
	var payable_amt=Number(document.getElementById('payable_amount').value);
	var wall_amt=Number(document.getElementById('wallet_amnt').value);
	if(payable_amt > final_amt+1)
	{
		extra_amnt=payable_amt-final_amt + wall_amt;
		//alert("Payable Amount should not be greater than Final amount..");
		alert("Would you like to add extra amount "+extra_amnt+" Rs/- in Vendor's Wallet");
		document.getElementById("payable_amount").value=payable_amt;	
	  	$('#remaining_amount').val(0);
		document.getElementById("wallet").style.display="block";
		document.getElementById("wallet_bal").style.display="block";
		document.getElementById("wallet_bal").innerHTML=extra_amnt;
		document.getElementById("wallet_amount").value=extra_amnt;		
	  	return false;
	}
	else
	{	
		remaining_amnt=final_amt-payable_amt;
		if(wall_amt > payable_amt)
		{
			extra_amnt=wall_amt - payable_amt;
			$('#remaining_amount').val(remaining_amnt);
			document.getElementById("wallet").style.display="block";
			document.getElementById("wallet_bal").style.display="block";
			document.getElementById("wallet_bal").innerHTML=extra_amnt;
			document.getElementById("wallet_amount").value=extra_amnt;		
			return false;
		}
		else
		{
			extra_amnt=0;
			$('#remaining_amount').val(remaining_amnt);
			document.getElementById("wallet").style.display="block";
			document.getElementById("wallet_bal").style.display="block";
			document.getElementById("wallet_bal").innerHTML=extra_amnt;
			document.getElementById("wallet_amount").value=extra_amnt;		
			return false;
		}
	}
	if(payable_amt!=0)
	{
		cal_tot_rem_amt=parseInt(final_amt - payable_amt);
	}
	else
	{
	  cal_tot_rem_amt=final_amt;
	}
	//alert(cal_tot_rem_amt);
	$('#remaining_amount').val(cal_tot_rem_amt);
}

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
function show_bank(branch_id,vals)
{
	//alert(branch_id);
	record_id= document.getElementById("record_id").value;
	var bank_data="action=inventory&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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
	var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax_type.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		//document.getElementById("create_type1").innerHTML='';
		document.getElementById("res_tax").value=rettax;
		//document.getElementById("type1").value=0;
		calculte_total_cost()
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
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='136' ".$_SESSION['where']."";
$ptr_sel_sms=mysql_query($sel_sms_cnt);
$tot_num_rows=mysql_num_rows($ptr_sel_sms);
$i=0;
while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
{
	"<br/>".$sel_act=" select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
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
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='136'";
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
function send(ids)
{	
	var inv_product_id=ids;
		
	var users_mail=mail1;
	data1='action=add_inventory&inv_product_id='+inv_product_id+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
	//alert(data1);
	if(inv_product_id !='')
	{
		$.ajax({
			url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true, async:false,
			success: function(response) {
			//alert(response);
			return true;
			}
		});
	}
}

function validme()
{
	frm = document.jqueryForm;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
	if(frm.vendor_id.value=='')
	{
		disp_error +='Select Vender\n';
		document.getElementById('vendor_id').style.border = '1px solid #f00';
		frm.vendor_id.focus();
		error='yes';
	}
	if(frm.discount.value=='')
	{
		disp_error +='Enter Discount\n';
		document.getElementById('discount').style.border = '1px solid #f00';
		frm.discount.focus();
		error='yes';
	}
	/* if(frm.payment_mode.value=='')
	{
		disp_error +='Please select Payment Mode \n';
		document.getElementById('payment_mode').style.border = '1px solid #f00';
		frm.payment_mode.focus();
		error='yes';
	}*/
	if(error=='yes')
	{
		alert(disp_error);
		return false;
	}
	else
	{
		
	}
	// return true;
}


function delete_product(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#product_id'+id).replaceWith(function(){
			return $('<select name="product_id'+id+'" id="product_id'+id+'" style="width:140px"><option value=""></option></select>', {html: $(this).html()});
		});
		$('#sin_product_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_price'+id+'" id="sin_product_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_product_disc'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_disc'+id+'" id="sin_product_disc'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_product_qty'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_qty'+id+'" id="sin_product_qty'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_product_total'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_total'+id+'" id="sin_product_total'+id+'" value="" />', {html: $(this).html()});
		});
		$('#staff_id'+id).replaceWith(function(){
			return $('<select name="staff_id'+id+'" id="staff_id'+id+'" style="width:140px"></select>', {html: $(this).html()});
		});
		if(types=='floor')
		{  		
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
			showUser();
			calculte_total_cost()
		}
	}
}
/*function delete_tax(id,tax_types)
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
}*/
function reset_price(prd_id)
{
	document.getElementById("sin_product_price"+prd_id).value=0;
	document.getElementById("sin_product_base_price"+prd_id).value=0;
	document.getElementById("sin_product_disc"+prd_id).value=0;
	document.getElementById("sin_product_cgst"+prd_id).value=0;
	document.getElementById("sin_product_sgst"+prd_id).value=0;
	document.getElementById("sin_product_igst"+prd_id).value=0;
	setTimeout(getDiscount(prd_id),500);
	//alert(base_price);
	base_price=document.getElementById("base_price"+prd_id).value;
	if(base_price=="1")
	{
		//base_price=0;
		document.getElementById("base_price"+prd_id).value=0;
		document.getElementById("sin_product_base_price"+prd_id).style.backgroundColor="#cccc";
		document.getElementById("sin_product_price"+prd_id).style.backgroundColor="white";
		document.getElementById("sin_product_price"+prd_id).readOnly = false;
		document.getElementById("sin_product_base_price"+prd_id).readOnly = true;
	}
	else if(base_price=="0")
	{
		//base_price=1;
		document.getElementById("base_price"+prd_id).value=1;
		document.getElementById("sin_product_price"+prd_id).style.backgroundColor="#cccc";
		document.getElementById("sin_product_base_price"+prd_id).style.backgroundColor="white";
		document.getElementById("sin_product_price"+prd_id).readOnly = true;
		document.getElementById("sin_product_base_price"+prd_id).readOnly = false;
	}
	else
	{
		//base_price=1;
		document.getElementById("base_price"+prd_id).value=1;
	}
}
</script> 
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>-->
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
    <td class="top_mid" valign="bottom"><?php include "include/asset_menu.php"; ?></td>
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
			if($_POST['added_date'] !=''){
				$ad_date=explode('/',$_POST['added_date'],3);
				$added_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
			}
			else $added_date=date('Y-m-d');
			$vendor_id=( ($_POST['vendor_id'])) ? $_POST['vendor_id'] : "0";
			$invoice_no=( ($_POST['invoice_no'])) ? $_POST['invoice_no'] : "0";
			$price=( ($_POST['price'])) ? $_POST['price'] : "";
			$tax=( ($_POST['tax'])) ? $_POST['tax'] : "";
			$total_cost=( ($_POST['total_cost'])) ? $_POST['total_cost'] : "0";
			$wallet_amount=($_POST['wallet_amount']) ? $_POST['wallet_amount'] : "0";
			$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
			$payment_mode_id="0";
			$payment_type_val="0";
			if($_POST['payment_mode']!='')
			{
				$payment_mode=$_POST['payment_mode'];
				$sep=explode("-",$payment_mode);
				$payment_mode_id=$sep[1];
				$payment_type_val=$sep[0];
			}
			$ref_invoice_no=( ($_POST['ref_invoice_no'])) ? $_POST['ref_invoice_no'] : "0";
			$amount1=( ($_POST['amount1'])) ? $_POST['amount1'] : "0";
			"<br/>Payble- ".$payable_amount=( ($_POST['payable_amount'])) ? $_POST['payable_amount'] : "0";
			"<br/>Remaining- ".$remaining_amount=($_POST['remaining_amount']) ? $_POST['remaining_amount'] : "0";
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
					$chaque_date="";
			}
			$discount=( ($_POST['discount'])) ? $_POST['discount'] : "";
			$discount_type=( ($_POST['discount_type'])) ? $_POST['discount_type'] : "";
			$discount_price=( ($_POST['discount_price'])) ? $_POST['discount_price'] : "";
			
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
			$total_floor=$_POST['floor'];
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
				$data_record['vendor_id']=$vendor_id;
				$data_record['invoice_no']=$invoice_no;
				$data_record['price']=$price;
				$data_record['tax']=$tax;
				$data_record['total_cost']=$total_cost;
				$data_record['payment_mode_id'] =$payment_mode_id;
				$data_record['chaque_no'] =$chaque_no;
				$data_record['chaque_date'] =$chaque_date;
				$data_record['credit_card_no'] =$credit_card_no;
				$data_record['bank_id'] =$bank_name;
				$data_record['amount1'] = $amount1;
				$total_floor=$_POST['no_of_floor'];
				//$total_type1=$_POST['total_type1'];
				
				$data_record['discount_type']=$discount_type;
				$data_record['discount']=$discount;
				$data_record['discount_price']=$discount_price;
				$data_record['asset_disc_type']=( ($_POST['products_disc_type'])) ? $_POST['products_disc_type'] : "";
				$data_record['admin_id']=$_SESSION['admin_id'];
				
				$data_record['payable_amount']=$payable_amount;
				$data_record['remaining_amount']=$remaining_amount;
				$data_record['ref_invoice_no']=$ref_invoice_no;
				if($record_id)
				{
					
					$sel_inv="select * from assets_map where asset_id='".$record_id."'";
					$ptr_inv=mysql_query($sel_inv);
					while($data_inv=mysql_fetch_array($ptr_inv))
					{
						$qty=$data_inv['sin_asset_qty'];
						$product_id=$data_inv['asset_type_id'];
				
						$sel_qty="select quantity from assets_type where `asset_type_id`='".$product_id."'";
						$ptr_qty=mysql_query($sel_qty);
						$data_qty=mysql_fetch_array($ptr_qty);
						$total=intval($data_qty['quantity']-$qty);
						
						$sql_query="UPDATE `assets_type` SET `quantity`='".$total."' WHERE `asset_type_id`='".$product_id."'";
						$query=mysql_query($sql_query);
					}
					
					$delete_query1="delete from assets_map where asset_id='".$record_id."'";
					$db->query($delete_query1); 
					
					$where_record="asset_id='".$record_id."'";
					$db->query_update("assets", $data_record,$where_record);
					
					for($i=1;$i<=$total_floor;$i++)
					{
						if($_POST['asset_type_id'.$i]!='')
						{
							$data_record_service['asset_id'] =$record_id; 
							$data_record_service['asset_type_id']=( ($_POST['product_id'.$i])) ? $_POST['product_id'.$i] : "0";
							$data_record_service['sin_asset_price']=( ($_POST['sin_product_price'.$i])) ? $_POST['sin_product_price'.$i] : "0";
							$data_record_service['sin_asset_base_price']=( ($_POST['sin_product_base_price'.$i])) ? $_POST['sin_product_base_price'.$i] : "0";
							$data_record_service['sin_asset_disc']=( ($_POST['sin_product_disc'.$i])) ? $_POST['sin_product_disc'.$i] : "0";
							$data_record_service['sin_asset_disc_price']=( ($_POST['sin_prod_disc_price'.$i])) ? $_POST['sin_prod_disc_price'.$i] : "0";
							$data_record_service['discounted_price']=( ($_POST['prod_discounted_price'.$i])) ? $_POST['prod_discounted_price'.$i] : "0";
							$data_record_service['disc_type']=( ($_POST['products_disc_type'])) ? $_POST['products_disc_type'] : "";
							
							$data_record_service['cgst_tax_in_per'] =$_POST['sin_product_cgst'.$i] ? $_POST['sin_product_cgst'.$i] : "0";
							$data_record_service['cgst_tax'] =$_POST['sin_prod_cgst_price'.$i] ? $_POST['sin_prod_cgst_price'.$i] : "0";
							$data_record_service['sgst_tax_in_per'] =$_POST['sin_product_sgst'.$i] ? $_POST['sin_product_sgst'.$i] : "0";
							$data_record_service['sgst_tax'] =$_POST['sin_prod_sgst_price'.$i] ? $_POST['sin_prod_sgst_price'.$i] : "0";
							$data_record_service['igst_tax_in_per'] =$_POST['sin_product_igst'.$i] ? $_POST['sin_product_igst'.$i] : "0";
							$data_record_service['igst_tax'] =$_POST['sin_prod_igst_price'.$i] ? $_POST['sin_prod_igst_price'.$i] : "0";
							
							$data_record_service['sin_asset_total']=(($_POST['sin_product_total'.$i])) ? $_POST['sin_product_total'.$i] : "0";
							$data_record_service['sin_asset_qty']=( ($_POST['sin_product_qty'.$i])) ? $_POST['sin_product_qty'.$i] : "0";
							$data_record_service['admin_id']=( ($_POST['staff_id'.$i])) ? $_POST['staff_id'.$i] : "0";
						
							$customer_service_id=$db->query_insert("assets_map", $data_record_service);
							
							$sel_qty="select quantity from assets_type where asset_type_id='".$_POST['product_id'.$i]."' ";
							$ptr_qty=mysql_query($sel_qty);
							$data_qty=mysql_fetch_array($ptr_qty);
							
							$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$i]);
							$update_prod_qty="update assets_type set quantity='".$total_quantity."' where asset_type_id='".$_POST['product_id'.$i]."'";
							$query_prod_qty=mysql_query($update_prod_qty);
						}
					}
					
					$chaque_date_exp=explode('/', $chaque_date);
					$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
					
					$update_invoice="update `asset_invoice` set `price`='".$price."', `total_cost`='".$total_cost."', `amount1`='".$amount1."', `payable_amount`='".$_POST['payable_amount']."',`remaining_amount`='".$_POST['remaining_amount']."', `paid_type`='".$payment_mode_id."', `bank_id`='".$bank_name."', `cheque_detail`='".$chaque_no."', `chaque_date`='".$sep_check_date."', `credit_card_no`='".$credit_card_no."', `admin_id`='".$_SESSION['admin_id']."',`total_paid`='".$payable_amount."', `added_date`='".$added_date."' where asset_id='".$record_id."'";
					
					$ptr_sales_invoice = mysql_query($update_invoice); 
					//============================================================================
					if($payment_mode_id=='2' || $payment_mode_id=='4' || $payment_mode_id=='5')
					{
						$update_bank="update `bank_records` set `bank_id`='".$bank_name."',`type`='purchase',`record_id`='".$record_id."', `invoice_id`='".$ptr_sales_invoice."',`amount`='".$payable_amount."',`added_date`='".date('Y-m-d H:i:s')."' where record_id='".$record_id."'";
						$bank_query=mysql_query($update_bank);  
					}
					
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_assets','Edit','asset edit','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
				}
				else
				{
					$data_record['added_date'] =$added_date;
					$record_id=$db->query_insert("assets", $data_record);
					
					"<br/>".$update_vendor="update vendor set wallet_balance='".$wallet_amount."' where vendor_id='".$vendor_id."'";
					$query_vendor=mysql_query($update_vendor);
					
					if($wallet_amount >0)
					{
					}
					for($i=1;$i<=$total_floor;$i++)
					{
						if($_POST['product_id'.$i] > 0)
						{
							$data_record_service['asset_id'] =$record_id; 
							//$data_record_service['product_id'] =$_POST['product_id'.$i];
							$data_record_service['asset_type_id']=( ($_POST['product_id'.$i])) ? $_POST['product_id'.$i] : "0";
							//$data_record_service['sin_product_price'] =$_POST['sin_product_price'.$i];
							$data_record_service['sin_asset_price']=( ($_POST['sin_product_price'.$i])) ? $_POST['sin_product_price'.$i] : "0";
							$data_record_service['sin_asset_base_price']=( ($_POST['sin_product_base_price'.$i])) ? $_POST['sin_product_base_price'.$i] : "0";
							//$data_record_service['sin_product_disc'] =$_POST['sin_product_disc'.$i];
							$data_record_service['sin_asset_disc']=( ($_POST['sin_product_disc'.$i])) ? $_POST['sin_product_disc'.$i] : "0";
							//$data_record_service['sin_prod_disc_price'] =$_POST['sin_prod_disc_price'.$i];
							$data_record_service['sin_asset_disc_price']=( ($_POST['sin_prod_disc_price'.$i])) ? $_POST['sin_prod_disc_price'.$i] : "0";
							//$data_record_service['sin_product_total'] =$_POST['sin_product_total'.$i];
							$data_record_service['discounted_price']=( ($_POST['prod_discounted_price'.$i])) ? $_POST['prod_discounted_price'.$i] : "0";
							$data_record_service['disc_type']=( ($_POST['products_disc_type'])) ? $_POST['products_disc_type'] : "";
							
							$data_record_service['cgst_tax_in_per'] =$_POST['sin_product_cgst'.$i] ? $_POST['sin_product_cgst'.$i] : "0";
							$data_record_service['cgst_tax'] =$_POST['sin_prod_cgst_price'.$i] ? $_POST['sin_prod_cgst_price'.$i] : "0";
							$data_record_service['sgst_tax_in_per'] =$_POST['sin_product_sgst'.$i] ? $_POST['sin_product_sgst'.$i] : "0";
							$data_record_service['sgst_tax'] =$_POST['sin_prod_sgst_price'.$i] ? $_POST['sin_prod_sgst_price'.$i] : "0";
							$data_record_service['igst_tax_in_per'] =$_POST['sin_product_igst'.$i] ? $_POST['sin_product_igst'.$i] : "0";
							$data_record_service['igst_tax'] =$_POST['sin_prod_igst_price'.$i] ? $_POST['sin_prod_igst_price'.$i] : "0";
							
							$data_record_service['sin_asset_total']=( ($_POST['sin_product_total'.$i])) ? $_POST['sin_product_total'.$i] : "0";
							//$data_record_service['sin_product_qty'] =$_POST['sin_product_qty'.$i];
							$data_record_service['sin_asset_qty']=( ($_POST['sin_product_qty'.$i])) ? $_POST['sin_product_qty'.$i] : "0";
							//$data_record_service['admin_id'] =$_POST['staff_id'.$i];
							$data_record_service['admin_id']=( ($_POST['staff_id'.$i])) ? $_POST['staff_id'.$i] : "0";
						
							$customer_service_id=$db->query_insert("assets_map", $data_record_service);
							
							$sel_qty="select quantity from assets_type where asset_type_id='".$_POST['product_id'.$i]."' ";
							$ptr_qty=mysql_query($sel_qty);
							$data_qty=mysql_fetch_array($ptr_qty);
							
							$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$i]);
							$update_prod_qty="update assets_type set quantity='".$total_quantity."' where asset_type_id='".$_POST['product_id'.$i]."'";
							$query_prod_qty=mysql_query($update_prod_qty);
						}
					}
					
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_asset','Add','add asset','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
						
					/*if($payment_type_val=="online")
					$status='pending';
					else*/
					$status='paid';
					
					$chaque_date_exp=explode('/', $chaque_date);
					$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
					
					$insert_sales_invoice = " INSERT INTO `assets_invoice` (`asset_id`, `price`, `total_cost`, `amount1`, `payable_amount`,`remaining_amount`, `paid_type`, `bank_id`, `cheque_detail`, `chaque_date`, `credit_card_no`, `admin_id`, `added_date`,`status`,`cm_id`,`total_paid`) VALUES ('".$record_id."', '".$price."', '".$total_cost."', '".$amount1."', '".$_POST['payable_amount']."','".$_POST['remaining_amount']."', '".$payment_mode_id."','".$bank_name."', '".$chaque_no."', '".$sep_check_date."','".$credit_card_no."', '".$_SESSION['admin_id']."','".$added_date."','".$status."','".$cm_id1."','".$payable_amount."'); ";
					$ptr_sales_invoice = mysql_query($insert_sales_invoice);
					//============================================================================
					if($payment_mode_id=='2' || $payment_mode_id=='4' || $payment_mode_id=='5')
					{
						$bank="INSERT INTO `bank_records`(`bank_id`, `type`, `record_id`, `invoice_id`, `amount`, `added_date`, `cm_id`, `admin_id`) VALUES ('".$bank_name."','purchase','".$record_id."','".$ptr_sales_invoice."','".$payable_amount."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$bank_query=mysql_query($bank);  
					}
					
					?>
                    <script>
					send(<?php echo $record_id; ?>);
					</script>
                    <?php				
					$sel_cust="select name,contact from vendor where vendor_id ='".$vendor_id."'";
					$ptr_cus_name=mysql_query($sel_cust);
					$data_cust_name=mysql_fetch_array($ptr_cus_name);
					$name=$data_cust_name['name'];
					$contact=$data_cust_name['contact'];
					//$mesg ="Hi ".$name." Thanks for purchasing our service";
					$sel_inq="select sms_text from previleges where privilege_id='136'";
					$ptr_inq=mysql_query($sel_inq);
					$txt_msg='';
					if(mysql_num_rows($ptr_inq))
					{
						$dta_msg=mysql_fetch_array($ptr_inq);
						$txt_msg=$dta_msg['sms_text'];
					}
					
					$address='';
					if($branch_name1=="Pune")
					{
						$address="International School of Aesthetics and Spa, 2nd Floor, The Greens,North Main Road, Koregoan Park, Pune-411001. Location:  https://bit.ly/2yOhji6";
					}
					else if($branch_name1=="Ahmedabad")
					{
						$address="International School of Aesthetics and Spa, First Floor, Zodiac Plaza,Near Nabard Flat, H.L. Comm. College Road, Navrangpura, Ahmedabad- 380 009.Tel No-:079-26300007. Location: https://bit.ly/2N28vbw";
					}
					else if($branch_name1=="ISAS PCMC")
					{
						$address="Hari A1,Next to ABS Gym, Pimple Nilakh, Pune 411027. Location: https://bit.ly/2Ke26fQ";
					}
					
					$messagessss =$txt_msg;
					$search_by = array("student_name","isas_address","&");
					$replace_by = array($name,$address,"and");
					"<br/>".$messagessss = str_replace($search_by, $replace_by, $messagessss);
					
					"<br/>".$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='136' ".$_SESSION['where']."";
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
					send_sms_function($contact,$messagessss);
					//------send notification on Sale voucher--------------------
						$notification_args['reference_id'] =$record_id;
						$notification_args['on_action'] = 'product_purchase';
						$notification_status = addNotifications($notification_args);
					//---------------------------------------------------------------
					//=========================================================================
					?><div id="statusChangesDiv" title="Record added"><center><br><p>Record added successfully</p></center></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" );}
												 }
								});
								
							});
						//setTimeout('document.location.href="manage_inventory.php";',500);
						</script>

					<?php
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
                	<input type="hidden" name="res1" id="res1" />
            		<input type="hidden" name="res_tax" id="res_tax" />
                    <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                </tr>
				<tr>
					<td width="20%">Date<span class="orange_font">*</span></td>
					<td width="49%"><?php 
					if($_SESSION['type']=='S')
					{
						if($_POST['added_date']) 
							$new_date=$_POST['added_date']; 
						else if($row_record['added_date']!='')
						{
							$arrage_date=explode(' ',$row_record['added_date']);
							$arr_date=explode('-',$arrage_date[0]);
							$new_date=$arr_date[2].'/'.$arr_date[1].'/'.$arr_date[0];
						}
						else
						{
							$new_date=date("d/m/Y");
						}?>
                        <input type="text" id="added_date" style="width:200px" name="added_date" class="input_text datepicker" value="<?php echo $new_date; ?>" />
                        <?php
					}
					else
					{
						if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode(' ',$row_record['added_date'],2); $arr_date=explode('-',$arrage_date[0]);echo $arr_date[2].'/'.$arr_date[1].'/'.$arr_date[0];}else{echo date("d/m/Y");}?>
						<input type="hidden" id="added_date" style="width:200px" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode(' ',$row_record['added_date'],3);$arr_date=explode('-',$arrage_date[0]);echo $arr_date[2].'/'.$arr_date[1].'/'.$arr_date[0];}else{echo date("d/m/Y");}?>" />
						<?php 
					}
					?>
					</td>
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
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)" style="width:200px">';
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
                  <td>Select Vendor <span class="orange_font">*</span></td>
                  <td>
                   <select name="vendor_id" id="vendor_id" class="input_select" style="width:200px;" onChange="get_asset_list(this.value)">
                   <option value="">Select Vender</option>
                   <?php
				    $sql_vendor ="select name, vendor_id from vendor where 1 ".$_SESSION['where']." order by vendor_id asc";
					$ptr_vendor = mysql_query($sql_vendor);
					while($data_vendor = mysql_fetch_array($ptr_vendor))
					{ 
						$selecteds = '';
						if($data_vendor['vendor_id']==$row_record['vendor_id'])
						$selecteds = 'selected="selected"';	
						echo "<option value='".$data_vendor['vendor_id']."' ".$selecteds.">".$data_vendor['name']."</option>";
					}
                   ?>
                   </select>
                  </td>
           </tr>
           <?php 

		      $rowSQL = mysql_query("SELECT MAX(asset_id) as max FROM `assets`" );
			  $row = mysql_fetch_array( $rowSQL );
			  $largestNumber = $row['max']+1;
		   ?>
           <tr>
                  <td width="15%" valign="top">Invoice No.<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="input_text" name="invoice_no" id="invoice_no" value="<?php if($_POST['save_changes']) echo $_POST['invoice_no']; else if($row_record['invoice_no'] !='') echo $row_record['invoice_no']; else echo $largestNumber;?>" style="width:200px" /></td> 
                  <td width="10%"></td>
              </tr>
           <tr>
                  <td width="15%" valign="top">Referal invoice No.<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="input_text" name="ref_invoice_no" id="ref_invoice_no" value="<?php if($_POST['save_changes']) echo $_POST['ref_invoice_no']; else if($row_record['ref_invoice_no'] !='') echo $row_record['ref_invoice_no']; ?>" style="width:200px" /></td> 

                  <td width="10%"></td>

          	</tr>
          
			<!--===========================================================NEW TABLE START===================================-->   

           	<tr>
				<td colspan="3">
                <table  width="100%" style="border:1px solid gray; ">
                    <tr>
                    <td colspan="2">
                    <table cellpadding="5" width="100%" >
                     <tr>
                     <?php
					 if($record_id =='')
					 {
						?>
                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1"  onKeyUp="create_floor();" value="0" />
                        <?php 
					 }?>
                     <script language="javascript">
                                function floors(idss)
                                {
									res= document.getElementById("res1").value;

                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td><div id="prod_list"></div></td></tr><tr><td width="10%" align="left"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:200px" onChange="getprice(this.value,'+idss+')"><option value="">Select Product</option>'+res+'</select></td><td width="6%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_price'+idss+'"  id="sin_product_price'+idss+'" style=" width:60px" /></td><td width="6%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_base_price'+idss+'" id="sin_product_base_price'+idss+'" style="width:60px" /></td><td width="5%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_qty'+idss+'" id="sin_product_qty'+idss+'" style=" width:40px" /></td><td width="8%" align="center"><input type="text" name="sin_product_disc'+idss+'" id="sin_product_disc'+idss+'" onkeyup="getDiscount('+idss+')"  disabled="disabled" style=" width:70px" /><input type="hidden" name="sin_prod_disc_price'+idss+'" id="sin_prod_disc_price'+idss+'" /></td><td width="4%" align="center"><input type="text" name="prod_discounted_price'+idss+'" disabled="disabled" id="prod_discounted_price'+idss+'" style="width:60px" /><input type="hidden" name="prod_disc_price'+idss+'" id="prod_disc_price'+idss+'" /></td><td width="5%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_cgst'+idss+'" id="sin_product_cgst'+idss+'" style=" width:40px"><input type="text" name="sin_prod_cgst_price'+idss+'" style=" width:40px" id="sin_prod_cgst_price'+idss+'" /></td><td width="5%" align="center"><input type="text" disabled="disabled" name="sin_product_sgst'+idss+'" onkeyup="getDiscount('+idss+')" id="sin_product_sgst'+idss+'" style=" width:40px"><input type="text" name="sin_prod_sgst_price'+idss+'" style=" width:40px" id="sin_prod_sgst_price'+idss+'" /></td><td width="5%" align="center"><input type="text" disabled="disabled" name="sin_product_igst'+idss+'" onkeyup="getDiscount('+idss+')" id="sin_product_igst'+idss+'" style=" width:40px"><input type="text" name="sin_prod_igst_price'+idss+'" id="sin_prod_igst_price'+idss+'" style=" width:40px" /></td><td width="4%" align="center"><input type="text" disabled="disabled" name="mrp_price'+idss+'" id="mrp_price'+idss+'" readonly="readonly" style="width:60px" /></td><td width="6%" align="center"><input type="text" disabled="disabled" name="sin_product_total'+idss+'" id="sin_product_total'+idss+'" style=" width:60px"></td><td width="10%"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:100px"><option value="">Select Staff</option><?php 
									/*$sel_staff = "select admin_id,name from site_setting order by admin_id asc";
									$query_staff = mysql_query($sel_staff);
									if($total_staff=mysql_num_rows($query_staff))
									{
										while($data=mysql_fetch_array($query_staff))
										{
											echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
										}
									}*/
									if($_SESSION['type']=="S")
									{
										$sel_staff = "select admin_id,name from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." order by name asc";	 
										$query_staff = mysql_query($sel_staff);
										if($total_staff=mysql_num_rows($query_staff))
										{
											
											while($data=mysql_fetch_array($query_staff))
											{
												$selected='';
												if($data['admin_id'] == $_SESSION['admin_id'])
												{
												$selected='selected="selected"';
												}
												echo '<option '.$selected.' value="'.$data['admin_id'].'">'.$data['name'].'</option>';
											}
										}
									}
									else
									{
										$sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$prev_value." ".$_SESSION['where']."  ";
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
									}
									?>
									</select></td><td width="2%" align="center"><a onClick="reset_price('+idss+')"><img src="images/refresh.png" height="25" width="25" alt="refresh"></a><input type="hidden" name="base_price'+idss+'" id="base_price'+idss+'" value="" /></td><td valign="top" width="1%" align="center"><input type="hidden" name="total_product[]" id="total_product'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></tr><tr><td colspan="7"><div style="display:none" id="product_details'+idss+'"><table style="width:100%" align="center"><tr><td width="10%">Price : <span id="price_desc'+idss+'"></span></td><td width="10%">Brand : <span id="brand'+idss+'"></span></td><td width="10%">Unit : <span id="unit_desc'+idss+'"></span><span id="measure_desc'+idss+'"></span></td><td width="70%">Product Desc.: <span id="description_desc'+idss+'"></span></td></tr></table></div></td></tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                        </script>
						<td align="right"><input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
						<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
					</td></tr>
                    <tr><td></td><td align="left"></td></tr>
                </table> 
                <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
    				<tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
    				<tr>
                        <td colspan="7">
                        	<table cellspacing="3" id="tbl" width="100%">
                        		<tr>
                        			<td valign="top" width="20%" align="center">Asset Name</td>
                                    <td valign="top" width="7%"  align="center">MRP</td>
                        			<td valign="top" width="7%"  align="center">Base Price</td>
                        			<td valign="top" width="5%"  align="center">Qty </td>
                        			<td valign="top" width="8%"  align="center">Discount in<br/>
                        			<input type="radio" name="products_disc_type" onChange="getDiscount()" id="products_disc_type" checked="checked" value="percentage" <?php if($_POST['products_disc_type']=="percentage") {echo 'checked="checked"';}else if($row_record['asset_disc_type']=="percentage") { echo 'checked="checked"';} ?>  />%<input type="radio" name="products_disc_type" onChange="getDiscount()" id="products_disc_type" value="rupees" <?php if($_POST['products_disc_type']=="rupees") {echo 'checked="checked"';}else if($row_record['asset_disc_type']=="rupees") { echo 'checked="checked"';} ?> />Rs/-</td>
                                    <td valign="top" width="7%"  align="center">Discounted Price</td>
									<td valign="top" width="5%"  align="center">CGST</td>
									<td valign="top" width="5%"  align="center">SGST</td>
									<td valign="top" width="5%"  align="center">IGST</td>
                                    <td valign="top" width="7%"  align="center">MRP</td>
                        			<td valign="top" width="7%"  align="center">Total Price</td>
                        			<td valign="top" width="10%"  align="center">Staff</td>
                                    <td valign="top" width="5%" align="center">Reset</td>
									<?php
									if($record_id!='')
									{
										?>
										<!--<td valign="top" width="2%"  align="center">Acton</td>-->
										<?php
									}
									?>
                        		</tr>
                        		<tr>
                           			<td colspan="15">
									<?php
									if($record_id!='')
									{
                            			$select_exc ="select * from assets_map where asset_id='".$record_id."' and asset_type_id!='' order by map_id asc ";
                            			$ptr_fs = mysql_query($select_exc);
                            			$t=1;
                            			$total_comision= mysql_num_rows($ptr_fs);
                            			$total_conditions= mysql_num_rows($ptr_fs);
                            			while($data_exclusive = mysql_fetch_array($ptr_fs))
                            			{ 
                                			$slab_id= $data_exclusive['map_id'];
											?> 
											<div class="floor_div" id="floor_id<?php echo $t; ?>">
											<table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
												<tr>
													<td width="10%" align="center">
													<select name="product_id<?php echo $t; ?>" id="product_id<?php echo $t; ?>" style="width:200px" onChange="getprice(this.value,<?php echo $t; ?>)"><option value="">Select Product</option><?php
													
													$sel_tel ="select asset_type_id,asset_name,price from assets_type ".$_SESSION['where']." order by asset_type_id asc";	 
													$query_tel = mysql_query($sel_tel);
													if($total=mysql_num_rows($query_tel))
													{
														while($data=mysql_fetch_array($query_tel))
														{
															$selected='';
															if($data_exclusive['asset_type_id'] ==$data['asset_type_id'] )
															{
																$selected='selected="selected"';
															}
															echo '<option value="'.$data['asset_type_id'].'" '.$selected.'>'.$data['asset_name'].'</option>';
														}
													}
													
													?>
													</select>
													</td>
													<td width="6%" align="center"><input type="text" name="sin_product_price<?php echo $t; ?>" id="sin_product_price<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['sin_asset_price'] ?>" onkeyup="getDiscount(<?php echo $t; ?>)" /></td>
													<td width="6%" align="center"><input type="text" name="sin_product_base_price<?php echo $t; ?>" id="sin_product_base_price<?php echo $t; ?>" style=" width:60px;background-color:#cccc" readOnly value="<?php echo $data_exclusive['sin_asset_base_price'] ?>" onkeyup="getDiscount(<?php echo $t; ?>)" /></td>
													<td width="5%" align="center"><input type="text"name="sin_product_qty<?php echo $t; ?>" id="sin_product_qty<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['sin_asset_qty'] ?>" onKeyUp="getDiscount(<?php echo $t; ?>)"/></td>
													<td width="8%" align="center"><input type="text" name="sin_product_disc<?php echo $t; ?>" id="sin_product_disc<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_asset_disc'] ?>" onKeyUp="getDiscount(<?php echo $t; ?>)"  style=" width:70px" /><input type="hidden" name="sin_prod_disc_price<?php echo $t; ?>" id="sin_prod_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_asset_disc_price'] ?>" /></td>
													<td width="4%" align="center"><input type="text" name="prod_discounted_price<?php echo $t; ?>" id="prod_discounted_price<?php echo $t; ?>" style="width:60px" value="<?php echo $data_exclusive['discounted_price'] ?>" /><input type="hidden" name="prod_disc_price<?php echo $t; ?>" id="prod_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['discounted_price'] ?>" /></td>
													<td width="5%" align="center"><input type="text" onkeyup="getDiscount(<?php echo $t; ?>)" name="sin_product_cgst<?php echo $t; ?>" id="sin_product_cgst<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['cgst_tax_in_per'] ?>" /><input type="text" name="sin_prod_cgst_price<?php echo $t; ?>" style=" width:40px" id="sin_prod_cgst_price<?php echo $t; ?>" value="<?php echo $data_exclusive['cgst_tax'] ?>" /></td>
													<td width="5%" align="center"><input type="text" name="sin_product_sgst<?php echo $t; ?>" onkeyup="getDiscount(<?php echo $t; ?>)" id="sin_product_sgst<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['sgst_tax_in_per'] ?>" /><input type="text" name="sin_prod_sgst_price<?php echo $t; ?>" style=" width:40px" id="sin_prod_sgst_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sgst_tax'] ?>" /></td>
													<td width="5%" align="center"><input type="text" name="sin_product_igst<?php echo $t; ?>" onkeyup="getDiscount(<?php echo $t; ?>)" id="sin_product_igst<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['igst_tax_in_per'] ?>" /><input type="text" name="sin_prod_igst_price<?php echo $t; ?>" id="sin_prod_igst_price<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['igst_tax'] ?>" /></td>
													<td width="4%" align="center"><input type="text" name="mrp_price<?php echo $t; ?>" id="mrp_price<?php echo $t; ?>" readonly="readonly" style="width:60px" value="<?php echo $data_exclusive['sin_asset_price'] ?>" /></td>
													<td width="6%" align="center"><input type="text"  name="sin_product_total<?php echo $t; ?>" id="sin_product_total<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['sin_asset_total'] ?>"></td>
													
													<td width="10%">
													<select name="staff_id<?php echo $t; ?>" id="staff_id<?php echo $t; ?>" style="width:100px">
													<option value="">Select Staff</option>
													<?php
													$sel_staff = "select admin_id,name from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." order by admin_id asc";	 
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
													</select>
													</td>
													<td width="2%" align="center"><a onClick="reset_price(<?php echo $t; ?>)"><img src="images/refresh.png" height="25" width="25" alt="refresh"></a><input type="hidden" name="base_price<?php echo $t; ?>" id="base_price<?php echo $t; ?>" value="<?php if($record_id!='') echo '0'; ?>" /><br/>
													<?php
													if($record_id)
													{
													?>
													<input type="hidden" name="total_product[]" id="total_product<?php echo $t; ?>" />
													<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['map_id'] ?>" />
													<input type="button" title="Delete Options(-)" onClick="delete_product(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
													<input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
													</td>
													
													<?php
													}
													/* if($record_id)
													{ */
													?>
														<!--<td valign="top" width="6%" align="center">
														<input type="hidden" name="total_product[]" id="total_product<?php //echo $t; ?>" />
														<input type="hidden" name="floor_id<?php //echo $t; ?>" id="floor_id_<?php //echo $t; ?>" value="<?php //echo $data_exclusive['map_id'] ?>" />
														<input type="button" title="Delete Options(-)" onClick="delete_product(<?php //echo $t; ?>,'floor');" class="delBtn" name="del">
														<input type="hidden" name="del_floor<?php //echo $t; ?>" id="del_floor<?php //echo $t; ?>" value="" />
														</td>-->
													<?php
													//} ?>   
													
												</tr>
											</table>
											</div>
											<script>
											$("#product_id<?php echo $t; ?>").chosen({allow_single_deselect:true});
											</script>
											<?php
											$t++;
                         				}
									}
                       					?>
                                    </td>
                        		</tr> 
                        	</table>
                       		<input type="hidden" name="floor" id="floor"  value="0" />
                        	<div id="create_floor"></div>
                    	</td>
                     </tr>
                </table>
                <?php
				if($record_id !='')
				{
				?>
                    <input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
                    <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
                	<?php 
				} 
				?> 
                </td>
             </tr>
         </table>
      </td>
   </tr>
       <!--============================================================END TABLE=========================================-->
           <tr>
                <td width="20%" valign="top">Asset Price <span class="orange_font">*</span></td>
                <td width="70%"><input type="text" class="input_text" onChange="showUser()" name="price" id="price" style="width:200px" value="<?php if($_POST['price']) echo $_POST['price']; else echo $row_record['price'];?>"/></td> 
                <td width="10%"></td>
           </tr>
           <tr>
            	<td width="20%" valign="top">Discount  
                <input type="radio" name="discount_type" onChange="showUser()" id="discount_type" checked="checked" value="percentage" <?php if($_POST['discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %
                <input type="radio" name="discount_type" id="discount_type" onChange="showUser()" value="rupees" <?php if($_POST['discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/</td>
            	<td width="72%"><input type="text" class=" input_text" name="discount" id="discount" style="width:200px" onBlur="showUser()" value="<?php if($_POST['discount']){echo $_POST['discount'];} else {echo $row_record['discount'];}?>" /></td> 
            	<td width="5%"></td>
            </tr>
            <tr>
            	<td width="20%" valign="top">Discount Price</td>
            	<td width="72%"><input type="text" class=" input_text" name="discount_price" id="discount_price" style="width:200px" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_record['discount_price'];?>" /></td> 
            	<td width="5%"></td>
            </tr>
            <tr>
            <input type="hidden" name="total_cost_discount"  id="total_cost_discount"  />
                <td width="25%">Total Cost :</td>
                <td width="40%"><input type="text" readonly="readonly" name="total_cost" class="input_text" style="width:200px" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>" /></td>
        </tr>
        <!---------------------------------------Payment mode------------------------------------->  
        <tr>
            <td class="tr-header">Select Payment Mode <span class="orange_font">*</span></td>
            <td width="25%"><select name="payment_mode" id="payment_mode" onChange="payment(this.value)" style="width:200px">
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
					<td width="26%" class="tr-header" >Bank Name</td>
					<td>
					<div id="bank_record">
					</div>
					<div id="bank_id"></div>
					</td>
				</tr>
                <tr>
					<td class="tr-header" width="26%">Account No</td>
					<td><input type="text" name="account_no" readonly="readonly" id="account_no" style="width:200px" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
				</tr>
            </table>
			</div>         
			<div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
			<table width="100%">
				<tr>
					<td class="tr-header" width="26%">Enter Chaque No</td>
						<td><input type="text" name="chaque_no" id="chaque_no" style="width:200px" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>
				</tr>
				<tr>
					<td class="tr-header" width="26%">Enter Chaque Date</td>
					<td><input type="text" name="cheque_date" id="cheque_date" style="width:200px" class="datepicker" value="<?php if($_POST['cheque_date']) echo $_POST['cheque_date']; else if($row_record['chaque_date']!=''){ 
					$chaque_date_exp=explode('-', $row_record['chaque_date']);
					echo $sep_check_date=$chaque_date_exp[2].'/'.$chaque_date_exp[1].'/'.$chaque_date_exp[0];
					} ?>"  /></td>
				</tr>
			</table>
			</div>
			<div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' 	style="display:none"'; ?>>
                <table width="100%">
					<tr>
						<td class="tr-header" width="26%">Enter Credit Card No</td>
						<td><input type="text" name="credit_card_no" id="credit_card_no" maxlength="4" style="width:200px" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
    <!---------------------------------------End Payment mode------------------------------------->
	<tr>
		<td width="25%" >Amount</td>
		<td width="40%"><input type="text" name="amount1" id="amount1" style="width:200px" value="<?php if($_POST['save_changes']) echo $_POST['amount1']; else echo $row_record['amount1']; ?>"  /></td>
	</tr>
	<tr>
		<td width="25%" >Payable Amount</td>  
		<td width="40%"><input type="text" name="payable_amount" style="width:200px" id="payable_amount" value="<?php if($_POST['save_changes']) echo $_POST['payable_amount']; else echo $row_record['payable_amount']; ?>" onKeyUp="cal_remaining_amt();"/></td>
	</tr> 
	<tr>
		<td width="25%"><div id="wallet" style="display:none">Wallet Balance<input type="hidden" name="wallet_amount" id="wallet_amount" /><input type="hidden" name="wallet_amnt" id="wallet_amnt" /></div></td>
				<td width="40%" id="wallet_bal" style="display:none"></td>
	<tr>
		<td width="25%" >Remaining Amount</td>  
		<td width="40%"><input type="text" name="remaining_amount" id="remaining_amount" style="width:200px" value="<?php if($_POST['save_changes']) echo $_POST['remaining_amount']; else echo $row_record['remaining_amount']; ?>"  /></td> 
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Inventory" name="save_changes"  /></td>
		<td></td>
	</tr>
</table>
</form>
</td>
</tr>
<?php
}
?>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<?php
/*if($_SESSION['type']=="S" || $record_id)
{
*/
?>
<script>
if(document.getElementById("branch_name"))
{
	branch_name =document.getElementById("branch_name").value;
	show_bank(branch_name);
}
</script>
<?php
//exit();
//}
?>
<script language="javascript">
//create_floor('add');
//create_type1('add_type1');
</script>
<script>
	function showUser()
	{
		//alert("hiiii");
		contact='';
		var total_product= document.getElementsByName("total_product[]");
		totals=total_product.length;
		for(i=1; i<=totals;i++)
		{
			//alert(i);
			servicesss_idddd=Number(document.getElementById("sin_product_total"+i).value);
			//alert(servicesss_idddd);
			if(servicesss_idddd!='')
			{
				contact =Number(contact)+Number(servicesss_idddd);
				//alert(contact);
			}
		}
		document.getElementById('price').value=contact;
		var total_prods_price=contact;
		if(document.getElementById('discount').value)
		{	
			var discount= parseFloat(document.getElementById('discount').value).toFixed(2);
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
			var total_discount_price= parseFloat(total_prods_price - discount_price).toFixed(2);
			document.getElementById('discount_price').value=discount_price;
		}
		else
		{
			var total_discount_price=total_prods_price;
			document.getElementById('discount_price').value=discount_price;
		}
		document.getElementById('total_cost').value=total_discount_price;
		document.getElementById('amount1').value=total_discount_price;
		calculte_amount_tax();
	}
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
if($record_id!='')
{
	?>
    <script>
	vendor_id =document.getElementById("vendor_id").value;
	//alert(vendor_id);
	setTimeout(get_asset_list(vendor_id),500);
    //create_floor('add');
	//branch_name1 =document.getElementById("branch_name").value;
	//alert(branch_name1)
	//show_bank(branch_name1);
	</script>
    <?php
}
?>
</body>
</html>
<?php $db->close();?>