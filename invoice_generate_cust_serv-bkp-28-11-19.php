<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
//echo base64_decode('SW5mb3RlY2hAMTIz');

//  update dd_user_payement set `amount`=amount * no_of_leads where `no_of_leads` !=0
?>
<?php
/** 
*  Function:   convert_number 
*
*  Description: 
*  Converts a given integer (in range [0..1T-1], inclusive) into 
*  alphabetical format ("one", "two", etc.)
*
*  @int
*
*  @return string
*
*/ 
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
	jQuery(document).ready( function() {
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
    </script>
    <link rel="stylesheet" href="js/jquery.custom/development-bundle/themes/base/jquery.ui.all.css">
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

    <script type="text/javascript">
    $(document).ready(function()
    {
        //$('.date-input-1').datepicker({ maxDate: "+0D",changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-1').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-2').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst) 
        {
            res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
        }
    });
    </script>
    <style>
	.left_border{ border-left:solid 0.6mm; }
	.right_border{ border-right:solid 0.6mm;}
	.right_border1{ border-right:solid #EFEFEF  1px;}
	.top_border{ border-top:solid 0.6mm;}
	.bottom_border{ border-bottom:solid 0.6mm;}
	body{ font-family:Verdana, Geneva, sans-serif}
	</style>
</head>
<body>
    <div class="heightSpacer"></div>
		<?php
        
        $record_id =$_GET['record_id'];
          
        $sql_records= "SELECT * from customer_service_invoice where invoice_id ='".$record_id."'";
        $ptr_exsist =mysql_query($sql_records);
        $data_bill_master=mysql_fetch_array($ptr_exsist);
        $invoice_no=$data_bill_master['receipt_no'];
        $amount_paid=$data_bill_master['amount'];
        $bank_name=$data_bill_master['bank_name'];
        $cheque_detail=$data_bill_master['cheque_detail'];
        $chaque_date=$data_bill_master['chaque_date'];					
        
        $sql_record= "SELECT * FROM customer_service where customer_service_id='".$data_bill_master['customer_service_id']."'";
        $_SESSION['sql_articles']=$sql_record;
        if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
        
		if($row_record['type']=='Student')
		{
			$sql_name ="select name,contact,cust_gst_no,mail from enrollment where enroll_id='".$row_record['customer_id']."' ";
			$ptr_name= mysql_query($sql_name);
			$data_name= mysql_fetch_array($ptr_name);
			$cust_name=$data_name['name'];
			$mobile1=$data_name['contact'];
			$gst_no=$data_name['cust_gst_no'];
			$email=$data_cust_name['mail'];
		}
		else if($row_record['type']=='Employee')
		{
			$sql_emp_name="select name, admin_id,contact_phone,email from site_setting where admin_id='".$row_record['customer_id']."' ";
			$ptr_emp_name=mysql_query($sql_emp_name);
			$data_emp_name=mysql_fetch_array($ptr_emp_name);
			$cust_name=$data_emp_name['name'];
			$mobile1=$data_emp_name['contact_phone'];
			$email=$data_cust_name['email'];
			$gst_no='';
		}
		else 
		{
			$sql_cust_name="select cust_name,cust_id,mobile1,cust_gst_no,membership,email from customer where cust_id='".$row_record['customer_id']."' ";
			$ptr_cust_name=mysql_query($sql_cust_name);
			$data_cust_name=mysql_fetch_array($ptr_cust_name);
			$cust_name=$data_cust_name['cust_name'];
			$mobile1=$data_cust_name['mobile1'];
			$gst_no=$data_cust_name['cust_gst_no'];
			$email=$data_cust_name['email'];
			$membership=$data_cust_name['membership'];
		}
		
		
        //=============================================================
            $sql_records_invoice= "SELECT * FROM `customer_service_invoice` WHERE customer_service_id='".$data_bill_master['customer_service_id']."' and (invoice_id < ".$record_id.") order by invoice_id desc limit 1";
            $ptr_exsist_invoice =$db->query($sql_records_invoice);
            $data_last_invoice_id=mysql_fetch_array($ptr_exsist_invoice);
        //=================================================================
        ?>
		<table align="center" border="0" width="450" style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-top:solid 0.6mm;border-top-radius:5px;">
        <tr>
            <td valign="top" width="185"><img src="images/innocent.png" width="180" height="60" title="Innocent Beauty Salon"/></td>
            <td style="font-size:14px;">Receipt No: <?php echo $invoice_no; ?> <br/> 
            	Invoice No: <?php echo $row_record['customer_invoice_no']; ?> <br/> 
                Date : <?php echo $data_bill_master['added_date']; ?>
            </td>
        </tr>
        <tr>
        	<td colspan="3" style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-top:solid 0.6mm;border-top-radius:5px;"></td>
        </tr>
        <tr>
        	<td width="601" align="right" style="padding-right:15px;" colspan="2">
            <table width="99%">
				<?php 
                if($_SESSION['type']=='S')
                {
                    $sele_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']."";
                    $ptr_cm_id=mysql_query($sele_cm_id);
                    $data_cm_id=mysql_fetch_array($ptr_cm_id);
                   
                    $select_branch_address="select innocent_address from branch where branch_name='".$data_cm_id['branch_name']."'";
                    $pte_branch_name=mysql_query($select_branch_address);
                    $data_branch_name=mysql_fetch_array($pte_branch_name);
                    echo $data_branch_name['innocent_address'];
                    //echo str_replace("International School of Aesthetics and Spa","Innocent Beauty Salon",$data_branch_name['innocent_address']);
                }
                else
                {
                    echo $_SESSION['branch_address'];
                    //echo str_replace("International School of Aesthetics and Spa","Innocent Beauty Salon",$_SESSION['branch_address']);
                }
                ?>
            </table>
			<?php
             if($_GET['action'] !='print')
             {
                ?>
                <a href="invoice_generate_cust_serv.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none">
                <input type="button" name="print" value="Print" /></a>
                <?php 
            } ?>
        </td>
	</tr>
    <tr height="5">
    </tr>
	</table>
	<table align="center" border="1px"  width="450" cellpadding="0" cellspacing="0" bgcolor="#EFEFEF" style=" border:1px solid;" >
    	<tr></tr>
    </table>
	</td>
	</tr>
 	</table>
    	<table align="center" border="0" width="450" cellpadding="0" style="border-left:solid 0.6mm; border-right:solid 0.6mm; ">
            <tr>
                <td></td><td></td>
            </tr>
            <tr>
                <td width="40%" height="10" style="padding-left:10px; font-size:16px;" ><strong>Customer Name :</strong></td>
                <td height="10" style="font-size:16px;" colspan="2"> <strong><?php echo $cust_name; ?></strong> </td>
            </tr>
            <tr>
                <td height="10" style="padding-left:10px; font-size:16px;"><strong>Mobile No :</strong></td>
                <td style="padding-left:10px; font-size:16px;"><strong><?php echo $mobile1; ?></strong></td>
            </tr>
            <tr>
                <td height="10" style="padding-left:10px; font-size:16px;"><strong>Email ID :</strong></td>
				<td style="padding-left:10px; font-size:16px;"><strong><?php echo $email; ?></strong></td>
            </tr>
            <tr>
                <td height="10" style="padding-left:10px; font-size:16px;"><strong>Cust. GST no :</strong></td>
				<td style="padding-left:10px; font-size:16px;"><strong><?php echo $gst_no; ?></strong></td>
            </tr>
            <tr>
                <td colspan="4"> <h3 align="center"><font size="+1">Service Price Details</font></h3></td>
            </tr>
        </table>
        <table align="center" border="1px " width="450" cellpadding="5" cellspacing="5" bgcolor="#EFEFEF" style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-collapse:collapse " >
            <tr>
                <td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Total Service Price</span></td>
                <td width="26%" width:20% align="center"><font size="4px;"><?php echo $row_record['service_price']; ?></font></td>
            </tr>
            <tr>
                <?php
                if($row_record['nonmemb_discount_type']=='percentage')
                    $discount_type="%";
                else
                    $discount_type="Rs";
                ?>
                <td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Non-member Discount in (<?php echo $discount_type ?>)</span></td>
                <td width="26%" width:20% align="center"><font size="4px;"><?php echo $row_record['nonmemb_discount']; ?></font></td>
            </tr>
            <tr>
                <td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Non-member Discount Price</span></td>
                <td width="26%" width:20% align="center"><font size="4px;"><?php echo $row_record['nonmemb_discount_price']; ?></font></td>
            </tr>
            <tr>
                <td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Total Cost</span></td>
                <td width="26%" width:20% align="center"><font size="4px;"><?php echo $row_record['total_cost']; ?></font></td>
            </tr>             
            <tr>
                <td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Final Amount</span></td>
                <td width="26%" width:20% align="center"><font size="4px;"><?php echo $row_record['amount']; ?></font></td>
            </tr>
            <tr>
                <td align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold"> Total paid Amount</span></td>
                <td width:20% align="center"><font size="4px;"><?php echo $data_bill_master['total_paid'];  ?></font></td>
            </tr>
            <tr>
                <td align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold"> Deposit Amount</span></td>
                <td width:20% align="center"><font size="4px;"><?php echo $data_bill_master['payable_amount'];  ?></font></td>                   
            </tr>
            <tr>
                <td width="24%" align="left"  style="padding-left:10px;width:20%"><span style="font-size:16px; font-weight:bold">Remaining Amount</span></td>
                <td width="29%" width:20% align="center"> <font size="4px;"><?php echo $data_bill_master['remaining_amount']; ?></font></td>
            </tr>				
        </table>
        <table align="center" border="0" width="450" cellpadding="0" style="border-left:solid 0.6mm; border-right:solid 0.6mm; ">
            <tr height="20px">
                <td colspan="4" style="padding-left:20px; font-size:16px; font-weight:bold"> <span> Deposit Amount In Words -: <?php echo convert_number($data_bill_master['payable_amount']) ?> Only</span></td><td></td>
            </tr>
        </table>
        <table align="center" border="0" width="450" cellpadding="0" style="border-left:solid 0.6mm; border-right:solid 0.6mm; ">
            <tr><td colspan="4"> <h3 align="center"><font size="+1">Payment Details</font></h3></td></tr>
        </table>
            <table align="center" border="0" width="450" cellpadding="0" style="border-left:solid 0.6mm; border-right:solid 0.6mm;  border-bottom:solid 0.6mm;">
            	<tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <?php
                    $sel_pay_mode="select payment_mode from payment_mode where payment_mode_id='".$data_bill_master['paid_type']."'";
                    $ptr_sel_mode=mysql_query($sel_pay_mode);
                    $fetch_pay_mode=mysql_fetch_array($ptr_sel_mode);
                    ?>
                    <td width="190" class="heading"  style="padding-left:20px; font-size:16px;">Mode Of Payment<span class="orange_font"></span></td>
                    <td style=" font-size:16px;"><strong><?php echo $fetch_pay_mode['payment_mode'];?></strong></td>
               	</tr>
			   	<?php 
				if($fetch_pay_mode['payment_mode']=='cheque')
				{
					$sel_bank_name="select bank_name,bank_id from bank where bank_id='".$data_bill_master['bank_id']."'";
					$quer_bank=mysql_query($sel_bank_name);
					$fetch_qeur=mysql_fetch_array($quer_bank);
					?>
					<tr>
						<td width="190" height="10" style="padding-left:20px; font-size:16px;">Bank Name: </td>
						<td width="196" height="10" style=" font-size:16px;" ><strong><?php echo $fetch_qeur['bank_name']; ?></strong> </td>
						<td width="146"></td>
					</tr>
						  
					<tr>
						<td width="190" height="10" style="padding-left:20px; font-size:16px;">Cheque No: </td>
						<td width="196" height="10" style=" font-size:16px;" ><strong><?php echo  $data_bill_master['cheque_detail']; ?></strong> </td>
					</tr>
					<tr>
					<?php
					$explode_checq_date=explode('-',$data_bill_master['chaque_date']);
					$sep_cheque=$explode_checq_date[2].'-'.$explode_checq_date[1].'-'.$explode_checq_date[0];
					?>
						<td width="190" height="10" style="padding-left:20px; font-size:16px;">Cheque Date: </td>
						<td width="196" height="10" style=" font-size:16px;" ><?php echo $sep_cheque; ?> </td>
					</tr>
					<?php 
				}?>
                           
				<?php 
                if($fetch_pay_mode['payment_mode']=='online')
                {
                    $sele_online_trans="select bank_ref_id, bank_name, paymode, order_id from online_trans_details where order_id='$record_id'";
                    $ptr_sel=mysql_query($sele_online_trans);
                    $data_online_trans=mysql_fetch_array($ptr_sel);
                    ?>
                    <tr>
                        <td width="190" height="10" style="padding-left:20px; font-size:16px;">Payment Mode: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_online_trans['paymode']; ?> </td>
                        <td width="146"></td>
                    </tr>
                    <tr>
                        <td width="190" height="10" style="padding-left:20px; font-size:16px;">Bank Name: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_online_trans['bank_name']; ?> </td>
                        <td width="146"></td>
                    </tr>
                    <tr>
                        <td width="190" height="10" style="padding-left:20px; font-size:16px;">Order ID: </td><td width="196" height="10" style=" font-size:16px;" ><?php echo  $data_online_trans['order_id']; ?> </td>
                    </tr>
                    <tr>
                        <td width="190" height="10" style="padding-left:20px; font-size:13px;">Bank Reference ID: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_online_trans['bank_ref_id']; ?> </td>
                    </tr>
                    <!--<tr><td></td></tr>-->
                    <?php 
                }?>
     			<tr><td width="190" class="heading"  style="padding-left:20px; font-size:16px;">Total Amount Paid:</td><td width="242" height="10" style=" font-size:16px;" ><strong><?php echo $data_bill_master['payable_amount']; ?></strong> </td>
           	</tr>
        </table>                                        
       	<table align="center" border="0" width="450" cellpadding="0"  style="border-left:solid 0.6mm; border-right:solid 0.6mm;  border-bottom:solid 0.6mm;">
        	<tr height="20px"><td colspan="2"></td></tr>
        	<tr><td width="395" align="left"><b><font size="-1">ISAS Authorised Signature</font></b></td>
        	<td width="383" align="right"><b><font size="-1">Customer Signature</font></b></td></tr>
        </table>
    </table>
	<?php
    if($_GET['action']=='print' )
    {
		?>
		<script language="javascript">
		
		window.print();
		//window.close();
		setTimeout('window.close();',3000);
		//setTimeout('window.close();',5000);
		</script>
		<?php	
    }							
    ?>
</body>
</html>
<?php $db->close();?>