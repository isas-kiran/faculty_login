<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
$host = "localhost";
$dbuid = "isasadmin";
$dbpwd = "isasadmin007";
$dbname = "isasbeautyschool_org";

$link1 = mysql_connect($host ,$dbuid, $dbpwd);
mysql_select_db($dbname,$link1);
// Check for connection
if($link1 == true) {
    //echo "database1 Connected Successfully";
}
else {
    die("ERROR: Could not connect 1" . mysql_error());
}
//==================ISAS LLP========================
$host1 = "localhost";
$dbuid1	= "isasllp";
$dbpwd1 = "isasllp!@!2021";
$dbname1 = "isas.llp";

$link2 = mysql_connect($host1 ,$dbuid1, $dbpwd1);
mysql_select_db($dbname1,$link2);
// Check for connection
if($link2 == true) {
    //echo "database1 Connected Successfully";
}
else {
    die("ERROR: Could not connect 2 " . mysql_error());
}
//==================================================
//==================ISAS Dubai========================
$host2="localhost";
$dbuid2="isas_dubai";
$dbpwd2="isas_dubai@007";
$dbname2="isas_dubai";

$link3 = mysql_connect($host2 ,$dbuid2, $dbpwd2);
mysql_select_db($dbname2,$link3);
// Check for connection
if($link3 == true) {
    //echo "database1 Connected Successfully";
}
else {
    die("ERROR: Could not connect 3 " . mysql_error());
}
//==================================================
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM sales_product where sales_product_id='".$record_id."'";
	$ptr_sql_rec=mysql_query($sql_record,$link1);
    if(mysql_num_rows($ptr_sql_rec))
	{
        $row_record=mysql_fetch_array($ptr_sql_rec);
	}
    else
        $record_id=0;
		
	$sel_map="SELECT disc_type  FROM sales_product_map where sales_product_id='".$record_id."' order by sales_product_id asc limit 0,1";
	$ptr_map=mysql_query($sel_map,$link1);
	$data_map=mysql_fetch_array($ptr_map);
	
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1,$link1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no from bank where bank_id='".$row_record['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no,$link1);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='138'";
$ptr_access=mysql_query($sel_acc,$link1);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
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
    
	<!-- <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
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
		<?php
		if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
		{?>
			$("#branch_name").chosen({allow_single_deselect:true});
			//$("#user").chosen({allow_single_deselect:true});
			$("#realtxt").chosen({allow_single_deselect:true});
			$("#customer_id").chosen({allow_single_deselect:true});
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
    
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
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
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"cheque")
	}
	else if(payment_mode[0]=="Credit Card")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'block';
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"credit_card")
		
	}
	else if(payment_mode[0]=="paytm")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"paytm")
	}
	else if(payment_mode[0]=="online")
	{
		document.getElementById("bank_ref_no").style.display = 'block';
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'block';
		document.getElementById("credit_details").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"online")
	}
	else if(payment_mode[0]=="cash")
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"")
	}
	else
	{
		document.getElementById("chaque_details").style.display = 'none';
		document.getElementById("bank_details").style.display = 'none';
		document.getElementById("credit_details").style.display = 'none';
		document.getElementById("bank_ref_no").style.display = 'none';
		show_bank_for_payment_mode(branch_name,"")
	}
}

function show_data(id)
{
	//alert(bank_id);
	var branch_name=document.getElementById("branch_name").value;
	var record_id= document.getElementById('record_id').value;
	var data1="action=show_data&action_page=sales_product&id="+id+'&record_id='+record_id+'&branch_name='+branch_name;
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

function show_product_qty(product_id,id)
{
	show_product_desc(id);
	//alert(product_id);
	var prod_data="action=show_product_estimation&product_id="+product_id;
	$.ajax({
		url:"ajax.php",type:"post",timeout: 5000,data:prod_data,cache:false,
		success: function(prod_data)
		{
			prod_qty=prod_data.split("-");
			//alert(prod_data);
			if(prod_qty[0].trim() !='' && prod_qty[1].trim()!='')
			{
				prod_data=prod_qty[0].trim();
				product_price=prod_qty[1].trim();
				product_cgst=prod_qty[2].trim();
				product_sgst=prod_qty[3].trim();
				product_igst=prod_qty[4].trim();
				product_servicetax=prod_qty[5].trim();
			}
			else
			{
				prod_data=0
				product_price=0;
				product_cgst=0;
				product_sgst=0;
				product_igst=0;
				product_servicetax=0;
			}
			
			//base_price=0;
			document.getElementById("base_price"+id).value=0;
			
			if(product_cgst > 0 || product_sgst > 0)
			{
				//base_price=1;
				document.getElementById("base_price"+id).value=1;
				document.getElementById("prod_base_price"+id).value=product_price;
				document.getElementById("prod_price"+id).value=0;
				document.getElementById("prod_price"+id).style.backgroundColor="#cccc";
				document.getElementById("prod_base_price"+id).style.backgroundColor="white";
				document.getElementById("prod_price"+id).readOnly = true;
				document.getElementById("prod_base_price"+id).readOnly = false;
			}
			else
			{
				//base_price=0;
				document.getElementById("base_price"+id).value=0;
				document.getElementById("prod_base_price"+id).value=0;
				document.getElementById("prod_price"+id).value=product_price;
				document.getElementById("mrp_price"+id).value=product_price;
				document.getElementById("prod_base_price"+id).style.backgroundColor="#cccc";
				document.getElementById("prod_price"+id).style.backgroundColor="white";
				document.getElementById("prod_price"+id).readOnly = false;
				document.getElementById("prod_base_price"+id).readOnly = true;			
			}
			//document.getElementById("prod_price"+id).value=product_price;
			document.getElementById("product_total_qty"+id).readOnly = true;
			document.getElementById("product_total_qty"+id).style.backgroundColor="#cccc";
			
			document.getElementById("sales_product_price"+id).value=product_price;
			document.getElementById("product_total_qty"+id).value=prod_data;
			var exit_disc=document.getElementById("product_disc"+id).value = 0;
			if(product_cgst > 0 || product_sgst > 0)
			{
				var exit_cgst=document.getElementById("sin_product_cgst"+id).value = product_cgst;
				var exit_sgst=document.getElementById("sin_product_sgst"+id).value = product_sgst;
			}
			else if(product_igst > 0 )
			{
				var exit_igst=document.getElementById("sin_product_igst"+id).value = product_igst;
			}
			else if(product_servicetax > 0 )
			{
				var exit_igst=document.getElementById("sin_product_vat"+id).value = product_servicetax;	
			}
			
			var exit_servicetax=document.getElementById("product_qty"+id).value = 1;
			
			<?php
			if($record_id=='') { ?>
					var exit_main_discount=document.getElementById("discount").value=0;
					
					var exit_payable_amt=document.getElementById("payable_amount").value=0;
				<?php } ?>
			setTimeout(calc_product_price(id),500);
			setTimeout(showUser,1000);
		}
		});
		
		/*setTimeout(getDiscount(id),600);
		setTimeout(calculte_total_cost,800);
		setTimeout(cal_remaining_amt,900);*/
}
function show_product(ids)
{
	product_id=document.getElementById("product_id"+ids).value;
	//alert(product_id)
	var data1="product_id="+product_id;
	$.ajax({
		url: "get-product_qty.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
				
			var new_values= document.getElementById('unit'+ids).value=html;
			var fields = new_values.split(/-/);
			var unit11 = fields[0];
			var sep_field= unit11.split(" ");
			var unit1=sep_field[0];
			var measure=sep_field[1];
			
			var quantity = fields[1];
		
			var quantity_new = quantity /*- quantity_minus*/;
			
			//alert(quantity_new);
			$("#unit"+ids).val(unit1);
			$("#unit_val"+ids).html(unit1);
			$("#measure"+ids).html(measure);
			$("#measure_unit"+ids).val(measure);
			//$("#quantity").val(quantity_new);
			var prod_desc=fields[2];
			var details = prod_desc.split(/#/);
			var price= details[0];
			$("#price"+ids).html(price);
			var brand= details[1];
			var description= details[2];
			document.getElementById("product_details"+ids).style.display="block";
			$("#brand"+ids).html(brand);
			$("#description"+ids).html(description);
				//alert(quantity)
				
			if(document.getElementById("select_from"))
			{
				values=document.getElementById("select_from").value;
				show_product_qty(values)
			}
		}
	});
}
function show_product_qty(id)
{
	var type=document.getElementById("select_from"+id).value;
	//alert(type)
	if(type=="stock")
	{
		var product_id= document.getElementById("product_id"+id).value;	
		var data="product_id="+product_id+"&type="+type+"&id="+id;
		//alert(data)	
		$.ajax({
            url: "get_product_from_stock.php", type: "post", data: data, cache: false,
            success: function (html)
			{
				//alert(html)
				sep=html.split("###");
				
				$("#quantity"+id).val(sep[0]);
				document.getElementById("select_to_div"+id).innerHTML=sep[1];
			}
		});
	}
	else
	{
		var product_id= document.getElementById("product_id"+id).value;	
		var data="product_id="+product_id+"&type="+type+"&id="+id;	
		$.ajax({
			
            url: "get_product_from_shelf_cons.php", type: "post", data: data, cache: false,
            success: function (html)
			{
				sep=html.split("###");
				$("#quantity"+id).val(sep[0]);
				
				document.getElementById("select_to_div"+id).innerHTML=sep[1];
			}
		});
	}
}
function check_quantity(qty_id)
{
	store_qty=document.getElementById("quantity"+qty_id).value;
	issue_qty=document.getElementById("issue_qty"+qty_id).value;
	//alert(store_qty)
	//alert(issue_qty)
	if(Number(issue_qty) > Number(store_qty) )
	{
		alert("Issue Quantity is not greater than store quantity");
		document.getElementById("issue_qty"+qty_id).value=0;
	}
}

function show_bank(branch_id,vals)
{
	//alert(branch_id);
	//record_id= document.getElementById("record_id").value;
	/*var bank_data="action=service&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
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
	});*/
	document.getElementById("show_type").innerHTML='';
	document.getElementById("stockiest").innerHTML='';
	document.getElementById('user').getElementsByTagName('option')[0].selected = 'selected'


	setTimeout(get_product_list(branch_id),300);

}
function get_product_list(branch_name)
{
	var record_id= document.getElementById("record_id").value;
	var total_product= document.getElementsByName("total_product[]");
	var totals=total_product.length;
	branch_name=document.getElementById('branch_name').value;
	var data1="action=get_checkout_product&branch_name="+branch_name+"&totals="+totals;
	$.ajax({
		url: "get_product_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			document.getElementById("create_floor").innerHTML='';
			//document.getElementById("create_type1").innerHTML='';
			document.getElementById("res1").value=html;
		}
	});
	
	var data1="action=get_emp_checkouts&branch_id="+branch_name;
	$.ajax({
		url: "show_councellor.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//document.getElementById("create_floor").innerHTML='';
			//document.getElementById("create_type1").innerHTML='';
			document.getElementById("res2").value=html;
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
function precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
}

</script>
<script>
function selectalls() 
{
	if($("#selectall").attr("checked")==true){
	$('.case').each(function() {
	$(this).attr('checked','checked');
	showservice();
	});
}
else
{
	$('.case').each(function() {
	$(this).attr('checked','');
	showservice();
	});
	}
}
function showservice()
{
	total_service =  document.getElementById("total_service").value;
	contact ='';
	for(i=1; i<=total_service;i++)
	{
		id="requirment_id"+i;
		if(document.getElementById(id).checked)
		{
				contact +=document.getElementById(id).value;
				contact +=',';
		}
 	}
}
function add_new_student(student)
{
	var a=student;
	if(a=='custom_student')
	{
	  document.getElementById('add_student').style.display='block';
	}
	else
	{
		document.getElementById('add_student').style.display='none';
	}
}
</script>
<script>
mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='134' ".$_SESSION['where']."";
$ptr_sel_sms=mysql_query($sel_sms_cnt);
$tot_num_rows=mysql_num_rows($ptr_sel_sms);
$i=0;
while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
{
	$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
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
	$sel_act="select contact_phone,email from site_setting where type='S'";
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
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='134'";
$ptr_mail_text=mysql_query($sel_mail_text);
if($tot_mail_text=mysql_num_rows($ptr_mail_text))
{
	$data_mail_text=mysql_fetch_array($ptr_mail_text);
	?>
	email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
	<?php
}
?>
function send(ids)
{	
	var checkout_product_id=ids;
	var users_mail=mail1;
	data1='action=add_checkout&checkout_product_id='+checkout_product_id+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
	//alert(data1);
	$.ajax({
		url:'send_email.php',type:"post",data:data1,cache:false,crossDomain:true, async:false,
		success: function(response) {
		//alert(response);
		return true;
	}
	});
}
</script>
<script>
function show_mobile_no(cust_ids,type)
{
	var data2="customer_id="+cust_ids+"&type="+type;
	//alert(data2);
	 $.ajax({
	url: "get_mail.php", type: "post", data: data2, cache: false,
	success: function (html)
	{
		if(html.trim()!='')
		{
			sep=html.split("###");
			
			var mail= sep[0].trim();
			document.getElementById('mail').value=mail;
			//document.getElementById('billing_address').value=sep[1].trim();
			//document.getElementById('delivery_address').value=sep[2].trim();
		}
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
	else if(cust_ids == '18')
	{
		var data2="action_for=Ahmedabad&customer_id="+cust_ids;
		//alert(data2);
		 $.ajax({
		url: "get_stockist.php", type: "post", data: data2, cache: false,
		success: function (html)
		{
			//alert(html);
			document.getElementById('stockiest').innerHTML=html;
		}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids == '1113')
	{
		var data2="action_for=ISAS PCMC&customer_id="+cust_ids;
		//alert(data2);
		 $.ajax({
		url: "get_stockist.php", type: "post", data: data2, cache: false,
		success: function (html)
		{
			document.getElementById('stockiest').innerHTML=html;
			$("#stockist_id").chosen({allow_single_deselect:true});
		}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids == '1212')
	{
		var data2="action_for=Ahmednagar&customer_id="+cust_ids;
		//alert(data2);
		 $.ajax({
		url: "get_stockist.php", type: "post", data: data2, cache: false,
		success: function (html)
		{
			document.getElementById('stockiest').innerHTML=html;
			$("#stockist_id").chosen({allow_single_deselect:true});
		}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids == '1805')
	{
		var data2="action_for=Pune&customer_id="+cust_ids;
		//alert(data2);
		 $.ajax({
		url: "get_stockist.php", type: "post", data: data2, cache: false,
		success: function (html)
		{
			document.getElementById('stockiest').innerHTML=html;
			$("#stockist_id").chosen({allow_single_deselect:true});
		}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids == '2915')
	{
		var data2="action_for=ISAS Singhgad Road&customer_id="+cust_ids;
		//alert(data2);
		 $.ajax({
		url: "get_stockist.php", type: "post", data: data2, cache: false,
		success: function (html)
		{
			document.getElementById('stockiest').innerHTML=html;
			$("#stockist_id").chosen({allow_single_deselect:true});
		}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids=='4199')
	{
		var data2="action_for=Pune LLP&customer_id="+cust_ids;
		$.ajax({
			url: "get_stockist_llp.php", type: "post", data: data2, cache: false,
			success: function (html)
			{
				document.getElementById('stockiest').innerHTML=html;
				$("#stockist_id").chosen({allow_single_deselect:true});
			}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids=='4322')
	{
		var data2="action_for=Surat&customer_id="+cust_ids;
		$.ajax({
			url: "get_stockist_llp.php", type: "post", data: data2, cache: false,
			success: function (html)
			{
				document.getElementById('stockiest').innerHTML=html;
				$("#stockist_id").chosen({allow_single_deselect:true});
			}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids=='4206')
	{
		var data2="action_for=Nagpur&customer_id="+cust_ids;
		$.ajax({
			url: "get_stockist_llp.php", type: "post", data: data2, cache: false,
			success: function (html)
			{
				document.getElementById('stockiest').innerHTML=html;
				$("#stockist_id").chosen({allow_single_deselect:true});
			}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids=='4321')
	{
		var data2="action_for=Vashi&customer_id="+cust_ids;
		$.ajax({
			url: "get_stockist_llp.php", type: "post", data: data2, cache: false,
			success: function (html)
			{
				document.getElementById('stockiest').innerHTML=html;
				$("#stockist_id").chosen({allow_single_deselect:true});
			}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids=='4323')
	{
		var data2="action_for=Vadodara&customer_id="+cust_ids;
		$.ajax({
			url: "get_stockist_llp.php", type: "post", data: data2, cache: false,
			success: function (html)
			{
				document.getElementById('stockiest').innerHTML=html;
				$("#stockist_id").chosen({allow_single_deselect:true});
			}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
	else if(cust_ids=='4324')
	{
		var data2="action_for=Indore&customer_id="+cust_ids;
		$.ajax({
			url: "get_stockist_llp.php", type: "post", data: data2, cache: false,
			success: function (html)
			{
				document.getElementById('stockiest').innerHTML=html;
				$("#stockist_id").chosen({allow_single_deselect:true});
			}
		});
		$("#stockist_id").chosen({allow_single_deselect:true});
	}
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
			$added_date=date('Y-m-d');
			$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
			$customer_id=( ($_POST['customer_id'])) ? $_POST['customer_id'] : "0";
			$type=$_POST['user'] ? $_POST['user'] : "";
			$stockist_id=$_POST['stockist_id'] ? $_POST['stockist_id'] : "";
			
			
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
			{
				$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
				$ptr_branch=mysql_query($sel_branch,$link1);
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id=$data_branch['cm_id'];
				$branch_name1=$branch_name;
				$data_record['cm_id']=$cm_id;
				$cm_id1=$cm_id;
			}	
			else
			{
				$data_record['cm_id']=$_SESSION['cm_id'];
				$branch_name=$_SESSION['branch_name'];
				$branch_name1=$_SESSION['branch_name'];
				$data_record['cm_id']=$_SESSION['cm_id'];
				$cm_id1=$_SESSION['cm_id'];
				$cm_id=$_SESSION['cm_id'];;
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
				$total_floor=$_POST['floor'];
				
				if($record_id)
				{
					//$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('sales_product','Edit','sale product','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					//$query=mysql_query($insert,$link1);
				}
				else
				{
					$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$_SESSION['admin_id']."','".$cm_id."')";
					$ptr_values=mysql_query($insert_checkout,$link1);
					$record_ids=mysql_insert_id($link1);
					for($i=1;$i<=$total_floor;$i++)
					{
						if($_POST['product_id'.$i]!='')
						{
							$quantity=$_POST['quantity'.$i];
							$issue_qty=$_POST['issue_qty'.$i];
							
							$data_record_check_prod['checkout_id'] =$record_ids;
							$data_record_check_prod['product_id'] =$_POST['product_id'.$i];
							$data_record_check_prod['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
							$data_record_check_prod['issue_qty'] =$_POST['issue_qty'.$i];
							$data_record_check_prod['type']=$_POST['type'.$i];
							$data_record_check_prod['select_from'] =$_POST['select_from'.$i];
							$data_record_check_prod['quantity'] =$quantity - $issue_qty;
							$data_record_check_prod['user_type'] =$type;
							$data_record_check_prod['employee_id'] =$customer_id;
							$data_record_check_prod['added_date']=date('Y-m-d');
							$prod_desc=$_POST['prod_desc'.$i];
							
							$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`, `issue_qty`, `issue_unit`,`select_from`,`type`,`quantity`,`user_type`,`employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$_POST['product_id'.$i]."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod['issue_qty']."','".$data_record_check_prod['type']."','".$data_record_check_prod['select_from']."','".$data_record_check_prod['type']."','".$data_record_check_prod['quantity']."','".$data_record_check_prod['user_type']."','".$data_record_check_prod['employee_id']."','".$cm_id."','".$added_date."')";
							$ptr_checkout_date=mysql_query($ins_checkout_data,$link1);
							
							//$checkout_prod_map_id=$db->query_insert("checkout_product_map", $data_record_check_prod);
							
							//>>>>>>>>>>>>>>>>>>>>>>>>>>> DELETE  <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<	
							/*if($data_record_check_prod['type']=="consumable")
							{
								$select_qty="select consumption_id,quantity,unit from consumption where product_id='".$data_record_check_prod['product_id']."' and employee_id='".$data_record_check_prod['employee_id']."'";
								$ptr_qty=mysql_query($select_qty);
								if(mysql_num_rows($ptr_qty))
								{
									$data_qty=mysql_fetch_array($ptr_qty);
									"<br/>".$update_qty="update consumption set quantity=quantity+".$data_record_check_prod['issue_qty'].",unit=unit+".$data_record_check_prod['unit']." where product_id='".$data_record_check_prod['product_id']."' and employee_id='".$data_record_check_prod['employee_id']."'";
									$ptr_qty=mysql_query($update_qty);
									if($prod_desc =='')
									$prod_desc='Adding '.$data_record_check_prod['issue_qty'].' quantity and '.$data_record_check_prod['unit'].' unit in this product';
									
								}
							}
							if($data_record_check_prod['select_from']=="consumable")
							{
								$select_qty="select consumption_id,quantity,unit from consumption where product_id='".$data_record_check_prod['product_id']."' and employee_id='".$data_record_check_prod['employee_id']."'";
								$ptr_qty=mysql_query($select_qty);
								if(mysql_num_rows($ptr_qty))
								{
									$data_qty=mysql_fetch_array($ptr_qty);
									$update_qty="update consumption set quantity=quantity-".$data_record_check_prod['issue_qty']." where product_id='".$data_record_check_prod['product_id']."' and employee_id='".$data_record_check_prod['employee_id']."'";
									$ptr_qty=mysql_query($update_qty);
									
									if($prod_desc =='')
									$prod_desc='release '.$data_record_check_prod['issue_qty'].' quantity and '.$data_record_check_prod['unit'].' unit in this product';
								}
							}*/
							//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
							$select_from=$_POST['select_from'.$i];
							//============================ FROM STOCK ===============================
							if($data_record_check_prod['select_from']=="stock")
							{
								$update_prod_qty="update product set quantity=(quantity - ".$issue_qty.") where product_id='".$_POST['product_id'.$i]."'";
								$query_prod_qty=mysql_query($update_prod_qty,$link1); 
								
								$sel_stockiest="select admin_id from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_stock=mysql_query($sel_stockiest,$link1);
								$data_stock=mysql_fetch_array($ptr_stock);
								
								$ins_data="INSERT INTO `product_daily_report`(`product_id`, `cm_id`, `stockiest_id`, `type`, `purchase_qty`, `sales_qty`, `checkout_qty`, `vendor_id`, `cust_type`, `cust_id`, `todays_qty`,`todays_shelf_qty`,`todays_consumable_qty`, `description`,`admin_id`,`added_date`) VALUES ('".$_POST['product_id'.$i]."','".$cm_id."','".$data_stock['admin_id']."','checkout','0','0','".$issue_qty."','0','staff','".$_POST['employee_id'.$i]."','todays_qty-".$data_prod['quantity']."','','','Checkout product quantity from stock  to other','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_ins=mysql_query($ins_data,$link1);
							}
							//========================= FROM SHELF =========================================
							else if($data_record_check_prod['select_from']=="shelf")
							{
								$upd_prod_qty="update product set quantity_in_shelf=(quantity_in_shelf - ".$issue_qty.") where product_id='".$_POST['product_id'.$i]."'";
								$query_prod_qty=mysql_query($upd_prod_qty,$link1);
							}
							//====================== FROM CONSUMABLE =====================================
							else if($data_record_check_prod['select_from']=="consumable")
							{
								$up_prod_qty="update product set quantity_in_consumable=(quantity_in_consumable - ".$issue_qty.") where product_id='".$_POST['product_id'.$i]."'";
								$query_prod_qty=mysql_query($up_prod_qty,$link1); 
							}
							//==================== USER PRODUCT QTY =========================
							$select_prod="select product_id,quantity from product_user_map where product_id='".$data_record_check_prod['product_id']."' and user_id ='".$data_record_check_prod['employee_id']."' and cm_id='".$cm_id."' ";
							$ptr_my=mysql_query($select_prod,$link1);
							if(mysql_num_rows($ptr_my))
							{
								$data_prod_id=mysql_fetch_array($ptr_my);
								$prod_id=$data_prod_id['product_id'];
								$prod_qty=$data_prod_id['quantity'];
								
								if($data_record_check_prod['type']=="stock")
								{
									$update_prod_qty="update product_user_map set quantity=(quantity + ".$issue_qty.") where product_id='".$prod_id."' and user_id='".$data_record_check_prod['employee_id']."' and cm_id='".$cm_id."' ";
								$query_prod_qty=mysql_query($update_prod_qty,$link1); 
								}
								//======================== TO SHELF ==========================================
								else if($data_record_check_prod['type']=="shelf")
								{
									$upd_prod_qty="update product_user_map set quantity_in_shelf=(quantity_in_shelf + ".$issue_qty.") where product_id='".$prod_id."' and user_id='".$data_record_check_prod['employee_id']."' and cm_id='".$cm_id."' ";
									$query_prod_qty=mysql_query($upd_prod_qty,$link1); 
								}
								//========================= TO CONSUMABLE ======================================
								else if($data_record_check_prod['type']=="consumable")
								{
									$up_prod_qty="update product_user_map set quantity_in_consumable=(quantity_in_consumable + ".$issue_qty.") where product_id='".$prod_id."' and user_id='".$data_record_check_prod['employee_id']."' and cm_id='".$cm_id."' ";
									$query_prod_qty=mysql_query($up_prod_qty,$link1); 
								}
							}
							else
							{
								$sel_prod=" select product_id,cm_id from product where product_id='".$data_record_check_prod['product_id']."'";
								$ptr_prod=mysql_query($sel_prod,$link1);
								if(mysql_num_rows($ptr_prod))
								{
									$data_prod=mysql_fetch_array($ptr_prod);
									if($data_record_check_prod['type']=="stock")
									{
										$ins_prod="INSERT INTO `product_user_map`(`product_id`, `user_id`,`quantity`,`quantity_in_shelf`,`quantity_in_consumable`,`admin_id`,`cm_id`) VALUES ('".$data_prod['product_id']."','".$data_record_check_prod['employee_id']."','".$issue_qty."','0','0','".$_SESSION['admin_id']."','".$data_prod['cm_id']."')";
										$query=mysql_query($ins_prod,$link1);
										
										$sel_stockiest="select admin_id from product where product_id='".$_POST['product_id'.$i]."' ";
										$ptr_stock=mysql_query($sel_stockiest,$link1);
										$data_stock=mysql_fetch_array($ptr_stock);
										$ins_data="INSERT INTO `product_daily_report`(`product_id`, `cm_id`, `stockiest_id`, `type`, `purchase_qty`, `sales_qty`, `checkout_qty`, `vendor_id`, `cust_type`, `cust_id`, `todays_qty`,`todays_shelf_qty`,`todays_consumable_qty`, `description`,`admin_id`,`added_date`) VALUES ('".$_POST['product_id'.$i]."','".$cm_id."','".$data_stock['admin_id']."','checkout','0','0','".$issue_qty."','0','staff','".$_POST['employee_id'.$i]."','todays_qty+".$data_prod['quantity']."','','','Checkout product quantity from other to stock','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
										$ptr_ins=mysql_query($ins_data,$link1);
									}
									//======================= TO SHELF =======================================
									else if($data_record_check_prod['type']=="shelf")
									{
										$ins_prod="INSERT INTO `product_user_map`(`product_id`, `user_id`,`quantity`,`quantity_in_shelf`,`quantity_in_consumable`,`admin_id`,`cm_id`) VALUES ('".$data_prod['product_id']."','".$data_record_check_prod['employee_id']."','0','".$issue_qty."','0','".$_SESSION['admin_id']."','".$data_prod['cm_id']."')";
										$query=mysql_query($ins_prod,$link1); 
									}
									//=========================== TO CONSUMABLE ===============================
									else if($data_record_check_prod['type']=="consumable")
									{
										$ins_prod="INSERT INTO `product_user_map`(`product_id`, `user_id`,`quantity`,`quantity_in_shelf`,`quantity_in_consumable`,`admin_id`,`cm_id`) VALUES ('".$data_prod['product_id']."','".$data_record_check_prod['employee_id']."','0','0','".$issue_qty."','".$_SESSION['admin_id']."','".$data_prod['cm_id']."')";
										$query=mysql_query($ins_prod,$link1); 
									}
								}
							}
						}
					}
					//======================================== AHMEDABAD ===========================================
					if($customer_id=="18")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="53"; // ISAS Pune
							$cm_ids="60";//ahmedabad
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link1);
						$record_ids=mysql_insert_id($link1);
						
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id, sub_id,size,unit, commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
																					
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and status='Active' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' "; //
									$ptr_sele_catte=mysql_query($sele_cate,$link1);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty'].") where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' "; //
										$query_update=mysql_query($update_products1,$link1);
									}
									else
									{
										//echo "<br/>hi..";
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link1);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link1);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link1);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link1);
											$cat_id=mysql_insert_id($link1);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link1);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link1);
											$sub_cat_id=mysql_insert_id($link1);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link1);
										$product_ids=mysql_insert_id($link1);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`, `issue_qty`, `issue_unit`,`select_from`,`type`,`quantity`,`user_type`,`employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link1);
								$customer_service_id=mysql_insert_id($link1);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link1);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//=======ISAS PCMC==========
					if($customer_id=="1113")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="53"; // ISAS Pune
							$cm_ids="115";
							$data_record_ahm['cm_id']=$cm_ids;
							
						}
						elseif($branch_name1=="Ahmedabad")
						{
							$data_record_ahm['vendor_id']="325";
							$cm_ids="115";
							$data_record_ahm['cm_id']=$cm_ids;
						}
					}
					
					//===========================================ISAS Ahmednagar======================================
					if($customer_id=="1212")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="53";
							$cm_ids="119";//Ahmednagar
							$data_record_ahm['cm_id']=$cm_ids;
							
						}
						else if($branch_name1=="Ahmednagar")
						{
							$data_record_ahm['vendor_id']="517";
							$cm_ids="2";//pune
							$data_record_ahm['cm_id']=$cm_ids;
						}
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link1);
						$record_ids=mysql_insert_id($link1);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id, sub_id,size,unit, commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
																					
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and status='Active' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' "; //
									$ptr_sele_catte=mysql_query($sele_cate,$link1);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty'].") where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' "; //
										$query_update=mysql_query($update_products1,$link1);
									}
									else
									{
										//echo "<br/>hi..";
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link1);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link1);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link1);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link1);
											$cat_id=mysql_insert_id($link1);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link1);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link1);
											$sub_cat_id=mysql_insert_id($link1);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link1);
										$product_ids=mysql_insert_id($link1);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`, `issue_qty`, `issue_unit`,`select_from`,`type`,`quantity`,`user_type`,`employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link1);
								$customer_service_id=mysql_insert_id($link1);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link1);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//===========================================ISAS Pune============================================
					if($customer_id=="1805")
					{
						if($branch_name1=="Ahmedabad")
						{
							$data_record_ahm['vendor_id']="325";
							$cm_ids="2";//ahmedabad
							$data_record_ahm['cm_id']=$cm_ids;
						}
						elseif($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="53";
							$cm_ids="60";//pune
							$data_record_ahm['cm_id']=$cm_ids;
						}
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link1);
						$record_ids=mysql_insert_id($link1);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id, sub_id,size,unit, commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
																					
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and status='Active' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' "; //
									$ptr_sele_catte=mysql_query($sele_cate,$link1);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty'].") where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' "; //
										$query_update=mysql_query($update_products1,$link1);
									}
									else
									{
										//echo "<br/>hi..";
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link1);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link1);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link1);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link1);
											$cat_id=mysql_insert_id($link1);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link1);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link1);
											$sub_cat_id=mysql_insert_id($link1);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link1);
										$product_ids=mysql_insert_id($link1);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`, `issue_qty`, `issue_unit`,`select_from`,`type`,`quantity`,`user_type`,`employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link1);
								$customer_service_id=mysql_insert_id($link1);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link1);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					
					//================================ ISAS LLP - PUNE ==========================================
					if($customer_id=="4199")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="108"; // ISAS Pune
							$cm_ids="2";//LLP Pune
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link2);
						$record_ids=mysql_insert_id($link2);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id,sub_id, size,unit,commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
									
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' ";
									$ptr_sele_catte=mysql_query($sele_cate,$link2);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty']."),status='Active' where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' ";
										$query_update=mysql_query($update_products1,$link2);
									}
									else
									{
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link2);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link2);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link2);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`, `admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link2);
											$cat_id=mysql_insert_id($link2);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link2);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link2);
											$sub_cat_id=mysql_insert_id($link2);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link2);
										$product_ids=mysql_insert_id($link2);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`,`issue_qty`,`issue_unit`,`select_from`,`type`,`quantity`,`user_type`, `employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link2);
								$customer_service_id=mysql_insert_id($link2);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link2);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//===================================END LLP PUNE ==========================================
					//================================ ISAS LLP - SURAT ==========================================
					if($customer_id=="4322")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="1571"; // ISAS Pune
							$cm_ids="3";//SURAT
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link2);
						$record_ids=mysql_insert_id($link2);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id,sub_id, size,unit,commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
									
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' ";
									$ptr_sele_catte=mysql_query($sele_cate,$link2);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty']."),status='Active' where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' ";
										$query_update=mysql_query($update_products1,$link2);
									}
									else
									{
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link2);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link2);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link2);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`, `admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link2);
											$cat_id=mysql_insert_id($link2);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link2);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link2);
											$sub_cat_id=mysql_insert_id($link2);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link2);
										$product_ids=mysql_insert_id($link2);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`,`issue_qty`,`issue_unit`,`select_from`,`type`,`quantity`,`user_type`, `employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link2);
								$customer_service_id=mysql_insert_id($link2);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link2);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//===================================END SURAT SALE ==========================================
					//================================ ISAS LLP - Vashi ==========================================
					if($customer_id=="4321")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="1569"; // ISAS Pune
							$cm_ids="4";//Vashi
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link2);
						$record_ids=mysql_insert_id($link2);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id,sub_id, size,unit,commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
									
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' ";
									$ptr_sele_catte=mysql_query($sele_cate,$link2);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty']."),status='Active' where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' ";
										$query_update=mysql_query($update_products1,$link2);
									}
									else
									{
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link2);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link2);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link2);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`, `admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link2);
											$cat_id=mysql_insert_id($link2);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link2);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link2);
											$sub_cat_id=mysql_insert_id($link2);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link2);
										$product_ids=mysql_insert_id($link2);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`,`issue_qty`,`issue_unit`,`select_from`,`type`,`quantity`,`user_type`, `employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link2);
								$customer_service_id=mysql_insert_id($link2);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link2);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//===================================END Vashi SALE ==========================================
					//================================ ISAS LLP - Indore ==========================================
					if($customer_id=="4324")
					{
						if($branch_name1=="Pune")	
						{
							$data_record_ahm['vendor_id']="1572"; // ISAS Pune
							$cm_ids="5";//Indore
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link2);
						$record_ids=mysql_insert_id($link2);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id,sub_id, size,unit,commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
									
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' ";
									$ptr_sele_catte=mysql_query($sele_cate,$link2);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty']."),status='Active' where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' ";
										$query_update=mysql_query($update_products1,$link2);
									}
									else
									{
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link2);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link2);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link2);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`, `admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link2);
											$cat_id=mysql_insert_id($link2);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link2);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link2);
											$sub_cat_id=mysql_insert_id($link2);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link2);
										$product_ids=mysql_insert_id($link2);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`,`issue_qty`,`issue_unit`,`select_from`,`type`,`quantity`,`user_type`, `employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link2);
								$customer_service_id=mysql_insert_id($link2);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link2);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//===================================END Indore SALE ==========================================
					//================================ ISAS LLP - Nagpur ==========================================
					if($customer_id=="4206")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="250"; // ISAS Pune
							$cm_ids="6";//Nagpur
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link2);
						$record_ids=mysql_insert_id($link2);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id,sub_id, size,unit,commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
									
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' ";
									$ptr_sele_catte=mysql_query($sele_cate,$link2);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty']."),status='Active' where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' ";
										$query_update=mysql_query($update_products1,$link2);
									}
									else
									{
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link2);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link2);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link2);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`, `admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link2);
											$cat_id=mysql_insert_id($link2);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link2);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link2);
											$sub_cat_id=mysql_insert_id($link2);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link2);
										$product_ids=mysql_insert_id($link2);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`,`issue_qty`,`issue_unit`,`select_from`,`type`,`quantity`,`user_type`, `employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link2);
								$customer_service_id=mysql_insert_id($link2);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link2);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//===================================END Nagpur SALE ==========================================
					//================================ ISAS LLP - Vadodara ==========================================
					if($customer_id=="4323")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="1573"; // ISAS Pune
							$cm_ids="7";//Vadodara
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$stockist_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link2);
						$record_ids=mysql_insert_id($link2);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link1);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id,sub_id, size,unit,commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link1);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
									
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' ";
									$ptr_sele_catte=mysql_query($sele_cate,$link2);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty']."),status='Active' where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' ";
										$query_update=mysql_query($update_products1,$link2);
									}
									else
									{
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link2);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link2);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link2);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`, `admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link2);
											$cat_id=mysql_insert_id($link2);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link2);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link2);
											$sub_cat_id=mysql_insert_id($link2);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link2);
										$product_ids=mysql_insert_id($link2);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`,`issue_qty`,`issue_unit`,`select_from`,`type`,`quantity`,`user_type`, `employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$data_record_check_prod_serv['product_id']."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link2);
								$customer_service_id=mysql_insert_id($link2);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link2);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}
					//===================================END Vadodara SALE ==========================================
					//================================ ISAS LLP - Bangalore ==========================================
					/*if($customer_id=="4379")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="1590"; // ISAS Pune
							$cm_ids="271";//Bangalore
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$customer_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link2);
						$record_ids=mysql_insert_id($link2);
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link2);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id, sub_id,size,unit, commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link2);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
																					
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and status='Active' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' "; //
									$ptr_sele_catte=mysql_query($sele_cate,$link2);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty'].") where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' "; //
										$query_update=mysql_query($update_products1,$link2);
									}
									else
									{
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link2);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link2);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link2);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link2);
											$cat_id=mysql_insert_id($link2);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link2);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link2);
											$sub_cat_id=mysql_insert_id($link2);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link2);
										$product_ids=mysql_insert_id($link2);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`, `issue_qty`, `issue_unit`,`select_from`,`type`,`quantity`,`user_type`,`employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$_POST['product_id'.$i]."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link2);
								$customer_service_id=mysql_insert_id($link2);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link2);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}*/
					//===================================END Bangalore SALE ==========================================
					//================================ ISAS - Dubai ==========================================
					/*if($customer_id=="4010")
					{
						if($branch_name1=="Pune")
						{
							$data_record_ahm['vendor_id']="22"; // ISAS Pune
							$cm_ids="3";//Dubai
							$data_record_ahm['cm_id']=$cm_ids;
						}
						
						$insert_checkout="insert into checkout(`added_date`,`admin_id`,`cm_id`) values('".$added_date."','".$customer_id."','".$data_record_ahm['cm_id']."')";
						$ptr_values=mysql_query($insert_checkout,$link3);
						$record_ids=mysql_insert_id($link3);
						
												
						for($i=1;$i<=$total_floor;$i++)
						{
							if(trim($_POST['product_id'.$i])>0)
							{
								$quantity=$_POST['quantity'.$i];
								$issue_qty=$_POST['issue_qty'.$i];
								
								$data_record_check_prod_serv['checkout_id']=$record_ids;
								$product_id=$data_record_check_prod_serv['product_id']=$_POST['product_id'.$i];
								$data_record_check_prod_serv['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
								$data_record_check_prod_serv['issue_qty'] =$_POST['issue_qty'.$i];
								$data_record_check_prod_serv['type']=$_POST['type'.$i];
								$data_record_check_prod_serv['select_from'] =$_POST['select_from'.$i];
								$data_record_check_prod_serv['quantity'] =$quantity - $issue_qty;
								$data_record_check_prod_serv['user_type'] ='Employee';
								$data_record_check_prod_serv['employee_id'] =$customer_id;
								$data_record_check_prod_serv['added_date']=date('Y-m-d');
								$prod_desc=$_POST['prod_desc'.$i];
								
								$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_ids."' and `type`='ST' and system_status='Enabled'";
								$ptr_admin_id=mysql_query($sel_admin_id,$link3);
								$data_cm_id=mysql_fetch_array($ptr_admin_id);
								
								$sel_product_name="select product_name,product_code,pcategory_id, sub_id,size,unit, commission,price,vender,type,added_date,cm_id, quantity,admin_id from product where product_id='".$product_id."' ";
								$ptr_names=mysql_query($sel_product_name,$link3);
								if(mysql_num_rows($ptr_names))
								{
									$data_product=mysql_fetch_array($ptr_names);
																					
									$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and status='Active' and admin_id='".$stockist_id."' and cm_id='".$cm_ids."' "; //
									$ptr_sele_catte=mysql_query($sele_cate,$link3);
									if(mysql_num_rows($ptr_sele_catte))
									{
										$data_product_id=mysql_fetch_array($ptr_sele_catte);
										$data_record_check_prod_serv['product_id']=$data_product_id['product_id'];
										
										$update_products1="update `product` set `quantity`=(quantity+".$data_record_check_prod_serv['issue_qty'].") where `product_id`='".$data_record_check_prod_serv['product_id']."' and cm_id='".$cm_ids."' and status='Active' and admin_id='".$stockist_id."' "; //
										$query_update=mysql_query($update_products1,$link3);
									}
									else
									{
										//echo "<br/>hi..";
										$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
										$ptr_category=mysql_query($sel_category,$link3);
										$data_cate=mysql_fetch_array($ptr_category);
										
										$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
										$ptr_subcategory1=mysql_query($sel_subcategory1,$link3);
										$data_subcategory=mysql_fetch_array($ptr_subcategory1);
										
										$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
										$ptr_sele_ahmcatte=mysql_query($sele_cateahm,$link3);
										if(mysql_num_rows($ptr_sele_ahmcatte))
										{
											$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
											$cat_id=$data_ahm_cat['pcategory_id'];
										}
										else
										{
											$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_cat=mysql_query($insert_cat,$link3);
											$cat_id=mysql_insert_id($link3);
										}
										$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
										$ptr_sele_subcatte=mysql_query($sele_subcateahm,$link3);
										if(mysql_num_rows($ptr_sele_subcatte))
										{
											$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
											$sub_cat_id=$data_ahm_subcat['sub_id'];
										}
										else
										{
											$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
											$ptr_ins_subcat=mysql_query($insert_subcat,$link3);
											$sub_cat_id=mysql_insert_id($link3);
										}
										$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`,`status`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_check_prod_serv['issue_qty']."','".$stockist_id."','Active')";
										$ptr_mysql_prod=mysql_query($inser_prod,$link3);
										$product_ids=mysql_insert_id($link3);
										$data_record_check_prod_serv['product_id']=$product_ids;
									}
								}
								$data_record_check_prod_serv['admin_id']=$stockist_id;
								
								$ins_checkout_data="INSERT INTO `checkout_product_map`(`checkout_id`,`product_id`,`unit`, `issue_qty`, `issue_unit`,`select_from`,`type`,`quantity`,`user_type`,`employee_id`,`cm_id`,`added_date`) VALUES ('".$record_ids."','".$_POST['product_id'.$i]."','".$_POST['unit'.$i].' '.$_POST['measure_unit'.$i]."', '".$data_record_check_prod_serv['issue_qty']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['select_from']."','".$data_record_check_prod_serv['type']."','".$data_record_check_prod_serv['quantity']."','".$data_record_check_prod_serv['user_type']."','".$data_record_check_prod_serv['admin_id']."','".$cm_ids."','".$added_date."')";
								$ptr_mysql_prod=mysql_query($ins_checkout_data,$link3);
								$customer_service_id=mysql_insert_id($link3);
								
								$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_qty=mysql_query($sel_qty,$link3);
								$data_qty=mysql_fetch_array($ptr_qty);
							}
						}						
					}*/
					//===================================END Dubai SALE ==========================================
					
					$insert="INSERT INTO `log_history`(`category`,`action`,`name`,`id`,`date`,`cm_id`,`admin_id`) VALUES ('sales_product','Add','sale product','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert,$link1);
					
					echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
					
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
						//setTimeout('document.location.href="manage_checkout.php";',1000);
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
			<?php
            $where_cm='';
            if($_SESSION['where']!='')
            {
                $where_cm=" and p.cm_id='".$_SESSION['cm_id']."'";
            }
            ?>
              	<tr>
                	<td colspan="3" class="orange_font">* Mandatory Fields</td>
                    <input type="hidden" name="res1" id="res1" />
                    <input type="hidden" name="res2" id="res2" />
                	<input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
         		</tr>
				<!--<tr>
					<td width="14%">Date<span class="orange_font">*</span></td>
					<td width="74%"><?php
					/*if($_SESSION['type']=='S')
					{*/
						?>
                        <input type="text" id="added_date" style="width:200px" name="added_date" class="input_text datepicker" value="<?php //if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode(' ',$row_record['added_date']);$arr_date= explode('-',$arrage_date[0]); echo $arr_date[2].'/'.$arr_date[1].'/'.$arr_date[0];}else{echo date("d/m/Y");}?>" />
                        <?php
					/*}
					else
					{
						if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode(' ',$row_record['added_date']);$arr_date= explode('-',$arrage_date[0]); echo $arr_date[2].'/'.$arr_date[1].'/'.$arr_date[0];}else{echo date("d/m/Y");}?>
						<input type="hidden" id="added_date" style="width:200px" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode(' ',$row_record['added_date']);$arr_date= explode('-',$arrage_date[0]); echo $arr_date[2].'/'.$arr_date[1].'/'.$arr_date[0];}else{echo date("d/m/Y");}?>" />
						<?php
					}*/
					?>
					</td>
				</tr> -->
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
							$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A'";
							$ptr_query=mysql_query($sel_cm_id,$link1);
							$data_branch_nmae=mysql_fetch_array($ptr_query);
						}
						$sel_branch="SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch,$link1);
						$total_Branch = mysql_num_rows($query_branch);
						echo'<table width="100%"><tr><td>'; 
						echo'<select id="branch_name" name="branch_name" onchange="show_bank(this.value)" style="width:200px">';
						echo '<option value="">Select Branch</option>';
						while($row_branch=mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"'?> /><?php echo $row_branch['branch_name']; ?>
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
                    <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name'];?>"/> 
                    <?php
				}?>
                <!--<tr>
                	<td width="14%" valign="top">Referal invoice No.<span class="orange_font">*</span></td>
                	<td width="74%"><input type="text"  class="input_text" style="width:200px" name="ref_invoice_no" id="ref_invoice_no" value="<?php //if($_POST['save_changes']) echo $_POST['ref_invoice_no']; else if($row_record['ref_invoice_no'] !='') echo $row_record['ref_invoice_no']; ?>" /></td> 
                	<td width="12%"></td>
          		</tr>
                <tr>
                	<td width="14%" valign="top">Show <?php //if($_SESSION['tax_type']=='GST') echo 'GST'; else echo 'VAT'; ?><span class="orange_font">*</span></td>
                	<td width="74%"><input type="radio" class="input_radio" name="show_gst" id="show_gst" value="yes" <?php //if($_POST['show_gst']=='yes') echo 'checked="checked"'; else if($row_record['show_gst']=='yes') echo 'checked="checked"'; else echo 'checked="checked"';  ?> />Yes &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="input_radio" name="show_gst" id="show_gst" value="no" <?php //if($_POST['show_gst']=='no') echo 'checked="checked"'; else if($row_record['show_gst']=='no') echo 'checked="checked"'; ?>/>No</td> 
                	<td width="12%"></td>
          		</tr>-->
				<tr>           		
            		<td width="14%" >Select Type<span class="orange_font">*</span></td>
            		<td>
                	<select id="user" name="user" onChange="show_data(this.value)" style="width:200px">
                	<option value="">Select</option>
					<option value="Student" <?php if($row_record['type']=="Student") echo 'selected="selected"';?>>Student</option>
					<option value="Customer" <?php if($row_record['type']=="Customer") echo 'selected="selected"';?>>Customer</option>
					<option value="Employee" <?php if($row_record['type']=="Employee") echo 'selected="selected"';?>>Employee</option>
                	</select>
                	</td>
            	</tr> 
				<tr>
					<td colspan="3">
						<div id="show_type">
						</div>
					</td>
            	</tr>
				<tr>
					<td colspan="3">
					<div id='stockiest'></div>
					</td>
				</tr>
                <!--<tr>
                    <td width="14%" class="tr-header" >Biling Address</td>
                    <td><textarea name="billing_address" id="billing_address" class="input_text" style="width:90%;height:80px"><?php //if($_POST['billing_address']) echo $_POST['billing_address']; else echo $row_record['billing_address'];?></textarea></td>
                </tr>
              	<tr>
                	<td width="14%" valign="top">Delivery Address</td>
                	<td width="74%"><textarea name="delivery_address" id="delivery_address" class="input_text" style="width:90%; height:80px"><?php //if($_POST['delivery_address']) echo $_POST['delivery_address']; else echo $row_record['delivery_address'];?></textarea></td>
              	</tr>-->
            <!--*********************************Multiple*********************************************************--->
           	<tr>
                <!--<td width="10%">Select Product from stock<span class="orange_font">*</span></td>-->
                <td colspan="3">
                  <table  width="101%" style="border:1px solid gray; ">
                    <tr>
                       <td colspan="2">
                        <table cellpadding="5" width="100%" >
                         <tr>
                           <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                             <script language="javascript">                              
                                <?php 
                                if($_SESSION['where'] !='')
                                {
                                    $cm_ds= ' and p.cm_id='.$_SESSION['cm_id'].'';
                                }
                                else
                                {
                                    $cm_ds='';
                                }
                                ?>
                                function floors(idss)
                                {
                                    res= document.getElementById("res1").value;
                                    res11= document.getElementById("res2").value;
                                    
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td width="16%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" style="width:360px" id="product_id'+idss+'" onChange="show_product('+idss+');" required><option value="">Select Product</option>'+res+'</select></td><td width="8%" align="center"><span id="unit_val'+idss+'"></span><input type="hidden" name="unit'+idss+'" id="unit'+idss+'" readonly="readonly" style="width:60px" /><span id="measure'+idss+'"></span><input type="hidden" name="measure_unit'+idss+'" id="measure_unit'+idss+'"/></td><td width="10%" align="center"><select name="select_from'+idss+'" id="select_from'+idss+'" onChange="show_product_qty('+idss+')" style="width: 110px;"><option value="">Select</option><option value="stock">Stock</option><option value="shelf">Shelf</option><option value="consumable">Consumable</option></select></td><td width="8%" align="center"><input type="text" name="quantity'+idss+'" id="quantity'+idss+'" readonly="readonly"  style="width:80px"/></td><td width="8%" align="center"><input type="text" name="issue_qty'+idss+'" id="issue_qty'+idss+'" onBlur="check_quantity('+idss+')" style="width:80px" /><td width="9%" align="center"><div id="select_to_div'+idss+'" style="width:100%"></div><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><input type="hidden" name="total_product[]" id="total_product'+idss+'"></td></tr><tr><td colspan="7"><div style="display:none;width:100%" id="product_details'+idss+'"><table style="width:100%" align="center"><tr><td width="7%">Price : <span id="price'+idss+'"></span></td><td width="10%">Brand : <span id="brand'+idss+'"></span></td><td width="15%">Product Desc. : <span id="description'+idss+'"></span></td><td width="40%" >Add Product Checkout Description. : <textarea name="prod_desc'+idss+'" id="prod_desc'+idss+'" placeholder="write description about product use" style="width:100%;"></textarea></td></tr></table></div></td></tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                            </script>
                           <td align="right">
                           <input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
                           <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
                          </td>
                        </tr>
                        <tr><td></td><td align="left"></td></tr>
                     </table>
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
                        <tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
                        <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
                          <tr>
                            <td colspan="6">
                              <table cellspacing="3" id="tbl" width="100%">
                                <tr>
                                    <td valign="top" align="center" width="24%" >Product Name</td>
                                    <td valign="top" width="7%" align="center">Unit</td>
                                    <td valign="top" width="8%" align="center" >Select From</td>
                                    <td valign="top" width="8%" align="center" >Quantity in Store</td>
                                    <td valign="top" width="8%" align="center">Issue Quantity</td>
                                    <td valign="top" width="8%" align="center">Select To</td>
                               </tr>
                              </table>
                                <input type="hidden" name="floor" id="floor" value="0">
                                <div id="create_floor"></div>
                            </td>
                          </tr>
                        </table>
                        </td>
                        </tr>
                	</table> 
            	</td>
           	</tr>
           	<!--*************************************************************************************************--->
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
<div id="footer"><?php require("include/footer.php");?></div>
<!--footer end-->
<?php
//if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  && $record_id=='')
//{
	?>
    <script>
	if(document.getElementById("branch_name"))
	{
		branch_name =document.getElementById("branch_name").value;
		show_bank(branch_name);
	}
    </script>
    <?php
//}

?>
</body>
</html>
<?php $db->close();?>