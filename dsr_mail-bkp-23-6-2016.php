<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Total Enrollment</title>
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

$message .= '
<table cellpadding="3" align="left" cellspacing="3" width="100%">
 ';

$message.=  '<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
<tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incomming</strong></td>
  </tr>
  <tr>';
  
  $select_amnt1="select SUM(amount) as total from receipt order by receipt_id desc limit 0,1";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
 
 $message.=' <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> :'.$total_amount1.'</td>
  </tr>';
  
  
  $message.='<tr>
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
  </tr>';
  
  
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            $pre_keyword=" and (name like '%".$keyword."%' )";
                        else
                            $pre_keyword="";

                        if($_REQUEST['page'])
                            $page=$_REQUEST['page'];
                        else
                            $page=0;
                        
                        if($_REQUEST['show_records'])
                            $show=$_REQUEST['show'];
                        else
                            $show=0;

                        if($_GET['order']=='asc')
                        {
                            $order='desc';
                            $img = "<img src='images/sort_up.png' border='0'>";
                        }
                        else if($_GET['order']=='desc')
                        {
                            $order='asc';
                            $img = "<img src='images/sort_down.png' border='0'>";
                        }
                        else
                            $order='desc';

                        if($_GET['orderby']=='amount' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='enroll_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by enroll_id asc';                      
                            $sql_query= "SELECT * FROM enrollment where added_date='".date('Y-m-d')."' ".$_SESSION['where']." ".$pre_keyword." ".$select_directory.""; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
						    
						 $message.=' <tr class="grey_td" style="background-color:#999">
							
							<td width="5%" align="center"><strong>Sr. No.</strong></td>
							<td width="20%"><a href="'. $_SERVER['PHP_SELF'].'?order='.$order.'."&orderby=category".'.$query_string.'" class="table_font"><strong>Student Name</strong></a>'.$img1.'</td>
							<td width="10%"><strong>Payment Mode</strong></td>
							<td width="10%"><strong>Account No</strong></td>
							<td width="10%"><strong>Chaque No</strong></td>
							<td width="10%"><strong>chaque Date</strong></td>
							<td width="10%"><strong>Amount</strong></td>
							<td width="10%"><strong>Added date</strong></td>
							<!--<td width="10%" class="centerAlign"><strong>Action</strong></td>-->
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
								
								$sql_invoice="select invoice_id,chaque_date,paid_type,bank_name,cheque_detail,amount from invoice where enroll_id='".$val_query['enroll_id']."'";
								$my_query_invoice=mysql_query($sql_invoice);
								$row_invoice= mysql_fetch_array($my_query_invoice);
								
                                $sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$row_invoice['paid_type']."'";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_bank="select bank_name,account_no from bank where bank_id='".$row_invoice['bank_name']."'";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
								
								
                                $message.= '<tr '.$bgcolor.' >
                                      ';
                                $message.= '<td align="center">'.$sr_no.'</td>';       
                                $message.= '<td >'.$val_query['name'].'</td>';
                                $message.= '<td >'.$data_payment_mode['payment_mode'].'</td>';
								$message.= '<td >'.$data_bank_name['account_no'].'</td>';
								$message.= '<td >'.$row_invoice['cheque_detail'].'</td>';
								$message.= '<td >'.$row_invoice['chaque_date'].'</td>';
								$message.= '<td >'.$row_invoice['amount'].'</td>';
							
								$message.= '<td >'.$val_query['added_date'].'</td>';
                                /*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';*/
                                $message.= '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
							
							
						}
						else
						{
         					$message.= '<tr><td class="text" align="center" colspan="8" ><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Student record added on today</div><br></td></tr>';
						}
           $message.=' <tr>
 <td align="center" colspan="10"><strong>Cash Deposite</strong></td>
 </tr>
 <tr class="grey_td" >
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%">
 <tr style="background-color:#999">
    
    <td width="15%" align="center"><strong>Sr. No.</strong></td>
    <td width="50%" align="center"><a href="'.$_SERVER['PHP_SELF'].'?order=<?php echo $order."&orderby=category".'.$query_string.'" class="table_font"><strong>Bank Name</strong></a> '.$img1.'</td>
    <td width="35%" align="center"><strong>Amount</strong></td>
   </tr>';
    
	$sel_inv1="select bank_name from invoice where DATE(`added_date`) = ".date('Y-m-d')."";
	$ptr_amnt1=mysql_query($sel_inv1);
	if( mysql_num_rows($ptr_amnt1))
	{
		$b=1;
		while($data_ptr_sel1=mysql_fetch_array($ptr_amnt1))
		{
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$data_ptr_sel1['bank_name']."'";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
								
			$sel_inv="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."'";
			$ptr_amnt=mysql_query($sel_inv);
			$total=mysql_num_rows($ptr_amnt);
			$data_ptr_sel=mysql_fetch_array($ptr_amnt);
			
			$message.= '<tr>
			<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
			$message.= '<td align="center">'.$b.'</td>';       
			$message.= '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" class="table_font">'.$data_bank_name['bank_name'].'</a></td>';
			$message.= '<td align="center">'.$data_ptr_sel['total_amt'].'</td>';
			$b++;
		}
	}
	else
	{
		$message.= '<tr><td class="text" align="center" colspan="3"><br><div class="msgbox" style="width:50%;background-color:green;color:white">No Bank Amount added on today</div><br></td></tr>';
	}
	
	
$message.='  </table>
   </td>
  </tr>
  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Outgoing</strong></td>
  </tr>
  <tr>';
  
  $select_amnt1="select SUM(amount) as total from expense order by expense_id desc limit 0,1";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
 
$message.='  <td align="left" colspan="10" style="color:#F00"><strong>Total Outgoing</strong> :'.$total_amount1.'</td>
  </tr>
  
  
 <tr>
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

  $message.='. </table>
   </td>
  </tr>
  <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="50%" align="center" style="border:1px solid #CCC"><a href="'.$_SERVER['PHP_SELF'].'?order='.$order.'."&orderby=category".'.$query_string.'" class="table_font"><strong>Expense Type</strong></a> '.$img1.'</td>
     <td width="35%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
   </tr>';
    
	$sele_exp="select expense_type_id from expense where  added_Date=".date('Y-m-d')."";
	$ptr_exp=mysql_query($sele_exp);
	if(mysql_num_rows($ptr_exp))
	{
		$i=1;
		while($data_exp=mysql_fetch_array($ptr_exp))
		{
			$exp_name="select expense_type from expense_type where expense_type_id=".$data_exp['expense_type_id']."";
			$ptr_expense=mysql_query($exp_name);
			$data_expense=mysql_fetch_array($ptr_expense);
			
			$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."' ";
			$ptr_amnt1=mysql_query($sel_inv1);
			$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
			
			$message.= '<tr>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_expense['expense_type'].'</td>';
			$message.= '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['total_amt'].'</td>';
		$i++;
		}
	}
	else
	{
		$message.= '<tr><td class="text" align="center" colspan="3"><br><div class="msgbox" style="width:50%; background-color:green;color:white">No Amount added by any Expense mode on today</div><br></td></tr>';
	}

 $message.='. 
   </table>
   </td>
  </tr>
  
  
   <tr>
 ';
  $select_amnt1="select SUM(amount) as total from expense where and added_Date=".date('Y-m-d')." order by expense_id desc";
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
  </tr>
  
  </table>>';

						
							/*------------send a mail to admin about this---------------------*/
							$subject = " Todays Expense Report of ".$GLOBALS['domainName']."";
								
							$message.='</table>';
							
					
							$sendMessage=$GLOBALS['box_message_top'];
							$sendMessage.=$message;
							$sendMessage.=$GLOBALS['box_message_bottom'];
							$from_id='support<support@'.$GLOBALS['siteUrlName'].'>';
							$headers= 'MIME-Version: 1.0' . "\n";
							$headers.='Content-type: text/html; charset=utf-8' . "\n";
							$headers.='From:'.$from_id;
							
							
								
						$select_email_id = " select email from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name1."') and email !='' ";
						$ptr_emails = mysql_query($select_email_id);
						while($data_emails = mysql_fetch_array($ptr_emails))
						{
							mail($data_emails['email'], $subject, $sendMessage, $headers);
						
						}
						echo "Mail sent";
							
						/*-------------------------------------------------------------------------*/
							

?>
</body>
</html>
