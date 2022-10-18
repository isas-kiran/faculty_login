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
                        						 
						$sql_record= "SELECT * FROM customer_service where customer_service_id='".$record_id."'";
						$_SESSION['sql_articles']=$sql_record;
						if(mysql_num_rows($db->query($sql_record)))
						$row_record=$db->fetch_array($db->query($sql_record));
						
						$receipt_no= $row_record['customer_service_id'];
						$invoice_no= $row_record['customer_invoice_no'];
					    $customer_id=$row_record['customer_id'];
						$service_date=$row_record['added_date'];
						$admin_id=$row_record['staff_id'];
						$cust_bank_name=$row_record['cust_bank_name'];
						$date=date("Y-m-d H:i:s");
						
						$sel_pay_mode="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";
						$ptr_sel_mode=mysql_query($sel_pay_mode);
						$fetch_pay_mode=mysql_fetch_array($ptr_sel_mode);
						$payment_mode=$fetch_pay_mode['payment_mode'];
						
						$cust_name='';
						$mobile1='';
						$membership='';
						
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
						
						$sel_name="select name from site_setting where admin_id='".$admin_id."'";
						$ptr_name=mysql_query($sel_name);
						$datas_name=mysql_fetch_array($ptr_name);
						
						$staff_name=$datas_name['name'];
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
                    <table align="center" width="100%">
                    	<tr>
                    		<td style="float:right">
							<?php
						 		if($_GET['action'] !='print' )
						 		{
						 		?>
									<a href="job-card-generate.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
									<?php 
								} ?>
                    		</td>
                        </tr>
                    </table>
                    <?php  
						$added_date=date("Y-m-d H:i:s");
						$timestamp =strtotime($service_date);
						$newDate = date('d/m/Y ', $timestamp);
										
						$date = DateTime::createFromFormat( 'Y-m-d H:i:s', $service_date, new DateTimeZone( 'Asia/Kolkata'));
						$date->format( 'H:i:s');	$service_date; $timestamp =strtotime($service_date);
						$time_in_12_hour_format  = DATE("h:i:s A", strtotime($service_date));
						//echo 	"Time: ".$time_in_12_hour_format."";
					?>
					<table width="100%" height="48" border="0" align="center" style="border:solid 0.6mm; border-radius:5px; padding-right:10px">
                        <tr>
                        	<td width="272">
                            <table width="100%">
                                <tr>
                                    <td valign="top" width="97" colspan="2"><img src="images/innocent.png" width="140" height="40" title="Isasbeautyschool "/></td>
                                    <td style="font-size:14px;" colspan="1">Receipt No: <?php echo $receipt_no; ?> <br/> 
                                        Invoice No: <?php echo $invoice_no; ?> <br/> 
                                        Date : <?php echo $newDate." ".$time_in_12_hour_format ; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3">
                                        <table width="99%"><strong><span style="font-size:14px;">
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
											
                                          /* if($_SESSION['type']=='S')
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
                                            }*/
                                            ?>
                                            </span></strong>
                                        </table>
                                    </td>                                    
                                </tr>
                               </table>
                            </td>
                    </tr>
                    <tr>
                       	<td>
                           	<table width="100%" style="border:1px solid black; border-collapse:collapse; font-size:12px" border="1px">
                                <tr>
                                    <td align="center" style="padding-left:10px; width:45%"><span style="font-size:12px; font-weight:bold">Customer Name:</span></td>
                                    <td><?php echo $cust_name;?></td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-left:10px;"><span style="font-size:12px; font-weight:bold">Mobile No:</span></td>
                                    <td><?php echo $mobile1;?></td>
                                </tr>
								<tr>
                                    <td align="center" style="padding-left:10px;"><span style="font-size:12px; font-weight:bold">Book by</span></td>
                                    <td><?php echo $staff_name;?></td>
                                </tr>
                            </table>
                           </td>
                    	</tr>
                         <tr>
                           <td>
                           	<table width="100%" style="border:1px solid black; border-collapse:collapse; font-size:12px" border="1px">
                            	<tr>
                                	<td width="5%" align="center">Sr. No.</td>
                                    <td width="40%" align="center">Service Name  (Price)</td>
                                    <td width="15%" align="center">Time(in min.)</td>
                                    <td width="40%" align="center">Staff</td>
                            	</tr>
                                <tr>
                                	<?php
										$sel_map="select * from customer_service_map where customer_service_id='".$row_record['customer_service_id']."'";
										$ptr_map=mysql_query($sel_map);
										$i=1;
										$total=mysql_num_rows($ptr_map);
										$total_time='';
										$total_price='';
										while($data_service=mysql_fetch_array($ptr_map))
										{
											$sel_ser_name="select service_name from servies where service_id='".$data_service['service_id']."'";
											$ptr_name=mysql_query($sel_ser_name);
											$data_name=mysql_fetch_array($ptr_name);
											
											$sel_name="select name from site_setting where admin_id='".$data_service['admin_id']."'";
											$ptr_names=mysql_query($sel_name);
											$data_names=mysql_fetch_array($ptr_names);
											$total_time +=$data_service['service_time'];
											$total_price +=$data_service['total_price'];
											echo "<td align='center'>".$i."</td>";
											echo "<td align='center'>".$data_name['service_name']."    (Price-".$data_service['total_price'].")"."</td>";
											echo "<td align='center'>".$data_service['service_time']."</td>";
											echo "<td align='center'>".$data_names['name']."</td>";
											
											if($total !=$i)
												echo"</tr>";
											$i++;
										}
									?>
                                </tr>
                                <tr>
                                    <td colspan="4">Total Price:<?php echo $total_price ;?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" rowspan="4"><span style="font-size:12px;"><strong>Bill Amounts in words:  </strong><?php echo convert_number($row_record['total_cost']) ?></span></td>
                                    <?php
                                    $select_tax="select tax_type,tax_value,tax_amount,inventory_id from inventory_tax_map where inventory_id='".$record_id."'";
                                    $query_tax=mysql_query($select_tax);  		?>
                                    <td colspan="2"><span style="font-size:12px;"><?php if($membership=="yes"){ echo "Membership Discounted Price:   ".$row_record['discount_price'].""; } ?></span></td>
                              </tr> 
                              <?php
                              if($row_record['nonmemb_discount'] >0)
                              {
                              ?>
                              <tr>
                                    <td colspan="2"><span style="font-size:12px;">Non-member Discount(<?php echo  $row_record['nonmemb_discount']." ".$row_record['nonmemb_discount_type'];?>):  <?php echo  $row_record['nonmemb_discount_price'];?></span></td>
                              </tr> 
                              <?php 
                              }
                              ?>
                              
                              <?php
							  if($row_record['service_tax'] >0)
							  {
							  ?>
							  <tr>
									<td colspan="4" ><span style="font-size:12px;">Service Tax:</span><span style="font-size:12px;"><?php echo  $row_record['service_tax'];?></span></td>
							  </tr> 
							  <?php
							  }
							  else if($row_record['gst_type']=='m_igst')
							  {
								  ?>
								  <tr>
									<td colspan="4"><span style="font-size:12px;">IGST(<?php echo $row_record['igst_tax_in_percent']; ?>%)</span><span style="font-size:12px;">=<?php echo $row_record['igst_tax'];?></span></td>
								  </tr> 
								  <?php
							  }
							  else
							  { 
								  if($row_record['cgst_tax'] >0 || $row_record['sgst_tax'] >0)
								  {
								  ?>
								  <tr>
										<td colspan="4" ><span style="font-size:12px;">CGST(<?php echo $row_record['cgst_tax_in_percent']; ?>%) + SGST(<?php echo $row_record['sgst_tax_in_percent'] ?>%)</span><span style="font-size:12px;">=<?php echo  $row_record['cgst_tax'] + $row_record['sgst_tax'];?></span></td>
								  </tr> 
								   <?php
								  }
							  }
							  ?>
                             <!-- <tr>
                                    <td colspan="2"><span style="font-size:12px;">Service Tax:  <?php //echo  $row_record['service_tax'];?></span></td>
                              </tr> -->
                              
                              <tr>
                                    <td  align="left" colspan="2"><span style="font-size:12px; font-weight:bold">Bill Amount:<?php echo $row_record['total_cost'];?> /-</span></td>
                                    <!--<td align="center"><span style="font-size:12px; font-weight:bold"><?php //echo $tot_bill_amount?></span></td>-->
                              </tr>  
                              <tr>
                                  <!--<td colspan="4"><span style="font-size:10px;"><b>* I/We here by certify that my/our registration certificate center under : -</b><br/>
                                  The Maharashtra Value Added Tax Act, 2002 is in force in the date on which the sale of goods specified in this TAX INVOICE is made by me/us & that transaction of sale covered by this Tax Invoice has been effected by me/us & it shall be accounted for in the turnover of sales while filling of return & the due tax, if any, payable on the sale has been paid or shall be paid.<br/><br/>
                                  
                                  TIN NO : 567898777<br/>
                                  CST TIN NO : 56788977<br/>
                                  LBT NO : <?php //echo $data_vendor['lbt_no']?><br/><br/>
                                  <b>Delivered by</b>  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Received by</b></span></td>-->
                                  <td colspan="5">
                                    <table width="100%">
                                        <tr>
                                            <span ><td width="54%" style="font-size:12px;"><b>Payment Type:</b></td><td width="46%" style="font-size:12px;"><?php echo $payment_mode; ?></td></span>
                                        </tr>
                                        <?php if($row_record['payment_mode_id'] =="2" ||$row_record['payment_mode_id'] =="3" ||$row_record['payment_mode_id'] =="4"){?>
                                        <tr>
                                            <span ><td style="font-size:12px;"><b>Cust.Bank Name</b></td><td style="font-size:12px;"><?php echo $cust_bank_name; ?></td></span>
                                        </tr>
                                        <!--<tr>
                                            <span ><td style="font-size:12px;"><b>Account No.:</b></td><td style="font-size:12px;"><?php echo $account_no; ?></td></span>
                                        </tr>-->
                                        <?php }?>
                                        <?php if($row_record['payment_mode_id'] =="2" ){
                                            
											$sep=explode("/",$row_record['chaque_date']);
											$date=$sep[0]."-".$sep[1]."-".$sep[2];
                                            ?>
                                        <tr>
                                            <span ><td style="font-size:12px;"><b>Chaque No:</b></td><td style="font-size:12px;"><?php echo $row_record['chaque_no']; ?></td></span>
                                        </tr>
                                        <tr>
                                            <span ><td style="font-size:12px;"><b>Chaque Date:</b></td><td style="font-size:12px;"><?php echo $date; ?></td></span>
                                        </tr>
                                        <?php }?>
                                         <?php if($row_record['payment_mode_id'] =="4" ){?>
                                        <tr>
                                            <span ><td style="font-size:12px;"><b>Credit Card No:</b></td><td style="font-size:12px;"><?php echo $row_record['credit_card_no']; ?></td></span>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                  </td>
                              </tr> 
                                <tr>
                                    <td colspan="4"><span style="font-size:12px;"><strong>Total Time: </strong><?php echo $total_time ;?> Min.</span></td>
                                </tr>
                                <tr>
                                	<td colspan="5"><span style="font-size:12px;"><strong>Status:</strong> &nbsp;<?php echo $row_record['status'];  ?> </span></td>
                                </tr>
                                <tr style="height:70px">
                                	<td align="left" colspan="5" style="vertical-align:top"><b>Extra Service</b></td>
                                </tr>
                                <tr style="height:50px">
                                	<td align="left" colspan="5" style="vertical-align:bottom"><b><font size="-1">ISAS Authorised Signature</font></b></td>
                                </tr>                               
                                <tr style="height:50px">
                                	<td align="left" colspan="5" style="vertical-align:bottom"><b><font size="-1">Customer Signature</font></b></td>
                                </tr>
                            </table>
                           </td>
                            
                    	</tr>
                        
                  	</table>
                  	<!--<table align="center" border="1px"  width="400" cellpadding="0" cellspacing="0" bgcolor="#EFEFEF" style=" border:1px solid;" >
                            <tr>
                            	<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:15px; font-weight:bold">Roll No.</span></td><td width:20% align="center"><font size="2px;"><? echo $installment_display_id; ?></font></td>
                                <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:15px; font-weight:bold">Date</span></td><td width:20% align="center"> <font size="2px;"><?php   /*$added_date;
											  $timestamp =strtotime($added_date);
											echo $newDate = date('Y-M-d ', $timestamp);
											
						      $date = DateTime::createFromFormat( 'Y-m-d H:i:s', $added_date, new DateTimeZone( 'Asia/Kolkata'));
								$date->format( 'H:i:s');	$added_date; $timestamp =strtotime($added_date);
						        $time_in_12_hour_format  = DATE("h:i:s A", strtotime($added_date));
										echo 	"Time: ".$time_in_12_hour_format."";*/
											 ?></font></td>
                            </tr>
					</table>-->
                </td></tr>
          	</table>
            </table>
            <?php
			if($_GET['action']=='print' )
			{
				$update_status="update customer_service set status='Processing' where customer_service_id='".$row_record['customer_service_id']."'";
				$ptr_status=mysql_query($update_status);
			?>
            <script>
			</script>
			<script language="javascript">
			window.print();
			//window.close();
			//setTimeout('window.close();',3000);
			//setTimeout('window.close();',5000);
			</script>
			<?php	
			}							
			?>
			</body>
			</html>
			<?php $db->close();?>
