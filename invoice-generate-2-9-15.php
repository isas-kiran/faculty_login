<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
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
						 
						//$last_recpt_no=" SELECT * FROM `invoice`  ORDER BY `invoice_id` DESC LIMIT 0,1 "; /*where  invoice_id ='".$invoice."'*/
						 //echo $last_recpt_no= "SELECT* from enrollment  where  invoice_no ='".$invoice_no."'";
						  
						 //$last =$db->query($last_recpt_no);
						  //$last_bill=mysql_fetch_array($last); 
						 //echo $enroll=$last_bill['enroll_id'];
						  
						  //$no_of_records=mysql_num_rows($db->query($last_recpt_no));
                           
						   //echo $no_of_records['invoice_id'];
						  
						//echo $last_bill['invoice_id'];
							?>
<table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
                        <tr>
                        <td valign="top" width="185"><img src="http://isasbeautyschool.com/wp-content/uploads/2015/04/logo.jpg"   title="Isasbeautyschool "/></td>
                        <td width="601" align="right" style="padding-right:15px;"><table width="99%">
        <tr>
        <td ><font size="+1"><b>International School of Aesthetics and Spa</b></font></td></tr>
<tr>
  <td>Flat No.1st Floor, The Greens CO-OP housing Society,North Main Road,</td></tr>
<tr>
  <td>Near Sizzling China Restaurant ,Next to Lane No.5 , Koregoan Park , Pune-1</td></tr>
<tr>
  <td>Tel No-:+91 20 2615 0616, +91 97698 11975, +91 91589 85007.</td></tr>
<tr><td>Email :learn@isasbeautyschool.com, info@isasbeautyschool.com</td></tr>
        </table>
        <td valign="top">
        <?php
		 if($_GET['action'] !='print')
		 {
		 ?>
        <a href="invoice-generate.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
        <?php } ?>
        </td>
        </td>
                        </tr>
                        <tr>
                        <td height="10" >&nbsp;</td>
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
                            	<td width="21%" align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Receipt No</span></td><td width="26%" width:20%><?php echo $invoice_no;?></td>
                                <td width="24%" align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Service Tax No.</span></td><td width="29%" width:20%>AADFI5575RSD001 </td>
                          </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Last Receipt No</span></td><td width:20%><?php //if($row_record['no_of_installment']<1) echo ''; else echo $invoice_no; ?>#</td>
                                <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Invoice No.</span></td><td width:20%><?php  echo $invoice_no; ?> </td>
                            </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Roll No</span></td><td width:20%><? echo $installment_display_id; ?></td>
                                <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Date</span></td><td width:20%> <?php  $added_date;
											   $timestamp =strtotime($added_date);
											echo $newDate = date('Y-M-d ', $timestamp);
											
						      $date = DateTime::createFromFormat( 'Y-m-d H:i:s', $added_date, new DateTimeZone( 'Asia/Kolkata'));
								$date->format( 'H:i:s');	$added_date; $timestamp =strtotime($added_date);
						        $time_in_12_hour_format  = DATE("h:i:s A", strtotime($added_date));
										echo 	"Time: ".$time_in_12_hour_format."";
											 ?></td>
                            </tr>
</table>
                        
                        
                        </td></tr>
                                              
                                              </table>
                                              <table align="center" border="0" width="786" cellpadding="0" class="left_border right_border">
                                              <tr>
                                              	<td></td><td></td>
                                              </tr>
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px;">Center Name</td><td width="" height="10" ><?php echo $_SESSION['branch_name']; ?> </td>
                                              </tr>
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px;" >Name Of the Student</td><td width="" height="10" ><?php echo $row_record['name']; ?> </td>
                                              </td>
                                              	<td width="" rowspan="3" align="center" valign="middle" style="color:#99CC00; font-weight:bold;">
                                              <font style="font-size:36px;">PAID</font></td>
                                              </tr>
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px;">Course Name</td><td width="" height="10" ><?php echo  $val_course['course_name']; ?> </td>
                                              </tr>
                                               <tr>
                                              	<td width="" height="10" style="padding-left:20px;">Course Fees</td><td width="" height="10" ><?php echo $row_record['course_fees']; ?> </td>
                                              </tr>
                                              <tr>
                                              	<td width="" height="10" style="padding-left:20px;">Mobile</td><td width="" height="10" ><?php echo $row_record['contact']; ?> </td>
                                              </tr>
                                              <tr><td colspan="4"> <h3 align="center">Fees Details</h3></td></tr>
                                              </table>
                                            
										<table align="center" border="1px" width="786" cellpadding="0" cellspacing="0"
                                        bgcolor="#EFEFEF" style=" border:1px solid;" >
                                        
                             <tr>
                          <td width="21%" align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Course Fees</span></td>
                           <td width="26%" width:20%><?php echo $row_record['course_fees']; ?></td>
                          <td width="24%" align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Total Fees</span></td>
                            <td width="29%" width:20%> <?php  echo $row_record['total_fees']; ?></td>
                            </tr>
                           	<tr>
                            <td align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold"> Discount in <? echo $row_record['discount_type']; ?></span></td>
                                   <td width:20%><?php echo $row_record['discount'];  ?></td>
                             <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Down Payment</span></td>
                                     <td width:20%><?php  echo  $row_record['down_payment'] ?> </td>
                            </tr>
                            <tr>
                            <td align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Net Fees </span></td>
                               <td width:20%><?php echo $row_record['net_fees']; ?></td>
                           <td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Balance Fee</span></td>
                                    <td width:20%><?php echo $row_record['installment_on']; ?><?php//echo $total; ?></td>
								</tr>				
											
                           				
                                  <tr>
                            	<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Service Tax (14%)</span></td>
                                 <td width:20%><?php echo $row_record['service_tax']; ?></td>
											
                                			<!--<td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Total Amount Paid</span></td>-->
                                            <?php
												//$total=$row_record['paid'];
											?>
                                            
                                        <!--<td width:20%><?php //echo $total; ?></td>-->
                           				</tr><tr></tr>
                                        <!--<tr>-->
                            				<!--<td align="left"  style="padding-left:10px; width:20%"><span style="font-size:18px; font-weight:bold">Total Course Fees</span></td>-->
                                            <!--<td width:20%><?php //echo $row_record['course_fees']-$row_record['discount'];?></td>-->
                                			<!--<td align="left"  style="padding-left:10px;width:20%"><span style="font-size:18px; font-weight:bold">Net Fees</span></td>
                                            <td width:20%><? //echo $row_record['net_fees']; ?></td>-->
                           				<!--</tr>-->
                                          
                                        <? $total= $row_record['paid']; ?>
       
            </table>
            <table align="center" border="0" width="786" cellpadding="0" class="left_border right_border">
            <tr height="50px">
            	<td colspan="4" style="padding-left:20px;"> <span>Amount In Words -: <?php echo convert_number($total) ?> Only</span></td><td></td>
            </tr>
            </table>
            <table align="center" border="0" width="786" cellpadding="0" class="left_border right_border"><tr><td colspan="4"> <h3 align="center">Payment Details</h3></td></tr></table>
           
            
            <table align="center" border="0" width="786" cellpadding="0" class="left_border right_border bottom_border">
                                              <tr>
                                              	<td></td><td></td>
                                              </tr>
                                             <!-- <tr>
                                              	<td width="283" height="10" >Mode Of Payment</td><td width="482" height="10" ><?php //echo '<b>'.$data_bill_master['paid_type'].'</b>'; ?> </td>
                                              </tr>-->
                                              
                                              <tr>
                                             
                                                  <td width="20%" class="heading"  style="padding-left:20px;">Mode Of Payment<span class="orange_font">*</span></td>
                                                 <td>
                                                 <?php if($data_bill_master['paid_type']=='cash')
												 { ?>
                                                  <input type="checkbox" class="validate[required] input_radio" name="payment_type" id="payment_type" disabled="disabled" value="cash" onClick="hide();"/ <?php if($data_bill_master['paid_type']=='cash' || $_POST['payment_type']=='cash') echo 'checked="checked"'; ?> > Cash
                                                  
                                                <?php }
												if($data_bill_master['paid_type']=='cheque')
												 {
												?>
                                                   <input type="checkbox" class="validate[required] input_radio" name="payment_type" disabled="disabled"  id="payment_type" value="cheque" onClick="show();" <?php  if($data_bill_master['paid_type']=='cheque'|| $_POST['payment_type']=='cheque') echo 'checked="checked"'; ?> />Cheque
                                                  
                                                   <?php }
												if($data_bill_master['paid_type']=='online')
												 {
												?>
                                                  <input type="checkbox" class="validate[required] input_radio" name="payment_type" disabled="disabled" id="payment_type" value="online" <?php if($data_bill_master['paid_type']=='online'|| $_POST['payment_type']=='online') echo 'checked="checked"'; ?> />Credit Card
                                                 
                                            <?php }?>
                                                  </td>
                                            </tr>
                                              
                                               <?php 
												 
												if( $data_bill_master['paid_type']=='cheque')
												{
												?>
                                              <tr>
                                              	<td width="283" height="10" style="padding-left:20px;">Bank Name: </td><td width="482" height="10" ><?php echo $data_bill_master['bank_name']; ?> </td>
                                              <td width="11"></td>
                                              </tr>
                                              <tr>
              <td width="283" height="10" style="padding-left:20px;">Cheque No: </td><td width="482" height="10" ><?php echo  $data_bill_master['cheque_detail']; ?> </td>
                                              </tr>
                                               <tr>
             <td width="143" height="10" style="padding-left:20px;">Cheque Date: </td><td width="30%" height="10" ><?php echo $data_bill_master['chaque_date']; ?> </td>
              <td width="143" height="10">Amount Paid:</td><td width="241" height="10" ><?php echo $total; ?> </td> 
</tr>
                                              <tr><td></td></tr>
                                               <?php }?>
                                               
    <tr><td colspan="4"> <h3 align="center">Payment Patterns</h3></td></tr>                                  
                                              
              
                           
            			<?php 
						 $sel_inst= "select * from installment where enroll_id=".$enroll_id." ";
						$ptr_query_inst=mysql_query($sel_inst);
						$i=$data_select['no_of_installment'];
						
						echo '<input type="hidden" name="no_of_installment" value="'.$i.'" id="no_of_installment" />
						<table width="786" align="center" bgcolor="#EFEFEF" border="0" style="border:1px solid black">';
						echo'<tr><td align="center"><b>Installments</b></td ><td align="center"><b>Installment Amount</b></td><td align="center"><b>Installment Date</b></td><td align="center"><b>Paid Status</</td></tr>';
					//	echo '<tr></tr>';
						$j=1;
						while($data_inst=mysql_fetch_array($ptr_query_inst))
						{
							 $col_paid ='<font color="#006600">';
							if($data_inst[status] =='not paid')
							$col_paid ='<font color="#FF3333">';
							echo '<input type="hidden" name="course_id" value="'.$data_inst['course_id'].'" id="course_id" />';
							
							echo'<tr><td width="25%" align="center"><b>Installment '.$j.'</b></td><td width="25%" align="center"><input type="hidden" name="inst_'.$j.'" id="inst_'.$j.'" value="'.$data_inst['installment_amount'].'"><span id=int_id_'.$j.'>'.$data_inst['installment_amount'].'</span></td><td width="25%" align="center"><input type="hidden" name="inst_date'.$j.'" id="inst_date'.$j.'" value="'.$data_inst['installment_date'].'">'.$data_inst['installment_date'].'</td>
							<td width="25%" align="center">'.$col_paid.$data_inst['status'].'</font></td></tr>';
							$j++;
							$i--;
						}
						echo '<table>';
						?>
                        <table align="center" border="0" width="786" cellpadding="0" class="left_border right_border bottom_border">
                        <tr height="50px"><td colspan="2"></td></tr>
                        <tr><td width="395" align="left"><b>ISAS Authorised Signature(With Seal)</b></td><td width="383" align="right"><b>Student Signature</b></td></tr>
                         
                         
                         </table>
                         </table>
                       
                                                
            <?php
			if($_GET['action']=='print')
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
