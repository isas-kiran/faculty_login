<?php session_start();
include 'inc_classes.php';
if($_POST['branch_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	$payment_type=$_POST['payment_type'];
	$branch_id = $_POST['branch_id'];
	$action= $_POST['action'];
	$record_id=$_POST['record_id'];
	$pay_type='';
	$selected='';
	
	$sele='';
	if($payment_type=="credit_card")
	{
		$pay_type=" and is_credit_card='yes'";
		$sele='selected="selected"';
	}
	else if($payment_type=="paytm")
	{
		$pay_type=" and is_paytm='yes'";
		$sele='selected="selected"';
	}
	
	echo '<select name="bank_name" id="bank_name" onchange="show_acc_no(this.value)">';
	echo '<option value="select">--Select--</option>';
	$sel_cm_id= "select cm_id from site_setting where branch_name='".$branch_id."' and type='A'";
	$ptr_cm_id=mysql_query($sel_cm_id);
	$data_cm_id=mysql_fetch_array($ptr_cm_id);
	
	"<br/>".$sle_bank_name="select bank_id,bank_name from bank where cm_id='".$data_cm_id['cm_id']."' ".$pay_type.""; 
	$ptr_bank_name=mysql_query($sle_bank_name);
	if(mysql_num_rows($ptr_bank_name))
	{
		while($data_bank=mysql_fetch_array($ptr_bank_name))
		{
			$selected=$sele;
			if($action=="service")
			{
				echo $sel="select bank_id from customer_service where customer_service_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			else if($action=="receipt")
			{
				$sel="select bank_id from receipt where receipt_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			else if($action=="expense")
			{
				$sel="select bank_id from expense where expense_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			else if($action=="enroll")
			{
				$sel="select bank_name from invoice where enroll_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_name'])
					{
						$selected='selected="selected"';
					}
				}
			}
			
			else if($action=="prod_payment")
			{
				$sel="select bank_id from sales_product_invoice where sales_product_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			
			else if($action=="view_payment")
			{
				$sel="select bank_id from invoice where enroll_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			else if($action=="customer")
			{
				$sel="select bank_id from customer where cust_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			else if($action=="customer_memb")
			{
				$sel="select bank_id from customer_membership_map where receipt_id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			else if($action=="sale_package_memb_voucher")
			{
				$sel="select bank_id from sales_package_voucher_memb where id='".$record_id."'";
				$ptr_data=mysql_query($sel);
				if(mysql_num_rows($ptr_data))
				{
					$row_record=mysql_fetch_array($ptr_data);
					if($data_bank['bank_id'] == $row_record['bank_id'])
					{
						$selected='selected="selected"';
					}
				}
			}
			/*if($_SESSION['selected_bank'] !='')
			{
				if($_SESSION['selected_bank']==$data_bank['bank_id'])
				$selected='selected="selected"';
			}*/
			 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
		 }
	}
	echo'</select>';
	unset($_SESSION['selected_bank']);
}

?>