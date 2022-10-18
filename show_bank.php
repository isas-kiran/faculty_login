<?php session_start();
include 'inc_classes.php';
if($_POST['branch_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	$action_for=$_POST['action_for'];
	if($_POST['action_for']=="for_credit_card")
	{
		$payment_type=$_POST['payment_type'];
		$branch_id = $_POST['branch_id'];
		$action= $_POST['action'];
		$record_id=$_POST['record_id'];
		$pay_type='';
		$selected='';
		$readon='';
		$sele='';
		$payment_id=$_POST['payment_id'];
		if($payment_type=="credit_card")
		{
			//$pay_type=" and is_credit_card='yes'";
			//$sele='selected="selected"';
			//$readon='readonly';
		}
		
		echo '<select name="cc_bank_name" class="input_text" style="width:200px" id="cc_bank_name" onchange="show_acc_no(this.value)" '.$readon.'>';
		echo '<option value="">--Select--</option>';
		$sel_cm_id= "select cm_id from site_setting where branch_name='".$branch_id."' and type='A'";
		$ptr_cm_id=mysql_query($sel_cm_id);
		$data_cm_id=mysql_fetch_array($ptr_cm_id);
		
		$sle_bank_name="select b.bank_id,b.bank_name,b.is_credit_card,b.is_paytm from bank b, bank_payment_map bp where b.bank_id = bp.bank_id and bp.payment_mode_id='".$payment_id."' and b.cm_id='".$data_cm_id['cm_id']."' and b.status='Active' "; //".$pay_type."
		$ptr_bank_name=mysql_query($sle_bank_name);
		if(mysql_num_rows($ptr_bank_name))
		{
			while($data_bank=mysql_fetch_array($ptr_bank_name))
			{
				/*$selected='';
				if($data_bank['is_credit_card']=="yes" && $payment_type=="credit_card" && $record_id=='')
				{
					$selected='selected="selected"';
				}*/
				if($action=="expense")
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
				echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
			 }
		}
		echo'</select>';
		unset($_SESSION['selected_bank']);
	}
	else if($action_for=="from_bank")
	{
		$payment_type=$_POST['payment_type'];
		$branch_id = $_POST['branch_id'];
		$action= $_POST['action'];
		$record_id=$_POST['record_id'];
		$pay_type='';
		$selected='';
		$readon='';
		$sele='';
		if($payment_type=="credit_card")
		{
			//$pay_type=" and is_credit_card='yes'";
			//$sele='selected="selected"';
			//$readon='readonly';
		}
		else if($payment_type=="paytm")
		{
			$pay_type=" and is_paytm='yes'";
			$sele='selected="selected"';
		}
		
		echo '<select name="from_bank_name" class="input_text" style="width:200px" id="from_bank_name" onchange="show_acc_no_to(this.value)" '.$readon.'>';
		echo '<option value="">--Select--</option>';
		$sel_cm_id= "select cm_id from site_setting where branch_name='".$branch_id."' and type='A'";
		$ptr_cm_id=mysql_query($sel_cm_id);
		$data_cm_id=mysql_fetch_array($ptr_cm_id);
		
		$sle_bank_name="select bank_id,bank_name,is_credit_card,is_paytm from bank where status='Active' and cm_id='".$data_cm_id['cm_id']."' ".$pay_type." "; //".$pay_type."
		$ptr_bank_name=mysql_query($sle_bank_name);
		if(mysql_num_rows($ptr_bank_name))
		{
			while($data_bank=mysql_fetch_array($ptr_bank_name))
			{
				$selected='';
				if($data_bank['is_credit_card']=="yes" && $payment_type=="credit_card" && $record_id=='')
				{
					$selected='selected="selected"';
				}
				if($data_bank['is_paytm']=="yes" && $payment_type=="paytm" && $record_id=='')
				{
					$selected='selected="selected"';
				}
				 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
			 }
		}
		echo'</select>';
		unset($_SESSION['selected_bank']);
	}
	else
	{
		$payment_type=$_POST['payment_type'];
		$branch_id = $_POST['branch_id'];
		$action= $_POST['action'];
		$record_id=$_POST['record_id'];
		$pay_type='';
		$selected='';
		$readon='';
		$sele='';
		if($payment_type=="credit_card")
		{
			//$pay_type=" and is_credit_card='yes'";
			//$sele='selected="selected"';
			//$readon='readonly';
		}
		else if($payment_type=="paytm")
		{
			$pay_type=" and is_paytm='yes'";
			$sele='selected="selected"';
		}
		
		echo '<select name="bank_name" class="input_text" style="width:200px" id="bank_name" onchange="show_acc_no(this.value)" '.$readon.'>';
		echo '<option value="">--Select--</option>';
		$sel_cm_id= "select cm_id from site_setting where branch_name='".$branch_id."' and type='A'";
		$ptr_cm_id=mysql_query($sel_cm_id);
		$data_cm_id=mysql_fetch_array($ptr_cm_id);
		
		$sle_bank_name="select bank_id,bank_name,is_credit_card,is_paytm from bank where status='Active' and cm_id='".$data_cm_id['cm_id']."' ".$pay_type." ";
		$ptr_bank_name=mysql_query($sle_bank_name);
		if(mysql_num_rows($ptr_bank_name))
		{
			while($data_bank=mysql_fetch_array($ptr_bank_name))
			{
				$selected='';
				if($data_bank['is_credit_card']=="yes" && $payment_type=="credit_card" && $record_id=='')
				{
					$selected='selected="selected"';
				}
				if($data_bank['is_paytm']=="yes" && $payment_type=="paytm" && $record_id=='')
				{
					$selected='selected="selected"';
				}
	
				if($action=="service")
				{
					$sel="select bank_id from customer_service where customer_service_id='".$record_id."'";
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
				else if($action=="inventory")
				{
					$sel_inv="select bank_id from inventory_invoice where inventory_id='".$record_id."'";
					$ptr_inv=mysql_query($sel_inv);
					if(mysql_num_rows($ptr_inv))
					{
						$row_record=mysql_fetch_array($ptr_inv);
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
}
?>