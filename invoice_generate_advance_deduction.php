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
                           
						  $sql_records= "SELECT * from pr_staff_advance_invoice where invoice_id ='".$record_id."'";
						  $ptr_exsist =mysql_query($sql_records);
						  $data_bill_master=mysql_fetch_array($ptr_exsist);
						  
						 $invoice_no=$data_bill_master['invoice_id'];
							
						$amount_paid=$data_bill_master['amount'];
						$bank_name=$data_bill_master['bank_name'];
						$cheque_detail=$data_bill_master['cheque_detail'];
						$chaque_date=$data_bill_master['chaque_date'];					
					
						$select_customer = " select * from site_setting where attendence_id='".$data_bill_master['staff_id']."' ";
						$ptr_customer=mysql_query($select_customer);
						$data_customer = mysql_fetch_array($ptr_customer);
						 //=============================================================
						 	 $sql_records_invoice= "SELECT * FROM `customer_service_invoice` WHERE customer_service_id='".$data_bill_master['customer_service_id']."' and (invoice_id < ".$record_id.") order by invoice_id desc limit 1";
							 
							
							$ptr_exsist_invoice =$db->query($sql_records_invoice);
							$data_last_invoice_id=mysql_fetch_array($ptr_exsist_invoice);
						 //=================================================================
						
							?>
<table align="center" border="0" width="450" style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-top:solid 0.6mm;border-top-radius:5px;">
                        <tr>
                        <td valign="top" width="185"><img src="images/logo.jpg" width="180" height="60"  title="Isasbeautyschool "/></td>
						<td></td>
						</tr>
						<tr>
                        <td width="601" align="right" style="padding-right:15px;" colspan="2"><table width="99%">
       
        <?php 
					   if($_SESSION['type']=='S')
					   {
						   $sele_cm_id="select branch_name from site_setting where cm_id=".$data_bill_master['cm_id']."";
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
        <a href="invoice_generate_advance_deduction.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
        <?php } ?>
        
        </td>
                        </tr>
                        <tr height="5">
                        
                        </tr></table>

                         
                        
                        <table align="center" border="1px"  width="450" cellpadding="0" cellspacing="0"
                                        bgcolor="#EFEFEF" style=" border:1px solid;" >
                                        <tr>
                            	
                          </tr>
                                        </table>
                        
                        
                        </td></tr>
                                              
                                              </table>
                                              <table align="center" border="0" width="450" cellpadding="0" style="border-left:solid 0.6mm; border-right:solid 0.6mm; ">
                                              <tr>
                                              	<td></td><td></td>
                                              </tr>
                                              
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px; font-size:16px;" > <strong>Staff Name :</strong></td>
                                                <td width="" height="10" style="font-size:16px;"> <strong><?php echo $data_customer['name']; ?></strong> </td>
                                              </td>
                                              	<td width="" rowspan="3" align="center" valign="middle" style="font-weight:bold;">
                                                <?php 
													if($data_bill_master['status']=='paid' && $data_bill_master['payable_amount']!='')
													{
														?>
														<font style="font-size:20px; color:#99CC00">PAID</font>
														<?php
                                                    }
													elseif($data_bill_master['status']=='Aborted')
													{
														?>
														<font style="font-size:20px; color:#FFFF00">ABORTED</font>
														<?php
													}
													else
													{
														?>
														<font style="font-size:20px; color:#FF0000"><?php echo strtoupper($data_bill_master['status']); ?></font>
                                                        <?php
													}
												?>
                                                
                                              
                                              </tr>
                                              <tr><td width="" height="10" style="padding-left:20px; font-size:16px;" ><strong>Invoice No :</strong> <strong><?php echo $invoice_no; ?></strong></font></h3></td></tr>
											 
                                              <tr><td colspan="4"> <h3 align="center"><font size="+1">Advance Details</font></h3></td></tr>
                                              </table>
                                            
										<table align="center" border="1px " width="450" cellpadding="5" cellspacing="5"
                                        bgcolor="#EFEFEF" style="border-left:solid 0.6mm; border-right:solid 0.6mm; border-collapse:collapse " >
                                        
                             <tr>
                          		<td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Total Price</span></td>
                           		<td width="26%" width:20% align="center"><font size="4px;"><?php echo $data_bill_master['amount']; ?></font></td>
                                
                            </tr>
                            
                            <tr>
                           
                          		<td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Total Paid Amount</span></td>
                           		<td width="26%" width:20% align="center"><font size="4px;"><?php echo $data_bill_master['total_paid']; ?></font></td>
                            </tr>
                            
                            <tr>
                          		<td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Deposit Amount</span></td>
                           		<td width="26%" width:20% align="center"><font size="4px;"><?php echo $data_bill_master['payable_amount']; ?></font></td>
                            </tr>
                            
                            <tr>
                          		<td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:16px; font-weight:bold">Remaining Amount</span></td>
                           		<td width="26%" width:20% align="center"><font size="4px;"><?php echo $data_bill_master['remaining_amount']; ?></font></td>
                            </tr>
                               
                  
            </table>
            <table align="center" border="0" width="450" cellpadding="0" style="border-left:solid 0.6mm; border-right:solid 0.6mm; ">
            <tr height="20px">
            	<td colspan="4" style="padding-left:20px; font-size:16px; font-weight:bold"> <span> Deposit Amount In Words -: <?php echo convert_number($data_bill_master['payable_amount']) ?> Only</span></td><td></td>
            </tr>
            </table>
            <table align="center" border="0" width="450" cellpadding="0" style="border-left:solid 0.6mm; border-right:solid 0.6mm; ">
            <tr><td colspan="4"> <h3 align="center"><font size="+1">Payment Details</font></h3></td></tr></table>
           
            
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
                                              
                           <?php }?>
                           
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
                                               <?php }?>
     <tr><td width="190" class="heading"  style="padding-left:20px; font-size:16px;">Total Amount Paid:</td><td width="242" height="10" style=" font-size:16px;" ><strong><?php echo $data_bill_master['payable_amount']; ?></strong> </td> </tr>  </table>                                        
            			
                        <table align="center" border="0" width="450" cellpadding="0"  style="border-left:solid 0.6mm; border-right:solid 0.6mm;  border-bottom:solid 0.6mm;">
                        <tr height="20px"><td colspan="2"></td></tr>
                        <tr><td width="395" align="left"><b><font size="-1">ISAS Authorised Signature(With Seal)</font></b></td>
                        <td width="383" align="right"><b><font size="-1">Staff Signature</font></b></td></tr>
                         
                         
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
