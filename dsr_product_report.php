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
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='288'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php";?></td>
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
		
	?><script>
	document.location.href="dsr_mail.php?<?php echo $sep_url_string; ?>&send_mail=mail";
	</script>
	<?php
  }
  
  
  ?>
  <form method="post" name="search">
 
 <!--==============================================================================INCOMMING PRODUCT==============================================================-->
  <tr  bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Incoming for Product</strong></td>
  </tr>
  <tr>
  <?php 
//===================Total receive balance===============================
$sel_total_servicec="SELECT SUM(payable_amount) as total_amt FROM sales_product_invoice where DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id."";
$ptr_total_service=mysql_query($sel_total_servicec);
$data_total_service=mysql_fetch_array($ptr_total_service);
$total_service_amount=$data_total_service['total_amt'];
//==============================================================================
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Total Incoming</strong> : <?php echo $total_service_amount; ?></td>
  <input type="hidden" name="total_incoming_service" value="<?php echo $total_service_amount; ?>"  />
  </tr>

  <tr class="grey_td" style="background-color:#999">
    <td width="45" align="center"><strong>Sr. No.</strong></td>
    <td width="102" align="center"><strong>Invoice Id</strong></td>
    <td width="121" align="center" colspan="2"><strong>Customer Name</strong></td>
    <td width="126" align="center"><strong>Payment Mode</strong></td>
    <td width="104" align="center"><strong>Bank</strong></td>
    <td width="105" align="center"><strong>Account No</strong></td>
    <td width="151" align="center"><strong>Chaque No</strong></td>
    <td width="144" align="center"><strong>Amount</strong></td>
  </tr>
  <?php  
	$select_directory='order by invoice_id asc';                      
	$sql_query= "SELECT invoice_id,sales_product_id,paid_type,bank_id,cheque_detail,payable_amount FROM sales_product_invoice where DATE(`added_date`)='".$date."' and payable_amount>0 ".$branch_id." ".$select_directory.""; 
	//echo $sql_query;
	$sql_query=mysql_query($sql_query);
	$no_of_records=mysql_num_rows($sql_query);
    if($no_of_records)
	{
		$ij=1;
		while($val_query=mysql_fetch_array($sql_query))
		{
			if($bgColorCounter%2==0)
				$bgcolor='class="grey_td"';
			else
				$bgcolor="";                
			$listed_record_id=$val_query['invoice_id']; 
			include "include/paging_script.php";
				
			$sel_sales_products="select sales_product_id,customer_id,type from sales_product where sales_product_id='".$val_query['sales_product_id']."'";	
			$ptr_products=mysql_query($sel_sales_products);
			$data_products=mysql_fetch_array($ptr_products);
			
			$sel_cust="select cust_name from customer where cust_id= '".$data_products['customer_id']."'";
			$ptr_cust=mysql_query($sel_cust);
			$data_cust=mysql_fetch_array($ptr_cust);
									
			$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
			$ptr_payment_mode=mysql_query($sel_payment_mode);
			$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
			
			$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$sel_cust_name="select name from vendor where vendor_id='".$data_products['vendor_id']."' ";
			$ptr_cust_name=mysql_query($sel_cust_name);
			$data_cust_name=mysql_fetch_array($ptr_cust_name);
			
			$name='';
			if($data_products['type']=='Customer')
			{
				$sql_product ="select cust_name, cust_id from customer where cust_id='".$data_products['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$name=$data_product['cust_name'];
			}
			else
			if($data_products['type']=='Employee')
			{
				$sql_product ="select name, admin_id from site_setting where admin_id='".$data_products['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$name=$data_product['name'];
			}
			else
			{
				$sql_product ="select name from enrollment where enroll_id='".$data_products['customer_id']."' ";
				$ptr_product = mysql_query($sql_product);
				$data_product = mysql_fetch_array($ptr_product);
				$name=$data_product['name'];
			}
			
			echo '<tr '.$bgcolor.' >';
			echo '<td align="center">'.$ij.'</td>';   
			echo '<td align="center">SALE-'.$val_query['sales_product_id'].'-'.$val_query['invoice_id'].'</td>';
			$sel_prod="select product_id from sales_product_map where sales_product_id = '".$data_products['sales_product_id']."'";
			$ptr_prod=mysql_query($sel_prod);
			$total_Sales=mysql_num_rows($ptr_prod);
			echo '<td align="center" colspan="2">';
			echo $name;
			echo '</td>';
			
			echo '<td align="center">'.$data_payment_mode['payment_mode'].'</td>';
			echo '<td align="center">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center">'.$data_bank_name['account_no'].'</td>';
			echo '<td align="center">'.$val_query['cheque_detail'].'</td>';
			echo '<td align="center">'.$val_query['payable_amount'].'</td>';
			/*echo '<td align="center"><a href="expense.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
				  <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
			echo '</td>';*/
			echo '</tr>';
			$ij++;
			$bgColorCounter++;
		}
	} 
	else
        echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Sales Product added on today</div><br></td></tr>';?>   
     
 <!--======================================================================END========================================================================-->
 
  <tr bgcolor="#AFD8E0">
  <td align="center" colspan="10"><strong>Outgoing (Product Purchase)</strong></td>
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
	
	
  ?>
  <td align="left" colspan="10" style="color:#F00"><strong>Total Outgoing</strong> : <?php echo $total; ?></td>
  <input type="hidden" name="total_outgoing" value="<?php echo $total_inv; ?>"  />
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
	
 	$select_directory='order by inventory_id asc';                      
	$sql_query= "SELECT inventory_id,paid_type,bank_id,payable_amount FROM inventory_invoice where DATE(`added_date`)='".$date."' and payable_amount > 0 ".$branch_id." ".$select_directory." "; 
	//echo $sql_query;
	$no_of_records=mysql_num_rows($db->query($sql_query));
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
			$listed_record_id=$val_query['inventory_id']; 
			//include "include/paging_script.php";
											
			$sel_payment_mode="select payment_mode from payment_mode where payment_mode_id='".$val_query['paid_type']."' ";
			$ptr_payment_mode=mysql_query($sel_payment_mode);
			$data_payment_mode=mysql_fetch_array($ptr_payment_mode);
				
			$sel_bank="select bank_name,account_no from bank where bank_id='".$val_query['bank_id']."' ";
			$ptr_bank=mysql_query($sel_bank);
			$data_bank_name=mysql_fetch_array($ptr_bank);
			
			$sele_inv="select vendor_id from inventory where inventory_id ='".$val_query['inventory_id']."' order by inventory_id asc limit 0,1";
			$ptr_inv1=mysql_query($sele_inv);
			$data_inv=mysql_fetch_array($ptr_inv1);
			
			$sel_cust_name="select name from vendor where vendor_id='".$data_inv['vendor_id']."' ";
			$ptr_cust_name=mysql_query($sel_cust_name);
			$data_cust_name=mysql_fetch_array($ptr_cust_name);
			
			echo '<tr '.$bgcolor.' >';
			echo '<td align="center" style="border:1px solid #CCC">'.$sr_no.'</td>';   
			
			$sel_prod="select product_id from inventory_product_map where inventory_id = '".$listed_record_id."'";
			$ptr_prod=mysql_query($sel_prod);
			$total_inventory=mysql_num_rows($ptr_prod);
			echo '<td align="center" style="border:1px solid #CCC">Purchase Produc ('.$total_inventory.')</td>';
			echo '<td align="center" style="border:1px solid #CCC">-</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_payment_mode['payment_mode'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_cust_name['name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['bank_name'].'</td>';
			echo '<td align="center" style="border:1px solid #CCC">'.$data_bank_name['account_no'].'</td>';
			
			echo '<td align="center" style="border:1px solid #CCC">'.$val_query['payable_amount'].'</td>';
			
			echo '</tr>';
			$bgColorCounter++;
		}    
	} 
    /*else
    	echo '<tr><td class="text" align="center" colspan="9"><br><div class="msgbox" style="width:50%;">No Purchase record added on today</div><br></td></tr>';*/?>
	</table>
	</td>
</tr>
<!--===============================================================END========================================================================================-->

  <tr>
  <td class="width5" colspan="10" align="center">
 <input type="hidden" name="send_mail"  value="mail">
 <?php 
 if($_SESSION['type']=='S' )
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
