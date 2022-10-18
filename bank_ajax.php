<?php include 'inc_classes.php';
 
    $action = $_POST['action'];
	if($action=='show_account')
	{
		$bank_id=$_POST['bank_id'];
		$sel_bank = "select account_no from bank where bank_id='".$bank_id."' ";
		$execute_bank = mysql_query($sel_bank);
		$account_no= mysql_fetch_array($execute_bank);
		echo $account_no['account_no'];
	}
//==========================================================================================================================================================
	if($action=='check_credit')
	{
		$bank_id=$_POST['bank_id'];
		$cm_id=$_POST['cm_id'];
		$sel_quantity = "select bank_id from bank where cm_id='".$cm_id."' ";
		$execute_quantity = mysql_query($sel_quantity);
		while($data_quantity= mysql_fetch_array($execute_quantity))
		{
			$update_query="update bank set is_credit_card='' where bank_id='".$data_quantity['bank_id']."'";
			$ptr_query=mysql_query($update_query);
		}
		$update_credit="update bank set is_credit_card='yes' where bank_id='".$bank_id."'";
		$ptr_credit=mysql_query($update_credit);
		
		if($ptr_credit)
			echo "success";
		else
			echo"error";
	}

//==========================================================================================================================================================
	if($action=='check_paytm')
	{
		$bank_id=$_POST['bank_id'];
		$cm_id=$_POST['cm_id'];
		$sel_quantity = "select bank_id from bank where cm_id='".$cm_id."' ";
		$execute_quantity = mysql_query($sel_quantity);
		while($data_quantity= mysql_fetch_array($execute_quantity))
		{
			$update_query="update bank set is_paytm='' where bank_id='".$data_quantity['bank_id']."'";
			$ptr_query=mysql_query($update_query);
		}
		$update_paytm="update bank set is_paytm='yes' where bank_id='".$bank_id."'";
		$ptr_paytmr=mysql_query($update_paytm);
		if($ptr_paytmr)
			echo "success";
		else
			echo"error";
	}

//==========================================================================================================================================================
	if($action=='check_voucher')
	{
		$bank_id=$_POST['bank_id'];
		$cm_id=$_POST['cm_id'];
		$sel_quantity = "select bank_id from bank where cm_id='".$cm_id."' and bank_id !='".$bank_id."' ";
		$execute_quantity = mysql_query($sel_quantity);
		while($data_quantity= mysql_fetch_array($execute_quantity))
		{
			$update_query="update bank set is_voucher='' where bank_id='".$data_quantity['bank_id']."'";
			$ptr_query=mysql_query($update_query);
		}
		$update_voucher="update bank set is_voucher='yes' where bank_id='".$bank_id."'";
		$ptr_voucher=mysql_query($update_voucher);
		if($ptr_voucher)
			echo "success";
		else
			echo"error";
	}
//=========================================================================================================================================================
