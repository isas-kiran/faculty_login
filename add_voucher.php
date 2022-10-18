<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM voucher where voucher_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='125'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Voucher</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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


<link rel="stylesheet" href="js/chosen.css" />
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var pageName = "add_voucher";
$(document).ready(function()
    {            
        $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
        {
            res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
        }
		
		
    });
	
</script>
<script type="text/javascript">
jQuery(document).ready( function() 
{
	//$("#service_id").multiselect().multiselectfilter();
	// binds form submission and fields to the validation engine
	jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
});
</script>
<script>

function hide()
{
	document.getElementById("service_hide").style.display="none";
	document.getElementById("redeme_hide").style.display="block";
	//document.getElementById("quantity_div").style.display="block";
}
function show()
{
	document.getElementById("service_hide").style.display="block";
	document.getElementById("redeme_hide").style.display="none";
	$("#service_id1").chosen({allow_single_deselect:true});
	$(".chosen-container-single").css("width", "161px");
	//document.getElementById("quantity_div").style.display="none";
}
/*function show_bank(branch_id)
{
	record_id= document.getElementById("record_id").value;
	var bank_data="action=enroll&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
	//alert(bank_data);
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
	/*var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		installment_tax= taxes[1];
		document.getElementById("service_tax_id").innerHTML=service_tax;
		//document.getElementById("inst_tax_id").innerHTML=installment_tax;
		document.getElementById("service_taxes").value=service_tax;
		//document.getElementById("inst_taxes").value=installment_tax;
		//alert("service tax- "+service_tax);
		val= Number(document.getElementById("amount").value);
		show_tax(val);

	}
	});
	
	var tax_data1="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax_type.php",type:"post", data: tax_data1,cache: false,
	success: function(rettax)
	{
		///alert(rettax);
		document.getElementById("create_type1").innerHTML='';
		document.getElementById("res1").value=rettax;
	}
	});*/

// }
/*function show_tax(val)
{
	var amount= Number(val);
	service_tax= Number(document.getElementById("service_taxes").value);
	
	service_tax_val= Number(val*service_tax/100)
	document.getElementById("service_tax").value=service_tax_val;
	
	total_cost=Number(val)+Number(service_tax_val);
	document.getElementById("total_cost_with_tax").value=total_cost;
	calculte_amount_tax();
	
}*/
/*function calculte_amount_tax(val_tax_ids)
{
	tax_value ='';
	var total_tax=document.getElementsByName("total_tax[]").length;
	//alert(total_tax);
	for(i=1;i<=total_tax;i++)
	{
		tax_id='tax_value'+i;
		//alert(tax_id);
		tax_value =Number(tax_value) + Number(document.getElementById(tax_id).value);
	}
	
    cost_tot_tt=parseInt(document.getElementById("total_cost_with_tax").value);
	cal_tot_amount=cost_tot_tt * (tax_value/100);
	//alert(cal_tot_amount)
	tot_amount=parseInt(cost_tot_tt + cal_tot_amount)
	//alert(tot_amount)
	
	$('#tax_amount'+val_tax_ids).val(cal_tot_amount);

	$('#total_cost').val(tot_amount);
}*/
/*function delete_tax(id,tax_types)
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
}*/

</script>
<script language="javascript" type="text/javascript">
function randomString(value) 
{
	//alert(value);
	var codes='';
	for(var j=1;j<=value;j++)
	{
		var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
		var string_length = 16;
		var randomstring = '';
		for (var i=0; i<string_length; i++) {
			var rnum = Math.floor(Math.random() * chars.length);
			randomstring += chars.substring(rnum,rnum+1);
		}
		var codes =codes.concat('<span style="font-size:16px; font-weight:400; color:#00F">'+j+') '+randomstring+'</span><input type="hidden" name="code'+j+'" id="code'+j+'" value="'+randomstring+'"></br>');
		
	}
	document.getElementById("show_codes").innerHTML=codes;
	//alert(codes);
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
				document.getElementById("service_qty"+val_idss).value=1;
				document.getElementById("sin_service_total"+val_idss).value=service_split[0];
				//var exit_disc=document.getElementById("sin_service_disc"+val_idss).value = 0;
				//var exit_disc_price=document.getElementById("sin_service_disc_price"+val_idss).value = 0;
            }
            });
			
			var exit_disc='';
			if(values !="")
			{		
				document.getElementById("sin_service_price"+val_idss).disabled = false;
				document.getElementById("service_qty"+val_idss).disabled = false;
				//document.getElementById("sin_service_time"+val_idss).disabled = false;
				document.getElementById("sin_service_total"+val_idss).disabled = false;
				//document.getElementById("staff_id"+val_idss).disabled = false;
				//$("#staff_id"+val_idss).chosen({allow_single_deselect:true});
			}
			else
			{
				document.getElementById("sin_service_price"+val_idss).disabled = true;
				document.getElementById("service_qty"+val_idss).disabled = true;
				//document.getElementById("sin_service_time"+val_idss).disabled = true;
				document.getElementById("sin_service_total"+val_idss).disabled = true;
				//document.getElementById("staff_id"+val_idss).disabled = true;
				//$("#staff_id"+val_idss).chosen({allow_single_deselect:true});
			}
			setTimeout(showUser,800);
			/*if(document.getElementById("package").value)
			{
				var package=document.getElementById("package").value;
				setTimeout(add_package(package),500);
			}*/
			//getDiscount(exit_disc,val_idss)
}
function calc_product_price(service_id)
{
	
	service_price=document.getElementById("sin_service_price"+service_id).value;
	service_qty=document.getElementById("service_qty"+service_id).value;
	//alert(prod_qty)
	/*total_prod_qty=document.getElementById("product_total_qty"+prod_id).value;
	//alert(total_prod_qty);
	
	if(prod_qty > total_prod_qty)
	{
		alert("Issue Quantity is not Greater than Total Quantity");
		document.getElementById("product_qty"+prod_id).value=1;
		prod_qty=1;
	}*/
	var service_price_new=service_price * service_qty;
	document.getElementById("sin_service_total"+service_id).value=service_price_new;
	//product_discount=document.getElementById("product_disc"+service_id).value;
	//if(product_discount!=0)
	/*{
		totl_price=prod_price_new*(product_discount/100);
		total_product_price=prod_price_new-totl_price;
		document.getElementById("sales_product_price"+prod_id).value=total_product_price;
	}
	else if(product_discount==0)
	{
	  document.getElementById("sales_product_price"+prod_id).value=prod_price_new;	
	}*/
	showUser();
	//calculte_total_cost();
}
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
	document.getElementById('amount').value=contact;
	
	/*var service_price=contact;
	var membership_discount= parseInt(document.getElementById('memb_discount').value);
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
		var total_discount_price= parseInt(service_price - discount_price);
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
		var nonmemb_discount= parseInt(document.getElementById('nonmemb_discount').value);
	}
	else
	{
		var nonmemb_discount=0;
	}
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
		var total_nonmemb_discount_price= parseInt(total_discount_price - nonmemb_discount_price);
		document.getElementById('nonmemb_discount_price').value=total_nonmemb_discount_price;
	}
	else
	{
		var total_nonmemb_discount_price=total_discount_price;
		document.getElementById('nonmemb_discount_price').value=total_nonmemb_discount_price;
	}*/
	
	
	
	/*var service_tax= document.getElementById('service_taxes').value;
	var disc_price= document.getElementById('nonmemb_discount_price').value;
	
	var service_tax__price= parseInt(disc_price * (service_tax/100));
	document.getElementById('service_tax').value=service_tax__price;
	var total_cost =  parseInt(disc_price) +  parseInt( service_tax__price);
	document.getElementById('total_cost').value=total_cost;
	document.getElementById('amount').value=total_cost;*/
	//alert(discount_price);
}
</script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>.

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
		if($_POST['formAction'])
		{
			if($_POST['formAction']=="delete")
			{
				for($r=0;$r<count($_POST['chkRecords']);$r++)
				{
					$del_record_id=$_POST['chkRecords'][$r];
					$sql_query= "SELECT voucher_id,deal_name FROM ".$GLOBALS["pre_db"]."voucher where voucher_id ='".$del_record_id."'";
					$ptr_query=mysql_query($sql_query);
					if(mysql_num_rows($ptr_query))
					{     
						$data_cust=mysql_fetch_array($ptr_query);   
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_voucher','Delete','".$data_cust['deal_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);
												  
						$delete_query="delete from package where package_id='".$del_record_id."'";
						$db->query($delete_query); 
												  
						$delete_query="delete from package where package_id='".$del_record_id."'";
						$db->query($delete_query); 
						
						$delete_query="delete from ".$GLOBALS["pre_db"]."voucher where voucher_id='".$del_record_id."'";
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
			$sql_query= "SELECT voucher_id,deal_name FROM ".$GLOBALS["pre_db"]."voucher where voucher_id='".$del_record_id."'";
			$ptr_query=mysql_query($sql_query);
			if(mysql_num_rows($ptr_query))
			{     
				$data_cust=mysql_fetch_array($ptr_query);   
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_voucher','Delete','".$data_cust['deal_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert);                           
				$delete_query="delete from ".$GLOBALS["pre_db"]."voucher where voucher_id='".$del_record_id."'";
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
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
                           	$category=$_POST['category']; 
                           	$deal_name=$_POST['deal_name'];
						   	$selling_amount=$_POST['amount'];
						   	$redeam_amount=$_POST['redeam_amount'];
							//$total_cost_with_tax=$_POST['total_cost_with_tax'];
						   	$total_floor=$_POST['floor'];
						   	//$service_tax=$_POST['service_tax'];
						   	$branch_name=$_POST['branch_name'];
						   	$start_date=$_POST['start_date'];
							$tan_date = explode('/',$start_date);
							$start_date=$tan_date[2].'-'.$tan_date[1].'-'.$tan_date[0];
							$end_date=$_POST['end_date'];
							$tan_dates = explode('/',$end_date);
							$end_date=$tan_dates[2].'-'.$tan_dates[1].'-'.$tan_dates[0];
							//$redeam_amount=$_POST['redeam_amount'];
							$validity=$end_date-$start_date;
							$quantity=$_POST['quantity'];
							
						   	//$total_type1=$_POST['total_type1'];
							if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
							}
							if($record_id=='')
							{
								  $sel_product="select voucher_id from voucher where deal_name ='".$deal_name."' ";
								  $ptr_product=mysql_query($sel_product);
								  if(mysql_num_rows($ptr_product))
								  {
									$success=0;
									$errors[$i++]="Deal Name already Exist.";
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
                                $data_record['category']=$category;
								$data_record['deal_name']=$deal_name;
								$data_record['amount']=$selling_amount;
								$data_record['redeam_amount']=$redeam_amount;
								//$data_record['total_cost_with_tax']=$total_cost_with_tax;
								//$data_record['service_tax']=$service_tax;
								$data_record['start_date']=$start_date;
								$data_record['end_date']=$end_date;
								$data_record['quantity_for_amount']=$quantity;
								$data_record['validity']=$validity;
								//$data_record['redeam_amount']=$redeam_amount;
                               	if($record_id)
                                {
                                    $where_record="voucher_id='".$record_id."'";
                                    $db->query_update("voucher", $data_record,$where_record);
									for($z=1;$z<=$total_floor;$z++)
									{
										"Floor- ". $_POST['del_floor'.$z]."<br />";
										"<br />floor_id- ".$_POST['floor_id'.$z];
										if($_POST['del_floor'.$z]=='yes')
										{
											if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
											{
												"<br />".$delete_row = " delete from voucher_service_map where voucher_service_id='".$_POST['floor_id'.$z]."' ";
												$ptr_delete = mysql_query($delete_row);
											}
										}
										if($_POST['del_floor'.$z] !='yes')
										{
										//$data_record_extra['product_id']=$record_id;   
										//$data_record_extra['title'] =ucfirst($_POST['title'.$z]);										
										$data_record_service['voucher_id'] =$record_id; 
										$data_record_service['service_id'] =$_POST['service_id'.$z];
										$data_record_service['quantity'] =$_POST['service_qty'.$z];
										$data_record_service['service_price'] =$_POST['sin_service_price'.$z];
										$data_record_service['price'] =$_POST['sin_service_total'.$z];
										
										if($_POST['floor_id'.$z]=='' && $_POST['service_id'.$z] !='')
										{
											 $type1_id=$db->query_insert("voucher_service_map", $data_record_service);
											
										}
										else
										{
											$where_record="voucher_service_id='".$_POST['floor_id'.$z]."'";
											$floor_id= $_POST['floor_id'.$z];
											$db->query_update("voucher_service_map", $data_record_service,$where_record);
										}
										unset($data_record_service);
									   }
									}
									/*for($x=1;$x<=$total_type1;$x++)
									{
										 $_POST['tax_type'.$x];
										
										if($_POST['del_floor_type1'.$x]=='yes')
										{
											if($_POST['type1_id'.$x]!='' && $_POST['del_floor_type1'.$x]=='yes' )
											{
												"<br />".$delete_row = " delete from voucher_tax_map where voucher_tax_map_id='".$_POST['type1_id'.$x]."' ";
												$ptr_delete = mysql_query($delete_row);
											}
										}
										if($_POST['del_floor_type1'.$x] !='yes')
										{
											$data_record_tax['voucher_id'] =$record_id; 
											'<br/>'.$data_record_tax['tax_type'] =$_POST['tax_type'.$x];
											$data_record_tax['tax_value'] =$_POST['tax_value'.$x];
											$data_record_tax['tax_amount'] =$_POST['tax_amount'.$x];
											if($_POST['type1_id'.$x]=='' && $_POST['tax_type'.$x] !='')
											{
												$type1_id=$db->query_insert("voucher_tax_map", $data_record_tax);
											}
											else
											{
												$where_record="voucher_tax_map_id='".$_POST['type1_id'.$x]."'";
												$type1_id= $_POST['type1_id'.$x];
												$db->query_update("voucher_tax_map", $data_record_tax,$where_record);
											}
											unset($data_record_tax);
									   	}
										
										
									}*/
									$del_code="delete from voucher_code_map where voucher_id='".$record_id."'";
									$ptr_del1=mysql_query($del_code);
									
									for($j=1;$j<=$quantity;$j++)
									{
										$data_record_code['voucher_id'] =$record_id;
										$data_record_code['voucher_code'] =$_POST['code'.$j];
										$data_record_code['status']='active';
										$voucher_code_id=$db->query_insert("voucher_code_map", $data_record_code);
									}
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_voucher','Edit','".$deal_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert); 
				
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d");
                                    $record_id=$db->query_insert("voucher", $data_record);
									for($i=1;$i<=$total_floor;$i++)
									{
										if($_POST['service_id'.$i] !='')
										{
											$data_record_service['voucher_id'] =$record_id; 
											$data_record_service['service_id'] =$_POST['service_id'.$i];
											$data_record_service['quantity'] =$_POST['service_qty'.$i];
											$data_record_service['service_price'] =$_POST['sin_service_price'.$i];
											$data_record_service['price'] =$_POST['sin_service_total'.$i];
											$customer_service_id=$db->query_insert("voucher_service_map", $data_record_service);
										}
									}
									/*for($j=1;$j<=$total_type1;$j++)
									{
										$data_record_tax['voucher_id'] =$record_id; 
										$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
										$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
										$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
										$customer_tax_id=$db->query_insert("voucher_tax_map", $data_record_tax);
									}*/
									for($j=1;$j<=$quantity;$j++)
									{
										$data_record_code['voucher_id'] =$record_id;
										$data_record_code['voucher_code'] =$_POST['code'.$j];
										$data_record_code['status']='active';
										$voucher_code_id=$db->query_insert("voucher_code_map", $data_record_code);
									}
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_voucher','Add','".$deal_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert); 
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
           </tr>
           <? if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
			{
				?>
			<tr>
			<td align="">Select Branch</td>
			<input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
			<td>
			<? 
			$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
			$query_branch = mysql_query($sel_branch);
			$total_Branch = mysql_num_rows($query_branch);
			echo '<table width="100%"><tr><td>';
			echo ' <select id="branch_name" name="branch_name" >';//onchange="show_bank(this.value)"
			
			while($row_branch = mysql_fetch_array($query_branch))
			{
				$selected='';
				if($_POST['branch_name']== $row_branch['branch_name'])
				{
					 $selected='selected="selected"';
				}
				$selected_branch="select branch_name from site_setting where cm_id= '".$row_record['cm_id']."' and type='A' ";
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
            <input type="hidden" name="res1" id="res1" />
			</tr>
			<? } ?>
           <tr>
           			<td>Select Category:</td>
                  	<td><input type="radio"  name="category" id="category" required value="amount" <?php if($row_record['category'] == "amount" || $_POST['category'] == "amount" ) echo 'checked="checked"'; else echo 'checked="checked"'; ?> onClick="hide()" />Amount <input type="radio"  name="category" id="category" required value="service" <?php if($row_record['category'] == "service" || $_POST['category'] == "service" ) echo 'checked="checked"'; ?>  onclick="show()" />Service</td>
           </tr>
           
         
          <tr>
          <td colspan="3">
          <div id="service_hide" <?php if($row_record['category'] == "service" || $_POST['category'] == "service" ) echo 'style="display:block"'; else echo 'style="display:none"'; ?> >
          <table width="100%" >
          <tr>
            	<td width="20%">Select Service<span class="orange_font">*</span></td>
            	<td width="80%" colspan="2">
                <table  width="75%" style="border:1px solid gray; ">
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
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="4%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="service_id'+idss+'" id="service_id'+idss+'" style="width:160px" onChange="getprice(this.value,'+idss+')"><option value="">Select Service</option><?php
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
									 </select><input type="hidden" disabled="disabled" name="sin_service_price'+idss+'" id="sin_service_price'+idss+'" style=" width:100px" /></td><td width="3%" align="center"><input type="text" name="service_qty'+idss+'" id="service_qty'+idss+'" style=" width:100px" onkeyup="calc_product_price('+idss+')" /></td><td width="3%" align="center"><input type="text" name="sin_service_total'+idss+'" id="sin_service_total'+idss+'" style=" width:100px" onkeyup="showUser()"/></td><td valign="top" width="8%" align="center"><input type="hidden" name="total_services[]" id="total_services'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
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
                        <td valign="top" width="33%" align="center">Service Name</td>
                        <td valign="top" width="20%"  align="center">Quantity</td>
                        <td valign="top" width="20%"  align="center">Price</td>
                        
                        <td valign="top" width="35%"  align="center"> <?php	if($record_id){ echo "Acton"; } ?></td>
                        </tr>
                        <tr>
                            <td colspan="7">
							<?php
                            $select_exc = "select * from voucher_service_map where voucher_id='".$record_id."' order by voucher_service_id asc ";
                            $ptr_fs = mysql_query($select_exc);
                            $t=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs))
                            { 
                                $slab_id= $data_exclusive['voucher_service_id'];
                            ?> 
                            <div class="floor_div" id="floor_id<?php echo $t; ?>">
                             <table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
                              <tr>
                                <td width="34%" align="center"><table cellspacing="5" id="tbl<?php echo $t; ?>2" width="100%">
                                  <tr>
                                    <td valign="top" width="29%" align="center">
                                    <select name="service_id<?php echo $t; ?>" id="service_id<?php echo $t; ?>" style="width:140px"  onChange="getprice(this.value,'<?php echo $t; ?>')" >
                                      <option value="">Select Service</option>
                                      <?php
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
                                    </select></td><input type="hidden" name="sin_service_price<?php echo $t; ?>" id="sin_service_price<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['service_price'] ?>" />
                                    <td width="20%" align="center"><input type="text" name="service_qty<?php echo $t; ?>" id="service_qty<?php echo $t; ?>" onkeyup="calc_product_price('<?php echo $t; ?>')" style=" width:100px" value="<?php echo $data_exclusive['quantity'] ?>"  /></td>
                                    <td width="20%" align="center"><input type="text" name="sin_service_total<?php echo $t; ?>" id="sin_service_total<?php echo $t; ?>" style=" width:100px" onkeyup="showUser()" value="<?php echo $data_exclusive['price'] ?>" /></td>
                                    <td valign="top" width="51%" align="center"><?php
								 	if($record_id)
								 	{
										?>
                                        <input type="hidden" name="total_services[]" id="total_services<?php echo $t; ?>" />
                                        <input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['voucher_service_id'] ?>" />
                                        <input type="button" title="Delete Options(-)" onClick="delete_rec(<?php echo $t; ?>,'floor');" class="delBtn" name="del" />
                                        <input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
                                        <?php } ?>
                                   	</td>
                                 </tr>
                                </table></td>
                              </tr>
                              </table>
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
             </table>
             </div>
             </td>
         </tr>
         <tr>
               <td>Deal Name:</td>
               <td><input type="text"  name="deal_name" class=" deal_name" id="deal_name" value="<?php if($_POST['deal_name']) echo $_POST['deal_name']; else echo $row_record['deal_name'];?>" required/></td>
         </tr>
         <tr>
         	<td colspan="3">
            <div id="quantity_div">
            	<table width="56%">
                <tr>
                	<td width="36%" valign="top">Quantity<span class="orange_font"></span></td>
         			<td width="42%"><input type="text" name="quantity" id="quantity" onblur="randomString(this.value)" value="<?php if($_POST['save_changes']) echo $_POST['quantity']; else echo $row_record['quantity_for_amount'];?>" /></td> 
            		<td width="22%"></td>
                </tr>
                </table>
         	</div>
            
            </td>
         </tr>
         <tr>
         	<td colspan="3">
            <table width="56%">
                <tr>
                	<td width="36%" valign="top">Voucher Codes</td>
         			<td width="42%"><div id="show_codes">
                    <?php
					if($record_id)
					{
						$sel_vou_code="select voucher_code,status from voucher_code_map where voucher_id='".$record_id."'";
						$ptr_voucher=mysql_query($sel_vou_code);
						$i=1;
						while($data_voucher=mysql_fetch_array($ptr_voucher))
						{
							echo"<span style='font-size:16px; font-weight:400; color:#00F'>".$i.")  ".$data_voucher['voucher_code']."    &nbsp;&nbsp;&nbsp; ".$data_voucher['status']."<input type='hidden' name='code".$i."' id='code".$i."' value='".$data_voucher['voucher_code']."'></span></br>";
						$i++;
						}
					}
					?>
                    
                    </div></td> 
            		<td width="22%"></td>
                </tr>
            </table>
            </td>
         </tr>
         <tr>
            <td width="15%" valign="top">Start Date <span class="orange_font"></span></td>
            <td width="70%"><input type="text"   class="datepicker" name="start_date"  id="start_date" value="<?php if($_POST['save_changes']) echo $_POST['start_date']; 
			else if($row_record['start_date'])
			{
				$sep=explode("-",$row_record['start_date']);
				echo $start_date=$sep[2]."/".$sep[1]."/".$sep[0];
			} 
			?>" /></td> 
              <td width="10%"></td>
         </tr>
         
         <tr>
         	<td width="20%" valign="top">End Date <span class="orange_font"></span></td>
         	<td width="70%"><input type="text"  class="datepicker" name="end_date" id="end_date" value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else if($row_record['end_date'])
			{
				$sep1=explode("-", $row_record['end_date']);
				echo $end_date=$sep1[2]."/".$sep1[1]."/".$sep1[0];
			}  
			
			?>" /></td> 
            <td width="10%"></td>
         </tr>
         <!-- <tr>
           		<td>Redeamable Amount(for 1 voucher):</td>
                <td><input type="text" name="redeam_amount" id="redeam_amount" value="<?php //if($_POST['redeam_amount']) echo $_POST['redeam_amount']; else echo $row_record['redeam_amount'];?>" required/></td>
         </tr>-->
         <tr>
           		<td>Selling Amount(for 1 voucher):</td>
                <td><input type="text" name="amount"  id="amount" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount'];?>" required/></td><!--onKeyUp="show_tax(this.value)"-->
         </tr>
         <!--<tr>      
           		<td width="20%" class="heading">Service Tax <span id="service_tax_id"><?php //if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?></span>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php //if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"/>
                <td><input type="text" name="total_cost_with_tax" id="total_cost_with_tax" value="<?php //if($_POST['total_cost_with_tax']) echo $_POST['total_cost_with_tax']; else echo $row_record['total_cost_with_tax'];?>" required/>                  <input type="text" name="service_tax" id="service_tax" value="<?php //if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>
         </tr>-->
         <!--<tr>
           		<td>Service_tax_with_amount:</td>
                <td>&nbsp;</td>
         </tr>-->
          <!--===========================================================NEW TABLE 2 START===================================-->   

          <!-- <tr>

            	<td width="10%">Tax<span class="orange_font">*</span></td>

            	<td colspan="2">

                <table  width="100%" style="border:1px solid gray; ">

                    <tr>

                    <td colspan="2">

                    

                    <table cellpadding="5" width="100%" >

                     <tr>

                     

                     <?php

					/* if($record_id =='')

					 {

						?>

                        <input type="hidden" name="type1" id="type1" class="inputText" size="1" onKeyUp="create_type1();" value="0" />

                        <?php 

					 }*/?>

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
                            /*$select_exc = "select * from voucher_tax_map where voucher_id='".$record_id."' order by voucher_tax_map_id asc ";
                            $ptr_fs = mysql_query($select_exc);
                            $s=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs))
                            { 
                                $slab_id= $data_exclusive['voucher_tax_map_id'];*/
                            ?> 
                            
                            <div class="type1" id="type1_id<?php //echo $s; ?>">
                            <table cellspacing="5" id="tbl<?php //echo $s; ?>" width="100%">
                            	<tr>
                            	<td width="8%" align="center">
                               
                               <select name="tax_type<?php //echo $s; ?>" id="tax_type<?php //echo $s; ?>">
                               <option value="">Select Tax</option>
							   <?php
							   	/*$cm_ids='';
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
		
								}*/
									 ?>

									 </select>
                                
                            	<!--<input type="text" name="tax_type<?php //echo $s; ?>" id="tax_type<?php //echo $s; ?>" style=" width:100px" value="<?php //echo $data_exclusive['tax_type'] ?>" />-->
                                
                            	<!--</td>
                            	<td width="8%" align="center">
                            	<input type="hidden" name="tax_amount<?php //echo $s; ?>" id="tax_amount<?php //echo $s; ?>" value="<?php //echo $data_exclusive['tax_amount'] ?>"/>
                            	<input type="text" name="tax_value<?php //echo $s; ?>" id="tax_value<?php //echo $s; ?>" style=" width:100px" value="<?php //echo $data_exclusive['tax_value'] ?>" onKeyUp="calculte_amount_tax(<?php //echo $s; ?>)"/></td>
                            	<td valign="top" width="10%" align="center">-->
                            	<?php
								/*if($record_id)
					 			{*/
								?>
									<!--<input type="hidden" name="total_tax[]" id="total_tax<?php //echo $s; ?>" />
                            		<input type="hidden" name="type1_id<?php //echo $s; ?>" id="type1_id<?php //echo $s; ?>" value="<?php //echo $data_exclusive['voucher_tax_map_id'] ?>" />
                            		<input type="button" title="Delete Options(-)" onClick="delete_tax(<?php //echo $s; ?>,'total_type1');" class="delBtn" name="del">
                            		<input type="hidden" name="del_floor_type1<?php //echo $s; ?>" id="del_floor_type1<?php //echo $s; ?>" value="" />-->

               	 				<?php 
								//} ?>   
                        		<!--</td>
                             	</tr>
                           </table>
                           </div>-->
                    <?php
                   //  $s++;
                    // }
                     ?>

                      <!--  </tr> 

                        </table>

                         <input type="hidden" name="total_type1" id="total_type1"  value="0" />

                        <div id="create_type1"></div>

                    </td></tr></table>-->

                     <?php

					/* if($record_id)

					 {
*/
						?>

                    <!--<input type="hidden" name="total_type1" id="total_type1" class="inputText"   value="<?php //echo $total_conditions; ?>" />-->

                  <!--  <input type="hidden" name="type1" id="type1" class="inputText" value="<?php //echo $total_conditions; ?>" />-->

                    <?php // } ?> 

                    

                   <!-- </td>

                    </tr>

                </table>

             </td>

         </tr>-->

       <!--============================================================END TABLE 2=========================================-->
       
         <tr>
         	<td colspan="2">
            <div id="redeme_hide">
            	<table width="100%">
                	<tr>
           				<td width="22%">Redeamable Amount(for 1 voucher):</td>
                		<td width="73%"><input type="text" name="redeam_amount" id="redeam_amount" value="<?php if($_POST['redeam_amount']) echo $_POST['redeam_amount']; else echo $row_record['redeam_amount'];?>"/></td>
         			</tr>
                </table>
            </div>
            </td>
         </tr>
       
         <tr>
         		<td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Voucher" name="save_changes"  /></td>
                <td></td>
         </tr>
        </table>
        </form>
        </td></tr>
<?php } ?>
        </table>
        
        <table cellspacing="0" cellpadding="0" class="table" width="95%">
		<tr class="head_td">
    		<td colspan="11">
        		<form method="get" name="search">
                    <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
                        <tr>
                            <td class="width5"></td>
                            <td width="20%">
                                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                    <option value="">-Operation-</option>
                                    <option value="delete">Delete</option>
                                </select></td>
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
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            $pre_keyword=" and (category like '%".$keyword."%' || deal_name like '%".$keyword."%' )";
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

                        if($_GET['orderby']=='category' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='voucher_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by voucher_id desc';    
							
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and voucher_id='".$_GET['record_id']."' ";
						}                  
                            $sql_query= "SELECT * FROM voucher where 1 ".$record_cat_id." ".$_SESSION['where']." ".$pre_keyword." ".$select_directory." "; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
    <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
    <td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="20%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Category Name</strong></a> <?php echo $img1;?></td>
    <td width="15%"><strong>Deal Name</strong></td>
    <td width="15%"><strong>Selling Amount</strong></td>
    <td width="10%"><strong>Redeamble Amount</strong></td>
    <!--<td width="15%"><strong>Total Cost (with Service Tax)</strong></td>-->
    <td width="10%"><strong>Added date</strong></td>
    <td width="10%" class="centerAlign"><strong>Action</strong></td>
  </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['voucher_id']; 
                                include "include/paging_script.php";
								
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';       
                                echo '<td >'.$val_query['category'].'</td>';
								echo '<td >'.$val_query['deal_name'].'</td>';
								echo '<td >'.$val_query['amount'].'</td>';
								echo '<td >'.$val_query['redeam_amount'].'</td>';
								//echo '<td >'.$val_query['total_cost'].'</td>';
								echo '<td >'.$val_query['added_date'].'</td>';
                                echo '<td align="center"><a href="add_voucher.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                                echo '</td>';
                                echo '</tr>';
                                $bgColorCounter++;
                            }    
                           ?>
  <tr class="head_td">
    <td colspan="11">
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
<script language="javascript">
create_floor('add');

var type= document.getElementById("category").value;
if(type=="amount")
{
	hide();
}
//document.getElementById("#service_id1_chosen").style.width="150px";
/*create_type1('add_type1');
create_type2('add_type2');*/

//create_floor_dependent();

</script>
<?php
if($_SESSION['type']=="S" || $record_id || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
{
	?>
    <script>
	//show_payment(this.value)
	//branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	//show_bank(branch_name);
	</script>
    <?php
	
	if($row_record['category'] == "service")
	{
		?><script>show()</script><?php
	}
	else
	{
		?><script>hide()</script><?php
	}
}
?>
</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>