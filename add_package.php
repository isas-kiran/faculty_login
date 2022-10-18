<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM package where package_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='124'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Package</title>
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
pageName="add_package";
$(document).ready(function()
{            
	$('.datepicker').datepicker({ changeMonth: true,dateFormat: 'dd/mm/yy',changeYear: true, showButtonPanel: true, closeText: 'Clear'});
	$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
	{
		res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
	}
	$("#service_id1").chosen({allow_single_deselect:true});
});
</script>
    
<script>
function selectalls() 
{
	if($("#selectall").attr("checked")==true){
	$('.case').each(function() {
	$(this).attr('checked','checked');
	showservice();
	});
	}else{
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
	  //alert(a);
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
/*$(function()
{
	$('#jqueryForm').submit(function()
	{
		 var options = $('#service_id > option:selected');
		 if(options.length == 0)
		 {
			 alert('Please Select Services');
			 return false;
		 }
	});
});
*/
function validme()
{
	 frm = document.jqueryForm;
	 error='';
	 disp_error = 'Clear The Following Errors : \n\n';
	
	 if(frm.package_name.value=='')
	 {
		 disp_error +='Enter Package Name\n';
		 document.getElementById('package_name').style.border = '1px solid #f00';
		 frm.package_name.focus();
		 error='yes';
	 }
	 if(frm.package_code.value=='')
	 {
		 disp_error +='Enter Package Code \n';
		 document.getElementById('package_code').style.border = '1px solid #f00';
		 frm.package_code.focus();
		 error='yes';
	 }
	 if(frm.start_date.value=='')
	 {
		 disp_error +='Enter Start Date \n';
		 document.getElementById('start_date').style.border = '1px solid #f00';
		 frm.start_date.focus();
		 error='yes';
	 }
	 if(frm.end_date.value=='')
	 {
		 disp_error +='Enter End Date \n';
		 document.getElementById('end_date').style.border = '1px solid #f00';
		 frm.end_date.focus();
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
	//alert(service_id);
	service_price=document.getElementById("sin_service_price"+service_id).value;
	//alert(service_price);
	service_qty=document.getElementById("service_qty"+service_id).value;
	//alert(service_qty);
	//alert(prod_qty)
	/*total_prod_qty=document.getElementById("product_total_qty"+prod_id).value;
	//alert(total_prod_qty);
	
	if(prod_qty > total_prod_qty)
	{
		alert("Issue Quantity is not Greater than Total Quantity");
		document.getElementById("product_qty"+prod_id).value=1;
		prod_qty=1;
	}*/
	var service_price_new=Number(parseInt(service_price) * parseInt(service_qty));
	//alert(service_price_new);
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
	for(i=1;i<=totals; i++)
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
	document.getElementById('total_service_amount').value=contact;
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
function show_bank(branch_id)
{
	//alert(branch_id);
	record_id='';
	if(document.getElementById("record_id"))
	record_id= document.getElementById("record_id").value;
	var bank_data="action=add_package&show_bnk=1&branch_id="+branch_id+"&record_id="+record_id;
	//alert(bank_data);
	
	
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
 function calculte_amount_tax(val_tax_ids)
{
	tax_value ='';
	var total_tax=document.getElementsByName("total_tax[]").length;
	/*for(i=1;i<=total_tax;i++)
	{
		tax_id='tax_value'+i;
		//alert(tax_id);
		tax_value =Number(tax_value) + Number(document.getElementById(tax_id).value);
	}
	
    cost_tot_tt=parseInt(document.getElementById("total_service_amount").value);
	cal_tot_amount=cost_tot_tt * (tax_value/100);
	//alert(cal_tot_amount)
	tot_amount=parseInt(cost_tot_tt + cal_tot_amount)
	//alert(tot_amount)
	
	$('#tax_amount'+val_tax_ids).val(cal_tot_amount);

	$('#amount').val(tot_amount);*/
	
	tot_tax_amount=0;
	for(i=1;i<=total_tax;i++)
	{
		tax_id='tax_value'+i;
		tax_amount_id='tax_amount'+i;
		tax_value = Number(document.getElementById(tax_id).value);
	
		cost_tot_tt=parseInt(document.getElementById("total_service_amount").value);
		cal_tot_amount=cost_tot_tt * (tax_value/100);
		
		//document.getElementById(tax_amount_id).value=cal_tot_amount;
		$('#tax_amount'+i).val(cal_tot_amount);
		tot_tax_amount=parseInt(Number(tot_tax_amount) + Number(cal_tot_amount))
	}
	tot_amount=parseInt(cost_tot_tt + tot_tax_amount)
	$('#amount').val(tot_amount);
	
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
</script>

<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>.
</head>
<body>
<?php include "include/header.php";?>
<?php include "include/menuLeft.php"; ?>
<!--info start-->
<div id="info">
<!--left start--><!--left end-->
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
                           $service_ids=$_POST['requirment_id']; 
						   $service_ids=( ($_POST['requirment_id'])) ? $_POST['requirment_id'] : "0";
						   //$total_service=@implode(",",$_POST['total_service']);
                           //$package_name=$_POST['package_name'];
						   $package_name=( ($_POST['package_name'])) ? $_POST['package_name'] : "";
						   //$package_code=$_POST['package_code'];
						   $package_code=( ($_POST['package_code'])) ? $_POST['package_code'] : "";
						  // $description=$_POST['description'];
						   //$start_date=$_POST['start_date'];
						   $start_date=( ($_POST['start_date'])) ? $_POST['start_date'] : "";
						  // $end_date=$_POST['end_date'];
						   $end_date=( ($_POST['end_date'])) ? $_POST['end_date'] : "";
						   //$cost_to_center=$_POST['cost_to_center'];
						   //$commision=$_POST['commision'];
						   //$membership_id=$_POST['membership_id'];
						   //$total_service_amount=$_POST['total_service_amount'];
						   $total_service_amount=( ($_POST['total_service_amount'])) ? $_POST['total_service_amount'] : "";
						  //$quantity=$_POST['quantity'];
						   $quantity=( ($_POST['quantity'])) ? $_POST['quantity'] : "1";
						   //$selling_amount=$_POST['amount'];
						   $selling_amount=( ($_POST['amount'])) ? $_POST['amount'] : "";
						  // $redeam_amount=$_POST['redeam_amount'];
						   $total_floor=$_POST['floor'];
							$total_type1=$_POST['total_type1'];
						   $exp=explode("/",$start_date);
						   $start_date=$exp[2]."-".$exp[1]."-".$exp[0];
						   
						   $exp1=explode("/",$end_date);
						   $end_date=$exp1[2]."-".$exp1[1]."-".$exp1[0];
						   $branch_name=$_POST['branch_name'];
						   if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
								  $sel_product="select package_name from package where package_name ='".$package_name."' ";
								  $ptr_product=mysql_query($sel_product);
								  if(mysql_num_rows($ptr_product))
								  {
									$success=0;
									$errors[$i++]="Package already Exist.";
								  }
								  
								  $sel_product_code="select package_code from package where package_code ='".$package_code."' ";
								  $ptr_product_code=mysql_query($sel_product_code);
								  if(mysql_num_rows($ptr_product_code))
								  {
									$success=0;
									$errors[$i++]="Package Code already Exist.";
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
                                $data_record['package_name']=$package_name;
								$data_record['package_code']=$package_code;
								$data_record['start_date']=$start_date;
								$data_record['end_date']=$end_date;
								$data_record['quantity']=$quantity;
								$data_record['amount']=$selling_amount;
								$data_record['total_service_amount']=$total_service_amount;
								//$data_record['redeam_amount']=$redeam_amount;
								//$data_record['description']=$description;
								
								//$data_record['cost_to_center']=$cost_to_center;
								//$data_record['commision']=$commision;
								//$data_record['membership_id']=$membership_id;
								
                            	if($record_id)
                                {
                                    $where_record=" package_id='".$record_id."'";
                                    $db->query_update("package", $data_record,$where_record);
									
									for($z=1;$z<=$total_floor;$z++)
									{
										"Floor- ". $_POST['del_floor'.$z]."<br />";
										"<br />floor_id- ".$_POST['floor_id'.$z];
										if($_POST['del_floor'.$z]=='yes')
										{
											if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
											{
												"<br />".$delete_row = "delete from package_service_map where map_id='".$_POST['floor_id'.$z]."' ";
												$ptr_delete = mysql_query($delete_row);
											}
										}
										if($_POST['del_floor'.$z] !='yes')
										{
										//$data_record_extra['product_id']=$record_id;   
										//$data_record_extra['title'] =ucfirst($_POST['title'.$z]);										
										$data_record_service['package_id'] =$record_id; 
										$data_record_service['service_id'] =$_POST['service_id'.$z];
										$data_record_service['quantity'] =$_POST['service_qty'.$z];
										$data_record_service['service_price'] =$_POST['sin_service_price'.$z];
										
										$data_record_service['price'] =$_POST['sin_service_total'.$z];
										
										if($_POST['floor_id'.$z]=='' && $_POST['service_id'.$z] !='')
										{
											 $type1_id=$db->query_insert("package_service_map", $data_record_service);
										}
										else
										{
											$where_record="map_id='".$_POST['floor_id'.$z]."'";
											$floor_id= $_POST['floor_id'.$z];
											$db->query_update("package_service_map", $data_record_service,$where_record);
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
												"<br />".$delete_row = " delete from package_tax_map where package_tax_map_id='".$_POST['type1_id'.$x]."' ";
												$ptr_delete = mysql_query($delete_row);
											}
										}
										if($_POST['del_floor_type1'.$x] !='yes')
										{
											$data_record_tax['package_id'] =$record_id; 
											'<br/>'.$data_record_tax['tax_type'] =$_POST['tax_type'.$x];
											$data_record_tax['tax_value'] =$_POST['tax_value'.$x];
											$data_record_tax['tax_amount'] =$_POST['tax_amount'.$x];
											if($_POST['type1_id'.$x]=='' && $_POST['tax_type'.$x] !='')
											{
												$type1_id=$db->query_insert("voucher_tax_map", $data_record_tax);
											}
											else
											{
												$where_record="package_tax_map_id='".$_POST['type1_id'.$x]."'";
												$type1_id= $_POST['type1_id'.$x];
												$db->query_update("package_tax_map", $data_record_tax,$where_record);
											}
											unset($data_record_tax);
									   	}
										
										
									}
									/*"<br />".$del_ex_section="delete from package_service_map where package_id='".$record_id."'";
                                    $ptr_del_section=mysql_query($del_ex_section);
									  
									for($i=0;$i<count($_POST['requirment_id']);$i++)
									{
										$insert_service_ids=" insert into package_service_map (`package_id`,`service_id`) values('".$record_id."', '".$_POST['requirment_id'][$i]."')";
										$query_insert=mysql_query($insert_service_ids);
									}*/
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_package','Edit','".$package_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert); 
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("package", $data_record);
									
									for($j=1;$j<=$total_type1;$j++)
									{
										if($_POST['tax_type'.$j] !='' && $_POST['tax_value'.$j] !='')
										{
											$data_record_tax['package_id'] =$record_id; 
											$data_record_tax['tax_type'] =$_POST['tax_type'.$j];
											$data_record_tax['tax_value'] =$_POST['tax_value'.$j];
											$data_record_tax['tax_amount']=$_POST['tax_amount'.$j];
											$customer_tax_id=$db->query_insert("package_tax_map", $data_record_tax);
										}
									}
									
									for($i=1;$i<=$total_floor;$i++)
									{
										$data_record_service['package_id'] =$record_id; 
										$data_record_service['service_id'] =$_POST['service_id'.$i];
										$data_record_service['quantity'] =$_POST['service_qty'.$i];
										$data_record_service['service_price'] =$_POST['sin_service_price'.$i];
										$data_record_service['price'] =$_POST['sin_service_total'.$i];
										$customer_service_id=$db->query_insert("package_service_map", $data_record_service);
									}
									
									/*for($i=0;$i<count($_POST['requirment_id']);$i++)
									{
									   "<br/>".$insert_service_ids=" insert into package_service_map (`package_id`,`service_id`) values('".$record_id."', '".$_POST['requirment_id'][$i]."')";
									   $query_insert=mysql_query($insert_service_ids);
									}
									*/
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_package','Add','".$package_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert); 
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
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
                </tr>
                
				<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                {
                    ?>
                <tr>
                <td align="">Select Branch</td>
                <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                <td>
                <?php
                $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                $query_branch = mysql_query($sel_branch);
                $total_Branch = mysql_num_rows($query_branch);
                echo '<table width="100%"><tr><td>';
                echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)" >';//onchange="show_bank(this.value)"
                
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
                
                </tr>
                <?php } else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?>    
           <tr>
            
                  <td>Package Name: <span class="orange_font">*</span></td>
                  <td><input type="text"  name="package_name" class=" input_text"  id="package_name" value="<?php if($_POST['save_changes']) echo $_POST['package_name']; else echo $row_record['package_name'];?>" /></td>
                   
           </tr>
           
            <tr>
            
                  <td>Package Code: <span class="orange_font">*</span></td>
                  <td><input type="text"  name="package_code" class=" input_text"  id="package_code" value="<?php if($_POST['save_changes']) echo $_POST['package_code']; else echo $row_record['package_code'];?>" /></td>
                   
           </tr>
           
           <!--<tr>
            <td width="12%" valign="top">Description </td>
            <td colspan="2">
                   
			 <script src="ckeditor/ckeditor.js"></script>
                <textarea name="description" id="description"><?php //if ($_POST['description']) echo stripslashes($_POST['description']); else echo $row_record['description']; ?></textarea>
            <script>
                CKEDITOR.replace( 'description' );
            </script>
                </td> 

            </tr>-->
            <tr>
          <td colspan="3">
          
          <table width="100%" >
          <tr>
            	<td width="12%">Select Service<span class="orange_font">*</span></td>
            	<td width="100%" colspan="2">
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
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="25%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="service_id'+idss+'" id="service_id'+idss+'" style="width:140px" onChange="getprice(this.value,'+idss+')"><option value="">Select Service</option><?php
									$sel_tel = "select service_id,service_name,service_price,service_time from servies order by service_id asc";	 
									$query_tel = mysql_query($sel_tel);
									if($total=mysql_num_rows($query_tel))
									{
										while($data=mysql_fetch_array($query_tel))
										{
											echo '<option value="'.$data['service_id'].'">'.addslashes($data['service_name'])." &nbsp;&nbsp;&nbsp;       (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time']." min)".'</option>';
										}
									}
									 ?>
									 </select><input type="hidden" disabled="disabled" name="sin_service_price'+idss+'" id="sin_service_price'+idss+'" style=" width:100px" /></td><td width="25%" align="center"><input type="text" name="service_qty'+idss+'" id="service_qty'+idss+'" style=" width:100px" onkeyup="calc_product_price('+idss+')"  /></td><td width="25%" align="center"><input type="text" name="sin_service_total'+idss+'" id="sin_service_total'+idss+'" style=" width:100px" onkeyup="showUser()"/></td><td valign="top" width="25%" align="center"><input type="hidden" name="total_services[]" id="total_services'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
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
                        <td valign="top" width="25%"  align="center">Quantity</td>
                        <td valign="top" width="25%"  align="center">Price</td>
                        
                        <td valign="top" width="25%"  align="center"> <?php	if($record_id){ echo "Acton"; } ?></td>
                        </tr>
                        <tr>
                            <td colspan="7">
						<?php
						if($record_id)
                        {
							$select_exc = "select * from package_service_map where package_id='".$record_id."' order by map_id asc ";
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
                                <td width="34%" align="center"><table cellspacing="5" id="tbl<?php echo $t; ?>2" width="100%">
                                  <tr>
                                    <td valign="top" width="25%" align="center">
                                    <select name="service_id<?php echo $t; ?>" id="service_id<?php echo $t; ?>" style="width:140px" onChange="getprice(this.value,'<?php echo $t; ?>')">
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
												echo '<option value="'.$data['service_id'].'" '.$selected.'>'.addslashes($data['service_name'])."   (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time'].")".'</option>';
											}
										}
										 ?>
                                    </select></td><input type="hidden" name="sin_service_price<?php echo $t; ?>" id="sin_service_price<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['service_price'] ?>" />
                                    <td width="25%" align="center"><input type="text" onkeyup="calc_product_price('<?php echo $t; ?>')" name="service_qty<?php echo $t; ?>" id="service_qty<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['quantity'] ?>" /></td>
                                    <td width="25%" align="center"><input type="text" onkeyup="showUser()" name="sin_service_total<?php echo $t; ?>" id="sin_service_total<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['price'] ?>" /></td>
                                    <td valign="top" width="25%" align="center"><?php
								 	if($record_id)
								 	{
										?>
                                        <input type="hidden" name="total_services[]" id="total_services<?php echo $t; ?>" />
                                        <input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['map_id'] ?>" />
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
             
             </td>
         </tr>
           <tr>
         	<td colspan="3">
            <div id="quantity_div">
            	<table width="100%">
                <tr>
                	<td width="12%" valign="top">Quantity<span class="orange_font"></span></td>
         			<td width="63%"><input type="text" name="quantity" id="quantity" value="<?php if($_POST['save_changes']) echo $_POST['quantity']; else echo $row_record['quantity'];?>" /></td> 
            		<td width="28%"></td>
                </tr>
                </table>
         	</div>
            
           </td>
          </tr>
           <tr>
                <td>Start Date</td>
                <td width="70%"><input type="text" name="start_date" id="start_date" class=" input_text datepicker" 
                value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else if($row_record['start_date']!=''){ $str_date=explode("-",$row_record['start_date']);echo $str_date[2]."/".$str_date[1]."/".$str_date[0] ;} ?>"/></td>
            </tr>
            
            <tr>
                <td>End Date</td>
                <td width="70%"><input type="text" name="end_date" id="end_date" class="datepicker input_text" 
                value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else if($row_record['end_date']!=''){ $end_date=explode("-",$row_record['end_date']);echo $end_date[2]."/".$end_date[1]."/".$end_date[0] ;} ?>"/></td>
            </tr>
            <tr>
           		<td>Total Service Price</td>
                <td><input type="text" name="total_service_amount"  id="total_service_amount" value="<?php if($_POST['total_service_amount']) echo $_POST['total_service_amount']; else echo $row_record['total_service_amount'];?>" required/></td><!--onKeyUp="show_tax(this.value)"-->
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
                            $select_exc = "select * from package_tax_map where package_id='".$record_id."' order by package_tax_map_id asc ";
                            $ptr_fs = mysql_query($select_exc);
                            $s=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs))
                            { 
                                $slab_id= $data_exclusive['package_tax_map_id'];
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
                                
                            	<!--<input type="hidden" name="tax_type<?php //echo $s; ?>" id="tax_type<?php echo $s; ?>" style=" width:100px" value="<?php //echo $data_exclusive['tax_type'] ?>" />-->
                                
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
                            		<input type="hidden" name="type1_id<?php echo $s; ?>" id="type1_id<?php echo $s; ?>" value="<?php echo $data_exclusive['package_tax_map_id'] ?>" />
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

                    <input type="hidden" name="total_type1" id="total_type1" class="inputText"   value="<?php echo $total_conditions; ?>" />

                    <input type="hidden" name="type1" id="type1" class="inputText" value="<?php echo $total_conditions; ?>" />

                    <?php  } ?> 

                    

                    </td>

                    </tr>

                </table>

             </td>

         </tr>

       <!--============================================================END TABLE 2=========================================-->
           <!--<tr>
            <td width="20%">Select Services </td>
            <td width="40%" >
                <select  multiple="multiple" name="requirment_id[]" id="service_id" class="input_select" style="width:150px;" >                        
                        <?php 
                            /*$select_service = "select service_id,service_name from servies order by service_id asc";
                            $query_service = mysql_query($select_service);
							$i=0;
                            while($data_service = mysql_fetch_array($query_service))
                            { 
                                $class ='';
								$sql_sub_cat ="select * from package_service_map where package_id='".$row_record['package_id']."' and service_id='".$data_service['service_id']."' ";
								$ptr_sub_cat =mysql_query($sql_sub_cat);
								if(mysql_num_rows($ptr_sub_cat))
								{
									$class = 'selected="selected"';
								}
                                echo '<option '.$class.' value="'.$data_service['service_id'].'" >'.$data_service['service_name'].'</option>';  
                            	$i++;
							}*/
                            ?>  
                              
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>-->
           
            <!--<tr>
                <td width="25%">Cost to Center : <span class="orange_font">*</span></td>
                <td width="40%"><input type="text" name="cost_to_center" class="input_text" id="cost_to_center" value="<?php //if($_POST['save_changes']) echo $_POST['cost_to_center']; else echo $row_record['cost_to_center'];?>"  /></td>
            </tr>
            
            <tr>
                <td width="25%">Commision (in %) :</td>
                <td width="40%"><input type="text" name="commision" class="input_text" id="commision" value="<?php //if($_POST['save_changes']) echo $_POST['commision']; else echo $row_record['commision'];?>" /></td>
            </tr>-->
           
           <!--<tr>
               <td width="15%">Membership:</td>
               <td><input type="radio" value="gold" name="membership" id="membership" <?php //if($row_record['membership']=='gold') echo 'checked="checked"' ?>>Gold
                   <input type="radio" value="silver" name="membership" id="membership" <?php //if($row_record['membership']=='silver') echo 'checked="checked"' ?>>Silver
                   <input type="radio" value="platinum" name="membership" id="membership" <?php //if($row_record['membership']=='platinum') echo 'checked="checked"' ?>>Platinum
               </td>
            
           </tr>-->
           
           <!--<tr>
            <td width="15%" valign="top">Select Membership</td>
             <td width="50%">
             <select name="membership_id" id="membership_id"  onChange="getMembership(this.value)">  
                        <option value=""> Select Membership</option>
                        <?php
                           /* $select_category = "select membership_id,membership_name from membership order by membership_id desc";
                            $ptr_category = mysql_query($select_category);
							
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['membership_id'] == $row_record['membership_id'])
                                    echo '<option value='.$data_category['membership_id'].' selected="selected">'.$data_category['membership_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['membership_id'].'>'.$data_category['membership_name'].'</option>';
                            }*/
                            ?>
                                   
                    </select>
             </td> 
              <td width="10%"></td>

            </tr>-->
           	<tr>
           		<td>Selling Amounts:</td>
                <td><input type="text" name="amount"  id="amount" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount'];?>" required/></td><!--onKeyUp="show_tax(this.value)"-->
         	</tr>
            <!--<tr>
           		<td>Redeamable Amount:</td>
                <td><input type="text" name="redeam_amount" id="redeam_amount" value="<?php //if($_POST['redeam_amount']) echo $_POST['redeam_amount']; else echo $row_record['redeam_amount'];?>" required/></td>
         	</tr>-->
             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Package" name="save_changes"  /></td>
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
<script language="javascript">
create_floor('add');

branch_name =document.getElementById("branch_name").value;
//alert(branch_name);
show_bank(branch_name);
</script>
</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>