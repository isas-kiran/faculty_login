<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM checkout where checkout_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
$staff_prev=$_SESSION['staff_prev']; 
$prev_value="";
for($e=0;$e<count($staff_prev);$e++)
{
	if($staff_prev[$e]==134) 
	{
		$prev_value="and privilege_id='134'";
	}
}
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='134'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Checkout</title>
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
	var pageName = "add_checkout";
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		$("#product").chosen({allow_single_deselect:true});
		$("#employee_id").chosen({allow_single_deselect:true});
	});
    </script>
    
    <script language="javascript" src="js/script.js"></script>
    <script language="javascript" src="js/conditions-script.js"></script>

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
<script type="text/javascript">
jQuery(document).ready( function() 
{
	$("#service_id").multiselect().multiselectfilter();
	// binds form submission and fields to the validation engine
	jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
});
</script>
<script type="text/javascript">
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
</script>
<script type="text/javascript">
function validate() 
{
    /*var value1 = parseInt(document.getElementById('quantity').value);
    var value2 = parseInt(document.getElementById('issue_qty').value);
    if (value2 > value1 )
    {
    	alert("Issue quantity should not be greater than Quantity in Store");
    	return false;
    }*/
}
</script>
<script>
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
<!--<link href="newjs/select2.css" rel="stylesheet"/>
    <script src="newjs/jquery-1.8.0.min.js"></script>
    <script src="newjs/select2.js"></script>
<script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
            $("#product").select2();   
        });
// Code that uses other library's $ can follow here.
</script>-->
<!--<link rel="stylesheet" href="js/chosen.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript"> 
var $j = jQuery.noConflict();
	$j(document).ready(function(){
	$j("#product").chosen({allow_single_deselect:true});
});
</script>-->
<script>
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
function show_data(val,ids)
{
	//alert(bank_id);
	var branch_name=document.getElementById("branch_name").value;
	var record_id= document.getElementById('record_id').value;
	var data1="action=show_data&action_page=checkout_product&id="+val+'&record_id='+record_id+'&branch_name='+branch_name+'&ids='+ids;
	//document.getElementById("billing_address").value= '';
	//document.getElementById("delivery_address").value= '';
	$.ajax({
	url: "ajax_cust_type.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		$("#show_type"+ids).html(html);
		// document.getElementById('show_type').value=html;
		$("#employee_id"+ids).chosen({allow_single_deselect:true});
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
			$added_date=date('Y-m-d');
			$branch_name=$_POST['branch_name'];
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
			{
				$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
				$ptr_branch=mysql_query($sel_branch);
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id=$data_branch['cm_id'];
				$data_record['cm_id']=$cm_id;
				$data_record_check_prod['cm_id']=$cm_id;
			}	
			else
			{
				$branch_name1=$_SESSION['branch_name'];
				$cm_id=$_SESSION['cm_id'];
				$data_record['cm_id']=$cm_id;
				$data_record_check_prod['cm_id']=$cm_id;
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
				</tr><br></br>  
				<?php
			}
			else
			{
				$success=1;
				$data_record['added_date']=$added_date;
				$data_record['admin_id']=$_SESSION['admin_id'];
				$total_floor=$_POST['floor'];
				if($record_id)
				{
					//$where_record=" checkout_id='".$record_id."'";
					//$db->query_update("checkout", $data_record,$where_record);
					//echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
				}
				else
				{
					$record_id=$db->query_insert("checkout", $data_record);
					for($i=1;$i<=$total_floor;$i++)
					{
						if($_POST['product_id'.$i]!='')
						{
							$quantity=$_POST['quantity'.$i];
							$issue_qty=$_POST['issue_qty'.$i];
							
							$data_record_check_prod['checkout_id'] =$record_id;
							$data_record_check_prod['product_id'] =$_POST['product_id'.$i];
							$data_record_check_prod['unit'] =$_POST['unit'.$i].' '.$_POST['measure_unit'.$i];
							$data_record_check_prod['issue_qty'] =$_POST['issue_qty'.$i];
							$data_record_check_prod['type']=$_POST['type'.$i];
							$data_record_check_prod['select_from'] =$_POST['select_from'.$i];
							$data_record_check_prod['quantity'] =$quantity - $issue_qty;
							$data_record_check_prod['user_type'] =$_POST['user'.$i];
							$data_record_check_prod['employee_id'] =$_POST['employee_id'.$i];
							$data_record_check_prod['added_date']=date('Y-m-d');
							$prod_desc=$_POST['prod_desc'.$i];
							$checkout_prod_map_id=$db->query_insert("checkout_product_map", $data_record_check_prod);
							
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
								$query_prod_qty=mysql_query($update_prod_qty); 
								
								$sel_stockiest="select admin_id from product where product_id='".$_POST['product_id'.$i]."' ";
								$ptr_stock=mysql_query($sel_stockiest);
								$data_stock=mysql_fetch_array($ptr_stock);
								$ins_data="INSERT INTO `product_daily_report`(`product_id`, `cm_id`, `stockiest_id`, `type`, `purchase_qty`, `sales_qty`, `checkout_qty`, `vendor_id`, `cust_type`, `cust_id`, `todays_qty`,`todays_shelf_qty`,`todays_consumable_qty`, `description`,`admin_id`,`added_date`) VALUES ('".$_POST['product_id'.$i]."','".$cm_id."','".$data_stock['admin_id']."','checkout','0','0','".$issue_qty."','0','staff','".$_POST['employee_id'.$i]."','todays_qty-".$data_prod['quantity']."','','','Checkout product quantity from stock  to other','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_ins=mysql_query($ins_data);
							}
							//========================= FROM SHELF =========================================
							else if($data_record_check_prod['select_from']=="shelf")
							{
								$upd_prod_qty="update product set quantity_in_shelf=(quantity_in_shelf - ".$issue_qty.") where product_id='".$_POST['product_id'.$i]."'";
								$query_prod_qty=mysql_query($upd_prod_qty);
							}
							//====================== FROM CONSUMABLE =====================================
							else if($data_record_check_prod['select_from']=="consumable")
							{
								$up_prod_qty="update product set quantity_in_consumable=(quantity_in_consumable - ".$issue_qty.") where product_id='".$_POST['product_id'.$i]."'";
								$query_prod_qty=mysql_query($up_prod_qty); 
							}
							//>>>>>>>>>>>>>>>>CHANGE FROM HERE ADD MAPPING TABLE-7/3/2019 <<<<<<<<<<<<<<<<<<<<<<<
							/*$sel_product_name="select product_id from product where product_id='".$data_record_check_prod['product_id']."'";
							$ptr_product_name=mysql_query($sel_product_name);
							$data_prod_name=mysql_fetch_array($ptr_product_name);*/
							
							$select_prod="select product_id,quantity from product_user_map where product_id='".$data_record_check_prod['product_id']."' and user_id ='".$data_record_check_prod['employee_id']."' ".$_SESSION['where']."";
							$ptr_my=mysql_query($select_prod);
							if(mysql_num_rows($ptr_my))
							{
								$data_prod_id=mysql_fetch_array($ptr_my);
								$prod_id=$data_prod_id['product_id'];
								$prod_qty=$data_prod_id['quantity'];
								
								/*$quantity=0;
								if($prod_qty > 0)
								{
									$quantity=$prod_qty+$issue_qty;
								}
								else
									$quantity=$issue_qty;*/
									
								if($data_record_check_prod['type']=="stock")
								{
									$update_prod_qty="update product_user_map set quantity=(quantity + ".$issue_qty.") where product_id='".$prod_id."' and user_id='".$data_record_check_prod['employee_id']."' ".$_SESSION['where']."";
								$query_prod_qty=mysql_query($update_prod_qty); 
								}
								//======================== TO SHELF ==========================================
								else if($data_record_check_prod['type']=="shelf")
								{
									$upd_prod_qty="update product_user_map set quantity_in_shelf=(quantity_in_shelf + ".$issue_qty.") where product_id='".$prod_id."' and user_id='".$data_record_check_prod['employee_id']."' ".$_SESSION['where']."";
									$query_prod_qty=mysql_query($upd_prod_qty); 
								}
								//========================= TO CONSUMABLE ======================================
								else if($data_record_check_prod['type']=="consumable")
								{
									$up_prod_qty="update product_user_map set quantity_in_consumable=(quantity_in_consumable + ".$issue_qty.") where product_id='".$prod_id."' and user_id='".$data_record_check_prod['employee_id']."' ".$_SESSION['where']."";
									$query_prod_qty=mysql_query($up_prod_qty); 
								}
							}
							else
							{
								$sel_prod=" select product_id,cm_id from product where product_id='".$data_record_check_prod['product_id']."'";
								$ptr_prod=mysql_query($sel_prod);
								if(mysql_num_rows($ptr_prod))
								{
									$data_prod=mysql_fetch_array($ptr_prod);
									
									if($data_record_check_prod['type']=="stock")
									{
										$ins_prod="INSERT INTO `product_user_map`(`product_id`, `user_id`,`quantity`,`quantity_in_shelf`,`quantity_in_consumable`,`admin_id`,`cm_id`) VALUES ('".$data_prod['product_id']."','".$data_record_check_prod['employee_id']."','".$issue_qty."','0','0','".$_SESSION['admin_id']."','".$data_prod['cm_id']."')";
										$query=mysql_query($ins_prod);
										
										$sel_stockiest="select admin_id from product where product_id='".$_POST['product_id'.$i]."' ";
										$ptr_stock=mysql_query($sel_stockiest);
										$data_stock=mysql_fetch_array($ptr_stock);
										$ins_data="INSERT INTO `product_daily_report`(`product_id`, `cm_id`, `stockiest_id`, `type`, `purchase_qty`, `sales_qty`, `checkout_qty`, `vendor_id`, `cust_type`, `cust_id`, `todays_qty`,`todays_shelf_qty`,`todays_consumable_qty`, `description`,`admin_id`,`added_date`) VALUES ('".$_POST['product_id'.$i]."','".$cm_id."','".$data_stock['admin_id']."','checkout','0','0','".$issue_qty."','0','staff','".$_POST['employee_id'.$i]."','todays_qty+".$data_prod['quantity']."','','','Checkout product quantity from other to stock','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
										$ptr_ins=mysql_query($ins_data);
									}
									//======================= TO SHELF =======================================
									else if($data_record_check_prod['type']=="shelf")
									{
										$ins_prod="INSERT INTO `product_user_map`(`product_id`, `user_id`,`quantity`,`quantity_in_shelf`,`quantity_in_consumable`,`admin_id`,`cm_id`) VALUES ('".$data_prod['product_id']."','".$data_record_check_prod['employee_id']."','0','".$issue_qty."','0','".$_SESSION['admin_id']."','".$data_prod['cm_id']."')";
										$query=mysql_query($ins_prod); 
									}
									//=========================== TO CONSUMABLE ===============================
									else if($data_record_check_prod['type']=="consumable")
									{
										$ins_prod="INSERT INTO `product_user_map`(`product_id`, `user_id`,`quantity`,`quantity_in_shelf`,`quantity_in_consumable`,`admin_id`,`cm_id`) VALUES ('".$data_prod['product_id']."','".$data_record_check_prod['employee_id']."','0','0','".$issue_qty."','".$_SESSION['admin_id']."','".$data_prod['cm_id']."')";
										$query=mysql_query($ins_prod); 
									}
								}
							}
							//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>DELETED - 7/3/19 >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
							//====================== TO STOCK ================================
							/*if($data_record_check_prod['type']=="stock")
							{
								$update_prod_qty="update product set quantity=(quantity + ".$issue_qty.") where product_id='".$prod_id."' and admin_id='".$data_record_check_prod['employee_id']."'";
							$query_prod_qty=mysql_query($update_prod_qty); 
							}
							//================================ TO SHELF ============================================
							else if($data_record_check_prod['type']=="shelf")
							{
								$upd_prod_qty="update product set quantity_in_shelf=(quantity_in_shelf + ".$issue_qty."),quantity=(quantity + ".$issue_qty.") where product_id='".$prod_id."' and admin_id='".$data_record_check_prod['employee_id']."'";
								$query_prod_qty=mysql_query($upd_prod_qty); 
							}
							//================================= TO CONSUMABLE ======================================
							else if($data_record_check_prod['type']=="consumable")
							{
								$up_prod_qty="update product set quantity_in_consumable=(quantity_in_consumable + ".$issue_qty."),quantity=(quantity + ".$issue_qty.") where product_id='".$prod_id."' and admin_id='".$data_record_check_prod['employee_id']."'";
								$query_prod_qty=mysql_query($up_prod_qty); 
							}*/
							//==========================================================================
						}
					}
					//>>>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<									
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_checkout','Add','Checkout add','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
	$query=mysql_query($insert);
					?>
					<script>
				   // send(<?php //echo $record_id; ?>);
					</script>
					<?php
					echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				}
			}
		}
		if($success==0)
		{
		?>
		<tr><td>
		<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
		<table border="0" cellspacing="15" cellpadding="0" width="100%">
			<tr>
				<td colspan="3" class="orange_font">* Mandatory Fields</td>
				<input type="hidden" name="res1" id="res1" />
				<input type="hidden" name="res2" id="res2" />
				<input type="hidden" name="res_tax" id="res_tax" />
				<input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
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
							$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
							$ptr_query=mysql_query($sel_cm_id);
							$data_branch_nmae=mysql_fetch_array($ptr_query);
						}
						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>'; 
						echo ' <select id="branch_name" name="branch_name" onChange="get_product_list(this.value)">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> </option>
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
				 <?php 
			}?>
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
								
								var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td width="16%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" style="width:340px" id="product_id'+idss+'" onChange="show_product('+idss+');" required><option value="">Select Product</option>'+res+'<?php
								/*$sel_tel = "select * from product where 1 and (quantity > 0 || quantity_in_shelf > 0 || quantity_in_consumable > 0) ".$_SESSION['where']."  ";// ".$_SESSION['user_id']." on 13/6/18	 ".$_SESSION['user_id']."
								//$sel_tel = "select p.*,s.name from product p, site_setting s where 1 and (s.type='ST' or s.type='S' or s.type='A') and s.admin_id=p.admin_id and (p.quantity > 0 || p.quantity_in_shelf > 0 || p.quantity_in_consumable > 0) and p.status='Active' ".$cm_ds." ";
								$query_tel = mysql_query($sel_tel);
								while($data=mysql_fetch_array($query_tel))
								{
									$name='';
									$sel_emp="select name from site_setting where admin_id='".$data['admin_id']."'";
									$ptr_admin_id=mysql_query($sel_emp);
									if(mysql_num_rows($ptr_admin_id))
									{
										$data_name=mysql_fetch_array($ptr_admin_id);
										$name= "(".$data_name['name'].")";
									}
									echo '<option value="'.$data['product_id'].'">'.addslashes($data['product_name']).'&nbsp; &nbsp;&nbsp;&nbsp;'.$name.'</option>';
								}*/
								 ?>
								 </select></td><td width="12%" align="center"><input type="text" name="unit'+idss+'" id="unit'+idss+'" readonly="readonly" style="width:60px" /> <span id="measure'+idss+'"><input type="hidden" name="measure_unit'+idss+'" id="measure_unit'+idss+'"/> </span></td><td width="10%" align="center"><select name="select_from'+idss+'" id="select_from'+idss+'" onChange="show_product_qty('+idss+')" style="width: 110px;"><option value="">Select</option><option value="stock">Stock</option><option value="shelf">Shelf</option><option value="consumable">Consumable</option></select></td><td width="8%" align="center"><input type="text" name="quantity'+idss+'" id="quantity'+idss+'" readonly="readonly"  style="width:80px"/></td><td width="8%" align="center"><input type="text" name="issue_qty'+idss+'" id="issue_qty'+idss+'" onBlur="check_quantity('+idss+')"  style="width:80px" /><td width="10%" align="center"><div id="select_to_div'+idss+'" style="width:100px"></div></td><td width="8%" align="center"><select name="user'+idss+'" id="user'+idss+'" onChange="show_data(this.value,'+idss+')" required style="width:100px"><option value="">Select Type</option><option value="">Select</option><option value="Student">Student</option><option value="Customer">Customer</option><option value="Employee">Employee</option></select></td><td width="8%" align="center"><div id="show_type'+idss+'"><select name="employee_id'+idss+'" id="employee_id'+idss+'" required style="width:180px"><option value="">Select Employee</option>'+res11+'<?php
								/*if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
								{
									$sel_staff = "select admin_id,name from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." order by name asc";	 
									$query_staff = mysql_query($sel_staff);
									if($total_staff=mysql_num_rows($query_staff))
									{
										while($data=mysql_fetch_array($query_staff))
										{
											echo '<option value="'.$data['admin_id'].'">'.addslashes($data['name']).'</option>';
										}
									}
								}
								else
								{
									$sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$prev_value." ".$_SESSION['where']." ";
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
												echo '<option value="'.$data['admin_id'].'">'.addslashes($data['name']).'</option>';
											}
										}
									}
								}*/
								?>
								</select></div><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><input type="hidden" name="total_product[]" id="total_product'+idss+'" ></td></tr><tr><td colspan="7"><div style="display:none" id="product_details'+idss+'"><table style="width:100%" align="center"><tr><td width="7%">Price : <span id="price'+idss+'"></span></td><td width="10%">Brand : <span id="brand'+idss+'"></span></td><td width="15%">Product Desc. : <span id="description'+idss+'"></span></td><td width="40%" >Add Product Checkout Description. : <textarea name="prod_desc'+idss+'" id="prod_desc'+idss+'" placeholder="write description about product use" style="width:100%;"></textarea></td></tr></table></div></td></tr></table></div>';
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
                                <td valign="top" align="center" width="29%" >Product Name</td>
                                <td valign="top" width="6%" align="center">Unit</td>
                                <td valign="top" width="10%" align="center" >Select From</td>
                                <td valign="top" width="8%" align="center" >Quantity in Store</td>
                                <td valign="top" width="8%" align="center">Issue Quantity</td>
                                <td valign="top" width="8%" align="center">Select To</td>
                                <td valign="top" width="8%" align="center">Select Type</td>
                                <td valign="top" width="16%" align="center">Select Employee</td>
                           </tr>
                          </table>
                            <input type="hidden" name="floor" id="floor"  value="0" />
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
              <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Checkout" name="save_changes"  onclick="return validate();"/></td>
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
<!--<script language="javascript">
create_floor('add');
</script>-->
<?php
//if($record_id!='' || $_SESSION['type']=='S' || $_SESSION['type']=='LD' || $_SESSION['type']=='Z')
//{
	?>
    <script>
	if(document.getElementById("branch_name"))
	{
		branch_name =document.getElementById("branch_name").value;
		//alert(vendor_id);
		setTimeout(get_product_list(branch_name),500);
	}
	</script>
    <?php
//}
?>
<!--footer start-->
<div id="footer"><?php require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>