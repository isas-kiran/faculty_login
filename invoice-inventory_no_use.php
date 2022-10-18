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
	.left_border{ border-left:solid #999 1px; }
	.right_border{ border-right:solid #999 1px;}
	.right_border1{ border-right:solid #EFEFEF  1px;}
	.top_border{ border-top:solid #999 1px;}
	.bottom_border{ border-bottom:solid #999 1px;}
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

?>
                        <?php
                        $record_id =$_GET['record_id'];
						$sql_records= "SELECT * from inventory where inventory_id ='".$record_id."'";
						$ptr_exsist =$db->query($sql_records);
						$data_bill_master=mysql_fetch_array($ptr_exsist);
						
						
						$sql_vendor= "SELECT name,email,contact,address,tax_no,gst_no from vendor where vendor_id ='".$data_bill_master['vendor_id']."'";
						$ptr_vendor =mysql_query($sql_vendor);
						$data_vendor=mysql_fetch_array($ptr_vendor);
						
						
						$sel_pay_mode="select payment_mode from payment_mode where payment_mode_id='".$data_bill_master['paid_type']."'";
						$ptr_sel_mode=mysql_query($sel_pay_mode);
						$fetch_pay_mode=mysql_fetch_array($ptr_sel_mode);
						
						$payment_mode=$fetch_pay_mode['payment_mode'];
						
						$sel_bank="select bank_name,account_no from bank where bank_id='".$data_bill_master['bank_id']."'";
						$ptr_bank=mysql_query($sel_bank);
						$data_bank=mysql_fetch_array($ptr_bank);
						
						$bank_name=$data_bank['bank_name'];
						$account_no=$data_bank['account_no'];
						?>
                            
<table align="center" border="1px"  width="786" style="border-left:solid #999 1px; border-right:solid #999 1px; border-top:solid #999 1px;border-radius:5px; border-collapse:collapse">
                        <tr>
                            <td valign="top" width="390" rowspan=2><img src="http://isasbeautyschool.com/wp-content/uploads/2015/04/logo.jpg"   title="Isasbeautyschool "/></td>
                            <td width="195" align="left" style="padding-left:10px; font-size:12px">Invoice No : <?php echo $data_bill_master['invoice_no'] ?><br/>
                                                              Date : <?php
															  
															  $added_date=explode(' ',$data_bill_master['added_date'],3);
																 '<br/>'.$exxxxx=$added_date[0];
																
																$sep=explode('-', $exxxxx);
																
																 $sep_added_date=$sep[2].'-'.$sep[1].'-'.$sep[0];
								 
															   echo $sep_added_date ?></td>
                            
                            <td width="195" align="right"> 
							<?php
								 if($_GET['action'] !='print')
								 {
								 ?>
								<a href="invoice-inventory.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
								<?php } ?>
                           </td>
                        
                        </tr>
                        
                        <tr><td width="390" align="center" colspan="2"><img src="images/barcode.png" height="50px" width="100px"/></td></tr>
                        
                        
                        <tr height="5">
                        
                        </tr></table>

               <table align="center" border="1px"  width="786" style="border-left:solid #999 1px; border-right:solid #999 1px; border-top:solid #999 1px;border-radius:5px; border-collapse:collapse" cellpadding="5" cellspacing="5">
                     <tr>
                     <td style="font-size:12px; padding-left:7px; vertical-align:top" >
                     <strong>Vendor Address:</strong>
                     <br/><br/>
                     <table >
                      <?php 
						$sql_inv= "SELECT vendor_id from inventory where inventory_id ='".$record_id."'";
				   		$ptr_inv=mysql_query($sql_inv);
						$data_inv=mysql_fetch_array($ptr_inv);
						
						$select_ven="select * from vendor where vendor_id='".$data_inv['vendor_id']."'";
						$ptr_vendors=mysql_query($select_ven);
						$data_vendors=mysql_fetch_array($ptr_vendors);
						
						echo $data_vendors['address'];
					   
						?>
                   </table>
                     
                     </td>
                     
                     <td style="font-size:12px;padding-left:7px">
                     <strong>Delivery Address:</strong>
                     <table >
                      <?php 
					   if($_SESSION['type']=='S')
					   {
						   $sele_cm_id="select branch_name from site_setting where cm_id=".$data_bill_master['cm_id']."";
						   $ptr_cm_id=mysql_query($sele_cm_id);
						   $data_cm_id=mysql_fetch_array($ptr_cm_id);
						   
						   $select_branch_address="select branch_address from branch where branch_name='".$data_cm_id['branch_name']."'";
						   $pte_branch_name=mysql_query($select_branch_address);
						   $data_branch_name=mysql_fetch_array($pte_branch_name);
						   
						  $replace= str_replace("International School of Aesthetics and Spa","Frespa Consultancy",$data_branch_name['branch_address']);
						   
						   echo $replace;
						}
						else
						{
							$replace1= str_replace("International School of Aesthetics and Spa","Frespa Consultancy",$_SESSION['branch_address']);
							echo $replace1;
						}
						?>
        			</table>
                </td>
            	</tr>                   
                <tr height="5"></tr>
                <tr height="5">
                    <td colspan="2">
                        <table width="100%">
                            <tr>
                                <td width="28%" align="center"><span style="font-size:12px; font-weight:bold">Vendor Name</span></td>
                                <td width="72%" align="center"><span style="font-size:12px; font-weight:bold"><?php echo $data_vendors['name']; ?></span></td>
                            </tr>
                            <tr>
                                <td width="28%" align="center"><span style="font-size:12px; font-weight:bold">Mobile no.</span></td>
                                <td width="72%" align="center"><span style="font-size:12px; font-weight:bold"><?php echo $data_vendors['contact']; ?></span></td>
                            </tr>
                            <tr>
                                <td width="28%" align="center"><span style="font-size:12px; font-weight:bold">Email ID</span></td>
                                <td width="72%" align="center"><span style="font-size:12px; font-weight:bold"><?php echo $data_vendors['email']; ?></span></td>
                            </tr>
                            <?php
							if($data_vendors['gst_no'] !='')
							{
							?>
                            <tr>
                                <td width="28%" align="center"><span style="font-size:12px; font-weight:bold">GST no.</span></td>
                                <td width="72%" align="center"><span style="font-size:12px; font-weight:bold"><?php echo $data_vendors['gst_no']; ?></span></td>
                            </tr>
                            <?php
							}
							?>
                        </table>
                    </td>
                    </tr>
            </table>
            <table align="center" border="1px"  width="786" cellpadding="5" cellspacing="2"  style=" border:1px solid; border-collapse:collapse" >
            	<tr bgcolor="#EFEFEF">
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Product Name</span></td>
                    <!--<td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Code</span></td>
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Brand</span></td>
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Description</span></td>-->
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Size</span></td>
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Qty</span></td>
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Rate</span></td>
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Total Price</span></td>
                     <?php if($data_bill_master['discount_type']=="percentage") {$type="%";} else if($data_bill_master['discount_type']=="rupees") {$type="Rs/-";}?>
                    <td width="10%" align="center" colspan="2"><span style="font-size:12px; font-weight:bold">Discount (in <?php echo $type; ?>)</span></td>
					<td width="5%" align="center"><span style="font-size:12px; font-weight:bold">CGST</span></td>
					<td width="5%" align="center"><span style="font-size:12px; font-weight:bold">SGST</span></td>
					<td width="5%" align="center"><span style="font-size:12px; font-weight:bold">IGST</span></td>
                    <td width="5%" align="center"><span style="font-size:12px; font-weight:bold">Amt</span></td>
               </tr>       
                <?php
				$total_qty_price='';
				$total_rate='';
				$total_add_price='';
				$tot_dis_price='';
				$amount='';
				$sql_inventory= "SELECT * from inventory_product_map where inventory_id ='".$record_id."'";
				$ptr_inventory =mysql_query($sql_inventory);
				while($data_inventoty=mysql_fetch_array($ptr_inventory))
				{		  
				   	"<br>". $select_product="select product_name,product_code,brand,description,size,price from product where product_id='".$data_inventoty['product_id']."' ";
					$query_product=mysql_query($select_product);
					$data_product=mysql_fetch_array($query_product);
					$amount=$amount+$data_inventoty['sin_product_total'];			 
					$total_qty_price=$data_inventoty['sin_product_price']*$data_inventoty['sin_product_qty'];
					$total_rate=$total_rate+$data_inventoty['sin_product_price'];
					$total_add_price=$total_add_price+$total_qty_price;
					$cgst_tax +=$data_inventoty['cgst_tax'];
					$sgst_tax +=$data_inventoty['sgst_tax'];
					$igst_tax +=$data_inventoty['igst_tax'];
					$tot_dis_price=$total_qty_price * ($data_inventoty['sin_product_disc']/100); 
					$total_discount_price =$total_discount_price+$tot_dis_price;
					echo '<tr>';
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_product['product_name'].'</span></td>';
						
						//echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_product['product_code'].'</span></td>';
						
						//echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_product['brand'].'</span></td>';
						
						//echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_product['description'].'</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_product['size'].'</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_inventoty['sin_product_qty'].'</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_inventoty['sin_product_price'].'</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$total_qty_price.'</span></td>';
						
						echo '<td width="5%" align="center" ><span style="font-size:10px;">'.$data_inventoty['sin_product_disc'].'</span></td>
						<td width="5%" align="center"><span style="font-size:10px;">'.$tot_dis_price.'</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_inventoty['cgst_tax_in_per'].'% <br/>'.$data_inventoty['cgst_tax'].'-/</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_inventoty['sgst_tax_in_per'].'% <br/>'.$data_inventoty['sgst_tax'].'-/</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_inventoty['igst_tax_in_per'].'% <br/>'.$data_inventoty['igst_tax'].'-/</span></td>';
						
						echo '<td width="5%" align="center"><span style="font-size:10px;">'.$data_inventoty['sin_product_total'].'</span></td>';
					echo '</tr>';
				   }
				?>  
                <?php
				$slect_sum_qty="SELECT SUM(`sin_product_qty`) as qty FROM `inventory_product_map` WHERE `inventory_id`='".$record_id."' ";
				$query_tot_qty=mysql_query($slect_sum_qty);
				$fetch_tot_qty=mysql_fetch_array($query_tot_qty);
				?>          	
                  <tr bgcolor="#EFEFEF">
                      <td colspan="2" align="center"><span style="font-size:12px; font-weight:bold">Total</span></td>
                      <td align="center"><span style="font-size:12px; font-weight:bold"><?php echo $fetch_tot_qty['qty'] ?></span></td>
                      <td align="center"><span style="font-size:12px; font-weight:bold"><?php echo $total_rate ?></span></td>
                      <td align="center"><span style="font-size:12px; font-weight:bold"><?php echo $total_add_price ?></span></td>
                      <td colspan="2" align="right"><span style="font-size:12px; font-weight:bold"><?php echo $total_discount_price ?></span></td>
					  <td colspan="" align="right"><span style="font-size:12px; font-weight:bold"><?php echo $cgst_tax; ?></span></td>
					  <td colspan="" align="right"><span style="font-size:12px; font-weight:bold"><?php echo $sgst_tax; ?></span></td>
					  <td colspan="" align="right"><span style="font-size:12px; font-weight:bold"><?php echo $igst_tax; ?></span></td>
                      <td align="center"><span style="font-size:12px; font-weight:bold"><?php echo $amount;?></span></td>
                  </tr> 
                  
                  <tr>
                  <td colspan="8" rowspan="2"><span style="font-size:12px;"><strong>Bill Amounts in words:</strong>&nbsp;<?php echo convert_number($data_bill_master['amount1']) ?></span></td>
                  <?php
				  $select_tax="select tax_type,tax_value,tax_amount,inventory_id from inventory_tax_map where inventory_id='".$record_id."'";
				  $query_tax=mysql_query($select_tax);
				  
				  ?>
                  <td colspan="3" ><span style="font-size:12px;">
                  <?php 
				  echo 'Discount : '.$data_bill_master['discount'].'&emsp;&emsp;=>&emsp;&emsp;'.$data_bill_master['total_cost'].'<br/><br/>';
				  while($fetch_tax=mysql_fetch_array($query_tax))
				  {
					  $tax_amount=($data_bill_master['total_cost'] * $fetch_tax['tax_value'])/100; 
					  
					  echo $fetch_tax['tax_type'].':&emsp;&emsp; '.$fetch_tax['tax_value'].'&emsp;&emsp;=>&emsp;&emsp; '.$tax_amount.'<br/><br/>';
					   $tot=$tot + $fetch_tax['tax_amount'];
				  }
				    $tot_bill_amount=$tot+$amount;
				  ?>
                  
                  </span></td>
                  <!--<td ><span style="font-size:12px;"></span></td>
-->                  </tr> 
                  
                  <!--<tr>
                  <td colspan="3"><span style="font-size:12px;">Adjustment(+/-)</span></td>
                  
                  </tr>--> 
                  
                  <tr>
                  <td colspan="3" align="left">
                  <span style="font-size:12px; font-weight:bold">Bill Amount : <?php echo $data_bill_master['amount1']?> /-</span><br/>
                 <?php
				    $tot_paid_amount="SELECT SUM( payable_amount ) as payable_amount FROM `inventory_invoice` WHERE inventory_id=".$record_id."";
					$query_sum=mysql_query($tot_paid_amount);
					$fetch_sum=mysql_fetch_array($query_sum);
				  ?>
                  <span style="font-size:12px; font-weight:bold">Paid Amount : <?php echo $fetch_sum['payable_amount']?> /-</span><br/>
                  <span style="font-size:12px; font-weight:bold">Remaining Amount : <?php echo $data_bill_master['remaining_amount']?> /-</span>
                  </td>
                 
                  </tr>  
                  
                  <tr>
                      <td colspan="8"><span style="font-size:10px;"><b>* I/We here by certify that my/our registration certificate center under : -</b><br/>
                      The Maharashtra Value Added Tax Act, 2002 is in force in the date on which the sale of goods specified in this TAX INVOICE is made by me/us & that transaction of sale covered by this Tax Invoice has been effected by me/us & it shall be accounted for in the turnover of sales while filling of return & the due tax, if any, payable on the sale has been paid or shall be paid.<br/><br/>
                      
                      TIN NO : 567898777<br/>
                      CST TIN NO : 56788977<br/>
                      LBT NO : <?php echo $data_vendor['lbt_no']?><br/><br/>
                      <b>Delivered by</b>  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Received by</b></span></td>
                      <td colspan="3">
                      <table width="100%">
                      		<tr>
                            	<span ><td width="54%" style="font-size:12px;"><b>Payment Type:</b></td><td width="46%" style="font-size:12px;"><?php echo $payment_mode; ?></td></span>
                            </tr>
                            <?php if($data_bill_master['payment_mode_id'] =="2" ||$data_bill_master['payment_mode_id'] =="3" ||$data_bill_master['payment_mode_id'] =="4"){?>
                            <tr>
                            	<span ><td style="font-size:12px;"><b>Bank Name</b></td><td style="font-size:12px;"><?php echo $bank_name; ?></td></span>
                            </tr>
                            <tr>
                            	<span ><td style="font-size:12px;"><b>Account No.:</b></td><td style="font-size:12px;"><?php echo $account_no; ?></td></span>
                            </tr>
                            <?php }?>
                            <?php if($data_bill_master['payment_mode_id'] =="2" ){
								
								$sep=explode("/",$data_bill_master['chaque_date']);
								$date=$sep[1]."-".$sep[0]."-".$sep[2];
								?>
                            <tr>
                            	<span ><td style="font-size:12px;"><b>Chaque No:</b></td><td style="font-size:12px;"><?php echo $data_bill_master['chaque_no']; ?></td></span>
                            </tr>
                            <tr>
                            	<span ><td style="font-size:12px;"><b>Chaque Date:</b></td><td style="font-size:12px;"><?php echo $date; ?></td></span>
                            </tr>
                            <?php }?>
                             <?php if($data_bill_master['payment_mode_id'] =="4" ){?>
                            <tr>
                            	<span ><td style="font-size:12px;"><b>Credit Card No:</b></td><td style="font-size:12px;"><?php echo $data_bill_master['credit_card_no']; ?></td></span>
                            </tr>
                            <?php } ?>
                      	</table>
                      </td>
                  </tr> 
                  
                  <tr bgcolor="#EFEFEF">
                  <td colspan="11" align="center"><span style="font-size:12px;"><?php echo $data_vendor['address'] ?></span></td>
                  </tr>   
                  
                  <tr bgcolor="#EFEFEF">
                  <td colspan="5" align="center"><span style="font-size:12px;">Tel : <?php echo $data_vendor['contact'] ?></span></td>
                  <td colspan="6" align="center"><span style="font-size:12px;">Email : <?php echo $data_vendor['email'] ?></span></td>
                  </tr>      
           </tr>
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
