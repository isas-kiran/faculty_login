<?php include 'inc_classes.php';?>
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
    </script>
    <script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
<script>
var reslts='';
record_id='';
function get_product_list(vendor_id,record_id)
{
// alert(vendor_id);
//alert(record_id);
var total_product= document.getElementsByName("total_product[]");
totals=total_product.length;
//alert(totals)
if(vendor_id!=record_id)
{
	for(i=1;i<=totals;i++)
	{
		//alert('hi')
		//document.getElementById("type1_id"+i).innerHTML='';
		document.getElementById("floor_id"+i).innerHTML='';
	}
 	var total_tax=document.getElementsByName("total_tax[]").length;
	//alert(total_tax);
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
}
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
				document.getElementById("res").value=html;
		}
  });
}
function getprice(values,val_idss)
{
	//alert(val_idss);
	//alert(values);
	var product_id=document.getElementById('product_id'+val_idss).value;
	//alert(product_id)			
	var data1="product_id="+product_id;	
	//alert(data1);
        $.ajax({
            url: "get_inven_product_price.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				product_price_inv=html;
				document.getElementById("sin_product_price"+val_idss).value=product_price_inv;
				document.getElementById("sin_product_total"+val_idss).value=product_price_inv;
				var exit_disc=document.getElementById("sin_product_disc"+val_idss).value = 0;
				var exit_qty=document.getElementById("sin_product_qty"+val_idss).value = 1;
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
				document.getElementById("sin_product_disc"+val_idss).disabled = false;
				document.getElementById("sin_product_qty"+val_idss).disabled = false;
				document.getElementById("sin_product_total"+val_idss).disabled = false;
				document.getElementById("staff_id"+val_idss).disabled = false;
			}
			else
			{
				document.getElementById("sin_product_price"+val_idss).disabled = true;
				document.getElementById("sin_product_disc"+val_idss).disabled = true;
				document.getElementById("sin_product_qty"+val_idss).disabled = true;
				document.getElementById("sin_product_total"+val_idss).disabled = true;
				document.getElementById("staff_id"+val_idss).disabled = true;
			}
			setTimeout(showUser,800);
			getDiscount(val_idss),800;
			calculte_amount_tax(val_idss),800;
}
function getDiscount(idss)
{
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.discount1.value;
	//alert(idss);
	product_price=parseFloat(document.getElementById("sin_product_price"+idss).value);
	disc=parseFloat(document.getElementById("sin_product_disc"+idss).value);
	//alert(disc)
	
	sin_product_qty=parseFloat(document.getElementById("sin_product_qty"+idss).value);
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
	
	document.getElementById("sin_prod_disc_price"+idss).value=discount_price;
	//discount= (total_price_qty*disc)/100;
	//total_price=total_price_qty-discount;
	if(document.getElementById("sin_product_total"+idss))
	{
	  document.getElementById("sin_product_total"+idss).value=total_price;
	}
	showUser();
	calculte_total_cost();
	calculte_amount_tax(idss);
}
function calculte_total_cost()
{
	 //alert('hi')

	var price=document.getElementById("price").value;

	var discount=document.getElementById("discount").value;
	 //alert(discount)
	var total=isNaN(parseInt(price * (discount / 100))) ? 0 :parseInt((price * (discount / 100)))
	 //alert(total_cost)
	var total_cost_new=isNaN(parseInt(price - total)) ? 0 :parseInt(price - total)
	$('#total_cost').val(total_cost_new);
	$('#amount1').val(total_cost_new);
	calculte_amount_tax();
}
function calculte_amount_tax(val_tax_ids)
{
	tax_value ='';
	//alert(total_tax);
	var total_tax=document.getElementsByName("total_tax[]").length;
	//alert(total_tax);
	for(i=1;i<=total_tax;i++)
	{
		tax_id='tax_value'+i;
		//alert(tax_id);
		if(document.getElementById(tax_id))
		{
			tax_value =Number(tax_value) + Number(document.getElementById(tax_id).value);
		}
	}
	//alert(tax_value);
	//tax_value +=document.getElementById('tax_value'+val_tax_ids).value;
    cost_tot_tt=parseInt(document.getElementById("total_cost").value);
	cal_tot_amount=cost_tot_tt * (tax_value/100);
	//alert(cal_tot_amount)
	tot_amount=parseInt(cost_tot_tt + cal_tot_amount)
	//alert(tot_amount)
	//document.getElementById('tax_amount').innerHTML=tot_amount;
	$('#tax_amount'+val_tax_ids).val(cal_tot_amount);

	$('#amount1').val(tot_amount);
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
	var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax_type.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		document.getElementById("create_type1").innerHTML='';
		document.getElementById("res1").value=rettax;
		
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
		 return true;
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
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
                           $vendor_id=$_POST['vendor_id']; 
                           //$product_id=$_POST['product_id'];
						   //$amount=$_POST['amount'];
						   $invoice_no=$_POST['invoice_no'];
						   $price=$_POST['price'];
						   //$discount=$_POST['discount'];
						   $tax=$_POST['tax'];
						   $total_cost=$_POST['total_cost'];
						   $branch_name=$_POST['branch_name'];
						   $payment_mode=$_POST['payment_mode'];
						   $sep=explode("-",$payment_mode);
		                   $payment_mode_id=$sep[1];
						   $amount1=$_POST['amount1'];
							if($payment_mode_id !="1" || $payment_mode_id !="3" ||$payment_mode_id !="5")
							{
								$bank_name=$_POST['bank_name'];
								$chaque_no=$_POST['chaque_no'];
								$credit_card_no=$_POST['credit_card_no'];
								$chaque_date=$_POST['cheque_date'];
							}
							
							$discount=$_POST['discount'];
							$discount_type=$_POST['discount_type'];
							$discount_price=$_POST['discount_price'];
							
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
								$data_record['cm_id']=$cm_id;
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
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
								//$data_record['product_id']=$product_id;
								$data_record['invoice_no']=$invoice_no;
								$data_record['price']=$price;
								//$data_record['discount']=$discount;
								$data_record['tax']=$tax;
								$data_record['total_cost']=$total_cost;
								$data_record['branch_id']=$branch_id;
								$data_record['payment_mode_id'] =$payment_mode_id;
								$data_record['chaque_no'] =$chaque_no;
								$data_record['chaque_date'] =$chaque_date;
								$data_record['credit_card_no'] =$credit_card_no;
								$data_record['bank_id'] =$bank_name;
								$data_record['amount1'] = $amount1;
								$total_floor=$_POST['no_of_floor'];
								$total_type1=$_POST['total_type1'];
								
								$data_record['discount_type']=$discount_type;
								$data_record['discount']=$discount;
								$data_record['discount_price']=$discount_price;
								
								
                                if($record_id)
                                {
                                    $where_record="inventory_id='".$record_id."'";
                                    $db->query_update("inventory", $data_record,$where_record);
									for($z=1;$z<=$total_floor;$z++)
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
											$data_record_service['sin_product_total'] =$_POST['sin_product_total'.$z];
											$data_record_service['sin_product_qty'] =$_POST['sin_product_qty'.$z];
											$data_record_service['admin_id'] =$_POST['staff_id'.$z];
											if($_POST['floor_id'.$z]=='' && $_POST['product_id'.$z] !='')
											{
											 	$type1_id=$db->query_insert("inventory_product_map", $data_record_service);
												
												$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
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
												
												$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
												$ptr_qty=mysql_query($sel_qty);
												$data_qty=mysql_fetch_array($ptr_qty);
												$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$z]);
												$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$z]."'";
												$query_prod_qty=mysql_query($update_prod_qty); 
										
												//$update_prod_qty="update product set quantity=(quantity + ".$_POST['sin_product_qty'.$z].") where product_id='".$_POST['product_id'.$z]."'";
												///$query_prod_qty=mysql_query($update_prod_qty); 
											}
											unset($data_record_service);
									   	}
									}
									for($x=1;$x<=$total_type1;$x++)
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
									}
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("inventory", $data_record);
									for($i=1;$i<=$total_floor;$i++)
									{
										$data_record_service['inventory_id'] =$record_id; 
										$data_record_service['product_id'] =$_POST['product_id'.$i];
										$data_record_service['sin_product_price'] =$_POST['sin_product_price'.$i];
										$data_record_service['sin_product_disc'] =$_POST['sin_product_disc'.$i];
										$data_record_service['sin_prod_disc_price'] =$_POST['sin_prod_disc_price'.$i];
										$data_record_service['sin_product_total'] =$_POST['sin_product_total'.$i];
										$data_record_service['sin_product_qty'] =$_POST['sin_product_qty'.$i];
										$data_record_service['admin_id'] =$_POST['staff_id'.$i];
									
										$customer_service_id=$db->query_insert("inventory_product_map", $data_record_service);
										
										$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
										$ptr_qty=mysql_query($sel_qty);
										$data_qty=mysql_fetch_array($ptr_qty);
										$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$i]);
										$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$i]."'";
										$query_prod_qty=mysql_query($update_prod_qty); 
										
										//$update_prod_qty="update product set quantity=(quantity + ".$_POST['sin_product_qty'.$i].") where product_id='".$_POST['product_id'.$i]."'";
										//$query_prod_qty=mysql_query($update_prod_qty); 
									}
									for($j=1;$j<=$total_type1;$j++)
									{
										$data_record_tax['inventory_id'] =$record_id; 
										$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
										$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
										$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
										$customer_tax_id=$db->query_insert("inventory_tax_map", $data_record_tax);
									}
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
                                            setTimeout('document.location.href="manage_inventory.php";',1000);
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
                    <input type="hidden" name="res1" id="res1" />

				</tr>

				<?php }  else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?> 

                

           <tr>

            

                  <td>Select Vendor <span class="orange_font">*</span></td>

                  <td>

                   <select name="vendor_id" id="vendor_id" class="input_select" style="width:200px;" onChange="get_product_list(this.value)">

                   <option value="">Select Vender</option>

                   <?php

				   

				    $sql_vendor = " select name, vendor_id from vendor where 1 ".$_SESSION['where']."  order by vendor_id asc";

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

                  	<input type="hidden" name="res" id="res" />

                  </td>

                   

           </tr>

           

           <?php 

		      $rowSQL = mysql_query("SELECT MAX(inventory_id) as max FROM `inventory`" );

			  $row = mysql_fetch_array( $rowSQL );
			  $largestNumber = $row['max']+1;
		   ?>
           <tr>
                  <td width="15%" valign="top">Invoice No.<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="input_text" name="invoice_no" id="invoice_no" value="<?php if($_POST['save_changes']) echo $_POST['invoice_no']; else if($row_record['invoice_no'] !='') echo $row_record['invoice_no']; else echo $largestNumber;?>" /></td> 
                  <td width="10%"></td>
           </tr>
           <tr>
                  <td width="15%" valign="top">Referal Invoice No.<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="input_text" name="ref_invoice_no" id="ref_invoice_no" value="<?php if($_POST['save_changes']) echo $_POST['ref_invoice_no']; else if($row_record['ref_invoice_no'] !='') echo $row_record['ref_invoice_no']; ?>" /></td> 
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

           

        <!--===========================================================NEW TABLE START===================================-->   

           <tr>

            	<td width="10%">Select Product<span class="orange_font">*</span></td>

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

                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1"  onKeyUp="create_floor();" value="0" />

                        <?php 

					 }?>

                     <script language="javascript">

                                

                                function floors(idss)

                                {
									res= document.getElementById("res").value;
									

                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td><div id="prod_list"></div></td></tr><tr><td valign="top" width="10%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:140px" onChange="getprice(this.value,'+idss+')"><option value="">Select Product</option>'+res+'</select></td><td width="8%" align="center"><input type="text" disabled="disabled" readonly="readonly" name="sin_product_price'+idss+'" id="sin_product_price'+idss+'" style=" width:100px" /></td><td width="8%" align="center"><input type="text" disabled="disabled" onkeyup="getDiscount('+idss+')" name="sin_product_qty'+idss+'" id="sin_product_qty'+idss+'" style=" width:100px" /></td><td width="8%" align="center"><input type="text" name="sin_product_disc'+idss+'" id="sin_product_disc'+idss+'" onkeyup="getDiscount('+idss+')"  disabled="disabled" style=" width:100px" /><input type="hidden" name="sin_prod_disc_price'+idss+'" id="sin_prod_disc_price'+idss+'" /></td><td width="8%" align="center"><input type="text" disabled="disabled" name="sin_product_total'+idss+'" id="sin_product_total'+idss+'" style=" width:100px"></td><td width="10%"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:90%"><option value="">Select Staff</option><?php $sel_staff = "select admin_id,name from site_setting order by admin_id asc";	$query_staff = mysql_query($sel_staff);if($total_staff=mysql_num_rows($query_staff)){while($data=mysql_fetch_array($query_staff)){echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';}}?></select></td><td valign="top" width="8%" align="center"><input type="hidden" name="total_product[]" id="total_product'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';

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

                        <td colspan="7">

                        <table cellspacing="3" id="tbl" width="100%">

                        <tr>

                        <td valign="top" width="8%" align="center">Product Name</td>

                        <td valign="top" width="6%"  align="center">Price</td>

                        <td valign="top" width="6%"  align="center">Product Qty </td>

                        <td valign="top" width="6%"  align="center">Discount (in %)<br/>
                        
                        <input type="radio" name="discount1" onChange="getDiscount()" id="discount1" checked="checked" value="percentage" <?php if($_POST['discount1']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %<input type="radio" name="discount1" onChange="getDiscount()" id="discount1" value="rupees" <?php if($_POST['discount1']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/
                        </td>

                        <td valign="top" width="6%"  align="center">Total Price</td>

                        

                        <td valign="top" width="6%"  align="center">Staff</td>

                        <td valign="top" width="6%"  align="center">acton</td>

                        

                        </tr>

                        <tr>

                            <td colspan="7">

							<?php

                            $select_exc = "select * from inventory_product_map where inventory_id='".$record_id."' order by map_id asc ";

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
                            <td valign="top" width="15%" align="center"><select name="product_id<?php echo $t; ?>" id="product_id<?php echo $t; ?>" style="width:140px" onChange="getprice(this.value,<?php echo $t; ?>)"><option value="">Select Product</option><?php
							
							 $sql_dest = " select product_id, vendor_id from product_vendor_map where vendor_id='".$row_record['vendor_id']."' ";

							$ptr_edes = mysql_query($sql_dest);
					
							while($data_dist = mysql_fetch_array($ptr_edes))
							{

									$sel_tel = "select product_id,product_name,price from product where product_id='".$data_dist['product_id']."' order by product_id asc";	 

									$query_tel = mysql_query($sel_tel);

									if($total=mysql_num_rows($query_tel))

									{

										

										$data=mysql_fetch_array($query_tel);

										

											$selected='';

											if($data_exclusive['product_id'] ==$data['product_id'] )

											{

												$selected='selected="selected"';

											}

											echo '<option value="'.$data['product_id'].'" '.$selected.'>'.$data['product_name'].'</option>';

										

									}
							}
									 ?>

									 </select></td>

                           

                            <td width="8%" align="center"><input type="text" name="sin_product_price<?php echo $t; ?>" id="sin_product_price<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['sin_product_price'] ?>" /></td><td width="8%" align="center"><input type="text"name="sin_product_qty<?php echo $t; ?>" id="sin_product_qty<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['sin_product_qty'] ?>" onKeyUp="getDiscount(<?php echo $t; ?>)"/></td><td width="8%" align="center"><input type="text" name="sin_product_disc<?php echo $t; ?>" id="sin_product_disc<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_product_disc'] ?>" onKeyUp="getDiscount(<?php echo $t; ?>)"  style=" width:100px" /><input type="hidden" name="sin_prod_disc_price<?php echo $t; ?>" id="sin_prod_disc_price<?php echo $t; ?>" /></td><td width="8%" align="center"><input type="text"  name="sin_product_total<?php echo $t; ?>" id="sin_product_total<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['sin_product_total'] ?>"></td><td width="10%"><select name="staff_id<?php echo $t; ?>" id="staff_id<?php echo $t; ?>" style="width:90%"><option value="">Select Staff</option><?php

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

                        	<input type="hidden" name="total_product[]" id="total_product<?php echo $t; ?>" />

                            <input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['map_id'] ?>" />

                            <input type="button" title="Delete Options(-)" onClick="delete_product(<?php echo $t; ?>,'floor');" class="delBtn" name="del">

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

                    

                    </td>

                    </tr>

                </table>

             </td>

         </tr>

       <!--============================================================END TABLE=========================================-->
           <tr>
                <td width="20%" valign="top">Product Price <span class="orange_font">*</span></td>
                <td width="70%"><input type="text" class="input_text" onChange="showUser()" name="price" id="price" value="<?php if($_POST['price']) echo $_POST['price']; else echo $row_record['price'];?>"/></td> 
                <td width="10%"></td>
           </tr>
           <tr>
            	<td width="20%" valign="top">Discount  
                <input type="radio" name="discount_type" onChange="showUser()" id="discount_type" checked="checked" value="percentage" <?php if($_POST['discount_type']=="percentage") {echo 'checked="checked"';}else if($row_record['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %
                <input type="radio" name="discount_type" id="discount_type" onChange="showUser()" value="rupees" <?php if($_POST['discount_type']=="rupees") {echo 'checked="checked"';}else if($row_record['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/</td>
            	<td width="72%"><input type="text" class=" input_text" name="discount" id="discount" onBlur="showUser()" value="<?php if($_POST['discount']){echo $_POST['discount'];} else {echo $row_record['discount'];}?>" /></td> 
            	<td width="5%"></td>
            </tr>
            <tr>
            	<td width="20%" valign="top">Discount Price</td>
            	<td width="72%"><input type="text" class=" input_text" name="discount_price" id="discount_price" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_record['discount_price'];?>" /></td> 
            	<td width="5%"></td>
            </tr>
            <!--<tr>

                <td>Discount(in %) <span class="orange_font">*</span></td>

                <td width="70%"><input type="text" name="discount" id="discount" onKeyUp="calculte_total_cost()" class="input_text" value="<?php //if($_POST['save_changes']) echo $_POST['discount']; else echo $row_record['discount'];?>" /></td>

            </tr>
           
-->
           

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

                <td width="40%"><input type="text" readonly="readonly" name="total_cost" class="input_text" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>" /></td>

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
                                
                            	<!--<input type="text" name="tax_type<?php //echo $s; ?>" id="tax_type<?php //echo $s; ?>" style=" width:100px" value="<?php //echo $data_exclusive['tax_type'] ?>" />-->
                                
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

              <!---------------------------------------End Payment mode------------------------------------->

 

 <tr>

    <td width="25%" >Amount</td>

    <td width="40%"><input type="text" name="amount1" id="amount1" value="<?php if($_POST['save_changes']) echo $_POST['amount1']; else echo $row_record['amount1']; ?>"  /></td>

 </tr>

           

             

              <tr>

                  <td>&nbsp;</td>

                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Inventory" name="save_changes"  /></td>

                  <td></td>

              </tr>

        </table>

        </form>

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

/*if($_SESSION['type']=="S" || $record_id)

{
*/
	?>

    <script>
if(document.getElementById("branch_name").value)
{
	branch_name =document.getElementById("branch_name").value;

	//alert(branch_name);

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
?>

<?php
if($record_id!='')
{
	?>

    <script>

	vendor_id =document.getElementById("vendor_id").value;

	//alert(vendor_id);

	get_product_list(vendor_id,vendor_id);
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