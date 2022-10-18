<?php //include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<?php //require 'PHPMailer-5.2.14/class.phpmailer.php';

	//$email_id='waghshital.12@gmail.com';
	//$subject='Hi this is test smtp mail';
	
	$mail = new PHPMailer(true);
	try {
		//$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->SMTPDebug=1;   
		$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'ajaymahadik60@gmail.com';                   // SMTP username
        $mail->Password = '9975988948';                            // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
		$mail->Port = 465;
		
		$mail->setFrom('info@ISAS-pune.com', 'ISAS');     //Set who the message is to be sent from
		//$mail->addReplyTo('waghshital.12@gmail.com', 'First Last');  //Set an alternative reply-to address
		
		if($_POST['action']=='add_inventoryy')
		{
			//$inq_mail=$_POST['mail'];
			//$mail->addAddress("$inq_mail");
			$users_mail='';
			if(trim($_POST['users_mail']) !='')
			{
				$users_mail=explode(',',$_POST['users_mail']);
				//print_r($users_mail);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					if($i==0)
					$mail->addAddress("isasoceanone@gmail.com");
					else
					$mail->addBCC("$emails"); 
				}
			}
			//$mail->addBCC($_POST['mail']); 
			$mail->Subject = 'Inventory added for branch '. $_POST['branch_name'] .' for vendor : ';
			$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['vendor_id'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Vendor/b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vendor_id'].'</font><br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['ref_invoice_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Referal Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['ref_invoice_no'].'</font><br></td>
                    </tr></table>';
					}
					
					
					if($_POST['total_service'])
					{
					
					$message.= '<table cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Product Name</b></td>
									<td width="15%" align="left"><b>Price</b></td>
									<td width="15%" align="left"><b>Product Qty</b></td>
									<td width="15%" align="left"><b>Discount</b></td>
									<td width="15%" align="left"><b>Total Price</b></td>
									<td width="15%" align="left"><b>Staff Name</b></td></tr>';
						for($i=1;$i<=$_POST['total_service'];$i++)
						{
						
            
						     
									$message.= '<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['product_id'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_price'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_qty'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_disc'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['sin_product_total'.$i].'</font><br></td>
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['staff_id'.$i].'</font><br></td>
									</tr>';
								
							 	
                         }
						  $message.='</table>';
					  }
					
					
					
				
					
					if($_POST['price'])
                    {
					$message.= '<table colspan="2" cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;">
                    <tr>
					<td width="15%" align="left"><b>Product Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['discount_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount_price'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total_cost'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Cost</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_cost'].'</font><br></td>
                    </tr></table>';
					}
					
					if($_POST['type1'])
					{
					
					$message.= '<table colspan="2" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
						         	<tr>
									<td width="15%" align="left"><b>Tax Type</b></td>
									<td width="15%" align="left"><b>Tax Value(in %)</b></td>
									</tr>';
									
						for($i=1;$i<=$_POST['type1'];$i++)
						{
						
            
						     
									$message.= '
						         	<tr>
								<td width="15%" align="left"><font color="#FF0000">'.$_POST['tax_type'.$i].'</font><br></td>
							
							<td width="15%" align="left"><font color="#FF0000">'.$_POST['tax_value'.$i].'</font><br></td>
									</tr>';
								
							 	
                         }
						 $message.='</table>';
					  }
					
					if($_POST['payment_mode'])
                    {
					$message.= '<table colspan="2" cellpadding="6" align="left" cellspacing="6" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_mode'].'</font><br></td>
                    </tr>';
					}
					if($_POST['bank_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Chaque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cheque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cheque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_details'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Details</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_details'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_start_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Start Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_start_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_end_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers End Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_end_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['vouchers_price'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Vouchers Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['vouchers_price'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['amount1'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount1'].'</font><br></td>
                    </tr>';
					}
					if($_POST['payable_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payable Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payable_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					$message.='<tr></tr></table>';
		}
		
		
		
		
		
		
	
		
	
				//$inq_mail=$_POST['mail'];
				//$mail->addAddress("$inq_mail");
				$users_mail=explode(',',$_POST['users_mail']);
				print_r($users_mail);
				for($i=0;$i<count($users_mail);$i++)
				{
					$emails=$users_mail[$i];
					$mail->addBCC("$emails"); 
				}
		     	//$mail->addBCC($_POST['mail']); 
				$mail->Subject = 'Customer Installment Payment done of '. $_POST['customer_name'] .'';
				$message= '
             		<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;background-color:#98bb49 " >
					
					<tr>
					<td colspan="2" align="left" style="color:black;"><h2>Isasbeautyschool.com Messages</h2></td>
                    </tr></table>';
				
					if($_POST['branch_name'])
					{
                    $message.= '<table cellpadding="3" align="left" cellspacing="3" width="100%" border="1" style="border-collapse: collapse;" >
                    <tr>
					<td width="15%" align="left"><b>Branch</b></td>
                    <td width="85%" align="left">'.$_POST['branch_name'].'<br></td>
                    </tr>';
					}
					if($_POST['invoice_no'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Invoice No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['invoice_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['customer_name'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['customer_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['total'])
					{
                    $message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Service Price</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['discount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Discount in (%)</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['discount'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['final_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Final Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['final_amt'].'</font><br></td>
                    </tr>';
					}
					
					
					if($_POST['total_paid_amt'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Total Paid Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['total_paid_amt'].'</font><br></td>
                    </tr>';
					}
					if($_POST['balance_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['balance_amount'].'</font><br></td>
                    </tr>';
					}
					if($_POST['amount_paid'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Deposite Amount</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['amount_paid'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['payment_type'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Payment Mode</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['payment_type'].'</font><br></td>
                    </tr>';
					}
					if($_POST['cust_bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Customer Bank Name</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['cust_bank_name'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['bank_name'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Bank</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['bank_name'].'</font><br></td>
                    </tr>';
					}
					if($_POST['account_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Account No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['account_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['chaque_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_no'].'</font><br></td>
                    </tr>';
					}
					
					if($_POST['chaque_date'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Cheque Date</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['chaque_date'].'</font><br></td>
                    </tr>';
					}
					if($_POST['credit_card_no'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Credit Card No</b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['credit_card_no'].'</font><br></td>
                    </tr>';
					}
					if($_POST['remaining_amount'])
                    {
					$message.= '
                    <tr>
					<td width="15%" align="left"><b>Remaining </b></td>
                    <td width="85%" align="left"><font color="#FF0000">'.$_POST['remaining_amount'].'</font><br></td>
                    </tr>';
					}
					
					
					
					
					  $message.='<tr></tr></table>';
		}
		
		$sendMessage=$GLOBALS['box_message_top'];
		$sendMessage.=$message;
		$sendMessage.=$GLOBALS['box_message_bottom'];
		//$sendMessage="Its kiran vyavahare";
		//$mail->addAddress('ajaymahadik60@gmail.com');
		//$mail->addCC('sudhirwithu@gmail.com');
		 $mail->WordWrap = 3000; 
		 $mail->isHTML(true);                                  // Set email format to HTML
		 $mail->Body    = $sendMessage;
		 
	
	$mail->Send();
  echo "Email Sent Successfully.";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
	?>
	