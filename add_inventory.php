<?php
ini_set('memory_limit','500M');
ini_set('max_execution_time', 0);
ini_set('max_input_vars', 50000);
ini_set('post_max_size', '500M');

include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM inventory where inventory_id='".$record_id."'";
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
else
	$record_id='';
	
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='136'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html><!--PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Inventory</title>
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
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>

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
		$("#agent_id").chosen({allow_single_deselect:true});
		//$("#product_id1").chosen({allow_single_deselect:true});
		<?php
		if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});//product_id1
			<?php
		}
		?>
     });
	 $(document).keypress(
		function(event){
		 if (event.which == '13') {
			event.preventDefault();
		  }
	});
    </script>
    <!--<script language="javascript" src="js/script.js"></script>-->
<script language="javascript" src="js/conditions-script.js"></script>
<script>
var reslts='';
record_id='';
function get_product_list(vendor_id)
{
	var record_id= document.getElementById("record_id").value;
	var total_product= document.getElementsByName("total_product[]");
	var totals=total_product.length;

	/*if(vendor_id!=record_id)// comment on 27/2/19
	{
		for(i=1;i<=totals;i++)
		{
			
			document.getElementById("floor_id"+i).innerHTML='';
		}
		var total_tax=document.getElementsByName("total_tax[]").length;

		for(j=1;j<=total_tax;j++)
		{
			document.getElementById("type1_id"+j).innerHTML='';
		}
		document.getElementById("create_floor").innerHTML='';
		document.getElementById("create_type1").innerHTML='';
		document.getElementById("no_of_floor").value=0;
		document.getElementById("price").value=0;
		document.getElementById("discount").value=0;
		document.getElementById("total_cost").value=0;
		document.getElementById("amount1").value=0;
	}*/
	var data1="vendor_id="+vendor_id+"totals="+totals;
	 //alert(data1)
	  $.ajax({
		url: "get_product_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			//res=html;
			document.getElementById("create_floor").innerHTML='';
			document.getElementById("create_type1").innerHTML='';
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
	var product_id=document.getElementById('product_id'+val_idss).value;
	var data1="product_id="+product_id;	
	$.ajax({
		url: "get_inven_product_price.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			product_price_inv=html;
			if(product_price_inv > 0)
			{
				document.getElementById("base_price"+val_idss).value=0;
				document.getElementById("sin_product_price"+val_idss).value=product_price_inv;
				document.getElementById("sin_product_base_price"+val_idss).value=product_price_inv;
				document.getElementById("sin_product_total"+val_idss).value=product_price_inv;
				var exit_disc=document.getElementById("sin_product_disc"+val_idss).value = 0;
				var exit_disc=document.getElementById("prod_discounted_price"+val_idss).value = product_price_inv;
				<?php
				if($_SESSION['tax_type']=='GST')
				{
					?>
					var exit_cgst=document.getElementById("sin_product_cgst"+val_idss).value = 0;
					var exit_sgst=document.getElementById("sin_product_sgst"+val_idss).value = 0;
					var exit_igst=document.getElementById("sin_product_igst"+val_idss).value = 0;
					<?php
				}
				else
				{
					?>
					var exit_vat=document.getElementById("sin_product_vat"+val_idss).value = 0;
					<?php
				}
				?>
				var exit_qty=document.getElementById("sin_product_qty"+val_idss).value = 1;
				
				document.getElementById("mrp_price"+val_idss).value=product_price_inv;
				document.getElementById("sin_product_base_price"+val_idss).style.backgroundColor="#cccc";
				document.getElementById("sin_product_price"+val_idss).style.backgroundColor="white";
				document.getElementById("sin_product_price"+val_idss).readOnly = false;
				document.getElementById("sin_product_base_price"+val_idss).readOnly = true;
				<?php
				if($record_id=='')
				{	
					?>
					var exit_main_discount=document.getElementById("discount").value=0;
					<?php 
				} ?>
			}
			else
			{
				document.getElementById("base_price"+val_idss).value=0;
				document.getElementById("sin_product_price"+val_idss).value=0;
				document.getElementById("sin_product_base_price"+val_idss).value=0;
				document.getElementById("sin_product_total"+val_idss).value=0;
				var exit_disc=document.getElementById("sin_product_disc"+val_idss).value = 0;
				var exit_disc=document.getElementById("prod_discounted_price"+val_idss).value = 0;
				<?php
				if($_SESSION['tax_type']=='GST')
				{
					?>
					var exit_cgst=document.getElementById("sin_product_cgst"+val_idss).value = 0;
					var exit_sgst=document.getElementById("sin_product_sgst"+val_idss).value = 0;
					var exit_igst=document.getElementById("sin_product_igst"+val_idss).value = 0;
					<?php
				}
				else
				{
					?>
					var exit_vat=document.getElementById("sin_product_vat"+val_idss).value = 0;
					<?php
				}
				?>
				var exit_qty=document.getElementById("sin_product_qty"+val_idss).value = 1;
				
				document.getElementById("mrp_price"+val_idss).value=0;
				document.getElementById("sin_product_base_price"+val_idss).style.backgroundColor="#cccc";
				document.getElementById("sin_product_price"+val_idss).style.backgroundColor="white";
				document.getElementById("sin_product_price"+val_idss).readOnly = false;
				document.getElementById("sin_product_base_price"+val_idss).readOnly = true;
				<?php
				if($record_id=='')
				{	
					?>
					var exit_main_discount=document.getElementById("discount").value=0;
					<?php 
				} ?>
			}
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
			<?php
			if($_SESSION['tax_type']=='GST')
			{
				?>
				document.getElementById("sin_product_cgst"+val_idss).disabled = false;
				document.getElementById("sin_product_sgst"+val_idss).disabled = false;
				document.getElementById("sin_product_igst"+val_idss).disabled = false;
				<?php
			}
			else
			{
				?>
				document.getElementById("sin_product_vat"+val_idss).disabled = false;
				<?php
			}
			?>
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
			<?php
			if($_SESSION['tax_type']=='GST')
			{
				?>
				document.getElementById("sin_product_cgst"+val_idss).disabled = true;
				document.getElementById("sin_product_sgst"+val_idss).disabled = true;
				document.getElementById("sin_product_igst"+val_idss).disabled = true;
				<?php
			}
			else
			{
				?>
				document.getElementById("sin_product_vat"+val_idss).disabled = true;
				<?php
			}
			?>
			document.getElementById("staff_id"+val_idss).disabled = true;
		}
		show_product_desc(val_idss);
		setTimeout(showUser,300);
		getDiscount(val_idss,500);
		//calculte_amount_tax(val_idss),800;
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
		//============================Calculate Base Price============================== Changes 9/2/21
		<?php
		if($_SESSION['tax_type']=='GST')
		{
			?>
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
				var tot_base_gst =roundNumber(parseFloat(product_price - total_base_taxable_value),3);
				//==========================================================================
				total_gst=roundNumber(parseFloat(Number(tot_gst)/k),3);
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
				var tot_base_gst =roundNumber(parseFloat(product_price - total_base_taxable_value),3);
				//==========================================================================
				total_gst=roundNumber(parseFloat(tot_gst/k),3);
				//gst_price=Number(parseFloat(igast_tax)).toFixed(2);
				document.getElementById("sin_prod_igst_price"+idss).value=roundNumber(total_base_taxable_value,2);
			}
			else
			{
			}
			<?php
		}
		else
		{
			?>
			//var k=0;
			servicetax=0;
			servicetax_percent=parseFloat(document.getElementById("sin_product_vat"+idss).value);
			if(servicetax_percent >0)
			{
				var servicetax=servicetax_percent;
				//var k =k+1;
				
			}
			total_gst=0;
			tot_gst=0;
			tot_base_gst=0;
			
			var totalgst=servicetax;
			var new_total_tax=parseFloat((totalgst+100)/100);
			//var total_taxable_value = parseFloat(total_price / new_total_tax);
			//var tot_gst =precisionRound(parseFloat(total_price - total_taxable_value),2);
			//=================================for base price===========================
			var total_base_taxable_value = parseFloat(product_price / new_total_tax);
			var tot_base_gst =roundNumber(parseFloat(product_price - total_base_taxable_value),3);
			//==========================================================================
			total_gst=roundNumber(parseFloat(tot_gst),3);
			//gst_price=Number(parseFloat(igast_tax)).toFixed(2);
			document.getElementById("sin_prod_vat_price"+idss).value=roundNumber(total_base_taxable_value,2);
			<?php
		}
		?>
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
		<?php
		if($_SESSION['tax_type']=='GST')
		{
			?>
			cgst_value=0;
			cgst_base_value=0;
			cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+idss).value).toFixed(2);
			if(cgst_percent >0)
			{
				cgst_value= roundNumber(parseFloat((total_price*cgst_percent)/100),3);
				cgst_base_value= roundNumber(parseFloat((total_base_price*cgst_percent)/100),3);<!--for base price-->
				cgst_price=roundNumber(parseFloat(cgst_value),3);
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
				sgst_value= roundNumber(parseFloat((total_price*sgst_percent)/100),3);
				sgst_base_value= roundNumber(parseFloat((total_base_price*sgst_percent)/100),3);<!--for base price-->
				sgst_price=roundNumber(parseFloat(sgst_value),3);
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
				igst_value= roundNumber(parseFloat((total_price*igst_percent)/100),3);
				igst_base_value= roundNumber(parseFloat((total_base_price*igst_percent)/100),3);<!--for base price-->
				igst_price=igst_value;
				document.getElementById("sin_prod_igst_price"+idss).value=igst_price;
			}
			else
			{
				document.getElementById("sin_prod_igst_price"+idss).value=0;
			}
			
			totals_price=roundNumber(Number(total_price) + Number(cgst_value) + Number(sgst_value)+ Number(igst_value),3);
			total_mrp_price=roundNumber(Number(total_base_price) + Number(cgst_base_value) + Number(sgst_base_value)+ Number(igst_base_value),3);
			<?php
		}
		else
		{
			?>
			service_value=0;
			service_base_value=0;
			service_percent=parseFloat(document.getElementById("sin_product_vat"+idss).value).toFixed(2);
			if(service_percent >0)
			{
				service_value= roundNumber(parseFloat((total_price*service_percent)/100),3);
				service_base_value= roundNumber(parseFloat((total_base_price*service_percent)/100),3);<!--for base price-->
				service_price=roundNumber(parseFloat(service_value),3);
				document.getElementById("sin_prod_vat_price"+idss).value=service_price;
			}
			else
			{
				document.getElementById("sin_prod_vat_price"+idss).value=0;
			}
			
			totals_price=roundNumber(Number(total_price) + Number(service_value),3);
			total_mrp_price=roundNumber(Number(total_base_price) + Number(service_base_value),3);
			<?php
		}
		?>
		//alert(total_mrp_price);
	}
	else
	{
	//================================CHANGES for BASE PRICE 0==========================================18/1/18
		/* var k=0;
		cgsttax=0;
		cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+prod_id).value);
		if(cgst_percent >0)
		{
			var cgsttax=cgst_percent;
			var k =k+1;
			
		}
		sgsttax=0;
		sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+prod_id).value);
		if(sgst_percent >0)
		{
			var sgsttax=sgst_percent;
			var k =k+1;
		}
		igsttax=0;
		igst_percent=parseFloat(document.getElementById("sin_product_igst"+prod_id).value);
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
			var total_taxable_value = parseFloat(total_price / tax_new);
			//alert(total_taxable_value);
			var tot_gst =precisionRound(parseFloat(total_price - total_taxable_value),2);
			//=================================for base price===========================
			var total_base_taxable_value = parseFloat(total_base_price / tax_new);
			var tot_base_gst =precisionRound(parseFloat(total_base_price - total_base_taxable_value),2);
			//==========================================================================
			total_gst=precisionRound(parseFloat(Number(tot_gst)/k),0);
			alert(total_gst);
			
			if(cgsttax >0 && (sgsttax <=0 || sgsttax==''))
			{
				document.getElementById("sin_prod_cgst_price"+prod_id).value=total_gst;
				document.getElementById("sin_prod_sgst_price"+prod_id).value=0;
			}
			else if(sgsttax >0 && (cgsttax <=0 || cgsttax==''))
			{
				document.getElementById("sin_prod_sgst_price"+prod_id).value=total_gst;
				document.getElementById("sin_prod_cgst_price"+prod_id).value=0;
			}
			else if(cgsttax >0 && sgsttax >0)
			{
				document.getElementById("sin_prod_cgst_price"+prod_id).value=total_gst;
				document.getElementById("sin_prod_sgst_price"+prod_id).value=total_gst;
			}
			else
			{
				document.getElementById("sin_prod_cgst_price"+prod_id).value=0;
				document.getElementById("sin_prod_sgst_price"+prod_id).value=0;
			}
			
		}
		else if(igsttax > 0)
		{
			var totalgst=igsttax;
			var new_total_tax=parseFloat((totalgst+100)/100);
			var total_taxable_value = parseFloat(total_price / new_total_tax);
			var tot_gst =precisionRound(parseFloat(total_price - total_taxable_value),2);
			//=================================for base price===========================
			var total_base_taxable_value = parseFloat(total_base_price / new_total_tax);
			var tot_base_gst =precisionRound(parseFloat(total_base_price - total_base_taxable_value),2);
			//==========================================================================
			total_gst=precisionRound(parseFloat(tot_gst/k),2);
			//gst_price=Number(parseFloat(igast_tax)).toFixed(2);
			document.getElementById("sin_prod_igst_price"+prod_id).value=precisionRound(total_taxable_value,0);
		}
		else
		{
			document.getElementById("sin_prod_cgst_price"+prod_id).value=0;
			document.getElementById("sin_prod_sgst_price"+prod_id).value=0;
			document.getElementById("sin_prod_igst_price"+prod_id).value=0;
		}
		
		totals_price=Number(total_price) - Number(tot_gst) ;
		totals_base_price=Number(total_base_price) - Number(tot_base_gst) ; //Fpr base price
		total_mrp_price=precisionRound(total_base_price,0);
		//alert(total_mrp_price); */
	//=========================================================END CHANGES==========================18/1/18
	//=============================================Changes 9/2/21 ====================================
		<?php
		if($_SESSION['tax_type']=='GST')
		{
			?>
			cgst_value=0;
			cgst_base_value=0;
			cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+idss).value).toFixed(2);
			if(cgst_percent >0)
			{
				cgst_value= roundNumber(parseFloat((total_price*cgst_percent)/100),3);
				cgst_base_value= roundNumber(parseFloat((total_base_price*cgst_percent)/100),3);
				cgst_price=cgst_value;
				document.getElementById("sin_prod_cgst_price"+idss).value=cgst_price;
			}
			else
			{
				document.getElementById("sin_prod_cgst_price"+idss).value=0;
			}
			sgst_value=0;
			sgst_base_value=0;
			sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+idss).value);
			if(sgst_percent >0)
			{
				sgst_value= roundNumber(parseFloat((total_price*sgst_percent)/100),3);
				sgst_base_value= roundNumber(parseFloat((total_base_price*sgst_percent)/100),3);
				sgst_price=sgst_value;
				document.getElementById("sin_prod_sgst_price"+idss).value=sgst_price;
			}
			else
			{
				document.getElementById("sin_prod_sgst_price"+idss).value=0;
			}
			igst_value=0;
			igst_base_value=0;
			igst_percent=roundNumber(document.getElementById("sin_product_igst"+idss).value,3);
			if(igst_percent >0)
			{
				igst_value= roundNumber(parseFloat((total_price*igst_percent)/100),3);
				igst_base_value= roundNumber(parseFloat((total_base_price*igst_percent)/100),3);
				igst_price=roundNumber(parseFloat(igst_value),3);
				document.getElementById("sin_prod_igst_price"+idss).value=igst_price;
			}
			else
			{
				document.getElementById("sin_prod_igst_price"+idss).value=0;
			}
			//alert(total_price+"-"+cgst_value+"-"+sgst_value);
			totals_price=roundNumber(Number(total_price) + Number(cgst_value) + Number(sgst_value)+ Number(igst_value),3);
			total_mrp_price=roundNumber(Number(total_base_price) + Number(cgst_base_value) + Number(sgst_base_value)+ Number(igst_base_value),3);
			//alert(totals_price);
			<?php
		}
		else
		{
			?>
			service_value=0;
			service_base_value=0;
			service_percent=parseFloat(document.getElementById("sin_product_vat"+idss).value).toFixed(2);
			if(service_percent >0)
			{
				service_value= roundNumber(parseFloat((total_price*service_percent)/100),3);
				service_base_value= roundNumber(parseFloat((total_base_price*service_percent)/100),3);
				service_price=service_value;
				document.getElementById("sin_prod_vat_price"+idss).value=service_price;
			}
			else
			{
				document.getElementById("sin_prod_vat_price"+idss).value=0;
			}
			
			totals_price=roundNumber(Number(total_price) + Number(service_value),3);
			total_mrp_price=roundNumber(Number(total_base_price) + Number(service_base_value),3);
			//alert(totals_price);
			<?php
		}
		?>
	}
	if(base_price==1)
	{
		document.getElementById("sin_product_price"+idss).value=total_mrp_price;
		document.getElementById("mrp_price"+idss).value=total_mrp_price;
		document.getElementById("sin_product_total"+idss).value=totals_price;
	}
	else
	{
		//alert(totals_price);
		//alert(totals_base_price);
		document.getElementById("sin_product_total"+idss).value=totals_price;
		document.getElementById("sin_product_base_price"+idss).value=totals_base_price;
		document.getElementById("mrp_price"+idss).value=total_mrp_price;
		//document.getElementById("prod_discounted_price"+prod_id).value=totals_base_price;
	}
	
	
	showUser();
	calculte_total_cost();
	//calculte_amount_tax(idss);
}
/*
function getcgst(idss)
{
	
	frm = document.jqueryForm;  
	product_price=parseFloat(document.getElementById("sin_product_total"+idss).value).toFixed(2);
	cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+idss).value).toFixed(2);
	
	sin_product_qty=parseFloat(document.getElementById("sin_product_qty"+idss).value).toFixed(2);
	if(sin_product_qty!='0')
	{
		 total_price_qty=parseFloat(product_price * sin_product_qty).toFixed(2);
	}
	else if(sin_product_qty=='0')
	{
		total_price_qty=product_price;
	}
	//alert(total_price_qty);
	cgst_value= parseFloat((total_price_qty*cgst_percent)/100).toFixed(2);
	
	total_price=parseFloat(Number(total_price_qty)+Number(cgst_value)).toFixed(2);
	cgst_price=parseFloat(cgst_value).toFixed(2);
	
	document.getElementById("sin_prod_cgst_price"+idss).value=cgst_price;
	
	if(document.getElementById("sin_product_total"+idss))
	{
	  document.getElementById("sin_product_total"+idss).value=total_price;
	}
	showUser();
	calculte_total_cost();
	calculte_amount_tax(idss);
}
function getsgst(idss)
{
	frm = document.jqueryForm;  
	product_price=parseFloat(document.getElementById("sin_product_total"+idss).value).toFixed(2);
	sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+idss).value).toFixed(2);
	
	sin_product_qty=parseFloat(document.getElementById("sin_product_qty"+idss).value).toFixed(2);
	if(sin_product_qty!='0')
	{
		 total_price_qty=parseFloat(product_price * sin_product_qty).toFixed(2);
	}
	else if(sin_product_qty=='0')
	{
		total_price_qty=product_price;
	}
	
	sgst_value= parseFloat((total_price_qty*sgst_percent)/100).toFixed(2);
	total_price=parseFloat(Number(total_price_qty)+Number(sgst_value)).toFixed(2);
	sgst_price=parseFloat(sgst_value).toFixed(2);
	
	document.getElementById("sin_prod_sgst_price"+idss).value=sgst_price;
	
	if(document.getElementById("sin_product_total"+idss))
	{
	  document.getElementById("sin_product_total"+idss).value=total_price;
	}
	showUser();
	calculte_total_cost();
	calculte_amount_tax(idss);
}
function getigst(idss)
{
	frm = document.jqueryForm;  
	product_price=parseFloat(document.getElementById("sin_product_total"+idss).value).toFixed(2);
	igst_percent=parseFloat(document.getElementById("sin_product_igst"+idss).value).toFixed(2);
	
	sin_product_qty=parseFloat(document.getElementById("sin_product_qty"+idss).value).toFixed(2);
	if(sin_product_qty!='0')
	{
		 total_price_qty=parseFloat(product_price * sin_product_qty).toFixed(2);
	}
	else if(sin_product_qty=='0')
	{
		total_price_qty=product_price;
	}
	
	igst_value= parseFloat((total_price_qty*igst_percent)/100).toFixed(2);
	total_price=parseFloat(Number(total_price_qty)+Number(igst_value)).toFixed(2);
	igst_price=parseFloat(igst_value).toFixed(2);
	
	document.getElementById("sin_prod_igst_price"+idss).value=igst_price;
	
	if(document.getElementById("sin_product_total"+idss))
	{
	  document.getElementById("sin_product_total"+idss).value=total_price;
	}
	showUser();
	calculte_total_cost();
	calculte_amount_tax(idss);
}
*/
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
	//calculte_amount_tax();
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
	
	//setTimeout(calculte_amount_tax,800,val_tax_ids);
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
		alert("Would you like to add extra amount "+extra_amnt+" in Vendor's Wallet");
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
/*function payment(value)
{

		//alert(value)

		payment_mode=value.split("-")

		//alert(payment_mode[0]);

		if(payment_mode[0]=="cheque")

		{

			//alert('cheque')

			 document.getElementById("chaque_details").style.display = 'block';

			 document.getElementById("bank_details").style.display = 'block';

			 document.getElementById("credit_details").style.display = 'none';

		}

		else if(payment_mode[0]=="Credit Card")

		{

			 document.getElementById("chaque_details").style.display = 'none';

			 document.getElementById("bank_details").style.display = 'block';

			 document.getElementById("credit_details").style.display = 'block';

		}

		else

		{

			 document.getElementById("chaque_details").style.display = 'none';

			 document.getElementById("bank_details").style.display = 'none';

			 document.getElementById("credit_details").style.display = 'none';

		}

	}*/

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
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'block';
		show_bank_for_payment_mode(branch_name,"paytm")
	}
	else if(payment_mode[0]=="online")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"online")
	}
	else if(payment_mode[0]=="cash")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		document.getElementById("paytm_details").style.display = 'none';
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
		
		
		calculte_total_cost()
	}
	});
	
	var ven_data="action=show_vendor&branch_id="+branch_id+"&record_id="+record_id;
	$.ajax({
	url: "show_councellor.php",type:"post", data: ven_data,cache: false,
	success: function(vendData)
	{
		document.getElementById("vendor_ids").innerHTML=vendData;
		$("#vendor_id").chosen({allow_single_deselect:true});
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
	"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' ";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$j=0;
		while($data_cnt=mysql_fetch_array($ptr_cnt))
		{
			?>
			mail1[<?php echo $j; ?>]='<?php echo  $data_cnt['email'];?>';
			<?php
			$j++;
		}
	}
}
$sel_mail_text="select email_text from previleges where privilege_id='136'";
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
	if(document.getElementById('branch_name'))			  
		var branch_name =document.getElementById('branch_name').value;
	else 
		var branch_name ='';
	if(vendor=document.getElementById('vendor_id'))
		var vendor_id=vendor.options[vendor.selectedIndex].text;
	else 
		var vendor_id ='';
	if(document.getElementById('invoice_no'))
		var invoice_no =document.getElementById('invoice_no').value;
	else
		var invoice_no ='';
	if(document.getElementById('ref_invoice_no'))
		var ref_invoice_no =document.getElementById('ref_invoice_no').value;
	else
		var ref_invoice_no ='';
	if(document.getElementById('no_of_floor'))
		var total_service =document.getElementById('no_of_floor').value;
	else
		var total_service =0;
	concat_string='';
	for(i=1; i<=total_service; i++)
	{
		if(document.getElementById('product_id'+i))
		{
			var product = document.getElementById('product_id'+i);
			product_id = product.options[product.selectedIndex].text;
		}
		else {
			var product ='';
			var product_id ='';
		}
		if(document.getElementById('sin_product_price'+i))
			var sin_product_price =document.getElementById('sin_product_price'+i).value;
		else
			var sin_product_price ='';
		if(document.getElementById('sin_product_qty'+i))
			var sin_product_qty =document.getElementById('sin_product_qty'+i).value;
		else
			var sin_product_qty ='';
		if(document.getElementById('sin_product_disc'+i))
			var sin_product_disc =document.getElementById('sin_product_disc'+i).value;
		else
			var sin_product_disc ='';
		if(document.getElementById('sin_product_total'+i))
			var sin_product_total =document.getElementById('sin_product_total'+i).value;
		else
			var sin_product_total ='';
		if(document.getElementById('staff_id'+i))
		{
			staff =document.getElementById('staff_id'+i);
			staff_id = staff.options[staff.selectedIndex].text;
		}
		else {
			staff ='';
			staff_id = '';
		}
		concat_string +='&product_id'+i+'='+product_id+'&sin_product_price'+i+'='+sin_product_price+'&sin_product_qty'+i+'='+sin_product_qty+'&sin_product_disc'+i+'='+sin_product_disc+'&sin_product_total'+i+'='+sin_product_total+'&staff_id'+i+'='+staff_id;
	}
	if(document.getElementById('price'))
		var price =document.getElementById('price').value;
	else
		var price='';
	if(document.getElementById('discount'))
		var discount =document.getElementById('discount').value;
	else
		var discount ='';
	if(document.getElementById('discount_price'))
		var discount_price =document.getElementById('discount_price').value;
	else
		var discount_price ='';
	if(document.getElementById('total_cost'))
		var total_cost =document.getElementById('total_cost').value;
	else
		var total_cost ='';
	if(document.getElementById('type1'))
		var type1 =document.getElementById('type1').value;
	else
		var type1 =0;
		
	concat_string_tax='';
	for(j=1; j<=type1; j++)
	{
		if(document.getElementById('tax_type'+j))
		{
			tax =document.getElementById('tax_type'+j);
			tax_type = tax.options[tax.selectedIndex].text;
		}
		else
		{
			tax ='';
			tax_type ='';
		}
		if(document.getElementById('tax_value'+j))
		{
			tax_value =document.getElementById('tax_value'+j).value;
		}
		else
			tax_value ='';
		
		concat_string_tax +='&tax_type'+j+'='+tax_type+'&tax_value'+j+'='+tax_value;
	}
	if(document.getElementById('payment_mode'))
	{
		var payment=document.getElementById('payment_mode');
		payment_mode = payment.options[payment.selectedIndex].text;
	}
	else
	{
		var payment='';
		var payment_mode = '';
	}
	bank='';
	bank_details='';
	account_no='';
	chaque_details='';
	cheque_date='';
	credit_details='';
	credit_card_no='';
	if(document.getElementById('bank_name'))
	{
		var bank=document.getElementById('bank_name');
		bank_details=bank.options[bank.selectedIndex].text;
		var account_no =document.getElementById('account_no').value;
		var chaque_details =document.getElementById('chaque_no').value;
		var cheque_date =document.getElementById('cheque_date').value;
		var cheque_date =document.getElementById('credit_card_no').value;
	}
	if(document.getElementById('amount1'))
		var amount1 =document.getElementById('amount1').value;
	else
		var amount1 ='';
	if(document.getElementById('payable_amount'))
		var payable_amount =document.getElementById('payable_amount').value;
	else
		var payable_amount ='';
	if(document.getElementById('remaining_amount'))
		var remaining_amount =document.getElementById('remaining_amount').value;
	else
		var remaining_amount ='';
		
	var users_mail=mail1;
	data1='action=add_inventory&inv_product_id='+inv_product_id+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
	//data1='action=add_inventory&inv_product_id='+inv_product_id+'branch_name='+branch_name+'&vendor_id='+vendor_id+'&invoice_no='+invoice_no+'&ref_invoice_no='+ref_invoice_no+'&price='+price+'&discount='+discount+'&discount_price='+discount_price+'&total_cost='+total_cost+'&payment_mode='+payment_mode+'&bank_details='+bank_details+'&account_no='+account_no+'&chaque_details='+chaque_details+'&cheque_date='+cheque_date+'&credit_card_no='+credit_card_no+'&amount1='+amount1+'&payable_amount='+payable_amount+'&remaining_amount='+remaining_amount+concat_string+concat_string_tax+'&total_service='+total_service+'&type1='+type1+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
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
	/*var fields = $("input[name='requirment_id[]']").serializeArray(); 
	 if (fields.length == 0) 
	{ 
	    disp_error +='Select Product\n';
		error='yes';
	} */
	/*if(frm.discount.value=='')
	{
		disp_error +='Enter Discount\n';
		document.getElementById('discount').style.border = '1px solid #f00';
		frm.discount.focus();
		error='yes';
	}*/
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
			calculte_total_cost(); 
		}
	}
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
			//calculte_amount_tax(id);
		}
	}
}
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">
        <!-- Posted:
		<?php
		/*if ($_POST['vendor_id']) {
			echo var_dump($_POST);
		}*/
        ?>
        -->
        <?php
		$errors=array(); $i=0;
		$success=0;
		if(isset($_POST['save_changes']))
		{
			if($_POST['added_date'] !=''){
				$ad_date=explode('/',$_POST['added_date'],3);
				$added_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
			}
			else $added_date=date('Y-m-d');
			$vendor_id=( ($_POST['vendor_id'])) ? $_POST['vendor_id'] : "0";
			$agent_id=( ($_POST['agent_id'])) ? $_POST['agent_id'] : "0";
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
			$payable_amount=( ($_POST['payable_amount'])) ? $_POST['payable_amount'] : "0";
			$remaining_amount=($_POST['remaining_amount']) ? $_POST['remaining_amount'] : "0";
			if($payment_mode_id !="1" )
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
			$bank_ref_no=( ($_POST['bank_ref_no'])) ? $_POST['bank_ref_no'] : "0";
			$discount=( ($_POST['discount'])) ? $_POST['discount'] : "";
			$discount_type=( ($_POST['discount_type'])) ? $_POST['discount_type'] : "";
			$discount_price=( ($_POST['discount_price'])) ? $_POST['discount_price'] : "";
			
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
				$data_record['cm_id']=$_SESSION['cm_id'];
				$branch_name1=$_SESSION['branch_name'];
				$data_record['cm_id']=$_SESSION['cm_id'];
				$cm_id=$_SESSION['cm_id'];
				$cm_id1=$_SESSION['cm_id'];
			}
			$total_floor=$_POST['floor'];
			
			$uploaded_url="";
			if(count($errors)==0 && $_FILES['ref_invoice']["name"])
			{
				if($record_id && $row_record['ref_invoice']!='')
				{
					$update_news="update inventory set ref_invoice='' where inventory_id='".$record_id."'";
					$db->query($update_news);
					if($row_record['ref_invoice'] && file_exists("vendor_invoice/".$row_record['ref_invoice']))
						unlink("vendor_invoice/".$row_record['photo']);
					if($row_record['photo'] && file_exists("staff_photo/".$row_record['ref_invoice']))
						unlink("vendor_invoice/".$row_record['photo']);
				}
				$uploaded_url=time().basename($_FILES['ref_invoice']["name"]);
				$newfile = "vendor_invoice/";
				$filename = $_FILES['ref_invoice']['tmp_name']; // File being uploaded.
				$filetype = $_FILES['ref_invoice']['type'];// type of file being uploaded
				$filesize = filesize($filename); // File size of the file being uploaded.
				$source1 = $_FILES['ref_invoice']['tmp_name'];
				$target_path1 = $newfile.$uploaded_url;
				
				if(move_uploaded_file($source1, $target_path1))
				{
					$thump_target_path="vendor_invoice/".$uploaded_url;
					$file_uploaded=1;
				}
				else
				{
					$file_uploaded=0;
					$success=0;
					$errors[$i++]="There are some errors while uploading image, please try again";
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
				$data_record['vendor_id']=$vendor_id;
				$data_record['agent_id'] =$agent_id;
				//$data_record['product_id']=$product_id;
				$data_record['invoice_no']=$invoice_no;
				$data_record['price']=$price;
				//$data_record['discount']=$discount;
				$data_record['tax']=$tax;
				$data_record['total_cost']=$total_cost;
				//$data_record['branch_id']=$branch_id;
				$data_record['payment_mode_id'] =$payment_mode_id;
				$data_record['chaque_no'] =$chaque_no;
				$data_record['chaque_date'] =$chaque_date;
				$data_record['credit_card_no'] =$credit_card_no;
				$data_record['bank_ref_no'] = $bank_ref_no;
				$data_record['bank_id'] =$bank_name;
				$data_record['amount1'] = $amount1;
				$total_floor=$_POST['no_of_floor'];
				$total_type1=$_POST['total_type1'];
				$data_record['ref_invoice'] = $uploaded_url;
				
				$data_record['discount_type']=$discount_type;
				$data_record['discount']=$discount;
				$data_record['discount_price']=$discount_price;
				$data_record['products_disc_type']=( ($_POST['products_disc_type'])) ? $_POST['products_disc_type'] : "";
				$data_record['admin_id']=$_SESSION['admin_id'];
				
				$data_record['payable_amount']=$payable_amount;
				$data_record['remaining_amount']=$remaining_amount;
				$data_record['ref_invoice_no']=$ref_invoice_no;
				if($record_id)
				{
					$sel_inv="select sin_product_qty,product_id from inventory_product_map where inventory_id='".$record_id."'";
					$ptr_inv=mysql_query($sel_inv);
					while($data_inv=mysql_fetch_array($ptr_inv))
					{
						$qty=$data_inv['sin_product_qty'];
						$product_id=$data_inv['product_id'];
				
						$sel_qty="select quantity from product where `product_id`='".$product_id."'";
						$ptr_qty=mysql_query($sel_qty);
						$data_qty=mysql_fetch_array($ptr_qty);
						$total=intval($data_qty['quantity']-$qty);
						
						$sql_query="UPDATE `product` SET `quantity`='".$total."' WHERE `product_id`='".$product_id."'";
						$query=mysql_query($sql_query);
						
						$sel_stockiest="select admin_id from product where product_id='".$product_id."' ";
						$ptr_stock=mysql_query($sel_stockiest);
						$data_stock=mysql_fetch_array($ptr_stock);
						
						$ins_data="INSERT INTO `product_daily_report`(`product_id`,`cm_id`,`stockiest_id`,`type`, `purchase_qty`,`sales_qty`,`checkout_qty`,`vendor_id`,`cust_type`,`cust_id`,`todays_qty`,`todays_shelf_qty`, `todays_consumable_qty`,`description`,`admin_id`,`added_date`) VALUES ('".$product_id."','".$cm_id."','".$data_stock['admin_id']."','purchase','".$$qty."','0','0','".$vendor_id."','','','sin_product_qty -".$qty."','','','Product Purchase Edit Remove','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
						$ptr_ins=mysql_query($ins_data);
					}
					
					$delete_query1="delete from inventory_product_map where inventory_id='".$record_id."'";
					$db->query($delete_query1); 
					 
					$delete_query2="delete from inventory_tax_map where inventory_id='".$record_id."'";
					$db->query($delete_query2);
					
					$where_record="inventory_id='".$record_id."'";
					$db->query_update("inventory",$data_record,$where_record);
					
					for($i=1;$i<=$total_floor;$i++)
					{
						if($_POST['product_id'.$i]!='')
						{
							$data_record_service['inventory_id'] =$record_id; 
							$data_record_service['product_id']=( ($_POST['product_id'.$i])) ? $_POST['product_id'.$i] : "0";
							$data_record_service['sin_product_price']=( ($_POST['sin_product_price'.$i])) ? $_POST['sin_product_price'.$i] : "0";
							$data_record_service['sin_product_base_price']=( ($_POST['sin_product_base_price'.$i])) ? $_POST['sin_product_base_price'.$i] : "0";
							$data_record_service['sin_product_disc']=( ($_POST['sin_product_disc'.$i])) ? $_POST['sin_product_disc'.$i] : "0";
							$data_record_service['sin_prod_disc_price']=( ($_POST['sin_prod_disc_price'.$i])) ? $_POST['sin_prod_disc_price'.$i] : "0";
							$data_record_service['discounted_price']=( ($_POST['prod_discounted_price'.$i])) ? $_POST['prod_discounted_price'.$i] : "0";
							$data_record_service['disc_type']=( ($_POST['products_disc_type'])) ? $_POST['products_disc_type'] : "";
							$data_record_service['cgst_tax_in_per'] =$_POST['sin_product_cgst'.$i] ? $_POST['sin_product_cgst'.$i] : "0";
							$data_record_service['cgst_tax'] =$_POST['sin_prod_cgst_price'.$i] ? $_POST['sin_prod_cgst_price'.$i] : "0";
							$data_record_service['sgst_tax_in_per'] =$_POST['sin_product_sgst'.$i] ? $_POST['sin_product_sgst'.$i] : "0";
							$data_record_service['sgst_tax'] =$_POST['sin_prod_sgst_price'.$i] ? $_POST['sin_prod_sgst_price'.$i] : "0";
							$data_record_service['igst_tax_in_per'] =$_POST['sin_product_igst'.$i] ? $_POST['sin_product_igst'.$i] : "0";
							$data_record_service['igst_tax'] =$_POST['sin_prod_igst_price'.$i] ? $_POST['sin_prod_igst_price'.$i] : "0";
							$data_record_service['service_tax_in_per'] =$_POST['sin_product_vat'.$i] ? $_POST['sin_product_vat'.$i] : "0";
							$data_record_service['service_tax'] =$_POST['sin_prod_vat_price'.$i] ? $_POST['sin_prod_vat_price'.$i] : "0";
							
							$data_record_service['sin_product_total']=( ($_POST['sin_product_total'.$i])) ? $_POST['sin_product_total'.$i] : "0";
							$data_record_service['sin_product_qty']=( ($_POST['sin_product_qty'.$i])) ? $_POST['sin_product_qty'.$i] : "0";
							$data_record_service['admin_id']=( ($_POST['staff_id'.$i])) ? $_POST['staff_id'.$i] : "0";
							
							$customer_service_id=$db->query_insert("inventory_product_map", $data_record_service);
							
							$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
							$ptr_qty=mysql_query($sel_qty);
							$data_qty=mysql_fetch_array($ptr_qty);
							
							$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$i]);
							$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$i]."'";
							$query_prod_qty=mysql_query($update_prod_qty);
							
							$sel_stockiest="select admin_id from product where product_id='".$_POST['product_id'.$i]."' ";
							$ptr_stock=mysql_query($sel_stockiest);
							$data_stock=mysql_fetch_array($ptr_stock);
							
							$ins_data="INSERT INTO `product_daily_report`(`product_id`, `cm_id`, `stockiest_id`, `type`, `purchase_qty`, `sales_qty`, `checkout_qty`, `vendor_id`, `cust_type`, `cust_id`, `todays_qty`,`todays_shelf_qty`,`todays_consumable_qty`, `description`,`admin_id`,`added_date`) VALUES ('".$_POST['product_id'.$i]."','".$cm_id."','".$data_stock['admin_id']."','purchase','".$_POST['sin_product_qty'.$i]."','0','0','".$vendor_id."','','','sin_product_qty +".$_POST['sin_product_qty'.$i]."','','','Product Purchase Edit','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
							$ptr_ins=mysql_query($ins_data);
						}
					}
					/*for($j=1;$j<=$total_type1;$j++)
					{
						$data_record_tax['inventory_id'] =$record_id; 
						$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
						$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
						$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
						$customer_tax_id=$db->query_insert("inventory_tax_map", $data_record_tax);
					}*/
					
					$chaque_date_exp=explode('/', $chaque_date);
					$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
					
					$update_invoice="update `inventory_invoice` set `price`='".$price."',`total_cost`='".$total_cost."', `amount1`='".$amount1."',`payable_amount`='".$_POST['payable_amount']."',`remaining_amount`='".$_POST['remaining_amount']."', `paid_type`='".$payment_mode_id."',`bank_id`='".$bank_name."',`cheque_detail`='".$chaque_no."',`chaque_date`='".$sep_check_date."',`credit_card_no`='".$credit_card_no."',bank_ref_no='".$bank_ref_no."',`admin_id`='".$_SESSION['admin_id']."',`total_paid`='".$payable_amount."' where inventory_id='".$record_id."' order by invoice_id asc LIMIT 1";
					$ptr_sales_invoice = mysql_query($update_invoice); 
					//============================================================================
					if($payment_mode_id=='2' || $payment_mode_id=='4' || $payment_mode_id=='5')
					{
						$update_bank="update `bank_records` set `bank_id`='".$bank_name."', `type`='purchase', `record_id`='".$record_id."', `invoice_id`='".$ptr_sales_invoice."',`amount`='".$payable_amount."', `added_date`='".date('Y-m-d H:i:s')."' where record_id='".$record_id."' ";
						
						$bank_query=mysql_query($update_bank);  
					}
					/* for($z=1;$z<=$total_floor;$z++)
					{
						"Floor- ". $_POST['del_floor'.$z]."<br />";
						"<br />floor_id- ".$_POST['floor_id'.$z];
						if($_POST['del_floor'.$z]=='yes')
						{
							if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
							{
								"<br />".$delete_row = " delete from inventory_product_map where map_id='".$_POST['floor_id'.$z]."' ";
								$ptr_delete = mysql_query($delete_row);
							}
						}
						if($_POST['del_floor'.$z] !='yes')
						{
							$data_record_service['inventory_id'] =$record_id; 
							$data_record_service['product_id'] =$_POST['product_id'.$z];
							$data_record_service['sin_product_price'] =$_POST['sin_product_price'.$z];
							$data_record_service['sin_product_disc'] =$_POST['sin_product_disc'.$z];
							
							$data_record_service['cgst_tax_in_per'] =$_POST['sin_product_cgst'.$z];
							$data_record_service['cgst_tax'] =$_POST['sin_prod_cgst_price'.$z];
							$data_record_service['sgst_tax_in_per'] =$_POST['sin_product_sgst'.$z];
							$data_record_service['sgst_tax'] =$_POST['sin_prod_sgst_price'.$z];
							$data_record_service['igst_tax_in_per'] =$_POST['sin_product_igst'.$z];
							$data_record_service['igst_tax'] =$_POST['sin_prod_igst_price'.$z];
							
							$data_record_service['sin_product_total'] =$_POST['sin_product_total'.$z];
							$data_record_service['sin_product_qty'] =$_POST['sin_product_qty'.$z];
							$data_record_service['admin_id'] =$_POST['staff_id'.$z];
							if($_POST['floor_id'.$z]=='' && $_POST['product_id'.$z] !='')
							{
								$type1_id=$db->query_insert("inventory_product_map", $data_record_service);
								
								$sel_qty="select quantity,product_name from product where product_id='".$_POST['product_id'.$z]."' ";
								$ptr_qty=mysql_query($sel_qty);
								$data_qty=mysql_fetch_array($ptr_qty);
								$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$z]);
								$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$z]."'";
								$query_prod_qty=mysql_query($update_prod_qty);
								
								//$update_prod_qty="update product set quantity='(quantity + ".$_POST['sin_product_qty'.$z].")' where product_id='".$_POST['product_id'.$z]."'";
								//$query_prod_qty=mysql_query($update_prod_qty);
							}
							else
							{
								$where_record="map_id='".$_POST['floor_id'.$z]."'";
								$floor_id= $_POST['floor_id'.$z];
								$db->query_update("inventory_product_map", $data_record_service,$where_record);
								
								$sel_qty="select quantity,product_name from product where product_id='".$_POST['product_id'.$z]."' ";
								$ptr_qty=mysql_query($sel_qty);
								$data_qty=mysql_fetch_array($ptr_qty);
								$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$z]);
								$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$z]."'";
								$query_prod_qty=mysql_query($update_prod_qty); 
							}
							unset($data_record_service);
						}
					} */
					/* for($x=1;$x<=$total_type1;$x++)
					{
						 $_POST['tax_type'.$x];
						
						if($_POST['del_floor_type1'.$x]=='yes')
						{
							if($_POST['type1_id'.$x]!='' && $_POST['del_floor_type1'.$x]=='yes' )
							{
								"<br />".$delete_row = " delete from inventory_tax_map where inv_tax_map_id='".$_POST['type1_id'.$x]."' ";
								$ptr_delete = mysql_query($delete_row);
							}
						}
						if($_POST['del_floor_type1'.$x] !='yes')
						{
							$data_record_tax['inventory_id'] =$record_id; 
							 '<br/>'.$data_record_tax['tax_type'] =$_POST['tax_type'.$x];
							$data_record_tax['tax_value'] =$_POST['tax_value'.$x];
							$data_record_tax['tax_amount'] =$_POST['tax_amount'.$x];
							if($_POST['type1_id'.$x]=='' && $_POST['tax_type'.$x] !='')
							{
								$type1_id=$db->query_insert("inventory_tax_map", $data_record_tax);
							}
							else
							{
								$where_record="inv_tax_map_id='".$_POST['type1_id'.$x]."'";
								$type1_id= $_POST['type1_id'.$x];
								$db->query_update("inventory_tax_map", $data_record_tax,$where_record);
							}
							unset($data_record_tax);
						} 
					} */
					
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_inventory','Edit','inventory edit','".$record_id."','".date('Y-m-d H:i:s')."','".$data_record['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
					echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
				}
				else 
				{
					//==============Update Invoice No.=====================
					$sel_inv="select ext_invoice_no from inventory where cm_id='".$data_record['cm_id']."' and ext_invoice_no IS NOT NULL order by ext_invoice_no desc limit 0,1";
					$ptr_inv=mysql_query($sel_inv);
					$data_inv=mysql_fetch_array($ptr_inv);
					
					$recp=explode("/",$data_inv['ext_invoice_no']);
					$inv_no=intval($recp[2])+1;
					$preinv=$recp[0].'/'.$recp[1].'/';
					$data_record['ext_invoice_no']=$preinv.$inv_no;
					//======================================================
					$data_record['added_date'] =$added_date;
					$record_id=$db->query_insert("inventory", $data_record);
					$update_vendor="update vendor set wallet_balance='".$wallet_amount."' where vendor_id='".$vendor_id."'";
					$query_vendor=mysql_query($update_vendor);
					
					if($wallet_amount >0)
					{
					}
					for($i=1;$i<=$total_floor;$i++)
					{
						if($_POST['product_id'.$i] > 0)
						{
							$data_record_service['inventory_id'] =$record_id; 
							//$data_record_service['product_id'] =$_POST['product_id'.$i];
							$data_record_service['product_id']=( ($_POST['product_id'.$i])) ? $_POST['product_id'.$i] : "0";
							//$data_record_service['sin_product_price'] =$_POST['sin_product_price'.$i];
							$data_record_service['sin_product_price']=( ($_POST['sin_product_price'.$i])) ? $_POST['sin_product_price'.$i] : "0";
							$data_record_service['sin_product_base_price']=( ($_POST['sin_product_base_price'.$i])) ? $_POST['sin_product_base_price'.$i] : "0";
							//$data_record_service['sin_product_disc'] =$_POST['sin_product_disc'.$i];
							$data_record_service['sin_product_disc']=( ($_POST['sin_product_disc'.$i])) ? $_POST['sin_product_disc'.$i] : "0";
							//$data_record_service['sin_prod_disc_price'] =$_POST['sin_prod_disc_price'.$i];
							$data_record_service['sin_prod_disc_price']=( ($_POST['sin_prod_disc_price'.$i])) ? $_POST['sin_prod_disc_price'.$i] : "0";
							//$data_record_service['sin_product_total'] =$_POST['sin_product_total'.$i];
							$data_record_service['discounted_price']=( ($_POST['prod_discounted_price'.$i])) ? $_POST['prod_discounted_price'.$i] : "0";
							$data_record_service['disc_type']=( ($_POST['products_disc_type'])) ? $_POST['products_disc_type'] : "";
							$data_record_service['cgst_tax_in_per'] =$_POST['sin_product_cgst'.$i] ? $_POST['sin_product_cgst'.$i] : "0";
							$data_record_service['cgst_tax'] =$_POST['sin_prod_cgst_price'.$i] ? $_POST['sin_prod_cgst_price'.$i] : "0";
							$data_record_service['sgst_tax_in_per'] =$_POST['sin_product_sgst'.$i] ? $_POST['sin_product_sgst'.$i] : "0";
							$data_record_service['sgst_tax'] =$_POST['sin_prod_sgst_price'.$i] ? $_POST['sin_prod_sgst_price'.$i] : "0";
							$data_record_service['igst_tax_in_per'] =$_POST['sin_product_igst'.$i] ? $_POST['sin_product_igst'.$i] : "0";
							$data_record_service['igst_tax'] =$_POST['sin_prod_igst_price'.$i] ? $_POST['sin_prod_igst_price'.$i] : "0";
							$data_record_service['service_tax_in_per'] =$_POST['sin_product_vat'.$i] ? $_POST['sin_product_vat'.$i] : "0";
							$data_record_service['service_tax'] =$_POST['sin_prod_vat_price'.$i] ? $_POST['sin_prod_vat_price'.$i] : "0";
							$data_record_service['sin_product_total']=( ($_POST['sin_product_total'.$i])) ? $_POST['sin_product_total'.$i] : "0";
							//$data_record_service['sin_product_qty'] =$_POST['sin_product_qty'.$i];
							$data_record_service['sin_product_qty']=( ($_POST['sin_product_qty'.$i])) ? $_POST['sin_product_qty'.$i] : "0";
							//$data_record_service['admin_id'] =$_POST['staff_id'.$i];
							$data_record_service['admin_id']=( ($_POST['staff_id'.$i])) ? $_POST['staff_id'.$i] : "0";
						
							$customer_service_id=$db->query_insert("inventory_product_map", $data_record_service);
							
							$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
							$ptr_qty=mysql_query($sel_qty);
							$data_qty=mysql_fetch_array($ptr_qty);
							
							$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$i]);
							$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$i]."'";
							$query_prod_qty=mysql_query($update_prod_qty);
							
							$sel_stockiest="select admin_id from product where product_id='".$_POST['product_id'.$i]."' ";
							$ptr_stock=mysql_query($sel_stockiest);
							$data_stock=mysql_fetch_array($ptr_stock);
							
							$ins_data="INSERT INTO `product_daily_report`(`product_id`, `cm_id`, `stockiest_id`, `type`, `purchase_qty`, `sales_qty`, `checkout_qty`, `vendor_id`, `cust_type`, `cust_id`, `todays_qty`,`todays_shelf_qty`,`todays_consumable_qty`, `description`,`admin_id`,`added_date`) VALUES ('".$_POST['product_id'.$i]."','".$cm_id."','".$data_stock['admin_id']."','purchase','".$_POST['sin_product_qty'.$i]."','0','0','".$vendor_id."','','','".$_POST['sin_product_qty'.$i]."','','','Product Purchase','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
							$ptr_ins=mysql_query($ins_data);
							
						}
					}
					/*for($j=1;$j<=$total_type1;$j++)
					{
						if($_POST['tax_type'.$j] >0)
						{
							$data_record_tax['inventory_id'] =$record_id; 
							$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
							$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
							$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
							$customer_tax_id=$db->query_insert("inventory_tax_map", $data_record_tax);
						}
					}*/
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_inventory','Add','add inventory','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);
						
					/*if($payment_type_val=="online")
					$status='pending';
					else*/
					$status='paid';
					
					$chaque_date_exp=explode('/', $chaque_date);
					$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
					
					//===============Update Receipt no================
					$sel_recpt="select receipt_no from inventory_invoice where cm_id='".$cm_id1."' and (receipt_no IS NOT NULL and receipt_no !='') order by receipt_no desc limit 0,1";
					$ptr_recpt=mysql_query($sel_recpt);
					$data_receipt=mysql_fetch_array($ptr_recpt);	
					
					$recp=explode("-",$data_receipt['receipt_no']);
					$recpt_no=intval($recp[1])+1;
					$pre=$recp[0].'-';
					$receipt_no=$pre.$recpt_no;
					//==================================================
					$insert_sales_invoice="INSERT INTO `inventory_invoice` (`inventory_id`,`receipt_no`,`price`,`total_cost`,`amount1`, `payable_amount`,`remaining_amount`,`paid_type`,`bank_id`,`cheque_detail`, `chaque_date`, `credit_card_no`, `bank_ref_no`,`admin_id`, `added_date`,`status`,`cm_id`,`total_paid`) VALUES ('".$record_id."','".$receipt_no."','".$price."','".$total_cost."','".$amount1."', '".$_POST['payable_amount']."','".$_POST['remaining_amount']."', '".$payment_mode_id."','".$bank_name."','".$chaque_no."','".$sep_check_date."','".$credit_card_no."','".$bank_ref_no."','".$_SESSION['admin_id']."','".$added_date."','".$status."','".$cm_id1."','".$payable_amount."'); ";
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
					/*else if($branch_name1=="ISAS PCMC")
					{
						$address="Hari A1,Next to ABS Gym, Pimple Nilakh, Pune 411027. Location: https://bit.ly/2Ke26fQ";
					}*/
					
					$messagessss =$txt_msg;
					$search_by = array("student_name","isas_address","&");
					$replace_by = array($name,$address,"and");
					$messagessss = str_replace($search_by, $replace_by, $messagessss);
					
					$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='136' ".$_SESSION['where']."";
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
					//send_sms_function($contact,$messagessss);
					//------send notification on Sale voucher--------------------
						$notification_args['reference_id'] =$record_id;
						$notification_args['on_action'] = 'product_purchase';
						$notification_status = addNotifications($notification_args);
					//---------------------------------------------------------------
					//=========================================================================
					?>
                    <div id="statusChangesDiv" title="Record added"><center><br><p>Record added successfully</p></center></div>
					<script type="text/javascript">
                        $(document).ready(function() {
                            $( "#statusChangesDiv" ).dialog({
                                    modal: true,
                                    buttons: {
                                                Ok: function() { $( this ).dialog( "close" );}
                                             }
                            });
                            
                        });
                    setTimeout('document.location.href="manage_inventory.php";',500);
                    </script>
					<?php
				}
			}
	}
	if($success==0)
	{
	?>
    <tr>
    <input type="hidden" name="res1" id="res1">
    <input type="hidden" name="res_tax" id="res_tax">
    <td>
    <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
		<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields
                	<!--<div id="res1" style="display:none"></div>-->
                    <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>">
                </td>
            </tr>
			<tr>
                <td width="20%">Date<span class="orange_font">*</span></td>
                <td width="49%"><?php 
                if($_SESSION['type']=='S' || $_SESSION['type']=='LD' || $_SESSION['type']=='ST' || $_SESSION['type']=='F')
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
                    <input type="hidden" id="added_date" style="width:200px" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode(' ',$row_record['added_date'],3);$arr_date=explode('-',$arrage_date[0]);echo $arr_date[2].'/'.$arr_date[1].'/'.$arr_date[0];}else{echo date("d/m/Y");}?>">
                    <?php 
                }
                ?>
                </td>
            </tr> 
			<?php 
            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
                    $sel_branch = "SELECT * FROM branch where 1 and status='Active' order by branch_id asc ";	 
                    $query_branch = mysql_query($sel_branch);
                    $total_Branch = mysql_num_rows($query_branch);
                    echo '<table width="100%"><tr><td>'; 
                    echo '<select id="branch_name" name="branch_name" onchange="show_bank(this.value)" style="width:200px">';
                    while($row_branch = mysql_fetch_array($query_branch))
                    {
                        ?>
                        <option value="<?php echo $row_branch['branch_name'];?>"<?php if($_POST['branch_name']==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"'?>><?php echo $row_branch['branch_name'];?></option>
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
                <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"> 
                <?php 
           	}?> 
           	<tr>
            	<td>Select Vendor <span class="orange_font">*</span></td>
              	<td id="vendor_ids">
               	<select name="vendor_id" id="vendor_id" class="input_select" style="width:200px;" onChange="get_product_list(this.value)">
               	<option value="">Select Vender</option>
               	<?php
                $sql_vendor="select name, vendor_id from vendor where 1 ".$_SESSION['where']."   order by vendor_id asc";
                $ptr_vendor=mysql_query($sql_vendor);
                while($data_vendor=mysql_fetch_array($ptr_vendor))
                { 
                    $selecteds='';
                    if($data_vendor['vendor_id']==$row_record['vendor_id'])
                    $selecteds = 'selected="selected"';	
                    echo "<option value='".$data_vendor['vendor_id']."' ".$selecteds.">".$data_vendor['name']."</option>";
                }
               ?>
               </select>
              </td>
           </tr>
           <tr>
            	<td width="15%" class="tr-header" align="left">Select Agent Name</td>
                <td width="25%"><select name="agent_id" style="width:200px" class="input_text" id="agent_id">
                <option value="">Select Agent Name</option>
                <?php
                $sel_agent="select * from agent_type where cm_id='".$_SESSION['cm_id']."'";
                $ptr_agent=mysql_query($sel_agent);
                while($data_agent=mysql_fetch_array($ptr_agent))
                {
                    $selected='';
                    if($data_agent['agent_id'] == $row_expense['agent_id'])
                    {
                        $selected='selected="selected"';
                    }
                    echo '<option '.$selected.' value="'.$data_agent['agent_id'].'">'.$data_agent['agent_name'].'</option>';
                }
                ?>
                </select></td>
           </tr>
           <?php 

		      $rowSQL = mysql_query("SELECT MAX(inventory_id) as max FROM `inventory`" );
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
          	<tr>
            	<td width="15%" valign="top">Upload Ref. Invoice<span class="orange_font">*</span></td>
            	<td width="70%"><input type="file"  class="input_file" name="ref_invoice" id="ref_invoice" value="<?php if($_POST['save_changes']) echo $_POST['ref_invoice']; else if($row_record['ref_invoice'] !='') echo $row_record['ref_invoice']; ?>" style="width:200px" /></td> 
            	<td width="10%"></td>
          	</tr>
          	<!--<tr>
          		<td width="10%">Select Product <span class="orange_font">*</span></td>
            	<td width="90%" >
				<?php
                /*$sel_tel = "select product_id,product_name,price from product order by product_id asc";	 
                $query_tel = mysql_query($sel_tel);
                $i=1;
                $total_no = mysql_num_rows($query_tel);
                $member_result='';
                echo '<table width="100%">';
                echo  '<tr>';
                ///-======= Existing course code===
                if($record_id)
                { 
    
                    $select_existing = " select product_id, inventory_id from inventory_product_map where inventory_id='".$record_id."' ";
                    $ptr_esxit = mysql_query($select_existing);
                    $subject_array = array();
                    $topic_array = array();
                    $j=0;
                    while( $data_exist = mysql_fetch_array($ptr_esxit))
                    {
                        $customer_array[$j]=$data_exist['inventory_id'];
                        $service_array[$j]=$data_exist['product_id'];
                        //print_r($service_array[$j]);
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
                    echo  '<td style="border:1px solid #999;">'; 
                    echo  "<input type='checkbox' '".$checked."' name='requirment_id[]'  value='".$row_member['product_id']."' id='requirment_id$i'  onClick='showprice()' class='case' $checked  /> ".$row_member['product_name']."( Price - ".$row_member['price']."/- )"." ";
                    echo '<input type="hidden" name="price_hidden" value="'.$row_member['price'].'" id="price_hidden'.$i.'" />';
                    //echo '<input type="hidden" name="quantity_total[]" value="'.$row_member['quantity'].'" id="quantity_total'.$i.'" />';
                    //echo' &emsp; Qty: <input type="text" name="quantity[]" value="'.$valu_quantity.'" id="quantity'.$i.'" style="width:60px" onkeyup="showprice()"/>';
                    //echo' &emsp; Total: <input type="text" name="total_price" value="" id="total_price'.$i.'" readonly="readonly" style="width:60px" />';
                    echo  '</td>';
                    if($i%3==0)
                    echo  '<tr></tr>';  
                    $i++;
                }
                echo' <input type="hidden" name="total_product" value="'.($i-1).'" id="total_product" />';
                echo '</table>';*/
                ?>

	        	</td> 
        	</tr>-->
        	<!--======================================NEW TABLE START===================================-->   
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
                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1"  onKeyUp="create_floor();" value="0">
                    	<?php 
					}?>
                    <script language="javascript">
					<?php 
					if($_SESSION['tax_type']=='GST')
					{
						?>
						function floors(idss)
						{
							//res= document.getElementById("res1").value;
							res= document.getElementById("res1").value;
	
							var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td><div id="prod_list'+idss+'"></div></td></tr><tr><td width="10%" align="left"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'"><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:200px" onChange="getprice(this.value,'+idss+')"><option value="">Select Product</option>'+res+'</select></td><td width="6%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_price'+idss+'" id="sin_product_price'+idss+'" style=" width:60px" /></td><td width="6%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_base_price'+idss+'" id="sin_product_base_price'+idss+'" style="width:60px" /></td><td width="5%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_qty'+idss+'" id="sin_product_qty'+idss+'" style=" width:40px" /></td><td width="8%" align="center"><input type="text" name="sin_product_disc'+idss+'" id="sin_product_disc'+idss+'" onkeyup="getDiscount('+idss+')"  disabled="disabled" style=" width:70px" /><input type="hidden" name="sin_prod_disc_price'+idss+'" id="sin_prod_disc_price'+idss+'"></td><td width="4%" align="center"><input type="text" name="prod_discounted_price'+idss+'" disabled="disabled" id="prod_discounted_price'+idss+'" style="width:60px" /><input type="hidden" name="prod_disc_price'+idss+'" id="prod_disc_price'+idss+'" /></td><td width="5%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_cgst'+idss+'" id="sin_product_cgst'+idss+'" style=" width:40px"><input type="text" name="sin_prod_cgst_price'+idss+'" style=" width:40px" id="sin_prod_cgst_price'+idss+'" /></td><td width="5%" align="center"><input type="text" disabled="disabled" name="sin_product_sgst'+idss+'" onkeyup="getDiscount('+idss+')" id="sin_product_sgst'+idss+'" style=" width:40px"><input type="text" name="sin_prod_sgst_price'+idss+'" style=" width:40px" id="sin_prod_sgst_price'+idss+'" /></td><td width="5%" align="center"><input type="text" disabled="disabled" name="sin_product_igst'+idss+'" onkeyup="getDiscount('+idss+')" id="sin_product_igst'+idss+'" style=" width:40px"><input type="text" name="sin_prod_igst_price'+idss+'" id="sin_prod_igst_price'+idss+'" style=" width:40px" /></td><td width="4%" align="center"><input type="text" disabled="disabled" name="mrp_price'+idss+'" id="mrp_price'+idss+'" readonly="readonly" style="width:60px" /></td><td width="6%" align="center"><input type="text" disabled="disabled" name="sin_product_total'+idss+'" id="sin_product_total'+idss+'" style=" width:60px"></td><td width="10%"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:100px"><option value="">Select Staff</option><?php 
							/*$sel_staff = "select admin_id,name from site_setting order by admin_id asc";
							$query_staff = mysql_query($sel_staff);
							if($total_staff=mysql_num_rows($query_staff))
							{
								while($data=mysql_fetch_array($query_staff))
								{
									echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
								}
							}*/
							if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
							</select></td><td width="2%" align="center"><a onClick="reset_price('+idss+')"><img src="images/refresh.png" height="25" width="25" alt="refresh"></a><input type="hidden" name="base_price'+idss+'" id="base_price'+idss+'" value=""></td><td valign="top" width="1%" align="center"><input type="hidden" name="total_product[]" id="total_product'+idss+'"></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></tr><tr><td colspan="7"><div style="display:none" id="product_details'+idss+'"><table style="width:100%" align="center"><tr><td width="10%">Price : <span id="price_desc'+idss+'"></span></td><td width="10%">Brand : <span id="brand'+idss+'"></span></td><td width="10%">Unit : <span id="unit_desc'+idss+'"></span><span id="measure_desc'+idss+'"></span></td><td width="70%">Product Desc.: <span id="description_desc'+idss+'"></span></td></tr></table></div></td></tr></table></div>';
							document.getElementById('floor').value=idss;
							return shows_data;
						}
						<?php
					}
					else
					{
						?>
						function floors(idss)
						{
							res= document.getElementById("res1").value;
	
							var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td><div id="prod_list'+idss+'"></div></td></tr><tr><td width="10%" align="left"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'"><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:200px" onChange="getprice(this.value,'+idss+')"><option value="">Select Product</option>'+res+'</select></td><td width="6%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_price'+idss+'" id="sin_product_price'+idss+'" style=" width:60px" /></td><td width="6%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_base_price'+idss+'" id="sin_product_base_price'+idss+'" style="width:60px" /></td><td width="5%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_qty'+idss+'" id="sin_product_qty'+idss+'" style=" width:40px" /></td><td width="8%" align="center"><input type="text" name="sin_product_disc'+idss+'" id="sin_product_disc'+idss+'" onkeyup="getDiscount('+idss+')"  disabled="disabled" style=" width:70px"><input type="hidden" name="sin_prod_disc_price'+idss+'" id="sin_prod_disc_price'+idss+'"></td><td width="4%" align="center"><input type="text" name="prod_discounted_price'+idss+'" disabled="disabled" id="prod_discounted_price'+idss+'" style="width:60px"><input type="hidden" name="prod_disc_price'+idss+'" id="prod_disc_price'+idss+'"></td><td width="5%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_vat'+idss+'" id="sin_product_vat'+idss+'" style=" width:40px"><input type="text" name="sin_prod_vat_price'+idss+'" style=" width:40px" id="sin_prod_vat_price'+idss+'"><input type="hidden" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_cgst'+idss+'" id="sin_product_cgst'+idss+'" style=" width:40px"><input type="hidden" name="sin_prod_cgst_price'+idss+'" style=" width:40px" id="sin_prod_cgst_price'+idss+'"><input type="hidden" disabled="disabled" name="sin_product_sgst'+idss+'" onkeyup="getDiscount('+idss+')" id="sin_product_sgst'+idss+'" style=" width:40px"><input type="hidden" name="sin_prod_sgst_price'+idss+'" style=" width:40px" id="sin_prod_sgst_price'+idss+'"><input type="hidden" disabled="disabled" name="sin_product_igst'+idss+'" onkeyup="getDiscount('+idss+')" id="sin_product_igst'+idss+'" style=" width:40px"><input type="hidden" name="sin_prod_igst_price'+idss+'" id="sin_prod_igst_price'+idss+'" style=" width:40px"></td><td width="4%" align="center"><input type="text" disabled="disabled" name="mrp_price'+idss+'" id="mrp_price'+idss+'" readonly="readonly" style="width:60px"></td><td width="6%" align="center"><input type="text" disabled="disabled" name="sin_product_total'+idss+'" id="sin_product_total'+idss+'" style=" width:60px"></td><td width="10%"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:100px"><option value="">Select Staff</option><?php 
							if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{
								$sel_staff ="select admin_id,name from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." order by name asc";	 
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
							</select></td><td width="2%" align="center"><a onClick="reset_price('+idss+')"><img src="images/refresh.png" height="25" width="25" alt="refresh"></a><input type="hidden" name="base_price'+idss+'" id="base_price'+idss+'" value=""></td><td valign="top" width="1%" align="center"><input type="hidden" name="total_product[]" id="total_product'+idss+'"></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></tr><tr><td colspan="7"><div style="display:none" id="product_details'+idss+'"><table style="width:100%" align="center"><tr><td width="10%">Price : <span id="price_desc'+idss+'"></span></td><td width="10%">Brand : <span id="brand'+idss+'"></span></td><td width="10%">Unit : <span id="unit_desc'+idss+'"></span><span id="measure_desc'+idss+'"></span></td><td width="70%">Product Desc.: <span id="description_desc'+idss+'"></span></td></tr></table></div></td></tr></table></div>';
							document.getElementById('floor').value=idss;
							return shows_data;
						}
						<?php
					}
					?>
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
                        	<td valign="top" width="20%" align="center">Product Name</td>
                            <td valign="top" width="7%"  align="center">MRP</td>
                        	<td valign="top" width="7%"  align="center">Base Price</td>
                        	<td valign="top" width="5%"  align="center">Qty </td>
                        	<td valign="top" width="8%"  align="center">Discount in<br/>
                        	<input type="radio" name="products_disc_type" onChange="getDiscount()" id="products_disc_type" value="percentage" <?php if($_POST['products_disc_type']=="percentage") {echo 'checked="checked"';}else if($row_record['products_disc_type']=="percentage"){ echo 'checked="checked"';} else echo 'checked="checked"';?>>%<input type="radio" name="products_disc_type" onChange="getDiscount()" id="products_disc_type" value="rupees" <?php if($_POST['products_disc_type']=="rupees") {echo 'checked="checked"';}else if($row_record['products_disc_type']=="rupees") { echo 'checked="checked"';} ?> /><?php if($_SESSION['tax_type']=='GST') echo 'Rs -/'; else echo 'AED'; ?></td>
                            <td valign="top" width="7%"  align="center">Discounted Price</td>
                            <?php if($_SESSION['tax_type']=='GST')
							{
								?>
                                <td valign="top" width="5%"  align="center">CGST</td>
                                <td valign="top" width="5%"  align="center">SGST</td>
                                <td valign="top" width="5%"  align="center">IGST</td>
                                <?php
							}
							else
							{
								?>
                                <td valign="top" width="5%"  align="center">VAT</td>
                                <?php
							}
							?>
                            <td valign="top" width="7%" align="center">MRP</td>
                            <td valign="top" width="7%" align="center">Total Price</td>
                            <td valign="top" width="10%" align="center">Staff</td>
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
            	       			$select_exc ="select * from inventory_product_map where inventory_id='".$record_id."' and product_id!='' order by map_id asc ";
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
											$sel_tel ="select product_id,product_name,price from product ".$_SESSION['where']." order by product_id asc";	 
											$query_tel = mysql_query($sel_tel);
											if($total=mysql_num_rows($query_tel))
											{
												while($data=mysql_fetch_array($query_tel))
												{
													$selected='';
													if($data_exclusive['product_id'] ==$data['product_id'] )
													{
														$selected='selected="selected"';
													}
													echo '<option value="'.$data['product_id'].'" '.$selected.'>'.$data['product_name'].'</option>';
												}
											}
											?>
											</select>
											</td>
											<td width="6%" align="center"><input type="text" name="sin_product_price<?php echo $t; ?>" id="sin_product_price<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['sin_product_price'] ?>" onkeyup="getDiscount(<?php echo $t; ?>)" /></td>
                                            <td width="6%" align="center"><input type="text" name="sin_product_base_price<?php echo $t; ?>" id="sin_product_base_price<?php echo $t; ?>" style=" width:60px;background-color:#cccc" readOnly value="<?php echo $data_exclusive['sin_product_base_price'] ?>" onkeyup="getDiscount(<?php echo $t; ?>)"></td>
                                            <td width="5%" align="center"><input type="text"name="sin_product_qty<?php echo $t; ?>" id="sin_product_qty<?php echo $t;?>" style=" width:40px" value="<?php echo $data_exclusive['sin_product_qty'] ?>" onKeyUp="getDiscount(<?php echo $t; ?>)"></td>
											<td width="8%" align="center"><input type="text" name="sin_product_disc<?php echo $t; ?>" id="sin_product_disc<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_product_disc'] ?>" onKeyUp="getDiscount(<?php echo $t; ?>)"  style=" width:70px"><input type="hidden" name="sin_prod_disc_price<?php echo $t; ?>" id="sin_prod_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_prod_disc_price'] ?>"></td>
											<td width="4%" align="center"><input type="text" name="prod_discounted_price<?php echo $t; ?>" id="prod_discounted_price<?php echo $t; ?>" style="width:60px" value="<?php echo $data_exclusive['discounted_price'] ?>"><input type="hidden" name="prod_disc_price<?php echo $t; ?>" id="prod_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['discounted_price'] ?>"></td>
                                            <?php
											if($_SESSION['tax_type']=='GST')
											{
												?>
												<td width="5%" align="center"><input type="text" onkeyup="getDiscount(<?php echo $t; ?>)" name="sin_product_cgst<?php echo $t; ?>" id="sin_product_cgst<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['cgst_tax_in_per'] ?>" /><input type="text" name="sin_prod_cgst_price<?php echo $t; ?>" style=" width:40px" id="sin_prod_cgst_price<?php echo $t; ?>" value="<?php echo $data_exclusive['cgst_tax'] ?>"></td>
												<td width="5%" align="center"><input type="text" name="sin_product_sgst<?php echo $t; ?>" onkeyup="getDiscount(<?php echo $t; ?>)" id="sin_product_sgst<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['sgst_tax_in_per'] ?>" /><input type="text" name="sin_prod_sgst_price<?php echo $t; ?>" style=" width:40px" id="sin_prod_sgst_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sgst_tax'] ?>" /></td>
												<td width="5%" align="center"><input type="text" name="sin_product_igst<?php echo $t; ?>" onkeyup="getDiscount(<?php echo $t; ?>)" id="sin_product_igst<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['igst_tax_in_per'] ?>" /><input type="text" name="sin_prod_igst_price<?php echo $t; ?>" id="sin_prod_igst_price<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['igst_tax'] ?>" /></td>
												<?php
											}
											else
											{
												?>
                                                <td width="5%" align="center"><input type="text" onkeyup="getDiscount(<?php echo $t; ?>)" name="sin_product_vat<?php echo $t; ?>" id="sin_product_vat<?php echo $t; ?>" style=" width:40px" value="<?php echo $data_exclusive['service_tax_in_per'] ?>" /><input type="text" name="sin_prod_vat_price<?php echo $t; ?>" style=" width:40px" id="sin_prod_vat_price<?php echo $t; ?>" value="<?php echo $data_exclusive['service_tax'] ?>" /></td>
                                                <?php
											}
											?>
											<td width="4%" align="center"><input type="text" name="mrp_price<?php echo $t; ?>" id="mrp_price<?php echo $t; ?>" readonly="readonly" style="width:60px" value="<?php echo $data_exclusive['sin_product_price'] ?>" /></td>
											<td width="6%" align="center"><input type="text"  name="sin_product_total<?php echo $t; ?>" id="sin_product_total<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['sin_product_total'] ?>"></td>
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
											<td width="2%" align="center"><a onClick="reset_price(<?php echo $t; ?>)"><img src="images/refresh.png" height="25" width="25" alt="refresh"></a><input type="hidden" name="base_price<?php echo $t; ?>" id="base_price<?php echo $t; ?>" value="<?php if($record_id!='') echo '0'; ?>"><br/>
											<?php
											if($record_id)
											{
												?>
												<input type="hidden" name="total_product[]" id="total_product<?php echo $t;?>">
												<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['map_id'] ?>">
												<input type="button" title="Delete Options(-)" onClick="delete_product(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
												<input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="">
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
            <input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions;?>">
            <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" value="<?php echo $total_conditions;?>">
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
                <td width="20%" valign="top">Product Price <span class="orange_font">*</span></td>
                <td width="70%"><input type="text" class="input_text" onChange="showUser()" name="price" id="price" style="width:200px" value="<?php if($_POST['price']) echo $_POST['price']; else echo $row_record['price'];?>"></td> 
                <td width="10%"></td>
           </tr>
           <tr>
            	<td width="20%" valign="top">Discount  
                <input type="radio" readonly="readonly" name="discount_type" onChange="showUser()" id="discount_type" checked="checked" value="percentage" <?php if($_POST['discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';}?>>in %
                <input type="radio" readonly="readonly" name="discount_type" id="discount_type" onChange="showUser()" value="rupees" <?php if($_POST['discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in <?php if($_SESSION['tax_type']=='GST') echo 'Rs -/'; else echo 'AED'; ?></td>
            	<td width="72%"><input type="text" readonly="readonly" class=" input_text" name="discount" id="discount" style="width:200px" onBlur="showUser()" value="<?php if($_POST['discount']){echo $_POST['discount'];} else {echo $row_record['discount'];}?>"></td> 
            	<td width="5%"></td>
            </tr>
            <tr>
            	<td width="20%" valign="top" >Discount Price</td>
            	<td width="72%" ><input type="text" class="input_text" readonly="readonly" name="discount_price" id="discount_price" style="width:200px" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_record['discount_price'];?>"></td> 
            	<td width="5%" ></td>
            </tr>
            <!--<tr>
                <td>Discount(in %) <span class="orange_font">*</span></td>
                <td width="70%"><input type="text" name="discount" id="discount" onKeyUp="calculte_total_cost()" class="input_text" value="<?php //if($_POST['save_changes']) echo $_POST['discount']; else echo $row_record['discount'];?>" /></td>
            </tr>-->
            <!--<tr>

                <td width="25%">Tax (in %):<span class="orange_font">*</span></td>

                <td width="40%"><input type="text" name="tax" onkeyup="calculte_total_cost()" class="input_text" id="tax" value="<?php //if($_POST['save_changes']) echo $_POST['tax']; else echo $row_record['tax'];?>" required/></td>
            </tr>-->          
            <!--<tr>      
                  <td width="20%" class="heading">Service Tax <?php //if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} else echo '<span id="service_tax_id"></span>';  ?>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php //if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"  />  
                  <td><input type="text" class=" input_text" name="tax" id="tax"  value="<?php //if($_POST['tax']) echo $_POST['tax']; else echo $row_record['tax'];?>" /></td>   
            </tr>-->          
            <tr>
            <input type="hidden" name="total_cost_discount"  id="total_cost_discount"  />
                <td width="25%">Total Cost :</td>
                <td width="40%"><input type="text" readonly="readonly" name="total_cost" class="input_text" style="width:200px" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>"></td>
            </tr>
           <!--===========================================================NEW TABLE 2 START===================================-->   
           <tr style="display:none">
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
                        <input type="hidden" name="type1" id="type1" class="inputText" size="1" onKeyUp="create_type1();" value="0">
                        <?php 
					 }?>
                    <script language="javascript">
						function type1(idss)
						{
                            res_tax= document.getElementById("res_tax").value;
							//alert(idss);
							var shows_data='<div id="type1_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="8%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="" /><select name="tax_type'+idss+'" id="tax_type'+idss+'" onChange="get_tax_value('+idss+',this.value)" ><option value="">Select Tax</option>'+res_tax+'</select></td><td valign="top" width="8%" align="left"><input type="text" name="tax_value'+idss+'" id="tax_value'+idss+'" onKeyUp="calculte_amount_tax('+idss+')"/><input type="hidden" name="tax_amount'+idss+'" id="tax_amount'+idss+'" /></td><input type="hidden" name="total_tax[]" id="total_tax'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';

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
									$select_exc="select * from inventory_tax_map where inventory_id='".$record_id."' order by inv_tax_map_id asc ";
									$ptr_fs=mysql_query($select_exc);
									$s=1;
									$total_comision= mysql_num_rows($ptr_fs);
									$total_conditions= mysql_num_rows($ptr_fs);
									while($data_exclusive = mysql_fetch_array($ptr_fs))
									{ 
										$slab_id=$data_exclusive['inv_tax_map_id'];
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
												$sql_tax="select tax_name from tax_type where 1 ".$cm_ids."";
												$ptr_tax=mysql_query($sql_tax);
												while($data_tax=mysql_fetch_array($ptr_tax))
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
                                               	<!--<input type="text" name="tax_type<?php //echo $s; ?>" id="tax_type<?php //echo $s; ?>" style=" width:100px" value="<?php //echo $data_exclusive['tax_type']?>">-->
                                               	</td>
												<td width="8%" align="center">
												<input type="hidden" name="tax_amount<?php echo $s; ?>" id="tax_amount<?php echo $s; ?>" value="<?php echo $data_exclusive['tax_amount'] ?>">
												<input type="text" name="tax_value<?php echo $s; ?>" id="tax_value<?php echo $s; ?>" style=" width:100px" value="<?php echo $data_exclusive['tax_value'] ?>" onKeyUp="calculte_amount_tax(<?php echo $s; ?>)"></td>
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
							<?php 
						} ?> 
						</td>
                    </tr>
                </table>
            </td>
        </tr>
		<!--============================================================END TABLE 2=========================================-->
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
            <div id="bank_details" <?php if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque' || $data_payment_mode1['payment_mode']=='online') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
            <table width="100%">
                <tr>
					<td width="26%" class="tr-header" >Bank Name</td>
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
					<td class="tr-header" width="26%">Account No</td>
					<td><input type="text" name="account_no" readonly="readonly" id="account_no" style="width:200px" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>
				</tr>
            </table>
			</div>       
            <div id="bank_ref_no" <?php if($_POST['payment_type'] =='online-5' || $data_payment_mode1['payment_mode']=='online') echo 'style="display:block"'; else echo 'style="display:none"'; ?>>
                <table width="100%">
                    <tr>
                        <td class="tr-header" width="26%">Bank Ref. no</td>
                        <td ><input type="text" name="bank_ref_no" class="input_text" style="width:200px" id="bank_ref_no" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $row_record['bank_ref_no']; ?>"/></td>
                    </tr>
                </table>
            </div>  
			<div id="chaque_details" <?php if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
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
				contact =parseFloat(Number(contact)+Number(servicesss_idddd)).toFixed(3);
				//alert(contact);
			}
		}
		document.getElementById('price').value=contact;
		
		var total_prods_price=contact;
		if(document.getElementById('discount').value)
		{	
			var discount= parseFloat(document.getElementById('discount').value).toFixed(3);
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
				var discount_price= parseFloat(total_prods_price * (discount/100)).toFixed(3);
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
			var total_discount_price= parseFloat(total_prods_price - discount_price).toFixed(3);
			document.getElementById('discount_price').value=discount_price;
		}
		else
		{
			var total_discount_price=total_prods_price;
			document.getElementById('discount_price').value=discount_price;
		}
		document.getElementById('total_cost').value=total_discount_price;
		document.getElementById('amount1').value=total_discount_price;
		//calculte_amount_tax();
	}
</script>
<?php
if($record_id || $_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
	if(document.getElementById("vendor_id"))
	{
		vendor_id =document.getElementById("vendor_id").value;
		//alert(vendor_id);
		setTimeout(get_product_list(vendor_id),500);
	}
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