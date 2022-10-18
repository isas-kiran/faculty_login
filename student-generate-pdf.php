<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--    <script type="text/javascript">
        jQuery(document).ready( function() {
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
-->    <!-- <link rel="stylesheet" href="../../nursary/css/style.css">-->
    <!--<link rel="stylesheet" href="../../nursary/js/jquery.custom/development-bundle/themes/base/jquery.ui.all.css">-->
    <!--<script src="../../mass_email Excel/waakanadmin/mass_email Excel/waakanadmin/js/jquery.custom/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="../../mass_email Excel/waakanadmin/mass_email Excel/waakanadmin/js/jquery.custom/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="../../mass_email Excel/waakanadmin/mass_email Excel/waakanadmin/js/jquery.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>-->

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
	.left_border{ border-left:solid #999 1px;}
	.right_border{ border-right:solid #999 1px;}
	.right_border1{ border-right:solid #EFEFEF  1px;}
	.top_border{ border-top:solid #999 1px;}
	.bottom_border{ border-bottom:solid #999 1px;}
	</style>
</head>
<body>
<table class="printing" width="100%" cellspacing="0" cellpadding="5px" border="0" style="font-family:Arial, Helvetica, sans-serif; color:#000; font-size:18px;">
    <tr>
        <td valign="top" width="52%">
        <img src="http://isasbeautyschool.com/wp-content/uploads/2015/04/logo.jpg" border="0"/>
        </td>
        <td align="right">
        <table>
        <tr>
        <td>International School of Aesthetics and Spa</td></tr>
<tr><td>1st, 2nd & 3rd Floor, The Greens,</td></tr>
<tr><td>North Main Road, Koregoan Park,</td></tr>
<tr><td>Pune 411001.</td></tr>
<tr><td>Contact No:+91 20 2615 0616, +91 97698 11975, +91 91589 85007.</td></tr>
<tr><td>Email :learn@isasbeautyschool.com, info@isasbeautyschool.com</td></tr>
        </table>
        </td>
    </tr>
</table>
<?php
                               /* if($_REQUEST['year'] !="" && $_REQUEST['month']!="")
                                $pre_to_date=" and month='".$_REQUEST['month']."' and year ='".$_REQUEST['year']."' ";*/
								
                            $sql_transaction=$_SESSION['sql_articles'];
						   //$sql_transaction;
							$ptr_sql_transaction =$db->query($sql_transaction);
							?>
                               <hr />
                               
                              <!-- <--/////////////////////////////////////////////////////////////////////////////////////////////////-->
                              <?php 
							if(mysql_num_rows($ptr_sql_transaction))
							{
					        $i=1;
							$fees=0;
							$discount=0;
							$final_fees=0;
							$net_fees=0;
							$service_tax=0;
							$total_fees=0;
						    
                           while($data_cust=mysql_fetch_array($ptr_sql_transaction))
						    {
								     
										$enroll_id ='';
										$student_id = '';
										$name ='';
										$contact='';
										$mail ='';
										$dob = '';
										$address ='';
										$qualification='';
										
										
										
									if($val_colleges['name']!=' ')
										{
										  $table_name = 'enrollment';	
						                  $select_id ='username';
										}
									else
										{
										$titlePage= 'Student Report';
										$table_name = 'enrollment';	
										$select_id ='username';
										}
										
										//echo $data_cust['name'];
									     $select_firstname = " select username ,contact, mail, dob, address, qualification from $table_name  ";   //where $select_id='".$data_cust['customer_supplier_id']."'
										 $data_select = mysql_fetch_array(mysql_query($select_firstname));
										
					?>
                              
                              
                              <!-- <--/////////////////////////////////////////////////////////////////////////////////////////////////-->
                               
                              <!--   <tr><td height="10" >&nbsp;</td></tr>
                                 <tr><td align="left" style="padding-left:10px;">Invoice Date:<?php /*?><?php echo date("d-m-Y");?><?php */?></td>-->
						    <table align="center" style="border:1px; #000">
                            <tr>
                            <td>
                            <table width="800" align="center" cellspacing="0" cellpadding="0" border="1px">
                                <tr>
                                    <td width="800" valign="top" height="" bgcolor="#FFFFFF">
                                    <h2 style="background-color:#000; color:#FFF; text-align:center;">Student Enrollment Form</h2>
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                
                                <table width="800" border="1px" cellpadding="5px" cellspacing="0px">
                               
                                    <tr align="left" style="padding-left:10px;"  class="bottom_border" width="92">
                                    <td width="400"><b>Addmission Date</b></td><td width="400"><? echo $data_cust['added_date']; ?></td></tr>
                                    <tr><td><b>Invoice No.</b> </td><td width="400"><? echo $data_cust['invoice_no']; ?></td> </tr>
                                    <tr><td><b>Enquiry Date</b></td><td width="400"><? echo $data_cust['inquiry_date']; ?></td></tr>
                                    <tr><td ><b>Student Name</b></td><td width="400"><? echo $data_cust['name']; ?></td></tr>
                                    <tr><td ><b>Contact No.</b></td><td width="400"><? echo $data_cust['contact']; ?></td></tr>
                                    <tr><td ><b>Email Id</b></td><td width="400"><? echo $data_cust['mail']; ?></td></tr>
                                    <tr><td ><b>Qualification</b></td><td width="400"><? echo $data_cust['qualification']; ?></td></tr>
                                    <tr><td ><b>User Name</b></td><td width="400"><? echo $data_cust['username']; ?></td></tr>
                                    <!--<tr><td ><b>Photo</b></td><td width="700"><?php /*?><? echo $data_cust['inquiry_date']; ?><?php */?></td></tr>-->
                                    <tr><td ><b>Address</b></td><td width="400"><? echo $data_cust['address']; ?></td></tr>
                                    <tr><td ><b>Identity card No.</b></td><td width="400"><? echo $data_cust['id_card']; ?></td></tr>
                                    <tr><td ><b>Date Of Birth</b></td><td width="400"><? echo $data_cust['dob']; ?></td></tr>
                                    <tr><td ><b>Source</b></td><td width="400"><? echo $data_cust['source']; ?></td></tr>
                                    <tr><td ><b>Admission remark</b></td><td width="400"><? echo $data_cust['admission_remark']; ?></td></tr>
                                    <tr><td ><b>Select Course</b></td><td width="400"><? echo $data_cust['course']; ?></td></tr>
                                    <tr><td ><b>Select Subject</b></td><td width="400"><? echo $data_cust['subject_id']; ?></td></tr>
                                    <tr><td ><b>Select Batch </b></td><td width="400"><? echo $data_cust['batch_id']; ?></td></tr>
                                    <tr><td ><b>Costomize Courses</b></td><td width="400"><? echo $data_cust['costomize_courses']; ?></td></tr>
                                    <tr><td ><b>Course Fees</b></td><td width="400"><? echo $data_cust['course_fees']; ?></td></tr>
                                    <tr><td ><b>Discount</b></td><td width="400"><? echo $data_cust['discount']; ?></td></tr>
                                    <tr><td ><b>Final Fees</b></td><td width="400"><? echo $data_cust['final_fees']; ?></td></tr>
                                    <tr><td ><b>Net Fees</b></td><td width="400"><? echo $data_cust['net_fees']; ?></td></tr>
                                    <tr><td ><b>Service Tax 14%</b></td><td width="400"><? echo $data_cust['service_tax']; ?></td></tr>
                                    <tr><td ><b>Total Fees</b></td><td width="400"><? echo $data_cust['total_fees']; ?></td></tr>
                                    <tr><td ><b>Number of Installment</b></td><td width="400"><? echo $data_cust['no_of_installment']; ?></td></tr>
                                    <tr><td ><b>Installments </b></td><td width="400"><? echo $data_cust['installments']; ?></td></tr>
                                    <tr><td ><b>Down Payment(Including tax)</b></td><td width="400"><? echo $data_cust['down_payment']; ?></td></tr>
                                    <tr><td ><b>Final Amount</b></td><td width="400"><? echo $data_cust['final_amt']; ?></td></tr>
                              
                             <?php  $i++; 
                               }
						   
						 }?>
                            <?php 
							/*if(mysql_num_rows($ptr_sql_transaction))
							{
					        $i=1;
							$fees=0;
							$discount=0;
							$final_fees=0;
							$net_fees=0;
							$service_tax=0;
							$total_fees=0;
						    
                           while($data_cust=mysql_fetch_array($ptr_sql_transaction))
						    {
								        echo '<td align="center">'.$i. '</td>';
								        echo '<td align="center">';
								        echo date("d-m-Y",strtotime($data_cust['data_time']));
									    echo '</td align="center">';
										
										$enroll_id ='';
										$student_id = '';
										$name ='';
										$contact='';
										$mail ='';
										$dob = '';
										$address ='';
										$qualification='';
										
										
										
									if($val_colleges['name']!=' ')
										{
										  $table_name = 'enrollment';	
						                  $select_id ='username';
										}
									else
										{
										$titlePage= 'Student Report';
										$table_name = 'enrollment';	
										$select_id ='username';
										}
										
										//echo $data_cust['name'];
									    $select_firstname = " select username ,contact, mail, dob, address, qualification from $table_name  ";   //where $select_id='".$data_cust['customer_supplier_id']."'
										$data_select = mysql_fetch_array(mysql_query($select_firstname));
										
										echo '<tr>
										 <td align="right"><i>'.$data_cust['invoice_no'].'</i><br /> </td></tr>';
										
										
										echo '<td align="left" style="padding-left:10px;padding-top:15px;"><i>'.$data_cust['inquiry_date'].'</i><br /> </td>';
										
										/*echo '<td class="textLeft">';
                                        echo $data_cust['product_name']." (".$data_cust['bill_no'].") ";
                                        echo '</td>'; */
										
										/*echo '<td align="left" style="padding-left:10px;padding-top:15px;"><i>'.$data_cust['name'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['contact'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['mail'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['qualification'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['username'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['address'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['id_card'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['dob'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['source'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['admission_remark'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['course'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['subject_id'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['batch_id'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['costomize_courses'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['fees'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['discount'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['final_fees'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['net_fees'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['service_tax'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['total_fees'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['no_of_installment'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['installments'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['down_payment'].'</i><br /> </td>';
										
										echo '<td align="left" style="padding-left:35px;padding-top:15px;"><i>'.$data_cust['final_amt'].'</i><br /> </td>';
										
                                        
                                        echo '</tr>';*/
                                        
										
									  /*if($data_cust['pkg_amt']!='')
                                       {
									    $pkg_amt += $data_cust['pkg_amt'];
                                       }
									    if($data_cust['recd_amt']!='')
									   {
										    $recd_amt += $data_cust['recd_amt'];
									   }
									  	
									  if($data_cust['balance']!='')
                                       {
									    $balance += $data_cust['balance'];
                                       }*/
									                               
									// echo "</tr>";
							//$bgcolor++;
							/*$i++;
						   }
						   
						   }*/
							  ?>
                              
                               <!--<tr class="tr-sub1" style="font-weight:bold;">
                                    <td><b>ToTal</b></td><td></td><td></td><td></td><td> </td><td></td>
                                    <td align="right">
                                    Total Pkg Amt= <?php /*?><? echo $pkg_amt ?><?php */?>
                                    </td>
                                    
                                    <td align="right">
                                    Total Recd Amt=<?php /*?> <? echo $recd_amt ?><?php */?>
                                    </td>
                                    
                                    <td align="right">Balance  = <?php /*?><? echo $balance ?><?php */?></td>-->
                                    <!--<td align="right">-->
									</table>
                                     </td>
                                    </tr>
                             </table>
                             
                             
                             </tr>
                             
                             </td>
                             </tr>
                             </table>
                             
                             <table width="100%" border="0" cellspacing="0" cellpadding="10">
                              <tr>
                                <td align="center">Copyright @ 2013. All rights reserved.</td>
                              </tr>
                            </table>

                             
                            
                                             
<?       						
if($_GET['action']=='print')
{
?>
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
