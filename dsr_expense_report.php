<?php include 'inc_classes.php';
ini_set('max_execution_time',1000);
?>
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
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
	$sep_url_string=$sep_url[1];
}
//echo $_GET['branch_id'];
if($_GET['branch_id'] =='' )
{
	$branch_id= $_SESSION['where'];
	$cm_id1= $_SESSION['cm_id'];
	$branch_name='';
}
else
{
	$branch_id= "and cm_id = '".$_GET['branch_id']."'";
	$cm_id1= $_GET['branch_id'];
	
	$sel_branch_name="select branch_name from site_setting where cm_id=".$cm_id1." and type='A'";
	$ptr_branch_name=mysql_query($sel_branch_name);
	$data_branch=mysql_fetch_array($ptr_branch_name);
	$branch_name=$data_branch['branch_name'];
}
?>
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
    <td class="top_mid" valign="bottom"><?php include "include/expense_menu.php";?></td>
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
			  <td width="30%" align="right">Date: </td>
			  <td width="20%" align="left"><input type="text" name="date" class="input_text datepicker" placeholder="date" id="date" title="Date" value="<?php if($_REQUEST['date']!='') echo $_REQUEST['date']; else echo date('d/m/Y');?>"></td>
                <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
				?>
					<td width="100%" align="center" ><strong>Select Branch</strong> &nbsp;&nbsp;
                        <?php
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						//echo '<table width="100%"><tr><td>';
						echo ' <select id="branch_id" name="branch_id">';
						echo '<option value="">Select Branch</option>';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							$selected_branch="select cm_id from site_setting where branch_name= '".$row_branch['branch_name']."' and type='A' ";
							$ptr_selected=mysql_query($selected_branch);
							if(mysql_num_rows($ptr_selected))
							{
								$data_cm_id=mysql_fetch_array($ptr_selected);
								$cm_id= $data_cm_id['cm_id'];
							}
							$selected='';
							if($_REQUEST['branch_id'] !='' && $_REQUEST['branch_id']== $cm_id)
							{
								 $selected='selected="selected"';
							}
							else if($_REQUEST['branch_id'] =='' && $row_branch['branch_name']=='Pune')
							{
								$selected='selected="selected"';
							}
							?>
							<option <?php echo $selected; ?> value="<?php echo $cm_id;?>"><?php echo $row_branch['branch_name']; ?> 
							</option>
							<?php
						
						}
						echo '</select>';
						//echo "</td></tr></table>";
						?> 
                        <!-- <td width="10%">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php //if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                         
                         <td width="10%">
                         <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php //if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                         </td>-->
					</td>
					<?php } ?>
                    <td><input type="submit" name="search" value="Search" class="inputButton"/></td>
                		<!--<td class="rightAlign" > 
                    		<table border="0" cellspacing="0" cellpadding="0" align="right">
              					<tr>
              						<td></td>
              						<td class="width5"></td>
                					<td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
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
  
	$date=date('Y-m-d');
	$date_for_month=date('Y-m');
	if($_REQUEST['date'] && $_REQUEST['date']!=="0000-00-00" && $_REQUEST['date']!="date")
	{
		$frm_date=explode("/",$_REQUEST['date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$date=date('Y-m-d',strtotime($frm_dates));
		$date_for_month=date('Y-m',strtotime($frm_dates));
	}
  	if(isset($_POST['sending_mail']))
  	{
		if($cm_id1=='2')
		{
			?><script>
			document.location.href="dsr_mail_pune.php?<?php echo $sep_url_string; ?>&send_mail=mail";
			</script>
			<?php
		}
		if($cm_id1=='60')
		{
			?><script>
			document.location.href="dsr_mail_ahm.php?<?php echo $sep_url_string; ?>&send_mail=mail";
			</script>
			<?php
		}
		if($cm_id1=='87')
		{
			?><script>
			document.location.href="dsr_mail_baramati.php?<?php echo $sep_url_string; ?>&send_mail=mail";
			</script>
			<?php
		}
		if($cm_id1=='115')
		{
			?><script>
			document.location.href="dsr_mail_pcmc.php?<?php echo $sep_url_string; ?>&send_mail=mail";
			</script>
			<?php
		}
		
		/* $insert_dsr="insert into dsr(`total_incoming`, `total_outgoing`, `yesterday_bal`, `total_cash_fees`, `total_cash_product`, `total_cash_taken_from_bank`, `cash_received_from_director`, `total_cash_expense`, `cash_given_to_director`,`cash_received_from_innocent`,`cash_in_hand`,`added_date`,`cm_id`) values ('".$_POST['total_incoming']."','".$_POST['total_outgoing']."','".$_POST['opening_cash']."','".$_POST['total_cash_fees']."','".$_POST['total_cash_product']."','".$_POST['total_cash_taken_from_bank']."','".$_POST['cash_received_from_director']."','".$_POST['total_cash_expense']."','".$_POST['cash_given_to_director']."','".$_POST['cash_received_from_innocent']."','".$_POST['cash_in_hand']."','".$date."','".$cm_id1."')";
	  $ptr_insert=mysql_query($insert_dsr);
	  
		 for($i=1;$i<=$_POST['total_banks']; $i++)
		  {
			  $insert_into_dsr_bank=" insert into dsr_bank_summery (`bank_id`,`account_no`,`incoming`,`	outgoing`,`yesterdas_balance`,`todays_balance`,`added_date`) values('".$_POST['bank_id_'.$i.'']."','".$_POST['account_no'.$i.'']."','".$_POST['incoming'.$i.'']."','".$_POST['outgoing'.$i.'']."','".$_POST['yesterday_bal'.$i.'']."','".$_POST['today_bal'.$i.'']."','".$date."')";
			  
			  $ptr_banks=mysql_query($insert_into_dsr_bank);
		  }*/
	?><script>
	document.location.href="dsr_mail.php?<?php echo $sep_url_string; ?>&send_mail=mail";
	</script>
	<?php
  }
  
  
  ?>
  <form method="post" name="search">
  
  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incommimg (Receipt)</strong></td>
  </tr>
  <tr>
  <?php 
	$sel_total_inc2="select SUM(amount) as total_amt from receipt where added_date='".$date."' ".$branch_id."";
	$ptr_total_inc2=mysql_query($sel_total_inc2);
	$data_total_inc2=mysql_fetch_array($ptr_total_inc2);
	$total=$data_total_inc2['total_amt'];
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Total Incomming</strong> : <?php echo $total; ?></td>
  <input type="hidden" name="total_incomming" value="<?php echo $total; ?>"  />
  </tr>
  
  <tr>
 <td colspan="10" >
 <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
 <tr style="background-color:#999">
    <td width="04%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    <td width="10%" align="center" style="border:1px solid #CCC"><strong>Type</strong></td>
    <td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Bank</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Descrription</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Customer name</strong></td>
    <td width="15%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
 </tr>
    <?php
	$sele_recep="select receipt_id,category,payment_mode_id,bank_id,amount,added_date,cash_transfer_mode,customer_id,emp_type,description from receipt where 1 and category='incoming' and added_date='".$date."' ".$branch_id."";
	$ptr_recep=mysql_query($sele_recep);
	$i=1;
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
			echo '<tr>';
			echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';       
			echo '<td align="center" style="border:1px solid #CCC">'.$category.' '.$cash_modes.'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			//echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['description'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$name.'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td>';
			$i++;
		}
	}
	
 ?> 
 
   </table>
   </td>
  </tr>
 <!--===================================================================================END========================================================================-->
  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Outgoing (Expense)</strong></td>
  </tr>
  <tr>
  <?php 
	$select_inv="select SUM(payable_amount) as total from inventory_invoice where DATE(added_date)='".$date."' ".$branch_id." ";
	$ptr_inv=mysql_query($select_inv);
	$total_inv=0;
	if(mysql_num_rows($ptr_inv))
	{
		$data_inv=mysql_fetch_array($ptr_inv);
		$total_inv=$data_inv['total'];
	}
	
  	$select_amnt1="select SUM(amount) as total from expense where added_Date='".$date."' ".$branch_id." ";
	$ptr_amt1=mysql_query($select_amnt1);
	$total_amount1=0;
	if(mysql_num_rows($ptr_amt1))
	{
		$data_amnt1=mysql_fetch_array($ptr_amt1);
		$total_amount1=$data_amnt1['total'];
	}
	
	$total=$total_inv+$total_amount1;
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Total Outgoing</strong> : <?php echo $total; ?></td>
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
 	?>
	</table>
	</td>
</tr>
<!--===============================================================Fund Transfer============================================================================================-->
<tr bgcolor="#AFD8E0">
	<td align="center" colspan="10"><strong>Fund Transfer</strong></td>
</tr>
<tr>
	<td colspan="10"></td>
</tr>
<tr>
	<td colspan="10" >
    	<table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #999">
			<tr style="background-color:#999">
            	<td width="04%" align="center" style="border:1px solid #CCC"><strong>Sr. No.</strong></td>
    			<td width="10%" align="center" style="border:1px solid #CCC"><strong>Type</strong></td>
    			<td width="10%" align="center" style="border:1px solid #CCC"><strong>Payment Mode</strong></td>
    			<td width="15%" align="center" style="border:1px solid #CCC"><strong>From Bank</strong></td>
                <td width="15%" align="center" style="border:1px solid #CCC"><strong>To Bank</strong></td>
    			<td width="15%" align="center" style="border:1px solid #CCC"><strong>Descrription</strong></td>
    			<td width="15%" align="center" style="border:1px solid #CCC"><strong>Amount</strong></td>
 			</tr>
    		<?php
			$sele_recep="select receipt_id,category,payment_mode_id,bank_id,from_bank_name,amount,added_date,cash_transfer_mode,customer_id,emp_type,description from receipt where 1 and category='cash_transfer' and added_date='".$date."' ".$branch_id."";
			$ptr_recep=mysql_query($sele_recep);
			$i=1;
			if(mysql_num_rows($ptr_recep))
			{
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
					echo '<tr>';
					echo '<td align="center" style="border:1px solid #CCC">'.$i.'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$cash_modes.'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_pay_name['payment_mode'].'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$from_bank_name.' '.$from_bank_acc_no.'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].' ('.$data_bank_name['account_no'].')</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['description'].'</td>';
					echo '<td align="center" style="border:1px solid #CCC">'.$data_recep['amount'].'</td>';
					$i++;
				}
			}
 			?>
		</table>
	</td>
</tr>
<!--==========================================================================================================================================================================-->

  <tr>
  <td class="width5" colspan="10" align="center">
 <input type="hidden" name="send_mail"  value="mail">
 <?php 
 if($_SESSION['type']=='S')
 {
	 ?>
	 <input type="submit" name="sending_mail" value="Send Mail" class="inputButton"/></td>
	 <?php
 }
 ?>
 </tr>
 </form>

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