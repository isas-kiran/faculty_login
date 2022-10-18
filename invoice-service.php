<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
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


						$type='';
						$record_id =$_GET['record_id'];
						   
						$sql_records= "SELECT * from customer_service where customer_service_id ='".$record_id."'";
						$ptr_exsist =$db->query($sql_records);
						$data_record=mysql_fetch_array($ptr_exsist);
						
						$sac_code=$data_record['sac_code'];
						$cust_bank_name=$data_record['cust_bank_name'];
						
						/*$sel="select cust_name,mobile1,email,membership,cust_gst_no from customer where cust_id='".$data_record['customer_id']."'";
						$ptr_cust=mysql_query($sel);
						$data_cust=mysql_fetch_array($ptr_cust);*/
						
						$sele_cm_id="select branch_name from site_setting where cm_id=".$data_record['cm_id']."";
						$ptr_cm_id=mysql_query($sele_cm_id);
					   	$data_cm_id=mysql_fetch_array($ptr_cm_id);
					   
					   	$select_branch_address="select innocent_address,innocent_logo,gst_no from branch where branch_name='".$data_cm_id['branch_name']."'";
					   	$pte_branch_name=mysql_query($select_branch_address);
					   	$data_branch_name=mysql_fetch_array($pte_branch_name);
						
						if($data_branch_name['innocent_logo']!='')
						{
							$logo=$data_branch_name['innocent_logo'];
						}
						else
						{
							$logo='innocent.png';
						}
						
						$cust_name='';
						$mobile1='';
						$email='';
						$membership='';
						$gst_no='';
												
						if($data_record['type']=='Student')
						{
							$sql_name ="select name,contact,cust_gst_no,mail from enrollment where enroll_id='".$data_record['customer_id']."' ";
							$ptr_name= mysql_query($sql_name);
							$data_name= mysql_fetch_array($ptr_name);
							$cust_name=$data_name['name'];
							$mobile1=$data_name['contact'];
							$gst_no=$data_name['cust_gst_no'];
							$email=$data_cust_name['mail'];
						}
						else if($data_record['type']=='Employee')
						{
							$sql_emp_name="select name, admin_id,contact_phone,email from site_setting where admin_id='".$data_record['customer_id']."' ";
							$ptr_emp_name=mysql_query($sql_emp_name);
							$data_emp_name=mysql_fetch_array($ptr_emp_name);
							$cust_name=$data_emp_name['name'];
							$mobile1=$data_emp_name['contact_phone'];
							$email=$data_cust_name['email'];
							$gst_no='';
						}
						else 
						{
							$sql_cust_name="select cust_name,cust_id,mobile1,cust_gst_no,membership,email from customer where cust_id='".$data_record['customer_id']."' ";
							$ptr_cust_name=mysql_query($sql_cust_name);
							$data_cust_name=mysql_fetch_array($ptr_cust_name);
							$cust_name=$data_cust_name['cust_name'];
							$mobile1=$data_cust_name['mobile1'];
							$gst_no=$data_cust_name['cust_gst_no'];
							$email=$data_cust_name['email'];
							$membership=$data_cust_name['membership'];
						}
						
						
						
						$sql_vendor= "SELECT name,email,contact_phone,contact_address from site_setting where admin_id ='".$data_record['staff_id']."'";
						$ptr_vendor =mysql_query($sql_vendor);
						$data_vendor=mysql_fetch_array($ptr_vendor);
						
						$sel_pay_mode="select payment_mode from payment_mode where payment_mode_id='".$data_record['payment_mode_id']."'";
						$ptr_sel_mode=mysql_query($sel_pay_mode);
						$fetch_pay_mode=mysql_fetch_array($ptr_sel_mode);
						$payment_mode=$fetch_pay_mode['payment_mode'];
						
						
						$sel_bank="select bank_name,account_no from bank where bank_id='".$data_record['bank_id']."'";
						$ptr_bank=mysql_query($sel_bank);
						$data_bank=mysql_fetch_array($ptr_bank);
						
						$bank_name=$data_bank['bank_name'];
						$account_no=$data_bank['account_no'];
						?>
                            
						<table align="center" border="1px"  width="400" style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-top:solid 0.6mm;border-radius:5px; border-collapse:collapse">
                        <tr>
                            <td valign="top" colspan="2" width="180" style="padding:10px;" ><img src="images/<?php echo $logo; ?>" width="140" height="80"/></td>
                            <td width="150" colspan="3" align="left" style="padding-left:8px; font-size:13px"><strong>Invoice No :</strong> <?php echo $data_record['customer_service_id'] ?><br/>
                            <strong>Date :</strong> <?php $added_date=explode(' ',$data_record['added_date'],3); '<br/>'.$exxxxx=$added_date[0]; $sep=explode('-', $exxxxx); $sep_added_date=$sep[2].'-'.$sep[1].'-'.$sep[0];
							echo $sep_added_date; ?><br/>
                            <strong>GST No :</strong> <?php echo $data_branch_name['gst_no']; ?><br/>
							<?php
							if($_GET['action'] !='print')
							{
								?>
								<a href="invoice-service.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
								<?php 
							} ?>
                            </td>
                        </tr>
                        <tr>
                    <td style="font-size:16px; padding-left:7px" colspan="5">
                    <table>
                      <?php 
					   if($_SESSION['type']=='S')
					   {
						   //echo $data_branch_name['branch_address'];
						   //echo str_replace("International School of Aesthetics and Spa","Innocent Beauty Salon",$data_branch_name['innocent_address']);
						   echo $data_branch_name['innocent_address'];
						}
						else
						{
							 echo $_SESSION['branch_address'];
							//echo str_replace("International School of Aesthetics and Spa","Innocent Beauty Salon",$_SESSION['branch_address']);
						}
						?>
                   </table>
                </td>
                </tr>                   
                <tr height="5">
                <td colspan="5">
                	<table width="100%" border="1" style="border:1px solid black; border-collapse:collapse">
                    	<tr>
                			<td width="38%" align="center"><span style="font-size:16px; font-weight:bold">Customer Name</span></td>
                    		<td width="66%" align="center"><span style="font-size:16px; font-weight:bold"><?php echo $cust_name; ?></span></td>
                    	</tr>
                        <tr>
                			<td width="28%" align="center"><span style="font-size:16px; font-weight:bold">Mobile no.</span></td>
                    		<td width="72%" align="center"><span style="font-size:16px; font-weight:bold"><?php echo $mobile1; ?></span></td>
                    	</tr>
						<?php
						if($email)
						{
						?>
                        <tr>
                			<td width="28%" align="center"><span style="font-size:16px; font-weight:bold">Email ID</span></td>
                    		<td width="72%" align="center"><span style="font-size:16px; font-weight:bold"><?php echo $email; ?></span></td>
                    	</tr>
                        <?php
						}
						if($gst_no !='')
						{
						?>
                        <tr>
                			<td width="28%" align="center"><span style="font-size:16px; font-weight:bold">Customer GST no.</span></td>
                    		<td width="72%" align="center"><span style="font-size:16px; font-weight:bold"><?php echo $gst_no; ?></span></td>
                    	</tr>
                        <?php 
						}
						/*if($sac_code)
						{
						?>
						<tr>
                			<td width="28%" align="center"><span style="font-size:16px; font-weight:bold">SAC No.</span></td>
                    		<td width="72%" align="center"><span style="font-size:16px; font-weight:bold"><?php echo $sac_code; ?></span></td>
                    	</tr>
                        <?php 
						}*/
						?>
                    </table>
                </td>
                </tr>
             <!-- </table>
               <table align="center" border="1px"  width="414" style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-top:solid 0.6mm;border-radius:5px; border-collapse:collapse" cellpadding="" cellspacing="5">
            </table>
            <table cellpadding="0" cellspacing="2"  style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-top:solid 0.6mm;border-radius:5px; border-collapse:collapse" width="400" border="1px" align="center" >-->
            <tr bgcolor="#EFEFEF">
                    <td width="20%" align="center"><span style="font-size:16px; font-weight:bold; padding:2px">Service Name</span></td>
                    <td width="20%" align="center"><span style="font-size:16px; font-weight:bold ; padding:2px">Service Price</span></td>
                    <?php if($data_record['discount_type']=="percentage") {$type="%";} else if($data_record['discount_type']=="rupees") {$type="Rs/-";}?>
                    <td align="center" colspan="2" width="30%"><span style="font-size:16px; font-weight:bold; padding:2px">Discount (in <?php echo $type; ?>) </span></td>
                    <td width="30%" align="center"><span style="font-size:16px; font-weight:bold; padding:2px">Total Price</span></td>
            </tr>
            <?php
				
				$sel_map="select * from customer_service_map where customer_service_id='".$data_record['customer_service_id']."'";
				$ptr_map=mysql_query($sel_map);
				$i=1;
				$total=mysql_num_rows($ptr_map);
				$total_time='';
				$total_price='';
				$service_price='';
				$discount_price='';
				while($data_service=mysql_fetch_array($ptr_map))
				{
					$sel_ser_name="select service_name,service_price from servies where service_id='".$data_service['service_id']."'";
					$ptr_name=mysql_query($sel_ser_name);
					$data_name=mysql_fetch_array($ptr_name);
					
					
					$service_price +=$data_service['service_price'];
					$discount_price +=$data_service['discount_price'];
					$total_time +=$data_service['service_time'];
					$total_price +=$data_service['total_price'];
					
					'<br/>'.$total_discount_price =$total_discount_price+$tot_dis_price;
					 
					$amount=$amount+$data_inventoty['sin_product_total'];
					
					echo '<tr>';
						echo '<td align="center"><span style="font-size:12px;font-weight:bold">'.$data_name['service_name'].'</span></td>';
						echo '<td align="center"><span style="font-size:12px;font-weight:bold">'.round($data_service['service_price'],2).'</span></td>';
						echo '<td align="center"><span style="font-size:12px;font-weight:bold">'.$data_service['discount']."  ".$type.'</span></td>';
						echo '<td align="center"><span style="font-size:12px;font-weight:bold">'.round($data_service['discount_price'],2).'</span></td>';
						echo '<td align="center"><span style="font-size:12px;font-weight:bold">'.round($data_service['total_price'],2).'</span></td>';
					echo '</tr>';
				   }
				?>  
                <?php
				$slect_sum_qty="SELECT SUM(`sin_product_qty`) as qty FROM `inventory_product_map` WHERE `inventory_id`='".$record_id."' ";
				$query_tot_qty=mysql_query($slect_sum_qty);
				$fetch_tot_qty=mysql_fetch_array($query_tot_qty);
				?>          	
                  <tr bgcolor="#EFEFEF">
                      <td  align="center"><span style="font-size:16px; font-weight:bold">Total</span></td>
                      <td width="19%" align="center"><span style="font-size:16px; font-weight:bold"><?php echo round($service_price,2); ?></span></td>
                      <td align="right" align="center" colspan="2"><span style="font-size:16px; font-weight:bold"><?php echo round($discount_price,2); ?></span></td>
                      <td width="41%" align="center"><span style="font-size:16px; font-weight:bold"><?php echo round($total_price,2);?></span></td>
                  </tr> 
                  <tr>
                  		<!--<td colspan="4" rowspan="4"><span style="font-size:16px;"><strong>Bill Amounts in words:  </strong><?php //echo convert_number($data_record['total_cost']) ?></span></td>-->
                        <td colspan="4" align="center" ><span style="font-size:16px; font-weight:bold""><?php if($membership=="yes"){ echo "Membership Discounted Price:   "; } ?></span></td>
                  		<td align="center"><span style="font-size:16px; font-weight:bold"><?php if($membership=="yes"){ echo "".round($data_record['discount_price'],2).""; } ?></span></td>
                  </tr> 
				  <?php
				  if($data_record['category']!='')
				  {
				  ?>
				  <tr>
                  		<td colspan="4" align="center"><span style="font-size:16px; font-weight:bold">Others Disc: <?php echo $data_record['category']; ?></span></td>
                  		<td  align="center" ><span style="font-size:16px; font-weight:bold"><?php if($data_record['category'] =="loyalty_point") echo $data_record['redemptoin_value'];?></span></td>
                  		<!--<td align="center"><span style="font-size:16px; font-weight:bold"><?php //echo $tot_bill_amount?></span></td>-->
                  </tr> 
				  
				  <?php
				  }
				  ?>
                  <?php
				  if($data_record['nonmemb_discount'] >0)
				  {
				  ?>
                  <tr>
                  		 <td colspan="4" align="center"><span style="font-size:16px; font-weight:bold">Non-member Discount(<?php echo  $data_record['nonmemb_discount']." ".$data_record['nonmemb_discount_type'];?>):</span></td>
                 	 	<td  align="center"><span style="font-size:16px; font-weight:bold"><?php echo  round($data_record['nonmemb_discount_price'],2);?></span></td>
                  </tr> 
                	<?php 
				}
				/*if($data_record['service_tax'] >0)
				{
					  ?>
					  <tr>
                        <td colspan="4"  align="center"><span style="font-size:16px; font-weight:bold">Service Tax:</span></td>
                        <td  align="center"><span style="font-size:16px;"><?php echo round($data_record['service_tax'],2);?></span></td>
					  </tr> 
					  <?php
				}*/
				if($data_record['gst_type']=='m_igst')
				{
						?>
					<tr>
						<td colspan="4"  align="left"><span style="font-size:14px; font-weight:bold; padding:2px">IGST(<?php echo $data_record['igst_tax_in_percent']; ?>%)</td>
						<td  align="center"><span style="font-size:14px; font-weight:bold"><?php echo $data_record['igst_tax'];?></td>
					</tr> 
                	<?php
				}
				else
				{
					if($data_record['cgst_tax'] >0 || $data_record['sgst_tax'] >0)
					{
						?>
						<tr>
							<td colspan="4"  align="left"><span style="font-size:14px; font-weight:bold; padding:2px">CGST(<?php echo $data_record['cgst_tax_in_percent']; ?>%)</span></td>
							<td  align="center"><span style="font-size:14px; font-weight:bold"><?php echo round($data_record['cgst_tax'],2); ?></span></td>
						</tr> 
						<tr>
							<td colspan="4"  align="left"><span style="font-size:14px; font-weight:bold; padding:2px">SGST(<?php echo $data_record['sgst_tax_in_percent']; ?>%)</span></td>
							<td  align="center"><span style="font-size:14px; font-weight:bold"><?php echo round($data_record['sgst_tax'],2); ?></span></td>
						</tr> 
						<tr>
							<td colspan="4" align="left"><span style="font-size:14px; font-weight:bold; padding:2px">Total GST</span></td>
							<td  align="center"><span style="font-size:14px; font-weight:bold"><?php echo round($data_record['cgst_tax'],2) + round($data_record['sgst_tax'],2);?></span></td>
						</tr>
						<?php
				  	}
				}
				?>
                  <tr>
                  		<td colspan="4" align="left"><span style="font-size:14px; font-weight:bold; padding:2px">Total Amount:</span></td>
                  		<td  align="center" ><span style="font-size:14px; font-weight:bold"><?php echo round($data_record['amount'],2);?> /-</span></td>
                  		<!--<td align="center"><span style="font-size:16px; font-weight:bold"><?php //echo $tot_bill_amount?></span></td>-->
                  </tr>
                  <tr>
                  		<td colspan="4" align="left"><span style="font-size:14px; font-weight:bold; padding:2px">Paid Amount:</span></td>
                  		<td  align="center" ><span style="font-size:14px; font-weight:bold"><?php echo round($data_record['payable_amount'],2);?> /-</span></td>
                  		<!--<td align="center"><span style="font-size:16px; font-weight:bold"><?php //echo $tot_bill_amount?></span></td>-->
                  </tr>  
                  <tr>
                  		<td colspan="4" align="left"><span style="font-size:14px; font-weight:bold; padding:2px">Remaining Amount:</span></td>
                  		<td  align="center" ><span style="font-size:14px; font-weight:bold"><?php echo round($data_record['remaining_amount'],2);?> /-</span></td>
                  		<!--<td align="center"><span style="font-size:16px; font-weight:bold"><?php //echo $tot_bill_amount?></span></td>-->
                  </tr>  
                 
                  <tr>
                      <!--<td colspan="4"><span style="font-size:12px;"><b>* I/We here by certify that my/our registration certificate center under : -</b><br/>
                      The Maharashtra Value Added Tax Act, 2002 is in force in the date on which the sale of goods specified in this TAX INVOICE is made by me/us & that transaction of sale covered by this Tax Invoice has been effected by me/us & it shall be accounted for in the turnover of sales while filling of return & the due tax, if any, payable on the sale has been paid or shall be paid.<br/><br/>
                      
                      TIN NO : 567898777<br/>
                      CST TIN NO : 56788977<br/>
                      LBT NO : <?php //echo $data_vendor['lbt_no']?><br/><br/>
                      <b>Delivered by</b>  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Received by</b></span></td>-->
                      <td colspan="4">
                      	<table width="100%">
                      		<tr>
                            	<span ><td width="54%" style="font-size:14px;" align="center"><b>Payment Type:</b></td><td width="46%" style="font-size:16px;"><?php echo $payment_mode; ?></td></span>
                            </tr>
                            <?php if($data_record['payment_mode_id'] =="2" ||$data_record['payment_mode_id'] =="3" ||$data_record['payment_mode_id'] =="4"){?>
                            <tr>
                            	<span ><td style="font-size:16px;" align="center"><b>Cust. Bank Name</b></td><td style="font-size:16px;"><?php echo $cust_bank_name; ?></td></span>
                            </tr>
                            <!--<tr>
                            	<span ><td style="font-size:16px;" align="center"><b>Account No.:</b></td><td style="font-size:16px;"><?php echo $account_no; ?></td></span>
                            </tr>-->
                            <?php }?>
                            <?php if($data_record['payment_mode_id'] =="2" ){
								
								$sep=explode("/",$data_record['chaque_date']);
								$date=$sep[0]."-".$sep[1]."-".$sep[2];
								?>
                            <tr>
                            	<span ><td style="font-size:16px;" align="center"><b>Chaque No:</b></td><td style="font-size:16px;"><?php echo $data_record['chaque_no']; ?></td></span>
                            </tr>
                            <tr>
                            	<span ><td style="font-size:16px;" align="center"><b>Chaque Date:</b></td><td style="font-size:16px;"><?php echo $date; ?></td></span>
                            </tr>
                            <?php }?>
                             <?php if($data_record['payment_mode_id'] =="4" ){?>
                            <tr>
                            	<span ><td style="font-size:16px;" align="center"><b>Credit Card No:</b></td><td style="font-size:16px;"><?php echo $data_record['credit_card_no']; ?></td></span>
                            </tr>
                            <?php } ?>
                            <?php if($data_record['payment_mode_id'] =="6" ){?>
                            <tr>
                            	<span ><td style="font-size:16px;" align="center"><b>Voucher No:</b></td><td style="font-size:16px;"><?php echo $data_record['voucher_number']; ?></td></span>
                            </tr>
                            <?php } ?>
                      	</table>
                      </td>
                  </tr> 
                  <tr height="70px" valign="bottom">
                  <td colspan="5" align="center"><span style="font-size:12px;float:left; font-weight:700">Isas authorisd signature</span> <span style="font-size:12px;float:right;font-weight:700">Customer signature</span></td>
                  </tr>  
                  <!--<tr bgcolor="#EFEFEF">
                  <td colspan="5" align="center"><span style="font-size:16px;"><?php //echo $data_vendor['contact_address'] ?></span></td>
                  </tr>   -->
                  
                  <!--<tr bgcolor="#EFEFEF">
                  <td colspan="2" align="center"><span style="font-size:16px;">Tel : <?php //echo $data_vendor['contact_phone'] ?></span></td>
                  <td colspan="3" align="center"><span style="font-size:16px;">Email : <?php //echo $data_vendor['email'] ?></span></td>
                  </tr>      -->
           
</table>
      </td></tr>
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
