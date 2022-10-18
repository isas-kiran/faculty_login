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
						/*$sql_pages= "select content from dd_pages where page_id='1' ";
						$ptr_contents = mysql_query($sql_pages);
						$data_pages = mysql_fetch_array($ptr_contents);
						$addresss = stripslashes($data_pages['content']);*/
                          $record_id =$_GET['record_id'];
                           
						  $sql_records= "SELECT* from invoice where  invoice_id ='".$record_id."'";
							 // order by year(added_date) desc,month(added_date) desc,day(added_date) asc";
                            //echo $sql_records;
						$ptr_exsist =$db->query($sql_records);
						$data_bill_master=mysql_fetch_array($ptr_exsist);
						 $invoice_no=$data_bill_master['invoice_id'];
						$added_date=$data_bill_master['added_date'];
						$enroll_id=$data_bill_master['enroll_id'];
						$balance_amt=$data_bill_master['balance_amt'];
						$amount=$data_bill_master['amount'];
						//============================= installment_display_id===================
						$sel_installment_display_id="select installment_display_id from enrollment where enroll_id='$enroll_id'";
						$ptr_sel=mysql_query($sel_installment_display_id);
						$data_sel=mysql_fetch_array($ptr_sel);
						$installment_display_id=$data_sel['installment_display_id'];
						//========================================================================			
						$amount_paid=$data_bill_master['amount'];
						$bank_name=$data_bill_master['bank_name'];
						$cheque_detail=$data_bill_master['cheque_detail'];
						$chaque_date=$data_bill_master['chaque_date'];					
						
						 $course_id=$data_bill_master['course_id'];
						//echo $data_bill_master['course_id'];
						 $select_course = "select * from courses where course_id = '".$course_id."' ";
                         $val_course= $db->fetch_array($db->query($select_course));
						 
						 
						  	$sql_record= "SELECT * FROM enrollment where enroll_id='".$enroll_id."'";
							$_SESSION['sql_articles']=$sql_record;
							if(mysql_num_rows($db->query($sql_record)))
							$row_record=$db->fetch_array($db->query($sql_record));
						      $row_record['no_of_installment'];
							$invoice= $row_record['invoice_no'];
							 $enroll=$row_record['enroll_id'];
						
						
					    	$totsss=$val_selectedpaid['amount_paid'];
							 $date_time=$val_selectedpaid['date_time'];
						    $totsss_avail=$amount_tot-$totsss;
						    $bill_totals=$amount_paid+$totsss;
						 //=============================================================
						 	 $sql_records_invoice= "SELECT * FROM `invoice` WHERE `enroll_id`='".$enroll_id."' and (invoice_id < ".$record_id.") order by invoice_id desc limit 1";
							 
							 // order by year(added_date) desc,month(added_date) desc,day(added_date) asc";
                            //echo $sql_records;
							$ptr_exsist_invoice =$db->query($sql_records_invoice);
							$data_last_invoice_id=mysql_fetch_array($ptr_exsist_invoice);
						 //=================================================================
						//$last_recpt_no=" SELECT * FROM `invoice`  ORDER BY `invoice_id` DESC LIMIT 0,1 "; /*where  invoice_id ='".$invoice."'*/
						 //echo $last_recpt_no= "SELECT* from enrollment  where  invoice_no ='".$invoice_no."'";
						  
						 //$last =$db->query($last_recpt_no);
						  //$last_bill=mysql_fetch_array($last); 
						 //echo $enroll=$last_bill['enroll_id'];
						  
						  //$no_of_records=mysql_num_rows($db->query($last_recpt_no));
                           
						   //echo $no_of_records['invoice_id'];
						  
						//echo $last_bill['invoice_id'];
							?>
<table align="center" border="0" width="786" style="border-left:solid #999 1px; border-right:solid #999 1px; border-top:solid #999 1px;border-radius:5px;">
                        <tr>
                        <td valign="top" width="185"><img src="http://isasbeautyschool.com/wp-content/uploads/2015/04/logo.jpg"   title="Isasbeautyschool "/></td>
                        <td width="601" align="right" style="padding-right:15px;"><table width="99%">
       <?php 
	   if($_SESSION['type']=='S')
	   {
		   $sele_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']."";
		   $ptr_cm_id=mysql_query($sele_cm_id);
		   $data_cm_id=mysql_fetch_array($ptr_cm_id);
		   
		   $select_branch_address="select branch_address from branch where branch_name='".$data_cm_id['branch_name']."'";
		   $pte_branch_name=mysql_query($select_branch_address);
		   $data_branch_name=mysql_fetch_array($pte_branch_name);
		   
		   echo $data_branch_name['branch_address'];
		}
		else
		{
	   		echo $_SESSION['branch_address'];
        }
		?>
        </table>
        <td valign="top">
        <?php
		 if($_GET['action'] !='print' && $_GET['for']!='email')
		 {
		 ?>
        <a href="invoice-generate.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
        <?php } ?>
        </td>
        </td>
                        </tr>
                        <tr height="5">
                        
                        </tr></table>

                         <!--<table align="center" width="786"  cellpadding="0" cellspacing="0"
                                        bgcolor="#EFEFEF" style=" border-right:1px solid; border-left: 1px solid;" >
                                   <tr>
                                   <td width="21%"></td>
                                   <td width="27%"></td>
                                   <td width="22%"></td>
                                
                                   <td width="30%" align="center" bgcolor="#000000"><h2 style="color:white">RECEIPT </h2></td></tr>   
                         </table>-->
                        
                        <table align="center" border="1px"  width="786" cellpadding="0" cellspacing="0"
                                        bgcolor="#EFEFEF" style=" border:1px solid;" >
                                        
                        	
                            
                            
                        	<tr>
                            	<td width="21%" align="left"  style="padding-left:10px; width:20%"><span style="font-size:15px; font-weight:bold">Receipt No.</span></td><td width="20%" width:20% align="center"><font size="2px;"><?php echo $invoice_no;?></font></td>
                                <td width="24%" align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Service Tax No.</span></td><td width="29%" width:20% align="center"><font size="2px;">AADFI5575RSD001</font> </td>
                          </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:15px; font-weight:bold">Last Receipt No.</span></td><td width:20% align="center"><?php if($data_last_invoice_id['invoice_id']) echo $data_last_invoice_id['invoice_id']; else echo '#'; ?></td>
                                <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Invoice No.</span></td><td width:20% align="center"><font size="2px;"><?php  echo $invoice_no; ?> </font></td>
                            </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:15px; font-weight:bold">Roll No.</span></td><td width:20% align="center"><font size="2px;"><? echo $installment_display_id; ?></font></td>
                                <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Date</span></td><td width:20% align="center"> <font size="2px;"><?php  $added_date;
											   $timestamp =strtotime($added_date);
											echo $newDate = date('Y-M-d ', $timestamp);
											
						      $date = DateTime::createFromFormat( 'Y-m-d H:i:s', $added_date, new DateTimeZone( 'Asia/Kolkata'));
								$date->format( 'H:i:s');	$added_date; $timestamp =strtotime($added_date);
						        $time_in_12_hour_format  = DATE("h:i:s A", strtotime($added_date));
										echo 	"Time: ".$time_in_12_hour_format."";
											 ?></font></td>
                            </tr>
</table>
                        
                        
                        </td></tr>
                                              
                                              </table>
                                              <table align="center" border="0" width="786" cellpadding="0"style="border-left:solid #999 1px; border-right:solid #999 1px; ">
                                              <tr>
                                              	<td></td><td></td>
                                              </tr>
                                              <tr>
                                          <td width="" height="10" style="padding-left:20px; font-size:13px;">Center Name</td><td width="" height="10" style="font-size:13px;" ><?php echo $_SESSION['branch_name']; ?> </td>
                                              </tr>
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px; font-size:13px;" >Name Of the Student</td><td width="" height="10" style="font-size:13px;"> <?php echo $row_record['name']; ?> </td>
                                              </td>
                                              	<td width="" rowspan="3" align="center" valign="middle" style="font-weight:bold;">
                                                <? 
													if($data_bill_master['status']=='paid')
													{
														?>
														<font style="font-size:36px; color:#99CC00">PAID</font>
														<?
                                                    }
													elseif($data_bill_master['status']=='Aborted')
													{
														?>
														<font style="font-size:36px; color:#FFFF00">ABORTED</font>
														<?
													}
													else
													{
														?>
														<font style="font-size:36px; color:#FF0000"><? echo strtoupper($data_bill_master['status']); ?></font>
                                                        <?
													}
												?>
                                                
                                              
                                              </tr>
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px; font-size:13px;">Course Name</td><td width="" height="10" style="font-size:13px;"><?php echo  $val_course['course_name']; ?> </td>
                                              </tr>
                                               <tr>
                                              	<td width="" height="10" style="padding-left:20px; font-size:13px;">Course Fees</td><td width="" height="10" style="font-size:13px;"><?php echo $row_record['course_fees']; ?></td>
                                              </tr>
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px; font-size:13px;">Mobile</td><td width="" height="10" style="font-size:13px;"><?php echo $row_record['contact']; ?> </td>
                                              </tr>
                                              <tr><td colspan="4"> <h3 align="center"><font size="+1">Fees Details</font></h3></td></tr>
                                              </table>
                                            
										<table align="center" border="1px" width="786" cellpadding="0" cellspacing="0"
                                        bgcolor="#EFEFEF" style=" border:1px solid;" >
                                        
                             <tr>
                          		<td width="21%" align="left"  style="padding-left:10px; width:25%"><span style="font-size:15px; font-weight:bold">Course Fees</span></td>
                           		<td width="26%" width:20% align="center"><font size="2px;"><?php echo $row_record['course_fees']; ?></font></td>
                          		
                                <td align="left"  style="padding-left:10px; width:25%"><span style="font-size:15px; font-weight:bold">Service Tax (14%)</span></td>
                                <td width:20% align="center"><font size="2px;"><?php echo $row_record['service_tax']; ?></font></td>
                            </tr>
                           	<tr>
                            	<td align="left"  style="padding-left:10px; width:25%"><span style="font-size:15px; font-weight:bold"> Discount in <? echo $row_record['discount_type']; ?></span></td>
                                <td width:20% align="center"><font size="2px;"><?php echo $row_record['discount'];  ?></font></td>
                                <td width="24%" align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Total Fees (w/o Tax)</span></td>
                            	<td width="29%" width:20% align="center"> <font size="2px;"><?php  echo $row_record['total_fees']; ?></font></td>
                             	
                            </tr>
                            <? $total= $row_record['paid']; ?>
                            <tr>
                            	<td width="24%" align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Discount on Coupon</span></td>
                            	<td width="29%" width:20% align="center"> <font size="2px;"><?php if($row_record['discount_coupon_price']) echo $row_record['discount_coupon_price']; else echo "0"; ?></font></td>
                                <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Down Payment</span></td>
                                <td width:20% align="center"><font size="2px;"><?php  echo  $row_record['down_payment'] ?> </font></td>
                            	
                           		
							</tr>				
                            <tr>
                            	<td align="left"  style="padding-left:10px; width:25%"><span style="font-size:15px; font-weight:bold">Net Fees </span></td>
                                <td width:20% align="center"><font size="2px;"><?php echo $row_record['net_fees']; ?></font></td>
                                <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Balance Fee </span></td>
                                <td width:20% align="center"><font size="2px;"><?php echo $balance_amt; ?></font></td>
							</tr><tr></tr>
                                
								<!--<td align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Balance Fee</span></td>
                                    <td width:20% align="center"><font size="2px;"><?php// echo $balance_amt; ?></font></td>		-->	
                                			<!--<td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Total Amount Paid</span></td>-->
                                            <?php
												//$total=$row_record['paid'];
											?>
                                            
                                        <!--<td width:20%><?php //echo $total; ?></td>-->
                           				
                                        <!--<tr>-->
                            				<!--<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Total Course Fees</span></td>-->
                                            <!--<td width:20%><?php //echo $row_record['course_fees']-$row_record['discount'];?></td>-->
                                			<!--<td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Net Fees</span></td>
                                            <td width:20%><? //echo $row_record['net_fees']; ?></td>-->
                           				<!--</tr>-->
                                          
                                       
       
            </table>
            <table align="center" border="0" width="786" cellpadding="0" style="border-left:solid #999 1px; border-right:solid #999 1px; ">
            <tr height="20px">
            	<td colspan="4" style="padding-left:20px; font-size:13px;"> <span>Amount In Words -: <?php echo convert_number($amount) ?> Only</span></td><td></td>
            </tr>
            </table>
            <table align="center" border="0" width="786" cellpadding="0" style="border-left:solid #999 1px; border-right:solid #999 1px; "><tr><td colspan="4"> <h3 align="center"><font size="+1">Payment Details</font></h3></td></tr></table>
           
            
            <table align="center" border="0" width="786" cellpadding="0" style="border-left:solid #999 1px; border-right:solid #999 1px;  border-bottom:solid #999 1px;">
                                              <tr>
                                              	<td></td><td></td>
                                              </tr>
                                             <!-- <tr>
                                              	<td width="283" height="10" >Mode Of Payment</td><td width="482" height="10" ><?php //echo '<b>'.$data_bill_master['paid_type'].'</b>'; ?> </td>
                                              </tr>-->
                                              
                                              <tr>
                                             	<?php
												$sel_pay_mode="select payment_mode from payment_mode where payment_mode_id='".$data_bill_master['paid_type']."'";
												$ptr_sel_mode=mysql_query($sel_pay_mode);
												$fetch_pay_mode=mysql_fetch_array($ptr_sel_mode);
												
												?>
                                                  <td width="190" class="heading"  style="padding-left:20px; font-size:13px;">Mode Of Payment<span class="orange_font"></span></td>
                                                 <td style=" font-size:13px;"><?php echo $fetch_pay_mode['payment_mode'];?></td>
                                             </tr>
                                               <?php 
												 
												if($fetch_pay_mode['payment_mode']=='cheque')
												{
												?>
                                              <tr>
                                              	<td width="190" height="10" style="padding-left:20px; font-size:13px;">Bank Name: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_bill_master['bank_name']; ?> </td>
                                              <td width="146"></td>
                                              </tr>
                                              <tr>
              <td width="190" height="10" style="padding-left:20px; font-size:13px;">Cheque No: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo  $data_bill_master['cheque_detail']; ?> </td>
                                              </tr>
                                               <tr>
             <td width="190" height="10" style="padding-left:20px; font-size:13px;">Cheque Date: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_bill_master['chaque_date']; ?> </td>
              
</tr>
                                              <!--<tr><td></td></tr>-->
                                               <?php }?>
                                                <?php 
												 
												if($fetch_pay_mode['payment_mode']=='online')
												{
													
													$sele_online_trans="select bank_ref_id, bank_name, paymode, order_id from online_trans_details where order_id='$record_id'";
													$ptr_sel=mysql_query($sele_online_trans);
													$data_online_trans=mysql_fetch_array($ptr_sel);
												?>
                                              <tr>
                                              	<td width="190" height="10" style="padding-left:20px; font-size:13px;">Payment Mode: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_online_trans['paymode']; ?> </td>
                                              <td width="146"></td>
                                              </tr>
                                               <tr>
                                              	<td width="190" height="10" style="padding-left:20px; font-size:13px;">Bank Name: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_online_trans['bank_name']; ?> </td>
                                              <td width="146"></td>
                                              </tr>
                                              <tr>
              <td width="190" height="10" style="padding-left:20px; font-size:13px;">Order ID: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo  $data_online_trans['order_id']; ?> </td>
                                              </tr>
                                               <tr>
             <td width="190" height="10" style="padding-left:20px; font-size:13px;">Bank Reference ID: </td><td width="196" height="10" style=" font-size:13px;" ><?php echo $data_online_trans['bank_ref_id']; ?> </td>
              
</tr>
                                              <!--<tr><td></td></tr>-->
                                               <?php }?>
     <tr><td width="190" class="heading"  style="padding-left:20px; font-size:13px;">Total Amount Paid:</td><td width="242" height="10" style=" font-size:13px;" ><?php echo $amount; ?> </td> </tr>  </table>                                        
            			<?php 
						$sel_inst= "select * from installment_history where invoice_id=".$record_id." ";
						$ptr_query_inst=mysql_query($sel_inst);
						if(mysql_num_rows($ptr_query_inst))
						{
						$i=$data_select['no_of_installment'];
						
						echo '<input type="hidden" name="no_of_installment" value="'.$i.'" id="no_of_installment" />
						<table width="786" align="center" bgcolor="#EFEFEF" border="1px" style="border:1px solid"> <tr><td colspan="4"> <h3 align="center"><font size="+1">Payment Patterns</font></h3></td></tr>  ';
						echo'<tr><td align="center" style=" font-size:15px;"><b>Installments</b></td ><td align="center" style=" font-size:15px;"><b>Installment Amount</b></td><td align="center" style=" font-size:15px;"><b>Installment Date</b></td><td align="center" style=" font-size:15px;"><b>Paid Status</</td></tr>';
					//	echo '<tr></tr>';
						$j=1;
						while($data_inst=mysql_fetch_array($ptr_query_inst))
						{
							 $col_paid ='<font color="#006600">';
							if($data_inst[status] =='not paid')
							$col_paid ='<font color="#FF3333">';
							echo '<input type="hidden" name="course_id" value="'.$data_inst['course_id'].'" id="course_id" />';
							
							echo'<tr><td width="25%" align="center" style=" font-size:15px;"><b>Installment '.$j.'</b></td><td width="25%" align="center"><input type="hidden" name="inst_'.$j.'" id="inst_'.$j.'" value="'.$data_inst['installment_amount'].'"><span id=int_id_'.$j.'><font size="2px;">'.$data_inst['installment_amount'].'</font></span></td><td width="25%" align="center"><input type="hidden" name="inst_date'.$j.'" id="inst_date'.$j.'" value="'.$data_inst['installment_date'].'"><font size="2px;">'.$data_inst['installment_date'].'</font></td>
							<td width="25%" align="center"><font size="2px;">'.$col_paid.$data_inst['status'].'</font></font></td></tr>';
							$j++;
							$i--;
						}
						echo '</table>';
						}
						?>
                        <table align="center" border="0" width="786" cellpadding="0"  style="border-left:solid #999 1px; border-right:solid #999 1px;  border-bottom:solid #999 1px;">
                        <tr height="20px"><td colspan="2"></td></tr>
                        <tr><td width="395" align="left"><b><font size="-1">ISAS Authorised Signature(With Seal)</font></b></td><td width="383" align="right"><b><font size="-1">Student Signature</font></b></td></tr>
                         
                         
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
