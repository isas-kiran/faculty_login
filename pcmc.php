<?php include 'inc_classes.php';?>
<?php
//===========================================ISAS PCMC============================================
$id=$_REQUEST['id'];
if($id!="")
{

	$data_record_ahm['vendor_id']="53";
	$cm_ids="115";//PCMC
	$data_record_ahm['cm_id']=$cm_ids;
	
	$sel_sale="select * from sales_product where sales_product_id='".$id."'";
	$ptr_sal=mysql_query($sel_sale);
	$data_sale=mysql_fetch_array($ptr_sal);
	
	//===========================================================
	$data_record_ahm['product_id']="0";
	$product_price=$data_sale['product_price'];
	$total_price=$data_sale['total_price'];
	$data_record_ahm['price']=$data_sale['product_price'];
	$data_record_ahm['discount_type']=$data_sale['discount_type'];
	$data_record_ahm['discount']=$data_sale['discount'];
	$data_record_ahm['discount_price']=$data_sale['discount_price'];
	$data_record_ahm['total_cost']=$data_sale['total_price'];
	$data_record_ahm['payment_mode_id'] =$data_sale['payment_mode_id'];
	$data_record_ahm['chaque_no'] =$data_sale['chaque_no'];
	$data_record_ahm['chaque_date'] =$data_sale['chaque_date'];
	$data_record_ahm['credit_card_no'] =$data_sale['credit_card_no'];
	$data_record_ahm['bank_id'] =$data_sale['bank_id'];
	$data_record_ahm['amount1'] = $data_sale['total_price'];
	$data_record_ahm['admin_id']="118";
	$data_record_ahm['payable_amount']=$data_sale['payable_amount'];
	$data_record_ahm['remaining_amount']=$data_sale['remaining_amount'];
	//$data_record['ref_invoice_no']=$ref_invoice_no;
	$data_record_ahm['added_date'] =$data_sale['added_date'];
	$inventory_id=$db->query_insert("inventory", $data_record_ahm);
	
	$sel_inv="select * from sales_product_map where sales_product_id='".$id."'";
	$ptr_inv=mysql_query($sel_inv);
	while($data_record_service=mysql_fetch_array($ptr_inv))
	{
		if(trim($data_record_service['product_id']) !='')
		{
						
			$data_record_service_inv['inventory_id'] =$inventory_id; 
			$product_id=$data_record_service['product_id'];
			$data_record_service_inv['sin_product_price']=$data_record_service['prod_price'];
			$data_record_service_inv['sin_product_disc']=$data_record_service['product_disc'];
			$data_record_service_inv['sin_prod_disc_price']=$data_record_service['base_prod_price'];
			$data_record_service_inv['sin_product_total']=$data_record_service['sales_product_price'];
			$data_record_service_inv['sin_product_qty']=$data_record_service['product_qty'];
			$data_record_service_inv['cgst_tax_in_per'] =$data_record_service['cgst_tax_in_per'];
			$data_record_service_inv['cgst_tax'] =$data_record_service['cgst_tax'];
			$data_record_service_inv['sgst_tax_in_per'] =$data_record_service['sgst_tax_in_per'];
			$data_record_service_inv['sgst_tax'] =$data_record_service['sgst_tax'];
			$data_record_service_inv['igst_tax_in_per'] =$data_record_service['igst_tax_in_per'];
			$data_record_service_inv['igst_tax'] =$data_record_service['igst_tax'];
			
			"<br/>".$sel_admin_id="select `admin_id` from `site_setting` where `cm_id`='".$cm_id1."' and `type`='ST'";
			$ptr_admin_id=mysql_query($sel_admin_id);
			$data_cm_id=mysql_fetch_array($ptr_admin_id);
			
			"<br/>".$sel_product_name=" select product_name,product_code,pcategory_id,sub_id,size,unit,commission,price,vender,type,added_date,cm_id,quantity,admin_id from product where product_id='".$product_id."' ";
			$ptr_names=mysql_query($sel_product_name);
			if(mysql_num_rows($ptr_names))
			{
				$data_product=mysql_fetch_array($ptr_names);
																
				"<br/>".$sele_cate="select product_id from product where product_name='".$data_product['product_name']."' and cm_id='".$cm_ids."' ";
				$ptr_sele_catte=mysql_query($sele_cate);
				if(mysql_num_rows($ptr_sele_catte))
				{
					$data_product_id=mysql_fetch_array($ptr_sele_catte);
					$data_record_service_inv['product_id']=$data_product_id['product_id'];
					
					 "<br/>".$update_products1="update `product` set `quantity`=(quantity+".$data_record_service_inv['sin_product_qty'].") where `product_id`='".$data_record_service_inv['product_id']."' and cm_id='".$cm_ids."'  ";
					$query_update=mysql_query($update_products1);
				}
				else
				{
					//echo "<br/>hi..";
					"<br/>1".$sel_category="select pcategory_name from product_category where pcategory_id='".$data_product['pcategory_id']."'";
					$ptr_category=mysql_query($sel_category);
					$data_cate=mysql_fetch_array($ptr_category);
					
					"<br/>2".$sel_subcategory1="select sub_name from product_subcategory where sub_id='".$data_product['sub_id']."'";
					$ptr_subcategory1=mysql_query($sel_subcategory1);
					$data_subcategory=mysql_fetch_array($ptr_subcategory1);
					
					"<br/>3".$sele_cateahm="select pcategory_id from product_category where pcategory_name='".$data_cate['pcategory_name']."' and cm_id='".$cm_ids."' order by  pcategory_id asc";
					$ptr_sele_ahmcatte=mysql_query($sele_cateahm);
					if(mysql_num_rows($ptr_sele_ahmcatte))
					{
						$data_ahm_cat=mysql_fetch_array($ptr_sele_ahmcatte);
						$cat_id=$data_ahm_cat['pcategory_id'];
					}
					else
					{
						"<br/>4".$insert_cat="insert into product_category (`pcategory_name`,`added_date`,`cm_id`,`admin_id`) values('".$data_cate['pcategory_name']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
						$ptr_ins_cat=mysql_query($insert_cat);
						$cat_id=mysql_insert_id();
					}
					
					"<br/>5".$sele_subcateahm="select sub_id from product_subcategory where sub_name='".$data_subcategory['sub_name']."' and cm_id='".$cm_ids."' order by  sub_id asc";
					$ptr_sele_subcatte=mysql_query($sele_subcateahm);
					if(mysql_num_rows($ptr_sele_subcatte))
					{
						$data_ahm_subcat=mysql_fetch_array($ptr_sele_subcatte);
						$sub_cat_id=$data_ahm_subcat['sub_id'];
					}
					else
					{
						"<br/>6".$insert_subcat="insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values('".$data_subcategory['sub_name']."','".$cat_id."','".$cm_ids."','".$data_record_ahm['admin_id']."')";
						$ptr_ins_subcat=mysql_query($insert_subcat);
						$sub_cat_id=mysql_insert_id();
					}
																
					"<br/>7".$inser_prod="insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`size`,`unit`,`commission`,`price`,`type`,`added_date`,`cm_id`,`quantity`,`admin_id`) values ('".$data_product['product_name']."','".$data_product['product_code']."','".$cat_id."','".$sub_cat_id."','".$data_product['size']."','".$data_product['unit']."','".$data_product['commission']."','".$data_product['price']."','".$data_product['type']."','".date('Y-m-d H:i:s')."','".$cm_ids."','".$data_record_service_inv['sin_product_qty']."','".$data_record_ahm['admin_id']."')";
					$ptr_mysql_prod=mysql_query($inser_prod);
					$product_ids=mysql_insert_id();
					$data_record_service_inv['product_id']=$product_ids;
				}
			}
			$data_record_service_inv['admin_id']=$data_record_ahm['admin_id'];
			$customer_service_id=$db->query_insert("inventory_product_map", $data_record_service_inv);
			
			$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
			$ptr_qty=mysql_query($sel_qty);
			$data_qty=mysql_fetch_array($ptr_qty);
			
		}
	}
	for($j=1;$j<=$total_type1;$j++)
	{
		$data_record_tax_inv['inventory_id'] =$record_id; 
		$data_record_tax_inv['tax_type'] =$_POST['tax_type'.$j];
		$data_record_tax_inv['tax_value'] =$_POST['tax_value'.$j];
		$data_record_tax_inv['tax_amount']=$_POST['tax_amount'.$j];
		$customer_tax_id=$db->query_insert("inventory_tax_map", $data_record_tax_inv);
	}
	
			
	if($payment_type_val=="online")
	$status='pending';
	else
	$status='paid';
	
	if($chaque_date !='')
	{
		$chaque_date_exp=explode('/', $chaque_date);
		$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
	}
	else
	{
		$sep_check_date='';
	}
	"<br/>".$insert_sales_invoice = " INSERT INTO `inventory_invoice` (`inventory_id`, `price`, `total_cost`, `amount1`, `payable_amount`,`remaining_amount`, `paid_type`, `bank_id`, `cheque_detail`, `chaque_date`, `credit_card_no`, `admin_id`, `added_date`,`status`,`cm_id`,`total_paid`) VALUES ('".$inventory_id."', '".$product_price."', '".$total_price."', '".$data_sale['total_price']."', '".$data_sale['payable_amount']."','".$data_sale['remaining_amount']."', '".$data_sale['payment_mode_id']."','".$data_sale['bank_id']."', '".$data_sale['chaque_no']."', '".$data_sale['chaque_date']."','".$data_sale['credit_card_no']."', '".$data_record_ahm['admin_id']."','".$data_sale['added_date']."','pending','".$cm_ids."','".$data_sale['payable_amount']."'); ";
	$ptr_sales_invoice = mysql_query($insert_sales_invoice);
	
	echo "record added successfully";
	//============================================================================
	$sel_cust="select name,contact from vendor where vendor_id ='".$data_record_ahm['vendor_id']."'";
	$ptr_cus_name=mysql_query($sel_cust);
	$data_cust_name=mysql_fetch_array($ptr_cus_name);
	$name=$data_cust_name['name'];
	$contact=$data_cust_name['contact'];
	$mesg ="Hi ".$name." Thanks for purchasing our service";
	$sel_inq="select sms_text from previleges where privilege_id='136'";
	$ptr_inq=mysql_query($sel_inq);
	$txt_msg='';
	if(mysql_num_rows($ptr_query))
	{
		$dta_msg=mysql_fetch_array($ptr_inq);
		$txt_msg=$dta_msg['sms_text'];
	}
}
else
{
	echo "Please add Sales id in URL";	
}
?>