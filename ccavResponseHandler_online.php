<?php include 'inc_classes.php';?>
<?php

include('Crypto.php')?>

<?php

	error_reporting(0);
	
	$workingKey='D0B286D32E02E22C5CAC77E5C8E50262';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	//echo $rcvdString;
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		
		if($i==3)	$order_status=$information[1];
		
	}
	$od_id=explode('=', $decryptValues[0]);
	$order_id=$od_id[1] ;
	
	$ref_id=explode('=', $decryptValues[1]);
	$ccavenue_reference_id=$ref_id[1] ;
	
	$bank_ref_id1=explode('=', $decryptValues[2]);
	$bank_ref_id=$bank_ref_id1[1] ;
	
	$paymode_id=explode('=', $decryptValues[5]);
	$paymode=$paymode_id[1] ;
	
	$card_name=explode('=', $decryptValues[6]);
	$card_name=$card_name[1] ;
	
	
	$payment_id=explode('=', $decryptValues[35]);
	$payment=$payment_id[1] ;
	
	
	if($order_status==="Success")
	{
		echo "<br> Success. Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		
		$update_invoice="update invoice set status='paid' where invoice_id='$order_id'";
		$ptr_query=mysql_query($update_invoice);
		
		$insert_online_trans_details="insert into online_trans_details (`order_id`,`ccavenue_reference_id`,`paymode`,`bank_ref_id`,`payment`,`status`,`added_date`,`bank_name`) values('$order_id','$ccavenue_reference_id','$paymode','$bank_ref_id','$payment','paid','".date('Y-m-d H:i:s')."','$card_name')";
		$ptr_query_insert=mysql_query($insert_online_trans_details);
		
		 $sele_course_id="select course_id,enroll_id from invoice where invoice_id='$order_id'";
		$ptr_course_id=mysql_query($sele_course_id);
		$data_id=mysql_fetch_array($ptr_course_id);
		
		 $sel_course="select course_name from courses where course_id='".$data_id['course_id']."'";
		$ptr_course=mysql_query($sel_course);
		$data_array=mysql_fetch_array($ptr_course);
		 $course_name=$data_array['course_name'];
		
		 $sel_mail="select mail from enrollment where enroll_id='".$data_id['enroll_id']."'";
		$ptr_mail=mysql_query($sel_mail);
		$data_mail=mysql_fetch_array($ptr_mail);
		 $mail=$data_mail['mail'];
		
		$invoice_subject = " Invoice for the course '$course_name' enrollment  at isasbeautyschool.com on ".date('d/m/Y H:i:s') ;
													
		$invoice_to = $mail;
		
		$msg_body = file_get_contents('http://www.isasbeautyschool.com/faculty_login/invoice-generate.php?record_id='.$order_id.'&for=email');
		
		$sendMessage=$msg_body;
		
		$from_id='info<info@'.$GLOBALS['domainName'].'>';
		$headers= 'MIME-Version: 1.0' . "\n";
		$headers.='Content-type: text/html; charset=utf-8' . "\n";
		$headers.='From:'.$from_id;
		mail($invoice_to, $invoice_subject, $sendMessage, $headers);
		
		
		mail('sudhir.pawar@waakan.com', $invoice_subject, $sendMessage, $headers);
		
		?>
		<script>
        window.open('invoice-generate.php?record_id=<?php echo $order_id; ?>', 'win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no');
        </script>
        <?php
        ?><script>
       setTimeout('document.location.href="../index.php";',4000);
        </script>
        <?php
		
	}
	else if($order_status==="Aborted")
	{
		echo "<br> Aborted. Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
		
		$update_invoice="update invoice set status='Aborted' where invoice_id='$order_id'";
		$ptr_query=mysql_query($update_invoice);
		
		$insert_online_trans_details="insert into online_trans_details (`order_id`,`ccavenue_reference_id`,`paymode`,`bank_ref_id`,`payment`,`status`,`added_date`,`bank_name`) values('$order_id','$ccavenue_reference_id','$paymode','$bank_ref_id','$payment','Aborted','".date('Y-m-d H:i:s')."','$card_name')";
		$ptr_query_insert=mysql_query($insert_online_trans_details);
		?>
		<script>
        window.open('invoice-generate.php?record_id=<?php echo $order_id; ?>', 'win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no');
        </script>
        <?php
        ?><script>
      setTimeout('document.location.href="../index.php";',4000);
        </script>
        <?php
	
	} 
	else if($order_status==="Failure")
	{
		echo "<br>Failure .Thank you for shopping with us.However,the transaction has been declined.";
		
		$update_invoice="update invoice set status='Failure' where invoice_id='$order_id'";
		$ptr_query=mysql_query($update_invoice);
		
		$insert_online_trans_details="insert into online_trans_details (`order_id`,`ccavenue_reference_id`,`paymode`,`bank_ref_id`,`payment`,`status`,`added_date`,`bank_name`) values('$order_id','$ccavenue_reference_id','$paymode','$bank_ref_id','$payment','Failure','".date('Y-m-d H:i:s')."','$card_name')";
		$ptr_query_insert=mysql_query($insert_online_trans_details);
		?>
		<script>
        window.open('invoice-generate.php?record_id=<?php echo $order_id; ?>', 'win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no');
        </script>
        <?php
        ?><script>
        setTimeout('document.location.href="../index.php";',4000);
        </script>
        <?php
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	//for($i = 8; $i <= 8; $i++) 
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";
?>
