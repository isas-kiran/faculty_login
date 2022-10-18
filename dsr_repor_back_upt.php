<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DSR Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
     <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
        });
		</script>
        
    <script type="text/javascript">
         function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
            var hasChecked = false;
            for (var i = 0; i < chks.length; i++)
            {
                if (chks[i].checked)
                {
                    hasChecked = true;
                    break;
                }
            }
            if (hasChecked == false)
            {
                alert("Please select at least one record to do operation");
                $('#selAction').val('');
                return false;
            }

            document.getElementById('formAction').value=action;
            if(action=="delete")
            {
                if(confirm("Are you sure, you want to delete selected record(s)?"))
                    document.frmTakeAction.submit();
                else
                {
                    $('#selAction').val('');
                    return false;
                }
            }
            else
                document.frmTakeAction.submit();
        }
        function redirect1(value,value1)
        {           
            //alert(value);
           // alert(value1);
            window.location.href=value+value1;
        }

        function validationToDelete(type)
        {
            if(confirm("Are you sure, you want to delete selected record(s)?"))
                return true;
            else
                return false;
        }
    </script>
</head>

<body>
<?php include "include/header.php"; ?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->

<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
   
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="13">
    <table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
        
	
              <tr>
              <form method="get" name="search">
                <td class="width5"></td>
                                
                        <!-- <td width="10%">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                         
                         <td width="10%">
                         <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                         </td>
                         <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                		<td class="rightAlign" > 
                    		<table border="0" cellspacing="0" cellpadding="0" align="right">
              					<tr>
              						<td></td>
              						<td class="width5"></td>
                					<td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                					<td class="width2"></td>
                					<td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              					</tr>
                    		</table>	
               			</td>-->
                         </form>	
                          <!--<form method="get" name="search">
         
                		<td class="width5"></td>
                         <td width="10%">
                         <input type="hidden" name="send_mail"  value="mail">
                         </td>
                         <td width="10%"><a href="dsr_mail.php"><input type="button" name="send_mail" value="Send Mail" class="inputButton"/></a></td>
         				</form>-->
           		 </tr>
        
       
        	
        </table>
       
		<!--<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              
        </table>-->
        
    </td>
  </tr>
  <?php
  if(isset($_POST['sending_mail']))
  {
	  $insert_dsr="insert into dsr(`total_incoming`, `total_outgoing`, `yesterday_bal`, `total_cash_fees`, `total_cash_product`, `total_cash_taken_from_bank`, `cash_received_from_director`, `total_cash_expense`, `cash_given_to_director`,`cash_received_from_innocent`,`cash_in_hand`,`added_date`) values ('".$_POST['total_incoming']."','".$_POST['total_outgoing']."','".$_POST['opening_cash']."','".$_POST['total_cash_fees']."','".$_POST['total_cash_product']."','".$_POST['total_cash_taken_from_bank']."','".$_POST['cash_received_from_director']."','".$_POST['total_cash_expense']."','".$_POST['cash_given_to_director']."','".$_POST['cash_received_from_innocent']."','".$_POST['cash_in_hand']."','".date('Y-m-d')."')";
	  $ptr_insert=mysql_query($insert_dsr);
	  
	  
	  for($i=1;$i<=$_POST['total_banks']; $i++)
	  {
		  echo $insert_into_dsr_bank=" insert into dsr_bank_summery (`bank_id`,`account_no`,`incoming`,`	outgoing`,`yesterdas_balance`,`todays_balance`,`added_date`) values('".$_POST['bank_id_'.$i.'']."','".$_POST['account_no'.$i.'']."','".$_POST['incoming'.$i.'']."','".$_POST['outgoing'.$i.'']."','".$_POST['yesterday_bal'.$i.'']."','".$_POST['today_bal'.$i.'']."','".date('Y-m-d')."')";
		  
		  $ptr_banks=mysql_query($insert_into_dsr_bank);
	  }
	  
	  
	  ?><script>
	setTimeout('document.location.href="dsr_mail.php?send_mail=mail";');
	</script>
	<?php
  }
  
  
  ?>
  <form method="post" name="search">
  <tr  bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incoming</strong></td>
  </tr>
  <tr>
  <?php 
//===================Total receive balance===============================
	$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".date('Y-m-d')."'";
	$ptr_total_inc=mysql_query($sel_total_inc);
	$data_total_inc=mysql_fetch_array($ptr_total_inc);
	
	"<br>".$sel_total_inc2="select SUM(amount) as total_amt from receipt where added_date='".date('Y-m-d')."'";
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
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_todays_bal; ?></td>
  <input type="hidden" name="total_incoming" value="<?php echo $total_todays_bal; ?>"  />
  </tr>
  
  
<!-- <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    
    <td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="20%" align="center" style="border:1px solid #CCC"><a href="<?php //echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Payment Mode</strong></a> <?php echo $img1;?></td>
     <td width="10%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
   </tr>
    <?php
	
		/*$sel_inv="select paid_type from invoice where  DATE(`added_date`) = ".date('Y-m-d')." ";
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
		
				echo '<tr>';
				echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
				echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_mode['payment_mode'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel['total_amt'].'</td>';
				$i++;
			}
		}
		else
		{
			echo '<tr><td class="text" align="center" colspan="3"><br><div class="msgbox" style="width:50%;">No Amount added by any Payment modes on today</div><br></td></tr>';
		}*/
  
 ?> 
   </table>
   </td>
  </tr>-->
     <?php
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
						  	$pre_from_date=" and added_date >='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
						 }
						else
						{
							$pre_from_date=""; 
							$enquiry_date="";
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							 $_REQUEST['to_date'];
							 $pre_to_date=" and added_date<='".date('Y-m-d',strtotime($_REQUEST['to_date']))."'";
							
							
						}
						else
						{
							$pre_to_date="";
							$enquiery_to_date="";
							$installment_to_date="";
						}
						
						?>
                        
                        
     <?php
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
                           $sql_query= "SELECT * FROM enrollment where added_date='".date('Y-m-d')."' ".$_SESSION['where']." ".$pre_keyword." ".$select_directory." "; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
						?>
                      <!--  <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                                     <input type="hidden" name="formAction" id="formAction" value=""/>-->
                       
                      <tr class="grey_td" style="background-color:#999">
                        
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
                         <td width="10%" align="center"><strong>Sale Type</strong></td>
                        <td width="20%" align="center"><strong>Student Name</strong></td>
                        <td width="10%" align="center"><strong>Payment Mode</strong></td>
                         <td width="10%" align="center"><strong>Bank</strong></td>
                        <td width="10%" align="center"><strong>Account No</strong></td>
                        <td width="10%" align="center"><strong>Chaque No</strong></td>
                       <!-- <td width="10%" align="center"><strong>chaque Date</strong></td>-->
                        <td width="10%" align="center"><strong>Amount</strong></td>
                        
                        <!--<td width="10%" class="centerAlign"><strong>Action</strong></td>-->
                      </tr>
                                                <?php
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
								
								
								
                                echo '<tr '.$bgcolor.' >
                                      ';
                                echo '<td align="center">'.$sr_no.'</td>';   
								echo '<td align="center">Course</td>';    
                                echo '<td align="center">'.$val_query['name'].'</td>';
                                echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
								echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
								echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
								echo '<td align="center">'.$row_invoice['cheque_detail'].'</td>';
								/*echo '<td align="center">'.$row_invoice['chaque_date'].'</td>';*/
								echo '<td align="center">'.$row_invoice['amount'].'</td>';
							
                                /*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';*/
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="13">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                      if($no_of_records>10)
                            {
                                echo '<td width="3%" align="left">Show</td>
                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                $show_records=array(0=>'10',1=>'20','50','100');
                                for($s=0;$s<count($show_records);$s++)
                                {
                                    if($_SESSION['show_records']==$show_records[$s])
                                        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                    else
                                        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                }
                                echo'</td></select>';
                            }
                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';                         
                 ?>                                    
            </tr>
        </table>            
    </td>
    </tr>
      <?php } 
      else
        echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Student record added on today</div><br></td></tr>';?>
        <!--</form>-->
        
  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Outgoing</strong></td>
  </tr>
  <tr>
  <?php 
  $select_amnt1="select SUM(amount) as total from expense where added_Date='".date('Y-m-d')."' ";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Total Outgoing</strong> : <?php echo $total_amount1; ?></td>
  <input type="hidden" name="total_outgoing" value="<?php echo $total_amount1; ?>"  />
  </tr>
  
  <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    <td width="4%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="12%" align="center" style="border:1px solid #CCC"><strong>Expense Type</strong></td>
    <td width="16%" align="center" style="border:1px solid #CCC"><strong>Employee</strong></td>
    <td width="11%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    <td width="13%" align="center" style="border:1px solid #CCC"><strong>Vendor</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
    <td width="13%" align="center" style="border:1px solid #CCC"><strong>Account No.</strong></td>
    <td width="16%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
 </tr>
    <?php
	$sele_exp="select expense_id,expense_type_id,employee_id,vendor_id,payment_mode_id,bank_id from expense where  added_Date='".date('Y-m-d')."'";
	$ptr_exp=mysql_query($sele_exp);
	$i=1;
	if(mysql_num_rows($ptr_exp))
	{
		while($data_exp=mysql_fetch_array($ptr_exp))
		{
			$exp_name="select expense_type from expense_type where expense_type_id='".$data_exp['expense_type_id']."'";
			$ptr_expense=mysql_query($exp_name);
			$data_expense=mysql_fetch_array($ptr_expense);
			
			$sel_inv1="select SUM(amount) as total_amt from expense where expense_type_id='".$data_exp['expense_type_id']."' and added_Date='".date('Y-m-d')."' and expense_id= '".$data_exp['expense_id']."'";
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
			
				echo '<tr>';
				echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
				echo '<td align="center" style="border:1px solid #CCC">'.$data_expense['expense_type'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_emp['name'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_vendor['name'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['total_amt'].'</td>';
			$i++;
		}
	}
	else
	{
		echo '<tr><td class="text" align="center" colspan="7"><br><div class="msgbox" style="width:50%; ">No Amount added by any Expense mode on today</div><br></td></tr>';
	}
 ?> 
   </table>
   </td>
  </tr>
  
  <tr>
  	<td align="center" colspan="10"><strong></strong></td>
  </tr>
   <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Bank Summery</strong></td>
  </tr>
  <tr >
  <td align="center" colspan="10"><strong></strong></td>
  </tr>
  <tr class="grey_td" >
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
   
   <td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="20%" align="center" style="border:1px solid #CCC"><strong>Bank Name</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Account No</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Total Incoming</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Outgoing</strong></td>
	<td width="15%" align="center" style="border:1px solid #CCC"><strong>Yesterday`s Balance</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Todays`s Balance</strong></td>
   </tr>
    <?php
	
		//echo $sel_inv1="select DISTINCT(bank_name) from invoice where DATE(`added_date`) = '".date('Y-m-d')."' and (bank_name !='') and (bank_name !='select')";
		
		$sel_inv1="Select A.bank_name
From invoice A Left Outer Join
     receipt B on A.bank_name = B.bank_id where  DATE(A.added_date) = '".date('Y-m-d')."' and (A.bank_name !='') and (A.bank_name !='select')
Union
Select c.bank_id
From receipt C left join
     invoice D on C.bank_id = D.bank_name where c.added_date = '".date('Y-m-d')."' and (c.bank_id !='') and (c.bank_id !='select')";
		
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
				//===================================================================================================================================
				$sel_receipt="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel['bank_name']."' and added_date='".date('Y-m-d')."'";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
				
				$sel_expense="select SUM(amount) as total_amt from expense where bank_id='".$data_ptr_sel['bank_name']."' and added_date='".date('Y-m-d')."'";
				$ptr_expense_bank_id=mysql_query($sel_expense);
				$data_sel_expense=mysql_fetch_array($ptr_expense_bank_id);
				//========================================================================================================================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(`added_date`) = '".date('Y-m-d')."' ";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and added_date='".date('Y-m-d')."'";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				//========================================================================================================================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where bank_name='".$data_ptr_sel1['bank_name']."' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_yesterday=mysql_fetch_array($ptr_total_inc);
				$data_total_yest = $data_total_yesterday['total_amt'];
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where bank_id='".$data_ptr_sel1['bank_name']."' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_yesterday2=mysql_fetch_array($ptr_total_inc2);
				$data_total_yest2 = $data_total_yesterday2['total_amt'];
				
				$total_todays_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				
				$incomming=$data_sel_recipt['total_amt']+$data_ptr_sel['total_amt'];
				
				$yesterday_bal=$data_total_yest+$data_total_yest2;
				
				$sele_yesterday_bal="select todays_balance from dsr_bank_summery where bank_id='".$data_ptr_sel1['bank_name']."' and DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
				$ptr_yest=mysql_query($sele_yesterday_bal);
				$data_yesterday=mysql_fetch_array($ptr_yest);
				echo '<tr>';
				echo '<td align="center" style="border:1px solid #CCC">'.$k.'</td> <input type="hidden" name="total_banks" value="'.$total_bank.'"  />';       
				echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td> <input type="hidden" name="bank_id_'.$k.'" value="'.$data_bank_name['bank_name'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td> <input type="hidden" name="account_no_'.$k.'" value="'.$data_bank_name['account_no'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$total_todays_bal.'</td> <input type="hidden" name="incoming_'.$k.'" value="'.$total_todays_bal.'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_sel_expense['total_amt'].'</td> <input type="hidden" name="outgoing_'.$k.'" value="'.$data_sel_expense['total_amt'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_yesterday['todays_balance'].'</td> <input type="hidden" name="yesterday_bal_'.$k.'" value="'.$data_sel_expense['todays_balance'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$incomming.'</td> <input type="hidden" name="todays_bal_'.$k.'" value="'.$incomming.'"  />';
				
				$k++;
			}
		}
		else
		{
			echo '<tr><td class="text" align="center" colspan="7"><br><div class="msgbox" style="width:50%;">No Bank Amount added on today</div><br></td></tr>';
		}
 ?> 
   </table>
   </td>
  </tr>
 
  



<tr>
  	<td align="center" colspan="10"><strong></strong></td>
  </tr>
   <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Cash Summery</strong></td>
  </tr>
  <tr >
  <td align="center" colspan="10"><strong></strong></td>
  </tr>
  <tr class="grey_td" >
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
   
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Opening Cash</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Revenue</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Taken from Bank</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Cash Received from Sir</strong></td>
	<td width="10%" align="center" style="border:1px solid #CCC"><strong>Total Cash Expenses</strong></td>
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash Given to Director</strong></td>
    <td width="12%" align="center" style="border:1px solid #CCC"><strong>Cash Deposited in Bank</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Cash Received from Innocent</strong></td>
    <td width="8%" align="center" style="border:1px solid #CCC"><strong>Cash In Hand</strong></td>
   </tr>
    <?php
	
				$sel_inv1="select DISTINCT(bank_name) from invoice where DATE(`added_date`) = '".date('Y-m-d')."' and bank_name !='' and bank_name !='select'";
				$ptr_amnt1=mysql_query($sel_inv1);
				$data_ptr_sel1=mysql_fetch_array($ptr_amnt1);
				
				//===================Todays Total receive balance===============================
				$sel_inv="select SUM(amount) as total_amt from invoice where paid_type='1' and DATE(`added_date`) = '".date('Y-m-d')."'";
				$ptr_amnt=mysql_query($sel_inv);
				$total=mysql_num_rows($ptr_amnt);
				$data_ptr_sel=mysql_fetch_array($ptr_amnt);
				
				$sel_receipt="select SUM(amount) as total_amt from receipt where payment_mode_id='1' and  added_date='".date('Y-m-d')."'";
				$ptr_bank_id=mysql_query($sel_receipt);
				$data_sel_recipt=mysql_fetch_array($ptr_bank_id);
				
				$todays_receive=$data_ptr_sel['total_amt']+$data_sel_recipt['total_amt'];
				//==============================================================================
				
				//===================Opening cash===============================
				$sel_total_inc="select SUM(amount) as total_amt from invoice where DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
				$ptr_total_inc=mysql_query($sel_total_inc);
				$data_total_inc=mysql_fetch_array($ptr_total_inc);
				
				$sel_total_inc2="select SUM(amount) as total_amt from receipt where DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
				$ptr_total_inc2=mysql_query($sel_total_inc2);
				$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
				
				 $total_yest_bal=$data_total_inc['total_amt']+$data_total_inc2['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				//==============================================================================
				
				//===================Total Cash Taken from Bank===============================
				$sel_expense_taken="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and added_date='".date('Y-m-d')."'";
				$ptr_expense_taken=mysql_query($sel_expense_taken);
				$data_expense_taken=mysql_fetch_array($ptr_expense_taken);
				//============================================================================
				
				//===================Cash received from sir===============================
				$sel_cash_received_sir="select SUM(amount) as total_amt from receipt where category ='santosh' and added_date='".date('Y-m-d')."'";
				$ptr_cash_received_sir=mysql_query($sel_cash_received_sir);
				$data_cash_received_sir=mysql_fetch_array($ptr_cash_received_sir);
				//============================================================================
				
				//===================Total Cash Expenses===============================
				$sel_total_expense="select SUM(amount) as total_amt from expense where payment_mode_id ='1' and expense_type_id !='4' and added_date='".date('Y-m-d')."'";
				$ptr_total_expense=mysql_query($sel_total_expense);
				$data_total_expense=mysql_fetch_array($ptr_total_expense);
				//============================================================================
				
				//===================Cash Given to sir===============================
				$sel_cash_from_sir="select SUM(amount) as total_amt from expense where expense_type_id='4' and added_date='".date('Y-m-d')."'";
				$ptr_cash_from_sir=mysql_query($sel_cash_from_sir);
				$data_cash_from_sir=mysql_fetch_array($ptr_cash_from_sir);
				
				//============================================================================

				//===================Cash Received from Inocent===============================
				$sel_cash_from_innocent="select SUM(amount) as total_amt from receipt where category ='innocent' and added_date='".date('Y-m-d')."'";
				$ptr_cash_from_innocent=mysql_query($sel_cash_from_innocent);
				$data_cash_from_innocent=mysql_fetch_array($ptr_cash_from_innocent);
				//============================================================================
				
				//===================Cash in Hand===============================
				$sel_cash_from_cash="select SUM(amount) as total_amt from receipt where added_date='".date('Y-m-d')."'";
				$ptr_cash_from_cash=mysql_query($sel_cash_from_cash);
				$data_cash_from_cash=mysql_fetch_array($ptr_cash_from_cash);
				//============================================================================
				
				$opening_cash=$total_yest_bal;
				
				$sele_yest_bal="select cash_in_hand from dsr where DATE(added_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) order by dsr_id desc limit 0,1";
				$ptr_yest1=mysql_query($sele_yest_bal);
				$data_yest_bal=mysql_fetch_array($ptr_yest1);
				$opening_cash1=$data_yest_bal['cash_in_hand'];
				
				echo '<tr>';
				echo '<td align="center" style="border:1px solid #CCC">'.$opening_cash1.'</td> <input type="hidden" name="opening_cash" value="'.$opening_cash1.'"  />';
				echo '<td align="center" style="border:1px solid #CCC">Fees- '.$data_ptr_sel['total_amt'].'<br /><hr >Product- '.$data_sel_recipt['total_amt'].'</td> ';
				
				echo '<input type="hidden" name="total_cash_fees" value="'.$data_ptr_sel['total_amt'].'"  />
				<input type="hidden" name="total_cash_product" value="'.$data_sel_recipt['total_amt'].'"  />';
				
				echo '<td align="center" style="border:1px solid #CCC">'.$data_expense_taken['total_amt'].'</td> <input type="hidden" name="total_cash_taken_from_bank" value="'.$data_expense_taken['total_amt'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_cash_received_sir['total_amt'].'</td> <input type="hidden" name="cash_received_from_director" value="'.$data_cash_received_sir['total_amt'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_total_expense['total_amt'].'</td><input type="hidden" name="total_cash_expense" value="'.$data_total_expense['total_amt'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_cash_from_sir['total_amt'].'</td> <input type="hidden" name="cash_given_to_director" value="'.$data_cash_from_sir['total_amt'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">';
				//===================Cash Deposited in Bank===============================
				$sel_dist_bank_id="Select DISTINCT(bank_id) from receipt where added_date='".date('Y-m-d')."' and bank_id !='' ";
				$ptr_dist_bank_id=mysql_query($sel_dist_bank_id);
				$total=mysql_num_rows($ptr_dist_bank_id);
				$i=1;
				$tt='';
				while($data_dist_bank_id=mysql_fetch_array($ptr_dist_bank_id))
				{
					$sel_cash_from_bank="select SUM(amount) as total_amt from receipt where bank_id ='".$data_dist_bank_id['bank_id']."' and added_date='".date('Y-m-d')."' ";
					$ptr_cash_from_bank=mysql_query($sel_cash_from_bank);
					$data_cash_from_bank=mysql_fetch_array($ptr_cash_from_bank);
					
					$sel_bank="select bank_name from bank where bank_id='".$data_dist_bank_id['bank_id']."'";
					$ptr_bank=mysql_query($sel_bank);
					$data_bank_name=mysql_fetch_array($ptr_bank);
					
					echo $data_bank_name['bank_name']." : ".$data_cash_from_bank['total_amt'] ;
					$tt .=$data_cash_from_bank['total_amt'];
					
					if($i !=$total)
					{
						echo '<br /><hr >';
					}
					$i++;
				}
				//echo "total -".$tt;
				//=============================================================================
				//===================Cash in Hand===============================
				$sel_total_inc1="select SUM(amount) as total_amt from invoice where DATE(`added_date`) = '".date('Y-m-d')."' and (bank_name='' or bank_name= 'select')";
				$ptr_total_inc1=mysql_query($sel_total_inc1);
				$data_total_inc1=mysql_fetch_array($ptr_total_inc1);
				
				$sel_total_inc21="select SUM(amount) as total_amt from receipt where added_date='".date('Y-m-d')."' and bank_id=''";
				$ptr_total_inc21=mysql_query($sel_total_inc21);
				$data_total_inc21=mysql_fetch_array($ptr_total_inc21);
				
				 $cash_in_hand=$data_total_inc1['total_amt']+$data_total_inc21['total_amt']; //DATE(added) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
				 
				 $total_cash_fees=$data_ptr_sel['total_amt'] ;
				 $total_cash_product= $data_sel_recipt['total_amt'];
				
					
				$cash_in_hands=$opening_cash1 + $data_ptr_sel['total_amt'] +$data_sel_recipt['total_amt'] + $data_expense_taken['total_amt'] + $data_cash_received_sir['total_amt'] - $data_total_expense['total_amt'] -  $data_cash_from_sir['total_amt'] - $data_cash_deposite_in_bank['total_amt'] + $data_cash_from_innocent['total_amt'];
				//==============================================================================
				echo '</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_cash_from_innocent['total_amt'].'</td> <input type="hidden" name="cash_received_from_innocent" value="'.$data_cash_from_innocent['total_amt'].'"  />';
				echo '<td align="center" style="border:1px solid #CCC">'.$cash_in_hands.'</td> <input type="hidden" name="cash_in_hand" value="'.$cash_in_hands.'"  />';
				
				
 ?> 
   </table>
   </td>
  </tr>  
  <tr>
  <td class="width5" colspan="10" align="center">
 <input type="hidden" name="send_mail"  value="mail">
 <input type="submit" name="sending_mail" value="Send Mail" class="inputButton"/></td>
 </tr>
 </form>
<!-- <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    
    <td width="5%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="20%" align="center" style="border:1px solid #CCC"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Payment Mode</strong></a> <?php echo $img1;?></td>
     <td width="10%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
   </tr>
    <?php
	/*$sele_pay_mode1="select payment_mode_id as total_amt from expense where added_Date=".date('Y-m-d')."";
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
				echo '<tr>';
				echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
				echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
				echo '<td align="center" style="border:1px solid #CCC">'.$data_ptr_sel1['total_amt'].'</td>';
			}
			
		$i++;
		}
	}
	else
	{
		echo '<tr><td class="text" align="center" colspan="3"><br><div class="msgbox" style="width:50%;background-color:green">No Amount added by any Payment mode on today</div><br></td></tr>';
	}*/
 ?> 
   </table>
   </td>
  </tr>-->
  
  
  
   <!--<tr>-->
  <?php 
  /*$select_amnt1="select SUM(amount) as total from expense where added_Date=".date('Y-m-d')." order by expense_id desc";
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
	}*/
  ?>
 <!--<td align="left" colspan="10" style="color:#F00"><strong>Todays Outgoing</strong> : <?php echo $total_amount1; ?></td>
  </tr>-->
 <!--   <tr>
  <?php 
/*  $select_amnt1="select SUM(amount) as total from expense added_Date=subdate(currentDate, 1) order by expense_id desc limit 0,1";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}*/
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Yesterday Outgoing</strong> : <?php //echo $total_amount1; ?></td>
  </tr>-->
</table>

	</td>
    <td class="mid_right"></td>
  </tr>
    
    
    
    
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>

</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
