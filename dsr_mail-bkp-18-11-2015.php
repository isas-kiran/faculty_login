<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Mail</title>
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
<body>

<?php

if($_GET['baranch_id'] =='' )
{
	$branch_id= $_SESSION['where'];
	$cm_id1= $_SESSION['cm_id'];
	$branch_name='';
}
else
{
	$branch_id= "and cm_id = '".$_GET['baranch_id']."'";
	$cm_id1= $_GET['baranch_id'];
	
	$sel_branch_name="select branch_name from site_setting where cm_id=".$cm_id1." and type='A'";
	$ptr_branch_name=mysql_query($sel_branch_name);
	$data_branch=mysql_fetch_array($ptr_branch_name);
	$branch_name=" For ".$data_branch['branch_name']." branch";
}



$message.=  '<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
<tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incomming Courses</strong></td>
  </tr>
  <tr>';
  
  
  //===================Total receive balance===============================
  
	$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".date('Y-m-d')."' ".$branch_id."";
	$ptr_total_inc=mysql_query($sel_total_inc);
	$data_total_inc=mysql_fetch_array($ptr_total_inc);
	
	$sel_total_inc2="select SUM(amount) as total_amt from receipt where added_date='".date('Y-m-d')."' and category !='cash_transfer' ".$branch_id." ";
	$ptr_total_inc2=mysql_query($sel_total_inc2);
	$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
	
	$total_todays_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
//==============================================================================
  
 /* $select_amnt1="select SUM(amount) as total from receipt order by receipt_id desc limit 0,1";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}*/
 $message.=' <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> :'.$total_todays_bal.'</td> 
  </tr>';
 /* $message.='<tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="50%" align="center" style="border:1px solid #CCC"><a href="'.$_SERVER['PHP_SELF'].'?order='.$order.'."&orderby=category".'.$query_string.'" class="table_font"><strong>Payment Mode</strong></a>  '.$img1.';</td>
     <td width="35%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
   </tr>';
		$sel_inv="select paid_type from invoice where  DATE(`added_date`) = ".date('Y-m-d')." ";
		$ptr_amnt=mysql_query($sel_inv);
		$i=1;
		if(mysql_num_rows($ptr_amnt))
		{
			while($data_ptr_sel=mysql_fetch_array($ptr_amnt))
			{
				$sele_pay_mode="select payment_mode from payment_mode where payment_mode_id=".$data_ptr_sel['paid_type']."";
				$ptr_pay_mode=mysql_query($sele_pay_mode);
				$data_pay_mode=mysql_fetch_array($ptr_pay_mode)	;
				
				$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='".$data_ptr_sel['paid_type']."'";
				$ptr_amnt=mysql_query($sel_inv);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				
				$message.= '<tr>';
				$message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
				$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_mode['payment_mode'].'</td>';
				$message.= '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel['total_amt'].'</td>';
				$i++;
			}
		}
		else
		{
			$message.= '<tr><td class="text" align="center" colspan="3" ><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Amount added by any Payment modes on today</div><br></td></tr>';
		}
   $message.= '</table>
   </td>
  </tr>';*/
                        
						$select_directory='order by enroll_id asc';                      
						$sql_query= "SELECT * FROM enrollment where added_date='".date('Y-m-d')."' ".$branch_id."  ".$pre_keyword." ".$select_directory.""; 
                      	//echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
						$message.=' <tr class="grey_td" style="background-color:#999;color: black">
						<td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Sale Type</strong></td>
						<td width="20%" align="center" style="border:1px solid #CCC"><strong>Student Name</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
						<td width="10%" align="center" style="border:1px solid #CCC"><strong>Chaque No</strong></td>
						<td width="10%" style="border:1px solid #CCC"><strong>Amount</strong></td>
							
						</tr>';
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            
                            while($val_query=mysql_fetch_array($all_records))
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
                                $message.= '<td align="center" style="border:1px solid #CCC">'.$sr_no.'</td>';    
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
                                                                
                                $bgColorCounter++;
                            }    
						}
						else
						{
         				$message.= '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Student record added on today</div><br></td></tr>';
						}
						
		
		
						
	  $message.='
	  <tr>
 <td align="center" colspan="10">&nbsp;</td>
 </tr>
	  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Outgoing</strong></td>
  </tr>
  
  <tr>';
  
 $select_amnt1="select SUM(amount) as total from expense where added_Date='".date('Y-m-d')."' ".$branch_id." ";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
 
$message.='  <td align="left" colspan="10" style="color:#F00"><strong>Total Outgoing</strong> :'.$total_amount1.'</td> </tr>';					
						
						
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
    
	$sele_exp="select expense_id,expense_type_id,employee_id,vendor_id,payment_mode_id,bank_id from expense where  added_Date='".date('Y-m-d')."' ".$branch_id."";
	$ptr_exp=mysql_query($sele_exp);
	$i=1;
	if(mysql_num_rows($ptr_exp))
	{
		while($data_exp=mysql_fetch_array($ptr_exp))
		{
			$exp_name="select expense_type from expense_type where expense_type_id=".$data_exp['expense_type_id']."";
			$ptr_expense=mysql_query($exp_name);
			$data_expense=mysql_fetch_array($ptr_expense);
			
			$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."'  and added_Date='".date('Y-m-d')."' and expense_id= '".$data_exp['expense_id']."' ";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
			
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id=".$data_exp['payment_mode_id']."";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_emp="select name from site_setting where admin_id=".$data_exp['employee_id']."";
			$ptr_emp=mysql_query($sel_emp);
			$data_emp=mysql_fetch_array($ptr_emp);
			
			$sel_vendor="select name from vendor where vendor_id=".$data_exp['vendor_id']."";
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
	else
	{
		$message.= '<tr><td class="text" align="center" colspan="7"><br><div class="msgbox" style="width:50%; background-color:green;color:white">No Amount added by any Expense mode on today</div><br></td></tr>';
	}

 $message.='</table>
   </td>
  </tr>';
  
  
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
if($_GET['baranch_id']=="")
{
	
	$cm_idA='';
	$cm_idC='';
}
else
{
	$cm_idA="and A.cm_id= ".$cm_id1."";
	$cm_idC="and C.cm_id= ".$cm_id1."";
}   
 
	$sel_inv1="Select A.bank_name
From invoice A Left Outer Join
     receipt B on A.bank_name = B.bank_id where  DATE(A.added_date) = '".date('Y-m-d')."' and (A.bank_name !='') and (A.bank_name !='select') ".$cm_idA."
Union
Select C.bank_id
From receipt C left join
     invoice D on C.bank_id = D.bank_name where C.added_date = '".date('Y-m-d')."' and (C.bank_id !='') and (C.bank_id !='select') ".$cm_idC."";
		$ptr_amnt1=mysql_query($sel_inv1);
		if($total_bank=mysql_num_rows($ptr_amnt1))
		{
			$k=1;
			while($data_ptr_sel1=mysql_fetch_array($ptr_amnt1))
			{
				$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel1['bank_name']."'";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
									
				$sel_inv="select SUM(amount) as total_amt,bank_name from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".date('Y-m-d')."' ".$branch_id."";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				//==================================================================================================================================================
				$sel_receipt="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode !='outword'  and added_date='".date('Y-m-d')."' ".$branch_id." ";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
				
				$sel_expense="select SUM(amount) as total_amt from expense where bank_id='".$data_ptr_sel1['bank_name']."' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_expense_bank_id=mysql_query($sel_expense);
				$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
				
				$sel_receipt_out="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode='outword'  and added_date='".date('Y-m-d')."' ".$branch_id." ";
				$ptr_bank_id_out=mysql_query($sel_receipt_out);
				$data_sel_recipt_out=mysql_fetch_array($ptr_bank_id_out);
				
				$outgoing=$data_sel_expense['total_amt'] + $data_sel_recipt_out['total_amt'];
				//==============================================================================================================================================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".date('Y-m-d')."' ".$branch_id."";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and cash_transfer_mode !='outword' and added_date='".date('Y-m-d')."' ".$branch_id." ";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				//==================================================================================================================================================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and added_date = '".$prv_date."'  ".$branch_id."" ;
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_yesterday=mysql_fetch_array($ptr_total_inc);
				$data_total_yest = $data_total_yesterday['total_amt'];
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and added_date = '".$prv_date."' ".$branch_id."";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_yesterday2=mysql_fetch_array($ptr_total_inc2);
				$data_total_yest2 = $data_total_yesterday2['total_amt'];
				
				$total_todays_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				
				$incomming=$data_sel_recipt['total_amt']+$data_ptr_sel['total_amt'];
				
				$yesterday_bal=$data_total_yest+$data_total_yest2;
				
				$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel1['bank_name']."' ".$branch_id."  order dsr_bank_id desc limit 0,1"; //and added_date = '".$prv_date."'
				$ptr_yest=mysql_query($sele_yesterday_bal);
				$data_yesterday=mysql_fetch_array($ptr_yest);
				
				$total_todays_bank= $total_todays_bal - $outgoing;
				if($total_todays_bank < 0)
				{
					$total_todays_bank= 0;
				}
			
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
			}
		}
		else
		{
			$message.= '<tr><td class="text" align="center" colspan="7"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Bank Amount added on today</div><br></td></tr>';
		}
	
	
$message.='  </table>
   </td>
  </tr>';
  
  
  
 
 
 
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
    
    
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Opening Cash</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Revenue</strong></td>
	
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Cash Received from Sir</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Expenses</strong></td>
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash Given to Director</strong></td>
    <td width="12%" align="center" style="border:1px solid #CCC"><strong>Cash Deposited in Bank</strong></td>
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash In Hand</strong></td>
   </tr>';
    // <td width="15%" align="center" style="border:1px solid #CCC"><strong>Cash Received from Innocent</strong></td>
				$sel_inv1="select DISTINCT(bank_name) from invoice where DATE(`added_date`) = '".date('Y-m-d')."' and bank_name !='' and bank_name !='select' ".$branch_id."";
				$ptr_amnt1=mysql_query($sel_inv1);
				$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
				
				//===================Todays Total receive balance===============================
				$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='1' and DATE(`added_date`) = '".date('Y-m-d')."' ".$branch_id."";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				
				$sel_receipt="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category !='cash_transfer'  and category !='innocent' and category !='santosh' and  added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
				
				$sel_voucher="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and category ='voucher' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_voucher=mysql_query($sel_voucher);
				$data_sel_voucher=mysql_fetch_array($ptr_voucher);
				
				//$todays_receive=$data_ptr_sel['total_amt']+$data_sel_recipt['total_amt'];
				//==============================================================================
				
				//===================Opening cash===============================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ".$branch_id."";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and  DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ".$branch_id."";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				
				 $total_yest_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				//==============================================================================
				//===================Total Cash Taken from Bank===============================
				/*$sel_expense_taken="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_expense_taken=mysql_query($sel_expense_taken);
				$data_expense_taken=mysql_fetch_array($ptr_expense_taken);*/
				//============================================================================
				
				//===================Cash received from sir===============================
				$sel_cash_received_sir="select SUM(amount) as total_amt from receipt where category ='santosh' and payment_mode_id='1' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_cash_received_sir=mysql_query($sel_cash_received_sir);
				$data_cash_received_sir=mysql_fetch_array($ptr_cash_received_sir);
				//============================================================================
				
				//===================Total Cash Expenses===============================
				$sel_total_expense="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and expense_type_id !='4' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_total_expense=mysql_query($sel_total_expense);
				$data_total_expense=mysql_fetch_array($ptr_total_expense);
				//============================================================================
				
				//===================Cash Given to sir===============================
				$sel_cash_from_sir="select SUM(amount) as total_amt from expense where expense_type_id='4' and payment_mode_id='1' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_cash_from_sir=mysql_query($sel_cash_from_sir);
				$data_cash_from_sir=mysql_fetch_array($ptr_cash_from_sir);
				
				//============================================================================

				//===================Cash Received from Inocent===============================
				$sel_cash_from_innocent="select SUM(amount) as total_amt from receipt where category ='innocent' and payment_mode_id='1' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_cash_from_innocent=mysql_query($sel_cash_from_innocent);
				$data_cash_from_innocent=mysql_fetch_array($ptr_cash_from_innocent);
				//============================================================================
				
				
				//===================Cash in Hand===============================
				$sel_cash_from_cash="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and payment_mode_id='1' and added_date='".date('Y-m-d')."' ".$branch_id."";
				$ptr_cash_from_cash=mysql_query($sel_cash_from_cash);
				$data_cash_from_cash=mysql_fetch_array($ptr_cash_from_cash);
				//============================================================================
				//=============================SERVICE===============================================
				$sel_service="select SUM(total_cost) as total_amt from customer_service where payment_mode_id='1' and DATE(added_date)='".date('Y-m-d')."' ".$branch_id."";
				$ptr_service=mysql_query($sel_service);
				$data_service=mysql_fetch_array($ptr_service);
				//============================================================================
				//=============================PRODUCT===============================================
				$sel_product="select SUM(total_cost) as total_amt from inventory where payment_mode_id='1' and DATE(added_date)='".date('Y-m-d')."' ".$branch_id."";
				$ptr_product=mysql_query($sel_product);
				$data_product=mysql_fetch_array($ptr_product);
				//============================================================================
				//$opening_cash=$total_yest_bal;
				
				$opening_cash1='';
				$sele_yest_bal="select cash_in_hand from dsr order by dsr_id desc limit 0,1"; //where added_date = '".$prv_date."' 
				$ptr_yest1=mysql_query($sele_yest_bal);
				if(mysql_num_rows($ptr_yest1))
				{
					$data_yest_bal=mysql_fetch_array($ptr_yest1);
					$opening_cash1=$data_yest_bal['cash_in_hand'];
				}
				
			 	$message.= '<tr>';
				$message.= '<td align="center" style="border:1px solid #CCC">'.$opening_cash1.'</td> ';
				$message.= '<td align="center" style="border:1px solid #CCC">Fees- '.$data_ptr_sel['total_amt'].'<br /><hr />Product- '.$data_product['total_amt'].'<br /><hr />Service- '.$data_service['total_amt'].'</td>';
				/*$message.= '<td align="center" style="border:1px solid #CCC">'.$data_expense_taken['total_amt'].'</td>';*/
				$message.= '<td align="center" style="border:1px solid #CCC">'.$data_cash_received_sir['total_amt'].'</td>';
				$message.= '<td align="center" style="border:1px solid #CCC">'.$data_total_expense['total_amt'].'</td>';
				$message.= '<td align="center" style="border:1px solid #CCC">'.$data_cash_from_sir['total_amt'].'</td>';
				$message.= '<td align="center" style="border:1px solid #CCC">';
				//======================================Cash Deposited in Bank=========================================
				$sel_dist_bank_id="Select DISTINCT(bank_id) from receipt where added_date='".date('Y-m-d')."' and bank_id !='' and category !='cash_transfer' ".$branch_id."";
				$ptr_dist_bank_id=mysql_query($sel_dist_bank_id);
				$total=mysql_num_rows($ptr_dist_bank_id);
				$i=1;
				$xx='';
				$tt='';
				while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
				{
					$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and category !='cash_transfer' and added_date='".date('Y-m-d')."' ".$branch_id."";
					$ptr_cash_from_bank=mysql_query($sel_cash_from_bank);
					$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
					
					$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					//$message.= $data_bank_name['bank_name']." : ".$data_cash_from_bank['total_amt'] ;
					
					$xx.= $data_bank_name['bank_name']." : ".$data_cash_from_bank['total_amt'];
					$tt +=$data_cash_from_bank['total_amt'];
					if($i !=$total)
					{
						$xx.= '<br /><hr >';
					}
					$i++;
				}
				$message.='<hr style="color: #1395D2">';
				$message.= "<strong>Total : ".$tt.'</strong>';
				//===========================================================================================
				//===================Cash in Hand===============================
				$sel_total_inc1="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".date('Y-m-d')."' and (bank_name='' or bank_name= 'select') ".$branch_id."";
				$ptr_total_inc1=mysql_query($sel_total_inc1);
				$data_total_inc1=mysql_fetch_array($ptr_total_inc1);
				
				$sel_total_inc21="select SUM(amount) as total_amt from receipt where category !='cash_transfer' and added_date='".date('Y-m-d')."' and bank_id='' ".$branch_id."";
				$ptr_total_inc21=mysql_query($sel_total_inc21);
				$data_total_inc21=mysql_fetch_array($ptr_total_inc21);
				
				 $cash_in_hand=$data_total_inc1['total_amt']+$data_total_inc21['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				 
				 $total_cash_fees=$data_ptr_sel['total_amt'] ;
				 $total_cash_product= $data_sel_recipt['total_amt'];
				
				
					
				$cash_in_hands=$opening_cash1 + $data_ptr_sel['total_amt'] +$data_sel_recipt['total_amt'] + /*$data_expense_taken['total_amt'] +*/ $data_cash_received_sir['total_amt'] - $data_total_expense['total_amt'] -  $data_cash_from_sir['total_amt'] - $tt +$data_sel_voucher['total_amt'];//+ $data_cash_from_innocent['total_amt']
				//==============================================================================
				$message.= $xx.'</td>';
				//$message.= '<td align="center" style="border:1px solid #CCC">'.$data_cash_from_innocent['total_amt'].'</td>';
				
				$message.= '<td align="center" style="border:1px solid #CCC">'.$cash_in_hands.'</td>' ;
				$message.= '</tr>';
	
$message.='  </table>
   </td>
  </tr>'; 
$message.='   <tr>
  	<td colspan="12" style="color:#F00">Note -:<br/>
    <strong>Total Cash Revenue (Product)</strong> -: It calculated Excluding <strong>Inoncent</strong> and <strong>Director</strong> taken from Receipt<br />
    <strong>Total Cash Expense -:</strong> It calculate Excluding "<strong>Cash Given to Director</strong>" taken from Expense <br />
    </td>
  </tr>';
/* $message.='<tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="50%" align="center" style="border:1px solid #CCC"><a href="'.$_SERVER['PHP_SELF'].'?order='.$order.'."&orderby=category".'.$query_string.'" class="table_font"><strong>Payment Mode</strong></a> '.$img1.'</td>
     <td width="35%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
   </tr>';
    
	$sele_pay_mode1="select payment_mode_id as total_amt from expense where added_Date=".date('Y-m-d')."";
	$ptr_pay_mode1=mysql_query($sele_pay_mode1);
	$i=1;
	if(mysql_num_rows($ptr_pay_mode1))
	{
		while($data_pay_mode1=mysql_fetch_array($ptr_pay_mode1))
		{
			$sele_pay_name="select payment_mode from payment_mode where payment_mode_id=".$data_pay_mode1['payment_mode_id']."";
			$ptr_pay_name=mysql_query($sele_pay_name);
			$data_pay_name=mysql_fetch_array($ptr_pay_name);
			
			$sel_inv1="select SUM(amount) as total_amt from expense where payment_mode_id='".$data_pay_mode1['payment_mode_id']."'";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
			if($data_ptr_sel1['total_amt'] !=0)
			{
			$message.= '<tr>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_pay_mode1['payment_mode'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['total_amt'].'</td>';
			}
			
		$i++;
		}
	}
	else
	{
		$message.= '<tr><td class="text" align="center" colspan="3"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Amount added by any Payment mode on today</div><br></td></tr>';
	}

  $message.='</table>
   </td>
  </tr>';*/
 
  
  
 //$message.='<tr>';
 /*  $select_amnt1="select SUM(amount) as total from expense where and added_Date=".date('Y-m-d')." order by expense_id desc";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
	else
	{
		$total_amount1=0;
	}
  $message.='
 <td align="left" colspan="10" style="color:#F00"><strong>Todays Outgoing</strong> : '.$total_amount1.'</td>
  </tr>';*/
  
	  
  
  $message.='</table>';

						
							/*------------send a mail to admin about this---------------------*/
							$subject = " Todays Expense Report of ".$GLOBALS['domainName']." ".$branch_name."";
								
							
							
					
							$sendMessage=$GLOBALS['box_message_top'];
							$sendMessage.=$message;
							$sendMessage.=$GLOBALS['box_message_bottom'];
							$from_id='support<support@'.$GLOBALS['siteUrlName'].'>';
							$headers= 'MIME-Version: 1.0' . "\n";
							$headers.='Content-type: text/html; charset=utf-8' . "\n";
							$headers.='From:'.$from_id;
							
							
								
						$select_email_id = " select email_id from sms_mail_configuration where email_id !='' and status='active'";
						$ptr_emails = mysql_query($select_email_id);
						while($data_emails = mysql_fetch_array($ptr_emails))
						{
							//echo "<br />".$data_emails['email'];
							mail($data_emails['email_id'], $subject, $sendMessage, $headers);
						
						}
						
						
						$insert_dsr="insert into dsr(`total_incoming`, `total_outgoing`, `yesterday_bal`, `total_cash_fees`, `total_cash_product`, `total_cash_taken_from_bank`, `cash_received_from_director`, `total_cash_expense`, `cash_given_to_director`,`cash_received_from_innocent`,`cash_in_hand`,`added_date`,`cm_id`) values ('".$total_todays_bal."','".$total_amount1."','".$opening_cash1."','".$data_ptr_sel['total_amt']."','".$data_sel_recipt['total_amt']."','".$data_expense_taken['total_amt']."','".$data_cash_received_sir['total_amt']."','".$data_total_expense['total_amt']."','".$data_cash_from_sir['total_amt']."','".$data_cash_from_innocent['total_amt']."','".$cash_in_hands."','".date('Y-m-d')."','".$cm_id1."')";
	  $ptr_insert=mysql_query($insert_dsr);
	  
	  $sel_inv1="select DISTINCT(bank_name) from invoice where DATE(`added_date`) = '".date('Y-m-d')."' and (bank_name !='') and (bank_name !='select')";
		$ptr_amnt1=mysql_query($sel_inv1);
		if($total_bank=mysql_num_rows($ptr_amnt1))
		{
			$k=1;
			while($data_ptr_sel1=mysql_fetch_array($ptr_amnt1))
			{
				$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel1['bank_name']."'";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
									
				$sel_inv="select SUM(amount) as total_amt,bank_name from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".date('Y-m-d')."'";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				//==================================================================================================================================================
				$sel_receipt="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel['bank_name']."' and category !='cash_transfer' and added_date='".date('Y-m-d')."'";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
				
				$sel_expense="select SUM(amount) as total_amt from expense where bank_id='".$data_ptr_sel['bank_name']."' and added_date='".date('Y-m-d')."'";
				$ptr_expense_bank_id=mysql_query($sel_expense);
				$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
				//==============================================================================================================================================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".date('Y-m-d')."'";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and category !='cash_transfer' and added_date='".date('Y-m-d')."'";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_yesterday=mysql_fetch_array($ptr_total_inc);
				$data_total_yest = $data_total_yesterday['total_amt'];
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and category !='cash_transfer' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_yesterday2=mysql_fetch_array($ptr_total_inc2);
				$data_total_yest2 = $data_total_yesterday2['total_amt'];
				
				$total_todays_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				
				$incomming=$data_sel_recipt['total_amt']+$data_ptr_sel['total_amt'];
				
				$yesterday_bal=$data_total_yest+$data_total_yest2;
				
				$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel1['bank_name']."' order dsr_bank_id desc limit 0,1 "; //and added_date = '".$prv_date."'
				$ptr_yest=mysql_query($sele_yesterday_bal);
				$data_yesterday=mysql_fetch_array($ptr_yest);
			
			
			
		 	 $insert_into_dsr_bank=" insert into dsr_bank_summery (`bank_id`,`account_no`,`incoming`,`outgoing`,`yesterdas_balance`,`todays_balance`,`added_date`,`cm_id`) values('".$data_ptr_sel1['bank_name']."','".$data_bank_name['account_no']."','".$total_todays_bal."','".$data_sel_expense['total_amt']."','".$data_yesterday['todays_balance']."','".$incomming."','".date('Y-m-d')."','".$cm_id1."')";
		  
		  $ptr_banks=mysql_query($insert_into_dsr_bank);
			
			$k++;
			}
		}
		
						echo "Mail sent";
							
						/*-------------------------------------------------------------------------*/
							
?><script>
								setTimeout('document.location.href="dsr_report.php";',2000);
								</script>
                                <?php
?>

</body>
</html>
