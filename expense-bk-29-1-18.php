<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
$page_name = "expense";
$sele_sac_code="select sac_code from sac_code_config where page_name='".$page_name."'";
$ptr_sac_code=mysql_query( $sele_sac_code);
$data_sac_code=mysql_fetch_array($ptr_sac_code);

$expense_type_id='';
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	
	$sel="select * from expense where expense_id='".$record_id."'";
	$ptr_data=mysql_query($sel);
	if(mysql_num_rows($ptr_data))
	$row_expense=mysql_fetch_array($ptr_data);
	$expense_type_id=$row_expense['expense_type_id']; 
	//echo $row_expense['expense_category_id'];	
	
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_expense['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no from bank where bank_id='".$row_expense['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}
else
{
	$record_id='';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Expense</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
    <!--End multiselect -->
	<link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
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
			
			$("#expense_category").chosen({allow_single_deselect:true});
			$("#vendor").chosen({allow_single_deselect:true});
			$("#employee").chosen({allow_single_deselect:true});
			$("#payment_mode").chosen({allow_single_deselect:true});
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
		/*function show_acc_no(bank_id)
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
		}*/
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
			
			show_bank(branch_name,"cheque")
		}
		else if(payment_mode[0]=="Credit Card")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'block';
			show_bank(branch_name,"credit_card")
			
		}
		else if(payment_mode[0]=="paytm")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'none';
			show_bank(branch_name,"paytm")
		}
		else
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'none';
			document.getElementById("credit_details").style.display = 'none';
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
	
	 function validme()
	 {
		 
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
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
		 
		 if(frm.expense_category.value=='select')
		 {
			 disp_error +='Select Expense Category\n';
			 document.getElementById('expense_category').style.border = '1px solid #f00';
			 frm.expense_category.focus();
			 error='yes';
	     }
		 else if(frm.expense_type.value=='')
		 {
			 disp_error +='Select Expense type\n';
			 document.getElementById('expense_type').style.border = '1px solid #f00';
			 frm.expense_type.focus();
			 error='yes';
			 
		 }
	 	if(frm.amount.value=='')
		 {
			 disp_error +='Plese Enter Amount\n';
			 document.getElementById('amount').style.border = '1px solid #f00';
			 frm.amount.focus();
			 error='yes';
		 }
		 if(frm.vendor.value=='select')
		 {
			 disp_error +='Plese Select Vendor name\n';
			 document.getElementById('vendor').style.border = '1px solid #f00';
			 frm.vendor.focus();
			 error='yes';
		 }
		  if(frm.employee.value=='select')
		 {
			 disp_error +='Plese Select Emplyee name\n';
			 document.getElementById('employee').style.border = '1px solid #f00';
			 frm.employee.focus();
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
	
	function show_bank(branch_id,vals)
	{
		//alert(branch_id);
		if(document.getElementById("record_id"))
		{
			record_id= document.getElementById("record_id").value;
		}
		document.getElementById("bank_record").style.display="none";
		var bank_data="action=expense&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
		
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
	/*function show_bank_for_payment_mode(branch_id,vals)
	{
		//alert(branch_id);
		if(document.getElementById("record_id"))
		record_id= document.getElementById("record_id").value;
		
		document.getElementById("bank_record").style.display="none";
		
		var bank_data="action=expense&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
		
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
		
	}*/
	function show_category(value)
	{
		category_id= value;
		var cat_data="action=show_expense_cat&category_id="+category_id+"&expense_type_id=<?php echo $expense_type_id; ?>";
		
		$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			document.getElementById("expense_subcategory").innerHTML=retbank;
			$("#expense_type").chosen({allow_single_deselect:true});
		}
		
		});
	}
	function calculte_amount_tax(val_tax_ids)
	{
		
		tax_value='';
		tot_amount=0;
		var total_tax_length=document.getElementsByName("total_tax[]").length;
		if(val_tax_ids>0 || total_tax_length!=0)
		{
			var total_tax=document.getElementsByName("total_tax[]").length;
			//alert(total_tax);
			tot_tax_amount=0;
			for(i=1;i<=total_tax;i++)
			{
				tax_id='tax_value'+i;
				tax_amount_id='tax_amount'+i;
				tax_value = Number(document.getElementById(tax_id).value);
			
				cost_tot_tt=parseInt(document.getElementById("total_price").value);
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
			cost_tot_tt=parseInt(document.getElementById("total_price").value);
			//alert(cost_tot_tt);
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
				//calculte_amount_tax(id);
			}
		}
	}
//==============18/1/18==============
function calc_product_price(prod_id)
{
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.discount1.value;
	if(prod_id=="1")
		document.getElementById("product_qty1").readOnly=false;
	
	base_price=document.getElementById("base_price"+prod_id).value;
	if(base_price=='1')
	{
		prod_price=document.getElementById("prod_base_price"+prod_id).value;
	}
	else
	{
		prod_price=document.getElementById("prod_price"+prod_id).value;
	//===================================Calculate Base Price============================== Changes 18/1/18
		var k=0;
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
			//var total_taxable_value = parseFloat(total_price / tax_new);
			//var tot_gst =precisionRound(parseFloat(total_price - total_taxable_value),2);
			//=================================for base price===========================
			var total_base_taxable_value = parseFloat(prod_price / tax_new);
			var tot_base_gst =precisionRound(parseFloat(prod_price - total_base_taxable_value),2);
			//==========================================================================
			total_gst=precisionRound(parseFloat(Number(tot_gst)/k),0);
			//alert(total_gst);
			
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
			//var total_taxable_value = parseFloat(total_price / new_total_tax);
			//var tot_gst =precisionRound(parseFloat(total_price - total_taxable_value),2);
			//=================================for base price===========================
			var total_base_taxable_value = parseFloat(prod_price / new_total_tax);
			var tot_base_gst =precisionRound(parseFloat(prod_price - total_base_taxable_value),2);
			//==========================================================================
			total_gst=precisionRound(parseFloat(tot_gst/k),2);
			//gst_price=Number(parseFloat(igast_tax)).toFixed(2);
			document.getElementById("sin_prod_igst_price"+prod_id).value=precisionRound(total_taxable_value,0);
		}
		
		
		//totals_price=Number(total_price) - Number(tot_gst) ;
		prod_price=Number(prod_price) - Number(tot_base_gst) ; //Fpr base price
		//alert(prod_price);
		totals_base_price=prod_price;
		//total_mrp_price=precisionRound(total_base_price,0);
	//==========================================================End================================18/1/18
	}
	total_prod_price=prod_price;
	total_base_price=prod_price;
	//alert(total_base_price);
	discounted_price=0;
	product_discount=document.getElementById("product_disc"+prod_id).value;
	if(disc_type=="rupees")
	{
		total_prod_price=precisionRound(parseFloat(prod_price-product_discount),2);
		discount_price=precisionRound(parseFloat(product_discount),2);
	}
	else
	{
		discount= parseFloat((prod_price*product_discount)/100).toFixed(2);
		total_prod_price=precisionRound(parseFloat(prod_price-discount),2);
		discount_price=precisionRound(parseFloat(discount),2);
	}
	
	document.getElementById("prod_disc_price"+prod_id).value=discount_price;
	document.getElementById("prod_discounted_price"+prod_id).value=total_prod_price;

	prod_qty=document.getElementById("product_qty"+prod_id).value;
	
	var total_price=total_prod_price * prod_qty;
	document.getElementById("sales_product_price"+prod_id).value=total_price;
	if(base_price==1)
	{
		cgst_value=0;
		cgst_base_value=0;
		cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+prod_id).value).toFixed(2);
		if(cgst_percent >0)
		{
			cgst_value= precisionRound(parseFloat((total_price*cgst_percent)/100),0);
			cgst_base_value= precisionRound(parseFloat((total_base_price*cgst_percent)/100),0);//for base price
			cgst_price=precisionRound(parseFloat(cgst_value),0);
			document.getElementById("sin_prod_cgst_price"+prod_id).value=cgst_price;
		}
		else
		{
			document.getElementById("sin_prod_cgst_price"+prod_id).value=0;
		}
		sgst_value=0;
		sgst_base_value=0;
		sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+prod_id).value).toFixed(2);
		if(sgst_percent >0)
		{
			sgst_value= precisionRound(parseFloat((total_price*sgst_percent)/100),0);
			sgst_base_value= precisionRound(parseFloat((total_base_price*sgst_percent)/100),0);//for base price
			sgst_price=precisionRound(parseFloat(sgst_value),0);
			document.getElementById("sin_prod_sgst_price"+prod_id).value=sgst_price;
		}
		else
		{
			document.getElementById("sin_prod_sgst_price"+prod_id).value=0;
		}
		igst_value=0;
		igst_base_value=0;
		igst_percent=parseFloat(document.getElementById("sin_product_igst"+prod_id).value).toFixed(2);
		if(igst_percent >0)
		{
			igst_value= precisionRound(parseFloat((total_price*igst_percent)/100),0);
			igst_base_value= precisionRound(parseFloat((total_base_price*igst_percent)/100),0);//for base price
			igst_price=precisionRound(parseFloat(igst_value),0);
			document.getElementById("sin_prod_igst_price"+prod_id).value=igst_price;
		}
		else
		{
			document.getElementById("sin_prod_igst_price"+prod_id).value=0;
		}
		totals_price=precisionRound(Number(total_price) + Number(cgst_value) + Number(sgst_value)+ Number(igst_value),0);
		total_mrp_price=precisionRound(Number(total_base_price) + Number(cgst_base_value) + Number(sgst_base_value)+ Number(igst_base_value),0);
		
		//alert(total_mrp_price);
	}
	else
	{
	
		cgst_value=0;
		cgst_base_value=0;
		cgst_percent=parseFloat(document.getElementById("sin_product_cgst"+prod_id).value).toFixed(2);
		if(cgst_percent >0)
		{
			cgst_value= precisionRound(parseFloat((total_price*cgst_percent)/100),0);
			cgst_base_value= precisionRound(parseFloat((total_base_price*cgst_percent)/100),0);//for base price
			cgst_price=precisionRound(parseFloat(cgst_value),0);
			document.getElementById("sin_prod_cgst_price"+prod_id).value=cgst_price;
		}
		else
		{
			document.getElementById("sin_prod_cgst_price"+prod_id).value=0;
		}
		sgst_value=0;
		sgst_base_value=0;
		sgst_percent=parseFloat(document.getElementById("sin_product_sgst"+prod_id).value).toFixed(2);
		if(sgst_percent >0)
		{
			sgst_value= precisionRound(parseFloat((total_price*sgst_percent)/100),0);
			sgst_base_value= precisionRound(parseFloat((total_base_price*sgst_percent)/100),0);//for base price
			sgst_price=precisionRound(parseFloat(sgst_value),0);
			document.getElementById("sin_prod_sgst_price"+prod_id).value=sgst_price;
		}
		else
		{
			document.getElementById("sin_prod_sgst_price"+prod_id).value=0;
		}
		igst_value=0;
		igst_base_value=0;
		igst_percent=parseFloat(document.getElementById("sin_product_igst"+prod_id).value).toFixed(2);
		if(igst_percent >0)
		{
			igst_value= precisionRound(parseFloat((total_price*igst_percent)/100),0);
			igst_base_value= precisionRound(parseFloat((total_base_price*igst_percent)/100),0);//for base price
			igst_price=precisionRound(parseFloat(igst_value),0);
			document.getElementById("sin_prod_igst_price"+prod_id).value=igst_price;
		}
		else
		{
			document.getElementById("sin_prod_igst_price"+prod_id).value=0;
		}
		totals_price=precisionRound(Number(total_price) + Number(cgst_value) + Number(sgst_value)+ Number(igst_value),0);
		total_mrp_price=precisionRound(Number(total_base_price) + Number(cgst_base_value) + Number(sgst_base_value)+ Number(igst_base_value),0);
	}
	if(base_price==1)
	{
		document.getElementById("prod_price"+prod_id).value=total_mrp_price;
		document.getElementById("mrp_price"+prod_id).value=total_mrp_price;
		document.getElementById("sales_product_price"+prod_id).value=totals_price;
	}
	else
	{
		document.getElementById("sales_product_price"+prod_id).value=totals_price;
		document.getElementById("prod_base_price"+prod_id).value=totals_base_price;
		document.getElementById("mrp_price"+prod_id).value=total_mrp_price;
		//document.getElementById("prod_discounted_price"+prod_id).value=totals_base_price;
	}
	
	showUser();
	calculte_total_cost();
	//cal_remaining_amt();
}
function precisionRound(number, precision) 
{
	var factor = Math.pow(10, precision);
	return Math.round(number * factor) / factor;
}

function delete_records(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#expense_name'+id).replaceWith(function(){
			return $('<input type="text"  name="expense_name'+id+'" id="expense_name'+id+'"  style="width:90%" />', {html: $(this).html()});
		});
		$('#prod_price'+id).replaceWith(function(){
			return $('<input type="text" name="prod_price'+id+'" id="prod_price'+id+'" value="" style="width:60px" />', {html: $(this).html()});
		});
		$('#prod_base_price'+id).replaceWith(function(){
			return $('<input type="text" name="prod_base_price'+id+'" id="prod_base_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#product_disc'+id).replaceWith(function(){
			return $('<input type="text" name="product_disc'+id+'" id="product_disc'+id+'" value="" />', {html: $(this).html()});
		});
		$('#prod_discounted_price'+id).replaceWith(function(){
			return $('<input type="text" name="prod_discounted_price'+id+'" id="prod_discounted_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#product_qty'+id).replaceWith(function(){
			return $('<input type="text" name="product_qty'+id+'" id="product_qty'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_product_cgst'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_cgst'+id+'" id="sin_product_cgst'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_prod_cgst_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_prod_cgst_price'+id+'" id="sin_prod_cgst_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_product_sgst'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_sgst'+id+'" id="sin_product_sgst'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_prod_sgst_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_prod_sgst_price'+id+'" id="sin_prod_sgst_price'+id+'" value="" />', {html: $(this).html()});
		});
		
		$('#sin_product_igst'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_igst'+id+'" id="sin_product_igst'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_prod_igst_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_prod_igst_price'+id+'" id="sin_prod_igst_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#mrp_price'+id).replaceWith(function(){
			return $('<input type="text" name="mrp_price'+id+'" id="mrp_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sales_product_price'+id).replaceWith(function(){
			return $('<input type="text" name="sales_product_price'+id+'" id="sales_product_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#base_price'+id).replaceWith(function(){
			return $('<input type="text" name="base_price'+id+'" id="base_price'+id+'" value="" />', {html: $(this).html()});
		});
		if(types=='floor')
		{  
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
			showUser();
		}
	}
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
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT expense_id FROM ".$GLOBALS["pre_db"]."expense where expense_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {
										"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Delete','expense','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
										$query=mysql_query($insert); 
										
                                        $delete_query="delete from ".$GLOBALS["pre_db"]."expense where expense_id='".$del_record_id."'";
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
                        $sql_query= "SELECT expense_id FROM ".$GLOBALS["pre_db"]."expense where expense_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Delete','expense','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert); 
										
                            $delete_query="delete from ".$GLOBALS["pre_db"]."expense where expense_id='".$del_record_id."'";
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
	if($_POST['save_changes'])
	{
		$sac_code=($_POST['sac_code']) ? $_POST['sac_code'] : "";
		$payment_mode=$_POST['payment_mode'];
		$sep=explode("-",$payment_mode);
		//$payment_mode_id=$sep[1];
		$payment_mode_id=( ($sep[1])) ? $sep[1] : "0";
		$bank_name='';
		$account_no='';
		$chaque_no='';
		$credit_card_no='';
		$date='';
		
		if($payment_mode_id !='1')
		{
			//$bank_name=$_POST['bank_name'];
			$bank_name=( ($_POST['bank_name'])) ? $_POST['bank_name'] : "0";
			//$account_no=$_POST['account_no'];
			$account_no=( ($_POST['account_no'])) ? $_POST['account_no'] : "0";
			///$chaque_no=$_POST['chaque_no'];
			$chaque_no=( ($_POST['chaque_no'])) ? $_POST['chaque_no'] : "0";
			//$credit_card_no=$_POST['credit_card_no'];
			$credit_card_no=( ($_POST['credit_card_no'])) ? $_POST['credit_card_no'] : "0";
			$date=$_POST['date'];
		}
		
		$amount=( ($_POST['amount'])) ? $_POST['amount'] : "0";
		$amount_wo_tax=( ($_POST['amount_wo_tax'])) ? $_POST['amount_wo_tax'] : "0";
		
		$discount_type= ($_POST['discount_type']) ? $_POST['discount_type'] : "";
		$discount= ($_POST['discount']) ? $_POST['discount'] : "";
		$discount_price=($_POST['discount_price']) ? $_POST['discount_price'] : "";
		$total_price=($_POST['total_price']) ? $_POST['total_price'] : "";
		
		$description=( ($_POST['description'])) ? $_POST['description'] : "";
		$vendor=( ($_POST['vendor'])) ? $_POST['vendor'] : "0";
		$employee=( ($_POST['employee'])) ? $_POST['employee'] : "0";
		$expense_type=( ($_POST['expense_type'])) ? $_POST['expense_type'] : "0";
		$expense_category=( ($_POST['expense_category'])) ? $_POST['expense_category'] : "0";
		$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "0";
		if($_POST['added_date'] !='')
		{
			$ad_date=explode('/',$_POST['added_date'],3);
			$added_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
		}
		else $added_date=date('Y-m-d');
		$total_type1=$_POST['total_type1'];
		if(count($errors))
		{
		?>
		<tr><td> <br></br>
				<table align="left" style="text-align:left;" class="alert">
				<tr><td ><strong>Please correct the following errors</strong><ul>
						<?php
						for($k=0;$k<count($errors);$k++)
								echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
						</ul>
				</td></tr>
				</table>
		 </td></tr>   <br></br>  
	<?php
		}
		else
		{
			$success=1;
			$data_record['sac_code']=$sac_code;
			$data_record['payment_mode_id'] = $payment_mode_id;
			$data_record['bank_id'] = $bank_name;
			$data_record['account_no'] = $account_no;
			$data_record['chaque_no'] = $chaque_no;
			$data_record['credit_card_no'] = $credit_card_no;
			$data_record['chaque_date'] = $date;
			$data_record['amount'] = $amount;
			$data_record['amount_wo_tax'] = $amount_wo_tax;
			$data_record['discount_type'] = $discount_type;
			$data_record['discount'] = $discount;
			$data_record['discount_price'] = $discount_price;
			$data_record['total_price'] = $total_price;
			$data_record['description'] = $description;
			$data_record['vendor_id'] = $vendor;
			$data_record['employee_id'] = $employee;
			$data_record['added_date'] = $added_date;
			$data_record['expense_type_id'] =$expense_type	;
			$data_record['expense_category_id'] =$expense_category;
			$total_floor=$_POST['floor'];
			//===============================CM ID for Super Admin===============
				if($_SESSION['type']=='S')
				{
					$sel_branch="select cm_id ,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
					$ptr_branch=mysql_query($sel_branch);
					$data_branch=mysql_fetch_array($ptr_branch);
					$cm_id=$data_branch['cm_id'];
					$data_record['cm_id']=$data_branch['cm_id'];
					
					$branch_name1=$branch_name;
					$_SESSION['cm_id_notification']=$data_branch['cm_id'];
				}	
				else
				{
					$cm_id=$_SESSION['cm_id'];
					$branch_name1=$_SESSION['branch_name'];
					$data_record['cm_id']=$_SESSION['cm_id'];
				}
				$admin_id=$_SESSION['admin_id'];
			//========================================================================
			
			if($record_id)
			{
				//$update="update expense set payment_mode_id='".$data_record['payment_mode_id']."',bank_id='".$data_record['bank_name']."',account_no='".$data_record['account_no']."',chaque_no='".$data_record['chaque_no']."',chaque_date='".$data_record['date']."',amount_wo_tax='".$data_record['amount_wo_tax']."',amount='".$data_record['amount']."',description='".$data_record['description']."',vendor_id='".$data_record['vendor']."',employee_id='".$data_record['employee']."',added_Date='".$added_date."',expense_type_id='".$data_record['expense_type']."',credit_card_no= '".$data_record['credit_card_no']."', cm_id='".$cm_id."', expense_category_id='".$expense_category."', sac_code='".$sac_code."' where expense_id='".$record_id."'";
				//$ptr_update=mysql_query($update);
				
				$where_records="expense_id='".$record_id."'";
				$db->query_update("expense", $data_record,$where_records);
				
				for($z=1;$z<=$total_floor;$z++)
				{
					"Floor- ". $_POST['del_floor'.$z]."<br />";
					"<br />floor_id- ".$_POST['floor_id'.$z];
					if($_POST['del_floor'.$z]=='yes')
					{
						if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
						{
							"<br />".$delete_row = "delete from expense_map where map_id='".$_POST['floor_id'.$z]."' ";
							$ptr_delete = mysql_query($delete_row);
						}
					}
					if($_POST['del_floor'.$z] !='yes')
					{
					//$data_record_extra['product_id']=$record_id;   
					//$data_record_extra['title'] =ucfirst($_POST['title'.$z]);										
					$data_record_service['expense_id'] =$record_id; 
					$data_record_service['expense_name']=( ($_POST['expense_name'.$z])) ? $_POST['expense_name'.$z] : "";
					$data_record_service['prod_price']=( ($_POST['prod_price'.$z])) ? $_POST['prod_price'.$z] : "0";
					$data_record_service['base_prod_price']=( ($_POST['prod_base_price'.$z])) ? $_POST['prod_base_price'.$z] : "0";
					$data_record_service['disc_type']=( ($_POST['discount1'])) ? $_POST['discount1'] : "";
					$data_record_service['product_qty']=( ($_POST['product_qty'.$z])) ? $_POST['product_qty'.$z] : "0";
					$data_record_service['discounted_price']=( ($_POST['prod_discounted_price'.$z])) ? $_POST['prod_discounted_price'.$z] : "0";
					
					$data_record_service['cgst_tax_in_per'] =$_POST['sin_product_cgst'.$z] ? $_POST['sin_product_cgst'.$z] : "0";
					$data_record_service['cgst_tax'] =$_POST['sin_prod_cgst_price'.$z] ? $_POST['sin_prod_cgst_price'.$z] : "0";
					$data_record_service['sgst_tax_in_per'] =$_POST['sin_product_sgst'.$z] ? $_POST['sin_product_sgst'.$z] : "0";
					$data_record_service['sgst_tax'] =$_POST['sin_prod_sgst_price'.$z] ? $_POST['sin_prod_sgst_price'.$z] : "0";
					$data_record_service['igst_tax_in_per'] =$_POST['sin_product_igst'.$z] ? $_POST['sin_product_igst'.$z] : "0";
					$data_record_service['igst_tax'] =$_POST['sin_prod_igst_price'.$z] ? $_POST['sin_prod_igst_price'.$z] : "0";
					
					$data_record_service['product_disc']=( ($_POST['product_disc'.$z])) ? $_POST['product_disc'.$z] : "0";
					$data_record_service['sales_product_price']=( ($_POST['sales_product_price'.$z])) ? $_POST['sales_product_price'.$z] : "0";
					$data_record_service['base_value']=( ($_POST['base_price'.$z])) ? $_POST['base_price'.$z] : "";
					
					if($_POST['floor_id'.$z]=='' && $_POST['expense_name'.$z] !='')
					{
						 $type1_id=$db->query_insert("expense_map", $data_record_service);
					}
					else
					{
						$where_record="map_id='".$_POST['floor_id'.$z]."'";
						$floor_id= $_POST['floor_id'.$z];
						$db->query_update("expense_map", $data_record_service,$where_record);
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
							"<br />".$delete_row = " delete from expense_tax_map where expense_tax_map_id='".$_POST['type1_id'.$x]."' ";
							$ptr_delete = mysql_query($delete_row);
						}
					}
					if($_POST['del_floor_type1'.$x] !='yes')
					{
						$data_record_tax['expense_id'] =$record_id; 
						'<br/>'.$data_record_tax['tax_type'] =$_POST['tax_type'.$x];
						$data_record_tax['tax_value'] =$_POST['tax_value'.$x];
						$data_record_tax['tax_amount'] =$_POST['tax_amount'.$x];
						if($_POST['type1_id'.$x]=='' && $_POST['tax_type'.$x] !='')
						{
							$type1_id=$db->query_insert("expense_tax_map", $data_record_tax);
						}
						else
						{
							$where_record="expense_tax_map_id='".$_POST['type1_id'.$x]."'";
							$type1_id= $_POST['type1_id'.$x];
							$db->query_update("expense_tax_map", $data_record_tax,$where_record);
						}
						unset($data_record_tax);
					}
				}
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Edit','expense','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert); 
										
				//echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense added successfully</p></center></div>
				<script type="text/javascript">
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
						});
						
					});
				   setTimeout('document.location.href="expense.php";',1000);
				</script>
				<?php
			}
			else
			{
				"<br/>".$insert_for_receipt = "insert into expense (`payment_mode_id`,`bank_id`,`account_no`,`chaque_no`,`chaque_date`,`amount_wo_tax`,`amount`,`discount_type`,`discount`,`discount_price`,`total_price`,`description`,`vendor_id`,`employee_id`,`expense_category_id`,`expense_type_id`,`credit_card_no`,`sac_code`,`added_date`,`cm_id`) values('".$data_record['payment_mode_id']."','".$data_record['bank_name']."','".$data_record['account_no']."','".$data_record['chaque_no']."','".$data_record['date']."','".$data_record['amount_wo_tax']."','".$data_record['amount']."','".$data_record['discount_type']."','".$data_record['discount']."','".$data_record['discount_price']."','".$data_record['total_price']."','".$data_record['description']."','".$data_record['vendor_id']."','".$data_record['employee_id']."','".$data_record['expense_category_id']."','".$data_record['expense_type_id']."','".$data_record['credit_card_no']."','".$sac_code."','".$added_date."','".$cm_id."')";
				$ptr_insert_receipt = mysql_query($insert_for_receipt);
				$ins_is=mysql_insert_id();
				
				for($i=1;$i<=$total_floor;$i++)
				{
					if($_POST['expense_name'.$i] !='' )
					{
						$data_record_service['expense_id'] =$ins_is; 
						$data_record_service['expense_name']=( ($_POST['expense_name'.$i])) ? $_POST['expense_name'.$i] : "";
						$data_record_service['prod_price']=( ($_POST['prod_price'.$i])) ? $_POST['prod_price'.$i] : "0";
						$data_record_service['base_prod_price']=( ($_POST['prod_base_price'.$i])) ? $_POST['prod_base_price'.$i] : "0";
						$data_record_service['disc_type']=( ($_POST['discount1'])) ? $_POST['discount1'] : "";
						$data_record_service['product_qty']=( ($_POST['product_qty'.$i])) ? $_POST['product_qty'.$i] : "0";
						$data_record_service['discounted_price']=( ($_POST['prod_discounted_price'.$i])) ? $_POST['prod_discounted_price'.$i] : "0";
						
						$data_record_service['cgst_tax_in_per'] =$_POST['sin_product_cgst'.$i] ? $_POST['sin_product_cgst'.$i] : "0";
						$data_record_service['cgst_tax'] =$_POST['sin_prod_cgst_price'.$i] ? $_POST['sin_prod_cgst_price'.$i] : "0";
						$data_record_service['sgst_tax_in_per'] =$_POST['sin_product_sgst'.$i] ? $_POST['sin_product_sgst'.$i] : "0";
						$data_record_service['sgst_tax'] =$_POST['sin_prod_sgst_price'.$i] ? $_POST['sin_prod_sgst_price'.$i] : "0";
						$data_record_service['igst_tax_in_per'] =$_POST['sin_product_igst'.$i] ? $_POST['sin_product_igst'.$i] : "0";
						$data_record_service['igst_tax'] =$_POST['sin_prod_igst_price'.$i] ? $_POST['sin_prod_igst_price'.$i] : "0";
						
						$data_record_service['product_disc']=( ($_POST['product_disc'.$i])) ? $_POST['product_disc'.$i] : "0";
						$data_record_service['sales_product_price']=( ($_POST['sales_product_price'.$i])) ? $_POST['sales_product_price'.$i] : "0";
						$data_record_service['base_value']=( ($_POST['base_price'.$i])) ? $_POST['base_price'.$i] : "";
						$customer_service_id=$db->query_insert("expense_map", $data_record_service);
					}
				}
				for($j=1;$j<=$total_type1;$j++)
				{
					if($_POST['tax_type'.$j] !='' && $_POST['tax_value'.$j] !='')
					{
						$data_record_tax['expense_id'] =$ins_is; 
						$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
						$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
						$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
						$customer_tax_id=$db->query_insert("expense_tax_map", $data_record_tax);
					}
				}
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Add','expense','".$ins_is."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert); 
										
				echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense added successfully</p></center></div>
				<script type="text/javascript">
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
						});
					});
				   setTimeout('document.location.href="expense.php";',1000);
				</script>
				<?php
			}
		}
	}
	/*if($success==0)
	{	*/
			
	?>
<form name="jqueryForm" method="post">
<table cellspacing="3" cellpadding="3" style="border:1px solid #CCC; margin-top: 15px;" width="95%">
<?php if($_SESSION['type']=='S')
{
	?>
<tr>
<td align="center">Select Branch</td>

<td>
<?php 
$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
$query_branch = mysql_query($sel_branch);
$total_Branch = mysql_num_rows($query_branch);
echo '<table width="100%"><tr><td>';
echo ' <select id="branch_name" style="width:200px" class="input_text" name="branch_name" onchange="show_bank(this.value)">';

while($row_branch = mysql_fetch_array($query_branch))
{
	$selected='';
	if($_POST['branch_name']== $row_branch['branch_name'])
	{
		 $selected='selected="selected"';
	}
	$selected_branch="select branch_name from site_setting where cm_id= '".$row_expense['cm_id']."' and type='A' ";
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
<?php }  
else { ?>
   <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
   <?php }?>

<!---------------------------------------Payment mode------------------------------------->  
<tr>
	<td width="15%" align="center">Date<span class="orange_font">*</span><input type="hidden" name="res1" id="res1" /></td>
	<td width="25%"><input style="width:200px" type="text" id="added_date" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
	<input type="hidden" name="record_id" class="input_text" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
	</td>
</tr> 
<tr>
	<td width="15%" align="center">SAC No.<span class="orange_font"></span></td>
	<td width="25%"><input type="text" style="width:200px" name="sac_code" id="sac_code" class="input_text" value="<?php if($_POST['sac_code']) echo $_POST['sac_code']; else echo $data_sac_code['sac_code']; ?>"  />
	</td>
</tr>
 <tr>
    <td width="15%" class="tr-header" align="center">Select Payment Mode</td>
    <td width="25%"><select name="payment_mode" style="width:200px" class="input_text" id="payment_mode" onchange="payment(this.value)">
    <option value="select">--Select--</option>
    <?php
	$sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
	$ptr_payment_mode=mysql_query($sel_payment_mode);
	while($data_payment=mysql_fetch_array($ptr_payment_mode))
	{
		$selected='';
		if($data_payment['payment_mode_id'] == $row_expense['payment_mode_id'])
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
 <td width="15%" class="tr-header"  align="center">Bank Name</td>
 <td>
 
  <?php 
/*if($_SESSION['type'] !="S")
{
?>
<select name="bank_name" class="input_text" id="bank_name"  style="width:200px" onchange="show_acc_no(this.value)">
 <option value="">--Select--</option>
 <?php
 $sle_bank_name="select bank_id,bank_name from bank "; 
 $ptr_bank_name=mysql_query($sle_bank_name);
 while($data_bank=mysql_fetch_array($ptr_bank_name))
 {
	$selected='';
	if($data_bank['bank_id'] == $row_expense['bank_id'])
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
	if($record_id !='')
	{
	?>
	<select name="bank_name" class="input_text" style="width:200px" id="bank_name" onChange="show_acc_no(this.value)">
	<option value="">--Select--</option>
	<?php
	$sle_bank_name="select bank_id,bank_name from bank where cm_id='".$row_expense['cm_id']."'"; 
	$ptr_bank_name=mysql_query($sle_bank_name);
	while($data_bank=mysql_fetch_array($ptr_bank_name))
	{
		$selected='';
		if($data_bank['bank_id'] == $row_expense['bank_id'])
		{
			$selected='selected="selected"';
		}
		 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
	}
	?>
	</select>
	<?php
	}
	?></div>         
 <div id="bank_id"></div>
 </td>
 </tr>
 <tr>
 <td width="35%" class="tr-header" align="center">Enter Account No</td>
 <td><input type="text" name="account_no" class="input_text" style="width:200px" id="account_no" readonly="readonly" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $row_expense['account_no']; ?>" /></td>
 
 </tr>
 </table>
 </div>
 
 <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
 <table width="100%">

 
 <tr>
 <td width="35%" class="tr-header" align="center">Enter Chaque No</td>
 <td><input type="text" name="chaque_no" class="input_text" style="width:200px" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_expense['chaque_no']; ?>" /></td>
 </tr>
 <tr>
 <td width="35%" class="tr-header" align="center">Enter Chaque Date</td>
 <td><input type="text" name="date" id="date" style="width:200px"  class="datepicker input_text" value="<?php if($_POST['date']) echo $_POST['date']; else echo $row_expense['chaque_date']; ?>"  /></td>
 </tr>
 </table>
 </div>
 
 
 
 <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
 <table width="100%">
 
 <tr>
 <td width="35%" class="tr-header" align="center">Enter Credit Card No</td>
 <td><input type="text" name="credit_card_no" class="input_text" style="width:200px" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_expense['credit_card_no']; ?>" /></td>
 </tr>
 </table>
 </div>
 
 
 </td>
 </tr>
 <tr>
    <td width="15%" class="tr-header" align="center">Select Expense Category</td>
    <td width="25%"><select name="expense_category" style="width:200px" class="input_text" onchange="show_category(this.value)" id="expense_category">
    <option value="select">--Select--</option>
    <?php
	$sel_payment_mode="select * from expense_category";
	$ptr_payment_mode=mysql_query($sel_payment_mode);
	while($data_payment=mysql_fetch_array($ptr_payment_mode))
	{
		$selected='';
		if($data_payment['expense_category_id'] == $row_expense['expense_category_id'])
		{
			$selected='selected="selected"';
		}
		echo '<option '.$selected.' value="'.$data_payment['expense_category_id'].'">'.$data_payment['name'].'</option>';
	}
	
	?>
    </select></td>
 </tr>
 <tr>
    <td width="15%" colspan="3"><div id="expense_subcategory"></div></td>
  
 </tr>
 <tr>
	<!--<td width="10%">Select Product<span class="orange_font">*</span></td>-->
	<td colspan="3">
		<table  width="100%" style="border:1px solid gray; ">
			<tr>
			<td colspan="3">
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
				var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td width="20%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><input type="text" name="expense_name'+idss+'" id="expense_name'+idss+'" style="width:90%" /></td><td width="3%" align="center"><input type="text" name="prod_price'+idss+'" id="prod_price'+idss+'" onkeyup="calc_product_price('+idss+')" style="width:60px" /></td><td width="3%" align="center"><input type="text" name="prod_base_price'+idss+'" readonly=true style="background-color:#cccc;width:60px"  id="prod_base_price'+idss+'" onkeyup="calc_product_price('+idss+')" /></td><td width="4%" align="center"><input type="text" name="product_disc'+idss+'" id="product_disc'+idss+'" onkeyup="calc_product_price('+idss+')" style="width:90px" /></td><td width="4%" align="center"><input type="text" name="prod_discounted_price'+idss+'" id="prod_discounted_price'+idss+'" style="width:50px" /><input type="hidden" name="prod_disc_price'+idss+'" id="prod_disc_price'+idss+'" /></td><td width="4%" align="center"><input type="text" name="product_qty'+idss+'" id="product_qty'+idss+'" value="1" readonly=true onkeyup="calc_product_price('+idss+')" style="width:50px" /></td><td width="5%" align="center"><input type="text" onkeyup="calc_product_price('+idss+')" name="sin_product_cgst'+idss+'" id="sin_product_cgst'+idss+'" style=" width:60px"><input type="text" name="sin_prod_cgst_price'+idss+'" id="sin_prod_cgst_price'+idss+'" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_product_sgst'+idss+'" onkeyup="calc_product_price('+idss+')" id="sin_product_sgst'+idss+'" style=" width:60px"><input type="text" name="sin_prod_sgst_price'+idss+'" id="sin_prod_sgst_price'+idss+'" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_product_igst'+idss+'" onkeyup="calc_product_price('+idss+')" id="sin_product_igst'+idss+'" style=" width:60px"><input type="text" name="sin_prod_igst_price'+idss+'" id="sin_prod_igst_price'+idss+'" style=" width:60px" /></td><td width="4%" align="center"><input type="text" name="mrp_price'+idss+'" id="mrp_price'+idss+'" readonly="readonly" style="width:50px" /></td><td width="4%" align="center"><input type="text" name="sales_product_price'+idss+'" id="sales_product_price'+idss+'" onkeyup="calc_product_price('+idss+')" style="width:50px" /><input type="hidden" name="total_sales_product[]" id="total_sales_product'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></td><td width="2%" align="center"><a onClick="reset_price('+idss+')"><img src="images/refresh.png" height="25" width="25" alt="refresh"></a></td><td width="2%"><input type="hidden" name="base_price'+idss+'" id="base_price'+idss+'" value="0" /></td><tr></table></div>';
				document.getElementById('floor').value=idss;
				return shows_data;
			}
			</script>
			<td align="right"><input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" ><input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" ></td></tr>
			<tr><td></td><td align="left"></td></tr>
		</table> 
		<table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr> <tr><td align="center" width="25%"> </td><td width="10%"> </td><td width="5%"> </td></tr>
		<tr>
			<td colspan="6">
				<table cellspacing="3" id="tbl" width="100%">
				<tr>
					<td valign="top" align="center" width="22%">Product Name</td>
					<td valign="top" align="center" width="7%">MRP</td>
					<td valign="top" align="center" width="7%">Base Price</td>
					<td valign="top" align="center" width="10%">Discount<br/>
					<input type="radio" name="discount1" id="discount1" checked="checked" value="percentage" />in %
					<input type="radio" name="discount1" id="discount1" value="rupees" />in Rs/-</td>
					<td valign="top" width="6%" align="center">Discounted price</td>
					<td valign="top" width="6%" align="center">Qty</td>
					<td valign="top" width="7%" align="center">CGST</td>
					<td valign="top" width="7%" align="center">SGST</td>
					<td valign="top" width="8%" align="center">IGST</td>
					<td valign="top" width="6%" align="center" >MRP</td>
					<td valign="top" width="6%" align="center">Total</td>
					<td valign="top" width="4%" align="center">Reset</td>
					<td valign="top" width="2%"  align="center"> <?php	if($record_id){ echo "Acton"; } ?></td>
				</tr>
				<tr>
					<td colspan="13">
					<?php
					if($record_id)
					{
					$select_exc = "select * from expense_map where expense_id='".$record_id."' order by map_id asc ";
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
						
						<td width="22%" align="center"><input type="text" name="expense_name<?php echo $t; ?>" id="expense_name<?php echo $t; ?>" style="width:90%" value="<?php echo $data_exclusive['expense_name'] ?>" /></td><td width="3%" align="center"><input type="text" name="prod_price<?php echo $t; ?>" id="prod_price<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" style="width:60px" value="<?php echo $data_exclusive['prod_price'] ?>" /></td><td width="3%" align="center"><input type="text" name="prod_base_price<?php echo $t; ?>" readonly=true style="background-color:#cccc;width:60px" value="<?php echo $data_exclusive['base_prod_price'] ?>" id="prod_base_price<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" /></td><td width="4%" align="center"><input type="text" name="product_disc<?php echo $t; ?>" id="product_disc<?php echo $t; ?>" value="<?php echo $data_exclusive['product_disc'] ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" style="width:90px" /></td><td width="4%" align="center"><input type="text" name="prod_discounted_price<?php echo $t; ?>" id="prod_discounted_price<?php echo $t; ?>" style="width:50px" value="<?php echo $data_exclusive['discounted_price'] ?>"/><input type="hidden" name="prod_disc_price<?php echo $t; ?>" id="prod_disc_price<?php echo $t; ?>" value="<?php echo $data_exclusive['product_disc'] ?>"/></td><td width="4%" align="center"><input type="text" name="product_qty<?php echo $t; ?>" id="product_qty<?php echo $t; ?>" value="1" onkeyup="calc_product_price(<?php echo $t; ?>)" style="width:50px" value="<?php echo $data_exclusive['product_qty'] ?>" /></td><td width="5%" align="center"><input type="text" onkeyup="calc_product_price(<?php echo $t; ?>)" name="sin_product_cgst<?php echo $t; ?>" id="sin_product_cgst<?php echo $t; ?>" style=" width:60px"  value="<?php echo $data_exclusive['cgst_tax_in_per'] ?>" /><input type="text" name="sin_prod_cgst_price<?php echo $t; ?>" id="sin_prod_cgst_price<?php echo $t; ?>" style="width:60px" value="<?php echo $data_exclusive['cgst_tax'] ?>" /></td><td width="5%" align="center"><input type="text" name="sin_product_sgst<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" id="sin_product_sgst<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['sgst_tax_in_per'] ?>" /><input type="text" name="sin_prod_sgst_price<?php echo $t; ?>" id="sin_prod_sgst_price<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['sgst_tax'] ?>" /></td><td width="5%" align="center"><input type="text" name="sin_product_igst<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" id="sin_product_igst<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['igst_tax_in_per']; ?>" /><input type="text" name="sin_prod_igst_price<?php echo $t; ?>" id="sin_prod_igst_price<?php echo $t; ?>" style=" width:60px" value="<?php echo $data_exclusive['igst_tax'] ?>" /></td><td width="4%" align="center"><input type="text" name="mrp_price<?php echo $t; ?>" id="mrp_price<?php echo $t; ?>" readonly="readonly" style="width:50px" value="<?php echo $data_exclusive['prod_price'] ?>" /></td><td width="4%" align="center"><input type="text" name="sales_product_price<?php echo $t; ?>" id="sales_product_price<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" style="width:50px" value="<?php echo $data_exclusive['sales_product_price']; ?>" /></td><td width="2%" align="center"><a onClick="reset_price(<?php echo $t; ?>)"><img src="images/refresh.png" height="25" width="25" alt="refresh"></a><input type="hidden" name="base_price<?php echo $t; ?>" id="base_price<?php echo $t; ?>" value="<?php echo $data_exclusive['base_price']; ?>"  /></td>
						<td valign="top" width="2%" align="center">
						<?php
						if($record_id)
						{
							?>
							<input type="hidden" name="total_sales_product[]" id="total_sales_product<?php echo $t; ?>" />
							<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['map_id'] ?>" />
							<input type="button" title="Delete Options(-)" onClick="delete_records(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
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
				<input type="hidden" name="floor" id="floor" value="0" />
			<div id="create_floor"></div>
			</td>
		</tr>
		</table>
		<?php
		if($record_id)
		{
			?>
			<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
			<input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
			<?php 
		} 
		?> 
		<!--============================================================END TABLE=========================================-->
		</td>
		</tr>
	</table>
</td>
</tr>
			
 <!--<tr>
	<td width="10%" align="center">Enter Expenses Name<span class="orange_font">*</span></td>
	<td colspan="2">
		<table  width="100%" style="border:1px solid gray;">
			<tr>
			<td colspan="2">
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
				var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td width="25%" align="left"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><input type="text" name="expense_name'+idss+'" id="expense_name'+idss+'" style="width:90%" /></td><td width="12%" align="center"><input type="text" name="prod_price'+idss+'" id="prod_price'+idss+'" onkeyup="calc_product_price('+idss+')" style="width:80px" /></td><td width="6%" align="center"><input type="text" name="product_qty'+idss+'" id="product_qty'+idss+'" onkeyup="calc_product_price('+idss+')" style="width:50px" value="1" /></td><td width="9%" align="center"><input type="text" name="net_amnt'+idss+'" id="net_amnt'+idss+'" readonly="readonly" style="width:60px" /></td><td width="12%" align="center"><input type="text" name="product_disc'+idss+'" id="product_disc'+idss+'" onkeyup="calc_product_price('+idss+')" style="width:80px" /><input type="hidden" name="prod_disc_price'+idss+'" id="prod_disc_price'+idss+'" /></td><td width="8%" align="center"><input type="text" onkeyup="calc_product_price('+idss+')" name="sin_product_cgst'+idss+'" id="sin_product_cgst'+idss+'" style=" width:60px"><input type="hidden" name="sin_prod_cgst_price'+idss+'" id="sin_prod_cgst_price'+idss+'" /></td><td width="8%" align="center"><input type="text" name="sin_product_sgst'+idss+'" onkeyup="calc_product_price('+idss+')" id="sin_product_sgst'+idss+'" style=" width:60px"><input type="hidden" name="sin_prod_sgst_price'+idss+'" id="sin_prod_sgst_price'+idss+'" /></td><td width="8%" align="center"><input type="text" name="sin_product_igst'+idss+'" onkeyup="calc_product_price('+idss+')" id="sin_product_igst'+idss+'" style=" width:60px"><input type="hidden" name="sin_prod_igst_price'+idss+'" id="sin_prod_igst_price'+idss+'" /></td><td width="14%" align="center"><input type="text" name="sales_product_price'+idss+'" id="sales_product_price'+idss+'" onkeyup="calc_product_price('+idss+')" style="width:80px" /><input type="hidden" name="total_sales_product[]" id="total_sales_product'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></td><td width="14%" align="center"></td><tr></table></div>';
				document.getElementById('floor').value=idss;
				return shows_data;
			}
			</script>
			<td align="right"><input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" ><input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" ></td></tr>
			<tr><td></td><td align="left"></td></tr>
		</table> 
		<table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr> <tr><td align="center" width="25%"> </td><td width="10%"> </td><td width="5%"> </td></tr>
		<tr>
			<td colspan="6">
				<table cellspacing="3" id="tbl" width="100%">
				<tr>
					<td valign="top" align="center" width="25%">Product Name</td>
					<td valign="top" align="center" width="12%">Product Price</td>
					<td valign="top" width="6%" align="center">Qty</td>
					<td valign="top" width="9%" align="center">Net Amnt.</td>
					<td valign="top" width="12%" align="center">Discount<br/>
					<input type="radio" name="discount1" id="discount1" checked="checked" value="percentage" />in %
					<input type="radio" name="discount1" id="discount1" value="rupees" />in Rs/-</td>
					<td valign="top" width="8%" align="center">CGST</td>
					<td valign="top" width="8%" align="center">SGST</td>
					<td valign="top" width="8%" align="center">IGST</td>
					<td valign="top" width="14%" align="center">Price</td>
					<td valign="top" width="8%"  align="center"> <?php	if($record_id){ echo "Acton"; } ?></td>
				</tr>
				<tr>
					<td colspan="7">
					<?php
					if($record_id)
					{
					$select_exc = "select * from expense_map where expense_id='".$record_id."' order by map_id asc ";
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
						<td valign="top" width="25%" align="center"><input type="text" name="expense_name<?php echo $t; ?>" id="expense_name<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['expense_name'] ?>" /></td>
						<td width="12%" align="center"><input type="text" onkeyup="calc_product_price('<?php echo $t; ?>')" name="prod_price<?php echo $t; ?>" id="prod_price<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['prod_price'] ?>" /></td><td width="6%" align="center"><input type="text" name="product_qty<?php echo $t; ?>" id="product_qty<?php echo $t; ?>" value="<?php echo $data_exclusive['product_qty'] ?>" onKeyUp="calc_product_price(<?php echo $t; ?>)"  style=" width:100px" /></td><td width="9%" align="center"><input type="text" onkeyup="calc_service_price('<?php echo $t; ?>')" name="net_amnt<?php echo $t; ?>" id="net_amnt<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['net_amnt'] ?>"></td><td width="12%" align="center"><input type="text" onkeyup="calc_product_price('<?php echo $t; ?>')" name="product_disc<?php echo $t; ?>" id="product_disc<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['product_disc'] ?>"><input type="hidden" name="prod_disc_price<?php echo $t; ?>" id="prod_disc_price<?php echo $t; ?>" /></td>
						<td width="8%" align="center"><input type="text" onkeyup="calc_product_price('+idss+')" name="sin_product_cgst<?php echo $t; ?>" id="sin_product_cgst<?php echo $t; ?>" style=" width:60px"><input type="hidden" name="sin_prod_cgst_price<?php echo $t; ?>" id="sin_prod_cgst_price<?php echo $t; ?>" /></td><td width="8%" align="center"><input type="text" name="sin_product_sgst<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" id="sin_product_sgst<?php echo $t; ?>" style=" width:60px"><input type="hidden" name="sin_prod_sgst_price<?php echo $t; ?>" id="sin_prod_sgst_price<?php echo $t; ?>" /></td><td width="8%" align="center"><input type="text" name="sin_product_igst<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" id="sin_product_igst<?php echo $t; ?>" style=" width:60px"><input type="hidden" name="sin_prod_igst_price<?php echo $t; ?>" id="sin_prod_igst_price<?php echo $t; ?>" /></td><td width="14%" align="center"><input type="text" name="sales_product_price<?php echo $t; ?>" id="sales_product_price<?php echo $t; ?>" onkeyup="calc_product_price(<?php echo $t; ?>)" style="width:80px" /></td>
						<td valign="top" width="8%" align="center">
						<?php
						if($record_id)
						{
							?>
							<input type="hidden" name="total_sales_product[]" id="total_sales_product<?php echo $t; ?>" />
							<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['map_id'] ?>" />
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
				<input type="hidden" name="floor" id="floor" value="0" />
			<div id="create_floor"></div>
			</td>
		</tr>
		</table>
		<?php
		if($record_id)
		{
			?>
			<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
			<input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
			<?php 
		} 
		?> 
		</td>
		</tr>
	</table>
	</td>
	</tr>-->
	<tr>
		<td width="15%" class="tr-header" align="center">Amount</td>
		<td width="25%"><input type="text" name="amount_wo_tax" id="amount_wo_tax" onBlur="calculte_amount_tax('0')" style="width:200px" class="input_text" value="<?php if($_POST['amount_wo_tax']) echo $_POST['amount_wo_tax']; else echo $row_expense['amount_wo_tax']; ?>"  /></td>
	</tr>
	<tr>
		<td width="20%" valign="top" align="center">Discount <input type="radio" name="discount_type" onChange="calculte_total_cost()" id="discount_type" checked="checked" value="percentage" style="width:20px" <?php if($_POST['discount_type']=="percentage") {echo 'checked="checked"';}else if($row_expense['discount_type']=="percentage") { echo 'checked="checked"';} ?>  />in %
		<input type="radio" name="discount_type" id="discount_type" onChange="calculte_total_cost()" value="rupees" <?php if($_POST['discount_type']=="rupees") {echo 'checked="checked"';}else if($row_expense['discount_type']=="rupees") { echo 'checked="checked"';} ?> />in Rs -/ <span class="orange_font">*</span></td>
		<td width="70%"><input type="text"  class="input_text" style="width:200px" name="discount" id="discount" onKeyUp="calculte_total_cost()" value="<?php if($_POST['discount']) echo $_POST['discount']; else echo $row_expense['discount'];?>" /></td> 
		<td width="10%"></td>
	</tr>
	<tr>
		<td width="20%" valign="top" align="center">Discount Price</td>
		<td width="72%"><input type="text" class=" input_text" style="width:200px" name="discount_price" id="discount_price" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_expense['discount_price'];?>" /></td> 
		<td width="5%"></td>
	</tr>
	<tr>
		<td width="20%" valign="top" align="center">Total Price</td>
		<td width="70%"><input type="text"  class="input_text" name="total_price" id="total_price" style="width:200px" value="<?php if($_POST['total_price']) echo $_POST['total_price']; else echo $row_expense['total_price'];?>" /></td> 
		<td width="10%"></td>
	</tr>
 <!--===========================================================NEW TABLE 2 START===================================-->   
			<tr>
            	<td width="15%" align="center">Tax<span class="orange_font">*</span></td>
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
					</td></tr>
					<tr><td>  </td><td align="left"></td></tr>
                    </table> 
                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
					<tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
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
							$select_exc = "select * from expense_tax_map where expense_id='".$record_id."' order by expense_tax_map_id asc ";
                            $ptr_fs = mysql_query($select_exc);
                            $s=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs))
                            { 
                                $slab_id= $data_exclusive['expense_tax_map_id'];
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
									$cm_ids="and cm_id='".$row_expense['cm_id']."'";
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
                            		<input type="hidden" name="type1_id<?php echo $s; ?>" id="type1_id<?php echo $s; ?>" value="<?php echo $data_exclusive['expense_tax_map_id'] ?>" />
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
					}?> 
                    </td>
                    </tr>
                </table>
             </td>
         </tr>

       <!--============================================================END TABLE 2=========================================-->
<tr>
    <td width="15%" class="tr-header" align="center">Total Amount</td>
    <td width="25%"><input type="text" name="amount" id="amount" style="width:200px" class="input_text" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_expense['amount']; ?>"  /></td>
 </tr>
 <tr>
 <td width="15%" class="tr-header" align="center">Description</td>
 <td><textarea name="description" id="description" class="input_text"  style="width:300px;height:70px" ><?php if($_POST['description']) echo $_POST['description']; else echo $row_expense['description']; ?></textarea></td>
 </tr>
  <tr>
 <td width="15%" class="tr-header" align="center">Select Vendor</td>
 <td><select name="vendor" style="width:200px" class="input_text" id="vendor">
 <option value="select">--Select--</option>
 <?php
 $sle_bank_name="select vendor_id,name from vendor"; 
 $ptr_bank_name=mysql_query($sle_bank_name);
 while($data_bank=mysql_fetch_array($ptr_bank_name))
 {
	$selected='';
	if($data_bank['vendor_id'] == $row_expense['vendor_id'])
	{
		$selected='selected="selected"';
	}
	 echo '<option '.$selected.' value="'.$data_bank['vendor_id'].'">'.$data_bank['name'].'</option>';
 }
 ?>
 </select>
 </td>
 </tr>
 <tr>
 <td width="15%" class="tr-header"  align="center">Select Employee</td>
 <td><select name="employee" style="width:200px" class="input_text" id="employee">
 <option value="select">--Select--</option>
 <?php
 $sle_name="select admin_id,name from site_setting"; 
 $ptr_name=mysql_query($sle_name);
 while($data_name=mysql_fetch_array($ptr_name))
 {
	$selected='';
	if($data_name['admin_id'] == $row_expense['employee_id'])
	{
		$selected='selected="selected"';
	}
	 echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
 }
 ?>
 </select>
 </td>
 <td width="25%"></td>
 </tr>
 <tr>
 <?php
$select_amnt1="select SUM(amount) as total from receipt order by receipt_id desc limit 0,1";
$ptr_amt1=mysql_query($select_amnt1);
$total_amount1=0;
if(mysql_num_rows($ptr_amt1))
{
	$data_amnt1=mysql_fetch_array($ptr_amt1);
	$total_amount1=$data_amnt1['total'];
}
 ?>
    <td align="center" colspan="2"><input type="submit" class="input_button" onclick="return validme()" name="save_changes" value="Save"  /></td>
 </tr>
</table>
</form>
<?php
	//}
?>
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="14">
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
								$cm_id_filter=" || cm_id = '".$data_branch['cm_id']."'";
							} 
							
							$pay_mode_filter='';
							$sel_pay_id="select payment_mode_id from payment_mode where payment_mode like '%".$keyword."%' "; 
							$ptr_pay_id=mysql_query($sel_pay_id);    
							if(mysql_num_rows($ptr_pay_id)) 
							{
								$data_pay_id=mysql_fetch_array($ptr_pay_id);
								$pay_mode_filter="|| payment_mode_id = '".$data_pay_id['payment_mode_id']."'";
							} 
							
							$expense_type_filter='';
							$sel_exp_id="select expense_type_id from expense_type where expense_type like '%".$keyword."%' "; 
							$ptr_exp_id=mysql_query($sel_exp_id);    
							if(mysql_num_rows($ptr_exp_id)) 
							{
								$data_exp_id=mysql_fetch_array($ptr_exp_id);
								$expense_type_filter="|| expense_type_id = '".$data_exp_id['expense_type_id']."'";
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
							
							$added_by='';
							$sel_enq="select admin_id from site_setting where name like '%".$keyword."%'";
							$ptr_enq=mysql_query($sel_enq);
							if(mysql_num_rows($ptr_enq))
							{
								$data_enq=mysql_fetch_array($ptr_enq);
								$added_by="|| employee_id = '".$data_enq['admin_id']."'";
							}
							
							$vendor_name_filter='';
							$sel_vendor="select vendor_id from vendor where name like '%".$keyword."%'";
							$ptr_vendor=mysql_query($sel_vendor);
							if(mysql_num_rows($ptr_vendor))
							{
								while($data_vendor=mysql_fetch_array($ptr_vendor))
								{
									"<br/>".$vendor_name_filter .="|| vendor_id = '".$data_vendor['vendor_id']."'";
								}
							}
							
							$pre_keyword =" and ( added_Date like '%".$keyword."%' ".$pay_mode_filter." ".$cm_id_filter." ".$expense_type_filter." ".$bank_name_filter." ".$added_by." ".$vendor_name_filter." || chaque_no like '%".$keyword."%' || chaque_date like '%".$keyword."%'  || credit_card_no like '%".$keyword."%' || amount like '%".$keyword."%' || description like '%".$keyword."%' ".$added_by.")";
							 
							 
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

                        if($_GET['orderby']=='amount' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='expense_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by expense_id desc';  
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and expense_id='".$_GET['record_id']."' ";
							
						}                    
                          	$sql_query= "SELECT * FROM expense where 1 ".$record_cat_id." ".$_SESSION['where']." ".$pre_keyword." ".$from_date." ".$to_date." ".$select_directory." "; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
	<?php
	if($_SESSION['type']=='S')
	{?>
    <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
	<?php
	}
	?>
    <td width="5%" align="center"><strong>Sr. No.</strong></td>
	 <?php
	if($_SESSION['type']=="S")
	{
		?>
		<td width="8%" align="center"><strong>Branch Name</strong></td>
		<?php 
	} ?>
	<td width="8%" align="center"><strong>Expense Type</strong></td>
    <td width="8%"align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Payment Mode</strong></a> <?php echo $img1;?></td>
    
     <td width="12%" align="center"><strong>Bank Details</strong></td>
    <!-- <td width="10%"><strong>Credit Card No</strong></td>
     <td width="10%"><strong>Chaque No</strong></td>
    <td width="10%"><strong>chaque Date</strong></td>-->
    <td width="14%" align="center"><strong>Amount</strong></td>
     <td width="10%" align="center"><strong>Description</strong></td>
    <td width="10%"align="center"><strong>Vendor</strong></td>
     <td width="8%" align="center"><strong>Employee</strong></td>
    <td width="8%" align="center"><strong>Added date</strong></td>
	<?php
	if($_SESSION['type']=='S')
	{?>
		<td width="12%" class="centerAlign"><strong>Action</strong></td>
	<?php } ?>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['expense_id']; 
                                
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
								
								$sel_vendor="select name from vendor where vendor_id='".$val_query['vendor_id']."'";
								$ptr_vendor=mysql_query($sel_vendor);
								$data_vendor=mysql_fetch_array($ptr_vendor);
								
								$sel_emp="select name from site_setting where admin_id='".$val_query['employee_id']."'";
								$ptr_emp=mysql_query($sel_emp);
								$data_emp=mysql_fetch_array($ptr_emp);
								
								$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								
                                echo '<tr '.$bgcolor.' >';
								
								if($_SESSION['type']=='S')
								{
                                      echo '<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';  
								if($_SESSION['type']=="S")
								{
									echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								}
								echo '<td >'.$data_expense_type['expense_type'].'</td>';
								if($_SESSION['type']=='S')
								{
									echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" class="table_font">'.$data_payment_mode['payment_mode'].'</a></td>';
								}
								else
									echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
								
								
                                echo '<td align="center">';
								if($data_payment_mode['payment_mode']!="cash")
								{
									echo 'Bank Name- '.$data_bank_name['bank_name'].' <br/>Credit Card No.- '.$val_query['credit_card_no'].'<br/>Chaque No.- '.$val_query['chaque_no'].' <br/>Chaque Date- '.$val_query['chaque_date'];
								}
								else
									echo "-----";
								echo'</td>';
								echo '<td align="center"><span style="float:left">Amount(w/o tax) -</span><span style="float:right">'.$val_query['amount_wo_tax'].'</span><br/>';
								if($val_query['discount_type']=="rupees")
									$dis_type=" Rs/-";
								else if($val_query['discount_type']=="percentage")
									$dis_type=" %";
								echo '<b><span style="float:left">Discount ('.$val_query['discount'].''.$dis_type.') -</span><span style="float:right">'.round($val_query['discount_price']).'</span></b>';
								echo '<b><span style="float:left">Discounted price -</span><span style="float:right">'.round($val_query['total_price']).'</span></b>';
								$sele_tax="select tax_type,tax_value,tax_amount from expense_tax_map where expense_id ='".$listed_record_id."'";
								$ptr_tax=mysql_query($sele_tax);
								if(mysql_num_rows($ptr_tax))
								{
									while($data_tax=mysql_fetch_array($ptr_tax))
									{
										echo '<span style="float:left">'.$data_tax['tax_type'].'('.$data_tax['tax_value'].'%) -</span><span style="float:right">'.round($data_tax['tax_amount']).'</span><br/>';
									}
									echo '<hr/ style="color:gray">';
									
								}
								echo '<b><span style="float:left">Total Amount -</span><span style="float:right">'.round($val_query['amount']).'</span></b>';
								echo'</td>';
								echo '<td align="center">'.$val_query['description'].'</td>';
								echo '<td align="center">'.$data_vendor['name'].'</td>';
								echo '<td align="center">'.$data_emp['name'].'</td>';
								echo '<td align="center">'.$val_query['added_Date'].'</td>';
								if($_SESSION['type']=='S')
								{
                                echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';
								}
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="15">
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
/*if($_SESSION['type']=="S" && $record_id=='')
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}*/
/*if($record_id || $_SESSION['type']=="S")
{
	?>
    <script>
	if(document.getElementById("payment_mode"))
	{
	vals= document.getElementById("payment_mode").value;
	payment(vals);
	}
	branch_name=document.getElementById("branch_name").value;
	show_bank(branch_name);
	</script>
	<?php
}
*/
?>
<script>
if(document.getElementById("payment_mode"))
{
	vals= document.getElementById("payment_mode").value;
	payment(vals);
}
//branch_name=document.getElementById("branch_name").value;
//show_bank(branch_name);
</script>
<?php

if($record_id)
{
	?>
	<script>
	show_category(<?php echo $row_expense['expense_category_id'] ?>)
	</script>
    <?php
}
?>
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
	document.getElementById('amount_wo_tax').value=contact;
	
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
	
	document.getElementById('total_price').value=total_discount_price;
	document.getElementById('amount').value=total_discount_price;
	//calculte_amount_tax();
	
	/*document.getElementById('total_price').value=contact;
	document.getElementById('amount').value=contact;*/
	//document.getElementById('remaining_amount').value=total_discount_price;
	calculte_amount_tax();
}
function getDiscount(idss)
{
	disc_type='';
	frm = document.jqueryForm;  
	disc_type =frm.discount1.value;
	//alert(idss);
	product_price=parseFloat(document.getElementById("prod_price"+idss).value).toFixed(2);
	disc=parseFloat(document.getElementById("product_disc"+idss).value).toFixed(2);
	//alert(disc)
	
	sin_product_qty=parseFloat(document.getElementById("product_qty"+idss).value).toFixed(2);
	//alert(sin_product_qty)
	if(sin_product_qty!='0')
	{
		 total_price_qty=parseFloat(product_price * sin_product_qty).toFixed(2);
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
		total_price=parseFloat(total_price_qty-disc).toFixed(2);
		discount_price=parseFloat(disc).toFixed(2);
	}
	else
	{
		discount= parseFloat((total_price_qty*disc)/100);
		total_price=parseFloat(total_price_qty-discount).toFixed(2);
		discount_price=parseFloat(discount).toFixed(2);
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
	var total_prods_price=document.getElementById("amount_wo_tax").value;
	
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
		var total_cost_new= parseFloat(total_prods_price - discount_price).toFixed(2);
		document.getElementById('discount_price').value=discount_price;
	}
	else
	{
		var total_cost_new=total_prods_price;
		document.getElementById('discount_price').value=discount_price;
	}
			 
	//var discount=document.getElementById("discount").value;
	//alert(discount)
	//var total=isNaN(parseFloat(product_price * (discount / 100))) ? 0 :parseFloat((product_price * (discount / 100)))
	//alert(total_cost)
	// var total_cost_new=isNaN(parseFloat(product_price - total)) ? 0 :parseFloat(product_price - total)
	//alert(total_cost_new)
	$('#total_price').val(total_cost_new);
	//$('#remaining_amount').val(total_cost_new);
	calculte_amount_tax();
}
</script>
<script>
function reset_price(prd_id)
{
	document.getElementById("prod_price"+prd_id).value=0;
	document.getElementById("prod_base_price"+prd_id).value=0;
	document.getElementById("product_disc"+prd_id).value=0;
	document.getElementById("sin_product_cgst"+prd_id).value=0;
	document.getElementById("sin_product_sgst"+prd_id).value=0;
	document.getElementById("sin_product_igst"+prd_id).value=0;
	setTimeout(calc_product_price(prd_id),500);
	//alert(base_price);
	base_price=document.getElementById("base_price"+prd_id).value;
	if(base_price=="1")
	{
		//base_price=0;
		document.getElementById("base_price"+prd_id).value=0;
		document.getElementById("prod_base_price"+prd_id).style.backgroundColor="#cccc";
		document.getElementById("prod_price"+prd_id).style.backgroundColor="white";
		document.getElementById("prod_price"+prd_id).readOnly = false;
		document.getElementById("prod_base_price"+prd_id).readOnly = true;
	}
	else if(base_price=="0")
	{
		//base_price=1;
		document.getElementById("base_price"+prd_id).value=1;
		document.getElementById("prod_price"+prd_id).style.backgroundColor="#cccc";
		document.getElementById("prod_base_price"+prd_id).style.backgroundColor="white";
		document.getElementById("prod_price"+prd_id).readOnly = true;
		document.getElementById("prod_base_price"+prd_id).readOnly = false;
	}
	else
	{
		//base_price=1;
		document.getElementById("base_price"+prd_id).value=1;
	}
}
</script>
<script language="javascript">
create_floor('add');
<?php 
if($record_id=='')
{
	?>
	
	<?php
}
?>
</script>
</body>
</html>
