<?php include 'inc_classes.php';

	$bank_id=$_REQUEST['bank_id'];
	$sel_bank = "select account_no from bank where bank_id='".$bank_id."' ";
	$execute_bank = mysql_query($sel_bank);
	$account_no= mysql_fetch_array($execute_bank);
	echo $account_no['account_no'];


?>