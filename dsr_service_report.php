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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php";?></td>
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
                <?php if($_SESSION['type']=='S')
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
                       
					</td>
					<?php } ?>
                    <td><input type="submit" name="search" value="Search" class="inputButton"/></td>
                </form>	       
           	</tr>
        </table>
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
	?><script>
	document.location.href="dsr_mail.php?<?php echo $sep_url_string; ?>&send_mail=mail";
	</script>
	<?php
  }
  
  
  ?>
  <form method="post" name="search">
 <!--==============================================================================INCOMMING SERVICES==============================================================-->
<tr  bgcolor="#AFD8E0">
	<td align="center" colspan="10"><strong>Incoming Service /Membership</strong></td>
</tr>
<tr>
<?php 
//===================Total receive balance===============================
$sel_total_servicec="select SUM(payable_amount) as total_amt from customer_service where payable_amount>'0' and DATE(`added_date`) = '".$date."' ".$branch_id."";
$ptr_total_service=mysql_query($sel_total_servicec);
$data_total_service=mysql_fetch_array($ptr_total_service);

$sql_customer= "SELECT price FROM customer where DATE(`added_date`)='".$date."' and membership ='yes' ".$branch_id." "; 
$ptr_customer=mysql_query($sql_customer);
while($data_customer=mysql_fetch_array($ptr_customer))
{
	$price +=$data_customer['price'];
}

$total_service_amount=$data_total_service['total_amt']+$price;
//==============================================================================
?>
  <td align="left" colspan="11" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_service_amount; ?></td>
  <input type="hidden" name="total_incoming_service" value="<?php echo $total_service_amount; ?>"  />
  </tr>
<?php
					   $select_directory='order by invoice_id asc';                      
					   $sql_query= "SELECT invoice_id,paid_type,bank_id,customer_service_id,voucher_number,cheque_detail,payable_amount FROM customer_service_invoice where paid_type!='0' and (payable_amount!='' or payable_amount!=0) and DATE(`added_date`)='".$date."' ".$branch_id." ".$select_directory." "; 
                       //echo $sql_query;
                       $no_of_records=mysql_num_rows($db->query($sql_query));
?>
                      <tr class="grey_td" style="background-color:#999">
                        <td width="45" align="center"><strong>Sr. No.</strong></td>
                        <td align="center" colspan="2"><strong>Sale Type</strong></td>
                        <td width="241" align="center"><strong>Customer Name</strong></td>
                        <td width="126" align="center"><strong>Payment Mode</strong></td>
                        <td width="104" align="center"><strong>Bank</strong></td>
                        <td width="105" align="center"><strong>Account No</strong></td>
                        <td width="151" align="center"><strong>Chaque No</strong></td>
                        <td width="144" align="center"><strong>Amount</strong></td>
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
                                $listed_record_id=$val_query['invoice_id']; 
                                include "include/paging_script.php";
								/*$sql_invoice="select invoice_id,chaque_date,paid_type,bank_name,cheque_detail,amount from invoice where enroll_id='".$val_query['enroll_id']."' ".$branch_id."";
								$my_query_invoice=mysql_query($sql_invoice);
								$row_invoice= mysql_fetch_array($my_query_invoice);*/
								
                                $sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
								$ptr_payment_mode=mysql_query($sel_payment_mode);
								$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
								
								$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
								$ptr_bank=mysql_query($sel_bank);
								$data_bank_name=mysql_fetch_array($ptr_bank);
								
								$sel_="select customer_id from customer_service where customer_service_id='".$val_query['customer_service_id']."'";
								$ptr_sels=mysql_query($sel_);
								$data_cust_srv=mysql_fetch_array($ptr_sels);
								
								$sel_cust_name="select cust_name from customer where cust_id='".$data_cust_srv['customer_id']."' ";
								$ptr_cust_name=mysql_query($sel_cust_name);
								$data_cust_name=mysql_fetch_array($ptr_cust_name);
								
								$voucher_no=='';
								if($data_payment_mode['payment_mode'] =="6")
								{
									$voucher_no="Voucher No.- ".$val_query['voucher_number'];
								}
                                echo '<tr '.$bgcolor.' >';
                                echo '<td align="center">'.$sr_no.'</td>';   
								echo '<td align="center" colspan="2">Service</td>';    
                                echo '<td align="center">'.$data_cust_name['cust_name'].'</td>';
                                echo '<td align="center">'.$data_payment_mode['payment_mode']."<br/>".$voucher_no.'</td>';
								echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
								echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
								echo '<td align="center">'.$val_query['cheque_detail'].'</td>';
								echo '<td align="center">'.$val_query['payable_amount'].'</td>';
                                /*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                                echo '</td>';*/
                                echo '</tr>';
                                $bgColorCounter++;
                            }
							     
                                ?>
 
      <?php } 
      else
        echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Service added on today</div><br></td></tr>';
		
		$select_directory='order by cust_id asc';
		$sql_querys= "SELECT payment_mode_id,bank_id,customer_id,chaque_no,price FROM customer where DATE(`added_date`)='".$date."' and membership ='yes'  ".$branch_id." ".$select_directory." "; 
        //echo $sql_query;
        $no_of_recordss=mysql_num_rows($db->query($sql_querys));
		if($no_of_recordss)
		{
			$bgColorCounter=1;
			//$_SESSION['show_records'] = 10;
			$query_string='&keyword='.$keyword;
			$query_string1=$query_string.$date_query;
			// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
			$pager = new PS_Pagination($sql_querys,$_SESSION['show_records'],5,$query_string1);
			$all_records= $pager->paginate();
			while($val_query=mysql_fetch_array($all_records))
			{
				if($bgColorCounter%2==0)
					$bgcolor='class="grey_td"';
				else
					$bgcolor="";                
				//$listed_record_id=$val_query['customer_service_id']; 
				//include "include/paging_script.php";
				
				
				$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."' ";
				$ptr_payment_mode=mysql_query($sel_payment_mode);
				$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
				
				$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
				$ptr_bank=mysql_query($sel_bank);
				$data_bank_name=mysql_fetch_array($ptr_bank);
				
				$sel_cust_name="select cust_name from customer where cust_id='".$val_query['customer_id']."' ";
				$ptr_cust_name=mysql_query($sel_cust_name);
				$data_cust_name=mysql_fetch_array($ptr_cust_name);
				
				echo '<tr '.$bgcolor.' >';
				echo '<td align="center">'.$sr_no.'</td>'; 
				echo '<td align="center" colspan="2">Membership</td>';    
				echo '<td align="center">'.$data_cust_name['cust_name'].'</td>';
				echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
				echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
				echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
				echo '<td align="center">'.$val_query['chaque_no'].'</td>';
				echo '<td align="center">'.$val_query['price'].'</td>';
				echo '</tr>';
				$bgColorCounter++;
			} 
		}
		?>
 <!--===================================================================================END========================================================================-->
 
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