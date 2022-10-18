<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Mail Singhgad</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>

    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
</head>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php'; ?>
<?php
$branch_id= "and cm_id = '174'";
$cm_id1= '174';

?>
<script>
/*function send_emil_to_oceanone(email_id,subject,message,headers)
{
	//alert(email_id);
	var data12="send_email=yes&email_id='"+email_id+"'&subject="+subject+"&body_message="+message+"&header="+headers;
	//alert(data12);
	$.ajax({
            url: "http://htdpt.in/universal/solar_heater/send_email.php", type: "post", data: data12, cache: false,
            success: function (retrive_func)
            {
				
				 //alert(retrive_func);
			},
        error: function (jqXHR, exception) {
            getErrorMessage(jqXHR, exception);
        },	
    		
		});
}*/
function getErrorMessage(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    alert(msg);
}
</script>

<script>
mail1=Array();
var email_text_msg='';
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='103' and cm_id='".$cm_id1."'";
$ptr_sel_sms=mysql_query($sel_sms_cnt);
$tot_num_rows=mysql_num_rows($ptr_sel_sms);
$i=0;
while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
{
	"<br/>".$sel_act=" select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and cm_id='".$cm_id1."' ";
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
	"<br/>".$sel_act="select contact_phone,email from site_setting where type='S'";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$j=$tot_num_rows;
		while($data_cnt=mysql_fetch_array($ptr_cnt))
		{
			?>
			mail1[<?php echo $j; ?>]='<?php echo  $data_cnt['email'];?>';
			<?php
			$j++;
		}
	}
}
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='103'";
$ptr_mail_text=mysql_query($sel_mail_text);
if($tot_mail_text=mysql_num_rows($ptr_mail_text))
{
	$data_mail_text=mysql_fetch_array($ptr_mail_text);
	?>
	var email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
	<?php
}
?>
//alert(mail1);
function send()
{		//alert('hi');						  
	/*var branch_name =document.getElementById('branch_name').value;
	vendor=document.getElementById('vendor_id');
	vendor_id=vendor.options[vendor.selectedIndex].text;
	var invoice_no =document.getElementById('invoice_no').value;
	var ref_invoice_no =document.getElementById('ref_invoice_no').value;
	var total_service =document.getElementById('no_of_floor').value;
	concat_string='';
	for(i=1; i<=total_service; i++)
	{
		
		product = document.getElementById('product_id'+i);
		product_id = product.options[product.selectedIndex].text;
		sin_product_price =document.getElementById('sin_product_price'+i).value;
		sin_product_qty =document.getElementById('sin_product_qty'+i).value;
		sin_product_disc =document.getElementById('sin_product_disc'+i).value;
		sin_product_total =document.getElementById('sin_product_total'+i).value;
		staff =document.getElementById('staff_id'+i);
		staff_id = staff.options[staff.selectedIndex].text;
		concat_string +='&product_id'+i+'='+product_id+'&sin_product_price'+i+'='+sin_product_price+'&sin_product_qty'+i+'='+sin_product_qty+'&sin_product_disc'+i+'='+sin_product_disc+'&sin_product_total'+i+'='+sin_product_total+'&staff_id'+i+'='+staff_id;
	}
	var price =document.getElementById('price').value;
	var discount =document.getElementById('discount').value;
	var discount_price =document.getElementById('discount_price').value;
	var total_cost =document.getElementById('total_cost').value;
	var type1 =document.getElementById('type1').value;
	concat_string_tax='';
	for(j=1; j<=type1; j++)
	{
		
		tax =document.getElementById('tax_type'+j);
		tax_type = tax.options[tax.selectedIndex].text;
		tax_value =document.getElementById('tax_value'+j).value;
		concat_string_tax +='&tax_type'+j+'='+tax_type+'&tax_value'+j+'='+tax_value;
	}
	
	var payment=document.getElementById('payment_mode');
	payment_mode = payment.options[payment.selectedIndex].text;
	
	
	bank='';
	bank_details='';
	account_no='';
	chaque_details='';
	cheque_date='';
	credit_details='';
	if(document.getElementById('bank_name'))
	{
	var bank=document.getElementById('bank_name');
	bank_details=bank.options[bank.selectedIndex].text;
	var account_no =document.getElementById('account_no').value;
	var chaque_details =document.getElementById('chaque_no').value;
	var cheque_date =document.getElementById('cheque_date').value;
}
	var amount1 =document.getElementById('amount1').value;
	var payable_amount =document.getElementById('payable_amount').value;
	var remaining_amount =document.getElementById('remaining_amount').value;
	var users_mail=mail1;*/
	
	/*data1='action=add_inventoryy&branch_name='+branch_name+'&vendor_id='+vendor_id+'&invoice_no='+invoice_no+'&ref_invoice_no='+ref_invoice_no+'&price='+price+'&discount='+discount+'&discount_price='+discount_price+'&total_cost='+total_cost+'&payment_mode='+payment_mode+'&bank_details='+bank_details+'&account_no='+account_no+'&chaque_details='+chaque_details+'&cheque_date='+cheque_date+'&credit_card_no='+credit_card_no+'&amount1='+amount1+'&payable_amount='+payable_amount+'&remaining_amount='+remaining_amount+concat_string+concat_string_tax+'&total_service='+total_service+'&type1='+type1+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;*/
	
	var content =document.getElementById('mail_content').value;
	var users_mail=mail1;
	//alert(users_mail);
	data1='action=dsr_mail&mail_content='+content+"&users_mail="+users_mail+"&email_text_msg="+email_text_msg;
	$.ajax({
		url:'send_email.php',dataType: "jsonp",type:"post",data:data1,cache:false,
		success: function(response) {
			//alert(response);
		return true;
		},
    error: function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        //$('#post').html(msg);
    },
	});

}

</script>
<body>
<?php
/*if($_GET['baranch_id'] =='' )
{
	$branch_id= $_SESSION['where'];
	$cm_id1= $_SESSION['cm_id'];
	$branch_name='';
}
else
{*/
	
	$sel_branch_name="select branch_name from site_setting where cm_id=".$cm_id1." and type='A'";
	$ptr_branch_name=mysql_query($sel_branch_name);
	$data_branch=mysql_fetch_array($ptr_branch_name);
	$branch_name=" For ".$data_branch['branch_name']." branch";
	
	$date=date('Y-m-d');
	if($_REQUEST['date'] && $_REQUEST['date']!=="0000-00-00" && $_REQUEST['date']!="date")
	{
		$frm_date=explode("/",$_REQUEST['date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		
		$date=date('Y-m-d',strtotime($frm_dates));
	}
//}

/*
function send_emil_to_oceanone($email_id, $subject,$message, $headers)
{
	$data1="?send_email=yes&email_id=".urlencode($email_id)."&subject=".urlencode($subject)."&body_message=".urlencode($message)."&header=".urlencode($headers);	
	$url = "http://htdpt.in/universal/solar_heater/send_email.php".$data1;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$retval = curl_exec($ch);
	curl_close($ch);
	$retval;
}
*/
$message.=  '<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
<tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incomming Courses</strong></td>
  </tr>
  <tr>';
//===================Total receive balance===============================
	$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".$date."' ".$branch_id."";
	$ptr_total_inc=mysql_query($sel_total_inc);
	$data_total_inc=mysql_fetch_array($ptr_total_inc);
	
	/*$sel_total_inc2="select SUM(amount) as total_amt from receipt where added_date='".$date."' and category !='cash_transfer' and category !='voucher' ".$branch_id." ";
	$ptr_total_inc2=mysql_query($sel_total_inc2);
	$data_total_inc2=mysql_fetch_array($ptr_total_inc2);*/
	
	$total_todays_bal=$data_total_inc['total_amt']/*+$data_total_inc2['total_amt']*/; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
//==============================================================================
  
$message.=' <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> :'.$total_todays_bal.'</td> 
  </tr>';
						$select_directory='order by enroll_id asc';                      
						$sql_query= "SELECT * FROM enrollment where added_date='".$date."' ".$branch_id."  ".$pre_keyword." ".$select_directory.""; 
                      	$ptr_db=mysql_query($sql_query);
						$no_of_records=mysql_num_rows($ptr_db);
						$message.='<tr>
			<td colspan="10" >
				<table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 					<tr class="grey_td" style="background-color:#999;color: black">
						<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Sale Type</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Student Name</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Chaque No</strong></td>
						<td width="10%" style="border:1px solid #CCC"><strong>Amount</strong></td>
						</tr>';
						$ent=1; 
                        if($no_of_records)
                        {
							              
                            while($val_query=mysql_fetch_array($ptr_db))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['enroll_id']; 
                                
                                include "include/paging_script.php";
								$sql_invoice="select invoice_id,chaque_date,paid_type,bank_name,cheque_detail,amount from invoice where enroll_id='".$val_query['enroll_id']."' ".$branch_id."";
								$my_query_invoice=mysql_query($sql_invoice);
								$row_invoice= mysql_fetch_array($my_query_invoice);
								
                                $sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$row_invoice['paid_type']."'";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_bank="select bank_name,account_no from bank where bank_id='".$row_invoice['bank_name']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
                                $message.= '<tr '.$bgcolor.'>';
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$ent.'</td>';    
								$message.= '<td align="center" style="border:1px solid #CCC">Course</td>';   
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['name'].'</td>';
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$row_invoice['cheque_detail'].'</td>';
								/*$message.= '<td >'.$row_invoice['chaque_date'].'</td>';*/
								$message.= '<td align="center" style="border:1px solid #CCC">'.$row_invoice['amount'].'</td>';
								
                                /*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                                echo '</td>';*/
                                $message.= '</tr>';
                                $ent++;              
                                $bgColorCounter++;
                            }    
						}
						
		$select_directory1='order by invoice_id asc';                      
		$sql_query_inv= "SELECT * FROM invoice where DATE(added_date)='".$date."' and amount >0  ".$branch_id." ".$select_directory1." "; 
		$ptr_in=mysql_query($sql_query_inv);
		$no_of_records_inv=mysql_num_rows($ptr_in);
	  	if($no_of_records_inv)
		{
			$inv=$ent;
			while($val_query_inv=mysql_fetch_array($ptr_in))
			{
				"<br/>".$sel_enroll="select enroll_id,invoice_no from enrollment where invoice_no= '".$val_query_inv['invoice_id']."'";
				$ptr_enroll=mysql_query($sel_enroll);
				if(!mysql_num_rows($ptr_enroll))
				{
					if($bgColorCounter%2==0)
						$bgcolor='class="grey_td"';
					else
						$bgcolor="";                
					$listed_record_id=$val_query['invoice_id'];
					 
					include "include/paging_script.php";
					
					$sql_name="select name from enrollment where enroll_id='".$val_query_inv['enroll_id']."' ".$branch_id."";
					$my_name=mysql_query($sql_name);
					$row_name= mysql_fetch_array($my_name);
					
					$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query_inv['paid_type']."' ";
					$ptr_payment_mode=mysql_query($sel_payment_mode);
					$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
					
					$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query_inv['bank_name']."' ";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					
					
					$message.= '<tr '.$bgcolor.' >
						  ';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$inv.'</td>';   
					$message.= '<td align="center" style="border:1px solid #CCC">Installment</td>';    
					$message.= '<td align="center" style="border:1px solid #CCC">'.$row_name['name'].'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query_inv['cheque_detail'].'</td>';
					/*echo '<td align="center">'.$row_invoice['chaque_date'].'</td>';*/
					$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query_inv['amount'].'</td>';
					/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
						  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
		
					echo '</td>';*/
					$message.= '</tr>';
					$inv++;
					$bgColorCounter++;
				}
			}    			
    	} 
		/*else
		{
		$message.= '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Student record added on today</div><br></td></tr>';
		}*/
						
$message.='</table>
   </td>
  </tr>';
  
//========================================================================================================================================================================

$message.=  '<tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incoming Service /Membership</strong></td>
  </tr>
  <tr>';
  
$sel_total_servicec="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type!='0' and payable_amount>'0' and DATE(`added_date`) = '".$date."' ".$branch_id."";
$ptr_total_service=mysql_query($sel_total_servicec);
$data_total_service=mysql_fetch_array($ptr_total_service);

$sql_customer= "SELECT price FROM customer where DATE(`added_date`)='".$date."' and membership ='yes' ".$branch_id." "; 
$ptr_customer=mysql_query($sql_customer);
while($data_customer=mysql_fetch_array($ptr_customer))
{
	$price +=$data_customer['price'];
}

$total_service_amount=$data_total_service['total_amt']+$price;

$message.=' <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> :'.$total_service_amount.'</td> </tr>';
                        
			$select_directory='order by customer_service_id asc';                      
			$sql_query= "SELECT invoice_id,paid_type,bank_id,customer_service_id,voucher_number,cheque_detail,payable_amount FROM customer_service_invoice where paid_type!='0' and payable_amount>0 and DATE(`added_date`)='".$date."' ".$branch_id." ".$select_directory." "; 
			$ptr_db=mysql_query($sql_query);
			$no_of_records=mysql_num_rows($ptr_db);
			$message.='<tr>
			<td colspan="10" >
				<table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 					<tr class="grey_td" style="background-color:#999;color: black">
						<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Sale Type</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Customer Name</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Chaque No</strong></td>
						<td width="10%" style="border:1px solid #CCC"><strong>Amount</strong></td>
							
						</tr>';
                        if($no_of_records)
                        {
                           
                            while($val_query=mysql_fetch_array($ptr_db))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['invoice_id']; 
                                
                                include "include/paging_script.php";
								/*$sql_invoice="select invoice_id,chaque_date,paid_type,bank_name,cheque_detail,amount from invoice where enroll_id='".$val_query['enroll_id']."' ".$branch_id."";
								$my_query_invoice=mysql_query($sql_invoice);
								$row_invoice= mysql_fetch_array($my_query_invoice);*/
								
                                $sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
								$sel_="select customer_id,type from customer_service where customer_service_id='".$val_query['customer_service_id']."'";
								$ptr_sels=mysql_query($sel_);
								$data_cust_srv=mysql_fetch_array($ptr_sels);
								
								/*$sel_cust_name="select cust_name from customer where cust_id='".$data_cust_srv['customer_id']."' ";
								$ptr_cust_name=mysql_query($sel_cust_name);
								$data_cust_name=mysql_fetch_array($ptr_cust_name);*/
								$name='';
								if($data_cust_srv['type']=='Student')
								{
									$sql_product = "select name,contact from enrollment where enroll_id='".$data_cust_srv['customer_id']."' ";
									$ptr_product = mysql_query($sql_product);
									$data_product = mysql_fetch_array($ptr_product);
									$name=$data_product['name'];
									$mobile=$data_product['contact'];
								}
								else if($data_cust_srv['type']=='Employee')
								{
									$sql_product="select name, admin_id,contact_phone from site_setting where admin_id='".$data_cust_srv['customer_id']."' ";
									$ptr_product=mysql_query($sql_product);
									$data_product=mysql_fetch_array($ptr_product);
									$name=$data_product['name'];
									$mobile=$data_product['contact_phone'];
								}
								else 
								{
									$sql_product="select cust_name,cust_id,mobile1 from customer where cust_id='".$data_cust_srv['customer_id']."' ";
									$ptr_product=mysql_query($sql_product);
									$data_product=mysql_fetch_array($ptr_product);
									$name=$data_product['cust_name'];
									$mobile=$data_product['mobile1'];
								}
								
                                $message.= '<tr '.$bgcolor.'>';
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$sr_no.'</td>';    
								$message.= '<td align="center" style="border:1px solid #CCC">Service</td>';   
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$name.'</td>';
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['chaque_no'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['payable_amount'].'</td>';
                                /*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                                echo '</td>';*/
                                $message.= '</tr>';
                                $bgColorCounter++;
                            }    
						}
						else
						{
         					$message.= '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Service added on today</div><br></td></tr>';
						}	
						
						$select_directory1='order by cust_id asc';                      
						$sql_query= "SELECT * FROM customer where DATE(`added_date`)='".$date."' and membership ='yes'  ".$branch_id." ".$select_directory1." "; 
                      	$ptr_db=mysql_query($sql_query);
						$no_of_records=mysql_num_rows($ptr_db);
						
						while($val_query=mysql_fetch_array($ptr_db))
						{
							if($bgColorCounter%2==0)
								$bgcolor='class="grey_td"';
							else
								$bgcolor="";                
							$listed_record_id=$val_query['customer_service_id']; 
							
							//include "include/paging_script.php";
							/*$sql_invoice="select invoice_id,chaque_date,paid_type,bank_name,cheque_detail,amount from invoice where enroll_id='".$val_query['enroll_id']."' ".$branch_id."";
							$my_query_invoice=mysql_query($sql_invoice);
							$row_invoice= mysql_fetch_array($my_query_invoice);*/
							
							$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."'  ";
							$ptr_payment_mode=mysql_query($sel_payment_mode);
							$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
							
							$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
							$ptr_bank=mysql_query($sel_bank);
							$data_bank_name=mysql_fetch_array($ptr_bank);
							
							$sel_cust_name="select cust_name from customer where cust_id='".$val_query['customer_id']."' ";
							$ptr_cust_name=mysql_query($sel_cust_name);
							$data_cust_name=mysql_fetch_array($ptr_cust_name);
							
							$message.= '<tr '.$bgcolor.'>';
							$message.= '<td align="center" style="border:1px solid #CCC">'.$sr_no.'</td>';    
							$message.= '<td align="center" style="border:1px solid #CCC">Service</td>';   
							$message.= '<td align="center" style="border:1px solid #CCC">'.$data_cust_name['cust_name'].'</td>';
							$message.= '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
							$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
							$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
							$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['chaque_no'].'</td>';
							$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['total_cost'].'</td>';
							
							/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
								  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
							echo '</td>';*/
							$message.= '</tr>';
															
							$bgColorCounter++;
						} 
						
$message.='</table>
   </td>
  </tr>';
  
//=========================================================================================================================================================================

$message.=  '<tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incomming Product</strong></td>
  </tr>
  <tr>';
$sel_total_product="SELECT SUM(payable_amount) as total_amt FROM sales_product_invoice where DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id."";
$ptr_total_product=mysql_query($sel_total_product);
$data_total_product=mysql_fetch_array($ptr_total_product);
$total_product_amount=$data_total_product['total_amt'];
//================================================================================================================================================================
$message.=' <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> :'.$total_product_amount.'</td> </tr>';
						$select_directory='order by invoice_id asc';                      
						$sql_query= "SELECT * FROM sales_product_invoice where DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id." order by invoice_id asc "; 
                      	$ptr_db=mysql_query($sql_query);
						$no_of_records=mysql_num_rows($ptr_db);
						$message.='<tr>
		<td colspan="10" >
			<table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 				<tr class="grey_td" style="background-color:#999;color: black">
						<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Invoice No.</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Customer Name</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Chaque No</strong></td>
						<td width="10%" style="border:1px solid #CCC"><strong>Amount</strong></td>
							
						</tr>';
                        if($no_of_records)
                        {
							$ij=1;
                            while($val_query=mysql_fetch_array($ptr_db))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['inventory_id']; 
                                
                                //include "include/paging_script.php";
								
								$sel_sales_prod="select * from sales_product where sales_product_id='".$val_query['sales_product_id']."'";	
								$ptr_prod=mysql_query($sel_sales_prod);
								$data_products=mysql_fetch_array($ptr_prod);
								
                                $sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
								$sel_cust_name="select name from vendor where vendor_id='".$data_products['vendor_id']."'  ";
								$ptr_cust_name=mysql_query($sel_cust_name);
								$data_cust_name=mysql_fetch_array($ptr_cust_name);
								
                                $message.= '<tr '.$bgcolor.'>';
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$ij.'</td>'; 
                                $message.= '<td align="center" style="border:1px solid #CCC">SALE-'.$val_query['sales_product_id'].'-'.$val_query['invoice_id'].'</td>';
								
								/*$sel_prod="select product_id from sales_product_map where sales_product_id = '".$listed_record_id."'";
								$ptr_prod=mysql_query($sel_prod);
								$total_Sales=mysql_num_rows($ptr_prod);*/
								
								$name='';
								if($data_products['type']=='Student')
								{
									$sql_name="select name from enrollment where enroll_id='".$data_products['customer_id']."' ";
									$ptr_names=mysql_query($sql_name);
									$data_name=mysql_fetch_array($ptr_names);
									$name=$data_name['name'];
								}
								else if($data_products['type']=='Employee')
								{
									$sql_name="select name, admin_id from site_setting where admin_id='".$data_products['customer_id']."' ";
									$ptr_names=mysql_query($sql_name);
									$data_name=mysql_fetch_array($ptr_names);
									$name=$data_name['name'];
								}
								else if($data_products['type']=='Customer')
								{
									$sql_name="select cust_name, cust_id from customer where cust_id='".$data_products['customer_id']."' ";
									$ptr_names=mysql_query($sql_name);
									$data_name=mysql_fetch_array($ptr_names);
									$name=$data_name['cust_name'];
								}
								
								
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$name.'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['cheque_detail'].'</td>';
								$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['payable_amount'].'</td>';
								
                                /*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                                echo '</td>';*/
                                $message.= '</tr>';
                                                                
                                $ij++;
                            }    
						}
						else
						{
         				$message.= '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Student record added on today</div><br></td></tr>';
						}
						
		$message.='</table>
   </td>
  </tr>';					
//==============================================================================================================================================

$message.=  '<tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Sale Vouchers/ Package</strong></td>
  </tr>
  <tr>';
  
$sel_sales_pack="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where membership_id='0' and DATE(`added_date`) = '".$date."' ".$branch_id."";
$ptr_sales_pack=mysql_query($sel_sales_pack);
$data_sales_pack=mysql_fetch_array($ptr_sales_pack);
$total_sales_pack=$data_sales_pack['total_amt'];

$message.=' <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> :'.$total_sales_pack.'</td> </tr>';
                        
$select_directory='order by id asc';                      
$sql_query= "SELECT * FROM sales_package_voucher_memb where membership_id='0' and  DATE(`added_date`)='".$date."' ".$branch_id." ".$select_directory.""; 
$ptr_db=mysql_query($sql_query);
$no_of_records=mysql_num_rows($ptr_db);
$message.='<tr>
 <td colspan="10" >
 <table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 <tr class="grey_td" style="background-color:#999;color: black">
<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
<td width="20%" align="center" style="border:1px solid #CCC"><strong>Category</strong></td>
<td width="20%" align="center" style="border:1px solid #CCC"><strong>Name</strong></td>
<td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
<td width="10%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
<td width="10%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
<td width="10%" align="center" style="border:1px solid #CCC"><strong>Chaque No</strong></td>
<td width="10%" style="border:1px solid #CCC"><strong>Amount</strong></td>
	
</tr>';
if($no_of_records)
{
	while($val_query=mysql_fetch_array($ptr_db))
	{
		if($bgColorCounter%2==0)
			$bgcolor='class="grey_td"';
		else
			$bgcolor="";                
		$listed_record_id=$val_query['id']; 
		
		//include "include/paging_script.php";
		
		$cust_name="select cust_name from customer where cust_id='".$val_query['cust_id']."'";
		$ptr_cust=mysql_query($cust_name);
		$data_cust=mysql_fetch_array($ptr_cust);
			
		$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."' ";
		$ptr_payment_mode=mysql_query($sel_payment_mode);
		$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
		
		$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."'";
		$ptr_bank=mysql_query($sel_bank);
		$data_bank_name=mysql_fetch_array($ptr_bank);
		
		$name=='';
		if($val_query['category']=='Membership')
		{
			$sl_memb="select membership_name from membership where membership_id='".$val_query['membership_id']."'";
			$ptr_memb=mysql_query($sl_memb);
			$data_memb=mysql_fetch_array($ptr_memb);
			$name=$data_memb['membership_name'];
		}
		else if($val_query['category']=='Package')
		{
			$sl_package="select package_name from package where package_id='".$val_query['package_id']."'";
			$ptr_package=mysql_query($sl_package);
			$data_package=mysql_fetch_array($ptr_package);
			$name=$data_package['package_name'];
		}else if($val_query['category']=="Voucher")
		{
			$sl_voucher="select deal_name from voucher where voucher_id='".$val_query['voucher_id']."'";
			$ptr_voucher=mysql_query($sl_voucher);
			$data_voucher=mysql_fetch_array($ptr_voucher);
			$name=$data_voucher['deal_name'];
		}
		$message.= '<tr '.$bgcolor.'>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$sr_no.'</td>'; 
		$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['category'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$name.'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['chaque_no'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['payable_amount'].'</td>';
		
		/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
			  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
		echo '</td>';*/
		$message.= '</tr>';
										
		$bgColorCounter++;
	}    
}
else
{
$message.= '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Sales Product added on today</div><br></td></tr>';
}

$message.='</table>
   </td>
  </tr>';

//====================================================================================================

$message.=  '<tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incommimg (Receipt)</strong></td>
  </tr>
  <tr>';

$sel_total_inc2="select SUM(amount) as total_amt from receipt where added_date='".$date."' ".$branch_id."";
$ptr_total_inc2=mysql_query($sel_total_inc2);
$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
$total=$data_total_inc2['total_amt'];

$message.=' <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> :'.$total.'</td> </tr>';
                        
$sele_recep="select receipt_id,category,payment_mode_id,bank_id,amount,added_date,emp_type,description,customer_id from receipt where 1 and category!='cash_transfer' and cash_transfer_mode is NULL and added_date='".$date."' ".$branch_id."";
$ptr_recep=mysql_query($sele_recep);
$no_of_records=mysql_num_rows($ptr_recep);

$message.='
<tr>
 <td colspan="10" >
 <table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 <tr class="grey_td" style="background-color:#999;color: black">
<td width="4%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Type</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
	<td width="20%" align="center" style="border:1px solid #CCC"><strong>Description</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Customer name</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
</tr>';
if($no_of_records)
{
	$bgColorCounter=1;
	while($data_recep=mysql_fetch_array($ptr_recep))
	{
		$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_recep['payment_mode_id']."'";
		$ptr_pay_name=mysql_query($sele_pay_name);
		$data_pay_name=mysql_fetch_array($ptr_pay_name);
		
		$sel_bank="select bank_name,account_no from bank where bank_id='".$data_recep['bank_id']."'";
		$ptr_bank=mysql_query($sel_bank);
		$data_bank_name=mysql_fetch_array($ptr_bank);
		
		$cash_modes='';
		if($data_recep['cash_transfer_mode']!='')
		{
			$cash_modes='('.$data_recep['cash_transfer_mode'].')';
		}
		$category=$data_recep['category'];
		if($data_recep['category']=="cash_transfer")
		{
			$category='Cash Transfer';
		}
		
		$name='';
		if($data_recep['emp_type']=="Student")
		{
			$sel_student="select name from enrollment where enroll_id='".$data_recep['customer_id']."'";
			$ptr_stud=mysql_query($sel_student);
			$data_stud=mysql_fetch_array($ptr_stud);
			$name=$data_stud['name'];
		}
		else if($data_recep['emp_type']=="Customer")
		{
			$sel_cust="select cust_name from customer where cust_id='".$data_recep['customer_id']."'";
			$ptr_cust=mysql_query($sel_cust);
			$data_cust=mysql_fetch_array($ptr_cust);
			$name=$data_cust['cust_name'];
		}
		else if($data_recep['emp_type']=="Employee")
		{
			$sel_emp="select name from site_setting where admin_id='".$data_recep['customer_id']."'";
			$ptr_emp=mysql_query($sel_emp);
			$data_emp=mysql_fetch_array($ptr_emp);
			$name=$data_emp['name'];
		}
		else if($data_recep['emp_type']=="Vendor")
		{
			$sel_vendor="select name from vendor where vendor_id='".$data_recep['customer_id']."'";
			$ptr_vendor=mysql_query($sel_vendor);
			$data_vendor=mysql_fetch_array($ptr_vendor);
			$name=$data_vendor['name'];
		}
		$message.= '<tr>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$bgColorCounter.'</td>';       
		$message.= '<td align="center" style="border:1px solid #CCC">'.$category.' '.$cash_modes.'</td>';		
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
		//$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_recep['description'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$name.'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td>';
			
		$bgColorCounter++;
		
	}  
}
else
{
$message.= '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Receipt added on today</div><br></td></tr>';
}

$message.='</table>
   </td>
  </tr>';

//=======================================================================================================================================================================
										
$message.='
<tr>
 <td align="center" colspan="10">&nbsp;</td>
 </tr>
	  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Outgoing (Expense)</strong></td>
  </tr>
  
  <tr>';
  
  	$select_inv="select SUM(payable_amount) as total from inventory_invoice where DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_inv=mysql_query($select_inv);
	$total_inv=0;
	if(mysql_num_rows($ptr_inv))
	{
		$data_inv=mysql_fetch_array($ptr_inv);
		$total_inv=$data_inv['total'];
	}
	
	$select_amnt1="select SUM(amount) as total from expense where DATE(added_Date)='".$date."' ".$branch_id." ";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
	
 	$sele_exp="select SUM(total_refund) as total_refund from enrollment_refund where DATE(added_date)='".$date."' ".$branch_id."";
	$ptr_exp=mysql_query($sele_exp);
	$totatl_refund=0;
	if(mysql_num_rows($ptr_exp))
	{
		$data_refund=mysql_fetch_array($ptr_exp);
		$totatl_refund=$data_refund['total_refund'];
	}
 	$total=$total_inv+$total_amount1+$totatl_refund;
	
	$message.='  <td align="left" colspan="10" style="color:#F00"><strong>Total Outgoing</strong> :'.$total.'</td> </tr>';					
	$message.='<tr>
 <td colspan="10" >
 <table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999;color: black">
    
    <td width="4%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="12%" align="center" style="border:1px solid #CCC"><strong>Expense Type</strong></td>
    <td width="16%" align="center" style="border:1px solid #CCC"><strong>Employee</strong></td>
    <td width="11%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    <td width="13%" align="center" style="border:1px solid #CCC"><strong>Vendor</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
	<td width="13%" align="center" style="border:1px solid #CCC"><strong>Account No.</strong></td>
    <td width="16%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
   </tr>';
    
	$sele_exp="select expense_id,expense_type_id,employee_id,vendor_id,payment_mode_id,bank_id from expense where  added_Date='".$date."' ".$branch_id."";
	$ptr_exp=mysql_query($sele_exp);
	$i=1;
	if(mysql_num_rows($ptr_exp))
	{
		while($data_exp=mysql_fetch_array($ptr_exp))
		{
			$exp_name="select expense_type from expense_type where expense_type_id='".$data_exp['expense_type_id']."'";
			$ptr_expense=mysql_query($exp_name);
			$data_expense=mysql_fetch_array($ptr_expense);
			
			$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."' and added_Date='".$date."' and expense_id= '".$data_exp['expense_id']."'";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
			
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_exp['payment_mode_id']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_emp="select name from site_setting where admin_id='".$data_exp['employee_id']."'";
			$ptr_emp=mysql_query($sel_emp);
			$data_emp=mysql_fetch_array($ptr_emp);
			
			$sel_vendor="select name from vendor where vendor_id='".$data_exp['vendor_id']."'";
			$ptr_vendor=mysql_query($sel_vendor);
			$data_vendor=mysql_fetch_array($ptr_vendor);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_exp['bank_id']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$message.= '<tr>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_expense['expense_type'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_emp['name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_vendor['name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['total_amt'].'</td></tr>';
		$i++;
		}
	}
	
	$sele_exp="select * from enrollment_refund where added_date='".$date."' ".$branch_id."";
	$ptr_exp=mysql_query($sele_exp);
	$j=$i;
	if(mysql_num_rows($ptr_exp))
	{
		while($data_exp=mysql_fetch_array($ptr_exp))
		{
			$exp_name="select name from enrollment where enroll_id='".$data_exp['enroll_id']."'";
			$ptr_stud=mysql_query($exp_name);
			$data_student=mysql_fetch_array($ptr_stud);
			
			$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."' and added_Date='".$date."' and expense_id= '".$data_exp['expense_id']."'";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
			
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_exp['paid_type']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_emp="select name from site_setting where admin_id='".$data_exp['admin_id']."'";
			$ptr_emp=mysql_query($sel_emp);
			$data_emp=mysql_fetch_array($ptr_emp);
			
						
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_exp['bank_name']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$message.= '<tr>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$j.'</td>';       
			$message.= '<td align="center" style="border:1px solid #CCC">Enroolment Refund</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_student['name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">---</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_exp['total_refund'].'</td></tr>';
		$j++;
		}
	}
	//================================================
	/*$sele_recep="select receipt_id,category,payment_mode_id,bank_id,amount,added_date,cash_transfer_mode from receipt where  1 and cash_transfer_mode='inword' and category='cash_transfer' and added_date='".$date."' ".$branch_id."";
	$ptr_recep=mysql_query($sele_recep);
	$i=$i;
	if(mysql_num_rows($ptr_recep))
	{
		while($data_recep=mysql_fetch_array($ptr_recep))
		{
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_recep['payment_mode_id']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_recep['bank_id']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			$cash_modes='';
			if($data_recep['cash_transfer_mode']!='')
			{
				$cash_modes='('.$data_recep['cash_transfer_mode'].')';
			}
			$category=$data_recep['category'];
			if($data_recep['category']=="cash_transfer")
			{
				$category='Cash Transfer';
			}
			$message.= '<tr>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			$message.= '<td align="center" style="border:1px solid #CCC">'.$category.' '.$cash_modes.'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">--</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">--</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td></tr>';
			$i++;
		}
	}
	$sele_recep="select receipt_id,category,payment_mode_id,from_bank_name,amount,added_date,cash_transfer_mode from receipt where  1 and cash_transfer_mode='bank_to_bank' and from_bank_name is NOT NULL and category='cash_transfer' and added_date='".$date."' ".$branch_id."";
	$ptr_recep=mysql_query($sele_recep);
	$i=$i;
	if(mysql_num_rows($ptr_recep))
	{
		while($data_recep=mysql_fetch_array($ptr_recep))
		{
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_recep['payment_mode_id']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_recep['from_bank_name']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			$cash_modes='';
			if($data_recep['cash_transfer_mode']=='bank_to_bank')
			{
				$cash_modes='(Bank)';
			}
			
			$message.= '<tr>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			$message.= '<td align="center" style="border:1px solid #CCC">Cash WIthdrwal '.$cash_modes.'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">--</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">--</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td></tr>';
			
			$i++;
		}
	}*/
	//=================================================
	
	$sele_exp="SELECT * FROM inventory_invoice where DATE(`added_date`)='".$date."' and payable_amount > 0 ".$branch_id." order by inventory_id asc";
	$ptr_exp=mysql_query($sele_exp);
	$k=$j;
	if(mysql_num_rows($ptr_exp))
	{
		while($val_query=mysql_fetch_array($ptr_exp))
		{
			
			$listed_record_id=$val_query['inventory_id'];
			/*$exp_name="select expense_type from expense_type where expense_type_id='".$data_exp['expense_type_id']."'";
			$ptr_expense=mysql_query($exp_name);
			$data_expense=mysql_fetch_array($ptr_expense);*/
			
			/*$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."' and added_Date='".$date."' and expense_id= '".$data_exp['expense_id']."'";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);*/
			
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."'";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sele_inv="select vendor_id from inventory where inventory_id ='".$val_query['inventory_id']."' order by inventory_id asc limit 0,1";
			$ptr_inv1=mysql_query($sele_inv);
			$data_inv=mysql_fetch_array($ptr_inv1);
			
			$sel_vendor="select name from vendor where vendor_id='".$data_inv['vendor_id']."'";
			$ptr_vendor=mysql_query($sel_vendor);
			$data_vendor=mysql_fetch_array($ptr_vendor);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$message.= '<tr>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$k.'</td>';      
			 
			$sel_prod="select product_id from inventory_product_map where inventory_id = '".$listed_record_id."'";
			$ptr_prod=mysql_query($sel_prod);
			$total_inventory=mysql_num_rows($ptr_prod);
								
			$message.= '<td align="center" style="border:1px solid #CCC">Purchase Product ('.$total_inventory.') - Rec. no-('.$listed_record_id.')- Inv. No('.$val_query['invoice_id'].')</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">-</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_vendor['name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$val_query['payable_amount'].'</td></tr>';
		$k++;
		}
	}

 $message.='</table>
   </td>
  </tr>';
  
 
 //=======================================================================END RECEIPT=============================================================================================

$message.='
<tr bgcolor="#AFD8E0">
	<td align="center" colspan="10"><strong>Fund Transfer</strong></td>
</tr>
<tr><td>&nbsp;</td></tr>';
                  
$sele_recep="select receipt_id,category,payment_mode_id,bank_id,amount,added_date,emp_type,description,from_bank_name,cash_transfer_mode from receipt where 1 and category='cash_transfer' and cash_transfer_mode!='cash_to_cash' and added_date='".$date."' ".$branch_id."";
$ptr_recep=mysql_query($sele_recep);
$no_of_records=mysql_num_rows($ptr_recep);

$message.='<tr>
 <td colspan="10" >
 <table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 <tr class="grey_td" style="background-color:#999;color: black">
	<td width="4%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Type</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>From Bank</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>To Bank</strong></td>
	<td width="20%" align="center" style="border:1px solid #CCC" colspan="2"><strong>Description</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
</tr>';
if($no_of_records)
{
	$bgColorCounter=1;
	while($data_recep=mysql_fetch_array($ptr_recep))
	{
		$sele_pay_name="select payment_mode from payment_mode where payment_mode_id='".$data_recep['payment_mode_id']."'";
		$ptr_pay_name=mysql_query($sele_pay_name);
		$data_pay_name=mysql_fetch_array($ptr_pay_name);
		
		$sel_from_bank="select bank_name,account_no from bank where bank_id='".$data_recep['from_bank_name']."'";
		$ptr_from_bank=mysql_query($sel_from_bank);
		$data_from_bank_name=mysql_fetch_array($ptr_from_bank);
		
		$sel_bank="select bank_name,account_no from bank where bank_id='".$data_recep['bank_id']."'";
		$ptr_bank=mysql_query($sel_bank);
		$data_bank_name=mysql_fetch_array($ptr_bank);
		
		$cash_modes='';
		$from_bank_name='-';
		$from_bank_acc_no='';
		if($data_recep['cash_transfer_mode']!='')
		{
			if($data_recep['cash_transfer_mode']=='outword')
			{
				$cash_modes=' Cash Deposited';
			}
			else if($data_recep['cash_transfer_mode']=='inword')
			{
				$cash_modes=' Cash Withdrawl';
			}
			else if($data_recep['cash_transfer_mode']=='bank_to_bank')
			{
				$cash_modes=' Bank to Bank Transfer';
				$from_bank_name=$data_from_bank_name['bank_name'];
				$from_bank_acc_no=$data_from_bank_name['account_no'];
			}
		}
		
		$name='';
		if($data_recep['emp_type']=="Student")
		{
			$sel_student="select name from enrollment where enroll_id='".$data_recep['customer_id']."'";
			$ptr_stud=mysql_query($sel_student);
			$data_stud=mysql_fetch_array($ptr_stud);
			$name=$data_stud['name'];
		}
		else if($data_recep['emp_type']=="Customer")
		{
			$sel_cust="select cust_name from customer where cust_id='".$data_recep['customer_id']."'";
			$ptr_cust=mysql_query($sel_cust);
			$data_cust=mysql_fetch_array($ptr_cust);
			$name=$data_cust['cust_name'];
		}
		else if($data_recep['emp_type']=="Employee")
		{
			$sel_emp="select name from site_setting where admin_id='".$data_recep['customer_id']."'";
			$ptr_emp=mysql_query($sel_emp);
			$data_emp=mysql_fetch_array($ptr_emp);
			$name=$data_emp['name'];
		}
		else if($data_recep['emp_type']=="Vendor")
		{
			$sel_vendor="select name from vendor where vendor_id='".$data_recep['customer_id']."'";
			$ptr_vendor=mysql_query($sel_vendor);
			$data_vendor=mysql_fetch_array($ptr_vendor);
			$name=$data_vendor['name'];
		}
		$message.= '<tr>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$bgColorCounter.'</td>';       
		$message.= '<td align="center" style="border:1px solid #CCC">'.$category.' '.$cash_modes.'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$from_bank_name.' '.$from_bank_acc_no.'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].' ('.$data_bank_name['account_no'].')</td>';
		$message.= '<td align="center" style="border:1px solid #CCC" colspan="2">'.$data_recep['description'].'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td>';
			
		$bgColorCounter++;
		
	}  
}
else
{
$message.= '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Fund Transfer added on today</div><br></td></tr>';
}
$message.='</table>
   </td>
</tr>';
//=================================================================END FUND TRANSFER====================================================================================== 
 
$message.=' <tr>
 <td align="center" colspan="10">&nbsp;</td>
 </tr>
 <tr bgcolor="#AFD8E0">
 <td align="center" colspan="10"><strong>Bank Summary</strong></td>
 </tr>
  <tr >
  <td align="center" colspan="10">&nbsp;</td>
  </tr>
 
 <tr class="grey_td" >
 <td colspan="12" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #CCC">
 <tr style="background-color:#999;color: black">
    
    <td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="20%" align="center" style="border:1px solid #CCC"><strong>Bank Name</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Incomming / Inward</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Outgoing / Outward</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Yesterday`s Balance</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Todays`s Balance</strong></td>
   </tr>';
$prv_date = trim(date('Y-m-d',strtotime('-1 day'))); 
/*if($_GET['baranch_id']=="")
{
	
	$cm_idA='';
	$cm_idC='';
}
else
{*/
	$cm_idA="and A.cm_id= ".$cm_id1."";
	$cm_idC="and C.cm_id= ".$cm_id1."";
//}   
 
		/*$sel_inv1="select DISTINCT(b.bank_id) as bank_name from bank b,invoice i,customer_service_invoice cs,sales_product_invoice sp,sales_package_voucher_memb spvm,receipt r where 1 and (b.bank_id=i.bank_name or b.bank_id=r.bank_id or b.bank_id=cs.bank_id or b.bank_id=sp.bank_id or b.bank_id=spvm.bank_id) and (DATE(i.added_date) = '".$date."' or  DATE(cs.added_date) = '".$date."' or DATE(sp.added_date) = '".$date."' or DATE(spvm.added_date) = '".$date."' or  DATE(r.added_date) = '".$date."')";*/
		$sel_inv1="select DISTINCT(bank_id) as bank_name from bank where 1 ".$branch_id."";
		$ptr_amnt1=mysql_query($sel_inv1);
		if($total_bank=mysql_num_rows($ptr_amnt1))
		{
			$k=1;
			while($data_ptr_sel1=mysql_fetch_array($ptr_amnt1))
			{
				$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel1['bank_name']."'";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
									
				$sel_inv="select SUM(amount) as total_amt,bank_name from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".$date."' ".$branch_id."";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				//==================================================================================================================================================
				/*$sel_receipt="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode !='outword'  and added_date='".$date."' ".$branch_id." ";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);*/
				
				$sel_expense="select SUM(amount) as total_amt from expense where bank_id='".$data_ptr_sel1['bank_name']."' and added_date='".$date."' ".$branch_id."";
				$ptr_expense_bank_id=mysql_query($sel_expense);
				$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
				
				$sel_refund="select SUM(total_refund) as total_amt from enrollment_refund where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_refund_bank_id=mysql_query($sel_refund);
				$data_sel_refund=mysql_fetch_array($ptr_refund_bank_id);
				
				$sel_receipt_out="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode='inword'  and added_date='".$date."' ".$branch_id." ";
				$ptr_bank_id_out=mysql_query($sel_receipt_out);
				$data_sel_recipt_out=mysql_fetch_array($ptr_bank_id_out);
				
				$sel_inv="select SUM(payable_amount) as total_amt from inventory_invoice where bank_id='".$data_ptr_sel1['bank_name']."' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptrinv=mysql_query($sel_inv);
				$data_inv=mysql_fetch_array($ptrinv);
				
				$sel_cc_expense="select SUM(amount) as total_amt from expense where cc_bank_name='".$data_ptr_sel1['bank_name']."' and added_date='".$date."' ".$branch_id."";
				$ptr_cc_expense=mysql_query($sel_cc_expense);
				$data_cc_expense=mysql_fetch_array($ptr_cc_expense);
				
				$sel_bank_out="select SUM(amount) as total_amt from receipt where from_bank_name='".$data_ptr_sel1['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$branch_id." ";
				$ptr_bank_out=mysql_query($sel_bank_out);
				$data_bank_out=mysql_fetch_array($ptr_bank_out);
				
				$outgoing=$data_sel_expense['total_amt'] + $data_sel_recipt_out['total_amt'] +$data_inv['total_amt']+$data_cc_expense['total_amt']+$data_bank_out['total_amt']+$data_sel_refund['total_amt'];
				//==============================================================================================================================================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".$date."' ".$branch_id."";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and (cash_transfer_mode = 'outword' OR cash_transfer_mode IS NULL ) and added_date='".$date."' ".$branch_id."";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				
				$sel_total_inc3="select SUM(payable_amount) as total_amt from customer_service_invoice where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_inc3=mysql_query($sel_total_inc3);
				$data_total_inc3=mysql_fetch_array($ptr_total_inc3);
				
				$sel_total_inc4="select SUM(payable_amount) as total_amt from sales_product_invoice where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_inc4=mysql_query($sel_total_inc4);
				$data_total_inc4=mysql_fetch_array($ptr_total_inc4);
				
				$sel_total_inc5="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where bank_id='".$data_ptr_sel1['bank_name']."'  and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_inc5=mysql_query($sel_total_inc5);
				$data_total_inc5=mysql_fetch_array($ptr_total_inc5);
				
				$sel_total_inc6="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and category='cash_transfer' and cash_transfer_mode='bank_to_bank' and added_date='".$date."' ".$branch_id." ";
				$ptr_total_inc6=mysql_query($sel_total_inc6);
				$data_total_inc6=mysql_fetch_array($ptr_total_inc6);
				//==================================================================================================================================================
				$$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and added_date = '".$prv_date."'  ".$branch_id."" ;
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_yesterday=mysql_fetch_array($ptr_total_inc);
				$data_total_yest = $data_total_yesterday['total_amt'];
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where category='incoming' and bank_id='".$data_ptr_sel1['bank_name']."' and added_date = '".$prv_date."' ".$branch_id."";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_yesterday2=mysql_fetch_array($ptr_total_inc2);
				$data_total_yest2 = $data_total_yesterday2['total_amt'];
				
				$total_todays_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']+$data_total_inc3['total_amt']+$data_total_inc4['total_amt']+$data_total_inc5['total_amt']+$data_total_inc6['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				
				//$incomming=$data_sel_recipt['total_amt']+$data_ptr_sel['total_amt'];
				$yesterday_bal=$data_total_yest+$data_total_yest2;
				
				$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel1['bank_name']."' and added_date<'".$date."' ".$branch_id."  order by added_date desc limit 0,1 "; //and added_date = '".$prv_date."'
				$ptr_yest=mysql_query($sele_yesterday_bal);
				$data_yesterday=mysql_fetch_array($ptr_yest);
				
				$total_todays_bank= intval($total_todays_bal + $data_yesterday['todays_balance']) - $outgoing;
				$tot=$total_todays_bank;
				/*if($total_todays_bank < 0)
				{
					$total_todays_bank= 0;
					
				}
				if($tot !=0)
				{*/
			
					$message.= '<tr>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$k.'</td> ';       
					$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$total_todays_bal.'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$outgoing.'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$data_yesterday['todays_balance'].'</td>';
					$message.= '<td align="center" style="border:1px solid #CCC">'.$total_todays_bank.'</td> ';
					$message.= '</tr>';
					$k++;
					
				//}
			}
		}
		else
		{
			$message.= '<tr><td class="text" align="center" colspan="7"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Bank Amount added on today</div><br></td></tr>';
		}
	
	
$message.='  </table>
   </td>
  </tr>';
  
//=====================================================================================================================================================================
 
  $message.=' <tr>
  <td align="center" colspan="10">&nbsp;</td>
  </tr>
 <tr bgcolor="#AFD8E0">
 <td align="center" colspan="10"><strong>Cash Summary</strong></td>
 </tr>
  <tr >
  <td align="center" colspan="10">&nbsp;</td>
  </tr>
 
 <tr class="grey_td" >
 <td colspan="14" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #CCC">
 <tr style="background-color:#999;color: black">
    
    
    <td width="6%" align="center" style="border:1px solid #CCC"><strong>Opening Cash</strong></td>
	<td width="8%" align="center" style="border:1px solid #CCC"><strong>Opening Petty Cash</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Revenue</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Cash Received from Sir in Business cash</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Expenses</strong></td>
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash Given to Director From Business cash</strong></td>
    <td width="10%" align="center" style="border:1px solid #CCC"><strong>Cash Deposited in Bank From Business Cash</strong></td>
	<td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash withdrawl in petty cash</strong></td>
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash In Hand</strong></td>
	<td width="8%" align="center" style="border:1px solid #CCC"><strong>Petty Cash In Hand</strong></td>
   </tr>';
    // <td width="15%" align="center" style="border:1px solid #CCC"><strong>Cash Received from Innocent</strong></td>
				$sel_inv1="select DISTINCT(bank_name) from invoice where DATE(`added_date`) = '".$date."' and bank_name !='' and bank_name !='select' ".$branch_id."";
				$ptr_amnt1=mysql_query($sel_inv1);
				$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
				//===================Todays Total receive balance===============================
				$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='1' and DATE(`added_date`) = '".$date."' ".$branch_id."";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				
				$sel_receipt="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
				
				$sel_receipt_petty="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer' and category !='innocent' and category !='santosh' and category !='voucher' and cash_type='petty_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_petty_cash=mysql_query($sel_receipt_petty);
				$data_sel_recipt_petty_cash=mysql_fetch_array($ptr_petty_cash);
				
				$sel_voucher="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category ='voucher' and added_date='".$date."' ".$branch_id."";
				$ptr_voucher=mysql_query($sel_voucher);
				$data_sel_voucher=mysql_fetch_array($ptr_voucher);
				
				//$todays_receive=$data_ptr_sel['total_amt']+$data_sel_recipt['total_amt'];
				//==============================================================================
				
				//===================Opening cash===============================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ".$branch_id."";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='voucher' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ".$branch_id."";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				
				$total_yest_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				//==============================================================================
				
				//===================Total Cash Taken from Bank===============================
				/*$sel_expense_taken="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and added_date='".$date."' ".$branch_id."";
				$ptr_expense_taken=mysql_query($sel_expense_taken);
				$data_expense_taken=mysql_fetch_array($ptr_expense_taken);*/
				//============================================================================
				
				//===================Cash received from sir===============================
				$sel_cash_received_sir="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_received_sir=mysql_query($sel_cash_received_sir);
				$data_cash_received_sir=mysql_fetch_array($ptr_cash_received_sir);
				
				$sel_cash_received_sir_in_petty="select SUM(amount) as total_amt from receipt where category ='santosh' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_received_sir_in_petty=mysql_query($sel_cash_received_sir_in_petty);
				$data_cash_received_sir_in_petty=mysql_fetch_array($ptr_cash_received_sir_in_petty);
				//============================================================================
				
				//===================Total Cash Expenses===============================
				$sel_total_expense="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and expense_type_id !='1' and expense_type_id !='119'  and expense_type_id !='120' and cash_type='petty_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_total_expense=mysql_query($sel_total_expense);
				$data_total_expense=mysql_fetch_array($ptr_total_expense);
				
				$sel_total_expense_business="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and expense_type_id !='1' and expense_type_id !='119'  and expense_type_id !='120' and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_total_expense_business=mysql_query($sel_total_expense_business);
				$data_total_expense_business=mysql_fetch_array($ptr_total_expense_business);
				//============================================================================
				//===================Total Cash Refund===============================
				$sel_total_refund="select SUM(total_refund) as total_amt from enrollment_refund where paid_type ='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_total_refund=mysql_query($sel_total_refund);
				$data_total_refund=mysql_fetch_array($ptr_total_refund);
				//============================================================================
				//===================Cash Given to sir===============================
				
				$sel_cash_from_sir_petty="select SUM(amount) as total_amt from expense where payment_mode_id='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='petty_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_from_sir_petty=mysql_query($sel_cash_from_sir_petty);
				$data_cash_from_sir_petty=mysql_fetch_array($ptr_cash_from_sir_petty);
				
				$sel_cash_from_sir_business="select SUM(amount) as total_amt from expense where payment_mode_id='1' and (expense_type_id='1' or expense_type_id='119' or expense_type_id='120') and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_from_sir_business=mysql_query($sel_cash_from_sir_business);
				$data_cash_from_sir_business=mysql_fetch_array($ptr_cash_from_sir_business);
				
				//============================================================================

				//===================Cash Received from Inocent===============================
				$sel_cash_from_innocent="select SUM(amount) as total_amt from receipt where category ='innocent' and payment_mode_id='1' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_from_innocent=mysql_query($sel_cash_from_innocent);
				$data_cash_from_innocent=mysql_fetch_array($ptr_cash_from_innocent);
				//============================================================================
				
				//===================Cash in Hand===============================
				/*$sel_cash_from_cash="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='santosh' and category !='voucher' and payment_mode_id='1' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_from_cash=mysql_query($sel_cash_from_cash);
				$data_cash_from_cash=mysql_fetch_array($ptr_cash_from_cash);*/
				
				/*$sel_cash_rec="select SUM(amount) as total_amt from receipt where 1 and category='cash_transfer' and (cash_transfer_mode is NULL or cash_transfer_mode !='outword' ) and cash_transfer_mode!= 'bank_to_bank' and category !='santosh' and category !='voucher' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_rec=mysql_query($sel_cash_rec);
				$data_cash_rec=mysql_fetch_array($ptr_cash_rec);*/
				//====================CASH TRANSFER - INWORD =======================================
				$sel_cash_rec="select SUM(amount) as total_amt from receipt where 1 and category='cash_transfer' and (cash_transfer_mode is NULL or cash_transfer_mode !='outword' ) and cash_transfer_mode!= 'bank_to_bank' and category !='santosh' and category !='voucher' and cash_transfer_mode!='cash_to_cash' and cash_type='business_cash' and added_date='".$date."' ".$branch_id."";
				$ptr_cash_rec=mysql_query($sel_cash_rec);
				$data_cash_rec=mysql_fetch_array($ptr_cash_rec); //cash_type='business_cash' (3/6/19)
				//=============================SERVICE===============================================
				$sel_service="select SUM(payable_amount) as total_amt from customer_service_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_service=mysql_query($sel_service);
				$data_service=mysql_fetch_array($ptr_service);
				
				$sel_memb="select SUM(price) as total_amt from customer where payment_mode_id='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_memb=mysql_query($sel_memb);
				$data_membership=mysql_fetch_array($ptr_memb);
				
				$total_service=$data_service['total_amt'];
				//============================================================================
				//=============================PRODUCT===============================================
				$sel_product="select SUM(payable_amount) as total_amt from inventory_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_product=mysql_query($sel_product);
				$data_product=mysql_fetch_array($ptr_product);
				
				$sel_sales_product="select SUM(payable_amount) as total_amt from sales_product_invoice where paid_type='1' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_product=mysql_query($sel_sales_product);
				$data_sales_product=mysql_fetch_array($ptr_sales_product);
				
				$total_produts=$data_product['total_amt']-$data_sales_product['total_amt'];
				
				$sel_sales_membership="select SUM(price) as total_amt from customer where payment_mode_id='1' and membership='yes' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_membership=mysql_query($sel_sales_membership);
				$data_sales_membership=mysql_fetch_array($ptr_sales_membership);
				
				$sel_sales_package="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Package' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_package=mysql_query($sel_sales_package);
				$data_sales_package=mysql_fetch_array($ptr_sales_package);
				
				$sel_sales_voucher="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where payment_mode_id='1' and category='Voucher' and DATE(added_date)='".$date."' ".$branch_id."";
				$ptr_sales_voucher=mysql_query($sel_sales_voucher);
				$data_sales_voucher=mysql_fetch_array($ptr_sales_voucher);
				//============================================================================
				//=================================Cash Withdrawl in petty cash====================== (3/6/19)
				$cash_withdrawl_in_petty_cash=0;
				$sel_withd="select SUM(amount) as total_amt from receipt where cash_transfer_mode='inword' and cash_type='petty_cash' and added_date='".$date."' ".$branch_id." ";
				$ptr_cash_withd=mysql_query($sel_withd);
				if(mysql_num_rows($ptr_cash_withd))
				{
					$data_cash_withdrawl=mysql_fetch_array($ptr_cash_withd);
					$cash_withdrawl_in_petty_cash=$data_cash_withdrawl['total_amt'];
				}
				//=====================================================================================
				//=================================Cash Transfer in petty cash====================== (3/6/19)
				$cash_transfer_in_petty_cash=0;
				$sel_transf="select SUM(amount) as total_amt from receipt where cash_transfer_mode='cash_to_cash' and added_date='".$date."' ".$branch_id." ";
				$ptr_cash_transf=mysql_query($sel_transf);
				if(mysql_num_rows($ptr_cash_transf))
				{
					$data_cash_transfer=mysql_fetch_array($ptr_cash_transf);
					$cash_transfer_in_petty_cash=$data_cash_transfer['total_amt'];
				}
				//===================================================================================
				$prv_date = trim(date('Y-m-d',strtotime('-1 day', strtotime($date))));
				//$opening_cash=$total_yest_bal;
				$opening_cash1='';
				$opening_petty_cash=0; //(3/6/19)
				$sele_yest_bal="select cash_in_hand,petty_cash_in_hand from dsr where 1 ".$branch_id." and added_date = '".$prv_date."' order by dsr_id desc limit 0,1"; //where added_date = '".$prv_date."'
				$ptr_yest1=mysql_query($sele_yest_bal);
				if(mysql_num_rows($ptr_yest1))
				{
					$data_yest_bal=mysql_fetch_array($ptr_yest1);
					$opening_cash1=$data_yest_bal['cash_in_hand'];
					$opening_petty_cash=$data_yest_bal['petty_cash_in_hand']; //(3/6/19)
				}
				$tota_exp=$data_product['total_amt']+$data_total_expense['total_amt']+$data_total_refund['total_amt'];
			 	$message.= '<tr>';
				$message.= '<td align="center" style="border:1px solid #CCC">'.$opening_cash1.'</td> ';
				$message.= '<td align="center" style="border:1px solid #CCC">'.$opening_petty_cash.'</td> ';
				
				$message.= '<td align="center" style="border:1px solid #CCC">Fees- '.$data_ptr_sel['total_amt'].'<br /><hr />Product- '.$data_sales_product['total_amt'].'<br /><hr />Service- '.$total_service.'<br /><hr />Membership - '.$data_sales_membership['total_amt'].'<br /><hr >Package - '.$data_sales_package['total_amt'].'<br /><hr >Voucher - '.$data_sales_voucher['total_amt'].'<br /><hr >Receipt - '.$data_sel_recipt['total_amt'].'<br/><hr>Cash Transfer - '.$data_cash_rec['total_amt'].'</td>';//(3/6/19)
				
				/*$message.= '<td align="center" style="border:1px solid #CCC">'.$data_expense_taken['total_amt'].'</td>';*/
				$message.= '<td align="center" style="border:1px solid #CCC"><strong>'.$data_cash_received_sir['total_amt'].'</strong><br/><hr style="color: #1395D2">Cash Received From Sir in Petty Cash<br/><br/><strong>'.$data_cash_received_sir_in_petty['total_amt'].'</strong><br/><hr style="color: #1395D2">Cash Received in Petty Cash<br/><br/><strong>'.$data_sel_recipt_petty_cash['total_amt'].'</strong></td>';//cash received from sir
				$message.= '<td align="center" style="border:1px solid #CCC">'.$tota_exp.'<br/><hr style="color: #1395D2">Total Cash Expense  From Business cash<br/><br/>'.$tota_exp_business.'</td>';//total cash expense
				$message.= '<td align="center" style="border:1px solid #CCC">'.$data_cash_from_sir_business['total_amt'].'<br/><hr style="color: #1395D2">Cash Given to Director From Petty Cash<br/>'.$data_cash_from_sir_petty['total_amt'].'</td>';//Cash given to director
				$message.= '<td align="center" style="border:1px solid #CCC">';
				//======================================Cash Deposited in Bank=========================================
				$sel_dist_bank_id="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode!='cash_to_cash') and cash_type='business_cash' and payment_mode_id='1' ".$branch_id."";
				$ptr_dist_bank_id=mysql_query($sel_dist_bank_id);
				$total=mysql_num_rows($ptr_dist_bank_id);
				$i=1;
				$xx='';
				$tt='';
				while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
				{
					$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";
					$ptr_cash_from_bank=mysql_query($sel_cash_from_bank);
					$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
					
					$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='business_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_bank_amnt=mysql_query($sel_bank_amnt);
					$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
					
					$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
					
					$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					//$message.= $data_bank_name['bank_name']." : ".$data_cash_from_bank['total_amt'] ;
					
					$xx.= $data_bank_name['bank_name']." : ".$total_bank_bal;
					$tots +=$total_bank_bal;
					$tt +=$data_cash_from_bank['total_amt'];
					if($i !=$total)
					{
						$xx.= '<br /><hr >';
					}
					$i++;
				}
				$message.= $xx;
				$message.= "<br/><strong>Total : ".$tots.'</strong><br/>';
				$message.='<hr style="color: #1395D2">';
				$message.='<br/><strong>Cash Deposited in Bank From Petty Cash (Q)</strong><br/><br/>';
				
				//============Cash Deposited in Bank From Petty Cash=================================
				$sel_dist_bank_id1="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and (category ='cash_transfer' and category !='voucher' and cash_transfer_mode !='inword' and cash_transfer_mode!='cash_to_cash') and cash_type='petty_cash' and payment_mode_id='1' ".$branch_id."";
				$ptr_dist_bank_id=mysql_query($sel_dist_bank_id1);
				$total1=mysql_num_rows($ptr_dist_bank_id);
				$i1=1;
				$xx1='';
				$tt1='';
				while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
				{
					$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='outword' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";
					$ptr_cash_from_bank=mysql_query($sel_cash_from_bank);
					$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
					
					$sel_bank_amnt="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category ='cash_transfer' and cash_transfer_mode ='bank_to_bank' and cash_type='petty_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_bank_amnt=mysql_query($sel_bank_amnt);
					$data_bank_amnt=mysql_fetch_array($ptr_bank_amnt);
					
					$total_bank_bal=$data_cash_from_bank['total_amt']+$data_bank_amnt['total_amt'];
					
					$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					//$message.= $data_bank_name['bank_name']." : ".$data_cash_from_bank['total_amt'] ;
					
					$xx1.= $data_bank_name['bank_name']." : ".$total_bank_bal;
					$tots1 +=$total_bank_bal;
					$tt1 +=$data_cash_from_bank['total_amt'];
					if($i1 !=$total1)
					{
						$xx1.= '<br /><hr >';
					}
					$i1++;
				}
				$message.= $xx1;
				$message.= "<br/><strong>Total : ".$tots1.'</strong><br/>';
				//===================================================================================
				$message.= '</td>';
				
				//----------------------------------------------------CASH DEPSOIT IN BANK from PETYY CASH---------------------------------
				/*$sel_dist_bank_id1="Select DISTINCT(bank_id) from receipt where added_date='".$date."' and bank_id !='' and category ='cash_transfer' and category !='voucher' and category !='cash_to_cash' and payment_mode_id='1' ".$branch_id."";// 29-12-17 category !='cash_transfer'
				$ptr_dist_bank_id1=mysql_query($sel_dist_bank_id1);
				$total=mysql_num_rows($ptr_dist_bank_id1);
				$it=1;
				$tam='';
				while($data_dist_bank_id1=mysql_fetch_array($ptr_dist_bank_id1))
				{
					$sel_cash_from_bank1="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id1['bank_id']."' and category ='cash_transfer' and category !='voucher' and category !='cash_to_cash' and payment_mode_id='1' and added_date='".$date."' ".$branch_id." ";// 29-12-17 category !='cash_transfer'
					$ptr_cash_from_bank1=mysql_query($sel_cash_from_bank1);
					$data_cash_from_bank1=mysql_fetch_array($ptr_cash_from_bank1);
					
					$sel_bank1="select bank_name from bank where bank_id='".$data_cash_from_bank1['bank_id']."'";
					$ptr_bank1=mysql_query($sel_bank1);
					$data_bank_name1=mysql_fetch_array($ptr_bank1);
					
					//echo $data_bank_name['bank_name']." : ".$data_cash_from_bank1['total_amt'] ;
					$tam +=$data_cash_from_bank1['total_amt'];
					
					//if($i !=$total)
//					{
//						echo '<br /><hr >';
//					}
					$it++;
				}*/
			//--------------------------------------------------------------------------------------------------------------
				//========================================END CASH DEPOSIT IN BANK===================================================
				//===============================================Cash in Hand========================================================
				$sel_total_inc1="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".$date."' and (bank_name='' or bank_name= 'select') ".$branch_id."";
				$ptr_total_inc1=mysql_query($sel_total_inc1);
				$data_total_inc1=mysql_fetch_array($ptr_total_inc1);
				
				$sel_total_inc21="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and category !='voucher' and added_date='".$date."' and bank_id='' ".$branch_id."";
				$ptr_total_inc21=mysql_query($sel_total_inc21);
				$data_total_inc21=mysql_fetch_array($ptr_total_inc21);
				
				$cash_in_hand=$data_total_inc1['total_amt']+$data_total_inc21['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				 
				$total_cash_fees=$data_ptr_sel['total_amt'] ;
				$total_cash_product= $data_sel_recipt['total_amt'];
				
				$cash_in_hands=$opening_cash1 + $data_ptr_sel['total_amt'] +$data_sel_recipt['total_amt'] +$total_service +$data_sales_product['total_amt']+$data_cash_received_sir['total_amt'] +$data_sel_voucher['total_amt']+$data_sales_membership['total_amt']+$data_sales_package['total_amt']+$data_sales_voucher['total_amt']+$data_cash_rec['total_amt']-$cash_transfer_in_petty_cash- $data_cash_from_sir_business['total_amt'] - $tota_exp_business - $tots ;//+ $data_cash_from_innocent['total_amt'] - $tt  - $data_total_expense['total_amt'] (3/6/19)
				
				//==========================================PETTY CASH IN HAND==================================================
				$petty_cash_in_hands=intval($data_sel_recipt_petty_cash['total_amt']+$opening_petty_cash+$cash_withdrawl_in_petty_cash+$cash_transfer_in_petty_cash - $tota_exp - $data_cash_from_sir_petty['total_amt']+$data_cash_received_sir_in_petty['total_amt'] - $tots1); //(3/6/19)
				//=============================================================================================================
				$message.= '<td align="center" style="border:1px solid #CCC">'.$cash_withdrawl_in_petty_cash.'  <hr style="color: #1395D2"><strong>Cash Transfer from business cash to petty cash</strong><br/><br/>'.$cash_transfer_in_petty_cash.'</td>';//(3/6/19)
				$message.= '<td align="center" style="border:1px solid #CCC">'.$cash_in_hands.'</td>' ;
				$message.= '<td align="center" style="border:1px solid #CCC">'.$petty_cash_in_hands.'</td>' ;//(3/6/19)
				$message.= '</tr>';
				$message.='  </table>
				</td>
			</tr>';
  
//=============================================MONTHLY SALE=========================================================
 $message.='
<tr>
	<td align="center" colspan="12">&nbsp;</td>
</tr>
<tr bgcolor="#AFD8E0">
	<td align="center" colspan="12"><strong>Monthly Sale</strong></td>
</tr>
<tr >
	<td align="center" colspan="12">&nbsp;</td>
</tr>';  
$message.='<tr>
 <td colspan="11" >
 <table cellspacing="2" cellpadding="2" width="100%" style="border:1px solid #999">
 	<tr class="grey_td" style="background-color:#999;color: black">
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Enrollment</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Receipt</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Product Sale</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Service</strong></td>
    <td width="10%" align="center" style="border:1px solid #CCC"><strong>Sale Vouchre/Package</strong></td>
	<td width="12%" align="center" style="border:1px solid #CCC"><strong>Expense</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Product Purchase</strong></td>
</tr>';
		$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(`added_date`) >= '".date('Y-m')."-01' and DATE(`added_date`) <= '".date('Y-m-d')."' ".$branch_id."";
		$ptr_total_inc=mysql_query($sel_total_inc);
		$data_total_inc=mysql_fetch_array($ptr_total_inc);
		//============================================
		$sel_total_servicec="select SUM(payable_amount) as total_amt from customer_service where payable_amount>'0' and DATE(`added_date`) >= '".date('Y-m')."-01' and DATE(`added_date`) <= '".date('Y-m-d')."' ".$branch_id."";
		$ptr_total_service=mysql_query($sel_total_servicec);
		$data_total_service=mysql_fetch_array($ptr_total_service);
		$sql_customer= "SELECT price FROM customer where DATE(`added_date`) >= '".date('Y-m')."-01' and DATE(`added_date`) <= '".date('Y-m-d')."' and membership ='yes' ".$branch_id." "; 
		$ptr_customer=mysql_query($sql_customer);
		while($data_customer=mysql_fetch_array($ptr_customer))
		{
			$price +=$data_customer['price'];
		}
		$total_service_amount=$data_total_service['total_amt']+$price;
		//=================================================
		$sel_total_prod="SELECT SUM(payable_amount) as total_amt FROM sales_product_invoice where DATE(`added_date`) >= '".date('Y-m')."-01' and DATE(`added_date`) <= '".date('Y-m-d')."' and payable_amount>0 ".$branch_id."";
		$ptr_total_prod=mysql_query($sel_total_prod);
		$data_total_prod=mysql_fetch_array($ptr_total_prod);
		$total_product_amount=$data_total_prod['total_amt'];
		//==================================================
		$sel_sales_pack="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where membership_id='0' and DATE(`added_date`) >= '".date('Y-m')."-01' and DATE(`added_date`) <= '".date('Y-m-d')."' ".$branch_id."";
		$ptr_sales_pack=mysql_query($sel_sales_pack);
		$data_sales_pack=mysql_fetch_array($ptr_sales_pack);
		$total_sales_pack=intval($data_sales_pack['total_amt']);
		//==================================================
		$sel_total_recp="select SUM(amount) as total_amt from receipt where category='incoming' and cash_type='business_cash' and DATE(`added_date`) >='".date('Y-m')."-01' and DATE(`added_date`) <= '".date('Y-m-d')."' ".$branch_id."";
		$ptr_total_recp=mysql_query($sel_total_recp);
		$data_total_recp=mysql_fetch_array($ptr_total_recp);
		$total_receipt=intval($data_total_recp['total_amt']);
		//==================================================
		$select_inv="select SUM(payable_amount) as total from inventory_invoice where DATE(`added_date`) >= '".date('Y-m')."-01' and DATE(`added_date`) <= '".date('Y-m-d')."' ".$branch_id." ";
		$ptr_inv=mysql_query($select_inv);
		$total_inv=0;
		if(mysql_num_rows($ptr_inv))
		{
			$data_inv=mysql_fetch_array($ptr_inv);
			$total_inv=$data_inv['total'];
		}
		//=================================================		
		$select_amnt1="select SUM(amount) as total from expense where DATE(`added_Date`) >= '".date('Y-m')."-01' and DATE(`added_Date`) <= '".date('Y-m-d')."' ".$branch_id." ";
		$ptr_amt1=mysql_query($select_amnt1);
		$total_exp=0;
		if(mysql_num_rows($ptr_amt1))
		{
			$data_amnt1=mysql_fetch_array($ptr_amt1);
			$total_exp=$data_amnt1['total'];
		}
		
		//==================================================
		$select_refund="select SUM(total_refund) as total from enrollment_refund where DATE(`added_Date`) >= '".$date_for_month."-01' and DATE(`added_Date`) <= '".$date."' ".$branch_id." ";
		$ptr_refund=mysql_query($select_refund);
		$total_refund=0;
		if(mysql_num_rows($ptr_refund))
		{
			$data_refund=mysql_fetch_array($ptr_amt1);
			$total_refund=$data_refund['total'];
		}
		$total_amount1=$total_exp+$total_refund;
		//====================================================
		$message.= '<tr>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.round($data_total_inc['total_amt'],2).'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.round($total_receipt,2).'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.round($total_product_amount,2).'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.round($total_service_amount,2).'</td>';		
		$message.= '<td align="center" style="border:1px solid #CCC">'.round($total_sales_pack,2).'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.round($total_amount1,2).'</td>';
		$message.= '<td align="center" style="border:1px solid #CCC">'.round($total_inv,2).'</td>';
		$message.= '</tr>';

$message.='</table>
   </td>
  </tr>';
//==========================================================================================================================================
  
   
$message.='   <tr>
  	<td colspan="12" style="color:#F00">Note -:<br/>
    <strong>Total Cash Revenue (Product)</strong> -: It calculated Excluding <strong>Inoncent</strong> and <strong>Director</strong> taken from Receipt<br />
    <strong>Total Cash Expense -:</strong> It calculate Excluding "<strong>Cash Given to Director</strong>" taken from Expense <br />
    </td>
  </tr>';
$message.='</table>';
					
						/*------------send a mail to admin about this---------------------*/
						$subject = " DSR Report for ISAS Singhgad Branch";
							
						$sendMessage=$GLOBALS['box_message_top'];
						echo $sendMessage.=$message;
						echo "<input type='hidden' name='mail_content' id='mail_content' value='".addslashes($sendMessage)."' >";
						
						?>
                        	<script>
							//send();
							</script>
                        <?php
						 
						/*$sendMessage.=$GLOBALS['box_message_bottom'];
						$from_id='support<support@'.$GLOBALS['siteUrlName'].'>';
						$headers= 'MIME-Version: 1.0' . "\n";
						$headers.='Content-type: text/html; charset=utf-8' . "\n";
						$headers.='From:'.$from_id;*/
						
						
						//=======================================================================================================================================
						/*"<br/>".$select_email_id = " select email_id from sms_mail_configuration where email_id !='' and status='active'";
						$ptr_emails = mysql_query($select_email_id);
						$total_manag=mysql_num_rows($ptr_emails); 
						$i=1;
						$bcc='';
						while($data_emails = mysql_fetch_array($ptr_emails))
						{
							//echo "<br />".$data_emails['email'];
							$bcc =$data_emails['email_id'];
							if($i<$total_manag)
							//$bcc .=',';
							///mail($data_emails['email_id'], $subject, $sendMessage, $headers);
							$mail->addAddress($bcc); 
							$mail->WordWrap = 50;
							$mail->isHTML(true); 
							 
							$mail->Subject = $subject;
							$mail->Body    = $sendMessage;
							 
							if($mail->send())
							{
								echo '<br/>email sent to '.$bcc.'';	
							}
							else
							{ 
								//echo '<br/>Error in sending email ';
							}*/
							
						
							?>
						
                        <script>
						//setTimeout(send_emil_to_oceanone(<?php //echo urlencode($bcc); ?>, '<?php //echo urlencode($subject); ?>','<?php //echo urlencode($sendMessage) ; ?>' ,'<?php ///echo urlencode($headers); ?>'),500);
						</script>
                        <?php
						/*
							$i++;
						}*/
						//echo "<br/>"."$bcc";
						
						//===============================================================================================================================
						
						//===================================================================================
						/*$mail = new PHPMailer(true);
						try {
								//$mail->IsSMTP();                                      // Set mailer to use SMTP
								$mail->SMTPDebug=1;   
								$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
								$mail->SMTPAuth = true;                               // Enable SMTP authentication
								$mail->Username = 'erp.isas@gmail.com';                   // SMTP username
								$mail->Password = 'erp@08isas';                            // SMTP password
								$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
								$mail->Port = 465;
								
								$mail->setFrom('learn@isasbeautyschool.org', 'ISAS');
								
								$mail->addAddress("vyavaharekiran@gmail.com"); 
								
								$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='103'";
								$ptr_sel_sms=mysql_query($sel_sms_cnt);
								$tot_num_rows=mysql_num_rows($ptr_sel_sms);
								$i=0;
								while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
								{
									"<br/>".$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' and type!='S' ";
									$ptr_cnt=mysql_query($sel_act);
									if(mysql_num_rows($ptr_cnt))
									{
										$data_cnt=mysql_fetch_array($ptr_cnt);
										$emailss=trim($data_cnt['email']);
										$mail->addCC("$emailss"); 
										$i++;
									}
								}
								
								"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' and email!='' ";
								$ptr_cnt=mysql_query($sel_act);
								if(mysql_num_rows($ptr_cnt))
								{
									$j=$tot_num_rows;
									while($data_cnt=mysql_fetch_array($ptr_cnt))
									{
										$email2=trim($data_cnt['email']);
										$mail->addCC("$email2"); 
										$j++;
									}
								}
								///usr/local/bin/php -q /home/isasadmin007/isastest/faculty_login/dsr_mail.php?&send_mail=mail
								///bin/touch /home/isasadmin007/public_html/cron_test.txt >/dev/null 2>&1 && /bin/echo "Cron ran at: `date`" >> /home/isasadmin007/public_html/cron_test.txt
								$mail->Subject = 'DSR report For Pune Branch on- '.$date.'';
								
								$sendMessage=$GLOBALS['box_message_top'];
								$sendMessage.=$message;
								$sendMessage.=$GLOBALS['box_message_bottom'];
								
								 $mail->WordWrap = 3000; 
								 $mail->isHTML(true);                                  
								 $mail->Body    = $sendMessage;
								 
							
								$mail->Send();
								echo "Email Sent Successfully.";
							} catch (phpmailerException $e) {
							  echo $e->errorMessage(); 
							} catch (Exception $e) {
							  echo $e->getMessage(); 
							}	*/
							
							//===================================================================================//21-12-17
							$mail = new PHPMailer(true);
							try {
									//$mail->IsSMTP();                                      // Set mailer to use SMTP
									$mail->SMTPDebug=1;   
									$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
									$mail->SMTPAuth = true;                               // Enable SMTP authentication
									$mail->Username = 'erp.isas@gmail.com';                   // SMTP username
									$mail->Password = 'erp@frespa';                            // SMTP password
									$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
									$mail->Port = 465;
									$mail->setFrom('info@isasbeautyschool.com', 'ISAS');
									$mail->addAddress("erp.isas@gmail.com"); 
									
									$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='103' and cm_id='".$cm_id1."'";
									$ptr_sel_sms=mysql_query($sel_sms_cnt);
									$tot_num_rows=mysql_num_rows($ptr_sel_sms);
									$i=0;
									while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
									{
										"<br/>".$sel_act="select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' and email!='' and type!='S' ";
										$ptr_cnt=mysql_query($sel_act);
										if(mysql_num_rows($ptr_cnt))
										{
											$data_cnt=mysql_fetch_array($ptr_cnt);
											$emailss=trim($data_cnt['email']);
											$mail->addCC("$emailss"); 
											$i++;
										}
									}
									
									"<br/>".$sel_act="select contact_phone,email from site_setting where type='S' and email!='' ";
									$ptr_cnt=mysql_query($sel_act);
									if(mysql_num_rows($ptr_cnt))
									{
										$j=$tot_num_rows;
										while($data_cnt=mysql_fetch_array($ptr_cnt))
										{
											$email2=trim($data_cnt['email']);
											$mail->addCC("$email2"); 
											$j++;
										}
									}
									
									///usr/local/bin/php -q /home/isasadmin007/isastest/faculty_login/dsr_mail.php?&send_mail=mail
									///bin/touch /home/isasadmin007/public_html/cron_test.txt >/dev/null 2>&1 && /bin/echo "Cron ran at: `date`" >> /home/isasadmin007/public_html/cron_test.txt
									$mail->Subject = 'DSR Report For ISAS Singhgad Branch- '.$date.'';
									
									$sendMessage=$GLOBALS['box_message_top'];
									$sendMessage.=$message;
									$sendMessage.=$GLOBALS['box_message_bottom'];
									
									$mail->WordWrap = 3000; 
									$mail->isHTML(true);                                  
									$mail->Body    = $sendMessage;
									 
								
									$mail->Send();
									echo "Email Sent Successfully.";
								} catch (phpmailerException $e) {
								  echo $e->errorMessage(); 
								} catch (Exception $e) {
								  echo $e->getMessage(); 
								}	
							//================================================================================	
						//================================================================================	
						?>
						
                        <script>
						//send_emil_to_oceanone('<?php //echo urlencode($bcc); ?>', '<?php //echo urlencode($subject); ?>','<?php //echo urlencode($sendMessage) ; ?>' ,'<?php //echo urlencode($headers); ?>');
						</script>
                        <?php
						"<br/>".$sel_dsr="select dsr_id from dsr where added_date='".$date."' and cm_id='".$cm_id1."'";
						$ptr_dsr=mysql_query($sel_dsr);
						if(mysql_num_rows($ptr_dsr))
						{
							$update_dsr="update dsr set total_incoming='".$total_todays_bal."',total_outgoing='".$total_amount1."',`yesterday_bal`='".$opening_cash1."',`total_cash_fees`='".$data_ptr_sel['total_amt']."',`total_cash_product`='".$data_sel_recipt['total_amt']."',`total_cash_taken_from_bank`='".$data_expense_taken['total_amt']."',`cash_received_from_director`='".intval($data_cash_received_sir['total_amt']+$data_cash_received_sir_in_petty['total_amt'])."',`total_cash_expense`= '".intval($tota_exp+$tota_exp_business)."',`cash_given_to_director`='".intval($data_cash_from_sir_business['total_amt']+$data_cash_from_sir_petty['total_amt'])."',`cash_received_from_innocent`='".$data_cash_from_innocent['total_amt']."',`cash_in_hand`='".$cash_in_hands."',`cash_withdrawl_from_petty_cash`='".$cash_withdrawl_in_petty_cash."',`petty_cash_in_hand`='".$petty_cash_in_hands."' where added_date='".$date."' and cm_id='".$cm_id1."'";
							$ptr_update=mysql_query($update_dsr);	//(3/6/19)
						}
						else
						{
							$insert_dsr="insert into dsr(`total_incoming`, `total_outgoing`, `yesterday_bal`, `total_cash_fees`, `total_cash_product`, `total_cash_taken_from_bank`, `cash_received_from_director`, `total_cash_expense`, `cash_given_to_director`, `cash_received_from_innocent`,`cash_withdrawl_from_petty_cash`,`cash_in_hand`, `petty_cash_in_hand`,`added_date`,`cm_id`) values ('".$total_todays_bal."','".$total_amount1."','".$opening_cash1."','".$data_ptr_sel['total_amt']."','".$data_sel_recipt['total_amt']."','".$data_expense_taken['total_amt']."','".intval($data_cash_received_sir['total_amt']+$data_cash_received_sir_in_petty['total_amt'])."','".intval($tota_exp+$tota_exp_business)."','".intval($data_cash_from_sir_business['total_amt']+$data_cash_from_sir_petty['total_amt'])."','".$data_cash_from_innocent['total_amt']."','".$cash_withdrawl_in_petty_cash."','".$cash_in_hands."','".$petty_cash_in_hands."','".$date."','".$cm_id1."')";
							$ptr_insert=mysql_query($insert_dsr); //(3/6/19)
						}
						$sel_bank_id="select bank_id from bank where cm_id='".$cm_id1."'";
						$ptr_bank_ids=mysql_query($sel_bank_id);
						if(mysql_num_rows($ptr_bank_ids))
						{
							while($data_bank_id=mysql_fetch_array($ptr_bank_ids))
							{
								$sel_bank="select bank_name,account_no from bank where bank_id='".$data_bank_id['bank_id']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								$sel_inv="select SUM(amount) as total_amt,bank_name from invoice where bank_name='".$data_bank_id['bank_id']."' and DATE(`added_date`)='".$date."'";
								$ptr_amnt=mysql_query($sel_inv);
								$total=mysql_num_rows($ptr_amnt);
								$data_ptr_sel=mysql_fetch_array($ptr_amnt);
								//==============================================================================================================================================
								/*$sel_recpt="select SUM(amount) as total_amt from receipt where bank_id='".$data_bank_id['bank_id']."' and category !='cash_transfer' and added_date='".$date."'";
								$ptr_bank_id=mysql_query($sel_recpt);
								$data_sel_recipt=mysql_fetch_array($ptr_bank_id);*/
								
								$sel_expense="select SUM(amount) as total_amt from expense where bank_id='".$data_bank_id['bank_id']."' and added_date='".$date."'";
								$ptr_expense_bank_id=mysql_query($sel_expense);
								$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
								
								$sel_receipt_out="select SUM(amount) as total_amt from receipt where bank_id='".$data_bank_id['bank_id']."' and cash_transfer_mode='inword'  and added_date='".$date."' ".$branch_id." ";
								$ptr_bank_id_out=mysql_query($sel_receipt_out);
								$data_sel_recipt_out=mysql_fetch_array($ptr_bank_id_out);
								
								$sel_exp="select SUM(payable_amount) as total_amt from inventory_invoice where bank_id='".$data_bank_id['bank_id']."' and DATE(added_date)='".$date."'";
								$ptr_exp=mysql_query($sel_exp);
								$data_exp_purchase=mysql_fetch_array($ptr_exp);
															
								$sel_cc_expense="select SUM(amount) as total_amt from expense where cc_bank_name='".$data_bank_id['bank_id']."' and added_date='".$date."' ".$branch_id."";
								$ptr_cc_expense=mysql_query($sel_cc_expense);
								$data_cc_expense=mysql_fetch_array($ptr_cc_expense);
								//==============================================================================================================================================
								$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_bank_id['bank_id']."' and DATE(`added_date`) = '".$date."'";
								$ptr_total_inc=mysql_query($sel_total_inc);
								$data_total_inc=mysql_fetch_array($ptr_total_inc);
								
								$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_bank_id['bank_id']."' and (cash_transfer_mode = 'outword' OR cash_transfer_mode IS NULL ) and added_date='".$date."'";
								$ptr_total_inc2=mysql_query($sel_total_inc2);
								$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
								
								$sel_total_inc3="select SUM(payable_amount) as total_amt from sales_product_invoice where bank_id='".$data_bank_id['bank_id']."' and DATE(added_date)='".$date."'";
								$ptr_total_inc3=mysql_query($sel_total_inc3);
								$data_total_inc3=mysql_fetch_array($ptr_total_inc3);
								
								$sel_total_inc4="select SUM(payable_amount) as total_amt from customer_service_invoice where bank_id='".$data_bank_id['bank_id']."'  and DATE(added_date)='".$date."' ".$branch_id."";
								$ptr_total_inc4=mysql_query($sel_total_inc4);
								$data_total_inc4=mysql_fetch_array($ptr_total_inc4);
								
								$sel_total_inc5="select SUM(payable_amount) as total_amt from sales_package_voucher_memb where bank_id='".$data_bank_id['bank_id']."'  and DATE(added_date)='".$date."' ".$branch_id."";
								$ptr_total_inc5=mysql_query($sel_total_inc5);
								$data_total_inc5=mysql_fetch_array($ptr_total_inc5);
								/*$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_bank_id['bank_id']."' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
								$ptr_total_inc=mysql_query($sel_total_inc);
								$data_total_yesterday=mysql_fetch_array($ptr_total_inc);
								$data_total_yest = $data_total_yesterday['total_amt'];
								
								$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_bank_id['bank_id']."' and category !='cash_transfer' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
								$ptr_total_inc2=mysql_query($sel_total_inc2);
								$data_total_yesterday2=mysql_fetch_array($ptr_total_inc2);
								$data_total_yest2 = $data_total_yesterday2['total_amt'];
								$yesterday_bal=$data_total_yest+$data_total_yest2;*/
								
								$total_incomming=$data_total_inc['total_amt']+$data_total_inc2['total_amt']+$data_total_inc3['total_amt']+$data_total_inc4['total_amt']+$data_total_inc5['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
								
								$total_outgoing=intval($data_sel_expense['total_amt']+$data_exp_purchase['total_amt']+$data_sel_recipt_out['total_amt']+$data_cc_expense['total_amt']);
								//$incomming=$data_total_inc2['total_amt']+$data_ptr_sel['total_amt'];
								
								$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_bank_id['bank_id']."' and added_date<'".$date."' ".$branch_id."  order by added_date desc limit 0,1";
								$ptr_yest=mysql_query($sele_yesterday_bal);
								$data_yesterday=mysql_fetch_array($ptr_yest);
								$today_total_bal=intval($total_incomming+$data_yesterday['todays_balance'])-intval($total_outgoing);
		
								"<br/>".$sel_bank_sm="select dsr_bank_id from dsr_bank_summery where bank_id='".$data_bank_id['bank_id']."' and cm_id='".$cm_id1."' and added_date='".$date."'";
								$ptr_bank_sm=mysql_query($sel_bank_sm);
								if(mysql_num_rows($ptr_bank_sm))
								{
									"<br/>".$update_bank_sm="update dsr_bank_summery set incoming='".$total_incomming."',outgoing='".$total_outgoing."',yesterdas_balance='".$data_yesterday['todays_balance']."', todays_balance='".$today_total_bal."' where bank_id='".$data_bank_id['bank_id']."' and cm_id='".$cm_id1."' and added_date='".$date."'  ";
									$ptr_update_sm=mysql_query($update_bank_sm);
									
								}
								else
								{
									"<br/>".$insert_into_dsr_bank=" insert into dsr_bank_summery (`bank_id`,`account_no`,`incoming`,`outgoing`,`yesterdas_balance`,`todays_balance`,`added_date`,`cm_id`) values('".$data_bank_id['bank_id']."','".$data_bank_name['account_no']."','".$total_incomming."','".$total_outgoing."','".$data_yesterday['todays_balance']."','".$today_total_bal."','".$date."','".$cm_id1."')";
									$ptr_banks=mysql_query($insert_into_dsr_bank);
								}
							}						
						}
//echo "<br/>Mail sent";  
							
						/*-------------------------------------------------------------------------*/
				
?><script>
//setTimeout('document.location.href="dsr_report.php";',2000);
</script>
<?php
?>

</body>
</html>
